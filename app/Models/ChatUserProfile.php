<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUserProfile extends Model
{
    protected $fillable = ['user_email', 'display_name', 'preferred_lang', 'topics', 'style'];

    protected $casts = [
        'topics' => 'array',
        'style' => 'array',
    ];
}
