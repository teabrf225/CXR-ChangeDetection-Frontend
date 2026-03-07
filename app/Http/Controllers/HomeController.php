<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function index_without_login(){
        if (Auth::check()) {
            return redirect()->route('home');
        }
        else {
            return view('home-with-out-login');
        }
    }
}
