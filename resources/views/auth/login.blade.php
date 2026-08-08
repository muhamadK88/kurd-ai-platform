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
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
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
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
        .otp-box {
            width: 2.9rem;
            height: 3.4rem;
            text-align: center;
            font-size: 1.35rem;
            font-weight: 900;
            color: #111827;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            border-radius: 0.9rem;
            outline: none;
            transition: all .15s ease;
        }
        .dark .otp-box {
            color: #ffffff;
            background: rgba(55, 65, 81, 0.6);
            border-color: #4b5563;
        }
        .otp-box:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        .otp-box.filled {
            border-color: #3b82f6;
            background: #eff6ff;
        }
        .dark .otp-box.filled {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.15);
        }
    </style>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

    <!-- ناڤباری سەرەکی (لۆگۆی فەڕمی) -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 transition group">
                <div class="relative flex-shrink-0">
                    <div class="absolute -inset-2 bg-gradient-to-r from-blue-600 to-cyan-400 rounded-full blur-xl opacity-0 group-hover:opacity-30 transition-all duration-300"></div>
                    <img src="logo.jpg" alt="Kurd AI Logo" class="h-10 md:h-11 w-auto object-contain dark:invert drop-shadow-md group-hover:scale-105 transition-transform duration-300 relative z-10">
                </div>
                <div class="flex flex-col justify-center hidden sm:flex">
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none group-hover:text-blue-600 transition-colors duration-300">KURD AI</h1>
                    <span class="text-[0.55rem] md:text-[0.60rem] font-black tracking-widest bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500 mt-0.5">INNOVATION - FUTURE</span>
                </div>
            </a>
            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-xs border border-blue-100 dark:border-blue-800/50 hover:bg-blue-100 transition"><span id="lang-text">Badini</span></button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition border border-gray-200/50 dark:border-gray-700/50" title="گۆڕینی مۆد">🌙</button>
            </div>
        </div>
    </nav>

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
                    <button id="tab-email" type="button" class="flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow lang-str" data-so="✉️ ئیمێڵ" data-ba="✉️ ئیمێل">✉️ ئیمێڵ</button>
                    <button id="tab-phone" type="button" class="flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lang-str" data-so="📱 ژمارەی موبایل" data-ba="📱 ژمارا موبایل">📱 ژمارەی موبایل</button>
                    <button id="tab-google" type="button" class="flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lang-str" data-so="گووگڵ" data-ba="گووگڵ">
                        <svg viewBox="0 0 48 48" width="16" height="16" class="flex-shrink-0">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span>گووگڵ</span>
                    </button>
                    <button id="tab-facebook" type="button" class="flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lang-str" data-so="فەیسبوک" data-ba="فەیسبوک">
                        <svg viewBox="0 0 48 48" width="16" height="16" class="flex-shrink-0">
                            <path fill="#1877F2" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/>
                        </svg>
                        <span>فەیسبوک</span>
                    </button>
                </div>

                <!-- پەڕەی ئیمێڵ -->
                <div id="panel-email" class="space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ئیمەیڵ" data-ba="ئیمێل">ئیمەیڵ</label>
                        <input type="email" id="email" placeholder="you@example.com" autocomplete="email" dir="ltr"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="پاسۆرد" data-ba="پاسۆرد">پاسۆرد</label>
                        <input type="password" id="password" placeholder="••••••••" autocomplete="current-password" dir="ltr"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left">
                    </div>
                    <button id="email-send-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="چوونەژوورەوە" data-ba="چوونا ژوورێ">
                        چوونەژوورەوە
                    </button>
                    <button id="email-recovery-btn" type="button" class="hidden w-full text-center text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition py-2 lang-str" data-so="پاسۆردەکەت لەبیرە؟ کۆدی پشتڕاستکردنەوە بۆ ئیمێڵەکەت بنێرە" data-ba="پاسۆرد ژه‌ بیرە؟ کۆدێ پشتڕاستکرنێ بۆ ئیمێلا تە بشێنە">پاسۆردەکەت لەبیرە؟ کۆدی پشتڕاستکردنەوە بۆ ئیمێڵەکەت بنێرە</button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="ئەگەر هەژمارت هەیە، بە ئیمێڵ و پاسۆرد چوونەژوورەوە بکە. ئەگەر نا، هەژمارەکە دروستدەکرێت و تەنها یەک جار کۆدی پشتڕاستکردنەوە بۆ ئیمێڵەکەت دەنێردرێت." data-ba="ئەگەر هەژمارا تە هەیە، ب ئیمێل و پاسۆرد چوونا ژوورێ بکە. ئەگەر نا، هەژمار چێدبیت و تنێ جارەکێ کۆدێ پشتڕاستکرنێ بۆ ئیمێلا تە دێتە شاندن.">ئەگەر هەژمارت هەیە، بە ئیمێڵ و پاسۆرد چوونەژوورەوە بکە. ئەگەر نا، هەژمارەکە دروستدەکرێت و تەنها یەک جار کۆدی پشتڕاستکردنەوە بۆ ئیمێڵەکەت دەنێردرێت.</p>
                </div>

                <!-- پەڕەی مۆبایل (وەتسئەپ) -->
                <div id="panel-phone" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ژمارەی مۆبایل" data-ba="ژمارا موبایلی">ژمارەی مۆبایل</label>
                        <div class="flex rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/60 focus-within:ring-2 focus-within:ring-emerald-500 transition">
                            <span class="flex items-center gap-1.5 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-black text-sm whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                🇮🇶 <span dir="ltr">+964</span>
                            </span>
                            <input type="tel" id="phone" placeholder="7xx xxx xxxx" inputmode="tel" autocomplete="tel" dir="ltr"
                                class="flex-1 px-4 py-3.5 bg-transparent outline-none text-left">
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-bold mt-1.5 text-left lang-str" data-so="تەنها بەشی ژمارەکە بنووسە — +964 خۆکارانە زیاد دەکرێت." data-ba="تنێ پشکا ژمارێ بنڤیسە — +964 ئۆتۆماتیک زێدە دبیت.">تەنها بەشی ژمارەکە بنووسە — +964 خۆکارانە زیاد دەکرێت.</p>
                    </div>
                    <button id="phone-send-btn" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-4 rounded-2xl font-black text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="ناردنی کۆد بۆ وەتسئەپ" data-ba="شاندنا کۆدێ بۆ وەتسئەپ">
                        ناردنی کۆد بۆ وەتسئەپ
                    </button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="کۆدەکە لە ڕێگەی وەتسئەپەوە دەنێردرێت بۆ ژمارەکەت. دڵنیابە وەتسئەپی لەسەر چالاک بێت." data-ba="کۆد ب ڕێکا وەتسئەپێ دێتە شاندن بۆ ژمارا تە. دڵنیا بە وەتسئەپ ل سر تە چالاک بیت.">کۆدەکە لە ڕێگەی وەتسئەپەوە دەنێردرێت بۆ ژمارەکەت. دڵنیابە وەتسئەپی لەسەر چالاک بێت.</p>
                </div>

                <!-- پەڕەی گووگڵ -->
                <div id="panel-google" class="hidden space-y-5">
                    <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white py-4 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        <span class="lang-str" data-so="بەردەوامبوون لەگەڵ گووگڵ" data-ba="بەردەوامبوون دگەل گووگڵ">بەردەوامبوون لەگەڵ گووگڵ</span>
                    </button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="ئەگەر یەکەم جارە، کۆدێک بۆ Gmailـەکەت دەنێردرێت بۆ پشتڕاستکردنەوە. دوای ئەوە ڕاستەوخۆ چوونەژوورەوە دەبیت." data-ba="ئەگەر جارا ئێکی، کۆدەک بۆ Gmailـا تە دێتە شاندن بۆ پشتڕاستکرنێ. پشتی وێ ڕاستەوخۆ دێیتە ژوورێ.">ئەگەر یەکەم جارە، کۆدێک بۆ Gmailـەکەت دەنێردرێت بۆ پشتڕاستکردنەوە. دوای ئەوە ڕاستەوخۆ چوونەژوورەوە دەبیت.</p>
                </div>

                <!-- پەڕەی فەیسبوک -->
                <div id="panel-facebook" class="hidden space-y-5">
                    <button id="facebook-login-btn" class="w-full flex items-center justify-center gap-3 bg-[#1877F2] text-white py-4 rounded-2xl font-bold hover:bg-[#166FE5] hover:shadow-lg hover:shadow-[#1877F2]/30 hover:-translate-y-0.5 transition-all group">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                            <path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/>
                        </svg>
                        <span class="lang-str" data-so="بەردەوامبوون لەگەڵ فەیسبوک" data-ba="بەردەوامبوون دگەل فەیسبوک">بەردەوامبوون لەگەڵ فەیسبوک</span>
                    </button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="ئەگەر یەکەم جارە، کۆدێک بۆ ئیمێڵەکەت دەنێردرێت بۆ پشتڕاستکردنەوە. دوای ئەوە ڕاستەوخۆ چوونەژوورەوە دەبیت." data-ba="ئەگەر جارا ئێکی، کۆدەک بۆ ئیمێلا تە دێتە شاندن بۆ پشتڕاستکرنێ. پشتی وێ ڕاستەوخۆ دێیتە ژوورێ.">ئەگەر یەکەم جارە، کۆدێک بۆ ئیمێڵەکەت دەنێردرێت بۆ پشتڕاستکردنەوە. دوای ئەوە ڕاستەوخۆ چوونەژوورەوە دەبیت.</p>
                </div>

                <!-- پەڕەی کۆد -->
                <div id="panel-otp" class="hidden space-y-5">
                    <div class="flex flex-col items-center text-center mb-1">
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-600 to-cyan-400 flex items-center justify-center text-2xl shadow-lg shadow-blue-500/30 mb-3">🔐</div>
                        <h3 class="text-lg font-black lang-str" data-so="کۆدی پشتڕاستکردنەوە" data-ba="کۆدێ پشتڕاستکرنێ">کۆدی پشتڕاستکردنەوە</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 font-bold mt-1.5 leading-relaxed" id="otp-destination"></p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-bold mt-1 lang-str" data-so="کۆدەکە بۆ 10 خولەک چالاکە." data-ba="کۆد بۆ 10 دەقە چالاکە.">کۆدەکە بۆ 10 خولەک چالاکە.</p>
                    </div>

                    <div dir="ltr" class="flex justify-center gap-2" id="otp-boxes"></div>

                    <button id="otp-verify-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3.5 rounded-2xl font-black hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="پشتڕاستکردنەوە و چوونەژوورەوە" data-ba="پشتڕاستکرن و چوونا ژوورێ">
                        پشتڕاستکردنەوە و چوونەژوورەوە
                    </button>

                    <div class="flex items-center justify-between gap-2 pt-1">
                        <button id="otp-resend-btn" type="button" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 transition py-1 lang-str" data-so="دووبارە ناردنەوە" data-ba="دوبارە شاندن">دووبارە ناردنەوە <span id="otp-countdown" dir="ltr">(60)</span></button>
                        <button id="otp-change-btn" type="button" class="text-sm font-bold text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition py-1 lang-str" data-so="گۆڕینی ئیمێڵ/ژمارە" data-ba="گۆڕینا ئیمێل/ژمارێ">گۆڕینی ئیمێڵ/ژمارە</button>
                    </div>
                </div>

                <div class="mt-7 text-center">
                    <a href="/" class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition lang-str" data-so="← گەڕانەوە بۆ سەرەتا" data-ba="← زڤڕین بۆ دەستپێکێ">← گەڕانەوە بۆ سەرەتا</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Noto Sans Arabic"', 'sans-serif'] } } } }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
        document.getElementById('theme-toggle').addEventListener('click', () => {
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
        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });
        applyLanguage();
    </script>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, setPersistence, browserLocalPersistence, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup, signInWithCustomToken, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs",
            authDomain: "ai-platform-adb1b.firebaseapp.com",
            databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com",
            projectId: "ai-platform-adb1b",
            storageBucket: "ai-platform-adb1b.firebasestorage.app",
            messagingSenderId: "798560436587",
            appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        auth.useDeviceLanguage();
        setPersistence(auth, browserLocalPersistence).catch(() => {});

        const csrf = document.querySelector('meta[name="csrf-token"]').content;

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

        async function api(path, body) {
            const res = await fetch(path, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
            });
            let data = {};
            try { data = await res.json(); } catch (_) {}
            if (!res.ok) {
                if (data && data.errors) {
                    const first = Object.values(data.errors)[0];
                    throw new Error(Array.isArray(first) ? first[0] : first);
                }
                throw new Error((data && data.message) || 'کێشەیەک ڕوویدا. تکایە دووبارە هەوڵ بدەرەوە.');
            }
            return data;
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
            };
            if (map[e.code]) return map[e.code];
            return 'چوونەژوورەوە سەرنەکەوت: ' + e.message;
        }

        // ---------- تبەکان و پانێڵەکان ----------
        const panelIds = ['email', 'phone', 'google', 'facebook', 'otp'];

        function setPanel(name) {
            panelIds.forEach(p => {
                document.getElementById('panel-' + p).classList.toggle('hidden', p !== name);
            });
        }

        const tabs = {
            email: document.getElementById('tab-email'),
            phone: document.getElementById('tab-phone'),
            google: document.getElementById('tab-google'),
            facebook: document.getElementById('tab-facebook'),
        };

        function setTabActive(name) {
            const active = 'lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow';
            const inactive = 'lang-str flex items-center justify-center gap-1.5 py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200';
            Object.entries(tabs).forEach(([key, el]) => {
                el.className = key === name ? active : inactive;
            });
        }

        let pendingAuth = null;

        function chooseMethod(name) {
            pendingAuth = null;
            hideMessages();
            setTabActive(name);
            setPanel(name);
            const recovery = document.getElementById('email-recovery-btn');
            if (recovery) recovery.classList.add('hidden');
        }

        Object.entries(tabs).forEach(([key, el]) => {
            el.addEventListener('click', () => chooseMethod(key));
        });

        // ---------- بۆکسەکانی کۆد ----------
        const otpBoxesWrap = document.getElementById('otp-boxes');
        const otpBoxes = [];

        function buildOtpBoxes() {
            for (let i = 0; i < 6; i++) {
                const input = document.createElement('input');
                input.type = 'text';
                input.inputMode = 'numeric';
                input.maxLength = 1;
                input.autocomplete = 'off';
                input.classList.add('otp-box');
                input.setAttribute('aria-label', 'کۆد ' + (i + 1));
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^0-9]/g, '').slice(0, 1);
                    input.classList.toggle('filled', !!input.value);
                    if (input.value && i < 5) otpBoxes[i + 1].focus();
                    if (otpBoxes.every(b => b.value)) verifyOtp();
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !input.value && i > 0) {
                        otpBoxes[i - 1].focus();
                        otpBoxes[i - 1].value = '';
                        otpBoxes[i - 1].classList.remove('filled');
                    }
                });
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const text = (e.clipboardData.getData('text') || '').replace(/[^0-9]/g, '').slice(0, 6);
                    [...text].forEach((ch, j) => {
                        if (otpBoxes[j]) {
                            otpBoxes[j].value = ch;
                            otpBoxes[j].classList.toggle('filled', !!ch);
                        }
                    });
                    const next = Math.min(text.length, 5);
                    otpBoxes[next].focus();
                    if (text.length === 6) verifyOtp();
                });
                otpBoxes.push(input);
                otpBoxesWrap.appendChild(input);
            }
        }

        function resetOtpBoxes() {
            otpBoxes.forEach(b => {
                b.value = '';
                b.classList.remove('filled');
            });
            otpBoxes[0].focus();
        }

        function collectOtp() {
            return otpBoxes.map(b => b.value).join('');
        }

        // ---------- OTP step ----------
        const otpDestination = document.getElementById('otp-destination');
        const otpVerifyBtn = document.getElementById('otp-verify-btn');
        const otpResendBtn = document.getElementById('otp-resend-btn');
        const otpCountdown = document.getElementById('otp-countdown');
        const otpChangeBtn = document.getElementById('otp-change-btn');

        function destinationText(method, masked) {
            if (method === 'google') return 'کۆدەکە بۆ Gmailـی ' + masked + ' نێردرا.';
            if (method === 'facebook') return 'کۆدەکە بۆ ئیمێڵەکەت نێردرا (' + masked + ').';
            if (method === 'phone') return 'کۆدەکە بۆ وەتسئەپی ' + masked + ' نێردرا.';
            return 'کۆدەکە بۆ ئیمێڵەکەت نێردرا (' + masked + ').';
        }

        function openOtpStep(method, identifier, masked, kind, idToken, password) {
            pendingAuth = { method, identifier, kind: kind || 'direct', idToken: idToken || null, password: password || null };
            setPanel('otp');
            otpDestination.innerText = destinationText(method, masked);
            resetOtpBoxes();
            startResendTimer();
            hideMessages();
        }

        otpChangeBtn.addEventListener('click', () => {
            if (pendingAuth) chooseMethod(pendingAuth.method);
        });

        let resendTimer = null;

        function startResendTimer() {
            let seconds = 60;
            otpResendBtn.disabled = true;
            otpResendBtn.classList.add('opacity-50', 'cursor-not-allowed');
            otpCountdown.innerText = '(60)';
            clearInterval(resendTimer);
            resendTimer = setInterval(() => {
                seconds--;
                otpCountdown.innerText = '(' + seconds + ')';
                if (seconds <= 0) {
                    clearInterval(resendTimer);
                    otpResendBtn.disabled = false;
                    otpResendBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    otpCountdown.innerText = '';
                }
            }, 1000);
        }

        otpResendBtn.addEventListener('click', async () => {
            if (!pendingAuth) return;
            const btn = otpResendBtn;
            setLoading(btn, true, 'ناردن...');
            try {
                let data;
                if (pendingAuth.kind === 'social') {
                    data = await api('/auth/social', { provider: pendingAuth.method, idToken: pendingAuth.idToken });
                } else {
                    data = await api('/otp/send', { method: pendingAuth.method, identifier: pendingAuth.identifier });
                }
                pendingAuth.identifier = data.identifier || pendingAuth.identifier;
                otpDestination.innerText = destinationText(pendingAuth.method, data.masked);
                resetOtpBoxes();
                showSuccess('کۆدەکە دووبارە نێردرایەوە.');
            } catch (e) {
                showError(e.message);
            } finally {
                setLoading(btn, false);
                startResendTimer();
            }
        });

        // ---------- ناردن ----------
        function buildPhoneNumber() {
            let digits = document.getElementById('phone').value.replace(/[^0-9]/g, '');
            if (digits.startsWith('00')) digits = digits.slice(2);
            if (digits.startsWith('964')) digits = digits.slice(3);
            if (digits.startsWith('0')) digits = digits.slice(1);
            return '+964' + digits;
        }

        function recoveryBtn() {
            return document.getElementById('email-recovery-btn');
        }

        async function signInWithPassword(email, password) {
            try {
                await signInWithEmailAndPassword(auth, email, password);
                showSuccess('سەرکەوتوو! ڕەوانەکردن بۆ پەڕەکە...');
                setTimeout(() => { window.location.href = '/'; }, 700);
                return true;
            } catch (e) {
                showError(emailPasswordError(e));
                recoveryBtn().classList.remove('hidden');
                return false;
            }
        }

        async function sendEmailLogin() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            if (!email) {
                showError('تکایە ئیمێڵەکەت بنووسە.');
                return;
            }
            if (password.length < 6) {
                showError('تکایە پاسۆردەکەت بنووسە (بەلایەنی کەم 6 پیت).');
                return;
            }
            const btn = document.getElementById('email-send-btn');
            hideMessages();
            setLoading(btn, true, 'چوونەژوورەوە...');
            try {
                const data = await api('/auth/email', { email, password });
                if (data.status === 'existing') {
                    await signInWithPassword(email, password);
                } else {
                    openOtpStep('email', data.identifier, data.masked, 'email-new', null, password);
                }
            } catch (e) {
                // ئەگەر سێرڤەر نەگەیشتە فایەربەیس، هەوڵی ڕاستەوخۆ بە پاسۆرد بدەرەوە
                const ok = await signInWithPassword(email, password);
                if (!ok && e && e.message) showError(e.message);
            } finally {
                setLoading(btn, false);
            }
        }

        async function sendRecoveryOtp() {
            const email = document.getElementById('email').value.trim();
            if (!email) {
                showError('تکایە ئیمێڵەکەت بنووسە.');
                return;
            }
            const btn = recoveryBtn();
            hideMessages();
            setLoading(btn, true, 'ناردن...');
            try {
                const data = await api('/otp/send', { method: 'email', identifier: email });
                openOtpStep('email', data.identifier, data.masked, 'email-recovery', null, document.getElementById('password').value || null);
            } catch (e) {
                showError(e.message);
            } finally {
                setLoading(btn, false);
            }
        }

        async function sendPhoneCode() {
            const full = buildPhoneNumber();
            if (!/^\+964[0-9]{8,12}$/.test(full)) {
                showError('تکایە ژمارەی مۆبایلەکەت بە تەواوی بنووسە (٧xx xxx xxxx).');
                return;
            }
            const btn = document.getElementById('phone-send-btn');
            hideMessages();
            setLoading(btn, true, 'ناردن...');
            try {
                const data = await api('/otp/send', { method: 'phone', identifier: full });
                openOtpStep('phone', data.identifier, data.masked);
            } catch (e) {
                showError(e.message);
            } finally {
                setLoading(btn, false);
            }
        }

        document.getElementById('email-send-btn').addEventListener('click', sendEmailLogin);
        document.getElementById('email').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailLogin();
        });
        document.getElementById('password').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendEmailLogin();
        });
        document.getElementById('email-recovery-btn').addEventListener('click', sendRecoveryOtp);
        document.getElementById('phone-send-btn').addEventListener('click', sendPhoneCode);
        document.getElementById('phone').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendPhoneCode();
        });

        // ---------- گووگڵ و فەیسبوک ----------
        const googleProvider = new GoogleAuthProvider();
        const facebookProvider = new FacebookAuthProvider();

        async function handleSocial(provider, method, btn) {
            hideMessages();
            setLoading(btn, true, 'چاوەڕوان...');
            try {
                const cred = await signInWithPopup(auth, provider);
                const idToken = await cred.user.getIdToken();
                const data = await api('/auth/social', { provider: method, idToken });
                if (data.status === 'existing' && data.token) {
                    await signInWithCustomToken(auth, data.token);
                    showSuccess('سەرکەوتوو! ڕەوانەکردن بۆ پەڕەکە...');
                    setTimeout(() => { window.location.href = '/'; }, 700);
                } else {
                    openOtpStep(method, data.email, data.masked, 'social', idToken);
                }
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
        document.getElementById('facebook-login-btn').addEventListener('click', () => {
            handleSocial(facebookProvider, 'facebook', document.getElementById('facebook-login-btn'));
        });

        // ---------- پشتڕاستکردنەوە ----------
        async function verifyOtp() {
            if (!pendingAuth) return;
            const code = collectOtp();
            if (code.length !== 6) {
                showError('تکایە کۆدەکە بە تەواوی بنووسە.');
                return;
            }
            hideMessages();
            setLoading(otpVerifyBtn, true, 'پشتڕاستکردنەوە...');
            try {
                const payload = {
                    method: pendingAuth.method,
                    identifier: pendingAuth.identifier,
                    code,
                };
                if (pendingAuth.password) payload.password = pendingAuth.password;
                const data = await api('/otp/verify', payload);
                setLoading(otpVerifyBtn, false);
                await signInWithCustomToken(auth, data.token);
                showSuccess('سەرکەوتوو! ڕەوانەکردن بۆ پەڕەکە...');
                setTimeout(() => { window.location.href = '/'; }, 700);
            } catch (e) {
                showError(e.message);
                setLoading(otpVerifyBtn, false);
                resetOtpBoxes();
            }
        }

        otpVerifyBtn.addEventListener('click', verifyOtp);

        buildOtpBoxes();
        setTabActive('email');
        setPanel('email');
    </script>
@include('components.chat-widget')
</body>
</html>
