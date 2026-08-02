<?php

// Script to add JavaScript lessons (1-10) to the Ferga section in Firebase.
// Language already exists as -Oysj4NVk0PGRLQx2Z8o; we just post lessons and unlock it.
if (!defined('FERGA_SEED_LIB')) {
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-Oysj4NVk0PGRLQx2Z8o';

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

function fbPatch($url, $data) {
    global $idToken;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $idToken, 'Content-Type: application/json']);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

// JavaScript language already exists; just unlock it.
fbPatch($firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
echo "Language JavaScript unlocked.\n";

function fixContent($html) {
    $html = preg_replace('/(?<!")\\\\n/', "\n", $html);
    $html = preg_replace('/<(?![\/a-zA-Z!?])/', '&lt;', $html);
    return $html;
}
}

$lessons = [
    [
        'order' => 1,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'چییە JavaScript؟',
        'title_ba' => 'چ یە JavaScript؟',
        'content_so' => '<p><strong>JavaScript</strong> زمانی وێبی مۆدێرنە بۆ ئەپلیکەیشنی کارلێککەر. بە نێوەندگیری ئەم زمانە دەتوانیت سایتەکان زیندوو بکەیت، و لە ڕێگەی <bdi>Node.js</bdi>شەوە لە سەرڤەردا کاردەکات.</p><p>چی دەتوانیت پێی بکەیت:</p><ul><li>کارلێککردن لەگەڵ بەکارهێنەر لە وێبگەڕدا</li><li>دروستکردنی ئەپلیکەیشن لە سەرڤەر (Node.js)</li><li>دروستکردنی یاری و ئەنیمەیشن</li></ul><p><code>console.log()</code> دەقێک لە کۆنسۆڵدا چاپ دەکات — سادەترین ڕێگایە بۆ بینینی ئەنجام.</p>',
        'content_ba' => '<p><strong>JavaScript</strong> زمانێ وێبی مۆدێرنە بو ئەپلیکەیشنێن کارلێککەر. پێ ڤی زمانی تۆ دکەی مالپەران زیندوو بکی، و ژ رێکا <bdi>Node.js</bdi> ڤە ل سەر سێرڤەری دا کاردکەت.</p><p>چی تۆ دکەی پێ بکی:</p><ul><li>کارلێککرن ل گەل بکارهێنەری ل براوزەری دا</li><li>دروستکرنا ئەپلیکەیشنێ ل سەر سێرڤەری (Node.js)</li><li>دروستکرنا یاری و ئەنیمەیشنان</li></ul><p><code>console.log()</code> نڤیسینەک د کۆنسۆلی دا چاپ دکەت — ڕێگا هەراسانتینە بو دیتنا دەرئەنجامان.</p>',
        'code' => 'console.log("Hello from JavaScript!");',
        'example_output' => 'Hello from JavaScript!',
        'challenge_desc_so' => 'پرۆگرامێک بنووسە کە "Bêxhatin bo JavaScript!" چاپ بکات',
        'challenge_desc_ba' => 'پرۆگرامەک بنڤیسە کو "Bêxhatin bo JavaScript!" چاپ بکەت',
        'expected_output' => 'Bêxhatin bo JavaScript!',
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'گۆڕاوەکان و جۆرەکانی داتا',
        'title_ba' => 'گۆڕۆک و چەشنێن داتایێ',
        'content_so' => '<p><strong>گۆڕاو (Variable)</strong> شوێنێکە لە یادگەدا کە بەهایەک لە خۆ دەگرێت. لە JavaScript بە <code>let</code> و <code>const</code> گۆڕاو دروست دەکەیت:</p><pre>let name = "Kurd";        // دەق (string)\nlet score = 95;           // ژمارە\nconst year = 2026;        // نەگۆڕ (const)\nlet passed = true;        // ڕاست یان هەڵە (boolean)</pre><p>جیاوازی <code>let</code> و <code>const</code>: بەهاکەی <code>const</code> ناتوانرێت دوای دروستکردن بیگۆڕیت. بە <code>typeof</code> جۆری داتاکە دەزانیت.</p>',
        'content_ba' => '<p><strong>گۆڕۆک (Variable)</strong> جهەکە د بیرێ دا کو بەهایەک د خۆ دا دگریت. د JavaScript دا پێ <code>let</code> و <code>const</code> گۆڕۆک دروست دکەی:</p><pre>let name = "Kurd";        // نڤیسین (string)\nlet score = 95;           // ژمارە\nconst year = 2026;        // نەگۆڕ (const)\nlet passed = true;        // راست یا خەلەت (boolean)</pre><p>فەرقا <code>let</code> و <code>const</code>: بەهایا <code>const</code> پی د نایە دوی د دروستکرنێ دا بگۆڕی. پێ <code>typeof</code> چەشنێ داتایێ دزانی.</p>',
        'code' => 'let name = "Kurd";
const year = 2026;
let score = 95;

console.log(name);
console.log(year);
console.log(score);',
        'example_output' => 'Kurd
2026
95',
        'challenge_desc_so' => 'گۆڕاوێک بە ناوی "city" بە بەهای "Hewlêr" دروست بکە و چاپی بکە',
        'challenge_desc_ba' => 'گۆڕۆکەک ب ناڤێ "city" ب بەهایا "Hewlêr" دروست بکە و چاپا وی بکە',
        'expected_output' => 'Hewlêr',
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>بە <code>if</code> و <code>else</code> دەتوانیت بڕیار بدەیت. ئەگەر مەرجەکە ڕاست بێت، بلۆکێکی کۆد جێبەجێ دەبێت:</p><pre>let score = 85;\n\nif (score >= 50) {\n    console.log("Bêşar!");\n} else {\n    console.log("Caw!");\n}</pre><p>ئۆپێراتۆرەکانی بەراوردکردن: <code>==</code>، <code>===</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. بۆ ئۆپێراتۆرە لۆژیکییەکانیش: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'content_ba' => '<p>پێ <code>if</code> و <code>else</code> تۆ دکەی بریار بدەی. گەر مەرج راست بیت، بلۆکەکا کۆدی جێبەجێ دبیت:</p><pre>let score = 85;\n\nif (score >= 50) {\n    console.log("Bêşar!");\n} else {\n    console.log("Caw!");\n}</pre><p>ئۆپێراتۆرێن بەراوردکرنێ: <code>==</code>، <code>===</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. ئۆپێراتۆرێن لۆژیک: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'code' => 'let score = 85;

if (score >= 50) {
    console.log("Bêşar!");
} else {
    console.log("Caw!");
}',
        'example_output' => 'Bêşar!',
        'challenge_desc_so' => 'مەرجێک بنووسە: ئەگەر age=16 کەمتر بوو لە ١٨ "Law" چاپ بکات، بێ نەوەک "Adil"',
        'challenge_desc_ba' => 'مەرجەک بنڤیسە: گەر age=16 کێمتر بیت ژ ١٨ "Law" چاپ بکەت، نەوەک "Adil"',
        'expected_output' => 'Law',
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'خولگەکان (Loops)',
        'title_ba' => 'گەڕخستن (Loops)',
        'content_so' => '<p><strong>خولگە (Loop)</strong> کۆدێک چەند جار دووبارە دەکاتەوە. سەرەکیترینیان <code>for</code> و <code>while</code> یە:</p><pre>// for - کاتێک ژمارەی تکرارەکان زانراوە\nfor (let i = 1; i <= 5; i++) {\n    console.log(i);\n}\n\n// while - کاتێک مەرجەکە ڕاستە\nlet j = 0;\nwhile (j < 3) {\n    console.log("Salam " + j);\n    j++;\n}</pre><p>ئەم کۆدە ئەنجام دەدات: <code>1 2 3 4 5</code> ئینجا سێ جار "Salam".</p>',
        'content_ba' => '<p><strong>گەڕخستن (Loop)</strong> کۆدێ چەند جاران دوبارە دکەت. سەرەکێنترین هەر <code>for</code> و <code>while</code> یە:</p><pre>// for - دەمە کو ژمارا دوبارەکرنێ زانرایە\nfor (let i = 1; i <= 5; i++) {\n    console.log(i);\n}\n\n// while - دەمە کو مەرج راستە\nlet j = 0;\nwhile (j < 3) {\n    console.log("Salam " + j);\n    j++;\n}</pre><p>ئەڤ کۆدە دەرئەنجام ددەت: <code>1 2 3 4 5</code> پاشی سێ جاران "Salam".</p>',
        'code' => 'for (let i = 1; i <= 5; i++) {
    console.log(i);
}',
        'example_output' => '1
2
3
4
5',
        'challenge_desc_so' => 'خولگەیەک بنووسە کە ١٠ بۆ ١ بە پاشەوە لە یەک ڕیزدا چاپ بکات',
        'challenge_desc_ba' => 'گەڕخستنەک بنڤیسە کو ١٠ هەتا ١ ب پاشدا د یەک ڕیزێ دا چاپ بکەت',
        'expected_output' => '10 9 8 7 6 5 4 3 2 1',
    ],
    [
        'order' => 5,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکان (Functions)',
        'title_ba' => 'فەنکشن (Functions)',
        'content_so' => '<p><strong>فەنکشن</strong> بلۆکێکی کۆدە کە ئەرکێکی دیاریکراو جێبەجێ دەکات و دەتوانیت چەند جار بەکاری بهێنیت:</p><pre>// فەنکشنی ئاسایی\nfunction add(a, b) {\n    return a + b;\n}\n\n// فەنکشنی arrow (هەمان شت بە کورتی)\nconst add2 = (a, b) => a + b;\n\nconsole.log(add(5, 3));   // 8\nconsole.log(add2(5, 3));  // 8</pre><p>فەنکشنەکان کۆدەت لە تکرار ڕزگار دەکەن و بەرنامەکەت ڕێک و خوێنەر دەکەن.</p>',
        'content_ba' => '<p><strong>فەنکشن</strong> بلۆکەکا کۆدی یە کو ئەرکەکا دیاریکراو جێبەجێ دکەت و تۆ دکەی چەند جاران بکاربینی:</p><pre>// فەنکشنێ ئاسایی\nfunction add(a, b) {\n    return a + b;\n}\n\n// فەنکشنێ arrow (هەمان شت ب کورتاهێ)\nconst add2 = (a, b) => a + b;\n\nconsole.log(add(5, 3));   // 8\nconsole.log(add2(5, 3));  // 8</pre><p>فەنکشن کۆدێ تە ژ دوبارەکرنێ دەرگین و بەرنامەکەت ڕێک و هەلبژەر دکەت.</p>',
        'code' => 'function add(a, b) {
    return a + b;
}

