<?php
$u='https://ai-platform-adb1b-default-rtdb.firebaseio.com/';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='-OysGzfS5Qi08XHYs_FL';
function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo "Rust OK\n";
$lessons=[
[
  'order'=>'1',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'چییە Rust؟',
  'title_ba'=>'چ یە Rust؟',
  'subtitle_so'=>'دەستپێک لەگەڵ Rust و ناسینی زمانی سیستەم',
  'subtitle_ba'=>'دەستپێکرن ل گەل Rust و ناسینا زمانی سیستەم',
  'content_so'=>'<p><strong>Rust</strong> زمانێکی سیستەمی بەهێزە کە Memory Safety بەبێ Garbage Collector پێشکەش دەکات. لەلایەن Mozilla لە ٢٠١٠ دروستکراوە.</p><ul><li>خێرایی وەک C/C++</li><li>بەبێ هەڵەی حافیزە</li><li>WebAssembly، سیستەم، network</li></ul>',
  'content_ba'=>'<p><strong>Rust</strong> زمانەکەکا سیستەمی بهێز یە کو Memory Safety بەبێ GC پێشکەش دکەت.</p><ul><li>خێرایی وەک C/C++</li><li>بەبێ هەڵەیا حافیزەیێ</li><li>WebAssembly، سیستەم</li></ul>',
  'code'=>'fn main() {
    // چاپکردنی سڵاو
    println!("Silav Kurdistane!");
    // بەخێرهێنان
    println!("Xērhatî bo Rust!");
}',
  'example_output'=>'Silav Kurdistane!
Xêrhatî bo Rust!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Rust چی تایبەتمەندییەکی سەرەکی هەیە؟',
  'quiz_question_ba'=>'Rust چ تایبەتمەندییا سەرەکی هەیە؟',
  'quiz_options_so'=>['Memory Safety بەبێ GC', 'Garbage Collection', 'بۆ وێب تەنها', 'ئاسانترین زمان'],
  'quiz_options_ba'=>['Memory Safety بەبێ GC', 'Garbage Collection', 'بو وێب تەنها', 'Hêsantirîn ziman'],
  'quiz_correct'=>'0',
],

[
  'order'=>'2',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'گۆڕاوەکان و let',
  'title_ba'=>'گۆڕۆک û let',
  'subtitle_so'=>'گۆڕاوەکان بە let و گۆڕینیان بە mut',
  'subtitle_ba'=>'گۆڕۆک پێ let و گۆڕینا وان پێ mut',
  'content_so'=>'<p>لە Rust گۆڕاوەکان بە <code>let</code> دروست دەکرێن. بە default نەگۆڕ (immutable) ن — بۆ گۆڕین پێویستە <code>mut</code>:</p><pre>let x = 5;
let mut y = 10;
y = 20; // OK
// x = 6; // هەڵە!</pre>',
  'content_ba'=>'<p>د Rust دا گۆڕۆک پێ <code>let</code> drust dkêt. By default negör (immutable) — bO gorîn <code>mut</code> pêwîste:</p><pre>let x = 5;
let mut y = 10;
y = 20; // OK</pre>',
  'code'=>'fn main() {
    let nav = "Kurdistan";  // گۆڕێنەی نەگۆڕ (immutable)
    let mut hejmar = 5;     // mut: دەکرێت بگۆڕدرێت
    println!("{}", nav);
    hejmar += 3;            // گۆڕینی بەها
    println!("{}", hejmar);
}',
  'example_output'=>'Kurdistan
8',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
let x = 10;
let y = x + 5;
println!("{}", y);',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
let x = 10;
let y = x + 5;
println!("{}", y);',
  'quiz_options_so'=>['15', '10', '5', 'هەڵە'],
  'quiz_options_ba'=>['15', '10', '5', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'3',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'جۆرەکانی داتا',
  'title_ba'=>'Çeşnên Datayê',
  'subtitle_so'=>'جۆرە سەرتەکییەکان: i32, f64, bool, char و &str',
  'subtitle_ba'=>'چەشنێن سەرەتایی: i32, f64, bool, char و &str',
  'content_so'=>'<p>جۆرە سەرەتاییەکانی Rust: <code>i32</code>، <code>f64</code>، <code>bool</code>، <code>char</code>، <code>String</code>، <code>&str</code>.</p><pre>let n: i32 = 42;
let f: f64 = 3.14;
let b: bool = true;
let c: char = \'K\';</pre>',
  'content_ba'=>'<p>Çeşnên serêtayî yên Rust: <code>i32</code>، <code>f64</code>، <code>bool</code>، <code>char</code>، <code>String</code>.</p>',
  'code'=>'fn main() {
    let temen: i32 = 25;       // ژمارەی تەواو
    let bilindi: f64 = 1.75;   // ژمارەی کەسیر
    let nav: &str = "Azad";    // دەق
    let drust: bool = true;    // ڕاست یان هەڵە
    println!("{} temenî {}", nav, temen);
    println!("bilindî: {}", bilindi);
    println!("drust: {}", drust);
}',
  'example_output'=>'Azad temenî 25
bilindî: 1.75
drust: true',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
fn main() {
    let x = 5;
    x = 10;
    println!("{}", x);
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
fn main() {
    let x = 5;
    x = 10;
    println!("{}", x);
}',
  'expected_output_text'=>'10',
  'solution_code'=>'fn main() {
    let mut x = 5; // mut ziyad bike
    x = 10;
    println!("{}", x);
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'4',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'ئۆپەراتۆرەکان',
  'title_ba'=>'Operatorên',
  'subtitle_so'=>'ئۆپەراتۆرە بیرکارییەکان و جیاوازی دابەشکردن',
  'subtitle_ba'=>'ئۆپەراتۆرێن ماتەماتیکی و جیەوازیەیا دابەشکرنێ',
  'content_so'=>'<p>Rust ئۆپەراتۆرە ئاساییەکانی هەیە: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئاگاداربە: دابەشکردنی <code>i32 / i32</code> ژمارەی تەواو دەگەڕێنێتەوە.</p>',
  'content_ba'=>'<p>Rust operatorên: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. Hay be: <code>i32/i32</code> jimare tamam digerîne.</p>',
  'code'=>'fn main() {
    let a: i32 = 15;
    let b: i32 = 4;
    println!("{}", a + b);  // 19 — کۆکردنەوە
    println!("{}", a - b);  // 11 — لێدەرکردن
    println!("{}", a * b);  // 60 — لێکدان
    println!("{}", a / b);  // 3 — دابەش
    println!("{}", a % b);  // 3 — ماوە
    let c = a as f64 / b as f64;  // گۆڕین بۆ کەسیر
    println!("{:.2}", c);   // 3.75
}',
  'example_output'=>'19
