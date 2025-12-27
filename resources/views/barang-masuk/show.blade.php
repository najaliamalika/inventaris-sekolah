<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Detail Barang Masuk') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Informasi lengkap barang masuk</p>
        </div>
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('barang-masuk.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium">{{ __('Kembali') }}</span>
        </a>

        <div class="flex gap-2">
            @hasrole('admin')
                <a href="{{ route('barang-masuk.edit', $barangMasuk->masuk_id) }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>

                <button x-data @click="$dispatch('open-modal', 'delete_item_{{ $barangMasuk->masuk_id }}')"
                    class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                    title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <x-confirm-modal id="delete_item_{{ $barangMasuk->masuk_id }}"
                    message="Apakah Anda yakin ingin menghapus barang masuk ini? Tindakan ini tidak dapat dibatalkan."
                    okLabel="Hapus" cancelLabel="Batal" :url="route('barang-masuk.destroy', $barangMasuk->masuk_id)" method="DELETE" />
            @endhasrole
        </div>
    </div>
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tanggal</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $barangMasuk->tanggal->format('d M Y') }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Kategori</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        @if ($barangMasuk->kategori == 'pembelian')
                            <span class="inline-flex items-center gap-1">
                                💰 Pembelian
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1">
                                🎁 Bantuan
                            </span>
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Supplier</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $barangMasuk->nama_supplier }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Jumlah</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($barangMasuk->total_jumlah) }} Item
                    </p>
                </div>
            </div>

            @if ($barangMasuk->keterangan)
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Keterangan</p>
                    <p class="text-gray-900 dark:text-gray-100">{{ $barangMasuk->keterangan }}</p>
                </div>
            @endif

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Nilai</p>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                        Rp {{ number_format($barangMasuk->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @foreach ($barangMasuk->details as $index => $detail)
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-semibold text-lg">
                            {{ $detail->jenisBarang->jenis }}
                        </h3>
                        <p class="text-blue-100 text-sm">
                            {{ $detail->jenisBarang->kategori }} • {{ $detail->jenisBarang->satuan }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-blue-100 text-sm">Jumlah</p>
                        <p class="text-white font-bold text-2xl">{{ $detail->jumlah }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Harga Satuan</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Subtotal</p>
                        <p class="text-lg font-semibold text-green-600 dark:text-green-400">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </p>
                    </div>

                    @if ($detail->keterangan)
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Keterangan</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $detail->keterangan }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        Detail Barang Individual ({{ $detail->barangItems->count() }} Unit)
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($detail->barangItems as $barang)
                            <div
                                class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1">
                                            {{ $barang->nama_barang }}
                                        </h5>
                                        @if ($barang->kode_barang)
                                            <p class="text-xs text-blue-600 dark:text-blue-400 font-mono">
                                                {{ $detail->jenisBarang->kode_utama . '' . $barang->kode_barang }}
                                            </p>
                                        @endif
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full
                                    {{ $barang->kondisi == 'baik'
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                        : ($barang->kondisi == 'diperbaiki'
                                            ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'
                                            : 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400') }}">
                                        {{ ucfirst($barang->kondisi) }}
                                    </span>
                                </div>

                                <div class="space-y-2">
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span class="font-medium">{{ $barang->merk }}</span>
                                    </div>

                                    @if ($barang->lokasi)
                                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $barang->lokasi }}</span>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
