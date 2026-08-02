<?php

// Script to add CSS lessons 1-20 to the Ferga section in Firebase
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-OysQq7E9B4bBLuGjUEX';

function fbPost($url, $data) {
    global $idToken;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $idToken, 'Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function lesson($order, $level_so, $level_ba, $title_so, $title_ba, $content_so, $content_ba, $code) {
    return [
        'order' => $order,
        'level_so' => $level_so,
        'level_ba' => $level_ba,
        'title_so' => $title_so,
        'title_ba' => $title_ba,
        'content_so' => $content_so,
        'content_ba' => $content_ba,
        'code' => $code,
        'example_output' => '',
        'challenge_desc_so' => '',
        'challenge_desc_ba' => '',
        'expected_output' => '',
    ];
}

$lv1so = 'ئاستی ١ - بنەڕەتی CSS';
$lv1ba = 'ئاستا ١ - بنگەهێن CSS';
$lv2so = 'ئاستی ٢ - بۆکس و لایۆت';
$lv2ba = 'ئاستا ٢ - بۆکس و لایۆت';
$lv3so = 'ئاستی ٣ - پێشکەوتوو';
$lv3ba = 'ئاستا ٣ - پێشکەفتی';
$lv4so = 'ئاستی ٤ - پرۆژەکان';
$lv4ba = 'ئاستا ٤ - پروژە';

