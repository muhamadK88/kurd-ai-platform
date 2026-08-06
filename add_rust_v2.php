<?php
$u='https://ai-platform-adb1b-default-rtdb.firebaseio.com/';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='-OysGzfS5Qi08XHYs_FL';
function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo "Rust OK\n";
$lessons=[
[
  'order'=>1,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'چییە Rust؟',
  'title_ba'=>'چ یە Rust؟',
  'content_so'=>'<p><strong>Rust</strong> زمانێکی سیستەمی بەهێزە کە Memory Safety بەبێ Garbage Collector پێشکەش دەکات. لەلایەن Mozilla لە ٢٠١٠ دروستکراوە.</p><ul><li>خێرایی وەک C/C++</li><li>بەبێ هەڵەی حافیزە</li><li>WebAssembly، سیستەم، network</li></ul>',
  'content_ba'=>'<p><strong>Rust</strong> زمانەکەکا سیستەمی بهێز یە کو Memory Safety بەبێ GC پێشکەش دکەت.</p><ul><li>خێرایی وەک C/C++</li><li>بەبێ هەڵەیا حافیزەیێ</li><li>WebAssembly، سیستەم</li></ul>',
  'code'=>'fn main() {
    println!("Silav Kurdistane!");
    println!("Xêrhatî bo Rust!");
}',
  'example_output'=>'Silav Kurdistane!
Xêrhatî bo Rust!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Rust چی تایبەتمەندییەکی سەرەکی هەیە؟',
  'quiz_question_ba'=>'Rust چ تایبەتمەندییا سەرەکی هەیە؟',
  'quiz_options_so'=>['Memory Safety بەبێ GC','Garbage Collection','بۆ وێب تەنها','ئاسانترین زمان'],
  'quiz_options_ba'=>['Memory Safety بەبێ GC','Garbage Collection','بو وێب تەنها','Hêsantirîn ziman'],
  'quiz_correct'=>0,
],
[
  'order'=>2,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'گۆڕاوەکان و let',
  'title_ba'=>'گۆڕۆک û let',
  'content_so'=>'<p>لە Rust گۆڕاوەکان بە <code>let</code> دروست دەکرێن. بە default نەگۆڕ (immutable) ن — بۆ گۆڕین پێویستە <code>mut</code>:</p><pre>let x = 5;
let mut y = 10;
y = 20; // OK
// x = 6; // هەڵە!</pre>',
  'content_ba'=>'<p>د Rust دا گۆڕۆک پێ <code>let</code> drust dkêt. By default negör (immutable) — bO gorîn <code>mut</code> pêwîste:</p><pre>let x = 5;
let mut y = 10;
y = 20; // OK</pre>',
  'code'=>'fn main() {
    let nav = "Kurdistan";
    let mut hejmar = 5;
    println!("{}", nav);
    hejmar += 3;
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
  'quiz_options_so'=>['15','10','5','هەڵە'],
  'quiz_options_ba'=>['15','10','5','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>3,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'جۆرەکانی داتا',
  'title_ba'=>'Çeşnên Datayê',
  'content_so'=>'<p>جۆرە سەرەتاییەکانی Rust: <code>i32</code>، <code>f64</code>، <code>bool</code>، <code>char</code>، <code>String</code>، <code>&str</code>.</p><pre>let n: i32 = 42;
let f: f64 = 3.14;
let b: bool = true;
let c: char = \'K\';</pre>',
  'content_ba'=>'<p>Çeşnên serêtayî yên Rust: <code>i32</code>، <code>f64</code>، <code>bool</code>، <code>char</code>، <code>String</code>.</p>',
  'code'=>'fn main() {
    let temen: i32 = 25;
    let bilindi: f64 = 1.75;
    let nav: &str = "Azad";
    let drust: bool = true;
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
  'attempts_allowed'=>5,
],
[
  'order'=>4,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'ئۆپەراتۆرەکان',
  'title_ba'=>'Operatorên',
  'content_so'=>'<p>Rust ئۆپەراتۆرە ئاساییەکانی هەیە: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئاگاداربە: دابەشکردنی <code>i32 / i32</code> ژمارەی تەواو دەگەڕێنێتەوە.</p>',
  'content_ba'=>'<p>Rust operatorên: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. Hay be: <code>i32/i32</code> jimare tamam digerîne.</p>',
  'code'=>'fn main() {
    let a: i32 = 15;
    let b: i32 = 4;
    println!("{}", a + b);  // 19
    println!("{}", a - b);  // 11
    println!("{}", a * b);  // 60
    println!("{}", a / b);  // 3
    println!("{}", a % b);  // 3
    let c = a as f64 / b as f64;
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
  'attempts_allowed'=>5,
],
[
  'order'=>5,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'if/else',
  'title_ba'=>'if/else',
  'content_so'=>'<p>Rust مەرجی <code>if/else</code> هەیە. تایبەتی Rust: if دەتوانرێت وەک بەها بەکاربێت:</p><pre>let nrx = 85;
if nrx >= 90 { println!("Taqez"); }
else if nrx >= 60 { println!("Bas"); }
else { println!("Nekefte"); }</pre>',
  'content_ba'=>'<p>Rust mêrca <code>if/else</code> heye. Taybetî Rust: if dikare wek behe were bikaranîn.</p>',
  'code'=>'fn main() {
    let nrx = 85;
    let asta = if nrx >= 90 { "Taqez" }
               else if nrx >= 70 { "Bas" }
               else if nrx >= 50 { "Navend" }
               else { "Nekefte" };
    println!("{}", asta);
}',
  'example_output'=>'Bas',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر nrx=45 بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'Ger nrx=45 be, çi tê çapkirin?',
  'quiz_options_so'=>['Nekefte','Navend','Bas','Taqez'],
  'quiz_options_ba'=>['Nekefte','Navend','Bas','Taqez'],
  'quiz_correct'=>0,
],
[
  'order'=>6,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'match',
  'title_ba'=>'match',
  'content_so'=>'<p><code>match</code> لە Rust وەک switch باشتر: هەموو حالەتەکان دەبێت پووشەبن:</p><pre>match n {
    1 => println!("Yek"),
    2 | 3 => println!("Du an se"),
    _ => println!("Tiştekî din"),
}</pre>',
  'content_ba'=>'<p><code>match</code> di Rust wek switch çêtir e: hemî halet divê tiji bin:</p>',
  'code'=>'fn main() {
    let roj = 3;
    match roj {
        1 => println!("Duşem"),
        2 => println!("Sêşem"),
        3 => println!("Çarşem"),
        4 => println!("Pênçşem"),
        5 => println!("Înî"),
        _ => println!("Dawiya heftê"),
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
  'quiz_options_so'=>['pênc','yek','din','هەڵە'],
  'quiz_options_ba'=>['pênc','yek','din','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>7,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی loop و while',
  'title_ba'=>'loop û while',
  'content_so'=>'<p>Rust خولگەی <code>loop</code> (بێ مەرج)، <code>while</code>، و <code>for..in</code> هەیە:</p><pre>let mut n=0;
loop { n+=1; if n==5 { break; } }
while n>0 { n-=1; }</pre>',
  'content_ba'=>'<p>Rust gêrxistinên: <code>loop</code>، <code>while</code>، û <code>for..in</code>:</p>',
  'code'=>'fn main() {
    let mut n=0;
    loop { n+=1; if n>=5 { break; } }
    println!("loop: {}", n);
    let mut x=10;
    while x>0 { print!("{} ",x); x-=3; }
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
  'attempts_allowed'=>5,
],
[
  'order'=>8,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'for..in و Range',
  'title_ba'=>'for..in û Range',
  'content_so'=>'<p><code>for..in</code> بۆ خولاندنی ئاراکان و range: <code>1..=5</code> (گونجاندنی) <code>1..5</code> (دەرجووی):</p><pre>for i in 1..=5 { println!("{}", i); }
for x in [10,20,30] { println!("{}", x); }</pre>',
  'content_ba'=>'<p><code>for..in</code> bO xolandina arrayan û range:</p>',
  'code'=>'fn main() {
    for i in 1..=5 { print!("{} ", i); }
    println!();
    let bajer = ["Hewler","Silemani","Duhok"];
    for (idx, b) in bajer.iter().enumerate() {
        println!("{}. {}", idx+1, b);
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
  'quiz_options_so'=>['0 1 2 ','0 1 2 3 ','1 2 3 ','هەڵە'],
  'quiz_options_ba'=>['0 1 2 ','0 1 2 3 ','1 2 3 ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>9,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'break و continue',
  'title_ba'=>'break û continue',
  'content_so'=>'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
  'content_ba'=>'<p><code>break</code> gêrxistinê datestênit. <code>continue</code> gêrana niha têperde dike.</p>',
  'code'=>'fn main() {
    for i in 1..=10 {
        if i == 7 { break; }
        if i % 2 == 0 { continue; }
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
  'quiz_options_so'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','هەڵە'],
  'quiz_options_ba'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>10,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'فەنکشن',
  'title_ba'=>'Fanksiyonên',
  'content_so'=>'<p>فەنکشن لە Rust بە <code>fn</code>. جۆری گەڕانەوە دیاری دەکرێت بە <code>-></code>:</p><pre>fn kot(a: i32, b: i32) -> i32 { a + b }
println!("{}", kot(3, 5)); // 8</pre>',
  'content_ba'=>'<p>Fanksiyonên di Rust de pê <code>fn</code>. Cureyê gerêdanê pê <code>-></code> diyar dike:</p>',
  'code'=>'fn kot(a: i32, b: i32) -> i32 { a + b }
fn jote(n: i32) -> bool { n % 2 == 0 }
fn xêrhatî(nav: &str) -> String { format!("Silav, {}!", nav) }
fn main() {
    println!("{}", kot(4,6));
    println!("{}", jote(7));
    println!("{}", xêrhatî("Kurdistan"));
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
  'attempts_allowed'=>5,
],
[
  'order'=>11,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'Ownership (خاوەندایەتی)',
  'title_ba'=>'Ownership',
  'content_so'=>'<p>Ownership سیستەمی مانایەکی Rust یە. هەر بەها تەنها یەک خاوەندی هەیە. کاتی گواستنەوە (<code>move</code>) خاوەنی کۆن بەتاڵ دەبێت.</p>',
  'content_ba'=>'<p>Ownership sîstema bîranîna Rust e. Her behe tenê xawanekê heye. Dema veguhastinê (move) xawanê kevin betale dibe.</p>',
  'code'=>'fn main() {
    let s1 = String::from("Kurdistan");
    let s2 = s1; // s1 moved bo s2
    // println!("{}", s1); // Hêle: moved!
    println!("{}", s2);
    let n1: i32 = 5;
    let n2 = n1; // Copy (ne Move) bO primitive types
    println!("{} {}", n1, n2);
}',
  'example_output'=>'Kurdistan
5 5',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە Rust کاتی move چ دەبێتە سەر گۆڕاوی کۆن؟',
  'quiz_question_ba'=>'Di Rust de gava move çi dibe bo giyorvaeka kevin?',
  'quiz_options_so'=>['بەتاڵ دەبێت (invalid)','کۆپی دەبێت','سفر دەبێت','نەگۆڕ دەمێنێتەوە'],
  'quiz_options_ba'=>['Betale dibe (invalid)','Copy dibe','Sifir dibe','Negör dimêne'],
  'quiz_correct'=>0,
],
[
  'order'=>12,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'References و Borrowing',
  'title_ba'=>'References û Borrowing',
  'content_so'=>'<p>Reference (<code>&</code>) ڕێگەت دەدات بەبێ move بەها بەکاربهێنیت. ئەمە <strong>borrowing</strong>ە:</p><pre>fn drêjayî(s: &String) -> usize { s.len() }
let s = String::from("Kurd");
println!("{}", drêjayî(&s));
println!("{}", s); // هێشتا درووستە</pre>',
  'content_ba'=>'<p>Reference (<code>&</code>) bê move bikaranîna behe dide: <strong>borrowing</strong>:</p>',
  'code'=>'fn drêjayî(s: &String) -> usize { s.len() }
fn mezin_bike(s: &mut String) { s.push_str(" baş e!"); }
fn main() {
    let s = String::from("Rust");
    println!("{}", drêjayî(&s));
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
  'attempts_allowed'=>5,
],
[
  'order'=>13,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Vec (ئارای ئەندازەدۆز)',
  'title_ba'=>'Vec (ئارایا Endazedoz)',
  'content_so'=>'<p><code>Vec</code> ئارایەکی ئەندازەدۆز (dynamic array) یە لە Rust:</p><pre>let mut v: Vec<i32> = Vec::new();
v.push(1); v.push(2);
for x in &v { println!("{}", x); }</pre>',
  'content_ba'=>'<p><code>Vec</code> arraya dinamîk e di Rust de:</p>',
  'code'=>'fn main() {
    let mut hejmar: Vec<i32> = vec![5,2,8,1,9];
    hejmar.push(7);
    hejmar.sort();
    println!("{:?}", hejmar);
    println!("Max: {}", hejmar.iter().max().unwrap());
    println!("Drêjayî: {}", hejmar.len());
}',
  'example_output'=>'[1, 2, 5, 7, 8, 9]
Max: 9
Drêjayî: 6',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Vec::new() چی دەگەڕێنێتەوە؟',
  'quiz_question_ba'=>'Vec::new() çi digerîne?',
  'quiz_options_so'=>['Vec بەتاڵ','Vec بە بەها','null','هەڵە'],
  'quiz_options_ba'=>['Vec betale','Vec bi behe','null','xelat'],
  'quiz_correct'=>0,
],
[
  'order'=>14,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Struct',
  'title_ba'=>'Struct',
  'content_so'=>'<p>Struct داتای تێکەڵ کۆ دەکاتەوە. لە Rust گۆڕانکاری پێویستە <code>mut</code>:</p><pre>struct Mirov { nav: String, temen: u32 }
let m = Mirov { nav: String::from("Kurd"), temen: 25 };</pre>',
  'content_ba'=>'<p>Struct daneyan tê de dicivîne. Di Rust de guhartin pê <code>mut</code> pêwîste:</p>',
  'code'=>'struct Xwendekar { nav: String, nrx: f64 }
impl Xwendekar {
    fn new(nav: &str, nrx: f64) -> Xwendekar {
        Xwendekar { nav: String::from(nav), nrx }
    }
    fn derbaz(&self) -> bool { self.nrx >= 50.0 }
    fn bide(&self) { println!("{}: {} ({})", self.nav, self.nrx, if self.derbaz(){"Derbaz"}else{"Nekefte"}); }
}
fn main() {
    let x = Xwendekar::new("Azad", 88.5);
    x.bide();
    let y = Xwendekar::new("Baran", 45.0);
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
  'attempts_allowed'=>5,
],
[
  'order'=>15,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Enum',
  'title_ba'=>'Enum',
  'content_so'=>'<p>Enum جۆرێکه کە چەند بەهای دیاریکراو هەیە. لەگەڵ match بەکاردێت:</p><pre>enum Asta { Destpêk, Navend, Pêşkewtu }
let a = Asta::Navend;</pre>',
  'content_ba'=>'<p>Enum cureyeke ko çend behe yên diyarkirî heye. Ligel match tê bikaranîn:</p>',
  'code'=>'enum Reng { Sor, Kesk, Şîn, Din(String) }
fn bide(r: Reng) {
    match r {
        Reng::Sor => println!("Sor"),
        Reng::Kesk => println!("Kesk"),
        Reng::Şîn => println!("Şîn"),
        Reng::Din(nav) => println!("Rengê din: {}", nav),
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
  'quiz_options_so'=>['S','N','E/W','هەڵە'],
  'quiz_options_ba'=>['S','N','E/W','xelat'],
  'quiz_correct'=>0,
],
[
  'order'=>16,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'Option<T>',
  'title_ba'=>'Option<T>',
  'content_so'=>'<p><code>Option<T></code> بەهایەکی کە دەتوانێت هەبێت (<code>Some</code>) یان نەبێت (<code>None</code>). جێگۆڕی null یە:</p><pre>fn dabesh(a:i32,b:i32)->Option<i32>{
    if b==0 {None} else {Some(a/b)}
}</pre>',
  'content_ba'=>'<p><code>Option<T></code> behe ya dikare hebe (Some) an nebe (None). Şûna null e:</p>',
  'code'=>'fn mezin(v: &Vec<i32>) -> Option<i32> {
    if v.is_empty() { None }
    else { Some(*v.iter().max().unwrap()) }
}
fn main() {
    let v = vec![3,7,1,9,4];
    match mezin(&v) {
        Some(m) => println!("Mezin: {}", m),
        None => println!("Vala ye"),
    }
    let empty: Vec<i32> = vec![];
    println!("{}", mezin(&empty).unwrap_or(-1));
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
  'attempts_allowed'=>5,
],
[
  'order'=>17,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'String و &str',
  'title_ba'=>'String û &str',
  'content_so'=>'<p>لە Rust دوو جۆری دەق هەن: <code>String</code> (خاوەندایەتییە، گۆڕێکار) و <code>&str</code> (slice، خوێندنی تەنها).</p>',
  'content_ba'=>'<p>Di Rust de du cureyên nivîsînê: <code>String</code> (xawendar, gêrêkar) û <code>&str</code> (slice, xwendina tenê).</p>',
  'code'=>'fn xêrhatî(nav: &str) -> String {
    format!("Silav, {}!", nav)
}
fn main() {
    let s1: &str = "Kurdistan";
    let s2: String = String::from("Hewler");
    let s3 = s1.to_string() + " & " + &s2;
    println!("{}", s3);
    println!("{}", xêrhatî(s1));
    println!("{}", s2.len());
    println!("{}", s2.contains("Hew"));
}',
  'example_output'=>'Kurdistan & Hewler
Silav, Kurdistan!
6
true',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'فەرقی String و &str چییە؟',
  'quiz_question_ba'=>'Cudahiya String û &str çi ye?',
  'quiz_options_so'=>['String خاوەندایەتییە، &str slice یە','هەر دووکیان یەکسانن','String کورتتەرە','&str خاوەندایەتییە'],
  'quiz_options_ba'=>['String xawendar e, &str slice ye','Her du yek in','String kurtir e','&str xawendar e'],
  'quiz_correct'=>0,
],
[
  'order'=>18,
  'level_so'=>'ئاستی ٣ - ڕیزبندی و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیزبندی و نڤیسین',
  'title_so'=>'HashMap',
  'title_ba'=>'HashMap',
  'content_so'=>'<p><code>HashMap</code> کلیل-بەها ستۆر دەکات لە Rust:</p><pre>use std::collections::HashMap;
let mut m = HashMap::new();
m.insert("av", "water");
println!("{}", m["av"]);</pre>',
  'content_ba'=>'<p><code>HashMap</code> kilîl-behe tê de diparêze di Rust de:</p>',
  'code'=>'use std::collections::HashMap;
fn main() {
    let mut xalên: HashMap<&str,i32> = HashMap::new();
    xalên.insert("Azad", 92);
    xalên.insert("Baran", 85);
    xalên.insert("Ciya", 78);
    for (nav, nrx) in &xalên {
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
  'attempts_allowed'=>5,
],
[
  'order'=>19,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Traits',
  'title_ba'=>'Traits',
  'content_so'=>'<p>Trait لە Rust وەک Interface یە — دیاری دەکات کلاسێک/struct چی پەیدا دەکات:</p><pre>trait Danasîn { fn bide(&self); }
impl Danasîn for Mirov { fn bide(&self){...} }</pre>',
  'content_ba'=>'<p>Trait di Rust de wek Interface ye — diyar dike struct çi peyda dike:</p>',
  'code'=>'trait Dengdêr { fn deng(&self) -> &str; }
struct Se { nav: String }
struct Pisîk { nav: String }
impl Dengdêr for Se { fn deng(&self) -> &str { "Haw!" } }
impl Dengdêr for Pisîk { fn deng(&self) -> &str { "Mêw!" } }
fn axivîn(d: &dyn Dengdêr) { println!("{}", d.deng()); }
fn main() {
    let s = Se { nav: String::from("Zato") };
    let p = Pisîk { nav: String::from("Mîla") };
    axivîn(&s); axivîn(&p);
}',
  'example_output'=>'Haw!
Mêw!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Trait لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Trait di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['دیاریکردنی رەفتار','هەلگرتنی داتا','دروستکردنی ئۆبجێکت','خولاندنی ئارا'],
  'quiz_options_ba'=>['Diyarkirina reftar','Hilgirtina dane','Çêkirina obejkt','Xolandina array'],
  'quiz_correct'=>0,
],
[
  'order'=>20,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Closures',
  'title_ba'=>'Closures',
  'content_so'=>'<p>Closure فەنکشنێکی ناوخۆییە کە گۆڕاوی ژینگەکەی دەگرێتەوە:</p><pre>let du = |x| x * 2;
println!("{}", du(5)); // 10
let nrx = 10;
let zêde = |x| x + nrx; // nrx capture</pre>',
  'content_ba'=>'<p>Closure fanksiyoneke hundirîn e ko giyorvaokên hawirdorê degirite:</p>',
  'code'=>'fn main() {
    let du = |x: i32| x * 2;
    let kot = |a: i32, b: i32| a + b;
    println!("{}", du(7));
    println!("{}", kot(4, 5));
    let nrx = 10;
    let zêde = |x| x + nrx;
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
  'quiz_options_so'=>['36','12','6','هەڵە'],
  'quiz_options_ba'=>['36','12','6','xelat'],
  'quiz_correct'=>0,
],
[
  'order'=>21,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Iterators',
  'title_ba'=>'Iterators',
  'content_so'=>'<p>Iterator میتۆدەکانی chain دەکات: <code>.map()</code>، <code>.filter()</code>، <code>.collect()</code>، <code>.sum()</code>، <code>.fold()</code>.</p>',
  'content_ba'=>'<p>Iterator metodên chain dike: <code>.map()</code>، <code>.filter()</code>، <code>.collect()</code>.</p>',
  'code'=>'fn main() {
    let v = vec![1,2,3,4,5,6,7,8,9,10];
    let jote: Vec<i32> = v.iter().filter(|&&x| x%2==0).cloned().collect();
    println!("{:?}", jote);
    let kot: i32 = v.iter().sum();
    println!("Kot: {}", kot);
    let qarebu: Vec<i32> = v.iter().map(|&x| x*x).collect();
    println!("{:?}", qarebu);
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
  'attempts_allowed'=>5,
],
[
  'order'=>22,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Result و Error Handling',
  'title_ba'=>'Result û Error Handling',
  'content_so'=>'<p><code>Result<T,E></code> جێگۆڕی exception یە لە Rust: <code>Ok(val)</code> یان <code>Err(e)</code>. بە <code>?</code> بە ئاسانی propagate دەکرێت.</p>',
  'content_ba'=>'<p><code>Result<T,E></code> şûna exception e di Rust de: <code>Ok(val)</code> an <code>Err(e)</code>.</p>',
  'code'=>'use std::num::ParseIntError;
fn parse(s: &str) -> Result<i32, ParseIntError> {
    s.trim().parse::<i32>()
}
fn main() {
    match parse("42") {
        Ok(n) => println!("OK: {}", n),
        Err(e) => println!("Hêle: {}", e),
    }
    match parse("abc") {
        Ok(n) => println!("OK: {}", n),
        Err(e) => println!("Hêle: {}", e),
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
  'quiz_options_so'=>['5','0','Err','هەڵە'],
  'quiz_options_ba'=>['5','0','Err','xelat'],
  'quiz_correct'=>0,
],
[
  'order'=>23,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Lifetimes',
  'title_ba'=>'Lifetimes',
  'content_so'=>'<p>Lifetime دیاری دەکات reference چەندێک ژیاو. لە فەنکشنەکانی کە reference دەگەڕێنەوە پێویستە:</p><pre>fn dirêjtirîn<\'a>(a: &\'a str, b: &\'a str) -> &\'a str {
    if a.len() > b.len() { a } else { b }
}</pre>',
  'content_ba'=>'<p>Lifetime diyar dike reference çend jiyo. Di fanksiyonên ko reference digerîne pêwîste:</p>',
  'code'=>'fn dirêjtirîn<\'a>(a: &\'a str, b: &\'a str) -> &\'a str {
    if a.len() >= b.len() { a } else { b }
}
fn main() {
    let s1 = String::from("Kurdistan");
    let result;
    {
        let s2 = String::from("Kurd");
        result = dirêjtirîn(&s1, &s2);
        println!("Dirêjtirîn: {}", result);
    }
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
  'attempts_allowed'=>5,
],
[
  'order'=>24,
  'level_so'=>'ئاستی ٤ - Ownership و Structs',
  'level_ba'=>'ئاستا ٤ - Ownership و Structs',
  'title_so'=>'Generic Functions',
  'title_ba'=>'Generic Functions',
  'content_so'=>'<p>Generic فەنکشن دەتوانرێت لەگەڵ هەر جۆرێک کاربکات:</p><pre>fn bide<T: std::fmt::Display>(val: T) {
    println!("{}", val);
}
bide(42); bide("Kurd"); bide(3.14);</pre>',
  'content_ba'=>'<p>Generic fanksiyonên dikarin ligel her cureyê biçin:</p>',
  'code'=>'fn mezin<T: PartialOrd>(a: T, b: T) -> T {
    if a >= b { a } else { b }
}
fn bide<T: std::fmt::Debug>(v: &[T]) {
    for x in v { print!("{:?} ", x); }
    println!();
}
fn main() {
    println!("{}", mezin(10, 7));
    println!("{}", mezin("Kurd", "Xurt"));
    bide(&[1,2,3,4,5]);
}',
  'example_output'=>'10
Xurt
1 2 3 4 5 ',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Generic لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Generic di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['کۆد دووبارە بەکارهێنان بۆ جۆرەکانی جیاواز','تەنها بۆ i32','تەنها بۆ String','هیچ پێویستی پێ نییە'],
  'quiz_options_ba'=>['Kodê ji nû ve bikaranîn bO cureyan','Tenê bO i32','Tenê bO String','Tu pêdivî pê tune'],
  'quiz_correct'=>0,
],
[
  'order'=>25,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: بەڕێوەبردنی خوێندکار',
  'title_ba'=>'Proje: Xwendekarên',
  'content_so'=>'<p>پرۆژەی یەکەم — سیستەمی ئەرشیفی خوێندکاران بە Struct:</p>',
  'content_ba'=>'<p>Projeya yekem — sîstema erşîva xwendekaran bi Struct:</p>',
  'code'=>'#[derive(Debug)]
struct Xwendekar { nav: String, nrx: f64 }
impl Xwendekar {
    fn new(nav: &str, nrx: f64) -> Self { Xwendekar{nav:String::from(nav),nrx} }
    fn ast(&self) -> &str {
        if self.nrx>=90.0{"Taqez"} else if self.nrx>=70.0{"Baş"} else if self.nrx>=50.0{"Navend"} else{"Nekefte"}
    }
}
fn main() {
    let mut lîste = vec![
        Xwendekar::new("Azad",92.0),
        Xwendekar::new("Baran",75.0),
        Xwendekar::new("Ciya",48.0),
    ];
    lîste.sort_by(|a,b| b.nrx.partial_cmp(&a.nrx).unwrap());
    for x in &lîste { println!("{}: {} [{}]", x.nav, x.nrx, x.ast()); }
    let navend: f64 = lîste.iter().map(|x|x.nrx).sum::<f64>()/lîste.len() as f64;
    println!("Navend: {:.1}", navend);
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
  'attempts_allowed'=>5,
],
[
  'order'=>26,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: ماشێنی ژمارەکردن',
  'title_ba'=>'Proje: Mêşîna Jimarê',
  'content_so'=>'<p>پرۆژەی دووەم — ماشێنی ژمارەکردنی سادە:</p>',
  'content_ba'=>'<p>Projeya duyem — mêşîna jimarêkirinê:</p>',
  'code'=>'fn hesab(a:f64, op:char, b:f64) -> Result<f64,String> {
    match op {
        \'+\' => Ok(a+b),
        \'-\' => Ok(a-b),
        \'*\' => Ok(a*b),
        \'/\' => if b!=0.0{Ok(a/b)}else{Err("Dabêşkirina bi sifir!".to_string())},
        _ => Err(format!("Operator nenas: {}", op))
    }
}
fn main() {
    let tests = [(10.0,\'+\',5.0),(20.0,\'-\',8.0),(6.0,\'*\',7.0),(15.0,\'/\',3.0),(5.0,\'/\',0.0)];
    for (a,op,b) in tests {
        match hesab(a,op,b) {
            Ok(r) => println!("{} {} {} = {}",a,op,b,r),
            Err(e) => println!("Hêle: {}",e),
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
  'quiz_options_so'=>['دەرئەنجامی سەرکەوتوو','هەڵەیەک','هیچ','boolean'],
  'quiz_options_ba'=>['Encama serkewtu','Helayeke','Tu tişt','boolean'],
  'quiz_correct'=>0,
],
[
  'order'=>27,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: فەرهەنگی کوردی',
  'title_ba'=>'Proje: Ferhengê Kurdî',
  'content_so'=>'<p>پرۆژەی سێیەم — دیکشنەری کوردی-ئینگلیزی بە HashMap:</p>',
  'content_ba'=>'<p>Projeya sêyem — Dîksiyonêra Kurdî-Înglîzî bi HashMap:</p>',
  'code'=>'use std::collections::HashMap;
fn main() {
    let mut ferheng: HashMap<&str,&str> = HashMap::new();
    let peyvên = [("av","water"),("agir","fire"),("erd","earth"),("ba","wind"),("roj","sun"),("av","water")];
    for (k,v) in &peyvên { ferheng.insert(k,v); }
    let lêgerin = ["av","hesp","roj"];
    for peyvek in &lêgerin {
        match ferheng.get(peyvek) {
            Some(w) => println!("{} = {}",peyvek,w),
            None => println!("{}: tune di ferheNGê de",peyvek),
        }
    }
    println!("Jimare: ", ferheng.len());
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
  'attempts_allowed'=>5,
],
[
  'order'=>28,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'File I/O',
  'title_ba'=>'File I/O',
  'content_so'=>'<p>خوێندن و نووسینی فایل لە Rust:</p><pre>use std::fs;
fs::write("test.txt","Silav")?;
let nav = fs::read_to_string("test.txt")?;</pre>',
  'content_ba'=>'<p>Xwendin û nivîsîna file di Rust de:</p>',
  'code'=>'use std::fs;
use std::io::Write;
fn main() -> std::io::Result<()> {
    fs::write("/tmp/kurd.txt","Silav Kurdistan!\\nRust bax e\\n")?;
    let nav = fs::read_to_string("/tmp/kurd.txt")?;
    print!("{}", nav);
    let rêzan: Vec<&str> = nav.lines().collect();
    println!("Jimare: {}", rêzan.len());
    fs::remove_file("/tmp/kurd.txt")?;
    Ok(())
}',
  'example_output'=>'Silav Kurdistan!
Rust bax e
Jimare: 2',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'<code>?</code> ئۆپەراتۆری لە Rust چییە؟',
  'quiz_question_ba'=>'<code>?</code> operator di Rust de çi ye?',
  'quiz_options_so'=>['propagate کردنی هەڵە','بەراوردکردن','ئۆپشنەل','سفر'],
  'quiz_options_ba'=>['Propagatekirina helayê','Berhevdankirin','Opsiyonel','Sifir'],
  'quiz_correct'=>0,
],
[
  'order'=>29,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'Concurrency - Threads',
  'title_ba'=>'Concurrency - Threads',
  'content_so'=>'<p>Rust thread-safe یە. بە <code>std::thread::spawn</code> thread دروست دەکرێت:</p><pre>use std::thread;
thread::spawn(|| { println!("Thread nû"); }).join().unwrap();</pre>',
  'content_ba'=>'<p>Rust thread-safe e. Bi <code>std::thread::spawn</code> thread tê çêkirin:</p>',
  'code'=>'use std::thread;
use std::sync::{Arc,Mutex};
fn main() {
    let kot = Arc::new(Mutex::new(0));
    let mut handles = vec![];
    for _ in 0..5 {
        let k = Arc::clone(&kot);
        handles.push(thread::spawn(move || {
            let mut m = k.lock().unwrap();
            *m += 1;
        }));
    }
    for h in handles { h.join().unwrap(); }
    println!("Kot: {}", *kot.lock().unwrap());
}',
  'example_output'=>'Kot: 5',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Arc<Mutex<T>> لە Rust بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Arc<Mutex<T>> di Rust de bO çi tê bikaranîn?',
  'quiz_options_so'=>['thread-safe هاوبەش کردنی داتا','خوێندنی فایل','دروستکردنی Struct','گۆڕینی نرخ'],
  'quiz_options_ba'=>['Thread-safe parvekirina danê','Xwendina file','Çêkirina struct','Guherandina nirxê'],
  'quiz_correct'=>0,
],
[
  'order'=>30,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'کۆتایی کۆرس — پرۆژەی کۆتایی',
  'title_ba'=>'Dawiya Kursê — Proje ya Dawî',
  'content_so'=>'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی Rust. ئەوەی فێربوویت: let/mut، جۆرەکان، match، خولگەکان، Ownership، Borrowing، Struct، Enum، Option، Result، Trait، Generic، Closure، Iterator، HashMap، File I/O.</p>',
  'content_ba'=>'<p>Aferîn! Gihîştî dawiya kursê yê Rust. Fêrbûyî: let/mut، cureyan، match، gêrxistinên، Ownership، Struct، Enum، Option، Result، Trait، Generic، Closure، Iterator.</p>',
  'code'=>'use std::collections::HashMap;
struct Bank {
    hejar: HashMap<String,f64>
}
impl Bank {
    fn new() -> Self { Bank{hejar:HashMap::new()} }
    fn dagirtin(&mut self,nav:&str,miqdar:f64) { *self.hejar.entry(nav.to_string()).or_insert(0.0)+=miqdar; }
    fn hesab(&self,nav:&str)->f64 { *self.hejar.get(nav).unwrap_or(&0.0) }
}
fn main() {
    let mut b=Bank::new();
    b.dagirtin("Azad",500.0);
    b.dagirtin("Azad",250.0);
    b.dagirtin("Baran",800.0);
    println!("Azad: {}", b.hesab("Azad"));
    println!("Baran: {}", b.hesab("Baran"));
    println!("Ciya: {}", b.hesab("Ciya"));
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
  'attempts_allowed'=>5,
],
];
echo 'Adding '.count($lessons).' lessons...\n';
foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);
if(isset($d['name'])){echo 'OK '.$l['order']."\n";}else{echo 'ERR '.$r."\n";exit(1);}}
echo 'Done Rust\n';
