<?php

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$idToken = trim(file_get_contents('/tmp/opencode/fb_token.txt'));
$pythonLangId = '-OypFoFNvHfBuaA2Uh7O';

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

$L1SO = 'ئاستی ١ - دەستپێکردن';
$L1BA = 'ئاستا ١ - دەستپێکرن';
$L2SO = 'ئاستی ٢ - مەرج و خولگە';
$L2BA = 'ئاستا ٢ - مەرج و گەڕخستن';
$L3SO = 'ئاستی ٣ - لیست و داتا';
$L3BA = 'ئاستا ٣ - لیست و داتا';
$L4SO = 'ئاستی ٤ - فەنکشن و فایل';
$L4BA = 'ئاستا ٤ - فەنکشن و فایل';
$L5SO = 'ئاستی ٥ - پرۆژەکان';
$L5BA = 'ئاستا ٥ - پرۆژە';

$lessons = [];

$lessons[] = lesson(1, $L1SO, $L1BA,
'چییە Python؟', 'چ یە Python؟',
<<<'SO'
<p><strong>Python</strong> یەکێکە لە ئاسانترین و بەناوبانگترین زمانەکانی پرۆگرامکردن لە جیهاندا. لەلایەن <strong>Guido van Rossum</strong> لە ساڵی ١٩٩١ دروستکراوە.</p>
<p>بۆچی Python فێربین؟</p>
<ul>
<li>ئاسانە بۆ فێربوون - شێوازی نووسینی وەک زمانە ئاساییەکانە</li>
<li>بەکاردێت لە <bdi>AI</bdi>، شیکردنەوەی داتا، وێب و زۆر بوار</li>
<li>کۆمەڵێک گەورەی فەرمانگە و ئامرازەکان</li>
<li>داواکاری زۆری لە بازارى کاردا</li>
</ul>
<p>لەم کۆرسەدا هەنگاو بە هەنگاو لە سفرەوە فێری دەبین.</p>
SO,
<<<'BA'
<p><strong>Python</strong> ئێک ژ زمانێن هەرە بساناهی و ناودار یێن پروگرامسازییێ یە ل جیهانێ دا. ل لایەن <strong>Guido van Rossum</strong> د سالا ١٩٩١ هاتیە دروستکرن.</p>
<p>بوچ Python فێربین؟</p>
<ul>
<li>بساناهیە بو فێربوونێ - شێوازێ نڤیسینا وی وەک زمانێن ئاساییانە</li>
<li>بکارتیت د <bdi>AI</bdi>، شیکرنا داتایێ، وێب و چەندەها بواران دا</li>
<li>کۆمەکەکا مەزن ژ پێکهاتان و ئامرازان</li>
<li>داوکریا وی زێدەیە د بازارێ کارێ دا</li>
</ul>
<p>د ڤێ کورسێ دا پێنگاڤ ب پێنگاڤ ژ سفری ڤە فێر دبیت.</p>
BA,
"print(\"Bexhî xêr!\")\nprint('Hello, Kurdistan!')",
"Bexhî xêr!\nHello, Kurdistan!",
'پرۆگرامێک بنووسە کە دوو هێڵ چاپ بکات: "Salam" و "Python"',
'پرۆگرامەک بنڤیسە کو دوو هێڵان چاپ بکەت: "Salam" و "Python"',
"Salam\nPython");

$lessons[] = lesson(2, $L1SO, $L1BA,
'فەرمانی print', 'فەرمانا print',
<<<'SO'
<p>فەرمانی <code>print()</code> بەکاردێت بۆ پیشاندانی دەق یان بەها لەسەر شاشە. ئەمە یەکەم فەرمانە کە فێری دەبیت.</p>
<pre>print("Hello World")   # دەقی سادە\nprint(42)              # ژمارە\nprint(3.14)            # ژمارەی دەیی\nprint(True)            # ڕاست/هەڵە</pre>
<p>دەتوانیت بە کۆما (<code>,</code>) چەند بەهایەک لە یەک فەرماندا چاپ بکەیت:</p>
<pre>print("Salam", "Kurd", 2026)</pre>
SO,
<<<'BA'
<p>فەرمانا <code>print()</code> بکارتیت بو نیشاندانا دەقێ یا بەهایێ ل سەر شاشێ. ئەڤە ئێکەم فەرمانە کو تۆ فێر دبی.</p>
<pre>print("Hello World")   # دەقەکا سادە\nprint(42)              # ژمارە\nprint(3.14)            # ژمارەیا دەهی\nprint(True)            # راست/خەلەت</pre>
<p>تو دکەی ب کۆمایێ (<code>,</code>) چەند بەهان د ئێک فەرمانێ دا چاپ بکی:</p>
<pre>print("Salam", "Kurd", 2026)</pre>
BA,
'print("Hello World")',
'Hello World',
'بە print فەرمانێک بنووسە کە ناوی تۆ چاپ بکات',
'ب print فەرمانەک بنڤیسە کو ناڤێ تە چاپ بکەت',
"Kurd");

$lessons[] = lesson(3, $L1SO, $L1BA,
'تێبینییەکان (Comments)', 'شیرحەت (Comments)',
<<<'SO'
<p><strong>تێبینی (Comment)</strong> دەقێکە کە پرۆگرامەکە جێی ناکاتەوە، بەڵام بۆ خوێندنەوەی کۆد و ڕوونکردنەوە بەکاردێت.</p>
<pre># ئەمە تێبینییەکی هێڵی یەکە\n\nprint("Hello")  # تێبینی لە دوای کۆدیش دەکرێت\n\n\"\"\"\nئەمە تێبینییەکی فرە هێڵی یە\nدەتوانیت چەند هێڵ بنووسیت\n\"\"\"</pre>
<p>تێبینییەکان باشترین هاوڕێی پرۆگرامەرانن — کۆدی خۆت بۆ داهاتوو ڕوون بکەرەوە!</p>
SO,
<<<'BA'
<p><strong>شیرحەت (Comment)</strong> دەقەکە کو پروگرام جێناکەتە ڤە، بەلێ بو خواندنا کۆدی و روونکرنا وی بکارتیت.</p>
<pre># ئەڤە شیرحەتەکا هێلی یەکە\n\nprint("Hello")  # شیرحەت پشتی کۆدی ژی دهێتە نڤیسین\n\n\"\"\"\nئەڤە شیرحەتەکا پیری هێلی یە\nتو دکەی چەند هێلان بنڤیسی\n\"\"\"</pre>
<p>شیرحەت باشترین هەڤڕێیێن پرۆگرامەرانن — کۆدێ خۆ بو دەمێ بەری روون بکە!</p>
BA,
'# ناوی قوتابی\nname = "Ahmad"\n# چاپکردن\nprint(name)',
'Ahmad',
'تێبینییەک دابنێ و ژمارەیەک تێیدا چاپ بکە',
'شیرحەتەک دابنێ و ژمارەیەک تێدا چاپ بکە',
"5");

$lessons[] = lesson(4, $L1SO, $L1BA,
'گۆڕاوەکان (Variables)', 'گۆڕۆک (Variables)',
<<<'SO'
<p><strong>گۆڕاو (Variable)</strong> شوێنێکە لە یادگەدا کە بەهایەک تێدا هەڵدەگرین. لە Python بۆ دروستکردنی گۆڕاو بە سادەیی ناو و بەهاکە دەنووسین:</p>
<pre>name = "Kurd"      # دەق (string)\nage = 25           # ژمارەی تەواو (int)\nprice = 19.99      # ژمارەی دەیی (float)\nis_student = True  # ڕاست/هەڵە (bool)</pre>
<p>تایبەتمەندییەکانی گۆڕاوەکان:</p>
<ul>
<li>ناوەکە دەبێت بە پیت دەست پێ بکات</li>
<li>هەستیارە بە پیتی گەورە و بچووک: <code>name</code> و <code>Name</code> جیاوازن</li>
<li>ناوی بە واتادار هەڵبژێرە</li>
</ul>
SO,
<<<'BA'
<p><strong>گۆڕۆک (Variable)</strong> جهەکە د بیرێ دا کو بەهایەک تێدا دگریین. د Python دا بو دروستکرنا گۆڕۆکی ب سادەیی ناڤ و بەهایێ دینڤیسین:</p>
<pre>name = "Kurd"      # دەق (string)\nage = 25           # ژمارەیا تەمام (int)\nprice = 19.99      # ژمارەیا دەهی (float)\nis_student = True  # راست/خەلەت (bool)</pre>
<p>تایبەتمەندییێن گۆڕۆکان:</p>
<ul>
<li>ناڤێ وی دڤێت ب پیتەکا دەست پێ بکەت</li>
<li>هەستارە ب پیتێن مەزن و بچویک: <code>name</code> و <code>Name</code> جودان</li>
<li>ناڤێکی ب واتا هەلبژێرە</li>
</ul>
BA,
'name = "Ahmad"\nage = 20\nprint("Name:", name)\nprint("Age:", age)',
'Name: Ahmad\nAge: 20',
'گۆڕاوێک بە ناوی "city" بە بەهای "Hewlêr" دروست بکە و چاپی بکە',
'گۆڕۆکەک ب ناڤێ "city" ب بەهایا "Hewlêr" دروست بکە و چاپا وی بکە',
"Hewlêr");

