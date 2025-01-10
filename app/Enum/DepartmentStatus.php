<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum DepartmentStatus: int
{
    use EnumValues, EnumOptions;

    case OFF = 0;
    case ON = 1;

    public function getBadge(): string
    {
        return match ($this) {
            self::OFF => 'danger',
            self::ON => 'success',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::OFF => 'Tắt',
            self::ON => 'Bật',
        };
    }
}
