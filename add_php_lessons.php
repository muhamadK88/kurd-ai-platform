<?php

// Script to add PHP lessons (1-10) to the Ferga section in Firebase.
// Language already exists as -Oysj44hJLXDgdp-b9iN; we just post lessons and unlock it.
if (!defined('FERGA_SEED_LIB')) {
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-Oysj44hJLXDgdp-b9iN';

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

// PHP language already exists; just unlock it.
fbPatch($firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
echo "Language PHP unlocked.\n";

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
        'title_so' => 'چییە PHP؟',
        'title_ba' => 'چ یە PHP؟',
        'content_so' => '<p><strong>PHP</strong> زمانێکە بۆ سەرڤەر و پشتەوەی وێب. زیاتر لە ٧٠٪ی سایتەکانی جیهان بە PHP دروستکراون — لەنێویاندا سیستەمی وێبسایت و بەڕێوەبردنەکان.</p><p>کۆدی PHP لە سەرڤەردا کاردەکات و ئەنجامەکەی لە براوزەری بەکارهێنەر نیشان دەدرێت:</p><pre>&lt;?php\necho "Hello from PHP!";\n?&gt;</pre><p>بە <code>echo</code> دەق چاپ دەکەیت. کۆدی PHP دەبێت لە نێو <code>&lt;?php ... ?&gt;</code>دا بنوسرێت.</p>',
        'content_ba' => '<p><strong>PHP</strong> زمانەکە یە بو سێرڤەر و پشتەوایا وێبێ. زێدەتر ژ ٧٠٪ مالپەرێن دنیای ب PHP هاتییە دروستکرن — د ناڤا وان دا سیستەمێن وێبسایت و بەرێڤەبرنان.</p><p>کۆدی PHP ل سەر سێرڤەری دا کاردکەت و دەرئەنجامێ وی ل براوزەری بکارهێنەری دا نیشان ددەت:</p><pre>&lt;?php\necho "Hello from PHP!";\n?&gt;</pre><p>پێ <code>echo</code> نڤیسین چاپ دکەی. کۆدی PHP دڤێت د ناڤا <code>&lt;?php ... ?&gt;</code> دا بنڤیسن.</p>',
        'code' => 'echo "Hello from PHP!";',
        'example_output' => 'Hello from PHP!',
        'challenge_desc_so' => 'پرۆگرامێک بنووسە کە "Bêxhatin bo PHP!" چاپ بکات',
        'challenge_desc_ba' => 'پرۆگرامەک بنڤیسە کو "Bêxhatin bo PHP!" چاپ بکەت',
        'expected_output' => 'Bêxhatin bo PHP!',
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'گۆڕاوەکان و جۆرەکانی داتا',
        'title_ba' => 'گۆڕۆک و چەشنێن داتایێ',
        'content_so' => '<p>لە PHP هەموو گۆڕاوەکان بە <code>$</code> دەست پێ دەکەن و پێویست ناکات جۆری داتاکە دیاری بکەیت — خودکار دیاری دەبێت:</p><pre>$name = "Kurd";        // دەق (string)\n$age = 20;             // ژمارەی تەواو (int)\n$price = 9.99;         // ژمارەی لۆیی (float)\n$passed = true;        // ڕاست یان هەڵە (bool)</pre><p>بە <code>.</code> دەق و گۆڕاو لەیەک دەبەستیتەوە (concatenation):</p><pre>echo "Salam, " . $name . "!";</pre>',
        'content_ba' => '<p>د PHP دا هەمی گۆڕۆک پێ <code>$</code> دەست پێ دکەن و دڤێ نەکەت چەشنا داتایێ دیاری بکی — خودکار دیاری دبیت:</p><pre>$name = "Kurd";        // نڤیسین (string)\n$age = 20;             // ژمارە تەمام (int)\n$price = 9.99;         // ژمارە لۆیی (float)\n$passed = true;        // راست یا خەلەت (bool)</pre><p>پێ <code>.</code> نڤیسین و گۆڕۆک یەک دبستیت:</p><pre>echo "Salam, " . $name . "!";</pre>',
        'code' => '$name = "Kurd";
$age = 20;
$price = 9.99;

echo "Name: " . $name . "\n";
echo "Age: " . $age . "\n";
echo "Price: " . $price;',
        'example_output' => 'Name: Kurd
Age: 20
Price: 9.99',
        'challenge_desc_so' => 'گۆڕاوێکی "$city" بە بەهای "Hewlêr" دروست بکە و چاپی بکە',
        'challenge_desc_ba' => 'گۆڕۆکەک "$city" ب بەهایا "Hewlêr" دروست بکە و چاپا وی بکە',
        'expected_output' => 'Hewlêr',
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>بە <code>if</code> و <code>else</code> بەرنامەکەت بڕیار دەدات:</p><pre>$score = 85;\n\nif ($score >= 50) {\n    echo "Bêşar!";\n} else {\n    echo "Caw!";\n}</pre><p>ئۆپێراتۆرەکانی بەراوردکردن: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. ئۆپێراتۆرە لۆژیکییەکان: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'content_ba' => '<p>پێ <code>if</code> و <code>else</code> بەرنامەکەت بریار ددەت:</p><pre>$score = 85;\n\nif ($score >= 50) {\n    echo "Bêşar!";\n} else {\n    echo "Caw!";\n}</pre><p>ئۆپێراتۆرێن بەراوردکرنێ: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. ئۆپێراتۆرێن لۆژیک: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'code' => '$score = 85;

if ($score >= 50) {
    echo "Bêşar!";
} else {
    echo "Caw!";
}',
        'example_output' => 'Bêşar!',
        'challenge_desc_so' => 'مەرجێک بنووسە: ئەگەر num=7 جۆت بێت "Even" چاپ بکات بێ نەوەک "Odd"',
        'challenge_desc_ba' => 'مەرجەک بنڤیسە: گەر num=7 جۆت بیت "Even" چاپ بکەت نەوەک "Odd"',
        'expected_output' => 'Odd',
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'خولگەکان (Loops)',
        'title_ba' => 'گەڕخستن (Loops)',
        'content_so' => '<p>خولگەی <code>for</code> و <code>while</code> کۆد دووبارە دەکەنەوە:</p><pre>// for - ژمارەی تکرارەکان دیاریکراوە\nfor ($i = 1; $i <= 5; $i++) {\n    echo $i . " ";\n}\n\n// while - مەرجەکە ڕاستە\n$j = 0;\nwhile ($j < 3) {\n    echo "Salam " . $j . "\n";\n    $j++;\n}</pre><p>بۆ ئارایەکانیش <code>foreach</code> زۆر بەسوودە — لە وانەی ئارایەکاندا فێری دەبیت.</p>',
        'content_ba' => '<p>گەڕخستنا <code>for</code> و <code>while</code> کۆد دوبارە دکەن:</p><pre>// for - ژمارا دوبارەکرنێ دیاریکرایە\nfor ($i = 1; $i <= 5; $i++) {\n    echo $i . " ";\n}\n\n// while - مەرج راستە\n$j = 0;\nwhile ($j < 3) {\n    echo "Salam " . $j . "\n";\n    $j++;\n}</pre><p>بو ئارایان ژی <code>foreach</code> زۆر ب سوودە — د وانەیا ئارایان دا فێر دبی.</p>',
        'code' => 'for ($i = 1; $i <= 5; $i++) {
    echo $i . " ";
}',
        'example_output' => '1 2 3 4 5',
        'challenge_desc_so' => 'خولگەیەک بنووسە کە ١٠ بۆ ١ بە پاشەوە چاپ بکات',
        'challenge_desc_ba' => 'گەڕخستنەک بنڤیسە کو ١٠ هەتا ١ ب پاشدا چاپ بکەت',
        'expected_output' => '10 9 8 7 6 5 4 3 2 1',
    ],
    [
        'order' => 5,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکان (Functions)',
        'title_ba' => 'فەنکشن (Functions)',
        'content_so' => '<p><strong>فەنکشن</strong> بلۆکێکی کۆدە کە دەتوانیت چەند جار بەکاری بهێنیت. بە <code>function</code> دەست پێ دەکات:</p><pre>function add($a, $b) {\n    return $a + $b;\n}\n\n$sum = add(5, 3);\necho "Sum = " . $sum;   // Sum = 8</pre><p>فەنکشنەکان کۆدەت لە تکرار ڕزگار دەکەن. لە PHP فەنکشنی زۆری تەواو هەیە بۆ دەق، ژمارە و داتاکان — وەک <code>strlen()</code> و <code>count()</code>.</p>',
        'content_ba' => '<p><strong>فەنکشن</strong> بلۆکەکا کۆدی یە کو تۆ دکەی چەند جاران بکاربینی. پێ <code>function</code> دەست پێ دکەت:</p><pre>function add($a, $b) {\n    return $a + $b;\n}\n\n$sum = add(5, 3);\necho "Sum = " . $sum;   // Sum = 8</pre><p>فەنکشن کۆدێ تە ژ دوبارەکرنێ دەرگین. د PHP دا فەنکشنێن زاف هەن بو نڤیسین، ژمارە و داتا — وەک <code>strlen()</code> و <code>count()</code>.</p>',
        'code' => 'function add($a, $b) {
    return $a + $b;
}

