<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $primaryKey = "item_id";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'item_id',
        'gambar',
        'nama_barang',
        'jenis',
        'merk',
        'kondisi',
        'stok',
        'satuan',
        'lokasi', 
    ];
}
