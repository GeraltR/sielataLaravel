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
        Schema::table('festival_edition', function (Blueprint $table) {
            $table->dateTime('edit_cutoff')->nullable()->after('registration_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('festival_edition', function (Blueprint $table) {
            $table->dropColumn('edit_cutoff');
        });
    }
};
