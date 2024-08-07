<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HolidayController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [AuthController::class, 'login']);

  Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
  });
});

Route::group(['middleware' => ['auth:sanctum']], function () {
  Route::apiResource('/holidays', HolidayController::class);
  Route::get('/export/holiday/{id}', [HolidayController::class, 'report']);
});
