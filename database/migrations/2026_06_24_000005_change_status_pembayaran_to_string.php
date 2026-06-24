<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE penyewaan MODIFY status_pembayaran VARCHAR(50) NOT NULL DEFAULT 'Menunggu Konfirmasi'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE penyewaan MODIFY status_pembayaran ENUM('Belum Lunas', 'Lunas', 'Ditolak', 'Expired') NOT NULL DEFAULT 'Belum Lunas'");
    }
};
