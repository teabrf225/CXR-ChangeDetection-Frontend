<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;

class ImageUploadController extends Controller
{
    public function index()
    {
        if (session()->has('image1_url') || session()->has('image2_url')) {
            session()->forget(['image1_url', 'image2_url', 'image1_filename', 'image2_filename', 'success']);
        }
        return view('upload');
    }

    public function process(Request $request)
    {
        $request->validate([
            'images' => 'required|array|size:2',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:20480',
        ], [
            'images.size' => 'You must upload exactly 2 images.',
            'images.*.max' => 'Each image must not exceed 20MB.'
        ]);

        if (!$request->hasFile('images')) {
            return back()->with('error', 'Please select images before proceeding.');
        }

        try {
            $files = $request->file('images');

            $hash1 = hash_file('sha256', $files[0]->getRealPath());
            $hash2 = hash_file('sha256', $files[1]->getRealPath());
            if ($hash1 === $hash2) {
                return back()->withInput()->withErrors([
                    'images' => 'The two images provided are identical. Please upload different images for comparison.'
                ]);
            }

            foreach ($files as $index => $file) {
                $data = file_get_contents($file->getRealPath());
                // $mime = $file->getMimeType();
                $base64 = base64_encode($data);

                $num = $index + 1;
                $sessionData["image{$num}_base64"] = $base64;
                // $sessionData["image{$num}_url"] = "data:{$mime};base64,{$base64}";
                $sessionData["image{$num}_filename"] = $file->getClientOriginalName();
            }

            $sessionData['success'] = 'Images verified and processed successfully.';
            return redirect()->route('roi')->with($sessionData);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Processing failed: ' . $e->getMessage());
        }
    }
}
