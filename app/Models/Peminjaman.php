<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;
    protected $primaryKey = "peminjaman_id";
    public $incrementing = false;
    protected $keyType = "string";
    protected $table = "peminjaman";
    protected $fillable = [
        'peminjaman_id',
        'tanggal_peminjaman',
        'nama_peminjam',
        'foto_peminjaman',
        'jumlah',
        'keterangan',
        'foto_pengembalian',
        'tanggal_pengembalian',
        'item_id',
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class,'item_id','item_id');
    }
}
