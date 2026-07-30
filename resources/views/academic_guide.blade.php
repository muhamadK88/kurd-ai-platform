<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="lang-str" data-so="ڕێنیشاندەری ئەکادیمی - کورد ئەی ئای" data-ba="ڕێبەرێ ئەکادیمی - کورد ئەی ئای">ڕێنیشاندەری ئەکادیمی - کورد ئەی ئای</title>
<!-- Favicon (وێنە بچووکەکەی سەرەوەی تابەکە) -->
<link rel="icon" href="/favicon.png" type="image/png">

<!-- Meta Tags (بۆ سۆشیاڵ میدیا و گوگڵ) -->
<meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">

<!-- تایبەت بە فەیسبووک، تێلیگرام و نامەکان (Open Graph) -->
<meta property="og:type" content="website">
<meta property="og:title" content="کورد ئەی ئای - Kurd AI">
<meta property="og:description" content="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی.">
<meta property="og:image" content="/logo.jpg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="description" content="ڕێنیشاندەری ئەکادیمی کورد ئەی ئای - ڕێنمایی زانکۆ و خوێندن">
    <meta name="keywords" content="ڕێنیشاندەر, ئەکادیمی, زانکۆ, کورد ئەی ئای, خوێندن">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/academic-guide">
    <meta property="og:title" content="ڕێنیشاندەری ئەکادیمی - KURD AI">
    <meta property="og:description" content="ڕێنمایی زانکۆ و خوێندن بۆ خوێندکارانی کورد">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/academic-guide">
    <meta property="twitter:title" content="ڕێنیشاندەری ئەکادیمی - KURD AI">
    <meta property="twitter:description" content="ڕێنمایی زانکۆ و خوێندن بۆ خوێندکارانی کورد">
    <meta property="twitter:image" content="https://kurd-ai.com/logo.jpg">

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
                    animation: { 'blob': 'blob 7s infinite' },
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
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.75);
            border: 1px solid rgba(75, 85, 99, 0.4);
        }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
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
    <a href="/academic-guide" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
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

    <!-- Header -->
    <header class="relative min-h-[45vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-teal-500 dark:bg-teal-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-emerald-500 dark:bg-emerald-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-teal-50 dark:bg-teal-900/30 border border-teal-200 dark:border-teal-700/50 text-teal-700 dark:text-teal-300 font-extrabold text-sm mb-6 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="lang-str" data-so="زانیارییە ئەکادیمییەکان" data-ba="زانیاریێن ئەکادیمی">زانیارییە ئەکادیمییەکان</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="ڕێنیشاندەری ئەکادیمی" data-ba="ڕێبەرێ ئەکادیمی">ڕێنیشاندەری ئەکادیمی</h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 font-medium max-w-2xl mx-auto mb-10 lang-str" data-so="هەموو ئەو زانیارییانەی پێویستتە بۆ سەرکەوتن لە پرۆسەی خوێندنت لێرە بدۆزەرەوە." data-ba="هەموو ئەو زانیاریێن پێویست بۆ سەرکەفتنێ د پرۆسەیا خوەندنێ دا لێرە ببینە.">هەموو ئەو زانیارییانەی پێویستتە بۆ سەرکەوتن لە پرۆسەی خوێندنت لێرە بدۆزەرەوە.</p>
            
            <!-- Live Search Bar -->
            <div class="max-w-xl mx-auto relative">
                <input type="text" id="search-input" placeholder="گەڕان بەناو پرسیار و ڕێنیشاندەرەکاندا..." class="w-full px-6 py-4 rounded-2xl glass-card text-gray-800 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-teal-500/30 shadow-lg text-lg transition">
                <svg class="w-6 h-6 text-gray-400 absolute left-5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </header>

    <!-- Guide Content -->
    <section class="container mx-auto pb-24 px-4 max-w-4xl">
        <div id="guide-container" class="space-y-6">
            <!-- Dynamic Data Will Load Here -->
        </div>
    </section>

    <!-- Admin Section -->
    <section class="admin-only hidden container mx-auto pb-24 px-4" id="admin-form-section">
        <div class="glass-card p-10 md:p-16 rounded-[3rem] shadow-2xl max-w-4xl mx-auto border-t-8 border-teal-500">
            <h3 class="text-4xl font-black mb-12 text-center text-gray-900 dark:text-white">بەشی بەڕێوەبردنی ڕێنیشاندەر</h3>
            <form id="upload-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" id="question_so" placeholder="پرسیار (سۆرانی)" required class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all">
                    <input type="text" id="question_ba" placeholder="پرسیار (بادینی)" required class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <textarea id="answer_so" placeholder="وەڵام (سۆرانی)" required rows="5" class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all"></textarea>
                    <textarea id="answer_ba" placeholder="وەڵام (بادینی)" required rows="5" class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all"></textarea>
                </div>
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-teal-600 to-emerald-600 text-white py-5 rounded-2xl font-black text-xl hover:shadow-2xl hover:shadow-teal-500/30 hover:-translate-y-1 transition-all">پاشەکەوتکردنی زانیارییەکان</button>
            </form>
        </div>
    </section>

    <!-- Script Section -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref, push, set, onValue, remove, update } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        let firebaseDataCache = {};
        let isAdmin = false;
        let editId = null;
        let currentLang = localStorage.getItem('site-lang') || 'so';
        let searchQuery = '';

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) {
                langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            }

            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            
            const searchInput = document.getElementById('search-input');
            if(searchInput) {
                searchInput.placeholder = currentLang === 'so' ? 'گەڕان بەناو پرسیار و ڕێنیشاندەرەکاندا...' : 'گەڕان دناڤ پرسیار و ڕێبەران دا...';
            }

            renderGuide(firebaseDataCache);
        }

        function renderGuide(data) {
            const container = document.getElementById('guide-container');
            if (!container) return;
            container.innerHTML = "";

            let hasItems = false;
            for (let id in data) {
                const item = data[id];
                const q = (currentLang === 'so' ? item.question_so : item.question_ba) || item.question_so;
                const a = (currentLang === 'so' ? item.answer_so : item.answer_ba) || item.answer_so;

                if (searchQuery && !q.toLowerCase().includes(searchQuery.toLowerCase()) && !a.toLowerCase().includes(searchQuery.toLowerCase())) {
                    continue;
                }

                hasItems = true;
                container.innerHTML += `
                    <div class="glass-card rounded-[2rem] border-l-4 border-teal-500 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden">
                        <button onclick="window.toggleAccordion('${id}')" class="w-full p-8 text-right flex justify-between items-center gap-4 focus:outline-none">
                            <h3 class="font-black text-2xl md:text-3xl text-gray-900 dark:text-white">${q}</h3>
                            <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center shrink-0 transition-transform duration-300" id="icon-${id}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>
                        <div id="content-${id}" class="hidden px-8 pb-8 pt-2 border-t border-gray-100 dark:border-gray-800/50">
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg whitespace-pre-line">${a}</p>
                            ${isAdmin ? `
                                <div class="mt-8 flex gap-4 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                                    <button onclick="window.editGuide('${id}')" class="px-6 py-2.5 rounded-xl bg-amber-500 text-white font-black hover:bg-amber-600 transition text-sm">دەستکاری</button>
                                    <button onclick="window.deleteGuide('${id}')" class="px-6 py-2.5 rounded-xl bg-red-600 text-white font-black hover:bg-red-700 transition text-sm">سڕینەوە</button>
                                </div>` : ''}
                        </div>
                    </div>
                `;
            }

            if (!hasItems) {
                container.innerHTML = `
                    <div class="glass-card p-12 rounded-[2rem] text-center">
                        <p class="text-gray-500 dark:text-gray-400 text-lg font-bold">هیچ زانیارییەک نەدۆزراوەتەوە.</p>
                    </div>
                `;
            }
        }

        window.toggleAccordion = (id) => {
            const content = document.getElementById(`content-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }

        window.deleteGuide = async (id) => { 
            if(confirm("دڵنیایت لە سڕینەوەی ئەم زانیارییە؟")) await remove(ref(db, 'academic_guide/' + id)); 
        }

        window.editGuide = (id) => {
            const item = firebaseDataCache[id];
            document.getElementById('question_so').value = item.question_so || '';
            document.getElementById('question_ba').value = item.question_ba || '';
            document.getElementById('answer_so').value = item.answer_so || '';
            document.getElementById('answer_ba').value = item.answer_ba || '';
            editId = id;
            document.getElementById('submit-form-btn').innerText = currentLang === 'so' ? "نوێکردنەوەی زانیارییەکان" : "نووژەنکرنا زانیارییان";
            window.scrollTo({ top: document.getElementById('admin-form-section').offsetTop - 50, behavior: 'smooth' });
        }

        document.getElementById('search-input').addEventListener('input', (e) => {
            searchQuery = e.target.value;
            renderGuide(firebaseDataCache);
        });

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        document.getElementById('theme-toggle').addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        onValue(ref(db, 'academic_guide'), (s) => { 
            firebaseDataCache = s.val() || {}; 
            renderGuide(firebaseDataCache); 
        });

        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = {
                question_so: document.getElementById('question_so').value,
                question_ba: document.getElementById('question_ba').value,
                answer_so: document.getElementById('answer_so').value,
                answer_ba: document.getElementById('answer_ba').value
            };
            if(editId) { 
                await update(ref(db, 'academic_guide/' + editId), data); 
                editId = null; 
                document.getElementById('submit-form-btn').innerText = "پاشەکەوتکردنی زانیارییەکان"; 
            } else { 
                await push(ref(db, 'academic_guide'), data); 
            }
            e.target.reset();
            alert("بە سەرکەوتوویی جێبەجێکرا!");
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            document.body.style.display = 'block';
            if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                isAdmin = true;
                document.querySelector('.admin-only').classList.remove('hidden');
            }
            applyLanguage();
        });
    </script>
</body>
</html>