<?php

/*
|--------------------------------------------------------------------------
| Kurd AI keys
|--------------------------------------------------------------------------
| API keys are read from a folder OUTSIDE the project so they never ship in
| the deploy zip (see zip-deploy.ps1). Resolution order (highest wins):
|   1) storage/app/ai/config.json       -> local override
|   2) ~/.config/kurd-ai/config.json    -> server / production
|   3) .env                            -> local development
|   4) empty
|
| After placing ~/.config/kurd-ai/config.json on the server, run:
|   php artisan config:clear   (or config:cache)
*/

$external = [];

$home = getenv('HOME') ?: ($_SERVER['HOME'] ?? getenv('USERPROFILE'));
if ($home) {
    $file = rtrim($home, DIRECTORY_SEPARATOR)
        . DIRECTORY_SEPARATOR . '.config'
        . DIRECTORY_SEPARATOR . 'kurd-ai'
        . DIRECTORY_SEPARATOR . 'config.json';
    if (is_file($file)) {
        $decoded = json_decode((string) file_get_contents($file), true);
        if (is_array($decoded)) {
            $external = $decoded;
        }
    }
}

$local = dirname(__DIR__) . '/storage/app/ai/config.json';
if (is_file($local)) {
    $decoded = json_decode((string) file_get_contents($local), true);
    if (is_array($decoded)) {
        $external = array_merge($external, $decoded);
    }
}

$fb = $external['firebase'] ?? [];
$imgbb = $external['imgbb'] ?? [];

return [
    /*
    | Keys are camelCase here on purpose: these values are rendered straight
    | into the browser via @json(config('kurdai.firebase')) and must match the
    | shape Firebase's initializeApp() expects (apiKey, authDomain, databaseURL,
    | projectId, storageBucket, messagingSenderId, appId).
    */
    'firebase' => [
        'apiKey' => $fb['api_key'] ?? env('FIREBASE_API_KEY'),
        'authDomain' => $fb['auth_domain'] ?? env('FIREBASE_AUTH_DOMAIN'),
        'databaseURL' => $fb['database_url'] ?? env('FIREBASE_DATABASE_URL'),
        'projectId' => $fb['project_id'] ?? env('FIREBASE_PROJECT_ID'),
        'storageBucket' => $fb['storage_bucket'] ?? env('FIREBASE_STORAGE_BUCKET'),
        'messagingSenderId' => $fb['messaging_sender_id'] ?? env('FIREBASE_MESSAGING_SENDER_ID'),
        'appId' => $fb['app_id'] ?? env('FIREBASE_APP_ID'),
    ],
    'imgbb' => [
        'api_key' => $imgbb['api_key'] ?? env('IMGBB_API_KEY'),
    ],
    'facebook' => [
        'app_id' => $external['facebook']['app_id'] ?? env('FACEBOOK_APP_ID'),
    ],
    'ai' => $external['ai'] ?? [],
];