const sum = add(5, 3);
console.log("Sum = " + sum);',
        'example_output' => 'Sum = 8',
        'challenge_desc_so' => 'فەنکشنێکی "multiply" دروست بکە کە دوو ژمارە زۆر بکات و ئەنجامی ٦×٧ چاپ بکات',
        'challenge_desc_ba' => 'فەنکشنەکا "multiply" دروست بکە کو دوو ژماران زێدە بکەت و ئەنجامێ ٦×٧ چاپ بکەت',
        'expected_output' => '42',
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارایەکان (Arrays)',
        'title_ba' => 'ئارای (Arrays)',
        'content_so' => '<p><strong>ئارای (Array)</strong> کۆمەڵێک بەها لە یەک گۆڕاودا دەگرێت. ئیندێکسەکان لە <strong>٠</strong> دەست پێ دەکەن:</p><pre>let langs = ["Kurd", "Arab", "Turk"];\n\nconsole.log(langs[0]);          // Kurd\nconsole.log(langs.length);      // 3\nlangs.push("Eram");             // زیادکردن لە کۆتایی\nlangs.pop();                    // لابردنی کۆتایی</pre><p>بە خولگەی <code>for</code> دەتوانیت بەسەر هەموو ئەندامەکاندا بسوڕێیتەوە.</p>',
        'content_ba' => '<p><strong>ئارای (Array)</strong> کۆمەکەک بەها د یەک گۆڕۆکی دا دگریت. ئیندێکس ژ <strong>٠</strong> دەست پێ دکەن:</p><pre>let langs = ["Kurd", "Arab", "Turk"];\n\nconsole.log(langs[0]);          // Kurd\nconsole.log(langs.length);      // 3\nlangs.push("Eram");             // زێدەکرن د کۆتایێ دا\nlangs.pop();                    // ژبیرکردنا کۆتایێ</pre><p>پێ گەڕخستنا <code>for</code> تۆ دکەی بسەر هەمی ئەندامان دا بگەڕی.</p>',
        'code' => 'let langs = ["Kurd", "Arab", "Turk"];

for (let i = 0; i < langs.length; i++) {
    console.log(langs[i]);
}',
        'example_output' => 'Kurd
Arab
Turk',
        'challenge_desc_so' => 'ئارایەکی "cities" بە Hewlêr و Silêmanî و Duhok دروست بکە و بە join هەمووی لە یەک ڕیزدا چاپ بکە',
        'challenge_desc_ba' => 'ئارایەکی "cities" ب Hewlêr و Silêmanî و Duhok دروست بکە و پێ join هەمی د یەک ڕیزێ دا چاپ بکە',
        'expected_output' => 'Hewlêr Silêmanî Duhok',
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەقەکان (Strings)',
        'title_ba' => 'نڤیسین (Strings)',
        'content_so' => '<p>دەقەکان لە JavaScript تایبەتمەندی و فەنکشنی زۆریان هەیە:</p><pre>let city = "Hewlêr";\n\ncity.length            // 6 - ژمارەی پیتەکان\ncity.toUpperCase()     // HEWLÊR\ncity.toLowerCase()     // hewlêr\ncity.includes("Hew")   // true\n\n// Template literal - دەقێک کە گۆڕاو تێدایە\nlet msg = `Salam, ${city}!`;\nconsole.log(msg);      // Salam, Hewlêr!</pre><p><bdi>Template literals</bdi> بە <code>`...`</code> دەنووسرێن و بە <code>${...}</code> گۆڕاو تێدا دەخەیت.</p>',
        'content_ba' => '<p>نڤیسین ل JavaScript دا تایبەتمەندی و فەنکشنێن زاف هەن:</p><pre>let city = "Hewlêr";\n\ncity.length            // 6 - ژمارا پیتان\ncity.toUpperCase()     // HEWLÊR\ncity.toLowerCase()     // hewlêr\ncity.includes("Hew")   // true\n\n// Template literal - نڤیسینەکا کو گۆڕۆک تێدایە\nlet msg = `Salam, ${city}!`;\nconsole.log(msg);      // Salam, Hewlêr!</pre><p><bdi>Template literals</bdi> پێ <code>`...`</code> دەنڤیسن و پێ <code>${...}</code> گۆڕۆک د ناڤدا دخی.</p>',
        'code' => 'const city = "Hewlêr";
const country = "Kurdistan";

console.log(`Salam, ${city}!`);
console.log(country.toUpperCase());',
        'example_output' => 'Salam, Hewlêr!
KURDISTAN',
        'challenge_desc_so' => 'بە .length ژمارەی پیتەکانی "Kurdistan" چاپ بکە',
        'challenge_desc_ba' => 'پێ .length ژمارا پیتێن "Kurdistan" چاپ بکە',
        'expected_output' => '9',
    ],
    [
        'order' => 8,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئۆبجێکتەکان (Objects)',
        'title_ba' => 'ئۆبجێکت (Objects)',
        'content_so' => '<p><strong>ئۆبجێکت</strong> زانیارییەکی تێروتەسەل لە خۆ دەگرێت وەک <code>key: value</code>:</p><pre>const student = {\n    name: "Ava",\n    grade: 95,\n    city: "Hewlêr"\n};\n\nconsole.log(student.name);    // Ava\nconsole.log(student["city"]); // Hewlêr\nstudent.grade = 100;          // گۆڕینی بەها</pre><p>ئۆبجێکتەکان زۆر بەکارن بۆ نوێنەرایەتیکردنی شتی ڕاستەقینە وەک خوێندکار، ئۆتۆمبێل یان بەرهەم.</p>',
        'content_ba' => '<p><strong>ئۆبجێکت</strong> زانیارییەکا تەمام د خۆ دا دگریت وەک <code>key: value</code>:</p><pre>const student = {\n    name: "Ava",\n    grade: 95,\n    city: "Hewlêr"\n};\n\nconsole.log(student.name);    // Ava\nconsole.log(student["city"]); // Hewlêr\nstudent.grade = 100;          // گۆڕینا بەهایێ</pre><p>ئۆبجێکت زۆر بکارتین بو نیشاندانا شتی ڕاستەقینە وەک خواندکار، ئۆتوموبیل یا بەرهەم.</p>',
        'code' => 'const student = {
    name: "Ava",
    grade: 95,
    city: "Hewlêr"
};

