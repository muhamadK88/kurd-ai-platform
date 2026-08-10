<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add hide_email flag (idempotent) — member can hide their email.
     */
    public function up(): void
    {
        if (Schema::hasTable('feedback_requests') && !Schema::hasColumn('feedback_requests', 'hide_email')) {
            Schema::table('feedback_requests', function (Blueprint $table) {
                $table->boolean('hide_email')->default(false)->after('email');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('feedback_requests') && Schema::hasColumn('feedback_requests', 'hide_email')) {
            Schema::table('feedback_requests', function (Blueprint $table) {
                $table->dropColumn('hide_email');
            });
        }
    }
};
