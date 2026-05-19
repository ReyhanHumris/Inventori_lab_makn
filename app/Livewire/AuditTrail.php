<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AuditTrail extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        // Hanya Kepala Lab yang boleh melihat audit log aktivitas
        if (Auth::user()->role !== 'kepala') {
            abort(403, 'Hanya Kepala Laboratorium yang dapat mengakses halaman ini.');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function clearLogs()
    {
        if (Auth::user()->role === 'kepala') {
            ActivityLog::truncate();
            \App\Helpers\ActivityLogger::log('Mengosongkan Audit Trail', 'Kepala Lab menghapus semua log aktivitas sistem.');
            session()->flash('message', 'Semua riwayat log aktivitas berhasil dikosongkan.');
        }
    }

    public function render()
    {
        $logs = ActivityLog::with('user')
            ->where(function($q) {
                $q->where('aktivitas', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('user', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(15);

        return view('livewire.audit-trail', [
            'logs' => $logs
        ]);
    }
}
