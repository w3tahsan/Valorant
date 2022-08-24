<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id','!=', Auth::id())->orderBy('name', 'asc')->paginate(5);
        $logged_user = Auth::user()->name;
        $total_user = User::all()->count();

        return view('home',[
            'users'=>$users,
            'logged_user'=>$logged_user,
            'total_user'=>$total_user,
        ]);
    }

    function delete($user_id){
        User::find($user_id)->delete();
        return back();
    }

    function dashboard(){
        return view('layouts.dashboard');
    }

}
