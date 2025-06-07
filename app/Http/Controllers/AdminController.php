<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\cart;
use App\Models\wishlist;
use App\Models\order;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
   public function dashboard()
   {
    return view('admin.dashboard');
   }
   public function loadForm(Request $request)
   {
    $product = product::with('category','subcategory')->get();
     $categories = category::all();
      return view('admin.addproduct',['categories'=>$categories,'product'=>$product]);
   }
   public function add(Request $request)
   {
      $product = new product;
      $product->productname = $request->productname;
      $product->price = $request->price;
      $product->category_id = $request->category_id;
      $product->subcategory_id = $request->subcategory_id;
      $product->quantity = $request->quantity;
      $request->validate([
          'productname' => 'required',
          'price' => 'required',
          'image' => 'required|mimes:jpg,png,jfif|max:1028',
          'category_id' =>'required',
          'subcategory_id' =>'required',
          'quantity' =>'required',

      ],[
          'productname.required' => 'Name is required.',
          'price.required' => 'Price is required.',
          'image.required' => 'The image field is required.',
          'image.max' => 'Maximum 1mb image allowed.',
          'category_id' => 'Select category',
          'subcategory_id' => 'Select subcategory',
          'quantity.required' =>'Please select quantity',

      ]);
      if($request->hasfile('image'))
      {
          $image = $request->file('image');
          $filename = $image->getClientOriginalName();
          $destination = 'storage/productimg/';
          $imagepath = $request->image->move($destination, $filename);
          $product->image = $imagepath;
          
      }
      $product->save();
      return redirect()->route('load')->with('success','create successfully');
   }
   public function view()
   {
      $product = product::paginate(5);
  
      return  view('admin.viewproduct')->with("product",$product);
   }
   public function edit($id)
   {
      $product = product::where('id',$id)->get();
      $category = category::all();
      $subcategory = subcategory::where('category_id',$product[0]['category_id'])->get();
      return view('admin.edituser',['product'=>$product,'category'=>$category,'subcategory'=>$subcategory]);
   }
   public function update(Request $request){
  
       
      $product = product::find($request->id);
      $request->validate([
         'productname' => 'required',
         'price' => 'required',
         'category_id' => 'required',
         'subcategory_id' => 'required',
         'updquantity' => 'required',

     ],[
         'productname.required' => 'Name is required.',
         'price.required' => 'Price is required.',
         'category_id.required' => 'Category is required',
         'subcategory_id.required' => 'Subcategory is required',
         'updquantity.required' => 'Quantity is required.',
     ]);
      if($request->hasfile('image'))
      {
        if ($product->image) {
            $imagePath = public_path($product->image); // Assuming images are stored in public folder
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
           }
          $image = $request->file('image');
          $filename = $image->getClientOriginalName();
          $destination = 'storage/productimg/';
          $imagepath = $request->image->move($destination, $filename);
          $product->image = $imagepath;
          
      }
      $product->update([
          'productname' => $request->productname,
          'price' => $request->price,
          'category_id' => $request->category_id,
          'subcategory_id' => $request->subcategory_id,
          'quantity' => $request->updquantity,
      ]);
      return redirect()->route('ViewProduct')->with('update','updated successfully');
  }
  public function delete(Request $request)
  {
   $product = product::find($request->id);
   if ($product->image) {
    $imagePath = public_path($product->image); // Assuming images are stored in public folder
    if (file_exists($imagePath)) {
        unlink($imagePath); // Delete the image file
    }
   }
   $product->delete();
   return redirect()->route('ViewProduct')->with('delete','product deleted successfully');
  }
  public function loadCatForm()
  {
   return view('admin.addcategory');
  }
  public function addcategory(Request $request)
  {
   $category = new category;
   $category->categoryname = $request->categoryname;
   $request->validate([
      'categoryname' => 'required',
  ],[
      'categoryname.required' => 'Category Name is required.',
  ]);
  $category->save();
  return redirect()->route('ViewCategory')->with('success','create successfully');
  }
  public function viewcategory()
  {
   $category = category::paginate(5);
   return  view('admin.viewcategory')->with("category",$category);
  }
  public function editcat(Request $request)
  {
     $category = category::find($request->id);
     return view('admin.editcategory')->with("category",$category);
  }
  public function updatecat(Request $request){
       
   $category = category::find($request->id);
   $request->validate([
      'categoryname' => 'required',
  ],[
      'categoryname.required' => 'category is required.',
  ]);
   $category->update([
       'categoryname' => $request->categoryname,  
   ]);
   return redirect()->route('ViewCategory')->with('update','updated successfully');
}
  public function deletecat(Request $request)
  {
   $category = category::find($request->id);
   $category->delete();
   return redirect()->route('ViewCategory')->with('delete','category deleted successfully');
  }
  public function loadsubCatForm()
  {
   $category = category::all();
   return view('admin.addsubcategory')->with("category",$category);
  }
  public function addsubcategory(Request $request)
  {
   $subcat = new subcategory;
   $request->validate([
      'category_id' => 'required',
      'subcategoryname' => 'required',
  ],[
      'category_id.required' => 'Select Category.',
      'subcategoryname.required' => 'Sub category is required.',
  ]);
      $subcat->category_id = $request->category_id;
      $subcat->subcategoryname = $request->subcategoryname;
      $subcat->save();
      return redirect()->route('ViewSubCategory')->with('success','create successfully');
  }
  public function viewsubcategory()
  {
   $subcat = subcategory::with('category')->paginate(5);
   return view('admin.viewsubcategory',compact('subcat'));
  }
  public function editsubcat(Request $request)
  {
     $subcat = subcategory::find($request->id);
     $category = category::all();
     return view('admin.editsubcategory',compact('subcat','category'));
  }
  public function updatesubcat(Request $request){
   $subcat = subcategory::find($request->id);
   $request->validate([
      'category_id' => 'required',
      'subcategoryname' => 'required',
  ],[
   'category_id.required' => 'Select Category.',
   'subcategoryname.required' => 'Sub category is required.',
  ]);
   $subcat->update([
       'category_id' => $request->category_id,
       'subcategoryname' => $request->subcategoryname,  
   ]);
   return redirect()->route('ViewSubCategory')->with('update','updated successfully');
}
  public function deletesubcat(Request $request)
  { 
//    $subcat = subcategory::find($request->id);
   $subcategory_id = $request->input('delete_user_id');
    $subcategory = subcategory::find($subcategory_id);
    $subcategory->delete();
//    $subcat->delete();
   return redirect()->route('ViewSubCategory')->with('delete','category deleted successfully');
  }
