{{-- ==========================================================================
     KURD AI — AI Leaderboard (ڕێزبەندی مۆدێلەکان)
     Self-contained component. Mounted on /ai-tools under the hero header.

     Contract with the host page:
       • Reads data from  public/data/leaderboard.json  (fetched once, cached).
       • Language: reads `localStorage['site-lang']` ('so' | 'ba') on load and
         re-renders on the `kai:langchange` event OR when the host page calls
         window.kaiLeaderboard.setLang(lang). Static strings also carry
         .lang-str / data-so / data-ba so a host `applyLanguage()` sweep works.
       • Exposes nothing else globally except `window.kaiLeaderboard`.
     ========================================================================== --}}

<link rel="stylesheet" href="{{ asset('css/kai-leaderboard.css') }}?v=4">

<section id="kai-leaderboard" class="relative z-10 container mx-auto px-4 pb-16 max-w-6xl">
    <div class="lb-panel glass-card rounded-[2.5rem] shadow-2xl p-6 md:p-10">

        <div class="lb-edge"></div>
        <div class="lb-glow lb-glow-a"></div>
        <div class="lb-glow lb-glow-b"></div>
        <div class="lb-scan"></div>

        {{-- ---------- header ---------- --}}
        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-5 mb-8">
            <div class="text-center md:text-start">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-cyan-50 dark:bg-cyan-900/30 border border-cyan-200 dark:border-cyan-700/50 text-cyan-700 dark:text-cyan-300 font-bold text-xs mb-4 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span class="lang-str" data-so="نوێترین ڕێزبەندی" data-ba="نویترین ڕێزبەندی">نوێترین ڕێزبەندی</span>
                    <span class="lb-live" aria-hidden="true"></span>
                </div>

                <h2 class="lb-title text-3xl md:text-5xl font-black tracking-tight leading-tight mb-3 lang-str"
                    data-so="ڕێزبەندی سەرەکیی مۆدێلەکانی ئەی ئای"
                    data-ba="ڕێزبەندیا سەرەکی یا مۆدێلێن ئەی ئای">ڕێزبەندی سەرەکیی مۆدێلەکانی ئەی ئای</h2>

                <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 font-medium lang-str"
                   data-so="باشترین مۆدێلەکانی ژیریی دەستکرد بەپێی نمرە و کارایی"
                   data-ba="باشترین مۆدێلێن ژێرییا دەستکرد ل دووڤ نمرە و کاراییێ">باشترین مۆدێلەکانی ژیریی دەستکرد بەپێی نمرە و کارایی</p>

                {{-- explanatory source description --}}
                <div class="lb-desc mt-4 flex items-start gap-2.5 max-w-2xl md:mx-0 mx-auto rounded-2xl bg-white/50 dark:bg-gray-800/40 border border-gray-200/60 dark:border-gray-700/50 px-4 py-3">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-cyan-500 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs md:text-sm text-gray-500 dark:text-gray-400 font-medium leading-relaxed lang-str"
                       data-so="ئەمە ڕێزبەندیی فەرمیی کارایی مۆدێلەکانی ژیریی دەستکردە لەلایەن Agent Arena (LMSYS) کە بەپێی تاقیکردنەوەی ڕاستەوخۆ و دەنگدانی بەکارهێنەران (نمرەی ELO) بەردەوام نوێ دەکرێتەوە."
                       data-ba="ئەڤە ڕێزبەندیا فەرمی یا کارایییا مۆدێلێن ژێرییا دەستکردە ژ لایێ Agent Arena (LMSYS) ڤە، ئەوا ل دووڤ تاقیکرنا ڕاستەوخۆ و دەنگدانا بەکارهێنەران (نمرەیا ELO) بەردەوام دهێتە نووژەنکرن.">ئەمە ڕێزبەندیی فەرمیی کارایی مۆدێلەکانی ژیریی دەستکردە لەلایەن Agent Arena (LMSYS) کە بەپێی تاقیکردنەوەی ڕاستەوخۆ و دەنگدانی بەکارهێنەران (نمرەی ELO) بەردەوام نوێ دەکرێتەوە.</p>
                </div>
            </div>

            {{-- collapse / expand toggle --}}
            <button type="button" id="lb-toggle"
                    class="lb-toggle-btn self-center md:self-start flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200/60 dark:border-gray-700/60 text-gray-700 dark:text-gray-200 font-bold text-xs shadow-sm flex-shrink-0"
                    aria-expanded="true" aria-controls="lb-body">
                <span id="lb-toggle-label" class="lang-str" data-so="شاردنەوە" data-ba="ڤەشارتن">شاردنەوە</span>
                <svg class="lb-chevron w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
            </button>
        </div>

        {{-- ---------- collapsible body ---------- --}}
        <div id="lb-body" class="lb-body relative z-10">

            {{-- category tabs --}}
            <div id="lb-tabs" class="flex flex-wrap gap-2.5 justify-center mb-8" role="tablist"></div>

            {{-- column header (desktop only) --}}
            <div class="lb-head lb-grid px-5 pb-3 mb-2 border-b border-gray-200/60 dark:border-gray-700/60 text-[0.7rem] font-black tracking-wider uppercase text-gray-500 dark:text-gray-400">
                <div class="lang-str" data-so="پلە" data-ba="پلە">پلە</div>
                <div class="lang-str" data-so="مۆدێل" data-ba="مۆدێل">مۆدێل</div>
                <div class="lang-str" data-so="نمرە" data-ba="نمرە">نمرە</div>
                <div class="text-end lang-str" data-so="مۆڵەت" data-ba="مۆڵەت">مۆڵەت</div>
            </div>

            {{-- rows --}}
            <div id="lb-rows" class="space-y-2"></div>

            {{-- footer note --}}
            <p id="lb-updated" class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500 font-medium"></p>

            {{-- bottom action: link out to the live arena --}}
            <div class="mt-6 flex justify-center">
                <a href="https://lmarena.ai" target="_blank" rel="noopener noreferrer"
                   class="lb-cta group inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-cyan-500 via-purple-500 to-indigo-500 text-white font-bold text-sm md:text-base shadow-lg shadow-purple-500/30">
                    <span class="lang-str"
                          data-so="ئەگەر زانیاری و ڕێزبەندیی وردترت دەوێت، سەردانی Agent Arena بکە"
                          data-ba="ئەگەر تە زانیاری و ڕێزبەندیا وردتر دڤێت، سەرەدانا Agent Arena بکه">ئەگەر زانیاری و ڕێزبەندیی وردترت دەوێت، سەردانی Agent Arena بکە</span>
                    <svg class="lb-cta-icon w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
