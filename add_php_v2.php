<?php
$u='https://ai-platform-adb1b-default-rtdb.firebaseio.com/';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='-Oysj44hJLXDgdp-b9iN';
function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo "PHP OK\n";
$lessons=[
[
  'order'=>'1',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'چییە PHP؟',
  'title_ba'=>'چ یە PHP؟',
  'subtitle_so'=>'دەستپێک لەگەڵ PHP — زمانی سەرڤەر بۆ ماڵپەڕی داینامیکی',
  'subtitle_ba'=>'دەستپێکرن ل گەل PHP — زمانێ سێرڤەر بو مالپەرێن داینامیکی',
  'content_so'=>'<p><strong>PHP</strong> زمانێکی server-side یە بۆ دروستکردنی ماڵپەڕی داینامیکی. لە WordPress، Laravel و زۆر فریمووەرک بەکاردێت.</p>',
  'content_ba'=>'<p><strong>PHP</strong> زمانەکەکا server-side یە بو دروستکرنا ماڵپەرێن داینامیکی. د WordPress، Laravel دا بکارتیت.</p>',
  'code'=>'<?php
// چاپکردنی سڵاو بە کوردی
echo "Silav Kurdistane!\\n";
// بەخێرهێنان بۆ کۆرس
echo "Xêrhatî bo PHP\\n";
// چاپکردنی ساڵی ئێستا
echo "Sal: ".date("Y")."\\n";
?>',
  'example_output'=>'Silav Kurdistane!
Xêrhatî bo PHP
Sal: 2026',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'PHP زمانێکی چییە؟',
  'quiz_question_ba'=>'PHP زمانەکا چ یە؟',
  'quiz_options_so'=>['Server-side scripting', 'Desktop app', 'Mobile app', 'Game engine'],
  'quiz_options_ba'=>['Server-side scripting', 'Desktop app', 'Mobile app', 'Game engine'],
  'quiz_correct'=>'0',
],

[
  'order'=>'2',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'گۆڕاوەکان',
  'title_ba'=>'گۆڕۆک',
  'subtitle_so'=>'گۆڕاوەکان بە $ و جۆرەکانیان بەبێ دیاریکردن',
  'subtitle_ba'=>'گۆڕۆک پێ $ و چەشنێن وان بەبێ دیاریکرن',
  'content_so'=>'<p>لە PHP گۆڕاوەکان بە <code>$</code> دەستپێدەکەن. پێویست ناکات جۆر دیاری بکرێت — PHP خۆی دەزانێت:</p><pre>$nav = "Kurd"; $temen = 25; $nrx = 4.5; $drust = true;</pre>',
  'content_ba'=>'<p>د PHP دا گۆڕۆک پێ <code>$</code> دەست پێ دکەن. پێویست نییە چەشن دیاری بکی:</p><pre>$nav = "Kurd"; $temen = 25;</pre>',
  'code'=>'<?php
$nav = "Kurd";     // گۆڕاوەی دەق
$temen = 22;       // گۆڕاوەی ژمارە
$bajar = "Hewler"; // گۆڕاوەی شار
echo $nav . " ji " . $bajar . "\\n";  // بەستنی دەق و چاپکردن
echo "Temen: " . $temen . "\\n";
echo "Cure: " . gettype($nav) . "\\n";  // نیشاندانی جۆری گۆڕاوە
?>',
  'example_output'=>'Kurd ji Hewler
Temen: 22
Cure: string',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
<?php $x=5; $y=3; echo $x+$y; ?>',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
<?php $x=5; $y=3; echo $x+$y; ?>',
  'quiz_options_so'=>['8', '53', '$x+$y', 'هەڵە'],
  'quiz_options_ba'=>['8', '53', '$x+$y', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'3',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'ئۆپەراتۆرەکان',
  'title_ba'=>'ئۆپەراتۆر',
  'subtitle_so'=>'ئۆپەراتۆرە بیرکارییەکان و بەستنی دەق بە .',
  'subtitle_ba'=>'ئۆپەراتۆرێن ماتەماتیکی و بەستنا نڤیسینێ پێ .',
  'content_so'=>'<p>PHP ئۆپەراتۆرە بیرکارییەکانی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>، <code>**</code>. بۆ دەق: <code>.</code> بەستن.</p>',
  'content_ba'=>'<p>PHP ئۆپەراتۆرێن ماتەماتیکی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>، <code>**</code>. بو نڤیسین: <code>.</code>.</p>',
  'code'=>'<?php
$a=15; $b=4;
echo $a+$b."\\n";   // 19 — کۆکردنەوە
echo $a-$b."\\n";   // 11 — لێدەرکردن
echo $a*$b."\\n";   // 60 — لێکدان
echo $a/$b."\\n";   // 3.75 — دابەشکردن
echo $a%$b."\\n";   // 3 — ماوە
echo ($a**2)."\\n"; // 225 — هێز
?>',
  'example_output'=>'19
11
60
3.75
3
225',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
$nav = "Kurd";
echo $Name;
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
$nav = "Kurd";
echo $Name;
?>',
  'expected_output_text'=>'Kurd',
  'solution_code'=>'<?php
$nav = "Kurd";
echo $nav; // case-sensitive
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'4',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'دەقەکان (Strings)',
  'title_ba'=>'نڤیسین (Strings)',
  'subtitle_so'=>'فانکشنی دەق: strlen، strtoupper، substr و str_replace',
  'subtitle_ba'=>'فانکشنێن نڤیسین: strlen، strtoupper، substr و str_replace',
  'content_so'=>'<p>PHP فانکشنی دەقی زۆری هەیە: <code>strlen()</code>، <code>strtoupper()</code>، <code>strtolower()</code>، <code>substr()</code>، <code>str_replace()</code>.</p>',
  'content_ba'=>'<p>PHP فانکشنێن نڤیسینی زۆر: <code>strlen()</code>، <code>strtoupper()</code>، <code>substr()</code>.</p>',
  'code'=>'<?php
$s = "Kurdistan";
echo strlen($s)."\\n";           // 9 — ژمارەی پیتەکان
echo strtoupper($s)."\\n";       // KURDISTAN — پیتە گەورەکان
echo substr($s,0,4)."\\n";       // Kurd — بەشی یەکەم
echo str_replace("stan","",$s)."\\n";  // Kurdi — گۆڕینی بەشێک
?>',
  'example_output'=>'9
KURDISTAN
Kurd
Kurdi',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ناوی شارێک وەربگرێت و بە پیتی گەورە چاپی بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ناڤا باژارەک وەربگریت و ب پیتێن مەزن چاپا وی بکەت.',
  'expected_output_text'=>'Bajar: HEWLER',
  'solution_code'=>'<?php
$b=readline("Bajar: ");
echo strtoupper($b)."\\n";
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'5',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'مەرجی if/else',
  'title_ba'=>'مەرجا if/else',
  'subtitle_so'=>'بڕیاردان بە if، elseif و else',
  'subtitle_ba'=>'بڕیاردانێ پێ if، elseif و else',
  'content_so'=>'<p>مەرجی <code>if/elseif/else</code> ڕێگەت دەدات بڕیار بدەیت:</p><pre>if ($nrx>=90) echo "Taqez";
elseif ($nrx>=60) echo "Bas";
else echo "Nekefte";</pre>',
  'content_ba'=>'<p>مەرجا <code>if/elseif/else</code> ڕێگا دیتت دەت:</p><pre>if ($nrx>=90) echo "Taqez";
elseif ($nrx>=60) echo "Bas";
else echo "Nekefte";</pre>',
  'code'=>'<?php
$temen = 20;
if ($temen >= 18) {  // مەرج: ئایا بەسەرپێگەیشتووە؟
    echo "Mezin buye\\n";
} else {
    echo "Picuk e\\n";
}
?>',
  'example_output'=>'Mezin buye',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر $temen=15 بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'گەر $temen=15 بیت، چ چاپ دبیت؟',
  'quiz_options_so'=>['Picuk e', 'Mezin buye', 'هیچ', 'هەڵە'],
  'quiz_options_ba'=>['Picuk e', 'Mezin buye', 'هیچ', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'6',
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'switch',
  'title_ba'=>'switch',
  'subtitle_so'=>'بەراوردکردنی یەک بەها لەگەڵ چەند حالەت بە switch',
  'subtitle_ba'=>'بەراوردکرنا یەک بەها ل گەل چەند حالەتان پێ switch',
  'content_so'=>'<p><code>switch</code> بۆ بەراوردکردن یەک بەها لەگەڵ چەند حالەت:</p><pre>switch($reng){
  case "sor": echo "Sor"; break;
  default: echo "Din";
}</pre>',
  'content_ba'=>'<p><code>switch</code> بو بەراوردکرنا بەهایەک ل گەل چەند حالەتان:</p>',
  'code'=>'<?php
$roj = "Sêşem";
switch($roj) {  // بەراوردی ناوی ڕۆژ
    case "Duşem": echo "Yekem roj\\n"; break;
    case "Sêşem": echo "Duyem roj\\n"; break;
    case "Înî": echo "Dawî heftê\\n"; break;
    default: echo "Roja din\\n";  // ئەگەر هیچ حالەتێک نەگونجا
}
?>',
  'example_output'=>'Duyem roj',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر $roj="Înî" بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'گەر $roj="Înî" بیت، چ چاپ دبیت؟',
  'quiz_options_so'=>['Dawî heftê', 'Yekem roj', 'Duyem roj', 'Roja din'],
  'quiz_options_ba'=>['Dawî heftê', 'Yekem roj', 'Duyem roj', 'Roja din'],
  'quiz_correct'=>'0',
],

[
  'order'=>'7',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی for',
  'title_ba'=>'گەڕخستنا for',
  'subtitle_so'=>'دووبارەکردنەوە بە ژمارەی دیاریکراو بە for',
  'subtitle_ba'=>'دووبارەکرن ب ژمارا دیاریکراڤ پێ for',
  'content_so'=>'<p><code>for</code> بۆ دووبارەکردنەوە:</p><pre>for ($i=1;$i<=5;$i++) echo $i."\\n";</pre>',
  'content_ba'=>'<p><code>for</code> بو دووبارەکرن:</p><pre>for ($i=1;$i<=5;$i++) echo $i."\\n";</pre>',
  'code'=>'<?php
// خولگەی for: لە ١ بۆ ٥
for ($i=1;$i<=5;$i++) echo "Jimare: $i\\n";
echo "Dawî bû\\n";
?>',
  'example_output'=>'Jimare: 1
Jimare: 2
Jimare: 3
Jimare: 4
Jimare: 5
Dawî bû',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
for ($i=1;$i<=3;$i--) echo $i."\\n";
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
for ($i=1;$i<=3;$i--) echo $i."\\n";
?>',
  'expected_output_text'=>'1
2
3',
  'solution_code'=>'<?php
for ($i=1;$i<=3;$i++) echo $i."\\n"; // i++ ne i--
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'8',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'while و do-while',
  'title_ba'=>'while û do-while',
  'subtitle_so'=>'خولگەی while و do-while بۆ دووبارەکردنەوە',
  'subtitle_ba'=>'گەڕخستنا while و do-while بو دووبارەکرنێ',
  'content_so'=>'<p><code>while</code> تا کاتێک مەرج راستە دەخولێت. <code>do-while</code> لانەکەمی یەک جار ئەجرا دەکات.</p>',
  'content_ba'=>'<p><code>while</code> هەتا کو مەرج راست دگەڕخیت. <code>do-while</code> لانەکەمی یەک جار ئیجرا دکەت.</p>',
  'code'=>'<?php
$n=5;
while ($n>0) { echo $n." "; $n--; }  // هەتا مەرجەکە راستە
echo "\\n";
$j=0;
do { echo $j." "; $j++; } while ($j<3);  // یەکەم جار هەمیشە ئەجرا دەبێت
echo "\\n";
?>',
  'example_output'=>'5 4 3 2 1 
0 1 2 ',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەی جۆتەکانی ٢ بۆ ١٠ بە while چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ژمارێن جۆتی ٢ هەتا ١٠ پێ while چاپ بکەت.',
  'expected_output_text'=>'2
4
6
8
10',
  'solution_code'=>'<?php
$i=2;
while($i<=10){echo $i."\\n";$i+=2;}
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'9',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'foreach',
  'title_ba'=>'foreach',
  'subtitle_so'=>'خولاندنی ئارا بە foreach بە سادەیی',
  'subtitle_ba'=>'خولاندنا ئارا پێ foreach ب سادهیی',
  'content_so'=>'<p><code>foreach</code> تایبەتە بۆ خولاندنی ئاراکان:</p><pre>$nav=["Azad","Baran"];
foreach($nav as $n) echo $n."\\n";</pre>',
  'content_ba'=>'<p><code>foreach</code> تایبەتە بو خولاندنا ئاراکان:</p>',
  'code'=>'<?php
$bajer=["Hewler","Silemani","Duhok"];  // ئارایەک لە شارەکان
foreach($bajer as $i=>$b) echo ($i+1).". $b\\n";  // خولاندن بەسەر ئارادا
?>',
  'example_output'=>'1. Hewler
2. Silemani
3. Duhok',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'foreach لە PHP بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'foreach د PHP دا بو چی بکارتیت؟',
  'quiz_options_so'=>['خولاندنی ئاراکان', 'دروستکردنی فایل', 'پەیوەندی داتابەیس', 'کاری بیرکاری'],
  'quiz_options_ba'=>['خولاندنا ئاراکان', 'دروستکرنا فایل', 'Peywendî DB', 'Karê math'],
  'quiz_correct'=>'0',
],

[
  'order'=>'10',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'break و continue',
  'title_ba'=>'break û continue',
  'subtitle_so'=>'کۆنترۆڵکردنی خولگەکان بە break و continue',
  'subtitle_ba'=>'کۆنترۆلکرنا گەڕخستانان پێ break و continue',
  'content_so'=>'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
  'content_ba'=>'<p><code>break</code> گەڕخستن دادەستنێت. <code>continue</code> گەڕانا ئێستا تێپەڕ دکەت.</p>',
  'code'=>'<?php
for($i=1;$i<=10;$i++){
    if($i==7) break;       // وەستاندنی خولگە لە ٧
    if($i%2==0) continue;  // تێپەڕاندنی ژمارە جووتەکان
    echo $i." ";
}
echo "\\n";
?>',
  'example_output'=>'1 3 5 ',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
<?php
for($i=1;$i<=5;$i++){
  if($i==3) continue;
  echo $i." ";
}
?>',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
<?php
for($i=1;$i<=5;$i++){
  if($i==3) continue;
  echo $i." ";
}
?>',
  'quiz_options_so'=>['1 2 4 5 ', '1 2 3 4 5 ', '1 2 ', 'هەڵە'],
  'quiz_options_ba'=>['1 2 4 5 ', '1 2 3 4 5 ', '1 2 ', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'11',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی تێکەڵ',
  'title_ba'=>'گەڕخستنا تێکەل',
  'subtitle_so'=>'خولگە لە ناو خولگە بۆ دروستکردنی جەدەوەل',
  'subtitle_ba'=>'گەڕخستن ل ناڤ گەڕخستنێ بو جەدەوەلان',
  'content_so'=>'<p>خولگەی تێکەڵ: خولگەیەک لە ناو خولگەیەکدا. بۆ جەدەوەل و نموونەکان بەکاردێت.</p>',
  'content_ba'=>'<p>گەڕخستنا تێکەل: گەڕخستنەک لە ناو گەڕخستنەکا دی. بو جەدەوەلان بکارتیت.</p>',
  'code'=>'<?php
// خولگەی تێکەڵ: خولگەیەک لە ناو خولگەیەکی تر
for($i=1;$i<=3;$i++){
    for($j=1;$j<=3;$j++) printf("%4d",$i*$j);  // خولگەی ناوەکی
    echo "\\n";
}
?>',
  'example_output'=>'   1   2   3
   2   4   6
   3   6   9',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
for($i=1;$i<=3;$i++)
    for($j=1;$j<=3;$j++)
    echo $j." ";
    echo "\\n";
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
for($i=1;$i<=3;$i++)
    for($j=1;$j<=3;$j++)
    echo $j." ";
    echo "\\n";
?>',
  'expected_output_text'=>'1 2 3 
1 2 3 
1 2 3 ',
  'solution_code'=>'<?php
for($i=1;$i<=3;$i++){
    for($j=1;$j<=3;$j++) echo $j." ";
    echo "\\n";
}
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'12',
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'مەرجی Ternary',
  'title_ba'=>'Mêrca Ternary',
  'subtitle_so'=>'شێوەی کورتی if/else بە ?:',
  'subtitle_ba'=>'شێوازا کورتا if/else پێ ?:',
  'content_so'=>'<p>Ternary شێوەی کورتی if/else: <code>$encam = $mêrj ? $erê : $na;</code></p><pre>$temen=20;
echo $temen>=18 ? "Mezin" : "Picuk";</pre>',
  'content_ba'=>'<p>Ternary şêwazê kurt yê if/else: <code>$encam = $mêrj ? $erê : $na;</code></p>',
  'code'=>'<?php
$nrx = 85;
// شێوەی کورتی if/else — Ternary
$asta = $nrx>=90 ? "Taqez" : ($nrx>=60 ? "Bas" : "Nekefte");
echo $asta."\\n";
$reng="kesk";
echo ($reng=="kesk") ? "Rengê xweza\\n" : "Rengekî din\\n";
?>',
  'example_output'=>'Bas
Rengê xweza',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەیەک وەربگرێت و بە ternary بەراوردبکات: ئەگەر گەورەتر لە ١٠ بێت "Mezin" بەڵام نەوەک "Biçûk" چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ژمارەکا وەربگریت و ب ternary: گەر مەزنتر ژ ١٠ بیت "Mezin" نەوەک "Biçûk" چاپ بکەت.',
  'expected_output_text'=>'Jimare: 15
Mezin',
  'solution_code'=>'<?php
$j=(int)readline("Jimare: ");
echo ($j>10?"Mezin":"Bicuk")."\\n";
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'13',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'ئارای ئیندێکس',
  'title_ba'=>'ئارایا Indeks',
  'subtitle_so'=>'ئارا، ڕیزکردن و فانکشنی count/max/min',
  'subtitle_ba'=>'ئارا، ڕیزکرن و فانکشنێن count/max/min',
  'content_so'=>'<p>ئارای لە PHP کۆمەڵێک بەهای لە ژێر یەک ناودا:</p><pre>$nav=["Azad","Baran","Ciya"];
echo $nav[0]; // Azad
echo count($nav); // 3
$nav[]="Dara"; // زیادکردن</pre>',
  'content_ba'=>'<p>ئارا د PHP دا کۆمەکێک بەهایان ژێر یەک ناڤ:</p><pre>$nav=["Azad","Baran"];
echo $nav[0]; // Azad
echo count($nav); // 2</pre>',
  'code'=>'<?php
$nrx=[85,92,78,95,67];  // ئارای نمرەکان
sort($nrx);  // ڕیزکردن
foreach($nrx as $n) echo $n." ";
echo "\\nMax: ".max($nrx)."\\n";  // زۆرترین بەها
echo "Min: ".min($nrx)."\\n";     // کەمترین بەها
?>',
  'example_output'=>'67 78 85 92 95 
Max: 95
Min: 67',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
$a=[3,1,4,1,5];
echo count($a);',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
$a=[3,1,4,1,5];
echo count($a);',
  'quiz_options_so'=>['5', '4', '14', 'هەڵە'],
  'quiz_options_ba'=>['5', '4', '14', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'14',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'ئارای هاوشێوە',
  'title_ba'=>'ئارایا Hevseng',
  'subtitle_so'=>'ئارای هاوشێوە (کلیل-بەها) و خولاندنیان',
  'subtitle_ba'=>'ئارایا هەڤشێوە (کلیل-بەها) و خولاندنا وان',
  'content_so'=>'<p>ئارای هاوشێوە (associative) کلیل و بەهایەک هەیە:</p><pre>$kes=["nav"=>"Azad","temen"=>25];
echo $kes["nav"]; // Azad</pre>',
  'content_ba'=>'<p>ئارایا hevşêweyê kilîl û behe heye:</p><pre>$kes=["nav"=>"Azad","temen"=>25];
echo $kes["nav"]; // Azad</pre>',
  'code'=>'<?php
$xwendekar=["nav"=>"Baran","nrx"=>88,"bajer"=>"Hewler"];  // ئارای هاوشێوە
foreach($xwendekar as $k=>$v) echo "$k: $v\\n";  // چاپکردنی کلیل و بەها
?>',
  'example_output'=>'nav: Baran
nrx: 88
bajer: Hewler',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
$a=["nav"=>"Kurd"];
echo $a[nav];
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
$a=["nav"=>"Kurd"];
echo $a[nav];
?>',
  'expected_output_text'=>'Kurd',
  'solution_code'=>'<?php
$a=["nav"=>"Kurd"];
echo $a["nav"]; // دڤێت quotes هەبیت
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'15',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'فانکشنی ئارا',
  'title_ba'=>'Fanksiyonên Araya',
  'subtitle_so'=>'فانکشنەکانی ئارا: array_push، in_array و rsort',
  'subtitle_ba'=>'فانکشنێن ئارا: array_push، in_array و rsort',
  'content_so'=>'<p>PHP فانکشنی ئارایی زۆری هەیە: <code>array_push()</code>، <code>array_pop()</code>، <code>array_search()</code>، <code>in_array()</code>، <code>array_merge()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên araya: <code>array_push()</code>، <code>array_pop()</code>، <code>in_array()</code>.</p>',
  'code'=>'<?php
$bajer=["Hewler","Silemani"];
array_push($bajer,"Duhok","Zaxo");  // زیادکردنی شار
echo implode(", ",$bajer)."\\n";    // بەستنی ئارا بۆ دەق
echo in_array("Duhok",$bajer)?"Heye\\n":"Nîne\\n";  // پشکنینی بوونی بەها
$jimare=[5,2,8,1];
rsort($jimare);  // ڕیزکردنی دابەزین
print_r($jimare);
?>',
  'example_output'=>'Hewler, Silemani, Duhok, Zaxo
Heye
Array
(
    [0] => 8
    [1] => 5
    [2] => 2
    [3] => 1
)',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'<code>in_array("x",$a)</code> چی دەگەڕێنێتەوە ئەگەر "x" نەبێت؟',
  'quiz_question_ba'=>'<code>in_array("x",$a)</code> چ دگەڕینێتەوە گەر "x" نەبیت؟',
  'quiz_options_so'=>['false', 'null', '0', 'هەڵە'],
  'quiz_options_ba'=>['false', 'null', '0', 'خەلەت'],
  'quiz_correct'=>'0',
],

[
  'order'=>'16',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'فانکشنی دەق',
  'title_ba'=>'Fanksiyonên Nivîsînê',
  'subtitle_so'=>'بەستن و جیاکردنەوەی دەق: explode، implode، trim و number_format',
  'subtitle_ba'=>'بەستن و جیاکرنا نڤیسینێ: explode، implode، trim و number_format',
  'content_so'=>'<p>فانکشنی دەقی گرنگ: <code>trim()</code>، <code>explode()</code>، <code>implode()</code>، <code>str_pad()</code>، <code>number_format()</code>، <code>sprintf()</code>.</p>',
  'content_ba'=>'<p>Fanksiyonên girîng: <code>trim()</code>، <code>explode()</code>، <code>implode()</code>.</p>',
  'code'=>'<?php
$navên="Azad,Baran,Ciya";
$lîste=explode(",",$navên);  // دابەشکردنی دەق بۆ ئارا
foreach($lîste as $n) echo "- ".trim($n)."\\n";  // لابردنی بۆشاییەکان
echo implode(" | ",$lîste)."\\n";  // بەستنەوەی ئارا بۆ دەق
$nrx=1234567.89;
echo number_format($nrx,2,".","،")."\\n";  // ڕێکخستنی ژمارە
?>',
  'example_output'=>'- Azad
- Baran
- Ciya
Azad | Baran | Ciya
1،234،567.89',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ریزبەندێک لەگەڵ explode جیا بکات بە فاصڵە.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو rêzeke pê explode ji "," bike.',
  'expected_output_text'=>'Hewler
Simlemani
Duhok',
  'solution_code'=>'<?php
$s="Hewler,Simlemani,Duhok";
$a=explode(",",$s);
foreach($a as $b) echo $b."\\n";
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'17',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'Date و Time',
  'title_ba'=>'Date û Time',
  'subtitle_so'=>'کارکردن لەگەڵ ڕێکەوت و کات بە date()',
  'subtitle_ba'=>'کارکرن ل گەل دیرۆک و دەم پێ date()',
  'content_so'=>'<p>PHP <code>date()</code> فانکشنی بۆ کاتژمێر و ڕێکەوت:</p><pre>echo date("Y-m-d");     // 2026-08-06
echo date("H:i:s");     // 14:30:00
echo time();            // Unix timestamp</pre>',
  'content_ba'=>'<p>PHP <code>date()</code> fanksiyonê bO dema û rojê:</p><pre>echo date("Y-m-d");
echo date("H:i:s");
echo time();</pre>',
  'code'=>'<?php
echo "Sal: ".date("Y")."\\n";   // ساڵی ئێستا
echo "Mang: ".date("m")."\\n";  // مانگی ئێستا
echo "Roj: ".date("d")."\\n";   // ڕۆژی ئێستا
$zeman=mktime(0,0,0,8,6,2026);  // دروستکردنی کات بە ڕێکەوت
echo date("d/m/Y",$zeman)."\\n";
?>',
  'example_output'=>'Sal: 2026
Mang: 08
Roj: 06
06/08/2026',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'date("Y") چی دەگەڕێنێتەوە؟',
  'quiz_question_ba'=>'date("Y") çi degerîne?',
  'quiz_options_so'=>['ساڵی ئێستا', 'مانگی ئێستا', 'ڕۆژی ئێستا', 'کاتژمێر'],
  'quiz_options_ba'=>['Sala niha', 'Meha niha', 'Roja niha', 'Saet'],
  'quiz_correct'=>'0',
],

[
  'order'=>'18',
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'Math Functions',
  'title_ba'=>'Fanksiyonên Math',
  'subtitle_so'=>'فانکشنی ماتماتیکی: abs، ceil، round و sqrt',
  'subtitle_ba'=>'فانکشنێن ماتەماتیکی: abs، ceil، round و sqrt',
  'content_so'=>'<p>PHP فانکشنی ماتماتیکی زۆری هەیە: <code>abs()</code>، <code>ceil()</code>، <code>floor()</code>، <code>round()</code>، <code>sqrt()</code>، <code>pow()</code>، <code>rand()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên matematîkî: <code>abs()</code>، <code>ceil()</code>، <code>sqrt()</code>، <code>rand()</code>.</p>',
  'code'=>'<?php
echo abs(-15)."\\n";       // 15 — بەهای مطلق
echo ceil(4.2)."\\n";      // 5 — گردکردنەوە بۆ سەرەوە
echo floor(4.9)."\\n";     // 4 — گردکردنەوە بۆ خوارەوە
echo round(4.567,2)."\\n"; // 4.57 — گردکردنەوە
echo sqrt(144)."\\n";      // 12 — ڕەگی دووجا
echo pow(2,10)."\\n";      // 1024 — هێز
?>',
  'example_output'=>'15
5
4
4.57
12
1024',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
echo squareroot(16);
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
echo squareroot(16);
?>',
  'expected_output_text'=>'4',
  'solution_code'=>'<?php
echo sqrt(16); // sqrt() ne squareroot()
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'19',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'فەنکشن',
  'title_ba'=>'Fanksiyonên',
  'subtitle_so'=>'دروستکردن و بانگکردنی فەنکشن',
  'subtitle_ba'=>'دروستکرن و بانگکرنا فانکشنان',
  'content_so'=>'<p>فەنکشن بەشێکی کۆدی دووبارە بەکارهاتنییە:</p><pre>function kot($a,$b) { return $a+$b; }
echo kot(3,5); // 8</pre>',
  'content_ba'=>'<p>Fanksiyoneke beşek kode ku dîsa tê bikaranîn:</p><pre>function kot($a,$b){return $a+$b;}
echo kot(3,5); // 8</pre>',
  'code'=>'<?php
function pakkirdin($nav){  // فەنکشنی پاککردنەوەی دەق
    return trim(strtolower($nav));
}
function pezkirdin($n,$p=2){  // فەنکشنی گردکردنەوە بە پارامیتەری بنەڕەت
    return round($n,$p);
}
echo pakkirdin("  KURD  ")."\\n";  // kurd
echo pezkirdin(3.14159)."\\n";     // 3.14
?>',
  'example_output'=>'kurd
3.14',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
function selam $nav) {
    echo "Silav $nav!\\n";
}
selam("Kurd");
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
function selam $nav) {
    echo "Silav $nav!\\n";
}
selam("Kurd");
?>',
  'expected_output_text'=>'Silav Kurd!',
  'solution_code'=>'<?php
function selam($nav) { // pêwîste "(" hebe
    echo "Silav $nav!\\n";
}
selam("Kurd");
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'20',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Scope و Return',
  'title_ba'=>'Scope û Return',
  'subtitle_so'=>'گۆڕاوە گلۆبالەکان و بەهای گەڕانەوە',
  'subtitle_ba'=>'گۆڕۆکێن global و بەهێن ڤەگەرانێ',
  'content_so'=>'<p>گۆڕاوە گلۆبالەکان لە ناو فەنکشن ناکرێن بەکاربهێنرێن بەبێ <code>global</code>:</p><pre>$x = 10;
function test(){
    global $x;
    echo $x;
}</pre>',
  'content_ba'=>'<p>Giyorvaokên global nakevin nav fanksiyonê bê <code>global</code>:</p>',
  'code'=>'<?php
$jimare=100;  // گۆڕاوەی گلۆبال
function zedeke($n){
    return $n * 2;
}
function global_test(){
    global $jimare;  // بەکارهێنانی گۆڕاوەی گلۆبال لە ناو فەنکشن
    $jimare += 50;
}
global_test();
echo $jimare."\\n";    // 150
echo zedeke(7)."\\n";  // 14
?>',
  'example_output'=>'150
14',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە فەنکشنێکی recursive بنووسێت کە factorial بژمێرێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko fanksiyoneke recursive binivîse ko factorial bijmêre.',
  'expected_output_text'=>'5! = 120',
  'solution_code'=>'<?php
function factorial($n){
    if($n<=1) return 1;
    return $n * factorial($n-1);
}
echo "5! = ".factorial(5)."\\n";
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'21',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'کلاس و Object',
  'title_ba'=>'Klas û Object',
  'subtitle_so'=>'بنەماکانی OOP: کلاس، ئۆبجێکت و __construct',
  'subtitle_ba'=>'بنگەهێن OOP: کلاس، ئوبجێکت و __construct',
  'content_so'=>'<p>کلاس شابلۆنی ئۆبجێکتێکە. بە <code>new</code> ئۆبجێکت دروست دەکرێت:</p><pre>class Mirov {
    public $nav;
    function danasîn() { echo $this->nav; }
}</pre>',
  'content_ba'=>'<p>Klas şabloneke bO objekt. Bi <code>new</code> obekt tê çêkirin:</p>',
  'code'=>'<?php
class Xwendekar {
    public $nav;   // تایبەتمەندی: ناو
    public $nrx;   // تایبەتمەندی: نمرە
    function __construct($n,$s){  // کۆنستراکتەر: بەهای سەرەتایی
        $this->nav=$n; $this->nrx=$s;
    }
    function danasîn(){
        echo $this->nav.": ".$this->nrx."\\n";
    }
}
$x=new Xwendekar("Azad",92);  // دروستکردنی ئۆبجێکت
$x->danasîn();
echo $x->nav."\\n";
?>',
  'example_output'=>'Azad: 92
Azad',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە PHP $this چییە؟',
  'quiz_question_ba'=>'Di PHP de $this çi ye?',
  'quiz_options_so'=>['ئاماژەی ئۆبجێکتی ئێستا', 'گۆڕاوی گلۆبال', 'فەنکشن', 'ئارا'],
  'quiz_options_ba'=>['Referansa obejkta niha', 'Giyorvaek global', 'Fanksiyoneke', 'Array'],
  'quiz_correct'=>'0',
],

[
  'order'=>'22',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Inheritance',
  'title_ba'=>'Inheritance',
  'subtitle_so'=>'وەرگرتنی تایبەتمەندی کلاسێک لە کلاسێکی تر بە extends',
  'subtitle_ba'=>'وەرگرتنا تایبەتمەندییێن کلاسەکا ژ کلاسەکا دی پێ extends',
  'content_so'=>'<p>Inheritance ڕێگەت دەدات کلاسێک تایبەتمەندی کلاسێکی تری وەربگرێت بە <code>extends</code>.</p>',
  'content_ba'=>'<p>Inheritance di PHP bi <code>extends</code>:</p>',
  'code'=>'<?php
class Heywên {  // کلاسی سەرەکی (باوک)
    public $nav;
    function __construct($n){ $this->nav=$n; }
    function xwe(){ echo "Ez ".get_class($this)." im\\n"; }
}
class Se extends Heywên {  // وەرگرتنی تایبەتمەندی — Inheritance
    function deng(){ echo $this->nav." dibêje: Haw!\\n"; }
}
$s=new Se("Zato");
$s->xwe();
$s->deng();
?>',
  'example_output'=>'Ez Se im
Zato dibêje: Haw!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
<?php
class A { function test(){ echo "A\\n"; } }
class B implements A {}
$b=new B();
$b->test();
?>',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
<?php
class A { function test(){ echo "A\\n"; } }
class B implements A {}
$b=new B();
$b->test();
?>',
  'expected_output_text'=>'A',
  'solution_code'=>'<?php
class A { function test(){ echo "A\\n"; } }
class B extends A {} // extends ne implements bo klas
$b=new B();
$b->test();
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'23',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Interface و Abstract',
  'title_ba'=>'Interface û Abstract',
  'subtitle_so'=>'Interface و Abstract: گرێبەست و کلاسی نیوەکارکراو',
  'subtitle_ba'=>'Interface و Abstract: گرێبەست و کلاسا نیوەکارکرایی',
  'content_so'=>'<p>Interface گڕێبەستی بەکلاسەکان دادەبەستێت. Abstract کلاسێکی نیوەکارکراوە.</p>',
  'content_ba'=>'<p>Interface girêbestê li klaşan datebeste. Abstract klaşeke nîwekarkrawiye.</p>',
  'code'=>'<?php
interface Şanoy {  // گرێبەست: دیاریکردنی میتۆد
    public function şano();
}
class Stranbêj implements Şanoy {  // جێبەجێکردنی گرێبەست
    public $nav;
    function __construct($n){ $this->nav=$n; }
    public function şano(){
        echo $this->nav." stran dixwîne\\n";
    }
}
$s=new Stranbêj("Şivan");
$s->şano();
?>',
  'example_output'=>'Şivan stran dixwîne',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Interface لە PHP بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Interface di PHP de bO çi tê bikaranîn?',
  'quiz_options_so'=>['دیاریکردنی گڕێبەست', 'وەرثەی کلاس', 'دروستکردنی ئۆبجێکت', 'خولاندنی ئارا'],
  'quiz_options_ba'=>['Diyarkirina girêbest', 'Mîrêya klas', 'Çêkirina obejkt', 'Xolandina araye'],
  'quiz_correct'=>'0',
],

[
  'order'=>'24',
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Exception Handling',
  'title_ba'=>'Exception Handling',
  'subtitle_so'=>'کۆنترۆڵکردنی هەڵەکان بە try/catch/finally',
  'subtitle_ba'=>'کۆنترۆلکرنا هەڵەیان پێ try/catch/finally',
  'content_so'=>'<p><code>try/catch/finally</code> بۆ کۆنترۆڵکردنی هەڵەکان:</p><pre>try { throw new Exception("Hêle"); }
catch(Exception $e){ echo $e->getMessage(); }
finally{ echo "Her tim"; }</pre>',
  'content_ba'=>'<p><code>try/catch/finally</code> bO kontrolkirina helekan:</p>',
  'code'=>'<?php
function dabeşkirin($a,$b){
    if($b===0) throw new Exception("Dabeşkirina bi sifir!");  // هەڵەدان
    return $a/$b;
}
try {
    echo dabeşkirin(10,2)."\\n";
    echo dabeşkirin(10,0)."\\n";
} catch(Exception $e) {  // گرتنی هەڵە
    echo "Hêle: ".$e->getMessage()."\\n";
} finally {
    echo "Temam bû\\n";  // هەمیشە جێبەجێ دەبێت
}
?>',
  'example_output'=>'5
Hêle: Dabeşkirina bi sifir!
Temam bû',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە هەڵەی ئارایی دەرجووی سنوور بگرێتەوە.',
  'practice_question_ba'=>'Bernameyeke binivîse ko helaya arrayek ji sinor derket bigire.',
  'expected_output_text'=>'Hêle: Index tune
Temam bû',
  'solution_code'=>'<?php
try{
    $a=[1,2,3];
    if(!isset($a[10])) throw new Exception("Index tune");
} catch(Exception $e){
    echo "Hêle: ".$e->getMessage()."\\n";
} finally{
    echo "Temam bû\\n";
}
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'25',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'GET و POST',
  'title_ba'=>'GET û POST',
  'subtitle_so'=>'وەرگرتنی داتای فۆرم بە $_GET و $_POST',
  'subtitle_ba'=>'وەرگرتنا داتایێن فۆرمێ پێ $_GET و $_POST',
  'content_so'=>'<p>لە PHP <code>$_GET</code> و <code>$_POST</code> داخڵی فۆڕمی وێب وەردەگرن.</p><pre>// URL: ?nav=Kurd
echo $_GET["nav"]; // Kurd
// فۆڕمی POST:
echo $_POST["email"];</pre>',
  'content_ba'=>'<p>Di PHP de <code>$_GET</code> û <code>$_POST</code> daneyên formê werdidgirin.</p>',
  'code'=>'<?php
// نیشانەسازی داتای فۆرم
$_POST["nav"]="Azad";
$_POST["email"]="azad@kurd.ai";
if(!empty($_POST["nav"])){
    $nav=htmlspecialchars($_POST["nav"]);  // پاراستن لە HTML
    echo "Silav, $nav!\\n";
    echo "Email: ".$_POST["email"]."\\n";
} else {
    echo "Nav vala ye\\n";
}
?>',
  'example_output'=>'Silav, Azad!
Email: azad@kurd.ai',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'htmlspecialchars() بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'htmlspecialchars() bO çi tê bikaranîn?',
  'quiz_options_so'=>['پارێزگاری لە XSS', 'ئینکۆدکردنی دەق', 'هەڵگرتنی فایل', 'پەیوەندی داتابەیس'],
  'quiz_options_ba'=>['Parêzgariya XSS', 'Enkodkirina nivîsê', 'Hilgirtina file', 'Peywendiya DB'],
  'quiz_correct'=>'0',
],

[
  'order'=>'26',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'فایل خوێندن و نووسین',
  'title_ba'=>'File Xwendin û Nivîsîn',
  'subtitle_so'=>'خوێندن و نووسینی فایل بە file_put_contents',
  'subtitle_ba'=>'خوێندن و نڤیسینا فایلان پێ file_put_contents',
  'content_so'=>'<p>PHP فانکشنی فایلی زۆری هەیە: <code>file_put_contents()</code>، <code>file_get_contents()</code>، <code>fopen()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên file: <code>file_put_contents()</code>، <code>file_get_contents()</code>.</p>',
  'code'=>'<?php
$nav="/tmp/kurd_test.txt";
file_put_contents($nav,"Silav Kurdistan!\\nJava bax e\\n");  // نووسین لە فایل
$nav2=file_get_contents($nav);  // خوێندنەوەی فایل
echo $nav2;
$rêz=file($nav);  // خوێندنەوە بە ڕیزەکان
echo "Jimare rêzan: ".count($rêz)."\\n";
unlink($nav);  // سڕینەوەی فایل
?>',
  'example_output'=>'Silav Kurdistan!
Java bax e
Jimare rêzan: 2',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەی ریزەکانی فایلێک بژمێرێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko hejmara rêzan a fileke bijmêre.',
  'expected_output_text'=>'Rêz: 3',
  'solution_code'=>'<?php
$f="/tmp/t.txt";
file_put_contents($f,"r1\\nr2\\nr3\\n");
echo "Rêz: ".count(file($f))."\\n";
unlink($f);
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'27',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'Session',
  'title_ba'=>'Session',
  'subtitle_so'=>'هەڵگرتنی داتا لەنێوان داواکاریەکان بە Session',
  'subtitle_ba'=>'هەڵگرتنا داتایان د ناڤبەرا داواخوازان پێ Session',
  'content_so'=>'<p>Session داتا لەنێوان داواکاریەکان هەلدەگرێت:</p><pre>session_start();
$_SESSION["nav"]="Kurd";
// لەسەر پەیجی دیکە:
echo $_SESSION["nav"]; // Kurd</pre>',
  'content_ba'=>'<p>Session daneyan di navbera daxwazîyan de dihêle:</p>',
  'code'=>'<?php
// نیشانەسازی سێشن بۆ تاقیکردنەوە
$_SESSION=["nav"=>"Azad","rol"=>"Admin"];  // داتای سێشن
echo "Nav: ".$_SESSION["nav"]."\\n";
echo "Rol: ".$_SESSION["rol"]."\\n";
if(isset($_SESSION["nav"])) echo "Session heye\\n";  // پشکنینی بوونی داتا
unset($_SESSION["nav"]);  // سڕینەوەی داتا
echo (isset($_SESSION["nav"]) ? "Heye" : "Tune")."\\n";
?>',
  'example_output'=>'Nav: Azad
Rol: Admin
Session heye
Tune',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'session_start() کەی دەبێت بانگ بکرێت؟',
  'quiz_question_ba'=>'session_start() kengî divê were bangkirin?',
  'quiz_options_so'=>['پێش هەر output', 'دواتر هەر کاتێک', 'دواتر HTML', 'تەنها یەک جار'],
  'quiz_options_ba'=>['Beriya her çapkirinê', 'Piştî çapkirinê', 'Piştî HTML', 'Tenê carekê'],
  'quiz_correct'=>'0',
],

[
  'order'=>'28',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'پرۆژە: ماشێنی ژمارەکردن',
  'title_ba'=>'Proje: Mêşîna Jimarê',
  'subtitle_so'=>'پرۆژە: ماشێنی ژمارەکردن بە فەنکشن',
  'subtitle_ba'=>'پرۆژە: ئامێرا ژمارەکرنێ پێ فانکشن',
  'content_so'=>'<p>پرۆژەی یەکەم — ماشێنی ژمارەکردنی سادە:</p>',
  'content_ba'=>'<p>Proje ya yekem — mêşîna jimarêkirina sade:</p>',
  'code'=>'<?php
function calculate($a,$op,$b){  // فەنکشنی ماشێنی ژمارەکردن
    switch($op){
        case "+": return $a+$b;
        case "-": return $a-$b;
        case "*": return $a*$b;
        case "/": return $b!=0 ? $a/$b : "Hêle: sifir";  // ڕێگری لە دابەشکردن بە سفر
        default: return "Operator nenas";
    }
}
$tests=[[10,"+",5],[20,"-",8],[6,"*",7],[15,"/",3]];
foreach($tests as $t)
    echo $t[0]." ".$t[1]." ".$t[2]." = ".calculate($t[0],$t[1],$t[2])."\\n";
?>',
  'example_output'=>'10 + 5 = 15
20 - 8 = 12
6 * 7 = 42
15 / 3 = 5',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ئارایەک لەگەڵ foreach ئۆپریشن بکات و ناوەندی هەمووی بژمێرێت.',
  'practice_question_ba'=>'Bernameyeke binivîse ko arreyeke pê foreach operasyon bike û navenda hemiyê bijmêre.',
  'expected_output_text'=>'Navend: 80',
  'solution_code'=>'<?php
$nrx=[75,80,90,70,85];
$k=0;
foreach($nrx as $n) $k+=$n;
echo "Navend: ".($k/count($nrx))."\\n";
?>',
  'attempts_allowed'=>'5',
],

[
  'order'=>'29',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'پرۆژە: ئەرشیفی بەرهەم',
  'title_ba'=>'Proje: Erşîva Hilberê',
  'subtitle_so'=>'پرۆژە: ئەرشیفی بەرهەمی فرۆشگا بە OOP',
  'subtitle_ba'=>'پرۆژە: ئەرشیفا بەرهەمێن دوکانێ پێ OOP',
  'content_so'=>'<p>پرۆژەی دووەم — سیستەمی ئەرشیفی بەرهەمی فرۆشگا:</p>',
  'content_ba'=>'<p>Projeya duyem — sîstema erşîva hilberên dukênê:</p>',
  'code'=>'<?php
class Hilber {  // کلاسی بەرهەم
    public $nav, $nrx, $hejmar;
    function __construct($n,$p,$h){ $this->nav=$n; $this->nrx=$p; $this->hejmar=$h; }
    function giştî(){ return $this->nrx * $this->hejmar; }  // کۆی نرخ
}
$hilber=[new Hilber("Sêv",2.5,10),new Hilber("Tirî",5.0,6),new Hilber("Gûz",3.0,8)];
$gişt=0;
foreach($hilber as $h){
    echo $h->nav.": ".$h->giştî()."\\n";
    $gişt+=$h->giştî();  // کۆکردنەوەی گشتی
}
echo "Giştî: $gişt\\n";
?>',
  'example_output'=>'Sêv: 25
Tirî: 30
Gûz: 24
Giştî: 79',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'OOP لە PHP چیان دەبێتە ئاسانتر؟',
  'quiz_question_ba'=>'OOP di PHP de çi hêsantir dike?',
  'quiz_options_so'=>['ڕێکخستن و دووبارە بەکارهێنانی کۆد', 'خێراتر کردنی کۆد', 'کۆچ بردن بۆ داتابەیس', 'دروستکردنی UI'],
  'quiz_options_ba'=>['Rêxistin û dûbarebûna kodê', 'Bilez kirina kodê', 'Koçberdina DB', 'Çêkirina UI'],
  'quiz_correct'=>'0',
],

[
  'order'=>'30',
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'کۆتایی کۆرس — پرۆژەی کۆتایی',
  'title_ba'=>'Dawiya Kursê — Proje ya Dawî',
  'subtitle_so'=>'پوختەی هەموو بابەتەکان و پرۆژەی کۆتایی',
  'subtitle_ba'=>'پوختەیا هەمی بابەتان و پرۆژەیا دویاهی',
  'content_so'=>'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی PHP. ئەوەی فێربوویت: گۆڕاوەکان، دەق، ئارا، if/else، for/while/foreach، فەنکشن، OOP، Exception، فایل، Session.</p>',
  'content_ba'=>'<p>Aferîn! Gihîştî dawiya kursê yê PHP. Fêrbûyî: giyorvaok, nivîsîn, array, if/else, for/foreach, fanksiyonên, OOP, Exception, file, Session.</p>',
  'code'=>'<?php
class FerheNG {  // فەرهەنگی کوردی
    private $data=[];
    function zede($k,$v){ $this->data[$k]=$v; }  // زیادکردنی وتە
    function bigere($k){ return $this->data[$k] ?? "Tune"; }  // گەڕان بۆ وتە
    function hejmar(){ return count($this->data); }  // ژمارەی وتەکان
}
$f=new FerheNG();
$f->zede("av","water"); $f->zede("agir","fire"); $f->zede("erd","earth");
echo $f->bigere("av")."\\n";
echo $f->bigere("ba")."\\n";
echo "Peyvên: ".$f->hejmar()."\\n";
?>',
  'example_output'=>'water
Tune
Peyvên: 3',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە کلاسی ئازادی هەبێت کە ناو و تەمەن وەربگرێت و چاپی بکات.',
  'practice_question_ba'=>'Bernameyeke binivîse ko klaseke hebît ko nav û temen werdigire û çap dike.',
  'expected_output_text'=>'Nav: Azad, Temen: 25',
  'solution_code'=>'<?php
class Mirov{
    function __construct(public $nav,public $temen){}
    function bide(){echo "Nav: $this->nav, Temen: $this->temen\\n";}
}
(new Mirov("Azad",25))->bide();
?>',
  'attempts_allowed'=>'5',
]
];
echo 'Adding '.count($lessons).' lessons...\n';
foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);
if(isset($d['name'])){echo 'OK '.$l['order']."\n";}else{echo 'ERR '.$r."\n";exit(1);}}
echo 'Done PHP\n';
