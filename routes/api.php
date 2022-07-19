<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetProductsController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Controllers\SaveProductController;
use Illuminate\Support\Facades\Route;

Route::post('register', UserRegisterController::class);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => ['api', 'auth']
], function () {
    Route::group([
        'prefix' => 'products'
    ], function () {
        Route::get('/', GetProductsController::class);
        Route::post('/', SaveProductController::class);
    });
});
