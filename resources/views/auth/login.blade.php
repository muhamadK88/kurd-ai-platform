<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>چوونەژوورەوە - کورد ئەی ئای</title>
<!-- Favicon (وێنە بچووکەکەی سەرەوەی تابەکە) -->
<link rel="icon" href="/favicon.png" type="image/png">

<!-- Meta Tags (بۆ سۆشیاڵ میدیا و گوگڵ) -->
<meta name="description" content="کورد ئەی ئای - یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی بە شێوازێکی مۆدێرن.">

<!-- تایبەت بە فەیسبووک، تێلیگرام و نامەکان (Open Graph) -->
<meta property="og:type" content="website">
<meta property="og:title" content="کورد ئەی ئای - Kurd AI">
<meta property="og:description" content="پەرە بە تواناکانت بدە لەگەڵ باشترین کۆرسەکانی ژیریی دەستکرد و پرۆگرامسازی.">
<meta property="og:image" content="/logo.jpg">
    <meta name="description" content="چوونەژوورەوە بۆ کورد ئەی ئای - پلاتفۆرمی فێربوون">
    <meta name="keywords" content="چوونەژوورەوە, login, کورد ئەی ئای">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/login">
    <meta property="og:title" content="چوونەژوورەوە - KURD AI">
    <meta property="og:description" content="چوونەژوورەوە بۆ کورد ئەی ئای - پلاتفۆرمی فێربوونی زیرەکی دەستکرد">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/login">
    <meta property="twitter:title" content="چوونەژوورەوە - KURD AI">
    <meta property="twitter:description" content="چوونەژوورەوە بۆ کورد ئەی ئای - پلاتفۆرمی فێربوونی زیرەکی دەستکرد">
    <meta property="twitter:image" content="https://kurd-ai.com/logo.jpg">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <style>
        body { font-family: 'Noto Sans Arabic', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.82);
            border: 1px solid rgba(55, 65, 81, 0.5);
        }
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .spinner {
            border: 2.5px solid rgba(255,255,255,.3);
            border-top-color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin .7s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -30px) scale(1.1); }
            66% { transform: translate(-15px, 20px) scale(0.95); }
        }
        .animate-blob { animation: blob 10s ease-in-out infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-up { animation: fadeUp .7s ease-out both; }
        .animation-delay-200 { animation-delay: 0.2s; }
        .animation-delay-400 { animation-delay: 0.4s; }
    </style>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    <!-- سەرەکی -->
    <main class="relative min-h-[calc(100vh-70px)] flex items-center justify-center py-14 px-4 overflow-hidden">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-400 dark:bg-indigo-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-400 dark:bg-purple-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:24px_24px]"></div>

        <div class="w-full max-w-md relative z-10 animate-fade-up">
            <div class="glass-card rounded-[2rem] p-8 md:p-10 shadow-2xl border-t-4 border-blue-600">

                <div class="flex flex-col items-center mb-8 animate-fade-up animation-delay-200">
                    <div class="relative">
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-full blur-2xl opacity-30"></div>
                        <img src="logo.jpg" alt="KURD AI" class="relative w-20 h-20 md:w-24 md:h-24 object-contain dark:invert rounded-2xl drop-shadow-lg">
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black mt-5 text-center"><span class="lang-str" data-so="بەخێربێیت بۆ" data-ba="بەخێرهاتی بۆ">بەخێربێیت بۆ</span> <span class="gradient-text">KURD AI</span></h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-2.5 font-bold text-sm text-center lang-str" data-so="بچۆ ژوورەوە یان هەژمارێکی نوێ دروستبکە" data-ba="بچۆ ناڤ هەژمارا خۆ یان هەژمارەکێ نوی چێکە">بچۆ ژوورەوە یان هەژمارێکی نوێ دروستبکە</p>
                </div>

                <div id="error-message" class="hidden bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-300 text-sm font-bold p-3.5 rounded-2xl mb-4 text-center border border-red-100 dark:border-red-800/50 leading-relaxed animate-fade-up"></div>
                <div id="success-message" class="hidden bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm font-bold p-4 rounded-2xl mb-4 text-center border border-green-200 dark:border-green-800/50 shadow-sm leading-relaxed animate-fade-up"></div>

                <!-- تبەکان -->
                <div class="grid grid-cols-2 gap-1.5 bg-gray-100 dark:bg-gray-800 rounded-2xl p-1.5 mb-6">
                    <button id="tab-login" type="button" class="lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow" data-so="چوونەژوورەوە" data-ba="چوونا ژوورێ">چوونەژوورەوە</button>
                    <button id="tab-register" type="button" class="lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200" data-so="دروستکردنی هەژمار" data-ba="چێکردنی هەژمارا نوی">دروستکردنی هەژمار</button>
                </div>

                <!-- پەڕەی چوونەژوورەوە -->
                <div id="panel-login" class="space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ئیمەیڵ" data-ba="ئیمێل">ئیمەیڵ</label>
                        <input type="email" id="login-email" placeholder="you@example.com" autocomplete="email" dir="ltr"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="پاسۆرد" data-ba="پاسۆرد">پاسۆرد</label>
                        <div class="relative">
                            <input type="password" id="login-password" placeholder="••••••••" autocomplete="current-password" dir="ltr"
                                class="w-full px-4 pl-12 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                            <button type="button" data-toggle-pw="login-password"
                                class="absolute left-1.5 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-blue-600 dark:hover:text-cyan-400 transition" title="پیشاندانی پاسۆرد">
                                <svg class="pw-eye w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="pw-eye-off hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243"/></svg>
                            </button>
                        </div>
                    </div>
                    <button id="login-send-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="چوونەژوورەوە" data-ba="چوونا ژوورێ">
                        چوونەژوورەوە
                    </button>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-600"></div></div>
                        <div class="relative flex justify-center text-sm"><span class="bg-white dark:bg-gray-800 px-3 text-gray-400 font-bold lang-str" data-so="یان" data-ba="یان">یان</span></div>
                    </div>

                    <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white py-4 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span class="lang-str" data-so="بەردەوامبوون لەگەڵ گووگڵ" data-ba="بەردەوام بە دگەل گووگڵ">بەردەوامبوون لەگەڵ گووگڵ</span>
                    </button>
                </div>

                <!-- پەڕەی دروستکردنی هەژمار -->
                <div id="panel-register" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ناو" data-ba="ناڤ">ناو</label>
                        <input type="text" id="register-name" placeholder="ناوی تۆ" autocomplete="name" dir="rtl"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-right">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ئیمەیڵ" data-ba="ئیمێل">ئیمەیڵ</label>
                        <input type="email" id="register-email" placeholder="you@example.com" autocomplete="email" dir="ltr"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="پاسۆرد" data-ba="پاسۆرد">پاسۆرد</label>
                        <div class="relative">
                            <input type="password" id="register-password" placeholder="••••••••" autocomplete="new-password" dir="ltr"
                                class="w-full px-4 pl-12 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                            <button type="button" data-toggle-pw="register-password"
                                class="absolute left-1.5 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-emerald-600 dark:hover:text-teal-400 transition" title="پیشاندانی پاسۆرد">
                                <svg class="pw-eye w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="pw-eye-off hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="دووپاتکردنەوەی پاسۆرد" data-ba="دووبارەکرنەڤا پاسۆردی">دووپاتکردنەوەی پاسۆرد</label>
                        <div class="relative">
                            <input type="password" id="register-password-confirm" placeholder="••••••••" autocomplete="new-password" dir="ltr"
                                class="w-full px-4 pl-12 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                            <button type="button" data-toggle-pw="register-password-confirm"
                                class="absolute left-1.5 top-1/2 -translate-y-1/2 p-2 text-gray-400 hover:text-emerald-600 dark:hover:text-teal-400 transition" title="پیشاندانی پاسۆرد">
                                <svg class="pw-eye w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="pw-eye-off hidden w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243"/></svg>
                            </button>
                        </div>
                    </div>
                    <button id="register-send-btn" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-4 rounded-2xl font-black text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="دروستکردنی هەژمار" data-ba="چێکردنی هەژمارا نوی">
                        دروستکردنی هەژمار
                    </button>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200 dark:border-gray-600"></div></div>
                        <div class="relative flex justify-center text-sm"><span class="bg-white dark:bg-gray-800 px-3 text-gray-400 font-bold lang-str" data-so="یان" data-ba="یان">یان</span></div>
                    </div>

                    <button id="google-register-btn" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white py-4 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span class="lang-str" data-so="هەژمار دروستبکە بە گووگڵ" data-ba="هەژمارەکێ چێکە ب گووگڵ">هەژمار دروستبکە بە گووگڵ</span>
                    </button>
                </div>

                <div class="mt-7 text-center">
                    <a href="/" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition lang-str" data-so="← گەڕانەوە بۆ سەرەتا" data-ba="← زڤڕین بۆ دەستپێکێ">← گەڕانەوە بۆ سەرەتا</a>
                </div>
            </div>
        </div>
    </main>

    <script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) themeToggle.addEventListener('click', () => {
            const html = document.documentElement;
            html.classList.toggle('dark');
            localStorage.setItem('color-theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        let currentLang = localStorage.getItem('site-lang') || 'so';
        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                const val = el.getAttribute(`data-${currentLang}`);
                if (val) el.innerText = val;
            });
        }
        const langToggle = document.getElementById('lang-toggle');
        if (langToggle) langToggle.addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });
        applyLanguage();

        document.querySelectorAll('[data-toggle-pw]').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.togglePw);
                if (!input) return;
                const show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                btn.querySelector('.pw-eye').classList.toggle('hidden', show);
                btn.querySelector('.pw-eye-off').classList.toggle('hidden', !show);
            });
        });
    </script>

    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="module">
        import { getAuth, setPersistence, browserLocalPersistence, GoogleAuthProvider, signInWithPopup, signInWithEmailAndPassword, createUserWithEmailAndPassword, updateProfile } from "/js/firebase10/firebase-auth.js";

        const KaiF = window.KaiFirebase || {};
        let auth = KaiF.auth ? KaiF.auth() : null;
        const onAuthStateChanged = KaiF.onAuthStateChanged || function () {};
        KaiF.whenReady(function (st) {
            auth = st.auth;
            if (st.auth) {
                try { st.auth.useDeviceLanguage(); } catch (e) {}
                setPersistence(st.auth, browserLocalPersistence).catch(() => {});
            }
        });

        function ensureAuth() {
            return new Promise((resolve) => {
                if (auth) return resolve(auth);
                KaiF.whenReady(function (st) { resolve(st.auth); });
            });
        }

        const errorMsg = document.getElementById('error-message');
        const successMsg = document.getElementById('success-message');

        function showError(text) {
            errorMsg.innerText = text;
            errorMsg.classList.remove('hidden');
            successMsg.classList.add('hidden');
        }

        function showSuccess(text) {
            successMsg.innerText = text;
            successMsg.classList.remove('hidden');
            errorMsg.classList.add('hidden');
        }

        function hideMessages() {
            errorMsg.classList.add('hidden');
            successMsg.classList.add('hidden');
        }

        function setLoading(btn, loading, loadingText) {
            if (loading) {
                btn.dataset.original = btn.innerHTML;
                btn.disabled = true;
                btn.classList.add('opacity-80', 'cursor-not-allowed');
                btn.innerHTML = `<span class="spinner"></span><span>${loadingText}</span>`;
            } else {
                if (btn.dataset.original) btn.innerHTML = btn.dataset.original;
                btn.disabled = false;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
            }
        }

        function firebaseErrorMessage(e) {
            const map = {
                'auth/popup-blocked': 'وێبگەڕەکەت پاپئاپەکە بەربەستکردووە. تکایە ڕێگەی بدە و دووبارە هەوڵ بدەرەوە.',
                'auth/popup-closed-by-user': null,
                'auth/account-exists-with-different-credential': 'ئەم ئیمێڵە پێشتر بە ڕێگایەکی تر تۆمارکراوە. تکایە لەگەڵ هەمان ئیمێڵ هەوڵ بدەرەوە.',
                'auth/unauthorized-domain': 'دۆمەینەکەت لە فایەربەیس ڕێگەپێدراو نییە (Firebase Console → Authentication → Authorized domains).',
            };
            if (map[e.code]) return map[e.code];
            return 'کێشەیەک ڕوویدا: ' + e.message;
        }

        function emailPasswordError(e) {
            const map = {
                'auth/invalid-credential': 'ئیمێڵ یان پاسۆرد هەڵەیە.',
                'auth/wrong-password': 'پاسۆردەکە هەڵەیە.',
                'auth/user-not-found': 'ئیمێڵەکە نەدۆزرایەوە.',
                'auth/user-disabled': 'ئەم هەژمارەیە ناچالاککراوە.',
                'auth/too-many-requests': 'زۆر هەوڵت داوە. دوای ماوەیەک دووبارە هەوڵ بدەرەوە.',
                'auth/network-request-failed': 'پەیوەندی بە ئینتەرنێتەوە نەما.',
                'auth/email-already-in-use': 'ئەم ئیمێڵە پێشتر تۆمارکراوە. بچۆ بەشی چوونەژوورەوە.',
                'auth/weak-password': 'پاسۆردەکە زۆر بەهێز نییە (بەلایەنی کەم 6 پیت).',
                'auth/invalid-email': 'ئیمێڵەکە دروست نییە.',
            };
            if (map[e.code]) return map[e.code];
            return 'کێشەیەک ڕوویدا: ' + e.message;
        }

        // ---------- تبەکان و پانێڵەکان ----------
        const panelIds = ['login', 'register'];

        function setPanel(name) {
            panelIds.forEach(p => {
                document.getElementById('panel-' + p).classList.toggle('hidden', p !== name);
            });
        }

        const tabs = {
            login: document.getElementById('tab-login'),
            register: document.getElementById('tab-register'),
        };

        function setTabActive(name) {
            const active = 'lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow';
            const inactive = 'lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200';
            Object.entries(tabs).forEach(([key, el]) => {
                el.className = key === name ? active : inactive;
            });
        }

        function chooseMethod(name) {
            hideMessages();
            setTabActive(name);
            setPanel(name);
        }

        Object.entries(tabs).forEach(([key, el]) => {
            el.addEventListener('click', () => chooseMethod(key));
        });

        // ---------- ناردن ----------
        let navigated = false;
        let submitting = false;
        function returnPath() {
            const value = new URLSearchParams(location.search).get('return') || '/';
            return value.startsWith('/') && !value.startsWith('//') && value !== '/login' ? value : '/';
        }
        function loginDone() {
            if (navigated) return;
            navigated = true;
            try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
            showSuccess('سەرکەوتوو بوو...');
            try {
                if (window.KaiTrack) {
                    const a = KaiF.auth ? KaiF.auth() : null;
                    const email = (a && a.currentUser && a.currentUser.email) || document.getElementById('login-email').value;
                    window.KaiTrack.login(email);
                }
            } catch (e) {}
            setTimeout(() => { location.replace(returnPath()); }, 350);
        }

        // already signed in? skip the form and go straight to the app
        onAuthStateChanged((user) => {
            if (user && !submitting && !navigated) {
                try { localStorage.setItem('kurdai-authenticated', '1'); } catch (e) {}
                location.replace(returnPath());
            }
        });

        async function sendEmailLogin() {
            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value;
            if (!email) {
                showError('تکایە ئیمێڵەکەت بنووسە.');
                return;
            }
            if (password.length < 6) {
                showError('تکایە پاسۆردەکەت بنووسە (بەلایەنی کەم 6 پیت).');
                return;
            }
            const btn = document.getElementById('login-send-btn');
            hideMessages();
            setLoading(btn, true, 'چوونەژوورەوە...');
            submitting = true;
            try {
                const a = await ensureAuth();
                if (!a) { showError('هێشتا پەیوەندی بە فایەربەیسەوە نەبەستراوەتەوە. تکایە چەند چرکەیەک چاوەڕێ بکە و دووبارە هەوڵ بدەرەوە.'); return; }
                await signInWithEmailAndPassword(a, email, password);
                loginDone();
            } catch (e) {
                if (e.code === 'auth/user-not-found') {
                    showError('ئەم ئیمێڵە نەتۆمارکراوە. تکایە بەشی دروستکردنی هەژمار بەکاربهێنە.');
                } else {
                    showError(emailPasswordError(e));
                }
            } finally {
                setLoading(btn, false);
            }
        }

        document.getElementById('login-send-btn').addEventListener('click', sendEmailLogin);
        document.getElementById('login-email').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailLogin();
        });
        document.getElementById('login-password').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailLogin();
        });

        // ---------- دروستکردنی هەژمار ----------
        async function sendEmailRegister() {
            const name = document.getElementById('register-name').value.trim();
            const email = document.getElementById('register-email').value.trim();
            const password = document.getElementById('register-password').value;
            const confirm = document.getElementById('register-password-confirm').value;
            if (!name) {
                showError('تکایە ناوەکەت بنووسە.');
                return;
            }
            if (!email) {
                showError('تکایە ئیمێڵەکەت بنووسە.');
                return;
            }
            if (password.length < 6) {
                showError('پاسۆرد دەبێت بەلایەنی کەم 6 پیت بێت.');
                return;
            }
            if (password !== confirm) {
                showError('دوو پاسۆردەکە یەکسان نین.');
                return;
            }
            const btn = document.getElementById('register-send-btn');
            hideMessages();
            setLoading(btn, true, 'دروستکردنی هەژمار...');
            submitting = true;
            try {
                const a = await ensureAuth();
                if (!a) { showError('هێشتا پەیوەندی بە فایەربەیسەوە نەبەستراوەتەوە. تکایە چەند چرکەیەک چاوەڕێ بکە و دووبارە هەوڵ بدەرەوە.'); return; }
                const userCredential = await createUserWithEmailAndPassword(a, email, password);
                if (name) {
                    await updateProfile(userCredential.user, { displayName: name });
                }
                loginDone();
            } catch (e) {
                showError(emailPasswordError(e));
            } finally {
                setLoading(btn, false);
            }
        }

        document.getElementById('register-send-btn').addEventListener('click', sendEmailRegister);
        document.getElementById('register-email').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailRegister();
        });
        document.getElementById('register-password').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailRegister();
        });
        document.getElementById('register-password-confirm').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailRegister();
        });

        // ---------- گووگڵ ----------
        const googleProvider = new GoogleAuthProvider();

        async function handleSocial(provider, method, btn) {
            hideMessages();
            setLoading(btn, true, 'تکایە چاوەڕێبە....');
            submitting = true;
            try {
                const a = await ensureAuth();
                if (!a) { showError('هێشتا پەیوەندی بە فایەربەیسەوە نەبەستراوەتەوە. تکایە چەند چرکەیەک چاوەڕێ بکە و دووبارە هەوڵ بدەرەوە.'); return; }
                await signInWithPopup(a, provider);
                loginDone();
            } catch (e) {
                const msg = firebaseErrorMessage(e);
                if (msg) showError(msg);
            } finally {
                setLoading(btn, false);
            }
        }

        document.getElementById('google-login-btn').addEventListener('click', () => {
            handleSocial(googleProvider, 'google', document.getElementById('google-login-btn'));
        });

        document.getElementById('google-register-btn').addEventListener('click', () => {
            handleSocial(googleProvider, 'google', document.getElementById('google-register-btn'));
        });

        setTabActive('login');
        setPanel('login');
    </script>
</body>
</html>
