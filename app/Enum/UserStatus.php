<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum UserStatus: int
{
    use EnumValues, EnumOptions;

    case INACTIVE = 0;
    case ACTIVE = 1;
    case LOCKED = 2;

    public function getBadge(): string
    {
        return match ($this) {
            self::INACTIVE => 'danger',
            self::ACTIVE => 'success',
            self::LOCKED => 'warning',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::INACTIVE => 'Không hoạt động',
            self::ACTIVE => 'Hoạt động',
            self::LOCKED => 'Đã khóa',
        };
    }
}