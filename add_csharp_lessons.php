<?php

// Script to add C# lessons (1-8) to the Ferga section in Firebase.
// Language already exists as -OysGzUzKG67KcswHXn2; we just post lessons and unlock it.
if (!defined('FERGA_SEED_LIB')) {
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-OysGzUzKG67KcswHXn2';

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

// C# language already exists; just unlock it.
fbPatch($firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
echo "Language C# unlocked.\n";

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
        'title_so' => 'چییە C#؟',
        'title_ba' => 'چ یە C#؟',
        'content_so' => '<p><strong>C#</strong> (بە شێوازی سیمانەی "سی شاڕپ") زمانێکی مۆدێرنە لەلایەن مایکرۆسۆفتەوە دروستکراوە. بۆ دروستکردنی ئەپلیکەیشنی ویندۆز، یارییەکان (بە Unity) و وێب بەکاردێت.</p><p>بەرنامەیەکی سادەی C#:</p><pre>using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine("Hello from C#!");\n    }\n}</pre><p><code>using System;</code> بۆ بەکارهێنانی دەروازە ئاساییەکانە. بە <code>Console.WriteLine()</code> دەق چاپ دەکەیت.</p>',
        'content_ba' => '<p><strong>C#</strong> (ب شێوازا دنگێ "سی شاڕپ") زمانەکەکا مۆدێرنە ژ لایەن مایکرۆسۆفت ڤە هاتییە دروستکرن. بو دروستکرنا ئەپلیکەیشنێن ویندۆز، یاریان (پێ Unity) و وێب بکارتیت.</p><p>بەرنامەیەکا سادە یا C#:</p><pre>using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine("Hello from C#!");\n    }\n}</pre><p><code>using System;</code> بو بکارهینانا دەروازە ئاساییان یە. پێ <code>Console.WriteLine()</code> نڤیسین چاپ دکەی.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        Console.WriteLine("Hello from C#!");
    }
}',
        'example_output' => 'Hello from C#!',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'کام فەنکشن دەق چاپ دەکات لە C#؟',
        'quiz_question_ba' => 'کا فەنکشن نڤیسین چاپ دکەت د C# دا؟',
        'quiz_options_so' => ['Console.WriteLine', 'System.print', 'echo', 'printf'],
        'quiz_options_ba' => ['Console.WriteLine', 'System.print', 'echo', 'printf'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'گۆڕاوەکان و جۆرەکانی داتا',
        'title_ba' => 'گۆڕۆک و چەشنێن داتایێ',
        'content_so' => '<p>لە C# هەموو گۆڕاوێک جۆرێکی دیاریکراوی هەیە:</p><pre>int age = 20;              // ژمارەی تەواو\ndouble price = 9.99;       // ژمارەی لۆیی\nchar letter = \'A\';          // پیتێک\nbool passed = true;         // ڕاست یان هەڵە\nstring name = "Kurd";       // دەق\n\nConsole.WriteLine(age + " - " + price);</pre><p>دەروازە ئاساییەکان بە پیتی گەورە دەست پێ دەکەن: <code>int</code>، <code>double</code>، <code>bool</code>، <code>string</code>. C# زمانی <strong>بەهێزی جۆرە</strong> یە — هەڵەی جۆرەکان لە کاتی کۆکردنەوەدا دەردەکەون.</p>',
        'content_ba' => '<p>د C# دا هەمی گۆڕۆک چەشنەکا دیاریکراوی یە:</p><pre>int age = 20;              // ژمارە تەمام\ndouble price = 9.99;       // ژمارە لۆیی\nchar letter = \'A\';          // پیتەک\nbool passed = true;         // راست یا خەلەت\nstring name = "Kurd";       // نڤیسین\n\nConsole.WriteLine(age + " - " + price);</pre><p>دەروازە ئاسایی پێ پیتێن مەزن دەست پێ دکەن: <code>int</code>، <code>double</code>، <code>bool</code>، <code>string</code>. C# زمانەکا <strong>بهێز یا چەشنان</strong> یە — خەلەتێن چەشنان د دەمە کومکرنێ دا دەردکەڤن.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int age = 20;
        double price = 9.99;
        string city = "Hewlêr";

        Console.WriteLine("Age: " + age);
        Console.WriteLine("Price: " + price);
        Console.WriteLine("City: " + city);
    }
}',
        'example_output' => 'Age: 20
Price: 9.99
City: Hewlêr',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'جۆری 3.14 لە C# چییە؟',
        'quiz_question_ba' => 'چەشنێ 3.14 د C# دا چ یە؟',
        'quiz_options_so' => ['double', 'int', 'char', 'bool'],
        'quiz_options_ba' => ['double', 'int', 'char', 'bool'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'بیرکاری و ئۆپێراتۆرەکان',
        'title_ba' => 'بیرکاری و ئۆپێراتۆر',
        'content_so' => '<p>C# هەموو ئۆپێراتۆرە بیرکارییەکان پشتگیری دەکات:</p><pre>int a = 10;\nint b = 4;\n\nConsole.WriteLine(a + b);   // 14 کۆکردنەوە\nConsole.WriteLine(a - b);   // 6 کەمکردنەوە\nConsole.WriteLine(a * b);   // 40 زۆرکردن\nConsole.WriteLine(a / b);   // 2 دابەشکردن (تەواو)\nConsole.WriteLine(a % b);   // 2 پاشماوە</pre><p>بە بیر بێت: دابەشکردنی دوو <code>int</code> لە C# هەمیشە <code>int</code> دەگەڕێنێتەوە — کەرتی لۆییەکە فڕ دەدرێت. بۆ ئەنجامی لۆیی دەبێت <code>double</code> بەکاربهێنیت.</p>',
        'content_ba' => '<p>C# هەمی ئۆپێراتۆرێن بیرکاری پشتگیر دکەت:</p><pre>int a = 10;\nint b = 4;\n\nConsole.WriteLine(a + b);   // 14 کومکرن\nConsole.WriteLine(a - b);   // 6 کێمکرن\nConsole.WriteLine(a * b);   // 40 زێدەکرن\nConsole.WriteLine(a / b);   // 2 پارڤەکرن (تەمام)\nConsole.WriteLine(a % b);   // 2 پاشمایە</pre><p>د بیرا خۆدا گریت: پارڤەکرنا دوو <code>int</code> د C# دا هەردیم <code>int</code> ڤەدگەڕیت — بەشا لۆیی هەلگریت دبیت. بو دەرئەنجامێ لۆیی دڤێت <code>double</code> بکاربینی.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int a = 10;
        int b = 4;

        Console.WriteLine(a + b);
        Console.WriteLine(a - b);
        Console.WriteLine(a * b);
        Console.WriteLine(a / b);
        Console.WriteLine(a % b);
    }
}',
        'example_output' => '14
