<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    protected $table = 'penyewaan';
    
    protected $fillable = [
        'user_id', 
        'kendaraan_id', 
        'tanggal_mulai', 
        'tanggal_selesai', 
        'lokasi_pengambilan', 
        'kondisi_ambil',
        'catatan_kondisi_ambil',
        'metode_pembayaran', 
        'nik_pelanggan',
        'foto_ktp_path',
        'harga_per_hari',
        'jumlah_hari',
        'total_harga', 
        'jumlah_bayar',
        'status_pembayaran',
        'kurang_bayar',
        'denda_keterlambatan',
        'denda_kerusakan',
        'detail_kerusakan',
        'denda_kehilangan',
        'detail_kehilangan',
        'status_denda',
        'denda_dibayar_at',
        'tanggal_pengembalian',
        'kondisi_kembali',
        'catatan_pengembalian',
        'status_sewa',
        'booking_code',
        'booking_expires_at',
        'paid_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_pengembalian' => 'date',
        'booking_expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'denda_dibayar_at' => 'datetime',
        'detail_kerusakan' => 'array',
        'detail_kehilangan' => 'array',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'penyewaan_id');
    }

    public function pengembalianRecords()
    {
        return $this->hasMany(Pengembalian::class, 'penyewaan_id');
    }

    public function getTotalDendaAttribute(): int
    {
        return (int) $this->denda_keterlambatan + (int) $this->denda_kerusakan + (int) $this->denda_kehilangan;
    }

    public function getQrPayloadAttribute(): string
    {
        return implode('|', [
            'JAYA-RENTAL',
            $this->booking_code,
            $this->user?->name,
            $this->kendaraan?->nama_kendaraan,
            $this->total_harga,
        ]);
    }

    public function getQrSvgAttribute(): string
    {
        $payload = $this->qr_payload;
        $hash = hash('sha256', $payload);
        $size = 29;
        $cell = 6;
        $svgSize = $size * $cell;
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'.$svgSize.'" height="'.$svgSize.'" viewBox="0 0 '.$svgSize.' '.$svgSize.'" role="img" aria-label="QR booking '.$this->booking_code.'"><rect width="100%" height="100%" fill="#fff"/>';

        $finder = function (int $x, int $y) use (&$svg, $cell): void {
            $svg .= '<rect x="'.($x * $cell).'" y="'.($y * $cell).'" width="'.(7 * $cell).'" height="'.(7 * $cell).'" fill="#111827"/>';
            $svg .= '<rect x="'.(($x + 1) * $cell).'" y="'.(($y + 1) * $cell).'" width="'.(5 * $cell).'" height="'.(5 * $cell).'" fill="#fff"/>';
            $svg .= '<rect x="'.(($x + 2) * $cell).'" y="'.(($y + 2) * $cell).'" width="'.(3 * $cell).'" height="'.(3 * $cell).'" fill="#111827"/>';
        };

        $finder(1, 1);
        $finder(21, 1);
        $finder(1, 21);

        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $inFinder = ($x >= 1 && $x <= 7 && $y >= 1 && $y <= 7)
                    || ($x >= 21 && $x <= 27 && $y >= 1 && $y <= 7)
                    || ($x >= 1 && $x <= 7 && $y >= 21 && $y <= 27);

                if ($inFinder) {
                    continue;
                }

                $char = hexdec($hash[($x + ($y * $size)) % strlen($hash)]);
                if (($char + $x + $y) % 3 === 0) {
                    $svg .= '<rect x="'.($x * $cell).'" y="'.($y * $cell).'" width="'.$cell.'" height="'.$cell.'" fill="#111827"/>';
                }
            }
        }

        return $svg.'</svg>';
    }
}
