<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $table = "barang_masuk";
    protected $primaryKey = "masuk_id";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'masuk_id',
        'item_id',
        'tanggal',
        'kode_barang',
        'jumlah',
        'keterangan',
        'kategori',
        'harga_satuan',
        'nama_supplier',
    ];

      public function item()
    {
        return $this->belongsTo(Item::class,'item_id','item_id');
    }
}
