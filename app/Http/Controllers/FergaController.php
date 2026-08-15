<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\VerifiesFirebaseToken;
use App\Models\FergaCourse;
use App\Models\FergaLesson;
use App\Models\FergaLessonCompletion;
use App\Models\FergaSection;
use App\Services\FirebaseAuthService;
use App\Support\FergaAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * فێرگە — student-facing learning APIs.
 *
 * The ten courses are a strictly sequential path. withUnlockState() walks
 * the chain once and annotates every course with the user's completion
 * count and lock state:
 *
 *   • course N is unlocked ⇔ status = active AND every earlier course is
 *     fully completed by this user (a coming_soon/locked course breaks the
 *     chain, so everything after it stays locked too);
 *   • a course is "completed" when it has lessons and all of them carry a
 *     completion row for the user's Firebase UID.
 *
 * Inside a course the lessons are sequential the same way: lesson N opens
 * only when every earlier lesson in the course is completed (admins bypass
 * every lock so they can preview + edit content freely).
 *
 * Identity comes from the Firebase ID token (optional for the read
 * endpoints — anonymous visitors simply see course 1 / lesson 1 only;
 * writes always require a verified token).
 */
class FergaController extends Controller
{
    use VerifiesFirebaseToken;

    /** firebaseUser() comes from VerifiesFirebaseToken; the service is injected. */
    public function __construct(private readonly FirebaseAuthService $firebase)
    {
    }

    /** Ferga admins are exempt from every lock (used by the in-place editor). */
    private function isAdmin(?array $user): bool
    {
        return !empty($user['email']) && FergaAdmin::isEmailAdmin($user['email']);
    }

    /**
     * Lesson N is reachable only when every earlier lesson in the same
     * course is completed. Anonymous visitors get lesson 1 only.
     */
    private function lessonSequenceOpen(FergaLesson $lesson, ?string $uid): bool
    {
        if (!$uid) {
            return (int) $lesson->position <= 1;
        }

        $prevIds = FergaLesson::query()
            ->where('ferga_course_id', $lesson->ferga_course_id)
            ->where('position', '<', $lesson->position)
            ->pluck('id');

        if ($prevIds->isEmpty()) {
            return true;
        }

        return FergaLessonCompletion::query()
            ->where('user_uid', $uid)
            ->whereIn('ferga_lesson_id', $prevIds)
            ->count() === $prevIds->count();
    }

    /* ------------------------------------------------------------------ */
    /* page                                                                */
    /* ------------------------------------------------------------------ */

    public function page()
    {
        return view('ferga_learn');
    }

    /* ------------------------------------------------------------------ */
    /* read APIs                                                           */
    /* ------------------------------------------------------------------ */

    /** GET /api/ferga/courses — the full path with per-user lock state. */
    public function courses(Request $request): JsonResponse
    {
        $user = $this->firebaseUser($request);
        $uid = $user['uid'] ?? null;
        $admin = $this->isAdmin($user);

        return response()->json([
            'authenticated' => (bool) $user,
            'uid' => $uid,
            'is_admin' => $admin,
            'courses' => $this->withUnlockState(
                FergaCourse::query()->withCount('lessons')->orderBy('position')->get(),
                $uid,
                $admin
            ),
        ]);
    }

