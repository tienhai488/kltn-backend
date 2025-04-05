<?php

use App\Http\Controllers\Api\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment-method')->group(function () {
    Route::get('/', [PaymentMethodController::class, 'index']);
});
