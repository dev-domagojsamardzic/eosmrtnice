<?php

namespace App\Enums;

enum PostSize: int
{
    /* to 40 words */
    case SMALL = 40;

    /* to 80 words */
    case MEDIUM = 80;

    /* to 180 words */
    case LARGE = 180;

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('enums.' . strtolower($case->name));
        }
        return $options;
    }
}