    /** GET /api/ferga/courses/{course} — course + lesson meta (no content). */
    public function course(Request $request, FergaCourse $course): JsonResponse
    {
        $user = $this->firebaseUser($request);
        $uid = $user['uid'] ?? null;
        $admin = $this->isAdmin($user);
        $courses = FergaCourse::query()->withCount('lessons')->orderBy('position')->get();
        $states = collect($this->withUnlockState($courses, $uid, $admin))->keyBy('id');
        $state = $states[$course->id] ?? null;

        if (!$state || $state['locked']) {
            return response()->json([
                'error' => 'locked',
                'message' => $state['lock_reason'] ?? 'unknown',
            ], 403);
        }

        $done = $uid
            ? FergaLessonCompletion::where('user_uid', $uid)
                ->where('ferga_course_id', $course->id)
                ->pluck('ferga_lesson_id')
                ->flip()->map(fn () => true)
            : collect();

        $course->load(['sections', 'lessons']); // single query — no lazy N+1 on the lesson list

        // Sequential lesson chain: lesson N opens only when every earlier
        // lesson is completed. An admin-locked lesson (status != active)
        // stays closed too — it shows "بەم زوانە" and breaks the chain for
        // members (admins bypass everything so they can preview/edit).
        $prevAllDone = true;
        $lessons = $course->lessons->sortBy('position')->map(function (FergaLesson $l) use (&$prevAllDone, $done, $admin) {
            $lDone = (bool) $done->get($l->id, false);
            $statusLocked = $l->status !== FergaLesson::STATUS_ACTIVE;
            $lLocked = !$admin && ($statusLocked || !$prevAllDone);

            $meta = $l->toMetaArray($lDone);
            $meta['locked'] = $lLocked;
            $meta['lock_reason'] = $lLocked
                ? ($statusLocked ? ($l->status === FergaLesson::STATUS_COMING_SOON ? 'coming_soon' : 'admin_locked') : 'lesson_sequence')
                : null;

            $prevAllDone = $prevAllDone && $lDone && !$statusLocked;

            return $meta;
        })->values();

        return response()->json([
            'course' => $state,
            'sections' => $course->sections->map(fn (FergaSection $s) => $s->toArrayValue())->values(),
            'lessons' => $lessons,
        ]);
    }

    /** GET /api/ferga/lessons/{lesson} — full lesson content. */
    public function lesson(Request $request, FergaLesson $lesson): JsonResponse
    {
        $user = $this->firebaseUser($request);
        $uid = $user['uid'] ?? null;
        $admin = $this->isAdmin($user);

        $course = $lesson->course;
        $courses = FergaCourse::query()->withCount('lessons')->orderBy('position')->get();
        $state = collect($this->withUnlockState($courses, $uid, $admin))->keyBy('id')[$course->id] ?? null;

        if (!$state || $state['locked']) {
            return response()->json(['error' => 'locked'], 403);
        }

        if (!$admin) {
            if ($lesson->status !== FergaLesson::STATUS_ACTIVE) {
                return response()->json([
                    'error' => 'lesson_locked',
                    'lock_reason' => $lesson->status === FergaLesson::STATUS_COMING_SOON ? 'coming_soon' : 'admin_locked',
                ], 403);
            }

            if (!$this->lessonSequenceOpen($lesson, $uid)) {
                return response()->json(['error' => 'lesson_locked', 'lock_reason' => 'lesson_sequence'], 403);
            }
        }

        $completed = $uid && FergaLessonCompletion::where('user_uid', $uid)
            ->where('ferga_lesson_id', $lesson->id)->exists();

        return response()->json([
            'lesson' => $lesson->toContentArray($completed),
            'course' => ['id' => $course->id, 'title_so' => $course->title_so, 'title_ba' => $course->title_ba],
        ]);
    }

    /* ------------------------------------------------------------------ */
    /* progress                                                            */
    /* ------------------------------------------------------------------ */

