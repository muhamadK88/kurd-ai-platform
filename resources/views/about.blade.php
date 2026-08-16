<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دەربارەی ئێمە - کورد ئەی ئای</title>
<!-- Favicon (وێنە بچووکەکەی سەرەوەی تابەکە) -->
<link rel="icon" href="/favicon.png" type="image/png">

<!-- Meta Tags (بۆ سۆشیاڵ میدیا و گوگڵ) -->
<meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">

<!-- تایبەت بە فەیسبووک، تێلیگرام و نامەکان (Open Graph) -->
<meta property="og:type" content="website">
<meta property="og:title" content="کورد ئەی ئای - Kurd AI">
<meta property="og:description" content="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی.">
<meta property="og:image" content="/logo.jpg">
    <meta name="description" content="دەربارەی کورد ئەی ئای - پلاتفۆرمی فێربوونی زیرەکی دەستکرد و پرۆگرامسازی">
    <meta name="keywords" content="دەربارەی ئێمە, کورد ئەی ئای, تیم, پلاتفۆرم">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/about">
    <meta property="og:title" content="دەربارەی ئێمە - KURD AI">
    <meta property="og:description" content="پلاتفۆرمی فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/about">
    <meta property="twitter:title" content="دەربارەی ئێمە - KURD AI">
    <meta property="twitter:description" content="پلاتفۆرمی فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی">
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

    @include('partials.kurdai-design')

    <link rel="stylesheet" href="{{ asset('css/kai-about.css') }}?v=4">
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    @include('partials.nav', ['active' => 'about'])

    <!-- Header Section -->
    <header class="relative min-h-[50vh] flex items-center justify-center overflow-hidden py-24 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-blue-500 dark:bg-blue-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-indigo-500 dark:bg-indigo-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-96 h-96 bg-teal-500 dark:bg-teal-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:32px_32px]"></div>
            <div class="kai-holo-grid absolute inset-0"></div>
            <div class="kai-scanlines absolute inset-0"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700/50 text-blue-700 dark:text-blue-300 font-extrabold text-sm mb-6 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="lang-str" data-so="تیمی پەرەپێدەرانی کورد ئەی ئای" data-ba="تیمێ پێشڤەبەرێن کورد ئەی ئای">تیمی پەرەپێدەرانی کورد ئەی ئای</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="دەربارەی ئێمە و تیمەکەمان" data-ba="دەربارەی مە و تیمێ مە">دەربارەی ئێمە و تیمەکەمان</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium max-w-3xl mx-auto leading-relaxed lang-str" data-so="ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ" data-ba="ناساندنا ئەندامێن تیمێ پڕۆژەی، زانکۆ و زانیاریێن پەیوەندیێ بۆ هاریکاری و ڕاوێژێ">ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ</p>
        </div>
    </header>

    <!-- Main Content Grid -->
    <section class="relative z-10 container mx-auto pb-24 px-4 max-w-6xl">
        
        <!-- Section Title -->
        <div class="text-center mb-16">
            <h3 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 lang-str" data-so="ئەندامانی سەرەکی پڕۆژە" data-ba="ئەندامێن سەرەکی یێن پڕۆژەی">ئەندامانی سەرەکی پڕۆژە</h3>
            <p class="text-gray-600 dark:text-gray-400 font-medium lang-str" data-so="بۆ پەیوەندی کردن زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت" data-ba="بۆ پەیوەندیکرن و دیتنا زانیاریێن ئەندامان دشێی ب ڕێکا ئیمێلی، ژمارا موبایلی یان فەیسبووکی پەیوەندیێ بکەی">بۆ پەیوەندی کردن و بەسەرکردنەوەی زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت</p>
        </div>

        <!-- 3 Team Members Cards Grid -->
        <div id="about-team-grid" class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            
            <!-- Member 1 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-blue-600 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div class="kai-id-strip flex items-center justify-between gap-3 pb-4 mb-6">
                    <span class="kai-id-badge">AGENT-001</span>
                    <span class="kai-id-status"><i></i>ONLINE</span>
                </div>
                <div>
                    <!-- وێنەی ئەندامی یەکەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="muhamad.jpg" alt="Member 1" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">محمد کامران حمەساڵح</h4>
                    <p class="text-blue-600 dark:text-blue-400 font-bold text-center text-sm mb-6">زانکۆی ئاکرێ بۆ زانستە کردارییەکان - قۆناغی سێیەم</p>
