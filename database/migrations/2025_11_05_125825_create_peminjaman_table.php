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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->uuid('peminjaman_id')->primary();
            $table->dateTime('tanggal_peminjaman');
            $table->dateTime('tanggal_pengembalian')->nullable();
            $table->string('nama_peminjam');
            $table->string('foto_peminjaman')->nullable();
            $table->string('foto_pengembalian')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->uuid('peminjaman_barang_id')->primary();
            $table->uuid('peminjaman_id');
            $table->uuid('barang_id');
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->timestamps();

            $table->foreign('peminjaman_id')
                ->references('peminjaman_id')
                ->on('peminjaman')
                ->cascadeOnDelete();

            $table->foreign('barang_id')
                ->references('barang_id')
                ->on('barang')
                ->cascadeOnDelete();

            $table->index(['peminjaman_id', 'status']);
            $table->index(['barang_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barang');
        Schema::dropIfExists('peminjaman');
    }
};