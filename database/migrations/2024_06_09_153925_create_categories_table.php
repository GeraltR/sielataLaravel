<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('idkat');
            $table->string('symbol', 6);
            $table->string('nazwa', 80);
            $table->string('klasa', 1);
            $table->integer('rok');
            $table->string('grupa', 15);
            $table->integer('idparent')->unsigned()->nullable()->default(12);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
