<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->name('member.')->group(function () {
    include 'member/dashboard.php';
    include 'member/project.php';
    include 'member/donation.php';
    include 'member/volunteer.php';
    include 'member/user.php';
});