// public function delete(Request $req){
     
//     // $contact = contact::find($req->id);
//     // $contact->delete();
//     $user_id = $req->input('delete_user_id');
//     $contact = contact::find($user_id);
//     $contact->delete();
//     return redirect()->route('index')->with('delete','deleted successfully');
// }


  public function getSubcategories($id) {
    $subcategory = subcategory::where('category_id', $id)->get();
    return response()->json(['subcategory'=>$subcategory]);
}
public function getcartdet() {
   $cart = cart::paginate(5);
   return view('admin.viewcart',compact('cart'));
}
public function search(Request $request)
    {
        $product = product::with('category', 'subcategory')
        ->when($request->search, function($query) use ($request) {
            $query->where('productname', 'like', '%'.$request->search.'%')->orWhere('price','like','%' .$request->search. '%');
        })
        ->paginate(5); 
    //   $data = $request->input('search');
    //   $product = DB::table('products')->where('productname', 'like', '%' . $data . '%')->paginate(5)->setpath('');
    //   $request->validate([
    //     'search' => 'required',
    //      ],[    
    //     'search.required' => 'Please enter keyword for search.',
    //      ]);
      return view('admin.viewproduct',compact('product'));
    }
    public function getwishdet() {
        $wishlist = wishlist::paginate(5);
        return view('admin.viewwishlist',compact('wishlist'));
     }
    public function getodrdet() {
        $order = order::paginate(5);
        return view('admin.vieworders',compact('order'));
     }
    
     
}
