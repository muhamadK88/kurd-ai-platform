<?php

// Backfill lesson.answer_code / answer_code_css from lesson.code / code_css
// only where answer_code is not already set. This keeps the "example code"
// separate from the "correct answer" that gets revealed after max attempts.

$token = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
if (!$token) { echo "ERROR: token missing. Run get_firebase_token.php first.\n"; exit(1); }
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';

function fbReq($url, $token, $method = 'GET', $body = null) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token, 'Content-Type: application/json']);
    if ($body !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

$data = json_decode(fbReq("$base/ferga_lessons.json", $token), true);
if (!is_array($data)) { echo "ERROR: could not read ferga_lessons.\n"; exit(1); }

$updates = [];
$count = 0;
foreach ($data as $id => $l) {
    $patch = [];
    if (empty($l['answer_code']) && !empty($l['code'])) {
        $patch['answer_code'] = $l['code'];
    }
    if (empty($l['answer_code_css']) && !empty($l['code_css'])) {
        $patch['answer_code_css'] = $l['code_css'];
    }
    if ($patch) { $updates[$id] = $patch; $count++; }
}

echo "Lessons to update: $count / " . count($data) . "\n";

$res = fbReq("$base/ferga_lessons.json", $token, 'PATCH', json_encode($updates));
$check = json_decode($res, true);
if (!$check) { echo "ERROR: PATCH failed\n$res\n"; exit(1); }

$done = 0;
foreach ($check as $id => $l) {
    if (isset($l['answer_code']) || isset($l['answer_code_css'])) $done++;
}
echo "Updated $done lessons with answer_code.\n";
