<?php

namespace App\Enums;

enum CondolencePackageAddon: int
{
    case LANTERNS_3 = 1;
    case LANTERNS_5 = 2;
    case LANTERNS_6 = 3;
    case LANTERNS_7 = 4;
    case LANTERNS_10 = 5;
    case ANGEL_STATUE = 6;
    case RED_ROSES = 7;
    case WHITE_ROSES = 8;

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = trans('enums.' . strtolower($case->name));
        }
        return $options;
    }

    /**
     * Translate resource
     * @param string $locale
     * @return string
     */
    public function translate(string $locale = 'hr'): string
    {
        return __('enums.' . strtolower($this->name), locale: $locale);
    }
}
