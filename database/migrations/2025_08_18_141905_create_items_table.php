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
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('item_id')->primary();
            $table->uuid('item_templates_id')->nullable(true);
            $table->string('nama_barang')->unique();
            $table->foreign('item_templates_id')->references('item_templates_id')->on('item_templates')->cascadeOnDelete();
            $table->string('gambar')->nullable(true);
            $table->string('kode_barang')->nullable(true);
            $table->string('merk');
            $table->enum('kondisi', ['baik', 'diperbaiki', 'dipinjam'])->default('baik');
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
