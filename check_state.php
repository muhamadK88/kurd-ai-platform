<?php
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
$tok = trim(file_get_contents('/tmp/opencode/fb_token.txt'));

function fbGet($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $r = curl_exec($ch);
    curl_close($ch);
    return json_decode($r, true);
}

$langs = fbGet("$base/ferga_languages.json?auth=" . urlencode($tok));
echo "== LANGUAGES ==\n";
foreach ($langs as $id => $l) {
    echo "$id | " . ($l['name_so'] ?? '') . " | ext=" . ($l['ext'] ?? '') . " | locked=" . (!empty($l['locked']) ? '1' : '0') . "\n";
}

$ids = fbGet("$base/ferga_lessons.json?shallow=true&auth=" . urlencode($tok));
echo "\n== LESSONS ==\ncount=" . count($ids) . "\n";

$langIds = array_keys($langs);
$counts = [];
foreach ($ids as $id) {
    $l = fbGet("$base/ferga_lessons/$id.json?auth=" . urlencode($tok));
    $lid = $l['langId'] ?? '(none)';
    $counts[$lid] = ($counts[$lid] ?? 0) + 1;
}
echo "\n== LESSONS PER LANG ==\n";
foreach ($counts as $lid => $c) {
    echo "$lid => $c\n";
}
