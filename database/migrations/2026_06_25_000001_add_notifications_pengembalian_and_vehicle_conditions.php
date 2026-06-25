<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE penyewaan MODIFY status_sewa VARCHAR(50) NOT NULL DEFAULT 'Pending'");

        Schema::table('penyewaan', function (Blueprint $table) {
            $table->string('kondisi_ambil')->nullable()->after('lokasi_pengambilan');
            $table->text('catatan_kondisi_ambil')->nullable()->after('kondisi_ambil');
            $table->string('kondisi_kembali')->nullable()->after('tanggal_pengembalian');
            $table->text('catatan_pengembalian')->nullable()->after('kondisi_kembali');
            $table->string('status_denda')->nullable()->after('denda_keterlambatan');
            $table->timestamp('denda_dibayar_at')->nullable()->after('status_denda');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('penyewaan_id')->nullable()->constrained('penyewaan')->nullOnDelete();
            $table->string('type')->default('info');
            $table->string('title');
            $table->text('message');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewaan_id')->constrained('penyewaan')->cascadeOnDelete();
            $table->foreignId('kendaraan_id')->nullable()->constrained('kendaraan')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->date('tanggal_ambil')->nullable();
            $table->string('kondisi_ambil')->nullable();
            $table->text('catatan_kondisi_ambil')->nullable();
            $table->date('tanggal_kembali')->nullable();
            $table->string('kondisi_kembali')->nullable();
            $table->text('catatan_pengembalian')->nullable();
            $table->unsignedInteger('denda')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
        Schema::dropIfExists('notifications');

        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn([
                'kondisi_ambil',
                'catatan_kondisi_ambil',
                'kondisi_kembali',
                'catatan_pengembalian',
                'status_denda',
                'denda_dibayar_at',
            ]);
        });

        DB::statement("ALTER TABLE penyewaan MODIFY status_sewa ENUM('Pending', 'Selesai', 'Dikembalikan', 'Expired') NOT NULL DEFAULT 'Pending'");
    }
};
