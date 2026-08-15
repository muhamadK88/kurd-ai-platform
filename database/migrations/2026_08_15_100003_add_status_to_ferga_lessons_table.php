<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * فێرگە — per-lesson admin lock.
     * Mirrors the course status enum (active | locked | coming_soon) so an
     * admin can lock individual lessons 1–10 for members: a non-active lesson
     * shows "بەم زوانە" on the learner side and cannot be opened or completed
     * by members (admins bypass, as everywhere else).
     */
    public function up(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->string('status', 20)->default('active')->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
