<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sponsor', function (Blueprint $table) {
            $table->enum('category', ['gold', 'silver', 'partner', 'media'])
                ->default('partner')
                ->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('sponsor', function (Blueprint $table) {
            $table->dropColumn(['category']);
        });
    }
};
