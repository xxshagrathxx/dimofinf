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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '218489449392-9bntj1kavpr185p02o5sropn7k6sg5la.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://localhost:8000/authorized/google/callback',
    ],

    'facebook' => [
        'client_id' => '912807023290821',
        'client_secret' => 'ac8be8c1b10caa9084a2c414f4cf3cf4',
        'redirect' => 'http://localhost:8000/authorized/facebook/callback',
    ],

    'linkedin' => [
        'client_id' => '77ebgzyghyu6iq',
        'client_secret' => '08nHpxCyD5Jv8Vfj',
        'redirect' => 'http://127.0.0.1:8000/authorized/linkedin/callback',
    ],

];
