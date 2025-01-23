<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum AnonymousStatus: int
{
    use EnumValues, EnumOptions;

    case OFF = 0;
    case ON = 1;

    public function getBadge(): string
    {
        return match ($this) {
            self::OFF => 'primary',
            self::ON => 'dark',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::OFF => 'Công khai',
            self::ON => 'Ẩn danh',
        };
    }
}