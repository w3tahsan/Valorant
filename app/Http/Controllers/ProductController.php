<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductThumbnail;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;

class ProductController extends Controller
{
    function index(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $products = Product::all();
        return view('admin.product.index', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'products'=>$products,
        ]);
    }

    function getCategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str_to_send = '<option>-- Select subcategory --</option>';
        foreach($subcategories as $subcategory){
            $str_to_send .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategory_name.'</option>';
        }
        echo $str_to_send;
    }

    function insert(Request $request){
        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'product_discount'=>$request->discount,
            'after_discount'=>($request->product_price - ($request->product_price*$request->discount/100)),
            'brand'=>$request->brand_name,
            'short_description'=>$request->short_description,
            'long_description'=>$request->description,
            'created_at'=>Carbon::now(),
        ]);

        $product_preview_image = $request->product_preview;
        $product_preview_image_extension = $product_preview_image->getClientOriginalExtension();
        $preview_file_name = $product_id.'.'.$product_preview_image_extension;

        Image::make($product_preview_image)->resize(680,680)->save(public_path('/uploads/product/preview/'.$preview_file_name));

        Product::find($product_id)->update([
            'preview'=>$preview_file_name,
        ]);

        $loop = 1;
        $product_thumbnails_image = $request->product_thumbnails;
        foreach($product_thumbnails_image as $thumbnail){
            $product_thumbnail_image_extension = $thumbnail->getClientOriginalExtension();
            $thumbnail_file_name = $product_id.'-'.$loop.'.'.$product_thumbnail_image_extension;
            Image::make($thumbnail)->resize(680,680)->save(public_path('/uploads/product/thumbnails/'.$thumbnail_file_name));

            ProductThumbnail::insert([
                'product_id'=>$product_id,
                'product_thumbnails'=>$thumbnail_file_name,
                'created_at'=>Carbon::now(),
            ]);

            $loop++;
        }

        return back();

    }

}
