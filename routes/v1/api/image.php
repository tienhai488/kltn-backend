<?php

use App\Http\Controllers\Image\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('image', ImageController::class)->name('load_image');