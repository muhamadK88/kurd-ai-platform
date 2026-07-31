<?php

// Add challenges (Test) to CSS lessons in Firebase
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-OyrwFaGbQ7K-1QnzHvq';

function fbPatch($url, $data) {
    global $idToken;
    $ch = curl_init($url . '?auth=' . urlencode($idToken));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

$style = fn($s, $p, $v) => [['t' => 'style', 's' => $s, 'p' => $p, 'v' => $v]];
$styled = fn($s, $p) => [['t' => 'styled', 's' => $s, 'p' => $p]];

$challenges = [
    1  => ['دەقی .demo-p بکە بە ڕەنگی سەوز (#008000)', 'دەقا .demo-p بکە ب ڕەنگا سەوز (#008000)', $style('.demo-p', 'color', '#008000')],
    2  => ['پاشبنەمای .demo-box بکە بە سور (#ff0000)', 'بنگەهێ .demo-box بکە ب سور (#ff0000)', $style('.demo-box', 'background-color', '#ff0000')],
    3  => ['پاشبنەمای body بکە بە شینی ڕووناک (#e3f2fd)', 'بنگەهێ body بکە ب شینا ڕوون (#e3f2fd)', $style('body', 'background-color', '#e3f2fd')],
    4  => ['قەبارەی .demo-h1 بکە بە 40px', 'قەبارا .demo-h1 بکە ب 40px', $style('.demo-h1', 'font-size', '40px')],
    5  => ['چوارچێوەی 2px بۆ .demo-box', 'چوارچێوەیەکا 2px بو .demo-box', $style('.demo-box', 'border-width', '2px')],
    6  => ['بۆشایی ناوەوەی 30px بۆ .demo-box', 'بۆشاییا ناڤخی 30px بو .demo-box', $style('.demo-box', 'padding', '30px')],
    7  => ['گۆشەی .demo-btn بکە بە بازنەیی (50%)', 'گۆشەیا .demo-btn بکە ب بازنەیی (50%)', $style('.demo-btn', 'border-radius', '50%')],
    8  => ['قەبارەی .demo-p بکە بە 2rem', 'قەبارا .demo-p بکە ب 2rem', $style('.demo-p', 'font-size', '2rem')],
    9  => ['گرادینت بۆ پاشبنەمای .demo-box زیاد بکە', 'گرادینتەکا بو بنگەهێ .demo-box زیاد بکە', $styled('.demo-box', 'background-image')],
    10 => ['.demo-box بکە بە inline-block', '.demo-box بکە ب inline-block', $style('.demo-box', 'display', 'inline-block')],
    11 => ['.demo-btn بکە بە fixed', '.demo-btn بکە ب fixed', $style('.demo-btn', 'position', 'fixed')],
    12 => ['.demo-h1 بکە بە flex', '.demo-h1 بکە ب flex', $style('.demo-h1', 'display', 'flex')],
    13 => ['body بکە بە grid', 'body بکە ب grid', $style('body', 'display', 'grid')],
    14 => ['ناوەڕۆکی زیادەی .demo-p بشارەوە (hidden)', 'ناڤەرۆکا زێدەیی .demo-p ڤەشارە (hidden)', $style('.demo-p', 'overflow', 'hidden')],
    15 => ['سێبەر بۆ .demo-box زیاد بکە', 'سێبەرەکا بو .demo-box زیاد بکە', $styled('.demo-box', 'box-shadow')],
    16 => ['ترانزیشن بۆ .demo-btn زیاد بکە', 'ترانزیشنەکا بو .demo-btn زیاد بکە', $styled('.demo-btn', 'transition-duration')],
    17 => ['گۆڕینێک (transform) بۆ .demo-btn زیاد بکە', 'گوهۆرینەکا (transform) بو .demo-btn زیاد بکە', $styled('.demo-btn', 'transform')],
    18 => ['ئەنیمەیشن بۆ .demo-btn زیاد بکە', 'ئەنیمەیشنەکا بو .demo-btn زیاد بکە', $styled('.demo-btn', 'animation-name')],
    19 => ['یەکەم .demo-box ڕەنگ بکە بە سور (#ff0000)', 'یەکێکا یەکێ .demo-box ڕەنگ کە ب سور (#ff0000)', $style('.demo-box', 'background-color', '#ff0000')],
    20 => ['ناوەڕۆکی ::after بۆ .demo-btn: OK', 'ناڤەرۆکا ::after بو .demo-btn: OK', $style('.demo-btn::after', 'content', 'OK')],
    21 => ['فۆنتی Poppins بۆ .demo-btn بەکاربهێنە', 'فۆنتا Poppins بو .demo-btn بکاربینی', $style('.demo-btn', 'font-family', 'Poppins')],
    22 => ['ڤاریەیبڵی --primary بکە بە #ff0000', 'گۆڕۆکا --primary بکە ب #ff0000', [['t' => 'var', 'n' => '--primary', 'v' => '#ff0000']]],
    23 => ['مێدیا کوێریەک زیاد بکە بە 600px', 'مێدیا کوێریەکەکا زیاد بکە پێ 600px', [['t' => 'media', 'v' => '600px']]],
    24 => ['.demo-btn بکە بە flex', '.demo-btn بکە ب flex', $style('.demo-btn', 'display', 'flex')],
    25 => ['گۆشەی .demo-btn بکە بە 25px', 'گۆشەیا .demo-btn بکە ب 25px', $style('.demo-btn', 'border-radius', '25px')],
    26 => ['body بکە بە flex و ناوەند بکە', 'body بکە ب flex و ناڤەند کە', array_merge($style('body', 'display', 'flex'), $style('body', 'justify-content', 'center'))],
    27 => ['مێدیا کوێریەک زیاد بکە بۆ prefers-color-scheme: light', 'مێدیا کوێریەکەکا زیاد بکە بو prefers-color-scheme: light', [['t' => 'media', 'v' => 'light']]],
    28 => ['گۆشەی .demo-box بکە بە 20px', 'گۆشەیا .demo-box بکە ب 20px', $style('.demo-box', 'border-radius', '20px')],
    29 => ['بۆشایی ناوەوەی 15px بۆ .demo-btn', 'بۆشاییا ناڤخی 15px بو .demo-btn', $style('.demo-btn', 'padding', '15px')],
    30 => ['ڕەنگی .demo-h1 بکە بە سپی (#ffffff) و ناوەند', 'ڕەنگا .demo-h1 بکە ب سپی (#ffffff) و ناڤەند', array_merge($style('.demo-h1', 'color', '#ffffff'), $style('.demo-h1', 'text-align', 'center'))],
    31 => ['گرادینت بۆ .demo-btn زیاد بکە', 'گرادینتەکا بو .demo-btn زیاد بکە', $styled('.demo-btn', 'background-image')],
    32 => ['.demo-box بکە بە grid', '.demo-box بکە ب grid', $style('.demo-box', 'display', 'grid')],
    33 => ['قەبارەی .demo-h1 بکە بە 48px', 'قەبارا .demo-h1 بکە ب 48px', $style('.demo-h1', 'font-size', '48px')],
    34 => ['پانی .demo-p بکە بە 600px', 'پانیا .demo-p بکە ب 600px', $style('.demo-p', 'max-width', '600px')],
    35 => ['ڕەنگی .demo-btn بکە بە شینی تۆخ (#1565c0)', 'ڕەنگا .demo-btn بکە ب شینا تۆخ (#1565c0)', $style('.demo-btn', 'background-color', '#1565c0')],
    36 => ['.demo-box بکە بە relative', '.demo-box بکە ب relative', $style('.demo-box', 'position', 'relative')],
    37 => ['ڕەنگی .demo-p بکە بە خۆڵەمێشی (#607d8b)', 'ڕەنگا .demo-p بکە ب خۆلەمێشی (#607d8b)', $style('.demo-p', 'color', '#607d8b')],
    38 => ['گۆشەی .demo-btn بکە بە 30px', 'گۆشەیا .demo-btn بکە ب 30px', $style('.demo-btn', 'border-radius', '30px')],
    39 => ['قەبارەی .demo-h1 بکە بە 46px', 'قەبارا .demo-h1 بکە ب 46px', $style('.demo-h1', 'font-size', '46px')],
    40 => ['قەبارەی .demo-p بکە بە 14px', 'قەبارا .demo-p بکە ب 14px', $style('.demo-p', 'font-size', '14px')],
];

$data = json_decode(file_get_contents($firebaseUrl . 'ferga_lessons.json'), true);
$count = 0;
foreach ($data as $id => $lesson) {
    if (($lesson['langId'] ?? '') !== $langId) continue;
    $order = (int)($lesson['order'] ?? 0);
    if (!isset($challenges[$order])) { echo "SKIP order $order\n"; continue; }
    [$so, $ba, $checks] = $challenges[$order];
    $res = fbPatch($firebaseUrl . 'ferga_lessons/' . $id . '.json', [
        'challenge_desc_so' => $so,
        'challenge_desc_ba' => $ba,
        'expected_output' => json_encode($checks),
    ]);
    if (json_decode($res, true) === null) { echo "ERROR $order: $res\n"; } else { $count++; }
}
echo "Updated $count CSS lessons\n";
