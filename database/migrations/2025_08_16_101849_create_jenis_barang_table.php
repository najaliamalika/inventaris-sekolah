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
        Schema::create('jenis_barang', function (Blueprint $table) {
            $table->uuid('jenis_barang_id')->primary();
            $table->string('jenis')->unique();
            $table->string('kategori');
            $table->string('kode_utama')->nullable(true);
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_barang');
    }
};
