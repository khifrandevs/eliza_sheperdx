<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departemens', function (Blueprint $table) {
            $table->id();
            $table->string('id_akun')->unique();  // e.g., DP001
            $table->string('password');
            $table->string('nama_departemen');
            $table->text('deskripsi')->nullable();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departemens');
    }
};