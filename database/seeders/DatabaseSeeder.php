<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Akun Kepala Lab
    \App\Models\User::factory()->create([
        'name' => 'Kepala Lab MAKN',
        'email' => 'kepala@makn.sch.id',
        'password' => bcrypt('password'),
        'role' => 'kepala',
    ]);

    // Akun Petugas Lab
    \App\Models\User::factory()->create([
        'name' => 'Petugas IT',
        'email' => 'petugas@makn.sch.id',
        'password' => bcrypt('password'),
        'role' => 'petugas',
    ]);

    // Panggil seeder barang yang tadi kita buat agar sekalian terisi
    $this->call(BarangSeeder::class);
    }
}
