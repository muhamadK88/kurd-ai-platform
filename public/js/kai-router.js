/* ==========================================================================
   KURD AI — kai-router (SPA navigation)
   Turbo-style instant page swapping: intercepts same-origin link clicks,
   fetches the next page (often already warmed by the prefetch layer),
   swaps only the target page's CONTENT REGION (everything between the
   persisted shell), syncs the per-page stylesheets + body classes, and
   re-runs only the scripts that belong to the new page. No full reload,
   no loading screen.

   What persists across swaps (the "shell"):
     - .ka-nav                    (site navigation — stays put, no repaint)
     - #kai-cosmos / #kai-aurora-sweep / #kai-cursor  (background layers,
        their rAF loops never restart or leak)

   What is swapped (the "content region"):
     - #main-content is cleared first, then rebuilt from the new page's
       parsed target root. Older pages without that wrapper are normalized
       into one, so a fetched <body>, header, or footer is never nested.

   Scripts are re-executed after the swap, in document order. The shared
   layers (kurdai-ui.js, kurdai-nav.js, kai-cosmos.js, kai-router.js and
   anything marked data-kai-shared) stay in the <head> and bind ONCE;
   kurdai-ui.js + kurdai-nav.js re-scan the DOM via MutationObserver when
   new content appears.

    v19 — Enterprise hardening:
     • SPA ALLOWLIST: only the public section pages are intercepted.
        Auth/admin/forms (login, dashboard, ferga_admin, edit, ...) go native
        immediately —
       zero wasted fetches, zero AbortError noise on those routes.
      • RACE-FREE NAVIGATION: a click owns a token; the 10s fallback timer
       and the fetch catch can never both navigate. AbortError (browser
       aborting the PJAX fetch during the fallback reload) is swallowed
       silently — it is an expected side-effect, not a failure.
     • NO ABORT ON THE NAV PATH: the nav fetch has no AbortController at
       all; only background warm() fetches abort (after 6s) so hung
       prefetches can never pin a fetcher entry.
     • FLASH-FREE CSS: new stylesheets are appended non-blocking
       (media="print" -> all) before the swap; stale stylesheets are
       pruned after the new page settles — no FOUC, no jank.
   ========================================================================== */
