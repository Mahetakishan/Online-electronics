<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\category;
use App\Models\subcategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('commonpages.dashboard');
    }
    public function productsByCategory($category_id)
    {
        $category = category::where('id', $category_id)->firstOrFail();
        $products = $category->products()->get();
       
    
        return response()->json($products);
       
    }
    public function getSubcategories($category_id)
    {
        
        $subcategories = subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }

    public function getProducts($subcategory_id)
    {
        $products = product::where('subcategory_id', $subcategory_id)->get();
        return response()->json($products);

      
    }
    public function profileview($id)
    {
        // $id = Auth::user()->id;
        $user = User::findOrFail($id); 
        // $users = User::where('id',$id)->get();
        return response()->json([
            'user' => $user,
        ]);
        // return view('user.userprofile',compact('user'));
    }
}
