<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Item;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MasukController extends Controller
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
        $query = BarangMasuk::with('item')->orderByDesc('tanggal');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', '%' . $search . '%')
                    ->orWhere('nama_supplier', 'like', '%' . $search . '%')
                    ->orWhere('kategori', 'like', '%' . $search . '%')
                    ->orWhereHas('item', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', '%' . $search . '%')
                            ->orWhere('kode_barang', 'like', '%' . $search . '%');
                    });
            });
        }

        $barangMasuk = $query->paginate(10);

        $barangMasuk->getCollection()->transform(function ($masuk) {
            if ($masuk->item->gambar) {
                $masuk->item->gambar = $this->fileService->url($masuk->item->gambar);
            }
            return $masuk;
        });

        // Statistics
        $todayCount = BarangMasuk::whereDate('tanggal', Carbon::today())->count();
        $monthlyCount = BarangMasuk::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $todayTotal = BarangMasuk::whereDate('tanggal', Carbon::today())->sum('jumlah');
        $monthlyTotal = BarangMasuk::whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('jumlah');

        return view('barang-masuk.index', compact('barangMasuk', 'todayCount', 'monthlyCount', 'todayTotal', 'monthlyTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::orderBy('nama_barang')->get();
        return view('barang-masuk.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'tanggal' => 'required|date',
            'kode_barang' => 'nullable|string|max:20',
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string',
            'merk' => 'required|string',
            'kondisi' => 'nullable|string|max:255',
            'satuan' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kategori' => 'required|in:pembelian,bantuan',
            'harga_satuan' => 'nullable|integer|min:0',
            'nama_supplier' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ];

        $messages = [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Tipe data tanggal harus date',
            'kode_barang.string' => 'Kode barang harus berupa teks',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 20 karakter',
            'nama_barang.required' => 'Nama barang wajib diisi',
            'nama_barang.string' => 'Nama barang harus berupa teks',
            'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter',
            'jenis.required' => 'Jenis barang wajib diisi',
            'jenis.string' => 'Jenis barang harus berupa teks',
            'merk.required' => 'Merk barang wajib diisi',
            'merk.string' => 'Merk barang harus berupa teks',
            'kondisi.string' => 'Kondisi barang harus berupa teks',
            'kondisi.max' => 'Kondisi barang tidak boleh lebih dari 255 karakter',
            'satuan.required' => 'Satuan barang wajib diisi',
            'satuan.string' => 'Satuan barang harus berupa teks',
            'lokasi.string' => 'Lokasi barang harus berupa teks',
            'lokasi.max' => 'Lokasi barang tidak boleh lebih dari 255 karakter',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif',
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_supplier.string' => 'Nama supplier harus berupa teks',
            'nama_supplier.max' => 'Nama supplier tidak boleh lebih dari 255 karakter',
            'keterangan.required' => 'Keterangan wajib diisi',
            'keterangan.string' => 'Keterangan harus berupa teks',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',
            'gambar.image' => 'File yang di-upload harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'gambar.max' => 'Gambar tidak boleh lebih dari 5 MB',
        ];

        $validated = $request->validate($rules, $messages);

        // Check if item with same nama_barang already exists
        $existingItem = Item::where('nama_barang', $validated['nama_barang'])->first();

        if ($existingItem) {
            // Item exists - update stock
            $existingItem->increment('stok', $validated['jumlah']);
            $itemId = $existingItem->item_id;
        } else {
            // Item doesn't exist - create new item
            $itemData = [
                'item_id' => uuid_create(),
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $validated['nama_barang'],
                'jenis' => $validated['jenis'],
                'merk' => $validated['merk'],
                'kondisi' => $validated['kondisi'] ?? 'Baik',
                'stok' => $validated['jumlah'], // Set initial stock from jumlah
                'satuan' => $validated['satuan'],
                'lokasi' => $request->lokasi,
            ];

            if ($request->hasFile('gambar')) {
                $itemData['gambar'] = $this->fileService->upload($request->file('gambar'), 'items');
            }

            $item = Item::create($itemData);
            $itemId = $item->item_id;
        }

        // Create barang masuk record
        $barangMasukData = [
            'masuk_id' => uuid_create(),
            'tanggal' => $validated['tanggal'],
            'kode_barang' => $request->kode_barang,
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'item_id' => $itemId,
            'kategori' => $validated['kategori'],
            'harga_satuan' => $validated['harga_satuan'],
            'nama_supplier' => $validated['nama_supplier'],
        ];

        BarangMasuk::create($barangMasukData);

        flash('Barang masuk berhasil dibuat')->success();
        return redirect()->route('barang-masuk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barangMasuk = BarangMasuk::with('item')->findOrFail($id);
        
        if ($barangMasuk->item->gambar) {
            $barangMasuk->item->gambar = $this->fileService->url($barangMasuk->item->gambar);
        }

        return view('barang-masuk.show', compact('barangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $items = Item::orderBy('nama_barang')->get();

        return view('barang-masuk.update', compact('barangMasuk', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $masuk_id)
    {
        $barangMasuk = BarangMasuk::findOrFail($masuk_id);
        
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'kode_barang' => 'nullable|string|max:20',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
            'kategori' => 'required|in:pembelian,bantuan',
            'harga_satuan' => 'nullable|integer|min:0',
            'nama_supplier' => 'required|string|max:255',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Tipe data tanggal harus date',
            'kode_barang.string' => 'Kode barang harus berupa teks',
            'kode_barang.max' => 'Kode barang tidak boleh lebih dari 20 karakter',
            'jumlah.required' => 'Jumlah wajib diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah minimal 1',
            'keterangan.required' => 'Keterangan wajib diisi',
            'keterangan.string' => 'Keterangan harus berupa teks',
            'keterangan.max' => 'Keterangan tidak boleh lebih dari 255 karakter',
            'kategori.required' => 'Kategori wajib dipilih',
            'kategori.in' => 'Kategori tidak valid',
            'harga_satuan.integer' => 'Harga satuan harus berupa angka',
            'harga_satuan.min' => 'Harga satuan tidak boleh negatif',
            'nama_supplier.required' => 'Nama supplier wajib diisi',
            'nama_supplier.string' => 'Nama supplier harus berupa teks',
            'nama_supplier.max' => 'Nama supplier tidak boleh lebih dari 255 karakter',
        ]);

        // Calculate stock difference
        $oldJumlah = $barangMasuk->jumlah;
        $newJumlah = $validated['jumlah'];
        $difference = $newJumlah - $oldJumlah;

        $updateData = [
            'tanggal' => $validated['tanggal'],
            'kode_barang' => $validated['kode_barang'],
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'kategori' => $validated['kategori'],
            'harga_satuan' => $validated['harga_satuan'],
            'nama_supplier' => $validated['nama_supplier'],
        ];

        $barangMasuk->update($updateData);

        // Update item stock based on difference
        if ($difference != 0) {
            $item = Item::find($barangMasuk->item_id);
            if ($difference > 0) {
                $item->increment('stok', $difference);
            } else {
                $item->decrement('stok', abs($difference));
            }
        }

        flash('Barang masuk berhasil diperbarui')->success();
        return redirect()->route('barang-masuk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $masuk_id)
    {
        $barangMasuk = BarangMasuk::findOrFail($masuk_id);
        
        // Decrease item stock
        $item = Item::find($barangMasuk->item_id);
        $item->decrement('stok', $barangMasuk->jumlah);

        $barangMasuk->delete();
        
        flash('Barang masuk berhasil dihapus')->success();

        return redirect()->route('barang-masuk.index');
    }
}