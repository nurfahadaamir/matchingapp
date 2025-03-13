<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MatchController;

Route::get('/find-match', [MatchController::class, 'findMatch'])->middleware('auth')->name('find.match');
Route::post('/cancel-match', [MatchController::class, 'cancelMatch'])->middleware('auth')->name('cancel.match');

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Show login page
// Show login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/profile', function () {
    return view('auth.profile');
})->middleware('auth')->name('profile');
Route::get('/edit-profile', function () {
    return view('auth.edit-profile');
})->middleware('auth')->name('profile.edit');

Route::put('/profile', [AuthController::class, 'updateProfile'])->middleware('auth')->name('profile.update');



// Handle user login
Route::post('/login', [AuthController::class, 'loginUser'])->name('login.user');
// Show register page
// Show Register Page (GET)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Handle User Registration (POST)
Route::post('/register', [AuthController::class, 'registerUser'])->name('register.user');

// Logout Route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// Google Login
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

