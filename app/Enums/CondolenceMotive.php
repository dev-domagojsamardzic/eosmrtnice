<?php

namespace App\Enums;

enum CondolenceMotive: int
{
    case CROSS = 1;

    case WHITE_ROSE = 2;

    case RED_ROSE = 3;

    case WHITE_DOVE = 4;

    case ANGEL = 5;

    case CANDLES = 6;

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
