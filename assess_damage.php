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
$d = json_decode(fb("$b/ferga_lessons.json", $t), true);
if (!is_array($d)) { echo "ERR: $d\n"; exit; }
$total = count($d);
$withTitle = 0; $withContent = 0; $withCode = 0; $withLang = 0; $withAnswer = 0; $onlyAnswer = 0;
foreach ($d as $id => $l) {
    if (!empty($l['title_so']) || !empty($l['title_ba'])) $withTitle++;
    if (!empty($l['content_so']) || !empty($l['content_ba'])) $withContent++;
    if (!empty($l['code'])) $withCode++;
    if (!empty($l['langId'])) $withLang++;
    if (isset($l['answer_code'])) $withAnswer++;
    $keys = array_keys($l);
    if (count($keys) === 1 && isset($l['answer_code'])) $onlyAnswer++;
}
echo "total lessons: $total\n";
echo "with title: $withTitle\n";
echo "with content: $withContent\n";
echo "with code: $withCode\n";
echo "with langId: $withLang\n";
echo "with answer_code: $withAnswer\n";
echo "ONLY answer_code (wiped): $onlyAnswer\n";
