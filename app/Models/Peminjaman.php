<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Alat;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'alat_id',
        'qty',
        'status',
        'nomor_peminjaman',
        'return_date',
        'borrowed_at',
        'returned_at',
        'photo_return',
        'return_description',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',
        'return_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->nomor_peminjaman) {
                $model->nomor_peminjaman = self::generateNomorPeminjaman();
            }
        });
    }

    public static function generateNomorPeminjaman()
    {
        $lastId = self::max('id') ?? 0;
        $nextId = $lastId + 1;
        return 'PJM-' . str_pad($nextId, 6, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd');
    }

    public function isOverdue()
    {
        return $this->status !== 'returned' && now()->gt($this->return_date);
    }
}
