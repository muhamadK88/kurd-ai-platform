<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>هەژمارەکەم - کورد ئەی ئای</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Noto Sans Arabic"', 'sans-serif'], } } } }
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg text-white font-black text-xl">ئـ</div>
                <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-blue-500 dark:from-blue-400 dark:to-cyan-300 lang-str" data-so="کورد ئەی ئای" data-ba="کورد ئەی ئای">کورد ئەی ئای</h1>
            </a>

            <div class="hidden md:flex items-center space-x-reverse space-x-2">
                <a href="/" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/courses" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <a href="/ai-tools" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition lang-str" data-so="تووڵەکانی AI" data-ba="ئامرازێن AI">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
            </div>

            <div class="flex items-center gap-3">
                <button id="lang-toggle" class="px-3 py-2 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-sm hover:bg-blue-200 transition">
                    <span id="lang-text">بادینی</span>
                </button>

                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-300 shadow-sm flex items-center justify-center">
                    <svg id="theme-toggle-light-icon" class="hidden dark:block w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="block dark:hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>

                <button id="logout-btn" class="flex items-center gap-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-800/50 px-4 py-2 rounded-xl hover:bg-red-500 hover:text-white dark:hover:bg-red-600 dark:hover:text-white font-bold text-sm transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="lang-str" data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</span>
                </button>
            </div>
        </div>
    </nav>

    <section class="container mx-auto py-12 px-4 max-w-5xl">
        <!-- بەشی سەرەوەی پرۆفایل -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-8">
            <div class="h-32 bg-gradient-to-l from-blue-700 to-blue-900 dark:from-blue-900 dark:to-gray-900"></div>
            <div class="px-8 pb-8 relative flex flex-col md:flex-row items-center md:items-end justify-between -mt-16 gap-6">
                
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <div id="profile-avatar" class="w-32 h-32 rounded-full bg-green-200 border-4 border-white dark:border-gray-800 flex items-center justify-center text-green-800 text-4xl font-black shadow-lg">
                        -
                    </div>
                    <div class="text-center md:text-right mt-4 md:mt-16">
                        <h2 id="profile-name" class="text-3xl font-black text-gray-800 dark:text-white mb-1">...</h2>
                        <p id="profile-email" class="text-gray-500 dark:text-gray-400" dir="ltr">...</p>
                    </div>
                </div>

                <div class="admin-only hidden bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 px-4 py-2 rounded-full font-bold text-sm border border-red-200 dark:border-red-800 mb-2">
                    <span class="lang-str" data-so="سەرپەرشتیار (ئەدمین)" data-ba="سەرپەرشتیار (ئەدمین)">سەرپەرشتیار (ئەدمین)</span>
                </div>
            </div>
        </div>

        <!-- پەنێڵی بەڕێوەبردن (تەنها بۆ ئەدمین) -->
        <div class="admin-only hidden bg-white dark:bg-[#1a2035] rounded-3xl shadow-sm border border-gray-100 dark:border-[#2a3045] p-8 mb-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-black text-blue-600 dark:text-blue-400 mb-2 flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="lang-str" data-so="پەنێڵی بەڕێوەبردن (تایبەت بە تیمی ئەدمین)" data-ba="پەنەلێ بڕێڤەبرنێ (تایبەت ب تیمێ ئەدمینی ڤە)">پەنێڵی بەڕێوەبردن (تایبەت بە تیمی ئەدمین)</span>
                </h3>
                <p class="text-gray-500 dark:text-blue-300/70 text-sm lang-str" data-so="لێرەوە دەتوانیت دەستگەیشتنی خێرای هەبێت بۆ بەشەکانی زیادکردنی داتا لە ماڵپەڕەکەدا." data-ba="ژ ڤێرێ تۆ دشێی ب لەز بگەهیە بەشێن زێدەکرنا داتایان ل مالپەری.">لێرەوە دەتوانیت دەستگەیشتنی خێرای هەبێت بۆ بەشەکانی زیادکردنی داتا لە ماڵپەڕەکەدا.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="/courses" class="bg-gray-100 dark:bg-[#111827] border border-transparent dark:border-gray-800 text-gray-700 dark:text-gray-300 font-bold py-4 px-6 rounded-2xl text-center hover:bg-gray-200 dark:hover:bg-[#1f2937] transition shadow-sm">
                    <span class="lang-str" data-so="بەڕێوەبردنی کۆرسەکان" data-ba="بڕێڤەبرنا کۆرسان">بەڕێوەبردنی کۆرسەکان</span>
                </a>
                <a href="/ai-tools" class="bg-gray-100 dark:bg-[#111827] border border-transparent dark:border-gray-800 text-gray-700 dark:text-gray-300 font-bold py-4 px-6 rounded-2xl text-center hover:bg-gray-200 dark:hover:bg-[#1f2937] transition shadow-sm">
                    <span class="lang-str" data-so="بەڕێوەبردنی ئامرازەکان" data-ba="بڕێڤەبرنا ئامرازان">بەڕێوەبردنی ئامرازەکان</span>
                </a>
                <a href="/academic-guide" class="bg-gray-100 dark:bg-[#111827] border border-transparent dark:border-gray-800 text-gray-700 dark:text-gray-300 font-bold py-4 px-6 rounded-2xl text-center hover:bg-gray-200 dark:hover:bg-[#1f2937] transition shadow-sm">
                    <span class="lang-str" data-so="بەڕێوەبردنی ڕێنیشاندەر" data-ba="بڕێڤەبرنا ڕێبەری">بەڕێوەبردنی ڕێنیشاندەر</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- چالاکییەکانی من -->
            <div class="md:col-span-2 bg-white dark:bg-[#1a2035] rounded-3xl shadow-sm border border-gray-100 dark:border-[#2a3045] p-8">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 text-center lang-str" data-so="چالاکییەکانی من" data-ba="چالاکیێن من">چالاکییەکانی من</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-[#111827] p-6 rounded-2xl text-center border border-gray-100 dark:border-gray-800">
                        <div class="text-2xl font-black text-blue-500 mb-1">٠</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 lang-str" data-so="کۆرسی تەواوکراو" data-ba="کۆرسێن ب دوماهی هاتی">کۆرسی تەواوکراو</div>
                    </div>
                    <div class="bg-gray-50 dark:bg-[#111827] p-6 rounded-2xl text-center border border-gray-100 dark:border-gray-800">
                        <div class="text-2xl font-black text-blue-500 mb-1">٠</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 lang-str" data-so="ئامرازی دڵخواز" data-ba="ئامرازێن دڵخواز">ئامرازی دڵخواز</div>
                    </div>
                </div>
                
                <p class="text-center text-sm text-gray-400 dark:text-gray-500 lang-str" data-so="لەم بەشەدا لە داهاتوودا چالاکییەکانت و پێشکەوتنەکانت پیشان دەدرێت." data-ba="د ڤی بەشی دا د پاشەڕۆژێ دا چالاکی و پێشکەفتنێن تە دێ هێنە نیشاندان.">لەم بەشەدا لە داهاتوودا چالاکییەکانت و پێشکەوتنەکانت پیشان دەدرێت.</p>
            </div>

            <!-- زانیارییە کەسییەکان -->
            <div class="bg-white dark:bg-[#1a2035] rounded-3xl shadow-sm border border-gray-100 dark:border-[#2a3045] p-8 flex flex-col justify-center">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6 text-center lang-str" data-so="زانیارییە کەسییەکان" data-ba="پێزانینێن کەسی">زانیارییە کەسییەکان</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-700/50 pb-4">
                        <span class="text-gray-500 dark:text-gray-400 font-bold text-sm lang-str" data-so="جۆری هەژمار" data-ba="جۆرێ هەژمارێ">جۆری هەژمار</span>
                        <span id="account-type" class="font-bold text-gray-800 dark:text-white lang-str" data-so="بەکارهێنەر" data-ba="بکارهێنەر">بەکارهێنەر</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-500 dark:text-gray-400 font-bold text-sm lang-str" data-so="بەشداریکردن" data-ba="پشکداریکرن">بەشداریکردن</span>
                        <span class="font-bold text-gray-800 dark:text-white lang-str" data-so="خۆڕایی (چالاکە)" data-ba="بێ بەرامبەر (چالاکە)">خۆڕایی (چالاکە)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        const auth = getAuth(initializeApp(firebaseConfig));

        let currentLang = localStorage.getItem('site-lang') || 'so';
        let isAdmin = false;

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) { langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی'; }
            
            document.querySelectorAll('.lang-str').forEach(el => {
                let text = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
                el.innerText = text;
            });

            // تایبەت بە جۆری هەژمار (ئەگەر ئەدمین بوو، با تێکستەکە بگرێتەوە)
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

        // وەرگرتنی پیتی یەکەمی ناو بۆ وێنەی پرۆفایل
        function getInitials(name) {
            if(!name) return 'U';
            const parts = name.split(' ');
            if(parts.length > 1) {
                return (parts[0][0] + parts[1][0]).toUpperCase();
            }
            return name.substring(0, 2).toUpperCase();
        }

        // Auth Check
        onAuthStateChanged(auth, (user) => { 
            if(!user) {
                window.location.href = "/login"; 
            } else { 
                document.body.style.display = 'block'; 
                
                // دانانی زانیارییەکانی بەکارهێنەر
                let displayName = user.displayName || user.email.split('@')[0];
                document.getElementById('profile-name').innerText = displayName;
                document.getElementById('profile-email').innerText = user.email;
                document.getElementById('profile-avatar').innerText = getInitials(displayName);

                // پشکنین بۆ ئەدمین
                const adminEmails = ["team@kurd-ai.com", "mahamadkamaran890@gmail.com"];
                if(adminEmails.includes(user.email)) {
                    isAdmin = true;
                    document.querySelectorAll('.admin-only').forEach(el => el.classList.remove('hidden'));
                }
                
                applyLanguage(); // کارپێکردنی زمان دوای بارکردنی زانیارییەکان
            }
        });
        
        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));
    </script>
</body>
</html>