<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil | Jaya Rental</title>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing: border-box; }
        body { margin:0; min-height:100vh; display:grid; place-items:center; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); font-family: Arial, sans-serif; color: var(--text); }
        .card { width:min(720px, calc(100% - 32px)); background:var(--panel); border:1px solid var(--border); border-radius:28px; padding:28px; text-align:center; box-shadow: 0 18px 50px rgba(15,23,42,0.08); }
        .check { width:120px; height:120px; border-radius:50%; background:#dcfce7; color:#166534; display:grid; place-items:center; font-size:60px; margin:0 auto 18px; }
        h1 { margin: 0 0 8px; }
        p { color: var(--muted); line-height: 1.6; }
        .btn-row { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; margin-top: 18px; }
        .btn { padding: 13px 18px; border-radius: 12px; text-decoration:none; font-weight:700; }
        .btn-primary { background: var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        .summary { margin-top:18px; padding:16px; border-radius:18px; background:#f9fbff; border:1px solid var(--border); text-align:left; }
        .summary-row { display:flex; justify-content:space-between; gap:12px; margin-bottom:8px; }
        .notice { margin-top:16px; padding:12px 14px; border-radius:14px; background:#dcfce7; color:#166534; font-weight:700; }
        .qr { width:174px; height:174px; margin:18px auto 0; padding:8px; border:1px solid var(--border); border-radius:18px; background:#fff; }
        .qr svg { width:100%; height:100%; display:block; }
        @media (max-width: 600px) { .summary-row { flex-direction: column; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="card">
        <div class="check">OK</div>
        <h1>Pembayaran Terkirim</h1>
        <p>Pesanan kamu sudah tercatat. Admin akan mengecek nominal yang masuk dan menentukan status pembayaran.</p>
        <div class="notice">{{ session('success') ?? 'Pembayaran dikirim untuk booking ' . $transaksi->booking_code }}</div>
        <div class="qr">{!! $transaksi->qr_svg !!}</div>

        <div class="summary">
            <div class="summary-row"><span>Kode Booking</span><strong>{{ $transaksi->booking_code }}</strong></div>
            <div class="summary-row"><span>Nama Mobil</span><strong>{{ $transaksi->kendaraan?->nama_kendaraan }}</strong></div>
            <div class="summary-row"><span>Total Pembayaran</span><strong>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></div>
            <div class="summary-row"><span>Jumlah Dibayar</span><strong>Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</strong></div>
            <div class="summary-row"><span>Kurang Bayar</span><strong>Rp {{ number_format($transaksi->kurang_bayar, 0, ',', '.') }}</strong></div>
            <div class="summary-row"><span>Status Pembayaran</span><strong>{{ $transaksi->status_pembayaran }}</strong></div>
            <div class="summary-row"><span>Metode</span><strong>{{ $transaksi->metode_pembayaran }}</strong></div>
        </div>

        <div class="btn-row">
            <a class="btn btn-soft" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
            <a class="btn btn-primary" href="{{ route('pembayaran.identitas') }}">Selanjutnya</a>
        </div>
    </div>
</body>
</html>
