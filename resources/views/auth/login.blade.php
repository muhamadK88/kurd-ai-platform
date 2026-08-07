<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .otp-input { letter-spacing: .5em; }
    </style>
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

                <!-- یارمەتی پشتڕاستکردنەوەی ئیمێڵ -->
                <div id="verify-help" class="hidden bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-sm font-bold p-4 rounded-2xl mb-4 text-center border border-amber-200 dark:border-amber-800/50 shadow-sm leading-relaxed animate-fade-up">
                    <p id="verify-help-text" class="lang-str" data-so="ئیمێڵەکەت هێشتا پشتڕاست نەکراوەتەوە." data-ba="ئیمێلا تە هێشتا نەهاتیە پشتڕاستکرن.">ئیمێڵەکەت هێشتا پشتڕاست نەکراوەتەوە.</p>
                    <div class="flex gap-2 justify-center mt-3">
                        <button id="resend-verify-btn" type="button" class="flex-1 bg-amber-500 text-white py-2.5 rounded-xl font-bold text-xs hover:bg-amber-600 transition shadow lang-str" data-so="دووبارە ناردنەوە" data-ba="دوبارە شاندن">دووبارە ناردنەوە</button>
                        <button id="cancel-verify-btn" type="button" class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-2.5 rounded-xl font-bold text-xs hover:bg-gray-300 dark:hover:bg-gray-600 transition lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>
                    </div>
                </div>

                <!-- تبەکان -->
                <div class="grid grid-cols-2 gap-1.5 bg-gray-100 dark:bg-gray-800 rounded-2xl p-1.5 mb-6">
                    <button id="tab-email" type="button" class="py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow lang-str" data-so="✉️ بە ئیمێڵ" data-ba="✉️ ب ئیمێلی">✉️ بە ئیمێڵ</button>
                    <button id="tab-phone" type="button" class="py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 lang-str" data-so="📱 بە ژمارەی مۆبایل" data-ba="📱 ب ژمارا موبایلی">📱 بە ژمارەی مۆبایل</button>
                </div>

                <!-- پەڕەی ئیمێڵ -->
                <div id="panel-email" class="space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ئیمەیڵ" data-ba="ئیمێل">ئیمەیڵ</label>
                        <input type="email" id="email" placeholder="you@example.com" autocomplete="email"
                            class="w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left" dir="ltr">
                    </div>
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="وشەی نهێنی" data-ba="پەیڤا نهێنی">وشەی نهێنی</label>
                        <div class="relative">
                            <input type="password" id="password" placeholder="••••••••" autocomplete="current-password"
                                class="w-full px-4 py-3.5 pr-4 pl-12 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition text-left" dir="ltr">
                            <button id="toggle-password" type="button" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 text-xl transition" title="نیشاندان/شاردنەوە">👁️</button>
                        </div>
                        <div class="text-left mt-2">
                            <button id="forgot-password-btn" type="button" class="text-sm font-bold text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition lang-str" data-so="وشەی نهێنیت بیرچووە؟" data-ba="پەیڤا نهێنی یا تە ژبیر چوویە؟">وشەی نهێنیت بیرچووە؟</button>
                        </div>
                    </div>

                    <button id="email-submit-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-2xl font-black text-lg hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="چوونەژورەوە" data-ba="چوونا ژوورێ">
                        چوونەژوورەوە
                    </button>
                    <p class="text-center text-xs text-gray-400 dark:text-gray-500 font-bold lang-str" data-so="ئەگەر هەژمارت نەبێت، بە هەمان زانیارییەوە ئۆتۆماتیکی دروستدەکرێت." data-ba="ئەگەر هەژمارا تە نەبیت، ب هەمان زانیاریان ئۆتۆماتیک دێتە چێکرن.">ئەگەر هەژمارت نەبێت، بە هەمان زانیارییەوە ئۆتۆماتیکی دروستدەکرێت.</p>
                </div>

                <!-- پەڕەی مۆبایل -->
                <div id="panel-phone" class="hidden space-y-5">
                    <div>
                        <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="ژمارەی مۆبایل" data-ba="ژمارا موبایلی">ژمارەی مۆبایل</label>
                        <div class="flex rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700/60 focus-within:ring-2 focus-within:ring-emerald-500 transition">
                            <span class="flex items-center gap-1.5 px-4 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-black text-sm whitespace-nowrap border-r border-gray-200 dark:border-gray-600">
                                🇮🇶 <span dir="ltr">+964</span>
                            </span>
                            <input type="tel" id="phone" placeholder="7xx xxx xxxx" inputmode="tel" autocomplete="tel"
                                class="flex-1 px-4 py-3.5 bg-transparent outline-none text-left" dir="ltr">
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 font-bold mt-1.5 text-left lang-str" data-so="تەنها بەشی ژمارەکە بنووسە — +964 خۆکارانە زیاد دەکرێت." data-ba="تنێ پشکا ژمارێ بنڤیسە — +964 ئۆتۆماتیک زێدە دبیت.">تەنها بەشی ژمارەکە بنووسە — +964 خۆکارانە زیاد دەکرێت.</p>
                    </div>
                    <div id="recaptcha-container"></div>

                    <button id="phone-send-btn" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white py-4 rounded-2xl font-black text-lg hover:from-emerald-700 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="ناردنی کۆدی پشتڕاستکردنەوە" data-ba="شاندنا کۆدێ پشتڕاستکرنێ">
                        ناردنی کۆدی پشتڕاستکردنەوە
                    </button>

                    <div id="otp-wrap" class="hidden space-y-3 border-t border-gray-100 dark:border-gray-700 pt-5 animate-fade-up">
                        <div>
                            <label class="block text-sm font-black text-gray-700 dark:text-gray-300 mb-2 lang-str" data-so="کۆدی پشتڕاستکردنەوە" data-ba="کۆدێ پشتڕاستکرنێ">کۆدی پشتڕاستکردنەوە</label>
                            <input type="text" id="otp" placeholder="000000" inputmode="numeric" maxlength="6"
                                class="otp-input w-full px-4 py-3.5 bg-gray-50 dark:bg-gray-700/60 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-white rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition text-center text-lg font-black text-left" dir="ltr">
                            <p class="text-xs text-gray-400 dark:text-gray-500 font-bold mt-1.5 lang-str" data-so="کۆدەکە لە ڕێگەی پیامەکەوە (SMS) بۆ ژمارەکەت دەنێردرێت." data-ba="کۆد ب ڕێکا پەیامێ (SMS) بۆ ژمارا تە دێتە شاندن.">کۆدەکە لە ڕێگەی پیامەکەوە (SMS) بۆ ژمارەکەت دەنێردرێت.</p>
                        </div>
                        <button id="phone-verify-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3.5 rounded-2xl font-black hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg shadow-blue-500/30 hover:-translate-y-0.5 flex items-center justify-center gap-2 lang-str" data-so="پشتڕاستکردنەوە و چوونەژوورەوە" data-ba="پشتڕاستکرن و چوونا ژوورێ">
                            پشتڕاستکردنەوە و چوونەژوورەوە
                        </button>
                        <button id="phone-resend-btn" type="button" class="w-full text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 transition py-1 lang-str" data-so="دووبارە ناردنەوەی کۆدەکە" data-ba="دوبارە شاندنا کۆدێ">دووبارە ناردنەوەی کۆدەکە</button>
                    </div>
                </div>

                <div class="mt-7 flex items-center justify-between">
                    <hr class="w-full border-gray-200 dark:border-gray-700">
                    <span class="px-3 text-gray-400 dark:text-gray-500 text-sm font-bold whitespace-nowrap lang-str" data-so="یان بەکارهێنانی" data-ba="یان ب بکارئینانا">یان بەکارهێنانی</span>
                    <hr class="w-full border-gray-200 dark:border-gray-700">
                </div>

                <div class="mt-6 space-y-3">
    <button id="google-login-btn" class="w-full flex items-center justify-center gap-3 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-white py-3.5 rounded-2xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-md hover:-translate-y-0.5 transition-all group">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
    </svg>
    <span class="lang-str" data-so="بەردەوامبوون لەگەڵ گووگڵ  " data-ba="بەردەوامبوون دگەل گووگڵ">بەردەوامبوون لەگەڵ گووگڵ</span>
