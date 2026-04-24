<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $fillable = [
        'barang_id', 'user_id', 'nama_peminjam', 
        'jumlah_pinjam', 'tgl_pinjam', 'tgl_kembali', 
        'kondisi_barang', 'status'
    ];

    // Relasi ke Barang (Setiap peminjaman punya satu barang)
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    // Relasi ke User/Petugas (Setiap peminjaman dicatat oleh satu user)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
