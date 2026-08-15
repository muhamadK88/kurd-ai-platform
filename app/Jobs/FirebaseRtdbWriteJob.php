<?php

namespace App\Jobs;

use App\Services\FirebaseRtdbClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Performs a single Firebase RTDB mutation OUT of the request cycle.
 *
 * Supported methods: post | patch | delete. After a successful write the
 * matching collection cache keys are invalidated so the next page load
 * re-reads fresh data. Retries with backoff so a transient RTDB blip never
 * loses an admin edit permanently.
 */
class FirebaseRtdbWriteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $backoff = 15;

    public int $timeout = 20;

    /**
     * @param  string  $method  post|patch|delete
     * @param  string  $path  RTDB path relative to the DB root (e.g. courses.json)
     * @param  array<string, mixed>  $payload
     * @param  list<string>  $forgetKeys  Cache keys to drop after success
     */
    public function __construct(
        public string $method,
        public string $path,
        public array $payload = [],
        public array $forgetKeys = [],
    ) {
        $this->onQueue('firebase');
    }

    public static function post(string $path, array $payload, array $forgetKeys = []): self
    {
        return new self('post', $path, $payload, $forgetKeys);
    }

    public static function patch(string $path, array $payload, array $forgetKeys = []): self
    {
        return new self('patch', $path, $payload, $forgetKeys);
    }

    public static function delete(string $path, array $forgetKeys = []): self
    {
        return new self('delete', $path, [], $forgetKeys);
    }

    public function handle(FirebaseRtdbClient $rtdb): void
    {
        $method = strtolower($this->method);

        try {
            $response = match ($method) {
                'post' => $rtdb->post($this->path, $this->payload),
                'patch' => $rtdb->patch($this->path, $this->payload),
                'delete' => $rtdb->delete($this->path),
                default => throw new \InvalidArgumentException("Unsupported Firebase write method: {$method}"),
            };

            if ($response->failed()) {
                throw new \RuntimeException(
                    "Firebase {$method} {$this->path} failed: HTTP " . $response->status()
                );
            }

            if ($this->forgetKeys !== []) {
                $rtdb->forget(...$this->forgetKeys);
            }
        } catch (Throwable $e) {
            Log::warning('FirebaseRtdbWriteJob failed', [
                'method' => $method,
                'path' => $this->path,
                'error' => $e->getMessage(),
                'attempt' => $this->attempts(),
            ]);

            throw $e;
        }
    }
}
