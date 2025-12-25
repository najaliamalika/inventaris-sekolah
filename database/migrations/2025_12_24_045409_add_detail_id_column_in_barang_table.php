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
        Schema::table('barang', function (Blueprint $table) {
            $table->uuid('detail_id')->nullable(true);
            $table->foreign('detail_id')->references('detail_id')->on('barang_masuk_detail')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropForeign(['detail_id']);
            $table->dropColumn('detail_id');
        });
    }
};
