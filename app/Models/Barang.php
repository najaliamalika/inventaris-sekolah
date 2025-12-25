<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;

    protected $primaryKey = 'barang_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'barang';

    protected $fillable = [
        'barang_id',
        'jenis_barang_id',
        'detail_id',
        'gambar',
        'nama_barang',
        'kode_barang',
        'merk',
        'kondisi',
        'lokasi',
        'status',
    ];

    protected $casts = [
        'kondisi' => 'string',
        'status' => 'string',
    ];

    protected $appends = ['gambar_url'];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    public function barangMasukDetail()
    {
        return $this->belongsTo(BarangMasukDetail::class, 'detail_id', 'detail_id');
    }

    public function barangKeluarItems()
    {
        return $this->hasMany(BarangKeluarItem::class, 'barang_id', 'barang_id');
    }

    public function getGambarUrlAttribute()
    {
        return $this->gambar
            ? Storage::url($this->gambar)
            : null;
    }

    public function peminjaman()
    {
        return $this->belongsToMany(
            Peminjaman::class,
            'peminjaman_barang',
            'barang_id',
            'peminjaman_id'
        )
            ->withPivot([
                'peminjaman_barang_id',
                'status',
                'tanggal_pengembalian',
                'foto_pengembalian',
                'catatan'
            ])
            ->withTimestamps();
    }

    public function peminjamanBarang()
    {
        return $this->hasMany(PeminjamanBarang::class, 'barang_id', 'barang_id');
    }

    public function scopeBaik($query)
    {
        return $query->where('kondisi', 'baik');
    }

    public function scopeDiperbaiki($query)
    {
        return $query->where('kondisi', 'diperbaiki');
    }

    public function scopeDipinjam($query)
    {
        return $query->where('kondisi', 'dipinjam');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'nonaktif');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status', 'aktif')->where('kondisi', 'baik');
    }

    public function isTersedia()
    {
        return $this->status === 'aktif' && $this->kondisi === 'baik';
    }

    public function isAktif()
    {
        return $this->status === 'aktif';
    }
}