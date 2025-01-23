<?php

namespace App\Enum;

use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum ImageSize: int
{
    use EnumValues, EnumOptions;

    case MAX_FILE_SIZE = 10485760;
}
