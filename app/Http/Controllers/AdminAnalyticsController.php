<?php

namespace App\Http\Controllers;

use App\Models\AnalyticsEvent;
use App\Models\FergaLessonCompletion;
use App\Models\User;
use App\Services\FirebaseAuthService;
use Illuminate\Database\Blueprint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Real-time admin analytics for the About page dashboard.
 *
 * Security:
 *   1. Laravel session (Blade Auth): auth()->user()->is_admin  ← PRIMARY
 *   2. Firebase ID-token: admin email whitelist                ← FALLBACK
 *
 * GET /api/admin/analytics?range=day|week|month
 */
class AdminAnalyticsController extends Controller
{
    private const ADMIN_EMAILS = ['team@kurd-ai.com', 'mahamadkamaran890@gmail.com'];

    private const RANGES = ['day', 'week', 'month'];

    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    public function data(Request $request): JsonResponse
    {
        $adminEmail = $this->resolveAdmin($request);
        if ($adminEmail === null) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $this->ensureTable();

        $range = in_array($request->input('range'), self::RANGES, true)
            ? (string) $request->input('range')
            : 'day';

        $buckets = $this->buckets($range);
        $from = $buckets[0]['start'];

        $visitRows = $this->safe(
            fn () => AnalyticsEvent::query()
                ->where('event_type', AnalyticsEvent::TYPE_VISIT)
                ->where('created_at', '>=', $from)
                ->get(['created_at', 'section', 'user_key']),
            collect()
        );

        $loginRows = $this->safe(
            fn () => AnalyticsEvent::query()
                ->where('event_type', AnalyticsEvent::TYPE_LOGIN)
                ->where('created_at', '>=', $from)
                ->get(['created_at']),
            collect()
        );

        $lessonRows = $this->safe(
            fn () => FergaLessonCompletion::query()
                ->where('completed_at', '>=', $from)
                ->get(['completed_at']),
            collect()
        );

        $totals = $this->safe(function () {
            return [
                'users' => (int) User::query()->count(),
                'visits' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_VISIT)->count(),
                'logins' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_LOGIN)->count(),
                'lessons' => (int) FergaLessonCompletion::query()->count(),
                'unique_users' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_VISIT)
                    ->whereNotNull('user_key')->distinct('user_key')->count('user_key'),
                'unique_users_30d' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_VISIT)
                    ->whereNotNull('user_key')->where('created_at', '>=', now()->subDays(30))
                    ->distinct('user_key')->count('user_key'),
                'today_visits' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_VISIT)
                    ->where('created_at', '>=', now()->startOfDay())->count(),
                'today_logins' => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_LOGIN)
                    ->where('created_at', '>=', now()->startOfDay())->count(),
            ];
        }, ['users' => 0, 'visits' => 0, 'logins' => 0, 'lessons' => 0, 'unique_users' => 0, 'unique_users_30d' => 0, 'today_visits' => 0, 'today_logins' => 0]);

        $firstSeen = $this->safe(
            fn () => AnalyticsEvent::query()
                ->where('event_type', AnalyticsEvent::TYPE_VISIT)
                ->whereNotNull('user_key')
                ->selectRaw('user_key, MIN(created_at) AS first_seen')
                ->groupBy('user_key')
                ->pluck('first_seen', 'user_key'),
            collect()
        );

        $sections = [];
        foreach (AnalyticsEvent::SECTIONS as $key => $label) {
            $sectionRows = $visitRows->where('section', $key);
            $secTotal = $this->safe(
                fn () => (int) AnalyticsEvent::query()->where('event_type', AnalyticsEvent::TYPE_VISIT)
                    ->where('section', $key)->count(),
                0
            );

            $sections[$key] = [
                'label' => $label,
                'total' => $secTotal,
                'today' => $sectionRows->filter(fn ($row) => $row->created_at instanceof \Carbon\Carbon && $row->created_at->isToday())->count(),
                'week' => $sectionRows->filter(fn ($row) => $row->created_at instanceof \Carbon\Carbon && $row->created_at->greaterThanOrEqualTo(now()->subDays(6)->startOfDay()))->count(),
                'month' => $sectionRows->filter(fn ($row) => $row->created_at instanceof \Carbon\Carbon && $row->created_at->greaterThanOrEqualTo(now()->subDays(29)->startOfDay()))->count(),
                'series' => $this->bucketize($sectionRows, $buckets),
            ];
        }

        $courseCompletions = $this->safe(function () {
            if (!Schema::hasTable('ferga_lesson_completions') || !Schema::hasTable('ferga_courses')) {
                return collect();
            }

            return DB::table('ferga_lesson_completions')
                ->join('ferga_courses', 'ferga_courses.id', '=', 'ferga_lesson_completions.ferga_course_id')
                ->select('ferga_courses.title_so', 'ferga_courses.title_ba', DB::raw('COUNT(*) AS total'))
                ->groupBy('ferga_courses.id', 'ferga_courses.title_so', 'ferga_courses.title_ba')
                ->orderByDesc('total')
                ->get()
                ->map(fn ($row) => [
                    'title_so' => $row->title_so,
                    'title_ba' => $row->title_ba,
                    'total' => (int) $row->total,
                ])->values();
        }, collect());

        return response()->json([
            'admin' => $adminEmail,
            'range' => $range,
            'buckets' => collect($buckets)->map(fn ($b) => ['key' => $b['key'], 'label' => $b['label']])->values(),
            'totals' => $totals,
            'series' => [
                'visits' => $this->bucketize($visitRows, $buckets),
                'logins' => $this->bucketize($loginRows, $buckets),
                'new_users' => $this->newUsersSeries($firstSeen, $buckets),
                'lessons' => $this->bucketize($lessonRows->map(fn ($row) => (object) ['created_at' => $row->completed_at]), $buckets),
            ],
            'sections' => $sections,
            'courses' => $courseCompletions,
        ]);
    }

    /** Resolve admin identity (email) or null. */
    private function resolveAdmin(Request $request): ?string
    {
        /* 1) Blade Auth / Laravel session — PRIMARY */
        if (auth()->check()) {
            $account = auth()->user();
            $isAdmin = (bool) ($account->is_admin ?? false) || (($account->role ?? '') === 'admin');
            return $isAdmin ? strtolower((string) $account->email) : null;
        }

        /* 2) Firebase ID-token — FALLBACK */
        $token = (string) ($request->header('X-Firebase-Id-Token') ?: $request->bearerToken());
        if ($token !== '') {
            try {
                $user = $this->firebase->verifiedUser($token);
                $email = strtolower((string) ($user['email'] ?? ''));
                if (in_array($email, self::ADMIN_EMAILS, true)) {
                    return $email;
                }
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    /** Auto-create analytics_events table if missing (self-healing deploy). */
    private function ensureTable(): void
    {
        try {
            if (!Schema::hasTable('analytics_events')) {
                Schema::create('analytics_events', function (Blueprint $table) {
                    $table->id();
                    $table->string('event_type', 20)->index();
                    $table->string('section', 40)->default('home')->index();
                    $table->string('user_key', 64)->nullable()->index();
                    $table->string('user_uid', 64)->nullable()->index();
                    $table->string('user_email', 190)->nullable()->index();
                    $table->timestamp('created_at')->useCurrent()->index();
                });
            }
        } catch (\Throwable $e) {
            // queries below are individually guarded
        }
    }

    /** Run $fn or fall back to $default on any DB error. */
    private function safe(\Closure $fn, mixed $default): mixed
    {
        try {
            return $fn();
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /** Build range buckets (day=30 daily, week=12 weekly, month=12 monthly). */
    private function buckets(string $range): array
    {
        $now = now();
        $out = [];

        if ($range === 'month') {
            for ($i = 11; $i >= 0; $i--) {
                $start = $now->copy()->startOfMonth()->subMonths($i);
                $out[] = [
                    'key' => $start->format('Y-m'),
                    'label' => $start->format('m/y'),
                    'start' => $start,
                    'end' => $start->copy()->addMonth()->subSecond(),
                ];
            }
        } elseif ($range === 'week') {
            for ($i = 11; $i >= 0; $i--) {
                $start = $now->copy()->startOfWeek()->subWeeks($i);
                $out[] = [
                    'key' => $start->format('Y-m-d'),
                    'label' => $start->format('m/d'),
                    'start' => $start,
                    'end' => $start->copy()->addWeek()->subSecond(),
                ];
            }
        } else {
            for ($i = 29; $i >= 0; $i--) {
                $start = $now->copy()->startOfDay()->subDays($i);
                $out[] = [
                    'key' => $start->format('Y-m-d'),
                    'label' => $start->format('m/d'),
                    'start' => $start,
                    'end' => $start->copy()->addDay()->subSecond(),
                ];
            }
        }

        return $out;
    }

    /** Count rows per bucket. */
    private function bucketize(iterable $rows, array $buckets): array
    {
        $counts = array_fill(0, count($buckets), 0);
        foreach ($buckets as $i => $bucket) {
            foreach ($rows as $row) {
                $time = $row->created_at;
                if ($time >= $bucket['start'] && $time <= $bucket['end']) {
                    $counts[$i]++;
                }
            }
        }

        return $counts;
    }

    /** New unique users per bucket (first-ever visit of each user_key). */
    private function newUsersSeries($firstSeen, array $buckets): array
    {
        $counts = array_fill(0, count($buckets), 0);
        foreach ($firstSeen as $firstSeenAt) {
            foreach ($buckets as $i => $bucket) {
                if ($firstSeenAt >= $bucket['start'] && $firstSeenAt <= $bucket['end']) {
                    $counts[$i]++;
                    break;
                }
            }
        }

        return $counts;
    }
}