<p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="خوێندکاری بەشی ژیریی دەستکرد لە زانکۆی ئاکرێ و دامەزرێنەری پلاتفۆرمی کورد ئەی ئای. پەرەپێدەرێکی لێهاتووی سیستەمە زیرەکەکان و وێب، ئامانجی سەرەکی دروستکردنی ئامرازی پێشکەوتوو و ئاسانکردنی ژیانی ئەکادیمییە بۆ فێرخوازان." data-ba="قوتابیێ بەشێ ژیرییا دەستکرد ل زانکۆیا ئاکرێ و دامەزرێنەرێ پلاتفۆرمێ کورد ئەی ئای. پێشڤەبەرەکێ لێهاتی یێ سیستەمێن زیرەک و وێبی، ئارمانجا سەرەکی چێکرنا ئامرازێن پێشکەفتی و ساناهیکرنا ژیانا ئەکادیمی یە بۆ قوتابیان.">خوێندکاری بەشی ژیریی دەستکرد لە زانکۆی ئاکرێ و دامەزرێنەری پلاتفۆرمی کورد ئەی ئای. پەرەپێدەرێکی لێهاتووی سیستەمە زیرەکەکان و وێب، ئامانجی سەرەکی دروستکردنی ئامرازی پێشکەوتوو و ئاسانکردنی ژیانی ئەکادیمییە بۆ فێرخوازان.</p>                </div>
                
                <div class="space-y-3 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                    <a href="mailto:mahamadkamaran890@gmail.com" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span dir="ltr">mahamadkamaran890@gmail.com</span>
                    </a>
                    <a href="tel:+964XXXXXXXXX" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span dir="ltr">07511915347</span>
                    </a>
                    <a href="https://www.facebook.com/share/1939LEuq7d/" target="_blank" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        <span class="lang-str" data-so="کلیک لێرە بکە" data-ba="کلیک ل ڤێرێ بکە">کلیک لێرە بکە</span>
                    </a>
                    <div class="kai-barcode-wrap flex items-center gap-3 pt-4 mt-1">
                        <span class="kai-barcode" aria-hidden="true"></span>
                        <span class="kai-barcode-id text-[0.6rem] font-bold text-gray-400">KURD·AI</span>
                    </div>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-purple-600 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div class="kai-id-strip flex items-center justify-between gap-3 pb-4 mb-6">
                    <span class="kai-id-badge">AGENT-002</span>
                    <span class="kai-id-status"><i></i>ONLINE</span>
                </div>
                <div>
                    <!-- وێنەی ئەندامی دووەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-600 to-pink-500 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="rastgo.jpg" alt="Member 2" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">ڕاستگۆ تۆفیق حسێن</h4>
                    <p class="text-purple-600 dark:text-purple-400 font-bold text-center text-sm mb-6">زانکۆی زاخۆ-قۆناغی دووەم</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="جێبەجێکاری لایەنی هونەری و نوسەری ناوەڕۆک و  بڵاوکراوەکانی کورد ئەی ئای شارەزا لە بواری سیستەمی پەروەردە و خوێندنی باڵا 
