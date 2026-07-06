<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\api\admin\users\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum',)->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UserDashboardController::class, 'users']);
        Route::get('/count', [UserDashboardController::class, 'userCount']);
        Route::get('/{id}', [UserDashboardController::class, 'getUser']);
        Route::post('/', [UserDashboardController::class, 'createUser']);
        Route::put('/{id}', [UserDashboardController::class, 'updateUser']);
        Route::delete('/{id}', [UserDashboardController::class, 'deleteUser']);
    });
});


