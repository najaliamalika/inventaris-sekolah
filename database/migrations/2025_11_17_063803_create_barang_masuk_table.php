<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->uuid('masuk_id')->primary();
            $table->dateTime('tanggal');
            $table->string('kode_barang')->nullable(true);
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->uuid('item_id');
            $table->enum('kategori', ['pembelian', 'bantuan'])->default('pembelian');
            $table->integer('harga_satuan')-> nullable(true); 
            $table->string('nama_supplier');
            $table->foreign('item_id')
                ->references('item_id')
                ->on('items')
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk');
    }
};
