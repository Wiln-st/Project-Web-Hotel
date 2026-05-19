<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\EmployeeController;
use App\Http\Controllers\Web\NotificationController;
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
    Route::post('admin/rooms/refresh-status', [RoomController::class, 'refreshStatus'])->name('rooms.refreshStatus');
    Route::get('admin/reservation', [ReservationController::class, 'reservation'])->name('reservation');
    Route::get('admin/history', [ReservationController::class, 'history'])->name('reservation.history');
    Route::get('admin/reservation/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('admin/reservation/{reservation}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::get('admin/notifikasi', [NotificationController::class, 'notification'])->name('notifikasi');
    Route::post('admin/notification/{notification}/check-in', [NotificationController::class, 'checkIn'])->name('notification.checkIn');
    Route::post('admin/notification/{notification}/check-out', [NotificationController::class, 'checkOut'])->name('notification.checkOut');
    Route::get('admin/manageemployee', [AdminController::class, 'manageemployee'])->name('manageemployee');
});


//Bisa diakses Employee
Route::middleware('auth', 'role:employee')->group(function () {
    Route::get('employee/rooms', [EmployeeController::class, 'rooms'])->name('employee.rooms');
});

//Bisa diakses semua
Route::middleware('auth')->group(function () {
    Route::get('/history', [ReservationController::class, 'history'])->name('history.index');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::delete('/reservation/{reservation}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
    Route::delete('/notification/clear-all', [NotificationController::class, 'clearAll'])->name('notification.clearAll');
    Route::post('/notification/refresh-status', [NotificationController::class, 'refreshNotification'])->name('notification.refresh');
});
