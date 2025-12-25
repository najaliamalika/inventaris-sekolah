<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarItem;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['jenisBarang', 'items.barang']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('penerima', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('jenisBarang', function ($q) use ($search) {
                        $q->where('jenis', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        if ($request->filled('tanggal_mulai')) {
            if ($request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
            } else {
                $query->whereDate('tanggal', $request->tanggal_mulai);
            }
        }

        $barangKeluar = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Stats
        $totalBarangKeluar = BarangKeluar::count();
        $totalItemKeluar = BarangKeluar::sum('jumlah');
        $totalHabisPakai = BarangKeluar::where('kategori', 'habis_pakai')->sum('jumlah');
        $totalDiperbaiki = BarangKeluar::where('kategori', 'sedang_diperbaiki')->sum('jumlah');

        // Get jenis barang for filter
        $jenisBarangList = JenisBarang::orderBy('jenis')->get();

        return view('barang-keluar.index', compact(
            'barangKeluar',
            'totalBarangKeluar',
            'totalItemKeluar',
            'totalHabisPakai',
            'totalDiperbaiki',
            'jenisBarangList'
        ));
    }

    public function create()
    {
        $jenisBarang = JenisBarang::whereHas('barang', function ($q) {
            $q->where('status', 'aktif')->where('kondisi', 'baik');
        })->withCount([
                    'barang as stok_tersedia' => function ($q) {
                        $q->where('status', 'aktif')->where('kondisi', 'baik');
                    }
                ])->orderBy('jenis')->get();

        return view('barang-keluar.create', compact('jenisBarang'));
    }

    public function getAvailableBarang($jenisBarangId)
    {
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
            'tanggal' => 'required|date',
            'jenis_barang_id' => 'required|exists:jenis_barang,jenis_barang_id',
            'kategori' => 'required|in:habis_pakai,rusak,tidak_layak,sedang_diperbaiki,dihibahkan',
            'penerima' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',

            'barang_ids' => 'required|array|min:1',
            'barang_ids.*' => 'required|exists:barang,barang_id',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'jenis_barang_id.required' => 'Jenis barang wajib dipilih',
            'kategori.required' => 'Kategori wajib dipilih',
            'jumlah.required' => 'Jumlah wajib diisi',
            'barang_ids.required' => 'Minimal pilih 1 barang untuk dikeluarkan',
            'barang_ids.min' => 'Minimal pilih 1 barang',
        ]);

        // Validate jumlah matches selected barang count
        if (count($validated['barang_ids']) !== (int) $validated['jumlah']) {
            return back()
                ->withInput()
                ->with('error', 'Jumlah barang yang dipilih (' . count($validated['barang_ids']) . ') tidak sesuai dengan jumlah yang diinput (' . $validated['jumlah'] . ')');
        }

        DB::beginTransaction();

        try {
            // Create Barang Keluar
            $barangKeluar = BarangKeluar::create([
                'keluar_id' => (string) Str::uuid(),
                'jenis_barang_id' => $validated['jenis_barang_id'],
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'penerima' => $validated['penerima'] ?? null,
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Process each selected barang
            foreach ($validated['barang_ids'] as $barangId) {
                // Verify barang exists and is available
                $barang = Barang::where('barang_id', $barangId)
                    ->where('status', 'aktif')
                    ->where('kondisi', 'baik')
                    ->firstOrFail();

                // Create pivot record
                BarangKeluarItem::create([
                    'keluar_item_id' => (string) Str::uuid(),
                    'keluar_id' => $barangKeluar->keluar_id,
                    'barang_id' => $barang->barang_id,
                ]);

                // Handle based on kategori
                if ($validated['kategori'] === 'sedang_diperbaiki') {
                    // Update kondisi to diperbaiki (status tetap aktif)
                    $barang->update(['kondisi' => 'diperbaiki']);
                } else {
                    // Set status to nonaktif (soft delete)
                    $barang->update(['status' => 'nonaktif']);
                }
            }

            DB::commit();

            return redirect()
                ->route('barang-keluar.index')
                ->with('success', 'Data Barang Keluar Berhasil Ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $keluar_id)
    {
        $barangKeluar = BarangKeluar::with(['jenisBarang', 'items.barang.jenisBarang'])
            ->findOrFail($keluar_id);

        return view('barang-keluar.show', compact('barangKeluar'));
    }

    public function edit(string $keluar_id)
    {
        $barangKeluar = BarangKeluar::with(['jenisBarang', 'items.barang'])
            ->findOrFail($keluar_id);

        // Get available barang for the same jenis
        $jenisBarang = JenisBarang::whereHas('barang', function ($q) {
            $q->where('status', 'aktif')->where('kondisi', 'baik');
        })->withCount([
                    'barang as stok_tersedia' => function ($q) {
                        $q->where('status', 'aktif')->where('kondisi', 'baik');
                    }
                ])->orderBy('jenis')->get();

        return view('barang-keluar.edit', compact('barangKeluar', 'jenisBarang'));
    }

    public function update(Request $request, string $keluar_id)
    {
        $barangKeluar = BarangKeluar::with('items.barang')->findOrFail($keluar_id);

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_barang_id' => 'required|exists:jenis_barang,jenis_barang_id',
            'kategori' => 'required|in:habis_pakai,rusak,tidak_layak,sedang_diperbaiki,dihibahkan',
            'penerima' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',

            'barang_ids' => 'required|array|min:1',
            'barang_ids.*' => 'required|exists:barang,barang_id',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'jenis_barang_id.required' => 'Jenis barang wajib dipilih',
            'kategori.required' => 'Kategori wajib dipilih',
            'jumlah.required' => 'Jumlah wajib diisi',
        ]);

        // Validate jumlah matches selected barang count
        if (count($validated['barang_ids']) !== $validated['jumlah']) {
            return back()
                ->withInput()
                ->with('error', 'Jumlah barang yang dipilih tidak sesuai dengan jumlah yang diinput');
        }

        DB::beginTransaction();

        try {
            $oldKategori = $barangKeluar->kategori;

            // Restore old barang status/kondisi
            foreach ($barangKeluar->items as $item) {
                $barang = $item->barang;
                if ($barang) {
                    if ($oldKategori === 'sedang_diperbaiki' && $barang->kondisi === 'diperbaiki') {
                        // Restore kondisi to baik
                        $barang->update(['kondisi' => 'baik']);
                    } elseif ($oldKategori !== 'sedang_diperbaiki' && $barang->status === 'nonaktif') {
                        // Restore status to aktif
                        $barang->update(['status' => 'aktif']);
                    }
                }
            }

            // Update Barang Keluar
            $barangKeluar->update([
                'jenis_barang_id' => $validated['jenis_barang_id'],
                'tanggal' => $validated['tanggal'],
                'kategori' => $validated['kategori'],
                'penerima' => $validated['penerima'] ?? null,
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // Delete old items
            $barangKeluar->items()->delete();

            // Process new selected barang
            foreach ($validated['barang_ids'] as $barangId) {
                $barang = Barang::where('barang_id', $barangId)
                    ->where('status', 'aktif')
                    ->where('kondisi', 'baik')
                    ->firstOrFail();

                // Create pivot record
                BarangKeluarItem::create([
                    'keluar_item_id' => (string) Str::uuid(),
                    'keluar_id' => $barangKeluar->keluar_id,
                    'barang_id' => $barang->barang_id,
                ]);

                // Handle based on kategori
                if ($validated['kategori'] === 'sedang_diperbaiki') {
                    $barang->update(['kondisi' => 'diperbaiki']);
                } else {
                    $barang->update(['status' => 'nonaktif']);
                }
            }

            DB::commit();

            return redirect()
                ->route('barang-keluar.index')
                ->with('success', 'Data Barang Keluar Berhasil Diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(string $keluar_id)
    {
        $barangKeluar = BarangKeluar::with('items.barang')->findOrFail($keluar_id);

        DB::beginTransaction();

        try {
            // Restore barang status/kondisi
            foreach ($barangKeluar->items as $item) {
                $barang = $item->barang;
                if ($barang) {
                    if ($barangKeluar->kategori === 'sedang_diperbaiki' && $barang->kondisi === 'diperbaiki') {
                        // Restore kondisi to baik
                        $barang->update(['kondisi' => 'baik']);
                    } elseif ($barangKeluar->kategori !== 'sedang_diperbaiki' && $barang->status === 'nonaktif') {
                        // Restore status to aktif
                        $barang->update(['status' => 'aktif']);
                    }
                }
            }

            // Delete (cascade will handle items)
            $barangKeluar->delete();

            DB::commit();

            return redirect()
                ->route('barang-keluar.index')
                ->with('success', 'Data Barang Keluar Berhasil Dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function laporanBarangKeluar(Request $request)
    {
        $query = BarangKeluar::with(['jenisBarang', 'items.barang']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_barang_id')) {
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        $barangKeluar = $query->orderBy('tanggal', 'desc')->get();

        $totalItem = $barangKeluar->sum('jumlah');

        $jenisBarangList = JenisBarang::orderBy('jenis')->get();

        return view('barang-keluar.laporan', compact(
            'barangKeluar',
            'totalItem',
            'jenisBarangList'
        ));
    }
}