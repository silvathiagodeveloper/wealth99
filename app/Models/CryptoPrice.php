<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoPrice extends Model
{
    protected $fillable = [
        'coin',
        'price',
        'recorded_at',
    ];
}