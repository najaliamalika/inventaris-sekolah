<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangTemplate;
use App\Models\JenisBarang;
use App\Models\PeminjamanBarang;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BarangController extends Controller
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
        $query = Barang::with('jenisBarang')->where('status', 'aktif')->orderByDesc('updated_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('BarangTemplate', function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $barang = $query->paginate(10);

        $barang->getCollection()->transform(function ($barang) {
            if ($barang->gambar) {
                $barang->gambar = $this->fileService->url($barang->gambar);
            }
            return $barang;
        });

        $jenisBarang = JenisBarang::all();

        return view('barang.index', compact('barang', 'jenisBarang'));
    }

    public function create(Request $request, string $jenis_barang_id)
    {
        $jenisBarang = JenisBarang::find($jenis_barang_id);

        return view('barang.create', compact('jenisBarang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'jenis_barang_id' => 'nullable|exists:jenis_barang,jenis_barang_id',
                'nama_barang' => 'required|string|max:255|unique:barang,nama_barang',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'kode_barang' => 'nullable|string|max:255',
                'merk' => 'required|string|max:255',
                'kondisi' => 'required|in:baik,diperbaiki,dipinjam',
                'lokasi' => 'nullable|string|max:255',
            ],
            [
                'gambar.max' => 'Gambar tidak boleh lebih dari 5 MB',
                'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png',
                'gambar.image' => 'File yang di-upload harus berupa gambar',
                'nama_barang.required' => 'Nama barang wajib diisi',
                'nama_barang.unique' => 'Nama barang sudah terdaftar',
                'merk.required' => 'Merk barang wajib diisi',
                'kondisi.required' => 'Kondisi barang wajib diisi',
                'kondisi.in' => 'Kondisi barang harus baik, diperbaiki, atau dipinjam',
                'jenis_barang_id.exists' => 'Template Barang tidak dBarangukan',
            ]
        );

        $newStore = [
            'barang_id' => uuid_create(),
            'jenis_barang_id' => $validated['jenis_barang_id'] ?? null,
            'nama_barang' => $validated['nama_barang'],
            'kode_barang' => $validated['kode_barang'] ?? null,
            'merk' => $validated['merk'],
            'kondisi' => $validated['kondisi'],
            'lokasi' => $validated['lokasi'] ?? null,
        ];

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $newStore['gambar'] = $this->fileService->upload($request->file('gambar'), 'barang');
        }

        Barang::create($newStore);

        flash('Barang berhasil ditambahkan')->success();
        return redirect()->route('jenis-barang.show', $validated['jenis_barang_id'])->with('success', 'Data Barang Berhasil ditambahkan!');
    }

    public function show(string $barang_id)
    {
        $barang = Barang::with('jenisBarang')->findOrFail($barang_id);

        if ($barang->gambar) {
            $barang->gambar_url = $this->fileService->url($barang->gambar);
        }

        return view('barang.show', compact('Barang'));
    }

    public function edit(string $jenis_barang_id, string $barang_id)
    {
        $barang = Barang::findOrFail($barang_id);
        $jenisBarang = JenisBarang::find($jenis_barang_id);

        if ($barang->gambar) {
            $barang->gambar_url = $this->fileService->url($barang->gambar);
        }

        return view('barang.edit', compact('barang', 'jenisBarang'));
    }

    public function update(Request $request, string $barang_id)
    {
        $barang = Barang::with('jenisBarang')->findOrFail($barang_id);

        $validated = $request->validate(
            [
                'jenis_barang_id' => 'nullable|exists:jenis_barang,jenis_barang_id',
                'nama_barang' => 'required|string|max:255|unique:barang,nama_barang,' . $barang_id . ',barang_id',
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'kode_barang' => 'nullable|string|max:255',
                'merk' => 'required|string|max:255',
                'kondisi' => 'required|in:baik,diperbaiki,dipinjam',
                'lokasi' => 'nullable|string|max:255',
            ],
            [
                'gambar.max' => 'Gambar tidak boleh lebih dari 5 MB',
                'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png',
                'gambar.image' => 'File yang di-upload harus berupa gambar',
                'nama_barang.required' => 'Nama barang wajib diisi',
                'nama_barang.unique' => 'Nama barang sudah terdaftar',
                'merk.required' => 'Merk barang wajib diisi',
                'kondisi.required' => 'Kondisi barang wajib diisi',
                'kondisi.in' => 'Kondisi barang harus baik, diperbaiki, atau dipinjam',
                'jenis_barang_id.exists' => 'Template Barang tidak dBarangukan',
            ]
        );

        $updateData = [
            'jenis_barang_id' => $validated['jenis_barang_id'] ?? null,
            'nama_barang' => $validated['nama_barang'],
            'kode_barang' => $validated['kode_barang'] ?? null,
            'merk' => $validated['merk'],
            'kondisi' => $validated['kondisi'],
            'lokasi' => $validated['lokasi'] ?? null,
        ];

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                $this->fileService->delete($barang->gambar);
            }
            $updateData['gambar'] = $this->fileService->upload($request->file('gambar'), 'barang');
        }

        $barang->update($updateData);

        flash('Barang berhasil diperbarui')->success();
        return redirect()->route(
            'jenis-barang.show',
            $barang->jenisBarang->jenis_barang_id
        )->with('success', 'Data Barang Berhasil Diperbarui!');

    }

    public function destroy(string $barang_id)
    {
        $barang = Barang::with('jenisBarang')->findOrFail($barang_id);

        $jenis_barang_id = $barang->jenisBarang->jenis_barang_id;

        if ($barang->gambar) {
            $this->fileService->delete($barang->gambar);
        }

        $barang->delete();

        flash('Barang berhasil dihapus')->success();
        return redirect()->route('jenis-barang.show', $jenis_barang_id)->with('success', 'Data Barang Berhasil Dihapus!');
    }
}