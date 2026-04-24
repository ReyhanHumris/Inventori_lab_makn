<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = ['nama_barang', 'kategori', 'merk', 'stok_total', 'stok_tersedia', 'kondisi'];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
