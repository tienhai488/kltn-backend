<?php

namespace App\Enum;

use App\Models\User;
use App\Traits\EnumValues;
use App\Traits\EnumOptions;

enum UserAvatar: string
{
    use EnumValues, EnumOptions;

    case COLLECTION = User::USER_AVATAR_COLLECTION;
    case RESIZE_NAME =  User::USER_AVATAR_RESIZE_NAME;
}