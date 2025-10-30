<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\ParkingSettingController;
use App\Http\Controllers\SkmController;
use Illuminate\Support\Facades\Route;

Route::post('/login',  [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    Route::get('/parkir',        [ParkirController::class, 'index']);
    Route::post('/parkir',       [ParkirController::class, 'store']);
    Route::delete('/parkir/{id}',[ParkirController::class, 'destroy']);

    Route::get('/parking-settings',  [ParkingSettingController::class, 'show']);
    Route::put('/parking-settings',  [ParkingSettingController::class, 'update']);

    Route::get('/skm',          [SkmController::class, 'index']);
    Route::post('/skm',         [SkmController::class, 'store']);
    Route::delete('/skm/{skm}', [SkmController::class, 'destroy']);

    Route::get('/parkir/totals', [ParkirController::class, 'totals']);
    // Route::get('/parkir/export', [ParkirController::class, 'export']);
});

Route::get('parkir/export', [ParkirController::class, 'export']);
