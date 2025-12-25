<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'detail_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'barang_masuk_detail';

    protected $fillable = [
        'detail_id',
        'masuk_id',
        'jenis_barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'keterangan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'integer',
        'subtotal' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detail) {
            $detail->subtotal = $detail->jumlah * ($detail->harga_satuan ?? 0);
        });

        static::saved(function ($detail) {
            if ($detail->barangMasuk) {
                $detail->barangMasuk->hitungTotal();
            }
        });

        static::deleted(function ($detail) {
            if ($detail->barangMasuk) {
                $detail->barangMasuk->hitungTotal();
            }
        });
    }

    public function barangMasuk()
    {
        return $this->belongsTo(BarangMasuk::class, 'masuk_id', 'masuk_id');
    }

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function barangItems()
    {
        return $this->hasMany(Barang::class, 'detail_id', 'detail_id');
    }

    public function getHargaSatuanFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    public function getSubtotalFormatAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}