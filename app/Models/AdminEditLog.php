<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEditLog extends Model
{
    protected $fillable = ['admin_email', 'request_text', 'actions', 'status'];

    protected $casts = [
        'actions' => 'array',
    ];
}
