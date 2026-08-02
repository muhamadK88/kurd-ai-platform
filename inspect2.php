<?php
$token = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
function g($url,$t){$ch=curl_init($url);curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);curl_setopt($ch,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t]);$r=curl_exec($ch);curl_close($ch);return $r;}
$lessons = json_decode(g("$base/ferga_lessons.json", $token), true);
$byLang = [];
foreach ($lessons as $id => $l) { $byLang[$l['langId']][] = $l['title_so'] ?? $l['title'] ?? '?'; }
foreach ($byLang as $lid => $titles) {
    echo "=== $lid (".count($titles)." lessons) ===\n";
    foreach (array_slice($titles, 0, 3) as $t) echo "   - $t\n";
}
