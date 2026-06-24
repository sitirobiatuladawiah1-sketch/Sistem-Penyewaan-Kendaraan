<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\PickupPoint;
use App\Models\Penyewaan;
use App\Models\ServiceHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function ensureAdmin(): void
    {
        abort_unless(Auth::check() && Auth::user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->ensureAdmin();

        $users = User::latest()->get();
        $transaksi = Penyewaan::with(['user', 'kendaraan'])
            ->latest()
            ->get();
        $kendaraan = Kendaraan::with('serviceHistories')->latest()->get();
        $serviceHistories = ServiceHistory::with('kendaraan')->latest('tanggal_service')->latest()->get();
        $pickupPoints = PickupPoint::orderBy('sort_order')->orderBy('id')->get();

        $statistik = [
            'total_pengguna' => $users->count(),
            'total_transaksi' => $transaksi->count(),
            'total_kendaraan' => $kendaraan->count(),
            'kendaraan_service' => $kendaraan->where('status_operasional', 'Service')->count(),
            'total_titik' => $pickupPoints->count(),
        ];

        return view('admin.dashboard', compact('users', 'transaksi', 'kendaraan', 'pickupPoints', 'statistik', 'serviceHistories'));
    }

    public function editKendaraan(Kendaraan $kendaraan)
    {
        $this->ensureAdmin();

        return view('admin.kendaraan-edit', compact('kendaraan'));
    }

    public function riwayatTransaksi()
    {
        $this->ensureAdmin();

        $transaksi = Penyewaan::with(['user', 'kendaraan'])->latest()->get();

        return view('admin.riwayat-transaksi', compact('transaksi'));
    }

    public function pengembalian()
    {
        $this->ensureAdmin();

        $transaksi = Penyewaan::with(['user', 'kendaraan'])
            ->where('status_sewa', 'Pending')
            ->latest()
            ->get();

        return view('admin.pengembalian', compact('transaksi'));
    }

    public function riwayatPerbaikan()
    {
        $this->ensureAdmin();

        $serviceHistories = ServiceHistory::with('kendaraan')->latest('tanggal_service')->latest()->get();

        return view('admin.riwayat-perbaikan', compact('serviceHistories'));
    }

    public function updateKendaraan(Request $request, Kendaraan $kendaraan)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|string|max:10',
            'plat_nomor' => 'required|string|max:20|unique:kendaraan,plat_nomor,' . $kendaraan->id,
            'no_bpkb' => 'required|string|max:50|unique:kendaraan,no_bpkb,' . $kendaraan->id,
            'pajak_berlaku_sampai' => 'required|date',
            'status_pajak' => 'required|in:Belum Bayar,Sudah Bayar',
            'tanggal_bayar_pajak' => 'nullable|date|required_if:status_pajak,Sudah Bayar',
            'image_url' => 'nullable|url',
            'harga_per_hari' => 'required|integer|min:0',
            'jumlah_unit' => 'required|integer|min:1',
            'unit_tersedia' => 'required|integer|min:0|lte:jumlah_unit',
            'status' => 'required|in:Tersedia,Disewa',
            'status_operasional' => 'required|in:Normal,Service',
        ]);

        $kendaraan->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    public function storeKendaraan(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'nama_kendaraan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|string|max:10',
            'plat_nomor' => 'required|string|max:20|unique:kendaraan,plat_nomor',
            'no_bpkb' => 'required|string|max:50|unique:kendaraan,no_bpkb',
            'pajak_berlaku_sampai' => 'required|date',
            'status_pajak' => 'required|in:Belum Bayar,Sudah Bayar',
            'tanggal_bayar_pajak' => 'nullable|date|required_if:status_pajak,Sudah Bayar',
            'image_url' => 'nullable|url',
            'harga_per_hari' => 'required|integer|min:0',
            'jumlah_unit' => 'required|integer|min:1',
            'unit_tersedia' => 'required|integer|min:0|lte:jumlah_unit',
            'status' => 'required|in:Tersedia,Disewa',
            'status_operasional' => 'required|in:Normal,Service',
        ]);

        Kendaraan::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function updateKendaraanStatus(Request $request, Kendaraan $kendaraan)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status_operasional' => 'required|in:Normal,Service',
        ]);

        $kendaraan->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Status kendaraan berhasil diperbarui.');
    }

    public function destroyKendaraan(Request $request, Kendaraan $kendaraan)
    {
        $this->ensureAdmin();

        $request->validate([
            'admin_email' => 'required|email',
            'admin_password' => 'required|string',
        ]);

        if ($request->admin_email !== Auth::user()->email || ! Hash::check($request->admin_password, Auth::user()->password)) {
            return redirect()->route('admin.dashboard')->with('error', 'Email atau password admin tidak cocok.');
        }

        $transaksiTerpakai = Penyewaan::where('kendaraan_id', $kendaraan->id)->exists();

        if ($transaksiTerpakai) {
            return redirect()->route('admin.dashboard')->with('error', 'Kendaraan ini tidak bisa dihapus karena sudah punya riwayat transaksi.');
        }

        $kendaraan->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Kendaraan berhasil dihapus.');
    }

    public function editPickupPoint(PickupPoint $pickupPoint)
    {
        $this->ensureAdmin();

        return view('admin.pickup-point-edit', compact('pickupPoint'));
    }

    public function updatePickupPoint(Request $request, PickupPoint $pickupPoint)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'nama_titik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $pickupPoint->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Titik lokasi pengambilan berhasil diperbarui.');
    }

    public function storePickupPoint(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'nama_titik' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['is_active'] = true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        PickupPoint::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Titik lokasi pengambilan berhasil ditambahkan.');
    }

    public function destroyPickupPoint(PickupPoint $pickupPoint)
    {
        $this->ensureAdmin();

        $pickupPoint->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Titik lokasi pengambilan berhasil dihapus.');
    }

    public function updateTransaksiStatus(Request $request, Penyewaan $transaksi)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status_sewa' => 'nullable|in:Pending,Selesai,Dikembalikan,Expired',
            'status_pembayaran' => 'nullable|in:Menunggu Konfirmasi,Lunas,Kurang Bayar,Ditolak',
        ]);

        $statusSebelumnya = $transaksi->status_sewa;
        $updateData = array_filter($data, fn ($value) => $value !== null);

        if (($updateData['status_pembayaran'] ?? null) === 'Lunas') {
            $updateData['kurang_bayar'] = 0;
            $updateData['paid_at'] = $transaksi->paid_at ?? now();
        }

        if (($updateData['status_pembayaran'] ?? null) === 'Kurang Bayar') {
            $updateData['kurang_bayar'] = max(0, (int) $transaksi->total_harga - (int) $transaksi->jumlah_bayar);
        }

        $transaksi->update($updateData);

        $kendaraan = $transaksi->kendaraan;
        if ($kendaraan && isset($updateData['status_sewa']) && in_array($updateData['status_sewa'], ['Selesai', 'Dikembalikan', 'Expired'], true)) {
            $unitTersedia = in_array($statusSebelumnya, ['Pending'], true)
                ? min($kendaraan->jumlah_unit, $kendaraan->unit_tersedia + 1)
                : $kendaraan->unit_tersedia;

            $kendaraan->update([
                'unit_tersedia' => $unitTersedia,
                'status' => $unitTersedia > 0 ? 'Tersedia' : 'Disewa',
            ]);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function returnTransaksi(Request $request, Penyewaan $transaksi)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'tanggal_pengembalian' => 'required|date',
        ]);

        $tanggalPengembalian = Carbon::parse($data['tanggal_pengembalian']);
        $tanggalSelesai = Carbon::parse($transaksi->tanggal_selesai);
        $hariTerlambat = $tanggalPengembalian->greaterThan($tanggalSelesai)
            ? $tanggalSelesai->diffInDays($tanggalPengembalian)
            : 0;
        $dendaPerHari = (int) round($transaksi->harga_per_hari * 1.2);
        $denda = $hariTerlambat * $dendaPerHari;

        $transaksi->update([
            'tanggal_pengembalian' => $tanggalPengembalian->toDateString(),
            'denda_keterlambatan' => $denda,
            'status_sewa' => 'Selesai',
        ]);

        if ($transaksi->kendaraan) {
            $unitTersedia = min($transaksi->kendaraan->jumlah_unit, $transaksi->kendaraan->unit_tersedia + 1);
            $transaksi->kendaraan->update([
                'unit_tersedia' => $unitTersedia,
                'status' => $unitTersedia > 0 ? 'Tersedia' : 'Disewa',
            ]);
        }

        return redirect()->back()->with('success', 'Mobil berhasil dikembalikan. Status menjadi Selesai. Denda: Rp ' . number_format($denda, 0, ',', '.') . ' (' . $hariTerlambat . ' hari x Rp ' . number_format($dendaPerHari, 0, ',', '.') . ').');
    }

    public function storeServiceHistory(Request $request, Kendaraan $kendaraan)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'tanggal_service' => 'required|date',
            'nama_bengkel' => 'required|string|max:255',
            'jenis_service' => 'required|string|max:255',
            'kerusakan' => 'required|string',
            'perbaikan' => 'required|string',
            'catatan' => 'nullable|string',
            'biaya' => 'nullable|integer|min:0',
        ]);

        $data['biaya'] = $data['biaya'] ?? 0;
        $kendaraan->serviceHistories()->create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Riwayat service berhasil ditambahkan.');
    }
}
