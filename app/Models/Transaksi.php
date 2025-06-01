<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksis';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    protected $casts = [
        'tanggal_transaksi' => 'date:Y-m-d',
    ];

    protected static function booted()
    {
        static::creating(function (Transaksi $model) {
            if (empty($model->tanggal_transaksi)) {
                $model->tanggal_transaksi = Carbon::now()->toDateString();
            }
        });
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
