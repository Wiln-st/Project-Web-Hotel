<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthWebController;

use App\Http\Controllers\Web\OwnerController;
use App\Http\Controllers\Web\SupervisorController;
use App\Http\Controllers\Web\EmployeeController;

// use App\Http\Controllers\Web\RoomController;
// use App\Http\Controllers\Web\ReservationController;
// use App\Http\Controllers\Web\NotificationController;

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
| OWNER
|--------------------------------------------------------------------------
*/

Route::prefix('owner')
    ->middleware(['auth', 'role:owner'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [OwnerController::class, 'dashboard'])
            ->name('owner.dashboard');

        Route::post('/transactions/store', [OwnerController::class, 'store_transaction'])
            ->name('owner.transactions.store');

        Route::put('/transactions/{transaction}', [OwnerController::class, 'update'])
            ->name('owner.transactions.update');

        Route::delete('/transactions/{transaction}', [OwnerController::class, 'destroy'])
            ->name('owner.transactions.destroy');


        /*
        |--------------------------------------------------------------------------
        | Reservation History
        | Owner hanya melihat histori
        |--------------------------------------------------------------------------
        */

        Route::get('/reservation-history', [OwnerController::class, 'history'])
            ->name('owner.reservations.history');


        /*
        |--------------------------------------------------------------------------
        | Rooms
        | Owner hanya melihat kamar
        |--------------------------------------------------------------------------
        */

        Route::get('/rooms', [OwnerController::class, 'room'])
            ->name('owner.rooms.index');


        /*
        |--------------------------------------------------------------------------
        | Employees & Supervisors
        |--------------------------------------------------------------------------
        */

        Route::get('/manage-employees', [OwnerController::class, 'user'])
            ->name('owner.employees.index');
    });



/*
|--------------------------------------------------------------------------
| SUPERVISOR
|--------------------------------------------------------------------------
*/

Route::prefix('supervisor')
    ->middleware(['auth', 'role:supervisor'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Rooms
        |--------------------------------------------------------------------------
        */

        Route::get('/rooms', [SupervisorController::class, 'room'])
            ->name('supervisor.rooms.index');

        Route::post('/rooms', [SupervisorController::class, 'room_store'])
            ->name('supervisor.rooms.store');

        Route::put('/rooms/{room}', [SupervisorController::class, 'room_update'])
            ->name('supervisor.rooms.update');

        Route::patch('/rooms/{room}/status', [SupervisorController::class, 'updateStatus'])
            ->name('supervisor.rooms.updateStatus');

        Route::delete('/rooms/{room}', [SupervisorController::class, 'room_destroy'])
            ->name('supervisor.rooms.destroy');


        /*
        |--------------------------------------------------------------------------
        | Manage Employees
        |--------------------------------------------------------------------------
        */

        Route::get('/manage-employees', [SupervisorController::class, 'user'])
            ->name('supervisor.employees.index');

        Route::post('/manage-employees', [SupervisorController::class, 'store_user'])
            ->name('supervisor.employees.store');

        // Route::put('/manage-employees/{employee}', [SupervisorController::class, 'update'])
        //     ->name('supervisor.employees.update');

        Route::delete('/manage-employees/{employee}', [SupervisorController::class, 'destroy_user'])
            ->name('supervisor.employees.destroy');


        /*
        |--------------------------------------------------------------------------
        | Reservation History
        | Supervisor bisa melihat & hapus
        |--------------------------------------------------------------------------
        */

        Route::get('/reservation-history', [SupervisorController::class, 'history'])
            ->name('supervisor.reservations.history');

        Route::delete('/reservation-history/{reservation}', [SupervisorController::class, 'destroy_reservation'])
            ->name('supervisor.reservations.destroy');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/notifications', [SupervisorController::class, 'notification'])
            ->name('supervisor.notifications.index');

        Route::post('/notifications/refresh', [SupervisorController::class, 'refresh_notification'])
            ->name('supervisor.notifications.refresh');

        Route::post('/notifications/{notification}/check-in', [SupervisorController::class, 'checkIn_notification'])
            ->name('supervisor.notifications.checkIn');

        Route::post('/notifications/{notification}/check-out', [SupervisorController::class, 'checkOut_notification'])
            ->name('supervisor.notifications.checkOut');

        Route::delete('/notifications/{notification}', [SupervisorController::class, 'destroy_notification'])
            ->name('supervisor.notifications.destroy');

        Route::delete('/notifications/clear-all', [SupervisorController::class, 'clearAll'])
            ->name('supervisor.notifications.clearAll');
    });



/*
|--------------------------------------------------------------------------
| EMPLOYEE
|--------------------------------------------------------------------------
*/

Route::prefix('employee')
    ->middleware(['auth', 'role:employee'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Rooms
        | Employee hanya melihat & set status
        |--------------------------------------------------------------------------
        */

        Route::get('/rooms', [EmployeeController::class, 'room'])
            ->name('employee.rooms.index');


        /*
        |--------------------------------------------------------------------------
        | Reservations
        |--------------------------------------------------------------------------
        */

        Route::get('/reservations', [EmployeeController::class, 'reservation'])
            ->name('employee.reservations.index');

        Route::post('/reservations', [EmployeeController::class, 'store_reservation'])
            ->name('employee.reservations.store');


        /*
        |--------------------------------------------------------------------------
        | Reservation History
        | Employee bisa edit & hapus reservasi
        |--------------------------------------------------------------------------
        */

        Route::get('/reservation-history', [EmployeeController::class, 'history'])
            ->name('employee.reservations.history');

        Route::get('/reservation-history/{reservation}/edit', [EmployeeController::class, 'edit_reservation'])
            ->name('employee.reservations.edit');

        Route::put('/reservation-history/{reservation}', [EmployeeController::class, 'update_reservation'])
            ->name('employee.reservations.update');

        Route::delete('/reservation-history/{reservation}', [EmployeeController::class, 'destroy_reservation'])
            ->name('employee.reservations.destroy');


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        Route::get('/notifications', [EmployeeController::class, 'notification'])
            ->name('employee.notifications.index');

        Route::delete('/notifications/{notification}', [EmployeeController::class, 'destroy_notification'])
            ->name('employee.notifications.destroy');

        Route::post('/notifications/refresh-notification', [EmployeeController::class, 'refresh_notification'])
            ->name('employee.notifications.refresh');

        Route::post('/notifications/{notification}/check-in', [EmployeeController::class, 'checkIn_notification'])
            ->name('employee.notifications.checkIn');

        Route::post('/notifications/{notification}/check-out', [EmployeeController::class, 'checkOut_notification'])
            ->name('employee.notifications.checkOut');

        Route::delete('/notifications/clear-all', [EmployeeController::class, 'clearAll'])
            ->name('employee.notifications.clearAll');
    });
