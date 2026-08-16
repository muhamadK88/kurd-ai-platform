<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زانیاری گشتی - کورد ئەی ئای</title>

    <link rel="icon" href="/favicon.png" type="image/png">

    <meta name="description" content="زانیاری گشتی - کورد ئەی ئای">
    <meta name="keywords" content="زانیاری, کورد ئەی ئای, فێربوون">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/general-info">
    <meta property="og:title" content="زانیاری گشتی - KURD AI">
    <meta property="og:description" content="زانیاری گشتی - کورد ئەی ئای">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/general-info">
    <meta property="twitter:title" content="زانیاری گشتی - KURD AI">
    <meta property="twitter:description" content="زانیاری گشتی - کورد ئەی ئای">
    <meta property="twitter:image" content="https://kurd-ai.com/logo.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(75, 85, 99, 0.5);
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* --- زانیاری گشتی: دیزاینی تایبەت --- */
        @keyframes giFadeUp { 0% { opacity: 0; transform: translateY(30px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes giShine { 0% { left: -85%; } 100% { left: 155%; } }
        @keyframes giFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes giSpinSlow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        .gi-fade-up { animation: giFadeUp 0.7s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .gi-card { position: relative; overflow: hidden; }
        .gi-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 5px;
            background: linear-gradient(90deg, #f59e0b, #10b981, #06b6d4, #8b5cf6, #f59e0b);
            background-size: 300% 300%; animation: giSpinSlow 8s linear infinite;
        }
        .gi-card:hover .gi-shine { animation: giShine 1.2s ease-in-out; }
        .gi-shine { position: absolute; top: 0; bottom: 0; width: 45%; background: linear-gradient(115deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.35) 50%, rgba(255,255,255,0) 100%); transform: skewX(-18deg); left: -85%; pointer-events: none; }
        .gi-type-chip { display: inline-flex; align-items: center; gap: 0.35rem; }
        .gi-code-block { background: #0f172a; color: #e2e8f0; border: 1px solid #334155; }
        .dark .gi-code-block { background: #020617; border-color: #1e293b; }
        .gi-code-block pre { white-space: pre-wrap; overflow-wrap: anywhere; font-family: 'Fira Code', 'JetBrains Mono', monospace; direction: ltr; text-align: left; }
        .gi-result-box { background: linear-gradient(135deg, rgba(16,185,129,0.08), rgba(6,182,212,0.08)); border: 1px solid rgba(16,185,129,0.25); }
        .dark .gi-result-box { background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(6,182,212,0.1)); border-color: rgba(16,185,129,0.35); }
        .gi-video-frame { aspect-ratio: 16/9; }
        .gi-empty-orb { animation: giFloat 4s ease-in-out infinite; }
        .gi-prose { overflow-wrap: anywhere; }
        .gi-prose h1, .gi-prose h2, .gi-prose h3 { font-weight: 900; color: #f59e0b; margin-top: 1em; margin-bottom: 0.5em; }
        .gi-prose h4 { font-weight: 900; color: #10b981; margin-top: 1em; margin-bottom: 0.4em; }
        .gi-prose p { margin-bottom: 0.9em; line-height: 2; }
        .gi-prose ul { list-style: disc; padding-right: 1.5em; margin-bottom: 0.9em; }
        .gi-prose ol { list-style: decimal; padding-right: 1.5em; margin-bottom: 0.9em; }
        .gi-prose li { margin-bottom: 0.35em; }
        .gi-prose a { color: #10b981; font-weight: 700; text-decoration: underline; }
        .gi-prose strong { color: #f59e0b; font-weight: 900; }
        .gi-prose blockquote { border-right: 4px solid #10b981; background: rgba(16,185,129,0.08); padding: 0.75em 1em; border-radius: 0.75em; margin-bottom: 0.9em; }
        .gi-prose img { border-radius: 1.25rem; box-shadow: 0 18px 40px -18px rgba(0,0,0,0.4); margin: 1em 0; }
        .gi-prose code { background: rgba(16,185,129,0.12); color: #10b981; padding: 0.15em 0.45em; border-radius: 0.4em; font-size: 0.9em; direction: ltr; unicode-bidi: embed; }
        .gi-prose pre { background: #0f172a; color: #e2e8f0; padding: 1em; border-radius: 1rem; direction: ltr; text-align: left; overflow-x: auto; margin-bottom: 1em; }
        .gi-prose pre code { background: transparent; color: inherit; padding: 0; }
        .gi-prose table { width: 100%; border-collapse: collapse; margin-bottom: 1em; }
        .gi-prose th, .gi-prose td { border: 1px solid rgba(148,163,184,0.3); padding: 0.6em 0.8em; text-align: right; }
        .gi-prose th { background: rgba(245,158,11,0.1); font-weight: 900; }
        .gi-prose hr { border-color: rgba(148,163,184,0.3); margin: 1em 0; }
        @media (prefers-reduced-motion: reduce) { .gi-fade-up, .gi-card::before, .gi-shine, .gi-empty-orb { animation: none !important; transition: none !important; } }
    </style>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    @include('partials.nav', ['active' => 'general-info'])

    <!-- Header -->
    <header class="relative min-h-[40vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-amber-400 dark:bg-amber-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-emerald-400 dark:bg-emerald-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-cyan-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
            <div class="kai-holo-grid absolute inset-0"></div>
            <div class="kai-scanlines absolute inset-0"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-50 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-700/50 text-amber-700 dark:text-amber-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="lang-str" data-so="هەموو زانیارییە گشتییەکان لە یەک شوێن" data-ba="هەمی زانیارییێن گشتی ل یەک جیه">هەموو زانیارییە گشتییەکان لە یەک شوێن</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-4 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="زانیاری گشتی" data-ba="زانیاری گشتی">زانیاری گشتی</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="وێنە، ڤیدیۆ، کۆد، ئەنجام و هەموو جۆرە نوسینێک" data-ba="وێنە، ڤیدیۆ، کۆد، ئەنجام و هەمی جۆرە نڤیسینێک">وێنە، ڤیدیۆ، کۆد، ئەنجام و هەموو جۆرە نوسینێک</p>
        </div>
    </header>

    <!-- Content Grid -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="gi-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-start max-w-7xl mx-auto">
            <!-- کارتەکان لە JSـەوە دەردەکەون -->
        </div>
    </section>

    <!-- Admin Section -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4" id="admin-form-section">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-5xl mx-auto relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-500 via-emerald-500 to-cyan-500"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white lang-str" data-so="بەڕێوەبردنی زانیاری گشتی (ئەدمین)" data-ba="بەرێڤەبیرنا زانیاریێن گشتی (ئەدمین)">بەڕێوەبردنی زانیاری گشتی (ئەدمین)</h3>

            <div class="flex flex-wrap gap-3 mb-10 border-b border-gray-200 dark:border-gray-700 pb-6 relative z-10">
                <button id="tab-btn-add" onclick="switchAdminTab('add')" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all">1. زیادکردنی نوێ</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-bold border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">2. بەڕێوەبردن (دەستکاری/سڕینەوە)</button>
            </div>

            <!-- 1. Form Add -->
            <form id="form-add" class="admin-form relative z-10">
                <input type="hidden" id="gi_edit_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">سەردێڕ (سۆرانی)</label>
                        <input type="text" id="gi_title_so" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">سەردێڕ (بادینی)</label>
                        <input type="text" id="gi_title_ba" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوەڕۆک (سۆرانی) — دەتوانیت HTML بنووسیت</label>
                        <textarea id="gi_content_so" rows="8" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all resize-y custom-scrollbar font-mono text-sm" dir="rtl" placeholder="&lt;h3&gt;سەردێڕ&lt;/h3&gt;&lt;p&gt;دەق...&lt;/p&gt;"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوەڕۆک (بادینی) — دەتوانیت HTML بنووسیت</label>
                        <textarea id="gi_content_ba" rows="8" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all resize-y custom-scrollbar font-mono text-sm" dir="rtl" placeholder="&lt;h3&gt;سەردێڕ&lt;/h3&gt;&lt;p&gt;دەق...&lt;/p&gt;"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">وێنەی سەرەکی</label>
                        <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                            <input type="file" id="gi_image_file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="text-center pointer-events-none">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 lang-str" data-so="کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە" data-ba="بیتک بکە یان وێنەکە ڕاکێشە بۆ ڤیرێ">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                            </div>
                        </div>
                        <p id="gi_image_url_text" class="text-[11px] text-gray-400 mt-2 break-all hidden"></p>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">بەستەری ڤیدیۆ (یوتیوب)</label>
                        <input type="url" id="gi_video_url" dir="ltr" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all text-left font-mono text-sm">
                        <p class="text-[11px] text-gray-400 mt-2 lang-str" data-so="بەستەری یوتیوب لێرە دابنێ بۆ لەخۆگرتنی ڤیدیۆکە" data-ba="ناڤێ گرێدانا یوتیوب ل ڤیرێ دەنە بۆ هەلگرتنا ڤیدیۆیێ">بەستەری یوتیوب لێرە دابنێ بۆ لەخۆگرتنی ڤیدیۆکە</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کۆد (ئەگەر هەیە)</label>
                        <textarea id="gi_code" rows="8" dir="ltr" class="w-full px-5 py-4 bg-[#0f172a] border border-gray-700 text-emerald-300 rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all resize-y custom-scrollbar font-mono text-sm text-left" placeholder="print('Hello, Kurd AI!')"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ئەنجام / دەرئەنجام (ئەگەر هەیە)</label>
                        <textarea id="gi_result" rows="8" dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-emerald-500 focus:outline-none transition-all resize-y custom-scrollbar font-mono text-sm text-left" placeholder="Hello, Kurd AI!"></textarea>
                    </div>
                </div>

                <button type="submit" id="gi-submit-btn" class="w-full bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 text-white py-4 rounded-2xl font-black text-lg shadow-lg shadow-emerald-500/25 hover:-translate-y-1 transition-all">سەیڤکردن</button>
            </form>

            <!-- 2. Form Manage -->
            <div id="form-manage" class="admin-form hidden relative z-10">
                <div id="gi-manage-list" class="space-y-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2"></div>
            </div>
        </div>
    </section>

    <!-- Modal: پیشاندانی تەواوی ناوەڕۆک -->
    <div id="giModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="window.closeGiModal()"></div>
        <div class="glass-card relative w-full max-w-4xl rounded-[2.5rem] p-6 md:p-10 shadow-2xl transform transition-all translate-y-4 opacity-0 max-h-[90vh] flex flex-col overflow-hidden" id="giModalContent">
            <button onclick="window.closeGiModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div id="giModalBody" class="custom-scrollbar overflow-y-auto pr-2 flex-grow my-2 space-y-6">
                <!-- ناوەڕۆک لە JSـەوە -->
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200/50 dark:border-gray-700/50 text-left">
                <button onclick="window.closeGiModal()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">داخستن</button>
            </div>
        </div>
    </div>

    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
    <script type="module">
        import { initializeApp, getApps, getApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
        const app = getApps().length ? getApp() : initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

        const ADMIN_EMAILS = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"];
        let currentLang = localStorage.getItem('site-lang') || 'so';
        let giData = {};
        let isAdmin = false;

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        const giDict = {
            video: currentLang === 'so' ? 'ڤیدیۆ' : 'ڤیدیۆ',
            code: currentLang === 'so' ? 'کۆد' : 'کۆد',
            result: currentLang === 'so' ? 'ئەنجام' : 'ئەنجام',
            copy: currentLang === 'so' ? 'کۆپی' : 'کۆپی',
            empty: currentLang === 'so' ? 'هێشتا هیچ زانیارییەک نەدانراوە' : 'هێشتا هیچ زانیارییەک نەهاتیە دانان',
            author: currentLang === 'so' ? 'لەلایەن ئەدمین' : 'ژ لایێ ئەدمین'
        };

        function getYouTubeId(url) {
            if (!url) return '';
            const m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/|live\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
            return m ? m[1] : '';
        }

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            renderGiCards();
        }

        function renderGiCards() {
            const container = document.getElementById('gi-container');
            if (!container) return;
            container.innerHTML = '';

            const ids = Object.keys(giData).sort((a, b) => (giData[b].createdAt || 0) - (giData[a].createdAt || 0));
            if (ids.length === 0) {
                container.innerHTML = `
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 py-24 text-center">
                        <div class="gi-empty-orb mx-auto mb-8 w-28 h-28 rounded-[2.5rem] glass-card flex items-center justify-center rotate-12">
                            <svg class="w-12 h-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-bold text-2xl">${giDict.empty}</p>
                    </div>`;
                return;
            }

            ids.forEach((id, i) => {
                const item = giData[id];
                const title = loc(item, 'title');
                const img = item.image_url || '';
                const vid = getYouTubeId(item.video_url || '');
                const code = item.code || '';
                const result = item.result || '';
                const hasContent = !!(item['content_so'] || item['content_ba']);
                const preview = (loc(item, 'content') || '').replace(/<[^>]*>/g, ' ').trim().slice(0, 130);
                const chips = [];

                if (img) chips.push(`<div class="gi-type-chip px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-700/50 text-xs font-bold"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>وێنە</div>`);
                if (vid) chips.push(`<div class="gi-type-chip px-3 py-1 rounded-full bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-700/50 text-xs font-bold"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>${giDict.video}</div>`);
                if (code) chips.push(`<div class="gi-type-chip px-3 py-1 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-700/50 text-xs font-bold"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>${giDict.code}</div>`);
                if (result) chips.push(`<div class="gi-type-chip px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-700/50 text-xs font-bold"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>${giDict.result}</div>`);

                container.innerHTML += `
                    <div class="glass-card rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 p-6 md:p-8 flex flex-col h-full gi-card gi-fade-up group" style="animation-delay:${i * 80}ms">
                        <span class="gi-shine"></span>
                        ${img ? `<img src="${img}" alt="${title}" loading="lazy" class="w-full h-48 object-cover rounded-[1.75rem] mb-6 group-hover:scale-[1.02] transition-transform duration-500">` : ''}
                        <h3 class="text-xl md:text-2xl font-black text-gray-900 dark:text-white mb-3 line-clamp-2">${title}</h3>
                        ${hasContent && preview ? `<p class="text-gray-500 dark:text-gray-400 text-sm leading-7 mb-5 line-clamp-3 flex-grow">${preview}</p>` : (img || vid || code || result) ? `<p class="text-gray-400 dark:text-gray-500 text-xs mb-5 flex-grow">${giDict.author} · ${new Date(item.createdAt || Date.now()).toLocaleDateString('ckb')}</p>` : ''}
                        <div class="flex flex-wrap gap-2 mb-5">${chips.join('')}</div>
                        <button onclick="window.openGiModal('${id}')" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-gradient-to-l from-amber-500 to-orange-500 text-white font-bold rounded-2xl shadow-md shadow-amber-500/20 group-hover:shadow-amber-500/40 hover:-translate-y-0.5 transition-all">
                            <span class="lang-str" data-so="زانیاریی زیاتر" data-ba="زانیاریی پتر">زانیاریی زیاتر</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </button>
                    </div>`;
            });
        }

        window.openGiModal = function(id) {
            const item = giData[id];
            if (!item) return;
            const title = loc(item, 'title');
            const img = item.image_url || '';
            const vid = getYouTubeId(item.video_url || '');
            const code = item.code || '';
            const result = item.result || '';
            const content = loc(item, 'content') || '';

            let html = `
                <div class="text-center">
                    <h3 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4">${title}</h3>
                </div>`;

            if (img) html += `<img src="${img}" alt="${title}" class="w-full max-h-[480px] object-contain rounded-[2rem] shadow-xl">`;

            if (vid) html += `
                <div class="gi-video-frame rounded-[2rem] overflow-hidden glass-card shadow-xl">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/${vid}" title="YouTube" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>`;

            if (content) html += `<div class="gi-prose text-gray-700 dark:text-gray-300 text-base leading-loose">${content}</div>`;

            if (code) html += `
                <div>
                    <p class="text-xs font-black text-indigo-400 mb-2 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>${giDict.code}</p>
                    <div class="gi-code-block rounded-2xl p-5 overflow-x-auto custom-scrollbar relative">
                        <button onclick="copyGiCode()" class="absolute top-3 left-3 px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition">${giDict.copy}</button>
                        <pre class="text-sm leading-7">${code.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
                    </div>
                </div>`;

            if (result) html += `
                <div>
                    <p class="text-xs font-black text-emerald-400 mb-2 flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>${giDict.result}</p>
                    <div class="gi-result-box rounded-2xl p-5">
                        <pre class="text-sm leading-7 text-gray-800 dark:text-gray-200 whitespace-pre-wrap font-mono">${result.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')}</pre>
                    </div>
                </div>`;

            document.getElementById('giModalBody').innerHTML = html;
            const modal = document.getElementById('giModal');
            const contentBox = document.getElementById('giModalContent');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => contentBox.classList.remove('translate-y-4', 'opacity-0'), 10);
        };

        window.closeGiModal = function() {
            const modal = document.getElementById('giModal');
            const contentBox = document.getElementById('giModalContent');
            contentBox.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        };

        window.copyGiCode = function() {
            const pre = document.querySelector('#giModalBody .gi-code-block pre');
            if (!pre) return;
            navigator.clipboard.writeText(pre.innerText).then(() => alert('کۆدی کۆپی کرا')).catch(() => {});
        };

        function renderManageList() {
            const list = document.getElementById('gi-manage-list');
            if (!list) return;
            list.innerHTML = '';
            const ids = Object.keys(giData).sort((a, b) => (giData[b].createdAt || 0) - (giData[a].createdAt || 0));
            if (ids.length === 0) {
                list.innerHTML = `<div class="glass-card rounded-2xl p-8 text-center text-gray-500 font-bold">${giDict.empty}</div>`;
                return;
            }
            ids.forEach(id => {
                const item = giData[id];
                list.innerHTML += `
                    <div class="glass-card rounded-2xl p-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            ${item.image_url ? `<img src="${item.image_url}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">` : `<div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>`}
                            <div class="min-w-0">
                                <p class="font-bold text-sm text-gray-800 dark:text-gray-200 truncate">${item.title_so || item.title_ba || '?'}</p>
                                <p class="text-xs text-gray-400">${new Date(item.createdAt || Date.now()).toLocaleDateString('ckb')}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <button onclick="window.editGi('${id}')" class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 rounded-lg text-xs font-bold hover:bg-blue-100 transition">دەستکاری</button>
                            <button onclick="window.deleteGi('${id}')" class="px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-300 rounded-lg text-xs font-bold hover:bg-red-100 transition">سڕینەوە</button>
                        </div>
                    </div>`;
            });
        }

        window.editGi = function(id) {
            const item = giData[id];
            if (!item) return;
            switchAdminTab('add');
            document.getElementById('gi_edit_id').value = id;
            document.getElementById('gi_title_so').value = item.title_so || '';
            document.getElementById('gi_title_ba').value = item.title_ba || '';
            document.getElementById('gi_content_so').value = item.content_so || '';
            document.getElementById('gi_content_ba').value = item.content_ba || '';
            document.getElementById('gi_video_url').value = item.video_url || '';
            document.getElementById('gi_code').value = item.code || '';
            document.getElementById('gi_result').value = item.result || '';
            const urlText = document.getElementById('gi_image_url_text');
            if (item.image_url) {
                urlText.textContent = 'وێنە: ' + item.image_url;
                urlText.classList.remove('hidden');
            } else {
                urlText.classList.add('hidden');
            }
            document.getElementById('form-add').scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        window.deleteGi = async function(id) {
            if (!confirm('دڵنیایت لە سڕینەوەی ئەم زانیارییە؟')) return;
            await remove(dbRef(db, 'general_info/' + id));
            alert('بە سەرکەوتوویی سڕایەوە');
        };

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            const data = await res.json();
            return data.data.url;
        }

        document.getElementById('form-add').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('gi-submit-btn');
            btn.disabled = true; btn.innerText = "جێبەجێ دەکرێت...";
            const editId = document.getElementById('gi_edit_id').value;
            try {
                let imageUrl = editId && giData[editId] ? giData[editId].image_url : '';
                const file = document.getElementById('gi_image_file').files[0];
                if (file) imageUrl = await uploadImage(file);

                const data = {
                    title_so: document.getElementById('gi_title_so').value,
                    title_ba: document.getElementById('gi_title_ba').value,
                    content_so: document.getElementById('gi_content_so').value,
                    content_ba: document.getElementById('gi_content_ba').value,
                    image_url: imageUrl,
                    video_url: document.getElementById('gi_video_url').value,
                    code: document.getElementById('gi_code').value,
                    result: document.getElementById('gi_result').value,
                    createdAt: editId && giData[editId] ? (giData[editId].createdAt || Date.now()) : Date.now()
                };

                if (editId) await update(dbRef(db, 'general_info/' + editId), data);
                else await set(push(dbRef(db, 'general_info')), data);

                alert("بە سەرکەوتوویی جێبەجێکرا!");
                e.target.reset();
                document.getElementById('gi_edit_id').value = '';
                document.getElementById('gi_image_url_text').classList.add('hidden');
            } catch (err) {
                alert('هەڵە: ' + err.message);
            } finally {
                btn.disabled = false; btn.innerText = "سەیڤکردن";
            }
        });

        window.switchAdminTab = function(tabName) {
            document.querySelectorAll('.admin-form').forEach(f => f.classList.add('hidden'));
            document.querySelectorAll('#admin-form-section [id^="tab-btn-"]').forEach(b => {
                b.className = "px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-bold border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all";
            });
            document.getElementById('tab-btn-' + tabName).className = "px-8 py-3 bg-gradient-to-r from-emerald-500 to-cyan-500 text-white rounded-xl font-bold shadow-md transition-all";
            if (tabName === 'add') document.getElementById('form-add').classList.remove('hidden');
            else {
                document.getElementById('form-manage').classList.remove('hidden');
                renderManageList();
            }
        };

        const langToggleBtn = document.getElementById('lang-toggle');
        if (langToggleBtn) langToggleBtn.addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        const themeBtn = document.getElementById('theme-toggle');
        if (themeBtn) themeBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) logoutBtn.addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));

        onValue(dbRef(db, 'general_info'), (s) => {
            giData = s.val() || {};
            applyLanguage();
            if (isAdmin) renderManageList();
        });

        onAuthStateChanged(auth, (user) => {
            if (user && ADMIN_EMAILS.includes(user.email)) {
                isAdmin = true;
                document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                renderManageList();
            }
        });
    </script>
@include('components.chat-widget')
</body>
</html>