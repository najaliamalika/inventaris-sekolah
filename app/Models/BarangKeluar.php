<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $table = "barang_keluar";
    protected $primaryKey = "keluar_id";
    public $incrementing = false;
    protected $keyType = "string";
    protected $fillable = [
        'keluar_id',
        'item_id',
        'masuk_id',
        'tanggal',
        'jumlah',
        'keterangan',
        'kategori',
    ];

      public function item()
    {
        return $this->belongsTo(Item::class,'item_id','item_id');
    }

          public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class,'masuk_id','masuk_id');
    }

}
