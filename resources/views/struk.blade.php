<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Booking | Jaya Rental</title>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; padding:24px; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); font-family: Arial, sans-serif; color:var(--text); }
        .wrap { max-width:900px; margin:0 auto; position:relative; }
        .close { position:absolute; right:0; top:0; width:44px; height:44px; border-radius:50%; border:1px solid var(--border); background:#fff; display:grid; place-items:center; text-decoration:none; color:#111827; font-size:20px; font-weight:700; }
        .card { background:var(--panel); border:1px solid var(--border); border-radius:28px; padding:28px; box-shadow: 0 18px 50px rgba(15,23,42,0.08); }
        .brand { display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:18px; }
        .logo { font-size:22px; font-weight:900; color:#143c8f; }
        .meta { color:var(--muted); }
        .line { border-top:1px dashed var(--border); margin:16px 0; }
        .grid { display:grid; grid-template-columns: 1fr 1fr; gap:12px; }
        .item { padding:12px 0; border-bottom:1px solid #eef2f7; }
        .item strong { display:block; margin-top:4px; }
        .footer { margin-top:18px; text-align:center; color:#166534; font-weight:700; }
        .qr { width:174px; height:174px; padding:8px; border:1px solid var(--border); border-radius:18px; background:#fff; }
        .qr svg { width:100%; height:100%; display:block; }
        .btn-row { margin-top:18px; display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }
        .btn { padding:13px 18px; border-radius:12px; text-decoration:none; font-weight:700; }
        .btn-primary { background:var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        @media print { .close, .btn-row { display:none; } body { background:#fff; padding:0; } .card { box-shadow:none; border:0; } }
        @media (max-width: 640px) { .grid { grid-template-columns: 1fr; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="wrap">
        <a href="{{ route('dashboard') }}" class="close">X</a>
        <div class="card">
            <div class="brand">
                <div>
                    <div class="logo">JAYA RENTAL</div>
                    <div class="meta">Bukti booking penyewaan</div>
                </div>
                <div class="qr">{!! $transaksi->qr_svg !!}</div>
            </div>
            <div class="meta">Tanggal: {{ now()->format('d-m-Y') }}</div>

            <div class="line"></div>

            <div class="grid">
                <div class="item">Nama<br><strong>{{ $transaksi->user?->name }}</strong></div>
                <div class="item">Kode Booking<br><strong>{{ $transaksi->booking_code }}</strong></div>
                <div class="item">NIK Pelanggan<br><strong>{{ $transaksi->nik_pelanggan }}</strong></div>
                <div class="item">Plat Nomor<br><strong>{{ $transaksi->kendaraan?->plat_nomor ?? '-' }}</strong></div>
                <div class="item">Tanggal Mulai<br><strong>{{ $transaksi->tanggal_mulai }}</strong></div>
                <div class="item">Tanggal Pengembalian<br><strong>{{ $transaksi->tanggal_selesai }}</strong></div>
                <div class="item">Tanggal Dikembalikan<br><strong>{{ $transaksi->tanggal_pengembalian ?? 'Belum dikembalikan' }}</strong></div>
                <div class="item">Nama Mobil<br><strong>{{ $transaksi->kendaraan?->nama_kendaraan }}</strong></div>
                <div class="item">Tipe Mobil<br><strong>{{ $transaksi->kendaraan?->jenis }}</strong></div>
                <div class="item">Tahun Mobil<br><strong>{{ $transaksi->kendaraan?->tahun }}</strong></div>
                <div class="item">Durasi Sewa<br><strong>{{ $transaksi->jumlah_hari }} Hari</strong></div>
                <div class="item">Harga per Hari<br><strong>Rp {{ number_format($transaksi->harga_per_hari, 0, ',', '.') }}</strong></div>
                <div class="item">Total<br><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></div>
                <div class="item">Jumlah Dibayar<br><strong>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</strong></div>
                <div class="item">Denda Keterlambatan<br><strong>Rp {{ number_format($transaksi->denda_keterlambatan, 0, ',', '.') }}</strong></div>
                <div class="item">Denda Kerusakan<br><strong>Rp {{ number_format($transaksi->denda_kerusakan, 0, ',', '.') }}</strong></div>
                <div class="item">Denda Kehilangan<br><strong>Rp {{ number_format($transaksi->denda_kehilangan, 0, ',', '.') }}</strong></div>
                <div class="item">Total Denda<br><strong>Rp {{ number_format($transaksi->total_denda, 0, ',', '.') }}</strong></div>
                <div class="item">Status Denda<br><strong>{{ $transaksi->status_denda ?? '-' }}</strong></div>
            </div>

            <div class="line"></div>
            <div class="footer">Terima kasih telah menggunakan layanan Jaya Rental.</div>

            <div class="btn-row">
                <a href="{{ route('dashboard') }}" class="btn btn-soft">Kembali ke Dashboard</a>
                <a href="{{ route('struk.pdf') }}" class="btn btn-primary">Download PDF</a>
            </div>
        </div>
    </div>
</body>
</html>
