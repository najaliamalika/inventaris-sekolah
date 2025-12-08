<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::firstOrCreate([
            "nama_barang"=> "Proyektor",

        ],[
            "item_id"=> uuid_create(),
            "jenis"=> "Elektronik",
            "merk"=> "Infocus",
            "kondisi"=> "Baik",
            "satuan"=> "Unit",
        ]);

         Item::firstOrCreate([
            "nama_barang"=> "Printer",

        ],[
            "item_id"=> uuid_create(),
            "jenis"=> "Elektronik",
            "merk"=> "Epson",
            "kondisi"=> "Baik",
            "satuan"=> "Unit",
        ]);

         Item::firstOrCreate([
            "nama_barang"=> "AC",

        ],[
            "item_id"=> uuid_create(),
            "jenis"=> "Elektronik",
            "merk"=> "LG",
            "kondisi"=> "Baik",
            "satuan"=> "Unit",
        ]);

         Item::firstOrCreate([
            "nama_barang"=> "Sound System",

        ],[
            "item_id"=> uuid_create(),
            "jenis"=> "Elektronik",
            "merk"=> "Yamaha",
            "kondisi"=> "Baik",
            "satuan"=> "Unit",
        ]);

         Item::firstOrCreate([
            "nama_barang"=> "Laptop",

        ],[
            "item_id"=> uuid_create(),
            "jenis"=> "Elektronik",
            "merk"=> "Asus",
            "kondisi"=> "Baik",
            "satuan"=> "Unit",
        ]);
    }
}
