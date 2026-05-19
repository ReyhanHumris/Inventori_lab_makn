<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class KelolaBarang extends Component
{
    use WithPagination;

    public $barang_id, $nama_barang, $stok, $kondisi, $kategori;
    public $isModalOpen = false;
    public $search = '';
    public $selectedId = null;
    public $isDeleting = false;
    
    // Properties for Detail View
    public $isDetailOpen = false;
    public $detailBarangId = null;

    protected $rules = [
        'nama_barang' => 'required|min:3',
        'stok' => 'required|numeric|min:0',
        'kondisi' => 'required',
        'kategori' => 'required',
    ];

    public function render()
    {
        $detailBarang = $this->detailBarangId 
            ? Barang::with(['peminjaman' => function($q) {
                $q->latest();
            }])->find($this->detailBarangId) 
            : null;

        $query = Barang::where('nama_barang', 'like', '%' . $this->search . '%');
        
        $totalAsetCount = (clone $query)->count();
        $totalStokSum = (clone $query)->sum('stok_total');
        $totalTersediaSum = (clone $query)->sum('stok_tersedia');

        return view('livewire.kelola-barang', [
            'barangs' => $query->latest()->paginate(10),
            'detailBarang' => $detailBarang,
            'summary' => [
                'total_aset' => $totalAsetCount,
                'total_stok' => $totalStokSum,
                'total_tersedia' => $totalTersediaSum,
                'total_dipinjam' => $totalStokSum - $totalTersediaSum,
            ]
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->nama_barang = '';
        $this->stok = '';
        $this->kondisi = '';
        $this->kategori = '';
        $this->barang_id = '';
    }

    public function store()
    {
        $this->validate();

        if ($this->barang_id) {
            $barang = Barang::findOrFail($this->barang_id);
            $dipinjam = $barang->stok_total - $barang->stok_tersedia;

            if ($this->stok < $dipinjam) {
                session()->flash('error', 'Stok total tidak boleh lebih kecil dari jumlah barang yang sedang dipinjam (' . $dipinjam . ' unit)!');
                return;
            }

            $barang->update([
                'nama_barang' => $this->nama_barang,
                'stok_total' => $this->stok,
                'stok_tersedia' => $this->stok - $dipinjam,
                'kondisi' => $this->kondisi,
                'kategori' => $this->kategori,
            ]);
            
            \App\Helpers\ActivityLogger::log('Mengubah Barang', 'Mengubah info barang ' . $this->nama_barang . ' (ID #' . $this->barang_id . ')');
        } else {
            Barang::create([
                'nama_barang' => $this->nama_barang,
                'stok_total' => $this->stok,
                'stok_tersedia' => $this->stok,
                'kondisi' => $this->kondisi,
                'kategori' => $this->kategori,
            ]);
            
            \App\Helpers\ActivityLogger::log('Menambahkan Barang', 'Menambahkan barang baru: ' . $this->nama_barang);
        }

        session()->flash('message', $this->barang_id ? 'Barang Diperbarui.' : 'Barang Ditambahkan.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $this->barang_id = $id;
        $this->nama_barang = $barang->nama_barang;
        $this->stok = $barang->stok_total;
        $this->kondisi = $barang->kondisi;
        $this->kategori = $barang->kategori;

        $this->openModal();
    }

    public function delete($id)
    {
        $this->isDeleting = true;
        
        try {
            $barang = Barang::findOrFail($id);
            $namaBarang = $barang->nama_barang;
            
            // Cek apakah barang masih dipinjam - gunakan query langsung untuk performa
            $peminjamanAktif = \DB::table('peminjaman')
                ->where('barang_id', $id)
                ->where('status', 'dipinjam')
                ->count();
            
            if ($peminjamanAktif > 0) {
                session()->flash('error', 'Barang tidak dapat dihapus karena masih dalam status peminjaman aktif.');
                return;
            }
            
            $barang->delete();
            
            \App\Helpers\ActivityLogger::log('Menghapus Barang', 'Menghapus barang: ' . $namaBarang . ' (ID #' . $id . ')');
            
            session()->flash('message', 'Barang Dihapus.');
            $this->selectedId = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menghapus barang: ' . $e->getMessage());
        } finally {
            $this->isDeleting = false;
        }
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
    }

    public function showDetail($id)
    {
        $this->detailBarangId = $id;
        $this->isDetailOpen = true;
        $this->dispatch('show-detail-qr', id: $id);
    }

    #[On('qr-scanned')]
    public function handleQrScanned($id)
    {
        $this->showDetail($id);
    }

    public function closeDetail()
    {
        $this->isDetailOpen = false;
        $this->detailBarangId = null;
    }
}