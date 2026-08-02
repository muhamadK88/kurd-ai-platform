<?php

// Script to add HTML lessons 1-20 to the Ferga section in Firebase
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

$lv1so = 'ئاستی ١ - بنەڕەتی HTML';
$lv1ba = 'ئاستا ١ - بنگەهێن HTML';
$lv2so = 'ئاستی ٢ - فۆڕم و سێمەنتیک';
$lv2ba = 'ئاستا ٢ - فۆرم و سێمەنتیک';
$lv3so = 'ئاستی ٣ - تایبەتمەندی و پێشکەوتوو';
$lv3ba = 'ئاستا ٣ - تایبەتمەندی و پێشکەفتی';
$lv4so = 'ئاستی ٤ - پرۆژەکان';
$lv4ba = 'ئاستا ٤ - پروژە';

$lessons = [
    lesson(1, $lv1so, $lv1ba, 'ئاشنابوون بە HTML', 'ناساندن ب HTML',
        '<p><strong>HTML</strong> کورتکراوەی <bdi>HyperText Markup Language</bdi> یە و بنەڕەتی هەموو وێبپەڕەیەکە. بە HTML پێکهاتەی وێبپەڕە دروست دەکەیت: سەرنووسە، پاراگراف، وێنە و لینک.</p><p>وێبگەڕەکە کۆدی HTML دەخوێنێتەوە و وەک پەڕەیەکی جوان نیشانی دەدات. تاقەکان لە نێوان <bdi>&lt;&gt;</bdi> دەنووسرێن و زۆربەیان دەکرێنەوە و دادەخرێن: <bdi>&lt;p&gt;...&lt;/p&gt;</bdi></p><p>دەست بکە و ئەم کۆدە بە خۆی ببینە لە پەنجەرەی پێشبینی!</p>',
        '<p><strong>HTML</strong> کورتکراوەی <bdi>HyperText Markup Language</bdi> یە و بنگەهێ هەمی وێبپەڕانە. پێ HTML تۆ دکەی پێکهاتەیا وێبپەڕێ دروست کەی: سەردێڕ، پاراگراف، وێنە و گرێدان.</p><p>وێبگەر کۆدا HTML دخوینیتەڤە و وەک رووپەڵەکا جوان نیشان ددەت. تاگ د ناڤ <bdi>&lt;&gt;</bdi> دا د نڤیسرێن و پشتیا ڤە دگریت: <bdi>&lt;p&gt;...&lt;/p&gt;</bdi></p><p>دست پێ بکە و ڤێ کۆدێ ب خۆ خودا د پەنجەرەیا پێشبینێ دا بینە!</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Yekem Ruperrim</title>\n</head>\n<body>\n  <h1>Salam Kurdistan!</h1>\n  <p>Ev min HTML ye. Ser xer be!</p>\n</body>\n</html>"),

    lesson(2, $lv1so, $lv1ba, 'پێکهاتهی وێبپەڕە', 'ساختارا وێبپەڕێ',
        '<p>هەموو پەڕەیەکی HTML پێکهاتەیەکی دیاریکراو هەیە:</p><ul><li><bdi>&lt;!DOCTYPE html&gt;</bdi> - وێبگەڕەکە ئاگادار دەکاتەوە کە HTML5 یە</li><li><bdi>&lt;html&gt;</bdi> - هەموو پەڕەکە لە ناوەوەیە</li><li><bdi>&lt;head&gt;</bdi> - زانیارییەکانی پەڕەکە (ناونیشان، ستایل)</li><li><bdi>&lt;body&gt;</bdi> - ناوەڕۆکی دیارەکە</li></ul><p>لە <bdi>&lt;body&gt;</bdi> دایە کە ناوەڕۆکەکە نیشانی بەکارهێنەر دەدرێت.</p>',
        '<p>هەمی رووپەلەکا HTML پێکهاتەیەکا دیاریکراو دگەری:</p><ul><li><bdi>&lt;!DOCTYPE html&gt;</bdi> - وێبگەر ئاگەدار دکەت کو HTML5 یە</li><li><bdi>&lt;html&gt;</bdi> - هەمی رووپەلە د ناڤ وی دا یە</li><li><bdi>&lt;head&gt;</bdi> - زانیارییێن رووپەلێ (ناڤ، ستایل)</li><li><bdi>&lt;body&gt;</bdi> - ناڤەرۆکێ دیار</li></ul><p>د ناڤ <bdi>&lt;body&gt;</bdi> دا ناڤەرۆک نیشانی بکارهێنەری ددەت.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Serekê min</title>\n</head>\n<body>\n  <h2>Naverok</h2>\n  <p>Ev naverok di nav body de ye.</p>\n</body>\n</html>"),

    lesson(3, $lv1so, $lv1ba, 'سەرنووسەکان (Headings)', 'سەردێڕ (Headings)',
        '<p>سەرنووسەکان پەڕەکە دابەش دەکەن و گرنگی تەوەرەکان نیشان دەدەن. لە HTML شەش ئاستی سەرنووسە هەیە:</p><ul><li><bdi>&lt;h1&gt;</bdi> - گەورەترین سەرنووسە (ناونیشانی سەرەکی)</li><li><bdi>&lt;h2&gt;</bdi> - سەرنووسەی کۆمەڵە</li><li><bdi>&lt;h3&gt;</bdi> - سەرنووسەی بچووکتر</li><li><bdi>&lt;h4&gt;</bdi>، <bdi>&lt;h5&gt;</bdi>، <bdi>&lt;h6&gt;</bdi> - بچووکترین</li></ul><p><bdi>&lt;h1&gt;</bdi> تەنها یەک جار لە پەڕەیەکدا بەکاربهێنە بۆ SEO باشتر.</p>',
        '<p>سەردێڕ پەڕەکە دابەش دکەن و گرنگییا تەڤەران نیشان ددەن. د HTML دا شەش ئاستێن سەردێڕ هەن:</p><ul><li><bdi>&lt;h1&gt;</bdi> - مەزنترین سەردێڕ (ناڤێ سەرەکی)</li><li><bdi>&lt;h2&gt;</bdi> - سەردێڕێ کۆمەلێ</li><li><bdi>&lt;h3&gt;</bdi> - سەردێڕەکا چویکترین</li><li><bdi>&lt;h4&gt;</bdi>، <bdi>&lt;h5&gt;</bdi>، <bdi>&lt;h6&gt;</bdi> - هەرە چویک</li></ul><p><bdi>&lt;h1&gt;</bdi> تەنها یەک جار د رووپەلەکێ دا بکاربینی بو SEO باشتر.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Serenuse</title>\n</head>\n<body>\n  <h1>Kursên Programkirinê</h1>\n  <h2>Python</h2>\n  <h3>Nivisarên</h3>\n  <h2>HTML</h2>\n  <h3>Tags</h3>\n</body>\n</html>"),

    lesson(4, $lv1so, $lv1ba, 'پاراگراف و فۆرماتکردنی دەق', 'پاراگراف و فۆرماتکرنا نڤیسینێ',
        '<p><bdi>&lt;p&gt;</bdi> بۆ پاراگراف بەکاردێت. هەروەها تاقەکانی دەق:</p><ul><li><bdi>&lt;b&gt;</bdi> یان <bdi>&lt;strong&gt;</bdi> - تۆخ (گرنگ)</li><li><bdi>&lt;i&gt;</bdi> یان <bdi>&lt;em&gt;</bdi> - لار</li><li><bdi>&lt;u&gt;</bdi> - ژێرهێڵ</li><li><bdi>&lt;mark&gt;</bdi> - دیارکراو</li><li><bdi>&lt;small&gt;</bdi> - بچووک</li><li><bdi>&lt;br&gt;</bdi> - هێڵی نوێ</li><li><bdi>&lt;hr&gt;</bdi> - هێڵی جیاکەرەوە</li></ul>',
        '<p><bdi>&lt;p&gt;</bdi> بو پاراگرافی بکارتیت. هەروەسا تاگێن نڤیسینێ:</p><ul><li><bdi>&lt;b&gt;</bdi> یا <bdi>&lt;strong&gt;</bdi> - تۆخ (گرنگ)</li><li><bdi>&lt;i&gt;</bdi> یا <bdi>&lt;em&gt;</bdi> - لار</li><li><bdi>&lt;u&gt;</bdi> - خوارگرێدان</li><li><bdi>&lt;mark&gt;</bdi> - دیارکرێ</li><li><bdi>&lt;small&gt;</bdi> - چویک</li><li><bdi>&lt;br&gt;</bdi> - خەتەکا نوی</li><li><bdi>&lt;hr&gt;</bdi> - خەتێ جودا کرنێ</li></ul>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Deq</title>\n</head>\n<body>\n  <h2>Kurtejiyan</h2>\n  <p>Ez <b>donk</b> me, ji <i>Kurdistanê</i> yê.\n  <br>Ev kursên fêrbûna webê ye.</p>\n  <hr>\n  <p><mark>Serketin</mark> hewl dixwaze!</p>\n</body>\n</html>"),

    lesson(5, $lv1so, $lv1ba, 'لینکەکان (Links)', 'گرێدان (Links)',
        '<p><bdi>&lt;a&gt;</bdi> بۆ دروستکردنی لینک بەکاردێت. ئەتریبیوتی <bdi>href</bdi> ناونیشانی ئامانجەکە دەنووسێت:</p><pre>&lt;a href="https://example.com"&gt;Deqê Linkî&lt;/a&gt;</pre><p>ئەتریبیوتی <bdi>target="_blank"</bdi> لینکەکە لە تابێکی نوێدا دەکاتەوە. هەروەها دەتوانیت بە <bdi>#id</bdi> لینک بۆ بەشێکی پەڕەکە دروست بکەیت.</p>',
        '<p><bdi>&lt;a&gt;</bdi> بو دروستکرنا گرێدانێ بکارتیت. ئەتریبیوتا <bdi>href</bdi> ناڤی ئارمانجێ دینڤیسە:</p><pre>&lt;a href="https://example.com"&gt;Deqê Linkî&lt;/a&gt;</pre><p>ئەتریبیوتا <bdi>target="_blank"</bdi> گرێدانێ د تابەکا نوی دا ڤەدکەت. هەروەسا دکەی پێ <bdi>#id</bdi> گرێدان بو پارچەکا رووپەلێ دروست کەی.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Link</title>\n</head>\n<body>\n  <h2>Gihane</h2>\n  <p><a href=\"https://www.google.com\">Biçe Google</a></p>\n  <p><a href=\"https://www.youtube.com\" target=\"_blank\">YouTube di tabeke nû de</a></p>\n</body>\n</html>"),

    lesson(6, $lv1so, $lv1ba, 'وێنەکان (Images)', 'وێنە (Images)',
        '<p><bdi>&lt;img&gt;</bdi> بۆ نیشاندانی وێنە بەکاردێت و تاقێکی داخراوە:</p><pre>&lt;img src="https://..." alt="Sêvekanî" width="300"&gt;</pre><p>ئەتریبیوتی <bdi>src</bdi> سەرچاوەی وێنەکەیە و <bdi>alt</bdi> دەقی جێگرەوەیە کاتێک وێنەکە دانابارێت. بە <bdi>width</bdi> و <bdi>height</bdi> قەبارەکەی دیاری دەکەیت. <bdi>alt</bdi> بۆ وێبئەکسیبلیتی و SEO زۆر گرنگە.</p>',
        '<p><bdi>&lt;img&gt;</bdi> بو نیشاندانا وێنێ بکارتیت و تاگەکا گرتی یە:</p><pre>&lt;img src="https://..." alt="Sêvekanî" width="300"&gt;</pre><p>ئەتریبیوتا <bdi>src</bdi> چاڤکانێ یا وێنێ یە و <bdi>alt</bdi> نڤیسینا جێگرەوەیە دەمە کو وێنە دانا باریت. پێ <bdi>width</bdi> و <bdi>height</bdi> قەبارا وی دیاری دکەی. <bdi>alt</bdi> بو وێبئەکسیبلیتی و SEO زۆر گرنگە.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Wêne</title>\n</head>\n<body>\n  <h2>Hewlêr</h2>\n  <img src=\"https://picsum.photos/400/250\" alt=\"Wêneyê Hewlêrê\" width=\"400\">\n  <p>Ev wêne ji internetê tê.</p>\n</body>\n</html>"),

    lesson(7, $lv1so, $lv1ba, 'لیستەکان (Lists)', 'لیست (Lists)',
        '<p>سێ جۆر لیست لە HTML هەیە:</p><ul><li><bdi>&lt;ul&gt;</bdi> - لیستی خاڵدار (بە خاڵ)</li><li><bdi>&lt;ol&gt;</bdi> - لیستی ژمارەدار (١، ٢، ٣)</li><li><bdi>&lt;dl&gt;</bdi> - لیستی پێناسە</li></ul><p>هەر بەندێک لە ناو <bdi>&lt;li&gt;</bdi> دایە. لیستەکان دەتوانن لە ناو یەکتردا بن (لیستی ناوەکی).</p>',
        '<p>سێ چەشن لیست د HTML دا هەن:</p><ul><li><bdi>&lt;ul&gt;</bdi> - لیستا خالدار</li><li><bdi>&lt;ol&gt;</bdi> - لیستا ژمارکرێ</li><li><bdi>&lt;dl&gt;</bdi> - لیستا پێناسەیێ</li></ul><p>هەر بەندەک د ناڤ <bdi>&lt;li&gt;</bdi> دا یە. لیست دکەن د ناڤ هەڤدا بن (لیستا ناڤخی).</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Lîst</title>\n</head>\n<body>\n  <h3>Zimanê programkirinê</h3>\n  <ul>\n    <li>Python</li>\n    <li>JavaScript</li>\n    <li>C++</li>\n  </ul>\n  <h3>Gavên projeyê</h3>\n  <ol>\n    <li>Plan</li>\n    <li>Kodkirin</li>\n    <li>Test</li>\n  </ol>\n</body>\n</html>"),

    lesson(8, $lv1so, $lv1ba, 'خشتەکان (Tables)', 'خشتە (Tables)',
        '<p>خشتەکان بۆ نیشاندانی داتا بە شێوەی ڕیز و ستوون. تاقەکان:</p><ul><li><bdi>&lt;table&gt;</bdi> - خشتەکە</li><li><bdi>&lt;tr&gt;</bdi> - ڕیز</li><li><bdi>&lt;th&gt;</bdi> - سەری ستوون (تۆخ)</li><li><bdi>&lt;td&gt;</bdi> - خانە</li></ul><p>بە <bdi>colspan</bdi> و <bdi>rowspan</bdi> خانەکان بەیەک دەگەیەنیت.</p>',
        '<p>خشتە بو نیشاندانا داتایێ ب ڕیز و ستوون. تاگ:</p><ul><li><bdi>&lt;table&gt;</bdi> - خشتە</li><li><bdi>&lt;tr&gt;</bdi> - ڕیز</li><li><bdi>&lt;th&gt;</bdi> - سەرێ ستوونێ (تۆخ)</li><li><bdi>&lt;td&gt;</bdi> - خانە</li></ul><p>پێ <bdi>colspan</bdi> و <bdi>rowspan</bdi> خانەیان پێکڤە گریت.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Xeste</title>\n</head>\n<body>\n  <h3>Nimreyan</h3>\n  <table border=\"1\" style=\"border-collapse: collapse\">\n    <tr><th>Nav</th><th>Nimre</th></tr>\n    <tr><td>Rêzan</td><td>95</td></tr>\n    <tr><td>Dilan</td><td>88</td></tr>\n  </table>\n</body>\n</html>"),

    lesson(9, $lv1so, $lv1ba, 'کۆمێنتەکان و ئەتریبیوتەکان', 'کۆمێنت و ئەتریبیوت',
        '<p><strong>کۆمێنت</strong> بۆ بەنووسەکانی کۆد، وێبگەڕ پێیان ناناسێنێت:</p><pre>&lt;!-- Ev komet e --&gt;</pre><p><strong>ئەتریبیوتەکان</strong> زانیاری زیادەن لەسەر تاقەکان و لە ناو تاقەکەدا دەنووسرێن:</p><pre>&lt;p class="sereki" id="beş1" lang="so"&gt;...&lt;/p&gt;</pre><p>هەندێ ئەتریبیوتی گشتین: <bdi>class</bdi>، <bdi>id</bdi>، <bdi>style</bdi>، <bdi>title</bdi>، <bdi>lang</bdi>.</p>',
        '<p><strong>کۆمێنت</strong> بو نڤیسینێن کۆدی، وێبگەر پێ نناسیت:</p><pre>&lt;!-- Ev komet e --&gt;</pre><p><strong>ئەتریبیوت</strong> زانیارییێن زیادە ل سەر تاگان و د ناڤ تاگی دا د نڤیسرن:</p><pre>&lt;p class="sereki" id="beş1" lang="so"&gt;...&lt;/p&gt;</pre><p>هەندەک ئەتریبیوتێن گشتی: <bdi>class</bdi>، <bdi>id</bdi>، <bdi>style</bdi>، <bdi>title</bdi>، <bdi>lang</bdi>.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Komet</title>\n</head>\n<body>\n  <!-- Ev beşa sereke ye -->\n  <h2 class=\"sereki\" title=\"Sereka page\">Serkeftin</h2>\n  <p>Kodê HTML bi kometan re zelaltir dibe.</p>\n</body>\n</html>"),

    lesson(10, $lv2so, $lv2ba, 'فۆڕمەکان - بنەڕەتەکان', 'فۆرم - بنگەهی',
        '<p><bdi>&lt;form&gt;</bdi> بۆ وەرگرتنی داتا لە بەکارهێنەر. بنەڕەتەکان:</p><ul><li><bdi>&lt;input type="text"&gt;</bdi> - دەق</li><li><bdi>&lt;input type="submit"&gt;</bdi> - دوگمەی ناردن</li><li><bdi>&lt;label&gt;</bdi> - ناونیشانی خانەکە</li></ul><p>ئەتریبیوتی <bdi>name</bdi> بۆ هەر خانەیەک گرنگە بۆ ناردنی داتاکە.</p>',
        '<p><bdi>&lt;form&gt;</bdi> بو هەلگرتنا داتایێ ژ بکارهێنەری. بنگەهی:</p><ul><li><bdi>&lt;input type="text"&gt;</bdi> - نڤیسین</li><li><bdi>&lt;input type="submit"&gt;</bdi> - دوگمەیا شاندنێ</li><li><bdi>&lt;label&gt;</bdi> - ناڤێ خانەیێ</li></ul><p>ئەتریبیوتا <bdi>name</bdi> بو هەمی خانەیەکێ گرنگە بو شاندنا داتایێ.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Form</title>\n</head>\n<body>\n  <h3>Têketin</h3>\n  <form>\n    <label>Nav:</label>\n    <input type=\"text\" name=\"nav\">\n    <br><br>\n    <label>E-mail:</label>\n    <input type=\"email\" name=\"email\">\n    <br><br>\n    <input type=\"submit\" value=\"Şandin\">\n  </form>\n</body>\n</html>"),

    lesson(11, $lv2so, $lv2ba, 'فۆڕمەکان - ڕادیۆ و چیکبۆکس', 'فۆرم - ڕادیۆ و چیکبۆکس',
        '<p><bdi>Radio</bdi> بۆ هەڵبژاردنی یەک بەیان (لە چەندێک) و <bdi>checkbox</bdi> بۆ چەند هەڵبژاردن:</p><pre>&lt;input type="radio" name="zayend" value="kur"&gt;\n&lt;input type="checkbox" name="ziman" value="py"&gt;</pre><p>بۆ radio، ئەتریبیوتی <bdi>name</bdi> هەر یەک دەبێت لە کۆمەڵێکدا. <bdi>value</bdi> بەهای ئەو بەیانه دیاری دەکات کە دەنێردرێت. لەگەڵ <bdi>&lt;label&gt;</bdi> کە <bdi>for</bdi> ی هەیە و ئەتریبیوتی <bdi>id</bdi> ی خانەکە بەکاربهێنە.</p>',
        '<p><bdi>Radio</bdi> بو هەلبژارتنا یەک بەهایێ (ژ چەندان) و <bdi>checkbox</bdi> بو چەند هەلبژارتنان:</p><pre>&lt;input type="radio" name="zayend" value="kur"&gt;\n&lt;input type="checkbox" name="ziman" value="py"&gt;</pre><p>بو radio، ئەتریبیوتا <bdi>name</bdi> دڤێت یەک بیت د گروپەکێ دا. <bdi>value</bdi> بەهایێ ئەو هەلبژارتنێ دیاری دکەت. پێکڤە پێ <bdi>&lt;label for&gt;</bdi> و <bdi>id</bdi> بکاربینی.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Radio</title>\n</head>\n<body>\n  <form>\n    <p>Zayend:</p>\n    <label><input type=\"radio\" name=\"zayend\" value=\"kur\"> Kur</label>\n    <label><input type=\"radio\" name=\"zayend\" value=\"keç\"> Keç</label>\n    <p>Zimanê programkirinê:</p>\n    <label><input type=\"checkbox\" name=\"ziman\" value=\"html\"> HTML</label>\n    <label><input type=\"checkbox\" name=\"ziman\" value=\"css\"> CSS</label>\n    <br><br>\n    <input type=\"submit\" value=\"Şandin\">\n  </form>\n</body>\n</html>"),

    lesson(12, $lv2so, $lv2ba, 'فۆڕمەکان - سلێکت و تێکستئاریا', 'فۆرم - سلێکت و تێکستئاریا',
        '<p><bdi>&lt;select&gt;</bdi> لیستی دابەزینە و <bdi>&lt;textarea&gt;</bdi> بۆ دەقی فرەهێڵ:</p><pre>&lt;select name="bajar"&gt;\n  &lt;option value="he"&gt;Hewlêr&lt;/option&gt;\n  &lt;option value="sl"&gt;Silêmanî&lt;/option&gt;\n&lt;/select&gt;\n\n&lt;textarea name="peyam" rows="4"&gt;&lt;/textarea&gt;</pre><p>بە <bdi>rows</bdi> و <bdi>cols</bdi> قەبارەی textarea دیاری دەکەیت.</p>',
        '<p><bdi>&lt;select&gt;</bdi> لیستا دابزینی و <bdi>&lt;textarea&gt;</bdi> بو نڤیسینا فرە خەتی:</p><pre>&lt;select name="bajar"&gt;\n  &lt;option value="he"&gt;Hewlêr&lt;/option&gt;\n  &lt;option value="sl"&gt;Silêmanî&lt;/option&gt;\n&lt;/select&gt;\n\n&lt;textarea name="peyam" rows="4"&gt;&lt;/textarea&gt;</pre><p>پێ <bdi>rows</bdi> و <bdi>cols</bdi> قەبارا textarea دیاری دکەی.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Select</title>\n</head>\n<body>\n  <form>\n    <label>Bajar:</label>\n    <select name=\"bajar\">\n      <option value=\"he\">Hewlêr</option>\n      <option value=\"sl\">Silêmanî</option>\n      <option value=\"dh\">Dihok</option>\n    </select>\n    <br><br>\n    <label>Peyam:</label>\n    <textarea name=\"peyam\" rows=\"4\" cols=\"30\">Peyama xwe binivîse...</textarea>\n    <br><br>\n    <input type=\"submit\" value=\"Şandin\">\n  </form>\n</body>\n</html>"),

    lesson(13, $lv2so, $lv2ba, 'تاقە سێمەنتیکەکان', 'تاگێن سێمەنتیک',
        '<p><strong>تاقە سێمەنتیکەکان</strong> واتای بەشەکە نیشان دەدەن، بۆ SEO و وێبئەکسیبلیتی باشتر:</p><ul><li><bdi>&lt;header&gt;</bdi> - سەری پەڕەکە</li><li><bdi>&lt;nav&gt;</bdi> - ناڤیگەیشن</li><li><bdi>&lt;main&gt;</bdi> - ناوەڕۆکی سەرەکی</li><li><bdi>&lt;section&gt;</bdi> - بەش</li><li><bdi>&lt;article&gt;</bdi> - بابەت</li><li><bdi>&lt;aside&gt;</bdi> - لاوەکی</li><li><bdi>&lt;footer&gt;</bdi> - دواوەی پەڕەکە</li></ul>',
        '<p><strong>تاگێن سێمەنتیک</strong> واتای پارچەکا رووپەلێ نیشان ددەن، بو SEO و وێبئەکسیبلیتی باشتر:</p><ul><li><bdi>&lt;header&gt;</bdi> - سەرێ رووپەلێ</li><li><bdi>&lt;nav&gt;</bdi> - ناڤیگەیشن</li><li><bdi>&lt;main&gt;</bdi> - ناڤەرۆکێ سەرەکی</li><li><bdi>&lt;section&gt;</bdi> - بەش</li><li><bdi>&lt;article&gt;</bdi> - بابەت</li><li><bdi>&lt;aside&gt;</bdi> - لاوەکی</li><li><bdi>&lt;footer&gt;</bdi> - دویاهیا رووپەلێ</li></ul>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Semantik</title>\n</head>\n<body>\n  <header>\n    <h1>Rûpelê Min</h1>\n  </header>\n  <nav>\n    <a href=\"#\">Mal</a> |\n    <a href=\"#\">Der barê</a> |\n    <a href=\"#\">Têkilî</a>\n  </nav>\n  <main>\n    <section>\n      <h2>Nûçe</h2>\n      <article><h3>Sernavê 1</h3><p>Naverok...</p></article>\n    </section>\n  </main>\n  <footer>\n    <p>Mafê telifê parastî ye</p>\n  </footer>\n</body>\n</html>"),

    lesson(14, $lv2so, $lv2ba, 'ڤیدیۆ و ئاودیۆ', 'ڤیدیۆ و دەنگ',
        '<p><bdi>&lt;video&gt;</bdi> و <bdi>&lt;audio&gt;</bdi> بۆ نیشاندانی میدیا:</p><pre>&lt;video src="video.mp4" controls width="400"&gt;&lt;/video&gt;\n&lt;audio src="deng.mp3" controls&gt;&lt;/audio&gt;</pre><p>ئەتریبیوتی <bdi>controls</bdi> کۆنترۆڵەکانی لێدان نیشان دەدات. <bdi>autoplay</bdi> بە شێوەی خۆکارانە لێی دەدات، <bdi>loop</bdi> دووبارە دەبێتەوە. <bdi>&lt;source&gt;</bdi> بۆ چەند فۆرماتێکی جیاواز.</p>',
        '<p><bdi>&lt;video&gt;</bdi> و <bdi>&lt;audio&gt;</bdi> بو نیشاندانا مێدیاییێ:</p><pre>&lt;video src="video.mp4" controls width="400"&gt;&lt;/video&gt;\n&lt;audio src="deng.mp3" controls&gt;&lt;/audio&gt;</pre><p>ئەتریبیوتا <bdi>controls</bdi> کۆنترۆلێن لێدانێ نیشان ددەت. <bdi>autoplay</bdi> ب شێوەیەکا خودکار لێ ددەت، <bdi>loop</bdi> دوبارە دبیت. <bdi>&lt;source&gt;</bdi> بو چەند فۆرماتان.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Video</title>\n</head>\n<body>\n  <h3>Vîdyoyeke fêrbûnê</h3>\n  <video controls width=\"400\">\n    <source src=\"https://www.w3schools.com/html/mov_bbb.mp4\" type=\"video/mp4\">\n    Vîdyoya te nehat piştgirîkirin.\n  </video>\n  <br><br>\n  <audio controls>\n    <source src=\"https://www.w3schools.com/html/horse.mp3\" type=\"audio/mpeg\">\n  </audio>\n</body>\n</html>"),

    lesson(15, $lv2so, $lv2ba, 'ئایفڕەیم (iframe)', 'ئایفڕەیم (iframe)',
        '<p><bdi>&lt;iframe&gt;</bdi> پەڕەیەکی تر لە ناو پەڕەکەتدا نیشان دەدات، بۆ یوتیوب، ماپ، و ئەپەکان:</p><pre>&lt;iframe src="https://www.youtube.com/embed/VIDEO_ID" width=\"560\" height=\"315\"&gt;&lt;/iframe&gt;</pre><p>بۆ نیشاندانی ڤیدیۆی یوتیوب، لە ناو پەڕەی ڤیدیۆکە بڕی <bdi>Share</bdi> و دواتر <bdi>Embed</bdi> و کۆدەکە کۆپی بکە. ئەتریبیوتی <bdi>title</bdi> بۆ وێبئەکسیبلیتی زیاد بکە.</p>',
        '<p><bdi>&lt;iframe&gt;</bdi> رووپەلەکا دی د ناڤ رووپەلا تە دا نیشان ددەت، بو یوتیوب، نەخشە و ئەپان:</p><pre>&lt;iframe src="https://www.youtube.com/embed/VIDEO_ID" width=\"560\" height=\"315\"&gt;&lt;/iframe&gt;</pre><p>بو نیشاندانا ڤیدیۆیێن یوتیوبێ، د رووپەلا ڤیدیۆیێ دا بیچە <bdi>Share</bdi> و پاشی <bdi>Embed</bdi> و کۆدە کۆپی بکە. ئەتریبیوتا <bdi>title</bdi> بو وێبئەکسیبلیتی زیاد بکە.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Iframe</title>\n</head>\n<body>\n  <h3>Vîdyo ji YouTube</h3>\n  <iframe src=\"https://www.youtube.com/embed/dQw4w9WgXcQ\" width=\"560\" height=\"315\" title=\"Vîdyoyek\"></iframe>\n</body>\n</html>"),

    lesson(16, $lv2so, $lv2ba, 'داتا ئەتریبیوتەکان', 'ئەتریبیوتێن داتایێ',
        '<p><bdi>data-*</bdi> ئەتریبیوتەکان داتای تایبەت لە تاقەکاندا دەهەڵگرن، بۆ JavaScript:</p><pre>&lt;div id="kart" data-nav=\"Rêzan\" data-temen=\"25\"&gt;...&lt;/div&gt;</pre><p>لە JavaScript بە <bdi>dataset</bdi> دەستی دەکەوێت:</p><pre>const kart = document.getElementById(\"kart\");\nconsole.log(kart.dataset.nav);   // Rêzan\nconsole.log(kart.dataset.temen); // 25</pre><p>ناوەکانی ئەتریبیوتەکە بە <bdi>-</bdi> دابەش دەکرێن و لە JS دا بە camelCase.</p>',
        '<p><bdi>data-*</bdi> ئەتریبیوت داتایا تایبەت د تاگان دا دگریت، بو JavaScript:</p><pre>&lt;div id="kart" data-nav=\"Rêzan\" data-temen=\"25\"&gt;...&lt;/div&gt;</pre><p>د JavaScript دا پێ <bdi>dataset</bdi> دچیتە دەست:</p><pre>const kart = document.getElementById(\"kart\");\nconsole.log(kart.dataset.nav);   // Rêzan\nconsole.log(kart.dataset.temen); // 25</pre><p>ناڤێن ئەتریبیوتان پێ <bdi>-</bdi> دابەش دبن و د JS دا ب camelCase.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Data Attribute</title>\n</head>\n<body>\n  <h3>Karta xwendekar</h3>\n  <div id=\"kart\" data-nav=\"Rêzan\" data-temen=\"25\" style=\"border:1px solid #333; padding:10px\">\n    Rêzan - 25 salî\n  </div>\n  <button onclick=\"nîşan()\">Nîşanî data</button>\n  <script>\n    function nîşan() {\n      const kart = document.getElementById(\"kart\");\n      alert(kart.dataset.nav + \" - \" + kart.dataset.temen);\n    }\n  </script>\n</body>\n</html>"),

    lesson(17, $lv2so, $lv2ba, 'دیڤ و سپان', 'دیڤ و سپان',
        '<p><bdi>&lt;div&gt;</bdi> تاقێکی بلۆکیە بۆ کۆکردنەوەی بەشەکان و <bdi>&lt;span&gt;</bdi> تاقێکی هێڵیە بۆ دەق:</p><ul><li><bdi>&lt;div&gt;</bdi> - هێڵی نوێ دەگرێتەوە، بۆ لایۆت</li><li><bdi>&lt;span&gt;</bdi> - لە ناو هێڵەکەدا دەمێنێتەوە، بۆ دەق</li></ul><p>بە <bdi>class</bdi> و <bdi>id</bdi> و <bdi>style</bdi> دەتوانیت ستایلیان بدەیت. div بە شێوەیەکی بەرفراوان لەگەڵ CSS و JavaScript بەکاردێت.</p>',
        '<p><bdi>&lt;div&gt;</bdi> تاگەکا بلۆکی یە بو کۆمکرنا پارچەیان و <bdi>&lt;span&gt;</bdi> تاگەکا خەتی یە بو نڤیسینێ:</p><ul><li><bdi>&lt;div&gt;</bdi> - خەتەکا نوی دگریت، بو لایۆت</li><li><bdi>&lt;span&gt;</bdi> - د ناڤ خەتێ دا دمینیت، بو نڤیسینێ</li></ul><p>پێ <bdi>class</bdi> و <bdi>id</bdi> و <bdi>style</bdi> دکەی ستایلی بدەی. div ب شێوەیەکا بەرفرەهان پێکڤە پێ CSS و JavaScript بکارتیت.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Div u Span</title>\n</head>\n<body>\n  <div style=\"background:#f0f0f0; padding:15px\">\n    <h3>Beşek</h3>\n    <p>Ev <span style=\"color:red; font-weight:bold\">deqê sor</span> e di nav wêniyê de.</p>\n  </div>\n  <div style=\"background:#e3f2fd; padding:15px; margin-top:10px\">\n    <h3>Beşek din</h3>\n    <p>Dîv û span her du jî pir bi kar tên.</p>\n  </div>\n</body>\n</html>"),

    lesson(18, $lv3so, $lv3ba, 'ئەتریبیوتە گشتەکان', 'ئەتریبیوتێن گشتی',
        '<p>ئەتریبیوتە گشتەکان بۆ هەموو تاقەکان بەکاردێن:</p><ul><li><bdi>class</bdi> - چەند تاق بەیەک دەبەستێت (CSS)</li><li><bdi>id</bdi> - تاقێکی تایبەت (یەک ناوەند)</li><li><bdi>style</bdi> - CSSی ڕاستەوخۆ</li><li><bdi>title</bdi> - تەنزیق کاتێک بەرچاو لە تاقەکە</li><li><bdi>lang</bdi> - زمانی ناوەڕۆک</li><li><bdi>dir</bdi> - ئاراستە: <bdi>rtl</bdi> یان <bdi>ltr</bdi></li><li><bdi>hidden</bdi> - شاردنەوە</li></ul>',
        '<p>ئەتریبیوتێن گشتی بو هەمی تاگان بکارتیت:</p><ul><li><bdi>class</bdi> - چەند تاگ پێکڤە دگریت (CSS)</li><li><bdi>id</bdi> - تاگەکا تایبەت</li><li><bdi>style</bdi> - CSSی راستەخۆ</li><li><bdi>title</bdi> - دەقێ ڕوناهیێ دەمە کو ل تاقێ دا بی</li><li><bdi>lang</bdi> - زمانێ ناڤەرۆکێ</li><li><bdi>dir</bdi> - ئاراستە: <bdi>rtl</bdi> یا <bdi>ltr</bdi></li><li><bdi>hidden</bdi> - ڤەشارتن</li></ul>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Attribute</title>\n</head>\n<body>\n  <h2 class=\"sereki\" id=\"serek\">Sereka rûpelê</h2>\n  <p lang=\"ku\" dir=\"rtl\">Ev nivîs bi kurmancî ye.</p>\n  <p title=\"Ev tenzîq e\">Li vir kursorê xwe bihêle</p>\n  <p hidden>Ev para nediye</p>\n</body>\n</html>"),

    lesson(19, $lv3so, $lv3ba, 'جۆرەکانی ئینپوت', 'چەشنێن ئینپوتی',
        '<p>جۆرەها جۆری <bdi>input</bdi> هەیە لە HTML5:</p><ul><li><bdi>email</bdi> - ئیمەیڵ (پشتڕاستکردنەوە)</li><li><bdi>password</bdi> - وشەی نهێنی</li><li><bdi>number</bdi> - ژمارە (min / max)</li><li><bdi>date</bdi> - بەروار</li><li><bdi>color</bdi> - ڕەنگ</li><li><bdi>range</bdi> - سلایدەر</li><li><bdi>file</bdi> - فایل</li></ul><p>هەر یەک جۆری خۆی ئاستی دەنووسێت و وێبگەڕەکە پشتڕاستی دەکاتەوە.</p>',
        '<p>چەند چەشنێن <bdi>input</bdi> د HTML5 دا هەن:</p><ul><li><bdi>email</bdi> - ئیمەیڵ (پشتڕاستکرن)</li><li><bdi>password</bdi> - پەیڤا نڤیشتی</li><li><bdi>number</bdi> - ژمارە (min / max)</li><li><bdi>date</bdi> - دیرۆک</li><li><bdi>color</bdi> - ڕەنگ</li><li><bdi>range</bdi> - سلایدەر</li><li><bdi>file</bdi> - پەڕگە</li></ul><p>هەر چەشنەکا یا خوە ڕوخسار و پشتڕاستکرنا وی هەیە.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <title>Input Types</title>\n</head>\n<body>\n  <form>\n    <label>E-mail: <input type=\"email\" name=\"email\"></label>\n    <br><br>\n    <label>Nimre: <input type=\"number\" name=\"nimre\" min=\"1\" max=\"100\"></label>\n    <br><br>\n    <label>Dîrok: <input type=\"date\" name=\"dîrok\"></label>\n    <br><br>\n    <label>Reng: <input type=\"color\" name=\"reng\"></label>\n    <br><br>\n    <label>Ast: <input type=\"range\" name=\"ast\" min=\"0\" max=\"10\"></label>\n    <br><br>\n    <input type=\"submit\" value=\"Şandin\">\n  </form>\n</body>\n</html>"),

    lesson(20, $lv3so, $lv3ba, 'مێتاداتا و SEO', 'مێتاداتا و SEO',
        '<p><bdi>&lt;meta&gt;</bdi> تاقەکان لە <bdi>&lt;head&gt;</bdi> دا زانیاری دەربارەی پەڕەکە دەدەن بۆ وێبگەڕ و گوگڵ:</p><pre>&lt;meta charset=\"UTF-8\"&gt;\n&lt;meta name=\"description\" content=\"...\"&gt;\n&lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"&gt;</pre><p><bdi>description</bdi> لە ئەنجامەکانی گوگڵ نیشان دەدرێت. <bdi>viewport</bdi> بۆ وێبپەڕە ڕیسپۆنسیڤەکان گرنگە. هەروەها <bdi>&lt;title&gt;</bdi> و سەرنووسەکان و <bdi>alt</bdi> ی وێنەکان کاریگەری SEO یان هەیە.</p>',
        '<p><bdi>&lt;meta&gt;</bdi> تاگ د ناڤ <bdi>&lt;head&gt;</bdi> دا زانیاری دەربارەی رووپەلێ ددەن بو وێبگەر و گوگڵ:</p><pre>&lt;meta charset=\"UTF-8\"&gt;\n&lt;meta name=\"description\" content=\"...\"&gt;\n&lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"&gt;</pre><p><bdi>description</bdi> د دەرئەنجامێن گوگڵ دا نیشان ددەت. <bdi>viewport</bdi> بو وێبپەڕێن ڕیسپۆنسیڤ گرنگە. هەروەسا <bdi>&lt;title&gt;</bdi> و سەردێڕ و <bdi>alt</bdi> یێن وێنەیان کاریگەرییا SEO یێ هەیە.</p>',
        "<!DOCTYPE html>\n<html lang=\"so\">\n<head>\n  <meta charset=\"UTF-8\">\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n  <meta name=\"description\" content=\"Kursên fêrbûna webê bi zimanê kurdî\">\n  <title>Kursên Kurdî</title>\n</head>\n<body>\n  <h1>Kursên Webê</h1>\n  <p>Fêrbûna HTML, CSS û JavaScript bi zimanê kurdî.</p>\n</body>\n</html>"),
];

foreach ($lessons as $lesson) {
    $lesson['langId'] = $langId;
    $res = fbPost($firebaseUrl . 'ferga_lessons.json', $lesson);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo "Lesson added: {$lesson['title_so']} -> {$d['name']}\n";
    } else {
        echo "ERROR adding lesson {$lesson['title_so']}: $res\n";
    }
}

echo "\nDone! HTML lessons 1-20 added.\n";
