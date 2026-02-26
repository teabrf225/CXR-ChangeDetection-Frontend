<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(){
        return view('result');
    }
    public function showResult(Request $request) 
    {
        // here
    }
}
