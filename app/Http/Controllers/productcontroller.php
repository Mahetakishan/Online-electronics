<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\category;
use App\Models\cart;
use App\Models\wishlist;
use App\Models\order;
use App\Models\country;
use App\Models\state;
use App\Models\city;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class productcontroller extends Controller
{
    public function index()
    {
        $category = category::all();
        return view('commonpages.productview',compact('category'));
        // return response()->json($categories);
        
    }
    public function getProductsBySubcategory($subcategory_id)
    {
        // $products = product::where('subcategory_id', $subcategory_id)->get();
        $products = product::where('subcategory_id', $subcategory_id)
        ->with('subcategory:id,subcategoryname') // Ensure correct syntax for eager loading
                ->get();
                //  $user_id = auth()->user();

                if(auth()->check()){
                foreach ($products as $product) {
                    $product->inWishlist = wishlist::where('product_id', $product->id)
                    ->where('user_id', auth()->user()->id)
                    ->exists();
                }
                }



        return response()->json($products);
    }

    public function getProductsByCategory($category_id)
    {
        // $products = product::whereHas('subcategory', function ($query) use ($category_id) {
        //     $query->where('category_id', $category_id);
        //      // Ensure correct syntax for eager loading
        $products = product::where('category_id', $category_id)
        ->with('subcategory:id,subcategoryname') // Ensure correct syntax for eager loading
                
        ->get();
        
        // $user_id = auth()->user();
        if(auth()->check()){
                foreach ($products as $product) {
                    $product->inWishlist = wishlist::where('product_id', $product->id)
                    ->where('user_id', auth()->user()->id)
                    ->exists();
                }
            }
        // foreach ($products as $product) {
        //     $product->inWishlist = wishlist::where('product_id', $product->id)
            
        //     ->exists();
        // }


        return response()->json($products);
    }

    public function getAllProducts()
    {
       
        $products = product::with('subcategory:id,subcategoryname')->get();

        // $user_id = auth()->user();
                if(auth()->check()){
                foreach ($products as $product) {
                    $product->inWishlist = wishlist::where('product_id', $product->id)
                    ->where('user_id', auth()->user()->id)
                    ->exists();
                }
            }


        
        return response()->json($products);
    }
    public function Loadcart($id) 
    {
        if (!auth()->check()) {
            return redirect()->route('loadlogin')->with('error','Login first to add to cart');
        }
        $cart = product::where('id',$id)->get();
        // dd($cart);
        return view('user.addtocart',compact('cart'));
    }
    public function addtocart($id,Request $request)
    {
       $product = product::findorFail($id);
       $availableQuantity = $product->quantity;

       $validatedData = $request->validate([
           'quantity' => 'required|integer|min:1|max:'.$availableQuantity,
       ], [
           'quantity.max' => 'Available stock is '.$availableQuantity.' only.',
       ]);
       $total = $product->price * $request->quantity;
      
       $cartItem = cart::where('product_id', $id)
                    ->where('user_id', auth()->id()) // Assuming you have user authentication
                    ->first();

                    if ($cartItem) {
                        // If product already exists in cart, increment quantity
                        
                        $cartItem->quantity += $request->quantity;
                        $cartItem->total += $total;
                        $cartItem->save();
                    } else {
                        // Otherwise, create a new cart item for the product
                        $cartItem = new cart();
                        $cartItem->product_id = $product->id;
                        $cartItem->user_id = auth()->id(); // Assuming you have user authentication

                        $cartItem->quantity = $request->quantity;
                         $cartItem->total = $total;
                         $cartItem->save();
                    }
                
                    // Optionally, you can redirect back to the previous page or cart page
                    return redirect()->route('Loadcart',['id' => $product->id])->with('success', 'Product added to cart successfully.');
   
    }
    public function viewcart()
    {
      
        $user = Auth::id();
        $cart = cart::where('user_id', $user)->with('product')->get();
        
        return view('commonpages.cartview',compact('cart'));
    }
   
    public function deletecart(Request $request)
    {
        $cart_id = $request->input('delete_user_id');
        $cart = cart::find($cart_id);
        $cart->delete();
       return redirect()->route('viewcart')->with('delete','Item deleted successfully');
        // $cart = cart::find($request->id);
        // $cart->delete();
        // return redirect()->route('viewcart')->with('success','Deleted from cart');
    }
    public function deletewishlist(Request $request)
    {
        $wishlist_id = $request->input('delete_user_id');
        $wishlist = wishlist::find($wishlist_id);
        $wishlist->delete();
       return redirect()->route('viewwish')->with('delete','Item deleted successfully');
        // $cart = cart::find($request->id);
        // $cart->delete();
        // return redirect()->route('viewcart')->with('success','Deleted from cart');
    }
    public function updateCartItem($id, Request $request)
   {
    $cartItem = cart::findOrFail($id);
    $product = product::findOrFail($cartItem->product_id);
    
    if ($request->input('quantity') > $product->quantity) {
       
        return response()->json(['error' => 'Requested quantity not available'], 400);
        // return redirect()->route('viewcart')->with('error','Quantity is not available.');
    }
    $total = $product->price * $request->input('quantity');
    $cartItem->quantity = $request->input('quantity');
    $cartItem->total = $total;
    $cartItem->save();
    $updatedCartItem = cart::with('product')->findOrFail($id);
    return response()->json([
        'message' => 'Cart item quantity updated successfully',
        'updatedCartItem' => $updatedCartItem,
    ]);
      }
      
      

      public function addWishlist($id)
      {
          if (!auth()->check()) {
              return redirect()->route('loadlogin')->with('error','Login first to add to wishlist');
          }   
          $wishlistItem = new wishlist;
          $wishlistItem->product_id = $id;
          
          $wishlistItem->user_id = auth()->id();
          $wishlistItem->quantity = 1;
          $wishlistItem->save();
          return redirect()->route('allprod')->with('success','product is added in wishlist');
            
          
         
      
      }


    public function removeWishlist($id)
    {
        if (!auth()->check()) {
            return redirect()->route('loadlogin')->with('error','Login first to add to wishlist');
        }   
        $wishlistItem = wishlist::where('product_id', $id)
        ->where('user_id', auth()->id()) // Assuming you have user authentication
        ->first();

       
            // If product already exists in cart, increment quantity
            $wishlistItem->delete();
            return redirect()->route('allprod')->with('error','product is already in wishlist');
        
       
    
    }
    public function viewwishlist()
    {
        $user = Auth::id();
        $wishlist = wishlist::where('user_id', $user)->with('product')->get();
        if ($wishlist->isEmpty()) {
            abort(404, 'Wishlist not found');
        }
        return view('user.wishlistview',compact('wishlist'));
    }
    public function loadorder(Request $request)
    {
    //   $prod = product::where('id',$id)->get();
      $prod = product::find($request->id);
      $cart = cart::where('product_id',$request->id)->get();
      $country = country::all();
    //   dd($cart);
      return  view('user.addorder',compact('prod','cart','country'));
    }
    
    public function placeorder(Request $request, $id){
        $request->validate([
          
               'select_country' => 'required',
               'select_state' => 'required',
               'select_city' => 'required',
               'pincode' => 'required|min:6',
               'mobno' => 'required|numeric|digits:10'
           ],[
            
               'select_country.required' => 'country is required.',
               'select_state.required' => 'state is required.',
               'select_city.required' => 'city is required.',
               'pincode.required' => 'pincode is required.',
               'pincode.min' => '6 digit required',
               'mobno.required' => 'Contact no is required',
               'mobno.digits' => 'Contact number must be exactly 10 digits',
           ]);

           $prod = product::findOrFail($id);

           $newQuantity = $prod->quantity - $request->quantity; 

           
           if ($newQuantity < 0) {
               return redirect()->back()->with('error', 'Not enough quantity available.');
           }
       
          
           $prod->quantity = $newQuantity;
           $prod->save();


        $order = new order;
        $order->product_id = $request->productname;
        $order->user_id =  auth()->id();
        $order->country_id = $request->select_country;
        $order->state_id = $request->select_state;
        $order->city_id = $request->select_city;
        $order->pincode = $request->pincode;
        $order->contactno = $request->mobno;
        $order->quantity = $request->quantity;
        $order->total = $request->total;
       
       
       $order->save();
       return redirect()->route('odrall')->with('success','Order placed');
     }
     public function getStates($country_id)
     {
         $state = state::where('country_id', $country_id)->get();
         return response()->json($state);
     }
     public function getCities($state_id)
     {
         $city = city::where('state_id', $state_id)->get();
         return response()->json($city);
     }
    
     public function viewallodr()
     {
         $user = Auth::id();

        // $order = order::where('user_id', $user)->with('product','country', 'state', 'city')
        // ->select('id','product_id', 'country_id', 'state_id', 'city_id','pincode', DB::raw('SUM(quantity) as total_quantity'))
        // ->groupBy('id','product_id', 'country_id', 'state_id', 'city_id','pincode')
        // ->get();  
        $order = Order::where('user_id', $user)
        ->with('product', 'country', 'state', 'city')
        ->select(
            'id',
            'product_id',
            'country_id',
            'state_id',
            'city_id',
            'pincode',
           
            'status',
            'quantity' // Include quantity to sum in PHP
        )
        ->get();

        $groupedOrders = [];

        // Group orders by the combination of country, state, city, and pincode
        foreach ($order as $order) {
            $addressKey = $order->country_id . '-' . $order->state_id . '-' . $order->city_id . '-' . $order->pincode;
    
            // Check if the address combination already exists in groupedOrders
            if (!isset($groupedOrders[$addressKey])) {
                // Initialize the grouped order with the first order's details
                $groupedOrders[$addressKey] = [
                    'id' => $order->id,  // Store the id of the first order in the group
                    'product' => $order->product,
                    'country' => $order->country,
                    'state' => $order->state,
                    'city' => $order->city,
                    'pincode' => $order->pincode,
                    'status' => $order->status,
                    'total_quantity' => $order->quantity, // Start with the current order's quantity
                ];
            } else {
                // Add the quantities if the address combination already exists
                $groupedOrders[$addressKey]['total_quantity'] += $order->quantity;
            }
        }
    
        // Now $groupedOrders contains orders grouped by address with summed quantities
        // Remove the addressKey from the grouped orders array
        $groupedOrders = array_values($groupedOrders);
        // dd($groupedOrders);
         return view('user.orderview',compact('groupedOrders'));
     }
     public function deleteorder(Request $request)
     {
        $order_id = $request->input('delete_user_id');
        $order = order::find($order_id);
        
        $product_id = $order->product_id;
        $quantity = $order->quantity;


        $product = product::find($product_id);
        $product->quantity += $quantity;
        $product->save();
        
        $order->delete();
       return redirect()->route('odrall')->with('delete','Order cancel successfully');
     }
     public function updatestatus($id)
     {
        $order = order::find($id);
        if ($order) {
         $order->status = 'Delivered';
         $order->save();
         return redirect()->route('Adminorderview')->with('update','Order status updated successfully');
       } 
     }
}
