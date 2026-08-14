<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Indexes matching the real query patterns of the MySQL-backed features.
 *
 * The single-column defaults were too narrow for the hot paths:
 *   • chat_sessions  — always filtered by user (key/email) then sorted latest
 *   • chat_histories — always read per session, ordered by id
 *   • chat_usage     — quota lookups filter on (user_key, usage_date) together
 *   • feedback_requests — admin list filters by status, newest first
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->index(['user_key', 'updated_at'], 'chat_sessions_user_key_updated_at_index');
            $table->index(['user_email', 'updated_at'], 'chat_sessions_user_email_updated_at_index');
            $table->index(['pinned', 'updated_at'], 'chat_sessions_pinned_updated_at_index');
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            $table->dropIndex('chat_histories_session_id_index');
            $table->index(['session_id', 'id'], 'chat_histories_session_id_id_index');
        });

        Schema::table('chat_usage', function (Blueprint $table) {
            $table->dropIndex('chat_usage_user_key_index');
            $table->dropIndex('chat_usage_usage_date_index');
            $table->index(['user_key', 'usage_date'], 'chat_usage_user_key_usage_date_index');
        });

        Schema::table('feedback_requests', function (Blueprint $table) {
            $table->index(['status', 'created_at'], 'feedback_requests_status_created_at_index');
            $table->index(['uid', 'created_at'], 'feedback_requests_uid_created_at_index');
        });
    }

    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropIndex('chat_sessions_user_key_updated_at_index');
            $table->dropIndex('chat_sessions_user_email_updated_at_index');
            $table->dropIndex('chat_sessions_pinned_updated_at_index');
        });

        Schema::table('chat_histories', function (Blueprint $table) {
            $table->dropIndex('chat_histories_session_id_id_index');
            $table->index('session_id');
        });

        Schema::table('chat_usage', function (Blueprint $table) {
            $table->dropIndex('chat_usage_user_key_usage_date_index');
            $table->index('user_key');
            $table->index('usage_date');
        });

        Schema::table('feedback_requests', function (Blueprint $table) {
            $table->dropIndex('feedback_requests_status_created_at_index');
            $table->dropIndex('feedback_requests_uid_created_at_index');
        });
    }
};
