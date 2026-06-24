<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceHistory extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'tanggal_service',
        'nama_bengkel',
        'jenis_service',
        'kerusakan',
        'perbaikan',
        'catatan',
        'biaya',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
