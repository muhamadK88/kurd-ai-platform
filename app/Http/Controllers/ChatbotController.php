<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\ChatSession;
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
            'session_id' => 'nullable|integer',
        ]);

        $key = env('DEEPSEEK_API_KEY');
        $baseUrl = env('DEEPSEEK_BASE_URL');
        $model = env('DEEPSEEK_MODEL');

        if (!$key || !$baseUrl || !$model) {
            Log::warning('AI provider config missing');
            return response()->json([
                'reply' => 'ببورە، پێکهاتەکانی ڕاژەکار ئامادە نین.',
            ], 500);
        }

        $system = 'تۆ یاریدەدەری ژیری دەستکردی پلاتفۆرمی کورد ئەی ئای (Kurd AI) ی. '
            . 'پلاتفۆرمێک بۆ فێربوونی پرۆگرامسازی و زیرەکی دەستکرد بە زمانی کوردی (سۆرانی و بادینی). '
            . 'هەر کاتێک بە کوردی پرسیار کرایت، بە کوردی وەڵام بدەرەوە. وەڵامەکانت ڕوون و کورت و بەسوود بن. '
            . 'ئەگەر لە پرۆگرامسازی پرسیار کرابێت، نموونەی کۆد بدە و ڕوونی بکەرەوە.';

        $session = null;
        $userKey = $request->input('user_key');

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
            ChatHistory::create([
                'session_id' => $session->id,
                'role' => 'user',
                'content' => $request->message,
            ]);
        }

        try {
            $response = Http::withToken($key)
                ->timeout(90)
                ->post($baseUrl . '/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $request->message],
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                Log::error('AI provider error', ['status' => $response->status()]);
                return response()->json([
                    'reply' => 'ببورە، کێشەیەک ڕوویدا لە وەڵامدانەوەکەدا. دوای تروە هەوڵبدەرەوە.',
                ], 502);
            }

            $reply = $response->json('choices.0.message.content')
                ?? 'ببورە، نەمتوانی وەڵام بدەمەوە.';

            if ($session) {
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
            ]);
        } catch (\Exception $e) {
            Log::error('AI provider exception', ['error' => $e->getMessage()]);
            return response()->json([
                'reply' => 'ببورە، کێشەیەک ڕوویدا. دوای تروە هەوڵبدەرەوە.',
            ], 500);
        }
    }
}
