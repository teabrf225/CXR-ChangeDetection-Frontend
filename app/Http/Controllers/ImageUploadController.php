<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function index() {
        if (session()->has('image1_path') || session()->has('image2_path')) {
            $p1 = session('image1_path');
            $p2 = session('image2_path');
            $this->clearStorageFiles([$p1, $p2]);
            session()->forget(['image1_path', 'image2_path', 'image1_url', 'image2_url', 'success']);
        }
        return view('upload');
    }


    public function process(Request $request)
    {
        $request->validate([
            'images' => 'required|array|size:2',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:9216',
        ],[
            'images.size' => 'You must upload exactly 2 images.',
            'images.*.max' => 'Each image must not exceed 9MB.'
        ]);

        if (!$request->hasFile('images')){
            return back()->with('error', 'Please select images before proceeding.');
        }

        $files = $request->file('images');
        $file1 = $files[0];
        $file2 = $files[1];

        $info1 = @getimagesize($file1->getRealPath());
        $info2 = @getimagesize($file2->getRealPath());

        if ($info1 === false || $info2 === false) {
            return back()->with('error', 'One or both of the uploaded images are corrupted or invalid. Please check your files and try again.');
        }

        $hash1 = hash_file('sha256', $file1->getRealPath());
        $hash2 = hash_file('sha256', $file2->getRealPath());

        if ($hash1 === $hash2) {
            return back()->withInput()->withErrors([
                'images' => 'The two images provided are identical. Please upload different images.'
            ]);
        }

        $path1 = null;
        $path2 = null;

        try {
            $path1 = $file1->store('uploads', 'public');
            $path2 = $file2->store('uploads', 'public');

            return redirect()->route('roi')->with([
                'image1_path' => $path1,
                'image2_path' => $path2,
                'image1_url' => asset('storage/' . $path1),
                'image2_url' => asset('storage/' . $path2),
                'success' => 'Images uploaded and verified successfully.'
            ]);

        } catch (\Exception $e) {
            $this->clearStorageFiles(array_filter([$path1, $path2]));
            return back()->withInput()->with('error', 'An error occurred during upload. Please try again.');
        }
    }

    public function clearStorageFiles($paths)
    {
        if (empty($paths)) return;
        
        $filesToDelete = is_array($paths) ? $paths : [$paths];

        foreach ($filesToDelete as $path) {
            if ($path && \Storage::disk('public')->exists($path)) {
                \Storage::disk('public')->delete($path);
            }
        }
    }
}
