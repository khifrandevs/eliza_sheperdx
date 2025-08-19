<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perlawatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->string('gambar_bukti')->nullable();  // Path to image
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perlawatans');
    }
};