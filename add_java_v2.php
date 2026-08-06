<?php
$u='https://ai-platform-adb1b-default-rtdb.firebaseio.com/';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='-Oysj4DmsfjAe6mjjfjT';
function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}
fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo "Java OK\n";
$lessons=[
[
  'order'=>1,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'چییە Java؟',
  'title_ba'=>'چ یە Java؟',
  'content_so'=>'<p><strong>Java</strong> زمانێکی object-oriented و بەهێزە کە لەلایەن Sun Microsystems لە ١٩٩٥ دروستکراوە. ئەمڕۆ لەلایەن Oracle بەڕێوەدەبرێت. بەکاردێت لە ئەندرۆید، وێب، و Enterprise.</p>',
  'content_ba'=>'<p><strong>Java</strong> زمانەکەکا بهێز و object-oriented یە. ژ لایەن Sun Microsystems د ١٩٩٥ هاتییە دروستکرن. بکارتیت د ئەندرۆید، وێب، Enterprise دا.</p>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        System.out.println("Silav Kurdistane!");
        System.out.println("Xêrhatî bo Java!");
    }
}',
  'example_output'=>'Silav Kurdistane!
Xêrhatî bo Java!',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'کام میتۆد دەیخاتە بەر ئەجرای بەرنامەی Java؟',
  'quiz_question_ba'=>'کا میتۆد بەرنامەیا Java دەستپێ دکەت؟',
  'quiz_options_so'=>['public static void main(String[] args)','void start()','public main()','static run()'],
  'quiz_options_ba'=>['public static void main(String[] args)','void start()','public main()','static run()'],
  'quiz_correct'=>0,
],
[
  'order'=>2,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'گۆڕاوە و جۆرەکانی داتا',
  'title_ba'=>'گۆڕۆک و چەشنێن داتایێ',
  'content_so'=>'<p>لە Java هەموو گۆڕاوێک جۆرێکی دیاریکراوی هەیە: <code>int</code> ژمارەی تەواو، <code>double</code> ژمارەی کەسری، <code>String</code> دەق، <code>boolean</code> ڕاست/هەڵە، <code>char</code> پیتێک.</p>',
  'content_ba'=>'<p>د Java دا هەمی گۆڕۆک چەشنەکا دیاریکراوی دڤێت: <code>int</code>، <code>double</code>، <code>String</code>، <code>boolean</code>، <code>char</code>.</p>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        int temen = 20;
        double nrx = 9.99;
        String nav = "Hewler";
        boolean xwendekar = true;
        System.out.println(nav + " temenî " + temen);
        System.out.println("Nrx: " + nrx);
    }
}',
  'example_output'=>'Hewler temenî 20
Nrx: 9.99',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
int a = 4; int b = 6;
System.out.println(a * b);',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
int a = 4; int b = 6;
System.out.println(a * b);',
  'quiz_options_so'=>['24','10','46','هەڵە'],
  'quiz_options_ba'=>['24','10','46','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>3,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'ئۆپەراتۆرەکان',
  'title_ba'=>'ئۆپەراتۆر',
  'content_so'=>'<p>Java ئۆپەراتۆرە بیرکارییەکانی هەیە: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئۆپەراتۆرە بەراوردکارییەکان: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>.</p>',
  'content_ba'=>'<p>Java ئۆپەراتۆرێن ماتەماتیکی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئۆپەراتۆرێن بەراوردکرنێ: <code>==</code>، <code>!=</code>، <code>&gt;</code>.</p>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        int a=15, b=4;
        System.out.println(a+b);  // 19
        System.out.println(a-b);  // 11
        System.out.println(a*b);  // 60
        System.out.println(a/b);  // 3
        System.out.println(a%b);  // 3
    }
}',
  'example_output'=>'19
11
60
3
3',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
public class Main {
    public static void main(String[] args) {
        int x = 10;
        int y = 0;
        System.out.println(x / y);
    }
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
public class Main {
    public static void main(String[] args) {
        int x = 10;
        int y = 0;
        System.out.println(x / y);
    }
}',
  'expected_output_text'=>'5',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        int x = 10;
        int y = 2;
        System.out.println(x / y);
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>4,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'وەرگرتنی داخڵ',
  'title_ba'=>'وەرگرتنا داخڵ',
  'content_so'=>'<p>بۆ وەرگرتنی داخڵ لە Java کلاسی <code>Scanner</code> بەکاردێت: <code>import java.util.Scanner;</code>. پاشان <code>sc.nextLine()</code> بۆ دەق و <code>sc.nextInt()</code> بۆ ژمارە.</p>',
  'content_ba'=>'<p>بو وەرگرتنا داخڵ د Java دا کلاسا <code>Scanner</code> بکارتیت: <code>import java.util.Scanner;</code>. پاشان <code>nextLine()</code> بو نڤیسین.</p>',
  'code'=>'import java.util.Scanner;
public class Main {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        System.out.print("Navt binuse: ");
        String nav = sc.nextLine();
        System.out.println("Silav, " + nav + "!");
        sc.close();
    }
}',
  'example_output'=>'Navt binuse: Azad
Silav, Azad!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە تەمەنی کەسێک وەربگرێت و ساڵەکانی ماوی تا ١٠٠ چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو تەمەنا کەسەک وەربگریت و سالێن ماوی هەتا ١٠٠ چاپ بکەت.',
  'expected_output_text'=>'Temen binuse: 25
Mawe ta 100: 75',
  'solution_code'=>'import java.util.Scanner;
