<?php

return [
    /**
     * *------------------------------------------------------------*
     * *--  Data and information related to main (mother) company --*
     * *------------------------------------------------------------*
     */
    'company' => [
        'title' => env('EOS_COMPANY_TITLE', 'eOsmrtnice d.o.o.'),
        'address' => env('EOS_COMPANY_ADDRESS', 'Addresa Hrvatskih Branitelja 11'),
        'zipcode' => env('EOS_COMPANY_ZIPCODE', '21300'),
        'town' => env('EOS_COMPANY_TOWN', 'Grad'),
        'country' => env('EOS_COMPANY_COUNTRY', 'Republika Hrvatska'),
        'oib' => env('EOS_COMPANY_OIB', '11457658984'),
        'email' => env('EOS_COMPANY_EMAIL', 'info@eosmrtnice.com'),
        'phone' => env('EOS_COMPANY_PHONE', '+38523414999'),
        'mobile_phone' => env('EOS_COMPANY_MOBILE_PHONE', '+385923419912'),
    ],

    'mail_from_address' => env('EOS_MAIL_FROM_ADDRESS', 'info@eosmrtnice.com'),

    /**
     * *-------------------------------*
     * *-- Images default dimensions --*
     * --------------------------------*
     */
    'image_dimensions' => [
        'deceased_image' => [
            'width' => env('EOS_DECEASED_IMAGE_WIDTH', 200),
            'height' => env('EOS_DECEASED_IMAGE_HEIGHT', 280),
        ],
        'company_logo' => [
            'width' => env('EOS_COMPANY_LOGO_WIDTH', 120),
            'height' => env('EOS_COMPANY_LOGO_HEIGHT', 120),
        ],
        'ad_banner' => [
            'width' => env('EOS_COMPANY_AD_BANNER_WIDTH', 500),
            'height' => env('EOS_COMPANY_AD_BANNER_HEIGHT', 300),
        ],
    ],
];
