<?php

use App\Http\Controllers\Api\AccountRequestController;
use Illuminate\Support\Facades\Route;

Route::prefix('account-request')->group(function () {
    Route::post('/organization', [AccountRequestController::class, 'organization']);

    Route::post('/individual', [AccountRequestController::class, 'individual']);
});
