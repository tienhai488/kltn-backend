<?php

use App\Acl\Acl;
use App\Http\Controllers\PaymentController;
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
    ->name('api.')
    ->group(function () {
        Route::middleware(['auth:sanctum'])->group(function () {
            include('v1/api/user.php');
        });
        include('v1/api/image.php');
        include('v1/api/setting.php');
        include('v1/api/contact.php');
        include('v1/api/project.php');
        include('v1/api/category.php');
        include('v1/api/donation.php');
        include('v1/api/volunteer.php');
        include('v1/api/department.php');
        include('v1/api/statistic.php');
        include('v1/api/auth.php');
        include('v1/api/file_upload.php');
        // Routes cho VNPay
        Route::prefix('payment')->group(function () {
            Route::post('/create-payment', [PaymentController::class, 'createPayment']);
            Route::get('/payment-status', [PaymentController::class, 'getPaymentStatus']);
        });
    });