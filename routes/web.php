<?php

use App\Acl\Acl;
use App\Http\Controllers\MomoController;
use App\Http\Controllers\VNPayController;
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

    Route::middleware(['auth.admin', 'active', 'role_or_permission:' . Acl::ROLE_SUPER_ADMIN . '|' . Acl::ROLE_ADMIN . '|' . Acl::ROLE_ORGANIZATION . '|' . Acl::ROLE_INDIVIDUAL])->group(function () {
        include 'v1/web/admin.php';
    });

    Route::prefix('payment-method')->name('payment_method.')->group(function () {
        Route::prefix('vnpay')->name('vnpay.')->group(function () {
            Route::get('/return', [VNPayController::class, 'return'])->name('return');
        });

        Route::prefix('momo')->name('momo.')->group(function () {
            Route::get('/return', [MomoController::class, 'return'])->name('return');
        });
    });
});

Scramble::registerUiRoute('docs', 'docs');
Scramble::registerJsonSpecificationRoute('docs.json', 'docs');