11
60
3
3
3.75',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە قارەبووی ژمارەیەک بژمێرێت بە Rust.',
  'practice_question_ba'=>'Bernameyeke binivîse ko çargoşeya jimarekê bijmêre bi Rust.',
  'expected_output_text'=>'Qarebu(7) = 49',
  'solution_code'=>'fn main() {
    let n: i32 = 7;
    println!("Qarebu({}) = {}", n, n*n);
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'5',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'if/else',
  'title_ba'=>'if/else',
  'subtitle_so'=>'بڕیاردان بە if/else و ڕستە بەهاکان',
  'subtitle_ba'=>'بڕیاردانێ پێ if/else و ڕستەیێن بەها',
  'content_so'=>'<p>Rust مەرجی <code>if/else</code> هەیە. تایبەتی Rust: if دەتوانرێت وەک بەها بەکاربێت:</p><pre>let nrx = 85;
if nrx >= 90 { println!("Taqez"); }
else if nrx >= 60 { println!("Bas"); }
else { println!("Nekefte"); }</pre>',
  'content_ba'=>'<p>Rust mêrca <code>if/else</code> heye. Taybetî Rust: if dikare wek behe were bikaranîn.</p>',
  'code'=>'fn main() {
    let nrx = 85;  // نمرەی خوێندکار
    let asta = if nrx >= 90 { "Taqêz" }        // نمرەی زۆر باش
               else if nrx >= 70 { "Baş" }      // نمرەی باش
               else if nrx >= 50 { "Navend" }   // نمرەی ناوەند
               else { "Nekeftî" };              // نەکەوتوو
    println!("{}", asta);
}',
  'example_output'=>'Bas',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر nrx=45 بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'Ger nrx=45 be, çi tê çapkirin?',
  'quiz_options_so'=>['Nekefte', 'Navend', 'Bas', 'Taqez'],
  'quiz_options_ba'=>['Nekefte', 'Navend', 'Bas', 'Taqez'],
  'quiz_correct'=>'0',
],

[
  'order'=>'6',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'match',
  'title_ba'=>'match',
  'subtitle_so'=>'match: بەراوردکردن لەگەڵ نمونە',
  'subtitle_ba'=>'match: بەراوردکرنا ل گەل نمونە',
  'content_so'=>'<p><code>match</code> لە Rust وەک switch باشتر: هەموو حالەتەکان دەبێت پووشەبن:</p><pre>match n {
    1 => println!("Yek"),
    2 | 3 => println!("Du an se"),
    _ => println!("Tiştekî din"),
}</pre>',
  'content_ba'=>'<p><code>match</code> di Rust wek switch çêtir e: hemî halet divê tiji bin:</p>',
  'code'=>'fn main() {
    let roj = 3;
    match roj {  // بەراوردی ژمارەی ڕۆژ
        1 => println!("Dusem"),
        2 => println!("Sesem"),
        3 => println!("Çarşem"),
        4 => println!("Pencerşem"),
        5 => println!("İni"),
        _ => println!("Dawiya heftê"),  // حالەتی دێرین
    }
}',
  'example_output'=>'Çarşem',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
let x = 5;
match x { 1=>println!("yek"), 5=>println!("pênc"), _=>println!("din") }',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
let x = 5;
match x { 1=>println!("yek"), 5=>println!("pênc"), _=>println!("din") }',
  'quiz_options_so'=>['pênc', 'yek', 'din', 'هەڵە'],
  'quiz_options_ba'=>['pênc', 'yek', 'din', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'7',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی loop و while',
  'title_ba'=>'loop û while',
  'subtitle_so'=>'خولگەکانی loop و while',
  'subtitle_ba'=>'گەڕخستنێن loop و while',
  'content_so'=>'<p>Rust خولگەی <code>loop</code> (بێ مەرج)، <code>while</code>، و <code>for..in</code> هەیە:</p><pre>let mut n=0;
loop { n+=1; if n==5 { break; } }
while n>0 { n-=1; }</pre>',
  'content_ba'=>'<p>Rust gêrxistinên: <code>loop</code>، <code>while</code>، û <code>for..in</code>:</p>',
  'code'=>'fn main() {
    let mut n = 0;
    loop { n += 1; if n >= 5 { break; } }  // خولگەی بێ مەرج
    println!("loop: {}", n);
    let mut x = 10;
    while x > 0 { print!("{} ", x); x -= 3; } // هەتا مەرجەکە راستە
    println!();
}',
  'example_output'=>'loop: 5
10 7 4 1 ',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
fn main() {
    let mut n = 0;
    while n < 3 {
        println!("{}", n);
    }
}',
  'practice_question_ba'=>'Xeleta kodê bidoze:
fn main() {
    let mut n = 0;
    while n < 3 {
        println!("{}", n);
    }
}',
  'expected_output_text'=>'0
1
2',
  'solution_code'=>'fn main() {
    let mut n = 0;
    while n < 3 {
        println!("{}", n);
        n += 1; // n++ tune di Rust de, n+=1 bikar bîne
    }
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'8',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'for..in و Range',
  'title_ba'=>'for..in û Range',
  'subtitle_so'=>'for..in: خوارانەوە ژمارەکان و ئارراكان',
  'subtitle_ba'=>'for..in: خوولاندنا ژماران و ئارایان',
  'content_so'=>'<p><code>for..in</code> بۆ خولاندنی ئاراکان و range: <code>1..=5</code> (گونجاندنی) <code>1..5</code> (دەرجووی):</p><pre>for i in 1..=5 { println!("{}", i); }
for x in [10,20,30] { println!("{}", x); }</pre>',
  'content_ba'=>'<p><code>for..in</code> bO xolandina arrayan û range:</p>',
  'code'=>'fn main() {
    for i in 1..=5 { print!("{} ", i); }  // 1 بۆ 5
    println!();
    let bajer = ["Hewler", "Silemani", "Duhok"];  // ئاررای
    for (idx, b) in bajer.iter().enumerate() {
        println!("{}. {}", idx + 1, b);
    }
}',
  'example_output'=>'1 2 3 4 5 
