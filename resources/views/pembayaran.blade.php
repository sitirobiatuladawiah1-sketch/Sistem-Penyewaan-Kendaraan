<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran | Jaya Rental</title>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: Arial, sans-serif; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); color:var(--text); }
        .page { min-height: 100vh; padding: 24px; display:grid; place-items:center; }
        .card { width:min(1120px, 100%); background:var(--panel); border:1px solid var(--border); border-radius:26px; padding:24px; box-shadow:0 18px 50px rgba(15,23,42,0.08); }
        .header { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; margin-bottom:18px; }
        .badge { display:inline-flex; padding:6px 10px; border-radius:999px; background:#dbeafe; color:#1d4ed8; font-size:12px; font-weight:700; }
        h2 { margin: 8px 0 6px; color:#143c8f; }
        .layout { display:grid; grid-template-columns: 1fr 1.1fr; gap: 18px; }
        .panel { border:1px solid var(--border); border-radius:20px; padding:18px; background:#f9fbff; }
        .detail-box { background: #fff; padding: 16px; border-radius: 16px; margin: 16px 0; border: 1px solid var(--border); }
        .row { display:flex; justify-content:space-between; gap:12px; margin-bottom:8px; }
        .muted { color: var(--muted); }
        select { width:100%; padding:12px; border:1px solid var(--border); border-radius:12px; margin-bottom:14px; background:#fff; }
        .btn-row { display:flex; gap:12px; flex-wrap: wrap; }
        .btn { width:auto; padding:13px 16px; border:none; border-radius:12px; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; }
        .btn-primary { background: var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        .method-box { border:1px solid var(--border); border-radius:18px; padding:18px; background:#fff; min-height: 320px; }
        .method-head { display:flex; align-items:center; gap:14px; margin-bottom: 14px; }
        .method-icon { width:56px; height:56px; border-radius:18px; display:grid; place-items:center; font-size:28px; background:#dbeafe; color:#1d4ed8; }
        .method-content { display:none; }
        .method-content.active { display:block; }
        .qr-box {
            width: 220px;
            height: 220px;
            border-radius: 22px;
            border: 12px solid #111827;
            background:
                linear-gradient(90deg, #111827 10px, transparent 10px) 0 0/44px 44px,
                linear-gradient(#111827 10px, transparent 10px) 0 0/44px 44px,
                #fff;
            display:grid;
            place-items:center;
            font-weight:700;
            margin: 0 auto;
        }
        .account-box { padding: 16px; border-radius: 18px; background: #eff6ff; border: 1px dashed #93c5fd; }
        .bank-logo { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:12px; background:#fff; margin-right:8px; font-weight:900; }
        .bank-grid { display:grid; gap:10px; }
        .bank-item { display:flex; justify-content:space-between; gap:12px; padding:12px; border-radius:14px; background:#fff; border:1px solid var(--border); }
        .cash-note { font-size:18px; font-weight:700; color:#166534; }
        .method-box p { line-height: 1.55; }
        .alert { border-radius:14px; padding:12px 14px; margin-bottom:14px; font-weight:700; }
        .alert.error { background:#fee2e2; color:#991b1b; }
        .alert.warning { background:#fef3c7; color:#92400e; }
        input { width:100%; padding:12px; border:1px solid var(--border); border-radius:12px; margin-bottom:14px; background:#fff; }
        @media (max-width: 900px) {
            .page { padding: 14px; }
            .card { padding: 18px; border-radius: 22px; }
            .layout { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: stretch; }
            .header a, .btn-row .btn { width: 100%; }
            .method-box { min-height: auto; }
        }
        @media (max-width: 560px) {
            .row { flex-direction: column; gap: 4px; }
            .bank-item { flex-direction: column; align-items: flex-start; }
            .qr-box { width: 180px; height: 180px; }
            .cash-note { font-size: 16px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>

<div class="page">
    <div class="card">
        <div class="header">
            <div>
                <span class="badge">Pembayaran</span>
                <h2>Konfirmasi Pembayaran</h2>
                <div class="muted">Pilih metode, cek instruksi, lalu lanjutkan pembayaran.</div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-soft">Kembali ke Dashboard</a>
        </div>

        <div class="layout">
            <div class="panel">
                @if(session('error'))
                    <div class="alert error">{{ session('error') }}</div>
                @endif
                <div class="alert warning">
                    Batas pembayaran sampai {{ \Carbon\Carbon::parse($data['booking_expires_at'])->format('d-m-Y H:i') }}.
                    Lewat dari waktu itu booking akan expired dan harus booking ulang.
                </div>
                <div class="detail-box">
                    <p style="margin-top:0;"><strong>{{ $mobil->nama_kendaraan }}</strong></p>
                    <div class="row"><span>Nama Mobil</span> <strong>{{ $mobil->nama_kendaraan }}</strong></div>
                    <div class="row"><span>Tipe</span> <strong>{{ $mobil->jenis }}</strong></div>
                    <div class="row"><span>Tahun</span> <strong>{{ $mobil->tahun }}</strong></div>
                    <div class="row"><span>Durasi</span> <strong>{{ $hari }} Hari</strong></div>
                    <div class="row"><span>Tanggal</span> <strong>{{ $data['tanggal_mulai'] }} s/d {{ $data['tanggal_selesai'] }}</strong></div>
                    <div class="row"><span>Lokasi Pengambilan</span> <strong>{{ $pickupPoint?->nama_titik ?? $data['pickup_point_nama'] }}</strong></div>
                    <div class="row"><span>Alamat</span> <strong>{{ $pickupPoint?->alamat ?? $data['pickup_point_alamat'] }}</strong></div>
                    <div class="row"><span>NIK Pelanggan</span> <strong>{{ $data['nik_pelanggan'] }}</strong></div>
                    <div class="row"><span>Booking Expired</span> <strong>{{ \Carbon\Carbon::parse($data['booking_expires_at'])->format('d-m-Y H:i') }}</strong></div>
                    <div class="row" style="font-size: 1.15em; color: #1e3a8a; margin-top: 10px;">
                        <span>Total Bayar</span> <strong>Rp {{ number_format($totalHarga, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <form action="{{ route('pembayaran.proses') }}" method="POST" id="paymentForm">
                    @csrf
                    <label>Pilih Metode Pembayaran</label>
                    <select name="metode_pembayaran" id="metodePembayaran" required>
                        <option value="QRIS">QRIS</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="Cash">Cash</option>
                    </select>
                    <label>Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" id="jumlahBayar" min="0" value="{{ old('jumlah_bayar', $totalHarga) }}" data-total="{{ $totalHarga }}" required>
                    <div class="alert warning" id="kurangBayarNotice" style="display:none;"></div>
                    @error('jumlah_bayar')
                        <div class="alert error">{{ $message }}</div>
                    @enderror

                    <div class="btn-row">
                        <a href="{{ route('dashboard') }}" class="btn btn-soft">Kembali</a>
                        <button type="submit" class="btn btn-primary">Selanjutnya</button>
                    </div>
                </form>
            </div>

            <div class="panel">
                <div class="method-box">
                    <div class="method-content active" data-method="QRIS">
                        <div class="method-head">
                            <div class="method-icon">QR</div>
                            <div>
                                <strong>QRIS</strong><br>
                                <span class="muted">Silahkan scan QR di bawah ini.</span>
                            </div>
                        </div>
                        <div class="qr-box">QR CODE</div>
                        <p style="text-align:center; margin-top:16px;">Silahkan scan QR di bawah ini.</p>
                        <p style="text-align:center; color:#166534; font-weight:700;">Verifikasi kurang dari 10 menit setelah pembayaran berhasil.</p>
                    </div>

                    <div class="method-content" data-method="Transfer Bank">
                        <div class="method-head">
                            <div class="method-icon">TB</div>
                            <div>
                                <strong>Transfer Bank</strong><br>
                                <span class="muted">Bayar ke rekening berikut.</span>
                            </div>
                        </div>
                        <div class="account-box">
                            <div class="bank-grid">
                                <div class="bank-item"><span><span class="bank-logo">B</span>BCA</span><strong>1234567890</strong></div>
                                <div class="bank-item"><span><span class="bank-logo">M</span>Mandiri</span><strong>9876543210</strong></div>
                                <div class="bank-item"><span><span class="bank-logo">B</span>BRI</span><strong>1122334455</strong></div>
                            </div>
                        </div>
                        <p class="muted" style="margin-top:12px;">Bayar pesanan ke nomor rekening di atas sebelum membuat pesanan kembali.</p>
                        <p style="color:#166534; font-weight:700;">Proses verifikasi kurang dari 10 menit setelah pembayaran berhasil.</p>
                    </div>

                    <div class="method-content" data-method="E-Wallet">
                        <div class="method-head">
                            <div class="method-icon">EW</div>
                            <div>
                                <strong>E-Wallet</strong><br>
                                <span class="muted">Dana, OVO, GoPay, atau sejenisnya.</span>
                            </div>
                        </div>
                        <div class="account-box">
                            <div class="bank-item"><span><span class="bank-logo">D</span>DANA</span><strong>0812-3456-7890</strong></div>
                            <div class="bank-item"><span><span class="bank-logo">O</span>OVO</span><strong>0812-3456-7890</strong></div>
                            <div class="bank-item"><span><span class="bank-logo">G</span>GoPay</span><strong>0812-3456-7890</strong></div>
                        </div>
                        <p class="muted" style="margin-top:12px;">Bayar ke akun yang sesuai lalu tunggu verifikasi.</p>
                        <p style="color:#166534; font-weight:700;">Proses verifikasi kurang dari 10 menit setelah pembayaran berhasil.</p>
                    </div>

                    <div class="method-content" data-method="Cash">
                        <div class="method-head">
                            <div class="method-icon">CS</div>
                            <div>
                                <strong>Cash</strong><br>
                                <span class="muted">Bayar saat mengambil kendaraan.</span>
                            </div>
                        </div>
                        <p class="cash-note">Pembayaran dilakukan di tempat saat serah terima kendaraan.</p>
                        <p class="muted">Siapkan uang sesuai total pembayaran agar proses cepat.</p>
                        <p style="color:#166534; font-weight:700;">Verifikasi otomatis dilakukan setelah admin mengonfirmasi pembayaran di tempat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const selectMetode = document.getElementById('metodePembayaran');
    const methodPanels = document.querySelectorAll('[data-method]');
    const jumlahBayar = document.getElementById('jumlahBayar');
    const kurangBayarNotice = document.getElementById('kurangBayarNotice');

    function updateMethodView() {
        const selected = selectMetode.value;
        methodPanels.forEach((panel) => {
            panel.classList.toggle('active', panel.dataset.method === selected);
        });
    }

    selectMetode.addEventListener('change', updateMethodView);
    updateMethodView();

    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }

    function updateKurangBayarNotice() {
        const total = Number(jumlahBayar.dataset.total || 0);
        const bayar = Number(jumlahBayar.value || 0);
        const kurang = Math.max(0, total - bayar);

        if (kurang > 0) {
            kurangBayarNotice.style.display = 'block';
            kurangBayarNotice.textContent = `Anda kurang bayar sebesar Rp ${formatRupiah(kurang)}. Admin akan mengecek dan menentukan status pembayaran.`;
            return;
        }

        kurangBayarNotice.style.display = 'none';
        kurangBayarNotice.textContent = '';
    }

    jumlahBayar.addEventListener('input', updateKurangBayarNotice);
    updateKurangBayarNotice();
</script>

</body>
</html>
