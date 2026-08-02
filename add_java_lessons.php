<?php

// Script to add Java lessons (1-10) to the Ferga section in Firebase.
// Language already exists as -Oysj4DmsfjAe6mjjfjT; we just post lessons and unlock it.
if (!defined('FERGA_SEED_LIB')) {
$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$langId = '-Oysj4DmsfjAe6mjjfjT';

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

// Java language already exists; just unlock it.
fbPatch($firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
echo "Language Java unlocked.\n";

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
        'title_so' => 'چییە Java؟',
        'title_ba' => 'چ یە Java؟',
        'content_so' => '<p><strong>Java</strong> زمانی بەناوبانگ و سەربەخۆی سەکۆیە — یەک جار دەینووسیت، لە هەموو شوێنێک کاردەکات. بۆ ئەپلیکەیشنی ئەندرۆید، سیستەمی گەورەی بانکی و وێب بەکاردێت.</p><p>هەموو بەرنامەیەکی Java دەست دەکات بە <code>main</code>:</p><pre>class Ferga {\n    public static void main(String[] args) {\n        System.out.println("Hello from Java!");\n    }\n}</pre><p>بە <code>System.out.println()</code> دەقێک چاپ دەکەیت. لەم کۆرسەدا فەنکشنەکانی <code>int</code> و <code>String</code> و خولگە و زۆر شتی تر فێر دەبیت.</p>',
        'content_ba' => '<p><strong>Java</strong> زمانەکەکا ناڤدار و سەربەخۆی پلاتفۆرمێ یە — جارەکا دینڤیسی، د هەمی جهی دا کاردکەت. بو ئەپلیکەیشنێن ئەندرۆید، سیستەمێن مەزنی بانکی و وێب بکارتیت.</p><p>هەمی بەرنامەیەکا Java دەست پێ دکەت پێ <code>main</code>:</p><pre>class Ferga {\n    public static void main(String[] args) {\n        System.out.println("Hello from Java!");\n    }\n}</pre><p>پێ <code>System.out.println()</code> نڤیسینەک چاپ دکەی. د ڤێ کورسێ دا فەنکشنێن <code>int</code> و <code>String</code> و گەڕخستن و زاف تیشتن دیت فێر دبی.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        System.out.println("Hello from Java!");
    }
}',
        'example_output' => 'Hello from Java!',
        'challenge_desc_so' => 'پرۆگرامێک بنووسە کە "Bêxhatin bo Java!" چاپ بکات',
        'challenge_desc_ba' => 'پرۆگرامەک بنڤیسە کو "Bêxhatin bo Java!" چاپ بکەت',
        'expected_output' => 'Bêxhatin bo Java!',
    ],
    [
        'order' => 2,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'گۆڕاوەکان و جۆرەکانی داتا',
        'title_ba' => 'گۆڕۆک و چەشنێن داتایێ',
        'content_so' => '<p>لە Java هەموو گۆڕاوێک جۆرێکی دیاریکراوی هەیە. سەرەکیترین جۆرەکان:</p><pre>int age = 20;              // ژمارەی تەواو\nlong big = 1000000000L;    // ژمارەی گەورە\ndouble price = 9.99;       // ژمارەی لۆیی\nchar letter = \'A\';          // پیتێک\nboolean passed = true;      // ڕاست یان هەڵە\nString name = "Kurd";       // دەق</pre><p>لەوانەیە <code>String</code> ببینیت — ئەمە کلاسێکە نەک جۆری سادە، بەڵام زۆر لە زمانی کۆددا وەک جۆری ئاسایی بەکاردێت. بە <code>+</code> دەتوانیت دەق و گۆڕاو لەیەکبخەیت.</p>',
        'content_ba' => '<p>د Java دا هەمی گۆڕۆک چەشنەکا دیاریکراوی یە. سەرەکێترین چەشن:</p><pre>int age = 20;              // ژمارە تەمام\nlong big = 1000000000L;    // ژمارە مەزن\ndouble price = 9.99;       // ژمارە لۆیی\nchar letter = \'A\';          // پیتەک\nboolean passed = true;      // راست یا خەلەت\nString name = "Kurd";       // نڤیسین</pre><p>بەریتی <code>String</code> ببینیت — ئەڤ کلاسەکە یە نەک چەشنێ سادە، بەلێ زۆر د کۆدی دا وەک چەشنێ ئاسایی بکارتیت. پێ <code>+</code> تۆ دکەی نڤیسین و گۆڕۆک یەکبخی.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int age = 20;
        double price = 9.99;
        String city = "Hewlêr";

        System.out.println("Age: " + age);
        System.out.println("Price: " + price);
        System.out.println("City: " + city);
    }
}',
        'example_output' => 'Age: 20
Price: 9.99
City: Hewlêr',
        'challenge_desc_so' => 'گۆڕاوێکی "score" بە بەهای ١٠٠ دروست بکە و چاپی بکە',
        'challenge_desc_ba' => 'گۆڕۆکەکا "score" ب بەهایا ١٠٠ دروست بکە و چاپا وی بکە',
        'expected_output' => '100',
    ],
    [
        'order' => 3,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'بیرکاری و ئۆپێراتۆرەکان',
        'title_ba' => 'بیرکاری و ئۆپێراتۆر',
        'content_so' => '<p>Java هەموو ئۆپێراتۆرە بیرکارییەکانی پشتگیری دەکات:</p><pre>int a = 10;\nint b = 4;\n\nSystem.out.println(a + b);   // 14 کۆکردنەوە\nSystem.out.println(a - b);   // 6 کەمکردنەوە\nSystem.out.println(a * b);   // 40 زۆرکردن\nSystem.out.println(a / b);   // 2 دابەشکردن (تەواو)\nSystem.out.println(a % b);   // 2 پاشماوە</pre><p>بە بیر بێت: دابەشکردنی دوو <code>int</code> هەمیشە <code>int</code> دەگەڕێنێتەوە. ئەگەر ئەنجامی لۆیی دەوێت، دەبێت یەکێک لە ژمارەکان <code>double</code> بێت.</p>',
        'content_ba' => '<p>Java هەمی ئۆپێراتۆرێن بیرکاری پشتگیر دکەت:</p><pre>int a = 10;\nint b = 4;\n\nSystem.out.println(a + b);   // 14 کومکرن\nSystem.out.println(a - b);   // 6 کێمکرن\nSystem.out.println(a * b);   // 40 زێدەکرن\nSystem.out.println(a / b);   // 2 پارڤەکرن (تەمام)\nSystem.out.println(a % b);   // 2 پاشمایە</pre><p>د بیرا خۆدا گریت: پارڤەکرنا دوو <code>int</code> هەردیم <code>int</code> ڤەگەڕیت. گەر دەرئەنجامێ لۆیی دڤێت، دڤێت یەک ژ ژماران <code>double</code> بیت.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int a = 10;
        int b = 4;

        System.out.println(a + b);
        System.out.println(a - b);
        System.out.println(a * b);
        System.out.println(a / b);
        System.out.println(a % b);
    }
}',
        'example_output' => '14