$lessons = [
    lesson(1, $lv1so, $lv1ba, 'ئاشنابوون بە CSS', 'ناساندن ب CSS',
        '<p><strong>CSS</strong> کورتکراوەی <bdi>Cascading Style Sheets</bdi> یە و بەکاردێت بۆ ڕازاندنەوەی HTML: ڕەنگ، فۆنت، بۆشایی و لایۆت.</p><p>سێ ڕێگە هەیە بۆ زیادکردنی CSS:</p><ul><li><bdi>inline</bdi> - ئەتریبیوتی style</li><li><bdi>&lt;style&gt;</bdi> لە ناو head</li><li>فایلی دەرەکی بە <bdi>&lt;link&gt;</bdi></li></ul><p>شێوازی نووسین: <bdi>selector { property: value; }</bdi></p>',
        '<p><strong>CSS</strong> کورتکراوەی <bdi>Cascading Style Sheets</bdi> یە و بکارتیت بو ڕازاندنا HTML: ڕەنگ، فۆنت، بۆشایی و لایۆت.</p><p>سێ ڕێگە هەن بو زیادکرنا CSS:</p><ul><li><bdi>inline</bdi> - ئەتریبیوتا style</li><li><bdi>&lt;style&gt;</bdi> د ناڤ head دا</li><li>پەڕگەیا دەرەکی پێ <bdi>&lt;link&gt;</bdi></li></ul><p>شێوازا نڤیسینێ: <bdi>selector { property: value; }</bdi></p>',
        "h1 {\n    color: #1a73e8;\n    text-align: center;\n    font-family: Arial;\n}\n\np {\n    font-size: 18px;\n    line-height: 1.6;\n    color: #333;\n}"),

    lesson(2, $lv1so, $lv1ba, 'سێلێکتەرەکان (Selectors)', 'سێلێکتەر (Selectors)',
        '<p>سێلێکتەر دیاری دەکات کام تاق ستایل دەکرێت:</p><ul><li><bdi>p</bdi> - بە ناوی تاق</li><li><bdi>.class</bdi> - بە کلاس</li><li><bdi>#id</bdi> - بە ئایدی</li><li><bdi>*</bdi> - هەموو تاقەکان</li><li><bdi>h1, h2</bdi> - چەند تاق بەیەکەوە</li></ul><p>بە کلاس زیادە و بە ئایدی تەنها یەک جار بەکاربهێنە.</p>',
        '<p>سێلێکتەر دیاری دکەت کا تاگ دەستێ ستایل دبیت:</p><ul><li><bdi>p</bdi> - پێ ناڤێ تاگی</li><li><bdi>.class</bdi> - پێ کلاسی</li><li><bdi>#id</bdi> - پێ ئایدییێ</li><li><bdi>*</bdi> - هەمی تاگ</li><li><bdi>h1, h2</bdi> - چەند تاگ پێکڤە</li></ul><p>کلاس بو چەندان و ئایدی تەنها یەک جار بکاربینی.</p>',
        ".card {\n    background: #fff;\n    border: 1px solid #ddd;\n    padding: 20px;\n}\n\n#sereki {\n    color: #e91e63;\n}\n\nh1, h2 {\n    font-family: Arial, sans-serif;\n}\n\n* {\n    box-sizing: border-box;\n}"),

    lesson(3, $lv1so, $lv1ba, 'ڕەنگ و بنەڕەتەکان', 'ڕەنگ و بنگەهێن',
        '<p>سێ شێوەی ڕەنگ لە CSS:</p><ul><li><bdi>red</bdi> - ناوی ڕەنگ</li><li><bdi>#ff0000</bdi> - HEX</li><li><bdi>rgb(255, 0, 0)</bdi> یان <bdi>rgba(255, 0, 0, 0.5)</bdi> - RGBA</li></ul><p>تایبەتمەندییەکانی ڕەنگ:</p><ul><li><bdi>color</bdi> - ڕەنگی دەق</li><li><bdi>background-color</bdi> - ڕەنگی پاشبنەما</li><li><bdi>opacity</bdi> - ڕەنگی سافر (٠-١)</li></ul><p>بۆ وێبئەکسیبلیتی، کۆنتراستی ڕەنگەکان دەبێت باش بێت.</p>',
        '<p>سێ شێوازێن ڕەنگێ د CSS دا:</p><ul><li><bdi>red</bdi> - ناڤێ ڕەنگی</li><li><bdi>#ff0000</bdi> - HEX</li><li><bdi>rgb(255, 0, 0)</bdi> یا <bdi>rgba(255, 0, 0, 0.5)</bdi> - RGBA</li></ul><p>تایبەتمەندییێن ڕەنگ:</p><ul><li><bdi>color</bdi> - ڕەنگا نڤیسینێ</li><li><bdi>background-color</bdi> - ڕەنگا بنگەهێ</li><li><bdi>opacity</bdi> - ڕەنگا ڕۆن (٠-١)</li></ul><p>بو وێبئەکسیبلیتی، کۆنتراستا ڕەنگان دڤێت باش بیت.</p>',
        "body {\n    background-color: #f0f4f8;\n}\n\nh1 {\n    color: #1565c0;\n}\n\np {\n    color: rgba(0, 0, 0, 0.8);\n}\n\n.highlight {\n    background-color: #fff176;\n    opacity: 0.9;\n}"),

    lesson(4, $lv1so, $lv1ba, 'دەق و فۆنت', 'نڤیسین و فۆنت',
        '<p>ستایلکردنی دەق لە CSS:</p><ul><li><bdi>font-family</bdi> - جۆری فۆنت</li><li><bdi>font-size</bdi> - قەبارە</li><li><bdi>font-weight</bdi> - تۆخی (bold)</li><li><bdi>font-style</bdi> - لار (italic)</li><li><bdi>text-align</bdi> - ئاراستە: center، right</li><li><bdi>line-height</bdi> - دووری هێڵەکان</li><li><bdi>text-decoration</bdi> - ژێرهێڵ</li></ul><p>بۆ دەقی کوردی، فۆنتێکی یونیکۆدی وەک Noto Naskh بەکاربهێنە.</p>',
        '<p>ستایلکرنا نڤیسینێ د CSS دا:</p><ul><li><bdi>font-family</bdi> - چەشنێ فۆنتی</li><li><bdi>font-size</bdi> - قەبارە</li><li><bdi>font-weight</bdi> - تۆخی (bold)</li><li><bdi>font-style</bdi> - لار (italic)</li><li><bdi>text-align</bdi> - ئاراستە: center، right</li><li><bdi>line-height</bdi> - دوریا خەتان</li><li><bdi>text-decoration</bdi> - خوارگرێدان</li></ul><p>بو نڤیسینا کوردی، فۆنتی یونیکۆدی وەک Noto Naskh بکاربینی.</p>',
        "body {\n    font-family: \"Noto Naskh Arabic\", Tahoma, sans-serif;\n}\n\nh1 {\n    font-size: 32px;\n    font-weight: bold;\n    text-align: center;\n}\n\np {\n    font-size: 18px;\n    line-height: 1.8;\n    text-align: right;\n}\n\n.italic {\n    font-style: italic;\n}\n\na {\n    text-decoration: none;\n    color: #1976d2;\n}"),

    lesson(5, $lv1so, $lv1ba, 'بۆکس مۆدێل (Box Model)', 'مۆدێلا بۆکسێ',
        '<p>هەموو تاقی HTML بۆکسێکە و چوار بەشی هەیە:</p><ul><li><bdi>content</bdi> - ناوەڕۆک</li><li><bdi>padding</bdi> - بۆشایی ناوەوە</li><li><bdi>border</bdi> - چوارچێوە</li><li><bdi>margin</bdi> - بۆشایی دەرەوە</li></ul><p>بە <bdi>box-sizing: border-box</bdi> قەبارەکە ڕێک دەبێت. ئەم یاسایە بە شێوەیەکی بەرفراوان لە سەرەتای هەموو پرۆژەیەکدا بەکاربهێنە.</p>',
        '<p>هەمی تاگێن HTML بۆکسەکەن و چوار بەشێن هەیە:</p><ul><li><bdi>content</bdi> - ناڤەرۆک</li><li><bdi>padding</bdi> - بۆشاییێ ناڤخی</li><li><bdi>border</bdi> - چوارچێوە</li><li><bdi>margin</bdi> - بۆشاییێ دەرڤەیی</li></ul><p>پێ <bdi>box-sizing: border-box</bdi> قەبارە ڕێک دبیت. ئەڤ یاسایە ب شێوەیەکا بەرفرەهان د سەرەتا هەمی پروژەیان دا بکاربینی.</p>',
        "*, *::before, *::after {\n    box-sizing: border-box;\n}\n\n.box {\n    width: 300px;\n    padding: 20px;\n    border: 2px solid #333;\n    margin: 15px auto;\n    background: #fff8e1;\n}"),

    lesson(6, $lv1so, $lv1ba, 'پەدینگ و مارجن', 'پەدینگ و مارجن',
        '<p><bdi>padding</bdi> بۆشایی ناوەوەی بۆکسەکە و <bdi>margin</bdi> بۆشایی دەرەوەیە:</p><pre>/* Çar alî */\npadding: 10px;\n\n/* Ser û bin | rast û çep */\npadding: 10px 20px;\n\n/* Ser | rast-çep | bin */\npadding: 10px 20px 5px;\n\n/* Ser | rast | bin | çep */\npadding: 10px 20px 5px 15px;</pre><p>بە <bdi>auto</bdi> لە margin بۆسەرەوەرتەوە بۆ ناوەند دەبێت.</p>',
        '<p><bdi>padding</bdi> بۆشاییێ ناڤخی بۆکسێ و <bdi>margin</bdi> بۆشاییێ دەرڤەیی یە:</p><pre>/* Çar alî */\npadding: 10px;\n\n/* Ser û bin | rast û çep */\npadding: 10px 20px;\n\n/* Ser | rast-çep | bin */\npadding: 10px 20px 5px;\n\n/* Ser | rast | bin | çep */\npadding: 10px 20px 5px 15px;</pre><p>پێ <bdi>auto</bdi> د margin دا بۆسەرەوەرتەوە دچیتە ناڤەند.</p>',
        ".container {\n    background: #e3f2fd;\n    padding: 30px;\n    margin: 20px auto;\n    max-width: 500px;\n}\n\n.card {\n    background: white;\n    padding: 20px 30px;\n    margin: 10px 0;\n    border-left: 4px solid #1976d2;\n}\n\n.card h3 {\n    margin: 0 0 8px 0;\n}"),

    lesson(7, $lv1so, $lv1ba, 'بۆردەر و ڕادیوس', 'بۆردەر و ڕادیوس',
        '<p><bdi>border</bdi> چوارچێوە دەکات لە دەوری بۆکسەکە:</p><pre>border: 2px solid #333;\nborder: 2px dashed red;\nborder-radius: 10px;  /* goşeya gerandî */\n</pre><p><bdi>border-radius</bdi> گۆشەکان دەخوات و بە <bdi>50%</bdi> بازنەیەکی تەواو دروست دەکات. هەروەها بە <bdi>border-bottom</bdi> تەنها یەک لا ستایل بکە.</p>',
        '<p><bdi>border</bdi> چوارچێوە دەورا بۆکسێ دگریت:</p><pre>border: 2px solid #333;\nborder: 2px dashed red;\nborder-radius: 10px;  /* goşeyên gerandî */\n</pre><p><bdi>border-radius</bdi> گۆشەیان دخوت و پێ <bdi>50%</bdi> بازنەکا تەمام دروست دبیت. هەروەسا پێ <bdi>border-bottom</bdi> تەنها ئالەکەکێ ستایل کە.</p>',
        ".avatar {\n    width: 100px;\n    height: 100px;\n    background: #ff9800;\n    border-radius: 50%;\n}\n\n.card {\n    border: 2px solid #4caf50;\n    border-radius: 12px;\n    padding: 15px;\n}\n\n.nav {\n    border-bottom: 3px solid #e91e63;\n}\n\n.dashed {\n    border: 2px dashed #9e9e9e;\n    border-radius: 8px;\n}"),

    lesson(8, $lv1so, $lv1ba, 'یونیتەکان (px, %, em, rem)', 'چەشنێن یونیتان',
        '<p>جۆرەکانی یونیت لە CSS:</p><ul><li><bdi>px</bdi> - پیکسڵ (نەگۆڕە)</li><li><bdi>%</bdi> - ڕێژە لە باوانەکەی</li><li><bdi>em</bdi> - قەبارەی فۆنتی باوان</li><li><bdi>rem</bdi> - قەبارەی فۆنتی <bdi>&lt;html&gt;</bdi> (زۆر باشە)</li><li><bdi>vw</bdi> / <bdi>vh</bdi> - قەبارەی پەنجەرەکە</li></ul><p>بۆ فۆنت <bdi>rem</bdi> و بۆ بۆشایی <bdi>em</bdi> یان <bdi>%</bdi> بەکاربهێنە بۆ دیزاینی ڕیسپۆنسیڤ.</p>',
        '<p>چەشنێن یونیتان د CSS دا:</p><ul><li><bdi>px</bdi> - پیکسڵ (نەگۆڕە)</li><li><bdi>%</bdi> - ڕێژە ژ باوانێ</li><li><bdi>em</bdi> - قەبارا فۆنتا باوانی</li><li><bdi>rem</bdi> - قەبارا فۆنتا <bdi>&lt;html&gt;</bdi> (زۆر باشە)</li><li><bdi>vw</bdi> / <bdi>vh</bdi> - قەبارا پەنجەرێ</li></ul><p>بو فۆنت <bdi>rem</bdi> و بو بۆشایی <bdi>em</bdi> یا <bdi>%</bdi> بکاربینی بو دیزاینەکا ڕیسپۆنسیڤ.</p>',
        "html {\n    font-size: 16px;\n}\n\nh1 {\n    font-size: 2rem;   /* 32px */\n}\n\np {\n    font-size: 1rem;   /* 16px */\n}\n\n.box {\n    width: 50%;\n    height: 100vh;\n    margin: 1em auto;\n    font-size: 1.2rem;\n}"),

    lesson(9, $lv1so, $lv1ba, 'باکگراوند و وێنە', 'باکگراوند و وێنە',
        '<p>ستایلکردنی پاشبنەما:</p><ul><li><bdi>background-color</bdi> - ڕەنگی یەکدەست</li><li><bdi>background-image</bdi> - وێنە</li><li><bdi>background-size: cover</bdi> - پڕکردنی بۆکسەکە</li><li><bdi>background-position</bdi> - شوێنی وێنەکە</li><li><bdi>linear-gradient()</bdi> - گۆڕانی ڕەنگ</li></ul><p>لەگەڵ وێنە، ڕەنگێکی یەدەگ دیاری بکە بۆ ئەو کاتەی وێنەکە دانابارێت.</p>',
        '<p>ستایلکرنا بنگەهێ:</p><ul><li><bdi>background-color</bdi> - ڕەنگەکا یەکدەست</li><li><bdi>background-image</bdi> - وێنە</li><li><bdi>background-size: cover</bdi> - تیژکرنا بۆکسێ</li><li><bdi>background-position</bdi> - جهێ وێنێ</li><li><bdi>linear-gradient()</bdi> - گوهۆرینا ڕەنگان</li></ul><p>پێکڤە پێ وێنە، ڕەنگەکا یەدەگ دیاری کە بو دەمە کو وێنە دانا باریت.</p>',
        ".hero {\n    background-image: url('https://picsum.photos/800/400');\n    background-size: cover;\n    background-position: center;\n    height: 300px;\n}\n\n.btn {\n    background: linear-gradient(45deg, #ff5722, #e91e63);\n    color: white;\n}\n\n.striped {\n    background: repeating-linear-gradient(45deg, #eee, #eee 10px, #ccc 10px, #ccc 20px);\n}"),

    lesson(10, $lv2so, $lv2ba, 'دیسپلەی (Display)', 'دیسپلەی',
        '<p>تایبەتمەندی <bdi>display</bdi> دیاری دەکات تاقەکە چۆن نیشان بدرێت:</p><ul><li><bdi>block</bdi> - هێڵی تەواو (وەک div، p)</li><li><bdi>inline</bdi> - لە ناو هێڵدا (وەک span، a)</li><li><bdi>inline-block</bdi> - تێکەڵەی هەردووک</li><li><bdi>none</bdi> - شاردراوە (بە تەواوی)</li><li><bdi>flex</bdi> و <bdi>grid</bdi> - لایۆتی پێشکەوتوو</li></ul><p><bdi>visibility: hidden</bdi> شوێنەکە هێشتا هەیە بەڵام <bdi>display: none</bdi> بە تەواوی لادەبات.</p>',
        '<p>تایبەتمەندا <bdi>display</bdi> دیاری دکەت کا تاگ چاوا نیشان دبیت:</p><ul><li><bdi>block</bdi> - خەتەکا تەمام (وەک div، p)</li><li><bdi>inline</bdi> - د ناڤ خەتێ دا (وەک span، a)</li><li><bdi>inline-block</bdi> - تێکەلەیا هەردووکان</li><li><bdi>none</bdi> - ڤەشارتی (ب تەڤایێ)</li><li><bdi>flex</bdi> و <bdi>grid</bdi> - لایۆتێن پێشکەفتی</li></ul><p><bdi>visibility: hidden</bdi> جهێ وی هەروەسا هەیە لێ <bdi>display: none</bdi> ب تەڤایێ دبیت.</p>',
        ".block {\n    display: block;\n    background: #ffcdd2;\n    margin: 5px;\n}\n\n.inline {\n    display: inline;\n    background: #c8e6c9;\n    margin: 5px;\n}\n\n.inline-block {\n    display: inline-block;\n    background: #bbdefb;\n    width: 100px;\n    height: 50px;\n    margin: 5px;\n}\n\n.hidden {\n    display: none;\n}"),

    lesson(11, $lv2so, $lv2ba, 'پۆزیشن (Position)', 'پۆزیشن',
        '<p><bdi>position</bdi> شوێنی تاقەکە دیاری دەکات:</p><ul><li><bdi>static</bdi> - بنەڕەتی</li><li><bdi>relative</bdi> - بە پێی شوێنی خۆی</li><li><bdi>absolute</bdi> - بە پێی باوانی positionدار</li><li><bdi>fixed</bdi> - لە پەنجەرەکەوە نەجۆڵە</li><li><bdi>sticky</bdi> - لەسەرەوە دەمێنێتەوە</li></ul><p>بۆ <bdi>absolute</bdi> باوانەکە <bdi>position: relative</bdi> بێت. بە <bdi>z-index</bdi> پلەی هەڵکشانی دیاری بکە.</p>',
        '<p><bdi>position</bdi> جهێ تاگی دیاری دکەت:</p><ul><li><bdi>static</bdi> - بنگەهی</li><li><bdi>relative</bdi> - ل گورەیا جهێ خوە</li><li><bdi>absolute</bdi> - ل گورەیا باوانێ positionدار</li><li><bdi>fixed</bdi> - د پەنجەرێ دا نەجۆڵە</li><li><bdi>sticky</bdi> - ل سەرەوێ دمینیت</li></ul><p>بو <bdi>absolute</bdi> باوان دڤێت <bdi>position: relative</bdi> بیت. پێ <bdi>z-index</bdi> پلەیا هەلکشیانێ دیاری بکە.</p>',
        ".parent {\n    position: relative;\n    width: 400px;\n    height: 200px;\n    background: #eceff1;\n}\n\n.child {\n    position: absolute;\n    bottom: 10px;\n    right: 10px;\n    background: #e91e63;\n    color: white;\n    padding: 8px 15px;\n}\n\n.menu {\n    position: sticky;\n    top: 0;\n    background: #263238;\n    color: white;\n}\n\n.chat-btn {\n    position: fixed;\n    bottom: 20px;\n    right: 20px;\n    background: #4caf50;\n    border-radius: 50%;\n    width: 50px;\n    height: 50px;\n}"),

    lesson(12, $lv2so, $lv2ba, 'فڵێکس باکس (Flexbox)', 'فڵێکس باکس',
        '<p><bdi>display: flex</bdi> ڕێکخستنی بەشەکانی تێدا دەبێتە ئاسان. یاساکانی باوان:</p><ul><li><bdi>flex-direction</bdi> - row یان column</li><li><bdi>justify-content</bdi> - هێڵی سەرەکی: center، space-between</li><li><bdi>align-items</bdi> - هێڵی لاوەکی</li><li><bdi>gap</bdi> - بۆشایی نێوان</li></ul><p>بۆ مناڵەکان: <bdi>flex-grow</bdi>، <bdi>flex-shrink</bdi>، <bdi>order</bdi>.</p>',
        '<p><bdi>display: flex</bdi> ڕێکخستنا بەشان ساده دکەت. یاسایێن باوانی:</p><ul><li><bdi>flex-direction</bdi> - row یا column</li><li><bdi>justify-content</bdi> - خەتا سەرەکی: center، space-between</li><li><bdi>align-items</bdi> - خەتا لاوەکی</li><li><bdi>gap</bdi> - بۆشاییا ناڤبەر</li></ul><p>بو زارۆکان: <bdi>flex-grow</bdi>، <bdi>flex-shrink</bdi>، <bdi>order</bdi>.</p>',
        ".navbar {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    background: #1565c0;\n    padding: 15px;\n}\n\n.menu {\n    display: flex;\n    gap: 15px;\n}\n\n.cards {\n    display: flex;\n    flex-wrap: wrap;\n    gap: 20px;\n}\n\n.card {\n    flex: 1 1 200px;\n    background: #fff;\n    border: 1px solid #ddd;\n    border-radius: 8px;\n    padding: 20px;\n}"),

    lesson(13, $lv2so, $lv2ba, 'گرید (Grid)', 'گرید',
        '<p><bdi>display: grid</bdi> لایۆتی دوو ڕەهەندی دروست دەکات:</p><pre>.grid {\n  display: grid;\n  grid-template-columns: 1fr 1fr 1fr;\n  gap: 15px;\n}</pre><p>بە <bdi>repeat(auto-fit, minmax(200px, 1fr))</bdi> گریدەکە خۆکارانە ڕیسپۆنسیڤ دەبێت. <bdi>grid-template-rows</bdi> بۆ ڕیزەکان و <bdi>grid-area</bdi> بۆ ئەو تاقانەی کە دەمانەوێت ڕیزەکە پڕ بکەن.</p>',
        '<p><bdi>display: grid</bdi> لایۆتەکا دوو ڕەهەندی دروست دکەت:</p><pre>.grid {\n  display: grid;\n  grid-template-columns: 1fr 1fr 1fr;\n  gap: 15px;\n}</pre><p>پێ <bdi>repeat(auto-fit, minmax(200px, 1fr))</bdi> گرید ب شێوەیەکا خودکار ڕیسپۆنسیڤ دبیت. <bdi>grid-template-rows</bdi> بو ڕیزان و <bdi>grid-area</bdi> بو ئەو تاگان کو دڤێت ڕیزەکا تەمام بگرن.</p>',
        ".grid {\n    display: grid;\n    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\n    gap: 20px;\n}\n\n.item {\n    background: #e8f5e9;\n    padding: 25px;\n    border-radius: 10px;\n    text-align: center;\n}\n\n.layout {\n    display: grid;\n    grid-template-columns: 1fr 3fr 1fr;\n    gap: 10px;\n}\n\n.header {\n    grid-column: 1 / -1;\n    background: #263238;\n    color: white;\n    padding: 15px;\n}"),

    lesson(14, $lv2so, $lv2ba, 'ئۆڤەرفڵۆ و ئێرۆیفڵۆو', 'ئۆڤەرفڵۆ',
        '<p><bdi>overflow</bdi> کۆنترۆڵ دەکات چی ڕوودەدات کاتێک ناوەڕۆکەکە گەورەترە لە بۆکسەکە:</p><ul><li><bdi>visible</bdi> - دەردەکەوێت (بنەڕەتی)</li><li><bdi>hidden</bdi> - دەشاردرێتەوە</li><li><bdi>scroll</bdi> - هەمیشە هێڵی خلیسکان</li><li><bdi>auto</bdi> - تەنها کاتێک پێویست بێت</li></ul><p>لەگەڵ <bdi>overflow-x</bdi> و <bdi>overflow-y</bdi> هەر تەوەرێک جیا کۆنترۆڵ بکە.</p>',
        '<p><bdi>overflow</bdi> کۆنترۆل دکەت چ دقیت دەمە کو ناڤەرۆک مەزنترە ژ بۆکسێ:</p><ul><li><bdi>visible</bdi> - دەرکەفتن (بنگەهی)</li><li><bdi>hidden</bdi> - ڤەشارتن</li><li><bdi>scroll</bdi> - هەرمای خلیسکان</li><li><bdi>auto</bdi> - تەنها دەمە کو پێدڤی بیت</li></ul><p>پێکڤە پێ <bdi>overflow-x</bdi> و <bdi>overflow-y</bdi> هەر تەڤەرەکە جودا کۆنترۆل کە.</p>',
        ".scroll-box {\n    width: 250px;\n    height: 120px;\n    overflow: auto;\n    border: 1px solid #999;\n    padding: 10px;\n}\n\n.hidden {\n    overflow: hidden;\n    height: 80px;\n    background: #ffebee;\n}\n\n.nowrap {\n    white-space: nowrap;\n    overflow-x: auto;\n    background: #e3f2fd;\n}"),

    lesson(15, $lv2so, $lv2ba, 'شادۆ و ئۆپەسیتی', 'شادۆ و ئۆپەسیتی',
        '<p><bdi>box-shadow</bdi> سێبەر بۆ بۆکسەکان و <bdi>text-shadow</bdi> بۆ دەق:</p><pre>box-shadow: 0 4px 10px rgba(0,0,0,0.2);\ntext-shadow: 2px 2px 4px rgba(0,0,0,0.3);</pre><p>شێوەیە: <bdi>x</bdi> <bdi>y</bdi> <bdi>blur</bdi> <bdi>color</bdi>. سێبەری ناوەوە بە <bdi>inset</bdi>. <bdi>opacity</bdi> سافری هەموو بۆکسەکە.</p>',
        '<p><bdi>box-shadow</bdi> سێبەر بو بۆکسان و <bdi>text-shadow</bdi> بو نڤیسینێ:</p><pre>box-shadow: 0 4px 10px rgba(0,0,0,0.2);\ntext-shadow: 2px 2px 4px rgba(0,0,0,0.3);</pre><p>شێواز: <bdi>x</bdi> <bdi>y</bdi> <bdi>blur</bdi> <bdi>color</bdi>. سێبەرێ ناڤخی پێ <bdi>inset</bdi>. <bdi>opacity</bdi> ڕۆنیا هەمی بۆکسێ.</p>',
        ".card {\n    background: white;\n    padding: 25px;\n    border-radius: 10px;\n    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);\n}\n\n.card:hover {\n    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);\n}\n\n.title {\n    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);\n}\n\n.inset {\n    box-shadow: inset 0 2px 6px rgba(0, 0, 0, 0.3);\n}\n\n.faded {\n    opacity: 0.6;\n}"),

    lesson(16, $lv2so, $lv2ba, 'ترانزیشن (Transition)', 'ترانزیشن',
        '<p><bdi>transition</bdi> گۆڕانی ستایل بە شێوەیەکی نەرم دەکات:</p><pre>transition: property duration timing-function delay;</pre><p>نمونە:</p><pre>.btn {\n  background: blue;\n  transition: background 0.3s ease, transform 0.3s;\n}\n.btn:hover { background: red; }</pre><p>بە <bdi>all</bdi> هەموو تایبەتمەندییەکان. <bdi>ease</bdi>، <bdi>linear</bdi>، <bdi>ease-in-out</bdi> جۆرەکانی خێرایی.</p>',
        '<p><bdi>transition</bdi> گوهۆرینا ستایلان ب شێوەیەکا نەرم دکەت:</p><pre>transition: property duration timing-function delay;</pre><p>نمونە:</p><pre>.btn {\n  background: blue;\n  transition: background 0.3s ease, transform 0.3s;\n}\n.btn:hover { background: red; }</pre><p>پێ <bdi>all</bdi> هەمی تایبەتمەندی. <bdi>ease</bdi>، <bdi>linear</bdi>، <bdi>ease-in-out</bdi> چەشنێن خێراییێ.</p>',
        ".btn {\n    background: #1565c0;\n    color: white;\n    padding: 12px 25px;\n    border: none;\n    border-radius: 6px;\n    cursor: pointer;\n    transition: background 0.3s ease, transform 0.2s;\n}\n\n.btn:hover {\n    background: #0d47a1;\n    transform: scale(1.05);\n}\n\n.card {\n    transition: all 0.4s ease-in-out;\n}\n\n.card:hover {\n    transform: translateY(-5px);\n    box-shadow: 0 10px 20px rgba(0,0,0,0.2);\n}"),

    lesson(17, $lv2so, $lv2ba, 'ترانسفۆڕم (Transform)', 'ترانسفۆڕم',
        '<p><bdi>transform</bdi> شێوە و شوێنی تاقەکە دەگۆڕێت:</p><ul><li><bdi>translate(x, y)</bdi> - جوڵاندن</li><li><bdi>rotate(45deg)</bdi> - سووڕانەوە</li><li><bdi>scale(1.5)</bdi> - گەورەکردن</li><li><bdi>skew(10deg)</bdi> - لارکردنەوە</li></ul><p>زۆرتر لە یەک کردار بەیەکەوە بە بۆشایی جیابکەرەوە: <bdi>transform: rotate(10deg) scale(1.1)</bdi>. <bdi>transform-origin</bdi> ناوەندی سووڕانەوە دیاری دەکات.</p>',
        '<p><bdi>transform</bdi> شێوە و جهێ تاگی دگوهۆریت:</p><ul><li><bdi>translate(x, y)</bdi> - گەڕاندن</li><li><bdi>rotate(45deg)</bdi> - زڤڕان</li><li><bdi>scale(1.5)</bdi> - مەزنکرن</li><li><bdi>skew(10deg)</bdi> - لارکرن</li></ul><p>ژ یەکێ بەرتر کردار پێکڤە پێ بۆشایی: <bdi>transform: rotate(10deg) scale(1.1)</bdi>. <bdi>transform-origin</bdi> ناڤەندا زڤڕانێ دیاری دکەت.</p>',
        ".box {\n    width: 80px;\n    height: 80px;\n    background: #4caf50;\n    transition: transform 0.3s;\n}\n\n.box:hover {\n    transform: rotate(45deg) scale(1.2);\n}\n\n.move {\n    transform: translate(50px, 20px);\n}\n\n.tilt {\n    transform: skew(10deg, 5deg);\n}\n\n.center {\n    transform: translate(-50%, -50%);\n}"),

    lesson(18, $lv3so, $lv3ba, 'ئەنیمەیشن (Animation)', 'ئەنیمەیشن',
        '<p><bdi>@keyframes</bdi> ئەنیمەیشن دروست دەکات:</p><pre>@keyframes name {\n  from { opacity: 0; }\n  to   { opacity: 1; }\n}\n\n.el {\n  animation: name 2s ease infinite;\n}</pre><p>تایبەتمەندییەکان: <bdi>animation-duration</bdi>، <bdi>animation-iteration-count</bdi> (بە <bdi>infinite</bdi> هەمیشە)، <bdi>animation-delay</bdi>، <bdi>animation-direction</bdi>. هەروەها دەتوانیت چەند ئاست (٪٥٠) بنووسیت.</p>',
        '<p><bdi>@keyframes</bdi> ئەنیمەیشن دروست دکەت:</p><pre>@keyframes name {\n  from { opacity: 0; }\n  to   { opacity: 1; }\n}\n\n.el {\n  animation: name 2s ease infinite;\n}</pre><p>تایبەتمەندی: <bdi>animation-duration</bdi>، <bdi>animation-iteration-count</bdi> (پێ <bdi>infinite</bdi> هەرمای)، <bdi>animation-delay</bdi>، <bdi>animation-direction</bdi>. هەروەسا دکەی چەند قۆناخ (٪٥٠) بنڤیسی.</p>',
        "@keyframes fadeIn {\n    from { opacity: 0; transform: translateY(20px); }\n    to   { opacity: 1; transform: translateY(0); }\n}\n\n@keyframes pulse {\n    0%   { transform: scale(1); }\n    50%  { transform: scale(1.1); }\n    100% { transform: scale(1); }\n}\n\n.hero h1 {\n    animation: fadeIn 1s ease-out;\n}\n\n.logo {\n    animation: pulse 2s infinite;\n}\n\n.loading {\n    width: 30px;\n    height: 30px;\n    border: 4px solid #ccc;\n    border-top-color: #1565c0;\n    border-radius: 50%;\n    animation: spin 1s linear infinite;\n}\n\n@keyframes spin {\n    to { transform: rotate(360deg); }\n}"),

    lesson(19, $lv3so, $lv3ba, 'سودۆ کلاسەکان', 'کلاسێن سودۆ',
        '<p>سودۆ کلاسەکان دۆخی تایبەتی تاقەکان دیاری دەکەن:</p><ul><li><bdi>:hover</bdi> - کاتێک cursor لەسەرە</li><li><bdi>:focus</bdi> - کاتێک دیاریکراوە</li><li><bdi>:first-child</bdi> / <bdi>:last-child</bdi></li><li><bdi>:nth-child(2n)</bdi> - هەر دووەم</li><li><bdi>:not()</bdi> - بێجگە</li></ul><p>لەگەڵ <bdi>:hover</bdi> و <bdi>:focus</bdi> ستایلی خواستنەکان دەستبەردار مەبە.</p>',
        '<p>کلاسێن سودۆ دۆخێن تایبەت یێن تاگان دیاری دکەن:</p><ul><li><bdi>:hover</bdi> - دەمە کو cursor ل سەر ە</li><li><bdi>:focus</bdi> - دەمە کو دیاریکرێ</li><li><bdi>:first-child</bdi> / <bdi>:last-child</bdi></li><li><bdi>:nth-child(2n)</bdi> - هەر دویێ</li><li><bdi>:not()</bdi> - بێجگە ژ</li></ul><p>پێکڤە پێ <bdi>:hover</bdi> و <bdi>:focus</bdi> ستایلێن خواستنان دەستبەردار مەکە.</p>',
        "a {\n    color: #1565c0;\n    transition: color 0.2s;\n}\n\na:hover {\n    color: #e91e63;\n}\n\ninput:focus {\n    border: 2px solid #4caf50;\n    outline: none;\n}\n\nul li:first-child {\n    font-weight: bold;\n}\n\nul li:nth-child(2n) {\n    background: #f5f5f5;\n}\n\n.btn:not(.disabled) {\n    background: #1976d2;\n}\n\n.btn:hover {\n    background: #0d47a1;\n}"),

    lesson(20, $lv3so, $lv3ba, 'سودۆ ئیلیمێنتەکان', 'ئیلیمێنتێن سودۆ',
        '<p>سودۆ ئیلیمێنتەکان بەشێکی تاقەکە دروست دەکەن:</p><pre>.card::before { content: \"\"; ... }\n.card::after  { content: \"\"; ... }</pre><ul><li><bdi>::before</bdi> - پێش ناوەڕۆک</li><li><bdi>::after</bdi> - دوای ناوەڕۆک</li><li><bdi>::first-line</bdi> - هێڵی یەکەم</li><li><bdi>::selection</bdi> - دەقی هەڵبژێردراو</li></ul><p>بۆ ناوەڕۆکی وەک ئایکۆن و نیشانەکان زۆر بەسوودە.</p>',
        '<p>ئیلیمێنتێن سودۆ پارچەکا تاگی دروست دکەن:</p><pre>.card::before { content: \"\"; ... }\n.card::after  { content: \"\"; ... }</pre><ul><li><bdi>::before</bdi> - بەر ناڤەرۆکێ</li><li><bdi>::after</bdi> - پاشی ناڤەرۆکێ</li><li><bdi>::first-line</bdi> - خەتا یەکێ</li><li><bdi>::selection</bdi> - نڤیسینا هەلبژرتی</li></ul><p>بو ناڤەرۆکێن وەک ئایکۆن و نیشانان زۆر بکەر.</p>',
        ".quote::before {\n    content: \"\\201C\";\n    font-size: 40px;\n    color: #999;\n}\n\n.card::after {\n    content: \"\";\n    display: block;\n    width: 50px;\n    height: 3px;\n    background: #e91e63;\n    margin-top: 10px;\n}\n\n::selection {\n    background: #ffe082;\n}\n\np::first-line {\n    font-weight: bold;\n}"),
];

$cssDemoHtml = "<!DOCTYPE html>\n<html lang=\"en\">\n<head>\n<meta charset=\"UTF-8\">\n</head>\n<body>\n<h1 class=\"demo-h1\">Kurd AI - CSS Preview</h1>\n<p class=\"demo-p\">This is a sample paragraph. Write your CSS and watch it apply to these elements.</p>\n<div class=\"demo-box\">Box 1</div>\n<div class=\"demo-box\">Box 2</div>\n<button class=\"demo-btn\">Click Me</button>\n</body>\n</html>";

foreach ($lessons as $lesson) {
    $lesson['langId'] = $langId;
    $lesson['order'] = ($lesson['order'] ?? 0) + 40;
    $lesson['code_css'] = $lesson['code'];
    $lesson['code'] = $cssDemoHtml;
    $res = fbPost($firebaseUrl . 'ferga_lessons.json', $lesson);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo "Lesson added: {$lesson['title_so']} -> {$d['name']}\n";
    } else {
        echo "ERROR adding lesson {$lesson['title_so']}: $res\n";
    }
}

echo "\nDone! CSS lessons 1-20 added.\n";
