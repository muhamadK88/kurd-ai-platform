<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-Oyrqajy5loFSFBPUgNi';

function fbPatch($url, $data) {
    global $idToken;
    $ch = curl_init($url . '?auth=' . urlencode($idToken));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

// Fetch all C++ lessons
$ch = curl_init($firebaseUrl . 'ferga_lessons.json');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$lessons = json_decode(curl_exec($ch), true);
curl_close($ch);

$fixed = 0;
foreach ($lessons as $id => $lesson) {
    if (($lesson['langId'] ?? '') !== $langId) continue;
    $updates = [];
    foreach (['title_so', 'title_ba', 'content_so', 'content_ba', 'challenge_desc_so', 'challenge_desc_ba'] as $field) {
        if (isset($lesson[$field])) {
            $text = $lesson[$field];
            $text = preg_replace('/C\+\+/', '<bdi>C++</bdi>', $text);
            $updates[$field] = $text;
        }
    }
    if ($updates) {
        $res = fbPatch($firebaseUrl . 'ferga_lessons/' . $id . '.json', $updates);
        $d = json_decode($res, true);
        if (isset($d['title_so'])) { echo "Fixed: " . $lesson['title_so'] . "\n"; $fixed++; }
        else echo "ERROR fixing " . $lesson['title_so'] . ": $res\n";
    }
}
echo "Total lessons fixed: $fixed\n";
