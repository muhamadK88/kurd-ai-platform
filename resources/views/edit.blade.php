<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دەستکاریکردنی زانیاری - کورد ئەی ئای</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="stylesheet" href="/css/kai-tailwind.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'"><noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap"></noscript>
    <script>if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white min-h-screen transition-colors duration-300">

    @include('partials.nav', ['active' => ''])

    <!-- ناوەڕۆکی فۆرمەکە -->
    <div class="container mx-auto py-16 px-4">
        <div class="bg-white dark:bg-gray-800 p-8 md:p-10 rounded-3xl shadow-2xl w-full max-w-2xl mx-auto border-t-4 border-yellow-500">
            
            <div class="flex flex-col sm:flex-row sm:justify-between items-center mb-8 gap-4 border-b border-gray-100 dark:border-gray-700 pb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-600 dark:text-yellow-400 rounded-xl flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white">دەستکاریکردنی زانیاری</h2>
                </div>
                <a href="javascript:history.back()" class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-5 py-2.5 rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition shadow-sm text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    گەڕانەوە
                </a>
            </div>

            <!-- فۆرمی کۆرسەکان -->
            @if($type == 'course')
                <form action="{{ route('update.course', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">ناونیشانی کۆرس</label>
                        <input type="text" name="title" value="{{ $data['title'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">بەستەری ڤیدیۆ</label>
                        <input type="url" name="video_url" value="{{ $data['video_url'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" dir="ltr" required>
                    </div>
                    <div class="mb-8">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">نرخ ($)</label>
                        <input type="number" name="price" value="{{ $data['price'] ?? 0 }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white py-3 rounded-xl font-bold text-lg transition shadow-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>

            <!-- فۆرمی تووڵەکانی ژیری دەستکرد -->
            @elseif($type == 'ai_tool')
                <form action="{{ route('update.ai_tool', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">ناوی تووڵ</label>
                        <input type="text" name="name" value="{{ $data['name'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">جۆری بەکارهێنان</label>
                        <input type="text" name="category" value="{{ $data['category'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">وەسفێکی کورت</label>
                        <textarea name="description" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" rows="3" required>{{ $data['description'] ?? '' }}</textarea>
                    </div>
                    <div class="mb-8">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">بەستەر (URL)</label>
                        <input type="url" name="link" value="{{ $data['link'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" dir="ltr" required>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white py-3 rounded-xl font-bold text-lg transition shadow-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>

            <!-- فۆرمی ڕێنیشاندەر -->
            @elseif($type == 'academic_guide')
                <form action="{{ route('update.academic_guide', $id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">پرسیار</label>
                        <input type="text" name="question" value="{{ $data['question'] ?? '' }}" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" required>
                    </div>
                    <div class="mb-8">
                        <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">وەڵام</label>
                        <textarea name="answer" class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-500 transition" rows="6" required>{{ $data['answer'] ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white py-3 rounded-xl font-bold text-lg transition shadow-lg">نوێکردنەوە و پاشەکەوتکردن</button>
                </form>
            @endif

        </div>
    </div>

    <!-- کۆدی فایەربەیس بۆ دارک مۆد و لۆگین -->
    <script type="application/json" id="kurdai-firebase-config">{!! json_encode(config('kurdai.firebase'), 15) !!}</script>
    <script type="module">
        document.getElementById('theme-toggle').addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        const KaiF = window.KaiFirebase || {};
        const auth = KaiF.auth ? KaiF.auth() : null;
        const onAuthStateChanged = KaiF.onAuthStateChanged || function () {};
        const signOut = KaiF.signOut || (function () { return Promise.resolve(); });
        
        onAuthStateChanged((user) => {
            if (!user) {
                window.location.href = "/login";
            } else {
                /* body visible instantly */
            }
        });

        const logoutBtn = document.getElementById('logout-btn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => signOut().then(() => window.location.href = "/login"));
        }
    </script>
@include('components.chat-widget')
</body>
</html>
