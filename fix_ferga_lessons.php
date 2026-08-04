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

echo "Processing ferga_lessons...\n";
$json = file_get_contents($firebaseUrl . 'ferga_lessons.json');
$items = json_decode($json, true);
if (is_array($items)) {
    $mh = curl_multi_init();
    $channels = [];
    $count = 0;

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
            }
        }

        if ($updates) {
            $ch = curl_init($firebaseUrl . 'ferga_lessons/' . $id . '.json');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($updates));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_multi_add_handle($mh, $ch);
            $channels[$id] = $ch;
            $count++;

            // Process in batches of 30 to avoid overwhelming multi-curl
            if ($count >= 30) {
                do {
                    $status = curl_multi_exec($mh, $active);
                    curl_multi_select($mh);
                } while ($active && $status == CURLM_OK);

                foreach ($channels as $cid => $cch) {
                    curl_multi_remove_handle($mh, $cch);
                    curl_close($cch);
                }
                $channels = [];
                $count = 0;
            }
        }
    }

    // Remaining
    if ($channels) {
        do {
            $status = curl_multi_exec($mh, $active);
            curl_multi_select($mh);
        } while ($active && $status == CURLM_OK);

        foreach ($channels as $cid => $cch) {
            curl_multi_remove_handle($mh, $cch);
            curl_close($cch);
        }
    }
    curl_multi_close($mh);
    echo "Completed ferga_lessons successfully!\n";
}
