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
    Route::get('/rekomendasi', [PenilaianController::class, 'get_rekomendasi']); 
    Route::prefix('penilaians')->group(function () {
        Route::get('/status-bulan', [PenilaianController::class,'monthlyStatus']);
        Route::get('/', [PenilaianController::class, 'get_penilaian'])->name('user.get.penilaian'); // Rute untuk mendapatkan data =penilaian

        Route::group(['prefix' => '{penilaianId}'], function () {
            Route::patch('/', [PenilaianController::class, 'update_penilaian']); // Rute untuk update penilaian

            // Route for update penilaians rekomendasi, setuju 
            Route::middleware('is.admin')->group(function () {
                Route::patch('/rekomendasi', [PenilaianController::class, 'update_rekomendasi']);
            });
        });
        Route::get('{departementId}', [PenilaianController::class, 'get_penilaian_by_departement'])->middleware('is.admin')->name('admin.get.penilaian');
    });
    Route::patch('/laporan/{laporanId}/setuju', [PenilaianController::class, 'update_setuju'])->middleware('is.admin');
    Route::get('/laporan/{departementId}', [LaporanController::class, 'showMonthlyReport']);
    // Definisikan rute lainnya yang memerlukan autentikasi di sini

});
Route::get('/departements', [DepartementController::class, 'get_departement']);
Route::get('klausul', [PenilaianController::class, 'klausul']);
