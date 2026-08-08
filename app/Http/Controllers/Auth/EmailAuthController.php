<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\FirebaseAuthService;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use RuntimeException;

class EmailAuthController extends Controller
{
    public function __construct(
        private readonly OtpService $otp,
        private readonly FirebaseAuthService $firebase,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        $email = strtolower(trim($data['email']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'ئیمێڵەکە نادروستە.'], 422);
        }

        try {
            $this->firebase->getUserByEmail($email);
        } catch (UserNotFound) {
            try {
                $this->firebase->createUserWithEmailAndPassword($email, $data['password']);
            } catch (\Throwable $e) {
                return response()->json(['message' => 'هەژمارەکە نەتوانرا دروستبکرێت. تکایە دووبارە هەوڵ بدەرەوە.'], 422);
            }

            try {
                $masked = $this->otp->send('email', $email);
            } catch (RuntimeException $e) {
                return response()->json([
                    'status' => 'new',
                    'masked' => $this->otp->mask('email', $email),
                    'identifier' => $email,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return response()->json([
                'status' => 'new',
                'masked' => $masked,
                'identifier' => $email,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'کێشەیەک ڕوویدا لە سیستەمی فایەربەیس. تکایە دوای چەند خولەکێک دووبارە هەوڵ بدەرەوە.'], 500);
        }

        return response()->json([
            'status' => 'existing',
        ]);
    }
}
