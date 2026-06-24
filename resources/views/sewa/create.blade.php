<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Sewa | Jaya Rental</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        :root { --bg:#f5f7fb; --panel:#fff; --border:#e5e7eb; --primary:#1f4fd7; --text:#1f2937; --muted:#6b7280; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: Arial, sans-serif; background: linear-gradient(180deg, #eef4ff 0%, var(--bg) 30%, #f8fafc 100%); color: var(--text); }
        .page { min-height: 100vh; padding: 24px; display: grid; place-items: center; }
        .card { background: var(--panel); width: min(1120px, 100%); border-radius: 26px; padding: 24px; box-shadow: 0 18px 50px rgba(15,23,42,0.08); border: 1px solid var(--border); }
        .header { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; margin-bottom: 18px; }
        .badge { display:inline-flex; padding:6px 10px; border-radius:999px; background:#dbeafe; color:#1d4ed8; font-size:12px; font-weight:700; }
        h2 { margin: 8px 0 6px; color:#143c8f; }
        .layout { display:grid; grid-template-columns: 1fr 1.1fr; gap: 18px; }
        .panel { background:#f9fbff; border:1px solid var(--border); border-radius: 20px; padding:18px; }
        .vehicle-box { display:flex; gap:16px; align-items:center; }
        .vehicle-art { width:120px; height:90px; border-radius:18px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 55%, #eff6ff 100%); display:grid; place-items:center; font-size:44px; overflow:hidden; }
        .vehicle-art img { width:100%; height:100%; object-fit:cover; }
        .muted { color:var(--muted); }
        .grid { display:grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap:12px; }
        .form-group { margin-bottom: 14px; }
        label { display:block; margin-bottom:6px; font-weight:700; font-size:13px; }
        input, select { width:100%; padding:12px 13px; border:1px solid var(--border); border-radius:12px; font-size:14px; background:#fff; }
        .pickup-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:12px; }
        .pickup-card { border:1px solid var(--border); border-radius:16px; padding:14px; background:#fff; cursor:pointer; transition: 0.2s ease; min-height: 120px; display:flex; flex-direction:column; justify-content:flex-start; }
        .pickup-card:hover { transform: translateY(-1px); box-shadow: 0 10px 24px rgba(15,23,42,0.06); }
        .pickup-card.active { border-color: #1f4fd7; background: #eff6ff; }
        .pickup-card strong { display:block; margin-bottom:4px; }
        .map-note { padding: 14px; border-radius: 16px; border: 1px dashed #93c5fd; background: linear-gradient(135deg, #eff6ff 0%, #ffffff 100%); margin-bottom: 14px; }
        .map-box { height: 280px; border-radius: 18px; border: 1px solid var(--border); overflow: hidden; margin-bottom: 14px; background:#f8fafc; }
        .pickup-meta { display:flex; justify-content:space-between; gap:10px; align-items:center; margin: 8px 0 14px; flex-wrap: wrap; }
        .pickup-badge { display:inline-flex; padding:6px 10px; border-radius:999px; background:#dcfce7; color:#166534; font-size:12px; font-weight:700; }
        .btn-row { display:flex; gap:12px; margin-top: 14px; flex-wrap: wrap; }
        .btn { padding: 13px 16px; border-radius: 12px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; border:none; cursor:pointer; }
        .btn-primary { background: var(--primary); color:#fff; }
        .btn-soft { background:#e5e7eb; color:#111827; }
        .alerts { margin-bottom: 14px; }
        .alert { border-radius: 14px; padding: 12px 14px; margin-bottom:10px; font-weight:700; }
        .alert.error { background:#fee2e2; color:#991b1b; }
        .alert.success { background:#dcfce7; color:#166534; }
        .pickup-card input { pointer-events:none; }
        .pickup-card .muted { line-height: 1.45; }
        @media (max-width: 900px) {
            .page { padding: 14px; }
            .card { padding: 18px; border-radius: 22px; }
            .layout, .grid { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: stretch; }
            .header a, .btn-row .btn { width: 100%; }
            .vehicle-box { align-items: flex-start; }
            .map-box { height: 240px; }
        }
        @media (max-width: 560px) {
            .vehicle-box { flex-direction: column; }
            .vehicle-art { width: 100%; height: 160px; }
            .pickup-grid { grid-template-columns: 1fr; }
            .pickup-card { min-height: auto; }
            .map-box { height: 210px; }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/jaya-polish.css') }}">
</head>
<body>

<div class="page">
    <div class="card">
        <div class="header">
            <div>
                <span class="badge">Form Sewa</span>
                <h2>{{ $kendaraan->nama_kendaraan }}</h2>
                <div class="muted">{{ $kendaraan->jenis }} - Tahun {{ $kendaraan->tahun }} - Rp {{ number_format($kendaraan->harga_per_hari, 0, ',', '.') }}/hari</div>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-soft">Kembali ke Dashboard</a>
        </div>

        <div class="layout">
            <div class="panel">
                <div class="vehicle-box">
                    <div class="vehicle-art">
                        @if($kendaraan->image_url)
                            <img src="{{ $kendaraan->image_url }}" alt="{{ $kendaraan->nama_kendaraan }}" onerror="this.parentElement.classList.add('image-failed');">
                        @else
                            CAR
                        @endif
                    </div>
                    <div>
                        <strong style="font-size:18px;">{{ $kendaraan->nama_kendaraan }}</strong><br>
                        <span class="muted">{{ $kendaraan->jenis }} | {{ $kendaraan->tahun }}</span><br>
                        <span class="muted">Plat: {{ $kendaraan->plat_nomor ?? '-' }} | Unit tersedia: {{ $kendaraan->unit_tersedia }}</span><br>
                        <span class="muted">Harga per hari: Rp {{ number_format($kendaraan->harga_per_hari, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="map-note">
                    <strong>Pilih titik pengambilan terdekat</strong><br>
                    <small class="muted">Aktifkan lokasi browser Anda untuk melihat titik terdekat dari posisi Anda. Admin bisa menambah atau menghapus titik pengambilan dari dashboard admin.</small>
                </div>

                <div class="pickup-meta">
                    <div class="muted" id="locationStatus">Meminta akses lokasi untuk menentukan titik terdekat...</div>
                    <span class="pickup-badge" id="nearestBadge">Belum dipilih</span>
                </div>

                <div class="map-box" id="pickupMap"></div>

                <div class="pickup-grid" id="pickupGrid">
                    @foreach($pickupPoints as $point)
                        <label class="pickup-card" data-pickup-card data-lat="{{ $point->latitude }}" data-lng="{{ $point->longitude }}" data-name="{{ $point->nama_titik }}" data-address="{{ $point->alamat }}">
                            <input type="radio" name="pickup_point_id" value="{{ $point->id }}" form="sewaForm" required hidden>
                            <strong>{{ $point->nama_titik }}</strong>
                            <span class="muted">{{ $point->alamat }}</span>
                            @if($point->latitude !== null && $point->longitude !== null)
                                <div class="muted" style="margin-top:8px; font-size:12px;">Koordinat tersedia</div>
                            @else
                                <div class="muted" style="margin-top:8px; font-size:12px;">Koordinat belum diisi</div>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="panel">
                <form action="{{ route('sewa.store') }}" method="POST" id="sewaForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kendaraan_id" value="{{ $kendaraan->id }}">

                    <div class="grid">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggalMulai" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggalSelesai" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Lokasi Pengambilan</label>
                        <input type="text" id="selectedPickupText" value="Pilih titik dari peta atau daftar di sebelah kiri" readonly>
                        <div class="muted" id="selectedPickupAddress" style="margin-top:8px;">Lokasi akan otomatis terisi setelah titik dipilih.</div>
                    </div>

                    <div class="form-group">
                        <label>NIK Pelanggan</label>
                        <input type="text" name="nik_pelanggan" value="{{ old('nik_pelanggan') }}" maxlength="16" inputmode="numeric" placeholder="16 digit NIK" required>
                    </div>

                    <div class="ktp-reminder">
                        <strong>Siapkan KTP sebelum upload foto.</strong>
                        Pastikan foto KTP jelas dan sesuai dengan NIK yang diisi. KTP asli dibawa saat pengambilan kendaraan untuk proses verifikasi admin.
                    </div>

                    <div class="form-group">
                        <label>Upload Foto KTP</label>
                        <input type="file" name="foto_ktp" accept="image/png,image/jpeg" required>
                    </div>

                    @error('pickup_point_id')
                        <div class="alert error">{{ $message }}</div>
                    @enderror
                    @error('nik_pelanggan')
                        <div class="alert error">{{ $message }}</div>
                    @enderror
                    @error('foto_ktp')
                        <div class="alert error">{{ $message }}</div>
                    @enderror

                    <div class="btn-row">
                        <a href="{{ route('dashboard') }}" class="btn btn-soft">Batal</a>
                        <button type="submit" class="btn btn-primary">Lanjut ke Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    window.googleMapsApiKey = @json(config('services.google_maps.api_key'));
</script>
<script>
    window.initGoogleRentalMap = function () {};
</script>
@if(config('services.google_maps.api_key'))
    <script defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.api_key') }}&callback=initGoogleRentalMap"></script>
@endif

<script>
    const pickupMapElement = document.getElementById('pickupMap');
    const locationStatus = document.getElementById('locationStatus');
    const nearestBadge = document.getElementById('nearestBadge');
    const pickupGrid = document.getElementById('pickupGrid');
    const selectedPickupText = document.getElementById('selectedPickupText');
    const selectedPickupAddress = document.getElementById('selectedPickupAddress');
    const tanggalMulai = document.getElementById('tanggalMulai');
    const tanggalSelesai = document.getElementById('tanggalSelesai');
    const getPickupCards = () => Array.from(document.querySelectorAll('[data-pickup-card]'));
    const allPickupCards = getPickupCards();

    const pickupPoints = allPickupCards.map((card) => ({
        card,
        name: card.dataset.name,
        address: card.dataset.address,
        lat: parseFloat(card.dataset.lat),
        lng: parseFloat(card.dataset.lng),
    })).filter((point) => Number.isFinite(point.lat) && Number.isFinite(point.lng));
    const pickupPointsWithoutCoords = allPickupCards.filter((card) => !Number.isFinite(parseFloat(card.dataset.lat)) || !Number.isFinite(parseFloat(card.dataset.lng)));

    function buildGoogleMap(pickupPoints, pickupPointsWithoutCoords) {
        const fallbackCenter = { lat: pickupPoints[0].lat, lng: pickupPoints[0].lng };
        const map = new google.maps.Map(pickupMapElement, {
            center: fallbackCenter,
            zoom: 12,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true,
        });

        const bounds = new google.maps.LatLngBounds();
        pickupPoints.forEach((point) => {
            const marker = new google.maps.Marker({
                position: { lat: point.lat, lng: point.lng },
                map,
                title: point.name,
            });
            const infoWindow = new google.maps.InfoWindow({
                content: `<strong>${point.name}</strong><br>${point.address}`,
            });
            marker.addListener('click', () => {
                infoWindow.open({ anchor: marker, map });
                const targetCard = pickupGrid.querySelector(`[data-name="${cssEscape(point.name)}"]`);
                if (targetCard) {
                    selectPickupCard(targetCard);
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
            bounds.extend(marker.getPosition());
        });

        map.fitBounds(bounds);

        const renderUserLocation = (userLat, userLng) => {
            const userMarker = new google.maps.Marker({
                position: { lat: userLat, lng: userLng },
                map,
                title: 'Lokasi Anda',
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 8,
                    fillColor: '#1f4fd7',
                    fillOpacity: 1,
                    strokeColor: '#ffffff',
                    strokeWeight: 2,
                },
            });
            bounds.extend(userMarker.getPosition());
        };

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                locationStatus.textContent = 'Lokasi terdeteksi, titik pickup diurutkan dari yang paling dekat.';

                const ordered = pickupPoints
                    .map((point) => ({
                        ...point,
                        distance: haversine(userLat, userLng, point.lat, point.lng),
                    }))
                    .sort((left, right) => left.distance - right.distance);

                nearestBadge.textContent = `Terdekat: ${ordered[0].name}`;

                pickupGrid.innerHTML = '';
                ordered.forEach((point, index) => {
                    const cloned = point.card.cloneNode(true);
                    const distanceText = point.distance < 1 ? `${Math.round(point.distance * 1000)} m` : `${point.distance.toFixed(1)} km`;
                    cloned.dataset.distance = point.distance.toFixed(2);
                    cloned.classList.toggle('active', index === 0);
                    cloned.insertAdjacentHTML('beforeend', `<div style="margin-top:8px; font-size:12px; font-weight:700; color:${index === 0 ? '#166534' : '#1f4fd7'};">${index === 0 ? 'Titik terdekat: ' : 'Jarak: '}${distanceText}</div>`);
                    pickupGrid.appendChild(cloned);
                });

                pickupPointsWithoutCoords.forEach((card) => {
                    pickupGrid.appendChild(card.cloneNode(true));
                });

                const firstCard = pickupGrid.querySelector('[data-pickup-card]');
                if (firstCard) {
                    selectPickupCard(firstCard);
                }

                renderUserLocation(userLat, userLng);
                map.fitBounds(bounds);
            }, () => {
                locationStatus.textContent = 'Lokasi browser tidak diizinkan. Titik pengambilan tetap tersedia di bawah.';
                const firstCard = pickupGrid.querySelector('[data-pickup-card]');
                if (firstCard) {
                    selectPickupCard(firstCard);
                }
            });
        }
    }

    window.initGoogleRentalMap = function () {
        if (pickupPoints.length && pickupMapElement) {
            buildGoogleMap(pickupPoints, pickupPointsWithoutCoords);
        }
    };

    function haversine(lat1, lng1, lat2, lng2) {
        const toRad = (value) => value * Math.PI / 180;
        const earthRadiusKm = 6371;
        const dLat = toRad(lat2 - lat1);
        const dLng = toRad(lng2 - lng1);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * Math.sin(dLng / 2) * Math.sin(dLng / 2);
        return earthRadiusKm * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function selectPickupCard(card) {
        getPickupCards().forEach((item) => item.classList.remove('active'));
        card.classList.add('active');
        const radio = card.querySelector('input[type="radio"]');
        if (radio) {
            radio.checked = true;
        }
        const pickupName = card.dataset.name || 'Titik pengambilan';
        const pickupAddress = card.dataset.address || 'Alamat belum tersedia';
        nearestBadge.textContent = pickupName;
        if (selectedPickupText) {
            selectedPickupText.value = pickupName;
        }
        if (selectedPickupAddress) {
            selectedPickupAddress.textContent = pickupAddress;
        }
    }

    function cssEscape(value) {
        if (window.CSS && typeof window.CSS.escape === 'function') {
            return window.CSS.escape(value);
        }
        return String(value).replace(/["\\]/g, '\\$&');
    }

    function toDateInputValue(date) {
        const offsetDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000);
        return offsetDate.toISOString().slice(0, 10);
    }

    function setDefaultDates() {
        if (!tanggalMulai || !tanggalSelesai) {
            return;
        }

        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        tanggalMulai.min = toDateInputValue(today);
        tanggalSelesai.min = toDateInputValue(tomorrow);

        if (!tanggalMulai.value) {
            tanggalMulai.value = toDateInputValue(today);
        }
        if (!tanggalSelesai.value) {
            tanggalSelesai.value = toDateInputValue(tomorrow);
        }
    }

    if (pickupGrid) {
        pickupGrid.addEventListener('click', (event) => {
            const card = event.target.closest('[data-pickup-card]');
            if (card) {
                selectPickupCard(card);
            }
        });
    }

    if (tanggalMulai && tanggalSelesai) {
        tanggalMulai.addEventListener('change', () => {
            const startDate = new Date(`${tanggalMulai.value}T00:00:00`);
            if (!Number.isNaN(startDate.getTime())) {
                const nextDate = new Date(startDate);
                nextDate.setDate(startDate.getDate() + 1);
                tanggalSelesai.min = toDateInputValue(nextDate);
                if (!tanggalSelesai.value || tanggalSelesai.value <= tanggalMulai.value) {
                    tanggalSelesai.value = toDateInputValue(nextDate);
                }
            }
        });
    }

    setDefaultDates();

    if (pickupPoints.length && pickupMapElement) {
        if (!window.googleMapsApiKey) {
        const fallbackCenter = [pickupPoints[0].lat, pickupPoints[0].lng];
        const map = L.map('pickupMap').setView(fallbackCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors',
        }).addTo(map);

        const markers = [];
        pickupPoints.forEach((point) => {
            const marker = L.marker([point.lat, point.lng]).addTo(map);
            marker.bindPopup(`<strong>${point.name}</strong><br>${point.address}`);
            marker.on('click', () => {
                const targetCard = pickupGrid.querySelector(`[data-name="${cssEscape(point.name)}"]`);
                if (targetCard) {
                    selectPickupCard(targetCard);
                    targetCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
            markers.push(marker);
        });

        const fitGroup = L.featureGroup(markers);
        map.fitBounds(fitGroup.getBounds().pad(0.2));

            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                locationStatus.textContent = 'Lokasi terdeteksi, titik pickup diurutkan dari yang paling dekat.';

                const ordered = pickupPoints
                    .map((point) => ({
                        ...point,
                        distance: haversine(userLat, userLng, point.lat, point.lng),
                    }))
                    .sort((left, right) => left.distance - right.distance);

                nearestBadge.textContent = `Terdekat: ${ordered[0].name}`;

                ordered.forEach((point, index) => {
                    const card = point.card;
                    card.dataset.distance = point.distance.toFixed(2);
                    const meterText = point.distance < 1
                        ? `${Math.round(point.distance * 1000)} m`
                        : `${point.distance.toFixed(1)} km`;
                    let distanceLabel = card.querySelector('[data-distance-label]');
                    if (!distanceLabel) {
                        distanceLabel = document.createElement('div');
                        distanceLabel.dataset.distanceLabel = '1';
                        distanceLabel.style.marginTop = '8px';
                        distanceLabel.style.fontSize = '12px';
                        distanceLabel.style.fontWeight = '700';
                        distanceLabel.style.color = index === 0 ? '#166534' : '#1f4fd7';
                        card.appendChild(distanceLabel);
                    }
                    distanceLabel.textContent = index === 0 ? `Titik terdekat: ${meterText}` : `Jarak: ${meterText}`;
                });

                pickupGrid.innerHTML = '';
                ordered.forEach((point, index) => {
                    const cloned = point.card.cloneNode(true);
                    cloned.classList.toggle('active', index === 0);
                    pickupGrid.appendChild(cloned);
                });

                pickupPointsWithoutCoords.forEach((card) => {
                    pickupGrid.appendChild(card.cloneNode(true));
                });

                const firstCard = pickupGrid.querySelector('[data-pickup-card]');
                if (firstCard) {
                    selectPickupCard(firstCard);
                }

                const userMarker = L.circleMarker([userLat, userLng], {
                    radius: 8,
                    color: '#1f4fd7',
                    fillColor: '#1f4fd7',
                    fillOpacity: 0.9,
                }).addTo(map);
                userMarker.bindPopup('Lokasi Anda');
            }, () => {
                locationStatus.textContent = 'Lokasi browser tidak diizinkan. Titik pengambilan tetap tersedia di bawah.';
                const firstCard = pickupGrid.querySelector('[data-pickup-card]');
                if (firstCard) {
                    selectPickupCard(firstCard);
                }
            });
            }
        }
    } else {
        locationStatus.textContent = 'Belum ada titik pickup yang memiliki koordinat. Admin perlu mengisi latitude dan longitude.';
        nearestBadge.textContent = 'Koordinat kosong';
        if (pickupMapElement) {
            pickupMapElement.innerHTML = '<div style="padding:20px; color:#6b7280;">Peta belum tersedia karena titik pickup belum memiliki koordinat.</div>';
        }
    }
</script>

</body>
</html>
