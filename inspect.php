<?php
$token = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
function g($url,$t){$ch=curl_init($url);curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);curl_setopt($ch,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t]);$r=curl_exec($ch);curl_close($ch);return $r;}
echo "=== ferga_languages raw ===\n";
echo g("$base/ferga_languages.json", $token) . "\n";
echo "=== ferga_lessons sample (first 800 chars) ===\n";
echo substr(g("$base/ferga_lessons.json", $token), 0, 800) . "\n";
