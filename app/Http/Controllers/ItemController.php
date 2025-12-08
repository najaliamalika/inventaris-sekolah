<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Services\FileStorageService;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    protected $fileService;

    public function __construct(FileStorageService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        $query = Item::query()->orderByDesc('updated_at');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%");
            });
        }

        $items = $query->paginate(10);

        $items->getCollection()->transform(function ($item) {
            if ($item->gambar) {
                $item->gambar = $this->fileService->url($item->gambar);
            }
            return $item;
        });

        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        /**
         * @var \App\Models\User|\Spatie\Permission\Traits\HasRoles $user
         */
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return view('item.create');
        } else {
            return view('item.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
                'nama_barang' => 'required|string|max:255',
                'jenis' => 'required|string',
                'merk' => 'required|string',
                'kondisi' => 'nullable|string|max:255',
                'stok' => 'nullable|integer',
                'satuan' => 'required|string',
                'lokasi' => 'nullable|string|max:255',
            ],
            [
                'gambar.max' => 'Gambar tidak boleh lebih dari 5 MB',
                'gambar.mimes' => 'Format gambar harus jpg, jpeg, atau png',
                'gambar.image' => 'File yang di-upload harus berupa gambar',

                'nama_barang.required' => 'Nama barang wajib diisi',
                'nama_barang.string' => 'Nama barang harus berupa teks',
                'nama_barang.max' => 'Nama barang tidak boleh lebih dari 255 karakter',

                'jenis.required' => 'Jenis barang wajib diisi',
                'jenis.string' => 'Jenis barang harus berupa teks',

                'merk.required' => 'Merk barang wajib diisi',
                'merk.string' => 'Merk barang harus berupa teks',

                'kondisi.string' => 'Kondisi barang harus berupa teks',
                'kondisi.max' => 'Kondisi barang tidak boleh lebih dari 255 karakter',

                'stok.integer' => 'Stok barang harus berupa angka',

                'satuan.required' => 'Satuan barang wajib diisi',
                'satuan.string' => 'Satuan barang harus berupa teks',

                'lokasi.string' => 'Lokasi barang harus berupa teks',
                'lokasi.max' => 'Lokasi barang tidak boleh lebih dari 255 karakter',
            ],
        );

        $newStore = [
            'item_id' => uuid_create(),
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'kondisi' => $request->kondisi ? $request->kondisi : null,
            'stok' => $request->stok ? $request->stok : null,
            'satuan' => $request->satuan,
            'lokasi' => $request->lokasi ? $request->lokasi : null,
        ];

        if ($request->hasFile('gambar')) {
            $newStore['gambar'] = $this->fileService->upload($request->file('gambar'), 'items');
        }

        $item = Item::create($newStore);

        flash('Item created successfully')->success();
        return redirect()->route('item.index')->with('success', 'Data Barang Berhasil ditambahkan!');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Item::find($id);
        if ($item->gambar) {
            $item->gambar = $this->fileService->url($item->gambar);
        }
        return view('item.update', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item_id)
    {
        $item = Item::findOrFail($item_id);
        $validated = $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:5048',
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string',
            'merk' => 'required|string',
            'kondisi' => 'nullable|string|max:255',
            'stok' => 'nullable|integer',
            'satuan' => 'required|string',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $updateData = [
            'nama_barang' => $validated['nama_barang'],
            'jenis' => $validated['jenis'],
            'merk' => $validated['merk'],
            'kondisi' => $validated['kondisi'],
            'stok' => $validated['stok'],
            'satuan' => $validated['satuan'],
            'lokasi' => $validated['lokasi'],
        ];
        if (isset($validated['gambar'])) {
            if ($item->gambar) {
                $this->fileService->delete($item->gambar);
            }
            $updateData['gambar'] = $this->fileService->upload($request->file('gambar'), 'items');
        }

        $item->update($updateData);

        flash('Item sukses diperbarui')->success();

        return redirect()->route('item.index')->with('success', 'Data Barang Berhasil Diperbarui!');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $item_id)
    {
        $item = Item::findOrFail($item_id);
        if ($item->gambar) {
            $this->fileService->delete($item->gambar);
        }
        $item->delete();
        flash('Item berhasil di hapus')->success();

        return redirect()->route('item.index');
    }
}
