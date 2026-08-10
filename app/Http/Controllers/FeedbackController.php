<?php

namespace App\Http\Controllers;

use App\Models\FeedbackRequest;
use App\Models\User;
use App\Services\FirebaseAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class FeedbackController extends Controller
{
    /**
     * ئیمەیڵەکانی ئەدمین — بە هەمان شێوەی profile.js
     */
    private const ADMIN_EMAILS = [
        'team@kurd-ai.com',
        'mahamadkamaran890@gmail.com',
    ];

    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    /**
     * بەکارهێنەری فایەربەیس لە توکنەکەوە بەدەست بهێنە.
     *
     * دەگەڕێتەوە: [uid, email, name] یان null
     */
    private function firebaseUser(Request $request): ?array
    {
        $token = (string) ($request->input('idToken') ?? $request->input('id_token') ?? '');

        if ($token === '') {
            $token = (string) $request->header('X-Firebase-Id-Token', '');
        }

        if ($token === '') {
            $token = (string) $request->bearerToken();
        }

        if ($token === '') {
            return null;
        }

        try {
            $user = $this->firebase->verifyIdTokenRest($token);
        } catch (Throwable) {
            $user = null;
        }

        if (!$user) {
            try {
                $payload = $this->firebase->verifyIdToken($token);

                $uid = $payload['uid'] ?? $payload['sub'] ?? null;
                $email = strtolower(trim((string) ($payload['email'] ?? '')));
                $name = trim((string) ($payload['name'] ?? ''));

                if (!$uid) {
                    return null;
                }

                $user = [
                    'uid' => $uid,
                    'email' => $email !== '' ? $email : null,
                    'name' => $name !== '' ? $name : null,
                ];
            } catch (Throwable) {
                $user = null;
            }
        }

        if (!$user || !$user['uid']) {
            return null;
        }

        return $user;
    }

    private function isAdmin(?array $user): bool
    {
        if (!$user || !$user['email']) {
            return false;
        }

        if (in_array($user['email'], self::ADMIN_EMAILS, true)) {
            return true;
        }

        return User::query()
            ->where('email', $user['email'])
            ->where('is_admin', true)
            ->exists();
    }

    /**
     * ناردنی بۆچوون / ڕەخنە / پێشنیار / داواکاری لە لایەن مێمبەرەوە
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$user) {
            return response()->json(['message' => 'تکایە خۆت تۆمار بکە یان بچۆ ژوورەوە.'], 401);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
            'category' => ['nullable', 'string', Rule::in(['feedback', 'suggestion', 'request', 'other'])],
            'name' => 'nullable|string|max:128',
            'hide_email' => 'nullable|boolean',
        ]);

        $email = $user['email'];

        $customName = trim((string) $request->input('name'));

        $name = $customName !== ''
            ? $customName
            : ($user['name'] ?? null);

        if (!$name) {
            $name = $email
                ? explode('@', $email)[0]
                : 'مێمبەر';
        }

        try {
            $feedback = FeedbackRequest::create([
                'user_id' => null,
                'uid' => $user['uid'],
                'name' => $name,
                'email' => $email,
                'hide_email' => (bool) $request->input('hide_email', false),
                'category' => $request->input('category', 'other') ?: 'other',
                'message' => trim((string) $request->input('message')),
                'status' => 'new',
            ]);
        } catch (Throwable) {
            return response()->json([
                'message' => 'نەتوانرا پەیامەکە پاشەکەوت بکرێت. تکایە دوای ماوەیەک دیسان تاقی بکەوە.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'feedback' => $this->shape($feedback),
            'is_admin' => $this->isAdmin($user),
        ]);
    }

    /**
     * پەیامەکانی بەکارهێنەرەکە خۆی — بۆ بەشی "پەیامەکانم"
     */
    public function mine(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$user) {
            return response()->json(['message' => 'تکایە خۆت تۆمار بکە یان بچۆ ژوورەوە.'], 401);
        }

        $items = FeedbackRequest::query()
            ->where('uid', $user['uid'])
            ->latest()
            ->get();

        return response()->json([
            'items' => $items->map(fn ($f) => $this->shape($f)),
            'is_admin' => $this->isAdmin($user),
        ]);
    }

    /**
     * لیستی هەموو پەیامەکان — تەنها بۆ ئەدمین
     */
    public function adminList(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $items = FeedbackRequest::latest()->get();

        return response()->json([
            'items' => $items->map(fn ($f) => $this->shape($f)),
            'stats' => [
                'total' => $items->count(),
                'new' => $items->where('status', 'new')->count(),
                'feedback' => $items->where('category', 'feedback')->count(),
                'suggestion' => $items->where('category', 'suggestion')->count(),
                'request' => $items->where('category', 'request')->count(),
                'other' => $items->where('category', 'other')->count(),
            ],
        ]);
    }

    /**
     * نیشانکردنی پەیام وەک خوێندراوە / نوێ — تەنها بۆ ئەدمین
     */
    public function markRead(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $feedback = FeedbackRequest::findOrFail($id);
        $feedback->status = $request->input('status') === 'new' ? 'new' : 'read';
        $feedback->save();

        return response()->json(['success' => true]);
    }

    /**
     * سڕینەوەی پەیام — تەنها بۆ ئەدمین
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        FeedbackRequest::findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * شێوازی یەکگرتوو بۆ پەیامەکە کە بۆ JS دەنێردرێت
     */
    private function shape(FeedbackRequest $f): array
    {
        return [
            'id' => $f->id,
            'name' => $f->name,
            'email' => $f->hide_email ? null : $f->email,
            'hide_email' => (bool) $f->hide_email,
            'category' => $f->category,
            'message' => $f->message,
            'status' => $f->status,
            'created_at' => $f->created_at ? $f->created_at->diffForHumans() : null,
            'created_raw' => $f->created_at ? $f->created_at->format('Y-m-d H:i') : null,
        ];
    }
}
