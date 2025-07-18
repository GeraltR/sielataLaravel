<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RegisteredModels;
use App\Models\Categories;
use App\Models\User;
use App\Models\GrandPrixes;

class CreateGrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grands', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'users_id');
            $table->foreignIdFor(Categories::class, 'categories_id');
            $table->foreignIdFor(RegisteredModels::class, 'model_id');
            $table->foreignIdFor(GrandPrixes::class, 'prixes_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grands');
    }
}
