<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum Gender: string
{
    use EnumValues, EnumOptions;

    case MALE = 'Nam';
    case FEMALE = 'Nữ';
    case OTHER = 'Khác';
}
