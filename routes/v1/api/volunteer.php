<?php

use App\Http\Controllers\Api\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::prefix('volunteer')->group(function () {
    Route::get('/', [VolunteerController::class, 'index']);

    Route::middleware(['auth:sanctum'])->post('/', [VolunteerController::class, 'store']);
});
