<?php

// Script to add Rust lessons (1-8) to the Ferga section in Firebase.
// Language already exists as -OysGzfS5Qi08XHYs_FL; we just post lessons and unlock it.
if (!defined('FERGA_SEED_LIB')) {
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-OysGzfS5Qi08XHYs_FL';

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

// Rust language already exists; just unlock it.
fbPatch($firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
echo "Language Rust unlocked.\n";

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
        'title_so' => 'چییە Rust؟',
        'title_ba' => 'چ یە Rust؟',
        'content_so' => '<p><strong>Rust</strong> زمانێکی نوێ و پارێزراوە کە بە ناوبەنگی خێرایی و سەلامەتی ناسراوە. لەلایەن Mozilla دروستکراوە و بۆ سیستەم، وێب و سەکۆی خزمەتگوزاری بەکاردێت.</p><p>بەرنامەیەکی سادەی Rust:</p><pre>fn main() {\n    println!("Hello from Rust!");\n}</pre><p><code>fn main()</code> خاڵی دەستپێکە و <code>println!</code> ماکرۆیەکە بۆ چاپکردن. تایبەتمەندی سەرەکی Rust: <strong>بێ ترسی هەڵە لە یادگەدا</strong> — هەڵەکان لە کاتی کۆکردنەوەدا دەردەکەون، نەک لە کاتی کارکردندا.</p>',
        'content_ba' => '<p><strong>Rust</strong> زمانەکەکا نوی و پاراستییە کو ب ناڤناڤا خێرایی و ئەمنییێ ناساییە. ژ لایەن Mozilla هاتییە دروستکرن و بو سیستەم، وێب و سەکۆی خزمەتگوزاری بکارتیت.</p><p>بەرنامەیەکا سادە یا Rust:</p><pre>fn main() {\n    println!("Hello from Rust!");\n}</pre><p><code>fn main()</code> خالێ دەستپێکێ یە و <code>println!</code> ماکرۆیەکە بو چاپکرنێ. تایبەتمەندی سەرەکی Rust: <strong>بێ ترسا خەلەتی د بیرێ دا</strong> — خەلەت د دەمە کومکرنێ دا دەردکەڤن، نەک د دەمە کارکرنێ دا.</p>',
        'code' => 'fn main() {
    println!("Hello from Rust!");
}',
        'example_output' => 'Hello from Rust!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کام ماکرۆ دەق چاپ دەکات لە Rust؟',
        'quiz_question_ba' => 'کا ماکرۆ نڤیسین چاپ دکەت د Rust دا؟',
        'quiz_options_so' => ['println!', 'echo', 'console.log', 'print'],
        'quiz_options_ba' => ['println!', 'echo', 'console.log', 'print'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'گۆڕاوەکان (let / mut)',
        'title_ba' => 'گۆڕۆک (let / mut)',
        'content_so' => '<p>گۆڕاوەکانی Rust بە <code>let</code> دروست دەکرێن و بە بنەڕەتدا <strong>نەگۆڕن</strong>:</p><pre>let x = 5;        // نەگۆڕە — ناتوانیت بیگۆڕیت\nlet mut y = 10;   // گۆڕاوە — دەتوانیت بیگۆڕیت\ny = 20;           // دروستە\n\n// Shadowing - ناوی دووبارە بەکارهێنانەوە\nlet x = x + 1;    // x ئێستا 6</pre><p>جیاوازی <code>let</code> و <code>const</code>: <code>const</code> بە بەهایەکی دیاریکراو لە کاتی کۆکردنەوەدا. گۆڕاوەکان بە بنەڕەت نەگۆڕن چونکە Rust سەلامەتی دەخاتە پێشەوە.</p>',
        'content_ba' => '<p>گۆڕۆکێن Rust پێ <code>let</code> دروست دبن و ب بنگەهێ <strong>نەگۆڕن</strong>:</p><pre>let x = 5;        // نەگۆڕە — نەدکەی بگۆڕی\nlet mut y = 10;   // گۆڕۆکە — دکەی بگۆڕی\ny = 20;           // دروستە\n\n// Shadowing - بکارهینانا ناڤی دوبارە\nlet x = x + 1;    // x ئێستا 6</pre><p>فەرقا <code>let</code> و <code>const</code>: <code>const</code> پێ بەهایەکا دیاریکراوی د دەمە کومکرنێ دا. گۆڕۆک ب بنگەهێ نەگۆڕن چونکی Rust ئەمنییێ دخاتە پێشەوە.</p>',
        'code' => 'fn main() {
    let x = 5;
    let mut y = 10;

    y = 20;

    let x = x + 1;

    println!("x = {}", x);
    println!("y = {}", y);
}',
        'example_output' => 'x = 6
y = 20',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە کۆدی سەرەوە، بەهای "y" دەبێتە چەند؟',
        'quiz_question_ba' => 'د کۆدی جۆر دا، بەهایا "y" دبیتە چەند؟',
        'quiz_options_so' => ['20', '10', '6', '30'],
        'quiz_options_ba' => ['20', '10', '6', '30'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'جۆرەکانی داتا',
        'title_ba' => 'چەشنێن داتایێ',
        'content_so' => '<p>Rust جۆری بەهێزی داتای هەیە — هەموو بەها جۆرێکی دیاریکراوە:</p><pre>let a: i32 = 5;         // تەواوی نیشانەدار\nlet b: u32 = 5;         // تەواوی بێ نیشانە\nlet c: f64 = 3.14;      // لۆیی\nlet d: bool = true;     // ڕاست یان هەڵە\nlet e: char = \'K\';       // پیتێک\n\nlet tup = (10, "Kurd", 3.5);   // Tuple\nlet arr = [1, 2, 3, 4];        // ئارای</pre><p>جۆری <code>i32</code> بە بنەڕەتە بۆ تەواو و <code>f64</code> بۆ لۆیی. Rust هەڵەی جۆرەکان لە کاتی کۆکردنەوەدا دەدۆزێتەوە — پێش کارکردن.</p>',
        'content_ba' => '<p>Rust چەشنێ بهێز یا داتایێ یە — هەمی بەها چەشنەکا دیاریکراوە:</p><pre>let a: i32 = 5;         // تەمام نیشانەدار\nlet b: u32 = 5;         // تەمام بێ نیشانە\nlet c: f64 = 3.14;      // لۆیی\nlet d: bool = true;     // راست یا خەلەت\nlet e: char = \'K\';       // پیتەک\n\nlet tup = (10, "Kurd", 3.5);   // Tuple\nlet arr = [1, 2, 3, 4];        // ئارای</pre><p>چەشنێ <code>i32</code> ب بنگەهێ یە بو تەمام و <code>f64</code> بو لۆیی. Rust خەلەتێن چەشنان د دەمە کومکرنێ دا ددیت — بەری کارکرنێ.</p>',
        'code' => 'fn main() {
    let a: i32 = 5;
    let c: f64 = 3.14;
    let e: char = \'K\';

    println!("a = {}", a);
    println!("c = {}", c);
    println!("e = {}", e);
}',
        'example_output' => 'a = 5
c = 3.14
e = K',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'جۆری 3.14 لە Rust چییە؟',
        'quiz_question_ba' => 'چەشنێ 3.14 د Rust دا چ یە؟',
        'quiz_options_so' => ['f64', 'i32', 'char', 'bool'],
        'quiz_options_ba' => ['f64', 'i32', 'char', 'bool'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>مەرجەکانی Rust وەک زمانەکانی ترن، بەڵام مەرجەکە دەبێت <code>bool</code> بێت:</p><pre>let score = 85;\n\nif score &gt;= 50 {\n    println!("Bêşar!");\n} else {\n    println!("Caw!");\n}\n\n// مەرج وەک expression — بەها دەگەڕێنێتەوە\nlet grade = if score &gt;= 90 { "A" } else { "B" };</pre><p>تایبەتمەندی Rust: <code>if</code> دەتوانێت بەها بگەڕێنێتەوە وەک <code>expression</code> — ئەمەش کۆد سادەتر دەکات.</p>',
        'content_ba' => '<p>مەرجێن Rust وەک زمانێن دین، بەلێ مەرج دڤێت <code>bool</code> بیت:</p><pre>let score = 85;\n\nif score &gt;= 50 {\n    println!("Bêşar!");\n} else {\n    println!("Caw!");\n}\n\n// مەرج وەک expression — بەها ڤەدگەڕیت\nlet grade = if score &gt;= 90 { "A" } else { "B" };</pre><p>تایبەتمەندی Rust: <code>if</code> دکەی بەها ڤەگەڕیت وەک <code>expression</code> — ئەڤ کۆد سادەتر دکەت.</p>',
        'code' => 'fn main() {
    let score = 85;

    if score >= 50 {
        println!("Bêşar!");
    } else {
        println!("Caw!");
    }
}',
        'example_output' => 'Bêşar!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە کۆدی سەرەوە، ئەگەر score=40 بووایە چی چاپ دەکرا؟',
        'quiz_question_ba' => 'د کۆدی جۆر دا، گەر score=40 بیت چ چاپ دبیت؟',
        'quiz_options_so' => ['Caw!', 'Bêşar!', '40', 'Score'],
        'quiz_options_ba' => ['Caw!', 'Bêşar!', '40', 'Score'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 5,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەکان (Loops)',
        'title_ba' => 'گەڕخستن (Loops)',
        'content_so' => '<p>Rust سێ جۆر خولگەی هەیە: <code>loop</code>، <code>while</code> و <code>for</code>:</p><pre>// loop - هەمیشە، هەتا break\nlet mut i = 0;\nloop {\n    i += 1;\n    if i &gt;= 3 { break; }\n}\n\n// while - مەرجەکە ڕاستە\nlet mut j = 0;\nwhile j &lt; 3 {\n    j += 1;\n}\n\n// for - بەسەر مەودایەکدا\nfor n in 1..=5 {\n    println!("{}", n);\n}</pre><p><code>1..=5</code> لە ١ بۆ ٥ و <code>1..5</code> لە ١ بۆ ٤. خولگەی <code>for</code> لە Rust زۆر خێرایە.</p>',
        'content_ba' => '<p>Rust سێ چەشن گەڕخستنێ هەن: <code>loop</code>، <code>while</code> و <code>for</code>:</p><pre>// loop - هەردیم، هەتا break\nlet mut i = 0;\nloop {\n    i += 1;\n    if i &gt;= 3 { break; }\n}\n\n// while - مەرج راستە\nlet mut j = 0;\nwhile j &lt; 3 {\n    j += 1;\n}\n\n// for - بسەر مەودایەکێ دا\nfor n in 1..=5 {\n    println!("{}", n);\n}</pre><p><code>1..=5</code> ژ ١ هەتا ٥ و <code>1..5</code> ژ ١ هەتا ٤. گەڕخستنا <code>for</code> د Rust دا زۆر خێرایە.</p>',
        'code' => 'fn main() {
    for n in 1..=5 {
        println!("{}", n);
    }
}',
        'example_output' => '1
2
3
4
5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'خولگەی for n in 1..=5 چەند جار تکرار دەبێتەوە؟',
        'quiz_question_ba' => 'گەڕخستنا for n in 1..=5 چەند جاران دوبارە دبیت؟',
        'quiz_options_so' => ['5 جار', '4 جار', '6 جار', '3 جار'],
        'quiz_options_ba' => ['5 جاران', '4 جاران', '6 جاران', '3 جاران'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکان (Functions)',
        'title_ba' => 'فەنکشن (Functions)',
        'content_so' => '<p>فەنکشن لە Rust بە <code>fn</code> دروست دەکرێت. جۆری پێکهاتەکان و جۆری گەڕانەوە دیاری دەکرێت:</p><pre>fn add(a: i32, b: i32) -&gt; i32 {\n    a + b   // گەڕانەوە بەبێ return\n}\n\nfn say_hello() {\n    println!("Hello!");\n}\n\nfn main() {\n    let sum = add(5, 3);\n    println!("Sum = {}", sum);  // Sum = 8\n}</pre><p>تایبەتمەندی Rust: دوایین دەربڕین بەبێ <code>return</code> و بەبێ <code>;</code> بەها دەگەڕێنێتەوە — پێی دەگوترێت <code>expression</code>.</p>',
        'content_ba' => '<p>فەنکشن د Rust دا پێ <code>fn</code> دروست دبیت. چەشنا پارامەتران و چەشنا ڤەگەڕاندنێ دیاری دبیت:</p><pre>fn add(a: i32, b: i32) -&gt; i32 {\n    a + b   // ڤەگەڕان بێ return\n}\n\nfn say_hello() {\n    println!("Hello!");\n}\n\nfn main() {\n    let sum = add(5, 3);\n    println!("Sum = {}", sum);  // Sum = 8\n}</pre><p>تایبەتمەندی Rust: دەربڕینا دوویان بێ <code>return</code> و بێ <code>;</code> بەها ڤەدگەڕیت — پێ دبێژن <code>expression</code>.</p>',
        'code' => 'fn add(a: i32, b: i32) -> i32 {
    a + b
}

fn main() {
    let sum = add(5, 3);
    println!("Sum = {}", sum);
}',
        'example_output' => 'Sum = 8',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی add(6, 7) دەبێتە چەند؟',
        'quiz_question_ba' => 'دەرئەنجامێ add(6, 7) دبیتە چەند؟',
        'quiz_options_so' => ['13', '42', '67', '14'],
        'quiz_options_ba' => ['13', '42', '67', '14'],
        'quiz_correct' => '1',
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەقەکان (String & &str)',
        'title_ba' => 'نڤیسین (String & &str)',
        'content_so' => '<p>Rust دوو جۆری دەقی هەیە: <code>String</code> (گۆڕاو، لەسەر هێپ) و <code>&amp;str</code> (نەگۆڕ، بەشێک لە کۆد):</p><pre>let s1 = String::from("Kurd");\nlet s2 = "Kurd";          // &amp;str\n\nlet mut msg = String::from("Salam");\nmsg.push_str(", Kurd!");  // زیادکردن\nmsg.len();                // ژمارەی بایتەکان\ns1.to_uppercase();        // KURD\ns2.contains("ur");        // true</pre><p><code>&amp;</code> بەها دەبات بە نیشانەوە بەبێ کۆپیکردن — ئەمەش Rust بە خێرایی ناساندووە. بە <code>{}</code> بەها لە <code>println!</code>دا دەخەیت.</p>',
        'content_ba' => '<p>Rust دوو چەشن نڤیسینێ هەن: <code>String</code> (گۆڕۆک، ل سەر هێپ) و <code>&amp;str</code> (نەگۆڕ، بەشەک ژ کۆدی):</p><pre>let s1 = String::from("Kurd");\nlet s2 = "Kurd";          // &amp;str\n\nlet mut msg = String::from("Salam");\nmsg.push_str(", Kurd!");  // زێدەکرن\nmsg.len();                // ژمارا بایتان\ns1.to_uppercase();        // KURD\ns2.contains("ur");        // true</pre><p><code>&amp;</code> بەها دبەت ب نیشانەڤە بێ کۆپیکرنێ — ئەڤ Rust ب خێرایی ناساندییە. پێ <code>{}</code> بەها د <code>println!</code> دا دخی.</p>',
        'code' => 'fn main() {
    let s1 = String::from("Kurd");
    let s2 = "Salam";

    println!("{}, {}!", s2, s1);
    println!("Upper: {}", s1.to_uppercase());
}',
        'example_output' => 'Salam, Kurd!
