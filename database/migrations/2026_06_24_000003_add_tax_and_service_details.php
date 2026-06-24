<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kendaraan', function (Blueprint $table) {
            $table->enum('status_pajak', ['Belum Bayar', 'Sudah Bayar'])->default('Belum Bayar')->after('pajak_berlaku_sampai');
            $table->date('tanggal_bayar_pajak')->nullable()->after('status_pajak');
        });

        Schema::table('service_histories', function (Blueprint $table) {
            $table->string('nama_bengkel')->nullable()->after('tanggal_service');
            $table->text('kerusakan')->nullable()->after('jenis_service');
            $table->text('perbaikan')->nullable()->after('kerusakan');
        });
    }

    public function down(): void
    {
        Schema::table('service_histories', function (Blueprint $table) {
            $table->dropColumn(['nama_bengkel', 'kerusakan', 'perbaikan']);
        });

        Schema::table('kendaraan', function (Blueprint $table) {
            $table->dropColumn(['status_pajak', 'tanggal_bayar_pajak']);
        });
    }
};
