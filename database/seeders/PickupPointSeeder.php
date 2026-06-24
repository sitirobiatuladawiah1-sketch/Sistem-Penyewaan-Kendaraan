<?php

namespace Database\Seeders;

use App\Models\PickupPoint;
use Illuminate\Database\Seeder;

class PickupPointSeeder extends Seeder
{
    public function run(): void
    {
        $points = [
            [
                'nama_titik' => 'Kantor Pusat Jaya Rental',
                'alamat' => 'Jl. Raya Utama No. 12, Bogor',
                'latitude' => -6.597147,
                'longitude' => 106.806039,
                'sort_order' => 1,
            ],
            [
                'nama_titik' => 'Stasiun Bogor',
                'alamat' => 'Jl. Kapten Muslihat, Bogor Tengah',
                'latitude' => -6.597454,
                'longitude' => 106.800147,
                'sort_order' => 2,
            ],
            [
                'nama_titik' => 'Terminal Baranangsiang',
                'alamat' => 'Jl. Raya Tajur, Bogor Timur',
                'latitude' => -6.622399,
                'longitude' => 106.818551,
                'sort_order' => 3,
            ],
            [
                'nama_titik' => 'Botani Square',
                'alamat' => 'Jl. Raya Pajajaran, Bogor Tengah',
                'latitude' => -6.597983,
                'longitude' => 106.806897,
                'sort_order' => 4,
            ],
            [
                'nama_titik' => 'Kebun Raya Bogor',
                'alamat' => 'Jl. Ir. H. Juanda No. 13, Bogor',
                'latitude' => -6.597753,
                'longitude' => 106.799665,
                'sort_order' => 5,
            ],
        ];

        foreach ($points as $point) {
            PickupPoint::updateOrCreate(
                ['nama_titik' => $point['nama_titik']],
                $point + ['is_active' => true]
            );
        }
    }
}