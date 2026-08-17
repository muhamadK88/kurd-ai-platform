<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Fire-and-forget beacon endpoint (no auth — anonymous usage data).
 * Accepts: POST /api/analytics/visit  {type?: visit|login, section, user_key}
 */
class AnalyticsController extends Controller
{
    private const VALID_TYPES = [AnalyticsEvent::TYPE_VISIT, AnalyticsEvent::TYPE_LOGIN];

    public function track(Request $request): JsonResponse
    {
        $type = $request->input('type');
        if (!in_array($type, self::VALID_TYPES, true)) {
            $type = AnalyticsEvent::TYPE_VISIT;
        }

        $section = strtolower((string) $request->input('section', ''));
        if ($section === '') {
            $section = 'home';
        }

        AnalyticsEvent::create([
            'event_type' => $type,
            'section' => mb_substr($section, 0, 40),
            'user_key' => mb_substr((string) $request->input('user_key', ''), 0, 64) ?: null,
            'user_uid' => mb_substr((string) $request->input('uid', ''), 0, 64) ?: null,
            'user_email' => mb_strtolower(mb_substr(trim((string) $request->input('email', '')), 0, 190)) ?: null,
            'created_at' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}