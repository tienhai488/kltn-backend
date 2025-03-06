<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});