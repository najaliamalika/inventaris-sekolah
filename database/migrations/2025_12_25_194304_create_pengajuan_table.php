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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->uuid('pengajuan_id')->primary();
            $table->uuid('jenis_barang_id')->nullable(true);
            $table->dateTime('tanggal');
            $table->string('nama_barang')->nullable(true);
            $table->enum('tipe', ['pembelian', 'perbaikan'])->default('pembelian');
            $table->integer('jumlah');
            $table->integer('estimasi_biaya')->default(0);
            $table->text('alasan');
            $table->enum('status', ['disetujui', 'menunggu', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();

            $table->foreign('jenis_barang_id')
                ->references('jenis_barang_id')
                ->on('jenis_barang')
                ->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::create('pengajuan_perbaikan_items', function (Blueprint $table) {
            $table->uuid('pengajuan_perbaikan_item_id')->primary();
            $table->uuid('pengajuan_id');
            $table->uuid('barang_id');

            $table->foreign('pengajuan_id')
                ->references('pengajuan_id')
                ->on('pengajuan')
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
        Schema::dropIfExists('pengajuan_perbaikan_items');
        Schema::dropIfExists('pengajuan');
    }
};