</button>

<button id="facebook-login-btn" class="w-full flex items-center justify-center gap-3 bg-[#1877F2] text-white py-3.5 rounded-2xl font-bold hover:bg-[#166FE5] hover:shadow-lg hover:shadow-[#1877F2]/30 hover:-translate-y-0.5 transition-all group">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28px" height="28px" class="flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
        <!-- تەنها پیتی (f) ماوەتەوە -->
        <path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/>
    </svg>
    <span class="lang-str" data-so="بەردەوامبوون لەگەڵ فەیسبووک" data-ba="بەردەوامبوون دگەل فەیسبووک">بەردەوامبوون لەگەڵ فەیسبووک</span>
</button>

                <p class="text-center mt-8 text-sm font-bold">
                    <a href="/" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition lang-str" data-so="← گەڕانەوە بۆ سەرەتا" data-ba="← زڤڕین بۆ دەستپێکێ">← گەڕانەوە بۆ سەرەتا</a>
                </p>
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
        import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, fetchSignInMethodsForEmail, GoogleAuthProvider, FacebookAuthProvider, signInWithPopup, sendEmailVerification, signOut, sendPasswordResetEmail, RecaptchaVerifier, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

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

        // لیستی ئەدمینەکان
        const adminEmails = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"];

        const errorMsg = document.getElementById('error-message');
        const successMsg = document.getElementById('success-message');
        const verifyHelp = document.getElementById('verify-help');

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
            verifyHelp.classList.add('hidden');
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

        // ---------- تبەکان ----------
        const tabEmail = document.getElementById('tab-email');
        const tabPhone = document.getElementById('tab-phone');
        const panelEmail = document.getElementById('panel-email');
        const panelPhone = document.getElementById('panel-phone');

        function setTab(which) {
            hideMessages();
            const isEmail = which === 'email';
            panelEmail.classList.toggle('hidden', !isEmail);
            panelPhone.classList.toggle('hidden', isEmail);
            const active = 'lang-str py-3 rounded-xl font-black text-sm transition bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 shadow';
            const inactive = 'lang-str py-3 rounded-xl font-black text-sm transition text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200';
            tabEmail.className = isEmail ? active : inactive;
            tabPhone.className = isEmail ? inactive : active;
        }
        tabEmail.addEventListener('click', () => setTab('email'));
        tabPhone.addEventListener('click', () => setTab('phone'));

        // ---------- نیشاندان/شاردنەوەی پاسۆرد ----------
        document.getElementById('toggle-password').addEventListener('click', () => {
            const p = document.getElementById('password');
            p.type = p.type === 'password' ? 'text' : 'password';
        });

        // ---------- لۆگینی ئیمێڵ (ئەگەر نەبوو دروستکردنی هەژمار) ----------
        document.getElementById('email-submit-btn').addEventListener('click', handleEmailAuth);
        document.getElementById('password').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') handleEmailAuth();
        });

        async function handlePasswordSignIn(email, password) {
            const userCredential = await signInWithEmailAndPassword(auth, email, password);
            const user = userCredential.user;
            const isAdmin = adminEmails.includes(user.email);
            if (!user.emailVerified && !isAdmin) {
                // دەرچوون + نیشاندانی یارمەتی پشتڕاستکردنەوە
                await signOut(auth);
                window.pendingVerifyEmail = email;
                window.pendingVerifyPassword = password;
                verifyHelp.classList.remove('hidden');
                verifyHelp.querySelector('#verify-help-text').innerText = "ئیمێڵەکەت هێشتا پشتڕاست نەکراوەتەوە. تکایە لینکەکەی ناو ئیمێڵەکەت بکەرەوە، یان ئیمێڵەکە دووبارە بنێرەوە.";
                showError("تکایە سەرەتا ئیمێڵەکەت پشتڕاست بکەرەوە پاشان لۆگین بکە.");
            } else {
                window.location.href = "/";
            }
        }

        async function handleEmailAuth() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const btn = document.getElementById('email-submit-btn');

            if (!email || !password) {
                showError("تکایە ئیمێڵ و وشەی نهێنی پڕبکەرەوە.");
                return;
            }
            hideMessages();
            setLoading(btn, true, 'تکایە چاوەڕوان بە...');
            try {
                let methods = [];
                try {
                    methods = await fetchSignInMethodsForEmail(auth, email);
                } catch (_) {
                    methods = [];
                }

                if (methods.includes('password')) {
                    // هەژمار بە پاسۆرد هەیە => لۆگین
                    await handlePasswordSignIn(email, password);
                } else if (methods.length === 0) {
                    // هەژمار نییە => دروستکردنی هەژماری نوێ + پشتڕاستکردنەوەی ئیمێڵ
                    try {
                        const userCredential = await createUserWithEmailAndPassword(auth, email, password);
                        await sendEmailVerification(userCredential.user);
                        await signOut(auth);
                        showSuccess("هەژمارەکەت سەرکەوتوویانە دروستکرا! ✨ نامەیەکی دڵنیاییمان نارد بۆ ئیمێڵەکەت. تکایە سەردانی ئیمێڵەکەت بکە و پشتڕاستی بکەرەوە پێش ئەوەی لۆگین بکەیت.");
                        document.getElementById('email').value = '';
                        document.getElementById('password').value = '';
                    } catch (createError) {
                        if (createError.code === 'auth/email-already-in-use') {
                            // هەژمارەکە هەیە => بە پاسۆرد لۆگین بکە
                            await handlePasswordSignIn(email, password);
                        } else {
                            throw createError;
                        }
                    }
                } else {
                    // هەژمار بە ڕێگایەکی تر تۆمارکراوە
                    const providerNames = {
                        'google.com': 'گووگڵ',
                        'facebook.com': 'فەیسبوک',
                        'phone': 'ژمارەی مۆبایل'
                    };
                    const providerLabel = methods.map(m => providerNames[m] || m).join(' یان ');
                    showError(`ئەم ئیمێڵە پێشتر بە (${providerLabel}) تۆمارکراوە. تکایە بە هەمان ڕێگا بچۆ ژوورەوە.`);
                }
            } catch (error) {
                if (error.code === 'auth/invalid-email') {
                    showError("ئیمێڵەکە هەڵەیە، تکایە دووبارە بینوسەرەوە.");
                } else if (error.code === 'auth/weak-password') {
                    showError("وشەی نهێنی لاوازە، دەبێت لانی کەم ٦ پیت یان ژمارە بێت.");
                } else if (error.code === 'auth/invalid-credential' || error.code === 'auth/wrong-password') {
                    showError("وشەی نهێنی هەڵەیە، تکایە دووبارە تاقی بکەرەوە.");
                } else if (error.code === 'auth/too-many-requests') {
                    showError("زۆر هەوڵت داوە. تکایە دوای چەند خولەکێک هەوڵ بدەوە.");
                } else {
                    showError("کێشەیەک ڕوویدا: " + error.message);
                }
            } finally {
                setLoading(btn, false);
            }
        }

        // دوبارە ناردنەوەی ئیمێڵی پشتڕاستکردنەوە
        document.getElementById('resend-verify-btn').addEventListener('click', () => {
            const email = window.pendingVerifyEmail;
            const password = window.pendingVerifyPassword;
            if (!email || !password) { verifyHelp.classList.add('hidden'); return; }
            const btn = document.getElementById('resend-verify-btn');
            setLoading(btn, true, 'ناردن...');
            signInWithEmailAndPassword(auth, email, password)
                .then(async (userCredential) => {
                    await sendEmailVerification(userCredential.user);
                    await signOut(auth);
                    showSuccess("ئیمێڵی پشتڕاستکردنەوە دووبارە نێردرایەوە! سەیری Inbox یان Spam بکە.");
                })
                .catch((error) => showError("کێشەیەک ڕوویدا: " + error.message))
                .finally(() => setLoading(btn, false));
        });
        document.getElementById('cancel-verify-btn').addEventListener('click', () => {
            verifyHelp.classList.add('hidden');
            window.pendingVerifyEmail = null;
            window.pendingVerifyPassword = null;
        });

        // ---------- لەبیرچوونی پاسۆرد ----------
        document.getElementById('forgot-password-btn').addEventListener('click', () => {
            const email = document.getElementById('email').value.trim();
            if (!email) {
                showError("تکایە سەرەتا ئیمێڵەکەت لە بۆکسەکەدا بنووسە، پاشان کلیک لە 'وشەی نهێنیت بیرچووە؟' بکە بۆ ئەوەی لینکی گۆڕینت بۆ بنێرین.");
                return;
            }
            sendPasswordResetEmail(auth, email)
                .then(() => {
                    showSuccess("لینکی گۆڕینی وشەی نهێنی نێردرا بۆ ئیمێڵەکەت! تکایە سەیری Inbox یان Spamـی ئیمێڵەکەت بکە.");
                })
                .catch((error) => {
                    if (error.code === 'auth/invalid-email') {
                        showError("ئەم ئیمێڵە هەڵەیە یان بوونی نییە.");
                    } else if (error.code === 'auth/user-not-found') {
                        showError("هیچ هەژمارێک بەم ئیمێڵەوە بوونی نییە لە سیستەمەکەماندا.");
                    } else {
                        showError("کێشەیەک ڕوویدا: " + error.message);
                    }
                });
        });

        // ---------- گووگڵ ----------
        const googleProvider = new GoogleAuthProvider();
        document.getElementById('google-login-btn').addEventListener('click', () => {
            signInWithPopup(auth, googleProvider)
                .then(() => { window.location.href = "/"; })
                .catch((error) => {
                    if (error.code === 'auth/popup-closed-by-user') return;
                    if (error.code === 'auth/account-exists-with-different-credential') {
                        showError("ئەم ئیمێڵە پێشتر بە ڕێگایەکی تر تۆمارکراوە. تکایە لەگەڵ هەمان ئیمێڵ لۆگین بکە یان بە ڕێگایەکی تر بچۆ ژوورەوە.");
                    } else if (error.code === 'auth/popup-blocked') {
                        showError("وێبگەڕەکەت پاپئاپەکە بەربەستکردووە. تکایە ڕێگەی بدە و دووبارە هەوڵ بدەوە.");
                    } else {
                        showError("کێشەیەک ڕوویدا لە گووگڵ: " + error.message);
                    }
                });
        });

        // ---------- فەیسبوک ----------
        const facebookProvider = new FacebookAuthProvider();
        document.getElementById('facebook-login-btn').addEventListener('click', () => {
            signInWithPopup(auth, facebookProvider)
                .then(() => { window.location.href = "/"; })
                .catch((error) => {
                    if (error.code === 'auth/popup-closed-by-user') return;
                    if (error.code === 'auth/account-exists-with-different-credential') {
                        showError("ئەم ئیمێڵە پێشتر بە ڕێگایەکی تر تۆمارکراوە. تکایە لەگەڵ هەمان ئیمێڵ لۆگین بکە یان بە ڕێگایەکی تر بچۆ ژوورەوە.");
                    } else if (error.code === 'auth/popup-blocked') {
                        showError("وێبگەڕەکەت پاپئاپەکە بەربەستکردووە. تکایە ڕێگەی بدە و دووبارە هەوڵ بدەوە.");
                    } else {
                        showError("کێشەیەک ڕوویدا لە فەیسبوک: " + error.message);
                    }
                });
        });

        // ---------- مۆبایل (کۆدی پشتڕاستکردنەوە) ----------
        let recaptchaVerifier = null;
        const sendBtn = document.getElementById('phone-send-btn');
        const verifyBtn = document.getElementById('phone-verify-btn');
        const resendBtn = document.getElementById('phone-resend-btn');
        const otpWrap = document.getElementById('otp-wrap');

        function buildPhoneNumber() {
            let digits = document.getElementById('phone').value.replace(/[^0-9]/g, '');
            if (digits.startsWith('964')) digits = digits.slice(3);
            if (digits.startsWith('0')) digits = digits.slice(1);
            return '+964' + digits;
        }

        function getRecaptcha() {
            if (!recaptchaVerifier) {
                recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
                    size: 'invisible',
                    callback: () => {}
                });
            }
            return recaptchaVerifier;
        }

        function resetRecaptcha() {
            if (recaptchaVerifier) {
                try { recaptchaVerifier.clear(); } catch (e) {}
                recaptchaVerifier = null;
            }
        }

        async function sendPhoneCode() {
            const full = buildPhoneNumber();
            if (!/^\+964[0-9]{8,12}$/.test(full)) {
                showError("تکایە ژمارەی مۆبایلەکەت بە تەواوی بنووسە (کۆدی وڵاتی +964 خۆکارانە زیاد دەکرێت).");
                return;
            }
            hideMessages();
            setLoading(sendBtn, true, 'ناردن...');
            try {
                window.confirmationResult = await signInWithPhoneNumber(auth, full, getRecaptcha());
                otpWrap.classList.remove('hidden');
                document.getElementById('otp').value = '';
                document.getElementById('otp').focus();
                showSuccess("کۆدی پشتڕاستکردنەوە نێردرا بۆ ژمارەکەت (SMS). تکایە کۆدەکە بنووسە.");
            } catch (error) {
                resetRecaptcha();
                if (error.code === 'auth/invalid-phone-number') {
                    showError("ژمارەی مۆبایلەکە نادروستە یان وەک سۆپۆرت ناکرێت.");
                } else if (error.code === 'auth/operation-not-allowed' || error.code === 'auth/unauthorized-continue-uri') {
                    showError("لۆگینی بە ژمارە لە فایەربەیس چالاک نەکراوە (Firebase Console → Authentication → Sign-in method → Phone).");
                } else if (error.code === 'auth/unauthorized-domain') {
                    showError("دۆمەینەکەت لە فایەربەیس ڕێگەپێدراو نییە (Firebase Console → Authentication → Authorized domains).");
                } else if (error.code === 'auth/quota-exceeded') {
                    showError("زۆر هەوڵت داوە. تکایە دوای چەند خولەکێک هەوڵ بدەوە.");
                } else if (error.code === 'auth/captcha-check-failed' || error.code === 'auth/missing-verification-code') {
                    showError("پشتڕاستکردنەوەی CAPTCHA سەرنەکەوت. تکایە دووبارە هەوڵ بدەوە.");
                } else {
                    showError("کێشەیەک ڕوویدا: " + error.message);
                }
            } finally {
                setLoading(sendBtn, false);
            }
        }

        async function verifyPhoneCode() {
            const code = document.getElementById('otp').value.trim();
            if (!code) {
                showError("تکایە کۆدەکە بنووسە.");
                return;
            }
            if (!window.confirmationResult) {
                showError("تکایە سەرەتا کۆدەکە بنێرە بۆ ژمارەکەت.");
                return;
            }
            hideMessages();
            setLoading(verifyBtn, true, 'پشتڕاستکردنەوە...');
            try {
                await window.confirmationResult.confirm(code);
                window.location.href = "/";
            } catch (error) {
                if (error.code === 'auth/invalid-verification-code') {
                    showError("کۆدەکە هەڵەیە. تکایە دووبارە تاقی بکەرەوە.");
                } else if (error.code === 'auth/code-expired') {
                    showError("کۆدەکە بەسەرچووە. تکایە کۆدێکی نوێ بنێرەوە.");
                    otpWrap.classList.add('hidden');
                    resetRecaptcha();
                } else {
                    showError("کێشەیەک ڕوویدا: " + error.message);
                }
            } finally {
                setLoading(verifyBtn, false);
            }
        }

        sendBtn.addEventListener('click', sendPhoneCode);
        document.getElementById('phone').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') sendPhoneCode();
        });
        verifyBtn.addEventListener('click', verifyPhoneCode);
        document.getElementById('otp').addEventListener('keydown', (e) => {
            if (e.key === 'Enter') verifyPhoneCode();
        });
        resendBtn.addEventListener('click', () => {
            otpWrap.classList.add('hidden');
            sendPhoneCode();
        });
    </script>
@include('components.chat-widget')
</body>
</html>
