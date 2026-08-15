<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Single gateway for Firebase Realtime Database HTTP I/O.
 *
 * Every outbound call carries strict timeouts (total 3s / connect 2s by
 * default). Read-only collections are cached under stable keys so a page
 * load never makes a live network round-trip. Callers that mutate data
 * MUST invalidate the matching cache key (see forget()).
 */
class FirebaseRtdbClient
{
    public const CACHE_COURSES = 'firebase.courses.v1';
    public const CACHE_AI_TOOLS = 'firebase.ai_tools.v1';
    public const CACHE_ACADEMIC_GUIDE = 'firebase.academic_guide.v1';
    public const CACHE_FERGA_LESSONS = 'firebase.ferga_lessons.v1';

    private string $baseUrl;

    public function __construct()
    {
        $url = (string) (config('kurdai.firebase.databaseURL')
            ?: config('services.firebase.database_url')
            ?: 'https://ai-platform-adb1b-default-rtdb.firebaseio.com');

        $this->baseUrl = rtrim($url, '/') . '/';
    }

    public function baseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Strict-timeout HTTP client. Total 3s / connect 2s keeps a slow or
     * unreachable RTDB from hanging the request cycle.
     */
    public function http(int $timeout = 3, int $connectTimeout = 2): PendingRequest
    {
        return Http::timeout($timeout)->connectTimeout($connectTimeout);
    }

    public function get(string $path, int $timeout = 3): Response
    {
        return $this->http($timeout)->get($this->url($path));
    }

    public function post(string $path, array $data, int $timeout = 3): Response
    {
        return $this->http($timeout)->post($this->url($path), $data);
    }

    public function patch(string $path, array $data, int $timeout = 3): Response
    {
        return $this->http($timeout)->patch($this->url($path), $data);
    }

    public function delete(string $path, int $timeout = 3): Response
    {
        return $this->http($timeout)->delete($this->url($path));
    }

    /**
     * Cached collection read. TTL defaults to kurdai.firebase.read_cache_ttl
     * (120s). Empty / failed responses still cache briefly so a flapping
     * RTDB cannot thrash every page load.
     */
    public function remember(string $cacheKey, string $path, ?int $ttl = null): array
    {
        $seconds = $ttl ?? (int) config('kurdai.firebase.read_cache_ttl', 120);

        return Cache::remember($cacheKey, now()->addSeconds(max(1, $seconds)), function () use ($path) {
            try {
                $json = $this->get($path)->json();

                return is_array($json) ? $json : [];
            } catch (\Throwable $e) {
                Log::warning('FirebaseRtdbClient: read failed', [
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);

                return [];
            }
        });
    }

    /** Drop one or more collection cache keys after a write. */
    public function forget(string ...$keys): void
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    private function url(string $path): string
    {
        return $this->baseUrl . ltrim($path, '/');
    }
}
