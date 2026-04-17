<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::get('/dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
Route::post('/login-proses', [AuthController::class, 'loginProses'])->name('login.proses');
Route::get('/', function () { return view('welcome'); })->name('welcome');

Route::post('/login', [AuthController::class, 'loginProses'])->name('login.proses');