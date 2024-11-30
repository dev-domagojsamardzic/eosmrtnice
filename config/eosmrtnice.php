<?php

return [
    /**
     * *------------------------------------------------------------*
     * *--  Data and information related to main (mother) company --*
     * *------------------------------------------------------------*
     */
    'company' => [
        'title' => env('EOS_COMPANY_TITLE', 'PROVEXIO d.o.o.'),
        'address' => env('EOS_COMPANY_ADDRESS', 'Vinogradska 3'),
        'zipcode' => env('EOS_COMPANY_ZIPCODE', '40313'),
        'town' => env('EOS_COMPANY_TOWN', 'Sv. Martin na Muri'),
        'full_address' => env('EOS_COMPANY_FULL_ADDRESS', 'HR-40313, Sv. Martin na Muri, Vinogradska 3'),
        'country' => env('EOS_COMPANY_COUNTRY', 'Republika Hrvatska'),
        'oib' => env('EOS_COMPANY_OIB', '02540522475'),
        'email' => env('EOS_COMPANY_EMAIL', 'info@provexio.hr'),
        'info_email' => env('EOS_INFO_EMAIL', 'info@eosmrtnice.com'),
        'phone' => env('EOS_COMPANY_PHONE', '0038540868219'),
        'fax' => env('EOS_COMPANY_FAX', '0038540868219'),
        'mobile_phone' => env('EOS_COMPANY_MOBILE_PHONE', ''),
        'director' => env('EOS_COMPANY_DIRECTOR', 'Leon Rešetar'),
        'mbs' => env('EOS_COMPANY_MBS', '070193285'),
    ],

    'bank' => [
        'title' => env('EOS_BANK_TITLE', 'Raiffeisen Bank d.d.'),
        'iban' => env('EOS_BANK_IBAN', 'HR5524840081135274361'),
        'swift_code' => env('EOS_BANK_SWIFT_CODE', 'RZBHHR2X'),
        'model' => env('EOS_BANK_MODEL', 'HR01'),
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


    /**
     * *------------------------------------------------*
     *  * ----- List of products that have prices -----*
     * * -----------------------------------------------*
 */
    'products' => [
        'condolences_addons' => [
            ['id' => 1, 'name' => 'lanterns_3', 'price' => 12.00],
            ['id' => 2, 'name' => 'lanterns_5', 'price' => 18.00],
            ['id' => 3, 'name' => 'lanterns_6', 'price' => 21.00],
            ['id' => 4, 'name' => 'lanterns_7', 'price' => 24.00],
            ['id' => 5, 'name' => 'lanterns_10', 'price' => 32.00],
            ['id' => 6, 'name' => 'angel_statue', 'price' => 5.00],
            ['id' => 7, 'name' => 'red_roses', 'price' => 6.00],
            ['id' => 8, 'name' => 'white_roses', 'price' => 6.00],
        ],
        'ad_types' => [
            'standard' => ['price_monthly' => 10.00, 'price_annual' => 96.00],
            'premium' => ['price_monthly' => 20.00, 'price_annual' => 192.00],
            'gold' => ['price_monthly' => 25.00, 'price_annual' => 240.00],
        ],
        'posts' => [
            ['size' => 40, 'name' => 'small', 'price' => 8.00],
            ['size' => 80, 'name' => 'medium', 'price' => 25.00],
            ['size' => 240, 'name' => 'large', 'price' => 80.00],
        ],
        'post_frame' => ['title' => 'post_frame', 'price' => 5.00],
        'post_image' => ['title' => 'post_image', 'price' => 5.00],
        'post_symbol' => ['title' => 'post_symbol', 'price' => 5.00],
    ],
];
