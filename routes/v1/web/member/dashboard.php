<?php

use App\Http\Controllers\Member\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('')->name('dashboard.')->group(function () {
    Route::get('', [DashboardController::class, 'index'])->name('index');
    Route::get('projects', [DashboardController::class, 'projects'])->name('projects');
    Route::get('donations', [DashboardController::class, 'donations'])->name('donations');
    Route::get('volunteers', [DashboardController::class, 'volunteers'])->name('volunteers');
});