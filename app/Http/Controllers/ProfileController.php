<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Image;

class ProfileController extends Controller
{
    function profile(){
        return view('admin.profile.profile');
    }
    function name_change(Request $request){
        User::find(Auth::id())->update([
            'name'=>$request->name,
        ]);
        return back()->with('success', 'Name Changed!');

    }

    function password_change(Request $request){
        $request->validate([
            'old_password'=>'required',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(),'confirmed'],
            'password_confirmation'=>'required',
        ],[
            'old_password.required'=>'Puran Password De!',
            'password.required'=>'New Password De!',
            'password_confirmation.required'=>'Abar New Password De!',
            'password.confirmed'=>'2 Password Mile nai ken!',
            'password.min'=>'Password Must be 8 charecters',
        ]);

        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('success', 'Password Changed!');
        }
        else{
            return back()->with('vul_pass', 'Batapari Baad Den, Apni Vua Lok');
        }

    }

    function photo_change(Request $request){
        $profile_photo = $request->profile_photo;
        if(Auth::user()->profile_photo != 'default.png'){
            $path = public_path('uploads/profile/'.Auth::user()->profile_photo);
            unlink($path);

            $extension = $profile_photo->getClientOriginalExtension();
            $profile_photo_name = Auth::id().'.'.$extension;

            Image::make($profile_photo)->save(public_path('/uploads/profile/'.$profile_photo_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$profile_photo_name,
            ]);
            return back()->with('success', 'Profile Photo changed!');
        }
        else{
            $extension = $profile_photo->getClientOriginalExtension();
            $profile_photo_name = Auth::id().'.'.$extension;

            Image::make($profile_photo)->save(public_path('/uploads/profile/'.$profile_photo_name));

            User::find(Auth::id())->update([
                'profile_photo'=>$profile_photo_name,
            ]);
            return back()->with('success', 'Profile Photo changed!');
        }
    }


}
