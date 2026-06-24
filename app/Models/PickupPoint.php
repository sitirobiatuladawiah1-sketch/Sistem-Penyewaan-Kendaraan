<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupPoint extends Model
{
    protected $fillable = [
        'nama_titik',
        'alamat',
        'latitude',
        'longitude',
        'is_active',
        'sort_order',
    ];
}
