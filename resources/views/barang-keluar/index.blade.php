<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Barang Keluar') }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Kelola semua transaksi barang keluar</p>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-orange-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $todayCount }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $monthlyCount }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $todayTotal }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 mb-1">Total Bulan Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $monthlyTotal }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Create Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <form action="{{ route('barang-keluar.index') }}" method="GET" class="md:col-span-2 flex gap-3">
                    <div class="relative flex-1">
                        <input type="text" name="search" 
                            placeholder="Cari berdasarkan keterangan, kategori atau nama barang"
                            value="{{ request('search') }}" 
                            class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-red-500 transition-all duration-200 hover:border-gray-300 bg-white">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                </form>

                <div class="flex justify-end">
                    <a href="{{ route('barang-keluar.create') }}"
                        class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 w-full md:w-auto justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Barang Keluar
                    </a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-red-600 to-red-500 text-white">
                                <th class="w-16 px-6 py-4 text-left font-semibold text-sm">No</th>
                                <th class="w-24 px-6 py-4 text-left font-semibold text-sm">Gambar</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Tanggal</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Nama Barang</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Jumlah</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Kategori</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Keterangan</th>
                                <th class="w-28 px-6 py-4 text-center font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($barangKeluar as $index => $keluar)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $barangKeluar->currentPage() * 10 - 10 + $index + 1 }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-start">
                                            <div class="relative inline-block">
                                                <img src="{{ $keluar->item->gambar ?? 'https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg' }}"
                                                    alt="{{ $keluar->item->nama_barang }}"
                                                    class="w-14 h-14 object-cover rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200" />
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($keluar->tanggal)->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-gray-900">{{ $keluar->item->nama_barang }}</p>
                                        <p class="text-xs text-gray-500">{{ $keluar->item->kode_barang }}</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ $keluar->jumlah }} {{ $keluar->item->satuan }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $kategoriColors = [
                                                'habis_pakai' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'dot' => 'bg-blue-600', 'label' => 'Habis Pakai'],
                                                'rusak' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'dot' => 'bg-red-600', 'label' => 'Rusak'],
                                                'tidak_layak' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'dot' => 'bg-orange-600', 'label' => 'Tidak Layak'],
                                                'sedang_diperbaiki' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-600', 'label' => 'Sedang Diperbaiki'],
                                                'dihibahkan' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'dot' => 'bg-purple-600', 'label' => 'Dihibahkan'],
                                            ];
                                            $kategori = $kategoriColors[$keluar->kategori] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'dot' => 'bg-gray-600', 'label' => ucfirst($keluar->kategori)];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $kategori['bg'] }} {{ $kategori['text'] }}">
                                            <span class="w-2 h-2 {{ $kategori['dot'] }} rounded-full mr-2"></span>
                                            {{ $kategori['label'] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span class="line-clamp-2">{{ $keluar->keterangan }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('barang-keluar.edit', $keluar->keluar_id) }}"
                                                class="p-2.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                    <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                </svg>
                                            </a>

                                            <button x-data 
                                                @click="$dispatch('open-modal', 'delete_keluar_{{ $keluar->keluar_id }}')"
                                                class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-9l-1 1H5v2h14V4z" />
                                                </svg>
                                            </button>

                                            <x-confirm-modal id="delete_keluar_{{ $keluar->keluar_id }}"
                                                message="Apakah Anda yakin ingin menghapus transaksi barang keluar ini? Tindakan ini tidak dapat dibatalkan."
                                                okLabel="Hapus" cancelLabel="Batal" 
                                                :url="route('barang-keluar.destroy', $keluar->keluar_id)" method="DELETE" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-lg font-semibold text-gray-500 mb-2">Tidak Ada Data</p>
                                            <p class="text-sm text-gray-400 mb-6">Belum ada transaksi barang keluar</p>
                                            <a href="{{ route('barang-keluar.create') }}"
                                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm font-medium">
                                                Tambah Barang Keluar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-6 border-t border-gray-200 bg-gray-50">
                    {{ $barangKeluar->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>