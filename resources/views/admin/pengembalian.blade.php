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
        .schedule-form { display:flex; gap:10px; flex-wrap:wrap; align-items:center; margin-bottom:10px; }
        .btn { text-decoration:none; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:12px; border-bottom:1px solid #e5e7eb; vertical-align:top; }
        input, textarea { min-width:160px; }
        textarea { border:1px solid #e5e7eb; border-radius:12px; padding:11px 12px; font-family:inherit; resize:vertical; }
        .return-form input, .return-form textarea { flex:1 1 180px; }
        .return-form .full-row { flex-basis:100%; }
        .fine-box { background:#f8fbff; border:1px solid #dbe7ff; border-radius:14px; padding:12px; margin:10px 0; }
        .fine-box strong { display:block; margin-bottom:8px; color:#143c8f; }
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
        <p>Denda keterlambatan dihitung per hari: harga sewa 1 hari + 20% dari harga sewa 1 hari. Jika ada kerusakan atau barang hilang, isi detail dan biaya dendanya saat pengembalian.</p>
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
                                <form action="{{ route('admin.transaksi.tanggal-pengembalian', $item->id) }}" method="POST" class="schedule-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="date" name="tanggal_selesai" value="{{ optional($item->tanggal_selesai)->format('Y-m-d') }}" required>
                                    <button class="btn btn-soft" type="submit">Simpan Tanggal Pengembalian</button>
                                </form>
                                <form action="{{ route('admin.transaksi.return', $item->id) }}" method="POST" class="return-form">
                                    @csrf
                                    @method('PATCH')
                                    <input type="date" name="tanggal_pengembalian" value="{{ now()->toDateString() }}" required>
                                    <input type="text" name="kondisi_kembali" placeholder="Kondisi saat kembali" required>
                                    <input type="text" name="catatan_pengembalian" placeholder="Catatan pengembalian" required>
                                    <div class="fine-box full-row">
                                        <strong>Denda Kerusakan</strong>
                                        <div class="return-form">
                                            <input type="text" name="jenis_kerusakan" placeholder="Jenis kerusakan, contoh: Lecet ringan">
                                            <textarea name="deskripsi_kerusakan" rows="2" placeholder="Deskripsi kerusakan"></textarea>
                                            <input type="number" name="denda_kerusakan" min="0" value="0" placeholder="Biaya denda kerusakan">
                                        </div>
                                    </div>
                                    <div class="fine-box full-row">
                                        <strong>Denda Kehilangan</strong>
                                        <div class="return-form">
                                            <input type="text" name="barang_hilang" placeholder="Barang hilang, contoh: STNK / kunci">
                                            <input type="number" name="biaya_kehilangan" min="0" value="0" placeholder="Biaya penggantian">
                                        </div>
                                    </div>
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
