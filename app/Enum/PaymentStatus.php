<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum PaymentStatus: int
{
    use EnumOptions, EnumValues;

    case PENDING = 0;
    case PAID = 1;
    case FAILED = 2;
    case REFUNDED = 3;
    case CANCELLED = 4;
    case EXPIRED = 5;

    /**
     * Get the label for the payment status.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ thanh toán',
            self::PAID => 'Đã thanh toán',
            self::FAILED => 'Thất bại',
            self::REFUNDED => 'Đã hoàn tiền',
            self::CANCELLED => 'Đã hủy',
            self::EXPIRED => 'Đã hết hạn',
        };
    }

    /**
     * Get the badge for the payment status.
     *
     * @return string
     */
    public function getBadge(): string
    {
        return match ($this) {
            self::PENDING => 'warning',
            self::PAID => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'info',
            self::CANCELLED => 'secondary',
            self::EXPIRED => 'dark',
        };
    }
}