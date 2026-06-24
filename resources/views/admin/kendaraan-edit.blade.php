<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kendaraan | Jaya Rental</title>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing:border-box; }
        body { margin:0; font-family: Arial, sans-serif; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); color:var(--text); }
        .page { min-height:100vh; padding:24px; display:grid; place-items:center; }
        .card { width:min(840px, 100%); background:var(--panel); border:1px solid var(--border); border-radius:26px; padding:24px; box-shadow: 0 18px 50px rgba(15,23,42,0.08); }
        h1 { margin:0 0 8px; color:#143c8f; }
        .muted { color:var(--muted); }
        .grid { display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:12px; margin-top:18px; }
        .field { display:flex; flex-direction:column; gap:6px; }
        .field.full { grid-column: 1 / -1; }
        label { font-size:13px; font-weight:700; color:var(--muted); }
        input, select { width:100%; border:1px solid var(--border); border-radius:12px; padding:11px 12px; font-size:14px; }
        .btn-row { display:flex; gap:12px; margin-top:18px; flex-wrap:wrap; }
        .btn { padding:13px 16px; border-radius:12px; border:none; text-decoration:none; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; }
        .btn-primary { background:var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        .alert { margin-top:14px; padding:12px 14px; border-radius:14px; background:#fee2e2; color:#991b1b; font-weight:700; }
        @media (max-width: 700px) { .grid { grid-template-columns: 1fr; } }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>
    <div class="page">
        <div class="card">
            <h1>Edit Kendaraan</h1>
            <div class="muted">Ubah data kendaraan dan status operasional.</div>

            @if($errors->any())
                <div class="alert">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid">
                    <div class="field full">
                        <label>Nama Kendaraan</label>
                        <input type="text" name="nama_kendaraan" value="{{ old('nama_kendaraan', $kendaraan->nama_kendaraan) }}" required>
                    </div>
                    <div class="field full">
                        <label>Image URL</label>
                        <input type="url" name="image_url" value="{{ old('image_url', $kendaraan->image_url) }}" placeholder="https://...">
                    </div>
                    <div class="field">
                        <label>Jenis</label>
                        <input type="text" name="jenis" value="{{ old('jenis', $kendaraan->jenis) }}" required>
                    </div>
                    <div class="field">
                        <label>Tahun</label>
                        <input type="text" name="tahun" value="{{ old('tahun', $kendaraan->tahun) }}" required>
                    </div>
                    <div class="field">
                        <label>Plat Nomor</label>
                        <input type="text" name="plat_nomor" value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}" required>
                    </div>
                    <div class="field">
                        <label>No BPKB</label>
                        <input type="text" name="no_bpkb" value="{{ old('no_bpkb', $kendaraan->no_bpkb) }}" required>
                    </div>
                    <div class="field">
                        <label>Pajak Berlaku Sampai</label>
                        <input type="date" name="pajak_berlaku_sampai" value="{{ old('pajak_berlaku_sampai', $kendaraan->pajak_berlaku_sampai) }}" required>
                    </div>
                    <div class="field">
                        <label>Status Pajak</label>
                        <select name="status_pajak" required>
                            <option value="Belum Bayar" @selected(old('status_pajak', $kendaraan->status_pajak ?? 'Belum Bayar') === 'Belum Bayar')>Belum Bayar</option>
                            <option value="Sudah Bayar" @selected(old('status_pajak', $kendaraan->status_pajak ?? 'Belum Bayar') === 'Sudah Bayar')>Sudah Bayar</option>
                        </select>
                        <small class="muted">Pilih Sudah Bayar kalau pajak kendaraan sudah dibayar.</small>
                    </div>
                    <div class="field">
                        <label>Tanggal Bayar Pajak</label>
                        <input type="date" name="tanggal_bayar_pajak" value="{{ old('tanggal_bayar_pajak', $kendaraan->tanggal_bayar_pajak) }}">
                        <small class="muted">Isi tanggal pembayaran pajak terakhir sebagai riwayat pajak.</small>
                    </div>
                    <div class="field">
                        <label>Harga per Hari</label>
                        <input type="number" name="harga_per_hari" value="{{ old('harga_per_hari', $kendaraan->harga_per_hari) }}" required>
                    </div>
                    <div class="field">
                        <label>Jumlah Unit</label>
                        <input type="number" name="jumlah_unit" min="1" value="{{ old('jumlah_unit', $kendaraan->jumlah_unit) }}" required>
                    </div>
                    <div class="field">
                        <label>Unit Tersedia</label>
                        <input type="number" name="unit_tersedia" min="0" value="{{ old('unit_tersedia', $kendaraan->unit_tersedia) }}" required>
                    </div>
                    <div class="field">
                        <label>Status Sewa</label>
                        <select name="status" required>
                            <option value="Tersedia" @selected(old('status', $kendaraan->status) === 'Tersedia')>Tersedia</option>
                            <option value="Disewa" @selected(old('status', $kendaraan->status) === 'Disewa')>Disewa</option>
                        </select>
                    </div>
                    <div class="field full">
                        <label>Status Operasional</label>
                        <select name="status_operasional" required>
                            <option value="Normal" @selected(old('status_operasional', $kendaraan->status_operasional ?? 'Normal') === 'Normal')>Normal</option>
                            <option value="Service" @selected(old('status_operasional', $kendaraan->status_operasional ?? 'Normal') === 'Service')>Service</option>
                        </select>
                    </div>
                </div>

                <div class="btn-row">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-soft">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
