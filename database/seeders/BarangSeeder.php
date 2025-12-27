<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\JenisBarang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // LAPTOP
        $laptop = JenisBarang::where('jenis', 'Laptop')->first();
        if ($laptop) {
            $laptopData = [
                ['nama' => 'Laptop Dell Latitude 5420', 'kode' => 'LPT-001', 'merk' => 'Dell', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Laptop Lenovo ThinkPad X1', 'kode' => 'LPT-002', 'merk' => 'Lenovo', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Laptop HP EliteBook 840', 'kode' => 'LPT-003', 'merk' => 'HP', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
                ['nama' => 'Laptop Asus VivoBook', 'kode' => 'LPT-004', 'merk' => 'Asus', 'kondisi' => 'baik', 'lokasi' => 'Ruang Guru'],
                ['nama' => 'Laptop Acer Aspire 5', 'kode' => 'LPT-005', 'merk' => 'Acer', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
                ['nama' => 'Laptop Dell Inspiron 14', 'kode' => 'LPT-006', 'merk' => 'Dell', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
                ['nama' => 'Laptop Lenovo IdeaPad', 'kode' => 'LPT-007', 'merk' => 'Lenovo', 'kondisi' => 'baik', 'lokasi' => 'Perpustakaan'],
            ];
            foreach ($laptopData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $laptop->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // MONITOR
        $monitor = JenisBarang::where('jenis', 'Monitor')->first();
        if ($monitor) {
            $monitorData = [
                ['nama' => 'Monitor LG 24 Inch', 'kode' => 'MON-001', 'merk' => 'LG', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kerja A'],
                ['nama' => 'Monitor Samsung 27 Inch', 'kode' => 'MON-002', 'merk' => 'Samsung', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kerja B'],
                ['nama' => 'Monitor Dell 22 Inch', 'kode' => 'MON-003', 'merk' => 'Dell', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kerja C'],
                ['nama' => 'Monitor Asus 24 Inch', 'kode' => 'MON-004', 'merk' => 'Asus', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
                ['nama' => 'Monitor HP 21.5 Inch', 'kode' => 'MON-005', 'merk' => 'HP', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
                ['nama' => 'Monitor BenQ 24 Inch', 'kode' => 'MON-006', 'merk' => 'BenQ', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
            ];
            foreach ($monitorData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $monitor->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // MOUSE
        $mouse = JenisBarang::where('jenis', 'Mouse')->first();
        if ($mouse) {
            $mouseData = [
                ['nama' => 'Mouse Logitech M170', 'kode' => 'MOU-001', 'merk' => 'Logitech', 'kondisi' => 'baik', 'lokasi' => 'Gudang'],
                ['nama' => 'Mouse Razer DeathAdder', 'kode' => 'MOU-002', 'merk' => 'Razer', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Mouse Microsoft Basic', 'kode' => 'MOU-003', 'merk' => 'Microsoft', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
                ['nama' => 'Mouse Logitech M331', 'kode' => 'MOU-004', 'merk' => 'Logitech', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
                ['nama' => 'Mouse HP X3000', 'kode' => 'MOU-005', 'merk' => 'HP', 'kondisi' => 'baik', 'lokasi' => 'Ruang Guru'],
            ];
            foreach ($mouseData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $mouse->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // KEYBOARD
        $keyboard = JenisBarang::where('jenis', 'Keyboard')->first();
        if ($keyboard) {
            $keyboardData = [
                ['nama' => 'Keyboard Logitech K120', 'kode' => 'KEY-001', 'merk' => 'Logitech', 'kondisi' => 'baik', 'lokasi' => 'Gudang'],
                ['nama' => 'Keyboard Razer BlackWidow', 'kode' => 'KEY-002', 'merk' => 'Razer', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Keyboard Corsair K55', 'kode' => 'KEY-003', 'merk' => 'Corsair', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kerja A'],
                ['nama' => 'Keyboard Dell KB216', 'kode' => 'KEY-004', 'merk' => 'Dell', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kerja D'],
                ['nama' => 'Keyboard Logitech K380', 'kode' => 'KEY-005', 'merk' => 'Logitech', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
                ['nama' => 'Keyboard Microsoft 600', 'kode' => 'KEY-006', 'merk' => 'Microsoft', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
            ];
            foreach ($keyboardData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $keyboard->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // PRINTER
        $printer = JenisBarang::where('jenis', 'Printer')->first();
        if ($printer) {
            $printerData = [
                ['nama' => 'Printer Canon Pixma G3010', 'kode' => 'PRN-001', 'merk' => 'Canon', 'kondisi' => 'baik', 'lokasi' => 'Ruang TU'],
                ['nama' => 'Printer HP LaserJet Pro', 'kode' => 'PRN-002', 'merk' => 'HP', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kepala Sekolah'],
                ['nama' => 'Printer Epson L3110', 'kode' => 'PRN-003', 'merk' => 'Epson', 'kondisi' => 'baik', 'lokasi' => 'Ruang Guru'],
                ['nama' => 'Printer Brother DCP-T510W', 'kode' => 'PRN-004', 'merk' => 'Brother', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
                ['nama' => 'Printer Canon ImageClass', 'kode' => 'PRN-005', 'merk' => 'Canon', 'kondisi' => 'baik', 'lokasi' => 'Perpustakaan'],
            ];
            foreach ($printerData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $printer->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // PROYEKTOR
        $proyektor = JenisBarang::where('jenis', 'Proyektor')->first();
        if ($proyektor) {
            $proyektorData = [
                ['nama' => 'Proyektor Epson EB-X06', 'kode' => 'PRY-001', 'merk' => 'Epson', 'kondisi' => 'baik', 'lokasi' => 'Aula'],
                ['nama' => 'Proyektor BenQ MH535', 'kode' => 'PRY-002', 'merk' => 'BenQ', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kelas 1A'],
                ['nama' => 'Proyektor ViewSonic PA503S', 'kode' => 'PRY-003', 'merk' => 'ViewSonic', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kelas 2B'],
                ['nama' => 'Proyektor Infocus IN112x', 'kode' => 'PRY-004', 'merk' => 'Infocus', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
            ];
            foreach ($proyektorData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $proyektor->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // AC
        $ac = JenisBarang::where('jenis', 'AC (Air Conditioner)')->first();
        if ($ac) {
            $acData = [
                ['nama' => 'AC Daikin 1 PK', 'kode' => 'ARC-001', 'merk' => 'Daikin', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kepala Sekolah'],
                ['nama' => 'AC LG 1.5 PK', 'kode' => 'ARC-002', 'merk' => 'LG', 'kondisi' => 'baik', 'lokasi' => 'Ruang Guru'],
                ['nama' => 'AC Sharp 1 PK', 'kode' => 'ARC-003', 'merk' => 'Sharp', 'kondisi' => 'baik', 'lokasi' => 'Ruang TU'],
                ['nama' => 'AC Panasonic 2 PK', 'kode' => 'ARC-004', 'merk' => 'Panasonic', 'kondisi' => 'baik', 'lokasi' => 'Aula'],
                ['nama' => 'AC Polytron 1 PK', 'kode' => 'ARC-005', 'merk' => 'Polytron', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
            ];
            foreach ($acData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $ac->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // MEJA KANTOR
        $mejaKantor = JenisBarang::where('jenis', 'Meja Kantor')->first();
        if ($mejaKantor) {
            $mejaData = [
                ['nama' => 'Meja Kantor Kayu Jati', 'kode' => 'MJK-001', 'merk' => 'Olympic', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kepala Sekolah'],
                ['nama' => 'Meja Kantor Minimalis', 'kode' => 'MJK-002', 'merk' => 'Chitose', 'kondisi' => 'baik', 'lokasi' => 'Ruang TU'],
                ['nama' => 'Meja Kerja L Shape', 'kode' => 'MJK-003', 'merk' => 'HighPoint', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Meja Komputer', 'kode' => 'MJK-004', 'merk' => 'Futura', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
                ['nama' => 'Meja Kantor Standard', 'kode' => 'MJK-005', 'merk' => 'Uno', 'kondisi' => 'baik', 'lokasi' => 'Gudang'],
            ];
            foreach ($mejaData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $mejaKantor->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // KURSI KANTOR
        $kursiKantor = JenisBarang::where('jenis', 'Kursi Kantor')->first();
        if ($kursiKantor) {
            $kursiData = [
                ['nama' => 'Kursi Direktur Kulit', 'kode' => 'KRK-001', 'merk' => 'Ergotec', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kepala Sekolah'],
                ['nama' => 'Kursi Staff Mesh', 'kode' => 'KRK-002', 'merk' => 'Chitose', 'kondisi' => 'baik', 'lokasi' => 'Ruang TU'],
                ['nama' => 'Kursi Putar Standar', 'kode' => 'KRK-003', 'merk' => 'HighPoint', 'kondisi' => 'baik', 'lokasi' => 'Ruang Guru'],
                ['nama' => 'Kursi Gaming', 'kode' => 'KRK-004', 'merk' => 'Rexus', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Kursi Lipat', 'kode' => 'KRK-005', 'merk' => 'Futura', 'kondisi' => 'baik', 'lokasi' => 'Aula'],
            ];
            foreach ($kursiData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $kursiKantor->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // PAPAN TULIS
        $papanTulis = JenisBarang::where('jenis', 'Papan White Board')->first();
        if ($papanTulis) {
            $papanData = [
                ['nama' => 'Whiteboard 120x180 cm', 'kode' => 'PWB-001', 'merk' => 'Sakana', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kelas 1A'],
                ['nama' => 'Whiteboard 90x120 cm', 'kode' => 'PWB-002', 'merk' => 'Kenko', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kelas 2B'],
                ['nama' => 'Whiteboard Magnetic', 'kode' => 'PWB-003', 'merk' => 'Toplas', 'kondisi' => 'baik', 'lokasi' => 'Ruang Kelas 3C'],
                ['nama' => 'Whiteboard Portable', 'kode' => 'PWB-004', 'merk' => 'Standard', 'kondisi' => 'baik', 'lokasi' => 'Workshop'],
            ];
            foreach ($papanData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $papanTulis->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // MEJA SISWA
        $mejaSiswa = JenisBarang::where('jenis', 'Meja Siswa')->first();
        if ($mejaSiswa) {
            for ($i = 1; $i <= 15; $i++) {
                Barang::firstOrCreate(['kode_barang' => sprintf('MJS-%03d', $i)], [
                    'barang_id' => uuid_create(),
                    'nama_barang' => 'Meja Siswa Standard ' . $i,
                    'jenis_barang_id' => $mejaSiswa->jenis_barang_id,
                    'kode_barang' => sprintf('MJS-%03d', $i),
                    'merk' => 'Chitose',
                    'kondisi' => $i > 12 ? 'diperbaiki' : 'baik',
                    'lokasi' => 'Ruang Kelas ' . (ceil($i / 5)) . chr(64 + (($i - 1) % 3 + 1)),
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // KURSI SISWA
        $kursiSiswa = JenisBarang::where('jenis', 'Kursi Siswa')->first();
        if ($kursiSiswa) {
            for ($i = 1; $i <= 15; $i++) {
                Barang::firstOrCreate(['kode_barang' => sprintf('KRS-%03d', $i)], [
                    'barang_id' => uuid_create(),
                    'nama_barang' => 'Kursi Siswa Standard ' . $i,
                    'jenis_barang_id' => $kursiSiswa->jenis_barang_id,
                    'kode_barang' => sprintf('KRS-%03d', $i),
                    'merk' => 'Chitose',
                    'kondisi' => $i > 13 ? 'diperbaiki' : 'baik',
                    'lokasi' => 'Ruang Kelas ' . (ceil($i / 5)) . chr(64 + (($i - 1) % 3 + 1)),
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // ROUTER
        $router = JenisBarang::where('jenis', 'Router')->first();
        if ($router) {
            $routerData = [
                ['nama' => 'Router TP-Link Archer C6', 'kode' => 'RTR-001', 'merk' => 'TP-Link', 'kondisi' => 'baik', 'lokasi' => 'Ruang IT'],
                ['nama' => 'Router Mikrotik RB750', 'kode' => 'RTR-002', 'merk' => 'Mikrotik', 'kondisi' => 'baik', 'lokasi' => 'Ruang Server'],
                ['nama' => 'Router Tenda AC10U', 'kode' => 'RTR-003', 'merk' => 'Tenda', 'kondisi' => 'baik', 'lokasi' => 'Lab Komputer'],
            ];
            foreach ($routerData as $data) {
                Barang::firstOrCreate(['nama_barang' => $data['nama']], [
                    'barang_id' => uuid_create(),
                    'jenis_barang_id' => $router->jenis_barang_id,
                    'kode_barang' => $data['kode'],
                    'merk' => $data['merk'],
                    'kondisi' => $data['kondisi'],
                    'lokasi' => $data['lokasi'],
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        // BOLA SEPAK
        $bolaSepak = JenisBarang::where('jenis', 'Bola Sepak')->first();
        if ($bolaSepak) {
            for ($i = 1; $i <= 5; $i++) {
                Barang::firstOrCreate(['kode_barang' => sprintf('BSK-%03d', $i)], [
                    'barang_id' => uuid_create(),
                    'nama_barang' => 'Bola Sepak Size 5 #' . $i,
                    'jenis_barang_id' => $bolaSepak->jenis_barang_id,
                    'kode_barang' => sprintf('BSK-%03d', $i),
                    'merk' => $i <= 3 ? 'Adidas' : 'Nike',
                    'kondisi' => $i == 5 ? 'diperbaiki' : 'baik',
                    'lokasi' => 'Gudang Olahraga',
                    'gambar' => null,
                    'status' => 'aktif',
                ]);
            }
        }

        $this->command->info('✅ Data Barang berhasil dibuat!');
    }
}