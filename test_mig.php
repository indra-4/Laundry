<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

try {
    Schema::create('test_users_table', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('nama');
        $table->string('email')->unique();
        $table->string('password');
        $table->string('no_hp', 15);
        $table->text('alamat')->nullable();
        $table->enum('role', ['pelanggan', 'karyawan', 'kurir', 'pemilik'])->default('pelanggan');
        $table->boolean('is_active')->default(true);
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
