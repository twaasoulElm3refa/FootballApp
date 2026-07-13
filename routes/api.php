<?php

use App\Http\Controllers\api\admin\leagues\LeagueDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->group(function () {

    // Route::prefix('leagues')->group(function () {
    //         Route::get('/', [LeagueDashboardController::class, 'leagues']);
    //         Route::get('/{id}', [LeagueDashboardController::class, 'getLeague']);
    //         Route::post('/', [LeagueDashboardController::class, 'createLeague']);
    //         Route::put('/{id}', [LeagueDashboardController::class, 'updateLeague']);
    //         Route::delete('/{id}', [LeagueDashboardController::class, 'deleteLeague']);
    //     });

    //     Route::prefix('teams')->group(function () {
    //         Route::get('/', [TeamController::class, 'teams']);
    //         Route::get('/{id}', [TeamDashboardController::class, 'getTeam']);
    //         Route::post('/', [TeamDashboardController::class, 'createTeam']);
    //         Route::put('/{id}', [TeamDashboardController::class, 'updateTeam']);
    //         Route::delete('/{id}', [TeamDashboardController::class, 'deleteTeam']);
    //     });

    //     Route::prefix('fixtures')->group(function () {
    //         Route::get('/', [FixtureDashboardController::class, 'fixtures']);
    //         Route::get('/{id}', [FixtureDashboardController::class, 'getFixture']);
    //         Route::post('/', [FixtureDashboardController::class, 'createFixture']);
    //         Route::put('/{id}', [FixtureDashboardController::class, 'updateFixture']);
    //         Route::delete('/{id}', [FixtureDashboardController::class, 'deleteFixture']);
    // });
});



