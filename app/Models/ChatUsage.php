<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUsage extends Model
{
    protected $table = 'chat_usage';

    protected $fillable = ['user_key', 'usage_date', 'count'];

    protected $casts = [
        'count' => 'integer',
    ];
}
