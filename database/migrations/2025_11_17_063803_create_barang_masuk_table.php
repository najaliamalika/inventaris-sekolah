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
        Schema::create('barang_masuk', function (Blueprint $table) {
            $table->uuid('masuk_id')->primary();
            $table->dateTime('tanggal');
            $table->enum('kategori', ['pembelian', 'bantuan'])->default('pembelian');
            $table->string('nama_supplier');
            $table->integer('total_jumlah')->default(0);
            $table->bigInteger('total_harga')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('barang_masuk_detail', function (Blueprint $table) {
            $table->uuid('detail_id')->primary();
            $table->uuid('masuk_id');
            $table->uuid('jenis_barang_id');
            $table->integer('jumlah');
            $table->integer('harga_satuan')->nullable();
            $table->bigInteger('subtotal')->default(0);
            $table->text('keterangan')->nullable();

            $table->foreign('masuk_id')
                ->references('masuk_id')
                ->on('barang_masuk')
                ->cascadeOnDelete();

            $table->foreign('jenis_barang_id')
                ->references('jenis_barang_id')
                ->on('jenis_barang')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_detail');
        Schema::dropIfExists('barang_masuk');
    }
};
