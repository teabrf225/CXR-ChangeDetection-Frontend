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

    private function resizeImageTo640(string $path, string $mimeType): string
    {
        $src = match (strtolower($mimeType)) {
            'image/png'               => imagecreatefrompng($path),
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($path),
            default                   => imagecreatefromjpeg($path),
        };

        if ($src === false) {
            throw new \RuntimeException("GD failed to open image: {$path}");
        }

        $originalW = imagesx($src);
        $originalH = imagesy($src);

        if ($originalW <= 640) {
            ob_start();
            imagejpeg($src, null, 75);
            $jpeg = ob_get_clean();
            imagedestroy($src);
            return $jpeg;
        }

        $targetW = 640;
        $targetH = (int) round($originalH * ($targetW / $originalW));

        $dst = imagecreatetruecolor($targetW, $targetH);
        $white = imagecolorallocate($dst, 255, 255, 255);
        imagefill($dst, 0, 0, $white);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $targetW, $targetH, $originalW, $originalH);

        ob_start();
        imagejpeg($dst, null, 75);
        $jpeg = ob_get_clean();

        imagedestroy($src);
        imagedestroy($dst);

        return $jpeg;
    }
}