(function () {
    "use strict";

    var SRC = "{{ asset('data/leaderboard.json') }}?v=2";

    /* ---------- i18n ---------- */
    var T = {
        so: {
            cats:    {
                overall: "گشتی", coding: "کۆدکردن", image: "وێنە", video: "ڤیدیۆ",
                search: "گەڕان", reasoning: "بیرکردنەوە", "text-generation": "دروستکردنی دەق"
            },
            license: { proprietary: "تایبەت", open: "سەرچاوە کراوە" },
            hide: "شاردنەوە", show: "پیشاندان",
            loading: "خەریکی بارکردنە...",
            error: "نەتوانرا ڕێزبەندییەکە باربکرێت",
            empty: "هیچ زانیارییەک نییە",
            updated: "دوایین نوێکردنەوە"
        },
        ba: {
            cats:    {
                overall: "گشتی", coding: "کۆدکرن", image: "وێنە", video: "ڤیدیۆ",
                search: "گەڕیان", reasoning: "هزرکرن", "text-generation": "دروستکرنا دەقی"
            },
            license: { proprietary: "تایبەت", open: "سەرچاوە ڤەکری" },
            hide: "ڤەشارتن", show: "نیشاندان",
            loading: "ل بارکرنێ دا یە...",
            error: "نەشیا ڕێزبەندی بهێتە بارکرن",
            empty: "چ زانیاری نینن",
            updated: "دوماهی نویکرن"
        }
    };

    var CATS = [
        { key: "overall",         icon: "🏆" },
        { key: "coding",          icon: "💻" },
        { key: "image",           icon: "🎨" },
        { key: "video",           icon: "🎬" },
        { key: "search",          icon: "🔍" },
        { key: "reasoning",       icon: "🧠" },
        { key: "text-generation", icon: "✍️" }
    ];

    var CAT_GRAD = {
        overall:          "from-purple-600 to-indigo-600",
        coding:           "from-emerald-500 to-cyan-500",
        image:            "from-pink-500 to-rose-500",
        video:            "from-orange-500 to-amber-500",
        search:           "from-sky-500 to-blue-600",
        reasoning:        "from-violet-500 to-fuchsia-500",
        "text-generation": "from-teal-500 to-emerald-500"
    };

    var state = {
        lang: (localStorage.getItem("site-lang") === "ba") ? "ba" : "so",
        cat: "overall",
        data: null,
        error: false
    };

    var elRoot    = document.getElementById("kai-leaderboard");
    var elTabs    = document.getElementById("lb-tabs");
    var elRows    = document.getElementById("lb-rows");
    var elUpdated = document.getElementById("lb-updated");
    var elToggle  = document.getElementById("lb-toggle");
    var elToggleL = document.getElementById("lb-toggle-label");
    var elBody    = document.getElementById("lb-body");

    if (!elRoot) return;

    function t() { return T[state.lang] || T.so; }

    function esc(s) {
        return String(s == null ? "" : s)
            .replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;").replace(/'/g, "&#39;");
    }

    /* Arabic-Indic digits so numbers match the rest of the Kurdish UI */
    var AR_DIGITS = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
    function toArabicDigits(n) {
        return String(n).replace(/[0-9]/g, function (d) { return AR_DIGITS[+d]; });
    }

    /* open vs proprietary. The data now carries the arena's verbatim license
       string plus a Kurdish `license_type` label; prefer that, then fall back
       to classifying the raw string (and the legacy "open"/"proprietary"). */
    function isOpenLicense(r) {
        var lt = String(r.license_type || "").trim();
        if (lt) return lt === T.so.license.open || lt === T.ba.license.open;
        var s = String(r.license || "").trim().toLowerCase();
        if (!s || s === "proprietary") return false;
        if (s === "open") return true;
        return !/proprietary|closed|commercial/.test(s);
    }

    /* ---------- static strings ---------- */
    function applyStatic() {
        elRoot.querySelectorAll(".lang-str").forEach(function (el) {
            var v = el.getAttribute("data-" + state.lang) || el.getAttribute("data-so");
            if (v) el.innerText = v;
        });
        // the toggle label is state-dependent, so it wins over the data-attr sweep
        elToggleL.innerText = elRoot.classList.contains("lb-collapsed") ? t().show : t().hide;
    }

    /* ---------- tabs ---------- */
    function renderTabs() {
        var html = "";
        CATS.forEach(function (c) {
            var active = state.cat === c.key;
            var cls = active
                ? "lb-tab active bg-gradient-to-r " + CAT_GRAD[c.key] + " text-white border border-transparent"
                : "lb-tab bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-gray-700 dark:text-gray-300 border border-gray-200/60 dark:border-gray-700/60 hover:bg-purple-50 dark:hover:bg-gray-700/60";
            html +=
                '<button type="button" role="tab" aria-selected="' + active + '" data-cat="' + c.key + '" ' +
                'class="' + cls + ' flex items-center gap-2 px-5 py-3 rounded-2xl font-bold text-sm">' +
                    '<span class="lb-tab-icon text-base">' + c.icon + '</span>' +
                    '<span>' + esc(t().cats[c.key]) + '</span>' +
                '</button>';
        });
        elTabs.innerHTML = html;
    }

    /* ---------- rows ---------- */
    function stateBlock(inner) {
        return '<div class="py-14 flex flex-col items-center justify-center gap-4 text-gray-500 dark:text-gray-400 font-bold">' + inner + '</div>';
    }

    function renderRows() {
        if (state.error) {
            elRows.innerHTML = stateBlock(
                '<svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>' +
                '<span>' + esc(t().error) + '</span>'
            );
            elUpdated.innerText = "";
            return;
        }

        if (!state.data) {
            elRows.innerHTML = stateBlock('<div class="lb-spinner"></div><span>' + esc(t().loading) + '</span>');
            return;
        }

        var list = (state.data.categories && state.data.categories[state.cat]) || [];
        if (!list.length) {
            elRows.innerHTML = stateBlock('<span>' + esc(t().empty) + '</span>');
            return;
        }

        // bars are scaled against the top score of the *visible* category
        var top = list.reduce(function (m, r) { return Math.max(m, Number(r.score) || 0); }, 0) || 1;

        var medal = { 1: "lb-rank-1", 2: "lb-rank-2", 3: "lb-rank-3" };
        var barTone = { 1: "lb-gold", 2: "lb-silver", 3: "lb-bronze" };

        var html = "";
        list.forEach(function (r, i) {
            var rank = Number(r.rank) || (i + 1);
            var score = Number(r.score) || 0;
            var pct = Math.max(6, Math.round((score / top) * 100));
            var isOpen = isOpenLicense(r);

            var badgeCls = medal[rank]
                ? medal[rank] + " shadow-lg"
                : "bg-gray-100 dark:bg-gray-700/70 text-gray-600 dark:text-gray-300 border border-gray-200/70 dark:border-gray-600/60";

            var licCls = isOpen
                ? "bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-700/50"
                : "bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 border-indigo-200 dark:border-indigo-700/50";

            html +=
            '<div class="lb-row lb-grid px-4 md:px-5 py-3.5 rounded-2xl bg-white/50 dark:bg-gray-800/40 border border-gray-200/50 dark:border-gray-700/50" style="animation-delay:' + (i * 0.05) + 's">' +

                '<div class="lb-col-rank">' +
                    '<div class="lb-rank ' + badgeCls + ' w-11 h-11 rounded-2xl flex items-center justify-center font-black text-base">' +
                        (rank === 1 ? '<span class="lb-crown">👑</span>' : toArabicDigits(rank)) +
                    '</div>' +
                '</div>' +

                '<div class="lb-col-model min-w-0">' +
                    '<div class="lb-model font-black text-base md:text-lg text-gray-900 dark:text-white truncate" dir="ltr" style="text-align:start">' + esc(r.model) + '</div>' +
                    '<div class="text-xs text-gray-500 dark:text-gray-400 font-bold truncate" dir="ltr" style="text-align:start">' + esc(r.provider) + '</div>' +
                '</div>' +

                '<div class="lb-col-score flex items-center gap-3">' +
                    '<div class="lb-bar-track h-2.5 flex-1 rounded-full">' +
                        '<div class="lb-bar-fill ' + (barTone[rank] || "") + '" data-pct="' + pct + '"></div>' +
                    '</div>' +
                    '<span class="font-black text-sm text-gray-800 dark:text-gray-100 tabular-nums flex-shrink-0" dir="ltr">' + esc(score) + '</span>' +
                '</div>' +

                '<div class="lb-col-lic flex md:justify-end">' +
                    '<span class="lb-tag px-3 py-1.5 rounded-full text-[0.7rem] font-black border ' + licCls + '" title="' + esc(r.license || "") + '">' +
                        esc(t().license[isOpen ? "open" : "proprietary"]) +
                    '</span>' +
                '</div>' +
            '</div>';
        });

        elRows.innerHTML = html;

        // animate the bars from 0 → target on the next frame
        requestAnimationFrame(function () {
            elRows.querySelectorAll(".lb-bar-fill").forEach(function (b) {
                b.style.width = b.getAttribute("data-pct") + "%";
            });
        });

        elUpdated.innerText = state.data.updated ? t().updated + " · " + state.data.updated : "";
    }

    function render() {
        applyStatic();
        renderTabs();
        renderRows();
    }

    /* ---------- collapse ----------
       While open the body is max-height:none, so re-rendering rows (category
       switch, language switch, data arriving) can never clip it. The pixel
       height is only pinned for the duration of the toggle animation. */
    function collapse() {
        elBody.style.maxHeight = elBody.scrollHeight + "px";
        void elBody.offsetHeight;                 // flush, so the transition has a start value
        elRoot.classList.add("lb-collapsed");     // CSS drives max-height to 0
    }

    function expand() {
        elRoot.classList.remove("lb-collapsed");
        elBody.style.maxHeight = elBody.scrollHeight + "px";
        var done = function (e) {
            if (e && e.propertyName !== "max-height") return;
            elBody.style.maxHeight = "none";
            elBody.removeEventListener("transitionend", done);
        };
        elBody.addEventListener("transitionend", done);
        setTimeout(done, 700);                    // fallback if transitionend never fires
    }

    elToggle.addEventListener("click", function () {
        var isCollapsed = elRoot.classList.contains("lb-collapsed");
        if (isCollapsed) expand(); else collapse();
        elToggle.setAttribute("aria-expanded", String(isCollapsed));
        elToggleL.innerText = isCollapsed ? t().hide : t().show;
    });

    elTabs.addEventListener("click", function (e) {
        var btn = e.target.closest("[data-cat]");
        if (!btn) return;
        var cat = btn.getAttribute("data-cat");
        if (cat === state.cat) return;
        state.cat = cat;
        renderTabs();
        renderRows();
    });

    /* ---------- language wiring ---------- */
    function setLang(lang) {
        var next = (lang === "ba") ? "ba" : "so";
        if (next === state.lang) return;
        state.lang = next;
        render();
    }

    window.kaiLeaderboard = { setLang: setLang, refresh: render };
    window.addEventListener("kai:langchange", function (e) {
        setLang((e.detail && e.detail.lang) || localStorage.getItem("site-lang"));
    });
    // catches a language toggle done in another tab
    window.addEventListener("storage", function (e) {
        if (e.key === "site-lang") setLang(e.newValue);
    });

    /* ---------- visibility gate ----------
       The host page keeps <body> display:none until Firebase auth resolves,
       so entrance animations must not start until the section is really on
       screen. Add .lb-in when it first becomes visible; fall back to a plain
       add() where IntersectionObserver is unavailable. */
    function markVisible() {
        if (elRoot.classList.contains("lb-in")) return;
        elRoot.classList.add("lb-in");
    }
    if (typeof IntersectionObserver === "function") {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { markVisible(); io.disconnect(); }
            });
        }, { threshold: 0.08 });
        io.observe(elRoot);
        // <body> starts hidden; once it flips to visible, re-check in case the
        // observer already fired a "not intersecting" while hidden.
        var bodyWatch = setInterval(function () {
            if (document.body && document.body.style.display !== "none") {
                clearInterval(bodyWatch);
                if (elRoot.getBoundingClientRect().top < window.innerHeight) markVisible();
            }
        }, 120);
        setTimeout(function () { clearInterval(bodyWatch); markVisible(); }, 4000);
    } else {
        markVisible();
    }

    /* ---------- boot ---------- */
    render();

    fetch(SRC, { cache: "no-cache" })
        .then(function (res) {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(function (json) {
            state.data = json;
            state.error = false;
            renderRows();
        })
        .catch(function () {
            state.error = true;
            renderRows();
        });
})();
</script>
