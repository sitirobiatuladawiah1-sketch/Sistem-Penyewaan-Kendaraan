<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siapkan Identitas | Jaya Rental</title>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing:border-box; }
        body { margin:0; min-height:100vh; display:grid; place-items:center; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); font-family: Arial, sans-serif; color:var(--text); }
        .card { width:min(760px, calc(100% - 32px)); background:var(--panel); border:1px solid var(--border); border-radius:28px; padding:30px; box-shadow: 0 18px 50px rgba(15,23,42,0.08); }
        .title { display:flex; gap:16px; align-items:center; }
        .icon { width:76px; height:76px; border-radius:50%; display:grid; place-items:center; background:#dbeafe; color:#1d4ed8; font-size:36px; flex: 0 0 auto; }
        h1 { margin:0 0 6px; }
        p { color:var(--muted); line-height:1.7; }
        .notice { margin-top:18px; padding:18px; border-radius:18px; background:#eff6ff; border:1px solid #bfdbfe; }
        .btn-row { display:flex; gap:12px; flex-wrap:wrap; margin-top: 20px; }
        .btn { padding:13px 18px; border-radius:12px; text-decoration:none; font-weight:700; }
        .btn-primary { background:var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        @media (max-width: 640px) { .title { flex-direction: column; align-items:flex-start; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="card">
        <div class="title">
            <div class="icon">OK</div>
            <div>
                <h1>Data Booking Sudah Siap</h1>
                <p>Data penyewaan dan identitas sudah tercatat. Lanjutkan untuk melihat bukti booking kendaraan Anda.</p>
            </div>
        </div>

        <div class="notice">
            Tunjukkan bukti booking atau QR booking kepada admin saat pengambilan kendaraan.
        </div>

        <div class="btn-row">
            <a href="{{ route('pembayaran.success') }}" class="btn btn-soft">Kembali</a>
            <a href="{{ route('struk') }}" class="btn btn-primary">Lihat Bukti Booking</a>
        </div>
    </div>
</body>
</html>
