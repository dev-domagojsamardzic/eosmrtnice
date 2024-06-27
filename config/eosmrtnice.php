<?php

return [
    /**
     * *------------------------------------------------------------*
     * *--  Data and information related to main (mother) company --*
     * *------------------------------------------------------------*
     */
    'company' => [
        'title' => env('COMPANY_TITLE', 'eOsmrtnice d.o.o.'),
        'address' => env('COMPANY_ADDRESS', 'Addresa Hrvatskih Branitelja 11'),
        'zipcode' => env('COMPANY_ZIPCODE', '21300'),
        'town' => env('COMPANY_TOWN', 'Grad'),
        'country' => env('COMPANY_COUNTRY', 'Republika Hrvatska'),
        'oib' => env('COMPANY_OIB', '11457658984'),
        'email' => env('COMPANY_EMAIL', 'info@eosmrtnice.com'),
        'phone' => env('COMPANY_PHONE', '+38523414999'),
        'mobile_phone' => env('COMPANY_MOBILE_PHONE', '+385923419912'),
    ],

    'mail_from_address' => env('MAIL_FROM_ADDRESS', 'info@eosmrtnice.com'),

    /**
     * *-------------------------------*
     * *-- Images default dimensions --*
     * --------------------------------*
     */
    'image_dimensions' => [
        'deceased_image' => ['width' => 220, 'height' => 280],
        'company_logo' => ['width' => 120, 'height' => 120],
        'ad_banner' => ['width' => 500, 'height' => 300],
    ],
];
