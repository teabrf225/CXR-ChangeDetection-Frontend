<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // return view('dashboard');
        return redirect('/home');
    })->name('dashboard');

    Route::get('/home', function (){
        return view('home');
    })->name('home');

    Route::get('/upload', [ImageUploadController::class, 'index'])->name('upload-image.form');
    Route::post('/upload.process-images', [ImageUploadController::class, 'process'])->name('upload.images.process');

    Route::get('/roi', function (){
        return view('roi');
    })->name('roi');
});
