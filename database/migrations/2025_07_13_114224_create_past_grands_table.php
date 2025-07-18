<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\RegisteredModels;
use App\Models\Categories;
use App\Models\User;
use App\Models\GrandPrixes;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('past_grands', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'users_id');
            $table->foreignIdFor(Categories::class, 'categories_id');
            $table->foreignIdFor(RegisteredModels::class, 'model_id');
            $table->foreignIdFor(GrandPrixes::class, 'prixes_id');
            $table->integer('year')->unsigned()->default(date('Y'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('past_grands');
    }
};
