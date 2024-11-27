<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cluster extends Model
{
    use HasFactory;

    protected $table = 'clusters';
    protected $guarded = ['id'];

}

