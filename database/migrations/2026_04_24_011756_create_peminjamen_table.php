<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel barang
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            // Relasi ke petugas yang melayani
            $table->foreignId('user_id')->constrained('users');
            
            $table->string('nama_peminjam'); 
            $table->integer('jumlah_pinjam');
            $table->dateTime('tgl_pinjam');
            
            // Kolom untuk proses pengembalian 
            $table->dateTime('tgl_kembali')->nullable();
            $table->text('kondisi_barang')->nullable(); // Sesuai flowchart: "input barang yang dikembalikan dan kondisi"
            
            // Status untuk logika dashboard
            $table->enum('status', ['dipinjam', 'kembali'])->default('dipinjam');
            $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
