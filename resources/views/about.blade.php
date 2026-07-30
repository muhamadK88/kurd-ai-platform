<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دەربارەی ئێمە - کورد ئەی ئای</title>

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

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

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
    <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
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

    <!-- Header Section -->
    <header class="relative min-h-[50vh] flex items-center justify-center overflow-hidden py-24 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-blue-500 dark:bg-blue-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-96 h-96 bg-indigo-500 dark:bg-indigo-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-96 h-96 bg-teal-500 dark:bg-teal-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700/50 text-blue-700 dark:text-blue-300 font-extrabold text-sm mb-6 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <span class="lang-str" data-so="تیمی پەرەپێدەرانی کورد ئەی ئای" data-ba="تیمێ پێشڤەبەرێن کورد ئەی ئای">تیمی پەرەپێدەرانی کورد ئەی ئای</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="دەربارەی ئێمە و تیمەکەمان" data-ba="دەربارەی مە و تیمێ مە">دەربارەی ئێمە و تیمەکەمان</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium max-w-3xl mx-auto leading-relaxed lang-str" data-so="ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ" data-ba="ناساندنا ئەندامێن تیمێ پروژەی، زانکۆ و زانیاریێن پەیوەندیێ بۆ هاریوکاری و ڕاوێژێ">ناساندنی ئەندامانی تیمی پڕۆژە، زانکۆ و زانیارییە پەیوەندییەکان بۆ هاوکاری و ڕاوێژ</p>
        </div>
    </header>

    <!-- Main Content Grid -->
    <section class="relative z-10 container mx-auto pb-24 px-4 max-w-6xl">
        
        <!-- Section Title -->
        <div class="text-center mb-16">
            <h3 class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white mb-4 lang-str" data-so="ئەندامانی سەرەکی پڕۆژە" data-ba="ئەندامێن سەرەکی یێن پروژەی">ئەندامانی سەرەکی پڕۆژە</h3>
            <p class="text-gray-600 dark:text-gray-400 font-medium lang-str" data-so="بۆ پەیوەندی کردن و بەسەرکردنەوەی زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت" data-ba="بۆ پەیوەندی کرن و دیتنا زانیاریێن ئەندامان دشێی ب رێکا ئیمێلی، ژمارا موبایلی یان فەیسبووکی پەیوەندیێ بکەی">بۆ پەیوەندی کردن و بەسەرکردنەوەی زانیاری ئەندامان دەتوانیت لە ڕێگەی ئیمێڵ، ژمارە موبایل یان فەیسبووکەوە پەیوەندی بکەیت</p>
        </div>

        <!-- 3 Team Members Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            
            <!-- Member 1 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-blue-600 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div>
                    <!-- وێنەی ئەندامی یەکەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-blue-600 to-cyan-400 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="muhamad.png" alt="Member 1" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">محمد کامران حمەساڵح</h4>
                    <p class="text-blue-600 dark:text-blue-400 font-bold text-center text-sm mb-6">زانکۆی ئاکرێ بۆ زانستە کردارییەکان - قۆناغی سێیەم</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="سەرپەرشتیار و پێشڕەوی پڕۆژەی کورد ئەی ئای. خاوەن دیدگاهێکی مۆدێرن لە بواری تەکنەلۆژیا و زیرەکی دەستکرددا، کار بۆ دابینکردن و ئاسانکاری پلاتفۆرمە ئەکادیمییەکان دەکات بە شێوازێکی پێشکەوتوو و داهێنەرانە." data-ba="لێرە دشێی کورتەیەک ژ کار و پسپۆڕیا ڤی ئەندامی بنووسی.">سەرپەرشتیاری گشتی و پەرەپێدەری سەرەکی</p>
                </div>
                
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
                        <span>[لینکی فەیسبووک]</span>
                    </a>
                </div>
            </div>

            <!-- Member 2 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-purple-600 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div>
                    <!-- وێنەی ئەندامی دووەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-purple-600 to-pink-500 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="لێرە_لینکی_وێنەی_دووەم_دابنە" alt="Member 2" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">[ ناوی ئەندامی دووەم ]</h4>
                    <p class="text-purple-600 dark:text-purple-400 font-bold text-center text-sm mb-6">[ ناوی زانکۆ و بەش / ڕۆڵ ]</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="لێرە دەتوانیت کورتەیەک لە کارەکان و پسپۆڕی ئەم ئەندامە بنووسیت." data-ba="لێرە دشێی کورتەیەک ژ کار و پسپۆڕیا ڤی ئەندامی بنووسی.">لێرە دەتوانیت کورتەیەک لە کارەکان و پسپۆڕی ئەم ئەندامە بنووسیت.</p>
                </div>
                
                <div class="space-y-3 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                    <a href="mailto:email2@example.com" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span dir="ltr">[email2@example.com]</span>
                    </a>
                    <a href="tel:+964XXXXXXXXX" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span dir="ltr">[ژمارە موبایل]</span>
                    </a>
                    <a href="https://facebook.com" target="_blank" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        <span>[لینکی فەیسبووک]</span>
                    </a>
                </div>
            </div>

            <!-- Member 3 -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-xl border-t-4 border-teal-500 flex flex-col justify-between hover:shadow-2xl transition-all duration-300 group">
                <div>
                    <!-- وێنەی ئەندامی سێیەم -->
                    <div class="relative w-28 h-28 mx-auto mb-6">
                        <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-emerald-500 rounded-full blur-md opacity-50 group-hover:opacity-80 transition duration-300"></div>
                        <img src="لێرە_لینکی_وێنەی_سێیەم_دابنە" alt="Member 3" class="relative w-28 h-28 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-lg">
                    </div>
                    <h4 class="text-2xl font-black text-gray-900 dark:text-white text-center mb-1">[ ناوی ئەندامی سێیەم ]</h4>
                    <p class="text-teal-600 dark:text-teal-400 font-bold text-center text-sm mb-6">[ ناوی زانکۆ و بەش / ڕۆڵ ]</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed text-center mb-6 lang-str" data-so="لێرە دەتوانیت کورتەیەک لە کارەکان و پسپۆڕی ئەم ئەندامە بنووسیت." data-ba="لێرە دشێی کورتەیەک ژ کار و پسپۆڕیا ڤی ئەندامی بنووسی.">لێرە دەتوانیت کورتەیەک لە کارەکان و پسپۆڕی ئەم ئەندامە بنووسیت.</p>
                </div>
                
                <div class="space-y-3 pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                    <a href="mailto:email3@example.com" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span dir="ltr">[email3@example.com]</span>
                    </a>
                    <a href="tel:+964XXXXXXXXX" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span dir="ltr">[ژمارە موبایل]</span>
                    </a>
                    <a href="https://facebook.com" target="_blank" class="flex items-center gap-3 text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-teal-600 dark:hover:text-teal-400 transition bg-white/50 dark:bg-gray-800/50 p-3 rounded-xl">
                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        <span>[لینکی فەیسبووک]</span>
                    </a>
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
    </script>
</body>
</html>