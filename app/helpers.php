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

if (!function_exists('is_user')) {
    /**
     * Check if currently authenticated user is admin
     * @return bool
     */
    function is_user(): bool
    {
        return auth()?->user()?->type === UserType::USER;
    }
}
