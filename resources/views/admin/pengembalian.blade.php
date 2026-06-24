<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Mobil | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width: 1180px; margin:0 auto; padding:24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .panel { margin-top:18px; }
        .top-actions,.return-form { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .btn { text-decoration:none; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; }
        input { min-width:160px; }
        .alert { padding:12px 14px; border-radius:12px; margin-top:14px; font-weight:700; }
        .success-alert { background:#dcfce7; color:#166534; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Pengembalian Mobil</h1>
            <p style="margin:6px 0 0; opacity:.85;">Kelola mobil yang sedang disewa dan kembalikan stok otomatis.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-transaksi') }}">Riwayat Transaksi</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert success-alert">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <p>Denda keterlambatan dihitung per hari: harga sewa 1 hari + 20% dari harga sewa 1 hari.</p>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Periode</th>
                        <th>Harga/Hari</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksi as $item)
                        <tr>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}<br><small>{{ $item->kendaraan?->plat_nomor ?? '-' }}</small></td>
                            <td>{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                            <td>Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('admin.transaksi.return', $item->id) }}" method="POST" class="return-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="date" name="tanggal_pengembalian" value="{{ now()->toDateString() }}" required>
                                    <button class="btn btn-primary" type="submit">Kembalikan Mobil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Tidak ada mobil yang sedang disewa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