Upper: KURD',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ژمارەی پیتەکانی "Kurdistan" چەندە؟',
        'quiz_question_ba' => 'ژمارا پیتێن "Kurdistan" چەندە؟',
        'quiz_options_so' => ['9', '8', '10', '7'],
        'quiz_options_ba' => ['9', '8', '10', '7'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 8,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Struct و ئۆبجێکت',
        'title_ba' => 'Struct و ئۆبجێکت',
        'content_so' => '<p><code>struct</code> داتایەکی پێکهاتوو دروست دەکات — وەک ئۆبجێکت لە زمانەکانی تر:</p><pre>struct Student {\n    name: String,\n    grade: i32,\n}\n\nimpl Student {\n    fn show(&amp;self) {\n        println!("{}: {}", self.name, self.grade);\n    }\n}\n\nfn main() {\n    let s = Student {\n        name: String::from("Ava"),\n        grade: 95,\n    };\n    s.show();   // Ava: 95\n}</pre><p>بە <code>impl</code> فەنکشن (methods) بۆ struct دەنووسیت. <code>&amp;self</code> نیشانەی خودی struct ئەکە — بەبێ ئەو کۆپی دەکرا.</p>',
        'content_ba' => '<p><code>struct</code> داتایەکا پێکهاتی دروست دکەت — وەک ئۆبجێکت د زمانێن دیان دا:</p><pre>struct Student {\n    name: String,\n    grade: i32,\n}\n\nimpl Student {\n    fn show(&amp;self) {\n        println!("{}: {}", self.name, self.grade);\n    }\n}\n\nfn main() {\n    let s = Student {\n        name: String::from("Ava"),\n        grade: 95,\n    };\n    s.show();   // Ava: 95\n}</pre><p>پێ <code>impl</code> فەنکشن (methods) بو struct دینڤیسی. <code>&amp;self</code> نیشانا خودێ struct یە — بێ وی کۆپی ددیت.</p>',
        'code' => 'struct Student {
    name: String,
    grade: i32,
}

impl Student {
    fn show(&self) {
        println!("{}: {}", self.name, self.grade);
    }
}

