
@php
    $fbCatLabels = ['feedback' => 'ڕەخنە', 'suggestion' => 'پێشنیار', 'request' => 'داواکاری', 'other' => 'ئەوانی تر'];
    $fbCatColors = ['feedback' => 'rose', 'suggestion' => 'amber', 'request' => 'blue', 'other' => 'purple'];
    $fbCatIcons = ['feedback' => '💬', 'suggestion' => '💡', 'request' => '🎯', 'other' => '✨'];
@endphp

<style>
    /* ===== Feedback section (بۆچوون و پێشنیار) ===== */
    @keyframes kaiFlow { to { background-position: 220% center; } }
    @keyframes kaiHeadIn { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
    .kai-fb-title {
        background-image: linear-gradient(90deg, #2563eb, #0d9488 55%, #d97706 85%, #2563eb);
        background-size: 220% auto;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        -webkit-text-fill-color: transparent;
        animation: kaiFlow 8s linear infinite, kaiHeadIn 0.9s 0.2s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .kai-fb-frame {
        position: relative;
        border-radius: 2rem;
        padding: 2px;
        background: linear-gradient(100deg, #2563eb, #14b8a6 30%, #d97706 55%, #b026ff 80%, #2563eb);
        background-size: 300% auto;
        animation: kaiFlow 9s linear infinite;
        box-shadow: 0 20px 50px -20px rgba(37, 99, 235, 0.45);
    }
    .kai-fb-frame-inner {
        position: relative;
        border-radius: calc(2rem - 2px);
        background: rgba(255, 255, 255, 0.88);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
    }
    .dark .kai-fb-frame-inner {
        background: rgba(13, 20, 36, 0.9);
    }
    .fb-cat-chip { transition: all 0.2s ease; cursor: pointer; }
    .fb-cat-chip:hover { transform: translateY(-2px); box-shadow: 0 6px 16px -8px rgba(37, 99, 235, 0.5); }
    .fb-cat-chip:active { transform: scale(0.96); }
    /* ===== Tabs (مێمبەر / ئەدمین) ===== */
    .fb-tab {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 10px 24px; border-radius: 14px;
        font-size: 13px; font-weight: 900; white-space: nowrap;
        color: #6b7280; background: transparent; border: 1px solid transparent;
        cursor: pointer; transition: all 0.25s ease;
    }
    .dark .fb-tab { color: #9ca3af; }
    .fb-tab:hover { color: #2563eb; transform: translateY(-1px); }
    .dark .fb-tab:hover { color: #22d3ee; }
    .fb-tab-active, .fb-tab-active:hover {
        color: #fff !important; transform: none;
        background: linear-gradient(135deg, #2563eb, #0d9488);
        box-shadow: 0 10px 24px -10px rgba(37, 99, 235, 0.55);
    }
    .fb-check { animation: fbPop 0.45s cubic-bezier(0.22, 1, 0.36, 1) both; }
    .fb-check svg circle {
        stroke: #10b981;
        stroke-width: 3;
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        animation: fbStroke 0.6s 0.1s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .fb-check svg path {
        stroke: #10b981;
        stroke-width: 3.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: fbStroke 0.35s 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    @keyframes fbStroke { to { stroke-dashoffset: 0; } }
    @keyframes fbPop { from { opacity: 0; transform: scale(0.6); } to { opacity: 1; transform: scale(1); } }
    #fb-success { transition: opacity 0.3s ease; }
    .fb-my-item { animation: kaiHeadIn 0.4s ease both; }
    .fb-admin-item { animation: kaiHeadIn 0.35s ease both; }
    #fb-toast {
        position: fixed; bottom: 120px; right: 24px; z-index: 9998;
        display: none; align-items: center; gap: 8px;
        background: rgba(12, 12, 18, 0.96); border: 1px solid #10b981;
        color: #6ee7b7; border-radius: 14px; padding: 12px 18px;
        font-size: 13px; font-weight: 800; box-shadow: 0 0 20px rgba(16, 185, 129, 0.35);
        animation: fbToastIn 0.3s ease both;
    }
    @keyframes fbToastIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: none; } }

    /* ==========================================================================
       v2 · TERMINAL SPLIT-SCREEN — holo field, terminal topbar, log readouts.
       Additive, guard-based.
       ========================================================================== */
    .kai-holo-grid {
        pointer-events: none;
        background-image:
            linear-gradient(to right, rgba(37, 99, 235, 0.07) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(37, 99, 235, 0.07) 1px, transparent 1px);
        background-size: 28px 28px;
    }
    .dark .kai-holo-grid { opacity: 0.6; }
    .kai-scanlines {
        pointer-events: none;
        background: repeating-linear-gradient(to bottom, rgba(255, 255, 255, 0.05) 0 1px, transparent 1px 3px);
        mix-blend-mode: overlay;
        opacity: 0.55;
        z-index: 1;
    }
    .dark .kai-scanlines {
        background: repeating-linear-gradient(to bottom, rgba(0, 0, 0, 0.14) 0 1px, transparent 1px 3px);
    }
    .kai-fb-vignette {
        pointer-events: none;
        background: radial-gradient(ellipse at center, transparent 55%, rgba(10, 15, 29, 0.5) 100%);
        opacity: 0.35;
    }
    .dark .kai-fb-vignette { opacity: 0.5; }

    .kai-term-bar {
        font-family: ui-monospace, "Cascadia Mono", "Segoe UI Mono", Consolas, monospace;
        box-shadow: 0 14px 34px -18px rgba(37, 99, 235, 0.4);
    }
    .kai-dot {
        width: 10px; height: 10px; border-radius: 50%;
        box-shadow: 0 0 8px currentColor;
    }
    .kai-term-title { letter-spacing: 0.08em; }
    .kai-eq { display: inline-flex; align-items: flex-end; gap: 3px; height: 14px; }
    .kai-eq i {
        width: 3px; border-radius: 2px;
        background: linear-gradient(to top, #2563eb, #14b8a6);
        transform-origin: bottom;
        animation: kaiEq 1s ease-in-out infinite;
    }
    .kai-eq i:nth-child(1) { height: 5px; animation-delay: 0s; }
    .kai-eq i:nth-child(2) { height: 10px; animation-delay: 0.15s; }
    .kai-eq i:nth-child(3) { height: 7px; animation-delay: 0.3s; }
    .kai-eq i:nth-child(4) { height: 13px; animation-delay: 0.45s; }
    @keyframes kaiEq { 0%, 100% { transform: scaleY(0.5); } 50% { transform: scaleY(1); } }
    .kai-blink { animation: kaiBlink 1.1s steps(1, end) infinite; }
    @keyframes kaiBlink { 50% { opacity: 0; } }
    .kai-term-mono {
        font-family: ui-monospace, "Cascadia Mono", "Segoe UI Mono", Consolas, monospace;
    }

    /* ---------- log readouts ---------- */
    .fb-my-item, .fb-admin-item { box-shadow: inset 3px 0 0 rgba(16, 185, 129, 0.35); }
    .fb-my-item p[dir="ltr"], .fb-admin-item p[dir="ltr"] {
        font-family: ui-monospace, "Cascadia Mono", "Segoe UI Mono", Consolas, monospace;
        letter-spacing: 0.04em;
    }

    /* ---------- v2 fallbacks ---------- */
    html.kai-perf .kai-eq i,
    html.kai-perf .kai-blink,
    html.kai-perf .kai-holo-grid,
    html.kai-perf .kai-scanlines,
    html.kai-perf .kai-fb-vignette { animation: none !important; }
    @media (prefers-reduced-motion: reduce) {
        .kai-holo-grid, .kai-scanlines, .kai-fb-vignette,
        .kai-eq i, .kai-blink { animation: none !important; }
    }
</style>

<section id="feedback-section" class="relative overflow-hidden py-16 md:py-24" style="scroll-margin-top: 96px;">
        <div class="absolute inset-0 pointer-events-none z-0">
            <div class="kai-holo-grid absolute inset-0"></div>
            <div class="kai-scanlines absolute inset-0"></div>
            <div class="kai-fb-vignette absolute inset-0"></div>
            <div class="absolute top-10 -left-20 w-80 h-80 bg-blue-500 dark:bg-blue-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-15 animate-blob"></div>
        <div class="absolute -top-10 right-0 w-72 h-72 bg-amber-500 dark:bg-amber-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-15 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/3 w-80 h-80 bg-teal-500 dark:bg-teal-700 rounded-full mix-blend-multiply dark:mix-blend-lighten filter blur-3xl opacity-15 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 container mx-auto px-4 max-w-6xl">

        <!-- سەردێڕ -->
        <div class="text-center mb-14">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/60 dark:bg-gray-900/50 border border-blue-200/60 dark:border-blue-800/50 text-blue-700 dark:text-blue-300 font-extrabold text-sm mb-5 shadow-sm backdrop-blur">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-500"></span>
                </span>
                <span class="lang-str" data-so="ڕەخنە و پێشنیار " data-ba="ڕەخنە و پێشنیار ">ڕەخنە و پێشنیار </span>
            </div>
            <h3 class="kai-fb-title text-3xl md:text-5xl font-black mb-5 lang-str" data-so="لەهەبوونی هەر کێشە و ڕەخنەو پێشنیارێک ڕاستەوخۆ پەیوەندی بە ئەدمین بکەن ✨" data-ba=" ل هەبوونا هەر موشکیلە و ڕەخنە و گازنە و پێشنیارەک پەیوەندی بە ئەدمین بکەن✨">ڕاو بۆچوون  ✨</h3>
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 font-medium max-w-2xl mx-auto leading-relaxed lang-str" data-so="ڕەخنەت، پێشنیارەکەت یان داواکارییەکەت بنووسە؛ بە شێوەیەکی ڕاستەوخۆ دەگاتە دەست ئەدمین" data-ba="ڕەخنەیا خۆ، پێشنیار یان داواکرنا خۆ بنڤێسە؛ ب شێوەیەکێ راستەوخۆ دگەهیتە دەستێ ئەدمین">ڕەخنەت، پێشنیارەکەت یان داواکارییەکەت بنووسە؛ بە شێوەیەکی ڕاستەوخۆ دەگاتە دەست ئەدمین</p>
            <div class="kai-term-mono mt-5 inline-flex items-center gap-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-white/60 dark:bg-[#0d1424]/60 backdrop-blur px-4 py-2 text-[11px] md:text-xs font-bold text-gray-500 dark:text-gray-400" dir="ltr">
                <span class="text-emerald-500">$</span>
                <span>./feedback.log</span>
                <span class="text-gray-300 dark:text-gray-600">—</span>
                <span class="text-emerald-500">● CONNECTED</span>
                <span class="kai-blink text-emerald-500">▌</span>
            </div>
        </div>

        <!-- ===== پەڕەی مێمبەر (دەردەکەوێت کاتێک لۆگینیت) ===== -->
        <div id="fb-member-ui">

            <!-- ===== بەشی مێمبەر (تەنها فۆرم و پەیامەکانی خۆی — بێ هیچ تابی ئەدمین) ===== -->
            <div id="fb-panel-member">

            <!-- terminal topbar -->
            <div class="kai-term-bar flex items-center justify-between gap-3 px-5 py-3 mb-6 rounded-2xl bg-white/70 dark:bg-[#0d1424]/70 border border-gray-200 dark:border-gray-700 backdrop-blur">
                <div class="flex items-center gap-2.5">
                    <span class="kai-dot bg-rose-500"></span>
                    <span class="kai-dot bg-amber-400"></span>
                    <span class="kai-dot bg-emerald-500"></span>
                    <span class="kai-term-title text-xs font-bold text-gray-500 dark:text-gray-400 hidden sm:inline">kurd-ai@feedback: ~/transmit</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="kai-eq" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
                    <span class="kai-blink text-[10px] font-bold text-emerald-500">● REC</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                <!-- پەڕەی ناردنی بۆچوون -->
                <div class="lg:col-span-3">
                    <div class="kai-fb-frame">
                        <div class="kai-fb-frame-inner p-6 md:p-9 relative overflow-hidden">
                            <div class="flex items-center gap-3 mb-7">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-teal-400 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-2xl font-black text-gray-900 dark:text-white lang-str" data-so="بۆچوونەکەت بنێرە" data-ba="بۆچوونا خۆ بنێرە">بۆچوونەکەت بنێرە</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium lang-str" data-so="سوپاس بۆ بیرۆکەکانت" data-ba="سوپاس بۆ بیرۆکێن تە">سوپاس بۆ بیرۆکەکانت</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mb-7 -mt-3 kai-term-mono text-[11px] font-bold text-gray-400 dark:text-gray-500" dir="ltr">
                                <span class="text-teal-500">#</span>
                                <span>transmit.form — category: </span>
                                <span id="fb-cat-readout" class="text-blue-500 dark:text-teal-400">feedback</span>
                            </div>

                            <form id="fb-form" autocomplete="off">
                                <!-- جۆری پەیام -->
                                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mb-2.5 lang-str" data-so="چ جۆرە پەیامێکە؟" data-ba="ئەڤ پەیامە چ جۆرەیە؟">چ جۆرە پەیامێکە؟</p>
                                <div class="flex flex-wrap gap-2.5 mb-6">
                                    @foreach ($fbCatLabels as $catKey => $catLabel)
                                    <button type="button" data-cat="{{ $catKey }}" class="fb-cat-chip flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold border transition-all" style="border-color:#e5e7eb;color:#6b7280;background:transparent">
                                        <span>{{ $fbCatIcons[$catKey] }}</span>
                                        <span class="lang-str" data-so="{{ $catLabel }}" data-ba="{{ $catLabel }}">{{ $catLabel }}</span>
                                    </button>
                                    @endforeach
                                    <input type="hidden" id="fb-category" value="feedback">
                                </div>

                                <!-- ناو و ئیمێل (لە هەژمارەکەوە پڕدەکرێتەوە؛ ناو دەتوانرێت بگۆڕدرێت) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="fb-name" class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 lang-str" data-so="ناوت" data-ba="ناڤێ تە">ناوت</label>
                                        <input id="fb-name" type="text" maxlength="128" class="w-full bg-gray-50 dark:bg-[#0d1424] border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl px-4 py-3 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition" dir="rtl">
                                        <p class="mt-1.5 text-[11px] text-gray-400 font-medium lang-str" data-so="دەتوانیت بەناوێکی دیکەوە پەیامەکە بنێریت (دڵخواز)" data-ba="دشێی ب ناڤەکێ دی پەیامێ بنێری (دڵخواز)">دەتوانیت بەناوێکی دیکەوە پەیامەکە بنێریت (دڵخواز)</p>
                                    </div>
                                    <div>
                                        <label for="fb-email" class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 lang-str" data-so="ئیمێل" data-ba="ئیمێل">ئیمێل</label>
                                        <input id="fb-email" type="email" class="w-full bg-gray-100 dark:bg-[#0a0f1c] border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl px-4 py-3 text-sm font-bold focus:outline-none transition cursor-not-allowed opacity-80" dir="ltr" readonly>
                                    </div>
                                </div>

                                <!-- شارتنەوەی ئیمێل -->
                                <label for="fb-hide-email" class="flex items-center gap-2.5 mb-5 cursor-pointer select-none group w-fit">
                                    <span class="relative inline-flex items-center justify-center w-6 h-6 shrink-0 rounded-lg border-2 border-gray-300 dark:border-gray-600 transition-all group-hover:border-teal-400">
                                        <input id="fb-hide-email" type="checkbox" class="peer sr-only">
                                        <svg class="w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" stroke="currentColor" stroke-width="3.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    </span>
                                    <span class="text-xs font-bold text-gray-600 dark:text-gray-300 lang-str" data-so="ئیمێلەکەم بشارەوە (لە پەیامەکەدا دیار نەبێت)" data-ba="ئیمێلێ مە بشارە (نەبیتە دیار لە پەیامێ)">ئیمێلەکەم بشارەوە (لە پەیامەکەدا دیار نەبێت)</span>
                                </label>

                                <!-- پەیام -->
                                <label for="fb-message" class="block text-xs font-bold text-gray-500 dark:text-gray-400 mb-1.5 lang-str" data-so="پەیامەکەت" data-ba="پەیامێ تە">پەیامەکەت</label>
                                <div class="relative mb-5">
                                    <textarea id="fb-message" required rows="5" maxlength="5000" placeholder="..." class="w-full bg-gray-50 dark:bg-[#0d1424] border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white rounded-2xl px-4 py-3 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition resize-none custom-scrollbar"></textarea>
                                    <span id="fb-char-count" class="absolute bottom-3 left-3 text-[11px] font-bold text-gray-400 pointer-events-none">0 / 5000</span>
                                </div>

                                <button id="fb-submit-btn" type="submit" class="w-full bg-gradient-to-r from-blue-600 via-teal-500 to-amber-500 hover:from-blue-500 hover:via-teal-400 hover:to-amber-400 text-white font-black py-4 px-6 rounded-2xl text-base shadow-lg shadow-blue-500/25 transition-all hover:shadow-xl hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    <span class="lang-str" data-so="ناردنی پەیام" data-ba="شاندنا پەیامێ">ناردنی پەیام</span>
                                </button>
                            </form>

                            <!-- سەرکەوتن -->
                            <div id="fb-success" class="hidden absolute inset-0 z-20 bg-white/90 dark:bg-[#0a0f1c]/90 backdrop-blur flex flex-col items-center justify-center rounded-[calc(2rem-2px)]">
                                <div class="fb-check">
                                    <svg viewBox="0 0 52 52" class="w-20 h-20"><circle cx="26" cy="26" r="24" fill="none"/><path fill="none" d="M14 27l8 8 16-16"/></svg>
                                </div>
                                <p class="mt-4 text-2xl font-black text-emerald-500 lang-str" data-so="سوپاس! پەیامەکەت نێردرا" data-ba="سوپاس! بوو پەیامەکەت   ">سوپاس! پەیامەکەت نێردرا</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 font-medium lang-str" data-so="ڕاستەوخۆ دەگاتە دەست ئەدمین" data-ba="راستەوخۆ دگەهیتە دەستێ ئەدمین">ڕاستەوخۆ دەگاتە دەست ئەدمین</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- پەیامەکانم -->
                <div class="lg:col-span-2">
                    <div class="kai-fb-frame">
                        <div class="kai-fb-frame-inner p-6 md:p-8 h-full flex flex-col">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-lg shadow-teal-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-black text-gray-900 dark:text-white lang-str" data-so="پەیامەکانم" data-ba="پەیامێن من">پەیامەکانم</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium lang-str" data-so="مێژووی ناردنەکانت" data-ba="مێژووی ناردنان">مێژووی ناردنەکانت</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 mb-6 -mt-3 kai-term-mono text-[11px] font-bold text-gray-400 dark:text-gray-500" dir="ltr">
                                <span class="text-teal-500">$</span>
                                <span>cat my_messages.log | tail -f</span>
                            </div>

                            <div id="fb-my-list" class="space-y-3 flex-1">
                                <div id="fb-my-empty" class="flex flex-col items-center justify-center text-center py-12 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4 text-3xl">📭</div>
                                    <p class="font-bold text-gray-500 dark:text-gray-400 lang-str" data-so="هێشتا هیچ پەیامێکت نەناردووە" data-ba="هێشتا چ پەیامەک نەناریە">هێشتا هیچ پەیامێکت نەناردووە</p>
                                    <p class="text-xs text-gray-400 mt-1 font-medium lang-str" data-so="یەکەم بۆچوونی تۆ دەبێتە یەکەم هەنگاوی باشتربوون" data-ba="یەکێکەم بۆچوونا تە دبیتە یەکێکەم پێنگاڤا باشتربوونێ">یەکەم بۆچوونی تۆ دەبێتە یەکەم هەنگاوی باشتربوون</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div><!-- /fb-panel-member -->

            <!-- ===== بەشی ئەدمین (تەنها بۆ ئەدمین) ===== -->
            <div id="fb-panel-admin" class="hidden">
                <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-600 to-fuchsia-500 flex items-center justify-center text-white shadow-lg shadow-purple-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-2xl font-black text-gray-900 dark:text-white lang-str" data-so="سندوقی ئەدمین" data-ba="سندوقا ئەدمین">سندوقی ئەدمین</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-bold flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                    <span id="fb-live-ping" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                <span class="lang-str" data-so="پەیامەکان ڕاستەوخۆ دەردەکەون" data-ba="پەیام ڕاستەوخۆ دەردکەڤن">پەیامەکان ڕاستەوخۆ دەردەکەون</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mb-6 kai-term-mono text-[11px] font-bold text-gray-400 dark:text-gray-500" dir="ltr">
                        <span class="text-teal-500">$</span>
                        <span>tail -f /var/log/kurd-ai/feedback.log</span>
                    </div>
                </div>

                <!-- ئامار -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-[#0d1424]/70 backdrop-blur p-5 text-center">
                        <p id="fb-stat-total" class="text-3xl font-black text-blue-600 dark:text-blue-400">0</p>
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 mt-1 lang-str" data-so="هەموو پەیامەکان" data-ba="هەمی پەیام">هەموو پەیامەکان</p>
                    </div>
                    <div class="rounded-2xl border border-amber-300/60 dark:border-amber-700/50 bg-amber-50/60 dark:bg-amber-900/10 backdrop-blur p-5 text-center">
                        <p id="fb-stat-new" class="text-3xl font-black text-amber-600 dark:text-amber-400">0</p>
                        <p class="text-xs font-bold text-amber-700 dark:text-amber-400 mt-1 lang-str" data-so="نوێ نەخوێندراوە" data-ba="نووی نەخوێنە">نوێ نەخوێندراوە</p>
                    </div>
                    <div class="rounded-2xl border border-teal-300/60 dark:border-teal-700/50 bg-teal-50/60 dark:bg-teal-900/10 backdrop-blur p-5 text-center">
                        <p id="fb-stat-suggestion" class="text-3xl font-black text-teal-600 dark:text-teal-400">0</p>
                        <p class="text-xs font-bold text-teal-700 dark:text-teal-400 mt-1 lang-str" data-so="پێشنیار" data-ba="پێشنیار">پێشنیار</p>
                    </div>
                    <div class="rounded-2xl border border-rose-300/60 dark:border-rose-700/50 bg-rose-50/60 dark:bg-rose-900/10 backdrop-blur p-5 text-center">
                        <p id="fb-stat-request" class="text-3xl font-black text-rose-600 dark:text-rose-400">0</p>
                        <p class="text-xs font-bold text-rose-700 dark:text-rose-400 mt-1 lang-str" data-so="داواکاری" data-ba="داواکاری">داواکاری</p>
                    </div>
                </div>

                <!-- لیستی پەیامەکان -->
                <div id="fb-admin-list" class="space-y-3">
                    <div id="fb-admin-empty" class="flex flex-col items-center justify-center text-center py-16 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-2xl">
                        <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-4 text-3xl">🕊️</div>
                        <p class="font-bold text-gray-500 dark:text-gray-400 lang-str" data-so="هێشتا هیچ پەیامێک نەهاتووە" data-ba="هێشتا چ پەیامەک نەهاتیە">هێشتا هیچ پەیامێک نەهاتووە</p>
                        <p class="text-xs text-gray-400 mt-1 font-medium lang-str" data-so="کاتێک مێمبەر پەیامێک بنێرێت، ڕاستەوخۆ لێرە دەردەکەوێت" data-ba="دەمێ مێمبەرەک پەیامەک بنێرە، ڕاستەوخۆ ڤێرە دەردکەڤیت">کاتێک مێمبەر پەیامێک بنێرێت، ڕاستەوخۆ لێرە دەردەکەوێت</p>
                    </div>
                </div>
            </div>
        </div>

        
</section>
