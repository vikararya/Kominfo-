<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\DoksubController;
use App\Http\Controllers\VersiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Middleware khusus untuk Super Admin
Route::middleware(['auth', \App\Http\Middleware\RoleMiddleware::class . ':administrator'])->group(function () {
    // Super Admin dapat mengelola pengguna (CRUD User)
    Route::resource('/covers', \App\Http\Controllers\CoverController::class);
    Route::get('versis/create/{cover_id}', [VersiController::class, 'create'])->name('versis.create');
    // Route untuk menyimpan versi baru (POST)
    Route::resource('/dokumentasis', \App\Http\Controllers\DokumentasiController::class);
    Route::post('/dokumentasis/{id}/swap-order', [DokumentasiController::class, 'swapOrder'])->name('dokumentasis.swapOrder');
    Route::post('/dokumentasi/upload-image', [DokumentasiController::class, 'uploadImage'])->name('dokumentasi.uploadImage');
    Route::post('/upload-image', [DoksubController::class, 'uploadImage'])->name('subjudul.uploadImage');
    Route::resource('/subjudul', \App\Http\Controllers\DoksubController::class);
    Route::resource('/kategoris', \App\Http\Controllers\KategoriController::class);
    Route::resource('/versis', \App\Http\Controllers\VersiController::class);
    // Di dalam grup middleware super-admin
    Route::get('/get-versions/{coverId}', [DokumentasiController::class, 'getVersions']);
    Route::get('/versis/{id}/duplicate', [VersiController::class, 'duplicate'])->name('versis.duplicate');
    Route::resource('/admins', \App\Http\Controllers\AdministratorController::class);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/all-covers', [HomeController::class, 'allCovers'])->name('home.all');
Route::get('/home/show/{cover}', [HomeController::class, 'show'])->name('home.show');



require __DIR__ . '/auth.php';