Tech Evangelism& AI Literacy." data-ba="جێبەجێکارێ لایەنێ هونەری و نڤیسەرێ ناڤەرۆکێ و بەلاڤکرییێن کورد ئەی ئای، شارەزا د بوارێ سیستەمێن پەروەردەیێ و خواندنا بلند دا
Tech Evangelism &amp; AI Literacy.">جێبەجێکاری لایەنی هونەری و نوسەری ناوەڕۆک و  بڵاوکراوەکانی کورد ئەی ئای شارەزا لە بواری سیستەمی پەروەردە و خوێندنی باڵا 
Tech Evangelism& AI Literacy.</p>
                </div>
                
                <div class="space-y-3 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                    <a href="mailto:rastgotofeq0@gmail.com" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span dir="ltr">astgotofeq0@gmail.com</span>
                    </a>
                    <a href="tel:+9647708913535" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span dir="ltr">07708913535</span>
                    </a>
                    <a href="https://www.facebook.com/share/1Dvruge4Xg/" target="_blank" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        <span class="lang-str" data-so="کلیک لێرە بکە" data-ba="کلیک ل ڤێرێ بکە">کلیک لێرە بکە</span>
                    </a>
                    <div class="kai-barcode-wrap flex items-center gap-3 pt-4 mt-1">
                        <span class="kai-barcode" aria-hidden="true"></span>
                        <span class="kai-barcode-id text-[0.6rem] font-bold text-gray-400">KURD·AI</span>
                    </div>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-teal-500 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div class="kai-id-strip flex items-center justify-between gap-3 pb-4 mb-6">
                    <span class="kai-id-badge">AGENT-003</span>
                    <span class="kai-id-status"><i></i>ONLINE</span>
                </div>
                <div>
                    <!-- وێنەی ئەندامی سێیەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-emerald-500 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="ali.jpg" alt="Member 3" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">علی عارف محمد </h4>
                    <p class="text-teal-600 dark:text-teal-400 font-bold text-center text-sm mb-6">AI engineering 3rd grade</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="جێبەجێکارێ تەکنیکی و شارەزا د بوارێ سێرڤەر و vibe coding و automation و زیرەکیا دەستکر" data-ba="جێبەجێکارێ تەکنیکی و شارەزا د بوارێ سێرڤەر و vibe coding و automation و زیرەکیا دەستکرد">جێبەجێکارێ تەکنیکی و شارەزا د بوارێ سێرڤەر و vibe coding و automation و زیرەکیا دەستکر</p>
                </div>
                
                <div class="space-y-3 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                    <a href="mailto:ali.ai2004.20@gmail.com" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span dir="ltr">ali.ai2004.20@gmail.com<span>
                    </a>
                    <a href="tel:+9647511826231" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span dir="ltr">07511826231</span>
                    </a>
                    <a href="https://www.facebook.com/share/19CRkdUVnh/" target="_blank" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        <span class="lang-str" data-so="کلیک لێرە بکە" data-ba="کلیک ل ڤێرێ بکە">کلیک لێرە بکە</span>
                    </a>
                    <div class="kai-barcode-wrap flex items-center gap-3 pt-4 mt-1">
                        <span class="kai-barcode" aria-hidden="true"></span>
                        <span class="kai-barcode-id text-[0.6rem] font-bold text-gray-400">KURD·AI</span>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- Script Section -->
    <script>
        let currentLang = localStorage.getItem('site-lang') || 'so';

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) {
                langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            }

            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
        }

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

        applyLanguage();

        (function () {
            var cards = document.querySelectorAll('.grid .glass-card');
            if (!cards.length) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            if (document.documentElement.classList.contains('kai-perf')) return;

            cards.forEach(function (card) {
                var icons = card.querySelectorAll('a svg');
                if (!icons.length) return;
                icons.forEach(function (icon) { icon.classList.add('kai-mag'); });
                var raf = null;
                card.addEventListener('mousemove', function (e) {
                    if (raf) return;
                    raf = requestAnimationFrame(function () {
                        raf = null;
                        var r = card.getBoundingClientRect();
                        icons.forEach(function (icon) {
                            var ir = icon.getBoundingClientRect();
                            var pdx = (e.clientX - (ir.left + ir.width / 2)) / r.width * 24;
                            var pdy = (e.clientY - (ir.top + ir.height / 2)) / r.height * 20;
                            icon.style.transform = 'translate(' + pdx + 'px,' + pdy + 'px)';
                        });
                    });
                });
                card.addEventListener('mouseleave', function () {
                    icons.forEach(function (icon) { icon.style.transform = ''; });
                });
            });
        })();
    </script>
<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="module">
    import { initializeApp, getApps, getApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
    const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
    const app = getApps().length ? getApp() : initializeApp(firebaseConfig);
    const auth = getAuth(app);
    onAuthStateChanged(auth, (user) => {
        if (user && ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
            document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
        }
    });
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    }
</script>
@include('components.chat-widget')
</body>
</html>