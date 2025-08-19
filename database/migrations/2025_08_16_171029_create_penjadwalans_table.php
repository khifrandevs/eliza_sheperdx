<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjadwalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->string('judul_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');
            $table->string('gambar_bukti')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjadwalans');
    }
};