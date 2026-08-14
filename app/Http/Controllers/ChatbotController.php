<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Models\ChatUsage;
use App\Models\ChatUserProfile;
use App\Models\KnowledgeBase;
use App\Models\User;
use App\Services\FirebaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class ChatbotController extends Controller
{
    private const PRO_DAILY_LIMIT = 5;

    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'user_key' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|max:255',
            'user_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'lang' => 'nullable|in:so,ba',
            'image' => 'nullable|string|max:15000000',
            'file_name' => 'nullable|string|max:255',
            'file_content' => 'nullable|string|max:100000',
            'mode' => 'nullable|in:default,grammar,teach',
            'tier' => 'nullable|in:normal,pro',
        ]);

        $providers = $this->providers();

        if (!$providers) {
            Log::warning('AI provider config missing');
            return response()->json([
                'reply' => $this->msg($request->lang, 'config_missing'),
            ], 500);
        }

        $userKey = $request->input('user_key');
        $userEmail = $this->verifiedEmail($request);
        $userName = $this->verifiedName($request);
        $userId = $request->input('user_id');
        $lang = $this->resolveDialect($request->input('lang', 'so'), (string) $request->input('message', ''));
        $image = $request->input('image');
        $mode = $request->input('mode', 'default');
        $tier = $request->input('tier', 'normal');
        $profile = $this->responseProfile($request->message, $tier);
        $memoryContext = $this->userMemoryContext($userEmail);

        if ($tier === 'pro') {
            $quota = $this->proQuota($userEmail, $userKey);
            if (!$quota['allowed']) {
                return response()->json([
                    'reply' => $this->msg($lang, 'pro_limit'),
                    'pro_remaining' => 0,
                    'pro_limit' => self::PRO_DAILY_LIMIT,
                ], 429);
            }
        }

        $hasVision = false;
        foreach ($providers as $provider) {
            if (!empty($provider['vision_model'])) {
                $hasVision = true;
                break;
            }
        }

        if ($image && !$hasVision) {
            Log::warning('Vision model config missing');
            return response()->json([
                'reply' => $this->msg($request->lang, 'config_missing'),
            ], 500);
        }

        $isAdmin = false;
        try {
            $authUser = $request->user();
            if ($authUser) {
                $isAdmin = (bool) $authUser->is_admin;
            } elseif ($userId) {
                $user = User::find($userId);
                $isAdmin = $user && $user->is_admin;
            }
        } catch (Throwable $e) {
            Log::warning('Admin check failed; continuing as non-admin', ['error' => $e->getMessage()]);
        }
        if (in_array($userEmail, ['mahamadkamaran890@gmail.com', 'team@kurd-ai.com'], true)) {
            $isAdmin = true;
        }

        $system = $this->systemPrompt($lang, $mode, $tier);
        $system .= $memoryContext;

        if ($this->shouldRetrieveKnowledge((string) $request->message)) {
            try {
                $system = $this->withKnowledge($system, $request->message, $lang);
            } catch (Throwable $e) {
                Log::warning('Knowledge context failed; continuing without it', ['error' => $e->getMessage()]);
            }
        }

        $session = null;
        $sessionEnabled = false;

        if ($userKey) {
            try {
                if ($request->input('session_id')) {
                    $sessionQuery = ChatSession::where('id', $request->input('session_id'));
                    if ($userEmail) {
                        $sessionQuery->where('user_email', $userEmail);
                    } else {
                        $sessionQuery->where('user_key', $userKey);
                    }
                    $session = $sessionQuery->first();
                }
                if (!$session) {
                    $session = ChatSession::create([
                        'user_key' => $userKey,
                        'user_email' => $userEmail,
                        'title' => mb_substr($request->message, 0, 60),
                    ]);
                }
                if ($session && $userEmail && !$session->user_email) {
                    $session->forceFill(['user_email' => $userEmail])->save();
                }
                $sessionEnabled = true;
            } catch (Throwable $e) {
                Log::warning('Session persistence unavailable; continuing without session', ['error' => $e->getMessage()]);
                $session = null;
            }
        }

        $userText = $request->message;
        if ($request->input('file_name') && $request->input('file_content')) {
            $userText .= "\n\n--- فایل: " . $request->input('file_name') . " ---\n" . $request->input('file_content') . "\n--- کۆتایی فایلەکە ---";
        }

        if ($mode === 'teach') {
            if (!$isAdmin) return response()->json(['error' => 'Unauthorized'], 403);
            $reply = $this->saveTeachingInstruction($userEmail, $userText, $lang);
            $this->saveConversation($session, $userText, $reply, $userName);
            return response()->json(['reply' => $reply, 'session_id' => $session?->id, 'is_admin' => true]);
        }

        $historyMessages = [];
        if ($session) {
            try {
                $historyMessages = ChatHistory::where('session_id', $session->id)
                    ->whereIn('role', ['user', 'assistant'])
                    ->orderBy('id')
                    ->limit(6)
                    ->get()
                    ->map(fn ($h) => ['role' => $h->role, 'content' => $h->content])
                    ->toArray();
            } catch (Throwable $e) {
                Log::warning('Chat history unavailable; continuing without history', ['error' => $e->getMessage()]);
            }
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
        $plan = $this->attemptPlan($providers, $lang, $isVision, $tier);
        $allowedAttempts = 10;

        foreach ($plan as [$provider, $attemptModel]) {
            if (--$allowedAttempts <= 0) {
                break;
            }
            try {
                $response = Http::withToken($provider['key'])
                    ->connectTimeout(3)
                    ->timeout(40)
                    ->post($provider['base_url'] . '/chat/completions', [
                        'model' => $attemptModel,
                        'messages' => $apiMessages,
                        'temperature' => $profile['temperature'],
                        'max_tokens' => min($provider['max_tokens'] ?? 1200, $profile['max_tokens']),
                    ]);
            } catch (\Exception $e) {
                Log::warning('AI provider connection failed', [
                    'provider' => $provider['name'] ?? '?',
                    'model' => $attemptModel,
                    'error' => $e->getMessage(),
                ]);
                $this->markProviderDown($provider, 45);
                continue;
            }

            $lastStatus = $response->status();
            $lastBody = substr((string) $response->body(), 0, 500);

            if (!$response->failed()) {
                $reply = $response->json('choices.0.message.content') ?? $this->msg($lang, 'no_reply');
                if ($reply === '') {
                    Log::warning('AI provider empty reply', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                    ]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }
                if ($this->looksLikeGarbage($reply)) {
                    Log::warning('AI provider garbage reply', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                    ]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }
                $this->markProviderUp($provider);
                break;
            }

            Log::warning('AI provider attempt failed', [
                'provider' => $provider['name'] ?? '?',
                'model' => $attemptModel,
                'status' => $lastStatus,
                'body' => $lastBody,
            ]);

            if ($lastStatus === 429) {
                $this->markRateLimited($provider);
                continue;
            }

            $this->markProviderDown($provider, 30);
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

        if ($this->looksLikeGarbage($reply)) {
            Log::error('AI all providers returned garbage');
            return response()->json([
                'reply' => $this->msg($lang, 'error'),
            ], 502);
        }

        $proRemaining = null;
        if ($tier === 'pro') {
            $this->incrementProUsage($userEmail, $userKey);
            $proRemaining = $this->proQuota($userEmail, $userKey)['remaining'];
        }

        if ($session) {
            try {
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
                $this->rememberUser($session->user_email, $userText, $userName);
            } catch (Throwable $e) {
                Log::warning('Chat history save failed; reply still delivered', ['error' => $e->getMessage()]);
            }
        }

        return response()->json([
            'reply' => $reply,
            'session_id' => $session?->id,
            'is_admin' => $isAdmin,
            'pro_remaining' => $proRemaining,
        ]);
    }

    /**
     * وەڵامی ڕاستەوخۆ (SSE streaming) — بەکارهێنەر دەقی وەڵامەکە بە شێوەی زیندوو دەبینێت
     * کاتێک ڕاژەکارەکەی AI دەیهێنێت، نەک چاوەڕوانی وەڵامی تەواو بکات.
     */
    public function stream(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:4000',
            'user_key' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|max:255',
            'user_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'lang' => 'nullable|in:so,ba',
            'image' => 'nullable|string|max:15000000',
            'file_name' => 'nullable|string|max:255',
            'file_content' => 'nullable|string|max:100000',
            'mode' => 'nullable|in:default,grammar,teach',
            'tier' => 'nullable|in:normal,pro',
        ]);

        $providers = $this->providers();
        $lang = $this->resolveDialect($request->input('lang', 'so'), (string) $request->input('message', ''));
        $mode = $request->input('mode', 'default');
        $tier = $request->input('tier', 'normal');
        $userKey = $request->input('user_key');
        $userEmail = $this->verifiedEmail($request);
        $userName = $this->verifiedName($request);
        $profile = $this->responseProfile((string) $request->input('message', ''), $tier);
        $memoryContext = $this->userMemoryContext($userEmail);
        $userId = $request->input('user_id');
        $image = $request->input('image');
        $isVision = !empty($image);

        if ($tier === 'pro') {
            $quota = $this->proQuota($userEmail, $userKey);
            if (!$quota['allowed']) {
                return response()->json([
                    'reply' => $this->msg($lang, 'pro_limit'),
                    'pro_remaining' => 0,
                    'pro_limit' => self::PRO_DAILY_LIMIT,
                ], 429);
            }
        }

        if (!$providers) {
            Log::warning('AI provider config missing');
            return $this->jsonReply($request->lang, 'config_missing', 500);
        }

        if ($isVision) {
            $hasVision = false;
            foreach ($providers as $provider) {
                if (!empty($provider['vision_model'])) {
                    $hasVision = true;
                    break;
                }
            }
            if (!$hasVision) {
                Log::warning('Vision model config missing');
                return $this->jsonReply($request->lang, 'config_missing', 500);
            }
        }

        $isAdmin = false;
        try {
            $authUser = $request->user();
            if ($authUser) {
                $isAdmin = (bool) $authUser->is_admin;
            } elseif ($userId) {
                $user = User::find($userId);
                $isAdmin = $user && $user->is_admin;
            }
        } catch (Throwable $e) {
            Log::warning('Admin check failed; continuing as non-admin', ['error' => $e->getMessage()]);
        }
        if (in_array($userEmail, ['mahamadkamaran890@gmail.com', 'team@kurd-ai.com'], true)) {
            $isAdmin = true;
        }

        $system = $this->systemPrompt($lang, $mode, $tier);
        $system .= $memoryContext;
        if ($this->shouldRetrieveKnowledge((string) $request->message)) {
            try {
                $system = $this->withKnowledge($system, $request->message, $lang);
            } catch (Throwable $e) {
                Log::warning('Knowledge context failed; continuing without it', ['error' => $e->getMessage()]);
            }
        }

        $session = null;
        $sessionEnabled = false;

        if ($userKey) {
            try {
                if ($request->input('session_id')) {
                    $sessionQuery = ChatSession::where('id', $request->input('session_id'));
                    if ($userEmail) {
                        $sessionQuery->where('user_email', $userEmail);
                    } else {
                        $sessionQuery->where('user_key', $userKey);
                    }
                    $session = $sessionQuery->first();
                }
                if (!$session) {
                    $session = ChatSession::create([
                        'user_key' => $userKey,
                        'user_email' => $userEmail,
                        'title' => mb_substr($request->message, 0, 60),
                    ]);
                }
                if ($session && $userEmail && !$session->user_email) {
                    $session->forceFill(['user_email' => $userEmail])->save();
                }
                $sessionEnabled = true;
            } catch (Throwable $e) {
                Log::warning('Session persistence unavailable; continuing without session', ['error' => $e->getMessage()]);
                $session = null;
            }
        }

        $userText = $request->message;
        if ($request->input('file_name') && $request->input('file_content')) {
            $userText .= "\n\n--- فایل: " . $request->input('file_name') . " ---\n" . $request->input('file_content') . "\n--- کۆتایی فایلەکە ---";
        }

        if ($mode === 'teach') {
            if (!$isAdmin) return response()->json(['error' => 'Unauthorized'], 403);
            $reply = $this->saveTeachingInstruction($userEmail, $userText, $lang);
            $this->saveConversation($session, $userText, $reply, $userName);
            return response()->json(['reply' => $reply, 'session_id' => $session?->id, 'is_admin' => true]);
        }

        $historyMessages = [];
        if ($session) {
            try {
                $historyMessages = ChatHistory::where('session_id', $session->id)
                    ->whereIn('role', ['user', 'assistant'])
                    ->orderBy('id')
                    ->limit(6)
                    ->get()
                    ->map(fn ($h) => ['role' => $h->role, 'content' => $h->content])
                    ->toArray();
            } catch (Throwable $e) {
                Log::warning('Chat history unavailable; continuing without history', ['error' => $e->getMessage()]);
            }
        }

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

        return response()->stream(function () use ($providers, $lang, $apiMessages, $session, $userText, $userName, $isAdmin, $isVision, $profile, $tier, $userEmail, $userKey) {
            // دەروازەی ڕاژەکار (session) دەبەینەوە تاوەکو داواکارییە هاوکاتەکان نەوەستن.
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
            }

            $plan = $this->attemptPlan($providers, $lang, $isVision, $tier);
            $attempted = 0;

            foreach ($plan as [$provider, $attemptModel]) {
                if ($attempted >= 16) {
                    break;
                }
                $attempted++;

                try {
                    $upstream = Http::withToken($provider['key'])
                        ->withOptions(['stream' => true])
                    ->connectTimeout(3)
                    ->timeout(50)
                        ->post($provider['base_url'] . '/chat/completions', [
                            'model' => $attemptModel,
                            'messages' => $apiMessages,
                            'temperature' => $profile['temperature'],
                            'max_tokens' => min($provider['max_tokens'] ?? 1200, $profile['max_tokens']),
                            'stream' => true,
                        ]);
                } catch (\Exception $e) {
                    Log::warning('AI stream connection failed', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                        'error' => $e->getMessage(),
                    ]);
                    $this->markProviderDown($provider, 45);
                    continue;
                }

                if ($upstream->failed()) {
                    $status = $upstream->status();
                    $body = substr((string) $upstream->body(), 0, 300);
                    Log::warning('AI stream attempt failed', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                        'status' => $status,
                        'body' => $body,
                    ]);

                    if ($status === 429) {
                        $this->markRateLimited($provider);
                    } else {
                        $this->markProviderDown($provider, 30);
                    }
                    continue;
                }

                $this->markProviderUp($provider);

                $this->sseEvent('meta', [
                    'session_id' => $session?->id,
                    'is_admin' => $isAdmin,
                ]);
                $this->sseFlush();

                $full = '';
                $flushed = false;
                $streamStart = microtime(true);
                $bodyStream = $upstream->toPsrResponse()->getBody();
                $lineBuffer = '';

                try {
                    while (!$bodyStream->eof()) {
                        $chunk = $bodyStream->read(4096);
                        if ($chunk === '') {
                            usleep(20000);
                            if ($bodyStream->eof()) {
                                break;
                            }
                            continue;
                        }

                        $lineBuffer .= $chunk;

                        while (($pos = strpos($lineBuffer, "\n")) !== false) {
                            $line = trim(substr($lineBuffer, 0, $pos));
                            $lineBuffer = substr($lineBuffer, $pos + 1);

                            if (!str_starts_with($line, 'data:')) {
                                continue;
                            }

                            $payload = trim(substr($line, 5));
                            if ($payload === '' || $payload === '[DONE]') {
                                continue;
                            }

                            $json = json_decode($payload, true);
                            if (!is_array($json)) {
                                continue;
                            }

                            $delta = $json['choices'][0]['delta']['content']
                                ?? $json['choices'][0]['message']['content']
                                ?? null;
                            if (!is_string($delta) || $delta === '') {
                                continue;
                            }

                            $full .= $delta;
                            if (!$flushed) {
                                if ($this->shouldFlushPrefix($full, $streamStart)) {
                                    if ($this->looksLikeGarbage($full)) {
                                        $this->markProviderDown($provider, 30);
                                        continue 3;
                                    }
                                    $this->sseEvent('delta', ['text' => $full]);
                                    $this->sseFlush();
                                    $flushed = true;
                                }
                            } else {
                                $this->sseEvent('delta', ['text' => $delta]);
                                $this->sseFlush();
                            }
                        }
                    }

                    if (trim($lineBuffer) !== '') {
                        $line = trim($lineBuffer);
                        if (str_starts_with($line, 'data:')) {
                            $payload = trim(substr($line, 5));
                            if ($payload !== '' && $payload !== '[DONE]') {
                                $json = json_decode($payload, true);
                                if (is_array($json)) {
                                    $delta = $json['choices'][0]['delta']['content']
                                        ?? $json['choices'][0]['message']['content']
                                        ?? null;
                                    if (is_string($delta) && $delta !== '') {
                                        $full .= $delta;
                                        if (!$flushed) {
                                            if ($this->shouldFlushPrefix($full, $streamStart)) {
                                                if ($this->looksLikeGarbage($full)) {
                                                    $this->markProviderDown($provider, 30);
                                                    continue;
                                                }
                                                $this->sseEvent('delta', ['text' => $full]);
                                                $this->sseFlush();
                                                $flushed = true;
                                            }
                                        } else {
                                            $this->sseEvent('delta', ['text' => $delta]);
                                            $this->sseFlush();
                                        }
                                    }
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning('AI stream read failed', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                        'error' => $e->getMessage(),
                    ]);
                }

                if ($full === '') {
                    Log::warning('AI stream empty reply', ['provider' => $provider['name'] ?? '?', 'model' => $attemptModel]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }

                if (!$flushed && $this->looksLikeGarbage($full)) {
                    Log::warning('AI stream garbage reply', ['provider' => $provider['name'] ?? '?', 'model' => $attemptModel]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }

                $proRemaining = null;
                if ($tier === 'pro') {
                    $this->incrementProUsage($userEmail, $userKey);
                    $proRemaining = $this->proQuota($userEmail, $userKey)['remaining'];
                }

                $this->saveConversation($session, $userText, $full, $userName);

                $this->sseEvent('done', [
                    'reply' => $full,
                    'session_id' => $session?->id,
                    'is_admin' => $isAdmin,
                    'pro_remaining' => $proRemaining,
                ]);
                $this->sseFlush();

                return;
            }

            Log::error('AI stream providers error', ['attempted' => $attempted]);
            $this->sseEvent('error', [
                'reply' => $this->msg($lang, 'error'),
                'status' => 502,
            ]);
            $this->sseFlush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }

    /**
     * ناردنی ڕووداوێکی SSE بۆ بەکارهێنەر.
     */
    private function sseEvent(string $event, array $data): void
    {
        echo 'event: ' . $event . "\n";
        echo 'data: ' . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n\n";
    }

    /**
     * بەزۆری خوێندنەوەکانی نووسین دەداتەوە بۆ وێبگەڕ (دەبێت دەستبەجێ بگەیت).
     */
    private function sseFlush(): void
    {
        if (ob_get_level() > 0) {
            ob_flush();
        }
        flush();
    }

    /**
     * وەڵامی هەڵەی سادە بە JSON — بۆ دۆخەکانی پێش دەستپێکردنی streaming.
     */
    private function jsonReply(?string $lang, string $key, int $status = 500)
    {
        return response()->json([
            'reply' => $this->msg($lang, $key),
        ], $status);
    }

    private function saveTeachingInstruction(string $email, string $text, string $lang = 'so'): string
    {
        $text = trim($text);
        $title = mb_substr($text, 0, 100);
        $keywords = implode('، ', array_slice($this->knowledgeTokens($text), 0, 12));
        KnowledgeBase::create([
            'uid' => $email,
            'title' => 'فێرکردنی ئەدمین: ' . $title,
            'content' => $text,
            'keywords' => $keywords,
            'lang' => $lang === 'ba' ? 'ba' : 'so',
            'active' => true,
            'training' => null,
        ]);

        return 'تێبینییەکەت وەرگیرا و لە بنکەی زانیاری هەڵگیرا. لە وەڵامە داهاتووەکاندا بەکاری دەهێنم؛ ئەگەر وردەکارییەکی کەم بێت، لە چاتی ئاساییدا پرسیاری ڕوونکەرەوە دەکەم.';
    }

    /**
     * پلانی خێرا بۆ قەبارەی وەڵام — پرسیاری سادە کورتە، پرسیاری ئاڵۆز قوڵە.
     * مۆدێل هەموو بیرکردنەوەی ناوخۆیی ناداتە دەرەوە؛ تەنها ئەنجامی ڕێکخراو دەدات.
     */
    private function responseProfile(string $message, string $tier = 'normal'): array
    {
        $text = mb_strtolower(trim($message));
        $length = mb_strlen($text);
        $deepMarkers = [
            'شیکردنەوە', 'بەراورد', 'هەنگاو بە هەنگاو', 'ڕاپۆرت', 'وردەکاری',
            'بۆچی', 'چۆن کار دەکات', 'architecture', 'algorithm', 'debug',
            'تحلیل', 'موازنة', 'deep learning', 'neural', 'machine learning',
        ];
        $shortMarkers = ['کورت', 'بە کورتی', 'تەنها وەڵام', 'یەک ڕستە', 'چییە؟', 'مانای'];

        $result = ['max_tokens' => 600, 'temperature' => 0.5];

        foreach ($shortMarkers as $marker) {
            if (mb_strpos($text, $marker) !== false) {
                $result = ['max_tokens' => 500, 'temperature' => 0.35];
                break;
            }
        }

        if ($result['max_tokens'] === 600) {
            foreach ($deepMarkers as $marker) {
                if (mb_strpos($text, $marker) !== false) {
                    $result = ['max_tokens' => 1800, 'temperature' => 0.42];
                    break;
                }
            }
            if ($result['max_tokens'] === 600 && ($length > 500 || str_contains($text, '```'))) {
                $result = ['max_tokens' => 1400, 'temperature' => 0.48];
            }
        }

        if ($tier === 'pro') {
            if ($result['max_tokens'] < 1400) {
                $result['max_tokens'] = 1400;
            }
            $result['temperature'] = min($result['temperature'], 0.42);
        }

        return $result;
    }

    private function shouldRetrieveKnowledge(string $message): bool
    {
        $text = mb_strtolower(trim($this->normalizeKurdish($message)));
        if (mb_strlen($text) > 35) return true;
        foreach (['کۆد', 'فێربوون', 'ڕێزمان', 'بادینی', 'سۆرانی', 'کورد', 'مۆدێل', 'داتا', 'زانکۆ', 'پرس', 'چۆن'] as $marker) {
            if (mb_strpos($text, $marker) !== false) return true;
        }
        return false;
    }

    private function resolveDialect(?string $requested, string $message): string
    {
        $fallback = $requested === 'ba' ? 'ba' : 'so';
        $text = mb_strtolower($this->normalizeKurdish($message));
        $badini = ['ئەز', 'دکەم', 'دکەی', 'دکەت', 'دشێم', 'دشێی', 'دشێت', 'نوکە', 'ئەڤرۆ', 'چاوا', 'ب خۆشی', 'خودا حافز'];
        $sorani = ['من', 'دەکەم', 'دەکەیت', 'دەکات', 'دەتوانم', 'دەتوانیت', 'ئێستا', 'ئەمڕۆ', 'چۆن', 'بەخێربێیت', 'خواحافیز'];
        $baScore = 0;
        $soScore = 0;
        foreach ($badini as $word) if (mb_strpos($text, $word) !== false) $baScore++;
        foreach ($sorani as $word) if (mb_strpos($text, $word) !== false) $soScore++;

        if ($baScore >= 2 && $baScore > $soScore) return 'ba';
        if ($soScore >= 2 && $soScore > $baScore) return 'so';
        return $fallback;
    }

    private function normalizeKurdish(string $text): string
    {
        return strtr($text, [
            'ي' => 'ی', 'ى' => 'ی', 'ك' => 'ک', 'ۀ' => 'ە', 'ة' => 'ە',
            'ؤ' => 'ۆ', 'إ' => 'ئ', 'أ' => 'ئا', 'ـ' => '',
        ]);
    }

    private function verifiedEmail(Request $request): ?string
    {
        return $this->verifiedIdentity($request)['email'] ?? null;
    }

    private function verifiedName(Request $request): ?string
    {
        return $this->verifiedIdentity($request)['name'] ?? null;
    }

    private function verifiedIdentity(Request $request): array
    {
        $token = (string) ($request->header('X-Firebase-Id-Token') ?: $request->bearerToken());
        if ($token === '') return [];

        return Cache::remember('firebase.identity.' . hash('sha256', $token), now()->addMinutes(5), function () use ($token) {
            try {
                $user = $this->firebase->verifyIdTokenRest($token);
                if (!$user) {
                    $payload = $this->firebase->verifyIdToken($token);
                    return [
                        'email' => !empty($payload['email']) ? strtolower(trim($payload['email'])) : null,
                        'name' => !empty($payload['name']) ? trim($payload['name']) : null,
                    ];
                }
                return [
                    'email' => !empty($user['email']) ? strtolower(trim($user['email'])) : null,
                    'name' => !empty($user['name']) ? trim($user['name']) : null,
                ];
            } catch (Throwable) {
                return [];
            }
        });
    }

    /**
     * پلانی هەوڵدان: ڕاژەکارەکان بە شێوەی ئاسۆیی تێکەڵ دەکات — یەکەم مۆدێلی هەر
     * ڕاژەکارێک، پاشان دووەم و سێیەم — تاوەکو لە یەکەم داواکاریدا زۆرترین جۆراوجۆری
     * هەبێت و نەگەینە کۆتایی ڕاژەکارەکانی بەدەر لە پێکهاتە. ژمارەی هەوڵەکان سنووردارە.
     */
    private function attemptPlan(array $providers, string $lang, bool $isVision, string $tier = 'normal'): array
    {
        $health = $this->providerHealth();
        $now = time();

        $healthy = [];
        $downed = [];
        $maxLen = 0;

        foreach ($this->sortProviders($providers, $lang) as $p) {
            $chain = $this->modelChain($p, $lang, $isVision, $tier);
            if (!$chain) {
                continue;
            }
            $h = $health[$this->providerKey($p)] ?? null;
            if ((int) ($h['down_until'] ?? 0) > $now) {
                $downed[] = ['p' => $p, 'chain' => $chain];
            } else {
                $healthy[] = ['p' => $p, 'chain' => $chain];
            }
            $maxLen = max($maxLen, count($chain));
        }

        // سەرەتا ساغەکان، پاشان ئەوانەی بە کاتییەتی "down" نیشانکراون وەک پەناگەی کۆتایی —
        // بەم شێوەیە هەرگیز هەموو پلانەکە بەتاڵ نابێتەوە.
        $chains = array_merge($healthy, $downed);

        // پلانی بەرفرەھ: یەکەم مۆدێلی هەموو ڕاژەکارەکان، پاشان دووەم، پاشان سێیەم...
        // ئەگەر کلیدێک سەرکەوتوو نەبوو، ڕاستەوخۆ ڕوو لە کلیدی دیکە دەکات.
        $plan = [];
        for ($i = 0; $i < $maxLen; $i++) {
            foreach ($chains as $c) {
                if (isset($c['chain'][$i])) {
                    $plan[] = [$c['p'], $c['chain'][$i]];
                }
            }
        }

        return array_slice($plan, 0, 16);
    }

    /**
     * زنجیرەی مۆدێلەکان بۆ ڕاژەکارێک (لەگەڵ مۆدێلی بینایی ئەگەر پێویست بێت).
     * تایری پڕۆ ڕاژەکارێکی بەهێزتر بەکاردەهێنێت لەگەڵ بەرگری لە ڕاژەکارە ئاساییەکان.
     */
    private function modelChain(array $p, string $lang, bool $isVision, string $tier = 'normal'): array
    {
        if ($tier === 'pro') {
            $chain = array_values(array_unique(array_filter([
                $p['pro_model'] ?? null,
                $p['pro_fallback_model'] ?? null,
                $p['fallback_model'] ?? null,
                $p['fallback_model2'] ?? null,
                $p['model'] ?? null,
            ])));
        } else {
            $chain = $lang === 'ba' && !empty($p['badini_models'])
                ? $p['badini_models']
                : array_values(array_unique(array_filter([$p['model'], $p['fallback_model'] ?? null, $p['fallback_model2'] ?? null])));
        }

        if ($isVision) {
            $chain = array_values(array_unique(array_filter(array_merge([$p['vision_model'] ?? null], $chain))));
        }

        return $chain;
    }

    /**
     * پاراستنی وەڵامەکە لە مێژووی گفتوگۆدا (ئەگەر دانیشتن هەبێت).
     */
    private function saveConversation(?ChatSession $session, string $userText, string $reply, ?string $userName = null): void
    {
        if (!$session) {
            return;
        }
        try {
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
            $this->rememberUser($session->user_email, $userText, $userName);
        } catch (Throwable $e) {
            Log::warning('Chat history save failed; reply still delivered', ['error' => $e->getMessage()]);
        }
    }

    private function userMemoryContext(?string $email): string
    {
        if (!$email) return '';
        try {
            $memory = ChatUserProfile::where('user_email', $email)->first();
            if (!$memory) return '';
            $topics = collect($memory->topics ?? [])->sortDesc()->take(8)->keys()->implode('، ');
            $lang = $memory->preferred_lang === 'ba' ? 'بادینی' : ($memory->preferred_lang === 'so' ? 'سۆرانی' : 'دیارینەکراو');
            if ($topics === '' && !$memory->style) return '';
            $name = trim((string) ($memory->display_name ?? ''));
            $recent = ChatHistory::query()
                ->whereHas('session', fn ($query) => $query->where('user_email', $email))
                ->latest('id')
                ->limit(6)
                ->get(['role', 'content'])
                ->reverse()
                ->map(fn ($message) => ($message->role === 'user' ? 'بەکارهێنەر: ' : 'یاریدەدەر: ') . mb_substr($message->content, 0, 700))
                ->implode("\n");
            return "\n\nتێبینیی یارمەتیدەر بۆ ئەم بەکارهێنەرە: ناو: {$name}؛ شێوەزارێکی زۆر بەکارهاتوو: {$lang}؛ بابەتە دووبارەبووەکان: {$topics}.\nیادەوەریی کورت لە گفتوگۆی پێشوو:\n{$recent}\nئەم تێبینییە تەنها بۆ گونجاندنی وەڵامە؛ هیچ شتێک بە دڵنیایی لەسەر بەکارهێنەر مەهەڵسەنگێنە و ئەگەر پرسیاری نوێ جیاواز بوو، پەیڕەوی پرسیارە نوێیەکە بکە.";
        } catch (Throwable) {
            return '';
        }
    }

    private function rememberUser(?string $email, string $text, ?string $name = null): void
    {
        if (!$email) return;
        try {
            $name = $name ?: $this->extractIntroducedName($text);
            $profile = ChatUserProfile::firstOrCreate($email ? ['user_email' => $email] : [], [
                'display_name' => $name,
                'preferred_lang' => null,
                'topics' => [],
                'style' => [],
            ]);
            if ($name && $profile->display_name !== $name) $profile->display_name = $name;
            $topics = $profile->topics ?? [];
            preg_match_all('/[\p{L}\p{N}]{3,}/u', mb_strtolower($this->normalizeKurdish($text)), $matches);
            $stop = ['لە', 'بۆ', 'کە', 'ئەو', 'ئەم', 'من', 'تۆ', 'چی', 'چۆن', 'دەکات', 'دەمەوێت'];
            foreach ($matches[0] ?? [] as $word) {
                if (in_array($word, $stop, true)) continue;
                $topics[$word] = min(99, ((int) ($topics[$word] ?? 0)) + 1);
            }
            $profile->topics = collect($topics)->sortDesc()->take(40)->all();
            $profile->preferred_lang = $this->resolveDialect(null, $text);
            $profile->style = ['average_length' => mb_strlen($text) > 300 ? 'long' : 'short'];
            $profile->save();
        } catch (Throwable $e) {
            Log::notice('User chat memory update skipped', ['error' => $e->getMessage()]);
        }
    }

    private function extractIntroducedName(string $text): ?string
    {
        $patterns = [
            '/(?:ناوم|ناوی من)\s+([\p{L}][\p{L}\s]{1,45})/u',
            '/(?:من)\s+([\p{L}][\p{L}\s]{1,35})(?:م|مە|مـ)?(?:\s|$)/u',
        ];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, trim($text), $match)) {
                $name = trim(preg_replace('/\s+/u', ' ', $match[1]));
                $name = trim($name, " .،,؛؟?!");
                if (mb_strlen($name) >= 2 && mb_strlen($name) <= 50) return $name;
            }
        }
        return null;
    }

    /**
     * ئەگەر زانیاری تایبەتی ئەدمین هەیە و پەیوەندی بە پرسیارەکە هەیە، بۆ سیستەم-پرۆمپت دەخاتەوە.
     */
    private function withKnowledge(string $system, string $query, string $lang): string
    {
        $context = $this->knowledgeContext($query, $lang);

        return $context === '' ? $system : $system . "\n\n" . $context;
    }

    /**
     * بەندە چالاکەکانی knowledge_base دەهێنێتەوە، بەپێی ئەو بەشانەشی
     * هاوشێوەی وشەی پرسیارەکەن ڕیز دەکات، و بۆ سیستەم-پرۆمپت فۆرمات دەکات.
     */
    private function knowledgeContext(string $query, string $lang): string
    {
        $cacheKey = 'kurdai.knowledge.active.' . $lang . '.v1';
        $items = Cache::get($cacheKey);
        if ($items === null) {
            try {
                $items = KnowledgeBase::query()
                    ->where('active', true)
                    ->whereNotNull('content')
                    ->where('content', '!=', '')
                    ->where(function ($q) use ($lang) {
                        $q->whereNull('lang')->orWhere('lang', $lang);
                    })
                    ->latest('updated_at')
                    ->limit(50)
                    ->get();
                Cache::put($cacheKey, $items, now()->addSeconds(45));
            } catch (Throwable $e) {
                Log::warning('Knowledge context unavailable; continuing without it', ['error' => $e->getMessage()]);
                $items = collect();
                Cache::put($cacheKey, $items, now()->addSeconds(10));
            }
        }

        if ($items->isEmpty()) {
            return '';
        }

        $queryTokens = $this->knowledgeTokens($query);

        // پلەدانانی خێرا بەپێی ناونیشان و کلیلی وشان (نرخەکەش هەرگیز لە کۆی گشتی ناکەوێت) —
        // تەنها بۆ ١٢ دانەی باشترین، ناوەڕۆک دەتوکنرێتەوە کە خێراترە.
        $top = $items->map(function (KnowledgeBase $item) use ($queryTokens) {
            $titleTokens = $this->knowledgeTokens($item->title);
            $keywordTokens = $this->knowledgeTokens($item->keywords ?? '');

            $score = 0;
            foreach ($queryTokens as $t) {
                if (in_array($t, $titleTokens, true)) {
                    $score += 3;
                }
                if (in_array($t, $keywordTokens, true)) {
                    $score += 2;
                }
            }

            return ['item' => $item, 'score' => $score];
        })->filter(fn ($s) => $s['score'] > 0)
            ->sortByDesc('score')
            ->take(12);

        $scored = $top->map(function ($entry) use ($queryTokens) {
            $item = $entry['item'];
            $score = $entry['score'];
            $contentTokens = $this->knowledgeTokens($item->content);

            foreach ($queryTokens as $t) {
                if (in_array($t, $contentTokens, true)) {
                    $score += 1;
                }
            }

            return ['item' => $item, 'score' => $score];
        })->filter(fn ($s) => $s['score'] > 0)
            ->sortByDesc('score')
            ->take(3);

        if ($scored->isEmpty()) {
            $scored = $items->sortByDesc('updated_at')
                ->take(2)
                ->map(fn (KnowledgeBase $item) => ['item' => $item, 'score' => 0]);
        }

        $limit = 6000;
        $parts = [];
        $used = 0;

        foreach ($scored as $entry) {
            $item = $entry['item'];
            $text = 'ناونیشان: ' . $item->title . "\n" . $item->content;
            $length = mb_strlen($text);

            if ($length > 3000) {
                $text = mb_substr($text, 0, 3000) . '…';
                $length = 3000;
            }

            if ($used + $length > $limit) {
                break;
            }

            $parts[] = $text;
            $used += $length;
        }

        if (!$parts) {
            return '';
        }

        $heading = $lang === 'ba'
            ? '### زانیاریێن تایبەت یێن پلاتفۆرمێ (دانەدانا ئەدمین):'
            : '### زانیاری تایبەتی پلاتفۆرم (لەلایەن ئەدمینەوە دانراوە):';

        $instruction = $lang === 'ba'
            ? 'ئەڤ زانیارییە پەیوەندی بە کورد ئەی ئای و خزمەتێن وێ هەیە. ئەگەر پرسیارا بەکارهینەری پەیوەندی پێ گێتی، تەنها ژ ئەڤ زانیارییانە وەڵام بدە و ڕەنگا لەسەر بەرسڤاندا بەکارئینە. ئەگەر پەیوەندی پێ نەگێتی، ئەڤ زانیارییە بەکارئینە. قەت مەبێژە کە ئەڤ زانیارییە ب تە هاتینە دان.'
            : 'ئەم زانیارییانە پەیوەندیان بە کورد ئەی ئای و خزمەتەکانییەوە هەیە. ئەگەر پرسیارەکەی بەکارهێنەر پەیوەندی بەم زانیارییانەوە هەبوو، تەنها لەم زانیارییانەوە وەڵام بدەرەوە و پشتی پێ ببەستە. ئەگەر پەیوەندی نەبوو، ئەم زانیارییانە بەکارمەهێنە. هەرگیز باسی مەکە کە ئەم زانیارییانە بۆتە پێدراو.';

        return $heading . "\n\n" . $instruction . "\n\n" . implode("\n\n---\n\n", $parts);
    }

    /**
     * وشەکانی دەقەکە لە کردارە وشە بچووکەکان جیا دەکاتەوە بۆ پلەدانانی پەیوەندی.
     */
    private function knowledgeTokens(?string $text): array
    {
        if ($text === null || trim($text) === '') {
            return [];
        }

        $text = $this->normalizeKurdish($text);
        preg_match_all('/[\p{L}\p{N}]+/u', mb_strtolower($text), $matches);
        $words = $matches[0] ?? [];

        $stop = [
            'دەربارەی', 'بۆ', 'لە', 'وە', 'کە', 'و', 'ی', 'ئە', 'بو', 'با', 'بە',
            'هەر', 'ئەم', 'ئەو', 'ئێمە', 'ئێوە', 'تۆ', 'من', 'دەکات', 'دەکەم', 'دەکەیت',
            'چۆن', 'چی', 'ئێستا', 'هەیە', 'هەیەت', 'نییە', 'بکە', 'بدە', 'دەبێت',
        ];

        return array_values(array_unique(array_filter(
            $words,
            fn ($w) => mb_strlen($w) > 1 && !in_array($w, $stop, true)
        )));
    }

    /**
     * ناردنی ناوەڕۆک بۆ ڕاژەکاری AI (بەهەمان زنجیرەی ڕاژەکارەکانی چات) و
     * گەڕاندنەوەی وەڵامەکە وەک دەق. بۆ پرسیاری ڕوونکەرەوەی زانیاری ئەدمین بەکاردێت.
     */
    public function aiCompletion(array $messages, string $lang = 'so'): ?string
    {
        $providers = $this->providers();

        if (!$providers) {
            return null;
        }

        $response = null;
        $plan = $this->attemptPlan($providers, $lang, false);

        foreach ($plan as [$provider, $attemptModel]) {
            try {
                $response = Http::withToken($provider['key'])
                    ->timeout(45)
                    ->post($provider['base_url'] . '/chat/completions', [
                        'model' => $attemptModel,
                        'messages' => $messages,
                        'temperature' => 0.4,
                        'max_tokens' => $provider['max_tokens'] ?? 1200,
                    ]);
            } catch (\Exception $e) {
                Log::warning('AI completion connection failed', [
                    'provider' => $provider['name'] ?? '?',
                    'model' => $attemptModel,
                    'error' => $e->getMessage(),
                ]);
                $this->markProviderDown($provider, 45);
                continue;
            }

            if (!$response->failed()) {
                $content = $response->json('choices.0.message.content');
                if (!is_string($content) || $content === '') {
                    Log::warning('AI completion empty reply', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                    ]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }
                if ($this->looksLikeGarbage($content)) {
                    Log::warning('AI completion garbage reply', [
                        'provider' => $provider['name'] ?? '?',
                        'model' => $attemptModel,
                    ]);
                    $this->markProviderDown($provider, 30);
                    continue;
                }
                $this->markProviderUp($provider);
                break;
            }

            Log::warning('AI completion attempt failed', [
                'provider' => $provider['name'] ?? '?',
                'model' => $attemptModel,
                'status' => $response->status(),
                'body' => substr((string) $response->body(), 0, 500),
            ]);

            if ($response->status() === 429) {
                $this->markRateLimited($provider);
                continue;
            }

            $this->markProviderDown($provider, 30);
        }

        if (!$response || $response->failed()) {
            return null;
        }

        return $response->json('choices.0.message.content');
    }

    private function configDir(): ?string
    {
        $candidates = [
            dirname(__DIR__, 3) . '/storage/app/ai',
            (getenv('USERPROFILE') ?: ($_SERVER['USERPROFILE'] ?? null)) . '/.config/kurd-ai',
            (getenv('HOME') ?: ($_SERVER['HOME'] ?? null)) . '/.config/kurd-ai',
        ];
        foreach ($candidates as $candidate) {
            if ($candidate && is_dir($candidate)) {
                return $candidate;
            }
        }
        return null;
    }

    /**
     * تەندروستی ڕاژەکارەکان لە فایلێکدا (بەبێ داتابەیس) هەڵدەگرین —
     * ڕاژەکارە شکاوەکان بۆ ماوەیەکی کورت لە پێشەوە ناهێنرێن تا بەخێرایی
     * بگەینە ڕاژەکارێکی ساغ. بەم شێوەیە چات خێرا و پشتگیری دەمێنێتەوە.
     */
    private function healthFile(): ?string
    {
        $dir = $this->configDir();
        return $dir ? $dir . '/provider_health.json' : null;
    }

    private function providerHealth(): array
    {
        $file = $this->healthFile();
        if (!$file || !is_readable($file)) {
            return [];
        }
        $raw = json_decode((string) file_get_contents($file), true);
        return is_array($raw) ? $raw : [];
    }

    private function saveProviderHealth(array $health): void
    {
        $file = $this->healthFile();
        if (!$file) {
            return;
        }
        try {
            @file_put_contents($file, json_encode($health), LOCK_EX);
        } catch (Throwable $e) {
            Log::warning('Provider health write failed', ['error' => $e->getMessage()]);
        }
    }

    private function providerKey(array $p): string
    {
        return md5(($p['base_url'] ?? '') . '|' . ($p['key'] ?? '') . '|' . ($p['name'] ?? ''));
    }

    private function markProviderDown(array $p, int $seconds): void
    {
        $health = $this->providerHealth();
        $health[$this->providerKey($p)] = [
            'name' => $p['name'] ?? '?',
            'down_until' => time() + $seconds,
            'at' => time(),
        ];
        $this->saveProviderHealth($health);
    }

    /**
     * بۆ 429: OpenRouter ی فری-tier سنوورەکەی خێرا دەگەڕێتەوە (٦٠ چرکە)،
     * بەڵام InferX کۆتایەکەی ڕاستەقینەیە (١٠ خولەک دووبارە تاقی بکەرەوە).
     */
    private function markRateLimited(array $p): void
    {
        $seconds = str_contains($p['base_url'] ?? '', 'openrouter') ? 60 : 600;
        $this->markProviderDown($p, $seconds);
    }

    /**
     * وەڵامێک "گاربەیش"ە ئەگەر ڕێژەیەکی زۆر لە پیتەکانی لە سکریپتی
     * عەرەبی/لاتین/ئینگلیزی دەرچوون (وەک بەنگالی، دیڤاناگاری، چینی...).
     */
    private function looksLikeGarbage(string $text): bool
    {
        $len = mb_strlen($text);
        if ($len < 8) {
            return false;
        }
        $clean = preg_replace('/[\p{Script=Arabic}\p{Script=Latin}\p{Script=Common}\p{Z}]/u', '', $text);
        if ($clean === null || $clean === '') {
            return false;
        }
        return (mb_strlen($clean) / $len) > 0.3;
    }

    /**
     * ئایا ناوەڕۆکە کۆکراوەکە بەسە بۆ دەستپێکردنی گواستنەوە؟ (٦٠ پیت،
     * یان پاش ٦ چرکە ئەگەر ٨ پیت هەبێت) — بۆ وەستاندنی گاربەیش لە سەرەتاوە.
     */
    private function shouldFlushPrefix(string $full, float $start): bool
    {
        $len = mb_strlen($full);
        return $len >= 60 || (microtime(true) - $start > 6 && $len >= 8);
    }

    private function markProviderUp(array $p): void
    {
        $health = $this->providerHealth();
        $k = $this->providerKey($p);
        if (isset($health[$k])) {
            unset($health[$k]);
            $this->saveProviderHealth($health);
        }
    }

    /**
     * ڕیزکردنی ڕاژەکارەکان: سەرەتا ساغەکان، پاشان شکاوەکان، و
     * لە ناوەوە بەپێی badini_priority (ئەگەر زمان بادینی بێت).
     */
    private function sortProviders(array $providers, string $lang): array
    {
        $health = $this->providerHealth();
        $now = time();
        $rotation = (int) ($health['__rotation'] ?? 0);
        if (count($providers) > 0) {
            $health['__rotation'] = ($rotation + 1) % count($providers);
            $this->saveProviderHealth($health);
        }

        $ranked = [];
        foreach ($providers as $i => $p) {
            $h = $health[$this->providerKey($p)] ?? null;
            $downUntil = (int) ($h['down_until'] ?? 0);
            $ranked[] = [
                'p' => $p,
                'down' => $downUntil > $now ? 1 : 0,
                'prio' => (int) ($p['priority'] ?? 0),
                'badini' => $lang === 'ba' ? (int) ($p['badini_priority'] ?? 999) : 0,
                'rotation' => ($i - $rotation + count($providers)) % max(1, count($providers)),
                'i' => $i,
            ];
        }

        usort($ranked, function ($a, $b) use ($lang) {
            if ($a['down'] !== $b['down']) {
                return $a['down'] <=> $b['down'];
            }
            if ($a['prio'] !== $b['prio']) {
                return $b['prio'] <=> $a['prio'];
            }
            if ($lang === 'ba' && $a['badini'] !== $b['badini']) {
                return $a['badini'] <=> $b['badini'];
            }
            if ($a['rotation'] !== $b['rotation']) {
                return $a['rotation'] <=> $b['rotation'];
            }
            return $a['i'] <=> $b['i'];
        });

        return array_column($ranked, 'p');
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
            return $this->envValue((string) $p['api_key_env']) ?: null;
        }

        if (!empty($p['no_key'])) {
            return 'no-key';
        }

        return null;
    }

    private function envValue(string $name): ?string
    {
        $value = env($name);
        if ($value !== null && $value !== false && $value !== '') {
            return (string) $value;
        }

        $file = dirname(__DIR__, 2) . '/.env';
        if (!is_readable($file)) {
            return null;
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (!$lines) {
            return null;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }
            [$key, $val] = explode('=', $line, 2);
            if (trim($key) !== $name) {
                continue;
            }
            $val = trim($val);
            if (strlen($val) >= 2 && (
                (str_starts_with($val, '"') && str_ends_with($val, '"')) ||
                (str_starts_with($val, "'") && str_ends_with($val, "'"))
            )) {
                $val = substr($val, 1, -1);
            }
            return $val !== '' ? $val : null;
        }

        return null;
    }

    private function systemPrompt(string $lang, string $mode, string $tier = 'normal'): string
    {
        $base = $lang === 'ba'
            ? 'تۆ یاریدەدەری ژیری دەستکردی کورد ئەی ئای (Kurd AI) ی ب شێوەزاری بادینی. هەمی وەڵامێن تە ب بادینی بن، نەک سۆرانی. وشەیێن سۆرانی مەبێژە: "بەخێربێیت"→"بەخێر هاتی"، "دەتوانیت"→"دشێی"، "ئێستا"→"نوکە"، "چۆن"→"چاوا". فەرمێن کردار: دکەم/دکەی/دکەت. ئەگەر پرسا کێ تە چێکر، بڵێ: "ئەز ژ لایێ تیمێ کورد ئەی ئای ڤە هاتیمە چێکرن." ناڤێن ڕاژەکاران مەبێژە. وەڵامێن کورت و ب سوود بدە.'
            : 'تۆ یاریدەدەری ژیری دەستکردی کورد ئەی ئای (Kurd AI) ی ب شێوەزاری سۆرانی. هەمی وەڵامێن تە ب سۆرانی بن. وشەیێن بادینی مەبێژە: "دتوانم"→"دەتوانم"، "چاوا"→"چۆن"، "ئەڤرۆ"→"ئەمڕۆ". فەرمێن کردار: دەکەم/دەکەیت/دەکات. ئەگەر پرسا کێ تە دروست کرد، بڵێ: "من لەلایەن تیمی کورد ئەی ئای دروستکراوم." ناوی ڕاژەکاران مەڵێ. وەڵامێن کورت و ب سوود بدە.';

        if ($mode === 'grammar') {
            $base .= $lang === 'ba'
                ? ' نوکە تە دەبیت بۆ گەشتی ڕێزمان: دەقی کو بکارهینەر دانا، ڕاست بکەرەوە (ڕێزمان، ڕێنڤێسین، وشە) و پاشی ڕوون بکەرەوە چ گەشتی تێدا کرا، و پاشی دەقی ڕاستکراوی دا.'
                : ' ئێستا تۆ لە مۆدی چاککردنەوەی ڕێزمانیت: دەقەکەی بەکارهێنەر بکەرە بە باشی چاک بکەرەوە (ڕێزمان، ڕێنووس، وشە)، پاشان ڕوون بکەرەوە کە چ گۆڕانکارییەک کراوە، و لە کۆتاییدا دەقە چاککراوەکە بنووسە.';
        }

        if ($tier === 'pro') {
            $base .= $lang === 'ba'
                ? ' نوکە تۆ مۆدێلا پێشکەفتویا پڕۆ یا کورد ئەی ئای (KURD AI Pro) یی: بەرسڤێن تە دڤێت قوڵتر و وردەکاریتر بن — پاشخان ڕوون بکە، گاڤ ب گاڤ چارەسەر بکە، نموونە و بەراڤێ بدە، و چارەسەرێکا ڕێکخستى بدە. قەت بەرسڤێن کورت و خالیک مەدە.'
                : ' ئێستا تۆ مۆدێلی پێشکەوتووی پڕۆ ی کورد ئەی ئایت (KURD AI Pro): وەڵامەکانت قوڵتر و وردەکاریتر دەبێت — پاشبنەما ڕوون بکەرەوە، هەنگاو بە هەنگاو شیکاری بکە، نموونە و بەراورد بدە، و وەڵامێکی ڕێکخراو بدەرەوە. هەرگیز وەڵامی کورت و بەڕوو مەدەرەوە.';
        }

        return $base;
    }

    private function proUsageKey(?string $email, ?string $userKey): string
    {
        $email = $email ? mb_strtolower(trim($email)) : '';
        return $email !== '' ? 'email:' . $email : 'key:' . ($userKey ?: 'anon');
    }

    private function proQuota(?string $email, ?string $userKey): array
    {
        $date = now()->toDateString();
        try {
            $row = ChatUsage::firstOrCreate(
                ['user_key' => $this->proUsageKey($email, $userKey), 'usage_date' => $date],
                ['count' => 0]
            );
            $remaining = max(0, self::PRO_DAILY_LIMIT - (int) $row->count);
            return ['allowed' => $remaining > 0, 'remaining' => $remaining, 'limit' => self::PRO_DAILY_LIMIT];
        } catch (Throwable $e) {
            Log::warning('Pro quota check failed; allowing request', ['error' => $e->getMessage()]);
            return ['allowed' => true, 'remaining' => self::PRO_DAILY_LIMIT, 'limit' => self::PRO_DAILY_LIMIT];
        }
    }

    private function incrementProUsage(?string $email, ?string $userKey): void
    {
        $date = now()->toDateString();
        try {
            $row = ChatUsage::firstOrCreate(
                ['user_key' => $this->proUsageKey($email, $userKey), 'usage_date' => $date],
                ['count' => 0]
            );
            $row->increment('count');
        } catch (Throwable $e) {
            Log::warning('Pro usage increment failed', ['error' => $e->getMessage()]);
        }
    }

    public function quota(Request $request)
    {
        $userEmail = $this->verifiedEmail($request);
        $userKey = (string) $request->input('user_key', '');
        return response()->json([
            'pro_limit' => self::PRO_DAILY_LIMIT,
            'pro_remaining' => $this->proQuota($userEmail, $userKey)['remaining'],
        ]);
    }

    private function msg(?string $lang, string $key): string
    {
        $so = [
            'error' => 'ببورە، کێشەیەک ڕوویدا. دوای تروە هەوڵبدەرەوە.',
            'no_reply' => 'ببورە، نەمتوانی وەڵام بدەمەوە.',
            'config_missing' => 'ببورە، پێکهاتەکانی ڕاژەکار ئامادە نین.',
            'provider_quota' => 'ببورە، سنووری بەکارهێنانی ڕاژەکاری AI ئەمڕۆ پڕ بووەتەوە. دوای ٢٤ کاتژمێر دووبارە هەوڵبدەرەوە.',
            'pro_limit' => 'ببورە، سنووری ئەمڕۆی پڕۆ تەواو بووە (٥ پەیام بۆ هەر ئیمێلێک). سبەی دووبارە هەوڵبدەرەوە یان لە مۆدی ئاسایی بەکاری بهێنە.',
        ];
        $ba = [
            'error' => 'ببورە، کێشەیەک ڕوویدا. پاشی دەمەکێ دیسا هەوڵبە.',
            'no_reply' => 'ببورە، نەشێیام بەرسڤ بدەمە تە.',
            'config_missing' => 'ببورە، پێکهاتێن ڕاژەکار ئامادە نینن.',
            'provider_quota' => 'ببورە، سنوورا بەکارئینانا ڕاژەکاری AI یا ئەڤرۆ پڕ بوویە. پاشی ٢٤ دەمژمێران دیسا هەوڵبە.',
            'pro_limit' => 'ببورە، سنوورا ئەڤرۆ یا پرۆ تەمام بوویە (٥ پەیام بۆ هەر ئیمەیلاکێ). سبەهێ دیسا هەوڵبە یان د مۆدا ئاسایی دا بکارئینە.',
        ];

        return ($lang === 'ba' ? $ba : $so)[$key] ?? $so['error'];
    }
}
