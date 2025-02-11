<?php

use App\Http\Controllers\Api\SettingController;
use Illuminate\Support\Facades\Route;

Route::post('/setting/value/{key}', [SettingController::class, 'getValue']);