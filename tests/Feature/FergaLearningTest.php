<?php

namespace Tests\Feature;

use App\Models\FergaCourse;
use App\Models\FergaLesson;
use App\Models\FergaSection;
use App\Services\FirebaseAuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FergaLearningTest extends TestCase
{
    use RefreshDatabase;

    public const UID = 'ferga-test-student-1';
    public const ADMIN_EMAIL = 'team@kurd-ai.com';

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedCourses();

        // A fake auth service so tests never touch the real Firebase SDK.
        // One fake handles every token: students (tok-valid) and the admin
        // (tok-admin) — the controller instance is cached on the route, so we
        // cannot swap bindings between requests in the same test.
        $fake = new class extends FirebaseAuthService {
            public function __construct()
            {
            }

            public function verifyUserFromToken(string $idToken): ?array
            {
                if ($idToken === 'tok-admin') {
                    return ['uid' => 'admin-1', 'email' => FergaLearningTest::ADMIN_EMAIL, 'name' => 'Admin'];
                }

                return $idToken === 'tok-valid'
                    ? ['uid' => FergaLearningTest::UID, 'email' => 'student@example.com', 'name' => 'Test Student']
                    : null;
            }
        };

        $this->app->instance(FirebaseAuthService::class, $fake);
    }

    private function seedCourses(): void
    {
        foreach ([1, 2, 3] as $pos) {
            $course = FergaCourse::create([
                'position' => $pos,
                'title_so' => "Course $pos SO",
                'title_ba' => "Course $pos BA",
                'icon' => '?',
                'accent' => 'cyan',
                'status' => FergaCourse::STATUS_ACTIVE,
            ]);

            foreach ([1, 2, 3] as $lp) {
                FergaLesson::create([
                    'ferga_course_id' => $course->id,
                    'position' => $lp,
                    'title_so' => "Course $pos Lesson $lp SO",
                    'title_ba' => "Course $pos Lesson $lp BA",
                    'desc_so' => "Lesson desc $pos/$lp SO",
                    'desc_ba' => "Lesson desc $pos/$lp BA",
                    'content_so' => '<p>Content</p>',
                    'content_ba' => '<p>Navêrok</p>',
                    'code_language' => 'python',
                ]);
            }
        }
    }

    private function authedHeaders(): array
    {
        return ['X-Firebase-Id-Token' => 'tok-valid'];
    }

    public function test_anonymous_user_only_sees_course_one_unlocked(): void
    {
        $res = $this->getJson('/api/ferga/courses');

        $res->assertOk();
        $res->assertJson([
            'authenticated' => false,
            'uid' => null,
        ]);

        $courses = collect($res->json('courses'));
        $this->assertFalse($courses->firstWhere('position', 1)['locked']);
        $this->assertTrue($courses->firstWhere('position', 2)['locked']);
        $this->assertTrue($courses->firstWhere('position', 3)['locked']);
    }

    public function test_authenticated_user_starts_with_chain_locked_after_course_one(): void
    {
        $res = $this->getJson('/api/ferga/courses', $this->authedHeaders());

        $res->assertOk();
        $res->assertJson(['authenticated' => true]);

        $courses = collect($res->json('courses'));
        $this->assertFalse($courses->firstWhere('position', 1)['locked']);
        $this->assertTrue($courses->firstWhere('position', 2)['locked']);
        $this->assertTrue($courses->firstWhere('position', 3)['locked']);
        $this->assertSame('sequence', $courses->firstWhere('position', 2)['lock_reason']);
    }

    public function test_locked_course_detail_returns_403(): void
    {
        $course2 = FergaCourse::where('position', 2)->first();

        $res = $this->getJson("/api/ferga/courses/{$course2->id}", $this->authedHeaders());

        $res->assertForbidden();
    }

    public function test_courses_reports_admin_flag_and_admin_bypasses_locks(): void
    {
        // Students / anonymous are never admin.
        $res = $this->getJson('/api/ferga/courses', $this->authedHeaders());
        $res->assertOk();
        $res->assertJson(['is_admin' => false]);

        // The admin token is recognized.
        $res = $this->getJson('/api/ferga/courses', ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $res->assertJson(['is_admin' => true]);

        // Admin bypasses the course chain: a locked course opens for them.
        $course2 = FergaCourse::where('position', 2)->first();
        $res = $this->getJson("/api/ferga/courses/{$course2->id}", ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
    }

    public function test_lessons_open_sequentially_only_after_completion(): void
    {
        $course1 = FergaCourse::where('position', 1)->first();
        $l1 = $course1->lessons()->orderBy('position')->get()[0];
        $l2 = $course1->lessons()->orderBy('position')->get()[1];

        // Course detail reports the chain: lesson 1 open, lesson 2 locked.
        $res = $this->getJson("/api/ferga/courses/{$course1->id}", $this->authedHeaders());
        $res->assertOk();
        $lessons = $res->json('lessons');
        $this->assertFalse($lessons[0]['locked']);
        $this->assertTrue($lessons[1]['locked']);
        $this->assertSame('lesson_sequence', $lessons[1]['lock_reason']);

        // The locked lesson cannot be read...
        $res = $this->getJson("/api/ferga/lessons/{$l2->id}", $this->authedHeaders());
        $res->assertStatus(403);

        // ...and cannot be completed out of order.
        $res = $this->postJson("/api/ferga/lessons/{$l2->id}/complete", [], $this->authedHeaders());
        $res->assertStatus(403);

        // Complete lesson 1 → lesson 2 opens.
        $this->postJson("/api/ferga/lessons/{$l1->id}/complete", [], $this->authedHeaders())->assertOk();
        $res = $this->getJson("/api/ferga/lessons/{$l2->id}", $this->authedHeaders());
        $res->assertOk();
        $res->assertJsonPath('lesson.completed', false);

        // Anonymous visitors get lesson 1 only.
        $res = $this->getJson("/api/ferga/lessons/{$l2->id}");
        $res->assertStatus(403);
        $res = $this->getJson("/api/ferga/lessons/{$l1->id}");
        $res->assertOk();
    }

    public function test_admin_can_lock_and_unlock_a_lesson(): void
    {
        $course1 = FergaCourse::where('position', 1)->first();
        $l1 = $course1->lessons()->orderBy('position')->first();
        $l2 = $course1->lessons()->orderBy('position')->get()[1];

        // Admin locks lesson 1 via a partial update.
        $res = $this->putJson(
            "/api/ferga/admin/lessons/{$l1->id}",
            ['status' => FergaLesson::STATUS_COMING_SOON],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertOk();
        $res->assertJsonPath('lesson.status', 'coming_soon');

        // Members now see it locked with the coming_soon reason.
        $res = $this->getJson("/api/ferga/courses/{$course1->id}", $this->authedHeaders());
        $res->assertOk();
        $lessons = $res->json('lessons');
        $this->assertTrue($lessons[0]['locked']);
        $this->assertSame('coming_soon', $lessons[0]['lock_reason']);

        // ...cannot read it...
        $res = $this->getJson("/api/ferga/lessons/{$l1->id}", $this->authedHeaders());
        $res->assertStatus(403);
        $res->assertJsonPath('lock_reason', 'coming_soon');

        // ...and cannot complete it.
        $res = $this->postJson("/api/ferga/lessons/{$l1->id}/complete", [], $this->authedHeaders());
        $res->assertStatus(403);

        // Admin still bypasses the lock to preview.
        $res = $this->getJson("/api/ferga/lessons/{$l1->id}", ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();

        // A later lesson also stays locked (the chain breaks at lesson 1).
        $res = $this->getJson("/api/ferga/lessons/{$l2->id}", $this->authedHeaders());
        $res->assertStatus(403);

        // Admin unlocks it again → members can read lesson 1.
        $res = $this->putJson(
            "/api/ferga/admin/lessons/{$l1->id}",
            ['status' => FergaLesson::STATUS_ACTIVE],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertOk();
        $res->assertJsonPath('lesson.status', 'active');
        $res = $this->getJson("/api/ferga/lessons/{$l1->id}", $this->authedHeaders());
        $res->assertOk();

        // An invalid status is rejected.
        $res = $this->putJson(
            "/api/ferga/admin/lessons/{$l1->id}",
            ['status' => 'broken'],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertStatus(422);
    }

    public function test_completing_every_lesson_unlocks_next_course(): void
    {
        $course1 = FergaCourse::where('position', 1)->first();
        $course2 = FergaCourse::where('position', 2)->first();

        // Unlock step by step: after lesson 1 of course 1, course 2 is still locked.
        $l1 = $course1->lessons()->first();
        $res = $this->postJson("/api/ferga/lessons/{$l1->id}/complete", [], $this->authedHeaders());
        $res->assertOk();

        $courses = collect($this->getJson('/api/ferga/courses', $this->authedHeaders())->json('courses'));
        $this->assertFalse($courses->firstWhere('position', 1)['locked']);
        $this->assertTrue($courses->firstWhere('position', 2)['locked']);

        // Complete the rest of course 1 -> course 2 unlocks, course 3 stays locked.
        foreach ($course1->lessons()->orderBy('position')->get() as $lesson) {
            $this->postJson("/api/ferga/lessons/{$lesson->id}/complete", [], $this->authedHeaders())->assertOk();
        }

        $courses = collect($this->getJson('/api/ferga/courses', $this->authedHeaders())->json('courses'));
        $this->assertTrue($courses->firstWhere('position', 1)['completed']);
        $this->assertFalse($courses->firstWhere('position', 2)['locked']);
        $this->assertTrue($courses->firstWhere('position', 3)['locked']);

        // Now the detail endpoint for course 2 is reachable and lesson state is reported.
        $res = $this->getJson("/api/ferga/courses/{$course2->id}", $this->authedHeaders());
        $res->assertOk();
        $this->assertFalse($res->json('course.locked'));
        $this->assertCount(3, $res->json('lessons'));
    }

    public function test_anonymous_cannot_complete_a_lesson(): void
    {
        $l1 = FergaCourse::where('position', 1)->first()->lessons()->first();

        $res = $this->postJson("/api/ferga/lessons/{$l1->id}/complete", []);

        $res->assertStatus(401);
    }

    public function test_lesson_descriptions_round_trip(): void
    {
        $course1 = FergaCourse::where('position', 1)->first();

        // Admin creates a lesson carrying dual-dialect descriptions.
        $res = $this->postJson(
            "/api/ferga/admin/courses/{$course1->id}/lessons",
            [
                'title_so' => 'Intro SO',
                'title_ba' => 'Intro BA',
                'desc_so' => 'Short blurb SO',
                'desc_ba' => 'Kurtbejna BA',
                'content_so' => '<p>c</p>',
                'content_ba' => '<p>c</p>',
            ],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertCreated();
        $lessonId = $res->json('lesson.id');

        // The lesson payload exposes both dialect descriptions. The lesson sits
        // at position 4 (behind the seeded chain), so only the admin bypass can
        // reach it.
        $res = $this->getJson("/api/ferga/lessons/{$lessonId}", ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $res->assertJsonPath('lesson.desc_so', 'Short blurb SO');
        $res->assertJsonPath('lesson.desc_ba', 'Kurtbejna BA');

        // The course detail (lesson meta list) carries them too.
        $res = $this->getJson("/api/ferga/courses/{$course1->id}", $this->authedHeaders());
        $res->assertOk();
        $this->assertTrue(collect($res->json('lessons'))->contains('desc_so', 'Short blurb SO'));

        // Partial admin update touches only the posted dialect column.
        $res = $this->putJson(
            "/api/ferga/admin/lessons/{$lessonId}",
            ['desc_so' => 'Updated SO'],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertOk();
        $res->assertJsonPath('lesson.desc_so', 'Updated SO');
        $res->assertJsonPath('lesson.desc_ba', 'Kurtbejna BA');
    }

    public function test_lesson_media_is_accepted_and_returned(): void
    {
        $course1 = FergaCourse::where('position', 1)->first();

        // The media field stores image URLs that admin can add to explain topics.
        $res = $this->postJson(
            "/api/ferga/admin/courses/{$course1->id}/lessons",
            ['title_so' => 'M SO', 'title_ba' => 'M BA', 'media' => ['/x.png']],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertCreated();
        $res->assertJsonPath('lesson.media.0', '/x.png');
    }

    public function test_admin_endpoints_require_an_admin_email(): void
    {
        $res = $this->getJson('/api/ferga/admin/courses');
        $res->assertStatus(401);

        // A verified but non-admin identity gets 403.
        $res = $this->getJson('/api/ferga/admin/courses', $this->authedHeaders());
        $res->assertStatus(403);
    }

    public function test_admin_can_manage_sections(): void
    {
        $course = FergaCourse::where('position', 1)->first();

        // Non-admins cannot touch sections.
        $this->postJson("/api/ferga/admin/courses/{$course->id}/sections", ['title_so' => 'A', 'title_ba' => 'B'], $this->authedHeaders())
            ->assertStatus(403);

        // Create two sections.
        $res = $this->postJson("/api/ferga/admin/courses/{$course->id}/sections", [
            'title_so' => 'بەشی یەکەم',
            'title_ba' => 'بەشی یەکێ',
        ], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertCreated();
        $s1 = $res->json('section');

        $res = $this->postJson("/api/ferga/admin/courses/{$course->id}/sections", [
            'title_so' => 'بەشی دووەم',
            'title_ba' => 'بەشی دووێ',
        ], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertCreated();
        $s2 = $res->json('section');

        $this->assertSame(1, $s1['position']);
        $this->assertSame(2, $s2['position']);

        // Rename.
        $res = $this->putJson("/api/ferga/admin/sections/{$s1['id']}", [
            'title_so' => 'بەشی یەکەم — نوێ',
            'title_ba' => 'بەشی یەکێ — نوی',
        ], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $res->assertJsonPath('section.title_so', 'بەشی یەکەم — نوێ');

        // Reorder: move section 2 up → it becomes position 1.
        $res = $this->postJson("/api/ferga/admin/sections/{$s2['id']}/move", ['dir' => 'up'], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $this->assertSame(1, FergaSection::find($s2['id'])->position);
        $this->assertSame(2, FergaSection::find($s1['id'])->position);

        // A section at the top cannot move up.
        $res = $this->postJson("/api/ferga/admin/sections/{$s2['id']}/move", ['dir' => 'up'], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertStatus(422);

        // Deleting a section keeps its lessons (they become "بێ بەش").
        $lesson = FergaLesson::where('ferga_course_id', $course->id)->first();
        $lesson->update(['ferga_section_id' => $s1['id']]);
        $this->deleteJson("/api/ferga/admin/sections/{$s1['id']}", [], ['X-Firebase-Id-Token' => 'tok-admin'])
            ->assertOk();
        $this->assertNull($lesson->fresh()->ferga_section_id);
    }

    public function test_new_lesson_lands_at_end_of_its_section(): void
    {
        $course = FergaCourse::where('position', 1)->first();

        $section = FergaSection::create([
            'ferga_course_id' => $course->id,
            'position' => 1,
            'title_so' => 'بەش',
            'title_ba' => 'بەش',
        ]);

        // Existing lessons occupy positions 1..3. Put lesson 2 into the section.
        $l2 = $course->lessons()->orderBy('position')->get()[1];
        $l2->update(['ferga_section_id' => $section->id]);

        // A new lesson posted to the section lands AFTER lesson 2 (position 3),
        // and the old lesson 3 shifts to position 4.
        $res = $this->postJson(
            "/api/ferga/admin/courses/{$course->id}/lessons",
            ['title_so' => 'Inserted SO', 'title_ba' => 'Inserted BA', 'section_id' => $section->id],
            ['X-Firebase-Id-Token' => 'tok-admin']
        );
        $res->assertCreated();
        $newId = $res->json('lesson.id');
        $res->assertJsonPath('lesson.section_id', $section->id);

        $positions = FergaLesson::where('ferga_course_id', $course->id)
            ->orderBy('position')->pluck('position', 'id');

        $this->assertSame(3, $positions[$newId]);
        $this->assertSame(4, $positions[$course->lessons()->orderBy('position')->get()[3]->id]);
        $this->assertSame([1, 2, 3, 4], $positions->sort()->values()->all());
    }

    public function test_move_lesson_stays_within_its_section(): void
    {
        $course = FergaCourse::where('position', 1)->first();
        $section = FergaSection::create([
            'ferga_course_id' => $course->id,
            'position' => 1,
            'title_so' => 'بەش',
            'title_ba' => 'بەش',
        ]);

        $lessons = $course->lessons()->orderBy('position')->get();
        $l1 = $lessons[0];
        $l2 = $lessons[1];
        $l3 = $lessons[2];

        // l1 + l2 are in the section; l3 (the next lesson globally) is not.
        $l1->update(['ferga_section_id' => $section->id]);
        $l2->update(['ferga_section_id' => $section->id]);

        // Section boundary upward: l1 has no same-section neighbour above.
        $this->postJson("/api/ferga/admin/lessons/{$l1->id}/move", ['dir' => 'up'], ['X-Firebase-Id-Token' => 'tok-admin'])
            ->assertStatus(422);

        // l2 swaps with l1 (same section).
        $res = $this->postJson("/api/ferga/admin/lessons/{$l2->id}/move", ['dir' => 'up'], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $this->assertSame(1, $l2->fresh()->position);
        $this->assertSame(2, $l1->fresh()->position);

        // l1 (now at the section tail) cannot cross the boundary downward:
        // l3 is in a different (no) section.
        $res = $this->postJson("/api/ferga/admin/lessons/{$l1->id}/move", ['dir' => 'down'], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertStatus(422);
    }

    public function test_admin_can_import_an_outline(): void
    {
        $course = FergaCourse::create([
            'position' => 99,
            'title_so' => 'Import course',
            'title_ba' => 'Import course',
            'icon' => '📥',
            'accent' => 'cyan',
            'status' => FergaCourse::STATUS_ACTIVE,
        ]);

        $outline = <<<TXT
بەشی یەکەم: دەروازەیەک بۆ جیهانی نوێ (تێگەیشتن لە چەمکەکان)
وانەی ١: بەخێرهاتن بۆ داڕشتنەوەی مێشک: بەڕاستی ژیریی دەستکرد چییە؟
وانەی ٢: گەشتێک بە مێژوودا: لە خەیاڵی زانستییەوە بۆ واقیع (لە ئالان تیورینگەوە تا ئەمڕۆ)
وانەی ٣: مێشکی مرۆڤ بەرامبەر مێشکی ئامێر

بەشی دووەم: ئامێرەکان چۆن بیر دەکەنەوە؟ (لۆژیکی شاراوە)
وانەی ٤: داتا: نەوتی سەدەی بیست و یەکەم
٥. ئەلگۆریتم بە زمانێکی سادە
Lesson 6: Reinforcement Learning

Note: this prose line is ignored.
TXT;

        $res = $this->postJson("/api/ferga/admin/courses/{$course->id}/import-outline", ['text' => $outline], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertStatus(201);
        $res->assertJson(['sections_created' => 2, 'lessons_created' => 6]);

        // Empty text is rejected.
        $this->postJson("/api/ferga/admin/courses/{$course->id}/import-outline", ['text' => ''], ['X-Firebase-Id-Token' => 'tok-admin'])
            ->assertStatus(422);

        // Two sections in order, 3 lessons each.
        $sections = $course->sections()->orderBy('position')->get();
        $this->assertCount(2, $sections);
        $this->assertSame('دەروازەیەک بۆ جیهانی نوێ (تێگەیشتن لە چەمکەکان)', $sections[0]->title_so);
        $this->assertSame('ئامێرەکان چۆن بیر دەکەنەوە؟ (لۆژیکی شاراوە)', $sections[1]->title_so);

        $this->assertCount(3, $sections[0]->lessons);
        $this->assertCount(3, $sections[1]->lessons);
        $this->assertSame('بەخێرهاتن بۆ داڕشتنەوەی مێشک: بەڕاستی ژیریی دەستکرد چییە؟', $sections[0]->lessons[0]->title_so);
        $this->assertSame('ئەلگۆریتم بە زمانێکی سادە', $sections[1]->lessons[1]->title_so);

        // Global positions are contiguous 1..6 and each lesson knows its section.
        $lessons = $course->lessons()->orderBy('position')->get();
        $this->assertSame([1, 2, 3, 4, 5, 6], $lessons->pluck('position')->all());
        $this->assertSame($sections[0]->id, $lessons[0]->ferga_section_id);
        $this->assertSame($sections[1]->id, $lessons[5]->ferga_section_id);

        // The student course detail exposes the imported sections.
        $res = $this->getJson("/api/ferga/courses/{$course->id}", ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $this->assertCount(2, $res->json('sections'));
        $this->assertSame($sections[0]->id, $res->json('lessons.0.section_id'));
    }

    public function test_import_requires_admin(): void
    {
        $course = FergaCourse::where('position', 1)->first();
        $this->postJson("/api/ferga/admin/courses/{$course->id}/import-outline", ['text' => 'وانەی ١: ئەمە وانەیە'], $this->authedHeaders())
            ->assertStatus(403);
    }

    public function test_admin_can_edit_and_lock_a_course_from_the_learn_page(): void
    {
        $c1 = FergaCourse::where('position', 1)->first();
        $payload = [
            'title_so' => 'Edited SO',
            'title_ba' => 'Edited BA',
            'desc_so' => 'New blurb SO',
            'desc_ba' => 'Nûçe BA',
            'icon' => '🚀',
            'accent' => 'purple',
            'status' => FergaCourse::STATUS_LOCKED,
        ];

        // Non-admins cannot update courses.
        $this->putJson("/api/ferga/admin/courses/{$c1->id}", $payload, $this->authedHeaders())
            ->assertStatus(403);

        // The admin edits the course from the learn page and locks it.
        $res = $this->putJson("/api/ferga/admin/courses/{$c1->id}", $payload, ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();
        $res->assertJsonPath('course.title_so', 'Edited SO');
        $res->assertJsonPath('course.icon', '🚀');
        $res->assertJsonPath('course.status', 'locked');

        // Members now see course 1 as locked.
        $res = $this->getJson('/api/ferga/courses', $this->authedHeaders());
        $res->assertOk();
        $courses = collect($res->json('courses'));
        $this->assertTrue($courses->firstWhere('position', 1)['locked']);
        $this->assertSame('locked', $courses->firstWhere('position', 1)['status']);

        // Admin still bypasses the lock.
        $res = $this->getJson("/api/ferga/courses/{$c1->id}", ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();

        // Unlock again via the toggle → members can re-enter.
        $payload['status'] = FergaCourse::STATUS_ACTIVE;
        $this->putJson("/api/ferga/admin/courses/{$c1->id}", $payload, ['X-Firebase-Id-Token' => 'tok-admin'])
            ->assertOk();
        $res = $this->getJson("/api/ferga/courses/{$c1->id}", $this->authedHeaders());
        $res->assertOk();
        $this->assertFalse($res->json('course.locked'));

        // A missing dialect title is rejected (both are required).
        unset($payload['title_ba']);
        $this->putJson("/api/ferga/admin/courses/{$c1->id}", $payload, ['X-Firebase-Id-Token' => 'tok-admin'])
            ->assertStatus(422);
    }

    public function test_admin_can_reorder_a_course(): void
    {
        $c1 = FergaCourse::where('position', 1)->first();
        $c2 = FergaCourse::where('position', 2)->first();

        // A verified but non-admin identity is forbidden.
        $res = $this->postJson("/api/ferga/admin/courses/{$c1->id}/move", ['dir' => 'down'], ['X-Firebase-Id-Token' => 'tok-valid']);
        $res->assertStatus(403);

        // The admin identity (from the token payload) is allowed to reorder.
        $res = $this->postJson("/api/ferga/admin/courses/{$c1->id}/move", ['dir' => 'down'], ['X-Firebase-Id-Token' => 'tok-admin']);
        $res->assertOk();

        $this->assertSame(2, $c1->fresh()->position);
        $this->assertSame(1, $c2->fresh()->position);

        // The student-facing chain still holds after the swap.
        $this->getJson('/api/ferga/courses')->assertOk();
    }
}
