<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تووڵەکانی ئەی ئای - کورد ئەی ئای</title>

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

        .cat-tab {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cat-tab::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .cat-tab:hover::before {
            opacity: 1;
        }
        .cat-tab.active {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px -5px rgba(147, 51, 234, 0.4);
        }
        .cat-tab:not(.active):hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .dark .cat-tab:not(.active):hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .cat-tab .tab-icon {
            transition: transform 0.3s ease;
        }
        .cat-tab:hover .tab-icon {
            transform: scale(1.15) rotate(-5deg);
        }
        .cat-tab.active .tab-icon {
            transform: scale(1.1);
        }
        .cat-tab .tab-badge {
            transition: all 0.3s ease;
        }
        .cat-tab.active .tab-badge {
            background: rgba(255,255,255,0.25);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .tool-card {
            animation: fadeInUp 0.5s ease forwards;
            opacity: 0;
        }
        .tool-card:nth-child(1) { animation-delay: 0.05s; }
        .tool-card:nth-child(2) { animation-delay: 0.1s; }
        .tool-card:nth-child(3) { animation-delay: 0.15s; }
        .tool-card:nth-child(4) { animation-delay: 0.2s; }
        .tool-card:nth-child(5) { animation-delay: 0.25s; }
        .tool-card:nth-child(6) { animation-delay: 0.3s; }
        .cat-header {
            animation: fadeInScale 0.4s ease forwards;
            opacity: 0;
        }
    </style>

    @include('partials.kurdai-design')

    <link rel="stylesheet" href="{{ asset('css/kai-tools.css') }}?v=4">
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    @include('partials.nav', ['active' => 'ai-tools'])

    <header class="relative min-h-[45vh] flex items-center justify-center overflow-hidden py-20 px-4">
<div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 dark:bg-purple-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-pink-500 dark:bg-pink-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-500 dark:bg-indigo-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
            <div class="kai-matrix absolute inset-0"></div>
            <div class="kai-scanlines absolute inset-0"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-50 dark:bg-purple-900/30 border border-purple-200 dark:border-purple-700/50 text-purple-700 dark:text-purple-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="lang-str" data-so="ئامرازە زیرەکەکان بۆ ئاسانکردنی کارەکان" data-ba="ئامرازێن ژیر بۆ ساناهیکرنا کاران">ئامرازە زیرەکەکان بۆ ئاسانکردنی کارەکان</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="تووڵەکانی ئەی ئای" data-ba="ئامرازێن ئەی ئای">تووڵەکانی ئەی ئای</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="باشترین ئامرازەکانی زیرەکی دەستکرد بدۆزەرەوە بۆ بەرزکردنەوەی بەرهەمهێنانت" data-ba="باشترین ئامرازێن ژیرییا دەستکرد ببینە بۆ بڵندکرنا بەرهەمهێنانێ">باشترین ئامرازەکانی زیرەکی دەستکرد بدۆزەرەوە بۆ بەرزکردنەوەی بەرهەمهێنانت</p>

            <!-- خوێندنەوەی داتا (Data Readout) -->
            <div class="mt-9 flex flex-wrap items-center justify-center gap-3" id="kai-data-stats" aria-hidden="true">
                <span class="kai-stat kai-stat-glow">
                    <span class="kai-stat-dot"></span>
                    <span class="lang-str" data-so="مۆدێلی ئۆنڵاین" data-ba="مۆدێل ئۆنلاین">مۆدێلی ئۆنڵاین</span>
                    <b class="kai-stat-num">247</b>
                </span>
                <span class="kai-stat">
                    <span class="lang-str" data-so="ئاژانسەکانی نمرە" data-ba="سەرچاوەیێن نمرە">ئاژانسەکانی نمرە</span>
                    <b class="kai-stat-num">ELO</b>
                </span>
                <span class="kai-stat">
                    <span class="lang-str" data-so="نوێکردنەوەی ڕاستەوخۆ" data-ba="نووژەکرنا راستەوخۆ">نوێکردنەوەی ڕاستەوخۆ</span>
                    <b class="kai-stat-num">LIVE</b>
                </span>
            </div>
        </div>
    </header>

    @include('partials.leaderboard')

    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="tools-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"></div>
    </section>

    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-4xl mx-auto border-t-4 border-purple-600 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white lang-str" data-so="زیادکردنی تووڵی نوێ (ئەدمین)" data-ba="زێدەکرنا ئامرازەکێ نوی (ئەدمین)">زیادکردنی تووڵی نوێ</h3>
            
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
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">پۆل (Category)</label>
                    <select id="tool_category" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                        <option value="وێنە (Image)">وێنە (Image)</option>
                        <option value="ڤیدیۆ (Video)">ڤیدیۆ (Video)</option>
                        <option value="کۆدکردن (Coding)">کۆدکردن (Coding)</option>
                        <option value="دەنگ (Audio)">دەنگ (Audio)</option>
                        <option value="بەرهەمهێنان (Productivity)">بەرهەمهێنان (Productivity)</option>
                        <option value="پێشکەشکردن (Presentation)">پێشکەشکردن (Presentation)</option>
                        <option value="بیرکاری (Math)">بیرکاری (Math)</option>
                        <option value="نووسین (Content)">نووسین (Content)</option>
                        <option value="تر (Other)">تر (Other)</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="بەستەری تووڵەکە (لینک)" data-ba="لینکا ئامرازێ">بەستەری تووڵەکە (لینک)</label>
                    <input type="url" id="tool_url" required dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-purple-500 focus:outline-none transition-all">
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="لۆگۆی تووڵەکە (ئەپڵۆدکردن)" data-ba="لۆگۆیێ ئامرازێ">لۆگۆی تووڵەکە</label>
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

    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
    <script type="module">
        import { getDatabase, ref as dbRef, push, set, onValue } from "/js/firebase10/firebase-database.js";

        const KaiF = window.KaiFirebase || {};
        const app = KaiF.app ? KaiF.app() : null;
        let db = app ? getDatabase(app) : null;
        const auth = KaiF.auth ? KaiF.auth() : null;
        const onAuthStateChanged = KaiF.onAuthStateChanged || function () {};
        const signOut = KaiF.signOut || (function () { return Promise.resolve(); });
        KaiTrack.visit('ai_tools');
        const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let firebaseDataCache = {}; 

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) {
                langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            }

            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });

            renderTools(firebaseDataCache);

            // let self-contained components (leaderboard) re-render their dynamic strings
            window.dispatchEvent(new CustomEvent('kai:langchange', { detail: { lang: currentLang } }));
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        let activeCategory = 'all';

        function renderTools(data) {
            const container = document.getElementById('tools-container');
            if (!container) return;
            container.innerHTML = "";

            if (!data || Object.keys(data).length === 0) {
                const emptyText = currentLang === 'so' ? 'هێشتا هیچ تووڵێک زیاد نەکراوە' : 'هێشتا چ ئامراز نەهاتینە زێدەکرن';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">${emptyText}</p></div>`;
                return;
            }

            const grouped = {};
            const catLabels = {
                'وێنە (Image)': 'وێنە', 'ڤیدیۆ (Video)': 'ڤیدیۆ',
                'کۆدکردن (Coding)': 'کۆدکردن', 'دەنگ (Audio)': 'دەنگ', 'بەرهەمهێنان (Productivity)': 'بەرهەمهێنان',
                'پێشکەشکردن (Presentation)': 'پێشکەشکردن', 'بیرکاری (Math)': 'بیرکاری', 'نووسین (Content)': 'نووسین',
                'تر (Other)': 'تر'
            };

            for (let id in data) {
                const t = data[id];
                const cat = t.category || 'تر (Other)';
                if (/chat\s*bot/i.test(cat) || (cat.includes('چات') && cat.includes('بۆت'))) continue;
                if (!grouped[cat]) grouped[cat] = [];
                grouped[cat].push({id, ...t});
            }

            const allCats = Object.keys(grouped).sort((a, b) => {
                const order = ['وێنە (Image)','ڤیدیۆ (Video)','کۆدکردن (Coding)','دەنگ (Audio)','بەرهەمهێنان (Productivity)','پێشکەشکردن (Presentation)','بیرکاری (Math)','نووسین (Content)','تر (Other)'];
                return order.indexOf(a) - order.indexOf(b);
            });

            const catIcons = {
                'وێنە (Image)': '🎨', 'ڤیدیۆ (Video)': '🎬',
                'کۆدکردن (Coding)': '💻', 'دەنگ (Audio)': '🎵', 'بەرهەمهێنان (Productivity)': '⚡',
                'پێشکەشکردن (Presentation)': '📊', 'بیرکاری (Math)': '🔢', 'نووسین (Content)': '✍️',
                'تر (Other)': '🔧'
            };
            const catColors = {
                'وێنە (Image)': 'from-pink-500 to-rose-400',
                'ڤیدیۆ (Video)': 'from-red-500 to-orange-400', 'کۆدکردن (Coding)': 'from-green-500 to-emerald-400',
                'دەنگ (Audio)': 'from-violet-500 to-purple-400', 'بەرهەمهێنان (Productivity)': 'from-amber-500 to-yellow-400',
                'پێشکەشکردن (Presentation)': 'from-indigo-500 to-blue-400', 'بیرکاری (Math)': 'from-teal-500 to-cyan-400',
                'نووسین (Content)': 'from-orange-500 to-amber-400', 'تر (Other)': 'from-gray-500 to-slate-400'
            };

            let tabsHtml = `<div class="col-span-1 md:col-span-2 lg:col-span-3 mb-10"><div class="flex flex-wrap gap-3 justify-center">`;

            tabsHtml += `
                <button onclick="setCategory('all')" class="cat-tab relative flex items-center gap-2.5 px-5 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 ${activeCategory === 'all' ? 'active bg-gradient-to-r from-purple-600 to-indigo-600 text-white shadow-xl shadow-purple-500/30 scale-105' : 'bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-700 dark:text-gray-300 border border-gray-200/50 dark:border-gray-700/50 hover:bg-purple-50 dark:hover:bg-gray-700/50'}" data-cat="all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>${currentLang === 'so' ? 'هەموو' : 'هەمی'}</span>
                    <span class="tab-badge text-xs px-2 py-0.5 rounded-full ${activeCategory === 'all' ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'}">${Object.keys(data).length}</span>
                </button>`;

            allCats.forEach(cat => {
                const label = catLabels[cat] || cat;
                const icon = catIcons[cat] || '🔧';
                const grad = catColors[cat] || 'from-gray-500 to-slate-400';
                tabsHtml += `
                <button onclick="setCategory('${cat.replace(/'/g, "\\'")}')" class="cat-tab relative flex items-center gap-2.5 px-5 py-3.5 rounded-2xl font-bold text-sm transition-all duration-300 ${activeCategory === cat ? 'active bg-gradient-to-r ' + grad + ' text-white shadow-xl shadow-purple-500/20 scale-105' : 'bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-700 dark:text-gray-300 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/50'}" data-cat="${cat.replace(/'/g, "&apos;")}">
                    <span class="tab-icon text-lg">${icon}</span>
                    <span>${label}</span>
                    <span class="tab-badge text-xs px-2 py-0.5 rounded-full ${activeCategory === cat ? 'bg-white/20 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400'}">${grouped[cat].length}</span>
                </button>`;
            });
            tabsHtml += `</div></div>`;
            container.innerHTML = tabsHtml;

            const categoriesToShow = activeCategory === 'all' ? allCats : [activeCategory];
            
            categoriesToShow.forEach(cat => {
                const tools = grouped[cat];
                if (!tools || tools.length === 0) return;
                const label = catLabels[cat] || cat;
                const icon = catIcons[cat] || '🔧';
                container.innerHTML += `
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 mt-6 mb-4 cat-header">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-lg shadow-lg shadow-purple-500/20">${icon}</div>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">${label}</h3>
                            <div class="h-px flex-1 bg-gradient-to-r from-purple-200/50 to-transparent dark:from-purple-800/30 ml-4"></div>
                        </div>
                    </div>`;

                tools.forEach((t, idx) => {
                    const title = currentLang === 'ba' && t.title_ba ? t.title_ba : t.title_so || t.title; 
                    const desc = currentLang === 'ba' && t.desc_ba ? t.desc_ba : t.desc_so || t.description;
                    const btnText = currentLang === 'so' ? 'بەکارهێنان' : 'ب کارئینان';

                    container.innerHTML += `
                        <div class="tool-card kai-matrix-card glass-card rounded-[2rem] shadow-sm hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-500 p-8 flex flex-col h-full group hover:-translate-y-2 hover:border-purple-200 dark:hover:border-purple-800 border border-transparent">
                            <header class="kai-tool-hud flex items-center justify-between mb-5">
<span class="kai-tool-idx font-mono text-[0.65rem] font-black tracking-[0.22em] text-purple-500/80 dark:text-purple-400/80">#${String(idx + 1).padStart(2, '0')}</span>
                                <span class="kai-tool-signal" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
                            </header>
                            <div class="w-20 h-20 rounded-2xl overflow-hidden shadow-lg mb-6 bg-white dark:bg-gray-800 flex-shrink-0 flex items-center justify-center p-3 border border-gray-100 dark:border-gray-700 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                                <img src="${t.image_url}" class="w-full h-full object-contain">
                            </div>
                            <h3 class="font-black text-2xl mb-3 text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">${title}</h3>
                            <div class="flex-grow mb-8"><p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">${desc}</p></div>
                            <div class="mt-auto pt-5 border-t border-gray-200/50 dark:border-gray-700/50">
                                <a href="${t.tool_url}" target="_blank" class="w-full block bg-gradient-to-r from-purple-600 to-pink-500 hover:from-purple-700 hover:to-pink-600 text-white text-center py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-purple-500/30 hover:shadow-pink-500/40 hover:-translate-y-0.5 flex items-center justify-center gap-2 group/btn">
                                    ${btnText}
                                    <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>
                    `;
                });
            });
        }

        window.setCategory = function(cat) {
            activeCategory = cat;
            renderTools(firebaseDataCache);
        };

        function subscribeTools(fdb) {
            onValue(dbRef(fdb, 'ai_tools'), (snapshot) => {
                firebaseDataCache = snapshot.val() || {};
                renderTools(firebaseDataCache);
            });
        }
        window.KaiPageReady(function () {
            if (db) subscribeTools(db);
            else if (KaiF.whenReady) KaiF.whenReady(function (S) { if (S && S.db) { db = S.db; subscribeTools(db); } });
        });

        applyLanguage();

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
                            image_url: url,
                            category: document.getElementById('tool_category').value
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

        document.getElementById('theme-toggle').addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        onAuthStateChanged((user) => { 
            if (user && ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
            }
        });
        document.getElementById('logout-btn').addEventListener('click', () => signOut().then(() => window.location.href = "/login"));
    </script>
</body>
</html>
