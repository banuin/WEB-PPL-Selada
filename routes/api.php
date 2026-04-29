<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/login-api', [AuthController::class, 'loginApi']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/profil-saya', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout-api', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Berhasil logout dan token dihapus']);
    });
});