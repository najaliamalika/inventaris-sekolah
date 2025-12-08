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
        Schema::create('barang_keluar', function (Blueprint $table) {
            $table->uuid('keluar_id')->primary();
            $table->dateTime('tanggal');
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->uuid('item_id');
            $table->uuid('masuk_id');
            $table->enum('kategori', ['habis_pakai', 'rusak', 'tidak_layak', 'sedang_diperbaiki', 'dihibahkan'])->default('habis_pakai');
            $table->foreign('item_id')->references('item_id')->on('items')->cascadeOnDelete();
            $table->foreign('masuk_id')->references('masuk_id')->on('barang_masuk')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar');
    }
};
