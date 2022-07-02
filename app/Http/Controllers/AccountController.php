<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Models\CustomerPassReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderProductDetails;
use App\Notifications\PassResetNotification;
use Carbon\Carbon;
use Notification;
use PDF;
use Hash;
use Crypt;

class AccountController extends Controller
{
    function account(){
        $orders = Order::where('user_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.account', [
            'orders'=>$orders,
        ]);
    }
    function customerlogout(Request $request){
        Auth::guard('customerlogin')->logout();
        return redirect()->route('customer.register.form');
    }

    function invoice($invoice_id){
        $billing_info = BillingDetails::where('order_id', $invoice_id)->get();
        $order_info = Order::where('id', $invoice_id)->get();
        $product_info = OrderProductDetails::where('order_id', $invoice_id)->get();
        $data = [
            'billing_info'=>$billing_info,
            'order_info'=>$order_info,
            'product_info'=>$product_info,
        ];
        $pdf = PDF::loadView('frontend.invoice', $data);
        return $pdf->stream('valorant.pdf');
    }


    //password reset
    function password_reset_req(){
        return view('customer_password_reset');
    }

    function password_reset_store(Request $request){
        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $password_reset = CustomerPassReset::where('customer_id', $customer->id)->delete();

        $password_reset = CustomerPassReset::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new PassResetNotification($password_reset));

    }

    function password_reset_req_form($token){
        return view('customer_password_reset_form', compact('token'));
    }
    function pass_update(Request $request){
        $password_reset = CustomerPassReset::where('token', $request->token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($password_reset->customer_id);

        $customer->update([
            'password'=>Hash::make($request->password),
        ]);

        $password_reset = CustomerPassReset::where('customer_id', $customer->id)->delete();

    }

    function customerEmailverify($token){
        $token_check = CustomerEmailVerify::where('token', $token)->firstOrFail();
        $customer = CustomerLogin::findOrFail($token_check->customer_id);

        $customer->update([
            'email_verified_at'=>Carbon::now(),
        ]);
        
        if(Auth::guard('customerlogin')->attempt(['email' => $customer->email, 'password' => Crypt::decryptString($customer->password)])){
            $verified_info = CustomerEmailVerify::where('customer_id', $customer->id)->delete();
            return redirect('/');
        }
        
    }

}
