<?php

// Fix RTL/LTR text issues in all ferga lessons:
// 1. Wrap raw "C++" in <bdi> (renders as "++C" in RTL otherwise)
// 2. Wrap "(Latin...)" groups in <bdi> (parens flip in RTL)
// 3. Remove raw HTML tags from challenge texts

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));

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

function fixBidi($t, &$placeholders) {
    $t = preg_replace_callback('/<bdi>.*?<\/bdi>/', function ($m) use (&$placeholders) {
        $k = "\x01" . count($placeholders) . "\x01";
        $placeholders[$k] = $m[0];
        return $k;
    }, $t);
    $t = str_replace('C++', '<bdi>C++</bdi>', $t);
    $t = preg_replace_callback('/\([^()]*?[A-Za-z][^()]*?\)/', function ($m) {
        return '<bdi>' . $m[0] . '</bdi>';
    }, $t);
    return strtr($t, $placeholders);
}

$data = json_decode(file_get_contents($firebaseUrl . 'ferga_lessons.json'), true);
$updated = 0;
foreach ($data as $id => $lesson) {
    $changed = [];
    foreach (['title_so', 'title_ba', 'content_so', 'content_ba', 'challenge_desc_so', 'challenge_desc_ba'] as $field) {
        $t = $lesson[$field] ?? '';
        if ($t === '') continue;
        $placeholders = [];
        $clean = $t;
        if (strpos($field, 'challenge') === 0) {
            $clean = str_replace(['(<b>)', '(<strong>)', '(<i>)'], '(bold)', $clean);
        }
        $fixed = fixBidi($clean, $placeholders);
        if ($fixed !== $t) $changed[$field] = $fixed;
    }
    if ($changed) {
        $res = fbPatch($firebaseUrl . 'ferga_lessons/' . $id . '.json', $changed);
        if (json_decode($res, true) === null) {
            echo "ERROR L{$lesson['order']} [{$lesson['langId']}]: $res\n";
        } else {
            $updated++;
            echo "Fixed L{$lesson['order']} [{$lesson['langId']}]: " . implode(', ', array_keys($changed)) . "\n";
        }
    }
}
echo "Updated $updated lessons\n";
