<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چوونەژوورەوە - کورد ئەی ئای</title>

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

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white min-h-screen transition-colors duration-300 flex items-center justify-center p-4">

    <!-- دوگمەی گۆڕینی زمان و دارک مۆد لە سەرەوە -->
    <div class="absolute top-4 right-4 flex gap-3">
        <button id="lang-toggle" class="px-3 py-2 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 font-bold rounded-xl text-sm hover:bg-blue-200 transition shadow-sm">
            <span id="lang-text">بادینی</span>
        </button>
        <button id="theme-toggle" class="p-2.5 bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-700 transition duration-300 shadow-sm flex items-center justify-center">
            <svg id="theme-toggle-light-icon" class="hidden dark:block w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707-.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
            <svg id="theme-toggle-dark-icon" class="block dark:hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
        </button>
    </div>

    <!-- فۆرمی چوونەژوورەوە -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-2xl flex items-center justify-center shadow-lg text-white font-black text-3xl mx-auto mb-4">ئـ</div>
            <h2 class="text-2xl font-black text-gray-800 dark:text-white lang-str" data-so="چوونەژوورەوە" data-ba="چوونە ژوور">چوونەژوورەوە</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm lang-str" data-so="بەخێربێیتەوە بۆ پلاتفۆرمی کورد ئەی ئای" data-ba="ب خێرهاتی بۆ پلاتفۆرمێ کورد ئەی ئای">بەخێربێیتەوە بۆ پلاتفۆرمی کورد ئەی ئای</p>
        </div>

        <div id="error-msg" class="hidden bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 p-3 rounded-xl text-center text-sm font-bold mb-4 border border-red-200 dark:border-red-800"></div>

        <!-- فۆرمی ئیمەیڵ و وشەی نهێنی -->
        <form id="login-form">
            <div class="mb-5">
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="ئیمەیڵ" data-ba="ئیمەیل">ئیمەیڵ</label>
                <input type="email" id="email" required dir="ltr" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 font-bold mb-2 lang-str" data-so="وشەی نهێنی" data-ba="پەیڤا نهێنی">وشەی نهێنی</label>
                <input type="password" id="password" required dir="ltr" class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <button type="submit" id="login-btn" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg flex justify-center items-center gap-2">
                <span class="lang-str" data-so="چوونەژوورەوە" data-ba="چوونە ژوور">چوونەژوورەوە</span>
            </button>
        </form>

        <!-- هێڵی جیاکەرەوە -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 lang-str" data-so="یان" data-ba="یان">یان</span>
            </div>
        </div>

        <!-- دوگمەی گۆڕڵ -->
        <button type="button" id="google-login-btn" class="w-full bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 py-3 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm flex justify-center items-center gap-3">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            <span class="lang-str" data-so="چوونەژوورەوە بە گۆگڵ" data-ba="چوونە ژوور ب گۆگڵ">چوونەژوورەوە بە گۆگڵ</span>
        </button>

    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b", storageBucket: "ai-platform-adb1b.firebasestorage.app", messagingSenderId: "798560436587", appId: "1:798560436587:web:d4e3f4e5f862c7cbde0c2e" };
        
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const googleProvider = new GoogleAuthProvider();

        // --- بەشی زمان و دارک مۆد ---
        let currentLang = localStorage.getItem('site-lang') || 'so';

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) { langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی'; }
            
            document.querySelectorAll('.lang-str').forEach(el => {
                let text = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
                if (el.tagName === 'SPAN' || el.tagName === 'H2' || el.tagName === 'P' || el.tagName === 'LABEL') {
                    el.innerText = text;
                }
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

        // --- بەشی لۆگین بە ئیمەیڵ ---
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault(); 
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const btn = document.getElementById('login-btn');
            const errorMsg = document.getElementById('error-msg');
            
            btn.disabled = true;
            btn.innerHTML = currentLang === 'so' ? 'چاوەڕێ بە...' : 'چاڤەڕێ بە...';
            errorMsg.classList.add('hidden');

            try {
                await signInWithEmailAndPassword(auth, email, password);
                window.location.href = "/";
            } catch (error) {
                errorMsg.innerText = currentLang === 'so' ? 'ئیمەیڵ یان وشەی نهێنی هەڵەیە!' : 'ئیمەیل یان پەیڤا نهێنی خەلەتە!';
                errorMsg.classList.remove('hidden');
                
                btn.disabled = false;
                btn.innerHTML = `<span class="lang-str" data-so="چوونەژوورەوە" data-ba="چوونە ژوور">${currentLang === 'so' ? 'چوونەژوورەوە' : 'چوونە ژوور'}</span>`;
            }
        });

        // --- بەشی لۆگین بە گۆگڵ ---
        document.getElementById('google-login-btn').addEventListener('click', async () => {
            const errorMsg = document.getElementById('error-msg');
            errorMsg.classList.add('hidden');
            
            try {
                await signInWithPopup(auth, googleProvider);
                window.location.href = "/";
            } catch (error) {
                console.error("Google Login Error: ", error);
                errorMsg.innerText = currentLang === 'so' ? 'کێشەیەک ڕوویدا، نەتوانرا بە گۆگڵ لۆگین بکرێت!' : 'ئاریشەیەک دروست بوو، نەهاتە لۆگین کرن ب گۆگڵێ!';
                errorMsg.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>