    /**
     * POST /api/ferga/lessons/{lesson}/complete  { completed: bool }
     *
     * Toggle the completion ledger. Validates that the lesson's course is
     * unlocked for this user, then returns fresh progress so the UI can
     * immediately paint checkmarks / unlock the next course.
     */
    public function completeLesson(Request $request, FergaLesson $lesson): JsonResponse
    {
        $user = $this->firebaseUser($request);

        if (!$user) {
            return response()->json(['error' => 'auth_required'], 401);
        }

        $data = $request->validate(['completed' => ['nullable', 'boolean']]);
        $wantCompleted = $data['completed'] ?? true;
        $uid = $user['uid'];
        $admin = $this->isAdmin($user);

        $courses = FergaCourse::query()->withCount('lessons')->orderBy('position')->get();
        $state = collect($this->withUnlockState($courses, $uid, $admin))->keyBy('id')[$lesson->ferga_course_id] ?? null;

        if (!$state || $state['locked']) {
            return response()->json(['error' => 'locked'], 403);
        }

        // Members may only toggle a lesson they can actually open.
        if (!$admin) {
            if ($lesson->status !== FergaLesson::STATUS_ACTIVE) {
                return response()->json([
                    'error' => 'lesson_locked',
                    'lock_reason' => $lesson->status === FergaLesson::STATUS_COMING_SOON ? 'coming_soon' : 'admin_locked',
                ], 403);
            }

            if (!$this->lessonSequenceOpen($lesson, $uid)) {
                return response()->json(['error' => 'lesson_locked', 'lock_reason' => 'lesson_sequence'], 403);
            }
        }

        if ($wantCompleted) {
            FergaLessonCompletion::firstOrCreate(
                ['user_uid' => $uid, 'ferga_lesson_id' => $lesson->id],
                ['ferga_course_id' => $lesson->ferga_course_id]
            );
        } else {
            FergaLessonCompletion::where('user_uid', $uid)
                ->where('ferga_lesson_id', $lesson->id)
                ->delete();
        }

        $courses = FergaCourse::query()->withCount('lessons')->orderBy('position')->get();
        $fresh = collect($this->withUnlockState($courses, $uid, $admin))->keyBy('id')[$lesson->ferga_course_id];

        return response()->json([
            'ok' => true,
            'lesson_id' => $lesson->id,
            'lesson_completed' => $wantCompleted,
            'course' => $fresh,
        ]);
    }

    /* ------------------------------------------------------------------ */
    /* the unlock chain                                                    */
    /* ------------------------------------------------------------------ */

    /**
     * Annotate an ordered course list with per-user completion + lock
     * state. One pass, no N+1: completions for the uid are fetched in a
     * single grouped query.
     *
     * @return array<int, array>
     */
    private function withUnlockState($courses, ?string $uid, bool $adminBypass = false): array
    {
        $counts = [];

        if ($uid) {
            $counts = FergaLessonCompletion::query()
                ->where('user_uid', $uid)
                ->get()
                ->groupBy('ferga_course_id')
                ->map(fn ($rows) => $rows->count())
                ->all();
        }

        $out = [];
        $chainOpen = true;   // stays true while every earlier course is completed

        foreach ($courses as $course) {
            $lessonsCount = $course->lessons_count;
            $doneCount = min($counts[$course->id] ?? 0, $lessonsCount);
            $completed = $lessonsCount > 0 && $doneCount >= $lessonsCount;

            if ($course->status === FergaCourse::STATUS_COMING_SOON) {
                $locked = true;
                $reason = 'coming_soon';
            } elseif ($course->status === FergaCourse::STATUS_LOCKED) {
                $locked = true;
                $reason = 'admin_locked';
            } elseif (!$chainOpen) {
                $locked = true;
                $reason = 'sequence';
            } else {
                $locked = false;
                $reason = null;
            }

            // Admins bypass every lock so the in-place editor can reach
            // any course (status is still reported for the badge/select).
            if ($adminBypass) {
                $locked = false;
                $reason = null;
            }

            $out[] = [
                'id' => $course->id,
                'position' => $course->position,
                'title_so' => $course->title_so,
                'title_ba' => $course->title_ba,
                'desc_so' => $course->desc_so,
                'desc_ba' => $course->desc_ba,
                'icon' => $course->icon,
                'accent' => $course->accent,
                'status' => $course->status,
                'lessons_count' => $lessonsCount,
                'completed_lessons' => $doneCount,
                'completed' => $completed,
                'locked' => $locked,
                'lock_reason' => $reason,
            ];

            // the chain continues only through completed ACTIVE courses
            $chainOpen = $chainOpen && $completed && $course->status === FergaCourse::STATUS_ACTIVE;
        }

        return $out;
    }
}