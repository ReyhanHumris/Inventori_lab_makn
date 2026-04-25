<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            // Relasi ke User yang menginput (Admin/Kepala Lab)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Tabel Barang
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            
            // Informasi Peminjam
            $table->string('nama_peminjam');
            $table->string('nim'); // Nomor Induk Siswa/Mahasiswa
            
            // Detail Transaksi
            $table->integer('jumlah');
            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_kembali');
            
            // Status: Dipinjam, Kembali, Terlambat
            $table->string('status')->default('Dipinjam');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};