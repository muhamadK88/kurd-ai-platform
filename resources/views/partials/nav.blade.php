{{--
    ============================================================
    KURD AI — ناڤبار (shared navigation)
    ============================================================
    Usage:  @include('partials.nav', ['active' => 'home'])

    Every link, every element ID (lang-toggle, lang-text,
    theme-toggle, logout-btn) and every lang-str data attribute is
    preserved exactly as it was on the original per-page navbars,
    so all existing page JS keeps working untouched.
    ============================================================
--}}
@php
    $active = $active ?? '';

    $navLinks = [
        ['key' => 'home',           'href' => '/',                'so' => 'سەرەکی',       'ba' => 'سەرەکی'],
        ['key' => 'ferga',          'href' => '/ferga',           'so' => 'فێرگە',         'ba' => 'فێرگە'],
        ['key' => 'courses',        'href' => '/courses',         'so' => 'کۆرسەکان',     'ba' => 'کۆرس'],
        ['key' => 'news',           'href' => '/news',            'so' => 'هەواڵەکان',    'ba' => 'نووچە'],
        ['key' => 'ai-tools',       'href' => '/ai-tools',        'so' => 'تووڵەکان',     'ba' => 'ئامراز'],
        ['key' => 'academic-guide', 'href' => '/academic-guide',  'so' => 'ڕێنیشاندەر',   'ba' => 'ڕێبەر'],
        ['key' => 'universities',   'href' => '/universities',    'so' => 'زانکۆکان',     'ba' => 'زانکۆ'],
        ['key' => 'about',          'href' => '/about',           'so' => 'دەربارەی ئێمە','ba' => 'دەربارەی مە'],
    ];
@endphp

<nav class="ka-nav ka-vt-nav">
    <div class="container mx-auto px-4">
        <div class="ka-nav__shell">

            {{-- ---------- Wordmark ---------- --}}
            <a href="/" class="group flex items-center gap-3 flex-shrink-0 ka-vt-logo">
                <div class="relative flex-shrink-0">
                    <div class="absolute -inset-2.5 rounded-full blur-xl opacity-0 group-hover:opacity-60 transition-opacity duration-500"
                         style="background: var(--ka-brand-gradient);"></div>
                    <img src="/logo.jpg" alt="Kurd AI Logo"
                         class="relative z-10 h-10 md:h-11 w-auto object-contain rounded-xl dark:invert drop-shadow-md
                                group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500"
                         style="transition-timing-function: var(--ka-spring);">
                </div>
                <div class="hidden sm:flex flex-col justify-center leading-none">
                    <span class="ka-wordmark text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-white
                                 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">
                        KURD AI
                    </span>
                    <span class="ka-wordmark ka-gradient-text text-[0.55rem] md:text-[0.6rem] font-bold tracking-[0.22em] mt-1">
                        INNOVATION · FUTURE
                    </span>
                </div>
            </a>

            {{-- ---------- Desktop links + morphing pill ---------- --}}
            <div class="ka-navlinks hidden lg:flex items-center gap-1 p-1.5 rounded-[20px]
                        border border-[var(--ka-line-soft)] bg-black/[0.03] dark:bg-white/[0.04]">
                <span class="ka-navlinks__pill" aria-hidden="true"></span>
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}"
                       class="ka-navlink lang-str px-3.5 py-2 rounded-[14px] text-sm font-bold whitespace-nowrap
                              {{ $active === $link['key']
                                    ? 'is-active'
                                    : 'text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-cyan-400' }}"
                       data-so="{{ $link['so'] }}" data-ba="{{ $link['ba'] }}">{{ $link['so'] }}</a>
                @endforeach
            </div>

            {{-- ---------- Controls ---------- --}}
            <div class="flex items-center gap-2">

                <button id="lang-toggle"
                        class="ka-icon-btn px-3 py-2 text-xs font-bold text-blue-700 dark:text-cyan-300"
                        title="سۆرانی / بادینی">
                    <span id="lang-text">Badini</span>
                </button>

                <button id="theme-toggle" class="ka-icon-btn p-2.5 text-base leading-none" title="ڕووناک / تاریک">
                    <span class="ka-theme-icon">🌙</span>
                </button>

                <a href="/profile"
                   class="ka-icon-btn lang-str hidden sm:inline-flex px-3.5 py-2 text-xs font-bold text-gray-700 dark:text-gray-200"
                   data-so="هەژمارەکەم" data-ba="هەژمارا من">هەژمارەکەم</a>

                <button id="logout-btn"
                        class="ka-icon-btn lang-str px-3.5 py-2 text-xs font-bold text-red-600 dark:text-red-400
                               hover:!border-red-400/50"
                        data-so="دەرچوون" data-ba="دەرکەفتن">دەرچوون</button>

                {{-- mobile menu trigger --}}
                <button id="ka-burger" class="ka-icon-btn lg:hidden p-2.5" aria-expanded="false" aria-label="Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- ---------- Mobile drawer ---------- --}}
        <div id="ka-drawer"
             class="lg:hidden overflow-hidden mt-2 rounded-[24px]"
             style="max-height: 0; transition: max-height .55s var(--ka-ease);">
            <div class="ka-glass p-3 rounded-[24px] grid grid-cols-2 gap-2">
                @foreach ($navLinks as $link)
                    <a href="{{ $link['href'] }}"
                       class="lang-str px-4 py-3 rounded-[16px] text-sm font-bold text-center transition-all duration-300
                              {{ $active === $link['key']
                                    ? 'text-white shadow-lg'
                                    : 'text-gray-700 dark:text-gray-200 hover:bg-black/5 dark:hover:bg-white/10' }}"
                       @if ($active === $link['key']) style="background: var(--ka-brand-gradient);" @endif
                       data-so="{{ $link['so'] }}" data-ba="{{ $link['ba'] }}">{{ $link['so'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</nav>
