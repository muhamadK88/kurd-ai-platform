<?php

// Generates line-by-line code explanations (Sorani + Badini) for all ferga lessons
// and stores them as code_explain_so / code_explain_ba JSON arrays on each lesson.

$db = "https://ai-platform-adb1b-default-rtdb.firebaseio.com";
$token = trim(file_get_contents("/tmp/opencode/fb_token.txt"));
$d = json_decode(file_get_contents("/tmp/opencode/ferga_full.json"), true);

// ---------- helpers ----------

// wrap latin snippet safely for RTL text (rendered via innerHTML)
function l($s) { return htmlspecialchars($s, ENT_NOQUOTES | ENT_SUBSTITUTE, "UTF-8"); }

function pair($so, $ba) { return [$so, $ba]; }

function stripQuotes($s) {
    $s = trim($s);
    if ((str_starts_with($s, '"') && str_ends_with($s, '"')) || (str_starts_with($s, "'") && str_ends_with($s, "'")))
        return substr($s, 1, -1);
    return $s;
}

function isQuoted($s) {
    $s = trim($s);
    return (str_starts_with($s, '"') || str_starts_with($s, "'")) && (str_ends_with($s, '"') || str_ends_with($s, "'"));
}

function isNumber($s) { return is_numeric(trim($s)); }
function isVar($s) { return (bool)preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', trim($s)); }

// joiner for list of items into Kurdish phrase
function joinItems($arr, $soSep = "، ") { return implode($soSep, array_filter($arr, fn($x) => $x !== "")); }

// ---------- Python ----------
function pyExplain($line) {
    $t = trim($line);
    if ($t === "") return null;

    // comment
    if (str_starts_with($t, "#")) {
        $c = l(trim(substr($t, 1)));
        if ($c === "") return pair("تێبینی (comment) — هیچ کاری ناکات", "تێبینی (comment) — هیچ کاری ناکەت");
        return pair("تێبینی: $c", "تێبینی: $c");
    }
    // import
    if (preg_match('/^import\s+([\w\.]+)/', $t, $m))
        return pair("لیبرارییەکە بە ناوی <bdi>{$m[1]}</bdi> دەهێنێتە ناو کۆدەکە بۆ بەکارهێنانی فەرمانەکانی", "کتابخانایا بە ناڤێ <bdi>{$m[1]}</bdi> تینیتە ناڤ کۆدی بۆ بکارئینانا فەرمانێن وی");
    if (preg_match('/^from\s+([\w\.]+)\s+import\s+(.+)/', $t, $m))
        return pair("لە لیبرارییەکە <bdi>{$m[1]}</bdi> ئەم شتانە دەهێنێت: <bdi>{$m[2]}</bdi>", "ژ کتابخانایا <bdi>{$m[1]}</bdi> ئەڤان دتینیت: <bdi>{$m[2]}</bdi>");
    // class
    if (preg_match('/^class\s+(\w+)\s*\((.*)\)\s*:/', $t, $m))
        return pair("کلاسێک بە ناوی <bdi>{$m[1]}</bdi> دروست دەکات کە لە <bdi>{$m[2]}</bdi> دەست دەگرێت (میراث/میراس)", "کلاسەکە بە ناڤێ <bdi>{$m[1]}</bdi> دروست دکەت کو ژ <bdi>{$m[2]}</bdi> دەست دگرت (میرات)");
    if (preg_match('/^class\s+(\w+)\s*:/', $t, $m))
        return pair("کلاسێک بە ناوی <bdi>{$m[1]}</bdi> دروست دکات — چوارچێوەیەک بۆ دروستکردنی ئۆبژەکتەکان", "کلاسەکە بە ناڤێ <bdi>{$m[1]}</bdi> دروست دکەت — چوارچێوەیەک بو دروستکرنا ئۆبژەکتان");
    // methods
    if (preg_match('/^def\s+__init__\s*\(self(.*)\)\s*:/', $t, $m))
        return pair("فەنکشنی سازکەر: کاتێک ئۆبژەکتێک دروست دەکرێت ئەمە سەرەتا جێبەجێ دەبێت", "فەنکشنا سازکەر: دەمێ ئۆبژەکتەک دروست دبیت ئەڤە دەستپێک جێبەجێ دبیت");
    if (preg_match('/^def\s+(\w+)\s*\((.*)\)\s*:/', $t, $m)) {
        $args = trim($m[2]);
        if ($args === "" || $args === "self")
            return pair("فەنکشنێک بە ناوی <bdi>{$m[1]}</bdi> دروست دەکات — گرووپێکی فەرمانەکان", "فەنکشنەکە بە ناڤێ <bdi>{$m[1]}</bdi> دروست دکەت — گروپەکا ژ فەرمانان");
        return pair("فەنکشنێک بە ناوی <bdi>{$m[1]}</bdi> دروست دەکات و <bdi>{$args}</bdi> وەردەگرێت", "فەنکشنەکە بە ناڤێ <bdi>{$m[1]}</bdi> دروست دکەت و <bdi>{$args}</bdi> وەردگرت");
    }
    // self attribute
    if (preg_match('/^self\.(\w+)\s*=\s*(.+)/', $t, $m))
        return pair("تایبەتمەندی <bdi>{$m[1]}</bdi> بۆ ئەم ئۆبژەکتە دادەنێت بە بەهای <bdi>{$m[2]}</bdi>", "تایبەتمەندییا <bdi>{$m[1]}</bdi> بو ڤی ئۆبژەکتی دانیت ب بەهایا <bdi>{$m[2]}</bdi>");
    if (preg_match('/^self\.(\w+)/', $t, $m))
        return pair("ئاماژەیە بۆ تایبەتمەندی <bdi>{$m[1]}</bdi> لەم ئۆبژەکتە", "ئاماژەیە بو تایبەتمەندییا <bdi>{$m[1]}</bdi> د ڤی ئۆبژەکتی");
    // def/class decorators
    if (str_starts_with($t, "@"))
        return pair("سینگەلێکە (decorator) کە ڕەفتاری فەنکشنەکە دەگۆڕێت", "سینگەلەکە (decorator) کە ڕەفتارا فەنکشنێ دگوهۆڕیت");
    // try/except
    if (str_starts_with($t, "try:")) return pair("دەستپێکی گەڵاڵەکردنی هەڵە: ئەگەر هەڵە ڕووی دا لەم بەشە، ئەوا بەشی except جێبەجێ دەبێت", "دەستپێکا هەوڵدانا خەلەتێ: ئەگەر خەلەت ڕوویدا د ڤی بەشی، دەمە except جێبەجێ دبیت");
    if (str_starts_with($t, "except")) return pair("دەستگرتنی هەڵە: ئەگەر لە try هەڵەیەک ڕووی دا، ئەم بەشە جێبەجێ دەبێت", "گرتنا خەلەتێ: ئەگەر د try دا خەلەتەک ڕوویدا، ئەڤ بەش جێبەجێ دبیت");
    // with open
    if (preg_match('/^with\s+open\((.+)\)\s+as\s+(\w+)\s*:/', $t, $m))
        return pair("فایلەکە <bdi>{$m[1]}</bdi> دەکاتەوە وەک <bdi>{$m[2]}</bdi> — دوای کۆتایی، خۆکارانە دادەخرێت", "فایل <bdi>{$m[1]}</bdi> ڤەدکەت وەکی <bdi>{$m[2]}</bdi> — پشتی دووماهییێ، خۆکارانە ددهینت");
    // for loops
    if (preg_match('/^for\s+(\w+)\s+in\s+(.+):\s*$/', $t, $m)) {
        $it = l(trim($m[2]));
        if (str_starts_with($it, "range"))
            return pair("لووپ: کۆدەکە بۆ <bdi>{$m[1]}</bdi> دوبارە دەبێتەوە لەسەر هەر ژمارەیەکی <bdi>{$it}</bdi>", "لووپ: کۆد دوبارە دبیتەڤە بو <bdi>{$m[1]}</bdi> ل سەر هەر ژمارەیەکا ژ <bdi>{$it}</bdi>");
        return pair("لووپ: بۆ هەر ئەندامێک (<bdi>{$m[1]}</bdi>) لە <bdi>{$it}</bdi>، کۆدەکە جێبەجێ دەبێت", "لووپ: بو هەر ئەندامەک (<bdi>{$m[1]}</bdi>) ژ <bdi>{$it}</bdi>، کۆد جێبەجێ دبیت");
    }
    // while
    if (preg_match('/^while\s+(.+):\s*$/', $t, $m))
        return pair("لووپی while: هەتا مەرجەکە <bdi>{$m[1]}</bdi> ڕاستە، کۆدەکە دوبارە دەبێتەوە", "لووپا while: هەتا مەرج <bdi>{$m[1]}</bdi> ڕاستە، کۆد دوبارە دبیتەڤە");
    // if / elif / else
    if (preg_match('/^if\s+(.+):\s*$/', $t, $m))
        return pair("مەرج: ئەگەر <bdi>{$m[1]}</bdi> ڕاست بوو، ئەوا کۆدی ژوورەوە جێبەجێ دەبێت", "مەرج: ئەگەر <bdi>{$m[1]}</bdi> ڕاست بیت، ئەو دەمە کۆدێ ناڤدەر جێبەجێ دبیت");
    if (str_starts_with($t, "elif")) {
        $c = l(trim(preg_replace('/^elif\s+/', '', rtrim($t, ':'))));
        return pair("مەرجی دیکە (elif): ئەگەر مەرجە پێشووەکان ڕاست نەبوون و ئەمە ڕاست بوو — <bdi>$c</bdi>", "مەرجێ دیکە (elif): ئەگەر مەرجێن بەری ڕاست نەبون و ئەڤە ڕاست بیت — <bdi>$c</bdi>");
    }
    if (str_starts_with($t, "else"))
        return pair("بەشی پاشماوە: ئەگەر هیچ مەرجێک ڕاست نەبوو، ئەمە جێبەجێ دەبێت", "بەشێ پاشمایە: ئەگەر هیچ مەرجەک ڕاست نەبیت، ئەڤە جێبەجێ دبیت");
    // break/continue/pass
    if ($t === "break") return pair("وەستاندنی لووپەکە: بەفرمانەکە دەچێتە دەرەوەی لووپەکە", "وەستاندنا لووپێ: بەفرمان ڤەدچیتە دەرڤەی لووپێ");
    if ($t === "continue") return pair("پەڕاندنی ئەم دوبارەکردنەوەیە: دەچێتە دوبارەکردنەوەکەی داهاتوو", "پەڕاندنا ڤێ دوبارەکرنێ: دچیتە دوبارەکرنا داهاتی");
    if ($t === "pass") return pair("بەتاڵییە (pass): هیچ کارێک ناکات، تەنها بۆ تەواوی شوێنی کۆد", "بەتاڵییە (pass): هیچ کاری ناکەت، تەنها بو تەمامکرنا شوینێ کۆدی");
    // return
    if (preg_match('/^return\s+(.+)$/', $t, $m)) {
        $v = l(trim($m[1]));
        return pair("ئەنجامەکە دەگەڕێنێتەوە: <bdi>$v</bdi>", "ئەنجام ڤەدگەڕینیتەڤە: <bdi>$v</bdi>");
    }
    if ($t === "return") return pair("بەفرمانەکە لە فەنکشنەکە دەگەڕێتەوە بەبێ هیچ بەهایەک", "بەفرمان ژ فەنکشنێ ڤەدگەڕیتەڤە بێ هیچ بەهایا");
    // input
    if (preg_match('/^(\w+)\s*=\s*input\((.+)\)/', $t, $m)) {
        $p = l(stripQuotes(trim($m[2])));
        return pair("داتا لە بەکارهێنەر وەردەگرێت (پەیامی <bdi>$p</bdi>) و لە گۆڕاوی <bdi>{$m[1]}</bdi> هەڵیدەگرێت", "داتای ژ بکارئینەر وەردگرت (پەیاما <bdi>$p</bdi>) و د گۆڕاڤێ <bdi>{$m[1]}</bdi> دا هلدگرت");
    }
    // print
    if (preg_match('/^print\s*\((.+)\)\s*$/', $t, $m)) {
        $a = trim($m[1]);
        if (isQuoted($a)) {
            $s = l(stripQuotes($a));
            return pair("دەقەکە <bdi>$s</bdi> لەسەر شاشە پیشان دەدات", "دەق <bdi>$s</bdi> ل سەر شاشێ نیشان ددات");
        }
        if (isVar($a))
            return pair("بەهای گۆڕاوی <bdi>$a</bdi> لەسەر شاشە پیشان دەدات", "بەهایا گۆڕاڤێ <bdi>$a</bdi> ل سەر شاشێ نیشان ددات");
        if (preg_match('/^(\w+)\.(\w+)$/', $a, $am))
            return pair("تایبەتمەندی <bdi>{$am[2]}</bdi> لە ئۆبژەکتی <bdi>{$am[1]}</bdi> پیشان دەدات", "تایبەتمەندییا <bdi>{$am[2]}</bdi> ژ ئۆبژەکتی <bdi>{$am[1]}</bdi> نیشان ددات");
        if (isNumber($a))
            return pair("ژمارەکە <bdi>$a</bdi> لەسەر شاشە پیشان دەدات", "ژمارە <bdi>$a</bdi> ل سەر شاشێ نیشان ددات");
        return pair("ئەنجامی <bdi>$a</bdi> ژمێر دەکات و پیشان دەدات", "ئەنجامێ <bdi>$a</bdi> ژمێر دکەت و نیشان ددات");
    }
    // type conversions
    if (preg_match('/^(\w+)\s*=\s*(int|float|str|bool)\((.*)\)/', $t, $m))
        return pair("ئەنجامی <bdi>{$m[3]}</bdi> دەگۆڕێت بۆ جۆری <bdi>{$m[2]}</bdi> و لە <bdi>{$m[1]}</bdi> هەڵیدەگرێت", "ئەنجامێ <bdi>{$m[3]}</bdi> دگوهۆڕیت بو جۆرێ <bdi>{$m[2]}</bdi> و د <bdi>{$m[1]}</bdi> دا هلدگرت");
    // augmented assignment (must be BEFORE plain assignment)
    if (preg_match('/^(\w+)\s*(\+=|-=|\*=|\/=|%=|\/\/=|\*\*=)\s*(.+)$/', $t, $m))
        return pair("بەهای گۆڕاوی <bdi>{$m[1]}</bdi> دەگۆڕێت بە <bdi>{$m[2]}{$m[3]}</bdi>", "بەهایا گۆڕاڤێ <bdi>{$m[1]}</bdi> دگوهۆڕیت ب <bdi>{$m[2]}{$m[3]}</bdi>");
    // function call
    if (preg_match('/^(\w+)\((.*)\)\s*$/', $t, $m)) {
        $args = trim($m[2]);
        if ($args === "")
            return pair("فەنکشنی <bdi>{$m[1]}</bdi> بانگ دەکات (جێبەجێ دەکات)", "فەنکشنا <bdi>{$m[1]}</bdi> بانگ دکەت (جێبەجێ دکەت)");
        return pair("فەنکشنی <bdi>{$m[1]}</bdi> بانگ دەکات بە <bdi>$args</bdi>", "فەنکشنا <bdi>{$m[1]}</bdi> بانگ دکەت ب <bdi>$args</bdi>");
    }
    // assignment
    if (preg_match('/^(\w+)\s*=\s*(.+)$/', $t, $m)) {
        $v = l(trim($m[1]));
        $val = trim($m[2]);
        if (preg_match('/^([A-Z]\w*)\((.*)\)$/', $val, $cm))
            return pair("ئۆبژەکتێکی نوێ دروست دەکات لە کلاسی <bdi>{$cm[1]}</bdi> و لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "ئۆبژەکتەکا نوی دروست دکەت ژ کلاسی <bdi>{$cm[1]}</bdi> و د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        if (preg_match('/^\[.*\]$/', $val))
            return pair("لیستێک دروست دەکات و لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "لیستەک دروست دکەت و د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        if (preg_match('/^\{.*\}$/', $val))
            return pair("فەرهەنگێک (dictionary) دروست دەکات و لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "فەرهەنگەک (dictionary) دروست دکەت و د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        if (isQuoted($val)) {
            $s = l(stripQuotes($val));
            return pair("دەقەکە <bdi>$s</bdi> لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "دەق <bdi>$s</bdi> د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        }
        if (isNumber($val))
            return pair("ژمارەکە <bdi>$val</bdi> لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "ژمارە <bdi>$val</bdi> د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        if ($val === "True" || $val === "False")
            return pair("بەهایی ڕاستی <bdi>$val</bdi> لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "بەهایا ڕاستییێ <bdi>$val</bdi> د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
        return pair("ئەنجامی <bdi>$val</bdi> لە گۆڕاوی <bdi>$v</bdi> هەڵیدەگرێت", "ئەنجامێ <bdi>$val</bdi> د گۆڕاڤێ <bdi>$v</bdi> دا هلدگرت");
    }
    // augmented assignment
    if (preg_match('/^(\w+)\s*(\+=|-=|\*=|\/=|%=|\/\/=|\*\*=)\s*(.+)$/', $t, $m))
        return pair("بەهای گۆڕاوی <bdi>{$m[1]}</bdi> دەگۆڕێت بە <bdi>{$m[2]}{$m[3]}</bdi>", "بەهایا گۆڕاڤێ <bdi>{$m[1]}</bdi> دگوهۆڕیت ب <bdi>{$m[2]}{$m[3]}</bdi>");
    // methods on objects
    if (preg_match('/^(\w+)\.(\w+)\((.+)\)\s*$/', $t, $m))
        return pair("فەنکشنی <bdi>{$m[2]}</bdi> لەسەر <bdi>{$m[1]}</bdi> جێبەجێ دەکات بە <bdi>{$m[3]}</bdi>", "فەنکشنا <bdi>{$m[2]}</bdi> ل سەر <bdi>{$m[1]}</bdi> جێبەجێ دکەت ب <bdi>{$m[3]}</bdi>");
    if (preg_match('/^(\w+)\.(\w+)\(\)\s*$/', $t, $m))
        return pair("فەنکشنی <bdi>{$m[2]}</bdi> لەسەر <bdi>{$m[1]}</bdi> جێبەجێ دەکات", "فەنکشنا <bdi>{$m[2]}</bdi> ل سەر <bdi>{$m[1]}</bdi> جێبەجێ دکەت");
    // indexing
    if (preg_match('/^(\w+)\[(\d+|-?\d+)\]\s*=\s*(.+)$/', $t, $m))
        return pair("ئەندامی ژمارە <bdi>{$m[2]}</bdi> لە لیستی <bdi>{$m[1]}</bdi> دەگۆڕێت بۆ <bdi>{$m[3]}</bdi>", "ئەندامێ ژمارە <bdi>{$m[2]}</bdi> د لیستا <bdi>{$m[1]}</bdi> دا دگوهۆڕیت بو <bdi>{$m[3]}</bdi>");
    if (preg_match('/^(\w+)\[(\d+)\]/', $t, $m))
        return pair("دەستگەیشتن بە ئەندامی ژمارە <bdi>{$m[2]}</bdi> لە <bdi>{$m[1]}</bdi>", "دەستگەهشتنە ئەندامێ ژمارە <bdi>{$m[2]}</bdi> ژ <bdi>{$m[1]}</bdi>");
    // len()
    if (preg_match('/^(\w+)\s*=\s*len\((.+)\)$/', $t, $m))
        return pair("ژمارەی ئەندامەکانی <bdi>{$m[2]}</bdi> دەژمێرێت و لە <bdi>{$m[1]}</bdi> هەڵیدەگرێت", "ژمارا ئەندامان ژ <bdi>{$m[2]}</bdi> دژمێرت و د <bdi>{$m[1]}</bdi> دا هلدگرت");
    // f-strings in print
    if (str_contains($t, 'f"') || str_contains($t, "f'"))
        return pair("دەقی f-string: بەهای گۆڕاوەکان لە ناو { } دەخرێتە ناو دەقەکە", "دەقی f-string: بەهایا گۆڕاڤان د ناڤ { } دا ددهینتە ناڤ دەقی");
    // comparisons/expressions as statements
    if (preg_match('/^(\w+)\s*([<>]=?|==|!=)\s*(.+)$/', $t, $m))
        return pair("بەراوردکردنی <bdi>{$m[1]}</bdi> لەگەڵ <bdi>{$m[2]} {$m[3]}</bdi>", "بەراوردکرنا <bdi>{$m[1]}</bdi> دگەل <bdi>{$m[2]} {$m[3]}</bdi>");
    // lambda
    if (str_contains($t, "lambda"))
        return pair("فەنکشنی بێ ناو (lambda): فەنکشنێکی بچووک لە هێڵێکدا", "فەنکشنا بێ ناڤ (lambda): فەنکشنەکا بچویک د هێلەکێ دا");
    // generic
    $kw = l(preg_replace('/[^A-Za-z0-9_.]+/', ' ', $t));
    return pair("ئەم هێڵە بەکارهێنانی <bdi>$kw</bdi>", "ئەڤ هێلە بکارئینانا <bdi>$kw</bdi>");
}

// ---------- C++ ----------
function cppExplain($line) {
    $t = trim($line);
    if ($t === "") return null;

    // comment
    if (str_starts_with($t, "//")) {
        $c = l(trim(substr($t, 2)));
        if ($c === "") return pair("تێبینی (comment) — هیچ کاری ناکات", "تێبینی (comment) — هیچ کاری ناکەت");
        return pair("تێبینی: $c", "تێبینی: $c");
    }
    if (str_starts_with($t, "/*"))
        return pair("تێبینی فرەهێڵی (comment)", "تێبینی فرەهێڵی (comment)");
    // include
    if (preg_match('/#include\s*<([\w\.]+)>/', $t, $m))
        return pair("فایلەکەی سەری <bdi>{$m[1]}</bdi> دەهێنێت — فەرمانە ناسراوەکانی تێدایە", "فایلێ سەری <bdi>{$m[1]}</bdi> تینیت — فەرمانێن ناساڤ تێدا هەنە");
    if (preg_match('/#include\s*"([\w\.\/]+)"/', $t, $m))
        return pair("فایلە تایبەتەکە <bdi>{$m[1]}</bdi> دەهێنێتە ناو کۆدەکە", "فایلێ تایبەت <bdi>{$m[1]}</bdi> تینیتە ناڤ کۆدی");
    if (str_starts_with($t, "#define"))
        return pair("پێناسەیەک (define) بۆ ناوی سادە", "پێناسەکە (define) بو ناڤێ سادە");
    if (str_starts_with($t, "using namespace"))
        return pair("بەکارهێنانی فەرمانە ستانداردەکان بەبێ نووسینی <bdi>std::</bdi>", "بکارئینانا فەرمانێن ستاندارد بێ نڤیسینا <bdi>std::</bdi>");
    // main
    if (preg_match('/^\s*(int|void)\s+main\s*\(\s*\)\s*\{/', $t))
        return pair("خاڵی دەستپێکی پرۆگرامەکە: کۆدەکە لەمەوە جێبەجێ دەبێت", "خالێ دەستپێکا پرۆگرامێ: کۆد ژ ڤیرە جێبەجێ دبیت");
    if (preg_match('/^\s*(int|void)\s+main\s*\(\s*\)\s*$/', $t))
        return pair("خاڵی دەستپێکی پرۆگرامەکە: کۆدەکە لەمەوە جێبەجێ دەبێت", "خالێ دەستپێکا پرۆگرامێ: کۆد ژ ڤیرە جێبەجێ دبیت");
    // cout
    if (str_contains($t, "cout <<")) {
        $parts = [];
        $rest = $t;
        while (preg_match('/\<\<\s*("(?:[^"\\\\]|\\\\.)*"|\'(?:[^\'\\\\]|\\\\.)*\'|[A-Za-z_]\w*\(\s*(?:[^()]|\([^()]*\))*\)|\d+(?:\.\d+)?)/', $rest, $m)) {
            $rest = substr($rest, strpos($rest, $m[0]) + strlen($m[0]));
            $val = trim($m[1]);
            if (isQuoted($val)) $parts[] = "دەق <bdi>" . l(stripQuotes($val)) . "</bdi>";
            elseif (preg_match('/^(\w+)\(/', $val, $fm)) $parts[] = "ئەنجامی فەنکشنی <bdi>$val</bdi>";
            elseif (isVar($val)) $parts[] = "بەهای <bdi>$val</bdi>";
            elseif (isNumber($val)) $parts[] = "ژمارە <bdi>$val</bdi>";
            elseif ($val === "endl") $parts[] = "هێڵی نوێ";
        }
        if (count($parts) > 0) {
            $joined = joinItems($parts);
            return pair("لەسەر شاشە دەنووسێت: $joined", "ل سەر شاشێ دنینڤیسیت: $joined");
        }
        return pair("دەق/بەها لەسەر شاشە دەنووسێت", "دەق/بەهایا ل سەر شاشێ دنینڤیسیت");
    }
    // cin
    if (preg_match('/cin\s*>>\s*(.+)/', $t, $m)) {
        $vars = l(preg_replace('/>>\s*/', ' و ', trim($m[1])));
        return pair("داتا لە بەکارهێنەر وەردەگرێت و لە گۆڕاوەکە <bdi>$vars</bdi> هەڵیدەگرێت", "داتای ژ بکارئینەر وەردگرت و د گۆڕاڤێ <bdi>$vars</bdi> دا هلدگرت");
    }
    // control flow braces
    if (preg_match('/^\}\s*else\s*(if|{)/', $t) || $t === "} else {")
        return pair("بەشی پاشماوە: ئەگەر مەرجەکە ڕاست نەبوو، ئەمە جێبەجێ دەبێت", "بەشێ پاشمایە: ئەگەر مەرج ڕاست نەبیت، ئەڤە جێبەجێ دبیت");
    if (preg_match('/^if\s*\((.*)\)\s*\{?$/', $t, $m)) {
        $c = l(trim($m[1]));
        return pair("مەرج: ئەگەر <bdi>$c</bdi> ڕاست بوو، ئەوا کۆدی ناو بلۆکەکە جێبەجێ دەبێت", "مەرج: ئەگەر <bdi>$c</bdi> ڕاست بیت، کۆدێ ناڤ بلۆکی جێبەجێ دبیت");
    }
    if (preg_match('/^else\s+\{?$/', $t))
        return pair("بەشی پاشماوە: ئەگەر مەرجەکە ڕاست نەبوو، ئەمە جێبەجێ دەبێت", "بەشێ پاشمایە: ئەگەر مەرج ڕاست نەبیت، ئەڤە جێبەجێ دبیت");
    if (preg_match('/^else\s+if\s*\((.*)\)\s*\{?$/', $t, $m))
        return pair("مەرجی دیکە: ئەگەر مەرجە پێشووەکان ڕاست نەبوون و ئەمە ڕاست بوو — <bdi>{$m[1]}</bdi>", "مەرجێ دیکە: ئەگەر مەرجێن بەری ڕاست نەبون و ئەڤە ڕاست بیت — <bdi>{$m[1]}</bdi>");
    // ternary
    if (str_contains($t, "?"))
        return pair("مەرجی کورت (ternary): ئەگەر مەرجەکە ڕاست بوو بەهای یەکەم، نەک ئەوی دووەم", "مەرجێ کورت (ternary): ئەگەر مەرج ڕاست بیت بەهایا دویێ، نەک دویا");
    // for
    if (preg_match('/^for\s*\((.*)\)\s*\{?$/', $t, $m)) {
        $s = trim($m[1]);
        if (preg_match('/^(.*?);(.*?);(.*)$/', $s, $p))
            return pair("لووپی for: <bdi>{$p[1]}</bdi>؛ هەتا <bdi>{$p[2]}</bdi> ڕاستە؛ هەموو جار <bdi>{$p[3]}</bdi>", "لووپا for: <bdi>{$p[1]}</bdi>؛ هەتا <bdi>{$p[2]}</bdi> ڕاستە؛ هەر جار <bdi>{$p[3]}</bdi>");
        return pair("لووپی for بەم مەرجانە: <bdi>$s</bdi>", "لووپا for ب ڤان مەرجان: <bdi>$s</bdi>");
    }
    // while
    if (preg_match('/^while\s*\((.*)\)\s*\{?$/', $t, $m))
        return pair("لووپی while: هەتا <bdi>{$m[1]}</bdi> ڕاستە، کۆدەکە دوبارە دەبێتەوە", "لووپا while: هەتا <bdi>{$m[1]}</bdi> ڕاستە، کۆد دوبارە دبیتەڤە");
    if (preg_match('/^do\s*\{?$/', $t))
        return pair("لووپی do-while: یەکەم جار کۆدەکە جێبەجێ دەبێت، پاشان مەرجەکە پشکنی دەکرێت", "لووپا do-while: دەستپێک کۆد جێبەجێ دبیت، پشتی مەرج پشکنی دکەت");
    // switch
    if (preg_match('/^switch\s*\((.+)\)\s*\{?$/', $t, $m))
        return pair("فرمانی switch: بەپێی بەهای <bdi>{$m[1]}</bdi> لقەکان پشکنی دەکرێت", "فەرمانا switch: ل گورە بەهایا <bdi>{$m[1]}</bdi> لق پشکنی دکەت");
    if (preg_match('/^case\s+([^:]+)\s*:/', $t, $m))
        return pair("ئەگەر بەهاکە <bdi>{$m[1]}</bdi> بوو، ئەم لقە جێبەجێ دەبێت", "ئەگەر بەها <bdi>{$m[1]}</bdi> بیت، ئەڤ لق جێبەجێ دبیت");
    if (str_starts_with($t, "default:"))
        return pair("ئەگەر هیچ لقییەک ڕاست نەبوو، ئەم لقە جێبەجێ دەبێت", "ئەگەر هیچ لقەک ڕاست نەبیت، ئەڤ لق جێبەجێ دبیت");
    // break/continue
    if (str_starts_with($t, "break")) return pair("وەستاندنی لووپ/لقەکە", "وەستاندنا لووپ/لقێ");
    if (str_starts_with($t, "continue")) return pair("پەڕاندن بۆ دوبارەکردنەوەکەی داهاتوو", "پەڕاندن بو دوبارەکرنا داهاتی");
    // return
    if (preg_match('/^return\s+(.+);\s*$/', $t, $m)) {
        $v = l(trim($m[1]));
        if ($v === "0")
            return pair("کۆتایی سەرکەوتووی فەنکشنەکە (بەفرمانەکە 0 دەگەڕێنێتەوە)", "دووماهیا سەرکەفتی یا فەنکشنێ (بەفرمان 0 ڤەدگەڕینیتەڤە)");
        return pair("ئەنجامەکە <bdi>$v</bdi> دەگەڕێنێتەوە بۆ شوێنی بانگکردن", "ئەنجام <bdi>$v</bdi> ڤەدگەڕینیتەڤە بو شوینێ بانگکرنێ");
    }
    if (str_starts_with($t, "return"))
        return pair("گەڕانەوە لە فەنکشنەکە", "ڤەگەڕانە ژ فەنکشنێ");
    // function definitions
    if (preg_match('/^(?:inline\s+)?([A-Za-z_][\w]*\s*&?)\s+(\w+)\s*\(([^;]*?)\)\s*\{?$/', $t, $m)) {
        $ret = trim($m[1]);
        $fname = $m[2];
        $args = trim($m[3]);
        $argPart = "";
        if ($args !== "") {
            $argNames = [];
            foreach (explode(",", $args) as $a) {
                $a = trim($a);
                if (preg_match('/([A-Za-z_]\w*)\s*$/', $a, $am)) $argNames[] = $am[1];
            }
            $argPart = " — وەردەگرێت: <bdi>" . l(joinItems($argNames)) . "</bdi>";
        }
        return pair("فەنکشنێک دروست دەکات بە ناوی <bdi>$fname</bdi> (جۆری گەڕانەوە: <bdi>$ret</bdi>)$argPart", "فەنکشنەکە دروست دکەت بە ناڤێ <bdi>$fname</bdi> (جۆرێ ڤەگەڕانێ: <bdi>$ret</bdi>)$argPart");
    }
    // function definition with body on the same line
    if (preg_match('/^(?:inline\s+)?([A-Za-z_][\w]*\s*&?)\s+(\w+)\s*\(([^;]*?)\)\s*\{(.+)\}\s*;?\s*$/', $t, $m)) {
        $ret = l(trim($m[1]));
        $fname = l($m[2]);
        $body = l(trim($m[4]));
        return pair("فەنکشنێک بە ناوی <bdi>$fname</bdi> (جۆری گەڕانەوە: <bdi>$ret</bdi>) کە ئەمە جێبەجێ دەکات: <bdi>$body</bdi>", "فەنکشنەکە بە ناڤێ <bdi>$fname</bdi> (جۆرێ ڤەگەڕانێ: <bdi>$ret</bdi>) کو ئەڤە جێبەجێ دکەت: <bdi>$body</bdi>");
    }
    // method with body (inside class)
    if (preg_match('/^([A-Za-z_][\w]*)\s+(\w+)\s*\(([^;]*?)\)\s*\{(.+)\}\s*;?\s*$/', $t, $m)) {
        $fname = l($m[2]);
        $body = l(trim($m[4]));
        return pair("فەنکشنی کلاسەکە بە ناوی <bdi>$fname</bdi> کە ئەمە جێبەجێ دەکات: <bdi>$body</bdi>", "فەنکشنا کلاسی بە ناڤێ <bdi>$fname</bdi> کو ئەڤە جێبەجێ دکەت: <bdi>$body</bdi>");
    }
    // constructor with body
    if (preg_match('/^(\w+)\s*\(([^;]*?)\)\s*\{(.+)\}\s*;?\s*$/', $t, $m)) {
        $body = l(trim($m[3]));
        return pair("سازکەر (constructor) بۆ کلاسەکە کە ئەمە جێبەجێ دەکات: <bdi>$body</bdi>", "سازکەر (constructor) بو کلاسێ کو ئەڤە جێبەجێ دکەت: <bdi>$body</bdi>");
    }
    // template
    if (str_starts_with($t, "template <"))
        return pair("فەنکشنی ژەنەریک (template): جۆرێکی گشتی لە شوێنی T", "فەنکشنا ژەنەریک (template): جۆرەکا گشتی د شوینێ T دا");
    // class with inheritance
    if (preg_match('/^class\s+(\w+)\s*:\s*\w+\s+(\w+)\s*\{?$/', $t, $m))
        return pair("کلاسێک بە ناوی <bdi>{$m[1]}</bdi> کە لە <bdi>{$m[2]}</bdi> دەست دەگرێت (میراث/میراس)", "کلاسەکە بە ناڤێ <bdi>{$m[1]}</bdi> کو ژ <bdi>{$m[2]}</bdi> دەست دگرت (میرات)");
    // catch
    if (str_starts_with($t, "} catch") || str_starts_with($t, "catch"))
        return pair("دەستگرتنی هەڵە (catch): ئەگەر لە try هەڵەیەک ڕووی دا، ئەم بەشە جێبەجێ دەبێت", "گرتنا خەلەتێ (catch): ئەگەر د try دا خەلەتەک ڕوویدا، ئەڤ بەش جێبەجێ دبیت");
    // class
    if (preg_match('/^class\s+(\w+)\s*(\{|$)/', $t, $m))
        return pair("کلاسێک دروست دەکات بە ناوی <bdi>{$m[1]}</bdi> — چوارچێوەیەک بۆ ئۆبژەکتەکان", "کلاسەکە دروست دکەت بە ناڤێ <bdi>{$m[1]}</bdi> — چوارچێوەیەک بو ئۆبژەکتان");
    if (preg_match('/^struct\s+(\w+)\s*\{?$/', $t, $m))
        return pair("ستڕەکتێک دروست دەکات بە ناوی <bdi>{$m[1]}</bdi> — کۆمەڵێک داتا", "سترەکتەک دروست دکەت بە ناڤێ <bdi>{$m[1]}</bdi> — کۆمەلەک داتای");
    if ($t === "private:")
        return pair("ئەندامە شەخسییەکان (private): تەنها لەناو کلاسەکە دەست دەکەوێت", "ئەندامێن شەخسی (private): تەنها د ناڤ کلاسێ دا دەست دکەڤیت");
    if ($t === "public:")
        return pair("ئەندامە گشتییەکان (public): لە هەموو شوێنێک دەست دەکەوێت", "ئەندامێن گشتی (public): ژ هەموو شوینەک دەست دکەڤیت");
    if ($t === "protected:")
        return pair("ئەندامە پارێزراوەکان (protected)", "ئەندامێن پارێزرای (protected)");
    // constructor
    if (preg_match('/^(\w+)\s*\(\s*\)\s*\{?$/', $t, $m) && preg_match('/^\w+$/', $m[1]))
        return pair("سازکەر (constructor) بۆ کلاسەکە", "سازکەر (constructor) بو کلاسێ");
    // class end
    if (preg_match('/^\}\s*;\s*$/', $t)) return pair("کۆتایی پێناسەی کلاسەکە", "دووماهیا پێناسا کلاسی");
    // object method call
    if (preg_match('/^(\w+)\.(\w+)\((.*)\)\s*;\s*$/', $t, $m)) {
        $args = trim($m[3]);
        if ($args === "")
            return pair("فەنکشنی <bdi>{$m[2]}</bdi> لە ئۆبژەکتی <bdi>{$m[1]}</bdi> بانگ دەکات", "فەنکشنا <bdi>{$m[2]}</bdi> ژ ئۆبژەکتی <bdi>{$m[1]}</bdi> بانگ دکەت");
        return pair("فەنکشنی <bdi>{$m[2]}</bdi> لە ئۆبژەکتی <bdi>{$m[1]}</bdi> بانگ دەکات بە <bdi>$args</bdi>", "فەنکشنا <bdi>{$m[2]}</bdi> ژ ئۆبژەکتی <bdi>{$m[1]}</bdi> بانگ دکەت ب <bdi>$args</bdi>");
    }
    // declarations
    if (preg_match('/^([A-Za-z_][\w]*)\s+(\w+)\s*=\s*(.+);\s*$/', $t, $m)) {
        $type = l($m[1]);
        $name = l($m[2]);
        $val = trim($m[3]);
        $valPart = "";
        if (isQuoted($val)) $valPart = " و دەقەکە <bdi>" . l(stripQuotes($val)) . "</bdi> تێدا هەڵدەگرێت";
        elseif (isNumber($val)) $valPart = " و بەهای <bdi>$val</bdi>ی تێدا هەڵدەگرێت";
        elseif (isVar($val)) $valPart = " و بەهای گۆڕاوی <bdi>$val</bdi>ی تێدا هەڵدەگرێت";
        else $valPart = " و بەهای <bdi>" . l($val) . "</bdi>ی تێدا هەڵدەگرێت";
        return pair("گۆڕاوێک دروست دەکات بە ناوی <bdi>$name</bdi> بە جۆری <bdi>$type</bdi>$valPart", "گۆڕاوەک دروست دکەت بە ناڤێ <bdi>$name</bdi> بە جۆرێ <bdi>$type</bdi>$valPart");
    }
    if (preg_match('/^([A-Za-z_][\w]*)\s+(\w+)\s*;\s*$/', $t, $m))
        return pair("گۆڕاوێک دروست دەکات بە ناوی <bdi>{$m[2]}</bdi> بە جۆری <bdi>{$m[1]}</bdi>", "گۆڕاوەک دروست دکەت بە ناڤێ <bdi>{$m[2]}</bdi> بە جۆرێ <bdi>{$m[1]}</bdi>");
    // augmented assignment (must be BEFORE simple assignment)
    if (preg_match('/^(\w+)\s*(\+=|-=|\*=|\/=|%=)\s*(.+);\s*$/', $t, $m))
        return pair("بەهای گۆڕاوی <bdi>{$m[1]}</bdi> دەگۆڕێت بە <bdi>{$m[2]} {$m[3]}</bdi>", "بەهایا گۆڕاڤێ <bdi>{$m[1]}</bdi> دگوهۆڕیت ب <bdi>{$m[2]} {$m[3]}</bdi>");
    // simple assignment
    if (preg_match('/^(\w+)\s*=\s*(.+);\s*$/', $t, $m)) {
        $val = trim($m[2]);
        if (preg_match('/^\{.*\}$/', $val))
            return pair("لیستێک لە گۆڕاوی <bdi>{$m[1]}</bdi> هەڵیدەگرێت (ڕیز / array)", "لیستەک د گۆڕاڤێ <bdi>{$m[1]}</bdi> دا هلدگرت (ڕیز / array)");
        return pair("بەهای <bdi>$val</bdi> لە گۆڕاوی <bdi>{$m[1]}</bdi> هەڵیدەگرێت", "بەهایا <bdi>$val</bdi> د گۆڕاڤێ <bdi>{$m[1]}</bdi> دا هلدگرت");
    }
    if (preg_match('/^(\w+)\+\+\s*;\s*$/', $t, $m))
        return pair("١ زیاد دەکات بۆ بەهای <bdi>{$m[1]}</bdi>", "١ زێدە دکەت بو بەهایا <bdi>{$m[1]}</bdi>");
    if (preg_match('/^(\w+)--\s*;\s*$/', $t, $m))
        return pair("١ کەم دەکات لە بەهای <bdi>{$m[1]}</bdi>", "١ کێم دکەت ژ بەهایا <bdi>{$m[1]}</bdi>");
    // array indexing assignment
    if (preg_match('/^(\w+)\[(\w+|\d+)\]\s*=\s*(.+);\s*$/', $t, $m))
        return pair("ئەندامی <bdi>{$m[2]}</bdi> لە ڕیزەکە <bdi>{$m[1]}</bdi> دەگۆڕێت بۆ <bdi>{$m[3]}</bdi>", "ئەندامێ <bdi>{$m[2]}</bdi> د ڕیزەکێ <bdi>{$m[1]}</bdi> دا دگوهۆڕیت بو <bdi>{$m[3]}</bdi>");
    // pointer
    if (preg_match('/^(\w+)\s*\*\s*(\w+)\s*=\s*&(\w+)\s*;\s*$/', $t, $m))
        return pair("نیشانەرێک (pointer) بە ناوی <bdi>{$m[2]}</bdi> دروست دەکات کە ئاماژەیە بۆ <bdi>{$m[3]}</bdi>", "نیشانەرەک (pointer) بە ناڤێ <bdi>{$m[2]}</bdi> دروست دکەت کو ئاماژەیە بو <bdi>{$m[3]}</bdi>");
    if (preg_match('/^\*(\w+)\s*=\s*(.+);\s*$/', $t, $m))
        return pair("بەهای شوێنەکەی نیشانەرەکە <bdi>{$m[1]}</bdi> دەگۆڕێت بۆ <bdi>{$m[2]}</bdi>", "بەهایا شوینێ نیشانەر <bdi>{$m[1]}</bdi> دگوهۆڕیت بو <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)->(\w+)/', $t, $m))
        return pair("دەستگەیشتن بە ئەندام/فەنکشنی <bdi>{$m[2]}</bdi> لە ڕێگەی نیشانەرەکەوە <bdi>{$m[1]}</bdi>", "دەستگەهشتنە ئەندام/فەنکشنا <bdi>{$m[2]}</bdi> ژ رێکا نیشانەر ڤە <bdi>{$m[1]}</bdi>");
    // vector
    if (preg_match('/^(\w+)\.push_back\((.+)\)\s*;\s*$/', $t, $m))
        return pair("بەهای <bdi>{$m[2]}</bdi> بۆ کۆتایی لیستی <bdi>{$m[1]}</bdi> زیاد دەکات", "بەهایا <bdi>{$m[2]}</bdi> بو دووماهیا لیستا <bdi>{$m[1]}</bdi> زێدە دکەت");
    if (preg_match('/^(\w+)\.size\(\)\s*;\s*$/', $t, $m))
        return pair("ژمارەی ئەندامەکانی <bdi>{$m[1]}</bdi> دەگەڕێنێتەوە", "ژمارا ئەندامان ژ <bdi>{$m[1]}</bdi> ڤەدگەڕینیتەڤە");
    if (preg_match('/^(\w+)\.empty\(\)\s*;\s*$/', $t, $m))
        return pair("پشکنینی بەتاڵی <bdi>{$m[1]}</bdi>", "پشکنینا بەتاڵییا <bdi>{$m[1]}</bdi>");
    // new
    if (preg_match('/^(\w+)\s*\*\s*(\w+)\s*=\s*new\s+(\w+)/', $t, $m))
        return pair("ئۆبژەکتێکی نوێ دروست دەکات لە <bdi>{$m[3]}</bdi> و بۆ <bdi>{$m[2]}</bdi> دایەپەڕێنێت", "ئۆبژەکتەکا نوی دروست دکەت ژ <bdi>{$m[3]}</bdi> و بو <bdi>{$m[2]}</bdi> دایەپەڕینیت");
    if (preg_match('/^delete\s+(\w+)/', $t, $m))
        return pair("ئازادکردنی یادگەی <bdi>{$m[1]}</bdi>", "ئازادکرنا بیرا <bdi>{$m[1]}</bdi>");
    // braces
    if ($t === "{") return pair("کردنەوەی بلۆکێک", "ڤەکرنا بلۆکەک");
    if ($t === "}") return pair("داخستنی بلۆکەکە", "داخستنا بلۆکی");
    // try/catch
    if (str_starts_with($t, "try")) return pair("دەستپێکی گەڵاڵەکردنی هەڵە (try)", "دەستپێکا هەوڵدانا خەلەتێ (try)");
    if (str_starts_with($t, "catch")) return pair("دەستگرتنی هەڵە (catch)", "گرتنا خەلەتێ (catch)");
    // generic expression statement
    if (preg_match('/^(.+);\s*$/', $t, $m)) {
        $e = l(trim($m[1]));
        return pair("ژمێرکردن: <bdi>$e</bdi>", "ژمێرکرن: <bdi>$e</bdi>");
    }
    $kw = l(preg_replace('/[^A-Za-z0-9_.]+/', ' ', $t));
    return pair("ئەم هێڵە بەکارهێنانی <bdi>$kw</bdi>", "ئەڤ هێلە بکارئینانا <bdi>$kw</bdi>");
}

// ---------- HTML ----------
function htmlExplain($line) {
    $t = trim($line);
    if ($t === "") return null;

    // comments
    if (preg_match('/^<!--(.*?)-->/', $t, $m)) {
        $c = l(trim($m[1]));
        if ($c === "") return pair("تێبینی — هیچ کاری ناکات", "تێبینی — هیچ کاری ناکەت");
        return pair("تێبینی: $c", "تێبینی: $c");
    }
    // doctype
    if (str_starts_with(strtoupper($t), "<!DOCTYPE"))
        return pair("پێناسەکردنی پەڕەکە وەک HTML5", "پێناسەکرنا پەڕەی وەکی HTML5");
    if (str_starts_with($t, "<meta")) {
        if (str_contains($t, "viewport"))
            return pair("پەڕەکە لەسەر مۆبایل و ئامێرە بچووکەکان باش نمایش دەکرێت (viewport)", "پەڕە ل سەر مۆبایل و ئامیرێن بچویک باش دیار دبیت (viewport)");
        if (preg_match('/charset\s*=\s*"([^"]+)"/', $t, $m))
            return pair("پیتەکانی پەڕەکە دیاری دەکات: <bdi>{$m[1]}</bdi> — پشتیوانی هەموو زمانەکان", "پیتێن پەڕەی دیاری دکەت: <bdi>{$m[1]}</bdi> — پشتیڤانایا هەمی زمانان");
        return pair("زانیاری (metadata) بۆ وێبگەڕ", "زانیاری (metadata) بو وێبگەر");
    }
    if (str_starts_with($t, "<link"))
        return pair("پەیوەندی بە فایلێکی دەرەکییەوە (وەک CSS)", "پەیوەندی ب فایلەکا دەرڤەیی ڤە (وەکی CSS)");
    if (str_starts_with($t, "<style"))
        return pair("بەشی CSS لەناو پەڕەکە: ستایلی ئەندامەکان لێرە دەنووسرێت", "بەشێ CSS د ناڤ پەڕەی دا: ستایلێن ئەندامان ڤیرە دەنڤیسرن");
    if (str_starts_with($t, "</style>"))
        return pair("کۆتایی بەشی CSS", "دووماهیا بەشێ CSS");
    if (str_starts_with($t, "<script"))
        return pair("بەشی JavaScript لەناو پەڕەکە", "بەشێ JavaScript د ناڤ پەڕەی دا");
    if (str_starts_with($t, "</script>"))
        return pair("کۆتایی بەشی JavaScript", "دووماهیا بەشێ JavaScript");

    $tagRe = '/<\/?([a-zA-Z0-9]+)([^>]*)>/';
    if (preg_match_all($tagRe, $t, $mm, PREG_SET_ORDER)) {
        $exps = [];
        foreach ($mm as $i => $tagM) {
            $tag = strtolower($tagM[1]);
            $attrs = trim($tagM[2]);
            $isClose = str_starts_with($tagM[0], "</");
            $exp = htmlTagExplanation($tag, $attrs, $isClose);
            $exps[] = $exp;
            if ($i >= 1) break;
        }
        return $exps[0];
    }

    // --- lines without HTML tags: JS / CSS-in-style / plain text ---
    // JS function
    if (preg_match('/^function\s+(\w+)\s*\((.*)\)\s*\{?$/', $t, $m)) {
        $args = l(trim($m[2]));
        if ($args === "")
            return pair("فەنکشنێکی JavaScript بە ناوی <bdi>{$m[1]}</bdi>", "فەنکشنەکا JavaScript بە ناڤێ <bdi>{$m[1]}</bdi>");
        return pair("فەنکشنێکی JavaScript بە ناوی <bdi>{$m[1]}</bdi> — وەردەگرێت: <bdi>$args</bdi>", "فەنکشنەکا JavaScript بە ناڤێ <bdi>{$m[1]}</bdi> — وەردگرت: <bdi>$args</bdi>");
    }
    if (preg_match('/^(const|let|var)\s+(\w+)\s*=\s*(.+);\s*$/', $t, $m))
        return pair("گۆڕاوێکی JavaScript بە ناوی <bdi>{$m[2]}</bdi> (بە <bdi>{$m[1]}</bdi>)", "گۆڕاوەکا JavaScript بە ناڤێ <bdi>{$m[2]}</bdi> (ب <bdi>{$m[1]}</bdi>)");
    if (preg_match('/^(\w+)\s*=\s*(\w+)\.getContext\(/', $t))
        return pair("دەستپێکردنی کێشان لەسەر canvas (<bdi>2d</bdi>)", "دەستپێکرنا کێشانێ ل سەر canvas (<bdi>2d</bdi>)");
    if (preg_match('/^(\w+)\.fillStyle\s*=\s*(.+);\s*$/', $t, $m))
        return pair("ڕەنگی پڕکردن دیاری دەکات: <bdi>{$m[2]}</bdi>", "ڕەنگێ پڕکرنێ دیاری دکەت: <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)\.fillRect\((.+)\)\s*;\s*$/', $t, $m))
        return pair("چوارگۆشەیەک دەکێشێت لە شوێنەکە: <bdi>({$m[2]})</bdi>", "چوارگۆشەک دکێشیت د شوینێ دا: <bdi>({$m[2]})</bdi>");
    if (preg_match('/^(\w+)\.font\s*=\s*(.+);\s*$/', $t, $m))
        return pair("فۆنتی دەقی کێشان دیاری دەکات: <bdi>{$m[2]}</bdi>", "فۆنتێ دەقی کێشانێ دیاری دکەت: <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)\.fillText\((.+)\)\s*;\s*$/', $t, $m))
        return pair("دەق دەکێشێت لەسەر canvas: <bdi>{$m[2]}</bdi>", "دەقی دکێشیت ل سەر canvas: <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)\.beginPath\(\)\s*;\s*$/', $t))
        return pair("دەستپێکی ڕێڕەوی کێشان", "دەستپێکا ڕێڕەوی کێشانێ");
    if (preg_match('/^(\w+)\.(moveTo|lineTo|arc|stroke|fill)\((.+)\)\s*;\s*$/', $t, $m))
        return pair("فەرمانی کێشان: <bdi>{$m[2]}({$m[3]})</bdi> لەسەر canvas", "فەرمانا کێشانێ: <bdi>{$m[2]}({$m[3]})</bdi> ل سەر canvas");
    if (preg_match('/^alert\((.+)\)\s*;?\s*$/', $t, $m))
        return pair("پەیامێک پیشانی بەکارهێنەر دەدات: <bdi>{$m[1]}</bdi>", "پەیامەک نیشانا بکارئینەری ددات: <bdi>{$m[1]}</bdi>");
    if (str_contains($t, "getElementById"))
        return pair("دەستگەیشتن بە ئەندامی HTML بە <bdi>id</bdi>-ەکەوە", "دەستگەهشتنە ئەندامێ HTML ب <bdi>id</bdi> ڤە");
    if (preg_match('/^(\w+)\.addEventListener\(/', $t))
        return pair("کارێک هەڵدەواسێت (مێشەکە) لەسەر ئەندامەکە", "کارەک هەلدواسیت (گەهەکە) ل سەر ئەندامی");
    if (preg_match('/^(\w+)\.innerHTML\s*=\s*(.+);\s*$/', $t, $m))
        return pair("ناوەڕۆکی ئەندامەکە دەگۆڕێت بۆ: <bdi>{$m[2]}</bdi>", "ناڤەڕۆکێ ئەندامی دگوهۆڕیت بو: <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)\.value\s*=\s*(.+);\s*$/', $t, $m))
        return pair("بەهای خانەکە دەگۆڕێت بۆ: <bdi>{$m[2]}</bdi>", "بەهایا خانەی دگوهۆڕیت بو: <bdi>{$m[2]}</bdi>");
    if (preg_match('/^(\w+)\.style\.(\w+)\s*=\s*(.+);\s*$/', $t, $m))
        return pair("ستایلی <bdi>{$m[2]}</bdi> دەگۆڕێت بۆ <bdi>{$m[3]}</bdi>", "ستایلێ <bdi>{$m[2]}</bdi> دگوهۆڕیت بو <bdi>{$m[3]}</bdi>");
    if (str_contains($t, ".dataset."))
        return pair("خوێندنەوەی داتای تایبەت (data-*) لە ئەندامەکە", "خواندنا داتایا تایبەت (data-*) ژ ئەندامی");
    if (preg_match('/^\}\s*$/', $t)) return pair("داخستنی بلۆکەکە", "داخستنا بلۆکی");
    if (str_starts_with($t, "}")) return pair("داخستنی بلۆکەکە", "داخستنا بلۆکی");
    // CSS inside <style> (single-line rules)
    if (preg_match('/^[^{}]+{[^{}]*}\s*$/', $t) || (str_contains($t, ":") && str_contains($t, ";")))
        return cssExplain($t);
    // plain text
    return pair("دەقی ئاسایی لە پەڕەکە: <bdi>" . l($t) . "</bdi>", "دەقی ئاسایی د پەڕەی دا: <bdi>" . l($t) . "</bdi>");
}

function htmlTagExplanation($tag, $attrs, $isClose) {
    $map = [
        "html" => ["دەستپێکی پەڕەی HTML", "دەستپێکا پەڕەی HTML"],
        "head" => ["سەری پەڕەکە: زانیاری بۆ وێبگەڕ (ناونیشان، ستایل، ...)", "سەری پەڕەی: زانیاری بو وێبگەر (ناونیشان، ستایل، ...)"],
        "body" => ["ناوەڕۆکی پەڕەکە: هەرچییەک لەسەر شاشە دەردەکەوێت لێرەیە", "ناڤەڕۆکی پەڕەی: چ ئەگەر ل سەر شاشێ دەرکەفیت ڤیرەیە"],
        "title" => ["ناونیشانی پەڕەکە لە نوارەی وێبگەڕ", "ناونیشانێ پەڕەی د نوارا وێبگەری"],
        "h1" => ["سەرنووسە: ناونیشانی سەرەکی پەڕەکە", "سەرنڤیس: ناونیشانێ سەرەکی یێ پەڕەی"],
        "h2" => ["سەرنووسەی نێوانە: بەشێکی پەڕەکە", "سەرنڤیسێ ناڤین: بەشەکێ پەڕەی"],
        "h3" => ["سەرنووسەی بچووک", "سەرنڤیسێ بچویک"],
        "h4" => ["سەرنووسەی بچووکتر", "سەرنڤیسێ بچویکتر"],
        "h5" => ["سەرنووسەی ورد", "سەرنڤیسێ هوری"],
        "h6" => ["بچووکترین سەرنووسە", "بچویکترین سەرنڤیس"],
        "p" => ["بڕگەیەکی دەق (پاراگراف)", "بەشەکە دەقی (پاراگراف)"],
        "b" => ["دەقی قەڵەو (bold)", "دەقی قەلەو (bold)"],
        "strong" => ["دەقی گرنگ و قەڵەو", "دەقی گرنگ و قەلەو"],
        "i" => ["دەقی لار (italic)", "دەقی لار (italic)"],
        "em" => ["دەقی لار بۆ گرنگیدان", "دەقی لار بو گرنگیدان"],
        "u" => ["دەقی ژێرهێڵکراو", "دەقی ژێرهێلکرای"],
        "mark" => ["دەقی دیارکراو (بە ڕەنگ دیارە)", "دەقی دیارکرای (ب ڕەنگ دیارە)"],
        "small" => ["دەقی بچووک", "دەقی بچویک"],
        "br" => ["پەڕاندن بۆ هێڵی نوێ", "پەڕاندن بو هێلەکا نوی"],
        "hr" => ["هێڵی جیاکەرەوە لە نێوان بەشەکان", "هێلەکا جیاکەرا د ناڤ بەشان دا"],
        "ul" => ["لیستی بێ ڕیزبەندی (خاڵ بە خاڵ)", "لیستا بێ ڕیزبەندی (خال ب خال)"],
        "ol" => ["لیستی ڕیزبەندکراو (ژمارەیی)", "لیستا ڕیزبەندکرای (ژمارەیی)"],
        "li" => ["ئەندامێکی لیستەکە", "ئەندامەکێ لیستی"],
        "a" => ["لینک/گرێدان بۆ پەڕەیەکی دیکە", "لینک/گرێدان بو پەڕەیەکا دیکە"],
        "img" => ["وێنەیەک لە پەڕەکە", "وێنەکە د پەڕەی دا"],
        "div" => ["سندوقێک کە ئەندامەکانی تێدا کۆ دەکرێنەوە", "سندوقەک کو ئەندام پێکڤە ددهنە ناڤێ"],
        "span" => ["بەشێکی بچووکی دەق/ئەندام", "بەشەکێ بچویکی دەقی/ئەندام"],
        "header" => ["سەرەوەی پەڕەکە یان بەشەکە (سەرنووسەکان)", "سەرەوی پەڕەی یان بەشی (سەرنڤیس)"],
        "nav" => ["بەشی گەڕان/ناڤیگەیشن (لینکەکان)", "بەشێ گەڕان/ناڤیگەیشن (لینک)"],
        "main" => ["ناوەڕۆکی سەرەکی پەڕەکە", "ناڤەڕۆکێ سەرەکی یێ پەڕەی"],
        "section" => ["بەشێکی پەڕەکە", "بەشەکێ پەڕەی"],
        "article" => ["وتار/بەشێکی سەربەخۆ", "وتار/بەشەکا سەربەخۆ"],
        "aside" => ["بەشی لاوەکی پەڕەکە", "بەشێ لاوەکی یێ پەڕەی"],
        "footer" => ["ژێرەوەی پەڕەکە", "ژێرەوی پەڕەی"],
        "button" => ["دۆکمەیەک بۆ کرتەکردن", "دوکمەکە بو کرتەکرنێ"],
        "input" => ["خانەیەک بۆ نووسینی بەکارهێنەر", "خانەکە بو نڤیسینا بکارئینەری"],
        "form" => ["فۆرم: داتا بۆ ڕاژەکار دەنێرێت", "فۆرم: داتا بو ڕاژەکار دشینیت"],
        "label" => ["ناونیشان بۆ خانەیەکی فۆرم", "ناونیشان بو خانەکا فۆرمی"],
        "select" => ["لیستی هەڵبژاردن (dropdown)", "لیستا هەلبژارتنێ (dropdown)"],
        "option" => ["هەڵبژاردەیەک لە لیستەکە", "هەلبژارتیەکە د لیستێ دا"],
        "textarea" => ["خانەی دەقی فرەهێڵی", "خانەکا دەقی یا فرەهێل"],
        "table" => ["خشتەیەک", "خشتەکە"],
        "tr" => ["ڕیزێک لە خشتەکە", "ڕیزەکا د خشتەی دا"],
        "td" => ["خانەیەکی زانیاری لە خشتەکە", "خانەکە داتای د خشتەی دا"],
        "th" => ["سەرنووسەی خانەی خشتەکە", "سەرنڤیسێ خانەیا خشتەی"],
        "thead" => ["سەری خشتەکە", "سەری خشتەی"],
        "tbody" => ["ناوەڕۆکی خشتەکە", "ناڤەڕۆکێ خشتەی"],
        "tfoot" => ["ژێرەوەی خشتەکە", "ژێرەوی خشتەی"],
        "video" => ["ڤیدیۆیەک", "ڤیدیۆیەک"],
        "audio" => ["دەنگییەک", "دەنگەک"],
        "iframe" => ["پەڕەیەکی دیکە لەناو چوارچێوەیەکدا نمایش دەکات", "پەڕەیەکا دیکە د ناڤ چوارچێوەیەک دا نیشان ددات"],
        "figure" => ["وێنە/ناوەڕۆکێک بە سەرنووسەوە", "وێنە/ناڤەڕۆکەک دگەل سەرنڤیس"],
        "figcaption" => ["سەرنووسەی وێنەکە", "سەرنڤیسێ وێنەی"],
        "blockquote" => ["وتەیەک لە شوێنێکی دیکە", "وتەکە ژ شوینەکێ دیکە"],
        "pre" => ["دەقی پێشفرماتکراو (کۆد)", "دەقی پێشفرماتکرای (کۆد)"],
        "code" => ["دەقی کۆد", "دەقی کۆد"],
        "details" => ["بەشێک کە دەکرێتەوە/داخرێت", "بەشەک کو ڤەدبیت/ددهیت"],
        "summary" => ["ناونیشانی بەشی details", "ناونیشانێ بەشێ details"],
        "svg" => ["وێنەی ڤێکتەری (SVG)", "وێنەکا ڤێکتەری (SVG)"],
        "rect" => ["چوارگۆشەیەک لە وێنەکە (SVG)", "چوارگۆشەک د وێنەی دا (SVG)"],
        "circle" => ["بازنەیەک لە وێنەکە (SVG)", "بازنەکە د وێنەی دا (SVG)"],
        "ellipse" => ["هێلکەیی (elipse) لە وێنەکە (SVG)", "هێلکەیی (elipse) د وێنەی دا (SVG)"],
        "line" => ["هێڵێک لە وێنەکە (SVG)", "هێلەکە د وێنەی دا (SVG)"],
        "polygon" => ["فرەگۆشەیەک لە وێنەکە (SVG)", "فرەگۆشەک د وێنەی دا (SVG)"],
        "path" => ["ڕێڕەو/هێڵێکی ئازاد (SVG)", "ڕێڕەو/هێلەکا ئازاد (SVG)"],
        "text" => ["دەق لە وێنەکە (SVG)", "دەق د وێنەی دا (SVG)"],
        "canvas" => ["تەختی کێشان (canvas) — JS دەتوانێت تێیدا بکێشێت", "تەختێ کێشانێ (canvas) — JS دکەڤیت تێدا بکێشیت"],
        "head" => ["سەری پەڕەکە", "سەری پەڕەی"],
    ];
    if (isset($map[$tag])) {
        $so = $map[$tag][0];
        $ba = $map[$tag][1];
    } else {
        $so = "تەگی <bdi>&lt;$tag&gt;</bdi> بۆ بەشێکی ناوەڕۆک";
        $ba = "تەگێ <bdi>&lt;$tag&gt;</bdi> بو بەشەکا ناڤەڕۆکی";
    }
    if ($isClose) {
        return pair("داخستنی تەگی <bdi>&lt;$tag&gt;</bdi>", "داخستنا تەگێ <bdi>&lt;$tag&gt;</bdi>");
    }
    // attribute extras
    if (str_contains($attrs, "href")) {
        if (preg_match('/href\s*=\s*"([^"]+)"/', $attrs, $m))
            return pair("لینکێکە بۆ <bdi>" . l($m[1]) . "</bdi>", "لینکەکە بو <bdi>" . l($m[1]) . "</bdi>");
        return pair("لینکێکە (href)", "لینکەکە (href)");
    }
    if (str_contains($attrs, "src")) {
        if (preg_match('/src\s*=\s*"([^"]+)"/', $attrs, $m))
            return pair("وێنە/ناوەڕۆک لە <bdi>" . l($m[1]) . "</bdi>", "وێنە/ناڤەڕۆک ژ <bdi>" . l($m[1]) . "</bdi>");
    }
    if (str_contains($attrs, "type")) {
        if (preg_match('/type\s*=\s*"([^"]+)"/', $attrs, $m)) {
            $ty = l($m[1]);
            if ($ty === "text") return pair("خانەی نووسینی سادە", "خانەکا نڤیسینا سادە");
            if ($ty === "password") return pair("خانەی نهێنی (پەنهان)", "خانەکا نهێنی (پەنهان)");
            if ($ty === "email") return pair("خانەی ئیمەیڵ", "خانەکا ئیمەیڵ");
            if ($ty === "number") return pair("خانەی ژمارە", "خانەکا ژمارەی");
            if ($ty === "submit") return pair("دۆکمەی ناردنی فۆرمەکە", "دوکمەیا شاندنا فۆرمی");
            if ($ty === "button") return pair("دۆکمەیەکی سادە", "دوکمەکا سادە");
            if ($ty === "checkbox") return pair("خانەی نیشانکردن (checkbox)", "خانەکا نیشانکرنێ (checkbox)");
            if ($ty === "radio") return pair("خانەی هەڵبژاردنی یەکێک", "خانەکا هەلبژارتنە یا یەکێ");
            if ($ty === "file") return pair("هەڵبژاردنی فایل", "هەلبژارتنا فایل");
            return pair("خانەی فۆرم بە جۆری <bdi>$ty</bdi>", "خانەکا فۆرمی ب جۆرێ <bdi>$ty</bdi>");
        }
    }
    if (str_contains($attrs, "placeholder"))
        return pair("خانەی نووسین بە دەقی ڕێنمایی", "خانەکا نڤیسینێ ب دەقی ڕێنڤیسی");
    return pair($so, $ba);
}

// ---------- CSS ----------
function cssExplain($line) {
    $t = trim($line);
    if ($t === "") return null;

    if (str_starts_with($t, "/*")) {
        $c = l(trim(preg_replace('/\/\*\s*|\s*\*\//', ' ', $t)));
        if ($c === "") return pair("تێبینی (comment)", "تێبینی (comment)");
        return pair("تێبینی: $c", "تێبینی: $c");
    }
    // strip trailing inline comment
    $t = trim(preg_replace('/\/\*.*?\*\/\s*$/s', '', $t));
    // custom properties (CSS variables)
    if (preg_match('/^(--[\w-]+)\s*:\s*(.+?)\s*;?\s*$/', $t, $m))
        return pair("گۆڕاوی CSS (custom property): بە ناوی <bdi>{$m[1]}</bdi> و بەهای <bdi>{$m[2]}</bdi>", "گۆڕاڤا CSS (custom property): بە ناڤێ <bdi>{$m[1]}</bdi> و بەهایا <bdi>{$m[2]}</bdi>");
    // media query
    if (preg_match('/^@media\s+(.+?)\s*\{?\s*$/', $t, $m)) {
        $cond = l(trim($m[1]));
        return pair("ئەم یاسایانە تەنها کاتێک جێبەجێ دەبن کە شاشەکە بەم مەرجە بێت: <bdi>$cond</bdi>", "ئەڤ یاسای تەنها دەمێ جێبەجێ دبن کو شاش ب ڤی مەرجی بیت: <bdi>$cond</bdi>");
    }
    if (preg_match('/^@\w+/', $t, $m))
        return pair("فەرمانی CSS تایبەت (<bdi>{$m[0]}</bdi>)", "فەرمانا CSS تایبەت (<bdi>{$m[0]}</bdi>)");
    // keyframes
    if (preg_match('/^@keyframes\s+(\w+)/', $t, $m))
        return pair("ئەنیمەیشنێک دروست دەکات بە ناوی <bdi>{$m[1]}</bdi>", "ئەنیمەیشنەک دروست دکەت بە ناڤێ <bdi>{$m[1]}</bdi>");
    // selector continuation (multi-line selector)
    if (preg_match('/^([^{},]+),\s*$/', $t, $m)) {
        $sel = l(trim($m[1]));
        $hv = "";
        if (str_ends_with(trim($m[1]), ":hover")) $hv = " (هۆڤەر)";
        return pair("سێلێکتەرەکە بەردەوامە لە هێڵی داهاتوو: <bdi>$sel</bdi>$hv", "سێلێکتەر ل هێلەکا داهاتی دا بەردەوامە: <bdi>$sel</bdi>$hv");
    }
    // selector
    if (preg_match('/([^{}]+)\{\s*$/', $t, $m)) {
        $sel = l(trim($m[1]));
        if ($sel === "*")
            return pair("ئەم یاسایە بۆ هەموو ئەندامەکانی پەڕەکە جێبەجێ دەبێت", "ئەڤ یاسا بو هەمی ئەندامێن پەڕەی جێبەجێ دبیت");
        if ($sel === ":root")
            return pair("ئەم یاسایە بۆ هەموو پەڕەکە جێبەجێ دەبێت — گۆڕاوە گشتییەکانی CSS لێرە دانراون", "ئەڤ یاسا بو هەمی پەڕەی جێبەجێ دبیت — گۆڕاڤێن گشتی یێن CSS ڤیرە داناین");
        $selSo = $sel;
        $selBa = $sel;
        if (str_ends_with($sel, ":hover"))
            return pair("کاتێک کرسرە (mouse) لەسەر <bdi>$sel</bdi> دەنێرێت", "دەمێ کرسرە (mouse) ل سەر <bdi>$sel</bdi> دەنێرینیت");
        if (str_ends_with($sel, ":focus"))
            return pair("کاتێک <bdi>$sel</bdi> فۆکەس دەگرێت (بە کلیک یان تەب)", "دەمێ <bdi>$sel</bdi> فۆکەس دگرت (ب کلیک یان تەب)");
        if (str_ends_with($sel, ":first-child"))
            return pair("کاتێک ئەندامەکە یەکەم منداڵە — بۆ <bdi>$sel</bdi>", "دەمێ ئەندام یەکەم زارۆکە — بو <bdi>$sel</bdi>");
        if (str_ends_with($sel, ":nth-child("))
            return pair("ئەندامەکان بەپێی ژمارەکەیان — <bdi>$sel</bdi>", "ئەندام ل گورە ژمارا خوە — <bdi>$sel</bdi>");
        return pair("ئەم یاسایە بۆ <bdi>$selSo</bdi> بەکاردێت", "ئەڤ یاسا بو <bdi>$selBa</bdi> بکارتیت");
    }
    // property
    if (preg_match('/^([a-zA-Z][\w-]*)\s*:\s*(.+?)\s*;\s*$/', $t, $m)) {
        $prop = strtolower($m[1]);
        $val = l(trim($m[2]));
        $pmap = [
            "color" => ["ڕەنگی دەق", "ڕەنگێ دەقی"],
            "background" => ["پاشبنەمای ئەندامەکە", "پاشبەما یا ئەندامی"],
            "background-color" => ["ڕەنگی پاشبنەما", "ڕەنگێ پاشبەمای"],
            "background-image" => ["وێنەی پاشبنەما", "وێنەیا پاشبەمای"],
            "background-size" => ["قەبارەی وێنەی پاشبنەما", "قەبارا وێنەیا پاشبەمای"],
            "background-position" => ["شوێنی وێنەی پاشبنەما", "شوینێ وێنەیا پاشبەمای"],
            "background-repeat" => ["دووبارەبوونەوەی وێنەی پاشبنەما", "دوبارەبونەیا وێنەیا پاشبەمای"],
            "font-size" => ["قەبارەی دەق", "قەبارا دەقی"],
            "font-family" => ["فۆنتی دەق", "فۆنتێ دەقی"],
            "font-weight" => ["ستووری دەق", "ستوریا دەقی"],
            "font-style" => ["شێوازی دەق (لار و ...)", "شێوازێ دەقی (لار و ...)"],
            "line-height" => ["بەرزی هێڵی دەق", "بەرزیا هێلێ دەقی"],
            "text-align" => ["ڕیزکردنی دەق (چەپ/ڕاست/ناوەند)", "ڕیزکرنا دەقی (چەپ/ڕاست/ناڤەند)"],
            "text-decoration" => ["ڕازاندنەوەی دەق (ژێرهێڵ و ...)", "ڕازاندنا دەقی (ژێرهێل و ...)"],
            "text-transform" => ["گۆڕینی جۆری پیتەکان (گەورە/بچووک)", "گوهۆڕینا جۆرێ پیتان (مەزن/بچویک)"],
            "letter-spacing" => ["بۆشایی نێوان پیتەکان", "بۆشایا د ناڤ پیتان دا"],
            "word-spacing" => ["بۆشایی نێوان وشەکان", "بۆشایا د ناڤ ڤەکان دا"],
            "white-space" => ["ڕێزی هەڵگرتن بۆ بۆشایی و هێڵەکان", "ڕێزا هلگرتنێ بو بۆشایی و هێلان"],
            "margin" => ["بۆشایی دەرەوە (لە دەرەوەی کەنارەکە)", "بۆشایا دەرڤەیی (ژ دەرڤەی کەنار)"],
            "margin-top" => ["بۆشایی لە سەرەوە", "بۆشایا ژ سەرڤە"],
            "margin-bottom" => ["بۆشایی لە خوارەوە", "بۆشایا ژ خارڤە"],
            "margin-left" => ["بۆشایی لە چەپەوە", "بۆشایا ژ چەپڤە"],
            "margin-right" => ["بۆشایی لە ڕاستەوە", "بۆشایا ژ ڕاستڤە"],
            "margin-top" => ["بۆشایی لە سەرەوە", "بۆشایا ژ سەرڤە"],
            "padding" => ["بۆشایی ناوەوە (لە ناوەوەی کەنارەکە)", "بۆشایا ناڤخۆ (د ناڤ کەناری دا)"],
            "padding-top" => ["بۆشایی ناوەوە لە سەرەوە", "بۆشایا ناڤخۆ ژ سەرڤە"],
            "padding-bottom" => ["بۆشایی ناوەوە لە خوارەوە", "بۆشایا ناڤخۆ ژ خارڤە"],
            "padding-left" => ["بۆشایی ناوەوە لە چەپەوە", "بۆشایا ناڤخۆ ژ چەپڤە"],
            "padding-right" => ["بۆشایی ناوەوە لە ڕاستەوە", "بۆشایا ناڤخۆ ژ ڕاستڤە"],
            "width" => ["پانی ئەندامەکە", "پانیا ئەندامی"],
            "height" => ["بەرزی ئەندامەکە", "بەرزیا ئەندامی"],
            "min-width" => ["کەمترین پانی", "کێمترین پانی"],
            "max-width" => ["زۆرترین پانی", "زێدەترین پانی"],
            "min-height" => ["کەمترین بەرزی", "کێمترین بەرزی"],
            "max-height" => ["زۆرترین بەرزی", "زێدەترین بەرزی"],
            "box-sizing" => ["شێوازی ژمێرکردنی قەبارە (padding لەگەڵ پانی)", "شێوازێ ژمێرکرنا قەبارێ (padding دگەل پانی)"],
            "display" => ["جۆری پیشاندانی ئەندامەکە", "جۆرێ نیشاندانا ئەندامی"],
            "flex" => ["ڕێکخستنی flex (نەرمی ئەندامەکە)", "ڕێکخستنا flex (نەرما ئەندامی)"],
            "flex-direction" => ["ئاراستەی ڕێکخستنی flex (ڕیز/ستوون)", "ئاراستا ڕێکخستنا flex (ڕیز/ستوون)"],
            "flex-wrap" => ["گەڕانەوە بۆ هێڵی نوێ کاتێک بۆشایی نەما", "ڤەگەڕان بو هێلەکا نوی دەمێ بۆشای نەما"],
            "flex-grow" => ["چەندە لە بۆشایی زیادە وەردەگرێت", "چەندە ژ بۆشایا زێدە وەردگرت"],
            "flex-shrink" => ["چەندە دەبچووکێتەوە کاتێک بۆشایی کەمە", "چەندە دبچویکیتەڤە دەمێ بۆشای کێمە"],
            "flex-basis" => ["قەبارەی بنەڕەتی لە flex", "قەبارا بنەڕەتی د flex دا"],
            "justify-content" => ["ڕێکخستنی ئەندامەکان بە درێژایی ئاراستەی سەرەکی", "ڕێکخستنا ئەندامان د درێژییا ئاراستا سەرەکی دا"],
            "align-items" => ["ڕێکخستنی ئەندامەکان بە درێژایی ئاراستەی لاوەکی", "ڕێکخستنا ئەندامان د درێژییا ئاراستا لاوەکی دا"],
            "align-self" => ["ڕێکخستنی ئەم ئەندامە بە تەنیا", "ڕێکخستنا ڤی ئەندامی ب تەنیا"],
            "gap" => ["بۆشایی نێوان ئەندامەکان", "بۆشایا د ناڤ ئەندامان دا"],
            "row-gap" => ["بۆشایی نێوان ڕیزەکان", "بۆشایا د ناڤ ڕیزان دا"],
            "column-gap" => ["بۆشایی نێوان ستوونەکان", "بۆشایا د ناڤ ستوونان دا"],
            "grid-template-columns" => ["ستوونەکانی grid دیاری دەکات", "ستوونێن grid دیاری دکەت"],
            "grid-template-rows" => ["ڕیزەکانی grid دیاری دەکات", "ڕیزێن grid دیاری دکەت"],
            "grid-template-areas" => ["ناوچەکانی grid دیاری دەکات", "ناڤچێن grid دیاری دکەت"],
            "grid-column" => ["شوێنی ئەندامەکە لە ستوونەکانی grid", "شوینێ ئەندامی د ستوونێن grid دا"],
            "grid-row" => ["شوێنی ئەندامەکە لە ڕیزەکانی grid", "شوینێ ئەندامی د ڕیزێن grid دا"],
            "place-items" => ["ڕێکخستنی ئەندامەکان (ستوون و ڕیز پێکەوە)", "ڕێکخستنا ئەندامان (ستوون و ڕیز پێکڤە)"],
            "place-content" => ["ڕێکخستنی ناوەڕۆکەکە بە هەردوو ئاراستە", "ڕێکخستنا ناڤەڕۆکی ب هەردوو ئاراستا"],
            "border" => ["کەنار/لێواری ئەندامەکە", "کەنار/لێوارا ئەندامی"],
            "border-top" => ["لێواری سەرەوە", "لێوارا سەرڤە"],
            "border-bottom" => ["لێواری خوارەوە", "لێوارا خارڤە"],
            "border-left" => ["لێواری چەپ", "لێوارا چەپ"],
            "border-right" => ["لێواری ڕاست", "لێوارا ڕاست"],
            "border-radius" => ["گۆشە خواراوەکانی کەنارەکە", "گۆشێن خوارای کەناری"],
            "border-width" => ["ئەستووری کەنارەکە", "ئەستوریا کەناری"],
            "border-style" => ["شێوازی کەنارەکە (پتەو/خاڵ و ...)", "شێوازێ کەناری (پتەو/خال و ...)"],
            "border-color" => ["ڕەنگی کەنارەکە", "ڕەنگێ کەناری"],
            "box-shadow" => ["سێبەری ئەندامەکە", "سیبەرێ ئەندامی"],
            "outline" => ["کەناری دەرەکی (بەبێ کارکردن لەسەر قەبارە)", "کەنارا دەرڤەیی (بێ کارکرن ل سەر قەبارێ)"],
            "position" => ["شێوازی شوێندانان (relative/absolute/...)", "شێوازێ شوێندانێ (relative/absolute/...)"],
            "top" => ["دووری لە سەرەوە", "دوریا ژ سەرڤە"],
            "right" => ["دووری لە ڕاستەوە", "دوریا ژ ڕاستڤە"],
            "bottom" => ["دووری لە خوارەوە", "دوریا ژ خارڤە"],
            "left" => ["دووری لە چەپەوە", "دوریا ژ چەپڤە"],
            "z-index" => ["چینی ئەندامەکە (لەسەر/لە خوارەوە)", "چینێ ئەندامی (ل سەر/ل خار)"],
            "float" => ["لەرەوە بۆ لایەک (ڕاست/چەپ)", "لەرەڤە بو لایەک (ڕاست/چەپ)"],
            "clear" => ["ڕاگرتنی کاری float", "ڕاگرتنا کاری float"],
            "overflow" => ["ڕەفتار لەگەڵ ناوەڕۆکی زیادە (وەستاندن/هەڵگەڕان)", "ڕەفتار دگەل ناڤەڕۆکێ زێدە (وەستاندن/هلگەڕان)"],
            "overflow-x" => ["ڕەفتار لەگەڵ زیادەی ئاسۆیی", "ڕەفتار دگەل زێدەیا ئاسۆیی"],
            "overflow-y" => ["ڕەفتار لەگەڵ زیادەی ستوونی", "ڕەفتار دگەل زێدەیا ستوونی"],
            "opacity" => ["ڕوونی ئەندامەکە (0 بێ دیارە)", "ڕوونیا ئەندامی (0 بێ دیار)"],
            "visibility" => ["بینینی ئەندامەکە", "دیتنا ئەندامی"],
            "cursor" => ["شێوازی کرسرە لەسەر ئەندامەکە", "شێوازێ کرسرێ ل سەر ئەندامی"],
            "transform" => ["گۆڕینی شێوە (خولانەوە/گەورەکردن و ...)", "گوهۆڕینا شێوێ (خولاندن/مەزنکرن و ...)"],
            "transition" => ["گواستنەوەی نەرم لە نێوان ستایلەکان", "گواستنا نەرم د ناڤ ستایلان دا"],
            "animation" => ["ئەنیمەیشنێک بۆ ئەندامەکە", "ئەنیمەیشنەک بو ئەندامی"],
            "object-fit" => ["چۆنیەتی گونجاندنی وێنە لەناو چوارچێوەکە", "چۆناتی گونجاندنا وێنەی د ناڤ چوارچێوەی دا"],
            "list-style" => ["ستایلی خاڵەکانی لیست", "ستایلێ خالێن لیستی"],
            "list-style-type" => ["جۆری نیشانەکانی لیست", "جۆرێ نیشانێن لیستی"],
            "content" => ["ناوەڕۆکی ئەندامەکە (بۆ ::before/::after)", "ناڤەڕۆکێ ئەندامی (بو ::before/::after)"],
            "float" => ["لەرەوە بۆ لایەک", "لەرەڤە بو لایەک"],
            "filter" => ["پاڵاوتنی وێنە (ڕەنگ و ...)", "پاڵاوتنا وێنەی (ڕەنگ و ...)"],
            "outline" => ["کەناری دەرەکی", "کەنارا دەرڤەیی"],
            "vertical-align" => ["ڕیزکردنی ستوونی", "ڕیزکرنا ستوونی"],
            "user-select" => ["هەڵبژاردنی دەق لەلایەن بەکارهێنەر", "هەلبژارتنا دەقی ژ لایێ بکارئینەر"],
            "pointer-events" => ["وەرگرتنی کرتەکانی کرسرە", "وەرگرتنا کرتێن کرسرێ"],
        ];
        if (isset($pmap[$prop]))
            return pair($pmap[$prop][0] . " (بەهای <bdi>$val</bdi>)", $pmap[$prop][1] . " (بەهایا <bdi>$val</bdi>)");
        return pair("تایبەتمەندی <bdi>$prop</bdi>: بەهای <bdi>$val</bdi>", "تایبەتمەندییا <bdi>$prop</bdi>: بەهایا <bdi>$val</bdi>");
    }
    // single-line rule: selector { prop: val; ... }
    if (preg_match('/^([^{}]+)\{([^{}]*)\}\s*$/', $t, $m)) {
        $sel = l(trim($m[1]));
        $body = trim($m[2]);
        $extra = "";
        if (preg_match('/^([a-zA-Z][\w-]*)\s*:\s*([^;]+);/', $body, $pm))
            $extra = " — یەکەم تایبەتمەندی: <bdi>{$pm[1]}</bdi>";
        if (str_ends_with($sel, ":hover"))
            return pair("کاتێک کرسرە دەنێرێتە سەر <bdi>$sel</bdi>، ئەم ستایلە جێبەجێ دەبێت$extra", "دەمێ کرسرە دەنێرینیت سەر <bdi>$sel</bdi>، ئەڤ ستایل جێبەجێ دبیت$extra");
        if (str_ends_with($sel, ":focus"))
            return pair("کاتێک <bdi>$sel</bdi> فۆکەس دەگرێت، ئەم ستایلە جێبەجێ دەبێت$extra", "دەمێ <bdi>$sel</bdi> فۆکەس دگرت، ئەڤ ستایل جێبەجێ دبیت$extra");
        return pair("یاسایەکی CSS بۆ <bdi>$sel</bdi>$extra", "یاسایەکا CSS بو <bdi>$sel</bdi>$extra");
    }
    // closing brace
    if (preg_match('/^\}\s*$/', $t)) return pair("داخستنی بلۆکەکە", "داخستنا بلۆکی");
    if (preg_match('/^\}\s*,?/', $t) && str_contains($t, "{"))
        return pair("داخستن و کردنەوەی بلۆک (چەند سێلێکتەر)", "داخستن و ڤەکرنا بلۆکی (چەند سێلێکتەر)");
    $kw = l(preg_replace('/[^A-Za-z0-9_.:-]+/', ' ', $t));
    return pair("ئەم هێڵە بەکارهێنانی <bdi>$kw</bdi>", "ئەڤ هێلە بکارئینانا <bdi>$kw</bdi>");
}

// ---------- main ----------
$byLang = ["py" => "pyExplain", "cpp" => "cppExplain", "html" => "htmlExplain", "css" => "cssExplain"];
$extByLangId = [
    "-OypFoFNvHfBuaA2Uh7O" => "py",
    "-Oyrqajy5loFSFBPUgNi" => "cpp",
    "-OyrwFN0avjq2hhlCRO5" => "html",
    "-OyrwFaGbQ7K-1QnzHvq" => "css",
];

$stats = ["fallback" => 0, "lines" => 0, "patched" => 0];
$fallbackReport = [];
foreach ($d as $id => $l) {
    $fn = $byLang[$extByLangId[$l["langId"]]] ?? null;
    if (!$fn) continue;
    $lines = explode("\n", rtrim($l["code"], "\n"));
    $soArr = [];
    $baArr = [];
    foreach ($lines as $line) {
        $stats["lines"]++;
        $ex = $fn($line);
        if ($ex === null) { $soArr[] = ""; $baArr[] = ""; continue; }
        if (str_starts_with($ex[0], "ئەم هێڵە بەکارهێنانی") || str_starts_with($ex[1], "ئەڤ هێلە بکارئینانا")) {
            $stats["fallback"]++;
            $fallbackReport[] = "L{$l["order"]} [$l[langId]]: " . $line;
        }
        $soArr[] = $ex[0];
        $baArr[] = $ex[1];
    }
    $l["code_explain_so"] = $soArr;
    $l["code_explain_ba"] = $baArr;
    $toPatch[$id] = $l;
}

$mh = curl_multi_init();
$handles = [];
$batch = [];
foreach ($toPatch as $id => $l) {
    $ch = curl_init("$db/ferga_lessons/$id.json?auth=$token");
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST => "PATCH",
        CURLOPT_POSTFIELDS => json_encode($l, JSON_UNESCAPED_UNICODE),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_TIMEOUT => 60,
    ]);
    curl_multi_add_handle($mh, $ch);
    $handles[$id] = $ch;
    $stats["patched"]++;
    if (count($handles) >= 10) {
        do { curl_multi_exec($mh, $running); curl_multi_select($mh, 5); } while ($running);
        foreach ($handles as $hid => $hc) { curl_multi_remove_handle($mh, $hc); curl_close($hc); }
        $handles = [];
        echo ".";
    }
}
if ($handles) {
    do { curl_multi_exec($mh, $running); curl_multi_select($mh, 5); } while ($running);
    foreach ($handles as $hid => $hc) { curl_multi_remove_handle($mh, $hc); curl_close($hc); }
    echo ".";
}
curl_multi_close($mh);
echo "patched: {$stats["patched"]} lessons, lines: {$stats["lines"]}, fallback: {$stats["fallback"]}\n";
echo "--- fallback lines ---\n";
foreach ($fallbackReport as $r) echo $r . "\n";
