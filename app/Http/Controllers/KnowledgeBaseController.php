<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Models\User;
use App\Services\FirebaseAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class KnowledgeBaseController extends Controller
{
    /**
     * ئیمەیڵەکانی ئەدمین — بە هەمان شێوەی FeedbackController
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

        try {
            return User::query()
                ->where('email', $user['email'])
                ->where('is_admin', true)
                ->exists();
        } catch (Throwable $e) {
            Log::warning('Admin database check unavailable', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * پەڕەی بەڕێوەبردنی زانیارییەکانی چاتبۆت — JS دادەبات و دەستیشانی ئەدمین دەکات.
     */
    public function page()
    {
        return view('knowledge');
    }

    /**
     * لیستی هەموو بەندەکانی زانیاری — تەنها بۆ ئەدمین
     */
    public function index(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $items = KnowledgeBase::latest()->get();
        } catch (Throwable $e) {
            Log::warning('Knowledge list unavailable (DB down?)', ['error' => $e->getMessage()]);

            return response()->json([
                'items' => [],
                'stats' => ['total' => 0, 'active' => 0, 'inactive' => 0],
                'notice' => 'داتابەیس ئامادە نییە — تکایە MySQL بەڕوو بکە و پاشان دیسان هەوڵبدەرەوە.',
            ], 200);
        }

        return response()->json([
            'items' => $items->map(fn ($k) => $this->shape($k)),
            'stats' => [
                'total' => $items->count(),
                'active' => $items->where('active', true)->count(),
                'inactive' => $items->where('active', false)->count(),
            ],
        ]);
    }

    /**
     * زیادکردنی زانیاری نوێ — تەنها بۆ ئەدمین
     */
    public function store(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:50000',
            'keywords' => 'nullable|string|max:500',
            'active' => 'nullable|boolean',
        ]);

        try {
            $knowledge = KnowledgeBase::create([
                'uid' => $user['uid'],
                'title' => trim((string) $request->input('title')),
                'content' => trim((string) $request->input('content')),
                'keywords' => $request->filled('keywords') ? trim((string) $request->input('keywords')) : null,
                'active' => $request->boolean('active', true),
                'training' => null,
            ]);
            $this->forgetKnowledgeCache();
        } catch (Throwable $e) {
            Log::error('Knowledge store failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'knowledge' => $this->shape($knowledge),
        ]);
    }

    /**
     * نوێکردنەوەی زانیاری — تەنها بۆ ئەدمین
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $knowledge = KnowledgeBase::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string|max:50000',
            'keywords' => 'nullable|string|max:500',
            'active' => 'nullable|boolean',
        ]);

        try {
            $knowledge->title = trim((string) $request->input('title'));
            $knowledge->content = trim((string) $request->input('content'));
            $knowledge->keywords = $request->filled('keywords') ? trim((string) $request->input('keywords')) : null;
            $knowledge->active = $request->boolean('active', $knowledge->active);
            $knowledge->save();
            $this->forgetKnowledgeCache();
        } catch (Throwable $e) {
            Log::error('Knowledge update failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'knowledge' => $this->shape($knowledge),
        ]);
    }

    /**
     * چالاک / ناچالاک کردنی زانیاری — تەنها بۆ ئەدمین
     */
    public function toggle(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $knowledge = KnowledgeBase::findOrFail($id);
            $knowledge->active = !$knowledge->active;
            $knowledge->save();
            $this->forgetKnowledgeCache();
        } catch (Throwable $e) {
            Log::warning('Knowledge toggle failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'knowledge' => $this->shape($knowledge),
        ]);
    }

    /**
     * سڕینەوەی زانیاری — تەنها بۆ ئەدمین
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            KnowledgeBase::findOrFail($id)->delete();
            $this->forgetKnowledgeCache();
        } catch (Throwable $e) {
            Log::warning('Knowledge delete failed', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json(['success' => true]);
    }

    /**
     * فێرکردنی چاتبۆت بە گفتوگۆ — ئەدمین وەڵام دەداتەوە و چاتبۆت
     * پرسیاری ڕوونکەرەوە دەکات تا باشتر تێبگات. تەنها بۆ ئەدمین.
     */
    public function train(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'nullable|string|max:8000',
        ]);

        $knowledge = $this->findKnowledgeOr($id);

        if ($knowledge === null) {
            return response()->json([
                'error' => 'داتابەیس ئامادە نییە — تکایە MySQL بەڕوو بکە و پاشان هەوڵبدەرەوە.',
            ], 500);
        }

        $message = trim((string) $request->input('message'));

        $training = is_array($knowledge->training) ? $knowledge->training : [];

        $system = 'تۆ ئێستا مامۆستایەکیت کە ئەدمینی پلاتفۆرمی کورد ئەی ئای (Kurd AI) فێری بابەتێک دەکات. '
            . 'بەرگری: هەمی وەڵامێن تە دەبیت ب تەواوی ب شێوەزاری سۆرانی بن. '
            . 'ئەرکی تۆ: بۆ ئەوەی باشتر لە بابەتەکە تێبگەیت، پرسیاری کورت و تایبەت لە ئەدمین بکە. '
            . 'یەک پرسیار لە یەک کاتدا بکە — لە کۆتایی هەر وەڵامێکەت پرسیارێک دابنێ. '
            . 'ڕوونکردنەوەی درێژ مەدە؛ فۆکوس لەسەر تێگەیشتنە. '
            . 'هەر کاتێک ئەدمین وەڵامی پرسیارەکەت دایەوە، ئەگەر هێشتا بەشی کەم و کوڕی هەیە، پرسیارێکی تری ڕوونکەرەوە بکە. '
            . 'زانیارییەکانی ئەدمین وەک ڕاستی وەربگرە و لەبیرت بگرە. '
            . 'لە ڕێگەی ئەم پرسیار و وەڵامانەوە دەبێت لە کۆتاییدا بتوانیت ڕوون و تەواو وەڵامی بەکارهێنەران بدەیتەوە.';

        $apiMessages = [['role' => 'system', 'content' => $system]];

        foreach ($training as $m) {
            if (is_array($m) && isset($m['role'], $m['content'])) {
                $apiMessages[] = ['role' => $m['role'], 'content' => $m['content']];
            }
        }

        if ($message === '') {
            if (trim((string) $knowledge->content) !== '') {
                $message = trim((string) $knowledge->content);
            } else {
                $message = trim((string) $knowledge->title);
            }
        }

        $apiMessages[] = ['role' => 'user', 'content' => $message];

        $reply = app(ChatbotController::class)->aiCompletion($apiMessages, 'so');

        if ($reply === null) {
            return response()->json([
                'error' => 'نەتوانرا وەڵام دروست بکرێت. دوای ماوەیەک دیسان تاقی بکەوە.',
            ], 502);
        }

        $training[] = ['role' => 'user', 'content' => $message];
        $training[] = ['role' => 'assistant', 'content' => $reply];

        try {
            $knowledge->training = $training;
            $knowledge->save();
        } catch (Throwable $e) {
            Log::error('Knowledge train save failed', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'reply' => $reply,
            'training' => $training,
        ]);
    }

    /**
     * تەواوکردنی فێرکاری — دەقی کۆتایی لە گفتوگۆکەوە دروست دەکرێت و
     * دەبێتە زانیاری چالاک کە چاتبۆت بۆ وەڵامدانی بەکارهێنەران بەکاری دەهێنێت.
     */
    public function finalize(Request $request, $id): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$this->isAdmin($user)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $knowledge = $this->findKnowledgeOr($id);

        if ($knowledge === null) {
            return response()->json([
                'error' => 'داتابەیس ئامادە نییە — تکایە MySQL بەڕوو بکە و پاشان هەوڵبدەرەوە.',
            ], 500);
        }

        $training = is_array($knowledge->training) ? $knowledge->training : [];

        if (!$training) {
            return response()->json([
                'error' => 'هێشتا هیچ گفتوگۆیەکی فێرکاری نییە. سەرەتا دەست بە فێرکردن بکە.',
            ], 422);
        }

        $system = 'ئەدمینی پلاتفۆرمی کورد ئەی ئای (Kurd AI) دەیەوێت لە ڕێگەی گفتوگۆکەی خوارەوەوە فێرت بکات بە بابەتێک. '
            . 'بەرگری: دەقی کۆتایی دەبێت ب تەواوی ب شێوەزاری سۆرانی بن. '
            . 'ئەرکی تۆ: لەسەر بنەمای هەموو پرسیار و وەڵامەکانی گفتوگۆکە، دەقی کۆتایی، تەواو، ڕێکوپێک و بەسوود بنووسە '
            . 'کە وەک زانیاری چاتبۆت بۆ وەڵامدانی بەکارهێنەران بەکار دەهێنرێت. '
            . 'دەقەکە تەنها لەسەر بنەمای زانیارییەکانی ئەدمین بەرهەم بهێنە، بەوەڕوونی و بە هەر بەشێک کە پێویستە. '
            . 'هیچ پرسیارێک مەکە و هیچ پێشەکییەک مەنووسە — تەنها دەقی کۆتایی بدە.';

        $apiMessages = [['role' => 'system', 'content' => $system]];

        foreach ($training as $m) {
            if (is_array($m) && isset($m['role'], $m['content'])) {
                $apiMessages[] = ['role' => $m['role'], 'content' => $m['content']];
            }
        }

        $reply = app(ChatbotController::class)->aiCompletion($apiMessages, 'so');

        if ($reply === null) {
            return response()->json([
                'error' => 'نەتوانرا دەقە کۆتاییەکە دروست بکرێت. دوای ماوەیەک دیسان تاقی بکەوە.',
            ], 502);
        }

        try {
            $knowledge->content = trim($reply);
            $knowledge->active = true;
            $knowledge->save();
        } catch (Throwable $e) {
            Log::error('Knowledge finalize save failed', ['error' => $e->getMessage()]);

            return response()->json([
                'error' => $this->saveErrorMessage($e),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'knowledge' => $this->shape($knowledge),
        ]);
    }

    /**
     * دۆزینەوەی زانیاری — ئەگەر داتابەیس نەبێت، null دەگەڕێتەوە نەک هەڵە.
     */
    private function findKnowledgeOr($id): ?KnowledgeBase
    {
        try {
            return KnowledgeBase::findOrFail($id);
        } catch (Throwable $e) {
            Log::warning('Knowledge find failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * پەیامی ڕوون و بەسوود بۆ هەڵەی پاشەکەوتکردن
     */
    private function saveErrorMessage(Throwable $e): string
    {
        $msg = strtolower($e->getMessage());

        if (str_contains($msg, 'unknown column') || str_contains($msg, "no such column") || str_contains($msg, 'column') && str_contains($msg, 'training')) {
            return 'داتابەیس نۆژەن نەکراوەتەوە. تکایە لە تێرمیناڵ ڕانە بکە: php artisan migrate';
        }

        Log::warning('Knowledge save failed with unhandled SQL', ['error' => $e->getMessage()]);

        return 'نەتوانرا زانیارییەکە پاشەکەوت بکرێت. تکایە دوای ماوەیەک دیسان تاقی بکەوە.';
    }

    private function forgetKnowledgeCache(): void
    {
        foreach (['so', 'ba', 'en', 'ar', 'ckb', 'kmr'] as $lang) {
            Cache::forget('kurdai.knowledge.active.' . $lang . '.v1');
        }
    }

    /**
     * شێوازی یەکگرتوو بۆ بەندەکە کە بۆ JS دەنێردرێت
     */
    private function shape(KnowledgeBase $k): array
    {
        return [
            'id' => $k->id,
            'title' => $k->title,
            'content' => $k->content,
            'keywords' => $k->keywords,
            'active' => (bool) $k->active,
            'training' => is_array($k->training) ? $k->training : [],
            'updated_at' => $k->updated_at ? $k->updated_at->diffForHumans() : null,
            'updated_raw' => $k->updated_at ? $k->updated_at->format('Y-m-d H:i') : null,
        ];
    }
}
