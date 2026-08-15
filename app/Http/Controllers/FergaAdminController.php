<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\VerifiesFirebaseToken;
use App\Models\FergaCourse;
use App\Models\FergaLesson;
use App\Models\FergaSection;
use App\Services\FirebaseAuthService;
use App\Support\FergaAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * فێرگە — admin content-management APIs.
 *
 * Every route requires a verified Firebase identity whose email is either
 * in the ADMIN_EMAILS allow-list or has is_admin in the local users table
 * (the same policy FeedbackController/KnowledgeBaseController use).
 *
 * Capabilities: create/edit/delete courses, flip status
 * (active | locked | coming_soon), reorder the path, manage sections (بەش)
 * inside each course, and manage lessons — plus a paste-to-import endpoint
 * that turns a pasted outline ("بەشی یەکەم: …" / "وانەی ١: …") into real
 * sections + lessons so a whole course can be scaffolded in seconds.
 */
class FergaAdminController extends Controller
{
    use VerifiesFirebaseToken;

    /** requireAdmin() needs the injected Firebase service to resolve identity. */
    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }
    public function page()
    {
        return view('ferga_admin');
    }

    /* ------------------------------------------------------------------ */
    /* guard                                                               */
    /* ------------------------------------------------------------------ */

    private function requireAdmin(Request $request): ?JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$user || !$user['email']) {
            return response()->json(['error' => 'unauthorized'], 401);
        }

        return FergaAdmin::isEmailAdmin($user['email'])
            ? null
            : response()->json(['error' => 'forbidden'], 403);
    }

    /* ------------------------------------------------------------------ */
    /* courses                                                             */
    /* ------------------------------------------------------------------ */

    public function index(Request $request): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        return response()->json([
            'courses' => FergaCourse::query()
                ->withCount(['lessons', 'sections'])
                ->orderBy('position')
                ->get()
                ->map(fn (FergaCourse $c) => [
                    'id' => $c->id,
                    'position' => $c->position,
                    'title_so' => $c->title_so,
                    'title_ba' => $c->title_ba,
                    'desc_so' => $c->desc_so,
                    'desc_ba' => $c->desc_ba,
                    'icon' => $c->icon,
                    'accent' => $c->accent,
                    'status' => $c->status,
                    'lessons_count' => $c->lessons_count,
                    'sections_count' => $c->sections_count,
                ]),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $data = $this->validatedCourse($request);
        $data['position'] = (int) FergaCourse::max('position') + 1;

        return response()->json(['course' => FergaCourse::create($data)], 201);
    }

    public function update(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $course->update($this->validatedCourse($request));

        return response()->json(['course' => $course->fresh()]);
    }

    public function destroy(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $course->delete(); // lessons + completions cascade

        // close the gap in the sequence so the path stays 1..N
        FergaCourse::query()->where('position', '>', $course->position)
            ->decrement('position');

        return response()->json(['ok' => true]);
    }

    /** POST {course}/move { dir: 'up' | 'down' } — swap with the neighbour. */
    public function move(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $dir = $request->input('dir') === 'up' ? -1 : 1;
        $neighbour = FergaCourse::query()
            ->where('position', $course->position + $dir)
            ->first();

        if (!$neighbour) {
            return response()->json(['error' => 'at_end'], 422);
        }

        $a = $course->position;
        $b = $neighbour->position;

        // Vacate a slot first: the position column is UNIQUE, so two direct
        // updates would collide. Inside one transaction the swap is atomic.
        DB::transaction(function () use ($course, $neighbour, $a, $b) {
            $course->update(['position' => 0]);
            $neighbour->update(['position' => $a]);
            $course->update(['position' => $b]);
        });

        return response()->json(['ok' => true]);
    }

    /* ------------------------------------------------------------------ */
    /* lessons                                                             */
    /* ------------------------------------------------------------------ */

    public function lessons(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $course->load(['sections', 'lessons']);

        return response()->json([
            'course' => $course,
            'sections' => $course->sections->map(fn (FergaSection $s) => $s->toArrayValue()),
            'lessons' => $course->lessons->map(fn (FergaLesson $l) => $l->toContentArray()),
        ]);
    }

    public function storeLesson(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $data = $this->validatedLesson($request);
        $sectionId = $data['ferga_section_id'] ?? null;
        unset($data['ferga_section_id']);

        // Insert at the END of the chosen section (or the end of the course
        // when the section is empty / none is chosen), shifting everything
        // that comes after by one — the chain stays intact.
        $position = $this->nextLessonPositionInSection($course->id, $sectionId);
        $lesson = $this->insertLessonAt($course->id, $sectionId, $position, $data);

        return response()->json(['lesson' => $lesson->fresh()->toContentArray()], 201);
    }

    public function updateLesson(Request $request, FergaLesson $lesson): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $lesson->update($this->validatedLesson($request, true));

        return response()->json(['lesson' => $lesson->fresh()->toContentArray()]);
    }

    public function destroyLesson(Request $request, FergaLesson $lesson): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $courseId = $lesson->ferga_course_id;
        $pos = $lesson->position;
        $lesson->delete();

        FergaLesson::query()
            ->where('ferga_course_id', $courseId)
            ->where('position', '>', $pos)
            ->decrement('position');

        return response()->json(['ok' => true]);
    }

    /**
     * POST lessons/{lesson}/move { dir } — swap with the neighbour lesson
     * INSIDE the same section. Section boundaries are fixed points: a lesson
     * never silently moves across a section, admins reorder sections instead.
     */
    public function moveLesson(Request $request, FergaLesson $lesson): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $dir = $request->input('dir') === 'up' ? -1 : 1;
        $neighbour = FergaLesson::query()
            ->where('ferga_course_id', $lesson->ferga_course_id)
            ->when(
                $lesson->ferga_section_id === null,
                fn ($q) => $q->whereNull('ferga_section_id'),
                fn ($q) => $q->where('ferga_section_id', $lesson->ferga_section_id)
            )
            ->where('position', $lesson->position + $dir)
            ->first();

        if (!$neighbour) {
            return response()->json(['error' => 'at_end'], 422);
        }

        $a = $lesson->position;
        $b = $neighbour->position;

        DB::transaction(function () use ($lesson, $neighbour, $a, $b) {
            $lesson->update(['position' => 0]);
            $neighbour->update(['position' => $a]);
            $lesson->update(['position' => $b]);
        });

        return response()->json(['ok' => true]);
    }

    /* ------------------------------------------------------------------ */
    /* sections (بەش)                                                      */
    /* ------------------------------------------------------------------ */

    public function sections(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        return response()->json([
            'course' => $course,
            'sections' => $course->sections->map(fn (FergaSection $s) => $s->toArrayValue()),
        ]);
    }

    public function storeSection(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $data = $this->validatedSection($request);
        $data['ferga_course_id'] = $course->id;
        $data['position'] = (int) FergaSection::where('ferga_course_id', $course->id)->max('position') + 1;

        return response()->json(['section' => FergaSection::create($data)], 201);
    }

    public function updateSection(Request $request, FergaSection $section): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $section->update($this->validatedSection($request));

        return response()->json(['section' => $section->fresh()]);
    }

    /** DELETE a section — its lessons keep their place (بێ بەش group). */
    public function destroySection(Request $request, FergaSection $section): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $courseId = $section->ferga_course_id;
        $pos = $section->position;
        $section->delete(); // ferga_section_id is nulled by the FK (nullOnDelete)

        FergaSection::query()
            ->where('ferga_course_id', $courseId)
            ->where('position', '>', $pos)
            ->decrement('position');

        return response()->json(['ok' => true]);
    }

    /** POST sections/{section}/move { dir: 'up' | 'down' } — swap sections. */
    public function moveSection(Request $request, FergaSection $section): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $dir = $request->input('dir') === 'up' ? -1 : 1;
        $neighbour = FergaSection::query()
            ->where('ferga_course_id', $section->ferga_course_id)
            ->where('position', $section->position + $dir)
            ->first();

        if (!$neighbour) {
            return response()->json(['error' => 'at_end'], 422);
        }

        $a = $section->position;
        $b = $neighbour->position;

        DB::transaction(function () use ($section, $neighbour, $a, $b) {
            $section->update(['position' => 0]);
            $neighbour->update(['position' => $a]);
            $section->update(['position' => $b]);
        });

        return response()->json(['ok' => true]);
    }

    /* ------------------------------------------------------------------ */
    /* import outline                                                      */
    /* ------------------------------------------------------------------ */

    /**
     * POST /api/ferga/admin/courses/{course}/import-outline  { text }
     *
     * Scaffold sections + lessons from a pasted outline so a whole course
     * can be built in seconds. Supported line shapes:
     *
     *   بەشی یەکەم: دەروازەیەک بۆ جیهانی نوێ      ← section (word or number)
     *   Section 1: Getting started                 ← english variant
     *   وانەی ١: بەخێرهاتن بۆ داڕشتنەوەی مێشک      ← lesson
     *   Lesson 12 - Neural Networks                ← english variant
     *   ١٢. تۆڕە دەمارییەکان                        ← bare numbered item → lesson
     *
     * Sections are appended after any existing ones; lessons get empty
     * bilingual content that the admin fills in later.
     */
    public function importOutline(Request $request, FergaCourse $course): JsonResponse
    {
        if ($err = $this->requireAdmin($request)) return $err;

        $data = $request->validate(['text' => ['required', 'string', 'max:20000']]);
        $parsed = $this->parseOutline($data['text']);

        $sectionCount = 0;
        $lessonCount = 0;

        DB::transaction(function () use ($course, $parsed, &$sectionCount, &$lessonCount) {
            $lastSectionPos = (int) FergaSection::where('ferga_course_id', $course->id)->max('position');

            foreach ($parsed['sections'] as $s) {
                $section = FergaSection::create([
                    'ferga_course_id' => $course->id,
                    'position' => ++$lastSectionPos,
                    'title_so' => $s['title'],
                    'title_ba' => $s['title'],
                ]);
                $sectionCount++;

                $lastPos = (int) FergaLesson::where('ferga_course_id', $course->id)->max('position');
                foreach ($s['lessons'] as $title) {
                 $this->insertLessonAt($course->id, $section->id, ++$lastPos, [
                         'title_so' => $title,
                         'title_ba' => $title,
                         'code_language' => 'python',
                     ]);
                    $lessonCount++;
                }
            }

            $lastPos = (int) FergaLesson::where('ferga_course_id', $course->id)->max('position');
            foreach ($parsed['loose_lessons'] as $title) {
                $this->insertLessonAt($course->id, null, ++$lastPos, [
                    'title_so' => $title,
                    'title_ba' => $title,
                    'code_language' => 'python',
                ]);
                $lessonCount++;
            }
        });

        return response()->json([
            'ok' => true,
            'sections_created' => $sectionCount,
            'lessons_created' => $lessonCount,
        ], 201);
    }

    /* ------------------------------------------------------------------ */
    /* validation                                                          */
    /* ------------------------------------------------------------------ */

    private function validatedCourse(Request $request): array
    {
        $data = $request->validate([
            'title_so' => ['required', 'string', 'max:255'],
            'title_ba' => ['required', 'string', 'max:255'],
            'desc_so' => ['nullable', 'string', 'max:4000'],
            'desc_ba' => ['nullable', 'string', 'max:4000'],
            'icon' => ['nullable', 'string', 'max:16'],
            'accent' => ['nullable', 'string', 'max:32'],
            'status' => ['nullable', 'in:active,locked,coming_soon'],
        ]);

        if (empty($data['icon'])) $data['icon'] = '📘';
        if (empty($data['status'])) $data['status'] = 'active';

        return $data;
    }

    private function validatedSection(Request $request): array
    {
        return $request->validate([
            'title_so' => ['required', 'string', 'max:255'],
            'title_ba' => ['required', 'string', 'max:255'],
        ]);
    }

    private function validatedLesson(Request $request, bool $partial = false): array
    {
        // On partial (PATCH-style) updates every field is optional and only
        // the explicitly-posted ones are written back.
        $title = $partial ? 'sometimes' : 'required';

        $data = $request->validate([
            'title_so' => [$title, 'string', 'max:255'],
            'title_ba' => [$title, 'string', 'max:255'],
            'desc_so' => ['nullable', 'string', 'max:4000'],
            'desc_ba' => ['nullable', 'string', 'max:4000'],
            'content_so' => ['nullable', 'string'],
            'content_ba' => ['nullable', 'string'],
            'code_language' => ['nullable', 'in:python'],
            'starter_code' => ['nullable', 'string'],
            'status' => ['nullable', 'in:active,locked,coming_soon'],
            'section_id' => ['nullable', 'integer', 'exists:ferga_sections,id'],
            'media' => ['nullable', 'array'],
        ]);

        // only keep explicitly-posted optional fields (partial updates)
        foreach (['title_so', 'title_ba', 'desc_so', 'desc_ba', 'content_so', 'content_ba', 'starter_code', 'code_language', 'status', 'section_id', 'media'] as $f) {
            if (!array_key_exists($f, $data)) unset($data[$f]);
        }

        // the API talks about sections as `section_id`, the column is ferga_section_id
        if (array_key_exists('section_id', $data)) {
            $data['ferga_section_id'] = $data['section_id'];
            unset($data['section_id']);
        }

        return $data;
    }

    /* ------------------------------------------------------------------ */
    /* lesson placement helpers                                            */
    /* ------------------------------------------------------------------ */

    /** Position for a new lesson so it lands at the END of its section. */
    private function nextLessonPositionInSection(int $courseId, ?int $sectionId): int
    {
        $max = FergaLesson::query()
            ->where('ferga_course_id', $courseId)
            ->when(
                $sectionId === null,
                fn ($q) => $q->whereNull('ferga_section_id'),
                fn ($q) => $q->where('ferga_section_id', $sectionId)
            )
            ->max('position');

        return $max !== null
            ? $max + 1
            : (int) FergaLesson::query()->where('ferga_course_id', $courseId)->max('position') + 1;
    }

    /**
     * Create a lesson at an exact global position. Lessons at/after that
     * position are shifted +1 first, one row at a time in descending order
     * (each step writes into the slot the previous step just vacated, so the
     * UNIQUE (course, position) index is never violated mid-transaction).
     * Works identically on MySQL and SQLite.
     */
    private function insertLessonAt(int $courseId, ?int $sectionId, int $position, array $data): FergaLesson
    {
        return DB::transaction(function () use ($courseId, $sectionId, $position, $data) {
            FergaLesson::query()
                ->where('ferga_course_id', $courseId)
                ->where('position', '>=', $position)
                ->orderByDesc('position')
                ->get()
                ->each(fn (FergaLesson $l) => $l->update(['position' => $l->position + 1]));

            $lesson = FergaLesson::create($data + [
                'ferga_course_id' => $courseId,
                'ferga_section_id' => $sectionId,
                'position' => $position,
            ]);

            return $lesson;
        });
    }

    /* ------------------------------------------------------------------ */
    /* outline parser                                                      */
    /* ------------------------------------------------------------------ */

    /** Digits in Arabic-Indic (٠-٩), Persian (۰-۹) or Latin — all accepted. */
    private const NUM = '[0-9۰-۹٠-٩]+';

    private function parseOutline(string $text): array
    {
        $ordinals = '(?:یەکەم|دووەم|سێیەم|چوارەم|پێنجەم|شەشەم|حەوتەم|هەشتەم|نۆیەم|دەیەم|یازدەهەم|دوازدەهەم|سیانزەهەم|چواردەهەم|پازدەهەم|شانزەهەم|حەڤدەهەم|هەژدەهەم|نۆزدەهەم|بیستەم|' . self::NUM . ')';

        $sections = [];
        $loose = [];
        $current = -1;

        // NOTE: avoid /\R/ here — without the /u flag PCRE treats the raw byte
        // 0x85 (NEL) as a line break, and 0x85 is the continuation byte of the
        // Kurdish letter م (UTF-8 d9 85), so it would split every such word.
        $lines = preg_split('/\r\n|\r|\n/', $text);

        foreach ($lines as $raw) {
            $line = trim($raw);
            $line = trim($line, " \t\r\n•-–—*·");
            $line = trim($line);
            if ($line === '') continue;

            // Section: "بەشی یەکەم: دەروازەیەک…" | "بەش ١: …" | "Section 1: …"
            if (preg_match('/^(?:بەشی|بەش)\s*(?:' . $ordinals . ')?\s*[:،:-]?\s*(.+)$/u', $line, $m)
                || preg_match('/^(?:section|part)\s*' . self::NUM . '\s*[:.\-]?\s*(.+)$/iu', $line, $m)) {
                $sections[] = ['title' => $this->cleanTitle($m[1]), 'lessons' => []];
                $current = count($sections) - 1;
                continue;
            }

            // Lesson: "وانەی ١: بەخێرهاتن…" | "وانەی 1 - …" | "Lesson 12: …"
            if (preg_match('/^(?:وانەی|وانه|وانە)\s*' . self::NUM . '\s*[:،.:\-]?\s*(.+)$/u', $line, $m)
                || preg_match('/^(?:lesson|درس)\s*' . self::NUM . '\s*[:.\-]?\s*(.+)$/iu', $line, $m)) {
                $title = $this->cleanTitle($m[1]);
                if ($current >= 0) $sections[$current]['lessons'][] = $title;
                else $loose[] = $title;
                continue;
            }

            // Bare numbered item inside a section: "١٢. تۆڕە دەمارییەکان"
            if ($current >= 0 && preg_match('/^' . self::NUM . '\s*[.:)٫]\s*(.+)$/u', $line, $m)) {
                $sections[$current]['lessons'][] = $this->cleanTitle($m[1]);
                continue;
            }
        }

        return ['sections' => $sections, 'loose_lessons' => $loose];
    }

    private function cleanTitle(string $s): string
    {
        $s = trim($s);
        $s = preg_replace('/\s+/u', ' ', $s);
        $s = rtrim($s, '.؛:،');
        return trim($s);
    }
}