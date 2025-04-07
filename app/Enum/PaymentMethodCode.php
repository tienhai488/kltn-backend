<?php

namespace App\Enum;

use App\DTOs\BankTransferApiConfigDTO;
use App\DTOs\MomoApiConfigDTO;
use App\DTOs\VNPayApiConfigDTO;

enum PaymentMethodCode: string
{
    case VNPAY = 'vnpay';
    case MOMO = 'momo';
    case BANK_TRANSFER = 'bank_transfer';

    public function getView(): string
    {
        return match ($this) {
            self::VNPAY => 'admin.payment_method.vnpay',
            self::MOMO => 'admin.payment_method.momo',
            self::BANK_TRANSFER => 'admin.payment_method.bank_transfer',
        };
    }

    public function getDTO()
    {
        return match ($this) {
            self::VNPAY => VNPayApiConfigDTO::class,
            self::MOMO => MomoApiConfigDTO::class,
            self::BANK_TRANSFER => BankTransferApiConfigDTO::class,
        };
    }
}