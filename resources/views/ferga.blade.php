<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/skulpt@1.2.0/dist/skulpt-stdlib.js"></script>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فێرگە - کورد ئەی ئای</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        let pyodide = null;

        async function initPyodide() {
            if (!pyodide) {
                pyodide = await loadPyodide();
            }
        }

        let currentLangExt = 'py';

        async function runPythonCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            
            out.innerText = "چاوەڕێ بکە...";
            out.classList.add("animate-pulse");
            
            try {
                await initPyodide();
                pyodide.runPython("import sys\nfrom io import StringIO\nsys.stdout = StringIO()");
                await pyodide.runPythonAsync(code);
                out.innerText = pyodide.runPython("sys.stdout.getvalue()");
                out.classList.remove("animate-pulse");
            } catch (err) {
                out.innerText = "هەڵە لە کۆدەکەدا:\n" + err;
                out.classList.remove("animate-pulse");
            }
        }

        async function runCppCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            
            out.innerText = "چاوەڕێ بکە...";
            out.classList.add("animate-pulse");
            
            try {
                const res = await fetch("https://godbolt.org/api/compiler/g142/compile", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify({
                        source: code,
                        compiler: "g142",
                        options: {
                            userArguments: "-std=c++17 -O2",
                            filters: { execute: true, binary: false }
                        }
                    })
                });
                const data = await res.json();
                let output = "";
                if (data.execResult && data.execResult.stdout) {
                    output = data.execResult.stdout.map(o => o.text).join("");
                }
                if (data.execResult && data.execResult.stderr && data.execResult.stderr.length) {
                    output += "\n" + data.execResult.stderr.map(o => o.text).join("");
                }
                if (!output && data.stderr && data.stderr.length) {
                    output = data.stderr.map(o => o.text).join("");
                }
                if (data.code && data.code !== 0) {
                    output = "Compilation error (code " + data.code + ")\n" + output;
                }
                out.innerText = output || "(بێ دەرکەوتن)";
                out.classList.remove("animate-pulse");
            } catch (err) {
                out.innerText = "هەڵە لە کۆدەکەدا:\n" + err;
                out.classList.remove("animate-pulse");
            }
        }

        function runCode() {
            if (currentLangExt === 'cpp') {
                runCppCode();
            } else {
                runPythonCode();
            }
        }

        tailwind.config = { 
            darkMode: 'class', 
            theme: { 
                extend: { 
                    fontFamily: { sans: ['"Noto Sans Arabic"', 'sans-serif'] },
                    animation: {
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                } 
            } 
        }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(55, 65, 81, 0.5);
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }

        .quiz-option.selected { 
            border-color: #3b82f6; 
            background-color: #eff6ff; 
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
        }
        .dark .quiz-option.selected { 
            border-color: #3b82f6; 
            background-color: rgba(59, 130, 246, 0.2); 
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- ناڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        
        <!-- بەشی لۆگۆ و ناوی پڕۆژە -->
        <a href="/" class="flex items-center gap-3 transition group relative">
            <div class="relative flex-shrink-0">
                <!-- درەوشانەوەی پشتەوە کە لەگەڵ گلاسمۆرفیزم زۆر گونجاوە -->
                <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-full blur-xl opacity-0 group-hover:opacity-30 transition-all duration-300 dark:group-hover:opacity-50"></div>
                <!-- وێنەی لۆگۆکە -->
                <img src="logo.jpg" alt="Kurd AI Logo" class="h-10 md:h-11 w-auto object-contain dark:invert drop-shadow-md group-hover:scale-105 transition-transform duration-300 relative z-10">
            </div>
            
            <!-- تێکستی KURD AI بە ئینگلیزی لەگەڵ دروشمەکەی -->
            <div class="flex flex-col justify-center hidden sm:flex">
                <h1 class="text-xl md:text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">
                    KURD AI
                </h1>
                <span class="text-[0.55rem] md:text-[0.60rem] font-black tracking-widest bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500 mt-0.5">
                    INNOVATION - FUTURE
                </span>
            </div>
        </a>
        <div class="hidden lg:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
    <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
    <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
    <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
    <a href="/news" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</a>
    <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="تووڵەکان" data-ba="ئامراز">تووڵەکان</a>
    <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
    <a href="/universities" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
    <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="دەرباری ئێمە" data-ba="دەرباری مە">دەرباری ئێمە</a>
</div>
        <div class="flex items-center gap-2.5">
            <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
            <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
            <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50 lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</a>
            <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50 lang-str" data-so="دەرچوون" data-ba="چنە دەر">دەرچوون</button>
        </div>
    </div>
</nav>

    <!-- قۆناغی 1: هەڵبژاردنی زمان (گۆڕدراو بۆ دیزاینی سەرەکی) -->
    <div id="home-view" class="relative min-h-[85vh] py-16 px-4 overflow-hidden flex flex-col items-center justify-center">
        <!-- باکگراوندی جوڵاو -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center mb-16 w-full max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="فێرگەی پرۆگرامسازی" data-ba="فێرگەها پرۆگرامسازییێ">فێرگەی پرۆگرامسازی</h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە." data-ba="وێ زمانێ هەلبژێرە کو دڤێت ژێ دەستپێبکەی و پێنگاڤ ب پێنگاڤ فێرببە.">ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە.</p>
        </div>
        
        <div id="languages-grid" class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl mx-auto"></div>

        <!-- بەشی ئەدمین (دەستکاری نەکراوە زۆر تەنها پڕفیشناڵتر کراوە) -->
        <div class="admin-only hidden relative z-10 mt-20 w-full max-w-5xl mx-auto glass-card p-8 rounded-3xl shadow-xl border-t-4 border-purple-600">
            <h3 class="text-2xl font-bold mb-6 border-b pb-4 dark:border-gray-700">دەستکاریکردنی فێرگە (ئەدمین)</h3>
            
            <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <button id="tab-btn-lang" onclick="switchAdminTab('lang')" class="px-6 py-2 bg-purple-600 text-white rounded-lg font-bold">1. زمان</button>
                <button id="tab-btn-lesson" onclick="switchAdminTab('lesson')" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold">2. وانە</button>
                <button id="tab-btn-quiz" onclick="switchAdminTab('quiz')" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold">3. پرسیار</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-6 py-2 bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 rounded-lg font-bold border border-red-200 dark:border-red-800">4. بەڕێوەبردن (سڕینەوە/دەستکاری)</button>
            </div>

            <!-- 1. فۆڕمی زمان -->
            <form id="form-lang" class="admin-form space-y-4">
                <input type="hidden" id="edit_lang_id">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">ناوی زمان (سۆرانی)</label><input type="text" id="lang_name_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"></div>
                    <div><label class="block font-bold mb-2">ناوی زمان (بادینی)</label><input type="text" id="lang_name_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">کورتە (سۆرانی)</label><textarea id="lang_desc_so" required rows="3" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea></div>
                    <div><label class="block font-bold mb-2">کورتە (بادینی)</label><textarea id="lang_desc_ba" required rows="3" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"></textarea></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">ڕەنگی پاشبنەما (بۆ دیزاین)</label><input type="text" id="lang_color" value="bg-blue-100" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 focus:ring-2 focus:ring-purple-500 focus:outline-none"></div>
                    <div><label class="block font-bold mb-2">لۆگۆی زمانەکە (وێنە)</label><input type="file" id="lang_logo_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"><p class="text-xs text-gray-500 mt-1">ئەگەر لە کاتی دەستکاریکردن وێنە دانەنێیت، وێنە کۆنەکە دەمێنێتەوە.</p></div>
                </div>
                <button type="submit" id="btn-submit-lang" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 rounded-xl font-bold hover:shadow-lg transition-all">سەیڤکردنی زمان</button>
            </form>

            <!-- 2. فۆڕمی وانە -->
            <form id="form-lesson" class="admin-form space-y-4 hidden">
                <input type="hidden" id="edit_lesson_id">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><label class="block font-bold mb-2">زمان هەڵبژێرە</label><select id="lesson_lang_select" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></select></div>
                    <div><label class="block font-bold mb-2">ئاست (سۆرانی)</label><input type="text" id="lesson_level_so" placeholder="نموونە: ١. بنەماکان" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">ئاست (بادینی)</label><input type="text" id="lesson_level_ba" placeholder="نموونە: ١. بنەمایێن..." required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">سەردێڕی وانە (سۆرانی)</label><input type="text" id="lesson_title_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">سەردێڕی وانە (بادینی)</label><input type="text" id="lesson_title_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">ڕوونکردنەوە (سۆرانی)</label><textarea id="lesson_content_so" required rows="4" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                    <div><label class="block font-bold mb-2">ڕوونکردنەوە (بادینی)</label><textarea id="lesson_content_ba" required rows="4" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                </div>
                <div><label class="block font-bold mb-2">کۆدی نموونە (بۆ هەردوو زمان وەک یەکە)</label><textarea id="lesson_code" rows="5" dir="ltr" class="w-full p-3 rounded-xl bg-[#1e1e1e] text-green-400 font-mono text-left focus:ring-2 focus:ring-blue-500 outline-none"></textarea></div>
                <button type="submit" id="btn-submit-lesson" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold hover:shadow-lg transition-all">سەیڤکردنی وانە</button>
            </form>

            <!-- 3. فۆڕمی پرسیار -->
            <form id="form-quiz" class="admin-form space-y-4 hidden">
                <input type="hidden" id="edit_quiz_id">
                <div><label class="block font-bold mb-2">وانە هەڵبژێرە</label><select id="quiz_lesson_select" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></select></div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2 text-blue-600 dark:text-blue-400">پرسیار (سۆرانی)</label><input type="text" id="quiz_question_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2 text-blue-600 dark:text-blue-400">پرسیار (بادینی)</label><input type="text" id="quiz_question_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>

                <!-- بژاردەکان بە هەردوو زمان -->
                <div class="grid grid-cols-2 gap-6 mt-4 p-6 border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50/50 dark:bg-gray-800/50">
                    <div class="space-y-3">
                        <h4 class="font-bold border-b dark:border-gray-600 pb-2">بژاردەکان (سۆرانی)</h4>
                        <input type="text" id="quiz_opt0_so" placeholder="بژاردەی ١" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt1_so" placeholder="بژاردەی ٢" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt2_so" placeholder="بژاردەی ٣" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt3_so" placeholder="بژاردەی ٤" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                    </div>
                    <div class="space-y-3">
                        <h4 class="font-bold border-b dark:border-gray-600 pb-2">بژاردەکان (بادینی)</h4>
                        <input type="text" id="quiz_opt0_ba" placeholder="بژاردەی ١" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt1_ba" placeholder="بژاردەی ٢" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt2_ba" placeholder="بژاردەی ٣" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                        <input type="text" id="quiz_opt3_ba" placeholder="بژاردەی ٤" required class="w-full p-3 rounded-lg bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700">
                    </div>
                </div>

                <div>
                    <label class="block font-bold mb-2 text-green-600 dark:text-green-400">کامیان وەڵامە ڕاستەکەیە؟ (بۆ هەردوو زمان وەک یەکە)</label>
                    <select id="quiz_correct" required class="w-full p-3 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-300 dark:border-green-800 font-bold">
                        <option value="0">بژاردەی ١</option>
                        <option value="1">بژاردەی ٢</option>
                        <option value="2">بژاردەی ٣</option>
                        <option value="3">بژاردەی ٤</option>
                    </select>
                </div>
                <button type="submit" id="btn-submit-quiz" class="w-full bg-gradient-to-r from-green-600 to-teal-500 text-white py-4 rounded-xl font-bold hover:shadow-lg transition-all">سەیڤکردنی پرسیار</button>
            </form>

            <!-- 4. بەڕێوەبردن (Manage - Edit/Delete) -->
            <div id="form-manage" class="admin-form hidden">
                <div class="mb-4">
                    <select id="manage_category" onchange="renderManageList()" class="w-full p-3 rounded-xl bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-bold outline-none">
                        <option value="langs">زمانەکان</option>
                        <option value="lessons">وانەکان</option>
                        <option value="quizzes">پرسیارەکان</option>
                    </select>
                </div>
                <div id="manage-list" class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar p-4 bg-gray-50 dark:bg-[#0a0f1c] rounded-2xl border border-gray-200 dark:border-gray-800">
                    <!-- لیستەکان لێرە دەردەکەون -->
                </div>
            </div>
        </div>
    </div>

    <!-- قۆناغی 2: خوێندنەوەی وانە (دیزاینی شووشەیی و مۆدێرن) -->
    <div id="learning-view" class="hidden flex flex-col md:flex-row min-h-[calc(100vh-76px)] relative bg-gray-50 dark:bg-[#0a0f1c]">
        <!-- دوگمەی گەڕانەوەی سەرئاوکەوتوو -->
        <button onclick="goBackToHome()" class="absolute top-6 left-4 md:left-8 z-20 glass-card text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-full shadow-lg font-bold flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all hover:-translate-x-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="lang-str" data-so="گەڕانەوە" data-ba="زڤڕین">گەڕانەوە</span>
        </button>

        <!-- سایت بار (Sidebar) -->
        <aside class="w-full md:w-80 bg-white/60 dark:bg-[#111827]/60 backdrop-blur-xl border-l border-gray-200/50 dark:border-gray-800/50 overflow-y-auto custom-scrollbar h-[calc(100vh-76px)] shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10 pt-16 md:pt-6">
            <div class="p-6" id="sidebar-content"></div>
        </aside>

        <!-- ناوەڕۆکی سەرەکی -->
        <main class="flex-1 p-6 md:p-16 overflow-y-auto h-[calc(100vh-76px)] relative z-0">
            <div class="max-w-4xl mx-auto pt-10 md:pt-0">
                <h1 id="display-title" class="text-4xl md:text-5xl font-black mb-8 text-gray-900 dark:text-white leading-tight"></h1>
                <p id="display-content" class="text-lg md:text-xl text-gray-600 dark:text-gray-300 leading-relaxed whitespace-pre-wrap mb-12 font-medium"></p>
                
                <!-- سندووقی کۆد (Mac OS Style) -->
                <div id="display-code-box" class="hidden mb-16">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 lang-str" data-so="نموونەی کۆد" data-ba="نموونەیا کۆدی">نموونەی کۆد</h3>
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-800 bg-[#1e1e1e]">
                        <!-- Mac OS Header -->
                        <div class="bg-[#2d2d2d] px-4 py-3 flex items-center gap-2 border-b border-gray-800">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span id="code-filename-label" class="ml-4 text-xs font-mono text-gray-400">main.py</span>
                        </div>
                        <div class="p-5 overflow-x-auto" dir="ltr">
                            <pre class="font-mono text-[15px] leading-relaxed text-[#569cd6]"><code id="display-code"></code></pre>
                        </div>
                        <div class="bg-[#252526] px-4 py-3 border-t border-gray-800 flex justify-end">
                            <button onclick="openTryItYourself()" class="flex items-center gap-2 text-sm font-bold text-green-400 hover:text-green-300 transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                تاقیبکەرەوە
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-12 pt-8 border-t border-gray-200 dark:border-gray-800/50">
                    <button id="btn-prev" class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">&laquo; پێشوو</button>
                    <button id="btn-action" onclick="handleNextAction()" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5"></button>
                </div>
            </div>
        </main>
    </div>

    <!-- پەنجەرەی تاقیکردنەوەی کۆد (سەکۆی کۆدکردنی مۆدێرن) -->
    <div id="compiler-modal" class="fixed inset-0 bg-black/60 backdrop-blur-md z-[100] hidden items-center justify-center p-4">
        <div class="bg-[#1e1e1e] w-full max-w-6xl h-[85vh] rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-gray-800 transform transition-all">
            <!-- Header -->
            <div class="bg-[#252526] text-white p-4 flex justify-between items-center border-b border-[#333]">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <h3 id="compiler-modal-title" class="text-lg font-bold font-mono">سەکۆی کۆدکردن (Python)</h3>
                </div>
                <button onclick="closeTryItYourself()" class="text-gray-400 hover:text-white bg-[#333] hover:bg-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">✕</button>
            </div>
            
            <!-- Body -->
            <div class="flex-1 flex flex-col md:flex-row overflow-hidden">
                <!-- Editor -->
                <div class="w-full md:w-1/2 flex flex-col border-b md:border-b-0 md:border-l border-[#333]">
                    <div class="bg-[#2d2d2d] px-4 py-2 flex justify-between items-center">
                        <span id="compiler-filename-label" class="text-xs font-mono text-gray-400 uppercase tracking-wider">main.py</span>
                        <button onclick="runCode()" class="bg-green-600 hover:bg-green-500 text-white px-5 py-1.5 rounded-lg font-bold text-sm shadow flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                            Run
                        </button>
                    </div>
                    <textarea id="user-code" class="flex-1 w-full bg-[#1e1e1e] text-[#d4d4d4] font-mono text-[16px] leading-relaxed p-6 focus:outline-none resize-none custom-scrollbar" dir="ltr" spellcheck="false"></textarea>
                </div>
                
                <!-- Terminal Output -->
                <div class="w-full md:w-1/2 flex flex-col bg-[#000000]">
                    <div class="bg-[#2d2d2d] px-4 py-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs font-mono text-gray-400 uppercase tracking-wider">Terminal Output</span>
                    </div>
                    <pre id="code-output" class="flex-1 w-full text-green-400 font-mono text-[15px] leading-relaxed p-6 overflow-y-auto whitespace-pre-wrap text-left custom-scrollbar" dir="ltr">ئامادەیە بۆ کارپێکردن...</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- پەنجەرەی تاقیکردنەوەی وانە (Quiz) -->
    <div id="quiz-modal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-md z-[120] hidden flex-col items-center justify-center p-4">
        <div class="bg-white dark:bg-[#111827] rounded-[2rem] shadow-2xl w-full max-w-2xl p-8 relative overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="absolute top-0 right-0 w-full h-1.5 bg-gray-100 dark:bg-gray-800"><div id="quiz-progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 w-0 transition-all duration-500 rounded-r-full"></div></div>
            
            <div class="flex justify-between items-center mb-10 mt-2">
                <h2 class="text-2xl font-black text-gray-800 dark:text-white lang-str" data-so="تاقیکردنەوەی وانە" data-ba="تاقیکرنا وانەیێ">تاقیکردنەوەی وانە</h2>
                <span id="quiz-counter" class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold px-4 py-1.5 rounded-full text-sm border border-blue-100 dark:border-blue-800/50"></span>
            </div>
            
            <div id="quiz-content">
                <h3 id="quiz-question-text" class="text-xl md:text-2xl font-bold mb-8 text-gray-800 dark:text-gray-100 leading-relaxed"></h3>
                <div id="quiz-options" class="space-y-4"></div>
            </div>
            
            <div id="quiz-result" class="hidden text-center py-10">
                <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center mx-auto mb-8 text-5xl font-black shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-3xl font-black mb-4 text-gray-800 dark:text-white lang-str" data-so="ئافەرین! تەواوت کرد" data-ba="ئافەرم! تە ب دووماهی ئینا">ئافەرین! تەواوت کرد</h3>
                <p id="quiz-score-text" class="text-xl text-gray-500 dark:text-gray-400 mb-10 font-medium"></p>
                <button onclick="finishQuizAndContinue()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-lg w-full transition-all hover:-translate-y-1">بڕۆ بۆ وانەی داهاتوو</button>
            </div>
            
            <div id="quiz-footer" class="mt-10 flex justify-end">
                <button id="btn-next-question" onclick="nextQuestion()" class="bg-gray-200 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed transition-all" disabled>دواتر</button>
            </div>
        </div>
    </div>

    <!-- Firebase & Logic -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let languagesData = {}; let lessonsData = {}; let quizzesData = {};
        let currentActiveLanguage = null; let currentLessonArray = []; let currentLessonIndex = 0;
        let completedLessons = JSON.parse(localStorage.getItem('ferga_completed_lessons') || '[]');

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function applyLanguage() {
            document.getElementById('lang-text').innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            renderLanguagesGrid();
            if(currentActiveLanguage) openLanguage(currentActiveLanguage.id, currentLessonIndex);
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        onValue(dbRef(db, 'ferga_languages'), (s) => { languagesData = s.val() || {}; applyLanguage(); updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_lessons'), (s) => { lessonsData = s.val() || {}; updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_quizzes'), (s) => { quizzesData = s.val() || {}; renderManageList(); });

        function renderLanguagesGrid() {
            const grid = document.getElementById('languages-grid');
            if(!grid) return;
            grid.innerHTML = '';
            for (let id in languagesData) {
                const l = languagesData[id];
                const name = loc(l, 'name');
                const desc = loc(l, 'desc');
                
                let iconHtml = l.logo_url 
                    ? `<img src="${l.logo_url}" class="w-full h-full object-contain p-2">` 
                    : `<span class="text-3xl font-black text-gray-800">${name.charAt(0)}</span>`;

                grid.innerHTML += `
                    <div onclick="openLanguage('${id}')" class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col items-center text-center p-10 group hover:-translate-y-2">
                        <div class="w-24 h-24 ${l.color || 'bg-blue-100'} rounded-[1.5rem] flex items-center justify-center mb-8 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                            ${iconHtml}
                        </div>
                        <h3 class="text-2xl font-black mb-4 text-gray-900 dark:text-white">Learn ${name}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose line-clamp-3">${desc}</p>
                        <div class="mt-6 text-blue-600 dark:text-blue-400 font-bold text-sm flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0">
                            دەستپێبکە <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </div>
                    </div>`;
            }
        }

        window.openLanguage = function(langId, forcedIndex = null) {
            currentActiveLanguage = { id: langId, ...languagesData[langId] };
            document.getElementById('home-view').classList.add('hidden');
            document.getElementById('learning-view').classList.remove('hidden');
            document.getElementById('learning-view').classList.add('flex');
            
            let langLessons = [];
            for (let lid in lessonsData) {
                if (lessonsData[lid].langId === langId) langLessons.push({ id: lid, ...lessonsData[lid] });
            }

            const grouped = {};
            langLessons.forEach(l => {
                const level = loc(l, 'level');
                if (!grouped[level]) grouped[level] = [];
                grouped[level].push(l);
            });

            currentLessonArray = [];
            const sidebar = document.getElementById('sidebar-content');
            const langName = loc(currentActiveLanguage, 'name');
            sidebar.innerHTML = `<div class="flex items-center gap-3 mb-8 px-2"><div class="w-8 h-8 rounded bg-blue-500 flex items-center justify-center text-white font-bold">${langName.charAt(0)}</div><h2 class="text-xl font-black text-gray-800 dark:text-white">${langName}</h2></div>`;

            const ext = langName.includes('++') ? 'cpp' : 'py';
            currentLangExt = ext;
            const filenameLabel = document.getElementById('code-filename-label');
            const compilerLabel = document.getElementById('compiler-filename-label');
            const modalTitle = document.getElementById('compiler-modal-title');
            if (filenameLabel) filenameLabel.textContent = 'main.' + ext;
            if (compilerLabel) compilerLabel.textContent = 'main.' + ext;
            if (modalTitle) modalTitle.textContent = 'سەکۆی کۆدکردن (' + (ext === 'cpp' ? 'C++' : 'Python') + ')';

            for (let level in grouped) {
                sidebar.innerHTML += `<div class="mb-3 px-2 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mt-6">${level}</div>`;
                grouped[level].forEach(lesson => {
                    const index = currentLessonArray.length;
                    currentLessonArray.push(lesson);
                    const isCompleted = completedLessons.includes(lesson.id);
                    const checkMark = isCompleted ? `<svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>` : '';
                    const title = loc(lesson, 'title');
                    
                    sidebar.innerHTML += `
                        <button id="sidebar-btn-${index}" onclick="loadLesson(${index})" class="w-full text-right flex justify-between items-center px-4 py-3 mb-1 text-[15px] font-bold text-gray-600 dark:text-gray-400 hover:bg-white dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-700 hover:shadow-sm">
                            <span class="truncate pr-2">${title}</span> ${checkMark}
                        </button>`;
                });
            }

            if (currentLessonArray.length > 0) {
                loadLesson(forcedIndex !== null && forcedIndex < currentLessonArray.length ? forcedIndex : 0);
            } else {
                document.getElementById('display-title').innerText = langName;
                document.getElementById('display-content').innerText = loc(currentActiveLanguage, 'desc') + "\n\nهیچ وانەیەک لێرە نییە.";
                document.getElementById('display-code-box').classList.add('hidden');
            }
        };

        window.loadLesson = function(index) {
            currentLessonIndex = index;
            const lesson = currentLessonArray[index];
            
            document.querySelectorAll('[id^="sidebar-btn-"]').forEach(el => {
                el.classList.remove('bg-white', 'dark:bg-gray-800', 'text-blue-600', 'dark:text-blue-400', 'border-gray-200', 'dark:border-gray-700', 'shadow-sm');
                el.classList.add('border-transparent');
            });
            const activeBtn = document.getElementById(`sidebar-btn-${index}`);
            if(activeBtn) {
                activeBtn.classList.add('bg-white', 'dark:bg-gray-800', 'text-blue-600', 'dark:text-blue-400', 'border-gray-200', 'dark:border-gray-700', 'shadow-sm');
                activeBtn.classList.remove('border-transparent');
            }

            document.getElementById('display-title').innerText = loc(lesson, 'title');
            document.getElementById('display-content').innerText = loc(lesson, 'content');
            
            if (lesson.code && lesson.code.trim() !== '') {
                document.getElementById('display-code-box').classList.remove('hidden');
                document.getElementById('display-code').innerText = lesson.code;
            } else {
                document.getElementById('display-code-box').classList.add('hidden');
            }

            const btnPrev = document.getElementById('btn-prev');
            const btnAction = document.getElementById('btn-action');
            
            btnPrev.disabled = index === 0;
            btnPrev.style.opacity = index === 0 ? '0.3' : '1';
            btnPrev.onclick = () => { if(index > 0) loadLesson(index - 1); };

            const isLast = index === currentLessonArray.length - 1;
            const isCompleted = completedLessons.includes(lesson.id);
            const nextText = currentLang === 'so' ? "وانەی داهاتوو &raquo;" : "وانا دیڤدا &raquo;";
            const endText = currentLang === 'so' ? "کۆتایی زمانەکە" : "دووماهییا زمانی";
            const doneText = currentLang === 'so' ? "تەواوکردنی وانە ✓" : "ب دووماهی ئینان ✓";

            if (!isCompleted) {
                btnAction.innerHTML = doneText;
                btnAction.className = "bg-gradient-to-r from-green-500 to-emerald-500 text-white px-8 py-3 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-green-500/30 transition-all hover:-translate-y-0.5";
            } else {
                btnAction.innerHTML = isLast ? endText : nextText;
                btnAction.className = "bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all hover:-translate-y-0.5";
            }
        };

        window.handleNextAction = function() {
            const lessonId = currentLessonArray[currentLessonIndex].id;
            const isCompleted = completedLessons.includes(lessonId);

            if (!isCompleted) {
                let lessonQuizzes = [];
                for(let qid in quizzesData) {
                    if(quizzesData[qid].lessonId === lessonId) lessonQuizzes.push(quizzesData[qid]);
                }
                if (lessonQuizzes.length > 0) startQuiz(lessonQuizzes, lessonId);
                else markLessonCompleted(lessonId);
            } else {
                if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
            }
        };

        function markLessonCompleted(lessonId) {
            if(!completedLessons.includes(lessonId)) {
                completedLessons.push(lessonId);
                localStorage.setItem('ferga_completed_lessons', JSON.stringify(completedLessons));
            }
            openLanguage(currentActiveLanguage.id, currentLessonIndex); 
            if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
        }

        // --- Quiz Logic ---
        let activeQuizQuestions = []; let activeQuizIndex = 0; let activeQuizScore = 0; let activeLessonIdToComplete = null; let selectedOptionForCurrent = null;

        function startQuiz(questions, lessonId) {
            activeQuizQuestions = questions; activeQuizIndex = 0; activeQuizScore = 0; activeLessonIdToComplete = lessonId;
            document.getElementById('quiz-modal').classList.remove('hidden'); document.getElementById('quiz-modal').classList.add('flex');
            document.getElementById('quiz-content').classList.remove('hidden'); document.getElementById('quiz-footer').classList.remove('hidden'); document.getElementById('quiz-result').classList.add('hidden');
            renderQuizQuestion();
        }

        function renderQuizQuestion() {
            const q = activeQuizQuestions[activeQuizIndex];
            selectedOptionForCurrent = null;
            document.getElementById('quiz-progress-bar').style.width = `${((activeQuizIndex) / activeQuizQuestions.length) * 100}%`;
            document.getElementById('quiz-counter').innerText = `${currentLang === 'so' ? 'پرسیاری' : 'پرسیارا'} ${activeQuizIndex + 1} / ${activeQuizQuestions.length}`;
            document.getElementById('quiz-question-text').innerText = loc(q, 'question');
            
            const optionsContainer = document.getElementById('quiz-options');
            optionsContainer.innerHTML = '';
            
            const optionsArray = currentLang === 'ba' && q.options_ba ? q.options_ba : q.options_so || q.options;
            
            optionsArray.forEach((opt, idx) => {
                optionsContainer.innerHTML += `
                    <div onclick="selectQuizOption(${idx})" id="opt-${idx}" class="quiz-option cursor-pointer border-2 border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 rounded-2xl p-5 text-lg font-bold text-gray-700 dark:text-gray-300 hover:border-blue-300 dark:hover:border-blue-700 transition-all flex items-center gap-4">
                        <div class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center shrink-0 pointer-events-none indicator-circle"></div>
                        ${opt}
                    </div>`;
            });
            
            const nextBtn = document.getElementById('btn-next-question');
            nextBtn.disabled = true;
            nextBtn.className = "bg-gray-200 dark:bg-gray-800 text-gray-400 dark:text-gray-500 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed transition-all";
        }

        window.selectQuizOption = function(idx) {
            selectedOptionForCurrent = idx;
            document.querySelectorAll('.quiz-option').forEach(el => {
                el.classList.remove('selected');
                el.querySelector('.indicator-circle').innerHTML = '';
                el.querySelector('.indicator-circle').classList.remove('border-blue-500', 'bg-blue-500');
            });
            const selectedEl = document.getElementById(`opt-${idx}`);
            selectedEl.classList.add('selected');
            const circle = selectedEl.querySelector('.indicator-circle');
            circle.classList.add('border-blue-500', 'bg-blue-500');
            circle.innerHTML = '<svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';

            const nextBtn = document.getElementById('btn-next-question');
            nextBtn.disabled = false;
            nextBtn.className = "bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 cursor-pointer";
        };

        window.nextQuestion = function() {
            if(selectedOptionForCurrent === null) return;
            if(parseInt(selectedOptionForCurrent) === parseInt(activeQuizQuestions[activeQuizIndex].correct)) activeQuizScore++;
            activeQuizIndex++;
            if(activeQuizIndex < activeQuizQuestions.length) renderQuizQuestion();
            else showQuizResult();
        };

        function showQuizResult() {
            document.getElementById('quiz-progress-bar').style.width = `100%`;
            document.getElementById('quiz-content').classList.add('hidden'); document.getElementById('quiz-footer').classList.add('hidden'); document.getElementById('quiz-result').classList.remove('hidden');
            const percent = Math.round((activeQuizScore / activeQuizQuestions.length) * 100);
            
            const resultText = currentLang === 'so' 
                ? `تۆ وەڵامی ${activeQuizScore} پرسیارت لە کۆی ${activeQuizQuestions.length} بە دروستی دایەوە (${percent}%)`
                : `تە بەرسڤا ${activeQuizScore} پرسیاران ژ سەرجەمێ ${activeQuizQuestions.length} ب دروستی دا (${percent}%)`;
                
            document.getElementById('quiz-score-text').innerText = resultText;
            if(!completedLessons.includes(activeLessonIdToComplete)) {
                completedLessons.push(activeLessonIdToComplete);
                localStorage.setItem('ferga_completed_lessons', JSON.stringify(completedLessons));
            }
        }

        window.finishQuizAndContinue = function() {
            document.getElementById('quiz-modal').classList.add('hidden'); document.getElementById('quiz-modal').classList.remove('flex');
            openLanguage(currentActiveLanguage.id, currentLessonIndex);
            if(currentLessonIndex < currentLessonArray.length - 1) loadLesson(currentLessonIndex + 1);
        };

        window.openTryItYourself = function() {
            document.getElementById('user-code').value = document.getElementById('display-code').innerText;
            document.getElementById('code-output').innerText = 'ئامادەیە بۆ کارپێکردن...';
            document.getElementById('compiler-modal').classList.remove('hidden'); document.getElementById('compiler-modal').classList.add('flex');
        };
        window.closeTryItYourself = function() { document.getElementById('compiler-modal').classList.add('hidden'); document.getElementById('compiler-modal').classList.remove('flex'); };
        
        window.goBackToHome = function() { 
            document.getElementById('learning-view').classList.add('hidden'); 
            document.getElementById('learning-view').classList.remove('flex'); 
            document.getElementById('home-view').classList.remove('hidden'); 
        };

        // --- ADMIN LOGIC ---
        const tabs = ['lang', 'lesson', 'quiz', 'manage'];
        window.switchAdminTab = function(tabName) {
            tabs.forEach(x => {
                document.getElementById(`tab-btn-${x}`).classList.remove('bg-purple-600', 'bg-blue-600', 'text-white', 'border-red-600');
                document.getElementById(`tab-btn-${x}`).classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700');
                if(x === 'manage') document.getElementById(`tab-btn-${x}`).classList.add('bg-red-100', 'text-red-600');
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            const activeBtn = document.getElementById(`tab-btn-${tabName}`);
            activeBtn.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-700', 'bg-red-100', 'text-red-600');
            activeBtn.classList.add(tabName === 'manage' ? 'bg-red-600' : 'bg-purple-600', 'text-white');
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
            
            if(tabName !== 'manage') {
                document.getElementById(`form-${tabName}`).reset();
                document.getElementById(`edit_${tabName}_id`)?.setAttribute('value', '');
                const btn = document.getElementById(`btn-submit-${tabName}`);
                if(btn) btn.innerText = 'سەیڤکردن';
            }
        };

        function updateAdminSelects() {
            const lSelect = document.getElementById('lesson_lang_select');
            lSelect.innerHTML = '<option value="">-- زمان هەڵبژێرە --</option>';
            for (let id in languagesData) lSelect.innerHTML += `<option value="${id}">${languagesData[id].name_so || languagesData[id].name}</option>`;

            const qSelect = document.getElementById('quiz_lesson_select');
            qSelect.innerHTML = '<option value="">-- وانە هەڵبژێرە --</option>';
            for (let id in lessonsData) {
                const lName = languagesData[lessonsData[id].langId] ? (languagesData[lessonsData[id].langId].name_so || 'نەناسراو') : 'نەناسراو';
                qSelect.innerHTML += `<option value="${id}">[${lName}] ${lessonsData[id].title_so || lessonsData[id].title}</option>`;
            }
        }

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            const data = await res.json();
            return data.data.url;
        }

        // Admin submits...
        document.getElementById('form-lang').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-lang'); btn.disabled = true; btn.innerText = "چاوەڕێ بکە...";
            const editId = document.getElementById('edit_lang_id').value;
            try {
                let logoUrl = editId && languagesData[editId] ? languagesData[editId].logo_url : '';
                const file = document.getElementById('lang_logo_file').files[0];
                if(file) logoUrl = await uploadImage(file);
                const data = {
                    name_so: document.getElementById('lang_name_so').value, name_ba: document.getElementById('lang_name_ba').value,
                    desc_so: document.getElementById('lang_desc_so').value, desc_ba: document.getElementById('lang_desc_ba').value,
                    color: document.getElementById('lang_color').value, logo_url: logoUrl
                };
                if(editId) await update(dbRef(db, 'ferga_languages/' + editId), data); else await set(push(dbRef(db, 'ferga_languages')), data);
                alert("بە سەرکەوتوویی جێبەجێکرا!"); e.target.reset(); document.getElementById('edit_lang_id').value = ''; btn.innerText = "سەیڤکردن";
                switchAdminTab('manage');
            } catch (err) { alert("هەڵە ڕوویدا"); btn.disabled = false; btn.innerText = "سەیڤکردن"; }
        });

        document.getElementById('form-lesson').addEventListener('submit', async (e) => {
            e.preventDefault();
            const editId = document.getElementById('edit_lesson_id').value;
            const data = {
                langId: document.getElementById('lesson_lang_select').value,
                level_so: document.getElementById('lesson_level_so').value, level_ba: document.getElementById('lesson_level_ba').value,
                title_so: document.getElementById('lesson_title_so').value, title_ba: document.getElementById('lesson_title_ba').value,
                content_so: document.getElementById('lesson_content_so').value, content_ba: document.getElementById('lesson_content_ba').value,
                code: document.getElementById('lesson_code').value
            };
            if(editId) await update(dbRef(db, 'ferga_lessons/' + editId), data); else await set(push(dbRef(db, 'ferga_lessons')), data);
            alert("بە سەرکەوتوویی جێبەجێکرا!"); e.target.reset(); document.getElementById('edit_lesson_id').value = '';
            switchAdminTab('manage');
        });

        document.getElementById('form-quiz').addEventListener('submit', async (e) => {
            e.preventDefault();
            const editId = document.getElementById('edit_quiz_id').value;
            const data = {
                lessonId: document.getElementById('quiz_lesson_select').value,
                question_so: document.getElementById('quiz_question_so').value, question_ba: document.getElementById('quiz_question_ba').value,
                options_so: [document.getElementById('quiz_opt0_so').value, document.getElementById('quiz_opt1_so').value, document.getElementById('quiz_opt2_so').value, document.getElementById('quiz_opt3_so').value],
                options_ba: [document.getElementById('quiz_opt0_ba').value, document.getElementById('quiz_opt1_ba').value, document.getElementById('quiz_opt2_ba').value, document.getElementById('quiz_opt3_ba').value],
                correct: document.getElementById('quiz_correct').value
            };
            if(editId) await update(dbRef(db, 'ferga_quizzes/' + editId), data); else await set(push(dbRef(db, 'ferga_quizzes')), data);
            alert("بە سەرکەوتوویی جێبەجێکرا!"); e.target.reset(); document.getElementById('edit_quiz_id').value = '';
            switchAdminTab('manage');
        });

        window.renderManageList = function() {
            const cat = document.getElementById('manage_category').value;
            const listObj = document.getElementById('manage-list');
            listObj.innerHTML = '';
            let dataObj = cat === 'langs' ? languagesData : (cat === 'lessons' ? lessonsData : quizzesData);
            for(let id in dataObj) {
                const item = dataObj[id];
                let title = '';
                if(cat === 'langs') title = item.name_so || item.name;
                if(cat === 'lessons') title = `[${languagesData[item.langId]?.name_so || '?'}] ${item.title_so || item.title}`;
                if(cat === 'quizzes') title = `[پرسیار] ${item.question_so || item.question}`;
                listObj.innerHTML += `
                    <div class="flex justify-between items-center bg-white dark:bg-[#111827] p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800">
                        <span class="font-bold truncate text-gray-800 dark:text-gray-200">${title}</span>
                        <div class="flex gap-2 shrink-0">
                            <button onclick="editItem('${cat}', '${id}')" class="bg-blue-100 text-blue-600 px-4 py-1.5 rounded-lg text-sm hover:bg-blue-200 font-bold">دەستکاری</button>
                            <button onclick="deleteItem('${cat}', '${id}')" class="bg-red-100 text-red-600 px-4 py-1.5 rounded-lg text-sm hover:bg-red-200 font-bold">سڕینەوە</button>
                        </div>
                    </div>`;
            }
        };

        window.deleteItem = async function(cat, id) {
            if(!confirm('دڵنیایت لە سڕینەوەی ئەمە؟')) return;
            const path = cat === 'langs' ? 'ferga_languages' : (cat === 'lessons' ? 'ferga_lessons' : 'ferga_quizzes');
            await remove(dbRef(db, `${path}/${id}`));
            alert('بە سەرکەوتوویی سڕایەوە');
        };

        window.editItem = function(cat, id) {
            if(cat === 'langs') {
                const d = languagesData[id];
                document.getElementById('edit_lang_id').value = id;
                document.getElementById('lang_name_so').value = d.name_so || d.name || ''; document.getElementById('lang_name_ba').value = d.name_ba || d.name || '';
                document.getElementById('lang_desc_so').value = d.desc_so || d.desc || ''; document.getElementById('lang_desc_ba').value = d.desc_ba || d.desc || '';
                document.getElementById('lang_color').value = d.color || '';
                document.getElementById('btn-submit-lang').innerText = "نوێکردنەوەی زمان";
                switchAdminTab('lang');
            } else if(cat === 'lessons') {
                const d = lessonsData[id];
                document.getElementById('edit_lesson_id').value = id;
                document.getElementById('lesson_lang_select').value = d.langId || '';
                document.getElementById('lesson_level_so').value = d.level_so || d.level || ''; document.getElementById('lesson_level_ba').value = d.level_ba || d.level || '';
                document.getElementById('lesson_title_so').value = d.title_so || d.title || ''; document.getElementById('lesson_title_ba').value = d.title_ba || d.title || '';
                document.getElementById('lesson_content_so').value = d.content_so || d.content || ''; document.getElementById('lesson_content_ba').value = d.content_ba || d.content || '';
                document.getElementById('lesson_code').value = d.code || '';
                document.getElementById('btn-submit-lesson').innerText = "نوێکردنەوەی وانە";
                switchAdminTab('lesson');
            } else if(cat === 'quizzes') {
                const d = quizzesData[id];
                document.getElementById('edit_quiz_id').value = id;
                document.getElementById('quiz_lesson_select').value = d.lessonId || '';
                document.getElementById('quiz_question_so').value = d.question_so || d.question || ''; document.getElementById('quiz_question_ba').value = d.question_ba || d.question || '';
                const optSo = d.options_so || d.options || ['', '', '', '']; const optBa = d.options_ba || d.options || ['', '', '', ''];
                for(let i=0; i<4; i++) {
                    document.getElementById(`quiz_opt${i}_so`).value = optSo[i] || '';
                    document.getElementById(`quiz_opt${i}_ba`).value = optBa[i] || '';
                }
                document.getElementById('quiz_correct').value = d.correct || '0';
                document.getElementById('btn-submit-quiz').innerText = "نوێکردنەوەی پرسیار";
                switchAdminTab('quiz');
            }
        };

        onAuthStateChanged(auth, (user) => { 
            if(!user) window.location.href = "/login"; 
            else {
                document.body.style.display = 'block';
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    document.querySelector('.admin-only').classList.remove('hidden');
                }
            }
        });
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>