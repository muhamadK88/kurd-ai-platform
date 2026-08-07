<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('knowledge_items');
        Schema::dropIfExists('teaching_sessions');
    }

    public function down(): void
    {
        //
    }
};
