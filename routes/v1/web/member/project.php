<?php

use App\Http\Controllers\Member\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/project/{project}/statistic', [ProjectController::class, 'statistic'])
    ->name('project.statistic');

Route::resource('project', ProjectController::class);