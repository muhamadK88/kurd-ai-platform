
<script type="application/json" id="kurdai-fb-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script type="module">
    import { initializeApp, getApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

    (function () {
        const firebaseConfig = JSON.parse((document.getElementById('kurdai-fb-config') || {}).textContent || '{}');

        let app;
        try {
            app = getApp();
        } catch (e) {
            app = initializeApp(firebaseConfig);
        }
        const auth = getAuth(app);

        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

        const FB_L = {
            cat: {
                feedback: { so: 'ڕەخنە', ba: 'ڕەخنە' },
                suggestion: { so: 'پێشنیار', ba: 'پێشنیار' },
                request: { so: 'داواکاری', ba: 'داواکاری' },
                other: { so: 'هەرشتێکی تر', ba: 'هەرتشتەکی دی' },
            },
            newMsg: { so: 'نوێ', ba: 'نی' },
            read: { so: 'خوێندراوە', ba: 'خوێندراوە' },
            markRead: { so: 'خوێندراوە نیشان بکە', ba: 'نیشانکە وەک خوێندە' },
            markNew: { so: 'بگەڕێنەوە بۆ نوێ', ba: 'ڤەگەڕینە بۆ نووی' },
            del: { so: 'سڕینەوە', ba: 'سڕینەوە' },
            delConfirm: { so: 'ئەم پەیامە بسڕینەوە؟', ba: 'ئەڤ پەیامە ب سڕینەوە؟' },
            emptyAdmin: { so: 'هێشتا هیچ پەیامێک نەهاتووە', ba: 'هێشتا چ پەیامەک نەهاتیە' },
            toast: { so: '🔔 پەیامێکی نوێ هات', ba: '🔔 پەیامەکا نوی هاتی' },
            now: { so: 'ئێستا', ba: 'نوکە' },
        };
        const FB_COLORS = {
            feedback: { color: '#e11d48', bg: 'rgba(225,29,72,0.1)', border: 'rgba(225,29,72,0.3)' },
            suggestion: { color: '#d97706', bg: 'rgba(217,119,6,0.1)', border: 'rgba(217,119,6,0.3)' },
            request: { color: '#2563eb', bg: 'rgba(37,99,235,0.1)', border: 'rgba(37,99,235,0.3)' },
            other: { color: '#9333ea', bg: 'rgba(147,51,234,0.1)', border: 'rgba(147,51,234,0.3)' },
        };
        const FB_ICONS = { feedback: '💬', suggestion: '💡', request: '🎯', other: '✨' };

        function fbLang() { return (localStorage.getItem('site-lang') || 'so') === 'ba' ? 'ba' : 'so'; }
        function fbT(key) { return (FB_L[key] || {})[fbLang()] || ''; }
        function fbCatT(c) { return (FB_L.cat[c] || {})[fbLang()] || c; }

        function esc(v) {
            return String(v == null ? '' : v)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function fbBadge(cat) {
            const st = FB_COLORS[cat] || FB_COLORS.other;
            return '<span style="color:' + st.color + ';background:' + st.bg + ';border:1px solid ' + st.border + '" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold">' + (FB_ICONS[cat] || '✨') + ' ' + esc(fbCatT(cat)) + '</span>';
        }

        function fbStatusBadge(status) {
            if (status === 'new') {
                return '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold text-amber-600 bg-amber-500/10 border border-amber-500/40"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>' + esc(fbT('newMsg')) + '</span>';
            }
            return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold text-emerald-600 bg-emerald-500/10 border border-emerald-500/40">' + esc(fbT('read')) + '</span>';
        }

        function fbCount() {
            const el = document.getElementById('fb-message');
            const c = document.getElementById('fb-char-count');
            if (el && c) c.textContent = (el.value || '').length + ' / 5000';
        }

        function fbSetCategory(cat) {
            const hidden = document.getElementById('fb-category');
            if (!hidden) return;
            hidden.value = cat;
            const readout = document.getElementById('fb-cat-readout');
            if (readout) readout.textContent = cat;
            document.querySelectorAll('.fb-cat-chip').forEach(chip => {
                const isActive = chip.dataset.cat === cat;
                const st = FB_COLORS[cat] || FB_COLORS.other;
                if (isActive) {
                    chip.style.color = '#ffffff';
                    chip.style.background = 'linear-gradient(90deg,' + st.color + ',' + st.color + ')';
                    chip.style.borderColor = 'transparent';
                    chip.style.boxShadow = '0 8px 18px -8px ' + st.color;
                } else {
                    chip.style.color = '#6b7280';
                    chip.style.background = 'transparent';
                    chip.style.borderColor = '#e5e7eb';
                    chip.style.boxShadow = 'none';
                }
                if (document.documentElement.classList.contains('dark') && !isActive) {
                    chip.style.borderColor = '#4b5563';
                    chip.style.color = '#9ca3af';
                }
            });
        }

        function fbShowSuccess() {
            const box = document.getElementById('fb-success');
            if (!box) return;
            box.classList.remove('hidden');
            setTimeout(() => { box.classList.add('hidden'); }, 2600);
        }

        function fbToast(text) {
            let t = document.getElementById('fb-toast');
            if (!t) {
                t = document.createElement('div');
                t.id = 'fb-toast';
                document.body.appendChild(t);
            }
            t.textContent = text;
            t.style.display = 'flex';
            clearTimeout(t._timer);
            t._timer = setTimeout(() => { t.style.display = 'none'; }, 3000);
        }

        function fbMyItem(fb) {
            const st = FB_COLORS[fb.category] || FB_COLORS.other;
            const time = fb.created_at || fb.created_raw || fbT('now');
            const item = document.createElement('div');
            item.className = 'fb-my-item group rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/60 dark:bg-[#0d1424]/60 p-4';
            item.innerHTML =
                '<div class="flex items-center justify-between gap-2 mb-2">' +
                '<span style="color:' + st.color + ';background:' + st.bg + ';border:1px solid ' + st.border + '" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold">' + (FB_ICONS[fb.category] || '✨') + ' ' + esc(fbCatT(fb.category)) + '</span>' +
                fbStatusBadge(fb.status) +
                '</div>' +
                '<p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed break-words">' + esc(fb.message) + '</p>' +
                '<p class="mt-2 text-[11px] text-gray-400 font-bold" dir="ltr">' + esc(time) + '</p>';
            return item;
        }

        function fbRenderMy(items) {
            const list = document.getElementById('fb-my-list');
            if (!list) return;
            const empty = document.getElementById('fb-my-empty');
            if (!items.length) {
                if (empty) empty.classList.remove('hidden');
                return;
            }
            if (empty) empty.remove();
            (items || []).forEach(fb => list.appendChild(fbMyItem(fb)));
        }

        function fbAppendMyMessage(fb) {
            const list = document.getElementById('fb-my-list');
            const empty = document.getElementById('fb-my-empty');
            if (!list) return;
            if (empty) empty.remove();
            list.prepend(fbMyItem(fb));
        }

        let bound = false;
        function fbBindForm() {
            if (bound) return;
            bound = true;
            const form = document.getElementById('fb-form');
            if (!form) return;
            document.querySelectorAll('.fb-cat-chip').forEach(chip => {
                chip.addEventListener('click', () => fbSetCategory(chip.dataset.cat));
            });
            const msg = document.getElementById('fb-message');
            if (msg) msg.addEventListener('input', fbCount);
            fbSetCategory('feedback');
            fbCount();

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const user = auth.currentUser;
                if (!user) return;
                const btn = document.getElementById('fb-submit-btn');
                const cat = document.getElementById('fb-category').value;
                const message = document.getElementById('fb-message').value.trim();
                if (!message) return;
                const name = document.getElementById('fb-name').value.trim();
                const hideEmail = document.getElementById('fb-hide-email')?.checked === true;
                btn.disabled = true;
                btn.style.opacity = '0.6';
                try {
                    const idToken = await user.getIdToken();
                    const res = await fetch('/feedback/store', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                        body: JSON.stringify({ category: cat, message, name, hide_email: hideEmail, idToken }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        fbShowSuccess();
                        document.getElementById('fb-message').value = '';
                        fbCount();
                        fbAppendMyMessage(data.feedback);
                        if (data.is_admin) { fbPoll(); fbToast(fbT('toast')); }
                    } else {
                        fbToast(data.message || 'هەڵەیەک ڕوویدا');
                    }
                } catch (err) {
                    fbToast('هەڵەیەک ڕوویدا لە پەیوەندیدا');
                } finally {
                    btn.disabled = false;
                    btn.style.opacity = '1';
                }
            });
        }

        /* ---------- سندوقی ئەدمین ---------- */
        let fbLastNew = -1;

        function fbRenderAdmin(data) {
            const list = document.getElementById('fb-admin-list');
            if (!list) return;
            const stats = data.stats || {};
            const set = (id, v) => { const el = document.getElementById(id); if (el) el.textContent = v; };
            set('fb-stat-total', stats.total || 0);
            set('fb-stat-new', stats.new || 0);
            set('fb-stat-suggestion', stats.suggestion || 0);
            set('fb-stat-request', stats.request || 0);

            if (fbLastNew === -1) fbLastNew = stats.new || 0;
            else if ((stats.new || 0) > fbLastNew) {
                fbLastNew = stats.new || 0;
                fbToast(fbT('toast'));
            } else {
                fbLastNew = stats.new || 0;
            }

            const items = data.items || [];
            if (!items.length) {
                list.innerHTML = '<div class="flex flex-col items-center justify-center text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl"><div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4 text-3xl">🕊️</div><p class="font-bold text-gray-500 dark:text-gray-400">' + esc(fbT('emptyAdmin')) + '</p></div>';
                return;
            }
            list.innerHTML = items.map(fbAdminItemHTML).join('');
            document.querySelectorAll('.fb-mark-btn').forEach(b => b.addEventListener('click', () => {
                fbMarkRead(b.dataset.id, b.dataset.status);
            }));
            document.querySelectorAll('.fb-del-btn').forEach(b => b.addEventListener('click', () => {
                if (!confirm(fbT('delConfirm'))) return;
                fbDelete(b.dataset.id);
            }));
        }

        function fbAdminItemHTML(f) {
            const isNew = f.status === 'new';
            const avatar = (f.name || '؟').trim().charAt(0);
            const st = FB_COLORS[f.category] || FB_COLORS.other;
            const time = f.created_at || f.created_raw || '';
            const markBtn = isNew
                ? '<button type="button" data-id="' + f.id + '" data-status="' + f.status + '" class="fb-mark-btn px-3 py-1.5 rounded-lg text-[11px] font-bold border border-emerald-400/50 text-emerald-600 hover:bg-emerald-500/10 transition-all">✓ ' + esc(fbT('markRead')) + '</button>'
                : '<button type="button" data-id="' + f.id + '" data-status="' + f.status + '" class="fb-mark-btn px-3 py-1.5 rounded-lg text-[11px] font-bold border border-gray-300 dark:border-gray-600 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">↺ ' + esc(fbT('markNew')) + '</button>';
            const delBtn = '<button type="button" data-id="' + f.id + '" class="fb-del-btn px-3 py-1.5 rounded-lg text-[11px] font-bold text-rose-600 border border-rose-400/50 hover:bg-rose-500/10 transition-all">' + esc(fbT('del')) + '</button>';
            return '<div class="fb-admin-item rounded-2xl border ' + (isNew ? 'border-amber-400/70 bg-amber-50/50 dark:bg-amber-900/10' : 'border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-[#0d1424]/70') + ' backdrop-blur p-4 sm:p-5 transition-all">' +
                '<div class="flex flex-col sm:flex-row sm:items-start gap-4">' +
                '<div class="w-11 h-11 shrink-0 rounded-full bg-gradient-to-br from-blue-600 to-teal-400 text-white flex items-center justify-center font-black text-lg shadow">' + esc(avatar) + '</div>' +
                '<div class="flex-1 min-w-0">' +
                '<div class="flex items-center flex-wrap gap-x-3 gap-y-1 mb-1.5">' +
                '<span class="font-black text-gray-900 dark:text-white">' + esc(f.name) + '</span>' +
                (f.email ? '<span class="text-xs text-gray-400 font-bold" dir="ltr">' + esc(f.email) + '</span>' : '') +
                fbBadge(f.category) +
                '</div>' +
                '<p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed break-words">' + esc(f.message) + '</p>' +
                '<p class="mt-2 text-[11px] text-gray-400 font-bold" dir="ltr">' + esc(time) + '</p>' +
                '</div>' +
                '<div class="flex sm:flex-col items-center sm:items-end gap-2 shrink-0 w-full sm:w-auto justify-between sm:justify-start">' + fbStatusBadge(f.status) +
                '<div class="flex gap-2 flex-wrap">' + markBtn + delBtn + '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        async function fbMarkRead(id, status) {
            const user = auth.currentUser;
            if (!user) return;
            try {
                const idToken = await user.getIdToken();
                await fetch('/feedback/' + id + '/read', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                    body: JSON.stringify({ status: status === 'new' ? 'read' : 'new' }),
                });
            } catch (e) {}
            fbPoll();
        }

        async function fbDelete(id) {
            const user = auth.currentUser;
            if (!user) return;
            try {
                const idToken = await user.getIdToken();
                await fetch('/feedback/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': CSRF, 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                });
            } catch (e) {}
            fbPoll();
        }

        async function fbPoll() {
            const user = auth.currentUser;
            if (!user) return;
            try {
                const idToken = await user.getIdToken();
                const res = await fetch('/feedback/list', {
                    headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                });
                if (res.status !== 200) return;
                const data = await res.json();
                fbRenderAdmin(data);
            } catch (e) {}
        }

        function showMemberUI(user) {
            const member = document.getElementById('fb-member-ui');
            const guest = document.getElementById('fb-guest-ui');
            if (member) member.classList.remove('hidden');
            if (guest) guest.classList.add('hidden');

            const nameEl = document.getElementById('fb-name');
            const emailEl = document.getElementById('fb-email');
            if (nameEl) nameEl.value = user.displayName || (user.email ? user.email.split('@')[0] : 'مێمبەر');
            if (emailEl) emailEl.value = user.email || '';

            fbBindForm();
            loadMine();
        }

        function showGuestUI() {
            const member = document.getElementById('fb-member-ui');
            const guest = document.getElementById('fb-guest-ui');
            if (member) member.classList.add('hidden');
            if (guest) guest.classList.remove('hidden');
        }

        async function loadMine() {
            const user = auth.currentUser;
            if (!user) return;
            const list = document.getElementById('fb-my-list');
            if (!list) return;
            try {
                const idToken = await user.getIdToken();
                const res = await fetch('/feedback/mine', {
                    headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + idToken, 'X-Firebase-Id-Token': idToken },
                });
                if (res.status !== 200) return;
                const data = await res.json();
                fbRenderMy(data.items || []);

                const panelAdmin = document.getElementById('fb-panel-admin');
                if (data.is_admin) {
                    if (panelAdmin) panelAdmin.classList.remove('hidden');
                    fbPoll();
                    if (!window.__fbPollTimer) {
                        window.__fbPollTimer = setInterval(fbPoll, 8000);
                    }
                } else if (panelAdmin) {
                    panelAdmin.remove();
                }
            } catch (e) {}
        }

        onAuthStateChanged(auth, (user) => {
            if (user) {
                showMemberUI(user);
            } else {
                showGuestUI();
            }
        });
    })();
</script>
