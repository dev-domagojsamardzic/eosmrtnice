<?php

namespace App\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case PARTNER = 'partner';
    case USER = 'user';
}
