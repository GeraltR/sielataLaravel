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
        Schema::create('festival_edition', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('edition');
            $table->string('title', 100);
            $table->string('slug', 100)->unique();
            $table->string('city', 50);
            $table->integer('rok');
            $table->dateTime('registration_start');
            $table->dateTime('registration_end');
            $table->dateTime('festival_start');
            $table->dateTime('festival_end');
            $table->dateTime('results_at');
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_edition');
    }
};
