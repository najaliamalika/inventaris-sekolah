<?php

namespace App\Http\Controllers;

use App\Models\ItemTemplate;
use Illuminate\Http\Request;

class ItemTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ItemTemplate::withCount('items')->orderByDesc('updated_at');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kategori', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('kode_utama', 'like', "%{$search}%");
            });
        }

        $itemTemplates = $query->paginate(10);

        return view('kategori-item.index', compact('itemTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'kategori' => 'required|string|max:255|unique:item_templates,kategori',
                'jenis' => 'required|string|max:255',
                'kode_utama' => 'nullable|string|max:255',
                'satuan' => 'required|string|max:255',
            ],
            [
                'kategori.required' => 'Kategori wajib diisi',
                'kategori.unique' => 'Kategori sudah terdaftar',
                'jenis.required' => 'Jenis wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
            ]
        );

        $validated['stok'] = 0;

        $validated['item_templates_id'] = uuid_create();

        ItemTemplate::create($validated);

        flash('Template item berhasil ditambahkan')->success();
        return redirect()->route('kategori-item.index')
            ->with('success', 'Template Item Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $item_template_id)
    {
        /** @var \App\Models\ItemTemplate $itemTemplate */
        $itemTemplate = ItemTemplate::with('items')->findOrFail($item_template_id);

        // Transform gambar URL untuk items
        if ($itemTemplate->items) {
            $itemTemplate->items->transform(function ($item) {
                if ($item->gambar) {
                    $item->gambar_url = asset('storage/' . $item->gambar);
                }
                return $item;
            });
        }

        return view('kategori-item.show', compact('itemTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $item_template_id)
    {
        $itemTemplate = ItemTemplate::findOrFail($item_template_id);
        return view('kategori-item.edit', compact('itemTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $item_template_id)
    {
        $itemTemplate = ItemTemplate::findOrFail($item_template_id);

        $validated = $request->validate(
            [
                'kategori' => 'required|string|max:255|unique:item_templates,kategori,' . $item_template_id . ',item_templates_id',
                'jenis' => 'required|string|max:255',
                'kode_utama' => 'nullable|string|max:255',
                'stok' => 'nullable|integer|min:0',
                'satuan' => 'required|string|max:255',
            ],
            [
                'kategori.required' => 'Kategori wajib diisi',
                'kategori.unique' => 'Kategori sudah terdaftar',
                'jenis.required' => 'Jenis wajib diisi',
                'satuan.required' => 'Satuan wajib diisi',
                'stok.integer' => 'Stok harus berupa angka',
                'stok.min' => 'Stok tidak boleh negatif',
            ]
        );

        $itemTemplate->update($validated);

        flash('Template item berhasil diperbarui')->success();
        return redirect()->route('kategori-item.index')
            ->with('success', 'Template Item Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $item_template_id)
    {
        $itemTemplate = ItemTemplate::findOrFail($item_template_id);

        // Cek apakah masih ada items yang menggunakan template ini
        if ($itemTemplate->items()->count() > 0) {
            flash('Template tidak dapat dihapus karena masih digunakan oleh ' . $itemTemplate->items()->count() . ' item')->error();
            return redirect()->route('kategori-item.index');
        }

        $itemTemplate->delete();

        flash('Template item berhasil dihapus')->success();
        return redirect()->route('kategori-item.index')
            ->with('success', 'Template Item Berhasil Dihapus!');
    }
}