1. Hewler
2. Silemani
3. Duhok',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
for i in 0..3 { print!("{} ", i); }',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
for i in 0..3 { print!("{} ", i); }',
  'quiz_options_so'=>['0 1 2 ', '0 1 2 3 ', '1 2 3 ', 'هەڵە'],
  'quiz_options_ba'=>['0 1 2 ', '0 1 2 3 ', '1 2 3 ', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'9',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'break و continue',
  'title_ba'=>'break û continue',
  'subtitle_so'=>'کۆنترۆڵی break و continue لە خولگە',
  'subtitle_ba'=>'کۆنترۆڵا break و continue ی د گەڕخستنێ',
  'content_so'=>'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
  'content_ba'=>'<p><code>break</code> gêrxistinê datestênit. <code>continue</code> gêrana niha têperde dike.</p>',
  'code'=>'fn main() {
    for i in 1..=10 {
        if i == 7 { break; }        // وەستاندنی خولگە لە 7
        if i % 2 == 0 { continue; } // تێپەڕاندنی جووتەکان
        print!("{} ", i);
    }
    println!();
}',
  'example_output'=>'1 3 5 ',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
for i in 1..=5 { if i==3 { continue; } print!("{} ",i); }',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
for i in 1..=5 { if i==3 { continue; } print!("{} ",i); }',
  'quiz_options_so'=>['1 2 4 5 ', '1 2 3 4 5 ', '1 2 ', 'هەڵە'],
  'quiz_options_ba'=>['1 2 4 5 ', '1 2 3 4 5 ', '1 2 ', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'10',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'فەنکشن',
  'title_ba'=>'Fanksiyonên',
  'subtitle_so'=>'فانکشن بە fn، پارامیتەر و گەڕانەوە',
  'subtitle_ba'=>'فانکشن پێ fn، پارامیتەر و ڤەگەرانە',
  'content_so'=>'<p>فەنکشن لە Rust بە <code>fn</code>. جۆری گەڕانەوە دیاری دەکرێت بە <code>-></code>:</p><pre>fn kot(a: i32, b: i32) -> i32 { a + b }
println!("{}", kot(3, 5)); // 8</pre>',
  'content_ba'=>'<p>Fanksiyonên di Rust de pê <code>fn</code>. Cureyê gerêdanê pê <code>-></code> diyar dike:</p>',
  'code'=>'fn kot(a: i32, b: i32) -> i32 { a + b }       // کۆکردنەوە
fn jote(n: i32) -> bool { n % 2 == 0 }         // پشکنینی جووت
fn xerhatî(nav: &str) -> String { format!("Silav, {}!", nav) }
fn main() {
    println!("{}", kot(4, 6));
    println!("{}", jote(7));
    println!("{}", xerhatî("Kurdistan"));
}',
  'example_output'=>'10
false
Silav, Kurdistan!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
fn giştî(a: i32, b: i32) -> i32 {
    return a + b;
    a * b
}',
  'practice_question_ba'=>'Xeleta kodê bidoze:
fn giştî(a: i32, b: i32) -> i32 {
    return a + b;
    a * b
}',
  'expected_output_text'=>'15',
  'solution_code'=>'fn giştî(a: i32, b: i32) -> i32 {
    a + b // return bê "return" keyword — an jî return bikar bîne û a*b jê bibe
}
fn main() { println!("{}", giştî(7,8)); }',
  'attempts_allowed'=>'5',
],

[
  'order'=>'11',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'Ownership (خاوەندایەتی)',
  'title_ba'=>'Ownership',
  'subtitle_so'=>'Ownership: خاوەندارێتی و گواستنەوە (move)',
  'subtitle_ba'=>'Ownership: خاوەندایەتی و گوهاستن (move)',
  'content_so'=>'<p>Ownership سیستەمی مانایەکی Rust یە. هەر بەها تەنها یەک خاوەندی هەیە. کاتی گواستنەوە (<code>move</code>) خاوەنی کۆن بەتاڵ دەبێت.</p>',
  'content_ba'=>'<p>Ownership sîstema bîranîna Rust e. Her behe tenê xawanekê heye. Dema veguhastinê (move) xawanê kevin betale dibe.</p>',
  'code'=>'fn main() {
    let s1 = String::from("Kurdistan");
    let s2 = s1;  // خاوەندارایی گواسترایەوە بۆ s2 (move)
    // println!("{}", s1);   // هەڵە! س1 ئەدی نابهێت بهکاربێت
    println!("{}", s2);
    let n1: i32 = 5;
    let n2 = n1;  // Copy — جۆرە سادەکان کۆپی دێن
    println!("{} {}", n1, n2);
}',
  'example_output'=>'Kurdistan
5 5',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە Rust کاتی move چ دەبێتە سەر گۆڕاوی کۆن؟',
  'quiz_question_ba'=>'Di Rust de gava move çi dibe bo giyorvaeka kevin?',
  'quiz_options_so'=>['بەتاڵ دەبێت (invalid)', 'کۆپی دەبێت', 'سفر دەبێت', 'نەگۆڕ دەمێنێتەوە'],
  'quiz_options_ba'=>['Betale dibe (invalid)', 'Copy dibe', 'Sifir dibe', 'Negör dimêne'],
  'quiz_correct'=>'0',
],

[
  'order'=>'12',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'References و Borrowing',
  'title_ba'=>'References û Borrowing',
  'subtitle_so'=>'References و Borrowing بەبێ move',
  'subtitle_ba'=>'References و Borrowing بەبێ move',
  'content_so'=>'<p>Reference (<code>&</code>) ڕێگەت دەدات بەبێ move بەها بەکاربهێنیت. ئەمە <strong>borrowing</strong>ە:</p><pre>fn drêjayî(s: &String) -> usize { s.len() }
let s = String::from("Kurd");
println!("{}", drêjayî(&s));
println!("{}", s); // هێشتا درووستە</pre>',
  'content_ba'=>'<p>Reference (<code>&</code>) bê move bikaranîna behe dide: <strong>borrowing</strong>:</p>',
  'code'=>'fn direjayî(s: &String) -> usize { s.len() }       // reference
fn mezin_bike(s: &mut String) { s.push_str(" bas!"); }  // reference داشڵ
fn main() {
    let s = String::from("Rust");
    println!("{}", direjayî(&s));  // بەکارهێنان بەبێ گوهاستن
    let mut t = String::from("Rust");
    mezin_bike(&mut t);
    println!("{}", t);
}',
  'example_output'=>'4
Rust baş e!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
fn test(s: &String) {
    s.push_str(" zede");
}
fn main() {
    let s = String::from("Kurd");
    test(&s);
    println!("{}", s);
}',
  'practice_question_ba'=>'Xeleta kodê bidoze:
fn test(s: &String) {
    s.push_str(" zede");
}
fn main() {
    let s = String::from("Kurd");
    test(&s);
    println!("{}", s);
}',
  'expected_output_text'=>'Kurd zede',
  'solution_code'=>'fn test(s: &mut String) { // &mut lazime bO guhartin
    s.push_str(" zede");
}
fn main() {
    let mut s = String::from("Kurd"); // mut lazime
    test(&mut s);
    println!("", s);
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'13',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Vec (ئارای ئەندازەدۆز)',
  'title_ba'=>'Vec (ئارایا Endazedoz)',
  'subtitle_so'=>'Vec: ئاررای داینامیک و کارخستنەکانی',
  'subtitle_ba'=>'Vec: ئاررای داینامیک و کارهێنانێن وی',
  'content_so'=>'<p><code>Vec</code> ئارایەکی ئەندازەدۆز (dynamic array) یە لە Rust:</p><pre>let mut v: Vec<i32> = Vec::new();
v.push(1); v.push(2);
for x in &v { println!("{}", x); }</pre>',
  'content_ba'=>'<p><code>Vec</code> arraya dinamîk e di Rust de:</p>',
  'code'=>'fn main() {
    let mut hejmar: Vec<i32> = vec![5, 2, 8, 1, 9]; // ئاررای
    hejmar.push(7);      // زیادکردن
    hejmar.sort();       // ڕیزکردن
    println!("{:?}", hejmar);
    println!("Max: {}", hejmar.iter().max().unwrap()); // زۆرترین
    println!("Drêjayî: {}", hejmar.len()); // ژمارەی خانە
}',
  'example_output'=>'[1, 2, 5, 7, 8, 9]
