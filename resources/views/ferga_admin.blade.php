<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>بەڕێوەبردنی فێرگە - کورد ئەی ئای</title>
    <link rel="icon" href="/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <link rel="stylesheet" href="/css/kai-ferga-learn.css?v=13">
    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-[#0a0f1c] dark:text-white min-h-screen transition-colors duration-300">

@include('partials.nav', ['active' => 'ferga'])

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

    {{-- ================= سەرپەڕە ================= --}}
    <section class="kfg-hero rounded-[28px] p-6 sm:p-8 mb-8" style="--kfg-accent:#a855f7">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black mb-1 lang-str" data-so="بەڕێوەبردنی فێرگە" data-ba="بەڕێڤەبیرنا فێرگە">بەڕێوەبردنی فێرگە</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-bold lang-str"
                   data-so="دروستکردن، دەستکاریکردن و بەڕێوەبردنی کۆرس و وانەکان — ئەدمین تەنها" 
                   data-ba="دروستکرن، دەستکاریکرن و بەڕێڤەبیرنا کورس و وانەیان — ئەدمین تەنها">دروستکردن، دەستکاریکردن و بەڕێوەبردنی کۆرس و وانەکان — ئەدمین تەنها</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="px-4 py-2 rounded-2xl bg-purple-500/10 border border-purple-500/30 text-center">
                    <div id="kfga-stat-courses" class="text-xl font-black text-purple-500 dark:text-purple-300">0</div>
                    <div class="text-[11px] font-bold text-slate-400 lang-str" data-so="کۆرس" data-ba="کورس">کۆرس</div>
                </div>
                <div class="px-4 py-2 rounded-2xl bg-cyan-500/10 border border-cyan-500/30 text-center">
                    <div id="kfga-stat-lessons" class="text-xl font-black text-cyan-500 dark:text-cyan-300">0</div>
                    <div class="text-[11px] font-bold text-slate-400 lang-str" data-so="وانە" data-ba="وانە">وانە</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= نا-ئەدمین ================= --}}
    <section id="kfga-unauthorized" class="hidden">
        <div class="kfg-admin-card rounded-[24px] p-10 text-center">
            <div class="w-20 h-20 mx-auto rounded-full bg-rose-500/10 border border-rose-500/30 flex items-center justify-center text-4xl mb-4">⛔</div>
            <h2 class="text-xl font-black mb-1 lang-str" data-so="بەردەست نییە" data-ba="بەردەست نینە">بەردەست نییە</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-bold lang-str" data-so="تەنها ئەدمینەکان دەتوانن بگەنە ئەم پەڕەیە." data-ba="تنێ ئەدمین شایا ڤێ پەلەپەڕێ گەهیشتن.">تەنها ئەدمینەکان دەتوانن بگەنە ئەم پەڕەیە.</p>
            <a href="/ferga" class="kfg-btn kfg-btn--primary mt-6 lang-str" data-so="گەڕانەوە بۆ فێرگە" data-ba="ڤەگەڕا بۆ فێرگە">گەڕانەوە بۆ فێرگە</a>
        </div>
    </section>

    {{-- ================= بەڕێوەبەری ================= --}}
    <section id="kfga-admin" class="hidden">

        {{-- ---- دۆخی بارکردن ---- --}}
        <div id="kfga-loading" class="kfg-note kfg-note--info mb-6 lang-str" data-so="بارکردنی داتاکان..." data-ba="بارکرنا داتایان...">بارکردنی داتاکان...</div>

        {{-- ---- کۆرسەکان ---- --}}
        <div id="kfga-courses-panel">
            <div class="kfg-admin-head">
                <h2 class="text-xl font-black lang-str" data-so="کۆرسەکان" data-ba="کورس">کۆرسەکان</h2>
                <button type="button" id="kfga-new-course" class="kfg-btn kfg-btn--primary lang-str" data-so="➕ کۆرسی نوێ" data-ba="➕ کورسێ نوی">➕ کۆرسی نوێ</button>
            </div>
            <div class="kfg-note kfg-note--info mb-4 lang-str"
                 data-so="ڕیزبەندی کۆرسەکان ژیانی فێربوونە — کۆرسێک بە تەواوی تەواو دەکرێت بەڵام ئەگەر دۆخەکەی 'دووربەستە' یان 'بەم زوانە' بێت، خوێندکار ناتوانێت بیکاتەوە."
                 data-ba="ڕیزبەندا کورسانا ژیانا فێربوونێ یە — کورسەکێ تەواو دەکرێت بەلەڤ ئەگەر دۆخا وێ 'قفڵکری' یا 'بەم دیمە' بیت، خوەندکار نیشایا ڤەکیت.">
                 ڕیزبەندی کۆرسەکان ژیانی فێربوونە — کۆرسێک بە تەواوی تەواو دەکرێت بەڵام ئەگەر دۆخەکەی 'دووربەستە' یان 'بەم زوانە' بێت، خوێندکار ناتوانێت بیکاتەوە.</div>
            <div id="kfga-courses"></div>
            <div id="kfga-courses-empty" class="hidden kfg-note kfg-note--warn lang-str" data-so="هێشتا هیچ کۆرسێک نییە — یەکەم کۆرس دروست بکە." data-ba="هێشتا چ کورس نینن — یێکێم کورس دروست بکە.">هێشتا هیچ کۆرسێک نییە — یەکەم کۆرس دروست بکە.</div>
        </div>

        {{-- ---- وانەکان ---- --}}
        <div id="kfga-lessons-panel" class="hidden">
            <div class="kfg-admin-head">
                <div class="flex items-center gap-3 min-w-0">
                    <button type="button" id="kfga-back-courses" class="kfg-btn kfg-btn--ghost lang-str" data-so="→ کۆرسەکان" data-ba="→ کورس">→ کۆرسەکان</button>
                    <h2 id="kfga-lessons-course-title" class="text-xl font-black truncate"></h2>
                </div>
                <button type="button" id="kfga-new-lesson" class="kfg-btn kfg-btn--primary lang-str" data-so="➕ وانەی نوێ" data-ba="➕ وانەیێ نوی">➕ وانەی نوێ</button>
            </div>
            <div class="kfg-note kfg-note--info mb-4 lang-str"
                 data-so="ناوەڕۆکی وانەکان بە زمانی سۆرانی و بادینی دابین بکە — دەتوانیت وێنە، خشتە و بلۆکی کۆد لەگەڵ تایبەتمەندی ڕاکێشانی کۆد (Python) زیاد بکەیت."
                 data-ba="ناڤەڕۆکا وانەیان ب زمانێ سۆرانی و بادینی دابین بکە — شایا وێنە، خشتە و بلۆکێن کۆدی لگەل تایبەتمەندی کارخستنا کۆدی (Python) زێدە بکەی.">
                 ناوەڕۆکی وانەکان بە زمانی سۆرانی و بادینی دابین بکە — دەتوانیت وێنە، خشتە و بلۆکی کۆد لەگەڵ تایبەتمەندی ڕاکێشانی کۆد (Python) زیاد بکەیت.</div>
            <div id="kfga-lessons"></div>
            <div id="kfga-lessons-empty" class="hidden kfg-note kfg-note--warn lang-str" data-so="هێشتا هیچ وانەیەک نییە — یەکەم وانە دروست بکە." data-ba="هێشتا چ وانە نینن — یێکێم وانە دروست بکە.">هێشتا هیچ وانەیەک نییە — یەکەم وانە دروست بکە.</div>
        </div>
    </section>
