<?php
$t = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$b = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
function fb($url, $token) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}
$keys = json_decode(fb("$b/ferga_lessons.json?shallow=true", $t), true);
if (!is_array($keys)) { echo "ERR keys: " . substr(fb("$b/ferga_lessons.json?shallow=true", $t),0,300) . "\n"; exit; }
echo "lesson count: " . count($keys) . "\n";
$ids = array_slice(array_keys($keys), 0, 3);
foreach ($ids as $id) {
    $l = json_decode(fb("$b/ferga_lessons/$id.json", $t), true);
    echo "== $id ==\n";
    echo "title_so: " . (isset($l['title_so']) ? substr($l['title_so'],0,40) : 'MISSING') . "\n";
    echo "content_so: " . (isset($l['content_so']) ? 'len=' . strlen($l['content_so']) : 'MISSING') . "\n";
    echo "code: " . (isset($l['code']) ? 'len=' . strlen($l['code']) : 'MISSING') . "\n";
    echo "answer_code: " . (isset($l['answer_code']) ? 'len=' . strlen($l['answer_code']) : 'MISSING') . "\n";
    echo "expected_output: " . (isset($l['expected_output']) ? substr($l['expected_output'],0,30) : 'MISSING') . "\n";
    echo "langId: " . (isset($l['langId']) ? $l['langId'] : 'MISSING') . "\n";
}
