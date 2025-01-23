<?php

use App\Http\Controllers\Admin\ProjectController;
use Illuminate\Support\Facades\Route;

Route::resource('project', ProjectController::class);