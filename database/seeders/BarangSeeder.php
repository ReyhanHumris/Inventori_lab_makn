<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Barang::create([
        'nama_barang' => 'Komputer i5 Core',
        'kategori' => 'Komputer',
        'merk' => 'Dell',
        'stok_total' => 20,
        'stok_tersedia' => 20,
    ]);

    \App\Models\Barang::create([
        'nama_barang' => 'Smart TV 55 Inch',
        'kategori' => 'Elektronik',
        'merk' => 'Samsung',
        'stok_total' => 2,
        'stok_tersedia' => 2,
    ]);
}
}
