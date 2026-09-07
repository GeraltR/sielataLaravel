<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registered_models', function (Blueprint $table) {
            $table->boolean('confirm')->default(0);
        });

        // Modele zarejestrowane przed wprowadzeniem tej funkcji uznajemy za
        // już potwierdzone - nie mają dostawać maila z potwierdzeniem wstecz.
        DB::table('registered_models')->update(['confirm' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registered_models', function (Blueprint $table) {
            $table->dropColumn('confirm');
        });
    }
};
