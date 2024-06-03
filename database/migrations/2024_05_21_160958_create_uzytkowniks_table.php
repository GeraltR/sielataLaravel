<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateUzytkowniksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uzytkownik', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('password', 255);
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('kod', 32)->nullable();
            $table->dateTime('data');
            $table->tinyInteger('status')->default(0);
            $table->string('miasto', 40);
            $table->integer('rokur');
            $table->string('klub', 255)->nullable();
            $table->tinyInteger('admin')->unsigned()->default(0);
            $table->string('haslo2', 50)->nullable();
            $table->integer('idopiekuna')->unsigned()->nullable();
            $table->boolean('isteacher')->nullable()->default(false);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('uzytkownik');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
