<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_pemeliharaan'); // Servis, Perbaikan, Kalibrasi, Pembersihan
            $table->text('keterangan');
            $table->integer('biaya')->default(0);
            $table->date('tanggal');
            $table->string('status')->default('Proses'); // Selesai, Proses, Gagal
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
