<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use App\Services\FirebaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class ChatSessionController extends Controller
{
    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    public function index(Request $request)
    {
        $userKey = $request->input('user_key');
        $email = $this->firebaseEmail($request);

        if (!$userKey && !$email) {
            return response()->json([]);
        }

        if ($userKey && $email) {
            ChatSession::where('user_key', $userKey)
                ->whereNull('user_email')
                ->update(['user_email' => $email]);
        }

        $sessions = ChatSession::query()
            ->where(function ($query) use ($userKey, $email) {
                if ($userKey) $query->orWhere('user_key', $userKey);
                if ($email) $query->orWhere('user_email', $email);
            })
            ->orderByDesc('pinned')
            ->orderByDesc('updated_at')
            ->get()
            ->each(function (ChatSession $session) use ($email, $userKey) {
                if ($email && $userKey && !$session->user_email && $session->user_key === $userKey) {
                    $session->forceFill(['user_email' => $email])->save();
                }
            })
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'title' => $s->title,
                    'pinned' => $s->pinned,
                    'updated_at' => $s->updated_at ? $s->updated_at->format('Y-m-d H:i') : null,
                ];
            })
            ->values();

        return response()->json($sessions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_key' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $email = $this->firebaseEmail($request);

        $session = ChatSession::create([
            'user_key' => $request->user_key,
            'user_email' => $email,
            'title' => $request->title ?: 'پرسیارێکی نوێ',
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function messages(Request $request, $id)
    {
        $session = $this->ownedSession($request, $id);
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        $messages = ChatHistory::where('session_id', $session->id)
            ->orderBy('id')
            ->get(['id', 'role', 'content', 'reaction', 'created_at']);

        return response()->json([
            'id' => $session->id,
            'title' => $session->title,
            'pinned' => $session->pinned,
            'messages' => $messages,
        ]);
    }

    public function pin(Request $request, $id)
    {
        $session = $this->ownedSession($request, $id);
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        $session->pinned = !$session->pinned;
        $session->save();

        return response()->json(['pinned' => $session->pinned]);
    }

    public function destroy(Request $request, $id)
    {
        $session = $this->ownedSession($request, $id);
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        ChatHistory::where('session_id', $session->id)->delete();
        $session->delete();

        return response()->json(['deleted' => true]);
    }

    public function react(Request $request, $id)
    {
        $request->validate([
            'user_key' => 'required|string|max:255',
            'reaction' => 'nullable|in:up,down',
        ]);

        $email = $this->firebaseEmail($request);
        $message = ChatHistory::where('id', $id)
            ->whereHas('session', function ($q) use ($request, $email) {
                $q->where(function ($sub) use ($request, $email) {
                    $sub->where('user_key', $request->user_key);
                    if ($email) $sub->orWhere('user_email', $email);
                });
            })
            ->first();

        if (!$message) {
            return response()->json(['error' => 'not found'], 404);
        }

        $message->reaction = $request->reaction;
        $message->save();

        return response()->json(['reaction' => $message->reaction]);
    }

    private function ownedSession(Request $request, $id): ?ChatSession
    {
        $email = $this->firebaseEmail($request);
        $userKey = $request->input('user_key');
        if (!$email && !$userKey) return null;
        $query = ChatSession::where('id', $id);
        if ($email) {
            $query->where(function ($sub) use ($userKey, $email) {
                $sub->where('user_email', $email);
                if ($userKey) $sub->orWhere('user_key', $userKey);
            });
        } else {
            $query->where('user_key', $userKey);
        }
        return $query->first();
    }

    private function firebaseEmail(Request $request): ?string
    {
        $token = (string) ($request->header('X-Firebase-Id-Token') ?: $request->bearerToken());
        if ($token === '') return null;
        return Cache::remember('firebase.email.' . hash('sha256', $token), now()->addMinutes(5), function () use ($token) {
            try {
                $user = $this->firebase->verifyIdTokenRest($token);
                if ($user && !empty($user['email'])) return strtolower(trim($user['email']));
                $payload = $this->firebase->verifyIdToken($token);
                return !empty($payload['email']) ? strtolower(trim($payload['email'])) : null;
            } catch (Throwable) {
                return null;
            }
        });
    }
}
