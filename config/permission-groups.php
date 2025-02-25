<?php

use App\Acl\Acl;

return [
    'Vai trò' => [
        Acl::PERMISSION_ASSIGNEE,
        Acl::PERMISSION_ROLE_LIST,
        Acl::PERMISSION_ROLE_ADD,
        Acl::PERMISSION_ROLE_EDIT,
        Acl::PERMISSION_ROLE_DELETE,
    ],
    'Người dùng' => [
        Acl::PERMISSION_USER_LIST,
        Acl::PERMISSION_USER_ADD,
        Acl::PERMISSION_USER_EDIT,
        Acl::PERMISSION_USER_DELETE,
    ],
    'Phòng ban' => [
        Acl::PERMISSION_DEPARTMENT_LIST,
        Acl::PERMISSION_DEPARTMENT_ADD,
        Acl::PERMISSION_DEPARTMENT_EDIT,
        Acl::PERMISSION_DEPARTMENT_DELETE,
    ],
    'Danh mục' => [
        Acl::PERMISSION_CATEGORY_LIST,
        Acl::PERMISSION_CATEGORY_ADD,
        Acl::PERMISSION_CATEGORY_EDIT,
        Acl::PERMISSION_CATEGORY_DELETE,
    ],
    'Liên hệ' => [
        Acl::PERMISSION_CONTACT_LIST,
        Acl::PERMISSION_CONTACT_EDIT,
    ],
    'Yêu cầu tài khoản' => [
        Acl::PERMISSION_ACCOUNT_REQUEST_LIST,
        Acl::PERMISSION_ACCOUNT_REQUEST_EDIT,
    ],
    'Dự án' => [
        Acl::PERMISSION_PROJECT_LIST,
        Acl::PERMISSION_PROJECT_ADD,
        Acl::PERMISSION_PROJECT_EDIT,
        Acl::PERMISSION_PROJECT_DELETE,
    ],
    'Quyên góp' => [
        Acl::PERMISSION_DONATION_LIST,
        Acl::PERMISSION_DONATION_ADD,
        Acl::PERMISSION_DONATION_EDIT,
        Acl::PERMISSION_DONATION_DELETE,
    ],
    'Tình nguyện viên' => [
        Acl::PERMISSION_VOLUNTEER_LIST,
        Acl::PERMISSION_VOLUNTEER_ADD,
        Acl::PERMISSION_VOLUNTEER_EDIT,
        Acl::PERMISSION_VOLUNTEER_DELETE,
    ],
    'Cài đặt' => [
        Acl::PERMISSION_SETTING_POLICY,
        Acl::PERMISSION_SETTING_TERMS,
    ],
];