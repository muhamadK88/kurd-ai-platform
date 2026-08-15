<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FirebaseAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;

class SocialAuthController extends Controller
{
    public function __construct(
        private readonly FirebaseAuthService $firebase,
    ) {
    }

    public function exchange(Request $request): JsonResponse
    {
        $data = $request->validate([
            'provider' => ['required', 'in:google'],
            'idToken' => ['required', 'string'],
        ]);

        try {
            $cacheKey = 'auth_token_' . hash('sha256', $data['idToken']);
            $verifiedIdToken = \Illuminate\Support\Facades\Cache::remember($cacheKey, 300, function () use ($data, $cacheKey) {
                $token = $this->firebase->verifyIdToken($data['idToken']);
                $exp = (int) ($token['exp'] ?? 0);
                $ttl = max(0, $exp - time());
                \Illuminate\Support\Facades\Cache::put($cacheKey, $token, $ttl);
                return $token;
            });
            $payload = $verifiedIdToken;
            $email = strtolower(trim($payload['email'] ?? ''));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return response()->json(['message' => 'ئەم هەژمارەیە هیچ ئیمێڵێکی تێدا نەبوو.'], 422);
            }

            $uid = $this->firebase->getOrCreateUser($data['provider'], $email);
            $token = $this->firebase->customToken($uid);

            return response()->json([
                'success' => true,
                'status' => 'existing',
                'token' => $token,
                'email' => $email,
            ]);
        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => 'پشتڕاستکردنەوەی هەژمارەکە سەرنەکەوت. تکایە دووبارە هەوڵ بدەرەوە.'], 401);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'کێشەیەک ڕوویدا لە سیستەمی فایەربەیس. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.'], 500);
        }
    }
}
