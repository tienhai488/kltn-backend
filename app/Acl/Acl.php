<?php

namespace App\Acl;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

final class Acl
{
    const ROLE_SUPER_ADMIN = 'quản trị viên cấp cao';

    const ROLE_ADMIN = 'quản trị viên';

    const PERMISSION_ASSIGNEE = 'gán vai trò';

    const PERMISSION_VIEW_MENU_DASHBOARD = 'xem menu bảng điều khiển';

    const PERMISSION_ROLE_LIST = 'danh sách vai trò';

    const PERMISSION_ROLE_ADD = 'thêm mới vai trò';

    const PERMISSION_ROLE_EDIT = 'chỉnh sửa vai trò';

    const PERMISSION_ROLE_DELETE = 'xóa vai trò';

    const PERMISSION_USER_MANAGE = 'quản lý người dùng';

    const PERMISSION_USER_LIST = 'danh sách người dùng';

    const PERMISSION_USER_ADD = 'thêm mới người dùng';

    const PERMISSION_USER_EDIT = 'chỉnh sửa người dùng';

    const PERMISSION_USER_DELETE = 'xóa người dùng';

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