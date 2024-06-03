<?php

use App\Enums\UserType;
use App\Models\User;

if (!function_exists('auth_user_type')) {
    /**
     * Return type of currently authenticated user
     * @return string
     */
    function auth_user_type(): string
    {
        return auth()?->user()?->type?->value === 'member' ? 'user' : auth()?->user()?->type?->value;
    }
}

if (!function_exists('is_admin')) {

    /**
     * Check if currently authenticated user is admin
     * @return bool
     */
    function is_admin(): bool
    {
        return auth()?->user()?->type === UserType::ADMIN;
    }
}

if (!function_exists('is_partner')) {
    /**
     * Check if currently authenticated user is admin
     * @return bool
     */
    function is_partner(): bool
    {
        return auth()?->user()?->type === UserType::PARTNER;
    }
}

if (!function_exists('is_member')) {
    /**
     * Check if currently authenticated user is admin
     * @return bool
     */
    function is_member(): bool
    {
        return auth()?->user()?->type === UserType::MEMBER;
    }
}

if (!function_exists('public_storage_asset')) {
    /**
     * Returns asset link for item in public/storage directory
     * @param string $path
     * @return string
     */
    function public_storage_asset(string $path = ''): string
    {
        return asset('storage/' . $path);
    }
}

if (!function_exists('admin')) {
    /**
     * Return admin user
     * @return User
     */
    function admin(): User
    {
        return User::where('type', UserType::ADMIN)->first();
    }
}

if (!function_exists('company_data')) {
    function company_data(string $property = null): array|string|null
    {
        $key = 'eosmrtnice.company';
        if ($property) {
            $key .= '.' . $property;
        }

        return config($key);
    }
}

if (!function_exists('currency')) {
    /**
     * Return amount with currency symbol
     *
     * @param int|float $amount
     * @return string
     */
    function currency(int|float $amount): string
    {
        return number_format($amount, 2, '.', '') . config('app.currency_symbol');
    }
}

if (!function_exists('percentage')) {
    /**
     * Return number with percentage symbol
     *
     * @param int|float $amount
     * @return string
     */
    function percentage(int|float $amount): string
    {
        return $amount . '%';
    }
}
