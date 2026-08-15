<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * فێرگە — lesson image gallery (fully optional).
     * Admins drag & drop images into a dedicated media section below the
     * content editor; the URLs are stored as a JSON array and rendered as a
     * gallery under the lesson content on the learner side.
     */
    public function up(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->json('media')->nullable()->after('starter_code');
        });
    }

    public function down(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->dropColumn('media');
        });
    }
};
