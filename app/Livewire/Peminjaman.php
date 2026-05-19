<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Peminjaman as PeminjamanModel;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Peminjaman extends Component
{
    // Properti untuk Form
    public $nama_peminjam, $nim, $barang_id, $jumlah = 1, $tgl_kembali, $keperluan;

    // QR scan listener to automatically select asset and open booking modal
    #[On('qr-scanned')]
    public function handleQrScanned($id)
    {
        $barang = Barang::find($id);
        if ($barang && $barang->stok_tersedia > 0) {
            $this->barang_id = $id;
            $this->dispatch('open-booking-modal-from-qr');
        } else {
            session()->flash('error', 'Aset tidak ditemukan atau stok kosong!');
        }
    }

    public function render()
    {
        $user = Auth::user();

        // 1. Data Peminjaman Aktif & Pengajuan Mandiri
        if ($user->role === 'peminjam') {
            // Peminjam (Siswa/Guru) hanya melihat miliknya sendiri
            $peminjam_aktif = PeminjamanModel::with('barang')
                                ->where('user_id', $user->id)
                                ->latest()
                                ->get();
            
            $stats = [
                'total' => PeminjamanModel::where('user_id', $user->id)->where('status', 'Dipinjam')->count(),
                'terlambat' => PeminjamanModel::where('user_id', $user->id)
                                ->where('status', 'Dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count(),
            ];

            $daftar_pengajuan = collect(); // Peminjam tidak melihat antrean persetujuan orang lain
        } else {
            // Petugas & Kepala Lab melihat semua
            $peminjam_aktif = PeminjamanModel::with('barang')
                                ->where('status', 'Dipinjam')
                                ->latest()
                                ->get();
            
            $daftar_pengajuan = PeminjamanModel::with('barang')
                                ->where('status', 'Diajukan')
                                ->latest()
                                ->get();

            $stats = [
                'total' => PeminjamanModel::where('status', 'Dipinjam')->count(),
                'terlambat' => PeminjamanModel::where('status', 'Dipinjam')
                                ->where('tgl_kembali', '<', now())
                                ->count(),
            ];
        }

        return view('livewire.peminjaman', [
            'peminjam_aktif' => $peminjam_aktif,
            'daftar_pengajuan' => $daftar_pengajuan,
            'daftar_barang' => Barang::where('stok_tersedia', '>', 0)->get(), 
            'stats' => $stats
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
            'keperluan'     => 'nullable|string',
        ]);

        $barang = Barang::find($this->barang_id);

        // Cek apakah stok cukup
        if ($barang->stok_tersedia < $this->jumlah) {
            session()->flash('error', 'Stok barang tidak mencukupi!');
            return;
        }

        $user = Auth::user();
        
        // Tentukan status awal berdasarkan role
        // Jika peminjam (siswa/guru), maka 'Diajukan'. Jika petugas/kepala, langsung 'Dipinjam'
        $statusAwal = ($user->role === 'peminjam') ? 'Diajukan' : 'Dipinjam';

        // Simpan Data Peminjaman
        PeminjamanModel::create([
            'user_id'       => $user->id,
            'nama_peminjam' => $this->nama_peminjam,
            'nim'           => $this->nim,
            'barang_id'     => $this->barang_id,
            'jumlah'        => $this->jumlah,
            'tgl_pinjam'    => now(),
            'tgl_kembali'   => $this->tgl_kembali,
            'status'        => $statusAwal,
        ]);

        if ($statusAwal === 'Dipinjam') {
            // Kurangi stok barang secara otomatis jika disetujui langsung oleh petugas
            $barang->decrement('stok_tersedia', $this->jumlah);
            \App\Helpers\ActivityLogger::log('Peminjaman Aset', 'Mencatat peminjaman langsung alat ' . $barang->nama_barang . ' untuk ' . $this->nama_peminjam);
            session()->flash('message', 'Data peminjaman berhasil dicatat!');
        } else {
            // Log aktivitas pengajuan mandiri
            \App\Helpers\ActivityLogger::log('Pengajuan Booking', 'Mengajukan booking alat ' . $barang->nama_barang . ' atas nama ' . $this->nama_peminjam);
            session()->flash('message', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas lab.');
        }

        $this->reset(['nama_peminjam', 'nim', 'barang_id', 'jumlah', 'tgl_kembali', 'keperluan']);
        $this->dispatch('close-modal'); 
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

            \App\Helpers\ActivityLogger::log('Pengembalian Aset', 'Verifikasi pengembalian alat ' . ($barang->nama_barang ?? 'Aset') . ' dari ' . $peminjaman->nama_peminjam);

            session()->flash('message', 'Barang telah dikembalikan dan stok diperbarui.');
        }
    }

    // Persetujuan Booking Pengajuan Mandiri oleh Petugas
    public function setujuiBooking($id)
    {
        if (Auth::user()->role === 'peminjam') {
            abort(403);
        }

        $peminjaman = PeminjamanModel::find($id);
        if ($peminjaman && $peminjaman->status === 'Diajukan') {
            $barang = Barang::find($peminjaman->barang_id);

            // Cek stok kembali sebelum verifikasi
            if ($barang->stok_tersedia < $peminjaman->jumlah) {
                session()->flash('error', 'Stok tidak mencukupi untuk menyetujui pengajuan ini!');
                return;
            }

            // Potong stok dan ubah status ke Dipinjam
            $barang->decrement('stok_tersedia', $peminjaman->jumlah);
            $peminjaman->update([
                'status' => 'Dipinjam',
                'tgl_pinjam' => now(), // Diperbarui ke tanggal persetujuan aktif
            ]);

            \App\Helpers\ActivityLogger::log('Persetujuan Booking', 'Menyetujui booking alat ' . $barang->nama_barang . ' oleh ' . $peminjaman->nama_peminjam);

            session()->flash('message', 'Pengajuan peminjaman berhasil disetujui.');
        }
    }

    // Penolakan Booking Pengajuan Mandiri oleh Petugas
    public function tolakBooking($id)
    {
        if (Auth::user()->role === 'peminjam') {
            abort(403);
        }

        $peminjaman = PeminjamanModel::find($id);
        if ($peminjaman && $peminjaman->status === 'Diajukan') {
            $peminjaman->update(['status' => 'Ditolak']);
            
            \App\Helpers\ActivityLogger::log('Penolakan Booking', 'Menolak booking dari ' . $peminjaman->nama_peminjam);
            
            session()->flash('message', 'Pengajuan peminjaman telah ditolak.');
        }
    }
}