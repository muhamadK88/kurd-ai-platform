<?php
/*
 * fix_badini_content.php
 *
 * Corrects the Badini (Behdini/Kurmanji) text stored in Firebase.
 * Only values whose key ends in "_ba" are ever touched; every "_so"
 * (Sorani) value is left exactly as it is.
 *
 *   php fix_badini_content.php --dry     preview: counts + sample diffs, writes nothing
 *   php fix_badini_content.php --apply   apply and PATCH the live database
 *
 * A full backup lives in storage/backups/firebase-20260805/.
 */

$firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';
$nodes = ['courses', 'ai_tools', 'universities', 'academic_guide',
          'ferga_lessons', 'ferga_quizzes', 'questions', 'ferga_languages'];

$apply = in_array('--apply', $argv, true);
$dry   = !$apply;

/* ---------------------------------------------------------------------------
 * 1. Prompt leakage. Some challenge descriptions still carry the authoring
 *    prompt ("question in Badini:" / "question in Sorani:") as literal text.
 * ------------------------------------------------------------------------- */
$stripPrefix = '/^\s*پرسیار\s+ب[ەه]?\s*(بادینی|سۆرانی)\s*:\s*/u';

/* ---------------------------------------------------------------------------
 * 2. Sorani morphology -> Badini. Order matters: longest first.
 * ------------------------------------------------------------------------- */
$morph = [
    'لە ئێستادا' => 'ل ڤێ گاڤێ دا',
    'ئێستادا'    => 'ڤێ گاڤێ دا',
    'لەلایەن'    => 'ژ لایێ',
    'لەناو'      => 'د ناڤ',
    'لەسەر'      => 'ل سەر',
    ' لە '        => ' ل ',
    'دەتوانیت'   => 'دشێی',
    'دەکرێت'     => 'دهێتە کرن',
    'دەکەیت'     => 'دکەی',
    'دەکەین'     => 'دکەین',
    'دەردەخەین'  => 'دەردێخین',
    'دەگۆڕین'    => 'دگوهۆڕین',
    'دەبێت'      => 'دڤێت',
    'دەکات'      => 'دکەت',
    ' کە '        => ' کو ',
    'چۆنە'       => 'چەوایە',
    'چۆن '       => 'چەوا ',
    'یەکەمین'    => 'ئێکەمین',
    'یەکەم'      => 'ئێکەم',
    'ئێستا'      => 'نوکە',
];

/* ---------------------------------------------------------------------------
 * 3. Orthography: ر -> ڕ and ل -> ڵ where the phoneme requires it.
 *
 *    These MUST be anchored to the start of a word. Unanchored they would
 *    corrupt unrelated words that merely contain the same letters:
 *      پاراستن (protection) -> پاڕاستن   WRONG
 *      کرێکاران (workers)   -> کڕێکاران  WRONG
 *      زارووک  (child)      -> زاڕووک    WRONG
 *    The (?<!\p{Arabic}) lookbehind keeps them word-initial only.
 *
 *    Deliberately NOT normalised, because plain ل is correct Badini here:
 *      دگەل (with), بەلێ (but/yes), بەلاش (free)
 * ------------------------------------------------------------------------- */
$ortho = [
    'راست' => 'ڕاست',
    'رێک'  => 'ڕێک',
    'روو'  => 'ڕوو',
    'سال'  => 'ساڵ',
    'مال'  => 'ماڵ',
    'هەلبژ' => 'هەڵبژ',
];
/* applied after the word-initial pass; safe as plain substrings */
$orthoExtra = [
    'پشتراست' => 'پشتڕاست',
    'ماڵپەر'  => 'ماڵپەڕ',   // ماڵپەڕ (website) is always spelled with ڕ
];

/* ---------------------------------------------------------------------------
 * 4. Encoding: Arabic-script look-alikes and stray zero-width joiners that
 *    render as broken glyphs in the Kurdish font.
 * ------------------------------------------------------------------------- */
$encoding = [
    "\u{0647}\u{200C}" => 'ە',   // heh + ZWNJ  ->  ae
    'ك' => 'ک',                   // Arabic kaf  ->  Kurdish kaf
    'ي' => 'ی',                   // Arabic yeh  ->  Kurdish yeh
    'ھ' => 'ه',                   // heh doachashmee -> plain heh
    'ة' => 'ە',
    "\u{200C}" => '',             // any remaining ZWNJ
];

/* ---------------------------------------------------------------------------
 * 5. Fields that were written entirely (or almost entirely) in Sorani and
 *    need a real translation rather than a rule. Keyed by node + path.
 * ------------------------------------------------------------------------- */
