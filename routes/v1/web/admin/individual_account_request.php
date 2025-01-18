<?php

use App\Http\Controllers\Admin\IndividualAccountRequestController;
use Illuminate\Support\Facades\Route;

Route::resource('individual-account-request', IndividualAccountRequestController::class)
    ->names('individual_account_request')
    ->only(['index', 'create', 'show']);