/* ==========================================================================
   KURD AI — فێرگە learning SPA (kai-ferga-learn.js)
   Drives /ferga (view: resources/views/ferga_learn.blade.php).
   Talks to the Laravel JSON API (routes/web.php → FergaController):
     GET  /api/ferga/courses
     GET  /api/ferga/courses/{course}
     GET  /api/ferga/lessons/{lesson}
     POST /api/ferga/lessons/{lesson}/complete
   Identity = Firebase ID token (optional for reads, required to complete).
   ========================================================================== */
(function () {
    'use strict';

    var API = {
        courses: '/api/ferga/courses',
    };

    /* ------------------------------------------------------------------ */
    /* tiny helpers                                                        */
    /* ------------------------------------------------------------------ */
    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }
    function $(id) { return document.getElementById(id); }
    function lang() { return (localStorage.getItem('site-lang') || 'so') === 'ba' ? 'ba' : 'so'; }
    function esc(v) {
        return String(v == null ? '' : v)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }
    function locTitle(o) { return lang() === 'ba' && o.title_ba ? o.title_ba : (o.title_so || o.title || ''); }
    function locDesc(o) { return lang() === 'ba' && o.desc_ba ? o.desc_ba : (o.desc_so || o.desc || ''); }

    var ACCENTS = {
        cyan: '#22d3ee', blue: '#3b82f6', purple: '#a855f7', pink: '#ec4899',
        amber: '#f59e0b', green: '#22c55e', sky: '#38bdf8', indigo: '#6366f1',
        rose: '#f43f5e', teal: '#14b8a6',
    };

    var UI = {
        locked: { so: 'دووربەستە', ba: 'قفڵکری' },
        done: { so: 'تەواو کراوە', ba: 'تەواو کری' },
        soon: { so: 'بەم زوانە', ba: 'بەم دیمە' },
        active: { so: 'بەردەست', ba: 'بەردەست' },
        lessonsCount: { so: 'وانە', ba: 'وانە' },
        lessonNum: { so: 'وانەی', ba: 'وانەی' },
        openCourse: { so: 'کردنەوە', ba: 'ڤەکرن' },
        loginFirst: { so: 'بۆ تۆمارکردنی پێشکەوتن سەرەتا بچۆ ژوورەوە.', ba: 'بۆ تومارکرنا پێشکەفتنێ یێکێم بچە ژورەڤە.' },
        completing: { so: 'تۆمارکردن...', ba: 'تومارکرن...' },
        doneLesson: { so: '✓ وانەکەت تەواو کرد', ba: '✓ وانەیێ تەواو کری' },
        undoneLesson: { so: 'پێشکەوتنەکە سڕایەوە', ba: 'پێشکەفتن هاتە سڕینەوە' },
        nextUnlock: { so: 'کۆرسی دواتر دەکرێتەوە!', ba: 'کورسێ دوڤێ ڤەدبیت!' },
        courseDone: { so: 'کۆرسەکەت تەواو کرد 🎉', ba: 'کورسێ تەواو کری 🎉' },
        completeBtn: { so: 'تەواوکردنی وانەکە ✓', ba: 'تەواوکرنا وانەیێ ✓' },
        doneBtn: { so: '✓ تەواو کراوە', ba: '✓ تەواو کری' },
        noNext: { so: '—', ba: '—' },
        prev: { so: 'پێشوو', ba: 'بەری' },
        next: { so: 'دواتر', ba: 'پیڤا' },
        loaded: { so: 'وەڵام', ba: 'بەرسڤ' },
        noLessons: { so: 'هێشتا هیچ وانەیەک نییە.', ba: 'هێشتا چ وانە نینن.' },
        lockedLesson: { so: 'یەکەم وانەکانی پێشووی کۆرسەکە تەواو بکە.', ba: 'یانەیێن بەری یێن کورسێ دەستپێک تەواو بکە.' },
        editLesson: { so: 'دەستکاریکردنی وانە', ba: 'سەرڤێکرنا وانەیێ' },
        newLesson: { so: 'وانەی نوێ', ba: 'وانەیێ نوی' },
        addLesson: { so: '➕ وانەی نوێ زیاد بکە', ba: '➕ وانەیێ نوی زێدە بکە' },
        saved: { so: 'پاشەکەوت کرا ✓', ba: 'پاشەکەوت بوو ✓' },
        missing: { so: 'تکایە ناونیشان پڕ بکەرەوە.', ba: 'تکایە ناڤ پڕ بکە.' },
        err: { so: 'هەڵەیەک ڕوویدا', ba: 'خەلەتەک ڕوویدا' },
        lock: { so: 'قفڵ', ba: 'قفڵ' },
        unlock: { so: 'کردنەوە', ba: 'ڤەکرن' },
        editCourse: { so: 'دەستکاری', ba: 'سەرڤێکرن' },
    };
    function T(key) { return (UI[key] || {})[lang()] || ''; }

    /* ------------------------------------------------------------------ */
    /* state                                                               */
    /* ------------------------------------------------------------------ */
    var state = {
        courses: [],
        totalLessons: 0,
        course: null,          // currently open course payload
        lessons: [],           // meta list of the open course
        lessonIndex: -1,       // index in state.lessons
        lessonContent: null,
        currentLang: lang(),
        isAdmin: false,        // from GET /api/ferga/courses (is_admin)
    };

    var authUser = null;
    var authReady = false;
    var pyLoaded = false;

    /* ------------------------------------------------------------------ */
    /* firebase bootstrap                                                  */
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
                        authMod.onAuthStateChanged(auth, function (user) {
                            authUser = user;
                            authReady = true;
                            refreshCourses();
                        });
                    });
            })
            .catch(function () { authReady = true; refreshCourses(); });
    }

    async function token() {
        if (!authUser) return '';
        try { return await authUser.getIdToken(); } catch (e) { return ''; }
    }

    /* ------------------------------------------------------------------ */
    /* API                                                                 */
    /* ------------------------------------------------------------------ */
    async function api(path, opts) {
        opts = opts || {};
        var headers = { 'Accept': 'application/json' };
        var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
        if (csrf) headers['X-CSRF-TOKEN'] = csrf;
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
    /* toast                                                               */
    /* ------------------------------------------------------------------ */
    var toastTimer = null;
    function toast(msg, isErr) {
        var el = $('kfg-toast');
        if (!el) return;
        el.textContent = msg;
        el.style.background = isErr ? 'linear-gradient(120deg,#e11d48,#f43f5e)' : 'linear-gradient(120deg,#059669,#0ea5e9)';
        el.classList.remove('hidden');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { el.classList.add('hidden'); }, 2800);
    }

    /* ------------------------------------------------------------------ */
    /* ring + stats                                                        */
    /* ------------------------------------------------------------------ */
    function renderStats() {
        var doneCourses = 0, doneLessons = 0, totalLessons = 0;
        state.courses.forEach(function (c) {
            totalLessons += c.lessons_count || 0;
            doneLessons += c.completed_lessons || 0;
            if (c.completed) doneCourses++;
        });
        var pct = totalLessons > 0 ? Math.round((doneLessons / totalLessons) * 100) : 0;
        var ring = $('kfg-ring');
        if (ring) ring.style.setProperty('--kfg-ring-val', pct);
        var pctEl = $('kfg-ring-pct');
        if (pctEl) pctEl.textContent = pct + '%';
        var sc = $('kfg-stat-courses'); if (sc) sc.textContent = doneCourses + ' / ' + state.courses.length;
        var sl = $('kfg-stat-lessons'); if (sl) sl.textContent = doneLessons + ' / ' + totalLessons;
    }

    /* ------------------------------------------------------------------ */
    /* course path rendering                                               */
    /* ------------------------------------------------------------------ */
    function statusBadge(c) {
        if (c.status === 'coming_soon') {
            return '<span class="kfg-badge kfg-badge--soon">🕒 ' + esc(T('soon')) + '</span>';
        }
        if (c.locked) {
            return '<span class="kfg-badge kfg-badge--lock">🔒 ' + esc(T('locked')) + '</span>';
        }
        if (c.completed) {
            return '<span class="kfg-badge kfg-badge--done">✓ ' + esc(T('done')) + '</span>';
        }
        return '<span class="kfg-badge kfg-badge--active">' + esc(T('active')) + '</span>';
    }

    function renderPath() {
        var wrap = $('kfg-path');
        var loading = $('kfg-loading');
        var empty = $('kfg-empty');
        if (loading) loading.classList.add('hidden');
        if (!state.courses.length) {
            if (empty) empty.classList.remove('hidden');
            if (wrap) wrap.innerHTML = '';
            renderStats();
            return;
        }
        if (empty) empty.classList.add('hidden');

        var html = '';
        state.courses.forEach(function (c) {
            var pct = c.lessons_count > 0 ? Math.round((c.completed_lessons / c.lessons_count) * 100) : 0;
            var accent = ACCENTS[c.accent] || ACCENTS.cyan;
            var cls = 'kfg-course' + (state.isAdmin ? ' is-admin' : '');
            if (c.locked) cls += ' is-locked';
            if (c.completed) cls += ' is-done';

            // Admins get per-course edit + lock/unlock actions.
            var admin = '';
            if (state.isAdmin) {
                var lockedNow = c.status === 'locked' || c.status === 'coming_soon';
                admin =
                    '<div class="kfg-course__admin">' +
                        '<button type="button" class="kfg-course__admin-btn" data-action="edit" data-id="' + c.id + '">' +
                            '✏️ ' + esc(T('editCourse')) +
                        '</button>' +
                        '<button type="button" class="kfg-course__admin-btn" data-action="lock" data-id="' + c.id + '">' +
                            (lockedNow ? '🔓 ' + esc(T('unlock')) : '🔒 ' + esc(T('lock'))) +
                        '</button>' +
                    '</div>';
            }

            html += '<div class="' + cls + '" style="--kfg-accent:' + accent + '">' +
                '<button type="button" class="kfg-course__open" data-id="' + c.id + '"' + (c.locked && !state.isAdmin ? ' disabled' : '') + '>' +
                    '<div class="kfg-course__top">' +
                        '<span class="kfg-course__icon">' + esc(c.icon || '📘') + '</span>' +
                        '<span class="kfg-course__head">' +
                            '<span class="kfg-course__num">' + esc(T('lessonNum')) + ' ' + c.position + '</span>' +
                            '<span class="kfg-course__title">' + esc(locTitle(c)) + '</span>' +
                        '</span>' +
                    '</div>' +
                    '<p class="kfg-course__desc">' + esc(locDesc(c)) + '</p>' +
                    '<div class="kfg-course__foot">' +
                        '<span>' + c.lessons_count + ' ' + esc(T('lessonsCount')) + '</span>' +
                        '<span class="flex items-center gap-2 flex-1 justify-end">' +
                            '<span class="kfg-progress"><span class="kfg-progress__fill" style="width:' + pct + '%"></span></span>' +
                            '<span class="text-xs font-black">' + pct + '%</span>' +
                        '</span>' +
                    '</div>' +
                    '<div class="kfg-course__status">' + statusBadge(c) + '</div>' +
                '</button>' +
                admin +
            '</div>';
        });
        wrap.innerHTML = html;

        wrap.querySelectorAll('.kfg-course__open[data-id]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openCourse(parseInt(btn.getAttribute('data-id'), 10));
            });
        });

        if (state.isAdmin) {
            wrap.querySelectorAll('.kfg-course__admin-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var id = parseInt(btn.getAttribute('data-id'), 10);
                    if (btn.getAttribute('data-action') === 'edit') openCourseEditor(id);
                    else toggleCourseLock(id);
                });
            });
        }

        renderStats();
    }

    /* ------------------------------------------------------------------ */
    /* admin: course editor (edit + lock/unlock on the path page)          */
    /* ------------------------------------------------------------------ */
    function openCourseEditor(courseId) {
        var c = state.courses.find(function (x) { return x.id === courseId; });
        if (!c) return;
        $('kfgl-course-id').value = c.id;
        $('kfgl-course-title-so').value = c.title_so || '';
        $('kfgl-course-title-ba').value = c.title_ba || '';
        $('kfgl-course-desc-so').value = c.desc_so || '';
        $('kfgl-course-desc-ba').value = c.desc_ba || '';
        $('kfgl-course-icon').value = c.icon || '';
        $('kfgl-course-accent').value = ACCENTS[c.accent] ? c.accent : 'cyan';
        $('kfgl-course-status').value = c.status || 'active';
        var m = $('kfgl-course-modal');
        if (m) m.classList.add('is-open');
        applyStaticLang();
    }

    function closeCourseEditor() {
        var m = $('kfgl-course-modal');
        if (m) m.classList.remove('is-open');
    }

    async function saveCourseEditor() {
        var body = {
            title_so: $('kfgl-course-title-so').value.trim(),
            title_ba: $('kfgl-course-title-ba').value.trim(),
            desc_so: $('kfgl-course-desc-so').value.trim(),
            desc_ba: $('kfgl-course-desc-ba').value.trim(),
            icon: $('kfgl-course-icon').value.trim(),
            accent: $('kfgl-course-accent').value,
            status: $('kfgl-course-status').value,
        };
        if (!body.title_so || !body.title_ba) { toast(T('missing'), true); return; }
        var r = await api('/api/ferga/admin/courses/' + $('kfgl-course-id').value, { method: 'PUT', body: body });
        if (r.status === 401 || r.status === 403) { toast(T('loginFirst'), true); return; }
        if (r.status >= 200 && r.status < 300) {
            toast(T('saved'));
            closeCourseEditor();
            await refreshCourses();
        } else {
            toast(String((r.data && r.data.message) || T('err')), true);
        }
    }

    async function toggleCourseLock(courseId) {
        var c = state.courses.find(function (x) { return x.id === courseId; });
        if (!c) return;
        var next = (c.status === 'locked' || c.status === 'coming_soon') ? 'active' : 'locked';
        var r = await api('/api/ferga/admin/courses/' + courseId, {
            method: 'PUT',
            body: {
                title_so: c.title_so, title_ba: c.title_ba,
                desc_so: c.desc_so || '', desc_ba: c.desc_ba || '',
                icon: c.icon || '', accent: c.accent || 'cyan', status: next,
            },
        });
        if (r.status === 401 || r.status === 403) { toast(T('loginFirst'), true); return; }
        if (r.status >= 200 && r.status < 300) {
            toast(T('saved'));
            await refreshCourses();
        } else {
            toast(String((r.data && r.data.message) || T('err')), true);
        }
    }

    /* ------------------------------------------------------------------ */
    /* reader                                                              */
    /* ------------------------------------------------------------------ */
    async function openCourse(courseId) {
        var pathView = $('kfg-path-view');
        var reader = $('kfg-reader');
        var article = $('kfg-article');
        var body = $('kfg-lesson-body');
        var loading = $('kfg-lesson-loading');

        if (pathView) pathView.classList.add('hidden');
        if (reader) reader.classList.remove('hidden');
        if (article) article.classList.remove('hidden');
        if (loading) loading.classList.remove('hidden');
        if (body) body.classList.add('hidden');

        window.scrollTo({ top: 0, behavior: 'smooth' });

        var course = state.courses.find(function (c) { return c.id === courseId; });
        if (course) {
            var titleEl = $('kfg-course-title');
            if (titleEl) titleEl.textContent = esc(locTitle(course));
        }

        var r = await api(API.courses + '/' + courseId);
        if (r.status === 403) {
            toast((r.data && r.data.message === 'coming_soon')
                ? esc(T('soon'))
                : esc(T('locked')), true);
            showPath();
            return;
        }
        state.course = r.data.course || course;
        state.lessons = r.data.lessons || [];
        state.lessonIndex = state.lessons.length ? 0 : -1;

        renderSidebar();
        renderCourseProgress();

        if (state.lessonIndex >= 0) {
            openLesson(state.lessonIndex);
        } else {
            if (loading) loading.classList.add('hidden');
            if (body) body.classList.remove('hidden');
            var content = $('kfg-content');
            if (content) {
                content.innerHTML = '<p class="text-slate-500 dark:text-slate-400">' + esc(T('noLessons')) + '</p>';
            }
        }
    }

    function showPath() {
        var pathView = $('kfg-path-view');
        var reader = $('kfg-reader');
        if (pathView) pathView.classList.remove('hidden');
        if (reader) reader.classList.add('hidden');
    }

    function renderCourseProgress() {
        var done = 0;
        state.lessons.forEach(function (l) { if (l.completed) done++; });
        var pct = state.lessons.length ? Math.round((done / state.lessons.length) * 100) : 0;
        var bar = $('kfg-course-progress');
        if (bar) bar.style.width = pct + '%';
    }

    function renderSidebar() {
        var wrap = $('kfg-sidebar');
        if (!wrap) return;
        var html = '';
        state.lessons.forEach(function (l, i) {
            var soon = l.status && l.status !== 'active';
            var locked = !state.isAdmin && l.locked;
            var cls = 'kfg-sidebar__item';
            if (i === state.lessonIndex) cls += ' is-current';
            if (l.completed) cls += ' is-done';
            if (locked) cls += ' is-locked';

            var icon = '';
            if (l.completed) {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="0" stroke-linecap="square" stroke-linejoin="miter"><polyline points="20 6 9 17 4 12"/></svg>';
            } else if (locked) {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><circle cx="12" cy="5" r="3.3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>';
            } else {
                icon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>';
            }

            html += '<div class="' + cls + '">' +
                '<button type="button" class="kfg-sidebar__open" data-i="' + i + '"' + (locked ? ' disabled' : '') + '>' +
                    '<span class="kfg-sidebar__icon">' + icon + '</span>' +
                    '<span class="flex-1 text-start">' + esc(locTitle(l)) + '</span>' +
                    (locked
                        ? (soon
                            ? '<span class="kfg-sidebar__soon">🕒 ' + esc(T('soon')) + '</span>'
                            : '<span class="kfg-sidebar__lock">🔒</span>')
                        : '') +
                '</button>' +
                (state.isAdmin
                    ? '<button type="button" class="kfg-sidebar__lockbtn' + (soon ? ' is-locked' : '') + '" data-lock-i="' + i + '" title="' + esc(T('lock')) + '">🔒</button>' +
                      '<button type="button" class="kfg-sidebar__edit" data-edit-i="' + i + '" title="' + esc(T('editLesson')) + '">✏️</button>'
                    : '') +
            '</div>';
        });
        if (state.isAdmin) {
            html += '<button type="button" id="kfg-add-lesson" class="kfg-add-lesson">' + esc(T('addLesson')) + '</button>';
        }
        wrap.innerHTML = html;

        wrap.querySelectorAll('.kfg-sidebar__open').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openLesson(parseInt(btn.getAttribute('data-i'), 10));
            });
        });
        wrap.querySelectorAll('.kfg-sidebar__lockbtn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                toggleLessonLock(parseInt(btn.getAttribute('data-lock-i'), 10));
            });
        });
        wrap.querySelectorAll('.kfg-sidebar__edit').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openLessonEditor(parseInt(btn.getAttribute('data-edit-i'), 10));
            });
        });
        var add = $('kfg-add-lesson');
        if (add) add.addEventListener('click', openNewLesson);
    }

    async function toggleLessonLock(index) {
        if (!state.isAdmin || !state.course) return;
        var lesson = state.lessons[index];
        if (!lesson) return;
        var next = (lesson.status && lesson.status !== 'active') ? 'active' : 'coming_soon';
        var r = await api('/api/ferga/admin/lessons/' + lesson.id, { method: 'PUT', body: { status: next } });
        if (r.status === 401 || r.status === 403) { toast(T('loginFirst'), true); return; }
        if (!r.data || !r.data.lesson) { toast(T('err'), true); return; }
        toast(T('saved'));

        // Refresh the course so the sidebar reflects the new lock state.
        var r2 = await api(API.courses + '/' + state.course.id);
        if (r2.status === 403) { showPath(); return; }
        state.course = r2.data.course || state.course;
        state.lessons = r2.data.lessons || [];
        renderSidebar();
        renderCourseProgress();
    }

    async function openLesson(index) {
        if (index < 0 || index >= state.lessons.length) return;
        var lesson = state.lessons[index];
        if (lesson.locked && !state.isAdmin) {
            toast(lesson.lock_reason === 'coming_soon' ? T('soon') : T('lockedLesson'), true);
            return;
        }
        state.lessonIndex = index;
        renderSidebar();

        var loading = $('kfg-lesson-loading');
        var body = $('kfg-lesson-body');
        if (loading) loading.classList.remove('hidden');
        if (body) body.classList.add('hidden');

        var lesson = state.lessons[index];
        var titleEl = $('kfg-lesson-title');
        var descEl = $('kfg-lesson-desc');
        var contentEl = $('kfg-content');
        var metaEl = $('kfg-lesson-meta');
        if (titleEl) titleEl.textContent = '';
        if (contentEl) contentEl.innerHTML = '';
        if (metaEl) metaEl.textContent = '';

        var r = await api('/api/ferga/lessons/' + lesson.id);

        var l = (r.data && r.data.lesson) || {};
        state.lessonContent = l;

        if (titleEl) titleEl.textContent = locTitle(l);
        if (descEl) {
            var d = lang() === 'ba' ? (l.desc_ba || '') : (l.desc_so || '');
            descEl.textContent = d;
            descEl.classList.toggle('hidden', !d);
        }
        if (metaEl) metaEl.textContent = (lang() === 'ba' ? 'وانەی ' : 'وانەی ') + (index + 1) + ' / ' + state.lessons.length;
        if (contentEl) {
            var html = lang() === 'ba' && l.content_ba ? l.content_ba : (l.content_so || '');
            if (l.starter_code && !/data-run|data-kai-code|<pre/i.test(html)) {
                html += '\n<pre data-lang="python" data-run="1">' + esc(l.starter_code) + '</pre>';
            }
            contentEl.innerHTML = html;

            // Render media images above the content if present
            if (l.media && Array.isArray(l.media) && l.media.length) {
                var mediaWrap = document.createElement('div');
                mediaWrap.className = 'kfg-media';
                l.media.forEach(function (url) {
                    var img = document.createElement('img');
                    img.src = url;
                    img.alt = '';
                    img.onerror = function () { img.style.display = 'none'; };
                    mediaWrap.appendChild(img);
                });
                contentEl.parentNode.insertBefore(mediaWrap, contentEl);
            }

            enhanceCode(contentEl);
        }

        renderCompleteButton(l.completed);
        renderNavButtons();

        if (loading) loading.classList.add('hidden');
        if (body) body.classList.remove('hidden');
        var article = $('kfg-article');
        if (article) article.scrollTop = 0;
    }

    function enhanceCode(root) {
        if (window.KaiPy && window.KaiPy.enhance) {
            try { window.KaiPy.enhance(root); pyLoaded = true; }
            catch (e) {}
        }
    }

    function renderCompleteButton(completed) {
        var btn = $('kfg-complete-btn');
        if (!btn) return;
        var label = $('kfg-complete-label');
        if (label) label.textContent = completed ? T('doneBtn') : T('completeBtn');
        btn.classList.toggle('is-done', !!completed);
        btn.disabled = false;
        btn.setAttribute('data-done', completed ? '1' : '0');
    }

    function renderNavButtons() {
        var prev = $('kfg-prev');
        var next = $('kfg-next');
        if (prev) {
            prev.disabled = state.lessonIndex <= 0;
            prev.style.opacity = state.lessonIndex <= 0 ? '.4' : '1';
        }
        if (next) {
            var hasNext = state.lessonIndex < state.lessons.length - 1;
            next.disabled = !hasNext;
            next.style.opacity = hasNext ? '1' : '.4';
            next.textContent = hasNext ? T('next') + ' ←' : '';
        }
    }

    async function toggleComplete() {
        if (!authUser) {
            toast(T('loginFirst'), true);
            setTimeout(function () { window.location.href = '/login'; }, 1400);
            return;
        }
        if (state.lessonIndex < 0) return;
        var lesson = state.lessons[state.lessonIndex];
        var btn = $('kfg-complete-btn');
        if (btn) { btn.disabled = true; }

        var want = !(state.lessonContent && state.lessonContent.completed);
        var r = await api('/api/ferga/lessons/' + lesson.id + '/complete', {
            method: 'POST',
            body: { completed: want },
        });

        if (r.status === 401) {
            toast(T('loginFirst'), true);
            if (btn) btn.disabled = false;
            return;
        }
        if (r.status === 403) {
            toast(T('locked'), true);
            if (btn) btn.disabled = false;
            return;
        }

        lesson.completed = want;
        if (state.lessonContent) state.lessonContent.completed = want;

        var course = r.data && r.data.course;
        if (course) {
            updateCourseState(state.course.id, course);
            renderCompleteButton(want);
            renderSidebar();
            renderCourseProgress();
            renderStats();
            toast(want ? (course.completed ? T('courseDone') : T('doneLesson')) : T('undoneLesson'));
            if (want && course.completed) toast(T('nextUnlock'));
        }
    }

    function updateCourseState(courseId, fresh) {
        var idx = state.courses.findIndex(function (c) { return c.id === courseId; });
        if (idx >= 0) {
            state.courses[idx] = Object.assign({}, state.courses[idx], fresh);
            if (fresh.id === state.course.id) state.course = Object.assign({}, state.course, fresh);
        }
    }

    /* ------------------------------------------------------------------ */
    /* in-place lesson editor (admins only)                                */
    /* ------------------------------------------------------------------ */
    /* Reuses the shared kfg-* modal/editor CSS and the admin CRUD API:
         PUT  /api/ferga/admin/lessons/{lesson}
         POST /api/ferga/admin/courses/{course}/lessons
       The server re-checks admin rights on every write. */
    var editor = {};      // per dialect: { so: {title,desc,html}, ba: {...} }
    var editorSrc = {};   // which editor area is showing raw HTML source
    var L_EDIT = {
        so: { title: 'kfgl-lesson-title-so', desc: 'kfgl-lesson-desc-so', area: 'kfgl-content-so', src: 'kfgl-src-so' },
        ba: { title: 'kfgl-lesson-title-ba', desc: 'kfgl-lesson-desc-ba', area: 'kfgl-content-ba', src: 'kfgl-src-ba' },
    };

    function openLessonEditor(index) {
        var l = state.lessons[index];
        if (!l) return;
        $('kfgl-lesson-modal-title').textContent = T('editLesson');
        $('kfgl-lesson-id').value = l.id;

        // The meta list carries only title/desc — fetch the full content.
        api('/api/ferga/lessons/' + l.id).then(function (r) {
            var full = (r.data && r.data.lesson) || l;
            fillLessonEditor(full);
            openLessonEditorModal();
        });
    }

    function openNewLesson() {
        if (!state.course) return;
        $('kfgl-lesson-modal-title').textContent = T('newLesson');
        $('kfgl-lesson-id').value = '';
        fillLessonEditor({});
        openLessonEditorModal();
    }

    function fillLessonEditor(l) {
        $('kfgl-lesson-language').value = 'python';
        $('kfgl-lesson-starter').value = l.starter_code || '';
        var mediaEl = $('kfgl-lesson-media');
        if (mediaEl) {
            if (l.media && Array.isArray(l.media)) mediaEl.value = l.media.join(', ');
            else if (typeof l.media === 'string') mediaEl.value = l.media;
            else mediaEl.value = '';
        }
        editor = {
            so: { title: l.title_so || '', desc: l.desc_so || '', html: l.content_so || '' },
            ba: { title: l.title_ba || '', desc: l.desc_ba || '', html: l.content_ba || '' },
        };
        editorSrc = {};
        syncLessonEditor();
    }

    function syncLessonEditor() {
        ['so', 'ba'].forEach(function (k) {
            var ids = L_EDIT[k], c = editor[k];
            $(ids.title).value = c.title;
            $(ids.desc).value = c.desc;
            var area = $(ids.area), src = $(ids.src);
            if (editorSrc[ids.area]) {
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

    function readLessonEditor() {
        ['so', 'ba'].forEach(function (k) {
            var ids = L_EDIT[k], c = editor[k];
            c.title = $(ids.title).value;
            c.desc = $(ids.desc).value;
            var area = $(ids.area), src = $(ids.src);
            c.html = area.hidden ? src.value : area.innerHTML;
        });
    }

    function lessonEditorAreas(btn) {
        var tb = btn.closest('[data-toolbar]');
        var edId = tb ? tb.getAttribute('data-toolbar') : 'kfgl-content-so';
        return { area: $(edId), src: $(edId.replace('-content-', '-src-')) };
    }

    function lessonEditorCmd(cmd, btn) {
        var ed = lessonEditorAreas(btn);
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
            editorSrc[area.id] = !ed.src.hidden;
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
            document.execCommand('insertHTML', false, t ? '<code>' + esc(t) + '</code>' : '<code></code>');
            return;
        }
        if (cmd === 'codeblock') {
            insertBlockTag('pre', ' data-kai-code', area);
            return;
        }
        if (cmd === 'runblock') {
            insertBlockTag('pre', ' data-lang="' + esc($('kfgl-lesson-language').value || 'python') + '" data-run="1"', area);
            return;
        }
    }

    function insertBlockTag(tag, attrs, area) {
        if (area.hidden) return;
        area.focus();
        var sel = window.getSelection && getSelection();
        var text = (sel && sel.rangeCount && area.contains(sel.anchorNode)) ? String(sel.toString()) : '';
        document.execCommand('insertHTML', false,
            '\n<' + tag + (attrs || '') + '>\n' + (text ? esc(text) : '\n') + '\n</' + tag + '>\n');
    }

    /* ------------------------------------------------------------------ */
    /* smart paste — pasted text becomes beautiful lesson HTML             */
    /*   • lines starting with # / ## / ### → headings (slightly larger)   */
    /*   • **bold** / __bold__ → <strong> (rendered in accent color)       */
    /*   • *italic* → <em>, `code` → <code>, lists, links, paragraphs      */
    /*   • HTML pasted from docs/websites keeps its real headings/bold     */
    /* ------------------------------------------------------------------ */
    function inlineMarkup(s) {
        s = s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        s = s.replace(/`([^`]+)`/g, '<code>$1</code>');
        s = s.replace(/(\*\*|__)([^*_]+)\1/g, '<strong>$2</strong>');
        s = s.replace(/(\*|_)([^*_]+)\1/g, '<em>$2</em>');
        s = s.replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/g, '<a href="$2" target="_blank" rel="noopener">$1</a>');
        s = s.replace(/(https?:\/\/[^\s<]+)/g, '<a href="$1" target="_blank" rel="noopener">$1</a>');
        return s;
    }

    function markdownLite(text) {
        var out = [];
        var list = null;
        function closeList() { if (list) { out.push('</' + list + '>'); list = null; } }
        text.split(/\r?\n/).forEach(function (raw) {
            var line = raw.replace(/\s+/g, ' ').trim();
            var m;
            if (!line) { closeList(); out.push(''); return; }
            if ((m = line.match(/^(#{1,6})\s+(.*)$/))) {
                closeList();
                var lvl = Math.min(m[1].length + 1, 4);
                out.push('<' + 'h' + lvl + '>' + inlineMarkup(m[2]) + '</' + 'h' + lvl + '>');
                return;
            }
            if ((m = line.match(/^[-*]\s+(.*)$/))) {
                if (list !== 'ul') { closeList(); out.push('<ul>'); list = 'ul'; }
                out.push('<li>' + inlineMarkup(m[1]) + '</li>');
                return;
            }
            if ((m = line.match(/^\d+[.)]\s+(.*)$/))) {
                if (list !== 'ol') { closeList(); out.push('<ol>'); list = 'ol'; }
                out.push('<li>' + inlineMarkup(m[1]) + '</li>');
                return;
            }
            if (/^\s*(---+|\*\*\*+|___+)\s*$/.test(line)) { closeList(); out.push('<hr>'); return; }
            closeList();
            out.push('<p>' + inlineMarkup(line) + '</p>');
        });
        closeList();
        return out.join('\n');
    }

    var PASTE_HTML_TAGS = ['h1','h2','h3','h4','p','br','ul','ol','li','b','strong','i','em','u','code','pre','blockquote','a','hr'];

    function cleanPasteHtml(html) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        doc.querySelectorAll('script, style, iframe, object, embed, form').forEach(function (el) {
            el.remove();
        });
        function tidy(node) {
            Array.prototype.forEach.call(node.children || [], function (el) {
                tidy(el);
                var tag = (el.tagName || '').toLowerCase();
                if (tag === 'h1') {
                    var h = doc.createElement('h2');
                    h.innerHTML = el.innerHTML;
                    el.parentNode.replaceChild(h, el);
                    el = h;
                }
                if (PASTE_HTML_TAGS.indexOf(tag) === -1) {
                    while (el.firstChild) el.parentNode.insertBefore(el.firstChild, el);
                    el.remove();
                    return;
                }
                Array.prototype.forEach.call(el.attributes, function (a) {
                    if (a.name === 'href' && tag === 'a') return;
                    el.removeAttribute(a.name);
                });
                if (tag === 'a') el.setAttribute('target', '_blank');
            });
        }
        tidy(doc.body);
        return doc.body.innerHTML.trim();
    }

    function smartPaste(e, target, isTextarea) {
        var data = e.clipboardData || window.clipboardData;
        if (!data) return;
        var html = '', text = '';
        try { html = data.getData('text/html') || ''; } catch (err) {}
        try { text = data.getData('text/plain') || ''; } catch (err) {}
        if (!text && !html) return;

        var out = '';
        if (!isTextarea && /<[a-z][\s\S]*>/i.test(html)) {
            var cleaned = cleanPasteHtml(html);
            if (/<(h[1-4]|b|strong|em|i|p|li|pre)/i.test(cleaned)) out = cleaned;
        }
        if (!out && text) out = markdownLite(text);
        if (!out) return;

        e.preventDefault();
        if (isTextarea) {
            var pos = target.selectionStart == null ? target.value.length : target.selectionStart;
            var end = target.selectionEnd == null ? pos : target.selectionEnd;
            target.value = target.value.slice(0, pos) + out + target.value.slice(end);
            target.focus();
            target.setSelectionRange(pos + out.length, pos + out.length);
            return;
        }
        target.focus();
        var sel = window.getSelection();
        if (sel && sel.rangeCount) {
            sel.getRangeAt(0).deleteContents();
            var holder = document.createElement('div');
            holder.innerHTML = out;
            var range = sel.getRangeAt(0);
            Array.prototype.slice.call(holder.childNodes).forEach(function (n) {
                range.insertNode(n);
                range.setStartAfter(n);
            });
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        } else {
            target.innerHTML += out;
        }
    }

    function bindSmartPaste() {
        document.addEventListener('paste', function (e) {
            var t = e.target;
            if (!t || !t.closest) return;
            var area = t.closest('.kfg-editor__area');
            var src = t.closest('.kfg-editor__src');
            if (area) smartPaste(e, area, false);
            else if (src) smartPaste(e, src, true);
        });
    }

    function openLessonEditorModal() { $('kfgl-lesson-modal').classList.add('is-open'); }
    function closeLessonEditorModal() { $('kfgl-lesson-modal').classList.remove('is-open'); }

    async function saveLessonEditor() {
        if (!state.course) return;
        readLessonEditor();
        var titleSo = (editor.so.title || '').trim();
        var titleBa = (editor.ba.title || '').trim();
        if (!titleSo || !titleBa) { toast(T('missing'), true); return; }

        var id = $('kfgl-lesson-id').value;
        var mediaEl = $('kfgl-lesson-media');
        var mediaStr = mediaEl ? (mediaEl.value || '').trim() : '';
        var media = mediaStr ? mediaStr.split(',').map(function (s) { return s.trim(); }).filter(Boolean) : null;
        var body = {
            title_so: titleSo,
            title_ba: titleBa,
            desc_so: editor.so.desc || '',
            desc_ba: editor.ba.desc || '',
            content_so: editor.so.html || '',
            content_ba: editor.ba.html || '',
            code_language: 'python',
            starter_code: $('kfgl-lesson-starter').value || '',
            section_id: $('kfgl-lesson-section').value || '',
            media: media,
        };

        var r = id
            ? await api('/api/ferga/admin/lessons/' + id, { method: 'PUT', body: body })
            : await api('/api/ferga/admin/courses/' + state.course.id + '/lessons', { method: 'POST', body: body });

        if (r.status === 401 || r.status === 403) {
            toast(T('loginFirst'), true);
            closeLessonEditorModal();
            return;
        }
        if (!r.data || !r.data.lesson) { toast(T('err'), true); return; }

        toast(T('saved'));
        closeLessonEditorModal();

        // Reload the course so the sidebar reflects the new/edited lesson.
        var saved = r.data.lesson;
        var r2 = await api(API.courses + '/' + state.course.id);
        if (r2.status === 403) { showPath(); return; }
        state.course = r2.data.course || state.course;
        state.lessons = r2.data.lessons || [];

        var idx = state.lessons.findIndex(function (x) { return x.id === saved.id; });
        if (idx >= 0) {
            openLesson(idx);
        } else {
            renderSidebar();
            renderCourseProgress();
        }
    }

    /* ------------------------------------------------------------------ */
    /* nav wiring                                                          */
    /* ------------------------------------------------------------------ */
    function wireNav() {
        var back = $('kfg-back');
        if (back) back.addEventListener('click', showPath);

        var complete = $('kfg-complete-btn');
        if (complete) complete.addEventListener('click', toggleComplete);

        var prev = $('kfg-prev');
        if (prev) prev.addEventListener('click', function () {
            if (state.lessonIndex > 0) openLesson(state.lessonIndex - 1);
        });

        var next = $('kfg-next');
        if (next) next.addEventListener('click', function () {
            if (state.lessonIndex < state.lessons.length - 1) openLesson(state.lessonIndex + 1);
        });

        /* in-place lesson editor (admins) */
        var save = $('kfgl-lesson-save');
        if (save) save.addEventListener('click', saveLessonEditor);

        document.querySelectorAll('.kfgl-close').forEach(function (b) {
            b.addEventListener('click', closeLessonEditorModal);
        });
        var modal = $('kfgl-lesson-modal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeLessonEditorModal();
            });
        }
        document.querySelectorAll('[data-toolbar] [data-cmd]').forEach(function (b) {
            b.addEventListener('click', function () { lessonEditorCmd(b.getAttribute('data-cmd'), b); });
        });

        /* course editor modal (admins) */
        var cSave = $('kfgl-course-save');
        if (cSave) cSave.addEventListener('click', saveCourseEditor);
        document.querySelectorAll('.kfgl-cclose').forEach(function (b) {
            b.addEventListener('click', closeCourseEditor);
        });
        var cModal = $('kfgl-course-modal');
        if (cModal) {
            cModal.addEventListener('click', function (e) {
                if (e.target === cModal) closeCourseEditor();
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') { closeLessonEditorModal(); closeCourseEditor(); }
        });
    }

    /* ------------------------------------------------------------------ */
    /* boot                                                                */
    /* ------------------------------------------------------------------ */
    ready(function () {
        wireNav();
        bindSmartPaste();

        // Never let the browser navigate away when a file is dropped anywhere
        // on the page.
        document.addEventListener('dragover', function (e) { e.preventDefault(); });
        document.addEventListener('drop', function (e) { e.preventDefault(); });

        applyStaticLang();
        window.addEventListener('kai:langchange', function (e) {
            state.currentLang = (e.detail && e.detail.lang) || lang();
            applyStaticLang();
            renderPath();
            if (state.course) {
                var titleEl = $('kfg-course-title');
                if (titleEl) titleEl.textContent = locTitle(state.course);
                renderSidebar();
                if (state.lessonContent) {
                    var title = $('kfg-lesson-title');
                    if (title) title.textContent = locTitle(state.lessonContent);
                }
            }
        });

        refreshCourses();
        initFirebase();
    });

    function applyStaticLang() {
        document.querySelectorAll('.lang-str').forEach(function (el) {
            el.textContent = el.getAttribute('data-' + lang()) || el.getAttribute('data-so') || '';
        });
    }

    async function refreshCourses() {
        var r = await api(API.courses);
        state.courses = (r.data && r.data.courses) || [];
        state.isAdmin = !!r.data.is_admin;
        renderPath();
    }
})();
