<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('festival_topic', function (Blueprint $table) {
            $table->string('fade_width')->default('hidden')->after('image_position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('festival_topic', function (Blueprint $table) {
            $table->dropColumn(['fade_width']);
        });
    }
};
