<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * فێرگە — one of the ten sequential AI courses.
 *
 * Owns the prerequisite-chain rule used by the student API: iterating the
 * courses in `position` order, a course is unlocked iff its own status is
 * `active` AND every earlier course has been fully completed by the user
 * (see FergaController::withUnlockState). The model itself exposes the
 * completion helper and status constants.
 */
class FergaCourse extends Model
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_LOCKED = 'locked';
    public const STATUS_COMING_SOON = 'coming_soon';

    public const STATUSES = [
        self::STATUS_ACTIVE,
        self::STATUS_LOCKED,
        self::STATUS_COMING_SOON,
    ];

    protected $fillable = [
        'position',
        'title_so',
        'title_ba',
        'desc_so',
        'desc_ba',
        'icon',
        'accent',
        'status',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(FergaLesson::class)->orderBy('position');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(FergaSection::class)->orderBy('position');
    }

    public function completions(): HasMany
    {
        return $this->hasMany(FergaLessonCompletion::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}