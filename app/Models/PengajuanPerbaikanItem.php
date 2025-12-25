<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanPerbaikanItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuan_perbaikan_item_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'pengajuan_perbaikan_items';

    protected $fillable = [
        'pengajuan_perbaikan_item_id',
        'pengajuan_id',
        'barang_id',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }
}
