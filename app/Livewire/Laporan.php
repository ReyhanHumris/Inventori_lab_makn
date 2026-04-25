<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Peminjaman;
use App\Models\Barang;

class Laporan extends Component
{
    public $tgl_mulai, $tgl_selesai, $status_filter = 'semua';

    public function render()
    {
        $query = Peminjaman::with('barang');

        // Filter berdasarkan tanggal jika diisi
        if ($this->tgl_mulai && $this->tgl_selesai) {
            $query->whereBetween('tgl_pinjam', [$this->tgl_mulai, $this->tgl_selesai]);
        }

        // Filter berdasarkan status
        if ($this->status_filter !== 'semua') {
            $query->where('status', $this->status_filter);
        }

        return view('livewire.laporan', [
            'laporan_data' => $query->latest()->get(),
            'total_barang' => Barang::sum('stok_total'),
            'barang_rusak' => Barang::where('kondisi', 'Rusak')->count(),
        ])->layout('layouts.app');
    }
}