</main>

{{-- ================= مۆدالی کۆرس ================= --}}
<div id="kfga-course-modal" class="kfg-modal">
    <div class="kfg-modal__box">
        <div class="flex items-center justify-between gap-4 mb-5">
            <h3 id="kfga-course-modal-title" class="text-lg font-black lang-str" data-so="کۆرسی نوێ" data-ba="کورسێ نوی">کۆرسی نوێ</h3>
            <button type="button" class="kfg-icon-btn kfga-close" data-modal="kfga-course-modal">✕</button>
        </div>
        <input type="hidden" id="kfga-course-id">
        <div class="kfg-grid-2">
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="ناونیشان (سۆرانی) *" data-ba="ناڤ (سۆرانی) *">ناونیشان (سۆرانی) *</label>
                <input type="text" id="kfga-course-title-so" class="kfg-input" maxlength="255" required>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="ناونیشان (بادینی) *" data-ba="ناڤ (بادینی) *">ناونیشان (بادینی) *</label>
                <input type="text" id="kfga-course-title-ba" class="kfg-input" maxlength="255" required>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="وەسف (سۆرانی)" data-ba="شایان (سۆرانی)">وەسف (سۆرانی)</label>
                <textarea id="kfga-course-desc-so" class="kfg-textarea" rows="2" maxlength="4000"></textarea>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="وەسف (بادینی)" data-ba="شایان (بادینی)">وەسف (بادینی)</label>
                <textarea id="kfga-course-desc-ba" class="kfg-textarea" rows="2" maxlength="4000"></textarea>
            </div>
        </div>
        <div class="kfg-grid-2">
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="ئایکۆن" data-ba="ئایکۆن">ئایکۆن</label>
                <input type="text" id="kfga-course-icon" class="kfg-input" maxlength="16" placeholder="🧠">
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="ڕەنگ" data-ba="ڕەنگ">ڕەنگ</label>
                <select id="kfga-course-accent" class="kfg-select">
                    <option value="cyan">Cyan</option>
                    <option value="blue">Blue</option>
                    <option value="purple">Purple</option>
                    <option value="pink">Pink</option>
                    <option value="amber">Amber</option>
                    <option value="green">Green</option>
                    <option value="sky">Sky</option>
                    <option value="indigo">Indigo</option>
                    <option value="rose">Rose</option>
                    <option value="teal">Teal</option>
                </select>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="دۆخ" data-ba="دۆخ">دۆخ</label>
                <select id="kfga-course-status" class="kfg-select">
                    <option value="active" class="lang-str" data-so="بەردەست" data-ba="بەردەست">بەردەست</option>
                    <option value="locked" class="lang-str" data-so="دووربەستە" data-ba="قفڵکری">دووربەستە</option>
                    <option value="coming_soon" class="lang-str" data-so="بەم زوانە" data-ba="بەم دیمە">بەم زوانە</option>
                </select>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2 mt-4">
            <button type="button" class="kfg-btn kfg-btn--ghost kfga-close" data-modal="kfga-course-modal" data-so="پاشگەزبوونەوە" data-ba="پاشڤەگەڕان">پاشگەزبوونەوە</button>
            <button type="button" id="kfga-course-save" class="kfg-btn kfg-btn--primary lang-str" data-so="پاشەکەوتکردن" data-ba="پاشەکەوتکرن">پاشەکەوتکردن</button>
        </div>
    </div>
