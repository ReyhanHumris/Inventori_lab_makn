<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\KelolaBarang;
use App\Livewire\Peminjaman; 
use App\Livewire\Laporan; 

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
});