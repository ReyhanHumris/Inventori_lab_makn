<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\KelolaBarang;

Route::get('/', function () {
    return view('welcome');
});

// Taruh di dalam group middleware auth jetstream yang sudah ada
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Tambahkan ini:
    Route::get('/kelola-barang', KelolaBarang::class)->name('kelola-barang');
});
