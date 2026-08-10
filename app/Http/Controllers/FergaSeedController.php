<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class FergaSeedController extends Controller
{
    private $firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';

    private $seedFiles = [
        'add_javascript_lessons.php',
        'add_java_lessons.php',
        'add_php_lessons.php',
        'add_rust_lessons.php',
        'add_csharp_lessons.php',
    ];

    public function run()
    {
        try {
            $log = $this->seed();
            return response('<pre>' . htmlspecialchars(implode("\n", $log)) . '</pre>');
        } catch (\Throwable $e) {
            return response('<pre>ERROR: ' . htmlspecialchars($e->getMessage()) . '</pre>', 500);
        }
    }

    public function seed()
    {
        if (!defined('FERGA_SEED_LIB')) {
            define('FERGA_SEED_LIB', true);
        }

        $FERGA_SEED_LIBS = [];
        foreach ($this->seedFiles as $file) {
            require base_path($file);
        }

        $existing = Http::timeout(15)->get($this->firebaseUrl . 'ferga_lessons.json')->json() ?? [];
        $present = [];
        foreach ($existing as $lesson) {
            if (isset($lesson['langId'])) {
                $lid = $lesson['langId'];
                if (!isset($present[$lid])) {
                    $present[$lid] = [];
                }
                $ord = $lesson['order'] ?? null;
                if ($ord !== null && $ord !== '') {
                    $present[$lid][(string) $ord] = true;
                }
            }
        }

        $log = [];
        foreach ($FERGA_SEED_LIBS as $lang => $lib) {
            $langId = $lib['langId'];
            $uploaded = 0;
            $skipped = 0;
            foreach ($lib['lessons'] as $lesson) {
                $ord = $lesson['order'] ?? null;
                if ($ord !== null && $ord !== '' && isset($present[$langId][(string) $ord])) {
                    $skipped++;
                    continue;
                }
                $lesson['langId'] = $langId;
                $lesson['content_so'] = $this->fixContent($lesson['content_so'] ?? '');
                $lesson['content_ba'] = $this->fixContent($lesson['content_ba'] ?? '');
                $res = Http::timeout(15)->post($this->firebaseUrl . 'ferga_lessons.json', $lesson);
                $log[] = $lang . ' #' . ($lesson['order'] ?? '?') . ' -> ' . $res->body();
                $uploaded++;
            }
            if ($uploaded === 0 && $skipped > 0) {
                $log[] = "$lang: all lessons already exist ($skipped skipped)";
            } else {
                $unlock = Http::timeout(15)->patch($this->firebaseUrl . 'ferga_languages/' . $langId . '.json', ['locked' => false]);
                $log[] = "$lang: unlock -> " . $unlock->status() . " | uploaded $uploaded, skipped $skipped";
            }
        }

        return $log;
    }

    public function data()
    {
        if (!defined('FERGA_SEED_LIB')) {
            define('FERGA_SEED_LIB', true);
        }
        $FERGA_SEED_LIBS = [];
        foreach ($this->seedFiles as $file) {
            require base_path($file);
        }
        $out = [];
        foreach ($FERGA_SEED_LIBS as $lang => $lib) {
            $langId = $lib['langId'];
            $lessons = [];
            foreach ($lib['lessons'] as $lesson) {
                $lesson['langId'] = $langId;
                $lesson['content_so'] = $this->fixContent($lesson['content_so'] ?? '');
                $lesson['content_ba'] = $this->fixContent($lesson['content_ba'] ?? '');
                $lessons[] = $lesson;
            }
            $out[] = ['lang' => $lang, 'langId' => $langId, 'lessons' => $lessons];
        }
        return response()->json($out);
    }

    public function uploadPage()
    {
        $fbConfigJson = json_encode(config('kurdai.firebase'), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<meta charset="UTF-8">
<title>بارکردنی وانەکانی Ferga</title>
<style>
body{background:#0f172a;color:#e2e8f0;font-family:monospace;padding:20px;max-width:900px;margin:auto}
h1{color:#38bdf8}
#log{background:#0b1220;border:1px solid #334155;border-radius:12px;padding:16px;min-height:300px;white-space:pre-wrap;color:#4ade80;font-size:13px}
.btn{background:#2563eb;color:#fff;border:0;padding:14px 28px;border-radius:10px;font-size:16px;cursor:pointer}
.btn:disabled{opacity:.5;cursor:wait}
.input{width:100%;padding:12px;border-radius:8px;border:1px solid #334155;background:#0b1220;color:#e2e8f0;margin-bottom:12px;box-sizing:border-box}
.err{color:#f87171}
.good{color:#4ade80}
.box{background:#0b1220;border:1px solid #334155;border-radius:12px;padding:16px;margin-bottom:16px}
.hidden{display:none}
</style>
</head>
<body>
<h1>بارکردنی وانەکانی Ferga</h1>
<div id="login-box" class="box">
<p>پێویستە بە ئەکاونتەکەت (ئەو ئیمەیڵەی کە لەگەڵی چوویتە ژوورەوە بۆ /ferga) چوونە ژوورەوە بکەیتەوە.</p>
<input class="input" id="email" type="email" placeholder="ئیمەیڵ">
<input class="input" id="pass" type="password" placeholder="وشەی نهێنی">
<button class="btn" onclick="doLogin()">چوونە ژوورەوە</button>
<pre id="login-err" class="err"></pre>
</div>
<div id="upload-box" class="box hidden">
<p class="good">بە سەرکەوتوویی چوویتە ژوورەوە وەک: <b id="user-email"></b></p>
<p>دوگمەکە دابگرە — خۆی زمانەکان دەکاتەوە و وانەکان دەنێرێت بۆ Firebase (بەهەمان SDK و ئەکاونتەکەی کە ئەپەکە بەکاری دەهێنێت).</p>
<button class="btn" id="go" onclick="start()">دەستپێکردن</button>
</div>
<pre id="log">چاوەڕوان...</pre>
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
import { getAuth, signInWithEmailAndPassword, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
import { getDatabase, ref, get, update, push } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";
var firebaseConfig = __FB_CONFIG__;
var app = initializeApp(firebaseConfig);
var auth = getAuth(app);
var db = getDatabase(app);
var logEl=document.getElementById('log');
function add(t){logEl.textContent+='\n'+t;}
onAuthStateChanged(auth, (user) => {
  if(user){
    document.getElementById('user-email').textContent = user.email;
    document.getElementById('login-box').classList.add('hidden');
    document.getElementById('upload-box').classList.remove('hidden');
    add('بە سەرکەوتوویی چوویتە ژوورەوە وەک: '+user.email);
  }
});
window.doLogin = async function(){
  var email=document.getElementById('email').value.trim();
  var pass=document.getElementById('pass').value;
  var err=document.getElementById('login-err');
  err.textContent='';
  try{
    await signInWithEmailAndPassword(auth,email,pass);
  }catch(e){
    err.textContent='هەڵە: '+e.message;
  }
};
window.start = async function(){
  var btn=document.getElementById('go');btn.disabled=true;logEl.textContent='';
  try{
    var u=auth.currentUser;
    if(!u){add('هەڵە: سەرەتا بچۆ ژوورەوە');return;}
    var data=await (await fetch('/ferga/seed-data')).json();
    add('داتا هات ('+data.length+' زمان)');
    add('بەکارهێنەر: '+u.email);
    var snap=await get(ref(db,'ferga_lessons'));
    var existing=snap.val()||{};
    var present={};
    for(var k in existing){if(existing[k]&&existing[k].langId){var lid=existing[k].langId;if(!present[lid])present[lid]={};if(existing[k].order!==undefined&&existing[k].order!==null)present[lid][String(existing[k].order)]=true;}}
    var totalAdded=0,totalSkipped=0;
    for(var i=0;i<data.length;i++){
      var lang=data[i];
      try{
        await update(ref(db,'ferga_languages/'+lang.langId),{locked:false});
      }catch(e){
        add(lang.lang+' : هەڵە لە کردنەوەی زمان — '+e.message);
        continue;
      }
      var added=0,skipped=0;
      for(var j=0;j<lang.lessons.length;j++){
        var lesson=lang.lessons[j];
        if(present[lang.langId]&&present[lang.langId][String(lesson.order)]){skipped++;continue;}
        try{
          var r=await push(ref(db,'ferga_lessons'),lesson);
          added++;totalAdded++;
          add(lang.lang+' #'+lesson.order+' -> '+r.key);
        }catch(e){
          add(lang.lang+' #'+lesson.order+' هەڵە: '+e.message);
          break;
        }
      }
      totalSkipped+=skipped;
      add(lang.lang+' : '+added+' زیادکرا, '+skipped+' هەیەبوو');
    }
    add('\nکۆی گشتی: '+totalAdded+' زیادکرا, '+totalSkipped+' هەیەبوو');
    add('\n=== تەواو بوو! ئێستا /ferga بکەرەوە و Ctrl+F5 بکە ===');
  }catch(e){
    add('هەڵە: '+e.message);
  }
};
</script>
</body>
</html>
HTML;
        return response(str_replace('__FB_CONFIG__', $fbConfigJson, $html))->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function fixContent($html)
    {
        $html = preg_replace('/(?<!")\\\\n/', "\n", $html);
        $html = preg_replace('/<(?![\/a-zA-Z!?])/', '&lt;', $html);
        return $html;
    }
}
