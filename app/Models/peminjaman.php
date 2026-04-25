<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'barang_id',
        'nama_peminjam',
        'nim',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // Relasi ke User (Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}