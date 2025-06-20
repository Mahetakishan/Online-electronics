<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\subcategory;
use Illuminate\Support\Facades\Auth;


class categorycontroller extends Controller
{
    public function index()
    {
        $category = category::all();
        return view('commonpages.productview',compact('category'));
        
        
    }

    public function getSubcategories($category_id)
    {
        $subcategories = subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
}