$manual = [
 'academic_guide/-Oywl9dVJIfRzbFm6b-i/question_ba' =>
   'ئایا خواندنا ماستەر و دکتۆرایێ ل سەر وارێ زیرەکیا دەستکرد چەوایە؟',

 'academic_guide/-OyxqKf9YZG5z1V322tj/question_ba' =>
   'لقێن ژیرییا دەستکرد',

 'academic_guide/-OyxuEWnyTtH-oR1zB1U/question_ba' =>
   'ئایا باشترین کار و بوار چییە د بازاڕێ کاری دا؟',

 'academic_guide/-Oyxxj4AdFlY_LqVWokt/question_ba' =>
   'ئایا زیرەکیا دەستکرد ب هۆیا سێرڤەر و داتا سەنتەرێن زەبەلاح، مە تووشی قەیرانا ئاڤا ڤەخوارنێ و وزەیێ دکەت؟',

 'academic_guide/-OyxzaN9_LzTYrCC1pWU/question_ba' =>
   'ئەلگۆریتم چییە و بۆچی بیرکاری ستوونا سەرەکی یا زیرەکیا دەستکردە؟',

 'courses/-OyiNsr0WAMyLBSeGbKl/desc_ba' =>
   'ئەڤ کۆرسێ ڤیدیۆیی ژ ١٥ ڤیدیۆیان پێکدێت بۆ فێربوونا زمانێ بەرنامەسازیێ C# و چێکرنا سیستەمێ بڕێڤەبرنێ ب بکارئینانا SQL Server ل ئاستێ دەستپێکێ، ژ لایێ (With Hawbash) ڤە هاتیە ئامادەکرن. تێدا باس ژ وانەیێن دەستپێکێ یێن فێربوونا سی شارپ و چێکرنا سیستەمان دهێتە کرن ب زمانێ کوردی.',

 'ferga_lessons/-Oz2Fdlj7UsCDsyXF0vo/challenge_desc_ba' =>
   'دوو گۆڕاوان ب ناڤێن x و y چێکە و بهایێن 20 و 4 بدە وان. پاشان x ل سەر y دابەش بکە و ئەنجامی د گۆڕاوەکێ نوی دا ب ناڤێ result هەڵگرە و ب console.log چاپ بکە.',

 'ferga_lessons/-Oz2wwO78p5GdStMWI7t/title_ba' =>
   'خواندنا داتایان ب Scanner',

 'ferga_lessons/-Oz2wyaaw_aEhIadbwDj/quiz_question_ba' =>
   'کیژێ بۆ گەهشتنا ئێکەم ئەندامێ tuple بکاردئینی؟',

 'ferga_lessons/-Oz2wwyH0NDXYJiaZusY/content_ba' =>
   '<p>کۆنسترۆکتەر ئەو فەنکشنەیە کو دەمێ ئۆبجێکت چێدکەی ڕاستەوخۆ بانگ دبیت:</p>'
   . "<pre>class Book {\n    String title;\n    int pages;\n\n    Book(String title, int pages) {\n        this.title = title;\n        this.pages = pages;\n    }\n\n    void show() {\n        System.out.println(title + \" (\" + pages + \" rûpel)\");\n    }\n}</pre>"
   . '<p><code>this</code> ئاماژەیە بۆ گۆڕاوێن ڤی ئۆبجێکتی. ب <code>new</code> ئۆبجێکتەکێ نوی چێدکەی.</p>',

 // Python lesson: every code comment was written in Sorani
 'ferga_lessons/-OyxXQqKjiHmJLXjSFRk/content_ba' =>
   '<p><strong>کومێنت (Comment)</strong> ئەو دەقەیە کو پرۆگرام جێبەجێ ناکەت، بەلێ بۆ خواندنا کۆدی و ڕوونکرنا وی دهێتە بکارئینان.</p><p>' . "\n"
   . '</p><pre># ١. ئەڤە تێبینیەکا سادەیە ل سەر ئێک هێلی (دێڕ)' . "\n\n\n"
   . 'print("Hello")&nbsp; # ٢. دشێی تێبینیێ ل تەنیشتا کۆدی ژی بنڤێسی' . "\n\n\n"
   . '"""' . "\n" . '٣. ئەڤە تێبینیەکا فرەهێلییە (چەند دێڕ)' . "\n"
   . 'دشێی چەندین هێلان ڕوونکرنێ بنڤێسی' . "\n"
   . 'زۆرجار بۆ ڕوونکرنا درێژ دهێتە بکارئینان' . "\n" . '"""' . "\n\n\n"
   . '# با نموونەکا کرداری بکەین:' . "\n\n\n"
   . '# ناڤێ قوتابی (تێبینی: ل ڤێرێ گۆڕاوەکێ بۆ ناڤی چێدکەین)' . "\n"
   . 'name = "Ahmad"' . "\n\n\n"
   . '# چاپکرن (تێبینی: ل ڤێرێ بهایێ گۆڕاوی ل سەر شاشەیێ دەردێخین)' . "\n"
   . 'print(name)' . "\n"
   . '</pre><p>کومێنت باشترین هەڤڕێیێن پرۆگرامەرانن — کۆدێ خۆ بۆ دەمێ بەری ڕوون بکە!</p>',
];

