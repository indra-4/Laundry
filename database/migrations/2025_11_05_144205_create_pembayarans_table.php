<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('pembayaran_id')->primary();
            $table->uuid('pesanan_id');
            $table->enum('metode_pembayaran', ['transfer', 'tunai', 'ewallet', 'qris']);
            $table->decimal('jumlah', 10, 2);
            $table->enum('status', ['menunggu', 'berhasil', 'gagal'])->default('menunggu');
            $table->string('bukti_transfer')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->timestamps();
            
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};


