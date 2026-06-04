<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\ArtikelController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\LaporanController; // <-- Tambahan PENTING!
use App\Models\Artikel;
use App\Models\Katalog;

// 1. Rute Publik
Route::get('/', function () { 
    // Ambil 3 artikel dan 3 katalog terbaru dari database
    $artikels = Artikel::latest()->take(3)->get(); 
    $katalogs = Katalog::latest()->take(3)->get(); 

    // Kirim data asli ke file welcome.blade.php
    return view('welcome', compact('artikels', 'katalogs')); 
});

// 2. Rute Guest (Hanya untuk yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login-proses', [AuthController::class, 'loginProses'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register-proses', [AuthController::class, 'registerProses'])->name('register.proses');

    // Rute Lupa Password dipindah ke sini agar lebih aman
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// 3. Rute Auth (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/profil', [AuthController::class, 'showProfil'])->name('profil.show');
    Route::post('/profil/update', [AuthController::class, 'updateProfil'])->name('profil.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/artikel/{id}', [ArtikelController::class, 'show'])->name('artikel.show');

    // ==========================================
    // GRUP ADMIN
    // ==========================================
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
        Route::get('/katalog/edit/{id}', [KatalogController::class, 'edit'])->name('katalog.edit');
        Route::put('/katalog/update/{id}', [KatalogController::class, 'update'])->name('katalog.update');
        Route::delete('/katalog/hapus/{id}', [KatalogController::class, 'destroy'])->name('katalog.destroy');

        Route::get('/pemesanan', [App\Http\Controllers\AdminPemesananController::class, 'index'])->name('pemesanan.index');
        Route::get('/pemesanan/riwayat', [App\Http\Controllers\AdminPemesananController::class, 'riwayat'])->name('pemesanan.riwayat');
        Route::get('/pemesanan/detail/{id}', [App\Http\Controllers\AdminPemesananController::class, 'show'])->name('pemesanan.show');
        
        // Rute untuk mengeksekusi perubahan status
        Route::post('/pemesanan/update-status/{id}', [App\Http\Controllers\AdminPemesananController::class, 'updateStatus'])->name('pemesanan.updateStatus');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

// ==========================================
    // GRUP PELANGGAN
    // ==========================================
    Route::prefix('pelanggan')->name('pelanggan.')->group(function () {
        Route::get('/home', [AuthController::class, 'showDashboard'])->name('home');
        
        // 👇 DUA BARIS INI YANG HARUS DITAMBAHKAN 👇
        Route::get('/artikel', [ArtikelController::class, 'indexPelanggan'])->name('artikel.index');
        Route::get('/katalog', [KatalogController::class, 'indexPelanggan'])->name('katalog.index');
        // 👆 =================================== 👆

        // Rute fitur pemesanan dipindah ke sini dengan rapi
        Route::get('/katalog/{id}', [KatalogController::class, 'showPelanggan'])->name('katalog.show');
        Route::get('/checkout/{id}', [PemesananController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/proses', [PemesananController::class, 'proses'])->name('checkout.proses');
        Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
        
        // Menampilkan Daftar Pemesanan (Aktif)
        Route::get('/pemesanan', [PemesananController::class, 'indexPelanggan'])->name('pemesanan.index');
        // Menampilkan Riwayat Pemesanan (Selesai)
        Route::get('/pemesanan/riwayat/selesai', [PemesananController::class, 'riwayatPelanggan'])->name('pemesanan.riwayat');
    });
});