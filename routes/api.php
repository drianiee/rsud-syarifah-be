<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\ParkingSettingController;

Route::get('/parkir', [ParkirController::class, 'index']);
Route::post('/parkir', [ParkirController::class, 'store']);
Route::delete('/parkir/{parkir}', [ParkirController::class, 'destroy']);

Route::get('/parking-settings', [ParkingSettingController::class, 'show']);
Route::put('/parking-settings', [ParkingSettingController::class, 'update']);