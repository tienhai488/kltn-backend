<?php

use App\Acl\Acl;
use Dedoc\Scramble\Scramble;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    include 'v1/web/auth.php';

    Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
        include 'v1/web/admin.php';
    });
});