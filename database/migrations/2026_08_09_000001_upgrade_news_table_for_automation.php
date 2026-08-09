<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * خشتەی هەواڵ — پاڵپشتی فرە-زاراوە (سۆرانی + بادینی) و بڵاوکردنەوەی خۆکار.
 *
 * The original `news` table was an empty stub (id + timestamps) because the
 * live site reads its news from Firebase RTDB. This migration turns it into a
 * real, queryable mirror so that:
 *   • both dialects are first-class columns (no JSON blobs, no serialisation),
 *   • `published_at` can be filtered server-side (Today / Yesterday / Week),
 *   • the automated pipeline can de-duplicate on `source_url`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // --- Sorani (کوردیی سۆرانی) ---
            $table->string('title_sorani')->nullable()->after('id');
            $table->text('summary_sorani')->nullable()->after('title_sorani');

            // --- Badini (کوردیی بادینی) ---
            $table->string('title_badini')->nullable()->after('summary_sorani');
            $table->text('summary_badini')->nullable()->after('title_badini');

            // --- Media & provenance ---
            $table->text('image_url')->nullable()->after('summary_badini');
            // Bounded length: this column carries a UNIQUE index, and MySQL
            // cannot index an unbounded TEXT column.
            $table->string('source_url', 500)->nullable()->after('image_url');

            // --- Taxonomy ---
            $table->string('category')->default('General AI')->after('source_url');
            $table->json('tags')->nullable()->after('category');

            // --- Publication ---
            $table->string('status', 20)->default('published')->after('tags');
            $table->timestamp('published_at')->nullable()->after('status');

            // --- Automation bookkeeping ---
            $table->boolean('is_automated')->default(false)->after('published_at');
            $table->unsignedTinyInteger('confidence_score')->nullable()->after('is_automated');
            $table->string('firebase_key')->nullable()->after('confidence_score');

            // Date filtering (Today / Yesterday) hits published_at on every request.
            $table->index('published_at');
            $table->index('category');
            $table->index('status');
        });

        // De-duplication guard for the pipeline: the same article must never be
        // stored twice. Kept as a separate statement because SQLite needs the
        // column to exist before a unique index can be built over it.
        Schema::table('news', function (Blueprint $table) {
            $table->unique('source_url', 'news_source_url_unique');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropUnique('news_source_url_unique');
            $table->dropIndex(['published_at']);
            $table->dropIndex(['category']);
            $table->dropIndex(['status']);

            $table->dropColumn([
                'title_sorani',
                'summary_sorani',
                'title_badini',
                'summary_badini',
                'image_url',
                'source_url',
                'category',
                'tags',
                'status',
                'published_at',
                'is_automated',
                'confidence_score',
                'firebase_key',
            ]);
        });
    }
};
