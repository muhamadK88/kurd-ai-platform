<?php

// Script to add HTML and CSS languages to the Ferga section in Firebase
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));

function fbPost($url, $data) {
    global $idToken;
    $ch = curl_init($url . '?auth=' . urlencode($idToken));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

$languages = [
    [
        'name_so' => 'HTML',
        'name_ba' => 'HTML',
        'desc_so' => 'HTML زمانی بنەڕەتی دروستکردنی وێبسایتە، پێکھاتە و پێکهاتەی هەموو پەڕەیەکی وێب پێ دروست دەکرێت. لەم کۆرسەدا فێری دروستکردنی وێبپەڕەی تەواو دەبیت.',
        'desc_ba' => 'HTML زمانی بنگەهیی دروستکرنا وێبسایتانە، پێکهاتە و ساختارا هەمی رووپەلەکا وێبێ پێ دەوربیت. د ڤێ کورسێ دا فێر دروستکرنا وێبپەڕەکا تەمام دبیت.',
        'ext' => 'html',
        'color' => 'from-orange-500 to-red-500',
        'logo_url' => 'https://i.ibb.co/TxzTB3pV/html5.png',
    ],
    [
        'name_so' => 'CSS',
        'name_ba' => 'CSS',
        'desc_so' => 'CSS بەکار دێت بۆ ڕازاندنەوە و جوانکردنی وێبپەڕەکان: ڕەنگ، ڕەوانە، نیوەگەلێکی (فۆنت)، و ڕووکار. بە CSS وێبپەڕەکان دەکەیتە جوانتر و گەشتر.',
        'desc_ba' => 'CSS بکارتیت بو ڕازاندن و جوانکرنا وێبپەڕان: ڕەنگ، لایێن، فۆنت و ڕوویک. پێ CSS وێبپەڕەیان دکەی جوانتر و گەشتر.',
        'ext' => 'css',
        'color' => 'from-blue-500 to-cyan-400',
        'logo_url' => 'https://i.ibb.co/LDXg09TC/css3.png',
    ],
];

foreach ($languages as $lang) {
    $res = fbPost($firebaseUrl . 'ferga_languages.json', $lang);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo $lang['name_so'] . " language created with ID: " . $d['name'] . "\n";
    } else {
        echo "ERROR creating " . $lang['name_so'] . ": $res\n";
    }
}
