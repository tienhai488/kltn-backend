<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum AccountRequestStatus: int
{
    use EnumValues, EnumOptions;

    case PENDING = 1;
    case IN_PROGRESS = 2;
    case APPROVED = 3;
    case REJECTED = 4;

    public function getBadge(): string
    {
        return match ($this) {
            self::PENDING => 'primary',
            self::IN_PROGRESS => 'warning',
            self::APPROVED => 'success',
            self::REJECTED => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ xử lý',
            self::IN_PROGRESS => 'Đang xử lý',
            self::APPROVED => 'Đã duyệt',
            self::REJECTED => 'Từ chối',
        };
    }
}