6
40
2
2',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە C# ئەنجامی 10 / 3 دەبێتە چەند (هەردووکیان int)؟',
        'quiz_question_ba' => 'د C# دا دەرئەنجامێ 10 / 3 دبیتە چەند (هەردوو int)؟',
        'quiz_options_so' => ['3', '3.33', '4', '1'],
        'quiz_options_ba' => ['3', '3.33', '4', '1'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>بە <code>if</code> و <code>else</code> بەرنامەکەت بڕیار دەدات:</p><pre>int score = 85;\n\nif (score >= 50) {\n    Console.WriteLine("Bêşar!");\n} else {\n    Console.WriteLine("Caw!");\n}</pre><p>ئۆپێراتۆرەکانی بەراوردکردن: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. لۆژیکی: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'content_ba' => '<p>پێ <code>if</code> و <code>else</code> بەرنامەکەت بریار ددەت:</p><pre>int score = 85;\n\nif (score >= 50) {\n    Console.WriteLine("Bêşar!");\n} else {\n    Console.WriteLine("Caw!");\n}</pre><p>ئۆپێراتۆرێن بەراوردکرنێ: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>، <code>&gt;=</code>، <code>&lt;=</code>. لۆژیک: <code>&amp;&amp;</code> (و)، <code>||</code> (یان).</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int score = 85;

        if (score >= 50) {
            Console.WriteLine("Bêşar!");
        } else {
            Console.WriteLine("Caw!");
        }
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
        'content_so' => '<p>C# چەند جۆر خولگەی هەیە — <code>for</code>، <code>foreach</code>، <code>while</code>:</p><pre>// for\nfor (int i = 1; i <= 5; i++) {\n    Console.Write(i + " ");\n}\n\n// while\nint j = 0;\nwhile (j < 3) {\n    Console.WriteLine("Salam " + j);\n    j++;\n}\n\n// foreach - بەسەر ئارای/لیستدا\nstring[] names = { "Kurd", "Arab" };\nforeach (string n in names) {\n    Console.WriteLine(n);\n}</pre><p><code>foreach</code> بە سادەیی بەسەر هەموو ئەندامەکاندا دەسوڕێتەوە بەبێ ئیندێکس.</p>',
        'content_ba' => '<p>C# چەند چەشن گەڕخستنێ هەن — <code>for</code>، <code>foreach</code>، <code>while</code>:</p><pre>// for\nfor (int i = 1; i <= 5; i++) {\n    Console.Write(i + " ");\n}\n\n// while\nint j = 0;\nwhile (j < 3) {\n    Console.WriteLine("Salam " + j);\n    j++;\n}\n\n// foreach - بسەر ئارای/لیستێ دا\nstring[] names = { "Kurd", "Arab" };\nforeach (string n in names) {\n    Console.WriteLine(n);\n}</pre><p><code>foreach</code> ب ساداهی بسەر هەمی ئەندامان دا دگەڕیت بێ ئیندێکس.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        for (int i = 1; i <= 5; i++) {
            Console.Write(i + " ");
        }
        Console.WriteLine();
    }
}',
        'example_output' => '1 2 3 4 5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'خولگەی for (int i=1; i<=5; i++) چەند جار تکرار دەبێتەوە؟',
        'quiz_question_ba' => 'گەڕخستنا for (int i=1; i<=5; i++) چەند جاران دوبارە دبیت؟',
        'quiz_options_so' => ['5 جار', '4 جار', '6 جار', '3 جار'],
        'quiz_options_ba' => ['5 جاران', '4 جاران', '6 جاران', '3 جاران'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکان (Methods)',
        'title_ba' => 'فەنکشن (Methods)',
        'content_so' => '<p>لە C# فەنکشن بە <code>method</code> ناسراوە. جۆری گەڕانەوە، ناو و پێکهاتەکان دیاری دەکەیت:</p><pre>static int Add(int a, int b) {\n    return a + b;\n}\n\nstatic void Main() {\n    int sum = Add(5, 3);\n    Console.WriteLine("Sum = " + sum);   // Sum = 8\n}</pre><p><code>static</code> واتە دەتوانیت لە <code>Main</code>ەوە بانگی بکەیت بەبێ دروستکردنی ئۆبجێکت. <code>void</code> ئەو فەنکشنانەیە کە هیچ ناگەڕێننەوە.</p>',
        'content_ba' => '<p>د C# دا فەنکشن پێ <code>method</code> ناڤدارە. چەشنا ڤەگەڕاندنێ، ناڤ و پارامەتران دیاری دکەی:</p><pre>static int Add(int a, int b) {\n    return a + b;\n}\n\nstatic void Main() {\n    int sum = Add(5, 3);\n    Console.WriteLine("Sum = " + sum);   // Sum = 8\n}</pre><p><code>static</code> واتە تۆ دکەی ژ <code>Main</code> بانگ بکی بێ دروستکرنا ئۆبجێکتێ. <code>void</code> ئەو فەنکشنانەن کو هیچ ڤەناگەڕینن.</p>',
        'code' => 'using System;

class Program {
    static int Add(int a, int b) {
        return a + b;
    }

    static void Main() {
        int sum = Add(5, 3);
        Console.WriteLine("Sum = " + sum);
    }
}',
        'example_output' => 'Sum = 8',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی Add(6, 7) دەبێتە چەند؟',
        'quiz_question_ba' => 'دەرئەنجامێ Add(6, 7) دبیتە چەند؟',
        'quiz_options_so' => ['13', '42', '67', '14'],
        'quiz_options_ba' => ['13', '42', '67', '14'],
        'quiz_correct' => '1',
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارایەکان و لیست',
        'title_ba' => 'ئارای و لیست',
        'content_so' => '<p><strong>ئارای (Array)</strong> قەبارەیەکی دیاریکراوە، بەڵام <strong>List</strong> دەتوانێت گەورە ببێت. ئیندێکس لە <strong>٠</strong> دەست پێ دەکات:</p><pre>int[] numbers = { 10, 20, 30 };     // ئارای\nConsole.WriteLine(numbers[0]);      // 10\nConsole.WriteLine(numbers.Length);  // 3\n\n// List - داینامیک\nList&lt;string&gt; langs = new List&lt;string&gt;() { "Kurd", "Arab" };\nlangs.Add("Turk");                  // زیادکردن\nConsole.WriteLine(langs.Count);     // 3</pre><p><code>List</code> لە <code>System.Collections.Generic</code> دێت — بۆ زانیارییەکانی قەبارە نەزانراو زۆر باشە.</p>',
        'content_ba' => '<p><strong>ئارای (Array)</strong> قەبارەکا دیاریکراوە، بەلێ <strong>List</strong> دکەی مەزن بیت. ئیندێکس ژ <strong>٠</strong> دەست پێ دکەت:</p><pre>int[] numbers = { 10, 20, 30 };     // ئارای\nConsole.WriteLine(numbers[0]);      // 10\nConsole.WriteLine(numbers.Length);  // 3\n\n// List - داینامیک\nList&lt;string&gt; langs = new List&lt;string&gt;() { "Kurd", "Arab" };\nlangs.Add("Turk");                  // زێدەکرن\nConsole.WriteLine(langs.Count);     // 3</pre><p><code>List</code> ژ <code>System.Collections.Generic</code> تیت — بو زانیارییێن کو قەبارە نەزانرایە زۆر باشە.</p>',
        'code' => 'using System;
using System.Collections.Generic;

class Program {
    static void Main() {
        List<string> langs = new List<string>() { "Kurd", "Arab", "Turk" };

        foreach (string l in langs) {
            Console.WriteLine(l);
        }
    }
}',
        'example_output' => 'Kurd
Arab
Turk',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە کام فەنکشن شتێک زیاد دەکەیت بۆ List لە C#؟',
        'quiz_question_ba' => 'پێ کا فەنکشن تیشتەک زێدە دکەی بو List د C# دا؟',
        'quiz_options_so' => ['Add()', 'push()', 'append()', 'insert()'],
        'quiz_options_ba' => ['Add()', 'push()', 'append()', 'insert()'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 8,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'دەقەکان (Strings)',
        'title_ba' => 'نڤیسین (Strings)',
        'content_so' => '<p>دەقی <code>string</code> لە C# فەنکشنی زۆری هەیە:</p><pre>string city = "Hewlêr";\n\ncity.Length;             // 6 ژمارەی پیتەکان\ncity.ToUpper();          // HEWLÊR\ncity.ToLower();          // hewlêr\ncity.Contains("Hew");    // true\ncity[0];                 // H\ncity.Substring(0, 3);    // Hew\n\n// Interpolation - دەقێک کە گۆڕاو تێدایە\nstring msg = $"Salam, {city}!";</pre><p><bdi>String interpolation</bdi> بە <code>$"..."</code> و <code>{...}</code> گۆڕاو دەخاتە ناو دەق — سادەتر لە <code>+</code>.</p>',
        'content_ba' => '<p>نڤیسینا <code>string</code> د C# دا فەنکشنێن زاف هەن:</p><pre>string city = "Hewlêr";\n\ncity.Length;             // 6 ژمارا پیتان\ncity.ToUpper();          // HEWLÊR\ncity.ToLower();          // hewlêr\ncity.Contains("Hew");    // true\ncity[0];                 // H\ncity.Substring(0, 3);    // Hew\n\n// Interpolation - نڤیسینەکا کو گۆڕۆک تێدایە\nstring msg = $"Salam, {city}!";</pre><p><bdi>String interpolation</bdi> پێ <code>$"..."</code> و <code>{...}</code> گۆڕۆک دخی د ناڤ نڤیسینێ — سادەتر ژ <code>+</code>.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        string city = "Hewlêr";
        string country = "Kurdistan";

        Console.WriteLine($"Salam, {city}!");
        Console.WriteLine(country.ToUpper());
    }
}',
        'example_output' => 'Salam, Hewlêr!
