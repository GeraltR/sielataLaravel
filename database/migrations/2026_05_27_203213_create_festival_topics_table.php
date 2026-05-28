<?php

use App\Models\FestivalEdition;
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
        Schema::create('festival_topic', function (Blueprint $table) {
            $table->increments('id');

            $table->foreignIdFor(FestivalEdition::class);

            $table->string('title', 150);

            $table->string('subtitle', 255)->nullable();

            $table->text('description')->nullable();

            $table->string('image', 255)->nullable();

            $table->integer('order')->default(0);

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_topic');
    }
};
