<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pelanggans';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    /**
     * Hijack data form sebelum disimpan,
     * agar no_pelanggan = YYYYMMDD + urutan 3 digit.
     *
     * @param  array  $data  Hasil state form
     * @return array<int, array>  Array of data-records
     */
    protected static function booted()
    {
        static::creating(function ($pelanggan) {
            if (!$pelanggan->no_pelanggan) {
                $today = Carbon::now()->format('Ymd');
                $last = static::whereDate('created_at', now()->toDateString())
                    ->where('no_pelanggan', 'like', "$today%")
                    ->latest('no_pelanggan')
                    ->value('no_pelanggan');
                $seq  = $last ? (int)substr($last, -3) : 0;
                $pelanggan->no_pelanggan = $today . str_pad($seq + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function Transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
    }


}
