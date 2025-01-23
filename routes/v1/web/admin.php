<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->name('admin.')->group(function () {
    include 'admin/dashboard.php';
    include 'admin/role.php';
    include 'admin/user.php';
    include 'admin/department.php';
    include 'admin/category.php';
    include 'admin/contact.php';
    include 'admin/individual_account_request.php';
    include 'admin/organization_account_request.php';
    include 'admin/project.php';
    include 'admin/donation.php';
    include 'admin/volunteer.php';
    include 'admin/editor_upload.php';
});