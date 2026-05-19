<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MaintenanceLog;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class KelolaMaintenance extends Component
{
    use WithPagination;

    public $search = '';
    public $isModalOpen = false;

    // Form fields
    public $log_id;
    public $barang_id;
    public $jenis_pemeliharaan = 'Servis';
    public $keterangan;
    public $biaya = 0;
    public $tanggal;
    public $status = 'Proses';

    public $selectedId = null; // for delete confirmation
    public $isDeleting = false;

    protected $queryString = ['search' => ['except' => '']];

    public function mount()
    {
        if (Auth::user()->role === 'peminjam') {
            abort(403, 'Akses terbatas untuk petugas dan kepala laboratorium.');
        }
        $this->tanggal = date('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $log = MaintenanceLog::findOrFail($id);
        $this->log_id = $id;
        $this->barang_id = $log->barang_id;
        $this->jenis_pemeliharaan = $log->jenis_pemeliharaan;
        $this->keterangan = $log->keterangan;
        $this->biaya = $log->biaya;
        $this->tanggal = $log->tanggal->format('Y-m-d');
        $this->status = $log->status;
        $this->isModalOpen = true;
    }

    public function resetInputFields()
    {
        $this->log_id = null;
        $this->barang_id = '';
        $this->jenis_pemeliharaan = 'Servis';
        $this->keterangan = '';
        $this->biaya = 0;
        $this->tanggal = date('Y-m-d');
        $this->status = 'Proses';
    }

    public function store()
    {
        $this->validate([
            'barang_id'          => 'required',
            'jenis_pemeliharaan' => 'required',
            'keterangan'         => 'required|min:5',
            'biaya'              => 'required|numeric|min:0',
            'tanggal'            => 'required|date',
            'status'             => 'required',
        ]);

        $barang = Barang::findOrFail($this->barang_id);

        $data = [
            'barang_id'          => $this->barang_id,
            'user_id'            => Auth::id(),
            'jenis_pemeliharaan' => $this->jenis_pemeliharaan,
            'keterangan'         => $this->keterangan,
            'biaya'              => $this->biaya,
            'tanggal'            => $this->tanggal,
            'status'             => $this->status,
        ];

        if ($this->log_id) {
            $log = MaintenanceLog::findOrFail($this->log_id);
            $log->update($data);
            
            \App\Helpers\ActivityLogger::log('Mengubah Log Pemeliharaan', 'Memperbarui log pemeliharaan alat ' . $barang->nama_barang . ' (ID #' . $this->log_id . ')');
            session()->flash('message', 'Log pemeliharaan berhasil diperbarui.');
        } else {
            MaintenanceLog::create($data);
            
            \App\Helpers\ActivityLogger::log('Menambah Log Pemeliharaan', 'Mencatat pemeliharaan baru jenis ' . $this->jenis_pemeliharaan . ' untuk alat ' . $barang->nama_barang);
            session()->flash('message', 'Log pemeliharaan berhasil dicatat.');
        }

        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
    }

    public function delete()
    {
        if ($this->selectedId) {
            $log = MaintenanceLog::findOrFail($this->selectedId);
            $log->delete();

            \App\Helpers\ActivityLogger::log('Menghapus Log Pemeliharaan', 'Menghapus log pemeliharaan #' . $this->selectedId);
            
            session()->flash('message', 'Log pemeliharaan berhasil dihapus.');
            $this->selectedId = null;
        }
    }

    public function render()
    {
        $logs = MaintenanceLog::with(['barang', 'user'])
            ->whereHas('barang', function($q) {
                $q->where('nama_barang', 'like', '%' . $this->search . '%')
                  ->orWhere('kategori', 'like', '%' . $this->search . '%');
            })
            ->orWhere('jenis_pemeliharaan', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        // Menghitung ringkasan pemeliharaan
        $stats = [
            'total_biaya' => MaintenanceLog::sum('biaya'),
            'sedang_proses' => MaintenanceLog::where('status', 'Proses')->count(),
            'total_pemeliharaan' => MaintenanceLog::count(),
        ];

        return view('livewire.kelola-maintenance', [
            'logs' => $logs,
            'barangs' => Barang::all(),
            'stats' => $stats,
        ]);
    }
}
