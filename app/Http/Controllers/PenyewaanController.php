<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Kendaraan;
use App\Models\PickupPoint;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PenyewaanController extends Controller
{
    // 1. Tampilkan Dashboard Pengguna
    public function index()
    {
        $mobilTersedia = Kendaraan::where('status', 'Tersedia')
            ->where('unit_tersedia', '>', 0)
            ->where(function ($query) {
                $query->whereNull('status_operasional')
                    ->orWhere('status_operasional', '!=', 'Service');
            })
            ->get();
        $riwayatSewa = Penyewaan::with('kendaraan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $this->ensureUserRentalNotifications($riwayatSewa);

        $notifications = UserNotification::where('user_id', Auth::id())
            ->latest()
            ->limit(12)
            ->get();
        $unreadNotifications = $notifications->whereNull('read_at')->count();

        $totalPengeluaran = $riwayatSewa->sum(function ($item) {
            return (int) $item->total_harga + (int) $item->denda_keterlambatan;
        });
        $tanggalAwal = $riwayatSewa->min('tanggal_mulai');
        $tanggalAkhir = $riwayatSewa->max('tanggal_selesai');
        $punyaRiwayat = $riwayatSewa->isNotEmpty();

        return view('dashboard', compact(
            'mobilTersedia',
            'riwayatSewa',
            'totalPengeluaran',
            'tanggalAwal',
            'tanggalAkhir',
            'punyaRiwayat',
            'notifications',
            'unreadNotifications'
        ));
    }

    // 2. Tampilkan Halaman FORMULIR Sewa
    public function create($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $pickupPoints = PickupPoint::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($kendaraan->status !== 'Tersedia' || $kendaraan->status_operasional === 'Service' || $kendaraan->unit_tersedia < 1) {
            return redirect()->route('dashboard')->with('error', 'Kendaraan sedang tidak tersedia.');
        }

        return view('sewa.create', compact('kendaraan', 'pickupPoints')); 
    }

    public function riwayatTransaksi()
    {
        $riwayatSewa = Penyewaan::with('kendaraan')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('riwayat-transaksi', compact('riwayatSewa'));
    }

    // 3. Simpan data sementara ke session, lalu pindah ke halaman pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'pickup_point_id' => 'required|exists:pickup_points,id',
            'nik_pelanggan' => 'required|digits:16',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pickupPoint = PickupPoint::findOrFail($request->pickup_point_id);
        $fotoKtpPath = $request->file('foto_ktp')->store('foto-ktp', 'public');

        session(['data_booking' => array_merge($request->except('foto_ktp'), [
            'pickup_point_nama' => $pickupPoint->nama_titik,
            'pickup_point_alamat' => $pickupPoint->alamat,
            'foto_ktp_path' => $fotoKtpPath,
            'booking_created_at' => now()->toIso8601String(),
            'booking_expires_at' => now()->addHours(12)->toIso8601String(),
        ])]);
        return redirect()->route('pembayaran.index');
    }

    // 4. Tampilkan Halaman Pembayaran (Ringkasan)
    public function indexPembayaran()
    {
        if (!session()->has('data_booking')) {
            return redirect()->route('dashboard')->with('error', 'Sesi penyewaan habis.');
        }

        if ($this->bookingSessionExpired()) {
            session()->forget('data_booking');
            return redirect()->route('dashboard')->with('error', 'Booking expired karena melewati 12 jam.');
        }

        $data = session('data_booking');
        $mobil = Kendaraan::findOrFail($data['kendaraan_id']);
        $pickupPoint = PickupPoint::find($data['pickup_point_id']);

        if ($mobil->status !== 'Tersedia' || $mobil->status_operasional === 'Service' || $mobil->unit_tersedia < 1) {
            session()->forget('data_booking');
            return redirect()->route('dashboard')->with('error', 'Kendaraan sedang tidak tersedia.');
        }

        $mulai = Carbon::parse($data['tanggal_mulai']);
        $selesai = Carbon::parse($data['tanggal_selesai']);
        $hari = $mulai->diffInDays($selesai) ?: 1;
        $totalHarga = $mobil->harga_per_hari * $hari;

        return view('pembayaran', compact('mobil', 'data', 'hari', 'totalHarga', 'pickupPoint'));
    }

    // 5. Proses Akhir: Simpan ke Database
    public function prosesPembayaran(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:QRIS,Transfer Bank,E-Wallet,Cash',
            'jumlah_bayar' => 'required|integer|min:0',
        ]);
        
        $data = session('data_booking');
        if (!$data) {
            return redirect()->route('dashboard')->with('error', 'Data tidak ditemukan.');
        }

        if ($this->bookingSessionExpired()) {
            session()->forget('data_booking');
            return redirect()->route('dashboard')->with('error', 'Booking expired karena melewati 12 jam.');
        }

        $mobil = Kendaraan::findOrFail($data['kendaraan_id']);

        if ($mobil->status !== 'Tersedia' || $mobil->status_operasional === 'Service' || $mobil->unit_tersedia < 1) {
            session()->forget('data_booking');
            return redirect()->route('dashboard')->with('error', 'Kendaraan sedang tidak tersedia.');
        }

        $mulai = Carbon::parse($data['tanggal_mulai']);
        $selesai = Carbon::parse($data['tanggal_selesai']);
        $hari = $mulai->diffInDays($selesai) ?: 1;
        $totalHarga = $mobil->harga_per_hari * $hari;

        $jumlahBayar = (int) $request->jumlah_bayar;
        $kurangBayar = max(0, $totalHarga - $jumlahBayar);

        $transaksi = Penyewaan::create([
            'user_id' => Auth::id(),
            'kendaraan_id' => $data['kendaraan_id'],
            'tanggal_mulai' => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'lokasi_pengambilan' => $data['pickup_point_nama'] . ' - ' . $data['pickup_point_alamat'],
            'metode_pembayaran' => $request->metode_pembayaran,
            'nik_pelanggan' => $data['nik_pelanggan'],
            'foto_ktp_path' => $data['foto_ktp_path'],
            'harga_per_hari' => $mobil->harga_per_hari,
            'jumlah_hari' => $hari,
            'total_harga' => $totalHarga,
            'jumlah_bayar' => $jumlahBayar,
            'status_pembayaran' => 'Menunggu Konfirmasi',
            'kurang_bayar' => $kurangBayar,
            'booking_code' => $this->generateBookingCode(),
            'booking_expires_at' => Carbon::parse($data['booking_expires_at']),
            'paid_at' => now(),
            'status_sewa' => 'Pending',
        ]);

        $unitTersedia = max(0, $mobil->unit_tersedia - 1);
        $mobil->update([
            'unit_tersedia' => $unitTersedia,
            'status' => $unitTersedia > 0 ? 'Tersedia' : 'Disewa',
        ]);
        session([
            'transaksi_aktif_id' => $transaksi->id,
            'metode_terpilih' => $request->metode_pembayaran,
        ]);
        session()->forget('data_booking');

        $message = $kurangBayar > 0
            ? 'Pembayaran dikirim, tetapi nominal kurang Rp ' . number_format($kurangBayar, 0, ',', '.') . '. Admin akan mengecek status pembayaran.'
            : 'Pembayaran dikirim. Admin akan mengonfirmasi pembayaran masuk.';

        return redirect()->route('pembayaran.success')->with('success', $message);
    }

    public function successPembayaran()
    {
        $transaksi = $this->getTransaksiAktif();

        return view('pembayaran_berhasil', compact('transaksi'));
    }

    public function warningIdentitas()
    {
        $transaksi = $this->getTransaksiAktif();

        return view('identitas', compact('transaksi'));
    }

    public function struk()
    {
        $transaksi = $this->getTransaksiAktif();

        return view('struk', compact('transaksi'));
    }

    public function downloadStrukPdf()
    {
        $transaksi = $this->getTransaksiAktif();
        $pdf = $this->buildBookingPdf($transaksi);
        $filename = 'bukti-booking-' . ($transaksi->booking_code ?? $transaksi->id) . '.pdf';

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length' => strlen($pdf),
        ]);
    }

    public function markNotificationsRead()
    {
        UserNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    private function getTransaksiAktif(): Penyewaan
    {
        $transaksiId = session('transaksi_aktif_id');

        abort_unless($transaksiId, 404);

        return Penyewaan::with(['kendaraan', 'user'])->findOrFail($transaksiId);
    }

    private function bookingSessionExpired(): bool
    {
        $data = session('data_booking');

        if (!isset($data['booking_expires_at'])) {
            return false;
        }

        return now()->greaterThan(Carbon::parse($data['booking_expires_at']));
    }

    private function generateBookingCode(): string
    {
        do {
            $code = 'BK-' . now()->format('ymd') . '-' . Str::upper(Str::random(6));
        } while (Penyewaan::where('booking_code', $code)->exists());

        return $code;
    }

    private function ensureUserRentalNotifications($riwayatSewa): void
    {
        foreach ($riwayatSewa as $transaksi) {
            if (! in_array($transaksi->status_sewa, ['Pending', 'Menunggu Pembayaran Denda'], true)) {
                continue;
            }

            $tanggalPengembalian = Carbon::parse($transaksi->tanggal_selesai)->startOfDay();
            $today = now()->startOfDay();

            if ($today->diffInDays($tanggalPengembalian, false) <= 1 && $today->lessThanOrEqualTo($tanggalPengembalian)) {
                $this->createUserNotificationOnce(
                    $transaksi,
                    'return_reminder',
                    'Pengingat tanggal pengembalian',
                    'Kendaraan ' . ($transaksi->kendaraan?->nama_kendaraan ?? '-') . ' harus dikembalikan pada ' . $tanggalPengembalian->format('d-m-Y') . '.'
                );
            }

            if ($today->greaterThan($tanggalPengembalian) && ! $transaksi->tanggal_pengembalian) {
                $this->createUserNotificationOnce(
                    $transaksi,
                    'overdue',
                    'Kendaraan terlambat dikembalikan',
                    'Anda terlambat mengembalikan kendaraan. Segera hubungi admin untuk proses pengembalian dan perhitungan denda.'
                );
            }
        }
    }

    private function createUserNotificationOnce(Penyewaan $transaksi, string $type, string $title, string $message): void
    {
        $exists = UserNotification::where('user_id', $transaksi->user_id)
            ->where('penyewaan_id', $transaksi->id)
            ->where('type', $type)
            ->exists();

        if ($exists) {
            return;
        }

        UserNotification::create([
            'user_id' => $transaksi->user_id,
            'penyewaan_id' => $transaksi->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ]);
    }

    private function buildBookingPdf(Penyewaan $transaksi): string
    {
        $lines = [
            ['JAYA RENTAL', 20, true],
            ['Bukti Booking Penyewaan Kendaraan', 13, false],
            ['Tanggal Cetak: ' . now()->format('d-m-Y H:i'), 10, false],
            ['', 10, false],
            ['Kode Booking: ' . ($transaksi->booking_code ?? '-'), 12, true],
            ['Nama Pelanggan: ' . ($transaksi->user?->name ?? '-'), 11, false],
            ['NIK Pelanggan: ' . ($transaksi->nik_pelanggan ?? '-'), 11, false],
            ['Kendaraan: ' . ($transaksi->kendaraan?->nama_kendaraan ?? '-'), 11, false],
            ['Plat Nomor: ' . ($transaksi->kendaraan?->plat_nomor ?? '-'), 11, false],
            ['Tanggal Mulai: ' . $this->formatPdfDate($transaksi->tanggal_mulai), 11, false],
            ['Tanggal Pengembalian: ' . $this->formatPdfDate($transaksi->tanggal_selesai), 11, false],
            ['Tanggal Dikembalikan: ' . ($transaksi->tanggal_pengembalian ? $this->formatPdfDate($transaksi->tanggal_pengembalian) : 'Belum dikembalikan'), 11, false],
            ['Durasi Sewa: ' . $transaksi->jumlah_hari . ' Hari', 11, false],
            ['Metode Pembayaran: ' . ($transaksi->metode_pembayaran ?? '-'), 11, false],
            ['Status Pembayaran: ' . ($transaksi->status_pembayaran ?? '-'), 11, false],
            ['', 10, false],
            ['Harga per Hari: Rp ' . number_format($transaksi->harga_per_hari, 0, ',', '.'), 11, false],
            ['Total: Rp ' . number_format($transaksi->total_harga, 0, ',', '.'), 11, true],
            ['Jumlah Dibayar: Rp ' . number_format($transaksi->jumlah_bayar, 0, ',', '.'), 11, false],
            ['Kurang Bayar: Rp ' . number_format($transaksi->kurang_bayar, 0, ',', '.'), 11, false],
            ['Denda Keterlambatan: Rp ' . number_format($transaksi->denda_keterlambatan, 0, ',', '.'), 11, false],
            ['', 10, false],
            ['Tunjukkan bukti booking atau QR booking kepada admin saat pengambilan kendaraan.', 10, false],
        ];

        $content = "";
        $y = 790;

        foreach ($lines as [$text, $size, $bold]) {
            if ($text === '') {
                $y -= 12;
                continue;
            }

            foreach ($this->wrapPdfText($text, 82) as $line) {
                $font = $bold ? 'F2' : 'F1';
                $content .= 'BT /' . $font . ' ' . $size . ' Tf 50 ' . $y . ' Td (' . $this->escapePdfText($line) . ") Tj ET\n";
                $y -= $size + 7;
            }
        }

        return $this->makeSimplePdf($content);
    }

    private function formatPdfDate($date): string
    {
        return $date ? Carbon::parse($date)->format('d-m-Y') : '-';
    }

    private function wrapPdfText(string $text, int $limit): array
    {
        $words = explode(' ', $text);
        $lines = [];
        $line = '';

        foreach ($words as $word) {
            $candidate = trim($line . ' ' . $word);
            if (strlen($candidate) > $limit && $line !== '') {
                $lines[] = $line;
                $line = $word;
                continue;
            }
            $line = $candidate;
        }

        if ($line !== '') {
            $lines[] = $line;
        }

        return $lines;
    }

    private function escapePdfText(string $text): string
    {
        $text = preg_replace('/[^\x20-\x7E]/', '?', $text) ?? $text;

        return str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
    }

    private function makeSimplePdf(string $content): string
    {
        $objects = [
            "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n",
            "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n",
            "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >>\nendobj\n",
            "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n",
            "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n",
            "6 0 obj\n<< /Length " . strlen($content) . " >>\nstream\n" . $content . "endstream\nendobj\n",
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object;
        }

        $xref = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }

        $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xref . "\n%%EOF";

        return $pdf;
    }
}