$lessons[] = lesson(5, $L1SO, $L1BA,
'جۆرەکانی داتا (Data Types)', 'چەشنێن داتایێ (Data Types)',
<<<'SO'
<p>لە Python چەند جۆری داتا بنەڕەتی هەیە:</p>
<pre># دەق (String)\ntext = "Salam"\n\n# ژمارەی تەواو (Integer)\nn = 10\n\n# ژمارەی دەیی (Float)\nf = 3.14\n\n# ڕاست/هەڵە (Boolean)\nb = True\n\n# هیچ (None)\nx = None</pre>
<p>بە فەرمانی <code>type()</code> دەتوانیت جۆری هەر بەهایەک بزانیت:</p>
<pre>print(type("Salam"))  # &lt;class 'str'&gt;\nprint(type(10))       # &lt;class 'int'&gt;</pre>
SO,
<<<'BA'
<p>د Python دا چەند چەشنی داتایێ بنەرەتی هەن:</p>
<pre># دەق (String)\ntext = "Salam"\n\n# ژمارەیا تەمام (Integer)\nn = 10\n\n# ژمارەیا دەهی (Float)\nf = 3.14\n\n# راست/خەلەت (Boolean)\nb = True\n\n# چ (None)\nx = None</pre>
<p>ب فەرمانا <code>type()</code> تو دکەی چەشنێ هەر بەهایەکی بزانی:</p>
<pre>print(type("Salam"))  # &lt;class 'str'&gt;\nprint(type(10))       # &lt;class 'int'&gt;</pre>
BA,
'print(type(2026))\nprint(type(3.14))\nprint(type("AI"))',
"<class 'int'>\n<class 'float'>\n<class 'str'>",
'جۆری بەهای True چاپ بکە بە type()',
'چەشنێ بەهایێ True چاپ بکە ب type()',
"<class 'bool'>");

$lessons[] = lesson(6, $L1SO, $L1BA,
'ژمارە و بیرکاری (Numbers)', 'ژمارە و بیرکاری (Numbers)',
<<<'SO'
<p>لە Python هەموو کردەوە بیرکارییەکان دەتوانیت جێبەجێ بکەیت:</p>
<pre>print(10 + 3)    # کۆکردنەوە → 13\nprint(10 - 3)    # کەمکردنەوە → 7\nprint(10 * 3)    # زۆرکردن → 30\nprint(10 / 3)    # دابەشکردن → 3.333...\nprint(10 // 3)   # دابەشی تەواو → 3\nprint(10 % 3)    # ماوە (بەش) → 1\nprint(2 ** 3)    # توان → 8</pre>
<p><strong>کردەوەکانی کورتکردنەوە:</strong></p>
<pre>x = 5\nx += 2   # هەمان x = x + 2\ny = 5\ny -= 1   # هەمان y = y - 1</pre>
SO,
<<<'BA'
<p>د Python دا هەمی کردارێن بیرکاری تو دکەی جێبەجێ بکی:</p>
<pre>print(10 + 3)    # کۆکرن → 13\nprint(10 - 3)    # کەمکرن → 7\nprint(10 * 3)    # زێدەکرن → 30\nprint(10 / 3)    # پارڤەکرن → 3.333...\nprint(10 // 3)   # پارڤەکرنا تەمام → 3\nprint(10 % 3)    # مایین (بەش) → 1\nprint(2 ** 3)    # هێز → 8</pre>
<p><strong>کردارێن کورتکرنێ:</strong></p>
<pre>x = 5\nx += 2   # هەمان x = x + 2\ny = 5\ny -= 1   # هەمان y = y - 1</pre>
BA,
'x = 7\ny = 2\nprint(x + y)\nprint(x * y)\nprint(x % y)',
"9\n14\n1",
'ئەنجامی 10 ÷ 4 و 10 ÷ 4 (دابەشی تەواو) چاپ بکە',
'ئەنجامێ 10 ÷ 4 و 10 ÷ 4 (پارڤەکرنا تەمام) چاپ بکە',
"2.5\n2");

$lessons[] = lesson(7, $L1SO, $L1BA,
'دەقەکان (Strings)', 'دەق (Strings)',
<<<'SO'
<p><strong>دەق (String)</strong> کۆمەڵێک پیتە. لە Python بە نووسینی نێوان دوو فەرقۆخانە دروست دەبێت: <code>'</code> یان <code>"</code>.</p>
<pre>name = "Kurd AI"\ncity = 'Hewlêr'</pre>
<p>کردەوە سەرەکییەکان:</p>
<pre># پێکەوەبەستن (Concatenation)\nprint("Salam" + " " + "Kurd")   # Salam Kurd\n\n# دووبارەکردنەوە\nprint("Ha" * 3)                 # HaHaHa\n\n# درێژایی دەقەکە\nprint(len("Kurd"))              # 4</pre>
SO,
<<<'BA'
<p><strong>دەق (String)</strong> کۆمەکەکا پیتانە. د Python دا ب نڤیسینا ناڤبەرا دوو فەرقۆخانان دروست دبیت: <code>'</code> یا <code>"</code>.</p>
<pre>name = "Kurd AI"\ncity = 'Hewlêr'</pre>
<p>کردارێن سەرەکی:</p>
<pre># پێکڤەبستن (Concatenation)\nprint("Salam" + " " + "Kurd")   # Salam Kurd\n\n# دوبارەکرن\nprint("Ha" * 3)                 # HaHaHa\n\n# درێژاییا دەقی\nprint(len("Kurd"))              # 4</pre>
BA,
'print("Kurd" + "istan")\nprint("AI" * 2)\nprint(len("Hello"))',
"Kurdistan\nAIAI\n5",
'درێژایی وشەی "Programming" چاپ بکە بە len()',
'درێژاییا بەژەیا "Programming" چاپ بکە ب len()',
"11");

$lessons[] = lesson(8, $L1SO, $L1BA,
'وەرگرتنی داتا (input)', 'هەلگرتنا داتایێ (input)',
<<<'SO'
<p>بە فەرمانی <code>input()</code> دەتوانیت داتا لە بەکارهێنەر وەربگریت. هەموو داتایەک کە وەردەگریت <strong>دەق</strong>ە:</p>
<pre>name = input("What is your name? ")\nprint("Salam", name)</pre>
<p>بۆ ژمارە پێویستە بە <code>int()</code> یان <code>float()</code> بگۆڕیت:</p>
<pre>age = int(input("Your age? "))\nprint("Next year you will be", age + 1)</pre>
SO,
<<<'BA'
<p>ب فەرمانا <code>input()</code> تو دکەی داتا ژ بکارهێنەری هەلگری. هەمی داتایا کو هەلدگریت <strong>دەق</strong>ە:</p>
<pre>name = input("What is your name? ")\nprint("Salam", name)</pre>
<p>بو ژمارەیان دڤێت ب <code>int()</code> یا <code>float()</code> بگۆڕی:</p>
<pre>age = int(input("Your age? "))\nprint("Next year you will be", age + 1)</pre>
BA,
'name = "Ahmad"\nprint("Hello", name)',
'Hello Ahmad',
'پرۆگرامێک بنووسە کە تەمەن وەربگرێت و بە ٥ سال زیاتر پیشانی بدات (بەبێ input: age=20)',
'پرۆگرامەک بنڤیسە کو تەمەن هەلگریت و ب ٥ سال زێدەتر نیشان بدەت (بەبێ input: age=20)',
"25");

$lessons[] = lesson(9, $L1SO, $L1BA,
'مەرجی if', 'مەرجا if',
<<<'SO'
<p>بە <code>if</code> دەتوانیت بڕیار بدەیت لەسەر ڕوودانی شتێک:</p>
<pre>age = 20\n\nif age &gt;= 18:\n    print("You are an adult")\n\nif age &lt; 18:\n    print("You are a child")</pre>
<p><strong>گرنگ:</strong> لە Python بۆ بلۆکەکان بۆشایی چوار خانە (تەب) بەکاردێت، نەک کەوانەی { } وەک C++.</p>
SO,
<<<'BA'
<p>ب <code>if</code> تو دکەی بریار بدەی ل سەر ڕویدانا شتەکی:</p>
<pre>age = 20\n\nif age &gt;= 18:\n    print("You are an adult")\n\nif age &lt; 18:\n    print("You are a child")</pre>
<p><strong>گرنگ:</strong> د Python دا بو بلۆکان بۆشایا چوار خانان (تاب) بکارتیت، نەک کەوانە { } وەک C++.</p>
BA,
'num = 10\nif num > 5:\n    print("Big number")',
'Big number',
'ئەگەر x=15 و لە ١٠ گەورەتر بێت "Big" چاپ بکە',
'گەر x=15 و ژ ١٠ مەزنتر بیت "Big" چاپ بکە',
"Big");

$lessons[] = lesson(10, $L1SO, $L1BA,
'else و elif', 'else و elif',
<<<'SO'
<p>بە <code>else</code> بەشێک کۆد دەکەیت کە ئەگەر مەرجەکە هەڵە بوو جێبەجێ بێت، و بە <code>elif</code> (کورتکراوەی else if) چەند مەرجێک دەکەیت:</p>
<pre>score = 75\n\nif score &gt;= 90:\n    print("A")\nelif score &gt;= 70:\n    print("B")\nelif score &gt;= 50:\n    print("C")\nelse:\n    print("Fail")</pre>
<p>لەم نموونەیە ئەنجام دەبێت: <code>B</code></p>
SO,
<<<'BA'
<p>ب <code>else</code> بەشەکا کۆدی تو دکەی کو گەر مەرج خەلەت بیت جێبەجێ بیت، و ب <code>elif</code> (کورتکرنا else if) چەند مەرجان دکەی:</p>
<pre>score = 75\n\nif score &gt;= 90:\n    print("A")\nelif score &gt;= 70:\n    print("B")\nelif score &gt;= 50:\n    print("C")\nelse:\n    print("Fail")</pre>
<p>د ڤێ نموونەیێ دا دەرئەنجام دبیت: <code>B</code></p>
BA,
'x = 10\nif x > 15:\n    print("Big")\nelse:\n    print("Small")',
'Small',
'بە elif بەهای 60 بنووسە و پلەکەکەی چاپ بکە (90=A، 70=B، 50=C، ئەوانی تر=Fail)',
'ب elif بەهایا 60 بنڤیسە و پلەیا وی چاپ بکە (90=A، 70=B، 50=C، یێن دی=Fail)',
"C");

