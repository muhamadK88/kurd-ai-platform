<?php

// Add challenges (Test) to HTML lessons in Firebase
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-OyrwFN0avjq2hhlCRO5';

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

$text = fn($v) => [['t' => 'text', 'v' => $v]];
$attr = fn($s, $a, $v) => [['t' => 'attr', 's' => $s, 'a' => $a, 'v' => $v]];

$challenges = [
    1  => ['سەرنووسەیەک زیاد بکە کە بنووسێت: Ez Kurd im!', 'سەردێڕەکەکا زیاد بکە کو بنڤیسیت: Ez Kurd im!', $text('Ez Kurd im!')],
    2  => ['پاراگرافێک زیاد بکە کە بڵێت: Naveroka min', 'پاراگرافەکەکا زیاد بکە کو بێژیت: Naveroka min', $text('Naveroka min')],
    3  => ['سەرنووسەی h2 زیاد بکە بە: Kursa min', 'سەردێڕا h2 زیاد بکە ب: Kursa min', $text('Kursa min')],
    4  => ['دەقێکی تۆخ (<b>) زیاد بکە: Giring', 'نڤیسینەکا تۆخ (<b>) زیاد بکە: Giring', $text('Giring')],
    5  => ['لینکێک زیاد بکە بۆ https://kurd-ai.com بە دەقی: Serdana Kurd AI', 'گرێدانەکەکا زیاد بکە بو https://kurd-ai.com ب دەقا: Serdana Kurd AI', array_merge($text('Serdana Kurd AI'), $attr('a', 'href', 'kurd-ai.com'))],
    6  => ['وێنەیەک زیاد بکە بە alt ی: Alaya Kurdistan', 'وێنەکەکا زیاد بکە پێ altا: Alaya Kurdistan', $attr('img', 'alt', 'Alaya')],
    7  => ['بەندی لیست زیاد بکە: Kotlin', 'بەندەکا لیستێ زیاد بکە: Kotlin', $text('Kotlin')],
    8  => ['ڕیزێک زیاد بکە بە نمرەی: 100', 'ڕیزەکەکا زیاد بکە ب نمرەیا: 100', $text('100')],
    9  => ['ئەتریبیوتی title بۆ پاراگرافێک زیاد بکە بە: Kurs', 'ئەتریبیوتا title بو پاراگرافەکەکا زیاد بکە ب: Kurs', $attr('p', 'title', 'Kurs')],
    10 => ['خانەیەکی input زیاد بکە بە placeholder ی: Navê te', 'خانەیا input زیاد بکە ب placeholderا: Navê te', $attr('input', 'placeholder', 'Navê te')],
    11 => ['ڕادیۆیەکی نوێ زیاد بکە بە value ی: din', 'ڕادیۆەکا نوی زیاد بکە ب valueا: din', $attr('input[type=radio]', 'value', 'din')],
    12 => ['بژاردەیەک زیاد بکە: Hewlamb', 'هەلبژارتنەکەکا زیاد بکە: Hewlamb', $text('Hewlamb')],
    13 => ['لینکی نوێ زیاد بکە لە ناڤیگەیشن: Kurs', 'گرێدانەکا نوی زیاد بکە د ناڤیگەیشنێ دا: Kurs', $text('Kurs')],
    14 => ['سەرچاوەی ڤیدیۆکە بگۆڕە بۆ: movie.mp4', 'چاڤکانیا ڤیدیۆیێ بگوهۆرە بو: movie.mp4', $attr('video', 'src', 'movie.mp4')],
    15 => ['ئەتریبیوتی title بۆ ئایفڕەیم: Vîdyoya fêrbûnê', 'ئەتریبیوتا title بو ئایفڕەیم: Vîdyoya fêrbûnê', $attr('iframe', 'title', 'Vîdyoya')],
    16 => ['data-temen بگۆڕە بۆ: 30', 'data-temen بگوهۆرە بو: 30', $attr('div', 'data-temen', '30')],
    17 => ['span یەک زیاد بکە بە کلاسی nav و دەقی: Kurd', 'spanەکەکا زیاد بکە پێ کلاسا nav و دەقا: Kurd', array_merge($text('Kurd'), $attr('span', 'class', 'nav'))],
    18 => ['پاراگرافێک زیاد بکە بە lang ی: en', 'پاراگرافەکەکا زیاد بکە پێ langا: en', $attr('p', 'lang', 'en')],
    19 => ['ئینپوتی جۆری month زیاد بکە', 'ئینپوتا چەشنێ month زیاد بکە', $attr('input', 'type', 'month')],
    20 => ['مێتایەک زیاد بکە: name="keywords" بە ناوەڕۆکی HTML', 'مێتایەکەکا زیاد بکە: name="keywords" ب ناڤەرۆکا HTML', $attr('meta[name=keywords]', 'content', 'HTML')],
    21 => ['چوارگۆشەیەکی تر زیاد بکە لە SVG دا', 'چوارگۆشەکا دی زیاد بکە د SVG دا', [['t' => 'count', 's' => 'rect', 'min' => 2]]],
    22 => ['فیلدستی نوێ زیاد بکە بە لیجێندی: Navnîşan', 'فیلدستەکا نوی زیاد بکە پێ لیجێندا: Navnîşan', $text('Navnîşan')],
    23 => ['لینکی نوێ زیاد بکە: Projeyên me', 'گرێدانەکا نوی زیاد بکە: Projeyên me', $text('Projeyên me')],
    24 => ['aria-label زیاد بکە بۆ input: navê te', 'aria-label زیاد بکە بو input: navê te', $attr('input', 'aria-label', 'navê te')],
    25 => ['تاقی bdo زیاد بکە بە dir ی: rtl', 'تاگا bdo زیاد بکە پێ dirا: rtl', $attr('bdo', 'dir', 'rtl')],
    26 => ['بژاردەیەک زیاد بکە: Zaxo', 'هەلبژارتنەکەکا زیاد بکە: Zaxo', $text('Zaxo')],
    27 => ['ئینپوتی جۆری password زیاد بکە', 'ئینپوتا چەشنێ password زیاد بکە', $attr('input', 'type', 'password')],
    28 => ['بەشێک زیاد بکە بە ناوی شارەکەت: Silêmanî', 'بەشەکەکا زیاد بکە ب ناڤێ باجەرێ خوە: Silêmanî', $text('Silêmanî')],
    29 => ['بابەتێک زیاد بکە دەربارەی: JavaScript', 'بابەتەکەکا زیاد بکە دەربارە: JavaScript', $text('JavaScript')],
    30 => ['خانەیەکی telephone زیاد بکە', 'خانەیا telephone زیاد بکە', $attr('input', 'type', 'tel')],
    31 => ['وێنەیەک زیاد بکە بە وەسفی: Çiyayê Sindî', 'وێنەکەکا زیاد بکە ب وەسفا: Çiyayê Sindî', $text('Sindî')],
    32 => ['ڕیزێک زیاد بکە بۆ کۆرسی: Kotlin', 'ڕیزەکەکا زیاد بکە بو کورسا: Kotlin', $text('Kotlin')],
    33 => ['بەشی مێنوو زیاد بکە بە: Kubba', 'بەشا مێنوویێ زیاد بکە پێ: Kubba', $text('Kubba')],
    34 => ['خۆراکێک زیاد بکە: Şerbet', 'خوارنەکەکا زیاد بکە: Şerbet', $text('Şerbet')],
    35 => ['کورسێک زیاد بکە: JavaScript', 'کورسەکەکا زیاد بکە: JavaScript', $text('JavaScript')],
    36 => ['بابەتێکی وەرزشی زیاد بکە: Sport', 'بابەتەکا وەرزشی زیاد بکە: Sport', $text('Sport')],
    37 => ['کارێک زیاد بکە بە وێنەی alt: Projeya 4', 'کارەکەکا زیاد بکە پێ وێنەیا alt: Projeya 4', $attr('img', 'alt', 'Projeya 4')],
    38 => ['کارتی زمان زیاد بکە: JavaScript', 'کارتەکا زمانێ زیاد بکە: JavaScript', $text('JavaScript')],
    39 => ['دەرسێک زیاد بکە: Fonksiyon', 'دەرسەکەکا زیاد بکە: Fonksiyon', $text('Fonksiyon')],
    40 => ['بەشێک زیاد بکە بە ناوی شارەکەت: Hewlêr', 'بەشەکەکا زیاد بکە ب ناڤێ باجەرێ خوە: Hewlêr', $text('Hewlêr')],
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
echo "Updated $count HTML lessons\n";
