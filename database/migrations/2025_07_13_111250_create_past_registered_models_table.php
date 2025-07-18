<?php

use App\Models\Categories;
use App\Models\User;
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
        Schema::create('past_registered_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nazwa', 150);
            $table->string('producent', 100)->nullable();
            $table->string('skala', 100)->nullable();
            $table->tinyInteger('styl')->unsigned()->default(0);
            $table->integer('konkurs')->unsigned()->default(0);
            $table->tinyInteger('wynik')->unsigned()->default(0);
            $table->integer('idparent')->unsigned()->nullable();
            $table->foreignIdFor(User::class, 'users_id');
            $table->foreignIdFor(Categories::class, 'categories_id');
            $table->integer('year')->unsigned()->default(date('Y'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_registered_models');
    }
};