$lessons[] = lesson(11, $L1SO, $L1BA,
'ئۆپێراتۆرەکانی بەراوردکردن', 'ئۆپێراتۆرێن بەراوردکرنێ',
<<<'SO'
<p>ئۆپێراتۆرەکانی بەراوردکردن بەراورد دەکەن و لە جیاتی <code>True</code> یان <code>False</code> دەگەڕێننەوە:</p>
<pre>print(5 == 5)    # یەکسانە → True\nprint(5 != 3)    # یەکسان نییە → True\nprint(5 &gt; 3)     # گەورەتر → True\nprint(5 &lt; 3)     # بچووکتر → False\nprint(5 &gt;= 5)    # گەورەتر یان یەکسان → True\nprint(5 &lt;= 2)    # بچووکتر یان یەکسان → False</pre>
<p>دەتوانیت دەقیش بەراورد بکەیت:</p>
<pre>print("kurd" == "kurd")   # True\nprint("A" &lt; "B")          # True (ئەلفبێ)</pre>
SO,
<<<'BA'
<p>ئۆپێراتۆرێن بەراوردکرنێ بەراورد دکەن و ل شونا <code>True</code> یا <code>False</code> ڤەدگەڕینن:</p>
<pre>print(5 == 5)    # یەکسانە → True\nprint(5 != 3)    # نە یەکسانە → True\nprint(5 &gt; 3)     # مەزنتر → True\nprint(5 &lt; 3)     # بچویکتر → False\nprint(5 &gt;= 5)    # مەزنتر یا یەکسان → True\nprint(5 &lt;= 2)    # بچویکتر یا یەکسان → False</pre>
<p>تو دکەی دەقی ژی بەراورد بکی:</p>
<pre>print("kurd" == "kurd")   # True\nprint("A" &lt; "B")          # True (ئەلفبێ)</pre>
BA,
'print(10 > 5)\nprint(3 == 4)\nprint(7 != 7)',
'True\nFalse\nFalse',
'بەهای 8==8 و 8!=8 چاپ بکە',
'بەهایا 8==8 و 8!=8 چاپ بکە',
"True\nFalse");

$lessons[] = lesson(12, $L1SO, $L1BA,
'ئۆپێراتۆرە لۆژیکییەکان', 'ئۆپێراتۆرێن لۆژیکی',
<<<'SO'
<p>ئۆپێراتۆرە لۆژیکییەکان چەند مەرجێک پێکەوە دەبەستن:</p>
<pre># and - هەردووکیان دەبێت ڕاست بن\nprint(True and True)    # True\nprint(True and False)   # False\n\n# or - یەکێکیان بەسە\nprint(True or False)    # True\nprint(False or False)   # False\n\n# not - پێچەوانە\nprint(not True)         # False\nprint(not False)        # True</pre>
<p>نموونەی ڕاستەقینە:</p>
<pre>age = 25\nhas_id = True\n\nif age &gt;= 18 and has_id:\n    print("You can enter")\n\nif age &lt; 13 or age &gt; 60:\n    print("Free ticket")</pre>
SO,
<<<'BA'
<p>ئۆپێراتۆرێن لۆژیکی چەند مەرجان پێکڤە دبستن:</p>
<pre># and - هەردوو ژی دڤێت راست بن\nprint(True and True)    # True\nprint(True and False)   # False\n\n# or - ئێکەکا بەسە\nprint(True or False)    # True\nprint(False or False)   # False\n\n# not - پچەڤانا\nprint(not True)         # False\nprint(not False)        # True</pre>
<p>نموونەیا ڕاستەقینە:</p>
<pre>age = 25\nhas_id = True\n\nif age &gt;= 18 and has_id:\n    print("You can enter")\n\nif age &lt; 13 or age &gt; 60:\n    print("Free ticket")</pre>
BA,
'print(True and True)\nprint(True or False)\nprint(not False)',
'True\nTrue\nTrue',
'ئەگەر x=10 و y=5، مەرجی (x>5 and y<10) چاپ بکە',
'گەر x=10 و y=5، مەرجا (x>5 and y<10) چاپ بکە',
'True');

$lessons[] = lesson(13, $L1SO, $L1BA,
'خولگەی while', 'گەڕخستنا while',
<<<'SO'
<p>خولگەی <code>while</code> هەتا مەرجەکە ڕاستە کۆدەکە دووبارە دەکاتەوە:</p>
<pre>count = 1\n\nwhile count &lt;= 5:\n    print(count)\n    count += 1</pre>
<p>ئەنجام: <code>1 2 3 4 5</code></p>
<p><strong>گرنگ:</strong> ئاگاداربە لە خولگەی بێکۆتا! ئەگەر مەرجەکە هەرگیز هەڵە نەبێت، خولگەکە هەرگیز ناوەستێت.</p>
SO,
<<<'BA'
<p>گەڕخستنا <code>while</code> هەتا مەرج راستە کۆدی دوبارە دکەت:</p>
<pre>count = 1\n\nwhile count &lt;= 5:\n    print(count)\n    count += 1</pre>
<p>دەرئەنجام: <code>1 2 3 4 5</code></p>
<p><strong>گرنگ:</strong> ئاگاداربە ژ گەڕخستنا بێکۆتا! گەر مەرج هەرگیز خەلەت نەبیت، گەڕخستن هەرگیز ناڤەستیت.</p>
BA,
'count = 1\nwhile count <= 3:\n    print("Hi")\n    count += 1',
'Hi\nHi\nHi',
'بە while ژمارەکانی 1 بۆ 3 چاپ بکە',
'ب while ژمارێن 1 هەتا 3 چاپ بکە',
"1\n2\n3");

$lessons[] = lesson(14, $L1SO, $L1BA,
'خولگەی for', 'گەڕخستنا for',
<<<'SO'
<p>خولگەی <code>for</code> بەسەر کۆمەڵێک بەهادا دەسوڕێتەوە:</p>
<pre># بەسەر دەقەکەدا\nfor letter in "Kurd":\n    print(letter)\n\n# بەسەر لیستێکدا\nfor fruit in ["sêv", "mûz", "porteqal"]:\n    print(fruit)</pre>
<p>لە Python خولگەی for زۆر سادەترە لە C++ چونکە پێویستی بە شەرتی کۆتایی نییە.</p>
SO,
<<<'BA'
<p>گەڕخستنا <code>for</code> ل سەر کۆمەکەکا بەهایان دا دگەڕیت:</p>
<pre># ل سەر دەقی\nfor letter in "Kurd":\n    print(letter)\n\n# ل سەر لیستێکی\nfor fruit in ["sêv", "mûz", "porteqal"]:\n    print(fruit)</pre>
<p>د Python دا گەڕخستنا for زۆر سادەترە ژ C++ ژبەر کو پێداویستی ب شەرتی کۆتایی نینە.</p>
BA,
'for letter in "AI":\n    print(letter)',
'A\nI',
'بە for پیتەکانی "Go" چاپ بکە',
'ب for پیتێن "Go" چاپ بکە',
"G\no");

$lessons[] = lesson(15, $L1SO, $L1BA,
'فەرمانی range()', 'فەرمانا range()',
<<<'SO'
<p>فەرمانی <code>range()</code> زنجیرەیەک ژمارە دروست دەکات، زۆر بەسوودە لەگەڵ for:</p>
<pre>for i in range(5):      # 0 بۆ 4\n    print(i)\n\nfor i in range(1, 6):   # 1 بۆ 5\n    print(i)\n\nfor i in range(0, 10, 2):  # هەنگاوی 2\n    print(i)                # 0 2 4 6 8</pre>
<p>شێوازەکان:</p>
<ul>
<li><code>range(n)</code> → ٠ بۆ n-1</li>
<li><code>range(a, b)</code> → a بۆ b-1</li>
<li><code>range(a, b, c)</code> → بە هەنگاوی c</li>
</ul>
SO,
<<<'BA'
<p>فەرمانا <code>range()</code> زنجیرەکا ژماران دروست دکەت، زۆر ب سوودە ل گەڵ for:</p>
<pre>for i in range(5):      # 0 هەتا 4\n    print(i)\n\nfor i in range(1, 6):   # 1 هەتا 5\n    print(i)\n\nfor i in range(0, 10, 2):  # پێنگاڤا 2\n    print(i)                 # 0 2 4 6 8</pre>
<p>شێوازێن:</p>
<ul>
<li><code>range(n)</code> → ٠ هەتا n-1</li>
<li><code>range(a, b)</code> → a هەتا b-1</li>
<li><code>range(a, b, c)</code> → ب پێنگاڤا c</li>
</ul>
BA,
'for i in range(3):\n    print("Number", i)',
'Number 0\nNumber 1\nNumber 2',
'بە range(2, 6) ژمارەکانی 2 بۆ 5 چاپ بکە',
'ب range(2, 6) ژمارێن 2 هەتا 5 چاپ بکە',
"2\n3\n4\n5");

$lessons[] = lesson(16, $L1SO, $L1BA,
'break و continue', 'break و continue',
<<<'SO'
<p><code>break</code> خولگەکە بە تەواوی دەوەستێنێت، بەڵام <code>continue</code> تەنها ئەم خولە بەشێوەردەبات:</p>
<pre># break - وەستاندن\nfor i in range(10):\n    if i == 3:\n        break\n    print(i)          # 0 1 2\n\n# continue - فڕێدان\nfor i in range(5):\n    if i == 2:\n        continue\n    print(i)          # 0 1 3 4</pre>
<p>بە break بۆ وەستان لەسەر مەرجێکی دیاریکراو، و بە continue بۆ فڕێدانی ئەندامێک بەکاردێت.</p>
SO,
<<<'BA'
<p><code>break</code> گەڕخستن ب تەمامی دەوەستنیت، بەلێ <code>continue</code> تەنها ڤێ خولێ بەشێوەردبات:</p>
<pre># break - وەستان\nfor i in range(10):\n    if i == 3:\n        break\n    print(i)          # 0 1 2\n\n# continue - دەرئاڤێتن\nfor i in range(5):\n    if i == 2:\n        continue\n    print(i)          # 0 1 3 4</pre>
<p>ب break بو وەستانێ ل سەر مەرجەکا دیاریکرێ، و ب continue بو دەرئاڤتنا ئەندامەکی بکارتیت.</p>
BA,
'for i in range(5):\n    if i == 2:\n        break\n    print(i)',
'0\n1',
'بە break ژمارەکانی 0 بۆ 4 بنووسە بەڵام لە 2 بوەستە',
'ب break ژمارێن 0 هەتا 4 بنڤیسە بەلێ ل 2 ڤە وەستە',
"0\n1");

