<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('my-profile', [UserController::class, 'myProfile'])
    ->name('user.my_profile');
Route::put('update-profile', [UserController::class, 'updateProfile'])
    ->name('user.update_profile');
Route::put('update-password', [UserController::class, 'updatePassword'])
    ->name('user.update_password');

Route::resource('user', UserController::class)->except('destroy');