console.log(student.name + ": " + student.grade);',
        'example_output' => 'Ava: 95',
        'challenge_desc_so' => 'ئۆبجێکتێکی "book" دروست بکە بە تایبەتمەندی title="Kurdi" و چاپی بکە',
        'challenge_desc_ba' => 'ئۆبجێکتەکا "book" دروست بکە ب تایبەتمەندی title="Kurdi" و چاپا وی بکە',
        'expected_output' => 'Kurdi',
    ],
    [
        'order' => 9,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ئۆبجێکتی Math',
        'title_ba' => 'ئۆبجێکتێ Math',
        'content_so' => '<p>JavaScript ئۆبجێکتی <code>Math</code> ی هەیە کە فەنکشنی بیرکاری تێدایە:</p><pre>Math.max(3, 9, 5)     // 9\nMath.min(3, 9, 5)     // 3\nMath.floor(3.99)      // 3 - دابەزاندن\nMath.ceil(3.01)       // 4 - بەرزکردنەوە\nMath.round(3.5)       // 4 - نزیکترین تەواو\nMath.random()         // ژمارەی هەڕەمەکی ٠-١\nMath.pow(2, 3)        // 8 - توان</pre><p>بە <code>Math.random()</code> ژمارەی هەڕەمەکی دروست دەکەیت — بۆ یارییەکان و هەڵبژاردنی ڕووداو زۆر بەسوودە.</p>',
        'content_ba' => '<p>JavaScript ئۆبجێکتێ <code>Math</code> ی یە کو فەنکشنێن بیرکاری تێدایە:</p><pre>Math.max(3, 9, 5)     // 9\nMath.min(3, 9, 5)     // 3\nMath.floor(3.99)      // 3 - دابەزاندن\nMath.ceil(3.01)       // 4 - بلندکرن\nMath.round(3.5)       // 4 - نزیکترین تەمام\nMath.random()         // ژمارە هەڕەمەکی ٠-١\nMath.pow(2, 3)        // 8 - توان</pre><p>پێ <code>Math.random()</code> ژمارە هەڕەمەکی دروست دکەی — بو یاریان و هەلبژارتنا ڕووداڤان زۆر ب سوودە.</p>',
        'code' => 'console.log(Math.max(3, 9, 5));
console.log(Math.floor(3.99));',
        'example_output' => '9
3',
        'challenge_desc_so' => 'بە Math.round ئەنجامی ٣.١٤ بگێڕە بۆ ژمارەی تەواو و چاپی بکە',
        'challenge_desc_ba' => 'پێ Math.round ئەنجامێ ٣.١٤ بگەڕینە ژمارە تەمام و چاپا وی بکە',
        'expected_output' => '3',
    ],
    [
        'order' => 10,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: کۆکردنەوەی ژمارەکان',
        'title_ba' => 'پرۆژە: کومکرنا ژماران',
        'content_so' => '<p>ئێستا هەموو ئەو شتانەی کە فێری بوویت یەکبخەین: خولگە، گۆڕاو و فەنکشن. پرۆژەکە: کۆی ژمارەکانی ١ بۆ ١٠ بدۆزەرەوە.</p><p>فەنکشنێک دروست دەکەین کە <code>total</code> وەردگرێت و لە نێو خولگەی <code>for</code>دا کۆی دەکات:</p><pre>let total = 0;\n\nfor (let i = 1; i <= 10; i++) {\n    total += i;\n}\n\nconsole.log("Total = " + total);</pre><p>بە سادەترین شێوە: ١+٢+٣+...+١٠ = <strong>٥٥</strong>.</p>',
        'content_ba' => '<p>ئێستا هەمی ئەڤان یەکبخین کو فێر بووی: گەڕخستن، گۆڕۆک و فەنکشن. پرۆژە: کوما ژمارێن ١ هەتا ١٠ بدۆزە.</p><p>فەنکشنەک دروست دکەین کو <code>total</code> هەلگریت و د ناڤ گەڕخستنا <code>for</code> دا کوم دکەت:</p><pre>let total = 0;\n\nfor (let i = 1; i <= 10; i++) {\n    total += i;\n}\n\nconsole.log("Total = " + total);</pre><p>ب شێوەیەکا هەراسان: ١+٢+٣+...+١٠ = <strong>٥٥</strong>.</p>',
        'code' => 'let total = 0;

for (let i = 1; i <= 10; i++) {
    total += i;
}

console.log("Total = " + total);',
        'example_output' => 'Total = 55',
        'challenge_desc_so' => 'فەکتۆریاڵی ٥ بدۆزەرەوە (١×٢×٣×٤×٥) و ئەنجامەکە چاپ بکە',
        'challenge_desc_ba' => 'فاکتۆریالا ٥ بدۆزە (١×٢×٣×٤×٥) و دەرئەنجام چاپ بکە',
        'expected_output' => '120',
    ],
    [
        'order' => 11,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'گۆڕینی جۆرەکان (Type Conversion)',
        'title_ba' => 'گۆڕینا چەشنان (Type Conversion)',
        'content_so' => '<p><strong>گۆڕینی جۆرەکان (Type Conversion)</strong> وا دەکات بەهایەک لە جۆرێکەوە بگۆڕێت بۆ جۆرێکی تر. بە <code>Number()</code> دەقێک دەبێت بە ژمارە، بە <code>String()</code> ژمارە دەبێت بە دەق:</p><pre>let num = "42";\n\nconsole.log(Number(num) + 8);     // 50\nconsole.log(typeof Number(num));  // number\n\nconsole.log(String(100).length);  // 3 - "100"</pre><p>هەروەها <code>parseInt()</code> و <code>parseFloat()</code> دەقەکان لە سەرەتاوە بۆ ژمارە دەگۆڕن.</p>',
        'content_ba' => '<p><strong>گۆڕینا چەشنان (Type Conversion)</strong> دکەت بەهایەک ژ چەشنەکە بۆ چەشنا دیت. پێ <code>Number()</code> نڤیسین دبیت ژمارە، پێ <code>String()</code> ژمارە دبیت نڤیسین:</p><pre>let num = "42";\n\nconsole.log(Number(num) + 8);     // 50\nconsole.log(typeof Number(num));  // number\n\nconsole.log(String(100).length);  // 3 - "100"</pre><p>هەروەکا <code>parseInt()</code> و <code>parseFloat()</code> نڤیسین ژ دەستپێکا دگەڕیننە ژمارە.</p>',
        'code' => 'let num = "42";
let converted = Number(num);
console.log(converted + 8);
console.log(typeof converted);',
        'example_output' => '50
number',
        'challenge_desc_so' => 'بە Number بەهای "10" بۆ ژمارە بگێڕە و ٥ی پێ زیاد بکە و چاپی بکە',
        'challenge_desc_ba' => 'پێ Number بەهایا "10" بگەڕینە ژمارە و ٥ زێدە بکە سەر و چاپا وی بکە',
        'expected_output' => '15',
    ],
    [
        'order' => 12,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی while',
        'title_ba' => 'گەڕخستنا while',
        'content_so' => '<p><strong>خولگەی <code>while</code></strong> هێندە تکرار دەبێتەوە تا مەرجەکە ڕاستە. ئەگەر مەرجەکە لە سەرەتاوە هەڵە بێت، خولگەکە هەرگیز جێبەجێ نابێت:</p><pre>let i = 1;\n\nwhile (i <= 5) {\n    console.log("Step " + i);\n    i++;\n}</pre><p>لە ناوەوە دەبێت <code>i++</code> بێت، نەوەک خولگەکە هەرگیز نەوەستێت.</p>',
        'content_ba' => '<p><strong>گەڕخستنا <code>while</code></strong> بۆ دەمەکی دوبارە دبیتەڤە هەتا مەرج راستە. گەر مەرج ژ دەستپێکا خەلەت بیت، گەڕخستن چ جارەکا جێبەجێ نابیت:</p><pre>let i = 1;\n\nwhile (i <= 5) {\n    console.log("Step " + i);\n    i++;\n}</pre><p>د ناڤدا دا دڤێ <code>i++</code> هەبیت، نەوەک گەڕخستن هەرگیز نەوەستیت.</p>',
        'code' => 'let i = 1;
while (i <= 5) {
    console.log("Step " + i);
    i++;
}',
        'example_output' => 'Step 1
Step 2
Step 3
Step 4
Step 5',
        'challenge_desc_so' => 'بە while ژمارە جووتەکانی ٢ بۆ ١٠ بە بۆشایی چاپ بکە',
        'challenge_desc_ba' => 'پێ while ژمارێن جووت یێن ٢ هەتا ١٠ ب بۆشایی چاپ بکە',
        'expected_output' => '2 4 6 8 10',
    ],
    [
        'order' => 13,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'مەرجی switch',
        'title_ba' => 'مەرجێ switch',
        'content_so' => '<p><strong><code>switch</code></strong> دەتوانێت بەهایەک لەگەڵ چەند حاڵەتدا بەراورد بکات و لە حاڵەتی هاوشێوە کۆد جێبەجێ بکات. لە کۆتایی هەر حاڵەتێک <code>break</code> دەبێت:</p><pre>let grade = "B";\n\nswitch (grade) {\n    case "A":\n        console.log("Baş!");\n        break;\n    case "B":\n        console.log("Navincî!");\n        break;\n    default:\n        console.log("Divê bixwînî!");\n}</pre><p>ئەگەر هیچ حاڵەتێک نەگونجیت، <code>default</code> جێبەجێ دەبێت.</p>',
        'content_ba' => '<p><strong><code>switch</code></strong> دکەت بەهایەک ب ل گەل چەند حاڵەتێن دا بەراورد بکەت و د حاڵەتا هەوشێوە دا کۆد جێبەجێ بکەت. د دوی هەر حاڵەتەک دا <code>break</code> دڤێ بیت:</p><pre>let grade = "B";\n\nswitch (grade) {\n    case "A":\n        console.log("Baş!");\n        break;\n    case "B":\n        console.log("Navincî!");\n        break;\n    default:\n        console.log("Divê bixwînî!");\n}</pre><p>گەر چ حاڵەتەک نەگونجیت، <code>default</code> جێبەجێ دبیت.</p>',
        'code' => 'let grade = "B";

switch (grade) {
    case "A":
        console.log("Baş!");
        break;
    case "B":
        console.log("Navincî!");
        break;
    default:
        console.log("Divê bixwînî!");
}',
        'example_output' => 'Navincî!',
        'challenge_desc_so' => 'بە switch دەنگێکی ئاژەڵ "Pisîk" چاپ بکە: "Mîyaw!"',
        'challenge_desc_ba' => 'پێ switch دەنگەکا ئاژەڵ "Pisîk" چاپ بکە: "Mîyaw!"',
        'expected_output' => 'Mîyaw!',
    ],
    [
        'order' => 14,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئۆپێراتۆری سێگۆشەیی (Ternary)',
        'title_ba' => 'ئۆپێراتۆرێ سێگۆشەیی (Ternary)',
        'content_so' => '<p><strong>ئۆپێراتۆری سێگۆشەیی (Ternary)</strong> کورترین شێوازی نووسینی <code>if/else</code> یە:</p><pre>let age = 20;\n\nlet result = age >= 18 ? "Adil" : "Law";\nconsole.log(result);   // Adil</pre><p>شێوازەکەی: <code>مەرج ? ئەگەر ڕاست : ئەگەر هەڵە</code>. زۆر باشە بۆ بەهای کورت.</p>',
        'content_ba' => '<p><strong>ئۆپێراتۆرێ سێگۆشەیی (Ternary)</strong> کورترین ڕێگایا نڤیسینا <code>if/else</code> یە:</p><pre>let age = 20;\n\nlet result = age >= 18 ? "Adil" : "Law";\nconsole.log(result);   // Adil</pre><p>شێوازا وی: <code>مەرج ? گەر راست : گەر خەلەت</code>. باشە بو بەهایێن کورت.</p>',
        'code' => 'let age = 20;
let result = age >= 18 ? "Adil" : "Law";
console.log(result);',
        'example_output' => 'Adil',
        'challenge_desc_so' => 'بە ternary ئەگەر score=60 بوو، "Bêşar" چاپ بکە بێ نەوەک "Caw"',
        'challenge_desc_ba' => 'پێ ternary گەر score=60 بیت، "Bêşar" چاپ بکە نەوەک "Caw"',
        'expected_output' => 'Bêşar',
    ],
    [
        'order' => 15,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'map و filter',
        'title_ba' => 'map و filter',
        'content_so' => '<p>دوو فەنکشنی بەسوود بۆ ئارایەکان: <code>map()</code> هەر ئەندامێک دەگۆڕێت، <code>filter()</code> ئەو ئەندامانە دەپاڵێوێت کە مەرج پڕ دەکەن:</p><pre>let numbers = [1, 2, 3, 4, 5];\n\nlet doubled = numbers.map(n => n * 2);\nlet evens = numbers.filter(n => n % 2 === 0);\n\nconsole.log(doubled);   // [ 2, 4, 6, 8, 10 ]\nconsole.log(evens);     // [ 2, 4 ]</pre><p>هەردووکیان ئارایەکی نوێ دەگەڕێننەوە و ئارایە ڕەسەنەکە ناگۆڕن.</p>',
        'content_ba' => '<p>دوو فەنکشنێن ب سودا بو ئارایان: <code>map()</code> هەر ئەندامەک دگۆڕیت، <code>filter()</code> ئەو ئەندامان دپارێزیت کو مەرج تێر دکەن:</p><pre>let numbers = [1, 2, 3, 4, 5];\n\nlet doubled = numbers.map(n => n * 2);\nlet evens = numbers.filter(n => n % 2 === 0);\n\nconsole.log(doubled);   // [ 2, 4, 6, 8, 10 ]\nconsole.log(evens);     // [ 2, 4 ]</pre><p>هەردوو ئارایەکا نوێ دگەڕیننەڤە و ئارایا ڕەسەن ناگۆڕن.</p>',
        'code' => 'let numbers = [1, 2, 3, 4, 5];

let doubled = numbers.map(n => n * 2);
let evens = numbers.filter(n => n % 2 === 0);

console.log(doubled);
console.log(evens);',
        'example_output' => '[ 2, 4, 6, 8, 10 ]
[ 2, 4 ]',
        'challenge_desc_so' => 'بە filter ئەو ژمارانە بدۆزەرەوە کە لە ٣ گەورەترن لە [1, 2, 3, 4, 5, 6] و چاپیان بکە',
        'challenge_desc_ba' => 'پێ filter ئەو ژماران بدۆزە کو ژ ٣ مەزنترن د [1, 2, 3, 4, 5, 6] دا و چاپا وان بکە',
        'expected_output' => '[ 4, 5, 6 ]',
    ],
    [
        'order' => 16,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'forEach و reduce',
        'title_ba' => 'forEach و reduce',
        'content_so' => '<p><code>forEach()</code> بەسەر هەموو ئەندامانی ئارایەکدا دەسوڕێتەوە، <code>reduce()</code> هەموو ئەندامانەکە بۆ یەک بەها کۆ دەکاتەوە:</p><pre>let numbers = [5, 10, 15];\nlet total = 0;\n\nnumbers.forEach(n => {\n    total += n;\n});\n\nconsole.log("Total = " + total);   // 30</pre><p>بە <code>reduce</code> هەمان شت: <code>numbers.reduce((acc, n) =&gt; acc + n, 0)</code>.</p>',
        'content_ba' => '<p><code>forEach()</code> بسەر هەمی ئەندامێن ئارایەک دا دگەڕیت، <code>reduce()</code> هەمی ئەندامان بو یەک بەهایێ کۆ دکەتەڤە:</p><pre>let numbers = [5, 10, 15];\nlet total = 0;\n\nnumbers.forEach(n => {\n    total += n;\n});\n\nconsole.log("Total = " + total);   // 30</pre><p>پێ <code>reduce</code> هەمان شت: <code>numbers.reduce((acc, n) =&gt; acc + n, 0)</code>.</p>',
        'code' => 'let numbers = [5, 10, 15];
let total = 0;

numbers.forEach(n => {
    total += n;
});

console.log("Total = " + total);',
        'example_output' => 'Total = 30',
        'challenge_desc_so' => 'بە reduce ئەنجامی ١×٢×٣×٤ بدۆزەرەوە و چاپی بکە',
        'challenge_desc_ba' => 'پێ reduce ئەنجامێ ١×٢×٣×٤ بدۆزە و چاپا وی بکە',
        'expected_output' => '24',
    ],
    [
        'order' => 17,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'میتۆدەکانی ئۆبجێکت و this',
        'title_ba' => 'میتۆدێن ئۆبجێکتێ و this',
        'content_so' => '<p>ئۆبجێکت دەتوانێت فەنکشن لە خۆ بگرێت بە ناوی <bdi>میتۆد (method)</bdi>. لە ناو ئەو فەنکشنەدا <code>this</code> ئاماژە بە خۆی ئۆبجێکتەکە دەکات:</p><pre>const person = {\n    name: "Ava",\n    age: 20,\n    introduce() {\n        console.log("Salam, min navê wê " + this.name + " ye.");\n    }\n};\n\nperson.introduce();</pre><p>بە <code>this.name</code> تایبەتمەندییەکانی ئۆبجێکتەکە دەخوێنیتەوە.</p>',
        'content_ba' => '<p>ئۆبجێکت دکەت فەنکشن د خۆ دا بگریت ب ناڤێ <bdi>میتۆد (method)</bdi>. د ناڤ وی فەنکشنێ دا <code>this</code> ئاماژە بو خودێ ئۆبجێکتە دکەت:</p><pre>const person = {\n    name: "Ava",\n    age: 20,\n    introduce() {\n        console.log("Salam, min navê wê " + this.name + " ye.");\n    }\n};\n\nperson.introduce();</pre><p>پێ <code>this.name</code> تایبەتمەندیێن ئۆبجێکتە دخوانی.</p>',
        'code' => 'const person = {
    name: "Ava",
    age: 20,
    introduce() {
        console.log("Salam, min navê wê " + this.name + " ye.");
    }
};

