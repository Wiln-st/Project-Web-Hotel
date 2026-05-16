<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\RoomController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AuthWebController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');


// Hanya bisa diakses Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/rooms', [AdminController::class, 'index'])->name('rooms.index');
    Route::post('admin/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::delete('admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('admin/reservation', [AdminController::class, 'reservation'])->name('reservation');
    Route::get('admin/history', [AdminController::class, 'history'])->name('history');
    Route::get('admin/manageemployee', [AdminController::class, 'manageemployee'])->name('manageemployee');
    Route::get('admin/notifikasi', [AdminController::class, 'notifikasi'])->name('notifikasi');
});


//Hanya bisa diakses Employee
Route::middleware('auth', 'role:employee')->group(function () {
    Route::get('employee/rooms', [EmployeeController::class, 'room'])->name('employee.room');
});

//Bisa diakses semua
Route::middleware('auth')->group(function () {
    Route::get('rooms', [RoomController::class, 'index']);
});