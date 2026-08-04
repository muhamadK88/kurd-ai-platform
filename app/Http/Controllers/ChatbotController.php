<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Models\ChatUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    private const DAILY_LIMIT = 3;

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'user_key' => 'nullable|string|max:255',
            'session_id' => 'nullable|integer',
            'lang' => 'nullable|in:so,ba',
            'image' => 'nullable|string|max:15000000',
            'file_name' => 'nullable|string|max:255',
            'file_content' => 'nullable|string|max:100000',
            'mode' => 'nullable|in:default,grammar',
        ]);

        $key = env('DEEPSEEK_API_KEY');
        $baseUrl = env('DEEPSEEK_BASE_URL');
        $model = env('DEEPSEEK_MODEL');

        if (!$key || !$baseUrl || !$model) {
            Log::warning('AI provider config missing');
            return response()->json([
                'reply' => $this->msg($request->lang, 'config_missing'),
            ], 500);
        }

        $userKey = $request->input('user_key');
        $lang = $request->input('lang', 'so');
        $image = $request->input('image');
        $mode = $request->input('mode', 'default');

        if ($userKey && !$this->consumeDailyQuota($userKey)) {
            return response()->json([
                'reply' => $this->msg($lang, 'limit'),
                'limited' => true,
            ], 429);
        }

        $system = $this->systemPrompt($lang, $mode);

        $session = null;

        if ($userKey) {
            if ($request->input('session_id')) {
                $session = ChatSession::where('id', $request->input('session_id'))
                    ->where('user_key', $userKey)
                    ->first();
            }
            if (!$session) {
                $session = ChatSession::create([
                    'user_key' => $userKey,
                    'title' => mb_substr($request->message, 0, 60),
                ]);
            }
        }

        $userText = $request->message;
        if ($request->input('file_name') && $request->input('file_content')) {
            $userText .= "\n\n--- فایل: " . $request->input('file_name') . " ---\n" . $request->input('file_content') . "\n--- کۆتایی فایلەکە ---";
        }

        $historyMessages = [];
        if ($session) {
            $historyMessages = ChatHistory::where('session_id', $session->id)
                ->whereIn('role', ['user', 'assistant'])
                ->orderBy('id')
                ->limit(10)
                ->get()
                ->map(fn ($h) => ['role' => $h->role, 'content' => $h->content])
                ->toArray();
        }

        $isVision = !empty($image);
        $apiMessages = [['role' => 'system', 'content' => $system]];
        $apiMessages = array_merge($apiMessages, $historyMessages);

        if ($isVision) {
            $apiMessages[] = [
                'role' => 'user',
                'content' => [
                    ['type' => 'text', 'text' => $userText],
                    ['type' => 'image_url', 'image_url' => ['url' => $image]],
                ],
            ];
        } else {
            $apiMessages[] = ['role' => 'user', 'content' => $userText];
        }

        try {
            $response = Http::withToken($key)
                ->timeout(120)
                ->post($baseUrl . '/chat/completions', [
                    'model' => $isVision ? 'gemma-4-31B-it-fp8' : $model,
                    'messages' => $apiMessages,
                    'temperature' => 0.7,
                    'max_tokens' => 2000,
                ]);

            if ($response->failed()) {
                Log::error('AI provider error', ['status' => $response->status(), 'body' => substr($response->body(), 0, 500)]);
                return response()->json([
                    'reply' => $this->msg($lang, 'error'),
                ], 502);
            }

            $reply = $response->json('choices.0.message.content')
                ?? $this->msg($lang, 'no_reply');

            if ($session) {
                ChatHistory::create([
                    'session_id' => $session->id,
                    'role' => 'user',
                    'content' => $userText,
                ]);
                ChatHistory::create([
                    'session_id' => $session->id,
                    'role' => 'assistant',
                    'content' => $reply,
                ]);
                $session->touch();
            }

            return response()->json([
                'reply' => $reply,
                'session_id' => $session?->id,
                'remaining' => $this->remainingToday($userKey),
            ]);
        } catch (\Exception $e) {
            Log::error('AI provider exception', ['error' => $e->getMessage()]);
            return response()->json([
                'reply' => $this->msg($lang, 'error'),
            ], 500);
        }
    }

    private function systemPrompt(string $lang, string $mode): string
    {
        $base = $lang === 'ba'
            ? 'تۆ یاریدەدەری ژیری دەستکردی پلاتفۆرمی کورد ئەی ئای (Kurd AI) ی ب شێوەزاری بادینی. '
                . 'بەرگرییا ئەکەت: هەمی وەڵامێن تە دەبیت ب تەواوی ب شێوەزاری بادینی (کورمانجیا باکوری/بادینی) بن، نەک سۆرانی. '
                . 'بەکارئینانا فەرم و وشەیێن سۆرانی قەدەغەیە: نەک "بەخێربێیت" بەلکو "بەخێر هاتی"، نەک "دەتوانیت/دەتوانی" بەلکو "دشێی/دکەی"، نەک "ئێستا" بەلکو "نوکە/نوک"، نەک "چۆن" بەلکو "چاوا/چوان"، نەک "ئەمڕۆ" بەلکو "ئەڤرۆ"، نەک "هەوڵبدەرەوە" بەلکو "هەوڵبە"، نەک "بەم شێوەیە" بەلکو "ب ڤی شێوەی". '
                . 'فەرمێن کرداران ب شێوەزا بادینی بن: "دکەم/دکەی/دکەت"، "دێم/دێی/دێت"، "دزانم/دزانێ"، "دشێم/دشێی"، "بکە/بکەن"، "بنڤێسە/بنڤێسن"، "بەرسڤ بدە". '
                . 'بەر بەرسڤدانێ، خۆ ڕاست بکەرەوە: ئەڤ وەڵامە ب تەواوی بادینییە؟ ئەگەر نەخێر، وەڵامێ خۆ ب بادینی بنڤێسە.'
            : 'تۆ یاریدەدەری ژیری دەستکردی پلاتفۆرمی کورد ئەی ئای (Kurd AI) ی. '
                . 'پلاتفۆرمێک بۆ فێربوونی پرۆگرامسازی و زیرەکی دەستکرد بە زمانی کوردی (سۆرانی و بادینی). '
                . 'هەر کاتێک بە کوردی پرسیار کرایت، بە کوردی وەڵام بدەرەوە. وەڵامەکانت ڕوون و کورت و بەسوود بن. '
                . 'ئەگەر لە پرۆگرامسازی پرسیار کرابێت، نموونەی کۆد بدە و ڕوونی بکەرەوە.';

        if ($mode === 'grammar') {
            $base .= $lang === 'ba'
                ? ' نوکە تە دەبیت بۆ گەشتی ڕێزمان: دەقی کو بکارهینەر دانا، ڕاست بکەرەوە (ڕێزمان، ڕێنڤێسین، وشە) و پاشی ڕوون بکەرەوە چ گەشتی تێدا کرا، و پاشی دەقی ڕاستکراوی دا.'
                : ' ئێستا تۆ لە مۆدی چاککردنەوەی ڕێزمانیت: دەقەکەی بەکارهێنەر بکەرە بە باشی چاک بکەرەوە (ڕێزمان، ڕێنووس، وشە)، پاشان ڕوون بکەرەوە کە چ گۆڕانکارییەک کراوە، و لە کۆتاییدا دەقە چاککراوەکە بنووسە.';
        }

        return $base;
    }

    private function consumeDailyQuota(string $userKey): bool
    {
        $today = now()->toDateString();
        $usage = ChatUsage::firstOrCreate(
            ['user_key' => $userKey, 'usage_date' => $today],
            ['count' => 0]
        );

        if ($usage->count >= self::DAILY_LIMIT) {
            return false;
        }

        $usage->increment('count');
        return true;
    }

    private function remainingToday(?string $userKey): ?int
    {
        if (!$userKey) {
            return null;
        }
        $usage = ChatUsage::where('user_key', $userKey)
            ->where('usage_date', now()->toDateString())
            ->first();

        return max(0, self::DAILY_LIMIT - ($usage->count ?? 0));
    }

    private function msg(?string $lang, string $key): string
    {
        $so = [
            'limit' => 'گەیشتوویتە سنووری ئەمڕۆ: ٣ نامە. دوای ٢٤ کاتژمێر دیسان هەوڵبدەرەوە.',
            'error' => 'ببورە، کێشەیەک ڕوویدا. دوای تروە هەوڵبدەرەوە.',
            'no_reply' => 'ببورە، نەمتوانی وەڵام بدەمەوە.',
            'config_missing' => 'ببورە، پێکهاتەکانی ڕاژەکار ئامادە نین.',
        ];
        $ba = [
            'limit' => 'گەهیشتییە سنوورا ئەڤرۆ: ٣ پەیام. پاشی ٢٤ دەمژمێران دیسا هەوڵبە.',
            'error' => 'ببورە، کێشەیەک ڕوویدا. پاشی دەمەکێ دیسا هەوڵبە.',
            'no_reply' => 'ببورە، نەشێیام بەرسڤ بدەمە تە.',
            'config_missing' => 'ببورە، پێکهاتێن ڕاژەکار ئامادە نینن.',
        ];

        return ($lang === 'ba' ? $ba : $so)[$key] ?? $so['error'];
    }
}
