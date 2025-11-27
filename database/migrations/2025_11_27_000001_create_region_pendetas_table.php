<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('region_pendetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->foreignId('region_id')->constrained('regions')->onDelete('restrict');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('region_pendetas');
    }
};

