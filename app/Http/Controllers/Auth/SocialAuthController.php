<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FirebaseAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
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
            'provider' => ['required', Rule::in(['google', 'facebook'])],
            'idToken' => ['required', 'string'],
        ]);

        try {
            $payload = $this->firebase->verifyIdToken($data['idToken']);
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

    public function facebookLogin(Request $request): JsonResponse
    {
        $data = $request->validate([
            'accessToken' => ['required', 'string'],
        ]);

        try {
            $response = Http::get('https://graph.facebook.com/me', [
                'fields' => 'id,name,email',
                'access_token' => $data['accessToken'],
            ]);

            $me = $response->json() ?? [];

            if (!$response->successful() || empty($me['id'])) {
                return response()->json(['message' => 'پشتڕاستکردنەوەی فەیسبووک سەرنەکەوت. تکایە دووبارە هەوڵ بدەرەوە.'], 401);
            }

            $email = strtolower(trim((string) ($me['email'] ?? '')));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = 'fb.' . $me['id'] . '@facebook.local';
            }

            $uid = $this->firebase->getOrCreateByEmail($email);
            $token = $this->firebase->customToken($uid);

            return response()->json([
                'success' => true,
                'status' => 'existing',
                'token' => $token,
                'email' => $email,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'کێشەیەک ڕوویدا. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.'], 500);
        }
    }
}
