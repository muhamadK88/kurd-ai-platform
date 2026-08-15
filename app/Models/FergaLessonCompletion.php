<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FergaLessonCompletion extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'user_uid',
        'ferga_course_id',
        'ferga_lesson_id',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(FergaLesson::class, 'ferga_lesson_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(FergaCourse::class, 'ferga_course_id');
    }
}