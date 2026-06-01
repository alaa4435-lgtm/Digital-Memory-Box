<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function() { return view('Authentication.login'); })->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    
    Route::get('/register', function() { return view('Authentication.register'); })->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
    
    Route::get('/forgot-password', function() { return view('Authentication.forgot-password'); })->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
});


Route::get('/auth/google', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);



Route::get('/lang/{locale}', function ($locale) {

    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }

    return back();
});