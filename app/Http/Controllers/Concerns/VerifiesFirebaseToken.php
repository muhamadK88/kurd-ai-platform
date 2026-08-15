<?php

namespace App\Http\Controllers\Concerns;

use App\Services\FirebaseAuthService;
use Illuminate\Http\Request;

/**
 * Single source of truth for resolving the Firebase user from an incoming
 * request. Every controller that talks to Firebase (chatbot, sessions,
 * feedback, knowledge base, chat analytics) shares this one trait instead of
 * carrying its own copy of the token-extraction + verifyIdTokenRest/verifyIdToken
 * fallback ladder — which previously made five separate network call sites,
 * each without consistent caching.
 *
 * The heavy lifting (REST lookup, SDK fallback, caching, timeouts) lives in
 * {@see FirebaseAuthService::verifyUserFromToken()}, so a controller only has
 * to ask "who is this?" and get back [uid, email, name] or null.
 *
 * Host class contract: must expose a `$firebase` property of type
 * FirebaseAuthService (constructor-injected — every host already does this).
 */
trait VerifiesFirebaseToken
{
    /**
     * Pull the ID token from the most common locations, in priority order:
     * body params (idToken / id_token), the X-Firebase-Id-Token header, then
     * the Authorization Bearer token. Returns '' when none is present.
     */
    protected function firebaseTokenFromRequest(Request $request): string
    {
        $token = (string) ($request->input('idToken') ?? $request->input('id_token') ?? '');

        if ($token === '') {
            $token = (string) $request->header('X-Firebase-Id-Token', '');
        }

        if ($token === '') {
            $token = (string) $request->bearerToken();
        }

        return $token;
    }

    /**
     * Normalized Firebase user: ['uid' => string, 'email' => ?string,
     * 'name' => ?string], or null when the token is absent / unverifiable.
     * All verification (and its caching) is delegated to the service layer.
     */
    protected function firebaseUser(Request $request): ?array
    {
        $token = $this->firebaseTokenFromRequest($request);

        if ($token === '') {
            return null;
        }

        /** @var FirebaseAuthService $firebase */
        $firebase = $this->firebase ?? null;

        if (!$firebase instanceof FirebaseAuthService) {
            return null;
        }

        return $firebase->verifyUserFromToken($token);
    }

    protected function firebaseUid(Request $request): ?string
    {
        return $this->firebaseUser($request)['uid'] ?? null;
    }

    protected function firebaseEmail(Request $request): ?string
    {
        return $this->firebaseUser($request)['email'] ?? null;
    }

    protected function firebaseName(Request $request): ?string
    {
        return $this->firebaseUser($request)['name'] ?? null;
    }
}