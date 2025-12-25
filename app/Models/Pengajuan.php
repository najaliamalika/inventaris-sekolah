<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pengajuan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'pengajuan';

    protected $fillable = [
        'pengajuan_id',
        'jenis_barang_id',
        'nama_barang',
        'tipe',
        'jumlah',
        'estimasi_biaya',
        'alasan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'estimasi_biaya' => 'integer',
    ];

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenis_barang_id', 'jenis_barang_id');
    }

    // Items untuk pengajuan perbaikan
    public function perbaikanItems()
    {
        return $this->hasMany(PengajuanPerbaikanItem::class, 'pengajuan_id', 'pengajuan_id');
    }

    // Barang yang akan diperbaiki (through pivot)
    public function barangPerbaikan()
    {
        return $this->hasManyThrough(
            Barang::class,
            PengajuanPerbaikanItem::class,
            'pengajuan_id',
            'barang_id',
            'pengajuan_id',
            'barang_id'
        );
    }

    public function getTipeLabel()
    {
        return $this->tipe === 'pembelian' ? 'Pembelian' : 'Perbaikan';
    }

    public function getStatusLabel()
    {
        $labels = [
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColor()
    {
        $colors = [
            'menunggu' => 'yellow',
            'disetujui' => 'green',
            'ditolak' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }

    public function getTipeIcon()
    {
        return $this->tipe === 'pembelian' ? '🛒' : '🔧';
    }

    public function getStatusIcon()
    {
        $icons = [
            'menunggu' => '⏳',
            'disetujui' => '✅',
            'ditolak' => '❌',
        ];
        return $icons[$this->status] ?? '❓';
    }

    public function getEstimasiBiayaFormatAttribute()
    {
        return 'Rp ' . number_format($this->estimasi_biaya, 0, ',', '.');
    }

    // Scopes
    public function scopeByTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByJenisBarang($query, $jenisBarangId)
    {
        return $query->where('jenis_barang_id', $jenisBarangId);
    }

    public function scopePembelian($query)
    {
        return $query->where('tipe', 'pembelian');
    }

    public function scopePerbaikan($query)
    {
        return $query->where('tipe', 'perbaikan');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function isPembelian()
    {
        return $this->tipe === 'pembelian';
    }

    public function isPerbaikan()
    {
        return $this->tipe === 'perbaikan';
    }

    public function isMenunggu()
    {
        return $this->status === 'menunggu';
    }

    public function isDisetujui()
    {
        return $this->status === 'disetujui';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }
}
