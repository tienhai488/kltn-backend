<?php

use App\Http\Controllers\Api\FileUploadController;
use Illuminate\Support\Facades\Route;

Route::post('/upload', [FileUploadController::class, 'upload'])->name('file_upload.upload');
Route::delete('/revert', [FileUploadController::class, 'revert'])->name('file_upload.revert');
