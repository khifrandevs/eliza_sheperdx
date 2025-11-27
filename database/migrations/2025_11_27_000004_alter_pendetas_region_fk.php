<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendetas', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->foreign('region_id')->references('id')->on('regions')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pendetas', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->foreign('region_id')->references('id')->on('regions')->cascadeOnDelete();
        });
    }
};

