<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دەستکاریکردنی زانیاری - کورد ئەی ئای</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Noto Sans Arabic"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @include('partials.kurdai-design')
</head>

<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-white min-h-screen transition-colors duration-300" style="display: none;">

    <!-- نەڤباری سەرەکی -->
    <nav class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-800 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            
            <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg text-white font-black text-xl">ئـ</div>
                <h1 class="text-2xl font-black bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-blue-500 dark:from-blue-400 dark:to-cyan-300">کورد ئەی ئای</h1>
            </a>

            <div class="hidden md:flex items-center space-x-reverse space-x-2">
                <a href="/" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">سەرەکی</a>
                <a href="/courses" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">کۆرسەکان</a>
                <a href="/ai-tools" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">تووڵەکانی AI</a>
                <a href="/academic-guide" class="px-4 py-2 text-gray-600 dark:text-gray-300 font-bold hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">ڕێنیشاندەر</a>
            </div>

            <div class="flex items-center gap-3">
                <button id="theme-toggle" class="p-2.5 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-300 shadow-sm">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                </button>
                <a href="/profile" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 border border-blue-200 dark:border-gray-600 text-blue-800 dark:text-blue-300 rounded-xl hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 font-bold text-sm ml-2">هەژمارەکەم</a>
                <a href="/#feedback-section" class="flex items-center gap-2 px-4 py-2 bg-rose-50 to-rose-100 dark:from-gray-800 dark:to-gray-700 border border-rose-200 dark:border-gray-600 text-rose-800 dark:text-rose-300 rounded-xl hover:shadow-md hover:-translate-y-0.5 transition-all duration-300 font-bold text-sm">ڕەخنە</a>
            </div>
            
        </div>
    </nav>

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
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
        import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-auth.js";

        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        document.getElementById('theme-toggle').addEventListener('click', function() {
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        const firebaseConfig = JSON.parse((document.getElementById('kurdai-firebase-config') || {}).textContent || '{}');
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        
        onAuthStateChanged(auth, (user) => {
            if (!user) {
                window.location.href = "/login";
            } else {
                document.body.style.display = 'block';
            }
        });
    </script>
@include('components.chat-widget')
</body>
</html>