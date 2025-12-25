<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Detail Jenis Barang' . ' ' . $jenisBarang->jenis) }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Informasi lengkap daftar barang berjenis {{ $jenisBarang->jenis }}</p>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ route('jenis-barang.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 mb-8 group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium">{{ __('Kembali') }}</span>
            </a>

            <!-- Template Info Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-green-600 to-green-400 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-white">{{ $jenisBarang->jenis }}</h1>
                                <p class="text-green-100 mt-1">{{ $jenisBarang->kategori }}</p>
                            </div>
                        </div>
                        <a href="{{ route('jenis-barang.edit', $jenisBarang->jenis_barang_id) }}"
                            class="px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Jenis Barang
                        </a>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-blue-600">Kode Jenis Barang</p>
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $jenisBarang->kode_utama ?? '-' }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-green-600">Total Stok (Tersedia)</p>
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $jenisBarang->stok ?? 0 }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-purple-600">Satuan</p>
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-gray-900">{{ $jenisBarang->satuan }}</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- barang List -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900 flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            Daftar Barang dengan jenis {{ $jenisBarang->jenis }}
                        </h2>
                        <a href="{{ route('barang.create', $jenisBarang->jenis_barang_id) }}"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors duration-200 text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Barang
                        </a>
                    </div>
                </div>

                @if ($barang->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="w-16 px-6 py-4 text-left font-semibold text-sm text-gray-700">No</th>
                                    <th class="w-24 px-6 py-4 text-left font-semibold text-sm text-gray-700">Gambar
                                    </th>
                                    <th class="px-6 py-4 text-left font-semibold text-sm text-gray-700">Nama Barang
                                    </th>
                                    <th class="px-6 py-4 text-left font-semibold text-sm text-gray-700">Kode Barang</th>
                                    <th class="px-6 py-4 text-left font-semibold text-sm text-gray-700">Merk</th>
                                    <th class="px-6 py-4 text-left font-semibold text-sm text-gray-700">Kondisi</th>
                                    <th class="px-6 py-4 text-left font-semibold text-sm text-gray-700">Lokasi</th>
                                    <th class="w-32 px-6 py-4 text-center font-semibold text-sm text-gray-700">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($barang as $index => $barang)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $index + 1 }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <img src="{{ $barang->gambar_url ?? 'https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg' }}"
                                                alt="{{ $barang->nama_barang }}"
                                                class="w-14 h-14 object-cover rounded-lg border border-gray-200 shadow-sm" />
                                        </td>

                                        <td class="px-6 py-4">
                                            <p class="text-sm font-semibold text-gray-900">{{ $barang->nama_barang }}
                                            </p>
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($barang->kode_barang)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-gray-100 text-gray-700">
                                                    {{ $jenisBarang->kode_utama . '' . $barang->kode_barang }}
                                                </span>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $barang->merk }}</td>

                                        <td class="px-6 py-4 text-sm">
                                            @if ($barang->kondisi === 'baik')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                                    Baik
                                                </span>
                                            @elseif ($barang->kondisi === 'diperbaiki')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <span class="w-2 h-2 bg-yellow-600 rounded-full mr-2"></span>
                                                    Diperbaiki
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <span class="w-2 h-2 bg-red-600 rounded-full mr-2"></span>
                                                    Dipinjam
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $barang->lokasi ?? '-' }}</td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('barang.edit', [$jenisBarang->jenis_barang_id, $barang->barang_id]) }}"
                                                    class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                        <path
                                                            d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                    </svg>
                                                </a>

                                                <button type="button" x-data
                                                    @click="$dispatch('open-modal', 'delete_barang_{{ $barang->barang_id }}')"
                                                    class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Confirmation Modal -->
                                    <x-confirm-modal id="delete_barang_{{ $barang->barang_id }}"
                                        message="Apakah Anda yakin ingin menghapus barang '{{ $barang->nama_barang }}'?"
                                        okLabel="Hapus" cancelLabel="Batal" :url="route('barang.destroy', $barang->barang_id)" method="DELETE" />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-12 text-center">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-lg font-semibold text-gray-500 mb-2">Belum Ada Item</p>
                        <p class="text-sm text-gray-400 mb-6">Kategori ini belum memiliki item</p>
                        <a href="{{ route('barang.create') }}?template_id={{ $jenisBarang->jenis_barang_id }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Item Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
