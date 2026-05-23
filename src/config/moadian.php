<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Account
    |--------------------------------------------------------------------------
    |
    | This option controls the default Moadian account that will be used
    | when no specific account is specified.
    |
    */

    'default' => env('MOADIAN_DEFAULT_ACCOUNT', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Base URI
    |--------------------------------------------------------------------------
    |
    | The base URI for Moadian API. Can be overridden per account.
    |
    */

    'base_uri' => env('MOADIAN_BASE_URI', 'https://tp.tax.gov.ir/requestsmanager/api/v2/'),

    /*
    |--------------------------------------------------------------------------
    | Legacy Single Account Configuration (Backward Compatibility)
    |--------------------------------------------------------------------------
    |
    | These settings are used when no 'accounts' array is configured.
    | This maintains backward compatibility with existing implementations.
    |
    */

    'username'         => env('MOADIAN_USERNAME'),
    'private_key_path' => env('MOADIAN_PRIVATE_KEY_PATH'),
    'certificate_path' => env('MOADIAN_CERTIFICATE_PATH'),

    /*
    |--------------------------------------------------------------------------
    | Multiple Accounts Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure multiple Moadian accounts. Each account can have
    | its own credentials and base URI. You can specify credentials either
    | as file paths or as direct content.
    |
    */

    // 'accounts' => [
    //     'company_a' => [
    //         'username' => 'A12345678',
    //         'private_key_path' => storage_path('app/keys/company_a/private.pem'),
    //         'certificate_path' => storage_path('app/keys/company_a/certificate.crt'),
    //         'base_uri' => 'https://tp.tax.gov.ir/requestsmanager/api/v2/',
    //     ],
    //     'company_b' => [
    //         'username' => 'B87654321',
    //         'private_key_path' => storage_path('app/keys/company_b/private.pem'),
    //         'certificate_path' => storage_path('app/keys/company_b/certificate.crt'),
    //         'base_uri' => 'https://tp.tax.gov.ir/requestsmanager/api/v2/',
    //     ],
    // ],

    'accounts' => [
        // 'default' => [
        //     'username' => env('MOADIAN_USERNAME'),
        //     'private_key_path' => env('MOADIAN_PRIVATE_KEY_PATH'),
        //     'certificate_path' => env('MOADIAN_CERTIFICATE_PATH'),
        //     'base_uri' => env('MOADIAN_BASE_URI'),
        // ],
    ],

];
