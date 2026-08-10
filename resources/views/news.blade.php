<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هەواڵەکان - کورد ئەی ئای</title>
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
    <meta name="description" content="هەواڵەکانی کورد ئەی ئای - دوایین هەواڵەکانی زیرەکی دەستکرد و تەکنەلۆژیا">
    <meta name="keywords" content="هەواڵ, کورد ئەی ئای, زیرەکی دەستکرد, تەکنەلۆژیا, AI">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/news">
    <meta property="og:title" content="هەواڵەکان - KURD AI">
    <meta property="og:description" content="دوایین هەواڵەکانی زیرەکی دەستکرد و تەکنەلۆژیا لە کورد ئەی ئای">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/news">
    <meta property="twitter:title" content="هەواڵەکان - KURD AI">
    <meta property="twitter:description" content="دوایین هەواڵەکانی زیرەکی دەستکرد و تەکنەلۆژیا لە کورد ئەی ئای">
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
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>

    @include('partials.kurdai-design')

    <link rel="stylesheet" href="{{ asset('css/kai-news.css') }}?v=3">
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- ناڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            
            <!-- بەشی لۆگۆ و ناوی پڕۆژە -->
            <a href="/" class="flex items-center gap-3 transition group relative">
                <div class="relative flex-shrink-0">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-full blur-xl opacity-0 group-hover:opacity-30 transition-all duration-300 dark:group-hover:opacity-50"></div>
                    <img src="logo.jpg" alt="Kurd AI Logo" class="h-10 md:h-11 w-auto object-contain dark:invert drop-shadow-md group-hover:scale-105 transition-transform duration-300 relative z-10">
                </div>
                
                <div class="flex flex-col justify-center hidden sm:flex">
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">
                        KURD AI
                    </h1>
                    <span class="text-[0.55rem] md:text-[0.60rem] font-black tracking-widest bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500 mt-0.5">
                        INNOVATION - FUTURE
                    </span>
                </div>
            </a>

            <!-- بەشە سەرەکییەکانی ناڤبار -->
           <div class="hidden lg:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
    <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
    <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
    <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
    <a href="/news" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</a>
    <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="تووڵەکان" data-ba="ئامراز">تووڵەکان</a>
    <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
    <a href="/universities" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
    <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="دەرباری ئێمە" data-ba="دەربارەی مە">دەرباری ئێمە</a>
