<?php
// Safe backfill of answer_code / answer_code_css per lesson node.
// PATCHes each lesson individually - NEVER the root node.
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

$ids = json_decode(fbReq("$base/ferga_lessons.json?shallow=true", $tok), true);
$n = 0;
foreach (array_keys($ids) as $id) {
    $l = json_decode(fbReq("$base/ferga_lessons/$id.json", $tok), true);
    $patch = [];
    if (isset($l['code']) && !isset($l['answer_code'])) $patch['answer_code'] = $l['code'];
    if (isset($l['code_css']) && $l['code_css'] !== '' && !isset($l['answer_code_css'])) $patch['answer_code_css'] = $l['code_css'];
    if (!$patch) continue;
    $r = fbReq("$base/ferga_lessons/$id.json", $tok, 'PATCH', json_encode($patch, JSON_UNESCAPED_UNICODE));
    if ($r === 'null') { $n++; } else { echo "ERROR $id: $r\n"; }
}
echo "answer_code backfilled on $n lessons\n";
