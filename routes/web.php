<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\RoomController;
use App\Http\Controllers\Web\ReservationController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\EmployeeController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthWebController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthWebController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthWebController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Rooms
        |--------------------------------------------------------------------------
        */

        Route::get('/rooms', [RoomController::class, 'index'])
            ->name('admin.rooms.index');

        Route::post('/rooms', [RoomController::class, 'store'])
            ->name('admin.rooms.store');

        Route::put('/rooms/{room}', [RoomController::class, 'update'])
            ->name('admin.rooms.update');

        Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])
            ->name('admin.rooms.destroy');

        Route::post('/rooms/refresh-status', [RoomController::class, 'refreshStatus'])
            ->name('admin.rooms.refreshStatus');


        /*
        |--------------------------------------------------------------------------
        | Reservations
        |--------------------------------------------------------------------------
        */

        Route::get('/reservations', [ReservationController::class, 'index'])
            ->name('admin.reservations.index');

        Route::post('/reservations', [ReservationController::class, 'store'])
            ->name('admin.reservations.store');

        Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])
            ->name('admin.reservations.edit');

        Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])
            ->name('admin.reservations.update');

        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])
            ->name('admin.reservations.destroy');


        /*
        |--------------------------------------------------------------------------
        | Reservation History
        |--------------------------------------------------------------------------
        */

        Route::get('/reservation-history', [ReservationController::class, 'history'])
            ->name('admin.reservations.history');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/notifications', [NotificationController::class, 'index'])
            ->name('admin.notifications.index');

        Route::post('/notifications/refresh', [NotificationController::class, 'refresh'])
            ->name('admin.notifications.refresh');

        Route::post('/notifications/{notification}/check-in', [NotificationController::class, 'checkIn'])
            ->name('admin.notifications.checkIn');

        Route::post('/notifications/{notification}/check-out', [NotificationController::class, 'checkOut'])
            ->name('admin.notifications.checkOut');

        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
            ->name('admin.notifications.destroy');

        Route::delete('/notifications', [NotificationController::class, 'clearAll'])
            ->name('admin.notifications.clearAll');


        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        Route::get('/employees', [EmployeeController::class, 'index'])
            ->name('admin.employees.index');

        Route::post('/employees', [EmployeeController::class, 'store'])
            ->name('admin.employees.store');

        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
            ->name('admin.employees.update');

        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])
            ->name('admin.employees.destroy');

        Route::post('/employees/refresh-status', [EmployeeController::class, 'refreshStatus'])
            ->name('admin.employees.refreshStatus');
    });


/*
|--------------------------------------------------------------------------
| EMPLOYEE
|--------------------------------------------------------------------------
*/

Route::prefix('employee')
    ->middleware(['auth', 'role:employee'])
    ->group(function () {

        Route::get('/rooms', [EmployeeController::class, 'rooms'])
            ->name('employee.rooms.index');

        Route::put('/rooms/{room}/status', [EmployeeController::class, 'updateRoomStatus'])
            ->name('employee.rooms.updateStatus');
    });