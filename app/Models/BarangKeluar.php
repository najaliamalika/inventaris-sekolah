<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $primaryKey = 'keluar_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'barang_keluar';

    protected $fillable = [
        'keluar_id',
        'jenis_barang_id',
        'tanggal',
        'kategori',
        'penerima',
        'jumlah',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah' => 'integer',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function items()
    {
        return $this->hasMany(BarangKeluarItem::class, 'keluar_id', 'keluar_id');
    }

    public function barang()
    {
        return $this->hasManyThrough(
            Barang::class,
            BarangKeluarItem::class,
            'keluar_id',
            'barang_id',
            'keluar_id',
            'barang_id'
        );
    }

    public function getTanggalFormatAttribute()
    {
        return $this->tanggal->format('d/m/Y H:i');
    }

    public function getKategoriLabelAttribute()
    {
        $labels = [
            'habis_pakai' => 'Habis Pakai',
            'rusak' => 'Rusak',
            'tidak_layak' => 'Tidak Layak',
            'sedang_diperbaiki' => 'Sedang Diperbaiki',
            'dihibahkan' => 'Dihibahkan',
        ];

        return $labels[$this->kategori] ?? $this->kategori;
    }

    public function getKategoriColorAttribute()
    {
        $colors = [
            'habis_pakai' => 'blue',
            'rusak' => 'red',
            'tidak_layak' => 'gray',
            'sedang_diperbaiki' => 'yellow',
            'dihibahkan' => 'green',
        ];

        return $colors[$this->kategori] ?? 'gray';
    }

    public function getKategoriIconAttribute()
    {
        $icons = [
            'habis_pakai' => '📦',
            'rusak' => '💔',
            'tidak_layak' => '❌',
            'sedang_diperbaiki' => '🔧',
            'dihibahkan' => '🎁',
        ];

        return $icons[$this->kategori] ?? '📤';
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeByJenisBarang($query, $jenisBarangId)
    {
        return $query->where('jenis_barang_id', $jenisBarangId);
    }

    public function scopeByTanggal($query, $tanggalMulai, $tanggalAkhir = null)
    {
        if ($tanggalAkhir) {
            return $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        }
        return $query->whereDate('tanggal', $tanggalMulai);
    }

}