public class Main {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        System.out.print("Temen binuse: ");
        int t = sc.nextInt();
        System.out.println("Mawe ta 100: " + (100-t));
        sc.close();
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>5,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'مەرجی if/else',
  'title_ba'=>'مەرجا if/else',
  'content_so'=>'<p>مەرجی <code>if/else</code> ڕێگەت دەدات بڕیار بدەیت:</p><pre>if (nrx >= 50) {
    System.out.println("Derbaz");
} else {
    System.out.println("Nekefte");
}</pre>',
  'content_ba'=>'<p>مەرجا <code>if/else</code> ڕێگا دیتت دەت بو بڕیاردانێ:</p><pre>if (nrx >= 50) System.out.println("Derbaz");
else System.out.println("Nekefte");</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        int nrx = 85;
        if (nrx >= 90) System.out.println("Taqez");
        else if (nrx >= 70) System.out.println("Bas");
        else if (nrx >= 50) System.out.println("Navend");
        else System.out.println("Nekefte");
    }
}',
  'example_output'=>'Bas',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەگەر nrx=45 بێت، چی چاپ دەبێت؟',
  'quiz_question_ba'=>'گەر nrx=45 بیت، چ چاپ دبیت؟',
  'quiz_options_so'=>['Nekefte','Navend','Bas','Taqez'],
  'quiz_options_ba'=>['Nekefte','Navend','Bas','Taqez'],
  'quiz_correct'=>0,
],
[
  'order'=>6,
  'level_so'=>'ئاستی ١ - دەستپێکردن',
  'level_ba'=>'ئاستا ١ - دەستپێکرن',
  'title_so'=>'switch',
  'title_ba'=>'switch',
  'content_so'=>'<p><code>switch</code> بۆ بەراوردکردنی یەک بەها لەگەڵ چەند حالەت:</p><pre>switch(roj) {
  case 1: System.out.println("Duşem"); break;
  default: System.out.println("Rojeke din");
}</pre>',
  'content_ba'=>'<p><code>switch</code> بو بەراوردکرنا یەک بەها ل گەل چەند حالەتان:</p><pre>switch(roj) {
  case 1: System.out.println("Duşem"); break;
  default: System.out.println("Roja din");
}</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        int roj = 3;
        switch(roj) {
            case 1: System.out.println("Duşem"); break;
            case 2: System.out.println("Sêşem"); break;
            case 3: System.out.println("Çarşem"); break;
            default: System.out.println("Roja din");
        }
    }
}',
  'example_output'=>'Çarşem',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
int d=5;
switch(d){case 5:System.out.println("Pênçşem");break;default:System.out.println("Din");}',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
int d=5;
switch(d){case 5:System.out.println("Pênçşem");break;default:System.out.println("Din");}',
  'quiz_options_so'=>['Pênçşem','Din','هیچ','هەڵە'],
  'quiz_options_ba'=>['Pênçşem','Din','هیچ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>7,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی for',
  'title_ba'=>'گەڕخستنا for',
  'content_so'=>'<p>خولگەی <code>for</code> بۆ دووبارەکردنەوەی کۆدێک ژمارەیەکی دیاریکراو:</p><pre>for (int i = 1; i <= 5; i++) {
    System.out.println(i);
}</pre>',
  'content_ba'=>'<p>گەڕخستنا <code>for</code> بو دووبارەکرنا کودەک ژمارەکا دیاریکراو:</p><pre>for (int i=1;i<=5;i++) System.out.println(i);</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        for (int i = 1; i <= 5; i++)
            System.out.println("Jimare: " + i);
        System.out.println("Dawî bû!");
    }
}',
  'example_output'=>'Jimare: 1
Jimare: 2
Jimare: 3
Jimare: 4
Jimare: 5
Dawî bû!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
for (int i=1; i<=3; i--) {
    System.out.println(i);
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
for (int i=1; i<=3; i--) {
    System.out.println(i);
}',
  'expected_output_text'=>'1
2
3',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        for (int i=1;i<=3;i++) // i++ نەک i--
            System.out.println(i);
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>8,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'خولگەی while',
  'title_ba'=>'گەڕخستنا while',
  'content_so'=>'<p><code>while</code> تا کاتێک مەرج راستە دەخولێت. باشە کاتێک ژمارەی دووبارەکردنەوە پێشوەخت دیاری نییە.</p>',
  'content_ba'=>'<p><code>while</code> هەتا کو مەرج راست دگەڕخیت. باش یە کاتێ ژمارا دووبارەکرنێ پێشوەخت دیاری نییە.</p>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        int n = 10;
        while (n > 0) {
            System.out.print(n + " ");
            n -= 3;
        }
        System.out.println();
    }
}',
  'example_output'=>'10 7 4 1 ',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەی جۆتەکانی ٢ بۆ ١٠ چاپ بکات بە while.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ژمارێن جۆتی ٢ هەتا ١٠ پێ while چاپ بکەت.',
  'expected_output_text'=>'2
4
6
8
10',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        int i=2;
        while(i<=10){System.out.println(i);i+=2;}
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>9,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'break و continue',
  'title_ba'=>'break و continue',
  'content_so'=>'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
  'content_ba'=>'<p><code>break</code> گەڕخستن دادەستنێت. <code>continue</code> گەڕانا ئێستا تێپەڕ دکەت.</p>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        for (int i=1;i<=10;i++) {
            if (i==7) break;
            if (i%2==0) continue;
            System.out.println(i);
        }
    }
}',
  'example_output'=>'1