Max: 9
Drêjayî: 6',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Vec::new() چی دەگەڕێنێتەوە؟',
  'quiz_question_ba'=>'Vec::new() çi digerîne?',
  'quiz_options_so'=>['Vec بەتاڵ', 'Vec بە بەها', 'null', 'هەڵە'],
  'quiz_options_ba'=>['Vec betale', 'Vec bi behe', 'null', 'xelat'],
  'quiz_correct'=>'0',
],

[
  'order'=>'14',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Struct',
  'title_ba'=>'Struct',
  'subtitle_so'=>'Struct: کۆکردنەوەی داتای ئاڵۆز',
  'subtitle_ba'=>'Struct: کۆکرنا داتای ئالۆز',
  'content_so'=>'<p>Struct داتای تێکەڵ کۆ دەکاتەوە. لە Rust گۆڕانکاری پێویستە <code>mut</code>:</p><pre>struct Mirov { nav: String, temen: u32 }
let m = Mirov { nav: String::from("Kurd"), temen: 25 };</pre>',
  'content_ba'=>'<p>Struct daneyan tê de dicivîne. Di Rust de guhartin pê <code>mut</code> pêwîste:</p>',
  'code'=>'struct Xwendekar { nav: String, nrx: f64 }  // پێناسە
impl Xwendekar {
    fn new(nav: &str, nrx: f64) -> Xwendekar {
        Xwendekar { nav: String::from(nav), nrx }
    }
    fn derbaz(&self) -> bool { self.nrx >= 50.0 } // پشکین
    fn bide(&self) { println!("{}: {}", self.nav,
        if self.derbaz() { "Derbaz" } else { "Nekefte" }); }
}
fn main() {
    let x = Xwendekar::new("Azad", 88.5);
    x.bide();
    let y = Xwendekar::new("Baran", 40.0);
    y.bide();
}',
  'example_output'=>'Azad: 88.5 (Derbaz)
Baran: 45 (Nekefte)',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
struct Mirov { nav: String }
fn main() {
    let m = Mirov { nav: "Kurd" };
    println!("{}", m.nav);
}',
  'practice_question_ba'=>'Xeleta kodê bidoze:
struct Mirov { nav: String }
fn main() {
    let m = Mirov { nav: "Kurd" };
    println!("{}", m.nav);
}',
  'expected_output_text'=>'Kurd',
  'solution_code'=>'struct Mirov { nav: String }
fn main() {
    let m = Mirov { nav: String::from("Kurd") }; // &str bo String::from lazime
    println!("{}", m.nav);
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'15',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Enum',
  'title_ba'=>'Enum',
  'subtitle_so'=>'Enum: جۆر بە چەند بەهای دیاریکراو',
  'subtitle_ba'=>'Enum: چەشنەک بە چەند بەهایێن دیاریکرای',
  'content_so'=>'<p>Enum جۆرێکه کە چەند بەهای دیاریکراو هەیە. لەگەڵ match بەکاردێت:</p><pre>enum Asta { Destpêk, Navend, Pêşkewtu }
let a = Asta::Navend;</pre>',
  'content_ba'=>'<p>Enum cureyeke ko çend behe yên diyarkirî heye. Ligel match tê bikaranîn:</p>',
  'code'=>'enum Reng { Sor, Kesk, Şîn, Din(String) }  // جۆر
fn bide(r: Reng) {
    match r {                        // بەراورد بکە
        Reng::Sor => println!("Sor"),
        Reng::Kesk => println!("Kesk"),
        Reng::Şîn => println!("Şîn"),
        Reng::Din(nav) => println!("Reng din: {}", nav),
    }
}
fn main() {
    bide(Reng::Kesk);
    bide(Reng::Din(String::from("Zer")));
}',
  'example_output'=>'Kesk
Rengê din: Zer',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
enum Dir {Bakur, Başûr, Rojhilat, Rojava}
let d = Dir::Başûr;
match d { Dir::Bakur=>println!("N"), Dir::Başûr=>println!("S"), _=>println!("E/W") }',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
enum Dir {Bakur,Başûr,Rojhilat,Rojava}
let d=Dir::Başûr;
match d{Dir::Bakur=>println!("N"),Dir::Başûr=>println!("S"),_=>println!("E/W")}',
  'quiz_options_so'=>['S', 'N', 'E/W', 'هەڵە'],
  'quiz_options_ba'=>['S', 'N', 'E/W', 'xelat'],
  'quiz_correct'=>'0',
],

[
  'order'=>'16',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Option<T>',
  'title_ba'=>'Option<T>',
  'subtitle_so'=>'Option: بەها هەیە یان نییە (Some/None)',
  'subtitle_ba'=>'Option: بەها هەبێ یان نەبێ (Some/None)',
  'content_so'=>'<p><code>Option<T></code> بەهایەکی کە دەتوانێت هەبێت (<code>Some</code>) یان نەبێت (<code>None</code>). جێگۆڕی null یە:</p><pre>fn dabesh(a:i32,b:i32)->Option<i32>{
    if b==0 {None} else {Some(a/b)}
}</pre>',
  'content_ba'=>'<p><code>Option<T></code> behe ya dikare hebe (Some) an nebe (None). Şûna null e:</p>',
  'code'=>'fn mezin(v: &Vec<i32>) -> Option<i32> {
    if v.is_empty() { None }                  // هیچ نییە
    else { Some(*v.iter().max().unwrap()) }   // بەها هەیە
}
fn main() {
    let v = vec![3, 7, 1, 9, 4];
    match mezin(&v) {
        Some(m) => println!("Mezin: {}", m),
        None => println!("Vala"),
    }
    let e: Vec<i32> = vec![];
    println!("{}", mezin(&e).unwrap_or(-1));
}',
  'example_output'=>'Mezin: 9
