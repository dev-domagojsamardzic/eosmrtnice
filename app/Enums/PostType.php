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

    /**
     * Return select box options array
     *
     * @return array
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('enums.' . strtolower($case->name));
        }
        return $options;
    }
}
