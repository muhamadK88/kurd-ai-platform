#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import os
B='/home/donk/kurd-ai-platform'
F='https://ai-platform-adb1b-default-rtdb.firebaseio.com/'
def pv(v):
    if v is None: return 'null'
    if isinstance(v,bool): return 'true' if v else 'false'
    if isinstance(v,int): return str(v)
    if isinstance(v,list): return '['+','.join(pv(i) for i in v)+']'
    return "'"+str(v).replace('\\','\\\\').replace("'","\\'")+  "'"
def run(fname,lang,lid,LL):
    L=['<?php',f"$u='{F}';$t=trim(file_get_contents('/tmp/opencode/fb_token.txt'));$lid='{lid}';",
       "function fp($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_POST,true);curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}",
       "function fpa($url,$d){global $t;$c=curl_init($url);curl_setopt($c,CURLOPT_RETURNTRANSFER,true);curl_setopt($c,CURLOPT_CUSTOMREQUEST,'PATCH');curl_setopt($c,CURLOPT_POSTFIELDS,json_encode($d));curl_setopt($c,CURLOPT_HTTPHEADER,['Authorization: Bearer '.$t,'Content-Type: application/json']);$r=curl_exec($c);curl_close($c);return $r;}",
       f"fpa($u.'ferga_languages/'.$lid.'.json',['locked'=>false]);echo \"{lang} OK\\n\";",
       '$lessons=[']
    for ls in LL:
        L.append('[')
        for k,v in ls.items(): L.append(f"  {pv(k)}=>{pv(v)},")
        L.append('],')
    L+=['];',"echo 'Adding '.count($lessons).' lessons...\\n';",
        "foreach($lessons as $l){$l['langId']=$lid;$r=fp($u.'ferga_lessons.json',$l);$d=json_decode($r,true);",
        "if(isset($d['name'])){echo 'OK '.$l['order'].\"\\n\";}else{echo 'ERR '.$r.\"\\n\";exit(1);}}",
        f"echo 'Done {lang}\\n';"]
    p=os.path.join(B,fname)
    with open(p,'w',encoding='utf-8') as f: f.write('\n'.join(L)+'\n')
    print(f'Wrote {p}')

s1so='ئاستی ١ - دەستپێکردن';s1ba='ئاستا ١ - دەستپێکرن'
s2so='ئاستی ٢ - مەرج و خولگە';s2ba='ئاستا ٢ - مەرج و گەڕخستن'
s3so='ئاستی ٣ - ڕیزەکان و دەق';s3ba='ئاستا ٣ - ڕیز و نڤیسین'
s4so='ئاستی ٤ - فەنکشن و OOP';s4ba='ئاستا ٤ - فەنکشن و OOP'
s5so='ئاستی ٥ - پرۆژەکان';s5ba='ئاستا ٥ - پرۆژە'