KURDISTAN',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بە .Length ژمارەی پیتەکانی "Kurdistan" دەبێتە چەند؟',
        'quiz_question_ba' => 'پێ .Length ژمارا پیتێن "Kurdistan" دبیتە چەند؟',
        'quiz_options_so' => ['9', '8', '10', '7'],
        'quiz_options_ba' => ['9', '8', '10', '7'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 9,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکانی دەق (ToUpper / Length / Contains)',
        'title_ba' => 'فەنکشنێن نڤیسینێ (ToUpper / Length / Contains)',
        'content_so' => '<p>زۆر فەنکشن لەسەر دەقی <code>string</code> هەیە:</p><pre>string word = "Kurdistan";\n\nword.Length;                // 9\nword.ToUpper();             // KURDISTAN\nword.ToLower();             // kurdistan\nword.Contains("Kur");       // True</pre><p><code>Contains</code> دەگەڕێتەوە بۆ ئەوەی ئایا دەقەکە بەشێکی تێدایە یان نا — دەرئەنجام <code>True</code> یان <code>False</code>.</p>',
        'content_ba' => '<p>زاف فەنکشن لسەر نڤیسینا <code>string</code> هەن:</p><pre>string word = "Kurdistan";\n\nword.Length;                // 9\nword.ToUpper();             // KURDISTAN\nword.ToLower();             // kurdistan\nword.Contains("Kur");       // True</pre><p><code>Contains</code> ڤەدگەڕیت ئەر نڤیسینێ بەشەک تێدا یە یا نا — دەرئەنجام <code>True</code> یان <code>False</code>.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        string word = "Kurdistan";
        Console.WriteLine(word.Length);
        Console.WriteLine(word.ToUpper());
        Console.WriteLine(word.Contains("Kur"));
        Console.WriteLine(word.Contains("Zagros"));
    }
}',
        'example_output' => '9
KURDISTAN
True
False',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی "Kurdistan".Contains("Zagros") چییە؟',
        'quiz_question_ba' => 'دەرئەنجامێ "Kurdistan".Contains("Zagros") چ یە؟',
        'quiz_options_so' => ['True', 'False', 'Zagros', 'Kurdistan'],
        'quiz_options_ba' => ['True', 'False', 'Zagros', 'Kurdistan'],
        'quiz_correct' => '1',
    ],
    [
        'order' => 10,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەقی فەرمول (String Interpolation)',
        'title_ba' => 'نڤیسینا فورمولێ (String Interpolation)',
        'content_so' => '<p>بە <bdi>string interpolation</bdi> گۆڕاو بە سادەیی دەخەیتە ناو دەق:</p><pre>string name = "Hêvîn";\nint age = 25;\n\nstring msg = $"Nav: {name}, Temen: {age}";\nConsole.WriteLine(msg);</pre><p>ئەو دەقەی لە نێوان <code>{...}</code> دایە بە نرخەکەی گۆڕاوەکە دەگۆڕدرێت. پێش دەقەکە <code>$</code> دابنێ — بەبێ ئەو، C# بە سادەیی نووسییەکە دەچاپێت.</p>',
        'content_ba' => '<p>پێ <bdi>string interpolation</bdi> گۆڕۆک ب ساداهی دخی د ناڤ نڤیسینێ:</p><pre>string name = "Hêvîn";\nint age = 25;\n\nstring msg = $"Nav: {name}, Temen: {age}";\nConsole.WriteLine(msg);</pre><p>ئەو نڤیسینا د ناڤ <code>{...}</code> دا یە پێ نرخێ گۆڕۆکێ دگۆڕیت. بەر نڤیسینێ <code>$</code> دانی — بێ ئێ، C# ب ساداهی تێکست چاپ دکەت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        string name = "Hêvîn";
        int age = 25;
        string msg = $"Nav: {name}, Temen: {age}";
        Console.WriteLine(msg);
    }
}',
        'example_output' => 'Nav: Hêvîn, Temen: 25',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بۆ string interpolation کام نیشانە بەکار دەهێنیت؟',
        'quiz_question_ba' => 'بو string interpolation کا نیشانە بکار دبینی؟',
        'quiz_options_so' => ['$"{name}"', '+', '&', '#'],
        'quiz_options_ba' => ['$"{name}"', '+', '&', '#'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 11,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'if / else if / else',
        'title_ba' => 'if / else if / else',
        'content_so' => '<p>بە <code>else if</code> زنجیرەیەک مەرج بەسەر یەکتردا دەبڕی — ئەگەر مەرجێک <code>true</code> بوو، بەشەکانی دیکە دەوریان نایەت:</p><pre>int grade = 85;\n\nif (grade >= 90) {\n    Console.WriteLine("A");\n} else if (grade >= 75) {\n    Console.WriteLine("B");\n} else {\n    Console.WriteLine("C");\n}</pre><p>یەکەم مەرجی ڕاست بەشەکەی خۆی جێبەجێ دەکات و پاشان بەرنامەکە لە زنجیرەکە دەردەچێت.</p>',
        'content_ba' => '<p>پێ <code>else if</code> زنجیرەیەک مەرج لسەر هەڤدا دهەورن — گەر مەرجەک <code>true</code> بیت، بەشێن دی ڤەدگەڕن:</p><pre>int grade = 85;\n\nif (grade >= 90) {\n    Console.WriteLine("A");\n} else if (grade >= 75) {\n    Console.WriteLine("B");\n} else {\n    Console.WriteLine("C");\n}</pre><p>مەرجێ یەکێ راست بەشێ خو ئەنجام ددەت و پاشی بەرنامە ژ زنجیرێ دەرکەفت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int grade = 85;

        if (grade >= 90) {
            Console.WriteLine("A");
        } else if (grade >= 75) {
            Console.WriteLine("B");
        } else {
            Console.WriteLine("C");
        }
    }
}',
        'example_output' => 'B',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەگەر grade=80 بووایە لە کۆدی سەرەوە چی چاپ دەکرا؟',
        'quiz_question_ba' => 'گەر grade=80 بیت د کۆدی جۆر دا چ چاپ دبیت؟',
        'quiz_options_so' => ['B', 'A', 'C', '80'],
        'quiz_options_ba' => ['B', 'A', 'C', '80'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 12,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'مەرجی switch',
        'title_ba' => 'مەرجێ switch',
        'content_so' => '<p><code>switch</code> یەک گۆڕاو لەگەڵ چەند بەهای جیاواز دەبڕی:</p><pre>int day = 3;\n\nswitch (day) {\n    case 1:\n        Console.WriteLine("Duşem");\n        break;\n    case 2:\n        Console.WriteLine("Sêşem");\n        break;\n    case 3:\n        Console.WriteLine("Çarşem");\n        break;\n    default:\n        Console.WriteLine("Nenas");\n        break;\n}</pre><p>هەر <code>case</code> دەبێت بە <code>break</code> کۆتایی بێت. ئەگەر هیچ <code>case</code> نەگونجی، <code>default</code> جێبەجێ دەبێت.</p>',
        'content_ba' => '<p><code>switch</code> گۆڕۆکەک پێ چەند نرها جودا هەوراند دکەت:</p><pre>int day = 3;\n\nswitch (day) {\n    case 1:\n        Console.WriteLine("Duşem");\n        break;\n    case 2:\n        Console.WriteLine("Sêşem");\n        break;\n    case 3:\n        Console.WriteLine("Çarşem");\n        break;\n    default:\n        Console.WriteLine("Nenas");\n        break;\n}</pre><p>هەر <code>case</code> دڤێت پێ <code>break</code> بدۆمهێت. گەر هیچ <code>case</code> نەگونجیت، <code>default</code> تەتەبێ دبیت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int day = 3;

        switch (day) {
            case 1:
                Console.WriteLine("Duşem");
                break;
            case 2:
                Console.WriteLine("Sêşem");
                break;
            case 3:
                Console.WriteLine("Çarşem");
                break;
            default:
                Console.WriteLine("Nenas");
                break;
        }
    }
}',
        'example_output' => 'Çarşem',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەگەر day=5 بووایە لە switch ئەوە چی چاپ دەکرا؟',
        'quiz_question_ba' => 'گەر day=5 بیت د switch دا چ چاپ دبیت؟',
        'quiz_options_so' => ['Nenas', 'Duşem', 'Çarşem', 'Sêşem'],
        'quiz_options_ba' => ['Nenas', 'Duşem', 'Çarşem', 'Sêşem'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 13,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی while',
        'title_ba' => 'گەڕخستنا while',
        'content_so' => '<p><code>while</code> خولگەیەکە تاکوو مەرجەکەی <code>true</code> بێت بەردەوام دەبێت:</p><pre>int count = 1;\n\nwhile (count <= 5) {\n    Console.WriteLine(count);\n    count++;\n}</pre><p>مەرج لە سەرەتاوە دەبڕدرێت — ئەگەر هەرگیز <code>true</code> نەبوو، خولگەکە هیچ جارێک ناخوڕێتەوە. ئاگادار بە: بەبێ <code>count++</code> خولگەکە هەرگیز کۆتایی نایەت.</p>',
        'content_ba' => '<p><code>while</code> گەڕخستنەکە تاکوو مەرجەکێ وێ <code>true</code> بیت بردمە بیت:</p><pre>int count = 1;\n\nwhile (count <= 5) {\n    Console.WriteLine(count);\n    count++;\n}</pre><p>مەرج ژ دەستپێکە دا دهەوریت — گەر هەرگیز <code>true</code> نەبیت، گەڕخستن چ جاران ناگەڕیت. هۆشیار بە: بێ <code>count++</code> گەڕخستن هەرگیز ناڤسێت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int count = 1;

        while (count <= 5) {
            Console.WriteLine(count);
            count++;
        }
    }
}',
        'example_output' => '1
