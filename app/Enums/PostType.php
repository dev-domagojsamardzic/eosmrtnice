<?php

namespace App\Enums;

enum PostType: int
{
    /* Obavijest o smrti */
    case DEATH_NOTICE = 1;
    /* Sjećanje */
    case MEMORY = 2;
    /* Posljednji pozdrav */
    case LAST_GOODBYE = 3;
    /* Zahvala */
    case THANK_YOU = 4;
}
