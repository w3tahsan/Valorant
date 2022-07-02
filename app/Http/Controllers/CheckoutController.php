<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\BillingDetails;
use App\Models\Country;
use App\Models\City;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderProductDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    function checkout(){
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        $sub_total = 0;
        foreach($carts as $cart){
            $sub_total += $cart->product->after_discount * $cart->quantity;
        }

        $countries = Country::all();
        return view('frontend.checkout', [
            'countries'=>$countries,
            'sub_total'=>$sub_total,
        ]);
    }

    function getCity(Request $request){
        $cities = City::where('country_id', $request->country_id)->get();
        $str = '<option value="">Select a City&hellip;</option>';
        foreach($cities as $city){
            $str .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str;
    }

    function order_insert(Request $request){
        if($request->payment_method == 1){
            $order_id = Order::insertGetId([
                'user_id'=>Auth::guard('customerlogin')->id(),
                'discount'=>$request->discount,
                'delivery_charge'=>$request->delivery_charge,
                'total'=>$request->total - ($request->total*$request->discount)/100 + ($request->delivery_charge),
                'payment_method'=>$request->payment_method,
                'created_at'=>Carbon::now(),
            ]);

            BillingDetails::insert([
                'order_id'=>$order_id,
                'user_id'=>Auth::guard('customerlogin')->id(),
                'name'=>$request->name,
                'email'=>$request->email,
                'company'=>$request->company,
                'phone'=>$request->phone,
                'country_id'=>$request->country_id,
                'city_id'=>$request->city_id,
                'address'=>$request->address,
                'notes'=>$request->notes,
                'created_at'=>Carbon::now(),
            ]);

            $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();

            foreach($carts as $cart){
                OrderProductDetails::insert([
                    'order_id'=>$order_id,
                    'product_id'=>$cart->product_id,
                    'product_name'=>$cart->product->product_name,
                    'product_price'=>$cart->product->after_discount,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                    'created_at'=>Carbon::now(),
                ]);
            }

            Mail::to($request->email)->send(new InvoiceMail($order_id));
            $abc_total = $request->total - ($request->total*$request->discount)/100 + ($request->delivery_charge);
            $url = "http://66.45.237.70/api.php";
            $number=$request->phone;
            $text="Thank Your For Purchasing Our Product! Your Total Bill is:".$abc_total;
            $data= array(
            'username'=>"sohely",
            'password'=>"XCGS9ANW",
            'number'=>"$number",
            'message'=>"$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];

            foreach($carts as $cart){
                Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
                // Cart::find($cart->id)->delete();
            }
            return back();
        }

        else if($request->payment_method == 2){
            $data = $request->all();
            return view('exampleHosted', [
                'data'=>$data
            ]);
        }
        else{
            $data = $request->all();
            return view('stripe', [
                'data'=>$data
            ]);
        }


    }

    function order_confirmed(){
        return view('frontend.order_confirm');
    }


}
