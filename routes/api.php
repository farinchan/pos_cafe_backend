<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    });

    Route::prefix('business')->group(function () {
        Route::post('/create', [BusinessController::class, 'create'])->middleware('auth:sanctum');
        Route::get('/list', [BusinessController::class, 'index'])->middleware('auth:sanctum');
        Route::get('/{id}', [BusinessController::class, 'show'])->middleware('auth:sanctum');
    });
});
