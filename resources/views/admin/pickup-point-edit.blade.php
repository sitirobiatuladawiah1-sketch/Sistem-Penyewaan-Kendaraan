<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Titik Pickup | Jaya Rental</title>
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
        input { width:100%; border:1px solid var(--border); border-radius:12px; padding:11px 12px; font-size:14px; }
        .checkbox { display:flex; align-items:center; gap:10px; margin-top:6px; }
        .btn-row { display:flex; gap:12px; margin-top:18px; flex-wrap:wrap; }
        .btn { padding:13px 16px; border-radius:12px; border:none; text-decoration:none; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; }
        .btn-primary { background:var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        .alert { margin-top:14px; padding:12px 14px; border-radius:14px; background:#fee2e2; color:#991b1b; font-weight:700; }
        @media (max-width: 700px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            <h1>Edit Titik Pickup</h1>
            <div class="muted">Ubah nama, alamat, atau koordinat titik pengambilan.</div>

            @if($errors->any())
                <div class="alert">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('admin.pickup-point.update', $pickupPoint->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid">
                    <div class="field full">
                        <label>Nama Titik</label>
                        <input type="text" name="nama_titik" value="{{ old('nama_titik', $pickupPoint->nama_titik) }}" required>
                    </div>
                    <div class="field full">
                        <label>Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $pickupPoint->alamat) }}" required>
                    </div>
                    <div class="field">
                        <label>Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $pickupPoint->latitude) }}">
                    </div>
                    <div class="field">
                        <label>Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $pickupPoint->longitude) }}">
                    </div>
                    <div class="field">
                        <label>Urutan Tampil</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $pickupPoint->sort_order) }}" min="0">
                    </div>
                    <div class="field">
                        <label>Status Aktif</label>
                        <div class="checkbox">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $pickupPoint->is_active))>
                            <span>Aktif</span>
                        </div>
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