person.introduce();',
        'example_output' => 'Salam, min navê wê Ava ye.',
        'challenge_desc_so' => 'ئۆبجێکتێکی "person" بە name="Hêmin" و میتۆدی greet دروست بکە کە "Bêxhatin, Hêmin!" چاپ بکات',
        'challenge_desc_ba' => 'ئۆبجێکتەکا "person" ب name="Hêmin" و میتۆدا greet دروست بکە کو "Bêxhatin, Hêmin!" چاپ بکەت',
        'expected_output' => 'Bêxhatin, Hêmin!',
    ],
    [
        'order' => 18,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'کلاسەکان (Classes)',
        'title_ba' => 'کلاس (Classes)',
        'content_so' => '<p><strong>کلاس (Class)</strong> ڕێبازەکەیە بۆ دروستکردنی چەند ئۆبجێکتی هاوشێوە. <code>constructor</code> کاتێک جێبەجێ دەبێت کە ئۆبجێکتێکی نوێ دروست دەکەیت:</p><pre>class Student {\n    constructor(name, grade) {\n        this.name = name;\n        this.grade = grade;\n    }\n\n    info() {\n        console.log(this.name + ": " + this.grade);\n    }\n}\n\nconst s = new Student("Ava", 95);\ns.info();   // Ava: 95</pre><p>بە <code>new</code> ئۆبجێکتێکی نوێ دروست دەکەیت.</p>',
        'content_ba' => '<p><strong>کلاس (Class)</strong> ڕێبازە کو چەند ئۆبجێکتێن هەوشێوە پێ دروست دکەی. <code>constructor</code> دەمە دبیت کو ئۆبجێکتەکا نوێ دروست دکەی:</p><pre>class Student {\n    constructor(name, grade) {\n        this.name = name;\n        this.grade = grade;\n    }\n\n    info() {\n        console.log(this.name + ": " + this.grade);\n    }\n}\n\nconst s = new Student("Ava", 95);\ns.info();   // Ava: 95</pre><p>پێ <code>new</code> ئۆبجێکتەکا نوێ دروست دکەی.</p>',
        'code' => 'class Student {
    constructor(name, grade) {
        this.name = name;
        this.grade = grade;
    }

    info() {
        console.log(this.name + ": " + this.grade);
    }
}

