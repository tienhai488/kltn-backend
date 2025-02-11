<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('setting')->name('setting.')->group(function () {
    Route::get('policy', [SettingController::class, 'policy'])->name('policy');

    Route::post('policy', [SettingController::class, 'updatePolicy']);

    Route::get('terms', [SettingController::class, 'terms'])->name('terms');

    Route::post('terms', [SettingController::class, 'updateTerms']);
});