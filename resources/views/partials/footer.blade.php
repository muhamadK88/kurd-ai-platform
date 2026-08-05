{{--
    ============================================================
    KURD AI — فووتەر (shared footer)
    ============================================================
    Same links and wording as the original home-page footer,
    restyled and now shared across pages. Nothing removed.
    ============================================================
--}}
<footer class="relative mt-24 overflow-hidden">

    {{-- top hairline that fades in from the brand ramp --}}
    <div class="h-px w-full" style="background: linear-gradient(90deg, transparent, rgba(59,130,246,.5), rgba(139,92,246,.5), transparent);"></div>

    <div class="relative bg-white/40 dark:bg-[#04070f]/60 backdrop-blur-xl">
        <div class="container mx-auto max-w-7xl px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <img src="/logo.jpg" alt="Kurd AI" class="h-11 w-auto object-contain rounded-xl dark:invert">
                        <div class="leading-none">
                            <div class="ka-wordmark text-lg font-bold text-gray-900 dark:text-white">KURD AI</div>
                            <span class="ka-wordmark ka-gradient-text text-[0.5rem] font-bold tracking-[0.22em]">INNOVATION · FUTURE</span>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 lang-str"
                       data-so="یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی."
                       data-ba="ئێکەمین پلاتفۆرما کوردی بۆ فێربوونا ژیرییا دەستکرد و پرۆگرامسازیێ.">یەکەمین پلاتفۆرمی کوردی بۆ فێربوونی ژیریی دەستکرد و پرۆگرامسازی.</p>
                </div>

                <div>
                    <h5 class="font-black mb-5 text-gray-900 dark:text-white lang-str" data-so="بەشەکان" data-ba="بەش">بەشەکان</h5>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="/ferga"    class="ka-footlink lang-str" data-so="فێرگە"      data-ba="فێرگە">فێرگە</a></li>
                        <li><a href="/courses"  class="ka-footlink lang-str" data-so="کۆرسەکان"  data-ba="کۆرس">کۆرسەکان</a></li>
                        <li><a href="/ai-tools" class="ka-footlink lang-str" data-so="ئامرازەکان" data-ba="ئامراز">ئامرازەکان</a></li>
                        <li><a href="/news"     class="ka-footlink lang-str" data-so="هەواڵەکان"  data-ba="نووچە">هەواڵەکان</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-black mb-5 text-gray-900 dark:text-white lang-str" data-so="ڕێنمایی" data-ba="ڕێنمایی">ڕێنمایی</h5>
                    <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <li><a href="/academic-guide" class="ka-footlink lang-str" data-so="ڕێنیشاندەر"    data-ba="ڕێبەر">ڕێنیشاندەر</a></li>
                        <li><a href="/universities"   class="ka-footlink lang-str" data-so="زانکۆکان"      data-ba="زانکۆ">زانکۆکان</a></li>
                        <li><a href="/about"          class="ka-footlink lang-str" data-so="دەربارەی ئێمە" data-ba="دەربارەی مە">دەربارەی ئێمە</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-[var(--ka-line-soft)] py-6">
            <p class="text-center text-sm text-gray-500 dark:text-gray-500 lang-str"
               data-so="گەشەپێدراوە لەلایەن تیمی کورد ئەی ئای © ٢٠٢٦"
               data-ba="هاتیە پێشڤەبرن ژ لایێ تیمێ کورد ئەی ئای © ٢٠٢٦">گەشەپێدراوە لەلایەن تیمی کورد ئەی ئای © ٢٠٢٦</p>
        </div>
    </div>

    <style>
        .ka-footlink {
            position: relative;
            transition: color .3s var(--ka-swift), padding-inline-start .3s var(--ka-ease);
        }
        .ka-footlink::before {
            content: '';
            position: absolute; inset-inline-start: -12px; top: 50%;
            width: 6px; height: 6px; border-radius: 99px;
            background: var(--ka-brand-gradient);
            transform: translateY(-50%) scale(0);
            transition: transform .4s var(--ka-spring);
        }
        .ka-footlink:hover { color: var(--ka-azure); padding-inline-start: 12px; }
        .ka-footlink:hover::before { transform: translateY(-50%) scale(1); }
    </style>
</footer>
