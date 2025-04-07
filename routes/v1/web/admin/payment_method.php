<?php

use App\Http\Controllers\Admin\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment-method')->name('payment_method.')->group(function () {
    Route::put('toggle-status/{paymentMethod}', [PaymentMethodController::class, 'toggleStatus'])
        ->name('toggle_status');

    Route::get('setting/{paymentMethod}', [PaymentMethodController::class, 'setting'])->name('setting');

    Route::put('setting/{paymentMethod}', [PaymentMethodController::class, 'updateSetting']);
});

Route::resource('payment-method', PaymentMethodController::class)
    ->parameters(['payment-method' => 'paymentMethod'])
    ->names('payment_method');