/* ------------------------------------------------------------------------ */

$stats = [];
$samples = [];

function correct(string $v, string $fullPath, array &$stats, array &$samples): string
{
    global $stripPrefix, $morph, $ortho, $orthoExtra, $encoding, $manual;
    $orig = $v;

    if (isset($manual[$fullPath])) {
        $stats['manual rewrite'] = ($stats['manual rewrite'] ?? 0) + 1;
        return $manual[$fullPath];
    }

    $new = preg_replace($stripPrefix, '', $v);
    if ($new !== $v) { $stats['prompt-leak prefix'] = ($stats['prompt-leak prefix'] ?? 0) + 1; $v = $new; }

    foreach ($encoding as $a => $b) {
        $n = substr_count($v, $a);
        if ($n) { $stats["encoding $a"] = ($stats["encoding $a"] ?? 0) + $n; $v = str_replace($a, $b, $v); }
    }

    foreach ($morph as $a => $b) {
        $n = substr_count($v, $a);
        if ($n) { $stats["morph $a"] = ($stats["morph $a"] ?? 0) + $n; $v = str_replace($a, $b, $v); }
    }

    foreach ($ortho as $a => $b) {
        // word-initial only
        $v = preg_replace_callback('/(?<!\p{Arabic})' . preg_quote($a, '/') . '/u',
            function () use ($a, &$stats, $b) {
                $stats["ortho $a"] = ($stats["ortho $a"] ?? 0) + 1;
                return $b;
            }, $v);
    }

    foreach ($orthoExtra as $a => $b) {
        $n = substr_count($v, $a);
        if ($n) { $stats["ortho $a"] = ($stats["ortho $a"] ?? 0) + $n; $v = str_replace($a, $b, $v); }
    }

    if ($v !== $orig && count($samples) < 20) {
        $samples[] = [$fullPath, $orig, $v];
    }
    return $v;
}

function walkFix($data, string $path, string $node, array &$stats, array &$samples, int &$changed)
{
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            $data[$k] = walkFix($v, $path . '/' . $k, $node, $stats, $samples, $changed);
        }
        return $data;
    }
    if (is_string($data)) {
        $key = substr($path, strrpos($path, '/') + 1);
        if (substr($key, -3) === '_ba') {
            $full = $node . $path;
            $new = correct($data, $full, $stats, $samples);
            if ($new !== $data) { $changed++; }
            return $new;
        }
    }
    return $data;
}

$totalChanged = 0;
$payloads = [];

foreach ($nodes as $node) {
    $raw = @file_get_contents($firebaseUrl . $node . '.json');
    if ($raw === false) { fwrite(STDERR, "!! could not read $node\n"); continue; }
    $data = json_decode($raw, true);
    if ($data === null) { echo "$node: empty\n"; continue; }

    $changed = 0;
    $fixed = walkFix($data, '', $node, $stats, $samples, $changed);
    $totalChanged += $changed;
    printf("%-18s %4d field(s) changed\n", $node, $changed);
    if ($changed > 0) { $payloads[$node] = $fixed; }
}

echo str_repeat('=', 70), "\n";
echo "Rule hits:\n";
ksort($stats);
foreach ($stats as $k => $n) { printf("   %-28s %d\n", $k, $n); }
printf("\nTotal _ba fields changed: %d\n", $totalChanged);

echo "\nSample diffs:\n";
foreach ($samples as [$p, $a, $b]) {
    echo "--- $p\n";
    echo "  before: ", mb_substr(preg_replace('/\s+/u', ' ', $a), 0, 150), "\n";
    echo "  after : ", mb_substr(preg_replace('/\s+/u', ' ', $b), 0, 150), "\n";
}

if ($dry) {
    @mkdir('/tmp/ba_preview', 0777, true);
    foreach ($payloads as $node => $payload) {
        file_put_contents("/tmp/ba_preview/$node.json",
            json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
    echo "\nDRY RUN — nothing written. Payloads dumped to /tmp/ba_preview/.\n";
    echo "Re-run with --apply to push.\n";
    exit(0);
}

foreach ($payloads as $node => $payload) {
    $ch = curl_init($firebaseUrl . $node . '.json');
    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST  => 'PUT',
        CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 180,
    ]);
    $res  = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    printf("PUT %-18s HTTP %d %s\n", $node, $code, $code === 200 ? 'OK' : substr((string)$res, 0, 200));
}
echo "\nDone.\n";