$lessons[] = lesson(17, $L1SO, $L1BA,
'لیستەکان (Lists)', 'لیست (Lists)',
<<<'SO'
<p><strong>لیست (List)</strong> کۆمەڵێک بەهایە کە بە <code>[ ]</code> دروست دەبێت و دەتوانیت چەند جۆری داتا تێدا بکەیت:</p>
<pre>fruits = ["sêv", "mûz", "porteqal"]\nnumbers = [1, 2, 3, 4, 5]\nmixed = ["Kurd", 25, True, 3.14]\n\nprint(fruits[0])     # sêv - یەکەم ئەندام\nprint(fruits[-1])    # porteqal - کۆتا ئەندام\nprint(len(numbers))  # 5 - ژمارەی ئەندامەکان</pre>
<p>لیستەکان <strong>دەگۆڕێن</strong> (mutable) - دەتوانیت ئەندامان بگۆڕیت:</p>
<pre>fruits[1] = "hirmî"\nprint(fruits)   # ['sêv', 'hirmî', 'porteqal']</pre>
SO,
<<<'BA'
<p><strong>لیست (List)</strong> کۆمەکەکا بەهایانە کو ب <code>[ ]</code> دروست دبیت و تو دکەی چەند چەشنی داتایێ تێدا بکی:</p>
<pre>fruits = ["sêv", "mûz", "porteqal"]\nnumbers = [1, 2, 3, 4, 5]\nmixed = ["Kurd", 25, True, 3.14]\n\nprint(fruits[0])     # sêv - ئێکەم ئەندام\nprint(fruits[-1])    # porteqal - دویاهێ ئەندام\nprint(len(numbers))  # 5 - ژمارا ئەندامان</pre>
<p>لیست <strong>دگۆڕن</strong> (mutable) - تو دکەی ئەندامان بگۆڕی:</p>
<pre>fruits[1] = "hirmî"\nprint(fruits)   # ['sêv', 'hirmî', 'porteqal']</pre>
BA,
'colors = ["red", "green", "blue"]\nprint(colors[0])\nprint(len(colors))',
'red\n3',
'لیستێک لە دوو وشە دروست بکە و یەکەم ئەندامی چاپ بکە',
'لیستەکا ژ دوو بەژەیان دروست بکە و ئێکەم ئەندامی چاپ بکە',
"Kurd");

$lessons[] = lesson(18, $L1SO, $L1BA,
'میتۆدەکانی لیست', 'میتۆدێن لیستێ',
<<<'SO'
<p>لیستەکان چەند میتۆدی بەسوودیان هەیە:</p>
<pre>fruits = ["sêv", "mûz"]\n\nfruits.append("hirmî")     # زیادکردن لە کۆتایی\nprint(fruits)               # ['sêv', 'mûz', 'hirmî']\n\nfruits.insert(1, "tû")     # زیادکردن لە شوێنی 1\nprint(fruits)               # ['sêv', 'tû', 'mûz', 'hirmî']\n\nfruits.remove("tû")         # سڕینەوە بە بەها\nprint(fruits)               # ['sêv', 'mûz', 'hirmî']\n\nfruits.pop()                # سڕینەوەی کۆتایی\nprint(fruits)               # ['sêv', 'mûz']</pre>
SO,
<<<'BA'
<p>لیست چەند میتۆدێن ب سوود هەن:</p>
<pre>fruits = ["sêv", "mûz"]\n\nfruits.append("hirmî")     # زێدەکرن ل کۆتایی\nprint(fruits)               # ['sêv', 'mûz', 'hirmî']\n\nfruits.insert(1, "tû")     # زێدەکرن ل شونا 1\nprint(fruits)               # ['sêv', 'tû', 'mûz', 'hirmî']\n\nfruits.remove("tû")         # ژێبرن ب بەها\nprint(fruits)               # ['sêv', 'mûz', 'hirmî']\n\nfruits.pop()                # ژێبرنا کۆتایێ\nprint(fruits)               # ['sêv', 'mûz']</pre>
BA,
'nums = [1, 2]\nnums.append(3)\nprint(nums)\nprint(len(nums))',
'[1, 2, 3]\n3',
'بە append ژمارەی 4 زیاد بکە بۆ لیستی [1,2,3] و بڵاوی بکەرەوە',
'ب append ژمارا 4 زێدە بکە بو لیستا [1,2,3] و بەلاڤ بکە',
'[1, 2, 3, 4]');

$lessons[] = lesson(19, $L1SO, $L1BA,
'tuple', 'tuple',
<<<'SO'
<p><strong>tuple</strong> وەک لیستە بەڵام بە <code>( )</code> دروست دەبێت و <strong>ناگۆڕێت</strong> (immutable):</p>
<pre>point = (3, 4)\ncolors = ("red", "green", "blue")\n\nprint(point[0])    # 3\nprint(len(colors)) # 3</pre>
<p>فەرقە سەرەکییەکە:</p>
<pre>point[0] = 10   # ERROR! ناتوانیت tuple بگۆڕیت\n\nnums = [1, 2]\nnums[0] = 10    # ئەمە دروستە - لیست دەگۆڕێت</pre>
<p>tuple بەکاردێت بۆ داتا نەگۆڕەکان وەک پۆینتی جوگرافی، ڕەنگەکان و هەماهەنگییەکان.</p>
SO,
<<<'BA'
<p><strong>tuple</strong> وەک لیست یە بەلێ ب <code>( )</code> دروست دبیت و <strong>نەگۆڕا</strong> (immutable) یە:</p>
<pre>point = (3, 4)\ncolors = ("red", "green", "blue")\n\nprint(point[0])    # 3\nprint(len(colors)) # 3</pre>
<p>فەرقێ سەرەکی:</p>
<pre>point[0] = 10   # ERROR! تو نەدکەی tuple بگۆڕی\n\nnums = [1, 2]\nnums[0] = 10    # ئەڤە دروستە - لیست دگۆڕت</pre>
<p>tuple بو داتایێن نەگۆڕا بکارتیت وەک پوینتێن جۆگرافی، ڕەنگ و هەماهەنگی.</p>
BA,
'city = ("Hewlêr", "Silêmanî", "Duhok")\nprint(city[0])\nprint(len(city))',
'Hewlêr\n3',
'لە tupleی ("Kurd", "Arab") ئەندامی یەکەم چاپ بکە',
'ژ tupleا ("Kurd", "Arab") ئێکەم ئەندامی چاپ بکە',
'Kurd');

$lessons[] = lesson(20, $L1SO, $L1BA,
'dictionary (فەرهەنگ)', 'dictionary (فەرهەنگ)',
<<<'SO'
<p><strong>dictionary</strong> بەهایەکان بە <strong>کلیل</strong> (key) هەڵدەگرێت، وەک فەرهەنگێک:</p>
<pre>student = {\n    "name": "Ahmad",\n    "age": 20,\n    "city": "Hewlêr"\n}\n\nprint(student["name"])   # Ahmad\nprint(student["age"])    # 20\n\n# زیادکردن و گۆڕین\nstudent["grade"] = "A"\nstudent["age"] = 21\nprint(student)</pre>
<p>بە <code>keys()</code> و <code>values()</code> و <code>items()</code> دەتوانیت بەسەر dictionary بەسوڕیتەوە:</p>
<pre>for key, value in student.items():\n    print(key, "=", value)</pre>
SO,
<<<'BA'
<p><strong>dictionary</strong> بەهایان ب <strong>کلیل</strong> (key) هەلدگریت، وەک فەرهەنگەک:</p>
<pre>student = {\n    "name": "Ahmad",\n    "age": 20,\n    "city": "Hewlêr"\n}\n\nprint(student["name"])   # Ahmad\nprint(student["age"])    # 20\n\n# زێدەکرن و گۆڕین\nstudent["grade"] = "A"\nstudent["age"] = 21\nprint(student)</pre>
<p>ب <code>keys()</code> و <code>values()</code> و <code>items()</code> تو دکەی ل سەر dictionary بگەڕی:</p>
<pre>for key, value in student.items():\n    print(key, "=", value)</pre>
BA,
'person = {"name": "Ava", "age": 30}\nprint(person["name"])',
'Ava',
'dictionaryیەک دروست بکە بە "language":"Python" و بەهای language چاپ بکە',
'dictionaryەک دروست بکە ب "language":"Python" و بەهایا language چاپ بکە',
'Python');

$lessons[] = lesson(21, $L1SO, $L1BA,
'set (کۆمەڵ)', 'set (کۆمەڵ)',
<<<'SO'
<p><strong>set</strong> کۆمەڵێک بەهای یەکجارە و بێ دووبارەبوونەوەیە:</p>
<pre>numbers = {1, 2, 3, 3, 2, 1}\nprint(numbers)   # {1, 2, 3} - دووبارەکان سڕاونەتەوە\n\n# زیادکردن و سڕینەوە\nnumbers.add(4)\nnumbers.remove(2)\nprint(numbers)   # {1, 3, 4}</pre>
<p>کردەوە سەرەکییەکان:</p>
<pre>a = {1, 2, 3}\nb = {2, 3, 4}\n\nprint(a &amp; b)   # هاوبەش: {2, 3}\nprint(a | b)   # تێکەڵ: {1, 2, 3, 4}\nprint(a - b)   # جیاوازی: {1}</pre>
SO,
<<<'BA'
<p><strong>set</strong> کۆمەکەکا بەهایێن ئێکجارە و بێ دوبارەبوونێ یە:</p>
<pre>numbers = {1, 2, 3, 3, 2, 1}\nprint(numbers)   # {1, 2, 3} - دوبارە ژهاتینە ژێبرن\n\n# زێدەکرن و ژێبرن\nnumbers.add(4)\nnumbers.remove(2)\nprint(numbers)   # {1, 3, 4}</pre>
<p>کردارێن سەرەکی:</p>
<pre>a = {1, 2, 3}\nb = {2, 3, 4}\n\nprint(a &amp; b)   # هاوبەش: {2, 3}\nprint(a | b)   # تێکەل: {1, 2, 3, 4}\nprint(a - b)   # جیاوازی: {1}</pre>
BA,
'nums = {1, 2, 2, 3, 3, 3}\nprint(len(nums))',
'3',
'ژمارەی ئەندامەکانی setی {1,1,2,2,3} چاپ بکە بە len',
'ژمارا ئەندامێن setا {1,1,2,2,3} چاپ بکە ب len',
'3');

