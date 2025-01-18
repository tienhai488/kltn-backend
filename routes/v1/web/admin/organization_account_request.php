<?php

use App\Http\Controllers\Admin\OrganizationAccountRequestController;
use Illuminate\Support\Facades\Route;

Route::resource('organization-account-request', OrganizationAccountRequestController::class)
    ->names('organization_account_request')
    ->only(['index', 'create', 'show']);