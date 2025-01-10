<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    include 'admin/dashboard.php';
    include 'admin/role.php';
    include 'admin/user.php';
    include 'admin/department.php';
    include 'admin/category.php';
});