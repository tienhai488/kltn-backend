<?php

use App\Http\Controllers\Admin\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/volunteer/export', [VolunteerController::class, 'export'])->name('volunteer.export');

Route::resource('volunteer', VolunteerController::class);
