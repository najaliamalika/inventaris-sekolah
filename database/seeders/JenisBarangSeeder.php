<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisBarang;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisBarangData = [
            // ELEKTRONIK
            [
                "jenis" => "Laptop",
                "kategori" => "Elektronik",
                "kode_utama" => "OKJ",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Monitor",
                "kategori" => "Elektronik",
                "kode_utama" => "KLB",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Mouse",
                "kategori" => "Elektronik",
                "kode_utama" => "CJH",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Keyboard",
                "kategori" => "Elektronik",
                "kode_utama" => "DTR",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Printer",
                "kategori" => "Elektronik",
                "kode_utama" => "PRN",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Proyektor",
                "kategori" => "Elektronik",
                "kode_utama" => "PRY",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Speaker",
                "kategori" => "Elektronik",
                "kode_utama" => "SPK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Webcam",
                "kategori" => "Elektronik",
                "kode_utama" => "WBC",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Scanner",
                "kategori" => "Elektronik",
                "kode_utama" => "SCN",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "UPS",
                "kategori" => "Elektronik",
                "kode_utama" => "UPS",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Stabilizer",
                "kategori" => "Elektronik",
                "kode_utama" => "STB",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "AC (Air Conditioner)",
                "kategori" => "Elektronik",
                "kode_utama" => "ARC",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "CCTV",
                "kategori" => "Elektronik",
                "kode_utama" => "CTV",
                "satuan" => "Unit"
            ],

            // PERALATAN KANTOR
            [
                "jenis" => "Meja Kantor",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "MJK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Kursi Kantor",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "KRK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Lemari Arsip",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "LMR",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Rak Buku",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "RBK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Papan Tulis",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "PTL",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Papan White Board",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "PWB",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Filing Cabinet",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "FLC",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Brankas",
                "kategori" => "Peralatan Kantor",
                "kode_utama" => "BRK",
                "satuan" => "Unit"
            ],

            // ATK (Alat Tulis Kantor)
            [
                "jenis" => "Kertas HVS A4",
                "kategori" => "ATK",
                "kode_utama" => "KTA",
                "satuan" => "Rim"
            ],
            [
                "jenis" => "Kertas HVS F4",
                "kategori" => "ATK",
                "kode_utama" => "KTF",
                "satuan" => "Rim"
            ],
            [
                "jenis" => "Pulpen",
                "kategori" => "ATK",
                "kode_utama" => "PPN",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Pensil",
                "kategori" => "ATK",
                "kode_utama" => "PSL",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Spidol Whiteboard",
                "kategori" => "ATK",
                "kode_utama" => "SPW",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Spidol Permanent",
                "kategori" => "ATK",
                "kode_utama" => "SPP",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Penghapus",
                "kategori" => "ATK",
                "kode_utama" => "PHM",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Penggaris",
                "kategori" => "ATK",
                "kode_utama" => "PGR",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Stapler",
                "kategori" => "ATK",
                "kode_utama" => "STL",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Isi Stapler",
                "kategori" => "ATK",
                "kode_utama" => "IST",
                "satuan" => "Box"
            ],
            [
                "jenis" => "Gunting",
                "kategori" => "ATK",
                "kode_utama" => "GNT",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Cutter",
                "kategori" => "ATK",
                "kode_utama" => "CTR",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Lakban",
                "kategori" => "ATK",
                "kode_utama" => "LKB",
                "satuan" => "Roll"
            ],
            [
                "jenis" => "Double Tape",
                "kategori" => "ATK",
                "kode_utama" => "DBT",
                "satuan" => "Roll"
            ],
            [
                "jenis" => "Lem Kertas",
                "kategori" => "ATK",
                "kode_utama" => "LKR",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Map Plastik",
                "kategori" => "ATK",
                "kode_utama" => "MPL",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Map Snelhecter",
                "kategori" => "ATK",
                "kode_utama" => "MSN",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Ordner",
                "kategori" => "ATK",
                "kode_utama" => "ORD",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Buku Folio",
                "kategori" => "ATK",
                "kode_utama" => "BFL",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Buku Kwarto",
                "kategori" => "ATK",
                "kode_utama" => "BKW",
                "satuan" => "Pcs"
            ],

            // PERALATAN PEMBELAJARAN
            [
                "jenis" => "Meja Siswa",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "MJS",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Kursi Siswa",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "KRS",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Meja Guru",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "MJG",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Kursi Guru",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "KRG",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Alat Peraga Matematika",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "APM",
                "satuan" => "Set"
            ],
            [
                "jenis" => "Alat Peraga IPA",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "API",
                "satuan" => "Set"
            ],
            [
                "jenis" => "Globe",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "GLB",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Peta Dunia",
                "kategori" => "Peralatan Pembelajaran",
                "kode_utama" => "PTD",
                "satuan" => "Unit"
            ],

            // PERALATAN KEBERSIHAN
            [
                "jenis" => "Sapu",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "SPU",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Pel",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "PEL",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Kemoceng",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "KMC",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Tempat Sampah",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "TSM",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Ember",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "EMB",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Sabun Cuci Tangan",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "SCT",
                "satuan" => "Liter"
            ],
            [
                "jenis" => "Pembersih Lantai",
                "kategori" => "Peralatan Kebersihan",
                "kode_utama" => "PBL",
                "satuan" => "Liter"
            ],

            // NETWORKING
            [
                "jenis" => "Router",
                "kategori" => "Networking",
                "kode_utama" => "RTR",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Switch",
                "kategori" => "Networking",
                "kode_utama" => "SWC",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Access Point",
                "kategori" => "Networking",
                "kode_utama" => "ACP",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Kabel LAN",
                "kategori" => "Networking",
                "kode_utama" => "KLN",
                "satuan" => "Meter"
            ],
            [
                "jenis" => "Kabel HDMI",
                "kategori" => "Networking",
                "kode_utama" => "KHD",
                "satuan" => "Pcs"
            ],

            // PERALATAN OLAHRAGA
            [
                "jenis" => "Bola Sepak",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "BSK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Bola Voli",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "BVL",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Bola Basket",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "BBK",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Net Voli",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "NVL",
                "satuan" => "Unit"
            ],
            [
                "jenis" => "Raket Badminton",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "RBD",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Shuttlecock",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "SHC",
                "satuan" => "Pcs"
            ],
            [
                "jenis" => "Matras",
                "kategori" => "Peralatan Olahraga",
                "kode_utama" => "MTR",
                "satuan" => "Unit"
            ],

            // CONSUMABLES
            [
                "jenis" => "Tinta Printer Black",
                "kategori" => "Consumables",
                "kode_utama" => "TPB",
                "satuan" => "Botol"
            ],
            [
                "jenis" => "Tinta Printer Color",
                "kategori" => "Consumables",
                "kode_utama" => "TPC",
                "satuan" => "Botol"
            ],
            [
                "jenis" => "Toner Printer",
                "kategori" => "Consumables",
                "kode_utama" => "TNP",
                "satuan" => "Unit"
            ],
        ];

        foreach ($jenisBarangData as $data) {
            JenisBarang::firstOrCreate(
                ["jenis" => $data["jenis"]], // Kondisi pencarian
                [
                    "jenis_barang_id" => uuid_create(),
                    "kategori" => $data["kategori"],
                    "kode_utama" => $data["kode_utama"],
                    "satuan" => $data["satuan"]
                ]
            );
        }

        $this->command->info('✅ Jenis Barang berhasil dibuat!');
    }
}