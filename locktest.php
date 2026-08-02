<?php
$token = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
if (!$token) { echo "NO TOKEN\n"; exit(1); }
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
echo "PUT: " . fbReq("$base/_locktest.json", $token, 'PUT', json_encode(['a'=>1,'b'=>2])) . "\n";
echo "PATCH: " . fbReq("$base/_locktest.json", $token, 'PATCH', json_encode(['c'=>3])) . "\n";
echo "GET: " . fbReq("$base/_locktest.json", $token) . "\n";
echo "DELETE: " . fbReq("$base/_locktest.json", $token, 'DELETE') . "\n";
