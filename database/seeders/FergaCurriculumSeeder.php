<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

/**
 * Ferga Curriculum Seeder
 * -----------------------
 * Imports the generated programming curricula (C#, C++, Rust, HTML+CSS, PHP, Java)
 * into the Firebase `ferga_lessons` node, exactly the same way the admin panel does it:
 *   set(push(dbRef(db, 'ferga_lessons')), lesson)
 *
 * Data source:  database/seeders/data/ferga/*.json
 * (or the generated files in storage/curriculum/*.json)
 *
 * USAGE:
 *   php artisan db:seed --class=FergaCurriculumSeeder
 *
 * Flags (via getopt in the command wrapper are not supported by Seeder, so use
 * environment variables instead):
 *   FERGA_DRY_RUN=1            Only validate, do not write to Firebase.
 *   FERGA_FIREBASE_URL=...     Override the Firebase base URL (default = production URL).
 *   FERGA_DATA_DIR=...         Override the directory containing the JSON files.
 */
class FergaCurriculumSeeder extends Seeder
{
    protected string $firebaseUrl;

    public function run(): void
    {
        $this->firebaseUrl = rtrim((string) env('FERGA_FIREBASE_URL', 'https://ai-platform-adb1b-default-rtdb.firebaseio.com'), '/');

        $dataDir = env('FERGA_DATA_DIR') ?: (is_dir(base_path('database/seeders/data/ferga'))
            ? base_path('database/seeders/data/ferga')
            : storage_path('curriculum'));

        $files = [
            'csharp.json'  => 'C#',
            'cpp.json'     => 'C++',
            'rust.json'    => 'Rust',
            'htmlcss.json' => 'HTML+CSS',
            'php.json'     => 'PHP',
            'java.json'    => 'Java',
        ];

        $dryRun = (bool) env('FERGA_DRY_RUN', false);
        $imported = 0;
        $skipped = 0;

        foreach ($files as $file => $label) {
            $path = rtrim($dataDir, '/') . '/' . $file;
            if (! file_exists($path)) {
                $this->command?->warn("⚠️  Missing $file — skipping $label");
                continue;
            }
            $lessons = json_decode(file_get_contents($path), true);
            if (! is_array($lessons)) {
                $this->command?->error("❌ $file is not valid JSON — skipping $label");
                continue;
            }

            $this->command?->info("📚 $label: " . count($lessons) . ' lessons');

            foreach ($lessons as $i => $lesson) {
                $n = $i + 1;
                $title = $lesson['title_so'] ?? $lesson['title'] ?? "(#{$n})";

                // -- validation -------------------------------------------------
                $errors = $this->validateLesson($lesson, $label, $n);
                if (! empty($errors)) {
                    $skipped++;
                    foreach ($errors as $err) {
                        $this->command?->warn("   ⚠️  $label lesson #{$n} ($title): $err");
                    }
                    continue;
                }

                if ($dryRun) {
                    $imported++;
                    continue;
                }

                // -- import (same as admin panel: set(push(...), lesson)) -------
                try {
                    $response = Http::asJson()
                        ->timeout(20)
                        ->post($this->firebaseUrl . '/ferga_lessons.json', $lesson);

                    if ($response->successful()) {
                        $imported++;
                    } else {
                        $skipped++;
                        $this->command?->error("   ❌ $label lesson #{$n}: Firebase HTTP " . $response->status());
                    }
                } catch (\Throwable $e) {
                    $skipped++;
                    $this->command?->error("   ❌ $label lesson #{$n}: " . $e->getMessage());
                }
            }
        }

        $this->command?->info('');
        $this->command?->info($dryRun
            ? "✅ Dry run complete — {$imported} lessons valid (nothing written)."
            : "✅ Import complete — {$imported} lessons written, {$skipped} skipped.");
    }

    /**
     * Validate a single lesson against the Ferga schema.
     *
     * @return string[] list of problems (empty = valid)
     */
    protected function validateLesson(array $l, string $label, int $n): array
    {
        $errors = [];

        $requiredScalars = ['langId', 'order', 'level_so', 'level_ba', 'title_so', 'title_ba',
            'content_so', 'content_ba', 'code', 'example_output', 'expected_output',
            'challenge_desc_so', 'challenge_desc_ba', 'answer_code', 'quiz_type',
            'quiz_question_so', 'quiz_question_ba', 'quiz_correct'];

        foreach ($requiredScalars as $k) {
            if (! array_key_exists($k, $l)) {
                $errors[] = "missing field '$k'";
            }
        }

        // quiz_type must be one of the supported values
        $qt = $l['quiz_type'] ?? '';
        if (! in_array($qt, ['choice', 'code', 'none', ''], true)) {
            $errors[] = "invalid quiz_type '{$qt}'";
        }

        // concept 1&2 (choice): options must be a 4-element array, correct in 1..4
        if ($qt === 'choice') {
            foreach (['quiz_options_so', 'quiz_options_ba'] as $opts) {
                if (! isset($l[$opts]) || count($l[$opts]) !== 4) {
                    $errors[] = "'$opts' must be an array of exactly 4 options";
                }
            }
            $c = $l['quiz_correct'] ?? null;
            if (! in_array((string) $c, ['1', '2', '3', '4'], true)) {
                $errors[] = "quiz_correct must be '1'..'4', got " . var_export($c, true);
            }
        }

        // concept 3&4 (code): challenge must be present with expected_output + answer_code
        if ($qt === 'code') {
            if (trim((string) ($l['challenge_desc_so'] ?? '')) === '') {
                $errors[] = 'code lessons need challenge_desc_so';
            }
            if (trim((string) ($l['challenge_desc_ba'] ?? '')) === '') {
                $errors[] = 'code lessons need challenge_desc_ba';
            }
            if (trim((string) ($l['expected_output'] ?? '')) === '') {
                $errors[] = 'code lessons need expected_output';
            }
            if (trim((string) ($l['answer_code'] ?? '')) === '') {
                $errors[] = 'code lessons need answer_code';
            }
        }

        // order must be numeric
        if (isset($l['order']) && ! is_numeric($l['order'])) {
            $errors[] = 'order must be numeric';
        }

        return $errors;
    }
}
