# -*- coding: utf-8 -*-
# Generator for Ferga C# curriculum (Kurd AI). Builds csharp.json.
import json

LANG_ID = "-OysGzUzKG67KcswHXn2"

# Chapter labels (Sorani / Badini)
LV1_SO = "بەشی ١ - دەستپێک"
LV1_BA = "بەشا ١ - دەستپێک"
LV2_SO = "بەشی ٢ - گۆڕاوەکان و جۆرەکانی داتا"
LV2_BA = "بەشا ٢ - گۆڕاوەکان و جۆرەکانی داتا"
LV3_SO = "بەشی ٣ - ئۆپەرەیتەرەکان"
LV3_BA = "بەشا ٣ - ئۆپەرەیتەرەکان"
LV4_SO = "بەشی ٤ - مەرجەکان"
LV4_BA = "بەشا ٤ - مەرجەکان"
LV5_SO = "بەشی ٥ - لوولەکان"
LV5_BA = "بەشا ٥ - لوولەکان"
LV6_SO = "بەشی ٦ - فەنکشنەکان"
LV6_BA = "بەشا ٦ - فەنکشنەکان"
LV7_SO = "بەشی ٧ - ئارای و کۆلیکشن"
LV7_BA = "بەشا ٧ - ئارای و کۆلیکشن"
LV8_SO = "بەشی ٨ - OOP"
LV8_BA = "بەشا ٨ - OOP"


def lesson(order, level_so, level_ba, title_so, title_ba, content_so, content_ba,
            code, example_output, quiz_type,
            q_so="", q_ba="", opts_so=None, opts_ba=None, correct="",
            ch_so="", ch_ba="", expected="", ans=""):
    opts_so = opts_so if opts_so else ["", "", "", ""]
    opts_ba = opts_ba if opts_ba else ["", "", "", ""]
    return {
        "langId": LANG_ID,
        "order": order,
        "level_so": level_so,
        "level_ba": level_ba,
        "title_so": title_so,
        "title_ba": title_ba,
        "content_so": content_so,
        "content_ba": content_ba,
        "code": code,
        "code_css": "",
        "example_output": example_output,
        "challenge_desc_so": ch_so,
        "challenge_desc_ba": ch_ba,
        "expected_output": expected,
        "answer_code": ans,
        "answer_code_css": "",
        "quiz_type": quiz_type,
        "quiz_question_so": q_so,
        "quiz_question_ba": q_ba,
        "quiz_options_so": opts_so,
        "quiz_options_ba": opts_ba,
        "quiz_correct": correct,
        "max_attempts": 5,
        "allow_show_answer": True,
        "xp_cost": 0,
    }


lessons = []

# [[LESSON_DEFS_START]]
# ---------- Chapter 1: دەستپێک ----------
# Lesson 1 — ناساندنی C# (Concept 1: standard quiz)
lessons.append(lesson(
    order=1,
    level_so=LV1_SO, level_ba=LV1_BA,
    title_so="ناساندنی C# و پرۆگرامی یەکەم",
    title_ba="ناساندنا C# و پرۆگرامێ یێ دەستپێکێ",
    content_so="""<p>C# (بە ئینگلیزی: سی-شارپ) زمانێکی بەهێزی بەرنامەسازییە کە لەلایەن کۆمپانیای <strong>مایکرۆسۆفت</strong>ەوە دروست کراوە. ئەم زمانە بە شێوەیەکی باو لە دروستکردنی ئەپلیکەیشنی ویندۆز، وێبسایت، یارییەکان و ئەپەکانی مۆبایلدا بەکاردێت.</p>
<p>نموونەیەکی سادە لە پرۆگرامسازی: پرۆگرامساز وەک ئەو وەستانەیە کە یەکەم جار ئوتومبێل لێدەخوات؛ سەرەتا فەرمانە سادەکان دەزانێت پاشان دەچێت بۆ شتە ئاڵۆزەکان. یەکەم فەرمان کە دەیخوێنین <code>Console.WriteLine</code>ە کە نووسراوەکە لە کۆنسۆڵدا چاپ دەکات.</p>
<h3>پرۆگرامی یەکەم</h3>
<p>هەموو پرۆگرامێکی C# پێویستی بە <code>using System;</code> و کلاسی <code>Program</code> و میتۆدی <code>Main</code> هەیە. لە نموونەی خوارەوەدا نووسراوەیەک لە کۆنسۆڵدا چاپ دەکەین:</p>
<pre>Console.WriteLine("بەخێربێیت بۆ فێربوونی C#!");</pre>
<ul>
<li><strong>using System;</strong> — هێنانی ئامرازە پێویستەکان بۆ چاپکردن.</li>
<li><strong>class Program</strong> — کلاسی سەرەکی پرۆگرام.</li>
<li><strong>static void Main()</strong> — خاڵی دەستپێکی بەرنامەکە.</li>
</ul>
<p>دوای هەر فەرمانێک نیشانەی <code>;</code> دادەنرێت وەک کۆتایی هەڵواسە.</p>""",
    content_ba="""<p>C# (ب ئینگلیزی: سی-شارپ) زمانەکی بەهێزە یێ بەرنامەسازێ کە ل ئالیهن کومپانیا <strong>مایکرۆسۆفت</strong> ڤە هاتییە دروستکرن. ئەڤ زمانە ب شێوەیەکی گشتی ل دروستکرنا ئەپلکاسیۆنێن ویندۆزێ، وێبسایتی، یاریان و ئەپێن مۆبایلێ دا دهێتە بکارئینان.</p>
<p>میناکەکە ل بەرنامەسازی: بەرنامەساز وەک ئەو کەسێ یە کە ڤەکاری ئۆتوموبیلی دبیت؛ دەستپێک فەرمانێن سادە دزانیت پاشی دچیت بۆ بەرسێن ئالۆزتر. یەکێک ژ فەرمانێن دەستپێکێ یێن ئەم دخوانین <code>Console.WriteLine</code>یە کو دەقەکا ل کۆنسۆلێ دا چاپ دکەت.</p>
<h3>پرۆگرامێ یێ دەستپێکێ</h3>
<p>هەر پرۆگرامەکی C# پێدڤی ب <code>using System;</code> و کلاسا <code>Program</code> و میتۆدا <code>Main</code> هەیە. ل نمونیا خوارە دا دەقەکا ل کۆنسۆلێ دا چاپ دکەین:</p>
<pre>Console.WriteLine("بەخێربێیت بۆ فێربوونی C#!");</pre>
<ul>
<li><strong>using System;</strong> — ئینانا ئامرازێن پێدڤی بۆ چاپکرنێ.</li>
<li><strong>class Program</strong> — کلاسا سەرەکی یا پرۆگرامێ.</li>
<li><strong>static void Main()</strong> — خالا دەستپێکا بەرنامێ.</li>
</ul>
<p>پاشی هەر فەرمانەکی نیشانا <code>;</code> تێ دەهێتە دانان وەک دەنگەلێک یێ دەمێ هەلگرتنا فەرمانێ.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // ئەم پرۆگرامە نووسراوەیەک لە کۆنسۆڵدا چاپ دەکات
        Console.WriteLine("بەخێربێیت بۆ فێربوونی C#!");
    }
}""",
    example_output="بەخێربێیت بۆ فێربوونی C#!",
    quiz_type="choice",
    q_so="کامە لەم فەرمانانەی خوارەوە نووسراوەیەک لە کۆنسۆڵدا چاپ دەکات؟",
    q_ba="کیژەک ل ڤان فەرمانان دەقەکا ل کۆنسۆلێ دا چاپ دکەت؟",
    opts_so=['Console.WriteLine("بەخێربێیت بۆ فێربوونی C#!");',
             'Console.ReadLine("بەخێربێیت");',
             'System.Read();',
             'print("بەخێربێیت");'],
    opts_ba=['Console.WriteLine("بەخێربێیت بۆ فێربوونی C#!");',
             'Console.ReadLine("بەخێربێیت");',
             'System.Read();',
             'print("بەخێربێیت");'],
    correct="1",
))