$lessons[] = lesson(22, $L1SO, $L1BA,
'پارچەکردنی لیست (Slicing)', 'پارچەکرنا لیستێ (Slicing)',
<<<'SO'
<p>بە <strong>slicing</strong> دەتوانیت پارچەیەک لە لیست یان دەق وەربگریت:</p>
<pre>fruits = ["sêv", "mûz", "hirmî", "tû", "xox"]\n\nprint(fruits[1:3])    # ['mûz', 'hirmî']\nprint(fruits[:2])     # ['sêv', 'mûz'] - سەرەتاوە\nprint(fruits[3:])     # ['tû', 'xox'] - هەتا کۆتایی\nprint(fruits[::2])    # ['sêv', 'hirmî', 'xox'] - هەنگاو 2</pre>
<p>شێوازەکە: <code>list[start:end:step]</code> — ئەندامی end ناگیرێت!</p>
<p>دەقی ئاراستەی پێچەوانە:</p>
<pre>word = "Kurdistan"\nprint(word[::-1])   # natsidruK</pre>
SO,
<<<'BA'
<p>ب <strong>slicing</strong> تو دکەی پارچەکا ژ لیستێ یا دەقی هەلگری:</p>
<pre>fruits = ["sêv", "mûz", "hirmî", "tû", "xox"]\n\nprint(fruits[1:3])    # ['mûz', 'hirmî']\nprint(fruits[:2])     # ['sêv', 'mûz'] - ژ دەستپێکێ\nprint(fruits[3:])     # ['tû', 'xox'] - هەتا کۆتایێ\nprint(fruits[::2])    # ['sêv', 'hirmî', 'xox'] - پێنگاڤا 2</pre>
<p>شێواز: <code>list[start:end:step]</code> — ئەندامێ end ناگریت!</p>
<p>دەق ب ئاراستەی پچەڤان:</p>
<pre>word = "Kurdistan"\nprint(word[::-1])   # natsidruK</pre>
BA,
'nums = [10, 20, 30, 40, 50]\nprint(nums[1:3])',
'[20, 30]',
'پارچەی [2:4] لە لیستی [1,2,3,4,5] چاپ بکە',
'پارچا [2:4] ژ لیستا [1,2,3,4,5] چاپ بکە',
'[3, 4]');

$lessons[] = lesson(23, $L1SO, $L1BA,
'لیستی تێکڕا (Nested Lists)', 'لیستێن تێکرا (Nested Lists)',
<<<'SO'
<p>لیست دەتوانێت لیستی تر لە خۆ بگرێت - ئەمە پێی دەوترێت <strong>لیستی تێکڕا</strong>:</p>
<pre>matrix = [\n    [1, 2, 3],\n    [4, 5, 6],\n    [7, 8, 9]\n]\n\nprint(matrix[0])    # [1, 2, 3]\nprint(matrix[1][2]) # 6 - ڕیز 1 ستوون 2\n\n# سوڕانەوە بەسەر هەموو ئەنداماندا\nfor row in matrix:\n    for num in row:\n        print(num, end=" ")\n# 1 2 3 4 5 6 7 8 9</pre>
<p>لیستی تێکڕا بۆ پێکهاتەی خشتەکان، matrixەکان و یارییەکان وەک X-O زۆر بەکاردێت.</p>
SO,
<<<'BA'
<p>لیست دکەت لیستا دی د خۆ دا بگریت - ئەڤە پێی دبێژن <strong>لیستا تێکرا</strong>:</p>
<pre>matrix = [\n    [1, 2, 3],\n    [4, 5, 6],\n    [7, 8, 9]\n]\n\nprint(matrix[0])    # [1, 2, 3]\nprint(matrix[1][2]) # 6 - ڕیزا 1 ستوونا 2\n\n# گەڕان ل سەر هەمی ئەندامان\nfor row in matrix:\n    for num in row:\n        print(num, end=" ")\n# 1 2 3 4 5 6 7 8 9</pre>
<p>لیستا تێکرا بو پێکهاتەێن خشتە، matrix و یارییان وەک X-O زۆر بکارتیت.</p>
BA,
'grid = [[1, 2], [3, 4]]\nprint(grid[1][0])',
'3',
'لە لیستی [[1,2],[3,4]] بەهای ڕیزی 0 و ستوونی 1 چاپ بکە',
'ژ لیستا [[1,2],[3,4]] بەهایا ڕیزا 0 و ستوونا 1 چاپ بکە',
'2');

$lessons[] = lesson(24, $L1SO, $L1BA,
'List Comprehension', 'List Comprehension',
<<<'SO'
<p><strong>List Comprehension</strong> ڕێگایەکی کورتە بۆ دروستکردنی لیست لە یەک هێڵدا:</p>
<pre># شێوازی ئاسایی\nsquares = []\nfor i in range(1, 6):\n    squares.append(i * i)\nprint(squares)   # [1, 4, 9, 16, 25]\n\n# بە list comprehension\nsquares = [i * i for i in range(1, 6)]\nprint(squares)   # [1, 4, 9, 16, 25]</pre>
<p>بە مەرج:</p>
<pre>evens = [n for n in range(10) if n % 2 == 0]\nprint(evens)   # [0, 2, 4, 6, 8]</pre>
SO,
<<<'BA'
<p><strong>List Comprehension</strong> ڕێکا کورتە بو دروستکرنا لیستێ د ئێک هێلی دا:</p>
<pre># شێوازێ ئاسایی\nsquares = []\nfor i in range(1, 6):\n    squares.append(i * i)\nprint(squares)   # [1, 4, 9, 16, 25]\n\n# ب list comprehension\nsquares = [i * i for i in range(1, 6)]\nprint(squares)   # [1, 4, 9, 16, 25]</pre>
<p>ب مەرج:</p>
<pre>evens = [n for n in range(10) if n % 2 == 0]\nprint(evens)   # [0, 2, 4, 6, 8]</pre>
BA,
'nums = [n * 2 for n in range(1, 4)]\nprint(nums)',
'[2, 4, 6]',
'بە list comprehension لیستی [n*n for n in range(1,4)] چاپ بکە',
'ب list comprehension لیستا [n*n for n in range(1,4)] چاپ بکە',
'[1, 4, 9]');

$lessons[] = lesson(25, $L1SO, $L1BA,
'فەنکشنەکان (Functions)', 'فەنکشن (Functions)',
<<<'SO'
<p><strong>فەنکشن</strong> بلۆکێکی کۆدە کە ئەرکێکی دیاریکراو جێبەجێ دەکات و بە <code>def</code> دروست دەبێت:</p>
<pre>def say_salam():\n    print("Salam Kurdistan!")\n\n# بانگکردن\ndef say_salam():\n    print("Salam Kurdistan!")\n\n# بانگکردن\nsay_salam()\nsay_salam()</pre>
<p>فەنکشن بە پارامیتەر:</p>
<pre>def greet(name):\n    print("Salam", name)\n\ngreet("Ava")     # Salam Ava\ngreet("Roj")     # Salam Roj</pre>
<p>فەنکشن کۆدەکە یەک جار دەنووسیت و چەند جار بەکاری دەهێنیت.</p>
SO,
<<<'BA'
<p><strong>فەنکشن</strong> بلۆکەکا کۆدی یە کو ئەرکەکا دیاریکرێ جێبەجێ دکەت و ب <code>def</code> دروست دبیت:</p>
<pre>def say_salam():\n    print("Salam Kurdistan!")\n\n# بانگکرن\nsay_salam()\nsay_salam()</pre>
<p>فەنکشن ب پارامیتەران:</p>
<pre>def greet(name):\n    print("Salam", name)\n\ngreet("Ava")     # Salam Ava\ngreet("Roj")     # Salam Roj</pre>
<p>فەنکشن کۆدی ئێک جار دینڤیسی و چەند جاران بکارتینی.</p>
BA,
'def greet():\n    print("Hi")\n\ngreet()\ngreet()',
'Hi\nHi',
'فەنکشنێکی hello دروست بکە کە "Hello" چاپ بکات و دوو جار بانگی بکە',
'فەنکشنەکا hello دروست بکە کو "Hello" چاپ بکەت و دوو جاران بانگا وی بکە',
'Hello\nHello');

$lessons[] = lesson(26, $L1SO, $L1BA,
'پارامیتەر و return', 'پارامیتەر و return',
<<<'SO'
<p>فەنکشن دەتوانێت بەها وەربگرێت (<strong>پارامیتەر</strong>) و بەهایەک بگەڕێنێتەوە (<strong>return</strong>):</p>
<pre>def add(a, b):\n    return a + b\n\nresult = add(5, 3)\nprint(result)   # 8\n\n# چەند پارامیتەر\ndef full_name(first, last):\n    return first + " " + last\n\nprint(full_name("Ahmad", "Rashid"))</pre>
<p>کاتێک فەنکشن بەهاکە دەگەڕێنێتەوە بە return، دەتوانیت لە شوێنەکانی تر بەکاری بهێنیت:</p>
<pre>print(add(add(1, 2), add(3, 4)))   # 10</pre>
SO,
<<<'BA'
<p>فەنکشن دکەت بەها هەلگریت (<strong>پارامیتەر</strong>) و بەهایەک ڤەدگەڕینیت (<strong>return</strong>):</p>
<pre>def add(a, b):\n    return a + b\n\nresult = add(5, 3)\nprint(result)   # 8\n\n# چەند پارامیتەر\n</pre>
<p>دەمە کو فەنکشن بەهایێ ب return ڤەدگەڕینیت، تو دکەی د جهێن دیان دا بکاربینی:</p>
<pre>print(add(add(1, 2), add(3, 4)))   # 10</pre>
BA,
'def multiply(a, b):\n    return a * b\n\nprint(multiply(4, 5))',
'20',
'فەنکشنێکی subtract دروست بکە کە 10-3 بگەڕێنێتەوە و چاپی بکە',
'فەنکشنەکا subtract دروست بکە کو 10-3 ڤەدگەڕینیت و چاپا وی بکە',
'7');

