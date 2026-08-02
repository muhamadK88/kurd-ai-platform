<?php

// Set default `locked` flag on all languages in ferga_languages.
// Python / C++ / HTML+CSS stay FREE (locked=false); everything else is locked=true.
// Reuses the OAuth token minted by get_firebase_token.php.

$tokenPath = '/tmp/opencode/fb_token.txt';
$dbUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';

if (!is_file($tokenPath)) {
    echo "ERROR: token not found. Run get_firebase_token.php first.\n";
    exit(1);
}
$token = trim(file_get_contents($tokenPath));

function fbReq($url, $token, $method = 'GET', $body = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
    ]);
    if ($body !== null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

$languages = json_decode(fbReq("$dbUrl/ferga_languages.json", $token), true);
if (!$languages) {
    echo "ERROR: no languages found / fetch failed\n";
    exit(1);
}

function isFreeLanguage($name, $ext) {
    $n = mb_strtolower((string)$name, 'UTF-8');
    $e = strtolower((string)$ext);
    if (str_contains($n, 'python')) return true;
    if (str_contains($n, 'c++') || $e === 'cpp' || $e === 'c++') return true;
    if (str_contains($n, 'html')) return true;
    if (in_array($e, ['html', 'css', 'html+css', 'htmlcss'], true)) return true;
    return false;
}

$patch = [];
foreach ($languages as $id => $l) {
    $name = $l['name_so'] ?? $l['name'] ?? $id;
    $ext = $l['ext'] ?? '';
    $locked = !isFreeLanguage($name, $ext);
    $patch[$id] = ['locked' => $locked];
    echo sprintf("%-16s ext=%-8s locked=%s\n", $name, $ext, $locked ? 'true ' : 'false');
}

$res = fbReq("$dbUrl/ferga_languages.json", $token, 'PATCH', json_encode($patch));
echo "PATCH response: " . substr($res, 0, 200) . "\n";
echo "Done.\n";