6
40
2
2',
        'challenge_desc_so' => 'بە ئۆپێراتۆری دابەشکردن ئەنجامی ٤٩÷٧ چاپ بکە',
        'challenge_desc_ba' => 'پێ ئۆپێراتۆرێ پارڤەکرنێ دەرئەنجامێ ٤٩÷٧ چاپ بکە',
        'expected_output' => '7',
    ],
    [
        'order' => 4,
        'level_so' => 'ئاستی ١ - دەستپێک',
        'level_ba' => 'ئاستا ١ - دەستپێکرن',
        'title_so' => 'مەرجەکان (if / else)',
        'title_ba' => 'مەرج (if / else)',
        'content_so' => '<p>بە <code>if</code> و <code>else</code> بەرنامەکەت بڕیار دەدات:</p><pre>int score = 85;\n\nif (score >= 50) {\n    System.out.println("Bêşar!");\n} else {\n    System.out.println("Caw!");\n}</pre><p>بۆ چەند مەرجێک لەسەر یەکیش <code>else if</code> بەکاردەهێنیت:</p><pre>if (score >= 90) {\n    System.out.println("A");\n} else if (score >= 50) {\n    System.out.println("B");\n} else {\n    System.out.println("F");\n}</pre>',
        'content_ba' => '<p>پێ <code>if</code> و <code>else</code> بەرنامەکەت بریار ددەت:</p><pre>int score = 85;\n\nif (score >= 50) {\n    System.out.println("Bêşar!");\n} else {\n    System.out.println("Caw!");\n}</pre><p>بو چەند مەرجێ ل سەر یەک ژی <code>else if</code> بکارتینی:</p><pre>if (score >= 90) {\n    System.out.println("A");\n} else if (score >= 50) {\n    System.out.println("B");\n} else {\n    System.out.println("F");\n}</pre>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int score = 85;

        if (score >= 50) {
            System.out.println("Bêşar!");
        } else {
            System.out.println("Caw!");
        }
    }
}',
        'example_output' => 'Bêşar!',
        'challenge_desc_so' => 'مەرجێک بنووسە: ئەگەر num=7 جۆت بێت "Even" چاپ بکات بێ نەوەک "Odd"',
        'challenge_desc_ba' => 'مەرجەک بنڤیسە: گەر num=7 جۆت بیت "Even" چاپ بکەت نەوەک "Odd"',
        'expected_output' => 'Odd',
    ],
    [
        'order' => 5,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەکان (Loops)',
        'title_ba' => 'گەڕخستن (Loops)',
        'content_so' => '<p>خولگەی <code>for</code> کۆدێک ژمارەیەکی دیاریکراو جار تکرار دەکات:</p><pre>for (int i = 1; i <= 5; i++) {\n    System.out.print(i + " ");\n}\n\n// while - مەرجەکە ڕاستە هەتا بێت تکرار دەکات\nint j = 0;\nwhile (j < 3) {\n    System.out.println("Salam " + j);\n    j++;\n}</pre><p>بە بیر بێت: <code>i++</code> واتە <code>i = i + 1</code>. خولگەکان زۆرترین ئەرکی کارەکان جێبەجێ دەکەن وەک سوڕانەوە بەسەر داتاکاندا.</p>',
        'content_ba' => '<p>گەڕخستنا <code>for</code> کۆدێ ژمارەکا دیاریکراو جاران دوبارە دکەت:</p><pre>for (int i = 1; i <= 5; i++) {\n    System.out.print(i + " ");\n}\n\n// while - مەرج راستە هەتا بیت دوبارە دکەت\nint j = 0;\nwhile (j < 3) {\n    System.out.println("Salam " + j);\n    j++;\n}</pre><p>د بیرا خۆدا گریت: <code>i++</code> واتە <code>i = i + 1</code>. گەڕخستن زۆربە ئەرکێن کاری جێبەجێ دکەن وەک ڤەگەڕان بسەر داتایان دا.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        for (int i = 1; i <= 5; i++) {
            System.out.print(i + " ");
        }
        System.out.println();
    }
}',
        'example_output' => '1 2 3 4 5',
        'challenge_desc_so' => 'خولگەیەک بنووسە کە ژمارە جۆتەکانی ٢ بۆ ١٠ چاپ بکات',
        'challenge_desc_ba' => 'گەڕخستنەک بنڤیسە کو ژمارێن جۆت ٢ هەتا ١٠ چاپ بکەت',
        'expected_output' => '2 4 6 8 10',
    ],
    [
        'order' => 6,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنەکان (Methods)',
        'title_ba' => 'فەنکشن (Methods)',
        'content_so' => '<p>لە Java فەنکشن بە <code>method</code> ناسراوە. جۆری گەڕانەوە، ناو و پێکهاتەکانی دیاری دەکەیت:</p><pre>static int add(int a, int b) {\n    return a + b;\n}\n\npublic static void main(String[] args) {\n    int sum = add(5, 3);\n    System.out.println("Sum = " + sum);\n}</pre><p><code>static</code> واتە دەتوانیت لە <code>main</code>ەوە بانگی بکەیت بەبێ دروستکردنی ئۆبجێکت. <code>void</code> ئەو فەنکشنانەیە کە هیچ ناگەڕێننەوە.</p>',
        'content_ba' => '<p>د Java دا فەنکشن پێ <code>method</code> ناڤدارە. چەشنا ڤەگەڕاندنێ، ناڤ و پارامەترێن وی دیاری دکەی:</p><pre>static int add(int a, int b) {\n    return a + b;\n}\n\npublic static void main(String[] args) {\n    int sum = add(5, 3);\n    System.out.println("Sum = " + sum);\n}</pre><p><code>static</code> واتە تۆ دکەی ژ <code>main</code> بانگ بکی بێ دروستکرنا ئۆبجێکتێ. <code>void</code> ئەو فەنکشنانەن کو هیچ ڤەناگەڕینن.</p>',
        'code' => 'class Ferga {
    static int add(int a, int b) {
        return a + b;
    }

    public static void main(String[] args) {
        int sum = add(5, 3);
        System.out.println("Sum = " + sum);
    }
}',
        'example_output' => 'Sum = 8',
        'challenge_desc_so' => 'فەنکشنێکی "multiply" دروست بکە کە دوو ژمارە زۆر بکات و ئەنجامی ٦×٧ چاپ بکات',
        'challenge_desc_ba' => 'فەنکشنەکا "multiply" دروست بکە کو دوو ژماران زێدە بکەت و دەرئەنجامێ ٦×٧ چاپ بکەت',
        'expected_output' => '42',
    ],
    [
        'order' => 7,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارایەکان (Arrays)',
        'title_ba' => 'ئارای (Arrays)',
        'content_so' => '<p><strong>ئارای (Array)</strong> کۆمەڵێک بەها لە یەک گۆڕاودا دەگرێت. ئیندێکس لە <strong>٠</strong> دەست پێ دەکات:</p><pre>int[] numbers = {10, 20, 30, 40, 50};\n\nSystem.out.println(numbers[0]);   // 10\nSystem.out.println(numbers.length); // 5\n\nfor (int i = 0; i < numbers.length; i++) {\n    System.out.print(numbers[i] + " ");\n}</pre><p>بە <code>for-each</code>ش دەتوانیت بە سادەیی بەسەر هەموو ئەندامەکاندا بسوڕێیتەوە: <code>for (int n : numbers)</code>.</p>',
        'content_ba' => '<p><strong>ئارای (Array)</strong> کۆمەکەک بەها د یەک گۆڕۆکی دا دگریت. ئیندێکس ژ <strong>٠</strong> دەست پێ دکەت:</p><pre>int[] numbers = {10, 20, 30, 40, 50};\n\nSystem.out.println(numbers[0]);   // 10\nSystem.out.println(numbers.length); // 5\n\nfor (int i = 0; i < numbers.length; i++) {\n    System.out.print(numbers[i] + " ");\n}</pre><p>پێ <code>for-each</code> ژی تۆ دکەی ب ساداهی بسەر هەمی ئەندامان دا بگەڕی: <code>for (int n : numbers)</code>.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int[] numbers = {10, 20, 30, 40, 50};

        for (int i = 0; i < numbers.length; i++) {
            System.out.print(numbers[i] + " ");
        }
        System.out.println();
    }
}',
        'example_output' => '10 20 30 40 50',
        'challenge_desc_so' => 'ئارایەک بە "Kurd" و "Arab" و "Turk" دروست بکە و بە خولگەی for هەمووی چاپ بکە',
        'challenge_desc_ba' => 'ئارایەک ب "Kurd" و "Arab" و "Turk" دروست بکە و پێ گەڕخستنا for هەمی چاپ بکە',
        'expected_output' => 'Kurd Arab Turk',
    ],
    [
        'order' => 8,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'دەقەکان (Strings)',
        'title_ba' => 'نڤیسین (Strings)',
        'content_so' => '<p>دەقی <code>String</code> لە Java فەنکشنی زۆری هەیە:</p><pre>String city = "Hewlêr";\n\ncity.length();              // 6 ژمارەی پیتەکان\ncity.toUpperCase();         // HEWLÊR\ncity.toLowerCase();         // hewlêr\ncity.contains("Hew");       // true\ncity.charAt(0);             // H\ncity.substring(0, 3);       // Hew</pre><p>بە <code>+</code> دەقەکان لەیەک دەبەستیتەوە (concatenation) و بە <code>equals()</code> دوو دەق بەراورد دەکەیت — نەک بە <code>==</code>.</p>',
        'content_ba' => '<p>نڤیسینا <code>String</code> د Java دا فەنکشنێن زاف هەن:</p><pre>String city = "Hewlêr";\n\ncity.length();              // 6 ژمارا پیتان\ncity.toUpperCase();         // HEWLÊR\ncity.toLowerCase();         // hewlêr\ncity.contains("Hew");       // true\ncity.charAt(0);             // H\ncity.substring(0, 3);       // Hew</pre><p>پێ <code>+</code> نڤیسین یەک دبستیت و پێ <code>equals()</code> دوو نڤیسین بەراورد دکەی — نەک پێ <code>==</code>.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        String city = "Hewlêr";
        String country = "Kurdistan";

        System.out.println("Salam, " + city + "!");
        System.out.println(country.toUpperCase());
    }
}',
        'example_output' => 'Salam, Hewlêr!
