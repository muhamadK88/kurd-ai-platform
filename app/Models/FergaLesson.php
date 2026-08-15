<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FergaLesson extends Model
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
        'ferga_course_id',
        'ferga_section_id',
        'position',
        'status',
        'title_so',
        'title_ba',
        'desc_so',
        'desc_ba',
        'content_so',
        'content_ba',
        'code_language',
        'starter_code',
        'media',
    ];

    protected $casts = [
        'position' => 'integer',
        'media' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(FergaCourse::class, 'ferga_course_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FergaSection::class, 'ferga_section_id');
    }

    public function completions(): HasMany
    {
        return $this->hasMany(FergaLessonCompletion::class);
    }

    /** Public payload — content is included only by the lesson endpoint. */
    public function toMetaArray(bool $completed = false): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'section_id' => $this->ferga_section_id,
            'status' => $this->status ?: self::STATUS_ACTIVE,
            'title_so' => $this->title_so,
            'title_ba' => $this->title_ba,
            'desc_so' => $this->desc_so,
            'desc_ba' => $this->desc_ba,
            'code_language' => $this->code_language ?: 'python',
            'media' => $this->media,
            'completed' => $completed,
        ];
    }

    public function toContentArray(bool $completed = false): array
    {
        return $this->toMetaArray($completed) + [
            'content_so' => (string) $this->content_so,
            'content_ba' => (string) $this->content_ba,
            'starter_code' => (string) $this->starter_code,
            'course_id' => $this->ferga_course_id,
        ];
    }
}