$sum = add(5, 3);
echo "Sum = " . $sum;',
        'example_output' => 'Sum = 8',
        'challenge_desc_so' => 'فەنکشنێکی "multiply" دروست بکە کە دوو ژمارە زۆر بکات و ئەنجامی ٦×٧ چاپ بکات',
        'challenge_desc_ba' => 'فەنکشنەکا "multiply" دروست بکە کو دوو ژماران زێدە بکەت و دەرئەنجامێ ٦×٧ چاپ بکەت',
        'expected_output' => '42',
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارایەکان (Arrays)',
        'title_ba' => 'ئارای (Arrays)',
        'content_so' => '<p><strong>ئارای</strong> کۆمەڵێک بەها لە یەک گۆڕاودا دەگرێت. ئیندێکس لە <strong>٠</strong> دەست پێ دەکات:</p><pre>$langs = ["Kurd", "Arab", "Turk"];\n\necho $langs[0];          // Kurd\necho count($langs);      // 3\n$langs[] = "Eram";       // زیادکردن\n\nforeach ($langs as $lang) {\n    echo $lang . "\n";\n}</pre><p><code>foreach</code> بە سادەیی بەسەر هەموو ئەندامەکاندا دەسوڕێتەوە بەبێ ئیندێکس.</p>',
        'content_ba' => '<p><strong>ئارای</strong> کۆمەکەک بەها د یەک گۆڕۆکی دا دگریت. ئیندێکس ژ <strong>٠</strong> دەست پێ دکەت:</p><pre>$langs = ["Kurd", "Arab", "Turk"];\n\necho $langs[0];          // Kurd\necho count($langs);      // 3\n$langs[] = "Eram";       // زێدەکرن\n\nforeach ($langs as $lang) {\n    echo $lang . "\n";\n}</pre><p><code>foreach</code> ب ساداهی بسەر هەمی ئەندامان دا دگەڕیت بێ ئیندێکس.</p>',
        'code' => '$langs = ["Kurd", "Arab", "Turk"];

foreach ($langs as $lang) {
    echo $lang . "\n";
}',
        'example_output' => 'Kurd
Arab
Turk',
        'challenge_desc_so' => 'ئارایەک بە Hewlêr و Silêmanî و Duhok دروست بکە و بە foreach هەمووی چاپ بکە',
        'challenge_desc_ba' => 'ئارایەک ب Hewlêr و Silêmanî و Duhok دروست بکە و پێ foreach هەمی چاپ بکە',
        'expected_output' => 'Hewlêr
Silêmanî
Duhok',
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەقەکان (Strings)',
        'title_ba' => 'نڤیسین (Strings)',
        'content_so' => '<p>PHP فەنکشنی زۆری هەیە بۆ کارکردن لەگەڵ دەق:</p><pre>$city = "Hewlêr";\n\nstrlen($city);          // 6 - ژمارەی پیتەکان\nstrtoupper($city);      // HEWLÊR\nstrtolower($city);      // hewlêr\nucfirst("kurd");        // Kurd - پیتی یەکەم گەورە\nstr_replace("Hew", "A", $city); // Alêr\nsubstr($city, 0, 3);    // Hew\nstr_word_count("Salam Kurd");   // 2</pre><p>فەنکشنی دەقی PHP زۆر بەهێزن و لە پرۆسێسی زانیارییەکاندا زۆر بەکاردێن.</p>',
        'content_ba' => '<p>PHP فەنکشنێن زاف هەن بو کارکرنا ل گەل نڤیسینێ:</p><pre>$city = "Hewlêr";\n\nstrlen($city);          // 6 - ژمارا پیتان\nstrtoupper($city);      // HEWLÊR\nstrtolower($city);      // hewlêr\nucfirst("kurd");        // Kurd - پیتێ ئەڤەل مەزن\nstr_replace("Hew", "A", $city); // Alêr\nsubstr($city, 0, 3);    // Hew\nstr_word_count("Salam Kurd");   // 2</pre><p>فەنکشنێن نڤیسینا PHP زۆر بهێزن و د پرۆسێسا زانیاریان دا زۆر بکارتین.</p>',
        'code' => '$city = "Hewlêr";
$country = "Kurdistan";

echo "Salam, " . $city . "!\n";
echo strtoupper($country);',
        'example_output' => 'Salam, Hewlêr!
KURDISTAN',
        'challenge_desc_so' => 'بە strtoupper وشەی "kurd" بگۆڕە بۆ پیتە گەورەکان و چاپی بکە',
        'challenge_desc_ba' => 'پێ strtoupper پەیا "kurd" بگەڕینە پیتێن مەزن و چاپا وی بکە',
        'expected_output' => 'KURD',
    ],
    [
        'order' => 8,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارای هاوشێوە (Associative Arrays)',
        'title_ba' => 'ئارایێن هاوشێوە (Associative Arrays)',
        'content_so' => '<p>ئارای هاوشێوە بە جیاتی ئیندێکسی ژمارەیی، <code>key =&gt; value</code> بەکاردەهێنێت — وەک فەرهەنگێک:</p><pre>$book = [\n    "title" =&gt; "Kurdi",\n    "author" =&gt; "Ava",\n    "year" =&gt; 2026\n];\n\necho $book["title"];     // Kurdi\n\nforeach ($book as $key =&gt; $value) {\n    echo $key . ": " . $value . "\n";\n}</pre><p>ئەم جۆرە ئارایە بۆ زانیارییەکانی وەک بەکارهێنەر، بەرهەم یان دانەکان زۆر باشە.</p>',
        'content_ba' => '<p>ئارایێن هاوشێوە ب جیهاتا ئیندێکسێ ژمارەیی، <code>key =&gt; value</code> بکارتینن — وەک فەرهەنگەک:</p><pre>$book = [\n    "title" =&gt; "Kurdi",\n    "author" =&gt; "Ava",\n    "year" =&gt; 2026\n];\n\necho $book["title"];     // Kurdi\n\nforeach ($book as $key =&gt; $value) {\n    echo $key . ": " . $value . "\n";\n}</pre><p>ئەڤ چەشنە ئارای بو زانیارییێن وەک بکارهێنەر، بەرهەم یا دانان زۆر باشە.</p>',
        'code' => '$book = [
    "title" => "Kurdi",
    "author" => "Ava",
    "year" => 2026
];

foreach ($book as $key => $value) {
    echo $key . ": " . $value . "\n";
}',
        'example_output' => 'title: Kurdi
author: Ava
year: 2026',
        'challenge_desc_so' => 'ئارایەکی هاوشێوە بە ناوی "$student" دروست بکە بە name="Ava" و تەنها name چاپ بکە',
        'challenge_desc_ba' => 'ئارایەکێ هاوشێوە ب ناڤێ "$student" دروست بکە ب name="Ava" و تەنها name چاپ بکە',
        'expected_output' => 'Ava',
    ],
    [
        'order' => 9,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کلاسەکان (OOP)',
        'title_ba' => 'کلاس (OOP)',
        'content_so' => '<p>PHP بەرنامەسازی ڕوو لە ئۆبجێکت پشتگیری دەکات. کلاس وەک قاڵبێکە و ئۆبجێکت نموونەیەکی ڕاستەقینەیە:</p><pre>class Car {\n    public $brand;\n\n    function __construct($b) {\n        $this-&gt;brand = $b;\n    }\n\n    function show() {\n        return "Car: " . $this-&gt;brand;\n    }\n}\n\n$car = new Car("Toyota");\necho $car-&gt;show();   // Car: Toyota</pre><p><code>__construct</code> کۆنسترەکتنەرە و <code>this-&gt;</code> ئەندامەکانی کلاسەکە دەگرێتەوە.</p>',
        'content_ba' => '<p>PHP بەرنامەسازی ڕوو ل ئۆبجێکت پشتگیر دکەت. کلاس وەک قالبەکا یە و ئۆبجێکت نموونەکا ڕاستەقینە:</p><pre>class Car {\n    public $brand;\n\n    function __construct($b) {\n        $this-&gt;brand = $b;\n    }\n\n    function show() {\n        return "Car: " . $this-&gt;brand;\n    }\n}\n\n$car = new Car("Toyota");\necho $car-&gt;show();   // Car: Toyota</pre><p><code>__construct</code> کۆنسترەکتەرە و <code>this-&gt;</code> ئەندامێن کلاسێ هەلگریت.</p>',
        'code' => 'class Car {
    public $brand;

    function __construct($b) {
        $this->brand = $b;
    }

    function show() {
        return "Car: " . $this->brand;
    }
}

