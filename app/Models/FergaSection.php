<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * فێرگە — a named group of lessons inside a course (بەش).
 *
 * Sections are pure grouping: the unlock chain is driven by the course-global
 * lesson `position`, so moving lessons between sections never changes what a
 * student can open next. Deleting a section keeps its lessons (they fall back
 * to the "بێ بەش" / no-section group).
 */
class FergaSection extends Model
{
    protected $fillable = [
        'ferga_course_id',
        'position',
        'title_so',
        'title_ba',
    ];

    protected $casts = [
        'position' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(FergaCourse::class, 'ferga_course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(FergaLesson::class, 'ferga_section_id')->orderBy('position');
    }

    public function toArrayValue(): array
    {
        return [
            'id' => $this->id,
            'position' => $this->position,
            'title_so' => $this->title_so,
            'title_ba' => $this->title_ba,
        ];
    }
}
