<?php

$db = "https://ai-platform-adb1b-default-rtdb.firebaseio.com";
$token = trim(file_get_contents("/tmp/opencode/fb_token.txt"));

$d = json_decode(file_get_contents("/tmp/opencode/ferga_full.json"), true);

$fields = ["title_so", "title_ba", "content_so", "content_ba", "code", "example_output", "challenge_desc_so", "challenge_desc_ba"];

$patched = 0;
foreach ($d as $id => $l) {
    $changed = false;
    foreach ($fields as $f) {
        if (!isset($l[$f])) continue;
        $t = $l[$f];
        if (str_contains($t, "\\n") || str_contains($t, "\\\"") || str_contains($t, "\\t")) {
            $t2 = str_replace("\\n", "\n", $t);
            $t2 = str_replace('\\"', '"', $t2);
            $t2 = str_replace("\\t", "\t", $t2);
            if ($t2 !== $t) {
                $l[$f] = $t2;
                $changed = true;
            }
        }
    }
    if ($changed) {
        $ch = curl_init("$db/ferga_lessons/$id.json?auth=$token");
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => json_encode($l, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        $patched++;
        echo "patched $id (order {$l["order"]})\n";
    }
}
echo "done: $patched lessons patched\n";
