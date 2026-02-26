<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        return view('result');
    }
    public function showResult(Request $request)
    {
        if (!$request->has(['image_source', 'image_target', 'image_changeMap'])) {
            return redirect()->route('upload-image.form')
                ->with('error', 'No analysis results found. Please start a new process.');
        }
        $data = [
            'source' => $request->input('image_source'),
            'target' => $request->input('image_target'),
            'changeMap' => $request->input('image_changeMap'),
        ];

        return view('results', $data);
    }
}