$car = new Car("Toyota");
echo $car->show();',
        'example_output' => 'Car: Toyota',
        'challenge_desc_so' => 'کلاسێکی "Student" دروست بکە بە name="Ava" و تەنها name چاپ بکە',
        'challenge_desc_ba' => 'کلاسەکا "Student" دروست بکە ب name="Ava" و تەنها name چاپ بکە',
        'expected_output' => 'Ava',
    ],
    [
        'order' => 10,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz',
        'title_ba' => 'پرۆژە: FizzBuzz',
        'content_so' => '<p><strong>FizzBuzz</strong> مەشقێکی بەناوبانگە لە چاوپێکەوتنەکانی کاردا. بۆ هەر ژمارەیەک لە ١ بۆ ١٥:</p><ul><li>ئەگەر بە ٣ دابەش بوو → <code>Fizz</code></li><li>ئەگەر بە ٥ دابەش بوو → <code>Buzz</code></li><li>ئەگەر بە هەردووکیان → <code>FizzBuzz</code></li><li>بێ نەوەک → خودی ژمارەکە</li></ul><pre>for ($i = 1; $i &lt;= 15; $i++) {\n    if ($i % 15 == 0) {\n        echo "FizzBuzz\n";\n    } elseif ($i % 3 == 0) {\n        echo "Fizz\n";\n    } elseif ($i % 5 == 0) {\n        echo "Buzz\n";\n    } else {\n        echo $i . "\n";\n    }\n}</pre><p>ئەم مەشقە مەرج، خولگە و ئۆپێراتۆری پاشماوە تێکەڵ دەکات — پشکنینێکی تەواوە بۆ بیرکردنەوەی بەرنامەسازی.</p>',
        'content_ba' => '<p><strong>FizzBuzz</strong> مەشقەکا ناڤدارە د ئەڤدیتییێن کاردا. بو هەر ژمارەیەکە ژ ١ هەتا ١٥:</p><ul><li>گەر ب ٣ پارڤە بیت → <code>Fizz</code></li><li>گەر ب ٥ پارڤە بیت → <code>Buzz</code></li><li>گەر ب هەردووکان → <code>FizzBuzz</code></li><li>نەوەک → خودا ژمارە</li></ul><pre>for ($i = 1; $i &lt;= 15; $i++) {\n    if ($i % 15 == 0) {\n        echo "FizzBuzz\n";\n    } elseif ($i % 3 == 0) {\n        echo "Fizz\n";\n    } elseif ($i % 5 == 0) {\n        echo "Buzz\n";\n    } else {\n        echo $i . "\n";\n    }\n}</pre><p>ئەڤ مەشقە مەرج، گەڕخستن و ئۆپێراتۆرێ پاشمایێ تێکەل دکەت — پشکنینەکا تەمامە بو بیرکردنا بەرنامەسازی.</p>',
        'code' => 'for ($i = 1; $i <= 15; $i++) {
    if ($i % 15 == 0) {
        echo "FizzBuzz\n";
    } elseif ($i % 3 == 0) {
        echo "Fizz\n";
    } elseif ($i % 5 == 0) {
        echo "Buzz\n";
    } else {
        echo $i . "\n";
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
        'challenge_desc_so' => 'خولگەیەک بنووسە کە ژمارە جۆتەکانی ٢ بۆ ١٠ چاپ بکات',
        'challenge_desc_ba' => 'گەڕخستنەک بنڤیسە کو ژمارێن جۆت ٢ هەتا ١٠ چاپ بکەت',
        'expected_output' => '2 4 6 8 10',
    ],
    [
        'order' => 11,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'جیماتیک و بەهەڵبەست',
        'title_ba' => 'ژمار و بەهەڤکرن',
        'content_so' => '<p>بە <strong>ئۆپێراتۆرە جیماتیکەکان</strong> (+، -، *، /، %) هەژماری ژمارە دەکەیت و بە <code>.</code> (concatenation) دەق و گۆڕاو یەک دەبەستیتەوە:</p><pre>$a = 7;\n$b = 3;\n\necho "7 + 3 = " . ($a + $b) . "\n";\necho "7 - 3 = " . ($a - $b) . "\n";\necho "7 * 3 = " . ($a * $b) . "\n";\necho "7 / 3 = " . ($a / $b) . "\n";\necho "7 % 3 = " . ($a % $b);</pre><p>ئۆپێراتۆری <code>%</code> پاشماوەی دابەشکردن دەداتەوە — بۆ زانینی جووت یان تا بو ژمارەیەک زۆر بەسوودە.</p>',
        'content_ba' => '<p>پێ <strong>ئۆپێراتۆرێن ژماران</strong> (+، -، *، /، %) هەژمارکرنا ژماران دکەی و پێ <code>.</code> (concatenation) نڤیسین و گۆڕۆک یەک دبستیت:</p><pre>$a = 7;\n$b = 3;\n\necho "7 + 3 = " . ($a + $b) . "\n";\necho "7 - 3 = " . ($a - $b) . "\n";\necho "7 * 3 = " . ($a * $b) . "\n";\necho "7 / 3 = " . ($a / $b) . "\n";\necho "7 % 3 = " . ($a % $b);</pre><p>ئۆپێراتۆرێ <code>%</code> پاشمایا پارڤینێ ددەتەڤە — بو زانینا جووت یا تا یەک ژمارە زۆر ب سوودە.</p>',
        'code' => '$a = 7;
$b = 3;

echo "7 + 3 = " . ($a + $b) . "\n";
echo "7 - 3 = " . ($a - $b) . "\n";
echo "7 * 3 = " . ($a * $b) . "\n";
echo "7 / 3 = " . ($a / $b) . "\n";
echo "7 % 3 = " . ($a % $b);',
        'example_output' => '7 + 3 = 10
7 - 3 = 4
7 * 3 = 21
7 / 3 = 2.3333333333333
7 % 3 = 1',
        'challenge_desc_so' => 'گۆڕاوێکی $total دروست بکە کە 8+5 بێت و بە concatenation وەک "Total = 13" چاپی بکە',
        'challenge_desc_ba' => 'گۆڕۆکەک $total دروست بکە کو 8+5 بیت و پێ concatenation وەک "Total = 13" چاپا وی بکە',
        'expected_output' => 'Total = 13',
    ],
    [
        'order' => 12,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی while',
        'title_ba' => 'گەڕخستنا while',
        'content_so' => '<p><code>while</code> کۆد دووبارە دەکاتەوە هەتا ئەو کاتەی مەرجەکە <strong>ڕاست</strong> بێت. پێش هەموو گەڕێک مەرجەکە دەپشکنرێت:</p><pre>$i = 1;\nwhile ($i &lt;= 5) {\n    echo $i . " ";\n    $i++;\n}</pre><p>ئەگەر لەبیری بکەیت <code>$i++</code>، خولگەکە بێ کۆتایی دەبێت!</p>',
        'content_ba' => '<p><code>while</code> کۆد دوبارە دکەت هەتا ئەو دەمێ مەرج <strong>راست</strong> بیت. بەری هەمی گەڕەکێ مەرج پشدکنەرت:</p><pre>$i = 1;\nwhile ($i &lt;= 5) {\n    echo $i . " ";\n    $i++;\n}</pre><p>گەر ل بیر بکەی <code>$i++</code>، گەڕخستن بێ داوایێ دبیت!</p>',
        'code' => '$i = 1;
while ($i <= 5) {
    echo $i . " ";
    $i++;
}',
        'example_output' => '1 2 3 4 5',
        'challenge_desc_so' => 'بە while ژمارەکانی 5 بۆ 1 بە پاشەوە چاپ بکە',
        'challenge_desc_ba' => 'پێ while ژمارێن 5 هەتا 1 ب پاشدا چاپ بکە',
        'expected_output' => '5 4 3 2 1',
    ],
    [
        'order' => 13,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی do-while',
        'title_ba' => 'گەڕخستنا do-while',
        'content_so' => '<p><code>do-while</code> وەک <code>while</code>ە بەڵام <strong>لانی کەم جارێک</strong> کۆدەکە جێبەجێ دەکات، بە تەنانەت ئەگەر مەرجەکە هەڵە بێت — چونکە مەرجەکە لە کۆتاییدا دەپشکنرێت:</p><pre>$i = 1;\ndo {\n    echo $i . " ";\n    $i++;\n} while ($i &lt;= 5);</pre><p>کاتێک دەتەوێت کۆدەکە لانی کەم جارێک کار بکات، <code>do-while</code> هەڵبژاردەیەکی باشە.</p>',
        'content_ba' => '<p><code>do-while</code> وەک <code>while</code>یە بەلێ <strong>هەرێ مەر جارەک</strong> کۆد جێبەجێ دکەت، تەڤانە گەر مەرج خەلەت بیت — ژبەر کو مەرج ل داوایێ دا پشدکنەرت:</p><pre>$i = 1;\ndo {\n    echo $i . " ";\n    $i++;\n} while ($i &lt;= 5);</pre><p>دەمێ دڤێ کۆد هەرێ مەر جارەک بکارکەت، <code>do-while</code> هەلبژارتەکا باشە.</p>',
        'code' => '$i = 1;
do {
    echo $i . " ";
    $i++;
} while ($i <= 5);',
        'example_output' => '1 2 3 4 5',
        'challenge_desc_so' => 'بە do-while ژمارە جۆتەکانی 2، 4، 6، 8، 10 چاپ بکە',
        'challenge_desc_ba' => 'پێ do-while ژمارێن جۆت 2، 4، 6، 8، 10 چاپ بکە',
        'expected_output' => '2 4 6 8 10',
    ],
    [
        'order' => 14,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'مەرجی switch',
        'title_ba' => 'مەرجا switch',
        'content_so' => '<p><code>switch</code> بۆ بەراوردکردنی گۆڕاوێک لەگەڵ چەند بەهایەک وەک <code>if</code>ە بەڵام خوێندنەوەی ئاسانترە:</p><pre>$day = 3;\n\nswitch ($day) {\n    case 1:\n        echo "Duşem";\n        break;\n    case 2:\n        echo "Sêşem";\n        break;\n    case 3:\n        echo "Çarşem";\n        break;\n    default:\n        echo "Nîşane";\n}</pre><p>بە <code>break</code> مەرجەکە ڕادەگیرێت؛ بە <code>default</code> ئەگەر هیچ case یەک نەگونجی.</p>',
        'content_ba' => '<p><code>switch</code> بو بەراوردکرنا گۆڕۆکەک ل گەل چەند بەهایان وەک <code>if</code>یە بەلێ خوێندنەوا وی هەسانترە:</p><pre>$day = 3;\n\nswitch ($day) {\n    case 1:\n        echo "Duşem";\n        break;\n    case 2:\n        echo "Sêşem";\n        break;\n    case 3:\n        echo "Çarşem";\n        break;\n    default:\n        echo "Nîşane";\n}</pre><p>پێ <code>break</code> مەرج دەورترت؛ پێ <code>default</code> گەر هیچ case یەک نەگونجیت.</p>',
        'code' => '$day = 3;

switch ($day) {
    case 1:
        echo "Duşem";
        break;
    case 2:
        echo "Sêşem";
        break;
    case 3:
        echo "Çarşem";
        break;
    default:
        echo "Nîşane";
}',
        'example_output' => 'Çarşem',
        'challenge_desc_so' => 'بە switch ئەگەر $fruit="mûz" بیت "Banana" چاپ بکە',
        'challenge_desc_ba' => 'پێ switch گەر $fruit="mûz" بیت "Banana" چاپ بکە',
        'expected_output' => 'Banana',
    ],
    [
        'order' => 15,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی foreach',
        'title_ba' => 'گەڕخستنا foreach',
        'content_so' => '<p><code>foreach</code> سادەترین ڕێگەیە بۆ گەڕان بەسەر هەموو ئەندامەکانی ئارای. ئەگەر بە <code>as $key =&gt; $value</code> بنووسیت، ئیندێکسی هەر ئەندامێکیش دەست دەکەوێت:</p><pre>$names = ["Ava", "Roj", "Berfin"];\n\nforeach ($names as $i =&gt; $name) {\n    echo $i . ": " . $name . "\n";\n}</pre><p>لەگەڵ <code>foreach</code> پێویست ناکات ژمارەی ئەندامەکان بزانیت — خۆی بەسەر هەموویاندا دەگەڕێتەوە.</p>',
        'content_ba' => '<p><code>foreach</code> سادەترین ڕێگایە بو گەڕان بسەر هەمی ئەندامێن ئارای. گەر ب <code>as $key =&gt; $value</code> بنڤیسی، ئیندێکسا هەر ئەندامەکە ژی دەست دکەڤیت:</p><pre>$names = ["Ava", "Roj", "Berfin"];\n\nforeach ($names as $i =&gt; $name) {\n    echo $i . ": " . $name . "\n";\n}</pre><p>پێ <code>foreach</code> دڤێ نەکەی ژمارا ئەندامان بزانێ — خود بەسەر هەمیان دا دگەڕیت.</p>',
        'code' => '$names = ["Ava", "Roj", "Berfin"];

foreach ($names as $i => $name) {
    echo $i . ": " . $name . "\n";
}',
        'example_output' => '0: Ava
1: Roj
2: Berfin',
        'challenge_desc_so' => 'بە foreach هەر شارێکی $cities چاپ بکە',
        'challenge_desc_ba' => 'پێ foreach هەر شارەکێ $cities چاپ بکە',
        'expected_output' => 'Zaho
Duhok',
    ],
    [
        'order' => 16,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکانی ئارای',
        'title_ba' => 'فەنکشنێن ئارای',
        'content_so' => '<p>PHP فەنکشنی زۆری هەیە بۆ ئارای: <code>count()</code> ژمارەی ئەندامەکان، <code>array_sum()</code> کۆی ژمارەکان، و <code>sort()</code> ئارایەکە ڕیز دەکات:</p><pre>$numbers = [3, 8, 2, 10, 5];\n\necho "Count: " . count($numbers) . "\n";\necho "Sum: " . array_sum($numbers) . "\n";\nsort($numbers);\necho "Sorted: " . implode(", ", $numbers);</pre><p>تێبینی: <code>sort()</code> بەهەمان گۆڕاودا گۆڕانکاری دەکات — واتە ئارایەکە لە جێگەی خۆیدا ڕیز دەبێت.</p>',
        'content_ba' => '<p>PHP فەنکشنێن زاف هەن بو ئارای: <code>count()</code> ژمارا ئەندامان، <code>array_sum()</code> کۆمەلا ژماران، و <code>sort()</code> ئارای ریز دکەت:</p><pre>$numbers = [3, 8, 2, 10, 5];\n\necho "Count: " . count($numbers) . "\n";\necho "Sum: " . array_sum($numbers) . "\n";\nsort($numbers);\necho "Sorted: " . implode(", ", $numbers);</pre><p>تبینی: <code>sort()</code> د هەمان گۆڕۆکی دا گوهۆرین دکەت — ئارای د شوینێ خوە دا ریز دبیت.</p>',
        'code' => '$numbers = [3, 8, 2, 10, 5];

echo "Count: " . count($numbers) . "\n";
echo "Sum: " . array_sum($numbers) . "\n";
sort($numbers);
echo "Sorted: " . implode(", ", $numbers);',
        'example_output' => 'Count: 5
Sum: 28
Sorted: 2, 3, 5, 8, 10',
        'challenge_desc_so' => 'کۆی ئارای [1, 2, 3, 4] چاپ بکە',
        'challenge_desc_ba' => 'کۆمەلا ئارای [1, 2, 3, 4] چاپ بکە',
        'expected_output' => '10',
    ],
    [
        'order' => 17,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'implode و explode',
        'title_ba' => 'implode و explode',
        'content_so' => '<p><code>implode()</code> ئارای دەکاتە یەک دەق و بە <code>explode()</code> دەق دەکرێتەوە بۆ ئارای:</p><pre>$fruits = ["sêv", "mûz", "pirtaqal"];\n$str = implode(" - ", $fruits);\necho $str . "\n";\n\n$words = explode(" ", "Kurdistan Azad e");\necho $words[1];</pre><p>ئەم دوو فەنکشنە لە پرۆسێسی داتادا زۆر بەکاردەهێنرێن — وەک کردنی نووسینی CSV.</p>',
        'content_ba' => '<p><code>implode()</code> ئارای دکەتە یەک نڤیسین و پێ <code>explode()</code> نڤیسین دبیتە دوبارە ئارای:</p><pre>$fruits = ["sêv", "mûz", "pirtaqal"];\n$str = implode(" - ", $fruits);\necho $str . "\n";\n\n$words = explode(" ", "Kurdistan Azad e");\necho $words[1];</pre><p>ئەڤ هەردوو فەنکشن د پرۆسێسا داتایێ دا زۆر بکارتین — وەک داکرنا نڤیسینا CSV.</p>',
        'code' => '$fruits = ["sêv", "mûz", "pirtaqal"];
$str = implode(" - ", $fruits);
echo $str . "\n";

$words = explode(" ", "Kurdistan Azad e");
echo $words[1];',
        'example_output' => 'sêv - mûz - pirtaqal
Azad',
        'challenge_desc_so' => 'بە explode دەقی "Salam-Gelek-Kurdan" بە "-" جیا بکەرەوە و index 2 چاپ بکە',
        'challenge_desc_ba' => 'پێ explode نڤیسینا "Salam-Gelek-Kurdan" پێ "-" جیا بکە و index 2 چاپ بکە',
        'expected_output' => 'Kurdan',
    ],
    [
        'order' => 18,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکانی دەق',
        'title_ba' => 'فەنکشنێن نڤیسینێ',
        'content_so' => '<p>فەنکشنە دەقییەکان: <code>strlen()</code> درێژی، <code>strtoupper()</code> پیتە گەورەکان، <code>strpos()</code> شوێنی دەقی ناوەکە، و <code>str_replace()</code> گۆڕینی دەق:</p><pre>$word = "Kurdistan";\n$sentence = "Kurdistan ji bona azadiyê";\n\necho "Length: " . strlen($word) . "\n";\necho "Upper: " . strtoupper($word) . "\n";\necho "Position: " . strpos($sentence, "azadiyê") . "\n";\necho "Replace: " . str_replace("Kurdistan", "Kurd", $sentence);</pre><p><code>strpos()</code> ئەگەر دەقەکە نەدۆزرایەوە <code>false</code> دەگەڕێنێتەوە — هەر بۆیە پێش بەکارهێنانەکەی بەراوردی بکە.</p>',
        'content_ba' => '<p>فەنکشنێن نڤیسینێ: <code>strlen()</code> درێژی، <code>strtoupper()</code> پیتێن مەزن، <code>strpos()</code> شوینا نڤیسینا ناڤ، و <code>str_replace()</code> گوهۆرینا نڤیسینێ:</p><pre>$word = "Kurdistan";\n$sentence = "Kurdistan ji bona azadiyê";\n\necho "Length: " . strlen($word) . "\n";\necho "Upper: " . strtoupper($word) . "\n";\necho "Position: " . strpos($sentence, "azadiyê") . "\n";\necho "Replace: " . str_replace("Kurdistan", "Kurd", $sentence);</pre><p><code>strpos()</code> گەر نڤیسین نەهاتە دیتن <code>false</code> ڤەدگەرینت — بۆ ژبەر بەری بکارئینانێ بەراوردا وی بکە.</p>',
        'code' => '$word = "Kurdistan";
$sentence = "Kurdistan ji bona azadiyê";

echo "Length: " . strlen($word) . "\n";
echo "Upper: " . strtoupper($word) . "\n";
echo "Position: " . strpos($sentence, "azadiyê") . "\n";
echo "Replace: " . str_replace("Kurdistan", "Kurd", $sentence);',
        'example_output' => 'Length: 9
Upper: KURDISTAN
Position: 18
Replace: Kurd ji bona azadiyê',
        'challenge_desc_so' => 'درێژی (strlen) وشەی "Amed" چاپ بکە',
        'challenge_desc_ba' => 'درێژیا (strlen) پەیڤا "Amed" چاپ بکە',
        'expected_output' => '4',
    ],
    [
        'order' => 19,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشن و return',
        'title_ba' => 'فەنکشن و return',
        'content_so' => '<p>فەنکشن دەتوانێ بە <code>return</code> بەهایەک بگەڕێنێتەوە بۆ شوێنی بانگکردنەکەی — ئەمە واتە دەتوانیت ئەنجامەکەی لە گۆڕاوێکدا بهێڵیتەوە:</p><pre>function maxNumber($a, $b) {\n    if ($a &gt; $b) {\n        return $a;\n    }\n    return $b;\n}\n\necho maxNumber(12, 7);   // 12</pre><p>لەگەڵ <code>return</code> کۆدەکە لەو شوێنەوە دەوەستێت کە <code>return</code> دەبینێت — هەرچی لە دوایەوە بێت جێبەجێ نابێت.</p>',
        'content_ba' => '<p>فەنکشن دکە ب پێ <code>return</code> بەهایەک ڤەدگەرینتە شوینا بانگکرنێ — ئەڤ یە دڤێت دکەی دەرئەنجامێ وی د گۆڕۆکەکی دا بهیلینی:</p><pre>function maxNumber($a, $b) {\n    if ($a &gt; $b) {\n        return $a;\n    }\n    return $b;\n}\n\necho maxNumber(12, 7);   // 12</pre><p>پێ <code>return</code> کۆد ژ وان شوینەڤە دەورترت کو <code>return</code> دبیت — چ دبیت ژ پشتیدا بیت جێبەجێ نابیت.</p>',
        'code' => 'function maxNumber($a, $b) {
    if ($a > $b) {
        return $a;
    }
    return $b;
}

echo maxNumber(12, 7);',
        'example_output' => '12',
        'challenge_desc_so' => 'فەنکشنێکی square بنووسە کە چوارگۆشەی ژمارەیەک دەگەڕێنێتەوە و square(9) چاپ بکە',
        'challenge_desc_ba' => 'فەنکشنەکا square بنڤیسە کو چوارگۆشەیا ژمارەک ڤەدگەرینت و square(9) چاپ بکە',
        'expected_output' => '81',
    ],
    [
        'order' => 20,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'نرخە پێشگرتووەکان',
        'title_ba' => 'نرخێن پێشدانان',
        'content_so' => '<p>فەنکشن دەتوانێ <strong>نرخی پێشگرتوو</strong> هەبێت — ئەگەر گۆڕاوەکە بەبێ بەها بانگ بکرێت، نرخی پێشگرتووەکە بەکاردێت:</p><pre>function salam($name = "Hêvî") {\n    return "Salam, " . $name . "!";\n}\n\necho salam("Roj") . "\n";\necho salam();</pre><p>ئەمە وا دەکات فەنکشنەکەت بەبێ پارامەتریش باش کار بکات — وەک ئەگەر هیچ بەکارهێنەرێک ناسراو نەبێت.</p>',
        'content_ba' => '<p>فەنکشن دکە <strong>نرخا پێشدانان</strong> هەبیت — گەر گۆڕۆک بێ بەها بانگ ببیت، نرخا پێشدانان بکارت:</p><pre>function salam($name = "Hêvî") {\n    return "Salam, " . $name . "!";\n}\n\necho salam("Roj") . "\n";\necho salam();</pre><p>ئەڤ یە دکەت فەنکشنا تە بێ پارامەترژی باش بکارکەت — وەک گەر هیچ بکارهینەرەک نەناسکرا بیت.</p>',
        'code' => 'function salam($name = "Hêvî") {
    return "Salam, " . $name . "!";
}

