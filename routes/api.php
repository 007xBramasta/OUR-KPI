<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenilaianController;


// Rute untuk autentikasi
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Rute di bawah ini memerlukan autentikasi
    Route::middleware('auth.jwt')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// Rute untuk penilaian memerlukan autentikasi
Route::middleware('auth.jwt')->group(function () {
    Route::get('/penilaians', [PenilaianController::class, 'get_penilaian']);
    Route::get('/rekomendasi', [RekomendasiController::class, 'index']);
    // Definisikan rute lainnya yang memerlukan autentikasi di sini
});
Route::get('klausul', [PenilaianController::class, 'klausul']);
