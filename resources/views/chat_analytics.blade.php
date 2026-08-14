<!doctype html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>شیکردنەوە و مێژووی گفتوگۆ - KURD AI</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;600;800;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;600;800;900&display=swap"></noscript>
    <style>
        body{font-family:'Noto Sans Arabic',sans-serif;background:#070b16;color:#edf7ff}
        .glass{background:linear-gradient(135deg,rgba(15,23,42,.88),rgba(20,15,48,.76));border:1px solid rgba(94,234,212,.18);backdrop-filter:blur(18px)}
        .metric{background:rgba(15,23,42,.62);border:1px solid rgba(148,163,184,.13)}
        .bar{height:9px;border-radius:99px;background:linear-gradient(90deg,#5eead4,#a78bfa);box-shadow:0 0 15px rgba(94,234,212,.25)}
        .user-row,.session-row{cursor:pointer;transition:all .2s}
        .user-row:hover,.session-row:hover{background:rgba(45,212,191,.07);border-color:rgba(94,234,212,.35)}
        .msg{max-width:80%;padding:10px 14px;border-radius:14px;font-size:13.5px;line-height:1.7;white-space:pre-wrap;word-break:break-word;border:1px solid rgba(148,163,184,.15)}
        .msg.user{background:rgba(8,47,73,.85);border-color:rgba(94,234,212,.3);align-self:flex-start}
        .msg.bot{background:rgba(37,25,75,.72);border-color:rgba(167,139,250,.32);align-self:flex-end}
        .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:800}
    </style>
</head>
<body class="min-h-screen">
    <main class="max-w-6xl mx-auto px-4 py-8 md:py-12">
        <header class="glass rounded-[2rem] p-6 md:p-8 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-5">
                <div>
                    <div class="text-xs font-black tracking-[.18em] text-teal-300 mb-2">KURD AI / PRIVATE INSIGHT</div>
                    <h1 class="text-3xl md:text-5xl font-black">ئامار و مێژووی گفتوگۆکان</h1>
                    <p class="text-slate-400 mt-3 text-sm md:text-base">هەموو گفتوگۆکان بەپێی ئیمێڵی بەکارهێنەران — تەنها بۆ خاوەنی پلاتفۆرم.</p>
                </div>
                <div class="px-4 py-3 rounded-2xl bg-emerald-400/10 border border-emerald-300/20 text-emerald-200 text-sm font-bold">تەنها بۆ خاوەنەکە</div>
            </div>
        </header>

        <section id="loading" class="glass rounded-[2rem] p-10 text-center text-slate-400">داتا بار دەکرێت...</section>
        <section id="unauthorized" class="hidden glass rounded-[2rem] p-12 text-center">
            <h2 class="text-2xl font-black text-rose-300">ئەم داشبۆردە تایبەتە</h2>
            <p class="text-slate-400 mt-3">تەنها خاوەنی پلاتفۆرم دەتوانێت ئەم ئامارانە ببینێت.</p>
        </section>

        <section id="dashboard" class="hidden">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-5 mb-6">
                <div class="metric rounded-2xl p-5"><div class="text-slate-400 text-xs font-bold">کۆی گفتوگۆکان</div><strong id="sessions" class="block text-3xl mt-2 text-teal-300">0</strong></div>
                <div class="metric rounded-2xl p-5"><div class="text-slate-400 text-xs font-bold">هەموو پەیامەکان</div><strong id="messages" class="block text-3xl mt-2 text-violet-300">0</strong></div>
                <div class="metric rounded-2xl p-5"><div class="text-slate-400 text-xs font-bold">پرسیارەکان</div><strong id="user-messages" class="block text-3xl mt-2 text-cyan-300">0</strong></div>
                <div class="metric rounded-2xl p-5"><div class="text-slate-400 text-xs font-bold">دوایین چالاکی</div><strong id="last-activity" class="block text-sm mt-3 text-emerald-300">-</strong></div>
            </div>
            <div class="grid lg:grid-cols-2 gap-6 mb-6">
                <section class="glass rounded-[2rem] p-6">
                    <h2 class="text-xl font-black mb-5">بابەتە زۆر بەکارهاتووەکان</h2>
                    <div id="topics" class="space-y-4"></div>
                </section>
                <section class="glass rounded-[2rem] p-6">
                    <h2 class="text-xl font-black mb-5">وشە زۆر دووبارەکراوەکان</h2>
                    <div id="words" class="flex flex-wrap gap-2"></div>
                </section>
            </div>

            <section class="glass rounded-[2rem] p-6 mb-6">
                <h2 class="text-xl font-black mb-5">بەکارهێنەران (بەپێی ئیمێڵ)</h2>
                <div id="users" class="space-y-2"></div>
            </section>

            <section class="glass rounded-[2rem] p-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <h2 class="text-xl font-black">مێژووی هەموو گفتوگۆکان</h2>
                    <input id="conv-search" placeholder="گەڕان لە گفتوگۆکان بە ئیمێڵ یان ناونیشان..." class="flex-1 min-w-[220px] max-w-sm px-4 py-2 rounded-xl text-sm bg-[#0a1020] border border-slate-700 outline-none focus:border-teal-400">
                </div>
                <div id="sessions-list" class="space-y-2"></div>
            </section>

            <section id="conv-viewer" class="hidden glass rounded-[2rem] p-6 mt-6">
                <div class="flex items-center justify-between gap-3 mb-5">
                    <h2 id="conv-title" class="text-xl font-black"></h2>
                    <button id="conv-back" class="px-4 py-2 rounded-xl text-sm font-bold bg-slate-800 hover:bg-slate-700 border border-slate-600">بۆ پێشەوە</button>
                </div>
                <div id="conv-meta" class="flex flex-wrap gap-2 mb-5"></div>
                <div id="conv-messages" class="flex flex-col gap-3"></div>
            </section>
        </section>
    </main>
    <script type="application/json" id="firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="module">
        import { initializeApp } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js';
        import { getAuth, onAuthStateChanged } from 'https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js';
        const config = JSON.parse(document.getElementById('firebase-config').textContent || '{}');
        const auth = getAuth(initializeApp(config));
        const loading = document.getElementById('loading');
        const unauthorized = document.getElementById('unauthorized');
        const dashboard = document.getElementById('dashboard');
        const number = value => Number(value || 0).toLocaleString('ckb-IQ');
        const esc = text => String(text ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
        let DATA = null;

        async function load(user) {
            if (!user) { loading.classList.add('hidden'); unauthorized.classList.remove('hidden'); return; }
            const token = await user.getIdToken();
            const response = await fetch('/api/admin/chat-analytics', {headers:{Accept:'application/json',Authorization:'Bearer '+token,'X-Firebase-Id-Token':token}});
            loading.classList.add('hidden');
            if (response.status === 403) { unauthorized.classList.remove('hidden'); return; }
            if (!response.ok) { unauthorized.classList.remove('hidden'); unauthorized.querySelector('p').textContent='کێشەیەک لە هێنانی ئامارەکان ڕوویدا.'; return; }
            DATA = await response.json();
            dashboard.classList.remove('hidden');
            document.getElementById('sessions').textContent=number(DATA.sessions);
            document.getElementById('messages').textContent=number(DATA.messages);
            document.getElementById('user-messages').textContent=number(DATA.user_messages);
            document.getElementById('last-activity').textContent=DATA.last_activity || '-';
            const maxTopic=Math.max(1,...(DATA.topics||[]).map(x=>x.count));
            document.getElementById('topics').innerHTML=(DATA.topics||[]).map(x=>`<div><div class="flex justify-between text-sm font-bold mb-1"><span>${esc(x.label)}</span><span class="text-teal-300">${number(x.count)}</span></div><div class="h-2 rounded-full bg-slate-800 overflow-hidden"><div class="bar" style="width:${Math.max(3,x.count/maxTopic*100)}%"></div></div></div>`).join('') || '<p class="text-slate-400">هێشتا داتا نییە.</p>';
            document.getElementById('words').innerHTML=(DATA.top_words||[]).map(x=>`<span class="px-3 py-2 rounded-xl bg-teal-300/10 border border-teal-300/20 text-teal-100 text-sm font-bold">${esc(x.word)} <b class="text-teal-300">${number(x.count)}</b></span>`).join('') || '<p class="text-slate-400">هێشتا داتا نییە.</p>';
            renderUsers(); renderConversations();
        }

        function renderUsers() {
            const el = document.getElementById('users');
            const users = DATA.users || [];
            if (!users.length) { el.innerHTML = '<p class="text-slate-400">هێشتا بەکارهێنەر نییە.</p>'; return; }
            el.innerHTML = users.map((u,i)=>`
                <div class="user-row flex flex-wrap items-center gap-3 px-4 py-3 rounded-2xl border border-slate-700/60 bg-slate-800/30" data-index="${i}">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-violet-500 flex items-center justify-center text-black font-black text-sm">${esc((u.email||u.identity||'؟').slice(0,1))}</div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold truncate">${esc(u.email || u.identity)}</div>
                        <div class="text-xs text-slate-400">${u.email ? '' : 'بێ ئیمێڵ (سەردانکەر) — '}دوایین چالاکی: ${esc(u.last_activity || '-')}</div>
                    </div>
                    <span class="badge bg-teal-400/10 border border-teal-300/20 text-teal-200">${number(u.sessions)} گفتوگۆ</span>
                    <span class="badge bg-violet-400/10 border border-violet-300/20 text-violet-200">${number(u.messages)} پەیام</span>
                </div>`).join('');
            el.querySelectorAll('.user-row').forEach(row => row.addEventListener('click', () => {
                const index = Number(row.dataset.index);
                const u = users[index];
                const search = document.getElementById('conv-search');
                search.value = u.email || u.identity;
                search.dispatchEvent(new Event('input'));
                document.getElementById('sessions-list').scrollIntoView({behavior:'smooth'});
            }));
        }

        function renderConversations() {
            const q = (document.getElementById('conv-search').value || '').trim().toLowerCase();
            const list = (DATA.conversations || []).filter(s =>
                !q || (s.email||'').toLowerCase().includes(q) || (s.user_key||'').toLowerCase().includes(q) || (s.title||'').toLowerCase().includes(q)
            );
            const el = document.getElementById('sessions-list');
            if (!list.length) { el.innerHTML = '<p class="text-slate-400">هیچ گفتوگۆیەک نەدۆزرایەوە.</p>'; return; }
            el.innerHTML = list.map((s,i)=>`
                <div class="session-row flex flex-wrap items-center gap-3 px-4 py-3 rounded-2xl border border-slate-700/60 bg-slate-800/30" data-index="${i}">
                    <div class="flex-1 min-w-0">
                        <div class="font-bold truncate">${esc(s.title || 'بێ ناونیشان')}</div>
                        <div class="text-xs text-slate-400 truncate">${esc(s.email || 'بێ ئیمێڵ')} • ${esc(s.created_at || '')} • ${number(s.messages.length)} پەیام</div>
                    </div>
                    <span class="text-teal-300 text-xs font-bold">بینین &larr;</span>
                </div>`).join('');
            el.querySelectorAll('.session-row').forEach(row => row.addEventListener('click', () => {
                openConversation(list[Number(row.dataset.index)]);
            }));
        }

        function openConversation(s) {
            document.getElementById('conv-title').textContent = s.title || 'بێ ناونیشان';
            document.getElementById('conv-meta').innerHTML = `
                <span class="badge bg-teal-400/10 border border-teal-300/20 text-teal-200">${esc(s.email || 'بێ ئیمێڵ')}</span>
                <span class="badge bg-slate-700/40 border border-slate-600 text-slate-300">${esc(s.created_at || '')}</span>
                <span class="badge bg-slate-700/40 border border-slate-600 text-slate-300">${number(s.messages.length)} پەیام</span>`;
            const msgs = s.messages || [];
            document.getElementById('conv-messages').innerHTML = msgs.length
                ? msgs.map(m => `<div class="msg ${m.role === 'user' ? 'user' : 'bot'}"><div class="text-[10px] opacity-60 mb-1">${m.role === 'user' ? 'بەکارهێنەر' : 'یاریدەدەر'} • ${esc(m.created_at || '')}</div>${esc(m.content)}</div>`).join('')
                : '<p class="text-slate-400">هیچ پەیامێک نییە.</p>';
            document.getElementById('conv-viewer').classList.remove('hidden');
            document.getElementById('conv-viewer').scrollIntoView({behavior:'smooth'});
        }

        document.getElementById('conv-back').addEventListener('click', () => document.getElementById('conv-viewer').classList.add('hidden'));
        document.getElementById('conv-search').addEventListener('input', renderConversations);

        onAuthStateChanged(auth, user => load(user).catch(() => { loading.classList.add('hidden'); unauthorized.classList.remove('hidden'); }));
    </script>
</body>
</html>