-1',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەیەک وەک Option وەربگرێت و بهیا دووتایی چاپ بکات یان "None" ئەگەر نەبێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko jimarekê wek Option wergire û bihaya du-alî çap bike an "None".',
  'expected_output_text'=>'Some(10)
None',
  'solution_code'=>'fn du(x: Option<i32>) -> Option<i32> {
    x.map(|n| n*2)
}
fn main() {
    println!("{:?}", du(Some(5)));
    println!("{:?}", du(None));
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'17',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'String و &str',
  'title_ba'=>'String û &str',
  'subtitle_so'=>'String و &str: دوو جۆری دەق',
  'subtitle_ba'=>'String و &str: دوو چەشنێن دەق',
  'content_so'=>'<p>لە Rust دوو جۆری دەق هەن: <code>String</code> (خاوەندایەتییە، گۆڕێکار) و <code>&str</code> (slice، خوێندنی تەنها).</p>',
  'content_ba'=>'<p>Di Rust de du cureyên nivîsînê: <code>String</code> (xawendar, gêrêkar) û <code>&str</code> (slice, xwendina tenê).</p>',
  'code'=>'fn xerhatî(nav: &str) -> String {
    format!("Silav, {}!", nav)
}
fn main() {
    let s1: &str = "Kurdistan";             // نەگۆڕ
    let s2: String = String::from("Hewler"); // گۆڕ و خاوەن
    let s3 = s1.to_string() + " & " + &s2;  // بەستن
    println!("{}", s3);
    println!("{}", xerhatî(s1));
    println!("{}", s2.len());               // ژمارەی پیت
    println!("{}", s2.contains("Hew"));     // پشکینا
}',
  'example_output'=>'Kurdistan & Hewler
Silav, Kurdistan!
6
true',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'فەرقی String و &str چییە؟',
  'quiz_question_ba'=>'Cudahiya String û &str çi ye?',
  'quiz_options_so'=>['String خاوەندایەتییە، &str slice یە', 'هەر دووکیان یەکسانن', 'String کورتتەرە', '&str خاوەندایەتییە'],
  'quiz_options_ba'=>['String xawendar e, &str slice ye', 'Her du yek in', 'String kurtir e', '&str xawendar e'],
  'quiz_correct'=>'0',
],

[
  'order'=>'18',
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'HashMap',
  'title_ba'=>'HashMap',
  'subtitle_so'=>'HashMap: کۆگا کلیل-بەها',
  'subtitle_ba'=>'HashMap: کۆگەیا کلیل-بەها',
  'content_so'=>'<p><code>HashMap</code> کلیل-بەها ستۆر دەکات لە Rust:</p><pre>use std::collections::HashMap;
let mut m = HashMap::new();
m.insert("av", "water");
println!("{}", m["av"]);</pre>',
  'content_ba'=>'<p><code>HashMap</code> kilîl-behe tê de diparêze di Rust de:</p>',
  'code'=>'use std::collections::HashMap;
fn main() {
    let mut xalên: HashMap<&str, i32> = HashMap::new();
    xalên.insert("Azad", 92);  // زیادکردن
    xalên.insert("Baran", 87);
    for (nav, nrx) in &xalên {  // خولاندن
        println!("{}: {}", nav, nrx);
    }
    println!("Jimare: {}", xalên.len());
    println!("{}", xalên.get("Azad").unwrap_or(&0));
}',
  'example_output'=>'Azad: 92
Baran: 85
Ciya: 78
Jimare: 3
92',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە فەرهەنگی کوردی-ئینگلیزی لەگەڵ HashMap دروست بکات.',
  'practice_question_ba'=>'Bernameyeke binivîse ko ferhengeke Kurdî-Înglîzî ligel HashMap çêbike.',
  'expected_output_text'=>'av = water
agir = fire',
  'solution_code'=>'use std::collections::HashMap;
fn main() {
    let mut f=HashMap::new();
    f.insert("av","water");
    f.insert("agir","fire");
    for (k,v) in &f { println!("{} = {}",k,v); }
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'19',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Traits',
  'title_ba'=>'Traits',
  'subtitle_so'=>'Trait: دیاریکردنی ڕەفتار بۆ چەند جۆر',
  'subtitle_ba'=>'Trait: دیارکرنا ڕەفتاری بۆ چەند چەشنان',
  'content_so'=>'<p>Trait لە Rust وەک Interface یە — دیاری دەکات کلاسێک/struct چی پەیدا دەکات:</p><pre>trait Danasîn { fn bide(&self); }
impl Danasîn for Mirov { fn bide(&self){...} }</pre>',
  'content_ba'=>'<p>Trait di Rust de wek Interface ye — diyar dike struct çi peyda dike:</p>',
  'code'=>'trait Dengder { fn deng(&self) -> &str; } // ڕەفتار
struct Se { nav: String }
struct Pisîk { nav: String }
impl Dengder for Se { fn deng(&self) -> &str { "Haw!" } }   // پیادهکردن
impl Dengder for Pisîk { fn deng(&self) -> &str { "Miyaw!" } }
fn peyan(d: &dyn Dengder) { println!("{}", d.deng()); }
fn main() {
    let se = Se { nav: String::from("Sipî") };
    let pisîk = Pisîk { nav: String::from("Naz") };
    peyan(&se);
    peyan(&pisîk);
}',
  'example_output'=>'Haw!
Mêw!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Trait لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Trait di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['دیاریکردنی رەفتار', 'هەلگرتنی داتا', 'دروستکردنی ئۆبجێکت', 'خولاندنی ئارا'],
  'quiz_options_ba'=>['Diyarkirina reftar', 'Hilgirtina dane', 'Çêkirina obejkt', 'Xolandina array'],
  'quiz_correct'=>'0',
],

[
  'order'=>'20',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Closures',
  'title_ba'=>'Closures',
  'subtitle_so'=>'Closure: فانکشنی کورت و ناوخۆیی',
  'subtitle_ba'=>'Closure: فانکشنێن کورت و ناوخۆیی',
  'content_so'=>'<p>Closure فەنکشنێکی ناوخۆییە کە گۆڕاوی ژینگەکەی دەگرێتەوە:</p><pre>let du = |x| x * 2;
println!("{}", du(5)); // 10
let nrx = 10;
let zêde = |x| x + nrx; // nrx capture</pre>',
  'content_ba'=>'<p>Closure fanksiyoneke hundirîn e ko giyorvaokên hawirdorê degirite:</p>',
  'code'=>'fn main() {
    let du = |x: i32| x * 2;  // closure: هێندکردن
    let kot = |a: i32, b: i32| a + b;
    println!("{}", du(7));
    println!("{}", kot(4, 5));
    let nrx = 10;
    let zêde = |x: i32| x + nrx;  // گرتنی nrx (capture)
    println!("{}", zêde(5));
    let v: Vec<i32> = (1..=5).map(|x| x * x).collect();
    println!("{:?}", v);
}',
  'example_output'=>'14
9
15
[1, 4, 9, 16, 25]',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
let m = |x:i32| x*x;
println!("{}", m(6));',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
let m = |x:i32| x*x;
println!("{}", m(6));',
  'quiz_options_so'=>['36', '12', '6', 'هەڵە'],
  'quiz_options_ba'=>['36', '12', '6', 'xelat'],
  'quiz_correct'=>'0',
],

