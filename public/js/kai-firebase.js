/* ==========================================================================
   KURD AI — kai-firebase (shared guarded Firebase bootstrap)
   --------------------------------------------------------------------------
   Loaded once per page (data-kai-shared, deferred, in the <head>).

   Why this file exists:
     • Every page used to import firebase-app/auth/database and call
       getAuth() at module top-level. When the config is missing or has a
       stale apiKey (e.g. a server-side config file that drifted), that
       call THROWS auth/invalid-api-key and the whole page module dies.
     • This module VALIDATES the config before touching Firebase. A bad
       or missing key never throws: KaiFirebase.auth() is simply null and
       every callback resolves with no user — pages degrade gracefully.
     • It is a single shared singleton across pages AND SPA swaps, so the
       SDK modules are imported once and reused everywhere.
     • It boots in the BACKGROUND (after load + idle, or first
       interaction), so first paint never waits for the ~120KB gzipped
       Firebase SDK.
   ========================================================================== */
(function () {
    'use strict';
    if (window.KaiFirebase) return;

    var S = { app: null, auth: null, db: null, user: null, ready: false, booted: false, configured: false };
    var cbs = [];
    var cfg = {};
    try {
        var el = document.getElementById('kurdai-firebase-config');
        cfg = JSON.parse((el && el.textContent) || '{}');
    } catch (e) { cfg = {}; }
    S.configured = !!(cfg && typeof cfg.apiKey === 'string' &&
        /^AIza[0-9A-Za-z_-]{30,}$/.test(cfg.apiKey) && cfg.projectId);

    function settle() {
        if (S.ready) return;
        S.ready = true;
        var email = S.user ? String(S.user.email || '').toLowerCase() : '';
        try {
            window.dispatchEvent(new CustomEvent('kurdai:identity', { detail: { email: email } }));
            window.dispatchEvent(new CustomEvent('kurdai:firebase-ready', { detail: { configured: S.configured, user: S.user } }));
        } catch (e) {}
        for (var i = 0; i < cbs.length; i++) { try { cbs[i](S.user); } catch (e) {} }
        cbs.length = 0;
    }

    function boot() {
        if (S.booted) return;
        S.booted = true;
        if (!S.configured) { settle(); return; }
        Promise.all([
            import('/js/firebase10/firebase-app.js'),
            import('/js/firebase10/firebase-auth.js'),
            import('/js/firebase10/firebase-database.js')
        ]).then(function (mods) {
            try {
                S.app = mods[0].getApps().length ? mods[0].getApp() : mods[0].initializeApp(cfg);
                S.auth = mods[1].getAuth(S.app);
                S.db = mods[2].getDatabase(S.app);
                S.auth.useDeviceLanguage();
                mods[1].onAuthStateChanged(S.auth, function (u) {
                    S.user = u;
                    settle();
                });
            } catch (e) { settle(); }
        }).catch(function () { settle(); });
    }

    window.KaiFirebase = {
        configured: function () { return S.configured; },
        app: function () { return S.app; },
        auth: function () { return S.auth; },
        db: function () { return S.db; },
        boot: boot,
        whenReady: function (cb) {
            if (typeof cb !== 'function') return;
            if (S.ready) { try { cb(S); } catch (e) {} return; }
            var w = function () { try { cb(S); } catch (e) {} };
            cbs.push(w);
            boot();
        },
        onAuthStateChanged: function (cb) {
            if (typeof cb !== 'function') return;
            if (S.ready) { try { cb(S.user); } catch (e) {} return; }
            cbs.push(cb);
            boot();
        },
        signOut: function () { return S.auth ? S.auth.signOut() : Promise.resolve(); }
    };

    var scheduled = false;
    function maybeBoot() {
        if (scheduled) return;
        scheduled = true;
        boot();
        window.removeEventListener('pointerdown', maybeBoot, true);
        window.removeEventListener('keydown', maybeBoot, true);
        window.removeEventListener('load', onLoad, true);
    }
    function onLoad() { setTimeout(maybeBoot, 1400); }
    if (document.readyState === 'complete') { setTimeout(maybeBoot, 1400); }
    else window.addEventListener('load', onLoad, { once: true });
    window.addEventListener('pointerdown', maybeBoot, { once: true, capture: true });
    window.addEventListener('keydown', maybeBoot, { once: true, capture: true });
})();