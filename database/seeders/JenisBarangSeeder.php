<?php

namespace Database\Seeders;

use App\Models\JenisBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JenisBarang::firstOrCreate([
            "jenis" => "Laptop"
        ], [
            "jenis_barang_id" => uuid_create(),
            "kategori" => "Elektronik",
            "kode_utama" => "OKJ",
            "satuan" => "Unit"
        ]);

        JenisBarang::firstOrCreate([
            "jenis" => "Monitor"
        ], [
            "jenis_barang_id" => uuid_create(),
            "kategori" => "Elektronik",
            "kode_utama" => "KLB",
            "satuan" => "Unit"
        ]);

        JenisBarang::firstOrCreate([
            "jenis" => "Mouse"
        ], [
            "jenis_barang_id" => uuid_create(),
            "kategori" => "Elektronik",
            "kode_utama" => "CJH",
            "satuan" => "Unit"
        ]);

        JenisBarang::firstOrCreate([
            "jenis" => "Keyboard"
        ], [
            "jenis_barang_id" => uuid_create(),
            "kategori" => "Elektronik",
            "kode_utama" => "DTR",
            "satuan" => "Unit"
        ]);
    }
}
