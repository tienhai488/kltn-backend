<?php

use App\Http\Controllers\Member\DonationController;
use Illuminate\Support\Facades\Route;

Route::get('/donation/export', [DonationController::class, 'export'])->name('donation.export');

Route::resource('donation', DonationController::class);