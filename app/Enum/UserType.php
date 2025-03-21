<?php

namespace App\Enum;

enum UserType: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case ORGANIZATION = 'organization';
    case INDIVIDUAL = 'individual';
}
