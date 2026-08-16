/* ==========================================================================
   KURD AI — فێرگە admin content manager (kai-ferga-admin.js)
   Drives /ferga/admin (view: resources/views/ferga_admin.blade.php).
   Talks to the Laravel JSON API (FergaAdminController):
     GET/POST        /api/ferga/admin/courses
     PUT/DELETE      /api/ferga/admin/courses/{course}
     POST            /api/ferga/admin/courses/{course}/move   {dir}
     GET/POST        /api/ferga/admin/courses/{course}/lessons
     PUT/DELETE      /api/ferga/admin/lessons/{lesson}
     POST            /api/ferga/admin/lessons/{lesson}/move   {dir}
   Identity = Firebase ID token; the server re-checks admin rights.
   ========================================================================== */
(function () {
    'use strict';

    function ready(fn) { if (document.readyState !== 'loading') fn(); else document.addEventListener('DOMContentLoaded', fn); }
    function $(id) { return document.getElementById(id); }
    function lang() { return (localStorage.getItem('site-lang') || 'so') === 'ba' ? 'ba' : 'so'; }
    function esc(v) {
        return String(v == null ? '' : v)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    var UI = {
        active: { so: 'بەردەست', ba: 'بەردەست' },
        locked: { so: 'دووربەستە', ba: 'قفڵکری' },
        soon: { so: 'بەم زوانە', ba: 'بەم دیمە' },
        open: { so: 'وانەکان', ba: 'وانە' },
        lessons: { so: 'وانە', ba: 'وانە' },
        edit: { so: 'دەستکاری', ba: 'سەرڤێکرن' },
        del: { so: 'سڕینەوە', ba: 'سڕینەوە' },
        delCourseQ: { so: 'ئەم کۆرسە و هەموو وانەکانی بسڕینەوە؟', ba: 'ئەڤ کورسە و هەمی وانەیێن وێ ب سڕینەوە؟' },
        delLessonQ: { so: 'ئەم وانەیە بسڕینەوە؟', ba: 'ئەڤ وانەیێ ب سڕینەوە؟' },
        saved: { so: 'پاشەکەوت کرا ✓', ba: 'پاشەکەوت بوو ✓' },
        deleted: { so: 'سڕایەوە', ba: 'هاتە سڕینەوە' },
        moved: { so: 'ڕیزبەندی نوێ کرا', ba: 'ڕیزبەندی نوی بوی' },
        unauthorized: { so: 'بەردەست نییە — تۆ ئەدمین نیت.', ba: 'بەردەست نینە — تو ئەدمین نینی.' },
        err: { so: 'هەڵەیەک ڕوویدا', ba: 'خەلەتەک ڕوویدا' },
        missing: { so: 'تکایە ناونیشان پڕ بکەرەوە.', ba: 'تکایە ناڤ پڕ بکە.' },
        newCourse: { so: 'کۆرسی نوێ', ba: 'کورسێ نوی' },
        editCourse: { so: 'دەستکاریکردنی کۆرس', ba: 'سەرڤێکرنا کورسێ' },
        newLesson: { so: 'وانەی نوێ', ba: 'وانەیێ نوی' },
        editLesson: { so: 'دەستکاریکردنی وانە', ba: 'سەرڤێکرنا وانەیێ' },
        noLessons: { so: 'هێشتا هیچ وانەیەک نییە.', ba: 'هێشتا چ وانە نینن.' },
        lock: { so: 'قفڵ / کردنەوە', ba: 'قفڵ / ڤەکرن' },
    };
    function T(key) { return (UI[key] || {})[lang()] || ''; }

    /* ------------------------------------------------------------------ */
    /* state                                                               */
    /* ------------------------------------------------------------------ */
    var state = {
        courses: [],
        activeCourse: null,
        lessons: [],
        editor: {},         // rich editor cache per dialect: so / ba
        editorSrc: {},      // which editor is in HTML-source mode
    };

    var authUser = null;
    var CSRF = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';

    /* ------------------------------------------------------------------ */
    /* firebase + api                                                      */
    /* ------------------------------------------------------------------ */
    function initFirebase() {
        var cfgEl = $('kurdai-firebase-config');
        if (!cfgEl) return;
        var cfg = {};
        try { cfg = JSON.parse(cfgEl.textContent || '{}'); } catch (e) {}
        if (!cfg || !cfg.apiKey) return;

        import('https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js')
            .then(function (appMod) {
                return import('https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js')
                    .then(function (authMod) {
                        var app = appMod.getApps().length ? appMod.getApp() : appMod.initializeApp(cfg);
                        var auth = authMod.getAuth(app);
                        var logoutBtn = $('logout-btn');
                        if (logoutBtn) {
                            logoutBtn.addEventListener('click', function () {
                                authMod.signOut(auth).then(function () { window.location.href = '/login'; });
                            });
                        }
                        authMod.onAuthStateChanged(auth, function (user) {
                            authUser = user;
                            boot();
                        });
                    });
            })
            .catch(function () { authUser = null; boot(); });
    }

    async function token() {
        if (!authUser) return '';
        try { return await authUser.getIdToken(); } catch (e) { return ''; }
    }

    async function api(path, opts) {
        opts = opts || {};
        var headers = { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF };
        var t = await token();
        if (t) { headers['Authorization'] = 'Bearer ' + t; headers['X-Firebase-Id-Token'] = t; }
        if (opts.body) headers['Content-Type'] = 'application/json';
        var res;
        try {
            res = await fetch(path, {
                method: opts.method || 'GET',
                headers: headers,
                body: opts.body ? JSON.stringify(opts.body) : undefined,
            });
        } catch (e) {
            return { status: 0, data: {} };
        }
        var data = {};
        try { data = await res.json(); } catch (e) {}
        return { status: res.status, data: data };
    }

    /* ------------------------------------------------------------------ */
    /* toast + language                                                    */
    /* ------------------------------------------------------------------ */
    var toastTimer = null;
    function toast(msg, isErr) {
        var el = $('kfga-toast');
        if (!el) return;
        el.textContent = msg;
        el.style.background = isErr ? 'linear-gradient(120deg,#e11d48,#f43f5e)' : 'linear-gradient(120deg,#059669,#0ea5e9)';
        el.classList.remove('hidden');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { el.classList.add('hidden'); }, 2600);
    }

    function applyStaticLang() {
        document.querySelectorAll('.lang-str').forEach(function (el) {
            el.textContent = el.getAttribute('data-' + lang()) || el.getAttribute('data-so') || '';
        });
    }

    /* ------------------------------------------------------------------ */
    /* boot + guard                                                        */
    /* ------------------------------------------------------------------ */
    async function boot() {
        applyStaticLang();
        if (!authUser) { showUnauthorized(); return; }
        await loadCourses();
    }

    function showUnauthorized() {
        $('kfga-admin').classList.add('hidden');
        $('kfga-loading').classList.add('hidden');
        $('kfga-unauthorized').classList.remove('hidden');
    }

    function setLoading(on) {
        var l = $('kfga-loading');
        if (l) l.classList.toggle('hidden', !on);
    }

    /* ------------------------------------------------------------------ */
    /* courses                                                             */
    /* ------------------------------------------------------------------ */
    async function loadCourses() {
        setLoading(true);
        var r = await api('/api/ferga/admin/courses');
        setLoading(false);

        if (r.status === 401 || r.status === 403) {
            showUnauthorized();
            return;
        }
        state.courses = (r.data && r.data.courses) || [];
        renderCourses();
    }

    function statusLabel(s) {
        if (s === 'active') return T('active');
        if (s === 'locked') return T('locked');
        return T('soon');
    }

    function renderCourses() {
        var wrap = $('kfga-courses');
        var empty = $('kfga-courses-empty');
        var stat = $('kfga-stat-courses');
        var lessonsTotal = 0;
        if (stat) stat.textContent = state.courses.length;

        if (!state.courses.length) {
            if (empty) empty.classList.remove('hidden');
            if (wrap) wrap.innerHTML = '';
            return;
        }
        if (empty) empty.classList.add('hidden');

        var html = '';
        state.courses.forEach(function (c, i) {
            lessonsTotal += c.lessons_count || 0;
            html += '<div class="kfg-row" data-id="' + c.id + '">' +
                '<span class="kfg-icon-btn is-primary" style="cursor:default">#' + c.position + '</span>' +
                '<span style="font-size:1.4rem">' + esc(c.icon || '📘') + '</span>' +
                '<span class="flex-1 min-w-[180px]">' +
                    '<span class="block font-black text-sm">' + esc(c.title_so) + '</span>' +
                    '<span class="block text-xs text-slate-500 dark:text-slate-400">' + esc(c.title_ba) + '</span>' +
                '</span>' +
                '<span class="kfg-status-badge is-' + esc(c.status) + '">' + esc(statusLabel(c.status)) + '</span>' +
                '<span class="text-xs font-bold text-slate-400 whitespace-nowrap">' + (c.lessons_count || 0) + ' ' + esc(T('lessons')) + '</span>' +
                '<span class="kfg-actions">' +
                    '<select class="kfg-select kfga-status" data-id="' + c.id + '" style="width:auto;padding:.35rem .6rem;font-size:.74rem">' +
                        '<option value="active"' + (c.status === 'active' ? ' selected' : '') + '>' + esc(T('active')) + '</option>' +
                        '<option value="locked"' + (c.status === 'locked' ? ' selected' : '') + '>' + esc(T('locked')) + '</option>' +
                        '<option value="coming_soon"' + (c.status === 'coming_soon' ? ' selected' : '') + '>' + esc(T('soon')) + '</option>' +
                    '</select>' +
                    '<button type="button" class="kfg-icon-btn is-primary kfga-lessons-btn" data-id="' + c.id + '" title="' + esc(T('open')) + '">📚</button>' +
                    '<button type="button" class="kfg-icon-btn kfga-move" data-id="' + c.id + '" data-dir="up" ' + (i === 0 ? 'disabled' : '') + ' title="↑">↑</button>' +
                    '<button type="button" class="kfg-icon-btn kfga-move" data-id="' + c.id + '" data-dir="down" ' + (i === state.courses.length - 1 ? 'disabled' : '') + ' title="↓">↓</button>' +
                    '<button type="button" class="kfg-icon-btn is-warn kfga-edit-course" data-id="' + c.id + '" title="' + esc(T('edit')) + '">✏️</button>' +
                    '<button type="button" class="kfg-icon-btn is-danger kfga-del-course" data-id="' + c.id + '" title="' + esc(T('del')) + '">🗑️</button>' +
                '</span>' +
            '</div>';
        });
        wrap.innerHTML = html;

        var sl = $('kfga-stat-lessons');
        if (sl) sl.textContent = lessonsTotal;

        wrap.querySelectorAll('.kfga-lessons-btn').forEach(function (b) {
            b.addEventListener('click', function () { openCourse(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-edit-course').forEach(function (b) {
            b.addEventListener('click', function () { openCourseModal(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-del-course').forEach(function (b) {
            b.addEventListener('click', function () { deleteCourse(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-move').forEach(function (b) {
            b.addEventListener('click', function () {
                moveCourse(parseInt(b.getAttribute('data-id'), 10), b.getAttribute('data-dir'));
            });
        });
        wrap.querySelectorAll('.kfga-status').forEach(function (sel) {
            sel.addEventListener('change', function () {
                setCourseStatus(parseInt(sel.getAttribute('data-id'), 10), sel.value);
            });
        });
    }

    async function setCourseStatus(courseId, status) {
        var c = state.courses.find(function (x) { return x.id === courseId; });
        if (!c) return;
        var r = await api('/api/ferga/admin/courses/' + courseId, {
            method: 'PUT',
            body: {
                title_so: c.title_so, title_ba: c.title_ba,
                desc_so: c.desc_so, desc_ba: c.desc_ba,
                icon: c.icon, accent: c.accent, status: status,
            },
        });
        if (r.status === 401 || r.status === 403) { toast(T('unauthorized'), true); showUnauthorized(); return; }
        if (r.data && r.data.course) {
            Object.assign(c, r.data.course);
            toast(T('saved'));
        }
        renderCourses();
    }

    async function moveCourse(courseId, dir) {
        var r = await api('/api/ferga/admin/courses/' + courseId + '/move', { method: 'POST', body: { dir: dir } });
        if (r.data && r.data.ok) { toast(T('moved')); await loadCourses(); }
        else if (r.status === 422) { /* at end */ }
    }

    async function deleteCourse(courseId) {
        if (!confirm(T('delCourseQ'))) return;
        var r = await api('/api/ferga/admin/courses/' + courseId, { method: 'DELETE' });
        if (r.data && r.data.ok) { toast(T('deleted')); await loadCourses(); }
    }

    /* ------------------------------------------------------------------ */
    /* course modal                                                        */
    /* ------------------------------------------------------------------ */
    function openCourseModal(courseId) {
        var title = $('kfga-course-modal-title');
        title.textContent = courseId ? T('editCourse') : T('newCourse');
        var c = courseId ? state.courses.find(function (x) { return x.id === courseId; }) : null;
        $('kfga-course-id').value = courseId || '';
        $('kfga-course-title-so').value = c ? (c.title_so || '') : '';
        $('kfga-course-title-ba').value = c ? (c.title_ba || '') : '';
        $('kfga-course-desc-so').value = c ? (c.desc_so || '') : '';
        $('kfga-course-desc-ba').value = c ? (c.desc_ba || '') : '';
        $('kfga-course-icon').value = c ? (c.icon || '') : '📘';
        $('kfga-course-accent').value = c ? (c.accent || 'cyan') : 'cyan';
        $('kfga-course-status').value = c ? (c.status || 'active') : 'active';
        openModal('kfga-course-modal');
    }

    async function saveCourse() {
        var id = $('kfga-course-id').value;
        var titleSo = $('kfga-course-title-so').value.trim();
        var titleBa = $('kfga-course-title-ba').value.trim();
        if (!titleSo || !titleBa) { toast(T('missing'), true); return; }

        var body = {
            title_so: titleSo,
            title_ba: titleBa,
            desc_so: $('kfga-course-desc-so').value,
            desc_ba: $('kfga-course-desc-ba').value,
            icon: $('kfga-course-icon').value || '📘',
            accent: $('kfga-course-accent').value,
            status: $('kfga-course-status').value,
        };

        var r = id
            ? await api('/api/ferga/admin/courses/' + id, { method: 'PUT', body: body })
            : await api('/api/ferga/admin/courses', { method: 'POST', body: body });

        if (r.status === 401 || r.status === 403) { toast(T('unauthorized'), true); showUnauthorized(); return; }
        if (!r.data || !r.data.course) { toast(T('err'), true); return; }
        toast(T('saved'));
        closeModal('kfga-course-modal');
        await loadCourses();
    }

    /* ------------------------------------------------------------------ */
    /* lessons                                                             */
    /* ------------------------------------------------------------------ */
    async function openCourse(courseId) {
        state.activeCourse = state.courses.find(function (x) { return x.id === courseId; }) || null;
        $('kfga-courses-panel').classList.add('hidden');
        $('kfga-lessons-panel').classList.remove('hidden');
        var t = $('kfga-lessons-course-title');
        if (t) t.textContent = (state.activeCourse ? state.activeCourse.title_so : '') + ' / ' + (state.activeCourse ? state.activeCourse.title_ba : '');

        setLoading(true);
        var r = await api('/api/ferga/admin/courses/' + courseId + '/lessons');
        setLoading(false);

        if (r.status === 401 || r.status === 403) { showUnauthorized(); return; }
        state.lessons = (r.data && r.data.lessons) || [];
        renderLessons();
    }

    function backToCourses() {
        $('kfga-lessons-panel').classList.add('hidden');
        $('kfga-courses-panel').classList.remove('hidden');
        state.activeCourse = null;
        state.lessons = [];
    }

    function renderLessons() {
        var wrap = $('kfga-lessons');
        var empty = $('kfga-lessons-empty');
        if (!state.lessons.length) {
            if (empty) empty.classList.remove('hidden');
            if (wrap) wrap.innerHTML = '';
            return;
        }
        if (empty) empty.classList.add('hidden');

        var html = '';
        state.lessons.forEach(function (l, i) {
            var statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
            var statusTitle = l.status === 'active' ? '' : esc(T('locked'));
            if (l.status && l.status !== 'active') {
                statusIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><circle cx="12" cy="5" r="3.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            }
            html += '<div class="kfg-row" data-id="' + l.id + '">' +
                '<span class="kfg-icon-btn is-primary" style="cursor:default">#' + (i + 1) + '</span>' +
                '<span class="flex-1 min-w-[180px]">' +
                    '<span class="block font-black text-sm">' + esc(l.title_so) + '</span>' +
                    '<span class="block text-xs text-slate-500 dark:text-slate-400">' + esc(l.title_ba) + '</span>' +
                '</span>' +
                '<span class="kfg-actions">' +
                    '<button type="button" class="kfg-icon-btn kfga-move-lesson" data-id="' + l.id + '" data-dir="up" ' + (i === 0 ? 'disabled' : '') + ' title="↑">↑</button>' +
                    '<button type="button" class="kfg-icon-btn kfga-move-lesson" data-id="' + l.id + '" data-dir="down" ' + (i === state.lessons.length - 1 ? 'disabled' : '') + ' title="↓">↓</button>' +
                    '<button type="button" class="kfg-icon-btn ' + (l.status && l.status !== 'active' ? 'is-warn' : '') + ' kfga-lock-lesson" data-id="' + l.id + '" title="' + statusTitle + '">' + statusIcon + '</button>' +
                    '<button type="button" class="kfg-icon-btn is-warn kfga-edit-lesson" data-id="' + l.id + '" title="' + esc(T('edit')) + '">✏️</button>' +
                    '<button type="button" class="kfg-icon-btn is-danger kfga-del-lesson" data-id="' + l.id + '" title="' + esc(T('del')) + '">🗑️</button>' +
                '</span>' +
            '</div>';
        });
        wrap.innerHTML = html;

        wrap.querySelectorAll('.kfga-lock-lesson').forEach(function (b) {
            b.addEventListener('click', function () { toggleLessonLock(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-edit-lesson').forEach(function (b) {
            b.addEventListener('click', function () { openLessonModal(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-del-lesson').forEach(function (b) {
            b.addEventListener('click', function () { deleteLesson(parseInt(b.getAttribute('data-id'), 10)); });
        });
        wrap.querySelectorAll('.kfga-move-lesson').forEach(function (b) {
            b.addEventListener('click', function () {
                moveLesson(parseInt(b.getAttribute('data-id'), 10), b.getAttribute('data-dir'));
            });
        });
    }

    async function moveLesson(lessonId, dir) {
        var r = await api('/api/ferga/admin/lessons/' + lessonId + '/move', { method: 'POST', body: { dir: dir } });
        if (r.data && r.data.ok) { toast(T('moved')); await openCourse(state.activeCourse.id); }
    }

    async function deleteLesson(lessonId) {
        if (!confirm(T('delLessonQ'))) return;
        var r = await api('/api/ferga/admin/lessons/' + lessonId, { method: 'DELETE' });
        if (r.data && r.data.ok) { toast(T('deleted')); await openCourse(state.activeCourse.id); }
    }

    async function toggleLessonLock(lessonId) {
        var l = state.lessons.find(function (x) { return x.id === lessonId; });
        if (!l) return;
        var next;
        if (l.status === 'active') next = 'coming_soon';
        else if (l.status === 'coming_soon') next = 'active';
        else next = 'coming_soon';
        var r = await api('/api/ferga/admin/lessons/' + lessonId, { method: 'PUT', body: { status: next } });
        if (r.data && r.data.lesson) { toast(T('saved')); await openCourse(state.activeCourse.id); }
    }

    /* ------------------------------------------------------------------ */
    /* lesson modal + rich editor                                          */
    /* ------------------------------------------------------------------ */
    /* Both dialects are edited SIDE-BY-SIDE — one full editor per column,
       never a shared area with tabs. IDs mirror ferga_admin.blade.php. */
    var EDITORS = {
        so: { area: 'kfga-content-so', src: 'kfga-src-so', title: 'kfga-lesson-title-so', desc: 'kfga-lesson-desc-so' },
        ba: { area: 'kfga-content-ba', src: 'kfga-src-ba', title: 'kfga-lesson-title-ba', desc: 'kfga-lesson-desc-ba' },
    };

    function openLessonModal(lessonId) {
        var l = lessonId ? state.lessons.find(function (x) { return x.id === lessonId; }) : null;
        $('kfga-lesson-modal-title').textContent = lessonId ? T('editLesson') : T('newLesson');
        $('kfga-lesson-id').value = lessonId || '';
        $('kfga-lesson-language').value = 'python';
        $('kfga-lesson-starter').value = l ? (l.starter_code || '') : '';
        var mediaEl = $('kfga-lesson-media');
        if (mediaEl) {
            var mediaVal = '';
            if (l && l.media) {
                if (typeof l.media === 'string') mediaVal = l.media;
                else if (Array.isArray(l.media)) mediaVal = l.media.join(', ');
                else mediaVal = JSON.stringify(l.media);
            }
            mediaEl.value = mediaVal;
        }

        state.editor = {
            so: { title: l ? (l.title_so || '') : '', desc: l ? (l.desc_so || '') : '', html: l ? (l.content_so || '') : '' },
            ba: { title: l ? (l.title_ba || '') : '', desc: l ? (l.desc_ba || '') : '', html: l ? (l.content_ba || '') : '' },
        };
        state.editorSrc = {};
        syncEditors();
        openModal('kfga-lesson-modal');
    }

    function syncEditors() {
        Object.keys(EDITORS).forEach(function (k) {
            var ids = EDITORS[k];
            var c = state.editor[k];
            $(ids.title).value = c.title;
            $(ids.desc).value = c.desc;
            var area = $(ids.area);
            var src = $(ids.src);
            if (state.editorSrc[ids.area]) {
                area.hidden = true;
                src.hidden = false;
                src.value = c.html;
            } else {
                src.hidden = true;
                area.hidden = false;
                area.innerHTML = c.html;
            }
        });
    }

    function readEditor(k) {
        var ids = EDITORS[k];
        var c = state.editor[k];
        c.title = $(ids.title).value;
        c.desc = $(ids.desc).value;
        var area = $(ids.area);
        var src = $(ids.src);
        c.html = area.hidden ? src.value : area.innerHTML;
        state.editor[k] = c;
    }

    /* Resolve the editor a toolbar button belongs to, from data-toolbar. */
    function editorAreas(btn) {
        var tb = btn.closest('[data-toolbar]');
        var edId = tb ? tb.getAttribute('data-toolbar') : 'kfga-content-so';
        var area = $(edId);
        var src = $('kfga-src-' + edId.replace('kfga-content-', ''));
        return { area: area, src: src };
    }

    function insertBlockTag(tag, attrs, area) {
        if (area.hidden) return;
        area.focus();
        var sel = window.getSelection && getSelection();
        var text = '';
        if (sel && sel.rangeCount && area.contains(sel.anchorNode)) {
            text = String(sel.toString());
        }
        var open = '<' + tag + (attrs || '') + '>';
        var close = '</' + tag + '>';
        var html = (text ? esc(text) : '\n');
        document.execCommand('insertHTML', false, '\n' + open + '\n' + html + '\n' + close + '\n');
    }

    function editorCommand(cmd, btn) {
        var ed = editorAreas(btn);
        var area = ed.area;
        if (area.hidden) return;

        if (cmd === 'source') {
            if (ed.src.hidden) {
                ed.src.value = area.innerHTML;
                area.hidden = true;
                ed.src.hidden = false;
            } else {
                area.innerHTML = ed.src.value;
                ed.src.hidden = true;
                area.hidden = false;
            }
            state.editorSrc[area.id] = !ed.src.hidden;
            return;
        }
        if (cmd === 'h3') { area.focus(); document.execCommand('formatBlock', false, 'H3'); return; }
        if (cmd === 'p') { area.focus(); document.execCommand('formatBlock', false, 'P'); return; }
        if (cmd === 'ul') { area.focus(); document.execCommand('insertUnorderedList', false, null); return; }
        if (cmd === 'ol') { area.focus(); document.execCommand('insertOrderedList', false, null); return; }
        if (cmd === 'blockquote') { area.focus(); document.execCommand('formatBlock', false, 'BLOCKQUOTE'); return; }
        if (cmd === 'bold') { area.focus(); document.execCommand('bold', false, null); return; }
        if (cmd === 'italic') { area.focus(); document.execCommand('italic', false, null); return; }
        if (cmd === 'link') {
            area.focus();
            var url = prompt('URL:');
            if (url) document.execCommand('createLink', false, url.trim());
            return;
        }
        if (cmd === 'code') {
            area.focus();
            var sel = window.getSelection && getSelection();
            var t = (sel && sel.rangeCount && area.contains(sel.anchorNode)) ? String(sel.toString()) : '';
            if (t) {
                document.execCommand('insertHTML', false, '<code>' + esc(t) + '</code>');
            } else {
                document.execCommand('insertHTML', false, '<code></code>');
            }
            return;
        }
        if (cmd === 'codeblock') {
            insertBlockTag('pre', ' data-kai-code', area);
            return;
        }
        if (cmd === 'runblock') {
            var langSel = $('kfga-lesson-language');
            insertBlockTag('pre', ' data-lang="' + esc(langSel ? langSel.value : 'python') + '" data-run="1"', area);
            return;
        }
    }

    async function saveLesson() {
        var id = $('kfga-lesson-id').value;
        if (!state.activeCourse) return;
        readEditor('so');
        readEditor('ba');

        var titleSo = (state.editor.so.title || '').trim();
        var titleBa = (state.editor.ba.title || '').trim();
        if (!titleSo || !titleBa) { toast(T('missing'), true); return; }

        var mediaEl = $('kfga-lesson-media');
        var mediaStr = mediaEl ? (mediaEl.value || '').trim() : '';
        var media = mediaStr ? mediaStr.split(',').map(function (s) { return s.trim(); }).filter(Boolean) : null;

        var body = {
            title_so: titleSo,
            title_ba: titleBa,
            desc_so: state.editor.so.desc || '',
            desc_ba: state.editor.ba.desc || '',
            content_so: state.editor.so.html || '',
            content_ba: state.editor.ba.html || '',
            code_language: 'python',
            starter_code: $('kfga-lesson-starter').value || '',
            section_id: $('kfga-lesson-section').value || '',
            media: media,
        };

        var r = id
            ? await api('/api/ferga/admin/lessons/' + id, { method: 'PUT', body: body })
            : await api('/api/ferga/admin/courses/' + state.activeCourse.id + '/lessons', { method: 'POST', body: body });

        if (r.status === 401 || r.status === 403) { toast(T('unauthorized'), true); showUnauthorized(); return; }
        if (!r.data || !r.data.lesson) { toast(T('err'), true); return; }
        toast(T('saved'));
        closeModal('kfga-lesson-modal');
        await openCourse(state.activeCourse.id);
    }

    /* ------------------------------------------------------------------ */
    /* modal helpers                                                       */
    /* ------------------------------------------------------------------ */
    function openModal(id) { $(id).classList.add('is-open'); }
    function closeModal(id) { $(id).classList.remove('is-open'); }

    /* ------------------------------------------------------------------ */
    /* wiring                                                              */
    /* ------------------------------------------------------------------ */
    function wire() {
        $('kfga-new-course').addEventListener('click', function () { openCourseModal(null); });
        $('kfga-course-save').addEventListener('click', saveCourse);
        $('kfga-new-lesson').addEventListener('click', function () { openLessonModal(null); });
        $('kfga-lesson-save').addEventListener('click', saveLesson);
        $('kfga-back-courses').addEventListener('click', backToCourses);

        document.querySelectorAll('.kfga-close').forEach(function (b) {
            b.addEventListener('click', function () { closeModal(b.getAttribute('data-modal')); });
        });
        document.querySelectorAll('.kfg-modal').forEach(function (m) {
            m.addEventListener('click', function (e) {
                if (e.target === m) m.classList.remove('is-open');
            });
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.kfg-modal.is-open').forEach(function (m) { m.classList.remove('is-open'); });
            }
        });

        document.querySelectorAll('[data-toolbar] [data-cmd]').forEach(function (b) {
            b.addEventListener('click', function () { editorCommand(b.getAttribute('data-cmd'), b); });
        });

        window.addEventListener('kai:langchange', function () {
            applyStaticLang();
            if (!$('kfga-courses-panel').classList.contains('hidden')) renderCourses();
            else if (state.lessons.length) renderLessons();
        });
    }

    ready(function () {
        applyStaticLang();
        wire();

        // Never let the browser navigate away when a file is dropped anywhere
        // on the page.
        document.addEventListener('dragover', function (e) { e.preventDefault(); });
        document.addEventListener('drop', function (e) { e.preventDefault(); });

        initFirebase();
    });
})();
