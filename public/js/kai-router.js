/* ==========================================================================
   KURD AI — kai-router (SPA navigation)
   Turbo-style instant page swapping: intercepts same-origin link clicks,
   fetches the next page (often already warmed by the prefetch layer),
   swaps <body> content + per-page stylesheets, and re-runs only the
   scripts that belong to the new page. No full reload, no loading screen.

   Persists the shared background layer (#kai-cosmos / #kai-aurora-sweep /
   #kai-cursor) across swaps so its rAF loops never restart or leak.

   The shared layers (kurdai-ui.js, kurdai-nav.js, kai-cosmos.js) stay in
   the <head> and bind ONCE; kurdai-ui.js + kurdai-nav.js already re-scan
   the DOM via MutationObserver when new content appears.
   ========================================================================== */
(function () {
    'use strict';
    if (window.__kaiRouterActive) return;
    window.__kaiRouterActive = true;

    var PERSIST = '#kai-cosmos, #kai-aurora-sweep, #kai-cursor, .ka-nav, #kurdai-widget-root';
    var cache = {};      /* pathname+search -> { body, scripts, css, title } */
    var fetchers = {};   /* pathname+search -> shared in-flight fetch promise */
    var navToken = null; /* identity of the latest navigation click */

    /* ---------- page transition ----------
       Native View Transitions API: the browser captures a snapshot of the
       old page and crossfades it into the new one. Nothing else flashes —
       just a soft, branded morph (see ::view-transition CSS). Falls back to
       an instant swap on browsers without support, and NEVER starts a
       second transition while one is still running (the second click just
       swaps instantly instead of swallowing the click). */
    var vtBusy = false;
    function withTransition(fn) {
        if (document.startViewTransition && !vtBusy) {
            vtBusy = true;
            try {
                var t = document.startViewTransition(function () { fn(); });
                var finish = function () { vtBusy = false; };
                if (t && t.finished && t.finished.then) t.finished.then(finish, finish);
                else setTimeout(finish, 400);
                return;
            } catch (e) {
                vtBusy = false;
            }
        }
        fn();
    }

    function keyOf(p) { return p.pathname + (p.search || ''); }

    function interceptable(a) {
        if (!a) return false;
        var href = a.getAttribute('href');
        if (!href || href.charAt(0) === '#') return false;
        if (a.target && a.target !== '_self' && a.target !== '') return false;
        if (a.hasAttribute('download')) return false;
        var p = new URL(a.href, location.href);
        if (p.origin !== location.origin) return false;
        if (p.protocol !== 'http:' && p.protocol !== 'https:') return false;
        return true;
    }

    function extractScripts(doc) {
        var out = [], nodes = doc.querySelectorAll('script'), i, s;
        for (i = 0; i < nodes.length; i++) {
            s = nodes[i];
            out.push({
                src: s.getAttribute('src'),
                text: s.textContent || '',
                type: s.getAttribute('type') || '',
                shared: s.hasAttribute('data-kai-shared')
            });
        }
        return out;
    }

    function currentCss() {
        var css = [], seen = {}, href;
        document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
            href = l.getAttribute('href');
            if (href && !seen[href]) { seen[href] = 1; css.push(href); }
        });
        return css;
    }

    function extractHead(doc) {
        var css = [], seen = {}, i, href;
        var l = doc.querySelectorAll('link[rel="stylesheet"]');
        for (i = 0; i < l.length; i++) {
            href = l[i].getAttribute('href');
            if (href && !seen[href]) { seen[href] = 1; css.push(href); }
        }
        return { css: css, title: doc.title || '' };
    }

    function syncHead(page) {
        var i, href, want = {}, add = [], have = {};
        for (i = 0; i < page.css.length; i++) {
            href = page.css[i];
            if (!want[href]) { want[href] = 1; add.push(href); }
        }
        document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
            href = l.getAttribute('href');
            if (href && !want[href]) l.remove();           /* drop old page's css */
            else if (href) have[href] = 1;
        });
        for (i = 0; i < add.length; i++) {
            if (!have[add[i]]) {
                var nl = document.createElement('link');
                nl.rel = 'stylesheet';
                nl.href = add[i];
                document.head.appendChild(nl);             /* add new page's css */
            }
        }
        if (page.title) document.title = page.title;
    }

    function parsePage(html, k) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        /* Pages without the shared navigation are auth/admin flows and
           should keep their normal full-page lifecycle. */
        if (!document.querySelector('.ka-nav') || !doc.querySelector('.ka-nav')) {
            throw new Error('page is not SPA-compatible');
        }
        var head = extractHead(doc);
        var page = {
            body: doc.body,
            scripts: extractScripts(doc),
            css: head.css,
            title: head.title
        };
        cache[k] = page;
        return page;
    }

    /* Shared, deduplicated fetch: warm() and nav() await the SAME promise,
       so hovering a link starts the request and a click on it swaps from
       memory with zero extra network cost. Rapid clicks never fire
       duplicate requests and never abort each other. */
    function getPage(href) {
        var p = new URL(href, location.href);
        var k = keyOf(p);
        if (cache[k]) return Promise.resolve(cache[k]);
        if (fetchers[k]) return fetchers[k];

        var controller = window.AbortController ? new AbortController() : null;
        var timeout = setTimeout(function () { if (controller) controller.abort(); }, 8000);

        var promise = fetch(p.href, {
            credentials: 'same-origin',
            headers: { 'X-KAI-PJAX': '1' },
            signal: controller ? controller.signal : undefined
        })
            .then(function (r) {
                if (!r.ok) throw new Error('bad status');
                return r.text();
            })
            .then(function (html) {
                clearTimeout(timeout);
                return parsePage(html, k);
            });
        fetchers[k] = promise;
        promise.then(function () {
            clearTimeout(timeout);
            if (fetchers[k] === promise) delete fetchers[k];
        }, function () {
            clearTimeout(timeout);
            if (fetchers[k] === promise) delete fetchers[k];
        });
        return promise;
    }

    function persistNodes() {
        var els = [];
        document.querySelectorAll(PERSIST).forEach(function (el) { els.push(el); });
        return els;
    }

    function syncNav(page) {
        var current = document.querySelector('.ka-nav');
        var incoming = page.body.querySelector('.ka-nav');
        if (!current || !incoming) return;
        current.querySelectorAll('a[href]').forEach(function (link) {
            var wanted = new URL(link.href, location.href).pathname;
            var next = Array.prototype.find.call(incoming.querySelectorAll('a[href]'), function (candidate) {
                return new URL(candidate.href, location.href).pathname === wanted;
            });
            if (next) {
                link.className = next.className;
                link.setAttribute('aria-current', next.getAttribute('aria-current') || (next.classList.contains('is-active') ? 'page' : 'false'));
            }
        });
    }

    function exec(s) {
        if (s.shared || (s.src && /\/(?:kai-router|kai-cosmos|kurdai-ui|kurdai-nav)\.js(?:\?|$)/.test(s.src))) return;
        try {
            var el = document.createElement('script');
            if (s.type) el.type = s.type;
            if (s.src) el.src = s.src;
            else el.text = s.text;
            document.body.appendChild(el);
        } catch (e) {}
    }

    function apply(page) {
        var persist = persistNodes();
        syncNav(page);
        var newBody = page.body.cloneNode(true);
        newBody.querySelectorAll('script').forEach(function (el) { el.remove(); });
        newBody.querySelectorAll(PERSIST).forEach(function (el) { el.remove(); });

        /* carry the target page's own body attributes over (theme/bg classes,
           data-*) so the swapped page matches the freshly-loaded one */
        if (page.body.hasAttributes()) {
            var attr = page.body.attributes, i;
            for (i = 0; i < attr.length; i++) {
                document.body.setAttribute(attr[i].name, attr[i].value);
            }
        }

        var frag = document.createDocumentFragment();
        while (newBody.firstChild) frag.appendChild(newBody.firstChild);

        /* replace body content (this removes old cosmos/cursor nodes too) */
        document.body.replaceChildren(frag);

        /* re-attach the persistent background layer */
        var cursor = null;
        persist.forEach(function (el) {
            if (el.id === 'kai-cursor') cursor = el;
            else document.body.insertBefore(el, document.body.firstChild);
        });
        if (cursor) document.body.appendChild(cursor);

        /* safety: if the background layer was never booted, re-run it */
        if (!document.getElementById('kai-cosmos')) {
            try {
                var cs = document.createElement('script');
                cs.src = '/js/kai-cosmos.js';
                document.body.appendChild(cs);
            } catch (e) {}
        }

        document.querySelectorAll('img:not([loading])').forEach(function (img) {
            img.loading = 'lazy';
            img.decoding = 'async';
        });
        document.querySelectorAll('iframe:not([loading])').forEach(function (frame) {
            frame.loading = 'lazy';
        });
        window.scrollTo(0, 0);
        page.scripts.forEach(exec);
    }

    /* Strip any leftover transition veils / loading classes so a page can
       never be left blank or dark after a swap — even if some UI code (or a
       stale cached script) added them. Runs after every navigation. */
    function cleanup() {
        document.documentElement.classList.remove('kai-vt', 'kai-leave', 'kai-enter');
        document.body.classList.remove('fade-out', 'opacity-0', 'loading');
        if (document.body.style.display === 'none') document.body.style.display = '';
        document.querySelectorAll('div').forEach(function (d) {
            var st = d.style && d.style.cssText ? d.style.cssText : '';
            if (st.indexOf('rgba(37,99,235,.16)') !== -1 && d.style.position === 'fixed') {
                if (d.parentNode) d.parentNode.removeChild(d);
            }
        });
        var veil = document.getElementById('kai-veil');
        if (veil) {
            veil.style.opacity = '0';
            setTimeout(function () { if (veil.parentNode) veil.parentNode.removeChild(veil); }, 600);
        }
    }

    /* Re-scan UI motion bindings after new content lands. */
    function reinitUI() {
        try {
            if (window.KaiUI && typeof window.KaiUI.reinit === 'function') {
                window.KaiUI.reinit(document);
            }
        } catch (e) {}
    }

    function pageVisible() {
        return !!(document.body && document.body.querySelector('.ka-nav') && document.body.textContent.trim());
    }

    function applySafely(page) {
        try {
            apply(page);
            return true;
        } catch (error) {
            console.error('[kai-router] page swap failed', error);
            return false;
        }
    }

    /* Swap + guaranteed final state: content injected, overlays stripped,
       UI re-bound, and a visible page. Any failure -> full page load. */
    function commit(page, href) {
        try {
            if (!applySafely(page)) throw new Error('apply failed');
            cleanup();
            reinitUI();
            if (!pageVisible()) throw new Error('page ended up blank');
            return true;
        } catch (error) {
            console.error('[kai-router] navigation failed', error);
            try { cleanup(); } catch (e) {}
            window.location.href = href;
            return false;
        }
    }

    function nav(href) {
        var p = new URL(href, location.href);
        var k = keyOf(p);
        var token = {};

        /* this click is now the latest — supersede any in-flight fetch */
        navToken = token;

        if (cache[k]) {
            history.pushState({ k: k }, '', p.href);
            withTransition(function () {
                if (navToken !== token) return;
                commit(cache[k], p.href);
            });
            return;
        }

        getPage(p.href).then(function () {
            /* only the latest click may swap the page — navToken stays === token
               so the (async) transition callback can still verify ownership */
            if (navToken !== token) return;
            syncHead(cache[k]);
            history.pushState({ k: k }, '', p.href);
            withTransition(function () {
                if (navToken !== token) return;
                commit(cache[k], p.href);
            });
        }).catch(function (error) {
            if (navToken !== token) return;
            /* AbortError only comes from our 8s safety timeout — never
               treat a cancelled request as a failure or reload the page. */
            if (error && error.name === 'AbortError') return;
            console.error('[kai-router] navigation failed', error);
            window.location.href = p.href;
        });
    }

    /* Pre-warm a page into the in-memory cache without touching the DOM.
       The prefetch layer calls this on pointerover/pointerdown so a click
       after a hover swaps instantly from cache. */
    function warm(href) {
        var p = new URL(href, location.href);
        if (p.origin !== location.origin) return;
        if (p.protocol !== 'http:' && p.protocol !== 'https:') return;
        var k = keyOf(p);
        if (cache[k] || fetchers[k]) return;
        getPage(p.href).catch(function () {});
    }

    document.addEventListener('click', function (e) {
        if (e.defaultPrevented) return;
        if (e.button && e.button !== 0) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (!interceptable(a)) return;
        e.preventDefault();
        var p = new URL(a.href, location.href);
        /* logged-in users never need the login page */
        if (p.pathname === '/login' && Object.keys(localStorage).some(function (k) { return k.indexOf('firebase:authUser') === 0; })) {
            nav('/');
            return;
        }
        nav(a.href);
    }, true);

    /* Prefetch on hover / pointer-down: the page is fetched before the user
       clicks, so the first click navigates instantly — no second-click needed.
       Deduplicated against in-flight fetches and already-cached pages. */
    document.addEventListener('pointerover', function (e) {
        var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (a && interceptable(a)) warm(a.href);
    }, true);
    document.addEventListener('pointerdown', function (e) {
        if (e.button && e.button !== 0) return;
        var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
        if (a && interceptable(a)) warm(a.href);
    }, true);

    window.addEventListener('popstate', function (e) {
        var k = location.pathname + (location.search || '');
        if (cache[k]) {
            withTransition(function () {
                commit(cache[k], location.href);
            });
        }
        else window.location.href = location.href;
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('img:not([loading])').forEach(function (img) {
            img.loading = 'lazy';
            img.decoding = 'async';
        });
        document.querySelectorAll('iframe:not([loading])').forEach(function (frame) {
            frame.loading = 'lazy';
        });
    });

    window.KaiRouter = { nav: nav, warm: warm };
})();