$lessons[] = lesson(27, $L1SO, $L1BA,
'بەهای پێشوەختە (Default Arguments)', 'بەهایێن پێشڤە (Default Arguments)',
<<<'SO'
<p>دەتوانیت بەهای پێشوەختە (default) بۆ پارامیتەرەکان دابنێیت - ئەگەر بەهایەک نەدرێت، بەهای پێشوەختە بەکاردێت:</p>
<pre>def greet(name, greeting="Salam"):\n    print(greeting, name)\n\ngreet("Ava")              # Salam Ava\ngreet("Roj", "Bexhî")     # Bexhî Roj\n\n# چەند default\ndef power(base, exp=2):\n    return base ** exp\n\nprint(power(3))      # 9 (3²)\nprint(power(3, 3))   # 27 (3³)</pre>
<p><strong>تێبینی:</strong> پارامیتەرەکانی default دەبێت هەمیشە لە کۆتایی بێن.</p>
SO,
<<<'BA'
<p>تو دکەی بەهایێن پێشڤە (default) بو پارامیتەران دابنێی - گەر بەهایەک نەهاتە دان، بەهایێ پێشڤە بکارتیت:</p>
<pre>def greet(name, greeting="Salam"):\n    print(greeting, name)\n\ngreet("Ava")              # Salam Ava\ngreet("Roj", "Bexhî")     # Bexhî Roj\n\n# چەند default\n</pre>
BA,
'def greet(name, msg="Hi"):\n    print(msg, name)\n\ngreet("Ava")\ngreet("Ava", "Salam")',
'Hi Ava\nSalam Ava',
'فەنکشنێک بنووسە کە بە پارامیتەری default بنووسێت "Kurd"',
'فەنکشنەک بنڤیسە کو ب پارامیتەری default بنڤیسەت "Kurd"',
"Kurd");

$lessons[] = lesson(28, $L1SO, $L1BA,
'lambda (فەنکشنی نادیار)', 'lambda (فەنکشن ب ناڤ)',
<<<'SO'
<p><strong>lambda</strong> فەنکشنێکی کورت و بێ ناوە لە یەک هێڵدا، بۆ فەنکشنە بچووکەکان:</p>
<pre># فەنکشنی ئاسایی\ndef add(a, b):\n    return a + b\n\n# هەمان شت بە lambda\nadd = lambda a, b: a + b\n\nprint(add(5, 3))   # 8</pre>
<p>lambda زۆر جار لەگەڵ sorted و filter بەکاردێت:</p>
<pre>names = ["Ava", "Roj", "Baran"]\nnames.sort(key=lambda s: len(s))\nprint(names)   # ['Ava', 'Roj', 'Baran']</pre>
SO,
<<<'BA'
<p><strong>lambda</strong> فەنکشنەکا کورت و ب ناڤە د ئێک هێلی دا، بو فەنکشنێن بچویک:</p>
<pre># فەنکشنێ ئاسایی\n</pre>
<p>lambda زۆر جاران ل گەڵ sorted و filter بکارتیت:</p>
<pre>nums = [5, 2, 8, 1]\nnums.sort(key=lambda x: x)\nprint(nums)   # [1, 2, 5, 8]</pre>
BA,
'double = lambda x: x * 2\nprint(double(7))',
'14',
'بە lambda فەنکشنێک دروست بکە کە ژمارەیەک بە سێ زۆر بکات (x*3)',
'ب lambda فەنکشنەک دروست بکە کو ژمارەیەک ب سێ زێدە بکەت (x*3)',
'15');

$lessons[] = lesson(29, $L1SO, $L1BA,
'گۆڕاوە ناوخۆیی و گشتی', 'گۆڕۆکێن ناڤخۆیی و گشتی',
<<<'SO'
<p>گۆڕاوەکان لە Python دوو جۆرن:</p>
<pre># گۆڕاوی گشتی (Global) - لە دەرەوەی فەنکشن\ncount = 10\n\ndef show():\n    # گۆڕاوی ناوخۆیی (Local) - لە ناو فەنکشن\n    total = 5\n    print(total)      # 5\n    print(count)      # 10 - دەتوانیت بیخوێنیتەوە\n\nshow()\nprint(total)   # ERROR! ناگەیت بە ناوخۆیی</pre>
<p>بۆ گۆڕینی گۆڕاوی گشتی لە ناو فەنکشن پێویستە <code>global</code> بەکاربهێنیت:</p>
<pre>count = 10\n\ndef increase():\n    global count\n    count += 1\n\nincrease()\nprint(count)   # 11</pre>
SO,
<<<'BA'
<p>گۆڕۆک د Python دا دوو چەشنن:</p>
<pre># گۆڕۆکێ گشتی (Global) - د دەرڤەی فەنکشنی دا\ncount = 10\n\ndef show():\n    # گۆڕۆکێ ناڤخۆیی (Local) - د ناڤ فەنکشنی دا\n    total = 5\n    print(total)      # 5\n    print(count)      # 10 - تو دکەی بخوینی\n\nshow()\nprint(total)   # ERROR! ناگەهی ناڤخۆیی</pre>
<p>بو گۆڕینا گۆڕۆکێ گشتی د ناڤ فەنکشنی دا دڤێت <code>global</code> بکاربینی:</p>
<pre>count = 10\n\ndef increase():\n    global count\n    count += 1\n\nincrease()\nprint(count)   # 11</pre>
BA,
'x = 5\n\ndef show():\n    y = 10\n    print(x + y)\n\nshow()',
'15',
'گۆڕاوێکی گشتی بە 7 دروست بکە و لە ناو فەنکشن چاپی بکە',
'گۆڕۆکەکا گشتی ب 7 دروست بکە و د ناڤ فەنکشنی دا چاپا وی بکە',
'7');

$lessons[] = lesson(30, $L1SO, $L1BA,
'مۆدیولەکان (Modules)', 'مۆدیول (Modules)',
<<<'SO'
<p><strong>مۆدیول</strong> فایلی Python یە کە فەنکشن و گۆڕاوەکانی تر تێدا هەیە. بە <code>import</code> بەکاری دەهێنیت:</p>
<pre>import math\n\nprint(math.sqrt(16))     # 4.0\nprint(math.pi)           # 3.14159...\nprint(math.floor(3.7))   # 3\nprint(math.ceil(3.2))    # 4</pre>
<p>بە <code>from ... import</code> دەتوانیت تەنها ئەوەی پێویستتە بەکاربهێنیت:</p>
<pre>from random import randint\n\nprint(randint(1, 10))    # ژمارەی هەڕەمەکی 1-10\n\nimport datetime\nprint(datetime.date.today())</pre>
SO,
<<<'BA'
<p><strong>مۆدیول</strong> فایلەکا Python یە کو فەنکشن و گۆڕۆکێن دی تێدا هەنە. ب <code>import</code> بکاری دینی:</p>
<pre>import math\n\nprint(math.sqrt(16))     # 4.0\nprint(math.pi)           # 3.14159...\nprint(math.floor(3.7))   # 3\nprint(math.ceil(3.2))    # 4</pre>
<p>ب <code>from ... import</code> تو دکەی تەنها ئەوێ کو دڤێت بکاربینی:</p>
<pre>from random import randint\n\nprint(randint(1, 10))    # ژمارەیا هەڕەمەکی 1-10</pre>
BA,
'import math\nprint(math.sqrt(25))',
'5.0',
'بە math.sqrt چوارگۆشەی 81 بدۆزەرەوە',
'ب math.sqrt چوارگۆشەی 81 بدۆزەرە',
'9.0');

$lessons[] = lesson(31, $L1SO, $L1BA,
'کارکردن لەگەڵ فایل', 'کارکرن ل گەل فایلان',
<<<'SO'
<p>بە <code>open()</code> دەتوانیت فایل بخوێنیتەوە یان بنووسیت:</p>
<pre># نووسین بۆ فایل\nwith open("note.txt", "w") as f:\n    f.write("Salam Kurdistan!")\n\n# خوێندنەوەی فایل\nwith open("note.txt", "r") as f:\n    content = f.read()\n    print(content)   # Salam Kurdistan!</pre>
<p>شێوازەکانی کردنەوە:</p>
<ul>
<li><code>"r"</code> - خوێندنەوە</li>
<li><code>"w"</code> - نووسین (بەسەردا دەنووسێتەوە)</li>
<li><code>"a"</code> - زیادکردن بۆ کۆتایی</li>
</ul>
<p>بە <code>with</code> فایلەکە بە شێوەیەکی ئۆتۆماتیکی دادەخرێت.</p>
SO,
<<<'BA'
<p>ب <code>open()</code> تو دکەی فایلەک بخوینی یا بنڤیسی:</p>
<pre># نڤیسین بو فایلی\nwith open("note.txt", "w") as f:\n    f.write("Salam Kurdistan!")\n\n# خواندنا فایلی\nwith open("note.txt", "r") as f:\n    content = f.read()\n    print(content)   # Salam Kurdistan!</pre>
<p>شێوازێن ڤەکرنێ:</p>
<ul>
<li><code>"r"</code> - خواندن</li>
<li><code>"w"</code> - نڤیسین (ل سەر دینڤیسە)</li>
<li><code>"a"</code> - زێدەکرن بو کۆتایێ</li>
</ul>
<p>ب <code>with</code> فایل ب شێوەیەکی ئۆتۆماتیکی دداخیت.</p>
BA,
'with open("test.txt", "w") as f:\n    f.write("Hello")\n\nwith open("test.txt", "r") as f:\n    print(f.read())',
'Hello',
'بە open فایلی text بنووسە بە "Kurd AI" و بیخوێنەرەوە',
'ب open فایلی text بنڤیسە ب "Kurd AI" و بخوینە',
'Kurd AI');

