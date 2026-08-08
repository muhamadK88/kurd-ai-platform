<?php

// restore_rust.php
// Restore the deleted Rust language entry in ferga_languages.
// The 28 Rust lessons are still in ferga_lessons (langId=-OysGzfS5Qi08XHYs_FL),
// so we only re-create the language definition node, exactly as the original.
// SAFE: PATCHes ONLY the Rust node (merge, idempotent) — never touches other languages.
//
// Usage:  php restore_rust.php
// Needs firebase_credentials.json next to this script (or fb_token.txt at
// /tmp/opencode/fb_token.txt on Linux).

$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
$langId = '-OysGzfS5Qi08XHYs_FL';
$tokenPath = '/tmp/opencode/fb_token.txt';

$token = is_file($tokenPath) ? trim(file_get_contents($tokenPath)) : '';
if (!$token && is_file(__DIR__ . '/firebase_credentials.json')) {
    $cred = json_decode(file_get_contents(__DIR__ . '/firebase_credentials.json'), true);
    if ($cred && !empty($cred['client_email']) && !empty($cred['private_key'])) {
        $now = time();
        $b64 = function ($s) { return rtrim(strtr(base64_encode($s), '+/', '-_'), '='); };
        $header = $b64(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $claims = $b64(json_encode([
            'iss' => $cred['client_email'],
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/firebase.database',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ]));
        $sig = '';
        openssl_sign("$header.$claims", $sig, $cred['private_key'], OPENSSL_ALGO_SHA256);
        $jwt = "$header.$claims." . $b64($sig);
        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (!empty($res['access_token'])) $token = $res['access_token'];
    }
}
if (!$token) {
    echo "ERROR: no token. Place fb_token.txt at $tokenPath or firebase_credentials.json next to this script.\n";
    exit(1);
}

function fbReq($url, $token, $method = 'GET', $body = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);
    if ($body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Original Rust definition (as in restore_languages.php / fix_language_logos.php).
$rust = [
    'name_so' => 'Rust', 'name_ba' => 'Rust',
    'desc_so' => 'زمانێکی نوێ و پارێزراوە کە بە ناوبەنگی خێرایی و سەلامەتی ناسراوە، بۆ سیستەم و وێب.',
    'desc_ba' => 'زمانەکەکێ نوی و پاراستییە، ب ناڤناڤا لەزی و ئەمنییێ ناساییە، ژبو سیستەمان و وێب.',
    'ext' => 'rs', 'color' => 'bg-orange-100', 'logo_url' => '/rust-logo.svg', 'locked' => false,
];

$url = "$base/ferga_languages/$langId.json";

echo "== Restoring Rust language node ==\n";
$res = fbReq($url, $token, 'PATCH', json_encode($rust));
if (!$res || !isset($res['name_so']) || $res['name_so'] !== 'Rust') {
    echo "ERROR: PATCH failed\n" . json_encode($res) . "\n";
    exit(1);
}

echo "== Verify ==\n";
$after = fbReq("$base/ferga_languages.json", $token);
$r = $after[$langId] ?? null;
if ($r === null) { echo "Rust MISSING\n"; exit(1); }
printf("name=%-6s ext=%-4s locked=%-5s logo=%s\n",
    $r['name_so'], $r['ext'], $r['locked'] ? 'true ' : 'false', $r['logo_url']);

echo "== Lesson count for Rust ==\n";
$lessons = fbReq("$base/ferga_lessons.json", $token);
if (is_array($lessons)) {
    $n = 0;
    foreach ($lessons as $l) { if (($l['langId'] ?? null) === $langId) $n++; }
    echo "Rust lessons in ferga_lessons: $n\n";
} else {
    echo "Could not read ferga_lessons.\n";
}

echo "Done. Refresh the Ferga page — Rust is restored.\n";
