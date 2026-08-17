/* ==========================================================================
   KURD AI — ka-nav component wiring
   Drives the FLIP pill, condensed-scroll state and mobile drawer of
   resources/views/partials/nav.blade.php.

   Deliberately does NOT bind lang-toggle / theme-toggle / logout-btn:
   those IDs are preserved by the partial so each page's existing toggle JS
   keeps working untouched (double-binding would double-fire).

   Depends on the shared KaiUI primitives exposed by kurdai-ui.js
   (placePill / morphPill / each / ready). Must load after it.
   ========================================================================== */
(function () {
    'use strict';

    var Kai = window.KaiUI;
    if (!Kai) return; /* guard: ui layer not present */

    function initKaNav() {
        var nav = document.querySelector('.ka-nav');
        if (!nav || nav.dataset.kaWired) return;
        nav.dataset.kaWired = '1';

        /* ---------- condensed state on scroll ---------- */
        var onScroll = function () {
            nav.classList.toggle('kai-nav-scrolled', window.scrollY > 12);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();

        /* ---------- FLIP morphing pill on the desktop link track ---------- */
        var track = nav.querySelector('.ka-navlinks');
        var pill = nav.querySelector('.ka-navlinks__pill');
        if (track && pill) {
            pill.style.transformOrigin = 'top left';
            var active = track.querySelector('.ka-navlink.is-active');

            function settle() {
                if (!active || !track.offsetWidth) return;
                Kai.placePill(pill, active);
                pill.classList.add('kai-pill-on');
            }

            Kai.each('.ka-navlink', track, function (a) {
                a.addEventListener('pointerenter', function () {
                    if (!track.offsetWidth) return;
                    Kai.morphPill(pill, a, 420);
                });
            });
            track.addEventListener('pointerleave', function () {
                if (!active || !track.offsetWidth) return;
                Kai.morphPill(pill, active);
            });

            settle();
            setTimeout(settle, 250);
            window.addEventListener('resize', settle);
            if ('ResizeObserver' in window) new ResizeObserver(settle).observe(track);
            if (document.fonts && document.fonts.ready) document.fonts.ready.then(settle);
        }

        /* ---------- burger + mobile drawer ---------- */
        var burger = nav.querySelector('#ka-burger');
        var drawer = nav.querySelector('#ka-drawer');
        if (burger && drawer) {
            var open = false;

            function setOpen(v) {
                open = v;
                nav.classList.toggle('is-open', v);
                burger.setAttribute('aria-expanded', v ? 'true' : 'false');
                drawer.setAttribute('aria-hidden', v ? 'false' : 'true');
                drawer.classList.toggle('ka-open', v);
                drawer.style.maxHeight = v ? drawer.scrollHeight + 'px' : '0px';
            }

            setOpen(false);

            burger.addEventListener('click', function (e) {
                e.stopPropagation();
                setOpen(!open);
            });
            document.addEventListener('click', function (e) {
                if (open && !nav.contains(e.target)) setOpen(false);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && open) setOpen(false);
            });
            window.addEventListener('resize', function () {
                if (open) setOpen(false);
            });
        }
    }

    Kai.ready(initKaNav);

    /* re-wire if the nav is injected later (e.g. after the auth gate) */
    if ('MutationObserver' in window) {
        var obs = new MutationObserver(function () { initKaNav(); });
        obs.observe(document.body, { childList: true, subtree: true });
    }
})();
