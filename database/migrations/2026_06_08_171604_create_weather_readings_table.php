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
        // database/migrations/xxxx_create_weather_readings_table.php
        Schema::create('weather_readings', function (Blueprint $table) {
            $table->id();
            $table->integer('recorded_at'); // unix timestamp
            $table->float('temp');
            $table->float('humidity');
            $table->float('pressure');
            $table->float('wind');
            $table->float('rain');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_readings');
    }
};
