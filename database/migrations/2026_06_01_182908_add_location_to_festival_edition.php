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
        // database/migrations/xxxx_add_location_to_festivals_table.php
        Schema::table('festival_edition', function (Blueprint $table) {
            $table->string('location')->nullable()->after('city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('festival_edition', function (Blueprint $table) {
            $table->dropColumn(['location']);
        });
    }
};
