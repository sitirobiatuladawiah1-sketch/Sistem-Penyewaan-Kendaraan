<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $fillable = [
        'penyewaan_id',
        'kendaraan_id',
        'user_id',
        'tanggal_ambil',
        'kondisi_ambil',
        'catatan_kondisi_ambil',
        'tanggal_kembali',
        'kondisi_kembali',
        'catatan_pengembalian',
        'denda',
    ];

    protected $casts = [
        'tanggal_ambil' => 'date',
        'tanggal_kembali' => 'date',
    ];

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'penyewaan_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
