<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\KelolaBarang;
use App\Livewire\Peminjaman; 
use App\Livewire\Laporan; 
use App\Livewire\KelolaUser;
use App\Livewire\KelolaMaintenance;
use App\Livewire\AuditTrail;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Route Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Route Manajemen Barang
    Route::get('/kelola-barang', KelolaBarang::class)->name('kelola-barang');

    // Tambahkan Route Peminjaman di sini agar terlindungi login
    Route::get('/peminjaman', Peminjaman::class)->name('peminjaman');

    // Tambahkan Route Laporan di sini agar terlindungi login
    Route::get('/laporan', Laporan::class)->name('laporan');

    // Route Pemeliharaan Alat
    Route::get('/maintenance', KelolaMaintenance::class)->name('kelola-maintenance');

    // Route Audit Trail (hanya untuk kepala lab)
    Route::get('/audit', AuditTrail::class)->name('audit-trail');

    // Route Kelola User (hanya untuk kepala lab)
    Route::get('/kelola-user', KelolaUser::class)->name('kelola-user');
});