<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Perbaikan | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width:1320px; margin:0 auto; padding:24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .panel { margin-top:18px; }
        .top-actions { display:flex; gap:10px; flex-wrap:wrap; }
        .btn { text-decoration:none; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Riwayat Perbaikan</h1>
            <p style="margin:6px 0 0; opacity:.85;">Catatan service, bengkel, kerusakan, tindakan perbaikan, dan biaya.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.pengembalian') }}">Pengembalian Mobil</a>
        </div>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nama Kendaraan</th>
                        <th>Bengkel</th>
                        <th>Kerusakan</th>
                        <th>Perbaikan</th>
                        <th>Biaya</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceHistories as $history)
                        <tr>
                            <td>{{ $history->kendaraan?->nama_kendaraan ?? '-' }}</td>
                            <td>{{ $history->nama_bengkel ?? '-' }}</td>
                            <td>{{ $history->kerusakan ?? '-' }}</td>
                            <td>{{ $history->perbaikan ?? '-' }}</td>
                            <td>Rp {{ number_format($history->biaya, 0, ',', '.') }}</td>
                            <td>{{ $history->tanggal_service }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Belum ada riwayat perbaikan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
