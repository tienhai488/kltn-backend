<?php

use App\Acl\Acl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')
    ->middleware(['api'])
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            include('v1/api/setting.php');
        });
        include('v1/api/auth.php');
    })
    ->name('api.');