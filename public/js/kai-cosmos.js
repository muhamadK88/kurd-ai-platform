/* ==========================================================================
   KURD AI — "Cosmos" v4 · whole-site background universe.
   Three.js particle constellation + aurora orbs + cursor glow + sparkle
   trail + click bursts. Pure additive layer — never touches page logic,
   classes or data. Degrades gracefully: reduced-motion / touch / low-end /
   no-WebGL all keep the page fully functional.
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
       2. Three.js particle constellation.
       Positions are static; the whole group rotates + parallaxes with the
       mouse, so the connection-line buffer is computed ONCE and never
       updates per frame (kept GPU-cheap).
       ====================================================================== */
    function mountParticles() {
        if (perf) return;
        if (typeof THREE === 'undefined') return;

        var box = getCosmos();
        var reduce = isTouch;
        var COUNT = reduce ? 90 : 240;
        var W = 250, H = 170, D = 80;
        var paletteHex = [0x2563eb, 0x06b6d4, 0x7c3aed, 0xec4899, 0xf59e0b, 0x38bdf8];
        var renderer, camera, group, points, dust, pMat;
        var mx = 0, my = 0;
        var running = false;

        try {
            renderer = new THREE.WebGLRenderer({ alpha: true, antialias: false });
        } catch (e) {
            return;
        }

        renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, reduce ? 1.2 : 1.75));
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setClearColor(0x000000, 0);
        box.appendChild(renderer.domElement);

        camera = new THREE.PerspectiveCamera(58, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.set(0, 0, 210);

        group = new THREE.Group();
        group.rotation.x = -0.18;
        group.rotation.y = -0.3;

        /* main constellation */
        var pos = new Float32Array(COUNT * 3);
        var col = new Float32Array(COUNT * 3);
        var c = new THREE.Color();
        for (var i = 0; i < COUNT; i++) {
            pos[i * 3]     = (Math.random() - 0.5) * W;
            pos[i * 3 + 1] = (Math.random() - 0.5) * H;
            pos[i * 3 + 2] = (Math.random() - 0.5) * D;
            c.setHex(paletteHex[i % paletteHex.length]);
            col[i * 3] = c.r; col[i * 3 + 1] = c.g; col[i * 3 + 2] = c.b;
        }

        var pGeo = new THREE.BufferGeometry();
        pGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
        pGeo.setAttribute('color', new THREE.BufferAttribute(col, 3));

        pMat = new THREE.PointsMaterial({
            size: reduce ? 2.0 : 2.4,
            vertexColors: true,
            transparent: true,
            opacity: 0.85,
            depthWrite: false,
            sizeAttenuation: true,
            blending: THREE.AdditiveBlending
        });
        points = new THREE.Points(pGeo, pMat);
        group.add(points);

        /* faint dust cloud, counter-rotates for living depth */
        var DUST = reduce ? 36 : 80;
        var dPos = new Float32Array(DUST * 3);
        for (var j = 0; j < DUST; j++) {
            dPos[j * 3]     = (Math.random() - 0.5) * (W * 1.3);
            dPos[j * 3 + 1] = (Math.random() - 0.5) * (H * 1.2);
            dPos[j * 3 + 2] = (Math.random() - 0.5) * (D * 1.2);
        }
        var dGeo = new THREE.BufferGeometry();
        dGeo.setAttribute('position', new THREE.BufferAttribute(dPos, 3));
        var dMat = new THREE.PointsMaterial({
            size: 1.0,
            color: 0x8ecbff,
            transparent: true,
            opacity: 0.28,
            depthWrite: false,
            sizeAttenuation: true,
            blending: THREE.AdditiveBlending
        });
        dust = new THREE.Points(dGeo, dMat);
        group.add(dust);

        /* constellation lines — precomputed once */
        var MAX_EDGES = reduce ? 60 : 170;
        var edges = [];
        var n = Math.min(COUNT, 120);
        var thr = W * 0.16;
        var thr2 = thr * thr;
        for (var a = 0; a < n && edges.length < MAX_EDGES; a++) {
            for (var b = a + 1; b < n; b++) {
                var dx = pos[a * 3] - pos[b * 3];
                var dy = pos[a * 3 + 1] - pos[b * 3 + 1];
                var dz = pos[a * 3 + 2] - pos[b * 3 + 2];
                if (dx * dx + dy * dy + dz * dz < thr2) {
                    edges.push(a, b);
                    if (edges.length >= MAX_EDGES) break;
                }
            }
        }

        if (edges.length) {
            var lPos = new Float32Array(edges.length * 3);
            for (var e = 0; e < edges.length; e += 2) {
                var ia = edges[e], ib = edges[e + 1];
                lPos[e * 3]         = pos[ia * 3];
                lPos[e * 3 + 1]     = pos[ia * 3 + 1];
                lPos[e * 3 + 2]     = pos[ia * 3 + 2];
                lPos[e * 3 + 3]     = pos[ib * 3];
                lPos[e * 3 + 4]     = pos[ib * 3 + 1];
                lPos[e * 3 + 5]     = pos[ib * 3 + 2];
            }
            var lGeo = new THREE.BufferGeometry();
            lGeo.setAttribute('position', new THREE.BufferAttribute(lPos, 3));
            var lMat = new THREE.LineBasicMaterial({
                color: 0x67d8ff,
                transparent: true,
                opacity: reduce ? 0.10 : 0.20,
                depthWrite: false
            });
            group.add(new THREE.LineSegments(lGeo, lMat));
        }

        var scene = new THREE.Scene();
        scene.add(group);

        if (!isTouch) {
            window.addEventListener('pointermove', function (e) {
                mx = e.clientX / window.innerWidth - 0.5;
                my = e.clientY / window.innerHeight - 0.5;
            }, { passive: true });
        }

        function resize() {
            var w = window.innerWidth, h = window.innerHeight;
            if (!w || !h) return;
            camera.aspect = w / h;
            camera.updateProjectionMatrix();
            renderer.setSize(w, h);
        }
        window.addEventListener('resize', resize);

        function frame() {
            if (!running) return;
            requestAnimationFrame(frame);
            var t = performance.now() * 0.0001;
            group.rotation.y += 0.00034;
            group.rotation.x = -0.18 + Math.sin(t * 0.4) * 0.05;
            points.rotation.z += 0.00014;
            dust.rotation.z -= 0.00022;
            pMat.opacity = 0.78 + Math.sin(t * 7) * 0.12;
            camera.position.x += (mx * 34 - camera.position.x) * 0.045;
            camera.position.y += (-my * 26 - camera.position.y) * 0.045;
            camera.lookAt(0, 0, 0);
            renderer.render(scene, camera);
        }

        function start() { if (!running) { running = true; frame(); } }
        function stop() { running = false; }

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
       boot
       ====================================================================== */
    ready(function () {
        mountOrbs();
        mountParticles();
        mountCursor();
        mountTrail();
        mountBursts();
    });
})();
