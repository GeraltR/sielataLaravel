<?php

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
        Schema::table('festival_topic', function (Blueprint $table) {
            $table->unsignedSmallInteger('anniversary_value')
                ->default(10)
                ->after('title');
            $table->string('anniversary_period', 20)
                ->default('Lat')
                ->after('anniversary_value');
        });
    }

    public function down(): void
    {
        Schema::table('festival_topic', function (Blueprint $table) {
            $table->dropColumn(['anniversary_value', 'anniversary_period']);
        });
    }
};
