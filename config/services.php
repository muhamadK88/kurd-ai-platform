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

    'whatsapp' => [
        'token' => env('WHATSAPP_API_TOKEN'),
        'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
        'template_name' => env('WHATSAPP_TEMPLATE_NAME', 'otp_code'),
        'template_language' => env('WHATSAPP_TEMPLATE_LANGUAGE', 'ar'),
        'test_mode' => env('WHATSAPP_TEST_MODE', false),
    ],

    'otp' => [
        'expires_minutes' => (int) env('OTP_EXPIRES_MINUTES', 10),
        'cooldown_seconds' => (int) env('OTP_SEND_COOLDOWN_SECONDS', 60),
        'max_attempts' => (int) env('OTP_MAX_ATTEMPTS', 5),
    ],

    /*
    | Shared secret for machine-to-machine endpoints — currently the
    | automated AI news pipeline (POST /api/news/automated-store).
    */
    'website' => [
        'api_secret' => env('WEBSITE_API_SECRET'),
    ],

    /*
    | Firebase Realtime Database — the live news node the site renders from.
    | Writes need auth: a service-account key is preferred, with an
    | admin email/password sign-in as the fallback.
    */
    'firebase' => [
        'database_url' => env('FIREBASE_DATABASE_URL', 'https://ai-platform-adb1b-default-rtdb.firebaseio.com'),
        'credentials' => env('FIREBASE_SERVICE_ACCOUNT', base_path('firebase_credentials.json')),
        'api_key' => env('FIREBASE_API_KEY', 'AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs'),
        'admin_email' => env('FIREBASE_ADMIN_EMAIL'),
        'admin_password' => env('FIREBASE_ADMIN_PASSWORD'),
    ],

];
