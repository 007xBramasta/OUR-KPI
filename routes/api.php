<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\PenilaianController;
use App\Models\Penilaian;

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
    Route::prefix('penilaians')->group(function () {
        Route::get('/', [PenilaianController::class, 'get_penilaian']);
        
        Route::group(['prefix' => '{penilaianId}/klausul-items/{klausulItemId}'], function () {
            Route::patch('/', [PenilaianController::class, 'update_penilaian']);
        
            // Route for update penilaians rekomendasi, setuju 
            Route::middleware('is.admin')->group(function(){
                Route::patch('/rekomendasi', [PenilaianController::class, 'update_rekomendasi']);
                Route::patch('/setuju', [PenilaianController::class, 'update_setuju']);
            });
        });
    });
    Route::get('/laporan/{departementId}', [LaporanController::class, 'showMonthlyReport']);
    // Definisikan rute lainnya yang memerlukan autentikasi di sini

});
Route::get('/departements', [DepartementController::class, 'get_departement']);
Route::get('klausul', [PenilaianController::class, 'klausul']);
Route::get('/departements', [DepartementController::class, 'get_departement']);
