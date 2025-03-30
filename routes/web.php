<?php

use App\Acl\Acl;
use App\Http\Controllers\PaymentController;
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
});

// Routes callback VNPay và hiển thị kết quả
Route::prefix('payment')->group(function () {
    Route::get('/return', [PaymentController::class, 'vnpayReturn'])->name('payment.return');
    Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/failed', [PaymentController::class, 'paymentFailed'])->name('payment.failed');
});

Scramble::registerUiRoute('docs', 'docs');
Scramble::registerJsonSpecificationRoute('docs.json', 'docs');