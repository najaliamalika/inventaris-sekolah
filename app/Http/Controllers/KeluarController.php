<?php

namespace App\Http\Controllers;

use App\Models\BarangKeluar;
use App\Models\Item;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KeluarController extends Controller
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
        $query = BarangKeluar::with('item')->orderByDesc('tanggal');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhereHas('item', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kode_barang', 'like', '%' . $search . '%');
                    });
            });
        }

        $barangKeluar = $query->paginate(10);

        $barangKeluar->getCollection()->transform(function ($keluar) {
            if ($keluar->item->gambar) {
                $keluar->item->gambar = $this->fileService->url($keluar->item->gambar);
            }
            return $keluar;
        });

        // Statistics
        $todayCount = BarangKeluar::whereDate('tanggal', Carbon::today())->count();
        $monthlyCount = BarangKeluar::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $todayTotal = BarangKeluar::whereDate('tanggal', Carbon::today())->sum('jumlah');
        $monthlyTotal = BarangKeluar::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('jumlah');

        return view('barang-keluar.index', compact('barangKeluar', 'todayCount', 'monthlyCount', 'todayTotal', 'monthlyTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::where('stok', '>', 0)->orderBy('nama_barang')->get();
        return view('barang-keluar.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'tanggal' => 'required|date',
                'jumlah' => 'required|integer|min:1',
                'keterangan' => 'required|string|max:255',
                'item_id' => 'required|exists:items,item_id',
                'kategori' => 'required|in:habis_pakai,rusak,tidak_layak,sedang_diperbaiki,dihibahkan',
            ],
            [
                'tanggal.required' => 'Tanggal wajib diisi',
                'tanggal.date' => 'Tipe data tanggal harus date',

                'jumlah.required' => 'Jumlah wajib diisi',
                'jumlah.integer' => 'Jumlah harus berupa angka',
                'jumlah.min' => 'Jumlah minimal 1',

                'keterangan.required' => 'Keterangan wajib diisi',
                'keterangan.string' => 'Keterangan harus berupa teks',
                'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',

                'item_id.required' => 'Item wajib dipilih',
                'item_id.exists' => 'Item tidak ditemukan',

                'kategori.required' => 'Kategori wajib dipilih',
                'kategori.in' => 'Kategori tidak valid',
            ],
        );

        // Check if item has enough stock
        $item = Item::findOrFail($validated['item_id']);
        if ($item->stok < $validated['jumlah']) {
            return back()
                ->withErrors(['jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $item->stok])
                ->withInput();
        }

        $newStore = [
            'keluar_id' => uuid_create(),
            'tanggal' => $validated['tanggal'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'item_id' => $validated['item_id'],
            'kategori' => $validated['kategori'],
        ];

        BarangKeluar::create($newStore);

        // Decrease item stock
        $item->decrement('stok', $validated['jumlah']);

        flash('Barang keluar berhasil dibuat')->success();
        return redirect()->route('barang-keluar.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barangKeluar = BarangKeluar::with('item')->findOrFail($id);
        
        if ($barangKeluar->item->gambar) {
            $barangKeluar->item->gambar = $this->fileService->url($barangKeluar->item->gambar);
        }

        return view('barang-keluar.show', compact('barangKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $items = Item::orderBy('nama_barang')->get();

        return view('barang-keluar.update', compact('barangKeluar', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $keluar_id)
    {
        $barangKeluar = BarangKeluar::findOrFail($keluar_id);
        
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
            'kategori' => 'required|in:habis_pakai,rusak,tidak_layak,sedang_diperbaiki,dihibahkan',
        ]);

        // Calculate stock difference
        $oldJumlah = $barangKeluar->jumlah;
        $newJumlah = $validated['jumlah'];
        $difference = $newJumlah - $oldJumlah;

        // Check if item has enough stock for increase
        if ($difference > 0) {
            $item = Item::find($barangKeluar->item_id);
            if ($item->stok < $difference) {
                return back()
                    ->withErrors(['jumlah' => 'Stok tidak mencukupi untuk perubahan ini. Stok tersedia: ' . $item->stok])
                    ->withInput();
            }
        }

        $updateData = [
            'tanggal' => $validated['tanggal'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'kategori' => $validated['kategori'],
        ];

        $barangKeluar->update($updateData);

        // Update item stock based on difference
        if ($difference != 0) {
            $item = Item::find($barangKeluar->item_id);
            if ($difference > 0) {
                // More items going out, decrease stock
                $item->decrement('stok', $difference);
            } else {
                // Less items going out, increase stock
                $item->increment('stok', abs($difference));
            }
        }

        flash('Barang keluar sukses diperbarui')->success();

        return redirect()->route('barang-keluar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $keluar_id)
    {
        $barangKeluar = BarangKeluar::findOrFail($keluar_id);
        
        // Restore item stock
        $item = Item::find($barangKeluar->item_id);
        $item->increment('stok', $barangKeluar->jumlah);

        $barangKeluar->delete();
        
        flash('Barang keluar berhasil dihapus')->success();

        return redirect()->route('barang-keluar.index');
    }
}
