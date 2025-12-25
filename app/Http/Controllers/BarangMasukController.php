<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\JenisBarang;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BarangMasukController extends Controller
{
    protected FileStorageService $fileService;

    public function __construct(FileStorageService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $query = BarangMasuk::with(['details.jenisBarang', 'details.barangItems']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_supplier', 'like', "%{$search}%")
                    ->orWhereHas('details.jenisBarang', function ($q) use ($search) {
                        $q->where('jenis', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('supplier')) {
            $query->where('nama_supplier', 'like', "%{$request->supplier}%");
        }

        if ($request->filled('tanggal_mulai')) {
            if ($request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
            } else {
                $query->whereDate('tanggal', $request->tanggal_mulai);
            }
        }

        $barangMasuk = $query->orderBy('tanggal', 'desc')
            ->paginate(10);

        $totalBarangMasuk = BarangMasuk::count();
        $totalItemMasuk = BarangMasukDetail::sum('jumlah');
        $totalNilaiPembelian = BarangMasuk::where('kategori', 'pembelian')->sum('total_harga');
        $totalNilaiBantuan = BarangMasuk::where('kategori', 'bantuan')->sum('total_harga');

        return view('barang-masuk.index', compact(
            'barangMasuk',
            'totalBarangMasuk',
            'totalItemMasuk',
            'totalNilaiPembelian',
            'totalNilaiBantuan'
        ));
    }

    public function create()
    {
        $jenisBarang = JenisBarang::orderBy('jenis')->get();
        return view('barang-masuk.create', compact('jenisBarang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pembelian,bantuan',
            'nama_supplier' => 'required|string|max:255',
            'keterangan' => 'nullable|string',

            'jenis_barang_ids' => 'required|array|min:1',
            'jenis_barang_ids.*' => 'required|exists:jenis_barang,jenis_barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|array',
            'harga_satuan.*' => 'nullable|integer|min:0',
            'keterangan_detail' => 'nullable|array',

            // Data barang individual
            'list_barang' => 'required|array|min:1',
            'list_barang.*.*.nama_barang' => 'required|string|max:255',
            'list_barang.*.*.kode_barang' => 'nullable|string|max:255',
            'list_barang.*.*.merk' => 'required|string|max:255',
            'list_barang.*.*.lokasi' => 'nullable|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'jenis_barang_ids.required' => 'Minimal pilih 1 jenis barang',
            'jenis_barang_ids.*.exists' => 'Jenis barang tidak ditemukan',
            'jumlah.required' => 'Jumlah barang wajib diisi',
            'jumlah.*.min' => 'Jumlah minimal 1',
            'list_barang.required' => 'Data barang wajib diisi',
            'list_barang.*.*.nama_barang.required' => 'Nama barang wajib diisi',
            'list_barang.*.*.merk.required' => 'Merk barang wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $barangMasuk = BarangMasuk::create([
                'masuk_id' => uuid_create(),
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'nama_supplier' => $validated['nama_supplier'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['jenis_barang_ids'] as $index => $jenisBarangId) {
                $jumlah = (int) $validated['jumlah'][$index];
                $hargaSatuan = isset($validated['harga_satuan'][$index]) ? (int) $validated['harga_satuan'][$index] : 0;

                $detail = BarangMasukDetail::create([
                    'detail_id' => uuid_create(),
                    'masuk_id' => $barangMasuk->masuk_id,
                    'jenis_barang_id' => $jenisBarangId,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                    'keterangan' => $validated['keterangan_detail'][$index] ?? null,
                ]);
                $listBarangForThisDetail = $validated['list_barang'][$index] ?? [];

                foreach ($listBarangForThisDetail as $barangData) {
                    Barang::create([
                        'barang_id' => uuid_create(),
                        'jenis_barang_id' => $jenisBarangId,
                        'detail_id' => $detail->detail_id,
                        'nama_barang' => $barangData['nama_barang'],
                        'kode_barang' => $barangData['kode_barang'] ?? null,
                        'merk' => $barangData['merk'],
                        'kondisi' => 'baik',
                        'lokasi' => $barangData['lokasi'] ?? null,
                    ]);
                }
            }

            // Update total
            $barangMasuk->hitungTotal();

            DB::commit();

            flash('Barang masuk berhasil dicatat')->success();
            return redirect()
                ->route('barang-masuk.index')
                ->with('success', 'Data Barang Masuk Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            flash('Terjadi kesalahan: ' . $e->getMessage())->error();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $masuk_id)
    {
        $barangMasuk = BarangMasuk::with(['details.jenisBarang', 'details.barangItems'])
            ->findOrFail($masuk_id);

        return view('barang-masuk.show', compact('barangMasuk'));
    }

    public function edit(string $masuk_id)
    {
        $barangMasuk = BarangMasuk::with(['details.jenisBarang', 'details.barangItems'])
            ->findOrFail($masuk_id);

        $jenisBarang = JenisBarang::orderBy('jenis')->get();

        return view('barang-masuk.edit', compact('barangMasuk', 'jenisBarang'));
    }

    public function update(Request $request, string $masuk_id)
    {
        $barangMasuk = BarangMasuk::with('details.barangItems')->findOrFail($masuk_id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kategori' => 'required|in:pembelian,bantuan',
            'nama_supplier' => 'required|string|max:255',
            'keterangan' => 'nullable|string',

            'jenis_barang_ids' => 'required|array|min:1',
            'jenis_barang_ids.*' => 'required|exists:jenis_barang,jenis_barang_id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'required|integer|min:1',
            'harga_satuan' => 'nullable|array',
            'harga_satuan.*' => 'nullable|integer|min:0',
            'keterangan_detail' => 'nullable|array',
            'keterangan_detail.*' => 'nullable|string',
            'detail_ids' => 'nullable|array',
            'detail_ids.*' => 'nullable|string',

            // Barang items
            'barang_ids' => 'nullable|array',
            'barang_ids.*' => 'nullable|array',
            'list_barang' => 'nullable|array',
            'list_barang.*' => 'nullable|array',
            'list_barang.*.*' => 'nullable|array',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'kategori.required' => 'Kategori wajib dipilih',
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'jenis_barang_ids.required' => 'Minimal pilih 1 jenis barang',
        ]);

        DB::beginTransaction();

        try {
            // Update Barang Masuk Header
            $barangMasuk->update([
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'nama_supplier' => $validated['nama_supplier'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Get existing detail IDs
            $existingDetailIds = $validated['detail_ids'] ?? [];
            $currentDetailIds = $barangMasuk->details->pluck('detail_id')->toArray();

            // Delete removed details (cascade will handle barang items)
            $removedDetailIds = array_diff($currentDetailIds, $existingDetailIds);
            if (!empty($removedDetailIds)) {
                BarangMasukDetail::whereIn('detail_id', $removedDetailIds)->delete();
            }

            // Process each detail
            foreach ($validated['jenis_barang_ids'] as $index => $jenisBarangId) {
                $detailId = $existingDetailIds[$index] ?? null;
                $jumlah = $validated['jumlah'][$index];
                $hargaSatuan = $validated['harga_satuan'][$index] ?? 0;
                $subtotal = $jumlah * $hargaSatuan;

                // Check if this is an update or create
                if ($detailId && in_array($detailId, $currentDetailIds)) {
                    // UPDATE existing detail
                    $detail = BarangMasukDetail::find($detailId);

                    if ($detail) {
                        $detail->update([
                            'jenis_barang_id' => $jenisBarangId,
                            'jumlah' => $jumlah,
                            'harga_satuan' => $hargaSatuan,
                            'subtotal' => $subtotal,
                            'keterangan' => $validated['keterangan_detail'][$index] ?? null,
                        ]);

                        // Handle barang items for this detail
                        $this->updateBarangItems($detail, $index, $validated, $jenisBarangId);
                    }
                } else {
                    // CREATE new detail
                    $detail = BarangMasukDetail::create([
                        'detail_id' => (string) Str::uuid(),
                        'masuk_id' => $barangMasuk->masuk_id,
                        'jenis_barang_id' => $jenisBarangId,
                        'jumlah' => $jumlah,
                        'harga_satuan' => $hargaSatuan,
                        'subtotal' => $subtotal,
                        'keterangan' => $validated['keterangan_detail'][$index] ?? null,
                    ]);

                    // Create barang items for new detail
                    $this->createBarangItems($detail, $index, $validated, $jenisBarangId);
                }
            }

            // Recalculate totals
            $barangMasuk->hitungTotal();

            DB::commit();

            return redirect()
                ->route('barang-masuk.index')
                ->with('success', 'Data Barang Masuk Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating barang masuk: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(string $masuk_id)
    {
        $barangMasuk = BarangMasuk::with('details.barangItems')->findOrFail($masuk_id);

        DB::beginTransaction();

        try {
            // Cascade will handle deleting details and barang items
            $barangMasuk->delete();

            DB::commit();

            return redirect()
                ->route('barang-masuk.index')
                ->with('success', 'Data Barang Masuk Berhasil Dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyDetail(string $detail_id)
    {
        $detail = BarangMasukDetail::with('barangItems')->findOrFail($detail_id);

        DB::beginTransaction();

        try {
            $masukId = $detail->masuk_id;

            // Cascade will handle deleting barang items
            $detail->delete();

            // Update total
            $barangMasuk = BarangMasuk::find($masukId);
            if ($barangMasuk) {
                $barangMasuk->hitungTotal();
            }

            DB::commit();

            return redirect()
                ->route('barang-masuk.show', $masukId)
                ->with('success', 'Detail Barang Berhasil Dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function laporanBarangMasuk(Request $request)
    {
        $query = BarangMasuk::with(['details.jenisBarang']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('supplier')) {
            $query->where('nama_supplier', 'like', "%{$request->supplier}%");
        }

        $barangMasuk = $query->orderBy('tanggal', 'desc')->get();

        $totalItem = $barangMasuk->sum('total_jumlah');
        $totalNilai = $barangMasuk->sum('total_harga');

        return view('barang-masuk.laporan', compact(
            'barangMasuk',
            'totalItem',
            'totalNilai'
        ));
    }

    private function updateBarangItems($detail, $index, $validated, $jenisBarangId)
    {
        $existingBarangIds = $validated['barang_ids'][$index] ?? [];
        $currentBarangIds = $detail->barangItems->pluck('barang_id')->toArray();

        $removedBarangIds = array_diff($currentBarangIds, $existingBarangIds);
        if (!empty($removedBarangIds)) {
            Barang::whereIn('barang_id', $removedBarangIds)->delete();
        }

        $listBarangForThisDetail = $validated['list_barang'][$index] ?? [];

        foreach ($listBarangForThisDetail as $barangIndex => $barangData) {
            if (!isset($barangData['nama_barang']) || !isset($barangData['merk'])) {
                continue;
            }

            $barangId = $existingBarangIds[$barangIndex] ?? null;

            if ($barangId && in_array($barangId, $currentBarangIds)) {
                $barang = Barang::find($barangId);
                if ($barang) {
                    $barang->update([
                        'nama_barang' => $barangData['nama_barang'],
                        'kode_barang' => $barangData['kode_barang'] ?? null,
                        'merk' => $barangData['merk'],
                        'lokasi' => $barangData['lokasi'] ?? null,
                    ]);
                }
            } else {
                Barang::create([
                    'barang_id' => (string) Str::uuid(),
                    'jenis_barang_id' => $jenisBarangId,
                    'detail_id' => $detail->detail_id,
                    'nama_barang' => $barangData['nama_barang'],
                    'kode_barang' => $barangData['kode_barang'] ?? null,
                    'merk' => $barangData['merk'],
                    'kondisi' => 'baik',
                    'lokasi' => $barangData['lokasi'] ?? null,
                ]);
            }
        }
    }

    private function createBarangItems($detail, $index, $validated, $jenisBarangId)
    {
        $listBarangForThisDetail = $validated['list_barang'][$index] ?? [];

        foreach ($listBarangForThisDetail as $barangData) {
            if (!isset($barangData['nama_barang']) || !isset($barangData['merk'])) {
                continue;
            }

            Barang::create([
                'barang_id' => (string) Str::uuid(),
                'jenis_barang_id' => $jenisBarangId,
                'detail_id' => $detail->detail_id,
                'nama_barang' => $barangData['nama_barang'],
                'kode_barang' => $barangData['kode_barang'] ?? null,
                'merk' => $barangData['merk'],
                'kondisi' => 'baik',
                'lokasi' => $barangData['lokasi'] ?? null,
            ]);
        }
    }
}