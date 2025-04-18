<?php

use App\Acl\Acl;
use App\Http\Controllers\EditorImageUploadController;
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

    Route::domain(config('app.url'))
        ->group(function () {
            Route::get('/', function () {
                if (auth()->check()) {
                    if (auth()->user()->hasAnyRole([Acl::ROLE_SUPER_ADMIN, Acl::ROLE_ADMIN]) && ! Route::is(['admin.*'])) {
                        return to_route('admin.dashboard.index');
                    } else if (auth()->user()->hasAnyRole([Acl::ROLE_ORGANIZATION, Acl::ROLE_INDIVIDUAL]) && ! Route::is(['member.*'])) {
                        return to_route('member.dashboard.index');
                    }

                    auth()->logout();
                }

                return to_route('auth.login.show_form');
            });
        });

    Route::prefix('payment-method')->name('payment_method.')->group(function () {
        Route::prefix('vnpay')->name('vnpay.')->group(function () {
            Route::get('/return', [VNPayController::class, 'return'])->name('return');
        });

        Route::prefix('momo')->name('momo.')->group(function () {
            Route::get('/return', [MomoController::class, 'return'])->name('return');
        });
    });

    Route::post('/editor-uploads', EditorImageUploadController::class)->name('editor_upload');

    // Route::middleware(['auth.admin', 'active', 'check_user_role_redirect', 'role_or_permission:' . Acl::ROLE_SUPER_ADMIN . '|' . Acl::ROLE_ADMIN . '|' . Acl::ROLE_ORGANIZATION . '|' . Acl::ROLE_INDIVIDUAL])->group(function () {
    //     include 'v1/web/admin.php';
    //     include 'v1/web/member.php';
    // });

    Route::domain(config('subdomain.admin') . '.' . config('app.url'))
        ->middleware(['auth.admin', 'active', 'check_user_role_redirect', 'role:' . Acl::ROLE_SUPER_ADMIN . '|' . Acl::ROLE_ADMIN])
        ->group(function () {
            include 'v1/web/admin.php';
        });

    Route::domain(config('subdomain.member') . '.' . config('app.url'))
        ->middleware(['auth.admin', 'active', 'check_user_role_redirect', 'role:' . Acl::ROLE_ORGANIZATION . '|' . Acl::ROLE_INDIVIDUAL])
        ->group(function () {
            include 'v1/web/member.php';
        });
});

Scramble::registerUiRoute('docs', 'docs');
Scramble::registerJsonSpecificationRoute('docs.json', 'docs');