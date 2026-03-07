<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ResultController;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\ROIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index_without_login'])->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // return view('dashboard');
        return redirect('/home');
    })->name('dashboard');

    Route::get('/home', [HomeController::class,'index'])->name('home');

    Route::get('/upload', [ImageUploadController::class, 'index'])->name('upload-image.form');
    Route::post('/upload.process-images', [ImageUploadController::class, 'process'])->name('upload.images.process');

    Route::get('/roi', [ROIController::class, 'index'])->name('roi');

    Route::get('/result', [ResultController::class, 'ShowResult'])->name('result');
    Route::post('/result.show', [ResultController::class, 'ShowResult'])->name('results.show');

    Route::post('/analyze-images', [ROIController::class, 'analyze'])->name('ai.analyze');
    Route::get('/get-api-key', function () {
        try {
            $google2fa = new Google2FA();
            $secret = env('SHARED_SECRET');
            $otp = $google2fa->getCurrentOtp($secret);
            
            return response()->json(['otp' => $otp]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    })->name('get-api-key');
});
