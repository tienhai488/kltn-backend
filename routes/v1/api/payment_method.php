<?php

use App\Http\Controllers\Api\MomoController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\VNPayController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment-method')->group(function () {
    Route::get('/', [PaymentMethodController::class, 'index']);

    Route::prefix('vnpay')->group(function () {
        Route::post('/create-payment', [VNPayController::class, 'createPayment']);
    });

    Route::prefix('momo')->group(function () {
        Route::post('/create-payment', [MomoController::class, 'createPayment']);
        Route::post('/ipn', [MomoController::class, 'handleIpn'])->name('payment_method.momo.ipn');
    });
});
