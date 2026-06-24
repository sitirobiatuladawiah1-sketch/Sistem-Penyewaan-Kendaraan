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
    Schema::create('kendaraan', function (Blueprint $table) {
        $table->id();
        $table->string('nama_kendaraan');
        $table->string('jenis'); // SUV, MPV, Sedan, dll
        $table->string('tahun'); // Contoh: 2024
        $table->integer('harga_per_hari');
        $table->enum('status', ['Tersedia', 'Disewa'])->default('Tersedia'); // <-- Pakai ->bukan titik
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