const s = new Student("Ava", 95);
s.info();',
        'example_output' => 'Ava: 95',
        'challenge_desc_so' => 'کلاسێکی "Car" دروست بکە کە براندەکەی چاپ بکات و ئۆبجێکتێکی بە "Toyota" دروست بکە',
        'challenge_desc_ba' => 'کلاسەکا "Car" دروست بکە کو براندێ خۆ چاپ بکەت و ئۆبجێکتەکا ب "Toyota" دروست بکە',
        'expected_output' => 'Toyota',
    ],
    [
        'order' => 19,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'بەڕێوەبردنی هەڵە (try/catch)',
        'title_ba' => 'بەڕێوەبرنا خەلەتیان (try/catch)',
        'content_so' => '<p>بە <code>try/catch</code> هەڵەکانی بەرنامە بەڕێوە دەبەیت بێ ئەوەی بەرنامەکە بوەستێت:</p><pre>try {\n    let num = Number("dus");\n    if (isNaN(num)) {\n        throw new Error("Ne jimar e!");\n    }\n    console.log(num);\n} catch (err) {\n    console.log("Xeletî: " + err.message);\n}</pre><p>ئەگەر لە <code>try</code> هەڵە ڕوو بدات، <code>catch</code> دەیگرێت و کۆدەکەی جێبەجێ دەبێت.</p>',
        'content_ba' => '<p>پێ <code>try/catch</code> خەلەتیێن بەرنامە بەڕێوە دبی بێ ئەوێ بەرنامە بوەستیت:</p><pre>try {\n    let num = Number("dus");\n    if (isNaN(num)) {\n        throw new Error("Ne jimar e!");\n    }\n    console.log(num);\n} catch (err) {\n    console.log("Xeletî: " + err.message);\n}</pre><p>گەر د <code>try</code> دا خەلەت ڕوو بدەت، <code>catch</code> دگریت و کۆدێ وی جێبەجێ دبیت.</p>',
        'code' => 'try {
    let num = Number("dus");
    if (isNaN(num)) {
        throw new Error("Ne jimar e!");
    }
    console.log(num);
} catch (err) {
    console.log("Xeletî: " + err.message);
}',
        'example_output' => 'Xeletî: Ne jimar e!',
        'challenge_desc_so' => 'بە throw هەڵەیەکی "Helleke!" فڕێ بدە و بە catch چاپی بکە',
        'challenge_desc_ba' => 'پێ throw خەلەتەکا "Helleke!" فڕێ بدە و پێ catch چاپا وی بکە',
        'expected_output' => 'Xeletî: Helleke!',
    ],
    [
        'order' => 20,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'Arrow Functions و Callbacks',
        'title_ba' => 'Arrow Functions و Callbacks',
        'content_so' => '<p><strong>فەنکشنی Arrow</strong> <code>() =></code> شێوازێکی کورتتری فەنکشنە. <strong>Callback</strong> فەنکشنێکە وەک بەها دەدرێت بە فەنکشنی تر:</p><pre>const greet = (name) => "Salam, " + name + "!";\n\nconst printMsg = (msg) => {\n    console.log(msg);\n};\n\nprintMsg(greet("Ava"));   // Salam, Ava!</pre><p>ئەگەر پێکهاتەکە یەک دەربڕین بێت، <code>return</code> پێویست نییە.</p>',
        'content_ba' => '<p><strong>فەنکشنێ Arrow</strong> <code>() =></code> شێوازەکا کورتر فەنکشنێ یە. <strong>Callback</strong> فەنکشنەکە کو وەک بەها دەیتێ فەنکشنەکا دیت:</p><pre>const greet = (name) => "Salam, " + name + "!";\n\nconst printMsg = (msg) => {\n    console.log(msg);\n};\n\nprintMsg(greet("Ava"));   // Salam, Ava!</pre><p>گەر پێکهاتە یەک دەربڕین بیت، <code>return</code> پێدڤی نییە.</p>',
        'code' => 'const greet = (name) => "Salam, " + name + "!";

const printMsg = (msg) => {
    console.log(msg);
};

printMsg(greet("Ava"));',
        'example_output' => 'Salam, Ava!',
        'challenge_desc_so' => 'فەنکشنی arrow بە ناوی "double" دروست بکە کە بەهایەک دوان بکات و ٨ چاپ بکات',
        'challenge_desc_ba' => 'فەنکشنەکا arrow ب ناڤێ "double" دروست بکە کو بەهایەک دوبارە بکەت و چاپا ٨ بکەت',
        'expected_output' => '16',
    ],
    [
        'order' => 21,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'فەنکشنەکانی دەق (indexOf/slice/replace)',
        'title_ba' => 'فەنکشنێن نڤیسینێ (indexOf/slice/replace)',
        'content_so' => '<p>فەنکشنی زۆری هەیە بۆ دەقەکان: <code>indexOf()</code> شوێنی ووشەیەک دەدۆزێتەوە، <code>slice()</code> بەشێک لە دەقەکە دەکاتەوە، <code>replace()</code> بەشێک دەگۆڕێت:</p><pre>let text = "Kurdistan azad e";\n\nconsole.log(text.indexOf("azad"));\nconsole.log(text.slice(0, 9));\nconsole.log(text.replace("azad", "serbilind"));</pre><p>ئەنجامەکەی: <code>10</code>، <code>Kurdistan</code>، <code>Kurdistan serbilind e</code>.</p>',
        'content_ba' => '<p>فەنکشنێن زاف هەن بو نڤیسینان: <code>indexOf()</code> جهێ پەیڤەک ددیتە، <code>slice()</code> بەشەکا نڤیسینێ دکەتە، <code>replace()</code> بەشەک دگۆڕیت:</p><pre>let text = "Kurdistan azad e";\n\nconsole.log(text.indexOf("azad"));\nconsole.log(text.slice(0, 9));\nconsole.log(text.replace("azad", "serbilind"));</pre><p>دەرئەنجام: <code>10</code>، <code>Kurdistan</code>، <code>Kurdistan serbilind e</code>.</p>',
        'code' => 'let text = "Kurdistan azad e";

console.log(text.indexOf("azad"));
console.log(text.slice(0, 9));
console.log(text.replace("azad", "serbilind"));',
        'example_output' => '10
Kurdistan
Kurdistan serbilind e',
        'challenge_desc_so' => 'بە replace ووشەی "Hewlêr" بە "Kurdistan" بگۆڕە لە "Bexhatin Hewlêr" و چاپی بکە',
        'challenge_desc_ba' => 'پێ replace پەیڤا "Hewlêr" ب "Kurdistan" بگۆڕە د "Bexhatin Hewlêr" دا و چاپا وی بکە',
        'expected_output' => 'Bexhatin Kurdistan',
    ],
    [
        'order' => 22,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Template Literals بە قووڵی',
        'title_ba' => 'Template Literals ب قوڵی',
        'content_so' => '<p><bdi>Template literals</bdi> بە <code>${...}</code> هەر دەربڕینێکی JavaScript دەخەیتە ناو دەقەوە، تەنانەت هەژماریش:</p><pre>let name = "Ava";\nlet score = 95;\nlet passed = score >= 50;\n\nconsole.log(`Nav: ${name}`);\nconsole.log(`Puan: ${score}`);\nconsole.log(`Derbaz bû: ${passed ? "Erê" : "Na"}`);</pre><p>بەم شێوەیە زیاتر لە گۆڕاوێک بە خێرایی لە دەقێکدا کۆ دەکەیتەوە.</p>',
        'content_ba' => '<p><bdi>Template literals</bdi> پێ <code>${...}</code> هەر دەربڕینەکا JavaScript تێخە ناو نڤیسینێ، تەڤا هەژمار:</p><pre>let name = "Ava";\nlet score = 95;\nlet passed = score >= 50;\n\nconsole.log(`Nav: ${name}`);\nconsole.log(`Puan: ${score}`);\nconsole.log(`Derbaz bû: ${passed ? "Erê" : "Na"}`);</pre><p>ب ڤی شێوەی ژ گۆڕۆکێن زاف زو ب زو د یەک نڤیسینێ دا کوم دکەی.</p>',
        'code' => 'let name = "Ava";
let score = 95;
let passed = score >= 50;

console.log(`Nav: ${name}`);
console.log(`Puan: ${score}`);
console.log(`Derbaz bû: ${passed ? "Erê" : "Na"}`);',
        'example_output' => 'Nav: Ava
Puan: 95
Derbaz bû: Erê',
        'challenge_desc_so' => 'بە template literal هەژماری ٧×٦ بکە و "Encam: 42" چاپ بکە',
        'challenge_desc_ba' => 'پێ template literal هەژمارا ٧×٦ بکە و "Encam: 42" چاپ بکە',
        'expected_output' => 'Encam: 42',
    ],
    [
        'order' => 23,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Spread و Rest',
        'title_ba' => 'Spread و Rest',
        'content_so' => '<p><strong>Spread</strong> (<code>...</code>) ئەندامەکانی ئارایەک یان ئۆبجێکتێک دەکاتەوە؛ <strong>Rest</strong> چەند بەهای وەک یەک ئارای کۆ دەکاتەوە:</p><pre>let arr1 = [1, 2, 3];\nlet arr2 = [...arr1, 4, 5];\n\nfunction sumAll(...numbers) {\n    let total = 0;\n    for (let n of numbers) {\n        total += n;\n    }\n    return total;\n}\n\nconsole.log(arr2);               // [ 1, 2, 3, 4, 5 ]\nconsole.log(sumAll(1, 2, 3, 4)); // 10</pre>',
        'content_ba' => '<p><strong>Spread</strong> (<code>...</code>) ئەندامێن ئارایەک یا ئۆبجێکتەک ڤەدکەت؛ <strong>Rest</strong> چەند بەهایان وەک یەک ئارای کۆ دکەت:</p><pre>let arr1 = [1, 2, 3];\nlet arr2 = [...arr1, 4, 5];\n\nfunction sumAll(...numbers) {\n    let total = 0;\n    for (let n of numbers) {\n        total += n;\n    }\n    return total;\n}\n\nconsole.log(arr2);               // [ 1, 2, 3, 4, 5 ]\nconsole.log(sumAll(1, 2, 3, 4)); // 10</pre>',
        'code' => 'let arr1 = [1, 2, 3];
let arr2 = [...arr1, 4, 5];

function sumAll(...numbers) {
    let total = 0;
    for (let n of numbers) {
        total += n;
    }
    return total;
}

console.log(arr2);
console.log(sumAll(1, 2, 3, 4));',
        'example_output' => '[ 1, 2, 3, 4, 5 ]
10',
        'challenge_desc_so' => 'بە spread دوو ئارای تێکەڵ بکە [1, 2] و [3, 4, 5] و ژمارەی ئەندامەکانی چاپ بکە',
        'challenge_desc_ba' => 'پێ spread دوو ئارای تێکەل بکە [1, 2] و [3, 4, 5] و ژمارا ئەندامان چاپ بکە',
        'expected_output' => '5',
    ],
    [
        'order' => 24,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Destructuring',
        'title_ba' => 'Destructuring',
        'content_so' => '<p><strong>Destructuring</strong> ڕێگایەکە بۆ دەرهێنانی بەهاکان لە ئارای یان ئۆبجێکتەوە بە ناوی گۆڕاو:</p><pre>let colors = ["Sor", "Zer", "Kesk"];\nlet [first, second] = colors;\n\nconst user = { name: "Ava", age: 20 };\nlet { name, age } = user;\n\nconsole.log(first);              // Sor\nconsole.log(name + " " + age);   // Ava 20</pre>',
        'content_ba' => '<p><strong>Destructuring</strong> ڕێگایەکە بو دەرهینانا بەهایان ژ ئارای یا ئۆبجێکتە ب ناڤێ گۆڕۆک:</p><pre>let colors = ["Sor", "Zer", "Kesk"];\nlet [first, second] = colors;\n\nconst user = { name: "Ava", age: 20 };\nlet { name, age } = user;\n\nconsole.log(first);              // Sor\nconsole.log(name + " " + age);   // Ava 20</pre>',
        'code' => 'let colors = ["Sor", "Zer", "Kesk"];
let [first, second] = colors;

const user = { name: "Ava", age: 20 };
let { name, age } = user;

console.log(first);
console.log(name + " " + age);',
        'example_output' => 'Sor
Ava 20',
        'challenge_desc_so' => 'بە destructuring ناوی خوێندکارێکە بە name="Roj" دەربهێنە و چاپی بکە',
        'challenge_desc_ba' => 'پێ destructuring ناڤێ خواندکارەکا ب name="Roj" دەرئینە و چاپا وی بکە',
        'expected_output' => 'Roj',
    ],
    [
        'order' => 25,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Constructor (دروستکەر)',
        'title_ba' => 'Constructor (دروستکەر)',
        'content_so' => '<p><strong>Constructor (دروستکەر)</strong> میتۆدێکی تایبەتە لە ناو کلاسدا کە خۆکارانە جێبەجێ دەبێت هەر کاتێک ئۆبجێکتێکی نوێ بە <code>new</code> دروست بکەیت. ئەرکە سەرەکییەکەی دەستپێکردنی تایبەتمەندییەکانی ئۆبجێکتەکەیە بە یارمەتی <code>this</code>.</p><p>ئەگەر constructor نەنووسیت، JavaScript دانەیەکی بەتاڵ بۆت دروست دەکات. بەڵام کاتێک پارامیتەر وەردەگرێت، هەر ئۆبجێکتێک بەهای خۆی لە کاتی دروستکردندا پێ دەدرێت:</p><pre>class Student {\n    constructor(name, grade) {\n        this.name = name;\n        this.grade = grade;\n        console.log("Student created: " + name);\n    }\n}\n\nconst s1 = new Student("Ava", 95);\nconst s2 = new Student("Roj", 88);\nconsole.log(s1.name + " and " + s2.name);</pre><p>بە <code>new</code> هەر جارەک ئۆبجێکتێکی نوێ و سەربەخۆ دروست دەکرێت و constructorەکەش جارێک جێبەجێ دەبێت. تەنانەت دەتوانیت پشکنینی وەک ڕێگەگرتن لە بەهای نادروست لە ناوەوەیدا بکەیت.</p>',
        'content_ba' => '<p><strong>Constructor (دروستکەر)</strong> میتۆدەکا تایبەتە د ناڤ کلاسی دا کو خودکار جێبەجێ دبیت هەر دەمە ئۆبجێکتەکا نوێ پێ <code>new</code> دروست دکەی. ئەرکێ وی سەرەکی دەستپێکرنا تایبەتمەندییێن ئۆبجێکتە یە پێ ئەلکارییا <code>this</code>.</p><p>گەر constructor نەنڤیسی، JavaScript یەکەکا ڤەلایی بو تە دروست دکەت. لێ دەمە پارامەتر هەلگریت، هەر ئۆبجێکتەک بەهایێ خۆ د دەمێ دروستکرنێ دا هەلگریت:</p><pre>class Student {\n    constructor(name, grade) {\n        this.name = name;\n        this.grade = grade;\n        console.log("Student created: " + name);\n    }\n}\n\nconst s1 = new Student("Ava", 95);\nconst s2 = new Student("Roj", 88);\nconsole.log(s1.name + " and " + s2.name);</pre><p>پێ <code>new</code> هەر جارەک ئۆبجێکتەکا نوێ و سەربەخۆ دروست دبیت و constructor ژ دوی چاران جێبەجێ دبیت.</p>',
        'code' => 'class Student {
    constructor(name, grade) {
        this.name = name;
        this.grade = grade;
        console.log("Student created: " + name);
    }
}

