<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { 
            darkMode: 'class', 
            theme: { 
                extend: { 
                    fontFamily: { sans: ['"Noto Sans Arabic"', 'sans-serif'] },
                    animation: { 'blob': 'blob 7s infinite', },
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
    <script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>
    <!-- Quill Rich Text Editor CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/png">
    <link rel="icon" href="/favicon.png" type="image/png">
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">
    <meta property="og:type" content="website">
    <meta property="og:title" content="کورد ئەی ئای - Kurd AI">
    <meta property="og:description" content="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی.">
    <meta property="og:image" content="/logo.jpg">
    <title>فێرگە - کورد ئەی ئای</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .dark .glass-card { background: rgba(17, 24, 39, 0.7); border: 1px solid rgba(55, 65, 81, 0.5); }

        .quiz-option.selected { border-color: #3b82f6; background-color: #eff6ff; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1); }
        .dark .quiz-option.selected { border-color: #3b82f6; background-color: rgba(59, 130, 246, 0.2); }

        .timeline-line { position: absolute; right: 20px; top: 0; bottom: 0; width: 3px; background: #e5e7eb; z-index: 1;}
        .dark .timeline-line { background: #374151; }
        .timeline-dot { width: 16px; height: 16px; border-radius: 50%; border: 3px solid #d1d5db; background: white; flex-shrink: 0; position: relative; z-index: 3; transition: all 0.3s; }
        .dark .timeline-dot { background: #1f2937; border-color: #4b5563; }
        .timeline-dot.completed { background: #10b981; border-color: #10b981; box-shadow: 0 0 10px rgba(16,185,129,0.4);}
        .timeline-dot.current { background: #3b82f6; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.3); }
        .timeline-dot.locked { background: #9ca3af; border-color: #9ca3af; }

        .locked-lesson { opacity: 0.4; cursor: not-allowed !important; filter: grayscale(100%); }
        .locked-lesson:hover { background: transparent !important; transform: none !important; }

        .xp-popup { position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%); z-index: 9999; animation: slideUpFade 2.5s ease-out forwards; }
        @keyframes slideUpFade { 0% { opacity: 0; transform: translate(-50%, 20px); } 15% { opacity: 1; transform: translate(-50%, 0); } 85% { opacity: 1; transform: translate(-50%, 0); } 100% { opacity: 0; transform: translate(-50%, -20px); } }

        /* Quill Admin Overrides */
        .ql-toolbar { background: white; border-radius: 8px 8px 0 0; direction: ltr; text-align: left; }
        .ql-container { background: white; border-radius: 0 0 8px 8px; color: black; font-family: 'Noto Sans Arabic', sans-serif; font-size: 16px; }
        .ql-editor { min-height: 120px; direction: rtl; text-align: right; }
        
        /* Rendered Content overrides */
        .rendered-content h1, .rendered-content h2, .rendered-content h3 { font-weight: 900; margin-top: 1em; margin-bottom: 0.5em; color: #3b82f6; }
        .rendered-content p { margin-bottom: 1em; }
        .rendered-content p, .rendered-content li, .rendered-content strong { overflow-wrap: anywhere; }
        .rendered-content pre { background: #1e1e1e; color: #d4d4d4; padding: 1em; border-radius: 8px; direction: ltr; text-align: left; font-family: monospace; margin-bottom: 1em; white-space: pre-wrap; overflow-wrap: anywhere; max-width: 100%; }
        #display-title { overflow-wrap: anywhere; }
        #display-content { overflow-wrap: anywhere; }
        #display-example-output { white-space: pre-wrap; overflow-wrap: anywhere; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <canvas id="confetti-canvas" class="fixed inset-0 w-full h-full pointer-events-none z-[9999]" style="display:none;"></canvas>
    <div id="xp-notification-container"></div>

    <!-- ناڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 transition group relative">
                <div class="relative flex-shrink-0">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-full blur-xl opacity-0 group-hover:opacity-30 transition-all duration-300 dark:group-hover:opacity-50"></div>
                    <img src="logo.jpg" alt="Kurd AI Logo" class="h-10 md:h-11 w-auto object-contain dark:invert drop-shadow-md group-hover:scale-105 transition-transform duration-300 relative z-10">
                </div>
                <div class="flex flex-col justify-center hidden sm:flex">
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">KURD AI</h1>
                    <span class="text-[0.55rem] md:text-[0.60rem] font-black tracking-widest bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500 mt-0.5">INNOVATION - FUTURE</span>
                </div>
            </a>
            <div class="hidden lg:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <a href="/news" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</a>
                <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="تووڵەکان" data-ba="ئامراز">تووڵەکان</a>
                <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
                <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="دەربارەی ئێمە" data-ba="دەربارەی مە">دەربارەی ئێمە</a>
            </div>
            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50 lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</a>
                <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50 lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>
            </div>
        </div>
    </nav>

    <!-- قۆناغی 1: هەڵبژاردنی زمان -->
    <div id="home-view" class="relative min-h-[85vh] py-16 px-4 overflow-hidden flex flex-col items-center justify-center">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob" style="animation-delay: 4s;"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center mb-16 w-full max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="فێرگەی پرۆگرامسازی" data-ba="فێرگەها پرۆگرامسازییێ">فێرگەی پرۆگرامسازی</h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە." data-ba="وێ زمانێ هەلبژێرە کو دڤێت ژێ دەستپێبکەی و پێنگاڤ ب پێنگاڤ فێرببە.">ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە.</p>
        </div>
        
        <div id="languages-grid" class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl mx-auto"></div>

        <!-- بەشی ئەدمین -->
        <div class="admin-only hidden relative z-10 mt-20 w-full max-w-5xl mx-auto glass-card p-8 rounded-3xl shadow-xl border-t-4 border-purple-600">
            <h3 class="text-2xl font-bold mb-6 border-b pb-4 dark:border-gray-700">دەستکاریکردنی فێرگە (ئەدمین)</h3>
            <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <button id="tab-btn-lang" onclick="switchAdminTab('lang')" class="px-6 py-2 bg-purple-600 text-white rounded-lg font-bold">1. زمان</button>
                <button id="tab-btn-lesson" onclick="switchAdminTab('lesson')" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold">2. وانە (دەستکاری ئاسان)</button>
                <button id="tab-btn-quiz" onclick="switchAdminTab('quiz')" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold">3. پرسیار</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-6 py-2 bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 rounded-lg font-bold border border-red-200 dark:border-red-800">4. بەڕێوەبردن</button>
            </div>
            
            <form id="form-lang" class="admin-form space-y-4">
                <input type="hidden" id="edit_lang_id">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">ناوی زمان (سۆرانی)</label><input type="text" id="lang_name_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">ناوی زمان (بادینی)</label><input type="text" id="lang_name_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">کورتە (سۆرانی)</label><textarea id="lang_desc_so" required rows="3" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                    <div><label class="block font-bold mb-2">کورتە (بادینی)</label><textarea id="lang_desc_ba" required rows="3" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div><label class="block font-bold mb-2">پاشگری زمان (بۆ نموونە: py, php, cpp)</label><input type="text" id="lang_ext" required placeholder="py" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-mono" dir="ltr"></div>
                    <div><label class="block font-bold mb-2">ڕەنگی پاشبنەما</label><input type="text" id="lang_color" value="bg-blue-100" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">لۆگۆی زمانەکە</label><input type="file" id="lang_logo_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <button type="submit" id="btn-submit-lang" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 rounded-xl font-bold">سەیڤکردنی زمان</button>
            </form>

            <form id="form-lesson" class="admin-form space-y-4 hidden">
                <input type="hidden" id="edit_lesson_id">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-1"><label class="block font-bold mb-2">زمان</label><select id="lesson_lang_select" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></select></div>
                    <div class="md:col-span-1"><label class="block font-bold mb-2">ڕیزبەندی (ژمارە)</label><input type="number" id="lesson_order" value="1" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div class="md:col-span-1"><label class="block font-bold mb-2">ئاست (سۆرانی)</label><input type="text" id="lesson_level_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div class="md:col-span-1"><label class="block font-bold mb-2">ئاست (بادینی)</label><input type="text" id="lesson_level_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">سەردێڕ (سۆرانی)</label><input type="text" id="lesson_title_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">سەردێڕ (بادینی)</label><input type="text" id="lesson_title_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <!-- ناوەڕۆک بە Quill -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-10">
                        <label class="block font-bold mb-2 text-blue-600">ناوەڕۆک (سۆرانی) - ئاسانکراو</label>
                        <div id="editor_content_so"></div>
                    </div>
                    <div class="mb-10">
                        <label class="block font-bold mb-2 text-blue-600">ناوەڕۆک (بادینی) - ئاسانکراو</label>
                        <div id="editor_content_ba"></div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                    <h4 class="font-black text-purple-600 mb-4">بەشی مەشق و تاقیکردنەوە (Proof of Learning)</h4>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div><label class="block font-bold mb-2">پرسیاری مەشق (سۆرانی) - با پڕ نەکرێتەوە ئەگەر مەشق نییە</label><textarea id="lesson_challenge_so" rows="2" placeholder="نموونە: کۆدێک بنووسە کە وشەی هەولێر چاپ بکات" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                        <div><label class="block font-bold mb-2">پرسیاری مەشق (بادینی)</label><textarea id="lesson_challenge_ba" rows="2" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></textarea></div>
                    </div>
                    <div>
                        <label class="block font-bold mb-2 text-green-600">وەڵامی چاوەڕوانکراو (Expected Output Text)</label>
                        <textarea id="lesson_expected_output" rows="3" dir="ltr" placeholder="هەولێر" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-mono text-left"></textarea>
                    </div>
                </div>

                <div><label class="block font-bold mb-2 mt-4">کۆدی نموونە (دەردەکەوێت لە سەکۆکەدا)</label><textarea id="lesson_code" rows="5" dir="ltr" class="w-full p-3 rounded-xl bg-[#1e1e1e] text-green-400 font-mono text-left"></textarea></div>
                <div>
                    <label class="block font-bold mb-2 mt-4 text-blue-600">ئەنجامی کۆدی نموونە (Example Output)</label>
                    <textarea id="lesson_example_output" rows="3" dir="ltr" placeholder="hello world" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-mono text-left"></textarea>
                </div>
                <button type="submit" id="btn-submit-lesson" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold mt-4">سەیڤکردنی وانە</button>
            </form>

            <form id="form-quiz" class="admin-form space-y-4 hidden">
                <input type="hidden" id="edit_quiz_id">
                <div><label class="block font-bold mb-2">وانە</label><select id="quiz_lesson_select" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></select></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">پرسیار (سۆرانی)</label><input type="text" id="quiz_question_so" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">پرسیار (بادینی)</label><input type="text" id="quiz_question_ba" required class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div class="space-y-3">
                        <input type="text" id="quiz_opt0_so" placeholder="بژاردەی ١" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt1_so" placeholder="بژاردەی ٢" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt2_so" placeholder="بژاردەی ٣" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt3_so" placeholder="بژاردەی ٤" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                    </div>
                    <div class="space-y-3">
                        <input type="text" id="quiz_opt0_ba" placeholder="بژاردەی ١" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt1_ba" placeholder="بژاردەی ٢" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt2_ba" placeholder="بژاردەی ٣" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                        <input type="text" id="quiz_opt3_ba" placeholder="بژاردەی ٤" required class="w-full p-3 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block font-bold mb-2">وەڵامە ڕاستەکە</label>
                    <select id="quiz_correct" required class="w-full p-3 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-300 font-bold">
                        <option value="0">بژاردەی ١</option><option value="1">بژاردەی ٢</option><option value="2">بژاردەی ٣</option><option value="3">بژاردەی ٤</option>
                    </select>
                </div>
                <button type="submit" id="btn-submit-quiz" class="w-full bg-gradient-to-r from-green-600 to-teal-500 text-white py-4 rounded-xl font-bold">سەیڤکردنی پرسیار</button>
            </form>

            <div id="form-manage" class="admin-form hidden">
                <div class="mb-4">
                    <select id="manage_category" onchange="renderManageList()" class="w-full p-3 rounded-xl bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-bold outline-none">
                        <option value="langs">زمانەکان</option><option value="lessons">وانەکان</option><option value="quizzes">پرسیارەکان</option>
                    </select>
                </div>
                <div id="manage-list" class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar p-4 bg-gray-50 dark:bg-[#0a0f1c] rounded-2xl border border-gray-200"></div>
            </div>
        </div>
    </div>

    <!-- قۆناغی 2: فێربوونی دابەشکراو (Learning View) -->
    <div id="learning-view" class="hidden flex flex-col md:flex-row min-h-[calc(100vh-76px)] relative bg-gray-50 dark:bg-[#0a0f1c]">
        
        <button onclick="goBackToHome()" class="absolute top-6 left-4 md:left-8 z-30 glass-card text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-full shadow-lg font-bold flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all hover:-translate-x-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="lang-str" data-so="گەڕانەوە" data-ba="زڤڕین">گەڕانەوە</span>
        </button>

        <!-- سایت بار (Sidebar with XP & Streak) -->
        <aside class="w-full md:w-80 bg-white dark:bg-[#111827] border-l border-gray-200/50 dark:border-gray-800/50 overflow-y-auto custom-scrollbar h-[calc(100vh-76px)] shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.05)] z-20 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center bg-gray-50 dark:bg-[#0a0f1c]">
                <div class="flex items-center gap-3">
                    <span class="text-3xl filter drop-shadow-md">🔥</span>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest font-black lang-str" data-so="بەردەوامی" data-ba="بەردەوامی">بەردەوامی</span>
                        <span id="streak-counter" class="text-xl font-black text-orange-500">0</span>
                    </div>
                </div>
                <div class="h-8 w-px bg-gray-300 dark:bg-gray-700"></div>
                <div class="flex items-center gap-3">
                    <span class="text-3xl filter drop-shadow-md">⭐</span>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest font-black lang-str" data-so="خاڵەکان" data-ba="خاڵان">خاڵەکان</span>
                        <span id="xp-counter" class="text-xl font-black text-blue-500">0</span>
                    </div>
                </div>
            </div>
            <div class="p-6 flex-1 relative" id="sidebar-content"></div>
        </aside>

        <!-- ناوەڕۆکی سەرەکی (Main Learning Content) -->
        <main class="flex-1 p-6 md:p-12 overflow-y-auto h-[calc(100vh-76px)] relative z-10 flex flex-col">
            <div class="max-w-4xl mx-auto w-full flex-1 flex flex-col pt-10 md:pt-0">
                <h1 id="display-title" class="text-4xl md:text-5xl font-black mb-6 text-gray-900 dark:text-white leading-tight"></h1>
                
                <div id="display-content" class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8 font-medium rendered-content"></div>
                
                <div id="display-code-box" class="hidden mb-6 relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-800 bg-[#1e1e1e]">
                        <div class="bg-[#2d2d2d] px-4 py-3 flex justify-between items-center border-b border-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span class="text-[10px] text-gray-500 mr-3 font-bold uppercase tracking-wider lang-str" data-so="نمونە" data-ba="نمونە">نمونە</span>
                                <span id="code-filename-label" class="text-xs font-mono text-gray-400">main.py</span>
                            </div>
                        </div>
                        <div class="p-5 overflow-x-auto" dir="ltr">
                            <div id="display-code" class="font-mono text-[15px] leading-relaxed space-y-1"></div>
                        </div>
                    </div>
                </div>

                <div id="example-output-box" class="hidden mb-10">
                    <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider lang-str" data-so="ئەنجام" data-ba="ئەنجام">ئەنجام</span>
                            <pre id="display-example-output" dir="ltr" class="mt-1 text-emerald-700 dark:text-emerald-300 font-mono text-sm bg-white dark:bg-emerald-900/20 rounded-lg p-3 border border-emerald-100 dark:border-emerald-800/30"></pre>
                        </div>
                    </div>
                </div>

                <div id="challenge-container" class="hidden mb-10 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/15 dark:to-indigo-900/15 border-2 border-purple-300 dark:border-purple-700/50 rounded-2xl p-6 relative overflow-hidden shadow-[0_4px_24px_rgba(147,51,234,0.08)]">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 via-fuchsia-500 to-indigo-500"></div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-gray-800 dark:text-white lang-str" data-so="ئێستا تۆ تاقیبکە" data-ba="ئێستا تۆ تاقیبکە">ئێستا تۆ تاقیبکە</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium lang-str" data-so="کۆدەکە لە خوارەوە بنووسە و پشکنینی بکە" data-ba="کۆدێ ل خوارێ بنڤیسە و پشکنینێ بکە">کۆدەکە لە خوارەوە بنووسە و پشکنینی بکە</p>
                        </div>
                    </div>
                    <p id="challenge-text" class="text-gray-700 dark:text-gray-200 font-bold leading-relaxed bg-white/60 dark:bg-black/20 rounded-xl p-4 border border-purple-200/50 dark:border-purple-800/50"></p>
                    <div class="mt-4 flex justify-end">
                        <button onclick="openTryItYourself()" class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            <span class="lang-str" data-so="کردنەوەی سەکۆی کۆدکردن" data-ba="ڤەکرنا سەکۆیێ کۆدکرنێ">کردنەوەی سەکۆی کۆدکردن</span>
                        </button>
                    </div>
                </div>

                <div class="mt-auto pt-8 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center">
                    <button id="btn-prev" class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 px-6 py-3 rounded-xl font-bold hover:bg-gray-200 transition"></button>
                    <button id="btn-action" onclick="handleNextAction()" class="bg-blue-600 text-white px-10 py-3 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 hover:-translate-y-1"></button>
                </div>
            </div>
        </main>
    </div>

    <!-- سەکۆی کۆدکردن (Compiler) -->
    <div id="compiler-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[100] hidden items-center justify-center p-2 md:p-6">
        <div class="bg-[#1e1e1e] w-full max-w-7xl h-[90vh] md:h-[85vh] rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-700 transform transition-all">
            <!-- Modal Header -->
            <div class="bg-[#252526] text-white p-4 flex justify-between items-center border-b border-[#333]">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <h3 id="compiler-modal-title" class="text-lg font-bold font-mono lang-str" data-so="سەکۆی کۆدکردن" data-ba="سەکۆیێ کۆدکرنێ">سەکۆی کۆدکردن</h3>
                </div>
                <button onclick="closeTryItYourself()" class="text-gray-400 hover:text-white bg-[#333] hover:bg-red-500 w-8 h-8 rounded-full flex items-center justify-center transition-colors">✕</button>
            </div>
            
            <div class="flex-1 flex flex-col md:flex-row overflow-hidden relative">
                <!-- Editor Pane -->
                <div class="w-full md:w-1/2 flex flex-col border-b md:border-b-0 md:border-l border-[#333] relative">
                    
                    <!-- Challenge Panel (ئەرکی تۆ لەناو کۆمپایڵەر) -->
                    <div id="compiler-challenge-panel" class="bg-[#2a2a2b] border-b border-[#444] p-4 shrink-0 hidden shadow-md">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 text-purple-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <span class="text-[11px] text-gray-400 font-bold tracking-widest mb-1 block lang-str" data-so="ئەرکی تۆ لەم وانەیە:" data-ba="ئەرکێ تە دڤێ وانەیێ دا:">ئەرکی تۆ لەم وانەیە:</span>
                                <p id="compiler-challenge-desc" class="text-sm text-gray-200 font-bold leading-relaxed"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Editor Toolbar -->
                    <div class="bg-[#2d2d2d] px-4 py-2 flex justify-between items-center border-b border-[#1e1e1e]">
                        <span id="compiler-filename-label" class="text-xs font-mono text-gray-400 uppercase tracking-wider">main.py</span>
                        <div class="flex gap-2">
                            <button onclick="loadExampleIntoCompiler()" class="bg-[#3a3a3c] hover:bg-[#4a4a4c] text-gray-300 px-3 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 border border-[#444]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="lang-str" data-so="هێنانی نموونە" data-ba="ئینانا نمونەیێ">هێنانی نموونە</span>
                            </button>
                            <button onclick="runCode()" class="bg-gray-600 hover:bg-gray-500 text-white px-5 py-1.5 rounded-lg font-bold text-xs shadow flex items-center gap-1.5 transition-all">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                <span id="btn-run-text" class="lang-str" data-so="کارپێکردن" data-ba="کارپێکرن">کارپێکردن</span>
                            </button>
                            <button id="btn-submit-challenge" onclick="verifyChallenge()" class="hidden bg-purple-600 hover:bg-purple-500 text-white px-5 py-1.5 rounded-lg font-bold text-xs shadow flex items-center gap-1.5 transition-all hover:scale-105">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span id="btn-submit-challenge-text" class="lang-str" data-so="پشکنینی مەشق" data-ba="پشکنینا مەشقێ">پشکنینی مەشق</span>
                            </button>
                        </div>
                    </div>
                    <!-- Editor Textarea -->
                    <textarea id="user-code" class="flex-1 w-full bg-[#1e1e1e] text-[#d4d4d4] font-mono text-[16px] leading-relaxed p-6 focus:outline-none resize-none custom-scrollbar" dir="ltr" spellcheck="false"></textarea>
                </div>
                
                <!-- Terminal Pane -->
                <div class="w-full md:w-1/2 flex flex-col bg-[#000000]">
                    <div class="bg-[#2d2d2d] px-4 py-3 flex items-center gap-2 border-b border-[#1e1e1e]">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs font-mono text-gray-400 uppercase tracking-wider lang-str" data-so="دەرئەنجام (Output)" data-ba="دەرئەنجام (Output)">دەرئەنجام (Output)</span>
                    </div>
                    <pre id="code-output" class="flex-1 w-full text-green-400 font-mono text-[15px] leading-relaxed p-6 overflow-y-auto whitespace-pre-wrap text-left custom-scrollbar" dir="ltr"></pre>
                    <iframe id="code-preview" class="flex-1 w-full bg-white hidden" sandbox="allow-scripts allow-modals allow-forms"></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- پەنجەرەی Quiz -->
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
                <h3 id="quiz-success-title" class="text-3xl font-black mb-4 text-gray-800 dark:text-white lang-str" data-so="ئافەرین! تەواوت کرد" data-ba="ئافەرم! تە ب دووماهی ئینا">ئافەرین! تەواوت کرد</h3>
                <p id="quiz-score-text" class="text-xl text-gray-500 dark:text-gray-400 mb-10 font-medium"></p>
                <button id="btn-quiz-next" onclick="finishQuizAndContinue()" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-lg w-full transition-all hover:-translate-y-1 lang-str" data-so="بڕۆ بۆ وانەی داهاتوو" data-ba="هەڕە بۆ وانەیا داهاتی">بڕۆ بۆ وانەی داهاتوو</button>
            </div>
            <div id="quiz-footer" class="mt-10 flex justify-end">
                <button id="btn-next-question" onclick="nextQuestion()" class="bg-gray-200 dark:bg-gray-800 text-gray-500 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed transition-all lang-str" data-so="دواتر" data-ba="داهاتی" disabled>دواتر</button>
            </div>
        </div>
    </div>

    <!-- Firebase & Core Logic -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue, get } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let languagesData = {}; let lessonsData = {}; let quizzesData = {};
        let currentActiveLanguage = null; let currentLessonArray = []; let currentLessonIndex = 0;

        // --- Pyodide (Python in-browser) ---
        let pyodide = null;
        async function initPyodide() {
            if (!pyodide) { pyodide = await loadPyodide(); }
        }
        let currentLangExt = 'py';
        
        let currentUid = null;
        let completedLessons = [];
        let userXP = 0;
        let dayStreak = 0;
        let lastActiveDate = "";
        let latestCompilerOutput = ""; 

        // --- Quill Editors Initialization ---
        let quillSo = new Quill('#editor_content_so', { theme: 'snow', modules: { toolbar: [ [{ 'header': [1, 2, 3, false] }], ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['code-block'] ] } });
        let quillBa = new Quill('#editor_content_ba', { theme: 'snow', modules: { toolbar: [ [{ 'header': [1, 2, 3, false] }], ['bold', 'italic', 'underline'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], ['code-block'] ] } });

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function applyLanguage() {
            document.getElementById('lang-text').innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => { el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so'); });
            
            renderLanguagesGrid();
            
            if(currentActiveLanguage) {
                openLanguage(currentActiveLanguage.id, currentLessonIndex);
                
                // Update dynamic button texts based on language
                const outText = document.getElementById('code-output').innerText;
                if(outText === 'ئامادەیە بۆ کارپێکردن...' || outText === 'ئامادەیە بۆ کارپێکرنێ...') {
                    document.getElementById('code-output').innerText = currentLang === 'so' ? 'ئامادەیە بۆ کارپێکردن...' : 'ئامادەیە بۆ کارپێکرنێ...';
                }
            }
        }

        // Support Tab key in compiler
        document.getElementById('user-code').addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                const start = this.selectionStart;
                const end = this.selectionEnd;
                this.value = this.value.substring(0, start) + "    " + this.value.substring(end);
                this.selectionStart = this.selectionEnd = start + 4;
            }
        });

        // Guess file extension
        function guessExtFromName(name) {
            const n = (name || '').toLowerCase();
            if (n.includes('++') || n.includes('cpp') || n.includes('c++')) return 'cpp';
            if (n.includes('php')) return 'php';
            if (n.includes('java')) return 'java';
            if (n.includes('javascript') || n.includes('js')) return 'js';
            if (n.includes('html')) return 'html';
            if (n.includes('css')) return 'css';
            if (n.includes('ruby') || n.includes('rb')) return 'rb';
            if (n.includes('rust') || n.includes('rs')) return 'rs';
            if (n.includes('go')) return 'go';
            if (n.includes('swift')) return 'swift';
            if (n.includes('kotlin') || n.includes('kt')) return 'kt';
            return 'py';
        }

        // --- COMPILER LOGIC ---
        window.runCode = async function() {
            const ext = (currentActiveLanguage && currentActiveLanguage.ext) ? currentActiveLanguage.ext.toLowerCase().replace('.','') : (currentActiveLanguage ? guessExtFromName(loc(currentActiveLanguage, 'name')) : 'py');
            if (ext === 'cpp') await runCppCode();
            else if (ext === 'py' || ext === 'python') await runPythonCode();
            else if (ext === 'php') await runPhpCode();
            else if (ext === 'html' || ext === 'htm') await runHtmlCode();
            else if (ext === 'css') await runCssCode();
            else await runServerCode(ext);
        }

        function showPreview(htmlContent) {
            const out = document.getElementById('code-output');
            const preview = document.getElementById('code-preview');
            if (out) out.classList.add('hidden');
            if (preview) {
                preview.classList.remove('hidden');
                preview.srcdoc = htmlContent;
            }
        }

        function hidePreview() {
            const out = document.getElementById('code-output');
            const preview = document.getElementById('code-preview');
            if (out) out.classList.remove('hidden');
            if (preview) preview.classList.add('hidden');
        }

        async function runHtmlCode() {
            const code = document.getElementById('user-code').value;
            hidePreview();
            showPreview(code);
            latestCompilerOutput = "";
        }

        async function runCssCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            out.classList.add("animate-pulse");
            const previewDoc = `<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; margin: 20px; padding: 20px; background: #f8fafc; }
${code}
</style>
</head>
<body>
<h1 class="demo-h1">Kurd AI - CSS Preview</h1>
<p class="demo-p">This is a sample paragraph. Write your CSS and watch it apply to these elements.</p>
<div class="demo-box">Box 1</div>
<div class="demo-box">Box 2</div>
<button class="demo-btn">Click Me</button>
</body>
</html>`;
            hidePreview();
            showPreview(previewDoc);
            latestCompilerOutput = "";
            out.classList.remove("animate-pulse");
        }

        async function runPythonCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            hidePreview();
            out.innerText = currentLang === 'so' ? "سەرقاڵی کارپێکردن..." : "مژویلی کارپێکرنێیە...";
            out.classList.add("animate-pulse");
            try {
                await initPyodide();
                pyodide.runPython("import sys\nfrom io import StringIO\nsys.stdout = StringIO()");
                await pyodide.runPythonAsync(code);
                latestCompilerOutput = pyodide.runPython("sys.stdout.getvalue()");
                out.innerText = latestCompilerOutput || (currentLang === 'so' ? "(بێ دەرکەوتن)" : "(بێ دەرکەفتن)");
            } catch (err) {
                latestCompilerOutput = ""; out.innerText = (currentLang === 'so' ? "هەڵە:\n" : "خەلەت:\n") + err;
            }
            out.classList.remove("animate-pulse");
        }

        async function runCppCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            hidePreview();
            out.innerText = currentLang === 'so' ? "سەرقاڵی کارپێکردن..." : "مژویلی کارپێکرنێیە..."; 
            out.classList.add("animate-pulse");
            try {
                const res = await fetch("https://godbolt.org/api/compiler/g142/compile", {
                    method: "POST", headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify({ source: code, compiler: "g142", options: { userArguments: "-std=c++17 -O2", filters: { execute: true, binary: false } }})
                });
                const data = await res.json();
                let output = "";
                if (data.execResult && data.execResult.stdout) output = data.execResult.stdout.map(o => o.text).join("");
                if (data.execResult && data.execResult.stderr && data.execResult.stderr.length) output += "\n" + data.execResult.stderr.map(o => o.text).join("");
                if (!output && data.stderr && data.stderr.length) output = data.stderr.map(o => o.text).join("");
                if (data.code && data.code !== 0) output = "Compilation error\n" + output;
                latestCompilerOutput = output;
                out.innerText = latestCompilerOutput || (currentLang === 'so' ? "(بێ دەرکەوتن)" : "(بێ دەرکەفتن)");
            } catch (err) {
                latestCompilerOutput = ""; out.innerText = (currentLang === 'so' ? "هەڵە:\n" : "خەلەت:\n") + err;
            }
            out.classList.remove("animate-pulse");
        }

        async function runPhpCode() {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            hidePreview();
            out.innerText = currentLang === 'so' ? "سەرقاڵی کارپێکردنی PHP..." : "مژویلی کارپێکرنا PHP..."; 
            out.classList.add("animate-pulse");
            try {
                const res = await fetch("/ferga/run-php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ code: code })
                });
                const data = await res.json();
                latestCompilerOutput = data.output || "";
                if (data.code && data.code !== 0 && !latestCompilerOutput) {
                    out.innerText = (currentLang === 'so' ? "هەڵە لە جێبەجێکردندا\n" : "خەلەت د جێبەجێکرنێدا\n") + (data.output || "");
                } else {
                    out.innerText = latestCompilerOutput || (currentLang === 'so' ? "(بێ دەرکەوتن)" : "(بێ دەرکەفتن)");
                }
            } catch (err) {
                latestCompilerOutput = ""; out.innerText = (currentLang === 'so' ? "هەڵە لە پەیوەندیکردن بە ڕاژەکار:\n" : "خەلەت د پەیوەندیکرنێدا:\n") + err;
            }
            out.classList.remove("animate-pulse");
        }

        async function runServerCode(languageExt) {
            const out = document.getElementById('code-output');
            const code = document.getElementById('user-code').value;
            hidePreview();
            out.innerText = currentLang === 'so' ? "سەرقاڵی کارپێکردن..." : "مژویلی کارپێکرنێیە..."; 
            out.classList.add("animate-pulse");
            try {
                const res = await fetch("/ferga/run-code", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ language: languageExt, code: code })
                });
                const data = await res.json();
                latestCompilerOutput = data.output || "";
                if (data.code && data.code !== 0 && !latestCompilerOutput) {
                    out.innerText = (currentLang === 'so' ? "هەڵە لە جێبەجێکردندا\n" : "خەلەت د جێبەجێکرنێدا\n") + (data.output || "");
                } else {
                    out.innerText = latestCompilerOutput || (currentLang === 'so' ? "(بێ دەرکەوتن)" : "(بێ دەرکەفتن)");
                }
            } catch (err) {
                latestCompilerOutput = ""; out.innerText = (currentLang === 'so' ? "هەڵە لە پەیوەندیکردن بە ڕاژەکار:\n" : "خەلەت د پەیوەندیکرنێدا:\n") + err;
            }
            out.classList.remove("animate-pulse");
        }

        // --- Preview checks (HTML/CSS) ---
        function parsePreviewChecks(raw) {
            try {
                const p = JSON.parse(raw);
                return Array.isArray(p) ? p : (Array.isArray(p.checks) ? p.checks : []);
            } catch (e) { return []; }
        }

        function normalizeColor(v) {
            v = (v || '').trim().toLowerCase();
            let m;
            if (m = v.match(/^#([0-9a-f]{3})$/)) {
                return [parseInt(m[1][0]+m[1][0],16), parseInt(m[1][1]+m[1][1],16), parseInt(m[1][2]+m[1][2],16)].join(',');
            }
            if (m = v.match(/^#([0-9a-f]{6})$/)) {
                return [parseInt(m[1].slice(0,2),16), parseInt(m[1].slice(2,4),16), parseInt(m[1].slice(4,6),16)].join(',');
            }
            if (m = v.match(/^rgba?\(\s*(\d+)\s*[,\s]\s*(\d+)\s*[,\s]\s*(\d+)/)) {
                return [m[1], m[2], m[3]].join(',');
            }
            return null;
        }

        function previewChecksPass(checks) {
            const frame = document.getElementById('code-preview');
            const doc = frame && frame.contentDocument;
            if (!doc) return false;

            const styleMatches = (sel, prop, expected) => {
                const els = doc.querySelectorAll(sel);
                for (const el of els) {
                    const cs = doc.defaultView.getComputedStyle(el);
                    const actual = (cs.getPropertyValue(prop) || '').trim();
                    const ne = normalizeColor(expected);
                    const na = normalizeColor(actual);
                    if (ne !== null && na !== null) {
                        if (na === ne) return true;
                    } else if (actual.toLowerCase().includes(expected.toLowerCase())) {
                        return true;
                    }
                }
                return false;
            };

            for (const c of checks) {
                if (c.t === 'text') {
                    const bodyText = (doc.body && doc.body.innerText) || '';
                    if (!bodyText.includes(c.v)) return false;
                } else if (c.t === 'style') {
                    if (!styleMatches(c.s, c.p, c.v)) return false;
                } else if (c.t === 'styled') {
                    let ok = false;
                    const els = doc.querySelectorAll(c.s);
                    for (const el of els) {
                        const val = doc.defaultView.getComputedStyle(el).getPropertyValue(c.p).trim();
                        if (val && val !== 'none' && val !== '0s' && val !== '0px') { ok = true; break; }
                    }
                    if (!ok) return false;
                } else if (c.t === 'attr') {
                    let ok = false;
                    const els = doc.querySelectorAll(c.s);
                    for (const el of els) {
                        if ((el.getAttribute(c.a) || '').includes(c.v)) { ok = true; break; }
                    }
                    if (!ok) return false;
                } else if (c.t === 'count') {
                    if (doc.querySelectorAll(c.s).length < c.min) return false;
                } else if (c.t === 'var') {
                    const val = doc.defaultView.getComputedStyle(doc.documentElement).getPropertyValue(c.n).trim();
                    if (!val.toLowerCase().includes((c.v || '').toLowerCase())) return false;
                } else if (c.t === 'media') {
                    let ok = false;
                    try {
                        for (const sheet of doc.styleSheets) {
                            for (const rule of sheet.cssRules) {
                                if (rule.type === 4 && rule.conditionText.toLowerCase().includes((c.v || '').toLowerCase())) { ok = true; break; }
                            }
                            if (ok) break;
                        }
                    } catch (e) {}
                    if (!ok) return false;
                }
            }
            return true;
        }

        // --- Challenge Validation ---
        window.verifyChallenge = async function() {
            const lesson = currentLessonArray[currentLessonIndex];
            const btnText = document.getElementById('btn-submit-challenge-text');
            const btn = document.getElementById('btn-submit-challenge');
            
            btnText.innerHTML = currentLang === 'so' ? '<span class="animate-pulse">سەرقاڵی پشکنین...</span>' : '<span class="animate-pulse">مژویلی پشکنینێیە...</span>';
            
            await window.runCode(); 
            
            const ext = (currentActiveLanguage && currentActiveLanguage.ext) ? currentActiveLanguage.ext.toLowerCase().replace('.','') : (currentActiveLanguage ? guessExtFromName(loc(currentActiveLanguage, 'name')) : 'py');

            let pass = false;

            if (ext === 'html' || ext === 'css') {
                const checks = parsePreviewChecks(lesson.expected_output || '');
                pass = checks.length > 0 && previewChecksPass(checks);
            } else {
                // Normalize expected and actual outputs (convert CRLF to LF, and trim whitespace)
                const expected = lesson.expected_output ? lesson.expected_output.trim().replace(/\r\n/g, '\n') : "";
                const actual = latestCompilerOutput ? latestCompilerOutput.trim().replace(/\r\n/g, '\n') : "";
                pass = actual === expected;
            }

            if(pass) {
                btnText.innerHTML = currentLang === 'so' ? "ئافەرین! وەڵامەکە ڕاستە ✓" : "ئافەرم! بەرسڤ ڕاستە ✓";
                btn.classList.replace('bg-purple-600', 'bg-green-600');
                
                if(!completedLessons.includes(lesson.id)) {
                    completedLessons.push(lesson.id);
                    triggerConfetti();
                    addXP(50); 
                    saveProgressToFirebase();
                    
                    setTimeout(() => {
                        window.closeTryItYourself();
                        openLanguage(currentActiveLanguage.id, currentLessonIndex);
                    }, 1500);
                } else {
                    setTimeout(() => { window.closeTryItYourself(); openLanguage(currentActiveLanguage.id, currentLessonIndex); }, 1500);
                }
            } else {
                btnText.innerHTML = currentLang === 'so' ? "هەڵەیە، دووبارە تاقیبکەرەوە" : "خەلەتە، دوبارە تاقیبکە";
                btn.classList.replace('bg-purple-600', 'bg-red-600');
                setTimeout(() => {
                    btnText.innerHTML = currentLang === 'so' ? 'پشکنینی مەشق' : 'پشکنینا مەشقێ';
                    btn.classList.replace('bg-red-600', 'bg-purple-600');
                }, 3000);
            }
        }

        // --- Confetti & Notifications ---
        function triggerConfetti() {
            const canvas = document.getElementById('confetti-canvas');
            if (!canvas) return;
            canvas.width = window.innerWidth; canvas.height = window.innerHeight;
            canvas.style.display = 'block';
            const ctx = canvas.getContext('2d');
            const colors = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444'];
            const particles = [];
            for (let i = 0; i < 150; i++) {
                particles.push({
                    x: Math.random() * canvas.width, y: Math.random() * canvas.height - canvas.height,
                    w: Math.random() * 10 + 5, h: Math.random() * 6 + 3,
                    color: colors[Math.floor(Math.random() * colors.length)],
                    vx: (Math.random() - 0.5) * 8, vy: Math.random() * 5 + 2,
                    rot: Math.random() * 360, rotV: (Math.random() - 0.5) * 10
                });
            }
            let frame = 0; const maxFrames = 200;
            function draw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(p => {
                    p.x += p.vx; p.vy += 0.1; p.y += p.vy; p.rot += p.rotV;
                    ctx.save(); ctx.translate(p.x, p.y); ctx.rotate(p.rot * Math.PI / 180);
                    ctx.fillStyle = p.color; ctx.globalAlpha = Math.max(0, 1 - frame/maxFrames);
                    ctx.fillRect(-p.w/2, -p.h/2, p.w, p.h); ctx.restore();
                });
                if (++frame < maxFrames) requestAnimationFrame(draw);
                else { ctx.clearRect(0, 0, canvas.width, canvas.height); canvas.style.display = 'none'; }
            }
            draw();
        }

        function showXPNotification(amount) {
            const container = document.getElementById('xp-notification-container');
            const notif = document.createElement('div');
            notif.className = 'xp-popup bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-2xl shadow-2xl font-bold flex items-center gap-2';
            notif.innerHTML = `✨ +${amount} XP`;
            container.appendChild(notif);
            setTimeout(() => notif.remove(), 2500);
        }

        function updateStatsUI() {
            const streakEl = document.getElementById('streak-counter');
            const xpEl = document.getElementById('xp-counter');
            if(streakEl) streakEl.innerText = dayStreak;
            if(xpEl) xpEl.innerText = userXP;
        }

        function updateStreakLogic() {
            const todayStr = new Date().toLocaleDateString('en-CA'); 
            if (lastActiveDate !== todayStr) {
                if (lastActiveDate) {
                    const diffDays = Math.ceil(Math.abs(new Date(todayStr) - new Date(lastActiveDate)) / (1000 * 60 * 60 * 24)); 
                    if (diffDays === 1) dayStreak++; else if (diffDays > 1) dayStreak = 1;
                } else dayStreak = 1;
                lastActiveDate = todayStr;
                return true; 
            }
            return false;
        }

        function saveProgressToFirebase() {
            if(!currentUid) return;
            update(dbRef(db, `users/${currentUid}/ferga_progress`), { xp: userXP, completedLessons: completedLessons, streak: dayStreak, lastActiveDate: lastActiveDate });
            updateStatsUI();
        }

        window.addXP = function(amount) {
            userXP += amount;
            showXPNotification(amount);
            saveProgressToFirebase();
        };

        // --- Data Fetching ---
        onValue(dbRef(db, 'ferga_languages'), (s) => { languagesData = s.val() || {}; applyLanguage(); updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_lessons'), (s) => { lessonsData = s.val() || {}; updateAdminSelects(); renderManageList(); });
        onValue(dbRef(db, 'ferga_quizzes'), (s) => { quizzesData = s.val() || {}; renderManageList(); });

        onAuthStateChanged(auth, async (user) => { 
            if(!user) { window.location.href = "/login"; } else {
                currentUid = user.uid;
                const snap = await get(dbRef(db, `users/${currentUid}/ferga_progress`));
                if(snap.exists()) {
                    const data = snap.val();
                    userXP = data.xp || 0; completedLessons = data.completedLessons || [];
                    dayStreak = data.streak || 0; lastActiveDate = data.lastActiveDate || "";
                } else {
                    userXP = 0; completedLessons = []; dayStreak = 0; lastActiveDate = "";
                }

                if(updateStreakLogic()) saveProgressToFirebase();
                updateStatsUI();
                
                document.body.style.display = 'block';
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    document.querySelector('.admin-only').classList.remove('hidden');
                }
            }
        });

        // --- Render UI ---
        function renderLanguagesGrid() {
            const grid = document.getElementById('languages-grid');
            if(!grid) return;
            grid.innerHTML = '';
            for (let id in languagesData) {
                const l = languagesData[id];
                const name = loc(l, 'name');
                const desc = loc(l, 'desc');
                let iconHtml = l.logo_url ? `<img src="${l.logo_url}" class="w-full h-full object-contain p-2">` : `<span class="text-3xl font-black text-gray-800">${name.charAt(0)}</span>`;
                grid.innerHTML += `
                    <div class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 flex flex-col items-center text-center p-10 group hover:-translate-y-2">
                        <div onclick="openLanguage('${id}')" class="cursor-pointer w-full flex flex-col items-center">
                            <div class="w-24 h-24 ${l.color || 'bg-blue-100'} rounded-[1.5rem] flex items-center justify-center mb-8 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">${iconHtml}</div>
                            <h3 class="text-2xl font-black mb-4 text-gray-900 dark:text-white">Learn <bdi>${name}</bdi></h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose line-clamp-3 mb-4">${desc}</p>
                        </div>
                        ${window.isAdmin ? `
                        <div class="flex items-center gap-2 w-full mt-auto pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                            <button onclick="event.stopPropagation(); window.openEditLangModal('${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-xl font-bold text-xs transition border border-amber-200 dark:border-amber-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                ${currentLang === 'so' ? 'دەستکاری' : 'دەستکاریکرن'}
                            </button>
                            <button onclick="event.stopPropagation(); window.deleteItem('langs','${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100 rounded-xl font-bold text-xs transition border border-red-200 dark:border-red-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                ${currentLang === 'so' ? 'سڕینەوە' : 'ژێبرن'}
                            </button>
                        </div>` : ''}
                    </div>`;
            }
        }

        window.openLanguage = function(langId, forcedIndex = null) {
            currentActiveLanguage = { id: langId, ...languagesData[langId] };
            document.getElementById('home-view').classList.add('hidden');
            document.getElementById('learning-view').classList.remove('hidden');
            document.getElementById('learning-view').classList.add('flex');
            
            let langLessons = Object.keys(lessonsData).filter(lid => lessonsData[lid].langId === langId).map(lid => ({id: lid, ...lessonsData[lid]}));
            
            // Sort by manual order, fallback to push id
            langLessons.sort((a, b) => {
                let orderA = parseInt(a.order) || 0;
                let orderB = parseInt(b.order) || 0;
                if (orderA !== orderB) return orderA - orderB;
                return a.id.localeCompare(b.id);
            });

            const grouped = {};
            langLessons.forEach(l => { const lvl = loc(l, 'level'); if(!grouped[lvl]) grouped[lvl] = []; grouped[lvl].push(l); });

            currentLessonArray = [];
            const sidebar = document.getElementById('sidebar-content');
            sidebar.innerHTML = '';
            
            let htmlStr = '';
            for (let level in grouped) {
                htmlStr += `<div class="mb-4 px-2 text-xs font-bold text-gray-400 dark:text-gray-500 tracking-widest mt-6">${level}</div><div class="relative pl-3 border-r-2 border-gray-100 dark:border-gray-800 mr-3">`;
                grouped[level].forEach(lesson => {
                    const index = currentLessonArray.length;
                    currentLessonArray.push(lesson);
                    const isCompleted = completedLessons.includes(lesson.id);
                    const isLocked = index > 0 && !completedLessons.includes(currentLessonArray[index - 1].id);
                    
                    let dotClass = isLocked ? 'locked' : (isCompleted ? 'completed' : 'current');
                    let btnClass = isLocked ? 'locked-lesson' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300';
                    let clickAction = isLocked ? '' : `loadLesson(${index})`;

                    htmlStr += `
                        <div class="relative flex items-center gap-3 mb-2 group">
                            <div class="absolute -right-[1.1rem] timeline-dot ${dotClass}"></div>
                            <button id="sidebar-btn-${index}" onclick="${clickAction}" class="w-full text-right flex justify-between items-center px-4 py-3 text-[14px] font-bold rounded-xl transition-all ${btnClass}">
                                <span class="truncate">${isLocked ? '🔒 ' : ''}${loc(lesson, 'title')}</span>
                                ${isCompleted ? '<svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' : ''}
                            </button>
                        </div>`;
                });
                htmlStr += `</div>`;
            }
            sidebar.innerHTML = htmlStr;

            currentLangExt = (currentActiveLanguage.ext) ? currentActiveLanguage.ext.replace('.','').toLowerCase() : guessExtFromName(loc(currentActiveLanguage, 'name'));
            document.getElementById('code-filename-label').textContent = 'main.' + currentLangExt;
            document.getElementById('compiler-filename-label').textContent = 'main.' + currentLangExt;
            
            if (currentLessonArray.length > 0) {
                let targetIdx = forcedIndex !== null ? forcedIndex : currentLessonArray.findIndex(l => !completedLessons.includes(l.id));
                if (targetIdx === -1) targetIdx = 0; 
                loadLesson(targetIdx);
            }
        };

        window.loadLesson = function(index) {
            currentLessonIndex = index;
            const lesson = currentLessonArray[index];
            
            document.querySelectorAll('[id^="sidebar-btn-"]').forEach(el => el.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm'));
            const activeBtn = document.getElementById(`sidebar-btn-${index}`);
            if(activeBtn && !activeBtn.classList.contains('locked-lesson')) {
                activeBtn.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
            }

            document.getElementById('display-title').innerHTML = loc(lesson, 'title');
            document.getElementById('display-content').innerHTML = loc(lesson, 'content');
            
            // Challenge Handling
            const challengeDesc = loc(lesson, 'challenge_desc');
            const hasChallenge = challengeDesc && lesson.expected_output;
            const isCompleted = completedLessons.includes(lesson.id);

            if (hasChallenge) {
                document.getElementById('challenge-container').classList.remove('hidden');
                document.getElementById('challenge-text').innerHTML = challengeDesc;
                document.getElementById('btn-submit-challenge').classList.remove('hidden');
                
                if(!isCompleted) document.getElementById('btn-action').classList.add('hidden');
                else document.getElementById('btn-action').classList.remove('hidden');
            } else {
                document.getElementById('challenge-container').classList.add('hidden');
                document.getElementById('btn-submit-challenge').classList.add('hidden');
                document.getElementById('btn-action').classList.remove('hidden');
            }

            if (lesson.code && lesson.code.trim() !== '') {
                document.getElementById('display-code-box').classList.remove('hidden');
                renderCodeExplanations(document.getElementById('display-code'), lesson);
            } else {
                document.getElementById('display-code-box').classList.add('hidden');
            }

            if (lesson.example_output && lesson.example_output.trim() !== '') {
                document.getElementById('example-output-box').classList.remove('hidden');
                document.getElementById('display-example-output').innerText = lesson.example_output;
            } else {
                document.getElementById('example-output-box').classList.add('hidden');
            }

            const btnPrev = document.getElementById('btn-prev');
            const btnAction = document.getElementById('btn-action');
            
            btnPrev.disabled = index === 0;
            btnPrev.style.opacity = index === 0 ? '0.3' : '1';
            btnPrev.innerHTML = currentLang === 'so' ? "&laquo; پێشوو" : "&laquo; پێشتر";
            btnPrev.onclick = () => { if(index > 0) loadLesson(index - 1); };

            const isLast = index === currentLessonArray.length - 1;

            if (!isCompleted) {
                btnAction.innerHTML = currentLang === 'so' ? "تەواوکردنی وانە ✓" : "ب دووماهی ئینانا وانەیێ ✓";
                btnAction.className = "bg-green-500 hover:bg-green-600 text-white px-10 py-3 rounded-xl font-bold text-lg shadow-lg transition hover:-translate-y-1";
            } else {
                btnAction.innerHTML = isLast ? (currentLang === 'so' ? "کۆتایی زمانەکە" : "دووماهیا زمانێ") : (currentLang === 'so' ? "وانەی داهاتوو &raquo;" : "وانەیا داهاتی &raquo;");
                btnAction.className = "bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-xl font-bold text-lg shadow-lg transition hover:-translate-y-1";
            }
        };

        window.handleNextAction = function() {
            const lessonId = currentLessonArray[currentLessonIndex].id;
            const isCompleted = completedLessons.includes(lessonId);

            if (!isCompleted) {
                let lessonQuizzes = Object.values(quizzesData).filter(q => q.lessonId === lessonId);
                if (lessonQuizzes.length > 0) startQuiz(lessonQuizzes, lessonId);
                else markLessonCompleted(lessonId);
            } else {
                if(currentLessonIndex < currentLessonArray.length - 1) {
                    loadLesson(currentLessonIndex + 1);
                }
            }
        };

        function markLessonCompleted(lessonId) {
            if(!completedLessons.includes(lessonId)) {
                completedLessons.push(lessonId);
                triggerConfetti();
                addXP(20);
                saveProgressToFirebase();
            }
            openLanguage(currentActiveLanguage.id, currentLessonIndex + 1 < currentLessonArray.length ? currentLessonIndex + 1 : currentLessonIndex); 
        }

        // --- Code Explanation Rendering (هێل ب هێل) ---
        function escapeHtml(s) {
            return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function renderCodeExplanations(container, lesson) {
            if (!container || !lesson || !lesson.code) return;
            const codeLines = lesson.code.split('\n');
            const explains = (currentLang === 'ba' ? lesson.code_explain_ba : lesson.code_explain_so) || [];
            let html = '';
            codeLines.forEach((line, i) => {
                const num = i + 1;
                const ex = explains[i] ? explains[i] : '';
                html += `<div class="flex gap-3 items-baseline">
                            <span class="text-gray-600 text-right w-6 shrink-0 select-none">${num}</span>
                            <code class="text-[#569cd6] whitespace-pre-wrap break-words flex-1">${escapeHtml(line) || ' '}</code>
                          </div>`;
                if (ex) {
                    html += `<div class="flex gap-3 ml-9 mb-3">
                                <span class="text-[#6a9955] shrink-0 leading-6">↳</span>
                                <span class="text-gray-400 text-[13px] leading-6" dir="auto">${ex}</span>
                             </div>`;
                } else {
                    html += `<div class="mb-3"></div>`;
                }
            });
            container.innerHTML = html;
        }

        // --- Modal/Compiler Functions ---
        window.openTryItYourself = function() {
            const lesson = currentLessonArray[currentLessonIndex];
            
            // Set compiler code to blank/comment to prevent copying example code automatically
            document.getElementById('user-code').value = currentLang === 'so' ? "# لێرە کۆدەکەت بنووسە...\n" : "# لێرە کۆدێ خۆ بنڤیسە...\n";
            
            document.getElementById('code-output').innerText = currentLang === 'so' ? 'ئامادەیە بۆ کارپێکردن...' : 'ئامادەیە بۆ کارپێکرنێ...';
            
            const challengeDesc = loc(lesson, 'challenge_desc');
            const panel = document.getElementById('compiler-challenge-panel');
            if (challengeDesc) {
                panel.classList.remove('hidden');
                document.getElementById('compiler-challenge-desc').innerHTML = challengeDesc;
            } else {
                panel.classList.add('hidden');
            }

            document.getElementById('compiler-modal').classList.remove('hidden'); 
            document.getElementById('compiler-modal').classList.add('flex');
        };

        window.loadExampleIntoCompiler = function() {
            const lesson = currentLessonArray[currentLessonIndex];
            if (lesson && lesson.code) {
                document.getElementById('user-code').value = lesson.code;
            }
        };

        window.closeTryItYourself = function() { 
            document.getElementById('compiler-modal').classList.add('hidden'); 
            document.getElementById('compiler-modal').classList.remove('flex'); 
        };
        
        window.goBackToHome = function() { 
            document.getElementById('learning-view').classList.add('hidden'); 
            document.getElementById('learning-view').classList.remove('flex'); 
            document.getElementById('home-view').classList.remove('hidden'); 
            currentActiveLanguage = null;
        };

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
            document.getElementById('quiz-counter').innerText = `${activeQuizIndex + 1} / ${activeQuizQuestions.length}`;
            document.getElementById('quiz-question-text').innerText = loc(q, 'question');
            
            const optionsContainer = document.getElementById('quiz-options');
            optionsContainer.innerHTML = '';
            const optionsArray = currentLang === 'ba' && q.options_ba ? q.options_ba : q.options_so || q.options;
            
            optionsArray.forEach((opt, idx) => {
                optionsContainer.innerHTML += `
                    <div onclick="selectQuizOption(${idx})" id="opt-${idx}" class="quiz-option cursor-pointer border-2 border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 rounded-2xl p-5 text-lg font-bold text-gray-700 dark:text-gray-300 hover:border-blue-300 transition-all flex items-center gap-4">
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center shrink-0 indicator-circle"></div>
                        ${opt}
                    </div>`;
            });
            
            const nextBtn = document.getElementById('btn-next-question');
            nextBtn.disabled = true; nextBtn.className = "bg-gray-200 dark:bg-gray-800 text-gray-500 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed";
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
            circle.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';

            const nextBtn = document.getElementById('btn-next-question');
            nextBtn.disabled = false; nextBtn.className = "bg-blue-600 hover:bg-blue-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg cursor-pointer transition-all";
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
            document.getElementById('quiz-score-text').innerText = currentLang === 'so' ? `تۆ وەڵامی ${activeQuizScore} پرسیارت بە دروستی دایەوە (${percent}%)` : `تە بەرسڤا ${activeQuizScore} پرسیاران ب دروستی دا (${percent}%)`;
            
            if(!completedLessons.includes(activeLessonIdToComplete)) {
                completedLessons.push(activeLessonIdToComplete);
                triggerConfetti();
                addXP(50);
                saveProgressToFirebase();
            }
        }

        window.finishQuizAndContinue = function() {
            document.getElementById('quiz-modal').classList.add('hidden'); document.getElementById('quiz-modal').classList.remove('flex');
            openLanguage(currentActiveLanguage.id, currentLessonIndex + 1 < currentLessonArray.length ? currentLessonIndex + 1 : currentLessonIndex);
        };

        // --- Admin Logic ---
        const tabs = ['lang', 'lesson', 'quiz', 'manage'];
        window.switchAdminTab = function(tabName) {
            tabs.forEach(x => {
                document.getElementById(`tab-btn-${x}`).className = "px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold";
                if(x === 'manage') document.getElementById(`tab-btn-${x}`).className = "px-6 py-2 bg-red-100 text-red-600 rounded-lg font-bold";
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            document.getElementById(`tab-btn-${tabName}`).className = `px-6 py-2 ${tabName === 'manage' ? 'bg-red-600' : 'bg-purple-600'} text-white rounded-lg font-bold`;
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
            
            // CLEAR FORMS AND HIDDEN IDs TO PREVENT OVERWRITING
            if (tabName === 'lang') { document.getElementById('form-lang').reset(); document.getElementById('edit_lang_id').value = ''; }
            if (tabName === 'lesson') { document.getElementById('form-lesson').reset(); document.getElementById('edit_lesson_id').value = ''; quillSo.root.innerHTML = ''; quillBa.root.innerHTML = ''; document.getElementById('lesson_order').value = '1'; }
            if (tabName === 'quiz') { document.getElementById('form-quiz').reset(); document.getElementById('edit_quiz_id').value = ''; }
        };

        function updateAdminSelects() {
            const lSelect = document.getElementById('lesson_lang_select'); lSelect.innerHTML = '<option value="">-- زمان --</option>';
            for (let id in languagesData) lSelect.innerHTML += `<option value="${id}">${languagesData[id].name_so || languagesData[id].name}</option>`;
            const qSelect = document.getElementById('quiz_lesson_select'); qSelect.innerHTML = '<option value="">-- وانە --</option>';
            
            // Sort lessons for the quiz dropdown as well
            let lessonsArr = Object.keys(lessonsData).map(lid => ({id: lid, ...lessonsData[lid]}));
            lessonsArr.sort((a, b) => {
                let orderA = parseInt(a.order) || 0;
                let orderB = parseInt(b.order) || 0;
                if (orderA !== orderB) return orderA - orderB;
                return a.id.localeCompare(b.id);
            });
            
            lessonsArr.forEach(item => {
                qSelect.innerHTML += `<option value="${item.id}">[${languagesData[item.langId]?.name_so || '?'}] ${item.title_so || item.title}</option>`;
            });
        }

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            const data = await res.json(); return data.data.url;
        }

        document.getElementById('form-lang').addEventListener('submit', async (e) => {
            e.preventDefault(); const editId = document.getElementById('edit_lang_id').value;
            let logoUrl = editId && languagesData[editId] ? languagesData[editId].logo_url : '';
            const file = document.getElementById('lang_logo_file').files[0]; if(file) logoUrl = await uploadImage(file);
            const data = { 
                name_so: document.getElementById('lang_name_so').value, 
                name_ba: document.getElementById('lang_name_ba').value, 
                desc_so: document.getElementById('lang_desc_so').value, 
                desc_ba: document.getElementById('lang_desc_ba').value, 
                ext: document.getElementById('lang_ext').value.replace('.',''),
                color: document.getElementById('lang_color').value, 
                logo_url: logoUrl 
            };
            if(editId) await update(dbRef(db, 'ferga_languages/' + editId), data); else await set(push(dbRef(db, 'ferga_languages')), data);
            e.target.reset(); switchAdminTab('manage');
        });

        document.getElementById('form-lesson').addEventListener('submit', async (e) => {
            e.preventDefault(); const editId = document.getElementById('edit_lesson_id').value;
            
            const contentSo = quillSo.root.innerHTML;
            const contentBa = quillBa.root.innerHTML;

            const data = { 
                langId: document.getElementById('lesson_lang_select').value, 
                order: document.getElementById('lesson_order').value,
                level_so: document.getElementById('lesson_level_so').value, 
                level_ba: document.getElementById('lesson_level_ba').value, 
                title_so: document.getElementById('lesson_title_so').value, 
                title_ba: document.getElementById('lesson_title_ba').value, 
                content_so: contentSo, 
                content_ba: contentBa, 
                challenge_desc_so: document.getElementById('lesson_challenge_so').value,
                challenge_desc_ba: document.getElementById('lesson_challenge_ba').value,
                expected_output: document.getElementById('lesson_expected_output').value,
                example_output: document.getElementById('lesson_example_output').value,
                code: document.getElementById('lesson_code').value 
            };
            if(editId) await update(dbRef(db, 'ferga_lessons/' + editId), data); else await set(push(dbRef(db, 'ferga_lessons')), data);
            e.target.reset(); quillSo.root.innerHTML = ''; quillBa.root.innerHTML = ''; switchAdminTab('manage');
        });

        document.getElementById('form-quiz').addEventListener('submit', async (e) => {
            e.preventDefault(); const editId = document.getElementById('edit_quiz_id').value;
            const data = { lessonId: document.getElementById('quiz_lesson_select').value, question_so: document.getElementById('quiz_question_so').value, question_ba: document.getElementById('quiz_question_ba').value, options_so: [document.getElementById('quiz_opt0_so').value, document.getElementById('quiz_opt1_so').value, document.getElementById('quiz_opt2_so').value, document.getElementById('quiz_opt3_so').value], options_ba: [document.getElementById('quiz_opt0_ba').value, document.getElementById('quiz_opt1_ba').value, document.getElementById('quiz_opt2_ba').value, document.getElementById('quiz_opt3_ba').value], correct: document.getElementById('quiz_correct').value };
            if(editId) await update(dbRef(db, 'ferga_quizzes/' + editId), data); else await set(push(dbRef(db, 'ferga_quizzes')), data);
            e.target.reset(); switchAdminTab('manage');
        });

        window.renderManageList = function() {
            const cat = document.getElementById('manage_category').value;
            const listObj = document.getElementById('manage-list'); listObj.innerHTML = '';
            
            let dataArr = [];
            let dataObj = cat === 'langs' ? languagesData : (cat === 'lessons' ? lessonsData : quizzesData);
            for(let id in dataObj) {
                dataArr.push({id: id, ...dataObj[id]});
            }
            
            // Sort to make managing easier
            if(cat === 'lessons') {
                dataArr.sort((a, b) => {
                    let orderA = parseInt(a.order) || 0;
                    let orderB = parseInt(b.order) || 0;
                    if (orderA !== orderB) return orderA - orderB;
                    return a.id.localeCompare(b.id);
                });
            }

            dataArr.forEach(item => {
                let title = '';
                if(cat === 'langs') title = item.name_so || item.name;
                if(cat === 'lessons') title = `[${languagesData[item.langId]?.name_so || '?'}] (${item.order || 0}) ${item.title_so || item.title}`;
                if(cat === 'quizzes') title = `[پرسیار] ${item.question_so || item.question}`;
                listObj.innerHTML += `<div class="flex justify-between p-4 bg-white dark:bg-gray-800 rounded mb-2 shadow-sm"><span>${title}</span><div class="flex gap-2"><button onclick="editItem('${cat}','${item.id}')" class="text-blue-500 font-bold">دەستکاری</button><button onclick="deleteItem('${cat}','${item.id}')" class="text-red-500 font-bold">سڕینەوە</button></div></div>`;
            });
        };

        window.deleteItem = async function(cat, id) { if(confirm('دڵنیایت لە سڕینەوە؟')) { await remove(dbRef(db, (cat === 'langs' ? 'ferga_languages' : (cat === 'lessons' ? 'ferga_lessons' : 'ferga_quizzes')) + '/' + id)); } };

        window.editItem = function(cat, id) {
            if(cat === 'langs') {
                const d = languagesData[id]; document.getElementById('edit_lang_id').value = id;
                ['lang_name_so','lang_name_ba','lang_desc_so','lang_desc_ba','lang_color','lang_ext'].forEach(k => { 
                    const elem = document.getElementById(k);
                    if(elem) elem.value = d[k.replace('lang_','')] || d[k.replace('lang_','').replace('_so','')] || ''; 
                });
                switchAdminTab('lang');
            } else if(cat === 'lessons') {
                const d = lessonsData[id]; document.getElementById('edit_lesson_id').value = id; document.getElementById('lesson_lang_select').value = d.langId || '';
                ['lesson_order','lesson_level_so','lesson_level_ba','lesson_title_so','lesson_title_ba','lesson_code','lesson_expected_output','lesson_example_output'].forEach(k => { 
                    const elem = document.getElementById(k);
                    if(elem) elem.value = d[k.replace('lesson_','')] || d[k.replace('lesson_','').replace('_so','')] || ''; 
                });
                document.getElementById('lesson_challenge_so').value = d.challenge_desc_so || d.challenge_so || '';
                document.getElementById('lesson_challenge_ba').value = d.challenge_desc_ba || d.challenge_ba || '';
                quillSo.root.innerHTML = d.content_so || d.content || '';
                quillBa.root.innerHTML = d.content_ba || d.content || '';
                switchAdminTab('lesson');
            } else if(cat === 'quizzes') {
                const d = quizzesData[id]; document.getElementById('edit_quiz_id').value = id; document.getElementById('quiz_lesson_select').value = d.lessonId || '';
                ['quiz_question_so','quiz_question_ba'].forEach(k => { document.getElementById(k).value = d[k.replace('quiz_','')] || d[k.replace('quiz_','').replace('_so','')] || ''; });
                for(let i=0; i<4; i++) { document.getElementById(`quiz_opt${i}_so`).value = (d.options_so || d.options || [])[i] || ''; document.getElementById(`quiz_opt${i}_ba`).value = (d.options_ba || d.options || [])[i] || ''; }
                document.getElementById('quiz_correct').value = d.correct || '0'; switchAdminTab('quiz');
            }
        };

        window.openEditLangModal = function(langId) {
            const d = languagesData[langId];
            if (!d) return;
            document.getElementById('edit_lang_id').value = langId;
            document.getElementById('lang_name_so').value = d.name_so || '';
            document.getElementById('lang_name_ba').value = d.name_ba || '';
            document.getElementById('lang_desc_so').value = d.desc_so || '';
            document.getElementById('lang_desc_ba').value = d.desc_ba || '';
            document.getElementById('lang_color').value = d.color || 'bg-blue-100';
            document.getElementById('lang_ext').value = d.ext || '';

            const modal = document.getElementById('editLangModal');
            const content = document.getElementById('editLangModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeEditLangModal = function() {
            const modal = document.getElementById('editLangModal');
            const content = document.getElementById('editLangModalContent');
            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        };

        document.getElementById('edit-lang-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit_lang_id').value;
            if (!id) return;
            const submitBtn = document.getElementById('edit-lang-submit-btn');
            submitBtn.innerText = "خەریکە پاشەکەوت دەکرێت...";
            submitBtn.classList.add('opacity-70', 'cursor-wait');
            try {
                const updates = {
                    name_so: document.getElementById('lang_name_so').value,
                    name_ba: document.getElementById('lang_name_ba').value,
                    desc_so: document.getElementById('lang_desc_so').value,
                    desc_ba: document.getElementById('lang_desc_ba').value,
                    color: document.getElementById('lang_color').value,
                    ext: document.getElementById('lang_ext').value,
                    logo_url: languagesData[id].logo_url || ''
                };
                await update(dbRef(db, 'ferga_languages/' + id), updates);
                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                window.closeEditLangModal();
                alert('زمانەکە بە سەرکەوتوویی پاشەکەوت کرا');
            } catch (error) {
                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                alert('هەڵەیەک ڕوویدا: ' + error.message);
            }
        });

        const origEditItem = window.editItem;
        window.editItem = function(cat, id) {
            if (cat === 'langs') { window.openEditLangModal(id); return; }
            origEditItem(cat, id);
        };

        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });
    </script>

    <!-- پەنجەرەی دەستکاری کردنی زمان (Modal) -->
    <div id="editLangModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeEditLangModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 overflow-y-auto max-h-[90vh]" id="editLangModalContent">
            <button onclick="window.closeEditLangModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center">دەستکاری کردنی زمان</h3>
                <form id="edit-lang-form" class="space-y-5">
                    <input type="hidden" id="edit_lang_id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوی زمان (سۆرانی)</label>
                            <input type="text" id="lang_name_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوی زمان (بادینی)</label>
                            <input type="text" id="lang_name_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتە (سۆرانی)</label>
                            <textarea id="lang_desc_so" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتە (بادینی)</label>
                            <textarea id="lang_desc_ba" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پاشگری زمان (بۆ نموونە: py, php, cpp)</label>
                            <input type="text" id="lang_ext" required dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ڕەنگی پاشبنەما</label>
                            <input type="text" id="lang_color" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">لۆگۆکە لە کاتی دەستکاری دا ناگۆڕدرێت</p>
                    <button type="submit" id="edit-lang-submit-btn" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>