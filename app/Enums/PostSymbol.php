<?php

namespace App\Enums;

enum PostSymbol: string
{
    case NONE = '';
    case CROSS = 'cross';
    case DOVE = 'dove';
    case MOON_STAR = 'moon-star';
    case OLIVE_BRANCH = 'olive-branch';
    case STAR_OF_DAVID = 'star-of-david';

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
