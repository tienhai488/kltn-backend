<?php

use App\Http\Controllers\Admin\OrganizationAccountRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('account-request')->name('account_request.')->group(function () {
    Route::resource('organization', OrganizationAccountRequestController::class)
        ->names('organization')
        ->only(['index', 'create', 'show']);
});
