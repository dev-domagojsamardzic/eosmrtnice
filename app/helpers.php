<?php

if(!function_exists('auth_user_type')) {
    /**
     * Return type of currently authenticated user
     * @return string
     */
    function auth_user_type(): string
    {
        return auth()?->user()?->type?->value ?? '';
    }
}
