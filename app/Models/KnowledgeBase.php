<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class KnowledgeBase extends Model
{
    protected $table = 'knowledge_base';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uid',
        'title',
        'content',
        'keywords',
        'lang',
        'active',
        'training',
    ];

    protected $casts = [
        'active' => 'boolean',
        'training' => 'array',
    ];

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget('kurdai.knowledge.active.so.v1');
            Cache::forget('kurdai.knowledge.active.ba.v1');
        });
        static::deleted(function () {
            Cache::forget('kurdai.knowledge.active.so.v1');
            Cache::forget('kurdai.knowledge.active.ba.v1');
        });
    }
}
