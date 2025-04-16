<?php

use App\Http\Controllers\Member\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->name('dashboard.')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');
});