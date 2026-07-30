<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تووڵەکانی ئەی ئای - کورد ئەی ئای</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="description" content="ئامرازەکانی زیرەکی دەستکرد - کورد ئەی ئای">
    <meta name="keywords" content="ئامراز, AI, زیرەکی دەستکرد, تووڵ, کورد ئەی ئای">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/ai-tools">
    <meta property="og:title" content="تووڵەکانی ئەی ئای - KURD AI">
    <meta property="og:description" content="باشترین ئامرازەکانی زیرەکی دەستکرد بۆ بەرزکردنەوەی بەرهەمهێنان">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/ai-tools">
    <meta property="twitter:title" content="تووڵەکانی ئەی ئای - KURD AI">
    <meta property="twitter:description" content="باشترین ئامرازەکانی زیرەکی دەستکرد بۆ بەرزکردنەوەی بەرهەمهێنان">
    <meta property="twitter:image" content="https://kurd-ai.com/logo.jpg">
<!-- Favicon (وێنە بچووکەکەی سەرەوەی تابەکە) -->
<link rel="icon" href="/favicon.png" type="image/png">

<!-- Meta Tags (بۆ سۆشیاڵ میدیا و گوگڵ) -->
<meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">

<!-- تایبەت بە فەیسبووک، تێلیگرام و نامەکان (Open Graph) -->
<meta property="og:type" content="website">
<meta property="og:title" content="کورد ئەی ئای - Kurd AI">
<meta property="og:description" content="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی.">
<meta property="og:image" content="/logo.jpg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
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
        
        // پشکنین بۆ دارک مۆد پێش کردنەوەی پەڕەکە
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
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- ناڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-lg border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 hover:opacity-80 transition group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 text-white font-black text-xl group-hover:scale-105 transition-transform">ئـ</div>
                <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-blue-500 dark:from-blue-400 dark:to-cyan-300 lang-str" data-so="کورد ئەی ئای" data-ba="کورد ئەی ئای">کورد ئەی ئای</h1>
            </a>

            <div class="hidden md:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <a href="/" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <!-- تووڵەکان چالاککراوە (Active) -->
                <a href="/ai-tools" class="px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition lang-str" data-so="تووڵەکانی AI" data-ba="ئامرازێن AI">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
            </div>
            </div>

            <div class="flex items-center gap-3">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-sm border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 dark:hover:bg-blue-800/50 transition">
                    <span id="lang-text">بادینی</span>
                </button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                    <svg id="theme-toggle-light-icon" class="hidden dark:block w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="block dark:hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>
                <button id="logout-btn" class="flex items-center gap-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50 px-4 py-2 rounded-xl hover:bg-red-500 hover:text-white dark:hover:bg-red-600 dark:hover:text-white font-bold text-sm transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</span>
                </button>
            </div>

        </div>
    </nav>

    <!-- بەشی هێدەر بە دیزاینی مۆدێرن (ڕەنگی وەنەوشەیی/پەمەیی) -->
    <header class="relative min-h-[45vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <!-- باکگراوندی جوڵاو -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 dark:bg-purple-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-pink-500 dark:bg-pink-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 dark:bg-indigo-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-700/50 text-purple-700 dark:text-purple-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="lang-str" data-so="ئامرازە زیرەکەکان بۆ ئاسانکردنی کارەکان" data-ba="ئامرازێن ژیر بۆ بساناهیکرنا کاران">ئامرازە زیرەکەکان بۆ ئاسانکردنی کارەکان</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="تووڵەکانی ئەی ئای" data-ba="ئامرازێن ئەی ئای">تووڵەکانی ئەی ئای</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="باشترین ئامرازەکانی زیرەکی دەستکرد بدۆزەرەوە بۆ بەرزکردنەوەی بەرهەمهێنانت" data-ba="باشترین ئامرازێن ژیرییا دەستکرد ببینە بۆ بڵندکرنا بەرهەمهێنانێ">باشترین ئامرازەکانی زیرەکی دەستکرد بدۆزەرەوە بۆ بەرزکردنەوەی بەرهەمهێنانت</p>
        </div>
    </header>

    <!-- بەشی پیشاندانی تووڵەکان -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="tools-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"></div>
    </section>

    <!-- بەشی زیادکردنی تووڵ (تایبەت بە ئەدمین) -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-4xl mx-auto border-t-4 border-purple-600 relative overflow-hidden">
            <!-- دەیکۆرەیشنی ناو فۆڕم -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white lang-str" data-so="زیادکردنی تووڵی نوێ (ئەدمین)" data-ba="زێدەکرنا ئامرازێ نوی (ئەدمین)">زیادکردنی تووڵی نوێ</h3>
            
            <form id="upload-form" class="relative z-10">
                <input type="hidden" id="image_url_hidden">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوی تووڵ (سۆرانی)</label>
                        <input type="text" id="title_so" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوی ئامراز (بادینی)</label>
                        <input type="text" id="title_ba" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (سۆرانی)</label>
                        <textarea id="desc_so" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (بادینی)</label>
                        <textarea id="desc_ba" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="بەستەری تووڵەکە (لینک)" data-ba="لینکا ئامرازی">بەستەری تووڵەکە (لینک)</label>
                    <input type="url" id="tool_url" required dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="لۆگۆی تووڵەکە (ئەپڵۆدکردن)" data-ba="لۆگۆیێ ئامرازی">لۆگۆی تووڵەکە</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                        <input type="file" id="tool_image_input" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-purple-500/30 hover:-translate-y-1 transition-all">زیادکردنی تووڵ</button>
            </form>
        </div>
    </section>

    <!-- سکرێپتەکان -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a"; 

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let firebaseDataCache = {};
        let currentUserId = null;
        let userFavorites = {};

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) {
                langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            }

            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });

            renderTools(firebaseDataCache);
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        // ----- هێنان و پیشاندانی تووڵەکان بە دیزاینی مۆدێرن -----
        function renderTools(data) {
            const container = document.getElementById('tools-container');
            if (!container) return;
            container.innerHTML = "";

            if (!data || Object.keys(data).length === 0) {
                const emptyText = currentLang === 'so' ? 'هێشتا هیچ تووڵێک زیاد نەکراوە' : 'هێشتا چ ئامراز نەهاتینە زێدەکرن';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">${emptyText}</p></div>`;
                return;
            }

            for (let id in data) {
                const t = data[id];
                const title = currentLang === 'ba' && t.title_ba ? t.title_ba : t.title_so || t.title; 
                const desc = currentLang === 'ba' && t.desc_ba ? t.desc_ba : t.desc_so || t.description;
                const btnText = currentLang === 'so' ? 'بەکارهێنان' : 'ب کارئینان';

                container.innerHTML += `
                    <div class="tool-card glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 p-8 flex flex-col h-full group hover:-translate-y-2 hover:border-purple-200 dark:hover:border-purple-800 border border-transparent">
                        <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-lg mb-6 bg-white dark:bg-gray-800 flex-shrink-0 flex items-center justify-center p-3 border border-gray-100 dark:border-gray-700 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 relative">
                            <img src="${t.image_url}" class="w-full h-full object-contain">
                            <button onclick="window.toggleToolFav('${t.id || t.fb_id}', event)" class="absolute -top-2 -right-2 w-8 h-8 flex items-center justify-center rounded-full backdrop-blur-md transition-all duration-200 shadow-lg ${userFavorites && userFavorites[t.id || t.fb_id] ? 'bg-red-500 text-white scale-110' : 'bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 hover:text-red-500 hover:scale-110'}" title="${currentLang === 'so' ? 'دڵخواز' : 'دڵخواز'}">
                                <svg class="w-[14px] h-[14px]" fill="${userFavorites && userFavorites[t.id || t.fb_id] ? 'currentColor' : 'none'}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </button>
                        </div>
                        <h3 class="font-black text-2xl mb-3 text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">${title}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-8 flex-grow line-clamp-3 leading-relaxed">${desc}</p>
                        <div class="mt-auto pt-5 border-t border-gray-200/50 dark:border-gray-700/50">
                            <a href="${t.tool_url}" target="_blank" class="w-full block bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white text-center py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-purple-500/30 hover:shadow-pink-500/40 hover:-translate-y-0.5 flex items-center justify-center gap-2 group/btn">
                                ${btnText}
                                <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                `;
            }
        }

        window.toggleToolFav = function(toolId, event) {
            if(event) event.stopPropagation();
            if (!currentUserId) return;
            const favRef = dbRef(db, 'favorites/' + currentUserId + '/ai_tools/' + toolId);
            if (userFavorites && userFavorites[toolId]) {
                remove(favRef);
            } else {
                set(favRef, { favoritedAt: Date.now() });
            }
        };
        onValue(dbRef(db, 'ai_tools'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderTools(firebaseDataCache);
        });

        applyLanguage();

        // ----- ناردنی فۆرم بۆ فایەربەیس -----
        let isUploading = false;
        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault(); 
            const file = document.getElementById('tool_image_input').files[0];
            const submitBtn = document.getElementById('submit-form-btn');
            
            if(file) {
                if(isUploading) return;
                isUploading = true;
                submitBtn.innerText = "خەریکە ئەپڵۆد دەکرێت... (کەمێک چاوەڕێ بکە)"; 
                submitBtn.classList.add('opacity-70', 'cursor-wait');

                try {
                    const formData = new FormData();
                    formData.append("image", file);

                    const response = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, {
                        method: 'POST',
                        body: formData
                    });
                    
                    const resData = await response.json();
                    
                    if(resData.success) {
                        const url = resData.data.url;
                        
                        await set(push(dbRef(db, 'ai_tools')), {
                            title_so: document.getElementById('title_so').value,
                            title_ba: document.getElementById('title_ba').value,
                            desc_so: document.getElementById('desc_so').value,
                            desc_ba: document.getElementById('desc_ba').value,
                            tool_url: document.getElementById('tool_url').value,
                            image_url: url
                        });

                        alert("تووڵەکە بە سەرکەوتوویی زیادکرا!");
                        document.getElementById('upload-form').reset();
                        submitBtn.innerText = "زیادکردنی تووڵ";
                        submitBtn.classList.remove('opacity-70', 'cursor-wait');
                        isUploading = false;
                    } else {
                        throw new Error("سێرڤەر وەڵامی نەدایەوە");
                    }
                } catch (error) {
                    alert("نەتوانرا زیاد بکرێت، دڵنیابە لە هێڵی ئینتەرنێتەکەت یان قەبارەی وێنەکە");
                    submitBtn.innerText = "زیادکردنی تووڵ";
                    submitBtn.classList.remove('opacity-70', 'cursor-wait');
                    isUploading = false;
                }
            }
        });

        // Theme Toggle
        document.getElementById('theme-toggle').addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        // Auth Check
        onAuthStateChanged(auth, (user) => { 
            if(!user) window.location.href = "/login"; 
            else {
                document.body.style.display = 'block';
                currentUserId = user.uid;
                onValue(dbRef(db, 'favorites/' + user.uid + '/ai_tools'), (snap) => {
                    userFavorites = snap.val() || {};
                    renderTools(firebaseDataCache);
                });
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
            }
        });
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>