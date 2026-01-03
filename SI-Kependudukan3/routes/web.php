<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\OrganisasiMasyarakatController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\LaporanController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Penduduk Routes
    Route::resource('penduduk', PendudukController::class);

    // Kartu Keluarga Routes
    Route::resource('kartu-keluarga', KartuKeluargaController::class);

    // Organisasi Routes
    Route::resource('organisasi', OrganisasiMasyarakatController::class);
    Route::post('organisasi/{id}/anggota', [OrganisasiMasyarakatController::class, 'addAnggota'])->name('organisasi.addAnggota');
    Route::delete('organisasi/{id}/anggota/{nik}', [OrganisasiMasyarakatController::class, 'removeAnggota'])->name('organisasi.removeAnggota');

    // Riwayat Routes
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
