<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * فێرگە — lesson descriptions, one column per dialect (Sorani + Badini).
     * Short blurbs shown under the lesson title on the learner side, exactly
     * like courses already carry desc_so / desc_ba.
     */
    public function up(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->text('desc_so')->nullable()->after('title_ba');
            $table->text('desc_ba')->nullable()->after('desc_so');
        });
    }

    public function down(): void
    {
        Schema::table('ferga_lessons', function (Blueprint $table) {
            $table->dropColumn(['desc_so', 'desc_ba']);
        });
    }
};
