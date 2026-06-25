<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penyewaan', function (Blueprint $table) {
            $table->unsignedInteger('denda_kerusakan')->default(0)->after('denda_keterlambatan');
            $table->json('detail_kerusakan')->nullable()->after('denda_kerusakan');
            $table->unsignedInteger('denda_kehilangan')->default(0)->after('detail_kerusakan');
            $table->json('detail_kehilangan')->nullable()->after('denda_kehilangan');
        });

        Schema::table('pengembalian', function (Blueprint $table) {
            $table->unsignedInteger('denda_keterlambatan')->default(0)->after('catatan_pengembalian');
            $table->unsignedInteger('denda_kerusakan')->default(0)->after('denda_keterlambatan');
            $table->json('detail_kerusakan')->nullable()->after('denda_kerusakan');
            $table->unsignedInteger('denda_kehilangan')->default(0)->after('detail_kerusakan');
            $table->json('detail_kehilangan')->nullable()->after('denda_kehilangan');
        });
    }

    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropColumn([
                'denda_keterlambatan',
                'denda_kerusakan',
                'detail_kerusakan',
                'denda_kehilangan',
                'detail_kehilangan',
            ]);
        });

        Schema::table('penyewaan', function (Blueprint $table) {
            $table->dropColumn([
                'denda_kerusakan',
                'detail_kerusakan',
                'denda_kehilangan',
                'detail_kehilangan',
            ]);
        });
    }
};
