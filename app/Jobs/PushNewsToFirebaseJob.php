<?php

namespace App\Jobs;

use App\Models\News;
use App\Services\FirebaseNewsWriter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Mirrors a published news row into the Firebase RTDB `news` node — OUT of the
 * synchronous request cycle. The SQL `news` row is the source of truth for
 * de-duplication, so this job can fail and retry without ever producing a
 * duplicate on the next pipeline run.
 *
 * A dedicated `firebase` queue lets a worker be run alongside the default
 * queue (`php artisan queue:work --queue=firebase,default`) so user-facing
 * jobs are never delayed behind slow Firebase writes.
 */
class PushNewsToFirebaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Up to three attempts before the row is left for `news:sync-firebase`. */
    public int $tries = 3;

    /** Seconds between retries — gives a transient RTDB outage time to clear. */
    public int $backoff = 30;

    /** Max seconds the job may run before being killed. */
    public int $timeout = 30;

    public function __construct(public int $newsId)
    {
        $this->onQueue('firebase');
    }

    public function handle(FirebaseNewsWriter $firebase): void
    {
        $news = News::find($this->newsId);

        // Row deleted before the job ran — nothing to push.
        if (!$news) {
            return;
        }

        // Already mirrored by a previous run or the `news:sync-firebase` command.
        if ($news->firebase_key) {
            return;
        }

        try {
            $key = $firebase->push($news);

            if ($key) {
                $news->update(['firebase_key' => $key]);
            }
        } catch (Throwable $e) {
            Log::warning('PushNewsToFirebaseJob: Firebase mirror failed, will retry', [
                'news_id' => $news->id,
                'error' => $e->getMessage(),
            ]);

            // Re-throw so the queue retries with backoff; a final failure is
            // replayable via `php artisan news:sync-firebase`.
            throw $e;
        }
    }
}