<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';

function soraniToBadini($text) {
    if (!is_string($text) || $text === '') return $text;

    $phrases = [
        "بەخێربێیت" => "بەخێربێی",
        "کۆرسەکان" => "خولێن مە",
        "چوونەژوورەوە" => "چوونەژوورڤە",
        "بەخێر هاتن" => "بەخێربێی",
        "لەلاین" => "ژ ئالیێ",
        "لەلایەن" => "ژ ئالیێ",
        "کۆمپانیای" => "کۆمپانیا",
        "بەشێ" => "پشکێ",
        "بەشی" => "پشکا",
        "بەش" => "پشک",
        "زانیاری" => "پێزانین",
        "زانیارییەکانی" => "پێزانینێن",
        "دروستکردنی" => "چێکرنا",
        "بەکارهێنانی" => "بکارئینانا",
        "نووسینی" => "نڤیسینا",
        "خوێندنەوەی" => "خویندنا",
        "شیکارکردنی" => "شرۆڤەکرنا",
        "فێربوونی" => "فێربوونا",
        "خۆڕایی" => "ب بێ بەرانبەر",
        "بەخۆڕایی" => "ب بێ بەرانبەر",
        "ناونیشان" => "ناڤنیشان",
        "پێکەوە" => "پێکڤە",
        "کێشە" => "ئاریشە",
        "دەبێت" => "دڤێت",
        "دەکات" => "دکەت",
        "دەكات" => "دکەت",
        "دەکەن" => "دکەن",
        "چونکە" => "چونکو",
        "ئەگەر" => "هەکە",
        "توانایەکی" => "شیانەکا",
        "توانای" => "شیانێن",
        "ئەم" => "ئەمە",
        "ئەو" => "ئەڤە",
    ];

    foreach ($phrases as $so => $ba) {
        $text = str_ireplace($so, $ba, $text);
    }

    $particles = [
        " لە " => " ل ",
        " بە " => " ب ",
        " کە " => " کو ",
    ];
    foreach ($particles as $so => $ba) {
        $text = str_replace($so, $ba, $text);
    }

    return $text;
}

$nodes = ['courses', 'ai_tools', 'universities', 'academic_guide', 'ferga_quizzes', 'questions', 'ferga_lessons'];

foreach ($nodes as $node) {
    echo "Processing node: $node...\n";
    $json = file_get_contents($firebaseUrl . $node . '.json');
    $items = json_decode($json, true);
    if (!is_array($items)) continue;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $updatedCount = 0;
    foreach ($items as $id => $item) {
        if (!is_array($item)) continue;
        $updates = [];
        
        foreach ($item as $k => $v) {
            if (str_ends_with($k, '_ba')) {
                $soKey = str_replace('_ba', '_so', $k);
                if (isset($item[$soKey])) {
                    $soVal = $item[$soKey];
                    $converted = soraniToBadini($soVal);
                    if ($v === $soVal || $v === '' || $v === null) {
                        $updates[$k] = $converted;
                    } else {
                        $updates[$k] = soraniToBadini($v);
                    }
                }
            } elseif ($k === 'question_kmr' || $k === 'a_kmr' || $k === 'q_kmr') {
                $soKey = str_replace('_kmr', '_so', $k);
                if (isset($item[$soKey])) {
                    $updates[$k] = soraniToBadini($item[$soKey]);
                }
            }
        }

        if ($updates) {
            curl_setopt($ch, CURLOPT_URL, $firebaseUrl . $node . '/' . $id . '.json');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updates));
            curl_exec($ch);
            $updatedCount++;
        }
    }
    curl_close($ch);
    echo "Completed $node ($updatedCount items updated).\n";
}

echo "All Badini sections successfully updated and fixed across the entire website/database!\n";
