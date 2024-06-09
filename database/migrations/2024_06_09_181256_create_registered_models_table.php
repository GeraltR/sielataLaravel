<?php

use App\Models\Categories;
use App\Models\Users;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisteredModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registered_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Nazwa', 150);
            $table->string('Producent', 100)->nullable();
            $table->string('Skala', 100)->nullable();
            $table->tinyInteger('Styl')->unsigned()->default(0);
            $table->integer('konkurs')->unsigned()->default(0);
            $table->tinyInteger('wynik')->unsigned()->default(0);
            $table->integer('IdParent')->unsigned()->nullable();
            $table->foreignIdFor(Users::class);
            $table->foreignIdFor(Categories::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registered_models');
    }
}
