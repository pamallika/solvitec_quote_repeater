<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ValuteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/registration', [AuthController::class, 'registration']);
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::patch('/user/token', [UserController::class, 'refreshApiKey'])->middleware('auth:api');
    Route::get('/cbr/retranslate', [ValuteController::class, 'retranslate']);
});

