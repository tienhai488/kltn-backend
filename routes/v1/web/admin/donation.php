<?php

use App\Http\Controllers\Admin\DonationController;
use Illuminate\Support\Facades\Route;

Route::resource('donation', DonationController::class);