<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\ReservationController;
use App\Http\Controllers\Web\RoomController;
use Illuminate\Support\Facades\Route;


//Login & Logout
Route::get('/', [AuthWebController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout');


// Hanya bisa diakses Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/rooms', [RoomController::class, 'rooms'])->name('rooms.view');
    Route::post('admin/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::delete('admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::get('admin/reservation', [ReservationController::class, 'reservation'])->name('reservation');
    Route::get('admin/history', [ReservationController::class, 'history'])->name('reservation.history');
    Route::get('admin/reservation/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('admin/reservation/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::get('admin/notifikasi', [AdminController::class, 'notifikasi'])->name('notifikasi');
    Route::get('admin/manageemployee', [AdminController::class, 'manageemployee'])->name('manageemployee');
});


//Bisa diakses Employee
Route::middleware('auth', 'role:employee')->group(function () {
    Route::get('employee/rooms', [EmployeeController::class, 'room'])->name('employee.room');
});

//Bisa diakses semua
Route::middleware('auth')->group(function () {
    Route::get('/history', [ReservationController::class, 'history'])->name('history.index');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::delete('/reservation/{reservation}', [ReservationController::class, 'destroy'])->name('reservation.destroy'); 
});