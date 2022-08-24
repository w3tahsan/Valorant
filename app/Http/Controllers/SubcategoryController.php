<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function index(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.index', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function insert(Request $request){
        Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Sub Category Added!');
    }

    function delete($subcategory_id){
        Subcategory::find($subcategory_id)->delete();
        return back();
    }
}
