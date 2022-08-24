<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\OrderProductDetails;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Arr;

class FrontendController extends Controller

{
    function privacy(){
        echo 'privacy';
    }
    function terms(){
        echo 'terms';
    }

    function index(){
        $best_selling = OrderProductDetails::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('quantity', 'DESC')
        ->havingRaw('sum >= 5')
        ->get();
        $all_products = Product::take(6)->orderBy('id', 'DESC')->get();
        $new_arrival = Product::latest()->take(4)->orderBy('id', 'DESC')->get();
        $all_categories = Category::all();

        $get_recent = json_decode(Cookie::get('recent_view'), true);
        if($get_recent == ''){
            $get_recent = [''];
        }
        else{
            $get_recent = json_decode(Cookie::get('recent_view'), true);
        }
        $after_unique = array_unique($get_recent);
        $recent_view_products = Product::find($after_unique);

        return view('frontend.index', [
            'all_products'=>$all_products,
            'all_categories'=>$all_categories,
            'new_arrival'=>$new_arrival,
            'best_selling'=>$best_selling,
            'recent_view_products'=>$recent_view_products,
        ]);
    }

    function product_details($product_id){

        $review = OrderProductDetails::where('product_id', $product_id)->where('review', '!=', null)->get();
        $product_info = Product::find($product_id);
        $related_product = Product::where('category_id',$product_info->category_id)->where('id', '!=',$product_id)->get();
        $available_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('sum(color_id) as sum,color_id')->get();

        $al = Cookie::get('recent_view');
        if(!$al){
            $al = "[]";
        }
        $all = json_decode($al, true);
        $all = Arr::prepend($all, $product_id);
        $item_data = json_encode($all);
        Cookie::queue('recent_view', $item_data, 1000);

        return view('frontend.product_details', [
            'product_info'=>$product_info,
            'related_product'=>$related_product,
            'available_colors'=>$available_colors,
            'review'=>$review,
        ]);
    }

    function getSize(Request $request){
        $available_sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        $str_to_send  = '<option>Choose A Option</option>';
        foreach($available_sizes as $sizes){
            $str_to_send .='<option value="'.$sizes->size_id.'">'.$sizes->rel_to_size->size_name.'</option>';
        }
        echo $str_to_send;
    }

    function product_review(Request $request, $product_id){
        OrderProductDetails::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $product_id)->first()->update([
            'star'=>$request->star,
            'review'=>$request->review,
        ]);
        return back();
    }


    function shop(Request $request){
        $data = $request->all();
        $all_products = Product::where(function ($q) use ($data){
        if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
            $q->where(function ($q) use ($data){
                $q->where('product_name', 'like', '%'.$data['q'].'%');
                $q->orWhere('short_description', 'like', '%'.$data['q'].'%');
            });
        }
        if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
            $q->where('category_id', $data['category_id']);
        }
        if(!empty($data['category_id']) && $data['category_id'] != '' && $data['category_id'] != 'undefined'){
            $q->where('category_id', $data['category_id']);
        }
        if(!empty($data['amount']) && $data['amount'] != '' && $data['amount'] != 'undefined'){
            $amount = explode('-', $data['amount']);
            $q->whereBetween('after_discount', [$amount[0],$amount[1]]);
        }

        if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
            $q->whereHas('inventories', function ($q) use ($data){
                if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                    $q->whereHas('rel_to_color', function ($q) use ($data){
                        $q->where('colors.id', $data['color_id']);
                    });
                }
                if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                    $q->whereHas('rel_to_size', function ($q) use ($data){
                        $q->where('sizes.id', $data['size_id']);
                    });
                }
            });
        }

        })->get();


        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('frontend.shop', [
            'all_products'=>$all_products,
            'categories'=>$categories,
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

}
