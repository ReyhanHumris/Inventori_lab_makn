<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    protected $fillable = [
        'barang_id',
        'user_id',
        'jenis_pemeliharaan',
        'keterangan',
        'biaya',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya' => 'integer',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
