<?php

use App\Acl\Acl;
use Illuminate\Support\Facades\Route;

Route::prefix('')->group(function () {
    include 'admin/dashboard.php';
    include 'admin/role.php';
    include 'admin/user.php';
});