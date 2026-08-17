<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_type', 20)->default('visit');
            $table->string('section', 40)->nullable()->index();
            $table->string('user_key', 64)->nullable()->index();
            $table->string('user_uid', 64)->nullable();
            $table->string('user_email', 190)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['event_type', 'section', 'created_at']);
            $table->index(['event_type', 'created_at']);
            $table->index(['user_key', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};