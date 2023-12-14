<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
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


    // admin after login
    public function admin(){
        return view('admin.home');
    }

    // Admin custom logout
    public function logout(){
        Auth::logout();

         $notifications = array('messege'=>'You are logout', 'alert-type'=>'success');

        return redirect()->route('admin.login')->with($notifications);
    }

}
