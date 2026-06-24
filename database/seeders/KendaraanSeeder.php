<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kendaraan;

class KendaraanSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = [
            [
            'nama_kendaraan' => 'Mitsubishi Xpander HEV',
            'jenis' => 'SUV',
            'tahun' => '2024',
            'plat_nomor' => 'B 1001 JYA',
            'no_bpkb' => 'BPKB-JYA-1001',
            'pajak_berlaku_sampai' => '2027-06-30',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-01',
            'image_url' => 'https://images.unsplash.com/photo-1549921296-3a9e7f3d4d0a?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 500000,
            'jumlah_unit' => 2,
            'unit_tersedia' => 2,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Suzuki Fronx',
            'jenis' => 'SUV',
            'tahun' => '2025',
            'plat_nomor' => 'B 1002 JYA',
            'no_bpkb' => 'BPKB-JYA-1002',
            'pajak_berlaku_sampai' => '2027-07-31',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-02',
            'image_url' => 'https://images.unsplash.com/photo-1541348263662-e068662d82af?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 670000,
            'jumlah_unit' => 1,
            'unit_tersedia' => 1,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Toyota Rush TRD Sportivo',
            'jenis' => 'SUV',
            'tahun' => '2018',
            'plat_nomor' => 'B 1003 JYA',
            'no_bpkb' => 'BPKB-JYA-1003',
            'pajak_berlaku_sampai' => '2026-12-31',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-03',
            'image_url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 450000,
            'jumlah_unit' => 1,
            'unit_tersedia' => 1,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Honda Brio RS',
            'jenis' => 'Hatchback',
            'tahun' => '2023',
            'plat_nomor' => 'B 1004 JYA',
            'no_bpkb' => 'BPKB-JYA-1004',
            'pajak_berlaku_sampai' => '2027-01-31',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-04',
            'image_url' => 'https://images.unsplash.com/photo-1549925862-990b5bcf4d7e?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 350000,
            'jumlah_unit' => 3,
            'unit_tersedia' => 3,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Toyota Avanza',
            'jenis' => 'MPV',
            'tahun' => '2022',
            'plat_nomor' => 'B 1005 JYA',
            'no_bpkb' => 'BPKB-JYA-1005',
            'pajak_berlaku_sampai' => '2026-11-30',
            'status_pajak' => 'Belum Bayar',
            'tanggal_bayar_pajak' => null,
            'image_url' => 'https://images.unsplash.com/photo-1592198084033-aade902d1aae?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 420000,
            'jumlah_unit' => 2,
            'unit_tersedia' => 2,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Hyundai Stargazer',
            'jenis' => 'MPV',
            'tahun' => '2024',
            'plat_nomor' => 'B 1006 JYA',
            'no_bpkb' => 'BPKB-JYA-1006',
            'pajak_berlaku_sampai' => '2027-03-31',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-05',
            'image_url' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 550000,
            'jumlah_unit' => 1,
            'unit_tersedia' => 1,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Daihatsu Terios',
            'jenis' => 'SUV',
            'tahun' => '2021',
            'plat_nomor' => 'B 1007 JYA',
            'no_bpkb' => 'BPKB-JYA-1007',
            'pajak_berlaku_sampai' => '2026-10-31',
            'status_pajak' => 'Belum Bayar',
            'tanggal_bayar_pajak' => null,
            'image_url' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 400000,
            'jumlah_unit' => 1,
            'unit_tersedia' => 1,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
            [
            'nama_kendaraan' => 'Toyota Innova Zenix',
            'jenis' => 'MPV',
            'tahun' => '2024',
            'plat_nomor' => 'B 1008 JYA',
            'no_bpkb' => 'BPKB-JYA-1008',
            'pajak_berlaku_sampai' => '2027-05-31',
            'status_pajak' => 'Sudah Bayar',
            'tanggal_bayar_pajak' => '2026-06-06',
            'image_url' => 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1200&q=80',
            'harga_per_hari' => 700000,
            'jumlah_unit' => 1,
            'unit_tersedia' => 1,
            'status' => 'Tersedia',
            'status_operasional' => 'Normal'
        ],
        ];

        foreach ($vehicles as $vehicle) {
            Kendaraan::updateOrCreate(
                ['nama_kendaraan' => $vehicle['nama_kendaraan']],
                $vehicle
            );
        }
    }
}
