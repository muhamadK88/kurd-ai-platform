<?php

// Script to add C++ language and lessons to the Ferga section in Firebase
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

// 1. Add the C++ language
$langRes = fbPost($firebaseUrl . 'ferga_languages.json', [
    'name_so' => 'C++',
    'name_ba' => 'C++',
    'desc_so' => 'C++ یەکێکە لە بەهێزترین زمانەکانی پرۆگرامکردن، بەکاردێت بۆ دروستکردنی یاری، سیستەمی وەگەڕخستن و ئەپڵیکەیشنە ئاستبەرزەکان. فێربوونی یارمەتیت دەدات بنەمای پرۆگرامکردن بە تەواوی تێبگەیت.',
    'desc_ba' => 'C++ ئێک ژ زمانێن هەرە بیهێز یێن پروگرامسازییێ یە، بکارتیت بۆ دروستکرنا یارییان، سیستەمان و ئەپلیکەیشنێن ئاستبلند. فێربوونا وی هاریکارییێ دکەت کو بنەمایێن پروگرامسازییێ تەمام تێبگەهی.',
    'ext' => 'cpp',
    'color' => 'from-blue-500 to-sky-400',
    'logo_url' => 'https://i.ibb.co/wgvXsLx/cpp-logo.png',
]);

$langData = json_decode($langRes, true);
if (!isset($langData['name'])) {
    echo "ERROR: could not create language\n$langRes\n";
    exit(1);
}
$langId = $langData['name'];
echo "Language created with ID: $langId\n";

