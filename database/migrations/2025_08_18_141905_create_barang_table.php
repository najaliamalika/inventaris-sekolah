<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->uuid('barang_id')->primary();
            $table->uuid('jenis_barang_id')->nullable(true);
            $table->string('nama_barang');
            $table->foreign('jenis_barang_id')->references('jenis_barang_id')->on('jenis_barang')->cascadeOnDelete();
            $table->string('gambar')->nullable(true);
            $table->string('kode_barang')->nullable(true);
            $table->string('merk');
            $table->enum('kondisi', ['baik', 'diperbaiki', 'dipinjam'])->default('baik');
            $table->string('lokasi')->nullable(true);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
