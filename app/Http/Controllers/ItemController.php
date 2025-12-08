<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemTemplate;
use App\Services\FileStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
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
        $query = Item::with('itemTemplate')->orderByDesc('updated_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                    ->orWhere('merk', 'like', "%{$search}%")
                    ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->whereHas('itemTemplate', function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }

        // Filter berdasarkan kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $items = $query->paginate(10);

        // Transform gambar URL
        $items->getCollection()->transform(function ($item) {
            if ($item->gambar) {
                $item->gambar = $this->fileService->url($item->gambar);
            }
            return $item;
        });

        $itemTemplates = ItemTemplate::all();

        return view('items.index', compact('items', 'itemTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $itemTemplates = ItemTemplate::all();
        $selectedTemplateId = $request->query('template_id');
        $selectedTemplate = null;

        if ($selectedTemplateId) {
            $selectedTemplate = ItemTemplate::find($selectedTemplateId);
        }

        return view('items.create', compact('itemTemplates', 'selectedTemplate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'item_templates_id' => 'nullable|exists:item_templates,item_templates_id',
                'nama_barang' => 'required|string|max:255|unique:items,nama_barang',
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
                'item_templates_id.exists' => 'Template item tidak ditemukan',
            ]
        );

        $newStore = [
            'item_id' => uuid_create(),
            'item_templates_id' => $validated['item_templates_id'] ?? null,
            'nama_barang' => $validated['nama_barang'],
            'kode_barang' => $validated['kode_barang'] ?? null,
            'merk' => $validated['merk'],
            'kondisi' => $validated['kondisi'],
            'lokasi' => $validated['lokasi'] ?? null,
        ];

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $newStore['gambar'] = $this->fileService->upload($request->file('gambar'), 'items');
        }

        // Update stok template jika ada
        if ($validated['item_templates_id']) {
            $template = ItemTemplate::find($validated['item_templates_id']);
            if ($template) {
                $template->increment('stok');
            }
        }

        Item::create($newStore);

        flash('Item berhasil ditambahkan')->success();
        return redirect()->route('items.index')->with('success', 'Data Item Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $item_id)
    {
        $item = Item::with('itemTemplate')->findOrFail($item_id);

        if ($item->gambar) {
            $item->gambar_url = $this->fileService->url($item->gambar);
        }

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $item_id)
    {
        $item = Item::findOrFail($item_id);
        $itemTemplates = ItemTemplate::all();

        if ($item->gambar) {
            $item->gambar_url = $this->fileService->url($item->gambar);
        }

        return view('items.edit', compact('item', 'itemTemplates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item_id)
    {
        $item = Item::findOrFail($item_id);

        $validated = $request->validate(
            [
                'item_templates_id' => 'nullable|exists:item_templates,item_templates_id',
                'nama_barang' => 'required|string|max:255|unique:items,nama_barang,' . $item_id . ',item_id',
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
                'item_templates_id.exists' => 'Template item tidak ditemukan',
            ]
        );

        $updateData = [
            'item_templates_id' => $validated['item_templates_id'] ?? null,
            'nama_barang' => $validated['nama_barang'],
            'kode_barang' => $validated['kode_barang'] ?? null,
            'merk' => $validated['merk'],
            'kondisi' => $validated['kondisi'],
            'lokasi' => $validated['lokasi'] ?? null,
        ];

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($item->gambar) {
                $this->fileService->delete($item->gambar);
            }
            $updateData['gambar'] = $this->fileService->upload($request->file('gambar'), 'items');
        }

        // Update stok template jika template berubah
        if ($item->item_templates_id != $validated['item_templates_id']) {
            // Kurangi stok template lama
            if ($item->item_templates_id) {
                $oldTemplate = ItemTemplate::find($item->item_templates_id);
                if ($oldTemplate && $oldTemplate->stok > 0) {
                    $oldTemplate->decrement('stok');
                }
            }

            // Tambah stok template baru
            if ($validated['item_templates_id']) {
                $newTemplate = ItemTemplate::find($validated['item_templates_id']);
                if ($newTemplate) {
                    $newTemplate->increment('stok');
                }
            }
        }

        $item->update($updateData);

        flash('Item berhasil diperbarui')->success();
        return redirect()->route('items.index')->with('success', 'Data Item Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $item_id)
    {
        $item = Item::findOrFail($item_id);

        // Hapus gambar jika ada
        if ($item->gambar) {
            $this->fileService->delete($item->gambar);
        }

        // Kurangi stok template jika ada
        if ($item->item_templates_id) {
            $template = ItemTemplate::find($item->item_templates_id);
            if ($template && $template->stok > 0) {
                $template->decrement('stok');
            }
        }

        $item->delete();

        flash('Item berhasil dihapus')->success();
        return redirect()->route('items.index')->with('success', 'Data Item Berhasil Dihapus!');
    }
}