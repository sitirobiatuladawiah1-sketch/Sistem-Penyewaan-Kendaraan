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
    Schema::create('penyewaan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->string('lokasi_pengambilan');
        $table->string('metode_pembayaran');
        $table->integer('harga_per_hari'); // Kolom baru sesuai PDF
        $table->integer('jumlah_hari');    // Kolom baru sesuai PDF
        $table->integer('total_harga');
        $table->enum('status_sewa', ['Pending', 'Selesai', 'Dikembalikan', 'Expired'])->default('Pending');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};
