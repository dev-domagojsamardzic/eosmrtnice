<?php

namespace App\Enums;

enum CondolencePackageAddon: int
{
    case LANTERNS_6 = 1;
    case LANTERNS_5 = 2;
    case LANTERNS_4 = 3;
    case LANTERNS_3 = 4;
    case ANGEL_STATUE = 5;
    case RED_ROSES = 6;
    case WHITE_ROSES = 7;

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
