<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->name('member.')->group(function () {
    include 'member/dashboard.php';
});