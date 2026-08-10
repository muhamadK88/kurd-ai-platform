<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add the Firebase UID column (idempotent).
     */
    public function up(): void
    {
        if (Schema::hasTable('feedback_requests') && !Schema::hasColumn('feedback_requests', 'uid')) {
            Schema::table('feedback_requests', function (Blueprint $table) {
                $table->string('uid', 191)->nullable()->index()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('feedback_requests') && Schema::hasColumn('feedback_requests', 'uid')) {
            Schema::table('feedback_requests', function (Blueprint $table) {
                $table->dropColumn('uid');
            });
        }
    }
};
