<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login.user');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
    Route::post('/register', [AuthController::class, 'registerUser'])->name('register.user');

    // Google Login
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout')->middleware('auth');

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/update-eligibility', [ProfileController::class, 'updateEligibility'])->name('update.eligibility');
    Route::get('/available-matches', [MatchController::class, 'showAvailableMatches'])->middleware('auth')->name('available.matches');
    Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->middleware('auth')->name('profile.edit');



    // Match Routes
    Route::get('/lets-match', [MatchController::class, 'showStateSelection'])->name('match.state.selection');
    Route::get('/available-matches', [MatchController::class, 'showAvailableMatches'])->name('available.matches');
    Route::post('/send-match-request/{receiver_id}', [MatchController::class, 'sendMatchRequest'])->name('send.match.request');
    Route::get('/match-requests', [MatchController::class, 'viewMatchRequests'])->name('match.requests');
    Route::post('/accept-match/{sender_id}', [MatchController::class, 'acceptMatch'])->name('accept.match');
    Route::post('/decline-match/{sender_id}', [MatchController::class, 'declineMatch'])->name('decline.match');
    Route::post('/cancel-match', [MatchController::class, 'cancelMatch'])->name('cancel.match');

;



    // Supervisor Form (After Matching)
    Route::get('/match/{match_id}/supervisor', [MatchController::class, 'showSupervisorForm'])->name('match.supervisor.form');
    Route::post('/match/{match_id}/supervisor', [MatchController::class, 'saveSupervisorDetails'])->name('match.supervisor.save');
});
