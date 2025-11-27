<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpindahan_pendetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->foreignId('region_asal_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->foreignId('region_tujuan_id')->nullable()->constrained('regions')->nullOnDelete();
            $table->foreignId('gereja_asal_id')->nullable()->constrained('gerejas')->nullOnDelete();
            $table->foreignId('gereja_tujuan_id')->nullable()->constrained('gerejas')->nullOnDelete();
            $table->date('tanggal_perpindahan');
            $table->date('tanggal_aktif_melayani')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpindahan_pendetas');
    }
};