3
5',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
for(int i=1;i<=5;i++){
  if(i==3) continue;
  System.out.print(i+" ");
}',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
for(int i=1;i<=5;i++){
  if(i==3) continue;
  System.out.print(i+" ");
}',
  'quiz_options_so'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','هەڵە'],
  'quiz_options_ba'=>['1 2 4 5 ','1 2 3 4 5 ','1 2 ','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>10,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'ئارای (Arrays)',
  'title_ba'=>'ئاری (Arrays)',
  'content_so'=>'<p>ئارای کۆمەڵێک بەهای هاو جۆرن لە ژێر یەک ناودا:</p><pre>int[] nrx = {85, 92, 78};
System.out.println(nrx[0]); // 85
System.out.println(nrx.length); // 3</pre>',
  'content_ba'=>'<p>ئارای کۆمەکا بەهایێن هاوچەشنن ژێر یەک ناڤ:</p><pre>int[] nrx = {85,92,78};
System.out.println(nrx[0]); // 85
System.out.println(nrx.length); // 3</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        String[] nav = {"Azad","Baran","Çiya"};
        for (int i=0;i<nav.length;i++)
            System.out.println((i+1)+". "+nav[i]);
    }
}',
  'example_output'=>'1. Azad
2. Baran
3. Çiya',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ئارایەک لە ٥ ژمارە دروست بکات و کۆی هەمووی چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ئارایەک ژ ٥ ژمارە دروست بکەت و کۆما هەمییان چاپ بکەت.',
  'expected_output_text'=>'Kop: 35',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        int[] n={5,7,8,10,5};int k=0;
        for(int v:n) k+=v;
        System.out.println("Kop: "+k);
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>11,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'ArrayList',
  'title_ba'=>'ArrayList',
  'content_so'=>'<p><code>ArrayList</code> ئارایەکی ئەندازەدۆز (resizable) یە: <code>import java.util.ArrayList;</code></p><pre>ArrayList<String> nav = new ArrayList<>();
nav.add("Azad"); nav.add("Baran");
nav.remove(0);
System.out.println(nav.size());</pre>',
  'content_ba'=>'<p><code>ArrayList</code> ئارایەکا مەزنبووی (resizable) یە: <code>import java.util.ArrayList;</code></p>',
  'code'=>'import java.util.ArrayList;
public class Main {
    public static void main(String[] args) {
        ArrayList<String> bajer = new ArrayList<>();
        bajer.add("Hewler");
        bajer.add("Silêmani");
        bajer.add("Duhok");
        for (String b : bajer)
            System.out.println(b);
        System.out.println("Jimare: "+bajer.size());
    }
}',
  'example_output'=>'Hewler
Silêmani
Duhok
Jimare: 3',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
ArrayList<Integer> a=new ArrayList<>();
a.add(10);a.add(20);a.remove(0);
System.out.println(a.get(0));',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
ArrayList<Integer> a=new ArrayList<>();
a.add(10);a.add(20);a.remove(0);
System.out.println(a.get(0));',
  'quiz_options_so'=>['20','10','0','هەڵە'],
  'quiz_options_ba'=>['20','10','0','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>12,
  'level_so'=>'ئاستی ٢ - مەرج و خولگە',
  'level_ba'=>'ئاستا ٢ - مەرج و گەڕخستن',
  'title_so'=>'دەقەکان (Strings)',
  'title_ba'=>'نڤیسین (Strings)',
  'content_so'=>'<p>دەق لە Java کلاسی <code>String</code>ە. میتۆدی زۆری هەیە:</p><pre>String s = "Kurdistan";
s.length()     // 9
s.toUpperCase() // KURDISTAN
s.contains("stan") // true
s.substring(0,4) // Kurd</pre>',
  'content_ba'=>'<p>نڤیسین د Java دا کلاسا <code>String</code>ێ یە. میتۆدێن زۆر هەن:</p><pre>String s="Kurdistan";
s.length(); s.toUpperCase(); s.substring(0,4);</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        String s = "Kurdistan";
        System.out.println(s.length());
        System.out.println(s.toUpperCase());
        System.out.println(s.substring(0,4));
        System.out.println(s.replace("stan",""));
    }
}',
  'example_output'=>'9
KURDISTAN
Kurd
Kurdi',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
String s = "Kurd";
System.out.println(s.Lenght);',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
String s = "Kurd";
System.out.println(s.Lenght);',
  'expected_output_text'=>'4',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        String s="Kurd";
        System.out.println(s.length()); // length() not Lenght
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>13,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'کلاس و Object',
  'title_ba'=>'کلاس و Object',
  'content_so'=>'<p>OOP (Object-Oriented Programming) بۆ دروستکردنی شتەکان وەک ئۆبجێکت. کلاس نەخشەکەیە، ئۆبجێکت نموونەکەیە:</p><pre>class Miroî {
    String nav;
    int temen;
    void danasîn() {
        System.out.println(nav+" temenî "+temen);
    }
}</pre>',
  'content_ba'=>'<p>OOP بو دروستکرنا شتان وەک ئوبجێکت. کلاس نەخشەیە، ئوبجێکت نموونەیە:</p><pre>class Mirov {
    String nav; int temen;
    void danasîn(){System.out.println(nav);}
}</pre>',
  'code'=>'class Mirov {
    String nav;
    int temen;
    void danasîn() {
        System.out.println(nav + " temenî " + temen + "e");
    }
}
public class Main {
    public static void main(String[] args) {
        Mirov m = new Mirov();
        m.nav = "Azad";
        m.temen = 25;
        m.danasîn();
    }
}',
  'example_output'=>'Azad temenî 25e',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە Java کلاس چییە؟',
  'quiz_question_ba'=>'د Java دا کلاس چ یە؟',
  'quiz_options_so'=>['نەخشەی ئۆبجێکت','ژمارەیەک','فایل','فەنکشن'],
  'quiz_options_ba'=>['نەخشەیا ئوبجێکت','ژمارەک','فایل','فەنکشن'],
  'quiz_correct'=>0,
],
[
  'order'=>14,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'کۆنستراکتەر',
  'title_ba'=>'Constructor',
  'content_so'=>'<p>کۆنستراکتەر میتۆدێکی تایبەتە کە بەکارهاتنی <code>new</code> ئەجرا دەبێت. ناوەکەی وەک کلاسەکەیە:</p><pre>class Mirov {
    String nav;
    Mirov(String n) { this.nav = n; }
}</pre>',
  'content_ba'=>'<p>Constructor میتۆدەکا تایبەتە کو دەما <code>new</code> ئیجرا دبیت. ناڤا وی وەک کلاسێ یە:</p><pre>class Mirov {
    String nav;
    Mirov(String n){this.nav=n;}
}</pre>',
  'code'=>'class Xwendekar {
    String nav;
    int nrx;
    Xwendekar(String n, int s) {
        nav = n; nrx = s;
    }
    void bide() {
        System.out.println(nav + ": " + nrx);
    }
}
public class Main {
    public static void main(String[] args) {
        Xwendekar x = new Xwendekar("Baran", 88);
        x.bide();
    }
}',
  'example_output'=>'Baran: 88',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
