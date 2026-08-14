<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زانیاری چاتبۆت - کورد ئەی ئای</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="/favicon.png" type="image/png">

    <meta name="description" content="بەڕێوەبردنی زانیاری چاتبۆت - کورد ئەی ئای">
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
    </style>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

@include('partials.nav', ['active' => ''])

<main class="max-w-5xl mx-auto px-4 sm:px-6 py-10">

    {{-- سەرپەڕە --}}
    <section class="glass-card rounded-3xl p-6 sm:p-8 mb-6 shadow-xl shadow-gray-200/50 dark:shadow-black/30">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 shrink-0 rounded-2xl bg-gradient-to-br from-indigo-600 to-cyan-500 flex items-center justify-center text-2xl shadow-lg">🧠</div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black">زانیاری چاتبۆت</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">فێرکردنی چاتبۆت بە زانیارییەکانی تۆ — ئەدمین تەنها</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 rounded-2xl bg-indigo-500/10 border border-indigo-500/30 text-center">
                    <div id="kn-stat-total" class="text-xl font-black text-indigo-600 dark:text-cyan-300">0</div>
                    <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400">هەموو</div>
                </div>
                <div class="px-4 py-2 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-center">
                    <div id="kn-stat-active" class="text-xl font-black text-emerald-600 dark:text-emerald-300">0</div>
                    <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400">چالاک</div>
                </div>
                <div class="px-4 py-2 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-center">
                    <div id="kn-stat-inactive" class="text-xl font-black text-rose-600 dark:text-rose-300">0</div>
                    <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400">ناچالاک</div>
                </div>
            </div>
        </div>
        <div id="kn-notice" class="hidden mt-4 px-4 py-3 rounded-2xl bg-amber-500/10 border border-amber-500/40 text-sm font-bold text-amber-700 dark:text-amber-300"></div>
    </section>

    {{-- ئاگاداریی نا-ئەدمین --}}
    <section id="kn-unauthorized" class="hidden">
        <div class="glass-card rounded-3xl p-10 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-rose-500/10 border border-rose-500/30 flex items-center justify-center text-4xl mb-4">⛔</div>
            <h2 class="text-xl font-black mb-1">بەردەست نییە</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-bold">تەنها ئەدمینەکان دەتوانن بگەنە ئەم پەڕەیە.</p>
        </div>
    </section>

    <section id="kn-admin" class="hidden">
        {{-- ڕێنمایی --}}
        <div class="glass-card rounded-3xl p-5 mb-6 border border-indigo-400/40 shadow-lg">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 shrink-0 rounded-xl bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-xl">🎓</div>
                <div>
                    <h3 class="font-black text-base mb-1">چۆنیەتی فێرکردنی چاتبۆت</h3>
                    <ol class="text-sm font-bold text-gray-600 dark:text-gray-300 space-y-1.5 leading-relaxed">
                        <li><span class="text-indigo-600 dark:text-cyan-300 font-black">١.</span> زانیارییەکە دروست بکە و پڕۆمپتەکەت بنووسە (م. فێرکردنی بادینی).</li>
                        <li><span class="text-indigo-600 dark:text-cyan-300 font-black">٢.</span> کرتە لە <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black bg-indigo-500/10 border border-indigo-400/50 text-indigo-600 dark:text-cyan-300">🎓 فێربکە</span> بکە.</li>
                        <li><span class="text-indigo-600 dark:text-cyan-300 font-black">٣.</span> چاتبۆت پرسیارت لێدەکات — وەڵامی بدەرەوە تا باشتر تێبگات.</li>
                        <li><span class="text-indigo-600 dark:text-cyan-300 font-black">٤.</span> کاتێک تەواو بوو، کرتە لە <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-black bg-emerald-500/10 border border-emerald-400/50 text-emerald-600 dark:text-emerald-300">✅ تەواوکردن</span> بکە — دەقی کۆتایی دروست دەبێت و چاتبۆت لە ڕێگەیەوە وەڵامی بەکارهێنەران دەداتەوە.</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- فۆرمی زیادکردن / دەستکاری --}}
        <section id="kn-form-card" class="glass-card rounded-3xl p-6 sm:p-8 mb-6 shadow-xl shadow-gray-200/50 dark:shadow-black/30">
            <h2 id="kn-form-title" class="text-lg font-black mb-5">➕ زیادکردنی زانیاری نوێ</h2>

            <form id="kn-form">
                <input type="hidden" id="kn-id">

                <div class="grid sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="kn-title" class="block text-sm font-black mb-1.5 text-gray-700 dark:text-gray-300">ناونیشان *</label>
                        <input type="text" id="kn-title" required maxlength="255" placeholder="م. زانیاری دەربارەی کۆرسی ..."
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-[#0d1424]/70 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500/50">
                    </div>
                    <div>
                        <label for="kn-keywords" class="block text-sm font-black mb-1.5 text-gray-700 dark:text-gray-300">وشە کلیدەکان (بە کۆما جیا بکەرەوە)</label>
                        <input type="text" id="kn-keywords" maxlength="500" placeholder="کۆرس، دەرچوون، وەرگرتن"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-[#0d1424]/70 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500/50">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="kn-content" class="block text-sm font-black mb-1.5 text-gray-700 dark:text-gray-300">پڕۆمپت / دەقی سەرەتایی <span class="text-xs font-bold text-gray-400">(ئارەزوومەندانە)</span></label>
                    <textarea id="kn-content" rows="6" maxlength="50000" placeholder="م. من دەمەوێت فێرت بکەم بە زمانی بادینی — ڕێزمان، ناوەکان و ڕستەسازی..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-[#0d1424]/70 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500/50 leading-relaxed custom-scrollbar"></textarea>
                    <p class="mt-1 text-[11px] text-gray-400 font-bold">ئەم دەقە تەنها سەرەتایەکی فێرکردنە — دەتوانیت دواتر بە کرتەکردن لە «فێربکە» لە ڕێگەی گفتوگۆوە زیاتر فێری چاتبۆت بکەیت.</p>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-4">
                    <label class="flex items-center gap-2 text-sm font-black cursor-pointer select-none">
                        <input type="checkbox" id="kn-active" checked class="w-5 h-5 rounded accent-emerald-600">
                        چالاک (چاتبۆت ئەم زانیارییە بەکاردەهێنێت)
                    </label>
                    <div class="flex items-center gap-2">
                        <button type="button" id="kn-cancel-edit" class="hidden px-5 py-2.5 rounded-xl text-sm font-black border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">پاشگەزبوونەوە</button>
                        <button type="submit" id="kn-submit" class="px-6 py-2.5 rounded-xl text-sm font-black text-white bg-gradient-to-l from-indigo-600 to-cyan-500 hover:opacity-90 shadow-lg shadow-indigo-500/25 transition-all">پاشەکەوتکردن</button>
                    </div>
                </div>
            </form>
        </section>

        {{-- پەیامی سەرکەوتن --}}
        <div id="kn-toast" class="hidden fixed top-5 right-5 z-[9999] px-5 py-3 rounded-2xl text-sm font-black text-white bg-emerald-600 shadow-2xl" style="direction: rtl;"></div>

        {{-- لیستی زانیارییەکان --}}
        <section class="glass-card rounded-3xl p-6 sm:p-8 shadow-xl shadow-gray-200/50 dark:shadow-black/30">
            <h2 class="text-lg font-black mb-5">📚 زانیارییەکان</h2>
            <div id="kn-list" class="space-y-4"></div>
            <div id="kn-empty" class="hidden flex flex-col items-center justify-center text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl">
                <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4 text-3xl">📭</div>
                <p class="font-bold text-gray-500 dark:text-gray-400">هێشتا هیچ زانیارییەک نەنووسراوە</p>
            </div>
        </section>
    </section>
</main>

{{-- مۆدالی فێرکردنی چاتبۆت --}}
<div id="kn-train-modal" class="hidden fixed inset-0 z-[9998] flex items-center justify-center p-4" style="background: rgba(0,0,0,0.55); backdrop-filter: blur(4px);">
    <div class="w-full max-w-xl glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border border-white/40 dark:border-gray-700 max-h-[85vh] overflow-hidden flex flex-col">
        <div class="flex items-center justify-between gap-4 mb-3 shrink-0">
            <div class="min-w-0">
                <h3 class="text-lg font-black">🎓 فێرکردنی چاتبۆت</h3>
                <p id="kn-train-title" class="text-xs text-gray-500 dark:text-gray-400 font-bold truncate mt-0.5"></p>
            </div>
            <button id="kn-train-close" class="w-9 h-9 rounded-xl bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-black transition-colors shrink-0">✕</button>
        </div>
        <div id="kn-train-messages" class="flex-1 overflow-y-auto custom-scrollbar space-y-3 mb-4 min-h-0">
            <div class="flex items-center justify-center gap-3 py-10">
                <div class="w-6 h-6 rounded-full border-2 border-indigo-500 border-t-transparent animate-spin"></div>
                <span class="text-sm font-bold text-gray-500">دەستپێکردنی گفتوگۆ...</span>
            </div>
        </div>
        <div class="shrink-0">
            <form id="kn-train-form" class="flex items-end gap-2">
                <textarea id="kn-train-input" rows="2" class="flex-1 px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white/70 dark:bg-[#0d1424]/70 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500/50 custom-scrollbar resize-none" placeholder="وەڵامی ئەم پرسیارە بنووسە..." disabled></textarea>
                <button type="submit" id="kn-train-send" disabled class="px-5 py-2.5 rounded-xl text-sm font-black text-white bg-gradient-to-l from-indigo-600 to-cyan-500 hover:opacity-90 shadow-lg shadow-indigo-500/25 transition-all disabled:opacity-40 disabled:cursor-not-allowed">ناردن</button>
            </form>
            <div class="mt-3">
                <button type="button" id="kn-train-finish" class="hidden w-full px-5 py-2.5 rounded-xl text-sm font-black text-white bg-gradient-to-l from-emerald-600 to-teal-500 hover:opacity-90 shadow-lg shadow-emerald-500/25 transition-all">✅ تەواوکردن — دروستکردنی دەقی کۆتایی</button>
            </div>
        </div>
    </div>
</div>

    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="module">
        import { initializeApp, getApps, getApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
        const app = getApps().length ? getApp() : initializeApp(firebaseConfig);
        const auth = getAuth(app);

        let currentLang = localStorage.getItem('site-lang') || 'so';

        function applyLanguage() {
            const langBtnText = document.getElementById('lang-text');
            if (langBtnText) langBtnText.innerText = currentLang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(el => {
                el.innerText = el.getAttribute(`data-${currentLang}`) || el.getAttribute('data-so');
            });
        }

        document.getElementById('lang-toggle').addEventListener('click', () => {
            currentLang = currentLang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', currentLang);
            applyLanguage();
        });

        document.getElementById('theme-toggle').addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        document.getElementById('logout-btn').addEventListener('click', () => signOut(auth).then(() => window.location.href = "/login"));

        /* ================= زانیاری چاتبۆت ================= */

        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

        let knItems = [];

        const KN_L = {
            edit: { so: 'دەستکاری', ba: 'سەرڤێکرن' },
            del: { so: 'سڕینەوە', ba: 'سڕینەوە' },
            delConfirm: { so: 'ئەم زانیارییە بسڕینەوە؟', ba: 'ئەڤ زانیاریە ب سڕینەوە؟' },
            active: { so: 'چالاک', ba: 'چالاک' },
            inactive: { so: 'ناچالاک', ba: 'ناچالاک' },
            train: { so: 'فێربکە', ba: 'فێربکە' },
            trainSteps: { so: 'هەنگاوی فێرکاری', ba: 'گاڤێن فێرکرنێ' },
            saved: { so: '✅ زانیارییەکە پاشەکەوت کرا', ba: '✅ زانیاری پاشەکەوت بوو' },
            deleted: { so: '🗑️ زانیارییەکە سڕایەوە', ba: '🗑️ زانیاری هاتە سڕینەوە' },
            loading: { so: 'ئامادەکردن...', ba: 'ئامادەکرن...' },
            finalizing: { so: 'دروستکردنی دەقی کۆتایی...', ba: 'دروستکرنا دهقی دواهیی...' },
        };

        function knLang() { return (localStorage.getItem('site-lang') || 'so') === 'ba' ? 'ba' : 'so'; }
        function knT(key) { return (KN_L[key] || {})[knLang()] || ''; }

        function esc(v) {
            return String(v == null ? '' : v)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function knToast(msg) {
            const t = document.getElementById('kn-toast');
            if (!t) return;
            t.textContent = msg;
            t.classList.remove('hidden');
            clearTimeout(t._timer);
            t._timer = setTimeout(() => t.classList.add('hidden'), 2600);
        }

        async function knApi(path, opts = {}) {
            const user = auth.currentUser;
            if (!user) return { status: 401, data: {} };
            const idToken = await user.getIdToken();
            const res = await fetch(path, {
                method: opts.method || 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF,
                    'Authorization': 'Bearer ' + idToken,
                    'X-Firebase-Id-Token': idToken,
                    ...(opts.body ? { 'Content-Type': 'application/json' } : {}),
                },
                body: opts.body ? JSON.stringify(opts.body) : undefined,
            });
            let data = {};
            try { data = await res.json(); } catch (e) {}
            return { status: res.status, data };
        }

        function knStatusBadge(active) {
            if (active) {
                return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-600 dark:text-emerald-300 bg-emerald-500/10 border border-emerald-500/40"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>' + esc(knT('active')) + '</span>';
            }
            return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold text-gray-500 bg-gray-500/10 border border-gray-500/40">' + esc(knT('inactive')) + '</span>';
        }

        function knItemHTML(k) {
            const preview = (k.content || '').length > 200 ? (k.content || '').slice(0, 200) + '…' : (k.content || '');
            return '<div class="rounded-2xl border ' + (k.active ? 'border-indigo-400/40 bg-indigo-50/40 dark:bg-indigo-900/10' : 'border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-[#0d1424]/70') + ' p-5 transition-all">' +
                '<div class="flex items-start justify-between gap-4 mb-3">' +
                '<div class="flex items-center gap-3 min-w-0">' +
                knStatusBadge(k.active) +
                '<h3 class="font-black text-gray-900 dark:text-white truncate">' + esc(k.title) + '</h3>' +
                '</div>' +
                '<span class="text-[11px] text-gray-400 font-bold shrink-0 whitespace-nowrap" dir="ltr">' + esc(k.updated_raw || '') + '</span>' +
                '</div>' +
                (k.keywords ? '<div class="mb-3 flex flex-wrap gap-1.5">' + String(k.keywords).split(/[,،]/).filter(Boolean).map(w => '<span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-cyan-500/10 border border-cyan-500/30 text-cyan-700 dark:text-cyan-300">#' + esc(w.trim()) + '</span>').join('') + '</div>' : '') +
                '<p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed break-words whitespace-pre-wrap">' + esc(preview) + '</p>' +
                (k.training && k.training.length ? '<div class="mt-3"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold text-cyan-600 dark:text-cyan-300 bg-cyan-500/10 border border-cyan-500/40">🎓 ' + esc(knT('trainSteps')) + ': ' + k.training.length + '</span></div>' : '') +
                '<div class="mt-4 flex items-center flex-wrap gap-2">' +
                '<button type="button" class="kn-train-btn px-3 py-1.5 rounded-lg text-[11px] font-bold text-indigo-600 dark:text-cyan-300 border border-indigo-400/50 hover:bg-indigo-500/10 transition-all" data-id="' + k.id + '">🎓 ' + esc(knT('train')) + '</button>' +
                '<button type="button" class="kn-edit-btn px-3 py-1.5 rounded-lg text-[11px] font-bold text-amber-600 border border-amber-400/50 hover:bg-amber-500/10 transition-all" data-id="' + k.id + '">✏️ ' + esc(knT('edit')) + '</button>' +
                '<button type="button" class="kn-toggle-btn px-3 py-1.5 rounded-lg text-[11px] font-bold text-cyan-600 border border-cyan-400/50 hover:bg-cyan-500/10 transition-all" data-id="' + k.id + '">' + (k.active ? '⏸ ناچالاک' : '▶️ چالاک') + '</button>' +
                '<button type="button" class="kn-del-btn px-3 py-1.5 rounded-lg text-[11px] font-bold text-rose-600 border border-rose-400/50 hover:bg-rose-500/10 transition-all" data-id="' + k.id + '">🗑️ ' + esc(knT('del')) + '</button>' +
                '</div>' +
                '</div>';
        }

        function knRender(data) {
            const list = document.getElementById('kn-list');
            const empty = document.getElementById('kn-empty');
            const notice = document.getElementById('kn-notice');
            const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };
            set('kn-stat-total', data.stats.total);
            set('kn-stat-active', data.stats.active);
            set('kn-stat-inactive', data.stats.inactive);

            if (notice) {
                if (data.notice) {
                    notice.textContent = '⚠️ ' + data.notice;
                    notice.classList.remove('hidden');
                } else {
                    notice.classList.add('hidden');
                }
            }

            const items = data.items || [];
            knItems = items;
            if (!items.length) {
                if (list) list.innerHTML = '';
                if (empty) empty.classList.remove('hidden');
                return;
            }
            if (empty) empty.classList.add('hidden');
            if (list) {
                list.innerHTML = items.map(knItemHTML).join('');
                list.querySelectorAll('.kn-edit-btn').forEach(b => b.addEventListener('click', () => knStartEdit(b.dataset.id)));
                list.querySelectorAll('.kn-toggle-btn').forEach(b => b.addEventListener('click', () => knToggle(b.dataset.id)));
                list.querySelectorAll('.kn-del-btn').forEach(b => b.addEventListener('click', () => {
                    if (!confirm(knT('delConfirm'))) return;
                    knDelete(b.dataset.id);
                }));
                list.querySelectorAll('.kn-train-btn').forEach(b => b.addEventListener('click', () => knTrainOpen(b.dataset.id)));
            }
        }

        async function knLoad() {
            const { status, data } = await knApi('/api/knowledge');
            if (status === 403) {
                document.getElementById('kn-admin')?.classList.add('hidden');
                document.getElementById('kn-unauthorized')?.classList.remove('hidden');
                return;
            }
            if (status !== 200 || !data.items) return;
            document.getElementById('kn-unauthorized')?.classList.add('hidden');
            document.getElementById('kn-admin')?.classList.remove('hidden');
            knRender(data);
        }

        function knCount() {
            const el = document.getElementById('kn-content');
            if (el) {
                const hint = el.nextElementSibling;
                if (hint) hint.textContent = (el.value || '').length + ' / 50000 — ئەم دەقە تەنها سەرەتایەکی فێرکردنە.';
            }
        }

        function knResetForm() {
            document.getElementById('kn-id').value = '';
            document.getElementById('kn-title').value = '';
            document.getElementById('kn-keywords').value = '';
            document.getElementById('kn-content').value = '';
            document.getElementById('kn-active').checked = true;
            document.getElementById('kn-cancel-edit')?.classList.add('hidden');
            document.getElementById('kn-form-title').textContent = '➕ زیادکردنی زانیاری نوێ';
            document.getElementById('kn-submit').textContent = 'پاشەکەوتکردن';
            knCount();
        }

        function knStartEdit(id) {
            const item = knItems.find(i => String(i.id) === String(id));
            if (!item) return;
            document.getElementById('kn-id').value = item.id;
            document.getElementById('kn-title').value = item.title;
            document.getElementById('kn-keywords').value = item.keywords || '';
            document.getElementById('kn-content').value = item.content;
            document.getElementById('kn-active').checked = !!item.active;
            document.getElementById('kn-cancel-edit')?.classList.remove('hidden');
            document.getElementById('kn-form-title').textContent = '✏️ دەستکاری زانیاری';
            document.getElementById('kn-submit').textContent = 'پاشەکەوتکردنی دەستکاری';
            knCount();
            document.getElementById('kn-form-card')?.scrollIntoView({ behavior: 'smooth' });
        }

        async function knToggle(id) {
            const { status } = await knApi('/api/knowledge/' + id + '/toggle', { method: 'PATCH' });
            if (status === 200) knLoad();
        }

        async function knDelete(id) {
            const { status } = await knApi('/api/knowledge/' + id, { method: 'DELETE' });
            if (status === 200) {
                knToast(knT('deleted'));
                knLoad();
            }
        }

        function knMsgHTML(role, text, thinking) {
            const isBot = role === 'bot';
            return '<div class="flex ' + (isBot ? 'justify-start' : 'justify-end') + '">' +
                '<div class="max-w-[85%] rounded-2xl px-4 py-2.5 text-sm font-bold leading-relaxed whitespace-pre-wrap break-words ' +
                (isBot ? 'bg-indigo-500/10 border border-indigo-500/20 text-gray-800 dark:text-gray-100' : 'bg-gradient-to-l from-indigo-600 to-cyan-500 text-white') + '">' +
                (isBot ? '🤖 ' : '') + (thinking ? '<span class="inline-flex items-center gap-1.5"><span class="w-4 h-4 rounded-full border-2 border-indigo-500 border-t-transparent animate-spin"></span>' + esc(knT('loading')) + '</span>' : esc(text)) +
                '</div></div>';
        }

        async function knTrainOpen(id) {
            const modal = document.getElementById('kn-train-modal');
            const msgs = document.getElementById('kn-train-messages');
            const input = document.getElementById('kn-train-input');
            const send = document.getElementById('kn-train-send');
            const finish = document.getElementById('kn-train-finish');
            if (!modal || !msgs) return;
            const item = knItems.find(i => String(i.id) === String(id));
            const ttl = document.getElementById('kn-train-title');
            if (ttl) ttl.textContent = item ? item.title : ('#' + id);
            msgs.innerHTML = '<div class="flex items-center justify-center gap-3 py-10"><div class="w-6 h-6 rounded-full border-2 border-indigo-500 border-t-transparent animate-spin"></div><span class="text-sm font-bold text-gray-500">' + esc(knT('loading')) + '</span></div>';
            modal.classList.remove('hidden');
            input.disabled = true;
            send.disabled = true;
            finish.classList.add('hidden');
            if (input) {
                input.value = '';
                input.dataset.id = String(id);
            }
            const { status, data } = await knApi('/api/knowledge/' + id + '/train', { method: 'POST', body: { message: item && item.content ? item.content : '' } });
            if (status !== 200) {
                msgs.innerHTML = '<p class="text-sm font-bold text-rose-600 text-center py-8">' + esc(data.error || 'هەڵەیەک ڕوویدا') + '</p>';
                return;
            }
            msgs.innerHTML = '';
            (item && item.content ? data.training.slice(0, 1) : []).forEach(m => msgs.insertAdjacentHTML('beforeend', knMsgHTML(m.role === 'assistant' ? 'bot' : 'user', m.content)));
            msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', data.reply));
            input.disabled = false;
            send.disabled = false;
            input.focus();
            msgs.scrollTop = msgs.scrollHeight;
        }

        function knTrainBusy(b) {
            const input = document.getElementById('kn-train-input');
            const send = document.getElementById('kn-train-send');
            if (input) input.disabled = b;
            if (send) send.disabled = b;
        }

        async function knTrainSend(id, msg) {
            const msgs = document.getElementById('kn-train-messages');
            if (!msgs) return;
            msgs.insertAdjacentHTML('beforeend', knMsgHTML('user', msg));
            msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', '', true));
            msgs.scrollTop = msgs.scrollHeight;
            knTrainBusy(true);
            const { status, data } = await knApi('/api/knowledge/' + id + '/train', { method: 'POST', body: { message: msg } });
            msgs.querySelector('.animate-spin')?.closest('.flex')?.remove();
            knTrainBusy(false);
            if (status !== 200) {
                msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', data.error || 'هەڵەیەک ڕوویدا'));
                return;
            }
            msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', data.reply));
            msgs.scrollTop = msgs.scrollHeight;
            document.getElementById('kn-train-finish')?.classList.remove('hidden');
        }

        async function knTrainFinish(id) {
            const msgs = document.getElementById('kn-train-messages');
            const finish = document.getElementById('kn-train-finish');
            if (!msgs || !finish) return;
            finish.disabled = true;
            msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', knT('finalizing'), true));
            msgs.scrollTop = msgs.scrollHeight;
            const { status, data } = await knApi('/api/knowledge/' + id + '/finalize', { method: 'POST' });
            msgs.querySelector('.animate-spin')?.closest('.flex')?.remove();
            finish.disabled = false;
            if (status === 200 && data.knowledge) {
                msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', '✅ دەقی کۆتایی دروست کرا و بە ئامادەیی چالاک کرا.'));
                finish.classList.add('hidden');
                document.getElementById('kn-train-input')?.setAttribute('disabled', '');
                document.getElementById('kn-train-send')?.setAttribute('disabled', '');
                setTimeout(() => { document.getElementById('kn-train-modal')?.classList.add('hidden'); knLoad(); }, 1800);
            } else {
                msgs.insertAdjacentHTML('beforeend', knMsgHTML('bot', data.error || 'هەڵەیەک ڕوویدا'));
            }
        }

        function knBind() {
            const form = document.getElementById('kn-form');
            const cancelBtn = document.getElementById('kn-cancel-edit');
            const content = document.getElementById('kn-content');
            const modal = document.getElementById('kn-train-modal');
            const trainForm = document.getElementById('kn-train-form');
            if (content) content.addEventListener('input', knCount);

            form?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = document.getElementById('kn-id').value;
                const payload = {
                    title: document.getElementById('kn-title').value.trim(),
                    keywords: document.getElementById('kn-keywords').value.trim(),
                    content: document.getElementById('kn-content').value.trim(),
                    active: document.getElementById('kn-active').checked,
                };
                if (!payload.title) return;
                const btn = document.getElementById('kn-submit');
                btn.disabled = true;
                btn.style.opacity = '0.6';
                const { status, data } = await knApi('/api/knowledge' + (id ? '/' + id : ''), { method: id ? 'PUT' : 'POST', body: payload });
                btn.disabled = false;
                btn.style.opacity = '1';
                if (status === 200 && data.success) {
                    knToast(knT('saved'));
                    knResetForm();
                    knLoad();
                } else {
                    knToast(data.message || 'هەڵەیەک ڕوویدا');
                }
            });

            cancelBtn?.addEventListener('click', knResetForm);
            document.getElementById('kn-train-close')?.addEventListener('click', () => modal?.classList.add('hidden'));
            modal?.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });
            trainForm?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const input = document.getElementById('kn-train-input');
                if (!input || input.disabled || !input.value.trim()) return;
                const msg = input.value.trim();
                input.value = '';
                const id = input.dataset.id;
                if (!id) return;
                await knTrainSend(id, msg);
            });
            document.getElementById('kn-train-input')?.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (trainForm) trainForm.requestSubmit();
                }
            });
            document.getElementById('kn-train-finish')?.addEventListener('click', async (e) => {
                const input = document.getElementById('kn-train-input');
                const id = input?.dataset.id;
                if (!id) return;
                await knTrainFinish(id);
            });
        }

        onAuthStateChanged(auth, (user) => {
            if (!user) { window.location.href = "/login"; return; }
            /* body visible instantly */
            applyLanguage();
            knResetForm();
            knBind();
            knLoad();
        });
    </script>
    @include('components.chat-widget')
</body>
</html>
