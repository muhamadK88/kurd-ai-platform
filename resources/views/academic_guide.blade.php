<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ڕێنیشاندەری ئەکادیمی - کورد ئەی ئای</title>

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
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid rgba(75, 85, 99, 0.5);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- ناڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-lg border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 hover:opacity-80 transition group">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30 text-white font-black text-xl">ئـ</div>
                <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-blue-500 dark:from-blue-400 dark:to-cyan-300">کورد ئەی ئای</h1>
            </a>
            
            <div class="hidden md:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <a href="/" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="سەرەکی" data-ba="سەرەکی">سەرەکی</a>
                <a href="/ferga" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="فێرگە" data-ba="فێرگە">فێرگە</a>
                <a href="/courses" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="کۆرسەکان" data-ba="کۆرس">کۆرسەکان</a>
                <!-- تووڵەکان چالاککراوە (Active) -->
                <a href="/ai-tools" class="px-4 py-2 bg-white dark:bg-gray-700 text-blue-600 dark:text-blue-400 font-bold rounded-xl shadow-sm transition lang-str" data-so="تووڵەکانی AI" data-ba="ئامرازێن AI">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="ڕێنیشاندەر" data-ba="ڕێبەر">ڕێنیشاندەر</a>
                <a href="/universities" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-200/50 dark:hover:bg-gray-700/50 rounded-xl transition lang-str" data-so="زانکۆکان" data-ba="زانکۆ">زانکۆکان</a>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="relative py-24 text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-teal-400 dark:bg-teal-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[128px] opacity-20 animate-blob"></div>
            <div class="absolute -bottom-8 right-20 w-96 h-96 bg-blue-400 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[128px] opacity-20 animate-blob animation-delay-2000"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-teal-50 dark:bg-teal-900/30 border border-teal-200 dark:border-teal-700/50 text-teal-700 dark:text-teal-300 font-black text-sm mb-8 shadow-sm">
                <span>زانیارییە ئەکادیمییەکان</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 text-gray-900 dark:text-white tracking-tight">ڕێنیشاندەری ئەکادیمی</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto font-medium">هەموو ئەو زانیارییانەی پێویستتە بۆ سەرکەوتن لە پرۆسەی خوێندنت لێرە بدۆزەرەوە.</p>
        </div>
    </header>

    <!-- Guide Content -->
    <section class="container mx-auto pb-24 px-4 max-w-4xl">
        <div id="guide-container" class="space-y-8">
            <!-- لێرە زانیارییەکان بە دیزاینی Glassmorphism دەردەکەون -->
        </div>
    </section>

    <!-- Admin Section -->
    <section class="admin-only hidden container mx-auto pb-24 px-4" id="admin-form-section">
        <div class="glass-card p-10 md:p-16 rounded-[3rem] shadow-2xl max-w-4xl mx-auto border-t-8 border-teal-500">
            <h3 class="text-4xl font-black mb-12 text-center text-gray-900 dark:text-white">بەشی بەڕێوەبردنی ڕێنیشاندەر</h3>
            <form id="upload-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="text" id="question_so" placeholder="پرسیار (سۆرانی)" required class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all">
                    <input type="text" id="question_ba" placeholder="پرسیار (بادینی)" required class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <textarea id="answer_so" placeholder="وەڵام (سۆرانی)" required rows="5" class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all"></textarea>
                    <textarea id="answer_ba" placeholder="وەڵام (بادینی)" required rows="5" class="w-full px-6 py-5 rounded-2xl bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 focus:ring-4 focus:ring-teal-500/20 outline-none transition-all"></textarea>
                </div>
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-teal-600 to-emerald-600 text-white py-5 rounded-2xl font-black text-xl hover:shadow-2xl hover:shadow-teal-500/30 hover:-translate-y-1 transition-all">پاشەکەوتکردنی زانیارییەکان</button>
            </form>
        </div>
    </section>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";
        import { getDatabase, ref, push, set, onValue, remove, update } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

        const firebaseConfig = { apiKey: "AIzaSyAizrzIAwVMDSXdu-Y0LYFDzwQPy79ThEs", authDomain: "ai-platform-adb1b.firebaseapp.com", databaseURL: "https://ai-platform-adb1b-default-rtdb.firebaseio.com", projectId: "ai-platform-adb1b" };
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        const db = getDatabase(app);

        let firebaseDataCache = {};
        let isAdmin = false;
        let editId = null;

        function renderGuide(data) {
            const container = document.getElementById('guide-container');
            if (!container) return;
            container.innerHTML = "";
            for (let id in data) {
                const item = data[id];
                container.innerHTML += `
                    <div class="glass-card p-10 rounded-[2rem] border-l-4 border-teal-500 shadow-lg hover:shadow-2xl transition-all duration-300">
                        <h3 class="font-black text-3xl text-gray-900 dark:text-white mb-6">${item.question_so}</h3>
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed text-lg whitespace-pre-line">${item.answer_so}</p>
                        ${isAdmin ? `
                            <div class="mt-8 flex gap-4">
                                <button onclick="window.editGuide('${id}')" class="px-8 py-3 rounded-xl bg-amber-500 text-white font-black hover:bg-amber-600 transition">دەستکاری</button>
                                <button onclick="window.deleteGuide('${id}')" class="px-8 py-3 rounded-xl bg-red-600 text-white font-black hover:bg-red-700 transition">سڕینەوە</button>
                            </div>` : ''}
                    </div>
                `;
            }
        }

        window.deleteGuide = async (id) => { if(confirm("دڵنیایت لە سڕینەوەی ئەم زانیارییە؟")) await remove(ref(db, 'academic_guide/' + id)); }

        window.editGuide = (id) => {
            const item = firebaseDataCache[id];
            document.getElementById('question_so').value = item.question_so || '';
            document.getElementById('question_ba').value = item.question_ba || '';
            document.getElementById('answer_so').value = item.answer_so || '';
            document.getElementById('answer_ba').value = item.answer_ba || '';
            editId = id;
            document.getElementById('submit-form-btn').innerText = "نوێکردنەوەی زانیارییەکان";
            window.scrollTo({ top: document.getElementById('admin-form-section').offsetTop - 50, behavior: 'smooth' });
        }

        onValue(ref(db, 'academic_guide'), (s) => { firebaseDataCache = s.val() || {}; renderGuide(firebaseDataCache); });

        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = {
                question_so: document.getElementById('question_so').value,
                question_ba: document.getElementById('question_ba').value,
                answer_so: document.getElementById('answer_so').value,
                answer_ba: document.getElementById('answer_ba').value
            };
            if(editId) { await update(ref(db, 'academic_guide/' + editId), data); editId = null; document.getElementById('submit-form-btn').innerText = "پاشەکەوتکردنی زانیارییەکان"; }
            else { await push(ref(db, 'academic_guide'), data); }
            e.target.reset();
            alert("بە سەرکەوتوویی جێبەجێکرا!");
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            document.body.style.display = 'block';
            if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                isAdmin = true;
                document.querySelector('.admin-only').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>