<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Services\FirebaseAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ChatAnalyticsController extends Controller
{
    private const OWNER_EMAIL = 'mahamadkamaran890@gmail.com';

    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    public function page()
    {
        return view('chat_analytics');
    }

    public function data(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);
        if (!$user || strtolower((string) ($user['email'] ?? '')) !== self::OWNER_EMAIL) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $sessions = ChatSession::query()
            ->orderByDesc('updated_at')
            ->limit(500)
            ->get(['id', 'title', 'user_key', 'user_email', 'created_at', 'updated_at']);
        $sessionIds = $sessions->pluck('id');
        $messages = $sessionIds->isEmpty()
            ? collect()
            : ChatHistory::query()->whereIn('session_id', $sessionIds)->orderBy('id')->get(['session_id', 'role', 'content', 'created_at']);
        $userMessages = $messages->where('role', 'user');

        $perSessionUserCount = $messages->where('role', 'user')->countBy('session_id');

        $users = $sessions->groupBy(function (ChatSession $session) {
            return $session->user_email ?: ($session->user_key ?: 'نەناسراو');
        })->map(function ($group) use ($perSessionUserCount) {
            $first = $group->first();
            return [
                'identity' => $first->user_email ?: $first->user_key,
                'email' => $first->user_email,
                'user_key' => $first->user_key,
                'sessions' => $group->count(),
                'messages' => $group->sum(fn (ChatSession $session) => (int) ($perSessionUserCount[$session->id] ?? 0)),
                'last_activity' => $group->max('updated_at')?->format('Y-m-d H:i'),
            ];
        })->sortByDesc('messages')->values();

        $conversations = $sessions->map(function (ChatSession $session) use ($messages) {
            return [
                'id' => $session->id,
                'email' => $session->user_email,
                'user_key' => $session->user_key,
                'title' => $session->title,
                'created_at' => $session->created_at?->format('Y-m-d H:i'),
                'updated_at' => $session->updated_at?->format('Y-m-d H:i'),
                'messages' => $messages->where('session_id', $session->id)->map(function ($m) {
                    return [
                        'role' => $m->role,
                        'content' => $m->content,
                        'created_at' => $m->created_at?->format('Y-m-d H:i'),
                    ];
                })->values()->all(),
            ];
        })->values();

        $topics = $this->topics($userMessages->pluck('content')->all());
        $words = $this->words($userMessages->pluck('content')->all());

        return response()->json([
            'owner' => self::OWNER_EMAIL,
            'sessions' => $sessions->count(),
            'messages' => $messages->count(),
            'user_messages' => $userMessages->count(),
            'assistant_messages' => $messages->where('role', 'assistant')->count(),
            'active_days' => $sessions->pluck('created_at')->filter()->map(fn ($date) => $date->format('Y-m-d'))->unique()->count(),
            'topics' => $topics,
            'top_words' => $words,
            'last_activity' => optional($sessions->max('updated_at'))->format('Y-m-d H:i'),
            'users' => $users,
            'conversations' => $conversations,
        ]);
    }

    private function topics(array $texts): array
    {
        $groups = [
            'پرۆگرامسازی و کۆد' => ['کۆد', 'پڕۆگرام', 'python', 'javascript', 'php', 'html', 'css', 'هەڵە'],
            'ژیری دەستکرد و ML' => ['ژیری', 'machine', 'ml', 'neural', 'model', 'مۆدێل', 'داتا'],
            'فێربوون و کۆرس' => ['فێربوون', 'کۆرس', 'وانە', 'خوێندن', 'قوتابی'],
            'ڕێزمان و زمان' => ['ڕێزمان', 'وشە', 'بادینی', 'سۆرانی', 'وەرگێڕان'],
            'زانکۆ و ڕێنمایی' => ['زانکۆ', 'بەش', 'خوێندکار', 'ئەکادیمی'],
            'بابەتی گشتی' => [],
        ];
        $counts = array_fill_keys(array_keys($groups), 0);
        foreach ($texts as $text) {
            $lower = mb_strtolower((string) $text);
            $matched = false;
            foreach ($groups as $name => $keywords) {
                if ($name === 'بابەتی گشتی') continue;
                foreach ($keywords as $keyword) {
                    if (mb_strpos($lower, $keyword) !== false) {
                        $counts[$name]++;
                        $matched = true;
                        break;
                    }
                }
                if ($matched) break;
            }
            if (!$matched) $counts['بابەتی گشتی']++;
        }
        arsort($counts);
        return collect($counts)->map(fn ($count, $name) => ['label' => $name, 'count' => $count])->values()->all();
    }

    private function words(array $texts): array
    {
        $stop = ['لە', 'بۆ', 'کە', 'و', 'بە', 'ئەو', 'ئەم', 'من', 'تۆ', 'چی', 'چۆن', 'دەکات', 'دەمەوێت', 'هەیە'];
        $counts = [];
        foreach ($texts as $text) {
            preg_match_all('/[\p{L}\p{N}]{3,}/u', mb_strtolower((string) $text), $matches);
            foreach ($matches[0] ?? [] as $word) {
                if (in_array($word, $stop, true)) continue;
                $counts[$word] = ($counts[$word] ?? 0) + 1;
            }
        }
        arsort($counts);
        return collect($counts)->take(12)->map(fn ($count, $word) => ['word' => $word, 'count' => $count])->values()->all();
    }

    private function firebaseUser(Request $request): ?array
    {
        $token = (string) ($request->header('X-Firebase-Id-Token') ?: $request->bearerToken());
        if ($token === '') return null;
        try {
            $user = $this->firebase->verifyIdTokenRest($token);
            if ($user) return $user;
            $payload = $this->firebase->verifyIdToken($token);
            return ['uid' => $payload['uid'] ?? $payload['sub'] ?? null, 'email' => $payload['email'] ?? null];
        } catch (Throwable) {
            return null;
        }
    }
}
