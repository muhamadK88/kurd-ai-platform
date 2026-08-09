<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Services\FirebaseNewsWriter;
use Illuminate\Console\Command;

/**
 * Replays SQL news rows that never made it into Firebase — e.g. because the
 * RTDB was unreachable or the credentials had expired when the pipeline ran.
 * Safe to run repeatedly: only rows with a null `firebase_key` are pushed.
 */
class SyncNewsToFirebase extends Command
{
    protected $signature = 'news:sync-firebase {--limit=25 : Maximum articles to replay}';

    protected $description = 'Push published news rows that have no firebase_key into the Firebase news node';

    public function handle(FirebaseNewsWriter $firebase): int
    {
        $pending = News::published()
            ->whereNull('firebase_key')
            ->latestFirst()
            ->limit((int) $this->option('limit'))
            ->get();

        if ($pending->isEmpty()) {
            $this->info('Nothing to sync — every published article already has a Firebase key.');

            return self::SUCCESS;
        }

        $this->info("Replaying {$pending->count()} article(s) into Firebase…");
        $failed = 0;

        foreach ($pending as $news) {
            try {
                $key = $firebase->push($news);
                $news->update(['firebase_key' => $key]);
                $this->line("  ✓ #{$news->id}  {$news->title_sorani}");
            } catch (\Throwable $e) {
                $failed++;
                $this->error("  ✗ #{$news->id}  {$e->getMessage()}");
            }
        }

        if ($failed > 0) {
            $this->warn("{$failed} article(s) still pending.");

            return self::FAILURE;
        }

        $this->info('All pending articles synced.');

        return self::SUCCESS;
    }
}