java=[
{'order':1,'level_so':s1so,'level_ba':s1ba,'title_so':'چییە Java؟','title_ba':'چ یە Java؟',
 'content_so':'<p><strong>Java</strong> زمانێکی object-oriented و بەهێزە کە لەلایەن Sun Microsystems لە ١٩٩٥ دروستکراوە. ئەمڕۆ لەلایەن Oracle بەڕێوەدەبرێت. بەکاردێت لە ئەندرۆید، وێب، و Enterprise.</p>',
 'content_ba':'<p><strong>Java</strong> زمانەکەکا بهێز و object-oriented یە. ژ لایەن Sun Microsystems د ١٩٩٥ هاتییە دروستکرن. بکارتیت د ئەندرۆید، وێب، Enterprise دا.</p>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        System.out.println("Silav Kurdistane!");\n        System.out.println("Xêrhatî bo Java!");\n    }\n}',
 'example_output':'Silav Kurdistane!\nXêrhatî bo Java!',
 'quiz_type':'choice','quiz_question_so':'کام میتۆد دەیخاتە بەر ئەجرای بەرنامەی Java؟','quiz_question_ba':'کا میتۆد بەرنامەیا Java دەستپێ دکەت؟',
 'quiz_options_so':['public static void main(String[] args)','void start()','public main()','static run()'],
 'quiz_options_ba':['public static void main(String[] args)','void start()','public main()','static run()'],'quiz_correct':0},

{'order':2,'level_so':s1so,'level_ba':s1ba,'title_so':'گۆڕاوە و جۆرەکانی داتا','title_ba':'گۆڕۆک و چەشنێن داتایێ',
 'content_so':'<p>لە Java هەموو گۆڕاوێک جۆرێکی دیاریکراوی هەیە: <code>int</code> ژمارەی تەواو، <code>double</code> ژمارەی کەسری، <code>String</code> دەق، <code>boolean</code> ڕاست/هەڵە، <code>char</code> پیتێک.</p>',
 'content_ba':'<p>د Java دا هەمی گۆڕۆک چەشنەکا دیاریکراوی دڤێت: <code>int</code>، <code>double</code>، <code>String</code>، <code>boolean</code>، <code>char</code>.</p>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        int temen = 20;\n        double nrx = 9.99;\n        String nav = "Hewler";\n        boolean xwendekar = true;\n        System.out.println(nav + " temenî " + temen);\n        System.out.println("Nrx: " + nrx);\n    }\n}',
 'example_output':'Hewler temenî 20\nNrx: 9.99',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nint a = 4; int b = 6;\nSystem.out.println(a * b);',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nint a = 4; int b = 6;\nSystem.out.println(a * b);',
 'quiz_options_so':['24','10','46','هەڵە'],'quiz_options_ba':['24','10','46','خەلەت'],'quiz_correct':0},

{'order':3,'level_so':s1so,'level_ba':s1ba,'title_so':'ئۆپەراتۆرەکان','title_ba':'ئۆپەراتۆر',
 'content_so':'<p>Java ئۆپەراتۆرە بیرکارییەکانی هەیە: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئۆپەراتۆرە بەراوردکارییەکان: <code>==</code>، <code>!=</code>، <code>&gt;</code>، <code>&lt;</code>.</p>',
 'content_ba':'<p>Java ئۆپەراتۆرێن ماتەماتیکی: <code>+</code>، <code>-</code>، <code>*</code>، <code>/</code>، <code>%</code>. ئۆپەراتۆرێن بەراوردکرنێ: <code>==</code>، <code>!=</code>، <code>&gt;</code>.</p>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        int a=15, b=4;\n        System.out.println(a+b);  // 19\n        System.out.println(a-b);  // 11\n        System.out.println(a*b);  // 60\n        System.out.println(a/b);  // 3\n        System.out.println(a%b);  // 3\n    }\n}',
 'example_output':'19\n11\n60\n3\n3',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\npublic class Main {\n    public static void main(String[] args) {\n        int x = 10;\n        int y = 0;\n        System.out.println(x / y);\n    }\n}',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\npublic class Main {\n    public static void main(String[] args) {\n        int x = 10;\n        int y = 0;\n        System.out.println(x / y);\n    }\n}',
 'expected_output_text':'5','solution_code':'public class Main {\n    public static void main(String[] args) {\n        int x = 10;\n        int y = 2;\n        System.out.println(x / y);\n    }\n}','attempts_allowed':5},

{'order':4,'level_so':s1so,'level_ba':s1ba,'title_so':'وەرگرتنی داخڵ','title_ba':'وەرگرتنا داخڵ',
 'content_so':'<p>بۆ وەرگرتنی داخڵ لە Java کلاسی <code>Scanner</code> بەکاردێت: <code>import java.util.Scanner;</code>. پاشان <code>sc.nextLine()</code> بۆ دەق و <code>sc.nextInt()</code> بۆ ژمارە.</p>',
 'content_ba':'<p>بو وەرگرتنا داخڵ د Java دا کلاسا <code>Scanner</code> بکارتیت: <code>import java.util.Scanner;</code>. پاشان <code>nextLine()</code> بو نڤیسین.</p>',
 'code':'import java.util.Scanner;\npublic class Main {\n    public static void main(String[] args) {\n        Scanner sc = new Scanner(System.in);\n        System.out.print("Navt binuse: ");\n        String nav = sc.nextLine();\n        System.out.println("Silav, " + nav + "!");\n        sc.close();\n    }\n}',
 'example_output':'Navt binuse: Azad\nSilav, Azad!',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە تەمەنی کەسێک وەربگرێت و ساڵەکانی ماوی تا ١٠٠ چاپ بکات.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو تەمەنا کەسەک وەربگریت و سالێن ماوی هەتا ١٠٠ چاپ بکەت.',
 'expected_output_text':'Temen binuse: 25\nMawe ta 100: 75','solution_code':'import java.util.Scanner;\npublic class Main {\n    public static void main(String[] args) {\n        Scanner sc = new Scanner(System.in);\n        System.out.print("Temen binuse: ");\n        int t = sc.nextInt();\n        System.out.println("Mawe ta 100: " + (100-t));\n        sc.close();\n    }\n}','attempts_allowed':5},

{'order':5,'level_so':s1so,'level_ba':s1ba,'title_so':'مەرجی if/else','title_ba':'مەرجا if/else',
 'content_so':'<p>مەرجی <code>if/else</code> ڕێگەت دەدات بڕیار بدەیت:</p><pre>if (nrx >= 50) {\n    System.out.println("Derbaz");\n} else {\n    System.out.println("Nekefte");\n}</pre>',
 'content_ba':'<p>مەرجا <code>if/else</code> ڕێگا دیتت دەت بو بڕیاردانێ:</p><pre>if (nrx >= 50) System.out.println("Derbaz");\nelse System.out.println("Nekefte");</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        int nrx = 85;\n        if (nrx >= 90) System.out.println("Taqez");\n        else if (nrx >= 70) System.out.println("Bas");\n        else if (nrx >= 50) System.out.println("Navend");\n        else System.out.println("Nekefte");\n    }\n}',
 'example_output':'Bas',
 'quiz_type':'choice',
 'quiz_question_so':'ئەگەر nrx=45 بێت، چی چاپ دەبێت؟',
 'quiz_question_ba':'گەر nrx=45 بیت، چ چاپ دبیت؟',
 'quiz_options_so':['Nekefte','Navend','Bas','Taqez'],'quiz_options_ba':['Nekefte','Navend','Bas','Taqez'],'quiz_correct':0},

{'order':6,'level_so':s1so,'level_ba':s1ba,'title_so':'switch','title_ba':'switch',
 'content_so':'<p><code>switch</code> بۆ بەراوردکردنی یەک بەها لەگەڵ چەند حالەت:</p><pre>switch(roj) {\n  case 1: System.out.println("Duşem"); break;\n  default: System.out.println("Rojeke din");\n}</pre>',
 'content_ba':'<p><code>switch</code> بو بەراوردکرنا یەک بەها ل گەل چەند حالەتان:</p><pre>switch(roj) {\n  case 1: System.out.println("Duşem"); break;\n  default: System.out.println("Roja din");\n}</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        int roj = 3;\n        switch(roj) {\n            case 1: System.out.println("Duşem"); break;\n            case 2: System.out.println("Sêşem"); break;\n            case 3: System.out.println("Çarşem"); break;\n            default: System.out.println("Roja din");\n        }\n    }\n}',
 'example_output':'Çarşem',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nint d=5;\nswitch(d){case 5:System.out.println("Pênçşem");break;default:System.out.println("Din");}',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nint d=5;\nswitch(d){case 5:System.out.println("Pênçşem");break;default:System.out.println("Din");}',
 'quiz_options_so':['Pênçşem','Din','هیچ','هەڵە'],'quiz_options_ba':['Pênçşem','Din','هیچ','خەلەت'],'quiz_correct':0},

# L2: for/while/arrays
{'order':7,'level_so':s2so,'level_ba':s2ba,'title_so':'خولگەی for','title_ba':'گەڕخستنا for',
 'content_so':'<p>خولگەی <code>for</code> بۆ دووبارەکردنەوەی کۆدێک ژمارەیەکی دیاریکراو:</p><pre>for (int i = 1; i <= 5; i++) {\n    System.out.println(i);\n}</pre>',
 'content_ba':'<p>گەڕخستنا <code>for</code> بو دووبارەکرنا کودەک ژمارەکا دیاریکراو:</p><pre>for (int i=1;i<=5;i++) System.out.println(i);</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        for (int i = 1; i <= 5; i++)\n            System.out.println("Jimare: " + i);\n        System.out.println("Dawî bû!");\n    }\n}',
 'example_output':'Jimare: 1\nJimare: 2\nJimare: 3\nJimare: 4\nJimare: 5\nDawî bû!',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\nfor (int i=1; i<=3; i--) {\n    System.out.println(i);\n}',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\nfor (int i=1; i<=3; i--) {\n    System.out.println(i);\n}',
 'expected_output_text':'1\n2\n3','solution_code':'public class Main {\n    public static void main(String[] args) {\n        for (int i=1;i<=3;i++) // i++ نەک i--\n            System.out.println(i);\n    }\n}','attempts_allowed':5},

{'order':8,'level_so':s2so,'level_ba':s2ba,'title_so':'خولگەی while','title_ba':'گەڕخستنا while',
 'content_so':'<p><code>while</code> تا کاتێک مەرج راستە دەخولێت. باشە کاتێک ژمارەی دووبارەکردنەوە پێشوەخت دیاری نییە.</p>',
 'content_ba':'<p><code>while</code> هەتا کو مەرج راست دگەڕخیت. باش یە کاتێ ژمارا دووبارەکرنێ پێشوەخت دیاری نییە.</p>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        int n = 10;\n        while (n > 0) {\n            System.out.print(n + " ");\n            n -= 3;\n        }\n        System.out.println();\n    }\n}',
 'example_output':'10 7 4 1 ',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە ژمارەی جۆتەکانی ٢ بۆ ١٠ چاپ بکات بە while.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو ژمارێن جۆتی ٢ هەتا ١٠ پێ while چاپ بکەت.',
 'expected_output_text':'2\n4\n6\n8\n10','solution_code':'public class Main {\n    public static void main(String[] args) {\n        int i=2;\n        while(i<=10){System.out.println(i);i+=2;}\n    }\n}','attempts_allowed':5},

{'order':9,'level_so':s2so,'level_ba':s2ba,'title_so':'break و continue','title_ba':'break و continue',
 'content_so':'<p><code>break</code> خولگەکە دادەوەستێنێت. <code>continue</code> گەڕانی ئێستا تێپەردەی دەکات.</p>',
 'content_ba':'<p><code>break</code> گەڕخستن دادەستنێت. <code>continue</code> گەڕانا ئێستا تێپەڕ دکەت.</p>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        for (int i=1;i<=10;i++) {\n            if (i==7) break;\n            if (i%2==0) continue;\n            System.out.println(i);\n        }\n    }\n}',
 'example_output':'1\n3\n5',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nfor(int i=1;i<=5;i++){\n  if(i==3) continue;\n  System.out.print(i+" ");\n}',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nfor(int i=1;i<=5;i++){\n  if(i==3) continue;\n  System.out.print(i+" ");\n}',
 'quiz_options_so':['1 2 4 5 ','1 2 3 4 5 ','1 2 ','هەڵە'],'quiz_options_ba':['1 2 4 5 ','1 2 3 4 5 ','1 2 ','خەلەت'],'quiz_correct':0},

{'order':10,'level_so':s2so,'level_ba':s2ba,'title_so':'ئارای (Arrays)','title_ba':'ئاری (Arrays)',
 'content_so':'<p>ئارای کۆمەڵێک بەهای هاو جۆرن لە ژێر یەک ناودا:</p><pre>int[] nrx = {85, 92, 78};\nSystem.out.println(nrx[0]); // 85\nSystem.out.println(nrx.length); // 3</pre>',
 'content_ba':'<p>ئارای کۆمەکا بەهایێن هاوچەشنن ژێر یەک ناڤ:</p><pre>int[] nrx = {85,92,78};\nSystem.out.println(nrx[0]); // 85\nSystem.out.println(nrx.length); // 3</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        String[] nav = {"Azad","Baran","Çiya"};\n        for (int i=0;i<nav.length;i++)\n            System.out.println((i+1)+". "+nav[i]);\n    }\n}',
 'example_output':'1. Azad\n2. Baran\n3. Çiya',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە ئارایەک لە ٥ ژمارە دروست بکات و کۆی هەمووی چاپ بکات.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو ئارایەک ژ ٥ ژمارە دروست بکەت و کۆما هەمییان چاپ بکەت.',
 'expected_output_text':'Kop: 35','solution_code':'public class Main {\n    public static void main(String[] args) {\n        int[] n={5,7,8,10,5};int k=0;\n        for(int v:n) k+=v;\n        System.out.println("Kop: "+k);\n    }\n}','attempts_allowed':5},

{'order':11,'level_so':s2so,'level_ba':s2ba,'title_so':'ArrayList','title_ba':'ArrayList',
 'content_so':'<p><code>ArrayList</code> ئارایەکی ئەندازەدۆز (resizable) یە: <code>import java.util.ArrayList;</code></p><pre>ArrayList<String> nav = new ArrayList<>();\nnav.add("Azad"); nav.add("Baran");\nnav.remove(0);\nSystem.out.println(nav.size());</pre>',
 'content_ba':'<p><code>ArrayList</code> ئارایەکا مەزنبووی (resizable) یە: <code>import java.util.ArrayList;</code></p>',
 'code':'import java.util.ArrayList;\npublic class Main {\n    public static void main(String[] args) {\n        ArrayList<String> bajer = new ArrayList<>();\n        bajer.add("Hewler");\n        bajer.add("Silêmani");\n        bajer.add("Duhok");\n        for (String b : bajer)\n            System.out.println(b);\n        System.out.println("Jimare: "+bajer.size());\n    }\n}',
 'example_output':'Hewler\nSilêmani\nDuhok\nJimare: 3',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nArrayList<Integer> a=new ArrayList<>();\na.add(10);a.add(20);a.remove(0);\nSystem.out.println(a.get(0));',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nArrayList<Integer> a=new ArrayList<>();\na.add(10);a.add(20);a.remove(0);\nSystem.out.println(a.get(0));',
 'quiz_options_so':['20','10','0','هەڵە'],'quiz_options_ba':['20','10','0','خەلەت'],'quiz_correct':0},

{'order':12,'level_so':s2so,'level_ba':s2ba,'title_so':'دەقەکان (Strings)','title_ba':'نڤیسین (Strings)',
 'content_so':'<p>دەق لە Java کلاسی <code>String</code>ە. میتۆدی زۆری هەیە:</p><pre>String s = "Kurdistan";\ns.length()     // 9\ns.toUpperCase() // KURDISTAN\ns.contains("stan") // true\ns.substring(0,4) // Kurd</pre>',
 'content_ba':'<p>نڤیسین د Java دا کلاسا <code>String</code>ێ یە. میتۆدێن زۆر هەن:</p><pre>String s="Kurdistan";\ns.length(); s.toUpperCase(); s.substring(0,4);</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        String s = "Kurdistan";\n        System.out.println(s.length());\n        System.out.println(s.toUpperCase());\n        System.out.println(s.substring(0,4));\n        System.out.println(s.replace("stan",""));\n    }\n}',
 'example_output':'9\nKURDISTAN\nKurd\nKurdi',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\nString s = "Kurd";\nSystem.out.println(s.Lenght);',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\nString s = "Kurd";\nSystem.out.println(s.Lenght);',
 'expected_output_text':'4','solution_code':'public class Main {\n    public static void main(String[] args) {\n        String s="Kurd";\n        System.out.println(s.length()); // length() not Lenght\n    }\n}','attempts_allowed':5},

# L3: OOP
{'order':13,'level_so':s3so,'level_ba':s3ba,'title_so':'کلاس و Object','title_ba':'کلاس و Object',
 'content_so':'<p>OOP (Object-Oriented Programming) بۆ دروستکردنی شتەکان وەک ئۆبجێکت. کلاس نەخشەکەیە، ئۆبجێکت نموونەکەیە:</p><pre>class Miroî {\n    String nav;\n    int temen;\n    void danasîn() {\n        System.out.println(nav+" temenî "+temen);\n    }\n}</pre>',
 'content_ba':'<p>OOP بو دروستکرنا شتان وەک ئوبجێکت. کلاس نەخشەیە، ئوبجێکت نموونەیە:</p><pre>class Mirov {\n    String nav; int temen;\n    void danasîn(){System.out.println(nav);}\n}</pre>',
 'code':'class Mirov {\n    String nav;\n    int temen;\n    void danasîn() {\n        System.out.println(nav + " temenî " + temen + "e");\n    }\n}\npublic class Main {\n    public static void main(String[] args) {\n        Mirov m = new Mirov();\n        m.nav = "Azad";\n        m.temen = 25;\n        m.danasîn();\n    }\n}',
 'example_output':'Azad temenî 25e',
 'quiz_type':'choice','quiz_question_so':'لە Java کلاس چییە؟','quiz_question_ba':'د Java دا کلاس چ یە؟',
 'quiz_options_so':['نەخشەی ئۆبجێکت','ژمارەیەک','فایل','فەنکشن'],'quiz_options_ba':['نەخشەیا ئوبجێکت','ژمارەک','فایل','فەنکشن'],'quiz_correct':0},

{'order':14,'level_so':s3so,'level_ba':s3ba,'title_so':'کۆنستراکتەر','title_ba':'Constructor',
 'content_so':'<p>کۆنستراکتەر میتۆدێکی تایبەتە کە بەکارهاتنی <code>new</code> ئەجرا دەبێت. ناوەکەی وەک کلاسەکەیە:</p><pre>class Mirov {\n    String nav;\n    Mirov(String n) { this.nav = n; }\n}</pre>',
 'content_ba':'<p>Constructor میتۆدەکا تایبەتە کو دەما <code>new</code> ئیجرا دبیت. ناڤا وی وەک کلاسێ یە:</p><pre>class Mirov {\n    String nav;\n    Mirov(String n){this.nav=n;}\n}</pre>',
 'code':'class Xwendekar {\n    String nav;\n    int nrx;\n    Xwendekar(String n, int s) {\n        nav = n; nrx = s;\n    }\n    void bide() {\n        System.out.println(nav + ": " + nrx);\n    }\n}\npublic class Main {\n    public static void main(String[] args) {\n        Xwendekar x = new Xwendekar("Baran", 88);\n        x.bide();\n    }\n}',
 'example_output':'Baran: 88',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nclass A { int x; A(int n){x=n;} }\nA a = new A(7);\nSystem.out.println(a.x);',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nclass A { int x; A(int n){x=n;} }\nA a = new A(7);\nSystem.out.println(a.x);',
 'quiz_options_so':['7','0','null','هەڵە'],'quiz_options_ba':['7','0','null','خەلەت'],'quiz_correct':0},

{'order':15,'level_so':s3so,'level_ba':s3ba,'title_so':'Encapsulation','title_ba':'Encapsulation',
 'content_so':'<p>Encapsulation تایبەتمەندییەکان پارێزراو دەکات بە <code>private</code>. دواتر بە <code>getter/setter</code> دەستگرد دەکرێن:</p>',
 'content_ba':'<p>Encapsulation تایبەتمەندییان پارێز دکەت پێ <code>private</code>. پاشان پێ <code>getter/setter</code> دەستگر دبیت:</p>',
 'code':'class BankAccount {\n    private double balance;\n    BankAccount(double b){balance=b;}\n    void xistin(double a){if(a>0)balance+=a;}\n    double balance(){return balance;}\n}\npublic class Main {\n    public static void main(String[] args) {\n        BankAccount ba = new BankAccount(1000);\n        ba.xistin(500);\n        System.out.println(ba.balance());\n    }\n}',
 'example_output':'1500.0',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\nclass A {\n    private int x = 10;\n}\npublic class Main {\n    public static void main(String[] args) {\n        A a = new A();\n        System.out.println(a.x);\n    }\n}',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\nclass A {\n    private int x = 10;\n}\npublic class Main {\n    public static void main(String[] args) {\n        A a = new A();\n        System.out.println(a.x);\n    }\n}',
 'expected_output_text':'10','solution_code':'class A {\n    private int x=10;\n    int getX(){return x;} // getter زیادبکە\n}\npublic class Main {\n    public static void main(String[] args) {\n        A a=new A();\n        System.out.println(a.getX());\n    }\n}','attempts_allowed':5},

{'order':16,'level_so':s3so,'level_ba':s3ba,'title_so':'وەرثە (Inheritance)','title_ba':'Inheritance',
 'content_so':'<p>Inheritance ڕێگەت دەدات کلاسێک تایبەتمەندی کلاسێکی تری وەربگرێت بە <code>extends</code>:</p><pre>class Heywên {String nav; void deng(){...}}\nclass Se extends Heywên {void deng(){System.out.println("Haw!");}}</pre>',
 'content_ba':'<p>Inheritance ڕێگا دیتت دەت کلاسەکا تایبەتمەندییێن کلاسەکا دی وەربگریت پێ <code>extends</code>:</p>',
 'code':'class Heywên {\n    String nav;\n    void xwe(){System.out.println("Ez heywênek im: "+nav);}\n}\nclass Se extends Heywên {\n    void deng(){System.out.println(nav+" dibêje: Haw!");}\n}\npublic class Main {\n    public static void main(String[] args) {\n        Se s = new Se();\n        s.nav = "Zato";\n        s.xwe();\n        s.deng();\n    }\n}',
 'example_output':'Ez heywênek im: Zato\nZato dibêje: Haw!',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە کلاسی ئۆتۆمبێل دروست بکات کە لە کلاسی ئامێر دامەزرێت و ناو و خێرایی چاپ بکات.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو کلاسا ئوتۆمبێل دروست بکەت کو ژ کلاسا ئامێر شین بیت و ناڤ و خێرایی چاپ بکەت.',
 'expected_output_text':'Otombêl: BMW, xêrayi: 200','solution_code':'class Amêr{String nav;}\nclass Otombêl extends Amêr{\n    int xêrayi;\n    void bide(){System.out.println("Otombêl: "+nav+", xêrayi: "+xêrayi);}\n}\npublic class Main{\n    public static void main(String[] args){\n        Otombêl o=new Otombêl();\n        o.nav="BMW"; o.xêrayi=200;\n        o.bide();\n    }\n}','attempts_allowed':5},

{'order':17,'level_so':s3so,'level_ba':s3ba,'title_so':'Interface','title_ba':'Interface',
 'content_so':'<p><code>interface</code> گڕێبەستی بە کلاسەکان دەکات کە میتۆدی دیاریکراو جێبەجێ بکات:</p><pre>interface Dengdêr {\n    void deng();\n}\nclass Se implements Dengdêr {\n    public void deng(){System.out.println("Haw");}\n}</pre>',
 'content_ba':'<p><code>interface</code> گرێبەستا ل گەل کلاسان دکەت کو میتۆدا دیاریکراو جێبەجێ بکەت:</p>',
 'code':'interface Şanoy {\n    void şano();\n}\nclass Helbestvan implements Şanoy {\n    String nav;\n    Helbestvan(String n){nav=n;}\n    public void şano(){System.out.println(nav+" helbestek dixwîne");}\n}\npublic class Main {\n    public static void main(String[] args) {\n        Şanoy h = new Helbestvan("Cigerxwîn");\n        h.şano();\n    }\n}',
 'example_output':'Cigerxwîn helbestek dixwîne',
 'quiz_type':'choice','quiz_question_so':'Interface لە Java بۆ چی بەکاردێت؟','quiz_question_ba':'Interface د Java دا بو چی بکارتیت؟',
 'quiz_options_so':['دیاریکردنی گڕێبەست','دروستکردنی ئۆبجێکت','خولاندنی ئارا','کاری بیرکاری'],
 'quiz_options_ba':['دیاریکرنا گرێبەست','دروستکرنا ئوبجێکت','خولاندنا ئارا','کارا ماتەماتیکێ'],'quiz_correct':0},

{'order':18,'level_so':s3so,'level_ba':s3ba,'title_so':'Exception Handling','title_ba':'Exception Handling',
 'content_so':'<p><code>try/catch</code> بۆ کۆنترۆڵکردنی هەڵەکان:</p><pre>try {\n    int r = 10/0;\n} catch(ArithmeticException e) {\n    System.out.println("Hêle: "+e.getMessage());\n} finally {\n    System.out.println("Her tim dijî");\n}</pre>',
 'content_ba':'<p><code>try/catch</code> بو کۆنترۆلکرنا هەڵەکان:</p><pre>try{int r=10/0;}\ncatch(ArithmeticException e){System.out.println("Hêle");}\nfinally{System.out.println("Her tim");}</pre>',
 'code':'public class Main {\n    public static void main(String[] args) {\n        try {\n            int[] a = {1,2,3};\n            System.out.println(a[5]);\n        } catch(ArrayIndexOutOfBoundsException e) {\n            System.out.println("Index le sînore derket: "+e.getMessage());\n        } finally {\n            System.out.println("Temam bû");\n        }\n    }\n}',
 'example_output':'Index le sînore derket: Index 5 out of bounds for length 3\nTemam bû',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە هەڵەی دابەشکردن بە سفر (ArithmeticException) بگرێتەوە.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو هەڵەیا پارڤەکرنا ب صفر (ArithmeticException) بگریتەوە.',
 'expected_output_text':'Hêle: / by zero\nTemam bû','solution_code':'public class Main {\n    public static void main(String[] args) {\n        try{System.out.println(10/0);}\n        catch(ArithmeticException e){System.out.println("Hêle: "+e.getMessage());}\n        finally{System.out.println("Temam bû");}\n    }\n}','attempts_allowed':5},

# L4: HashMap, methods, generics
{'order':19,'level_so':s4so,'level_ba':s4ba,'title_so':'فەنکشن (Methods)','title_ba':'فەنکشن (Methods)',
 'content_so':'<p>میتۆد (فەنکشن) لە Java بەشێکی کۆد یە کە ناوێکی هەیە و دەتوانرێت دووبارە بانگ بکرێت:</p><pre>static int kot(int a, int b) { return a + b; }\nSystem.out.println(kot(3,5)); // 8</pre>',
 'content_ba':'<p>میتۆد (فەنکشن) د Java دا بەشەکا کودی یە کو ناڤێ هەیە و دووبارە بانگ دبیت:</p><pre>static int kot(int a,int b){return a+b;}\nSystem.out.println(kot(3,5)); // 8</pre>',
 'code':'public class Main {\n    static int kot(int a,int b){return a+b;}\n    static boolean jote(int n){return n%2==0;}\n    public static void main(String[] args) {\n        System.out.println(kot(4,6));\n        System.out.println(jote(7));\n        System.out.println(jote(8));\n    }\n}',
 'example_output':'10\nfalse\ntrue',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nstatic int du(int x){return x*2;}\nSystem.out.println(du(du(3)));',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nstatic int du(int x){return x*2;}\nSystem.out.println(du(du(3)));',
 'quiz_options_so':['12','6','9','هەڵە'],'quiz_options_ba':['12','6','9','خەلەت'],'quiz_correct':0},

{'order':20,'level_so':s4so,'level_ba':s4ba,'title_so':'Method Overloading','title_ba':'Method Overloading',
 'content_so':'<p>Overloading: چەند میتۆد بە هەمان ناو بەڵام پارامیتەری جیاواز:</p><pre>static int kot(int a,int b){return a+b;}\nstatic double kot(double a,double b){return a+b;}</pre>',
 'content_ba':'<p>Overloading: چەند میتۆد ب هەمان ناڤ بەڵام پارامیتەرێن جیاواز:</p>',
 'code':'public class Main {\n    static int kot(int a,int b){return a+b;}\n    static double kot(double a,double b){return a+b;}\n    static String kot(String a,String b){return a+" "+b;}\n    public static void main(String[] args) {\n        System.out.println(kot(3,5));\n        System.out.println(kot(1.5,2.5));\n        System.out.println(kot("Kurd","istan"));\n    }\n}',
 'example_output':'8\n4.0\nKurd istan',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\npublic class Main {\n    static void bide(int x){System.out.println(x);}\n    static void bide(int x){System.out.println(x*2);}\n}',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\npublic class Main {\n    static void bide(int x){System.out.println(x);}\n    static void bide(int x){System.out.println(x*2);}\n}',
 'expected_output_text':'5\n10','solution_code':'public class Main {\n    static void bide(int x){System.out.println(x);}\n    static void bide(int x,boolean du){System.out.println(x*2);} // پارامیتەری جیاواز\n    public static void main(String[] args){bide(5);bide(5,true);}\n}','attempts_allowed':5},

{'order':21,'level_so':s4so,'level_ba':s4ba,'title_so':'HashMap','title_ba':'HashMap',
 'content_so':'<p><code>HashMap</code> کلیل-بەها ستۆر دەکات:</p><pre>import java.util.HashMap;\nHashMap<String,int> xalên = new HashMap<>();\nxalên.put("Azad",95);\nSystem.out.println(xalên.get("Azad")); // 95</pre>',
 'content_ba':'<p><code>HashMap</code> کلیل-بەها هەلدەگریت:</p><pre>HashMap<String,Integer> m=new HashMap<>();\nm.put("Azad",95); System.out.println(m.get("Azad"));</pre>',
 'code':'import java.util.HashMap;\npublic class Main {\n    public static void main(String[] args) {\n        HashMap<String,Integer> xalên = new HashMap<>();\n        xalên.put("Azad",95);\n        xalên.put("Baran",82);\n        xalên.put("Çiya",78);\n        for (String nav : xalên.keySet())\n            System.out.println(nav+": "+xalên.get(nav));\n    }\n}',
 'example_output':'Azad: 95\nBaran: 82\nÇiya: 78',
 'quiz_type':'choice','quiz_question_so':'HashMap.get(key) چی دەگەڕێنێتەوە ئەگەر کلیل نەبێت؟','quiz_question_ba':'HashMap.get(key) چ دگەڕینێتەوە گەر کلیل نەبیت؟',
 'quiz_options_so':['null','0','""','هەڵە'],'quiz_options_ba':['null','0','""','خەلەت'],'quiz_correct':0},

{'order':22,'level_so':s4so,'level_ba':s4ba,'title_so':'Recursion','title_ba':'Recursion',
 'content_so':'<p>Recursion میتۆدێکە کە خۆی بانگ دەکات. پێویستە حالەتی بنەڕەت هەبێت بۆ ڕاگرتن:</p><pre>static int factorial(int n) {\n    if (n<=1) return 1;\n    return n * factorial(n-1);\n}</pre>',
 'content_ba':'<p>Recursion میتۆدەکە کو خۆ بانگ دکەت. دڤێت حالەتا بنگەه هەبیت:</p><pre>static int factorial(int n){\n    if(n<=1) return 1;\n    return n*factorial(n-1);\n}</pre>',
 'code':'public class Main {\n    static int factorial(int n){\n        if(n<=1) return 1;\n        return n*factorial(n-1);\n    }\n    static int fib(int n){\n        if(n<=1) return n;\n        return fib(n-1)+fib(n-2);\n    }\n    public static void main(String[] args) {\n        System.out.println(factorial(5)); // 120\n        System.out.println(fib(7));       // 13\n    }\n}',
 'example_output':'120\n13',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە بە recursion کۆی ژمارەی ١ بۆ n بژمێرێت.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو ب recursion کۆما ژمارێن ١ هەتا n bijmerê.',
 'expected_output_text':'Kot(5) = 15','solution_code':'public class Main {\n    static int kot(int n){return n<=0?0:n+kot(n-1);}\n    public static void main(String[] args){\n        System.out.println("Kot(5) = "+kot(5));\n    }\n}','attempts_allowed':5},

{'order':23,'level_so':s4so,'level_ba':s4ba,'title_so':'File I/O','title_ba':'File I/O',
 'content_so':'<p>بۆ نووسین و خوێندنی فایل لە Java:</p><pre>import java.io.*;\nFileWriter fw = new FileWriter("test.txt");\nfw.write("Silav");\nfw.close();</pre>',
 'content_ba':'<p>بو نڤیسین و خوێندنا فایل د Java دا:</p><pre>import java.io.*;\nFileWriter fw=new FileWriter("t.txt");\nfw.write("Silav");\nfw.close();</pre>',
 'code':'import java.io.*;\npublic class Main {\n    public static void main(String[] args) throws Exception {\n        FileWriter fw = new FileWriter("kurd.txt");\n        fw.write("Silav Kurdistan!\\n");\n        fw.write("Java baş e\\n");\n        fw.close();\n        BufferedReader br = new BufferedReader(new FileReader("kurd.txt"));\n        String rêz;\n        while((rêz=br.readLine())!=null) System.out.println(rêz);\n        br.close();\n    }\n}',
 'example_output':'Silav Kurdistan!\nJava baş e',
 'quiz_type':'choice','quiz_question_so':'کام کلاس بۆ نووسینی فایل لە Java بەکاردێت؟','quiz_question_ba':'کا کلاس بو نڤیسینا فایل د Java دا بکارتیت؟',
 'quiz_options_so':['FileWriter','FileReader','Scanner','BufferedWriter'],'quiz_options_ba':['FileWriter','FileReader','Scanner','BufferedWriter'],'quiz_correct':0},

{'order':24,'level_so':s4so,'level_ba':s4ba,'title_so':'Generics','title_ba':'Generics',
 'content_so':'<p>Generics ڕێگەت دەدات کۆد لەگەڵ هەر جۆرێک کاربکات:</p><pre>static <T> void bide(T val){\n    System.out.println(val);\n}\nbide(42); bide("Kurd"); bide(3.14);</pre>',
 'content_ba':'<p>Generics ڕێگا دیتت دەت کود ل گەل هەر چەشنەکا کاربکەت:</p>',
 'code':'public class Main {\n    static <T> void bide(T val){\n        System.out.println("Cure: "+val.getClass().getSimpleName()+", Nirx: "+val);\n    }\n    public static void main(String[] args) {\n        bide(42);\n        bide("Kurd");\n        bide(3.14);\n    }\n}',
 'example_output':'Cure: Integer, Nirx: 42\nCure: String, Nirx: Kurd\nCure: Double, Nirx: 3.14',
 'quiz_type':'practice',
 'practice_question_so':'هەڵەی کۆد بدۆزەرەوە:\npublic class Main {\n    static T maxBide(T a, T b){\n        return a>b?a:b;\n    }\n}',
 'practice_question_ba':'خەلەتا کودێ بدۆزە:\npublic class Main {\n    static T maxBide(T a, T b){\n        return a>b?a:b;\n    }\n}',
 'expected_output_text':'5','solution_code':'public class Main {\n    static <T extends Comparable<T>> T maxBide(T a,T b){return a.compareTo(b)>0?a:b;}\n    public static void main(String[] args){System.out.println(maxBide(3,5));}\n}','attempts_allowed':5},

# L5: Projects
{'order':25,'level_so':s5so,'level_ba':s5ba,'title_so':'پرۆژە: ماشێنی ژمارەکردن','title_ba':'پرۆژە: ئامێرا ژمارەکرنێ',
 'content_so':'<p>پرۆژەی یەکەم — ماشێنی ژمارەکردنی سادە:</p>',
 'content_ba':'<p>پرۆژەیا یەکەم — ئامێرا ژمارەکrynêx a sade:</p>',
 'code':'import java.util.Scanner;\npublic class Main {\n    public static void main(String[] args) {\n        Scanner sc=new Scanner(System.in);\n        System.out.print("Jimare 1: "); double a=sc.nextDouble();\n        System.out.print("Operator (+,-,*,/): "); String op=sc.next();\n        System.out.print("Jimare 2: "); double b=sc.nextDouble();\n        double encam;\n        switch(op){\n            case "+": encam=a+b; break;\n            case "-": encam=a-b; break;\n            case "*": encam=a*b; break;\n            case "/": encam=b!=0?a/b:Double.NaN; break;\n            default: System.out.println("Operator nenas"); return;\n        }\n        System.out.println("Encam: "+encam);\n        sc.close();\n    }\n}',
 'example_output':'Jimare 1: 10\nOperator (+,-,*,/): *\nJimare 2: 5\nEncam: 50.0',
 'quiz_type':'choice','quiz_question_so':'لە Java double.NaN چییە؟','quiz_question_ba':'د Java دا Double.NaN چ یە؟',
 'quiz_options_so':['Not a Number','سفر','ژمارەی نەگەتیف','هەڵە'],'quiz_options_ba':['Not a Number','Sifir','Jimare negativ','Xelat'],'quiz_correct':0},

{'order':26,'level_so':s5so,'level_ba':s5ba,'title_so':'پرۆژە: بەڕێوەبردنی خوێندکار','title_ba':'پرۆژە: بەڕێوەبردنا Xwendekaran',
 'content_so':'<p>پرۆژەی دووەم — سیستەمی ئەرشیفی خوێندکاران:</p>',
 'content_ba':'<p>پرۆژەیا دووەم — سیستەما ئەرشیفا Xwendekaran:</p>',
 'code':'import java.util.*;\nclass Xwendekar{\n    String nav; int nrx;\n    Xwendekar(String n,int s){nav=n;nrx=s;}\n    public String toString(){return nav+": "+nrx;}\n}\npublic class Main {\n    public static void main(String[] args) {\n        ArrayList<Xwendekar> lîste=new ArrayList<>();\n        lîste.add(new Xwendekar("Azad",92));\n        lîste.add(new Xwendekar("Baran",85));\n        lîste.add(new Xwendekar("Çiya",78));\n        lîste.sort((a,b)->b.nrx-a.nrx);\n        System.out.println("-- Rêzkirin --");\n        for(Xwendekar x:lîste) System.out.println(x);\n        int kot=0; for(Xwendekar x:lîste) kot+=x.nrx;\n        System.out.println("Navend: "+kot/lîste.size());\n    }\n}',
 'example_output':'-- Rêzkirin --\nAzad: 92\nBaran: 85\nÇiya: 78\nNavend: 85',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە لیستی ژمارەی {5,2,8,1,9} رێک بکاتەوە لە گەورە بۆ بچووک.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو لیستا ژمارێن {5,2,8,1,9} ژ مەزن بۆ بچویک ڕێک بکەت.',
 'expected_output_text':'[9, 8, 5, 2, 1]','solution_code':'import java.util.*;\npublic class Main {\n    public static void main(String[] args){\n        ArrayList<Integer> a=new ArrayList<>(Arrays.asList(5,2,8,1,9));\n        a.sort(Collections.reverseOrder());\n        System.out.println(a);\n    }\n}','attempts_allowed':5},

{'order':27,'level_so':s5so,'level_ba':s5ba,'title_so':'پرۆژە: پاڵپشتی زمانی کوردی','title_ba':'پرۆژە: Piştgiriya Kurdî',
 'content_so':'<p>پرۆژەی سێیەم — دیکشنەری کوردی-ئینگلیزی:</p>',
 'content_ba':'<p>پرۆژەیا سێیەم — Dîksiyonêra Kurdî-Înglîzî:</p>',
 'code':'import java.util.*;\npublic class Main {\n    public static void main(String[] args) {\n        HashMap<String,String> ferhenga=new HashMap<>();\n        ferhenga.put("av","water");\n        ferhenga.put("agir","fire");\n        ferhenga.put("erd","earth");\n        ferhenga.put("ba","wind");\n        for(Map.Entry<String,String> e:ferhenga.entrySet())\n            System.out.println(e.getKey()+" = "+e.getValue());\n        System.out.println("Jimare: "+ferhenga.size());\n    }\n}',
 'example_output':'av = water\nagir = fire\nerd = earth\nba = wind\nJimare: 4',
 'quiz_type':'choice','quiz_question_so':'Map.Entry چییە لە Java؟','quiz_question_ba':'Map.Entry چ یە د Java دا؟',
 'quiz_options_so':['جووتی کلیل-بەها','ئارای','کلاس','Interface'],'quiz_options_ba':['Çifta kilîl-behe','Array','Klas','Interface'],'quiz_correct':0},

{'order':28,'level_so':s5so,'level_ba':s5ba,'title_so':'پرۆژە: ئەندازەی شێوەکان','title_ba':'پرۆژە: Pîvana Şêweyan',
 'content_so':'<p>پرۆژەی چوارەم — بەکارهێنانی OOP بۆ ئەندازەی شێوەکان:</p>',
 'content_ba':'<p>پرۆژەیا چوارەم — Bikaranîna OOP bO pîvana şêweyan:</p>',
 'code':'abstract class Şêwe {\n    abstract double rûber();\n    abstract double dowr();\n}\nclass Çargoşe extends Şêwe {\n    double dirêj,pahn;\n    Çargoşe(double d,double p){dirêj=d;pahn=p;}\n    double rûber(){return dirêj*pahn;}\n    double dowr(){return 2*(dirêj+pahn);}\n}\nclass Xeleka extends Şêwe {\n    double radius;\n    Xeleka(double r){radius=r;}\n    double rûber(){return Math.PI*radius*radius;}\n    double dowr(){return 2*Math.PI*radius;}\n}\npublic class Main {\n    public static void main(String[] args) {\n        Şêwe[] şêwe={new Çargoşe(4,5),new Xeleka(3)};\n        for(Şêwe s:şêwe){\n            System.out.printf("Ruber:%.2f Dowr:%.2f%n",s.rûber(),s.dowr());\n        }\n    }\n}',
 'example_output':'Ruber:20.00 Dowr:18.00\nRuber:28.27 Dowr:18.85',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە ئاریای شل و نرخی بازارەکان بخوێنێتەوە.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو ئارایا نرخێن بازارا بخوینیتەوە.',
 'expected_output_text':'Max: 95\nMin: 72\nAvg: 83.0','solution_code':'import java.util.*;\npublic class Main{\n    public static void main(String[] args){\n        int[] nrx={85,95,72,80};\n        int mx=nrx[0],mn=nrx[0],k=0;\n        for(int n:nrx){if(n>mx)mx=n;if(n<mn)mn=n;k+=n;}\n        System.out.println("Max: "+mx+"\\nMin: "+mn+"\\nAvg: "+(double)k/nrx.length);\n    }\n}','attempts_allowed':5},

{'order':29,'level_so':s5so,'level_ba':s5ba,'title_so':'Lambda و Streams','title_ba':'Lambda û Streams',
 'content_so':'<p>Lambda (لە Java 8>) ڕێگەت دەدات فەنکشن کورتی بنووسیت:</p><pre>list.stream().filter(x->x>5).forEach(System.out::println);</pre>',
 'content_ba':'<p>Lambda (ژ Java 8>) ڕێگا دیتت دەت فەنکشن کورت بنڤیسیت:</p>',
 'code':'import java.util.*;\nimport java.util.stream.*;\npublic class Main {\n    public static void main(String[] args) {\n        List<Integer> hejmar=Arrays.asList(3,7,2,9,1,8,5);\n        System.out.println("Mezinan (>5):");\n        hejmar.stream().filter(x->x>5).sorted().forEach(System.out::println);\n        int kot=hejmar.stream().mapToInt(Integer::intValue).sum();\n        System.out.println("Kot: "+kot);\n    }\n}',
 'example_output':'Mezinan (>5):\n7\n8\n9\nKot: 45',
 'quiz_type':'choice',
 'quiz_question_so':'ئەمەی خوارەوە چی چاپ دەکات؟\nArrays.asList(1,2,3).stream()\n  .map(x->x*x).forEach(System.out::println);',
 'quiz_question_ba':'ئەڤ کودا خوارێ چ چاپ دکەت؟\nArrays.asList(1,2,3).stream()\n  .map(x->x*x).forEach(System.out::println);',
 'quiz_options_so':['1\n4\n9','1\n2\n3','2\n4\n6','هەڵە'],'quiz_options_ba':['1\n4\n9','1\n2\n3','2\n4\n6','خەلەت'],'quiz_correct':0},

{'order':30,'level_so':s5so,'level_ba':s5ba,'title_so':'کۆتایی کۆرس — پرۆژەی کۆتایی','title_ba':'Dawiya Kursê — Proje ya Dawî',
 'content_so':'<p>ئافەرین! گەیشتیتە کۆتایی کۆرسی Java. ئەوەی فێربوویت:</p><ul><li>گۆڕاوە، جۆرەکان، ئۆپەراتۆر، Scanner</li><li>if/else، switch، for، while</li><li>ئارای، ArrayList، HashMap</li><li>کلاس، کۆنستراکتەر، Encapsulation، Inheritance</li><li>Interface، Exception، File I/O، Generics</li><li>Lambda، Streams</li></ul>',
 'content_ba':'<p>ئافەرم! گەهیشتی دویاهیا کورسی Java.</p><ul><li>گۆڕۆک، چەشن، ئۆپەراتۆر، Scanner</li><li>if/else، switch، for، while</li><li>ئارا، ArrayList، HashMap</li><li>کلاس، Constructor، Encapsulation، Inheritance</li><li>Interface، Exception، File، Generics، Lambda</li></ul>',
 'code':'import java.util.*;\nimport java.util.stream.*;\nclass Xerîdar {\n    String nav; double drav;\n    Xerîdar(String n,double d){nav=n;drav=d;}\n    public String toString(){return nav+"("+drav+")";}\n}\npublic class Main {\n    public static void main(String[] args) {\n        ArrayList<Xerîdar> lîste=new ArrayList<>();\n        lîste.add(new Xerîdar("Azad",250.0));\n        lîste.add(new Xerîdar("Baran",180.5));\n        lîste.add(new Xerîdar("Çiya",320.0));\n        double kot=lîste.stream().mapToDouble(x->x.drav).sum();\n        Xerîdar berzin=lîste.stream().max(Comparator.comparingDouble(x->x.drav)).get();\n        System.out.println("Dawiya kursê: Java");\n        System.out.println("Kot: "+kot);\n        System.out.println("Berzin: "+berzin);\n    }\n}',
 'example_output':'Dawiya kursê: Java\nKot: 750.5\nBerzin: Çiya(320.0)',
 'quiz_type':'practice',
 'practice_question_so':'بەرنامەیەک بنووسە کە ژمارەکانی {1..10} فیلتەر بکات و تەنها ئەوانەی کە %3==0 کات چاپ بکات.',
 'practice_question_ba':'بەرنامەکەک بنڤیسە کو ژمارێن {1..10} filtre بکەت و تەنها ئەوانێ کو %3==0 کات چاپ بکەت.',
 'expected_output_text':'3\n6\n9','solution_code':'import java.util.stream.IntStream;\npublic class Main{\n    public static void main(String[] args){\n        IntStream.rangeClosed(1,10).filter(n->n%3==0).forEach(System.out::println);\n    }\n}','attempts_allowed':5},

]

run('add_java_v2.php','Java','-Oysj4DmsfjAe6mjjfjT',java)
print('gen_java.py complete')