fn main() {
    let s = Student {
        name: String::from("Ava"),
        grade: 95,
    };
    s.show();
}',
        'example_output' => 'Ava: 95',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کام وشە فەنکشن بۆ struct زیاد دەکەیت؟',
        'quiz_question_ba' => 'پێ کا پەیا فەنکشن بو struct زێدە دکەی؟',
        'quiz_options_so' => ['impl', 'class', 'method', 'struct fn'],
        'quiz_options_ba' => ['impl', 'class', 'method', 'struct fn'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 9,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئەوپەریتۆرەکانی ژمێر (Arithmetic)',
        'title_ba' => 'ئەوپەریتۆرێن ژمێر (Arithmetic)',
        'content_so' => '<p>ئەوپەریتۆرەکانی ژمێر بۆ هەژمارکردنن: <code>+</code> کۆکردنەوە، <code>-</code> کەمکردنەوە، <code>*</code> لێکدان، <code>/</code> دابەشکردن و <code>%</code> ماوە:</p><pre>let a = 10;\nlet b = 3;\n\nprintln!("{}", a + b);   // 13\nprintln!("{}", a / b);   // 3\nprintln!("{}", a % b);   // 1</pre><p>کاتێک هەردوو بەها <code>i32</code> بن، <code>/</code> دابەشکردنی تەواو دەکات. بۆ ئەنجامی لۆیی دەبێت بەهایەک ببێتە <code>f64</code> وەک <code>10.0 / 3</code>.</p>',
        'content_ba' => '<p>ئەوپەریتۆرێن ژمێر بو هەژمارکرنێ ن: <code>+</code> کۆکرن، <code>-</code> کێمکرن، <code>*</code> زێدەکرن، <code>/</code> پارڤەکرن و <code>%</code> ماوە:</p><pre>let a = 10;\nlet b = 3;\n\nprintln!("{}", a + b);   // 13\nprintln!("{}", a / b);   // 3\nprintln!("{}", a % b);   // 1</pre><p>دەمەکێ هر دو بەها <code>i32</code> بن، <code>/</code> پارڤەکرنەکا تەمام دکەت. بو دەرئەنجامەکا لۆیی دڤێت بەهایەک بیت <code>f64</code> وەک <code>10.0 / 3</code>.</p>',
        'code' => 'fn main() {
    let a = 10;
    let b = 3;

    println!("{} + {} = {}", a, b, a + b);
    println!("{} - {} = {}", a, b, a - b);
    println!("{} * {} = {}", a, b, a * b);
    println!("{} / {} = {}", a, b, a / b);
    println!("{} % {} = {}", a, b, a % b);
}',
        'example_output' => '10 + 3 = 13
10 - 3 = 7
10 * 3 = 30
10 / 3 = 3
10 % 3 = 1',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی 17 % 5 چەندە؟',
        'quiz_question_ba' => 'دەرئەنجامێ 17 % 5 چەندە؟',
        'quiz_options_so' => ['2', '3', '12', '22'],
        'quiz_options_ba' => ['2', '3', '12', '22'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 10,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'Tupleەکان',
        'title_ba' => 'Tuple',
        'content_so' => '<p><code>tuple</code> کۆمەڵێک بەها لە ناو پەڕانتێزە و دەتوانێت جۆری جیاوازی تێدا بێت:</p><pre>let tup = (42, "Kurd", 3.5);\n\nprintln!("{}", tup.0);   // 42\nprintln!("{}", tup.1);   // Kurd</pre><p>بە <code>destructuring</code> دەتوانیت ئەندامەکان بکەیتە گۆڕاو:</p><pre>let (a, b, c) = tup;</pre><p>ئەندامەکان بە <code>tup.0</code>، <code>tup.1</code>... دەگەیت، نەک <code>tup[0]</code>.</p>',
        'content_ba' => '<p><code>tuple</code> کۆمەلەکا بەهایان د ناڤ پارانتێزێ دا یە و دکەی چەشنا جیاواز تێدا بیت:</p><pre>let tup = (42, "Kurd", 3.5);\n\nprintln!("{}", tup.0);   // 42\nprintln!("{}", tup.1);   // Kurd</pre><p>پێ <code>destructuring</code> دکەی ئەندامان بکەی گۆڕۆک:</p><pre>let (a, b, c) = tup;</pre><p>ئەندام ب <code>tup.0</code>، <code>tup.1</code>... ڤە دگههیت، نەک <code>tup[0]</code>.</p>',
        'code' => 'fn main() {
    let tup = (42, "Kurd", 3.5);

    println!("{}", tup.0);
    println!("{}", tup.1);
    println!("{}", tup.2);

    let (a, b, c) = tup;
    println!("{}, {}, {}", a, b, c);
}',
        'example_output' => '42
Kurd
3.5
42, Kurd, 3.5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە بۆ دەستگەیشتن بە یەکەم ئەندامی tuple بەکار دێت؟',
        'quiz_question_ba' => 'کا بۆ دگەهشتنا یەکەم ئەندامێ tuple بکارتیت؟',
        'quiz_options_so' => ['tup.0', 'tup[0]', 'tup->0', 'tup.one'],
        'quiz_options_ba' => ['tup.0', 'tup[0]', 'tup->0', 'tup.one'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 11,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارایەکان (Arrays)',
        'title_ba' => 'ئارای (Arrays)',
        'content_so' => '<p>ئارای (array) کۆمەڵێک بەهای هەمان جۆرە بە قەبارەی دیاریکراو. لە <code>Vec</code> جیاوازە چونکە قەبارەکەی ناگۆڕێت:</p><pre>let arr = [10, 20, 30, 40, 50];\nlet zeros = [0; 5];       // [0, 0, 0, 0, 0]\n\nprintln!("{}", arr[0]);    // 10\nprintln!("{}", arr.len()); // 5</pre><p>ژمارەدانەوە لە <code>0</code> دەست پێدەکات. ئەگەر بچیتە دەرەوەی سنوور، Rust هەڵە دەدات.</p>',
        'content_ba' => '<p>ئارای (array) کۆمەلەکا بەهایێن هەمان چەشنی ب قەبارەکا دیاریکراوی یە. ژ <code>Vec</code> جودا یە چونکی قەبارە ناگۆڕیت:</p><pre>let arr = [10, 20, 30, 40, 50];\nlet zeros = [0; 5];       // [0, 0, 0, 0, 0]\n\nprintln!("{}", arr[0]);    // 10\nprintln!("{}", arr.len()); // 5</pre><p>ژماردانان ژ <code>0</code> دەست پێدکەت. گەر بچی دەرڤە سنوور، Rust خەلەت ددەت.</p>',
        'code' => 'fn main() {
    let arr = [10, 20, 30, 40, 50];

    println!("yekem: {}", arr[0]);
    println!("siyem: {}", arr[3]);
    println!("hejmara endaman: {}", arr.len());
}',
        'example_output' => 'yekem: 10
siyem: 40
hejmara endaman: 5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بەهای arr[2] چەندە ئەگەر arr = [10, 20, 30, 40]؟',
        'quiz_question_ba' => 'بەهایا arr[2] چەندە گەر arr = [10, 20, 30, 40]؟',
        'quiz_options_so' => ['30', '20', '40', '10'],
        'quiz_options_ba' => ['30', '20', '40', '10'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 12,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'زنجیرەی مەرج (else if)',
        'title_ba' => 'زنجیرا مەرج (else if)',
        'content_so' => '<p>کاتێک چەند مەرجێکت هەیە، زنجیرەی <code>else if</code> بەکاربهێنە. تەنها یەکەم مەرجی ڕاست جێبەجێ دەبێت:</p><pre>let score = 85;\n\nif score &gt;= 90 {\n    println!("A");\n} else if score &gt;= 80 {\n    println!("B");\n} else if score &gt;= 70 {\n    println!("C");\n} else {\n    println!("F");\n}</pre><p>لێرەدا 85 دەکەوێتە شاخەی <code>score &gt;= 80</code> بۆیە چاپ دەکرێت <code>B</code>.</p>',
        'content_ba' => '<p>دەمەکێ چەند مەرجێک هەبن، زنجیرا <code>else if</code> بکاربینە. تەنێ یەکەم مەرجا راست جێبەجێ دبیت:</p><pre>let score = 85;\n\nif score &gt;= 90 {\n    println!("A");\n} else if score &gt;= 80 {\n    println!("B");\n} else if score &gt;= 70 {\n    println!("C");\n} else {\n    println!("F");\n}</pre><p>ڤێرە 85 دکەڤیتە شاخا <code>score &gt;= 80</code> بو وی چاپ دبیت <code>B</code>.</p>',
        'code' => 'fn main() {
    let score = 85;

    if score >= 90 {
        println!("A");
    } else if score >= 80 {
        println!("B");
    } else if score >= 70 {
        println!("C");
    } else {
        println!("F");
    }
}',
        'example_output' => 'B',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەگەر score = 75 بووایە، چی چاپ دەکرا؟',
        'quiz_question_ba' => 'گەر score = 75 بیت، چ چاپ دبیت؟',
        'quiz_options_so' => ['C', 'B', 'A', 'F'],
        'quiz_options_ba' => ['C', 'B', 'A', 'F'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 13,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی while',
        'title_ba' => 'گەڕخستنا while',
        'content_so' => '<p>خولگەی <code>while</code> دەسوڕێتەوە هەتا مەرجەکە ڕاستە. دەبێت ژمارەرەکە <code>mut</code> بێت:</p><pre>let mut n = 1;\n\nwhile n &lt;= 5 {\n    println!("{}", n);\n    n += 1;\n}</pre><p>ئەگەر مەرجەکە هەرگیز ڕاست نەبێت، هیچ جارێک ناچێتە ناوەوە. ئەگەر هەر ڕاست بێت و <code>n += 1</code> نەبێت، خولگەکە بێ کۆتایی دەبێت.</p>',
        'content_ba' => '<p>گەڕخستنا <code>while</code> ددگەڕیت هەتا مەرج راستە. دڤێت ژمارەر <code>mut</code> بیت:</p><pre>let mut n = 1;\n\nwhile n &lt;= 5 {\n    println!("{}", n);\n    n += 1;\n}</pre><p>گەر مەرج چ جاران نەبیتە راست، هەرگز ناچیتە ناڤێ. گەر هەردیم راست بیت و <code>n += 1</code> نەبیت، گەڕخستن بێ کۆتایی دبیت.</p>',
        'code' => 'fn main() {
    let mut n = 1;

    while n <= 5 {
        println!("{}", n);
        n += 1;
    }
}',
        'example_output' => '1
