<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هەژمارەکەم - کورد ئەی ئای</title>
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
    <meta name="description" content="پڕۆفایلی بەکارهێنەر - کورد ئەی ئای">
    <meta name="keywords" content="پڕۆفایل, هەژمار, کورد ئەی ئای, بەکارهێنەر">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/profile">
    <meta property="og:title" content="هەژمارەکەم - KURD AI">
    <meta property="og:description" content="پڕۆفایلی بەکارهێنەر لە کورد ئەی ئای">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/profile">
    <meta property="twitter:title" content="هەژمارەکەم - KURD AI">
    <meta property="twitter:description" content="پڕۆفایلی بەکارهێنەر لە کورد ئەی ئای">
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
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
        .animation-delay-600 { animation-delay: 0.6s; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 20px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #475569; }
    </style>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- ناڤباری سەرەکی (وەک پەڕەکانی دیکە) -->
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
                <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <a href="/news" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="هەواڵەکان" data-ba="نووچە">هەواڵەکان</a>
                <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="تووڵەکان" data-ba="ئامراز">تووڵەکان</a>
                <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
                <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="دەرباری ئێمە" data-ba="دەربارەی مە">دەرباری ئێمە</a>
            </div>
            
            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-blue-600 text-white font-bold rounded-xl text-xs shadow-lg shadow-blue-500/30 lang-str" data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</a>
                <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50 lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>
            </div>
        </div>
    </nav>

    <!-- بەشی سەرەوەی پرۆفایل بە دیزاینی مۆدێرن -->
    <header class="relative min-h-[40vh] flex items-center justify-center overflow-hidden py-16 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-400 dark:bg-indigo-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-5xl mx-auto animate-fade-in">
            <!-- کارتی پرۆفایل -->
            <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <!-- ئاڤاتار -->
                    <div class="relative flex-shrink-0">
                        <div class="absolute -inset-3 bg-gradient-to-br from-blue-600 via-indigo-500 to-purple-600 rounded-full blur-xl opacity-40 animate-pulse"></div>
                        <div id="profile-avatar" class="relative w-28 h-28 md:w-36 md:h-36 rounded-full bg-gradient-to-br from-blue-500 to-indigo-700 border-4 border-white dark:border-gray-800 flex items-center justify-center text-white text-5xl md:text-6xl font-black shadow-2xl">
                            -
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>

                    <!-- زانیارییەکان -->
                    <div class="flex-1 text-center md:text-right">
                        <div class="flex flex-col md:flex-row md:items-center gap-3 mb-2">
                            <h2 id="profile-name" class="text-3xl md:text-4xl font-black text-gray-900 dark:text-white tracking-tight">...</h2>
                            <span id="account-type-badge" class="hidden px-4 py-1.5 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-black rounded-full border border-blue-200 dark:border-blue-800/50 w-fit">
                                <span class="lang-str" data-so="سەرپەرشتیار" data-ba="سەرپەرشتیار">سەرپەرشتیار</span>
                            </span>
                        </div>
                        <p id="profile-email" class="text-gray-500 dark:text-gray-400 text-lg font-medium" dir="ltr">...</p>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-4">
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span class="font-bold lang-str" data-so="هەژمار چالاکە" data-ba="هەژمار چالاکە">هەژمار چالاکە</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                                <span class="font-bold lang-str" data-so="خۆڕایی" data-ba="بێ بەرامبەر">خۆڕایی</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ناوەڕۆکی پرۆفایل -->
    <section class="relative z-10 container mx-auto pb-24 px-4 -mt-8">
        <div class="max-w-5xl mx-auto space-y-8">

            <!-- پەنێڵی بەڕێوەبردن (تەنها بۆ ئەدمین) -->
            <div class="admin-only hidden animate-slide-up">
                <div class="glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-black mb-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="lang-str" data-so="پەنێڵی بەڕێوەبردن" data-ba="پانێلا بڕێڤەبرنێ">پەنێڵی بەڕێوەبردن</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm lang-str" data-so="لێرەوە دەستگەیشتنی خێرا بۆ بەشەکانی بەڕێوەبردنی ماڵپەڕ." data-ba="ژ ڤێرێ دەستگەهشتنەکا لەز بۆ بەشێن بڕێڤەبرنا ماڵپەڕی.">لێرەوە دەستگەیشتنی خێرا بۆ بەشەکانی بەڕێوەبردنی ماڵپەڕ.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="/courses" class="group bg-gray-50/80 dark:bg-[#111827]/80 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 font-bold py-5 px-6 rounded-2xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800/50 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</span>
                        </a>
                        <a href="/ai-tools" class="group bg-gray-50/80 dark:bg-[#111827]/80 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 font-bold py-5 px-6 rounded-2xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800/50 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-sm lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</span>
                        </a>
                        <a href="/academic-guide" class="group bg-gray-50/80 dark:bg-[#111827]/80 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 font-bold py-5 px-6 rounded-2xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800/50 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            <span class="text-sm lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</span>
                        </a>
                        <a href="/ferga" class="group bg-gray-50/80 dark:bg-[#111827]/80 border border-gray-200/50 dark:border-gray-700/50 text-gray-700 dark:text-gray-300 font-bold py-5 px-6 rounded-2xl text-center hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-200 dark:hover:border-blue-800/50 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 shadow-sm">
                            <svg class="w-6 h-6 mx-auto mb-2 opacity-60 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            <span class="text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- کارتەکانی ئامار و زانیاری -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- ئامارەکان -->
                <div class="lg:col-span-2 glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl animate-slide-up animation-delay-200">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 text-center flex items-center justify-center gap-3">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="lang-str" data-so="ئامار و چالاکییەکان" data-ba="ئامار و چالاکی">ئامار و چالاکییەکان</span>
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-6 text-center border border-gray-100/50 dark:border-gray-700/50 hover:border-blue-200 dark:hover:border-blue-800/50 transition-all duration-300 group">
                            <div class="text-3xl md:text-4xl font-black text-blue-500 mb-1 fav-stats-courses">٠</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-bold lang-str" data-so="کۆرسی دڵخواز" data-ba="کۆرسێن دڵخواز">کۆرسی دڵخواز</div>
                        </div>
                        <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-6 text-center border border-gray-100/50 dark:border-gray-700/50 hover:border-blue-200 dark:hover:border-blue-800/50 transition-all duration-300 group">
                            <div class="text-3xl md:text-4xl font-black text-indigo-500 mb-1 fav-stats-tools">٠</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-bold lang-str" data-so="ئامرازی دڵخواز" data-ba="ئامرازێن دڵخواز">ئامرازی دڵخواز</div>
                        </div>
                        <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-6 text-center border border-gray-100/50 dark:border-gray-700/50 hover:border-blue-200 dark:hover:border-blue-800/50 transition-all duration-300 group">
                            <div id="stat-streak" class="text-3xl md:text-4xl font-black text-purple-500 mb-1">٠</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-bold lang-str" data-so="ڕۆژی بەشداری" data-ba="ڕۆژا پشکداریێ">ڕۆژی بەشداری</div>
                        </div>
                        <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-6 text-center border border-gray-100/50 dark:border-gray-700/50 hover:border-blue-200 dark:hover:border-blue-800/50 transition-all duration-300 group">
                            <div id="stat-xp" class="text-3xl md:text-4xl font-black text-cyan-500 mb-1">-</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 font-bold lang-str" data-so="خاڵی XP" data-ba="خاڵێن XP">خاڵی XP</div>
                        </div>
                    </div>

                    <p class="text-center text-sm text-gray-400 dark:text-gray-500 lang-str" data-so="لە داهاتوودا چالاکییەکانت و پێشکەوتنەکانت لێرەدا پیشان دەدرێت، کاتێک لە کۆرسەکان خوێندنت دەستپێکرد." data-ba="د پاشەڕۆژێ دا چالاکی و پێشکەفتنێن تە د ڤێرە دێ نیشان بدرن، دەمێ تۆ دەست ب خوێندنا کۆرسان بکی.">لە داهاتوودا چالاکییەکانت و پێشکەوتنەکانت لێرەدا پیشان دەدرێت.</p>
                </div>

                <!-- زانیارییە کەسییەکان -->
                <div class="glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl animate-slide-up animation-delay-400">
                    <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-8 text-center flex items-center justify-center gap-3">
                        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="lang-str" data-so="زانیارییە کەسییەکان" data-ba="پێزانینێن کەسی">زانیارییە کەسییەکان</span>
                    </h3>
                    
                    <div class="space-y-5">
                        <div class="flex items-center justify-between p-4 bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl border border-gray-100/50 dark:border-gray-700/50">
                            <span class="text-gray-500 dark:text-gray-400 font-bold text-sm lang-str" data-so="جۆری هەژمار" data-ba="جۆرێ هەژمارێ">جۆری هەژمار</span>
                            <span id="account-type" class="font-black text-gray-800 dark:text-white lang-str" data-so="بەکارهێنەر" data-ba="بکارئینەر">بەکارهێنەر</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl border border-gray-100/50 dark:border-gray-700/50">
                            <span class="text-gray-500 dark:text-gray-400 font-bold text-sm lang-str" data-so="بەشداریکردن" data-ba="پشکداریکرن">بەشداریکردن</span>
                            <span class="font-black text-green-600 dark:text-green-400 lang-str" data-so="خۆڕایی (چالاکە)" data-ba="بێ بەرامبەر (چالاکە)">خۆڕایی (چالاکە)</span>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl border border-gray-100/50 dark:border-gray-700/50">
                            <span class="text-gray-500 dark:text-gray-400 font-bold text-sm lang-str" data-so="ڕەوش" data-ba="ڕەوش">ڕەوش</span>
                            <span class="font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                <span class="lang-str" data-so="چالاکە" data-ba="چالاکە">چالاکە</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- کارتی زیادە: پێشکەوتنی فێرگە -->
            <div id="ferga-progress-card" class="glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl animate-slide-up animation-delay-400">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2 text-center flex items-center justify-center gap-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    <span class="lang-str" data-so="پێشکەوتنی فێرگە" data-ba="پێشکەفتنا فێرگەهێ">پێشکەوتنی فێرگە</span>
                </h3>
                <p id="ferga-progress-summary" class="text-center text-sm text-gray-500 dark:text-gray-400 font-bold mb-6"></p>
                <div id="ferga-progress-list" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
            </div>

            <!-- کارتی زیادە: باجەکانی فێرگە -->
            <div id="ferga-badges-card" class="glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl animate-slide-up animation-delay-500">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center flex items-center justify-center gap-3">
                    <span class="w-10 h-10 rounded-2xl bg-gradient-to-br from-amber-400 to-yellow-600 flex items-center justify-center text-xl shadow-inner">🏆</span>
                    <span class="lang-str" data-so="باجەکانی فێرگە" data-ba="باجێن فێرگەهێ">باجەکانی فێرگە</span>
                </h3>
                <div id="ferga-badges-list" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
            </div>

            <!-- بەشی دڵخوازەکان (Favorites) -->
            <div class="glass-card rounded-[2rem] p-8 md:p-10 shadow-xl border border-white/30 dark:border-gray-700/30 backdrop-blur-xl animate-slide-up">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center flex items-center justify-center gap-3">
                    <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span class="lang-str" data-so="دڵخوازەکان" data-ba="دڵخواز">دڵخوازەکان</span>
                </h3>

                <!-- Tab buttons: Courses / Tools -->
                <div class="flex justify-center gap-3 mb-8">
                    <button id="fav-tab-courses" onclick="switchFavTab('courses')" class="px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/30 transition-all lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</button>
                    <button id="fav-tab-tools" onclick="switchFavTab('tools')" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-all lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</button>
                </div>

                <!-- Favorites content -->
                <div id="fav-content" class="min-h-[100px]">
                    <div id="fav-courses" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
                    <div id="fav-tools" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 hidden"></div>
                    <div id="fav-empty" class="text-center py-10">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <p class="text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="هێشتا هیچ دڵخوازێکی نییە" data-ba="هێشتا چ دڵخواز نینن">هێشتا هیچ دڵخوازێکی نییە</p>
                        <p class="text-gray-300 dark:text-gray-600 text-sm mt-2 lang-str" data-so="لە کۆرس یان ئامرازەکاندا کرتە لەسەر دڵ بکە بۆ زیادکردن" data-ba="د کۆرس یان ئامرازان دا کرتە لسەر دڵ بکە بۆ زێدەکرن">لە کۆرس یان ئامرازەکاندا کرتە لەسەر دڵ بکە بۆ زیادکردن</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref, onValue, remove } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let isAdmin = false;

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) { langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی'; }
            
            document.querySelectorAll('.lang-str').forEach(el => {
                let text = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
                el.innerText = text;
            });

            const typeEl = document.getElementById('account-type');
            if(isAdmin && typeEl) {
                typeEl.innerText = currentLang === 'so' ? 'ئەدمین (تایبەت)' : 'ئەدمین (تایبەت)';
                typeEl.classList.add('text-red-500', 'dark:text-red-400');
            }
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
            renderFavCourses();
            renderFavTools();
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

        function getInitials(name) {
            if(!name) return 'U';
            const parts = name.split(' ');
            if(parts.length > 1) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return name.substring(0, 2).toUpperCase();
        }

        let favTab = 'courses';
        let favCourses = {};
        let favTools = {};
        let coursesData = {};
        let toolsData = {};

        window.switchFavTab = function(tab) {
            favTab = tab;
            document.getElementById('fav-tab-courses').className = tab === 'courses' ? 'px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/30 transition-all' : 'px-6 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-all';
            document.getElementById('fav-tab-tools').className = tab === 'tools' ? 'px-6 py-2.5 bg-blue-600 text-white font-bold rounded-xl text-sm shadow-lg shadow-blue-500/30 transition-all' : 'px-6 py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-bold rounded-xl text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-all';
            document.getElementById('fav-courses').classList.toggle('hidden', tab !== 'courses');
            document.getElementById('fav-tools').classList.toggle('hidden', tab !== 'tools');
            renderFavCourses();
            renderFavTools();
        };

        function renderFavCourses() {
            const container = document.getElementById('fav-courses');
            const favIds = Object.keys(favCourses);
            if (favIds.length === 0) {
                container.innerHTML = '';
                document.getElementById('fav-empty').classList.remove('hidden');
                return;
            }
            document.getElementById('fav-empty').classList.add('hidden');
            let html = '';
            favIds.forEach(id => {
                const c = coursesData[id];
                if (!c) return;
                const title = currentLang === 'ba' && c.title_ba ? c.title_ba : c.title_so || c.title;
                const desc = currentLang === 'ba' && c.desc_ba ? c.desc_ba : c.desc_so || c.description;
                html += `
                    <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl overflow-hidden border border-gray-100/50 dark:border-gray-700/50 hover:border-red-200 dark:hover:border-red-800/50 transition-all group relative">
                        <button onclick="removeFavCourse('${id}', event)" class="absolute top-2 left-2 z-10 w-7 h-7 flex items-center justify-center rounded-full bg-red-500/80 text-white opacity-0 group-hover:opacity-100 hover:bg-red-600 transition-all" title="${currentLang === 'so' ? 'لابردن' : 'ژێبرن'}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                        <div class="h-28 overflow-hidden bg-gray-200 dark:bg-gray-800">
                            <img src="${c.image_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                        </div>
                        <div class="p-4">
                            <h4 class="font-black text-sm text-gray-900 dark:text-white line-clamp-1 mb-2">${title}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 mb-3">${desc || ''}</p>
                            <a href="${c.video_url}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 transition">
                                <span>${currentLang === 'so' ? 'بینین' : 'دیتن'}</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function renderFavTools() {
            const container = document.getElementById('fav-tools');
            const favIds = Object.keys(favTools);
            if (favIds.length === 0) {
                container.innerHTML = '';
                document.getElementById('fav-empty').classList.remove('hidden');
                return;
            }
            document.getElementById('fav-empty').classList.add('hidden');
            let html = '';
            favIds.forEach(id => {
                const t = toolsData[id];
                if (!t) return;
                const title = currentLang === 'ba' && t.title_ba ? t.title_ba : t.title_so || t.title;
                html += `
                    <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-4 border border-gray-100/50 dark:border-gray-700/50 hover:border-red-200 dark:hover:border-red-800/50 transition-all group flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-white dark:bg-gray-800 flex-shrink-0 p-2 border border-gray-100 dark:border-gray-700">
                            <img src="${t.image_url}" class="w-full h-full object-contain">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-black text-sm text-gray-900 dark:text-white line-clamp-1">${title}</h4>
                            <a href="${t.tool_url}" target="_blank" class="text-xs font-bold text-purple-600 dark:text-purple-400 hover:text-purple-800 transition flex items-center gap-1">
                                <span>${currentLang === 'so' ? 'کردنەوە' : 'ڤەکرن'}</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                        <button onclick="removeFavTool('${id}', event)" class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-red-50 dark:bg-red-900/20 text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 hover:text-red-600 transition" title="${currentLang === 'so' ? 'لابردن' : 'ژێبرن'}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        let fergaProgressData = {};
        let fergaLangNames = {};

        const AI_TOPIC_FALLBACK = {
            ai_intro: { name_so: 'پێشەکی بۆ ژیری دەستکرد', name_ba: 'دەستپێک بۆ زیرەکییا دەستکرد', icon: '🧠' },
            ai_data: { name_so: 'داتا و شیکردنەوەی داتا', name_ba: 'داتا و شیکرنا داتایان', icon: '📊' },
            ai_algo: { name_so: 'بنەڕەتەکانی ئالگۆریتم', name_ba: 'بنەڕەتێن ئالگۆریتم', icon: '⚙️' },
            ai_ml: { name_so: 'فێربوونی ئامێر (Machine Learning)', name_ba: 'فێربوونا ماکین (Machine Learning)', icon: '🤖' },
            ai_dl: { name_so: 'فێربوونی قووڵ (Deep Learning)', name_ba: 'فێربوونا کور (Deep Learning)', icon: '🧠' },
            ai_cv: { name_so: 'بینینی کۆمپیوتەر (Computer Vision)', name_ba: 'دیتنا کۆمپیوتەر (Computer Vision)', icon: '👁️' },
            ai_nlp: { name_so: 'پرۆسێسکردنی زمان (NLP)', name_ba: 'پێڤاجۆکیرنا زمان (NLP)', icon: '💬' },
            ai_llm: { name_so: 'مۆدێلی زمانی گەورە و AI پراکتیکی', name_ba: 'مۆدێلێن زمانێن مەزن و AI پراکتیک', icon: '🚀' },
        };

        function fergaLangName(langId) {
            const l = fergaLangNames[langId];
            if (l) return currentLang === 'ba' && l.name_ba ? l.name_ba : (l.name_so || l.name || langId);
            const fb = AI_TOPIC_FALLBACK[langId];
            if (fb) return currentLang === 'ba' ? (fb.name_ba || fb.name_so) : fb.name_so;
            return langId;
        }

        function renderFergaProgress() {
            const container = document.getElementById('ferga-progress-list');
            const summaryEl = document.getElementById('ferga-progress-summary');
            if (!container) return;
            const lp = fergaProgressData.lessonProgress || {};
            const langIds = Object.keys(lp).filter(id => id && id !== 'undefined' && id !== 'null');
            if (langIds.length === 0) {
                if (summaryEl) summaryEl.innerText = currentLang === 'so' ? 'هێشتا هیچ پێشکەوتنێک تۆمار نەکراوە — لە فێرگە دەست بە خوێندن بکە' : 'هێشتا چ پێشکەفتن نەهاتیە تۆمارکرن — د فێرگە دەست ب خوێندنێ بکە';
                container.innerHTML = '';
                return;
            }
            let totalCompleted = 0; let totalAll = 0;
            let html = '';
            langIds.forEach(langId => {
                const p = lp[langId] || {};
                const total = p.total || 0;
                const completed = p.completed || 0;
                const last = p.lastIndex || 0;
                totalCompleted += completed; totalAll += total;
                const percent = total > 0 ? Math.min(100, Math.round((completed / total) * 100)) : 0;
                html += `
                <div class="bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-5 border border-gray-100/50 dark:border-gray-700/50">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-black text-gray-900 dark:text-white flex items-center gap-2">${fergaLangName(langId)}${(total > 0 && completed >= total) ? '<span class="text-base" title="' + (currentLang === 'so' ? 'تەواو بوو' : 'دووماهی بوو') + '">' + fergaBadgeMeta(langId).icon + '</span>' : ''}</span>
                        <span class="text-xs font-black px-3 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 rounded-full">${completed}/${total}</span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-bold mb-3">${currentLang === 'so' ? 'گەیشتووەتە وانەی' : 'گەهیشتایە وانەیێ'} ${Math.min(last, total) || 0} ${currentLang === 'so' ? 'لە' : 'ژ'} ${total}</p>
                    <div class="h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-500 to-emerald-400 rounded-full transition-all duration-500" style="width:${percent}%"></div>
                    </div>
                    <p class="text-left text-xs font-black text-emerald-600 dark:text-emerald-400 mt-1.5">${percent}%</p>
                </div>`;
            });
            if (summaryEl) summaryEl.innerText = currentLang === 'so' ? `کۆی گشتی: ${totalCompleted} وانە لە ${totalAll}` : `کۆڤکا گشتی: ${totalCompleted} وانەی ژ ${totalAll}`;
            container.innerHTML = html;
        }

        // --- باجەکانی فێرگە ---
        const PROFILE_BADGE_META = {
            py: { icon: '🐍', grad: 'from-blue-500 to-cyan-400' },
            cpp: { icon: '⚡', grad: 'from-indigo-500 to-purple-600' },
            js: { icon: '🟨', grad: 'from-yellow-400 to-amber-500' },
            php: { icon: '🐘', grad: 'from-indigo-400 to-violet-600' },
            java: { icon: '☕', grad: 'from-red-500 to-rose-600' },
            rs: { icon: '🦀', grad: 'from-orange-500 to-red-600' },
            cs: { icon: '💜', grad: 'from-purple-500 to-fuchsia-600' },
            'html+css': { icon: '🎨', grad: 'from-orange-400 to-pink-500' },
        };
        let fergaBadgesData = {};

        function fergaBadgeMeta(langId) {
            const l = fergaLangNames[langId];
            if (l && l.is_ai) return { icon: l.icon || '🤖', grad: 'from-emerald-500 to-cyan-500' };
            if (AI_TOPIC_FALLBACK[langId]) return { icon: AI_TOPIC_FALLBACK[langId].icon || '🤖', grad: 'from-emerald-500 to-cyan-500' };
            const ext = (l && l.ext) ? String(l.ext).replace('.', '').toLowerCase() : '';
            return PROFILE_BADGE_META[ext] || { icon: '🏆', grad: 'from-blue-500 to-indigo-600' };
        }

        function renderFergaBadges() {
            const container = document.getElementById('ferga-badges-list');
            if (!container) return;
            const earnedIds = new Set(Object.keys(fergaBadgesData).filter(id => fergaBadgesData[id]));
            const lp = fergaProgressData.lessonProgress || {};
            Object.keys(lp).forEach(id => {
                const p = lp[id] || {};
                if ((p.total || 0) > 0 && (p.completed || 0) >= p.total) earnedIds.add(id);
            });
            if (earnedIds.size === 0) {
                container.innerHTML = `<div class="col-span-2 md:col-span-4 text-center py-8 text-sm font-bold text-gray-400 dark:text-gray-500">${currentLang === 'so' ? 'هێشتا هیچ باجێکت بەدەست نەهێناوە — لە فێرگە زمانێک بە تەواوی تەواو بکە!' : 'هێشتا چ باجەکە نەدستی نەکەتیە — د فێرگە زوانەک ب تەمامی دووماهی بکە!'}</div>`;
                return;
            }
            let html = '';
            earnedIds.forEach(id => {
                const meta = fergaBadgeMeta(id);
                html += `
                <div class="group bg-gray-50/80 dark:bg-[#111827]/80 rounded-2xl p-5 border border-gray-100/50 dark:border-gray-700/50 flex flex-col items-center text-center gap-2 hover:-translate-y-1 hover:shadow-lg transition-all cursor-default">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br ${meta.grad} flex items-center justify-center text-4xl shadow-lg ring-4 ring-amber-200/40 dark:ring-amber-900/40">
                        ${meta.icon}
                    </div>
                    <span class="text-[10px] font-black text-amber-600 dark:text-amber-400">${currentLang === 'so' ? '🏅 باجی تەواوکراو' : '🏅 باجا دووماهی'}</span>
                    <h4 class="font-black text-xs text-gray-800 dark:text-gray-200">${fergaLangName(id)}</h4>
                </div>`;
            });
            container.innerHTML = html;
        }

        window.removeFavCourse = function(courseId, event) {
            if (event) event.stopPropagation();
            const user = auth.currentUser;
            if (user) remove(ref(db, 'favorites/' + user.uid + '/courses/' + courseId));
        };

        window.removeFavTool = function(toolId, event) {
            if (event) event.stopPropagation();
            const user = auth.currentUser;
            if (user) remove(ref(db, 'favorites/' + user.uid + '/ai_tools/' + toolId));
        };

        onAuthStateChanged(auth, (user) => { 
            if(!user) {
                window.location.href = "/login"; 
            } else { 
                document.body.style.display = 'block'; 
                
                let displayName = user.displayName || user.email.split('@')[0];
                document.getElementById('profile-name').innerText = displayName;
                document.getElementById('profile-email').innerText = user.email;
                document.getElementById('profile-avatar').innerText = getInitials(displayName);

                const adminEmails = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"];
                if(adminEmails.includes(user.email)) {
                    isAdmin = true;
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                    document.getElementById('account-type-badge').classList.remove('hidden');
                }

                // بارکردنی دڵخوازەکان و کۆرس/ئامرازەکان
                onValue(ref(db, 'favorites/' + user.uid + '/courses'), (snap) => {
                    favCourses = snap.val() || {};
                    document.querySelector('.fav-stats-courses').textContent = Object.keys(favCourses).length;
                    if (favTab === 'courses') renderFavCourses();
                });
                onValue(ref(db, 'favorites/' + user.uid + '/ai_tools'), (snap) => {
                    favTools = snap.val() || {};
                    document.querySelector('.fav-stats-tools').textContent = Object.keys(favTools).length;
                    if (favTab === 'tools') renderFavTools();
                });
                onValue(ref(db, 'courses'), (snap) => {
                    coursesData = snap.val() || {};
                    if (favTab === 'courses') renderFavCourses();
                });
                onValue(ref(db, 'ai_tools'), (snap) => {
                    toolsData = snap.val() || {};
                    if (favTab === 'tools') renderFavTools();
                });

                onValue(ref(db, 'users/' + user.uid + '/ferga_progress'), (snap) => {
                    const data = snap.val() || {};
                    fergaProgressData = data;
                    const statStreak = document.getElementById('stat-streak');
                    if (statStreak) statStreak.textContent = data.streak || 0;
                    const statXp = document.getElementById('stat-xp');
                    if (statXp) statXp.textContent = data.xp || 0;
                    renderFergaProgress();
                    renderFergaBadges();
                });
                onValue(ref(db, 'users/' + user.uid + '/ferga_badges'), (snap) => {
                    fergaBadgesData = snap.val() || {};
                    renderFergaBadges();
                });
                onValue(ref(db, 'ferga_languages'), (snap) => {
                    fergaLangNames = snap.val() || {};
                    renderFergaProgress();
                    renderFergaBadges();
                });

                applyLanguage();
            }
        });
        
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
@include('components.chat-widget')
</body>
</html>
