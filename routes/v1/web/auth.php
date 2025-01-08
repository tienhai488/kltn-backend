<?php

use App\Events\ResendEmailVerification;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.show-form');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/email/verify', function () {
    if (auth()->user()->hasVerifiedEmail()) {
        return to_route('auth.login');
    }

    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return to_route('auth.login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    event(new ResendEmailVerification($request->user()));

    return back()->with('resent', 'Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn. Vui lòng kiểm tra email trong một vài phút tới.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
