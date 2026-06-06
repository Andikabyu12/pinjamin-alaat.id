<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_alat',
        'kode_alat_text',
        'deskripsi',
        'stok',
        'stok_baik',
        'stok_rusak',
        'kondisi',
        'kategori',
        'status',
        'gambar',
        'qr_code',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'alat_id');
    }
}