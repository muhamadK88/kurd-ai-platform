<?php

namespace App\Services;

use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Exception\Auth\UserNotFound;

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

    private function randomPassword(): string
    {
        return bin2hex(random_bytes(24));
    }
}
