{{-- ==========================================
     ADMIN-ONLY SITE ANALYTICS — REAL-TIME DATA
     Rendered as a hidden shell and revealed only after the Firebase/Laravel
     admin API accepts the current identity. The API is the security boundary.
     ========================================== --}}

{{-- Visit beacon for ALL visitors (admins and members) --}}
<script>if (window.KaiTrack) { try { window.KaiTrack.visit('about'); } catch (e) {} }</script>

    <div id="kai-site-analytics" class="hidden kai-analytics-console mt-24 pt-16 border-t border-gray-200/60 dark:border-gray-800">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <div class="kai-console-kicker inline-flex items-center gap-2 px-4 py-1.5 rounded-full border font-bold text-xs mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>ADMIN ANALYTICS / LIVE DATA</span>
                </div>
                <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">ئامارەکانی بەکارهێنانی پلاتفۆڕم</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">سەردان، لۆگین، بەکارهێنەرە نوێکان و تەواوکردنی وانەکان — ڕاستەوخۆ لە داتابەیسەوە</p>
            </div>
            <div class="flex items-center gap-3">
                <button id="kai-stats-refresh" class="px-4 py-2 rounded-xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 font-bold text-xs border border-blue-200/50 dark:border-blue-700/50 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition">نوێکردنەوە ↻</button>
                <span class="px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-300 font-bold text-xs border border-emerald-200/50 dark:border-emerald-700/50">دۆخی ڕاستەقینە: چالاک</span>
            </div>
        </div>

        <!-- Range + Section Tabs -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
            <div id="kai-stats-range" class="inline-flex items-center gap-1 p-1 rounded-2xl bg-gray-100 dark:bg-gray-800/70 border border-gray-200/50 dark:border-gray-700/50 self-start">
                <button data-range="day" class="kai-range-btn px-4 py-2 rounded-xl text-xs font-black transition">ڕۆژ</button>
                <button data-range="week" class="kai-range-btn px-4 py-2 rounded-xl text-xs font-black transition">حەفتە</button>
                <button data-range="month" class="kai-range-btn px-4 py-2 rounded-xl text-xs font-black transition">مانگ</button>
            </div>
            <div id="kai-stats-tabs" class="flex flex-wrap items-center gap-1.5">
                <button data-tab="overview" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">سەرەکی</button>
                <button data-tab="universities" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">زانکۆکان</button>
                <button data-tab="ferga" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">فێرگە</button>
                <button data-tab="general_info" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">زانیاری گشتی</button>
                <button data-tab="courses" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">کۆرسەکان</button>
                <button data-tab="academic_guide" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">ڕێنیشاندەر</button>
                <button data-tab="ai_tools" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">تووڵەکان</button>
                <button data-tab="news" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">هەواڵەکان</button>
                <button data-tab="lessons" class="kai-tab-btn px-3 py-1.5 rounded-xl text-xs font-black transition">وانەکان</button>
            </div>
        </div>

        <style>
            .kai-range-btn.active, .kai-tab-btn.active { background: linear-gradient(135deg, #10b981, #0d9488); color: #fff; box-shadow: 0 4px 12px rgba(16,185,129,.25); }
            .kai-range-btn:not(.active), .kai-tab-btn:not(.active) { color: #64748b; }
            .dark .kai-range-btn:not(.active), .dark .kai-tab-btn:not(.active) { color: #94a3b8; }
            .kai-range-btn:not(.active):hover, .kai-tab-btn:not(.active):hover { background: rgba(148,163,184,.15); }
            #kai-site-analytics .kai-chart { direction: ltr; }
            .kai-analytics-console { position: relative; isolation: isolate; }
            .kai-analytics-console::before { content: ''; position: absolute; inset: 2rem 0 auto; height: 26rem; z-index: -1; pointer-events: none; background: radial-gradient(circle at 12% 20%, rgba(16,185,129,.14), transparent 36%), radial-gradient(circle at 88% 12%, rgba(59,130,246,.14), transparent 34%); filter: blur(8px); }
            .kai-analytics-console .glass-card { background: rgba(255,255,255,.64); border: 1px solid rgba(148,163,184,.2); backdrop-filter: blur(18px); }
            .dark .kai-analytics-console .glass-card { background: rgba(15,23,42,.66); border-color: rgba(94,234,212,.13); }
            .kai-console-kicker { color: #047857; background: rgba(16,185,129,.1); border-color: rgba(16,185,129,.22); letter-spacing: .08em; }
            .dark .kai-console-kicker { color: #6ee7b7; background: rgba(16,185,129,.12); border-color: rgba(110,231,183,.2); }
            .kai-analytics-console .kai-chart > div { min-height: 12rem; padding: 1rem .5rem .25rem; border-radius: 1.25rem; background: repeating-linear-gradient(to top, rgba(100,116,139,.09) 0 1px, transparent 1px 25%); }
            .kai-analytics-console .kai-chart > div > div { align-items: end; }
            .kai-analytics-console .kai-chart > div > div > div { min-height: 2.5rem; }
            .kai-analytics-console .kai-chart > div > div > div > div { background-image: linear-gradient(180deg, #34d399, #0d9488); box-shadow: 0 -5px 18px rgba(16,185,129,.22); transition: height .6s cubic-bezier(.22,1,.36,1); }
            .kai-section-row { background: rgba(148,163,184,.08); border: 1px solid rgba(148,163,184,.12); }
            .kai-section-row:hover { background: rgba(16,185,129,.08); border-color: rgba(16,185,129,.25); }
            .kai-rank { width: 2rem; height: 2rem; display: inline-flex; align-items: center; justify-content: center; border-radius: .75rem; color: #047857; background: rgba(16,185,129,.12); font: 900 .7rem ui-monospace, SFMono-Regular, Consolas, monospace; }
            .dark .kai-rank { color: #6ee7b7; background: rgba(16,185,129,.15); }
            .kai-section-fill { background: linear-gradient(90deg, #10b981, #06b6d4, #6366f1); box-shadow: 0 0 14px rgba(16,185,129,.28); }
            @media (max-width: 640px) { .kai-section-row { grid-template-columns: auto minmax(0,1fr); } .kai-section-row > div:last-child { grid-column: 2; text-align: right; } }
        </style>

        <!-- Loading -->
        <div id="kai-stats-loading" class="glass-card p-12 rounded-[2.5rem] shadow-xl text-center">
            <div class="inline-block w-10 h-10 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin mb-4"></div>
            <p class="text-gray-500 dark:text-gray-400 font-bold">خەریکی هێنانی ئامارەکانە...</p>
        </div>

        <!-- Error -->
        <div id="kai-stats-error" class="hidden glass-card p-10 rounded-[2.5rem] shadow-xl text-center">
            <p class="text-lg font-black text-red-500 mb-2">کێشەیەک لە هێنانی ئامارەکان ڕوویدا</p>
            <p id="kai-stats-error-msg" class="text-sm text-gray-500 dark:text-gray-400 mb-6"></p>
            <button id="kai-stats-retry" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black rounded-xl transition">هەوڵدانەوە</button>
        </div>

        <!-- Content -->
        <div id="kai-stats-content" class="hidden">

            <!-- Overview KPIs -->
            <div id="kai-stats-overview-kpis" class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8"></div>

            <!-- Overview charts -->
            <div id="kai-stats-overview" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">سەردانەکان (ڕۆژ بە ڕۆژ)</h4>
                    <div id="ov-visits" class="kai-chart"></div>
                </div>
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">لۆگینەکان</h4>
                    <div id="ov-logins" class="kai-chart"></div>
                </div>
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">بەکارهێنەرە نوێکان</h4>
                    <div id="ov-users" class="kai-chart"></div>
                </div>
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">وانە تەواوکراوەکان</h4>
                    <div id="ov-lessons" class="kai-chart"></div>
                </div>
            </div>

            <div class="glass-card p-6 rounded-[2.5rem] shadow-xl mt-6">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                    <div>
                        <h4 class="text-lg font-black text-gray-900 dark:text-white">ڕیزبەندی بەشەکان</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">بەپێی کۆی سەردان و چالاکییە تۆمارکراوەکان</p>
                    </div>
                    <span class="text-xs font-black text-emerald-600 dark:text-emerald-300">LIVE SECTION RANKING</span>
                </div>
                <div id="kai-stats-section-table" class="space-y-3"></div>
            </div>

            <!-- Section view -->
            <div id="kai-stats-section" class="hidden">
                <div id="kai-stats-section-kpis" class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6"></div>
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 id="kai-stats-section-title" class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4"></h4>
                    <div id="sec-chart" class="kai-chart"></div>
                </div>
            </div>

            <!-- Lessons view -->
            <div id="kai-stats-lessons" class="hidden">
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl mb-6">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">وانەی تەواوکراو بەپێی کۆرسەکان (فێرگە)</h4>
                    <div id="les-courses" class="space-y-4"></div>
                </div>
                <div class="glass-card p-6 rounded-[2.5rem] shadow-xl">
                    <h4 class="text-sm font-black text-gray-700 dark:text-gray-200 mb-4">تەواوکردنی وانەکان بەپێی کات</h4>
                    <div id="les-chart" class="kai-chart"></div>
                </div>
            </div>
        </div>
    </div>

    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="module">
        const SEC_TITLES = { universities: 'سەردانی زانکۆکان', ferga: 'سەردانی فێرگە', general_info: 'سەردانی زانیاری گشتی', courses: 'سەردانی کۆرسەکان', academic_guide: 'سەردانی ڕێنیشاندەر', ai_tools: 'سەردانی تووڵەکان', news: 'سەردانی هەواڵەکان' };

        let currentLang = localStorage.getItem('site-lang') || 'so';
        const L = (so, ba) => currentLang === 'ba' ? ba : so;
        const num = v => { try { return Number(v || 0).toLocaleString('ckb-IQ'); } catch (e) { return String(v || 0); } };
        const esc = v => String(v ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        let DATA = null, range = 'day', tab = 'overview', activeUser = null;

        const content = document.getElementById('kai-stats-content');
        const loadingEl = document.getElementById('kai-stats-loading');
        const errorEl = document.getElementById('kai-stats-error');
        const errorMsg = document.getElementById('kai-stats-error-msg');

        async function load(r, readyUser) {
            r = r || range;
            range = r;
            if (arguments.length > 1) activeUser = readyUser;
            setActiveButtons();
            loadingEl.classList.remove('hidden');
            errorEl.classList.add('hidden');
            content.classList.add('hidden');
            try {
                /* Laravel session cookie travels automatically; Firebase token attached if present */
                const headers = { 'Accept': 'application/json' };
                const KaiF = window.KaiFirebase || {};
                const auth = KaiF.auth ? KaiF.auth() : null;
                const currentUser = activeUser || (auth && auth.currentUser);
                if (currentUser) {
                    try {
                        const t = await currentUser.getIdToken();
                        headers['X-Firebase-Id-Token'] = t;
                    } catch (e) {}
                }
                const res = await fetch('/api/admin/analytics?range=' + r, { headers, credentials: 'same-origin' });
                if (res.status === 403) {
                    document.getElementById('kai-site-analytics').classList.add('hidden');
                    return;
                }
                if (!res.ok) throw new Error('HTTP ' + res.status);
                DATA = await res.json();
                render();
                document.getElementById('kai-site-analytics').classList.remove('hidden');
                loadingEl.classList.add('hidden');
                content.classList.remove('hidden');
            } catch (e) {
                loadingEl.classList.add('hidden');
                errorMsg.textContent = (e && e.message) || 'نەتوانرا پەیوەندی بکرێت';
                errorEl.classList.remove('hidden');
            }
        }

        function setActiveButtons() {
            document.querySelectorAll('#kai-stats-range .kai-range-btn').forEach(b => b.classList.toggle('active', b.dataset.range === range));
            document.querySelectorAll('#kai-stats-tabs .kai-tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === tab));
        }

        function render() {
            renderOverviewKpis();
            renderCharts();
            renderSectionTable();
            renderSection();
            renderLessons();
            document.querySelectorAll('#kai-stats-overview, #kai-stats-section, #kai-stats-lessons')
                .forEach(el => el.classList.add('hidden'));
            if (tab === 'lessons') document.getElementById('kai-stats-lessons').classList.remove('hidden');
            else if (tab === 'overview') document.getElementById('kai-stats-overview').classList.remove('hidden');
            else document.getElementById('kai-stats-section').classList.remove('hidden');
        }

        function kpiCard(label, value, color, icon) {
            return `<div class="glass-card p-5 rounded-3xl shadow-xl border-r-4 ${color}">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[0.68rem] font-bold text-gray-500 dark:text-gray-400">${label}</span>
                    <span class="w-8 h-8 rounded-xl bg-white/40 dark:bg-white/10 flex items-center justify-center text-sm">${icon}</span>
                </div>
                <div class="text-2xl font-black text-gray-900 dark:text-white">${num(value)}</div>
            </div>`;
        }

        function renderOverviewKpis() {
            const t = DATA.totals;
            document.getElementById('kai-stats-overview-kpis').innerHTML =
                kpiCard('بەکارهێنەری تۆمارکراو', t.users, 'border-sky-500', '👤') +
                kpiCard('کۆی سەردانەکان', t.visits, 'border-emerald-500', '👁') +
                kpiCard('کۆی لۆگینەکان', t.logins, 'border-blue-500', '🔑') +
                kpiCard('بەکارهێنەری ناوازە', t.unique_users, 'border-violet-500', '👥') +
                kpiCard('بەکارهێنەری ٣٠ ڕۆژ', t.unique_users_30d, 'border-amber-500', '🔥') +
                kpiCard('وانەی تەواوکراو', t.lessons, 'border-teal-500', '🎓') +
                kpiCard('ئەمڕۆ (سەردان / لۆگین)', t.today_visits + ' / ' + t.today_logins, 'border-rose-500', '⚡');
        }

        function barChart(el, counts, labels, colorClass) {
            const max = Math.max(1, ...counts);
            const n = counts.length;
            let bars = '';
            for (let i = 0; i < n; i++) {
                const h = Math.max(3, Math.round(counts[i] / max * 100));
                const lbl = (i % 4 === 0 || i === n - 1) ? labels[i] : '';
                const barColor = counts[i] ? colorClass : 'bg-gray-200 dark:bg-gray-700';
                bars += `<div class="flex-1 flex flex-col items-center justify-end gap-1 min-w-0 h-44">
                    <span class="text-[0.6rem] font-black ${counts[i] ? 'text-gray-700 dark:text-gray-200' : 'text-gray-300 dark:text-gray-600'}">${num(counts[i])}</span>
                    <div class="w-full rounded-t-lg ${barColor}" style="height:${h}%"></div>
                    <span class="text-[0.55rem] font-bold text-gray-400 truncate w-full text-center">${lbl}</span>
                </div>`;
            }
            el.innerHTML = `<div class="flex items-end gap-1">${bars}</div>`;
        }

        function renderCharts() {
            const labels = DATA.buckets.map(b => b.label);
            barChart(document.getElementById('ov-visits'), DATA.series.visits, labels, 'bg-emerald-500');
            barChart(document.getElementById('ov-logins'), DATA.series.logins, labels, 'bg-blue-500');
            barChart(document.getElementById('ov-users'), DATA.series.new_users, labels, 'bg-violet-500');
            barChart(document.getElementById('ov-lessons'), DATA.series.lessons, labels, 'bg-teal-500');
        }

        function renderSectionTable() {
            const el = document.getElementById('kai-stats-section-table');
            const rows = Object.entries(DATA.sections || {}).sort((a, b) => Number(b[1].total || 0) - Number(a[1].total || 0));
            const max = Math.max(1, ...rows.map(([, section]) => Number(section.total || 0)));
            el.innerHTML = rows.length ? rows.map(([key, section], index) => {
                const width = Math.max(3, Math.round(Number(section.total || 0) / max * 100));
                return `<div class="kai-section-row grid grid-cols-[auto_minmax(0,1fr)_auto] items-center gap-3 rounded-2xl px-3 py-3">
                    <span class="kai-rank">${String(index + 1).padStart(2, '0')}</span>
                    <div class="min-w-0">
                        <div class="flex items-center justify-between gap-3 mb-1.5">
                            <span class="font-black text-sm text-gray-800 dark:text-gray-100 truncate">${esc(section.label || key)}</span>
                            <span class="text-xs font-black text-emerald-600 dark:text-emerald-300 whitespace-nowrap">${num(section.total)}</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-200/80 dark:bg-gray-800 overflow-hidden"><span class="kai-section-fill block h-full rounded-full" style="width:${width}%"></span></div>
                    </div>
                    <div class="text-[10px] text-gray-500 dark:text-gray-400 text-left whitespace-nowrap">ئەمڕۆ ${num(section.today)}<br>هەفتە ${num(section.week)}</div>
                </div>`;
            }).join('') : '<p class="text-sm text-gray-500 dark:text-gray-400">هێشتا داتا نییە.</p>';
        }

        function renderSection() {
            const s = DATA.sections[tab];
            if (!s) return;
            document.getElementById('kai-stats-section-kpis').innerHTML =
                kpiCard('ئەمڕۆ', s.today, 'border-emerald-500', '📅') +
                kpiCard('حەفتەی ڕابردوو', s.week, 'border-blue-500', '📆') +
                kpiCard('٣٠ ڕۆژی ڕابردوو', s.month, 'border-amber-500', '🗓') +
                kpiCard('کۆی هەموو', s.total, 'border-violet-500', '📊');
            document.getElementById('kai-stats-section-title').textContent = SEC_TITLES[tab] || s.label;
            barChart(document.getElementById('sec-chart'), s.series, DATA.buckets.map(b => b.label), 'bg-indigo-500');
        }

        function renderLessons() {
            const courses = DATA.courses || [];
            const max = Math.max(1, ...courses.map(c => c.total));
            document.getElementById('les-courses').innerHTML = courses.length
                ? courses.map(c => {
                    const title = L(c.title_so, c.title_ba);
                    return `<div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-gray-700 dark:text-gray-200">${title}</span>
                            <span class="text-teal-600 dark:text-teal-400">${num(c.total)} تەواوکراو</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-teal-500 to-emerald-500 h-2.5 rounded-full transition-all duration-700" style="width:${Math.max(3, c.total / max * 100)}%"></div>
                        </div>
                    </div>`;
                }).join('')
                : '<p class="text-sm text-gray-500 dark:text-gray-400 font-bold">هێشتا هیچ وانەیەک تەواو نەکراوە.</p>';
            barChart(document.getElementById('les-chart'), DATA.series.lessons, DATA.buckets.map(b => b.label), 'bg-teal-500');
        }

        document.getElementById('kai-stats-refresh').addEventListener('click', () => load(range));
        document.getElementById('kai-stats-retry').addEventListener('click', () => load(range));
        document.querySelectorAll('#kai-stats-range .kai-range-btn').forEach(b => b.addEventListener('click', () => load(b.dataset.range)));
        document.querySelectorAll('#kai-stats-tabs .kai-tab-btn').forEach(b => b.addEventListener('click', () => { tab = b.dataset.tab; render(); }));

        const KaiF = window.KaiFirebase || {};
        if (KaiF.whenReady) {
            KaiF.whenReady((state) => load('day', state && state.user));
        } else {
            load('day', null);
        }
        setInterval(() => {
            if (!document.getElementById('kai-site-analytics').classList.contains('hidden')) load(range);
        }, 60000);
    </script>
