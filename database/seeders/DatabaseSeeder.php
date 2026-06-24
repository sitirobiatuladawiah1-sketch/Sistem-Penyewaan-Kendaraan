<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\KendaraanSeeder;
use Database\Seeders\PickupPointSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate([
            'email' => 'admin@jayarental.test',
        ], [
            'name' => 'Admin Jaya Rental',
            'no_telp' => '081234567890',
            'alamat' => 'Kantor Pusat',
            'password' => Hash::make('admin12345'),
            'role' => 'admin',
        ]);

        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $this->call(KendaraanSeeder::class);
        $this->call(PickupPointSeeder::class);
    }
}
