<?php

namespace App\Services;

use App\Models\News;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Server-side writer for the Firebase Realtime Database `news` node.
 *
 * The live page (news.blade.php) reads news straight from Firebase, so the
 * automated pipeline must land there — but the RTDB rules now reject
 * anonymous writes. Two authenticated paths exist, used in order:
 *
 *   1. `FIREBASE_SERVICE_ACCOUNT` (preferred) — a JSON service-account key.
 *      We mint a short-lived OAuth2 token ourselves (JWT → token_uri →
 *      access_token) with the `firebase.database` scope, exactly like
 *      scripts/push_ferga_firebase.sh.
 *   2. `FIREBASE_ADMIN_EMAIL` / `FIREBASE_ADMIN_PASSWORD` — a Firebase
 *      Identity Toolkit sign-in for a user who is an RTDB admin (the
 *      kurd-ai.com admin account).
 *
 * The token is cached in memory for the lifetime of the request cycle, so a
 * batch of articles only triggers one mint.
 */
class FirebaseNewsWriter
{
    private ?string $databaseUrl = null;
    private ?string $cachedToken = null;

    public function __construct()
    {
        $this->databaseUrl = rtrim(
            (string) (config('services.firebase.database_url') ?: ''),
            '/'
        ) ?: 'https://ai-platform-adb1b-default-rtdb.firebaseio.com';
    }

    /**
     * Insert one news article into Firebase. Creates a fresh child key and
     * never touches existing records, mirroring the add-one-lesson workflow.
     */
    public function push(News $news): ?string
    {
        $token = $this->accessToken();

        if ($token === null) {
            throw new Exception('No Firebase credentials configured (FIREBASE_SERVICE_ACCOUNT or FIREBASE_ADMIN_EMAIL/PASSWORD).');
        }

        $response = Http::withToken($token)
            ->timeout(30)
            ->post($this->databaseUrl . '/news.json', $news->toFirebaseArray());

        if ($response->failed()) {
            Log::error('FirebaseNewsWriter: failed to push news', [
                'status' => $response->status(),
                'body' => substr((string) $response->body(), 0, 500),
            ]);
            throw new Exception('Firebase write failed: ' . $response->status());
        }

        // A POST against `news.json` returns the new push key.
        $key = $response->json('name');

        if (is_string($key) && $key !== '') {
            Log::info('FirebaseNewsWriter: stored automated news', [
                'firebase_key' => $key,
                'title_sorani' => $news->title_sorani,
            ]);
        }

        return $key;
    }

    // ------------------------------------------------------------- auth

    private function accessToken(): ?string
    {
        if ($this->cachedToken !== null) {
            return $this->cachedToken;
        }

        $token = $this->mintServiceAccountToken()
            ?? $this->signInWithAdminPassword();

        if ($token !== null) {
            $this->cachedToken = $token;
        }

        return $token;
    }

    /** Path 1: JWT signed with the service account's private key. */
    private function mintServiceAccountToken(): ?string
    {
        $path = (string) config('services.firebase.credentials');

        if ($path === '' || ! is_file($path)) {
            return null;
        }

        try {
            $cred = json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR);
            $clientEmail = $cred['client_email'] ?? null;
            $privateKey = $cred['private_key'] ?? null;

            if (! $clientEmail || ! $privateKey) {
                return null;
            }

            $now = time();
            $header = $this->base64Url(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
            $claims = $this->base64Url(json_encode([
                'iss' => $clientEmail,
                'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/firebase.database',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ]));

            $signature = '';
            openssl_sign("$header.$claims", $signature, $privateKey, OPENSSL_ALGO_SHA256);
            $jwt = "$header.$claims." . $this->base64Url($signature);

            $response = Http::asForm()
                ->timeout(15)
                ->post('https://oauth2.googleapis.com/token', [
                    'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                    'assertion' => $jwt,
                ]);

            if ($response->failed()) {
                Log::warning('FirebaseNewsWriter: service-account token exchange failed', [
                    'status' => $response->status(),
                ]);

                return null;
            }

            return $response->json('access_token');
        } catch (\Throwable $e) {
            Log::warning('FirebaseNewsWriter: service-account path failed', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /** Path 2: Identity Toolkit sign-in for a RTDB-admin user. */
    private function signInWithAdminPassword(): ?string
    {
        $email = (string) config('services.firebase.admin_email');
        $password = (string) config('services.firebase.admin_password');

        if ($email === '' || $password === '') {
            return null;
        }

        try {
            $response = Http::asForm()
                ->timeout(15)
                ->post('https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword', [
                    'key' => (string) config('services.firebase.api_key'),
                    'email' => $email,
                    'password' => $password,
                    'returnSecureToken' => true,
                ]);

            if ($response->failed()) {
                Log::warning('FirebaseNewsWriter: admin sign-in failed', [
                    'status' => $response->status(),
                ]);

                return null;
            }

            return $response->json('idToken');
        } catch (\Throwable $e) {
            Log::warning('FirebaseNewsWriter: admin sign-in path failed', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function base64Url(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
