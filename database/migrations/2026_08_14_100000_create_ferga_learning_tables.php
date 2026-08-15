<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * فێرگە — the Ferga learning system.
 *
 * Ten sequential AI courses, each with ordered bilingual lessons, plus a
 * per-user completion ledger that drives the prerequisite locking system:
 * course N stays locked (🔒) until the user has completed every lesson of
 * course N-1. Progress is keyed to the Firebase UID — the identity every
 * page already has after the client-side auth gate resolves.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ferga_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position')->unique();     // 1..10, strict order
            $table->string('title_so');                        // سۆرانی
            $table->string('title_ba');                        // بادینی
            $table->text('desc_so')->nullable();               // rich intro (plain text summary)
            $table->text('desc_ba')->nullable();
            $table->string('icon', 16)->default('📘');         // emoji shown on the path
            $table->string('accent', 32)->nullable();          // css accent token (cyan/blue/…)
            $table->string('status', 20)->default('active');   // active | locked | coming_soon
            $table->timestamps();
        });

        Schema::create('ferga_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ferga_course_id')->constrained('ferga_courses')->cascadeOnDelete();
            $table->unsignedInteger('position');               // order inside the course
            $table->string('title_so');
            $table->string('title_ba');
            $table->longText('content_so')->nullable();        // rich HTML (admin editor)
            $table->longText('content_ba')->nullable();
            $table->string('code_language', 20)->default('python');
            $table->text('starter_code')->nullable();          // default playground code
            $table->timestamps();

            $table->unique(['ferga_course_id', 'position']);
        });

        Schema::create('ferga_lesson_completions', function (Blueprint $table) {
            $table->id();
            $table->string('user_uid', 191);                   // Firebase UID
            $table->foreignId('ferga_course_id')->constrained('ferga_courses')->cascadeOnDelete();
            $table->foreignId('ferga_lesson_id')->constrained('ferga_lessons')->cascadeOnDelete();
            $table->timestamp('completed_at')->useCurrent();
            $table->timestamps();

            // toggle-safe: one row per (user, lesson)
            $table->unique(['user_uid', 'ferga_lesson_id']);
            $table->index(['user_uid', 'ferga_course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ferga_lesson_completions');
        Schema::dropIfExists('ferga_lessons');
        Schema::dropIfExists('ferga_courses');
    }
};