/* ==========================================================================
   KURD AI — فێرگە (Ferga) · Lesson experience  ·  v2
   Loaded ONLY on /ferga. Purely presentational — no page logic touched.
   Targets the READING/LEARNING view only: reading progress bar, lesson-title
   pop, read-along content reveal, staggered code lines, sidebar row cascade.
   Fails safe: reduced-motion / missing elements / no IntersectionObserver.
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

    /* ======================================================================
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
       boot
       ====================================================================== */
    ready(function () {
        if (reduce) return; /* CSS already forces everything visible */
        initProgress();
        initTitlePop();

        watch('display-content', function () { rIC(stampContent); });
        watch('display-code', stampCode);
        watch('display-css-code', stampCode);
        watch('sidebar-content', function () { rIC(stampSidebar); });
    });
})();
