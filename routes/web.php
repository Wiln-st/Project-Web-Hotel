<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthWebController;



Route::get('/', [AuthWebController::class, 'showlogin'])->name('login');
Route::post('/login', [AuthWebController::class, 'login']);