KURDISTAN',
        'challenge_desc_so' => 'بە .length() ژمارەی پیتەکانی "Kurdistan" چاپ بکە',
        'challenge_desc_ba' => 'پێ .length() ژمارا پیتێن "Kurdistan" چاپ بکە',
        'expected_output' => '9',
    ],
    [
        'order' => 9,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کلاس و ئۆبجێکت (OOP)',
        'title_ba' => 'کلاس و ئۆبجێکت (OOP)',
        'content_so' => '<p>Java زمانی OOP یە (بەرنامەسازی ڕوو لە ئۆبجێکت). کلاس وەک قاڵبێکە و ئۆبجێکت وەک نموونەیەکی ڕاستەقینە:</p><pre>class Student {\n    String name;\n    int grade;\n\n    Student(String n, int g) {\n        name = n;\n        grade = g;\n    }\n\n    void show() {\n        System.out.println(name + ": " + grade);\n    }\n}\n\n// لە main:\nStudent s = new Student("Ava", 95);\ns.show();   // Ava: 95</pre><p><code>new</code> ئۆبجێکتێکی نوێ دروست دەکات و <code>constructor</code> زانیارییە سەرەتاییەکان پێدەدات.</p>',
        'content_ba' => '<p>Java زمانەکا OOP یە (بەرنامەسازی ڕوو ل ئۆبجێکت). کلاس وەک قالبەکا یە و ئۆبجێکت وەک نموونەکا ڕاستەقینە:</p><pre>class Student {\n    String name;\n    int grade;\n\n    Student(String n, int g) {\n        name = n;\n        grade = g;\n    }\n\n    void show() {\n        System.out.println(name + ": " + grade);\n    }\n}\n\n// د main دا:\nStudent s = new Student("Ava", 95);\ns.show();   // Ava: 95</pre><p><code>new</code> ئۆبجێکتەکا نوی دروست دکەت و <code>constructor</code> زانیارییێن سەرەتایی پێ ددەت.</p>',
        'code' => 'class Student {
    String name;
    int grade;

    Student(String n, int g) {
        name = n;
        grade = g;
    }

    void show() {
        System.out.println(name + ": " + grade);
    }
}

class Ferga {
    public static void main(String[] args) {
        Student s = new Student("Ava", 95);
        s.show();
    }
}',
        'example_output' => 'Ava: 95',
        'challenge_desc_so' => 'کلاسێکی "Car" دروست بکە بە تایبەتمەندی brand="Toyota" و چاپی بکە',
        'challenge_desc_ba' => 'کلاسەکا "Car" دروست بکە ب تایبەتمەندی brand="Toyota" و چاپا وی بکە',
        'expected_output' => 'Toyota',
    ],
    [
        'order' => 10,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: کۆکردنەوەی ئارای',
        'title_ba' => 'پرۆژە: کومکرنا ئارای',
        'content_so' => '<p>ئێستا هەموو شتێک یەکبخەین: ئارای، خولگە و فەنکشن. پرۆژەکە: کۆی بەهای ئارایەک بدۆزەرەوە.</p><pre>static int sumArray(int[] arr) {\n    int total = 0;\n    for (int i = 0; i < arr.length; i++) {\n        total += arr[i];\n    }\n    return total;\n}\n\n// لە main:\nint[] nums = {10, 20, 30};\nSystem.out.println("Total = " + sumArray(nums));\n// Total = 60</pre><p>فەنکشنێک کۆی ئارایەک دەدۆزێتەوە و ئەنجامەکە دەگەڕێنێتەوە — نموونەیەکی ڕاستەقینەی بەرنامەسازییە.</p>',
        'content_ba' => '<p>ئێستا هەمی تیشت یەکبخین: ئارای، گەڕخستن و فەنکشن. پرۆژە: کوما بەهاییێن ئارایەک بدۆزە.</p><pre>static int sumArray(int[] arr) {\n    int total = 0;\n    for (int i = 0; i < arr.length; i++) {\n        total += arr[i];\n    }\n    return total;\n}\n\n// د main دا:\nint[] nums = {10, 20, 30};\nSystem.out.println("Total = " + sumArray(nums));\n// Total = 60</pre><p>فەنکشنەک کوما ئارایەک ددۆزیت و دەرئەنجام ڤەدگەڕیت — نموونەکا ڕاستەقینە یا بەرنامەسازیێ یە.</p>',
        'code' => 'class Ferga {
    static int sumArray(int[] arr) {
        int total = 0;
        for (int i = 0; i < arr.length; i++) {
            total += arr[i];
        }
        return total;
    }

    public static void main(String[] args) {
        int[] nums = {10, 20, 30};
        System.out.println("Total = " + sumArray(nums));
    }
}',
        'example_output' => 'Total = 60',
        'challenge_desc_so' => 'فەنکشنێک بنووسە کە گەورەترین بەهای ئارایەکی {3, 9, 5} بدۆزێتەوە و چاپی بکات',
        'challenge_desc_ba' => 'فەنکشنەک بنڤیسە کو مەزنا بەهای ئارایەکی {3, 9, 5} بدۆزیت و چاپا وی بکەت',
        'expected_output' => '9',
    ],
    [
        'order' => 11,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'داتا خوێندنەوە بە Scanner',
        'title_ba' => 'داتا خوێندنەوە بە Scanner',
        'content_so' => '<p><code>Scanner</code> داتا دەخوێنێتەوە — لە بەرنامەی ڕاستەقینەدا لە کلیلەوە بە <code>System.in</code>. دەبێت لە <code>java.util.Scanner</code> هاوردەی بکەیت:</p><pre>import java.util.Scanner;\n\nScanner sc = new Scanner("Ava 21");\n\nString name = sc.next();\nint age = sc.nextInt();\n\nSystem.out.println("Salam " + name + "!");\nSystem.out.println("Age: " + age);</pre><p><code>next()</code> دەقێک دەخوێنێتەوە و <code>nextInt()</code> ژمارەیەکی تەواو. لە بەرنامەی ڕاستەقینەدا <code>new Scanner(System.in)</code> بەکاربهێنە.</p>',
        'content_ba' => '<p><code>Scanner</code> داتا دخوانیت — د بەرنامەی ڕاستەقینە دا ژ کلیلە پێ <code>System.in</code>. دڤێت ژ <code>java.util.Scanner</code> هەورەی بکی:</p><pre>import java.util.Scanner;\n\nScanner sc = new Scanner("Ava 21");\n\nString name = sc.next();\nint age = sc.nextInt();\n\nSystem.out.println("Salam " + name + "!");\nSystem.out.println("Age: " + age);</pre><p><code>next()</code> نڤیسینەک دخوانیت و <code>nextInt()</code> ژمارەکا تەمام. د بەرنامەی ڕاستەقینە دا <code>new Scanner(System.in)</code> بکاربینە.</p>',
        'code' => 'import java.util.Scanner;

class Ferga {
    public static void main(String[] args) {
        Scanner sc = new Scanner("Ava 21");

        String name = sc.next();
        int age = sc.nextInt();

        System.out.println("Salam " + name + "!");
        System.out.println("Age: " + age);
    }
}',
        'example_output' => 'Salam Ava!
Age: 21',
        'challenge_desc_so' => 'بە Scanner ناو و تەمەنەکە بخوێنە و "Salam Ava! / Age: 21" چاپ بکە',
        'challenge_desc_ba' => 'پێ Scanner ناڤ و تەمەنەکا خوێندنە و "Salam Ava! / Age: 21" چاپ بکە',
        'expected_output' => 'Salam Ava!
Age: 21',
    ],
    [
        'order' => 12,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'مەرجی switch',
        'title_ba' => 'مەرجا switch',
        'content_so' => '<p><code>switch</code> بۆ چەند مەرجێک بەسەر یەک گۆڕاودا باشترە لە <code>if</code>:</p><pre>int day = 2;\n\nswitch (day) {\n    case 1:\n        System.out.println("Duşem");\n        break;\n    case 2:\n        System.out.println("Sêşem");\n        break;\n    default:\n        System.out.println("Nenas");\n}</pre><p><code>break</code> خولگەکە دەوەستێنێت؛ <code>default</code> ئەو حاڵەتەیە کە هیچ case ێک نەگونجێت.</p>',
        'content_ba' => '<p><code>switch</code> بو چەند مەرجان ل سەر یەک گۆڕۆکی باشترە ژ <code>if</code>:</p><pre>int day = 2;\n\nswitch (day) {\n    case 1:\n        System.out.println("Duşem");\n        break;\n    case 2:\n        System.out.println("Sêşem");\n        break;\n    default:\n        System.out.println("Nenas");\n}</pre><p><code>break</code> گەڕخستنە ددهمڕیت؛ <code>default</code> ئەو حاڵەتەیە کو هیچ case ەک نەگونجیت.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int day = 2;

        switch (day) {
            case 1:
                System.out.println("Duşem");
                break;
            case 2:
                System.out.println("Sêşem");
                break;
            case 3:
                System.out.println("Çarşem");
                break;
            default:
                System.out.println("Nenas");
        }
    }
}',
        'example_output' => 'Sêşem',
        'challenge_desc_so' => 'بە switch و day=7 "Yekşem" چاپ بکە',
        'challenge_desc_ba' => 'پێ switch و day=7 "Yekşem" چاپ بکە',
        'expected_output' => 'Yekşem',
    ],
    [
        'order' => 13,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی while',
        'title_ba' => 'گەڕخستنا while',
        'content_so' => '<p>خولگەی <code>while</code> تکرار دەکات هەتا مەرجەکە ڕاست بێت:</p><pre>int i = 1;\n\nwhile (i <= 5) {\n    System.out.println("Salam " + i);\n    i++;\n}</pre><p>ئاگادار بە: ئەگەر <code>i++</code> نەنووسیت خولگەکە بەبێ کۆتایی تکرار دەبێت. بۆ ژماردن بۆ خوارەوە <code>i--</code> بەکاردەهێنیت.</p>',
        'content_ba' => '<p>گەڕخستنا <code>while</code> دوبارە دکەت هەتا مەرج راست بیت:</p><pre>int i = 1;\n\nwhile (i <= 5) {\n    System.out.println("Salam " + i);\n    i++;\n}</pre><p>هشیار بە: گەر <code>i++</code> نەنڤیسی گەڕخستن بێ داوایێ دوبارە دبیت. بو هژمارتن بۆ خوارێ <code>i--</code> بکاربینیت.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int i = 1;

        while (i <= 5) {
            System.out.println("Salam " + i);
            i++;
        }
    }
}',
        'example_output' => 'Salam 1
