<?php

use App\Http\Controllers\Admin\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::resource('payment-method', PaymentMethodController::class)
    ->parameters(['payment-method' => 'paymentMethod'])
    ->names('payment_method');

Route::put('payment-method/toggle-status/{paymentMethod}', [PaymentMethodController::class, 'toggleStatus'])
    ->name('payment_method.toggle_status');
