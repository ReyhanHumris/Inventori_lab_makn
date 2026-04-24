<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Barang;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KelolaBarang extends Component
{
    use WithPagination;

    public $barang_id, $nama_barang, $stok, $kondisi, $kategori;
    public $isModalOpen = false;
    public $search = '';
    public $selectedId = null;
    public $isDeleting = false;

    protected $rules = [
        'nama_barang' => 'required|min:3',
        'stok' => 'required|numeric',
        'kondisi' => 'required',
        'kategori' => 'required',
    ];

    public function render()
    {
        return view('livewire.kelola-barang', [
            'barangs' => Barang::where('nama_barang', 'like', '%' . $this->search . '%')
                        ->latest()
                        ->paginate(10)
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

        Barang::updateOrCreate(['id' => $this->barang_id], [
            'nama_barang' => $this->nama_barang,
            'stok_total' => $this->stok,
            'stok_tersedia' => $this->stok, // Asumsi awal tersedia = total
            'kondisi' => $this->kondisi,
            'kategori' => $this->kategori,
        ]);

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
            
            // Cek apakah barang masih dipinjam - gunakan query langsung untuk performa
            $peminjamanAktif = \DB::table('peminjamen')
                ->where('barang_id', $id)
                ->where('status', 'dipinjam')
                ->count();
            
            if ($peminjamanAktif > 0) {
                session()->flash('error', 'Barang tidak dapat dihapus karena masih dalam status peminjaman aktif.');
                return;
            }
            
            $barang->delete();
            
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
        // Debug: pastikan selectedId ter-set
        \Log::info('confirmDelete called with id: ' . $id . ', selectedId set to: ' . $this->selectedId);
    }
}