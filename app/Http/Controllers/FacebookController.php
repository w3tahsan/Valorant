<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerLogin;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class FacebookController extends Controller
{
    function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }
    function handleProviderCallback(){
        $user = Socialite::driver('facebook')->stateless()->user();

        if(CustomerLogin::where('email', $user->getEmail())->exists()){
            if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail(), 'password'=>'abc@gmail.com'])){
                return redirect('/');
            }
        }
        else{
            CustomerLogin::insert([
                'name'=>$user->getName(),
                'email'=>$user->getEmail(),
                'password'=>bcrypt('abc@gmail.com'),
                'created_at'=>Carbon::now(),
            ]);
    
            if(Auth::guard('customerlogin')->attempt(['email'=>$user->getEmail(), 'password'=>'abc@gmail.com'])){
                return redirect('/');
            }
        }
    }
}
