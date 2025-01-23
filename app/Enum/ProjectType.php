<?php

namespace App\Enum;

use App\Traits\EnumOptions;
use App\Traits\EnumValues;

enum ProjectType: string
{
    use EnumValues, EnumOptions;

    case DONATION = 'Quyên góp';
    case VOLUNTEER = 'Tình nguyện';
    case BOTH = 'Quyên góp và tình nguyện';
}