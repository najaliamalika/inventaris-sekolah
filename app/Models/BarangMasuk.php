<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $primaryKey = 'masuk_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'barang_masuk';

    protected $fillable = [
        'masuk_id',
        'tanggal',
        'kategori',
        'nama_supplier',
        'total_jumlah',
        'total_harga',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'total_jumlah' => 'integer',
        'total_harga' => 'integer',
    ];

    public function details()
    {
        return $this->hasMany(BarangMasukDetail::class, 'masuk_id', 'masuk_id');
    }

    public function hitungTotal()
    {
        $this->total_jumlah = $this->details()->sum('jumlah');
        $this->total_harga = $this->details()->sum('subtotal');
        $this->save();
    }

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal->format('d/m/Y H:i');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
    public function scopeBySupplier($query, $supplier)
    {
        return $query->where('nama_supplier', 'like', "%{$supplier}%");
    }

    public function scopeByTanggal($query, $tanggalMulai, $tanggalAkhir = null)
    {
        if ($tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        }
        return $query->whereDate('tanggal', $tanggalMulai);
    }
}