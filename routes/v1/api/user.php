<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/profile', [UserController::class, 'profile']);

        Route::put('/profile', [UserController::class, 'updateProfile']);

        Route::put('/avatar', [UserController::class, 'updateAvatar']);
    });
});
