/* ==========================================================================
   KURD AI — kai-pyrunner.js · in-browser Python runner for فێرگە lessons.
   Powered by Pyodide (CPython → WebAssembly). The chat widget already lazy-
   loads Pyodide v0.23.4 as window.loadPyodide — we reuse that exact loader
   so both features share ONE ~10MB download and ONE interpreter instance.

   Public API:
     KaiPy.ensure()                  -> Promise<pyodide>   (singleton)
     KaiPy.run(code, hooks)          -> Promise<result>    (stdout/stderr/
                                                            done/error/figs)
     KaiPy.mount(container, code)    -> runner UI inside `container`
     KaiPy.highlight(code)           -> highlighted HTML (read-only blocks)
     KaiPy.enhance(root)             -> convert <pre data-run> in `root`
   ========================================================================== */
(function () {
    'use strict';

    var PYODIDE_VERSION = '0.23.4';
    var RUN_TIMEOUT_MS = 30000;

    /* Packages Pyodide ships natively — auto-installed when the user's code
       imports them (Kurdish variable names are fine: Python 3 identifiers
       are unicode, and so is our import scanner's fallback to raw exec). */
    var AUTO_PACKAGES = ['numpy', 'pandas', 'matplotlib', 'scipy', 'pillow', 'networkx', 'sympy'];

    /* ------------------------------------------------------------------
       1. interpreter singleton
       ------------------------------------------------------------------ */
    /* window.loadPyodide comes from three places depending on boot order:
         1) Pyodide's real factory (returns a Promise<instance>),
         2) the chat widget's wrapper (usually the same factory, sometimes
            shaped differently, occasionally a raw promise that resolves
            directly to the instance),
         3) nothing yet — then we load Pyodide ourselves.
       ensure() normalizes all of them down to a Promise<instance> and caches
       it so lessons + chat share ONE interpreter (~10MB, one WASM instance). */
    function ensure() {
        if (window.__kaiPyReady) return window.__kaiPyReady;

        window.__kaiPyReady = new Promise(function (resolve, reject) {
            function settle(v) {
                if (v && typeof v.then === 'function') return v.then(settle, reject);
                if (v && v.runPython && v.loadPackage) return resolve(v);
                resolve(v);
            }

            function boot() {
                try {
                    settle(window.loadPyodide({ indexURL: 'https://cdn.jsdelivr.net/pyodide/v' + PYODIDE_VERSION + '/full/' }));
                } catch (e) {
                    if (window.__kaiPyReadyCached) resolve(window.__kaiPyReadyCached);
                    else reject(e);
                }
            }

            if (typeof window.loadPyodide === 'function') {
                boot();
            } else if (window.loadPyodide && window.loadPyodide.runPython) {
                // the widget already resolved the interpreter — reuse it
                resolve(window.loadPyodide);
            } else {
                var s = document.createElement('script');
                s.src = 'https://cdn.jsdelivr.net/pyodide/v' + PYODIDE_VERSION + '/full/pyodide.js';
                s.onload = boot;
                s.onerror = function () { reject(new Error('pyodide-load-failed')); };
                document.head.appendChild(s);
            }
        });

        // remember the resolved interpreter in case a wrapper later throws
        window.__kaiPyReady.then(function (py) {
            window.__kaiPyReadyCached = py;
            return py;
        }, function () {});

        return window.__kaiPyReady;
    }

    /* ------------------------------------------------------------------
       2. execution
       ------------------------------------------------------------------ */

    /* Prologue: capture matplotlib figures instead of needing a display.
       plt.show() collects every open figure as a base64 PNG. */
    var PROLOGUE = [
        'import sys, io, base64, __main__',
        '_kai_figs = []',
        'try:',
        '    import matplotlib',
        '    matplotlib.use("Agg")',
        '    import matplotlib.pyplot as _kai_plt',
        '    def _kai_show(*a, **k):',
        '        for _n in _kai_plt.get_fignums():',
        '            _b = io.BytesIO()',
        '            _kai_plt.figure(_n).savefig(_b, format="png", dpi=110, bbox_inches="tight")',
        '            _kai_figs.append(base64.b64encode(_b.getvalue()).decode())',
        '        _kai_plt.close("all")',
        '    _kai_plt.show = _kai_show',
        'except Exception:',
        '    pass'
    ].join('\n');

    var EPILOGUE = '_kai_figs';

    function neededPackages(code) {
        var found = [];
        for (var i = 0; i < AUTO_PACKAGES.length; i++) {
            var pkg = AUTO_PACKAGES[i];
            var alias = pkg === 'pillow' ? 'PIL' : pkg;
            var re = new RegExp('^\\s*(import\\s+' + alias + '\\b|from\\s+' + alias + '\\b)', 'm');
            if (re.test(code)) found.push(pkg);
        }
        return found;
    }

    /**
     * run(code, hooks) — hooks: { stdout, stderr, done, error, figs }
     * Returns a promise resolving to { ok, error, figs }.
     */
    function run(code, hooks) {
        hooks = hooks || {};
        var out = '', err = '';

        var job = ensure().then(function (pyodide) {
            var pkgs = neededPackages(code);
            var load = pkgs.length ? pyodide.loadPackage(pkgs) : Promise.resolve();
            return load.then(function () {
                pyodide.setStdout({ batched: function (s) {
                    out += s + '\n';
                    if (hooks.stdout) hooks.stdout(s + '\n');
                }});
                pyodide.setStderr({ batched: function (s) {
                    err += s + '\n';
                    if (hooks.stderr) hooks.stderr(s + '\n');
                }});

                return pyodide.runPythonAsync(PROLOGUE + '\n' + code + '\n' + EPILOGUE)
                    .then(function (figs) {
                        var images = [];
                        if (figs && figs.toJs) {
                            try { images = Array.from(figs.toJs()); } catch (e) {}
                        } else if (Array.isArray(figs)) {
                            images = figs;
                        }
                        if (hooks.done) hooks.done(out);
                        if (hooks.figs && images.length) hooks.figs(images);
                        return { ok: true, error: null, figs: images };
                    });
            });
        });

        /* timeout guard — Pyodide cannot be hard-killed, but we stop
           WAITING so the UI recovers and says what happened. */
        var timeout = new Promise(function (_, reject) {
            setTimeout(function () {
                reject(new Error('⏱ کاتەکە تەواو بوو (30 چرکە) — کۆدەکە زۆر درێژە'));
            }, RUN_TIMEOUT_MS);
        });

        return Promise.race([job, timeout]).catch(function (e) {
            var msg = (e && e.message) ? String(e.message) : String(e);
            if (hooks.error) hooks.error(msg, err);
            return { ok: false, error: msg, figs: [] };
        });
    }

    /* ------------------------------------------------------------------
       3. runner UI
       ------------------------------------------------------------------ */
    function esc(s) {
        return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    function mount(container, code) {
        if (!container || container.dataset.kaiRunner) return;
        container.dataset.kaiRunner = '1';
        container.classList.add('kai-runner');

        container.innerHTML =
            '<div class="kai-runner__bar">' +
                '<button type="button" class="kai-runner__run">▶ <span class="lang-str" data-so="بیکاری بکەوە" data-ba="بکارخە">بیکاری بکەوە</span></button>' +
                '<button type="button" class="kai-runner__reset">↺ <span class="lang-str" data-so="گەڕانەوە" data-ba="ڤەگەڕە">گەڕانەوە</span></button>' +
                '<span class="kai-runner__lang">Python 3 · Pyodide</span>' +
            '</div>' +
            '<textarea class="kai-runner__code" spellcheck="false" dir="ltr"></textarea>' +
            '<pre class="kai-runner__out" dir="ltr" hidden></pre>' +
            '<div class="kai-runner__figs"></div>';

        var ta = container.querySelector('.kai-runner__code');
        var out = container.querySelector('.kai-runner__out');
        var figs = container.querySelector('.kai-runner__figs');
        var btn = container.querySelector('.kai-runner__run');
        var initial = code || '';

        ta.value = initial;

        /* tab inserts indentation instead of leaving the editor */
        ta.addEventListener('keydown', function (e) {
            if (e.key === 'Tab') {
                e.preventDefault();
                var s = ta.selectionStart, epos = ta.selectionEnd;
                ta.value = ta.value.slice(0, s) + '    ' + ta.value.slice(epos);
                ta.selectionStart = ta.selectionEnd = s + 4;
            }
        });
        /* auto-grow */
        ta.addEventListener('input', function () {
            ta.style.height = 'auto';
            ta.style.height = Math.min(ta.scrollHeight, 520) + 'px';
        });
        requestAnimationFrame(function () {
            ta.style.height = 'auto';
            ta.style.height = Math.min(ta.scrollHeight, 520) + 'px';
        });

        container.querySelector('.kai-runner__reset').addEventListener('click', function () {
            ta.value = initial;
            ta.dispatchEvent(new Event('input'));
            out.hidden = true; out.textContent = '';
            figs.innerHTML = '';
        });

        btn.addEventListener('click', function () {
            btn.disabled = true;
            btn.classList.add('is-busy');
            out.hidden = false;
            out.textContent = '…';
            out.classList.remove('is-err');
            figs.innerHTML = '';

            run(ta.value, {
                stdout: function (s) {
                    if (out.textContent === '…') out.textContent = '';
                    out.textContent += s;
                },
                error: function (msg) {
                    out.hidden = false;
                    out.classList.add('is-err');
                    out.textContent = msg;
                },
                figs: function (images) {
                    images.forEach(function (b64) {
                        var img = document.createElement('img');
                        img.src = 'data:image/png;base64,' + b64;
                        img.alt = 'figure';
                        figs.appendChild(img);
                    });
                }
            }).then(function () {
                if (out.textContent === '…') out.textContent = out.classList.contains('is-err') ? out.textContent : '';
                btn.disabled = false;
                btn.classList.remove('is-busy');
            });
        });
    }

    /* ------------------------------------------------------------------
       4. read-only code display with a tiny Python highlighter
       ------------------------------------------------------------------ */
    var KEYWORDS = ['False','None','True','and','as','assert','async','await','break','class','continue',
        'def','del','elif','else','except','finally','for','from','global','if','import','in','is',
        'lambda','nonlocal','not','or','pass','raise','return','try','while','with','yield'];
    var BUILTINS = ['print','len','range','int','float','str','list','dict','set','tuple','sum','min',
        'max','abs','round','sorted','enumerate','zip','map','filter','input','type','open','isinstance'];

    function highlight(code) {
        var src = String(code);
        var html = '';
        var re = /(#[^\n]*)|("""[\s\S]*?"""|'''[\s\S]*?'''|"(?:\\.|[^"\\\n])*"|'(?:\\.|[^'\\\n])*')|\b(\d+\.?\d*)\b|\b([A-Za-z_]\w*)\b/g;
        var m, last = 0;

        while ((m = re.exec(src)) !== null) {
            html += esc(src.slice(last, m.index));
            if (m[1]) html += '<span class="c">' + esc(m[1]) + '</span>';
            else if (m[2]) html += '<span class="s">' + esc(m[2]) + '</span>';
            else if (m[3]) html += '<span class="n">' + esc(m[3]) + '</span>';
            else if (m[4]) {
                var w = m[4];
                if (KEYWORDS.indexOf(w) !== -1) html += '<span class="k">' + esc(w) + '</span>';
                else if (BUILTINS.indexOf(w) !== -1) html += '<span class="b">' + esc(w) + '</span>';
                else html += esc(w);
            }
            last = re.lastIndex;
        }
        html += esc(src.slice(last));
        return html;
    }

    /* Convert every <pre data-kai-code> (and pre[data-run]) inside `root`:
       runnable ones become live editors, the rest become highlighted
       read-only blocks. Lesson content is server-rendered admin HTML. */
    function enhance(root) {
        (root || document).querySelectorAll('pre[data-kai-code], pre[data-run], pre[data-lang]').forEach(function (pre) {
            if (pre.dataset.kaiDone) return;
            pre.dataset.kaiDone = '1';

            var code = pre.textContent;
            var runnable = pre.hasAttribute('data-run') && pre.getAttribute('data-run') !== '0';

            if (runnable) {
                var box = document.createElement('div');
                box.className = 'kai-runner-slot';
                pre.parentNode.replaceChild(box, pre);
                mount(box, code);
            } else {
                pre.classList.add('kai-code');
                pre.innerHTML = highlight(code);
            }
        });
    }

    window.KaiPy = { ensure: ensure, run: run, mount: mount, highlight: highlight, enhance: enhance };
})();