</div>

            <!-- بەشی ئامرازەکان -->
            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
                <a href="/#feedback-section" class="lang-str px-3 py-2 bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300 font-bold rounded-xl text-xs border border-rose-100 dark:border-rose-800/50 hover:bg-rose-100 transition" data-so="ڕەخنە" data-ba="ڕەخنە">ڕەخنە</a>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50 lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</a>
                <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50 lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>
            </div>
            
        </div>
    </nav>

    <!-- هێدەری سەرەکی -->
    <header class="relative min-h-[40vh] flex items-center justify-center overflow-hidden py-16 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-sky-400 dark:bg-sky-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-sky-50 dark:bg-sky-900/30 border border-sky-200 dark:border-sky-700/50 text-sky-700 dark:text-sky-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                <span class="lang-str" data-so="نوێترین زانیاری و گۆڕانکارییەکان" data-ba="دوماهیک پێزانین و گۆڕانکاری">نوێترین زانیاری و گۆڕانکارییەکان</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-4 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="هەواڵ و پێشهاتەکان" data-ba="نووچە و پێشهات">هەواڵ و پێشهاتەکان</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="ئاگاداری نوێترین هەواڵەکانی تەکنەلۆژیا و ژیریی دەستکرد بە" data-ba="ئاگاداری دوماهیک نووچەیێن تەکنەلۆژیا و ژیرییا دەستکرد ببە">ئاگاداری نوێترین هەواڵەکانی تەکنەلۆژیا و ژیریی دەستکرد بە</p>
        </div>
    </header>

    <!-- بەشی زیادکردنی هەواڵ (تەنها بۆ ئەدمین) -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-16 px-4">
        <div class="glass-card p-8 rounded-[2rem] shadow-xl max-w-4xl mx-auto border-t-4 border-sky-500 relative overflow-hidden">
            <h3 class="text-2xl font-black mb-6 text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="lang-str" data-so="بڵاوکردنەوەی هەواڵی نوێ (ئەدمین)" data-ba="بەلاڤکرنا نووچەکا نوی (ئەدمین)">بڵاوکردنەوەی هەواڵی نوێ (ئەدمین)</span>
            </h3>
            
            <form id="add-news-form">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">سەردێڕ (سۆرانی)</label>
                        <input type="text" id="news_title_so" required class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">سەردێڕ (بادینی)</label>
                        <input type="text" id="news_title_ba" required class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوەرۆک (سۆرانی)</label>
                        <textarea id="news_content_so" required rows="4" class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none resize-none custom-scrollbar"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوەرۆک (بادینی)</label>
                        <textarea id="news_content_ba" required rows="4" class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none resize-none custom-scrollbar"></textarea>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">وێنەی هەواڵ</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 hover:bg-white/50 dark:hover:bg-gray-900/50 transition">
                        <input type="file" id="news_image" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <p class="text-sm font-bold text-gray-500 dark:text-gray-400">کلیک بکە بۆ هەڵبژاردنی وێنە</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">جۆر (Category)</label>
                        <select id="news_category" class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none">
                            <option value="General AI">General AI</option>
                            <option value="AI Agents">AI Agents</option>
                            <option value="Image Generation">Image Generation</option>
                            <option value="Finance & Business">Finance &amp; Business</option>
                            <option value="LLMs & Base Models">LLMs &amp; Base Models</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">تاگەکان (بە کۆما جیابکەرەوە)</label>
                        <input type="text" id="news_tags" placeholder="Base, Update, Research" class="w-full px-5 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 outline-none">
                    </div>
                </div>

                <button type="submit" id="submit-news-btn" class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white py-3.5 rounded-xl font-black text-lg hover:shadow-lg hover:-translate-y-1 transition-all">بڵاوکردنەوە</button>
            </form>
        </div>
    </section>

    <!-- فلتەرەکان: کاتەگۆری + بەروار -->
    <section class="relative z-10 container mx-auto px-4 pb-8 max-w-7xl">
        <div id="news-filters" class="glass-card rounded-[1.75rem] p-4 md:p-5 flex flex-col gap-4 shadow-lg">
            <!-- فلتەری بەروار -->
            <div class="flex flex-wrap items-center gap-2" id="date-filter" role="tablist">
                <span class="text-xs font-black text-gray-400 dark:text-gray-500 ms-1 me-1 uppercase tracking-widest lang-str" data-so="کات" data-ba="دەم">کات</span>
                <button data-range="all"       class="kai-chip is-active lang-str" data-so="هەموو" data-ba="هەمی">هەموو</button>
                <button data-range="today"     class="kai-chip lang-str" data-so="ئەمڕۆ" data-ba="ئەڤرۆ">ئەمڕۆ</button>
                <button data-range="yesterday" class="kai-chip lang-str" data-so="دوێنێ" data-ba="دهی">دوێنێ</button>
                <button data-range="week"      class="kai-chip lang-str" data-so="ئەم هەفتەیە" data-ba="ڤێ هەفتیێ">ئەم هەفتەیە</button>
            </div>
            <!-- فلتەری کاتەگۆری -->
            <div class="flex flex-wrap items-center gap-2 border-t border-gray-200/60 dark:border-gray-700/50 pt-4" id="category-filter">
                <span class="text-xs font-black text-gray-400 dark:text-gray-500 ms-1 me-1 uppercase tracking-widest lang-str" data-so="جۆر" data-ba="جۆر">جۆر</span>
                <button data-cat="all" class="kai-chip is-active lang-str" data-so="هەموو" data-ba="هەمی">هەموو</button>
                <!-- کاتەگۆرییەکان بە جاڤاسکریپت دروست دەکرێن -->
            </div>
        </div>
    </section>

    <!-- پیشاندانی هەواڵەکان -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="news-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
            <!-- هەواڵەکان لێرە دەردەکەون -->
        </div>
    </section>

    <!-- پەنجەرەی خوێندنەوە و کۆمێنت (Modal) -->
    <div id="newsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4 py-8">
        <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="window.closeNewsModal()"></div>
        
        <div class="glass-card relative w-full max-w-4xl max-h-[90vh] rounded-[2rem] shadow-2xl flex flex-col transform transition-all translate-y-4 opacity-0 overflow-hidden" id="modalContent">
            
            <button onclick="window.closeNewsModal()" class="absolute top-4 right-4 z-20 p-2 bg-black/50 text-white hover:bg-red-500 rounded-full transition backdrop-blur-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- ناوەرۆکی هەواڵەکە بۆ سکڕۆڵ -->
            <div class="overflow-y-auto custom-scrollbar flex-grow bg-white/40 dark:bg-gray-900/40">
                <!-- وێنە -->
                <div class="w-full h-64 md:h-80 relative bg-gray-200 dark:bg-gray-800">
                    <img id="modalImg" src="" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent"></div>
                    <div class="absolute bottom-6 px-6 md:px-8 w-full">
                        <span id="modalDate" class="text-sky-300 font-bold text-xs mb-2 block"></span>
                        <h2 id="modalTitle" class="text-2xl md:text-3xl font-black text-white leading-tight"></h2>
                    </div>
                </div>

                <!-- زانیاری زیادە: جۆر، تاگ، سەرچاوە -->
                <div class="px-6 md:px-8 pt-6 flex flex-wrap items-center gap-2" id="modalMeta"></div>

                <!-- تێکستی هەواڵ -->
                <div class="p-6 md:p-8 pt-4">
                    <p id="modalBody" class="text-gray-800 dark:text-gray-200 leading-loose text-sm md:text-base whitespace-pre-wrap font-medium"></p>
                    <a id="modalSource" href="#" target="_blank" rel="noopener noreferrer" class="hidden mt-6 items-center gap-2 text-sky-600 dark:text-sky-400 font-bold text-sm hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        <span class="lang-str" data-so="سەرچاوەی هەواڵ" data-ba="سەرچاوا نووچەیێ">سەرچاوەی هەواڵ</span>
                    </a>
                </div>

                <!-- بەشی کۆمێنتەکان -->
                <div class="p-6 md:p-8 bg-gray-50/80 dark:bg-[#0a0f1c]/80 border-t border-gray-200 dark:border-gray-800">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <span class="lang-str" data-so="بۆچوونەکان" data-ba="بۆچوون">بۆچوونەکان</span>
                    </h3>
                    
                    <div id="comments-list" class="space-y-4 mb-6 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                        <!-- کۆمێنتەکان لێرە دەردەکەون -->
                    </div>

                    <!-- فۆڕمی کۆمێنت -->
                    <form id="comment-form" class="flex gap-3">
                        <input type="hidden" id="current_news_id">
                        <input type="text" id="comment_input" required class="flex-grow px-5 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-sky-500 outline-none text-sm font-medium" placeholder="بۆچوونی خۆت بنووسە...">
                        <button type="submit" id="comment-btn" class="px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl transition shadow-md whitespace-nowrap">
                            ناردن
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- پەنجەرەی دەستکاری کردنی هەواڵ (Modal) -->
    <div id="editNewsModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeEditNewsModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 overflow-y-auto max-h-[90vh]" id="editNewsModalContent">
            <button onclick="window.closeEditNewsModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center lang-str" data-so="دەستکاری کردنی هەواڵ" data-ba="دەستکاریکرنا نووچەیێ">دەستکاری کردنی هەواڵ</h3>
                <form id="edit-news-form" class="space-y-5">
                    <input type="hidden" id="edit-news-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">سەردێڕ (سۆرانی)</label>
                            <input type="text" id="edit_news_title_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">سەردێڕ (بادینی)</label>
                            <input type="text" id="edit_news_title_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوەرۆک (سۆرانی)</label>
                            <textarea id="edit_news_content_so" required rows="4" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all text-sm resize-none custom-scrollbar"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوەرۆک (بادینی)</label>
                            <textarea id="edit_news_content_ba" required rows="4" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-sky-500 focus:outline-none transition-all text-sm resize-none custom-scrollbar"></textarea>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center lang-str" data-so="وێنەکە لە کاتی دەستکاری دا ناگۆڕدرێت" data-ba="وێنە د دەمێ دەستکاریێ دا ناهێتە گوهۆڕین">وێنەکە لە کاتی دەستکاری دا ناگۆڕدرێت</p>
                    <button type="submit" id="edit-news-submit-btn" class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-sky-500/30 hover:-translate-y-0.5 transition-all lang-str" data-so="پاشەکەوتکردن" data-ba="پاشەکەوتکرن">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Firebase Logic -->
    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="application/json" id="kurdai-imgbb-config">{!! json_encode(config('kurdai.imgbb.api_key'), 15) !!}</script>
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = JSON.parse((document.getElementById('kurdai-imgbb-config') || {}).textContent || 'null');

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let newsData = {};
        window.isAdmin = false;
        let currentUser = null;

        // فلتەری چالاک
        let activeRange = 'all';
        let activeCategory = 'all';

        // ناونیشانی کاتەگۆرییەکان بە هەردوو زاراوە (سۆرانی / بادینی)
        const CATEGORY_LABELS = {
            'AI Agents':            { so: 'ئەجێنتەکان',        ba: 'ئەجێنت' },
            'Image Generation':     { so: 'دروستکردنی وێنە',   ba: 'دروستکرنا وێنەیان' },
            'Finance & Business':   { so: 'دارایی و بازرگانی',  ba: 'دارایی و بازرگانی' },
            'LLMs & Base Models':   { so: 'مۆدێلە زمانییەکان',  ba: 'مۆدێلێن زمانی' },
            'General AI':           { so: 'ژیریی گشتی',        ba: 'ژیرییا گشتی' },
        };
        const catLabel = (cat) => (CATEGORY_LABELS[cat] ? CATEGORY_LABELS[cat][currentLang] || CATEGORY_LABELS[cat].so : cat);

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        // بەرواری هەواڵ لە published_at (ISO) یان timestamp (ms) وەردەگرێت
        const newsDate = (n) => n.published_at ? new Date(n.published_at) : (n.timestamp ? new Date(n.timestamp) : null);

        function inRange(n, range) {
            if (range === 'all') return true;
            const d = newsDate(n);
            if (!d) return false;
            const now = new Date();
            const startToday = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            if (range === 'today') return d >= startToday;
            if (range === 'yesterday') {
                const startYest = new Date(startToday); startYest.setDate(startYest.getDate() - 1);
                return d >= startYest && d < startToday;
            }
            if (range === 'week') {
                const weekAgo = new Date(startToday); weekAgo.setDate(weekAgo.getDate() - 7);
                return d >= weekAgo;
            }
            return true;
        }

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            buildCategoryChips();
            renderNews();
        }

        // دروستکردنی چیپەکانی کاتەگۆری لەسەر بنەمای ئەو هەواڵانەی هەن
        function buildCategoryChips() {
            const wrap = document.getElementById('category-filter');
            if (!wrap) return;
            const present = new Set();
            Object.values(newsData).forEach(n => { if (n && n.category) present.add(n.category); });

            // چیپی "هەموو" هەمیشە دەمێنێتەوە؛ ئەوانی تر لە نوێ دروست دەکرێن
            wrap.querySelectorAll('[data-cat]:not([data-cat="all"])').forEach(el => el.remove());
            present.forEach(cat => {
                const btn = document.createElement('button');
                btn.className = 'kai-chip' + (activeCategory === cat ? ' is-active' : '');
                btn.setAttribute('data-cat', cat);
                btn.textContent = catLabel(cat);
                wrap.appendChild(btn);
            });
            // نیشانکردنی چیپی چالاک
            wrap.querySelectorAll('[data-cat]').forEach(el => {
                el.classList.toggle('is-active', el.getAttribute('data-cat') === activeCategory);
            });
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        // فلتەری بەروار (کلیک لەسەر چیپەکان)
        document.getElementById('date-filter').addEventListener('click', (e) => {
            const btn = e.target.closest('[data-range]');
            if (!btn) return;
            activeRange = btn.getAttribute('data-range');
            document.querySelectorAll('#date-filter [data-range]').forEach(el =>
                el.classList.toggle('is-active', el === btn));
            renderNews();
        });

        // فلتەری کاتەگۆری
        document.getElementById('category-filter').addEventListener('click', (e) => {
            const btn = e.target.closest('[data-cat]');
            if (!btn) return;
            activeCategory = btn.getAttribute('data-cat');
            document.querySelectorAll('#category-filter [data-cat]').forEach(el =>
                el.classList.toggle('is-active', el === btn));
            renderNews();
        });

        document.getElementById('theme-toggle').addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark'); localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark'); localStorage.setItem('color-theme', 'dark');
            }
        });

        function formatDate(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleDateString('en-GB') + ' - ' + date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        onValue(dbRef(db, 'news'), (s) => { 
            newsData = s.val() || {}; 
            renderNews(); 
        });

        function renderNews() {
            const container = document.getElementById('news-container');
            if(!container) return;

            // FLIP: تۆمارکردنی شوێنی کارتەکان پێش نوێکردنەوە بۆ مۆرفی نەرم
            const firstRects = {};
            container.querySelectorAll('[data-fbid]').forEach(el => {
                firstRects[el.getAttribute('data-fbid')] = el.getBoundingClientRect();
            });

            container.innerHTML = '';

            let newsKeys = Object.keys(newsData).sort((a,b) => {
                const db = (newsData[b].published_at ? Date.parse(newsData[b].published_at) : newsData[b].timestamp) || 0;
                const da = (newsData[a].published_at ? Date.parse(newsData[a].published_at) : newsData[a].timestamp) || 0;
                return db - da;
            });

            // جێبەجێکردنی فلتەرەکان
            newsKeys = newsKeys.filter(id => {
                const n = newsData[id];
                if (!n) return false;
                if (!inRange(n, activeRange)) return false;
                if (activeCategory !== 'all' && n.category !== activeCategory) return false;
                return true;
            });

            if (newsKeys.length === 0) {
                const emptyTxt = currentLang === 'so' ? 'هیچ هەواڵێک بەم فلتەرە نەدۆزرایەوە.' : 'چ نووچە ب ڤی فلتەری نەهاتنە دیتن.';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 font-bold">${emptyTxt}</p></div>`;
                return;
            }

            newsKeys.forEach((id, idx) => {
                const n = newsData[id];
                const title = loc(n, 'title');
                const content = loc(n, 'content');
                const dateStr = formatDate(n.published_at ? Date.parse(n.published_at) : n.timestamp);
                const btnTxt = currentLang === 'so' ? 'خوێندنەوە و بۆچوون' : 'خواندن و بۆچوون';

                // پاککردنەوە بۆ ناو فەنکشن
                const safeTitle = (title || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                const safeContent = (content || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                const safeImg = (n.image_url || "").replace(/"/g, '&quot;');

                // بەیجی کاتەگۆری
                let catBadge = '';
                if (n.category) {
                    catBadge = `<span class="kai-cat-badge">${catLabel(n.category)}</span>`;
                }

                // تاگەکان
                let tagsHtml = '';
                if (Array.isArray(n.tags) && n.tags.length) {
                    tagsHtml = `<div class="flex flex-wrap gap-1.5 mb-3">` +
                        n.tags.slice(0,3).map(t => `<span class="kai-tag">#${t}</span>`).join('') +
                        `</div>`;
                }

                // نیشانەی هەواڵی خۆکار (AI)
                const autoBadge = n.is_automated ? `<span class="kai-auto-badge" title="AI">AI</span>` : '';

                let adminBtn = '';
                if(window.isAdmin) {
                    adminBtn = `
                        <div class="flex items-center gap-2 mt-2">
                            <button onclick="window.openEditNewsModal('${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-xl font-bold text-xs transition border border-amber-200 dark:border-amber-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                ${currentLang === 'so' ? 'دەستکاری' : 'دەستکاری'}
                            </button>
                            <button onclick="window.deleteNews('${id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100 rounded-xl font-bold text-xs transition border border-red-200 dark:border-red-800/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                ${currentLang === 'so' ? 'سڕینەوە' : 'سڕینەوە'}
                            </button>
                        </div>
                    `;
                }

                const card = document.createElement('div');
                card.className = 'kai-news-card glass-card rounded-[2rem] overflow-hidden flex flex-col group hover:-translate-y-2 hover:shadow-2xl hover:shadow-sky-500/10 transition-all duration-300';
                card.setAttribute('data-fbid', id);
                card.style.setProperty('--i', idx);
                card.innerHTML = `
                    <div class="relative h-52 overflow-hidden bg-gray-200 dark:bg-gray-800 cursor-pointer" onclick="window.openNewsModal('${id}', '${safeTitle}', '${safeContent}', '${safeImg}', '${dateStr}')">
                        <img src="${n.image_url}" loading="lazy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-70 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute top-3 right-3 flex items-center gap-2">${catBadge}${autoBadge}</div>
                        <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">${dateStr}</div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow bg-white/30 dark:bg-[#111827]/30">
                        ${tagsHtml}
                        <h3 class="font-black text-xl mb-3 text-gray-900 dark:text-white line-clamp-2 leading-tight">${title}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-5 line-clamp-3 leading-relaxed flex-grow font-medium">${content}</p>
                        <button onclick="window.openNewsModal('${id}', '${safeTitle}', '${safeContent}', '${safeImg}', '${dateStr}')" class="w-full py-3 bg-sky-50 dark:bg-sky-900/20 text-sky-600 dark:text-sky-400 font-bold rounded-xl hover:bg-sky-100 dark:hover:bg-sky-900/40 transition flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            ${btnTxt}
                        </button>
                        ${adminBtn}
                    </div>
                `;
                container.appendChild(card);
            });

            // FLIP: گواستنەوەی نەرم بۆ کارتەکانی پێشتر هەبوون + دەرکەوتنی زنجیرەیی بۆ نوێیەکان
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            container.querySelectorAll('[data-fbid]').forEach(el => {
                const id = el.getAttribute('data-fbid');
                const last = el.getBoundingClientRect();
                const first = firstRects[id];
                if (first && !reduce) {
                    const dx = first.left - last.left;
                    const dy = first.top - last.top;
                    if (dx || dy) {
                        el.style.transform = `translate(${dx}px, ${dy}px)`;
                        el.style.transition = 'transform 0s';
                        requestAnimationFrame(() => {
                            el.style.transition = 'transform 0.5s cubic-bezier(.22,1,.36,1)';
                            el.style.transform = '';
                        });
                    }
                } else if (!first) {
                    el.classList.add('kai-card-enter');
                }
            });
        }

        // --- ئەپڵۆد و زیادکردنی هەواڵ ---
        let isUploading = false;
        document.getElementById('add-news-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const file = document.getElementById('news_image').files[0];
            const btn = document.getElementById('submit-news-btn');
            
            if(file && !isUploading) {
                isUploading = true;
                btn.innerText = "چاوەڕێ بکە..."; btn.classList.add('opacity-70', 'cursor-wait');
                
                try {
                    const fd = new FormData(); fd.append("image", file);
                    const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: fd });
                    const rData = await res.json();
                    
                    if(rData.success) {
                        const tags = (document.getElementById('news_tags').value || '')
                            .split(',').map(t => t.trim()).filter(Boolean).slice(0, 3);
                        const now = Date.now();
                        const data = {
                            title_so: document.getElementById('news_title_so').value,
                            title_ba: document.getElementById('news_title_ba').value,
                            content_so: document.getElementById('news_content_so').value,
                            content_ba: document.getElementById('news_content_ba').value,
                            image_url: rData.data.url,
                            category: document.getElementById('news_category').value,
                            tags: tags,
                            status: 'published',
                            published_at: new Date(now).toISOString(),
                            timestamp: now
                        };
                        await set(push(dbRef(db, 'news')), data);
                        alert("هەواڵەکە بڵاوکرایەوە!");
                        e.target.reset();
                    }
                } catch(err) { alert("کێشەیەک ڕوویدا لە بارکردنی وێنەکە"); }
                
                isUploading = false;
                btn.innerText = "بڵاوکردنەوە"; btn.classList.remove('opacity-70', 'cursor-wait');
            }
        });

        window.deleteNews = async function(id) {
            if(confirm('دڵنیایت لە سڕینەوەی ئەم هەواڵە؟')) {
                await remove(dbRef(db, `news/${id}`));
            }
        };

        // ----- دەستکاری کردنی هەواڵ (Edit Modal) -----
        let editNewsData = null;

        window.openEditNewsModal = function(newsId) {
            const data = newsData[newsId];
            if (!data) {
                alert('نەتوانرا زانیاری هەواڵەکە بدۆزرێتەوە');
                return;
            }
            editNewsData = { fb_id: newsId, ...data };

            document.getElementById('edit-news-id').value = newsId;
            document.getElementById('edit_news_title_so').value = data.title_so || '';
            document.getElementById('edit_news_title_ba').value = data.title_ba || '';
            document.getElementById('edit_news_content_so').value = data.content_so || '';
            document.getElementById('edit_news_content_ba').value = data.content_ba || '';

            const modal = document.getElementById('editNewsModal');
            const content = document.getElementById('editNewsModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeEditNewsModal = function() {
            const modal = document.getElementById('editNewsModal');
            const content = document.getElementById('editNewsModalContent');
            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        document.getElementById('edit-news-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!editNewsData) return;

            const newsId = document.getElementById('edit-news-id').value;
            const submitBtn = document.getElementById('edit-news-submit-btn');
            submitBtn.innerText = "خەریکە پاشەکەوت دەکرێت...";
            submitBtn.classList.add('opacity-70', 'cursor-wait');

            try {
                // فیلدەکانی خۆکار (category, tags, source_url, ...) دەپارێزرێن
                const merged = { ...editNewsData };
                delete merged.fb_id;
                // comments دەمێننەوە وەک خۆیان (بەرزکردنەوەی کۆمێنتەکان)
                merged.title_so = document.getElementById('edit_news_title_so').value;
                merged.title_ba = document.getElementById('edit_news_title_ba').value;
                merged.content_so = document.getElementById('edit_news_content_so').value;
                merged.content_ba = document.getElementById('edit_news_content_ba').value;
                merged.image_url = editNewsData.image_url || '';
                merged.timestamp = editNewsData.timestamp || Date.now();
                await set(dbRef(db, 'news/' + newsId), merged);

                submitBtn.innerText = currentLang === 'so' ? 'پاشەکەوتکردن' : 'پاشەکەوتکرن';
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                window.closeEditNewsModal();
                alert('هەواڵەکە بە سەرکەوتوویی پاشەکەوت کرا');
            } catch (error) {
                submitBtn.innerText = currentLang === 'so' ? 'پاشەکەوتکردن' : 'پاشەکەوتکرن';
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                alert('هەڵەیەک ڕوویدا: ' + error.message);
            }
        });

        // --- مۆدێل و کۆمێنت ---
        let activeCommentsListener = null;

        window.openNewsModal = function(id, title, content, imgUrl, dateStr) {
            document.getElementById('modalImg').src = imgUrl;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalBody').innerText = content;
            document.getElementById('modalDate').innerText = dateStr;
            document.getElementById('current_news_id').value = id;

            // زانیاری زیادە: جۆر + تاگ + سەرچاوە
            const n = newsData[id] || {};
            const meta = document.getElementById('modalMeta');
            let metaHtml = '';
            if (n.category) metaHtml += `<span class="kai-cat-badge kai-inline">${catLabel(n.category)}</span>`;
            if (Array.isArray(n.tags)) metaHtml += n.tags.slice(0,3).map(t => `<span class="kai-tag">#${t}</span>`).join('');
            if (n.is_automated) metaHtml += `<span class="kai-auto-badge">AI</span>`;
            meta.innerHTML = metaHtml;

            const src = document.getElementById('modalSource');
            if (n.source_url) {
                src.href = n.source_url;
                src.classList.remove('hidden'); src.classList.add('inline-flex');
            } else {
                src.classList.add('hidden'); src.classList.remove('inline-flex');
            }

            const modal = document.getElementById('newsModal');
            const modalContent = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('translate-y-4', 'opacity-0');
                modalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            // لۆدکردنی کۆمێنتەکان تایبەت بەم هەواڵە
            const list = document.getElementById('comments-list');
            if(activeCommentsListener) activeCommentsListener(); // پاککردنەوەی لیسنەری پێشوو
            
            const commentsRef = dbRef(db, `news/${id}/comments`);
            activeCommentsListener = onValue(commentsRef, (snapshot) => {
                list.innerHTML = '';
                const coms = snapshot.val();
                if(!coms) {
                    const emptyComments = currentLang === 'so' ? 'هیچ بۆچوونێک نییە، یەکەم کەسبە بۆچوون بنووسیت.' : 'هێشتا چ بۆچوونێک نینە، ببە یەکەم کەس کو بۆچوونەک بنڤێسە.';
                    list.innerHTML = `<p class="text-gray-500 text-sm text-center py-4">${emptyComments}</p>`;
                    return;
                }
                
                const cKeys = Object.keys(coms).sort((a,b) => coms[a].timestamp - coms[b].timestamp);
                cKeys.forEach(cid => {
                    const c = coms[cid];
                    const cDate = new Date(c.timestamp).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                    
                    let delBtn = '';
                    // ئەگەر ئەدمینە یان خاوەنی کۆمێنتەکەیە دەتوانێت بیسڕێتەوە
                    if(window.isAdmin || (currentUser && currentUser.email === c.email)) {
                        delBtn = `<button onclick="window.deleteComment('${id}', '${cid}')" class="text-red-500 hover:text-red-700 text-xs">سڕینەوە</button>`;
                    }

                    list.innerHTML += `
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="font-bold text-sky-600 dark:text-sky-400 text-sm">${c.name}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-gray-400">${cDate}</span>
                                    ${delBtn}
                                </div>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 text-sm">${c.text}</p>
                        </div>
                    `;
                });
                list.scrollTop = list.scrollHeight;
            });
        };

        window.closeNewsModal = function() {
            const modal = document.getElementById('newsModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('translate-y-0', 'opacity-100');
            modalContent.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
            if(activeCommentsListener) { activeCommentsListener(); activeCommentsListener = null; }
        };

        // ناردنی کۆمێنت
        document.getElementById('comment-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if(!currentUser) return alert("بۆ نووسینی کۆمێنت پێویستە هەژمارت هەبێت و چوویتە ژوورەوە.");
            
            const newsId = document.getElementById('current_news_id').value;
            const textInput = document.getElementById('comment_input');
            const text = textInput.value.trim();
            const btn = document.getElementById('comment-btn');

            if(text && newsId) {
                btn.disabled = true; btn.innerText = "...";
                try {
                    await set(push(dbRef(db, `news/${newsId}/comments`)), {
                        name: currentUser.displayName || currentUser.email.split('@')[0],
                        email: currentUser.email,
                        text: text,
                        timestamp: Date.now()
                    });
                    textInput.value = '';
                } catch(err) { alert("هەڵەیەک ڕوویدا"); }
                btn.disabled = false; btn.innerText = "ناردن";
            }
        });

        window.deleteComment = async function(newsId, commentId) {
            if(confirm("دڵنیایت لە سڕینەوەی ئەم کۆمێنتە؟")) {
                await remove(dbRef(db, `news/${newsId}/comments/${commentId}`));
            }
        };

        // پشکنینی هەژمار
        onAuthStateChanged(auth, (user) => { 
            if(!user) window.location.href = "/login"; 
            else {
                document.body.style.display = 'block';
                currentUser = user;
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    window.isAdmin = true;
                    document.querySelector('.admin-only').classList.remove('hidden');
                }
                applyLanguage();
            }
        });
        
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
@include('components.chat-widget')
</body>
</html>