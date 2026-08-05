<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سەرەکی - کورد ئەی ئای</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="description" content="Kurd AI - پلاتفۆرمی فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی">
    <meta name="keywords" content="Kurd AI, کورد ئەی ئای, زیرەکی دەستکرد, پرۆگرامسازی, کوردی, فێربوون, AI, programming">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com">
    <meta property="og:title" content="KURD AI - پلاتفۆرمی فێربوونی زیرەکی دەستکرد">
    <meta property="og:description" content="فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی، لەگەڵ کۆرس، ئامرازەکانی AI، و ڕێنیشاندەری ئەکادیمی">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com">
    <meta property="twitter:title" content="KURD AI - پلاتفۆرمی فێربوونی زیرەکی دەستکرد">
    <meta property="twitter:description" content="فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی، لەگەڵ کۆرس، ئامرازەکانی AI، و ڕێنیشاندەری ئەکادیمی">
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
                    animation: {
                        'blob': 'blob 7s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-up': 'fadeUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
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
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
        .service-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .service-card:hover {
            transform: translateY(-8px) scale(1.02);
        }
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.15;
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

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
            <a href="/" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
            <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
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

<!-- ===== هێدەری سەرەکی (Hero) ===== -->
<header class="relative min-h-[90vh] flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-[#0a0f1c]">
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="floating-shape bg-blue-500 w-96 h-96 -top-20 -right-20 animate-blob"></div>
        <div class="floating-shape bg-purple-500 w-80 h-80 -bottom-20 -left-20 animate-blob animation-delay-2000"></div>
        <div class="floating-shape bg-cyan-500 w-72 h-72 top-1/2 left-1/3 animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
    </div>

    <div class="relative container mx-auto px-4 z-10 text-center flex flex-col items-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700/50 text-blue-700 dark:text-blue-300 font-bold text-sm mb-8 shadow-sm animate-fade-in">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
            </span>
            <span class="lang-str" data-so="تایبەت بە خوێندکارانی ژیریی دەستکرد" data-ba="تایبەت ب قوتابیێن ژیرییا دەستکرد">تایبەت بە خوێندکارانی ژیریی دەستکرد</span>
        </div>
        
        <h2 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight animate-fade-up" 
            data-so="دەروازەیەک بەرەو داهاتووی ژیریی دەستکرد" 
            data-ba="دەرگەهەک بەرەڤ پاشەڕۆژا ژیرییا دەستکرد">
            <span class="gradient-text">KURD AI</span>
            <br>
            <span class="lang-str" data-so="دەروازەیەک بەرەو داهاتووی ژیریی دەستکرد" data-ba="دەرگەهەک بەرەڤ پاشەڕۆژا ژیرییا دەستکرد">دەروازەیەک بەرەو داهاتووی ژیریی دەستکرد</span>
        </h2>
        
        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl font-medium leading-relaxed mb-10 animate-fade-up animation-delay-200 lang-str" 
           data-so="یەکەمین پلاتفۆرمی پێشکەوتووی کوردی بۆ فێربوون، ڕێنمایی ئەکادیمی و بەکارهێنانی ئامرازەکانی AI بە شێوەیەکی پراکتیکی." 
           data-ba="ئێکەمین پلاتفۆرما پێشکەفتییا کوردی بۆ فێربوون، ڕێنماییێن ئەکادیمی و ب کارئینانا ئامرازێن AI ب شێوەیەکێ پراکتیکی.">
           یەکەمین پلاتفۆرمی پێشکەوتووی کوردی بۆ فێربوون، ڕێنمایی ئەکادیمی و بەکارهێنانی ئامرازەکانی AI بە شێوەیەکی پراکتیکی.
        </p>
        
        <div class="flex flex-wrap justify-center gap-4 animate-fade-up animation-delay-400">
            <a href="/ferga" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl text-lg shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 hover:-translate-y-1 transition-all flex items-center gap-2 group/btn">
                <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                <span class="lang-str" data-so="دەستپێبکە بۆ فێربوون" data-ba="دەستپێبکە بۆ فێربوونێ">دەستپێبکە بۆ فێربوون</span>
            </a>
            <a href="/ai-tools" class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-800 dark:text-white font-bold rounded-2xl text-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 hover:-translate-y-1 transition-all flex items-center gap-2 group/btn">
                <svg class="w-5 h-5 text-purple-500 group-hover/btn:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                <span class="lang-str" data-so="ئامرازەکانی AI" data-ba="ئامرازێن AI">ئامرازەکانی AI</span>
            </a>
        </div>
    </div>
    
    <div class="absolute bottom-0 w-full overflow-hidden leading-none z-0">
        <svg class="relative block w-full h-[60px] md:h-[120px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,126.38,189.9,117.84,235.32,111.27,278.71,85.29,321.39,56.44Z" class="fill-white dark:fill-[#0d1326]"></path>
        </svg>
    </div>
</header>

<!-- ===== ئامارەکان (Stats) ===== -->


<!-- ===== بەشەکانی پلاتفۆرم (Services) ===== -->
<section class="relative bg-gray-50 dark:bg-[#0a0f1c] py-24 px-4 overflow-hidden">
    <div class="floating-shape bg-blue-500 w-96 h-96 -top-40 -left-40 animate-blob"></div>
    
    <div class="container mx-auto max-w-7xl relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm font-black rounded-full mb-4">بەشەکان</span>
            <h3 class="text-4xl md:text-5xl font-black mb-4 text-gray-900 dark:text-white lang-str" data-so="بەشەکانی پلاتفۆرمی کورد ئەی ئای" data-ba="بەشێن پلاتفۆرما کورد ئەی ئای">بەشەکانی پلاتفۆرمی کورد ئەی ئای</h3>
            <p class="text-gray-500 dark:text-gray-400 text-lg max-w-2xl mx-auto lang-str" data-so="هەموو ئەوەی پێویستە بۆ فێربوون و پەرەپێدان لە بواری ژیریی دەستکرددا، لە یەک شوێن." data-ba="هەمی ئەوا پێدڤی بۆ فێربوون و پێشڤەبرنێ د بوارێ ژیرییا دەستکرد دا، د ئێک جهی دا.">هەموو ئەوەی پێویستە بۆ فێربوون و پەرەپێدان لە بواری ژیریی دەستکرددا، لە یەک شوێن.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- 1. فێرگە -->
            <a href="/ferga" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-blue-500">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors lang-str" data-so="فێرگەی پڕۆگرامزاسی و ژیری دەستکرد" data-ba="فێرگەها پڕۆگرامسازیێ و ژیرییا دەستکرد">فێرگەی پرۆگرامسازی</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="فێربوونی زمانەکانی پڕۆگرامینگ لەگەڵ تاقیکردنەوەی کۆدەکان ڕاستەوخۆ لەناو وێبسایتەکەدا." data-ba="فێربوونا زمانێن پڕۆگرامینگ دگەل تاقیکرنا کۆدان ڕاستەوخۆ د ناڤ وێبسایتێ دا.">فێربوونی زمانەکانی پڕۆگرامینگ لەگەڵ تاقیکردنەوەی کۆدەکان ڕاستەوخۆ لەناو وێبسایتەکەدا.</p>
            </a>

            <!-- 2. کۆرسەکان -->
            <a href="/courses" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-indigo-500">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors lang-str" data-so="کۆرسە ئەکادیمییەکان" data-ba="کۆرسێن ئەکادیمی">کۆرسە ئەکادیمییەکان</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="بەشی ڤیدیۆیی و کتێبخانەی دیجیتاڵی بۆ بابەتە زانستییەکانی پەیوەست بە ژیریی دەستکرد." data-ba="بەشێ ڤیدیۆیی و پەرتووکخانا دیجیتاڵی بۆ بابەتێن زانستی یێن گرێدای ب ژیرییا دەستکرد.">بەشی ڤیدیۆیی و کتێبخانەی دیجیتاڵی بۆ بابەتە زانستییەکانی پەیوەست بە ژیریی دەستکرد.</p>
            </a>
            
            <!-- 3. ئامرازەکان -->
            <a href="/ai-tools" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-purple-500">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors lang-str" data-so="ئامرازە زیرەکەکان (AI Tools)" data-ba="ئامرازێن ژیر (AI Tools)">ئامرازە زیرەکەکان (AI Tools)</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="کۆمەڵێک ئامرازی پێشکەوتووی AI بۆ یارمەتیدانت لە نووسین، شیکردنەوەی داتا و ڕاپۆرتەکانت." data-ba="کۆمەڵەکا ئامرازێن پێشکەفتی یێن AI بۆ هاریکاریکرنا تە د نڤێسین، شیکرنا داتایان و ڕاپۆرتێن تە دا.">کۆمەڵێک ئامرازی پێشکەوتووی AI بۆ یارمەتیدانت لە نووسین، شیکردنەوەی داتا و ڕاپۆرتەکانت.</p>
            </a>
            
            <!-- 4. ڕێنیشاندەر -->
            <a href="/academic-guide" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-teal-500">
                <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-emerald-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-teal-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors lang-str" data-so="ڕێنیشاندەری ئەکادیمی" data-ba="ڕێبەرێ ئەکادیمی">ڕێنیشاندەری ئەکادیمی</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="وەڵامی پرسیارە باوەکان و ڕێنمایی زانستی بۆ تێپەڕاندنی قۆناغەکانی خوێندن بە سەرکەوتوویی." data-ba="بەرسڤا پرسیارێن بەربەلاڤ و ڕێنماییێن زانستی بۆ دەربازکرنا قۆناغێن خواندنێ ب سەرکەفتیانە.">وەڵامی پرسیارە باوەکان و ڕێنمایی زانستی بۆ تێپەڕاندنی قۆناغەکانی خوێندن بە سەرکەوتوویی.</p>
            </a>
            
            <!-- 5. زانکۆکان -->
            <a href="/universities" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-orange-500">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors lang-str" data-so="زانکۆکانی زیرەکی دەستکرد" data-ba="زانکۆیێن زیرەکیا دەستکرد">زانکۆکانی زیرەکی دەستکرد</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="دۆزینەوەی ئەو زانکۆیانەی بەشی AI یان هەیە لەگەڵ خشتەی وانەکانی." data-ba="دیتنا وان زانکۆیێن کو بەشێ AI هەی، دگەل خشتەیا وانەیان.">دۆزینەوەی ئەو زانکۆیانەی بەشی AI یان هەیە لەگەڵ خشتەی وانەکانی.</p>
            </a>
            
            <!-- 6. هەواڵەکان (NEW) -->
            <a href="/news" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-sky-500">
                <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-blue-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-sky-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition-colors lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="دوایین هەواڵ و ڕووداوەکانی جیهانی تەکنەلۆژیا و زیرەکی دەستکرد." data-ba="دوماهیک نووچە و ڕووداوێن جیهانا تەکنەلۆژیایێ و ژیرییا دەستکرد.">دوایین هەواڵ و ڕووداوەکانی جیهانی تەکنەلۆژیا و زیرەکی دەستکرد.</p>
                <span class="inline-block mt-4 px-3 py-1 bg-sky-100 dark:bg-sky-900/30 text-sky-600 dark:text-sky-400 text-xs font-black rounded-full lang-str" data-so="بەردەوام نوێ دەکرێتەوە" data-ba="بەردەوام دهێتە نویکرن">بەردەوام نوێ دەکرێتەوە</span>
            </a>

            <!-- 7. دەربارەی ئێمە (NEW) -->
            <a href="/about" class="glass-card p-8 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-500 service-card group border-t-4 border-t-rose-500">
                <div class="w-16 h-16 bg-gradient-to-br from-rose-400 to-pink-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-rose-500/30 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h4 class="text-xl font-black mb-3 text-gray-900 dark:text-white group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors lang-str" data-so="دەربارەی ئێمە" data-ba="دەربارەی مە">دەربارەی ئێمە</h4>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed text-sm lang-str" data-so="زانیاری دەربارەی تیمەکەمان، ئامانجەکانمان و پەیوەندیکردن پێمان." data-ba="پێزانین دەربارەی تیمێ مە، ئامانجێن مە و پەیوەندیکرن پێ مە.">زانیاری دەربارەی تیمەکەمان، ئامانجەکانمان و چۆنیەتی پەیوەندیکردن پێمان.</p>
                <span class="inline-block mt-4 px-3 py-1 bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-xs font-black rounded-full lang-str" data-so="زیاتر بزانە" data-ba="زێدەتر بزانە">زیاتر بزانە</span>
            </a>
            
        </div>
    </div>
</section>

<!-- ===== تایبەتمەندییەکان (Why Choose Us) ===== -->
<section class="relative bg-white dark:bg-[#0d1326] py-24 px-4 overflow-hidden">
    <div class="floating-shape bg-indigo-500 w-96 h-96 -bottom-40 -right-40 animate-blob animation-delay-2000"></div>
    
    <div class="container mx-auto max-w-7xl relative z-10">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-black rounded-full mb-4 lang-str" data-so="بۆچی کورد ئەی ئای؟" data-ba="بۆچی کورد ئەی ئای؟">بۆچی کورد ئەی ئای؟</span>
            <h3 class="text-4xl md:text-5xl font-black mb-4 text-gray-900 dark:text-white lang-str" data-so="بۆچی ئێمە هەڵبژێرین؟" data-ba="بۆچی مە هەڵبژێری؟">بۆچی ئێمە هەڵبژێرین؟</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center p-8">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                </div>
                <h4 class="text-lg font-black mb-2 text-gray-900 dark:text-white lang-str" data-so="بە زمانی کوردی" data-ba="ب زمانی کوردی">بە زمانی کوردی</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed lang-str" data-so="هەموو ناوەڕۆکەکان بە هەردوو شێوەزاری سۆرانی و بادینی." data-ba="هەمی ناوەڕۆک ب هەردوو شێوەزارێن سۆرانی و بادینی.">هەموو ناوەڕۆکەکان بە هەردوو شێوەزاری سۆرانی و بادینی.</p>
            </div>
            <div class="text-center p-8">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-indigo-500 to-purple-400 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-lg font-black mb-2 text-gray-900 dark:text-white lang-str" data-so="فێربوونی پراکتیکی" data-ba="فێربوونەکا پراکتیکی">فێربوونی پراکتیکی</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed lang-str" data-so="تاقیکردنەوەی کۆد ڕاستەوخۆ لەناو پلاتفۆرمەکەدا." data-ba="تاقیکرنا کۆدان ڕاستەوخۆ د ناڤ پلاتفۆرمێ دا.">تاقیکردنەوەی کۆد ڕاستەوخۆ لەناو پلاتفۆرمەکەدا.</p>
            </div>
            <div class="text-center p-8">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-purple-500 to-pink-400 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h4 class="text-lg font-black mb-2 text-gray-900 dark:text-white lang-str" data-so="بە تەواوی خۆڕایی" data-ba="ب تەواوی بێ بەرامبەر">بە تەواوی خۆڕایی</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed lang-str" data-so="هەموو خزمەتگوزارییەکان بە خۆڕایی." data-ba="هەمی خزمەتگوزاری بێ بەرامبەر.">هەموو خزمەتگوزارییەکان بە خۆڕایی.</p>
            </div>
            <div class="text-center p-8">
                <div class="w-16 h-16 mx-auto mb-5 bg-gradient-to-br from-teal-400 to-emerald-400 rounded-2xl flex items-center justify-center shadow-lg shadow-teal-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h4 class="text-lg font-black mb-2 text-gray-900 dark:text-white lang-str" data-so="بەردەوام نوێکردنەوە" data-ba="نویکرنا بەردەوام">بەردەوام نوێکردنەوە</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed lang-str" data-so="زیادکردنی کۆرس و ئامرازی نوێ بە بەردەوامی." data-ba="زێدەکرنا کۆرس و ئامرازێن نوی ب بەردەوامی.">زیادکردنی کۆرس و ئامرازی نوێ بە بەردەوامی.</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== بانگەشە بۆ دەستپێکردن (CTA) ===== -->
<section class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 py-20 px-4 overflow-hidden">
    <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -right-4 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    </div>
    <div class="relative container mx-auto max-w-4xl text-center z-10">
        <h3 class="text-4xl md:text-5xl font-black mb-6 text-white lang-str" data-so="ئامادەییت بۆ دەستپێکردن؟" data-ba="ئامادەیی بۆ دەستپێکرنێ؟">ئامادەییت بۆ دەستپێکردن؟</h3>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto lang-str" data-so="بەشداربە لە گەشەپێدانی تواناکانت لە بواری ژیریی دەستکرددا، بە تەواوی خۆڕایی." data-ba="بەشداربە د پێشڤەبرنا شیانێن خۆ دا د بوارێ ژیرییا دەستکرد دا، ب تەواوی بێ بەرامبەر.">بەشداربە لە گەشەپێدانی تواناکانت لە بواری ژیریی دەستکرددا، بە تەواوی خۆڕایی.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="/ferga" class="px-10 py-4 bg-white text-indigo-700 font-black rounded-2xl text-lg shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all lang-str" data-so="دەستپێبکە ئێستا" data-ba="دەستپێبکە نوکە">دەستپێبکە ئێستا</a>
            <a href="/about" class="px-10 py-4 bg-white/10 text-white font-black rounded-2xl text-lg border border-white/30 hover:bg-white/20 hover:-translate-y-1 transition-all lang-str" data-so="زیاتر بزانە" data-ba="زێدەتر بزانە">زیاتر بزانە</a>
        </div>
    </div>
</section>

<!-- ===== فووتەری سەرەکی (Footer) ===== -->
<footer class="bg-gray-900 dark:bg-[#050a18] text-gray-400">
    <div class="container mx-auto max-w-7xl px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <img src="logo.jpg" alt="Kurd AI" class="h-10 w-auto object-contain dark:invert">
                    <div>
                        <h4 class="text-lg font-black text-white">KURD AI</h4>
                        <span class="text-[0.5rem] font-black tracking-widest text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">INNOVATION - FUTURE</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed lang-str" data-so="یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی." data-ba="ئێکەمین پلاتفۆرما کوردی بۆ فێربوونا ژیرییا دەستکرد و پرۆگرامسازیێ.">یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی.</p>
            </div>

            <div>
                <h5 class="text-white font-black mb-5 lang-str" data-so="بەشەکان" data-ba="بەش">بەشەکان</h5>
                <ul class="space-y-3 text-sm">
                    <li><a href="/ferga" class="hover:text-blue-400 transition lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a></li>
                    <li><a href="/courses" class="hover:text-blue-400 transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a></li>
                    <li><a href="/ai-tools" class="hover:text-blue-400 transition lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</a></li>
                    <li><a href="/news" class="hover:text-blue-400 transition lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-white font-black mb-5 lang-str" data-so="ڕێنمایی" data-ba="ڕێنمایی">ڕێنمایی</h5>
                <ul class="space-y-3 text-sm">
                    <li><a href="/academic-guide" class="hover:text-blue-400 transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a></li>
                    <li><a href="/universities" class="hover:text-blue-400 transition lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a></li>
                    <li><a href="/about" class="hover:text-blue-400 transition lang-str" data-so="دەربارەی ئێمە" data-ba="دەربارەی مە">دەربارەی ئێمە</a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="border-t border-gray-800 py-6">
        <p class="text-center text-sm text-gray-500 lang-str" data-so="گەشەپێدراوە لەلایەن تیمی کورد ئەی ئای &copy; ٢٠٢٦" data-ba="هاتیە پێشڤەبرن ژ لایێ تیمێ کورد ئەی ئای &copy; ٢٠٢٦">گەشەپێدراوە لەلایەن تیمی کورد ئەی ئای &copy; ٢٠٢٦</p>
    </div>
</footer>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

    const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    let currentLang = localStorage.getItem('site-lang') || 'so';

    function applyLanguage() {
        const langBtnText = document.getElementById('lang-text');
        if (langBtnText) { langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی'; }
        
        document.querySelectorAll('.lang-str').forEach(el => {
            el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
        });
    }

    document.getElementById('lang-toggle').addEventListener('click', () => {
        currentLang = currentLang === 'so' ? 'ba' : 'so';
        localStorage.setItem('site-lang', currentLang);
        applyLanguage();
    });

    applyLanguage();

    function toggleTheme() {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }

    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);

    onAuthStateChanged(auth, (user) => { 
        if(!user) window.location.href = "/login"; 
        else { document.body.style.display = 'block'; }
    });
    
    const logoutBtn = document.getElementById('logout-btn');
    if(logoutBtn) {
        logoutBtn.addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    }
</script>

@include('components.chat-widget')

</body>
</html>