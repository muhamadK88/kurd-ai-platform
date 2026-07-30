<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MigrateCourseCategories extends Command
{
    protected $signature = 'courses:migrate-categories';
    protected $description = 'Migrate old course categories/topics to new predefined category IDs in Firebase';

    private $firebaseUrl = 'https://ai-platform-adb1b-default-rtdb.firebaseio.com/';

    private $categoryMapping = [
        'پرۆگرامسازی' => 'programming-languages',
        'کلود و داتابەیس' => 'database-cloud',
        'دیزاین' => 'design',
        'زمان' => 'other',
        'بزنس و بەرھەمھێنان' => 'business-productivity',
        'ئاسایشی ئەلیکترۆنی' => 'cybersecurity',
        'داتا و زیرەکی دەستکرد' => 'ai-machine-learning',
        'ڤیدیۆ و مۆنتاژ' => 'video-production',
        'فرەیم ۆرک' => 'web-development',
    ];

    private $validCategoryIds = [
        'programming-languages', 'web-development', 'mobile-development',
        'ai-machine-learning', 'data-science', 'database-cloud',
        'cybersecurity', 'design', 'video-production',
        'business-productivity', 'other',
    ];

    public function handle()
    {
        $this->info('Fetching courses from Firebase...');

        $response = Http::get($this->firebaseUrl . 'courses.json');
        $courses = $response->json();

        if (!$courses || !is_array($courses)) {
            $this->error('No courses found or failed to fetch data.');
            return 1;
        }

        $this->info('Found ' . count($courses) . ' courses.');
        $updated = 0;
        $skipped = 0;

        foreach ($courses as $id => $course) {
            if (!is_array($course)) continue;

            $oldCategory = $course['category'] ?? null;
            $oldTopic = $course['topic'] ?? null;
            $currentTopic = $oldTopic;

            // Already has a valid category ID
            if ($currentTopic && in_array($currentTopic, $this->validCategoryIds)) {
                $this->line("  SKIP [$id]: already has valid category '{$currentTopic}'");
                $skipped++;
                continue;
            }

            $newCategoryId = null;

            // Map from old 'category' field
            if ($oldCategory && isset($this->categoryMapping[$oldCategory])) {
                $newCategoryId = $this->categoryMapping[$oldCategory];
                $this->line("  MAP  [$id]: category '{$oldCategory}' -> '{$newCategoryId}'");
            }

            // Map from old 'topic' field (if not already mapped)
            if (!$newCategoryId && $oldTopic && isset($this->categoryMapping[$oldTopic])) {
                $newCategoryId = $this->categoryMapping[$oldTopic];
                $this->line("  MAP  [$id]: topic '{$oldTopic}' -> '{$newCategoryId}'");
            }

            // Fallback to 'other'
            if (!$newCategoryId) {
                $newCategoryId = 'other';
                $this->line("  MAP  [$id]: no category found -> 'other'");
            }

            // Update Firebase
            $updateData = [
                'topic' => $newCategoryId,
            ];

            // Remove old 'category' field if it exists
            if ($oldCategory) {
                $updateData['category'] = null;
            }

            Http::patch($this->firebaseUrl . 'courses/' . $id . '.json', $updateData);
            $updated++;
        }

        $this->info("Done! {$updated} courses updated, {$skipped} skipped.");
        return 0;
    }
}
