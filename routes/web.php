<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ArtikelController; 
use App\Http\Controllers\AdminController;
use App\Models\Artikel; 

// 1. Rute Publik
Route::get('/', function () { 
    return redirect()->route('login');
});
Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');

// 2. Rute Guest (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'loginProses'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register-proses', [AuthController::class, 'registerProses'])->name('register.proses');
});

// 3. Rute Auth (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil.show');
    Route::post('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');

    // GRUP ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
        
        // Kelola Pelanggan
        Route::get('/pelanggan', [AdminController::class, 'daftarPelanggan'])->name('pelanggan.index');
        Route::get('/pelanggan/{id}', [AdminController::class, 'detailPelanggan'])->name('pelanggan.show');
        Route::post('/pelanggan/hapus/{id}', [AdminController::class, 'hapusPelanggan'])->name('pelanggan.destroy');
        
        // Kelola Artikel
        Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
        Route::get('/artikel/create', [ArtikelController::class, 'create'])->name('artikel.create');
        Route::post('/artikel/store', [ArtikelController::class, 'store'])->name('artikel.store');
        Route::get('/artikel/edit/{id}', [ArtikelController::class, 'edit'])->name('artikel.edit');
        Route::post('/artikel/update/{id}', [ArtikelController::class, 'update'])->name('artikel.update');  
        Route::delete('artikel/hapus/{id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

        // Kelola Katalog
        Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
        Route::get('/katalog/create', [KatalogController::class, 'create'])->name('katalog.create');
        Route::post('/katalog', [KatalogController::class, 'store'])->name('katalog.store');
        Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
    });

    // GRUP PELANGGAN
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/home', [AuthController::class, 'showDashboard'])->name('home');
    });
});