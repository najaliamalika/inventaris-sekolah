<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $primaryKey = 'jenis_barang_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'jenis_barang';

    protected $fillable = [
        'jenis_barang_id',
        'kategori',
        'jenis',
        'kode_utama',
        'satuan',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function barangMasukDetail()
    {
        return $this->hasMany(BarangMasukDetail::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', 'like', "%{$kategori}%");
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', 'like', "%{$jenis}%");
    }

    public function getJumlahBarangAttribute()
    {
        return $this->barang()->count();
    }

}