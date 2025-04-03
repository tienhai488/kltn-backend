<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum NotificationType: string
{
    use EnumOptions, EnumValues;

    case SUCCESS = 'success';
    case ERROR = 'error';
}