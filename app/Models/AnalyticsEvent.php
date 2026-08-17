<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * One row per tracked site event (visit / login) with a coarse section key.
 * Written by the fire-and-forget browser beacon (KaiTrack) and aggregated by
 * AdminAnalyticsController for the admin dashboard on the About page.
 */
class AnalyticsEvent extends Model
{
    public const TYPE_VISIT = 'visit';
    public const TYPE_LOGIN = 'login';

    public const SECTIONS = [
        'home' => 'سەرەکی',
        'ferga' => 'فێرگە',
        'courses' => 'کۆرسەکان',
        'news' => 'هەواڵەکان',
        'ai_tools' => 'تووڵەکان',
        'academic_guide' => 'ڕێنیشاندەر',
        'universities' => 'زانکۆکان',
        'general_info' => 'زانیاری گشتی',
        'about' => 'دەربارەی ئێمە',
        'profile' => 'پڕۆفایل',
        'feedback' => 'ڕەخنە و پێشنیار',
    ];

    public $timestamps = false;

    protected $fillable = [
        'event_type',
        'section',
        'user_key',
        'user_uid',
        'user_email',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
