<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use App\Services\FileStorageService;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
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
        $query = JenisBarang::query()
            ->withCount([
                'barang as stok' => function ($q) {
                    $q->where('kondisi', 'baik')->where('status', 'aktif');
                }
            ])
            ->orderByDesc('updated_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('kode_utama', 'like', "%{$search}%");
            });
        }

        $jenisBarang = $query->paginate(10);

        return view('jenis-barang.index', compact('jenisBarang'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kategori' => 'required|string|max:255',
                'jenis' => 'required|string|max:255|unique:jenis_barang,jenis',
                'kode_utama' => 'nullable|string|max:255',
                'satuan' => 'required|string|max:255',
            ],
            [
                'kategori.required' => 'Kategori wajib diisi',
                'jenis.unique' => 'Jenis barang sudah terdaftar',
                'jenis.required' => 'Jenis wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
            ]
        );

        $validated['jenis_barang_id'] = uuid_create();

        JenisBarang::create($validated);

        flash('Jenis Barang berhasil ditambahkan')->success();
        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis Barang Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $jenis_barang_id)
    {
        $jenisBarang = JenisBarang::withCount([
            'barang as stok' => function ($q) {
                $q->where('kondisi', 'baik')->where('status', 'aktif');
            }
        ])->findOrFail($jenis_barang_id);

        $barang = $jenisBarang->barang()->where('status', 'aktif')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('jenis-barang.show', compact('jenisBarang', 'barang'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $item_template_id)
    {
        $jenisBarang = JenisBarang::findOrFail($item_template_id);
        return view('jenis-barang.edit', compact('jenisBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item_template_id)
    {
        $jenisBarang = JenisBarang::findOrFail($item_template_id);

        $validated = $request->validate(
            [
                'kategori' => 'required|string|max:255',
                'jenis' => 'required|string|max:255|unique:jenis_barang,jenis,' . $item_template_id . ',jenis_barang_id',
                'kode_utama' => 'nullable|string|max:255',
                'satuan' => 'required|string|max:255',
            ],
            [
                'kategori.required' => 'Kategori wajib diisi',
                'jenis.unique' => 'Jenis sudah terdaftar',
                'jenis.required' => 'Jenis wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
            ]
        );

        $jenisBarang->update($validated);

        flash('Jenis Barang berhasil diperbarui')->success();
        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis Barang Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $item_template_id)
    {
        $jenisBarang = JenisBarang::findOrFail($item_template_id);

        // Cek apakah masih ada barang yang menggunakan template ini
        if ($jenisBarang->barang()->count() > 0) {
            flash('Jenis Barang tidak dapat dihapus karena masih digunakan oleh ' . $jenisBarang->barang()->count() . ' item')->error();
            return redirect()->route('jenis-barang.index');
        }

        $jenisBarang->delete();

        flash('Jenis Barang berhasil dihapus')->success();
        return redirect()->route('jenis-barang.index')
            ->with('success', 'Jenis Barang Berhasil Dihapus!');
    }
}