<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * هەواڵ — News, stored bilingually (سۆرانی / بادینی).
 *
 * The live front-end reads news from Firebase RTDB; this model is the
 * queryable SQL mirror. It owns two things the RTDB cannot do well:
 * server-side date filtering (`published_at`) and de-duplication
 * (`source_url` unique).
 */
class News extends Model
{
    /** The table is named `news` in both singular and plural. */
    protected $table = 'news';

    /** Dialects the platform publishes in. */
    public const DIALECTS = ['sorani', 'badini'];

    /** The only categories the pipeline is allowed to assign. */
    public const CATEGORIES = [
        'AI Agents',
        'Image Generation',
        'Finance & Business',
        'LLMs & Base Models',
        'General AI',
    ];

    protected $fillable = [
        'title_sorani',
        'summary_sorani',
        'title_badini',
        'summary_badini',
        'image_url',
        'source_url',
        'category',
        'tags',
        'status',
        'published_at',
        'is_automated',
        'confidence_score',
        'firebase_key',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_automated' => 'boolean',
        'confidence_score' => 'integer',
    ];

    // ---------------------------------------------------------------- scopes

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /** Newest first — matches the front-end ordering. */
    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('published_at');
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $category ? $query->where('category', $category) : $query;
    }

    /** Articles carrying a given tag (works on both MySQL and SQLite). */
    public function scopeTagged(Builder $query, ?string $tag): Builder
    {
        return $tag ? $query->whereJsonContains('tags', $tag) : $query;
    }

    public function scopePublishedOn(Builder $query, mixed $date): Builder
    {
        return $query->whereDate('published_at', $date);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('published_at', now()->toDateString());
    }

    public function scopeYesterday(Builder $query): Builder
    {
        return $query->whereDate('published_at', now()->subDay()->toDateString());
    }

    /** Rolling window, e.g. `->withinDays(7)` for "this week". */
    public function scopeWithinDays(Builder $query, int $days): Builder
    {
        return $query->where('published_at', '>=', now()->subDays($days));
    }

    /**
     * Resolve a named range used by the front-end date filter.
     * Unknown ranges (including "all") return the query untouched.
     */
    public function scopeDateRange(Builder $query, ?string $range): Builder
    {
        return match ($range) {
            'today' => $query->today(),
            'yesterday' => $query->yesterday(),
            'week' => $query->withinDays(7),
            'month' => $query->withinDays(30),
            default => $query,
        };
    }

    // ------------------------------------------------------------- accessors

    /** Title in the requested dialect, falling back to Sorani. */
    public function titleFor(string $dialect): ?string
    {
        return $dialect === 'badini'
            ? ($this->title_badini ?: $this->title_sorani)
            : $this->title_sorani;
    }

    /** Summary in the requested dialect, falling back to Sorani. */
    public function summaryFor(string $dialect): ?string
    {
        return $dialect === 'badini'
            ? ($this->summary_badini ?: $this->summary_sorani)
            : $this->summary_sorani;
    }

    /**
     * The shape the Firebase `news` node — and therefore the live page —
     * expects. `_so` / `_ba` suffixes and the millisecond `timestamp` are
     * kept for backwards compatibility with news added by hand via the
     * admin panel.
     */
    public function toFirebaseArray(): array
    {
        return [
            'title_so' => (string) $this->title_sorani,
            'content_so' => (string) $this->summary_sorani,
            'title_ba' => (string) $this->title_badini,
            'content_ba' => (string) $this->summary_badini,
            'image_url' => (string) $this->image_url,
            'source_url' => (string) $this->source_url,
            'category' => (string) $this->category,
            'tags' => array_values($this->tags ?? []),
            'status' => (string) $this->status,
            'published_at' => optional($this->published_at)->toIso8601String(),
            'timestamp' => optional($this->published_at)->getTimestampMs()
                ?? now()->getTimestampMs(),
            'is_automated' => (bool) $this->is_automated,
            'confidence_score' => $this->confidence_score,
        ];
    }
}