[
  'order'=>'21',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Iterators',
  'title_ba'=>'Iterators',
  'subtitle_so'=>'Iterator و زنجیرەی methodەکان',
  'subtitle_ba'=>'Iterator و زنجیرەیا methodان',
  'content_so'=>'<p>Iterator میتۆدەکانی chain دەکات: <code>.map()</code>، <code>.filter()</code>، <code>.collect()</code>، <code>.sum()</code>، <code>.fold()</code>.</p>',
  'content_ba'=>'<p>Iterator metodên chain dike: <code>.map()</code>، <code>.filter()</code>، <code>.collect()</code>.</p>',
  'code'=>'fn main() {
    let v = vec![1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    // فلتەرکردنی جووتەکان
    let ju: Vec<i32> = v.iter().filter(|&&x| x % 2 == 0).cloned().collect();
    println!("{:?}", ju);
    let kot: i32 = v.iter().sum();  // کۆکردنەوە
    println!("Kot: {}", kot);
    let q: Vec<i32> = v.iter().map(|&x| x * x).collect(); // دووجا
    println!("{:?}", q);
}',
  'example_output'=>'[2, 4, 6, 8, 10]
Kot: 55
[1, 4, 9, 16, 25, 36, 49, 64, 81, 100]',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
let v = vec![1,2,3];
let r = v.map(|x| x*2).collect::<Vec<_>>();
println!("{:?}", r);',
  'practice_question_ba'=>'Xeleta kodê bidoze:
let v = vec![1,2,3];
let r = v.map(|x| x*2).collect::<Vec<_>>();
println!("{:?}", r);',
  'expected_output_text'=>'[2, 4, 6]',
  'solution_code'=>'fn main() {
    let v = vec![1,2,3];
    let r: Vec<_> = v.iter().map(|x| x*2).collect(); // .iter() lazime
    println!("{:?}", r);
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'22',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Result و Error Handling',
  'title_ba'=>'Result û Error Handling',
  'subtitle_so'=>'Result: سەرکەوتن یان هەڵە بە Ok/Err',
  'subtitle_ba'=>'Result: سەرکەفتن یان هەڵە بە Ok/Err',
  'content_so'=>'<p><code>Result<T,E></code> جێگۆڕی exception یە لە Rust: <code>Ok(val)</code> یان <code>Err(e)</code>. بە <code>?</code> بە ئاسانی propagate دەکرێت.</p>',
  'content_ba'=>'<p><code>Result<T,E></code> şûna exception e di Rust de: <code>Ok(val)</code> an <code>Err(e)</code>.</p>',
  'code'=>'use std::num::ParseIntError;
fn parse(s: &str) -> Result<i32, ParseIntError> { s.trim().parse::<i32>() }
fn main() {
    match parse("42") {
        Ok(n) => println!("OK: {}", n),       // سەرکەفتن
        Err(e) => println!("Hêle: {}", e),    // هەڵە
    }
    if let Ok(n) = parse("7") {
        println!("{}", n);
    }
}',
  'example_output'=>'OK: 42
Hêle: invalid digit found in string',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
let r: Result<i32,&str> = Ok(5);
println!("{}", r.unwrap_or(0));',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
let r: Result<i32,&str> = Ok(5);
println!("{}", r.unwrap_or(0));',
  'quiz_options_so'=>['5', '0', 'Err', 'هەڵە'],
  'quiz_options_ba'=>['5', '0', 'Err', 'xelat'],
  'quiz_correct'=>'0',
],

[
  'order'=>'23',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Lifetimes',
  'title_ba'=>'Lifetimes',
  'subtitle_so'=>'Lifetimes: ماوەی ژیانی reference',
  'subtitle_ba'=>'Lifetimes: ماوەیا ژیانا reference',
  'content_so'=>'<p>Lifetime دیاری دەکات reference چەندێک ژیاو. لە فەنکشنەکانی کە reference دەگەڕێنەوە پێویستە:</p><pre>fn dirêjtirîn<\'a>(a: &\'a str, b: &\'a str) -> &\'a str {
    if a.len() > b.len() { a } else { b }
}</pre>',
  'content_ba'=>'<p>Lifetime diyar dike reference çend jiyo. Di fanksiyonên ko reference digerîne pêwîste:</p>',
  'code'=>'fn direjtirîne<\'b>(a: &\'b str, b: &\'b str) -> &\'b str {
    if a.len() >= b.len() { a } else { b }  // هەرکام زۆرترە
}
fn main() {
    let s1 = String::from("Kurdistan");
    let s2 = String::from("Kurd");
    let drê = direjtirîne(&s1, &s2);
    println!("{}", drê);
}',
  'example_output'=>'Dirêjtirîn: Kurdistan',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە لەگەڵ lifetime کورتترین دەق لە دوو ئیتەم دەبینێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko ligel lifetime kurttirîn nivîsîn ji du tiştan bibîne.',
  'expected_output_text'=>'Kurttirîn: Kurd',
  'solution_code'=>'fn kurttirîn<\'a>(a: &\'a str, b: &\'a str) -> &\'a str {
    if a.len() <= b.len() {a} else {b}
}
fn main() {
    println!("Kurttirîn: {}", kurttirîn("Kurd","Kurdistan"));
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'24',
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Generic Functions',
  'title_ba'=>'Generic Functions',
  'subtitle_so'=>'Generic: فانکشن بۆ هەر جۆرێک',
  'subtitle_ba'=>'Generic: فانکشن بۆ هەر چەشنەکێ',
  'content_so'=>'<p>Generic فەنکشن دەتوانرێت لەگەڵ هەر جۆرێک کاربکات:</p><pre>fn bide<T: std::fmt::Display>(val: T) {
    println!("{}", val);
}
bide(42); bide("Kurd"); bide(3.14);</pre>',
  'content_ba'=>'<p>Generic fanksiyonên dikarin ligel her cureyê biçin:</p>',
  'code'=>'fn mezintir<T: PartialOrd>(a: T, b: T) -> T {
    if a >= b { a } else { b }  // بۆ هەر جۆرێک
}
fn bide<T: std::fmt::Debug>(v: &[T]) {
    for x in v { print!("{:?} ", x); }
    println!();
}
fn main() {
    println!("{}", mezintir(10, 7));           // ژمارە
    println!("{}", mezintir("kurd", "xurt"));  // دەق
    bide(&[1, 2, 3, 4]);
}',
  'example_output'=>'10
