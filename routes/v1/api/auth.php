<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});