/* ==========================================================================
   KURD AI — Hero "Neural Horizon" v2 · home page only.
   1) Lang-aware typewriter subheading (Sorani + Badini).
   2) Canvas-2D neural particle sphere — fibonacci lattice, constellation
      wiring, cursor-reactive parallax + breathing (no three.js).
   3) Pure additive layer. Guards: reduced-motion / touch / kai-perf / no-WebGL.
   ========================================================================== */
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isTouch = window.matchMedia('(hover: none)').matches;
    var lowEnd = (navigator.deviceMemory && navigator.deviceMemory < 4) ||
                 (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4);
    var perf = document.documentElement.classList.contains('kai-perf') || lowEnd;

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
        } else {
            fn();
        }
    }

    /* home page is gated behind Firebase auth, so <body> starts display:none
       and only becomes visible after login resolves. Defer size-dependent
       work (the sphere) until the page is actually laid out. */
    function whenVisible(cb) {
        var tries = 0;
        var iv = setInterval(function () {
            if ((document.body && document.body.style.display !== 'none' && document.body.offsetHeight > 0) || ++tries > 80) {
                clearInterval(iv);
                cb();
            }
        }, 150);
    }

    function lang() { return localStorage.getItem('site-lang') === 'ba' ? 'ba' : 'so'; }

    /* ======================================================================
        1. Typewriter subheading (lang-aware, skips anim under reduced-motion)
       ====================================================================== */
    var PHRASES = {
        so: [
            'پڕۆگرامسازی بە کوردی فێر بە',
            'زیرەکی دەستکرد بە زمانی دایک',
            'کۆدی خۆت لەوێ تاقی بکەوە',
            'ئامرازەکانی AI بەکاربهێنە'
        ],
        ba: [
            'ب کوردی پڕۆگرامسازیێ فێر بە',
            'ژیرییا دەستکرد ب زمانێ دایک',
            'کۆدا خۆ ڤێرە تاقی بکە',
            'ئامرازێن AI بکارئینە'
        ]
    };

    function initTypewriter(el) {
        if (!el) return;
        var words = PHRASES[lang()];
        if (reduced) { el.textContent = words[0]; return; }

        /* One shared state object: re-running this on every SPA swap clears
           the previous timer and re-targets the fresh element instead of
           stacking timers + kai:langchange listeners on every home visit. */
        var st = window.__kaiType;
        if (!st) {
            st = window.__kaiType = {};
            st.tick = function () {
                var word = st.words[st.wi];
                if (st.el) st.el.textContent = word.slice(0, st.ci);
                var delay;
                if (!st.deleting) {
                    if (st.ci < word.length) { st.ci++; delay = 72; }
                    else { st.deleting = true; delay = 1900; }
                } else {
                    if (st.ci > 0) { st.ci--; delay = 32; }
                    else { st.deleting = false; st.wi = (st.wi + 1) % st.words.length; delay = 380; }
                }
                st.timer = setTimeout(st.tick, delay);
            };
        }
        if (st.timer) clearTimeout(st.timer);
        st.el = el;
        st.words = words;
        st.wi = 0; st.ci = 0; st.deleting = false;
        st.tick();

        /* The shared navbar handles the first click through delegated
           capture events while page modules are still loading. React to its
           language event instead of binding a second direct click handler.
           Bound once globally — later re-inits just retarget the state. */
        if (!window.__kaiHeroLangBound) {
            window.__kaiHeroLangBound = true;
            window.addEventListener('kai:langchange', function () {
                var s = window.__kaiType;
                if (!s) return;
                if (s.timer) clearTimeout(s.timer);
                s.words = PHRASES[lang()];
                s.wi = 0; s.ci = 0; s.deleting = false;
                s.tick();
            });
        }
    }

    /* ======================================================================
       2. Neural particle sphere (Canvas 2D — no three.js)
       ====================================================================== */
    function mountSphere() {
        if (typeof window.__kaiSphereCleanup === 'function') window.__kaiSphereCleanup();
        if (reduced || perf || isTouch) return;

        var host = document.getElementById('kai-neuro-sphere');
        if (!host || host.dataset.kaiMounted) return;
        host.dataset.kaiMounted = '1';

        var W = host.clientWidth || 360;
        var H = host.clientHeight || W;
        var DPR = Math.min(window.devicePixelRatio || 1, 2);

        var canvas = document.createElement('canvas');
        canvas.setAttribute('aria-hidden', 'true');
        canvas.style.cssText = 'display:block;width:100%;height:100%;pointer-events:none;';
        host.appendChild(canvas);
        var ctx = canvas.getContext('2d');
        if (!ctx) {
            canvas.remove();
            return;
        }

        /* fibonacci sphere — uniform point distribution */
        var palette = ['#22d3ee', '#818cf8', '#c084fc', '#f472b6', '#38bdf8'];
        var golden = Math.PI * (3 - Math.sqrt(5));
        var COUNT = 420;
        var R = 0, pts = [], edges = [], thr2 = 0, camD = 0;

        function buildGeometry() {
            R = Math.min(W, H) * 0.32;
            pts.length = 0;
            for (var i = 0; i < COUNT; i++) {
                var y = 1 - (i / (COUNT - 1)) * 2;
                var rad = Math.sqrt(Math.max(0, 1 - y * y));
                var th = golden * i;
                pts.push({
                    x: Math.cos(th) * rad * R,
                    y: y * R,
                    z: Math.sin(th) * rad * R,
                    c: palette[i % palette.length]
                });
            }
            /* constellation wiring — near neighbours, computed once per geometry */
            var thr = R * 0.30;
            thr2 = thr * thr;
            var MAX = 620;
            edges.length = 0;
            for (var a = 0; a < COUNT && edges.length < MAX; a++) {
                for (var b = a + 1; b < COUNT && edges.length < MAX; b++) {
                    var dx = pts[a].x - pts[b].x;
                    var dy = pts[a].y - pts[b].y;
                    var dz = pts[a].z - pts[b].z;
                    if (dx * dx + dy * dy + dz * dz < thr2) edges.push(a, b);
                }
            }
            camD = R * 2.4;
        }

        function resize() {
            var w = host.clientWidth || W;
            var h = host.clientHeight || w;
            if (!w || !h) return;
            W = w; H = h;
            canvas.width = Math.round(W * DPR);
            canvas.height = Math.round(H * DPR);
            ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
            buildGeometry();
        }
        window.addEventListener('resize', resize);

        /* cursor-reactive parallax (pointer within stage bounds) */
        var tx = 0, ty = 0, curX = 0, curY = 0;
        function onPointerMove(e) {
            var r = host.getBoundingClientRect();
            if (e.clientX < r.left - 60 || e.clientX > r.right + 60 ||
                e.clientY < r.top - 60 || e.clientY > r.bottom + 60) return;
            tx = ((e.clientX - r.left) / r.width - 0.5) * 2;
            ty = ((e.clientY - r.top) / r.height - 0.5) * 2;
        }
        if (!isTouch) {
            document.addEventListener('pointermove', onPointerMove, { passive: true });
        }

        var running = true;
        var cx = 0, cy = 0;
        function onVisibilityChange() {
            if (document.hidden) { running = false; }
            else if (!running) { running = true; frame(); }
        }
        function cleanup() {
            running = false;
            window.removeEventListener('resize', resize);
            document.removeEventListener('pointermove', onPointerMove);
            document.removeEventListener('visibilitychange', onVisibilityChange);
            if (window.__kaiSphereCleanup === cleanup) window.__kaiSphereCleanup = null;
        }
        window.__kaiSphereCleanup = cleanup;

        function frame() {
            if (!running) return;
            requestAnimationFrame(frame);
            /* Stop the loop as soon as this canvas leaves the document: SPA
               swaps replace #kai-neuro-sphere, and without this check every
               visit to home leaks another never-ending rAF loop that slows
               the whole page down over time. */
            if (!canvas.isConnected) { cleanup(); return; }
            var t = performance.now() * 0.0001;

            curX += (tx - curX) * 0.055;
            curY += (ty - curY) * 0.055;

            var rotY = t * 0.28 + curX * 0.4;
            var rotX = curY * 0.5 + t * 0.06;
            var cosY = Math.cos(rotY), sinY = Math.sin(rotY);
            var cosX = Math.cos(rotX), sinX = Math.sin(rotX);

            cx = W / 2; cy = H / 2;

            /* rotate + perspective-project */
            var proj = new Array(COUNT);
            for (var i = 0; i < COUNT; i++) {
                var p = pts[i];
                var x1 = p.x * cosY + p.z * sinY;
                var z1 = -p.x * sinY + p.z * cosY;
                var y1 = p.y * cosX - z1 * sinX;
                var z2 = p.y * sinX + z1 * cosX;
                var fov = camD / (camD - z2);
                proj[i] = {
                    x: cx + x1 * fov,
                    y: cy + y1 * fov,
                    z: z2,
                    d: (z2 + R) / (2 * R),
                    c: p.c
                };
            }

            ctx.clearRect(0, 0, W, H);

            /* constellation wiring (skip fully back-facing pairs) */
            ctx.lineWidth = 1;
            for (var e = 0; e < edges.length; e += 2) {
                var A = proj[edges[e]], B = proj[edges[e + 1]];
                if (A.z < 0 && B.z < 0) continue;
                var al = 0.05 + 0.2 * (A.d + B.d) * 0.5;
                ctx.strokeStyle = 'rgba(34,211,238,' + al.toFixed(3) + ')';
                ctx.beginPath();
                ctx.moveTo(A.x, A.y);
                ctx.lineTo(B.x, B.y);
                ctx.stroke();
            }

            /* soft inner glow core */
            var glowR = R * 0.26;
            var g = ctx.createRadialGradient(cx, cy, 0, cx, cy, glowR);
            g.addColorStop(0, 'rgba(124,58,237,0.22)');
            g.addColorStop(1, 'rgba(124,58,237,0)');
            ctx.fillStyle = g;
            ctx.fillRect(cx - glowR, cy - glowR, glowR * 2, glowR * 2);

            /* points, depth-sorted back-to-front, breathing */
            var order = new Array(COUNT);
            for (var k = 0; k < COUNT; k++) order[k] = k;
            order.sort(function (p, q) { return proj[p].z - proj[q].z; });

            var breathe = Math.sin(t * 2.2);
            for (var o = 0; o < COUNT; o++) {
                var q = proj[order[o]];
                if (q.d < 0.02) continue;
                var size = (1.1 + breathe * 0.35) * (0.6 + q.d * 1.2);
                ctx.globalAlpha = Math.min(1, 0.15 + q.d * 0.8);
                ctx.fillStyle = q.c;
                ctx.beginPath();
                ctx.arc(q.x, q.y, size, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.globalAlpha = 1;
        }

        document.addEventListener('visibilitychange', onVisibilityChange);

        resize();
        buildGeometry();
        frame();
    }

    /* ======================================================================
       boot
       ====================================================================== */
    ready(function () {
        initTypewriter(document.getElementById('kai-typewriter'));
        whenVisible(mountSphere);
    });
})();
