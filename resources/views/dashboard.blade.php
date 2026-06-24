<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYA RENTAL - Dashboard</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --primary: #1f4fd7;
            --border: #e5e7eb;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 28%, #f8fafc 100%);
            font-family: Arial, sans-serif;
            color: var(--text);
        }
        .main-container { max-width: 1240px; margin: auto; padding: 28px; }
        .header {
            background: linear-gradient(135deg, #143c8f 0%, #2757d6 60%, #3d76ff 100%);
            color: white;
            padding: 26px;
            border-radius: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }
        .btn-exit, .btn-sewa, .btn-lihat {
            border: none;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-exit { background: white; color: #111827; padding: 10px 18px; border-radius: 12px; }
        .summary-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }
        .card-sm {
            background: var(--panel);
            padding: 18px;
            border-radius: 18px;
            border: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }
        .icon-box { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: #dbeafe; }
        .car-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; }
        .car-card { background: var(--panel); border-radius: 18px; overflow: hidden; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04); }
        .car-media { height: 170px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 50%, #eff6ff 100%); display: flex; align-items: center; justify-content: center; font-size: 44px; overflow: hidden; }
        .car-media img { width: 100%; height: 100%; object-fit: cover; }
        .car-body { padding: 16px; }
        .btn-sewa { width: 100%; background: var(--primary); color: white; padding: 11px; border-radius: 12px; margin-top: 12px; }
        .history-section { background: var(--panel); padding: 22px; border-radius: 20px; border: 1px solid var(--border); margin-top: 22px; }
        .btn-lihat { background: var(--primary); color: white; padding: 10px 20px; border-radius: 12px; margin-top: 12px; }
        .section-title { display: flex; justify-content: space-between; align-items: end; gap: 12px; margin-bottom: 12px; }
        .section-title p { margin: 0; color: var(--muted); }
        .history-list { display: grid; gap: 12px; }
        .history-item {
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px;
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
        }
        .badge { display: inline-flex; padding: 6px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; }
        .badge.pending { background: #fef3c7; color: #92400e; }
        .badge.done { background: #dcfce7; color: #166534; }
        .muted { color: var(--muted); }
        .section-anchor { scroll-margin-top: 24px; }
        .active-rental {
            background:#eff6ff;
            border:1px solid #bfdbfe;
            border-radius:16px;
            padding:14px;
            margin-bottom:18px;
            display:flex;
            justify-content:space-between;
            gap:12px;
            align-items:center;
        }
        @media (max-width: 900px) {
            .main-container { padding: 18px; }
            .summary-row, .car-grid { grid-template-columns: 1fr; }
            .header, .history-item, .card-sm { flex-direction: column; align-items: flex-start; }
            .header form, .btn-exit, .btn-lihat, .btn-sewa { width: 100%; }
            .section-title { flex-direction: column; align-items: flex-start; }
            .card-sm { gap: 12px; }
            .icon-box { align-self: flex-end; }
        }
        @media (max-width: 560px) {
            .header { padding: 20px; border-radius: 20px; }
            .card-sm { padding: 16px; }
            .history-section { padding: 18px; }
            .car-media { height: 150px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>

<div class="main-container">
    @php
        $authUser = auth()->user();
    @endphp
    <div class="header">
        <div>
            <h2 style="margin:0; text-transform: capitalize;">{{ $authUser->name }}</h2>
            <p style="margin:5px 0 0 0; opacity:0.8;">{{ $punyaRiwayat ? 'Selamat Datang Kembali!' : 'Selamat Datang!' }}</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-exit">Exit</button>
        </form>
    </div>

    <div class="summary-row">
        <a href="#mobil-tersedia" class="card-sm" style="color:inherit; text-decoration:none;">
            <div><small>Mobil tersedia</small><br><strong>{{ $mobilTersedia->sum('unit_tersedia') }} Unit</strong><br><small style="color:#dc2626;">Siap Disewa</small></div>
            <div class="icon-box" style="background:#dbeafe;">CAR</div>
        </a>
        <a href="{{ route('riwayat-transaksi') }}" class="card-sm" style="color:inherit; text-decoration:none;">
            <div><small>Penyewaan Saya</small><br><strong>{{ $riwayatSewa->count() }} Transaksi</strong><br><small>Riwayat terbaru</small></div>
            <div class="icon-box" style="background:#dcfce7;">TRX</div>
        </a>
        <a href="{{ route('riwayat-transaksi') }}" class="card-sm" style="color:inherit; text-decoration:none;">
            <div>
                <small>Total Pengeluaran</small><br>
                <strong>Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong><br>
                <small>Klik untuk halaman riwayat transaksi</small>
            </div>
            <div class="icon-box" style="background:#f3e8ff;">Rp</div>
        </a>
    </div>

    @php
        $sewaAktif = $riwayatSewa->where('status_sewa', 'Pending')->first();
    @endphp
    @if($sewaAktif)
        <a href="#riwayat-sewa" class="active-rental" style="color:inherit; text-decoration:none;">
            <div>
                <strong>Mobil sedang disewa: {{ $sewaAktif->kendaraan?->nama_kendaraan ?? '-' }}</strong><br>
                <small class="muted">Klik untuk melihat detail di riwayat transaksi.</small>
            </div>
            <span class="badge pending">Disewa</span>
        </a>
    @endif

    <div class="section-title section-anchor" id="mobil-tersedia">
        <div>
            <h3 style="margin:0;">Mobil Tersedia</h3>
            <p>Pilih mobil yang pas untuk destinasi Anda.</p>
        </div>
    </div>
    <div class="car-grid">
        @forelse($mobilTersedia as $mobil)
            <div class="car-card">
                <div class="car-media">
                    @if($mobil->image_url)
                        <img src="{{ $mobil->image_url }}" alt="{{ $mobil->nama_kendaraan }}">
                    @else
                        CAR
                    @endif
                </div>
                <div class="car-body">
                    <strong>{{ $mobil->nama_kendaraan }}</strong><br>
                    <small class="muted">{{ $mobil->tahun }} - {{ $mobil->jenis }} - Plat {{ $mobil->plat_nomor ?? '-' }}</small><br>
                    <small class="muted">Unit tersedia: {{ $mobil->unit_tersedia }}</small><br>
                    Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}/hari
                    <a href="{{ route('sewa.create', $mobil->id) }}" class="btn-sewa">Sewa Sekarang</a>
                </div>
            </div>
        @empty
            <div class="car-card" style="grid-column: 1 / -1;">
                <div class="car-body">
                    <strong>Belum ada mobil yang tersedia.</strong><br>
                    <small class="muted">Silakan cek lagi nanti atau hubungi admin.</small>
                </div>
            </div>
        @endforelse
    </div>

    <div class="history-section section-anchor" id="riwayat-sewa">
        <div class="section-title">
            <div>
                <h3 style="margin:0;">Riwayat Penyewaan Saya</h3>
                <p>Lacak transaksi terakhir Anda dari sini.</p>
            </div>
            <a href="#" class="btn-lihat" onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;">Lihat Mobil Tersedia</a>
        </div>

        <div class="history-list">
            @forelse($riwayatSewa as $riwayat)
                <div class="history-item">
                    <div>
                        <strong>{{ $riwayat->kendaraan?->nama_kendaraan ?? 'Kendaraan tidak ditemukan' }}</strong><br>
                        <small class="muted">{{ $riwayat->booking_code }} - {{ $riwayat->tanggal_mulai }} s/d {{ $riwayat->tanggal_selesai }} - {{ $riwayat->metode_pembayaran }}</small>
                        @if($riwayat->denda_keterlambatan > 0)
                            <br><small class="muted">Denda: Rp {{ number_format($riwayat->denda_keterlambatan, 0, ',', '.') }}</small>
                        @endif
                    </div>
                    <div style="text-align:right;">
                        <span class="badge {{ $riwayat->status_sewa === 'Selesai' ? 'done' : 'pending' }}">{{ $riwayat->status_sewa }}</span><br>
                        <strong>Rp {{ number_format($riwayat->total_harga, 0, ',', '.') }}</strong>
                        @if($riwayat->tanggal_pengembalian)
                            <br><small class="muted">Dikembalikan: {{ $riwayat->tanggal_pengembalian }}</small>
                        @endif
                    </div>
                </div>
            @empty
                <div class="history-item">
                    <div>
                        <strong>Belum ada riwayat penyewaan.</strong><br>
                        <small class="muted">Mulai sewa mobil sekarang untuk perjalanan Anda.</small>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="history-section section-anchor" id="total-pengeluaran" style="margin-top:22px;">
        <div class="section-title">
            <div>
                <h3 style="margin:0;">Total Pengeluaran</h3>
                <p>Ringkasan pengeluaran berdasarkan transaksi Anda.</p>
            </div>
        </div>
        @if($punyaRiwayat)
            <p style="margin-top:0;">Periode transaksi: {{ $tanggalAwal }} sampai {{ $tanggalAkhir }}</p>
            <div style="font-size:28px; font-weight:700; color:#1f4fd7;">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        @else
            <p style="margin-top:0; color:#6b7280;">Belum ada transaksi, jadi total pengeluaran masih Rp 0.</p>
        @endif
    </div>
</div>

</body>
</html>
