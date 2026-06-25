<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width: 1320px; margin: 0 auto; padding: 24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .panel { margin-top:18px; }
        .top-actions { display:flex; gap:10px; flex-wrap:wrap; }
        .btn { text-decoration:none; }
        .transaction-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:14px; align-items:stretch; }
        .transaction-card { background:#fff; border:1px solid #e4e9f2; border-radius:14px; padding:16px; box-shadow:0 10px 26px rgba(15,23,42,.05); display:flex; flex-direction:column; gap:12px; min-height:100%; }
        .transaction-card h3 { margin:0 0 4px; font-size:18px; color:#143c8f; overflow-wrap:anywhere; }
        .transaction-head { padding-bottom:12px; border-bottom:1px solid #eef2f7; }
        .transaction-row { display:grid; grid-template-columns:112px minmax(0,1fr); gap:10px; border-top:1px solid #eef2f7; padding-top:10px; align-items:start; }
        .transaction-row span { color:#667085; font-size:13px; }
        .transaction-row strong { text-align:right; overflow-wrap:anywhere; min-width:0; }
        .payment-line { display:flex; flex-wrap:wrap; gap:6px; align-items:center; }
        .fine-detail { display:grid; gap:4px; text-align:right; }
        .fine-detail small { color:#667085; }
        .badge { display:inline-flex; padding:6px 10px; border-radius:999px; font-size:12px; font-weight:700; }
        .success { background:#dcfce7; color:#166534; }
        .warning { background:#fef3c7; color:#92400e; }
        .danger { background:#fee2e2; color:#991b1b; }
        .fine-action { margin-top:auto; padding-top:12px; border-top:1px solid #eef2f7; }
        .fine-action form { margin:0; }
        .fine-action .btn { width:100%; justify-content:center; }
        @media (max-width: 640px) {
            .wrap { padding:14px; }
            .transaction-grid { grid-template-columns:1fr; }
            .transaction-row { grid-template-columns:1fr; gap:2px; }
            .transaction-row strong { text-align:left; }
            .fine-detail { text-align:left; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Riwayat Transaksi</h1>
            <p style="margin:6px 0 0; opacity:.85;">Data transaksi lengkap pelanggan dan kendaraan.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.pengembalian') }}">Pengembalian Mobil</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-perbaikan') }}">Riwayat Perbaikan</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-kerusakan') }}">Riwayat Kerusakan</a>
        </div>
    </div>

    <div class="panel">
        <div class="transaction-grid">
            @forelse($transaksi as $item)
                <article class="transaction-card">
                    <div class="transaction-head">
                        <h3>{{ $item->user?->name ?? '-' }}</h3>
                        <small>{{ $item->user?->email ?? '-' }}</small>
                    </div>
                    <div class="transaction-row"><span>Kendaraan</span><strong>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}<br><small>{{ $item->kendaraan?->plat_nomor ?? '-' }}</small></strong></div>
                    <div class="transaction-row"><span>Tanggal Sewa</span><strong>{{ $item->tanggal_mulai }}</strong></div>
                    <div class="transaction-row"><span>Tanggal Pengembalian</span><strong>{{ $item->tanggal_selesai }}</strong></div>
                    <div class="transaction-row"><span>Tanggal Dikembalikan</span><strong>{{ $item->tanggal_pengembalian ?? 'Belum dikembalikan' }}</strong></div>
                    <div class="transaction-row"><span>Total</span><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></div>
                    <div class="transaction-row"><span>Bayar</span><strong>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</strong></div>
                    <div class="transaction-row"><span>Kurang</span><strong>Rp {{ number_format($item->kurang_bayar, 0, ',', '.') }}</strong></div>
                    <div class="transaction-row">
                        <span>Denda</span>
                        <div class="fine-detail">
                            <small>Keterlambatan: Rp {{ number_format($item->denda_keterlambatan, 0, ',', '.') }}</small>
                            <small>Kerusakan: Rp {{ number_format($item->denda_kerusakan, 0, ',', '.') }}</small>
                            <small>Kehilangan: Rp {{ number_format($item->denda_kehilangan, 0, ',', '.') }}</small>
                            <strong>Total: Rp {{ number_format($item->total_denda, 0, ',', '.') }}</strong>
                        </div>
                    </div>
                    <div class="transaction-row"><span>Status Denda</span><strong>{{ $item->status_denda ?? ($item->total_denda > 0 ? 'Belum dibayar' : '-') }}</strong></div>
                    @if($item->detail_kerusakan)
                        <div class="transaction-row">
                            <span>Detail Kerusakan</span>
                            <strong>
                                @foreach($item->detail_kerusakan as $detail)
                                    {{ $detail['jenis'] ?? '-' }} - {{ $detail['deskripsi'] ?? '-' }} (Rp {{ number_format($detail['biaya'] ?? 0, 0, ',', '.') }})<br>
                                @endforeach
                            </strong>
                        </div>
                    @endif
                    @if($item->detail_kehilangan)
                        <div class="transaction-row">
                            <span>Detail Kehilangan</span>
                            <strong>
                                @foreach($item->detail_kehilangan as $detail)
                                    {{ $detail['barang'] ?? '-' }} (Rp {{ number_format($detail['biaya'] ?? 0, 0, ',', '.') }})<br>
                                @endforeach
                            </strong>
                        </div>
                    @endif
                    <div class="transaction-row"><span>Kondisi Ambil</span><strong>{{ $item->kondisi_ambil ?? 'Belum diisi' }}</strong></div>
                    <div class="transaction-row"><span>Kondisi Kembali</span><strong>{{ $item->kondisi_kembali ?? 'Belum diisi' }}</strong></div>
                    <div class="payment-line">
                        <span class="badge {{ $item->status_sewa === 'Selesai' ? 'success' : 'warning' }}">{{ $item->status_sewa }}</span>
                        <span class="badge {{ ($item->status_pembayaran ?? '') === 'Lunas' ? 'success' : (($item->kurang_bayar > 0 || ($item->status_pembayaran ?? '') === 'Kurang Bayar') ? 'danger' : 'warning') }}">{{ $item->status_pembayaran ?? 'Menunggu Konfirmasi' }}</span>
                    </div>
                    @if($item->total_denda > 0 && ! in_array($item->status_denda, ['Dibayar', 'Denda Lunas'], true))
                        <div class="fine-action">
                            <form action="{{ route('admin.transaksi.denda', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi denda user sudah dibayar?');">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-primary" type="submit">Konfirmasi Denda Sudah Dibayar</button>
                            </form>
                        </div>
                    @endif
                </article>
            @empty
                <div class="transaction-card">Belum ada transaksi.</div>
            @endforelse
        </div>
    </div>
</div>
</body>
</html>
