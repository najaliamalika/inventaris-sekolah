<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class Peminjaman extends Model
{
    use HasUuids;

    protected $table = 'peminjaman';
    protected $primaryKey = 'peminjaman_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'nama_peminjam',
        'foto_peminjaman',
        'foto_pengembalian',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'datetime',
        'tanggal_pengembalian' => 'datetime',
    ];

    public function barang()
    {
        return $this->belongsToMany(
            Barang::class,
            'peminjaman_barang',
            'peminjaman_id',
            'barang_id'
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
        return $this->hasMany(PeminjamanBarang::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function getFotoPeminjamanUrlAttribute(): string
    {
        if (!$this->foto_peminjaman) {
            return 'https://via.placeholder.com/150';
        }

        return asset(Storage::url($this->foto_peminjaman));
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->whereHas('barang', function ($q) use ($status) {
            $q->wherePivot('status', $status);
        });
    }
}