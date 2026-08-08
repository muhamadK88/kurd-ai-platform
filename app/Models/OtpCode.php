<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;

    public const CHANNELS = ['email', 'phone', 'google', 'facebook'];

    protected $fillable = [
        'channel',
        'identifier',
        'code_hash',
        'expires_at',
        'used_at',
        'attempts',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }

    public function scopeUnusedFor($query, string $channel, string $identifier)
    {
        return $query->where('channel', $channel)
            ->where('identifier', $identifier)
            ->whereNull('used_at')
            ->where('expires_at', '>', now());
    }
}