Salam 2
Salam 3
Salam 4
Salam 5',
        'challenge_desc_so' => 'بە while ژمارە جۆتەکانی 10 بۆ 2 چاپ بکە بە فۆڕمی یەک ڕیز',
        'challenge_desc_ba' => 'پێ while ژمارێن جۆت 10 هەتا 2 چاپ بکە ب شێوەی یەک ڕیز',
        'expected_output' => '10 8 6 4 2',
    ],
    [
        'order' => 14,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی do-while',
        'title_ba' => 'گەڕخستنا do-while',
        'content_so' => '<p><code>do-while</code> وەک <code>while</code> یە بەڵام هەمیشە یەک جار جێبەجێ دەبێت پێش پشکنینی مەرج:</p><pre>int i = 1;\n\ndo {\n    System.out.println("Hejmara " + i);\n    i++;\n} while (i <= 3);</pre><p>بۆ حاڵەتەکان کە دەمانەوێت لانیکەم یەک جار بێت، وەک نیشاندانی مێنوو، <code>do-while</code> گونجاوە.</p>',
        'content_ba' => '<p><code>do-while</code> وەک <code>while</code> یە بەلێ هەردیم جارەکا جێبەجێ دبیت بەری پشکنینا مەرجی:</p><pre>int i = 1;\n\ndo {\n    System.out.println("Hejmara " + i);\n    i++;\n} while (i <= 3);</pre><p>بو حاڵەتێن کو دڤێت هەردیم بێ کێم یەک جار، وەک نیشاندانا مێنووی، <code>do-while</code> گونجایە.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int i = 1;

        do {
            System.out.println("Hejmara " + i);
            i++;
        } while (i <= 3);
    }
}',
        'example_output' => 'Hejmara 1
Hejmara 2
Hejmara 3',
        'challenge_desc_so' => 'بە do-while ژمارەکان 3 بۆ 1 چاپ بکە',
        'challenge_desc_ba' => 'پێ do-while ژمارێن 3 هەتا 1 چاپ بکە',
        'expected_output' => '3
2
1',
    ],
    [
        'order' => 15,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'خولگەی هێلانەیی (سێگۆشە)',
        'title_ba' => 'گەڕخستنا هێلانەیی (سێگۆشە)',
        'content_so' => '<p>کاتێک خولگەیەک لە ناوەوەی خولگەیەکی تردا دەبێت پێی دەگوترێت خولگەی هێلانەیی. بەمەوە شێوەکان دەکێشرێن:</p><pre>for (int i = 1; i <= 5; i++) {\n    for (int j = 1; j <= i; j++) {\n        System.out.print("*");\n    }\n    System.out.println();\n}</pre><p>لە دەرەوەدا ڕیزەکان و لە ناوەوەدا ئەستێرەکانی هەر ڕیزێک ژماردەیت.</p>',
        'content_ba' => '<p>دمایە گەڕخستنەک ل ناڤ گەڕخستنا دین دا بیت، پێی دبێژن گەڕخستنا هێلانەیی. پێ ڤێ یە شێوە تێنەکێشن:</p><pre>for (int i = 1; i <= 5; i++) {\n    for (int j = 1; j <= i; j++) {\n        System.out.print("*");\n    }\n    System.out.println();\n}</pre><p>د دەرڤە دا ڕیزان و د ناڤە دا ئەستێرێن هەر ڕیزەکێ دیاری دکەی.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        for (int i = 1; i <= 5; i++) {
            for (int j = 1; j <= i; j++) {
                System.out.print("*");
            }
            System.out.println();
        }
    }
}',
        'example_output' => '*
**
***
****
*****',
        'challenge_desc_so' => 'بە خولگەی هێلانەیی سێگۆشەیەکی 3 ڕیز بە * دروست بکە',
        'challenge_desc_ba' => 'پێ گەڕخستنا هێلانەیی سێگۆشەکا 3 ڕیزان ب * دروست بکە',
        'expected_output' => '*
**
***',
    ],
    [
        'order' => 16,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشنی زۆرتر لە Strings',
        'title_ba' => 'فەنکشنێن زێدە یێن Strings',
        'content_so' => '<p>ئەم جارە فەنکشنەکانی دەق زیاتر بەکاردەهێنین و لەگەڵ خولگەدا تێکەڵیان دەکەین:</p><pre>String word = "Kurdistan";\n\nword.length();              // ژمارەی پیتەکان\nword.charAt(0);             // پیتی یەکەم\nword.toUpperCase();         // بە پیتی گەورە\nword.toLowerCase();         // بە پیتی بچووک</pre><p>بە <code>charAt()</code> و خولگە دەتوانیت بەسەر هەموو پیتەکاندا بسوڕێیتەوە — ڕێگایەک بۆ پێچەوانەکردنەوەی دەق.</p>',
        'content_ba' => '<p>ئەڤ جارێ فەنکشنێن نڤیسینێ زێدە بکاربینین و د گەڕخستنی دا یەکبخین:</p><pre>String word = "Kurdistan";\n\nword.length();              // ژمارا پیتان\nword.charAt(0);             // پیتا دویێ\nword.toUpperCase();         // ب پیتێن مەزن\nword.toLowerCase();         // ب پیتێن بچویک</pre><p>پێ <code>charAt()</code> و گەڕخستنێ تۆ دکەی بسەر هەمی پیتان دا بگەڕی — ڕێگایەک بو پێچەوانەکرنا نڤیسینێ.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        String word = "Kurdistan";

        System.out.println("Length: " + word.length());

        for (int i = 0; i < word.length(); i++) {
            System.out.print(word.charAt(i) + " ");
        }
        System.out.println();

        System.out.println(word.toUpperCase());
    }
}',
        'example_output' => 'Length: 9
K U R D I S T A N 
KURDISTAN',
        'challenge_desc_so' => 'بە charAt دەقی "Soran" پێچەوانە بکەرەوە و چاپی بکە',
        'challenge_desc_ba' => 'پێ charAt نڤیسینا "Soran" پێچەوانە بکە و چاپا وی بکە',
        'expected_output' => 'naroS',
    ],
    [
        'order' => 17,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'StringBuilder',
        'title_ba' => 'StringBuilder',
        'content_so' => '<p><code>StringBuilder</code> دەقەکان بە بەریەکبەستن دروست دەکات — گشت ئەو جارانەی دەق دەگۆڕیت خێراترە:</p><pre>StringBuilder sb = new StringBuilder();\n\nsb.append("Kurdistan");\nsb.append(" Azad");\n\nSystem.out.println(sb.toString());\nsb.reverse();               // پێچەوانەکردنەوە\nSystem.out.println(sb.toString());</pre><p>بە <code>append()</code> دەق زیاد دەکەیت و بە <code>reverse()</code> پێچەوانەی دەکەیتەوە.</p>',
        'content_ba' => '<p><code>StringBuilder</code> نڤیسینان ب پێکەڤەبستنێ دروست دکەت — هەردیمێ جارانا تۆ دەست دگەڕن نڤیسینێ خێترترە:</p><pre>StringBuilder sb = new StringBuilder();\n\nsb.append("Kurdistan");\nsb.append(" Azad");\n\nSystem.out.println(sb.toString());\nsb.reverse();               // پێچەوانەکرن\nSystem.out.println(sb.toString());</pre><p>پێ <code>append()</code> نڤیسین زێدە دکەی و پێ <code>reverse()</code> پێچەوانە دکەی.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        StringBuilder sb = new StringBuilder();

        sb.append("Kurdistan");
        sb.append(" Azad");

        System.out.println(sb.toString());
        System.out.println(sb.reverse().toString());
    }
}',
        'example_output' => 'Kurdistan Azad
