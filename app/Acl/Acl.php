<?php

namespace App\Acl;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Acl
{
    const ROLE_SUPER_ADMIN = 'quản trị viên cấp cao';

    const ROLE_ADMIN = 'quản trị viên';

    const ROLE_ORGANIZATION = 'tổ chức gây quỹ';

    const ROLE_INDIVIDUAL = 'cá nhân gây quỹ';

    const PERMISSION_ASSIGNEE = 'gán vai trò';

    const PERMISSION_VIEW_MENU_DASHBOARD = 'xem menu bảng điều khiển';

    const PERMISSION_ROLE_LIST = 'xem danh sách vai trò';

    const PERMISSION_ROLE_ADD = 'thêm mới vai trò';

    const PERMISSION_ROLE_EDIT = 'chỉnh sửa vai trò';

    const PERMISSION_ROLE_DELETE = 'xóa vai trò';

    const PERMISSION_USER_LIST = 'xem danh sách người dùng';

    const PERMISSION_USER_ADD = 'thêm mới người dùng';

    const PERMISSION_USER_EDIT = 'chỉnh sửa người dùng';

    const PERMISSION_USER_DELETE = 'xóa người dùng';

    const PERMISSION_DEPARTMENT_LIST = 'xem danh sách phòng ban';

    const PERMISSION_DEPARTMENT_ADD = 'thêm mới phòng ban';

    const PERMISSION_DEPARTMENT_EDIT = 'chỉnh sửa phòng ban';

    const PERMISSION_DEPARTMENT_DELETE = 'xóa phòng ban';

    const PERMISSION_CATEGORY_LIST = 'xem danh sách danh mục';

    const PERMISSION_CATEGORY_ADD = 'thêm mới danh mục';

    const PERMISSION_CATEGORY_EDIT = 'chỉnh sửa danh mục';

    const PERMISSION_CATEGORY_DELETE = 'xóa danh mục';

    const PERMISSION_CONTACT_LIST = 'xem danh sách liên hệ';

    const PERMISSION_CONTACT_EDIT = 'chỉnh sửa liên hệ';

    const PERMISSION_ACCOUNT_REQUEST_LIST = 'xem danh sách yêu cầu tài khoản';

    const PERMISSION_ACCOUNT_REQUEST_EDIT = 'chỉnh sửa yêu cầu tài khoản';

    const PERMISSION_PROJECT_LIST = 'xem danh sách dự án';

    const PERMISSION_PROJECT_ADD = 'thêm mới dự án';

    const PERMISSION_PROJECT_EDIT = 'chỉnh sửa dự án';

    const PERMISSION_PROJECT_DELETE = 'xóa dự án';

    const PERMISSION_DONATION_LIST = 'xem danh sách quyên góp';

    const PERMISSION_DONATION_ADD = 'thêm mới quyên góp';

    const PERMISSION_DONATION_EDIT = 'chỉnh sửa quyên góp';

    const PERMISSION_DONATION_DELETE = 'xóa quyên góp';

    const PERMISSION_VOLUNTEER_LIST = 'xem danh sách tình nguyện viên';

    const PERMISSION_VOLUNTEER_ADD = 'thêm mới tình nguyện viên';

    const PERMISSION_VOLUNTEER_EDIT = 'chỉnh sửa tình nguyện viên';

    const PERMISSION_VOLUNTEER_DELETE = 'xóa tình nguyện viên';

    const PERMISSION_VIEW_DOC_API = 'xem tài liệu api';

    /**
     * @param  array  $exclusives Exclude some permissions from the list
     */
    public static function permissions(array $exclusives = []): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) use ($exclusives) {
                return ! in_array($value, $exclusives) && Str::startsWith($key, 'PERMISSION_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    public static function menuPermissions(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $permissions = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'PERMISSION_VIEW_MENU_');
            });

            return array_values($permissions);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }

    public static function roles(): array
    {
        try {
            $class = new \ReflectionClass(__CLASS__);
            $constants = $class->getConstants();
            $roles = Arr::where($constants, function ($value, $key) {
                return Str::startsWith($key, 'ROLE_');
            });

            return array_values($roles);
        } catch (\ReflectionException $exception) {
            return [];
        }
    }
}