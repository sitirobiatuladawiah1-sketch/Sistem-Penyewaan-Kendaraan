<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $fillable = [
        'nama_kendaraan',
        'jenis',
        'tahun',
        'plat_nomor',
        'no_bpkb',
        'pajak_berlaku_sampai',
        'status_pajak',
        'tanggal_bayar_pajak',
        'image_url',
        'harga_per_hari',
        'jumlah_unit',
        'unit_tersedia',
        'status',
        'status_operasional',
    ];

    public function serviceHistories()
    {
        return $this->hasMany(ServiceHistory::class, 'kendaraan_id');
    }
}