echo salam("Roj") . "\n";
echo salam();',
        'example_output' => 'Salam, Roj!
Salam, Hêvî!',
        'challenge_desc_so' => 'فەنکشنێک بە نرخی پێشگرتووی $name="Ava" بنووسە و بەبێ پارامەتر بانگی بکە',
        'challenge_desc_ba' => 'فەنکشنەک ب نرخا پێشدانان $name="Ava" بنڤیسە و بێ پارامەتر بانگا وی بکە',
        'expected_output' => 'Salam, Ava!',
    ],
    [
        'order' => 21,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Constructor (دروستکەر)',
        'title_ba' => 'Constructor (دروستکەر)',
        'content_so' => '<p><strong>Constructor (دروستکەر)</strong> مێتۆدێکی تایبەتە کە بە شێوەی خۆکار جێبەجێ دەبێت کاتێک بە <code>new</code> ئۆبجێکتێک دروست دەکەیت. بە هۆیەوە خاسیەتەکانی ئۆبجێکتەکە دەستپێک دەکرێن.</p><p>لە PHP دا ناوی کۆنسترەکتنەر <code>__construct</code>ە. بە <code>this-&gt;</code> خاسیەتەکانی کلاسەکە دیاری دەکەیت:</p><pre>class Car {\n    public $brand;\n    public $year;\n\n    function __construct($brand, $year) {\n        $this-&gt;brand = $brand;\n        $this-&gt;year = $year;\n    }\n}\n\n$car = new Car("Toyota", 2026);\necho $car-&gt;brand . " - " . $car-&gt;year;</pre><p>بە <code>new</code> ئۆبجێکتەکە دروست دەکرێت و <code>__construct</code> بە پارامەترەکانەوە خۆکار بانگ دەکرێت. کۆنسترەکتنەر وا دەکات هەر ئۆبجێکتێک لە هەمان کاتی دروستبووندا ئامادە بێت بۆ بەکارهێنان.</p>',
        'content_ba' => '<p><strong>Constructor (دروستکەر)</strong> مێتۆدەکا تایبەتە یە کو ب شێوەی خۆکار جێبەجێ دبیت دەمێ پێ <code>new</code> ئۆبجێکتەک دروست دکەی. پێ وێ تایبەتمەندییێن ئۆبجێکتێ دەستپێک دبن.</p><p>ل PHP دا ناڤێ کۆنسترەکتەری <code>__construct</code>یە. پێ <code>this-&gt;</code> تایبەتمەندییێن کلاسێ دیاری دکەی:</p><pre>class Car {\n    public $brand;\n    public $year;\n\n    function __construct($brand, $year) {\n        $this-&gt;brand = $brand;\n        $this-&gt;year = $year;\n    }\n}\n\n$car = new Car("Toyota", 2026);\necho $car-&gt;brand . " - " . $car-&gt;year;</pre><p>پێ <code>new</code> ئۆبجێکت دروست دبیت و <code>__construct</code> ب پارامەترانەڤە خۆکار بانگ دبیت. کۆنسترەکتەر دکەت هەر ئۆبجێکتەک ڤە دەمێ دروست دبیت، هازار بیت بو بکارئینانێ.</p>',
        'code' => '<?php
class Car {
    public $brand;
    public $year;

    function __construct($brand, $year) {
        $this->brand = $brand;
        $this->year = $year;
    }
}

$car = new Car("Toyota", 2026);
echo $car->brand . " - " . $car->year;
?>',
        'example_output' => 'Toyota - 2026',
        'challenge_desc_so' => 'بە __construct کلاسێکی Student دروست بکە کە name="Ava" دەگرێتەوە و name چاپ بکە',
        'challenge_desc_ba' => 'پێ __construct کلاسەکا Student دروست بکە کو name="Ava" هەلگریت و name چاپ بکە',
        'expected_output' => 'Ava',
    ],
    [
        'order' => 22,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ئۆپێراتۆری سێهەم (Ternary)',
        'title_ba' => 'ئۆپێراتۆرێ سیانە (Ternary)',
        'content_so' => '<p><strong>ئۆپێراتۆری سێهەم (Ternary)</strong> کورتترین ڕێگەی <code>if/else</code>ە:</p><pre>$age = 18;\n$status = ($age &gt;= 18) ? "Kêm" : "Ciwan";\necho $status;   // Kêm</pre><p>فۆرمات: <code>مەرج ؟ ئەگەر ڕاست : ئەگەر هەڵە</code>. بۆ مەرجە سادەکان زۆر باشە، بەڵام لە مەرجە ئاڵۆزەکاندا <code>if/else</code> خوێندنەوەی ئاسانترە.</p>',
        'content_ba' => '<p><strong>ئۆپێراتۆرێ سیانە (Ternary)</strong> کورتترین ڕێگای <code>if/else</code>یە:</p><pre>$age = 18;\n$status = ($age &gt;= 18) ? "Kêm" : "Ciwan";\necho $status;   // Kêm</pre><p>فۆرمات: <code>مەرج ؟ گەر راست : گەر خەلەت</code>. بو مەرجێن سادە زۆر باشە، بەلێ د مەرجێن ئالۆز دا <code>if/else</code> هەسانترە خوێندرن.</p>',
        'code' => '$age = 18;
$status = ($age >= 18) ? "Kêm" : "Ciwan";
echo $status;',
        'example_output' => 'Kêm',
        'challenge_desc_so' => 'بە ternary ئەگەر $age=15 بێت "Ciwan" چاپ بکە',
        'challenge_desc_ba' => 'پێ ternary گەر $age=15 بیت "Ciwan" چاپ بکە',
        'expected_output' => 'Ciwan',
    ],
    [
        'order' => 23,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ئۆپێراتۆرە لۆژیکییەکان',
        'title_ba' => 'ئۆپێراتۆرێن لۆژیک',
        'content_so' => '<p>ئۆپێراتۆرە لۆژیکییەکان چەند مەرج یەک دەکەن: <code>&amp;&amp;</code> (هەموو ڕاست)، <code>||</code> (لانی کەم یەک ڕاست)، <code>!</code> (پێچەوانە):</p><pre>$age = 25;\n$hasID = true;\n\nif ($age &gt;= 18 &amp;&amp; $hasID) {\n    echo "Destûr pê heye";\n} else {\n    echo "Rê nîne";\n}</pre><p>بۆ پشکنینی چەند مەرج لە یەک جار، ئۆپێراتۆرە لۆژیکییەکان پێویستن.</p>',
        'content_ba' => '<p>ئۆپێراتۆرێن لۆژیک چەند مەرجان یەک دکەن: <code>&amp;&amp;</code> (هەمی راست)، <code>||</code> (هەرێ مەر یەک راست)، <code>!</code> (بەرەڤاژی):</p><pre>$age = 25;\n$hasID = true;\n\nif ($age &gt;= 18 &amp;&amp; $hasID) {\n    echo "Destûr pê heye";\n} else {\n    echo "Rê nîne";\n}</pre><p>بو پشکنینا چەند مەرجان د یەک جاری دا، ئۆپێراتۆرێن لۆژیک پێدڤین.</p>',
        'code' => '$age = 25;
$hasID = true;

if ($age >= 18 && $hasID) {
    echo "Destûr pê heye";
} else {
    echo "Rê nîne";
}',
        'example_output' => 'Destûr pê heye',
        'challenge_desc_so' => 'بە || مەرجێک بنووسە کە "Gihîştin heye" چاپ بکات',
        'challenge_desc_ba' => 'پێ || مەرجەک بنڤیسە کو "Gihîştin heye" چاپ بکەت',
        'expected_output' => 'Gihîştin heye',
    ],
    [
        'order' => 24,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ئارای هاوشێوە (پێشکەوتوو)',
        'title_ba' => 'ئارایێن هاوشێوە (پێشکەفتی)',
        'content_so' => '<p>ئارای هاوشێوە وەک فەرهەنگە: بە <code>key</code> دەتوانیت زیاد بکەیت، بسڕیتەوە (<code>unset</code>) و بپشکنی (<code>isset</code>):</p><pre>$student = [\n    "name" =&gt; "Ava",\n    "city" =&gt; "Hewlêr",\n    "age" =&gt; 20\n];\n\n$student["lang"] = "PHP";\nunset($student["age"]);\n\nforeach ($student as $key =&gt; $value) {\n    echo $key . ": " . $value . "\n";\n}\n\necho "Lang: " . (isset($student["lang"]) ? "Erê" : "Na");</pre><p>بە <code>isset()</code> دەپشکێنیت ئایا key یەک هەیە یان نا — پێش خوێندنەوە زۆر بەسوودە.</p>',
        'content_ba' => '<p>ئارایێن هاوشێوە وەک فەرهەنگ ین: پێ <code>key</code> دکەی زێدە بکەی، ژێ ببەی (<code>unset</code>) و پشدکنی (<code>isset</code>):</p><pre>$student = [\n    "name" =&gt; "Ava",\n    "city" =&gt; "Hewlêr",\n    "age" =&gt; 20\n];\n\n$student["lang"] = "PHP";\nunset($student["age"]);\n\nforeach ($student as $key =&gt; $value) {\n    echo $key . ": " . $value . "\n";\n}\n\necho "Lang: " . (isset($student["lang"]) ? "Erê" : "Na");</pre><p>پێ <code>isset()</code> پشدکنی گەر key هەیت یا نا — بەری خوەندنەوە زۆر ب سوودە.</p>',
        'code' => '$student = [
    "name" => "Ava",
    "city" => "Hewlêr",
    "age" => 20
];

