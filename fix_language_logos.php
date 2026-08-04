<?php

// fix_language_logos.php
// Restore ferga_languages definition fields (name/desc/color/logo_url) that were
// wiped to only `locked`, which makes the ferga UI fall back to letter avatars.
// SAFE: PATCHes only the missing fields per known language id (merge, idempotent),
// never touches unknown entries, never overwrites existing values.

$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
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

$known = [
    '-OypFoFNvHfBuaA2Uh7O' => [
        'name_so' => 'Python', 'name_ba' => 'Python',
        'desc_so' => 'زمانێکی سادە و خوێندنەوەی ئاسانە بۆ دەستپێکەران، بەکاردێت لە وێب، زانستی داتا و زیرەکی دەستکرد.',
        'desc_ba' => 'زمانەکەکێ هەسا و خوێندنەوە وەساانە ژبو دەستپێکەران، بکارئینان ل وێب، زانستا داتایان و ئاقلی دەسکرد.',
        'ext' => 'py', 'color' => 'bg-blue-100', 'logo_url' => '/python-logo.svg', 'locked' => false,
    ],
    '-Oyrqajy5loFSFBPUgNi' => [
        'name_so' => 'C++', 'name_ba' => 'C++',
        'desc_so' => 'زمانێکی بەهێزە بۆ پرۆگرامی سیستەم و یارییەکان، خێرا و کۆنترۆڵی تەواوی سەر کۆمپیوتەر.',
        'desc_ba' => 'زمانەکەکێ بهێزە ژبو بەرنامەکرنا سیستەمان و لیستا، لەز و کۆنترۆلا تمام یا سەر کۆمپیوتەری.',
        'ext' => 'cpp', 'color' => 'bg-indigo-100', 'logo_url' => '/cpp-logo.svg', 'locked' => false,
    ],
    '-OysGzUzKG67KcswHXn2' => [
        'name_so' => 'C#', 'name_ba' => 'C#',
        'desc_so' => 'زمانێکی مۆدێرنە لەلایەن مایکرۆسۆفتەوە، بەکارهێنانی زۆرە لە دروستکردنی ئەپلیکەیشن و یاری.',
        'desc_ba' => 'زمانەکەکێ مۆدێرنە ژ لای مایکرۆسۆفت، بکارئینانا زاف ل دروستکرنا بەرنامان و لیستا.',
        'ext' => 'cs', 'color' => 'bg-purple-100', 'logo_url' => '/csharp-logo.svg', 'locked' => true,
    ],
    '-OysGzfS5Qi08XHYs_FL' => [
        'name_so' => 'Rust', 'name_ba' => 'Rust',
        'desc_so' => 'زمانێکی نوێ و پارێزراوە کە بە ناوبەنگی خێرایی و سەلامەتی ناسراوە، بۆ سیستەم و وێب.',
        'desc_ba' => 'زمانەکەکێ نوی و پاراستییە، ب ناڤناڤا لەزی و ئەمنییێ ناساییە، ژبو سیستەمان و وێب.',
        'ext' => 'rs', 'color' => 'bg-orange-100', 'logo_url' => '/rust-logo.svg', 'locked' => true,
    ],
    '-OysQq7E9B4bBLuGjUEX' => [
        'name_so' => 'HTML + CSS', 'name_ba' => 'HTML + CSS',
        'desc_so' => 'بنەماکانی دروستکردنی وێبپەڕە — HTML بۆ پێکهاتە و CSS بۆ جوانی، بە یەکەوە وێبپەڕەی جوان دروست دەکەن.',
        'desc_ba' => 'بنەمایێن دروستکرنا مالپەران — HTML ژبو پێکهاتان و CSS ژبو دڵخوشییێ، پێکڤە مالپەرێن جوان چێدکەن.',
        'ext' => 'html+css', 'color' => 'bg-orange-100', 'logo_url' => '/html-css-logo.svg', 'locked' => false,
    ],
    '-Oysj44hJLXDgdp-b9iN' => [
        'name_so' => 'PHP', 'name_ba' => 'PHP',
        'desc_so' => 'زمانێکە بۆ سەرڤەر و پشتەوەی وێب، بەکاردێت بۆ دروستکردنی سایتە داینامیکییەکان.',
        'desc_ba' => 'زمانەکەکە ژبو سێرڤەر و پشتەوایا وێبێ، بکارئینان ژبو دروستکرنا مالپەرێن داینامیک.',
        'ext' => 'php', 'color' => 'bg-indigo-100', 'logo_url' => '/php-logo.svg', 'locked' => true,
    ],
    '-Oysj4DmsfjAe6mjjfjT' => [
        'name_so' => 'Java', 'name_ba' => 'Java',
        'desc_so' => 'زمانێکی بەناوبانگە و سەربەخۆی سەکۆیە، بەکاردێت لە ئەپلیکەیشنی ئەندرۆید و سیستەمە گەورەکان.',
        'desc_ba' => 'زمانەکەکێ ناڤدار و سەربەخۆی پلاتفۆرمێ، بکارئینان ل بەرنامەن ئەندرۆید و سیستەمێن مەزن.',
        'ext' => 'java', 'color' => 'bg-red-100', 'logo_url' => '/java-logo.svg', 'locked' => true,
    ],
    '-Oysj4NVk0PGRLQx2Z8o' => [
        'name_so' => 'JavaScript', 'name_ba' => 'JavaScript',
        'desc_so' => 'زمانی وێبی مۆدێرنە بۆ ئەپلیکەیشنی کارلێککەر، کاردەکات لە وێبگەڕدا و لە سەرڤەر (Node).',
        'desc_ba' => 'زمانێ وێبێ مۆدێرن ژبو بەرنامێن کارلێککەر، کاردکەت د براوزەرێ و سەر سێرڤەری (Node).',
        'ext' => 'js', 'color' => 'bg-yellow-100', 'logo_url' => '/javascript-logo.svg', 'locked' => true,
    ],
];

