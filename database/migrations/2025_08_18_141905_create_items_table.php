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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('item_id')->primary();
            $table->string('gambar')->nullable(true);
            $table->string('nama_barang')->unique();
            $table->string('jenis');
            $table->string('merk');
            $table->string('kondisi')->nullable(true);
            $table->integer('stok')->nullable(true);
            $table->string('satuan');
            $table->string('lokasi')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
