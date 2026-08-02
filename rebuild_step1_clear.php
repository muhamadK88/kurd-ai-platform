<?php
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
$tok = trim(file_get_contents('/tmp/opencode/fb_token.txt'));

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

$r = fbReq("$base/ferga_lessons.json", $tok, 'DELETE');
echo "DELETE: " . substr($r, 0, 200) . "\n";