class A { int x; A(int n){x=n;} }
A a = new A(7);
System.out.println(a.x);',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
class A { int x; A(int n){x=n;} }
A a = new A(7);
System.out.println(a.x);',
  'quiz_options_so'=>['7','0','null','هەڵە'],
  'quiz_options_ba'=>['7','0','null','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>15,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'Encapsulation',
  'title_ba'=>'Encapsulation',
  'content_so'=>'<p>Encapsulation تایبەتمەندییەکان پارێزراو دەکات بە <code>private</code>. دواتر بە <code>getter/setter</code> دەستگرد دەکرێن:</p>',
  'content_ba'=>'<p>Encapsulation تایبەتمەندییان پارێز دکەت پێ <code>private</code>. پاشان پێ <code>getter/setter</code> دەستگر دبیت:</p>',
  'code'=>'class BankAccount {
    private double balance;
    BankAccount(double b){balance=b;}
    void xistin(double a){if(a>0)balance+=a;}
    double balance(){return balance;}
}
public class Main {
    public static void main(String[] args) {
        BankAccount ba = new BankAccount(1000);
        ba.xistin(500);
        System.out.println(ba.balance());
    }
}',
  'example_output'=>'1500.0',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
class A {
    private int x = 10;
}
public class Main {
    public static void main(String[] args) {
        A a = new A();
        System.out.println(a.x);
    }
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
class A {
    private int x = 10;
}
public class Main {
    public static void main(String[] args) {
        A a = new A();
        System.out.println(a.x);
    }
}',
  'expected_output_text'=>'10',
  'solution_code'=>'class A {
    private int x=10;
    int getX(){return x;} // getter زیادبکە
}
public class Main {
    public static void main(String[] args) {
        A a=new A();
        System.out.println(a.getX());
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>16,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'وەرثە (Inheritance)',
  'title_ba'=>'Inheritance',
  'content_so'=>'<p>Inheritance ڕێگەت دەدات کلاسێک تایبەتمەندی کلاسێکی تری وەربگرێت بە <code>extends</code>:</p><pre>class Heywên {String nav; void deng(){...}}
class Se extends Heywên {void deng(){System.out.println("Haw!");}}</pre>',
  'content_ba'=>'<p>Inheritance ڕێگا دیتت دەت کلاسەکا تایبەتمەندییێن کلاسەکا دی وەربگریت پێ <code>extends</code>:</p>',
  'code'=>'class Heywên {
    String nav;
    void xwe(){System.out.println("Ez heywênek im: "+nav);}
}
class Se extends Heywên {
    void deng(){System.out.println(nav+" dibêje: Haw!");}
}
public class Main {
    public static void main(String[] args) {
        Se s = new Se();
        s.nav = "Zato";
        s.xwe();
        s.deng();
    }
}',
  'example_output'=>'Ez heywênek im: Zato
Zato dibêje: Haw!',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە کلاسی ئۆتۆمبێل دروست بکات کە لە کلاسی ئامێر دامەزرێت و ناو و خێرایی چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو کلاسا ئوتۆمبێل دروست بکەت کو ژ کلاسا ئامێر شین بیت و ناڤ و خێرایی چاپ بکەت.',
  'expected_output_text'=>'Otombêl: BMW, xêrayi: 200',
  'solution_code'=>'class Amêr{String nav;}
class Otombêl extends Amêr{
    int xêrayi;
    void bide(){System.out.println("Otombêl: "+nav+", xêrayi: "+xêrayi);}
}
public class Main{
    public static void main(String[] args){
        Otombêl o=new Otombêl();
        o.nav="BMW"; o.xêrayi=200;
        o.bide();
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>17,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'Interface',
  'title_ba'=>'Interface',
  'content_so'=>'<p><code>interface</code> گڕێبەستی بە کلاسەکان دەکات کە میتۆدی دیاریکراو جێبەجێ بکات:</p><pre>interface Dengdêr {
    void deng();
}
class Se implements Dengdêr {
    public void deng(){System.out.println("Haw");}
}</pre>',
  'content_ba'=>'<p><code>interface</code> گرێبەستا ل گەل کلاسان دکەت کو میتۆدا دیاریکراو جێبەجێ بکەت:</p>',
  'code'=>'interface Şanoy {
    void şano();
}
class Helbestvan implements Şanoy {
    String nav;
    Helbestvan(String n){nav=n;}
    public void şano(){System.out.println(nav+" helbestek dixwîne");}
}
public class Main {
    public static void main(String[] args) {
        Şanoy h = new Helbestvan("Cigerxwîn");
        h.şano();
    }
}',
  'example_output'=>'Cigerxwîn helbestek dixwîne',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Interface لە Java بۆ چی بەکاردێت؟',
  'quiz_question_ba'=>'Interface د Java دا بو چی بکارتیت؟',
  'quiz_options_so'=>['دیاریکردنی گڕێبەست','دروستکردنی ئۆبجێکت','خولاندنی ئارا','کاری بیرکاری'],
  'quiz_options_ba'=>['دیاریکرنا گرێبەست','دروستکرنا ئوبجێکت','خولاندنا ئارا','کارا ماتەماتیکێ'],
  'quiz_correct'=>0,
],
[
  'order'=>18,
  'level_so'=>'ئاستی ٣ - ڕیزەکان و دەق',
  'level_ba'=>'ئاستا ٣ - ڕیز و نڤیسین',
  'title_so'=>'Exception Handling',
  'title_ba'=>'Exception Handling',
  'content_so'=>'<p><code>try/catch</code> بۆ کۆنترۆڵکردنی هەڵەکان:</p><pre>try {
    int r = 10/0;
} catch(ArithmeticException e) {
    System.out.println("Hêle: "+e.getMessage());
} finally {
    System.out.println("Her tim dijî");
}</pre>',
  'content_ba'=>'<p><code>try/catch</code> بو کۆنترۆلکرنا هەڵەکان:</p><pre>try{int r=10/0;}
