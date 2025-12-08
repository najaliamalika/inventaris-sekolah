<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Kategori Item') }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Kelola kategori template untuk inventaris barang</p>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Search and Create Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <form action="{{ route('kategori-item.index') }}" method="GET" class="md:col-span-2 flex gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" placeholder="Cari berdasarkan kategori, jenis, atau kode"
                            value="{{ request('search') }}"
                            class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-white">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                </form>

                @hasrole('admin')
                    <div class="flex justify-end">
                        <a href="{{ route('kategori-item.create') }}"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 w-full md:w-auto justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Kategori
                        </a>
                    </div>
                @endhasrole
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                                <th class="w-16 px-6 py-4 text-left font-semibold text-sm">No</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Kategori</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Jenis</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Kode Utama</th>
                                <th class="w-24 px-6 py-4 text-center font-semibold text-sm">Stok</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Satuan</th>
                                <th class="w-32 px-6 py-4 text-center font-semibold text-sm">Jumlah Item</th>
                                <th class="w-28 px-6 py-4 text-center font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($itemTemplates as $index => $template)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $itemTemplates->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $template->kategori }}</p>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $template->jenis }}</td>

                                    <td class="px-6 py-4">
                                        @if ($template->kode_utama)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-medium bg-gray-100 text-gray-700">
                                                {{ $template->kode_utama }}
                                            </span>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <span
                                                class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-semibold text-sm">
                                                {{ $template->stok ?? 0 }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $template->satuan }}</td>

                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('kategori-item.show', $template->item_templates_id) }}"
                                            class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors font-semibold text-sm">
                                            {{ $template->items_count }} items
                                        </a>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kategori-item.show', $template->item_templates_id) }}"
                                                class="p-2.5 text-green-600 hover:bg-green-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Lihat">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('kategori-item.edit', $template->item_templates_id) }}"
                                                class="p-2.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                </svg>
                                            </a>

                                            <button x-data
                                                @click="$dispatch('open-modal', 'delete_template_{{ $template->item_templates_id }}')"
                                                class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-9l-1 1H5v2h14V4z" />
                                                </svg>
                                            </button>

                                            <x-confirm-modal id="delete_template_{{ $template->item_templates_id }}"
                                                message="Apakah Anda yakin ingin menghapus kategori {{ $template->kategori }}? Tindakan ini tidak dapat dibatalkan."
                                                okLabel="Hapus" cancelLabel="Batal" :url="route('kategori-item.destroy', $template->item_templates_id)"
                                                method="DELETE" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <p class="text-lg font-semibold text-gray-500 mb-2">Tidak Ada Data</p>
                                            <p class="text-sm text-gray-400 mb-6">Kategori item yang Anda cari tidak
                                                ditemukan</p>
                                            @hasrole('admin')
                                                <a href="{{ route('kategori-item.create') }}"
                                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm font-medium">
                                                    Tambah Kategori Pertama
                                                </a>
                                            @endhasrole
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-6 border-t border-gray-200 bg-gray-50">
                    {{ $itemTemplates->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
