<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->uuid('laporan_id')->primary();
            $table->enum('jenis_laporan', ['harian', 'mingguan', 'bulanan', 'tahunan']);
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->integer('total_pesanan')->default(0);
            $table->decimal('total_pendapatan', 15, 2)->default(0);
            $table->timestamp('tanggal_generate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