2
3
4
5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'خولگەی while چەند جار دەسوڕێتەوە ئەگەر n = 1 دەست پێبکات و مەرجەکە n < 4 بێت؟',
        'quiz_question_ba' => 'گەڕخستنا while چەند جاران ددگەڕیت گەر n = 1 دەست پێدکەت و مەرج n < 4 بیت؟',
        'quiz_options_so' => ['3 جار', '4 جار', '5 جار', '2 جار'],
        'quiz_options_ba' => ['3 جاران', '4 جاران', '5 جاران', '2 جاران'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 14,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی for بە مەودا',
        'title_ba' => 'گەڕخستنا for ب مەودایێ',
        'content_so' => '<p><code>for</code> بەسەر مەوداکان دەسوڕێتەوە. <code>1..=5</code> ١ بۆ ٥ و <code>1..5</code> ١ بۆ ٤:</p><pre>let mut sum = 0;\nfor n in 1..=5 {\n    sum += n;\n}\nprintln!("Sum = {}", sum);   // 15\n\nfor n in (1..=5).rev() {\n    println!("{}", n);\n}</pre><p><code>rev()</code> مەودایەکە دەگەڕێنێتەوە. خولگەی <code>for</code> لە Rust پارێزراوە — ژمارەرێکی <code>mut</code> ناوێت.</p>',
        'content_ba' => '<p><code>for</code> بسەر مەودایان ڤە ددگەڕیت. <code>1..=5</code> ١ هەتا ٥ و <code>1..5</code> ١ هەتا ٤:</p><pre>let mut sum = 0;\nfor n in 1..=5 {\n    sum += n;\n}\nprintln!("Sum = {}", sum);   // 15\n\nfor n in (1..=5).rev() {\n    println!("{}", n);\n}</pre><p><code>rev()</code> مەودایە ڤەدگەڕیت. گەڕخستنا <code>for</code> د Rust دا پاراستییە — ژمارەرەکا <code>mut</code> نڤێت.</p>',
        'code' => 'fn main() {
    let mut sum = 0;

    for n in 1..=5 {
        sum += n;
    }

    println!("Sum = {}", sum);

    for n in (1..=5).rev() {
        println!("{}", n);
    }
}',
        'example_output' => 'Sum = 15
5
4
3
2
1',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کۆی ژمارەکانی 1 بۆ 5 (1+2+3+4+5) چەندە؟',
        'quiz_question_ba' => 'کۆڤانا ژمارێن 1 هەتا 5 (1+2+3+4+5) چەندە؟',
        'quiz_options_so' => ['15', '14', '10', '20'],
        'quiz_options_ba' => ['15', '14', '10', '20'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 15,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی loop و break',
        'title_ba' => 'گەڕخستنا loop و break',
        'content_so' => '<p>خولگەی <code>loop</code> هەرگیز بە خۆی ناوەستێت — تەنها بە <code>break</code> دەوەستێت. <code>continue</code> ئەم جارە دەپەڕێنێت و دەچێت بۆ جاری داهاتوو:</p><pre>let mut n = 0;\n\nloop {\n    n += 1;\n\n    if n == 3 { continue; }\n    if n &gt; 5 { break; }\n\n    println!("{}", n);\n}</pre><p>لێرەدا 3 دەپەڕێتەوە و خولگەکە لە 6 دەوەستێت.</p>',
        'content_ba' => '<p>گەڕخستنا <code>loop</code> هەرگز ب خۆی ناڤەستیت — تەنێ پێ <code>break</code> دیسیت. <code>continue</code> ئەڤ جارا دەرباز دکەت و چیتە جارا دووی:</p><pre>let mut n = 0;\n\nloop {\n    n += 1;\n\n    if n == 3 { continue; }\n    if n &gt; 5 { break; }\n\n    println!("{}", n);\n}</pre><p>ڤێرە 3 دەرباز دبیت و گەڕخستن ل 6 دا دیسیت.</p>',
        'code' => 'fn main() {
    let mut n = 0;

    loop {
        n += 1;

        if n == 3 {
            continue;
        }

        if n > 5 {
            break;
        }

        println!("{}", n);
    }
}',
        'example_output' => '1
2
4
5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کام وشە خولگەی loop وەستاندن؟',
        'quiz_question_ba' => 'کا پەیڤا گەڕخستنا loop disîne؟',
        'quiz_options_so' => ['break', 'continue', 'exit', 'stop'],
        'quiz_options_ba' => ['break', 'continue', 'exit', 'stop'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 16,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەربڕینی match',
        'title_ba' => 'دەربڕینا match',
        'content_so' => '<p><code>match</code> بەها بەراورد دەکات لەگەڵ شێوازەکان و شاخەی یەکەمی لێکچوو جێبەجێ دەکات:</p><pre>let grade = "B";\n\nlet msg = match grade {\n    "A" =&gt; "Pir bas!",\n    "B" =&gt; "Bas!",\n    _ =&gt; "Ne qebûl",\n};\n\nprintln!("{}", msg);   // Bas!</pre><p>شێوازی <code>_</code> هەموو بەهایەکانی تر دەگرێتەوە — وەک <code>else</code> لە مەرج.</p>',
        'content_ba' => '<p><code>match</code> بەها بەراورد دکەت پێگەل شێوازان و شاخا یەکەمین لێکچوو جێبەجێ دکەت:</p><pre>let grade = "B";\n\nlet msg = match grade {\n    "A" =&gt; "Pir bas!",\n    "B" =&gt; "Bas!",\n    _ =&gt; "Ne qebûl",\n};\n\nprintln!("{}", msg);   // Bas!</pre><p>شێوازێ <code>_</code> هەمی بەهایێن دیان دگرهت — وەک <code>else</code> د مەرجی دا.</p>',
        'code' => 'fn main() {
    let grade = "B";

    let msg = match grade {
        "A" => "Pir bas!",
        "B" => "Bas!",
        _ => "Ne qebûl",
    };

    println!("{}", msg);
}',
        'example_output' => 'Bas!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە لە match بۆ هەر بەهایەکی تر بەکار دێت؟',
        'quiz_question_ba' => 'کا د match دا بو هەر بەهایەکا دی بکارتیت؟',
        'quiz_options_so' => ['_', '*', 'default', 'else'],
        'quiz_options_ba' => ['_', '*', 'default', 'else'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 17,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'گەڕانەوە لە فەنکشن',
        'title_ba' => 'ڤەگەڕان ژ فەنکشن',
        'content_so' => '<p>فەنکشن دوو ڕێگای گەڕانەوەی بەهای هەیە: دەربڕینی کۆتایی بەبێ <code>return</code>، یان وشەی <code>return</code> بۆ گەڕانەوەی پێشوەخت:</p><pre>fn square(n: i32) -&gt; i32 {\n    n * n\n}\n\nfn positive(n: i32) -&gt; bool {\n    if n &gt; 0 { return true; }\n    false\n}\n\nprintln!("{}", square(7));      // 49\nprintln!("{}", positive(-3));   // false</pre><p>جۆری گەڕانەوە لە نیشانەی <code>-&gt;</code> دوای پارانتێزەکان دەنووسرێت.</p>',
        'content_ba' => '<p>فەنکشن دوو ڕێکا ڤەگەڕاندنا بەهایان هەن: دەربڕینا دووییان بێ <code>return</code>، یا پەیڤا <code>return</code> بو ڤەگەڕاندنا بەریی:</p><pre>fn square(n: i32) -&gt; i32 {\n    n * n\n}\n\nfn positive(n: i32) -&gt; bool {\n    if n &gt; 0 { return true; }\n    false\n}\n\nprintln!("{}", square(7));      // 49\nprintln!("{}", positive(-3));   // false</pre><p>چەشنا ڤەگەڕاندنێ د نیشانەیا <code>-&gt;</code> پشتی پارانتێزان دینڤیسیت.</p>',
        'code' => 'fn square(n: i32) -> i32 {
    n * n
}

fn positive(n: i32) -> bool {
    if n > 0 {
        return true;
    }
    false
}

fn main() {
    println!("square(7) = {}", square(7));
    println!("positive(-3) = {}", positive(-3));
    println!("positive(4) = {}", positive(4));
}',
        'example_output' => 'square(7) = 49
