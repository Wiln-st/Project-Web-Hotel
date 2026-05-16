<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\EmployeeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AuthWebController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/rooms', [AdminController::class, 'rooms'])->name('rooms');
    Route::get('admin/reservation', [AdminController::class, 'reservation'])->name('reservation');
    Route::get('admin/history', [AdminController::class, 'history'])->name('history');
    Route::get('admin/manageemployee', [AdminController::class, 'manageemployee'])->name('manageemployee');
    Route::get('admin/notifikasi', [AdminController::class, 'notifikasi'])->name('notifikasi');
});

Route::middleware('auth')->group(function () {
    Route::get('employee/room', [EmployeeController::class, 'room'])->name('employee.room');
});