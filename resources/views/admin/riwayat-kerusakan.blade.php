<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kerusakan Kendaraan | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width:1320px; margin:0 auto; padding:24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .top-actions { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .panel { margin-top:18px; }
        .btn { text-decoration:none; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; line-height:1.45; }
        th { color:#344054; font-size:13px; white-space:nowrap; }
        .detail-list { display:grid; gap:5px; min-width:220px; }
        .detail-list small { color:#6b7280; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Riwayat Kerusakan Kendaraan</h1>
            <p style="margin:6px 0 0; opacity:.85;">Catatan kerusakan dan kehilangan yang muncul saat pengembalian kendaraan.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.pengembalian') }}">Pengembalian Mobil</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-kondisi') }}">Riwayat Kondisi</a>
        </div>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Kerusakan</th>
                        <th>Kehilangan</th>
                        <th>Total Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKerusakan as $item)
                        <tr>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>{{ $item->user?->name ?? '-' }}</td>
                            <td>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}<br><small>{{ $item->kendaraan?->plat_nomor ?? '-' }}</small></td>
                            <td>
                                <div class="detail-list">
                                    @forelse(($item->detail_kerusakan ?? []) as $detail)
                                        <small>{{ $detail['jenis'] ?? '-' }} - {{ $detail['deskripsi'] ?? '-' }}</small>
                                        <strong>Rp {{ number_format($detail['biaya'] ?? 0, 0, ',', '.') }}</strong>
                                    @empty
                                        <small>Tidak ada kerusakan.</small>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                <div class="detail-list">
                                    @forelse(($item->detail_kehilangan ?? []) as $detail)
                                        <small>{{ $detail['barang'] ?? '-' }}</small>
                                        <strong>Rp {{ number_format($detail['biaya'] ?? 0, 0, ',', '.') }}</strong>
                                    @empty
                                        <small>Tidak ada kehilangan.</small>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                Kerusakan: Rp {{ number_format($item->denda_kerusakan, 0, ',', '.') }}<br>
                                Kehilangan: Rp {{ number_format($item->denda_kehilangan, 0, ',', '.') }}<br>
                                <strong>Rp {{ number_format($item->denda_kerusakan + $item->denda_kehilangan, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Belum ada riwayat kerusakan atau kehilangan kendaraan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