# Lesson 2 — پێکهاتەی پرۆگرامەکە (Concept 2: predict output)
lessons.append(lesson(
    order=2,
    level_so=LV1_SO, level_ba=LV1_BA,
    title_so="پێکهاتەی پرۆگرامەکە",
    title_ba="پێکهاتەی پرۆگرامێ",
    content_so="""<p>پرۆگرامێکی C# وەک ماڵێک وایە: هەر ماڵێک بناغە و دیوار و سەقفی هەیە، بەم شێوەش هەر پرۆگرامێک پێکهاتەیەکی ڕێکوپێکی هەیە. ئەگەر یەک شت لە شوێنی خۆیدا نەبێت، پرۆگرامەکە ناکرێت.</p>
<h3>پێکهاتە سەرەکییەکان</h3>
<ul>
<li><code>using System;</code> — ئامرازە بنەڕەتییەکانی C# دەهێنێت بۆ کارکردن لەگەڵ کۆنسۆڵ.</li>
<li><code>class Program</code> — کلاسی سەرەکی کە هەموو کۆدەکە لە ناویەتی.</li>
<li><code>static void Main()</code> — ئەم میتۆدە خاڵی دەستپێکی پرۆگرامە؛ لەوێوە هەموو شتێک دەست پێدەکات.</li>
<li>هەر فەرمانێک بە <code>;</code> کۆتایی دێت.</li>
<li>فەرمانەکان لە نێو <code>{ }</code> دادەنرێن.</li>
</ul>
<p>لە نموونەکەدا دوو فەرمانی چاپکردن دەبینین؛ هەر یەکەیان نووسراوەکەی لە هێڵێکی جیادا چاپ دەکات، بۆیە هەر یەکەیان لە هێڵێکی تایبەتدا دەردەکەوێت.</p>
<pre>Console.WriteLine("یەکەم");
Console.WriteLine("دووەم");</pre>""",
    content_ba="""<p>پرۆگرامەکی C# وەک مالەکێ یە: هەر مالەکەک بناخە و دیوار و بانی هەیە، ب ڤی شێوەی جی هەر پرۆگرامەکەک پێکهاتەکەک رێک و پێک هەیە. گەر ئێک بەرس ل شوینێ خۆ دا نەبیت، پرۆگرام نایەتە کار.</p>
<h3>پێکهاتێن سەرەکی</h3>
<ul>
<li><code>using System;</code> — ئامرازێن بنەرەتی یێن C# تینیت بۆ کارکرنا ب کۆنسۆلێ.</li>
<li><code>class Program</code> — کلاسا سەرەکی کو هەمی کۆد د ناڤێ دا یە.</li>
<li><code>static void Main()</code> — ئەڤ میتۆدا خالا دەستپێکا پرۆگرامێ یە؛ ژ وی دەمی هەمی تیشت دەست پێ دکەت.</li>
<li>هەر فەرمانەکا ب <code>;</code> دەمێ دێتە سەر.</li>
<li>فەرمان ل ناڤ <code>{ }</code> دا تێنە دانان.</li>
</ul>
<p>ل نمونیا ئەڤرە دا دوو فەرمانێن چاپکرنێ دبینین؛ هەر ئێکەک ل رێزەکا جودا دەقەکا خۆ چاپ دکەت، لەوما هەر ئێکەک ل رێزەکا تایبەت دا دەردکەڤیت.</p>
<pre>Console.WriteLine("یەکەم");
Console.WriteLine("دووەم");</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // چاپکردنی دوو نووسراوە لە دوو هێڵدا
        Console.WriteLine("یەکەم");
        Console.WriteLine("دووەم");
    }
}""",
    example_output="یەکەم\nدووەم",
    quiz_type="choice",
    q_so='سەیری ئەم پارچە کۆدەی بکە:\n<pre>Console.WriteLine("١");\nConsole.WriteLine("٢");</pre>\nچی لە کۆنسۆڵدا چاپ دەکرێت؟',
    q_ba='سەیری ئەڤ پارچە کۆدی بکە:\n<pre>Console.WriteLine("١");\nConsole.WriteLine("٢");</pre>\nچی ل کۆنسۆلێ دا تێتە چاپکرن؟',
    opts_so=["١ ٢ لە یەک هێڵدا",
             "١ لە هێڵی یەکەم و ٢ لە هێڵی دووەم",
             "٢ لە هێڵی یەکەم و ١ لە هێڵی دووەم",
             "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["١ ٢ ل رێزەکا یەکێ دا",
             "١ ل رێزێ یەکێ و ٢ ل رێزێ دووێ",
             "٢ ل رێزێ یەکێ و ١ ل رێزێ دووێ",
             "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="2",
))

# Lesson 3 — کۆمێنتەکان (Concept 3: find the bug)
lessons.append(lesson(
    order=3,
    level_so=LV1_SO, level_ba=LV1_BA,
    title_so="کۆمێنتەکان",
    title_ba="کۆمێنت",
    content_so="""<p>کۆمێنتەکان وەک تێبینییەکانی کتێبن: بۆ کەسی دیکە (یان بۆ خۆت لە داهاتوودا) نووسراون، بەڵام پرۆگرامەکە هیچ کاری پێ ناکات. کۆمپیتەر کۆمێنتەکان ڕادەگرێت؛ تەنها بۆ فێربوون و ڕوونکردنەوەی کۆد بەکاردێن.</p>
<h3>دوو جۆری کۆمێنت</h3>
<ul>
<li><code>//</code> — کۆمێنتی تاک-هێڵ: هەموو ئەوەی لەدوای ئەم نیشانەیە لە هەمان هێڵدا دێت کۆمێنتە.</li>
<li><code>/* */</code> — کۆمێنتی فرە-هێڵ: هەموو ئەوەی لە نێوان ئەم دوو نیشانەیە دایە کۆمێنتە.</li>
</ul>
<p>کۆمێنتە باشەکان کۆدەکە ڕوونتر دەکەن و لە تیمدا کارکردن ئاسانتر دەکەن. لە نموونەکەدا هەردوو جۆرەکە بەکارهاتووە.</p>
<pre>// ئەمە کۆمێنتی تاک-هێڵە
Console.WriteLine("بەخێربێیت");
/* ئەمە کۆمێنتی فرە-هێڵە */</pre>""",
    content_ba="""<p>کۆمێنت وەک تێبینینێن پەرتووکێنە: بۆ کەسێن دی (یان بۆ خۆ تە ل دەمێ ئایندەیێ دا) تێنە نڤیسین، لێ پرۆگرام هیچ کار پێ ناکەت. کومپیوتر کۆمێنتان بەرف وەردگرت؛ تەنها بۆ فێربوونێ و ڕوونکرنا کۆدی بکارتینن.</p>
<h3>دوو جورێن کۆمێنتێ</h3>
<ul>
<li><code>//</code> — کۆمێنتێ رێزێک: هەمی ئەڤا کو پاشی ڤێ نیشانێ ل هەمان رێزێ دا یە کۆمێنتە.</li>
<li><code>/* */</code> — کۆمێنتێ فرە-رێز: هەمی ئەڤا کو د ناڤبەرا ڤان نیشانان دا یە کۆمێنتە.</li>
</ul>
<p>کۆمێنتێن باش کۆدی ڕوونتر دکەن و کارکرنا ل تیمێ دا ئاسانتەر دکەن. ل نمونیا ئەڤرە دا هەردوو جور هاتینە بکارئینان.</p>
<pre>// ئەڤە کۆمێنتێ رێزێکە
Console.WriteLine("بەخێربێیت");
/* ئەڤە کۆمێنتێ فرە-رێزە */</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // ئەمە کۆمێنتی تاک-هێڵە، هیچ کاری ناکات
        Console.WriteLine("بەخێربێیت");
        /* ئەمە کۆمێنتی فرە-هێڵە
           لە دوو هێڵ یان زیاتر */
        Console.WriteLine("کۆتایی");
    }
}""",
    example_output="بەخێربێیت\nکۆتایی",
    quiz_type="code",
    ch_so='''ئەم پرۆگرامە دەبێت نووسراوەی «سڵاو، کوردستان!» چاپ بکات بەڵام هەڵەیەکی تێدایە و بەم شێوەیە جێبەجێ نابێت. هەڵەکە بدۆزەرەوە و کۆدە تەواوە ڕاستکراوەکە بنووسە:
<pre>using System;

class Program
{
    static void Main()
    {
        // ئەم کۆدە نووسراوەیەک چاپ دەکات
        Console.Writeline("سڵاو، کوردستان!");
    }
}</pre>''',
    ch_ba='''ئەڤ پرۆگرامە دبیت دەقا «سڵاو، کوردستان!» چاپ بکەت لێ شاشلتیک د ناڤێ دا هەیە و ب ڤی شێوەی نایه‌تە کار. شاشلتی بدۆزە و کۆدی ته‌واو یێ راستکرى بنڤیسه:
<pre>using System;

class Program
{
    static void Main()
    {
        // ئەڤ کۆد دەقەکا چاپ دکەت
        Console.Writeline("سڵاو، کوردستان!");
    }
}</pre>''',
    expected="سڵاو، کوردستان!",
    ans="""using System;

class Program
{
    static void Main()
    {
        // نووسراوەکە لە کۆنسۆڵدا چاپ بکە
        Console.WriteLine("سڵاو، کوردستان!");
    }
}""",
))

# Lesson 4 — فەرمانەکانی کۆنسۆڵ (Concept 4: write from scratch)
lessons.append(lesson(
    order=4,
    level_so=LV1_SO, level_ba=LV1_BA,
    title_so="فەرمانەکانی کۆنسۆڵ",
    title_ba="فەرمانێن کۆنسۆلێ",
    content_so="""<p>کۆنسۆڵ وەک پەنجەرەیەکە بۆ بینینی ئەنجامی پرۆگرامەکەت. لە ڕێگەی کۆنسۆڵەوە دەتوانیت نووسراوە چاپ بکەیت و داتا وەربگریت لە بەکارهێنەر.</p>
<h3>فەرمانە سەرەکییەکان</h3>
<ul>
<li><code>Console.WriteLine(...)</code> — نووسراوەکە چاپ دەکات و هێڵێک نوێ دەکاتەوە.</li>
<li><code>Console.Write(...)</code> — نووسراوەکە چاپ دەکات بەبێ هێڵی نوێ.</li>
<li><code>Console.ReadLine()</code> — هێڵێک وەردەگرێت لە بەکارهێنەرەوە.</li>
</ul>
<p>لە نموونەکەدا دەبینین کە <code>WriteLine</code> دوای هەر چاپێک هێڵی نوێ دەکاتەوە، بەڵام <code>Write</code> لە هەمان هێڵدا بەردەوام دەبێت.</p>
<pre>Console.WriteLine("هێڵی یەکەم");
Console.Write("هێڵی دووەم");
Console.Write(" بەردەوامە");</pre>
<p>ئەنجام: هێڵی یەکەم لە هێڵێکی جیادا، و پاشان «هێڵی دووەم بەردەوامە» لە هەمان هێڵدا.</p>""",
    content_ba="""<p>کۆنسۆل وەک پەنجەرەکەکە بۆ دیتنا ئەنجامێ پرۆگرامێ تە. ل رێیا کۆنسۆلی ڤە دتوانی دەق چاپ کەی و داتا وەربگری ژ بکارهینەر.</p>
<h3>فەرمانێن سەرەکی</h3>
<ul>
<li><code>Console.WriteLine(...)</code> — دەقەکا چاپ دکەت و رێزەکا نوی دکەتەوە.</li>
<li><code>Console.Write(...)</code> — دەقەکا چاپ دکەت بێ رێزەکا نوی.</li>
<li><code>Console.ReadLine()</code> — رێزەکا وەردگرت ژ بکارهینەر.</li>
</ul>
<p>ل نمونیا ئەڤرە دا دبینین کو <code>WriteLine</code> پاشی هەر چاپکرنەکا رێزەکا نوی دکەتەوە، لێ <code>Write</code> ل هەمان رێزێ دا دبەردەوامە.</p>
<pre>Console.WriteLine("هێڵی یەکەم");
Console.Write("هێڵی دووەم");
Console.Write(" بەردەوامە");</pre>
<p>ئەنجام: هێڵی یەکەم ل رێزەکا جودا دا، و پاشی «هێڵی دووەم بەردەوامە» ل هەمان رێزێ دا.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // WriteLine هێڵێک نوێ دەکاتەوە
        Console.WriteLine("هێڵی یەکەم");
        // Write بەبێ هێڵی نوێ دەنووسێت
        Console.Write("هێڵی دووەم");
        Console.Write(" بەردەوامە");
    }
}""",
    example_output="هێڵی یەکەم\nهێڵی دووەم بەردەوامە",
    quiz_type="code",
    ch_so="پرۆگرامێکی تەواو بنووسە (بە using System; و کلاس و Main) کە دوو نووسراوە لە دوو هێڵدا چاپ بکات: یەکەم «بەخێربێیت» و دووەم «بە فێربوونی C#».",
    ch_ba="پرۆگرامەکەکا ته‌واو بنڤیسه (ب گەل using System; و کلاس و Main) کو دوو دەقان ل دوو رێزان دا چاپ دکەت: یەکێک «بەخێربێیت» و دووێ «بە فێربوونی C#».",
    expected="بەخێربێیت\nبە فێربوونی C#",
    ans="""using System;

class Program
{
    static void Main()
    {
        // یەکەم نووسراوە
        Console.WriteLine("بەخێربێیت");
        // دووەم نووسراوە
        Console.WriteLine("بە فێربوونی C#");
    }
}""",
))

# ---------- Chapter 2: گۆڕاوەکان و جۆرەکانی داتا ----------
# Lesson 5 — گۆڕاوەکان (Concept 1: standard quiz)
lessons.append(lesson(
    order=5,
    level_so=LV2_SO, level_ba=LV2_BA,
    title_so="گۆڕاوەکان",
    title_ba="گۆڕەر",
    content_so="""<p>گۆڕاو (Variable) وەک سندووقێک وایە کە دەتوانیت داتایەک تێیدا هەڵبگریت و دواتر بیگۆڕیت. بۆ نموونە، ئەگەر تەمەنی بەکارهێنەرێک هەڵبگریت، دەتوانیت بیخەیتە ناو گۆڕاوێکی <code>int</code>.</p>
<h3>چۆنیەتی دروستکردنی گۆڕاو</h3>
<p>بۆ دروستکردنی گۆڕاو سێ شت پێویستە: جۆری داتا، ناو، و نرخ (ئارەزوومەندانە).</p>
<pre>int temen = 20;
string nav = "ئاڤا";</pre>
<ul>
<li><strong>int</strong> — ژمارەی تەواو (وەک 20).</li>
<li><strong>string</strong> — دەق یان نووسراوە.</li>
<li>ناوی گۆڕاو دەبێت بە پیتی بچووک دەست پێبکات و نابێت وشەی ناسراوی C# بێت.</li>
<li>دوای دروستکردن، دەتوانیت نرخەکە چاپ بکەیت یان بیگۆڕیت.</li>
</ul>
<p>گۆڕاوەکان وەک ئەو سندووقانەن کە لە ماڵ دەتوانیت شتی جیاوازیان لێ بگریت و بە ناویانەوە باندۆکەیان بکەیت.</p>""",
    content_ba="""<p>گۆڕەر (Variable) وەک سندوقەکەکە کو دتوانی دانەیەک د ناڤێ دا هەلگری و پاشی بگوهۆری. بۆ میناک، گەر تەمەنێ بکارهینەری هەلگری، دتوانی بکەیە ناڤ گۆڕەرەکەکی <code>int</code>.</p>
<h3>چاوا گۆڕەر دێتە دروستکرن</h3>
<p>بۆ دروستکرنا گۆڕەری سێ تیشت پێدڤی یە: جورێ دانەیێ، ناڤ، و نرخ (دلخواز).</p>
<pre>int temen = 20;
string nav = "ئاڤا";</pre>
<ul>
<li><strong>int</strong> — ژمارەکا ته‌واو (وەک 20).</li>
<li><strong>string</strong> — دەق یا نڤیسین.</li>
<li>ناڤێ گۆڕەری دبیت ب تیپەکا بچوک دەست پێ بکەت و نەبیتە وشەکا ناسایی یا C#.</li>
<li>پاشی دروستکرنێ، دتوانی نرخێ چاپ کەی یان بگوهۆری.</li>
</ul>
<p>گۆڕەر وەک ڤان سندوقانە یێن ل مال کو دتوانی تیشتێن جودا د ناڤان دا هەلگری و ب ناڤان ڤە نیشانە کەی.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // دروستکردنی گۆڕاوەکان
        int temen = 20;
        string nav = "ئاڤا";
        // چاپکردنی نرخەکان
        Console.WriteLine(nav);
        Console.WriteLine(temen);
    }
}""",
    example_output="ئاڤا\n20",
    quiz_type="choice",
    q_so="کامە لەم بڕگانە گۆڕاوێکی ژمارەی تەواو (int) بە ناوی temen دروست دەکات؟",
    q_ba="کیژەک ل ڤان بڕگان گۆڕەرەکا ژمارا ته‌واو (int) ب ناڤی temen دروست دکەت؟",
    opts_so=["int temen = 20;",
             "string temen = 20;",
             'int "temen" = 20;',
             "temen = int 20;"],
    opts_ba=["int temen = 20;",
             "string temen = 20;",
             'int "temen" = 20;',
             "temen = int 20;"],
    correct="1",
))

# Lesson 6 — جۆرەکانی داتا (Concept 2: predict output)
lessons.append(lesson(
    order=6,
    level_so=LV2_SO, level_ba=LV2_BA,
    title_so="جۆرەکانی داتا",
    title_ba="جورێن دانەیێ",
    content_so="""<p>لە C# دا هەر داتایەک جۆرێکی هەیە، وەک ئەوەی هەر کەلوپەلێک لە ماڵ شوێنی خۆی هەبێت. جۆری داتا دەستنیشان دەکات کە گۆڕاوەکە چ شتێک دەتوانێت هەڵبگرێت.</p>
<h3>جۆرە باوەکان</h3>
<ul>
<li><code>int</code> — ژمارەی تەواو، وەک 7.</li>
<li><code>double</code> — ژمارەی کەسری، وەک 2.5.</li>
<li><code>char</code> — یەک پیت، لە نێو دوو نووسە بەتەنها: <code>'ک'</code>.</li>
<li><code>bool</code> — ڕاستی یان درۆ: <code>true</code> یان <code>false</code>.</li>
<li><code>string</code> — دەقێک یان زنجیرەیەک پیت.</li>
</ul>
<p>بەکارهێنانی جۆری داتای گونجاو ڕێگری دەکات لە هەڵەکان و یادگەری (memory) بە شێوەیەکی باش بەکاردێنێت. لە نموونەکەدا هەر پێنج جۆرەکە بەکارهاتوون.</p>
<pre>int jimara = 7;
double baha = 2.5;
char pit = 'ک';
bool raast = true;
string nav = "هەولێر";</pre>""",
    content_ba="""<p>د C# دا هەر دانەیەک جورەکێ هەیە، وەک ئەوێ کو هەر کەسبەکە ل مال شوینێ خۆ هەبیت. جورێ دانەیێ ديارى دکەت کو گۆڕەر چ تیشتەک دشێت هەلگرت.</p>
<h3>جورێن گشتی</h3>
<ul>
<li><code>int</code> — ژمارەکا ته‌واو، وەک 7.</li>
<li><code>double</code> — ژمارەکا کەسری، وەک 2.5.</li>
<li><code>char</code> — تیپەک، د ناڤبەرا دوو نڤیسینان دا: <code>'ک'</code>.</li>
<li><code>bool</code> — راستی یان درەو: <code>true</code> یان <code>false</code>.</li>
<li><code>string</code> — دەقەک یا زنجیرەکا تیپان.</li>
</ul>
<p>بکارئینانا جورێ دانەیێ یێ گونجای ڕێگری دکەت ژ هەلێنان و بەرفیرا (memory) ب شێوەکا باش بکارتینت. ل نمونیا ئەڤرە دا هەر پێنج جور هاتینە بکارئینان.</p>
<pre>int jimara = 7;
double baha = 2.5;
char pit = 'ک';
bool raast = true;
string nav = "هەولێر";</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // نموونەی جۆرە جۆرەکانی داتا
        int jimara = 7;
        double baha = 2.5;
        char pit = 'ک';
        bool raast = true;
        string nav = "هەولێر";

        Console.WriteLine(jimara);
        Console.WriteLine(baha);
        Console.WriteLine(pit);
        Console.WriteLine(raast);
        Console.WriteLine(nav);
    }
}""",
    example_output="7\n2.5\nک\nTrue\nهەولێر",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>double x = 3.5;\nConsole.WriteLine(x);</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>double x = 3.5;\nConsole.WriteLine(x);</pre>\nچی دچاپیت؟',
    opts_so=["3.5", "3", "35", "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["3.5", "3", "35", "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="1",
))

# Lesson 7 — وەرگرتنی داتا لە بەکارهێنەر (Concept 3: find the bug)
lessons.append(lesson(
    order=7,
    level_so=LV2_SO, level_ba=LV2_BA,
    title_so="وەرگرتنی داتا لە بەکارهێنەر",
    title_ba="وەرگرتنا دانەیێ ژ بکارهینەر",
    content_so="""<p>پرۆگرامە ڕاستەقینەکان لەگەڵ بەکارهێنەر کارلێک دەکەن. وەک ئەوەی لە چێشتخانەیەک داوای خواردن بکەیت و وەڵام وەربگریت، پرۆگرامەکە دەتوانێت بە <code>Console.ReadLine()</code> داتا لە بەکارهێنەر وەربگرێت.</p>
<h3>وەرگرتنی نووسراوە و ژمارە</h3>
<p><code>Console.ReadLine()</code> هەمیشە <code>string</code> دەگەڕێنێتەوە. ئەگەر پێویستت بە ژمارە بێت، دەبێت بە <code>Convert.ToInt32()</code> بیگۆڕیت بۆ ژمارە.</p>
<pre>string nav = Console.ReadLine();
int jimara = Convert.ToInt32(Console.ReadLine());</pre>
<ul>
<li>یەکەم: نووسراوەکە ڕاستەوخۆ دەخرێتە گۆڕاو.</li>
<li>دووەم: نووسراوەکە یەکەم جار دەگۆڕدرێت بۆ ژمارەی تەواو.</li>
</ul>
<p>لە نموونەی کۆدەکەدا ناوی بەکارهێنەر وەردەگرین و بە سڵاو بە شوێنیەوە چاپی دەکەین. لە کاتی جێبەجێکردندا، پاش نووسینی ناوەکە و دابەزینی Enter، ئەنجامەکە دەبینیت.</p>""",
    content_ba="""<p>پرۆگرامێن راستی ب گەل بکارهینەری کارلێک دکەن. وەک ئەوێ ل خواردانەگەهاکە دا خوارنەکە دبێژیت و بەرسڤ وەردگریت، پرۆگرام دشێت ب <code>Console.ReadLine()</code> دانە ژ بکارهینەری وەربگرت.</p>
<h3>وەرگرتنا نڤیسینێ و ژمارێ</h3>
<p><code>Console.ReadLine()</code> هەرگاڤ <code>string</code> دگەڕینتەوە. گەر پێدڤی ب ژمارەکا تە بیت، دبیت ب <code>Convert.ToInt32()</code> بگوهۆری بۆ ژمارێ.</p>
<pre>string nav = Console.ReadLine();
int jimara = Convert.ToInt32(Console.ReadLine());</pre>
<ul>
<li>یەکێک: نڤیسینا ڕاستەوخۆ دچیتە ناڤ گۆڕەری.</li>
<li>دووێ: نڤیسینا دەستپێک دگەهێتە گوهۆرینا بۆ ژمارەکا ته‌واو.</li>
</ul>
<p>ل نمونیا کۆدی دا ناڤێ بکارهینەری وەردگرین و ب سلاڤەکا پشی بەرسڤا وی چاپ دکەین. ل دەمێ کارکردنێ دا، پاشی نڤیسینا ناڤی و لداکتیڤکرنا Enter، ئەنجام دبینی.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // داواکردنی ناو لە بەکارهێنەر
        Console.Write("ناوت بنووسە: ");
        string nav = Console.ReadLine();
        // سڵاوکردن بە ناوەکە
        Console.WriteLine("سڵاو، " + nav + "!");
    }
}""",
    example_output="ناوت بنووسە: سڵاو، ئاڤا!",
    quiz_type="code",
    ch_so='''ئەم کۆدە دەبێت ژمارەیەک لە بەکارهێنەر وەربگرێت و چاپی بکات، بەڵام هەڵەیەکی تێدایە و کۆمپایل نابێت. هەڵەکە بدۆزەرەوە و کۆدە ڕاستکراوەکە بنووسە. بە گریمانەی ئەوەی بەکارهێنەر 5 بنووسێت، دەبێت ئەنجامەکە «ژمارەکەت: 5» بێت:
<pre>using System;

class Program
{
    static void Main()
    {
        Console.Write("ژمارەیەک بنووسە: ");
        int jimara = Console.ReadLine();
        Console.WriteLine("ژمارەکەت: " + jimara);
    }
}</pre>''',
    ch_ba='''ئەڤ کۆد دبیت ژمارەکا ژ بکارهینەری وەربگرت و چاپی بکەت، لێ شاشلتیک تێدا هەیە و نایەتە کار. شاشلتی بدۆزە و کۆدی راستکرى بنڤیسه. ب گریمانا کو بکارهینەر 5 بنڤیسیت، دبیت ئەنجام «ژمارەکەت: 5» بیت:
<pre>using System;

class Program
{
    static void Main()
    {
        Console.Write("ژمارەیەک بنووسە: ");
        int jimara = Console.ReadLine();
        Console.WriteLine("ژمارەکەت: " + jimara);
    }
}</pre>''',
    expected="ژمارەکەت: 5",
    ans="""using System;

class Program
{
    static void Main()
    {
        // داواکردنی ژمارە لە بەکارهێنەر
        Console.Write("ژمارەیەک بنووسە: ");
        string tekst = Console.ReadLine();
        // گۆڕینی نووسراوەکە بۆ ژمارە
        int jimara = Convert.ToInt32(tekst);
        Console.WriteLine("ژمارەکەت: " + jimara);
    }
}""",
))

# Lesson 8 — نەگۆڕەکان (Concept 4: write from scratch)
lessons.append(lesson(
    order=8,
    level_so=LV2_SO, level_ba=LV2_BA,
    title_so="نەگۆڕەکان",
    title_ba="نەگۆڕەر",
    content_so="""<p>هەندێک نرخ هەن کە دەبێت هەرگیز نەگۆڕێن، وەک نرخی <strong>π (پای)</strong> لە بیرکاریدا. لە C# دا بە وشەی <code>const</code> نەگۆڕێک دروست دەکەیت کە دوای دیاریکردن ناتوانیت بیگۆڕیت.</p>
<h3>چۆنیەتی دروستکردن</h3>
<pre>const double PI = 3.14159;</pre>
<ul>
<li>پێویستە نرخەکە یەکسەر لە کاتی دروستکردندا دیاری بکەیت.</li>
<li>ناوی نەگۆڕ بە پیتی گەورە دەنووسرێت بۆ ئەوەی بەچاو ببینرێت.</li>
<li>ئەگەر هەوڵی گۆڕینی بدەیت، C# هەڵە دەدات.</li>
</ul>
<p>بەکارهێنانی نەگۆڕ یارمەتی دەدات کۆدەکە سەلامەتتر و ڕوونتر بێت؛ چونکە نرخە گرنگەکان لە یەک شوێندا دەنووسیت و دووبارە نابێنەوە.</p>""",
    content_ba="""<p>هینەک نرخ هەنە کو دبیت هەرگاڤ نەگوهۆرن، وەک نرخێ <strong>π (پای)</strong> د بیرکاریێ دا. د C# دا ب وشەیا <code>const</code> نەگۆڕەک دروست دکەی کو پاشی ديارىکرنێ نتوانی بگوهۆری.</p>
<h3>چاوا دروست دبیت</h3>
<pre>const double PI = 3.14159;</pre>
<ul>
<li>پێدڤی یە کو نرخ ل دەمێ دروستکرنێ دا رێکە دیار بکەی.</li>
<li>ناڤێ نەگۆڕی ب تیپێن مه‌زن تێتە نڤیسین داکو ب چاڤان ببینیت.</li>
<li>گەر هەوڵا گوهۆرینێ بدەی، C# هەلە ددەت.</li>
</ul>
<p>بکارئینانا نەگۆڕان ئالیکارێ دکەت کو کۆد سەلامەتتر و ڕوونتر بیت؛ چونکی نرخێن گرنگ ل ئێک شوینی دا تێنە نڤیسین و دووبارە نابنەوە.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // نەگۆڕێک کە نرخەکەی ناگۆڕێت
        const double PI = 3.14159;
        Console.WriteLine(PI);
    }
}""",
    example_output="3.14159",
    quiz_type="code",
    ch_so="پرۆگرامێکی تەواو بنووسە کە نەگۆڕێکی (const) بە ناوی sal و جۆری int و نرخی 2026 دروست بکات، پاشان نرخەکەی چاپ بکات.",
    ch_ba="پرۆگرامەکەکا ته‌واو بنڤیسه کو نەگۆڕەکەکا (const) ب ناڤی sal و جورێ int و نرخی 2026 دروست دکەت، پاشی نرخێ چاپ دکەت.",
    expected="2026",
    ans="""using System;

class Program
{
    static void Main()
    {
        // نەگۆڕێکی ساڵ
        const int sal = 2026;
        Console.WriteLine(sal);
    }
}""",
))

# ---------- Chapter 3: ئۆپەرەیتەرەکان ----------
# Lesson 9 — ئۆپەرەیتەری ژمێراری (Concept 1: standard quiz)
lessons.append(lesson(
    order=9,
    level_so=LV3_SO, level_ba=LV3_BA,
    title_so="ئۆپەرەیتەری ژمێراری",
    title_ba="ئۆپەرەیتێرێن ژمارتنێ",
    content_so="""<p>ئۆپەرەیتەرە ژمێرارییەکان وەک ئامرازەکانی ژمێراری وایە لە بیرکاری: کۆکردنەوە، لێدەرکردن، زۆرکردن و دابەشکردن. C# هەموو ئەم ئۆپەرەیتەرانە پشتگیری دەکات.</p>
<h3>ئۆپەرەیتەرەکان</h3>
<ul>
<li><code>+</code> — کۆکردنەوە.</li>
<li><code>-</code> — لێدەرکردن.</li>
<li><code>*</code> — زۆرکردن.</li>
<li><code>/</code> — دابەشکردن. تێبینی: دابەشکردنی دوو ژمارەی تەواو بەشە کەسرییەکە فڕێدەدات.</li>
<li><code>%</code> — پاشماوە (remainder). بۆ نموونە <code>10 % 3</code> یەکسانە بە <code>1</code>.</li>
</ul>
<p>لە نموونەکەدا <code>10 / 3</code> نەک 3.33 بەڵکو <code>3</code> دەگەڕێنێتەوە چونکە هەردووکیان <code>int</code>ن. ئەمە گرنگە لە پرۆگرامسازی.</p>
<pre>int a = 10;
int b = 3;
Console.WriteLine(a + b);
Console.WriteLine(a - b);
Console.WriteLine(a * b);
Console.WriteLine(a / b);
Console.WriteLine(a % b);</pre>""",
    content_ba="""<p>ئۆپەرەیتێرێن ژمارتنێ وەک ئامرازێن ژمارتنێ یێن ماتماتیکێنە: کۆکرن، ژێبرن، زێدەکرن و پارڤەکرن. C# هەمی ڤان ئۆپەرەیتێران دگەل دکەت.</p>
<h3>ئۆپەرەیتێرێن ژمارتنێ</h3>
<ul>
<li><code>+</code> — کۆکرن.</li>
<li><code>-</code> — ژێبرن.</li>
<li><code>*</code> — زێدەکرن.</li>
<li><code>/</code> — پارڤەکرن. تێبین: پارڤەکرنا دوو ژمارێن ته‌واو بەشا کەسری ئاڤیتە دەرڤە.</li>
<li><code>%</code> — پاشماوە. بۆ میناک <code>10 % 3</code> یەکسانە ب <code>1</code>.</li>
</ul>
<p>ل نمونیا ئەڤرە دا <code>10 / 3</code> نەک 3.33 لێ <code>3</code> دگەڕینتەوە چونکی هەردوو <code>int</code>نە. ئەڤە گرنگە ل بەرنامەسازی دا.</p>
<pre>int a = 10;
int b = 3;
Console.WriteLine(a + b);
Console.WriteLine(a - b);
Console.WriteLine(a * b);
Console.WriteLine(a / b);
Console.WriteLine(a % b);</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int a = 10;
        int b = 3;
        // کردارە ژمێرارییەکان
        Console.WriteLine(a + b);
        Console.WriteLine(a - b);
        Console.WriteLine(a * b);
        Console.WriteLine(a / b);
        Console.WriteLine(a % b);
    }
}""",
    example_output="13\n7\n30\n3\n1",
    quiz_type="choice",
    q_so="ئۆپەرەیتەری % لە C# دا چی دەکات؟",
    q_ba="ئۆپەرەیتێرێ % ل C# دا چ دکەت؟",
    opts_so=["پاشماوەی دابەشکردن دەگەڕێنێتەوە",
             "دابەشکردن دەکات",
             "زۆرکردن دەکات",
             "هیچ"],
    opts_ba=["پاشماوێ پارڤەکرنێ دگەڕینتەوە",
             "پارڤەکرن دکەت",
             "زێدەکرن دکەت",
             "هیچ"],
    correct="1",
))

# Lesson 10 — ئۆپەرەیتەری بەراوردکردن (Concept 2: predict output)
lessons.append(lesson(
    order=10,
    level_so=LV3_SO, level_ba=LV3_BA,
    title_so="ئۆپەرەیتەری بەراوردکردن",
    title_ba="ئۆپەرەیتێرێن بەراوردکرنێ",
    content_so="""<p>بەراوردکردن وەک کێشانەوەی دوو کەلوپەلە: دەزانیت کامەیان گەورەترە یان ئایا یەکسانن یان نا. لە C# دا ئۆپەرەیتەرەکانی بەراوردکردن هەمیشە <code>true</code> یان <code>false</code> دەگەڕێننەوە.</p>
<h3>ئۆپەرەیتەرەکان</h3>
<ul>
<li><code>==</code> — یەکسانن؟</li>
<li><code>!=</code> — نایەکسانن؟</li>
<li><code>&gt;</code> — گەورەترە؟</li>
<li><code>&lt;</code> — بچووکترە؟</li>
<li><code>&gt;=</code> — گەورەتر یان یەکسانە؟</li>
<li><code>&lt;=</code> — بچووکتر یان یەکسانە؟</li>
</ul>
<p>تێبینی گرنگ: <code>=</code> بەکارناهێت بۆ بەراوردکردن؛ ئەوە بۆ تەرخانکردنی نرخە. بۆ بەراوردکردن دەبێت <code>==</code> بەکاربهێنیت.</p>
<pre>int x = 5;
int y = 8;
Console.WriteLine(x < y);
Console.WriteLine(x == y);
Console.WriteLine(x != y);</pre>""",
    content_ba="""<p>بەراوردکرن وەک پێڤەچاڤکرنا دوو کەسبەکە: دزانی کیژەک مه‌زنترە یا ئەرێ یەکسانن یا نا. ل C# دا ئۆپەرەیتێرێن بەراوردکرنێ هەرگاڤ <code>true</code> یان <code>false</code> دگەڕیننەوە.</p>
<h3>ئۆپەرەیتێرێن بەراوردکرنێ</h3>
<ul>
<li><code>==</code> — یەکسانن؟</li>
<li><code>!=</code> — نە یەکسانن؟</li>
<li><code>&gt;</code> — مه‌زنترە؟</li>
<li><code>&lt;</code> — بچوکترە؟</li>
<li><code>&gt;=</code> — مه‌زنتر یا یەکسانە؟</li>
<li><code>&lt;=</code> — بچوکتر یا یەکسانە؟</li>
</ul>
<p>تێبینا گرنگ: <code>=</code> ژ بۆ بەراوردکرنێ نایه‌تە بکارئینان؛ ئەو بۆ دانانا نرخی یە. بۆ بەراوردکرنێ دبیت <code>==</code> بکاربینیت.</p>
<pre>int x = 5;
int y = 8;
Console.WriteLine(x < y);
Console.WriteLine(x == y);
Console.WriteLine(x != y);</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int x = 5;
        int y = 8;
        // بەراوردکردنی دوو ژمارە
        Console.WriteLine(x < y);
        Console.WriteLine(x == y);
        Console.WriteLine(x != y);
    }
}""",
    example_output="True\nFalse\nTrue",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>Console.WriteLine(7 > 3);</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>Console.WriteLine(7 > 3);</pre>\nچی دچاپیت؟',
    opts_so=["True", "False", "7", "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["True", "False", "7", "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="1",
))

# Lesson 11 — ئۆپەرەیتەری لۆژیکی (Concept 3: find the bug)
lessons.append(lesson(
    order=11,
    level_so=LV3_SO, level_ba=LV3_BA,
    title_so="ئۆپەرەیتەری لۆژیکی",
    title_ba="ئۆپەرەیتێرێن لۆژيكی",
    content_so="""<p>هەندێک جار پێویستە چەند مەرجێک لەگەڵ یەکدا پشکنین بکەیت، وەک ئەوەی: "ئەگەر ئاسمان هەور بێت و با هەبێت، باران دەبارێت". ئۆپەرەیتەرە لۆژیکییەکان ئەم کارە دەکەن.</p>
<h3>سێ ئۆپەرەیتەری سەرەکی</h3>
<ul>
<li><code>&amp;&amp;</code> (AND) — هەردوو مەرجەکە دەبێت ڕاست بن.</li>
<li><code>||</code> (OR) — بەلانی کەم یەکێکیان دەبێت ڕاست بێت.</li>
<li><code>!</code> (NOT) — پێچەوانەکە دەکات: ڕاست دەکات بە درۆ و درۆ بە ڕاست.</li>
</ul>
<p>لە نموونەکەدا، تەمەن 25 و بەڵگەی فەرمانکردن ڕاستە؛ بۆیە مەرجی <code>&amp;&amp;</code> ڕاستە، بەڵام <code>temen > 30</code> درۆیە.</p>
<pre>int temen = 25;
bool xwendekare = true;
Console.WriteLine(temen > 18 && xwendekare);
Console.WriteLine(temen > 30 || xwendekare);
Console.WriteLine(!xwendekare);</pre>""",
    content_ba="""<p>هینەک جاران پێدڤی یە چەند مەرجەکا پێکڤە بپشکنی، وەک: "گەر ئاسمان هەور بیت و با هەبیت، باران دباریت". ئۆپەرەیتێرێن لۆژیكی ڤێ کارێ دکەن.</p>
<h3>سێ ئۆپەرەیتێرێن سەرەکی</h3>
<ul>
<li><code>&amp;&amp;</code> (AND) — هەردوو مەرج دبیت راست بن.</li>
<li><code>||</code> (OR) — به‌لایەن کێم ئێکەک دبیت راست بیت.</li>
<li><code>!</code> (NOT) — بەرسڤا دگوهۆریت: راست دکەتە درەو و درەو بە راست.</li>
</ul>
<p>ل نمونیا ئەڤرە دا، تەمەن 25 و بەلگەها کارکرنێ راستە؛ لەوما مەرجێ <code>&amp;&amp;</code> راستە، لێ <code>temen > 30</code> درەوە.</p>
<pre>int temen = 25;
bool xwendekare = true;
Console.WriteLine(temen > 18 && xwendekare);
Console.WriteLine(temen > 30 || xwendekare);
Console.WriteLine(!xwendekare);</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int temen = 25;
        bool xwendekare = true;
        // هەردوو مەرجەکە ڕاستن؟
        Console.WriteLine(temen > 18 && xwendekare);
        // یەکێکیان ڕاستە؟
        Console.WriteLine(temen > 30 || xwendekare);
        // پێچەوانەکەی
        Console.WriteLine(!xwendekare);
    }
}""",
    example_output="True\nTrue\nFalse",
    quiz_type="code",
    ch_so='''ئەم کۆدە دەبێت True چاپ بکات بەڵام هەڵەیەکی تێدایە و کۆمپایل نابێت. هەڵەکە بدۆزەرەوە و کۆدە تەواوە ڕاستکراوەکە بنووسە:
<pre>using System;

class Program
{
    static void Main()
    {
        bool baran = true;
        Console.WriteLine(baran or true);
    }
}</pre>''',
    ch_ba='''ئەڤ کۆد دبیت True چاپ بکەت لێ شاشلتیک تێدا هەیە و نایەتە کار. شاشلتی بدۆزە و کۆدی ته‌واو یێ راستکرى بنڤیسه:
<pre>using System;

class Program
{
    static void Main()
    {
        bool baran = true;
        Console.WriteLine(baran or true);
    }
}</pre>''',
    expected="True",
    ans="""using System;

class Program
{
    static void Main()
    {
        bool baran = true;
        // ئۆپەرەیتەری لۆژیکی دروست: ||
        Console.WriteLine(baran || true);
    }
}""",
))

# Lesson 12 — پێشینەی ئۆپەرەیتەرەکان (Concept 4: write from scratch)
lessons.append(lesson(
    order=12,
    level_so=LV3_SO, level_ba=LV3_BA,
    title_so="پێشینەی ئۆپەرەیتەرەکان",
    title_ba="پێشینەی ئۆپەرەیتێران",
    content_so="""<p>لە بیرکاریدا، زیابوون پێش کۆکردنەوە دێت: <code>2 + 3 * 4</code> یەکسانە بە <code>14</code> نەک <code>20</code>. لە C# دا هەمان ڕێسا هەیە، بەڵام دەتوانیت بە پرانتێز <code>( )</code> ڕیزبەندییەکە بگۆڕیت.</p>
<h3>ڕیزبەندی کارکردن</h3>
<ul>
<li>یەکەم: پرانتێزەکان <code>( )</code>.</li>
<li>دووەم: زۆرکردن و دابەشکردن <code>*</code> و <code>/</code>.</li>
<li>سێیەم: کۆکردنەوە و لێدەرکردن <code>+</code> و <code>-</code>.</li>
</ul>
<p>بۆ ئەوەی کۆدەکە ڕوونتر بێت، هەمیشە پرانتێز بەکاربهێنە تەنانەت ئەگەر پێویست نەکات.</p>
<pre>int encam = 2 + 3 * 4;      // 14
int encam2 = (2 + 3) * 4;    // 20
Console.WriteLine(encam);
Console.WriteLine(encam2);</pre>""",
    content_ba="""<p>د ماتماتیکێ دا، زێدەکرن بەری کۆکرنێ دێت: <code>2 + 3 * 4</code> یەکسانە ب <code>14</code> نەک <code>20</code>. ل C# دا هەمان رێباز هەیە، لێ دتوانی ب کەڤانان <code>( )</code> ریزبەندیێ بگوهۆری.</p>
<h3>ریزبەندیا کارکرنێ</h3>
<ul>
<li>یەکێک: کەڤان <code>( )</code>.</li>
<li>دووێ: زێدەکرن و پارڤەکرن <code>*</code> و <code>/</code>.</li>
<li>سێیێ: کۆکرن و ژێبرن <code>+</code> و <code>-</code>.</li>
</ul>
<p>داکو کۆد ڕوونتر بیت، هەرگاڤ کەڤانان بکاربینە تە به‌لایەن نەپێدڤی بن.</p>
<pre>int encam = 2 + 3 * 4;      // 14
int encam2 = (2 + 3) * 4;    // 20
Console.WriteLine(encam);
Console.WriteLine(encam2);</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // ژمێراری بەپێی پێشینە: زیابوون پێش کۆکردنەوە
        int encam = 2 + 3 * 4;
        Console.WriteLine(encam);
        // بە بەکارهێنانی پرانتێز
        int encam2 = (2 + 3) * 4;
        Console.WriteLine(encam2);
    }
}""",
    example_output="14\n20",
    quiz_type="code",
    ch_so="پرۆگرامێکی تەواو بنووسە کە بەرکەوتەی (10 - 4) * 2 لە گۆڕاوێکدا هەڵبگرێت و چاپی بکات.",
    ch_ba="پرۆگرامەکەکا ته‌واو بنڤیسه کو ئەنجامێ (10 - 4) * 2 ل گۆڕەرەکا دا هەلگرت و چاپ دکەت.",
    expected="12",
    ans="""using System;

class Program
{
    static void Main()
    {
        // ژمێراری بە پرانتێز
        int encam = (10 - 4) * 2;
        Console.WriteLine(encam);
    }
}""",
))

# ---------- Chapter 4: مەرجەکان ----------
# Lesson 13 — if و else (Concept 1: standard quiz)
lessons.append(lesson(
    order=13,
    level_so=LV4_SO, level_ba=LV4_BA,
    title_so="if و else",
    title_ba="if و else",
    content_so="""<p>لە ژیاندا بەپێی بارودۆخ بڕیار دەدەین: "ئەگەر باران ببارێت، سەربان دەبەم؛ ئەگینا دەچم بۆ دەرەوە". مەرجی <code>if</code> هەمان شت دەکات لە پرۆگرامسازی: بڕیار دەدات لەسەر بنەمای مەرجێک.</p>
<h3>پێکهاتە</h3>
<pre>if (مەرج)
{
    // ئەگەر مەرجەکە ڕاست بێت
}
else
{
    // ئەگەر مەرجەکە درۆ بێت
}</pre>
<ul>
<li>مەرجەکە دەبێت <code>true</code> یان <code>false</code> بێت.</li>
<li>ئەگەر مەرجەکە ڕاست بێت، بلۆکی <code>if</code> جێبەجێ دەبێت.</li>
<li>ئەگینا، بلۆکی <code>else</code> جێبەجێ دەبێت.</li>
</ul>
<p>لە نموونەکەدا تەمەن 16ە؛ چونکە کەمترە لە 18، دەرئەنجام "تۆ منداڵیت"ە.</p>""",
    content_ba="""<p>د ژیانێ دا ب گۆرەی بارودۆخەکێ بریاران ددەین: "گەر باران بباریت، سەربانەکە دبەم؛ ئەگینا دچیمە دەرڤە". مەرجێ <code>if</code> هەمان تیشت دکەت ل بەرنامەسازی دا: بریار ددەت ل سەر بنیاتا مەرجەکێ.</p>
<h3>پێکهاتە</h3>
<pre>if (مەرج)
{
    // گەر مەرج راست بیت
}
else
{
    // گەر مەرج درەو بیت
}</pre>
<ul>
<li>مەرج دبیت <code>true</code> یان <code>false</code> بیت.</li>
<li>گەر مەرج راست بیت، بلۆکا <code>if</code> تێتە کار.</li>
<li>ئەگینا، بلۆکا <code>else</code> تێتە کار.</li>
</ul>
<p>ل نمونیا ئەڤرە دا تەمەن 16ە؛ چونکی کێمترە ژ 18، ئەنجام "تۆ منداڵیت"ە.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int temen = 16;
        // پشکنینی تەمەن
        if (temen >= 18)
        {
            Console.WriteLine("تۆ گەورەیت");
        }
        else
        {
            Console.WriteLine("تۆ منداڵیت");
        }
    }
}""",
    example_output="تۆ منداڵیت",
    quiz_type="choice",
    q_so="فەرمانی if لە بەرنامەسازی چی دەکات؟",
    q_ba="فەرمانێ if ل بەرنامەسازی دا چ دکەت؟",
    opts_so=["مەرجێک دەپشکنێت و بەپێی ئەوە فەرمان جێبەجێ دەکات",
             "لوولەیەک دروست دەکات",
             "گۆڕاوێک دروست دەکات",
             "هیچ"],
    opts_ba=["مەرجەکەکا دپشکنیت و ب گۆرەی وی فەرمان تێتە کار",
             "لوولەکا دروست دکەت",
             "گۆڕەرەکا دروست دکەت",
             "هیچ"],
    correct="1",
))

# Lesson 14 — زنجیرەی else if (Concept 2: predict output)
lessons.append(lesson(
    order=14,
    level_so=LV4_SO, level_ba=LV4_BA,
    title_so="زنجیرەی else if",
    title_ba="زنجیرا else if",
    content_so="""<p>هەندێک جار زیاتر لە دوو بژاردە هەیە، وەک پلەی نمرە: زۆر باش، باش، یان پێویست بە فێربوون. لەم حاڵەتەدا لە زنجیرەی <code>else if</code> بەکاردێنیت.</p>
<h3>پێکهاتە</h3>
<pre>if (مەرجی یەکەم)
{
    ...
}
else if (مەرجی دووەم)
{
    ...
}
else
{
    ...
}</pre>
<ul>
<li>C# لە سەرەوەوە بۆ خوارەوە دەکۆڵێتەوە.</li>
<li>یەکەم مەرجی ڕاست جێبەجێ دەبێت؛ دوای ئەوە لە لوولەکە دەچێتە دەرەوە.</li>
<li>ئەگەر هیچ مەرجێک ڕاست نەبوو، بلۆکی <code>else</code> جێبەجێ دەبێت.</li>
</ul>
<p>لە نموونەکەدا نمرە 85ە؛ لەبەر ئەوەی 85 < 90 بەڵام ≥ 70، "باش" چاپ دەکرێت.</p>""",
    content_ba="""<p>هینەک جاران ژ دوو بژاردان زێدەتر هەیە، وەک پلەیا نمرێ: زۆر باش، باش، یا پێدڤی ب فێربوونێ. ل ڤی حاڵەتێ دا زنجیرا <code>else if</code> بکارتینین.</p>
<h3>پێکهاتە</h3>
<pre>if (مەرجێ یەکێک)
{
    ...
}
else if (مەرجێ دووێ)
{
    ...
}
else
{
    ...
}</pre>
<ul>
<li>C# ژ سەر دا بۆ خوار دا دکۆلیتەوە.</li>
<li>مەرجێ یێ راست یێ دەستپێک تێتە کار؛ پاشی دچیتە دەرڤە.</li>
<li>گەر هیچ مەرجەکەک راست نەبیت، بلۆکا <code>else</code> تێتە کار.</li>
</ul>
<p>ل نمونیا ئەڤرە دا نمرە 85ە؛ لەبەر وی کو 85 < 90 لێ ≥ 70، "باش" تێتە چاپکرن.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int pile = 85;
        // پلەدانان بەپێی نمرە
        if (pile >= 90)
        {
            Console.WriteLine("زۆر باش");
        }
        else if (pile >= 70)
        {
            Console.WriteLine("باش");
        }
        else
        {
            Console.WriteLine("دەستبکەوە بۆ فێربوون");
        }
    }
}""",
    example_output="باش",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>int pile = 95;\nif (pile >= 90) { Console.WriteLine("زۆر باش"); }\nelse if (pile >= 70) { Console.WriteLine("باش"); }\nelse { Console.WriteLine("فێر بە"); }</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>int pile = 95;\nif (pile >= 90) { Console.WriteLine("زۆر باش"); }\nelse if (pile >= 70) { Console.WriteLine("باش"); }\nelse { Console.WriteLine("فێر بە"); }</pre>\nچی دچاپیت؟',
    opts_so=["زۆر باش", "باش", "فێر بە", "هیچ"],
    opts_ba=["زۆر باش", "باش", "فێر بە", "هیچ"],
    correct="1",
))

# Lesson 15 — switch (Concept 3: find the bug)
lessons.append(lesson(
    order=15,
    level_so=LV4_SO, level_ba=LV4_BA,
    title_so="فەرمانی switch",
    title_ba="فەرمانێ switch",
    content_so="""<p>ئەگەر چەندین بژاردەی جیاواز هەبێت بۆ یەک نرخ، بەکارهێنانی زنجیرەیەکی درێژ لە <code>if</code> ئاڵۆز دەبێت. لە جیاتی ئەوە، فەرمانی <code>switch</code> بەکاردێنیت؛ وەک ئەوەی لیستەیەکی خواردن هەبێت و بەپێی ژمارەکە هەڵیبژێریت.</p>
<h3>پێکهاتە</h3>
<pre>switch (نرخ)
{
    case 1:
        // کردار
        break;
    case 2:
        // کردار
        break;
    default:
        // ئەگەر هیچ نەگونجا
        break;
}</pre>
<ul>
<li>هەر <code>case</code> بە نرخەکە دەچێتەوە.</li>
<li>لە کۆتایی هەر بلۆکێک دەبێت <code>break;</code> بەکاربهێنیت.</li>
<li><code>default</code> ئەو کاتە جێبەجێ دەبێت کە هیچ case یەک نەگونجێت.</li>
</ul>
<p>لە نموونەکەدا ژمارەکە 3ە؛ بۆیە "دووشەممە" چاپ دەکرێت.</p>""",
    content_ba="""<p>گەر هندەک بژاردێن جودا هەبن بۆ یەک نرخی، بکارئینانا زنجیرەکەکا درێژ یا <code>if</code> ئالۆز دبیت. ل شوینا وی، فەرمانێ <code>switch</code> بکارتینین؛ وەک ئەوێ لیستەیەک خوارنێ هەبیت و ب گۆرەی ژمارێ هەلبژێری.</p>
<h3>پێکهاتە</h3>
<pre>switch (نرخ)
{
    case 1:
        // کار
        break;
    case 2:
        // کار
        break;
    default:
        // گەر هیچ نەگونجیت
        break;
}</pre>
<ul>
<li>هەر <code>case</code> بە نرخی هەرێ هۆ یە.</li>
<li>ل دەنگەلای هەر بلۆکەکا دا دبیت <code>break;</code> بکاربینیت.</li>
<li><code>default</code> ئەو دەمێ تێتە کار کو هیچ case یەک نەگونجیت.</li>
</ul>
<p>ل نمونیا ئەڤرە دا ژمارە 3ە؛ لەوما "دووشەممە" تێتە چاپکرن.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int roj = 3;
        // دیاریکردنی ناوی ڕۆژ بەپێی ژمارەکەی
        switch (roj)
        {
            case 1:
                Console.WriteLine("شەممە");
                break;
            case 2:
                Console.WriteLine("یەکشەممە");
                break;
            case 3:
                Console.WriteLine("دووشەممە");
                break;
            default:
                Console.WriteLine("ڕۆژی نەناسراو");
                break;
        }
    }
}""",
    example_output="دووشەممە",
    quiz_type="code",
    ch_so='''ئەم پارچە کۆدە دەبێت «شەممە» چاپ بکات کاتێک roj=1، بەڵام کۆمپایل نابێت. هەڵەکە بدۆزەرەوە و کۆدە تەواوە ڕاستکراوەکە بنووسە:
<pre>using System;

class Program
{
    static void Main()
    {
        int roj = 1;
        switch (roj)
        {
            case 1:
                Console.WriteLine("شەممە");
            case 2:
                Console.WriteLine("یەکشەممە");
                break;
        }
    }
}</pre>''',
    ch_ba='''ئەڤ پارچە کۆد دبیت «شەممە» چاپ بکەت دەمێ roj=1، لێ نایەتە کار. شاشلتی بدۆزە و کۆدی ته‌واو یێ راستکرى بنڤیسه:
<pre>using System;

class Program
{
    static void Main()
    {
        int roj = 1;
        switch (roj)
        {
            case 1:
                Console.WriteLine("شەممە");
            case 2:
                Console.WriteLine("یەکشەممە");
                break;
        }
    }
}</pre>''',
    expected="شەممە",
    ans="""using System;

class Program
{
    static void Main()
    {
        int roj = 1;
        // بەکارهێنانی switch بە break
        switch (roj)
        {
            case 1:
                Console.WriteLine("شەممە");
                break;
            case 2:
                Console.WriteLine("یەکشەممە");
                break;
            default:
                Console.WriteLine("ڕۆژی نەناسراو");
                break;
        }
    }
}""",
))

# Lesson 16 — ئۆپەرەیتەری سێلار (Concept 4: write from scratch)
lessons.append(lesson(
    order=16,
    level_so=LV4_SO, level_ba=LV4_BA,
    title_so="ئۆپەرەیتەری سێلار",
    title_ba="ئۆپەرەیتێرێ سێلار",
    content_so="""<p>بۆ بژاردەیەکی سادە لە نێوان دوو شتدا، ئۆپەرەیتەری سێلار <code>?:</code> کورتترین ڕێگایە. وەک ئەوەی بپرسیت: "ئایا ئەمە ڕاستە؟ ئەگەر بەڵێ ئەمە؛ ئەگینا ئەوە".</p>
<h3>پێکهاتە</h3>
<pre>string encam = مەرج ? "ئەگەر ڕاست" : "ئەگەر درۆ";</pre>
<ul>
<li>پێکهاتە: <code>مەرج ? نرخی ڕاست : نرخی درۆ</code>.</li>
<li>هەرگیز بەکاری مەهێنە بۆ مەرجە ئاڵۆزەکان؛ تەنها بۆ بژاردەی سادە.</li>
</ul>
<p>لە نموونەکەدا تەمەن 20ە و گەورەترە لە 18؛ بۆیە "گەورە" چاپ دەکرێت.</p>
<pre>int temen = 20;
string deraj = temen >= 18 ? "گەورە" : "منداڵ";
Console.WriteLine(deraj);</pre>""",
    content_ba="""<p>بۆ بژاردەکەکا سادا د ناڤبەرا دوو تیشتان دا، ئۆپەرەیتێرێ سێلار <code>?:</code> کورترین رێگایە. وەک ئەوێ بپرسیت: "ئەرێ ئەڤە راستە؟ گەر بەلێ ئەڤە؛ ئەگینا ئەوە".</p>
<h3>پێکهاتە</h3>
<pre>string encam = مەرج ? "گەر راست" : "گەر درەو";</pre>
<ul>
<li>پێکهاتە: <code>مەرج ? نرخێ راست : نرخێ درەو</code>.</li>
<li>هەرگاڤ بۆ مەرجێن ئالۆز بکارمەینە؛ تەنها بۆ بژاردەیا سادا.</li>
</ul>
<p>ل نمونیا ئەڤرە دا تەمەن 20ە و مه‌زنترە ژ 18؛ لەوما "گەورە" تێتە چاپکرن.</p>
<pre>int temen = 20;
string deraj = temen >= 18 ? "گەورە" : "منداڵ";
Console.WriteLine(deraj);</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int temen = 20;
        // ئۆپەرەیتەری سێلار: مەرج ? ئەگەر ڕاست : ئەگەر هەڵە
        string deraj = temen >= 18 ? "گەورە" : "منداڵ";
        Console.WriteLine(deraj);
    }
}""",
    example_output="گەورە",
    quiz_type="code",
    ch_so="بە بەکارهێنانی ئۆپەرەیتەری سێلار (? :)، پرۆگرامێکی تەواو بنووسە کە ژمارە 4 بپشکنێت: ئەگەر جووتە «جووت» چاپ بکات، ئەگینا «فرد».",
    ch_ba="ب بکارئینانا ئۆپەرەیتێری سێلار (? :)، پرۆگرامەکەکا ته‌واو بنڤیسه کو ژمارا 4 دپشکنیت: گەر جوته «جووت» چاپ دکەت، ئەگینا «فرد».",
    expected="جووت",
    ans="""using System;

class Program
{
    static void Main()
    {
        int jimara = 4;
        // پشکنینی جووت یان فرد بە ئۆپەرەیتەری سێلار
        string encam = jimara % 2 == 0 ? "جووت" : "فرد";
        Console.WriteLine(encam);
    }
}""",
))

# ---------- Chapter 5: لوولەکان ----------
# Lesson 17 — لوولەی for (Concept 1: standard quiz)
lessons.append(lesson(
    order=17,
    level_so=LV5_SO, level_ba=LV5_BA,
    title_so="لوولەی for",
    title_ba="لوولەیا for",
    content_so="""<p>لوولەکان وەک ئەوە وایە کارێک چەند جار دووبارە بکەیتەوە. وەک ئەوەی بچیتە یانەی وەرزشی هەفتانە: هەر هەفتەیەک هەمان کار جێبەجێ دەکەیت بۆ ماوەیەکی دیاریکراو. لوولەی <code>for</code> زۆرترین جار بۆ کاتێک بەکاردێت کە دەزانیت چەند جار دووبارەکردنەوە دەبێت.</p>
<h3>پێکهاتە</h3>
<pre>for (سەرەتا; مەرج; گۆڕانکاری)
{
    // کۆدە دووبارەکراوەکان
}</pre>
<p>لە نموونەکەدا، <code>i</code> لە 1 دەست پێدەکات، تا <code>i &lt;= 5</code> بەردەوام دەبێت، و هەموو جارێک <code>i++</code> دەبێتەوە. دەرئەنجام: ١، ٢، ٣، ٤، ٥ — هەر یەکەیان لە هێڵێکی جیادا.</p>
<pre>for (int i = 1; i <= 5; i++)
{
    Console.WriteLine(i);
}</pre>""",
    content_ba="""<p>لوولە وەک ئەوێ کارەکا هندەک جاران دووبارە بکەیەوە. وەک ئەوێ هەر هەفتایەک بچییە یانایا وەرزشێ: هەر هەفتایەک هەمان کار دکەی بۆ ماوەکا دیاریکری. لوولەیا <code>for</code> زۆربە جاران بۆ دەمێ کو دزانی چەند جار دووبارەکرن دبیت بکاردهێت.</p>
<h3>پێکهاتە</h3>
<pre>for (دەستپێک; مەرج; گوهۆرین)
{
    // کۆدێن دووبارەکری
}</pre>
<p>ل نمونیا ئەڤرە دا، <code>i</code> ژ 1 دەست پێ دکەت، تا <code>i &lt;= 5</code> دبەردەوامە، و هەر جارەکا <code>i++</code> دبیت. ئەنجام: ١، ٢، ٣، ٤، ٥ — هەر ئێکەک ل رێزەکا جودا دا.</p>
<pre>for (int i = 1; i <= 5; i++)
{
    Console.WriteLine(i);
}</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // لوولەی for بۆ چاپکردنی ١ بۆ ٥
        for (int i = 1; i <= 5; i++)
        {
            Console.WriteLine(i);
        }
    }
}""",
    example_output="1\n2\n3\n4\n5",
    quiz_type="choice",
    q_so="لەم لوولەیەدا: <code>for (int i = 1; i <= 5; i++)</code> — لوولەکە چەند جار جێبەجێ دەبێت؟",
    q_ba="ل ڤی لوولەیی دا: <code>for (int i = 1; i <= 5; i++)</code> — لوولە چەند جاران تێتە کار؟",
    opts_so=["5 جار", "4 جار", "6 جار", "بێ کۆتایی"],
    opts_ba=["5 جاران", "4 جاران", "6 جاران", "بێ دەنگەلای"],
    correct="1",
))

# Lesson 18 — لوولەی while و do-while (Concept 2: predict output)
lessons.append(lesson(
    order=18,
    level_so=LV5_SO, level_ba=LV5_BA,
    title_so="لوولەی while و do-while",
    title_ba="لوولەیا while و do-while",
    content_so="""<p>هەندێک جار نازانیت چەند جار دەبێت کارەکە دووبارە بکەیتەوە؛ تەنها دەزانی کە مەرجێک هەیە. لەم حاڵەتەدا لوولەی <code>while</code> بەکاردێنیت، وەک ئەوەی پێکهاتەکان بخوێنیتەوە تا هەموویان کۆتایی بێت.</p>
<h3>پێکهاتەی while</h3>
<pre>while (مەرج)
{
    // کۆدە دووبارەکراوەکان
}</pre>
<h3>پێکهاتەی do-while</h3>
<pre>do
{
    // کۆدەکە لانیکەم جارێک جێبەجێ دەبێت
} while (مەرج);</pre>
<ul>
<li><code>while</code> — مەرجەکە پێش جێبەجێکردن دەپشکنێت.</li>
<li><code>do-while</code> — کۆدەکە یەکەم جار جێبەجێ دەکات پاشان مەرجەکە دەپشکنێت؛ بۆیە لانیکەم جارێک جێبەجێ دەبێت.</li>
</ul>
<p>لە نموونەکەدا، تا <code>i &lt;= 3</code> نووسراوەکە چاپ دەکرێت و <code>i</code> زیاد دەکات.</p>""",
    content_ba="""<p>هینەک جاران نزانی چەند جار دبیت کارەکا دووبارە بکەیەوە؛ تەنها دزانی مەرجەک هەیە. ل ڤی حاڵەتێ دا لوولەیا <code>while</code> بکارتینین، وەک ئەوێ پێکهاتان بخوینی تا هەمی ب تەواوی ببن.</p>
<h3>پێکهاتەیا while</h3>
<pre>while (مەرج)
{
    // کۆدێن دووبارەکری
}</pre>
<h3>پێکهاتەیا do-while</h3>
<pre>do
{
    // کۆد ب که‌مایەتی جارەکا تێتە کار
} while (مەرج);</pre>
<ul>
<li><code>while</code> — مەرج بەری کارکرنێ دپشکنیت.</li>
<li><code>do-while</code> — کۆد دەستپێک جارەکا تێتە کار پاشی مەرج دپشکنیت؛ لەوما ب که‌مایەتی جارەکا تێتە کار.</li>
</ul>
<p>ل نمونیا ئەڤرە دا، تا <code>i &lt;= 3</code> دەق تێتە چاپکرن و <code>i</code> زێدە دبیت.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        int i = 1;
        // لوولەی while
        while (i <= 3)
        {
            Console.WriteLine("جار: " + i);
            i++;
        }
    }
}""",
    example_output="جار: 1\nجار: 2\nجار: 3",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>int x = 10;\ndo {\n    Console.WriteLine(x);\n    x++;\n} while (x < 5);</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>int x = 10;\ndo {\n    Console.WriteLine(x);\n    x++;\n} while (x < 5);</pre>\nچی دچاپیت؟',
    opts_so=["10", "10، 11، 12 ...", "هیچ", "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["10", "10، 11، 12 ...", "هیچ", "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="1",
))

# Lesson 19 — break و continue (Concept 3: find the bug)
lessons.append(lesson(
    order=19,
    level_so=LV5_SO, level_ba=LV5_BA,
    title_so="break و continue",
    title_ba="break و continue",
    content_so="""<p>لە لوولەکاندا، هەندێک جار دەتەوێت زووتر بووێستیت یان پرش بەسەر دووبارەکردنەوەیەکدا بکەیت. دوو فەرمان هەن بۆ ئەم کارە: <code>break</code> و <code>continue</code>.</p>
<h3>فەرمانەکان</h3>
<ul>
<li><code>break;</code> — لوولەکە یەکسەر دەبڕێت و دەچێتە دەرەوە.</li>
<li><code>continue;</code> — دووبارەکردنەوەی ئێستا فڕێدەدات و دەچێت بۆ دووبارەکردنەوەی داهاتوو.</li>
</ul>
<p>لە نموونەکەدا: ژمارەکانی ٤ و ٥ بە <code>continue</code> پرش دەکەن، و لە ژمارە ٨دا لوولەکە بە <code>break</code> دەبڕدرێت. دەرئەنجام: ١، ٢، ٣، ٦، ٧.</p>
<pre>for (int i = 1; i <= 10; i++)
{
    if (i == 4 || i == 5) continue;
    if (i == 8) break;
    Console.WriteLine(i);
}</pre>""",
    content_ba="""<p>ل لوولان دا، هینەک جاران دڤی زووتر بووەستی یان پەڕی ب سەر دووبارەکرنەکەکا دا کەی. دوو فەرمان هەنە بۆ ڤی کار: <code>break</code> و <code>continue</code>.</p>
<h3>فەرمان</h3>
<ul>
<li><code>break;</code> — لوولە رێکە دبڕیت و دچیتە دەرڤە.</li>
<li><code>continue;</code> — دووبارەکرنا نۆکا ئاڤیتە دەرڤە و دچیت بۆ دووبارەکرنا هاتی.</li>
</ul>
<p>ل نمونیا ئەڤرە دا: ژمارێن ٤ و ٥ ب <code>continue</code> دهێنە پەڕاندن، و ل ژمارا ٨ێ دا لوولە ب <code>break</code> دهێتە برین. ئەنجام: ١، ٢، ٣، ٦، ٧.</p>
<pre>for (int i = 1; i <= 10; i++)
{
    if (i == 4 || i == 5) continue;
    if (i == 8) break;
    Console.WriteLine(i);
}</pre>""",
    code="""using System;

class Program
{
    static void Main()
    {
        for (int i = 1; i <= 10; i++)
        {
            // پرش بەسەر ٤ و ٥
            if (i == 4 || i == 5)
            {
                continue;
            }
            // وەستان لە ٨
            if (i == 8)
            {
                break;
            }
            Console.WriteLine(i);
        }
    }
}""",
    example_output="1\n2\n3\n6\n7",
    quiz_type="code",
    ch_so='''ئەم کۆدە دەبێت ژمارەکانی 1، 2، 4، 5 چاپ بکات (پرش بەسەر 3)، بەڵام بەم شێوەیە دەبێتە 1، 2 و دەوەستێت. هەڵەکە بدۆزەرەوە و چاکی بکە:
<pre>using System;

class Program
{
    static void Main()
    {
        for (int i = 1; i <= 5; i++)
        {
            if (i == 3)
            {
                break;
            }
            Console.WriteLine(i);
        }
    }
}</pre>''',
    ch_ba='''ئەڤ کۆد دبیت ژمارێن 1، 2، 4، 5 چاپ بکەت (پەڕاندنا سەر 3)، لێ ب ڤی شێوەی دبیتە 1، 2 و دەمەستیت. شاشلتی بدۆزە و چاکی بکە:
<pre>using System;

class Program
{
    static void Main()
    {
        for (int i = 1; i <= 5; i++)
        {
            if (i == 3)
            {
                break;
            }
            Console.WriteLine(i);
        }
    }
}</pre>''',
    expected="1\n2\n4\n5",
    ans="""using System;

class Program
{
    static void Main()
    {
        for (int i = 1; i <= 5; i++)
        {
            // پرش بەسەر ژمارە 3 بە continue
            if (i == 3)
            {
                continue;
            }
            Console.WriteLine(i);
        }
    }
}""",
))

# ---------- Chapter 6: فەنکشنەکان ----------
# Lesson 20 — ناساندنی فەنکشن (Concept 4: write from scratch)
lessons.append(lesson(
    order=20,
    level_so=LV6_SO, level_ba=LV6_BA,
    title_so="ناساندنی فەنکشن",
    title_ba="ناساندنا فەنکشنێ",
    content_so="""<p>فەنکشن وەک ئەو شێفە وایە کە کارێک دەکات و دەتوانیت دووبارە بەکاریبهێنیت: هەموو جارێک کە پێویستت بێت بانگی دەکەیت. لە جیاتی نووسینەوەی هەمان کۆد، فەنکشنێک دروست دەکەیت و بانگی دەکەیت.</p>
<h3>دروستکردنی فەنکشن</h3>
<pre>static void NaviFunkshen()
{
    // کۆدەکە
}</pre>
<ul>
<li><code>void</code> — بەو مانایە کە فەنکشنەکە هیچ ناگەڕێنێتەوە.</li>
<li>ناوی فەنکشن بە پیتی گەورە دەست پێدەکات (وەک <code>Silav</code>).</li>
<li>بۆ بانگکردن: <code>Silav();</code></li>
</ul>
<p>لە نموونەکەدا فەنکشنێک دروست دەکەین کە نووسراوەیەک چاپ دەکات و دوو جار بانگی دەکەین.</p>""",
    content_ba="""<p>فەنکشن وەک ئەو شێفە یە کو کارەکەکا دکەت و دتوانی دووبارە بکاربینیت: هەر جارەکا پێدڤی پێ تە بیت بانگی دکەی. ل شوینا نڤیسینا هەمان کۆدی، فەنکشنەکەک دروست دکەی و بانگی دکەی.</p>
<h3>دروستکرنا فەنکشنێ</h3>
<pre>static void NaviFunkshen()
{
    // کۆد
}</pre>
<ul>
<li><code>void</code> — ب وی واتایێ کو فەنکشن هیچ ناگەڕینتەوە.</li>
<li>ناڤێ فەنکشنێ ب تیپەکا مه‌زن دەست پێ دکەت (وەک <code>Silav</code>).</li>
<li>بۆ بانگکرنێ: <code>Silav();</code></li>
</ul>
<p>ل نمونیا ئەڤرە دا فەنکشنەکەک دروست دکەین کو دەقەکا چاپ دکەت و دوو جاران بانگی دکەین.</p>""",
    code="""using System;

class Program
{
    // دروستکردنی فەنکشنێک بەبێ پارامیتەر
    static void Silav()
    {
        Console.WriteLine("سڵاو لە فەنکشنەوە!");
    }

    static void Main()
    {
        // بانگکردنی فەنکشنەکە دوو جار
        Silav();
        Silav();
    }
}""",
    example_output="سڵاو لە فەنکشنەوە!\nسڵاو لە فەنکشنەوە!",
    quiz_type="code",
    ch_so="فەنکشنێک بنووسە بە ناوی Bexerhayat کە نووسراوەی «بەخێربێیت!» چاپ دەکات، پاشان لە Main بانگی بکە. پرۆگرامەکە دەبێت تەواو بێت.",
    ch_ba="فەنکشنەکەکا بنڤیسه ب ناڤی Bexerhayat کو دەقا «بەخێربێیت!» چاپ دکەت، پاشی ل Main بانگی بکە. پرۆگرام دبیت ته‌واو بیت.",
    expected="بەخێربێیت!",
    ans="""using System;

class Program
{
    // فەنکشنێک بۆ چاپکردنی بەخێرهاتن
    static void Bexerhayat()
    {
        Console.WriteLine("بەخێربێیت!");
    }

    static void Main()
    {
        // بانگکردنی فەنکشنەکە
        Bexerhayat();
    }
}""",
))

# Lesson 21 — پارامیتەرەکان (Concept 1: standard quiz)
lessons.append(lesson(
    order=21,
    level_so=LV6_SO, level_ba=LV6_BA,
    title_so="پارامیتەرەکان",
    title_ba="پارامیتەر",
    content_so="""<p>پارامیتەرەکان وەک پێداویستییەکانین بۆ کارێک: هەرکاتێک فەنکشنێک بانگ دەکەیت، دەتوانیت داتای پێ بدەیت تاوەکو لە ناوەوە بەکاریبهێنێت. وەک ئەوەی بۆ ماکۆی خواردن دەقی خواردنەکە بدەیت و دواتر ئەنجامەکە وەربگریت.</p>
<h3>فەنکشن لەگەڵ پارامیتەر</h3>
<pre>static void Naskirin(string nav, int temen)
{
    Console.WriteLine(nav + " تەمەنی " + temen + " ساڵە.");
}</pre>
<ul>
<li>هەر پارامیتەرێک جۆری داتای خۆی هەیە، وەک <code>string</code> و <code>int</code>.</li>
<li>کاتێک بانگ دەکەیت، دەبێت نرخەکان بە هەمان ڕیزبەندی بدەیت.</li>
<li>دەتوانیت هەمان فەنکشن بە نرخە جیاوازەکان بانگ بکەیتەوە.</li>
</ul>
<p>لە نموونەکەدا هەمان فەنکشن بە دوو جۆرە ناوی جیاواز بانگ دەکرێت.</p>""",
    content_ba="""<p>پارامیتەر وەک پێدڤیێن کارەکەکەن: هەر دەمێ فەنکشنەکەک بانگی دکەی، دتوانی دانەیێ بدەیێ داکو د ناڤێ دا بکاربینیت. وەک ئەوێ نڤیسینا خوارنێ بدەی خواردانەگەهێ و پاشی ئەنجامێ وەربگری.</p>
<h3>فەنکشن ب گەل پارامیتەری</h3>
<pre>static void Naskirin(string nav, int temen)
{
    Console.WriteLine(nav + " تەمەنی " + temen + " ساڵە.");
}</pre>
<ul>
<li>هەر پارامیتەرەکەک جورێ دانەیێ خۆ هەیە، وەک <code>string</code> و <code>int</code>.</li>
<li>دەمێ بانگی دکەی، دبیت نرخان ب هەمان ریزبەندی بدەی.</li>
<li>دتوانی هەمان فەنکشن ب نرخێن جودا بانگ کەیەوە.</li>
</ul>
<p>ل نمونیا ئەڤرە دا هەمان فەنکشن ب دوو ناڤێن جودا تێتە بانگکرن.</p>""",
    code="""using System;

class Program
{
    // فەنکشنێک کە پارامیتەر وەردەگرێت
    static void Naskirin(string nav, int temen)
    {
        Console.WriteLine(nav + " تەمەنی " + temen + " ساڵە.");
    }

    static void Main()
    {
        // بانگکردنی فەنکشن بە نرخە جیاوازەکان
        Naskirin("ئاڤا", 21);
        Naskirin("دلوڤان", 25);
    }
}""",
    example_output="ئاڤا تەمەنی 21 ساڵە.\nدلوڤان تەمەنی 25 ساڵە.",
    quiz_type="choice",
    q_so="بۆ هەڵگرتنی ناوی بەکارهێنەر لە فەنکشنێکدا، کام جۆری داتا بۆ پارامیتەرەکە گونجاوە؟",
    q_ba="بۆ هەلگرتنا ناڤێ بکارهینەری ل فەنکشنەکا دا، کیژەک جورێ دانەیێ ژ بۆ پارامیتەری گونجایە؟",
    opts_so=["string", "int", "bool", "double"],
    opts_ba=["string", "int", "bool", "double"],
    correct="1",
))

# Lesson 22 — گەڕانەوە لە فەنکشن (Concept 2: predict output)
lessons.append(lesson(
    order=22,
    level_so=LV6_SO, level_ba=LV6_BA,
    title_so="گەڕانەوە لە فەنکشن",
    title_ba="ڤەگەڕانەوە ژ فەنکشنێ",
    content_so="""<p>هەندێک فەنکشن تەنها کارێک دەکەن، بەڵام هەندێکیان ئەنجامێک دەگەڕێننەوە، وەک ئەوەی لە دووکان بۆ شتەکەکەت بەهایەک بدەیت و دراوی گۆڕاوەکە وەربگریت. فەرمانی <code>return</code> ئەنجامەکە دەگەڕێنێتەوە.</p>
<h3>فەنکشن لەگەڵ گەڕانەوە</h3>
<pre>static int Kokirdineve(int a, int b)
{
    return a + b;
}</pre>
<ul>
<li>جۆری گەڕانەوە لە شوێنی <code>void</code> دەنووسرێت، وەک <code>int</code>.</li>
<li><code>return</code> ئەنجامەکە دەگەڕێنێتەوە و دەبێت هاوکات بێت لەگەڵ جۆری گەڕانەوە.</li>
<li>دەتوانیت ئەنجامەکە بکەیتە گۆڕاو: <code>int encam = Kokirdineve(4, 6);</code></li>
</ul>
<p>لە نموونەکەدا، فەنکشنەکە 4 و 6 کۆ دەکاتەوە و 10 دەگەڕێنێتەوە.</p>""",
    content_ba="""<p>هینەک فەنکشن تەنها کارەکا دکەن، لێ هینەکێن دی ئەنجامەکا دگەڕیننەوە، وەک ئەوێ ل دکانەکە دا بۆ تیشتەکا خۆ بهایەک بدەی و دراڤێ گوهۆری وەربگری. فەرمانێ <code>return</code> ئەنجامەکا دگەڕینتەوە.</p>
<h3>فەنکشن ب گەل ڤەگەڕانەوەی</h3>
<pre>static int Kokirdineve(int a, int b)
{
    return a + b;
}</pre>
<ul>
<li>جورێ ڤەگەڕانەوێ ل شوینا <code>void</code> تێتە نڤیسین، وەک <code>int</code>.</li>
<li><code>return</code> ئەنجامەکا دگەڕینتەوە و دبیت هاوکات بیت ب گەل جورێ ڤەگەڕانەوێ.</li>
<li>دتوانی ئەنجامێ بکەیە گۆڕەر: <code>int encam = Kokirdineve(4, 6);</code></li>
</ul>
<p>ل نمونیا ئەڤرە دا، فەنکشنێ 4 و 6 کۆ دکەت و 10 دگەڕینتەوە.</p>""",
    code="""using System;

class Program
{
    // فەنکشنێک کە کۆکردنەوە دەکات و ئەنجامەکە دەگەڕێنێتەوە
    static int Kokirdineve(int a, int b)
    {
        return a + b;
    }

    static void Main()
    {
        int encam = Kokirdineve(4, 6);
        Console.WriteLine(encam);
    }
}""",
    example_output="10",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>static int Jmar(int x)\n{\n    return x * 2;\n}\n\nConsole.WriteLine(Jmar(5));</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>static int Jmar(int x)\n{\n    return x * 2;\n}\n\nConsole.WriteLine(Jmar(5));</pre>\nچی دچاپیت؟',
    opts_so=["5", "10", "25", "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["5", "10", "25", "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="2",
))

# Lesson 23 — بەرهەڵگرتنی فەنکشن (Concept 3: find the bug)
lessons.append(lesson(
    order=23,
    level_so=LV6_SO, level_ba=LV6_BA,
    title_so="بەرهەڵگرتنی فەنکشن",
    title_ba="زێدەبارگرتنا فەنکشنێ",
    content_so="""<p>لە C# دا دەتوانیت چەند فەنکشن بە هەمان ناو دروست بکەیت بە مەرجێک جۆری پارامیتەرەکان جیاواز بن، ئەمە پێی دەگوترێت <strong>بەرهەڵگرتن (Overloading)</strong>. وەک ئەوەی وشەی «ئاڤا» هەمان ناو بێت بەڵام بۆ کەسێک یان بۆ شەرمەک بەکاربهێنیت.</p>
<h3>نموونە</h3>
<pre>static int Kokirdineve(int a, int b)
{
    return a + b;
}

static double Kokirdineve(double a, double b)
{
    return a + b;
}</pre>
<ul>
<li>C# بەپێی جۆری ئەو نرخانەی کە دەیەیت، فەنکشنە گونجاوەکە هەڵدەبژێرێت.</li>
<li>پارامیتەرەکان دەتوانن جیاواز بن بە ژمارە یان بە جۆر.</li>
<li>بەرهەڵگرتن کۆدەکە خوێندنەوە ئاسانتر دەکات.</li>
</ul>
<p>لە نموونەکەدا، کاتێک دوو <code>int</code> دەدەیت فەنکشنی int دادەبەسترێت، و کاتێک دوو <code>double</code> فەنکشنی double دادەبەسترێت.</p>""",
    content_ba="""<p>د C# دا دتوانی هندەک فەنکشن ب هەمان ناڤ دروست کەی ب مەرجەکا جورێ پارامیتەران جودا بیت، ئەڤە ژەنرێت <strong>زێدەبارگرتن (Overloading)</strong>. وەک ئەوێ وشەیا «ئاڤا» هەمان ناڤ بیت لێ بۆ کەسەکەک یا بۆ شەرمەکەک بکاربیت.</p>
<h3>نمونیا</h3>
<pre>static int Kokirdineve(int a, int b)
{
    return a + b;
}

static double Kokirdineve(double a, double b)
{
    return a + b;
}</pre>
<ul>
<li>C# ب گۆرەی جورێ نرخێن کو ددەی، فەنکشنێ گونجای هەلبژێریت.</li>
<li>پارامیتەر دشێن جودا بن ب ژمارێ یا ب جور.</li>
<li>زێدەبارگرتن کۆد خوەندنەوە ئاسانتەر دکەت.</li>
</ul>
<p>ل نمونیا ئەڤرە دا، دەمێ دوو <code>int</code> ددەی فەنکشنا int تێتە بەستن، و دەمێ دوو <code>double</code> فەنکشنا double تێتە بەستن.</p>""",
    code="""using System;

class Program
{
    // بەرهەڵگرتنی فەنکشن: دوو ژمارەی تەواو
    static int Kokirdineve(int a, int b)
    {
        return a + b;
    }

    // بەرهەڵگرتنی فەنکشن: دوو ژمارەی کەسری
    static double Kokirdineve(double a, double b)
    {
        return a + b;
    }

    static void Main()
    {
        Console.WriteLine(Kokirdineve(3, 4));
        Console.WriteLine(Kokirdineve(1.5, 2.5));
    }
}""",
    example_output="7\n4",
    quiz_type="code",
    ch_so='''ئەم کۆدە دەبێت 10 چاپ بکات بەڵام هەڵەیەکی تێدایە و کۆمپایل نابێت. هەڵەکە بدۆزەرەوە و کۆدە تەواوە ڕاستکراوەکە بنووسە:
<pre>using System;

class Program
{
    static int Zeda(int x)
    {
        x + 1;
    }

    static void Main()
    {
        Console.WriteLine(Zeda(9));
    }
}</pre>''',
    ch_ba='''ئەڤ کۆد دبیت 10 چاپ بکەت لێ شاشلتیک تێدا هەیە و نایەتە کار. شاشلتی بدۆزە و کۆدی ته‌واو یێ راستکرى بنڤیسه:
<pre>using System;

class Program
{
    static int Zeda(int x)
    {
        x + 1;
    }

    static void Main()
    {
        Console.WriteLine(Zeda(9));
    }
}</pre>''',
    expected="10",
    ans="""using System;

class Program
{
    // فەنکشنێک کە ١ زیاد دەکات
    static int Zeda(int x)
    {
        return x + 1;
    }

    static void Main()
    {
        Console.WriteLine(Zeda(9));
    }
}""",
))

# ---------- Chapter 7: ئارای و کۆلیکشن ----------
# Lesson 24 — ئارای (Concept 4: write from scratch)
lessons.append(lesson(
    order=24,
    level_so=LV7_SO, level_ba=LV7_BA,
    title_so="ئارای",
    title_ba="ئارای",
    content_so="""<p>ئارای وەک زنجیرەیەکە لە شوێنی هەڵگرتن بۆ کۆمەڵێک داتا لە یەک گۆڕاودا، وەک تەلاری نیشتەجێبوون کە چەندین ژووری تێدایە و هەر ژوورێک ژمارەیەکی هەیە. لە C# دا، توخمەکانی ئارای بە ئیندێکس (index) دەگەنێدرێن، کە لە <code>0</code> دەست پێدەکات.</p>
<h3>دروستکردن و دەستپێگەیشتن</h3>
<pre>int[] nimerak = { 80, 90, 75, 95 };
Console.WriteLine(nimerak[0]);  // 80
Console.WriteLine(nimerak[3]);  // 95</pre>
<ul>
<li>ئیندێکسی یەکەم توخم هەمیشە <code>0</code>ە.</li>
<li><code>Length</code> ژمارەی توخمەکان دەگەڕێنێتەوە.</li>
<li>ئارای هەرگیز ناتوانرێت زیاد بکرێت؛ بۆ لیستی گۆڕاو، لە بەشی داهاتوو List فێردەبین.</li>
</ul>
<p>لە نموونەکەدا ئارایەک لە 4 نمرە دروست دەکەین؛ یەکەم توخم (80) و چوارەم توخم (95) چاپ دەکرێن، و <code>Length</code> دەکاتە 4.</p>""",
    content_ba="""<p>ئارای وەک زنجیرەکا شوینانە بۆ کومەکەکا دانەیی ل یەک گۆڕەری دا، وەک تەلارەکا نیشتەجێبوونێ کو چەندین جورە و هەر جورەکەک ژمارەکەکا خۆ هەیە. ل C# دا، توخمێن ئارایی ب ئیندێکسی دهێنە گیهاندن، کو ژ <code>0</code> دەست پێ دکەت.</p>
<h3>دروستکرن و گیهانین</h3>
<pre>int[] nimerak = { 80, 90, 75, 95 };
Console.WriteLine(nimerak[0]);  // 80
Console.WriteLine(nimerak[3]);  // 95</pre>
<ul>
<li>ئیندێکسێ توخمێ یێ یەکێ هەرگاڤ <code>0</code>ە.</li>
<li><code>Length</code> ژمارا توخمان دگەڕینتەوە.</li>
<li>ئارای هەرگاڤ ناتێتە زێدەکرن؛ بۆ لیستەکا گوهۆر، د بەشا هاتی دا List دخوانین.</li>
</ul>
<p>ل نمونیا ئەڤرە دا ئارایەکا ژ 4 نمران دروست دکەین؛ توخمێ یێ یەکێ (80) و توخمێ چارێ (95) تێنە چاپکرن، و <code>Length</code> دبیتە 4.</p>""",
    code="""using System;

class Program
{
    static void Main()
    {
        // دروستکردنی ئارایەک لە نمرەکان
        int[] nimerak = { 80, 90, 75, 95 };
        // چاپکردنی یەکەم و چوارەم توخم
        Console.WriteLine(nimerak[0]);
        Console.WriteLine(nimerak[3]);
        // ژمارەی توخمەکان
        Console.WriteLine(nimerak.Length);
    }
}""",
    example_output="80\n95\n4",
    quiz_type="code",
    ch_so="ئارایەک دروست بکە لە سێ ناو: «ئاڤا»، «دلوڤان»، «ئارام»، پاشان دووەم توخمەکە (ئەوەی ئیندێکسی 1) چاپ بکە. پرۆگرامەکە دەبێت تەواو بێت.",
    ch_ba="ئارایەکا دروست بکە ژ سێ ناڤان: «ئاڤا»، «دلوڤان»، «ئارام»، پاشی توخمێ دووێ (ئەو یێ ئیندێکسی 1) چاپ بکە. پرۆگرام دبیت ته‌واو بیت.",
    expected="دلوڤان",
    ans="""using System;

class Program
{
    static void Main()
    {
        // ئارایەک لە ناوەکان
        string[] navan = { "ئاڤا", "دلوڤان", "ئارام" };
        // چاپکردنی دووەم توخم
        Console.WriteLine(navan[1]);
    }
}""",
))

# Lesson 25 — List (Concept 1: standard quiz)
lessons.append(lesson(
    order=25,
    level_so=LV7_SO, level_ba=LV7_BA,
    title_so="لیست (List)",
    title_ba="لیست (List)",
    content_so="""<p>ئارای ناتوانرێت گەورە بکرێت، بەڵام <code>List</code> وەک کیسەیەکیە کە دەتوانیت شتی تێدا زیاد بکەیت و لێی دەربهێنیت. بۆیە زۆرجار List باشترە کاتێک ژمارەی داتاکان نادیارە.</p>
<h3>دروستکردن و زیادکردن</h3>
<pre>List<string> navan = new List<string>();
navan.Add("هەولێر");
navan.Add("سلێمانی");</pre>
<ul>
<li><code>Add()</code> توخمێک زیاد دەکات بۆ کۆتایی لیستەکە.</li>
<li><code>Count</code> ژمارەی توخمەکان دەگەڕێنێتەوە (وەک Length).</li>
<li>دەتوانیت وەک ئارای بە ئیندێکس دەستی پێ بگەیت: <code>navan[1]</code>.</li>
<li>بۆ بەکارهێنان پێویستی بە <code>using System.Collections.Generic;</code> هەیە.</li>
</ul>
<p>لە نموونەکەدا سێ شار زیاد دەکەین؛ ژمارەکە 3ە و دووەم توخم "سلێمانی"یە.</p>""",
    content_ba="""<p>ئارای ناتێتە مه‌زنکرن، لێ <code>List</code> وەک کیسەکەکە کو دتوانی تیشتان د ناڤێ دا زێدە کەی و دەرڤە بینی. لەوما زۆربە جاران List باشترە دەمێ ژمارا دانان نادیار بیت.</p>
<h3>دروستکرن و زێدەکرن</h3>
<pre>List<string> navan = new List<string>();
navan.Add("هەولێر");
navan.Add("سلێمانی");</pre>
<ul>
<li><code>Add()</code> توخمەکەکا زێدە دکەت بۆ دەنگەلا لیستێ.</li>
<li><code>Count</code> ژمارا توخمان دگەڕینتەوە (وەک Length).</li>
<li>دتوانی وەک ئارایی ب ئیندێکسی گیهیی: <code>navan[1]</code>.</li>
<li>بۆ بکارئینانێ پێدڤی ب <code>using System.Collections.Generic;</code> هەیە.</li>
</ul>
<p>ل نمونیا ئەڤرە دا سێ شاران زێدە دکەین؛ ژمارە 3ە و توخمێ دووێ "سلێمانی"یە.</p>""",
    code="""using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        // دروستکردنی لیستێک لە ناوەکان
        List<string> navan = new List<string>();
        navan.Add("هەولێر");
        navan.Add("سلێمانی");
        navan.Add("دهۆک");

        Console.WriteLine(navan.Count);
        Console.WriteLine(navan[1]);
    }
}""",
    example_output="3\nسلێمانی",
    quiz_type="choice",
    q_so="کامە ئەو میتۆدەیە کە توخمێک زیاد دەکات بۆ لیستێک؟",
    q_ba="کیژەک ئەو میتۆدە یا کو توخمەکەکا زێدە دکەت بۆ لیستێ؟",
    opts_so=["Add()", "Push()", "append()", "Insert()"],
    opts_ba=["Add()", "Push()", "append()", "Insert()"],
    correct="1",
))

# Lesson 26 — foreach و Dictionary (Concept 2: predict output)
lessons.append(lesson(
    order=26,
    level_so=LV7_SO, level_ba=LV7_BA,
    title_so="foreach و Dictionary",
    title_ba="foreach و Dictionary",
    content_so="""<p><code>foreach</code> ڕێگایەکی سادەیە بۆ گەڕان بە ناو هەموو توخمەکانی کۆلیکشنێکدا، وەک ئەوەی لە لیستەیەک بەدوای هەموو بڕگەکاندا بگەڕێیت. بەشی نووسینی کۆد کەمترە و ڕوونترە لە <code>for</code>.</p>
<h3>foreach</h3>
<pre>foreach (int j in jmaran)
{
    Console.WriteLine(j);
}</pre>
<p><code>Dictionary</code> وەک فەرهەنگێک وایە: هەر وشەیەک (Key) مانایەکی هەیە (Value). بۆ نموونە، ناوی شار وەک Key و ژمارەی دانیشتووان وەک Value.</p>
<pre>Dictionary<string, int> shwakan = new Dictionary<string, int>();
shwakan["هەولێر"] = 1000000;</pre>
<p>لەگەڵ <code>foreach</code> دەتوانیت بە ناو هەموو تۆمارەکانی فەرهەنگەکەدا بگەڕێیت.</p>""",
    content_ba="""<p><code>foreach</code> رێگایەکا سادا بۆ ڤەگەڕان د ناڤا هەمی توخمێن کۆلکسیونەکا دا، وەک ئەوێ ل لیستەیەک دا پشی هەمی رێزان بگەڕی. نڤیسینا کۆدی کێمترە و ڕوونترە ژ <code>for</code>.</p>
<h3>foreach</h3>
<pre>foreach (int j in jmaran)
{
    Console.WriteLine(j);
}</pre>
<p><code>Dictionary</code> وەک فەرهەنگەکەکە: هەر وشەکەکا (Key) واتایەکا هەیە (Value). بۆ میناک، ناڤێ شاری وەک Key و ژمارا دانیشتوانان وەک Value.</p>
<pre>Dictionary<string, int> shwakan = new Dictionary<string, int>();
shwakan["هەولێر"] = 1000000;</pre>
<p>ب گەل <code>foreach</code> دتوانی د ناڤا هەمی تۆمارێن فەرهەنگی دا بگەڕی.</p>""",
    code="""using System;
using System.Collections.Generic;

class Program
{
    static void Main()
    {
        // دیفتیۆنەری شار و دانیشتووان
        Dictionary<string, int> shwakan = new Dictionary<string, int>();
        shwakan["هەولێر"] = 1000000;
        shwakan["سلێمانی"] = 700000;

        // گەڕان بە ناو هەموو تۆمارەکاندا
        foreach (KeyValuePair<string, int> qeyd in shwakan)
        {
            Console.WriteLine(qeyd.Key + ": " + qeyd.Value);
        }
    }
}""",
    example_output="هەولێر: 1000000\nسلێمانی: 700000",
    quiz_type="choice",
    q_so='سەیری ئەم کۆدە بکە:\n<pre>int[] jmaran = { 10, 20, 30 };\nforeach (int j in jmaran)\n{\n    Console.WriteLine(j);\n}</pre>\nچی دەچاپێت؟',
    q_ba='سەیری ئەڤ کۆدی بکە:\n<pre>int[] jmaran = { 10, 20, 30 };\nforeach (int j in jmaran)\n{\n    Console.WriteLine(j);\n}</pre>\nچی دچاپیت؟',
    opts_so=["10 20 30 لە یەک هێڵدا",
             "10، 20، 30 لە سێ هێڵدا",
             "30 20 10 لە سێ هێڵدا",
             "هەڵەی پێکهاتە (Syntax Error)"],
    opts_ba=["10 20 30 ل رێزەکا یەکێ دا",
             "10، 20، 30 ل سێ رێزان دا",
             "30 20 10 ل سێ رێزان دا",
             "شاشلتی پێکهاتێ (Syntax Error)"],
    correct="2",
))

# ---------- Chapter 8: OOP ----------
# Lesson 27 — کلاس و ئۆبجێکت (Concept 3: find the bug)
lessons.append(lesson(
    order=27,
    level_so=LV8_SO, level_ba=LV8_BA,
    title_so="کلاس و ئۆبجێکت",
    title_ba="کلاس و ئۆبجێکت",
    content_so="""<p><strong>OOP</strong> (بەرنامەسازی پڕۆژەئامێز) وەک دروستکردنی قاڵبێک وایە: کلاسەکە وەک قاڵبە و ئۆبجێکتەکان وەک شتەکانن کە لەو قاڵبەوە دروست دەکرێن. وەک ئەوەی قاڵبێکی کێک هەبێت و چەندین کێکی لێ دروست بکەیت.</p>
<h3>دروستکردنی کلاس</h3>
<pre>class Merov
{
    public string nav;
    public int temen;
}</pre>
<p>بۆ دروستکردنی ئۆبجێکتێک لە کلاسەکە، وشەی <code>new</code> بەکاردێنیت:</p>
<pre>Merov kesek = new Merov();
kesek.nav = "ئاڤا";</pre>
<ul>
<li><code>public</code> بەو مانایە کە دەکرێت لە دەرەوەی کلاسەکەوە دەستی پێ بگەیت.</li>
<li>خانەکان (Fields) داتای ئۆبجێکتەکە هەڵدەگرن.</li>
<li>دەتوانیت چەندین ئۆبجێکت لە یەک کلاسەوە دروست بکەیت.</li>
</ul>""",
    content_ba="""<p><strong>OOP</strong> (بەرنامەسازیا پروژەیینەر) وەک دروستکرنا قالبەکەکە: کلاس وەک قالبە و ئۆبجێکت وەک تیشتێن کو ژ وی قالبی ڤە دهێنە دروستکرن. وەک ئەوێ قالبەکەکا کەیگێ هەبیت و چەندین کەیگ ژێ دروست کەی.</p>
<h3>دروستکرنا کلاسێ</h3>
<pre>class Merov
{
    public string nav;
    public int temen;
}</pre>
<p>بۆ دروستکرنا ئۆبجێکتەکەکا ژ کلاسێ، وشەیا <code>new</code> بکارتینین:</p>
<pre>Merov kesek = new Merov();
kesek.nav = "ئاڤا";</pre>
<ul>
<li><code>public</code> ب وی واتایێ کو دشێت ژ دەرڤەی کلاسێ ڤە گهیهیی.</li>
<li>خانە (Fields) دانەیێن ئۆبجێکتەکا هەلگرن.</li>
<li>دتوانی چەندین ئۆبجێکت ژ یەک کلاسە ڤە دروست کەی.</li>
</ul>""",
    code="""using System;

class Merov
{
    // خانەکانی کلاس
    public string nav;
    public int temen;
}

class Program
{
    static void Main()
    {
        // دروستکردنی ئۆبجێکتێک لە کلاسەکە
        Merov kesek = new Merov();
        kesek.nav = "ئاڤا";
        kesek.temen = 21;

        Console.WriteLine(kesek.nav);
        Console.WriteLine(kesek.temen);
    }
}""",
    example_output="ئاڤا\n21",
    quiz_type="code",
    ch_so='''ئەم کۆدە دەبێت ئۆبجێکتێک لە کلاسی Merov دروست بکات بەڵام هەڵەیەکی تێدایە و کۆمپایل نابێت. هەڵەکە بدۆزەرەوە و کۆدە تەواوە ڕاستکراوەکە بنووسە تاوەکو «ئاڤا - 21» چاپ بکات:
<pre>using System;

class Merov
{
    public string nav;
    public int temen;
}

class Program
{
    static void Main()
    {
        Merov kesek = Merov();
        kesek.nav = "ئاڤا";
        kesek.temen = 21;
        Console.WriteLine(kesek.nav + " - " + kesek.temen);
    }
}</pre>''',
    ch_ba='''ئەڤ کۆد دبیت ئۆبجێکتەکا ژ کلاسا Merov دروست بکەت لێ شاشلتیک تێدا هەیە و نایەتە کار. شاشلتی بدۆزە و کۆدی ته‌واو یێ راستکرى بنڤیسه داکو «ئاڤا - 21» چاپ بکەت:
<pre>using System;

class Merov
{
    public string nav;
    public int temen;
}

class Program
{
    static void Main()
    {
        Merov kesek = Merov();
        kesek.nav = "ئاڤا";
        kesek.temen = 21;
        Console.WriteLine(kesek.nav + " - " + kesek.temen);
    }
}</pre>''',
    expected="ئاڤا - 21",
    ans="""using System;

class Merov
{
    public string nav;
    public int temen;
}

class Program
{
    static void Main()
    {
        // دروستکردنی ئۆبجێکت بە وشەی new
        Merov kesek = new Merov();
        kesek.nav = "ئاڤا";
        kesek.temen = 21;
        Console.WriteLine(kesek.nav + " - " + kesek.temen);
    }
}""",
))

# Lesson 28 — کۆنستراکتەر (Concept 4: write from scratch)
lessons.append(lesson(
    order=28,
    level_so=LV8_SO, level_ba=LV8_BA,
    title_so="کۆنستراکتەر",
    title_ba="کۆنستراکتەر",
    content_so="""<p>کۆنستراکتەر (Constructor) میتۆدێکی تایبەتە کە ڕاستەوخۆ کاتێک ئۆبجێکتێک دروست دەکەیت جێبەجێ دەبێت. وەک ئەوەی لە کارگەدا ئۆتۆمبێلێک پێکهاتە سەرەکییەکانی پێشتر تێدا دانرابن؛ ناوی کۆنستراکتەر هەمان ناوی کلاسەکەیە.</p>
<h3>دروستکردنی کۆنستراکتەر</h3>
<pre>class Xwendekar
{
    public string nav;

    public Xwendekar(string n)
    {
        nav = n;
    }
}</pre>
<ul>
<li>ناوی کۆنستراکتەر بەتەواوی هەمان ناوی کلاسەکەیە.</li>
<li>هیچ جۆری گەڕانەوەی هەیە نییە (تەنانەت void نا).</li>
<li>کاتێک بە <code>new</code> بانگ دەکەیت، کۆنستراکتەرەکە بە شێوەیەکی ئۆتۆماتیکی جێبەجێ دەبێت.</li>
<li>دەتوانیت نرخە سەرەتایییەکان بە پارامیتەر بدەیت.</li>
</ul>
<p>لە نموونەکەدا کۆنستراکتەر ناوی بەکارهێنەر وەردەگرێت و دەیخاتە خانەی nav.</p>""",
    content_ba="""<p>کۆنستراکتەر میتۆدەکەکا تایبەتە کو رێکە دەمێ ئۆبجێکتەکا دروست دکەی تێتە کار. وەک ئەوێ د کارگەها دا ئۆتۆموبیلەکا پێکهاتێن سەرەکی بەری تێدا هاتینە دانان؛ ناڤێ کۆنستراکتەری هەمان ناڤێ کلاسێ یە.</p>
<h3>دروستکرنا کۆنستراکتەری</h3>
<pre>class Xwendekar
{
    public string nav;

    public Xwendekar(string n)
    {
        nav = n;
    }
}</pre>
<ul>
<li>ناڤێ کۆنستراکتەری رێکا ته‌واو هەمان ناڤێ کلاسێ یە.</li>
<li>هیچ جورێ ڤەگەڕانەوەی نینە (تە ب void ژی نا).</li>
<li>دەمێ ب <code>new</code> بانگی دکەی، کۆنستراکتەر ب شێوەیەکا ئۆتوماتیک تێتە کار.</li>
<li>دتوانی نرخێن دەستپێکێ ب پارامیتەری بدەی.</li>
</ul>
<p>ل نمونیا ئەڤرە دا کۆنستراکتەر ناڤێ بکارهینەری وەردگرت و دکەتە خانەیا nav.</p>""",
    code="""using System;

class Xwendekar
{
    public string nav;

    // کۆنستراکتەر
    public Xwendekar(string n)
    {
        nav = n;
    }
}

class Program
{
    static void Main()
    {
        // دروستکردنی ئۆبجێکتێک بە کۆنستراکتەر
        Xwendekar kesek = new Xwendekar("ئاڤا");
        Console.WriteLine(kesek.nav);
    }
}""",
    example_output="ئاڤا",
    quiz_type="code",
    ch_so="کلاسێک بنووسە بە ناوی Ktib کە خانەیەکی string بە ناوی nav هەبێت و کۆنستراکتەرێک کە nav وەردەگرێت، پاشان لە Main ئۆبجێکتێک بە «فەرگا» دروست بکە و nav چاپ بکە. پرۆگرامەکە دەبێت تەواو بێت.",
    ch_ba="کلاسەکەکا بنڤیسه ب ناڤی Ktib کو خانەکا string ب ناڤی nav هەبیت و کۆنستراکتەرەکا کو nav وەردگرت، پاشی ل Main ئۆبجێکتەکا ب «فەرگا» دروست بکە و nav چاپ بکە. پرۆگرام دبیت ته‌واو بیت.",
    expected="فەرگا",
    ans="""using System;

class Ktib
{
    public string nav;

    // کۆنستراکتەر
    public Ktib(string n)
    {
        nav = n;
    }
}

class Program
{
    static void Main()
    {
        Ktib ktib = new Ktib("فەرگا");
        Console.WriteLine(ktib.nav);
    }
}""",
))

# Lesson 29 — میراتگری و پۆلیمۆرفیزم (Concept 1: standard quiz)
lessons.append(lesson(
    order=29,
    level_so=LV8_SO, level_ba=LV8_BA,
    title_so="میراتگری و پۆلیمۆرفیزم",
    title_ba="میراتی و پۆلیمۆرفیزم",
    content_so="""<p><strong>کۆنستراکتەر</strong> میتۆدێکی تایبەتە کە کاتێک ئۆبجێکتێک دروست دەکەیت ڕاستەوخۆ جێبەجێ دەبێت، وەک ئەوەی لە کاتی دروستکردنی ئۆتۆمبێلێکدا پێکهاتە سەرەکییەکانی تێدا دانرابن. <strong>میراتگری (Inheritance)</strong> یش وەک ئەوەیە منداڵ تایبەتمەندییەکانی باوکی بۆ بگوازرێتەوە.</p>
<h3>کۆنستراکتەر</h3>
<pre>public Ajal(string n)
{
    nav = n;
}</pre>
<h3>میراتگری</h3>
<pre>class Seg : Ajal
{
    ...
}</pre>
<ul>
<li>کلاسی کوڕ (Seg) هەموو خانە و میتۆدەکانی کلاسی باوک (Ajal) بە میرات وەردەگرێت.</li>
<li><code>base(n)</code> کۆنستراکتەری کلاسی باوک بانگ دەکات.</li>
<li><code>virtual</code> و <code>override</code> ڕێگە دەدەن کلاسی کوڕ میتۆدەکانی باوک سەرلەنوێ بنووسێتەوە (پۆلیمۆرفیزم).</li>
</ul>
<p>لە نموونەکەدا، کلاسی <code>Seg</code> دەنگی باوکی ناهێڵیت و «هاو هاو» چاپ دەکات.</p>""",
    content_ba="""<p><strong>کۆنستراکتەر</strong> میتۆدەکەکا تایبەتە کو دەمێ ئۆبجێکتەکا دروست دکەی رێکە تێتە کار، وەک ئەوێ د دەمێ دروستکرنا ئۆتۆموبیلەکە دا پێکهاتێن سەرەکی تێدا هاتینە دانان. <strong>میراتی (Inheritance)</strong> ژی وەک ئەوێە زارۆک تایبەتمەندیێن باوکی بۆ بگەهینت.</p>
<h3>کۆنستراکتەر</h3>
<pre>public Ajal(string n)
{
    nav = n;
}</pre>
<h3>میراتی</h3>
<pre>class Seg : Ajal
{
    ...
}</pre>
<ul>
<li>کلاسا زارۆک (Seg) هەمی خانە و میتۆدێن کلاسا باوک (Ajal) ب میراتی وەردگرت.</li>
<li><code>base(n)</code> کۆنستراکتەرێ کلاسا باوک بانگ دکەت.</li>
<li><code>virtual</code> و <code>override</code> رێگە ددەن کلاسا زارۆک میتۆدێن باوک ژ نوی بنڤیسیت (پۆلیمۆرفیزم).</li>
</ul>
<p>ل نمونیا ئەڤرە دا، کلاسا <code>Seg</code> دەنگێ باوکی ناهێلیت و «هاو هاو» چاپ دکەت.</p>""",
    code="""using System;

class Ajal
{
    public string nav;

    // کۆنستراکتەر
    public Ajal(string n)
    {
        nav = n;
    }

    // ئەم میتۆدە دەتوانرێت لە کلاسی کوڕدا سەرلەنوێ بنووسرێت
    public virtual void Deng()
    {
        Console.WriteLine("دەنگی گیانلەبەرەکە");
    }
}

class Seg : Ajal
{
    // کۆنستراکتەری کلاسی کوڕ
    public Seg(string n) : base(n) { }

    // سەرلەنوێ نووسینەوەی میتۆدی باوک
    public override void Deng()
    {
        Console.WriteLine("هاو هاو");
    }
}

class Program
{
    static void Main()
    {
        Seg seg = new Seg("رەش");
        Console.WriteLine(seg.nav);
        seg.Deng();
    }
}""",
    example_output="رەش\nهاو هاو",
    quiz_type="choice",
    q_so="لە میراتگریدا، کامە لەم بڕگانە ڕاستە؟",
    q_ba="د میراتی دا، کیژەک ل ڤان بڕگان راستە؟",
    opts_so=["کلاسی کوڕ (وەک Seg) خانە و میتۆدەکانی کلاسی باوک بە میرات وەردەگرێت",
             "کلاسی باوک لە کلاسی کوڕەوە دروست دەبێت",
             "میراتگری لە C# دا پشتگیری ناکرێت",
             "هیچ"],
    opts_ba=["کلاسا زارۆک (وەک Seg) خانە و میتۆدێن کلاسا باوک ب میراتی وەردگرت",
             "کلاسا باوک ژ کلاسا زارۆک ڤە دێتە دروستکرن",
             "میراتی ل C# دا پشتگری نابیت",
             "هیچ"],
    correct="1",
))

# [[LESSON_DEFS_END]]

with open("/home/donk/kurd-ai-platform/storage/curriculum/csharp.json", "w", encoding="utf-8") as f:
    json.dump(lessons, f, ensure_ascii=False, indent=2)

print("Total lessons:", len(lessons))
