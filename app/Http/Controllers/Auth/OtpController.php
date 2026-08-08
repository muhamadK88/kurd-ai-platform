<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Services\FirebaseAuthService;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RuntimeException;

class OtpController extends Controller
{
    public function __construct(
        private readonly OtpService $otp,
        private readonly FirebaseAuthService $firebase,
    ) {
    }

    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'method' => ['required', Rule::in(['email', 'phone'])],
            'identifier' => ['required', 'string', 'max:255'],
        ]);

        try {
            $identifier = $this->otp->normalize($data['method'], $data['identifier']);
            $this->assertValidIdentifier($data['method'], $identifier);
            $masked = $this->otp->send($data['method'], $identifier);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json([
            'success' => true,
            'masked' => $masked,
            'identifier' => $identifier,
        ]);
    }

    public function verify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'method' => ['required', Rule::in(OtpCode::CHANNELS)],
            'identifier' => ['required', 'string', 'max:255'],
            'code' => ['required', 'digits:6'],
            'password' => ['sometimes', 'nullable', 'string', 'min:6', 'max:255'],
        ]);

        try {
            $identifier = $this->otp->normalize($data['method'], $data['identifier']);
            $this->otp->verify($data['method'], $identifier, $data['code']);
            $uid = $this->firebase->getOrCreateUser($data['method'], $identifier);

            if (!empty($data['password'])) {
                $this->firebase->setPassword($uid, $data['password']);
            }

            $token = $this->firebase->customToken($uid);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'کێشەیەک ڕوویدا لە سیستەمی فایەربەیس. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.'], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    private function assertValidIdentifier(string $method, string $identifier): void
    {
        if ($method === 'phone') {
            if (!preg_match('/^\+964[0-9]{8,12}$/', $identifier)) {
                throw new RuntimeException('ژمارەی مۆبایلەکە نادروستە. تکایە بە تەواوی بنووسە.');
            }
            return;
        }

        if (!filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('ئیمێڵەکە نادروستە.');
        }
    }
}
