<?php

// Restore full ferga_languages data.
// The language nodes were found to contain only `locked` — the definition
// fields (name/desc/color/logo) had been wiped. We rebuild them here.
// ID -> language mapping was verified against ferga_lessons.langId.

$token = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
if (!$token) { echo "ERROR: token missing. Run get_firebase_token.php first.\n"; exit(1); }
$base = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';

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

$languages = [
    '-OypFoFNvHfBuaA2Uh7O' => [
        'name_so' => 'Python', 'name_ba' => 'Python',
        'desc_so' => 'زمانێکی سادە و خوێندنەوەی ئاسانە بۆ دەستپێکەران، بەکاردێت لە وێب، زانستی داتا و زیرەکی دەستکرد.',
        'desc_ba' => 'زمانەکەکێ هەسا و خوێندنەوە وەساانە ژبو دەستپێکەران، بکارئینان ل وێب، زانستا داتایان و ئاقلی دەسکرد.',
        'ext' => 'py', 'color' => 'bg-blue-100', 'logo_url' => '/python-logo.svg', 'locked' => false,
    ],
    '-Oyrqajy5loFSFBPUgNi' => [
        'name_so' => 'C++', 'name_ba' => 'C++',
        'desc_so' => 'زمانێکی بەهێزە بۆ پرۆگرامی سیستەم و یارییەکان، خێرا و کۆنترۆڵی تەواوی سەر کۆمپیوتەر.',
        'desc_ba' => 'زمانەکەکێ بهێزە ژبو بەرنامەکرنا سیستەمان و لیستا، لەز و کۆنترۆلا تمام یا سەر کۆمپیوتەری.',
        'ext' => 'cpp', 'color' => 'bg-indigo-100', 'logo_url' => '/cpp-logo.svg', 'locked' => false,
    ],
    '-OysGzUzKG67KcswHXn2' => [
        'name_so' => 'C#', 'name_ba' => 'C#',
        'desc_so' => 'زمانێکی مۆدێرنە لەلایەن مایکرۆسۆفتەوە، بەکارهێنانی زۆرە لە دروستکردنی ئەپلیکەیشن و یاری.',
        'desc_ba' => 'زمانەکەکێ مۆدێرنە ژ لای مایکرۆسۆفت، بکارئینانا زاف ل دروستکرنا بەرنامان و لیستا.',
        'ext' => 'cs', 'color' => 'bg-purple-100', 'logo_url' => '/csharp-logo.svg', 'locked' => true,
    ],
    '-OysGzfS5Qi08XHYs_FL' => [
        'name_so' => 'Rust', 'name_ba' => 'Rust',
        'desc_so' => 'زمانێکی نوێ و پارێزراوە کە بە ناوبەنگی خێرایی و سەلامەتی ناسراوە، بۆ سیستەم و وێب.',
        'desc_ba' => 'زمانەکەکێ نوی و پاراستییە، ب ناڤناڤا لەزی و ئەمنییێ ناساییە، ژبو سیستەمان و وێب.',
        'ext' => 'rs', 'color' => 'bg-orange-100', 'logo_url' => '/rust-logo.svg', 'locked' => true,
    ],
    '-OysQq7E9B4bBLuGjUEX' => [
        'name_so' => 'HTML + CSS', 'name_ba' => 'HTML + CSS',
        'desc_so' => 'بنەماکانی دروستکردنی وێبپەڕە — HTML بۆ پێکهاتە و CSS بۆ جوانی، بە یەکەوە وێبپەڕەی جوان دروست دەکەن.',
        'desc_ba' => 'بنەمایێن دروستکرنا مالپەران — HTML ژبو پێکهاتان و CSS ژبو دڵخوشییێ، پێکڤە مالپەرێن جوان چێدکەن.',
        'ext' => 'html+css', 'color' => 'bg-orange-100', 'logo_url' => '/html-css-logo.svg', 'locked' => false,
    ],
    '-Oysj44hJLXDgdp-b9iN' => [
        'name_so' => 'PHP', 'name_ba' => 'PHP',
        'desc_so' => 'زمانێکە بۆ سەرڤەر و پشتەوەی وێب، بەکاردێت بۆ دروستکردنی سایتە داینامیکییەکان.',
        'desc_ba' => 'زمانەکەکە ژبو سێرڤەر و پشتەوایا وێبێ، بکارئینان ژبو دروستکرنا مالپەرێن داینامیک.',
        'ext' => 'php', 'color' => 'bg-indigo-100', 'logo_url' => '/php-logo.svg', 'locked' => true,
    ],
    '-Oysj4DmsfjAe6mjjfjT' => [
        'name_so' => 'Java', 'name_ba' => 'Java',
        'desc_so' => 'زمانێکی بەناوبانگە و سەربەخۆی سەکۆیە، بەکاردێت لە ئەپلیکەیشنی ئەندرۆید و سیستەمە گەورەکان.',
        'desc_ba' => 'زمانەکەکێ ناڤدار و سەربەخۆی پلاتفۆرمێ، بکارئینان ل بەرنامەن ئەندرۆید و سیستەمێن مەزن.',
        'ext' => 'java', 'color' => 'bg-red-100', 'logo_url' => '/java-logo.svg', 'locked' => true,
    ],
    '-Oysj4NVk0PGRLQx2Z8o' => [
        'name_so' => 'JavaScript', 'name_ba' => 'JavaScript',
        'desc_so' => 'زمانی وێبی مۆدێرنە بۆ ئەپلیکەیشنی کارلێککەر، کاردەکات لە وێبگەڕدا و لە سەرڤەر (Node).',
        'desc_ba' => 'زمانێ وێبێ مۆدێرن ژبو بەرنامێن کارلێککەر، کاردکەت د براوزەرێ و سەر سێرڤەری (Node).',
        'ext' => 'js', 'color' => 'bg-yellow-100', 'logo_url' => '/javascript-logo.svg', 'locked' => true,
    ],
];

$res = fbReq("$base/ferga_languages.json", $token, 'PUT', json_encode($languages));
$check = json_decode($res, true);
if (!$check) { echo "ERROR: PUT failed\n$res\n"; exit(1); }
foreach ($check as $id => $l) {
    echo sprintf("%-24s name=%-14s ext=%-9s locked=%s logo=%s\n",
        $id, $l['name_so'], $l['ext'], $l['locked'] ? 'true ' : 'false', $l['logo_url'] ?: '-');
}
echo "Restored " . count($check) . " languages.\n";
