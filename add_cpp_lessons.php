<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$cppLangId = '-Oyrqajy5loFSFBPUgNi';

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

function lesson($order, $lvlSo, $lvlBa, $tSo, $tBa, $cSo, $cBa, $code, $exOut, $chSo = '', $chBa = '', $expOut = '') {
    return [
        'order' => $order,
        'level_so' => $lvlSo, 'level_ba' => $lvlBa,
        'title_so' => $tSo, 'title_ba' => $tBa,
        'content_so' => $cSo, 'content_ba' => $cBa,
        'code' => $code, 'example_output' => $exOut,
        'challenge_desc_so' => $chSo, 'challenge_desc_ba' => $chBa,
        'expected_output' => $expOut,
    ];
}

$L2SO = 'ئاستی ٢ - بنەڕەتی زیاتر';
$L2BA = 'ئاستا ٢ - بنگەهێن زێدەتر';
$L3SO = 'ئاستی ٣ - پێشکەوتوو';
$L3BA = 'ئاستا ٣ - پێشکەفتی';
$L4SO = 'ئاستی ٤ - فایل و STL';
$L4BA = 'ئاستا ٤ - فایل و STL';
$L5SO = 'ئاستی ٥ - پرۆژەکان';
$L5BA = 'ئاستا ٥ - پرۆژە';

$lessons = [];

