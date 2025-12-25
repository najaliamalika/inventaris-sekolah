<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class PeminjamanBarang extends Model
{
    use HasUuids;

    protected $table = 'peminjaman_barang';
    protected $primaryKey = 'peminjaman_barang_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'status',
        'tanggal_pengembalian',
        'foto_pengembalian',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'peminjaman_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'barang_id');
    }

    public function getFotoPengembalianUrlAttribute(): string
    {
        if (!$this->foto_pengembalian) {
            return 'https://via.placeholder.com/150';
        }

        return asset(Storage::url($this->foto_pengembalian));
    }

    public function isDikembalikan(): bool
    {
        return $this->status === 'dikembalikan';
    }
}