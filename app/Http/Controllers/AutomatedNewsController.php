<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\FirebaseNewsWriter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * Ingest endpoint for the automated AI-news pipeline (scripts/news_pipeline.py).
 *
 * Protected by `Authorization: Bearer <WEBSITE_API_SECRET>` via the
 * `api.secret` middleware. Every accepted article is written twice:
 *   • to SQL (`news`) — queryable, date-filterable, de-duplicated;
 *   • to Firebase RTDB (`news`) — the node the live page renders from.
 *
 * The SQL row is the source of truth for de-duplication, so a Firebase
 * failure never produces a duplicate on the next run.
 */
class AutomatedNewsController extends Controller
{
    public function __construct(private FirebaseNewsWriter $firebase)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title_sorani' => ['required', 'string', 'max:255'],
            'summary_sorani' => ['required', 'string'],
            'title_badini' => ['required', 'string', 'max:255'],
            'summary_badini' => ['required', 'string'],
            'image_url' => ['required', 'url', 'max:2000'],
            'source_url' => ['required', 'url', 'max:500'],
            'published_at' => ['nullable', 'date'],
            'category' => ['required', 'string', Rule::in(News::CATEGORIES)],
            'tags' => ['nullable', 'array', 'max:3'],
            'tags.*' => ['string', 'max:40'],
            'confidence_score' => ['nullable', 'integer', 'min:0', 'max:10'],
        ]);

        // Idempotency: the pipeline re-reads the same RSS feeds every 2 hours.
        $existing = News::where('source_url', $data['source_url'])->first();

        if ($existing) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'This article has already been published.',
                'id' => $existing->id,
                'firebase_key' => $existing->firebase_key,
            ], 200);
        }

        $news = News::create([
            'title_sorani' => $data['title_sorani'],
            'summary_sorani' => $data['summary_sorani'],
            'title_badini' => $data['title_badini'],
            'summary_badini' => $data['summary_badini'],
            'image_url' => $data['image_url'],
            'source_url' => $data['source_url'],
            'category' => $data['category'],
            'tags' => array_values($data['tags'] ?? []),
            'status' => 'published',
            'published_at' => isset($data['published_at'])
                ? Carbon::parse($data['published_at'])
                : now(),
            'is_automated' => true,
            'confidence_score' => $data['confidence_score'] ?? null,
        ]);

        // Mirror to Firebase so the article shows up on /news immediately.
        // A failure here is reported but does NOT roll back the SQL row —
        // `php artisan news:sync-firebase` can replay it.
        $firebaseKey = null;
        $firebaseError = null;

        try {
            $firebaseKey = $this->firebase->push($news);

            if ($firebaseKey) {
                $news->update(['firebase_key' => $firebaseKey]);
            }
        } catch (\Throwable $e) {
            $firebaseError = $e->getMessage();
            Log::error('AutomatedNews: stored in SQL but Firebase mirror failed', [
                'news_id' => $news->id,
                'error' => $firebaseError,
            ]);
        }

        return response()->json([
            'status' => 'published',
            'id' => $news->id,
            'firebase_key' => $firebaseKey,
            'firebase_error' => $firebaseError,
            'published_at' => $news->published_at->toIso8601String(),
            'category' => $news->category,
            'tags' => $news->tags,
        ], 201);
    }

    /**
     * Public read endpoint with dialect selection and date filtering.
     *
     *   GET /api/news?dialect=badini&range=today&category=AI%20Agents&tag=Base
     *
     * `range` accepts today | yesterday | week | month | all, and `date`
     * accepts an explicit YYYY-MM-DD for a single day.
     */
    public function index(Request $request): JsonResponse
    {
        $params = $request->validate([
            'dialect' => ['nullable', Rule::in(News::DIALECTS)],
            'range' => ['nullable', Rule::in(['today', 'yesterday', 'week', 'month', 'all'])],
            'date' => ['nullable', 'date_format:Y-m-d'],
            'category' => ['nullable', 'string', Rule::in(News::CATEGORIES)],
            'tag' => ['nullable', 'string', 'max:40'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:60'],
        ]);

        $dialect = $params['dialect'] ?? 'sorani';

        $query = News::query()
            ->published()
            ->dateRange($params['range'] ?? null)
            ->category($params['category'] ?? null)
            ->tagged($params['tag'] ?? null)
            ->latestFirst();

        if (! empty($params['date'])) {
            $query->publishedOn($params['date']);
        }

        $page = $query->paginate($params['per_page'] ?? 12);

        return response()->json([
            'dialect' => $dialect,
            'range' => $params['range'] ?? 'all',
            'total' => $page->total(),
            'current_page' => $page->currentPage(),
            'last_page' => $page->lastPage(),
            'data' => collect($page->items())->map(fn (News $n) => [
                'id' => $n->id,
                'title' => $n->titleFor($dialect),
                'summary' => $n->summaryFor($dialect),
                'title_sorani' => $n->title_sorani,
                'summary_sorani' => $n->summary_sorani,
                'title_badini' => $n->title_badini,
                'summary_badini' => $n->summary_badini,
                'image_url' => $n->image_url,
                'source_url' => $n->source_url,
                'category' => $n->category,
                'tags' => $n->tags ?? [],
                'published_at' => optional($n->published_at)->toIso8601String(),
                'is_automated' => $n->is_automated,
            ])->all(),
        ]);
    }
}
