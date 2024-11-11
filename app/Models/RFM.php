<?php

namespace App\Models;

use app\Models\Relationship\TransaksiRelation;
use app\Models\Relationship\TransaksiRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RFM extends Model
{
    use HasFactory;

    protected $table = 'rfms';
    protected $guarded = ['id'];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id', 'pelanggan_id');
    }
}
