<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use PragmaRX\Google2FA\Google2FA;

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

    public function analyze(Request $request)
    {
        try {
            $google2fa = new Google2FA();
            $otp = $google2fa->getCurrentOtp(config('services.ai.secret'));

            $payload = [
                'image1_base64' => session('image1_base64'),
                'image2_base64' => session('image2_base64'),
                'roi' => $request->input('roi')
            ];

            $response = Http::withHeaders([
                'x-api-key' => $otp,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post(config('services.ai.url'), $payload);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'AI Service Error: ' . ($response->json()['detail'] ?? 'Unknown error')
                ], 502);
            }

            return response()->json($response->json());

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
