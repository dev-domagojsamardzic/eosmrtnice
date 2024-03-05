<?php

namespace App\Enums;

enum UserSex: string
{
    case MALE = 'm';
    case FEMALE = 'f';

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('common.' . strtolower($case->name));
        }
        return $options;
    }
}
