<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrandPrixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grand_prixes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prix_name', 255)->nullable()->default('');
            $table->string('information', 255)->nullable()->default('');
            $table->tinyInteger('kind')->unsigned()->default(0);
            $table->boolean('isActiv')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grand_prixes');
    }
}
