<?php

namespace App\Http\Controllers;

use App\Models\CustomerEmailVerify;
use App\Models\CustomerLogin;
use App\Notifications\CustomerEmailVerifyNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Notification;

class CustomerRegisterController extends Controller
{
    function customer_register(Request $request){
        CustomerLogin::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'created_at'=>Carbon::now(),
        ]);

        $customer = CustomerLogin::where('email', $request->email)->firstOrFail();
        $verified_info = CustomerEmailVerify::where('customer_id', $customer->id)->delete();

        $verified_info = CustomerEmailVerify::create([
            'customer_id'=>$customer->id,
            'token'=>uniqid(),
            'created_at'=>Carbon::now(),
        ]);

        Notification::send($customer, new CustomerEmailVerifyNotification($verified_info));
        
        return back()->with('email_verified', 'We have sent you a verification link at'.$customer->email);
    }

    function customer_register_form(){
        return view('customer_register');
    }
}
