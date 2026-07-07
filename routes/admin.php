<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\api\admin\fixtures\FixtureDashboardController;
use App\Http\Controllers\api\admin\leagues\LeagueDashboardController;
use App\Http\Controllers\api\admin\teams\TeamDashboardController;
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
        Route::get('/active', [UserDashboardController::class, 'userActive']);
        Route::get('/{id}', [UserDashboardController::class, 'getUser']);
        Route::post('/', [UserDashboardController::class, 'createUser']);
        Route::put('/{id}', [UserDashboardController::class, 'updateUser']);
        Route::delete('/{id}', [UserDashboardController::class, 'deleteUser']);
    });

    Route::prefix('leagues')->group(function () {
        Route::get('/', [LeagueDashboardController::class, 'leagues']);
        Route::get('/count', [LeagueDashboardController::class, 'leagueCount']);
        Route::get('/active', [LeagueDashboardController::class, 'leagueActive']);
        Route::get('/{id}', [LeagueDashboardController::class, 'getLeague']);
        Route::post('/', [LeagueDashboardController::class, 'createLeague']);
        Route::put('/{id}', [LeagueDashboardController::class, 'updateLeague']);
        Route::delete('/{id}', [LeagueDashboardController::class, 'deleteLeague']);
    });

    Route::prefix('teams')->group(function () {
        // Route::get('/', [TeamDashboardController::class, 'teams']);
        Route::get('/count', [TeamDashboardController::class, 'teamCount']);
        // Route::get('/{id}', [TeamDashboardController::class, 'getTeam']);
        // Route::post('/', [TeamDashboardController::class, 'createTeam']);
        // Route::put('/{id}', [TeamDashboardController::class, 'updateTeam']);
        // Route::delete('/{id}', [TeamDashboardController::class, 'deleteTeam']);
    });

    Route::prefix('fixtures')->group(function () {
        // Route::get('/', [FixtureDashboardController::class, 'fixtures']);
        Route::get('/count', [FixtureDashboardController::class, 'fixtureCount']);
        Route::get('/live', [FixtureDashboardController::class, 'fixtureLive']);
        Route::get('/finished', [FixtureDashboardController::class, 'fixtureFinished']);
        // Route::get('/{id}', [FixtureDashboardController::class, 'getFixture']);
        // Route::post('/', [FixtureDashboardController::class, 'createFixture']);
        // Route::put('/{id}', [FixtureDashboardController::class, 'updateFixture']);
        // Route::delete('/{id}', [FixtureDashboardController::class, 'deleteFixture']);
    });

});