catch(ArithmeticException e){System.out.println("Hêle");}
finally{System.out.println("Her tim");}</pre>',
  'code'=>'public class Main {
    public static void main(String[] args) {
        try {
            int[] a = {1,2,3};
            System.out.println(a[5]);
        } catch(ArrayIndexOutOfBoundsException e) {
            System.out.println("Index le sînore derket: "+e.getMessage());
        } finally {
            System.out.println("Temam bû");
        }
    }
}',
  'example_output'=>'Index le sînore derket: Index 5 out of bounds for length 3
Temam bû',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە هەڵەی دابەشکردن بە سفر (ArithmeticException) بگرێتەوە.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو هەڵەیا پارڤەکرنا ب صفر (ArithmeticException) بگریتەوە.',
  'expected_output_text'=>'Hêle: / by zero
Temam bû',
  'solution_code'=>'public class Main {
    public static void main(String[] args) {
        try{System.out.println(10/0);}
        catch(ArithmeticException e){System.out.println("Hêle: "+e.getMessage());}
        finally{System.out.println("Temam bû");}
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>19,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'فەنکشن (Methods)',
  'title_ba'=>'فەنکشن (Methods)',
  'content_so'=>'<p>میتۆد (فەنکشن) لە Java بەشێکی کۆد یە کە ناوێکی هەیە و دەتوانرێت دووبارە بانگ بکرێت:</p><pre>static int kot(int a, int b) { return a + b; }
System.out.println(kot(3,5)); // 8</pre>',
  'content_ba'=>'<p>میتۆد (فەنکشن) د Java دا بەشەکا کودی یە کو ناڤێ هەیە و دووبارە بانگ دبیت:</p><pre>static int kot(int a,int b){return a+b;}
System.out.println(kot(3,5)); // 8</pre>',
  'code'=>'public class Main {
    static int kot(int a,int b){return a+b;}
    static boolean jote(int n){return n%2==0;}
    public static void main(String[] args) {
        System.out.println(kot(4,6));
        System.out.println(jote(7));
        System.out.println(jote(8));
    }
}',
  'example_output'=>'10
false
true',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
static int du(int x){return x*2;}
System.out.println(du(du(3)));',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
static int du(int x){return x*2;}
System.out.println(du(du(3)));',
  'quiz_options_so'=>['12','6','9','هەڵە'],
  'quiz_options_ba'=>['12','6','9','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>20,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Method Overloading',
  'title_ba'=>'Method Overloading',
  'content_so'=>'<p>Overloading: چەند میتۆد بە هەمان ناو بەڵام پارامیتەری جیاواز:</p><pre>static int kot(int a,int b){return a+b;}
static double kot(double a,double b){return a+b;}</pre>',
  'content_ba'=>'<p>Overloading: چەند میتۆد ب هەمان ناڤ بەڵام پارامیتەرێن جیاواز:</p>',
  'code'=>'public class Main {
    static int kot(int a,int b){return a+b;}
    static double kot(double a,double b){return a+b;}
    static String kot(String a,String b){return a+" "+b;}
    public static void main(String[] args) {
        System.out.println(kot(3,5));
        System.out.println(kot(1.5,2.5));
        System.out.println(kot("Kurd","istan"));
    }
}',
  'example_output'=>'8