positive(-3) = false
positive(4) = true',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی square(8) چەندە؟',
        'quiz_question_ba' => 'دەرئەنجامێ square(8) چەندە؟',
        'quiz_options_so' => ['64', '16', '8', '56'],
        'quiz_options_ba' => ['64', '16', '8', '56'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 18,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'نیشانەکان (References)',
        'title_ba' => 'نیشانە (References)',
        'content_so' => '<p>بە نیشانە (reference) بە بەها دەگەیت بەبێ گواستنەوەی خاوەندارێتی. <code>&amp;x</code> نیشانەی نەگۆڕ و <code>&amp;mut x</code> نیشانەی گۆڕاوە:</p><pre>let x = 5;\nlet r = &amp;x;\nprintln!("{}", r);   // 5\n\nlet mut y = 10;\nlet mr = &amp;mut y;\n*mr += 5;\nprintln!("{}", y);   // 15</pre><p>بە <code>*mr</code> بەهاکە دەگۆڕیت. یاسایەکی گرنگ: نیشانەی گۆڕاو نابێت دوو جار لە یەک کاتدا هەبێت — ئەمەش Rust لە ڕاکردنی ناڕێک دەپارێزێت.</p>',
        'content_ba' => '<p>پێ نیشانە (reference) ب بەهایێ ڤە دگههی بێ ڤەگەڕاندنا خاڤەنداریێ. <code>&amp;x</code> نیشانەیا نەگۆڕ و <code>&amp;mut x</code> نیشانەیا گۆڕۆک:</p><pre>let x = 5;\nlet r = &amp;x;\nprintln!("{}", r);   // 5\n\nlet mut y = 10;\nlet mr = &amp;mut y;\n*mr += 5;\nprintln!("{}", y);   // 15</pre><p>پێ <code>*mr</code> بەهایا دگۆڕی. یاسایەکا گرنگ: نیشانەیا گۆڕۆک نابیت دوبارە د هەمان دەمی دا هەبیت — ئەڤ Rust ژ ڕاکرنا ناڕێک دپارێزیت.</p>',
        'code' => 'fn main() {
    let x = 5;
    let r = &x;

    println!("r = {}", r);

    let mut y = 10;
    let mr = &mut y;
    *mr += 5;

    println!("y = {}", y);
}',
        'example_output' => 'r = 5
y = 15',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە نیشانەی نەگۆڕی گۆڕاوی x دروست دەکەیت؟',
        'quiz_question_ba' => 'پێ کا نیشانەیا نەگۆڕ یا گۆڕۆکێ x دروست دکەی؟',
        'quiz_options_so' => ['&x', '*x', '#x', 'x&'],
        'quiz_options_ba' => ['&x', '*x', '#x', 'x&'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 19,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'String لەگەڵ &str',
        'title_ba' => 'String پێگەل &str',
        'content_so' => '<p><code>String</code> دەقی گۆڕاوە لەسەر هێپ، بەڵام <code>&amp;str</code> دەقی نەگۆڕە. دەتوانیت لە نێوانیاندا گۆڕکاری بکەیت:</p><pre>let s1 = String::from("Kurd");\nlet s2 = "Kurd".to_string();\nlet s3: &amp;str = "Kurd";\n\nprintln!("{}", s1);                    // Kurd\nprintln!("{}", s2);                    // Kurd\nprintln!("{}", s3.to_uppercase());     // KURD</pre><p><code>String::from(...)</code> و <code>.to_string()</code> لە <code>&amp;str</code> دا <code>String</code> دروست دەکەن.</p>',
        'content_ba' => '<p><code>String</code> نڤیسینەکا گۆڕۆک ل سەر هێپ، بەلێ <code>&amp;str</code> نڤیسینەکا نەگۆڕ. دکەی د ناڤبەرا هەرکا و چەشنێ گۆڕکاری بکەی:</p><pre>let s1 = String::from("Kurd");\nlet s2 = "Kurd".to_string();\nlet s3: &amp;str = "Kurd";\n\nprintln!("{}", s1);                    // Kurd\nprintln!("{}", s2);                    // Kurd\nprintln!("{}", s3.to_uppercase());     // KURD</pre><p><code>String::from(...)</code> و <code>.to_string()</code> ژ <code>&amp;str</code> دا <code>String</code> دروست دکەن.</p>',
        'code' => 'fn main() {
    let s1 = String::from("Kurd");
    let s2 = "kurd".to_string();
    let s3: &str = "Kurdistan";

    println!("{}", s1);
    println!("{}", s2);
    println!("{}", s3.to_uppercase());
}',
        'example_output' => 'Kurd
kurd
KURDISTAN',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە دروستە بۆ گۆڕینی &str بۆ String؟',
        'quiz_question_ba' => 'کا دروستە بو گۆڕینا &str بۆ String؟',
        'quiz_options_so' => ['"salam".to_string()', '"salam".to_str()', 'String::str("salam")', '"salam".string()'],
        'quiz_options_ba' => ['"salam".to_string()', '"salam".to_str()', 'String::str("salam")', '"salam".string()'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 20,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'میتۆدەکانی String',
        'title_ba' => 'میتۆدێن String',
        'content_so' => '<p>چەند میتۆدی بەسوود بۆ <code>String</code>:</p><pre>let mut msg = String::from("Salam");\nmsg.push_str(" Kurd!");\n\nprintln!("{}", msg);                     // Salam Kurd!\nprintln!("{}", msg.len());               // 11\nprintln!("{}", msg.contains("Kurd"));    // true\nprintln!("{}", msg.replace("Salam", "Merheba"));</pre><p><code>push_str</code> وشە زیاد دەکات، <code>len</code> ژمارەی بایتەکان، <code>contains</code> دەگەڕێت بۆ وشەیەک و <code>replace</code> دەگۆڕێت.</p>',
        'content_ba' => '<p>چەند میتۆدێن بسوود بو <code>String</code>:</p><pre>let mut msg = String::from("Salam");\nmsg.push_str(" Kurd!");\n\nprintln!("{}", msg);                     // Salam Kurd!\nprintln!("{}", msg.len());               // 11\nprintln!("{}", msg.contains("Kurd"));    // true\nprintln!("{}", msg.replace("Salam", "Merheba"));</pre><p><code>push_str</code> پەیڤ زێدە دکەت، <code>len</code> ژمارا بایتان، <code>contains</code> دگەڕیت بو پەیڤەکا و <code>replace</code> دگۆڕیت.</p>',
        'code' => 'fn main() {
    let mut msg = String::from("Salam");
    msg.push_str(" Kurd!");

    println!("{}", msg);
    println!("dirêjî: {}", msg.len());
    println!("contains Kurd: {}", msg.contains("Kurd"));
    println!("nû: {}", msg.replace("Salam", "Merheba"));
}',
        'example_output' => 'Salam Kurd!
dirêjî: 11
contains Kurd: true
nû: Merheba Kurd!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە میتۆد وشە زیاد دەکەیت بۆ کۆتایی String؟',
        'quiz_question_ba' => 'پێ کا میتۆدی پەیڤ زێدە دکەی بو کۆتایا String؟',
        'quiz_options_so' => ['push_str', 'len', 'contains', 'replace'],
        'quiz_options_ba' => ['push_str', 'len', 'contains', 'replace'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 21,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ڤەکتۆر (Vec)',
        'title_ba' => 'ڤەکتۆر (Vec)',
        'content_so' => '<p><code>Vec</code> ئارایێکی گۆڕاوە کە دەتوانێت گەورە بێت. بە <code>vec!</code> یان <code>Vec::new()</code> دروست دەکرێت:</p><pre>let mut v = Vec::new();\nv.push(1);\nv.push(2);\nv.push(3);\n\nlet v2 = vec![10, 20, 30];\n\nfor n in &amp;v2 {\n    println!("{}", n);\n}\n\nprintln!("{}", v[1]);     // 2\nprintln!("{}", v.len());  // 3</pre><p>هەموو بەهاکانی <code>Vec</code> دەبێت هەمان جۆر بن. <code>push</code> بەها زیاد دەکات و <code>len</code> قەبارە دەگەڕێنێتەوە.</p>',
        'content_ba' => '<p><code>Vec</code> ئارایەکا گۆڕۆک یە کە دکەی مهزن بیت. پێ <code>vec!</code> یا <code>Vec::new()</code> دروست دبیت:</p><pre>let mut v = Vec::new();\nv.push(1);\nv.push(2);\nv.push(3);\n\nlet v2 = vec![10, 20, 30];\n\nfor n in &amp;v2 {\n    println!("{}", n);\n}\n\nprintln!("{}", v[1]);     // 2\nprintln!("{}", v.len());  // 3</pre><p>هەمی بەهایێن <code>Vec</code> دڤێت هەمان چەشن بن. <code>push</code> بەها زێدە دکەت و <code>len</code> قەبارە ڤەدگەڕیت.</p>',
        'code' => 'fn main() {
    let mut v = Vec::new();
    v.push(1);
    v.push(2);
    v.push(3);

    let v2 = vec![10, 20, 30];

    for n in &v2 {
        println!("{}", n);
    }

    println!("v[1] = {}", v[1]);
    println!("len = {}", v.len());
}',
        'example_output' => '10