dazA natsidruK',
        'challenge_desc_so' => 'بە StringBuilder "Hello" و " World" تێکەڵ بکە و چاپی بکە',
        'challenge_desc_ba' => 'پێ StringBuilder "Hello" و " World" یەک بکە و چاپا وی بکە',
        'expected_output' => 'Hello World',
    ],
    [
        'order' => 18,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارای دەقەکان (String[])',
        'title_ba' => 'ئارایێ نڤیسینان (String[])',
        'content_so' => '<p>ئارای نەک تەنها بۆ ژمارە، بۆ دەقیش بەکاردێت:</p><pre>String[] cities = {"Hewlêr", "Silêmanî", "Dihok"};\n\nfor (int i = 0; i < cities.length; i++) {\n    System.out.println(cities[i]);\n}</pre><p>هەر ئەندامێک دەقێکە و بە <code>cities.length</code> ژمارەی شارەکان دەردەکەوێت.</p>',
        'content_ba' => '<p>ئارای نەک تەنێ بو ژماران، بو نڤیسینان ژی بکارتیت:</p><pre>String[] cities = {"Hewlêr", "Silêmanî", "Dihok"};\n\nfor (int i = 0; i < cities.length; i++) {\n    System.out.println(cities[i]);\n}</pre><p>هەر ئەندامەک نڤیسینەکە و پێ <code>cities.length</code> ژمارا شاران ددەرکەڤیت.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        String[] cities = {"Hewlêr", "Silêmanî", "Dihok"};

        for (int i = 0; i < cities.length; i++) {
            System.out.println(cities[i]);
        }
    }
}',
        'example_output' => 'Hewlêr
Silêmanî
Dihok',
        'challenge_desc_so' => 'ئارایەکی "Kurd" و "Arab" و "Turk" دروست بکە و هەر یەکەیان لە ڕیزی جیادا چاپ بکە',
        'challenge_desc_ba' => 'ئارایەک "Kurd" و "Arab" و "Turk" دروست بکە و هەر یەک ژوان ل ڕیزەکا جودا چاپ بکە',
        'expected_output' => 'Kurd
Arab
Turk',
    ],
    [
        'order' => 19,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'ئارای دوو ڕەهەندی (2D)',
        'title_ba' => 'ئارایێ دوو ڕەهەندی (2D)',
        'content_so' => '<p>ئارای دوو ڕەهەندی وەک خشتەیەکە بە ڕیز و ستوون:</p><pre>int[][] grid = {{1, 2, 3}, {4, 5, 6}};\n\nfor (int i = 0; i < grid.length; i++) {\n    for (int j = 0; j < grid[i].length; j++) {\n        System.out.print(grid[i][j] + " ");\n    }\n    System.out.println();\n}</pre><p><code>grid[i][j]</code> — i ڕیزەکەیە و j ستوونەکەیە. خولگەی هێلانەیی دەبێت بۆ پڕکردنەوەی.</p>',
        'content_ba' => '<p>ئارایێ دوو ڕەهەندی وەک خشتەکا یە ب ڕیز و ستوون:</p><pre>int[][] grid = {{1, 2, 3}, {4, 5, 6}};\n\nfor (int i = 0; i < grid.length; i++) {\n    for (int j = 0; j < grid[i].length; j++) {\n        System.out.print(grid[i][j] + " ");\n    }\n    System.out.println();\n}</pre><p><code>grid[i][j]</code> — i ڕیزە و j ستوونە. گەڕخستنا هێلانەیی دڤێت بو داگیرکرنا وی.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        int[][] grid = {{1, 2, 3}, {4, 5, 6}};

        for (int i = 0; i < grid.length; i++) {
            for (int j = 0; j < grid[i].length; j++) {
                System.out.print(grid[i][j] + " ");
            }
            System.out.println();
        }
    }
}',
        'example_output' => '1 2 3 
4 5 6 ',
        'challenge_desc_so' => 'ئارای 2×2 ی {1,2} و {3,4} چاپ بکە',
        'challenge_desc_ba' => 'ئارایا 2×2 یا {1,2} و {3,4} چاپ بکە',
        'expected_output' => '1 2 
3 4 ',
    ],
    [
        'order' => 20,
        'level_so' => 'ئاستی ٢ - ناوەندی',
        'level_ba' => 'ئاستا ٢ - ناڤەندی',
        'title_so' => 'فەنکشن بە گەڕانەوە',
        'title_ba' => 'فەنکشن ب ڤەگەڕاندن',
        'content_so' => '<p>فەنکشنەکان دەتوانن ئەنجامێک بگەڕێننەوە بە <code>return</code>. جۆری گەڕانەوە لە دەستپێکی فەنکشنەکەدا دیاری دەکەیت:</p><pre>static int max(int a, int b) {\n    if (a > b) {\n        return a;\n    } else {\n        return b;\n    }\n}\n\nint result = max(7, 12);   // 12</pre><p>فەنکشنێک کە دەگەڕێتەوە دەبێت هەمیشە <code>return</code> ی هەبێت — ئەگەر نا کۆدی Java ەکە هەڵە دەبێت.</p>',
        'content_ba' => '<p>فەنکشن تۆ دکەن دەرئەنجامەک ڤەگەڕینن پێ <code>return</code>. چەشنا ڤەگەڕاندنێ ل دەستپێکا فەنکشنێ دیاری دکەی:</p><pre>static int max(int a, int b) {\n    if (a > b) {\n        return a;\n    } else {\n        return b;\n    }\n}\n\nint result = max(7, 12);   // 12</pre><p>فەنکشنەکا کو ڤەدگەڕیت دڤێت هەردیم <code>return</code> ڤە یە — گەر نا کۆدی Java خەلەت دبیت.</p>',
        'code' => 'class Ferga {
    static int max(int a, int b) {
        if (a > b) {
            return a;
        } else {
            return b;
        }
    }

    public static void main(String[] args) {
        int result = max(7, 12);
        System.out.println("Max = " + result);
    }
}',
        'example_output' => 'Max = 12',
        'challenge_desc_so' => 'فەنکشنی "min" بنووسە کە بچووکترینی دوو ژمارە دەگەڕێنێتەوە و ئەنجامی min(3, 8) چاپ بکە',
        'challenge_desc_ba' => 'فەنکشنا "min" بنڤیسە کو بچویکترینی دوو ژماران ڤەدگەڕیت و دەرئەنجامێ min(3, 8) چاپ بکە',
        'expected_output' => '3',
    ],
    [
        'order' => 21,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'فەنکشنی زۆربار (Overloading)',
        'title_ba' => 'فەنکشنێن زۆربار (Overloading)',
        'content_so' => '<p>Java ڕێگا دەدات چەند فەنکشن بە هەمان ناو ببێت بە مەرجێک پێکهاتەکانیان جیاواز بن — بەمە دەڵێن <em>overloading</em>:</p><pre>static int add(int a, int b) {\n    return a + b;\n}\n\nstatic int add(int a, int b, int c) {\n    return a + b + c;\n}\n\nstatic double add(double a, double b) {\n    return a + b;\n}</pre><p>Java بەپێی ژمارە و جۆری ئارگومێنتەکان بڕیار دەدات کام فەنکشن جێبەجێ بکات.</p>',
        'content_ba' => '<p>Java ڕێ ددەت چەند فەنکشن ب هەمان ناڤ هەبن ب مەرجەکا پارامەترێن وان جودا بن — پێ ڤێ یە دبێژن <em>overloading</em>:</p><pre>static int add(int a, int b) {\n    return a + b;\n}\n\nstatic int add(int a, int b, int c) {\n    return a + b + c;\n}\n\nstatic double add(double a, double b) {\n    return a + b;\n}</pre><p>Java ل گۆرە ژمارە و چەشنا ئارگومێنتان بریار ددەت کا فەنکشنا کی جێبەجێ بکەت.</p>',
        'code' => 'class Ferga {
    static int add(int a, int b) {
        return a + b;
    }

    static int add(int a, int b, int c) {
        return a + b + c;
    }

    static double add(double a, double b) {
        return a + b;
    }

    public static void main(String[] args) {
        System.out.println(add(2, 3));
        System.out.println(add(1, 2, 3));
        System.out.println(add(2.5, 1.5));
    }
}',
        'example_output' => '5
6
4.0',
        'challenge_desc_so' => 'فەنکشنی "area" بنووسە: area(4) بۆ چوارگۆشە و area(3, 5) بۆ لاکێشە — ئەنجامەکان چاپ بکە',
        'challenge_desc_ba' => 'فەنکشنا "area" بنڤیسە: area(4) بو چوارگۆشە و area(3, 5) بو لاکێشە — دەرئەنجامان چاپ بکە',
        'expected_output' => '16
