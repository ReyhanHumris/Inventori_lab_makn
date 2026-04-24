<?php

namespace App\Livewire;

use App\Models\Barang;
use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        // Mengambil data untuk statistik (Aset, Dipinjam, Rusak)
        $stats = [
            'tersedia' => Barang::sum('stok_tersedia'),
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'rusak'    => Peminjaman::where('kondisi_barang', 'Rusak')->count(),
        ];

        // Mengambil riwayat untuk "Menu Laporan" di flowchart
        $activities = Peminjaman::with('barang')->latest()->take(5)->get();

        // MENGIRIM DATA KE VIEW
        return view('livewire.dashboard', [
            'totalBarang' => \App\Models\Barang::count(),
            'barangs' => \App\Models\Barang::latest()->take(5)->get(),
            'stats' => $stats,
            'activities' => $activities,
            'user' => Auth::user() // INI SOLUSI ERROR KAMU
        ]);
    }
}