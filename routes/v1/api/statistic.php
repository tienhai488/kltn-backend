<?php

use App\Http\Controllers\Api\StatisticController;
use Illuminate\Support\Facades\Route;

Route::prefix('statistic')->group(function () {
    Route::get('/', [StatisticController::class, 'index']);
});