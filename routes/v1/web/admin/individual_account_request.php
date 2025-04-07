<?php

use App\Http\Controllers\Admin\IndividualAccountRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('account-request')->name('account_request.')->group(function () {
    Route::resource('individual', IndividualAccountRequestController::class)
        ->names('individual')
        ->only(['index', 'create', 'show']);
});
