<?php

use App\Http\Controllers\Admin\ContactController;
use Illuminate\Support\Facades\Route;

Route::resource('contact', ContactController::class)->only(['index', 'show', 'update']);

Route::post('contact/update', [ContactController::class, 'updateMultiple'])->name('contact.update_multiple');