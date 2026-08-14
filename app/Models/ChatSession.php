<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['user_key', 'user_email', 'title', 'pinned'];

    protected $casts = [
        'pinned' => 'boolean',
    ];

    public function messages()
    {
        return $this->hasMany(ChatHistory::class, 'session_id');
    }
}
