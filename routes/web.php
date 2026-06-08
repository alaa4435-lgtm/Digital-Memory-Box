<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MemoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/phpinfo', function() {
    phpinfo();
});
Route::middleware('guest')->group(function () {
    Route::get('/login', function() { return view('auth.login'); })->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);
    
    Route::get('/register', function() { return view('auth.register'); })->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
    
    Route::get('/forgot-password', function() { return view('auth.forgot-password'); })->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.email');
    
    Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
    Route::patch('/memories/{memory}/favorite', [MemoryController::class, 'toggleFavorite'])->name('memories.favorite');
    Route::resource('memories', MemoryController::class);
});


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/lang/{lang}', [LanguageController::class, 'switch']);

Route::view('/help-center', 'pages.help-center')->name('help-center');
Route::view('/terms-of-service', 'pages.terms')->name('terms');
Route::view('/privacy-policy', 'pages.privacy')->name('privacy');

