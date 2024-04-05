<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DepartementController;
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
    Route::get('/penilaians/{laporanId}', [PenilaianController::class, 'get_penilaian']);
    Route::patch('/penilaians/{penilaianId}/klausuls/{klausulId}', [PenilaianController::class, 'update_penilaian']);
    Route::get('/rekomendasi', [RekomendasiController::class, 'index']);
    Route::get('/laporan', [LaporanController::class, 'showMonthlyReport']);
    // Definisikan rute lainnya yang memerlukan autentikasi di sini
});
Route::get('/departements', [DepartementController::class, 'get_departement']);
Route::get('klausul', [PenilaianController::class, 'klausul']);
