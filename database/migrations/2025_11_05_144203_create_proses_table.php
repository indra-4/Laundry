<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proses', function (Blueprint $table) {
            $table->uuid('proses_id')->primary();
            $table->uuid('pesanan_id');
            $table->uuid('karyawan_id')->nullable();
            $table->enum('tahapan', ['pencucian', 'pengeringan', 'penyetrikaan', 'pengemasan']);
            $table->boolean('status_checklist')->default(false);
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan')->onDelete('cascade');
            $table->foreign('karyawan_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proses');
    }
};