$student["lang"] = "PHP";
unset($student["age"]);

foreach ($student as $key => $value) {
    echo $key . ": " . $value . "\n";
}

echo "Lang: " . (isset($student["lang"]) ? "Erê" : "Na");',
        'example_output' => 'name: Ava
city: Hewlêr
lang: PHP
Lang: Erê',
        'challenge_desc_so' => 'پێش خوێندنەوە بە isset بپشکنە ئایا $data["city"] هەیە یان نا',
        'challenge_desc_ba' => 'بەری خوەندنەوە پێ isset پشدکنە گەر $data["city"] هەیت یا نا',
        'expected_output' => 'Na',
    ],
    [
        'order' => 25,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'خولگە لە ناو خولگە',
        'title_ba' => 'گەڕخستن د ناڤ گەڕخستنێ دا',
        'content_so' => '<p>دەتوانیت خولگەیەک لە ناو خولگەیەکی تر دانێیت — بەمەش لێرە و ستوونەکان دروست دەکەیت:</p><pre>for ($i = 1; $i &lt;= 3; $i++) {\n    $line = "";\n    for ($j = 1; $j &lt;= 3; $j++) {\n        $line .= $i . $j . " ";\n    }\n    echo rtrim($line) . "\n";\n}</pre><p>خولگەی دەرەوە بۆ لێرەکان و خولگەی ناوەوە بۆ ستوونەکانە. بۆ لێرە و ستوونی زۆر بەسوودە.</p>',
        'content_ba' => '<p>دکەی گەڕخستنەکا د ناڤ گەڕخستنا دین دا دانی — ب ڤی ڕەنگی ستوون و ریز دروست دکەی:</p><pre>for ($i = 1; $i &lt;= 3; $i++) {\n    $line = "";\n    for ($j = 1; $j &lt;= 3; $j++) {\n        $line .= $i . $j . " ";\n    }\n    echo rtrim($line) . "\n";\n}</pre><p>گەڕخستنا دەرڤەی بو ریزان و گەڕخستنا ناڤی بو ستوونانە. بو ریز و ستوون زۆر ب سوودە.</p>',
        'code' => 'for ($i = 1; $i <= 3; $i++) {
    $line = "";
    for ($j = 1; $j <= 3; $j++) {
        $line .= $i . $j . " ";
    }
    echo rtrim($line) . "\n";
}',
        'example_output' => '11 12 13
