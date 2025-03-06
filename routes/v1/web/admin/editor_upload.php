<?php

use App\Http\Controllers\Admin\EditorImageUploadController;
use Illuminate\Support\Facades\Route;

Route::post('/editor-uploads', EditorImageUploadController::class)->name('editor_upload');