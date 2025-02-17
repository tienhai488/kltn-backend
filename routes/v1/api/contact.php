<?php

use App\Http\Controllers\Api\StoreContactController;
use Illuminate\Support\Facades\Route;

Route::post('/contact/store', StoreContactController::class);