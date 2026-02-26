<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ROIController extends Controller
{
    public function index()
    {
        if (!session()->has('image1_base64') || !session()->has('image2_base64')) {
            return redirect()->route('upload-image.form')
                ->with('error', 'Please upload images first.');
        }
        session()->reflash();

        return view('roi');
    }
}
