<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'uid',
        'name',
        'email',
        'hide_email',
        'category',
        'message',
        'status',
    ];

    protected $casts = [
        'hide_email' => 'boolean',
    ];

    /**
     * Get the member (user) who sent this message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
