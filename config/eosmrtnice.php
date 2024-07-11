<?php

return [
    /**
     * *------------------------------------------------------------*
     * *--  Data and information related to main (mother) company --*
     * *------------------------------------------------------------*
     */
    'company' => [
        'title' => env('EOS_COMPANY_TITLE', 'PROVEXIO d.o.o.'),
        'address' => env('EOS_COMPANY_ADDRESS', 'Vinogradarska 3'),
        'zipcode' => env('EOS_COMPANY_ZIPCODE', '40313'),
        'town' => env('EOS_COMPANY_TOWN', 'Sv. Martin na Muri'),
        'country' => env('EOS_COMPANY_COUNTRY', 'Republika Hrvatska'),
        'oib' => env('EOS_COMPANY_OIB', '02540522475'),
        'email' => env('EOS_COMPANY_EMAIL', 'info@provexio.hr'),
        'phone' => env('EOS_COMPANY_PHONE', '040/886-219'),
        'fax' => env('EOS_COMPANY_FAX', '040/886-219'),
        'mobile_phone' => env('EOS_COMPANY_MOBILE_PHONE', ''),
        'director' => env('EOS_COMPANY_DIRECTOR', 'Leon Rešetar'),
    ],

    'bank' => [
        'title' => env('EOS_BANK_TITLE', 'Raiffeisen Bank d.d.'),
        'iban' => env('EOS_BANK_IBAN', 'HR5524840081135274361'),
        'swift_code' => env('EOS_BANK_SWIFT_CODE', 'RZBHHR2X'),
        'model' => env('EOS_BANK_MODEL', '05'),
        'reference_number' => env('EOS_BANK_REFNUMBER', '2410-0387'),
    ],

    'mail_from_address' => env('EOS_MAIL_FROM_ADDRESS', 'info@eosmrtnice.com'),

    /**
     * *-------------------------------*
     * *-- Images default dimensions --*
     * --------------------------------*
     */
    'image_dimensions' => [
        'default' => [
            'width' => env('EOS_DEFAULT_IMAGE_WIDTH', 500),
            'height' => env('EOS_DEFAULT_IMAGE_HEIGHT', 325),
        ],
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

    /**
     * *------------------------------------------------*
     * *-- How long will the post be active (in days) --*
     * *-------- default is 730 days (~2 years) --------*
     * -------------------------------------------------*
     */
    'post_duration_days' => config('EOS_POST_DURATION_DAYS', 730),
];
