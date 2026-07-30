<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کۆرسەکانمان - کورد ئەی ئای</title>

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
                <a href="/courses" class="px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <a href="/ai-tools" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="تووڵەکانی AI" data-ba="ئامرازێن AI">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
            </div>

            <div class="flex items-center gap-3">
                <div id="lang-tabs" class="flex gap-1 bg-gray-100 dark:bg-gray-800/50 p-1 rounded-xl border border-gray-200/50 dark:border-gray-700/50">
                    <button class="lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all" data-lang="so">سۆرانی</button>
                    <button class="lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all" data-lang="ba">بادینی</button>
                    <button class="lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all" data-lang="ar">العربية</button>
                    <button class="lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all" data-lang="en">English</button>
                </div>
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

    <!-- بەشی هێدەر بە دیزاینی مۆدێرن -->
    <header class="relative min-h-[50vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <!-- باکگراوندی جوڵاو -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-400 dark:bg-indigo-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="کۆرسەکانمان" data-ba="کۆرسێن مە">کۆرسەکانمان</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی" data-ba="شیانێن خۆ پێشبێخە دگەل باشترین کۆرسێن ژیرییا دەستکرد و پرۆگرامسازییێ">پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی</p>
        </div>
    </header>

    <!-- بەشی کەتێگۆری فلتەر -->
    <section class="relative z-10 container mx-auto px-4 pb-8">
        <div id="category-tabs" class="flex flex-wrap gap-3 justify-center max-w-5xl mx-auto"></div>
    </section>

    <!-- بەشی پیشاندانی کۆرسەکان -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="courses-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"></div>
    </section>

    <!-- بەشی زیادکردنی کۆرس (تایبەت بە ئەدمین) -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-4xl mx-auto border-t-4 border-indigo-600 relative overflow-hidden">
            <!-- دەیکۆرەیشنی ناو فۆڕم -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white lang-str" data-so="زیادکردنی کۆرسی نوێ (ئەدمین)" data-ba="زێدەکرنا کۆرسێ نوی (ئەدمین)">زیادکردنی کۆرسی نوێ</h3>
            
            <form id="upload-form" class="relative z-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناونیشان (سۆرانی)</label>
                        <input type="text" id="title_so" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناونیشان (بادینی)</label>
                        <input type="text" id="title_ba" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (سۆرانی)</label>
                        <textarea id="desc_so" rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (بادینی)</label>
                        <textarea id="desc_ba" rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناونیشان (عەرەبی)</label>
                        <input type="text" id="title_ar" dir="rtl" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناونیشان (ئینگلیزی)</label>
                        <input type="text" id="title_en" dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (عەرەبی)</label>
                        <textarea id="desc_ar" rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (ئینگلیزی)</label>
                        <textarea id="desc_en" rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="بەستەری ڤیدیۆ (لینکی یوتیوب یان درایڤ)" data-ba="لینکا ڤیدیۆیێ">بەستەری ڤیدیۆ</label>
                        <input type="url" id="video_url" required dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">نرخ بە دۆلار (بۆ خۆڕایی بنووسە 0)</label>
                        <input type="number" id="price" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="کەتێگۆری (Category)" data-ba="کەتێگۆری (Category)">کەتێگۆری</label>
                    <select id="category" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                        <option value="پرۆگرامسازی">پرۆگرامسازی (Programming)</option>
                        <option value="داتا و زیرەکی دەستکرد">داتا و زیرەکی دەستکرد (Data & AI)</option>
                        <option value="دیزاین">دیزاین (Design)</option>
                        <option value="ئاسایشی ئەلیکترۆنی">ئاسایشی ئەلیکترۆنی (Cyber Security)</option>
                        <option value="کلود و داتابەیس">کلود و داتابەیس (Cloud & Database)</option>
                        <option value="بزنس و بەرھەمھێنان">بزنس و بەرھەمھێنان (Business)</option>
                        <option value="زمان">زمان (Language)</option>
                        <option value="ڤیدیۆ و مۆنتاژ">ڤیدیۆ و مۆنتاژ (Video Editing)</option>
                    </select>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="وێنەی کۆرس (ئەپڵۆدکردن)" data-ba="وێنێ کۆرسێ">وێنەی کۆرس</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                        <input type="file" id="course_image_input" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all">زیادکردنی کۆرس</button>
            </form>
        </div>
    </section>

    <!-- سکرێپتەکان -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a"; 

        // ----- بەشی زمان (Multi-Language Support) -----
        const langNames = { so: 'سۆرانی', ba: 'بادینی', ar: 'العربية', en: 'English' };
        let currentLang = localStorage.getItem('site-lang') || 'so';
        let firebaseDataCache = {}; 

        function applyLanguage() {
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so') || el.innerText;
            });

            document.querySelectorAll('.lang-tab').forEach(btn => {
                const lang = btn.dataset.lang;
                if (lang === currentLang) {
                    btn.className = 'lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow-sm';
                } else {
                    btn.className = 'lang-tab px-3 py-1.5 rounded-lg text-sm font-bold transition-all text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-gray-700/50';
                }
            });

            renderCategoryTabs(firebaseDataCache);
            renderCourses(firebaseDataCache);
        }

        document.getElementById('lang-tabs').addEventListener('click', (e) => {
            const btn = e.target.closest('.lang-tab');
            if (!btn) return;
            const lang = btn.dataset.lang;
            if (lang === currentLang) return;
            currentLang = lang;
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        // ----- category config -----
        const categoryConfig = {
            'پرۆگرامسازی': { icon: '💻', color: 'from-blue-600 to-cyan-500', bg: 'bg-blue-100 dark:bg-blue-900/30', text: 'text-blue-700 dark:text-blue-300', border: 'border-blue-200 dark:border-blue-800' },
            'داتا و زیرەکی دەستکرد': { icon: '🧠', color: 'from-purple-600 to-pink-500', bg: 'bg-purple-100 dark:bg-purple-900/30', text: 'text-purple-700 dark:text-purple-300', border: 'border-purple-200 dark:border-purple-800' },
            'دیزاین': { icon: '🎨', color: 'from-pink-600 to-rose-500', bg: 'bg-pink-100 dark:bg-pink-900/30', text: 'text-pink-700 dark:text-pink-300', border: 'border-pink-200 dark:border-pink-800' },
            'ئاسایشی ئەلیکترۆنی': { icon: '🔒', color: 'from-red-600 to-orange-500', bg: 'bg-red-100 dark:bg-red-900/30', text: 'text-red-700 dark:text-red-300', border: 'border-red-200 dark:border-red-800' },
            'کلود و داتابەیس': { icon: '☁️', color: 'from-sky-600 to-teal-500', bg: 'bg-sky-100 dark:bg-sky-900/30', text: 'text-sky-700 dark:text-sky-300', border: 'border-sky-200 dark:border-sky-800' },
            'بزنس و بەرھەمھێنان': { icon: '💼', color: 'from-emerald-600 to-green-500', bg: 'bg-emerald-100 dark:bg-emerald-900/30', text: 'text-emerald-700 dark:text-emerald-300', border: 'border-emerald-200 dark:border-emerald-800' },
            'زمان': { icon: '🌐', color: 'from-yellow-600 to-amber-500', bg: 'bg-yellow-100 dark:bg-yellow-900/30', text: 'text-yellow-700 dark:text-yellow-300', border: 'border-yellow-200 dark:border-yellow-800' },
            'ڤیدیۆ و مۆنتاژ': { icon: '🎬', color: 'from-violet-600 to-indigo-500', bg: 'bg-violet-100 dark:bg-violet-900/30', text: 'text-violet-700 dark:text-violet-300', border: 'border-violet-200 dark:border-violet-800' },
            'گشتی': { icon: '📚', color: 'from-gray-600 to-slate-500', bg: 'bg-gray-100 dark:bg-gray-800/30', text: 'text-gray-700 dark:text-gray-300', border: 'border-gray-200 dark:border-gray-700' }
        };

        const categoryOrder = ['پرۆگرامسازی', 'داتا و زیرەکی دەستکرد', 'دیزاین', 'ئاسایشی ئەلیکترۆنی', 'کلود و داتابەیس', 'بزنس و بەرھەمھێنان', 'زمان', 'ڤیدیۆ و مۆنتاژ'];

        let activeCategory = null;

        function courseCardHTML(c, showCategory) {
            const title = c[`title_${currentLang}`] || c.title_so || c.title || '';
            const desc = c[`desc_${currentLang}`] || c.desc_so || c.description || '';
            const btnText = currentLang === 'en' ? 'Start' : currentLang === 'ar' ? 'ابدأ' : currentLang === 'ba' ? 'دەستپێکرن' : 'دەستپێکردن';
            const freeText = currentLang === 'so' ? 'خۆڕایی' : 'بێ بەرامبەر';
            const priceBadge = c.price && c.price != 0 ? `$${c.price}` : freeText;
            const cat = c.category || 'گشتی';
            const cfg = categoryConfig[cat] || categoryConfig['گشتی'];
            const catLabel = currentLang === 'so' ? cat : cat;

            return `
                <div class="glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-300 overflow-hidden flex flex-col group hover:-translate-y-2">
                    <div class="h-48 w-full relative overflow-hidden bg-gray-200 dark:bg-gray-800">
                        <img src="${c.image_url}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="absolute top-3 right-3 flex gap-2">
                            ${showCategory ? `<span class="${cfg.bg} ${cfg.text} px-3 py-1 rounded-full text-xs font-bold backdrop-blur-md border ${cfg.border} shadow-lg">${cfg.icon} ${catLabel}</span>` : ''}
                            <span class="bg-white/90 dark:bg-[#0a0f1c]/90 text-gray-900 dark:text-white backdrop-blur-md px-3 py-1 rounded-full font-black text-xs shadow-lg border border-gray-200/50 dark:border-gray-700/50">${priceBadge}</span>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow relative bg-white/50 dark:bg-[#111827]/50">
                        <h3 class="font-black text-xl mb-2 text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">${title}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 line-clamp-2 leading-relaxed">${desc}</p>
                        <div class="mt-auto pt-4 border-t border-gray-200/50 dark:border-gray-700/50">
                            <a href="${c.video_url}" target="_blank" class="w-full block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                ${btnText}
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderCategoryTabs(data) {
            const tabsContainer = document.getElementById('category-tabs');
            if (!tabsContainer) return;

            const cats = {};
            for (let id in data) {
                const lang = currentLang;
                const hasContent = data[id][`title_${lang}`] || data[id][`desc_${lang}`];
                const cat = data[id].category || 'گشتی';
                cats[cat] = (cats[cat] || 0) + 1;
            }

            const catsToShow = categoryOrder.filter(c => cats[c]);
            const others = Object.keys(cats).filter(c => !categoryOrder.includes(c));
            const allCats = ['all', ...catsToShow, ...others.sort()];

            const langLabels = { so: 'هەموو', ba: 'هەموو', ar: 'الكل', en: 'All' };
            const allText = langLabels[currentLang] || 'All';

            tabsContainer.innerHTML = allCats.map(cat => {
                const isAll = cat === 'all';
                const cfg = isAll ? null : (categoryConfig[cat] || categoryConfig['گشتی']);
                const label = isAll ? allText : cat;
                const count = isAll ? Object.keys(data).length : cats[cat];
                const isActive = isAll ? activeCategory === null : activeCategory === cat;

                return `
                    <button class="category-tab px-5 py-2.5 rounded-2xl font-bold text-sm transition-all duration-300 flex items-center gap-2
                        ${isActive 
                            ? (isAll ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : `${cfg.bg} ${cfg.text} shadow-lg`) 
                            : 'bg-white/50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 border border-gray-200/50 dark:border-gray-700/50'
                        }
                    " data-category="${cat}">
                        ${isAll ? '' : `<span>${cfg.icon}</span>`}
                        <span>${label}</span>
                        <span class="text-xs opacity-60">(${count})</span>
                    </button>
                `;
            }).join('');

            tabsContainer.querySelectorAll('.category-tab').forEach(btn => {
                btn.addEventListener('click', () => {
                    const cat = btn.dataset.category;
                    activeCategory = cat === 'all' ? null : cat;
                    renderCategoryTabs(data);
                    renderCourses(data);
                });
            });
        }

        function renderCourses(data) {
            const container = document.getElementById('courses-container');
            if (!container) return;
            container.innerHTML = "";

            if (!data || Object.keys(data).length === 0) {
                const emptyText = currentLang === 'so' ? 'هێشتا هیچ کۆرسێک زیاد نەکراوە' : 'هێشتا چ کۆرس نەهاتینە زێدەکرن';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">${emptyText}</p></div>`;
                return;
            }

            let filtered = [];
            for (let id in data) {
                const cat = data[id].category || 'گشتی';
                if (activeCategory === null || cat === activeCategory) {
                    filtered.push({ ...data[id], id });
                }
            }

            if (filtered.length === 0) {
                const emptyText = currentLang === 'so' ? 'هیچ کۆرسێک لەم کەتێگۆریەدا نییە' : 'چ کۆرس د ڤی کەتێگۆریێدا نینە';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">${emptyText}</p></div>`;
                return;
            }

            const showCategory = activeCategory === null;
            container.innerHTML = filtered.map(c => courseCardHTML(c, showCategory)).join('');
        }

        onValue(dbRef(db, 'courses'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderCategoryTabs(firebaseDataCache);
            renderCourses(firebaseDataCache);
        });

        applyLanguage();

        // ----- ناردنی فۆرم بۆ فایەربەیس -----
        let isUploading = false;
        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault(); 
            const file = document.getElementById('course_image_input').files[0];
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
                        
                        await set(push(dbRef(db, 'courses')), {
                            title_so: document.getElementById('title_so').value,
                            title_ba: document.getElementById('title_ba').value,
                            title_ar: document.getElementById('title_ar').value,
                            title_en: document.getElementById('title_en').value,
                            desc_so: document.getElementById('desc_so').value,
                            desc_ba: document.getElementById('desc_ba').value,
                            desc_ar: document.getElementById('desc_ar').value,
                            desc_en: document.getElementById('desc_en').value,
                            video_url: document.getElementById('video_url').value,
                            price: document.getElementById('price').value,
                            category: document.getElementById('category').value,
                            image_url: url
                        });

                        alert("بە سەرکەوتوویی زیادکرا!");
                        document.getElementById('upload-form').reset();
                        submitBtn.innerText = "زیادکردنی کۆرس";
                        submitBtn.classList.remove('opacity-70', 'cursor-wait');
                        isUploading = false;
                    } else {
                        throw new Error("سێرڤەر وەڵامی نەدایەوە");
                    }
                } catch (error) {
                    alert("نەتوانرا زیاد بکرێت، دڵنیابە لە هێڵی ئینتەرنێتەکەت یان قەبارەی وێنەکە");
                    submitBtn.innerText = "زیادکردنی کۆرس";
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
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
            }
        });
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>