echo "== Current ferga_languages state ==\n";
$current = fbReq("$base/ferga_languages.json", $token);
if (!$current) { echo "ERROR: fetch failed\n"; exit(1); }

$patch = [];
foreach ($known as $id => $l) {
    $c = $current[$id] ?? null;
    if ($c === null) {
        echo "$id (new) -> creating\n";
        $patch[$id] = $l;
        continue;
    }
    $missing = [];
    foreach ($l as $k => $v) {
        $has = isset($c[$k]) && $c[$k] !== '';
        if (!$has) $missing[$k] = $v;
    }
    if ($missing) {
        echo sprintf("%-24s name=%-10s missing: %s\n", $id, $l['name_so'], implode(', ', array_keys($missing)));
        $patch[$id] = $missing;
    } else {
        echo sprintf("%-24s name=%-10s OK\n", $id, $l['name_so']);
    }
}
foreach ($current as $id => $c) {
    if (!isset($known[$id])) {
        echo "$id (unknown, untouched): " . ($c['name_so'] ?? $c['name'] ?? '?') . "\n";
    }
}

if (!$patch) { echo "\nNothing to fix — all languages complete.\n"; exit(0); }

$res = fbReq("$base/ferga_languages.json", $token, 'PATCH', json_encode($patch));
if (!$res) { echo "\nERROR: PATCH failed\n" . json_encode($res) . "\n"; exit(1); }
echo "\nPatched " . count($patch) . " languages.\n";

echo "\n== Verify ==\n";
$after = fbReq("$base/ferga_languages.json", $token);
foreach ($known as $id => $l) {
    $c = $after[$id] ?? null;
    if ($c === null) { echo "$id MISSING\n"; continue; }
    $ok = isset($c['logo_url']) && $c['logo_url'] !== '' && isset($c['name_so']) && $c['name_so'] !== '';
    echo sprintf("%-10s logo=%-6s name=%-10s %s\n", $l['name_so'], $c['logo_url'] ? 'yes' : 'NO ', $c['name_so'], $ok ? '' : ' <-- STILL BROKEN');
}
echo "Done.\n";