4.0
Kurd istan',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
public class Main {
    static void bide(int x){System.out.println(x);}
    static void bide(int x){System.out.println(x*2);}
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
public class Main {
    static void bide(int x){System.out.println(x);}
    static void bide(int x){System.out.println(x*2);}
}',
  'expected_output_text'=>'5
10',
  'solution_code'=>'public class Main {
    static void bide(int x){System.out.println(x);}
    static void bide(int x,boolean du){System.out.println(x*2);} // پارامیتەری جیاواز
    public static void main(String[] args){bide(5);bide(5,true);}
}',
  'attempts_allowed'=>5,
],
[
  'order'=>21,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'HashMap',
  'title_ba'=>'HashMap',
  'content_so'=>'<p><code>HashMap</code> کلیل-بەها ستۆر دەکات:</p><pre>import java.util.HashMap;
HashMap<String,int> xalên = new HashMap<>();
xalên.put("Azad",95);
System.out.println(xalên.get("Azad")); // 95</pre>',
  'content_ba'=>'<p><code>HashMap</code> کلیل-بەها هەلدەگریت:</p><pre>HashMap<String,Integer> m=new HashMap<>();
m.put("Azad",95); System.out.println(m.get("Azad"));</pre>',
  'code'=>'import java.util.HashMap;
public class Main {
    public static void main(String[] args) {
        HashMap<String,Integer> xalên = new HashMap<>();
        xalên.put("Azad",95);
        xalên.put("Baran",82);
        xalên.put("Çiya",78);
        for (String nav : xalên.keySet())
            System.out.println(nav+": "+xalên.get(nav));
    }
}',
  'example_output'=>'Azad: 95
Baran: 82
Çiya: 78',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'HashMap.get(key) چی دەگەڕێنێتەوە ئەگەر کلیل نەبێت؟',
  'quiz_question_ba'=>'HashMap.get(key) چ دگەڕینێتەوە گەر کلیل نەبیت؟',
  'quiz_options_so'=>['null','0','""','هەڵە'],
  'quiz_options_ba'=>['null','0','""','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>22,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Recursion',
  'title_ba'=>'Recursion',
  'content_so'=>'<p>Recursion میتۆدێکە کە خۆی بانگ دەکات. پێویستە حالەتی بنەڕەت هەبێت بۆ ڕاگرتن:</p><pre>static int factorial(int n) {
    if (n<=1) return 1;
    return n * factorial(n-1);
}</pre>',
  'content_ba'=>'<p>Recursion میتۆدەکە کو خۆ بانگ دکەت. دڤێت حالەتا بنگەه هەبیت:</p><pre>static int factorial(int n){
    if(n<=1) return 1;
    return n*factorial(n-1);
}</pre>',
  'code'=>'public class Main {
    static int factorial(int n){
        if(n<=1) return 1;
        return n*factorial(n-1);
    }
    static int fib(int n){
        if(n<=1) return n;
        return fib(n-1)+fib(n-2);
    }
    public static void main(String[] args) {
        System.out.println(factorial(5)); // 120
        System.out.println(fib(7));       // 13
    }
}',
  'example_output'=>'120
13',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە بە recursion کۆی ژمارەی ١ بۆ n بژمێرێت.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ب recursion کۆما ژمارێن ١ هەتا n bijmerê.',
  'expected_output_text'=>'Kot(5) = 15',
  'solution_code'=>'public class Main {
    static int kot(int n){return n<=0?0:n+kot(n-1);}
    public static void main(String[] args){
        System.out.println("Kot(5) = "+kot(5));
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>23,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'File I/O',
  'title_ba'=>'File I/O',
  'content_so'=>'<p>بۆ نووسین و خوێندنی فایل لە Java:</p><pre>import java.io.*;
FileWriter fw = new FileWriter("test.txt");
fw.write("Silav");
fw.close();</pre>',
  'content_ba'=>'<p>بو نڤیسین و خوێندنا فایل د Java دا:</p><pre>import java.io.*;
FileWriter fw=new FileWriter("t.txt");
fw.write("Silav");
fw.close();</pre>',
  'code'=>'import java.io.*;
public class Main {
    public static void main(String[] args) throws Exception {
        FileWriter fw = new FileWriter("kurd.txt");
        fw.write("Silav Kurdistan!\\n");
        fw.write("Java baş e\\n");
        fw.close();
        BufferedReader br = new BufferedReader(new FileReader("kurd.txt"));
        String rêz;
        while((rêz=br.readLine())!=null) System.out.println(rêz);
        br.close();
    }
}',
  'example_output'=>'Silav Kurdistan!
Java baş e',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'کام کلاس بۆ نووسینی فایل لە Java بەکاردێت؟',
  'quiz_question_ba'=>'کا کلاس بو نڤیسینا فایل د Java دا بکارتیت؟',
  'quiz_options_so'=>['FileWriter','FileReader','Scanner','BufferedWriter'],
  'quiz_options_ba'=>['FileWriter','FileReader','Scanner','BufferedWriter'],
  'quiz_correct'=>0,
],
[
  'order'=>24,
  'level_so'=>'ئاستی ٤ - فەنکشن و OOP',
  'level_ba'=>'ئاستا ٤ - فەنکشن و OOP',
  'title_so'=>'Generics',
  'title_ba'=>'Generics',
  'content_so'=>'<p>Generics ڕێگەت دەدات کۆد لەگەڵ هەر جۆرێک کاربکات:</p><pre>static <T> void bide(T val){
    System.out.println(val);
}
bide(42); bide("Kurd"); bide(3.14);</pre>',
  'content_ba'=>'<p>Generics ڕێگا دیتت دەت کود ل گەل هەر چەشنەکا کاربکەت:</p>',
  'code'=>'public class Main {
    static <T> void bide(T val){
        System.out.println("Cure: "+val.getClass().getSimpleName()+", Nirx: "+val);
    }
    public static void main(String[] args) {
        bide(42);
        bide("Kurd");
        bide(3.14);
    }
}',
  'example_output'=>'Cure: Integer, Nirx: 42
Cure: String, Nirx: Kurd
Cure: Double, Nirx: 3.14',
  'quiz_type'=>'practice',
  'practice_question_so'=>'هەڵەی کۆد بدۆزەرەوە:
public class Main {
    static T maxBide(T a, T b){
        return a>b?a:b;
    }
}',
  'practice_question_ba'=>'خەلەتا کودێ بدۆزە:
public class Main {
    static T maxBide(T a, T b){
        return a>b?a:b;
    }
}',
  'expected_output_text'=>'5',
  'solution_code'=>'public class Main {
    static <T extends Comparable<T>> T maxBide(T a,T b){return a.compareTo(b)>0?a:b;}
    public static void main(String[] args){System.out.println(maxBide(3,5));}
}',
  'attempts_allowed'=>5,
],
[
  'order'=>25,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: ماشێنی ژمارەکردن',
  'title_ba'=>'پرۆژە: ئامێرا ژمارەکرنێ',
  'content_so'=>'<p>پرۆژەی یەکەم — ماشێنی ژمارەکردنی سادە:</p>',
  'content_ba'=>'<p>پرۆژەیا یەکەم — ئامێرا ژمارەکrynêx a sade:</p>',
  'code'=>'import java.util.Scanner;
public class Main {
    public static void main(String[] args) {
        Scanner sc=new Scanner(System.in);
        System.out.print("Jimare 1: "); double a=sc.nextDouble();
        System.out.print("Operator (+,-,*,/): "); String op=sc.next();
        System.out.print("Jimare 2: "); double b=sc.nextDouble();
        double encam;
        switch(op){
            case "+": encam=a+b; break;
            case "-": encam=a-b; break;
            case "*": encam=a*b; break;
            case "/": encam=b!=0?a/b:Double.NaN; break;
            default: System.out.println("Operator nenas"); return;
        }
        System.out.println("Encam: "+encam);
        sc.close();
    }
}',
  'example_output'=>'Jimare 1: 10
Operator (+,-,*,/): *
Jimare 2: 5
Encam: 50.0',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'لە Java double.NaN چییە؟',
  'quiz_question_ba'=>'د Java دا Double.NaN چ یە؟',
  'quiz_options_so'=>['Not a Number','سفر','ژمارەی نەگەتیف','هەڵە'],
  'quiz_options_ba'=>['Not a Number','Sifir','Jimare negativ','Xelat'],
  'quiz_correct'=>0,
],
[
  'order'=>26,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: بەڕێوەبردنی خوێندکار',
  'title_ba'=>'پرۆژە: بەڕێوەبردنا Xwendekaran',
  'content_so'=>'<p>پرۆژەی دووەم — سیستەمی ئەرشیفی خوێندکاران:</p>',
  'content_ba'=>'<p>پرۆژەیا دووەم — سیستەما ئەرشیفا Xwendekaran:</p>',
  'code'=>'import java.util.*;
class Xwendekar{
    String nav; int nrx;
    Xwendekar(String n,int s){nav=n;nrx=s;}
    public String toString(){return nav+": "+nrx;}
}
public class Main {
    public static void main(String[] args) {
        ArrayList<Xwendekar> lîste=new ArrayList<>();
        lîste.add(new Xwendekar("Azad",92));
        lîste.add(new Xwendekar("Baran",85));
        lîste.add(new Xwendekar("Çiya",78));
        lîste.sort((a,b)->b.nrx-a.nrx);
        System.out.println("-- Rêzkirin --");
        for(Xwendekar x:lîste) System.out.println(x);
        int kot=0; for(Xwendekar x:lîste) kot+=x.nrx;
        System.out.println("Navend: "+kot/lîste.size());
    }
}',
  'example_output'=>'-- Rêzkirin --
Azad: 92
Baran: 85
Çiya: 78
Navend: 85',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە لیستی ژمارەی {5,2,8,1,9} رێک بکاتەوە لە گەورە بۆ بچووک.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو لیستا ژمارێن {5,2,8,1,9} ژ مەزن بۆ بچویک ڕێک بکەت.',
  'expected_output_text'=>'[9, 8, 5, 2, 1]',
  'solution_code'=>'import java.util.*;
public class Main {
    public static void main(String[] args){
        ArrayList<Integer> a=new ArrayList<>(Arrays.asList(5,2,8,1,9));
        a.sort(Collections.reverseOrder());
        System.out.println(a);
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>27,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: پاڵپشتی زمانی کوردی',
  'title_ba'=>'پرۆژە: Piştgiriya Kurdî',
  'content_so'=>'<p>پرۆژەی سێیەم — دیکشنەری کوردی-ئینگلیزی:</p>',
  'content_ba'=>'<p>پرۆژەیا سێیەم — Dîksiyonêra Kurdî-Înglîzî:</p>',
  'code'=>'import java.util.*;
public class Main {
    public static void main(String[] args) {
        HashMap<String,String> ferhenga=new HashMap<>();
        ferhenga.put("av","water");
        ferhenga.put("agir","fire");
        ferhenga.put("erd","earth");
        ferhenga.put("ba","wind");
        for(Map.Entry<String,String> e:ferhenga.entrySet())
            System.out.println(e.getKey()+" = "+e.getValue());
        System.out.println("Jimare: "+ferhenga.size());
    }
}',
  'example_output'=>'av = water
agir = fire
erd = earth
ba = wind
Jimare: 4',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'Map.Entry چییە لە Java؟',
  'quiz_question_ba'=>'Map.Entry چ یە د Java دا؟',
  'quiz_options_so'=>['جووتی کلیل-بەها','ئارای','کلاس','Interface'],
  'quiz_options_ba'=>['Çifta kilîl-behe','Array','Klas','Interface'],
  'quiz_correct'=>0,
],
[
  'order'=>28,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'پرۆژە: ئەندازەی شێوەکان',
  'title_ba'=>'پرۆژە: Pîvana Şêweyan',
  'content_so'=>'<p>پرۆژەی چوارەم — بەکارهێنانی OOP بۆ ئەندازەی شێوەکان:</p>',
  'content_ba'=>'<p>پرۆژەیا چوارەم — Bikaranîna OOP bO pîvana şêweyan:</p>',
  'code'=>'abstract class Şêwe {
    abstract double rûber();
    abstract double dowr();
}
class Çargoşe extends Şêwe {
    double dirêj,pahn;
    Çargoşe(double d,double p){dirêj=d;pahn=p;}
    double rûber(){return dirêj*pahn;}
    double dowr(){return 2*(dirêj+pahn);}
}
class Xeleka extends Şêwe {
    double radius;
    Xeleka(double r){radius=r;}
    double rûber(){return Math.PI*radius*radius;}
    double dowr(){return 2*Math.PI*radius;}
}
public class Main {
    public static void main(String[] args) {
        Şêwe[] şêwe={new Çargoşe(4,5),new Xeleka(3)};
        for(Şêwe s:şêwe){
            System.out.printf("Ruber:%.2f Dowr:%.2f%n",s.rûber(),s.dowr());
        }
    }
}',
  'example_output'=>'Ruber:20.00 Dowr:18.00
Ruber:28.27 Dowr:18.85',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ئاریای شل و نرخی بازارەکان بخوێنێتەوە.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ئارایا نرخێن بازارا بخوینیتەوە.',
  'expected_output_text'=>'Max: 95
Min: 72
Avg: 83.0',
  'solution_code'=>'import java.util.*;
public class Main{
    public static void main(String[] args){
        int[] nrx={85,95,72,80};
        int mx=nrx[0],mn=nrx[0],k=0;
        for(int n:nrx){if(n>mx)mx=n;if(n<mn)mn=n;k+=n;}
        System.out.println("Max: "+mx+"\\nMin: "+mn+"\\nAvg: "+(double)k/nrx.length);
    }
}',
  'attempts_allowed'=>5,
],
[
  'order'=>29,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'Lambda و Streams',
  'title_ba'=>'Lambda û Streams',
  'content_so'=>'<p>Lambda (لە Java 8>) ڕێگەت دەدات فەنکشن کورتی بنووسیت:</p><pre>list.stream().filter(x->x>5).forEach(System.out::println);</pre>',
  'content_ba'=>'<p>Lambda (ژ Java 8>) ڕێگا دیتت دەت فەنکشن کورت بنڤیسیت:</p>',
  'code'=>'import java.util.*;
import java.util.stream.*;
public class Main {
    public static void main(String[] args) {
        List<Integer> hejmar=Arrays.asList(3,7,2,9,1,8,5);
        System.out.println("Mezinan (>5):");
        hejmar.stream().filter(x->x>5).sorted().forEach(System.out::println);
        int kot=hejmar.stream().mapToInt(Integer::intValue).sum();
        System.out.println("Kot: "+kot);
    }
}',
  'example_output'=>'Mezinan (>5):
7
8
9
Kot: 45',
  'quiz_type'=>'choice',
  'quiz_question_so'=>'ئەمەی خوارەوە چی چاپ دەکات؟
Arrays.asList(1,2,3).stream()
  .map(x->x*x).forEach(System.out::println);',
  'quiz_question_ba'=>'ئەڤ کودا خوارێ چ چاپ دکەت؟
Arrays.asList(1,2,3).stream()
  .map(x->x*x).forEach(System.out::println);',
  'quiz_options_so'=>['1
4
9','1
2
3','2
4
6','هەڵە'],
  'quiz_options_ba'=>['1
4
9','1
2
3','2
4
6','خەلەت'],
  'quiz_correct'=>0,
],
[
  'order'=>30,
  'level_so'=>'ئاستی ٥ - پرۆژەکان',
  'level_ba'=>'ئاستا ٥ - پرۆژە',
  'title_so'=>'کۆتایی کۆرس — پرۆژەی کۆتایی',
  'title_ba'=>'Dawiya Kursê — Proje ya Dawî',
  'content_so'=>'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی Java. ئەوەی فێربوویت:</p><ul><li>گۆڕاوە، جۆرەکان، ئۆپەراتۆر، Scanner</li><li>if/else، switch، for، while</li><li>ئارای، ArrayList، HashMap</li><li>کلاس، کۆنستراکتەر، Encapsulation، Inheritance</li><li>Interface، Exception، File I/O، Generics</li><li>Lambda، Streams</li></ul>',
  'content_ba'=>'<p>ئافەرم! گەهیشتی دویاهیا کورسی Java.</p><ul><li>گۆڕۆک، چەشن، ئۆپەراتۆر، Scanner</li><li>if/else، switch، for، while</li><li>ئارا، ArrayList، HashMap</li><li>کلاس، Constructor، Encapsulation، Inheritance</li><li>Interface، Exception، File، Generics، Lambda</li></ul>',
  'code'=>'import java.util.*;
import java.util.stream.*;
class Xerîdar {
    String nav; double drav;
    Xerîdar(String n,double d){nav=n;drav=d;}
    public String toString(){return nav+"("+drav+")";}
}
public class Main {
    public static void main(String[] args) {
        ArrayList<Xerîdar> lîste=new ArrayList<>();
        lîste.add(new Xerîdar("Azad",250.0));
        lîste.add(new Xerîdar("Baran",180.5));
        lîste.add(new Xerîdar("Çiya",320.0));
        double kot=lîste.stream().mapToDouble(x->x.drav).sum();
        Xerîdar berzin=lîste.stream().max(Comparator.comparingDouble(x->x.drav)).get();
        System.out.println("Dawiya kursê: Java");
        System.out.println("Kot: "+kot);
        System.out.println("Berzin: "+berzin);
    }
}',
  'example_output'=>'Dawiya kursê: Java
Kot: 750.5
Berzin: Çiya(320.0)',
  'quiz_type'=>'practice',
  'practice_question_so'=>'بەرنامەیەک بنووسە کە ژمارەکانی {1..10} فیلتەر بکات و تەنها ئەوانەی کە %3==0 کات چاپ بکات.',
  'practice_question_ba'=>'بەرنامەکەک بنڤیسە کو ژمارێن {1..10} filtre بکەت و تەنها ئەوانێ کو %3==0 کات چاپ بکەت.',
  'expected_output_text'=>'3
6
9',
  'solution_code'=>'import java.util.stream.IntStream;
public class Main{
    public static void main(String[] args){
        IntStream.rangeClosed(1,10).filter(n->n%3==0).forEach(System.out::println);
    }
}',
  'attempts_allowed'=>5,
],
];
echo 'Adding '.count($lessons).' lessons...\n';
foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);
if(isset($d['name'])){echo 'OK '.$l['order']."\n";}else{echo 'ERR '.$r."\n";exit(1);}}
echo 'Done Java\n';
