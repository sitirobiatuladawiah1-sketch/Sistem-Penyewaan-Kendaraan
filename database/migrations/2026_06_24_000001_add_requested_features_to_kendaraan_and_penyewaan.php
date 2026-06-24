<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kendaraan', function (Blueprint $table) {
            $table->string('plat_nomor')->nullable()->unique()->after('tahun');
            $table->string('no_bpkb')->nullable()->unique()->after('plat_nomor');
            $table->date('pajak_berlaku_sampai')->nullable()->after('no_bpkb');
            $table->unsignedInteger('jumlah_unit')->default(1)->after('harga_per_hari');
            $table->unsignedInteger('unit_tersedia')->default(1)->after('jumlah_unit');
        });

        Schema::table('penyewaan', function (Blueprint $table) {
            $table->string('booking_code')->nullable()->unique()->after('id');
            $table->string('nik_pelanggan', 16)->nullable()->after('lokasi_pengambilan');
            $table->string('foto_ktp_path')->nullable()->after('nik_pelanggan');
            $table->unsignedInteger('jumlah_bayar')->default(0)->after('total_harga');
            $table->unsignedInteger('denda_keterlambatan')->default(0)->after('jumlah_bayar');
            $table->date('tanggal_pengembalian')->nullable()->after('tanggal_selesai');
            $table->timestamp('booking_expires_at')->nullable()->after('status_sewa');
            $table->timestamp('paid_at')->nullable()->after('booking_expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn([
                'booking_code',
                'nik_pelanggan',
                'foto_ktp_path',
                'jumlah_bayar',
                'denda_keterlambatan',
                'tanggal_pengembalian',
                'booking_expires_at',
                'paid_at',
            ]);
        });

        Schema::table('kendaraan', function (Blueprint $table) {
            $table->dropUnique(['plat_nomor']);
            $table->dropUnique(['no_bpkb']);
            $table->dropColumn([
                'plat_nomor',
                'no_bpkb',
                'pajak_berlaku_sampai',
                'jumlah_unit',
                'unit_tersedia',
            ]);
        });
    }
};
