<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Peminjaman as PeminjamanModel;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class Peminjaman extends Component
{
    // Properti untuk Form
    public $nama_peminjam, $nim, $barang_id, $jumlah = 1, $tgl_kembali;

    public function render()
    {
        return view('livewire.peminjaman', [
            // Hanya menampilkan yang statusnya 'Dipinjam' agar tabel tetap rapi
            'peminjam_aktif' => PeminjamanModel::with('barang')
                                ->where('status', 'Dipinjam')
                                ->latest()
                                ->get(),
            
            'daftar_barang' => Barang::where('stok_tersedia', '>', 0)->get(), 
            
            'stats' => [
                'total' => PeminjamanModel::where('status', 'Dipinjam')->count(),
                'terlambat' => PeminjamanModel::where('status', 'Dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count(),
            ]
        ])->layout('layouts.app');
    }

    public function simpanPeminjaman()
    {
        $this->validate([
            'nama_peminjam' => 'required|min:3',
            'nim'           => 'required',
            'barang_id'     => 'required',
            'jumlah'        => 'required|numeric|min:1',
            'tgl_kembali'   => 'required|date',
        ]);

        $barang = Barang::find($this->barang_id);

        // Cek apakah stok cukup
        if ($barang->stok_tersedia < $this->jumlah) {
            session()->flash('error', 'Stok barang tidak mencukupi!');
            return;
        }

        // Simpan Data Peminjaman
        PeminjamanModel::create([
            'user_id'       => Auth::id(),
            'nama_peminjam' => $this->nama_peminjam,
            'nim'           => $this->nim,
            'barang_id'     => $this->barang_id,
            'jumlah'        => $this->jumlah,
            'tgl_pinjam'    => now(),
            'tgl_kembali'   => $this->tgl_kembali,
            'status'        => 'Dipinjam',
        ]);

        // Kurangi stok barang secara otomatis
        $barang->decrement('stok_tersedia', $this->jumlah);

        $this->reset(['nama_peminjam', 'nim', 'barang_id', 'jumlah', 'tgl_kembali']);
        $this->dispatch('close-modal'); 
        session()->flash('message', 'Data peminjaman berhasil dicatat!');
    }

    public function kembalikanBarang($id)
    {
        $peminjaman = PeminjamanModel::find($id);

        if ($peminjaman && $peminjaman->status == 'Dipinjam') {
            // Tambahkan kembali stok ke tabel barang
            $barang = Barang::find($peminjaman->barang_id);
            if ($barang) {
                $barang->increment('stok_tersedia', $peminjaman->jumlah);
            }

            // Update status
            $peminjaman->update(['status' => 'Kembali']);

            session()->flash('message', 'Barang telah dikembalikan dan stok diperbarui.');
        }
    }
}