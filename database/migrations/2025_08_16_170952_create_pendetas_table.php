<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendetas', function (Blueprint $table) {
            $table->id();
            $table->string('id_akun')->unique();  // e.g., PD001
            $table->string('password');
            $table->string('nama_pendeta');
            $table->string('no_telp');
            $table->text('alamat')->nullable();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->foreignId('departemen_id')->constrained('departemens')->onDelete('cascade');
            $table->foreignId('gereja_id')->nullable()->constrained('gerejas')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendetas');
    }
};