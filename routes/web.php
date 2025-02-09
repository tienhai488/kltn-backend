<?php

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

    Route::middleware('auth')->group(function () {
        include 'v1/web/admin.php';
    });
});

Scramble::registerUiRoute('docs', 'docs');
Scramble::registerJsonSpecificationRoute('docs.json', 'docs');