Xurt
1 2 3 4 5 ',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Generic لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Generic di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['کۆد دووبارە بەکارهێنان بۆ جۆرەکانی جیاواز', 'تەنها بۆ i32', 'تەنها بۆ String', 'هیچ پێویستی پێ نییە'],
  'quiz_options_ba'=>['Kodê ji nû ve bikaranîn bO cureyan', 'Tenê bO i32', 'Tenê bO String', 'Tu pêdivî pê tune'],
  'quiz_correct'=>'0',
],

[
  'order'=>'25',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: بەڕێوەبردنی خوێندکار',
  'title_ba'=>'Proje: Xwendekarên',
  'subtitle_so'=>'پڕۆژە: سیستەمی ئەرشیفی خوێندکاران',
  'subtitle_ba'=>'پڕۆژە: سیستەما ئەرشیفا خوێندکاران',
  'content_so'=>'<p>پرۆژەی یەکەم — سیستەمی ئەرشیفی خوێندکاران بە Struct:</p>',
  'content_ba'=>'<p>Projeya yekem — sîstema erşîva xwendekaran bi Struct:</p>',
  'code'=>'#[derive(Debug)]
struct Xwendekar { nav: String, nrx: f64 }
fn main() {
    let mut list: Vec<Xwendekar> = vec![];
    list.push(Xwendekar { nav: String::from("Azad"), nrx: 84.5 });
    list.push(Xwendekar { nav: String::from("Baran"), nrx: 66.0 });
    let mut derbaz = 0.0;
    for x in &list {              // خولاندن
        if x.nrx >= 50.0 { derbaz += 1.0; }  // فلتەر
    }
    println!("Derbaz: {}", derbaz);
    println!("{:#?}", list);
}',
  'example_output'=>'Azad: 92 [Taqez]
Baran: 75 [Baş]
Ciya: 48 [Nekefte]
Navend: 71.7',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە Vec<i32> وەربگرێت و ژمارەی ئەوانەی کە %3==0 ن بژمێرێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko Vec<i32> bigire û hejmara wan ko %3==0 bijmêre.',
  'expected_output_text'=>'Jimare: 3',
  'solution_code'=>'fn jimareyê_se(v: &Vec<i32>) -> usize { v.iter().filter(|&&x|x%3==0).count() }
fn main() {
    let v=vec![3,5,6,9,11,12];
    println!("Jimare: {}",jimareyê_se(&v));
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'26',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: ماشێنی ژمارەکردن',
  'title_ba'=>'Proje: Mêşîna Jimarê',
  'subtitle_so'=>'پڕۆژە: ماشێنی ژمارەکردن بە Result',
  'subtitle_ba'=>'پڕۆژە: ماشێنا ژماردنی بە Result',
  'content_so'=>'<p>پرۆژەی دووەم — ماشێنی ژمارەکردنی سادە:</p>',
  'content_ba'=>'<p>Projeya duyem — mêşîna jimarêkirinê:</p>',
  'code'=>'fn hesab(a: f64, op: char, b: f64) -> Result<f64, String> {
    match op {
        \'+\' => Ok(a + b),                                   // کۆکردنەوە
        \'-\' => Ok(a - b),                                   // لێدەرکردن
        \'*\' => Ok(a * b),                                   // لێکدان
        \'/\' => if b == 0.0 { Err(String::from("0!")) } else { Ok(a / b) }, // دابەشکردن
        _ => Err(String::from("Operator nehat")),           // ئۆپەراتۆر نەما
    }
}
fn main() {
    for (a, op, b) in [(10.0, \'+\', 4.0), (10.0, \'/\', 0.0)] {
        match hesab(a, op, b) {
            Ok(n) => println!("{}", n),
            Err(e) => println!("Err: {}", e),  // چاپکردنی هەڵە
        }
    }
}',
  'example_output'=>'10 + 5 = 15
20 - 8 = 12
6 * 7 = 42
15 / 3 = 5
Hêle: Dabêşkirina bi sifir!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Result::Ok چییە لە Rust؟',
  'quiz_question_ba'=>'Result::Ok çi ye di Rust de?',
  'quiz_options_so'=>['دەرئەنجامی سەرکەوتوو', 'هەڵەیەک', 'هیچ', 'boolean'],
  'quiz_options_ba'=>['Encama serkewtu', 'Helayeke', 'Tu tişt', 'boolean'],
  'quiz_correct'=>'0',
],

[
  'order'=>'27',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: فەرهەنگی کوردی',
  'title_ba'=>'Proje: Ferhengê Kurdî',
  'subtitle_so'=>'پڕۆژە: فەرهەنگی کوردی-ئینگلیزی بە HashMap',
  'subtitle_ba'=>'پڕۆژە: فەرهەنگا کوردی-ئینگلیزی بە HashMap',
  'content_so'=>'<p>پرۆژەی سێیەم — دیکشنەری کوردی-ئینگلیزی بە HashMap:</p>',
  'content_ba'=>'<p>Projeya sêyem — Dîksiyonêra Kurdî-Înglîzî bi HashMap:</p>',
  'code'=>'use std::collections::HashMap;
fn main() {
    let mut ferheng = HashMap::new();
    ferheng.insert("av", "water");   // ئاڤ
    ferheng.insert("agir", "fire");  // ئاگر
    ferheng.insert("erd", "earth");  // ئەرد
    let w = "av";
    match ferheng.get(w) {
        Some(m) => println!("{} = {}", w, m),  // دۆزینەوە
        None => println!("Ne hat dîtin"),      // نەدۆزرایەوە
    }
    println!("Jimare: {}", ferheng.len());
}',
  'example_output'=>'av = water
hesp: tune di ferheNGê de
roj = sun
Jimare: 5',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەی پەیوەندکراوی هاوشێوەکانی String لە Vec دا بژمێرێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko hejmara peyvên wekhev di Vec de bijmêre.',
  'expected_output_text'=>'Kurd: 2
Rust: 1',
  'solution_code'=>'use std::collections::HashMap;
fn main() {
    let v=vec!["Kurd","Rust","Kurd","Java","Rust","Kurd"];
    let mut m:HashMap<&str,i32>=HashMap::new();
    for w in v { *m.entry(w).or_insert(0)+=1; }
    for (k,v) in &m { if *v>1 { println!("{}: {}",k,v); } }
}',
  'attempts_allowed'=>'5',
],

[
  'order'=>'28',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'File I/O',
  'title_ba'=>'File I/O',
  'subtitle_so'=>'خوێندن و تۆمارکردنی فایل بە std::fs',
  'subtitle_ba'=>'خوێندن و تۆمارکرنا فایلێ بە std::fs',
  'content_so'=>'<p>خوێندن و نووسینی فایل لە Rust:</p><pre>use std::fs;
fs::write("test.txt","Silav")?;
let nav = fs::read_to_string("test.txt")?;</pre>',
  'content_ba'=>'<p>Xwendin û nivîsîna file di Rust de:</p>',
  'code'=>'use std::fs;
use std::io::Write;
fn main() -> std::io::Result<()> {
    // تۆمارکردنی فایل
    fs::write("/tmp/kurd.txt", "Silav Kurdistan!")?;
    // خوێندنی فایل
    let content = fs::read_to_string("/tmp/kurd.txt")?;
    println!("{}", content);
    Ok(())
}',
  'example_output'=>'Silav Kurdistan!
Rust bax e
Jimare: 2',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'<code>?</code> ئۆپەراتۆری لە Rust چییە؟',
  'quiz_question_ba'=>'<code>?</code> operator di Rust de çi ye?',
  'quiz_options_so'=>['propagate کردنی هەڵە', 'بەراوردکردن', 'ئۆپشنەل', 'سفر'],
  'quiz_options_ba'=>['Propagatekirina helayê', 'Berhevdankirin', 'Opsiyonel', 'Sifir'],
  'quiz_correct'=>'0',
],

[
  'order'=>'29',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'Concurrency - Threads',
  'title_ba'=>'Concurrency - Threads',
  'subtitle_so'=>'Threads: ئەرکە هاوچەرخییەکان بە std::thread',
  'subtitle_ba'=>'Threads: ئەرکێن هاوچەرخ بە std::thread',
  'content_so'=>'<p>Rust thread-safe یە. بە <code>std::thread::spawn</code> thread دروست دەکرێت:</p><pre>use std::thread;
thread::spawn(|| { println!("Thread nû"); }).join().unwrap();</pre>',
  'content_ba'=>'<p>Rust thread-safe e. Bi <code>std::thread::spawn</code> thread tê çêkirin:</p>',
  'code'=>'use std::thread;
fn main() {
    let handle = thread::spawn(|| {
        println!("Silav ji têri!  ");  // چاپکردن لە ئاژێرێ (دەنگ)
        String::from("Thread xelas bû")  // گەڕانەوەی بەها
    });
    let nav = handle.join().unwrap();  // چاوەڕوانی کۆتایی ئاژێرێ
    println!("{}", nav);
}',
  'example_output'=>'Kot: 5',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Arc<Mutex<T>> لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Arc<Mutex<T>> di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['thread-safe هاوبەش کردنی داتا', 'خوێندنی فایل', 'دروستکردنی Struct', 'گۆڕینی نرخ'],
  'quiz_options_ba'=>['Thread-safe parvekirina danê', 'Xwendina file', 'Çêkirina struct', 'Guherandina nirxê'],
  'quiz_correct'=>'0',
],

[
  'order'=>'30',
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'کۆتایی کۆرس — پرۆژەی کۆتایی',
  'title_ba'=>'Dawiya Kursê — Proje ya Dawî',
  'subtitle_so'=>'ئافەرین! گەیشتی بە کۆتایی کۆرس',
  'subtitle_ba'=>'ئافەرین! گەهیشتی بە داوەیا کۆرس',
  'content_so'=>'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی Rust. ئەوەی فێربوویت: let/mut، جۆرەکان، match، خولگەکان، Ownership، Borrowing، Struct، Enum، Option، Result، Trait، Generic، Closure، Iterator، HashMap، File I/O.</p>',
  'content_ba'=>'<p>Aferîn! Gihîştî dawiya kursê yê Rust. Fêrbûyî: let/mut، cureyan، match، gêrxistinên، Ownership، Struct، Enum، Option، Result، Trait، Generic، Closure، Iterator.</p>',
  'code'=>'fn main() {
    let nav = "Rust";  // ناوی زمانی بەرنامەسازی
    println!("Aferin, tû kursa {} temam kir!", nav);  // پیرۆزبایی کۆتایی
}',
  'example_output'=>'Azad: 750
Baran: 800
Ciya: 0',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە لەگەڵ Struct و impl میتۆدێکی تەلاری چاپ بکات.',
  'practice_question_ba'=>'Bernameyeke binivîse ko ligel Struct û impl metodeke telara çap bike.',
  'expected_output_text'=>'Şêwe: Çargoşe, Rûber: 20',
  'solution_code'=>'struct Çargoşe{d:f64,p:f64}
impl Çargoşe{fn ruber(&self)->f64{self.d*self.p}}
fn main(){
    let s=Çargoşe{d:4.0,p:5.0};
    println!("Şêwe: Çargoşe, Rûber: {}",s.ruber());
}',
  'attempts_allowed'=>'5',
]
];
echo 'Adding '.count($lessons).' lessons...\n';
foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);
if(isset($d['name'])){echo 'OK '.$l['order']."\n";}else{echo 'ERR '.$r."\n";exit(1);}}
echo 'Done Rust\n';
