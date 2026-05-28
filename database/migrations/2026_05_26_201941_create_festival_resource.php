<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\FestivalEdition;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('festival_resource', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order');
            $table->string('anniversary', 20);
            $table->string('anniversary_of',20);
            $table->string('title', 100);
            $table->string('note', 200);
            $table->string('image', 255);
            $table->foreignIdFor(FestivalEdition::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_resource');
    }
};