20
30
v[1] = 2
len = 3',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە دروستە بۆ دروستکردنی Vec بە بەهاکان؟',
        'quiz_question_ba' => 'کا دروستە بو دروستکرنا Vec ب بەهایان؟',
        'quiz_options_so' => ['vec![1, 2, 3]', 'array![1, 2, 3]', 'list![1, 2, 3]', 'new![1, 2, 3]'],
        'quiz_options_ba' => ['vec![1, 2, 3]', 'array![1, 2, 3]', 'list![1, 2, 3]', 'new![1, 2, 3]'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 22,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پێناسەکردنی Struct',
        'title_ba' => 'پێناسەکرنا Struct',
        'content_so' => '<p>بە <code>struct</code> شێوازێکی نوێی داتا پێناسە دەکەیت و پاشان بە <code>Book { ... }</code> نموونە دروست دەکەیت:</p><pre>struct Book {\n    title: String,\n    pages: i32,\n}\n\nlet b = Book {\n    title: String::from("Serhed"),\n    pages: 250,\n};\n\nprintln!("{}: {} rûpel", b.title, b.pages);</pre><p>بە خاڵ <code>.</code> بە بەشەکان دەگەیت. سینتاکسی <code>..b</code> بەشەکانی ماوە کۆپی دەکات:</p><pre>let b2 = Book { pages: 100, ..b };</pre>',
        'content_ba' => '<p>پێ <code>struct</code> شێوازەکا نوی یا داتایێ پێناسە دکەی و پشتی وی پێ <code>Book { ... }</code> نموونە دروست دکەی:</p><pre>struct Book {\n    title: String,\n    pages: i32,\n}\n\nlet b = Book {\n    title: String::from("Serhed"),\n    pages: 250,\n};\n\nprintln!("{}: {} rûpel", b.title, b.pages);</pre><p>پێ خال <code>.</code> ب بەشان ڤە دگههی. سینتاکسا <code>..b</code> بەشێن مایی کۆپی دکەت:</p><pre>let b2 = Book { pages: 100, ..b };</pre>',
        'code' => 'struct Book {
    title: String,
    pages: i32,
}

fn main() {
    let b = Book {
        title: String::from("Serhed"),
        pages: 250,
    };

    println!("{}: {} rûpel", b.title, b.pages);

    let b2 = Book {
        pages: 100,
        ..b
    };

    println!("{}: {} rûpel", b2.title, b2.pages);
}',
        'example_output' => 'Serhed: 250 rûpel
Serhed: 100 rûpel',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە بۆ بەشی title دەگەیت؟',
        'quiz_question_ba' => 'پێ کا بۆ بەشێ title دگههی؟',
        'quiz_options_so' => ['b.title', 'b->title', 'b[title]', 'b.title()'],
        'quiz_options_ba' => ['b.title', 'b->title', 'b[title]', 'b.title()'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 23,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'میتۆدی Struct (impl)',
        'title_ba' => 'میتۆدێ Struct (impl)',
        'content_so' => '<p>لە ناو بەشی <code>impl</code> فەنکشن بۆ struct دەنووسیت. میتۆد بە <code>&amp;self</code> و فەنکشنی پێوەندیدار (وەک <code>new</code>) بەبێ <code>self</code>:</p><pre>struct Circle {\n    radius: f64,\n}\n\nimpl Circle {\n    fn new(r: f64) -&gt; Circle {\n        Circle { radius: r }\n    }\n\n    fn area(&amp;self) -&gt; f64 {\n        3.14159 * self.radius * self.radius\n    }\n}\n\nlet c = Circle::new(2.0);\nprintln!("{}", c.area());   // 12.56636</pre><p><code>Circle::new</code> بە <code>::</code> بانگ دەکرێت و <code>c.area()</code> بە <code>.</code>.</p>',
        'content_ba' => '<p>د ناڤ بەشا <code>impl</code> دا فەنکشن بو struct دینڤیسی. میتۆد پێ <code>&amp;self</code> و فەنکشنێن پێوهندر (وەک <code>new</code>) بێ <code>self</code>:</p><pre>struct Circle {\n    radius: f64,\n}\n\nimpl Circle {\n    fn new(r: f64) -&gt; Circle {\n        Circle { radius: r }\n    }\n\n    fn area(&amp;self) -&gt; f64 {\n        3.14159 * self.radius * self.radius\n    }\n}\n\nlet c = Circle::new(2.0);\nprintln!("{}", c.area());   // 12.56636</pre><p><code>Circle::new</code> پێ <code>::</code> بانگ دبیت و <code>c.area()</code> پێ <code>.</code>.</p>',
        'code' => 'struct Circle {
    radius: f64,
}

impl Circle {
    fn new(r: f64) -> Circle {
        Circle { radius: r }
    }

    fn area(&self) -> f64 {
        3.14159 * self.radius * self.radius
    }
}

fn main() {
    let c = Circle::new(2.0);
    println!("rûpel = {}", c.area());
}',
        'example_output' => 'rûpel = 12.56636',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە فەنکشنی new بانگ دەکەیت؟',
        'quiz_question_ba' => 'پێ کا فەنکشنا new بانگ دکەی؟',
        'quiz_options_so' => ['Circle::new(2.0)', 'Circle.new(2.0)', 'Circle->new(2.0)', 'new(Circle, 2.0)'],
        'quiz_options_ba' => ['Circle::new(2.0)', 'Circle.new(2.0)', 'Circle->new(2.0)', 'new(Circle, 2.0)'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 24,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Enumەکان',
        'title_ba' => 'Enum',
        'content_so' => '<p><code>enum</code> کۆمەڵێک بەهای گریمانەیی پێناسە دەکات. دەتوانیت هاوپەیمان لەگەڵ <code>match</code> بەکاربهێنیت:</p><pre>enum Direction {\n    North,\n    East,\n    South,\n    West,\n}\n\nlet d = Direction::East;\n\nlet name = match d {\n    Direction::North =&gt; "bakur",\n    Direction::East =&gt; "rojhilat",\n    Direction::South =&gt; "başûr",\n    Direction::West =&gt; "rojava",\n};\n\nprintln!("{}", name);   // rojhilat</pre><p>وەریان بە <code>::</code> دروست دەکرێت وەک <code>Direction::East</code>.</p>',
        'content_ba' => '<p><code>enum</code> کۆمەلەکا بەهایێن گریمانەیی پێناسە دکەت. دکەی پێگەل <code>match</code> بکاربینی:</p><pre>enum Direction {\n    North,\n    East,\n    South,\n    West,\n}\n\nlet d = Direction::East;\n\nlet name = match d {\n    Direction::North =&gt; "bakur",\n    Direction::East =&gt; "rojhilat",\n    Direction::South =&gt; "başûr",\n    Direction::West =&gt; "rojava",\n};\n\nprintln!("{}", name);   // rojhilat</pre><p>وەریان پێ <code>::</code> دروست دبیت وەک <code>Direction::East</code>.</p>',
        'code' => 'enum Direction {
    North,
    East,
    South,
    West,
}

