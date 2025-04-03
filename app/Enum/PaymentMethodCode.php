<?php

namespace App\Enum;

enum PaymentMethodCode: string
{
    case VNPAY = 'vnpay';
    case MOMO = 'momo';
    case BANK_TRANSFER = 'bank_transfer';
}