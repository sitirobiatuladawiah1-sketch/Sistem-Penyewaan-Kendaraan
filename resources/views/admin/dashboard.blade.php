<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYA RENTAL - Admin Dashboard</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --primary: #1f4fd7;
            --primary-soft: #dbe7ff;
            --success: #16a34a;
            --warning: #d97706;
            --danger: #dc2626;
            --border: #e5e7eb;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%);
            color: var(--text);
        }
        .wrap {
            max-width: 1480px;
            margin: 0 auto;
            padding: 28px;
        }
        .hero {
            background: linear-gradient(135deg, #143c8f 0%, #2757d6 60%, #3d76ff 100%);
            color: #fff;
            border-radius: 26px;
            padding: 28px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
            box-shadow: 0 24px 60px rgba(31, 79, 215, 0.22);
        }
        .hero h1, .hero p { margin: 0; }
        .hero p { opacity: 0.85; margin-top: 8px; }
        .top-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .btn {
            border: 0;
            border-radius: 12px;
            padding: 11px 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .btn-light { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.25); }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-danger { background: var(--danger); color: #fff; }
        .btn-soft { background: var(--primary-soft); color: #153c94; }
        .grid-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin: 22px 0;
        }
        .stat {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }
        .stat small { color: var(--muted); display: block; margin-bottom: 8px; }
        .stat strong { font-size: 30px; display: block; }
        .grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 18px;
            margin-top: 18px;
        }
        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.04);
        }
        .panel h2 { margin: 0 0 14px 0; font-size: 20px; }
        .panel p.sub { margin-top: -6px; color: var(--muted); }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }
        .field { display: flex; flex-direction: column; gap: 6px; }
        .field label { font-size: 13px; color: var(--muted); font-weight: 700; }
        .field input, .field select, .field textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 12px;
            font-size: 14px;
            background: #fff;
        }
        .field textarea { min-height: 88px; resize: vertical; }
        .field.full { grid-column: 1 / -1; }
        .section {
            margin-top: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            vertical-align: top;
            font-size: 14px;
        }
        th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .table-wrap { overflow-x: auto; }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge.success { background: #dcfce7; color: #166534; }
        .badge.warning { background: #fef3c7; color: #92400e; }
        .badge.danger { background: #fee2e2; color: #991b1b; }
        .badge.gray { background: #e5e7eb; color: #374151; }
        .row-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: flex-start;
        }
        .delete-trigger { min-width: 92px; }
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            z-index: 50;
        }
        .modal-backdrop.active { display: flex; }
        .modal {
            width: min(520px, 100%);
            background: #fff;
            border-radius: 24px;
            padding: 20px;
            border: 1px solid var(--border);
            box-shadow: 0 25px 70px rgba(15, 23, 42, 0.2);
        }
        .modal h3 { margin: 0 0 8px; }
        .modal p { margin: 0 0 14px; color: var(--muted); }
        .modal-grid { display: grid; gap: 10px; }
        .modal-grid input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 11px 12px;
            font-size: 14px;
        }
        .modal-actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 14px; }
        .vehicle-name { color: #143c8f; font-weight: 700; }
        .hidden { display: none; }
        .table-note { color: var(--muted); font-size: 12px; margin-top: 8px; }
        .mini-form { display:flex; gap:8px; flex-wrap:wrap; align-items:center; margin-top:8px; }
        .mini-form input, .mini-form select { width:auto; min-width:130px; }
        .qr-mini { width:92px; height:92px; padding:4px; background:#fff; border:1px solid var(--border); border-radius:10px; }
        .qr-mini svg { width:100%; height:100%; display:block; }
        .admin-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 14px;
            align-items: stretch;
        }
        .admin-transaction-card {
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fff;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 100%;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.05);
        }
        .admin-transaction-head {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }
        .admin-transaction-head h3 {
            margin: 0 0 4px;
            font-size: 18px;
            color: #143c8f;
        }
        .admin-transaction-code {
            text-align: right;
            min-width: 92px;
        }
        .admin-transaction-code strong {
            font-size: 12px;
            color: var(--muted);
            overflow-wrap: anywhere;
        }
        .admin-transaction-rows {
            display: grid;
            gap: 8px;
        }
        .info-row {
            display: grid;
            grid-template-columns: 112px minmax(0, 1fr);
            gap: 10px;
            align-items: start;
        }
        .info-row span {
            color: var(--muted);
            font-size: 13px;
        }
        .info-row strong,
        .info-row div {
            min-width: 0;
            overflow-wrap: anywhere;
        }
        .status-line {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }
        .card-form-row {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }
        .card-form-row form {
            margin: 0;
        }
        .card-form-row select,
        .card-form-row input {
            width: 100%;
        }
        .mobile-only-break { display: none; }
        @media (max-width: 980px) {
            .row-actions { flex-direction: column; }
            .delete-trigger, .row-actions .btn, .row-actions select { width: 100%; }
        }
        @media (max-width: 760px) {
            .table-note { display: block; }
            .mobile-only-break { display: inline; }
        }
        .alert {
            border-radius: 14px;
            padding: 14px 16px;
            margin-top: 18px;
            font-weight: 700;
        }
        .alert.success { background: #dcfce7; color: #166534; }
        .alert.error { background: #fee2e2; color: #991b1b; }
        .spacer { height: 16px; }
        @media (max-width: 1100px) {
            .grid, .grid-stats { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 760px) {
            .wrap { padding: 14px; }
            .hero, .grid { grid-template-columns: 1fr; display: grid; }
            .grid-stats, .form-grid { grid-template-columns: 1fr; }
            .hero { padding: 20px; }
            .admin-transaction-head { flex-direction: column; }
            .admin-transaction-code { text-align: left; }
            .info-row { grid-template-columns: 1fr; gap: 2px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="wrap">
        <div class="hero">
            <div>
                <h1>Dashboard Admin</h1>
                <p>Kelola pengguna, transaksi, kendaraan, dan status service dari satu halaman.</p>
            </div>
            <div class="top-actions">
                <a class="btn btn-light" href="{{ route('dashboard') }}">Lihat Dashboard User</a>
                <a class="btn btn-light" href="{{ route('admin.pengembalian') }}">Pengembalian Mobil</a>
                <a class="btn btn-light" href="{{ route('admin.riwayat-transaksi') }}">Riwayat Transaksi</a>
                <a class="btn btn-light" href="{{ route('admin.riwayat-perbaikan') }}">Riwayat Perbaikan</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger" type="submit">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert error">{{ session('error') }}</div>
        @endif

        <div class="grid-stats">
            <div class="stat">
                <small>Total Pengguna</small>
                <strong>{{ $statistik['total_pengguna'] }}</strong>
            </div>
            <div class="stat">
                <small>Total Transaksi</small>
                <strong>{{ $statistik['total_transaksi'] }}</strong>
            </div>
            <div class="stat">
                <small>Total Kendaraan</small>
                <strong>{{ $statistik['total_kendaraan'] }}</strong>
            </div>
            <div class="stat">
                <small>Kendaraan Service</small>
                <strong>{{ $statistik['kendaraan_service'] }}</strong>
            </div>
            <div class="stat">
                <small>Titik Pengambilan</small>
                <strong>{{ $statistik['total_titik'] }}</strong>
            </div>
        </div>

        <div class="grid">
            <div class="panel">
                <h2>Tambah Kendaraan Baru</h2>
                <p class="sub">Tambah unit baru lalu tentukan apakah normal atau sedang service.</p>
                <form action="{{ route('admin.kendaraan.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="field full">
                            <label>Nama Kendaraan</label>
                            <input type="text" name="nama_kendaraan" placeholder="Contoh: Toyota Innova Zenix" required>
                        </div>
                        <div class="field full">
                            <label>Image URL</label>
                            <input type="url" name="image_url" placeholder="https://...">
                        </div>
                        <div class="field">
                            <label>Jenis</label>
                            <input type="text" name="jenis" placeholder="Contoh: MPV" required>
                        </div>
                        <div class="field">
                            <label>Tahun</label>
                            <input type="text" name="tahun" placeholder="Contoh: 2025" required>
                        </div>
                        <div class="field">
                            <label>Plat Nomor</label>
                            <input type="text" name="plat_nomor" placeholder="Contoh: B 1234 JYA" required>
                        </div>
                        <div class="field">
                            <label>No BPKB</label>
                            <input type="text" name="no_bpkb" placeholder="Nomor BPKB" required>
                        </div>
                        <div class="field">
                            <label>Pajak Berlaku Sampai</label>
                            <input type="date" name="pajak_berlaku_sampai" required>
                        </div>
                        <div class="field">
                            <label>Status Pajak</label>
                            <select name="status_pajak" required>
                                <option value="Belum Bayar">Belum Bayar</option>
                                <option value="Sudah Bayar">Sudah Bayar</option>
                            </select>
                            <small class="table-note">Kalau pajak sudah dibayar, pilih Sudah Bayar lalu isi tanggal bayar pajak di bawah.</small>
                        </div>
                        <div class="field">
                            <label>Tanggal Bayar Pajak</label>
                            <input type="date" name="tanggal_bayar_pajak">
                            <small class="table-note">Tanggal ini menjadi riwayat pembayaran pajak terakhir kendaraan.</small>
                        </div>
                        <div class="field">
                            <label>Harga per Hari</label>
                            <input type="number" name="harga_per_hari" min="0" placeholder="Contoh: 750000" required>
                        </div>
                        <div class="field">
                            <label>Jumlah Unit</label>
                            <input type="number" name="jumlah_unit" min="1" value="1" required>
                        </div>
                        <div class="field">
                            <label>Unit Tersedia</label>
                            <input type="number" name="unit_tersedia" min="0" value="1" required>
                        </div>
                        <div class="field">
                            <label>Status Sewa</label>
                            <select name="status" required>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Disewa">Disewa</option>
                            </select>
                        </div>
                        <div class="field full">
                            <label>Status Operasional</label>
                            <select name="status_operasional" required>
                                <option value="Normal">Normal</option>
                                <option value="Service">Service</option>
                            </select>
                        </div>
                    </div>
                    <div class="spacer"></div>
                    <button class="btn btn-primary" type="submit">Simpan Kendaraan</button>
                </form>
            </div>

            <div class="panel">
                <h2>Data Pengguna</h2>
                <p class="sub">Daftar akun yang terdaftar di sistem.</p>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->isAdmin() ? 'warning' : 'gray' }}">{{ $user->role ?? 'user' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="section panel">
            <h2>Data Kendaraan</h2>
            <p class="sub">Ubah status operasional jadi service, atau hapus unit yang belum pernah dipakai transaksi.</p>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Tahun</th>
                            <th>Plat/BPKB</th>
                            <th>Pajak</th>
                            <th>Harga/Hari</th>
                            <th>Unit</th>
                            <th>Status Sewa</th>
                            <th>Status Operasional</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kendaraan as $item)
                            <tr>
                                <td>
                                    <div style="width:72px; height:48px; border-radius:10px; overflow:hidden; background:#dbeafe; display:flex; align-items:center; justify-content:center;">
                                        @if($item->image_url)
                                            <img src="{{ $item->image_url }}" alt="{{ $item->nama_kendaraan }}" style="width:100%; height:100%; object-fit:cover;">
                                        @else
                                            CAR
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->nama_kendaraan }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->tahun }}</td>
                                <td>
                                    {{ $item->plat_nomor ?? '-' }}<br>
                                    <small>{{ $item->no_bpkb ?? '-' }}</small>
                                </td>
                                <td>
                                    Berlaku: {{ $item->pajak_berlaku_sampai ?? '-' }}<br>
                                    <span class="badge {{ ($item->status_pajak ?? 'Belum Bayar') === 'Sudah Bayar' ? 'success' : 'warning' }}">{{ $item->status_pajak ?? 'Belum Bayar' }}</span><br>
                                    <small>Bayar: {{ $item->tanggal_bayar_pajak ?? '-' }}</small>
                                </td>
                                <td>Rp {{ number_format($item->harga_per_hari, 0, ',', '.') }}</td>
                                <td>{{ $item->unit_tersedia }} / {{ $item->jumlah_unit }}</td>
                                <td>
                                    @if($item->status === 'Disewa')
                                        <a href="#riwayat-transaksi" class="badge danger" style="text-decoration:none;">{{ $item->status }}</a>
                                    @else
                                        <span class="badge success">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->status_operasional === 'Service' ? 'warning' : 'gray' }}">{{ $item->status_operasional ?? 'Normal' }}</span>
                                    @php
                                        $lastService = $item->serviceHistories->sortByDesc('tanggal_service')->first();
                                    @endphp
                                    @if(($item->status_operasional ?? 'Normal') === 'Service' && $lastService)
                                        <br><small>Bengkel: {{ $lastService->nama_bengkel ?? '-' }}</small>
                                        <br><small>Kerusakan: {{ $lastService->kerusakan ?? '-' }}</small>
                                        <br><small>Perbaikan: {{ $lastService->perbaikan ?? '-' }}</small>
                                        <br><small>Biaya: Rp {{ number_format($lastService->biaya, 0, ',', '.') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a class="btn btn-soft" href="{{ route('admin.kendaraan.edit', $item->id) }}">Edit</a>
                                        <form action="{{ route('admin.kendaraan.status', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_operasional" onchange="this.form.submit()">
                                                <option value="Normal" @selected(($item->status_operasional ?? 'Normal') === 'Normal')>Normal</option>
                                                <option value="Service" @selected(($item->status_operasional ?? 'Normal') === 'Service')>Service</option>
                                            </select>
                                        </form>

                                        <button
                                            type="button"
                                            class="btn btn-danger delete-trigger"
                                            data-delete-action="{{ route('admin.kendaraan.destroy', $item->id) }}"
                                            data-delete-name="{{ $item->nama_kendaraan }}"
                                        >
                                            Hapus
                                        </button>
                                        <form action="{{ route('admin.kendaraan.service.store', $item->id) }}" method="POST" class="mini-form">
                                            @csrf
                                            <input type="date" name="tanggal_service" value="{{ now()->toDateString() }}" required>
                                            <input type="text" name="nama_bengkel" placeholder="Nama bengkel" required>
                                            <input type="text" name="jenis_service" placeholder="Jenis service" required>
                                            <input type="text" name="kerusakan" placeholder="Kerusakan" required>
                                            <input type="text" name="perbaikan" placeholder="Perbaikan" required>
                                            <input type="number" name="biaya" min="0" placeholder="Biaya">
                                            <input type="text" name="catatan" placeholder="Catatan">
                                            <button class="btn btn-soft" type="submit">Tambah Service</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section panel" id="riwayat-transaksi">
            <h2>Riwayat Transaksi</h2>
            <p class="sub">Semua transaksi pelanggan beserta kendaraan yang dipakai. Status mobil Disewa di tabel kendaraan akan mengarah ke bagian ini.</p>
            <div class="admin-card-grid">
                @forelse($transaksi as $item)
                    <article class="admin-transaction-card">
                        <div class="admin-transaction-head">
                            <div>
                                <h3>{{ $item->user?->name ?? '-' }}</h3>
                                <small>{{ $item->user?->email ?? '-' }}</small>
                            </div>
                            <div class="admin-transaction-code">
                                <strong>{{ $item->booking_code ?? '-' }}</strong>
                                <div class="qr-mini">{!! $item->qr_svg !!}</div>
                            </div>
                        </div>

                        <div class="admin-transaction-rows">
                            <div class="info-row"><span>Kendaraan</span><strong>{{ $item->kendaraan?->nama_kendaraan ?? '-' }}</strong></div>
                            <div class="info-row"><span>Tanggal Sewa</span><strong>{{ $item->tanggal_mulai }}</strong></div>
                            <div class="info-row"><span>Tanggal Pengembalian</span><strong>{{ $item->tanggal_selesai }}</strong></div>
                            <div class="info-row"><span>Tanggal Dikembalikan</span><strong>{{ $item->tanggal_pengembalian ?? 'Belum dikembalikan' }}</strong></div>
                            <div class="info-row"><span>Expired</span><strong>{{ $item->booking_expires_at?->format('d-m-Y H:i') ?? '-' }}</strong></div>
                            <div class="info-row"><span>NIK</span><strong>{{ $item->nik_pelanggan ?? '-' }}</strong></div>
                            <div class="info-row">
                                <span>KTP</span>
                                <div>
                                    @if($item->foto_ktp_path)
                                        <a href="{{ asset('storage/' . $item->foto_ktp_path) }}" target="_blank">Lihat KTP</a>
                                    @else
                                        <small>KTP belum ada</small>
                                    @endif
                                </div>
                            </div>
                            <div class="info-row"><span>Total</span><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></div>
                            <div class="info-row"><span>Bayar</span><strong>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</strong></div>
                            <div class="info-row"><span>Kurang</span><strong>Rp {{ number_format($item->kurang_bayar, 0, ',', '.') }}</strong></div>
                            <div class="info-row"><span>Denda</span><strong>Rp {{ number_format($item->denda_keterlambatan, 0, ',', '.') }}</strong></div>
                            <div class="info-row"><span>Metode</span><strong>{{ $item->metode_pembayaran }}</strong></div>
                            <div class="status-line">
                                <span class="badge {{ $item->status_sewa === 'Selesai' ? 'success' : 'warning' }}">{{ $item->status_sewa }}</span>
                                @if($item->kurang_bayar > 0)
                                    <span class="badge danger">Kurang bayar</span>
                                @elseif(($item->status_pembayaran ?? '') === 'Lunas')
                                    <span class="badge success">Lunas</span>
                                @else
                                    <span class="badge warning">{{ $item->status_pembayaran ?? 'Menunggu Konfirmasi' }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-form-row">
                            <form action="{{ route('admin.transaksi.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label>Status Pembayaran</label>
                                <select name="status_pembayaran" onchange="this.form.submit()">
                                    <option value="Menunggu Konfirmasi" @selected(($item->status_pembayaran ?? 'Menunggu Konfirmasi') === 'Menunggu Konfirmasi')>Menunggu Konfirmasi</option>
                                    <option value="Lunas" @selected($item->status_pembayaran === 'Lunas')>Lunas</option>
                                    <option value="Kurang Bayar" @selected($item->status_pembayaran === 'Kurang Bayar')>Kurang Bayar</option>
                                    <option value="Ditolak" @selected($item->status_pembayaran === 'Ditolak')>Ditolak</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.transaksi.status', $item->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label>Status Sewa</label>
                                <select name="status_sewa" onchange="this.form.submit()">
                                    <option value="Pending" @selected($item->status_sewa === 'Pending')>Pending</option>
                                    <option value="Selesai" @selected($item->status_sewa === 'Selesai')>Selesai</option>
                                    <option value="Dikembalikan" @selected($item->status_sewa === 'Dikembalikan')>Dikembalikan</option>
                                    <option value="Expired" @selected($item->status_sewa === 'Expired')>Expired</option>
                                </select>
                            </form>
                            <form action="{{ route('admin.transaksi.return', $item->id) }}" method="POST" class="mini-form">
                                @csrf
                                @method('PATCH')
                                <input type="date" name="tanggal_pengembalian" value="{{ now()->toDateString() }}" required>
                                <button class="btn btn-primary" type="submit">Kembalikan Mobil</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="admin-transaction-card">
                        <strong>Belum ada transaksi.</strong>
                        <small class="table-note">Transaksi pelanggan akan muncul di sini.</small>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="section panel">
            <h2>Riwayat Service</h2>
            <p class="sub">Catatan service kendaraan yang pernah ditambahkan admin.</p>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Bengkel</th>
                            <th>Jenis Service</th>
                            <th>Kerusakan</th>
                            <th>Perbaikan</th>
                            <th>Catatan</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceHistories as $history)
                            <tr>
                                <td>{{ $history->tanggal_service }}</td>
                                <td>{{ $history->kendaraan?->nama_kendaraan ?? '-' }}</td>
                                <td>{{ $history->nama_bengkel ?? '-' }}</td>
                                <td>{{ $history->jenis_service }}</td>
                                <td>{{ $history->kerusakan ?? '-' }}</td>
                                <td>{{ $history->perbaikan ?? '-' }}</td>
                                <td>{{ $history->catatan ?? '-' }}</td>
                                <td>Rp {{ number_format($history->biaya, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada riwayat service.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section panel">
            <h2>Titik Lokasi Pengambilan</h2>
            <p class="sub">Tambahkan titik pengambilan yang akan tampil di form sewa pengguna.</p>
            <form action="{{ route('admin.pickup-point.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="field full">
                        <label>Nama Titik</label>
                        <input type="text" name="nama_titik" placeholder="Contoh: Stasiun Bogor" required>
                    </div>
                    <div class="field full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" placeholder="Contoh: Jl. Merdeka No. 1, Bogor" required>
                    </div>
                    <div class="field">
                        <label>Latitude (opsional)</label>
                        <input type="text" name="latitude" placeholder="-6.5971">
                    </div>
                    <div class="field">
                        <label>Longitude (opsional)</label>
                        <input type="text" name="longitude" placeholder="106.8060">
                    </div>
                    <div class="field full">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" min="0" value="0">
                    </div>
                </div>
                <div class="spacer"></div>
                <button class="btn btn-primary" type="submit">Tambah Titik</button>
            </form>

            <div class="spacer"></div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Titik</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pickupPoints as $point)
                            <tr>
                                <td>{{ $point->nama_titik }}</td>
                                <td>{{ $point->alamat }}</td>
                                <td>{{ $point->latitude ?? '-' }}, {{ $point->longitude ?? '-' }}</td>
                                <td>
                                    <div class="row-actions">
                                        <a class="btn btn-soft" href="{{ route('admin.pickup-point.edit', $point->id) }}">Edit</a>
                                        <form action="{{ route('admin.pickup-point.destroy', $point->id) }}" method="POST" onsubmit="return confirm('Hapus titik lokasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-backdrop" id="deleteModalBackdrop" aria-hidden="true">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
            <h3 id="deleteModalTitle">Konfirmasi Hapus Kendaraan</h3>
            <p>
                Kendaraan: <span class="vehicle-name" id="deleteVehicleName"></span><br>
                Masukkan email dan password admin untuk melanjutkan penghapusan.
            </p>

            <form id="deleteVehicleForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-grid">
                    <input type="email" name="admin_email" placeholder="Email admin" required>
                    <input type="password" name="admin_password" placeholder="Password admin" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-soft" id="cancelDeleteButton">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Sekarang</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const deleteModalBackdrop = document.getElementById('deleteModalBackdrop');
        const deleteVehicleForm = document.getElementById('deleteVehicleForm');
        const deleteVehicleName = document.getElementById('deleteVehicleName');
        const cancelDeleteButton = document.getElementById('cancelDeleteButton');

        document.querySelectorAll('[data-delete-action]').forEach((button) => {
            button.addEventListener('click', () => {
                deleteVehicleForm.action = button.dataset.deleteAction;
                deleteVehicleName.textContent = button.dataset.deleteName;
                deleteModalBackdrop.classList.add('active');
                deleteModalBackdrop.setAttribute('aria-hidden', 'false');
            });
        });

        function closeDeleteModal() {
            deleteModalBackdrop.classList.remove('active');
            deleteModalBackdrop.setAttribute('aria-hidden', 'true');
            deleteVehicleForm.reset();
        }

        cancelDeleteButton.addEventListener('click', closeDeleteModal);
        deleteModalBackdrop.addEventListener('click', (event) => {
            if (event.target === deleteModalBackdrop) {
                closeDeleteModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && deleteModalBackdrop.classList.contains('active')) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>
