<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Product;

class InventoryController extends Controller
{
    function color(){
        $colors = Color::all();
        return view('admin.product.add_color',[
            'colors'=>$colors,
        ]);
    }

    function insert(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function size(){
        $sizes = Size::all();
        return view('admin.product.add_size', [
            'sizes'=>$sizes,
        ]);
    }
    function size_insert(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function inventory($product_id){
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        $product_info = Product::find($product_id);
        return view('admin.product.inventory', [
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product_info'=>$product_info,
            'inventories'=>$inventories,
        ]);
    }
    function inventory_insert(Request $request){

        if(Inventory::where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();
        }
        else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back();
        }
    }
}