15',
    ],
    [
        'order' => 22,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'فەنکشنی static و کلاسی Math',
        'title_ba' => 'فەنکشنێن static و کلاسا Math',
        'content_so' => '<p>فەنکشنی <code>static</code> بەبێ دروستکردنی ئۆبجێکت بانگ دەکرێت. کلاسی <code>Math</code> پڕە لە فەنکشنی ئاواهاش:</p><pre>Math.max(8, 3);    // 8\nMath.min(8, 3);    // 3\nMath.abs(-7);      // 7\nMath.pow(2, 3);    // 8.0\nMath.sqrt(81);     // 9.0</pre><p>بە بیر بێت <code>pow</code> و <code>sqrt</code> <code>double</code> دەگەڕێننەوە — بۆیە 8.0 و 9.0 دەردەکەون.</p>',
        'content_ba' => '<p>فەنکشنا <code>static</code> بێ دروستکرنا ئۆبجێکتێ بانگ دبیت. کلاسا <code>Math</code> تژە فەنکشنێن هۆسا:</p><pre>Math.max(8, 3);    // 8\nMath.min(8, 3);    // 3\nMath.abs(-7);      // 7\nMath.pow(2, 3);    // 8.0\nMath.sqrt(81);     // 9.0</pre><p>د بیرا خۆدا گریت <code>pow</code> و <code>sqrt</code> <code>double</code> ڤەدگەڕینن — ژبەر ڤێ چەندێ 8.0 و 9.0 دەرکەڤن.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        System.out.println(Math.max(8, 3));
        System.out.println(Math.min(8, 3));
        System.out.println(Math.abs(-7));
        System.out.println(Math.pow(2, 3));
    }
}',
        'example_output' => '8
3
7
8.0',
        'challenge_desc_so' => 'بە کلاسی Math ئەنجامی sqrt(81) و max(10, 99) چاپ بکە',
        'challenge_desc_ba' => 'پێ کلاسا Math دەرئەنجامێ sqrt(81) و max(10, 99) چاپ بکە',
        'expected_output' => '9.0
99',
    ],
    [
        'order' => 23,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کلاس و کۆنسترۆکتەر',
        'title_ba' => 'کلاس و کۆنسترۆکتەر',
        'content_so' => '<p>کۆنسترۆکتەر ئەو فەنکشنەیە کە کاتێک ئۆبجێکت دروست دەکەیت ڕاستەوخۆ بانگ دەکرێت:</p><pre>class Book {\n    String title;\n    int pages;\n\n    Book(String title, int pages) {\n        this.title = title;\n        this.pages = pages;\n    }\n\n    void show() {\n        System.out.println(title + " (" + pages + " rûpel)");\n    }\n}</pre><p><code>this</code> ئاماژەیە بۆ گۆڕاوەکانی ئەم ئۆبجێکتە. بە <code>new</code> ئۆبجێکتێکی نوێ دروست دەکەیت.</p>',
        'content_ba' => '<p>کۆنسترۆکتەر ئەو فەنکشنەیە کو دمایە ئۆبجێکت دروست بکەی ڕاستەوخۆ بانگ دبیت:</p><pre>class Book {\n    String title;\n    int pages;\n\n    Book(String title, int pages) {\n        this.title = title;\n        this.pages = pages;\n    }\n\n    void show() {\n        System.out.println(title + " (" + pages + " rûpel)");\n    }\n}</pre><p><code>this</code> ئاماژەیە بۆ گۆڕاوەکانی ئەم ئۆبجێکتە. بە <code>new</code> ئۆبجێکتێکی نوێ دروست دەکەیت.</p>',
        'code' => 'class Book {
    String title;
    int pages;

    Book(String title, int pages) {
        this.title = title;
        this.pages = pages;
    }

    void show() {
        System.out.println(title + " (" + pages + " rûpel)");
    }
}

class Ferga {
    public static void main(String[] args) {
        Book b = new Book("Mem û Zîn", 311);
        b.show();
    }
}',
        'example_output' => 'Mem û Zîn (311 rûpel)',
        'challenge_desc_so' => 'کلاسی "Animal" دروست بکە بە name="Pisîk" و sound="Mew" و فەنکشنی "speak" کە "Pisîk: Mew" چاپ بکات',
        'challenge_desc_ba' => 'کلاسا "Animal" دروست بکە ب name="Pisîk" و sound="Mew" و فەنکشنا "speak" کو "Pisîk: Mew" چاپ بکەت',
        'expected_output' => 'Pisîk: Mew',
    ],
    [
        'order' => 24,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'بۆماوە (Inheritance)',
        'title_ba' => 'بۆماوە (Inheritance)',
        'content_so' => '<p><strong>بۆماوە (Inheritance)</strong> یەکێکە لە بنەماکانی OOP — ڕێگا دەدات کلاسێکی نوێ (subclass) هەموو خانە و فەنکشنی کلاسێکی هەبوو (superclass) بۆماوە ببێت. بە وشەی <code>extends</code> دیاری دەکەیت کە کام کلاس لە کامەوە دەگرێتەوە:</p><pre>class Animal {\n    String name;\n\n    Animal(String name) {\n        this.name = name;\n    }\n\n    void eat() {\n        System.out.println(name + " dexwêt");\n    }\n}\n\nclass Dog extends Animal {\n    Dog(String name) {\n        super(name);\n    }\n}</pre><p>ئێستا <code>Dog</code> هەموو خانە و فەنکشنی <code>Animal</code> ی بۆماوە هەیە، بەبێ دووبارەنووسینەوە. بە <code>super()</code> کۆنسترۆکتەری کلاسی سەرەکی بانگ دەکەیت.</p><p>بۆماوە کۆدەکەت کورت و ڕێکوپێک دەکات: گۆڕانکارییەکی بچووک لە کلاسی سەرەکیدا لە هەموو کلاسە وەرگرتووەکاندا جێبەجێ دەبێت.</p>',
        'content_ba' => '<p><strong>بۆماوە (Inheritance)</strong> یەک ژ بنەمایێن OOP — ڕێ ددەت کلاسەکا نوی (subclass) هەمی تایبەتمەندی و فەنکشنێن کلاسەکا هەبوی (superclass) بۆماوە بەربیت. ب وشەی <code>extends</code> دیاری دکەی کا کلاس ژ کێ ڤە دگریت:</p><pre>class Animal {\n    String name;\n\n    Animal(String name) {\n        this.name = name;\n    }\n\n    void eat() {\n        System.out.println(name + " dexwêt");\n    }\n}\n\nclass Dog extends Animal {\n    Dog(String name) {\n        super(name);\n    }\n}</pre><p>ئەڤ جارێ <code>Dog</code> هەمی تایبەتمەندی و فەنکشنێن <code>Animal</code> بۆماوە هەن، بێ دوبارەنڤیسینێ. پێ <code>super()</code> کۆنسترۆکتەرێ کلاسا سەرەکی بانگ دکەی.</p><p>بۆماوە کۆدکەت کورت و ڕێک و پێک دکەت: گۆڕانکارییەکا بچویک د کلاسا سەرەکی دا ل هەمی کلاسێن وەرگرتوو دا جێبەجێ دبیت.</p>',
        'code' => 'class Animal {
    String name;

    Animal(String name) {
        this.name = name;
    }

    void eat() {
        System.out.println(name + " dexwêt");
    }
}

class Dog extends Animal {
    Dog(String name) {
        super(name);
    }
}

