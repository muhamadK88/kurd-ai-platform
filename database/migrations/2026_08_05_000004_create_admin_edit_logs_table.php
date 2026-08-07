<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_edit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('admin_email')->nullable()->index();
            $table->text('request_text')->nullable();
            $table->longText('actions')->nullable();
            $table->string('status', 20)->default('done');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_edit_logs');
    }
};
