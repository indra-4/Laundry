<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->uuid('pesanan_id')->primary();
            $table->uuid('pelanggan_id');
            $table->string('kode_booking', 20)->unique();
            $table->unsignedBigInteger('layanan_id');
            $table->decimal('estimasi_berat', 8, 2)->nullable();
            $table->decimal('berat_aktual', 8, 2)->nullable();
            $table->enum('metode_antar', ['antar_sendiri', 'dijemput']);
            $table->text('alamat_jemput')->nullable();
            $table->text('catatan')->nullable();
            $table->decimal('estimasi_harga', 10, 2);
            $table->decimal('harga_final', 10, 2)->nullable();
            $table->enum('status', [
                'pending',
                'menunggu_penjemputan',
                'dijemput',
                'ditimbang',
                'dicuci',
                'dikeringkan',
                'disetrika',
                'dikemas',
                'siap_antar',
                'diantar',
                'selesai',
                'dibatalkan'
            ])->default('pending');
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};