</div>

{{-- ================= مۆدالی وانە ================= --}}
<div id="kfga-lesson-modal" class="kfg-modal">
    <div class="kfg-modal__box">
        <div class="flex items-center justify-between gap-4 mb-5">
            <h3 id="kfga-lesson-modal-title" class="text-lg font-black lang-str" data-so="وانەی نوێ" data-ba="وانەیێ نوی">وانەی نوێ</h3>
            <button type="button" class="kfg-icon-btn kfga-close" data-modal="kfga-lesson-modal">✕</button>
        </div>
        <input type="hidden" id="kfga-lesson-id">

        {{-- دوان-شێوەزار پاڵ پاڵ — Sorani & Badini side-by-side --}}
        <div class="kfg-dx-grid">
            <div class="kfg-dx-col">
                <div class="kfg-dx-head">
                    <span class="kfg-dx-badge is-so">سۆرانی</span>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">ناونیشان (سۆرانی) *</label>
                    <input type="text" id="kfga-lesson-title-so" class="kfg-input" maxlength="255" required>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">وەسف (سۆرانی)</label>
                    <textarea id="kfga-lesson-desc-so" class="kfg-textarea" rows="2" maxlength="4000" placeholder="وەسفێکی کورت..."></textarea>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">ناوەڕۆک (سۆرانی)</label>
                    <div class="kfg-editor">
                        <div class="kfg-editor__tools" data-toolbar="kfga-content-so">
                            <button type="button" data-cmd="bold" title="Bold"><b>B</b></button>
                            <button type="button" data-cmd="italic" title="Italic"><i>I</i></button>
                            <button type="button" data-cmd="h3" title="Heading">H3</button>
                            <button type="button" data-cmd="p" title="Paragraph">¶</button>
                            <button type="button" data-cmd="ul" title="List">•–</button>
                            <button type="button" data-cmd="ol" title="Numbered">1.</button>
                            <button type="button" data-cmd="blockquote" title="Quote">❝</button>
                            <button type="button" data-cmd="link" title="Link">🔗</button>
                            <button type="button" data-cmd="code" title="Inline code">&lt;code&gt;</button>
                            <button type="button" data-cmd="codeblock" title="Code block">▤ Code</button>
                            <button type="button" data-cmd="runblock" title="Runnable code (Python)">▶ Run</button>
                            <button type="button" data-cmd="source" title="HTML source">&lt;/&gt;</button>
                        </div>
                        <div class="kfg-editor__area" contenteditable="true" data-ph="ناوەڕۆکی وانەکە لێرە بنووسە..." id="kfga-content-so"></div>
                        <textarea class="kfg-editor__src" hidden id="kfga-src-so" spellcheck="false"></textarea>
                    </div>
                </div>
            </div>

            <div class="kfg-dx-col">
                <div class="kfg-dx-head">
                    <span class="kfg-dx-badge is-ba">بادینی</span>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">ناونیشان (بادینی) *</label>
                    <input type="text" id="kfga-lesson-title-ba" class="kfg-input" maxlength="255" required>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">وەسف (بادینی)</label>
                    <textarea id="kfga-lesson-desc-ba" class="kfg-textarea" rows="2" maxlength="4000" placeholder="دانەکەکە کورت..."></textarea>
                </div>
                <div class="kfg-field">
                    <label class="kfg-label">ناوەڕۆک (بادینی)</label>
                    <div class="kfg-editor">
                        <div class="kfg-editor__tools" data-toolbar="kfga-content-ba">
                            <button type="button" data-cmd="bold" title="Bold"><b>B</b></button>
                            <button type="button" data-cmd="italic" title="Italic"><i>I</i></button>
                            <button type="button" data-cmd="h3" title="Heading">H3</button>
                            <button type="button" data-cmd="p" title="Paragraph">¶</button>
                            <button type="button" data-cmd="ul" title="List">•–</button>
                            <button type="button" data-cmd="ol" title="Numbered">1.</button>
                            <button type="button" data-cmd="blockquote" title="Quote">❝</button>
                            <button type="button" data-cmd="link" title="Link">🔗</button>
                            <button type="button" data-cmd="code" title="Inline code">&lt;code&gt;</button>
                            <button type="button" data-cmd="codeblock" title="Code block">▤ Code</button>
                            <button type="button" data-cmd="runblock" title="Runnable code (Python)">▶ Run</button>
                            <button type="button" data-cmd="source" title="HTML source">&lt;/&gt;</button>
                        </div>
                        <div class="kfg-editor__area" contenteditable="true" data-ph="ناڤەڕۆکێ وانەیێ لڤیرە بنڤیسە..." id="kfga-content-ba"></div>
                        <textarea class="kfg-editor__src" hidden id="kfga-src-ba" spellcheck="false"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="kfg-grid-2">
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="زمانی کۆد" data-ba="زمانێ کۆدی">زمانی کۆد</label>
                <select id="kfga-lesson-language" class="kfg-select">
                    <option value="python">Python</option>
                </select>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="وێنە (URL یا بردن)" data-ba="وێنە (URL یا بردن)">وێنە (URL یا بردن)</label>
                <input type="text" id="kfga-lesson-media" class="kfg-input" placeholder="https:// یاخود بەرگری خوێنەکە">
                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 lang-str" data-so="وێنەیەکی فێرگە بەستێرەوە — کاتیەک ئایمەلەکەی نووسەوە یان رشتەی URL بدەوە. بەرگری: پشتگیری کردن." data-ba="وێنەکێ فێرگەیێ بستێرە — کاتیێ ویمیلەکێ نووسە یان URL ریزە بدەوە. بەرگری: پشتگیریکردن.">URL ی وێنە یان دەرچووو دەتوانلێت بکەوێت.</p>
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="ناونیشانی بەش" data-ba="ناونیشانی بەش">ناونیشانی بەش</label>
                <input type="text" id="kfga-lesson-section" class="kfg-input" placeholder="بنەماکان و فەلسەفەی ژیریی دەستکرد">
            </div>
            <div class="kfg-field">
                <label class="kfg-label lang-str" data-so="کۆدی دەستپێک (Playground)" data-ba="کۆدا دەستپێکێ (Playground)">کۆدی دەستپێک (Playground)</label>
                <textarea id="kfga-lesson-starter" class="kfg-textarea" rows="3" spellcheck="false" placeholder="print('سڵاو!')" dir="ltr"></textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 mt-4">
            <button type="button" class="kfg-btn kfg-btn--ghost kfga-close" data-modal="kfga-lesson-modal" data-so="پاشگەزبوونەوە" data-ba="پاشڤەگەڕان">پاشگەزبوونەوە</button>
            <button type="button" id="kfga-lesson-save" class="kfg-btn kfg-btn--primary lang-str" data-so="پاشەکەوتکردن" data-ba="پاشەکەوتکرن">پاشەکەوتکردن</button>
        </div>
    </div>
</div>

{{-- toast --}}
<div id="kfga-toast" class="hidden fixed top-5 left-1/2 -translate-x-1/2 z-[9999] px-5 py-3 rounded-2xl text-sm font-black text-white shadow-2xl" style="direction: rtl;"></div>

<script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
<script src="/js/kai-ferga-admin.js?v=9" defer></script>
</body>
</html>
