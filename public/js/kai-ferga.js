/* ==========================================================================
   KURD AI — فێرگە (Ferga) · Lesson experience  ·  v3
   Loaded ONLY on /ferga. Purely presentational — no page logic touched.
   Targets the READING/LEARNING view only: reading progress bar, lesson-title
   pop, read-along content reveal, staggered code lines, sidebar row cascade,
   lesson meta chips bar, code copy buttons + language badges, quiz letter
   chips. Fails safe: reduced-motion / missing elements / no IntersectionObserver.
   v3 note: static helpers (meta / copy / quiz letters) run even under
   prefers-reduced-motion — they are not motion, only progressive enrichment.
   ========================================================================== */
(function () {
    'use strict';

    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function ready(fn) {
        if (document.readyState !== 'loading') { fn(); } else { document.addEventListener('DOMContentLoaded', fn); }
    }
    function rIC(fn) { /* run once we get a frame — smooth, never blocks paint */
        if (window.requestIdleCallback) { requestIdleCallback(function(){ requestAnimationFrame(fn); }, { timeout: 300 }); }
        else { requestAnimationFrame(fn); }
    }
    function isEl(node) { return node && node.nodeType === 1; }

    /* ----------------------------------------------------------------------
       0. Tiny helpers — never touch page globals unless they exist.
       ---------------------------------------------------------------------- */
    function ui(so, ba) {
        try { if (typeof currentLang !== 'undefined' && currentLang === 'ba') return ba; } catch (e) {}
        return so;
    }
    function locTxt(obj, key) {
        try {
            if (typeof loc === 'function') { return loc(obj, key) || ''; }
        } catch (e) {}
        if (!obj) return '';
        return obj[key] || '';
    }
    function esc(s) {
        return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    /* ----------------------------------------------------------------------
       1. Reading progress bar (injected at top of #lesson-main)
       ====================================================================== */
    function initProgress() {
        var main = document.getElementById('lesson-main');
        if (!main) return;

        var bar = document.createElement('div');
        bar.id = 'kai-progress';
        var fill = document.createElement('div');
        fill.id = 'kai-progress-fill';
        bar.appendChild(fill);
        main.insertBefore(bar, main.firstChild);

        function update() {
            var max = main.scrollHeight - main.clientHeight;
            var pct = max > 0 ? (main.scrollTop / max) * 100 : 0;
            fill.style.width = Math.min(100, Math.max(0, pct)).toFixed(2) + '%';
        }
        main.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        /* re-measure when a lesson is opened / the learning view appears */
        var hv = document.getElementById('home-view');
        if (hv) {
            new MutationObserver(function () {
                if (!hv.classList.contains('hidden')) { rIC(update); }
            }).observe(hv, { attributes: true, attributeFilter: ['class'] });
        }
        rIC(update);
    }

    /* ======================================================================
       2. Lesson title pop every time a new lesson is loaded
       ====================================================================== */
    function initTitlePop() {
        var title = document.getElementById('display-title');
        if (!title || reduce) return;
        var timer = null;
        function pop() {
            title.classList.remove('kai-title-pop');
            void title.offsetWidth; /* restart the animation */
            title.classList.add('kai-title-pop');
            if (timer) clearTimeout(timer);
            timer = setTimeout(function () { title.classList.remove('kai-title-pop'); }, 600);
        }
        new MutationObserver(function () {
            if (title.textContent && String(title.textContent).trim()) pop();
        }).observe(title, { childList: true, characterData: true, subtree: true });
    }

    /* ======================================================================
       3. Read-along reveal for rendered lesson content
       ====================================================================== */
    var contentIO = null;

    function stampContent() {
        var content = document.getElementById('display-content');
        if (!content || reduce) return;
        var blocks = [];
        var kids = content.children;
        for (var i = 0; i < kids.length; i++) {
            var b = kids[i];
            if (b.classList.contains('kai-reveal')) continue;
            if (!b.textContent || !String(b.textContent).trim()) continue;
            b.classList.add('kai-reveal');
            b.style.setProperty('--kai-delay', Math.min(i * 60, 600) + 'ms');
            blocks.push(b);
        }
        if (!blocks.length) return;

        if (contentIO) contentIO.disconnect();
        if (!('IntersectionObserver' in window)) {
            for (var j = 0; j < blocks.length; j++) blocks[j].classList.add('kai-on');
            return;
        }
        contentIO = new IntersectionObserver(function (entries) {
            for (var k = 0; k < entries.length; k++) {
                if (entries[k].isIntersecting) {
                    entries[k].target.classList.add('kai-on');
                    contentIO.unobserve(entries[k].target);
                }
            }
        }, { threshold: 0.1 });
        for (var m = 0; m < blocks.length; m++) contentIO.observe(blocks[m]);
    }

    /* ======================================================================
       4. Code line cascade + blinking caret marker
       ====================================================================== */
    function stampCode(container) {
        if (!container || reduce) return;
        if (!container.classList.contains('kai-anim')) container.classList.add('kai-anim');
        var kids = container.children;
        for (var i = 0; i < kids.length; i++) {
            kids[i].style.setProperty('--kai-delay', Math.min(i * 40, 700) + 'ms');
        }
        /* mark the last child that actually holds a code line */
        for (var j = container.children.length - 1; j >= 0; j--) {
            var c = container.children[j];
            c.classList.remove('kai-last-line');
            if (c.querySelector('code')) { c.classList.add('kai-last-line'); break; }
        }
        /* kick the cascade into view (content may be below the fold) */
        requestAnimationFrame(function () {
            for (var k = 0; k < container.children.length; k++) {
                container.children[k].classList.add('kai-on');
            }
        });
    }

    /* ======================================================================
       5. Sidebar row cascade on every render
       ====================================================================== */
    function stampSidebar() {
        var sidebar = document.getElementById('sidebar-content');
        if (!sidebar || reduce) return;
        var rows = sidebar.querySelectorAll(':scope > div > .group, :scope > div');
        var delay = 0;
        for (var i = 0; i < rows.length; i++) {
            var el = rows[i];
            if (el.classList.contains('group') && !el.classList.contains('kai-side-row')) {
                el.classList.add('kai-side-row');
                el.style.setProperty('--kai-delay', Math.min(delay, 500) + 'ms');
                delay += 45;
            }
        }
    }

    /* ======================================================================
       6. Observers — re-stamp every time the page re-renders a section
       ====================================================================== */
    function watch(sel, stamp) {
        var el = document.getElementById(sel);
        if (!el) return;
        stamp(el);
        new MutationObserver(function () { stamp(el); })
            .observe(el, { childList: true });
    }

    /* ======================================================================
       7. Lesson meta chips bar (injected above the lesson title)
       ====================================================================== */
    function metaDot() {
        return '<span class="kai-dot"></span>';
    }
    function metaIcon(paths) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + paths + '</svg>';
    }
    var META_ICONS = {
        level: metaIcon('<path d="M4 19.5A2.5 2.5 0 016.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"></path>'),
        xp: metaIcon('<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>'),
        lang: metaIcon('<circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"></path>')
    };

    function buildMetaChips() {
        var wrap = document.querySelector('.kai-lesson-meta');
        var hide = function () { if (wrap) wrap.style.display = 'none'; };
        try {
            if (typeof currentLessonArray === 'undefined' || !currentLessonArray.length) { hide(); return; }
            var lesson = currentLessonArray[currentLessonIndex];
            if (!lesson) { hide(); return; }
            var total = currentLessonArray.length;
            var num = currentLessonIndex + 1;
            var chips = [];
            chips.push('<span class="kai-meta-chip">' + metaDot() + esc(ui('وانە ' + num + ' لە ' + total, 'وانە ' + num + ' ژ ' + total)) + '</span>');
            var level = locTxt(lesson, 'level');
            if (level) chips.push('<span class="kai-meta-chip kai-meta-chip--level">' + META_ICONS.level + esc(level) + '</span>');
            if (lesson.xp_cost) chips.push('<span class="kai-meta-chip kai-meta-chip--xp">' + META_ICONS.xp + '+' + Number(lesson.xp_cost) + ' XP</span>');
            try {
                if (typeof currentActiveLanguage !== 'undefined' && currentActiveLanguage) {
                    var langName = locTxt(currentActiveLanguage, 'name');
                    if (langName) chips.push('<span class="kai-meta-chip kai-meta-chip--lang">' + META_ICONS.lang + esc(langName) + '</span>');
                }
            } catch (e) {}
            if (!wrap) {
                wrap = document.createElement('div');
                wrap.className = 'kai-lesson-meta';
                var title = document.getElementById('display-title');
                if (!title) { return; }
                title.parentNode.insertBefore(wrap, title);
            }
            wrap.style.display = '';
            wrap.innerHTML = chips.join('');
        } catch (e) { hide(); }
    }

    function initLessonMeta() {
        rIC(buildMetaChips);
        var title = document.getElementById('display-title');
        if (!title) return;
        new MutationObserver(function () {
            if (title.textContent && String(title.textContent).trim()) { rIC(buildMetaChips); }
        }).observe(title, { childList: true, characterData: true, subtree: true });
    }

    /* ======================================================================
        8. Code language badges
       ====================================================================== */
    function initCodeBoxes() {
        var boxIds = ['display-code-box', 'display-css-code-box'];
        for (var i = 0; i < boxIds.length; i++) {
            var box = document.getElementById(boxIds[i]);
            if (!box) continue;
            var bar = box.querySelector('.rounded-2xl > div:first-child');
            if (!bar) continue;

            var name = '';
            if (boxIds[i] === 'display-code-box') {
                var fn = document.getElementById('code-filename-label');
                name = fn ? (fn.textContent || '') : '';
            } else {
                name = 'style.css';
            }
            var ext = (String(name).match(/\.([a-z0-9]+)$/i) || [])[1] || '';
            if (ext) {
                var badge = document.createElement('span');
                badge.className = 'kai-lang-badge';
                badge.textContent = ext.toUpperCase();
                var cluster = bar.querySelector('.flex.items-center.gap-2');
                if (cluster) { cluster.appendChild(badge); }
            }
        }
    }

    /* ======================================================================
       9. Quiz option letter chips (A/B/C/D…)
       ====================================================================== */
    function initQuizLetters() {
        var opts = document.getElementById('quiz-options');
        if (!opts) return;
        var letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        function stamp() {
            var rows = opts.querySelectorAll('.quiz-option');
            for (var i = 0; i < rows.length; i++) {
                var circle = rows[i].querySelector('.indicator-circle');
                if (circle && !circle.textContent.trim() && !circle.querySelector('svg')) {
                    circle.textContent = letters[i] || String(i + 1);
                }
            }
        }
        stamp();
        new MutationObserver(stamp).observe(opts, { childList: true });
    }

    /* ======================================================================
       boot
       ====================================================================== */
    ready(function () {
        /* static enrichment first — safe under every motion preference */
        initLessonMeta();
        initCodeBoxes();
        initQuizLetters();

        if (reduce) return; /* CSS already forces everything visible */
        initProgress();
        initTitlePop();

        watch('display-content', function () { rIC(stampContent); });
        watch('display-code', stampCode);
        watch('display-css-code', stampCode);
        watch('sidebar-content', function () { rIC(stampSidebar); });
    });
})();
