<?php

namespace Database\Seeders;

use App\Models\FergaCourse;
use App\Models\FergaLesson;
use Illuminate\Database\Seeder;

/**
 * Seeds the ten sequential AI courses of the فێرگە path, exactly in the
 * requested chronological order, bilingually (سۆرانی + بادینی).
 *
 * Idempotent: keyed on `position` — re-running updates titles/statuses
 * instead of duplicating. Sample lessons are attached to courses 1 and 2
 * so the locking + runner flow is testable out of the box.
 */
class FergaLearningSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->courses() as $index => $c) {
            $course = FergaCourse::updateOrCreate(
                ['position' => $index + 1],
                [
                    'title_so' => $c['title_so'],
                    'title_ba' => $c['title_ba'],
                    'desc_so' => $c['desc_so'],
                    'desc_ba' => $c['desc_ba'],
                    'icon' => $c['icon'],
                    'accent' => $c['accent'],
                    'status' => $c['status'],
                ]
            );

             foreach ($c['lessons'] ?? [] as $li => $lesson) {
                FergaLesson::updateOrCreate(
                    ['ferga_course_id' => $course->id, 'position' => $li + 1],
                    [
                        'title_so' => $lesson['title_so'],
                        'title_ba' => $lesson['title_ba'],
                        'content_so' => $lesson['content_so'] ?? null,
                        'content_ba' => $lesson['content_ba'] ?? null,
                        'code_language' => 'python',
                        'starter_code' => $lesson['starter'] ?? null,
                        'media' => $lesson['media'] ?? null,
                    ]
                );
            }
        }
    }

    /* ------------------------------------------------------------------ */

    private function courses(): array
    {
        return [
            [
                'title_so' => 'بنەماکان و فەلسەفەی ژیریی دەستکرد',
                'title_ba' => 'بنەمایێن بنەڕەتی و فەلسەفەیا ژیرییا دەستکرد',
                'desc_so' => 'ژیریی دەستکرد چییە؟ لە کووەوە دەستی پێکرد و بۆ کوردەوارێ بە گرنگە؟ لەم کۆرسەدا بنەماکان، مێژوو و فەلسەفەکەی فێر دەبین.',
                'desc_ba' => 'ژیرییا دەستکرد چیه؟ ماڕاڤە دێستپێکری و بۆ کوردستانی گرنگە؟ ڤێ کورسێ بنەمایێن، مێژوویێ و فەلسەفێ ڤێ فێر ددەت.',
                'icon' => '🧠', 'accent' => 'cyan', 'status' => 'active',
                'lessons' => [
                    [
                        'title_so' => 'ژیریی دەستکرد چییە؟',
                        'title_ba' => 'ژیرییا دەستکرد چیه؟',
                        'content_so' => '<h3>پێناسە</h3><p>ژیریی دەستکرد (AI) بریتییە لە توانای ئامێرەکان بۆ ئەنجامدانی ئەو کارانەی کە پێویستیان بە زیرەکی مرۆیی هەیە — وەک فێربوون، تێگەیشتن، لێکدانەوە و بڕیاردان.</p><h3>جۆرەکانی AI</h3><p><strong>AIی لاواز</strong> تەنها یەک ئەرک دەکات (وەک ناسینەوەی دەم و ڕوو)، بەڵام <strong>AIی گشتی (AGI)</strong> هێشتا خەونی مرۆڤە و هەموو ئەرکێکی زیرەکانە دەتوانێت ئەنجام بدات.</p><h3>بۆچی ئێستا؟</h3><p>سێ هۆکاری سەرەکی بوونی شۆڕشی ئەمڕۆ: <em>داتای زۆر</em>، <em>هێزای کۆمپیوتەری گەورە</em> و <em>ئەلگۆریتمە باشترەکان</em>.</p>',
                        'content_ba' => '<h3>پێناسە</h3><p>ژیرییا دەستکرد (AI) هاتیه زانینا ماشینێن بخەت ئەرکێن ژیر ب ئەنجامبینێ، وەک فێربوون، تێگەهشتن، شرونڤەدان و بڕیاردان.</p><h3>جۆرێن AI</h3><p><strong>AI یا زەیف</strong> تنێ ئەرکەکێ دکەت (وەک ناسینا دەم و ڕوویێ)، لگەلێ <strong>AGI</strong> هێشتا خەلە مرۆڤیە و هەمی ئەرکێن ژیر شایا ئەنجامبیت.</p><h3>بۆچی ئێستا؟</h3><p>سێ هوکاری سەرەکی: <em>زێدەبونا داتایێ</em>، <em>هێزا کۆمپیوتەری گەورە</em> و <em>ئەلگۆریتمێن چێتیر</em>.</p>',
                    ],
                    [
                        'title_so' => 'یەکەم کۆدی پایتۆن — بەخێربێی!',
                        'title_ba' => 'یێکێم کۆدا پایتۆن — بەخێرڤە!',
                        'content_so' => '<h3>با دەست پێ بکەین!</h3><p>لە فێرگەدا هەموو وانەکان کۆدێکی کارپێکراویان هەیە — دەتوانی دەستکاری بکەیت و <strong>بیکەی بە کار</strong> بەبێ جێهێشتبنی پەڕەکە.</p><pre data-lang="python" data-run="1">ناو = "هاوڕێی کورد"
print("بەخێربێی بۆ فێرگەی کورد ئەی ئای،", ناو)</pre><p>فەرمانی <code>print()</code> دەق لەسەر mànە نمایش دەکات. ئێستا ناوەکە بگۆڕە و دووبارە بیکاری بکەوە!</p>',
                        'content_ba' => '<h3>با دەست پێ بکەن!</h3><p>د فێرگەها هەمی وانەیێن کۆدی کارپێکری هەڤین — شایا دەستکاری بکە و <strong>بکارخە</strong> ب لیڤدانا پەلەپەڕکێ.</p><pre data-lang="python" data-run="1">ناو = "هەڤاڵێ کورد"
print("بەخێرڤە بۆ فێرگەها کورد ئەی ئای،", ناو)</pre><p>فرمانا <code>print()</code> دەق سەر ئەکرانێ دنیشتینن. ئێستا ناوێ بگوهۆر و دوڤارا بکارخە!</p>',
                        'starter' => '# ناوەکە بگۆڕە و دووبارە بیکاری بکەوە\nناو = "هاوڕێی کورد"\nprint("بەخێربێی،", ناو)\n\n# ژمارەیەک دوو ئەوەندە بکە\nژمارە = 21\nprint(ژمارە * 2)',
                    ],
                    [
                        'title_so' => 'فەلسەفە و ڕەوشی ئەخلاقی AI',
                        'title_ba' => 'فەلسەفە و حاڵەتا ئەخلاقی یا AI',
                        'content_so' => '<h3>پرسیاری گەورە</h3><p>ئایا ئامێر دەتوانێت «بیر بکاتەوە»؟ تاقیکردنەوەی تورینگ، ژووری چینی و بیری سیستەمی — هەموویان هەوڵێکن بۆ وەڵامدانەوەی ئەم پرسیارە.</p><h3>ئەخلاق</h3><p>AI دەبێت <em>ادارە بێت</em>، <em>دلالەتەوەی</em> نەبێت و مافەکان ڕێز لێبگرن. لە کوردەواردا گرنگە زمان و کولتووری کوردی لە مۆدێلەکاندا بەشدار بێت.</p>',
                        'content_ba' => '<h3>پرسە گەورە</h3><p>ماڕاڤە ماشین شایا «بیر بکەت»؟ تاقیکرنا تورینگ، ژوورا چینی و بیریا سیستەمی — هەمی هوڵن ب بەرسڤدانا ڤێ پرسێ.</p><h3>ئەخلاق</h3><p>AI دبیت <em>دروست بیت</em>، <em>پێشینەی</em> نەبیت و مافان ڕێز بگرن. د کوردستانی گرنگە زمان و کولتوورێ کوردی د مۆدێلاندا بەشدار بیت.</p>',
                    ],
                ],
            ],
            [
                'title_so' => 'ئامرازەکانی شیکاری داتا — NumPy, Pandas, Matplotlib',
                'title_ba' => 'ئامرازێن شیکارنا داتایێ — NumPy, Pandas, Matplotlib',
                'desc_so' => 'سێ ئامرازی سەرەکیی هەر شیکارکارێکی داتا: NumPy بۆ ژماردنی خێرا، Pandas بۆ ڕێکخستنی داتا و Matplotlib بۆ وێنەکێشان.',
                'desc_ba' => 'سێ ئامرازێن سەرەکی هەر شیکارکارێ داتایێ: NumPy بۆ حیسابا خرا، Pandas بۆ ڕێکخستنا داتایێ و Matplotlib بۆ وێنەکشافن.',
                'icon' => '🧰', 'accent' => 'blue', 'status' => 'active',
                'lessons' => [
                    [
                        'title_so' => 'NumPy — ڕیزەکان (Arrays)',
                        'title_ba' => 'NumPy — ڕەزێن (Arrays)',
                        'content_so' => '<h3>بۆچی NumPy؟</h3><p>لیستە ئاساییەکانی پایتۆن خاوەکن بۆ ژماردنی زانستی. NumPy ڕیزە (array) تایبەت بەکاردەهێنێت کە ١٠٠ ئەوەندە خێراترە.</p><pre data-lang="python" data-run="1">import numpy as np\n\n# دروستکردنی ڕیزە\nژمارەکان = np.array([10, 20, 30, 40, 50])\nprint("ڕیزە:", ژمارەکان)\nprint("دوو ئەوەندە:", ژمارەکان * 2)\nprint("تێکڕا:", ژمارەکان.mean())</pre><p>تێبینی بکە: کردارەکان بە یەکجار لەسەر <strong>هەموو</strong> توخمەکان جێبەجێ دەبن — ئەمە «ڤێکتۆرکردن»ە.</p>',
                        'content_ba' => '<h3>بۆچی NumPy؟</h3><p>لیستێن ئاساییێن پایتۆنی زەیفن بۆ حیسابێ زانستی. NumPy ڕەزەکێ تایبەت دکارئینە ١٠٠ جاران خراترە.</p><pre data-lang="python" data-run="1">import numpy as np\n\nژمارێ = np.array([10, 20, 30, 40, 50])\nprint("ڕەزە:", ژمارێ)\nprint("دو دووانی:", ژمارێ * 2)\nprint("نڤێندی:", ژمارێ.mean())</pre><p>تێبینی بکە: کرار ل سەر <strong>هەمی</strong> توخمان یێکێ دجرا دکەت — ڤێما «ڤێکتۆرکرن»ە.</p>',
                        'starter' => 'import numpy as np\n\n# ڕیزەیەک دروست بکە و کاری لەسەر بکە\na = np.array([1, 2, 3, 4, 5])\nprint("کۆ:", a.sum())\nprint("گەورەترین:", a.max())\n\n# ڕیزەی دوو ڕەهەندی\nm = np.array([[1, 2], [3, 4]])\nprint(m @ m)  # لێکدانەوەی ماتریکس',
                    ],
                    [
                        'title_so' => 'Pandas — داتا فرەیم',
                        'title_ba' => 'Pandas — داتا فرەیم',
                        'content_so' => '<h3>وەک ئێکسڵ، بەڵام بە کۆد</h3><p>Pandas خشتەی داتا (DataFrame) پێشکەش دەکات — هەمان شێوەی ئێکسڵ بەڵام بە هێزی پایتۆن.</p><pre data-lang="python" data-run="1">import pandas as pd\n\nخشتە = pd.DataFrame({\n    "ناو": ["ئاسۆ", "دیانا", "هێڤیدار"],\n    "تەمەن": [22, 19, 25],\n    "پلە": [88, 95, 79]\n})\nprint(خشتە)\nprint("\\n--- تێکڕای پلەکان ---")\nprint(خشتە["پلە"].mean())</pre>',
                        'content_ba' => '<h3>وەک ئێکسڵ، بەلەڤ ب کۆدی</h3><p>Pandas خشتەیا داتایێ (DataFrame) پێشکەش دکەت — هەڤ شێوەز ئێکسڵی بەلەڤ ب هێزا پایتۆنی.</p><pre data-lang="python" data-run="1">import pandas as pd\n\nخشتە = pd.DataFrame({\n    "ناو": ["ئاسۆ", "دیانا", "هێڤیدار"],\n    "تەمەن": [22, 19, 25],\n    "پلە": [88, 95, 79]\n})\nprint(خشتە)\nprint("\\n--- نڤێندیا پلەیان ---")\nprint(خشتە["پلە"].mean())</pre>',
                        'starter' => 'import pandas as pd\n\n# خشتەیەک دروست بکە، فلتەر بکە و ڕیز بکە\ndf = pd.DataFrame({\n    "شار": ["هەولێر", "دهۆک", "سلێمانی", "کەرکوک"],\n    "ژمارەی دانیشتووان": [1500000, 600000, 900000, 1300000]\n})\nprint(df.sort_values("ژمارەی دانیشتووان", ascending=False))',
                    ],
                    [
                        'title_so' => 'Matplotlib — یەکەم هێڵکاری',
                        'title_ba' => 'Matplotlib — یێکێم هێڵکاری',
                        'content_so' => '<h3>وێنە لە داتا</h3><p>هێڵکاری بنەمای هەر شیکارییەکە. کۆدەکە بیکار بخە — وێنەکە ڕاستەوخۆ لە چوارچێوەکەدا دەردەکەوێت!</p><pre data-lang="python" data-run="1">import numpy as np\nimport matplotlib.pyplot as plt\n\nx = np.linspace(0, 10, 100)\nplt.figure(figsize=(6, 3))\nplt.plot(x, np.sin(x), label="سینوس")\nplt.plot(x, np.cos(x), label="کۆسینوس")\nplt.title("شەپۆلەکان")\nplt.legend()\nplt.show()</pre>',
                        'content_ba' => '<h3>وێنە ژ داتایێ</h3><p>هێڵکاری بنەما هەر شیکارەکێ یە. کۆدێ بکارخە — وێنە ڕاستەوخۆ د چوارچێڤەها درخیت!</p><pre data-lang="python" data-run="1">import numpy as np\nimport matplotlib.pyplot as plt\n\nx = np.linspace(0, 10, 100)\nplt.figure(figsize=(6, 3))\nplt.plot(x, np.sin(x), label="سینوس")\nplt.plot(x, np.cos(x), label="کۆسینوس")\nplt.title("شەپۆلێ")\nplt.legend()\nplt.show()</pre>',
                        'starter' => 'import numpy as np\nimport matplotlib.pyplot as plt\n\n# هێڵکاری گەشەی ژمارەیەک بکێشە\nx = np.arange(1, 8)\ny = x ** 2\nplt.figure(figsize=(6, 3))\nplt.bar(x, y, color="#22d3ee")\nplt.title("چوارگۆشەی ژمارەکان")\nplt.show()',
                    ],
                ],
            ],
            [
                'title_so' => 'ئامار و بیرکاری بۆ ژیریی دەستکرد',
                'title_ba' => 'ئامار و بیرکاری بۆ ژیرییا دەستکرد',
                'desc_so' => 'ئەڵگۆریتمەکان بیرکاری بن — لێرەدا ئاماری وەسفی، خەتەری و ئەگەر، جەبرێ هێڵی و کۆمەڵە فێر دەبین.',
                'desc_ba' => 'ئەلگۆریتمێن بیرکاری بن — لێرێ ئامارا وەسفی، خەتەری و ئەگەری، جەبرا هێڵی و کۆمەلێ فێر دبن.',
                'icon' => '📐', 'accent' => 'purple', 'status' => 'active',
            ],
            [
                'title_so' => 'زانستی داتا',
                'title_ba' => 'زانستی داتایێ',
                'desc_so' => 'خولیای تەواوی کارکردن لەگەڵ داتا: کۆکردنەوە، پاککردنەوە، شیکردنەوە و پێشکەشکردنی داتا بۆ بڕیاردان.',
                'desc_ba' => 'خولیای تەواوی کارکرن لگەلێ داتایێ: کۆکردن، پاککرن، شیکرن و پێشکەشکرنا داتایێ بۆ بڕیاردان.',
                'icon' => '🔬', 'accent' => 'pink', 'status' => 'active',
            ],
            [
                'title_so' => 'ئەلگۆریتمەکان و چارەسەرکردنی کێشە',
                'title_ba' => 'ئەلگۆریتمێن و چارەسەرکرنا کێشەیێ',
                'desc_so' => 'بیری ئەلگۆریتمی، ئاڵۆزی (complexity) و پێکهاتەکانی داتا — بناغەی هەر ئەنجمێکی باش.',
                'desc_ba' => 'بیری ئەلگۆریتمی، ئاڵۆزی (complexity) و پێکهاتێن داتایێ — بنەما هەر ئەنجامەکێ چێت.',
                'icon' => '🧩', 'accent' => 'amber', 'status' => 'active',
            ],
            [
                'title_so' => 'فێربوونی ئامێر (Machine Learning)',
                'title_ba' => 'فێربوونا ماشینێ (Machine Learning)',
                'desc_so' => 'ڕێگریشن، پۆلێنکردن، کلاستەرکردن و ڕاهێنانی مۆدێل — یەکەم مۆدێلەکانت لێرەدا دروست دەکەیت.',
                'desc_ba' => 'ڕێگریشن، پۆلێنکرن، کلاستەرکرن و ڕاهێنانا مۆدێلێ — یێکێم مۆدێلێن تێ لێرێ دروست دکەی.',
                'icon' => '🤖', 'accent' => 'green', 'status' => 'active',
            ],
            [
                'title_so' => 'تۆڕە دەمارییەکان',
                'title_ba' => 'تۆرێن دەماری',
                'desc_so' => 'نۆڕۆن، چینەکان، فەنکشنی چالاک و ڕاوهێنان بە Backpropagation — مێشکی دەستکرد.',
                'desc_ba' => 'نۆڕۆن، چینێ، فەنکشنا چالاک و ڕاهێنان ب Backpropagation — مێشکێ دەستکرد.',
                'icon' => '🕸️', 'accent' => 'sky', 'status' => 'active',
            ],
            [
                'title_so' => 'فێربوونی قووڵ (Deep Learning)',
                'title_ba' => 'فێربوونا قووڵ (Deep Learning)',
                'desc_so' => 'تۆڕە قووڵەکان، CNN، RNN و Transformer — ئەو تەکنەلۆژیایەی شۆڕشی AIی دروست کرد.',
                'desc_ba' => 'تۆرێن قووڵ، CNN، RNN و Transformer — ئا تەکنەلۆژیایا شۆڕشا AI دڕاستکری.',
                'icon' => '🌊', 'accent' => 'indigo', 'status' => 'active',
            ],
            [
                'title_so' => 'بینینی کۆمپیوتەر',
                'title_ba' => 'بینینا کۆمپیوتەری',
                'desc_so' => 'ناسینەوەی وێنە، دیتێکشن و سێگۆشەکردن — فێربوونی بینین بە کامێرا و داتای وێنەیی.',
                'desc_ba' => 'ناسینا وێنە، دیتێکشن و سێگۆشەکرن — فێربوونا بینین ب کامێرا و داتایێ وێنەیی.',
                'icon' => '👁️', 'accent' => 'rose', 'status' => 'coming_soon',
            ],
            [
                'title_so' => 'پرۆسێسکردنی زمانی سروشتی',
                'title_ba' => 'پرۆسێسکرنا زمانێ سروشتی',
                'desc_so' => 'کاریکردن بە زمانی مرۆیی: تۆکنایزەیشن، ئیمبێدینگ، سێنتیمێنت و مۆدێلە زمانییە گەورەکان (LLM).',
                'desc_ba' => 'کارکرن ب زمانێ مرۆڤی: تۆکنایزەیشن، ئیمبێدینگ، سێنتیمێنت و مۆدێلێن زمانی گەورە (LLM).',
                'icon' => '💬', 'accent' => 'teal', 'status' => 'coming_soon',
            ],
        ];
    }
}