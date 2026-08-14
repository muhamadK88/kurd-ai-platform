<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_user_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_email')->unique();
            $table->string('preferred_lang', 8)->nullable();
            $table->json('topics')->nullable();
            $table->json('style')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_user_profiles');
    }
};
