<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjemputan', function (Blueprint $table) {
            $table->uuid('penjemputan_id')->primary();
            $table->uuid('pesanan_id');
            $table->uuid('kurir_id')->nullable();
            $table->text('alamat');
            $table->timestamp('tanggal_jemput')->nullable();
            $table->enum('status', ['dijadwalkan', 'dalam_perjalanan', 'selesai', 'gagal'])->default('dijadwalkan');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan')->onDelete('cascade');
            $table->foreign('kurir_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjemputan');
    }
};