2
3
4
5',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە کۆدی سەرەوە دوایین ژمارەی چاپکراو چییە؟',
        'quiz_question_ba' => 'د کۆدی جۆر دا ژمارا پاشین چاپکرای چ یە؟',
        'quiz_options_so' => ['5', '4', '6', '1'],
        'quiz_options_ba' => ['5', '4', '6', '1'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 14,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی do-while',
        'title_ba' => 'گەڕخستنا do-while',
        'content_so' => '<p><code>do-while</code> بەلایەنی کەم جارێک کار دەکات، پاشان مەرج دەبڕدرێت:</p><pre>int count = 1;\n\ndo {\n    Console.WriteLine(count);\n    count++;\n} while (count <= 3);</pre><p>جیاوازی لەگەڵ <code>while</code>: مەرج لە کۆتاییدا دەبڕدرێت. بۆیە تەنانەت ئەگەر مەرج لە سەرەتاوە <code>false</code> بوو، کۆدی ناوەوە جارێک دەخوڕێتەوە.</p>',
        'content_ba' => '<p><code>do-while</code> ب کێمترین چ جاران کار دکەت، پاشی مەرج دهەوریت:</p><pre>int count = 1;\n\ndo {\n    Console.WriteLine(count);\n    count++;\n} while (count <= 3);</pre><p>جودایی ژ <code>while</code>: مەرج د دەمە دەراهی دا دهەوریت. بۆ وێ تەخت گەر مەرج ژ دەستپێکێ <code>false</code> بیت، کۆدی ناڤێ جارەک دگەڕیت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int count = 1;

        do {
            Console.WriteLine(count);
            count++;
        } while (count <= 3);
    }
}',
        'example_output' => '1
2
3',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'جیاوازی سەرەکی do-while لەگەڵ while چییە؟',
        'quiz_question_ba' => 'جوداییا سەرەکی do-while ژ while چ یە؟',
        'quiz_options_so' => ['کەمترین جارێک کار دەکات', 'مەرج لە سەرەتادایە', 'هیچ جارێک کار ناکات', 'بەس بۆ خولگەیە'],
        'quiz_options_ba' => ['کێمترین چ جاران کار دکەت', 'مەرج د دەستپێکێ دا یە', 'چ جاران کار ناکەت', 'تەنێ بو گەڕخستنە'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 15,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی for',
        'title_ba' => 'گەڕخستنا for',
        'content_so' => '<p><code>for</code> خولگەیەکە بە سی بەش: دەستپێک، مەرج، گەشەکردن:</p><pre>for (int i = 0; i < 4; i++) {\n    Console.WriteLine("Item " + i);\n}</pre><p>لێرە <code>i</code> لە <code>0</code> دەست پێ دەکات، تاکوو <code>4</code> (بەبێ 4) بەردەوامە، و هەموو جارێک بە <code>i++</code> زیاد دەبێت.</p>',
        'content_ba' => '<p><code>for</code> گەڕخستنەکە ب سێ بەش: دەستپێک، مەرج، مەزنکرن:</p><pre>for (int i = 0; i < 4; i++) {\n    Console.WriteLine("Item " + i);\n}</pre><p>لڤێرە <code>i</code> ژ <code>0</code> دەست پێ دکەت، هەتا <code>4</code> (بێ 4) بردمە دبیت، و هەر جار پێ <code>i++</code> مەزن دبیت.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        for (int i = 0; i < 4; i++) {
            Console.WriteLine("Item " + i);
        }
    }
}',
        'example_output' => 'Item 0
Item 1
Item 2
Item 3',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'for (int i=0; i<4; i++) چەند جار دەخوڕێتەوە؟',
        'quiz_question_ba' => 'for (int i=0; i<4; i++) چەند جاران دگەڕیت؟',
        'quiz_options_so' => ['4 جار', '3 جار', '5 جار', '0 جار'],
        'quiz_options_ba' => ['4 جاران', '3 جاران', '5 جاران', '0 جاران'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 16,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی foreach',
        'title_ba' => 'گەڕخستنا foreach',
        'content_so' => '<p><code>foreach</code> بەسەر هەموو ئەندامەکانی لیست یان ئارایدا دەسوڕێتەوە بەبێ ئیندێکس:</p><pre>string[] cities = { "Hewlêr", "Silêmanî", "Duhok" };\n\nforeach (string c in cities) {\n    Console.WriteLine(c);\n}</pre><p>لە هەر گەڕێکدا <code>c</code> یەک ئەندام دەگرێت — سادەترین ڕێگای پێداچوونەوە بە لیست.</p>',
        'content_ba' => '<p><code>foreach</code> بسەر هەمی ئەندامێن لیست یا ئارای دا دگەڕیت بێ ئیندێکس:</p><pre>string[] cities = { "Hewlêr", "Silêmanî", "Duhok" };\n\nforeach (string c in cities) {\n    Console.WriteLine(c);\n}</pre><p>د هەر گەڕێ دا <code>c</code> ئەندامەک دگریت — سادەترین ڕێکا ڤەکوڵینا لیستێ.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        string[] cities = { "Hewlêr", "Silêmanî", "Duhok" };

        foreach (string c in cities) {
            Console.WriteLine(c);
        }
    }
}',
        'example_output' => 'Hewlêr
Silêmanî
Duhok',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە هەر گەڕێکی foreach، گۆڕاوەکەی ناوەوە چی دەگرێتەوە؟',
        'quiz_question_ba' => 'د هەر گەڕێکی foreach دا، گۆڕۆکێ ناڤێ چ دگریت؟',
        'quiz_options_so' => ['یەک ئەندام', 'هەموو ئەندامەکان', 'ئیندێکس', 'تەنیا یەکەم ئەندام'],
        'quiz_options_ba' => ['ئەندامەک', 'هەمی ئەندام', 'ئیندێکس', 'تەنێ ئەندامێ یەکێ'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 17,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارای int و Sort',
        'title_ba' => 'ئارای int و Sort',
        'content_so' => '<p><code>Array.Sort()</code> ئارایەک ڕیز دەکات و <code>Length</code> ژمارەی ئەندامەکان دەگەڕێنێتەوە:</p><pre>int[] numbers = { 30, 10, 20 };\n\nArray.Sort(numbers);\nConsole.WriteLine(numbers[0]);                  // 10\nConsole.WriteLine(numbers[numbers.Length - 1]); // 30</pre><p>دوای Sort ئەندامی یەکەم بچووکترینە و دوایین ئەندام (<code>Length - 1</code>) گەورەترینە.</p>',
        'content_ba' => '<p><code>Array.Sort()</code> ئارایەک ریز دکەت و <code>Length</code> ژمارا ئەندامان ڤەدگەڕیت:</p><pre>int[] numbers = { 30, 10, 20 };\n\nArray.Sort(numbers);\nConsole.WriteLine(numbers[0]);                  // 10\nConsole.WriteLine(numbers[numbers.Length - 1]); // 30</pre><p>پشی Sort ئەندامێ یەکێ بچووکترینە و ئەندامێ پاشین (<code>Length - 1</code>) مەزنترینە.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int[] numbers = { 30, 10, 20 };

        Array.Sort(numbers);
        Console.WriteLine(numbers[0]);
        Console.WriteLine(numbers[numbers.Length - 1]);
    }
}',
        'example_output' => '10
