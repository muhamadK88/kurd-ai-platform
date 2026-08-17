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
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700;900&family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700;900&family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <style>
        /* Kurdish text: Vazirmatn first (full Kurdish glyph support), Noto fallback */
        body { font-family: 'Vazirmatn', 'Noto Sans Arabic', Tahoma, system-ui, sans-serif; }
        h1, h2, h3, h4, h5, h6, p, a, li, span, button, input, textarea, select, label, div { font-family: inherit; }
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
        .ql-container { background: white; border-radius: 0 0 8px 8px; color: black; font-family: 'Vazirmatn', 'Noto Sans Arabic', sans-serif; font-size: 16px; }
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

        /* --- AI lesson hero (سەرپەڕەی وانەکانی ژیری دەستکرد) --- */
        @keyframes aiHeroIn { 0% { opacity: 0; transform: translateY(24px) scale(0.98); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes aiHeroGradFlow { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        @keyframes aiHeroOrbFloat { 0%, 100% { transform: translateY(0) translateX(0) scale(1); } 33% { transform: translateY(-12px) translateX(10px) scale(1.08); } 66% { transform: translateY(8px) translateX(-8px) scale(0.95); } }
        @keyframes aiHeroLogoPop { 0% { transform: scale(0.5) rotate(-12deg); opacity: 0; } 60% { transform: scale(1.1) rotate(4deg); } 100% { transform: scale(1) rotate(0); opacity: 1; } }
        @keyframes aiHeroBarFill { 0% { width: 0; } }
        @keyframes aiHeroShimmer { 0% { left: -85%; } 100% { left: 155%; } }
        #ai-lesson-hero { animation: aiHeroIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) both; }
        #ai-lesson-hero .ai-hero-grad { background-size: 220% 220%; animation: aiHeroGradFlow 8s ease-in-out infinite; }
        #ai-lesson-hero .ai-hero-orb { animation: aiHeroOrbFloat 7s ease-in-out infinite; }
        #ai-lesson-hero .ai-hero-logo { animation: aiHeroLogoPop 0.7s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s both; }
        #ai-lesson-hero .ai-hero-bar-fill { animation: aiHeroBarFill 1.1s cubic-bezier(0.22, 1, 0.36, 1) 0.4s both; }
        #ai-lesson-hero .ai-hero-shimmer { position: absolute; top: 0; bottom: 0; width: 50%; background: linear-gradient(115deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%); transform: skewX(-18deg); animation: aiHeroShimmer 2.4s ease-in-out 0.6s infinite; pointer-events: none; }
        #ai-lesson-hero .ai-hero-grid { background-image: linear-gradient(rgba(255,255,255,0.14) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.14) 1px, transparent 1px); background-size: 26px 26px; }
        /* AI content box */
        #display-content.ai-lesson-content { position: relative; }
        #display-content.ai-lesson-content > .rendered-content-box { animation: aiHeroIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) 0.1s both; }
        #display-content.ai-lesson-content > .rendered-content-box { background: rgba(255,255,255,0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(16,185,129,0.18); border-radius: 1.75rem; padding: 2rem 2.25rem; box-shadow: 0 18px 50px -18px rgba(16,185,129,0.18), 0 4px 18px -6px rgba(15,23,42,0.06); margin-bottom: 1.75rem; }
        .dark #display-content.ai-lesson-content > .rendered-content-box { background: rgba(15,23,42,0.6); border-color: rgba(16,185,129,0.22); }
        #display-content.ai-lesson-content > .rendered-content-box > :first-child { margin-top: 0; }
        #display-content.ai-lesson-content > .rendered-content-box > :last-child { margin-bottom: 0; }
        #display-content.ai-lesson-content h1, #display-content.ai-lesson-content h2, #display-content.ai-lesson-content h3 { color: #0f766e; }
        .dark #display-content.ai-lesson-content h1, .dark #display-content.ai-lesson-content h2, .dark #display-content.ai-lesson-content h3 { color: #5eead4; }
        #display-content.ai-lesson-content pre { border: 1px solid rgba(16,185,129,0.15); border-radius: 1rem; box-shadow: 0 12px 30px -12px rgba(2,6,23,0.4); }
        @media (prefers-reduced-motion: reduce) { #ai-lesson-hero, #ai-lesson-hero * { animation: none !important; transition: none !important; } }

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
    <link rel="stylesheet" href="/css/kai-ferga.css?v=8">
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
                <div id="ai-lesson-hero" class="hidden relative overflow-hidden rounded-[2rem] shadow-2xl mb-8 ring-1 ring-white/40 dark:ring-white/10">
                    <div id="ai-lesson-hero-grad" class="ai-hero-grad absolute inset-0 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600"></div>
                    <div class="ai-hero-grid absolute inset-0 opacity-40"></div>
                    <div class="ai-hero-orb absolute -top-10 -right-8 w-48 h-48 rounded-full bg-white/20 blur-2xl"></div>
                    <div class="ai-hero-orb absolute -bottom-16 -left-10 w-56 h-56 rounded-full bg-black/10 blur-2xl" style="animation-delay:2.5s"></div>
                    <div class="ai-hero-shimmer"></div>
                    <div class="relative p-6 md:p-8 flex flex-col md:flex-row md:items-center gap-5 md:gap-7">
                        <div class="ai-hero-logo w-20 h-20 md:w-24 md:h-24 shrink-0 rounded-2xl bg-white/95 dark:bg-gray-900/90 p-1.5 shadow-2xl ring-4 ring-white/50 dark:ring-white/20 flex items-center justify-center overflow-hidden">
                            <img id="ai-lesson-hero-logo-img" src="" alt="AI" class="w-full h-full object-cover hidden">
                            <span id="ai-lesson-hero-logo-icon" class="text-5xl hidden">🤖</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-wider text-white/90 bg-white/20 backdrop-blur px-3 py-1 rounded-full ring-1 ring-white/30">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3v3m0 12v3m9-9h-3M6 12H3m15.36 6.36l-2.12-2.12M7.76 7.76L5.64 5.64m12.72 0l-2.12 2.12M7.76 16.24l-2.12 2.12"></path></svg>
                                    <span class="lang-str" data-so="ژیری دەستکرد" data-ba="زیرەکیا دەستکرد">ژیری دەستکرد</span>
                                </span>
                                <span id="ai-lesson-hero-level" class="text-[10px] font-black text-white/90 bg-black/20 backdrop-blur px-3 py-1 rounded-full ring-1 ring-white/20"></span>
                            </div>
                            <h2 id="ai-lesson-hero-course" class="text-xl md:text-2xl font-black text-white mb-1.5 leading-snug drop-shadow-sm" dir="rtl"></h2>
                            <p id="ai-lesson-hero-lesson" class="text-sm font-bold text-white/85 leading-snug" dir="rtl"></p>
                            <div class="mt-3 flex items-center gap-3">
                                <div class="flex-1 h-2 bg-black/25 rounded-full overflow-hidden ring-1 ring-white/20">
                                    <div id="ai-lesson-hero-bar" class="ai-hero-bar-fill h-full rounded-full bg-gradient-to-r from-white to-white/70" style="width:0%"></div>
                                </div>
                                <span id="ai-lesson-hero-count" class="text-[11px] font-black text-white/90 whitespace-nowrap"></span>
                            </div>
                        </div>
                    </div>
                </div>
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

    <!-- Firebase & Core Logic -->
    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
    <script type="module" src="/js/kai-ferga-main.js?v=6"></script>

    <!-- مۆدالی دەستکاریکردنی زمان -->
    <!-- مۆدالی گۆڕینی لۆگۆ/ئایکۆنی بەشی AI (تەنها ئەدمین) -->
    <div id="changeLogoModal" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden z-[135] overflow-y-auto">
        <div class="min-h-full flex items-center justify-center p-4">
            <div class="absolute inset-0" onclick="window.closeChangeLogoModal()"></div>
            <div id="changeLogoModalContent" class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 transition-all duration-300 translate-y-4 opacity-0">
                <button onclick="window.closeChangeLogoModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-t-3xl">
                    <h3 class="text-xl font-black text-white text-center">گۆڕینی لۆگۆ/ئایکۆنی بەش</h3>
                </div>
                <div class="p-6 space-y-5">
                    <div class="flex justify-center">
                        <div id="change-logo-preview-box" class="w-24 h-24 rounded-2xl flex items-center justify-center text-5xl bg-emerald-100 shadow-inner ring-2 ring-white dark:ring-gray-900 overflow-hidden">
                            <span id="change-logo-preview-content">🤖</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">🖼️ گالەری لۆگۆکان (public/logos/ai)</label>
                        <div id="change-logo-gallery" class="grid grid-cols-5 gap-2"></div>
                        <p class="text-gray-400 text-[11px] mt-2">بۆ گۆڕینی وێنەکان، فایلی SVG بکەرەوە لە <span dir="ltr" class="font-mono">public/logos/ai/</span> و ناوی فایلەکە بگۆڕە — لەوێوە بە شێوەیەکی ئاسان دەبینرێت.</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">ئایکۆنی ئیمۆجی</label>
                        <div id="change-logo-emoji-grid" class="grid grid-cols-5 gap-2"></div>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-2">وێنەی لۆگۆ</label>
                        <div onclick="document.getElementById('change-logo-file').click()" class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-emerald-500 transition">
                            <p class="text-emerald-600 dark:text-emerald-400 font-black text-sm">📤 هەڵبژاردنی وێنە</p>
                            <p class="text-gray-400 text-xs mt-1">JPEG، PNG، GIF</p>
                        </div>
                        <input type="file" id="change-logo-file" accept="image/*" class="hidden">
                    </div>
                    <button onclick="window.clearTopicLogo()" class="w-full bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 py-3 rounded-xl font-bold text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition">🗑️ سڕینەوە و گەڕانەوە بۆ ئایکۆنی بنەڕەتی</button>
                </div>
            </div>
        </div>
    </div>

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

</body>
</html>