fn main() {
    let d = Direction::East;

    let name = match d {
        Direction::North => "bakur",
        Direction::East => "rojhilat",
        Direction::South => "başûr",
        Direction::West => "rojava",
    };

    println!("{}", name);
}',
        'example_output' => 'rojhilat',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە دروستە بۆ دروستکردنی وەری Direction؟',
        'quiz_question_ba' => 'کا دروستە بو دروستکرنا وەری Direction؟',
        'quiz_options_so' => ['Direction::East', 'Direction.East', 'new Direction(East)', 'East::Direction'],
        'quiz_options_ba' => ['Direction::East', 'Direction.East', 'new Direction(East)', 'East::Direction'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 25,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'ترایتەکان (Traits)',
        'title_ba' => 'ترایت (Traits)',
        'content_so' => '<p><strong>ترایت</strong> (trait) لە Rust وەک <code>interface</code> لە زمانەکانی تردایە — کۆمەڵێک واژووی میتۆد پێناسە دەکات بەبێ جێبەجێکردنی. پاشان <code>struct</code> یان <code>enum</code> دەتوانێت ئەو میتۆدانە جێبەجێ بکات.</p><p>لە نموونەکەدا ترایتی <code>Sound</code> تاکە میتۆدی <code>make_sound</code>ی هەیە. struct ی <code>Dog</code> بە <code>impl Sound for Dog</code> ئەو میتۆدە جێبەجێ دەکات و پاشان بە خاڵ <code>.</code> لەسەر نموونەکە بانگی دەکەیت:</p><pre>trait Sound {\n    fn make_sound(&amp;self) -&gt; String;\n}\n\nstruct Dog;\nstruct Cat;\n\nimpl Sound for Dog {\n    fn make_sound(&amp;self) -&gt; String {\n        String::from("Hav hav!")\n    }\n}\n\nimpl Sound for Cat {\n    fn make_sound(&amp;self) -&gt; String {\n        String::from("Miyav!")\n    }\n}\n\nfn main() {\n    let d = Dog;\n    let c = Cat;\n    println!("{}", d.make_sound());\n    println!("{}", c.make_sound());\n}</pre><p>هەمان ترایت دەتوانرێت بۆ <strong>چەند struct ی جیاواز</strong> جێبەجێ بکرێت — وەک <code>Cat</code> کە هەمان ترایتی <code>Sound</code> جێبەجێ دەکات بەڵام بە دەنگێکی جیاواز. ئەمەش <strong>ھاوشێوەیی</strong> (polymorphism) دەدات بە ڕێگایەکی سەلامەت بەبێ میراث (inheritance). میتۆدی ترایت بۆ دەستگەیشتن بە بەشەکانی struct دەبێت پارامەتری <code>&amp;self</code>ی هەبێت، هەروەک بەشی <code>impl</code> لە وانەی struct.</p>',
        'content_ba' => '<p><strong>ترایت</strong> (trait) د Rust دا وەک <code>interface</code> ی د زمانێن دیان یە — کۆمەلەکا نڤیسینا میتۆدان پێناسە دکەت بێ جێبەجێکرنێ. پشتی وی <code>struct</code> یا <code>enum</code> دکەت ڤان میتۆدان جێبەجێ کەت.</p><p>د نموونەکا دا ترایتێ <code>Sound</code> تەنێ میتۆدا <code>make_sound</code> هەیە. struct ی <code>Dog</code> پێ <code>impl Sound for Dog</code> ڤێ میتۆدا جێبەجێ دکەت و پشتی وی پێ خالەکا <code>.</code> ل سەر نموونە بانگ دکەی:</p><pre>trait Sound {\n    fn make_sound(&amp;self) -&gt; String;\n}\n\nstruct Dog;\nstruct Cat;\n\nimpl Sound for Dog {\n    fn make_sound(&amp;self) -&gt; String {\n        String::from("Hav hav!")\n    }\n}\n\nimpl Sound for Cat {\n    fn make_sound(&amp;self) -&gt; String {\n        String::from("Miyav!")\n    }\n}\n\nfn main() {\n    let d = Dog;\n    let c = Cat;\n    println!("{}", d.make_sound());\n    println!("{}", c.make_sound());\n}</pre><p>هەمان ترایت دکەت بو <strong>چەند struct ێن جودا</strong> جێبەجێ ببیت — وەک <code>Cat</code> ی کو هەمان ترایتێ <code>Sound</code> جێبەجێ دکەت بەلێ ب دەنگەکا جودا. ئەڤە <strong>polymorphism</strong> ی ددەت ب ڕێکا ئەمنی بێ میراثێ (inheritance). میتۆدا ترایتێ بو دگەهشتنا بەشێن struct ی دڤێت پارامەترا <code>&amp;self</code> هەبیت، وەک بەشا <code>impl</code> ی د وانەی struct دا.</p>',
        'code' => 'trait Sound {
    fn make_sound(&self) -> String;
}

struct Dog;
struct Cat;

impl Sound for Dog {
    fn make_sound(&self) -> String {
        String::from("Hav hav!")
    }
}

impl Sound for Cat {
    fn make_sound(&self) -> String {
        String::from("Miyav!")
    }
}

fn main() {
    let d = Dog;
    let c = Cat;

    println!("{}", d.make_sound());
    println!("{}", c.make_sound());
}',
        'example_output' => 'Hav hav!