$lessons[] = lesson(32, $L1SO, $L1BA,
'try/except (بەڕێوەبردنی هەڵە)', 'try/except (بەرێڤەبرنا خەلەتێ)',
<<<'SO'
<p>بە <code>try/except</code> دەتوانیت هەڵەکان بەڕێوە ببەیت و خولگەی بەرنامەکە تێک نەچێت:</p>
<pre>try:\n    number = int("abc")   # هەڵە! ناتوانرێت بگۆڕدرێت\n    print(number)\nexcept ValueError:\n    print("ئەمە ژمارە نییە!")</pre>
<p>بەڕێوەبردنی هەڵەی گشتی:</p>
<pre>try:\n    x = 10 / 0\nexcept ZeroDivisionError:\n    print("ناتوانیت بە سفەر دابەشی بکەیت!")\nexcept Exception as e:\n    print("هەڵەیەک ڕوویدا:", e)</pre>
<p>بەڕێوەبردنی هەڵە بەرنامەکان ڕەهێنتر دەکات و لە کەوتنی بەرنامەکە ڕێگری دەکات.</p>
SO,
<<<'BA'
<p>ب <code>try/except</code> تو دکەی خەلەتێن بەرێڤە ببی و گەڕخستنا بەرنامەی تێک نەچیت:</p>
<pre>try:\n    number = int("abc")   # خەلەت! ناتە گۆڕین\n    print(number)\nexcept ValueError:\n    print("ئەڤە ژمارە نینە!")</pre>
<p>بەرێڤەبرنا خەلەتا گشتی:</p>
<pre>try:\n    x = 10 / 0\nexcept ZeroDivisionError:\n    print("تو نەدکەی ب سفەر پارڤە بکی!")</pre>
BA,
'try:\n    print(10 / 0)\nexcept ZeroDivisionError:\n    print("Cannot divide by zero")',
'Cannot divide by zero',
'بە try/except هەڵەی دابەشکردن بە سفەر دەستبگرە و "Zero error" چاپ بکە',
'ب try/except خەلەتا پارڤەکرنا ب سفەر دەستبگرە و "Zero error" چاپ بکە',
'Zero error');

$lessons[] = lesson(33, $L1SO, $L1BA,
'OOP - کلاسەکان (Classes)', 'OOP - کلاس (Classes)',
<<<'SO'
<p><strong>کلاس (Class)</strong> شێوازێکە بۆ ڕێکخستنی کۆد — وەک هێلکەیەک (blueprint) بۆ دروستکردنی شت (object):</p>
<pre>class Student:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n\n    def introduce(self):\n        print(f"Salam, I am {self.name}")\n\n# دروستکردنی ئۆبجێکت\ns1 = Student("Ava", 20)\ns2 = Student("Roj", 22)\n\nprint(s1.name)          # Ava\ns1.introduce()          # Salam, I am Ava</pre>
<p><code>__init__</code> مێتۆدی تایبەتە کە کاتێک ئۆبجێکت دروست دەکرێت خۆکارانە جێبەجێ دەبێت.</p>
SO,
<<<'BA'
<p><strong>کلاس (Class)</strong> شێوازەکە بو ڕێکخرنا کۆدی — وەک هێلکەیەک (blueprint) بو دروستکرنا شتێ (object):</p>
<pre>class Student:\n    def __init__(self, name, age):\n        self.name = name\n        self.age = age\n\n    def introduce(self):\n        print(f"Salam, I am {self.name}")\n\n# دروستکرنا ئۆبجێکت\ns1 = Student("Ava", 20)\ns2 = Student("Roj", 22)\n\nprint(s1.name)          # Ava\ns1.introduce()          # Salam, I am Ava</pre>
<p><code>__init__</code> میتۆدەکا تایبەتە کو دەمە دروستکرنا ئۆبجێکتی خۆکارانە جێبەجێ دبیت.</p>
BA,
'class Car:\n    def __init__(self, brand):\n        self.brand = brand\n\nmy_car = Car("Toyota")\nprint(my_car.brand)',
'Toyota',
'کلاسێک بە ناوی Dog دروست بکە بە ناوی "Rex" و ناوەکەی چاپ بکە',
'کلاسەکا ب ناڤێ Dog دروست بکە ب ناڤێ "Rex" و ناڤێ وی چاپ بکە',
'Rex');

$lessons[] = lesson(34, $L1SO, $L1BA,
'میرات (Inheritance)', 'میرات (Inheritance)',
<<<'SO'
<p><strong>میرات (Inheritance)</strong> ڕێگە دەدات کلاسێک تایبەتمەندییەکانی کلاسێکی تر بە میرات ببات:</p>
<pre>class Animal:\n    def __init__(self, name):\n        self.name = name\n\n    def sound(self):\n        print("...")  # جێبەجێ دەکرێتەوە لە کلاسی منداڵ\n\nclass Dog(Animal):\n    def sound(self):\n        print(self.name + " says: Woof!")\n\nclass Cat(Animal):\n    def sound(self):\n        print(self.name + " says: Meow!")\n\ndog = Dog("Rex")\ncat = Cat("Kitty")\n\ndog.sound()   # Rex says: Woof!\ncat.sound()   # Kitty says: Meow!</pre>
<p>ئەمەش کۆدەکە زیاتر ڕێک و دووبارە بەکارهاتوو دەکات.</p>
SO,
<<<'BA'
<p><strong>میرات (Inheritance)</strong> ڕێگە ددەت کلاسەک تایبەتمەندییێن کلاسەکا دی ب میراهەتە ببات:</p>
<pre>class Animal:\n    def __init__(self, name):\n        self.name = name\n\nclass Dog(Animal):\n    def sound(self):\n        print(self.name + " says: Woof!")\n\nclass Cat(Animal):\n    def sound(self):\n        print(self.name + " says: Meow!")\n\ndog = Dog("Rex")\ncat = Cat("Kitty")\n\ndog.sound()   # Rex says: Woof!\ncat.sound()   # Kitty says: Meow!</pre>
<p>ئەڤە کۆدی زێدەتر ڕێک و دوبارە بکارهاتی دکەت.</p>
BA,
'class Animal:\n    def __init__(self, name):\n        self.name = name\n\nclass Dog(Animal):\n    pass\n\ndog = Dog("Rex")\nprint(dog.name)',
'Rex',
'کلاسێکی Base دروست بکە بە "Kurd" و لێی میرات بگرە بۆ کلاسێکی تر',
'کلاسەکا Base دروست بکە ب "Kurd" و ژێ میراهەتە بگره بو کلاسەکا دی',
'Kurd');

$lessons[] = lesson(35, $L1SO, $L1BA,
'پرۆژە: کاڵکولێیتەر', 'پرۆژە: کاڵکولێیتەر',
<<<'SO'
<p>با یەکەم پرۆژە دروست بکەین — کاڵکولێیتەرێکی سادە:</p>
<pre>def calculator(a, b, op):\n    if op == "+":\n        return a + b\n    elif op == "-":\n        return a - b\n    elif op == "*":\n        return a * b\n    elif op == "/":\n        return a / b\n    else:\n        return "Unknown operation"\n\nprint(calculator(10, 5, "+"))   # 15\nprint(calculator(10, 5, "-"))   # 5\nprint(calculator(10, 5, "*"))   # 50\nprint(calculator(10, 5, "/"))   # 2.0</pre>
<p>ئەم پرۆژەیە هەموو ئەو شتانە تێدایە کە هەتا ئێستا فێربوویت: فەنکشن، مەرج و ژمارە.</p>
SO,
<<<'BA'
<p>با ئێکەم پرۆژە دروست بکەین — کاڵکولێیتەرەکا سادە:</p>
<pre>def calculator(a, b, op):\n    if op == "+":\n        return a + b\n    elif op == "-":\n        return a - b\n    elif op == "*":\n        return a * b\n    elif op == "/":\n        return a / b\n    else:\n        return "Unknown operation"\n\nprint(calculator(10, 5, "+"))   # 15\nprint(calculator(10, 5, "-"))   # 5\nprint(calculator(10, 5, "*"))   # 50\nprint(calculator(10, 5, "/"))   # 2.0</pre>
<p>ئەڤ پرۆژەیا هەمی ئەو شتێن هەتا نوکە فێربوی تێدا هەنە: فەنکشن، مەرج و ژمارە.</p>
BA,
'def calc(a, b, op):\n    if op == "+":\n        return a + b\n    return a - b\n\nprint(calc(20, 8, "+"))\nprint(calc(20, 8, "-"))',
'28\n12',
'بە فەنکشن ئەنجامی 12*4 و 12/4 چاپ بکە',
'ب فەنکشن ئەنجامێ 12*4 و 12/4 چاپ بکە',
"48\n3.0");

$lessons[] = lesson(36, $L1SO, $L1BA,
'پرۆژە: یاری گەمژاندنی ژمارە', 'پرۆژە: یاریا گومانکرنا ژمارەیێ',
<<<'SO'
<p>پرۆژەی دووەم — یارییەکی کە بەکارهێنەر دەبێت ژمارەیەک گەمژ (guess) بکات:</p>
<pre>import random\n\nsecret = random.randint(1, 10)\nguess = 7   # با بەکارهێنەر هەر بەهایەک بنووسێت\n\nif guess == secret:\n    print("Congratulations! You guessed it!")\nelif guess &lt; secret:\n    print("Too low! Try again.")\nelse:\n    print("Too high! Try again.")</pre>
<p>بۆ یارییەکی تەواو، ئەمە بە خولگەی while تێکەڵ بکە هەتا بەکارهێنەر ڕاستی بکات:</p>
<pre>while guess != secret:\n    guess = int(input("Guess: "))\nprint("You win!")</pre>
SO,
<<<'BA'
<p>پرۆژەیا دووێ — یاریەکا کو بکارهێنەر دڤێت ژمارەیەک گومان (guess) بکەت:</p>
<pre>import random\n\nsecret = random.randint(1, 10)\nguess = 7   # با بکارهێنەر هەر بەهایەک بنڤیسەت\n\nif guess == secret:\n    print("Congratulations! You guessed it!")\nelif guess &lt; secret:\n    print("Too low! Try again.")\nelse:\n    print("Too high! Try again.")</pre>
<p>بو یاریەکا تەمام، ئەڤە ب گەڕخستنا while تێکەل بکە هەتا بکارهێنەر راستی بکەت:</p>
<pre>while guess != secret:\n    guess = int(input("Guess: "))\nprint("You win!")</pre>
BA,
'secret = 5\nguess = 3\nif guess == secret:\n    print("Equal")\nelse:\n    print("Not equal")',
'Not equal',
'ئەگەر guess=5 و secret=5 بێت "Equal" چاپ بکە',
'گەر guess=5 و secret=5 بیت "Equal" چاپ بکە',
'Equal');

