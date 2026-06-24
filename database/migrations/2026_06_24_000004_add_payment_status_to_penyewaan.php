<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->enum('status_pembayaran', ['Belum Lunas', 'Lunas', 'Ditolak', 'Expired'])->default('Belum Lunas')->after('jumlah_bayar');
            $table->unsignedInteger('kurang_bayar')->default(0)->after('status_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'kurang_bayar']);
        });
    }
};
