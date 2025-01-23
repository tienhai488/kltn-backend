<?php

use App\Http\Controllers\Admin\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::resource('volunteer', VolunteerController::class);