// 2. Add lessons
$lessons = [
    [
        'order' => 1,
        'level_so' => 'ئاستی ١ - بنەڕەتەکان',
        'level_ba' => 'ئاستا ١ - بنگەهێن',
        'title_so' => 'چییە C++؟',
        'title_ba' => 'چ یە C++؟',
        'content_so' => '<p><strong>C++</strong> زمانێکە لە ساڵی ١٩٨٥ لەلایەن <strong>Bjarne Stroustrup</strong> دروستکراوە وەک بەرزکردنەوەی زمانەکە. ئەم زمانە بەرز دەبێتەوە بۆ پرۆگرامی ئاستبەرز وەک یارییەکان، سیستەمی کارپێکردن، و بەرنامەی باڵا.</p><p>هەندێک لە تایبەتمەندییەکانی C++:</p><ul><li>خێراییەکی زۆر بەرز</li><li>کۆنترۆڵی تەواو لەسەر یادگە</li><li>بەکاردێت لە یاری، سیستەم، AI و زۆر شوێنی تر</li></ul><p>لەم کۆرسەدا هەنگاو بە هەنگاو فێری دەبین.</p>',
        'content_ba' => '<p><strong>C++</strong> زمانەکە د سالا ١٩٨٥ ڤە ل لایەن <strong>Bjarne Stroustrup</strong> هاتیە دروستکرن وەک بلندکرنا زمانێ C. ئەڤ زمان بکارتیت بو پروگرامێن ئاستبلند وەک یاری، سیستەمێن کارپێکرنێ و بەرنامەیێن بلند.</p><p>هەندەک ژ تایبەتمەندییێن C++:</p><ul><li>خێراییەکا زۆر بلند</li><li>کۆنترۆلا تەمام ل سەر بیرێ (memory)</li><li>بکارتیت د یاری، سیستەم، AI و جهێن دیان دا</li></ul><p>د ڤێ کورسێ دا پێنگاڤ ب پێنگاڤ فێر دبیت.</p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << \"Hello from C++!\" << endl;\n    return 0;\n}",
        'example_output' => "Hello from C++!",
        'challenge_desc_so' => 'پرۆگرامێک بنووسە کە "Bêxhatin bo C++!" چاپ بکات',
        'challenge_desc_ba' => 'پرۆگرامەک بنڤیسە کو "Bêxhatin bo C++!" چاپ بکەت',
        'expected_output' => "Bêxhatin bo C++!",
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - بنەڕەتەکان',
        'level_ba' => 'ئاستا ١ - بنگەهێن',
        'title_so' => 'گۆڕاوەکان و جۆرەکانی داتا',
        'title_ba' => 'گۆڕۆک و چەشنێن داتایێ',
        'content_so' => '<p><strong>گۆڕاو (Variable)</strong> شوێنێکە لە یادگەدا کە بەهایەک لە خۆ دەگرێت. لە C++ بۆ دروستکردنی گۆڕاو دەبێت جۆری داتاکە دیاری بکەیت:</p><pre>int num = 10;        // تەواو ژمارە\nfloat pi = 3.14;     // ژمارەی لۆیی\ndouble d = 3.14159;  // ژمارەی لۆیی وردتر\nchar ch = \'A\';       // پیت\ndoubleتە بەڵام bool b = true; // ڕاست یان هەڵە\nstring name = "Kurd"; // دەق</pre><p>بە <code>cout</code> دەتوانیت بەهای گۆڕاوەکان نیشان بدەیت.</p>',
        'content_ba' => '<p><strong>گۆڕۆک (Variable)</strong> جهەکە د بیرێ دا کو بەهایەک د خۆ دا دگریت. د C++ دا بو دروستکرنا گۆڕۆکی دڤێت چەشنێ داتایێ دیاری بکی:</p><pre>int num = 10;        // ژمارە تەمام\nfloat pi = 3.14;     // ژمارەکا لۆیی\nchar ch = \'A\';       // پیت\nbool b = true;       // راست یا خەلەت\nstring name = "Kurd"; // نڤیسین</pre><p>پێ <code>cout</code> تۆ دکەی بەهایێن گۆڕۆکان نیشان بدەی.</p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    int age = 20;\n    double price = 9.99;\n    string city = \"Hewlêr\";\n\n    cout << \"Age: \" << age << endl;\n    cout << \"Price: \" << price << endl;\n    cout << \"City: \" << city << endl;\n    return 0;\n}",
        'example_output' => "Age: 20\nPrice: 9.99\nCity: Hewlêr",
        'challenge_desc_so' => 'گۆڕاوێک دروست بکە بە ناوی "score" بە بەهای ١٠٠ و چاپی بکە',
        'challenge_desc_ba' => 'گۆڕۆکەک دروست بکە ب ناڤێ "score" ب بەهایا ١٠٠ و چاپا وی بکە',
        'expected_output' => "100",
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - بنەڕەتەکان',
        'level_ba' => 'ئاستا ١ - بنگەهێن',
        'title_so' => 'وەرگرتنی داتا (cin)',
        'title_ba' => 'هەلگرتنا داتایێ (cin)',
        'content_so' => '<p>بە <code>cin</code> دەتوانیت داتا لە بەکارهێنەر وەربگریت. بە <code>&gt;&gt;</code> داتاکە دەخرێتە ناو گۆڕاوەکە:</p><pre>int age;\ncin &gt;&gt; age;   // بەکارهێنەر ژمارەیەک دەنووسێت\n\ncout &lt;&lt; "Your age is " &lt;&lt; age &lt;&lt; endl;</pre><p>بۆ وەرگرتنی دەق (string) پێویستە <code>getline()</code> بەکاربهێنیت.</p>',
        'content_ba' => '<p>پێ <code>cin</code> تۆ دکەی داتا ژ بکارهێنەری هەلگری. پێ <code>&gt;&gt;</code> داتایێ دچیتە ناڤ گۆڕۆکی:</p><pre>int age;\ncin &gt;&gt; age;   // بکارهێنەر ژمارەیەک دینڤیسە\n\ncout &lt;&lt; "Your age is " &lt;&lt; age &lt;&lt; endl;</pre><p>بو هەلگرتنا نڤیسینێ (string) دڤێت <code>getline()</code> بکاربینی.</p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    string name;\n    cout << \"What is your name? \";\n    cin >> name;\n    cout << \"Salam \" << name << \"!\" << endl;\n    return 0;\n}",
        'example_output' => "Salam Kurd!",
        'challenge_desc_so' => 'پرۆگرامێک بنووسە کە تەمەن وەربگرێت و بە "You are X years old" نیشانی بدات',
        'challenge_desc_ba' => 'پرۆگرامەک بنڤیسە کو تەمەن هەلگریت و ب "You are X years old" نیشان بدەت',
        'expected_output' => "You are 25 years old",
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ٢ - مەرجەکان',
        'level_ba' => 'ئاستا ٢ - مەرج',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>بە <code>if</code> و <code>else</code> دەتوانیت بڕیار بدەیت. ئەگەر مەرجەکە ڕاست بێت، کۆدەکە جێبەجێ دەبێت:</p><pre>int score = 85;\n\nif (score &gt;= 50) {\n    cout &lt;&lt; "Bêşar!";   // ڕاستە\n} else {\n    cout &lt;&lt; "Bi ser nekefti!";\n}</pre><p>ئۆپێراتۆرەکانی بەراوردکردن: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code></p>',
        'content_ba' => '<p>پێ <code>if</code> و <code>else</code> تۆ دکەی بریار بدەی. گەر مەرج راست بیت، کۆد جێبەجێ دبیت:</p><pre>int score = 85;\n\nif (score &gt;= 50) {\n    cout &lt;&lt; "Bêşar!";   // راستە\n} else {\n    cout &lt;&lt; "Bi ser nekefti!";\n}</pre><p>ئۆپێراتۆرێن بەراوردکرنێ: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code></p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    int score = 85;\n\n    if (score >= 50) {\n        cout << \"Bêşar! You passed.\" << endl;\n    } else {\n        cout << \"Fail!\" << endl;\n    }\n    return 0;\n}",
        'example_output' => "Bêşar! You passed.",
        'challenge_desc_so' => 'مەرجێک بنووسە: ئەگەر num=7 هەڵبژاردنەکە ڕاست بێت "Even" یان "Odd" چاپ بکات',
        'challenge_desc_ba' => 'مەرجەک بنڤیسە: گەر num=7 بیت "Even" یا "Odd" چاپ بکەت',
        'expected_output' => "Odd",
    ],
    [
        'order' => 5,
        'level_so' => 'ئاستی ٢ - مەرجەکان',
        'level_ba' => 'ئاستا ٢ - مەرج',
        'title_so' => 'خولگەکان (Loops)',
        'title_ba' => 'گەڕخستن (Loops)',
        'content_so' => '<p><strong>خولگە (Loop)</strong> کۆدێک دووبارە دەکاتەوە. لە C++ سێ جۆر خولگە هەیە:</p><pre>// for - کاتێک ژمارەی تکرارەکان زانراوە\nfor (int i = 1; i &lt;= 5; i++) {\n    cout &lt;&lt; i &lt;&lt; " ";\n}\n\n// while - کاتێک مەرجەکە ڕاستە\nint j = 0;\nwhile (j &lt; 5) {\n    cout &lt;&lt; j &lt;&lt; " ";\n    j++;\n}</pre><p>ئەم کۆدە ئەنجام دەدات: <code>1 2 3 4 5</code></p>',
        'content_ba' => '<p><strong>گەڕخستن (Loop)</strong> کۆدێ دوبارە دکەت. د C++ دا سێ چەشن گەڕخستنێ هەن:</p><pre>// for - دەمە کو ژمارا دوبارەکرنێ زانرایە\nfor (int i = 1; i &lt;= 5; i++) {\n    cout &lt;&lt; i &lt;&lt; " ";\n}\n\n// while - دەمە کو مەرج راستە\nint j = 0;\nwhile (j &lt; 5) {\n    cout &lt;&lt; j &lt;&lt; " ";\n    j++;\n}</pre><p>ئەڤ کۆدە دەرئەنجام ددەت: <code>1 2 3 4 5</code></p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    for (int i = 1; i <= 5; i++) {\n        cout << i << \" \";\n    }\n    cout << endl;\n    return 0;\n}",
        'example_output' => "1 2 3 4 5",
        'challenge_desc_so' => 'خولگەیەک بنووسە کە ١٠ بۆ ١ بە پاشەوە چاپ بکات',
        'challenge_desc_ba' => 'گەڕخستنەک بنڤیسە کو ١٠ هەتا ١ ب پاشدا چاپ بکەت',
        'expected_output' => "10 9 8 7 6 5 4 3 2 1",
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'فەنکشنەکان (Functions)',
        'title_ba' => 'فەنکشن (Functions)',
        'content_so' => '<p><strong>فەنکشن</strong> بلۆکێکی کۆدە کە ئەرکێکی دیاریکراو جێبەجێ دەکات و دەتوانیت چەند جار بەکاری بهێنیت:</p><pre>// فەنکشنی بێ گەڕاندنەوە\nvoid sayHello() {\n    cout &lt;&lt; "Hello!";\n}\n\n// فەنکشنی گەڕانەوەی بەها\nint add(int a, int b) {\n    return a + b;\n}\n\nint main() {\n    sayHello();\n    int sum = add(5, 3);  // sum = 8\n    return 0;\n}</pre>',
        'content_ba' => '<p><strong>فەنکشن</strong> بلۆکەکا کۆدێ یە کو ئەرکەکا دیاریکراو جێبەجێ دکەت و تۆ دکەی چەند جاران بکاربینی:</p><pre>// فەنکشن بێ ڤەگەڕاندنا بەهایێ\nvoid sayHello() {\n    cout &lt;&lt; "Hello!";\n}\n\n// فەنکشن ڤەگەڕاندنا بەهایێ\nint add(int a, int b) {\n    return a + b;\n}\n\nint main() {\n    sayHello();\n    int sum = add(5, 3);  // sum = 8\n    return 0;\n}</pre>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint add(int a, int b) {\n    return a + b;\n}\n\nint main() {\n    int sum = add(5, 3);\n    cout << \"Sum = \" << sum << endl;\n    return 0;\n}",
        'example_output' => "Sum = 8",
        'challenge_desc_so' => 'فەنکشنێکی "multiply" دروست بکە کە دوو ژمارە زۆر بکات و ئەنجامی ٦×٧ چاپ بکات',
        'challenge_desc_ba' => 'فەنکشنەکا "multiply" دروست بکە کو دوو ژماران زێدە بکەت و ئەنجامێ ٦×٧ چاپ بکەت',
        'expected_output' => "42",
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ئارایەکان (Arrays)',
        'title_ba' => 'ئارای (Arrays)',
        'content_so' => '<p><strong>ئارای (Array)</strong> کۆمەڵێک بەها لە یەک گۆڕاودا دەگرێت:</p><pre>int numbers[5] = {10, 20, 30, 40, 50};\n\ncout &lt;&lt; numbers[0];  // 10\ncout &lt;&lt; numbers[3];  // 40</pre><p>بە بیر بێت کە ئیندێکسەکان لە <strong>٠</strong> دەست پێ دەکەن.</p>',
        'content_ba' => '<p><strong>ئارای (Array)</strong> کۆمەکەک بەها د یەک گۆڕۆکی دا دگریت:</p><pre>int numbers[5] = {10, 20, 30, 40, 50};\n\ncout &lt;&lt; numbers[0];  // 10\ncout &lt;&lt; numbers[3];  // 40</pre><p>د بیرا خۆدا گریت کو ئیندێکس ژ <strong>٠</strong> دەست پێ دکەن.</p>',
        'code' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    int numbers[5] = {10, 20, 30, 40, 50};\n\n    for (int i = 0; i < 5; i++) {\n        cout << numbers[i] << \" \";\n    }\n    cout << endl;\n    return 0;\n}",
        'example_output' => "10 20 30 40 50",
        'challenge_desc_so' => 'ئارایەک بە "Kurd" و "Arab" و "Turk" دروست بکە و بە فەنکشنی length هەمووی چاپ بکە',
        'challenge_desc_ba' => 'ئارایەک ب "Kurd" و "Arab" و "Turk" دروست بکە و پێ length هەمی چاپ بکە',
        'expected_output' => "Kurd Arab Turk",
    ],
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

echo "\nDone! C++ and its lessons have been added to Ferga.\n";
