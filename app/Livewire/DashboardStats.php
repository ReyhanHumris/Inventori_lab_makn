<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Peminjaman;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        return view('livewire.dashboard-stats', [
            // Menghitung total stok tersedia dari semua barang IT
            'stokTersedia' => Barang::sum('stok_tersedia'),
            
            // Menghitung jumlah transaksi yang statusnya masih 'dipinjam'
            'sedangDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            
            // Mengambil 5 aktivitas peminjaman terbaru untuk tabel
            'peminjamanTerbaru' => Peminjaman::with('barang')->latest()->take(5)->get(),
        ]);
    }
}