class Ferga {
    public static void main(String[] args) {
        Dog d = new Dog("Rex");
        d.eat();
    }
}',
        'example_output' => 'Rex dexwêt',
        'challenge_desc_so' => 'کلاسی Vehicle بە خانەی brand و فەنکشنی start دروست بکە و کلاسی Car بۆماوەی لێ وەربگرێت؛ پاشان بە brand="Toyota" فەنکشنی start چاپ بکە',
        'challenge_desc_ba' => 'کلاسا Vehicle ب تایبەتمەندی brand و فەنکشنا start دروست بکە و کلاسا Car بۆماوەی ژێ وەربگریت؛ پاشان ب brand="Toyota" فەنکشنا start چاپ بکە',
        'expected_output' => 'Toyota is starting',
    ],
    [
        'order' => 25,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پۆلیمۆرفیزم (Method Overriding)',
        'title_ba' => 'پۆلیمۆرفیزم (Method Overriding)',
        'content_so' => '<p>کاتێک subclass فەنکشنێکی superclass بە هەمان ناو و هەمان پێکهاتە (signature) دیسان جێبەجێ دەکات، پێی دەگوترێت <strong>method overriding</strong>. بە نیشانەی <code>@Override</code> دەریدەبڕیت تا Java هەڵەت بکات ئەگەر ناوەکە گونجاو نەبوو:</p><pre>class Animal {\n    void sound() {\n        System.out.println("Deng");\n    }\n}\n\nclass Cat extends Animal {\n    @Override\n    void sound() {\n        System.out.println("Mew");\n    }\n}</pre><p>لە <strong>پۆلیمۆرفیزم</strong> دا، دەتوانیت ئاماژەی کلاسی باوک بۆ ئۆبجێکتی منداڵ بەکاربهێنیت: <code>Animal a = new Cat();</code>. لە کاتی کارکردندا Java فەنکشنی ڕاستەقینەی ئۆبجێکتەکە جێبەجێ دەکات — نەک جۆری ئاماژەکە.</p><p>بەمەوە کۆدی گشتی دەنووسیت کە لەگەڵ هەر کلاسێکی نوێدا کاردەکات، بەبێ گۆڕینی.</p>',
        'content_ba' => '<p>دمایە subclass فەنکشنەکا superclass ب هەمان ناڤ و هەمان پێکهات (signature) دیسان جێبەجێ دکەت، پێی دبێژن <strong>method overriding</strong>. ب نیشانا <code>@Override</code> دەریببڕیت تا Java خەلەتەک بکەت گەر ناڤەک نەگونجیت:</p><pre>class Animal {\n    void sound() {\n        System.out.println("Deng");\n    }\n}\n\nclass Cat extends Animal {\n    @Override\n    void sound() {\n        System.out.println("Mew");\n    }\n}</pre><p>د <strong>پۆلیمۆرفیزم</strong> دا، تۆ دکەی ئاماژەیا کلاسا باڤ بۆ ئۆبجێکتا زارۆک بکاربینیت: <code>Animal a = new Cat();</code>. د دەمێ کارکرنێ دا Java فەنکشنا ڕاستەقینە یا ئۆبجێکتی جێبەجێ دکەت — نەک چەشنا ئاماژەیێ.</p><p>پێ ڤێ یە تۆ کۆدێ گشتی دینڤیسی کو د گەل هەر کلاسەکا نوی دا کاردکەت، بێ گۆڕینێ.</p>',
        'code' => 'class Animal {
    void sound() {
        System.out.println("Deng");
    }
}

class Cat extends Animal {
    @Override
    void sound() {
        System.out.println("Mew");
    }
}

class Ferga {
    public static void main(String[] args) {
        Animal a = new Cat();
        a.sound();
    }
}',
        'example_output' => 'Mew',
        'challenge_desc_so' => 'کلاسی Bird بە فەنکشنی fly و کلاسی Sparrow کە overriding دەکات و "Sparrow flies fast" چاپ دەکات دروست بکە',
        'challenge_desc_ba' => 'کلاسا Bird ب فەنکشنا fly و کلاسا Sparrow کو overriding دکەت و "Sparrow flies fast" چاپ دکەت دروست بکە',
        'expected_output' => 'Sparrow flies fast',
    ],
    [
        'order' => 26,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'کەپسولکردن (Encapsulation)',
        'title_ba' => 'کەپسولکرن (Encapsulation)',
        'content_so' => '<p><strong>کەپسولکردن (Encapsulation)</strong> بنەمایەکی OOP یە کە دەڵێت داتا دەبێت بە تایبەتمەندی <code>private</code> شاراوە بێت و تەنها لە ڕێگەی فەنکشنی گشتییەوە (getter/setter) دەستبکەوێت:</p><pre>class BankAccount {\n    private double balance;\n\n    public double getBalance() {\n        return balance;\n    }\n\n    public void deposit(double amount) {\n        balance += amount;\n    }\n}</pre><p>هیچ کۆدێکی دەرەکی ناتوانێت ڕاستەوخۆ <code>balance</code> بگۆڕێت یان بخوێنێتەوە — هەموو کارلێک لە ڕێگەی فەنکشنەکانەوەیە. ئەمە پێی دەگوترێت <strong>data hiding</strong>.</p><p>کەپسولکردن ڕێگا دەدات مەرج و پشکنین لە ناو فەنکشنەکاندا دابنێیت — بۆ نموونە ڕێگرتن لە زیادکردنی قەرز.</p>',
        'content_ba' => '<p><strong>کەپسولکرن (Encapsulation)</strong> بنەمایەکا OOP یە کو دبێژت داتا دڤێت ب تایبەتمەندی <code>private</code> شاری بیت و تەنێ ژ ڕێگای فەنکشنێن گشتی (getter/setter) ڤە دەستکەڤیت:</p><pre>class BankAccount {\n    private double balance;\n\n    public double getBalance() {\n        return balance;\n    }\n\n    public void deposit(double amount) {\n        balance += amount;\n    }\n}</pre><p>هیچ کۆدەکا دەرڤەی ناتڤیت ڕاستەوخۆ <code>balance</code> بگۆڕیت یا بخوینیت — هەمی کارلێک ژ ڕێگای فەنکشنان ڤە. ئەڤە پێی دبێژن <strong>data hiding</strong>.</p><p>کەپسولکرن ڕێ ددەت مەرج و پشکنین د ناڤ فەنکشنان دا دابنێی — بۆ نموونە ڕێگرتن ل زێدەکرنا قەرز.</p>',
        'code' => 'class BankAccount {
    private double balance;

    public double getBalance() {
        return balance;
    }

    public void deposit(double amount) {
        balance += amount;
    }
}

class Ferga {
    public static void main(String[] args) {
        BankAccount acc = new BankAccount();
        acc.deposit(500);
        acc.deposit(150);
        System.out.println("Balance = " + acc.getBalance());
    }
}',
        'example_output' => 'Balance = 650.0',
        'challenge_desc_so' => 'کلاسی Student بە خانەی name و getter و setter دروست بکە، ناوەکە ببەستە بە "Zana" و چاپی بکە',
        'challenge_desc_ba' => 'کلاسا Student ب تایبەتمەندی name و getter و setter دروست بکە، ناڤی ببستە ب "Zana" و چاپا وی بکە',
        'expected_output' => 'Zana',
    ],
    [
        'order' => 27,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Interface',
        'title_ba' => 'Interface',
        'content_so' => '<p><strong>Interface</strong> وەک پەیمانێک (contract) یە: دیاری دەکات کام فەنکشنەکان کلاسێک دەبێت هەیبێت، بەڵام جێبەجێکردنەکەیان لە کلاسەکەدا دەنووسرێت. بە وشەی <code>interface</code> دیاری و بە <code>implements</code> جێبەجێ دەکەیت:</p><pre>interface Flyable {\n    void fly();\n}\n\nclass Eagle implements Flyable {\n    @Override\n    public void fly() {\n        System.out.println("Eagle flies high");\n    }\n}</pre><p>کلاسێک دەتوانێت چەند interface یەک جێبەجێ بکات بە جیاکردنەوەیان بە کۆما. بەمەوە Java <strong>multiple inheritance</strong> بەدەست دەهێنێت بەبێ ئاڵۆزی و پێکدادانی کلاسەکان.</p><p>هەر کلاسێک کە <code>implements Flyable</code> دەکات دەبێت <code>fly()</code> بنووسێت — ئەمە دڵنیامان دەکات کە هەموو کلاسەکان هەمان پێکهاتە هەن.</p>',
        'content_ba' => '<p><strong>Interface</strong> وەک پەیمانەک (contract) یە: دیاری دکەت کا چ فەنکشن کلاسەک دڤێت هەبن، بەلێ جێبەجێکرنا وان د کلاسێ دا دەنڤیسیت. ب وشەی <code>interface</code> دیاری و ب <code>implements</code> جێبەجێ دکەی:</p><pre>interface Flyable {\n    void fly();\n}\n\nclass Eagle implements Flyable {\n    @Override\n    public void fly() {\n        System.out.println("Eagle flies high");\n    }\n}</pre><p>کلاسەک دشییت چەند interface ێ یەک جێبەجێ بکەت ب جوداکرنا وان ب کۆما. پێ ڤێ یە Java <strong>multiple inheritance</strong> بیدەست دیت بێ ئاڵۆزی و پێکدادانا کلاسان.</p><p>هەر کلاسەکا کو <code>implements Flyable</code> دکەت دڤێت <code>fly()</code> بنڤیسیت — ئەڤە دڵنیامان دکەت کو هەمی کلاس هەمان پێکهات هەن.</p>',
        'code' => 'interface Flyable {
    void fly();
}

class Eagle implements Flyable {
    @Override
    public void fly() {
        System.out.println("Eagle flies high");
    }
}