const s1 = new Student("Ava", 95);
const s2 = new Student("Roj", 88);
console.log(s1.name + " and " + s2.name);',
        'example_output' => 'Student created: Ava
Student created: Roj
Ava and Roj',
        'challenge_desc_so' => 'دوو ئۆبجێکتی "Car" بە براندی "Toyota" و "BMW" دروست بکە و هەردووکیان چاپ بکە',
        'challenge_desc_ba' => 'دوو ئۆبجێکتێن "Car" ب براندێن "Toyota" و "BMW" دروست بکە و هەردوو چاپ بکە',
        'expected_output' => 'Toyota
BMW',
    ],
    [
        'order' => 26,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Static و خاسیەتەکانی کلاس',
        'title_ba' => 'Static و تایبەتمەندیێن کلاس',
        'content_so' => '<p><strong>میتۆدی Static</strong> میتۆدێکە کە سەر بە کلاسەکە خۆیەتی، نەک بە ئۆبجێکت. بەبێ دروستکردنی ئۆبجێکت بە <code>ClassName.method()</code> بانگ دەکرێت و بە <code>new</code> پێویستی نییە.</p><p>خاسیەتی Staticیش داتایە لە ئاستی کلاسدا — هەموو ئۆبجێکتەکان هەمان بەهای پێشکەش دەکەن. لە ناو میتۆدی staticدا بە <code>this</code> ئاماژە بە خودی کلاسەکە دەکەیت:</p><pre>class Counter {\n    static count = 0;\n\n    static increment() {\n        this.count++;\n        return this.count;\n    }\n}\n\nconsole.log(Counter.increment());\nconsole.log(Counter.increment());\nconsole.log(Counter.count);</pre><p>ئەمە بۆ هەژمارکردن، ڕێکخستنی فەنکشنی یارمەتیدەر و داتای هاوبەش زۆر بەسوودە، چونکە بەبێ دروستکردنی ئۆبجێکت دەتوانرێت بەکاری بهێنیت.</p>',
        'content_ba' => '<p><strong>میتۆدا Static</strong> میتۆدەکە کو سەر ب کلاسی خود یە، نەک ب ئۆبجێکت. بێ دروستکرنا ئۆبجێکت پێ <code>ClassName.method()</code> بانگ دبیت و پێدڤی ب <code>new</code> نینە.</p><p>تایبەتمەندییا Static ژی داتایە د ئاستا کلاسی دا — هەمی ئۆبجێکت هەمان بەها پێشکەش دکەن. د ناڤ میتۆدا static دا پێ <code>this</code> ئاماژە ب خودی کلاسی دکەی:</p><pre>class Counter {\n    static count = 0;\n\n    static increment() {\n        this.count++;\n        return this.count;\n    }\n}\n\nconsole.log(Counter.increment());\nconsole.log(Counter.increment());\nconsole.log(Counter.count);</pre><p>ئەڤە بو هەژمارکرن، ڕێکخستنا فەنکشنێن ئەلکار و داتایا هەوپەشک زۆر ب سودە، چونکی بێ دروستکرنا ئۆبجێکت دکەیت بکاربینیت.</p>',
        'code' => 'class Counter {
    static count = 0;

    static increment() {
        this.count++;
        return this.count;
    }
}

