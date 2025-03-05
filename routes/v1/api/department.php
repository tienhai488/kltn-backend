<?php

use App\Http\Controllers\Api\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::prefix('department')->group(function () {
    Route::get('/', [DepartmentController::class, 'index']);
});