class Ferga {
    public static void main(String[] args) {
        Flyable f = new Eagle();
        f.fly();
    }
}',
        'example_output' => 'Eagle flies high',
        'challenge_desc_so' => 'interface ی "Playable" بە فەنکشنی play دروست بکە و کلاسی "Guitar" کە جێبەجێی دەکات و "Guitar is playing" چاپ دەکات',
        'challenge_desc_ba' => 'interface ی "Playable" ب فەنکشنا play دروست بکە و کلاسا "Guitar" کو جێبەجێی دکەت و "Guitar is playing" چاپ دکەت',
        'expected_output' => 'Guitar is playing',
    ],
    [
        'order' => 28,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'Abstract Class',
        'title_ba' => 'Abstract Class',
        'content_so' => '<p><strong>Abstract class</strong> کلاسێکە کە ناتوانیت ئۆبجێکتی لێ دروست بکەیت، بەڵام دەتوانێت فەنکشنی <code>abstract</code> ی هەبێت — فەنکشنێک بە نیشانە بەبێ جێبەجێکردن. هەر کلاسی منداڵێک دەبێت ئەو فەنکشنانە جێبەجێ بکات:</p><pre>abstract class Shape {\n    abstract double area();\n\n    void info() {\n        System.out.println("This is a shape");\n    }\n}\n\nclass Square extends Shape {\n    double side;\n\n    Square(double side) {\n        this.side = side;\n    }\n\n    @Override\n    double area() {\n        return side * side;\n    }\n}</pre><p>جیاوازی لەگەڵ interface: کلاسی abstract دەتوانێت خانە و کۆنسترۆکتەر و فەنکشنی ئاسایی هەبێت، و کلاسێک تەنها یەک کلاسی abstract بۆماوە دەبێت. بەڵام interface تەنها دیاریی فەنکشنە.</p><p>کاتێک بنەمایەکی هاوبەش لەگەڵ هەندێک جێبەجێکردنی ئاسایی هەیە، کلاسی abstract باشترە؛ کاتێک تەنها پێویست بە پەیمانە، interface بەکاربهێنە.</p>',
        'content_ba' => '<p><strong>Abstract class</strong> کلاسەکا یە کو ناتڤی ئۆبجێکت ژێ دروست بکەی، بەلێ دشییت فەنکشنێن <code>abstract</code> هەبن — فەنکشنەک ب نیشانا بێ جێبەجێکرن. هەر کلاسا زارۆکا دڤێت ئەو فەنکشنان جێبەجێ بکەت:</p><pre>abstract class Shape {\n    abstract double area();\n\n    void info() {\n        System.out.println("This is a shape");\n    }\n}\n\nclass Square extends Shape {\n    double side;\n\n    Square(double side) {\n        this.side = side;\n    }\n\n    @Override\n    double area() {\n        return side * side;\n    }\n}</pre><p>جوداهیا ژ interface: کلاسا abstract دشییت تایبەتمەندی و کۆنسترۆکتەر و فەنکشنێن ئاسایی هەبن، و کلاسەک تەنێ یەک کلاسا abstract بۆماوە دبیت. بەلێ interface تەنێ دیاریا فەنکشنان یە.</p><p>دمایە بنەمایەکا هاوبەش د گەل هینەک جێبەجێکرنا ئاسایی هەبیت، کلاسا abstract باشترە؛ دمایە تەنێ پێویستی ب پەیمانە، interface بکاربینە.</p>',
        'code' => 'abstract class Shape {
    abstract double area();

    void info() {
        System.out.println("This is a shape");
    }
}

class Square extends Shape {
    double side;

    Square(double side) {
        this.side = side;
    }

    @Override
    double area() {
        return side * side;
    }
}

class Ferga {
    public static void main(String[] args) {
        Square sq = new Square(4);
        sq.info();
        System.out.println("Area = " + sq.area());
    }
}',
        'example_output' => 'This is a shape
Area = 16.0',
        'challenge_desc_so' => 'کلاسی abstract ی "Vehicle" بە فەنکشنی abstract ی start دروست بکە و کلاسی "Motorcycle" کە "Motorcycle starts" چاپ دەکات',
        'challenge_desc_ba' => 'کلاسا abstract یا "Vehicle" ب فەنکشنا abstract یا start دروست بکە و کلاسا "Motorcycle" کو "Motorcycle starts" چاپ دکەت',
        'expected_output' => 'Motorcycle starts',
    ],
    [
        'order' => 29,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: کۆی ئارای بە for-each',
        'title_ba' => 'پرۆژە: کوما ئارای ب for-each',
        'content_so' => '<p>ئەم جارە کۆی ئارایەک لەگەڵ خولگەی <code>for-each</code> کۆ دەکەینەوە:</p><pre>static int sumArray(int[] arr) {\n    int total = 0;\n    for (int n : arr) {\n        total += n;\n    }\n    return total;\n}\n\nint[] nums = {5, 10, 15, 20};\nint sum = sumArray(nums);   // 50</pre><p><code>for-each</code> بەسەر هەموو ئەندامەکاندا دەسوڕێتەوە بەبێ نیاز بە ئیندێکس — سادەتر و خوێنەراوترە بۆ کۆکردنەوە.</p>',
        'content_ba' => '<p>ئەڤ جارێ کوما ئارایەک د گەڕخستنا <code>for-each</code> دا کۆ دکەین:</p><pre>static int sumArray(int[] arr) {\n    int total = 0;\n    for (int n : arr) {\n        total += n;\n    }\n    return total;\n}\n\nint[] nums = {5, 10, 15, 20};\nint sum = sumArray(nums);   // 50</pre><p><code>for-each</code> بسەر هەمی ئەندامان دا دگەڕیت بێ پێویستی ب ئیندێکس — سادەتر و خویندرەوەترە بۆ کۆمکرنێ.</p>',
        'code' => 'class Ferga {
    static int sumArray(int[] arr) {
        int total = 0;
        for (int n : arr) {
            total += n;
        }
        return total;
    }

    public static void main(String[] args) {
        int[] nums = {5, 10, 15, 20};
        System.out.println("Kur = " + sumArray(nums));
    }
}',
        'example_output' => 'Kur = 50',
        'challenge_desc_so' => 'کۆی ئارای {4, 8, 6, 2} بە for-each بدۆزەرەوە و چاپی بکە',
        'challenge_desc_ba' => 'کوما ئارای {4, 8, 6, 2} ب for-each بدۆزە و چاپا وی بکە',
        'expected_output' => '20',
    ],
    [
        'order' => 30,
        'level_so' => 'ئاستی ٣ - پێشکەوتوو',
        'level_ba' => 'ئاستا ٣ - پێشکەفتی',
        'title_so' => 'پرۆژە: FizzBuzz',
        'title_ba' => 'پرۆژە: FizzBuzz',
        'content_so' => '<p>FizzBuzz بەناوبانگترین تاقیکردنەوەی بەرنامەسازە. بۆ هەر ژمارەیەک لە 1 بۆ 15:</p><pre>if (i % 15 == 0)  → "FizzBuzz"\nelse if (i % 3 == 0) → "Fizz"\nelse if (i % 5 == 0) → "Buzz"\nelse            → i</pre><p>بە سێ ژمارە و چوار مەرج هەموو حاڵەتەکان دادەپۆشێت. ئاگاداری ڕیزبەندی مەرجەکان بە — بەرچاو یەکەم دەبێت <code>% 15</code> بێت.</p>',
        'content_ba' => '<p>FizzBuzz ناڤدارترین تاقیکرنا بەرنامەسازانە. بو هەر ژمارەکا ژ 1 هەتا 15:</p><pre>if (i % 15 == 0)  → "FizzBuzz"\nelse if (i % 3 == 0) → "Fizz"\nelse if (i % 5 == 0) → "Buzz"\nelse            → i</pre><p>پێ سێ ژماران و چوار مەرجان هەمی حاڵەت تێدا دڕەڤیت. هشیاری ڕیزا مەرجان — بەری هەمی دڤێت <code>% 15</code> بیت.</p>',
        'code' => 'class Ferga {
    public static void main(String[] args) {
        for (int i = 1; i <= 15; i++) {
            if (i % 15 == 0) {
                System.out.println("FizzBuzz");
            } else if (i % 3 == 0) {
                System.out.println("Fizz");
            } else if (i % 5 == 0) {
                System.out.println("Buzz");
            } else {
                System.out.println(i);
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
        'challenge_desc_so' => 'FizzBuzz بۆ 1 بۆ 5 بنووسە: هەر یەکەیان لە ڕیزی جیادا',
        'challenge_desc_ba' => 'FizzBuzz بو 1 هەتا 5 بنڤیسە: هەر یەک د ڕیزەکا جودا',
        'expected_output' => '1
2
Fizz
4
Buzz',
    ],
];

if (defined('FERGA_SEED_LIB')) {
    $FERGA_SEED_LIBS['java'] = ['langId' => '-Oysj4DmsfjAe6mjjfjT', 'lessons' => $lessons];
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

echo "\nDone! Java lessons have been added to Ferga.\n";
