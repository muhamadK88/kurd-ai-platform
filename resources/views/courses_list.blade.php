<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کۆرسەکانمان - کورد ئەی ئای</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <meta name="description" content="کۆرسەکانی کورد ئەی ئای - فێربوونی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی">
    <meta name="keywords" content="کۆرس, کورد ئەی ئای, زیرەکی دەستکرد, فێربوون, پرۆگرامسازی, کوردی">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/courses">
    <meta property="og:title" content="کۆرسەکان - KURD AI">
    <meta property="og:description" content="کۆرسەکانی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی - کورد ئەی ئای">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/courses">
    <meta property="twitter:title" content="کۆرسەکان - KURD AI">
    <meta property="twitter:description" content="کۆرسەکانی زیرەکی دەستکرد و پرۆگرامسازی بە زمانی کوردی - کورد ئەی ئای">
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
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;  
            overflow: hidden;
        }
    </style>
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
            
            <div class="hidden lg:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
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

    <!-- بەشی هێدەر بە دیزاینی مۆدێرن -->
    <header class="relative min-h-[50vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="کۆرسەکانمان" data-ba="کۆرسێن مە">کۆرسەکانمان</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی" data-ba="شیانێن خۆ پێشبێخە دگەل باشترین کۆرسێن ژیرییا دەستکرد و پرۆگرامسازییێ">پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی</p>
        </div>
    </header>

    <!-- بەشی پیشاندانی کۆرسەکان -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        
        <!-- بەشی فلتەرەکان (کەتەگۆری) -->
        <div class="mb-12 max-w-6xl mx-auto bg-white/40 dark:bg-gray-900/40 p-6 md:p-8 rounded-[2rem] border border-gray-200/50 dark:border-gray-800/50 shadow-sm backdrop-blur-xl">
            
            <!-- فلتەری زمانەکان -->
            <div class="mb-6 border-b border-gray-200/50 dark:border-gray-700/50 pb-6">
                <h4 class="text-center font-bold text-gray-500 dark:text-gray-400 mb-4 text-sm lang-str" data-so="جیاکردنەوە بەپێی زمان:" data-ba="جوداکرن بپێی زمانێ:">جیاکردنەوە بەپێی زمان:</h4>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <button onclick="window.filterByLang('all')" class="lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-blue-600 text-white shadow-lg shadow-blue-500/30" data-target="all">
                        <span class="lang-str" data-so="هەموو زمانەکان" data-ba="هەمی زمان">هەموو زمانەکان</span>
                    </button>
                    <button onclick="window.filterByLang('sorani')" class="lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700" data-target="sorani">سۆرانی</button>
                    <button onclick="window.filterByLang('badini')" class="lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700" data-target="badini">بادینی</button>
                    <button onclick="window.filterByLang('arabic')" class="lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700" data-target="arabic">عەرەبی</button>
                    <button onclick="window.filterByLang('english')" class="lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700" data-target="english">ئینگلیزی</button>
                </div>
            </div>

            <!-- فلتەری کەتەگۆرییەکان (پێشوەخت دیاری کراوە) -->
            <div>
                <h4 class="text-center font-bold text-gray-500 dark:text-gray-400 mb-4 text-sm lang-str" data-so="جیاکردنەوە بەپێی کەتەگۆری:" data-ba="جوداکرن بپێی کەتگۆریێ:">جیاکردنەوە بەپێی کەتەگۆری:</h4>
                <div class="flex flex-wrap items-center justify-center gap-3" id="topic-filters">
                    <!-- کەتەگۆرییەکان لە JavaScriptـەوە زیاد دەکرێن -->
                </div>
            </div>

        </div>

        <div id="courses-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto"></div>
    </section>

    <!-- بەشی زیادکردنی کۆرس (تایبەت بە ئەدمین) -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-4xl mx-auto border-t-4 border-indigo-600 relative overflow-hidden">
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
                        <textarea id="desc_so" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none custom-scrollbar"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتە (بادینی)</label>
                        <textarea id="desc_ba" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all resize-none custom-scrollbar"></textarea>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="بەستەری ڤیدیۆ (لینکی یوتیوب یان درایڤ)" data-ba="لینکا ڤیدیۆیێ">بەستەری ڤیدیۆ</label>
                        <input type="url" id="video_url" required dir="ltr" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">نرخ بە دۆلار (بۆ خۆڕایی بنووسە 0)</label>
                        <input type="number" id="price" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all">
                    </div>
                </div>

                <!-- هاوپۆلی زمان و بابەت -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="هاوپۆلی زمانی کۆرس" data-ba="جورێ زمانێ کۆرسێ">هاوپۆلی زمانی کۆرس</label>
                        <select id="course_category" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all font-bold">
                            <option value="sorani">سۆرانی</option>
                            <option value="badini">بادینی</option>
                            <option value="arabic">عەرەبی</option>
                            <option value="english">ئینگلیزی</option>
                        </select>
                    </div>
                    
                    <!-- بەشی هەڵبژاردنی کەتەگۆری (پێشوەخت دیاری کراوە) -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="کەتەگۆری" data-ba="کەتگۆری">کەتەگۆری</label>
                        <select id="course_topic" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-all font-bold">
                            <!-- کەتەگۆرییەکان لە JavaScriptـەوە زیاد دەکرێن -->
                        </select>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="وێنەی کۆرس (ئەپڵۆدکردن)" data-ba="وێنێ کۆرسێ">وێنەی کۆرس</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                        <input type="file" id="course_image_input" accept="image/*" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 font-bold">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-1 transition-all">زیادکردنی کۆرس</button>
            </form>
        </div>
    </section>

    <!-- پەنجەرەی زیاتر ببینە (Modal) -->
    <div id="courseModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeCourseModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0" id="modalContent">
            <button onclick="window.closeCourseModal()" class="absolute top-5 right-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <div class="flex gap-2 mb-4">
                    <span id="modalBadge" class="bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-black px-3 py-1 rounded-full">زمان</span>
                    <span id="modalTopic" class="bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 text-xs font-black px-3 py-1 rounded-full">بابەت</span>
                </div>
                <h3 id="modalTitle" class="text-2xl font-black text-gray-900 dark:text-white mb-4">ناوی کۆرس</h3>
                <div class="custom-scrollbar max-h-[50vh] overflow-y-auto pr-2">
                    <p id="modalDesc" class="text-gray-600 dark:text-gray-300 leading-loose text-sm md:text-base font-medium">تەواوی زانیارییەکە لێرە دەردەکەوێت...</p>
                </div>
            </div>
            <div class="mt-8 pt-4 border-t border-gray-200 dark:border-gray-700 text-left">
                <button onclick="window.closeCourseModal()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">داخستن</button>
            </div>
        </div>
    </div>

    <!-- پەنجەرەی دەستکاری کردنی کۆرس (Modal) -->
    <div id="editModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeEditModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 overflow-y-auto max-h-[90vh]" id="editModalContent">
            <button onclick="window.closeEditModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center lang-str" data-so="دەستکاری کردنی کۆرس" data-ba="دەستکاریکرنا کۆرسێ">دەستکاری کردنی کۆرس</h3>
                <form id="edit-form" class="space-y-5">
                    <input type="hidden" id="edit-course-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناونیشان (سۆرانی)</label>
                            <input type="text" id="edit_title_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناونیشان (بادینی)</label>
                            <input type="text" id="edit_title_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتە (سۆرانی)</label>
                            <textarea id="edit_desc_so" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتە (بادینی)</label>
                            <textarea id="edit_desc_ba" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1 lang-str" data-so="بەستەری ڤیدیۆ" data-ba="لینکا ڤیدیۆیێ">بەستەری ڤیدیۆ</label>
                            <input type="url" id="edit_video_url" dir="ltr" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">نرخ ($)</label>
                            <input type="number" id="edit_price" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1 lang-str" data-so="زمان" data-ba="زمان">زمان</label>
                            <select id="edit_course_category" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm font-bold">
                                <option value="sorani">سۆرانی</option>
                                <option value="badini">بادینی</option>
                                <option value="arabic">عەرەبی</option>
                                <option value="english">ئینگلیزی</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1 lang-str" data-so="کەتەگۆری" data-ba="کەتگۆری">کەتەگۆری</label>
                            <select id="edit_course_topic" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all text-sm font-bold"></select>
                        </div>
                    </div>
                    <button type="submit" id="edit-submit-btn" class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-amber-500/30 hover:-translate-y-0.5 transition-all lang-str" data-so="پاشەکەوتکردن" data-ba="پاشەکەوتکرن">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

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

        // گۆڕاوەکان بۆ فلتەرکردن
        let currentLang = localStorage.getItem('site-lang') || 'so';
        let firebaseDataCache = {}; 
        window.isAdmin = false;
        let currentUserId = null;
        let userFavorites = {};

        const COURSE_CATEGORIES = [
            { id: 'programming-languages', name_so: 'زمانی پڕۆگرامینگ', name_ba: 'زمانێن پرۆگرامسازییێ' },
            { id: 'web-development', name_so: 'پەرەپێدانی وێب', name_ba: 'پێشڤەبرنا وێبێ' },
            { id: 'mobile-development', name_so: 'پەرەپێدانی ئەپڵکەیشن', name_ba: 'پێشڤەبرنا ئەپڵکەیشنێ' },
            { id: 'ai-machine-learning', name_so: 'ژیری دەستکرد و فێربوونی ئامێر', name_ba: 'ژیرییا دەستکرد و فێربوونا ئامێر' },
            { id: 'data-science', name_so: 'زانستی داتا', name_ba: 'زانستا داتایێ' },
            { id: 'cybersecurity', name_so: ' سکویریتی', name_ba: 'سکویریتی ' },
            { id: 'design', name_so: 'گرافیک دیزاین', name_ba: 'گرافیک دیزاین' },
            { id: 'video-production', name_so: 'ڤیدیۆ و مۆنتاژ', name_ba: 'ڤیدیۆ و مۆنتاژ' },
            { id: 'database-system', name_so: 'سیستەمی داتابەیس', name_ba: 'سیستەما داتابەیسێ' },

            { id: 'business-productivity', name_so: 'بزنس و بەرهەمهێنان', name_ba: 'بزنس و بەرهەمهێنان' },
            
            { id: 'other', name_so: 'هیتر', name_ba: 'هیتر' }
        ];
        
        window.activeLang = 'all';
        window.activeTopic = 'all';

        // ----- بەشی زمان (Language Toggle) -----
        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) {
                langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            }

            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });

            renderCourses(firebaseDataCache);
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        // ----- فەنکشنە جیهانییەکان بۆ مۆدێل و فلتەر -----
        window.openCourseModal = function(title, desc, badgeTxt, topicTxt) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modalBadge').innerText = badgeTxt;
            document.getElementById('modalTopic').innerText = topicTxt;
            
            const modal = document.getElementById('courseModal');
            const modalContent = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('translate-y-4', 'opacity-0');
                modalContent.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeCourseModal = function() {
            const modal = document.getElementById('courseModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('translate-y-0', 'opacity-100');
            modalContent.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        window.filterByLang = function(lang) {
            window.activeLang = lang;
            document.querySelectorAll('.lang-btn').forEach(btn => {
                if (btn.getAttribute('data-target') === lang) {
                    btn.className = "lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-blue-600 text-white shadow-lg shadow-blue-500/30";
                } else {
                    btn.className = "lang-btn px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700";
                }
            });
            applyFilters();
        };

        window.filterByTopic = function(topic) {
            window.activeTopic = topic;
            document.querySelectorAll('.topic-btn').forEach(btn => {
                if(btn.getAttribute('data-target') === topic) {
                    btn.className = "topic-btn px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-indigo-600 text-white shadow-lg shadow-indigo-500/30";
                } else {
                    btn.className = "topic-btn px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700";
                }
            });
            applyFilters();
        };

        function applyFilters() {
            document.querySelectorAll('.course-item').forEach(item => {
                const itemLang = item.getAttribute('data-lang');
                const itemTopic = item.getAttribute('data-topic');
                
                const matchLang = window.activeLang === 'all' || itemLang === window.activeLang;
                const matchTopic = window.activeTopic === 'all' || itemTopic === window.activeTopic;
                
                if (matchLang && matchTopic) {
                    item.style.display = 'flex';
                    item.animate([{opacity: 0, transform: 'scale(0.95)'}, {opacity: 1, transform: 'scale(1)'}], {duration: 300, fill: 'forwards'});
                } else {
                    item.style.display = 'none';
                }
            });
        }

        window.deleteCourse = async function(id) {
            if(confirm('دڵنیایت لە سڕینەوەی ئەم کۆرسە؟')) {
                try {
                    await remove(dbRef(db, 'courses/' + id));
                    alert('کۆرسەکە سڕایەوە');
                } catch(error) {
                    alert('هەڵەیەک ڕوویدا لە کاتی سڕینەوەدا');
                }
            }
        };

        window.toggleCourseFav = function(courseId, event) {
            if(event) event.stopPropagation();
            if (!currentUserId) return;
            const favRef = dbRef(db, 'favorites/' + currentUserId + '/courses/' + courseId);
            if (userFavorites && userFavorites[courseId]) {
                remove(favRef);
            } else {
                set(favRef, { favoritedAt: Date.now() });
            }
        };

        // ----- پڕکردنەوەی هەڵبژاردنی کەتەگۆری لە فۆرمی زیادکردن -----
        function populateCategorySelect() {
            const select = document.getElementById('course_topic');
            if (!select) return;
            select.innerHTML = '';
            COURSE_CATEGORIES.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.id;
                opt.textContent = cat.name_so;
                select.appendChild(opt);
            });
        }
        populateCategorySelect();

        // ----- پڕکردنەوەی کەتەگۆری لە مۆدێلی دەستکاری -----
        function populateEditCategorySelect() {
            const select = document.getElementById('edit_course_topic');
            if (!select) return;
            select.innerHTML = '';
            COURSE_CATEGORIES.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat.id;
                opt.textContent = cat.name_so;
                select.appendChild(opt);
            });
        }
        populateEditCategorySelect();

        // ----- دەستکاری کردنی کۆرس (Edit Modal) -----
        let editCourseData = null;

        window.openEditModal = function(courseId) {
            const data = firebaseDataCache[courseId];
            if (!data) {
                alert('نەتوانرا زانیاری کۆرسەکە بدۆزرێتەوە');
                return;
            }
            editCourseData = { fb_id: courseId, ...data };
            
            document.getElementById('edit-course-id').value = courseId;
            document.getElementById('edit_title_so').value = data.title_so || '';
            document.getElementById('edit_title_ba').value = data.title_ba || '';
            document.getElementById('edit_desc_so').value = data.desc_so || data.description || '';
            document.getElementById('edit_desc_ba').value = data.desc_ba || '';
            document.getElementById('edit_video_url').value = data.video_url || '';
            document.getElementById('edit_price').value = data.price || 0;
            document.getElementById('edit_course_category').value = data.course_category || 'sorani';
            document.getElementById('edit_course_topic').value = data.topic || 'other';

            const modal = document.getElementById('editModal');
            const content = document.getElementById('editModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeEditModal = function() {
            const modal = document.getElementById('editModal');
            const content = document.getElementById('editModalContent');
            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        document.getElementById('edit-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!editCourseData) return;
            
            const courseId = document.getElementById('edit-course-id').value;
            const submitBtn = document.getElementById('edit-submit-btn');
            submitBtn.innerText = "خەریکە پاشەکەوت دەکرێت...";
            submitBtn.classList.add('opacity-70', 'cursor-wait');

            try {
                await set(dbRef(db, 'courses/' + courseId), {
                    title_so: document.getElementById('edit_title_so').value,
                    title_ba: document.getElementById('edit_title_ba').value,
                    desc_so: document.getElementById('edit_desc_so').value,
                    desc_ba: document.getElementById('edit_desc_ba').value,
                    video_url: document.getElementById('edit_video_url').value,
                    price: document.getElementById('edit_price').value || 0,
                    course_category: document.getElementById('edit_course_category').value,
                    topic: document.getElementById('edit_course_topic').value,
                    image_url: editCourseData.image_url || editCourseData.image || ''
                });

                submitBtn.innerText = currentLang === 'so' ? 'پاشەکەوتکردن' : 'پاشەکەوتکرن';
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                window.closeEditModal();
                alert('کۆرسەکە بە سەرکەوتوویی پاشەکەوت کرا');
            } catch (error) {
                submitBtn.innerText = currentLang === 'so' ? 'پاشەکەوتکردن' : 'پاشەکەوتکرن';
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                alert('هەڵەیەک ڕوویدا: ' + error.message);
            }
        });

        // ----- هێنان و پیشاندانی کۆرسەکان لە فایەربەیس (بە کۆمەڵ کەتەگۆری) -----
        function renderCourses(data) {
            const container = document.getElementById('courses-container');
            const topicFiltersContainer = document.getElementById('topic-filters');
            
            if (!container) return;
            container.innerHTML = "";
            
            if (!data || Object.keys(data).length === 0) {
                const emptyText = currentLang === 'so' ? 'هێشتا هیچ کۆرسێک زیاد نەکراوە' : 'هێشتا چ کۆرس نەهاتینە زێدەکرن';
                container.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">${emptyText}</p></div>`;
                if(topicFiltersContainer) topicFiltersContainer.innerHTML = '';
                return;
            }

            // دروستکردنی دوگمەکانی فلتەری کەتەگۆری لە لیستی پێشوەخت دیاریکراو
            if(topicFiltersContainer) {
                const allLabel = currentLang === 'so' ? 'هەموو کەتەگۆرییەکان' : 'هەمی کەتگۆری';
                let topicsHtml = `<button onclick="window.filterByTopic('all')" class="topic-btn px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ${window.activeTopic === 'all' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-gray-700'}" data-target="all">${allLabel}</button>`;
                
                COURSE_CATEGORIES.forEach(cat => {
                    const catName = currentLang === 'ba' ? cat.name_ba : cat.name_so;
                    const isActive = window.activeTopic === cat.id;
                    const activeClass = isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-gray-700';
                    topicsHtml += `<button onclick="window.filterByTopic('${cat.id}')" class="topic-btn px-4 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ${activeClass}" data-target="${cat.id}">${catName}</button>`;
                });
                
                topicFiltersContainer.innerHTML = topicsHtml;
            }

            // کۆکردنەوەی کۆرسەکان بەپێی کەتەگۆری
            let grouped = {};
            let categoryOrder = COURSE_CATEGORIES.map(c => c.id);
            
            for (let id in data) {
                const c = data[id];
                const catId = c.topic || 'other';
                if (!grouped[catId]) grouped[catId] = [];
                grouped[catId].push({ fb_id: id, ...c });
            }

            // ڕێکخستنی کەتەگۆرییەکان: ئەو کەتەگۆرییانەی کە کۆرسیان تێدایە
            let sortedCategories = categoryOrder.filter(catId => grouped[catId]);
            let otherCategories = Object.keys(grouped).filter(catId => !categoryOrder.includes(catId));
            sortedCategories.push(...otherCategories);

            // ڕێندەرکردنی کۆرسەکان بە کۆمەڵ کەتەگۆری
            let allHtml = '';
            sortedCategories.forEach(catId => {
                const courses = grouped[catId];
                if (!courses || courses.length === 0) return;

                const catDef = COURSE_CATEGORIES.find(c => c.id === catId);
                const catName = catDef 
                    ? (currentLang === 'ba' ? catDef.name_ba : catDef.name_so)
                    : catId;

                // سەرناوی کەتەگۆری
                allHtml += `
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 mb-6 mt-4 first:mt-0">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="h-1 flex-grow rounded-full bg-gradient-to-r from-indigo-500/30 to-transparent"></div>
                            <h2 class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white whitespace-nowrap">${catName}</h2>
                            <div class="h-1 flex-grow rounded-full bg-gradient-to-l from-indigo-500/30 to-transparent"></div>
                            <span class="bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-sm font-black px-3 py-1 rounded-full">${courses.length}</span>
                        </div>
                    </div>`;

                // کارتی کۆرسەکان
                courses.forEach(c => {
                    const title = currentLang === 'ba' && c.title_ba ? c.title_ba : c.title_so || c.title; 
                    const desc = currentLang === 'ba' && c.desc_ba ? c.desc_ba : c.desc_so || c.description;
                    const btnText = currentLang === 'so' ? 'دەستپێکردن' : 'دەستپێکرن';
                    const freeText = currentLang === 'so' ? 'خۆڕایی' : 'بێ بەرامبەر';
                    const seeMoreText = currentLang === 'so' ? 'زیاتر ببینە' : 'زێدەتر ببینە';
                    const priceBadge = c.price && c.price != 0 ? `$${c.price}` : freeText;
                    
                    let langBadge = 'سۆرانی';
                    if(c.course_category === 'badini') langBadge = 'بادینی';
                    if(c.course_category === 'arabic') langBadge = 'عەرەبی';
                    if(c.course_category === 'english') langBadge = 'ئینگلیزی';

                    const safeTitle = (title || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                    const safeDesc = (desc || "").replace(/"/g, '&quot;').replace(/'/g, "\\'");
                    const safeTopic = (catName).replace(/"/g, '&quot;').replace(/'/g, "\\'");

                    let adminButtonsHtml = '';
                    if(window.isAdmin) {
                        adminButtonsHtml = `
                            <div class="flex items-center gap-2 pt-4 border-t border-gray-200 dark:border-gray-700/50 mt-4">
                                <button onclick="window.openEditModal('${c.fb_id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 hover:bg-amber-100 rounded-xl font-bold text-xs transition border border-amber-200 dark:border-amber-800/50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    ${currentLang === 'so' ? 'دەستکاری' : 'دەستکاری'}
                                </button>
                                <button onclick="window.deleteCourse('${c.fb_id}')" class="flex-1 flex justify-center items-center gap-2 py-2.5 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100 rounded-xl font-bold text-xs transition border border-red-200 dark:border-red-800/50">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    ${currentLang === 'so' ? 'سڕینەوە' : 'سڕینەوە'}
                                </button>
                            </div>
                        `;
                    }

                    allHtml += `
                        <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col group course-item transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl" data-lang="${c.course_category || 'sorani'}" data-topic="${c.topic || 'other'}">
                            <div class="relative h-56 overflow-hidden bg-gray-200 dark:bg-gray-800">
                                <img src="${c.image_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-black px-3 py-1.5 rounded-full shadow-md">${langBadge}</div>
                                <div class="absolute top-4 left-4 bg-white/90 dark:bg-[#0a0f1c]/90 text-gray-900 dark:text-white backdrop-blur-md px-3 py-1.5 rounded-full font-black text-xs shadow-lg border border-gray-200/50 dark:border-gray-700/50">${priceBadge}</div>
                                <button onclick="window.toggleCourseFav('${c.fb_id}', event)" class="absolute top-4 left-16 z-10 w-9 h-9 flex items-center justify-center rounded-full backdrop-blur-md transition-all duration-200 ${userFavorites && userFavorites[c.fb_id] ? 'bg-red-500 text-white shadow-lg shadow-red-500/30 scale-110' : 'bg-white/80 dark:bg-gray-800/80 text-gray-600 dark:text-gray-300 hover:text-red-500 hover:scale-110'}" title="${currentLang === 'so' ? 'دڵخواز' : 'دڵخواز'}">
                                    <svg class="w-[18px] h-[18px]" fill="${userFavorites && userFavorites[c.fb_id] ? 'currentColor' : 'none'}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 flex flex-col flex-grow relative bg-white/50 dark:bg-[#111827]/50">
                                <span class="text-xs font-black text-indigo-500 dark:text-indigo-400 mb-2 uppercase tracking-wider">${catName}</span>
                                <h3 class="font-black text-2xl mb-2 text-gray-900 dark:text-white line-clamp-1">${title}</h3>
                                
                                <div class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4 flex-grow">
                                    <p class="line-clamp-3">${desc}</p>
                                </div>
                                
                                <button onclick="window.openCourseModal('${safeTitle}', '${safeDesc}', '${langBadge}', '${safeTopic}')" class="text-blue-600 dark:text-blue-400 font-bold text-sm flex items-center gap-1 hover:text-blue-800 dark:hover:text-blue-300 transition w-max mb-6">
                                    <span>${seeMoreText}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                <div class="mt-auto">
                                    <a href="${c.video_url}" target="_blank" class="w-full block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-center py-3 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        ${btnText}
                                    </a>
                                </div>

                                ${adminButtonsHtml}
                            </div>
                        </div>
                    `;
                });
            });

            container.innerHTML = allHtml;
            
            // جارێکی تر فلتەرەکە جێبەجێ بکەوە بۆ ئەوەی هەر کۆرسێک نەگونجاو بێت بیشارێتەوە
            applyFilters();
        }

        onValue(dbRef(db, 'courses'), (snapshot) => {
            firebaseDataCache = snapshot.val() || {};
            renderCourses(firebaseDataCache);
        });

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
                            desc_so: document.getElementById('desc_so').value,
                            desc_ba: document.getElementById('desc_ba').value,
                            course_category: document.getElementById('course_category').value,
                            topic: document.getElementById('course_topic').value, // بابەتی نوێ (نموونە ژیری دەستکرد)
                            video_url: document.getElementById('video_url').value,
                            price: document.getElementById('price').value,
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
                currentUserId = user.uid;
                onValue(dbRef(db, 'favorites/' + user.uid + '/courses'), (snap) => {
                    userFavorites = snap.val() || {};
                    renderCourses(firebaseDataCache);
                });
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    window.isAdmin = true;
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
            }
        });
        
         document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>