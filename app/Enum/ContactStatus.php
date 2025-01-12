<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ContactStatus: int
{
    use EnumValues, EnumOptions;

    case PENDING = 1;
    case IN_PROGRESS = 2;
    case DONE = 3;
    case CLOSED = 4;

    public function getBadge(): string
    {
        return match ($this) {
            self::PENDING => 'primary',
            self::IN_PROGRESS => 'warning',
            self::DONE => 'success',
            self::CLOSED => 'dark',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ xử lý',
            self::IN_PROGRESS => 'Đang xử lý',
            self::DONE => 'Hoàn thành',
            self::CLOSED => 'Đóng',
        };
    }
}