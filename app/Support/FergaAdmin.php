<?php

namespace App\Support;

use App\Models\User;
use Throwable;

/**
 * فێرگە — single source of truth for "who is a Ferga admin?".
 *
 * Both the admin API (FergaAdminController) and the student API
 * (FergaController, to expose is_admin + admin bypass) ask this class.
 * A user is admin when their Firebase email is in the allow-list, or when
 * their local users row has is_admin = true.
 */
class FergaAdmin
{
    public const EMAILS = [
        'team@kurd-ai.com',
        'mahamadkamaran890@gmail.com',
    ];

    public static function isEmailAdmin(string $email): bool
    {
        $email = strtolower(trim($email));

        if (in_array($email, self::EMAILS, true)) {
            return true;
        }

        try {
            return User::query()
                ->where('email', $email)
                ->where('is_admin', true)
                ->exists();
        } catch (Throwable) {
            return false;
        }
    }
}
