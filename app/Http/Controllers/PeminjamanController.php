<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\Barang;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    protected FileStorageService $fileService;

    public function __construct(FileStorageService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $query = Peminjaman::with(['peminjamanBarang.barang.jenisBarang']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', "%{$search}%")
                    ->orWhereHas('peminjamanBarang.barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            switch ($request->status) {
                case 'dikembalikan':
                    $query->whereNotNull('tanggal_pengembalian');
                    break;

                case 'dipinjam':
                    $query->whereNull('tanggal_pengembalian');
                    break;
            }
        }

        if ($request->filled('tanggal_mulai')) {
            if ($request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal_peminjaman', [$request->tanggal_mulai, $request->tanggal_akhir]);
            } else {
                $query->whereDate('tanggal_peminjaman', $request->tanggal_mulai);
            }
        }

        $peminjaman = $query->orderBy('created_at', 'desc')
            ->paginate(10);

        foreach ($peminjaman as $item) {
            if ($item->foto_peminjaman) {
                $item->foto_peminjaman_url = $this->fileService->url($item->foto_peminjaman);
            }

            if ($item->foto_pengembalian) {
                $item->foto_pengembalian_url = $this->fileService->url($item->foto_pengembalian);
            }

            foreach ($item->peminjamanBarang as $detail) {
                if ($detail->barang && $detail->barang->gambar) {
                    $detail->barang->gambar_url = $this->fileService->url($detail->barang->gambar);
                }
            }
        }

        $totalPeminjaman = Peminjaman::count();
        $dipinjamCount = Peminjaman::whereNull('tanggal_pengembalian')->count();
        $dikembalikanCount = Peminjaman::whereNotNull('tanggal_pengembalian')->count();

        $totalBarangDipinjam = PeminjamanBarang::whereHas('peminjaman', function ($q) {
            $q->whereNull('tanggal_pengembalian');
        })
            ->distinct('barang_id')
            ->count('barang_id');

        return view('peminjaman.index', compact(
            'peminjaman',
            'totalPeminjaman',
            'dipinjamCount',
            'dikembalikanCount',
            'totalBarangDipinjam'
        ));
    }

    public function create()
    {
        $barang = Barang::with('jenisBarang')
            ->where('kondisi', 'baik')
            ->where('status', 'aktif')
            ->orderBy('nama_barang')
            ->get();

        return view('peminjaman.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'nama_peminjam' => 'required|string|max:255',
            'foto_peminjaman' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
            'barang_ids' => 'required|array|min:1',
            'barang_ids.*' => 'required|exists:barang,barang_id',
        ], [
            'foto_peminjaman.required' => 'Foto peminjaman wajib diisi',
            'foto_peminjaman.image' => 'File harus berupa gambar',
            'foto_peminjaman.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'foto_peminjaman.max' => 'Gambar tidak boleh lebih dari 5 MB',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman wajib diisi',
            'nama_peminjam.required' => 'Nama peminjam wajib diisi',
            'barang_ids.required' => 'Minimal pilih 1 barang',
            'barang_ids.*.exists' => 'Barang tidak ditemukan',
        ]);

        DB::beginTransaction();

        try {
            $fotoPeminjamanPath = $this->fileService->upload(
                $request->file('foto_peminjaman'),
                'peminjaman'
            );

            $peminjaman = Peminjaman::create([
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'nama_peminjam' => $validated['nama_peminjam'],
                'foto_peminjaman' => $fotoPeminjamanPath,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            foreach ($validated['barang_ids'] as $barangId) {
                $peminjaman->barang()->attach($barangId, [
                    'peminjaman_barang_id' => uuid_create(),
                    'status' => 'dipinjam',
                ]);

                $barang = Barang::find($barangId);
                $barang->update([
                    'kondisi' => 'dipinjam',
                ]);
            }

            DB::commit();

            flash('Peminjaman berhasil dicatat')->success();
            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data Peminjaman Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoPeminjamanPath)) {
                $this->fileService->delete($fotoPeminjamanPath);
            }

            flash('Terjadi kesalahan: ' . $e->getMessage())->error();
            return back()->withInput();
        }
    }

    public function show(string $peminjaman_id)
    {
        $peminjaman = Peminjaman::with(['peminjamanBarang.barang.jenisBarang'])
            ->findOrFail($peminjaman_id);

        if ($peminjaman->foto_peminjaman) {
            $peminjaman->foto_peminjaman_url = $this->fileService->url($peminjaman->foto_peminjaman);
        }

        if ($peminjaman->foto_pengembalian) {
            $peminjaman->foto_pengembalian_url = $this->fileService->url($peminjaman->foto_pengembalian);
        }

        foreach ($peminjaman->peminjamanBarang as $detail) {
            if ($detail->barang && $detail->barang->gambar) {
                $detail->barang->gambar_url = $this->fileService->url($detail->barang->gambar);
            }
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(string $peminjaman_id)
    {
        $peminjaman = Peminjaman::with(['peminjamanBarang.barang.jenisBarang'])
            ->findOrFail($peminjaman_id);

        if ($peminjaman->tanggal_pengembalian) {
            flash('Tidak dapat mengedit peminjaman yang sudah dikembalikan')->warning();
            return redirect()->route('peminjaman.show', $peminjaman_id);
        }

        if ($peminjaman->foto_peminjaman) {
            $peminjaman->foto_peminjaman_url = $this->fileService->url($peminjaman->foto_peminjaman);
        }

        foreach ($peminjaman->peminjamanBarang as $detail) {
            if ($detail->barang && $detail->barang->gambar) {
                $detail->barang->gambar_url = $this->fileService->url($detail->barang->gambar);
            }
        }

        $barang = Barang::with('jenisBarang')
            ->where('kondisi', 'baik')
            ->where('status', 'aktif')
            ->orderBy('nama_barang')
            ->get();

        foreach ($barang as $item) {
            if ($item->gambar) {
                $item->gambar_url = $this->fileService->url($item->gambar);
            }
        }

        return view('peminjaman.edit', compact('peminjaman', 'barang'));
    }

    public function update(Request $request, string $peminjaman_id)
    {
        $peminjaman = Peminjaman::with('peminjamanBarang')->findOrFail($peminjaman_id);

        if ($peminjaman->tanggal_pengembalian) {
            flash('Tidak dapat mengedit peminjaman yang sudah dikembalikan')->warning();
            return redirect()->route('peminjaman.show', $peminjaman_id);
        }

        $validated = $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'nama_peminjam' => 'required|string|max:255',
            'foto_peminjaman' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
            'barang_ids' => 'required|array|min:1',
            'barang_ids.*' => 'required|exists:barang,barang_id',
        ], [
            'foto_peminjaman.image' => 'File harus berupa gambar',
            'foto_peminjaman.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'foto_peminjaman.max' => 'Gambar tidak boleh lebih dari 5 MB',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman wajib diisi',
            'nama_peminjam.required' => 'Nama peminjam wajib diisi',
            'barang_ids.required' => 'Minimal pilih 1 barang',
        ]);

        DB::beginTransaction();

        try {
            $updateData = [
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'nama_peminjam' => $validated['nama_peminjam'],
                'keterangan' => $validated['keterangan'] ?? null,
            ];

            if ($request->hasFile('foto_peminjaman')) {
                if ($peminjaman->foto_peminjaman) {
                    $this->fileService->delete($peminjaman->foto_peminjaman);
                }
                $updateData['foto_peminjaman'] = $this->fileService->upload(
                    $request->file('foto_peminjaman'),
                    'peminjaman'
                );
            }

            $peminjaman->update($updateData);

            $currentBarangIds = $peminjaman->peminjamanBarang
                ->pluck('barang_id')
                ->toArray();

            $newBarangIds = $validated['barang_ids'];

            $removedBarangIds = array_diff($currentBarangIds, $newBarangIds);

            $addedBarangIds = array_diff($newBarangIds, $currentBarangIds);

            foreach ($removedBarangIds as $barangId) {
                $barang = Barang::find($barangId);
                if ($barang) {
                    $barang->update(['kondisi' => 'baik']);
                }

                PeminjamanBarang::where('peminjaman_id', $peminjaman_id)
                    ->where('barang_id', $barangId)
                    ->delete();
            }

            foreach ($addedBarangIds as $barangId) {
                PeminjamanBarang::create([
                    'peminjaman_barang_id' => uuid_create(),
                    'peminjaman_id' => $peminjaman_id,
                    'barang_id' => $barangId,
                    'status' => 'dipinjam',
                ]);

                $barang = Barang::find($barangId);
                if ($barang) {
                    $barang->update(['kondisi' => 'dipinjam']);
                }
            }

            DB::commit();

            flash('Peminjaman berhasil diperbarui')->success();
            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data Peminjaman Berhasil Diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            flash('Terjadi kesalahan: ' . $e->getMessage())->error();
            return back()->withInput();
        }
    }

    public function destroy(string $peminjaman_id)
    {
        $peminjaman = Peminjaman::with('peminjamanBarang.barang')->findOrFail($peminjaman_id);

        DB::beginTransaction();

        try {
            if (!$peminjaman->tanggal_pengembalian) {
                foreach ($peminjaman->peminjamanBarang as $detail) {
                    if ($detail->barang) {
                        $detail->barang->update(['kondisi' => 'baik']);
                    }
                }
            }

            if ($peminjaman->foto_peminjaman) {
                $this->fileService->delete($peminjaman->foto_peminjaman);
            }

            if ($peminjaman->foto_pengembalian) {
                $this->fileService->delete($peminjaman->foto_pengembalian);
            }

            $peminjaman->delete();

            DB::commit();

            flash('Peminjaman berhasil dihapus')->success();
            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data Peminjaman Berhasil Dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            flash('Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }

    public function kembalikanBarang(Request $request, string $peminjaman_id)
    {
        $peminjaman = Peminjaman::with('peminjamanBarang.barang')->findOrFail($peminjaman_id);

        if ($peminjaman->tanggal_pengembalian) {
            flash('Peminjaman sudah dikembalikan sebelumnya')->warning();
            return back();
        }

        $validated = $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'foto_pengembalian' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'keterangan' => 'nullable|string',
        ], [
            'tanggal_pengembalian.required' => 'Tanggal pengembalian wajib diisi',
            'foto_pengembalian.required' => 'Foto pengembalian wajib diisi',
            'foto_pengembalian.image' => 'File harus berupa gambar',
            'foto_pengembalian.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'foto_pengembalian.max' => 'Gambar tidak boleh lebih dari 5 MB',
        ]);

        DB::beginTransaction();

        try {
            $fotoPengembalianPath = $this->fileService->upload(
                $request->file('foto_pengembalian'),
                'pengembalian'
            );

            $peminjaman->update([
                'tanggal_pengembalian' => $validated['tanggal_pengembalian'],
                'foto_pengembalian' => $fotoPengembalianPath,
                'keterangan' => $validated['keterangan'] ?? $peminjaman->keterangan,
            ]);

            foreach ($peminjaman->peminjamanBarang as $detail) {
                $detail->update(['status' => 'dikembalikan']);

                if ($detail->barang) {
                    $detail->barang->update(['kondisi' => 'baik']);
                }
            }

            DB::commit();

            flash('Semua barang berhasil dikembalikan')->success();
            return redirect()->route('peminjaman.show', $peminjaman_id)
                ->with('success', 'Semua Barang Berhasil Dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($fotoPengembalianPath)) {
                $this->fileService->delete($fotoPengembalianPath);
            }

            flash('Terjadi kesalahan saat mengembalikan barang')->error();
            return back();
        }
    }
}