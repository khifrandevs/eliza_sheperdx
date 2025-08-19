<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesan_ondemands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            $table->foreignId('pendeta_id')->constrained('pendetas')->onDelete('cascade');
            $table->text('isi_pesan');
            $table->enum('status', ['baru', 'diproses', 'selesai'])->default('baru');
            $table->dateTime('tanggal_pesan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan_ondemands');
    }
};