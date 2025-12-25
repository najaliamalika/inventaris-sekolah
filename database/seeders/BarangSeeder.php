<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil jenis barang yang sudah ada
        $laptop = JenisBarang::where('jenis', 'Laptop')->first();
        $monitor = JenisBarang::where('jenis', 'Monitor')->first();
        $mouse = JenisBarang::where('jenis', 'Mouse')->first();
        $keyboard = JenisBarang::where('jenis', 'Keyboard')->first();

        // Seed Laptop
        if ($laptop) {
            Barang::firstOrCreate([
                'nama_barang' => 'Laptop Dell Latitude 5420'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $laptop->jenis_barang_id,
                'kode_barang' => 'LPT-001',
                'merk' => 'Dell',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang IT',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Laptop Lenovo ThinkPad X1'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $laptop->jenis_barang_id,
                'kode_barang' => 'LPT-002',
                'merk' => 'Lenovo',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang IT',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Laptop HP EliteBook 840'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $laptop->jenis_barang_id,
                'kode_barang' => 'LPT-003',
                'merk' => 'HP',
                'kondisi' => 'diperbaiki',
                'lokasi' => 'Workshop',
                'gambar' => null,
                'status' => 'aktif',
            ]);
        }

        // Seed Monitor
        if ($monitor) {
            Barang::firstOrCreate([
                'nama_barang' => 'Monitor LG 24 Inch'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $monitor->jenis_barang_id,
                'kode_barang' => 'MON-001',
                'merk' => 'LG',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Kerja A',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Monitor Samsung 27 Inch'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $monitor->jenis_barang_id,
                'kode_barang' => 'MON-002',
                'merk' => 'Samsung',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Kerja B',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Monitor Dell 22 Inch'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $monitor->jenis_barang_id,
                'kode_barang' => 'MON-003',
                'merk' => 'Dell',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Kerja C',
                'gambar' => null,
                'status' => 'aktif',
            ]);
        }

        // Seed Mouse
        if ($mouse) {
            Barang::firstOrCreate([
                'nama_barang' => 'Mouse Logitech M170'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $mouse->jenis_barang_id,
                'kode_barang' => 'MOU-001',
                'merk' => 'Logitech',
                'kondisi' => 'baik',
                'lokasi' => 'Gudang',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Mouse Razer DeathAdder'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $mouse->jenis_barang_id,
                'kode_barang' => 'MOU-002',
                'merk' => 'Razer',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang IT',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Mouse Microsoft Basic'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $mouse->jenis_barang_id,
                'kode_barang' => 'MOU-003',
                'merk' => 'Microsoft',
                'kondisi' => 'diperbaiki',
                'lokasi' => 'Workshop',
                'gambar' => null,
                'status' => 'aktif',
            ]);
        }

        if ($keyboard) {
            Barang::firstOrCreate([
                'nama_barang' => 'Keyboard Logitech K120'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $keyboard->jenis_barang_id,
                'kode_barang' => 'KEY-001',
                'merk' => 'Logitech',
                'kondisi' => 'baik',
                'lokasi' => 'Gudang',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Keyboard Razer BlackWidow'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $keyboard->jenis_barang_id,
                'kode_barang' => 'KEY-002',
                'merk' => 'Razer',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang IT',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Keyboard Corsair K55'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $keyboard->jenis_barang_id,
                'kode_barang' => 'KEY-003',
                'merk' => 'Corsair',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Kerja A',
                'gambar' => null,
                'status' => 'aktif',
            ]);

            Barang::firstOrCreate([
                'nama_barang' => 'Keyboard Dell KB216'
            ], [
                'barang_id' => uuid_create(),
                'jenis_barang_id' => $keyboard->jenis_barang_id,
                'kode_barang' => 'KEY-004',
                'merk' => 'Dell',
                'kondisi' => 'baik',
                'lokasi' => 'Ruang Kerja D',
                'gambar' => null,
                'status' => 'aktif',
            ]);
        }
    }
}