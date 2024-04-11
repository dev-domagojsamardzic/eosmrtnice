<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = 'm';
    case FEMALE = 'f';

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('enums.' . strtolower($case->name));
        }
        return $options;
    }
}