$lessons[] = lesson(8, $L2SO, $L2BA,
'دەقەکان (Strings)', 'دەق (Strings)',
<<<'SO'
<p>لە <bdi>C++</bdi> دەقەکان لە کلاسی <code>string</code> بەکاردێن (پێویستە <code>#include &lt;string&gt;</code> بکەیت). لەگەڵ string چەند کردەوە هەیە:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;string&gt;\nusing namespace std;\n\nint main() {\n    string name = "Kurd";\n    string city = "Hewlêr";\n\n    // پێکەوەبەستن\n    string full = name + " - " + city;\n    cout &lt;&lt; full &lt;&lt; endl;   // Kurd - Hewlêr\n\n    // درێژایی\n    cout &lt;&lt; name.length() &lt;&lt; endl;   // 4\n\n    // پیتێک وەرگرتن\n    cout &lt;&lt; name[0] &lt;&lt; endl;         // K\n\n    // گۆڕینی پیت\n    name[0] = \'S\';\n    cout &lt;&lt; name &lt;&lt; endl;            // Surd\n    return 0;\n}</pre>
SO,
<<<'BA'
<p>د <bdi>C++</bdi> دا دەق ژ کلاسا <code>string</code> بکارتیت (دڤێت <code>#include &lt;string&gt;</code> بکی). ل گەل string چەند کردار هەن:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;string&gt;\nusing namespace std;\n\nint main() {\n    string name = "Kurd";\n    string city = "Hewlêr";\n\n    // پێکڤەبستن\n    string full = name + " - " + city;\n    cout &lt;&lt; full &lt;&lt; endl;   // Kurd - Hewlêr\n\n    // درێژایی\n    cout &lt;&lt; name.length() &lt;&lt; endl;   // 4\n\n    // پیتەک هەلگرتن\n    cout &lt;&lt; name[0] &lt;&lt; endl;         // K\n\n    // گۆڕینا پیتی\n    name[0] = \'S\';\n    cout &lt;&lt; name &lt;&lt; endl;            // Surd\n    return 0;\n}</pre>
BA,
"#include <iostream>\n#include <string>\nusing namespace std;\n\nint main() {\n    string lang = \"C++\";\n    string course = \"Ferga\";\n    cout << lang + \" \" + course << endl;\n    cout << course.length() << endl;\n    return 0;\n}",
"C++ Ferga\n5",
'دەقێک بنووسە "KurdAI" و درێژاییەکەی چاپ بکە',
'دەقەک بنڤیسە "KurdAI" و درێژاییا وی چاپ بکە',
'6');

$lessons[] = lesson(9, $L2SO, $L2BA,
'فەرمانی switch', 'فەرمانا switch',
<<<'SO'
<p><code>switch</code> ڕێگایەکی ترە بۆ چەند مەرجێک بەبێ زنجیرەی if/else. بۆ بەراوردکردنی بەهایەک لەگەڵ چەند بەهای تر:</p>
<pre>int day = 3;\n\nswitch (day) {\n    case 1:\n        cout &lt;&lt; "Duşem" &lt;&lt; endl;\n        break;\n    case 2:\n        cout &lt;&lt; "Sêşem" &lt;&lt; endl;\n        break;\n    case 3:\n        cout &lt;&lt; "Çarşem" &lt;&lt; endl;\n        break;\n    default:\n        cout &lt;&lt; "Unknown" &lt;&lt; endl;\n}\n// ئەنجام: Çarşem</pre>
<p><strong>گرنگ:</strong> بە <code>break</code> نەبێت، هەموو caseەکانی دواتر جێبەجێ دەبن!</p>
SO,
<<<'BA'
<p><code>switch</code> ڕێکا دی یە بو چەند مەرجان بێ زنجیرا if/else. بو بەراوردکرنا بەهایەکی ل گەل چەند بەهایێن دی:</p>
<pre>int day = 3;\n\nswitch (day) {\n    case 1:\n        cout &lt;&lt; "Duşem" &lt;&lt; endl;\n        break;\n    case 2:\n        cout &lt;&lt; "Sêşem" &lt;&lt; endl;\n        break;\n    case 3:\n        cout &lt;&lt; "Çarşem" &lt;&lt; endl;\n        break;\n    default:\n        cout &lt;&lt; "Unknown" &lt;&lt; endl;\n}\n// دەرئەنجام: Çarşem</pre>
<p><strong>گرنگ:</strong> ب <code>break</code> نەبیت، هەمی caseێن پشتی جێبەجێ دبن!</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    int grade = 2;\n    switch (grade) {\n        case 1: cout << \"A\" << endl; break;\n        case 2: cout << \"B\" << endl; break;\n        case 3: cout << \"C\" << endl; break;\n        default: cout << \"F\" << endl;\n    }\n    return 0;\n}",
'B',
'بە switch لەگەڵ score=1 بەهای "A" چاپ بکە',
'ب switch ل گەل score=1 بەهایا "A" چاپ بکە',
'A');

$lessons[] = lesson(10, $L2SO, $L2BA,
'خولگەی do-while', 'گەڕخستنا do-while',
<<<'SO'
<p><code>do-while</code> وەک while یە بەڵام لە <strong>کۆتاییدا</strong> مەرجەکە دەپشکنێت، واتە لەسەرەتادا بەلایەنی کەم یەک جار جێبەجێ دەبێت:</p>
<pre>int i = 1;\n\ndo {\n    cout &lt;&lt; i &lt;&lt; " ";\n    i++;\n} while (i &lt;= 5);\n// ئەنجام: 1 2 3 4 5</pre>
<p>فەرقەکە لەگەڵ while:</p>
<pre>int i = 10;\n\nwhile (i &lt; 5) {   // هەرگیز جێبەجێ نابێت\n    cout &lt;&lt; i &lt;&lt; endl;\n}\n\ndo {               // یەک جار جێبەجێ دەبێت\n    cout &lt;&lt; i &lt;&lt; endl;\n} while (i &lt; 5);</pre>
SO,
<<<'BA'
<p><code>do-while</code> وەک while یە بەلێ د <strong>کۆتایێ</strong> دا مەرج دپشکنیت، واتە د دەستپێکێ دا ب کێمی ئێک جار جێبەجێ دبیت:</p>
<pre>int i = 1;\n\ndo {\n    cout &lt;&lt; i &lt;&lt; " ";\n    i++;\n} while (i &lt;= 5);\n// دەرئەنجام: 1 2 3 4 5</pre>
<p>فەرق ل گەل while:</p>
<pre>int i = 10;\n\nwhile (i &lt; 5) {   // هەرگیز جێبەجێ نابیت\n    cout &lt;&lt; i &lt;&lt; endl;\n}\n\ndo {               // ئێک جار جێبەجێ دبیت\n    cout &lt;&lt; i &lt;&lt; endl;\n} while (i &lt; 5);</pre>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    int i = 1;\n    do {\n        cout << i << \" \";\n        i++;\n    } while (i <= 3);\n    cout << endl;\n    return 0;\n}",
'1 2 3',
'بە do-while ژمارەکانی 1 بۆ 3 چاپ بکە',
'ب do-while ژمارێن 1 هەتا 3 چاپ بکە',
'1 2 3');

$lessons[] = lesson(11, $L2SO, $L2BA,
'خولگەی تێکڕا و شێوەکان', 'گەڕخستنا تێکرا و شێوە',
<<<'SO'
<p>کاتێک خولگەیەک لە ناو خولگەیەکی تردا بێت، پێی دەوترێت <strong>خولگەی تێکڕا (Nested Loop)</strong>. بەمە دەتوانیت شێوەکان دروست بکەیت:</p>
<pre>// چوارگۆشەی ستێرە\nfor (int i = 0; i &lt; 3; i++) {\n    for (int j = 0; j &lt; 3; j++) {\n        cout &lt;&lt; "* ";\n    }\n    cout &lt;&lt; endl;\n}\n// * * *\n// * * *\n// * * *\n\n// سێگۆشە\nfor (int i = 1; i &lt;= 3; i++) {\n    for (int j = 1; j &lt;= i; j++) {\n        cout &lt;&lt; "* ";\n    }\n    cout &lt;&lt; endl;\n}\n// *\n// * *\n// * * *</pre>
SO,
<<<'BA'
<p>دەمە کو گەڕخستنەک د ناڤ گەڕخستنەکا دی دا بیت، پێی دبێژن <strong>گەڕخستنا تێکرا (Nested Loop)</strong>. ب ڤێ تو دکەی شێوەیان دروست بکی:</p>
<pre>// چوارگۆشەیا ستریان\nfor (int i = 0; i &lt; 3; i++) {\n    for (int j = 0; j &lt; 3; j++) {\n        cout &lt;&lt; "* ";\n    }\n    cout &lt;&lt; endl;\n}\n// * * *\n// * * *\n// * * *\n\n// سێگۆشە\nfor (int i = 1; i &lt;= 3; i++) {\n    for (int j = 1; j &lt;= i; j++) {\n        cout &lt;&lt; "* ";\n    }\n    cout &lt;&lt; endl;\n}\n// *\n// * *\n// * * *</pre>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    for (int i = 0; i < 2; i++) {\n        for (int j = 0; j < 2; j++) {\n            cout << \"#\";\n        }\n        cout << endl;\n    }\n    return 0;\n}",
'##\n##',
'بە خولگەی تێکڕا 3 ستوونی 2 بکە',
'ب گەڕخستنا تێکرا 3 ستوونا 2 بکە',
'###\n###');

$lessons[] = lesson(12, $L2SO, $L2BA,
'ئارای دوو ڕەهەندی (2D Arrays)', 'ئارایا دوو ڕەهەندی (2D Arrays)',
<<<'SO'
<p><strong>ئارای دوو ڕەهەندی</strong> وەک خشتەیەک وایە لە ڕیز و ستوون، کە بە <code>[ڕیز][ستوون]</code> دەگەیتە ئەندامەکانی:</p>
<pre>int matrix[3][3] = {\n    {1, 2, 3},\n    {4, 5, 6},\n    {7, 8, 9}\n};\n\ncout &lt;&lt; matrix[0][0] &lt;&lt; endl;   // 1\ncout &lt;&lt; matrix[1][2] &lt;&lt; endl;   // 6\n\n// چاپکردنی هەموو خشتەکە\nfor (int i = 0; i &lt; 3; i++) {\n    for (int j = 0; j &lt; 3; j++) {\n        cout &lt;&lt; matrix[i][j] &lt;&lt; " ";\n    }\n    cout &lt;&lt; endl;\n}</pre>
SO,
<<<'BA'
<p><strong>ئارایا دوو ڕەهەندی</strong> وەک خشتەیەک وایە ژ ڕیز و ستوونان، کو ب <code>[ڕیز][ستوون]</code> تو دگەهی ئەندامان:</p>
<pre>int matrix[3][3] = {\n    {1, 2, 3},\n    {4, 5, 6},\n    {7, 8, 9}\n};\n\ncout &lt;&lt; matrix[0][0] &lt;&lt; endl;   // 1\ncout &lt;&lt; matrix[1][2] &lt;&lt; endl;   // 6\n\n// چاپکرنا هەمی خشتێ\nfor (int i = 0; i &lt; 3; i++) {\n    for (int j = 0; j &lt; 3; j++) {\n        cout &lt;&lt; matrix[i][j] &lt;&lt; " ";\n    }\n    cout &lt;&lt; endl;\n}</pre>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    int grid[2][2] = {{1, 2}, {3, 4}};\n    cout << grid[1][0] << endl;\n    cout << grid[0][1] << endl;\n    return 0;\n}",
'3\n2',
'لە matrix لە ڕیزی 0 و ستوونی 1 بەهاکە چاپ بکە',
'ژ matrixا د ڕیزا 0 و ستوونا 1 دا بەهایێ چاپ بکە',
'2');

$lessons[] = lesson(13, $L2SO, $L2BA,
'vector (لیستی داینامیکی)', 'vector (لیستا داینامیکی)',
<<<'SO'
<p><code>vector</code> لیستی داینامیکییە لە <bdi>C++</bdi> کە دەتوانێت گەورە و بچووک ببێت — زۆر بەسوودە لە جیاتی ئارای ئاسایی:</p>
<pre>#include &lt;vector&gt;\n\nvector&lt;int&gt; numbers;\n\nnumbers.push_back(10);   // زیادکردن بۆ کۆتایی\nnumbers.push_back(20);\nnumbers.push_back(30);\n\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 3\ncout &lt;&lt; numbers[1] &lt;&lt; endl;       // 20\n\n// سوڕانەوە بەسەر هەموویاندا\nfor (int n : numbers) {\n    cout &lt;&lt; n &lt;&lt; " ";   // 10 20 30\n}\ncout &lt;&lt; endl;\n\nnumbers.pop_back();       // سڕینەوەی کۆتایی\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 2</pre>
<p><code>push_back()</code> زیاد دەکات، <code>pop_back()</code> دەیسڕێنێتەوە، و <code>size()</code> ژمارەی ئەندامەکان دەدات.</p>
SO,
<<<'BA'
<p><code>vector</code> لیستا داینامیکی یە د <bdi>C++</bdi> دا کو دکەت مەزن و بچویک بیت — زۆر ب سوودە ل شونا ئارایێ ئاسایی:</p>
<pre>#include &lt;vector&gt;\n\nvector&lt;int&gt; numbers;\n\nnumbers.push_back(10);   // زێدەکرن بو کۆتایێ\nnumbers.push_back(20);\nnumbers.push_back(30);\n\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 3\ncout &lt;&lt; numbers[1] &lt;&lt; endl;       // 20\n\n// گەڕان ل سەر هەمیان\nfor (int n : numbers) {\n    cout &lt;&lt; n &lt;&lt; " ";   // 10 20 30\n}\ncout &lt;&lt; endl;\n\nnumbers.pop_back();       // ژێبرنا کۆتایێ\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 2</pre>
<p><code>push_back()</code> زێدە دکەت، <code>pop_back()</code> ژێ دبیت، و <code>size()</code> ژمارا ئەندامان ددەت.</p>
BA,
"#include <iostream>\n#include <vector>\nusing namespace std;\n\nint main() {\n    vector<int> v;\n    v.push_back(5);\n    v.push_back(10);\n    cout << v.size() << endl;\n    cout << v[0] + v[1] << endl;\n    return 0;\n}",
'2\n15',
'بە vector ژمارەکانی 7 و 14 زیاد بکە و کۆی ئەندامەکانی چاپ بکە',
'ب vector ژمارێن 7 و 14 زێدە بکە و کۆی ئەندامان چاپ بکە',
'2');

$lessons[] = lesson(14, $L3SO, $L3BA,
'ئاماژەکان (Pointers)', 'ئاماژە (Pointers)',
<<<'SO'
<p><strong>ئاماژە (Pointer)</strong> ناونیشانی شوێنی گۆڕاوێک لە یادگەدا هەڵدەگرێت. بە <code>*</code> دروست دەبێت و بە <code>&amp;</code> ناونیشانەکە وەردەگریت:</p>
<pre>int age = 25;\nint* ptr = &amp;age;    // ناونیشانی age لە یادگەدا\n\ncout &lt;&lt; &amp;age &lt;&lt; endl;    // ناونیشان (وەک 0x61ff08)\ncout &lt;&lt; ptr &lt;&lt; endl;     // هەمان ناونیشان\ncout &lt;&lt; *ptr &lt;&lt; endl;    // 25 - بەهای ئاماژەکراو (dereference)\n\n// گۆڕینی بەها لە ڕێگەی ئاماژەوە\n*ptr = 30;\ncout &lt;&lt; age &lt;&lt; endl;    // 30!</pre>
<p>ئاماژەکان یەکێکن لە هۆکارەکانی هێز و مەترسییەکانی <bdi>C++</bdi> — بۆ کارکردن لەگەڵ یادگە و فەنکشن بەکار دەهێنرێن.</p>
SO,
<<<'BA'
<p><strong>ئاماژە (Pointer)</strong> ناڤنییشانا شوینا گۆڕۆکەکی د بیرێ دا هەلدگریت. ب <code>*</code> دروست دبیت و ب <code>&amp;</code> ناڤنییشان هەلدگریت:</p>
<pre>int age = 25;\nint* ptr = &amp;age;    // ناڤنییشانا age د بیرێ دا\n\ncout &lt;&lt; &amp;age &lt;&lt; endl;    // ناڤنییشان (وەک 0x61ff08)\ncout &lt;&lt; ptr &lt;&lt; endl;     // هەمان ناڤنییشان\ncout &lt;&lt; *ptr &lt;&lt; endl;    // 25 - بەهایێ ئاماژەکرێ (dereference)\n\n// گۆڕینا بەهایێ ژ ڕێگا ئاماژەیێ ڤە\n*ptr = 30;\ncout &lt;&lt; age &lt;&lt; endl;    // 30!</pre>
<p>ئاماژە ئێک ژ هۆکارێن هێزا و مەترسییێن <bdi>C++</bdi> یە — بو کارکرنا ل گەل بیرێ و فەنکشنان بکارتیت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    int num = 10;\n    int* ptr = &num;\n    *ptr = 20;\n    cout << num << endl;\n    return 0;\n}",
'20',
'گۆڕاوێکی num=5 دروست بکە و بە ئاماژە بە بەهای 50 بیگۆڕە و چاپی بکە',
'گۆڕۆکەکا num=5 دروست بکە و ب ئاماژەیێ ب بەهایا 50 بگۆڕە و چاپا وی بکە',
'50');

$lessons[] = lesson(15, $L3SO, $L3BA,
'ڕێفیرانسەکان (References)', 'ڕێفیرانس (References)',
<<<'SO'
<p><strong>ڕێفیرانس (Reference)</strong> ناوی ترە بۆ گۆڕاوێک — ناوبانگێکی (alias)ە. بە <code>&amp;</code> دروست دەبێت:</p>
<pre>int score = 80;\nint&amp; ref = score;    // ref ئێستا هەمان scoreە\n\nref = 95;             // گۆڕینی بە ڕێفیرانس\ncout &lt;&lt; score &lt;&lt; endl;   // 95\n\n// فەنکشن بە ڕێفیرانس - گۆڕانکاری ڕاستەقینە!\nvoid double_it(int&amp; n) {\n    n *= 2;\n}\n\nint x = 10;\ndouble_it(x);\ncout &lt;&lt; x &lt;&lt; endl;   // 20</pre>
<p>فەرق لەگەڵ pointer: ڕێفیرانس ناتوانرێت بە گۆڕاوی تر بوەستێت و بە <code>*</code> پێویستی نییە.</p>
SO,
<<<'BA'
<p><strong>ڕێفیرانس (Reference)</strong> ناڤەکا دی یە بو گۆڕۆکەکی — ئالیاسە. ب <code>&amp;</code> دروست دبیت:</p>
<pre>int score = 80;\nint&amp; ref = score;    // ref نوکە هەمان score یە\n\nref = 95;             // گۆڕین ب ڕێفیرانسی\ncout &lt;&lt; score &lt;&lt; endl;   // 95\n\n// فەنکشن ب ڕێفیرانسی - گۆڕینا راستەقینە!\nvoid double_it(int&amp; n) {\n    n *= 2;\n}\n\nint x = 10;\ndouble_it(x);\ncout &lt;&lt; x &lt;&lt; endl;   // 20</pre>
<p>فەرق ل گەل pointer: ڕێفیرانس نەدکەت ب گۆڕۆکەکا دی ڤەستیت و ب <code>*</code> پێداویستی نینە.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nvoid addOne(int& n) {\n    n += 1;\n}\n\nint main() {\n    int x = 5;\n    addOne(x);\n    cout << x << endl;\n    return 0;\n}",
'6',
'بە ڕێفیرانس گۆڕاوێکی 7 بە 10 بگۆڕە و چاپی بکە',
'ب ڕێفیرانسی گۆڕۆکەکا 7 ب 10 بگۆڕە و چاپا وی بکە',
'10');

$lessons[] = lesson(16, $L3SO, $L3BA,
'زیادکردنی فەنکشن (Overloading)', 'زێدەکرنا فەنکشنی (Overloading)',
<<<'SO'
<p><strong>Function Overloading</strong> ڕێگەدەدات چەند فەنکشن بە هەمان ناو ببیت بە مەرجێک پارامیتەرەکانیان جیاواز بن:</p>
<pre>int add(int a, int b) {\n    return a + b;\n}\n\ndouble add(double a, double b) {\n    return a + b;\n}\n\nint add(int a, int b, int c) {\n    return a + b + c;\n}\n\nint main() {\n    cout &lt;&lt; add(2, 3) &lt;&lt; endl;          // 5\n    cout &lt;&lt; add(2.5, 3.5) &lt;&lt; endl;    // 6\n    cout &lt;&lt; add(1, 2, 3) &lt;&lt; endl;      // 6\n    return 0;\n}</pre>
<p>کۆمپایلەرەکە بەپێی جۆری و ژمارەی پارامیتەرەکان دەزانێت کام فەنکشن بەکاربهێنێت.</p>
SO,
<<<'BA'
<p><strong>Function Overloading</strong> ڕێگە ددەت چەند فەنکشن ب هەمان ناڤ بیت ب مەرجەک پارامیتەرێن وان جودا بن:</p>
<pre>int add(int a, int b) {\n    return a + b;\n}\n\ndouble add(double a, double b) {\n    return a + b;\n}\n\nint add(int a, int b, int c) {\n    return a + b + c;\n}\n\nint main() {\n    cout &lt;&lt; add(2, 3) &lt;&lt; endl;          // 5\n    cout &lt;&lt; add(2.5, 3.5) &lt;&lt; endl;    // 6\n    cout &lt;&lt; add(1, 2, 3) &lt;&lt; endl;      // 6\n    return 0;\n}</pre>
<p>کۆمپایلەر ب پێی چەشن و ژمارا پارامیتەران دزانیت کام فەنکشن بکاربینیت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint square(int x) { return x * x; }\ndouble square(double x) { return x * x; }\n\nint main() {\n    cout << square(4) << endl;\n    cout << square(2.5) << endl;\n    return 0;\n}",
'16\n6.25',
'بە overloading دوو فەنکشنی hello بنووسە: یەکەم بە یەک دەق و دووەم بە دوو دەق',
'ب overloading دوو فەنکشنێن hello بنڤیسە: ئێکەم ب ئێک دەقی و دووێ ب دوو دەقی',
'Hello\nHello Kurd');

$lessons[] = lesson(17, $L3SO, $L3BA,
'دووبارەبوونەوە (Recursion)', 'دوبارەبوون (Recursion)',
<<<'SO'
<p><strong>Recursion</strong> کاتێک فەنکشنێک خۆی بانگ دەکات. هەر فەنکشنی recursive پێویستی بە <strong>شەرتی وەستان</strong> هەیە:</p>
<pre>int factorial(int n) {\n    if (n &lt;= 1) return 1;   // شەرتی وەستان\n    return n * factorial(n - 1);\n}\n\n// factorial(5) = 5 * 4 * 3 * 2 * 1 = 120\ncout &lt;&lt; factorial(5) &lt;&lt; endl;   // 120</pre>
<p>چۆن کار دەکات:</p>
<pre>factorial(3)\n= 3 * factorial(2)\n= 3 * 2 * factorial(1)\n= 3 * 2 * 1\n= 6</pre>
<p><strong>تێبینی:</strong> بەبێ شەرتی وەستان، فەنکشنەکە هەتاهەتایە خۆی بانگ دەکات و بەرنامەکە دەکەوێت!</p>
SO,
<<<'BA'
<p><strong>Recursion</strong> دەمە فەنکشنەک خۆ بانگ دکەت. هەر فەنکشنا recursive پێداویستی ب <strong>شەرتی وەستانێ</strong> هەیە:</p>
<pre>int factorial(int n) {\n    if (n &lt;= 1) return 1;   // شەرتی وەستانێ\n    return n * factorial(n - 1);\n}\n\n// factorial(5) = 5 * 4 * 3 * 2 * 1 = 120\ncout &lt;&lt; factorial(5) &lt;&lt; endl;   // 120</pre>
<p>چاوا کار دکەت:</p>
<pre>factorial(3)\n= 3 * factorial(2)\n= 3 * 2 * factorial(1)\n= 3 * 2 * 1\n= 6</pre>
<p><strong>تێبینی:</strong> بێ شەرتی وەستانێ، فەنکشن هەتاهەتایە خۆ بانگ دکەت و بەرنامە دکەڤیت!</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint sumTo(int n) {\n    if (n <= 1) return 1;\n    return n + sumTo(n - 1);\n}\n\nint main() {\n    cout << sumTo(4) << endl;\n    return 0;\n}",
'10',
'بە recursion ژمارەکانی 1+2+3+4+5 ژمێرە (بە ناوی sumTo)',
'ب recursion ژمارێن 1+2+3+4+5 هەژمار بکە (ب ناڤێ sumTo)',
'15');

$lessons[] = lesson(18, $L3SO, $L3BA,
'بەهای پێشوەختە لە فەنکشن', 'بەهایێن پێشڤە د فەنکشنی دا',
<<<'SO'
<p>وەک Python، لە <bdi>C++</bdi> دەتوانیت بەهای پێشوەختە (default) بۆ پارامیتەرەکان دابنێیت:</p>
<pre>void greet(string name, string greeting = "Salam") {\n    cout &lt;&lt; greeting &lt;&lt; " " &lt;&lt; name &lt;&lt; endl;\n}\n\nint main() {\n    greet("Ava");               // Salam Ava\n    greet("Roj", "Bexhî");      // Bexhî Roj\n    return 0;\n}</pre>
<p><strong>گرنگ:</strong></p>
<ul>
<li>پارامیتەرە پێشوەختەکان دەبێت لە کۆتاییدا بن</li>
<li>ئەگەر بەهایەک نەدرێت، بەهای پێشوەختەکە بەکاردێت</li>
</ul>
SO,
<<<'BA'
<p>وەک Python، د <bdi>C++</bdi> دا تو دکەی بەهایێن پێشڤە (default) بو پارامیتەران دابنێی:</p>
<pre>void greet(string name, string greeting = "Salam") {\n    cout &lt;&lt; greeting &lt;&lt; " " &lt;&lt; name &lt;&lt; endl;\n}\n\nint main() {\n    greet("Ava");               // Salam Ava\n    greet("Roj", "Bexhî");      // Bexhî Roj\n    return 0;\n}</pre>
<p><strong>گرنگ:</strong></p>
<ul>
<li>پارامیتەرێن پێشڤە دڤێت د کۆتایێ دا بن</li>
<li>گەر بەهایەک نەهاتە دان، بەهایێ پێشڤە بکارتیت</li>
</ul>
BA,
"#include <iostream>\nusing namespace std;\n\nint multiply(int a, int b = 2) {\n    return a * b;\n}\n\nint main() {\n    cout << multiply(5) << endl;\n    cout << multiply(5, 3) << endl;\n    return 0;\n}",
'10\n15',
'فەنکشنێک بە default دروست بکە کە بە بێ بەهای دووەم ئەنجام بدات',
'فەنکشنەک ب default دروست بکە کو ب بێ بەهایێ دووێ ئەنجام بدەت',
'10');

$lessons[] = lesson(19, $L3SO, $L3BA,
'struct (پێکهاتە)', 'struct (پێکهاتە)',
<<<'SO'
<p><code>struct</code> ڕێگەدەدات چەند بەهای جیاواز بە یەک ناو هەڵبگریت — وەک کارتێکی زانیاری:</p>
<pre>struct Student {\n    string name;\n    int age;\n    double score;\n};\n\nint main() {\n    Student s1;\n    s1.name = "Ava";\n    s1.age = 20;\n    s1.score = 92.5;\n\n    cout &lt;&lt; s1.name &lt;&lt; endl;   // Ava\n    cout &lt;&lt; s1.age &lt;&lt; endl;    // 20\n\n    // دروستکردن لە یەک هێڵدا\n    Student s2 = {"Roj", 22, 88.0};\n    cout &lt;&lt; s2.name &lt;&lt; endl;   // Roj\n    return 0;\n}</pre>
<p>بۆ کۆمەڵێک داتای پەیوەندیدار وەک خوێندکار، کتێب یان کەلەپوور زۆر بەسوودە.</p>
SO,
<<<'BA'
<p><code>struct</code> ڕێگە ددەت چەند بەهایێن جودا ب ئێک ناڤی هەلگری — وەک کارتەکا زانیاری:</p>
<pre>struct Student {\n    string name;\n    int age;\n    double score;\n};\n\nint main() {\n    Student s1;\n    s1.name = "Ava";\n    s1.age = 20;\n    s1.score = 92.5;\n\n    cout &lt;&lt; s1.name &lt;&lt; endl;   // Ava\n    cout &lt;&lt; s1.age &lt;&lt; endl;    // 20\n\n    // دروستکرن د ئێک هێلی دا\n    Student s2 = {"Roj", 22, 88.0};\n    cout &lt;&lt; s2.name &lt;&lt; endl;   // Roj\n    return 0;\n}</pre>
<p>بو کۆمەکەکا داتایێن پەیوەندی دار وەک خوێندکار، پەرتوک یا کەلەپور زۆر ب سوودە.</p>
BA,
"#include <iostream>\n#include <string>\nusing namespace std;\n\nstruct Book {\n    string title;\n    int pages;\n};\n\nint main() {\n    Book b = {\"Kurdistan\", 200};\n    cout << b.title << endl;\n    cout << b.pages << endl;\n    return 0;\n}",
'Kurdistan\n200',
'structیەکی Car دروست بکە بە "Toyota" و 2020 و هەردووکی چاپ بکە',
'structەکا Car دروست بکە ب "Toyota" و 2020 و هەردوو چاپ بکە',
'Toyota\n2020');

$lessons[] = lesson(20, $L3SO, $L3BA,
'کلاس و ئۆبجێکت (Classes)', 'کلاس و ئۆبجێکت (Classes)',
<<<'SO'
<p><strong>کلاس (Class)</strong> شێوازێکە بۆ دروستکردنی داتا بە فەنکشنەوە — بنەمای OOP:</p>
<pre>class Car {\npublic:\n    string brand;\n    int year;\n\n    void start() {\n        cout &lt;&lt; brand &lt;&lt; " is starting..." &lt;&lt; endl;\n    }\n};\n\nint main() {\n    Car myCar;\n    myCar.brand = "Toyota";\n    myCar.year = 2024;\n\n    cout &lt;&lt; myCar.brand &lt;&lt; endl;   // Toyota\n    myCar.start();                    // Toyota is starting...\n    return 0;\n}</pre>
<p>فەرق لەگەڭ struct: کلاس دەتوانێت فەنکشن (میتۆد) و کۆنترۆلی دەستگەیشتن (public/private) تێدا بێت.</p>
SO,
<<<'BA'
<p><strong>کلاس (Class)</strong> شێوازەکە بو دروستکرنا داتایێ پێ فەنکشنان ڤە — بنگەهێ OOP:</p>
<pre>class Car {\npublic:\n    string brand;\n    int year;\n\n    void start() {\n        cout &lt;&lt; brand &lt;&lt; " is starting..." &lt;&lt; endl;\n    }\n};\n\nint main() {\n    Car myCar;\n    myCar.brand = "Toyota";\n    myCar.year = 2024;\n\n    cout &lt;&lt; myCar.brand &lt;&lt; endl;   // Toyota\n    myCar.start();                    // Toyota is starting...\n    return 0;\n}</pre>
<p>فەرق ل گەل struct: کلاس دکەت فەنکشن (میتۆد) و کۆنترۆلا دەستگەهیشتنێ (public/private) تێدا بیت.</p>
BA,
"#include <iostream>\n#include <string>\nusing namespace std;\n\nclass Dog {\npublic:\n    string name;\n    void bark() {\n        cout << name << \" says Woof!\" << endl;\n    }\n};\n\nint main() {\n    Dog d;\n    d.name = \"Rex\";\n    d.bark();\n    return 0;\n}",
'Rex says Woof!',
'کلاسێکی Animal دروست بکە بە "Cat" و میتۆدێکی sound بە "Meow"',
'کلاسەکا Animal دروست بکە ب "Cat" و میتۆدەکا sound ب "Meow"',
'Meow');

$lessons[] = lesson(21, $L3SO, $L3BA,
'کۆنستراکتەر (Constructors)', 'کۆنستراکتەر (Constructors)',
<<<'SO'
<p><strong>کۆنستراکتەر (Constructor)</strong> فەنکشنێکی تایبەتە بە هەمان ناوی کلاسەکە، کە خۆکارانە جێبەجێ دەبێت کاتێک ئۆبجێکت دروست دەکرێت:</p>
<pre>class Student {\npublic:\n    string name;\n    int age;\n\n    // کۆنستراکتەر\n    Student(string n, int a) {\n        name = n;\n        age = a;\n    }\n};\n\nint main() {\n    Student s1("Ava", 20);\n    Student s2("Roj", 22);\n\n    cout &lt;&lt; s1.name &lt;&lt; " " &lt;&lt; s1.age &lt;&lt; endl;  // Ava 20\n    cout &lt;&lt; s2.name &lt;&lt; " " &lt;&lt; s2.age &lt;&lt; endl;  // Roj 22\n    return 0;\n}</pre>
<p>کۆنستراکتەرەکە دڵنیا دەکات کە هەموو ئۆبجێکتێک بە بەهای دروست دەست پێ دەکات.</p>
SO,
<<<'BA'
<p><strong>کۆنستراکتەر (Constructor)</strong> فەنکشنەکا تایبەتە ب هەمان ناڤێ کلاسی، کو خۆکارانە جێبەجێ دبیت دەمە دروستکرنا ئۆبجێکتی:</p>
<pre>class Student {\npublic:\n    string name;\n    int age;\n\n    // کۆنستراکتەر\n    Student(string n, int a) {\n        name = n;\n        age = a;\n    }\n};\n\nint main() {\n    Student s1("Ava", 20);\n    Student s2("Roj", 22);\n\n    cout &lt;&lt; s1.name &lt;&lt; " " &lt;&lt; s1.age &lt;&lt; endl;  // Ava 20\n    cout &lt;&lt; s2.name &lt;&lt; " " &lt;&lt; s2.age &lt;&lt; endl;  // Roj 22\n    return 0;\n}</pre>
<p>کۆنستراکتەر دڵنیا دکەت کو هەمی ئۆبجێکت ب بەهایێن دروست دەست پێ دکەت.</p>
BA,
"#include <iostream>\n#include <string>\nusing namespace std;\n\nclass Person {\npublic:\n    string name;\n    Person(string n) { name = n; }\n};\n\nint main() {\n    Person p(\"Kurd\");\n    cout << p.name << endl;\n    return 0;\n}",
'Kurd',
'کلاسێک بە کۆنستراکتەر دروست بکە کە ناوی "AI" وەربگرێت و چاپی بکات',
'کلاسەکا ب کۆنستراکتەری دروست بکە کو ناڤێ "AI" هەلگریت و چاپا وی بکەت',
'AI');

$lessons[] = lesson(22, $L3SO, $L3BA,
'public و private', 'public و private',
<<<'SO'
<p>لە کلاسەکانی <bdi>C++</bdi> دەستگەیشتن بە ئەندامەکان کۆنترۆل دەکرێت:</p>
<pre>class BankAccount {\nprivate:\n    double balance;   // لە دەرەوە ناگەیت!\n\npublic:\n    BankAccount(double b) { balance = b; }\n\n    void deposit(double amount) {\n        balance += amount;\n    }\n\n    double getBalance() {\n        return balance;\n    }\n};\n\nint main() {\n    BankAccount acc(1000);\n    acc.deposit(500);\n    cout &lt;&lt; acc.getBalance() &lt;&lt; endl;   // 1500\n\n    // acc.balance = 9999;  // ERROR! privateیە\n    return 0;\n}</pre>
<p><code>private</code> ئەندامەکان لە دەرەوە دەپارێزێت — تەنها لە ڕێگەی فەنکشنەکانی ناو کلاسەکەوە دەگەیت. ئەمە پێی دەوترێت <strong>Encapsulation</strong>.</p>
SO,
<<<'BA'
<p>د کلاسێن <bdi>C++</bdi> دا دەستگەهیشتن ب ئەندامان کۆنترۆل دبیت:</p>
<pre>class BankAccount {\nprivate:\n    double balance;   // ژ دەرڤەی ناگەهی!\n\npublic:\n    BankAccount(double b) { balance = b; }\n\n    void deposit(double amount) {\n        balance += amount;\n    }\n\n    double getBalance() {\n        return balance;\n    }\n};\n\nint main() {\n    BankAccount acc(1000);\n    acc.deposit(500);\n    cout &lt;&lt; acc.getBalance() &lt;&lt; endl;   // 1500\n\n    // acc.balance = 9999;  // ERROR! private یە\n    return 0;\n}</pre>
<p><code>private</code> ئەندامان ژ دەرڤەی دپارێزیت — تەنها ژ ڕێگا فەنکشنێن ناڤ کلاسی ڤە تو دگەهی. ئەڤە پێی دبێژن <strong>Encapsulation</strong>.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nclass Counter {\nprivate:\n    int count = 0;\npublic:\n    void increment() { count++; }\n    int get() { return count; }\n};\n\nint main() {\n    Counter c;\n    c.increment();\n    c.increment();\n    cout << c.get() << endl;\n    return 0;\n}",
'2',
'کلاسێکی Counter دروست بکە، سێ جار increment بکە و ئەنجامەکەی چاپ بکە',
'کلاسەکا Counter دروست بکە، سێ جاران increment بکە و ئەنجامێ وی چاپ بکە',
'3');

$lessons[] = lesson(23, $L3SO, $L3BA,
'میرات (Inheritance) د C++', 'میراهەت (Inheritance) د C++',
<<<'SO'
<p><strong>میرات (Inheritance)</strong> کلاسێک ڕێگەدەدات تایبەتمەندییەکانی کلاسێکی تر بە میرات ببات بە <code>:</code>:</p>
<pre>class Animal {\npublic:\n    string name;\n\n    void eat() {\n        cout &lt;&lt; name &lt;&lt; " is eating" &lt;&lt; endl;\n    }\n};\n\n// Dog میراثی لە Animal دەگرێت\nclass Dog : public Animal {\npublic:\n    void bark() {\n        cout &lt;&lt; name &lt;&lt; " says Woof!" &lt;&lt; endl;\n    }\n};\n\nint main() {\n    Dog d;\n    d.name = "Rex\";\n    d.eat();    // Rex is eating (لە Animal)\n    d.bark();   // Rex says Woof! (تایبەت بە Dog)\n    return 0;\n}</pre>
<p>کلاسی منداڵ (Dog) هەموو شتێکی باوان (Animal) بە میرات دەگرێت و تایبەتمەندی خۆی زیاد دەکات.</p>
SO,
<<<'BA'
<p><strong>میراهەت (Inheritance)</strong> کلاسەک ڕێگە ددەت تایبەتمەندییێن کلاسەکا دی ب میراهەتە ببات ب <code>:</code>:</p>
<pre>class Animal {\npublic:\n    string name;\n\n    void eat() {\n        cout &lt;&lt; name &lt;&lt; " is eating" &lt;&lt; endl;\n    }\n};\n\n// Dog میراهەتا ژ Animal دگریت\nclass Dog : public Animal {\npublic:\n    void bark() {\n        cout &lt;&lt; name &lt;&lt; " says Woof!" &lt;&lt; endl;\n    }\n};\n\nint main() {\n    Dog d;\n    d.name = "Rex";\n    d.eat();    // Rex is eating (ژ Animal)\n    d.bark();   // Rex says Woof! (تایبەت ب Dog)\n    return 0;\n}</pre>
<p>کلاسا زاروو (Dog) هەمی شتێ دایک و باڤێ (Animal) ب میراهەتە دگریت و تایبەتمەندییێن خۆ زێدە دکەت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nclass Vehicle {\npublic:\n    string brand = \"Toyota\";\n};\n\nclass Car : public Vehicle {\npublic:\n    int wheels = 4;\n};\n\nint main() {\n    Car c;\n    cout << c.brand << endl;\n    cout << c.wheels << endl;\n    return 0;\n}",
'Toyota\n4',
'کلاسێکی Base بە "Kurd" و کلاسێکی Derived لێی دروست بکە و بەهایەکەی چاپ بکە',
'کلاسەکا Base ب "Kurd" و کلاسەکا Derived ژێ دروست بکە و بەهایا وی چاپ بکە',
'Kurd');

$lessons[] = lesson(24, $L3SO, $L3BA,
'enum (پێرستی بەهاکان)', 'enum (پێرستا بەهایان)',
<<<'SO'
<p><code>enum</code> کۆمەڵێک بەهای ناونراوە — بۆ ڕوونکردنەوەی کۆد زۆر بەسوودە:</p>
<pre>enum Level {\n    EASY,\n    MEDIUM,\n    HARD\n};\n\nint main() {\n    Level gameLevel = HARD;\n\n    if (gameLevel == EASY) {\n        cout &lt;&lt; "Easy mode" &lt;&lt; endl;\n    } else if (gameLevel == MEDIUM) {\n        cout &lt;&lt; "Medium mode" &lt;&lt; endl;\n    } else {\n        cout &lt;&lt; "Hard mode" &lt;&lt; endl;\n    }\n\n    cout &lt;&lt; gameLevel &lt;&lt; endl;   // 2 (ژمارەی EASY=0)\n    return 0;\n}</pre>
<p>هەر بەهایەک ژمارەیەکی وەردەگرێت: EASY=0، MEDIUM=1، HARD=2 — بەڵام بەکارهێنانی ناوەکان کۆدەکە ڕوونتر دەکات.</p>
SO,
<<<'BA'
<p><code>enum</code> کۆمەکەکا بەهایێن ناڤکرێن — بو روونکرنا کۆدی زۆر ب سوودە:</p>
<pre>enum Level {\n    EASY,\n    MEDIUM,\n    HARD\n};\n\nint main() {\n    Level gameLevel = HARD;\n\n    if (gameLevel == EASY) {\n        cout &lt;&lt; "Easy mode" &lt;&lt; endl;\n    } else if (gameLevel == MEDIUM) {\n        cout &lt;&lt; "Medium mode" &lt;&lt; endl;\n    } else {\n        cout &lt;&lt; "Hard mode" &lt;&lt; endl;\n    }\n\n    cout &lt;&lt; gameLevel &lt;&lt; endl;   // 2 (ژمارا EASY=0)\n    return 0;\n}</pre>
<p>هەر بەهایەک ژمارەیەک هەلدگریت: EASY=0، MEDIUM=1، HARD=2 — بەلێ بکارئینانا ناڤان کۆدی روونتر دکەت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nenum Color { RED, GREEN, BLUE };\n\nint main() {\n    Color c = GREEN;\n    cout << c << endl;\n    return 0;\n}",
'1',
'enumێکی Direction دروست بکە {NORTH, SOUTH} و بەهای NORTH چاپ بکە',
'enumەکا Direction دروست بکە {NORTH, SOUTH} و بەهایا NORTH چاپ بکە',
'0');

$lessons[] = lesson(25, $L3SO, $L3BA,
'const و static', 'const و static',
<<<'SO'
<p><code>const</code> بەهاکە دەگۆڕینەوە نابێت بەگۆڕ، و <code>static</code> بەهاکە دەکاتە هاوبەش لە نێوان هەموو ئۆبجێکتەکاندا:</p>
<pre>// const - بەها نەگۆڕە\nconst double PI = 3.14159;\n// PI = 3.0;  // ERROR! ناتوانیت بیگۆڕیت\n\nclass Counter {\npublic:\n    static int total;\n\n    Counter() { total++; }\n};\n\nint Counter::total = 0;   // دەستپێکردنی static\n\nint main() {\n    Counter a;\n    Counter b;\n    Counter c;\n\n    cout &lt;&lt; Counter::total &lt;&lt; endl;   // 3\n    cout &lt;&lt; PI &lt;&lt; endl;               // 3.14159\n    return 0;\n}</pre>
<p>ئەندامێکی <code>static</code> تایبەت نییە بە ئۆبجێکتێک — بۆ هەموویان هاوبەشە و بە <code>ClassName::member</code> دەگەیت.</p>
SO,
<<<'BA'
<p><code>const</code> بەها نەدگۆڕت بەگۆڕ، و <code>static</code> بەها دکەتە هاوبەش د ناڤبەرا هەمی ئۆبجێکتان دا:</p>
<pre>// const - بەها نەگۆڕە\nconst double PI = 3.14159;\n// PI = 3.0;  // ERROR! تو نەدکەی بگۆڕی\n\nclass Counter {\npublic:\n    static int total;\n\n    Counter() { total++; }\n};\n\nint Counter::total = 0;   // دەستپێکرنا static\n\nint main() {\n    Counter a;\n    Counter b;\n    Counter c;\n\n    cout &lt;&lt; Counter::total &lt;&lt; endl;   // 3\n    cout &lt;&lt; PI &lt;&lt; endl;               // 3.14159\n    return 0;\n}</pre>
<p>ئەندامەکا <code>static</code> تایبەت نینە ب ئۆبجێکتی — بو هەمیان هاوبەشە و ب <code>ClassName::member</code> تو دگەهی.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nclass Counter {\npublic:\n    static int total;\n    Counter() { total++; }\n};\nint Counter::total = 0;\n\nint main() {\n    Counter a;\n    Counter b;\n    cout << Counter::total << endl;\n    return 0;\n}",
'2',
'بە static ژمارەی ئۆبجێکتەکان ژمێرە (3 ئۆبجێکت)',
'ب static ژمارا ئۆبجێکتان هەژمار بکە (3 ئۆبجێکت)',
'3');

$lessons[] = lesson(26, $L4SO, $L4BA,
'فایلەکان (Files)', 'فایل (Files)',
<<<'SO'
<p>لە <bdi>C++</bdi> بە <code>ofstream</code> (نووسین) و <code>ifstream</code> (خوێندنەوە) کار لەگەڵ فایل دەکەیت:</p>
<pre>#include &lt;fstream&gt;\n\n// نووسین بۆ فایل\nofstream outFile("note.txt");\noutFile &lt;&lt; "Salam Kurdistan!" &lt;&lt; endl;\noutFile &lt;&lt; 2026 &lt;&lt; endl;\noutFile.close();\n\n// خوێندنەوە لە فایل\nifstream inFile("note.txt");\nstring line;\nwhile (getline(inFile, line)) {\n    cout &lt;&lt; line &lt;&lt; endl;\n}\ninFile.close();</pre>
<p><strong>گرنگ:</strong> هەمیشە فایلەکە بە <code>close()</code> ببەستەرەوە لەدوای کارکردن.</p>
SO,
<<<'BA'
<p>د <bdi>C++</bdi> دا ب <code>ofstream</code> (نڤیسین) و <code>ifstream</code> (خواندن) کار ل گەل فایلان دکی:</p>
<pre>#include &lt;fstream&gt;\n\n// نڤیسین بو فایلی\nofstream outFile("note.txt");\noutFile &lt;&lt; "Salam Kurdistan!" &lt;&lt; endl;\noutFile &lt;&lt; 2026 &lt;&lt; endl;\noutFile.close();\n\n// خواندن ژ فایلی\nifstream inFile("note.txt");\nstring line;\nwhile (getline(inFile, line)) {\n    cout &lt;&lt; line &lt;&lt; endl;\n}\ninFile.close();</pre>
<p><strong>گرنگ:</strong> هەرگیز فایل ب <code>close()</code> بستە پشتی کارکرنێ.</p>
BA,
"#include <iostream>\n#include <fstream>\n#include <string>\nusing namespace std;\n\nint main() {\n    ofstream f(\"test.txt\");\n    f << \"Hello\";\n    f.close();\n\n    ifstream r(\"test.txt\");\n    string s;\n    getline(r, s);\n    r.close();\n    cout << s << endl;\n    return 0;\n}",
'Hello',
'بە ofstream/ifstream دەقێکی "Kurd" بنووسە و بیخوێنەرەوە',
'ب ofstream/ifstream دەقەکا "Kurd" بنڤیسە و بخوینە',
'Kurd');

$lessons[] = lesson(27, $L4SO, $L4BA,
'try/catch (بەڕێوەبردنی هەڵە)', 'try/catch (بەرێڤەبرنا خەلەتی)',
<<<'SO'
<p><code>try/catch</code> هەڵەکان بەڕێوە دەبات بەبێ کەوتنی بەرنامەکە:</p>
<pre>#include &lt;stdexcept&gt;\n\ndouble divide(double a, double b) {\n    if (b == 0) {\n        throw runtime_error("Cannot divide by zero!");\n    }\n    return a / b;\n}\n\nint main() {\n    try {\n        cout &lt;&lt; divide(10, 2) &lt;&lt; endl;   // 5\n        cout &lt;&lt; divide(10, 0) &lt;&lt; endl;   // هەڵە دەکات!\n    } catch (const exception&amp; e) {\n        cout &lt;&lt; "Error: " &lt;&lt; e.what() &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p><code>throw</code> هەڵەکە دروست دەکات، <code>try</code> کۆدەکەی تاقی دەکاتەوە، و <code>catch</code> هەڵەکە وەردەگرێت.</p>
SO,
<<<'BA'
<p><code>try/catch</code> خەلەتان بەرێڤە دبات بێ کەفتنا بەرنامەی:</p>
<pre>#include &lt;stdexcept&gt;\n\ndouble divide(double a, double b) {\n    if (b == 0) {\n        throw runtime_error("Cannot divide by zero!");\n    }\n    return a / b;\n}\n\nint main() {\n    try {\n        cout &lt;&lt; divide(10, 2) &lt;&lt; endl;   // 5\n        cout &lt;&lt; divide(10, 0) &lt;&lt; endl;   // خەلەت دکەت!\n    } catch (const exception&amp; e) {\n        cout &lt;&lt; "Error: " &lt;&lt; e.what() &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p><code>throw</code> خەلەتێ دروست دکەت، <code>try</code> کۆدی تاقی دکەت، و <code>catch</code> خەلەتێ هەلدگریت.</p>
BA,
"#include <iostream>\n#include <stdexcept>\nusing namespace std;\n\nint check(int n) {\n    if (n < 0) throw runtime_error(\"Negative\");\n    return n;\n}\n\nint main() {\n    try {\n        cout << check(5) << endl;\n    } catch (const exception& e) {\n        cout << e.what() << endl;\n    }\n    return 0;\n}",
'5',
'بە try/catch هەڵەیەک بە "Error" چاپ بکە کاتێک ژمارە منفییە',
'ب try/catch خەلەتەک ب "Error" چاپ بکە دەمە ژمارە نێگەتیڤە',
'Error');

$lessons[] = lesson(28, $L4SO, $L4BA,
'templates (شابلۆن)', 'templates (شابلۆن)',
<<<'SO'
<p><strong>Template</strong> ڕێگەدەدات فەنکشن یان کلاسێک بۆ چەند جۆری داتا کاربکات بەبێ دووبارەکردنەوە:</p>
<pre>template &lt;typename T&gt;\nT max_value(T a, T b) {\n    return (a &gt; b) ? a : b;\n}\n\nint main() {\n    cout &lt;&lt; max_value(10, 20) &lt;&lt; endl;       // 20 (int)\n    cout &lt;&lt; max_value(3.5, 2.5) &lt;&lt; endl;     // 3.5 (double)\n    cout &lt;&lt; max_value(\'A\', \'B\') &lt;&lt; endl;     // B (char)\n    return 0;\n}</pre>
<p><code>T</code> جۆرە گشتییەکەیە — کۆمپایلەر بەپێی بەهایەکان جۆرەکە دەدۆزێتەوە. هەمان فەنکشن بۆ int و double و char کاردەکات!</p>
SO,
<<<'BA'
<p><strong>Template</strong> ڕێگە ددەت فەنکشن یا کلاسەک بو چەند چەشنی داتایێ کار بکەت بێ دوبارەکرنێ:</p>
<pre>template &lt;typename T&gt;\nT max_value(T a, T b) {\n    return (a &gt; b) ? a : b;\n}\n\nint main() {\n    cout &lt;&lt; max_value(10, 20) &lt;&lt; endl;       // 20 (int)\n    cout &lt;&lt; max_value(3.5, 2.5) &lt;&lt; endl;     // 3.5 (double)\n    cout &lt;&lt; max_value(\'A\', \'B\') &lt;&lt; endl;     // B (char)\n    return 0;\n}</pre>
<p><code>T</code> چەشنا گشتی یە — کۆمپایلەر ب پێی بەهایان چەشنی ددۆزیت. هەمان فەنکشن بو int و double و char کار دکەت!</p>
BA,
"#include <iostream>\nusing namespace std;\n\ntemplate <typename T>\nT smaller(T a, T b) {\n    return (a < b) ? a : b;\n}\n\nint main() {\n    cout << smaller(7, 3) << endl;\n    cout << smaller(2.5, 9.1) << endl;\n    return 0;\n}",
'3\n2.5',
'بە template فەنکشنێکی bigger بنووسە بۆ 12 و 25 کە 25 دەگەڕێنێتەوە',
'ب template فەنکشنەکا bigger بنڤیسە بو 12 و 25 کو 25 ڤەدگەڕینیت',
'25');

$lessons[] = lesson(29, $L4SO, $L4BA,
'STL: map و set', 'STL: map و set',
<<<'SO'
<p><bdi>STL</bdi> (Standard Template Library) کتێبخانەیەکی مەزنی <bdi>C++</bdi>یە بۆ داتا سترەکتەرەکان:</p>
<pre>#include &lt;map&gt;\n#include &lt;set&gt;\n\n// map - dictionary (کلیل/بەها)\nmap&lt;string, int&gt; ages;\nages["Ava"] = 20;\nages["Roj"] = 22;\n\ncout &lt;&lt; ages["Ava"] &lt;&lt; endl;   // 20\n\nfor (auto&amp; p : ages) {\n    cout &lt;&lt; p.first &lt;&lt; ": " &lt;&lt; p.second &lt;&lt; endl;\n}\n\n// set - بەها یەکجارە\nset&lt;int&gt; numbers = {3, 1, 2, 3, 1};\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 3 - دووبارەکان سڕاونەتەوە</pre>
<p>map هەمان dictionaryی Pythonە، و set وەک setی Pythonە.</p>
SO,
<<<'BA'
<p><bdi>STL</bdi> (Standard Template Library) کتێبخانەیەکا مەزنە یا <bdi>C++</bdi> یێ بو داتا سترەکتەران:</p>
<pre>#include &lt;map&gt;\n#include &lt;set&gt;\n\n// map - dictionary (کلیل/بەها)\nmap&lt;string, int&gt; ages;\nages["Ava"] = 20;\nages["Roj"] = 22;\n\ncout &lt;&lt; ages["Ava"] &lt;&lt; endl;   // 20\n\nfor (auto&amp; p : ages) {\n    cout &lt;&lt; p.first &lt;&lt; ": " &lt;&lt; p.second &lt;&lt; endl;\n}\n\n// set - بەها ئێکجارە\nset&lt;int&gt; numbers = {3, 1, 2, 3, 1};\ncout &lt;&lt; numbers.size() &lt;&lt; endl;   // 3 - دوبارە ژهاتینە ژێبرن</pre>
<p>map هەمان dictionaryا Python یە، و set ژی وەک setا Python یە.</p>
BA,
"#include <iostream>\n#include <map>\nusing namespace std;\n\nint main() {\n    map<string, int> scores;\n    scores[\"Kurd\"] = 95;\n    cout << scores[\"Kurd\"] << endl;\n    cout << scores.size() << endl;\n    return 0;\n}",
'95\n1',
'بە map بەهای "AI"=100 دابنێ و چاپی بکە',
'ب map بەهایا "AI"=100 دابنێ و چاپا وی بکە',
'100');

$lessons[] = lesson(30, $L4SO, $L4BA,
'ڕێکخستن (sort)', 'ڕێکخستن (sort)',
<<<'SO'
<p>بە <code>sort()</code> دەتوانیت لیست یان vector ڕێک بخەیت:</p>
<pre>#include &lt;algorithm&gt;\n#include &lt;vector&gt;\n\nint main() {\n    vector&lt;int&gt; numbers = {5, 2, 8, 1, 9};\n\n    // ڕێکخستن لە بچووک بۆ گەورە\n    sort(numbers.begin(), numbers.end());\n    for (int n : numbers) {\n        cout &lt;&lt; n &lt;&lt; " ";   // 1 2 5 8 9\n    }\n    cout &lt;&lt; endl;\n\n    // ڕێکخستن لە گەورە بۆ بچووک\n    sort(numbers.rbegin(), numbers.rend());\n    for (int n : numbers) {\n        cout &lt;&lt; n &lt;&lt; " ";   // 9 8 5 2 1\n    }\n    cout &lt;&lt; endl;\n    return 0;\n}</pre>
<p>بە <code>begin()</code> و <code>end()</code> سنووری vector دیاری دەکەیت. بۆ دەقەکانیش کاردەکات!</p>
SO,
<<<'BA'
<p>ب <code>sort()</code> تو دکەی لیست یا vector ڕێک خەیی:</p>
<pre>#include &lt;algorithm&gt;\n#include &lt;vector&gt;\n\nint main() {\n    vector&lt;int&gt; numbers = {5, 2, 8, 1, 9};\n\n    // ڕێکخستن ژ بچویک بۆ مەزن\n    sort(numbers.begin(), numbers.end());\n    for (int n : numbers) {\n        cout &lt;&lt; n &lt;&lt; " ";   // 1 2 5 8 9\n    }\n    cout &lt;&lt; endl;\n\n    // ڕێکخستن ژ مەزن بۆ بچویک\n    sort(numbers.rbegin(), numbers.rend());\n    for (int n : numbers) {\n        cout &lt;&lt; n &lt;&lt; " ";   // 9 8 5 2 1\n    }\n    cout &lt;&lt; endl;\n    return 0;\n}</pre>
<p>ب <code>begin()</code> و <code>end()</code> سنورا vector دیاری دکی. بو دەقان ژی کار دکەت!</p>
BA,
"#include <iostream>\n#include <algorithm>\n#include <vector>\nusing namespace std;\n\nint main() {\n    vector<int> v = {3, 1, 2};\n    sort(v.begin(), v.end());\n    for (int n : v) cout << n << \" \";\n    cout << endl;\n    return 0;\n}",
'1 2 3',
'بە sort لیستی {9,4,7} ڕێک بخە و چاپی بکە',
'ب sort لیستا {9,4,7} ڕێک خە و چاپا وی بکە',
'4 7 9');

$lessons[] = lesson(31, $L4SO, $L4BA,
'ژمارە هەڕەمەکییەکان (Random)', 'ژمارێن هەڕەمەکی (Random)',
<<<'SO'
<p>لە <bdi>C++</bdi> 11 و سەرتر بە <code>&lt;random&gt;</code> ژمارە هەڕەمەکییەکان دروست دەکەیت:</p>
<pre>#include &lt;random&gt;\n\nint main() {\n    random_device rd;\n    mt19937 gen(rd());\n    uniform_int_distribution&lt;int&gt; dist(1, 100);\n\n    // 5 ژمارەی هەڕەمەکی لە نێوان 1-100\n    for (int i = 0; i &lt; 5; i++) {\n        cout &lt;&lt; dist(gen) &lt;&lt; " ";\n    }\n    cout &lt;&lt; endl;\n    return 0;\n}</pre>
<p>بە <code>uniform_int_distribution</code> بازەی ژمارەکان دیاری دەکەیت. هەر جارێک بەرنامەکە جێبەجێ دەبێت، ژمارەی جیاواز دەردەچێت.</p>
<p>هەروەها کۆدی کۆنتر (C style): <code>rand() % 100 + 1</code></p>
SO,
<<<'BA'
<p>د <bdi>C++</bdi> 11 و سەرتر ب <code>&lt;random&gt;</code> ژمارێن هەڕەمەکی دروست دکی:</p>
<pre>#include &lt;random&gt;\n\nint main() {\n    random_device rd;\n    mt19937 gen(rd());\n    uniform_int_distribution&lt;int&gt; dist(1, 100);\n\n    // 5 ژمارە هەڕەمەکی د ناڤبەرا 1-100\n    for (int i = 0; i &lt; 5; i++) {\n        cout &lt;&lt; dist(gen) &lt;&lt; " ";\n    }\n    cout &lt;&lt; endl;\n    return 0;\n}</pre>
<p>ب <code>uniform_int_distribution</code> بازا ژماران دیاری دکی. هەر جارەکا بەرنامە جێبەجێ دبیت، ژمارەیا جودا دەردەکەڤیت.</p>
BA,
"#include <iostream>\n#include <random>\nusing namespace std;\n\nint main() {\n    random_device rd;\n    mt19937 gen(rd());\n    uniform_int_distribution<int> dist(1, 6);\n    int roll = dist(gen);\n    cout << (roll >= 1 && roll <= 6 ? \"Valid\" : \"Invalid\") << endl;\n    return 0;\n}",
'Valid',
'بە random ژمارەیەکی هەڕەمەکی لە نێوان 1-10 دروست بکە و پشکنینی بکە',
'ب random ژمارەیەکا هەڕەمەکی د ناڤبەرا 1-10 دا دروست بکە و پشکنینا وی بکە',
'Valid');

$lessons[] = lesson(32, $L4SO, $L4BA,
'فەنکشنەکانی ماتماتیک', 'فەنکشنێن ماتماتیکی',
<<<'SO'
<p>بە <code>&lt;cmath&gt;</code> چەند فەنکشنی ماتماتیکی بەسوودت دەست دەکەوێت:</p>
<pre>#include &lt;cmath&gt;\n\nint main() {\n    cout &lt;&lt; sqrt(16) &lt;&lt; endl;      // 4 - چوارگۆشە\n    cout &lt;&lt; pow(2, 3) &lt;&lt; endl;    // 8 - توان\n    cout &lt;&lt; abs(-7) &lt;&lt; endl;      // 7 - بەهای مەطلق\n    cout &lt;&lt; round(3.6) &lt;&lt; endl;   // 4 - خڕکردنەوە\n    cout &lt;&lt; ceil(3.2) &lt;&lt; endl;    // 4 - بەرزتر\n    cout &lt;&lt; floor(3.8) &lt;&lt; endl;   // 3 - نزمتر\n    cout &lt;&lt; fmax(3, 7) &lt;&lt; endl;   // 7 - گەورەترین\n    cout &lt;&lt; fmin(3, 7) &lt;&lt; endl;   // 3 - بچووکترین\n    return 0;\n}</pre>
SO,
<<<'BA'
<p>ب <code>&lt;cmath&gt;</code> چەند فەنکشنێن ماتماتیکی ب سوود دەست تە دکەڤن:</p>
<pre>#include &lt;cmath&gt;\n\nint main() {\n    cout &lt;&lt; sqrt(16) &lt;&lt; endl;      // 4 - چوارگۆشە\n    cout &lt;&lt; pow(2, 3) &lt;&lt; endl;    // 8 - هێز\n    cout &lt;&lt; abs(-7) &lt;&lt; endl;      // 7 - بەهایا مەطلق\n    cout &lt;&lt; round(3.6) &lt;&lt; endl;   // 4 - خڕکرن\n    cout &lt;&lt; ceil(3.2) &lt;&lt; endl;    // 4 - بلندتر\n    cout &lt;&lt; floor(3.8) &lt;&lt; endl;   // 3 - نزمتر\n    cout &lt;&lt; fmax(3, 7) &lt;&lt; endl;   // 7 - مەزنترین\n    cout &lt;&lt; fmin(3, 7) &lt;&lt; endl;   // 3 - بچویکترین\n    return 0;\n}</pre>
BA,
"#include <iostream>\n#include <cmath>\nusing namespace std;\n\nint main() {\n    cout << sqrt(81) << endl;\n    cout << pow(3, 2) << endl;\n    cout << abs(-10) << endl;\n    return 0;\n}",
'9\n9\n10',
'بە cmath چوارگۆشەی 64 و توانی 5³ چاپ بکە',
'ب cmath چوارگۆشەی 64 و هێزا 5³ چاپ بکە',
'8\n125');

$lessons[] = lesson(33, $L5SO, $L5BA,
'پرۆژە: کاڵکولێیتەر', 'پرۆژە: کاڵکولێیتەر',
<<<'SO'
<p>پرۆژەی یەکەم لە <bdi>C++</bdi> — کاڵکولێیتەرێکی تەواو:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\ndouble calculate(double a, double b, char op) {\n    switch (op) {\n        case \'+\': return a + b;\n        case \'-\': return a - b;\n        case \'*\': return a * b;\n        case \'/\':\n            if (b == 0) {\n                cout &lt;&lt; "Error: division by zero!" &lt;&lt; endl;\n                return 0;\n            }\n            return a / b;\n        default:\n            cout &lt;&lt; "Unknown operator" &lt;&lt; endl;\n            return 0;\n    }\n}\n\nint main() {\n    cout &lt;&lt; calculate(10, 5, \'+\') &lt;&lt; endl;   // 15\n    cout &lt;&lt; calculate(10, 5, \'-\') &lt;&lt; endl;   // 5\n    cout &lt;&lt; calculate(10, 5, \'*\') &lt;&lt; endl;   // 50\n    cout &lt;&lt; calculate(10, 5, \'/\') &lt;&lt; endl;   // 2\n    return 0;\n}</pre>
<p>ئەم پرۆژەیە فەنکشن، switch و بەڕێوەبردنی هەڵەی دابەشکردن بە سفەر تێدایە.</p>
SO,
<<<'BA'
<p>پرۆژەیا ئێکێ د <bdi>C++</bdi> دا — کاڵکولێیتەرەکا تەمام:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\ndouble calculate(double a, double b, char op) {\n    switch (op) {\n        case \'+\': return a + b;\n        case \'-\': return a - b;\n        case \'*\': return a * b;\n        case \'/\':\n            if (b == 0) {\n                cout &lt;&lt; "Error: division by zero!" &lt;&lt; endl;\n                return 0;\n            }\n            return a / b;\n        default:\n            cout &lt;&lt; "Unknown operator" &lt;&lt; endl;\n            return 0;\n    }\n}\n\nint main() {\n    cout &lt;&lt; calculate(10, 5, \'+\') &lt;&lt; endl;   // 15\n    cout &lt;&lt; calculate(10, 5, \'-\') &lt;&lt; endl;   // 5\n    cout &lt;&lt; calculate(10, 5, \'*\') &lt;&lt; endl;   // 50\n    cout &lt;&lt; calculate(10, 5, \'/\') &lt;&lt; endl;   // 2\n    return 0;\n}</pre>
<p>ئەڤ پرۆژەیا فەنکشن، switch و بەرێڤەبرنا خەلەتا پارڤەکرنا ب سفەر تێدا یە.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint calc(int a, int b, char op) {\n    if (op == '+') return a + b;\n    if (op == '-') return a - b;\n    return a * b;\n}\n\nint main() {\n    cout << calc(12, 4, '+') << endl;\n    cout << calc(12, 4, '-') << endl;\n    cout << calc(12, 4, '*') << endl;\n    return 0;\n}",
'16\n8\n48',
'بە calc ئەنجامی 20/5 و 20*5 چاپ بکە',
'ب calc ئەنجامێ 20/5 و 20*5 چاپ بکە',
"4\n100");

$lessons[] = lesson(34, $L5SO, $L5BA,
'پرۆژە: یاری گەمژاندنی ژمارە', 'پرۆژە: یاریا گومانکرنا ژمارەیێ',
<<<'SO'
<p>پرۆژەی دووەم — یارییەک کە بەکارهێنەر ژمارەیەک گەمژ دەکات:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;random&gt;\nusing namespace std;\n\nint main() {\n    random_device rd;\n    mt19937 gen(rd());\n    uniform_int_distribution&lt;int&gt; dist(1, 10);\n\n    int secret = dist(gen);\n    int guess = 5;   // نموونە: با بەکارهێنەر هەر بەهایەک بنووسێت\n\n    if (guess == secret) {\n        cout &lt;&lt; "Congratulations! You guessed it!" &lt;&lt; endl;\n    } else if (guess &lt; secret) {\n        cout &lt;&lt; "Too low! Try again." &lt;&lt; endl;\n    } else {\n        cout &lt;&lt; "Too high! Try again." &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p>بۆ یارییەکی تەواو، ئەمە لەناو خولگەی while دابنێ هەتا بەکارهێنەر ڕاستی بکات.</p>
SO,
<<<'BA'
<p>پرۆژەیا دووێ — یاریەکا کو بکارهێنەر ژمارەیەک گومان دکەت:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;random&gt;\nusing namespace std;\n\nint main() {\n    random_device rd;\n    mt19937 gen(rd());\n    uniform_int_distribution&lt;int&gt; dist(1, 10);\n\n    int secret = dist(gen);\n    int guess = 5;   // نموونە: با بکارهێنەر هەر بەهایەک بنڤیسەت\n\n    if (guess == secret) {\n        cout &lt;&lt; "Congratulations! You guessed it!" &lt;&lt; endl;\n    } else if (guess &lt; secret) {\n        cout &lt;&lt; "Too low! Try again." &lt;&lt; endl;\n    } else {\n        cout &lt;&lt; "Too high! Try again." &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p>بو یاریەکا تەمام، ئەڤە د ناڤ گەڕخستنا while دا دابنێ هەتا بکارهێنەر راستی بکەت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    int secret = 5;\n    int guess = 3;\n    if (guess == secret) {\n        cout << \"Equal\" << endl;\n    } else {\n        cout << \"Not equal\" << endl;\n    }\n    return 0;\n}",
'Not equal',
'ئەگەر guess=5 و secret=5 بێت "Equal" چاپ بکە',
'گەر guess=5 و secret=5 بیت "Equal" چاپ بکە',
'Equal');

$lessons[] = lesson(35, $L5SO, $L5BA,
'پرۆژە: تۆماری خوێندکاران', 'پرۆژە: تۆمارا خوێندکاران',
<<<'SO'
<p>پرۆژەی سێیەم — بەڕێوەبردنی تۆماری خوێندکاران بە struct و vector:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;vector&gt;\nusing namespace std;\n\nstruct Student {\n    string name;\n    int score;\n};\n\nint main() {\n    vector&lt;Student&gt; students;\n\n    students.push_back({"Ava", 95});\n    students.push_back({"Roj", 82});\n    students.push_back({"Baran", 76});\n\n    // پیشاندانی هەموو خوێندکاران\n    for (const Student&amp; s : students) {\n        cout &lt;&lt; s.name &lt;&lt; ": " &lt;&lt; s.score &lt;&lt; endl;\n    }\n\n    // بەهای تێکراویی\n    int total = 0;\n    for (const Student&amp; s : students) {\n        total += s.score;\n    }\n    double avg = (double)total / students.size();\n    cout &lt;&lt; "Average: " &lt;&lt; avg &lt;&lt; endl;   // Average: 84.3333\n    return 0;\n}</pre>
<p>struct داتاکان ڕێک دەخات، vector ئەندامان بەڕێوە دەبات، و for-each بەسەریاندا دەسوڕێتەوە.</p>
SO,
<<<'BA'
<p>پرۆژەیا سێیێ — بەرێڤەبرنا تۆمارا خوێندکاران ب struct و vector:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;vector&gt;\nusing namespace std;\n\nstruct Student {\n    string name;\n    int score;\n};\n\nint main() {\n    vector&lt;Student&gt; students;\n\n    students.push_back({"Ava", 95});\n    students.push_back({"Roj", 82});\n    students.push_back({"Baran", 76});\n\n    // نیشاندانا هەمی خوێندکاران\n    for (const Student&amp; s : students) {\n        cout &lt;&lt; s.name &lt;&lt; ": " &lt;&lt; s.score &lt;&lt; endl;\n    }\n\n    // بەهایا تێکرایی\n    int total = 0;\n    for (const Student&amp; s : students) {\n        total += s.score;\n    }\n    double avg = (double)total / students.size();\n    cout &lt;&lt; "Average: " &lt;&lt; avg &lt;&lt; endl;   // Average: 84.3333\n    return 0;\n}</pre>
<p>struct داتا ڕێک دخت، vector ئەندامان بەرێڤە دبت، و for-each ل سەر وان دگەڕیت.</p>
BA,
"#include <iostream>\n#include <vector>\nusing namespace std;\n\nstruct Student {\n    string name;\n    int score;\n};\n\nint main() {\n    vector<Student> s;\n    s.push_back({\"Ava\", 90});\n    s.push_back({\"Roj\", 80});\n    cout << s.size() << endl;\n    cout << s[0].name << endl;\n    return 0;\n}",
'2\nAva',
'بە struct و vector دوو خوێندکار زیاد بکە و ژمارەکەیان چاپ بکە',
'ب struct و vector دوو خوێندکاران زێدە بکە و ژمارا وان چاپ بکە',
'2');

$lessons[] = lesson(36, $L5SO, $L5BA,
'پرۆژە: یاری ئێکس-ئۆ (Tic-Tac-Toe)', 'پرۆژە: یاریا ئێکس-ئۆ (Tic-Tac-Toe)',
<<<'SO'
<p>پرۆژەی چوارەم — یارییە بەناوبانگەکە بە ئارای دوو ڕەهەندی:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nchar board[3][3] = {{' ', ' ', ' '}, {' ', ' ', ' '}, {' ', ' ', ' '}};\n\nvoid printBoard() {\n    for (int i = 0; i &lt; 3; i++) {\n        for (int j = 0; j &lt; 3; j++) {\n            cout &lt;&lt; board[i][j];\n            if (j &lt; 2) cout &lt;&lt; " | ";\n        }\n        cout &lt;&lt; endl;\n        if (i &lt; 2) cout &lt;&lt; "---------" &lt;&lt; endl;\n    }\n}\n\nbool checkWin(char player) {\n    // ڕیزەکان\n    for (int i = 0; i &lt; 3; i++) {\n        if (board[i][0] == player &amp;&amp; board[i][1] == player &amp;&amp; board[i][2] == player)\n            return true;\n        // ستوونەکان\n        if (board[0][i] == player &amp;&amp; board[1][i] == player &amp;&amp; board[2][i] == player)\n            return true;\n    }\n    // لارەکان (diagonals)\n    return (board[0][0] == player &amp;&amp; board[1][1] == player &amp;&amp; board[2][2] == player) ||\n           (board[0][2] == player &amp;&amp; board[1][1] == player &amp;&amp; board[2][0] == player);\n}\n\nint main() {\n    board[0][0] = \'X\';\n    board[1][1] = \'X\';\n    board[2][2] = \'X\';\n\n    printBoard();\n    cout &lt;&lt; (checkWin(\'X\') ? "X wins!" : "No winner") &lt;&lt; endl;\n    return 0;\n}</pre>
<p>ئارای دوو ڕەهەندی بۆ یارییەکانی خشتە، checkWin بۆ بەرەنگاربوونەوە و خولگەی تێکڕا بۆ چاپکردن بەکارهاتووە.</p>
SO,
<<<'BA'
<p>پرۆژەیا چارێ — یاریا ناودار ب ئارایا دوو ڕەهەندی:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nchar board[3][3] = {{' ', ' ', ' '}, {' ', ' ', ' '}, {' ', ' ', ' '}};\n\nvoid printBoard() {\n    for (int i = 0; i &lt; 3; i++) {\n        for (int j = 0; j &lt; 3; j++) {\n            cout &lt;&lt; board[i][j];\n            if (j &lt; 2) cout &lt;&lt; " | ";\n        }\n        cout &lt;&lt; endl;\n        if (i &lt; 2) cout &lt;&lt; "---------" &lt;&lt; endl;\n    }\n}\n\nbool checkWin(char player) {\n    for (int i = 0; i &lt; 3; i++) {\n        if (board[i][0] == player &amp;&amp; board[i][1] == player &amp;&amp; board[i][2] == player)\n            return true;\n        if (board[0][i] == player &amp;&amp; board[1][i] == player &amp;&amp; board[2][i] == player)\n            return true;\n    }\n    return (board[0][0] == player &amp;&amp; board[1][1] == player &amp;&amp; board[2][2] == player) ||\n           (board[0][2] == player &amp;&amp; board[1][1] == player &amp;&amp; board[2][0] == player);\n}\n\nint main() {\n    board[0][0] = \'X\';\n    board[1][1] = \'X\';\n    board[2][2] = \'X\';\n\n    printBoard();\n    cout &lt;&lt; (checkWin(\'X\') ? "X wins!" : "No winner") &lt;&lt; endl;\n    return 0;\n}</pre>
<p>ئارایا دوو ڕەهەندی بو یاریێن خشتێ، checkWin بو بەرەنگاربوونێ و گەڕخستنا تێکرا بو چاپکرنێ بکارهاتینە.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint main() {\n    char board[2][2] = {{'X', 'O'}, {'O', 'X'}};\n    cout << board[0][0] << endl;\n    cout << board[1][1] << endl;\n    return 0;\n}",
'X\nX',
'لە خشتەی 2×2 بەهای (1,0) و (0,1) چاپ بکە',
'ژ خشتا 2×2 بەهایێن (1,0) و (0,1) چاپ بکە',
'O\nO');

$lessons[] = lesson(37, $L5SO, $L5BA,
'پرۆژە: ژمارەی پالیندرۆم', 'پرۆژە: ژمارا پالیندرۆم',
<<<'SO'
<p>پرۆژەی پێنجەم — پشکنینی پالیندرۆم (وشە یان ژمارەیەک کە لە هەردوو لاوە هەمانە، وەک 121 یان "KurdruK"):</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nbool isPalindrome(int n) {\n    int original = n;\n    int reversed = 0;\n\n    while (n &gt; 0) {\n        int digit = n % 10;          // دوا پێکهاتە\n        reversed = reversed * 10 + digit;\n        n /= 10;\n    }\n    return original == reversed;\n}\n\nint main() {\n    cout &lt;&lt; isPalindrome(121) &lt;&lt; endl;   // 1 (true)\n    cout &lt;&lt; isPalindrome(123) &lt;&lt; endl;   // 0 (false)\n    cout &lt;&lt; isPalindrome(4554) &lt;&lt; endl;  // 1 (true)\n    return 0;\n}</pre>
<p>ئەم پرۆژەیە خولگەی while و کردەوەی % (ماوە) بەکاردێنێت بۆ پێچەوانەکردنەوەی ژمارەکە.</p>
SO,
<<<'BA'
<p>پرۆژەیا پێنجێ — پشکنینا پالیندرۆم (بەژە یا ژمارەکا کو ژ هەردوو لایان هەمانە، وەک 121 یا "KurdruK"):</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nbool isPalindrome(int n) {\n    int original = n;\n    int reversed = 0;\n\n    while (n &gt; 0) {\n        int digit = n % 10;          // دویاهێ پێکهاتە\n        reversed = reversed * 10 + digit;\n        n /= 10;\n    }\n    return original == reversed;\n}\n\nint main() {\n    cout &lt;&lt; isPalindrome(121) &lt;&lt; endl;   // 1 (true)\n    cout &lt;&lt; isPalindrome(123) &lt;&lt; endl;   // 0 (false)\n    cout &lt;&lt; isPalindrome(4554) &lt;&lt; endl;  // 1 (true)\n    return 0;\n}</pre>
<p>ئەڤ پرۆژەیا گەڕخستنا while و کردارا % (مایین) بکارتینیت بو پچەڤانکرنا ژمارەی.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nbool isPalindrome(int n) {\n    int original = n, reversed = 0;\n    while (n > 0) {\n        reversed = reversed * 10 + n % 10;\n        n /= 10;\n    }\n    return original == reversed;\n}\n\nint main() {\n    cout << isPalindrome(121) << endl;\n    cout << isPalindrome(123) << endl;\n    return 0;\n}",
'1\n0',
'بە فەنکشن پشکنینی 1221 و 1234 بکە (بە 1/0)',
'ب فەنکشن پشکنینا 1221 و 1234 بکە (ب 1/0)',
'1\n0');

$lessons[] = lesson(38, $L5SO, $L5BA,
'پرۆژە: هەژماری بانک', 'پرۆژە: هەژمارا بانکێ',
<<<'SO'
<p>پرۆژەی شەشەم — سیستەمی هەژماری بانک بە کلاس و private:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nclass BankAccount {\nprivate:\n    double balance;\n    string owner;\n\npublic:\n    BankAccount(string name, double initial) {\n        owner = name;\n        balance = initial;\n    }\n\n    void deposit(double amount) {\n        if (amount &gt; 0) {\n            balance += amount;\n            cout &lt;&lt; "Deposited " &lt;&lt; amount &lt;&lt; endl;\n        }\n    }\n\n    bool withdraw(double amount) {\n        if (amount &gt; 0 &amp;&amp; amount &lt;= balance) {\n            balance -= amount;\n            cout &lt;&lt; "Withdrew " &lt;&lt; amount &lt;&lt; endl;\n            return true;\n        }\n        cout &lt;&lt; "Insufficient balance!" &lt;&lt; endl;\n        return false;\n    }\n\n    void showBalance() {\n        cout &lt;&lt; owner &lt;&lt; ": " &lt;&lt; balance &lt;&lt; endl;\n    }\n};\n\nint main() {\n    BankAccount acc("Ava", 1000);\n    acc.showBalance();       // Ava: 1000\n    acc.deposit(500);        // Deposited 500\n    acc.withdraw(200);       // Withdrew 200\n    acc.showBalance();       // Ava: 1300\n    return 0;\n}</pre>
<p>بە private، بەهای balance لە دەستکاریکردنی ڕاستەوخۆ پارێزراوە — تەنها لە ڕێگەی میتۆدەوە دەگۆڕێت.</p>
SO,
<<<'BA'
<p>پرۆژەیا شەشێ — سیستەما هەژمارا بانکێ ب کلاس و private:</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\nclass BankAccount {\nprivate:\n    double balance;\n    string owner;\n\npublic:\n    BankAccount(string name, double initial) {\n        owner = name;\n        balance = initial;\n    }\n\n    void deposit(double amount) {\n        if (amount &gt; 0) {\n            balance += amount;\n            cout &lt;&lt; "Deposited " &lt;&lt; amount &lt;&lt; endl;\n        }\n    }\n\n    bool withdraw(double amount) {\n        if (amount &gt; 0 &amp;&amp; amount &lt;= balance) {\n            balance -= amount;\n            cout &lt;&lt; "Withdrew " &lt;&lt; amount &lt;&lt; endl;\n            return true;\n        }\n        cout &lt;&lt; "Insufficient balance!" &lt;&lt; endl;\n        return false;\n    }\n\n    void showBalance() {\n        cout &lt;&lt; owner &lt;&lt; ": " &lt;&lt; balance &lt;&lt; endl;\n    }\n};\n\nint main() {\n    BankAccount acc("Ava", 1000);\n    acc.showBalance();       // Ava: 1000\n    acc.deposit(500);        // Deposited 500\n    acc.withdraw(200);       // Withdrew 200\n    acc.showBalance();       // Ava: 1300\n    return 0;\n}</pre>
<p>ب private، بەهایا balance ژ دەستکاریکرنا راستەخۆ پارێزرایە — تەنها ژ ڕێگا میتۆدان ڤە دگۆڕت.</p>
BA,
"#include <iostream>\nusing namespace std;\n\nclass BankAccount {\nprivate:\n    double balance;\npublic:\n    BankAccount(double b) { balance = b; }\n    void deposit(double a) { balance += a; }\n    double getBalance() { return balance; }\n};\n\nint main() {\n    BankAccount acc(500);\n    acc.deposit(250);\n    cout << acc.getBalance() << endl;\n    return 0;\n}",
'750',
'بە کلاس هەژمارەیەک بە 1000 دروست بکە و 300 تێبخە و چاپی بکە',
'ب کلاس هەژمارەکا ب 1000 دروست بکە و 300 تێدا خە و چاپا وی بکە',
'1300');

$lessons[] = lesson(39, $L5SO, $L5BA,
'پرۆژە: فایبۆناتچی (Fibonacci)', 'پرۆژە: فایبۆناتچی (Fibonacci)',
<<<'SO'
<p>پرۆژەی حەوتەم — زنجیرەی فایبۆناتچی (هەر ژمارەیەک کۆی دوو ژمارەی پێشترە):</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\n// بە recursion\nint fib(int n) {\n    if (n &lt;= 1) return n;\n    return fib(n - 1) + fib(n - 2);\n}\n\n// بە خولگە (خێراتر)\nvoid printFib(int count) {\n    int a = 0, b = 1;\n    for (int i = 0; i &lt; count; i++) {\n        cout &lt;&lt; a &lt;&lt; " ";\n        int next = a + b;\n        a = b;\n        b = next;\n    }\n    cout &lt;&lt; endl;\n}\n\nint main() {\n    cout &lt;&lt; fib(7) &lt;&lt; endl;   // 13\n    printFib(10);              // 0 1 1 2 3 5 8 13 21 34\n    return 0;\n}</pre>
<p>زنجیرەکە: 0، 1، 1، 2، 3، 5، 8، 13، 21، 34... — لە سروشتدا زۆر دەردەکەوێت!</p>
SO,
<<<'BA'
<p>پرۆژەیا هەفتیێ — زنجیرا فایبۆناتچی (هەر ژمارەیەک کۆما دوو ژمارێن پێشترە):</p>
<pre>#include &lt;iostream&gt;\nusing namespace std;\n\n// ب recursion\nint fib(int n) {\n    if (n &lt;= 1) return n;\n    return fib(n - 1) + fib(n - 2);\n}\n\n// ب گەڕخستنێ (خێراتر)\nvoid printFib(int count) {\n    int a = 0, b = 1;\n    for (int i = 0; i &lt; count; i++) {\n        cout &lt;&lt; a &lt;&lt; " ";\n        int next = a + b;\n        a = b;\n        b = next;\n    }\n    cout &lt;&lt; endl;\n}\n\nint main() {\n    cout &lt;&lt; fib(7) &lt;&lt; endl;   // 13\n    printFib(10);              // 0 1 1 2 3 5 8 13 21 34\n    return 0;\n}</pre>
<p>زنجیرە: 0، 1، 1، 2، 3، 5، 8، 13، 21، 34... — د سروشتێ دا زۆر دەردکەڤیت!</p>
BA,
"#include <iostream>\nusing namespace std;\n\nint fib(int n) {\n    if (n <= 1) return n;\n    return fib(n - 1) + fib(n - 2);\n}\n\nint main() {\n    cout << fib(6) << endl;\n    return 0;\n}",
'8',
'بە recursion ئەندامی 8ەمی فایبۆناتچی بدۆزەرەوە (fib(8))',
'ب recursion ئەندامێ 8ێ فایبۆناتچی بدۆزەرە (fib(8))',
'21');

$lessons[] = lesson(40, $L5SO, $L5BA,
'کۆتایی کۆرس و پێداچوونەوە', 'دویاهیا کورسی و پێداچوونەڤە',
<<<'SO'
<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی <bdi>C++</bdi>. ئەوەی فێربوویت:</p>
<ul>
<li>بنەڕەتەکان: گۆڕاوەکان، داتا، cin/cout</li>
<li>مەرجەکان: if/else، switch</li>
<li>خولگەکان: for، while، do-while، تێکڕا</li>
<li>داتا سترەکتەر: ئارای، 2D array، vector</li>
<li>فەنکشن: پارامیتەر، overloading، recursion، templates</li>
<li>ئاماژە و ڕێفیرانس</li>
<li>OOP: کلاس، کۆنستراکتەر، public/private، میراث</li>
<li>فایل و try/catch</li>
<li>STL: map، set، sort</li>
<li>٨ پرۆژەی ڕاستەقینە</li>
</ul>
<p>پرۆژەی کۆتایی — ئەو هەموو شتانە تێکەڵ بکە:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;vector&gt;\n#include &lt;algorithm&gt;\nusing namespace std;\n\nstruct Student {\n    string name;\n    int score;\n};\n\nint main() {\n    vector&lt;Student&gt; students = {\n        {"Ava", 95}, {"Roj", 82}, {"Baran", 76}\n    };\n\n    // ڕێکخستن بەپێی نمرە\n    sort(students.begin(), students.end(),\n         [](const Student&amp; a, const Student&amp; b) {\n             return a.score &gt; b.score;\n         });\n\n    for (const Student&amp; s : students) {\n        cout &lt;&lt; s.name &lt;&lt; ": " &lt;&lt; s.score &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p>ئێستا بەڕێ بکەوە بۆ زمانەکانی تر لە فێرگە، و خاڵەکانی XP خۆت کۆبکەرەوە!</p>
SO,
<<<'BA'
<p>ئافەرم! گەهیشتی دویاهیا کورسی <bdi>C++</bdi>. ئەوێ کو فێربوی:</p>
<ul>
<li>بنگەه: گۆڕۆک، داتا، cin/cout</li>
<li>مەرج: if/else، switch</li>
<li>گەڕخستن: for، while، do-while، تێکرا</li>
<li>داتا سترەکتەر: ئارای، 2D array، vector</li>
<li>فەنکشن: پارامیتەر، overloading، recursion، templates</li>
<li>ئاماژە و ڕێفیرانس</li>
<li>OOP: کلاس، کۆنستراکتەر، public/private، میراهەت</li>
<li>فایل و try/catch</li>
<li>STL: map، set، sort</li>
<li>٨ پرۆژە ڕاستەقینە</li>
</ul>
<p>پرۆژەیا کۆتایی — هەمی ئەو شتێن تێکەل بکە:</p>
<pre>#include &lt;iostream&gt;\n#include &lt;vector&gt;\n#include &lt;algorithm&gt;\nusing namespace std;\n\nstruct Student {\n    string name;\n    int score;\n};\n\nint main() {\n    vector&lt;Student&gt; students = {\n        {"Ava", 95}, {"Roj", 82}, {"Baran", 76}\n    };\n\n    // ڕێکخستن ب پێی نمرێ\n    sort(students.begin(), students.end(),\n         [](const Student&amp; a, const Student&amp; b) {\n             return a.score &gt; b.score;\n         });\n\n    for (const Student&amp; s : students) {\n        cout &lt;&lt; s.name &lt;&lt; ": " &lt;&lt; s.score &lt;&lt; endl;\n    }\n    return 0;\n}</pre>
<p>ئێستا بەرێ بکەوە بو زمانێن دی د فێرگەی دا، و خالێن XP یێن خۆ کۆ بکە!</p>
BA,
"#include <iostream>\n#include <vector>\n#include <algorithm>\nusing namespace std;\n\nint main() {\n    vector<int> scores = {82, 95, 76};\n    sort(scores.begin(), scores.end(), greater<int>());\n    for (int s : scores) cout << s << \" \";\n    cout << endl;\n    return 0;\n}",
'95 82 76',
'بە sort نمرەکانی {70,90,80} ڕێک بخە لە گەورە بۆ بچووک',
'ب sort نمرێن {70,90,80} ڕێک خە ژ مەزن بۆ بچویک',
'90 80 70');

echo "Adding " . count($lessons) . " more C++ lessons...\n";
foreach ($lessons as $lesson) {
    $lesson['langId'] = $cppLangId;
    $res = fbPost($firebaseUrl . 'ferga_lessons.json', $lesson);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo "Added: " . $lesson['order'] . ". " . $lesson['title_so'] . "\n";
    } else {
        echo "ERROR " . $lesson['order'] . ": $res\n";
        exit(1);
    }
}
echo "Done! " . count($lessons) . " more C++ lessons added (total C++ = 40).\n";
