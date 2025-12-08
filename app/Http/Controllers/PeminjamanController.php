<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Peminjaman;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    protected $fileService;

    public function __construct(FileStorageService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with('item')->orderByDesc('tanggal_peminjaman');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_peminjam', 'like', '%' . $search . '%')
                    ->orWhere('keterangan', 'like', '%' . $search . '%')
                    ->orWhereHas('item', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kode_barang', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by tanggal_peminjaman
        if ($request->has('tanggal_peminjaman_dari') && $request->tanggal_peminjaman_dari != '') {
            $query->whereDate('tanggal_peminjaman', '>=', $request->tanggal_peminjaman_dari);
        }
        if ($request->has('tanggal_peminjaman_sampai') && $request->tanggal_peminjaman_sampai != '') {
            $query->whereDate('tanggal_peminjaman', '<=', $request->tanggal_peminjaman_sampai);
        }

        // Filter by tanggal_pengembalian
        if ($request->has('tanggal_pengembalian_dari') && $request->tanggal_pengembalian_dari != '') {
            $query->whereDate('tanggal_pengembalian', '>=', $request->tanggal_pengembalian_dari);
        }
        if ($request->has('tanggal_pengembalian_sampai') && $request->tanggal_pengembalian_sampai != '') {
            $query->whereDate('tanggal_pengembalian', '<=', $request->tanggal_pengembalian_sampai);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->paginate(10);

        $peminjaman->getCollection()->transform(function ($pinjam) {
            if ($pinjam->item->gambar) {
                $pinjam->item->gambar = $this->fileService->url($pinjam->item->gambar);
            }
            if ($pinjam->foto_peminjaman) {
                $pinjam->foto_peminjaman = $this->fileService->url($pinjam->foto_peminjaman);
            }
            if ($pinjam->foto_pengembalian) {
                $pinjam->foto_pengembalian = $this->fileService->url($pinjam->foto_pengembalian);
            }
            return $pinjam;
        });

        // Statistics
        $todayCount = Peminjaman::whereDate('tanggal_peminjaman', Carbon::today())->count();
        $monthlyCount = Peminjaman::whereMonth('tanggal_peminjaman', Carbon::now()->month)
            ->whereYear('tanggal_peminjaman', Carbon::now()->year)
            ->count();
        $dipinjamCount = Peminjaman::where('status', 'dipinjam')->count();
        $dikembalikanCount = Peminjaman::where('status', 'dikembalikan')->count();

        return view('peminjaman.index', compact('peminjaman', 'todayCount', 'monthlyCount', 'dipinjamCount', 'dikembalikanCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('peminjaman.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'tanggal_peminjaman' => 'required|date',
                'nama_peminjam' => 'required|string|max:255',
                'foto_peminjaman' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'jumlah' => 'required|integer|min:1',
                'keterangan' => 'required|string|max:255',
                'item_id' => 'required|exists:items,item_id',
            ],
            [
                'tanggal_peminjaman.required' => 'Tanggal peminjaman wajib diisi',
                'tanggal_peminjaman.date' => 'Tanggal peminjaman harus berupa tanggal yang valid',

                'nama_peminjam.required' => 'Nama peminjam wajib diisi',
                'nama_peminjam.string' => 'Nama peminjam harus berupa teks',
                'nama_peminjam.max' => 'Nama peminjam tidak boleh lebih dari 255 karakter',

                'foto_peminjaman.required' => 'Foto peminjaman wajib diupload',
                'foto_peminjaman.image' => 'File harus berupa gambar',
                'foto_peminjaman.mimes' => 'Format gambar harus jpg, jpeg, atau png',
                'foto_peminjaman.max' => 'Ukuran gambar tidak boleh lebih dari 5 MB',

                'jumlah.required' => 'Jumlah wajib diisi',
                'jumlah.integer' => 'Jumlah harus berupa angka',
                'jumlah.min' => 'Jumlah minimal 1',

                'keterangan.required' => 'Keterangan wajib diisi',
                'keterangan.string' => 'Keterangan harus berupa teks',
                'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',

                'item_id.required' => 'Item wajib dipilih',
                'item_id.exists' => 'Item tidak ditemukan',
            ],
        );

        // Cek stok barang
        $item = Item::findOrFail($request->item_id);
        if ($item->stok < $request->jumlah) {
            flash('Stok barang tidak mencukupi. Stok tersedia: ' . $item->stok)->error();
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            $newStore = [
                'peminjaman_id' => uuid_create(),
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
                'nama_peminjam' => $request->nama_peminjam,
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'item_id' => $request->item_id,
                'status' => 'dipinjam',
            ];

            // Upload foto peminjaman
            if ($request->hasFile('foto_peminjaman')) {
                $newStore['foto_peminjaman'] = $this->fileService->upload($request->file('foto_peminjaman'), 'peminjaman');
            }

            // Create peminjaman
            $peminjaman = Peminjaman::create($newStore);

            // Kurangi stok barang
            $item->decrement('stok', $request->jumlah);

            DB::commit();

            flash('Peminjaman berhasil dibuat')->success();
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($newStore['foto_peminjaman'])) {
                $this->fileService->delete($newStore['foto_peminjaman']);
            }
            flash('Terjadi kesalahan saat membuat peminjaman')->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with('item')->findOrFail($id);
        
        if ($peminjaman->item->gambar) {
            $peminjaman->item->gambar = $this->fileService->url($peminjaman->item->gambar);
        }
        if ($peminjaman->foto_peminjaman) {
            $peminjaman->foto_peminjaman = $this->fileService->url($peminjaman->foto_peminjaman);
        }
        if ($peminjaman->foto_pengembalian) {
            $peminjaman->foto_pengembalian = $this->fileService->url($peminjaman->foto_pengembalian);
        }

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman::with('item')->findOrFail($id);
        $items = Item::orderBy('nama_barang')->get();

        if ($peminjaman->foto_peminjaman) {
            $peminjaman->foto_peminjaman_url = $this->fileService->url($peminjaman->foto_peminjaman);
        }
        if ($peminjaman->foto_pengembalian) {
            $peminjaman->foto_pengembalian_url = $this->fileService->url($peminjaman->foto_pengembalian);
        }

        return view('peminjaman.update', compact('peminjaman', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);
        
        $validated = $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'nama_peminjam' => 'required|string|max:255',
            'foto_peminjaman' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
            'foto_pengembalian' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:tanggal_peminjaman',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'nama_peminjam' => $validated['nama_peminjam'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'],
                'status' => $validated['status'],
            ];

            // Handle foto peminjaman
            if ($request->hasFile('foto_peminjaman')) {
                if ($peminjaman->foto_peminjaman) {
                    $this->fileService->delete($peminjaman->foto_peminjaman);
                }
                $updateData['foto_peminjaman'] = $this->fileService->upload($request->file('foto_peminjaman'), 'peminjaman');
            }

            // Handle pengembalian
            if ($validated['status'] === 'dikembalikan') {
                $updateData['tanggal_pengembalian'] = $validated['tanggal_pengembalian'] ?? now();
                
                // Upload foto pengembalian jika ada
                if ($request->hasFile('foto_pengembalian')) {
                    if ($peminjaman->foto_pengembalian) {
                        $this->fileService->delete($peminjaman->foto_pengembalian);
                    }
                    $updateData['foto_pengembalian'] = $this->fileService->upload($request->file('foto_pengembalian'), 'peminjaman');
                }

                // Tambah stok kembali jika status berubah dari dipinjam ke dikembalikan
                if ($peminjaman->status === 'dipinjam') {
                    $item = Item::findOrFail($peminjaman->item_id);
                    $item->increment('stok', $peminjaman->jumlah);
                }
            } else {
                // Jika status berubah dari dikembalikan ke dipinjam, kurangi stok lagi
                if ($peminjaman->status === 'dikembalikan') {
                    $item = Item::findOrFail($peminjaman->item_id);
                    if ($item->stok < $validated['jumlah']) {
                        throw new \Exception('Stok barang tidak mencukupi');
                    }
                    $item->decrement('stok', $validated['jumlah']);
                }
                
                // Clear tanggal dan foto pengembalian
                $updateData['tanggal_pengembalian'] = null;
                if ($peminjaman->foto_pengembalian) {
                    $this->fileService->delete($peminjaman->foto_pengembalian);
                    $updateData['foto_pengembalian'] = null;
                }
            }

            $peminjaman->update($updateData);

            DB::commit();

            flash('Peminjaman sukses diperbarui')->success();
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash('Terjadi kesalahan: ' . $e->getMessage())->error();
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        DB::beginTransaction();
        try {
            // Kembalikan stok jika status masih dipinjam
            if ($peminjaman->status === 'dipinjam') {
                $item = Item::findOrFail($peminjaman->item_id);
                $item->increment('stok', $peminjaman->jumlah);
            }

            // Delete files
            if ($peminjaman->foto_peminjaman) {
                $this->fileService->delete($peminjaman->foto_peminjaman);
            }
            if ($peminjaman->foto_pengembalian) {
                $this->fileService->delete($peminjaman->foto_pengembalian);
            }

            $peminjaman->delete();

            DB::commit();

            flash('Peminjaman berhasil dihapus')->success();
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            DB::rollBack();
            flash('Terjadi kesalahan saat menghapus peminjaman')->error();
            return redirect()->back();
        }
    }

    /**
     * Process pengembalian
     */
    public function pengembalian(Request $request, string $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        if ($peminjaman->status === 'dikembalikan') {
            flash('Barang sudah dikembalikan')->warning();
            return redirect()->back();
        }

        $validated = $request->validate([
            'foto_pengembalian' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'tanggal_pengembalian' => 'nullable|date|after_or_equal:' . $peminjaman->tanggal_peminjaman,
        ]);

        DB::beginTransaction();
        try {
            $updateData = [
                'status' => 'dikembalikan',
                'tanggal_pengembalian' => $validated['tanggal_pengembalian'] ?? now(),
            ];

            if ($request->hasFile('foto_pengembalian')) {
                $updateData['foto_pengembalian'] = $this->fileService->upload($request->file('foto_pengembalian'), 'peminjaman');
            }

            $peminjaman->update($updateData);

            // Tambah stok kembali
            $item = Item::findOrFail($peminjaman->item_id);
            $item->increment('stok', $peminjaman->jumlah);

            DB::commit();

            flash('Barang berhasil dikembalikan')->success();
            return redirect()->route('peminjaman.index');
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($updateData['foto_pengembalian'])) {
                $this->fileService->delete($updateData['foto_pengembalian']);
            }
            flash('Terjadi kesalahan saat memproses pengembalian')->error();
            return redirect()->back();
        }
    }
}