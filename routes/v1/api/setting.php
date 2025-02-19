<?php

use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/setting/value/{key}', [SettingController::class, 'getValue']);