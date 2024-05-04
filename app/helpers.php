<?php

use App\Enums\UserType;

if (!function_exists('auth_user_type')) {
    /**
     * Return type of currently authenticated user
     * @return string
     */
    function auth_user_type(): string
    {
        return auth()?->user()?->type?->value ?? '';
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
