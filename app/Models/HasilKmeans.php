<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilKmeans extends Model
{
    use HasFactory;

    protected $table = 'hasil_kmeans';
    protected $guarded = ['id'];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id');
    }
}