(function () {
    'use strict';
    if (window.__kaiRouterActive) return;
    window.__kaiRouterActive = true;

    var cache = {};      /* pathname+search -> { content, scripts, css, title, bodyClass } */
    var fetchers = {};   /* pathname+search -> shared in-flight fetch promise */
    var navToken = null; /* identity of the latest navigation click */

    /* ---------- SPA isolation ----------
       Only public section pages are SPA-swappable. Every other route
       (auth, admin, forms, API-ish pages) falls through to a native
       full page load. This is the FIRST gate, checked before any fetch,
       so non-SPA links never cost a byte or log an error. */
    var SPA_PATHS = {
        '/': 1, '/ferga': 1, '/courses': 1, '/news': 1, '/ai-tools': 1,
        '/academic-guide': 1, '/universities': 1, '/general-info': 1,
        '/about': 1, '/feedback': 1, '/profile': 1
    };
    function isSpaPath(pathname) {
        return SPA_PATHS[pathname] === 1;
    }

    /* ---------- page transition ----------
       Keep navigation synchronous. Native View Transitions can retain a
       frozen snapshot while a page script or a large DOM update is pending;
       that looks like a browser freeze. The router therefore commits the
       already-fetched page immediately instead of wrapping it in a native
       transition. */
    function withTransition(fn) {
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
        /* STRICT isolation: non-SPA routes are never intercepted. */
        if (!isSpaPath(p.pathname)) return false;
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

    function extractHead(doc) {
        var css = [], seen = {}, i, href;
        var l = doc.querySelectorAll('link[rel="stylesheet"]');
        for (i = 0; i < l.length; i++) {
            href = l[i].getAttribute('href');
            if (href && !seen[href]) { seen[href] = 1; css.push(href); }
        }
        return { css: css, title: doc.title || '' };
    }

    /* Flash-free CSS sync: append the new page's stylesheets with the
       print-media trick (never render-blocking), then prune stylesheets
       the new page does not reference once it has settled. Old CSS stays
       applied during the swap so there is no white/unstyled flash. */
    var lastCss = [];
    function syncHead(page) {
        var have = {};
        document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
            var href = l.getAttribute('href');
            if (href) have[href] = 1;
        });
        page.css.forEach(function (href) {
            if (!have[href]) {
                var nl = document.createElement('link');
                nl.rel = 'stylesheet';
                nl.href = href;
                nl.media = 'print';
                nl.onload = function () { nl.media = 'all'; };
                document.head.appendChild(nl);
            }
        });
        lastCss = page.css;
        if (page.title) document.title = page.title;
    }

    function pruneCss(page) {
        var want = {};
        page.css.forEach(function (href) { want[href] = 1; });
        document.querySelectorAll('link[rel="stylesheet"]').forEach(function (l) {
            var href = l.getAttribute('href');
            if (href && !want[href]) l.remove();
        });
    }

    /* Shell elements survive every swap untouched. The router owns
       #main-content, so only that root is cleared and replaced. */
    function isShellEl(el) {
        if (!el || el.nodeType !== 1) return false;
        if (el.classList && el.classList.contains('ka-nav')) return true;
        var id = el.id || '';
        return id === 'kai-cosmos' || id === 'kai-aurora-sweep' ||
               id === 'kai-cursor' || id === 'main-content';
    }

    function isScriptEl(el) {
        return el && (el.tagName === 'SCRIPT' || el.tagName === 'NOSCRIPT');
    }

    /* Return the page's one content root. Existing #main-content is preferred;
       #app is accepted only when it does not contain the shared navigation.
       Older pages without either wrapper are normalized into a detached
       #main-content root, preventing body/header/footer nesting. */
    function extractContentRoot(doc) {
        var root = doc.querySelector('#main-content');
        if (!root) {
            root = doc.querySelector('#app');
            if (root && root.querySelector('.ka-nav')) root = null;
        }
        if (root) return root;

        root = doc.createElement('div');
        root.id = 'main-content';
        Array.prototype.slice.call(doc.body.children).forEach(function (el) {
            if (!isShellEl(el) && !isScriptEl(el)) root.appendChild(el);
        });
        return root;
    }

    function contentNodes(root) {
        return Array.prototype.slice.call(root.children).filter(function (el) {
            return !isScriptEl(el);
        }).map(function (el) {
            /* Scripts anywhere inside the target root are handled by exec()
               below; keeping cloned script tags would leave inert duplicates
               in the DOM and could confuse page initializers. */
            var copy = el.cloneNode(true);
            copy.querySelectorAll('script, noscript').forEach(function (script) {
                script.remove();
            });
            return copy;
        });
    }

    /* Ensure the current document has exactly one live content root. This
       also repairs pages rendered before the router wrapper was introduced. */
    function ensureLiveContentRoot() {
        var body = document.body;
        var root = body.querySelector('#main-content');
        if (root && root.parentNode === body) return root;

        root = document.createElement('div');
        root.id = 'main-content';
        var anchor = null;
        Array.prototype.slice.call(body.children).forEach(function (el) {
            if (el === root || isShellEl(el) || isScriptEl(el)) return;
            if (!anchor) anchor = el;
            root.appendChild(el);
        });
        if (anchor && anchor.parentNode === body) body.insertBefore(root, anchor);
        else body.appendChild(root);
        return root;
    }

    function parsePage(html, k) {
        var doc = new DOMParser().parseFromString(html, 'text/html');
        /* Defense-in-depth: pages without the shared navigation are
           auth/admin flows and must keep their normal full-page lifecycle.
           (The SPA allowlist above already prevents fetching these.) */
        if (!document.querySelector('.ka-nav') || !doc.querySelector('.ka-nav')) {
            throw new Error('page is not SPA-compatible');
        }
        var head = extractHead(doc);
        var contentRoot = extractContentRoot(doc);
        var page = {
            body: doc.body,
            content: contentNodes(contentRoot),
            scripts: extractScripts(doc),
            css: head.css,
            title: head.title,
            bodyClass: doc.body.className || ''
        };
        cache[k] = page;
        return page;
    }

    /* Shared fetch/cache: a completed warm() result makes nav() instant, but
       a real navigation supersedes a warm request that is still in flight.
       Rapid clicks never fire duplicate navigation requests or abort each
       other's active fetch.

       The NAV path carries NO AbortController: only the nav() fallback
       timer decides when a slow response gives up (full page load). A
       browser abort during that fallback is expected and handled silently
       in nav() — it is no longer a source of console noise or double
       navigation. Warm() prefetches do abort after 6s so a hung
       background request can never pin its fetcher entry forever. */
    var warmCtrls = {}; /* in-flight warm-up fetches, keyed by path key */
    var prewarmTimer = null;
    var prewarmStopped = false;
    function abortWarm() {
        prewarmStopped = true;
        if (prewarmTimer) {
            clearTimeout(prewarmTimer);
            prewarmTimer = null;
        }
        var keys = Object.keys(warmCtrls);
        for (var i = 0; i < keys.length; i++) {
            try { warmCtrls[keys[i]].abort(); } catch (e) {}
            /* an aborted warm fetch must not be handed to a waiting nav()
               caller as the "in-flight fetcher" — it will only reject.
               Drop it so a navigation starts a fresh request. */
            delete fetchers[keys[i]];
        }
        warmCtrls = {};
    }

    function getPage(href, priority) {
        var p = new URL(href, location.href);
        var k = keyOf(p);
        if (cache[k]) return Promise.resolve(cache[k]);
        if (fetchers[k]) {
            if (priority !== 'low') {
                /* a real navigation supersedes any warm fetch still in
                   flight for the same page: abort it and fetch fresh so
                   the click can never ride a doomed promise */
                if (warmCtrls[k]) {
                    try { warmCtrls[k].abort(); } catch (e) {}
                    delete warmCtrls[k];
                }
                delete fetchers[k];
            } else {
                return fetchers[k];
            }
        }

        var isWarm = priority === 'low';
        var controller = (isWarm && window.AbortController) ? new AbortController() : null;
        var timeout = null;
        if (controller) {
            warmCtrls[k] = controller;
            timeout = setTimeout(function () { controller.abort(); }, 6000);
        }

        var promise = fetch(p.href, {
            credentials: 'same-origin',
            headers: { 'X-KAI-PJAX': '1' },
            signal: controller ? controller.signal : undefined,
            priority: priority || undefined
        })
            .then(function (r) {
                if (!r.ok) throw new Error('bad status');
                return r.text();
            })
            .then(function (html) {
                if (timeout) clearTimeout(timeout);
                return parsePage(html, k);
            });
        fetchers[k] = promise;
        promise.then(function () {
            if (timeout) clearTimeout(timeout);
            delete warmCtrls[k];
            if (fetchers[k] === promise) delete fetchers[k];
        }, function () {
            if (timeout) clearTimeout(timeout);
            delete warmCtrls[k];
            if (fetchers[k] === promise) delete fetchers[k];
        });
        return promise;
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
        syncNav(page);
        /* soft-navigation marker: entrance animations are one-shot "page
           load" effects. Marking the document lets CSS (kurdai-design.css
           html.kai-spa rules) keep their final state instead of re-blanking
           the hero/news header + news cards for ~1.4s on every swap. */
        document.documentElement.classList.add('kai-spa');
        var contentRoot = ensureLiveContentRoot();

        /* take on the new page's body classes. Replacing the whole
           class attribute drops every old page class AND any transient
           loading/veil classes the previous page may have left behind. */
        if (typeof page.bodyClass === 'string' && document.body.className !== page.bodyClass) {
            document.body.className = page.bodyClass;
        }

        /* Remove stale page scripts outside the root. The root itself is
           cleared before any incoming node is inserted. */
        Array.prototype.slice.call(document.body.children).forEach(function (el) {
            if (isScriptEl(el)) el.remove();
        });

        /* clear only #main-content, then insert only the parsed target
           content. The old body/nav/footer are never nested. The cached
           nodes are already detached clones, so appending them directly
           (instead of re-cloning the whole tree on every swap) keeps the
           swap cheap on the large pages. */
        var frag = document.createDocumentFragment();
        page.content.forEach(function (node) {
            frag.appendChild(node);
        });
        contentRoot.replaceChildren(frag);

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

        /* re-execute the scripts that belong to the new page */
        page.scripts.forEach(exec);
    }

    /* Strip any leftover transition veils / loading classes so a page can
       never be left blank or dark after a swap — even if some UI code (or a
       stale cached script) added them. Runs after every navigation. */
    function cleanup() {
        document.documentElement.classList.remove('kai-vt', 'kai-leave', 'kai-enter');
        document.body.classList.remove('fade-out', 'opacity-0', 'loading');
        if (document.body.style.display === 'none') document.body.style.display = '';
        sweepStuck();
        var veil = document.getElementById('kai-veil');
        if (veil) {
            veil.style.opacity = '0';
            setTimeout(function () { if (veil.parentNode) veil.parentNode.removeChild(veil); }, 600);
        }
    }

    /* Targeted late pass: some UI code adds loading/veil classes AFTER the
       swap (transition-end handlers, async renders). Removing them is what
       keeps the new page from mixing with a dark/blank overlay. Does not
       touch the morph animation classes. */
    function sweepStuck() {
        document.body.classList.remove('fade-out', 'opacity-0', 'loading');
        if (document.body.style.display === 'none') document.body.style.display = '';
        document.querySelectorAll('div[style]').forEach(function (d) {
            var st = d.style && d.style.cssText ? d.style.cssText : '';
            if (st.indexOf('rgba(37,99,235,.16)') !== -1 && d.style.position === 'fixed') {
                if (d.parentNode) d.parentNode.removeChild(d);
            }
        });
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
        var root = document.getElementById('main-content');
        return !!(document.body && document.querySelector('.ka-nav') &&
                  root && root.childElementCount > 0);
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
            /* Lifecycle signal for any script that was not re-executed on
               the swap (shared layers, long-lived widgets, analytics).
               Dispatched after the new content is in place and the shell
               is stable. */
            try {
                document.dispatchEvent(new CustomEvent('page:swapped', {
                    detail: { href: href, pathname: new URL(href, location.href).pathname }
                }));
            } catch (ignore) {}
            if (!pageVisible()) throw new Error('page ended up blank');
            /* late passes: catch loading/veil classes dropped after the swap */
            setTimeout(sweepStuck, 250);
            setTimeout(sweepStuck, 900);
            /* prune stylesheets the new page does not reference, once it
               has settled — prevents CSS accumulation across swaps */
            setTimeout(function () { pruneCss(page); }, 1200);
            return true;
        } catch (error) {
            console.error('[kai-router] navigation failed', error);
            try { cleanup(); } catch (e) {}
            window.location.href = href;
        }
    }

    /* Single-navigation guarantee. A click owns `token`; exactly ONE of
       the following may navigate to the target:
         1. the fallback timer (slow response -> native reload), or
         2. the PJAX success path (in-place swap).
       The fetch catch NEVER navigates if the fallback already did — that
       was the old double-navigation bug. AbortError is logged silently:
       it simply means the browser cancelled the PJAX fetch while the
       fallback reload was starting, which is expected behaviour. */
    function nav(href) {
        var p = new URL(href, location.href);
        var k = keyOf(p);
        var token = { navigated: false };

        /* a real navigation supersedes every background warm-up fetch —
           aborting them clears the server queue so this click is never
           stuck behind a burst of prefetches */
        abortWarm();

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

        /* If the PJAX request has not produced a usable page within a
           generous window, let the browser perform a normal navigation.
           The old 3s window was too aggressive: a busy server (or warm-up
           fetches queued ahead of the click) would trip it and turn every
           SPA click into a full page reload. 10s only gives up on a
           genuinely hung request, while the click is meanwhile covered by
           the pre-warmed cache. */
        var fallbackTimer = setTimeout(function () {
            if (navToken === token && !token.navigated) {
                token.navigated = true;
                navToken = null;
                window.location.assign(p.href);
            }
        }, 10000);

        getPage(p.href, 'high').then(function () {
            clearTimeout(fallbackTimer);
            /* only the latest click may swap the page */
            if (navToken !== token) return;
            syncHead(cache[k]);
            history.pushState({ k: k }, '', p.href);
            withTransition(function () {
                if (navToken !== token) return;
                commit(cache[k], p.href);
            });
        }).catch(function (error) {
            clearTimeout(fallbackTimer);
            /* If the fallback timer already started a native reload (or a
               newer click superseded this one), do nothing more. */
            if (token.navigated) return;
            if (navToken !== token) return;
            token.navigated = true;
            navToken = null;
            /* An AbortError here is the browser cancelling the PJAX fetch
               because the fallback reload is in flight — or the user
               pressed stop. Neither needs console noise. */
            if (!error || error.name !== 'AbortError') {
                console.error('[kai-router] navigation failed', error);
            }
            window.location.assign(p.href);
        });
    }

    /* Pre-warm a page into the in-memory cache without touching the DOM.
       The prefetch layer calls this on pointerover/pointerdown so a click
       after a hover swaps instantly from cache. Only SPA routes warm. */
    function warm(href) {
        var p = new URL(href, location.href);
        if (p.origin !== location.origin) return Promise.resolve();
        if (p.protocol !== 'http:' && p.protocol !== 'https:') return Promise.resolve();
        if (!isSpaPath(p.pathname)) return Promise.resolve();
        var k = keyOf(p);
        if (cache[k] || fetchers[k]) return Promise.resolve();
        return getPage(p.href, 'low').catch(function () {});
    }

    /* Event delegation: one document-level listener handles links that exist
       now and links inserted by every later page. Install it at DOM-ready,
       but install immediately when this deferred script loads after ready. */
    function installEvents() {
        if (window.__kaiRouterEventsInstalled) return;
        window.__kaiRouterEventsInstalled = true;

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

        /* Prefetch dynamically-created links without attaching listeners to
           individual anchors. interceptable() limits this to SPA routes. */
        document.addEventListener('pointerover', function (e) {
            var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
            if (a && interceptable(a)) warm(a.href);
        }, true);
        document.addEventListener('pointerdown', function (e) {
            if (e.button && e.button !== 0) return;
            var a = e.target && e.target.closest ? e.target.closest('a[href]') : null;
            if (a && interceptable(a)) warm(a.href);
        }, true);
    }

    /* A document-level listener does not need the DOM to be complete. Install
       it now, before Firebase/modules or DOMContentLoaded can delay the first
       click. The delegated lookup works for current and future anchors. */
    installEvents();

    /* Pull section pages into the in-memory cache one at a time shortly after
       first paint. A fixed timer list still creates a server queue when one
       response is slow; chaining each warm-up after the previous response
       keeps php -S and other single-worker hosts responsive to real clicks. */
    var prewarmed = false;
    function prewarmNav() {
        if (prewarmed || prewarmStopped) return;
        prewarmed = true;
        var links = document.querySelectorAll('.ka-nav a[href]');
        var seen = {}, queue = [];
        Array.prototype.slice.call(links).forEach(function (a) {
            var href = a.getAttribute('href');
            if (!href || seen[href]) return;
            seen[href] = 1;
            queue.push(href);
        });
        var index = 0;
        function next() {
            if (prewarmStopped || index >= queue.length) return;
            var href = queue[index++];
            prewarmTimer = setTimeout(function () {
                prewarmTimer = null;
                if (prewarmStopped) return;
                warm(href).then(next, next);
            }, index === 1 ? 0 : 120);
        }
        next();
    }

    function schedulePreWarm() {
        if (window.requestIdleCallback) {
            requestIdleCallback(prewarmNav, { timeout: 2500 });
        } else {
            setTimeout(prewarmNav, 2000);
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', schedulePreWarm, { once: true });
    } else {
        schedulePreWarm();
    }

    window.addEventListener('popstate', function (e) {
        var k = location.pathname + (location.search || '');
        if (cache[k]) {
            syncHead(cache[k]);
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
