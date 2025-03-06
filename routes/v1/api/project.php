<?php

use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('project')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
});