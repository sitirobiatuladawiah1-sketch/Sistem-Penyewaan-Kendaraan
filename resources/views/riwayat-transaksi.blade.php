<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi | Jaya Rental</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width:1180px; margin:0 auto; padding:24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .panel { margin-top:18px; }
        .btn { text-decoration:none; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; line-height:1.45; }
        .badge { display:inline-flex; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; }
        .success { background:#dcfce7; color:#166534; }
        .warning { background:#fef3c7; color:#92400e; }
        .fine-detail { display:grid; gap:4px; min-width:190px; }
        .fine-detail small { color:#6b7280; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Riwayat Transaksi</h1>
            <p style="margin:6px 0 0; opacity:.85;">Semua transaksi penyewaan kendaraan Anda.</p>
        </div>
        <a class="btn btn-soft" href="{{ route('dashboard') }}">Dashboard</a>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kendaraan</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Tanggal Dikembalikan</th>
                        <th>Total Pembayaran</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatSewa as $item)
                        <tr>
                            <td>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}<br><small>{{ $item->kendaraan?->plat_nomor ?? '-' }}</small></td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>{{ $item->tanggal_pengembalian ?? 'Belum dikembalikan' }}</td>
                            <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <div class="fine-detail">
                                    <small>Keterlambatan: Rp {{ number_format($item->denda_keterlambatan, 0, ',', '.') }}</small>
                                    <small>Kerusakan: Rp {{ number_format($item->denda_kerusakan, 0, ',', '.') }}</small>
                                    <small>Kehilangan: Rp {{ number_format($item->denda_kehilangan, 0, ',', '.') }}</small>
                                    <strong>Total: Rp {{ number_format($item->total_denda, 0, ',', '.') }}</strong>
                                    @if($item->status_denda)
                                        <small>Status: {{ $item->status_denda }}</small>
                                    @endif
                                </div>
                            </td>
                            <td><span class="badge {{ $item->status_sewa === 'Selesai' ? 'success' : 'warning' }}">{{ $item->status_sewa }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
