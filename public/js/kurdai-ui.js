/* ==========================================================================
   KURD AI — UI motion layer for "Aurora Glass v3 · Static Tech".
   Purely additive: attaches to classes that already exist in the markup
   (.glass-card, .service-card, .tool-card, .cat-tab, nav links) so no page
   logic, tool, category or data is touched.

   v3 performance contract:
     • No background animation of any kind — the canvas is a static CSS grid.
     • ONE rAF flush per frame — pointer events only *record*; all DOM reads
       (rects) and DOM writes (--kai-* vars) happen inside the flush, so
       read/write never interleave and layout thrash is impossible.
     • will-change is applied by JS only while an element is actively hovered
       / moving and removed when it goes idle (no VRAM leak).
     • FLIP (First/Last/Invert/Play) via the Web Animations API for the nav
       and category pills — compositor-driven, springy, never layout-driven.
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
       0. Single rAF scheduler — batches every DOM write into one frame.
       ====================================================================== */
    var frameHandlers = {};
    var frameQueued = false;

    function flushFrame() {
        frameQueued = false;
        var hs = frameHandlers;
        frameHandlers = {};
        for (var k in hs) { if (hs[k]) hs[k](); }
    }

    function enqueue(key, fn) {
        frameHandlers[key] = fn;
        if (!frameQueued) {
            frameQueued = true;
            requestAnimationFrame(flushFrame);
        }
    }

    /* Dynamic will-change: on while active, '' (removed) when idle.
       transform + opacity only — no filter layering in v3. */
    function setWill(el, on) {
        el.style.willChange = on ? 'transform, opacity' : '';
    }

    /* ======================================================================
       0b. Low-end device detection → html.kai-perf (lighter render path)
       ====================================================================== */
    function detectPerf() {
        var low = false;
        if (navigator.deviceMemory && navigator.deviceMemory < 4) low = true;
        if (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4) low = true;
        if (isTouch && !window.matchMedia('(hover: hover)').matches) low = true;
        if (low) document.documentElement.classList.add('kai-perf');
    }

    /* ======================================================================
       1. Scroll progress bar (will-change only while scrolling)
       ====================================================================== */
    function mountProgress() {
        if (document.getElementById('kai-progress')) return;
        var bar = document.createElement('div');
        bar.id = 'kai-progress';
        bar.setAttribute('aria-hidden', 'true');
        document.body.appendChild(bar);

        var ticking = false;
        var idleTimer = null;
        function update() {
            var h = document.documentElement.scrollHeight - window.innerHeight;
            var p = h > 0 ? window.scrollY / h : 0;
            bar.style.transform = 'scaleX(' + p.toFixed(4) + ')';
            ticking = false;
        }
        window.addEventListener('scroll', function () {
            setWill(bar, true);
            if (!ticking) { ticking = true; requestAnimationFrame(update); }
            clearTimeout(idleTimer);
            idleTimer = setTimeout(function () { setWill(bar, false); }, 400);
        }, { passive: true });
        update();
    }

    /* ======================================================================
       2. Page-exit / entrance veil (attached to <html> so it survives the
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

            /* let the nav wordmark do a tiny exit flourish */
            document.documentElement.classList.add('kai-vt');
            setTimeout(function () {
                document.documentElement.classList.remove('kai-vt');
            }, 700);
        }, true);
    }

    /* ======================================================================
       3. Scroll reveal (will-change managed: on while animating, off after)
       ====================================================================== */
    var revealObserver = null;

    function revealAll() {
        each('.kai-reveal', document, function (el) {
            el.classList.add('kai-in');
            setTimeout(function () { setWill(el, false); }, 900);
        });
    }

    function initReveal() {
        if (reduced || !('IntersectionObserver' in window)) return;

        revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    setWill(el, true);
                    el.classList.add('kai-in');
                    revealObserver.unobserve(el);
                    setTimeout(function () { setWill(el, false); }, 900);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

        window.addEventListener('error', revealAll);
        setTimeout(function () {
            each('.kai-reveal:not(.kai-in)', document, function (el) {
                var top = el.getBoundingClientRect().top;
                if (top < window.innerHeight * 2) {
                    setWill(el, true);
                    el.classList.add('kai-in');
                    setTimeout(function () { setWill(el, false); }, 900);
                }
            });
        }, 6000);
    }

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
            if (el.closest('#kurdai-chat-panel')) return;
            if (el.closest('.fixed')) return;
            el.dataset.kaiReveal = '1';
            el.classList.add('kai-reveal');
            el.style.setProperty('--kai-d', Math.min(i % 8, 7) * 65 + 'ms');
            revealObserver.observe(el);
        });
    }

    /* ======================================================================
       4. Deep-glass layers + cursor spotlight + 3D tilt + specular glare
          All pointer input is recorded in the event and *applied* in the
          single rAF flush — reads and writes never interleave.
       ====================================================================== */
    function injectLayers(card) {
        if (card.querySelector('.kai-glass-layer')) return;

        var a = document.createElement('i');
        a.className = 'kai-glass-layer';
        a.setAttribute('aria-hidden', 'true');

        var g = document.createElement('i');
        g.className = 'kai-grid-layer';
        g.setAttribute('aria-hidden', 'true');

        card.insertBefore(a, card.firstChild);
        card.insertBefore(g, a.nextSibling);

        if (card.matches('.service-card, .tool-card') && !reduced && !isTouch) {
            var gl = document.createElement('i');
            gl.className = 'kai-glare';
            gl.setAttribute('aria-hidden', 'true');
            card.appendChild(gl);
        }
    }

    function resetCard(card) {
        card.classList.add('kai-tilt-reset');
        card.style.setProperty('--kai-ry', '0deg');
        card.style.setProperty('--kai-rx', '0deg');
        card.style.setProperty('--kai-ty', '0px');
        card.style.setProperty('--kai-sc', '1');
        var glare = card.querySelector('.kai-glare');
        if (glare) glare.classList.remove('kai-on');
        setTimeout(function () {
            card.classList.remove('kai-tilt');
            setWill(card, false);
        }, 700);
    }

    function updateCard(card, x, y) {
        /* batched read — executed inside the flush, before any writes */
        var r = card.getBoundingClientRect();
        var mx = x - r.left;
        var my = y - r.top;

        card.style.setProperty('--kai-mx', mx + 'px');
        card.style.setProperty('--kai-my', my + 'px');

        if (isTouch || reduced) return;
        if (!card.matches('.service-card, .tool-card')) return;

        var px = (mx / r.width) - 0.5;
        var py = (my / r.height) - 0.5;

        card.classList.add('kai-tilt');
        card.classList.remove('kai-tilt-reset');
        card.style.setProperty('--kai-ry', (px * 9).toFixed(2) + 'deg');
        card.style.setProperty('--kai-rx', (-py * 9).toFixed(2) + 'deg');
        card.style.setProperty('--kai-ty', '-10px');
        card.style.setProperty('--kai-sc', '1.015');

        var glare = card.querySelector('.kai-glare');
        if (glare) {
            /* light reflects from the side opposite the tilt */
            glare.style.setProperty('--kai-glare-x', ((0.5 - px) * 100 + 50).toFixed(1) + '%');
            glare.style.setProperty('--kai-glare-y', ((0.5 - py) * 100 + 50).toFixed(1) + '%');
        }
    }

    function bindCard(card) {
        if (card.dataset.kaiCard) return;
        card.dataset.kaiCard = '1';

        injectLayers(card);

        var last = { x: 0, y: 0 };

        card.addEventListener('pointerenter', function () {
            setWill(card, true);
            var glare = card.querySelector('.kai-glare');
            if (glare) glare.classList.add('kai-on');
        });
        card.addEventListener('pointermove', function (e) {
            last.x = e.clientX;
            last.y = e.clientY;
            /* record now, apply in the shared flush */
            enqueue(card, function () { updateCard(card, last.x, last.y); });
        }, { passive: true });
        card.addEventListener('pointerleave', resetCard);
    }

    function scanCards(root) {
        each('.glass-card, .service-card, .tool-card', root, bindCard);
    }

    /* ======================================================================
       5. Stagger index for dynamically rendered cards
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
                    kids[i].style.setProperty('--kai-i', Math.min(n++, 10));
                }
            }
        }
    }

    /* ======================================================================
       6. Magnetic pull on primary buttons (rAF-batched)
       ====================================================================== */
    function scanMagnetic(root) {
        if (isTouch || reduced) return;
        each('a[class*="bg-gradient-to-r"], button[class*="bg-gradient-to-r"]', root, function (btn) {
            if (btn.dataset.kaiMag) return;
            btn.dataset.kaiMag = '1';

            var last = { x: 0, y: 0 };
            btn.addEventListener('pointermove', function (e) {
                last.x = e.clientX;
                last.y = e.clientY;
                enqueue(btn, function () {
                    var r = btn.getBoundingClientRect();
                    if (r.width > 420) return;
                    var x = (last.x - r.left - r.width / 2) / r.width;
                    var y = (last.y - r.top - r.height / 2) / r.height;
                    btn.style.transform = 'translate(' + (x * 8).toFixed(1) + 'px,' +
                        (y * 8 - 3).toFixed(1) + 'px) scale(1.02)';
                });
            }, { passive: true });

            btn.addEventListener('pointerenter', function () { setWill(btn, true); });
            btn.addEventListener('pointerleave', function () {
                btn.style.transform = '';
                setTimeout(function () { setWill(btn, false); }, 300);
            });
        });
    }

    /* ======================================================================
       7. FLIP primitives (shared with the ka-nav component via window.KaiUI)
       ====================================================================== */
    function placePill(pill, target) {
        if (!target) return;
        pill.style.width = target.offsetWidth + 'px';
        pill.style.height = target.offsetHeight + 'px';
        pill.style.left = target.offsetLeft + 'px';
        pill.style.top = target.offsetTop + 'px';
    }

    /* animate `pill` onto `target`, inverting from the pill's current rect */
    function morphPill(pill, target, dur) {
        var first = pill.getBoundingClientRect();
        var last = target.getBoundingClientRect();
        if (!first.width || !last.width || !pill.animate) {
            placePill(pill, target);
            return;
        }
        placePill(pill, target); /* write final geometry first (Last) */
        var ix = first.left - last.left;
        var iy = first.top - last.top;
        var sx = first.width / last.width;
        var sy = first.height / last.height;
        setWill(pill, true);
        var anim = pill.animate([
            { transform: 'translate(' + ix + 'px,' + iy + 'px) scale(' + sx + ',' + sy + ')', opacity: .999 },
            { transform: 'translate(0,0) scale(1,1)', opacity: 1 }
        ], { duration: dur || 560, easing: 'cubic-bezier(.34,1.56,.64,1)' });
        anim.onfinish = function () {
            pill.style.transform = '';
            setWill(pill, false);
        };
    }

    /* FLIP across a re-render: the pill element was destroyed and recreated,
       so we supply the previous rect explicitly instead of reading the pill. */
    function animateFromRect(pill, from, target) {
        var last = target.getBoundingClientRect();
        if (!from || !from.width || !last.width || !pill.animate) {
            placePill(pill, target);
            return;
        }
        placePill(pill, target);
        var ix = from.left - last.left;
        var iy = from.top - last.top;
        var sx = from.width / last.width;
        var sy = from.height / last.height;
        setWill(pill, true);
        var anim = pill.animate([
            { transform: 'translate(' + ix + 'px,' + iy + 'px) scale(' + sx + ',' + sy + ')', opacity: .999 },
            { transform: 'translate(0,0) scale(1,1)', opacity: 1 }
        ], { duration: 520, easing: 'cubic-bezier(.34,1.56,.64,1)' });
        anim.onfinish = function () {
            pill.style.transform = '';
            setWill(pill, false);
        };
    }

    /* ======================================================================
       8. Navigation — condensed state + FLIP morphing pill (live `nav.sticky`)
       ====================================================================== */
    function initNav() {
        var nav = document.querySelector('nav.sticky');
        if (!nav) return;

        var onScroll = function () {
            nav.classList.toggle('kai-nav-scrolled', window.scrollY > 12);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

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
        pill.style.transformOrigin = 'top left';
        track.insertBefore(pill, track.firstChild);

        var links = track.querySelectorAll('a');
        var path = window.location.pathname.replace(/\/+$/, '') || '/';

        var active = null;
        for (var i = 0; i < links.length; i++) {
            var lp = links[i].pathname ? links[i].pathname.replace(/\/+$/, '') || '/' : null;
            if (lp === path) { active = links[i]; break; }
        }

        /* the pill owns the highlight now */
        if (active) {
            active.classList.remove('bg-white', 'dark:bg-gray-700', 'shadow-sm');
        }

        function settle() {
            if (!active || !track.offsetWidth) return;
            placePill(pill, active);
            pill.classList.add('kai-pill-on');
        }

        each('a', track, function (a) {
            a.addEventListener('pointerenter', function () {
                if (!track.offsetWidth) return;
                morphPill(pill, a, 420);
            });
        });
        track.addEventListener('pointerleave', function () {
            if (!active || !track.offsetWidth) return;
            morphPill(pill, active);
        });

        settle();
        setTimeout(settle, 250);
        window.addEventListener('resize', settle);
        if ('ResizeObserver' in window) new ResizeObserver(settle).observe(track);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(settle);
    }

    /* ======================================================================
       9. Category tabs — FLIP morphing pill.
          Survives `container.innerHTML` re-renders by capturing the active
          tab's rect on click (before the page re-renders) and FLIPping the
          fresh pill from that rect to the new active tab.
       ====================================================================== */
    var catFromRect = null;

    function initCatTabs(root) {
        if (reduced) return;
        each('.cat-tab', root, function (tab) {
            var w = tab.parentElement;
            if (!w || w.classList.contains('kai-tabs')) return;

            var active = w.querySelector('.cat-tab.active');

            /* capture the category gradient BEFORE the strip rule applies */
            if (active) {
                var bg = window.getComputedStyle(active).backgroundImage;
                if (bg && bg !== 'none') w.dataset.kaiPillBg = bg;
            }

            w.classList.add('kai-tabs');

            var pill = w.querySelector('.cat-pill');
            if (!pill) {
                pill = document.createElement('span');
                pill.className = 'cat-pill';
                pill.setAttribute('aria-hidden', 'true');
                pill.style.transformOrigin = 'top left';
                w.appendChild(pill);
            }
            if (w.dataset.kaiPillBg) pill.style.background = w.dataset.kaiPillBg;

            if (active) {
                placePill(pill, active);
                pill.classList.add('kai-pill-on');
                if (catFromRect && catFromRect.width) {
                    animateFromRect(pill, catFromRect, active);
                    catFromRect = null;
                }
            }

            /* capture pre-render rect on click (capture phase = before the
               page's inline onclick re-renders the tab list) */
            w.addEventListener('click', function (e) {
                var t = e.target.closest('.cat-tab');
                if (!t) return;
                var cur = w.querySelector('.cat-tab.active');
                if (cur && cur !== t) catFromRect = cur.getBoundingClientRect();
            }, true);
        });
    }

    /* ======================================================================
       10. Rescan whenever Firebase (or anything else) renders new DOM
       ====================================================================== */
    function scanAll(root) {
        scanCards(root);
        scanStagger(root);
        scanMagnetic(root);
        scanReveal(root);
        initCatTabs(root);
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
       shared API for the ka-nav component
       ====================================================================== */
    window.KaiUI = {
        reduced: reduced,
        isTouch: isTouch,
        ready: ready,
        each: each,
        enqueue: enqueue,
        setWill: setWill,
        placePill: placePill,
        morphPill: morphPill
    };

    /* ======================================================================
       boot
       ====================================================================== */
    detectPerf();
    mountVeil();

    ready(function () {
        mountProgress();
        initReveal();
        initNav();
        scanAll(document);
        watchDom();
        watchAuthGate();
    });
})();
