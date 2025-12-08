<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->uuid('peminjaman_id')->primary();
            $table->dateTime('tanggal_peminjaman');
             $table->string('nama_peminjam');
            $table->string('foto_peminjaman');
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->string('foto_pengembalian')->nullable(); 
             $table->dateTime('tanggal_pengembalian')->nullable();
            $table->uuid('item_id');
            $table->enum('status', ['dipinjam','dikembalikan'])->default('dipinjam');
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
        Schema::dropIfExists('peminjaman');
    }
};
