<?php

use App\Http\Controllers\Admin\EditorImageUploadController;
use App\Http\Controllers\Image\ImageController;
use Illuminate\Support\Facades\Route;

Route::post('/editor-uploads', EditorImageUploadController::class)->name('editor_upload');

Route::get('image', ImageController::class)->name('load_image');