console.log(Counter.increment());
console.log(Counter.increment());
console.log(Counter.count);',
        'example_output' => '1
2
2',
        'challenge_desc_so' => 'کلاسێکی "MathTool" بنووسە کە میتۆدی static ی "double" هەبێت و ٢١ دوان بکاتەوە و چاپی بکە',
        'challenge_desc_ba' => 'کلاسەکا "MathTool" بنڤیسە کو میتۆدا static یا "double" هەبیت و ٢١ دوبارە بکەت و چاپا وی بکە',
        'expected_output' => '42',
    ],
    [
        'order' => 27,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'بۆماوە (Inheritance — extends)',
        'title_ba' => 'بۆماوە (Inheritance — extends)',
        'content_so' => '<p><strong>بۆماوە (Inheritance)</strong> ڕێگایەکە بۆ دروستکردنی کلاسی نوێ لە کلاسێکی بوونەوە. کلاسی مناڵ بە <code>extends</code> هەموو میتۆد و خاسیەتەکانی کلاسی باوک بەمێراث دەگرێت.</p><p>بە <code>super()</code> فەنکشنی <code>constructor</code>ی کلاسی باوک بانگ دەکەیت بۆ دەستپێکردنی بەشە هاوبەشەکان. کلاسی مناڵ دەتوانێت تایبەتمەندی نوێی خۆی زیاد بکات:</p><pre>class Animal {\n    constructor(name) {\n        this.name = name;\n    }\n\n    eat() {\n        console.log(this.name + " is eating.");\n    }\n}\n\nclass Dog extends Animal {\n    constructor(name, breed) {\n        super(name);\n        this.breed = breed;\n    }\n}\n\nconst dog = new Dog("Rex", "German Shepherd");\ndog.eat();\nconsole.log(dog.name + " is a " + dog.breed);</pre><p>بەم شێوەیە کۆدی هاوبەش جارێک دەنووسیت و چەند کلاسێک لە ناوەوە بەری دەگرن — ناسراوە بە <strong>reusability</strong>.</p>',
        'content_ba' => '<p><strong>بۆماوە (Inheritance)</strong> ڕێگایەکە بو دروستکرنا کلاسەکا نوێ ژ کلاسەکا هەی. کلاسێ زارۆک پێ <code>extends</code> هەمی میتۆد و تایبەتمەندیێن کلاسێ باوک بۆماوە دگریت.</p><p>پێ <code>super()</code> فەنکشنا <code>constructor</code> یا کلاسێ باوک بانگ دکەی بو دەستپێکرنا بەشێن هەوپەشک. کلاسێ زارۆک دکەت تایبەتمەندیێن نوێ یێن خودێ زێدە بکەت:</p><pre>class Animal {\n    constructor(name) {\n        this.name = name;\n    }\n\n    eat() {\n        console.log(this.name + " is eating.");\n    }\n}\n\nclass Dog extends Animal {\n    constructor(name, breed) {\n        super(name);\n        this.breed = breed;\n    }\n}\n\nconst dog = new Dog("Rex", "German Shepherd");\ndog.eat();\nconsole.log(dog.name + " is a " + dog.breed);</pre><p>ب ڤی شێوەی کۆدێ هەوپەشک یەک جاران دەنڤیسی و چەند کلاس ژی د ناڤ دا بەری دگرن — ب ناڤێ <strong>reusability</strong> تۆ ناسرایە.</p>',
        'code' => 'class Animal {
    constructor(name) {
        this.name = name;
    }

    eat() {
        console.log(this.name + " is eating.");
    }
}

class Dog extends Animal {
    constructor(name, breed) {
        super(name);
        this.breed = breed;
    }
}

const dog = new Dog("Rex", "German Shepherd");
dog.eat();
console.log(dog.name + " is a " + dog.breed);',
        'example_output' => 'Rex is eating.
