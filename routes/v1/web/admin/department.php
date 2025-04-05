<?php

use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::put('department/{department}/toggle-status', [DepartmentController::class, 'toggleStatus'])
    ->name('department.toggle_status');

Route::resource('department', DepartmentController::class);
