/* ==========================================================================
   KURD AI — UI motion layer for the "Aurora Glass" redesign.
   Purely additive: it attaches to classes that already exist in the markup
   (.glass-card, .service-card, .tool-card, .cat-tab, nav links) so no page
   logic, tool, category or data is touched.
   ========================================================================== */
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isTouch = window.matchMedia('(hover: none)').matches;

    /* ---------- helpers ---------- */
    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
        } else {
            fn();
        }
    }

    function each(sel, root, fn) {
        var list = (root || document).querySelectorAll(sel);
        for (var i = 0; i < list.length; i++) fn(list[i], i);
    }

    /* ======================================================================
       1. Aurora backdrop
       ====================================================================== */
    function mountAurora() {
        if (document.getElementById('kai-aurora')) return;

        var wrap = document.createElement('div');
        wrap.id = 'kai-aurora';
        wrap.setAttribute('aria-hidden', 'true');

        var html = '';
        for (var i = 0; i < 4; i++) html += '<div class="kai-blob"></div>';
        html += '<div class="kai-grid"></div>';
        if (!reduced) html += '<div class="kai-grain"></div>';
        wrap.innerHTML = html;

        document.body.insertBefore(wrap, document.body.firstChild);
    }

    /* ======================================================================
       2. Scroll progress bar
       ====================================================================== */
    function mountProgress() {
        if (document.getElementById('kai-progress')) return;
        var bar = document.createElement('div');
        bar.id = 'kai-progress';
        bar.setAttribute('aria-hidden', 'true');
        document.body.appendChild(bar);

        var ticking = false;
        function update() {
            var h = document.documentElement.scrollHeight - window.innerHeight;
            var p = h > 0 ? window.scrollY / h : 0;
            bar.style.transform = 'scaleX(' + p.toFixed(4) + ')';
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
        }, { passive: true });
        update();
    }

    /* ======================================================================
       3. Page-exit / entrance veil  (attached to <html> so it survives the
          `body { display:none }` auth gate used on most pages)
       ====================================================================== */
    function mountVeil() {
        if (reduced) return;
        var veil = document.createElement('div');
        veil.id = 'kai-veil';
        veil.setAttribute('aria-hidden', 'true');
        veil.style.cssText =
            'position:fixed;inset:0;z-index:10000;pointer-events:none;opacity:1;' +
            'background:radial-gradient(ellipse at 50% 40%,rgba(37,99,235,.16),transparent 65%),' +
            'var(--kai-canvas,#f5f7fb);' +
            'transition:opacity .55s cubic-bezier(.22,1,.36,1);';
        document.documentElement.appendChild(veil);

        function lift() { veil.style.opacity = '0'; }

        // whichever happens first — and a hard failsafe so it can never stick
        ready(function () { setTimeout(lift, 60); });
        window.addEventListener('load', lift);
        setTimeout(lift, 1400);
        setTimeout(function () { if (veil.parentNode) veil.parentNode.removeChild(veil); }, 2600);

        // fade out on internal navigation for a seamless morph between pages
        document.addEventListener('click', function (e) {
            var a = e.target.closest ? e.target.closest('a') : null;
            if (!a) return;
            if (a.target === '_blank' || a.hasAttribute('download')) return;
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.button !== 0) return;

            var href = a.getAttribute('href');
            if (!href || href.charAt(0) === '#' || /^(mailto:|tel:|javascript:)/i.test(href)) return;
            if (a.origin && a.origin !== window.location.origin) return;
            if (a.pathname === window.location.pathname && a.hash) return;

            var out = document.createElement('div');
            out.style.cssText = veil.style.cssText;
            out.style.opacity = '0';
            document.documentElement.appendChild(out);
            requestAnimationFrame(function () { out.style.opacity = '1'; });
        }, true);
    }

    /* ======================================================================
       4. Scroll reveal
       ====================================================================== */
    var revealObserver = null;

    /* Nothing may ever stay stuck at opacity:0 — if anything goes wrong,
       show the content and drop the effect. */
    function revealAll() {
        each('.kai-reveal', document, function (el) { el.classList.add('kai-in'); });
    }

    function initReveal() {
        if (reduced || !('IntersectionObserver' in window)) return;

        revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('kai-in');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

        window.addEventListener('error', revealAll);
        // failsafe: anything still hidden near the viewport after 6s gets shown
        setTimeout(function () {
            each('.kai-reveal:not(.kai-in)', document, function (el) {
                var top = el.getBoundingClientRect().top;
                if (top < window.innerHeight * 2) el.classList.add('kai-in');
            });
        }, 6000);
    }

    // elements worth revealing, without having to edit any markup
    var REVEAL_SELECTOR = [
        'section > .container > .text-center',
        'section .grid > a',
        'section .grid > div',
        '.glass-card',
        'header .inline-flex',
        'header h1', 'header h2', 'header p',
        'footer .grid > div'
    ].join(',');

    function scanReveal(root) {
        if (!revealObserver) return;
        each(REVEAL_SELECTOR, root, function (el, i) {
            if (el.dataset.kaiReveal) return;
            if (el.closest('#kai-aurora') || el.closest('#kurdai-chat-panel')) return;
            // modals and overlays open instantly — they must never fade in
            if (el.closest('.fixed')) return;
            el.dataset.kaiReveal = '1';
            el.classList.add('kai-reveal');
            el.style.setProperty('--kai-d', Math.min(i % 8, 7) * 65 + 'ms');
            revealObserver.observe(el);
        });
    }

    /* ======================================================================
       5. Cursor spotlight + 3D tilt on cards
       ====================================================================== */
    function bindCard(card) {
        if (card.dataset.kaiCard) return;
        card.dataset.kaiCard = '1';

        card.addEventListener('pointermove', function (e) {
            var r = card.getBoundingClientRect();
            var x = e.clientX - r.left;
            var y = e.clientY - r.top;

            card.style.setProperty('--kai-mx', x + 'px');
            card.style.setProperty('--kai-my', y + 'px');

            if (isTouch || reduced) return;
            if (!card.matches('.service-card, .tool-card')) return;

            var px = (x / r.width) - 0.5;
            var py = (y / r.height) - 0.5;
            card.classList.add('kai-tilt');
            card.classList.remove('kai-tilt-reset');
            card.style.setProperty('--kai-ry', (px * 9).toFixed(2) + 'deg');
            card.style.setProperty('--kai-rx', (-py * 9).toFixed(2) + 'deg');
            card.style.setProperty('--kai-ty', '-10px');
            card.style.setProperty('--kai-sc', '1.015');
        }, { passive: true });

        card.addEventListener('pointerleave', function () {
            card.classList.add('kai-tilt-reset');
            card.style.setProperty('--kai-ry', '0deg');
            card.style.setProperty('--kai-rx', '0deg');
            card.style.setProperty('--kai-ty', '0px');
            card.style.setProperty('--kai-sc', '1');
            setTimeout(function () { card.classList.remove('kai-tilt'); }, 700);
        });
    }

    function scanCards(root) {
        each('.glass-card, .service-card, .tool-card', root, bindCard);
    }

    /* ======================================================================
       6. Stagger index for dynamically rendered cards
       ====================================================================== */
    function scanStagger(root) {
        var containers = (root || document).querySelectorAll(
            '#tools-container, #courses-container, #news-container, #uni-container, #guide-container'
        );
        for (var c = 0; c < containers.length; c++) {
            var kids = containers[c].children;
            var n = 0;
            for (var i = 0; i < kids.length; i++) {
                if (kids[i].classList.contains('tool-card') || kids[i].classList.contains('cat-header')) {
                    // cap the stagger: with a long tool list an uncapped index
                    // would leave the last cards invisible for seconds
                    kids[i].style.setProperty('--kai-i', Math.min(n++, 10));
                }
            }
        }
    }

    /* ======================================================================
       7. Magnetic pull on primary buttons
       ====================================================================== */
    function scanMagnetic(root) {
        if (isTouch || reduced) return;
        each('a[class*="bg-gradient-to-r"], button[class*="bg-gradient-to-r"]', root, function (btn) {
            if (btn.dataset.kaiMag) return;
            btn.dataset.kaiMag = '1';

            btn.addEventListener('pointermove', function (e) {
                var r = btn.getBoundingClientRect();
                if (r.width > 420) return; // leave full-width form buttons alone
                var x = (e.clientX - r.left - r.width / 2) / r.width;
                var y = (e.clientY - r.top - r.height / 2) / r.height;
                btn.style.transform = 'translate(' + (x * 8).toFixed(1) + 'px,' +
                    (y * 8 - 3).toFixed(1) + 'px) scale(1.02)';
            }, { passive: true });

            btn.addEventListener('pointerleave', function () { btn.style.transform = ''; });
        });
    }

    /* ======================================================================
       8. Navigation — condensed state + morphing pill indicator
       ====================================================================== */
    function initNav() {
        var nav = document.querySelector('nav.sticky');
        if (!nav) return;

        var onScroll = function () {
            nav.classList.toggle('kai-nav-scrolled', window.scrollY > 12);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        // find the link group: the container holding the main nav anchors
        var track = null;
        each('nav div', nav, function (div) {
            if (track) return;
            var direct = 0;
            for (var i = 0; i < div.children.length; i++) {
                if (div.children[i].tagName === 'A') direct++;
            }
            if (direct >= 4) track = div;
        });
        if (!track) return;

        track.classList.add('kai-navtrack');

        var pill = document.createElement('span');
        pill.className = 'kai-pill';
        pill.setAttribute('aria-hidden', 'true');
        pill.style.left = '0px';
        pill.style.right = 'auto';
        track.insertBefore(pill, track.firstChild);

        var links = track.querySelectorAll('a');
        var path = window.location.pathname.replace(/\/+$/, '') || '/';

        var active = null;
        for (var i = 0; i < links.length; i++) {
            var lp = links[i].pathname ? links[i].pathname.replace(/\/+$/, '') || '/' : null;
            if (lp === path) { active = links[i]; break; }
        }

        // the current page's link already carries a solid background in the
        // markup — hand that job over to the morphing pill instead
        if (active) {
            active.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm');
        }

        function moveTo(el, show) {
            if (!el || !track.offsetWidth) return;
            pill.style.width = el.offsetWidth + 'px';
            pill.style.transform = 'translateX(' + el.offsetLeft + 'px)';
            pill.classList.toggle('kai-pill-on', show !== false);
        }

        function settle() { moveTo(active, !!active); }

        each('a', track, function (a) {
            a.addEventListener('pointerenter', function () { moveTo(a, true); });
        });
        track.addEventListener('pointerleave', settle);

        // measure once the auth gate reveals the body, and on resize
        settle();
        setTimeout(settle, 250);
        window.addEventListener('resize', settle);
        if ('ResizeObserver' in window) new ResizeObserver(settle).observe(track);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(settle);
    }

    /* ======================================================================
       9. Rescan whenever Firebase (or anything else) renders new DOM
       ====================================================================== */
    function scanAll(root) {
        scanCards(root);
        scanStagger(root);
        scanMagnetic(root);
        scanReveal(root);
    }

    function watchDom() {
        if (!('MutationObserver' in window)) return;
        var pending = false;

        new MutationObserver(function () {
            if (pending) return;
            pending = true;
            requestAnimationFrame(function () {
                pending = false;
                scanAll(document);
            });
        }).observe(document.body, { childList: true, subtree: true });
    }

    /* Most pages hide <body> until Firebase resolves auth; measurements taken
       while hidden are all zero, so re-run everything once it appears. */
    function watchAuthGate() {
        if (document.body.style.display !== 'none') return;

        var obs = new MutationObserver(function () {
            if (document.body.style.display !== 'none') {
                obs.disconnect();
                requestAnimationFrame(function () {
                    scanAll(document);
                    initNav();
                });
            }
        });
        obs.observe(document.body, { attributes: true, attributeFilter: ['style'] });
    }

    /* ======================================================================
       boot
       ====================================================================== */
    mountVeil();

    ready(function () {
        mountAurora();
        mountProgress();
        initReveal();
        initNav();
        scanAll(document);
        watchDom();
        watchAuthGate();
    });
})();
