<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سەرەکی - کورد ئەی ئای</title>

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
                <a href="/" class="px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <a href="/ai-tools" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="تووڵەکانی AI" data-ba="ئامرازێن AI">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
            </div>

            <div class="flex items-center gap-3">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-sm border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 dark:hover:bg-blue-800/50 transition">
                    <span id="lang-text">بادینی</span>
                </button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition shadow-sm border border-gray-200/50 dark:border-gray-700/50">
                    <svg id="theme-toggle-light-icon" class="hidden dark:block w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="block dark:hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 hover:-translate-y-0.5 transition-all duration-300 font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- بەشی هێدەر (Hero Section) بە دیزاینێکی مۆدێرن -->
    <header class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-[#0a0f1c]">
        <!-- باکگراوندی جوڵاو (Blobs) -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-blue-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-indigo-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <!-- هێڵکاری تۆڕی (Grid Pattern) -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative container mx-auto px-4 z-10 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700/50 text-blue-700 dark:text-blue-300 font-bold text-sm mb-8 shadow-sm">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
                <span class="lang-str" data-so="تایبەت بە خوێندکارانی ژیریی دەستکرد" data-ba="تایبەت ب قوتابیێن ژیرییا دەستکرد">تایبەت بە خوێندکارانی ژیریی دەستکرد</span>
            </div>
            
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" 
                data-so="دەروازەیەک بەرەو داهاتووی ژیریی دەستکرد" 
                data-ba="دەرگەهەک بەرەڤ پاشەڕۆژا ژیرییا دەستکرد">
                دەروازەیەک بەرەو داهاتووی ژیریی دەستکرد
            </h2>
            
            <p class="text-lg md:text-2xl text-gray-600 dark:text-gray-300 max-w-3xl font-medium leading-relaxed mb-10 lang-str" 
               data-so="یەکەمین پلاتفۆرمی پێشکەوتووی کوردی بۆ فێربوون، ڕێنمایی ئەکادیمی و بەکارهێنانی ئامرازەکانی AI بە شێوەیەکی پراکتیکی." 
               data-ba="ئێکەمین پلاتفۆرما پێشکەفتییا کوردی بۆ فێربوون، ڕێنماییێن ئەکادیمی و ب کارئینانا ئامرازێن AI ب شێوەیەکێ پراکتیکی.">
               یەکەمین پلاتفۆرمی پێشکەوتووی کوردی بۆ فێربوون، ڕێنمایی ئەکادیمی و بەکارهێنانی ئامرازەکانی AI بە شێوەیەکی پراکتیکی.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="/ferga" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-2xl text-lg shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <span class="lang-str" data-so="دەستپێبکە بۆ فێربوون" data-ba="دەستپێبکە بۆ فێربوونێ">دەستپێبکە بۆ فێربوون</span>
                </a>
                <a href="/ai-tools" class="px-8 py-4 bg-white dark:bg-gray-800 text-gray-800 dark:text-white font-bold rounded-2xl text-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="lang-str" data-so="ئامرازەکانی AI" data-ba="ئامرازێن AI">ئامرازەکانی AI</span>
                </a>
            </div>
        </div>
        
        <!-- شەپۆلی خوارەوە (Wave) -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-none z-0">
            <svg class="relative block w-full h-[50px] md:h-[100px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,126.38,189.9,117.84,235.32,111.27,278.71,85.29,321.39,56.44Z" class="fill-white dark:fill-[#0d1326]"></path>
            </svg>
        </div>
    </header>

    <!-- بەشی خزمەتگوزارییەکان (Cards) -->
    <section class="relative bg-white dark:bg-[#0d1326] py-24 px-4 z-10">
        <div class="container mx-auto max-w-7xl">
            <div class="text-center mb-16">
                <h3 class="text-3xl md:text-4xl font-black mb-4 text-gray-900 dark:text-white lang-str" data-so="بەشەکانی پلاتفۆرمی کورد ئەی ئای" data-ba="بەشێن پلاتفۆرما کورد ئەی ئای">بەشەکانی پلاتفۆرمی کورد ئەی ئای</h3>
                <p class="text-gray-500 dark:text-gray-400 text-lg lang-str" data-so="هەموو ئەوەی پێویستتە لە یەک شوێندایە" data-ba="هەمی ئەوا تە پێدڤییە ل ئێک جهـ دایە">هەموو ئەوەی پێویستتە لە یەک شوێندایە</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- 1. فێرگە -->
                <a href="/ferga" class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white lang-str" data-so="فێرگەی پرۆگرامسازی" data-ba="فێرگەها پرۆگرامسازیێ">فێرگەی پرۆگرامسازی</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed lang-str" data-so="فێربوونی زمانەکانی پڕۆگرامینگ لەگەڵ تاقیکردنەوەی کۆدەکان ڕاستەوخۆ لەناو وێبسایتەکەدا." data-ba="فێربوونا زمانێن پڕۆگرامینگ دگەل تاقیکرنا کۆدان ڕاستەوخۆ د ناڤ وێبسایتێ دا.">فێربوونی زمانەکانی پایتۆن و زیاتر لەگەڵ تاقیکردنەوەی کۆدەکان ڕاستەوخۆ لەناو وێبسایتەکەدا.</p>
                </a>

                <!-- 2. کۆرسەکان -->
                <a href="/courses" class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white lang-str" data-so="کۆرسە ئەکادیمییەکان" data-ba="کۆرسێن ئەکادیمی">کۆرسە ئەکادیمییەکان</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed lang-str" data-so="بەشی ڤیدیۆیی و کتێبخانەی دیجیتاڵی بۆ بابەتە زانستییەکانی پەیوەست بە ژیریی دەستکرد." data-ba="بەشێ ڤیدیۆیی و پەرتووکخانا دیجیتاڵی بۆ بابەتێن زانستی یێن گرێدای ب ژیرییا دەستکرد.">بەشی ڤیدیۆیی و کتێبخانەی دیجیتاڵی بۆ بابەتە زانستییەکانی پەیوەست بە ژیریی دەستکرد.</p>
                </a>
                
                <!-- 3. ئامرازەکان -->
                <a href="/ai-tools" class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white lang-str" data-so="ئامرازە زیرەکەکان (AI Tools)" data-ba="ئامرازێن ژیر (AI Tools)">ئامرازە زیرەکەکان (AI Tools)</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed lang-str" data-so="کۆمەڵێک ئامرازی پێشکەوتووی AI بۆ یارمەتیدانت لە نووسین، شیکردنەوەی داتا و ڕاپۆرتەکانت." data-ba="کۆمەڵەکا ئامرازێن پێشکەفتی یێن AI بۆ هاریکاریکرنا تە د نڤێسین، شیکرنا داتایان و ڕاپۆرتێن تە دا.">کۆمەڵێک ئامرازی پێشکەوتووی AI بۆ یارمەتیدانت لە نووسین، شیکردنەوەی داتا و ڕاپۆرتەکانت.</p>
                </a>
                
                <!-- 4. ڕێنیشاندەر -->
                <a href="/academic-guide" class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-teal-500/10 hover:-translate-y-2 transition-all duration-300 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-400 to-emerald-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-teal-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white lang-str" data-so="ڕێنیشاندەری ئەکادیمی" data-ba="ڕێبەرێ ئەکادیمی">ڕێنیشاندەری ئەکادیمی</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed lang-str" data-so="وەڵامی پرسیارە باوەکان و ڕێنمایی زانستی بۆ تێپەڕاندنی قۆناغەکانی خوێندن بە سەرکەوتوویی." data-ba="بەرسڤا پرسیارێن بەربەلاڤ و ڕێنماییێن زانستی بۆ دەربازکرنا قۆناغێن خواندنێ ب سەرکەفتیانە.">وەڵامی پرسیارە باوەکان و ڕێنمایی زانستی بۆ تێپەڕاندنی قۆناغەکانی خوێندن بە سەرکەوتوویی.</p>
                </a>
                
                <!-- 5. زانکۆکان -->
                <a href="/universities" class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-300 group md:col-span-2 lg:col-span-1 border-t-4 border-t-orange-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-400 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="text-2xl font-bold mb-3 text-gray-900 dark:text-white lang-str" data-so="زانکۆکانی زیرەکی دەستکرد" data-ba="زانکۆیێن زیرەکیا دەستکرد">زانکۆکانی زیرەکی دەستکرد</h4>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed lang-str" data-so="دۆزینەوەی ئەو زانکۆیانەی بەشی AI یان هەیە لەگەڵ خشتەی وانەکانی هەر ٨ سمستەرەکە بە وێنە." data-ba="دیتنا وان زانکۆیێن بەشێ AI هەی دگەل خشتەیا وانەیێن هەمی ٨ سمستەران ب وێنە.">دۆزینەوەی ئەو زانکۆیانەی بەشی AI یان هەیە لەگەڵ خشتەی وانەکانی هەر ٨ سمستەرەکە بە وێنە.</p>
                </a>
                
            </div>
        </div>
    </section>

    <!-- فووتەر (بچووک) -->
    <footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-8 text-center">
        <p class="text-gray-500 dark:text-gray-400 font-bold text-sm">
            &copy; 2026 Kurd AI. گەشەپێدراوە لەلایەن خوێندکارانی AI  .
        </p>
    </footer>

    <!-- سکرێپتەکان -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        const auth = getAuth(initializeApp(firebaseConfig));

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
            else { document.body.style.display = 'block'; }
        });
        
        const logoutBtn = document.getElementById('logout-btn');
        if(logoutBtn) {
            logoutBtn.addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
        }
    </script>
</body>
</html>