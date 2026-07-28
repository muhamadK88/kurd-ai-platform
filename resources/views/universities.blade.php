<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زانکۆکانی AI - کورد ئەی ئای</title>

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

        details > summary { list-style: none; cursor: pointer; }
        details > summary::-webkit-details-marker { display: none; }
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

    <!-- بەشی هێدەر بە دیزاینی مۆدێرن (ڕەنگی پرتەقاڵی و سوور) -->
    <header class="relative min-h-[45vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <!-- باکگراوندی جوڵاو -->
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-orange-400 dark:bg-orange-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-red-400 dark:bg-red-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-yellow-400 dark:bg-yellow-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 dark:bg-orange-900/30 border border-orange-200 dark:border-orange-700/50 text-orange-700 dark:text-orange-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="lang-str" data-so="ڕێنمایی بۆ خوێندنی ئەکادیمی" data-ba="ڕێنمایی بۆ خواندنا ئەکادیمی">ڕێنمایی بۆ خوێندنی ئەکادیمی</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight lang-str" data-so="زانکۆکانی زیرەکی دەستکرد" data-ba="زانکۆیێن زیرەکیا دەستکرد">زانکۆکانی زیرەکی دەستکرد</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium lang-str" data-so="بەدوای ئەو زانکۆیانەدا بگەڕێ کە بەشی ژیریی دەستکردیان هەیە لەگەڵ خشتەی وانەکانیان" data-ba="ل وان زانکۆیان بگەڕە کو بەشێ ژیرییا دەستکرد هەیە دگەل خشتەیا وانەیێن وان">بەدوای ئەو زانکۆیانەدا بگەڕێ کە بەشی ژیریی دەستکردیان هەیە لەگەڵ خشتەی وانەکانیان</p>
        </div>
    </header>

    <!-- بەشی پیشاندانی زانکۆکان (گۆڕاوە بۆ CSS Columns بۆ چارەسەری کێشەی بۆشایی) -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="uni-container" class="columns-1 md:columns-2 gap-10 max-w-6xl mx-auto"></div>
    </section>

    <!-- بەشی ئەدمین -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4" id="admin-form-section">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-5xl mx-auto border-t-4 border-orange-500 relative overflow-hidden">
            <!-- دەیکۆرەیشنی ناو فۆڕم -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white lang-str" data-so="دەستکاریکردنی زانکۆکان (ئەدمین)" data-ba="دەستکاریکرنا زانکۆیان (ئەدمین)">دەستکاریکردنی زانکۆکان (ئەدمین)</h3>
            
            <div class="flex flex-wrap gap-3 mb-10 border-b border-gray-200 dark:border-gray-700 pb-6 relative z-10">
                <button id="tab-btn-uni" onclick="switchAdminTab('uni')" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all">1. زانکۆ</button>
                <button id="tab-btn-subject" onclick="switchAdminTab('subject')" class="px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-bold border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">2. خشتەی وانەکان</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-8 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl font-bold border border-red-200 dark:border-red-800/50 hover:bg-red-100 dark:hover:bg-red-900/40 transition-all">3. بەڕێوەبردن (سڕینەوە/دەستکاری)</button>
            </div>

            <!-- 1. فۆڕمی زانکۆ -->
            <form id="form-uni" class="admin-form relative z-10">
                <input type="hidden" id="edit_uni_id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوی زانکۆ (سۆرانی)</label>
                        <input type="text" id="uni_name_so" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">ناوی زانکۆ (بادینی)</label>
                        <input type="text" id="uni_name_ba" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">جۆری بڕوانامە (سۆرانی)</label>
                        <input type="text" id="uni_degree_so" placeholder="نموونە: بەکالۆریۆس" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">جۆری بڕوانامە (بادینی)</label>
                        <input type="text" id="uni_degree_ba" required class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتەیەک (سۆرانی)</label>
                        <textarea id="uni_desc_so" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">کورتەیەک (بادینی)</label>
                        <textarea id="uni_desc_ba" required rows="4" class="w-full px-5 py-4 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl focus:ring-2 focus:ring-orange-500 focus:outline-none transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="لۆگۆی زانکۆ (ئەپڵۆدکردن)" data-ba="لۆگۆیێ زانکۆیێ">لۆگۆی زانکۆ</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                        <input type="file" id="uni_logo_file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                            <p class="mt-1 text-xs text-orange-500">(ئەگەر لە کاتی دەستکاریکردن وێنە دانەنێیت، لۆگۆ کۆنەکە دەمێنێتەوە)</p>
                        </div>
                    </div>
                </div>

                <button type="submit" id="btn-submit-uni" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-1 transition-all">سەیڤکردنی زانکۆ</button>
            </form>

            <!-- 2. فۆڕمی وانەکان (خشتە بە وێنە) -->
            <form id="form-subject" class="admin-form hidden relative z-10">
                <div class="mb-8">
                    <label class="block font-bold mb-3 text-lg text-orange-600 dark:text-orange-400">یەکەمجار زانکۆکە هەڵبژێرە:</label>
                    <select id="subject_uni_select" required class="w-full p-4 rounded-2xl bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800/50 font-bold text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500 outline-none transition-all cursor-pointer">
                    </select>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/30 rounded-xl p-4 mb-8 flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-blue-800 dark:text-blue-300 font-medium">وێنەی خشتەی وانەکانی هەر سمستەرێک ئەپڵۆد بکە. ئەگەر قۆناغێک/سمستەرێک بوونی نییە، بە بەتاڵی جێی بهێڵە. ئەو سمستەرانەی پێشتر وێنەیان بۆ دانراوە بە <span class="text-green-600 dark:text-green-400 font-bold">سەوز</span> دیاری کراون.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8 border border-gray-200 dark:border-gray-700 rounded-[2rem] bg-white/50 dark:bg-gray-800/30">
                    <!-- قۆناغی 1 -->
                    <div class="space-y-5 border-b md:border-b-0 md:border-l dark:border-gray-700 pb-6 md:pb-0 md:pl-6">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 flex items-center justify-center text-sm">١</div>
                            قۆناغی یەکەم
                        </h4>
                        <div>
                            <label id="sem1_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ١</label>
                            <input type="file" id="sem1_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <div>
                            <label id="sem2_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٢</label>
                            <input type="file" id="sem2_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                    </div>

                    <!-- قۆناغی 2 -->
                    <div class="space-y-5 pb-6 md:pb-0">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 flex items-center justify-center text-sm">٢</div>
                            قۆناغی دووەم
                        </h4>
                        <div>
                            <label id="sem3_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٣</label>
                            <input type="file" id="sem3_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <div>
                            <label id="sem4_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٤</label>
                            <input type="file" id="sem4_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                    </div>

                    <!-- قۆناغی 3 -->
                    <div class="space-y-5 border-b md:border-b-0 border-t dark:border-gray-700 pt-6 md:border-l md:pl-6">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 flex items-center justify-center text-sm">٣</div>
                            قۆناغی سێیەم
                        </h4>
                        <div>
                            <label id="sem5_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٥</label>
                            <input type="file" id="sem5_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <div>
                            <label id="sem6_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٦</label>
                            <input type="file" id="sem6_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                    </div>

                    <!-- قۆناغی 4 -->
                    <div class="space-y-5 border-t dark:border-gray-700 pt-6">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 flex items-center justify-center text-sm">٤</div>
                            قۆناغی چوارەم
                        </h4>
                        <div>
                            <label id="sem7_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٧</label>
                            <input type="file" id="sem7_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <div>
                            <label id="sem8_label" class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">سمستەری ٨</label>
                            <input type="file" id="sem8_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                    </div>
                </div>
                
                <button type="submit" id="btn-submit-subject" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-1 transition-all mt-8">سەیڤکردنی خشتە بۆ ئەم زانکۆیە</button>
            </form>

            <!-- 3. بەڕێوەبردن (Manage) -->
            <div id="form-manage" class="admin-form hidden relative z-10">
                <div id="manage-list" class="space-y-4 max-h-[500px] overflow-y-auto custom-scrollbar pr-2 pb-2">
                    <!-- لیستەکان لێرە دەردەکەون -->
                </div>
            </div>
        </div>
    </section>

    <!-- Firebase & Logic -->
    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref as dbRef, push, set, update, remove, onValue } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);
        const IMGBB_API_KEY = "947299981b43abca761315a1cd24c02a";

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let unisData = {}; 

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
            renderUniversities();
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        onValue(dbRef(db, 'universities'), (s) => { 
            unisData = s.val() || {}; 
            applyLanguage(); 
            updateAdminSelects(); 
            renderManageList(); 
        });

        function renderUniversities() {
            const container = document.getElementById('uni-container');
            if(!container) return;
            container.innerHTML = '';
            
            if (Object.keys(unisData).length === 0) {
                container.innerHTML = `<div class="col-span-1 md:col-span-2 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700 break-inside-avoid w-full"><p class="text-gray-500 dark:text-gray-400 text-xl font-bold">هیچ زانکۆیەک نەدۆزرایەوە</p></div>`;
                return;
            }

            const langDict = {
                planTitle: currentLang === 'so' ? 'خشتەی وانەکان بکەرەوە' : 'خشتەیا وانەیان ڤەکە',
                notExist: currentLang === 'so' ? 'بوونی نییە' : 'نە هەیە',
                stage1: currentLang === 'so' ? 'قۆناغی یەکەم' : 'قۆناغا ئێکێ',
                stage2: currentLang === 'so' ? 'قۆناغی دووەم' : 'قۆناغا دووێ',
                stage3: currentLang === 'so' ? 'قۆناغی سێیەم' : 'قۆناغا سێیێ',
                stage4: currentLang === 'so' ? 'قۆناغی چوارەم' : 'قۆناغا چارێ',
                semPrefix: currentLang === 'so' ? 'سمستەری' : 'سمستەرێ'
            };

            for (let id in unisData) {
                const u = unisData[id];
                const name = loc(u, 'name');
                const degree = loc(u, 'degree');
                const desc = loc(u, 'desc');
                
                const renderStage = (img1, img2, stageName, sem1Num, sem2Num) => {
                    if (!img1 && !img2) return `<div class="border-b border-gray-200/50 dark:border-gray-700/50 pb-4"><h5 class="font-black text-gray-900 dark:text-white mb-2 flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>${stageName}</h5><p class="text-gray-400 dark:text-gray-500 font-medium text-sm pr-4">${langDict.notExist}</p></div>`;
                    
                    return `
                        <div class="border-b border-gray-200/50 dark:border-gray-700/50 pb-8 last:border-0 last:pb-0">
                            <h5 class="font-black text-xl text-gray-900 dark:text-white mb-6 flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span>${stageName}</h5>
                            <div class="grid grid-cols-1 gap-6 pr-4 border-r-2 border-orange-100 dark:border-orange-900/30">
                                ${img1 ? `
                                <div class="bg-white/50 dark:bg-gray-900/50 rounded-2xl p-3 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                                    <p class="mb-3 text-sm font-black text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 inline-block px-3 py-1 rounded-lg">${langDict.semPrefix} ${sem1Num}</p>
                                    <img src="${img1}" class="w-full h-auto rounded-xl object-contain max-h-96 cursor-pointer hover:opacity-90 transition-opacity">
                                </div>` : ''}
                                
                                ${img2 ? `
                                <div class="bg-white/50 dark:bg-gray-900/50 rounded-2xl p-3 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-shadow">
                                    <p class="mb-3 text-sm font-black text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/20 inline-block px-3 py-1 rounded-lg">${langDict.semPrefix} ${sem2Num}</p>
                                    <img src="${img2}" class="w-full h-auto rounded-xl object-contain max-h-96 cursor-pointer hover:opacity-90 transition-opacity">
                                </div>` : ''}
                            </div>
                        </div>
                    `;
                };

                const studyPlanHTML = `
                    <details class="group mt-8">
                        <summary class="flex justify-between items-center font-bold p-5 text-orange-700 dark:text-orange-400 bg-gradient-to-r from-orange-50 to-orange-100/50 dark:from-orange-900/20 dark:to-orange-900/10 rounded-2xl border border-orange-200/50 dark:border-orange-800/30 hover:border-orange-300 dark:hover:border-orange-700/50 transition-all shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>${langDict.planTitle}</span>
                            </div>
                            <span class="transition-transform duration-300 group-open:rotate-180 bg-white dark:bg-gray-800 rounded-full p-1 shadow-sm">
                                <svg fill="none" height="20" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        </summary>
                        <div class="p-6 mt-2 bg-gray-50/50 dark:bg-gray-800/30 rounded-2xl border border-gray-100 dark:border-gray-800 space-y-6">
                            ${renderStage(u.sem1, u.sem2, langDict.stage1, '١', '٢')}
                            ${renderStage(u.sem3, u.sem4, langDict.stage2, '٣', '٤')}
                            ${renderStage(u.sem5, u.sem6, langDict.stage3, '٥', '٦')}
                            ${renderStage(u.sem7, u.sem8, langDict.stage4, '٧', '٨')}
                        </div>
                    </details>
                `;

                // لێرە کڵاسەکانی break-inside-avoid, mb-10 و inline-block زۆر گرنگن بۆ کارکردنی Masonry 
                container.innerHTML += `
                    <div class="glass-card rounded-[2.5rem] shadow-sm hover:shadow-2xl hover:shadow-orange-500/10 transition-all duration-300 p-8 md:p-10 flex flex-col hover:-translate-y-2 relative overflow-hidden group break-inside-avoid mb-10 w-full inline-block">
                        <div class="absolute top-0 right-0 w-40 h-40 bg-orange-500 opacity-5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <div class="flex items-start gap-6 mb-8 z-10">
                            <div class="w-28 h-28 rounded-3xl overflow-hidden bg-white dark:bg-gray-800 flex-shrink-0 flex items-center justify-center p-3 shadow-lg border border-gray-100 dark:border-gray-700 group-hover:rotate-3 transition-transform duration-500">
                                <img src="${u.logo_url || 'https://i.ibb.co/placeholder.png'}" class="w-full h-full object-contain">
                            </div>
                            <div class="pt-2">
                                <h3 class="font-black text-2xl md:text-3xl text-gray-900 dark:text-white mb-2 leading-tight">${name}</h3>
                                <span class="inline-block bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 font-bold px-3 py-1 rounded-lg text-sm border border-orange-200 dark:border-orange-800/50">${degree}</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-[15px] leading-relaxed z-10 font-medium">${desc}</p>
                        
                        <div class="z-10 mt-auto pt-4">${studyPlanHTML}</div>
                    </div>`;
            }
        }

        // --- ئەدمین لۆژیک ---
        const tabs = ['uni', 'subject', 'manage'];
        window.switchAdminTab = function(tabName) {
            tabs.forEach(x => {
                document.getElementById(`tab-btn-${x}`).classList.remove('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white', 'shadow-md');
                document.getElementById(`tab-btn-${x}`).classList.add('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300');
                if(x === 'manage') {
                    document.getElementById(`tab-btn-${x}`).classList.remove('bg-gradient-to-r', 'from-orange-500', 'to-red-500');
                    document.getElementById(`tab-btn-${x}`).classList.add('bg-red-50', 'dark:bg-red-900/20', 'text-red-600', 'dark:text-red-400');
                }
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            const activeBtn = document.getElementById(`tab-btn-${tabName}`);
            activeBtn.classList.remove('bg-white', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300', 'bg-red-50', 'dark:bg-red-900/20', 'text-red-600', 'dark:text-red-400');
            activeBtn.classList.add('bg-gradient-to-r', 'from-orange-500', 'to-red-500', 'text-white', 'shadow-md');
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
            
            if(tabName === 'uni') {
                document.getElementById(`form-uni`).reset();
                document.getElementById(`edit_uni_id`).value = '';
                document.getElementById(`btn-submit-uni`).innerText = 'سەیڤکردنی زانکۆ';
            }
        };

        function updateAdminSelects() {
            const select = document.getElementById('subject_uni_select');
            select.innerHTML = '<option value="">-- هەڵبژێرە --</option>';
            for (let id in unisData) select.innerHTML += `<option value="${id}">${unisData[id].name_so || '?'}</option>`;
        }

        document.getElementById('subject_uni_select').addEventListener('change', (e) => {
            const id = e.target.value;
            for(let i=1; i<=8; i++) {
                const label = document.getElementById(`sem${i}_label`);
                if (id && unisData[id] && unisData[id][`sem${i}`]) {
                    label.innerHTML = `سمستەری ${i} <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-2 py-0.5 rounded text-xs mr-2 font-black inline-flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> وێنە دانراوە</span>`;
                } else {
                    label.innerHTML = `سمستەری ${i}`;
                }
            }
        });

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            const data = await res.json();
            return data.data.url;
        }

        document.getElementById('form-uni').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-uni'); 
            btn.disabled = true; 
            btn.innerText = "خەریکە جێبەجێ دەکرێت...";
            btn.classList.add('opacity-70', 'cursor-wait');
            
            const editId = document.getElementById('edit_uni_id').value;
            
            try {
                let logoUrl = editId && unisData[editId] ? unisData[editId].logo_url : '';
                const file = document.getElementById('uni_logo_file').files[0];
                if(file) logoUrl = await uploadImage(file);

                const data = {
                    name_so: document.getElementById('uni_name_so').value, name_ba: document.getElementById('uni_name_ba').value,
                    degree_so: document.getElementById('uni_degree_so').value, degree_ba: document.getElementById('uni_degree_ba').value,
                    desc_so: document.getElementById('uni_desc_so').value, desc_ba: document.getElementById('uni_desc_ba').value,
                    logo_url: logoUrl
                };

                if(editId) await update(dbRef(db, 'universities/' + editId), data);
                else await set(push(dbRef(db, 'universities')), data);
                
                alert("بە سەرکەوتوویی جێبەجێکرا!"); 
                e.target.reset(); 
                document.getElementById('edit_uni_id').value = ''; 
                btn.innerText = "سەیڤکردنی زانکۆ";
                btn.classList.remove('opacity-70', 'cursor-wait');
                btn.disabled = false;
                switchAdminTab('manage');
            } catch (err) { 
                alert("هەڵە ڕوویدا لە ئەپڵۆدکردندا"); 
                btn.disabled = false; 
                btn.innerText = "سەیڤکردنی زانکۆ"; 
                btn.classList.remove('opacity-70', 'cursor-wait');
            }
        });

        document.getElementById('form-subject').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('subject_uni_select').value;
            if(!id) return alert('تکایە سەرەتا زانکۆیەک هەڵبژێرە');
            
            const btn = document.getElementById('btn-submit-subject'); 
            btn.disabled = true; 
            btn.innerText = "خەریکە ئەپڵۆد دەکرێت... (کەمێک چاوەڕێ بکە)";
            btn.classList.add('opacity-70', 'cursor-wait');
            
            try {
                const data = {};
                for(let i=1; i<=8; i++) {
                    const fileInput = document.getElementById(`sem${i}_file`);
                    if(fileInput.files.length > 0) {
                        const imgUrl = await uploadImage(fileInput.files[0]);
                        data[`sem${i}`] = imgUrl;
                    }
                }
                
                if (Object.keys(data).length > 0) {
                    await update(dbRef(db, 'universities/' + id), data);
                    alert("خشتەی وانەکان بۆ ئەم زانکۆیە نوێکرایەوە!");
                } else {
                    alert("هیچ وێنەیەکی نوێ هەڵنەبژێردراوە.");
                }
                
                for(let i=1; i<=8; i++) { document.getElementById(`sem${i}_file`).value = ''; }
                document.getElementById('subject_uni_select').dispatchEvent(new Event('change'));

                btn.disabled = false; 
                btn.innerText = "سەیڤکردنی خشتە بۆ ئەم زانکۆیە";
                btn.classList.remove('opacity-70', 'cursor-wait');
            } catch (err) { 
                alert("هەڵە ڕوویدا لە ئەپڵۆدکردندا"); 
                btn.disabled = false; 
                btn.innerText = "سەیڤکردنی خشتە بۆ ئەم زانکۆیە"; 
                btn.classList.remove('opacity-70', 'cursor-wait');
            }
        });

        window.renderManageList = function() {
            const listObj = document.getElementById('manage-list');
            listObj.innerHTML = '';
            for(let id in unisData) {
                const item = unisData[id];
                listObj.innerHTML += `
                    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-5 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-4">
                            <img src="${item.logo_url || 'https://i.ibb.co/placeholder.png'}" class="w-12 h-12 rounded-xl object-contain border border-gray-100 dark:border-gray-700 bg-white p-1">
                            <div>
                                <span class="block font-black text-gray-800 dark:text-gray-200">${item.name_so || item.name_ba}</span>
                                <span class="text-xs font-bold text-gray-400">${item.degree_so || ''}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="editUni('${id}')" class="bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 px-4 py-2 rounded-xl text-sm hover:bg-blue-100 dark:hover:bg-blue-900/50 font-bold transition-colors">دەستکاری</button>
                            <button onclick="deleteUni('${id}')" class="bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 px-4 py-2 rounded-xl text-sm hover:bg-red-100 dark:hover:bg-red-900/50 font-bold transition-colors">سڕینەوە</button>
                        </div>
                    </div>`;
            }
        };

        window.deleteUni = async function(id) {
            if(!confirm('دڵنیایت لە سڕینەوەی ئەم زانکۆیە؟ داتاکانی خشتەی وانەکانیش دەسڕێنەوە!')) return;
            await remove(dbRef(db, `universities/${id}`));
            alert('بە سەرکەوتوویی سڕایەوە');
        };

        window.editUni = function(id) {
            const d = unisData[id];
            document.getElementById('edit_uni_id').value = id;
            document.getElementById('uni_name_so').value = d.name_so || ''; document.getElementById('uni_name_ba').value = d.name_ba || '';
            document.getElementById('uni_degree_so').value = d.degree_so || ''; document.getElementById('uni_degree_ba').value = d.degree_ba || '';
            document.getElementById('uni_desc_so').value = d.desc_so || ''; document.getElementById('uni_desc_ba').value = d.desc_ba || '';
            document.getElementById('btn-submit-uni').innerText = "نوێکردنەوەی زانکۆ";
            switchAdminTab('uni');
        };

        onAuthStateChanged(auth, (user) => { 
            if(!user) window.location.href = "/login"; 
            else {
                document.body.style.display = 'block';
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    document.querySelector('.admin-only').classList.remove('hidden');
                }
            }
        });
        
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>