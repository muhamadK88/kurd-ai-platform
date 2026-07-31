<?php

// Script to merge the HTML and CSS courses into one "HTML + CSS" course in Ferga.
// - Creates a new language "HTML + CSS" (ext = html+css)
// - Copies HTML lessons first (order 1..40), code stays as HTML
// - Copies CSS lessons after (order 41..80), code becomes a generic HTML demo,
//   and the original CSS goes into the new `code_css` field.
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
if (!$idToken) {
    echo "ERROR: Firebase ID token not found at /tmp/opencode/fb_token.txt\n";
    exit(1);
}

function fbAuth($ch) {
    global $idToken;
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $idToken,
    ]);
}

function fbGet($path) {
    global $firebaseUrl;
    $ch = curl_init($firebaseUrl . $path . '.json');
    fbAuth($ch);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

function fbPost($path, $data) {
    global $firebaseUrl;
    $ch = curl_init($firebaseUrl . $path . '.json');
    fbAuth($ch);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// Generic HTML demo used as `code` for lessons that originally came from the CSS course
$cssDemoHtml = "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"UTF-8\">\n</head>\n<body>\n<h1 class=\"demo-h1\">Kurd AI - CSS Preview</h1>\n<p class=\"demo-p\">This is a sample paragraph. Write your CSS and watch it apply to these elements.</p>\n<div class=\"demo-box\">Box 1</div>\n<div class=\"demo-box\">Box 2</div>\n<button class=\"demo-btn\">Click Me</button>\n</body>\n</html>";

// 1. Load languages and lessons
$langs = fbGet('ferga_languages');
$lessons = fbGet('ferga_lessons');
if (!$langs || !$lessons) {
    echo "ERROR: could not read Firebase data (langs=" . json_encode($langs) . ", lessons=" . json_encode($lessons) . ")\n";
    exit(1);
}

$htmlLangId = null;
$cssLangId = null;
foreach ($langs as $id => $l) {
    $name = ($l['name_so'] ?? $l['name'] ?? '');
    if (strpos(strtolower($name), 'html') !== false && strpos(strtolower($name), 'css') === false) {
        $htmlLangId = $id;
    }
    if (strpos(strtolower($name), 'css') !== false && strpos(strtolower($name), 'html') === false) {
        $cssLangId = $id;
    }
    if ($htmlLangId && $cssLangId) break;
}
if (!$htmlLangId || !$cssLangId) {
    echo "ERROR: could not find HTML ($htmlLangId) and CSS ($cssLangId) languages\n";
    exit(1);
}
echo "HTML language: $htmlLangId\n";
echo "CSS language: $cssLangId\n";

// 2. Create the combined language
$langRes = fbPost('ferga_languages', [
    'name_so' => 'HTML + CSS',
    'name_ba' => 'HTML + CSS',
    'desc_so' => 'HTML زمانەکەی پێکهاتەی وێبە و CSS زمانەکەی دیمەن و جوانکارییە. لەم کۆرسەدا هەردووکیان پێکەوە فێردەبیت: یەکەم HTML بۆ دروستکردنی پێکهاتەی پەڕە، پاشان CSS بۆ جوانکردنی.',
    'desc_ba' => 'HTML زمانێ پێکهاتا وێبێ یە و CSS زمانێ دیمەن و جوانکارییێ یە. د ڤێ کورسێ دا هەردووکا پێکڤە فێر دبی: پێشی HTML بو دروستکرنا پێکهاتا پەڕێ، پاشی CSS بو جوانکرنا وی.',
    'ext' => 'html+css',
    'color' => 'from-orange-500 to-purple-500',
    'logo_url' => 'https://i.ibb.co/3f2jZYk/html-css-logo.png',
]);
if (!isset($langRes['name'])) {
    echo "ERROR: could not create combined language\n" . json_encode($langRes) . "\n";
    exit(1);
}
$newLangId = $langRes['name'];
echo "Combined language created: $newLangId\n";

// 3. Copy HTML lessons first (HTML taught first)
$htmlLessons = array_filter($lessons, fn($l) => ($l['langId'] ?? '') === $htmlLangId);
usort($htmlLessons, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));

$order = 0;
foreach ($htmlLessons as $lesson) {
    $order++;
    $lesson['langId'] = $newLangId;
    $lesson['order'] = $order;
    $lesson['code_css'] = '';
    $res = fbPost('ferga_lessons', $lesson);
    if (isset($res['name'])) {
        echo "HTML lesson copied: " . ($lesson['title_so'] ?? '?') . " -> {$res['name']}\n";
    } else {
        echo "ERROR copying HTML lesson " . ($lesson['title_so'] ?? '?') . ": " . json_encode($res) . "\n";
    }
}

// 4. Copy CSS lessons after (CSS taught second)
$cssLessons = array_filter($lessons, fn($l) => ($l['langId'] ?? '') === $cssLangId);
usort($cssLessons, fn($a, $b) => ($a['order'] ?? 0) <=> ($b['order'] ?? 0));

$baseOrder = $order; // HTML count
foreach ($cssLessons as $lesson) {
    $order++;
    $cssCode = $lesson['code'] ?? '';
    $lesson['langId'] = $newLangId;
    $lesson['order'] = $order;
    $lesson['code'] = $cssDemoHtml;
    $lesson['code_css'] = $cssCode;
    $res = fbPost('ferga_lessons', $lesson);
    if (isset($res['name'])) {
        echo "CSS lesson copied: " . ($lesson['title_so'] ?? '?') . " -> {$res['name']}\n";
    } else {
        echo "ERROR copying CSS lesson " . ($lesson['title_so'] ?? '?') . ": " . json_encode($res) . "\n";
    }
}

echo "\nDone! Merged {$baseOrder} HTML lessons + " . ($order - $baseOrder) . " CSS lessons into the \"HTML + CSS\" course.\n";
