<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Auth\Register;

Route::get('/', [ChirpController::class, 'index']);

// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/chirps', [ChirpController::class, 'index'])->name('chirps');
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
});

Route::view('/register', 'auth.register')
->middleware('guest')
->name('register');

Route::post('/register', Register::class)
->middleware('guest');


//Login routes
Route::view('/login', 'auth.login')
->middleware('guest')
->name('login');

Route::post('/login', Login::class)
->middleware('guest');

Route::post('/logout', Logout::class)
->middleware('auth')
->name('logout');