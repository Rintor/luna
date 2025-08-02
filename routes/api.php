<?php

use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Route;

Route::prefix('organizations')->group(function () {
    Route::get('/building/{buildingId}', [OrganizationController::class, 'byBuilding']);
    Route::get('/activity/{activityId}', [OrganizationController::class, 'byActivity']);
    Route::get('/radius', [OrganizationController::class, 'byRadius']);
    Route::get('/rectangle', [OrganizationController::class, 'byRectangle']);
    Route::get('/{id}', [OrganizationController::class, 'show']);
    Route::get('/search/activity', [OrganizationController::class, 'searchByActivity']);
    Route::get('/search/name/{name}', [OrganizationController::class, 'searchByName']);
});

Route::get('/buildings', [BuildingController::class, 'index']);