<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class="lang-str" data-so="ڕێنیشاندەری ئەکادیمی - کورد ئەی ئای" data-ba="ڕێبەرێ ئەکادیمی - کورد ئەی ئای">ڕێنیشاندەری ئەکادیمی - کورد ئەی ئای</title>
    
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    
    <meta name="description" content="ڕێنیشاندەری ئەکادیمی کورد ئەی ئای - ڕێنمایی زانکۆ و خوێندن">
    <meta name="keywords" content="ڕێنیشاندەر, ئەکادیمی, زانکۆ, کورد ئەی ئای, خوێندن">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://kurd-ai.com/academic-guide">
    <meta property="og:title" content="ڕێنیشاندەری ئەکادیمی - KURD AI">
    <meta property="og:description" content="ڕێنمایی زانکۆ و خوێندن بۆ خوێندکارانی کورد">
    <meta property="og:image" content="https://kurd-ai.com/logo.jpg">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://kurd-ai.com/academic-guide">
    <meta property="twitter:title" content="ڕێنیشاندەری ئەکادیمی - KURD AI">
    <meta property="twitter:description" content="ڕێنمایی زانکۆ و خوێندن بۆ خوێندکارانی کورد">
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
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-[#0a0f1c]/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-800/50 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 transition group relative">
                <div class="relative flex-shrink-0">
                    <div class="absolute -inset-2 bg-gradient-to-r from-teal-600 to-cyan-400 rounded-full blur-xl opacity-0 group-hover:opacity-30 transition-all duration-300 dark:group-hover:opacity-50"></div>
                    <img src="logo.jpg" alt="Kurd AI Logo" class="h-10 md:h-11 w-auto object-contain dark:invert drop-shadow-md group-hover:scale-105 transition-transform duration-300 relative z-10">
                </div>
                <div class="flex flex-col justify-center hidden sm:flex">
                    <h1 class="text-xl md:text-2xl font-black tracking-tight text-gray-900 dark:text-white leading-none group-hover:text-teal-600 dark:group-hover:text-cyan-400 transition-colors duration-300">KURD AI</h1>
                    <span class="text-[0.55rem] md:text-[0.60rem] font-black tracking-widest bg-clip-text text-transparent bg-gradient-to-r from-teal-600 to-cyan-500 mt-0.5">INNOVATION - FUTURE</span>
                </div>
            </a>

            <div class="hidden lg:flex items-center space-x-reverse space-x-1 bg-gray-100/50 dark:bg-gray-800/50 p-1.5 rounded-2xl border border-gray-200/50 dark:border-gray-700/50">
                <a href="/" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">سەرەکی</a>
                <a href="/ferga" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">فێرگە</a>
                <a href="/courses" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">کۆرسەکان</a>
                <a href="/news" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">هەواڵەکان</a>
                <a href="/ai-tools" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">تووڵەکان</a>
                <a href="/academic-guide" class="px-3.5 py-2 bg-white dark:bg-gray-700 text-teal-600 dark:text-teal-400 font-bold rounded-xl shadow-sm transition text-sm">ڕێنیشاندەر</a>
                <a href="/universities" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">زانکۆکان</a>
                <a href="/about" class="px-3.5 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-teal-600 dark:hover:text-teal-400 rounded-xl transition text-sm">دەربارەی ئێمە</a>
            </div>

            <div class="flex items-center gap-2.5">
                <button id="lang-toggle" class="px-3 py-2 bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 font-bold rounded-xl text-xs border border-teal-100 dark:border-teal-800/50 hover:bg-teal-100 transition"><span id="lang-text">Badini</span></button>
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">🌙</button>
                <a href="/profile" class="hidden sm:flex items-center gap-2 px-3.5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-xl text-xs hover:bg-gray-200 transition border border-gray-200/50 dark:border-gray-700/50">هەژمارەکەم</a>
                <button id="logout-btn" class="flex items-center gap-1.5 px-3.5 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 font-bold rounded-xl text-xs hover:bg-red-100 transition border border-red-100 dark:border-red-800/50">دەرچوون</button>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="relative py-24 text-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 -left-4 w-96 h-96 bg-teal-400 dark:bg-teal-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[128px] opacity-20 animate-blob"></div>
            <div class="absolute -bottom-8 right-20 w-96 h-96 bg-cyan-400 dark:bg-cyan-600 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-[128px] opacity-20 animate-blob animation-delay-2000"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="inline-flex items-center gap-2 px-6 py-2 rounded-full bg-teal-50 dark:bg-teal-900/30 border border-teal-200 dark:border-teal-700/50 text-teal-700 dark:text-teal-300 font-black text-sm mb-8 shadow-sm">
                <span>زانیارییە ئەکادیمییەکان و ڕێنمایی زانکۆ</span>
            </div>
            <h2 class="text-5xl md:text-7xl font-black mb-6 text-gray-900 dark:text-white tracking-tight">ڕێنیشاندەری ئەکادیمی</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto font-medium">هەموو ئەو پرس و ڕاوێژ و زانیارییانەی پێویستتە بۆ سەرکەوتن لە پرۆسەی خوێندنت لێرە بە شێوازێکی ڕوون بدۆزەرەوە.</p>
        </div>
    </header>

    <!-- Guide Content -->
    <section class="container mx-auto pb-24 px-4 max-w-4xl">
        <div id="guide-container" class="space-y-6">
            <!-- لێرە پرسیار و وەڵامەکان بە دیزاینی پێشکەوتوو دەردەکەون -->
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
                <button type="submit" id="submit-form-btn" class="w-full bg-gradient-to-r from-teal-600 to-cyan-600 text-white py-5 rounded-2xl font-black text-xl hover:shadow-2xl hover:shadow-teal-500/30 hover:-translate-y-1 transition-all">پاشەکەوتکردنی زانیارییەکان</button>
            </form>
        </div>
    </section>

    <!-- پەنجەرەی دەستکاری کردنی ڕێنیشاندەر (Modal) -->
    <div id="editGuideModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="window.closeEditGuideModal()"></div>
        <div class="glass-card relative w-full max-w-2xl rounded-[2rem] p-6 md:p-8 shadow-2xl transform transition-all translate-y-4 opacity-0 overflow-y-auto max-h-[90vh]" id="editGuideModalContent">
            <button onclick="window.closeEditGuideModal()" class="absolute top-5 left-5 p-2 bg-gray-100 dark:bg-gray-800 text-gray-500 hover:text-red-500 rounded-full transition z-10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-2">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 text-center">دەستکاری کردنی ڕێنیشاندەر</h3>
                <form id="edit-guide-form" class="space-y-5">
                    <input type="hidden" id="edit-guide-id">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (سۆرانی)</label>
                            <input type="text" id="edit_guide_question_so" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">پرسیار (بادینی)</label>
                            <input type="text" id="edit_guide_question_ba" required class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all text-sm">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">وەڵام (سۆرانی)</label>
                            <textarea id="edit_guide_answer_so" required rows="4" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 font-bold text-sm mb-1">وەڵام (بادینی)</label>
                            <textarea id="edit_guide_answer_ba" required rows="4" class="w-full px-4 py-3 bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-teal-500 focus:outline-none transition-all text-sm resize-none"></textarea>
                        </div>
                    </div>
                    <button type="submit" id="edit-guide-submit-btn" class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-3.5 rounded-xl font-black hover:shadow-lg hover:shadow-teal-500/30 hover:-translate-y-0.5 transition-all">پاشەکەوتکردن</button>
                </form>
            </div>
        </div>
    </div>

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
        let currentLang = localStorage.getItem('site-lang') || 'so';

        function renderGuide(data) {
            const container = document.getElementById('guide-container');
            if (!container) return;
            container.innerHTML = "";
            
            if (!data || Object.keys(data).length === 0) {
                container.innerHTML = `<div class="text-center py-20 glass-card rounded-3xl"><p class="text-gray-500 font-bold text-lg">هێشتا هیچ زانیارییەک لە ڕێنیشاندەردا نەهاتووە.</p></div>`;
                return;
            }

            for (let id in data) {
                const item = data[id];
                const question = currentLang === 'ba' && item.question_ba ? item.question_ba : item.question_so;
                const answer = currentLang === 'ba' && item.answer_ba ? item.answer_ba : item.answer_so;
                const btnTextShow = currentLang === 'so' ? 'پیشاندانی وەڵام' : 'نیشادانا بەرسڤێ';
                const btnTextHide = currentLang === 'so' ? 'شارنەوەی وەڵام' : 'ڤەشارتنا بەرسڤێ';

                container.innerHTML += `
                    <div class="glass-card rounded-[2rem] p-6 md:p-8 shadow-xl hover:shadow-2xl transition-all duration-300 border border-gray-200/50 dark:border-gray-700/50">
                        <div class="flex items-start justify-between gap-4 cursor-pointer" onclick="window.toggleAnswer('${id}')">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-teal-500/10 dark:bg-teal-500/20 text-teal-600 dark:text-teal-400 flex items-center justify-center font-black text-xl flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="font-black text-xl md:text-2xl text-gray-900 dark:text-white">${question}</h3>
                            </div>
                            <button id="btn-text-${id}" class="px-4 py-2 rounded-xl bg-teal-50 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 font-bold text-xs hover:bg-teal-100 transition flex items-center gap-2 flex-shrink-0">
                                <span id="label-${id}">${btnTextShow}</span>
                                <svg id="icon-${id}" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                        </div>

                        <div id="answer-${id}" class="hidden mt-6 pt-6 border-t border-gray-200/50 dark:border-gray-700/50 text-gray-600 dark:text-gray-300 leading-loose text-base md:text-lg whitespace-pre-line animate-fadeIn">
                            ${answer}
                        </div>

                        ${isAdmin ? `
                            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-800 flex gap-3">
                                <button onclick="window.editGuide('${id}')" class="px-5 py-2.5 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold text-xs hover:bg-amber-500 hover:text-white transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    دەستکاری
                                </button>
                                <button onclick="window.deleteGuide('${id}')" class="px-5 py-2.5 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 font-bold text-xs hover:bg-red-500 hover:text-white transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    سڕینەوە
                                </button>
                            </div>` : ''}
                    </div>
                `;
            }
        }

        window.toggleAnswer = (id) => {
            const answerEl = document.getElementById(`answer-${id}`);
            const iconEl = document.getElementById(`icon-${id}`);
            const labelEl = document.getElementById(`label-${id}`);
            const btnTextShow = currentLang === 'so' ? 'پیشاندانی وەڵام' : 'نیشادانا بەرسڤێ';
            const btnTextHide = currentLang === 'so' ? 'شارنەوەی وەڵام' : 'ڤەشارتنا بەرسڤێ';

            if (answerEl.classList.contains('hidden')) {
                answerEl.classList.remove('hidden');
                iconEl.classList.add('rotate-180');
                labelEl.innerText = btnTextHide;
            } else {
                answerEl.classList.add('hidden');
                iconEl.classList.remove('rotate-180');
                labelEl.innerText = btnTextShow;
            }
        };

        window.deleteGuide = async (id) => { 
            if(confirm("دڵنیایت لە سڕینەوەی ئەم زانیارییە؟")) await remove(ref(db, 'academic_guide/' + id)); 
        }

        window.editGuide = (id) => {
            const item = firebaseDataCache[id];
            if (!item) return;
            editId = id;

            document.getElementById('edit-guide-id').value = id;
            document.getElementById('edit_guide_question_so').value = item.question_so || '';
            document.getElementById('edit_guide_question_ba').value = item.question_ba || '';
            document.getElementById('edit_guide_answer_so').value = item.answer_so || '';
            document.getElementById('edit_guide_answer_ba').value = item.answer_ba || '';

            const modal = document.getElementById('editGuideModal');
            const content = document.getElementById('editGuideModalContent');
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-4', 'opacity-0');
                content.classList.add('translate-y-0', 'opacity-100');
            }, 10);
        };

        window.closeEditGuideModal = function() {
            const modal = document.getElementById('editGuideModal');
            const content = document.getElementById('editGuideModalContent');
            content.classList.remove('translate-y-0', 'opacity-100');
            content.classList.add('translate-y-4', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        document.getElementById('edit-guide-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const guideId = document.getElementById('edit-guide-id').value;
            if (!guideId) return;

            const submitBtn = document.getElementById('edit-guide-submit-btn');
            submitBtn.innerText = "خەریکە پاشەکەوت دەکرێت...";
            submitBtn.classList.add('opacity-70', 'cursor-wait');

            try {
                await update(ref(db, 'academic_guide/' + guideId), {
                    question_so: document.getElementById('edit_guide_question_so').value,
                    question_ba: document.getElementById('edit_guide_question_ba').value,
                    answer_so: document.getElementById('edit_guide_answer_so').value,
                    answer_ba: document.getElementById('edit_guide_answer_ba').value
                });

                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                window.closeEditGuideModal();
                alert('زانیارییەکە بە سەرکەوتوویی پاشەکەوت کرا');
            } catch (error) {
                submitBtn.innerText = "پاشەکەوتکردن";
                submitBtn.classList.remove('opacity-70', 'cursor-wait');
                alert('هەڵەیەک ڕوویدا: ' + error.message);
            }
        });

        onValue(ref(db, 'academic_guide'), (s) => { 
            firebaseDataCache = s.val() || {}; 
            renderGuide(firebaseDataCache); 
        });

        document.getElementById('upload-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const data = {
                question_so: document.getElementById('question_so').value,
                question_ba: document.getElementById('question_ba').value,
                answer_so: document.getElementById('answer_so').value,
                answer_ba: document.getElementById('answer_ba').value
            };
            if(editId) { 
                await update(ref(db, 'academic_guide/' + editId), data); 
                editId = null; 
                document.getElementById('submit-form-btn').innerText = "پاشەکەوتکردنی زانیارییەکان"; 
            } else { 
                await push(ref(db, 'academic_guide'), data); 
            }
            e.target.reset();
            alert("بە سەرکەوتوویی جێبەجێکرا!");
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

        // Language Toggle
        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            document.getElementById('lang-text').innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            renderGuide(firebaseDataCache);
        });

        onAuthStateChanged(auth, (user) => {
            if(!user) window.location.href = "/login";
            document.body.style.display = 'block';
            document.getElementById('lang-text').innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            if(["team@kurd-ai.com", "mahamadkamaran890@gmail.com"].includes(user.email)) {
                isAdmin = true;
                document.querySelector('.admin-only').classList.remove('hidden');
                renderGuide(firebaseDataCache);
            }
        });
    </script>
@include('components.chat-widget')
</body>
</html>