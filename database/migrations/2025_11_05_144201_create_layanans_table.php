<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('layanan_id');
            $table->string('nama_layanan');
            $table->enum('jenis', ['kiloan', 'satuan', 'express']);
            $table->decimal('harga_per_kg', 10, 2)->nullable();
            $table->decimal('harga_satuan', 10, 2)->nullable();
            $table->integer('durasi_pengerjaan');
            $table->text('deskripsi')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
