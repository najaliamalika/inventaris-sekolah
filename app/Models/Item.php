<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_id',
        'item_templates_id',
        'gambar',
        'nama_barang',
        'kode_barang',
        'merk',
        'kondisi',
        'lokasi',
    ];

    protected $casts = [
        'kondisi' => 'string',
    ];

    /**
     * Relasi ke item template
     */
    public function itemTemplate()
    {
        return $this->belongsTo(ItemTemplate::class, 'item_templates_id', 'item_templates_id');
    }

    /**
     * Scope untuk filter berdasarkan kondisi
     */
    public function scopeKondisi($query, $kondisi)
    {
        return $query->where('kondisi', $kondisi);
    }

    /**
     * Scope untuk filter berdasarkan kategori template
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->whereHas('itemTemplate', function ($q) use ($kategori) {
            $q->where('kategori', $kategori);
        });
    }

    /**
     * Accessor untuk mendapatkan nama kategori dari template
     */
    public function getKategoriAttribute()
    {
        return $this->itemTemplate?->kategori ?? '-';
    }

    /**
     * Accessor untuk mendapatkan jenis dari template
     */
    public function getJenisAttribute()
    {
        return $this->itemTemplate?->jenis ?? '-';
    }

    /**
     * Accessor untuk mendapatkan satuan dari template
     */
    public function getSatuanAttribute()
    {
        return $this->itemTemplate?->satuan ?? '-';
    }
}