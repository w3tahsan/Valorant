<?php

namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Models\Order;
use App\Models\BillingDetails;
use App\Models\OrderProductDetails;
use App\Models\Inventory;
use App\Models\Cart;
use Carbon\Carbon;
use Auth;
   
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->total*100,
                "currency" => "BDT",
                "source" => $request->stripeToken,
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
  
        $data = session('data');

        $order_id = Order::insertGetId([
            'user_id'=>Auth::guard('customerlogin')->id(),
            'discount'=>$data['discount'],
            'delivery_charge'=>$data['delivery_charge'],
            'total'=>$data['total'] - ($data['total']*$data['discount'])/100 + ($data['delivery_charge']),
            'payment_method'=>$data['payment_method'],
            'created_at'=>Carbon::now(),
        ]);

        BillingDetails::insert([
                'order_id'=>$order_id,
                'user_id'=>Auth::guard('customerlogin')->id(),
                'name'=>$data['name'],
                'email'=>$data['email'],
                'company'=>$data['company'],
                'phone'=>$data['phone'],
                'country_id'=>$data['country_id'],
                'city_id'=>$data['city_id'],
                'address'=>$data['address'],
                'notes'=>$data['notes'],
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


        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        foreach($carts as $cart){
            Inventory::where('product_id', $cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            Cart::find($cart->id)->delete();
        }


        return redirect()->route('order.confirmed')->with('order_success', 'Your Order Has Been Successfully Placed!');
    }
    }