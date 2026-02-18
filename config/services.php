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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'READ_AND_WRITE'            => 'xyz',
    'SECRET_KEY'                => '',
    'PUBLIC_KEY'                => 'FLWPUBK_TEST-1f276b3fa6fe86c2385fffbb9c15a982-X',
    'SECRET_KEY'                => 'FLWSECK_TEST-1663808b5b0b352dee2d3f71e154cfcc-X',
    'ENCRYPTION_KEY'            => 'FLWSECK_TEST0dd29d3d5e6e',
    'ENV'                       => 'staging/production',
    'GOOGLE_GEMINI_API_KEY'     => 'AIzaSyAEM0YQsrxzMPgBuH-AKdL4ZQPGk2y69-0',
    'GROQ_API_KEY'              => env('GROQ_API_KEY'),

];
