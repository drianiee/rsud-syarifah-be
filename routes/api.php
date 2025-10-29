<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\ParkingSettingController;
use App\Http\Controllers\SkmController;

Route::get('/parkir', [ParkirController::class, 'index']);
Route::post('/parkir', [ParkirController::class, 'store']);
Route::delete('/parkir/{parkir}', [ParkirController::class, 'destroy']);

Route::get('/parking-settings', [ParkingSettingController::class, 'show']);
Route::put('/parking-settings', [ParkingSettingController::class, 'update']);
Route::get('/parkir/export', [ParkirController::class, 'export']);
Route::get('/parkir/totals', [ParkirController::class, 'totals']);

Route::get('/skm', [SkmController::class, 'index']);
Route::post('/skm', [SkmController::class, 'store']);
Route::delete('/skm/{skm}', [SkmController::class, 'destroy']);
