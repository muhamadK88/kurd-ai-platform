/* ==========================================================================
   KURD AI — "Cosmos" v6 · whole-site background universe.
   Canvas-2D particle constellation (no three.js, ~1/6th the payload) +
   aurora orbs + cursor glow + sparkle trail + click bursts + aurora sweep
   + shooting stars. Pure additive layer — never touches page logic, classes
   or data. Degrades gracefully: reduced-motion / touch / low-end / mobile
   all keep the page functional and fast.
   ========================================================================== */
(function () {
    'use strict';

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var isTouch = window.matchMedia('(hover: none)').matches;
    var lowEnd = (navigator.deviceMemory && navigator.deviceMemory < 4) ||
                 (navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4);
    var perf = document.documentElement.classList.contains('kai-perf') || lowEnd;

    if (reduced) return;

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn, { once: true });
        } else {
            fn();
        }
    }

    var cosmos = null;

    function getCosmos() {
        if (cosmos) return cosmos;
        cosmos = document.getElementById('kai-cosmos');
        if (!cosmos) {
            cosmos = document.createElement('div');
            cosmos.id = 'kai-cosmos';
            cosmos.setAttribute('aria-hidden', 'true');
            document.body.insertBefore(cosmos, document.body.firstChild);
        }
        return cosmos;
    }

    /* ======================================================================
       1. Floating aurora orbs (CSS-only, composited transforms)
       ====================================================================== */
    function mountOrbs() {
        var box = getCosmos();
        if (box.querySelector('.kai-orb')) return;

        var palette = [
            { c: 'rgba(37,99,235,.55)',  t: '8%',  l: '6%',  s: 44, d: 30, x: '-8vw',  y: '-12vh', delay: -7,  o: .42 },
            { c: 'rgba(6,182,212,.5)',   t: '12%', l: '52%', s: 34, d: 23, x: '9vw',   y: '-7vh',  delay: -14, o: .34 },
            { c: 'rgba(124,58,237,.5)',  t: '52%', l: '12%', s: 46, d: 33, x: '12vw',  y: '9vh',   delay: -19, o: .38 },
            { c: 'rgba(236,72,153,.45)', t: '74%', l: '70%', s: 30, d: 25, x: '-9vw',  y: '8vh',   delay: -10, o: .30 },
            { c: 'rgba(245,158,11,.4)',  t: '42%', l: '84%', s: 26, d: 21, x: '7vw',   y: '10vh',  delay: -4,  o: .26 }
        ];

        palette.forEach(function (p) {
            var el = document.createElement('div');
            el.className = 'kai-orb';
            el.setAttribute('aria-hidden', 'true');
            el.style.top = p.t;
            el.style.left = p.l;
            el.style.width = p.s + 'vw';
            el.style.height = p.s + 'vw';
            el.style.background = 'radial-gradient(circle at 35% 35%, ' + p.c + ', transparent 70%)';
            el.style.setProperty('--kai-orb-x', p.x);
            el.style.setProperty('--kai-orb-y', p.y);
            el.style.setProperty('--kai-orb-d', p.d + 's');
            el.style.setProperty('--kai-orb-o', String(p.o));
            el.style.setProperty('--kai-orb-delay', p.delay + 's');
            box.appendChild(el);
        });
    }

    /* ======================================================================
       2. Canvas-2D particle constellation (replaces the three.js scene).
       Renders at a capped ~30 FPS and pauses when the tab is hidden.
       ====================================================================== */
    function mountParticles() {
        if (perf) return;

        var box = getCosmos();
        var canvas = document.createElement('canvas');
        canvas.setAttribute('aria-hidden', 'true');
        box.appendChild(canvas);
        var ctx = canvas.getContext('2d');
        if (!ctx) {
            canvas.remove();
            return;
        }

        var reduce = isTouch;
        var COUNT = reduce ? 70 : 150;
        var DPR = Math.min(window.devicePixelRatio || 1, 1.5);
        var W = 0, H = 0;
        var pts = [];
        var palette = ['#2563eb', '#06b6d4', '#7c3aed', '#ec4899', '#f59e0b', '#38bdf8'];
        var angle = 0, mx = 0, my = 0, camX = 0, camY = 0;
        var running = false, last = 0;
        var FPS = 30;

        function initPoints() {
            pts.length = 0;
            var spreadX = Math.min(W, H) * 0.55;
            var spreadY = spreadX * 0.66;
            for (var i = 0; i < COUNT; i++) {
                pts.push({
                    x: (Math.random() - 0.5) * 2 * spreadX,
                    y: (Math.random() - 0.5) * 2 * spreadY,
                    z: (Math.random() - 0.5) * 90,
                    c: palette[i % palette.length],
                    ph: Math.random() * Math.PI * 2
                });
            }
        }

        function resize() {
            W = window.innerWidth;
            H = window.innerHeight;
            if (!W || !H) return;
            canvas.width = Math.round(W * DPR);
            canvas.height = Math.round(H * DPR);
            canvas.style.width = W + 'px';
            canvas.style.height = H + 'px';
            ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
            initPoints();
        }

        function frame(ts) {
            if (!running) return;
            requestAnimationFrame(frame);
            if (!document.body.contains(canvas)) { running = false; return; }
            if (ts - last < 1000 / FPS) return;
            last = ts;

            ctx.clearRect(0, 0, W, H);

            camX += (mx * 34 - camX) * 0.045;
            camY += (-my * 26 - camY) * 0.045;
            angle += 0.00065;
            var cos = Math.cos(angle), sin = Math.sin(angle);
            var t = performance.now() * 0.001;
            var cx = W / 2 + camX, cy = H / 2 + camY;

            var proj = [];
            for (var i = 0; i < pts.length; i++) {
                var p = pts[i];
                var rx = p.x * cos - p.z * sin;
                var rz = p.x * sin + p.z * cos;
                var fov = 480 / (480 - rz);
                proj.push({
                    x: cx + rx * fov,
                    y: cy + p.y * fov,
                    z: rz,
                    c: p.c,
                    s: (1.1 + Math.sin(t * 2 + p.ph) * 0.5) * fov,
                    o: Math.max(0.08, Math.min(0.9, 0.5 * fov))
                });
            }

            var thr = 88 * (Math.min(W, H) / 800);
            var thr2 = thr * thr;
            var n = Math.min(proj.length, 110);
            ctx.lineWidth = 1;
            for (var a = 0; a < n; a++) {
                var pa = proj[a];
                for (var b = a + 1; b < n; b++) {
                    var pb = proj[b];
                    var dx = pa.x - pb.x, dy = pa.y - pb.y;
                    var d2 = dx * dx + dy * dy;
                    if (d2 < thr2) {
                        var al = 0.12 * (1 - Math.sqrt(d2) / thr);
                        ctx.strokeStyle = 'rgba(103,216,255,' + al.toFixed(3) + ')';
                        ctx.beginPath();
                        ctx.moveTo(pa.x, pa.y);
                        ctx.lineTo(pb.x, pb.y);
                        ctx.stroke();
                    }
                }
            }

            for (var k = 0; k < proj.length; k++) {
                var q = proj[k];
                ctx.globalAlpha = q.o;
                ctx.fillStyle = q.c;
                ctx.beginPath();
                ctx.arc(q.x, q.y, q.s, 0, Math.PI * 2);
                ctx.fill();
            }
            ctx.globalAlpha = 1;
        }

        function start() { if (!running) { running = true; requestAnimationFrame(frame); } }
        function stop() { running = false; }

        if (!isTouch) {
            window.addEventListener('pointermove', function (e) {
                mx = e.clientX / window.innerWidth - 0.5;
                my = e.clientY / window.innerHeight - 0.5;
            }, { passive: true });
        }
        window.addEventListener('resize', resize);
        document.addEventListener('visibilitychange', function () {
            if (document.hidden) stop(); else start();
        });

        resize();
        start();
    }

    /* ======================================================================
       3. Cursor glow (pointer devices only)
       ====================================================================== */
    function mountCursor() {
        if (isTouch) return;
        var el = document.createElement('div');
        el.id = 'kai-cursor';
        el.setAttribute('aria-hidden', 'true');
        document.body.appendChild(el);

        var x = -300, y = -300, tx = x, ty = y;

        document.addEventListener('pointermove', function (e) {
            tx = e.clientX;
            ty = e.clientY;
            if (!el.classList.contains('kai-on')) el.classList.add('kai-on');
        }, { passive: true });

        (function tick() {
            requestAnimationFrame(tick);
            if (!document.body.contains(el)) return;
            x += (tx - x) * 0.14;
            y += (ty - y) * 0.14;
            el.style.transform = 'translate3d(' + x.toFixed(1) + 'px,' + y.toFixed(1) + 'px,0) translate(-50%,-50%)';
        })();
    }

    /* ======================================================================
       4. Sparkle trail + click bursts
       ====================================================================== */
    var SPARK_COLORS = ['#38bdf8', '#a78bfa', '#f472b6', '#fbbf24', '#34d399', '#60a5fa'];

    function spawnSpark(x, y, spread) {
        var s = document.createElement('div');
        s.className = 'kai-spark';
        s.setAttribute('aria-hidden', 'true');
        s.style.left = x + 'px';
        s.style.top = y + 'px';
        s.style.background = 'radial-gradient(circle, ' +
            SPARK_COLORS[(Math.random() * SPARK_COLORS.length) | 0] + ', transparent 70%)';
        var a = Math.random() * Math.PI * 2;
        var d = (spread || 34) * (0.6 + Math.random() * 0.7);
        s.style.setProperty('--kai-sdx', (Math.cos(a) * d).toFixed(1) + 'px');
        s.style.setProperty('--kai-sdy', (Math.sin(a) * d - 12).toFixed(1) + 'px');
        s.style.setProperty('--kai-spark-d', (0.55 + Math.random() * 0.5).toFixed(2) + 's');
        document.body.appendChild(s);
        setTimeout(function () {
            if (s.parentNode) s.parentNode.removeChild(s);
        }, 1300);
    }

    function mountTrail() {
        if (isTouch) return;
        var last = 0;
        document.addEventListener('pointermove', function (e) {
            var now = Date.now();
            if (now - last < 90) return;
            last = now;
            spawnSpark(e.clientX, e.clientY, 26);
        }, { passive: true });
    }

    function mountBursts() {
        document.addEventListener('click', function (e) {
            var t = e.target && e.target.closest
                ? e.target.closest('a[class*="bg-gradient-to-r"], button[class*="bg-gradient-to-r"]')
                : null;
            if (!t) return;
            for (var i = 0; i < 9; i++) spawnSpark(e.clientX, e.clientY, 70);
        }, true);
    }

    /* ======================================================================
       5. Aurora sweep band (single fixed gradient, CSS-driven drift)
       ====================================================================== */
    function mountAuroraSweep() {
        var sweep = document.getElementById('kai-aurora-sweep');
        if (sweep) return;
        sweep = document.createElement('div');
        sweep.id = 'kai-aurora-sweep';
        sweep.setAttribute('aria-hidden', 'true');
        document.body.insertBefore(sweep, document.body.firstChild);
    }

    /* ======================================================================
       6. Shooting stars — periodic meteor streaks across the sky
       ====================================================================== */
    function spawnShootingStar() {
        var el = document.createElement('div');
        el.className = 'kai-shooting-star';
        el.setAttribute('aria-hidden', 'true');
        el.style.top = (6 + Math.random() * 34) + 'vh';
        el.style.left = (8 + Math.random() * 60) + 'vw';
        el.style.setProperty('--kai-shoot-x', (28 + Math.random() * 40) + 'vw');
        el.style.setProperty('--kai-shoot-y', (12 + Math.random() * 22) + 'vh');
        el.style.setProperty('--kai-shoot-d', (0.9 + Math.random() * 0.8).toFixed(2) + 's');
        document.body.appendChild(el);
        setTimeout(function () {
            if (el.parentNode) el.parentNode.removeChild(el);
        }, 2400);
    }

    function mountShootingStars() {
        var first = 1800 + Math.random() * 2600;
        setTimeout(function tick() {
            spawnShootingStar();
            setTimeout(tick, 7200 + Math.random() * 5200);
        }, first);
    }

    /* ======================================================================
       boot
       ====================================================================== */
    ready(function () {
        mountOrbs();
        mountAuroraSweep();
        mountParticles();
        mountCursor();
        mountTrail();
        mountBursts();
        mountShootingStars();
    });
})();