21 22 23
31 32 33',
        'challenge_desc_so' => 'خولگەی لێکدراو بۆ لێرە و ستوونی 1 بۆ 3 بە لێکدانی ژمارەکان چاپ بکە',
        'challenge_desc_ba' => 'گەڕخستنا تێکەل بو ریز و ستوونێن 1 هەتا 3 ب زێدەکرنا ژماران چاپ بکە',
        'expected_output' => '1 2 3
2 4 6
3 6 9',
    ],
    [
        'order' => 26,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'بۆماوە (Inheritance — extends)',
        'title_ba' => 'بۆماوە (Inheritance — extends)',
        'content_so' => '<p><strong>بۆماوە (Inheritance)</strong> وا دەکات کلاسێکی منداڵ هەموو مێتۆد و خاسیەتەکانی کلاسێکی باوک بەکاربهێنێتەوە بەبێ دووبارە نووسینەوە. بە وشەی <code>extends</code> دیاری دەکرێت:</p><pre>class Animal {\n    public $name;\n\n    function __construct($name) {\n        $this-&gt;name = $name;\n    }\n\n    function sound() {\n        return "some sound";\n    }\n}\n\nclass Dog extends Animal {\n    function sound() {\n        return "Woof!";\n    }\n}\n\n$dog = new Dog("Rex");\necho $dog-&gt;name . ": " . $dog-&gt;sound();</pre><p>کلاسی <code>Dog</code> بۆماوەی <code>Animal</code> وەردەگرێت — ناوی، کۆنسترەکتنەر و مێتۆدی <code>sound()</code> بۆی دەگەڕێت. دەتوانیت هەروەها مێتۆدی نوێ زیادی بکەیت.</p><p>بە <code>extends</code> کۆدەت لە دووبارەبوونەوە ڕزگار دەبێت — هەر کلاسێکی تر کە هەمان خاسیەت دەوێت، بە سادەیی بۆماوە وەردەگرێت.</p>',
        'content_ba' => '<p><strong>بۆماوە (Inheritance)</strong> دکەت کلاسەکا زارۆک هەمی مێتۆد و تایبەتمەندییێن کلاسەکا باوک بکاربینەڤە بێ دوبارە نڤیسینێ. پێ پەیڤا <code>extends</code> دیاری دبیت:</p><pre>class Animal {\n    public $name;\n\n    function __construct($name) {\n        $this-&gt;name = $name;\n    }\n\n    function sound() {\n        return "some sound";\n    }\n}\n\nclass Dog extends Animal {\n    function sound() {\n        return "Woof!";\n    }\n}\n\n$dog = new Dog("Rex");\necho $dog-&gt;name . ": " . $dog-&gt;sound();</pre><p>کلاسا <code>Dog</code> بۆماوەی <code>Animal</code> هەلگریت — ناڤ، کۆنسترەکتەر و مێتۆدا <code>sound()</code> بو وی دگەڕن. دکەی ژی مێتۆدێن نوی زێدە بکەی.</p><p>پێ <code>extends</code> کۆدێ ت ژ دوبارەبوونێ دەرچیت — هەر کلاسەکا دین کو هەمان تایبەتمەندی دڤێت، ب ساداهی بۆماوە هەلگریت.</p>',
        'code' => '<?php
class Animal {
    public $name;

    function __construct($name) {
        $this->name = $name;
    }

    function sound() {
        return "some sound";
    }
}

class Dog extends Animal {
    function sound() {
        return "Woof!";
    }
}

$dog = new Dog("Rex");
echo $dog->name . ": " . $dog->sound();
?>',
        'example_output' => 'Rex: Woof!',
        'challenge_desc_so' => 'کلاسێکی Cat دروست بکە کە بۆماوەی Animal بێت و مێتۆدی sound لەسەر بنووسێتەوە بۆ "Mew!" و چاپی بکە',
        'challenge_desc_ba' => 'کلاسەکا Cat دروست بکە کو بۆماوەی Animal بیت و مێتۆدا sound ل سەر بنڤیسە بو "Mew!" و چاپا وی بکە',
        'expected_output' => 'Mew!',
    ],
    [
        'order' => 27,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پۆلیمۆرفیزم (Method Overriding)',
        'title_ba' => 'پۆلیمۆرفیزم (Method Overriding)',
        'content_so' => '<p><strong>Method Overriding</strong> ئەوەیە کلاسێکی منداڵ مێتۆدێکی باوکی بە هەمان ناو دەگۆڕێت. کاتێک ئۆبجێکتی منداڵەکە بانگی دەکەیت، وەشانەکەی خۆی جێبەجێ دەبێت نەوەک وەشانی باوکەکەی:</p><pre>class Shape {\n    function area() {\n        return 0;\n    }\n}\n\nclass Rect extends Shape {\n    public $w;\n    public $h;\n\n    function __construct($w, $h) {\n        $this-&gt;w = $w;\n        $this-&gt;h = $h;\n    }\n\n    function area() {\n        return $this-&gt;w * $this-&gt;h;\n    }\n}\n\n$rect = new Rect(4, 5);\necho "Area = " . $rect-&gt;area();</pre><p>ئەمە بنەمای <strong>پۆلیمۆرفیزم (Polymorphism)</strong>ە — هەمان ناوی مێتۆد، بەڵام ڕەفتاری جیاواز بەپێی کلاسەکە.</p><p>کلاسی <code>Rect</code> مێتۆدی <code>area()</code> لەسەر دەنووسێتەوە بۆ هەژمارکردنی ڕووبەری چوارگۆشە. باوکەکەی (<code>Shape</code>) بە سادەیی <code>0</code> دەگەڕێنێتەوە.</p>',
        'content_ba' => '<p><strong>Method Overriding</strong> ئەوەیە کلاسا زارۆک مێتۆدەکا باوکی ب هەمان ناڤ دگوهوریت. دەمێ ئۆبجێکتا زارۆکە بانگ دکەی، وەشانێ خو جێبەجێ دبیت نە وەشانێ باوک:</p><pre>class Shape {\n    function area() {\n        return 0;\n    }\n}\n\nclass Rect extends Shape {\n    public $w;\n    public $h;\n\n    function __construct($w, $h) {\n        $this-&gt;w = $w;\n        $this-&gt;h = $h;\n    }\n\n    function area() {\n        return $this-&gt;w * $this-&gt;h;\n    }\n}\n\n$rect = new Rect(4, 5);\necho "Area = " . $rect-&gt;area();</pre><p>ئەڤ یە بناغەی <strong>پۆلیمۆرفیزم (Polymorphism)</strong>ە — هەمان ناڤێ مێتۆدی، بەلێ رەفتارەکا جیاواز ب پەی کلاسێ.</p><p>کلاسا <code>Rect</code> مێتۆدا <code>area()</code> ل سەر بنڤیسە بو هەژمارکرنا رووبەرێ چوارگۆشەی. باوکە (<code>Shape</code>) ب ساداهی <code>0</code> ڤەدگەرینت.</p>',
        'code' => '<?php
class Shape {
    function area() {
        return 0;
    }
}

class Rect extends Shape {
    public $w;
    public $h;

    function __construct($w, $h) {
        $this->w = $w;
        $this->h = $h;
    }

    function area() {
        return $this->w * $this->h;
    }
}

$rect = new Rect(4, 5);
echo "Area = " . $rect->area();
?>',
        'example_output' => 'Area = 20',
        'challenge_desc_so' => 'کلاسێکی Square دروست بکە کە بۆماوەی Shape بێت، area لەسەر بنووسێتەوە و area بۆ side=3 چاپ بکە',
        'challenge_desc_ba' => 'کلاسەکا Square دروست بکە کو بۆماوەی Shape بیت، area ل سەر بنڤیسە و area بو side=3 چاپ بکە',
        'expected_output' => '9',
    ],
    [
        'order' => 28,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کەپسولکردن (Visibility)',
        'title_ba' => 'کەپسولکردن (Visibility)',
        'content_so' => '<p><strong>کەپسولکردن (Visibility)</strong> دیاری دەکات کێ دەتوانێ بگاتە خاسیەت و مێتۆدەکان. <code>public</code> بۆ هەمووان، <code>private</code> تەنها لە ناو کلاسەکەدا، و <code>protected</code> لە کلاسەکە و کلاسە منداڵەکاندا.</p><p>بۆ خوێندنەوە و گۆڕینی خاسیەتی <code>private</code>، مێتۆدی <strong>getter و setter</strong> بەکاردەهێنرێن:</p><pre>class BankAccount {\n    private $balance;\n\n    function __construct($amount) {\n        $this-&gt;balance = $amount;\n    }\n\n    function getBalance() {\n        return $this-&gt;balance;\n    }\n\n    function setBalance($amount) {\n        if ($amount &gt;= 0) {\n            $this-&gt;balance = $amount;\n        }\n    }\n}\n\n$acc = new BankAccount(100);\n$acc-&gt;setBalance(250);\necho "Balance = " . $acc-&gt;getBalance();</pre><p>بە شاردنەوەی داتاکان، کەس لە دەرەوە ناتوانێت بە ڕاستەوخۆ بیگۆڕێت — هەموو گۆڕانکارییەکان لە ناو مێتۆدەکاندا دەپشکنرێن، بەمەش داتاکەت سەلامەتترە.</p>',
        'content_ba' => '<p><strong>کەپسولکردن (Visibility)</strong> دیاری دکەت کێ دکە بگهیتە تایبەتمەندی و مێتۆدان. <code>public</code> بو هەمیان، <code>private</code> تەنها د ناڤ کلاسێ دا، و <code>protected</code> د کلاسێ و کلاسێن زارۆک دا.</p><p>بو خوەندنەوە و گوهۆرینا تایبەتمەندییەکا <code>private</code>، مێتۆدێن <strong>getter و setter</strong> بکارتین:</p><pre>class BankAccount {\n    private $balance;\n\n    function __construct($amount) {\n        $this-&gt;balance = $amount;\n    }\n\n    function getBalance() {\n        return $this-&gt;balance;\n    }\n\n    function setBalance($amount) {\n        if ($amount &gt;= 0) {\n            $this-&gt;balance = $amount;\n        }\n    }\n}\n\n$acc = new BankAccount(100);\n$acc-&gt;setBalance(250);\necho "Balance = " . $acc-&gt;getBalance();</pre><p>پێ ڤەشارتنا داتایان، کەس ژ دەرڤەی ناشێ ب راستەخۆ بگوهوریت — هەمی گوهۆرین د ناڤ مێتۆدان دا پشدکنرن، ب ڤی ڕەنگی داتایێ تە زێدەت ئارامە.</p>',
        'code' => '<?php
class BankAccount {
    private $balance;

    function __construct($amount) {
        $this->balance = $amount;
    }

    function getBalance() {
        return $this->balance;
    }

    function setBalance($amount) {
        if ($amount >= 0) {
            $this->balance = $amount;
        }
    }
}

$acc = new BankAccount(100);
$acc->setBalance(250);
echo "Balance = " . $acc->getBalance();
?>',
        'example_output' => 'Balance = 250',
        'challenge_desc_so' => 'بە private و getter کلاسێکی User دروست بکە کە name بە getter دەگەڕێنێتەوە و "Ava" چاپ بکە',
        'challenge_desc_ba' => 'پێ private و getter کلاسەکا User دروست بکە کو name پێ getter ڤەدگەرینت و "Ava" چاپ بکە',
        'expected_output' => 'Ava',
    ],
    [
        'order' => 29,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: کۆی ئارای',
        'title_ba' => 'پرۆژە: کۆمەلا ئارای',
        'content_so' => '<p><strong>پرۆژە:</strong> کۆی ئەندامەکانی ئارای لە خولگەی <code>foreach</code> کۆ بکەرەوە — ئەمە بنەمای زۆرێک لە پرۆژە ڕاستەقینەکانە وەک هەژماری بەروار:</p><pre>$numbers = [4, 8, 15, 16, 23, 42];\n$total = 0;\n\nforeach ($numbers as $num) {\n    $total += $num;\n}\n\necho "Total = " . $total;</pre><p>هەمان ئەنجام دەتوانیت بە <code>array_sum()</code> بەدەست بهێنیت — بەڵام بە خولگە فێر دەبیت کە لە ناوەوە چۆن کار دەکات.</p>',
        'content_ba' => '<p><strong>پرۆژە:</strong> کۆمەلا ئەندامێن ئارای د گەڕخستنا <code>foreach</code> دا کۆم بکە — ئەڤ یە بناغەی زاف پڕۆژە ڕاستەقینە یە وەک هەژمارا بەروار:</p><pre>$numbers = [4, 8, 15, 16, 23, 42];\n$total = 0;\n\nforeach ($numbers as $num) {\n    $total += $num;\n}\n\necho "Total = " . $total;</pre><p>هەمان دەرئەنجام دکەی پێ <code>array_sum()</code> بدست بینی — بەلێ پێ گەڕخستنێ فێر دبی کو د ناڤدا چەوا کار دکەت.</p>',
        'code' => '$numbers = [4, 8, 15, 16, 23, 42];
$total = 0;

foreach ($numbers as $num) {
    $total += $num;
}

echo "Total = " . $total;',
        'example_output' => 'Total = 108',
        'challenge_desc_so' => 'کۆی ئارای [10, 20, 30] چاپ بکە',
        'challenge_desc_ba' => 'کۆمەلا ئارای [10, 20, 30] چاپ بکە',
        'expected_output' => '60',
    ],
    [
        'order' => 30,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz بە فەنکشن',
        'title_ba' => 'پرۆژە: FizzBuzz پێ فەنکشن',
        'content_so' => '<p><strong>پرۆژە:</strong> FizzBuzz بە شێوازی فەنکشن — بەجیاتی چاپکردنی دەستبەجێ، فەنکشنەکە ئەنجام دەگەڕێنێتەوە و ئارای پڕ دەکەین:</p><pre>function fizzbuzz($n) {\n    if ($n % 15 == 0) return "FizzBuzz";\n    if ($n % 3 == 0) return "Fizz";\n    if ($n % 5 == 0) return "Buzz";\n    return (string)$n;\n}\n\n$result = [];\nfor ($i = 1; $i &lt;= 10; $i++) {\n    $result[] = fizzbuzz($i);\n}\necho implode("\n", $result);</pre><p>فەنکشن کۆدەکەت دوبارە بەکارهێنەر دەکات و تاقیکردنەوەی ئاسانتر دەکات — لەم پرۆژەیەدا ئەنجامەکان لە ئارایەکدا کۆ دەکرێنەوە.</p>',
        'content_ba' => '<p><strong>پرۆژە:</strong> FizzBuzz پێ شێوازا فەنکشن — ب جیهاتا چاپکرنا دەستبەجێ، فەنکشن دەرئەنجام ڤەدگەرینت و ئارای تێر دکەین:</p><pre>function fizzbuzz($n) {\n    if ($n % 15 == 0) return "FizzBuzz";\n    if ($n % 3 == 0) return "Fizz";\n    if ($n % 5 == 0) return "Buzz";\n    return (string)$n;\n}\n\n$result = [];\nfor ($i = 1; $i &lt;= 10; $i++) {\n    $result[] = fizzbuzz($i);\n}\necho implode("\n", $result);</pre><p>فەنکشن کۆدێ ت دوبارە بکارهینەر دکەت و تاقیکرن هەسانتر دکەت — د ڤی پرۆژەیی دا دەرئەنجام د ئارایەکەڤە کۆم دبن.</p>',
        'code' => 'function fizzbuzz($n) {
    if ($n % 15 == 0) return "FizzBuzz";
    if ($n % 3 == 0) return "Fizz";
    if ($n % 5 == 0) return "Buzz";
    return (string)$n;
}

$result = [];
for ($i = 1; $i <= 10; $i++) {
    $result[] = fizzbuzz($i);
}
echo implode("\n", $result);',
        'example_output' => '1
2
Fizz
4
Buzz
Fizz
7
8
Fizz
Buzz',
        'challenge_desc_so' => 'بە فەنکشنی fizzbuzz بۆ 10 چاپ بکە',
        'challenge_desc_ba' => 'پێ فەنکشنا fizzbuzz بو 10 چاپ بکە',
        'expected_output' => 'Buzz',
    ],
];

if (defined('FERGA_SEED_LIB')) {
    $FERGA_SEED_LIBS['php'] = ['langId' => '-Oysj44hJLXDgdp-b9iN', 'lessons' => $lessons];
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

echo "\nDone! PHP lessons have been added to Ferga.\n";
