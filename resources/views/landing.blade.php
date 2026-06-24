<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAYA RENTAL - Sewa Mobil</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --ink: #102033;
            --muted: #667085;
            --line: #e4e9f2;
            --primary: #2563eb;
            --primary-dark: #143c8f;
            --accent: #f59e0b;
            --green: #14b8a6;
            --panel: #ffffff;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.10);
        }
        * { box-sizing: border-box; letter-spacing: 0; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            color: var(--ink);
            background:
                linear-gradient(180deg, #eaf2ff 0%, #f4f7fb 32%, #eef5ff 68%, #f8fbff 100%),
                var(--bg);
        }
        .site-nav {
            position: sticky;
            top: 0;
            z-index: 20;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid rgba(228, 233, 242, 0.9);
            backdrop-filter: blur(16px);
        }
        .nav-inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            min-height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 900;
        }
        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: #fff;
            font-size: 13px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .nav-links a {
            color: #344054;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 12px;
            border-radius: 8px;
        }
        .nav-links a:hover { background: #eef5ff; color: var(--primary-dark); }
        .nav-actions { display: flex; gap: 10px; align-items: center; }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 11px 16px;
            border-radius: 9px;
            border: 1px solid transparent;
            text-decoration: none;
            font-weight: 800;
            font-size: 14px;
        }
        .btn-primary { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); color: #fff; box-shadow: 0 10px 22px rgba(37, 99, 235, 0.24); }
        .btn-soft { background: #eef5ff; color: var(--ink); border-color: var(--line); }
        .hero {
            min-height: calc(100vh - 68px);
            display: grid;
            align-items: center;
            background:
                linear-gradient(110deg, rgba(10, 27, 55, 0.92), rgba(20, 60, 143, 0.76)),
                url("https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1800&q=80") center/cover;
            color: #fff;
        }
        .hero-inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 76px 0 54px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 380px;
            gap: 28px;
            align-items: end;
        }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            color: rgba(255, 255, 255, 0.86);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: var(--accent);
        }
        h1 {
            margin: 18px 0 14px;
            font-size: clamp(42px, 7vw, 82px);
            line-height: 0.95;
            max-width: 850px;
        }
        .hero-copy {
            max-width: 650px;
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 18px;
            line-height: 1.7;
        }
        .hero-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 28px;
        }
        .hero-buttons .btn-soft {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.24);
        }
        .hero-panel {
            background: rgba(248, 251, 255, 0.95);
            color: var(--ink);
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow);
        }
        .hero-panel h2 { margin: 0 0 8px; font-size: 22px; }
        .hero-panel p { margin: 0 0 16px; color: var(--muted); line-height: 1.55; }
        .quick-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .quick-stat {
            padding: 13px;
            border-radius: 12px;
            background: #eef5ff;
            border: 1px solid var(--line);
        }
        .trust-strip {
            width: min(1180px, calc(100% - 32px));
            margin: -34px auto 0;
            position: relative;
            z-index: 4;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: rgba(248, 251, 255, 0.98);
            box-shadow: var(--shadow);
        }
        .trust-item {
            padding: 18px;
            border-right: 1px solid var(--line);
        }
        .trust-item:last-child { border-right: 0; }
        .trust-item strong {
            display: block;
            font-size: 22px;
            margin-bottom: 4px;
        }
        .trust-item span {
            color: var(--muted);
            font-size: 13px;
        }
        .quick-stat strong { display: block; font-size: 24px; }
        .quick-stat span { color: var(--muted); font-size: 13px; }
        section {
            width: min(1180px, calc(100% - 32px));
            margin: 34px auto;
            padding: 42px;
            border: 1px solid rgba(205, 217, 236, 0.88);
            border-radius: 18px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.74), rgba(239, 246, 255, 0.72));
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.045);
        }
        section:nth-of-type(even) {
            background:
                linear-gradient(135deg, rgba(239, 246, 255, 0.86), rgba(255, 255, 255, 0.78));
        }
        .section-head {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: end;
            margin-bottom: 22px;
        }
        .section-head h2 {
            margin: 0;
            font-size: clamp(28px, 4vw, 42px);
        }
        .section-head p {
            margin: 0;
            max-width: 520px;
            color: var(--muted);
            line-height: 1.65;
        }
        .about-grid {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 18px;
            align-items: stretch;
        }
        .about-media {
            min-height: 220px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--line);
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
            background: #dbeafe;
        }
        .about-media img,
        .service-card img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        .about-card,
        .service-card,
        .review-card {
            background: #f8fbff;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.05);
        }
        .about-card p { color: var(--muted); line-height: 1.75; margin: 0; }
        .about-list {
            display: grid;
            gap: 12px;
        }
        .about-item {
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: #ffffff;
        }
        .about-item strong { display: block; margin-bottom: 4px; }
        .about-item span { color: var(--muted); line-height: 1.55; }
        .services-grid,
        .reviews-grid,
        .fleet-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }
        .fleet-card {
            overflow: hidden;
            background: #f8fbff;
            border: 1px solid var(--line);
            border-radius: 16px;
            box-shadow: 0 10px 26px rgba(15, 23, 42, 0.05);
        }
        .fleet-card img {
            width: 100%;
            height: 190px;
            display: block;
            object-fit: cover;
        }
        .fleet-body {
            padding: 18px;
        }
        .fleet-body strong {
            display: block;
            font-size: 18px;
            margin-bottom: 6px;
        }
        .fleet-body p {
            margin: 0 0 14px;
            color: var(--muted);
            line-height: 1.6;
        }
        .fleet-meta {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            color: var(--primary-dark);
            font-size: 13px;
            font-weight: 800;
        }
        .service-card strong {
            display: block;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .service-card {
            overflow: hidden;
            padding: 0;
        }
        .service-card img {
            height: 145px;
        }
        .service-card div {
            padding: 18px;
        }
        .service-card p,
        .review-card p {
            color: var(--muted);
            line-height: 1.65;
            margin: 0;
        }
        .rating {
            color: var(--accent);
            font-weight: 900;
            margin-bottom: 12px;
        }
        .review-user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--line);
        }
        .review-user strong { display: block; }
        .review-user span { color: var(--muted); font-size: 13px; }
        .cta {
            width: min(1180px, calc(100% - 32px));
            margin: 34px auto 70px;
            padding: 34px;
            border-radius: 18px;
            background:
                linear-gradient(135deg, rgba(20, 60, 143, 0.98), rgba(37, 99, 235, 0.94)),
                var(--primary-dark);
            color: #fff;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
            box-shadow: var(--shadow);
        }
        .cta h2 { margin: 0 0 8px; font-size: 30px; }
        .cta p { margin: 0; color: rgba(255, 255, 255, 0.82); line-height: 1.6; }
        .cta .btn-soft {
            background: #fff;
            color: var(--primary-dark);
            border-color: #fff;
        }
        footer {
            border-top: 1px solid var(--line);
            padding: 24px 0;
            color: var(--muted);
            text-align: center;
            background: #eef5ff;
        }
        @media (max-width: 900px) {
            .nav-inner { align-items: flex-start; padding: 12px 0; flex-direction: column; }
            .nav-links, .nav-actions { width: 100%; flex-wrap: wrap; }
            .hero { min-height: auto; }
            .hero-inner,
            .about-grid,
            .services-grid,
            .reviews-grid,
            .fleet-grid,
            .trust-strip {
                grid-template-columns: 1fr;
            }
            .trust-strip { margin-top: 0; }
            .trust-item { border-right: 0; border-bottom: 1px solid var(--line); }
            .trust-item:last-child { border-bottom: 0; }
            .hero-inner { padding: 56px 0 36px; }
            .section-head,
            .cta {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        @media (max-width: 560px) {
            .nav-links a { padding: 9px 8px; }
            .nav-actions, .hero-buttons { flex-direction: column; }
            .btn { width: 100%; }
            section { padding: 28px 18px; margin: 22px auto; }
            .quick-stats { grid-template-columns: 1fr; }
            .cta { padding: 24px; margin-bottom: 46px; }
        }
    </style>
</head>
<body>
    <nav class="site-nav">
        <div class="nav-inner">
            <a href="#home" class="brand">
                <span class="brand-mark">JR</span>
                <span>JAYA RENTAL</span>
            </a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#tentang">Tentang Kami</a>
                <a href="#layanan">Layanan</a>
                <a href="#armada">Armada</a>
                <a href="#rating">Rating</a>
            </div>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-soft">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>

    <main id="home" class="hero">
        <div class="hero-inner">
            <div>
                <div class="eyebrow">Sewa mobil cepat dan terpercaya</div>
                <h1>Perjalanan nyaman dimulai dari kendaraan yang tepat.</h1>
                <p class="hero-copy">
                    Jaya Rental membantu kamu memilih mobil, mengecek unit tersedia,
                    menentukan titik pengambilan, dan menyelesaikan booking dalam satu alur yang rapi.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-primary">Mulai Booking</a>
                    <a href="#tentang" class="btn btn-soft">Lihat Tentang Kami</a>
                </div>
            </div>

            <aside class="hero-panel">
                <h2>Ringkasan Layanan</h2>
                <p>Dirancang untuk pelanggan harian, perjalanan keluarga, dan kebutuhan operasional.</p>
                <div class="quick-stats">
                    <div class="quick-stat"><strong>4.9</strong><span>Rating pelanggan</span></div>
                    <div class="quick-stat"><strong>12 jam</strong><span>Validasi booking</span></div>
                    <div class="quick-stat"><strong>24/7</strong><span>Siap reservasi</span></div>
                    <div class="quick-stat"><strong>QR</strong><span>Kode booking</span></div>
                </div>
            </aside>
        </div>
    </main>

    <div class="trust-strip" aria-label="Keunggulan Jaya Rental">
        <div class="trust-item"><strong>120+</strong><span>booking tercatat</span></div>
        <div class="trust-item"><strong>30+</strong><span>unit siap jalan</span></div>
        <div class="trust-item"><strong>4.9</strong><span>rata-rata rating</span></div>
        <div class="trust-item"><strong>10 menit</strong><span>estimasi verifikasi</span></div>
    </div>

    <section id="tentang">
        <div class="section-head">
            <h2>Tentang Kami</h2>
            <p>Kami membuat proses sewa mobil terasa sederhana: jelas di harga, jelas di stok, dan jelas di alur pengambilan.</p>
        </div>
        <div class="about-grid">
            <div class="about-card">
                <div class="about-media" style="margin-bottom:16px;">
                    <img src="https://images.unsplash.com/photo-1565043666747-69f6646db940?auto=format&fit=crop&w=900&q=80" alt="Pelayanan rental kendaraan">
                </div>
                <p>
                    Jaya Rental adalah layanan penyewaan kendaraan yang berfokus pada kemudahan pelanggan.
                    Setiap booking dilengkapi data identitas, kode QR, riwayat transaksi, dan status pengembalian
                    agar pelanggan maupun admin bisa memantau proses dengan tenang.
                </p>
            </div>
            <div class="about-list">
                <div class="about-item">
                    <strong>Unit lebih terpantau</strong>
                    <span>Admin dapat mengelola plat nomor, BPKB, pajak, unit tersedia, dan status service.</span>
                </div>
                <div class="about-item">
                    <strong>Booking lebih aman</strong>
                    <span>Data NIK, foto KTP, validasi pembayaran, dan expiry 12 jam membantu transaksi lebih tertib.</span>
                </div>
                <div class="about-item">
                    <strong>Riwayat lengkap</strong>
                    <span>Transaksi, service kendaraan, pembayaran, dan pengembalian tersimpan rapi.</span>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan">
        <div class="section-head">
            <h2>Layanan Unggulan</h2>
            <p>Fitur yang disiapkan supaya proses rental tidak ribet dari awal sampai kendaraan dikembalikan.</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1556157382-97eda2d62296?auto=format&fit=crop&w=800&q=80" alt="Booking online">
                <div>
                    <strong>Booking Online</strong>
                    <p>Pilih kendaraan, tanggal sewa, titik pengambilan, dan lanjut ke pembayaran dari dashboard pelanggan.</p>
                </div>
            </div>
            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&w=800&q=80" alt="Pembayaran dan kode booking">
                <div>
                    <strong>QR Code Booking</strong>
                    <p>Setiap transaksi punya kode booking dan QR untuk memudahkan pengecekan saat serah terima.</p>
                </div>
            </div>
            <div class="service-card">
                <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=800&q=80" alt="Pengembalian kendaraan">
                <div>
                    <strong>Pengembalian & Denda</strong>
                    <p>Admin bisa mencatat pengembalian dan sistem menghitung denda keterlambatan secara otomatis.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="armada">
        <div class="section-head">
            <h2>Pilihan Armada</h2>
            <p>Beberapa kategori kendaraan yang biasa dipakai pelanggan untuk kebutuhan harian, keluarga, dan perjalanan luar kota.</p>
        </div>
        <div class="fleet-grid">
            <article class="fleet-card">
                <img src="https://images.unsplash.com/photo-1549925862-990b5bcf4d7e?auto=format&fit=crop&w=900&q=80" alt="Mobil city car">
                <div class="fleet-body">
                    <strong>City Car</strong>
                    <p>Ringkas, hemat, dan nyaman untuk mobilitas dalam kota.</p>
                    <div class="fleet-meta"><span>Mulai 350rb/hari</span><span>Harian</span></div>
                </div>
            </article>
            <article class="fleet-card">
                <img src="https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=80" alt="Mobil keluarga MPV">
                <div class="fleet-body">
                    <strong>MPV Keluarga</strong>
                    <p>Kabin luas untuk liburan, acara keluarga, dan perjalanan bersama.</p>
                    <div class="fleet-meta"><span>Mulai 420rb/hari</span><span>Keluarga</span></div>
                </div>
            </article>
            <article class="fleet-card">
                <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=900&q=80" alt="Mobil SUV">
                <div class="fleet-body">
                    <strong>SUV Premium</strong>
                    <p>Lebih gagah dan stabil untuk perjalanan jauh atau rute campuran.</p>
                    <div class="fleet-meta"><span>Mulai 500rb/hari</span><span>Travel</span></div>
                </div>
            </article>
        </div>
    </section>

    <section id="rating">
        <div class="section-head">
            <h2>Rating Pengguna</h2>
            <p>Beberapa kesan pelanggan setelah menggunakan Jaya Rental untuk perjalanan dan kebutuhan harian.</p>
        </div>
        <div class="reviews-grid">
            <div class="review-card">
                <div class="rating">5.0 / 5</div>
                <p>Mobil bersih, alur booking jelas, dan struknya langsung bisa dicek. Cocok untuk perjalanan keluarga.</p>
                <div class="review-user"><div><strong>Siti Rahma</strong><span>Pelanggan keluarga</span></div><span>MPV</span></div>
            </div>
            <div class="review-card">
                <div class="rating">4.9 / 5</div>
                <p>Admin cepat konfirmasi, lokasi pickup jelas, dan pembayaran terasa aman karena ada kode booking.</p>
                <div class="review-user"><div><strong>Dino Pratama</strong><span>Pelanggan harian</span></div><span>SUV</span></div>
            </div>
            <div class="review-card">
                <div class="rating">4.8 / 5</div>
                <p>Dashboardnya membantu banget buat lihat riwayat sewa dan total pengeluaran tanpa tanya admin lagi.</p>
                <div class="review-user"><div><strong>Nabila Putri</strong><span>Pelanggan reguler</span></div><span>Sedan</span></div>
            </div>
        </div>
    </section>

    <div class="cta">
        <div>
            <h2>Siap mulai perjalanan?</h2>
            <p>Login untuk melihat mobil tersedia atau daftar akun baru untuk mulai booking kendaraan.</p>
        </div>
        <div class="nav-actions">
            <a href="{{ route('login') }}" class="btn btn-soft">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        </div>
    </div>

    <footer>
        JAYA RENTAL - Sewa kendaraan mudah, rapi, dan terpercaya.
    </footer>
</body>
</html>
