<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زانکۆکانی AI - کورد ئەی ئای</title>
    
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    
    <meta name="description" content="زانکۆکانی کوردستان و باشووری کوردستان - کورد ئەی ئای">
    <meta name="keywords" content="زانکۆ, کوردستان, کورد ئەی ئای, خوێندن, زانکۆکانی کوردستان">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/universities">
    <meta property="og:title" content="زانکۆکان - KURD AI">
    <meta property="og:description" content="زاناکۆکانی کوردستان و باشووری کوردستان - کورد ئەی ئای">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/universities">
    <meta property="twitter:title" content="زانکۆکان - KURD AI">
    <meta property="twitter:description" content="زاناکۆکانی کوردستان و باشووری کوردستان - کورد ئەی ئای">
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
                <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">سەرەکی</a>
                <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">فێرگە</a>
                <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">کۆرسەکان</a>
                <a href="/news" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">هەواڵەکان</a>
                <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">تووڵەکان</a>
                <a href="/academic-guide" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">ڕێنیشاندەر</a>
                <a href="/universities" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition text-sm">زانکۆکان</a>
                <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition text-sm">دەربارەی ئێمە</a>
            </div>

            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">هەژمارەکەم</a>
                <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50">دەرچوون</button>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="relative min-h-[45vh] flex items-center justify-center overflow-hidden py-20 px-4">
        <div class="absolute inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-orange-400 dark:bg-orange-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-red-400 dark:bg-red-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-yellow-400 dark:bg-yellow-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 dark:bg-orange-900/30 border border-orange-200 dark:border-orange-700/50 text-orange-700 dark:text-orange-300 font-bold text-sm mb-6 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span>ڕێنمایی بۆ خوێندنی ئەکادیمی</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 tracking-tight text-gray-900 dark:text-white leading-tight">زانکۆکانی زیرەکی دەستکرد</h2>
            <p class="text-xl md:text-2xl text-gray-600 dark:text-gray-300 font-medium">بەدوای ئەو زانکۆیانەدا بگەڕێ کە بەشی ژیریی دەستکردیان هەیە لەگەڵ خشتەی وانەکانیان</p>
        </div>
    </header>

    <!-- University List Container -->
    <section class="relative z-10 container mx-auto pb-24 px-4">
        <div id="uni-container" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start max-w-7xl mx-auto"></div>
    </section>

    <!-- Modal بۆ پیشاندانی خشتەی وانەکانی زانکۆ -->
    <div id="planModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" onclick="window.closePlanModal()"></div>
        <div class="glass-card relative w-full max-w-4xl rounded-[2.5rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 max-h-[85vh] flex flex-col" id="planModalContent">
            <button onclick="window.closePlanModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mb-4 pr-2">
                <h3 id="planModalTitle" class="text-2xl md:text-3xl font-black text-gray-900 dark:text-white">خشتەی وانەکان</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">وردەکاری قۆناغ و سمستەرەکانی خوێندن</p>
            </div>
            <div id="planModalBody" class="custom-scrollbar overflow-y-auto pr-2 flex-grow space-y-6 my-2">
                <!-- داتای خشتەکە لێرە دەردەکەوێت -->
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200/50 dark:border-gray-700/50 text-left">
                <button onclick="window.closePlanModal()" class="px-6 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">داخستن</button>
            </div>
        </div>
    </div>

    <!-- Admin Section -->
    <section class="admin-only hidden relative z-10 container mx-auto pb-24 px-4" id="admin-form-section">
        <div class="glass-card p-8 md:p-12 rounded-[2.5rem] shadow-2xl max-w-5xl mx-auto border-t-4 border-orange-500 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500 opacity-5 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none"></div>

            <h3 class="text-3xl font-black mb-8 text-center text-gray-900 dark:text-white">دەستکاریکردنی زانکۆکان (ئەدمین)</h3>
            
            <div class="flex flex-wrap gap-3 mb-10 border-b border-gray-200 dark:border-gray-700 pb-6 relative z-10">
                <button id="tab-btn-uni" onclick="switchAdminTab('uni')" class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold shadow-md hover:shadow-lg transition-all">1. زانکۆ</button>
                <button id="tab-btn-subject" onclick="switchAdminTab('subject')" class="px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-bold border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">2. خشتەی وانەکان</button>
                <button id="tab-btn-manage" onclick="switchAdminTab('manage')" class="px-8 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl font-bold border border-red-200 dark:border-red-800/50 hover:bg-red-100 dark:hover:bg-red-900/40 transition-all">3. بەڕێوەبردن (سڕینەوە/دەستکاری)</button>
            </div>

            <!-- 1. Form Uni -->
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
                    <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2">لۆگۆی زانکۆ</label>
                    <div class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-6 bg-white/30 dark:bg-gray-900/30 hover:bg-white/50 dark:hover:bg-gray-900/50 transition-colors">
                        <input type="file" id="uni_logo_file" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="text-center pointer-events-none">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">کلیک بکە یان وێنەکە ڕابکێشە بۆ ئێرە</p>
                        </div>
                    </div>
                </div>
                <button type="submit" id="btn-submit-uni" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-2xl font-black text-lg hover:shadow-lg hover:shadow-orange-500/30 hover:-translate-y-1 transition-all">سەیڤکردنی زانکۆ</button>
            </form>

            <!-- 2. Form Subjects -->
            <form id="form-subject" class="admin-form hidden relative z-10">
                <div class="mb-8">
                    <label class="block font-bold mb-3 text-lg text-orange-600 dark:text-orange-400">یەکەمجار زانکۆکە هەڵبژێرە:</label>
                    <select id="subject_uni_select" required class="w-full p-4 rounded-2xl bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800/50 font-bold text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-orange-500 outline-none transition-all cursor-pointer">
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8 border border-gray-200 dark:border-gray-700 rounded-[2rem] bg-white/50 dark:bg-gray-800/30">
                    <div class="space-y-5">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white">قۆناغی یەکەم</h4>
                        <div><label id="sem1_label" class="block text-sm font-bold mb-2">سمستەری ١</label><input type="file" id="sem1_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                        <div><label id="sem2_label" class="block text-sm font-bold mb-2">سمستەری ٢</label><input type="file" id="sem2_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                    </div>
                    <div class="space-y-5">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white">قۆناغی دووەم</h4>
                        <div><label id="sem3_label" class="block text-sm font-bold mb-2">سمستەری ٣</label><input type="file" id="sem3_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                        <div><label id="sem4_label" class="block text-sm font-bold mb-2">سمستەری ٤</label><input type="file" id="sem4_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                    </div>
                    <div class="space-y-5">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white">قۆناغی سێیەم</h4>
                        <div><label id="sem5_label" class="block text-sm font-bold mb-2">سمستەری ٥</label><input type="file" id="sem5_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                        <div><label id="sem6_label" class="block text-sm font-bold mb-2">سمستەری ٦</label><input type="file" id="sem6_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                    </div>
                    <div class="space-y-5">
                        <h4 class="font-black text-xl text-gray-800 dark:text-white">قۆناغی چوارەم</h4>
                        <div><label id="sem7_label" class="block text-sm font-bold mb-2">سمستەری ٧</label><input type="file" id="sem7_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                        <div><label id="sem8_label" class="block text-sm font-bold mb-2">سمستەری ٨</label><input type="file" id="sem8_file" accept="image/*" class="w-full p-2.5 rounded-xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-sm"></div>
                    </div>
                </div>
                <button type="submit" id="btn-submit-subject" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 rounded-2xl font-black text-lg mt-8 shadow-lg">سەیڤکردنی خشتە بۆ ئەم زانکۆیە</button>
            </form>

            <!-- 3. Form Manage -->
            <div id="form-manage" class="admin-form hidden relative z-10">
                <div id="manage-list" class="space-y-4 max-h-[500px] overflow-y-auto custom-scrollbar pr-2"></div>
            </div>
        </div>
    </section>

    <!-- Modal Edit Uni -->
    <div id="editUniModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeEditUniModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 overflow-y-auto max-h-[90vh]" id="editUniModalContent">
            <button onclick="window.closeEditUniModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center">دەستکاری کردنی زانکۆ</h3>
                <form id="edit-uni-form" class="space-y-5">
                    <input type="hidden" id="edit-uni-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوی زانکۆ (سۆرانی)</label><input type="text" id="edit_uni_name_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm"></div>
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">ناوی زانکۆ (بادینی)</label><input type="text" id="edit_uni_name_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">جۆری بڕوانامە (سۆرانی)</label><input type="text" id="edit_uni_degree_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm"></div>
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">جۆری بڕوانامە (بادینی)</label><input type="text" id="edit_uni_degree_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتەیەک (سۆرانی)</label><textarea id="edit_uni_desc_so" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm resize-none"></textarea></div>
                        <div><label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">کورتەیەک (بادینی)</label><textarea id="edit_uni_desc_ba" required rows="3" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl text-sm resize-none"></textarea></div>
                    </div>
                    <button type="submit" id="edit-uni-submit-btn" class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3.5 rounded-xl font-black shadow-lg">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

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
        window.isAdmin = false;

        const loc = (obj, key) => currentLang === 'ba' && obj[key + '_ba'] ? obj[key + '_ba'] : obj[key + '_so'] || obj[key];

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
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

        window.openPlanModal = function(uniId) {
            const u = unisData[uniId];
            if (!u) return;

            const name = loc(u, 'name');
            document.getElementById('planModalTitle').innerText = (currentLang === 'so' ? 'خشتەی وانەکانی: ' : 'خشتەیا وانەیێن: ') + name;
            
            const langDict = {
                notExist: currentLang === 'so' ? 'بوونی نییە' : 'نە هەیە',
                stage1: currentLang === 'so' ? 'قۆناغی یەکەم' : 'قۆناغا ئێکێ',
                stage2: currentLang === 'so' ? 'قۆناغی دووەم' : 'قۆناغا دووێ',
                stage3: currentLang === 'so' ? 'قۆناغی سێیەم' : 'قۆناغا سێیێ',
                stage4: currentLang === 'so' ? 'قۆناغی چوارەم' : 'قۆناغا چارێ',
                semPrefix: currentLang === 'so' ? 'سمستەری' : 'سمستەرێ'
            };

            const renderStage = (img1, img2, stageName, sem1Num, sem2Num) => {
                if (!img1 && !img2) return `
                    <div class="border-b border-gray-200/50 dark:border-gray-700/50 pb-4">
                        <h5 class="font-bold text-gray-800 dark:text-gray-200 mb-1 text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-red-500"></span>${stageName}</h5>
                        <p class="text-gray-400 text-xs pr-4">${langDict.notExist}</p>
                    </div>`;
                
                return `
                    <div class="border-b border-gray-200/50 dark:border-gray-700/50 pb-6 last:border-0 last:pb-0">
                        <h5 class="font-black text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>${stageName}</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pr-3 border-r-2 border-orange-200 dark:border-orange-900/40">
                            ${img1 ? `
                            <div class="bg-white dark:bg-gray-900 rounded-xl p-3 border border-gray-100 dark:border-gray-800 shadow-sm">
                                <p class="mb-2 text-xs font-bold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 inline-block px-2.5 py-1 rounded">${langDict.semPrefix} ${sem1Num}</p>
                                <img src="${img1}" class="w-full h-auto rounded-lg object-contain max-h-[350px]">
                            </div>` : ''}
                            ${img2 ? `
                            <div class="bg-white dark:bg-gray-900 rounded-xl p-3 border border-gray-100 dark:border-gray-800 shadow-sm">
                                <p class="mb-2 text-xs font-bold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-900/30 inline-block px-2.5 py-1 rounded">${langDict.semPrefix} ${sem2Num}</p>
                                <img src="${img2}" class="w-full h-auto rounded-lg object-contain max-h-[350px]">
                            </div>` : ''}
                        </div>
                    </div>
                `;
            };

            const body = document.getElementById('planModalBody');
            body.innerHTML = `
                ${renderStage(u.sem1, u.sem2, langDict.stage1, '١', '٢')}
                ${renderStage(u.sem3, u.sem4, langDict.stage2, '٣', '٤')}
                ${renderStage(u.sem5, u.sem6, langDict.stage3, '٥', '٦')}
                ${renderStage(u.sem7, u.sem8, langDict.stage4, '٧', '٨')}
            `;

            const modal = document.getElementById('planModal');
            const content = document.getElementById('planModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
            }, 10);
        };

        window.closePlanModal = function() {
            const modal = document.getElementById('planModal');
            const content = document.getElementById('planModalContent');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        };

        function renderUniversities() {
            const container = document.getElementById('uni-container');
            if(!container) return;
            container.innerHTML = '';
            
            if (Object.keys(unisData).length === 0) {
                container.innerHTML = `<div class="col-span-1 md:col-span-2 text-center py-20 glass-card rounded-[2rem] border border-dashed border-gray-300 dark:border-gray-700"><p class="text-gray-500 font-bold text-xl">هیچ زانکۆیەک نەدۆزرایەوە</p></div>`;
                return;
            }

            const btnPlanText = currentLang === 'so' ? 'خشتەی وانەکان ببینە' : 'خشتەیا وانەیان ببینه';

            for (let id in unisData) {
                const u = unisData[id];
                const name = loc(u, 'name');
                const degree = loc(u, 'degree');
                const desc = loc(u, 'desc');
                
                container.innerHTML += `
                    <div class="glass-card rounded-[2.5rem] shadow-sm hover:shadow-xl transition-all duration-300 p-6 md:p-8 flex flex-col justify-between h-full relative overflow-hidden group">
                        <div>
                            <div class="flex items-start gap-5 mb-6 z-10">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-white dark:bg-gray-800 flex-shrink-0 flex items-center justify-center p-2 shadow border border-gray-100 dark:border-gray-700">
                                    <img src="${u.logo_url || 'https://i.ibb.co/placeholder.png'}" class="w-full h-full object-contain">
                                </div>
                                <div>
                                    <h3 class="font-black text-xl md:text-2xl text-gray-900 dark:text-white mb-1.5 leading-tight">${name}</h3>
                                    <span class="inline-block bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 font-bold px-2.5 py-0.5 rounded text-xs border border-orange-200 dark:border-orange-800/50">${degree}</span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed z-10 font-medium mb-6">${desc}</p>
                        </div>
                        
                        <div>
                            ${window.isAdmin ? `
                            <div class="flex items-center gap-2 mb-4 z-10">
                                <button onclick="window.openEditUniModal('${id}')" class="flex-1 py-2 bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400 rounded-xl font-bold text-xs transition border border-amber-200">دەستکاری</button>
                                <button onclick="window.deleteUni('${id}')" class="flex-1 py-2 bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 rounded-xl font-bold text-xs transition border border-red-200">سڕینەوە</button>
                            </div>` : ''}

                            <button onclick="window.openPlanModal('${id}')" class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>${btnPlanText}</span>
                            </button>
                        </div>
                    </div>
                `;
            }
        }

        const tabs = ['uni', 'subject', 'manage'];
        window.switchAdminTab = function(tabName) {
            tabs.forEach(x => {
                document.getElementById(`tab-btn-${x}`).className = "px-8 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl font-bold border border-gray-200 dark:border-gray-700 transition-all";
                if(x==='manage') document.getElementById(`tab-btn-${x}`).className = "px-8 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl font-bold border border-red-200 transition-all";
                document.getElementById(`form-${x}`)?.classList.add('hidden');
            });
            const activeBtn = document.getElementById(`tab-btn-${tabName}`);
            activeBtn.className = "px-8 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl font-bold shadow-md transition-all";
            document.getElementById(`form-${tabName}`)?.classList.remove('hidden');
        };

        function updateAdminSelects() {
            const select = document.getElementById('subject_uni_select');
            select.innerHTML = '<option value="">-- هەڵبژێرە --</option>';
            for (let id in unisData) select.innerHTML += `<option value="${id}">${unisData[id].name_so || '?'}</option>`;
        }

        async function uploadImage(file) {
            const formData = new FormData(); formData.append("image", file);
            const res = await fetch(`https://api.imgbb.com/1/upload?key=${IMGBB_API_KEY}`, { method: 'POST', body: formData });
            const data = await res.json();
            return data.data.url;
        }

        document.getElementById('form-uni').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-uni'); btn.disabled = true; btn.innerText = "جێبەجێ دەکرێت...";
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
                
                alert("بە سەرکەوتوویی جێبەجێکرا!"); e.target.reset();
                btn.disabled = false; btn.innerText = "سەیڤکردنی زانکۆ";
                switchAdminTab('manage');
            } catch (err) { alert("هەڵە ڕوویدا"); btn.disabled = false; btn.innerText = "سەیڤکردنی زانکۆ"; }
        });

        document.getElementById('form-subject').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('subject_uni_select').value;
            if(!id) return alert('تکایە سەرەتا زانکۆیەک هەڵبژێرە');
            const btn = document.getElementById('btn-submit-subject'); btn.disabled = true; btn.innerText = "خەریکە ئەپڵۆد دەکرێت...";
            try {
                const data = {};
                for(let i=1; i<=8; i++) {
                    const fileInput = document.getElementById(`sem${i}_file`);
                    if(fileInput.files.length > 0) data[`sem${i}`] = await uploadImage(fileInput.files[0]);
                }
                if (Object.keys(data).length > 0) {
                    await update(dbRef(db, 'universities/' + id), data);
                    alert("خشتەی وانەکان نوێکرایەوە!");
                }
                for(let i=1; i<=8; i++) { document.getElementById(`sem${i}_file`).value = ''; }
                btn.disabled = false; btn.innerText = "سەیڤکردنی خشتە بۆ ئەم زانکۆیە";
            } catch (err) { alert("هەڵە ڕوویدا"); btn.disabled = false; btn.innerText = "سەیڤکردنی خشتە بۆ ئەم زانکۆیە"; }
        });

        window.renderManageList = function() {
            const listObj = document.getElementById('manage-list');
            listObj.innerHTML = '';
            for(let id in unisData) {
                const item = unisData[id];
                listObj.innerHTML += `
                    <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <img src="${item.logo_url || ''}" class="w-10 h-10 rounded-lg object-contain bg-white p-1">
                            <span class="font-bold text-sm text-gray-800 dark:text-gray-200">${item.name_so}</span>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openEditUniModal('${id}')" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-bold">دەستکاری</button>
                            <button onclick="deleteUni('${id}')" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-lg text-xs font-bold">سڕینەوە</button>
                        </div>
                    </div>`;
            }
        };

        window.deleteUni = async function(id) {
            if(!confirm('دڵنیایت لە سڕینەوەی ئەم زانکۆیە؟')) return;
            await remove(dbRef(db, `universities/${id}`));
            alert('بە سەرکەوتوویی سڕایەوە');
        };

        window.openEditUniModal = function(uniId) {
            const d = unisData[uniId];
            if (!d) return;
            document.getElementById('edit-uni-id').value = uniId;
            document.getElementById('edit_uni_name_so').value = d.name_so || '';
            document.getElementById('edit_uni_name_ba').value = d.name_ba || '';
            document.getElementById('edit_uni_degree_so').value = d.degree_so || '';
            document.getElementById('edit_uni_degree_ba').value = d.degree_ba || '';
            document.getElementById('edit_uni_desc_so').value = d.desc_so || '';
            document.getElementById('edit_uni_desc_ba').value = d.desc_ba || '';
            document.getElementById('editUniModal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('editUniModalContent').classList.remove('translate-y-4', 'opacity-0');
            }, 10);
        };

        window.closeEditUniModal = function() {
            document.getElementById('editUniModal').classList.add('hidden');
        };

        document.getElementById('edit-uni-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const uniId = document.getElementById('edit-uni-id').value;
            const d = unisData[uniId];
            await set(dbRef(db, 'universities/' + uniId), {
                name_so: document.getElementById('edit_uni_name_so').value,
                name_ba: document.getElementById('edit_uni_name_ba').value,
                degree_so: document.getElementById('edit_uni_degree_so').value,
                degree_ba: document.getElementById('edit_uni_degree_ba').value,
                desc_so: document.getElementById('edit_uni_desc_so').value,
                desc_ba: document.getElementById('edit_uni_desc_ba').value,
                logo_url: d.logo_url || '',
                sem1: d.sem1 || '', sem2: d.sem2 || '', sem3: d.sem3 || '', sem4: d.sem4 || '',
                sem5: d.sem5 || '', sem6: d.sem6 || '', sem7: d.sem7 || '', sem8: d.sem8 || ''
            });
            window.closeEditUniModal();
            alert('بە سەرکەوتوویی پاشەکەوت کرا');
        });

        document.getElementById('theme-toggle').addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        onAuthStateChanged(auth, (user) => { 
            if(!user) window.location.href = "/login"; 
            else {
                document.body.style.display = 'block';
                if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                    window.isAdmin = true;
                    document.querySelector('.admin-only').classList.remove('hidden');
                    renderUniversities();
                }
            }
        });
        
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>