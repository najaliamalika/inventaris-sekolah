<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluarItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'keluar_item_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'barang_keluar_items';

    protected $fillable = [
        'keluar_item_id',
        'keluar_id',
        'barang_id',
    ];

    public function barangKeluar()
    {
        return $this->belongsTo(BarangKeluar::class, 'keluar_id', 'keluar_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
