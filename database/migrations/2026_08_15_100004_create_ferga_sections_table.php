<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * فێرگە — course "sections" (بەش).
 *
 * A section is a named group of lessons inside a course (e.g. "بەشی یەکەم:
 * دەروازەیەک بۆ جیهانی نوێ"). Sections are pure grouping — the lesson
 * unlock chain keeps using the course-global lesson `position`, so a section
 * boundary never affects which lesson opens next. Lessons that predate the
 * feature carry a NULL ferga_section_id and render in a "بێ بەش" group.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ferga_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ferga_course_id')->constrained('ferga_courses')->cascadeOnDelete();
            $table->unsignedInteger('position');               // order inside the course
            $table->string('title_so');                        // سۆرانی
            $table->string('title_ba');                        // بادینی
            $table->timestamps();

            $table->unique(['ferga_course_id', 'position']);
        });

        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->foreignId('ferga_section_id')
                ->nullable()
                ->after('ferga_course_id')
                ->constrained('ferga_sections')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ferga_section_id');
        });
        Schema::dropIfExists('ferga_sections');
    }
};
