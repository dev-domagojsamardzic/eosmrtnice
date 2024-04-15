<?php

namespace App\Enums;

enum CityType: int
{
    case CITY = 1;

    case MUNICIPALITY = 2;

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('enums.' . strtolower($case->name));
        }
        return $options;
    }
}
