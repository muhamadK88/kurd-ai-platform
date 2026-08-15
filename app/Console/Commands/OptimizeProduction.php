<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/**
 * One-step production readiness command.
 *
 * Caches config, events, and views. Route caching is attempted but skipped
 * gracefully if the application still uses Closure routes (Laravel's
 * route:cache serializes routes and cannot serialize Closures).
 *
 * Usage:
 *   php artisan app:optimize-production
 *
 * Before running in production you should also set:
 *   APP_DEBUG=false
 *   LOG_LEVEL=warning
 *   CACHE_STORE=file
 *   SESSION_DRIVER=file
 *   QUEUE_CONNECTION=database
 *   DB_JOURNAL_MODE=wal
 * And start a queue worker:
 *   php artisan queue:work --queue=firebase,default --sleep=3 --tries=3
 */
class OptimizeProduction extends Command
{
    protected $signature = 'app:optimize-production';

    protected $description = 'Cache config/events/views and safely attempt route caching';

    public function handle(): int
    {
        $this->info('Optimizing for production...');

        Artisan::call('config:cache', [], $this->output);
        Artisan::call('event:cache', [], $this->output);
        Artisan::call('view:cache', [], $this->output);

        if ($this->hasClosureRoutes()) {
            $this->warn('Route caching skipped: application still uses Closure routes.');
            $this->warn('Convert closure routes to controller methods, then run:');
            $this->warn('  php artisan route:cache');
        } else {
            Artisan::call('route:cache', [], $this->output);
        }

        $this->info('Done. Remember to restart your queue workers and web server.');

        return self::SUCCESS;
    }

    private function hasClosureRoutes(): bool
    {
        try {
            foreach (Route::getRoutes() as $route) {
                if ($route->getAction('uses') instanceof \Closure) {
                    return true;
                }
            }
        } catch (\Throwable) {
            // If the router isn't booted yet, assume closures may exist.
            return true;
        }

        return false;
    }
}
