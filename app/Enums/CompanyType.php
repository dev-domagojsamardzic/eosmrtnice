<?php

namespace App\Enums;

enum CompanyType: int
{
    case FUNERAL = 1;
    case MASONRY = 2;
    case FLOWERS = 3;

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
