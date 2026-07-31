<?php

// Appends a per-line explained code box (like C++ L2/L3) to every lesson content
// that doesn't already have one, in both dialects.

$db = "https://ai-platform-adb1b-default-rtdb.firebaseio.com";
$token = trim(file_get_contents("/tmp/opencode/fb_token.txt"));
$d = json_decode(file_get_contents("/tmp/opencode/ferga_full.json"), true);

$markers = [
    "-OypFoFNvHfBuaA2Uh7O" => "#",                 // Python
    "-Oyrqajy5loFSFBPUgNi" => "//",                // C++
    "-OyrwFN0avjq2hhlCRO5" => "html",              // HTML
    "-OyrwFaGbQ7K-1QnzHvq" => "/*",                // CSS
];

function hasExplainedBox($content) {
    preg_match_all("/<pre>(.*?)<\/pre>/s", $content, $m);
    foreach ($m[1] as $pre) {
        $lines = array_filter(array_map("trim", explode("\n", html_entity_decode($pre))), fn($x) => $x !== "");
        if (count($lines) === 0) continue;
        $commented = 0;
        foreach ($lines as $ln) if (preg_match("/(\/\/|#|\/\*|<!--)/", $ln)) $commented++;
        if ($commented === count($lines)) return true;
    }
    return false;
}

function esc($s) { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"); }

function buildBox($code, $exps, $marker) {
    $lines = explode("\n", rtrim($code, "\n"));
    $out = "";
    foreach ($lines as $i => $line) {
        $exp = $exps[$i] ?? "";
        if (trim($line) === "") { $out .= "\n"; continue; }
        $codeEsc = esc($line);
        if ($exp === "") { $out .= $codeEsc . "\n"; continue; }
        // alignment: pad code column (estimate entity width)
        $visLen = strlen(html_entity_decode($line, ENT_QUOTES | ENT_HTML5, "UTF-8"));
        $pad = $visLen < 44 ? max(2, 44 - $visLen) : 1;
        if ($marker === "#" || $marker === "//") {
            $out .= $codeEsc . str_repeat(" ", $pad) . $marker . " " . $exp . "\n";
        } elseif ($marker === "/*") {
            $out .= $codeEsc . str_repeat(" ", $pad) . "/* " . $exp . " */\n";
        } else { // html
            $out .= $codeEsc . str_repeat(" ", $pad) . "&lt;!-- " . $exp . " --&gt;\n";
        }
    }
    return "<pre>" . $out . "</pre>";
}

$patched = 0;
foreach ($d as $id => $l) {
    $changed = false;
    $marker = $markers[$l["langId"]] ?? null;
    if (!$marker) continue;

    $code = $l["code"] ?? "";
    if (trim($code) === "") continue;

    $needsSo = !hasExplainedBox($l["content_so"] ?? "");
    $needsBa = !hasExplainedBox($l["content_ba"] ?? "");

    // fix corrupted line in CPP L2 content_so
    $fixes = [
        "doubleتە بەڵام bool b = true; // ڕاست یان هەڵە" => "bool b = true;       // ڕاست یان هەڵە",
    ];
    foreach ($fixes as $bad => $good) {
        if (str_contains($l["content_so"] ?? "", $bad)) {
            $l["content_so"] = str_replace($bad, $good, $l["content_so"]);
            $needsSo = false;
            $changed = true;
        }
    }

    $introSo = "<p><strong>ڕوونکردنەوەی کۆدەکە هێل ب هێل:</strong></p>";
    $introBa = "<p><strong>ڕوونکردنەوە یا کۆدی هێل ب هێل:</strong></p>";

    if ($needsSo) {
        $l["content_so"] .= $introSo . buildBox($code, $l["code_explain_so"] ?? [], $marker);
        $changed = true;
    }
    if ($needsBa) {
        $l["content_ba"] .= $introBa . buildBox($code, $l["code_explain_ba"] ?? [], $marker);
        $changed = true;
    }

    if ($changed) {
        $ch = curl_init("$db/ferga_lessons/$id.json?auth=$token");
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => json_encode($l, JSON_UNESCAPED_UNICODE),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
            CURLOPT_TIMEOUT => 60,
        ]);
        curl_exec($ch);
        curl_close($ch);
        echo "patched L{$l["order"]} [{$l["langId"]}] so:" . ($needsSo ? "box" : "no") . " ba:" . ($needsBa ? "box" : "no") . "\n";
    }
}
echo "done, patches: $patched\n";
