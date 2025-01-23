<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum VolunteerStatus: int
{
    use EnumValues, EnumOptions;

    case PENDING = 1;
    case COMPLETED = 2;
    case INCOMPLETED = 3;
    case CANCELED = 4;

    public function getBadge(): string
    {
        return match ($this) {
            self::PENDING => 'primary',
            self::COMPLETED => 'success',
            self::INCOMPLETED => 'danger',
            self::CANCELED => 'dark',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ xử lý',
            self::COMPLETED => 'Hoàn thành',
            self::INCOMPLETED => 'Không hoàn thành',
            self::CANCELED => 'Hủy',
        };
    }
}
