<?php
$u='https://ai-platform-adb1b-default-rtdb.firebaseio.com/';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='-Oysj44hJLXDgdp-b9iN';
function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo "PHP OK\n";
$lessons=[
[
  'order'=>1,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'چییە PHP؟',
  'title_ba'=>'چ یە PHP؟',
  'content_so'=>'<p><strong>PHP</strong> زمانێکی server-side یە بۆ دروستکردنی ماڵپەڕی داینامیکی. لە WordPress، Laravel و زۆر فریمووەرک بەکاردێت.</p>',
  'content_ba'=>'<p><strong>PHP</strong> زمانەکەکا server-side یە بو دروستکرنا ماڵپەرێن داینامیکی. د WordPress، Laravel دا بکارتیت.</p>',
  'code'=>'<?php
echo "Silav Kurdistane!\\n";
echo "Xêrhatî bo PHP\\n";
echo "Sal: ".date("Y")."\\n";
?>',
  'example_output'=>'Silav Kurdistane!
Xêrhatî bo PHP
Sal: 2026',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'PHP زمانێکی چییە؟',
  'quiz_question_ba'=>'PHP زمانەکا چ یە؟',
  'quiz_options_so'=>['Server-side scripting','Desktop app','Mobile app','Game engine'],
  'quiz_options_ba'=>['Server-side scripting','Desktop app','Mobile app','Game engine'],
  'quiz_correct'=>0,
],
[
  'order'=>2,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'گۆڕاوەکان',
  'title_ba'=>'گۆڕۆک',
  'content_so'=>'<p>لە PHP گۆڕاوەکان بە <code>$</code> دەستپێدەکەن. پێویست ناکات جۆر دیاری بکرێت — PHP خۆی دەزانێت:</p><pre>$nav = "Kurd"; $temen = 25; $nrx = 4.5; $drust = true;</pre>',
  'content_ba'=>'<p>د PHP دا گۆڕۆک پێ <code>$</code> دەست پێ دکەن. پێویست نییە چەشن دیاری بکی:</p><pre>$nav = "Kurd"; $temen = 25;</pre>',
  'code'=>'<?php
$nav = "Kurd";
$temen = 22;
$bajar = "Hewler";
echo $nav . " ji " . $bajar . "\\n";
echo "Temen: " . $temen . "\\n";
echo "Cure: " . gettype($nav) . "\\n";
?>',
  'example_output'=>'Kurd ji Hewler
Temen: 22
Cure: string',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
<?php $x=5; $y=3; echo $x+$y; ?>',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
<?php $x=5; $y=3; echo $x+$y; ?>',
  'quiz_options_so'=>['8','53','$x+$y','هەڵە'],
  'quiz_options_ba'=>['8','53','$x+$y','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>3,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'ئۆپەراتۆرەکان',
  'title_ba'=>'ئۆپەراتۆر',
  'content_so'=>'<p>PHP ئۆپەراتۆرە بیرکارییەکانی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>، <code>**</code>. بۆ دەق: <code>.</code> بەستن.</p>',
  'content_ba'=>'<p>PHP ئۆپەراتۆرێن ماتەماتیکی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>، <code>**</code>. بو نڤیسین: <code>.</code>.</p>',
  'code'=>'<?php
$a=15; $b=4;
echo $a+$b."\\n";  // 19
echo $a-$b."\\n";  // 11
echo $a*$b."\\n";  // 60
echo $a/$b."\\n";  // 3.75
echo $a%$b."\\n";  // 3
echo $a**2."\\n";  // 225
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
  'attempts_allowed'=>5,
],
[
  'order'=>4,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'دەقەکان (Strings)',
  'title_ba'=>'نڤیسین (Strings)',
  'content_so'=>'<p>PHP فانکشنی دەقی زۆری هەیە: <code>strlen()</code>، <code>strtoupper()</code>، <code>strtolower()</code>، <code>substr()</code>، <code>str_replace()</code>.</p>',
  'content_ba'=>'<p>PHP فانکشنێن نڤیسینی زۆر: <code>strlen()</code>، <code>strtoupper()</code>، <code>substr()</code>.</p>',
  'code'=>'<?php
$s = "Kurdistan";
echo strlen($s)."\\n";          // 9
echo strtoupper($s)."\\n";    // KURDISTAN
echo substr($s,0,4)."\\n";     // Kurd
echo str_replace("stan","",$s)."\\n"; // Kurdi
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
  'attempts_allowed'=>5,
],
[
  'order'=>5,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'مەرجی if/else',
  'title_ba'=>'مەرجا if/else',
  'content_so'=>'<p>مەرجی <code>if/elseif/else</code> ڕێگەت دەدات بڕیار بدەیت:</p><pre>if ($nrx>=90) echo "Taqez";
elseif ($nrx>=60) echo "Bas";
else echo "Nekefte";</pre>',
  'content_ba'=>'<p>مەرجا <code>if/elseif/else</code> ڕێگا دیتت دەت:</p><pre>if ($nrx>=90) echo "Taqez";
elseif ($nrx>=60) echo "Bas";
else echo "Nekefte";</pre>',
  'code'=>'<?php
$temen = 20;
if ($temen >= 18) {
    echo "Mezin buye\\n";
} else {
    echo "Picuk e\\n";
}
?>',
  'example_output'=>'Mezin buye',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر $temen=15 بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'گەر $temen=15 بیت، چ چاپ دبیت؟',
  'quiz_options_so'=>['Picuk e','Mezin buye','هیچ','هەڵە'],
  'quiz_options_ba'=>['Picuk e','Mezin buye','هیچ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>6,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'switch',
  'title_ba'=>'switch',
  'content_so'=>'<p><code>switch</code> بۆ بەراوردکردن یەک بەها لەگەڵ چەند حالەت:</p><pre>switch($reng){
  case "sor": echo "Sor"; break;
  default: echo "Din";
}</pre>',
  'content_ba'=>'<p><code>switch</code> بو بەراوردکرنا بەهایەک ل گەل چەند حالەتان:</p>',
  'code'=>'<?php
$roj = "Sêşem";
switch($roj) {
    case "Duşem": echo "Yekem roj\\n"; break;
    case "Sêşem": echo "Duyem roj\\n"; break;
    case "Înî": echo "Dawî heftê\\n"; break;
    default: echo "Roja din\\n";
}
?>',
  'example_output'=>'Duyem roj',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر $roj="Înî" بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'گەر $roj="Înî" بیت، چ چاپ دبیت؟',
  'quiz_options_so'=>['Dawî heftê','Yekem roj','Duyem roj','Roja din'],
  'quiz_options_ba'=>['Dawî heftê','Yekem roj','Duyem roj','Roja din'],
  'quiz_correct'=>0,
],
[
  'order'=>7,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی for',
  'title_ba'=>'گەڕخستنا for',
  'content_so'=>'<p><code>for</code> بۆ دووبارەکردنەوە:</p><pre>for ($i=1;$i<=5;$i++) echo $i."\\n";</pre>',
  'content_ba'=>'<p><code>for</code> بو دووبارەکرن:</p><pre>for ($i=1;$i<=5;$i++) echo $i."\\n";</pre>',
  'code'=>'<?php
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
  'attempts_allowed'=>5,
],
[
  'order'=>8,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'while و do-while',
  'title_ba'=>'while û do-while',
  'content_so'=>'<p><code>while</code> تا کاتێک مەرج راستە دەخولێت. <code>do-while</code> لانەکەمی یەک جار ئەجرا دەکات.</p>',
  'content_ba'=>'<p><code>while</code> هەتا کو مەرج راست دگەڕخیت. <code>do-while</code> لانەکەمی یەک جار ئیجرا دکەت.</p>',
  'code'=>'<?php
$n=5;
while ($n>0) { echo $n." "; $n--; }
echo "\\n";
$j=0;
do { echo $j." "; $j++; } while ($j<3);
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
  'attempts_allowed'=>5,
],
[
  'order'=>9,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'foreach',
  'title_ba'=>'foreach',
  'content_so'=>'<p><code>foreach</code> تایبەتە بۆ خولاندنی ئاراکان:</p><pre>$nav=["Azad","Baran"];
foreach($nav as $n) echo $n."\\n";</pre>',
  'content_ba'=>'<p><code>foreach</code> تایبەتە بو خولاندنا ئاراکان:</p>',
  'code'=>'<?php
$bajer=["Hewler","Silemani","Duhok"];
foreach($bajer as $i=>$b) echo ($i+1).". $b\\n";
?>',
  'example_output'=>'1. Hewler
2. Silemani
3. Duhok',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'foreach لە PHP بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'foreach د PHP دا بو چی بکارتیت؟',
  'quiz_options_so'=>['خولاندنی ئاراکان','دروستکردنی فایل','پەیوەندی داتابەیس','کاری بیرکاری'],
  'quiz_options_ba'=>['خولاندنا ئاراکان','دروستکرنا فایل','Peywendî DB','Karê math'],
  'quiz_correct'=>0,
],
[
  'order'=>10,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'break و continue',
  'title_ba'=>'break û continue',
  'content_so'=>'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
  'content_ba'=>'<p><code>break</code> گەڕخستن دادەستنێت. <code>continue</code> گەڕانا ئێستا تێپەڕ دکەت.</p>',
  'code'=>'<?php
for($i=1;$i<=10;$i++){
    if($i==7) break;
    if($i%2==0) continue;
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
  'quiz_options_so'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','هەڵە'],
  'quiz_options_ba'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>11,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی تێکەڵ',
  'title_ba'=>'گەڕخستنا تێکەل',
  'content_so'=>'<p>خولگەی تێکەڵ: خولگەیەک لە ناو خولگەیەکدا. بۆ جەدەوەل و نموونەکان بەکاردێت.</p>',
  'content_ba'=>'<p>گەڕخستنا تێکەل: گەڕخستنەک لە ناو گەڕخستنەکا دی. بو جەدەوەلان بکارتیت.</p>',
  'code'=>'<?php
for($i=1;$i<=3;$i++){
    for($j=1;$j<=3;$j++) printf("%4d",$i*$j);
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
  'attempts_allowed'=>5,
],
[
  'order'=>12,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'مەرجی Ternary',
  'title_ba'=>'Mêrca Ternary',
  'content_so'=>'<p>Ternary شێوەی کورتی if/else: <code>$encam = $mêrj ? $erê : $na;</code></p><pre>$temen=20;
echo $temen>=18 ? "Mezin" : "Picuk";</pre>',
  'content_ba'=>'<p>Ternary şêwazê kurt yê if/else: <code>$encam = $mêrj ? $erê : $na;</code></p>',
  'code'=>'<?php
$nrx = 85;
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
  'attempts_allowed'=>5,
],
[
  'order'=>13,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'ئارای ئیندێکس',
  'title_ba'=>'ئارایا Indeks',
  'content_so'=>'<p>ئارای لە PHP کۆمەڵێک بەهای لە ژێر یەک ناودا:</p><pre>$nav=["Azad","Baran","Ciya"];
echo $nav[0]; // Azad
echo count($nav); // 3
$nav[]="Dara"; // زیادکردن</pre>',
  'content_ba'=>'<p>ئارا د PHP دا کۆمەکێک بەهایان ژێر یەک ناڤ:</p><pre>$nav=["Azad","Baran"];
echo $nav[0]; // Azad
echo count($nav); // 2</pre>',
  'code'=>'<?php
$nrx=[85,92,78,95,67];
sort($nrx);
foreach($nrx as $n) echo $n." ";
echo "\\nMax: ".max($nrx)."\\n";
echo "Min: ".min($nrx)."\\n";
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
  'quiz_options_so'=>['5','4','14','هەڵە'],
  'quiz_options_ba'=>['5','4','14','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>14,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'ئارای هاوشێوە',
  'title_ba'=>'ئارایا Hevseng',
  'content_so'=>'<p>ئارای هاوشێوە (associative) کلیل و بەهایەک هەیە:</p><pre>$kes=["nav"=>"Azad","temen"=>25];
echo $kes["nav"]; // Azad</pre>',
  'content_ba'=>'<p>ئارایا hevşêweyê kilîl û behe heye:</p><pre>$kes=["nav"=>"Azad","temen"=>25];
echo $kes["nav"]; // Azad</pre>',
  'code'=>'<?php
$xwendekar=["nav"=>"Baran","nrx"=>88,"bajer"=>"Hewler"];
foreach($xwendekar as $k=>$v) echo "$k: $v\\n";
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
  'attempts_allowed'=>5,
],
[
  'order'=>15,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'فانکشنی ئارا',
  'title_ba'=>'Fanksiyonên Araya',
  'content_so'=>'<p>PHP فانکشنی ئارایی زۆری هەیە: <code>array_push()</code>، <code>array_pop()</code>، <code>array_search()</code>، <code>in_array()</code>، <code>array_merge()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên araya: <code>array_push()</code>، <code>array_pop()</code>، <code>in_array()</code>.</p>',
  'code'=>'<?php
$bajer=["Hewler","Silemani"];
array_push($bajer,"Duhok","Zaxo");
echo implode(", ",$bajer)."\\n";
echo in_array("Duhok",$bajer)?"Heye\\n":"Nîne\\n";
$jimare=[5,2,8,1];
rsort($jimare);
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
  'quiz_options_so'=>['false','null','0','هەڵە'],
  'quiz_options_ba'=>['false','null','0','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>16,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'فانکشنی دەق',
  'title_ba'=>'Fanksiyonên Nivîsînê',
  'content_so'=>'<p>فانکشنی دەقی گرنگ: <code>trim()</code>، <code>explode()</code>، <code>implode()</code>، <code>str_pad()</code>، <code>number_format()</code>، <code>sprintf()</code>.</p>',
  'content_ba'=>'<p>Fanksiyonên girîng: <code>trim()</code>، <code>explode()</code>، <code>implode()</code>.</p>',
  'code'=>'<?php
$navên="Azad,Baran,Ciya";
$lîste=explode(",",$navên);
foreach($lîste as $n) echo "- ".trim($n)."\\n";
echo implode(" | ",$lîste)."\\n";
$nrx=1234567.89;
echo number_format($nrx,2,".","،")."\\n";
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
  'attempts_allowed'=>5,
],
[
  'order'=>17,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'Date و Time',
  'title_ba'=>'Date û Time',
  'content_so'=>'<p>PHP <code>date()</code> فانکشنی بۆ کاتژمێر و ڕێکەوت:</p><pre>echo date("Y-m-d");     // 2026-08-06
echo date("H:i:s");     // 14:30:00
echo time();            // Unix timestamp</pre>',
  'content_ba'=>'<p>PHP <code>date()</code> fanksiyonê bO dema û rojê:</p><pre>echo date("Y-m-d");
echo date("H:i:s");
echo time();</pre>',
  'code'=>'<?php
echo "Sal: ".date("Y")."\\n";
echo "Mang: ".date("m")."\\n";
echo "Roj: ".date("d")."\\n";
$zeman=mktime(0,0,0,8,6,2026);
echo date("d/m/Y",$zeman)."\\n";
?>',
  'example_output'=>'Sal: 2026
Mang: 08
Roj: 06
06/08/2026',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'date("Y") چی دەگەڕێنێتەوە؟',
  'quiz_question_ba'=>'date("Y") çi degerîne?',
  'quiz_options_so'=>['ساڵی ئێستا','مانگی ئێستا','ڕۆژی ئێستا','کاتژمێر'],
  'quiz_options_ba'=>['Sala niha','Meha niha','Roja niha','Saet'],
  'quiz_correct'=>0,
],
[
  'order'=>18,
  'level_so'=>'ئاستی ٣ - ئارا و دەق',
  'level_ba'=>'ئاستا ٣ - ئارا و نڤیسین',
  'title_so'=>'Math Functions',
  'title_ba'=>'Fanksiyonên Math',
  'content_so'=>'<p>PHP فانکشنی ماتماتیکی زۆری هەیە: <code>abs()</code>، <code>ceil()</code>، <code>floor()</code>، <code>round()</code>، <code>sqrt()</code>، <code>pow()</code>، <code>rand()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên matematîkî: <code>abs()</code>، <code>ceil()</code>، <code>sqrt()</code>، <code>rand()</code>.</p>',
  'code'=>'<?php
echo abs(-15)."\\n";      // 15
echo ceil(4.2)."\\n";     // 5
echo floor(4.9)."\\n";    // 4
echo round(4.567,2)."\\n"; // 4.57
echo sqrt(144)."\\n";     // 12
echo pow(2,10)."\\n";     // 1024
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
  'attempts_allowed'=>5,
],
[
  'order'=>19,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'فەنکشن',
  'title_ba'=>'Fanksiyonên',
  'content_so'=>'<p>فەنکشن بەشێکی کۆدی دووبارە بەکارهاتنییە:</p><pre>function kot($a,$b) { return $a+$b; }
echo kot(3,5); // 8</pre>',
  'content_ba'=>'<p>Fanksiyoneke beşek kode ku dîsa tê bikaranîn:</p><pre>function kot($a,$b){return $a+$b;}
echo kot(3,5); // 8</pre>',
  'code'=>'<?php
function pakkirdin($nav){
    return trim(strtolower($nav));
}
function pezkirdin($n,$p=2){
    return round($n,$p);
}
echo pakkirdin("  KURD  ")."\\n"; // kurd
echo pezkirdin(3.14159)."\\n";  // 3.14
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
  'attempts_allowed'=>5,
],
[
  'order'=>20,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Scope و Return',
  'title_ba'=>'Scope û Return',
  'content_so'=>'<p>گۆڕاوە گلۆبالەکان لە ناو فەنکشن ناکرێن بەکاربهێنرێن بەبێ <code>global</code>:</p><pre>$x = 10;
function test(){
    global $x;
    echo $x;
}</pre>',
  'content_ba'=>'<p>Giyorvaokên global nakevin nav fanksiyonê bê <code>global</code>:</p>',
  'code'=>'<?php
$jimare=100;
function zedeke($n){
    return $n * 2;
}
function global_test(){
    global $jimare;
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
  'attempts_allowed'=>5,
],
[
  'order'=>21,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'کلاس و Object',
  'title_ba'=>'Klas û Object',
  'content_so'=>'<p>کلاس شابلۆنی ئۆبجێکتێکە. بە <code>new</code> ئۆبجێکت دروست دەکرێت:</p><pre>class Mirov {
    public $nav;
    function danasîn() { echo $this->nav; }
}</pre>',
  'content_ba'=>'<p>Klas şabloneke bO objekt. Bi <code>new</code> obekt tê çêkirin:</p>',
  'code'=>'<?php
class Xwendekar {
    public $nav;
    public $nrx;
    function __construct($n,$s){
        $this->nav=$n; $this->nrx=$s;
    }
    function danasîn(){
        echo $this->nav.": ".$this->nrx."\\n";
    }
}
$x=new Xwendekar("Azad",92);
$x->danasîn();
echo $x->nav."\\n";
?>',
  'example_output'=>'Azad: 92
Azad',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە PHP $this چییە؟',
  'quiz_question_ba'=>'Di PHP de $this çi ye?',
  'quiz_options_so'=>['ئاماژەی ئۆبجێکتی ئێستا','گۆڕاوی گلۆبال','فەنکشن','ئارا'],
  'quiz_options_ba'=>['Referansa obejkta niha','Giyorvaek global','Fanksiyoneke','Array'],
  'quiz_correct'=>0,
],
[
  'order'=>22,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Inheritance',
  'title_ba'=>'Inheritance',
  'content_so'=>'<p>Inheritance ڕێگەت دەدات کلاسێک تایبەتمەندی کلاسێکی تری وەربگرێت بە <code>extends</code>.</p>',
  'content_ba'=>'<p>Inheritance di PHP bi <code>extends</code>:</p>',
  'code'=>'<?php
class Heywên {
    public $nav;
    function __construct($n){ $this->nav=$n; }
    function xwe(){ echo "Ez ".get_class($this)." im\\n"; }
}
class Se extends Heywên {
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
  'attempts_allowed'=>5,
],
[
  'order'=>23,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Interface و Abstract',
  'title_ba'=>'Interface û Abstract',
  'content_so'=>'<p>Interface گڕێبەستی بەکلاسەکان دادەبەستێت. Abstract کلاسێکی نیوەکارکراوە.</p>',
  'content_ba'=>'<p>Interface girêbestê li klaşan datebeste. Abstract klaşeke nîwekarkrawiye.</p>',
  'code'=>'<?php
interface Şanoy {
    public function şano();
}
class Stranbêj implements Şanoy {
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
  'quiz_options_so'=>['دیاریکردنی گڕێبەست','وەرثەی کلاس','دروستکردنی ئۆبجێکت','خولاندنی ئارا'],
  'quiz_options_ba'=>['Diyarkirina girêbest','Mîrêya klas','Çêkirina obejkt','Xolandina araye'],
  'quiz_correct'=>0,
],
[
  'order'=>24,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Exception Handling',
  'title_ba'=>'Exception Handling',
  'content_so'=>'<p><code>try/catch/finally</code> بۆ کۆنترۆڵکردنی هەڵەکان:</p><pre>try { throw new Exception("Hêle"); }
catch(Exception $e){ echo $e->getMessage(); }
finally{ echo "Her tim"; }</pre>',
  'content_ba'=>'<p><code>try/catch/finally</code> bO kontrolkirina helekan:</p>',
  'code'=>'<?php
function dabeşkirin($a,$b){
    if($b===0) throw new Exception("Dabeşkirina bi sifir!");
    return $a/$b;
}
try {
    echo dabeşkirin(10,2)."\\n";
    echo dabeşkirin(10,0)."\\n";
} catch(Exception $e) {
    echo "Hêle: ".$e->getMessage()."\\n";
} finally {
    echo "Temam bû\\n";
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
  'attempts_allowed'=>5,
],
[
  'order'=>25,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'GET و POST',
  'title_ba'=>'GET û POST',
  'content_so'=>'<p>لە PHP <code>$_GET</code> و <code>$_POST</code> داخڵی فۆڕمی وێب وەردەگرن.</p><pre>// URL: ?nav=Kurd
echo $_GET["nav"]; // Kurd
// فۆڕمی POST:
echo $_POST["email"];</pre>',
  'content_ba'=>'<p>Di PHP de <code>$_GET</code> û <code>$_POST</code> daneyên formê werdidgirin.</p>',
  'code'=>'<?php
// Simulation ya form data
$_POST["nav"]="Azad";
$_POST["email"]="azad@kurd.ai";
if(!empty($_POST["nav"])){
    $nav=htmlspecialchars($_POST["nav"]);
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
  'quiz_options_so'=>['پارێزگاری لە XSS','ئینکۆدکردنی دەق','هەڵگرتنی فایل','پەیوەندی داتابەیس'],
  'quiz_options_ba'=>['Parêzgariya XSS','Enkodkirina nivîsê','Hilgirtina file','Peywendiya DB'],
  'quiz_correct'=>0,
],
[
  'order'=>26,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'فایل خوێندن و نووسین',
  'title_ba'=>'File Xwendin û Nivîsîn',
  'content_so'=>'<p>PHP فانکشنی فایلی زۆری هەیە: <code>file_put_contents()</code>، <code>file_get_contents()</code>، <code>fopen()</code>.</p>',
  'content_ba'=>'<p>PHP fanksiyonên file: <code>file_put_contents()</code>، <code>file_get_contents()</code>.</p>',
  'code'=>'<?php
$nav="/tmp/kurd_test.txt";
file_put_contents($nav,"Silav Kurdistan!\\nJava bax e\\n");
$nav2=file_get_contents($nav);
echo $nav2;
$rêz=file($nav);
echo "Jimare rêzan: ".count($rêz)."\\n";
unlink($nav); // jêbirine
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
  'attempts_allowed'=>5,
],
[
  'order'=>27,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'Session',
  'title_ba'=>'Session',
  'content_so'=>'<p>Session داتا لەنێوان داواکاریەکان هەلدەگرێت:</p><pre>session_start();
$_SESSION["nav"]="Kurd";
// لەسەر پەیجی دیکە:
echo $_SESSION["nav"]; // Kurd</pre>',
  'content_ba'=>'<p>Session daneyan di navbera daxwazîyan de dihêle:</p>',
  'code'=>'<?php
// Simulation bê session_start() bo test
$_SESSION=["nav"=>"Azad","rol"=>"Admin"];
echo "Nav: ".$_SESSION["nav"]."\\n";
echo "Rol: ".$_SESSION["rol"]."\\n";
if(isset($_SESSION["nav"])) echo "Session heye\\n";
unset($_SESSION["nav"]);
echo (isset($_SESSION["nav"]) ? "Heye" : "Tune")."\\n";
?>',
  'example_output'=>'Nav: Azad
Rol: Admin
Session heye
Tune',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'session_start() کەی دەبێت بانگ بکرێت؟',
  'quiz_question_ba'=>'session_start() kengî divê were bangkirin?',
  'quiz_options_so'=>['پێش هەر output','دواتر هەر کاتێک','دواتر HTML','تەنها یەک جار'],
  'quiz_options_ba'=>['Beriya her çapkirinê','Piştî çapkirinê','Piştî HTML','Tenê carekê'],
  'quiz_correct'=>0,
],
[
  'order'=>28,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'پرۆژە: ماشێنی ژمارەکردن',
  'title_ba'=>'Proje: Mêşîna Jimarê',
  'content_so'=>'<p>پرۆژەی یەکەم — ماشێنی ژمارەکردنی سادە:</p>',
  'content_ba'=>'<p>Proje ya yekem — mêşîna jimarêkirina sade:</p>',
  'code'=>'<?php
function calculate($a,$op,$b){
    switch($op){
        case "+": return $a+$b;
        case "-": return $a-$b;
        case "*": return $a*$b;
        case "/": return $b!=0 ? $a/$b : "Hêle: sifir";
        default: return "Operator nenas";
    }
}
$tests=[[10,"+",$5=5],[20,"-",8],[6,"*",7],[15,"/",3]];
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
  'attempts_allowed'=>5,
],
[
  'order'=>29,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'پرۆژە: ئەرشیفی بەرهەم',
  'title_ba'=>'Proje: Erşîva Hilberê',
  'content_so'=>'<p>پرۆژەی دووەم — سیستەمی ئەرشیفی بەرهەمی فرۆشگا:</p>',
  'content_ba'=>'<p>Projeya duyem — sîstema erşîva hilberên dukênê:</p>',
  'code'=>'<?php
class Hilber {
    public $nav, $nrx, $hejmar;
    function __construct($n,$p,$h){ $this->nav=$n; $this->nrx=$p; $this->hejmar=$h; }
    function giştî(){ return $this->nrx * $this->hejmar; }
}
$hilber=[new Hilber("Sêv",2.5,10),new Hilber("Tirî",5.0,6),new Hilber("Gûz",3.0,8)];
$gişt=0;
foreach($hilber as $h){
    echo $h->nav.": ".$h->giştî()."\\n";
    $gişt+=$h->giştî();
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
  'quiz_options_so'=>['ڕێکخستن و دووبارە بەکارهێنانی کۆد','خێراتر کردنی کۆد','کۆچ بردن بۆ داتابەیس','دروستکردنی UI'],
  'quiz_options_ba'=>['Rêxistin û dûbarebûna kodê','Bilez kirina kodê','Koçberdina DB','Çêkirina UI'],
  'quiz_correct'=>0,
],
[
  'order'=>30,
  'level_so'=>'ئاستی ٥ - وێب و پرۆژە',
  'level_ba'=>'ئاستا ٥ - وێب و پرۆژە',
  'title_so'=>'کۆتایی کۆرس — پرۆژەی کۆتایی',
  'title_ba'=>'Dawiya Kursê — Proje ya Dawî',
  'content_so'=>'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی PHP. ئەوەی فێربوویت: گۆڕاوەکان، دەق، ئارا، if/else، for/while/foreach، فەنکشن، OOP، Exception، فایل، Session.</p>',
  'content_ba'=>'<p>Aferîn! Gihîştî dawiya kursê yê PHP. Fêrbûyî: giyorvaok, nivîsîn, array, if/else, for/foreach, fanksiyonên, OOP, Exception, file, Session.</p>',
  'code'=>'<?php
class FerheNG {
    private $data=[];
    function zede($k,$v){ $this->data[$k]=$v; }
    function bigere($k){ return $this->data[$k] ?? "Tune"; }
    function hejmar(){ return count($this->data); }
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
  'attempts_allowed'=>5,
],
];
echo 'Adding '.count($lessons).' lessons...\n';
foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);
if(isset($d['name'])){echo 'OK '.$l['order']."\n";}else{echo 'ERR '.$r."\n";exit(1);}}
echo 'Done PHP\n';
