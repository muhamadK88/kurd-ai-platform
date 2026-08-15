<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script>
        (function () {
            /* pyodide is ~10MB — lazy-load it only when the user actually runs Python */
            var pyPromise = null;
            window.loadPyodide = function () {
                if (pyPromise) return pyPromise;
                pyPromise = new Promise(function (resolve, reject) {
                    var s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js';
                    s.onload = function () {
                        try {
                            var factory = window.loadPyodide;
                            factory().then(resolve, reject);
                        } catch (e) { reject(e); }
                    };
                    s.onerror = function () { pyPromise = null; reject(new Error('pyodide failed to load')); };
                    document.head.appendChild(s);
                });
                return pyPromise;
            };
        })();
    </script>
    <!-- Quill rich text editor is lazy-loaded by initQuill() only when an admin edits content -->
    <!-- Favicon -->
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


    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        
        .glass-card { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .dark .glass-card { background: rgba(17, 24, 39, 0.7); border: 1px solid rgba(55, 65, 81, 0.5); }

        .quiz-option.selected { border-color: #3b82f6; background-color: #eff6ff; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1); }
        .dark .quiz-option.selected { border-color: #3b82f6; background-color: rgba(59, 130, 246, 0.2); }
        .quiz-option.option-correct { border-color: #22c55e !important; background-color: #f0fdf4 !important; box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.15); }
        .dark .quiz-option.option-correct { border-color: #22c55e !important; background-color: rgba(34, 197, 94, 0.22) !important; }
        .quiz-option.option-wrong { border-color: #ef4444 !important; background-color: #fef2f2 !important; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.15); }
        .dark .quiz-option.option-wrong { border-color: #ef4444 !important; background-color: rgba(239, 68, 68, 0.22) !important; }

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

        /* Glassmorphic linear progress bar — شریتێ پێشکەفتنێ */
        .kai-progress-track { position: relative; height: 0.55rem; border-radius: 9999px; overflow: hidden;
            background: rgba(15,23,42,0.08); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(15,23,42,0.08); box-shadow: inset 0 1px 2px rgba(0,0,0,0.12); }
        .dark .kai-progress-track { background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.12);
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.25); }
        .kai-progress-fill { position: absolute; inset-block: 0; inset-inline-start: 0; border-radius: 9999px;
            transition: width 0.9s cubic-bezier(0.22, 1, 0.36, 1); overflow: hidden; }
        /* moving light sheen sliding along the filled portion */
        .kai-progress-fill::after { content: ''; position: absolute; inset: 0;
            background: linear-gradient(100deg, transparent 20%, rgba(255,255,255,0.55) 50%, transparent 80%);
            background-size: 200% 100%; animation: progressShimmer 2.4s linear infinite; }
        /* soft top gloss so the fill reads like polished glass */
        .kai-progress-fill::before { content: ''; position: absolute; inset: 0 0 55% 0; border-radius: 9999px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.45), transparent); z-index: 1; }
        @keyframes progressShimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        /* coming-soon cards: a slow glass sweep instead of a fixed value */
        .kai-progress-indeterminate { animation: progressIndeterminate 2.8s ease-in-out infinite; }
        @keyframes progressIndeterminate { 0%, 100% { inset-inline-start: -38%; } 50% { inset-inline-start: 100%; } }

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

        /* --- Badge celebration (باج) --- */
        @keyframes badgeModalIn { 0% { transform: scale(0.7) translateY(50px); opacity: 0; } 100% { transform: scale(1) translateY(0); opacity: 1; } }
        @keyframes badgePopIn { 0% { transform: scale(0) rotate(-15deg); opacity: 0; } 60% { transform: scale(1.18) rotate(5deg); opacity: 1; } 80% { transform: scale(0.95) rotate(-2deg); } 100% { transform: scale(1) rotate(0deg); opacity: 1; } }
        @keyframes badgeRingPulse { 0% { transform: scale(1); opacity: 0.85; } 100% { transform: scale(1.7); opacity: 0; } }
        @keyframes badgeShine { 0% { left: -80%; } 100% { left: 140%; } }
        @keyframes badgeFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-14px); } }
        @keyframes badgeSparkle { 0%, 100% { opacity: 0; transform: scale(0.3) rotate(0deg); } 50% { opacity: 1; transform: scale(1.15) rotate(20deg); } }
        .badge-modal-box { animation: badgeModalIn 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; overflow: hidden; }
        .badge-disc { animation: badgePopIn 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both; position: relative; }
        .badge-ring { animation: badgeRingPulse 1.5s ease-out 0.7s 3; }
        .badge-ring-float { animation: badgeFloat 3.2s ease-in-out infinite; }
        .badge-shine { position: absolute; top: 0; bottom: 0; width: 45%; background: linear-gradient(115deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0) 100%); transform: skewX(-18deg); animation: badgeShine 1.6s ease-in-out 0.4s 3; }
        .badge-sparkle { position: absolute; font-size: 22px; animation: badgeSparkle 2.2s ease-in-out infinite; pointer-events: none; }

        /* --- AI topic cards (بەشەکانی ژیری دەستکرد) --- */
        @keyframes cardIn { 0% { opacity: 0; transform: translateY(28px) scale(0.96); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        .ai-topic-card { animation: cardIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both; }
        @keyframes aiShine { 0% { left: -80%; } 100% { left: 150%; } }
        .ai-shine { position: absolute; top: 0; bottom: 0; width: 45%; background: linear-gradient(115deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.55) 50%, rgba(255,255,255,0) 100%); transform: skewX(-18deg); animation: aiShine 1.8s ease-in-out 0.3s infinite; }
        .ai-pulse-ring { animation: badgeRingPulse 1.8s ease-out infinite; }

        /* --- Answer revealed → continue bar --- */
        @keyframes answerBarIn { 0% { opacity: 0; transform: translateY(30px) scale(0.96); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes answerCheckPop { 0% { transform: scale(0) rotate(-25deg); opacity: 0; } 60% { transform: scale(1.25) rotate(8deg); opacity: 1; } 80% { transform: scale(0.92) rotate(-3deg); } 100% { transform: scale(1) rotate(0deg); opacity: 1; } }
        @keyframes answerGlowPulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.55), 0 0 24px rgba(16,185,129,0.35); } 50% { box-shadow: 0 0 0 9px rgba(16,185,129,0), 0 0 42px rgba(16,185,129,0.55); } }
        @keyframes answerBorderFlow { 0% { background-position: 0% 50%; } 100% { background-position: 200% 50%; } }
        @keyframes answerArrowNudge { 0%, 100% { transform: translateX(0); } 50% { transform: translateX(5px); } }
        @keyframes answerBtnShine { 0% { left: -85%; } 100% { left: 155%; } }
        @keyframes answerConfetti { 0% { opacity: 0; transform: translateY(-12px) rotate(0deg) scale(1); } 12% { opacity: 1; } 100% { opacity: 0; transform: translateY(110px) rotate(340deg) scale(0.7); } }
        #answer-continue-bar { animation: answerBarIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both; }
        #answer-continue-bar .continue-border { background: linear-gradient(110deg, #10b981, #06b6d4, #8b5cf6, #f59e0b, #10b981); background-size: 300% 300%; animation: answerBorderFlow 6s linear infinite; }
        #answer-continue-bar .continue-badge { animation: answerCheckPop 0.65s cubic-bezier(0.34, 1.56, 0.64, 1) 0.25s both, answerGlowPulse 2.4s ease-in-out 0.9s infinite; }
        #answer-continue-bar .continue-arrow { animation: answerArrowNudge 1.3s ease-in-out infinite; }
        #answer-continue-bar .continue-btn-shine { position: absolute; top: 0; bottom: 0; width: 45%; background: linear-gradient(115deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0) 100%); transform: skewX(-18deg); animation: answerBtnShine 2.2s ease-in-out infinite; pointer-events: none; }
        #answer-continue-bar .continue-confetti { position: absolute; width: 8px; height: 12px; border-radius: 2px; animation: answerConfetti 1.9s ease-in forwards; pointer-events: none; }
        @media (prefers-reduced-motion: reduce) { #answer-continue-bar, #answer-continue-bar * { animation: none !important; transition: none !important; } }
    </style>

    @include('partials.kurdai-design')
    <link rel="stylesheet" href="/css/kai-ferga.css?v=7">
    <script src="/js/kai-ferga.js?v=4" defer></script>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    <canvas id="confetti-canvas" class="fixed inset-0 w-full h-full pointer-events-none z-[9999]" style="display:none;"></canvas>
    <div id="xp-notification-container"></div>

    @include('partials.nav', ['active' => 'ferga'])

    <!-- قۆناغی 1: هەڵبژاردنی زمان -->
    <div id="home-view" class="relative min-h-[85vh] py-16 px-4 overflow-hidden flex flex-col items-center justify-center">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob" style="animation-delay: 4s;"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center mb-16 w-full max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-6xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="فێرگەی پڕۆگرامسازی و ژیری دەستکرد" data-ba="فێرگەها پڕۆگرامسازیێ و ژیرییا دەستکرد">فێرگەی پرۆگرامسازی</h2>
            <p id="home-hero-subtitle" class="text-xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە." data-ba="وی زمانی هەڵبژێرە کو دڤێت ژێ دەستپێبکەی و پێنگاڤ ب پێنگاڤ فێرببە.">ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە.</p>
        </div>

        <!-- ناوەڕۆکی بەشەکان (Categories) -->
        <div id="category-nav" class="relative z-10 w-full max-w-6xl mx-auto mb-10 hidden">
            <button onclick="window.goToCategories()" class="glass-card text-gray-700 dark:text-gray-300 px-5 py-2.5 rounded-full shadow-lg font-bold flex items-center gap-2 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all hover:-translate-x-1 mb-7">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="lang-str" data-so="گەڕانەوە بۆ بەشەکان" data-ba="زڤڕین بۆ بەشان">گەڕانەوە بۆ بەشەکان</span>
            </button>
            <h2 id="category-title" class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white leading-tight"></h2>
            <p id="category-subtitle" class="mt-3 text-lg text-gray-600 dark:text-gray-300 font-medium"></p>
        </div>
        
        <div id="languages-grid" class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl mx-auto"></div>

        <!-- بەشی ئەدمین -->
        <div class="admin-only hidden relative z-10 mt-20 w-full max-w-5xl mx-auto glass-card p-8 rounded-3xl shadow-xl border-t-4 border-purple-600">
            <h3 class="text-2xl font-bold mb-6 border-b pb-4 dark:border-gray-700">دەستکاریکردنی فێرگە (ئەدمین)</h3>
            <div class="flex flex-wrap gap-2 mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <button id="tab-btn-lang" onclick="switchAdminTab('lang')" class="px-6 py-2 bg-purple-600 text-white rounded-lg font-bold">1. زمان</button>
                <button id="tab-btn-lesson" onclick="switchAdminTab('lesson')" class="px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold">2. وانە (دەستکاری ئاسان)</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-6 py-2 bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 rounded-lg font-bold border border-red-200 dark:border-red-800">3. بەڕێوەبردن</button>
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
                <div class="grid grid-cols-3 gap-4">
                    <div class="flex items-end pb-2"><label class="block font-bold mb-2 flex items-center gap-2"><input type="checkbox" id="lang_is_ai" class="w-5 h-5"> بەشی AI</label></div>
                    <div><label class="block font-bold mb-2">ئایکۆنی بەش (AI)</label><input type="text" id="lang_icon" placeholder="🤖" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
                    <div><label class="block font-bold mb-2">ڕیزبەندی بەش (AI)</label><input type="number" id="lang_ai_order" value="0" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700"></div>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="block font-bold mb-2">بەهای پۆینت (پاشماوە — ئێستا وانەکان بەخۆڕایی دەکرێنەوە)</label><input type="number" id="lesson_xp_cost" min="0" value="0" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-left"></div>
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
                <div><label class="block font-bold mb-2 mt-4">کۆدی CSS (style.css — تەنها بۆ HTML + CSS)</label><textarea id="lesson_code_css" rows="5" dir="ltr" class="w-full p-3 rounded-xl bg-[#1e1e1e] text-purple-400 font-mono text-left"></textarea></div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold mb-2 mt-4">ژمارەی هەوڵەکان (Attempts)</label>
                        <input type="number" id="lesson_max_attempts" min="1" max="20" value="5" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-left">
                    </div>
                    <div>
                        <label class="block font-bold mb-2 mt-4">نیشاندانی وەڵام</label>
                        <select id="lesson_allow_show_answer" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 text-left">
                            <option value="1">بەڵێ - ڕێگە بدە</option>
                            <option value="0">نەخێر - قەدەغە بکە</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block font-bold mb-2 mt-4 text-blue-600">ئەنجامی کۆدی نموونە (Example Output)</label>
                    <textarea id="lesson_example_output" rows="3" dir="ltr" placeholder="hello world" class="w-full p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-mono text-left"></textarea>
                </div>
                <button type="submit" id="btn-submit-lesson" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl font-bold mt-4">سەیڤکردنی وانە</button>
            </form>

            <div id="form-manage" class="admin-form hidden">
                <div class="mb-4">
                    <select id="manage_category" onchange="renderManageList()" class="w-full p-3 rounded-xl bg-gray-100 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 font-bold outline-none">
                        <option value="langs">زمانەکان</option><option value="lessons">وانەکان</option>
                    </select>
                </div>
                <div id="manage-list" class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar p-4 bg-gray-50 dark:bg-[#0a0f1c] rounded-2xl border border-gray-200"></div>

                <div class="mt-8 border-t-4 border-amber-500 bg-gradient-to-br from-amber-50/80 to-yellow-50/50 dark:from-amber-900/10 dark:to-yellow-900/5 rounded-2xl p-5">
                    <h4 class="text-xl font-black mb-4 flex items-center gap-2 text-amber-700 dark:text-amber-400">👑 بەڕێوەبردنی ئەندامان</h4>
                    <div class="flex gap-2 mb-4">
                        <input id="member_email_input" type="email" dir="ltr" placeholder="user@email.com" class="flex-1 p-3 rounded-xl bg-white dark:bg-gray-900 border border-amber-300/60 dark:border-amber-700/50 font-bold outline-none text-sm">
                        <button onclick="addMemberByEmail(true)" class="px-5 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white rounded-xl font-black text-sm shadow-lg shadow-emerald-500/20 transition-all whitespace-nowrap">+ مێمبەر</button>
                        <button onclick="addMemberByEmail(false)" class="px-5 py-3 bg-red-500 hover:bg-red-400 text-white rounded-xl font-black text-sm shadow-lg shadow-red-500/20 transition-all whitespace-nowrap">− سڕینەوە</button>
                    </div>
                    <p class="text-xs text-amber-600/80 dark:text-amber-400/70 font-bold mb-4">تێبینی: ئەو بەکارهێنەرە دەبێت یەک جار هاتووتبێتە ناو سایتەکە.</p>
                    <div id="members-list" class="space-y-2 max-h-72 overflow-y-auto custom-scrollbar"></div>
                </div>
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
        <aside class="w-full md:w-80 bg-slate-50 dark:bg-[#0f172a] border-l border-gray-200/50 dark:border-gray-800/50 overflow-y-auto custom-scrollbar h-[calc(100vh-76px)] shrink-0 shadow-[4px_0_24px_rgba(0,0,0,0.05)] z-20 flex flex-col">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center bg-slate-100/50 dark:bg-[#0a0f1c]">
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
                        <span class="text-[10px] text-gray-500 uppercase tracking-widest font-black lang-str" data-so="خاڵەکان" data-ba="خاڵ">خاڵەکان</span>
                        <span id="xp-counter" class="text-xl font-black text-blue-500">0</span>
                    </div>
                </div>
            </div>
            <div id="save-status" class="px-5 py-2.5 border-b border-gray-200 dark:border-gray-800 text-[11px] font-bold flex items-center gap-2 hidden"></div>
            <div class="p-6 flex-1 relative" id="sidebar-content"></div>
        </aside>

        <!-- ناوەڕۆکی سەرەکی (Main Learning Content) -->
        <main class="flex-1 overflow-y-auto custom-scrollbar h-[calc(100vh-76px)] bg-slate-50 dark:bg-[#0f172a]">
            <div class="max-w-4xl mx-auto w-full flex-1 flex flex-col pt-10 md:pt-0">
                <div id="data-load-error" class="hidden mb-6 bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm" role="alert"><div class="flex items-center gap-3"><svg class="w-5 h-5 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><span id="data-load-error-msg" class="text-sm font-medium">نەتوانرا وانەکان باربکرێن. تکایە هێڵی ئینتەرنێتەکەت بپشکنە.</span></div><button type="button" onclick="location.reload()" class="text-xs bg-red-500/20 hover:bg-red-500/30 text-red-300 font-semibold px-3 py-1.5 rounded-lg transition-colors">دووبارە هەوڵبدەوە</button></div>
                <h1 id="display-title" class="text-4xl md:text-5xl font-black mb-6 text-gray-900 dark:text-white leading-tight"></h1>
                
                <div class="admin-only hidden mb-4 flex justify-end">
                    <button onclick="window.openEditLessonModal(window.currentLessonId)" class="flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-xl font-bold text-sm transition border border-amber-200 dark:border-amber-800/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span class="lang-str" data-so="دەستکاری وانەکە" data-ba="دەستکاریا وانەیێ">دەستکاری وانەکە</span>
                    </button>
                </div>
                
                <div id="display-content" class="prose prose-lg dark:prose-invert prose-headings:font-black prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-strong:text-gray-900 dark:prose-strong:text-white prose-code:text-pink-600 dark:prose-code:text-pink-400 prose-pre:bg-gray-900 dark:prose-pre:bg-gray-950 prose-blockquote:border-l-4 prose-blockquote:border-purple-500 prose-blockquote:bg-purple-50 dark:prose-blockquote:bg-purple-900/20 prose-blockquote:pl-4 prose-blockquote:py-2 prose-blockquote:rounded-lg prose-img:rounded-2xl prose-img:shadow-lg text-gray-600 dark:text-gray-300 leading-relaxed mb-8 font-medium rendered-content"></div>
                
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
                            <button onclick="openCodeEditor(false)" class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-400 hover:to-amber-400 text-white rounded-lg font-bold text-[11px] shadow transition-all hover:scale-105 border border-orange-400/50 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="lang-str" data-so="دەستکاری و ڕەنکردن" data-ba="دەستکاری و ڕەنکردن">دەستکاری و ڕەنکردن</span>
                            </button>
                        </div>
                        <div class="p-5 overflow-x-auto" dir="ltr">
                            <div id="display-code" class="font-mono text-[15px] leading-relaxed space-y-1"></div>
                        </div>
                    </div>
                </div>

                <div id="display-css-code-box" class="hidden mb-6 relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-800 bg-[#1e1e1e]">
                        <div class="bg-[#2d2d2d] px-4 py-3 flex justify-between items-center border-b border-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                <span class="text-[10px] text-gray-500 mr-3 font-bold uppercase tracking-wider lang-str" data-so="نمونەی CSS" data-ba="نمونا CSS">نمونەی CSS</span>
                                <span class="text-xs font-mono text-gray-400">style.css</span>
                            </div>
                            <button onclick="openCodeEditor(true)" class="flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-400 hover:to-amber-400 text-white rounded-lg font-bold text-[11px] shadow transition-all hover:scale-105 border border-orange-400/50 shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="lang-str" data-so="دەستکاری و ڕەنکردن" data-ba="دەستکاری و ڕەنکردن">دەستکاری و ڕەنکردن</span>
                            </button>
                        </div>
                        <div class="p-5 overflow-x-auto" dir="ltr">
                            <div id="display-css-code" class="font-mono text-[15px] leading-relaxed space-y-1"></div>
                        </div>
                    </div>
                </div>

                <div id="display-web-preview-box" class="hidden mb-6">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-200 dark:border-gray-800 bg-slate-50 dark:bg-[#0f172a]">
                        <div class="bg-[#2d2d2d] px-4 py-3 flex items-center gap-2 border-b border-gray-800">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-[10px] text-gray-500 mr-3 font-bold uppercase tracking-wider lang-str" data-so="ئەنجام (بڕاوسەر)" data-ba="ئەنجام (بڕاوسەر)">ئەنجام (بڕاوسەر)</span>
                        </div>
                        <iframe id="display-web-preview" class="w-full h-[420px] bg-white" sandbox="allow-scripts allow-modals allow-forms"></iframe>
                    </div>
                </div>

                <div id="example-output-box" class="hidden mb-10">
                    <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-xl p-4 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="flex-1">
                            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider lang-str" data-so="ئەنجام" data-ba="ئەنجام">ئەنجام</span>
                            <pre id="display-example-output" dir="ltr" class="mt-1 text-emerald-700 dark:text-emerald-300 font-mono text-sm bg-slate-100 dark:bg-emerald-900/20 rounded-lg p-3 border border-emerald-100 dark:border-emerald-800/30"></pre>
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
                            <h3 class="text-lg font-black text-gray-800 dark:text-white lang-str" data-so="ئێستا تۆ تاقیبکەوە" data-ba="نوکە تو تاقی بکە">ئێستا تۆ تاقیبکەوە</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium lang-str" data-so="وەڵامی ئەم پرسیارە بدەوە" data-ba="بەرسڤا ڤی پرسیارێ بدە">وەڵامی ئەم پرسیارە بدەوە</p>
                        </div>
                    </div>
                    <p id="challenge-text" class="text-gray-700 dark:text-gray-200 font-bold leading-relaxed bg-slate-100/60 dark:bg-slate-800/40 rounded-xl p-4 border border-purple-200/50 dark:border-purple-800/50"></p>
                    <p id="challenge-attempts-note" class="mt-3 flex items-center gap-2 text-[12px] font-bold text-purple-600 dark:text-purple-300"></p>
                    <div class="mt-4 flex justify-end">
                        <button id="btn-challenge-open" onclick="openLessonQuestion()" class="flex items-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all text-sm">
                            <svg id="btn-challenge-open-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            <span id="btn-challenge-open-text" class="lang-str" data-so="کردنەوەی سەکۆی کۆدکردن" data-ba="ڤەکرنا سەکۆیێ کۆدکرنێ">کردنەوەی سەکۆی کۆدکردن</span>
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
                                <span class="text-[11px] text-gray-400 font-bold tracking-widest mb-1 block lang-str" data-so="ئەرکی تۆ لەم وانەیە:" data-ba="ئەرکێ تە د ڤێ وانەیێ دا:">ئەرکی تۆ لەم وانەیە:</span>
                                <p id="compiler-challenge-desc" class="text-sm text-gray-200 font-bold leading-relaxed"></p>
                                <p id="compiler-attempt-hint" class="mt-2 text-[12px] font-bold text-amber-400"></p>
                                <div id="correct-answer-box" class="mt-3 hidden">
                                    <div class="flex items-center gap-1.5 text-emerald-400 text-[11px] font-black tracking-widest mb-1">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.5L4 14.2 9 19.2l11-11-1.5-1.5L9 16.2z"/></svg>
                                        <span class="lang-str" data-so="وەڵامی ڕاست" data-ba="بەرسڤا ڕاست">وەڵامی ڕاست</span>
                                    </div>
                                    <pre id="correct-answer-code" class="bg-[#1e1e1e] border border-emerald-700/50 rounded-lg p-3 overflow-x-auto text-[12px] text-emerald-200 font-mono max-h-40 overflow-y-auto leading-relaxed"></pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Editor Toolbar with Modern Glow Buttons -->
                    <div class="bg-[#2d2d2d] px-4 py-2 flex justify-between items-center border-b border-[#1e1e1e]">
                        <span id="compiler-filename-label" class="text-xs font-mono text-gray-400 uppercase tracking-wider">main.py</span>
                        <div class="flex flex-wrap items-center gap-2">
                            <!-- Load Example Button -->
                            
                            
                            <!-- Show Answer Button -->
                            <button id="btn-show-answer" onclick="showCorrectAnswer()" class="hidden bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-400 hover:to-orange-400 text-white px-4 py-2 rounded-full font-bold text-xs shadow-[0_0_15px_rgba(245,158,11,0.2)] hover:shadow-[0_0_20px_rgba(245,158,11,0.4)] flex items-center gap-1.5 transition-all hover:scale-105 border border-amber-300/50">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span class="lang-str" data-so="بینینی وەڵام" data-ba="دیتنا بەرسڤێ">بینینی وەڵام</span>
                            </button>
                            
                            <!-- Run Button -->
                            <button onclick="runCode()" class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 text-white px-5 py-2 rounded-full font-bold text-xs shadow-[0_0_15px_rgba(59,130,246,0.3)] hover:shadow-[0_0_20px_rgba(59,130,246,0.5)] flex items-center gap-1.5 transition-all hover:scale-105 border border-blue-400/50">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                <span id="btn-run-text" class="lang-str" data-so="کارپێکردن" data-ba="کارپێکرن">کارپێکردن</span>
                            </button>
                            
                            <!-- Submit Button -->
                            <button id="btn-submit-challenge" onclick="verifyChallenge()" class="hidden bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-500 hover:to-pink-400 text-white px-5 py-2 rounded-full font-bold text-xs shadow-[0_0_15px_rgba(168,85,247,0.4)] hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] flex items-center gap-1.5 transition-all hover:scale-105 border border-purple-400/50">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span id="btn-submit-challenge-text" class="lang-str" data-so="پشکنینی مەشق" data-ba="پشکنینا مەشقێ">پشکنینی مەشق</span>
                            </button>
                        </div>
                    </div>
                    <!-- File Tabs (index.html / style.css) -->
                    <div id="compiler-file-tabs" class="hidden bg-[#252526] border-b border-[#1e1e1e] flex items-center px-2 pt-2 gap-1 shrink-0">
                        <button id="file-tab-html" onclick="switchCompilerFile('html')" class="px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-white bg-[#1e1e1e] border border-b-0 border-[#333]">index.html</button>
                        <button id="file-tab-css" onclick="switchCompilerFile('css')" class="px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-gray-400 hover:text-white bg-transparent border border-b-0 border-transparent">style.css</button>
                    </div>
                    <!-- Editor Textareas -->
                    <textarea id="user-code" class="flex-1 w-full bg-[#1e1e1e] text-[#d4d4d4] font-mono text-[16px] leading-relaxed p-6 focus:outline-none resize-none custom-scrollbar" dir="ltr" spellcheck="false"></textarea>
                    <textarea id="user-code-css" class="flex-1 w-full bg-[#1e1e1e] text-[#d4d4d4] font-mono text-[16px] leading-relaxed p-6 focus:outline-none resize-none custom-scrollbar hidden" dir="ltr" spellcheck="false"></textarea>
                </div>
                
                <!-- Terminal Pane -->
                <div class="w-full md:w-1/2 flex flex-col bg-[#000000]">
                    <div class="bg-[#2d2d2d] px-4 py-3 flex items-center gap-2 border-b border-[#1e1e1e]">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-xs font-mono text-gray-400 uppercase tracking-wider lang-str" data-so="دەرئەنجام (Output)" data-ba="دەرئەنجام (Output)">دەرئەنجام (Output)</span>
                    </div>
                    <pre id="code-output" class="flex-1 w-full text-green-400 font-mono text-[15px] leading-relaxed p-6 overflow-y-auto whitespace-pre-wrap text-left custom-scrollbar" dir="ltr"></pre>
                    <iframe id="code-preview" class="flex-1 w-full bg-slate-50 dark:bg-[#0f172a] hidden" sandbox="allow-scripts allow-modals allow-forms"></iframe>
                </div>
            </div>

            <!-- بەردەوامبوون بۆ وانەی داهاتوو — دوای بینینی وەڵام -->
            <div id="answer-continue-bar" class="hidden relative shrink-0 bg-[#0d0d0d]/95 overflow-hidden border-t border-emerald-500/20">
                <div class="continue-border absolute top-0 left-0 right-0 h-[3px] opacity-90"></div>
                <span class="continue-confetti" style="left:5%; top:-10px; background:#10b981; animation-delay:0s;"></span>
                <span class="continue-confetti" style="left:18%; top:-10px; background:#06b6d4; animation-delay:0.2s;"></span>
                <span class="continue-confetti" style="left:38%; top:-10px; background:#8b5cf6; animation-delay:0.4s;"></span>
                <span class="continue-confetti" style="left:62%; top:-10px; background:#f59e0b; animation-delay:0.6s;"></span>
                <span class="continue-confetti" style="left:81%; top:-10px; background:#ec4899; animation-delay:0.8s;"></span>
                <span class="continue-confetti" style="left:93%; top:-10px; background:#22d3ee; animation-delay:1s;"></span>
                <div class="relative flex flex-wrap items-center gap-3 md:gap-5 px-4 py-3 md:px-6 justify-center md:justify-between">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="continue-badge w-11 h-11 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-emerald-300 font-black text-sm md:text-base leading-tight lang-str" data-so="وەڵامی ڕاستت بینی" data-ba="! تە بەرسڤا راست دیت">وەڵامی ڕاستت بینی</p>
                            <p class="text-gray-400 text-[11px] md:text-xs font-medium mt-0.5 lang-str" data-so="کاتێک ئامادە بیت بڕۆ بۆ وانەی داهاتوو — وانەکەت تەواوە، بەڵام هیچ خاڵێک (XP) وەرناگریت" data-ba="دەمێ کە هەمادەبی بچە وانەیا داهاتی — وانە تەمامە، لێ چ خاڵان (XP) وەرناگری">کاتێک ئامادە بیت بڕۆ بۆ وانەی داهاتوو — وانەکەت تەواوە، بەڵام هیچ خاڵێک (XP) وەرناگریت</p>
                        </div>
                    </div>
                    <button id="btn-answer-continue" onclick="window.continueAfterAnswer()" class="relative overflow-hidden group flex items-center gap-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-white px-6 py-3 rounded-full font-black text-sm shadow-[0_0_20px_rgba(16,185,129,0.35)] hover:shadow-[0_0_32px_rgba(16,185,129,0.6)] hover:scale-105 active:scale-95 transition-all border border-emerald-300/40 shrink-0">
                        <span class="continue-btn-shine"></span>
                        <span class="lang-str" data-so="بڕۆ بۆ وانەی داهاتوو" data-ba="هەڕە بۆ وانەیا داهاتی">بڕۆ بۆ وانەی داهاتوو</span>
                        <svg class="w-4 h-4 continue-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- پەنجەرەی Quiz -->
    <div id="quiz-modal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-md z-[120] hidden flex overflow-y-auto">
        <div class="flex min-h-full w-full items-center justify-center p-4 sm:p-6">
            <div class="bg-slate-50 dark:bg-[#0f172a] rounded-[2rem] shadow-2xl w-full max-w-2xl p-8 relative overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="absolute top-0 right-0 w-full h-1.5 bg-gray-100 dark:bg-gray-800"><div id="quiz-progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 w-0 transition-all duration-500 rounded-r-full"></div></div>
            <div class="flex justify-between items-center mb-10 mt-2">
                <h2 class="text-2xl font-black text-gray-800 dark:text-white lang-str" data-so="تاقیکردنەوەی وانە" data-ba="تاقیکرنا وانەیا">تاقیکردنەوەی وانە</h2>
                <span id="quiz-counter" class="bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-bold px-4 py-1.5 rounded-full text-sm border border-blue-100 dark:border-blue-800/50"></span>
            </div>
            <div id="quiz-notice" class="hidden mb-6 flex items-center gap-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700/50 rounded-xl px-4 py-3">
                <span class="text-amber-500 text-lg shrink-0">⚠️</span>
                <p class="text-sm font-bold text-amber-700 dark:text-amber-300 lang-str" data-so="دەبێت پرسیارەکە جواب بدەیتەوە بۆ وانەی داهاتوو" data-ba="دڤێت بەرسڤا پرسیارێ بدەی بۆ وانەیا داهاتی">دەبێت پرسیارەکە جواب بدەیتەوە بۆ وانەی داهاتوو</p>
            </div>
            <div id="quiz-content">
                <h3 id="quiz-question-text" class="text-xl md:text-2xl font-bold mb-8 text-gray-800 dark:text-gray-100 leading-relaxed"></h3>
                <div id="quiz-code-block" class="hidden mb-6">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                        <span class="text-xs font-black text-orange-600 dark:text-orange-400 tracking-wider uppercase">کۆد</span>
                    </div>
                    <pre id="quiz-code-pre" class="bg-[#1e1e1e] border border-orange-700/50 rounded-xl p-4 overflow-x-auto text-[13px] text-orange-100 font-mono max-h-64 overflow-y-auto leading-relaxed" dir="ltr"></pre>
                </div>
                <div id="quiz-options" class="space-y-4"></div>
                <div id="quiz-feedback" class="hidden mt-6 rounded-xl px-4 py-3 text-lg font-black text-center"></div>
            </div>
            <div id="quiz-result" class="hidden text-center py-10">
                <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 text-green-500 rounded-full flex items-center justify-center mx-auto mb-8 text-5xl font-black shadow-inner">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 id="quiz-success-title" class="text-3xl font-black mb-4 text-gray-800 dark:text-white lang-str" data-so="ئافەرین! تەواوت کرد" data-ba="ئافەرین! تە ب دوماهی ئینا">ئافەرین! تەواوت کرد</h3>
                <p id="quiz-score-text" class="text-xl text-gray-500 dark:text-gray-400 mb-10 font-medium"></p>
                <button id="btn-quiz-next" onclick="finishQuizAndContinue()" class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-4 rounded-2xl font-bold text-lg shadow-lg w-full transition-all hover:-translate-y-1 lang-str" data-so="بڕۆ بۆ وانەی داهاتوو" data-ba="هەڕە بۆ وانەیا داهاتی">بڕۆ بۆ وانەی داهاتوو</button>
            </div>
            <div id="quiz-footer" class="mt-10 flex justify-end">
                <button id="btn-next-question" onclick="nextQuestion()" class="bg-gray-200 dark:bg-gray-800 text-gray-500 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed transition-all" disabled>دواتر</button>
            </div>
        </div>
        </div>
    </div>

    <!-- پەنجەرەی پیرۆزبایی و باجی زمان -->
    <div id="badge-modal" class="fixed inset-0 z-[140] hidden items-center justify-center p-4 bg-black/80 backdrop-blur-md">
        <div class="badge-modal-box relative bg-slate-50 dark:bg-[#0f172a] rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 text-center border border-white/20">
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-400"></div>
            <div id="badge-glow" class="absolute inset-0 pointer-events-none" style="background: radial-gradient(circle at 50% 18%, var(--badge-glow, rgba(251,191,36,0.35)), transparent 62%);"></div>
            <span class="badge-sparkle" style="top:16%; left:15%;">✨</span>
            <span class="badge-sparkle" style="top:11%; right:19%; animation-delay:0.6s;">🌟</span>
            <span class="badge-sparkle" style="top:72%; left:10%; animation-delay:1.1s;">✨</span>
            <span class="badge-sparkle" style="bottom:13%; right:13%; animation-delay:1.5s;">⭐</span>
            <p id="badge-kicker" class="relative text-xs font-black tracking-widest text-amber-500 dark:text-amber-400 uppercase mb-2"></p>
            <div class="badge-ring-float relative mx-auto my-7 w-40 h-40">
                <div class="badge-ring absolute inset-0 rounded-full" style="border:3px dashed rgba(251,191,36,0.6);"></div>
                <div class="absolute -inset-3 rounded-full" style="border:2px solid rgba(251,191,36,0.25);"></div>
                <div class="badge-disc w-full h-full rounded-full bg-gradient-to-br from-amber-400 via-yellow-500 to-amber-600 shadow-2xl flex items-center justify-center ring-4 ring-amber-200/50 dark:ring-amber-900/40 overflow-hidden">
                    <div class="badge-shine"></div>
                    <span id="badge-icon" class="text-8xl drop-shadow-lg">🏆</span>
                </div>
            </div>
            <h2 id="badge-title" class="relative text-3xl font-black text-gray-900 dark:text-white mb-3"></h2>
            <p id="badge-lang-chip" class="relative inline-block mb-4 px-5 py-1.5 rounded-full text-sm font-black border bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 border-amber-200 dark:border-amber-700/50"></p>
            <p id="badge-desc" class="relative text-gray-500 dark:text-gray-400 font-bold leading-relaxed mb-8"></p>
            <button onclick="closeBadgeModal()" class="relative w-full py-4 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white rounded-2xl font-black text-lg shadow-lg transition-all hover:-translate-y-1 lang-str" data-so="باشە، زۆر سوپاس!" data-ba="باشە، گەلەک سوپاس!">باشە، زۆر سوپاس!</button>
        </div>
    </div>

    <!-- پەنجەرەی ئەندامبوون -->
    <div id="member-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[130] hidden items-center justify-center p-4">
        <div class="relative bg-slate-50 dark:bg-[#0f172a] rounded-[2rem] shadow-2xl w-full max-w-md p-8 text-center overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-500"></div>
            <button onclick="closeMembershipModal()" class="absolute top-4 left-4 w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition text-xl font-black">×</button>
            <div class="relative mx-auto mt-4 mb-8 w-28 h-28">
                <div class="absolute inset-0 bg-amber-400/40 dark:bg-amber-500/30 rounded-full blur-2xl animate-pulse"></div>
                <div class="relative w-full h-full rounded-full bg-gradient-to-br from-amber-400 to-yellow-600 text-white flex items-center justify-center shadow-2xl ring-8 ring-amber-100 dark:ring-amber-900/40">
                    <svg class="w-12 h-12 drop-shadow" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V10a2 2 0 00-2-2zm-6 9a2 2 0 110-4 2 2 0 010 4zm3.5-9h-7V6a3.5 3.5 0 117 0v2z"/></svg>
                </div>
            </div>
            <h3 id="member-modal-title" class="text-3xl font-black mb-3 text-gray-900 dark:text-white lang-str" data-so="بە نزیکترین کات بەردەست دەبێت" data-ba="د نزیکترین دەمی دا بەردەست دبیت">بە نزیکترین کات بەردەست دەبێت</h3>
            <p id="member-modal-lang" class="inline-block mb-5 px-4 py-1.5 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 rounded-full text-sm font-black border border-amber-200 dark:border-amber-700/50"></p>
            <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-8 lang-str" data-so="ئەم زمانە لە ئێستادا لە جێگیربوونە. بە نزیکترین کات بەردەست دەبێت." data-ba="ئەڤ زمانە د ڤێ گاڤێ دا تێتە ئامادەکرن. د نزیکترین دەمی دا بەردەست دبیت.">ئەم زمانە لە ئێستادا لە جێگیربوونە. بە نزیکترین کات بەردەست دەبێت.</p>
            <button onclick="closeMembershipModal()" class="w-full py-4 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-2xl font-black hover:bg-gray-200 dark:hover:bg-gray-700 transition-all lang-str" data-so="باشە" data-ba="باشە">باشە</button>
        </div>
    </div>

    <!-- پەنجەرەی کردنەوەی بەشی ژیری دەستکرد بە پۆینت (هەر بەشێک جارێک) -->
    <div id="ai-unlock-modal" class="fixed inset-0 bg-black/80 backdrop-blur-md z-[135] hidden items-center justify-center p-4">
        <div class="badge-modal-box relative bg-slate-50 dark:bg-[#0f172a] rounded-[2.5rem] shadow-2xl w-full max-w-md p-10 text-center border border-white/20">
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-400 via-cyan-500 to-emerald-400"></div>
            <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(circle at 50% 16%, rgba(52,211,153,0.32), transparent 62%);"></div>
            <span class="badge-sparkle" style="top:16%; left:14%;">✨</span>
            <span class="badge-sparkle" style="top:11%; right:18%; animation-delay:0.6s;">💫</span>
            <span class="badge-sparkle" style="top:72%; left:10%; animation-delay:1.1s;">✨</span>
            <span class="badge-sparkle" style="bottom:14%; right:12%; animation-delay:1.5s;">⭐</span>
            <button onclick="closeAIUnlockModal()" class="absolute top-5 left-5 w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition text-xl font-black">×</button>
            <div class="badge-ring-float relative mx-auto mt-8 mb-8 w-32 h-32">
                <div class="badge-ring absolute inset-0 rounded-full" style="border:3px dashed rgba(16,185,129,0.6);"></div>
                <div class="ai-pulse-ring absolute -inset-3 rounded-full" style="border:2px solid rgba(16,185,129,0.35);"></div>
                <div class="badge-disc w-full h-full rounded-full bg-gradient-to-br from-emerald-400 via-teal-500 to-cyan-600 shadow-2xl flex items-center justify-center ring-4 ring-emerald-200/50 dark:ring-emerald-900/40 overflow-hidden">
                    <div class="badge-shine"></div>
                    <span class="text-6xl drop-shadow-lg">🔓</span>
                </div>
            </div>
            <h3 id="ai-unlock-title" class="relative text-3xl font-black mb-3 text-gray-900 dark:text-white"></h3>
            <p id="ai-unlock-desc" class="relative text-gray-500 dark:text-gray-400 font-bold leading-relaxed mb-5"></p>
            <p id="ai-unlock-cost" class="relative inline-block mb-8 px-5 py-2 rounded-full text-base font-black border bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700/50"></p>
            <div class="relative flex gap-3">
                <button onclick="closeAIUnlockModal()" class="flex-1 py-4 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-2xl font-black hover:bg-gray-200 dark:hover:bg-gray-700 transition-all lang-str" data-so="هەڵوەشاندنەوە" data-ba="بەتالکرن">هەڵوەشاندنەوە</button>
                <button id="ai-unlock-confirm-btn" onclick="confirmAIUnlock()" class="relative flex-1 py-4 bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white rounded-2xl font-black shadow-lg shadow-emerald-500/30 transition-all hover:-translate-y-1 overflow-hidden"></button>
            </div>
        </div>
    </div>

    <!-- Firebase & Core Logic -->
    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
    <script type="module">
        import { initializeApp, getApps, getApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue, get, query, orderByChild, equalTo } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
        const app = getApps().length ? getApp() : initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

        console.log('[ferga] v13 loaded');

        let currentLang = localStorage.getItem('site-lang') || 'so';
        window.isAdmin = false;
        window.isMember = false;
        let languagesData = {}; let lessonsData = {}; let quizzesData = {};
        let currentActiveLanguage = null; let currentLessonArray = []; let currentLessonIndex = 0;

        // --- Pyodide (Python in-browser) ---
        let pyodide = null;
        async function initPyodide() {
            if (!pyodide) { 
                pyodide = await loadPyodide();
                // Pre-load AI packages for the AI Learning section
                await pyodide.loadPackage(['numpy', 'pandas', 'scikit-learn']);
            }
        }
        let currentLangExt = 'py';
        
        let currentUid = null;
        let completedLessons = [];
        let userXP = 0;
        let dayStreak = 0;
        let lastActiveDate = "";
        let lessonProgress = {};
        // وانە خەڵاتدراوەکان — XP تەنها یەک جار بۆ هەر وانەیەک (بە دوبارەکردنەوە نادات)
        let xpAwardedLessons = {};
        let latestCompilerOutput = ""; 

        // --- بەشی ژیری دەستکرد: هەر بەشێک جارێک بە پۆینت دەکرێتەوە (بەشەکە لە خۆی) — وانەکانی ناو بەشەکە بەخۆڕایی و ڕیزبەندی کراوەن ---
        let aiUnlocked = {};
        let homeView = 'categories';
        let pendingAITopicId = null;

        // --- Badges (باجەکانی زمان) ---
        const LANGUAGE_BADGES = {
            py: { icon: '🐍', grad: 'from-blue-500 to-cyan-400', ring: 'rgba(56,189,248,0.45)', title_so: 'باجی پایتۆن', title_ba: 'باجا Python' },
            cpp: { icon: '⚡', grad: 'from-indigo-500 to-purple-600', ring: 'rgba(129,140,248,0.45)', title_so: 'باجی C++', title_ba: 'باجا C++' },
            js: { icon: '🟨', grad: 'from-yellow-400 to-amber-500', ring: 'rgba(251,191,36,0.45)', title_so: 'باجی جاڤاسکریپت', title_ba: 'باجا JavaScript' },
            php: { icon: '🐘', grad: 'from-indigo-400 to-violet-600', ring: 'rgba(167,139,250,0.45)', title_so: 'باجی PHP', title_ba: 'باجا PHP' },
            java: { icon: '☕', grad: 'from-red-500 to-rose-600', ring: 'rgba(248,113,113,0.45)', title_so: 'باجی جاڤا', title_ba: 'باجا Java' },
            rs: { icon: '🦀', grad: 'from-orange-500 to-red-600', ring: 'rgba(251,146,60,0.45)', title_so: 'باجی ڕەست', title_ba: 'باجا Rust' },
            cs: { icon: '💜', grad: 'from-purple-500 to-fuchsia-600', ring: 'rgba(232,121,249,0.45)', title_so: 'باجی سی شارپ', title_ba: 'باجا C#' },
            'html+css': { icon: '🎨', grad: 'from-orange-400 to-pink-500', ring: 'rgba(251,113,133,0.45)', title_so: 'باجی HTML + CSS', title_ba: 'باجا HTML + CSS' },
        };
        const FALLBACK_BADGE = { icon: '🏆', grad: 'from-blue-500 to-indigo-600', ring: 'rgba(96,165,250,0.45)', title_so: 'باجی زمان', title_ba: 'باجا زمان' };
        let badgesEarned = {};

        // --- بەشی فێربوونی ژیری دەستکرد (AI) — 10 کۆرسی ڕیزبەندی کراو (Linear Path) ---

        // هەر کۆرسێک وەک زمانێک لە فایەربەیس دەهێڵدرێت (is_ai: true) و ئەدمین دەتوانێت بیگۆڕێت
        const AI_TOPICS = [
            { id: 'ai_course_01', is_ai: true, ai_order: 1, unlock_cost: 0, icon: '🧠', color: 'bg-emerald-100', grad: 'from-emerald-500 to-teal-500',
              name_so: 'بنەماکان و فەلسەفەی ژیریی دەستکرد (دەستپێكی تیۆری)', name_ba: 'بنەماکان و فەلسەفەی ژیریی دەستکرد (دەستپێكی تیۆری)',
              desc_so: 'ژیری دەستکرد چییە، مێژووەکەی، جۆرەکانی و چۆنیەتی کارکردنی — یەکەم قۆناغ لە گەشەکردنەکەتدا.',
              desc_ba: 'ژیری دەستکرد چییە، مێژووەکەی، جۆرەکانی و چۆنیەتی کارکردنی — یەکەم قۆناغ لە گەشەکردنەکەتدا.',
              ext: 'py' },
            { id: 'ai_course_02', is_ai: true, ai_order: 2, unlock_cost: 0, icon: '📊', color: 'bg-teal-100', grad: 'from-teal-500 to-cyan-500',
              name_so: 'ئامرازەکانی شیکاری داتا (ئامادەکاری)', name_ba: 'ئامرازەکانی شیکاری داتا (ئامادەکاری)',
              desc_so: 'NumPy، Pandas، EDA و وێنەکێشان — داتا بناغەی هەموو مۆدێلەکانی AIە.',
              desc_ba: 'NumPy، Pandas، EDA و وێنەکێشان — داتا بناغەی هەموو مۆدێلەکانی AIە.',
              ext: 'py' },
            { id: 'ai_course_03', is_ai: true, ai_order: 3, unlock_cost: 0, icon: '📐', color: 'bg-cyan-100', grad: 'from-cyan-500 to-sky-500',
              name_so: 'ئامار و بیرکاری بۆ ژیریی دەستکرد', name_ba: 'ئامار و بیرکاری بۆ ژیریی دەستکرد',
              desc_so: 'ئاماری سەرەکی، بیرکاری جەبری، و ئەو پێوانانەی کە پێویستن بۆ فێربوونی ئامێر.',
              desc_ba: 'ئاماری سەرەکی، بیرکاری جەبری، و ئەو پێوانانەی کە پێویستن بۆ فێربوونی ئامێر.',
              ext: 'py' },
            { id: 'ai_course_04', is_ai: true, ai_order: 4, unlock_cost: 0, icon: '🔬', color: 'bg-indigo-100', grad: 'from-indigo-500 to-blue-600',
              name_so: 'زانستی داتا', name_ba: 'زانستی داتا',
              desc_so: 'شیکاری داتا، پیشاندانی داتا، و تێگەیشتن لە داتا بۆ مۆدێلەکانی AI.',
              desc_ba: 'شیکاری داتا، پیشاندانی داتا، و تێگەیشتن لە داتا بۆ مۆدێلەکانی AI.',
              ext: 'py' },
            { id: 'ai_course_05', is_ai: true, ai_order: 5, unlock_cost: 0, icon: '⚙️', color: 'bg-violet-100', grad: 'from-violet-500 to-purple-600',
              name_so: 'ئەلگۆریتمەکان و چارەسەرکردنی کێشە', name_ba: 'ئەلگۆریتمەکان و چارەسەرکردنی کێشە',
              desc_so: 'گەڕان، ڕیزکردن و ئاڵۆزی (Big O) — ئالگۆریتم پشووی هەموو AIەکە.',
              desc_ba: 'گەڕان، ڕیزکردن و ئاڵۆزی (Big O) — ئالگۆریتم پشووی هەموو AIەکە.',
              ext: 'py' },
            { id: 'ai_course_06', is_ai: true, ai_order: 6, unlock_cost: 0, icon: '🤖', color: 'bg-sky-100', grad: 'from-sky-500 to-blue-600',
              name_so: 'فێربوونی ئامێر (Machine Learning)', name_ba: 'فێربوونی ئامێر (Machine Learning)',
              desc_so: 'Supervised، Unsupervised، ڕیگرێشن و پێوانەکردنی مۆدێل — ئامێر لە داتا فێردەبێت.',
              desc_ba: 'Supervised، Unsupervised، ڕیگرێشن و پێوانەکردنی مۆدێل — ئامێر لە داتا فێردەبێت.',
              ext: 'py' },
            { id: 'ai_course_07', is_ai: true, ai_order: 7, unlock_cost: 0, icon: '🧠', color: 'bg-purple-100', grad: 'from-purple-500 to-fuchsia-600',
              name_so: 'تۆڕە دەمارییەکان (Neural Networks)', name_ba: 'تۆڕە دەمارییەکان (Neural Networks)',
              desc_so: 'پێرکێپترۆن، activation functions، و بناغەی تۆڕە دەمارییەکان.',
              desc_ba: 'پێرکێپترۆن، activation functions، و بناغەی تۆڕە دەمارییەکان.',
              ext: 'py' },
            { id: 'ai_course_08', is_ai: true, ai_order: 8, unlock_cost: 0, icon: '🔮', color: 'bg-fuchsia-100', grad: 'from-fuchsia-500 to-pink-600',
              name_so: 'فێربوونی قووڵ (Deep Learning)', name_ba: 'فێربوونی قووڵ (Deep Learning)',
              desc_so: 'تۆڕی دەمار، چینەکان، activation و فێربوون — بناغەی تەکنەلۆجیای ئەمڕۆ.',
              desc_ba: 'تۆڕی دەمار، چینەکان، activation و فێربوون — بناغەی تەکنەلۆجیای ئەمڕۆ.',
              ext: 'py' },
            { id: 'ai_course_09', is_ai: true, ai_order: 9, unlock_cost: 0, icon: '👁️', color: 'bg-rose-100', grad: 'from-rose-500 to-red-600',
              name_so: 'بینینی کۆمپیوتەر (Computer Vision)', name_ba: 'بینینی کۆمپیوتەر (Computer Vision)',
              desc_so: 'وێنە وەک ئارای ژمارە، فیلتەر، ناسینەوەی ڕووخسار و دۆزینەوەی شت.',
              desc_ba: 'وێنە وەک ئارای ژمارە، فیلتەر، ناسینەوەی ڕووخسار و دۆزینەوەی شت.',
              ext: 'py' },
            { id: 'ai_course_10', is_ai: true, ai_order: 10, unlock_cost: 0, icon: '💬', color: 'bg-amber-100', grad: 'from-amber-500 to-orange-600',
              name_so: 'پرۆسێسکردنی زمانی سروشتی (NLP)', name_ba: 'پرۆسێسکردنی زمانی سروشتی (NLP)',
              desc_so: 'Tokenization، پاککردنی دەق، هەست و وەرگێڕان — ئامێر لە زمان تێدەگات.',
              desc_ba: 'Tokenization، پاککردنی دەق، هەست و وەرگێڕان — ئامێر لە زمان تێدەگات.',
              ext: 'py' }
        ];

        // ٥ وانەی نمونە بۆ هەر کۆرسێک (کۆی گشتی ٥٠) — ئەدمین دەتوانێت تا ٣٠ وانە زیاد بکات
        const AI_SAMPLE_LESSONS = [
            // --- کۆرسی ١: بنەماکان و فەلسەفەی ژیریی دەستکرد ---
            { id: 'ai_course_01_01', langId: 'ai_course_01', order: 1, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'AI چییە؟ — بنەڕەتەکان', title_ba: 'AI چی یە؟ — بنەڕەت',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ژیری دەستکرد چییە؟</h3>
<p><b>ژیری دەستکرد (AI)</b> توانایەکە بۆ ئامێر کە کارێک وەک مرۆڤ ئەنجام دەدات: تێگەیشتن، بیرکردنەوە و بڕیاردان. لە جیاتی ڕێنمایی ڕاستەوخۆ، مۆدێلەکە لە داتا فێردەبێت.</p>
<p>سێ ئاست هەیە: <b>Narrow AI</b> (تایبەت بە کارێک، وەک ناسینەوەی ڕووخسار)، <b>General AI</b> (وەک مرۆڤ لە هەموو کارێکدا) و <b>Super AI</b> (لە مرۆڤ باشتر). ئێمە ئەمڕۆ لە ئاستی یەکەمداین.</p>
<p>لەم بەشەدا فێردەبین کە مۆدێل چۆن لە ژمارەکان و ڕێساکان دروست دەکرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">زیرەکیا دەستکرد چی یە؟</h3>
<p><b>زیرەکیا دەستکرد (AI)</b> جەهاتیبونەکە ژبۆ ئامرازێ کو کارەکێ وەک مرۆڤ دکەت: تێگهیشتن، بیرکرن و بریاردان. ل شوونا ڕێنماییا ڕاستەخۆ، مۆدێل ژ دانایان فێر دبیت.</p>
<p>سێ ئاست هەنە: <b>Narrow AI</b>، <b>General AI</b> و <b>Super AI</b>. ئەم ئەڤرۆ د ئاستا یەکێ د نینە.</p>`,
              code: `x = 5
y = 7
print(x + y)`,
              challenge_desc_so: 'دوو گۆڕاو دروست بکە بە ناوی a=3 و b=4 — ئینجا کۆی گشتییان چاپ بکە.',
              challenge_desc_ba: 'دوو گۆڕاڤان چێکە ب ناڤێ a=3 و b=4 — پشتی کۆما وان چاپ بکە.',
              expected_output: '7', example_output: '12' },
            { id: 'ai_course_01_02', langId: 'ai_course_01', order: 2, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'مێژووی AI — لە بیردۆزەوە بۆ ئەمڕۆ', title_ba: 'دیرۆکا AI — ژ بیردۆزێ ھەتا ئەڤرۆ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">AI لە کوێوە هاتووە؟</h3>
<p>بیرۆکەی ئامێری بیرکەرەوە دەگەڕێتەوە بۆ ساڵانی ١٩٥٠. لە ساڵی ١٩٥٦دا <b>John McCarthy</b> ناوی "ژیری دەستکرد" دانا. لەم چەند دەیەیەدا بەهۆی داتای زۆر و کۆمپیوتەری خێراتر، AI بە تەقینەوە گەشەی کرد.</p>
<p>ئەمڕۆ مۆدێلەکان لە وێنە، دەنگ و زمان تێدەگەن — بەڵام هەموویان پشت بە <b>ژمارە</b> دەبەستن. هەر بەرنامەیەکی کوردی بە پایتۆن دەست پێ دەکەین.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">AI ژ کو هات؟</h3>
<p>بیرۆکا ئامرازێ کو دفیكریت دگەریتەڤە بۆ سالێن 1950. د سالا 1956 دا <b>John McCarthy</b> ناڤێ "زیرەکیا دەستکرد" دانا. ژ بەر دانایان و کۆمپیوتەرێن زێدە لەزگین، AI گەلەک پێشڤە چوو.</p>`,
              code: `history = ["1950", "1956", "2020"]
print(len(history))`,
              challenge_desc_so: 'لیستەیەک دروست بکە بە سێ ساڵ: ["1950", "1960", "2024"] — ئینجا ژمارەی ئەندامەکان چاپ بکە.',
              challenge_desc_ba: 'لیستەکێ چێکە ب سێ سالان: ["1950", "1960", "2024"] — پشتی هەژمارا ئەندامان چاپ بکە.',
              expected_output: '3', example_output: '4' },
            { id: 'ai_course_01_03', langId: 'ai_course_01', order: 3, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'جۆرەکانی AI — Narrow, General, Super', title_ba: 'جۆرێن AI — Narrow, General, Super',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">سێ جۆرەکەی AI</h3>
<p><b>Narrow AI</b> تەنها لە کارێکی تایبەتدا شارەزایە: ئامۆژگاریی وەرگێڕان، سیستەمی پێشنیار و ناسینەوەی ڕووخسار. زۆربەی سیستەمەکانی ئەمڕۆ لەم جۆرەیان.</p>
<p><b>General AI</b> دەتوانێت هەر کارێکی فکری وەک مرۆڤ بکات (هێشتا نەگەیشتووە) و <b>Super AI</b> لە هەموو بوارێکدا لە مرۆڤ باشترە (بیردۆزە).</p>
<p>لە بەرنامەنووسیدا، جۆرەکە بە <b>مۆدێل</b> دەناسرێت — بۆ نموونە مۆدێلێک کە تەنها وێنە دەبینێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">سێ جۆرێن AI</h3>
<p><b>Narrow AI</b> تەنێ د کارەکێ تایبەت دا پسە: وەرگێران، سیستەما پێشنیارێ و ناسکرنا ڕووان. پیرانیا سیستەمان ژ ڤی جۆری نە.</p>
<p><b>General AI</b> دشێت هەر کارەکێ وەک مرۆڤ بکەت (هێشتا نەگهیشتیە) و <b>Super AI</b> د هەر وەری دا ژ مرۆڤ چێترە (بیردۆز).</p>`,
              code: `def narrow_ai(task):
    if task == "image":
        return "recognizes faces"
    return "unknown task"

print(narrow_ai("image"))`,
              challenge_desc_so: 'فەنکشنێک بنووسە بە ناوی check کە ئەگەر task == "text" بوو، "NLP" بگەڕێنێتەوە — ئینجا check("text") چاپ بکە.',
              challenge_desc_ba: 'فەنکشنەکێ بنڤیسە ب ناڤێ check کو هەکە task == "text" بیت، "NLP" ڤەگەڕینە — پشتی check("text") چاپ بکە.',
              expected_output: 'NLP', example_output: 'recognizes faces' },
            { id: 'ai_course_01_04', langId: 'ai_course_01', order: 4, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'داتا — بەنزینی AI', title_ba: 'داتا — بەنزینا AI',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">داتا چییە و بۆچی گرنگە؟</h3>
<p>هەموو مۆدێلەکانی AI بە <b>داتا</b> فێردەبن. داتا دەتوانێت ژمارە، دەق، وێنە یان دەنگ بێت. بە شێوەی <b>لیست</b>، <b>فەرهەنگ (dict)</b> و <b>ئارای (array)</b> هەڵدەگیرێت.</p>
<p>ئەگەر داتا خراپ بێت، مۆدێلەکەش خراپ دەبێت — "Garbage in, garbage out". لەم وانەیەدا فێردەبین داتا چۆن لە پایتۆندا هەڵدەگیرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">دانە چی یە و جیما گرینگە؟</h3>
<p>هەمی مۆدێلێن AI ب <b>دانایان</b> فێر دبن. دانە دشێت ژمارە، نڤیس، وێنە یان دەنگ بیت. ب شێوەی <b>لیستە</b>، <b>فەرهەنگ (dict)</b> و <b>array</b> دێتە هەلگرتن.</p>
<p>هەکە دانە خراب بن، مۆدێل ژی خراب دبیت — "Garbage in, garbage out".</p>`,
              code: `data = {
    "name": "Ava",
    "age": 22,
    "score": 95
}
print(data["age"])`,
              challenge_desc_so: 'فەرهەنگێک دروست بکە بە ناوی car و دوو نیشانە: "model" و "year". year = 2022 — ئینجا نرخی year چاپ بکە.',
              challenge_desc_ba: 'فەرهەنگەکێ چێکە ب ناڤێ car و دوو ستون: "model" و "year". year = 2022 — پشتی نێرخێ year چاپ بکە.',
              expected_output: '2022', example_output: '22' },
            { id: 'ai_course_01_05', langId: 'ai_course_01', order: 5, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'مۆدێl چۆن فێردەبێت؟ — بینینی گشتی', title_ba: 'مۆدێل چەوا فێر دبیت؟ — دیتنا گشتی',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئامێر چۆن فێردەبێت؟</h3>
<p>بە شێوەیەکی سادە: ئامێرەکە وەڵامێک دەدات، <b>هەڵەکە</b> دەپێوێت، ئینجا بە بەراوردی وەڵامەکە لەگەڵ وەڵامی ڕاست، خۆی <b>ڕاستدەکاتەوە</b>. ئەمە چەندین جار دووبارە دەکرێتەوە.</p>
<p>بۆ نموونە: مۆدێلێک کە نرخی ماڵ پێشبینی دەکات — بە نرخەکانی پێشوو فێردەبێت. لەم وانەیەدا ڕێسایەکی سادە دەنووسین.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ماکین چەوا فێر دبیت؟</h3>
<p>ب ڕیەکا سادە: ماکین بەرسڤەکێ ددەت، <b>شاشتیا</b> دیپێڤیت، پشتی ب بەراوردکرنا بەرسڤێ دگەل بەرسڤا ڕاست، خوە <b>ڕاست دکەت</b>. ئەڤە گەلەک جاران دێتە دووبارەکرن.</p>`,
              code: `def learn(expected, got):
    return abs(expected - got)

error = learn(100, 90)
print(error)`,
              challenge_desc_so: 'بە فەنکشنێک هەڵەکە هەژمار بکە: learn(50, 45) — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب فەنکشنەکێ شاشتیا حساب بکە: learn(50, 45) — پشتی ئەنجامێ چاپ بکە.',
              expected_output: '5', example_output: '10' },

            // --- کۆرسی ٢: ئامرازەکانی شیکاری داتا ---
            { id: 'ai_course_02_01', langId: 'ai_course_02', order: 1, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'ناساندنی NumPy — ئارایەکانی ژمارە', title_ba: 'ناساندنا NumPy — ئارایێن ژماران',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">NumPy چییە؟</h3>
<p><b>NumPy</b> کتێبخانەی سەرەکیی پایتۆنه بۆ کارکردن لەگەڵ داتای ژمارەیی. ئامرازی سەرەکییەکەی <b>ئارای (Array)</b>ە کە ڕێگەت دەدات بە خێرایی لەگەڵ ژمارە زۆرەکان کار بکەیت.</p>
<p>بە <code>np.array([...])</code> ئارایەک دروست دەکرێت. فەنکشنەکانی وەک <code>sum()</code>، <code>mean()</code>، <code>max()</code> و <code>min()</code> ڕێگەت دەدەن بەسەر داتاکەدا بپەڕیتەوە.</p>
<p>ئەم کتێبخانەیە بناغەی زۆربەی ئامرازەکانی داتا و ژیری دەستکردە.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">NumPy چی یە؟</h3>
<p><b>NumPy</b> کیتەبخانا سەرەکیا Python یە ژبۆ کارکرنا دگەل دانایێن ژمێرکی. ئامرازا وی یا سەرەکی <b>Array</b> یە.</p>
<p>ب <code>np.array([...])</code> arrayەک دێتە دامەزراندن. فەنکشنا وەک <code>sum()</code> و <code>mean()</code> ڕێ ددەنە تە کو دگەل دانایان بکاربێیت.</p>`,
              code: `import numpy as np
a = np.array([10, 20, 30])
print(a.sum())`,
              challenge_desc_so: 'بە NumPy ئارایەک دروست بکە بەم ژمارانە: 1, 2, 3 — ئینجا کۆی گشتییان چاپ بکە.',
              challenge_desc_ba: 'ب NumPy arrayەکێ دامەزرینە ب ڤان ژماران: 1, 2, 3 — پشتی کۆما وان چاپ بکە.',
              expected_output: '6', example_output: '60' },
            { id: 'ai_course_02_02', langId: 'ai_course_02', order: 2, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'ناساندنی Pandas — DataFrames', title_ba: 'ناساندنا Pandas — DataFrames',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Pandas چییە؟</h3>
<p><b>Pandas</b> ئامرازی سەرەکی داتا لە پایتۆندا. داتایەک بە شێوەی <b>DataFrame</b> هەڵدەگرێت — خشتەیەک وەک Excel بە ڕیز و ستوون.</p>
<p>بە <code>pd.DataFrame({...})</code> خشتەیەک دروست دەکرێت، بە <code>df.head()</code> سەرەتاکەی و بە <code>df.describe()</code> پوختەی ئاماری دەبینیت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Pandas چی یە؟</h3>
<p><b>Pandas</b> ئامرازا سەرەکیا دانایان د Python دایە. دانایان ب شێوەی <b>DataFrame</b> دگەرت — خشتەکێ وەک Excel ب ڕێز و ستونان.</p>
<p>ب <code>pd.DataFrame({...})</code> خشتەک دێتە دامەزراندن و ب <code>df.head()</code> سەرێ وی دێتە دیتن.</p>`,
              code: `import pandas as pd
df = pd.DataFrame({
    "naw": ["Soran", "Ava"],
    "score": [80, 90]
})
print(df["score"].sum())`,
              challenge_desc_so: 'بە Pandas خشتەیەک دروست بکە بە ستوونی "score" بە نرخەکانی 50 و 60 — ئینجا کۆی score چاپ بکە.',
              challenge_desc_ba: 'ب Pandas خشتەکێ چێکە ب ستونا "score" ب نێرخێن 50 و 60 — پشتی کۆما score چاپ بکە.',
              expected_output: '110', example_output: '170' },
            { id: 'ai_course_02_03', langId: 'ai_course_02', order: 3, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'پاککردنەوەی داتا — نرخە ونبووەکان', title_ba: 'پاقژکرنا داتایان — نێرخێن وندا',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">بەکوژکردنەوەی نرخە ونبووەکان</h3>
<p>زۆرجار لە داتا دا <b>None</b> یان نرخێکی ونبوو هەیە. بە <code>df.isnull().sum()</code> ژمارەی نرخە ونبووەکان لە هەر ستوونێکدا دەبینیت.</p>
<p>دوای دۆزینەوەیان، بە <code>df.dropna()</code> ڕیزەکان دەسڕدرێنەوە یان بە <code>df.fillna(0)</code> نرخێک لە شوێنیان دادەنرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چارەسەرکرنا نێرخێن وندا</h3>
<p>گەلەک جاران د دانایان دا <b>None</b> یان نێرخەکێ وندا هەیە. ب <code>df.isnull().sum()</code> هەژمارا نێرخێن وندا دێتە دیتن.</p>`,
              code: `import pandas as pd
df = pd.DataFrame({"x": [1, 2, None, 4]})
print(df.isnull().sum())`,
              challenge_desc_so: 'بە Pandas لیستەیەک دروست بکە: [1, None, 3] — ئینجا ژمارەی نرخە ونبووەکان چاپ بکە.',
              challenge_desc_ba: 'ب Pandas لیستەکێ چێکە: [1, None, 3] — پشتی هەژمارا نێرخێن وندا چاپ بکە.',
              expected_output: '1', example_output: '2' },
            { id: 'ai_course_02_04', langId: 'ai_course_02', order: 4, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'ئاماری سەرەکی — mean و median', title_ba: 'ئامارێن سەرەکی — mean û median',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پێوانەکانی ناوەند</h3>
<p><b>Mean (تێکڕا)</b> کۆی ژمارەکان دابەش بە ژمارەیان. <b>Median</b> نرخی ناوەڕاستە دوای ڕیزکردن. <b>Mode</b> ئەو نرخەیە کە زۆرترین جار دووبارە بووەتەوە.</p>
<p>بە کتێبخانەی <code>statistics</code> بە ئاسانی دەتوانیت ئەم پێوانانە هەژمار بکەیت. ئەمە بناغەی شیکردنەوەی داتایە.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پێڤانێن ناڤەندێ</h3>
<p><b>Mean</b> کۆما ژماران دابەش ب هەژمارا وان. <b>Median</b> نێرخێ ناڤێ پشتی ڕێزکرنێ. ب کیتەبخانا <code>statistics</code> ب ساناهی ئەڤە دێنە حسابکرن.</p>`,
              code: `import statistics
nums = [2, 4, 6]
print(statistics.mean(nums))`,
              challenge_desc_so: 'بە statistics تێکڕای [10, 20, 30] هەژمار بکە — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب statistics ناڤینجیا [10, 20, 30] حساب بکە — پشتی چاپ بکە.',
              expected_output: '20', example_output: '4' },
            { id: 'ai_course_02_05', langId: 'ai_course_02', order: 5, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'وێنەکێشانی داتا — Matplotlib', title_ba: 'وێنەکێشانا داتایان — Matplotlib',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چارت بۆ بینینی داتا</h3>
<p><b>Matplotlib</b> ئامرازی وێنەکێشانە لە پایتۆندا. بە <code>plt.plot(x, y)</code> هێڵێک و بە <code>plt.bar(...)</code> ستوون دروست دەکرێت.</p>
<p>چارت ڕێگەت دەدات داتاکەت بە چاو ببینیت — ئەمەش بناغەی شیکردنەوەی داتایە (EDA).</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">نەخشە ژبۆ دیتنا دانایان</h3>
<p><b>Matplotlib</b> ئامرازا وێنەکێشانا Python یە. ب <code>plt.plot(x, y)</code> خێزەک و ب <code>plt.bar(...)</code> ستون دێنە دامەزراندن.</p>`,
              code: `import matplotlib.pyplot as plt
x = [1, 2, 3]
y = [4, 5, 6]
plt.plot(x, y)
plt.title("Example")
print(len(x))`,
              challenge_desc_so: 'لیستی x بەم شێوەیە: [1, 2, 3, 4]. تەنها ژمارەی ئەندامەکانی x چاپ بکە بە len().',
              challenge_desc_ba: 'لیستا x ب ڤی شێوەی یە: [1, 2, 3, 4]. تەنێ هەژمارا ئەندامێن x چاپ بکە ب len().',
              expected_output: '4', example_output: '3' },

            // --- کۆرسی ٣: ئامار و بیرکاری بۆ ژیریی دەستکرد ---
            { id: 'ai_course_03_01', langId: 'ai_course_03', order: 1, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'ئالگۆریتم چییە؟', title_ba: 'ئالگۆریتم چی یە؟',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئالگۆریتم چییە؟</h3>
<p><b>ئالگۆریتم</b> ڕێنمایی هەنگاو بە هەنگاوە بۆ چارەسەری کێشەیەک. هەموو سیستەمەکانی ژیری دەستکرد پشتیان بە ئالگۆریتمە بەهێزەکانە.</p>
<p>نموونە: چارەسەری <b>کۆکردنەوە</b> ئالگۆریتمێکە. ئالگۆریتمەکە دەبێت <b>ڕوون</b>، <b>تەواو</b> و <b>کۆتایی</b> هەبێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئالگۆریتم چی یە؟</h3>
<p><b>ئالگۆریتم</b> ڕێبەریا گاڤ ب گاڤە ژبۆ چارەسەرکرنا ئاریشەکێ. هەمی سیستەمێن زیرەکیا دەستکرد دگەل ئالگۆریتان ڤە گرێدایی نە.</p>`,
              code: `def add(a, b):
    return a + b

print(add(15, 27))`,
              challenge_desc_so: 'فەنکشنێک بنووسە بە ناوی mul کە دوو ژمارە لێکدەدات — ئینجا mul(6, 7) چاپ بکە.',
              challenge_desc_ba: 'فەنکشنەکێ بنڤیسە ب ناڤێ mul کو دوو ژماران لێک دخەت — پشتی mul(6, 7) چاپ بکە.',
              expected_output: '42', example_output: '42' },
            { id: 'ai_course_03_02', langId: 'ai_course_03', order: 2, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'گەڕانی ڕیزبەندی — Linear Search', title_ba: 'گەڕانا ڕیزبەندی — Linear Search',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانی هێڵی</h3>
<p><b>Linear Search</b> سادەترین ڕێگای گەڕانە: لە سەرەتای لیستەکەوە دەست پێ دەکات و هەر ئەندامێک بەراورد دەکات بە نرخی داواکراو. ئەگەر دۆزرایەوە، <b>ژمارەی شوێنەکەی (index)</b> دەگەڕێنێتەوە.</p>
<p>بۆ لیستە گەورەکان ئەم ڕێگایە خاوە، بەڵام بناغەی تێگەیشتنی گەڕانە لە AI دا.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانا خێزیکی</h3>
<p><b>Linear Search</b> هەرە ساناهترین ڕێیا گەڕانێ یە: ژ سەرێ لیستێ دەست پێ دکەت و هەر ئەندامەکێ بەراورد دکەت دگەل نێرخێ داواکرێ.</p>`,
              code: `def linear_search(lst, target):
    for i in range(len(lst)):
        if lst[i] == target:
            return i
    return -1

print(linear_search([10, 20, 30, 40], 30))`,
              challenge_desc_so: 'بە گەڕانی هێڵی لە [5, 15, 25] بۆ 25 بگەڕێ — ئینجا ژمارەی شوێنەکەی چاپ بکە.',
              challenge_desc_ba: 'ب گەڕانا خێزیکی د [5, 15, 25] دا ل 25 بیگەڕە — پشتی ژمارا شوونێ چاپ بکە.',
              expected_output: '2', example_output: '2' },
            { id: 'ai_course_03_03', langId: 'ai_course_03', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'گەڕانی دوایین — Binary Search', title_ba: 'گەڕانا دواییان — Binary Search',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانی دوایین</h3>
<p><b>Binary Search</b> لە لیستێکی ڕێکخراو دا بە نیمچەبەشکردن لە هەر هەنگاوێکدا کار دەکات. ئەگەر نرخی ناوەڕاست بچووکتر بێت، نیوەی ڕاست و ئەگەر گەورەتر، نیوەی چەپ لەبەر دەچێت.</p>
<p>ئەم ئالگۆریتمە زۆر خێراترە — لە جیاتی پشکنینی هەموو ئەندامان، تەنها <b>log(n)</b> هەنگاو دەوێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانا دویایی</h3>
<p><b>Binary Search</b> د لیستەکێ ڕێزکرێ دا ب نیڤکرنێ د هەر گاڤێ دا دشخڤیت. ئەڤ ئالگۆریتم گەلەک لەزگینترە — تەنێ <b>log(n)</b> گاڤ دڤێت.</p>`,
              code: `def binary_search(a, target):
    lo, hi = 0, len(a) - 1
    while lo <= hi:
        mid = (lo + hi) // 2
        if a[mid] == target:
            return mid
        elif a[mid] < target:
            lo = mid + 1
        else:
            hi = mid - 1
    return -1

print(binary_search([1, 3, 5, 7, 9], 9))`,
              challenge_desc_so: 'بە Binary Search لە [2, 4, 6, 8] بۆ 4 بگەڕێ — ئینجا ژمارەی شوێنەکەی چاپ بکە.',
              challenge_desc_ba: 'ب Binary Search د [2, 4, 6, 8] دا ل 4 بیگەڕە — پشتی ژمارا شوونێ چاپ بکە.',
              expected_output: '1', example_output: '3' },
            { id: 'ai_course_03_04', langId: 'ai_course_03', order: 4, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'ڕیزکردن — Bubble Sort', title_ba: 'ڕێزکرن — Bubble Sort',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕیزکردنی بڵبڵ</h3>
<p><b>Bubble Sort</b> سادەترین ئالگۆریتمی ڕیزکردنە: دوانە دوانە بەراورد دەکات و ئەگەر ڕیزەکە هەڵە بوو، شوێنەکانیان دەگۆڕێت — هەتا لیستەکە ڕێک دەبێت.</p>
<p>لە هر گەشتنێکدا گەورەترین نرخ "بەسەرەوە" دەڕوات — وەک بڵبڵێک لە ئاودا. ئەمە ڕێگایەکی باشە بۆ تێگەیشتن لە ڕیزکردن.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕێزکرنا ب بلبلە</h3>
<p><b>Bubble Sort</b> هەرە ساناهترین ئالگۆریتما ڕێزکرنێ یە: دوجاران بەراورد دکەت و هەکە ڕێز شاشت بیت، شوونا وان دگوهۆڕیت — هەتا کو لیستە ڕێز دبیت.</p>`,
              code: `def bubble_sort(a):
    for i in range(len(a)):
        for j in range(len(a) - 1):
            if a[j] > a[j + 1]:
                a[j], a[j + 1] = a[j + 1], a[j]
    return a

print(bubble_sort([3, 1, 2]))`,
              challenge_desc_so: 'لیستەکە ڕیز بکە بە کۆدی خۆت: [5, 3, 4] — ئینجا بە sorted() چاپی بکە.',
              challenge_desc_ba: 'لیستێ ڕێز بکە ب کۆدا خوە: [5, 3, 4] — پشتی ب sorted() چاپ بکە.',
              expected_output: '[3, 4, 5]', example_output: '[1, 2, 3]' },
            { id: 'ai_course_03_05', langId: 'ai_course_03', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'ئاڵۆزی — ناساندنی Big O', title_ba: 'ئالۆزی — ناساندنا Big O',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Big O چییە؟</h3>
<p><b>Big O</b> پێوانەیەکە بۆ خێرایی ئالگۆریتم. <code>O(1)</code> هەمیشە یەک هەنگاوە، <code>O(n)</code> بەپێی ئەندامەکان دەگۆڕێت، و <code>O(n²)</code> بۆ لیستە گەورەکان زۆر خاوە.</p>
<p>ئەمە گرنگە چونکە مۆدێلەکانی AI لەسەر داتای گەورە کار دەکەن — دەبێت ئالگۆریتمەکە خێرا بێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Big O چی یە؟</h3>
<p><b>Big O</b> پێڤانەکە ژبۆ لەزا ئالگۆریتمێ. <code>O(1)</code> هەرتیم یەک گاڤ، <code>O(n)</code> ل گۆر ئەندامان دگوهۆڕیت.</p>`,
              code: `def operations(n):
    return 2 * n + 1

print(operations(10))`,
              challenge_desc_so: 'بە فەنکشنێک ژمارەی ئۆپەراسیۆنەکان هەژمار بکە: operations(5) کە دەگەڕێنێتەوە 2*n+1 — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب فەنکشنەکێ هەژمارا ئۆپراسیونان حساب بکە: operations(5) کو 2*n+1 ڤەدگەڕینیت — پشتی چاپ بکە.',
              expected_output: '11', example_output: '21' },

            // --- کۆرسی ٤: زانستی داتا ---
            { id: 'ai_course_04_01', langId: 'ai_course_04', order: 1, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'فێربوونی ئامێر چییە؟ — Supervised vs Unsupervised', title_ba: 'فێربوونا ماکین چی یە؟ — Supervised vs Unsupervised',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فێربوونی ئامێر چییە؟</h3>
<p><b>فێربوونی ئامێر (ML)</b> ئەوەیە کە کۆمپیوتەر لە داتاوە فێردەبێت لە جیاتی ئەوەی ڕێنمایی بە دەست بدرێت.</p>
<p><b>Supervised</b>: وەڵامی ڕاست هەیە و ئامێر فێردەبێت (پێشبینی نرخ). <b>Unsupervised</b>: ئامێرەکە بە خۆی شێواز دەدۆزێتەوە (جیاکردنەوەی کڕیارەکان).</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فێربوونا ماکین چی یە؟</h3>
<p><b>فێربوونا ماکین (ML)</b> ئەوە کو کۆمپیوتەر ژ دانایان فێر دبیت ل شوونا ڕێبەریا دەستی.</p>
<p><b>Supervised</b>: بەرسڤا ڕاست هەیە. <b>Unsupervised</b>: ماکین ب خوە شێوازان ددۆزیتەڤە.</p>`,
              code: `def predict(price, ratio):
    return price * ratio

new_price = predict(100, 1.1)
print(round(new_price))`,
              challenge_desc_so: 'بە فەنکشنێک پێشبینی بکە: predict(200, 0.5) — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب فەنکشنەکێ پێشبینییێ بکە: predict(200, 0.5) — پشتی ئەنجامێ چاپ بکە.',
              expected_output: '100', example_output: '110' },
            { id: 'ai_course_04_02', langId: 'ai_course_04', order: 2, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'ڕیگرێشنی هێڵی — Linear Regression', title_ba: 'ڕیگرێشنا خێزیکی — Linear Regression',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕیگرێشنی هێڵی</h3>
<p><b>Linear Regression</b> پێشبینی نرخێک دەکات بە هێڵێک: <code>y = w*x + b</code>. لێرە <b>w</b> کێشە (slope) و <b>b</b> قەتئینە (intercept).</p>
<p>مۆدێلەکە بۆ w و b واتایەک دەدۆزێتەوە کە هێڵەکە بە باشترین شێوە بەناو داتاکەدا تێپەڕێت — پاشان بۆ نرخە نوێکان پێشبینی دەکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕیگرێشنا خێزیکی</h3>
<p><b>Linear Regression</b> ب خێزەکێ نێرخەکێ پێشبینی دکەت: <code>y = w*x + b</code>. مۆدێل ژبۆ w و b نێرخەکێ چێترین ددۆزیتەڤە.</p>`,
              code: `w = 2
b = 3
x = 5
y = w * x + b
print(y)`,
              challenge_desc_so: 'بە w=3، b=1 و x=4 نرخی y هەژمار بکە بە فۆرمولەکە — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب w=3، b=1 و x=4 نێرخێ y حساب بکە ب فۆرمولێ — پشتی چاپ بکە.',
              expected_output: '13', example_output: '13' },
            { id: 'ai_course_04_03', langId: 'ai_course_04', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'پێوانەکردنی مۆدێل — Accuracy', title_ba: 'پێڤانەکرنا مۆدێل — Accuracy',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">دروستی مۆدێل چۆن دەپێورێت؟</h3>
<p><b>Accuracy</b> بریتییە لە ژمارەی پێشبینییە ڕاستەکان دابەش بە کۆی گشتی: <code>accuracy = correct / total</code>.</p>
<p>بۆ نموونە ئەگەر مۆدێلێک لە ٤ نموونەدا ٣ی ڕاست پێشبینی کردبێت، دروستیەکەی ٠.٧٥ە. هەرچی بەرزتر، باشتر.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕاستیا مۆدێل چەوا دێتە پێڤانکرن؟</h3>
<p><b>Accuracy</b> هەژمارا پێشبینیێن ڕاست دابەش ب گشتییێ یە: <code>accuracy = correct / total</code>.</p>`,
              code: `def accuracy(correct, total):
    return correct / total

print(accuracy(3, 4))`,
              challenge_desc_so: 'بە فەنکشنێک دروستی هەژمار بکە: accuracy(5, 10) — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب فەنکشنەکێ ڕاستیێ حساب بکە: accuracy(5, 10) — پشتی ئەنجامێ چاپ بکە.',
              expected_output: '0.5', example_output: '0.75' },
            { id: 'ai_course_04_04', langId: 'ai_course_04', order: 4, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'دابەشکردنی داتا — Train/Test', title_ba: 'دابەشکرنا داتایان — Train/Test',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">بۆچی داتا دابەش دەکرێت؟</h3>
<p>داتاکە دابەش دەکرێت بە دوو بەش: <b>Train</b> (فێربوون) و <b>Test</b> (تاقیکردنەوە). مۆدێلەکە لە بەشی یەکەم فێردەبێت و لە بەشی دووەم تاقی دەکرێتەوە.</p>
<p>ئەمە ڕێگری دەکات لە <b>overfitting</b> — ئەوەی مۆدێلەکە داتاکە بە دڵ بکات بەڵام لە داتای نوێ هەڵە بکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">جیما دانە دێتە دابەشکرن؟</h3>
<p>دانە ب دوو بەشان دێتە دابەشکرن: <b>Train</b> (فێربوون) و <b>Test</b> (ئەزموون). ئەڤ ڕێ ل بەر <b>overfitting</b> دگرت.</p>`,
              code: `data = [1, 2, 3, 4, 5, 6, 7, 8]
train = data[:6]
test = data[6:]
print(len(train))`,
              challenge_desc_so: 'لیستەکە دابەش بکە: train = data[:4] — ئینجا ژمارەی ئەندامەکانی train چاپ بکە.',
              challenge_desc_ba: 'لیستێ دابەش بکە: train = data[:4] — پشتی هەژمارا ئەندامێن train چاپ بکە.',
              expected_output: '4', example_output: '6' },
            // --- کۆرسی ٥: ئەلگۆریتمەکان و چارەسەرکردنی کێشە ---
            { id: 'ai_course_05_01', langId: 'ai_course_05', order: 1, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'ئالگۆریتم چییە؟', title_ba: 'ئالگۆریتم چی یە؟',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئالگۆریتم چییە؟</h3>
<p><b>ئالگۆریتم</b> ڕێنمایی هەنگاو بە هەنگاوە بۆ چارەسەری کێشەیەک. هەموو سیستەمەکانی ژیری دەستکرد پشتیان بە ئالگۆریتمە بەهێزەکانە.</p>
<p>نموونە: چارەسەری <b>کۆکردنەوە</b> ئالگۆریتمێکە. ئالگۆریتمەکە دەبێت <b>ڕوون</b>، <b>تەواو</b> و <b>کۆتایی</b> هەبێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئالگۆریتم چی یە؟</h3>
<p><b>ئالگۆریتم</b> ڕێبەریا گاڤ ب گاڤە ژبۆ چارەسەرکرنا ئاریشەکێ. هەمی سیستەمێن زیرەکیا دەستکرد دگەل ئالگۆریتان ڤە گرێدایی نە.</p>`,
              code: `def add(a, b):
    return a + b

print(add(15, 27))`,
              challenge_desc_so: 'فەنکشنێک بنووسە بە ناوی mul کە دوو ژمارە لێکدەدات — ئینجا mul(6, 7) چاپ بکە.',
              challenge_desc_ba: 'فەنکشنەکێ بنڤیسە ب ناڤێ mul کو دوو ژماران لێک دخەت — پشتی mul(6, 7) چاپ بکە.',
              expected_output: '42', example_output: '42' },
            { id: 'ai_course_05_02', langId: 'ai_course_05', order: 2, xp_cost: 0, level_so: 'بنەڕەتەکان', level_ba: 'بنەڕەت',
              title_so: 'گەڕانی ڕیزبەندی — Linear Search', title_ba: 'گەڕانا ڕیزبەندی — Linear Search',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانی هێڵی</h3>
<p><b>Linear Search</b> سادەترین ڕێگای گەڕانە: لە سەرەتای لیستەکەوە دەست پێ دەکات و هەر ئەندامێک بەراورد دەکات بە نرخی داواکراو. ئەگەر دۆزرایەوە، <b>ژمارەی شوێنەکەی (index)</b> دەگەڕێنێتەوە.</p>
<p>بۆ لیستە گەورەکان ئەم ڕێگایە خاوە، بەڵام بناغەی تێگەیشتنی گەڕانە لە AI دا.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانا خێزیکی</h3>
<p><b>Linear Search</b> هەرە ساناهترین ڕێیا گەڕانێ یە: ژ سەرێ لیستێ دەست پێ دکەت و هەر ئەندامەکێ بەراورد دکەت دگەل نێرخێ داواکرێ.</p>`,
              code: `def linear_search(lst, target):
    for i in range(len(lst)):
        if lst[i] == target:
            return i
    return -1

print(linear_search([10, 20, 30, 40], 30))`,
              challenge_desc_so: 'بە گەڕانی هێڵی لە [5, 15, 25] بۆ 25 بگەڕێ — ئینجا ژمارەی شوێنەکەی چاپ بکە.',
              challenge_desc_ba: 'ب گەڕانا خێزیکی د [5, 15, 25] دا ل 25 بیگەڕە — پشتی ژمارا شوونێ چاپ بکە.',
              expected_output: '2', example_output: '2' },
            { id: 'ai_course_05_03', langId: 'ai_course_05', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'گەڕانی دوایین — Binary Search', title_ba: 'گەڕانا دواییان — Binary Search',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانی دوایین</h3>
<p><b>Binary Search</b> لە لیستێکی ڕێکخراو دا بە نیمچەبەشکردن لە هەر هەنگاوێکدا کار دەکات. ئەگەر نرخی ناوەڕاست بچووکتر بێت، نیوەی ڕاست و ئەگەر گەورەتر، نیوەی چەپ لەبەر دەچێت.</p>
<p>ئەم ئالگۆریتمە زۆر خێراترە — لە جیاتی پشکنینی هەموو ئەندامان، تەنها <b>log(n)</b> هەنگاو دەوێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">گەڕانا دویایی</h3>
<p><b>Binary Search</b> د لیستەکێ ڕێزکرێ دا ب نیڤکرنێ د هەر گاڤێ دا دشخڤیت. ئەمە ڕێگایەکی باشە بۆ تێگەیشتن لە ڕیزکردن.</p>`,
              code: `def binary_search(a, target):
    lo, hi = 0, len(a) - 1
    while lo <= hi:
        mid = (lo + hi) // 2
        if a[mid] == target:
            return mid
        elif a[mid] < target:
            lo = mid + 1
        else:
            hi = mid - 1
    return -1

print(binary_search([1, 3, 5, 7, 9], 9))`,
              challenge_desc_so: 'بە Binary Search لە [2, 4, 6, 8] بۆ 4 بگەڕێ — ئینجا ژمارەی شوێنەکەی چاپ بکە.',
              challenge_desc_ba: 'ب Binary Search د [2, 4, 6, 8] دا ل 4 بیگەڕە — پشتی ژمارا شوونێ چاپ بکە.',
              expected_output: '1', example_output: '3' },
            { id: 'ai_course_05_04', langId: 'ai_course_05', order: 4, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'ڕیزکردن — Bubble Sort', title_ba: 'ڕێزکرن — Bubble Sort',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕیزکردنی بڵبڵ</h3>
<p><b>Bubble Sort</b> سادەترین ئالگۆریتمی ڕیزکردنە: دوانە دوانە بەراورد دەکات و ئەگەر ڕیزەکە هەڵە بوو، شوێنەکانیان دەگۆڕێت — هەتا لیستەکە ڕێک دەبێت.</p>
<p>لە هر گەشتنێکدا گەورەترین نرخ "بەسەرەوە" دەڕوات — وەک بڵبڵێک لە ئاودا. ئەمە ڕێگایەکی باشە بۆ تێگەیشتن لە ڕیزکردن.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ڕێزکرنا ب بلبلە</h3>
<p><b>Bubble Sort</b> هەرە ساناهترین ئالگۆریتما ڕێزکرنێ یە: دوجاران بەراورد دکەت و هەکە ڕێز شاشت بیت، شوونا وان دگوهۆڕیت — هەتا کو لیستە ڕێز دبیت.</p>`,
              code: `def bubble_sort(a):
    for i in range(len(a)):
        for j in range(len(a) - 1):
            if a[j] > a[j + 1]:
                a[j], a[j + 1] = a[j + 1], a[j]
    return a

print(bubble_sort([3, 1, 2]))`,
              challenge_desc_so: 'لیستەکە ڕیز بکە بە کۆدی خۆت: [5, 3, 4] — ئینجا بە sorted() چاپی بکە.',
              challenge_desc_ba: 'لیستێ ڕێز بکە ب کۆدا خوە: [5, 3, 4] — پشتی ب sorted() چاپ بکە.',
              expected_output: '[3, 4, 5]', example_output: '[1, 2, 3]' },
            { id: 'ai_course_05_05', langId: 'ai_course_05', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'ئاڵۆزی — ناساندنی Big O', title_ba: 'ئالۆزی — ناساندنا Big O',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Big O چییە؟</h3>
<p><b>Big O</b> پێوانەیەکە بۆ خێرایی ئالگۆریتم. <code>O(1)</code> هەمیشە یەک هەنگاوە، <code>O(n)</code> بەپێی ئەندامەکان دەگۆڕێت، و <code>O(n²)</code> بۆ لیستە گەورەکان زۆر خاوە.</p>
<p>ئەمە گرنگە چونکە مۆدێلەکانی AI لەسەر داتای گەورە کار دەکەن — دەبێت ئالگۆریتمەکە خێرا بێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Big O چی یە؟</h3>
<p><b>Big O</b> پێڤانەکە ژبۆ لەزا ئالگۆریتمێ. <code>O(1)</code> هەرتیم یەک گاڤ، <code>O(n)</code> ل گۆر ئەندامان دگوهۆڕیت.</p>`,
              code: `def operations(n):
    return 2 * n + 1

print(operations(10))`,
              challenge_desc_so: 'بە فەنکشنێک ژمارەی ئۆپەراسیۆنەکان هەژمار بکە: operations(5) کە دەگەڕێنێتەوە 2*n+1 — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب فەنکشنەکێ هەژمارا ئۆپراسیونان حساب بکە: operations(5) کو 2*n+1 ڤەدگەڕینیت — پشتی چاپ بکە.',
              expected_output: '11', example_output: '21' },

            // --- کۆرسی ٦: فێربوونی ئامێر (Machine Learning) ---
            { id: 'ai_course_06_01', langId: 'ai_course_06', order: 1, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'تۆڕی دەمار — چەمکی بنەڕەتی', title_ba: 'تۆڕا دەماران — چەمکێ بنەڕەت',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕی دەمار چییە؟</h3>
<p><b>تۆڕی دەمار (Neural Network)</b> نەخشەکێشانە لە مێشکی مرۆڤ. پێکهاتووە لە چینی <b>نووسین (Input)</b>، چینی <b>شاراوە (Hidden)</b> و چینی <b>دەرچوون (Output)</b>.</p>
<p>لە هەر دەمارێکدا کۆی کێشەکان هەژمار دەکرێت و دەردەچوونەکە دەردەکرێت. ئەم کارە بە <b>هەژماری دەمار (Neuron)</b> دەناسرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕا دەماران چی یە؟</h3>
<p><b>تۆڕا دەماران</b> نەخشە یە ژ مێژیێ مرۆڤ. ژ چینا <b>Input</b>، <b>Hidden</b> و <b>Output</b> پێکهاتیە.</p>`,
              code: `import numpy as np
x = np.array([1.0, 0.5])
w = np.array([0.4, 0.6])
b = 0.1
out = np.dot(x, w) + b
print(round(out, 2))`,
              challenge_desc_so: 'بە numpy هەژمارەکە بکە: np.dot([1, 2], [3, 4]) — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب numpy حساب بکە: np.dot([1, 2], [3, 4]) — پشتی ئەنجاما چاپ بکە.',
              expected_output: '11', example_output: '0.8' },
            { id: 'ai_course_06_02', langId: 'ai_course_06', order: 2, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'دەمار و activation — Sigmoid', title_ba: 'دەمار و activation — Sigmoid',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فەنکشنی چالاککردن</h3>
<p>دوای کۆکردنەوەی کێشەکان، دەمارەکە بە فەنکشنێکی <b>activation</b> بڕیار دەدات. <b>Sigmoid</b> ئەنجامەکە دەگۆڕێت بە ژمارەیەک لە نێوان ٠ و ١.</p>
<p>ئەمە بۆ پۆلێنکردن بەکاردەهێنرێت: نزیک لە ١ واتە "بەڵێ" و نزیک لە ٠ واتە "نەخێر".</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فەنکشنا چالاککرنێ</h3>
<p>دوای کۆکردنەوەی کێشەکان، دەمارەکە بە فەنکشنێکی <b>activation</b> بڕیار دەدات. <b>Sigmoid</b> ئەنجامەکە دەگۆڕێت بە ژمارەیەک لە نێوان ٠ و ١.</p>
<p>ئەمە بۆ پۆلێنکردن بەکاردەهێنرێت: نزیک لە ١ واتە "بەڵێ" و نزیک لە ٠ واتە "نەخێر".</p>`,
              code: `import math

def sigmoid(z):
    return 1 / (1 + math.exp(-z))

print(round(sigmoid(0), 2))`,
              challenge_desc_so: 'بە فەنکشنی sigmoid، sigmoid(0) هەژمار بکە — ئینجا بە round(..., 2) چاپی بکە.',
              challenge_desc_ba: 'ب فەنکشنا sigmoid، sigmoid(0) حساب بکە — پشتی ب round(..., 2) چاپ بکە.',
              expected_output: '0.5', example_output: '0.5' },
            { id: 'ai_course_06_03', langId: 'ai_course_06', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'چینەکان و کێشەکان', title_ba: 'چین و کێشان',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چینەکان چۆن کار دەکەن؟</h3>
<p>هەر چینێک <b>کێشەکان (weights)</b> و <b>bias</b>ی تایبەت بە خۆی هەیە. دەرچوونی چینێک دەبێتە نووسینی چینەکەی داهاتوو.</p>
<p>هەرچەن چین زۆرتر بێت، تۆڕەکە دەتوانێت شێوازە ئاڵۆزەکان فێربێت — ئەمەش بناغەی <b>فێربوونی قووڵ</b>ە.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چین چەوا کار دکەن؟</h3>
<p>هەر چینەک <b>کێش (weights)</b> و biasەک تایبەت هەیە. دەرکەتنا چینەکێ دبیتە تێکەتنا چینا دین.</p>`,
              code: `x = 1.0
w = 0.4
b = 0.1
out = w * x + b
print(round(out, 2))`,
              challenge_desc_so: 'بە w=0.5، x=2 و b=0.2 دەرچوونی دەمارەکە هەژمار بکە — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب w=0.5، x=2 و b=0.2 دەرکەتنا دەمارێ حساب بکە — پشتی چاپ بکە.',
              expected_output: '1.2', example_output: '0.5' },
            { id: 'ai_course_06_04', langId: 'ai_course_06', order: 4, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'فێربوون — چەمکی Backpropagation', title_ba: 'فێربوون — چەمکا Backpropagation',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕ چۆن فێردەبێت؟</h3>
<p><b>Backpropagation</b> ڕێگایەکە بۆ ڕاستکردنەوەی کێشەکان: هەڵەکە دەپێورێت و لە کۆتایییەوە بۆ سەرەتا بڵاودەبێتەوە، هەر کێشەیەک کەمێک ڕاستدەکرێتەوە.</p>
<p>ئەم ڕاستکردنەوانە بە <b>Gradient Descent</b> ئەنجام دەدرێن — نیشتنەوە لە ناو قەڵایی هەڵەکەدا.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕ چەوا فێر دبی؟</h3>
<p><b>Backpropagation</b> ڕێکەک ژبۆ ڕاستکرنا کێشان: خەلەتی دێتە پێڤان و ژ داوەیێ بەر ب سەرێ دا بەلاڤ دبی.</p>`,
              code: `w = 0.5
error = 0.2
lr = 0.1
w_new = w - lr * error
print(round(w_new, 2))`,
              challenge_desc_so: 'بە Gradient Descent کێشەکە نوێ بکە: w=1، error=0.2 و lr=0.1 — ئینجا w_new چاپ بکە.',
              challenge_desc_ba: 'ب Gradient Descent کێشێ نو بکە: w=1، error=0.2 و lr=0.1 — پشتی w_new چاپ بکە.',
              expected_output: '0.98', example_output: '0.48' },
            { id: 'ai_course_06_05', langId: 'ai_course_06', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'TensorFlow و PyTorch — چوارچێوەکان', title_ba: 'TensorFlow و PyTorch — چوارچیوەکان',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئامرازەکانی فێربوونی قووڵ</h3>
<p><b>TensorFlow</b> و <b>PyTorch</b> بەناوبانگترین چوارچێوەکانی فێربوونی قووڵن. بەوانە تۆڕی دەمار بە چەند ڕیزی کۆد دروست دەکرێت.</p>
<p>لەم وانەیەدا تەنها چەمکەکە فێردەبین — بەڵام هەموو ئەم چوارچێوەیانە لەسەر هەمان بنەمای ژمارەیی کە فێرمان، دروست دەبن.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">ئامرازێن فێربوونا کور</h3>
<p><b>TensorFlow</b> و <b>PyTorch</b> ناڤدارترین چوارچیوەیێن فێربوونا کور ین. ب وان تۆڕا دەماران ب چەند ڕێزێن کۆدێ دێتە چێکرن.</p>`,
              code: `def forward(x, w, b):
    return x * w + b

out = forward(2, 3, 1)
print(out)`,
              challenge_desc_so: 'بە forward، forward(3, 2, 1) هەژمار بکە — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب forward، forward(3, 2, 1) حساب بکە — پشتی ئەنجاما چاپ بکە.',
              expected_output: '7', example_output: '7' },

            // --- کۆرسی ٧: تۆڕە دەمارییەکان (Neural Networks) ---
            { id: 'ai_course_07_01', langId: 'ai_course_07', order: 1, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'پێرکێپترۆن — دەمارێکی تاک', title_ba: 'پێرکێپترۆن — دەمارەکێ تاک',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پێرکێپترۆن چییە؟</h3>
<p><b>پێرکێپترۆن</b> یەکەی بنەڕەتی تۆڕی دەمارییە: وەرگرتنی نووسین، کۆکردنەوەی کێشەکان، activation و دەرچوون.</p>
<p>پێرکێپترۆن دەتوانێت تەنها کێشە سادەکانی وەک AND و OR چارەسەر بکات — بەڵام XOR نا.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پێرکێپترۆن چی یە؟</h3>
<p><b>پێرکێپترۆن</b> یەکەتا بنەڕەتا تۆڕا دەماران یە: وەرگرتنا نووسین، کۆکرنا کێشان، activation و دەرکەتن.</p>`,
              code: `inputs = [1, 0]
weights = [0.5, 0.5]
bias = -0.2
sum_val = sum(i * w for i, w in zip(inputs, weights)) + bias
output = 1 if sum_val >= 0 else 0
print(output)`,
              challenge_desc_so: 'بە پێرکێپترۆن، inputs=[1,1]، weights=[0.5,0.5] و bias=-0.8 — دەرچوون چاپ بکە.',
              challenge_desc_ba: 'ب پێرکێپترۆن، inputs=[1,1]، weights=[0.5,0.5] و bias=-0.8 — دەرکەتنا چاپ بکە.',
              expected_output: '0', example_output: '1' },
            { id: 'ai_course_07_02', langId: 'ai_course_07', order: 2, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'Activation Functions — ReLU', title_ba: 'Activation Functions — ReLU',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فەنکشنی چالاککردن</h3>
<p><b>ReLU</b> (Rectified Linear Unit) سادەترین فەنکشنی activationە: ئەگەر نرخ گەورەتر بێت لە ٠، هەمان نرخ دەگەڕێنێتەوە، و ئەگەر بچووکتر بێت، ٠ دەگەڕێنێتەوە.</p>
<p>ReLU زۆر بەکاردەهێنرێت چونکە خێرایە و فێربوونەکە خێرا دەکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فەنکشنا چالاککرنێ</h3>
<p><b>ReLU</b> ساناهترین فەنکشنا activationە: هەکێ نرخ گەورەتر یە ژ ٠، ڤدگەڕینیتەڤە، و هەکێ بچووکتر یە، ٠ ڤدگەڕینیتەڤە.</p>`,
              code: `def relu(x):
    return max(0, x)

print(relu(-5))
print(relu(3))`,
              challenge_desc_so: 'بە فەنکشنی relu، relu(-2) و relu(4) چاپ بکە — تەنها دووەمی چاپ دەبێت.',
              challenge_desc_ba: 'ب فەنکشنا relu، relu(-2) و relu(4) چاپ بکە — تەنیا دووەمی چاپ دبیت.',
              expected_output: '4', example_output: '0' },
            { id: 'ai_course_07_03', langId: 'ai_course_07', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'تۆڕی فرە-چین — Multi-Layer', title_ba: 'تۆڕا فرە-چین — Multi-Layer',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕی فرە-چین چیییە؟</h3>
<p>کاتێک چەندین چین لە دەمارەکان پێکەوە دەبەسترێن، تۆڕی فرە-چین دروست دەبێت. چینی یەکەم نووسین وەردەگرێت و چینی کۆتایی دەرچوون دەدات.</p>
<p>هەر چین خۆی فێردەبێت تایبەتمەندییەکانی جیاواز — چینی یەکەم تایبەتمەندی سادە و چینی کۆتایی تایبەتمەندی ئاڵۆز.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">تۆڕا فرە-چین چی یە؟</h3>
<p>کاتێ چەندین چین ژ دەماران پێکەوە دبەسترن، تۆڕا فرە-چین ددێتە چێکرن.</p>`,
              code: `layers = [3, 5, 2]  # input, hidden, output
print(f"Input layer: {layers[0]} neurons")
print(f"Hidden layer: {layers[1]} neurons")
print(f"Output layer: {layers[2]} neurons")`,
              challenge_desc_so: 'تۆڕێک بە 3 چین: [4, 6, 2] — ژمارەی دەمارەکانی چینی ناوەڕاست چاپ بکە.',
              challenge_desc_ba: 'تۆڕەکێ ب 3 چین: [4, 6, 2] — هەژمارا دەمارانا چینا ناوەڕاست چاپ بکە.',
              expected_output: '6', example_output: '5' },
            { id: 'ai_course_07_04', langId: 'ai_course_07', order: 4, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'Forward Pass — پێشکەوتنی داتا', title_ba: 'Forward Pass — پێشکەفتنا داتایان',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Forward Pass چییە؟</h3>
<p><b>Forward Pass</b> ئەو پرۆسەسەیە کە داتا لە نووسینەوە بۆ دەرچوون دەڕوات. لە هەر چینێکدا، دەمارەکان کۆی کێشەکان و activation هەژمار دەکەن.</p>
<p>ئەمە "پێشبینی"ی تۆڕەکەیە — پێش فێربوون.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Forward Pass چی یە؟</h3>
<p><b>Forward Pass</b> ئەڤ پرۆسێسە یە کو داتا ژ نووسینێ بۆ دەرکەتن دڤەری.</p>`,
              code: `def forward_layer(x, w, b):
    return max(0, sum(i * wi for i, wi in zip(x, w)) + b)

x = [1, 2]
w = [0.5, 0.5]
b = -0.5
print(forward_layer(x, w, b))`,
              challenge_desc_so: 'بە forward_layer، x=[1,1]، w=[0.3,0.7] و b=0 — ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب forward_layer، x=[1,1]، w=[0.3,0.7] و b=0 — ئەنجاما چاپ بکە.',
              expected_output: '1', example_output: '0.5' },
            { id: 'ai_course_07_05', langId: 'ai_course_07', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'Loss Function — فەنکشنی هەڵە', title_ba: 'Loss Function — فەنکشنا هەڵەیێ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Loss Function چییە؟</h3>
<p><b>Loss Function</b> پێوانەیەکە بۆ هەڵە: جیاوازی نێوان پێشبینی تۆڕەکە و ڕاستی. هەرچی loss کەمتر بێت، تۆڕەکە باشترە.</p>
<p>Loss function ڕێنمایە بۆ فێربوون — تۆڕەکە هەوڵ دەدات loss کەم بکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Loss Function چی یە؟</h3>
<p><b>Loss Function</b> پێڤانەکە ژبۆ هەڵە: جیاوازی نین پێشبینینا تۆڕێ و ڕاستی.</p>`,
              code: `def mse_loss(pred, target):
    return (pred - target) ** 2

pred = 0.8
target = 1.0
print(round(mse_loss(pred, target), 3))`,
              challenge_desc_so: 'بە mse_loss، pred=0.5 و target=1.0 — loss چاپ بکە.',
              challenge_desc_ba: 'ب mse_loss، pred=0.5 و target=1.0 — loss چاپ بکە.',
              expected_output: '0.25', example_output: '0.04' },

            // --- کۆرسی ٨: فێربوونی قووڵ (Deep Learning) ---
            { id: 'ai_course_08_01', langId: 'ai_course_08', order: 1, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'CNN — تۆڕی کۆنڤۆلوشنال', title_ba: 'CNN — تۆڕا کۆنڤۆلوشنال',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">CNN چییە؟</h3>
<p><b>CNN (Convolutional Neural Network)</b> تۆڕی دەمارییە تایبەت بە وێنە. فیلتەرەکان بەسەر وێنەکەدا دەخزێن و تایبەتمەندییەکان دەدۆزنەوە.</p>
<p>CNN لە ناسینەوەی ڕووخسار، دۆزینەوەی شت و پزیشکی بەکاردەهێنرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">CNN چی یە؟</h3>
<p><b>CNN</b> تۆڕا دەماران یە تایبەت ب وێنە. فیلتەران ل سەر وێنێ دچین و تایبەتمەندییان دبینین.</p>`,
              code: `image = [
    [1, 2, 3],
    [4, 5, 6],
    [7, 8, 9]
]
print(len(image))`,
              challenge_desc_so: 'وێنەیەکی 3x3 — ژمارەی ڕیزەکان چاپ بکە.',
              challenge_desc_ba: 'وێنەکێ 3x3 — هەژمارا ڕێزان چاپ بکە.',
              expected_output: '3', example_output: '3' },
            { id: 'ai_course_08_02', langId: 'ai_course_08', order: 2, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'Pooling — کەمکردنی قەبارە', title_ba: 'Pooling — کەمکرنا قەبارەیێ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Pooling چییە؟</h3>
<p><b>Pooling</b> قەبارەی وێنەکە کەم دەکات بە هەڵگرتنی زانیاری گرنگ. <b>Max Pooling</b> گەورەترین نرخ لە هەر ناوچەیەک دەهێڵێتەوە.</p>
<p>ئەمە فێربوون خێراتر دەکات و لە overfitting ڕێگری دەکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Pooling چی یە؟</h3>
<p><b>Pooling</b> قەبارەیێ وێنێ کەم دکەت. <b>Max Pooling</b> مەزترین نرخ ژ هەر ناوچەکێ ڤدەهێڵیتەڤە.</p>`,
              code: `patch = [3, 7, 2, 9]
max_val = max(patch)
print(max_val)`,
              challenge_desc_so: 'بە max()، گەورەترین نرخ لە [5, 8, 3, 10] چاپ بکە.',
              challenge_desc_ba: 'ب max()، مەزترین نرخ ژ [5, 8, 3, 10] چاپ بکە.',
              expected_output: '10', example_output: '9' },
            { id: 'ai_course_08_03', langId: 'ai_course_08', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'RNN — تۆڕی دووبارەبوو', title_ba: 'RNN — تۆڕا دووبارەبوویێ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">RNN چییە؟</h3>
<p><b>RNN (Recurrent Neural Network)</b> تۆڕێکە کە داتای زنجیرەیی وەک دەق و دەنگ پەیدا دەکات. دەماری پێشوو دەدرێتە دەماری دواتر.</p>
<p>ئەمە بۆ زمان، دەنگ و ڤیدیۆ بەکاردەهێنرێت — بەڵام لە زنجیرە درێژەکان لاواز دەبێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">RNN چی یە؟</h3>
<p><b>RNN</b> تۆڕەکێ یە کو داتایا زنجیرەیی وەک نڤیس و دەنگ ڤدەدات.</p>`,
              code: `hidden = 0.5
input_val = 0.3
new_hidden = hidden + input_val
print(round(new_hidden, 2))`,
              challenge_desc_so: 'بە RNN سادە، hidden=0.4 و input=0.3 — hidden نوێ چاپ بکە.',
              challenge_desc_ba: 'ب RNN ساناه، hidden=0.4 و input=0.3 — hiddenا نو چاپ بکە.',
              expected_output: '0.7', example_output: '0.8' },
            { id: 'ai_course_08_04', langId: 'ai_course_08', order: 4, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'LSTM — یادگاری درێژخایەن', title_ba: 'LSTM — یادگاریا درێژخایەن',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LSTM چییە؟</h3>
<p><b>LSTM (Long Short-Term Memory)</b> جۆرێکی پێشکەوتووی RNNە کە دەتوانێت زانیاری بۆ ماوەیەکی درێژ یاد بێت — کێشەی RNN چارەسەر دەکات.</p>
<p>LSTM لە وەرگێڕان، پوختەکردن و دروستکردنی زمان بەکاردەهێنرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LSTM چی یە؟</h3>
<p><b>LSTM</b> جۆرەکێ پێشکەفتی RNNێ ی کو دشیتە زانیاری ب ماوەیێ درێژ یاد بیت.</p>`,
              code: `cell_state = [0.8, 0.6, 0.4]
forget_gate = 0.9
new_state = [c * forget_gate for c in cell_state]
print([round(x, 2) for x in new_state])`,
              challenge_desc_so: 'بە LSTM سادە، cell=[1, 0.5] و forget=0.8 — cell نوێ چاپ بکە.',
              challenge_desc_ba: 'ب LSTM ساناه، cell=[1, 0.5] و forget=0.8 — cellا نو چاپ بکە.',
              expected_output: '[0.8, 0.4]', example_output: '[0.72, 0.54, 0.36]' },
            { id: 'ai_course_08_05', langId: 'ai_course_08', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'Transfer Learning — فێربوونی گواستنەوە', title_ba: 'Transfer Learning — فێربوونا گواستنەوەیێ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Transfer Learning چییە؟</h3>
<p><b>Transfer Learning</b>: مۆدێلێک کە لە داتایەکی گەورە فێربووە بۆ ئەرکێکی تر بەکاردەهێنرێت. تەنها چەند چینێک ڕاڤە دەکرێن.</p>
<p>ئەمە کات و داتا خەرەنج دەکات — زۆربەی مۆدێلەکانی ئەمڕۆ بەم شێوەیە دروست دەبن.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Transfer Learning چی یە؟</h3>
<p><b>Transfer Learning</b>: مۆدێلەکێ کو ژ داتایەکێ گەورە هاتیە فێرکرن ژبۆ ئەرکێ دین ب دکارئینرێت.</p>`,
              code: `pretrained = [0.9, 0.8, 0.7]
fine_tuned = [w * 0.95 for w in pretrained]
print([round(x, 2) for x in fine_tuned])`,
              challenge_desc_so: 'بە transfer learning، weights=[1.0, 0.8] و factor=0.9 — weights نوێ چاپ بکە.',
              challenge_desc_ba: 'ب transfer learning، weights=[1.0, 0.8] و factor=0.9 — weightsا نو چاپ بکە.',
              expected_output: '[0.9, 0.72]', example_output: '[0.86, 0.76, 0.67]' },

            // --- کۆرسی ٩: بینینی کۆمپیوتەر (Computer Vision) ---
            { id: 'ai_course_09_01', langId: 'ai_course_09', order: 1, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'بینینی کۆمپیوتەر چییە؟', title_ba: 'دیتنا کۆمپیوتەر چی یە؟',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">بینینی کۆمپیوتەر</h3>
<p><b>Computer Vision (بینینی کۆمپیوتەر)</b>: مۆدێل لە وێنە و ڤیدیۆ تێدەگات — ناسینەوەی ڕووخسار، ڕووکەش و دۆزینەوەی شت.</p>
<p>ئەم بوارە لە پزیشکی (دۆزینەوەی نەخۆشی لە وێنە) و ئۆتۆمۆبیل (ئۆتۆمۆبیلی بێ شۆفێر) بەکاردەهێنرێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">دیتنا کۆمپیوتەرێ</h3>
<p><b>Computer Vision</b>: مۆدێل ژ وێنە و ڤیدیۆیان تێدگەهیت — ناسکرنا ڕوان و دیتنا تشتان.</p>`,
              code: `image = [
    [0, 0, 0],
    [0, 255, 0],
    [0, 0, 0]
]
print(len(image))`,
              challenge_desc_so: 'وێنەیەک بەم شێوەیە هەیە کە 3 ڕیزە. تەنها ژمارەی ڕیزەکان چاپ بکە بە len().',
              challenge_desc_ba: 'وێنە ب ڤی شەکلی هەیە کو 3 ڕێز ین. تەنیا هەژمارا ڕێزان چاپ بکە ب len().',
              expected_output: '3', example_output: '3' },
            { id: 'ai_course_09_02', langId: 'ai_course_09', order: 2, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'وێنە وەک ئارای ژمارە — پیکسڵ', title_ba: 'وێنە وەک ئارایێن ژماران — پیکسڵ',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پیکسڵ چییە؟</h3>
<p>وێنەیەکی ڕەش و سپی وەک خشتەیەک لە ژمارە دەردەکەوێت: ٠ بۆ ڕەش و ٢٥٥ بۆ سپی. لە وێنەی ڕەنگدا هەر پیکسڵ ٣ ژمارەیە (R, G, B).</p>
<p>مۆدێلەکە وێنەکە وەک ئەم خشتە ژمارانە دەبینێت و شێوازەکانی تێیدا فێردەبێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">پیکسڵ چی یە؟</h3>
<p>وێنەکەک رەش و سپی وەک تابلۆیەک ژ ژماران دێتە دیتن: 0 ژبۆ رەش و 255 ژبۆ سپی. مۆدێل وێنێ وەک ڤان تابلۆیان دبینیت.</p>`,
              code: `pixels = [0, 50, 200, 255]
print(max(pixels))`,
              challenge_desc_so: 'لیستی پیکسڵەکان: [0, 100, 255] — بە max() گەورەترینیان چاپ بکە.',
              challenge_desc_ba: 'لیستا پیکسڵان: [0, 100, 255] — ب max() مەزترین وان چاپ بکە.',
              expected_output: '255', example_output: '200' },
            { id: 'ai_course_09_03', langId: 'ai_course_09', order: 3, xp_cost: 0, level_so: 'ناوەندی', level_ba: 'ناڤەندی',
              title_so: 'فیلتەر و دۆزینەوەی قەراغ', title_ba: 'فیلتەر و دیتنا قەراجان',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فیلتەر چییە؟</h3>
<p><b>فیلتەر (Kernel)</b> خشتەیەکی بچووکە کە بەسەر وێنەکەدا دەخزێت و گۆڕانکاری دەکات. فیلتەری قەراغ شوێنی گۆڕانی ناگەهانی ڕووناکی دەدۆزێتەوە.</p>
<p>ئەمە بناغەی <b>Convolutional Neural Networks (CNN)</b>ە — بناغەی زۆربەی مۆدێلەکانی بینین.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">فیلتەر چی یە؟</h3>
<p><b>فیلتەر (Kernel)</b> تابلۆیەک بیچووکە کو ل سەر وێنێ دچیت. ئەڤ بناغەیا <b>CNN</b> ە.</p>`,
              code: `pixels = [0, 255, 0, 255]
bright = sum(1 for p in pixels if p > 100)
print(bright)`,
              challenge_desc_so: 'لیستی پیکسڵەکان: [0, 200, 0, 255] — ژمارەی پیکسڵە ڕووناکەکان (> 100) چاپ بکە.',
              challenge_desc_ba: 'لیستا پیکسڵان: [0, 200, 0, 255] — هەژمارا پیکسڵێن ڕۆناه (> 100) چاپ بکە.',
              expected_output: '2', example_output: '2' },
            { id: 'ai_course_09_04', langId: 'ai_course_09', order: 4, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'کۆنڤۆلوشن — CNN بناغەکان', title_ba: 'کۆنڤۆلوشن — بناغەیێن CNN',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">کۆنڤۆلوشن چۆن کاردەکات؟</h3>
<p><b>Convolution</b>: فیلتەرەکە لە هەر شوێنێک دەنیشێت و ئەندامەکانی لەگەڵ پیکسڵەکانی ژێرەوەی لێکدەدات (multiply) و کۆیان دەکاتەوە.</p>
<p>ئەم ئەنجامە خشتەیەکی نوێ دروست دەکات کە تایبەتمەندییە گرنگەکانی وێنەکە دەردەخات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">کۆنڤۆلوشن چەوا کار دکەت؟</h3>
<p><b>Convolution</b>: فیلتەر ل هەر شوونەکێ دادینەڤیت و ئەندامێن خۆ ب پیکسڵان ڤە لێک دکەت و کۆم دکەت.</p>`,
              code: `pixels = [1, 2, 3]
kernel = [1, 0, 1]
s = sum(p * k for p, k in zip(pixels, kernel))
print(s)`,
              challenge_desc_so: 'بە فیلتەری [1, 0, 1] لەسەر پیکسڵەکانی [2, 4, 2] کۆنڤۆلوشن بکە — ئینجا ئەنجامەکە چاپ بکە.',
              challenge_desc_ba: 'ب فیلتەر [1, 0, 1] ل سەر پیکسڵێن [2, 4, 2] کۆنڤۆلوشنێ بکە — پشتی ئەنجاما چاپ بکە.',
              expected_output: '4', example_output: '4' },
            { id: 'ai_course_09_05', langId: 'ai_course_09', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'دۆزینەوەی شت — Object Detection', title_ba: 'دیتنا شتیان — Object Detection',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">دۆزینەوەی شت</h3>
<p><b>Object Detection</b> نەک تەنها شتەکە دەناسێتەوە بەڵکو <b>شوێنەکەشی</b> لە وێنەکەدا دیاری دەکات — بە بۆکسێک (bounding box).</p>
<p>مۆدێلەکانی وەک <b>YOLO</b> بە خێرایی لە وێنەیەکدا چەندین شت دەدۆزنەوە — بۆ ئۆتۆمۆبیلی بێ شۆفێر و چاودێریی ڤیدیۆیی.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">دیتنا تشتان</h3>
<p><b>Object Detection</b> نە تەنیا تشتێ ناس دکەت بەلێ <b>شوونا وی</b> ژی د وێنێ دا دیار دکەت — ب قوتییەکێ.</p>`,
              code: `boxes = [
    {"label": "cat", "x": 10, "y": 20},
    {"label": "dog", "x": 40, "y": 50}
]
print(len(boxes))`,
              challenge_desc_so: 'لیستەیەک بە 2 بۆکس دروست بکە — ئینجا ژمارەی ئەندامەکانی چاپ بکە.',
              challenge_desc_ba: 'لیستەکەک ب 2 قوتییان چێکە — پشتی هەژمارا ئ�ندامێن چاپ بکە.',
              expected_output: '2', example_output: '3' },

            // --- کۆرسی ١٠: پرۆسێسکردنی زمانی سروشتی (NLP) ---
            { id: 'ai_course_10_01', langId: 'ai_course_10', order: 1, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'NLP چییە؟ — زمان و ئامێر', title_ba: 'NLP چی یە؟ — زمان و ماکین',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LLM چییە؟</h3>
<p><b>LLM (Large Language Model)</b> وەک ChatGPT: مۆدێلێکی گەورەی NLP کە بە ملیاران پەیوەندی لەسەر دەقی زۆر فێرکراوە. لە وشەی پێشوو، وشەی داهاتوو پێشبینی دەکات.</p>
<p>ئەم مۆدێلانە بە <b>Transformers</b> دروست دەبن — نەخشەکێشان لە ئاراستەکانی مێشکی مرۆڤەوە.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LLM چی یە؟</h3>
<p><b>LLM</b> وەک ChatGPT: مۆدێلەک مەزین ژ NLP کو ب ملیاران تێکلییان ل سەر نڤیسا پڕ هاتیە فێرکرن.</p>`,
              code: `text = "hello world from kurdistan"
tokens = text.split()
print(len(tokens))`,
              challenge_desc_so: 'دەقەکە بکەرەوە بە وشە و ژمارەیان چاپ بکە: "salam heval"',
              challenge_desc_ba: 'نڤیسێ ل پەیڤان بیقەتینە و هەژمارا وان چاپ بکە: "salam heval"',
              expected_output: '2', example_output: '4' },
            { id: 'ai_course_10_02', langId: 'ai_course_10', order: 2, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'Tokenization — دابەشکردنی دەق', title_ba: 'Tokenization — دابەشکرنا نڤیسا',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LLM چۆن وەڵام دەداتەوە؟</h3>
<p>LLM لە وشە نووسراوەکان دەست پێ دەکات و بۆ هەر وشەیهەلێک <b>ئەگەر</b> دەخەمڵێنێت: ئەم وشەیە دوای ئەمەی پێشوو چەند جار هاتووە؟ و بەرزترین ئەگەر هەڵدەبژێرێت.</p>
<p>وشە نوێیەکە زیاد دەکرێت و دووبارە پێشبینی دەکرێت — هەتا تەواو دەبێت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">LLM چەوا بەرسڤ ددەت؟</h3>
<p>LLM ژ پەیڤێن هاتیە نڤیسین دەست پێ دکەت و ژبۆ هەر پەیڤێ <b>ئه‌حتمالەک</b> حساب دکەت و یا هەرە بلند هەلبژێرە.</p>`,
              code: `counts = {"salam": 5, "xosh": 2}
best = max(counts, key=counts.get)
print(best)`,
              challenge_desc_so: 'فەرهەنگێک: {"salam": 5, "xosh": 2} — بە max() ئەو وشەیە چاپ بکە کە زۆرترین هاتووە.',
              challenge_desc_ba: 'فەرهەنگەک: {"salam": 5, "xosh": 2} — ب max() وێ پەیڤێ چاپ بکە کو هەرە زێدە هاتیە.',
              expected_output: 'salam', example_output: 'salam' },
            { id: 'ai_course_10_03', langId: 'ai_course_10', order: 3, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'پاککردنەوەی دەق — Stop Words', title_ba: 'پاقژکرنا نڤیسا — Stop Words',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Prompt چییە و بۆچی گرنگە؟</h3>
<p><b>Prompt</b> ڕێنماییەکەی تۆیە بۆ مۆدێلەکە. هەرچی ڕوونتر و وردتر بێت، وەڵامەکە باشتر دەبێت.</p>
<p>پێکهاتەیەکی باش: <b>ڕۆڵ</b> (تۆ فێرکاری کوردی)، <b>کار</b> (ئەم وانەیە ڕوون بکەرەوە) و <b>شێواز</b> (بە نمونە بۆم ڕوون بکە).</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">Prompt چی یە و جیما گرینگە؟</h3>
<p><b>Prompt</b> ڕێبەرناما تە یە ژبۆ مۆدێلێ. هەر چەقە ڕۆناهتر بیت، بەرسڤ ژی چێتر دبی.</p>`,
              code: `role = "teacher"
task = "explain"
prompt = "You are an AI " + role + " for " + task
print(prompt)`,
              challenge_desc_so: 'بە + دەقێک دروست بکە: "You are an AI " + "assistant" — ئینجا چاپی بکە.',
              challenge_desc_ba: 'ب + نڤیسەک چێکە: "You are an AI " + "assistant" — پشتی چاپ بکە.',
              expected_output: 'You are an AI assistant', example_output: 'You are an AI teacher for explain' },
            { id: 'ai_course_10_04', langId: 'ai_course_10', order: 4, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'هەستەشیکاری — Sentiment Analysis', title_ba: 'هەستەشیکاری — Sentiment Analysis',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چۆن زانینی تایبەت بۆ LLM زیاد دەکرێت؟</h3>
<p><b>RAG (Retrieval-Augmented Generation)</b>: پێش وەڵامدانەوە، مۆدێلەکە بە پاشخانێکدا دەگەڕێت و بەڵگەی پەیوەندیدار دەدۆزێتەوە — ئینجا وەڵامەکە لەسەر بنەمای ئەوە دەدات.</p>
<p>بەم شێوەیە دەتوانیت مۆدێلێکی گشتی لەسەر داتای تایبەتی کۆمپانیاکەت بەکاربهێنیت.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">چەوا زانینا تایبەت ژبۆ LLM دێتە زێدەکرن؟</h3>
<p><b>RAG</b>: بەری بەرسڤدانێ، مۆدێل د ئەرشیڤێ دا دگەڕیت و بەلگەیێن تێکلیدار دبینیت — پشتی ل سەر وان بەرسڤێ ددەت.</p>`,
              code: `docs = ["kurdi", "ziman", "slam"]
query = "kurdi"
match = docs[0] if query in docs else "not found"
print(match)`,
              challenge_desc_so: 'لیستەیەک: ["ferga", "slam"] و query = "slam" — ئەگەر هەبوو، یەکەم هاتوو چاپ بکە، نەوەک "not found".',
              challenge_desc_ba: 'لیستەکەک: ["ferga", "slam"] و query = "slam" — هەکە هەبیت، یەکێمین هاتنێ چاپ بکە، نەخوە "not found".',
              expected_output: 'ferga', example_output: 'kurdi' },
            { id: 'ai_course_10_05', langId: 'ai_course_10', order: 5, xp_cost: 0, level_so: 'پێشکەوتوو', level_ba: 'پێشکەفتی',
              title_so: 'وەرگێڕان و پوختەکردن', title_ba: 'وەرگێڕان و کورکرن',
              content_so: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">وەرگێڕان و پوختەکردن</h3>
<p>وەرگێڕان زنجیرە وشەکان دەخوێنێتەوە و زنجیرەیەکی نوێ دروست دەکات بە زمانێکی تر.</p>
<p>پوختەکردن دەقی درێژ دەخوێنێتەوە و کورتەگرتنەوەیەک دروست دەکات.</p>`,
              content_ba: `<h3 class="text-2xl font-black text-gray-900 dark:text-white mb-3">وەرگێڕان و کورکرن</h3>
<p>وەرگێڕان ڕێزا پەیڤان دخوانیت و ڕێزەک نو ب زمانەک دین چێدکەت.</p>
<p>کورکرن نڤیسا درێژ دێتە دەخوێنیت و کورتەگرتنەوەیەک ددەت.</p>`,
              code: `def project(step):
    return "step: " + step

print(project("data"))`,
              challenge_desc_so: 'فەنکشنێک بنووسە بە ناوی run کە دەگەڕێنێتەوە "run: ok" — ئینجا run() چاپ بکە.',
              challenge_desc_ba: 'فەنکشنەک بنڤیسە ب ناڤێ run کو "run: ok" ڤدگەڕینەت — پشتی run() چاپ بکە.',
              expected_output: 'run: ok', example_output: 'step: data' }
        ];

        // پێشکەوتن بەپێی ئەکاونت (ئیمەیڵ) — ڕاژە فایەربەیسەکە وەک ڕاژە ڕاستەوخۆ (realtime) دەگوێرێتەوە
        let currentProgressPath = null;
        let accountLastLangId = null;
        let lastActiveLangId = null;
        let progressUnsub = null;

        // --- Combined HTML+CSS compiler state ---
        let currentCompilerFile = 'html';
        let compilerHtmlBuffer = '';
        let compilerCssBuffer = '';

        // --- Challenge attempts / answer reveal ---
        let challengeAttempts = 0;
        let answerRevealed = false;

        // --- Quill Editors Initialization (lazy: only when an admin edits content) ---
        let quillSo = null, quillBa = null, quillModalSo = null, quillModalBa = null;
        let quillInitPromise = null;
        function initQuill() {
            if (quillInitPromise) return quillInitPromise;
            quillInitPromise = new Promise(function (resolve, reject) {
                var css = document.createElement('link');
                css.rel = 'stylesheet';
                css.href = 'https://cdn.quilljs.com/1.3.6/quill.snow.css';
                document.head.appendChild(css);
                var s = document.createElement('script');
                s.src = 'https://cdn.quilljs.com/1.3.6/quill.js';
                s.onload = function () {
                    try {
                        const toolbar = [{ 'header': [1, 2, 3, false] }, ['bold', 'italic', 'underline'], [{ 'list': 'ordered' }, { 'list': 'bullet' }], ['code-block']];
                        quillSo = new Quill('#editor_content_so', { theme: 'snow', modules: { toolbar } });
                        quillBa = new Quill('#editor_content_ba', { theme: 'snow', modules: { toolbar } });
                        quillModalSo = new Quill('#modal_editor_content_so', { theme: 'snow', modules: { toolbar } });
                        quillModalBa = new Quill('#modal_editor_content_ba', { theme: 'snow', modules: { toolbar } });
                        resolve();
                    } catch (e) { quillInitPromise = null; reject(e); }
                };
                s.onerror = function () { quillInitPromise = null; reject(new Error('quill failed to load')); };
                document.head.appendChild(s);
            });
            return quillInitPromise;
        }

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function applyLanguage() {
            document.getElementById('lang-text').innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => { el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so'); });
            
            renderHome();
            
            if(currentActiveLanguage) {
                openLanguage(currentActiveLanguage.id, currentLessonIndex);
                
                // Update dynamic button texts based on language
                const outText = document.getElementById('code-output').innerText;
                if(outText === 'ئامادەیە بۆ کارپێکردن...' || outText === 'ئامادەیە بۆ کارپێکرنێ...') {
                    document.getElementById('code-output').innerText = currentLang === 'so' ? 'ئامادەیە بۆ کارپێکردن...' : 'ئامادەیە بۆ کارپێکرنێ...';
                }
            }
        }

        // گۆڕینی زمان (سۆرانی / بادینی)
        const langToggleBtn = document.getElementById('lang-toggle');
        if (langToggleBtn) {
            langToggleBtn.addEventListener('click', () => {
                currentLang = currentLang === 'so' ? 'ba' : 'so';
                localStorage.setItem('site-lang', currentLang);
                applyLanguage();
            });
        }

        // گۆڕینی دەقی بادینی/سۆرانی بۆ دوگمەکە هەر لە سەرەتاوە
        try {
            const lt = document.getElementById('lang-text');
            if (lt) lt.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
        } catch(e) { console.error('[ferga] lang text init failed', e); }

        // گۆڕینی ڕووکار (شەو / ڕۆژ)
        const themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
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

        document.getElementById('user-code-css').addEventListener('keydown', function(e) {
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
            if (/c#|csharp/i.test(n)) return 'cs';
            if (n.includes('javascript') || n.includes('js')) return 'js';
            if (n.includes('html') && n.includes('css')) return 'html+css';
            if (n.includes('html')) return 'html';
            if (n.includes('css')) return 'css';
            if (n.includes('ruby') || n.includes('rb')) return 'rb';
            if (n.includes('rust') || n.includes('rs')) return 'rs';
            if (n.includes('go')) return 'go';
            if (n.includes('swift')) return 'swift';
            if (n.includes('kotlin') || n.includes('kt')) return 'kt';
            return 'py';
        }

        function currentLangExtValue() {
            return (currentActiveLanguage && currentActiveLanguage.ext) ? currentActiveLanguage.ext.toLowerCase().replace('.','') : (currentActiveLanguage ? guessExtFromName(loc(currentActiveLanguage, 'name')) : 'py');
        }

        function codePlaceholderText() {
            const ext = currentLangExtValue();
            const msg = currentLang === 'so' ? 'لێرە کۆدەکەت بنووسە' : 'لێرە کۆدێ خۆ بنڤیسە';
            if (ext === 'html' || ext === 'htm' || ext === 'html+css' || ext === 'htmlcss' || ext === 'web') {
                return '<!-- ' + msg + ' -->\n';
            }
            if (ext === 'css') {
                return '/* ' + msg + ' */\n';
            }
            if (ext === 'py' || ext === 'python') {
                return '# ' + msg + '\n';
            }
            if (ext === 'php') {
                return '';
            }
            return '// ' + msg + '\n';
        }

        function isCombinedWebMode() {
            const ext = currentLangExtValue();
            return ext === 'html+css' || ext === 'htmlcss' || ext === 'html-css' || ext === 'web';
        }

        // --- COMPILER LOGIC ---
        window.runCode = async function() {
            const ext = (currentActiveLanguage && currentActiveLanguage.ext) ? currentActiveLanguage.ext.toLowerCase().replace('.','') : (currentActiveLanguage ? guessExtFromName(loc(currentActiveLanguage, 'name')) : 'py');
            if (isCombinedWebMode()) await runHtmlCssCode();
            else if (ext === 'cpp') await runCppCode();
            else if (ext === 'py' || ext === 'python') await runPythonCode();
            else if (ext === 'html' || ext === 'htm') await runHtmlCode();
            else if (ext === 'css') await runCssCode();
            else if (ext === 'php' || ext === 'js' || ext === 'java' || ext === 'rs' || ext === 'cs') {
                let cloudCode = document.getElementById('user-code').value;
                if (ext === 'php') cloudCode = preparePhpCode(cloudCode);
                await runCloudCode(ext, cloudCode);
            }
            else await runServerCode(ext);
        }

        // Switch between index.html / style.css tabs in combined mode
        window.switchCompilerFile = function(file) {
            currentCompilerFile = file;
            const htmlArea = document.getElementById('user-code');
            const cssArea = document.getElementById('user-code-css');
            const tabHtml = document.getElementById('file-tab-html');
            const tabCss = document.getElementById('file-tab-css');
            if (file === 'css') {
                htmlArea.classList.add('hidden');
                cssArea.classList.remove('hidden');
                tabHtml.className = "px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-gray-400 hover:text-white bg-transparent border border-b-0 border-transparent";
                tabCss.className = "px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-white bg-[#1e1e1e] border border-b-0 border-[#333]";
            } else {
                cssArea.classList.add('hidden');
                htmlArea.classList.remove('hidden');
                tabCss.className = "px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-gray-400 hover:text-white bg-transparent border border-b-0 border-transparent";
                tabHtml.className = "px-4 py-2 rounded-t-lg text-xs font-bold font-mono text-white bg-[#1e1e1e] border border-b-0 border-[#333]";
            }
            updateCompilerFilenameLabel();
        };

        function updateCompilerFilenameLabel() {
            if (isCombinedWebMode()) {
                const label = currentCompilerFile === 'css' ? 'style.css' : 'index.html';
                document.getElementById('compiler-filename-label').textContent = label;
            } else {
                document.getElementById('compiler-filename-label').textContent = 'main.' + currentLangExt;
            }
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

        async function runHtmlCssCode() {
            const html = document.getElementById('user-code').value;
            const css = document.getElementById('user-code-css').value;
            hidePreview();
            let combined = html;
            const styleTag = `<style>\n${css}\n</style>`;
            if (css && css.trim()) {
                if (/<link[^>]*href="style\.css"[^>]*>/i.test(combined)) {
                    combined = combined.replace(/<link[^>]*href="style\.css"[^>]*>/i, styleTag);
                } else if (/<style[\s>]/i.test(combined)) {
                    combined = combined.replace(/<style[\s\S]*?<\/style>/i, styleTag);
                } else if (/<\/head>/i.test(combined)) {
                    combined = combined.replace(/<\/head>/i, styleTag + '\n</head>');
                } else if (/<html[^>]*>/i.test(combined)) {
                    combined = combined.replace(/<html[^>]*>/i, m => m + '\n' + styleTag);
                } else {
                    combined = styleTag + '\n' + combined;
                }
            }
            showPreview(combined);
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
                if (data.execResult && data.execResult.stdout) output = data.execResult.stdout.map(o => o.text).join("\n");
                if (data.execResult && data.execResult.stderr && data.execResult.stderr.length) output += "\n" + data.execResult.stderr.map(o => o.text).join("\n");
                if (!output && data.stderr && data.stderr.length) output = data.stderr.map(o => o.text).join("\n");
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

        // Run PHP/JS/Java/Rust/C# through the server proxy -> Wandbox cloud API (no server-side binaries needed)
        function preparePhpCode(code) {
            const trimmed = code.trim();
            if (!/^<\x3Fphp/i.test(trimmed)) return '<\x3Fphp\n' + code;
            return code;
        }

        async function runCloudCode(languageExt, code) {
            const out = document.getElementById('code-output');
            hidePreview();
            out.innerText = currentLang === 'so' ? "سەرقاڵی کارپێکردن..." : "مژویلی کارپێکرنێیە..."; 
            out.classList.add("animate-pulse");
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
                const res = await fetch("/ferga/run-cloud", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({
                        language: languageExt,
                        code: code
                    })
                });
                const data = await res.json();
                let output = "";
                if (data.message) {
                    output = data.message;
                } else if (String(data.status) !== "0") {
                    output = (data.compiler_error || data.compiler_message || data.program_error || "").trim();
                } else {
                    output = (data.program_output || "").trim();
                }
                if (/(OCI runtime error|Resource temporarily unavailable|Internal Server Error)/i.test(output)) {
                    output = (currentLang === 'so' ? "خزمەتگوزاری ڕاندنی دەرەکی ئێستا سەرقاڵە و کۆدەکە نەڕا. تکایە دوای چەند خولەکێک دووبارە هەوڵبدەوە." : "خزمەتگوزاری ڕاندنا دەرڤەیی ئەڤ گەهانە سەرقاڵە و کۆد نەرەڤی. ڤانایە پی دو چەند خولەکان جارەکا دی هەوڵ بدە.");
                }
                latestCompilerOutput = output;
                out.innerText = output || (currentLang === 'so' ? "(بێ دەرکەوتن)" : "(بێ دەرکەفتن)");
            } catch (err) {
                latestCompilerOutput = "";
                out.innerText = (currentLang === 'so' ? "هەڵە لە پەیوەندیکردن بە خزمەتگوزاری:\n" : "خەلەت د پەیوەندیکرنێدا:\n") + err;
            }
            out.classList.remove("animate-pulse");
        }

        // --- ئەنجامی کۆد بۆ پرسیاری "ئەنجامی ئەم کۆدە چییە؟" ---
        async function fetchCodeOutput(code, ext) {
            ext = (ext || 'py').toLowerCase().replace('.', '');
            if (ext === 'py' || ext === 'python') {
                await initPyodide();
                pyodide.runPython("import sys\nfrom io import StringIO\nsys.stdout = StringIO()");
                await pyodide.runPythonAsync(code);
                return pyodide.runPython("sys.stdout.getvalue()") || '';
            }
            if (ext === 'cpp') {
                const res = await fetch("https://godbolt.org/api/compiler/g142/compile", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "Accept": "application/json" },
                    body: JSON.stringify({ source: code, compiler: "g142", options: { userArguments: "-std=c++17 -O2", filters: { execute: true, binary: false } } })
                });
                const data = await res.json();
                let output = "";
                if (data.execResult && data.execResult.stdout) output = data.execResult.stdout.map(o => o.text).join("\n");
                if (data.execResult && data.execResult.stderr && data.execResult.stderr.length) output += "\n" + data.execResult.stderr.map(o => o.text).join("\n");
                if (!output && data.stderr && data.stderr.length) output = data.stderr.map(o => o.text).join("\n");
                if (data.code && data.code !== 0) output = "Compilation error\n" + output;
                return output;
            }
            let prepared = code;
            if (ext === 'php') prepared = preparePhpCode(code);
            if (['php', 'js', 'java', 'rs', 'cs'].includes(ext)) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
                const res = await fetch("/ferga/run-cloud", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                    body: JSON.stringify({ language: ext, code: prepared })
                });
                const data = await res.json();
                let output = "";
                if (data.message) output = data.message;
                else if (String(data.status) !== "0") output = (data.compiler_error || data.compiler_message || data.program_error || "").trim();
                else output = (data.program_output || "").trim();
                return output;
            }
            const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
            const res = await fetch("/ferga/run-code", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": csrfToken },
                body: JSON.stringify({ language: ext, code: code })
            });
            const data = await res.json();
            return data.output || '';
        }

        window.previewQuizCodeOutput = async function() {
            const status = document.getElementById('quiz-output-preview-status');
            const codeEl = document.getElementById('modal_quiz_code');
            const code = codeEl ? codeEl.value : '';
            if (!code || !String(code).trim()) {
                if (status) status.textContent = currentLang === 'so' ? '⚠️ سەرەتا کۆدەکە بنووسە' : '⚠️ بەری هەمی کۆد بنڤێسە';
                return;
            }
            const langSel = document.getElementById('modal_lesson_lang_select');
            let ext = 'py';
            if (langSel && langSel.value && languagesData[langSel.value] && languagesData[langSel.value].ext) {
                ext = String(languagesData[langSel.value].ext).toLowerCase().replace('.', '');
            }
            if (status) status.textContent = currentLang === 'so' ? '⚡ خەریکە کارپێدەکرێت...' : '⚡ مژویلی کارپێکرنێیە...';
            try {
                const output = await fetchCodeOutput(code, ext);
                const sel = document.getElementById('modal_quiz_output_correct');
                const idx = sel ? parseInt(sel.value, 10) : 0;
                const target = document.getElementById(`modal_quiz_output_opt${idx}`);
                if (target) target.value = (output || '').replace(/\s+$/, '');
                if (status) status.textContent = currentLang === 'so' ? '✅ ئەنجامەکە هاتە خوارەوە' : '✅ ئەنجام هاتە دامە';
            } catch (err) {
                if (status) status.textContent = currentLang === 'so' ? '❌ نەتوانرا ئەنجام بهێنرێت: ' + err : '❌ نەشێیا ئەنجام بێت: ' + err;
            }
        };

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
        window.openTryItYourself = function() {
            const lesson = currentLessonArray[currentLessonIndex];
            if (!lesson) return;
            
            const combined = isCombinedWebMode();
            const tabs = document.getElementById('compiler-file-tabs');
            if (tabs) tabs.classList.toggle('hidden', !combined);
            
            if (combined) {
                compilerHtmlBuffer = lesson.code || '';
                compilerCssBuffer = lesson.code_css || '';
                document.getElementById('user-code').value = compilerHtmlBuffer;
                document.getElementById('user-code-css').value = compilerCssBuffer;
                window.switchCompilerFile('html');
            } else {
                document.getElementById('user-code-css').classList.add('hidden');
                document.getElementById('user-code').classList.remove('hidden');
                document.getElementById('user-code').value = codePlaceholderText();
            }
            
            document.getElementById('code-output').innerText = currentLang === 'so' ? 'ئامادەیە بۆ کارپێکردن...' : 'ئامادەیە بۆ کارپێکرنێ...';
            
            const challengeDesc = loc(lesson, 'challenge_desc');
            const panel = document.getElementById('compiler-challenge-panel');
            const hintEl = document.getElementById('compiler-attempt-hint');
            const showAnswerBtn = document.getElementById('btn-show-answer');
            const submitBtn = document.getElementById('btn-submit-challenge');
            const hasChallenge = challengeDesc && lesson.expected_output;
            
            challengeAttempts = 0;
            answerRevealed = false;
            if (hintEl) hintEl.textContent = '';
            const answerBox = document.getElementById('correct-answer-box');
            if (answerBox) answerBox.classList.add('hidden');
            const continueBar = document.getElementById('answer-continue-bar');
            if (continueBar) continueBar.classList.add('hidden');

            // پاککردنەوەی دۆخە کۆنەکە — بۆ ئەوەی دوای وانەیەکی تەواوکراو، دەق/ڕەنگی دوگمەکە و دەرئەنجامی پێشوو نەمێننەوە
            latestCompilerOutput = "";
            if (submitBtn) {
                submitBtn.className = "bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-500 hover:to-pink-400 text-white px-5 py-2 rounded-full font-bold text-xs shadow-[0_0_15px_rgba(168,85,247,0.4)] hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] flex items-center gap-1.5 transition-all hover:scale-105 border border-purple-400/50";
                const btnTextEl = document.getElementById('btn-submit-challenge-text');
                if (btnTextEl) {
                    btnTextEl.setAttribute('data-so', 'پشکنینی مەشق');
                    btnTextEl.setAttribute('data-ba', 'پشکنینا مەشقێ');
                    btnTextEl.textContent = currentLang === 'so' ? 'پشکنینی مەشق' : 'پشکنینا مەشقێ';
                }
            }

            if (hasChallenge) {
                panel.classList.remove('hidden');
                document.getElementById('compiler-challenge-desc').innerHTML = challengeDesc;
                submitBtn.classList.remove('hidden');
                const allowShow = lesson.allow_show_answer !== false;
                if (allowShow && showAnswerBtn) showAnswerBtn.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
                if (submitBtn) submitBtn.classList.add('hidden');
                if (showAnswerBtn) showAnswerBtn.classList.add('hidden');
            }

            document.getElementById('compiler-modal').classList.remove('hidden'); 
            document.getElementById('compiler-modal').classList.add('flex');
        };

        // دەستکاری و ڕەنکردنی کۆدی نموونە لەلایەن بەکارهێنەرەوە
        window.openCodeEditor = function(fromCss) {
            const lesson = currentLessonArray[currentLessonIndex];
            if (!lesson) return;
            const combined = isCombinedWebMode();
            const tabs = document.getElementById('compiler-file-tabs');
            if (tabs) tabs.classList.toggle('hidden', !combined);
            if (combined) {
                compilerHtmlBuffer = lesson.code || '';
                compilerCssBuffer = lesson.code_css || '';
                document.getElementById('user-code').value = compilerHtmlBuffer;
                document.getElementById('user-code-css').value = compilerCssBuffer;
                window.switchCompilerFile(fromCss ? 'css' : 'html');
            } else {
                document.getElementById('user-code-css').classList.add('hidden');
                document.getElementById('user-code').classList.remove('hidden');
                document.getElementById('user-code').value = lesson.code || '';
            }
            const panel = document.getElementById('compiler-challenge-panel');
            if (panel) panel.classList.add('hidden');
            const submitBtn = document.getElementById('btn-submit-challenge');
            if (submitBtn) submitBtn.classList.add('hidden');
            const showAnswerBtn = document.getElementById('btn-show-answer');
            if (showAnswerBtn) showAnswerBtn.classList.add('hidden');
            const answerBox = document.getElementById('correct-answer-box');
            if (answerBox) answerBox.classList.add('hidden');
            const hintEl = document.getElementById('compiler-attempt-hint');
            if (hintEl) hintEl.textContent = '';
            const continueBar = document.getElementById('answer-continue-bar');
            if (continueBar) continueBar.classList.add('hidden');
            latestCompilerOutput = "";
            document.getElementById('code-output').innerText = currentLang === 'so' ? 'ئامادەیە بۆ کارپێکردن...' : 'ئامادەیە بۆ کارپێکرنێ...';
            const modal = document.getElementById('compiler-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        };

        window.closeTryItYourself = function() {
            const modal = document.getElementById('compiler-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            const bar = document.getElementById('answer-continue-bar');
            if (bar) bar.classList.add('hidden');
        };

        window.showCorrectAnswer = function() {
            const lesson = currentLessonArray[currentLessonIndex];
            if (!lesson || answerRevealed) return;
            answerRevealed = true;
            const ansHtml = lesson.answer_code || lesson.code || '';
            const ansCss = lesson.answer_code_css || lesson.code_css || '';
            if (isCombinedWebMode()) {
                compilerHtmlBuffer = ansHtml;
                compilerCssBuffer = ansCss;
                document.getElementById('user-code').value = compilerHtmlBuffer;
                document.getElementById('user-code-css').value = compilerCssBuffer;
                window.switchCompilerFile('html');
            } else {
                document.getElementById('user-code').value = ansHtml;
            }
            const correctCode = isCombinedWebMode()
                ? (ansCss.trim() !== '' ? `${ansHtml}\n\n/* CSS */\n${ansCss}` : ansHtml)
                : ansHtml;
            const answerCode = document.getElementById('correct-answer-code');
            if (answerCode) answerCode.textContent = correctCode;
            const answerBox = document.getElementById('correct-answer-box');
            if (answerBox) answerBox.classList.remove('hidden');
            const showBtn = document.getElementById('btn-show-answer');
            if (showBtn) showBtn.classList.add('hidden');
            const submitBtn = document.getElementById('btn-submit-challenge');
            if (submitBtn) submitBtn.classList.add('hidden');
            const hintEl = document.getElementById('compiler-attempt-hint');
            
            if (hintEl) hintEl.innerHTML = currentLang === 'so'
                ? '⚠️ وەڵامی ڕاستت پێ نیشان درا. هیچ خاڵێک (XP) وەرناگریت، بەڵام دەتوانیت بچیتە وانەی داهاتوو.'
                : '⚠️ بەرسڤێ راست بۆ تە هاتە نیشاندان. چ خاڵان (XP) وەرناگری، لێ دکاری بچیە وانەیا داهاتی.';
            
            window.markLessonCompleted(lesson.id, false, 0);
            
            setTimeout(() => {
                const bar = document.getElementById('answer-continue-bar');
                if (bar) bar.classList.remove('hidden');
            }, 700);
        };

        // بەردەوامبوونی دەستی — دوای بینینی وەڵام، بەکارهێنەر خۆی دەچێتە وانەی داهاتوو
        window.continueAfterAnswer = function() {
            const bar = document.getElementById('answer-continue-bar');
            if (bar) bar.classList.add('hidden');
            window.closeTryItYourself();
            window.goToNextLesson();
        };

        window.verifyChallenge = async function() {
            const lesson = currentLessonArray[currentLessonIndex];
            const btnText = document.getElementById('btn-submit-challenge-text');
            const btn = document.getElementById('btn-submit-challenge');
            const hintEl = document.getElementById('compiler-attempt-hint');
            const maxAttempts = parseInt(lesson && lesson.max_attempts, 10) || 5;
            
            btnText.innerHTML = currentLang === 'so' ? '<span class="animate-pulse">سەرقاڵی پشکنین...</span>' : '<span class="animate-pulse">مژویلی پشکنینێیە...</span>';
            
            await window.runCode(); 
            
            const ext = (currentActiveLanguage && currentActiveLanguage.ext) ? currentActiveLanguage.ext.toLowerCase().replace('.','') : (currentActiveLanguage ? guessExtFromName(loc(currentActiveLanguage, 'name')) : 'py');

            let pass = false;

            if (ext === 'html' || ext === 'css' || isCombinedWebMode()) {
                const checks = parsePreviewChecks(lesson.expected_output || '');
                pass = checks.length > 0 && previewChecksPass(checks);
            } else {
                // Normalize expected and actual outputs (convert CRLF to LF, and trim whitespace)
                const expected = lesson.expected_output ? lesson.expected_output.trim().replace(/\r\n/g, '\n') : "";
                const actual = latestCompilerOutput ? latestCompilerOutput.trim().replace(/\r\n/g, '\n') : "";
                pass = actual === expected;
            }

            if(pass) {
                challengeAttempts = 0;
                if (hintEl) hintEl.textContent = '';
                btnText.innerHTML = currentLang === 'so' ? "ئافەرین! وەڵامەکە ڕاستە ✓" : "ئافەرم! بەرسڤ ڕاستە ✓";
                btn.classList.replace('from-purple-600', 'from-green-500');
                btn.classList.replace('to-pink-500', 'to-emerald-500');

                // Check if this is an AI lesson - no XP for AI lessons
                const isAILesson = currentActiveLanguage && currentActiveLanguage.is_ai === true;
                window.markLessonCompleted(lesson.id, !isAILesson, isAILesson ? 0 : 50);

                setTimeout(() => {
                    window.closeTryItYourself();
                    window.goToNextLesson();
                }, 1500);
            } else {
                challengeAttempts++;
                if (challengeAttempts >= maxAttempts && !answerRevealed) {
                    window.showCorrectAnswer();
                    btnText.innerHTML = currentLang === 'so' ? "هەڵەیە! وەڵامی ڕاست نیشان درا" : "خەلەتە! بەرسڤێ راست هاتیە نیشان دان";
                    btn.classList.replace('from-purple-600', 'from-amber-500');
                    btn.classList.replace('to-pink-500', 'to-orange-500');
                } else {
                    const remaining = Math.max(maxAttempts - challengeAttempts, 0);
                    if (hintEl) hintEl.innerHTML = currentLang === 'so'
                        ? `وەڵامەکە هەڵەیە — <b>${remaining}</b> هەوڵی ماوە`
                        : `بەرسڤ خەلەتە — <b>${remaining}</b> هەوڵێت ماین`;
                    btnText.innerHTML = currentLang === 'so' ? "هەڵەیە، دووبارە تاقیبکەرەوە" : "خەلەتە، دوبارە تاقیبکە";
                    btn.classList.replace('from-purple-600', 'from-red-600');
                    btn.classList.replace('to-pink-500', 'to-rose-500');
                    setTimeout(() => {
                        btnText.innerHTML = currentLang === 'so' ? 'پشکنینی مەشق' : 'پشکنینا مەشقێ';
                        btn.classList.replace('from-red-600', 'from-purple-600');
                        btn.classList.replace('to-rose-500', 'to-pink-500');
                    }, 3000);
                }
            }
        }

        // --- Progression Logic ---
        // پاشەکەوتی ناوخۆیی (localStorage) بۆ وانە تەواوکراوەکان — ئەگەر فایەربەیس بشکێت، قفڵ نالابێتەوە
        function completedBackupKey() { return 'ferga_completed_' + (currentUid || 'guest'); }
        function saveCompletedBackup() {
            try { localStorage.setItem(completedBackupKey(), JSON.stringify(completedLessons)); } catch(e) { console.error('[ferga] backup write failed', e); }
        }
        function loadCompletedBackup() {
            try { const raw = localStorage.getItem(completedBackupKey()); return raw ? JSON.parse(raw) : []; } catch(e) { return []; }
        }
        function unionArrays(a, b) { const s = new Set([].concat(a || [], b || [])); return Array.from(s); }

        // پاشەکەوتی ناوخۆیی بۆ وانە خەڵاتدراوەکان — بۆ ئەوەی XP هەرگیز دووبارە نەدرێتەوە
        function xpAwardedBackupKey() { return 'ferga_xp_awarded_' + (currentUid || 'guest'); }
        function saveXPBackup() { try { localStorage.setItem(xpAwardedBackupKey(), JSON.stringify(xpAwardedLessons)); } catch(e) { console.error('[ferga] xp backup write failed', e); } }
        function loadXPBackup() { try { const raw = localStorage.getItem(xpAwardedBackupKey()); return raw ? JSON.parse(raw) : {}; } catch(e) { return {}; } }

        window.markLessonCompleted = function(lessonId, giveReward = true, xpAmount = 20) {
            let isNew = false;
            if(lessonId && !completedLessons.includes(lessonId)) {
                completedLessons.push(lessonId);
                isNew = true;
                saveCompletedBackup();
            }

            if (giveReward && lessonId && !xpAwardedLessons[lessonId]) {
                xpAwardedLessons[lessonId] = true;
                saveXPBackup();
                try { triggerConfetti(); } catch(e) { console.error('[ferga] confetti failed', e); }
                try {
                    addXP(xpAmount);
                } catch(e) {
                    console.error('[ferga] addXP failed', e);
                    try { saveProgressToFirebase(); } catch(e2) { console.error('[ferga] fallback save failed', e2); }
                }
            } else if (isNew) {
                try { saveProgressToFirebase(); } catch(e) { console.error('[ferga] progress save failed', e); }
            }

            if (isNew) {
                const lesson = lessonsData[lessonId];
                if (lesson && lesson.langId && lessonProgress[lesson.langId]) {
                    lessonProgress[lesson.langId].completed = (lessonProgress[lesson.langId].completed || 0) + 1;
                }
                if (lesson && lesson.langId) checkLanguageCompletion(lesson.langId);
            }

            if (isNew && currentActiveLanguage) renderSidebar();
            return isNew;
        }

        // --- Badge (باج) functions ---
        function badgesBackupKey() { return 'ferga_badges_' + (currentUid || 'guest'); }
        function loadBadgesBackup() { try { const raw = localStorage.getItem(badgesBackupKey()); return raw ? JSON.parse(raw) : {}; } catch(e) { return {}; } }
        function saveBadgesBackup() { try { localStorage.setItem(badgesBackupKey(), JSON.stringify(badgesEarned)); } catch(e) { console.error('[ferga] badges backup failed', e); } }
        function saveBadgesToFirebase() {
            if (!currentUid || !Object.keys(badgesEarned).length) return;
            set(dbRef(db, 'users/' + currentUid + '/ferga_badges'), badgesEarned).catch(() => {});
        }
        function badgeMetaFor(langId) {
            const l = languagesData[langId];
            if (l && l.is_ai) {
                const name = loc(l, 'name');
                return { icon: l.icon || '🤖', grad: 'from-emerald-500 to-cyan-500', ring: 'rgba(52,211,153,0.45)', title_so: name, title_ba: name };
            }
            const ext = (l && l.ext) ? String(l.ext).replace('.', '').toLowerCase() : '';
            return LANGUAGE_BADGES[ext] || FALLBACK_BADGE;
        }
        function isLanguageFullyCompleted(langId) {
            const lessons = sortedLangLessons(langId);
            if (!lessons.length) return false;
            return lessons.every(l => completedLessons.includes(l.id));
        }
        function checkLanguageCompletion(langId) {
            try {
                if (!langId || !isLanguageFullyCompleted(langId)) return;
                if (badgesEarned[langId]) return;
                badgesEarned[langId] = { earnedAt: Date.now() };
                saveBadgesBackup();
                saveBadgesToFirebase();
                setTimeout(() => { try { showBadgeCelebration(langId); } catch(e) { console.error('[ferga] badge modal failed', e); } }, 500);
            } catch(e) { console.error('[ferga] badge completion check failed', e); }
        }
        function showBadgeCelebration(langId) {
            const modal = document.getElementById('badge-modal');
            if (!modal) return;
            const meta = badgeMetaFor(langId);
            const l = languagesData[langId];
            const langName = l ? (loc(l, 'name') || (currentLang === 'so' ? 'زمان' : 'زوان')) : (currentLang === 'so' ? 'زمان' : 'زوان');
            document.getElementById('badge-icon').textContent = meta.icon;
            document.getElementById('badge-title').textContent = currentLang === 'so' ? meta.title_so : meta.title_ba;
            document.getElementById('badge-kicker').textContent = currentLang === 'so' ? 'پیرۆزبایییەکان 🎉' : 'پیرۆزبایی 🎉';
            const chip = document.getElementById('badge-lang-chip');
            chip.textContent = langName;
            document.getElementById('badge-desc').textContent = currentLang === 'so'
                ? 'ئافەرین! بە سەرکەوتوویی هەموو وانەکانی ' + langName + ' تەواو کردیت. ئەم باجە هەتا هەتایە هی تۆیە!'
                : 'ئافەرم! تە ب سەرکەفتی هەمی وانەیێن ' + langName + ' دووماهی ئینان. ئەڤ باجە هەتاهەتایێ هی تەیە!';
            modal.style.setProperty('--badge-glow', meta.ring);
            try { triggerConfetti(); } catch(e) { console.error('[ferga] badge confetti failed', e); }
            const disc = modal.querySelector('.badge-disc');
            if (disc) { disc.classList.remove('badge-disc'); void disc.offsetWidth; disc.classList.add('badge-disc'); }
            const ring = modal.querySelector('.badge-ring');
            if (ring) { ring.style.animation = 'none'; void ring.offsetWidth; ring.style.animation = ''; }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        window.closeBadgeModal = function() {
            const modal = document.getElementById('badge-modal');
            if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
        };

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
            notif.innerHTML = amount >= 0 ? `✨ +${amount} XP` : `🪙 ${amount} XP`;
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

        function setSaveStatus(msg, isError) {
            const el = document.getElementById('save-status');
            if (el) {
                el.classList.remove('hidden');
                if (isError) {
                    el.className = 'px-5 py-2.5 border-b border-gray-200 dark:border-gray-800 text-[11px] font-bold flex items-center gap-2 bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300';
                } else {
                    el.className = 'px-5 py-2.5 border-b border-gray-200 dark:border-gray-800 text-[11px] font-bold flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300';
                }
                el.textContent = msg;
            }
        }

        function showProgressSaveError(err) {
            console.error('[ferga] progress SAVE FAILED:', err);
            setSaveStatus('پاراستن شکستی هێنا: ' + (err && err.message ? err.message : 'unknown'), true);
            try {
                const container = document.getElementById('xp-notification-container');
                if (container) {
                    const notif = document.createElement('div');
                    notif.className = 'xp-popup bg-gradient-to-r from-rose-600 to-red-600 text-white px-4 py-2 rounded-2xl shadow-2xl font-bold text-sm';
                    notif.textContent = 'پاراستنی پێشکەوتن سەرکەوتوو نەبوو: ' + (err && err.message ? err.message : 'unknown');
                    container.appendChild(notif);
                    setTimeout(() => notif.remove(), 5000);
                }
            } catch(e2) {}
        }

        function saveProgressToFirebase() {
            if(!currentUid || !currentProgressPath) return;
            const savedLangId = lastActiveLangId || accountLastLangId || null;
            const payload = { xp: userXP, completedLessons: completedLessons, streak: dayStreak, lastActiveDate: lastActiveDate, lessonProgress: lessonProgress, lastLanguageId: savedLangId, xpAwarded: xpAwardedLessons, aiUnlocked: aiUnlocked };
            update(dbRef(db, currentProgressPath), payload)
                .then(() => { console.log('[ferga] progress saved OK'); setSaveStatus('پێشکەوتن سەیڤکرا'); })
                .catch(showProgressSaveError);
        }

        function trackLessonVisit() {
            if (!currentActiveLanguage || currentLessonIndex === undefined || currentLessonIndex === null) return;
            const langId = currentActiveLanguage.id;
            lastActiveLangId = langId;
            try {
                localStorage.setItem('ferga_last_lang', currentActiveLanguage.id);
                // سەیڤکردنی کۆتا وانە بۆ هەر زمانێک بە جیاواز
                localStorage.setItem('ferga_last_lesson_' + langId, window.currentLessonId);
            } catch(e) { console.error('[ferga] localStorage write failed', e); }
            if (!lessonProgress[langId]) {
                let count = 0;
                Object.keys(lessonsData).forEach(lid => {
                    if (lessonsData[lid].langId === langId && completedLessons.includes(lid)) count++;
                });
                lessonProgress[langId] = { lastIndex: 1, completed: count, total: currentLessonArray.length, lastLessonId: null, updatedAt: Date.now() };
            }
            const p = lessonProgress[langId];
            p.lastIndex = Math.max(p.lastIndex || 1, currentLessonIndex + 1);
            p.total = currentLessonArray.length;
            p.lastLessonId = window.currentLessonId;
            p.updatedAt = Date.now();
            saveProgressToFirebase();
        }

        // --- بیرگەی کاتی (LocalStorage) بۆ ڕیفرێش — ئەو سیستمەی کە پێشتر درا ---
        let dataLoaded = { langs: false, lessons: false, quizzes: false, auth: false };
        let initialLoadDone = false;

        function clearLocalResume() {
            try { localStorage.removeItem('ferga_last_lang'); } catch(e) {}
            try {
                Object.keys(localStorage).forEach(k => { if (k.indexOf('ferga_last_lesson_') === 0) localStorage.removeItem(k); });
            } catch(e) {}
        }

        function sortedLangLessons(langId) {
            let arr = Object.keys(lessonsData).filter(lid => lessonsData[lid].langId === langId).map(lid => ({ id: lid, ...lessonsData[lid] }));
            arr.sort((a, b) => {
                let orderA = parseInt(a.order) || 0;
                let orderB = parseInt(b.order) || 0;
                if (orderA !== orderB) return orderA - orderB;
                return a.id.localeCompare(b.id);
            });
            return arr;
        }

        function checkAndAutoResume() {
            if (!initialLoadDone && dataLoaded.langs && dataLoaded.lessons && dataLoaded.auth && dataLoaded.quizzes) {
                initialLoadDone = true;
                applyLanguage();
                // هەرگیز بە خۆی نەچیتە ناو وانە/زمانێک — هەر کات پەڕەکە دەکرێتەوە، پەڕەی هەموو وانەکان دەردەکەوێت
                renderHome();
            } else if (initialLoadDone) {
                if (!currentActiveLanguage) renderHome();
            }
        }

        window.addXP = function(amount) {
            userXP += amount;
            showXPNotification(amount);
            saveProgressToFirebase();
        };

        // --- Data Fetching ---
        // تێکەڵکردنی بەشی ژیری دەستکرد (virtual) لەگەڵ داتای فایەربەیس — تەنها وانە/بەشی نەهاتوو زیاد دەکرێت، بۆیە دەستکاری ئەدمین لە فایەربەیس ناسرێتەوە
        function mergeVirtualAI() {
            AI_TOPICS.forEach(t => { if (!languagesData[t.id]) languagesData[t.id] = { ...t }; });
            AI_SAMPLE_LESSONS.forEach(l => { if (!lessonsData[l.id]) lessonsData[l.id] = { ...l }; });
        }
        mergeVirtualAI();
        function showDataLoadError(m){const b=document.getElementById('data-load-error'),t=document.getElementById('data-load-error-msg');if(b){if(m&&t)t.textContent=m;b.classList.remove('hidden');}} function hideDataLoadError(){const b=document.getElementById('data-load-error');if(b)b.classList.add('hidden');} function subscribeWithTimeout(q,cb,t=8000){let h=false;const tm=setTimeout(()=>{if(!h){console.warn('Timeout');showDataLoadError('کێشەیەک لە بارکردنی داتاکان هەیە، پەیوەندی خاوە.');}},t);return onValue(q,(s)=>{h=true;clearTimeout(tm);hideDataLoadError();cb(s);},(e)=>{clearTimeout(tm);console.error(e);showDataLoadError(e&&e.message?e.message:'هەڵەیەک ڕوویدا');});}
        subscribeWithTimeout(dbRef(db, 'ferga_languages'), (s) => { languagesData = s.val() || {}; mergeVirtualAI(); dataLoaded.langs = true; applyLanguage(); updateAdminSelects(); renderManageList(); checkAndAutoResume(); });
        subscribeWithTimeout(dbRef(db, 'ferga_lessons'), (s) => { lessonsData = s.val() || {}; mergeVirtualAI(); dataLoaded.lessons = true; updateAdminSelects(); renderManageList(); checkAndAutoResume(); });
        subscribeWithTimeout(dbRef(db, 'ferga_quizzes'), (s) => { quizzesData = s.val() || {}; dataLoaded.quizzes = true; renderManageList(); checkAndAutoResume(); });

        // پێشکەوتن بەپێی ئیمەیڵ — ڕاژە فایەربەیسەکە وەک ڕاژە ڕاستەوخۆ (realtime) دەگوێرێتەوە
        function applyProgressData(data) {
            if (data) {
                userXP = data.xp || 0;
                // چارەسەری کێشەی فایەربەیس: دڵنیابوونەوە لەوەی کە هەمیشە وەک لیست (Array) مامەڵەی لەگەڵ دەکرێت
                const fromFirebase = data.completedLessons ? (Array.isArray(data.completedLessons) ? data.completedLessons : Object.values(data.completedLessons)) : [];
                // تێکەڵکردنی پاشەکەوتی ناوخۆیی: ئەگەر وانەیەک ناوخۆیی تەواو کرابوو بەڵام هێشتا فایەربەیس نەگەیشت، قفڵی نالابێتەوە
                completedLessons = unionArrays(fromFirebase, loadCompletedBackup());
                saveCompletedBackup();
                dayStreak = data.streak || 0; lastActiveDate = data.lastActiveDate || "";
                lessonProgress = data.lessonProgress || {};
                accountLastLangId = data.lastLanguageId || null;
            } else {
                completedLessons = loadCompletedBackup();
                if (completedLessons.length > 0) saveCompletedBackup();
                userXP = 0; dayStreak = 0; lastActiveDate = ""; lessonProgress = {};
                accountLastLangId = null;
            }
            // وانە تەواوکراوەکان وەک خەڵاتدراو هەژمار دەکرێن — دڵنیابوونەوە لەوەی XP دووبارە نەدرێتەوە
            xpAwardedLessons = {};
            completedLessons.forEach(id => { xpAwardedLessons[id] = true; });
            try {
                const savedAwarded = data && data.xpAwarded ? data.xpAwarded : {};
                Object.assign(xpAwardedLessons, savedAwarded, loadXPBackup());
            } catch(e) { console.error('[ferga] xp awarded load failed', e); }
            saveXPBackup();
            try { aiUnlocked = Object.assign({}, loadAIUnlocked(), (data && data.aiUnlocked) || {}); } catch(e) { aiUnlocked = loadAIUnlocked(); }
            saveAIUnlocked();
            if (updateStreakLogic()) saveProgressToFirebase();
            updateStatsUI();
            if (currentActiveLanguage) renderSidebar();
            renderHome();
            dataLoaded.auth = true;
            checkAndAutoResume();
        }

        // کلیدی سەلامەت بۆ ئیمەیڵ: ڕاژەی فایەربەیس ڕێگا نادات بە نوسینەوەی (.) لە ناوی کلیددا
        function safeEmailKey(email) {
            return String(email || '').trim().toLowerCase().replace(/\./g, ',');
        }

        onAuthStateChanged(auth, async (user) => { 
            if(!user) {
                /* Guest mode: all lessons are public, progress stays in this browser */
                currentUid = null;
                currentProgressPath = null;
                window.isAdmin = false;
                window.isMember = false;
                applyProgressData(null);
            } else {
                currentUid = user.uid;

                /* body visible instantly */
                window.isAdmin = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email);
                if(window.isAdmin) {
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
                renderHome();

                window.isMember = false;
                if(user.email) {
                    try {
                        set(dbRef(db, 'user_index/' + safeEmailKey(user.email)), { uid: user.uid, email: user.email }).catch(() => {});
                    } catch(e) { console.error('[ferga] user_index write failed:', e); }
                    set(dbRef(db, `users/${currentUid}/email`), user.email).catch(() => {});
                    get(dbRef(db, `users/${currentUid}/is_member`)).then(msnap => {
                        window.isMember = msnap.exists() ? msnap.val() === true : false;
                        renderHome();
                    }).catch(() => { window.isMember = false; });
                }

                // پێشکەوتن بەپێی ئیمەیڵ: ئەگەر بەکارهێنەر بە هەمان ئیمەیڵ بە دوو ئەکاونتی جیاواز (بۆ نموونە ئیمەیڵ/پاسۆرد + گووگڵ) چووە ژوورەوە،
                // پێشکەوتنەکەی لە ئەکاونتی کۆنەوە بۆ ئەکاونتی ئێستا دەگوازرێتەوە
                currentProgressPath = `users/${currentUid}/ferga_progress`;
                if (user.email) {
                    try {
                        const idxSnap = await get(dbRef(db, 'user_index/' + safeEmailKey(user.email)));
                        if (idxSnap.exists() && idxSnap.val().uid && idxSnap.val().uid !== currentUid) {
                            const otherSnap = await get(dbRef(db, `users/${idxSnap.val().uid}/ferga_progress`));
                            const mySnap = await get(dbRef(db, `users/${currentUid}/ferga_progress`));
                            if (otherSnap.exists() && !mySnap.exists()) {
                                await set(dbRef(db, `users/${currentUid}/ferga_progress`), otherSnap.val());
                            }
                        }
                    } catch(e) {
                        console.error('[ferga] progress migration failed:', e);
                    }
                }

                try {
                    if (progressUnsub) progressUnsub();
                    progressUnsub = onValue(dbRef(db, currentProgressPath), (snap) => { applyProgressData(snap.val()); }, (err) => {
                        console.error('[ferga] progress listen failed:', err);
                        if (!dataLoaded.auth) { dataLoaded.auth = true; checkAndAutoResume(); }
                    });
                } catch(e) {
                    console.error('[ferga] progress subscribe failed:', e);
                    dataLoaded.auth = true;
                    checkAndAutoResume();
                }

                // بارکردنی باجەکان (زمانە تەواوکراوەکان)
                try {
                    const localBadges = loadBadgesBackup();
                    get(dbRef(db, 'users/' + currentUid + '/ferga_badges')).then(snap => {
                        const fb = snap.val() || {};
                        const merged = {};
                        for (const k in fb) if (fb[k]) merged[k] = fb[k];
                        for (const k in localBadges) if (localBadges[k] && !merged[k]) merged[k] = localBadges[k];
                        badgesEarned = merged;
                        saveBadgesBackup();
                    }).catch(() => { badgesEarned = localBadges; saveBadgesBackup(); });
                } catch(e) { console.error('[ferga] badge load failed', e); }
            }
        });

        // --- Render UI ---

        // شریتێ پێشکەفتنێ یێ شووشەیی (Glassmorphic linear progress bar)
        // Reusable across category & language cards. `grad` = Tailwind gradient (e.g. 'from-cyan-400 to-blue-600'),
        // `glow` = rgba() used for the neon drop-shadow so it matches each card's own glowing border.
        // Structured so `pct` can be bound from Alpine.js (:style / x-bind) or a Blade echo later.
        function glassProgressBar(pct, grad, glow, opts) {
            opts = opts || {};
            const p = Math.max(0, Math.min(100, Math.round(pct || 0)));
            const soon = opts.soon === true;
            const label = opts.labelText || (soon
                ? (currentLang === 'so' ? 'بەمزووانە' : 'بەردەست دبیت')
                : (currentLang === 'so' ? 'پێشکەوتن' : 'پێشکەفتن'));
            // percentage caption floating above the bar, aligned to the reading edge
            const rightChip = soon
                ? `<span class="text-[11px] font-black text-gray-400 dark:text-gray-500">⏳</span>`
                : `<span class="text-[11px] font-black bg-gradient-to-r ${grad} bg-clip-text text-transparent tabular-nums">${p}%</span>`;
            const caption = opts.showLabel === false ? '' : `
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">${label}</span>
                    ${rightChip}
                </div>`;
            // filled portion: neon gradient + custom glow drop-shadow tuned to the card's border color.
            // Coming-soon cards show an indeterminate glass sweep instead of a real value.
            const fillShadow = `0 0 8px ${glow}, 0 0 16px ${glow}`;
            const fill = soon
                ? `<div class="kai-progress-fill kai-progress-indeterminate bg-gradient-to-r ${grad}" style="width:38%; opacity:.5; box-shadow:${fillShadow};"></div>`
                : `<div class="kai-progress-fill bg-gradient-to-r ${grad}" style="width:${p}%; box-shadow:${fillShadow};"></div>`;
            return `
                <div class="w-full ${opts.wrapClass || 'mt-auto pt-1'}" role="progressbar" aria-valuenow="${soon ? 0 : p}" aria-valuemin="0" aria-valuemax="100" aria-label="${label}">
                    ${caption}
                    <div class="kai-progress-track">
                        ${fill}
                    </div>
                </div>`;
        }

        // چ گرادیێنت و ڕەنگێ گڕدانێ بۆ هەر زمانەکێ — derive neon gradient + glow from the language badge
        function langProgressStyle(id) {
            const meta = badgeMetaFor(id) || FALLBACK_BADGE;
            return { grad: meta.grad || 'from-cyan-400 to-blue-600', glow: meta.ring || 'rgba(96,165,250,0.55)' };
        }

        function renderLanguagesGrid() {
            const grid = document.getElementById('languages-grid');
            if(!grid) return;
            grid.innerHTML = '';
            for (let id in languagesData) {
                const l = languagesData[id];
                if (l.is_ai) continue; // بەشێکانی ژیری دەستکرد لە ناو زمانەکان پیشان نادرێن — بەشێکی سەربەخۆن
                const name = loc(l, 'name');
                const desc = loc(l, 'desc');
                const locked = l.locked === true;
                const showLock = locked && !window.isAdmin;
                const needsMembership = locked && !window.isAdmin && !window.isMember;
                // پێشکەوتنی ئەم زمانە — completed lessons / total lessons
                const langLessons = sortedLangLessons(id);
                const langTotal = langLessons.length;
                const langDone = langLessons.filter(le => completedLessons.includes(le.id)).length;
                const langPct = langTotal ? Math.round((langDone / langTotal) * 100) : 0;
                const ps = langProgressStyle(id);
                const progressLabel = currentLang === 'so' ? `${langDone}/${langTotal} وانە` : `${langDone}/${langTotal} وانە`;
                const progressBar = glassProgressBar(langPct, ps.grad, ps.glow, { labelText: progressLabel });
                let iconHtml = l.logo_url ? `<img src="${l.logo_url}" class="w-full h-full object-contain p-2" alt="${name}">` : `<span class="text-3xl font-black text-gray-800">${name.charAt(0)}</span>`;
                const openAction = needsMembership
                    ? `window.openMembershipModal('${id}')`
                    : `window.openLanguage('${id}')`;
                const lockBadge = showLock ? `
                    <div onclick="event.stopPropagation(); ${openAction}" class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 flex items-center gap-1.5 px-4 py-1.5 rounded-full text-[11px] font-black shadow-lg bg-gradient-to-r from-amber-500 to-yellow-500 text-white ring-2 ring-white dark:ring-gray-900 hover:scale-105 transition-transform cursor-pointer whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V10a2 2 0 00-2-2zm-6 9a2 2 0 110-4 2 2 0 010 4zm3.5-9h-7V6a3.5 3.5 0 117 0v2z"/></svg>
                        ${currentLang === 'so' ? 'بەم زوانە بەردەست دەبێت' : 'بۆ ئەم زوانە بەردەست دەبیت'}
                    </div>` : '';
                const doneBadge = badgesEarned[id] ? `
                    <div onclick="event.stopPropagation(); window.openLanguage('${id}')" class="absolute top-4 right-4 z-20 flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-black shadow-lg bg-gradient-to-r from-emerald-500 to-teal-500 text-white ring-2 ring-white dark:ring-gray-900 hover:scale-105 transition-transform cursor-pointer whitespace-nowrap">
                        <span>${badgeMetaFor(id).icon}</span>
                        ${currentLang === 'so' ? 'تەواو بوو' : 'دووماهی بوو'}
                    </div>` : '';
                grid.innerHTML += `
                    <div class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 flex flex-col items-center text-center p-10 group hover:-translate-y-2 relative ${showLock ? 'ring-1 ring-amber-200/60 dark:ring-amber-700/40' : ''}">
                        ${lockBadge}
                        ${doneBadge}
                        <div onclick="${openAction}" class="cursor-pointer w-full flex flex-col items-center">
                            <div class="w-24 h-24 ${l.color || 'bg-blue-100'} rounded-[1.5rem] flex items-center justify-center mb-8 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 relative">
                                ${iconHtml}
                            </div>
                            <h3 class="text-2xl font-black mb-4 text-gray-900 dark:text-white"><bdi>${name}</bdi></h3>
                            <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose line-clamp-3 mb-4">${desc}</p>
                        </div>
                        ${progressBar}
                        ${window.isAdmin ? `
                        <div class="flex items-center gap-2 w-full pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                            <button onclick="event.stopPropagation(); window.toggleLanguageLock('${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 ${locked ? 'bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400 hover:bg-green-100' : 'bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400 hover:bg-gray-200'} rounded-xl font-bold text-xs transition border ${locked ? 'border-green-200 dark:border-green-800/50' : 'border-gray-200 dark:border-gray-700'}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                ${locked ? (currentLang === 'so' ? 'کردنەوە' : 'ڤەکرن') : (currentLang === 'so' ? 'قفڵکردن' : 'قفڵکرن')}
                            </button>
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

        // --- بەشەکان (Categories): پیشانکەری سەرەکی ---
        function aiUnlockBackupKey() { return 'ferga_ai_unlocked_' + (currentUid || 'guest'); }
        function saveAIUnlocked() { try { localStorage.setItem(aiUnlockBackupKey(), JSON.stringify(aiUnlocked)); } catch(e) { console.error('[ferga] ai unlock backup failed', e); } }
        function loadAIUnlocked() { try { const raw = localStorage.getItem(aiUnlockBackupKey()); return raw ? JSON.parse(raw) : {}; } catch(e) { return {}; } }

        function renderHome() {
            const nav = document.getElementById('category-nav');
            const titleEl = document.getElementById('category-title');
            const subEl = document.getElementById('category-subtitle');
            const heroSub = document.getElementById('home-hero-subtitle');
            const grid = document.getElementById('languages-grid');
            if (grid) grid.dataset.kaiView = homeView;
            if (homeView === 'ai') {
                if (nav) nav.classList.remove('hidden');
                if (titleEl) titleEl.textContent = currentLang === 'so' ? '🤖 فێربوونی ژیری دەستکرد' : '🤖 فێربوونا زیرەکیا دەستکرد';
                if (subEl) subEl.textContent = currentLang === 'so'
                    ? 'بەشێک هەڵبژێرە و فێربوونەکەت دەست پێ بکە.'
                    : 'بەشەک هەلبژێرە و فێربوونا خۆ دەستپێبکە.';
                if (heroSub) {
                    heroSub.textContent = currentLang === 'so'
                        ? 'هەر بەشێک دەکرێتەوە کاتێک بەشەکەی پێشوو تەواو دەبێت — فێربوونێکی ڕیزبەندی کراو.'
                        : 'هەر بەشەک دێتە ڤەکرن کەدەمێ بەشەکێ پێشوو دێتە تەمامکرن — فێربوونەکێ ڕێزکرن.';
                }
                renderAITopicsGrid();
            } else if (homeView === 'langs') {
                if (nav) nav.classList.remove('hidden');
                if (titleEl) titleEl.textContent = currentLang === 'so' ? '💻 زمانەکانی پرۆگرامسازی' : '💻 زمانێن پرۆگرامسازی';
                if (subEl) subEl.textContent = currentLang === 'so'
                    ? 'زمانێک هەڵبژێرە و هەنگاو بە هەنگاو فێربە.'
                    : 'زمانەک هەلبژێرە و پێنگاڤ ب پێنگاڤ فێرببە.';
                if (heroSub) heroSub.textContent = currentLang === 'so'
                    ? 'ئەو زمانە هەڵبژێرە کە دەتەوێت لێیەوە دەست پێ بکەیت و هەنگاو بە هەنگاو فێربە.'
                    : 'وێ زمانێ هەلبژێرە کو دڤێت ژێ دەستپێبکەی و پێنگاڤ ب پێنگاڤ فێرببە.';
                renderLanguagesGrid();
            } else {
                if (nav) nav.classList.add('hidden');
                if (heroSub) heroSub.textContent = currentLang === 'so'
                    ? 'بەشێک هەڵبژێرە بۆ دەستپێکردنی فێربوون.'
                    : 'بەشەک هەلبژێرە دۆ دەستپێکرنا فێربوونێ.';
                renderCategoriesGrid();
            }
        }

        window.openCategory = function(catId) {
            homeView = catId === 'ai' ? 'ai' : 'langs';
            renderHome();
        };

        window.goToCategories = function() {
            homeView = 'categories';
            renderHome();
        };

        window.openAIComingSoon = function() {
            showFlash(currentLang === 'so'
                ? '🤖 بەشی ژیری دەستکرد بەم زوانە دەکرێتەوە'
                : '🤖 بەشێ زیرەکیا دەستکرد د ڤێ زوانێ دا دێ ڤەبیت');
        };

        window.openRoboticsComingSoon = function() {
            showFlash(currentLang === 'so' ? '🦾 بەشی ڕۆبۆتیک بەمزووانە بەردەست دەبێت!' : '🦾 بەشێ ڕۆبۆتیک د نزیکترین دەمی دا بەردەست دبیت!');
        };

        function renderCategoriesGrid() {
            const grid = document.getElementById('languages-grid');
            if (!grid) return;
            grid.innerHTML = '';
            const langIds = Object.keys(languagesData).filter(id => !languagesData[id].is_ai);
            const langCount = langIds.length;
            // کۆی پێشکەوتنی هەموو زمانەکان — aggregate progress across every programming language
            const allLangLessons = langIds.reduce((acc, id) => acc.concat(sortedLangLessons(id)), []);
            const langTotalAll = allLangLessons.length;
            const langDoneAll = allLangLessons.filter(le => completedLessons.includes(le.id)).length;
            const langPctAll = langTotalAll ? Math.round((langDoneAll / langTotalAll) * 100) : 0;
            // کۆی پێشکەوتنی بەشەکانی ژیری دەستکرد — aggregate AI progress (admins learn/track it)
            const aiLessonsAll = AI_TOPICS.reduce((acc, t) => acc.concat(sortedLangLessons(t.id)), []);
            const aiTotalAll = aiLessonsAll.length;
            const aiDoneAll = aiLessonsAll.filter(le => completedLessons.includes(le.id)).length;
            const aiPctAll = aiTotalAll ? Math.round((aiDoneAll / aiTotalAll) * 100) : 0;
            // پێشکەوتنی کارتەکان — glassmorphic bars (per card gradient + glow to match its border)
            const langsCatBar = glassProgressBar(langPctAll, 'from-cyan-400 to-indigo-600', 'rgba(99,102,241,0.55)',
                { labelText: currentLang === 'so' ? `${langDoneAll}/${langTotalAll} وانە تەواو` : `${langDoneAll}/${langTotalAll} وانە دووماهی`, wrapClass: 'mt-auto pt-1 mb-5' });
            const aiCatBarAdmin = glassProgressBar(aiPctAll, 'from-emerald-400 to-cyan-500', 'rgba(16,185,129,0.55)',
                { labelText: currentLang === 'so' ? `${aiDoneAll}/${aiTotalAll} وانە تەواو` : `${aiDoneAll}/${aiTotalAll} وانە دووماهی`, wrapClass: 'mt-auto pt-1 mb-5' });
            const aiCatBarSoon = glassProgressBar(0, 'from-emerald-400 to-cyan-500', 'rgba(16,185,129,0.55)', { soon: true, wrapClass: 'mt-auto pt-1 mb-5' });
            const roboticsCatBar = glassProgressBar(0, 'from-rose-500 to-pink-600', 'rgba(244,63,94,0.55)', { soon: true, wrapClass: 'mt-auto pt-1 mb-5' });
            const langPreview = langIds.slice(0, 6).map(id => {
                const l = languagesData[id];
                const name = loc(l, 'name');
                return `<span class="w-10 h-10 rounded-xl ${l.color || 'bg-blue-100'} flex items-center justify-center text-lg font-black text-gray-800 shadow-inner ring-2 ring-white dark:ring-gray-900 overflow-hidden">${l.logo_url ? `<img src="${l.logo_url}" class="w-full h-full object-contain p-1" alt="${name}">` : (name ? name.charAt(0) : '؟')}</span>`;
            }).join('');
            grid.innerHTML += `
                <div onclick="window.openCategory('langs')" class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 p-10 flex flex-col items-center text-center group hover:-translate-y-2 relative cursor-pointer overflow-hidden h-full">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></div>
                    <div class="flex -space-x-2 mb-8 mt-2">${langPreview || '<span class="text-3xl">💻</span>'}</div>
                    <h3 class="text-3xl font-black mb-3 text-gray-900 dark:text-white">${currentLang === 'so' ? 'زمانەکانی پرۆگرامسازی' : 'زمانێن پرۆگرامسازی'}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose mb-1">${langCount} ${currentLang === 'so' ? 'زمان' : 'زوان'}</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs mb-6">${currentLang === 'so' ? 'بنەڕەتەکانی پرۆگرامسازی فێربە' : 'بنەڕەتێن پرۆگرامسازی فێرببە'}</p>
                    ${langsCatBar}
                    <span class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl font-black text-sm shadow-lg shadow-blue-500/20 group-hover:scale-105 transition-transform">${currentLang === 'so' ? 'بکەرەوە' : 'ڤەکە'}</span>
                </div>
                <div onclick="window.openCategory('ai')" class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 p-10 flex flex-col items-center text-center group hover:-translate-y-2 relative cursor-pointer overflow-hidden h-full">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500"></div>
                    <div class="w-24 h-24 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-[1.5rem] flex items-center justify-center text-6xl mb-8 mt-2 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">🤖</div>
                    <h3 class="text-3xl font-black mb-3 text-gray-900 dark:text-white">${currentLang === 'so' ? 'فێربوونی ژیری دەستکرد' : 'فێربوونا زیرەکیا دەستکرد'}</h3>
                    ${window.isAdmin
                        ? `<p class="text-gray-500 dark:text-gray-400 text-sm leading-loose mb-1">${AI_TOPICS.length} ${currentLang === 'so' ? 'بەش' : 'بەش'} • ${AI_TOPICS.reduce((s, t) => s + sortedLangLessons(t.id).length, 0)} ${currentLang === 'so' ? 'وانە' : 'وانە'}</p>
                           <p class="text-gray-400 dark:text-gray-500 text-xs mb-6">${currentLang === 'so' ? 'داتا، ئالگۆریتم، ML، DL و LLM' : 'داتا، ئالگۆریتم، ML، DL و LLM'}</p>
                           ${aiCatBarAdmin}
                           <span class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-2xl font-black text-sm shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">${currentLang === 'so' ? 'بکەرەوە' : 'ڤەکە'}</span>`
                        : `<p class="text-gray-500 dark:text-gray-400 text-sm leading-loose mb-1">${AI_TOPICS.length} ${currentLang === 'so' ? 'بەش' : 'بەش'} • ${AI_TOPICS.reduce((s, t) => s + sortedLangLessons(t.id).length, 0)} ${currentLang === 'so' ? 'وانە' : 'وانە'}</p>
                           <p class="text-gray-400 dark:text-gray-500 text-xs mb-6">${currentLang === 'so' ? 'داتا، ئالگۆریتم، ML، DL و LLM' : 'داتا، ئالگۆریتم، ML، DL و LLM'}</p>
                           <span class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-2xl font-black text-sm shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition-transform">${currentLang === 'so' ? 'بکەرەوە' : 'ڤەکە'}</span>`
                    }
                </div>
                <div onclick="window.openRoboticsComingSoon()" class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-300 p-10 flex flex-col items-center text-center group hover:-translate-y-2 relative cursor-pointer overflow-hidden h-full">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-rose-500 via-red-500 to-pink-500"></div>
                    <div class="w-24 h-24 bg-gradient-to-br from-rose-500 via-red-500 to-pink-600 rounded-[1.5rem] flex items-center justify-center text-6xl mb-8 mt-2 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">🦾</div>
                    <h3 class="text-3xl font-black mb-3 text-gray-900 dark:text-white">${currentLang === 'so' ? 'ڕۆبۆتیک' : 'ڕۆبۆتیک'}</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose mb-1">${currentLang === 'so' ? 'بەمزووانە بەردەست دەبێت' : 'د نزیکترین دەمی دا بەردەست دبیت'}</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs mb-6">${currentLang === 'so' ? 'ڕۆبۆت، سینسۆر، مایکرۆکۆنترۆلەر و پرۆگرامسازی ڕۆبۆتەکان' : 'ڕۆبۆت، سینسۆر، مایکرۆکۆنترۆلەر و بەرنامەکیرنا ڕۆبۆتان'}</p>
                    ${roboticsCatBar}
                    <span class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-rose-500 to-pink-500 text-white rounded-2xl font-black text-sm shadow-lg shadow-rose-500/20 group-hover:scale-105 transition-transform">${currentLang === 'so' ? 'بەم زوانە بەردەست دەبێت' : 'د ڤێ زوانێ دا دێ بەردەست بیت'}</span>
                </div>`;
        }

        function renderAITopicsGrid() {
            const grid = document.getElementById('languages-grid');
            if (!grid) return;
            const subEl = document.getElementById('category-subtitle');
            if (subEl) subEl.textContent = currentLang === 'so'
                ? 'هەر بەشێک دەکرێتەوە کاتێک بەشەکەی پێشوو تەواو دەبێت — فێربوونێکی ڕیزبەندی کراو.'
                : 'هەر بەشەک دێتە ڤەکرن کەدەمێ بەشەکێ پێشوو دێتە تەمامکرن — فێربوونەکێ ڕێزکرن.';
            grid.innerHTML = '';

            const topics = AI_TOPICS
                .map(t => languagesData[t.id] || t)
                .filter(t => t && t.is_ai)
                .sort((a, b) => (parseInt(a.ai_order, 10) || 0) - (parseInt(b.ai_order, 10) || 0));

            topics.forEach((t, ti) => {
                const grad = t.grad || 'from-emerald-500 to-cyan-500';
                const lessons = sortedLangLessons(t.id);
                const completed = lessons.filter(l => completedLessons.includes(l.id)).length;
                const total = lessons.length;
                const pct = total ? Math.round((completed / total) * 100) : 0;
                const name = loc(t, 'name');
                const desc = loc(t, 'desc');
                const cost = parseInt(t.unlock_cost, 10) || 0;
                const aiOrder = parseInt(t.ai_order, 10) || 0;
                const manuallyLocked = t.locked === true;

                // Determine if course is logically locked (for UI display)
                let logicallyLocked = false;
                if (manuallyLocked) {
                    logicallyLocked = true;
                } else {
                    // Members can access all AI courses
                    if (window.isMember) {
                        logicallyLocked = false;
                    } else {
                        // Sequential locking: Course is locked if previous course is not 100% completed
                        if (aiOrder === 1) {
                            logicallyLocked = false;
                        } else {
                            // Check if previous course is 100% completed
                            const prevCourse = topics.find(tc => parseInt(tc.ai_order, 10) === aiOrder - 1);
                            if (prevCourse) {
                                const prevLessons = sortedLangLessons(prevCourse.id);
                                const prevCompleted = prevLessons.filter(l => completedLessons.includes(l.id)).length;
                                const prevTotal = prevLessons.length;
                                logicallyLocked = !(prevTotal > 0 && prevCompleted === prevTotal);
                            } else {
                                logicallyLocked = true;
                            }
                        }
                    }
                }

                // Admins can access everything, but UI shows lock status based on logicallyLocked
                let isUnlocked = window.isAdmin || !logicallyLocked;
                const isDone = total > 0 && completed === total;
                const openAction = isUnlocked
                    ? `window.openLanguage('${t.id}')`
                    : `window.openAITopicUnlockModal('${t.id}')`;
                // Show lock badge based on logicallyLocked, not isUnlocked (so admins see the lock status too)
                const stateBadge = isDone
                    ? `<div onclick="event.stopPropagation(); window.openLanguage('${t.id}')" class="absolute top-4 right-4 z-20 flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-black shadow-lg bg-gradient-to-r from-emerald-500 to-teal-500 text-white ring-2 ring-white dark:ring-gray-900 hover:scale-105 transition-transform"><span>${badgeMetaFor(t.id).icon}</span>${currentLang === 'so' ? 'تەواو بوو' : 'دووماهی بوو'}</div>`
                    : (!logicallyLocked
                        ? `<div class="absolute top-4 right-4 z-20 flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-black shadow-lg bg-gradient-to-r from-emerald-500 to-cyan-500 text-white ring-2 ring-white dark:ring-gray-900">🔓 ${currentLang === 'so' ? 'کراوە' : 'ڤەکری'}</div>`
                        : `<div class="absolute top-4 right-4 z-20 flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[11px] font-black shadow-lg bg-gradient-to-r from-amber-500 to-yellow-500 text-white ring-2 ring-white dark:ring-gray-900"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V10a2 2 0 00-2-2zm-6 9a2 2 0 110-4 2 2 0 010 4zm3.5-9h-7V6a3.5 3.5 0 117 0v2z"/></svg>${currentLang === 'so' ? 'قفڵکراوە' : 'قفڵکری'}</div>`);
                const costChip = !isUnlocked ? `<span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-black bg-gradient-to-r from-amber-100 to-yellow-100 dark:from-amber-900/40 dark:to-yellow-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-700/50 shadow-sm"><span>🪙</span>${cost} XP</span>` : '';
                const btnText = isDone || isUnlocked
                    ? (currentLang === 'so' ? 'بکەرەوە' : 'ڤەکە')
                    : (currentLang === 'so' ? 'کردنەوە بە پۆینت' : 'ڤەکرن ب پۆینتان');
                grid.innerHTML += `
                    <div onclick="${openAction}" class="ai-topic-card glass-card rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 flex flex-col items-center text-center p-8 pt-0 group hover:-translate-y-2 relative cursor-pointer overflow-hidden ${isUnlocked ? 'ring-2 ring-emerald-300/40' : 'ring-1 ring-amber-200/60 dark:ring-amber-700/40'}" style="animation-delay:${ti * 90}ms">
                        <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r ${grad}"></div>
                        <div class="absolute top-10 -left-10 w-48 h-48 rounded-full bg-gradient-to-br ${grad} opacity-10 blur-2xl group-hover:opacity-25 transition-opacity duration-500"></div>
                        ${stateBadge}
                        <div class="relative mt-10 mb-6">
                            <div class="absolute inset-0 bg-gradient-to-br ${grad} rounded-[1.8rem] blur-xl opacity-30 group-hover:opacity-60 transition-opacity duration-500"></div>
                            <div class="relative w-24 h-24 bg-gradient-to-br ${grad} rounded-[1.8rem] flex items-center justify-center shadow-2xl ring-4 ring-white dark:ring-gray-900 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-500">
                                ${t.logo_url ? `<img src="${t.logo_url}" class="w-full h-full object-contain p-2" alt="${name}">` : `<span class="text-5xl">${t.icon || '🤖'}</span>`}
                                ${logicallyLocked ? `<div class="absolute inset-0 bg-black/40 rounded-[1.8rem] flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M18 8h-1V6a5 5 0 00-10 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V10a2 2 0 00-2-2zm-6 9a2 2 0 110-4 2 2 0 010 4zm3.5-9h-7V6a3.5 3.5 0 117 0v2z"/></svg>
                                </div>` : ''}
                            </div>
                        </div>
                        <h3 class="text-2xl font-black mb-2 text-gray-900 dark:text-white"><bdi>${name}</bdi></h3>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400">📚 ${completed}/${total}</span>
                            ${costChip}
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-loose line-clamp-3 mb-5">${desc}</p>
                        <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden mb-6">
                            <div class="h-full bg-gradient-to-r ${grad} rounded-full transition-all duration-700" style="width:${pct}%; box-shadow:0 0 10px rgba(52,211,153,0.55)"></div>
                        </div>
                        <span class="inline-flex items-center gap-2 px-8 py-3 ${isUnlocked ? 'bg-gradient-to-r ' + grad + ' text-white shadow-lg' : 'bg-gradient-to-r from-amber-500 to-yellow-500 text-white shadow-lg shadow-amber-500/20'} rounded-2xl font-black text-sm group-hover:scale-105 transition-transform">${btnText}</span>
                        ${window.isAdmin ? `
                        <div class="flex items-center gap-2 w-full mt-auto pt-5 border-t border-gray-200/50 dark:border-gray-700/50">
                            <button onclick="event.stopPropagation(); window.toggleAILock('${t.id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 ${isUnlocked ? 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 hover:bg-rose-100 border-rose-200 dark:border-rose-800/50' : 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 hover:bg-emerald-100 border-emerald-200 dark:border-emerald-800/50'} rounded-xl font-bold text-xs transition border">
                                ${isUnlocked 
                                    ? `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>`
                                    : `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>`
                                }
                                ${isUnlocked ? (currentLang === 'so' ? 'قفڵکردن' : 'قفڵکرن') : (currentLang === 'so' ? 'کردنەوە' : 'ڤەکە')}
                            </button>
                            <button onclick="event.stopPropagation(); window.openNewLessonModal('${t.id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 hover:bg-emerald-100 rounded-xl font-bold text-xs transition border border-emerald-200 dark:border-emerald-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                ${currentLang === 'so' ? 'وانە' : 'وانە'}
                            </button>
                            <button onclick="event.stopPropagation(); window.openEditLangModal('${t.id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-xl font-bold text-xs transition border border-amber-200 dark:border-amber-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                ${currentLang === 'so' ? 'دەستکاری' : 'دەستکاریکرن'}
                            </button>
                        </div>` : ''}
                    </div>`;
            });
        }

        // --- کردنەوەی بەشی AI بە سەرفکردنی پۆینت (هەر بەشێک جارێک دەکرێتەوە، وانەکانی بەخۆڕایی) ---
        function showFlash(msg, isError) {
            const container = document.getElementById('xp-notification-container');
            if (!container) return;
            const notif = document.createElement('div');
            notif.className = 'xp-popup ' + (isError ? 'bg-gradient-to-r from-rose-600 to-red-600 text-white' : 'bg-gradient-to-r from-emerald-600 to-teal-500 text-white') + ' px-5 py-3 rounded-2xl shadow-2xl font-bold flex items-center gap-2';
            notif.textContent = msg;
            container.appendChild(notif);
            setTimeout(() => notif.remove(), 3500);
        }

        window.openAITopicUnlockModal = function(topicId) {
            const topic = languagesData[topicId] || null;
            if (!topic) return;
            
            pendingAITopicId = topicId;
            document.getElementById('ai-unlock-title').textContent = loc(topic, 'name');
            document.getElementById('ai-unlock-desc').textContent = currentLang === 'so'
                ? 'ئەم بەشە دەکرێتەوە بە شێوەیەکی دەستکاری. لە دۆخی ئاساییدا، بەشەکان بە ڕیزبەندی دەکرێنەوە.'
                : 'ئەڤ بەشە دێتە ڤەکرن ب شێوەیێ دەستکاری. د دۆخی ئاسایی دا، بەشان ب ڕێزکرن دێن ڤەکرن.';
            document.getElementById('ai-unlock-cost').textContent = '🔓 دەستکاری';
            document.getElementById('ai-unlock-confirm-btn').textContent = currentLang === 'so' ? 'بەڵێ، بیکەرەوە' : 'بەلێ، ڤەکە';
            const m = document.getElementById('ai-unlock-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        };

        window.toggleAILock = function(topicId) {
            if (aiUnlocked[topicId]) {
                delete aiUnlocked[topicId];
            } else {
                aiUnlocked[topicId] = true;
            }
            saveAIUnlocked();
            saveProgressToFirebase();
            renderAITopicsGrid();
        };

        window.closeAIUnlockModal = function() {
            const m = document.getElementById('ai-unlock-modal');
            if (!m) return;
            m.classList.add('hidden');
            m.classList.remove('flex');
            pendingAITopicId = null;
        };

        window.confirmAIUnlock = function() {
            const id = pendingAITopicId;
            if (!id) return;
            const topic = languagesData[id];
            if (!topic) return;
            const cost = parseInt(topic.unlock_cost, 10) || 0;
            if (userXP < cost) {
                closeAIUnlockModal();
                showFlash(currentLang === 'so' ? '⚠️ پۆینتی تەمام نییە!' : '⚠️ پۆینتێن تەمام نینە!', true);
                return;
            }
            userXP -= cost;
            aiUnlocked[id] = true;
            saveAIUnlocked();
            updateStatsUI();
            saveProgressToFirebase();
            showXPNotification(-cost);
            closeAIUnlockModal();
            try { triggerConfetti(); } catch(e) { console.error('[ferga] unlock confetti failed', e); }
            showFlash(currentLang === 'so' ? '🎉 بەشەکەت کرایەوە — وانەکانی بەخۆڕایی فێربە!' : '🎉 بەش هاتە ڤەکرن — وانەیێن وێ بەلاش فێر ببە!');
            renderHome();
            window.openLanguage(id);
        };

        window.toggleLanguageLock = async function(id) {
            const l = languagesData[id];
            if (!l) return;
            const next = !(l.locked === true);
            await update(dbRef(db, 'ferga_languages/' + id), { locked: next });
            renderHome();
            const notif = document.createElement('div');
            notif.className = 'xp-popup bg-gradient-to-r from-emerald-600 to-teal-500 text-white px-6 py-3 rounded-2xl shadow-2xl font-bold flex items-center gap-2';
            notif.innerHTML = next
                ? (currentLang === 'so' ? '🔒 زمانەکە قفڵکرا' : '🔒 زمان قفڵکر')
                : (currentLang === 'so' ? '🔓 زمانەکە کرایەوە' : '🔓 زمان هاتە ڤەکرن');
            document.getElementById('xp-notification-container').appendChild(notif);
            setTimeout(() => notif.remove(), 2500);
        };

        window.openMembershipModal = function(langId) {
            const l = languagesData[langId];
            if(!l) return;
            document.getElementById('member-modal-lang').innerText = (loc(l, 'name') || '');
            const m = document.getElementById('member-modal');
            m.classList.remove('hidden');
            m.classList.add('flex');
        };

        window.closeMembershipModal = function() {
            const m = document.getElementById('member-modal');
            m.classList.add('hidden');
            m.classList.remove('flex');
        };

        async function refreshMembersList() {
            const listEl = document.getElementById('members-list');
            if(!listEl) return;
            listEl.innerHTML = '<p class="text-gray-400 text-sm text-center p-3">...</p>';
            let snap;
            try {
                snap = await get(query(dbRef(db, 'users'), orderByChild('is_member'), equalTo(true)));
            } catch(e) { snap = null; }
            listEl.innerHTML = '';
            if(snap && snap.exists()) {
                let any = false;
                snap.forEach(child => {
                    any = true;
                    const uid = child.key;
                    const email = child.val().email || uid;
                    listEl.innerHTML += `
                        <div class="flex justify-between items-center p-3 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-amber-200/60 dark:border-amber-700/40">
                            <span class="font-bold text-sm flex items-center gap-2">👑 <span dir="ltr">${email}</span></span>
                            <button onclick="setMember('${uid}', false)" class="text-red-500 font-bold text-xs bg-red-50 dark:bg-red-900/20 hover:bg-red-100 px-3 py-1.5 rounded-lg">سڕینەوە</button>
                        </div>`;
                });
                if(!any) listEl.innerHTML = '<p class="text-gray-400 text-sm text-center p-3">هیچ ئەندامێک نییە</p>';
            } else {
                listEl.innerHTML = '<p class="text-gray-400 text-sm text-center p-3">هیچ ئەندامێک نییە</p>';
            }
        }

        window.setMember = async function(uid, make) {
            if(!uid) return;
            await set(dbRef(db, `users/${uid}/is_member`), make);
            refreshMembersList();
        };

        window.addMemberByEmail = async function(make) {
            const email = document.getElementById('member_email_input').value.trim();
            if(!email) { alert(currentLang === 'so' ? 'ئیمەیڵ بنووسە' : 'ئیمەیڵێ بنڤیسە'); return; }
            const snap = await get(dbRef(db, 'user_index/' + safeEmailKey(email)));
            if(!snap.exists()) {
                alert(currentLang === 'so' ? 'ئەم ئیمەیڵە نەدۆزرایەوە — بەکارهێنەرەکە دەبێت یەک جار هاتووتبێتە ناو سایتەکە' : 'ئەڤ ئیمەیڵە نەهاتە دیتن — دڤێت بەکارهێنەر یەک جار هاتیبیتە ناڤ سایت');
                return;
            }
            await set(dbRef(db, `users/${snap.val().uid}/is_member`), make);
            document.getElementById('member_email_input').value = '';
            refreshMembersList();
        };

        // دروستکردنەوەی سایدبار بەپێی ئاستەکان — بۆ ئەوەی وانەی تەواوکراو یەکسەر کراوە بێت
        function renderSidebar() {
            const sidebar = document.getElementById('sidebar-content');
            if (!sidebar || currentLessonArray.length === 0) return;
            const grouped = {};
            currentLessonArray.forEach(l => { const lvl = loc(l, 'level'); if(!grouped[lvl]) grouped[lvl] = []; grouped[lvl].push(l); });
            let htmlStr = '';
            for (let level in grouped) {
                htmlStr += `<div class="mb-4 px-2 text-xs font-bold text-gray-400 dark:text-gray-500 tracking-widest mt-6">${level}</div><div class="relative pl-3 border-r-2 border-gray-100 dark:border-gray-800 mr-3">`;
                grouped[level].forEach(lesson => {
                    const index = currentLessonArray.indexOf(lesson);
                    const isCompleted = completedLessons.includes(lesson.id);
                    const isLocked = !lessonIndexUnlocked(index);
                    
                    let dotClass = isLocked ? 'locked' : (isCompleted ? 'completed' : 'current');
                    let btnClass = isLocked ? 'locked-lesson' : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300';
                    let clickAction = isLocked ? '' : `loadLesson(${index})`;

                    htmlStr += `
                        <div class="relative flex items-center gap-2 mb-2 group">
                            <div class="absolute -right-[1.1rem] timeline-dot ${dotClass}"></div>
                            <button id="sidebar-btn-${index}" onclick="${clickAction}" class="w-full text-right flex justify-between items-center px-4 py-3 text-[14px] font-bold rounded-xl transition-all ${btnClass}">
                                <span class="truncate">${isLocked ? '🔒 ' : ''}${loc(lesson, 'title')}</span>
                                ${isCompleted ? '<svg class="w-4 h-4 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' : ''}
                            </button>
                            ${window.isAdmin ? `
                            <button onclick="event.stopPropagation(); window.openEditLessonModal('${lesson.id}')" class="shrink-0 w-9 h-9 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 transition border border-amber-200 dark:border-amber-800/50" title="${currentLang === 'so' ? 'دەستکاری وانە' : 'دەستکاریکرنا وانەیێ'}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>` : ''}
                        </div>`;
                });
                htmlStr += `</div>`;
            }
            sidebar.innerHTML = htmlStr;
            const activeBtn = document.getElementById(`sidebar-btn-${currentLessonIndex}`);
            if (activeBtn && !activeBtn.classList.contains('locked-lesson')) {
                activeBtn.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
            }
        }

        window.openLanguage = function(langId, forcedIndex = null) {
            currentActiveLanguage = { id: langId, ...languagesData[langId] };
            document.getElementById('home-view').classList.add('hidden');
            document.getElementById('learning-view').classList.remove('hidden');
            document.getElementById('learning-view').classList.add('flex');
            
            let langLessons = sortedLangLessons(langId);
            
            const grouped = {};
            langLessons.forEach(l => { const lvl = loc(l, 'level'); if(!grouped[lvl]) grouped[lvl] = []; grouped[lvl].push(l); });

            currentLessonArray = [];
            for (let level in grouped) {
                grouped[level].forEach(lesson => currentLessonArray.push(lesson));
            }
            renderSidebar();

            currentLangExt = (currentActiveLanguage.ext) ? currentActiveLanguage.ext.replace('.','').toLowerCase() : guessExtFromName(loc(currentActiveLanguage, 'name'));
            if (isCombinedWebMode()) {
                document.getElementById('code-filename-label').textContent = 'index.html';
                document.getElementById('compiler-filename-label').textContent = 'index.html';
            } else {
                document.getElementById('code-filename-label').textContent = 'main.' + currentLangExt;
                document.getElementById('compiler-filename-label').textContent = 'main.' + currentLangExt;
            }
            
            if (currentLessonArray.length > 0) {
                let targetIdx = forcedIndex;
                if (targetIdx === null || targetIdx === undefined) {
                    // هێنانەوەی ئایدی وانەکە بەپێی ئەو زمانەی کە تێیدایە (چێک پۆینت) — ئەکاونت (ئیمەیڵ) یەکەمە
                    let savedLessonId = null;
                    if (lessonProgress[langId]) savedLessonId = lessonProgress[langId].lastLessonId || null;
                    if (!savedLessonId) {
                        try { savedLessonId = localStorage.getItem('ferga_last_lesson_' + langId); } catch(e) { savedLessonId = null; }
                    }

                    if (savedLessonId) {
                        targetIdx = currentLessonArray.findIndex(l => l.id === savedLessonId);
                    }

                    // دۆزینەوەی یەکەم وانە کە تەواو نەکراوە
                    let firstUncompleted = currentLessonArray.findIndex(l => !completedLessons.includes(l.id));
                    if (firstUncompleted === -1) firstUncompleted = currentLessonArray.length - 1;

                    if (targetIdx === null || targetIdx === undefined || targetIdx === -1) {
                        targetIdx = firstUncompleted;
                    } else if (targetIdx > firstUncompleted) {
                        // ئەگەر وانە سەیڤ کراوەکە لە پێشەوەی وانە تەواونەکراوەکان بوو (واتە قفڵ بوو)، بیگەڕێنەوە بۆ یەکەم وانەی تەواونەکراو
                        targetIdx = firstUncompleted;
                    }
                }
                if (targetIdx < 0 || targetIdx >= currentLessonArray.length) targetIdx = 0;
                loadLesson(targetIdx);
                if (forcedIndex === null || forcedIndex === undefined) {
                    const resumedLesson = currentLessonArray[targetIdx];
                    if (resumedLesson) {
                        setSaveStatus('بەردەوامبوون لە وانەی: ' + loc(resumedLesson, 'title'));
                    }
                }
            }
        };

        window.lessonQuestionType = function(lesson) {
            if (!lesson) return 'none';
            if (lesson.quiz_type) return lesson.quiz_type;
            if ((lesson.quiz_question_so && lesson.quiz_question_so.trim()) || (lesson.quiz_question_ba && lesson.quiz_question_ba.trim())) return 'choice';
            const challenge = loc(lesson, 'challenge_desc');
            // تەنها ئەگەر مەشقێک هەیە (وەسفەکەی) وەک پرسیاری کۆد دادەنرێت — ئەگەر هەر `expected_output` بەجێماو بێت بێ وەسف، قفڵی ناکات
            if (challenge && lesson.expected_output) return 'code';
            if (lesson.challenge_desc_so || lesson.challenge_desc_ba) return 'code';
            return 'none';
        };

        window.getLessonQuiz = function(lesson) {
            if (!lesson) return null;
            if ((lesson.quiz_question_so && lesson.quiz_question_so.trim()) || (lesson.quiz_question_ba && lesson.quiz_question_ba.trim())) {
                return {
                    question_so: lesson.quiz_question_so || '',
                    question_ba: lesson.quiz_question_ba || '',
                    options_so: Array.isArray(lesson.quiz_options_so) ? lesson.quiz_options_so : [],
                    options_ba: Array.isArray(lesson.quiz_options_ba) ? lesson.quiz_options_ba : [],
                    correct: lesson.quiz_correct !== undefined && lesson.quiz_correct !== null ? String(lesson.quiz_correct) : '0',
                    code: lesson.quiz_code || ''
                };
            }
            if (quizzesData && typeof quizzesData === 'object') {
                for (let id in quizzesData) {
                    const q = quizzesData[id];
                    if (q && q.lessonId === lesson.id) return q;
                }
            }
            return null;
        };

        window.hasLessonQuestion = function(lesson) {
            return window.lessonQuestionType(lesson) !== 'none';
        };

        window.openLessonQuestion = function() {
            const lesson = lessonsData[window.currentLessonId];
            if (!lesson) return;
            if (window.lessonQuestionType(lesson) === 'code') {
                window.openTryItYourself();
            } else {
                const quiz = window.getLessonQuiz(lesson);
                if (quiz) window.startQuiz([quiz], lesson.id);
            }
        };

        window.goBackToHome = function() {
            clearLocalResume();
            document.getElementById('learning-view').classList.add('hidden');
            document.getElementById('learning-view').classList.remove('flex');
            document.getElementById('home-view').classList.remove('hidden');
            window.scrollTo(0, 0);
            if (typeof renderHome === 'function') renderHome();
        };

        // --- قفڵی ڕیزبەندی (Sequential Unlock) ---
        // وانە تەنها دەکرێتەوە ئەگەر هەموو وانەکانی پێشتر تەواو کرابێتن
        function lessonIndexUnlocked(index) {
            if (!currentLessonArray.length) return true;
            if (index <= 0) return true;
            for (let i = 0; i < index; i++) {
                if (!completedLessons.includes(currentLessonArray[i].id)) return false;
            }
            return true;
        }
        function firstUnlockedIndex() {
            for (let i = 0; i < currentLessonArray.length; i++) {
                if (lessonIndexUnlocked(i)) return i;
            }
            return 0;
        }

        window.loadLesson = function(index) {
            // قفڵی یەک بە یەک: نابێت وانەیەکی قفڵکراو بکرێتەوە (بۆ ئەدمین ڕێگە دراوە)
            if (!window.isAdmin && index > 0 && !lessonIndexUnlocked(index)) {
                index = firstUnlockedIndex();
            }
            currentLessonIndex = index;
            const lesson = currentLessonArray[index];
            window.currentLessonId = lesson.id;
            trackLessonVisit();
            
            document.querySelectorAll('[id^="sidebar-btn-"]').forEach(el => el.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm'));
            const activeBtn = document.getElementById(`sidebar-btn-${index}`);
            if(activeBtn && !activeBtn.classList.contains('locked-lesson')) {
                activeBtn.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-600', 'dark:text-blue-400', 'shadow-sm');
            }

            document.getElementById('display-title').innerHTML = loc(lesson, 'title');
            document.getElementById('display-content').innerHTML = loc(lesson, 'content');
            
            // Challenge Handling
            const questionType = window.lessonQuestionType(lesson);
            const hasChallenge = questionType !== 'none';
            const isCompleted = completedLessons.includes(lesson.id);

            if (hasChallenge) {
                document.getElementById('challenge-container').classList.remove('hidden');
                if (questionType === 'choice' || questionType === 'output') {
                    const quiz = window.getLessonQuiz(lesson);
                    document.getElementById('challenge-text').innerHTML = loc(lesson, 'quiz_question') || (quiz ? (currentLang === 'so' ? quiz.question_so : quiz.question_ba) : '');
                    document.getElementById('btn-submit-challenge').classList.add('hidden');
                    const btnOpen = document.getElementById('btn-challenge-open');
                    if (btnOpen) {
                        btnOpen.classList.remove('hidden');
                        const btnText = document.getElementById('btn-challenge-open-text');
                        const icon = document.getElementById('btn-challenge-open-icon');
                        if (btnText) {
                            btnText.setAttribute('data-so', 'کردنەوەی پرسیارەکە');
                            btnText.setAttribute('data-ba', 'ڤەکرنا پرسیارێ');
                            btnText.textContent = currentLang === 'so' ? 'کردنەوەی پرسیارەکە' : 'ڤەکرنا پرسیارێ';
                        }
                        if (icon) icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>';
                    }
                    const attemptsNote = document.getElementById('challenge-attempts-note');
                    if (attemptsNote) attemptsNote.textContent = '';
                } else {
                    document.getElementById('challenge-text').innerHTML = loc(lesson, 'challenge_desc');
                    document.getElementById('btn-submit-challenge').classList.remove('hidden');
                    const btnOpen = document.getElementById('btn-challenge-open');
                    if (btnOpen) {
                        btnOpen.classList.remove('hidden');
                        const btnText = document.getElementById('btn-challenge-open-text');
                        const icon = document.getElementById('btn-challenge-open-icon');
                        if (btnText) {
                            btnText.setAttribute('data-so', 'کردنەوەی سەکۆی کۆدکردن');
                            btnText.setAttribute('data-ba', 'ڤەکرنا سەکۆیێ کۆدکرنێ');
                            btnText.textContent = currentLang === 'so' ? 'کردنەوەی سەکۆی کۆدکردن' : 'ڤەکرنا سەکۆیێ کۆدکرنێ';
                        }
                        if (icon) icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>';
                    }
                    const attemptsNote = document.getElementById('challenge-attempts-note');
                    if (attemptsNote) {
                        const maxA = parseInt(lesson.max_attempts, 10) || 5;
                        const canShow = lesson.allow_show_answer !== false;
                        attemptsNote.innerHTML = (currentLang === 'so'
                            ? `🧪 ${maxA} هەوڵت هەیە — لە دوای ئەوە وەڵامەکە نیشان دەدرێت${canShow ? ' · بە دوگمەی «نیشاندانی وەڵام» دەتوانیت کۆدەکە ببینیت' : ''}`
                            : `🧪 ${maxA} هەوڵێت تە هەن — پاشی وەکێ بەرسڤ تێ دەچیتە نیشاندان${canShow ? ' · ب دگمەکا «نیشاندانا بەرسڤێ» تۆ دکەی کۆدێ ببینی' : ''}`);
                    }
                }

                document.getElementById('btn-action').classList.remove('hidden');
            } else {
                document.getElementById('challenge-container').classList.add('hidden');
                document.getElementById('btn-submit-challenge').classList.add('hidden');
                document.getElementById('btn-challenge-open').classList.add('hidden');
                const attemptsNote = document.getElementById('challenge-attempts-note');
                if (attemptsNote) attemptsNote.textContent = '';
                document.getElementById('btn-action').classList.remove('hidden');
            }

            if (lesson.code && lesson.code.trim() !== '') {
                document.getElementById('display-code-box').classList.remove('hidden');
                const hasCss = lesson.code_css && lesson.code_css.trim() !== '';
                const htmlLesson = hasCss ? Object.assign({}, lesson, { code_explain_so: [], code_explain_ba: [] }) : lesson;
                renderCodeExplanations(document.getElementById('display-code'), htmlLesson);
            } else {
                document.getElementById('display-code-box').classList.add('hidden');
            }

            if (lesson.code_css && lesson.code_css.trim() !== '') {
                document.getElementById('display-css-code-box').classList.remove('hidden');
                renderCodeExplanations(document.getElementById('display-css-code'), Object.assign({}, lesson, { code: lesson.code_css }));
            } else {
                document.getElementById('display-css-code-box').classList.add('hidden');
            }

            // HTML + CSS: ئەنجامەکە بەشێوەی بڕاوسەر — لە خوارەوەی کۆدەکە
            const renderExt = currentLangExtValue();
            const isWebRender = (isCombinedWebMode() || renderExt === 'html' || renderExt === 'htm') && lesson.code && lesson.code.trim() !== '';
            const webPreviewBox = document.getElementById('display-web-preview-box');
            if (isWebRender) {
                let combined = lesson.code;
                if (lesson.code_css && lesson.code_css.trim()) {
                    if (/<\/head>/i.test(combined)) {
                        combined = combined.replace(/<\/head>/i, `<style>\n${lesson.code_css}\n</style>\n</head>`);
                    } else {
                        combined += `\n<style>\n${lesson.code_css}\n</style>`;
                    }
                }
                const pv = document.getElementById('display-web-preview');
                if (pv) pv.srcdoc = combined;
                if (webPreviewBox) webPreviewBox.classList.remove('hidden');
            } else {
                if (webPreviewBox) webPreviewBox.classList.add('hidden');
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

            // سەرەتای وانەکە پیشان بدە بۆ ئەوەی ناوەڕۆکەکە (باسکردنەکە) دیار بێت — سکرۆڵەکە لەناو main دایە
            const lessonMain = document.getElementById('lesson-main');
            if (lessonMain) lessonMain.scrollTop = 0;
            window.scrollTo(0, 0);
        };

        function showMustAnswerChallengeMessage() {
            const container = document.getElementById('xp-notification-container');
            const notif = document.createElement('div');
            notif.className = 'xp-popup bg-gradient-to-r from-red-600 to-amber-600 text-white px-6 py-3 rounded-2xl shadow-2xl font-bold flex items-center gap-2';
            notif.innerHTML = currentLang === 'so'
                ? '⚠️ پێویستە پرسیارەکە جواب بدەیتەوە بۆ وانەی داهاتوو'
                : '⚠️ دڤێت بەرسڤا پرسیارێ بدەی ژبو وانەیا بهێت';
            container.appendChild(notif);
            setTimeout(() => notif.remove(), 3500);

            const cc = document.getElementById('challenge-container');
            if (cc) {
                cc.scrollIntoView({ behavior: 'smooth', block: 'center' });
                cc.classList.add('ring-4', 'ring-red-500');
                setTimeout(() => cc.classList.remove('ring-4', 'ring-red-500'), 3500);
            }
        }

        // بۆ وانەی داهاتوو دەڕوات — بەشێکی یەکگرتوو بۆ هەموو شوێنەکان
        window.goToNextLesson = function() {
            if (!currentActiveLanguage || !currentActiveLanguage.id) return;
            let nextIdx = currentLessonIndex + 1;
            if (nextIdx >= currentLessonArray.length) nextIdx = currentLessonArray.length - 1;
            openLanguage(currentActiveLanguage.id, nextIdx);
        };

        window.handleNextAction = function() {
            const lesson = currentLessonArray[currentLessonIndex];
            if (!lesson) {
                console.error('[ferga] handleNextAction: no lesson at index', currentLessonIndex);
                return;
            }
            const hasChallenge = window.hasLessonQuestion(lesson);
            const lessonId = lesson.id;
            const isCompleted = completedLessons.includes(lessonId);

            // Check if this is an AI lesson - no XP for AI lessons
            const isAILesson = currentActiveLanguage && currentActiveLanguage.is_ai === true;

            if (!isCompleted) {
                if (hasChallenge) {
                    showMustAnswerChallengeMessage();
                    return;
                }
                window.markLessonCompleted(lessonId, !isAILesson, isAILesson ? 0 : 20);
            }
            window.goToNextLesson();
        };

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

        function escapeHtml(s) {
            return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        // --- Quiz Logic ---
        let activeQuizQuestions = []; let activeQuizIndex = 0; let activeQuizScore = 0; let activeLessonIdToComplete = null; let selectedOptionForCurrent = null; let quizAnswered = false;
        // هەڵبژاردە ڕاستەقینەکان (دواتر بۆ 0-based و یەکخستنی ئیندێکس)
        let activeQuizOptions = [];

        // دیاریکردنی بەهای ڕاستەکە بە شێوەیەکی بەرگریکار — ژمارە (0-based) یان پیت (a/b/c/d)
        function resolveCorrectIndex(q) {
            if (!q) return 0;
            const raw = q.correct;
            if (raw === undefined || raw === null || raw === '') return 0;
            const c = String(raw).trim().toLowerCase();
            const letterMap = { a: 0, b: 1, c: 2, d: 3, 'ئە': 0, 'ا': 0, 'أ': 0, 'آ': 0, 'ب': 1, 'ج': 2, 'د': 3, 'پ': 4, 'ت': 5 };
            if (letterMap[c] !== undefined) return letterMap[c];
            const num = parseInt(c, 10);
            return isNaN(num) ? 0 : num;
        }

        window.startQuiz = function(questions, lessonId) {
            activeQuizQuestions = questions; activeQuizIndex = 0; activeQuizScore = 0; activeLessonIdToComplete = lessonId; quizAnswered = false;
            document.getElementById('quiz-modal').classList.remove('hidden'); document.getElementById('quiz-modal').classList.add('flex');
            const qm = document.getElementById('quiz-modal');
            if (qm) { try { qm.scrollTop = 0; } catch(e) {} }
            document.getElementById('quiz-content').classList.remove('hidden'); document.getElementById('quiz-footer').classList.remove('hidden'); document.getElementById('quiz-result').classList.add('hidden');
            const notice = document.getElementById('quiz-notice');
            if (notice) notice.classList.remove('hidden');
            renderQuizQuestion();
        };

        function renderQuizQuestion() {
            const q = activeQuizQuestions[activeQuizIndex];
            selectedOptionForCurrent = null;
            quizAnswered = false;
            const qmEl = document.getElementById('quiz-modal');
            if (qmEl) { try { qmEl.scrollTop = 0; } catch(e) {} }
            document.getElementById('quiz-progress-bar').style.width = `${((activeQuizIndex) / activeQuizQuestions.length) * 100}%`;
            document.getElementById('quiz-counter').innerText = `${activeQuizIndex + 1} / ${activeQuizQuestions.length}`;
            document.getElementById('quiz-question-text').innerText = currentLang === 'so' ? q.question_so : q.question_ba;
            const quizCodeBlock = document.getElementById('quiz-code-block');
            const quizCodePre = document.getElementById('quiz-code-pre');
            if (quizCodeBlock && quizCodePre) {
                const codeVal = (q && q.code && String(q.code).trim()) ? String(q.code) : '';
                if (codeVal) {
                    quizCodeBlock.classList.remove('hidden');
                    quizCodePre.textContent = codeVal;
                } else {
                    quizCodeBlock.classList.add('hidden');
                }
            }
            const feedback = document.getElementById('quiz-feedback');
            if (feedback) { feedback.classList.add('hidden'); feedback.textContent = ''; }
            
            const optionsContainer = document.getElementById('quiz-options');
            optionsContainer.innerHTML = '';
            const rawOptions = currentLang === 'ba' && q.options_ba && q.options_ba.length ? q.options_ba : q.options_so || q.options || [];
            // تەنها بژاردە پڕەکان نیشان دەدرێن (بۆ ئەوەی خانە بەتاڵەکان ئەنیکەنەوە)
            activeQuizOptions = [];
            rawOptions.forEach((opt, i) => {
                if (opt && String(opt).trim() !== '') activeQuizOptions.push({ text: opt, origIdx: i });
            });
            
            activeQuizOptions.forEach((opt, idx) => {
                optionsContainer.innerHTML += `
                    <div onclick="selectQuizOption(${idx})" id="opt-${idx}" class="quiz-option cursor-pointer border-2 border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30 rounded-2xl p-5 text-lg font-bold text-gray-700 dark:text-gray-300 hover:border-blue-300 transition-all flex items-center gap-4">
                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center shrink-0 indicator-circle"></div>
                        <span class="min-w-0">${escapeHtml(opt.text)}</span>
                    </div>`;
            });
            
            const nextBtn = document.getElementById('btn-next-question');
            if (activeQuizOptions.length === 0) {
                // هیچ بژاردەیەک نییە — وانەکە تەواو دەکرێت و وانەی داهاتوو دەکرێتەوە
                if (feedback) {
                    feedback.classList.remove('hidden');
                    feedback.className = 'mt-6 rounded-xl px-4 py-3 text-lg font-black text-center bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300 border-2 border-amber-300 dark:border-amber-700/60';
                    feedback.textContent = currentLang === 'so' ? '⚠️ هیچ هەڵبژاردنێک نییە — وانەکە تەواو دەبێت' : '⚠️ چ هەلبژارتنەک نینە — وانە دبیتە دووماهی';
                }
                nextBtn.setAttribute('onclick', 'finishQuizAndContinue()');
                nextBtn.disabled = false; nextBtn.className = "bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg cursor-pointer transition-all";
                nextBtn.textContent = currentLang === 'so' ? 'بڕۆ بۆ وانەی داهاتوو' : 'هەڕە بۆ وانەیا داهاتی';
                try {
                    const lid = activeLessonIdToComplete || (currentLessonArray[currentLessonIndex] && currentLessonArray[currentLessonIndex].id);
                    if (lid && !completedLessons.includes(lid)) window.markLessonCompleted(lid, true, 20);
                } catch(e) { console.error('[ferga] auto-complete no options failed', e); }
            } else {
                nextBtn.setAttribute('onclick', 'nextQuestion()');
                nextBtn.disabled = true; nextBtn.className = "bg-gray-200 dark:bg-gray-800 text-gray-500 px-8 py-3.5 rounded-2xl font-bold cursor-not-allowed transition-all";
                nextBtn.textContent = currentLang === 'so' ? 'دواتر' : 'داهاتی';
            }
        }

        window.selectQuizOption = function(idx) {
            if (quizAnswered) return;
            selectedOptionForCurrent = idx;
            quizAnswered = true;
            const q = activeQuizQuestions[activeQuizIndex];
            const correctResolved = resolveCorrectIndex(q);
            const origIdx = (activeQuizOptions[idx] && activeQuizOptions[idx].origIdx) || idx;
            const isCorrect = origIdx === correctResolved;
            if (isCorrect) activeQuizScore++;

            try {
                // بڕیار لە وەڵامەکە دەدرێت: ڕێگە بە کلیکێکی تر نادرێت
                document.querySelectorAll('.quiz-option').forEach(el => {
                    el.classList.remove('selected', 'option-correct', 'option-wrong');
                    el.style.pointerEvents = 'none';
                    const circle = el.querySelector('.indicator-circle');
                    circle.innerHTML = '';
                    circle.classList.remove('border-blue-500', 'bg-blue-500', 'border-green-500', 'bg-green-500', 'border-red-500', 'bg-red-500');
                });

                // وەڵامە ڕاستەکە بە سەوز دیاری دەکرێت
                const correctRenderIdx = activeQuizOptions.findIndex(o => o.origIdx === correctResolved);
                const correctEl = document.getElementById(`opt-${correctRenderIdx}`);
                if (correctEl) {
                    correctEl.classList.add('option-correct');
                    const cCircle = correctEl.querySelector('.indicator-circle');
                    cCircle.classList.add('border-green-500', 'bg-green-500');
                    cCircle.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
                }

                // ئەگەر وەڵامەکە هەڵە بوو، وەڵامی هەڵبژێردراو بە سوور دیاری دەکرێت
                const feedback = document.getElementById('quiz-feedback');
                if (isCorrect) {
                    if (feedback) {
                        feedback.classList.remove('hidden');
                        feedback.className = 'mt-6 rounded-xl px-4 py-3 text-lg font-black text-center bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 border-2 border-emerald-300 dark:border-emerald-700/60';
                        feedback.textContent = currentLang === 'so' ? '✅ وەڵامەکەت دروستە!' : '✅ بەرسڤا تە ڕاستە!';
                    }
                } else {
                    const wrongEl = document.getElementById(`opt-${idx}`);
                    if (wrongEl) {
                        wrongEl.classList.add('option-wrong');
                        const wCircle = wrongEl.querySelector('.indicator-circle');
                        wCircle.classList.add('border-red-500', 'bg-red-500');
                        wCircle.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 6l12 12M18 6L6 18"></path></svg>';
                    }
                    if (feedback) {
                        feedback.classList.remove('hidden');
                        feedback.className = 'mt-6 rounded-xl px-4 py-3 text-lg font-black text-center bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-300 border-2 border-rose-300 dark:border-rose-700/60';
                        feedback.textContent = currentLang === 'so' ? '❌ وەڵامەکەت هەڵەیە!' : '❌ بەرسڤا تە خەلەتە!';
                    }
                }
            } catch(e) { console.error('[ferga] quiz feedback UI failed', e); }

            // دوای وەڵامدانەوە، بۆ وانەی داهاتوو دەچێت — هەمیشە دەبێت کار بکات
            const nextBtn = document.getElementById('btn-next-question');
            if (nextBtn) {
                // لابردنی lang-str تا applyLanguage نەتوانێت دەقەکە بگەڕێنێتەوە بۆ «دواتر»
                nextBtn.classList.remove('lang-str');
                nextBtn.removeAttribute('data-so');
                nextBtn.removeAttribute('data-ba');
                nextBtn.setAttribute('onclick', 'finishQuizAndContinue()');
                nextBtn.disabled = false; nextBtn.className = "bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg cursor-pointer transition-all";
                nextBtn.textContent = currentLang === 'so' ? 'بڕۆ بۆ وانەی داهاتوو' : 'هەڕە بۆ وانەیا داهاتی';
                // پەڕە دان بۆ خوارەوە تا دوگمەی «وانەی داهاتوو» دیار بێت (بۆ مۆبایل و لاپتۆپ)
                try {
                    const quizModalEl = document.getElementById('quiz-modal');
                    if (quizModalEl) quizModalEl.scrollTo({ top: quizModalEl.scrollHeight, behavior: 'smooth' });
                } catch(e) {}
            }

            // وانەکە تەواو دەکرێت (XP تەنها ئەگەر وەڵامەکە دروست بوو) — ڕاست یان هەڵە، هەردووکیان بۆ وانەی داهاتوو دەڕوان
            try {
                const lessonIdToComplete = activeLessonIdToComplete || (currentLessonArray[currentLessonIndex] && currentLessonArray[currentLessonIndex].id);
                if(lessonIdToComplete && !completedLessons.includes(lessonIdToComplete)) {
                    console.log('[ferga] choice answered, completing lesson', lessonIdToComplete, 'correct =', isCorrect);
                    // Check if this is an AI lesson - no XP for AI lessons
                    const isAILesson = currentActiveLanguage && currentActiveLanguage.is_ai === true;
                    window.markLessonCompleted(lessonIdToComplete, isAILesson ? true : isCorrect, isAILesson ? 0 : 50);
                }
            } catch(e) { console.error('[ferga] markLessonCompleted failed', e); }
        };

        window.nextQuestion = function() {
            if(selectedOptionForCurrent === null || quizAnswered) return;
            const q = activeQuizQuestions[activeQuizIndex];
            const origIdx = (activeQuizOptions[selectedOptionForCurrent] && activeQuizOptions[selectedOptionForCurrent].origIdx) || selectedOptionForCurrent;
            if(origIdx === resolveCorrectIndex(q)) activeQuizScore++;
            activeQuizIndex++;
            if(activeQuizIndex < activeQuizQuestions.length) renderQuizQuestion();
            else showQuizResult();
        };

        function showQuizResult() {
            document.getElementById('quiz-progress-bar').style.width = `100%`;
            document.getElementById('quiz-content').classList.add('hidden'); document.getElementById('quiz-footer').classList.add('hidden'); document.getElementById('quiz-result').classList.remove('hidden');
            const notice = document.getElementById('quiz-notice');
            if (notice) notice.classList.add('hidden');
            
            const percent = Math.round((activeQuizScore / activeQuizQuestions.length) * 100);
            document.getElementById('quiz-score-text').innerText = currentLang === 'so' ? `تۆ وەڵامی ${activeQuizScore} پرسیارت بە دروستی دایەوە (${percent}%)` : `تە بەرسڤا ${activeQuizScore} پرسیاران ب دروستی دا (${percent}%)`;
            
            if(!completedLessons.includes(activeLessonIdToComplete)) {
                let giveXP = activeQuizScore > 0;
                window.markLessonCompleted(activeLessonIdToComplete, giveXP, 50);
            }
        }

        window.finishQuizAndContinue = function() {
            const modal = document.getElementById('quiz-modal');
            if (modal) { modal.classList.add('hidden'); modal.classList.remove('flex'); }
            window.goToNextLesson();
        };

        // --- Admin Logic ---
        const tabs = ['lang', 'lesson', 'manage'];
        window.switchAdminTab = async function(tabName) {
            tabs.forEach(x => {
                document.getElementById(`tab-btn-${x}`).className = "px-6 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-bold";
                if(x === 'manage') document.getElementById(`tab-btn-${x}`).className = "px-6 py-2 bg-red-100 text-red-600 rounded-lg font-bold";
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            document.getElementById(`tab-btn-${tabName}`).className = `px-6 py-2 ${tabName === 'manage' ? 'bg-red-600' : 'bg-purple-600'} text-white rounded-lg font-bold`;
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
            
            if (tabName === 'manage') refreshMembersList();
            
            if (tabName === 'lang') { document.getElementById('form-lang').reset(); document.getElementById('edit_lang_id').value = ''; }
            if (tabName === 'lesson') { await initQuill(); document.getElementById('form-lesson').reset(); document.getElementById('edit_lesson_id').value = ''; quillSo.root.innerHTML = ''; quillBa.root.innerHTML = ''; document.getElementById('lesson_order').value = '1'; }
        };

        function updateAdminSelects() {
            const lSelect = document.getElementById('lesson_lang_select'); lSelect.innerHTML = '<option value="">-- زمان --</option>';
            for (let id in languagesData) {
                lSelect.innerHTML += `<option value="${id}">${languagesData[id].name_so || languagesData[id].name}</option>`;
            }
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
                logo_url: logoUrl,
                is_ai: document.getElementById('lang_is_ai').checked === true,
                icon: document.getElementById('lang_icon').value || '🤖',
                ai_order: parseInt(document.getElementById('lang_ai_order').value, 10) || 0
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
                code: document.getElementById('lesson_code').value,
                code_css: document.getElementById('lesson_code_css').value,
                xp_cost: parseInt(document.getElementById('lesson_xp_cost').value, 10) || 0,
                max_attempts: parseInt(document.getElementById('lesson_max_attempts').value, 10) || 5,
                allow_show_answer: document.getElementById('lesson_allow_show_answer').value === '1'
            };
            if(editId) await update(dbRef(db, 'ferga_lessons/' + editId), data); else await set(push(dbRef(db, 'ferga_lessons')), data);
            e.target.reset(); quillSo.root.innerHTML = ''; quillBa.root.innerHTML = ''; switchAdminTab('manage');
        });

        window.renderManageList = function() {
            const cat = document.getElementById('manage_category').value;
            const listObj = document.getElementById('manage-list'); listObj.innerHTML = '';
            
            let dataArr = [];
            let dataObj = cat === 'langs' ? languagesData : lessonsData;
            for(let id in dataObj) {
                dataArr.push({id: id, ...dataObj[id]});
            }
            
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
                let lockBadge = '';
                if(cat === 'langs') { title = item.name_so || item.name; lockBadge = item.locked === true ? '<span class="text-xs font-black bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-300 px-2.5 py-1 rounded-full">🔒 قفڵکراو</span>' : '<span class="text-xs font-black bg-emerald-100 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-300 px-2.5 py-1 rounded-full">🔓 کراوە</span>'; }
                if(cat === 'lessons') title = `[${languagesData[item.langId]?.name_so || '?'}] (${item.order || 0}) ${item.title_so || item.title}`;
                let extraBtn = cat === 'langs' ? `<button onclick="toggleLanguageLock('${item.id}')" class="font-bold text-xs ${item.locked === true ? 'text-emerald-500' : 'text-amber-500'}">${item.locked === true ? 'کردنەوە' : 'قفڵکردن'}</button>` : '';
                listObj.innerHTML += `<div class="flex justify-between p-4 bg-white dark:bg-gray-800 rounded mb-2 shadow-sm"><span class="flex items-center gap-2 flex-wrap">${lockBadge}<span>${title}</span></span><div class="flex gap-2 items-center">${extraBtn}<button onclick="editItem('${cat}','${item.id}')" class="text-blue-500 font-bold">دەستکاری</button><button onclick="deleteItem('${cat}','${item.id}')" class="text-red-500 font-bold">سڕینەوە</button></div></div>`;
            });
        };

        window.deleteItem = async function(cat, id) { if(confirm('دڵنیایت لە سڕینەوە؟')) { await remove(dbRef(db, (cat === 'langs' ? 'ferga_languages' : 'ferga_lessons') + '/' + id)); } };

        window.editItem = async function(cat, id) {
            if(cat === 'langs') {
                const d = languagesData[id]; document.getElementById('edit_lang_id').value = id;
                ['lang_name_so','lang_name_ba','lang_desc_so','lang_desc_ba','lang_color','lang_ext'].forEach(k => { 
                    const elem = document.getElementById(k);
                    if(elem) elem.value = d[k.replace('lang_','')] || d[k.replace('lang_','').replace('_so','')] || ''; 
                });
                switchAdminTab('lang');
            } else if(cat === 'lessons') {
                await initQuill();
                const d = lessonsData[id]; document.getElementById('edit_lesson_id').value = id; document.getElementById('lesson_lang_select').value = d.langId || '';
                ['lesson_order','lesson_level_so','lesson_level_ba','lesson_title_so','lesson_title_ba','lesson_code','lesson_expected_output','lesson_example_output'].forEach(k => { 
                    const elem = document.getElementById(k);
                    if(elem) elem.value = d[k.replace('lesson_','')] || d[k.replace('lesson_','').replace('_so','')] || ''; 
                });
                document.getElementById('lesson_xp_cost').value = parseInt(d.xp_cost, 10) || 0;
                document.getElementById('lesson_challenge_so').value = d.challenge_desc_so || d.challenge_so || '';
                document.getElementById('lesson_challenge_ba').value = d.challenge_desc_ba || d.challenge_ba || '';
                quillSo.root.innerHTML = d.content_so || d.content || '';
                quillBa.root.innerHTML = d.content_ba || d.content || '';
                switchAdminTab('lesson');
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
            const isAiEl = document.getElementById('lang_is_ai');
            if (isAiEl) isAiEl.checked = d.is_ai === true;
            const iconEl = document.getElementById('lang_icon');
            if (iconEl) iconEl.value = d.icon || '🤖';
            const orderEl = document.getElementById('lang_ai_order');
            if (orderEl) orderEl.value = d.ai_order || 0;
            const costEl = document.getElementById('lang_unlock_cost');
            if (costEl) costEl.value = d.unlock_cost || 0;
            const logoUrlEl = document.getElementById('lang_logo_url');
            if (logoUrlEl) logoUrlEl.value = d.logo_url || '';

            // Admins can always edit logos regardless of lock status
            if (logoUrlEl) {
                logoUrlEl.disabled = false;
                logoUrlEl.classList.remove('opacity-50', 'cursor-not-allowed');
            }

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
                    logo_url: document.getElementById('lang_logo_url').value || '',
                    is_ai: document.getElementById('lang_is_ai').checked === true,
                    icon: document.getElementById('lang_icon').value || '🤖',
                    ai_order: parseInt(document.getElementById('lang_ai_order').value, 10) || 0,
                    unlock_cost: parseInt(document.getElementById('lang_unlock_cost').value, 10) || 0
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

        // --- Edit Lesson Modal Logic ---
        
        window.toggleQuizType = function() {
            const type = (document.querySelector('input[name="modal_quiz_type"]:checked') || {}).value || 'none';
            const choiceFields = document.getElementById('quiz-choice-fields');
            const codeFields = document.getElementById('quiz-code-fields');
            const outputFields = document.getElementById('quiz-output-fields');
            if (choiceFields) choiceFields.classList.toggle('hidden', type !== 'choice');
            if (codeFields) codeFields.classList.toggle('hidden', type !== 'code');
            if (outputFields) outputFields.classList.toggle('hidden', type !== 'output');
        };

        // --- HTML + CSS: داگرتنی پەڕە و نیشاندانی ڕاستەوخۆ (دەستکاری وانە) ---
        function modalLangIsWeb() {
            const langSel = document.getElementById('modal_lesson_lang_select');
            const id = langSel ? langSel.value : '';
            if (id && languagesData[id]) {
                const ext = String(languagesData[id].ext || '').toLowerCase().replace('.', '');
                return ext === 'html+css' || ext === 'htmlcss' || ext === 'html-css' || ext === 'web';
            }
            return false;
        }

        window.updateModalWebSection = function() {
            const zone = document.getElementById('modal-web-zone');
            if (zone) zone.classList.toggle('hidden', !modalLangIsWeb());
        };

        function handleModalFiles(files) {
            const status = document.getElementById('modal-file-drop-status');
            if (!files || !files.length) return;
            Array.from(files).forEach(f => {
                const name = (f.name || '').toLowerCase();
                const isHtml = name.endsWith('.html') || name.endsWith('.htm');
                const isCss = name.endsWith('.css');
                if (!isHtml && !isCss) {
                    if (status) status.textContent = currentLang === 'so' ? `⚠️ ${f.name} مۆڵەتی نییە — تەنها .html و .css` : `⚠️ ${f.name} مۆڵەت نینە — تەنها .html و .css`;
                    return;
                }
                const reader = new FileReader();
                reader.onload = () => {
                    const content = String(reader.result || '');
                    if (isHtml) document.getElementById('modal_lesson_code').value = content;
                    if (isCss) document.getElementById('modal_lesson_code_css').value = content;
                    if (status) status.textContent = currentLang === 'so' ? `✅ ${f.name} خوێندرایەوە` : `✅ ${f.name} هاتیە خوێندن`;
                    previewModalWebPage();
                };
                reader.onerror = () => { if (status) status.textContent = '❌ نەتوانرا فایلەکە بخوێنرێتەوە'; };
                reader.readAsText(f);
            });
        }

        window.previewModalWebPage = function() {
            const html = document.getElementById('modal_lesson_code').value || '';
            const css = document.getElementById('modal_lesson_code_css').value || '';
            const pv = document.getElementById('modal-web-preview');
            const status = document.getElementById('modal-web-preview-status');
            if (!html.trim()) {
                if (status) status.textContent = currentLang === 'so' ? '⚠️ سەرەتا کۆدی HTML بنووسە' : '⚠️ بەری هەمی کۆدێ HTML بنڤێسە';
                return;
            }
            let combined = html;
            if (css.trim()) {
                if (/<\/head>/i.test(combined)) {
                    combined = combined.replace(/<\/head>/i, `<style>\n${css}\n</style>\n</head>`);
                } else {
                    combined += `\n<style>\n${css}\n</style>`;
                }
            }
            if (pv) {
                pv.classList.remove('hidden');
                pv.srcdoc = combined;
            }
            if (status) status.textContent = currentLang === 'so' ? '✅ پەڕەکە نیشان دەدرێت' : '✅ پەڕە د نیشاندانێدایە';
        };

        window.handleModalImage = async function(input) {
            const status = document.getElementById('modal-image-status');
            const preview = document.getElementById('modal-image-preview');
            const previewImg = document.getElementById('modal-image-preview-img');
            const file = input && input.files && input.files[0];
            if (!file) {
                if (status) status.textContent = '';
                return;
            }
            if (!/^image\//.test(file.type)) {
                if (status) status.textContent = currentLang === 'so' ? '⚠️ فایلێکی وێنە هەڵبژێرە (.jpg/.png/...)' : '⚠️ فایلەکێ وێنە هەلبژێرە (.jpg/.png/...)';
                input.value = '';
                return;
            }
            if (status) status.textContent = currentLang === 'so' ? '⏳ بەرز دەکرێتەوە...' : '⏳ هاتە بارکردن...';
            
            // Show local preview
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview && previewImg) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
            
            try {
                const url = await uploadImage(file);
                const codeEl = document.getElementById('modal_lesson_code');
                const imgTag = `<img src="${url}" style="max-width:100%;height:auto">`;
                if (codeEl) {
                    const start = codeEl.selectionStart != null ? codeEl.selectionStart : codeEl.value.length;
                    const end = codeEl.selectionEnd != null ? codeEl.selectionEnd : codeEl.value.length;
                    codeEl.value = codeEl.value.slice(0, start) + imgTag + codeEl.value.slice(end);
                    codeEl.focus();
                    codeEl.setSelectionRange(start + imgTag.length, start + imgTag.length);
                }
                if (status) status.textContent = currentLang === 'so' ? '✅ لینکی وێنەکە دانرا' : '✅ لینکا وێنە هاتە دانان';
                previewModalWebPage();
            } catch (err) {
                if (status) status.textContent = currentLang === 'so' ? '❌ بارکردنەکە سەرکەوتوو نەبوو — ئینتەرنێتەکە بپشکنە' : '❌ بارکردن سەرکەوتوو نەبوو — ئینتەرنێت بپشکنە';
                if (preview) preview.classList.add('hidden');
            }
            input.value = '';
        };

        window.clearModalImage = function() {
            const preview = document.getElementById('modal-image-preview');
            const previewImg = document.getElementById('modal-image-preview-img');
            const status = document.getElementById('modal-image-status');
            if (preview) preview.classList.add('hidden');
            if (previewImg) previewImg.src = '';
            if (status) status.textContent = '';
        };

        (function initModalWebZone() {
            const modalFileInput = document.getElementById('modal-file-input');
            if (modalFileInput) modalFileInput.addEventListener('change', function() {
                handleModalFiles(this.files);
                this.value = '';
            });
            const modalImageInput = document.getElementById('modal-image-input');
            if (modalImageInput) modalImageInput.addEventListener('change', function() {
                handleModalImage(this);
            });
            const modalImageDropZone = document.getElementById('modal-image-drop-zone');
            if (modalImageDropZone) {
                modalImageDropZone.addEventListener('dragover', e => {
                    e.preventDefault();
                    modalImageDropZone.classList.add('border-pink-600', 'bg-pink-100/60', 'dark:bg-pink-900/20');
                });
                modalImageDropZone.addEventListener('dragleave', () => {
                    modalImageDropZone.classList.remove('border-pink-600', 'bg-pink-100/60', 'dark:bg-pink-900/20');
                });
                modalImageDropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    modalImageDropZone.classList.remove('border-pink-600', 'bg-pink-100/60', 'dark:bg-pink-900/20');
                    const files = e.dataTransfer.files;
                    if (files && files.length > 0 && files[0].type.startsWith('image/')) {
                        handleModalImage({ files: files });
                    }
                });
            }
            const modalFileDrop = document.getElementById('modal-file-drop');
            if (modalFileDrop) {
                modalFileDrop.addEventListener('dragover', e => {
                    e.preventDefault();
                    modalFileDrop.classList.add('border-blue-600', 'bg-blue-100/60', 'dark:bg-blue-900/20');
                });
                modalFileDrop.addEventListener('dragleave', () => {
                    modalFileDrop.classList.remove('border-blue-600', 'bg-blue-100/60', 'dark:bg-blue-900/20');
                });
                modalFileDrop.addEventListener('drop', e => {
                    e.preventDefault();
                    modalFileDrop.classList.remove('border-blue-600', 'bg-blue-100/60', 'dark:bg-blue-900/20');
                    handleModalFiles(e.dataTransfer.files);
                });
            }
        })();

        window.openEditLessonModal = async function(lessonId) {
            await initQuill();
            const d = lessonsData[lessonId];
            if (!d) return;
            const legacyQuiz = Object.values(quizzesData).find(q => q.lessonId === lessonId) || null;
            document.getElementById('edit_lesson_modal_id').value = lessonId;
            document.getElementById('modal_lesson_lang_select').innerHTML = '<option value="">-- زمان --</option>';
            for (let id in languagesData) document.getElementById('modal_lesson_lang_select').innerHTML += `<option value="${id}">${languagesData[id].name_so || languagesData[id].name}</option>`;
            document.getElementById('modal_lesson_lang_select').value = d.langId || '';
            document.getElementById('modal_lesson_order').value = d.order || '1';
            document.getElementById('modal_lesson_level_so').value = d.level_so || '';
            document.getElementById('modal_lesson_level_ba').value = d.level_ba || '';
            document.getElementById('modal_lesson_title_so').value = d.title_so || d.title || '';
            document.getElementById('modal_lesson_title_ba').value = d.title_ba || d.title || '';
            document.getElementById('modal_lesson_challenge_so').value = d.challenge_desc_so || d.challenge_so || '';
            document.getElementById('modal_lesson_challenge_ba').value = d.challenge_desc_ba || d.challenge_ba || '';
            document.getElementById('modal_lesson_expected_output').value = d.expected_output || '';
            document.getElementById('modal_lesson_code').value = d.code || '';
            document.getElementById('modal_lesson_code_css').value = d.code_css || '';
            document.getElementById('modal_lesson_answer_code').value = d.answer_code || '';
            document.getElementById('modal_lesson_answer_code_css').value = d.answer_code_css || '';
            document.getElementById('modal_lesson_max_attempts').value = parseInt(d.max_attempts, 10) || 5;
            document.getElementById('modal_lesson_allow_show_answer').value = (d.allow_show_answer === false) ? '0' : '1';
            document.getElementById('modal_lesson_example_output').value = d.example_output || '';
            document.getElementById('modal_lesson_xp_cost').value = parseInt(d.xp_cost, 10) || 0;
            quillModalSo.root.innerHTML = d.content_so || d.content || '';
            quillModalBa.root.innerHTML = d.content_ba || d.content || '';

            document.getElementById('modal_quiz_question_so').value = d.quiz_question_so || (legacyQuiz ? legacyQuiz.question_so : '') || '';
            document.getElementById('modal_quiz_question_ba').value = d.quiz_question_ba || (legacyQuiz ? legacyQuiz.question_ba : '') || '';
            for(let i=0; i<4; i++) {
                document.getElementById(`modal_quiz_opt${i}_so`).value = (d.quiz_options_so || (legacyQuiz ? (legacyQuiz.options_so || legacyQuiz.options) : null) || [])[i] || '';
                document.getElementById(`modal_quiz_opt${i}_ba`).value = (d.quiz_options_ba || (legacyQuiz ? (legacyQuiz.options_ba || legacyQuiz.options) : null) || [])[i] || '';
            }
            document.getElementById('modal_quiz_correct').value = d.quiz_correct !== undefined && d.quiz_correct !== null ? String(d.quiz_correct) : (legacyQuiz ? (legacyQuiz.correct || '0') : '0');

            document.getElementById('modal_quiz_code').value = d.quiz_code || '';
            const outOpts = Array.isArray(d.quiz_options_so) ? d.quiz_options_so : [];
            for (let i = 0; i < 4; i++) document.getElementById(`modal_quiz_output_opt${i}`).value = outOpts[i] || '';
            document.getElementById('modal_quiz_output_correct').value = d.quiz_correct !== undefined && d.quiz_correct !== null ? String(d.quiz_correct) : '0';
            document.getElementById('modal_quiz_output_question_so').value = d.quiz_question_so || 'ئەنجامی ئەم کۆدە چییە؟';
            document.getElementById('modal_quiz_output_question_ba').value = d.quiz_question_ba || 'ئەنجامێ ڤی کۆدی چییە؟';

            let qtype = d.quiz_type || '';
            if (!qtype && (d.quiz_question_so || d.quiz_question_ba)) qtype = 'choice';
            if (!qtype && ((d.challenge_desc_so || d.challenge_desc_ba || d.challenge_so || d.challenge_ba) && d.expected_output)) qtype = 'code';
            if (!qtype && legacyQuiz) qtype = 'choice';
            const radio = document.querySelector(`input[name="modal_quiz_type"][value="${qtype || 'none'}"]`);
            if (radio) radio.checked = true;
            window.toggleQuizType();
            window.updateModalWebSection();

            const modal = document.getElementById('editLessonModal');
            const content = document.getElementById('editLessonModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeEditLessonModal = function() {
            const modal = document.getElementById('editLessonModal');
            const content = document.getElementById('editLessonModalContent');
            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        };

        window.openNewLessonModal = function(topicId) {
            const lang = languagesData[topicId] || null;
            const nextOrder = sortedLangLessons(topicId).reduce((mx, l) => Math.max(mx, parseInt(l.order, 10) || 0), 0) + 1;
            document.getElementById('edit_lesson_modal_id').value = '';
            const sel = document.getElementById('modal_lesson_lang_select');
            sel.innerHTML = '<option value="">-- زمان --</option>';
            for (let id in languagesData) sel.innerHTML += `<option value="${id}">${languagesData[id].name_so || languagesData[id].name}</option>`;
            sel.value = topicId;
            document.getElementById('modal_lesson_order').value = String(nextOrder);
            const isAi = lang && lang.is_ai === true;
            document.getElementById('modal_lesson_level_so').value = isAi ? 'بنەڕەتەکان' : '';
            document.getElementById('modal_lesson_level_ba').value = isAi ? 'بنەڕەت' : '';
            document.getElementById('modal_lesson_title_so').value = '';
            document.getElementById('modal_lesson_title_ba').value = '';
            document.getElementById('modal_lesson_challenge_so').value = '';
            document.getElementById('modal_lesson_challenge_ba').value = '';
            document.getElementById('modal_lesson_expected_output').value = '';
            document.getElementById('modal_lesson_code').value = '';
            document.getElementById('modal_lesson_code_css').value = '';
            document.getElementById('modal_lesson_answer_code').value = '';
            document.getElementById('modal_lesson_answer_code_css').value = '';
            document.getElementById('modal_lesson_max_attempts').value = '5';
            document.getElementById('modal_lesson_allow_show_answer').value = '1';
            document.getElementById('modal_lesson_example_output').value = '';
            document.getElementById('modal_lesson_xp_cost').value = '0';
            quillModalSo.root.innerHTML = '';
            quillModalBa.root.innerHTML = '';
            document.getElementById('modal_quiz_question_so').value = '';
            document.getElementById('modal_quiz_question_ba').value = '';
            for (let i = 0; i < 4; i++) {
                document.getElementById(`modal_quiz_opt${i}_so`).value = '';
                document.getElementById(`modal_quiz_opt${i}_ba`).value = '';
            }
            document.getElementById('modal_quiz_correct').value = '0';
            document.getElementById('modal_quiz_code').value = '';
            document.getElementById('modal_quiz_output_correct').value = '0';
            for (let i = 0; i < 4; i++) document.getElementById(`modal_quiz_output_opt${i}`).value = '';
            document.getElementById('modal_quiz_output_question_so').value = 'ئەنجامی ئەم کۆدە چییە؟';
            document.getElementById('modal_quiz_output_question_ba').value = 'ئەنجامێ ڤی کۆدی چییە؟';
            const radio = document.querySelector('input[name="modal_quiz_type"][value="none"]');
            if (radio) radio.checked = true;
            window.toggleQuizType();
            window.updateModalWebSection();
            const modal = document.getElementById('editLessonModal');
            const content = document.getElementById('editLessonModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        document.getElementById('edit-lesson-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit_lesson_modal_id').value;
            const isNew = !id;
            const submitBtn = document.getElementById('edit-lesson-submit-btn');
            submitBtn.innerText = "خەریکە پاشەکەوت دەکرێت...";
            submitBtn.classList.add('opacity-70', 'cursor-wait');
            try {
                const quizType = (document.querySelector('input[name="modal_quiz_type"]:checked') || {}).value || 'none';
                let outputOptionsSo = [];
                let outputCorrect = '0';
                if (quizType === 'output') {
                    outputOptionsSo = [0, 1, 2, 3].map(i => document.getElementById(`modal_quiz_output_opt${i}`).value);
                    outputCorrect = document.getElementById('modal_quiz_output_correct').value;
                }
                const updates = {
                    langId: document.getElementById('modal_lesson_lang_select').value,
                    order: document.getElementById('modal_lesson_order').value,
                    level_so: document.getElementById('modal_lesson_level_so').value,
                    level_ba: document.getElementById('modal_lesson_level_ba').value,
                    title_so: document.getElementById('modal_lesson_title_so').value,
                    title_ba: document.getElementById('modal_lesson_title_ba').value,
                    content_so: quillModalSo.root.innerHTML,
                    content_ba: quillModalBa.root.innerHTML,
                    challenge_desc_so: document.getElementById('modal_lesson_challenge_so').value,
                    challenge_desc_ba: document.getElementById('modal_lesson_challenge_ba').value,
                    expected_output: document.getElementById('modal_lesson_expected_output').value,
                    example_output: document.getElementById('modal_lesson_example_output').value,
                    code: document.getElementById('modal_lesson_code').value,
                    code_css: document.getElementById('modal_lesson_code_css').value,
                    answer_code: document.getElementById('modal_lesson_answer_code').value,
                    answer_code_css: document.getElementById('modal_lesson_answer_code_css').value,
                    max_attempts: parseInt(document.getElementById('modal_lesson_max_attempts').value, 10) || 5,
                    allow_show_answer: document.getElementById('modal_lesson_allow_show_answer').value === '1',
                    xp_cost: parseInt(document.getElementById('modal_lesson_xp_cost').value, 10) || 0,
                    quiz_type: quizType,
                    quiz_question_so: quizType === 'output' ? document.getElementById('modal_quiz_output_question_so').value : document.getElementById('modal_quiz_question_so').value,
                    quiz_question_ba: quizType === 'output' ? document.getElementById('modal_quiz_output_question_ba').value : document.getElementById('modal_quiz_question_ba').value,
                    quiz_options_so: quizType === 'output' ? outputOptionsSo : [0,1,2,3].map(i => document.getElementById(`modal_quiz_opt${i}_so`).value),
                    quiz_options_ba: quizType === 'output' ? outputOptionsSo : [0,1,2,3].map(i => document.getElementById(`modal_quiz_opt${i}_ba`).value),
                    quiz_correct: quizType === 'output' ? outputCorrect : document.getElementById('modal_quiz_correct').value,
                    quiz_code: quizType === 'output' ? document.getElementById('modal_quiz_code').value : null
                };
                if (isNew) {
                    const newRef = push(dbRef(db, 'ferga_lessons'));
                    await set(newRef, updates);
                } else {
                    await update(dbRef(db, 'ferga_lessons/' + id), updates);
                }
                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                window.closeEditLessonModal();
                if (!isNew && window.currentLessonId === id && currentActiveLanguage) openLanguage(currentActiveLanguage.id, currentLessonIndex);
                alert(isNew ? 'وانەکە بە سەرکەوتوویی زیاد کرا' : 'وانەکە بە سەرکەوتوویی پاشەکەوت کرا');
            } catch (error) {
                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                alert('هەڵەیەک ڕوویدا: ' + error.message);
            }
        });
        
        const origEditItem2 = window.editItem;
        window.editItem = function(cat, id) {
            if (cat === 'langs') { window.openEditLangModal(id); return; }
            if (cat === 'lessons') { window.openEditLessonModal(id); return; }
            origEditItem2(cat, id);
        };

        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>

    <!-- مۆدالی دەستکاریکردنی زمان -->
    <div id="editLangModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-[130] overflow-y-auto">
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="absolute inset-0" onclick="window.closeEditLangModal()"></div>
            <div id="editLangModalContent" class="relative w-full max-w-2xl bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 translate-y-4 opacity-0">
                <button onclick="window.closeEditLangModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-t-3xl">
                    <h3 class="text-xl font-black text-white text-center">دەستکاریکردنی زمان</h3>
                </div>
                <form id="edit-lang-form" class="p-6 space-y-4">
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
                            <textarea id="lang_desc_so" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتە (بادینی)</label>
                            <textarea id="lang_desc_ba" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پاشگری زمان (بۆ نموونە: py, php, cpp)</label>
                            <input type="text" id="lang_ext" required placeholder="py" dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm font-mono text-left">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ڕەنگی پاشبنەما</label>
                            <input type="text" id="lang_color" value="bg-blue-100" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="flex items-center md:items-end md:pb-1">
                            <label class="flex items-center gap-2 text-gray-700 dark:text-gray-300 font-bold text-sm cursor-pointer">
                                <input type="checkbox" id="lang_is_ai" class="w-5 h-5 rounded"> بەشی AI
                            </label>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ئایکۆنی بەش (AI)</label>
                            <input type="text" id="lang_icon" placeholder="🤖" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ڕیزبەندی بەش (AI)</label>
                            <input type="number" id="lang_ai_order" value="0" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">تێچووی کردنەوە بە پۆینت (AI)</label>
                            <input type="number" id="lang_unlock_cost" min="0" value="0" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">لۆگۆی بەش (Logo URL)</label>
                        <input type="text" id="lang_logo_url" placeholder="https://example.com/logo.png" dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">بەستەرەکەی وێنەی لۆگۆی بەش (بۆ AI courses)</p>
                    </div>
                    <button type="submit" id="edit-lang-submit-btn" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-0.5 transition-all">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

    <!-- مۆدالی دەستکاریکردنی وانە -->
    <div id="editLessonModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-[140] overflow-y-auto">
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="absolute inset-0" onclick="window.closeEditLessonModal()"></div>
            <div id="editLessonModalContent" class="relative w-full max-w-4xl bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 translate-y-4 opacity-0">
                <button onclick="window.closeEditLessonModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-t-3xl">
                    <h3 class="text-xl font-black text-white text-center">دەستکاریکردنی وانە</h3>
                </div>
                <form id="edit-lesson-form" class="p-6 space-y-6">
                    <input type="hidden" id="edit_lesson_modal_id">

                    <!-- ١. زانیارییە بنەڕەتییەکان -->
                    <div class="rounded-2xl border-2 border-blue-300 dark:border-blue-700 overflow-hidden">
                        <div class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-500 text-white font-black text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>١. زانیارییە بنەڕەتییەکان</span>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">زمان</label>
                                    <select id="modal_lesson_lang_select" required onchange="updateModalWebSection()" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm"></select>
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ڕیزبەندی (ژمارە)</label>
                                    <input type="number" id="modal_lesson_order" value="1" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ئاست (سۆرانی)</label>
                                    <input type="text" id="modal_lesson_level_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                                <div class="md:col-span-1">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ئاست (بادینی)</label>
                                    <input type="text" id="modal_lesson_level_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">بەهای پۆینت (پاشماوە — ئێستا وانەکان بەخۆڕایی دەکرێنەوە)</label>
                                    <input type="number" id="modal_lesson_xp_cost" min="0" value="0" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">سەردێڕ (سۆرانی)</label>
                                    <input type="text" id="modal_lesson_title_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">سەردێڕ (بادینی)</label>
                                    <input type="text" id="modal_lesson_title_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-10">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوەڕۆک (سۆرانی)</label>
                                    <div id="modal_editor_content_so" class="bg-white dark:bg-gray-900 rounded-xl"></div>
                                </div>
                                <div class="mb-10">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوەڕۆک (بادینی)</label>
                                    <div id="modal_editor_content_ba" class="bg-white dark:bg-gray-900 rounded-xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ٢. کۆدی نموونە -->
                    <div class="rounded-2xl border-2 border-orange-300 dark:border-orange-700 overflow-hidden">
                        <div class="px-5 py-3 bg-gradient-to-r from-orange-600 to-amber-500 text-white font-black text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                            <span>٢. کۆدی نموونە (دەردەکەوێت لە سەکۆکەدا)</span>
                        </div>
                        <div class="p-5 space-y-4">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کۆدی نموونە</label>
                                <textarea id="modal_lesson_code" rows="6" dir="ltr" class="w-full px-4 py-3 bg-[#1e1e1e] text-green-400 border border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm font-mono text-left" placeholder="# لێرە کۆدەکە بنووسە"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کۆدی CSS (style.css — تەنها بۆ HTML + CSS)</label>
                                <textarea id="modal_lesson_code_css" rows="5" dir="ltr" class="w-full px-4 py-3 bg-[#1e1e1e] text-purple-400 border border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm font-mono text-left"></textarea>
                            </div>

                            <!-- بەشی HTML + CSS: داگرتنی پەڕە و نیشاندانی ڕاستەوخۆ -->
                            <div id="modal-web-zone" class="hidden space-y-3">
                                <div id="modal-file-drop" onclick="document.getElementById('modal-file-input').click()" class="border-2 border-dashed border-blue-400 dark:border-blue-600 hover:border-blue-500 bg-blue-50/40 dark:bg-blue-900/10 rounded-xl p-5 text-center cursor-pointer transition">
                                    <input type="file" id="modal-file-input" accept=".html,.htm,.css" multiple class="hidden">
                                    <svg class="w-8 h-8 text-blue-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-sm font-black text-blue-600 dark:text-blue-400">داگرە و دابنێ index.html یان style.css</p>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mt-1">index.html → خانەی کۆد · style.css → خانەی CSS · دەتوانیت کرتەش بکەیت</p>
                                </div>
                                <p id="modal-file-drop-status" class="text-xs font-bold text-emerald-600 dark:text-emerald-400"></p>
                                <div class="flex items-center gap-3 flex-wrap">
                                    <input type="file" id="modal-image-input" accept="image/*" class="hidden">
                                    <div id="modal-image-drop-zone" onclick="document.getElementById('modal-image-input').click()" class="border-2 border-dashed border-pink-400 dark:border-pink-600 hover:border-pink-500 bg-pink-50/40 dark:bg-pink-900/10 rounded-xl p-4 text-center cursor-pointer transition flex-1 min-w-[200px]">
                                        <svg class="w-6 h-6 text-pink-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-xs font-black text-pink-600 dark:text-pink-400">داگرە و دابنە وێنە یان کرتە بکە</p>
                                    </div>
                                    <span id="modal-image-status" class="text-xs font-bold text-gray-500 dark:text-gray-400"></span>
                                </div>
                                <div id="modal-image-preview" class="hidden mt-3">
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-2">پێشبینین:</p>
                                    <img id="modal-image-preview-img" class="max-w-full h-auto rounded-xl border-2 border-gray-200 dark:border-gray-700 shadow-lg" alt="Preview">
                                    <button type="button" onclick="clearModalImage()" class="mt-2 text-xs font-bold text-red-500 hover:text-red-600 transition flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        سڕینەوە
                                    </button>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="previewModalWebPage()" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg flex items-center gap-2 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="lang-str" data-so="نیشاندانی پەڕەکە (ئەنجام)" data-ba="نیشاندانا پەڕە (ئەنجام)">نیشاندانی پەڕەکە (ئەنجام)</span>
                                    </button>
                                    <span id="modal-web-preview-status" class="text-xs font-bold text-gray-500 dark:text-gray-400"></span>
                                </div>
                                <iframe id="modal-web-preview" class="hidden w-full h-[360px] bg-white rounded-xl border-2 border-gray-200 dark:border-gray-700" sandbox="allow-scripts allow-modals allow-forms"></iframe>
                            </div>
                            <div>
                                <label class="block text-blue-600 dark:text-blue-300 font-bold text-sm mb-1">ئەنجامی کۆدی نموونە (Example Output)</label>
                                <textarea id="modal_lesson_example_output" rows="3" dir="ltr" placeholder="hello world" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm font-mono text-left"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ٣. پرسیاری وانەکە -->
                    <div class="rounded-2xl border-2 border-green-300 dark:border-green-700 overflow-hidden">
                        <div class="px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-black text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>٣. پرسیاری وانەکە (بەدڵخواز — جۆرەکە هەڵبژێرە)</span>
                        </div>
                        <div class="p-5 space-y-5">
                            <!-- جۆری پرسیار -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">جۆری پرسیار</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-gray-400 dark:hover:border-gray-500 transition bg-white/50 dark:bg-gray-900/30">
                                        <input type="radio" name="modal_quiz_type" value="none" checked onchange="toggleQuizType()" class="w-4 h-4 accent-green-600 shrink-0">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">🚫 هیچ پرسیارێک</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-blue-400 dark:hover:border-blue-600 transition bg-white/50 dark:bg-gray-900/30">
                                        <input type="radio" name="modal_quiz_type" value="choice" onchange="toggleQuizType()" class="w-4 h-4 accent-blue-600 shrink-0">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">🔘 هەڵبژاردن (کویز)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-purple-400 dark:hover:border-purple-600 transition bg-white/50 dark:bg-gray-900/30">
                                        <input type="radio" name="modal_quiz_type" value="code" onchange="toggleQuizType()" class="w-4 h-4 accent-purple-600 shrink-0">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">💻 مەشق (نمونەی کۆد)</span>
                                    </label>
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl border-2 border-gray-200 dark:border-gray-700 cursor-pointer hover:border-orange-400 dark:hover:border-orange-600 transition bg-white/50 dark:bg-gray-900/30">
                                        <input type="radio" name="modal_quiz_type" value="output" onchange="toggleQuizType()" class="w-4 h-4 accent-orange-600 shrink-0">
                                        <span class="text-sm font-bold text-gray-700 dark:text-gray-300">🧪 ئەنجامی ئەم کۆدە چییە</span>
                                    </label>
                                </div>
                            </div>

                            <!-- بەشی هەڵبژاردن -->
                            <div id="quiz-choice-fields" class="hidden space-y-4 rounded-2xl border-2 border-blue-300 dark:border-blue-700 p-5 bg-blue-50/40 dark:bg-blue-900/10">
                                <div class="text-xs font-black text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>پرسیاری هەڵبژاردن — بەکارهێنەر یەکێک هەڵدەبژێرێت</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (سۆرانی)</label>
                                        <input type="text" id="modal_quiz_question_so" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (بادینی)</label>
                                        <input type="text" id="modal_quiz_question_ba" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">بژاردەکان (سۆرانی)</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        <input type="text" id="modal_quiz_opt0_so" placeholder="بژاردەی ١" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt1_so" placeholder="بژاردەی ٢" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt2_so" placeholder="بژاردەی ٣" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt3_so" placeholder="بژاردەی ٤" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">بژاردەکان (بادینی)</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        <input type="text" id="modal_quiz_opt0_ba" placeholder="بژاردەی ١" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt1_ba" placeholder="بژاردەی ٢" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt2_ba" placeholder="بژاردەی ٣" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_opt3_ba" placeholder="بژاردەی ٤" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all text-sm">
                                    </div>
                                </div>
                                <div class="md:w-1/2">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">وەڵامە ڕاستەکە</label>
                                    <select id="modal_quiz_correct" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-green-300 dark:border-green-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition-all text-sm font-bold">
                                        <option value="0">بژاردەی ١</option><option value="1">بژاردەی ٢</option><option value="2">بژاردەی ٣</option><option value="3">بژاردەی ٤</option>
                                    </select>
                                </div>
                            </div>

                            <!-- بەشی مەشق / کۆد -->
                            <div id="quiz-code-fields" class="hidden space-y-4 rounded-2xl border-2 border-purple-300 dark:border-purple-700 p-5 bg-purple-50/40 dark:bg-purple-900/10">
                                <div class="text-xs font-black text-purple-700 dark:text-purple-300 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                    <span>مەشقی کۆد — بەکارهێنەر کۆدەکە دەنووسێت و پشکنینی دەکات</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیاری مەشق (سۆرانی)</label>
                                        <textarea id="modal_lesson_challenge_so" rows="2" placeholder="نموونە: کۆدێک بنووسە کە وشەی هەولێر چاپ بکات" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیاری مەشق (بادینی)</label>
                                        <textarea id="modal_lesson_challenge_ba" rows="2" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1 text-green-600">وەڵامی چاوەڕوانکراو (Expected Output Text)</label>
                                    <textarea id="modal_lesson_expected_output" rows="3" dir="ltr" placeholder="هەولێر" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition-all text-sm font-mono text-left"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ژمارەی هەوڵەکان (Attempts)</label>
                                        <input type="number" id="modal_lesson_max_attempts" min="1" max="20" value="5" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">نیشاندانی وەڵام</label>
                                        <select id="modal_lesson_allow_show_answer" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all text-sm">
                                            <option value="1">بەڵێ - ڕێگە بدە</option>
                                            <option value="0">نەخێر - قەدەغە بکە</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="rounded-xl border-2 border-dashed border-emerald-400/50 p-4 bg-emerald-50/40 dark:bg-emerald-900/10">
                                    <label class="block text-emerald-700 dark:text-emerald-300 font-black text-sm mb-1">✅ وەڵامی ڕاست (کۆدێک کە بەکارهێنەر دوای هەوڵەکان دەیبینێت)</label>
                                    <textarea id="modal_lesson_answer_code" rows="5" dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-emerald-300 dark:border-emerald-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all text-sm font-mono text-left" placeholder="جگەر بەتاڵ بێت، کۆدی نموونە دەردەکرێت"></textarea>
                                </div>
                                <div>
                                    <label class="block text-emerald-700 dark:text-emerald-300 font-bold text-sm mb-1">وەڵامی ڕاست (CSS — تەنها بۆ HTML + CSS)</label>
                                    <textarea id="modal_lesson_answer_code_css" rows="5" dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-emerald-300 dark:border-emerald-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all text-sm font-mono text-left"></textarea>
                                </div>
                            </div>

                            <!-- بەشی ئەنجامی کۆد -->
                            <div id="quiz-output-fields" class="hidden space-y-4 rounded-2xl border-2 border-orange-300 dark:border-orange-700 p-5 bg-orange-50/40 dark:bg-orange-900/10">
                                <div class="text-xs font-black text-orange-700 dark:text-orange-300 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span>پرسیاری ئەنجامی کۆد — کۆدێک دەنووسیت و ٤ بژاردە دادەنێیت (ڕاستەکە خۆت هەڵدەبژێریت)</span>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کۆدەکە (دەردەکەوێت لە پرسیارەکەدا)</label>
                                    <textarea id="modal_quiz_code" rows="5" dir="ltr" class="w-full px-4 py-3 bg-[#1e1e1e] text-green-400 border border-gray-700 rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm font-mono text-left" placeholder="# کۆدەکە لێرە بنووسە"></textarea>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button type="button" onclick="previewQuizCodeOutput()" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-400 hover:to-amber-400 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg flex items-center gap-2 transition-all">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        <span>کارپێکردن و هێنانی ئەنجام</span>
                                    </button>
                                    <span id="quiz-output-preview-status" class="text-xs font-bold text-gray-500 dark:text-gray-400"></span>
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">بژاردەکان</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        <input type="text" id="modal_quiz_output_opt0" placeholder="بژاردەی ١" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_output_opt1" placeholder="بژاردەی ٢" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_output_opt2" placeholder="بژاردەی ٣" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                        <input type="text" id="modal_quiz_output_opt3" placeholder="بژاردەی ٤" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">💡 دوای کرتەکردن لە «کارپێکردن و هێنانی ئەنجام»، ئەنجامە ڕاستەکە دەخرێتە ناو ئەو بژاردەیەی لە خوارەوە هەڵبژێردراوە</p>
                                </div>
                                <div class="md:w-1/2">
                                    <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">وەڵامە ڕاستەکە</label>
                                    <select id="modal_quiz_output_correct" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-green-300 dark:border-green-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-green-500 focus:outline-none transition-all text-sm font-bold">
                                        <option value="0">بژاردەی ١</option><option value="1">بژاردەی ٢</option><option value="2">بژاردەی ٣</option><option value="3">بژاردەی ٤</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (سۆرانی)</label>
                                        <input type="text" id="modal_quiz_output_question_so" value="ئەنجامی ئەم کۆدە چییە؟" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (بادینی)</label>
                                        <input type="text" id="modal_quiz_output_question_ba" value="ئەنجامێ ڤی کۆدی چییە؟" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all text-sm">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="edit-lesson-submit-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

@include('components.chat-widget')
</body>
</html>
