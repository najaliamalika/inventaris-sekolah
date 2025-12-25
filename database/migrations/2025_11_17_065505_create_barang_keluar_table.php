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
            $table->uuid('jenis_barang_id');
            $table->dateTime('tanggal');
            $table->enum('kategori', [
                'habis_pakai',
                'rusak',
                'tidak_layak',
                'sedang_diperbaiki',
                'dihibahkan'
            ])->default('habis_pakai');
            $table->string('penerima')->nullable();
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();

            $table->foreign('jenis_barang_id')
                ->references('jenis_barang_id')
                ->on('jenis_barang')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('barang_keluar_items', function (Blueprint $table) {
            $table->uuid('keluar_item_id')->primary();
            $table->uuid('keluar_id');
            $table->uuid('barang_id');

            $table->foreign('keluar_id')
                ->references('keluar_id')
                ->on('barang_keluar')
                ->cascadeOnDelete();

            $table->foreign('barang_id')
                ->references('barang_id')
                ->on('barang')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_items');
        Schema::dropIfExists('barang_keluar');
    }
};