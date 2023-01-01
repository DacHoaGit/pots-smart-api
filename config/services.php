<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'firebase' => [
        'api_Key' => "AIzaSyDTwNIC2GwRtA_2NEBvPjkaYG_E6ciEzsU",
        'auth_domain'=> "pots-smart.firebaseapp.com",
        'database_url'=> "https://pots-smart-default-rtdb.firebaseio.com",
        'project_id' => "pots-smart",
        'storage_bucket' => "pots-smart.appspot.com",
        'messaging_senderId' => "332257281506",
        'app_id' => "1:332257281506:web:0303a15ce152b54807a5bb",
        'measurement_id' => "G-9J8H48DBLJ",
    ]
];
