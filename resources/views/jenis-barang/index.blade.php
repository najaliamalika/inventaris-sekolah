<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Data Barang') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Kelola barang inventaris berdasarkan jenis.</p>
        </div>
    </x-slot>

    <!-- Search and Create Section -->
    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Search Form -->
                <form action="{{ route('jenis-barang.index') }}" method="GET" class="lg:col-span-2 flex gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" placeholder="Cari berdasarkan kategori, jenis, atau kode"
                            value="{{ request('search') }}"
                            class="w-full px-4 py-3 pl-12 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span class="hidden sm:inline">Filter</span>
                    </button>
                </form>

                <!-- Create Button -->
                @hasrole('admin')
                    <div class="flex justify-end">
                        <a href="{{ route('jenis-barang.create') }}"
                            class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 w-full lg:w-auto justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="hidden sm:inline">Tambah Jenis Barang</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                    </div>
                @endhasrole
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                        <th class="px-4 py-4 text-left font-semibold text-sm">No</th>
                        <th class="px-4 py-4 text-left font-semibold text-sm">Jenis</th>
                        <th class="px-4 py-4 text-left font-semibold text-sm ">Kategori</th>
                        <th class="px-4 py-4 text-left font-semibold text-sm ">Kode Utama</th>
                        <th class="px-4 py-4 text-center font-semibold text-sm ">Stok</th>
                        <th class="px-4 py-4 text-left font-semibold text-sm ">Satuan</th>
                        <th class="px-4 py-4 text-center font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($jenisBarang as $index => $jenis)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $jenisBarang->firstItem() + $index }}
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">
                                            {{ $jenis->jenis }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300 ">
                                {{ $jenis->kategori }}
                            </td>

                            <td class="px-4 py-4">
                                @if ($jenis->kode_utama)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        {{ $jenis->kode_utama }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-semibold text-sm">
                                    {{ $jenis->stok ?? 0 }}
                                </span>
                            </td>

                            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ $jenis->satuan }}
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('jenis-barang.show', $jenis->jenis_barang_id) }}"
                                        class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all duration-200"
                                        title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    <a href="{{ route('jenis-barang.edit', $jenis->jenis_barang_id) }}"
                                        class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-all duration-200"
                                        title="Edit">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                            <path
                                                d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                        </svg>
                                    </a>

                                    <button x-data
                                        @click="$dispatch('open-modal', 'delete_template_{{ $jenis->jenis_barang_id }}')"
                                        class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all duration-200"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-9l-1 1H5v2h14V4z" />
                                        </svg>
                                    </button>

                                    <x-confirm-modal id="delete_template_{{ $jenis->jenis_barang_id }}"
                                        message="Apakah Anda yakin ingin menghapus jenis barang {{ $jenis->jenis }}?"
                                        okLabel="Hapus" cancelLabel="Batal" :url="route('jenis-barang.destroy', $jenis->jenis_barang_id)" method="DELETE" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-2">Tidak Ada
                                        Data</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">Kategori yang Anda cari
                                        tidak
                                        ditemukan</p>
                                    @hasrole('admin')
                                        <a href="{{ route('jenis-barang.create') }}"
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
        @if ($jenisBarang->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                {{ $jenisBarang->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