$lessons[] = lesson(37, $L1SO, $L1BA,
'پرۆژە: لیستی کارەکان (To-Do)', 'پرۆژە: لیستا کاران (To-Do)',
<<<'SO'
<p>پرۆژەی سێیەم — بەڕێوەبردنی لیستی کارەکان بە لیست:</p>
<pre>tasks = []\n\n# زیادکردن\ntasks.append("خوێندنی Python")\ntasks.append("جیم")\ntasks.append("خوێندنەوەی کتێب")\n\n# پیشاندان\nprint("My tasks:")\nfor i, task in enumerate(tasks, 1):\n    print(f"{i}. {task}")\n\n# تەواوکردنی یەکەم کار\ndone = tasks.pop(0)\nprint("Done:", done)\nprint("Remaining:", len(tasks))</pre>
<p><code>enumerate()</code> ژمارە دەداتە هەر ئەندامێکی لیستەکە — زۆر بەسوودە بۆ لیستی ژمارەدار.</p>
SO,
<<<'BA'
<p>پرۆژەیا سێیێ — بەرێڤەبرنا لیستا کاران ب لیست:</p>
<pre>tasks = []\n\n# زێدەکرن\ntasks.append("خوێندنا Python")\ntasks.append("جیم")\ntasks.append("خواندنا پەرتوکێ")\n\n# نیشاندان\nprint("My tasks:")\nfor i, task in enumerate(tasks, 1):\n    print(f"{i}. {task}")\n\n# تەمامکرنا ئێکەم کارێ\ndone = tasks.pop(0)\nprint("Done:", done)\nprint("Remaining:", len(tasks))</pre>
<p><code>enumerate()</code> ژمارە ددەتە هەر ئەندامەکی لیستی — زۆر ب سوودە بو لیستا ژمارەیی.</p>
BA,
'tasks = ["A", "B"]\ntasks.append("C")\nprint(len(tasks))',
'3',
'لیستێک بە 2 ئەندام دروست بکە و یەکێکی تر زیاد بکە و ژمارەکەی چاپ بکە',
'لیستەکا ب 2 ئەندامان دروست بکە و ئێکێ دیکە زێدە بکە و ژمارا وی چاپ بکە',
'3');

$lessons[] = lesson(38, $L1SO, $L1BA,
'پرۆژە: ژماردنی وشەکان', 'پرۆژە: هەژمارکرنا بەژەیان',
<<<'SO'
<p>پرۆژەی چوارەم — بەرنامەیەک کە ژمارەی وشەکانی دەقێک دەژمێرێت:</p>
<pre>def count_words(text):\n    return len(text.split())\n\ndef count_letters(text):\n    return len(text)\n\nsentence = "Kurdistan is a beautiful country"\n\nwords = count_words(sentence)\nletters = count_letters(sentence)\n\nprint("Words:", words)       # 5\nprint("Letters:", letters)   # 31</pre>
<p><code>split()</code> دەقەکە دەکات بە لیستی وشەکان، و <code>len()</code> ژمارەیان دەژمێرێت.</p>
SO,
<<<'BA'
<p>پرۆژەیا چارێ — بەرنامەکا کو ژمارا بەژەیێن دەقەکی هەژمار دکەت:</p>
<pre>def count_words(text):\n    return len(text.split())\n\ndef count_letters(text):\n    return len(text)\n\nsentence = "Kurdistan is a beautiful country"\n\nwords = count_words(sentence)\nletters = count_letters(sentence)\n\nprint("Words:", words)       # 5\nprint("Letters:", letters)   # 31</pre>
<p><code>split()</code> دەقی دکەت ب لیستا بەژەیان، و <code>len()</code> ژمارەیا وان هەژمار دکەت.</p>
BA,
'text = "Salam Kurdistan"\nprint(len(text.split()))',
'2',
'بە split ژمارەی وشەکانی "AI is the future" چاپ بکە',
'ب split ژمارا بەژەیێن "AI is the future" چاپ بکە',
'4');

$lessons[] = lesson(39, $L1SO, $L1BA,
'پرۆژە: FizzBuzz', 'پرۆژە: FizzBuzz',
<<<'SO'
<p>FizzBuzz یەکێکە لە ناودارترین ئەرکەکانی پرۆگرامکردن لە چاوپێکەوتنەکانی کاردا:</p>
<pre>for i in range(1, 16):\n    if i % 3 == 0 and i % 5 == 0:\n        print("FizzBuzz")\n    elif i % 3 == 0:\n        print("Fizz")\n    elif i % 5 == 0:\n        print("Buzz")\n    else:\n        print(i)</pre>
<p>یاساکان:</p>
<ul>
<li>دابەش بە ٣ → Fizz</li>
<li>دابەش بە ٥ → Buzz</li>
<li>دابەش بە ١٥ → FizzBuzz</li>
<li>ئەوانی تر → ژمارەکە</li>
</ul>
SO,
<<<'BA'
<p>FizzBuzz ئێک ژ ناودارترین ئەرکێن پروگرامسازییێ یە د چاوپێکەفتنێن کاری دا:</p>
<pre>for i in range(1, 16):\n    if i % 3 == 0 and i % 5 == 0:\n        print("FizzBuzz")\n    elif i % 3 == 0:\n        print("Fizz")\n    elif i % 5 == 0:\n        print("Buzz")\n    else:\n        print(i)</pre>
<p>یاسا:</p>
<ul>
<li>پارڤە ب ٣ → Fizz</li>
<li>پارڤە ب ٥ → Buzz</li>
<li>پارڤە ب ١٥ → FizzBuzz</li>
<li>یێن دی → ژمارە</li>
</ul>
BA,
'for i in range(1, 4):\n    if i % 3 == 0:\n        print("Fizz")\n    else:\n        print(i)',
'1\n2\nFizz',
'بە for ژمارەکانی 1 بۆ 3 و بۆ 3 بنووسە "Fizz"',
'ب for ژمارێن 1 هەتا 3 و بو 3 بنڤیسە "Fizz"',
"1\n2\nFizz");

$lessons[] = lesson(40, $L1SO, $L1BA,
'کۆتایی کۆرس و پرۆژەی کۆتایی', 'دویاهیا کورسی و پرۆژەیا کۆتایی',
<<<'SO'
<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی Python. ئەوەی فێربوویت:</p>
<ul>
<li>گۆڕاوەکان، داتا، دەقەکان و ژمارەکان</li>
<li>مەرجەکان (if/elif/else)</li>
<li>خولگەکان (while, for)</li>
<li>لیست، dictionary و set</li>
<li>فەنکشن و lambda</li>
<li>فایلەکان و بەڕێوەبردنی هەڵە</li>
<li>OOP و میراث</li>
</ul>
<p>پرۆژەی کۆتایی — بەرنامەیەک کە نمرە وەردەگرێت و پلە دەدات:</p>
<pre>def grade(score):\n    if score &gt;= 90:\n        return "A"\n    elif score &gt;= 80:\n        return "B"\n    elif score &gt;= 70:\n        return "C"\n    elif score &gt;= 50:\n        return "D"\n    else:\n        return "F"\n\nscores = [95, 85, 72, 45, 60]\nfor s in scores:\n    print(s, "-&gt;", grade(s))</pre>
<p>ئێستا بەڕێ بکەوە بۆ فێربوونی C++ لە هەمان پلاتفۆرم!</p>
SO,
<<<'BA'
<p>ئافەرم! گەهیشتی دویاهیا کورسی Python. ئەوێ کو فێربوی:</p>
<ul>
<li>گۆڕۆک، داتا، دەق و ژمارە</li>
<li>مەرج (if/elif/else)</li>
<li>گەڕخستن (while, for)</li>
<li>لیست، dictionary و set</li>
<li>فەنکشن و lambda</li>
<li>فایل و بەرێڤەبرنا خەلەتی</li>
<li>OOP و میراهەت</li>
</ul>
<p>پرۆژەیا کۆتایی — بەرنامەکا کو نمرە هەلدگریت و پلە ددەت:</p>
<pre>def grade(score):\n    if score &gt;= 90:\n        return "A"\n    elif score &gt;= 80:\n        return "B"\n    elif score &gt;= 70:\n        return "C"\n    elif score &gt;= 50:\n        return "D"\n    else:\n        return "F"\n\nscores = [95, 85, 72, 45, 60]\nfor s in scores:\n    print(s, "-&gt;", grade(s))</pre>
<p>ئێستا بەرێ بکەوە بو فێربونا C++ د هەمان پلاتفۆرمێ دا!</p>
BA,
'scores = [90, 75]\nfor s in scores:\n    if s >= 90:\n        print("A")\n    else:\n        print("B")',
'A\nB',
'بە فەنکشن پلەی 85 چاپ بکە (80+ = B)',
'ب فەنکشن پلەیا 85 چاپ بکە (80+ = B)',
'B');

echo "Adding " . count($lessons) . " Python lessons...\n";
foreach ($lessons as $lesson) {
    $lesson['langId'] = $pythonLangId;
    $res = fbPost($firebaseUrl . 'ferga_lessons.json', $lesson);
    $d = json_decode($res, true);
    if (isset($d['name'])) {
        echo "Added: " . $lesson['order'] . ". " . $lesson['title_so'] . "\n";
    } else {
        echo "ERROR " . $lesson['order'] . ": $res\n";
        exit(1);
    }
}
echo "Done! " . count($lessons) . " Python lessons added.\n";
