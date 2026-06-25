<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kondisi Kendaraan | Admin</title>
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
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; }
        .fine-detail { display:grid; gap:4px; min-width:180px; }
        .fine-detail small { color:#6b7280; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Riwayat Kondisi Kendaraan</h1>
            <p style="margin:6px 0 0; opacity:.85;">Catatan kondisi kendaraan saat pengambilan dan pengembalian.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.pengembalian') }}">Pengembalian Mobil</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-kerusakan') }}">Riwayat Kerusakan</a>
        </div>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kendaraan</th>
                        <th>Tanggal Ambil</th>
                        <th>Kondisi Saat Ambil</th>
                        <th>Tanggal Kembali</th>
                        <th>Kondisi Saat Kembali</th>
                        <th>Catatan</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKondisi as $item)
                        <tr>
                            <td>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}<br><small>{{ $item->kendaraan?->plat_nomor ?? '-' }}</small></td>
                            <td>{{ $item->tanggal_ambil ?? '-' }}</td>
                            <td>{{ $item->kondisi_ambil ?? '-' }}</td>
                            <td>{{ $item->tanggal_kembali ?? '-' }}</td>
                            <td>{{ $item->kondisi_kembali ?? '-' }}</td>
                            <td>
                                Ambil: {{ $item->catatan_kondisi_ambil ?? '-' }}<br>
                                Kembali: {{ $item->catatan_pengembalian ?? '-' }}
                            </td>
                            <td>
                                <div class="fine-detail">
                                    <small>Keterlambatan: Rp {{ number_format($item->denda_keterlambatan, 0, ',', '.') }}</small>
                                    <small>Kerusakan: Rp {{ number_format($item->denda_kerusakan, 0, ',', '.') }}</small>
                                    <small>Kehilangan: Rp {{ number_format($item->denda_kehilangan, 0, ',', '.') }}</small>
                                    <strong>Total: Rp {{ number_format($item->total_denda, 0, ',', '.') }}</strong>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Belum ada riwayat kondisi kendaraan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