Rex is a German Shepherd',
        'challenge_desc_so' => 'کلاسێکی "Cat" بە extends لە "Animal" دروست بکە و بە super ناوەکەی "Pisîk" بدەرێت و بە میتۆدی eat چاپی بکە',
        'challenge_desc_ba' => 'کلاسەکا "Cat" پێ extends ژ "Animal" دروست بکە و پێ super ناڤێ وی "Pisîk" بدە و پێ میتۆدا eat چاپا وی بکە',
        'expected_output' => 'Pisîk is eating.',
    ],
    [
        'order' => 28,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پۆلیمۆرفیزم (Method Overriding)',
        'title_ba' => 'پۆلیمۆرفیزم (Method Overriding)',
        'content_so' => '<p><strong>پۆلیمۆرفیزم (Polymorphism)</strong> واتە هەمان فەنکشن لە کلاسی جیاوازدا بە شێوەی جیاواز ڕەفتار بکات. بە <bdi>method overriding</bdi> کلاسی مناڵ میتۆدێک بە هەمان ناو و پارامیتەر دەنووسێتەوە بەڵام بە ڕەفتاری نوێ.</p><p>کاتێک هەمان میتۆد لە کلاسی جیاواز بانگ دەکەیت، هەریەکەیان وەڵامی تایبەت بە خۆی دەداتەوە:</p><pre>class Animal {\n    speak() {\n        console.log("Animal makes a sound.");\n    }\n}\n\nclass Dog extends Animal {\n    speak() {\n        console.log("Dog barks.");\n    }\n}\n\nclass Cat extends Animal {\n    speak() {\n        console.log("Cat meows.");\n    }\n}\n\nconst animals = [new Dog(), new Cat(), new Animal()];\nanimals.forEach(a => a.speak());</pre><p>ئەمەش کۆدەکەت نەرم و گشتی دەکات: دەتوانیت بە یەک خولگە چەند جۆری جیاواز بەڕێوە ببەیت.</p>',
        'content_ba' => '<p><strong>پۆلیمۆرفیزم (Polymorphism)</strong> ڤێتە هەمان فەنکشن د کلاسێن جودا دا ب شێوەیەکا جودا ڕەفتار بکەت. پێ <bdi>method overriding</bdi> کلاسێ زارۆک میتۆدەکا ب هەمان ناڤ و پارامەتر دەنڤیسی لێ ب ڕەفتارەکا نوی.</p><p>دەمە هەمان میتۆد د کلاسێن جودا دا بانگ دکەی، هەر یەکا وەلایەکا تایبەت ب خودێ ددەتەڤە:</p><pre>class Animal {\n    speak() {\n        console.log("Animal makes a sound.");\n    }\n}\n\nclass Dog extends Animal {\n    speak() {\n        console.log("Dog barks.");\n    }\n}\n\nclass Cat extends Animal {\n    speak() {\n        console.log("Cat meows.");\n    }\n}\n\nconst animals = [new Dog(), new Cat(), new Animal()];\nanimals.forEach(a => a.speak());</pre><p>ئەڤە کۆدێ تە نەرم و گشتی دکەت: تۆ دکەی پێ یەک گەڕخستن چەند چەشنێن جودا بەڕێوە ببی.</p>',
        'code' => 'class Animal {
    speak() {
        console.log("Animal makes a sound.");
    }
}

class Dog extends Animal {
    speak() {
        console.log("Dog barks.");
    }
}

class Cat extends Animal {
    speak() {
        console.log("Cat meows.");
    }
}

const animals = [new Dog(), new Cat(), new Animal()];
animals.forEach(a => a.speak());',
        'example_output' => 'Dog barks.
Cat meows.
Animal makes a sound.',
        'challenge_desc_so' => 'کلاسێکی "Bird" بە extends لە "Animal" دروست بکە کە میتۆدی speak هەڵدەگرێتەوە و "Bird chirps." چاپ بکات',
        'challenge_desc_ba' => 'کلاسەکا "Bird" پێ extends ژ "Animal" دروست بکە کو میتۆدا speak بگەڕینیتەڤە و "Bird chirps." چاپ بکەت',
        'expected_output' => 'Bird chirps.',
    ],
    [
        'order' => 29,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz',
        'title_ba' => 'پرۆژە: FizzBuzz',
        'content_so' => '<p>پرۆژە: <strong>FizzBuzz</strong>. بۆ هەر ژمارەیەک لە ١ بۆ ١٥: ئەگەر دابەش بوو بە ٣ و ٥ "FizzBuzz"، بە ٣ "Fizz"، بە ٥ "Buzz"، بێ نەوەک ژمارەکە:</p><pre>for (let i = 1; i <= 15; i++) {\n    if (i % 3 === 0 && i % 5 === 0) {\n        console.log("FizzBuzz");\n    } else if (i % 3 === 0) {\n        console.log("Fizz");\n    } else if (i % 5 === 0) {\n        console.log("Buzz");\n    } else {\n        console.log(i);\n    }\n}</pre><p>ئەمە پرۆژەیەکی ناسراوی هەڤپەیڤینە بۆ پشکنینی فکری بەرنامەسازی.</p>',
        'content_ba' => '<p>پرۆژە: <strong>FizzBuzz</strong>. بو هەر ژمارەکا ژ ١ هەتا ١٥: گەر ب ٣ و ٥ دا دابەش دبیت "FizzBuzz"، ب ٣ "Fizz"، ب ٥ "Buzz"، نەوەک ژمارە:</p><pre>for (let i = 1; i <= 15; i++) {\n    if (i % 3 === 0 && i % 5 === 0) {\n        console.log("FizzBuzz");\n    } else if (i % 3 === 0) {\n        console.log("Fizz");\n    } else if (i % 5 === 0) {\n        console.log("Buzz");\n    } else {\n        console.log(i);\n    }\n}</pre><p>ئەڤە پرۆژەکا ناڤدارە بو ئازمکرنا فکرێ بەرنامەسازی.</p>',
        'code' => 'for (let i = 1; i <= 15; i++) {
    if (i % 3 === 0 && i % 5 === 0) {
        console.log("FizzBuzz");
    } else if (i % 3 === 0) {
        console.log("Fizz");
    } else if (i % 5 === 0) {
        console.log("Buzz");
    } else {
        console.log(i);
    }
}',
        'example_output' => '1
2
Fizz
4
Buzz
Fizz
7
8
Fizz
Buzz
11
Fizz
13
14
FizzBuzz',
        'challenge_desc_so' => 'FizzBuzz بۆ ژمارەکانی ١ بۆ ١٠ چاپ بکە',
        'challenge_desc_ba' => 'FizzBuzz بو ژمارێن ١ هەتا ١٠ چاپ بکە',
        'expected_output' => '1
2
Fizz
4
Buzz
Fizz
7
8
Fizz
Buzz',
    ],
    [
        'order' => 30,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: فاکتۆریاڵ',
        'title_ba' => 'پرۆژە: فاکتۆریال',
        'content_so' => '<p>پرۆژە: <strong>فاکتۆریاڵ</strong>. فاکتۆریاڵی n کە ١×٢×٣×...×n یە. بە فەنکشنی تکرارخۆ (recursion) دەینووسین:</p><pre>function factorial(n) {\n    if (n <= 1) return 1;\n    return n * factorial(n - 1);\n}\n\nconsole.log("6! = " + factorial(6));   // 720</pre><p>فەنکشنی تکرارخۆ خۆی بانگ دەکاتەوە، بەڵام دەبێت مەرجی وەستان هەبێت.</p>',
        'content_ba' => '<p>پرۆژە: <strong>فاکتۆریال</strong>. فاکتۆریالا n ١×٢×٣×...×n یە. پێ فەنکشنەکا دوبارەخوازی (recursion) دەنڤیسن:</p><pre>function factorial(n) {\n    if (n <= 1) return 1;\n    return n * factorial(n - 1);\n}\n\nconsole.log("6! = " + factorial(6));   // 720</pre><p>فەنکشنا دوبارەخوازی خودێ بانگ دکەت، لێ مەرجەکا وەستاندنێ دڤێ هەبیت.</p>',
        'code' => 'function factorial(n) {
    if (n <= 1) return 1;
    return n * factorial(n - 1);
}

console.log("6! = " + factorial(6));',
        'example_output' => '6! = 720',
        'challenge_desc_so' => 'فاکتۆریاڵی ٧ بدۆزەرەوە و ئەنجامەکە چاپ بکە',
        'challenge_desc_ba' => 'فاکتۆریالا ٧ بدۆزە و دەرئەنجام چاپ بکە',
        'expected_output' => '5040',
    ],
];

if (defined('FERGA_SEED_LIB')) {
    $FERGA_SEED_LIBS['javascript'] = ['langId' => '-Oysj4NVk0PGRLQx2Z8o', 'lessons' => $lessons];
    return;
}

foreach ($lessons as $lesson) {
    $lesson['langId'] = $langId;
    $lesson['content_so'] = fixContent($lesson['content_so'] ?? '');
    $lesson['content_ba'] = fixContent($lesson['content_ba'] ?? '');
    $res = fbPost($firebaseUrl . 'ferga_lessons.json', $lesson);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo "Lesson added: {$lesson['title_so']} -> {$d['name']}\n";
    } else {
        echo "ERROR adding lesson {$lesson['title_so']}: $res\n";
    }
}

echo "\nDone! JavaScript lessons have been added to Ferga.\n";
