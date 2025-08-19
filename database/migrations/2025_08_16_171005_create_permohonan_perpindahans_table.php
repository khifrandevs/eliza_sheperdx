<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_perpindahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->foreignId('region_asal_id')->constrained('regions')->onDelete('cascade');
            $table->foreignId('region_tujuan_id')->constrained('regions')->onDelete('cascade');
            $table->text('alasan');
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->date('tanggal_permohonan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_perpindahans');
    }
};