<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>زیادکردنی کۆرس - کورد ئەی ئای</title>
    <script src="https://cdn.tailwindcss.com"></script>

    @include('partials.kurdai-design')
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen font-sans">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 text-center">زیادکردنی کۆرسی نوێ</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('store.course') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">ناوی کۆرس</label>
                <input type="text" name="title" required placeholder="نموونە: کۆرسی فڵەتەر" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">بەستەری ڤیدیۆ (URL)</label>
                <input type="url" name="video_url" required placeholder="https://youtube.com/..." 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-left" dir="ltr">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">نرخ (بە دۆلار)</label>
                <input type="number" name="price" required placeholder="بۆ خۆڕایی بنووسە 0" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-left" dir="ltr">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                ناردن بۆ فایەربەیس
            </button>
        </form>
    </div>

@include('components.chat-widget')
</body>
</html>