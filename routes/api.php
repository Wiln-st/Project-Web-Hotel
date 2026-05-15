<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::post('/', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

//ADMIN ONLY

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function() {
        return response()->json(['message' => 'Halo Admin']);
    });
});

//KARYAWAN ONLY

Route::middleware(['auth:sanctum', 'role:karyawan'])->group(function () {
    Route::get('/employee/room', function() {
        return response()->json(['message' => 'Halo Karyawan']);
    });
});