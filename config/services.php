<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    /*
     * Which AI restyles the guest's photo: "gemini" or "flux".
     */
    'ai' => [
        'provider' => env('AI_PROVIDER', 'gemini'),
    ],

    'bfl' => [
        'api_key' => env('BFL_API_KEY'),
        'model' => env('BFL_MODEL', 'flux-2-pro'),
    ],

    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-3.1-flash-image'),
    ],

    'google_drive' => [
        'credentials' => env('GOOGLE_DRIVE_CREDENTIALS', 'storage/app/google/credentials.json'),
        'token_path' => env('GOOGLE_DRIVE_TOKEN_PATH'),
        'generated_folder_id' => env('GOOGLE_DRIVE_GENERATED_FOLDER_ID'),
    ],

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
