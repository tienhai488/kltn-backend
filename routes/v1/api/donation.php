<?php

use App\Http\Controllers\Api\DonationController;
use Illuminate\Support\Facades\Route;

Route::prefix('donation')->group(function () {
    Route::get('/', [DonationController::class, 'index']);

    Route::post('/', [DonationController::class, 'store']);
});