30',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'دوای Array.Sort(numbers) ئەندامی یەکەمی ئارایەکە چی دەبێت؟',
        'quiz_question_ba' => 'پشی Array.Sort(numbers) ئەندامێ یەکێ ئارایەکە چ دبیت؟',
        'quiz_options_so' => ['بچووکترین', 'گەورەترین', 'هەمان', 'سفر'],
        'quiz_options_ba' => ['بچووکترین', 'مەزنترین', 'هەمان', 'سفر'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 18,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشن بە return',
        'title_ba' => 'فەنکشن پێ return',
        'content_so' => '<p>فەنکشن دەتوانێت دەرئەنجامێک <strong>بگەڕێنێتەوە</strong> بە <code>return</code>:</p><pre>static int Square(int x) {\n    return x * x;\n}\n\nstatic void Main() {\n    Console.WriteLine(Square(5));   // 25\n    Console.WriteLine(Square(7));   // 49\n}</pre><p>جۆری گەڕانەوە لەبەردەم ناوی فەنکشنە: لێرە <code>int</code>. کۆدی دوای <code>return</code> جێبەجێ نابێت.</p>',
        'content_ba' => '<p>فەنکشن دکەی دەرئەنجامەک <strong>ڤەگەڕیت</strong> پێ <code>return</code>:</p><pre>static int Square(int x) {\n    return x * x;\n}\n\nstatic void Main() {\n    Console.WriteLine(Square(5));   // 25\n    Console.WriteLine(Square(7));   // 49\n}</pre><p>چەشنا ڤەگەڕاندنێ بەر ناڤێ فەنکشنێ: لڤێرە <code>int</code>. کۆدێ پشی <code>return</code> ئەنجام نابیت.</p>',
        'code' => 'using System;

class Program {
    static int Square(int x) {
        return x * x;
    }

    static void Main() {
        Console.WriteLine(Square(5));
        Console.WriteLine(Square(7));
    }
}',
        'example_output' => '25
49',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی Square(6) دەبێتە چەند؟',
        'quiz_question_ba' => 'دەرئەنجامێ Square(6) دبیتە چەند؟',
        'quiz_options_so' => ['36', '12', '66', '6'],
        'quiz_options_ba' => ['36', '12', '66', '6'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 19,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'Method Overload',
        'title_ba' => 'Method Overload',
        'content_so' => '<p><strong>Method overload</strong> — دوو فەنکشن بە هەمان ناو بەڵام جۆر یان ژمارەی جیاوازی پارامەتر:</p><pre>static int Add(int a, int b) {\n    return a + b;\n}\n\nstatic double Add(double a, double b) {\n    return a + b;\n}</pre><p>C# بەپێی جۆر و ژمارەی ئەرگۆمێنتەکان دەزانێت کامیان بانگ بکات.</p>',
        'content_ba' => '<p><strong>Method overload</strong> — دوو فەنکشن ب هەمان ناڤ بەلێ چەشن یا ژمارا جودا یا پارامەتران:</p><pre>static int Add(int a, int b) {\n    return a + b;\n}\n\nstatic double Add(double a, double b) {\n    return a + b;\n}</pre><p>C# بپێی چەشنا و ژمارا ئەرگومێنتان دزانیت کا کاڤان بانگ بکەت.</p>',
        'code' => 'using System;

class Program {
    static int Add(int a, int b) {
        return a + b;
    }

    static double Add(double a, double b) {
        return a + b;
    }

    static void Main() {
        Console.WriteLine(Add(3, 4));
        Console.WriteLine(Add(2.5, 1.5));
    }
}',
        'example_output' => '7
4',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە overload، C# چۆن فەنکشنە دروستەکە هەڵدەبژێرێت؟',
        'quiz_question_ba' => 'د overload دا، C# چاوا فەنکشنێ راست هەلبژێرت؟',
        'quiz_options_so' => ['بەپێی جۆر و ژمارەی پارامەتر', 'بەپێی ناوەکە بەتەنیا', 'هەمیشە یەکەم', 'بەپێی ئەلفوبێ'],
        'quiz_options_ba' => ['بپێی چەشنا و ژمارا پارامەتران', 'بپێی ناڤی ب تەنیا', 'هەردیم یەکێ', 'بپێی ئەلفوبێ'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 20,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'کلاس و پڕۆپەرتی',
        'title_ba' => 'کلاس و پڕۆپەرتی',
        'content_so' => '<p><strong>کلاس</strong> نموونەیەکە بۆ دروستکردنی ئۆبجێکت و <strong>پڕۆپەرتی</strong> زانیاری تێدەخات:</p><pre>class Person {\n    public string Name { get; set; }\n    public int Age { get; set; }\n}\n\nPerson p = new Person();\np.Name = "Azad";\np.Age = 30;</pre><p><code>{ get; set; }</code> واتە دەکرێت بخوێنرێتەوە (get) و بنووسرێت (set).</p>',
        'content_ba' => '<p><strong>کلاس</strong> نموونەیەکا یە بو دروستکرنا ئۆبجێکتی و <strong>پڕۆپەرتی</strong> زانیاری تێدا دخی:</p><pre>class Person {\n    public string Name { get; set; }\n    public int Age { get; set; }\n}\n\nPerson p = new Person();\np.Name = "Azad";\np.Age = 30;</pre><p><code>{ get; set; }</code> واتە دکەیت بخوێنی (get) و بنڤیسی (set).</p>',
        'code' => 'using System;

class Person {
    public string Name { get; set; }
    public int Age { get; set; }
}

class Program {
    static void Main() {
        Person p = new Person();
        p.Name = "Azad";
        p.Age = 30;
        Console.WriteLine(p.Name + " - " + p.Age);
    }
}',
        'example_output' => 'Azad - 30',
        'quiz_type' => 'choice',
        'quiz_question_so' => '{ get; set; } لە پڕۆپەرتی چی دەکات؟',
        'quiz_question_ba' => '{ get; set; } د پڕۆپەرتی دا چ دکەت؟',
        'quiz_options_so' => ['دەخوێنرێتەوە و دەنووسرێت', 'تەنیا دەخوێنرێتەوە', 'تەنیا دەنووسرێت', 'هیچ'],
        'quiz_options_ba' => ['دخوێنی و دنڤیسی', 'تەنێ دخوێنی', 'تەنێ دنڤیسی', 'چیشت'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 21,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Constructor (دروستکەر)',
        'title_ba' => 'Constructor (دروستکەر)',
        'content_so' => '<p><strong>Constructor</strong> فەنکشنێکە بە هەمان ناوی کلاس، کە لە کاتی دروستکردنی ئۆبجێکتدا جێبەجێ دەبێت:</p><pre>class Person {\n    public string Name { get; set; }\n\n    public Person(string name) {\n        Name = name;\n    }\n}\n\nPerson p = new Person("Dilan");</pre><p>بەمە بەهاکان لە کاتی دروستکردندا دیاری دەکەیت — کۆدی پاکتر.</p>',
        'content_ba' => '<p><strong>Constructor</strong> فەنکشنەکا پێ هەمان ناڤێ کلاسی، کو د دەمە دروستکرنا ئۆبجێکتی دا تەتەبێ دبیت:</p><pre>class Person {\n    public string Name { get; set; }\n\n    public Person(string name) {\n        Name = name;\n    }\n}\n\nPerson p = new Person("Dilan");</pre><p>پێ ڤێ نرخان د دەمە دروستکرنێ دا دیاری دکەی — کۆدێ پاکتر.</p>',
        'code' => 'using System;

class Person {
    public string Name { get; set; }

    public Person(string name) {
        Name = name;
    }
}

class Program {
    static void Main() {
        Person p = new Person("Dilan");
        Console.WriteLine(p.Name);
    }
}',
        'example_output' => 'Dilan',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ناوی constructor لە C# چییە؟',
        'quiz_question_ba' => 'ناڤێ constructor د C# دا چ یە؟',
        'quiz_options_so' => ['هەمان ناوی کلاسەکە', 'بە پیتی گەورە دەست پێ دەکات', 'Main', 'void'],
        'quiz_options_ba' => ['هەمان ناڤێ کلاسی', 'پێ پیتا مەزن دەست پێ دکەت', 'Main', 'void'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 22,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'بۆماوە (Inheritance)',
        'title_ba' => 'بۆماوە (Inheritance)',
        'content_so' => '<p><strong>بۆماوە</strong> (Inheritance) یەکێکە لە چەمکە سەرەکییەکانی OOP. کلاسێکی مناڵ (subclass) هەموو ئەندامەکانی کلاسی دایک (superclass) بۆماوە دەگرێت — بەمە کۆد دووبارە نابێتەوە و پەیوەندییەکی لۆژیکی لە نێوان کلاسەکاندا دروست دەبێت. لە C# بە نیشانەی <code>:</code> بۆماوە دەکەیت؛ ناوی کلاسی دایک لە پاش <code>:</code> دەنووسیت.</p><p>نموونە:</p><pre>class Animal {\n    public string Name { get; set; }\n\n    public Animal(string name) {\n        Name = name;\n    }\n\n    public void Speak() {\n        Console.WriteLine(Name + " is speaking");\n    }\n}\n\nclass Dog : Animal {\n    public Dog(string name) : base(name) { }\n}\n\nDog d = new Dog("Rex");\nd.Speak();</pre><p>کلاسی <code>Dog</code> بە <code>: Animal</code> هەموو ئەندامەکانی دایک بەکاردەهێنێت بەبێ نووسینەوە: <code>Name</code>، <code>Speak()</code> و constructor. <code>base(name)</code> بانگی constructor ی دایک دەکات تاکوو ناوەکە دیاری بکرێت. ئەمە گرنگە چونکە هەر گۆڕانکارییەک لە کلاسی دایکدا خۆکارانە بۆ هەموو مناڵەکان دەگوازرێتەوە — لە جیاتی نووسینەوەی کۆد لە هەموو کلاسێکدا، جارێک لە دایکدا دەنووسیت و لە هەموو جیادا دەردەکەوێت.</p>',
        'content_ba' => '<p><strong>بۆماوە</strong> (Inheritance) یەکە ژ چەمکێن سەرەکی یێن OOP. کلاسەکا زارووک (subclass) هەمی ئەندامێن کلاسێ دایک (superclass) بۆماوە دگریت — بمە کۆد دوبارە نابیت و پەیوەندییەکا لۆژیک د ناڤ کلاسان دا دەردکەفت. د C# دا پێ نیشانەیا <code>:</code> بۆماوە دکەی؛ ناڤێ کلاسێ دایک پشی <code>:</code> دنڤیسی.</p><p>نموونە:</p><pre>class Animal {\n    public string Name { get; set; }\n\n    public Animal(string name) {\n        Name = name;\n    }\n\n    public void Speak() {\n        Console.WriteLine(Name + " is speaking");\n    }\n}\n\nclass Dog : Animal {\n    public Dog(string name) : base(name) { }\n}\n\nDog d = new Dog("Rex");\nd.Speak();</pre><p>کلاسێ <code>Dog</code> پێ <code>: Animal</code> هەمی ئەندامێن دایک بکارتیت بێ نڤیسینا دوبارە: <code>Name</code>، <code>Speak()</code> و constructor. <code>base(name)</code> بانگەکرنا constructor ی دایک دکەت داکو ناڤ دیاری بیت. ئەڤە گرنگە ژبەر کو هەر گۆڕینەک د کلاسێ دایک دا ب خۆبەری هەمی زارووکان ڤەدگەڕیت — ل جیهاتا نڤیسینا کۆدی دوبارە د هەمی کلاسان دا، جارەک د دایک دا دنڤیسی و د هەمی جیهان دا دەردکەفت.</p>',
        'code' => 'using System;

class Animal {
    public string Name { get; set; }

    public Animal(string name) {
        Name = name;
    }

    public void Speak() {
        Console.WriteLine(Name + " is speaking");
    }
}

class Dog : Animal {
    public Dog(string name) : base(name) { }
}

class Program {
    static void Main() {
        Dog d = new Dog("Rex");
        d.Speak();
        Console.WriteLine(d.Name);
    }
}',
        'example_output' => 'Rex is speaking
Rex',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە C#، بۆ بۆماوە کام نیشانە بەکار دەهێنیت؟',
        'quiz_question_ba' => 'د C# دا، بو بۆماوەیێ کا نیشانە بکار دبینی؟',
        'quiz_options_so' => [':', '+', '=', '->'],
        'quiz_options_ba' => [':', '+', '=', '->'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 23,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پۆلیمۆرفیزم (virtual / override)',
        'title_ba' => 'پۆلیمۆرفیزم (virtual / override)',
        'content_so' => '<p><strong>پۆلیمۆرفیزم</strong> (Polymorphism) واتە هەمان بانگکردن دەرئەنجامی جیاواز لە کلاسە جیاوازەکان دەدات. بە <code>virtual</code> فەنکشنێکی کلاسی دایک دیاری دەکەیت کە دەتوانرێت لە مناڵ بگۆڕدرێت، و بە <code>override</code> لە کلاسی مناڵ جێبەجێی تایبەتی خۆت دەکەیت.</p><p>نموونە:</p><pre>class Animal {\n    public virtual void MakeSound() {\n        Console.WriteLine("Animal sound");\n    }\n}\n\nclass Cat : Animal {\n    public override void MakeSound() {\n        Console.WriteLine("Miyao");\n    }\n}\n\nAnimal a = new Cat();\na.MakeSound();</pre><p>لێرە جۆری گۆڕاوەکە <code>Animal</code>ە بەڵام ئۆبجێکتەکە <code>Cat</code>ە — بۆیە کۆدی <code>Cat</code> جێبەجێ دەبێت نەک کۆدی دایک. ئەمە بە <code>virtual</code> و <code>override</code> دەستدەکەوێت. بەبێ <code>virtual</code>، بانگکردنەکە بەپێی جۆری گۆڕاوەکە دادەنرێت و هەمیشە کۆدی دایک جێبەجێ دەبێت — ئەمەش جیاوازییە سەرەکییەکەیە کە پێویستە لەبەر بکەیت.</p>',
        'content_ba' => '<p><strong>پۆلیمۆرفیزم</strong> (Polymorphism) واتە هەمان بانگەکرن دەرئەنجامێ جودا ژ کلاسێن جودا ددەت. پێ <code>virtual</code> فەنکشنەکا کلاسێ دایک دیاری دکەی کو دکەی د زارووک دا بگوریت، و پێ <code>override</code> د کلاسێ زارووک دا تەتەبێیا خو دکەی.</p><p>نموونە:</p><pre>class Animal {\n    public virtual void MakeSound() {\n        Console.WriteLine("Animal sound");\n    }\n}\n\nclass Cat : Animal {\n    public override void MakeSound() {\n        Console.WriteLine("Miyao");\n    }\n}\n\nAnimal a = new Cat();\na.MakeSound();</pre><p>لڤێرە چەشنا گۆڕۆکێ <code>Animal</code>ە بەلێ ئۆبجێکت <code>Cat</code>ە — بۆ وێ کۆدێ <code>Cat</code> تەتەبێ دبیت نەک کۆدێ دایک. ئەڤە پێ <code>virtual</code> و <code>override</code> دەستدکەفت. بێ <code>virtual</code>، بانگەکرن بپێی چەشنا گۆڕۆکێ دبیت و هەردیم کۆدێ دایک تەتەبێ دبیت — ئەڤە جوداییا سەرەکی یە کو دڤێت د بیرا خۆدا بگریت.</p>',
        'code' => 'using System;

class Animal {
    public virtual void MakeSound() {
        Console.WriteLine("Animal sound");
    }
}

class Cat : Animal {
    public override void MakeSound() {
        Console.WriteLine("Miyao");
    }
}

class Program {
    static void Main() {
        Animal a = new Cat();
        a.MakeSound();
    }
}',
        'example_output' => 'Miyao',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'فەنکشنی دایک کە لە مناڵ دەگۆڕدرێت بە کام وشە دیاری دەکرێت؟',
        'quiz_question_ba' => 'فەنکشنێ دایک کو د زارووک دا دگوریت پێ کا پێڤە دیاری دبیت؟',
        'quiz_options_so' => ['virtual', 'static', 'final', 'private'],
        'quiz_options_ba' => ['virtual', 'static', 'final', 'private'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 24,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کلاسی Math',
        'title_ba' => 'کلاسێ Math',
        'content_so' => '<p>کلاسی <code>Math</code> فەنکشنی بیرکاری پێشکەش دەکات:</p><pre>Math.Max(10, 20);     // 20 گەورەترین\nMath.Min(10, 20);     // 10 بچووکترین\nMath.Abs(-7);         // 7 نرخە تەواوەکە\nMath.Pow(2, 3);       // 8 توان\nMath.Sqrt(16);        // 4</pre><p>بۆ بەکارهێنانی <code>Math</code> پێویست بە <code>using</code>ی زیادەی نییە — لە <code>System</code>دایە.</p>',
        'content_ba' => '<p>کلاسێ <code>Math</code> فەنکشنێن بیرکاری پێشکێش دکەت:</p><pre>Math.Max(10, 20);     // 20 مەزنترین\nMath.Min(10, 20);     // 10 بچووکترین\nMath.Abs(-7);         // 7 نرخا تەمام\nMath.Pow(2, 3);       // 8 توان\nMath.Sqrt(16);        // 4</pre><p>بو بکارهینانا <code>Math</code> پێدڤی ب <code>using</code>ا زێدە نینە — د <code>System</code> دا یە.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        Console.WriteLine(Math.Max(10, 20));
        Console.WriteLine(Math.Min(10, 20));
        Console.WriteLine(Math.Abs(-7));
        Console.WriteLine(Math.Pow(2, 3));
    }
}',
        'example_output' => '20
10
7
8',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەنجامی Math.Pow(2, 3) چەندە؟',
        'quiz_question_ba' => 'دەرئەنجامێ Math.Pow(2, 3) چەندە؟',
        'quiz_options_so' => ['8', '6', '9', '23'],
        'quiz_options_ba' => ['8', '6', '9', '23'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 25,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کەپسولکردن (get / set)',
        'title_ba' => 'کەپسولکرن (get / set)',
        'content_so' => '<p><strong>کەپسولکردن</strong> (Encapsulation) داتاکان دەشارێتەوە و تەنیا ڕێگای دیاریکراو بۆ گەیشتن بە ئەندامەکانی کلاس دەدات. بە <code>private</code> ئەندامەکە دەشاریتەوە و بە پڕۆپەرتی لەگەڵ <code>{ get; set; }</code> ڕێگای خوێندنەوە و نووسین دەدەیت.</p><p>نموونە:</p><pre>class Account {\n    private int balance;\n\n    public int Balance {\n        get { return balance; }\n        set { balance = value; }\n    }\n}\n\nAccount acc = new Account();\nacc.Balance = 100;\nConsole.WriteLine(acc.Balance);</pre><p>لێرە ناتوانیت ڕاستەوخۆ بە <code>balance</code> بگەیت — تەنیا لە ڕێگەی پڕۆپەرتی <code>Balance</code>یەوە. گۆڕاوەی <code>value</code> لەناو <code>set</code>دا نرخە نوێیەکە دەگرێت. ئەمە داتاکان لە دەستکاری هەڕەمەکی دەپارێزێت و دەتوانیت لۆژیکی وەک ڕاستکردنەوە زیاد بکەیت لەناو <code>set</code>دا — بۆ نموونە ڕێگە نەدەیت بەهای نەرێنی تۆمار بکرێت.</p>',
        'content_ba' => '<p><strong>کەپسولکرن</strong> (Encapsulation) داتایان دشارتەت و تەنێ ڕێکا دیاریکرای بو گەهشتنا ئەندامێن کلاسی ددەت. پێ <code>private</code> ئەندام دشارتەی و پێ پڕۆپەرتی یا پێ <code>{ get; set; }</code> ڕێکا خواندن و نڤیسینێ ددەی.</p><p>نموونە:</p><pre>class Account {\n    private int balance;\n\n    public int Balance {\n        get { return balance; }\n        set { balance = value; }\n    }\n}\n\nAccount acc = new Account();\nacc.Balance = 100;\nConsole.WriteLine(acc.Balance);</pre><p>لڤێرە ناکەی راستەوخۆ ب <code>balance</code> گەهیی — تەنێ ژ ڕێکا پڕۆپەرتی <code>Balance</code>. گۆڕۆکێ <code>value</code> د ناڤ <code>set</code> دا نرخا نوی دگریت. ئەڤە داتایان ژ دەستکارکرنا هەلەمەت دپارێزیت و دکەی لۆژیکا وەکو ڕاستکرن زێدە بکی د ناڤ <code>set</code> دا — بو نموونە ڕێ نەدەی نرخەکا نێرینی هاتە تۆمارکرن.</p>',
        'code' => 'using System;

class Account {
    private int balance;

    public int Balance {
        get { return balance; }
        set { balance = value; }
    }
}

class Program {
    static void Main() {
        Account acc = new Account();
        acc.Balance = 100;
        Console.WriteLine(acc.Balance);
    }
}',
        'example_output' => '100',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'بۆ شارتنەوەی ئەندامێکی کلاس کام وشە بەکاردەهێنیت؟',
        'quiz_question_ba' => 'بو شارتنەوەیە ئەندامەکا کلاسی کا پێڤە بکار دبینی؟',
        'quiz_options_so' => ['private', 'public', 'static', 'internal'],
        'quiz_options_ba' => ['private', 'public', 'static', 'internal'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 26,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Ternary Operator',
        'title_ba' => 'Ternary Operator',
        'content_so' => '<p><strong>Ternary</strong> کورتکراوەی if/else یە:</p><pre>string msg = (age >= 18) ? "Bêşar" : "Caw";</pre><p>ئەگەر مەرجەکە <code>true</code> بێت ئەنجامی یەکەم دەردەچێت، ئەگینە ئەنجامی دووەم. هەر دوو دەرئەنجام دەبێت هەمان جۆر بن.</p>',
        'content_ba' => '<p><strong>Ternary</strong> کورتکرنەکا if/else یە:</p><pre>string msg = (age >= 18) ? "Bêşar" : "Caw";</pre><p>گەر مەرجەکە <code>true</code> بیت دەرئەنجامێ یەکێ دەرکەفت، نەک دەرئەنجامێ دووێ. هەردوو دەرئەنجام دڤێت هەمان چەشن بن.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int age = 20;
        string msg = (age >= 18) ? "Bêşar" : "Caw";
        Console.WriteLine(msg);
    }
}',
        'example_output' => 'Bêşar',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئەگەر age=16 بووایە ئەنجامی ternary لە سەرەوە چی دەبوو؟',
        'quiz_question_ba' => 'گەر age=16 بیت دەرئەنجامێ ternary ل سەرەڤە چ دبیت؟',
        'quiz_options_so' => ['Caw', 'Bêşar', '16', '18'],
        'quiz_options_ba' => ['Caw', 'Bêşar', '16', '18'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 27,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Interface',
        'title_ba' => 'Interface',
        'content_so' => '<p><strong>Interface</strong> پەیمانێکە (contract) — لیستی فەنکشن دیاری دەکات بەبێ جێبەجێکردن. هەر کلاسێک کە interface ئەکە جێبەجێ بکات، دەبێت هەموو ئەو فەنکشنانە بە شێوەی خۆی بنووسێت. بەمە کۆدی بەشێک جیادەکرێتەوە لە ڕەفتارەکەی.</p><p>نموونە:</p><pre>interface IVehicle {\n    void Start();\n}\n\nclass Car : IVehicle {\n    public void Start() {\n        Console.WriteLine("Car started");\n    }\n}\n\nIVehicle v = new Car();\nv.Start();</pre><p>بە <code>: IVehicle</code> کلاسی <code>Car</code> پەیمانەکە دەبات و دەبێت <code>Start()</code> جێبەجێ بکات. جیاوازی لەگەڵ بۆماوە: کلاسێک لە C# تەنیا یەک دایک دەگرێتەوە، بەڵام چەند interface یەک دەتوانێت جێبەجێ بکات — لەمەوە دەردەچێت چەندین کلاسی جیاواز هەمان پەیمان بگرن و هەمان شێوە بەکاربهێنن.</p>',
        'content_ba' => '<p><strong>Interface</strong> پەیمانەکە یە (contract) — لیستا فەنکشنان دیاری دکەت بێ تەتەبێکرن. هەر کلاسەکا کو interface یی تەتەبێ دکەت، دڤێت هەمی ئەو فەنکشنان پێ شێوەیا خو بنڤیسیت. بمە کۆد ژ رەفتارێ جودا دبیت.</p><p>نموونە:</p><pre>interface IVehicle {\n    void Start();\n}\n\nclass Car : IVehicle {\n    public void Start() {\n        Console.WriteLine("Car started");\n    }\n}\n\nIVehicle v = new Car();\nv.Start();</pre><p>پێ <code>: IVehicle</code> کلاسێ <code>Car</code> پەیمانەکە دگریت و دڤێت <code>Start()</code> تەتەبێ بکەت. جودایی ژ بۆماوەیێ: کلاسەکا د C# دا تەنێ دایکەک دگریت، بەلێ چەند interface یان دکەی تەتەبێ بکەت — ژ وێ جودا، چەند کلاسێن جودا دکەن هەمان پەیمان بگرن و هەمان شێوە بکاربینن.</p>',
        'code' => 'using System;

interface IVehicle {
    void Start();
}

class Car : IVehicle {
    public void Start() {
        Console.WriteLine("Car started");
    }
}

class Program {
    static void Main() {
        IVehicle v = new Car();
        v.Start();
    }
}',
        'example_output' => 'Car started',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە interface، فەنکشنەکان تەنیا دیاری دەکرێن یان جێبەجێ دەکرێن؟',
        'quiz_question_ba' => 'د interface دا، فەنکشن تەنێ دیاری دبیت یا تەتەبێ دبیت؟',
        'quiz_options_so' => ['تەنیا دیاری دەکرێن', 'جێبەجێ دەکرێن', 'هەردووکیان', 'هیچیان'],
        'quiz_options_ba' => ['تەنێ دیاری دبیت', 'تەتەبێ دبیت', 'هەردووک', 'هیچ'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 28,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Abstract Class',
        'title_ba' => 'Abstract Class',
        'content_so' => '<p><strong>کلاسی abstract</strong> کلاسێکە ناتوانیت ئۆبجێکتی لێ دروست بکەیت — وەک سەرچاوەیەک بۆ کلاسەکانی دیکە کار دەکات. فەنکشنی <code>abstract</code> تەنیا ناو و نیشانەکەی دیاری دەکات و کلاسی مناڵ دەبێت بە <code>override</code> جێبەجێی بکات.</p><p>نموونە:</p><pre>abstract class Shape {\n    public abstract int Area();\n}\n\nclass Square : Shape {\n    public override int Area() {\n        return 10 * 10;\n    }\n}\n\nShape s = new Square();\nConsole.WriteLine(s.Area());</pre><p>جیاوازی لەگەڵ interface: کلاسی abstract دەتوانێت فەنکشنی جێبەجێکراو، ئەندام و constructor ی هەبێت، بەڵام interface تەنیا دیاری دەکات. فەنکشنی <code>abstract</code> دەبێت بە <code>override</code> لە مناڵدا جێبەجێ بکرێت — ئەگەر نەکرێت، کلاسی مناڵ خۆی دەبێتە abstract و ناتوانرێت ئۆبجێکتی لێ دروست بکرێت.</p>',
        'content_ba' => '<p><strong>کلاسێ abstract</strong> کلاسەکا یە کو ناکەی ئۆبجێکتی ژێ دروست بکی — وەکو سەرچاوەک بو کلاسێن دی کار دکەت. فەنکشنێ <code>abstract</code> تەنێ ناڤ و نیشانەکێ دیاری دکەت و کلاسێ زارووک دڤێت پێ <code>override</code> تەتەبێ بکەت.</p><p>نموونە:</p><pre>abstract class Shape {\n    public abstract int Area();\n}\n\nclass Square : Shape {\n    public override int Area() {\n        return 10 * 10;\n    }\n}\n\nShape s = new Square();\nConsole.WriteLine(s.Area());</pre><p>جودایی ژ interface: کلاسێ abstract دکەی فەنکشنێن تەتەبێکری، ئەندام و constructor هەبن، بەلێ interface تەنێ دیاری دکەت. فەنکشنێ <code>abstract</code> دڤێت پێ <code>override</code> د زارووک دا تەتەبێ بکەیت — گەر نەکەیت، کلاسێ زارووک خۆ دبیتە abstract و ناکەیت ئۆبجێکتی ژێ دروست بکی.</p>',
        'code' => 'using System;

abstract class Shape {
    public abstract int Area();
}

class Square : Shape {
    public override int Area() {
        return 10 * 10;
    }
}

class Program {
    static void Main() {
        Shape s = new Square();
        Console.WriteLine(s.Area());
    }
}',
        'example_output' => '100',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'ئایا دەتوانیت ئۆبجێکت لە کلاسی abstract دروست بکەیت؟',
        'quiz_question_ba' => 'ئەر دکەی ئۆبجێکت ژ کلاسێ abstract دروست بکی؟',
        'quiz_options_so' => ['نەخێر', 'بەڵێ', 'تەنیا لە C# 10', 'تەنیا لەگەڵ interface'],
        'quiz_options_ba' => ['نەخێر', 'بەڵێ', 'تەنێ د C# 10 دا', 'تەنێ پێ interface'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 29,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: کۆکردنەوەی ئارای',
        'title_ba' => 'پرۆژە: کومکرنا ئارایێ',
        'content_so' => '<p><bdi>پرۆژەی بچووک:</bdi> کۆکردنەوەی هەموو ئەندامەکانی ئارایەک:</p><pre>int[] numbers = { 5, 10, 15, 20, 25 };\nint sum = 0;\n\nforeach (int n in numbers) {\n    sum += n;\n}\n\nConsole.WriteLine("Sum = " + sum);   // Sum = 75</pre><p>ئەمە یەکگرتنی خولگە و کۆکردنەوەیە — بناغەی زۆر بەرنامە.</p>',
        'content_ba' => '<p><bdi>پرۆژەیا بچووک:</bdi> کومکرنا هەمی ئەندامێن ئارایەکێ:</p><pre>int[] numbers = { 5, 10, 15, 20, 25 };\nint sum = 0;\n\nforeach (int n in numbers) {\n    sum += n;\n}\n\nConsole.WriteLine("Sum = " + sum);   // Sum = 75</pre><p>ئەڤە یەکگرتنا گەڕخستنێ و کومکرنێ یە — بناگەها زاف بەرنامان.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        int[] numbers = { 5, 10, 15, 20, 25 };
        int sum = 0;

        foreach (int n in numbers) {
            sum += n;
        }

        Console.WriteLine("Sum = " + sum);
    }
}',
        'example_output' => 'Sum = 75',
        'quiz_type' => 'choice',
        'quiz_question_so' => 'لە پرۆژەکە، sum دوای خولگەکە چەند دەبێت؟',
        'quiz_question_ba' => 'د پرۆژەیێ دا، sum پشی گەڕخستنێ چەند دبیت؟',
        'quiz_options_so' => ['75', '25', '100', '15'],
        'quiz_options_ba' => ['75', '25', '100', '15'],
        'quiz_correct' => '0',
    ],
    [
        'order' => 30,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz',
        'title_ba' => 'پرۆژە: FizzBuzz',
        'content_so' => '<p><bdi>پرۆژەی کۆتایی:</bdi> <strong>FizzBuzz</strong> — کلاسیکترین پرۆژەی بەرنامەسازی:</p><pre>for (int i = 1; i <= 15; i++) {\n    if (i % 15 == 0) {\n        Console.WriteLine("FizzBuzz");\n    } else if (i % 3 == 0) {\n        Console.WriteLine("Fizz");\n    } else if (i % 5 == 0) {\n        Console.WriteLine("Buzz");\n    } else {\n        Console.WriteLine(i);\n    }\n}</pre><p>ئەگەر بە 3 بەشکرا — Fizz، بە 5 — Buzz، بە هەردووکی — FizzBuzz. ئەم پرۆژەیە لە چاوپێکەوتنی کاردا زۆر بەناوبانگە.</p>',
        'content_ba' => '<p><bdi>پرۆژەیا دەراهی:</bdi> <strong>FizzBuzz</strong> — کلاسیکترین پرۆژەیا بەرنامەسازێ:</p><pre>for (int i = 1; i <= 15; i++) {\n    if (i % 15 == 0) {\n        Console.WriteLine("FizzBuzz");\n    } else if (i % 3 == 0) {\n        Console.WriteLine("Fizz");\n    } else if (i % 5 == 0) {\n        Console.WriteLine("Buzz");\n    } else {\n        Console.WriteLine(i);\n    }\n}</pre><p>گەر پێ 3 هاتە پارڤەکرن — Fizz، پێ 5 — Buzz، پێ هەردووکی — FizzBuzz. ئەڤ پرۆژە د چاوپێکەفتی کار دا زاف ناڤدارە.</p>',
        'code' => 'using System;

class Program {
    static void Main() {
        for (int i = 1; i <= 15; i++) {
            if (i % 15 == 0) {
                Console.WriteLine("FizzBuzz");
            } else if (i % 3 == 0) {
                Console.WriteLine("Fizz");
            } else if (i % 5 == 0) {
                Console.WriteLine("Buzz");
            } else {
                Console.WriteLine(i);
            }
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
        'quiz_question_so' => 'لە FizzBuzz، ئەگەر i=9 بووایە چی چاپ دەکرا؟',
        'quiz_question_ba' => 'د FizzBuzz دا، گەر i=9 بیت چ چاپ دبیت؟',
        'quiz_options_so' => ['Fizz', 'Buzz', 'FizzBuzz', '9'],
        'quiz_options_ba' => ['Fizz', 'Buzz', 'FizzBuzz', '9'],
        'quiz_correct' => '0',
    ],
];

if (defined('FERGA_SEED_LIB')) {
    $FERGA_SEED_LIBS['csharp'] = ['langId' => '-OysGzUzKG67KcswHXn2', 'lessons' => $lessons];
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

echo "\nDone! C# lessons have been added to Ferga.\n";
