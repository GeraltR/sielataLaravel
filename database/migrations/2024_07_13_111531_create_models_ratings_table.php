<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RegisteredModels;
use App\Models\Users;

class CreateModelsRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('points')->unsigned();
            $table->tinyInteger('flaga')->unsigned();
            $table->foreignIdFor(RegisteredModels::class, 'model_id');
            $table->foreignIdFor(Users::class, 'judge_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models_ratings');
    }
}
