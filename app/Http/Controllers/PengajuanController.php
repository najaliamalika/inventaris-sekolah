<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarItem;
use App\Models\JenisBarang;
use App\Models\Pengajuan;
use App\Models\PengajuanPerbaikanItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::with(['jenisBarang', 'perbaikanItems.barang']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('alasan', 'like', "%{$search}%")
                    ->orWhereHas('jenisBarang', function ($q) use ($search) {
                        $q->where('jenis', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->paginate(10);

        // Stats
        $totalPengajuan = Pengajuan::count();
        $totalMenunggu = Pengajuan::where('status', 'menunggu')->count();
        $totalDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $totalDitolak = Pengajuan::where('status', 'ditolak')->count();

        // Get jenis barang for filter
        $jenisBarangList = JenisBarang::orderBy('jenis')->get();

        return view('pengajuan.index', compact(
            'pengajuan',
            'totalPengajuan',
            'totalMenunggu',
            'totalDisetujui',
            'totalDitolak',
            'jenisBarangList'
        ));
    }

    public function create()
    {
        // Get all jenis barang
        $jenisBarang = JenisBarang::orderBy('jenis')->get();

        return view('pengajuan.create', compact('jenisBarang'));
    }

    public function getAvailableBarangForPerbaikan($jenisBarangId)
    {
        // Get barang yang aktif dan kondisi baik (bisa diperbaiki)
        $barang = Barang::where('jenis_barang_id', $jenisBarangId)
            ->where('status', 'aktif')
            ->where('kondisi', 'baik')
            ->with('jenisBarang')
            ->get();

        return response()->json($barang);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe' => 'required|in:pembelian,perbaikan',
            'jenis_barang_id' => 'nullable|exists:jenis_barang,jenis_barang_id',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'estimasi_biaya' => 'required|integer|min:0',
            'alasan' => 'required|string',

            // For perbaikan only
            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'nullable|exists:barang,barang_id',
        ], [
            'tipe.required' => 'Tipe pengajuan wajib dipilih',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'jumlah.required' => 'Jumlah wajib diisi',
            'estimasi_biaya.required' => 'Estimasi biaya wajib diisi',
            'alasan.required' => 'Alasan pengajuan wajib diisi',
        ]);

        // Additional validation for perbaikan
        if ($validated['tipe'] === 'perbaikan') {
            if (empty($validated['jenis_barang_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Jenis barang wajib dipilih untuk pengajuan perbaikan');
            }

            if (empty($validated['barang_ids']) || count($validated['barang_ids']) !== $validated['jumlah']) {
                return back()
                    ->withInput()
                    ->with('error', 'Jumlah barang yang dipilih harus sesuai dengan jumlah yang diinput');
            }
        }

        DB::beginTransaction();

        try {
            // Create Pengajuan
            $pengajuan = Pengajuan::create([
                'pengajuan_id' => (string) Str::uuid(),
                'jenis_barang_id' => $validated['tipe'] === 'perbaikan' ? $validated['jenis_barang_id'] : null,
                'nama_barang' => $validated['nama_barang'],
                'tipe' => $validated['tipe'],
                'jumlah' => $validated['jumlah'],
                'estimasi_biaya' => $validated['estimasi_biaya'],
                'alasan' => $validated['alasan'],
                'status' => 'menunggu',
            ]);

            // If perbaikan, create items
            if ($validated['tipe'] === 'perbaikan' && !empty($validated['barang_ids'])) {
                foreach ($validated['barang_ids'] as $barangId) {
                    PengajuanPerbaikanItem::create([
                        'pengajuan_perbaikan_item_id' => (string) Str::uuid(),
                        'pengajuan_id' => $pengajuan->pengajuan_id,
                        'barang_id' => $barangId,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('pengajuan.index')
                ->with('success', 'Pengajuan berhasil dibuat dan menunggu persetujuan!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $pengajuan_id)
    {
        $pengajuan = Pengajuan::with(['jenisBarang', 'perbaikanItems.barang.jenisBarang'])
            ->findOrFail($pengajuan_id);

        return view('pengajuan.show', compact('pengajuan'));
    }

    public function edit(string $pengajuan_id)
    {
        $pengajuan = Pengajuan::with(['jenisBarang', 'perbaikanItems.barang'])
            ->findOrFail($pengajuan_id);

        // Only allow edit if status is 'menunggu'
        if ($pengajuan->status !== 'menunggu') {
            return redirect()
                ->route('pengajuan.index')
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah');
        }

        $jenisBarang = JenisBarang::orderBy('jenis')->get();

        return view('pengajuan.edit', compact('pengajuan', 'jenisBarang'));
    }

    public function update(Request $request, string $pengajuan_id)
    {
        $pengajuan = Pengajuan::with('perbaikanItems')->findOrFail($pengajuan_id);

        // Only allow update if status is 'menunggu'
        if ($pengajuan->status !== 'menunggu') {
            return redirect()
                ->route('pengajuan.index')
                ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah');
        }

        $validated = $request->validate([
            'tipe' => 'required|in:pembelian,perbaikan',
            'jenis_barang_id' => 'nullable|exists:jenis_barang,jenis_barang_id',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'estimasi_biaya' => 'required|integer|min:0',
            'alasan' => 'required|string',

            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'nullable|exists:barang,barang_id',
        ]);

        // Validation for perbaikan
        if ($validated['tipe'] === 'perbaikan') {
            if (empty($validated['jenis_barang_id'])) {
                return back()
                    ->withInput()
                    ->with('error', 'Jenis barang wajib dipilih untuk pengajuan perbaikan');
            }

            if (empty($validated['barang_ids']) || count($validated['barang_ids']) !== $validated['jumlah']) {
                return back()
                    ->withInput()
                    ->with('error', 'Jumlah barang yang dipilih harus sesuai dengan jumlah yang diinput');
            }
        }

        DB::beginTransaction();

        try {
            // Update Pengajuan
            $pengajuan->update([
                'jenis_barang_id' => $validated['tipe'] === 'perbaikan' ? $validated['jenis_barang_id'] : null,
                'nama_barang' => $validated['nama_barang'],
                'tipe' => $validated['tipe'],
                'jumlah' => $validated['jumlah'],
                'estimasi_biaya' => $validated['estimasi_biaya'],
                'alasan' => $validated['alasan'],
            ]);

            // Delete old items and create new ones for perbaikan
            $pengajuan->perbaikanItems()->delete();

            if ($validated['tipe'] === 'perbaikan' && !empty($validated['barang_ids'])) {
                foreach ($validated['barang_ids'] as $barangId) {
                    PengajuanPerbaikanItem::create([
                        'pengajuan_perbaikan_item_id' => (string) Str::uuid(),
                        'pengajuan_id' => $pengajuan->pengajuan_id,
                        'barang_id' => $barangId,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('pengajuan.index')
                ->with('success', 'Pengajuan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, string $pengajuan_id)
    {
        $pengajuan = Pengajuan::with('perbaikanItems.barang')->findOrFail($pengajuan_id);

        $validated = $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Update status
            $pengajuan->update([
                'status' => $validated['status'],
                'catatan' => $validated['catatan'] ?? null,
            ]);

            // If perbaikan + disetujui, create barang keluar automatically
            if ($pengajuan->tipe === 'perbaikan' && $validated['status'] === 'disetujui') {
                $this->createBarangKeluarFromPengajuan($pengajuan);
            }

            DB::commit();

            $message = $validated['status'] === 'disetujui'
                ? 'Pengajuan berhasil disetujui!'
                : 'Pengajuan berhasil ditolak!';

            return redirect()
                ->route('pengajuan.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createBarangKeluarFromPengajuan(Pengajuan $pengajuan)
    {
        // Create Barang Keluar
        $barangKeluar = BarangKeluar::create([
            'keluar_id' => (string) Str::uuid(),
            'jenis_barang_id' => $pengajuan->jenis_barang_id,
            'tanggal' => now(),
            'kategori' => 'sedang_diperbaiki',
            'penerima' => null,
            'jumlah' => $pengajuan->jumlah,
            'keterangan' => 'Otomatis dari pengajuan perbaikan: ' . $pengajuan->alasan,
        ]);

        // Create items and update barang kondisi
        foreach ($pengajuan->perbaikanItems as $item) {
            // Create pivot
            BarangKeluarItem::create([
                'keluar_item_id' => (string) Str::uuid(),
                'keluar_id' => $barangKeluar->keluar_id,
                'barang_id' => $item->barang_id,
            ]);

            // Update kondisi to 'diperbaiki'
            $item->barang->update(['kondisi' => 'diperbaiki']);
        }
    }

    public function destroy(string $pengajuan_id)
    {
        $pengajuan = Pengajuan::with('perbaikanItems')->findOrFail($pengajuan_id);

        // Only allow delete if status is 'menunggu' or 'ditolak'
        if ($pengajuan->status === 'disetujui') {
            return redirect()
                ->route('pengajuan.index')
                ->with('error', 'Pengajuan yang sudah disetujui tidak dapat dihapus');
        }

        DB::beginTransaction();

        try {
            // Cascade will handle deleting perbaikan items
            $pengajuan->delete();

            DB::commit();

            return redirect()
                ->route('pengajuan.index')
                ->with('success', 'Pengajuan berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}