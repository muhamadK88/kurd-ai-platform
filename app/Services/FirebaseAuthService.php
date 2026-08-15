<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\UserNotFound;
use Throwable;

class FirebaseAuthService
{
    public function __construct(private readonly FirebaseAuth $auth)
    {
    }

    public function getUserByEmail(string $email): UserRecord
    {
        return $this->auth->getUserByEmail($email);
    }

    public function createUserWithEmailAndPassword(string $email, string $password): UserRecord
    {
        return $this->auth->createUserWithEmailAndPassword($email, $password);
    }

    public function setPassword(string $uid, string $password): void
    {
        $this->auth->updateUser($uid, ['password' => $password]);
    }

    public function getOrCreateUser(string $method, string $identifier): string
    {
        if ($method === 'phone') {
            return $this->getOrCreateByPhone($identifier);
        }

        return $this->getOrCreateByEmail($identifier);
    }

    public function getOrCreateByEmail(string $email): string
    {
        try {
            $record = $this->auth->getUserByEmail($email);
        } catch (UserNotFound) {
            $record = $this->auth->createUserWithEmailAndPassword($email, $this->randomPassword());
        }

        if (!$record->emailVerified) {
            $this->auth->updateUser($record->uid, ['emailVerified' => true]);
        }

        return $record->uid;
    }

    public function getOrCreateByPhone(string $phone): string
    {
        try {
            $record = $this->auth->getUserByPhoneNumber($phone);
        } catch (UserNotFound) {
            $record = $this->auth->createUser([
                'phoneNumber' => $phone,
                'password' => $this->randomPassword(),
            ]);
        }

        return $record->uid;
    }

    public function customToken(string $uid): string
    {
        return (string) $this->auth->createCustomToken($uid);
    }

    public function verifyIdToken(string $idToken): array
    {
        $token = $this->auth->verifyIdToken($idToken);

        return $token->payload();
    }

    /**
     * REST-verified token payload (accounts:lookup) — no SDK credentials needed.
     * Returns null on any failure so callers can fall back to verifyIdToken().
     */
    public function verifyIdTokenRest(string $idToken): ?array
    {
        try {
            $apiKey = (string) config('kurdai.firebase.apiKey');

            if ($apiKey === '') {
                return null;
            }

            $response = Http::post(
                'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . $apiKey,
                ['idToken' => $idToken]
            );

            if (!$response->successful()) {
                return null;
            }

            $user = ($response->json('users') ?? [])[0] ?? null;

            if (!$user) {
                return null;
            }

            return [
                'uid' => $user['localId'] ?? $user['uid'] ?? null,
                'email' => isset($user['email'])
                    ? strtolower(trim((string) $user['email']))
                    : null,
                'name' => isset($user['displayName'])
                    ? trim((string) $user['displayName'])
                    : null,
            ];
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Cached token verification (REST-first with SDK fallback).
     * Result is cached under 'auth_token_' . sha256(token) for 300 seconds.
     * Returns null on any failure so callers can fall back gracefully.
     */
    public function verifiedUser(string $token): ?array
    {
        if ($token === '') {
            return null;
        }

        return Cache::remember('auth_token_' . hash('sha256', $token), 300, function () use ($token) {
            try {
                $user = $this->verifyIdTokenRest($token);
                if ($user) {
                    return $user;
                }

                $payload = $this->verifyIdToken($token);
                $uid = $payload['uid'] ?? $payload['sub'] ?? null;

                if (!$uid) {
                    return null;
                }

                $email = strtolower(trim((string) ($payload['email'] ?? '')));
                $name = trim((string) ($payload['name'] ?? ''));

                return [
                    'uid' => $uid,
                    'email' => $email !== '' ? $email : null,
                    'name' => $name !== '' ? $name : null,
                ];
            } catch (Throwable) {
                return null;
            }
        });
    }

    private function randomPassword(): string
    {
        return bin2hex(random_bytes(24));
    }
}
