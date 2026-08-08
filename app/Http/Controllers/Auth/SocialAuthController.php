<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Services\FirebaseAuthService;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;
use RuntimeException;

class SocialAuthController extends Controller
{
    public function __construct(
        private readonly OtpService $otp,
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
                return response()->json(['message' => 'ئەم هەژمارەیە هیچ ئیمێڵێکی تێدا نەبوو بۆ ناردنی کۆدەکە.'], 422);
            }

            $alreadyVerified = OtpCode::query()
                ->where('identifier', $email)
                ->whereNotNull('used_at')
                ->exists();

            if ($alreadyVerified) {
                $uid = $this->firebase->getOrCreateUser($data['provider'], $email);
                $token = $this->firebase->customToken($uid);

                return response()->json([
                    'success' => true,
                    'status' => 'existing',
                    'token' => $token,
                    'email' => $email,
                ]);
            }

            $masked = $this->otp->send($data['provider'], $email);
        } catch (FailedToVerifyToken $e) {
            return response()->json(['message' => 'پشتڕاستکردنەوەی هەژمارەکە سەرنەکەوت. تکایە دووبارە هەوڵ بدەرەوە.'], 401);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'کێشەیەک ڕوویدا لە سیستەمی فایەربەیس. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.'], 500);
        }

        return response()->json([
            'success' => true,
            'status' => 'new',
            'masked' => $masked,
            'email' => $email,
        ]);
    }
}
