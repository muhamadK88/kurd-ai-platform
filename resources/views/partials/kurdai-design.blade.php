{{-- KURD AI — "Futuristic Glass v4" redesign layer.
     Loaded last in <head> so it sits on top of Tailwind + each page's
     inline styles. Purely presentational: no tools, categories, data or
     page logic depend on it.
     v10 = "Nebula" layer on top of v8:
       • interactive 3D tilt now on every glass card
       • hero tech-orbits + data-grid + scanning beam
       • neon micro-interactions (CTA shine, nav underline, chip pulse)
       • aurora ring on every glass card hover
        • v10 dropped the CDN three.js scripts — the cosmos
          background and hero sphere now render on Canvas 2D (kai-cosmos.js,
          kai-hero.js). ~1.1MB of JS removed from every page load.
      kurdai-nav.{css,js} wire the ka-* navigation component
      (resources/views/partials/nav.blade.php) — safe on pages that don't
      use it yet. --}}
<link rel="stylesheet" href="/css/kurdai-design.css?v=15">
<link rel="stylesheet" href="/css/kurdai-nav.css?v=6">
<link rel="stylesheet" href="/css/kai-cosmos.css?v=7">
<script src="/js/kurdai-ui.js?v=11" data-kai-shared defer></script>
<script src="/js/kurdai-nav.js?v=4" data-kai-shared defer></script>
<script src="/js/kai-cosmos.js?v=7" data-kai-shared defer></script>
<script src="/js/kai-firebase.js?v=1" data-kai-shared defer></script>
<script src="/js/kai-router.js?v=19" data-kai-shared defer></script>
<script data-kai-shared>
    /* Page lifecycle helper: run `fn` as soon as the DOM is ready and safe
       to touch. On a hard load this defers to DOMContentLoaded; on an SPA
       swap the DOM is already in place, so the callback runs immediately.
       Page scripts (which the router re-executes on every swap) can wrap
       their boot code in KaiPageReady(fn) and be correct in both worlds. */
    window.KaiPageReady = function (fn) {
        if (typeof fn !== 'function') return;
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
        } else {
            fn();
        }
    };
</script>
<script data-kai-shared>
(function () {
    'use strict';
    /* Anonymous usage beacon (KaiTrack): one fire-and-forget event per page
       load / login. Feeds the admin-only analytics dashboard on /about. */
    var identity = { uid: '', email: '' };
    function send(payload) {
        try {
            if (navigator.sendBeacon) {
                navigator.sendBeacon('/api/analytics/visit', new Blob([JSON.stringify(payload)], { type: 'application/json' }));
            } else {
                fetch('/api/analytics/visit', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload),
                    keepalive: true
                }).catch(function () {});
            }
        } catch (e) {}
    }
    function userKey() {
        var k = localStorage.getItem('kurdai_user_key');
        if (!k) {
            k = 'u' + Math.random().toString(36).slice(2, 10) + Date.now().toString(36);
            try { localStorage.setItem('kurdai_user_key', k); } catch (e) {}
        }
        return k;
    }
    window.KaiTrack = {
        setIdentity: function (uid, email) {
            identity.uid = uid || '';
            identity.email = String(email || '').toLowerCase();
        },
        visit: function (section) {
            try {
                var now = Date.now();
                var last = sessionStorage.getItem('ka_v_' + section);
                if (last && now - Number(last) < 15000) return;
                sessionStorage.setItem('ka_v_' + section, String(now));
                send({ type: 'visit', section: section, user_key: userKey(), uid: identity.uid, email: identity.email });
            } catch (e) {}
        },
        login: function (email) {
            try {
                window.KaiTrack.setIdentity('', email);
                send({ type: 'login', section: 'auth', user_key: userKey(), uid: '', email: String(email || '').toLowerCase() });
            } catch (e) {}
        }
    };
    /* Once Firebase identity resolves, later beacons carry the email. */
    document.addEventListener('kurdai:identity', function (e) {
        window.KaiTrack.setIdentity('', e.detail && e.detail.email);
    });
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
       still loading. Capture-level delegation handles the language and theme
       controls immediately; kurdai-nav.js owns the burger state so outside
       click and Escape handling stay in sync with its local state. */
    document.addEventListener('click', function (e) {
        var target = e.target && e.target.closest ? e.target.closest('#lang-toggle, #theme-toggle') : null;
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

    }, true);
})();
</script>
