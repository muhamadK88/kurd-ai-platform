{{-- KURD AI — "Futuristic Glass v4" redesign layer.
     Loaded last in <head> so it sits on top of Tailwind + each page's
     inline styles. Purely presentational: no tools, categories, data or
     page logic depend on it.
     v10 = "Nebula" layer on top of v8:
       • interactive 3D tilt now on every glass card
       • hero tech-orbits + data-grid + scanning beam
       • neon micro-interactions (CTA shine, nav underline, chip pulse)
       • aurora ring on every glass card hover
       • v10 dropped the CDN three.js + lottie-web scripts — the cosmos
         background and hero sphere now render on Canvas 2D (kai-cosmos.js,
         kai-hero.js), and the chat launcher loads lottie lazily. ~1.1MB
         of JS removed from every page load.
      kurdai-nav.{css,js} wire the ka-* navigation component
      (resources/views/partials/nav.blade.php) — safe on pages that don't
      use it yet. --}}
<link rel="stylesheet" href="/css/kurdai-design.css?v=15">
<link rel="stylesheet" href="/css/kurdai-nav.css?v=5">
<link rel="stylesheet" href="/css/kai-cosmos.css?v=7">
<script src="/js/kurdai-ui.js?v=11" data-kai-shared defer></script>
<script src="/js/kurdai-nav.js?v=4" data-kai-shared defer></script>
<script src="/js/kai-cosmos.js?v=7" data-kai-shared defer></script>
<script src="/js/kai-router.js?v=17" data-kai-shared defer></script>
<script data-kai-shared>
(function () {
    'use strict';
    // Instant navigation: warm the next page into the router's in-memory
    // cache while the pointer is still moving, so a nav click after a hover
    // swaps from memory in the same frame — zero network wait.
    var done = {};
    var hoverTimer = null;
    function warm(url) {
        if (!url || done[url]) return;
        var p = new URL(url, location.href);
        if (p.origin !== location.origin) return;
        if (p.protocol !== 'http:' && p.protocol !== 'https:') return;
        done[url] = 1;
        try {
            if (window.KaiRouter && window.KaiRouter.warm) {
                window.KaiRouter.warm(p.href);
            } else if (window.fetch) {
                fetch(p.href, { credentials: 'same-origin', priority: 'low' }).catch(function () {});
            }
        } catch (e) {}
    }
    function pick(e) {
        var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (!a) return;
        if (a.target && a.target !== '_self') return;
        if (a.hasAttribute('download')) return;
        warm(a.getAttribute('href'));
    }
    function pickSoon(e) {
        if (hoverTimer) clearTimeout(hoverTimer);
        var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (!a) return;
        if (a.target && a.target !== '_self') return;
        if (a.hasAttribute('download')) return;
        var href = a.getAttribute('href');
        hoverTimer = setTimeout(function () { warm(href); }, 60);
    }
    document.addEventListener('pointerover', pickSoon, { passive: true });
    document.addEventListener('pointerdown', pick, { passive: true });

    /* Critical controls must work while page modules (notably Firebase) are
       still loading. Capture-level delegation handles the shared navbar
       immediately and prevents the later page-specific listeners from
       double-toggling the same control once they eventually attach. */
    document.addEventListener('click', function (e) {
        var target = e.target && e.target.closest ? e.target.closest('#lang-toggle, #theme-toggle, #ka-burger') : null;
        if (!target) return;

        if (target.id === 'lang-toggle') {
            e.preventDefault();
            e.stopImmediatePropagation();
            var lang = localStorage.getItem('site-lang') || 'so';
            lang = lang === 'so' ? 'ba' : 'so';
            localStorage.setItem('site-lang', lang);
            var langText = document.getElementById('lang-text');
            if (langText) langText.textContent = lang === 'so' ? 'Badini' : 'سۆرانی';
            document.querySelectorAll('.lang-str').forEach(function (el) {
                el.textContent = el.getAttribute('data-' + lang) || el.getAttribute('data-so') || '';
            });
            try {
                window.dispatchEvent(new CustomEvent('kai:langchange', { detail: { lang: lang } }));
            } catch (ignore) {}
            return;
        }

        if (target.id === 'theme-toggle') {
            e.preventDefault();
            e.stopImmediatePropagation();
            var dark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', dark ? 'dark' : 'light');
            return;
        }

        var nav = target.closest('.ka-nav');
        var drawer = nav && nav.querySelector('#ka-drawer');
        if (!nav || !drawer) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        var open = !nav.classList.contains('is-open');
        nav.classList.toggle('is-open', open);
        target.setAttribute('aria-expanded', open ? 'true' : 'false');
        drawer.style.maxHeight = open ? drawer.scrollHeight + 'px' : '0px';
    }, true);
})();
</script>
