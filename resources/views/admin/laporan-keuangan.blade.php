<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan | Admin</title>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
    <style>
        body { margin:0; }
        .wrap { max-width:1320px; margin:0 auto; padding:24px; }
        .hero { color:#fff; padding:22px; display:flex; justify-content:space-between; gap:14px; align-items:center; }
        .top-actions,.filter-form { display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
        .panel { margin-top:18px; }
        .btn { text-decoration:none; }
        .filter-form input,.filter-form select { min-width:160px; }
        .finance-summary {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap:14px;
            margin-top:18px;
            align-items:stretch;
        }
        .finance-card {
            background:#fff;
            border:1px solid #e4e9f2;
            border-radius:12px;
            padding:18px;
            min-height:124px;
            display:grid;
            grid-template-columns:minmax(0, 1fr) 52px;
            gap:12px;
            align-items:center;
            box-shadow:0 10px 26px rgba(15,23,42,.05);
        }
        .finance-card > div:first-child { min-width:0; }
        .finance-card small {
            display:block;
            color:#667085;
            font-size:13px;
            margin-bottom:8px;
            line-height:1.35;
        }
        .finance-card strong {
            display:block;
            color:#101828;
            font-size:clamp(19px, 2vw, 25px);
            line-height:1.15;
            letter-spacing:0;
            overflow-wrap:anywhere;
        }
        .finance-icon {
            width:52px;
            height:52px;
            border-radius:999px;
            background:#eef5ff;
            color:#143c8f;
            display:grid;
            place-items:center;
            font-weight:800;
        }
        .filter-form {
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            align-items:end;
        }
        .filter-form input,.filter-form select,.filter-form .btn { width:100%; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { text-align:left; padding:14px 12px; border-bottom:1px solid #e5e7eb; vertical-align:middle; line-height:1.45; }
        th { color:#344054; font-size:13px; white-space:nowrap; }
        td:last-child, th:last-child { text-align:right; white-space:nowrap; }
        tfoot td { font-weight:800; background:#f8fbff; }
        @media (min-width:1180px) {
            .finance-summary { grid-template-columns:repeat(4, minmax(0, 1fr)); }
        }
        @media (max-width:620px) {
            .wrap { padding:16px; }
            .hero { flex-direction:column; align-items:flex-start; }
            .top-actions { width:100%; }
            .top-actions .btn { flex:1; }
            .finance-card strong { font-size:20px; }
            td:last-child, th:last-child { text-align:left; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="hero">
        <div>
            <h1 style="margin:0;">Laporan Keuangan</h1>
            <p style="margin:6px 0 0; opacity:.85;">Ringkasan pembayaran sewa dan denda.</p>
        </div>
        <div class="top-actions">
            <a class="btn btn-soft" href="{{ route('admin.dashboard') }}">Dashboard</a>
            <a class="btn btn-soft" href="{{ route('admin.riwayat-transaksi') }}">Riwayat Transaksi</a>
        </div>
    </div>

    <div class="finance-summary">
        <div class="finance-card"><div><small>Total Pembayaran Sewa</small><strong>Rp {{ number_format($summary['total_pembayaran_sewa'], 0, ',', '.') }}</strong></div><div class="finance-icon">SW</div></div>
        <div class="finance-card"><div><small>Total Denda Keterlambatan</small><strong>Rp {{ number_format($summary['total_denda_keterlambatan'], 0, ',', '.') }}</strong></div><div class="finance-icon">DK</div></div>
        <div class="finance-card"><div><small>Total Denda Kerusakan</small><strong>Rp {{ number_format($summary['total_denda_kerusakan'], 0, ',', '.') }}</strong></div><div class="finance-icon">DR</div></div>
        <div class="finance-card"><div><small>Total Denda Kehilangan</small><strong>Rp {{ number_format($summary['total_denda_kehilangan'], 0, ',', '.') }}</strong></div><div class="finance-icon">DH</div></div>
        <div class="finance-card"><div><small>Total Seluruh Denda</small><strong>Rp {{ number_format($summary['total_pembayaran_denda'], 0, ',', '.') }}</strong></div><div class="finance-icon">DN</div></div>
        <div class="finance-card"><div><small>Total Pemasukan</small><strong>Rp {{ number_format($summary['total_pemasukan'], 0, ',', '.') }}</strong></div><div class="finance-icon">Rp</div></div>
        <div class="finance-card"><div><small>Transaksi Lunas</small><strong>{{ $summary['jumlah_transaksi_lunas'] }}</strong></div><div class="finance-icon">OK</div></div>
        <div class="finance-card"><div><small>Transaksi Denda</small><strong>{{ $summary['jumlah_transaksi_denda'] }}</strong></div><div class="finance-icon">TR</div></div>
    </div>

    <div class="panel">
        <form method="GET" class="filter-form">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            <select name="bulan">
                <option value="">Semua Bulan</option>
                @for($month = 1; $month <= 12; $month++)
                    <option value="{{ $month }}" @selected((string) request('bulan') === (string) $month)>Bulan {{ $month }}</option>
                @endfor
            </select>
            <input type="number" name="tahun" value="{{ request('tahun') }}" placeholder="Tahun">
            <button class="btn btn-primary" type="submit">Filter</button>
            <a class="btn btn-soft" href="{{ route('admin.laporan-keuangan') }}">Reset</a>
        </form>
    </div>

    <div class="panel">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Jenis Pembayaran</th>
                        <th>Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $row)
                        <tr>
                            <td>{{ $row['tanggal'] }}</td>
                            <td>{{ $row['pelanggan'] }}</td>
                            <td>{{ $row['kendaraan'] }}</td>
                            <td>{{ $row['jenis'] }}</td>
                            <td>Rp {{ number_format($row['nominal'], 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada data pembayaran sesuai filter.</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">Total</td>
                        <td>Rp {{ number_format($rows->sum('nominal'), 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</body>
</html>