Miyav!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە شێوە ترایت لەسەر struct جێبەجێ دەکەیت؟',
        'quiz_question_ba' => 'پێ کا شێوەز ترایت ل سەر struct جێبەجێ دکەی؟',
        'quiz_options_so' => ['impl Sound for Dog', 'struct Dog for Sound', 'for Sound Dog', 'Dog.impl(Sound)'],
        'quiz_options_ba' => ['impl Sound for Dog', 'struct Dog for Sound', 'for Sound Dog', 'Dog.impl(Sound)'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 26,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Default و Derive (خودکار)',
        'title_ba' => 'Default و Derive (خودکار)',
        'content_so' => '<p>لە Rust دەتوانیت بە <code>#[derive(...)]</code> ڕەفتاری ستاندارد بۆ struct ی خۆت دروست بکەیت بەبێ نووسینی دەستی. ئەمەش کۆد کەمتر و <strong>سادەتر</strong> دەکات.</p><p>ترایتی <code>Default</code> بەهای بنەڕەتی دەدات بە هەر بەشێک. کاتێک struct یەکە بە <code>#[derive(Default)]</code> پێناسە دەکەیت، دەتوانیت بە <code>Point::default()</code> نموونەکە بە بەهای بنەڕەتی دروست بکەیت:</p><pre>#[derive(Default)]\nstruct Point {\n    x: i32,\n    y: i32,\n}\n\nfn main() {\n    let p = Point::default();\n    println!("x = {}, y = {}", p.x, p.y);\n}</pre><p><code>#[derive(...)]</code> لە سەرووی struct یان enum دەنووسرێت وەک تایبەتمەندی. هەموو بەشەکان دەبێت خۆیان ترایتی <code>Default</code>یان هەبێت — بۆ نموونە <code>i32</code> بەهای <code>0</code>یە و <code>bool</code> بەهای <code>false</code>یە. <code>derive</code> بۆ ترایتی تر وەک <code>Debug</code> و <code>Clone</code>یش بەکار دێت بۆ کەمکردنەوەی نووسینی دووبارە.</p>',
        'content_ba' => '<p>د Rust دا دکەی پێ <code>#[derive(...)]</code> ڕەفتارا استاندارد بو struct ی خۆ دروست کەی بێ نڤیسینا دەستی. ئەڤە کۆد کێمتر و <strong>سادەتر</strong> دکەت.</p><p>ترایتێ <code>Default</code> بەهایا بنەڕەتی ددەت بو هەر بەشەکا. دەمەکێ struct ی پێ <code>#[derive(Default)]</code> پێناسە دکەی، دکەی پێ <code>Point::default()</code> نموونە ب بەهایێن بنەڕەتی دروست کەی:</p><pre>#[derive(Default)]\nstruct Point {\n    x: i32,\n    y: i32,\n}\n\nfn main() {\n    let p = Point::default();\n    println!("x = {}, y = {}", p.x, p.y);\n}</pre><p><code>#[derive(...)]</code> ل سەرا struct یا enum دینڤیسیت وەک تایبەتمەندی. هەمی بەش دڤێت خۆ ترایتێ <code>Default</code> هەبن — بو نموونە <code>i32</code> بەهایا <code>0</code>یە و <code>bool</code> بەهایا <code>false</code>یە. <code>derive</code> بو ترایتێن دی وەک <code>Debug</code> و <code>Clone</code> ژی بکارتیت بو کێمکرنا نڤیسینا دوبارە.</p>',
        'code' => '#[derive(Default)]
struct Point {
    x: i32,
    y: i32,
}

fn main() {
    let p = Point::default();

    println!("x = {}, y = {}", p.x, p.y);
}',
        'example_output' => 'x = 0, y = 0',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کامە دروستە بۆ دروستکردنی struct بە بەهای بنەڕەتی؟',
        'quiz_question_ba' => 'پێ کا دروستە بو دروستکرنا struct ی ب بەهایێن بنەڕەتی؟',
        'quiz_options_so' => ['Point::default()', 'Point::new()', 'Point::base()', 'Point::zero()'],
        'quiz_options_ba' => ['Point::default()', 'Point::new()', 'Point::base()', 'Point::zero()'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 27,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Generic Functions و Struct',
        'title_ba' => 'Generic Functions و Struct',
        'content_so' => '<p><strong>Generic</strong> لە Rust بە <code>&lt;T&gt;</code> دەنووسرێت و ڕێگا دەدات هەمان فەنکشن یان struct بۆ <strong>چەند جۆرێک</strong> بەکار بێت بەبێ دووبارەکردنەوە. <code>T</code> ناونیشانێکە بۆ هەر جۆرێک.</p><p>لە فەنکشنی generic دا پارامەتری جۆر <code>&lt;T&gt;</code> لە نێوان دوو براکەت دەنووسیت و پاشان <code>T</code> لە شوێنەکانی تر بەکار دەهێنیت. struct ی <code>Pair</code> دوو بەشی هەمان جۆر هەیە کە دەتوانرێت <code>i32</code> یان <code>&amp;str</code> بێت:</p><pre>use std::fmt::Display;\n\nfn show&lt;T: Display&gt;(value: T) {\n    println!("{}", value);\n}\n\nstruct Pair&lt;T&gt; {\n    first: T,\n    second: T,\n}\n\nfn main() {\n    show(42);\n    show("Kurdistan");\n\n    let p = Pair { first: 1, second: 2 };\n    println!("{} {}", p.first, p.second);\n}</pre><p>generic بەهێزترینە کاتێک پێگەل ترایت دەکەیت. لە <code>fn show&lt;T: Display&gt;</code>، <code>T: Display</code> بە واتای ئەوەیە <code>T</code> دەبێت ترایتی <code>Display</code>ی هەبێت بۆ چاپکردن. ئەمەش Rust یارمەتی دەدات هەڵەکانی جۆر لە کاتی کۆکردنەوەدا بدۆزێتەوە — پێش ئەوەی بەرنامەکە کار بکات.</p>',
        'content_ba' => '<p><strong>Generic</strong> د Rust دا پێ <code>&lt;T&gt;</code> دینڤیسیت و ڕێکا ددەت کو هەمان فەنکشن یا struct بو <strong>چەند چەشنان</strong> بکارتیت بێ دوبارەکرنێ. <code>T</code> ناڤەک یە بو هەر چەشنا.</p><p>د فەنکشنا generic دا پارامەترا چەشنا <code>&lt;T&gt;</code> د ناڤبەرا دوو براکەت دینڤیسی و پشتی وی <code>T</code> د شونا دیان بکارتینی. struct ی <code>Pair</code> دوو بەشێ هەمان چەشنی هەن کو دکەن <code>i32</code> یا <code>&amp;str</code> بن:</p><pre>use std::fmt::Display;\n\nfn show&lt;T: Display&gt;(value: T) {\n    println!("{}", value);\n}\n\nstruct Pair&lt;T&gt; {\n    first: T,\n    second: T,\n}\n\nfn main() {\n    show(42);\n    show("Kurdistan");\n\n    let p = Pair { first: 1, second: 2 };\n    println!("{} {}", p.first, p.second);\n}</pre><p>generic بهێزترین دەمە کو پێگەل ترایت دکەی. د <code>fn show&lt;T: Display&gt;</code> دا، <code>T: Display</code> ب مانایا وێ یە کو <code>T</code> دڤێت ترایتێ <code>Display</code> هەبیت بو چاپکرنێ. ئەڤە Rust بو یارمەتیی ددەت کو خەلەتێن چەشنان د دەمە کومکرنێ دا دیت — بەری کو بەرنامە کار کەت.</p>',
        'code' => 'use std::fmt::Display;

fn show<T: Display>(value: T) {
    println!("{}", value);
}

struct Pair<T> {
    first: T,
    second: T,
}

fn main() {
    show(42);
    show("Kurdistan");

    let p = Pair { first: 1, second: 2 };
    println!("{} {}", p.first, p.second);
}',
        'example_output' => '42
Kurdistan
1 2',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'پارامەتری جۆر لە فەنکشنی generic چۆن دەنووسرێت؟',
        'quiz_question_ba' => 'پارامەترا چەشنا د فەنکشنا generic دا چاوا دینڤیسیت؟',
        'quiz_options_so' => ['<T>', '(T)', '[T]', '{T}'],
        'quiz_options_ba' => ['<T>', '(T)', '[T]', '{T}'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 28,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'بەهای نەگۆڕ (const)',
        'title_ba' => 'بەهایا نەگۆڕ (const)',
        'content_so' => '<p><code>const</code> بەهایەکی نەگۆڕە کە لە کاتی کۆکردنەوەدا دەناسرێت. جۆرەکەی دەبێت دیاری بکرێت و ناوەکەی بە <code>SCREAMING_SNAKE_CASE</code>:</p><pre>const MAX_POINTS: u32 = 100_000;\n\nprintln!("{}", MAX_POINTS);   // 100000</pre><p>جیاوازی لەگەڵ <code>let</code>: <code>const</code> بە <code>mut</code> نابێت، جۆری دیاریکراوە، و ناتوانرێت shadow بکرێت.</p>',
        'content_ba' => '<p><code>const</code> بەهایەکا نەگۆڕ یە کو د دەمە کومکرنێ دا دیار دبیت. چەشنا وی دڤێت دیاری ببیت و ناڤێ وی پێ <code>SCREAMING_SNAKE_CASE</code>:</p><pre>const MAX_POINTS: u32 = 100_000;\n\nprintln!("{}", MAX_POINTS);   // 100000</pre><p>فەرقا وی پێگەل <code>let</code>: <code>const</code> پێ <code>mut</code> نابیت، چەشنا دیاریکری یە، و ناڤێ ناتکەن shadow بکەی.</p>',
        'code' => 'const MAX_POINTS: u32 = 100_000;

fn main() {
    println!("Max = {}", MAX_POINTS);

    let speed = 3.0;
    let time = 4.0;
    println!("dûr = {}", speed * time);
}',
        'example_output' => 'Max = 100000
dûr = 12',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کامە دروستە بۆ const؟',
        'quiz_question_ba' => 'کا دروستە بو const؟',
        'quiz_options_so' => ['const MAX: i32 = 10;', 'let const MAX = 10;', 'const MAX = 10;', 'static const MAX = 10;'],
        'quiz_options_ba' => ['const MAX: i32 = 10;', 'let const MAX = 10;', 'const MAX = 10;', 'static const MAX = 10;'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 29,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'جۆری char و bool',
        'title_ba' => 'چەشنێ char و bool',
        'content_so' => '<p><code>char</code> پیتێکی تاکەیە و بە یەک فەرمانی <code>\'</code> دەنووسرێت، لەگەڵ <code>bool</code> کە تەنها <code>true</code> یان <code>false</code>یە:</p><pre>let a: char = \'K\';\nlet b: bool = true;\n\nprintln!("{}", a);\nprintln!("{}", b);</pre><p>جیاوازی: دەق لەگەڵ <code>"</code> و char لەگەڵ <code>\'</code>. بۆ مەرجەکان <code>bool</code> بەکاربهێنە.</p>',
        'content_ba' => '<p><code>char</code> پیتەکا تەنی یە و ب یەک فەرمانا <code>\'</code> دینڤیسیت، پێگەل <code>bool</code> کو تەنێ <code>true</code> یا <code>false</code>یە:</p><pre>let a: char = \'K\';\nlet b: bool = true;\n\nprintln!("{}", a);\nprintln!("{}", b);</pre><p>فەرق: نڤیسین پێگەل <code>"</code> و char پێگەل <code>\'</code>. بو مەرجان <code>bool</code> بکاربینە.</p>',
        'code' => 'fn main() {
    let a: char = \'K\';
    let b: bool = true;
    let c: bool = false;

    println!("a = {}", a);
    println!("b = {}", b);
    println!("c = {}", c);
}',
        'example_output' => 'a = K
b = true
c = false',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'چ جۆر بەها لە char دەنووسرێت؟',
        'quiz_question_ba' => 'کا چ جۆرە بەهایان د char دا دینڤیسیت؟',
        'quiz_options_so' => ['پیتێکی تاکە', 'ژمارەیەک', 'دەقێکی درێژ', 'ڕاست یان هەڵە'],
        'quiz_options_ba' => ['پیتەکا تەنی', 'ژمارە', 'نڤیسینەکا درێژ', 'راست یان خەلەت'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 30,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz',
        'title_ba' => 'پرۆژە: FizzBuzz',
        'content_so' => '<p>پرۆژەیەکی ناسراو بۆ ڕاهێنان: بۆ هەر ژمارەیەک لە ١ بۆ ١٥، ئەگەر بە ٣ و ٥ دابەش بوو <code>FizzBuzz</code>، بە ٣ <code>Fizz</code>، بە ٥ <code>Buzz</code>، ئەگینا ژمارەکە:</p><pre>for n in 1..=15 {\n    if n % 15 == 0 {\n        println!("FizzBuzz");\n    } else if n % 3 == 0 {\n        println!("Fizz");\n    } else if n % 5 == 0 {\n        println!("Buzz");\n    } else {\n        println!("{}", n);\n    }\n}</pre><p>تێبینی: سەرەتا <code>n % 15</code> دەپشکنرێت چونکە هەر ژمارەیەک بە 15 دابەش دەبێت، بە 3 و 5یش دابەش دەبێت.</p>',
        'content_ba' => '<p>پرۆژەکا ناسایی بو ڕاهینانێ: بو هەر ژمارەکا ژ ١ هەتا ١٥، گەر ب ٣ و ٥ پارڤە ببیت <code>FizzBuzz</code>، ب ٣ <code>Fizz</code>، ب ٥ <code>Buzz</code>، ئەگینە ژمارە:</p><pre>for n in 1..=15 {\n    if n % 15 == 0 {\n        println!("FizzBuzz");\n    } else if n % 3 == 0 {\n        println!("Fizz");\n    } else if n % 5 == 0 {\n        println!("Buzz");\n    } else {\n        println!("{}", n);\n    }\n}</pre><p>تێبینی: پێشی <code>n % 15</code> دپشکرت چونکی هر ژمارەکا ب 15 پارڤە دبیت، ب 3 و 5 ژی پارڤە دبیت.</p>',
        'code' => 'fn main() {
    for n in 1..=15 {
        if n % 15 == 0 {
            println!("FizzBuzz");
        } else if n % 3 == 0 {
            println!("Fizz");
        } else if n % 5 == 0 {
            println!("Buzz");
        } else {
            println!("{}", n);
        }
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
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بۆ ژمارەی 15 چی چاپ دەکرێت؟',
        'quiz_question_ba' => 'بو ژمارا 15 چ چاپ دبیت؟',
        'quiz_options_so' => ['FizzBuzz', 'Fizz', 'Buzz', '15'],
        'quiz_options_ba' => ['FizzBuzz', 'Fizz', 'Buzz', '15'],
        'quiz_correct' => '0',
    ],
];

if (defined('FERGA_SEED_LIB')) {
    $FERGA_SEED_LIBS['rust'] = ['langId' => '-OysGzfS5Qi08XHYs_FL', 'lessons' => $lessons];
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

echo "\nDone! Rust lessons have been added to Ferga.\n";
