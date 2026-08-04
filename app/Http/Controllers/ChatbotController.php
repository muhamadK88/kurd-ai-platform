<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'user_key' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'lang' => 'nullable|in:so,ba',
            'image' => 'nullable|string|max:15000000',
            'file_name' => 'nullable|string|max:255',
            'file_content' => 'nullable|string|max:100000',
            'mode' => 'nullable|in:default,grammar',
        ]);

        $providers = $this->providers();

        if (!$providers) {
            Log::warning('AI provider config missing');
            return response()->json([
                'reply' => $this->msg($request->lang, 'config_missing'),
            ], 500);
        }

        $userKey = $request->input('user_key');
        $userId = $request->input('user_id');
        $lang = $request->input('lang', 'so');
        $image = $request->input('image');
        $mode = $request->input('mode', 'default');

        if ($image && !$visionModel) {
            Log::warning('Vision model config missing');
            return response()->json([
                'reply' => $this->msg($request->lang, 'config_missing'),
            ], 500);
        }

        $isAdmin = false;
        $authUser = $request->user();
        if ($authUser) {
            $isAdmin = $authUser->is_admin;
        } elseif ($userId) {
            $user = User::find($userId);
            $isAdmin = $user && $user->is_admin;
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

        $response = null;
        $lastStatus = 0;
        $lastBody = '';

        foreach ($providers as $provider) {
            $models = $isVision
                ? array_values(array_unique(array_filter([$provider['vision_model'] ?? null, $provider['model'] ?? null, $provider['fallback_model'] ?? null])))
                : array_values(array_unique(array_filter([$provider['model'], $provider['fallback_model'] ?? null])));

            foreach ($models as $attemptModel) {
                try {
                    $response = Http::withToken($provider['key'])
                        ->timeout(90)
                        ->post($provider['base_url'] . '/chat/completions', [
                            'model' => $attemptModel,
                            'messages' => $apiMessages,
                            'temperature' => 0.7,
                            'max_tokens' => 1200,
                        ]);
                } catch (\Exception $e) {
                    Log::warning('AI provider connection failed', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                        'error' => $e->getMessage(),
                    ]);
                    usleep(300000);
                    continue;
                }

                $lastStatus = $response->status();
                $lastBody = substr((string) $response->body(), 0, 500);

                if (!$response->failed()) {
                    break 2;
                }

                Log::warning('AI provider attempt failed', [
                    'provider' => $provider['name'] ?? '?',
                    'model' => $attemptModel,
                    'status' => $lastStatus,
                    'body' => $lastBody,
                ]);
                usleep(300000);
            }

            $response = null;
        }

        if (!$response || $response->failed()) {
            Log::error('AI providers error', ['status' => $lastStatus, 'body' => $lastBody]);

            if ($lastStatus === 429 && str_contains($lastBody, 'quota exceeded')) {
                return response()->json([
                    'reply' => $this->msg($lang, 'provider_quota'),
                ], 429);
            }

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
            'is_admin' => $isAdmin,
        ]);
    }

    private function configDir(): ?string
    {
        $home = getenv('HOME') ?: ($_SERVER['HOME'] ?? null);
        return $home ? $home . '/.config/kurd-ai' : null;
    }

    private function providers(): array
    {
        $dir = $this->configDir();
        $list = null;

        if ($dir && is_readable($dir . '/providers.json')) {
            $list = json_decode((string) file_get_contents($dir . '/providers.json'), true);
        }

        if (is_array($list) && $list) {
            $resolved = [];
            foreach ($list as $p) {
                if (!is_array($p) || empty($p['base_url']) || empty($p['model'])) {
                    continue;
                }
                $key = $this->resolveKey($p, $dir);
                if ($key === null) {
                    Log::info('AI provider skipped (no key)', ['provider' => $p['name'] ?? '?']);
                    continue;
                }
                $p['key'] = $key;
                $resolved[] = $p;
            }
            return $resolved;
        }

        $key = env('DEEPSEEK_API_KEY');
        $baseUrl = env('DEEPSEEK_BASE_URL');
        $model = env('DEEPSEEK_MODEL');
        $visionModel = env('DEEPSEEK_VISION_MODEL');
        $fallbackModel = env('DEEPSEEK_FALLBACK_MODEL');

        if (!$key || !$baseUrl || !$model) {
            $file = $dir ? $dir . '/provider.json' : null;

            if ($file && is_readable($file)) {
                $provider = json_decode((string) file_get_contents($file), true) ?? [];
                $keyFile = dirname($file) . '/deepseek_key';
                $key = $key ?: trim((string) (is_readable($keyFile) ? file_get_contents($keyFile) : ''));
                $baseUrl = $baseUrl ?: ($provider['base_url'] ?? null);
                $model = $model ?: ($provider['model'] ?? null);
                $visionModel = $visionModel ?: ($provider['vision_model'] ?? null);
                $fallbackModel = $fallbackModel ?: ($provider['fallback_model'] ?? null);
            }
        }

        if (!$key || !$baseUrl || !$model) {
            return [];
        }

        return [[
            'name' => 'legacy',
            'key' => $key,
            'base_url' => $baseUrl,
            'model' => $model,
            'vision_model' => $visionModel,
            'fallback_model' => $fallbackModel,
        ]];
    }

    private function resolveKey(array $p, ?string $dir): ?string
    {
        if (!empty($p['api_key'])) {
            return (string) $p['api_key'];
        }

        if (!empty($p['api_key_file'])) {
            $f = str_starts_with((string) $p['api_key_file'], '/')
                ? $p['api_key_file']
                : ($dir ? $dir . '/' . $p['api_key_file'] : null);
            if ($f && is_readable($f)) {
                return trim((string) file_get_contents($f));
            }
            return null;
        }

        if (!empty($p['api_key_env'])) {
            return env((string) $p['api_key_env']) ?: null;
        }

        if (!empty($p['no_key'])) {
            return 'no-key';
        }

        return null;
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
                . 'بەرگرییا ئەکەت: هەمی وەڵامێن تە دەبیت ب تەواوی ب شێوەزاری سۆرانی (کوردیی ناوەندی) بن — نەک بادینی و نەک کورمانجی باکور. '
                . 'بەکارئینانا فەرم و وشەیێن بادینی/کورمانجی قەدەغەیە: نەک "دتوانم/دتوانی/دتوانێ" بەلکو "دەتوانم/دەتوانیت/دەتوانێت"، نەک "چاوا/چوان" بەلکو "چۆن"، نەک "ئەڤرۆ" بەلکو "ئەمڕۆ"، نەک "نوکە/نوک" بەلکو "ئێستا"، نەک "بەخێر هاتی" بەلکو "بەخێربێیت"، نەک "بکەم/بکەی" بەلکو "بکەم/بکەیت". '
                . 'فەرمێن کرداران ب سۆرانی بن: "دەکەم/دەکەیت/دەکات"، "دەزانم/دەزانی/دەزانێت"، "دەبێت/دەبن"، "بکە/بکەن". '
                . 'شێوەزاری تر تێکەڵ مەکە: ئەگەر بەکارهینەر ب بادینی پرسیار کرد، هەر ب سۆرانی وەڵام بدەرەوە. '
                . 'وشەی عەرەبی، فارسی یان تورکی بەکارمەهێنە کاتێک وشەی کوردی هەیە. '
                . 'بەر بەرسڤدانێ، خۆ ڕاست بکەرەوە: ئەڤ وەڵامە ب تەواوی سۆرانییە و هیچ وشەیەکی بادینی/کورمانجی یان بیانی تێدایە؟ ئەگەر نەخێر، وەڵامێ خۆ ب سۆرانی بنڤێسە. '
                . 'هەر کاتێک بە کوردی پرسیار کرایت، بە کوردی وەڵام بدەرەوە. وەڵامەکانت ڕوون و کورت و بەسوود بن. '
                . 'ئەگەر لە پرۆگرامسازی پرسیار کرابێت، نموونەی کۆد بدە و ڕوونی بکەرەوە.';

        if ($mode === 'grammar') {
            $base .= $lang === 'ba'
                ? ' نوکە تە دەبیت بۆ گەشتی ڕێزمان: دەقی کو بکارهینەر دانا، ڕاست بکەرەوە (ڕێزمان، ڕێنڤێسین، وشە) و پاشی ڕوون بکەرەوە چ گەشتی تێدا کرا، و پاشی دەقی ڕاستکراوی دا.'
                : ' ئێستا تۆ لە مۆدی چاککردنەوەی ڕێزمانیت: دەقەکەی بەکارهێنەر بکەرە بە باشی چاک بکەرەوە (ڕێزمان، ڕێنووس، وشە)، پاشان ڕوون بکەرەوە کە چ گۆڕانکارییەک کراوە، و لە کۆتاییدا دەقە چاککراوەکە بنووسە.';
        }

        return $base;
    }

    private function msg(?string $lang, string $key): string
    {
        $so = [
            'error' => 'ببورە، کێشەیەک ڕوویدا. دوای تروە هەوڵبدەرەوە.',
            'no_reply' => 'ببورە، نەمتوانی وەڵام بدەمەوە.',
            'config_missing' => 'ببورە، پێکهاتەکانی ڕاژەکار ئامادە نین.',
            'provider_quota' => 'ببورە، سنووری بەکارهێنانی ڕاژەکاری AI ئەمڕۆ پڕ بووەتەوە. دوای ٢٤ کاتژمێر دووبارە هەوڵبدەرەوە.',
        ];
        $ba = [
            'error' => 'ببورە، کێشەیەک ڕوویدا. پاشی دەمەکێ دیسا هەوڵبە.',
            'no_reply' => 'ببورە، نەشێیام بەرسڤ بدەمە تە.',
            'config_missing' => 'ببورە، پێکهاتێن ڕاژەکار ئامادە نینن.',
            'provider_quota' => 'ببورە، سنوورا بەکارئینانا ڕاژەکاری AI یا ئەڤرۆ پڕ بوویە. پاشی ٢٤ دەمژمێران دیسا هەوڵبە.',
        ];

        return ($lang === 'ba' ? $ba : $so)[$key] ?? $so['error'];
    }
}
