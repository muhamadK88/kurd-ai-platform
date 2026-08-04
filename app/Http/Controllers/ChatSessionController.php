<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
use Illuminate\Http\Request;

class ChatSessionController extends Controller
{
    public function index(Request $request)
    {
        $userKey = $request->input('user_key');
        if (!$userKey) {
            return response()->json([]);
        }

        $sessions = ChatSession::where('user_key', $userKey)
            ->orderByDesc('pinned')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'title' => $s->title,
                    'pinned' => $s->pinned,
                    'updated_at' => $s->updated_at ? $s->updated_at->format('Y-m-d H:i') : null,
                ];
            });

        return response()->json($sessions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_key' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
        ]);

        $session = ChatSession::create([
            'user_key' => $request->user_key,
            'title' => $request->title ?: 'پرسیارێکی نوێ',
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function messages(Request $request, $id)
    {
        $userKey = $request->input('user_key');
        $session = ChatSession::where('id', $id)->where('user_key', $userKey)->first();
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        $messages = ChatHistory::where('session_id', $session->id)
            ->orderBy('id')
            ->get(['role', 'content', 'created_at']);

        return response()->json([
            'id' => $session->id,
            'title' => $session->title,
            'pinned' => $session->pinned,
            'messages' => $messages,
        ]);
    }

    public function pin(Request $request, $id)
    {
        $userKey = $request->input('user_key');
        $session = ChatSession::where('id', $id)->where('user_key', $userKey)->first();
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        $session->pinned = !$session->pinned;
        $session->save();

        return response()->json(['pinned' => $session->pinned]);
    }

    public function destroy(Request $request, $id)
    {
        $userKey = $request->input('user_key');
        $session = ChatSession::where('id', $id)->where('user_key', $userKey)->first();
        if (!$session) {
            return response()->json(['error' => 'not found'], 404);
        }

        ChatHistory::where('session_id', $session->id)->delete();
        $session->delete();

        return response()->json(['deleted' => true]);
    }
}
