<?php

use App\Http\Controllers\Member\ProjectController;
use Illuminate\Support\Facades\Route;

Route::resource('project', ProjectController::class);