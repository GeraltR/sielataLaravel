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
        Schema::table('festival_rule', function (Blueprint $table) {
            $table->unsignedInteger('festival_edition_id')->change();
            $table->foreign('festival_edition_id')->references('id')->on('festival_edition')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('festival_rule', function (Blueprint $table) {
            //
        });
    }
};
