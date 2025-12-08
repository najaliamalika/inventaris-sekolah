<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTemplate extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_templates_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_templates_id',
        'kategori',
        'jenis',
        'kode_utama',
        'stok',
        'satuan',
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    /**
     * Relasi ke items
     */
    public function items()
    {
        return $this->hasMany(Item::class, 'item_templates_id', 'item_templates_id');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', 'like', "%{$kategori}%");
    }

    /**
     * Scope untuk filter berdasarkan jenis
     */
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', 'like', "%{$jenis}%");
    }

    /**
     * Accessor untuk mendapatkan jumlah items
     */
    public function getJumlahItemsAttribute()
    {
        return $this->items()->count();
    }

    /**
     * Accessor untuk format stok dengan satuan
     */
    public function getStokFormatAttribute()
    {
        return ($this->stok ?? 0) . ' ' . $this->satuan;
    }

    /**
     * Boot method untuk auto set stok ke 0 jika null
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->stok)) {
                $model->stok = 0;
            }
        });
    }
}