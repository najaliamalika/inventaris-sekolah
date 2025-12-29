<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Barang Keluar') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Kelola data barang keluar (habis pakai, rusak,
                diperbaiki, dll)</p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Total Transaksi</p>
                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBarangKeluar }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 rounded-xl p-5 border border-orange-200 dark:border-orange-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-orange-600 dark:text-orange-400">Total Item Keluar</p>
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalItemKeluar) }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-green-600 dark:text-green-400">Habis Pakai</p>
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalHabisPakai) }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-5 border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Sedang Diperbaiki</p>
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalDiperbaiki) }}</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('barang-keluar.index') }}" method="GET" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cari
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Penerima atau keterangan..."
                                class="w-full px-4 py-2.5 pl-10 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <div id="searchLoading" class="hidden absolute right-3 top-3">
                                <svg class="animate-spin h-5 w-5 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kategori
                        </label>
                        <select name="kategori" id="kategoriSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            <option value="habis_pakai" {{ request('kategori') == 'habis_pakai' ? 'selected' : '' }}>
                                Habis Pakai</option>
                            <option value="rusak" {{ request('kategori') == 'rusak' ? 'selected' : '' }}>Rusak
                            </option>
                            <option value="tidak_layak" {{ request('kategori') == 'tidak_layak' ? 'selected' : '' }}>
                                Tidak Layak</option>
                            <option value="sedang_diperbaiki"
                                {{ request('kategori') == 'sedang_diperbaiki' ? 'selected' : '' }}>Sedang Diperbaiki
                            </option>
                            <option value="dihibahkan" {{ request('kategori') == 'dihibahkan' ? 'selected' : '' }}>
                                Dihibahkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Barang
                        </label>
                        <select name="jenis_barang_id" id="jenisBarangSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            @foreach ($jenisBarangList as $jenis)
                                <option value="{{ $jenis->jenis_barang_id }}"
                                    {{ request('jenis_barang_id') == $jenis->jenis_barang_id ? 'selected' : '' }}>
                                    {{ $jenis->jenis }} - {{ $jenis->kode_utama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Dari Tanggal
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggalMulaiInput"
                            value="{{ request('tanggal_mulai') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sampai Tanggal
                        </label>
                        <input type="date" name="tanggal_akhir" id="tanggalAkhirInput"
                            value="{{ request('tanggal_akhir') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    @if (request()->hasAny(['search', 'kategori', 'jenis_barang_id', 'tanggal_mulai', 'tanggal_akhir']))
                        <a href="{{ route('barang-keluar.index') }}"
                            class="px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif

                    @hasrole('admin')
                        <a href="{{ route('barang-keluar.create') }}"
                            class="ml-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Barang Keluar
                        </a>
                    @endhasrole
                </div>
            </form>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($barangKeluar->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                        <tr>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">No</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Tanggal</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Nama Barang</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Jenis Barang</th>
                            <th class="px-2 py-4 w-60 text-left text-xs font-semibold uppercase">Kategori</th>
                            <th class="px-2 py-4 text-center text-xs font-semibold uppercase">Jumlah</th>
                            <th class="px-2 py-4 text-center text-xs font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($barangKeluar as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $barangKeluar->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $item->tanggal->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $item->items->first()->barang->nama_barang . ($item->items->count() > 1 ? ' + ' . ($item->items->count() - 1) . ' lainnya' : '') }}
                                    </p>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $item->jenisBarang->jenis }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $item->jenisBarang->kategori }}
                                        </p>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if ($item->kategori == 'habis_pakai') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($item->kategori == 'rusak') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @elseif($item->kategori == 'tidak_layak') bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-400
                                        @elseif($item->kategori == 'sedang_diperbaiki') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                        @else bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @endif">
                                        {{ $item->kategori_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg text-gray-700 dark:text-white font-semibold text-sm">
                                        {{ number_format($item->jumlah) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('barang-keluar.show', $item->keluar_id) }}"
                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-all"
                                            title="Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>

                                        @hasrole('admin')
                                            <a href="{{ route('barang-keluar.edit', $item->keluar_id) }}"
                                                class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                </svg>
                                            </a>

                                            <button x-data
                                                @click="$dispatch('open-modal', 'delete_item_{{ $item->keluar_id }}')"
                                                class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                </svg>
                                            </button>

                                            <x-confirm-modal id="delete_item_{{ $item->keluar_id }}"
                                                message="Apakah Anda yakin ingin menghapus transaksi ini? Barang akan dikembalikan ke status semula."
                                                okLabel="Hapus" cancelLabel="Batal" :url="route('barang-keluar.destroy', $item->keluar_id)" method="DELETE" />
                                        @endhasrole
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($barangKeluar->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $barangKeluar->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    @if (request()->hasAny(['search', 'kategori', 'jenis_barang_id', 'tanggal_mulai', 'tanggal_akhir']))
                        Tidak Ada Data yang Sesuai
                    @else
                        Belum Ada Data Barang Keluar
                    @endif
                </p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">
                    @if (request()->hasAny(['search', 'kategori', 'jenis_barang_id', 'tanggal_mulai', 'tanggal_akhir']))
                        Coba ubah filter atau kata kunci pencarian Anda
                    @else
                        Mulai tambahkan data barang keluar
                    @endif
                </p>
                @if (request()->hasAny(['search', 'kategori', 'jenis_barang_id', 'tanggal_mulai', 'tanggal_akhir']))
                    <a href="{{ route('barang-keluar.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                        Reset Filter
                    </a>
                @else
                    <a href="{{ route('barang-keluar.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Barang Keluar Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            const autoSubmitForm = debounce(function() {
                const form = document.getElementById('filterForm');
                const loading = document.getElementById('searchLoading');

                if (loading) {
                    loading.classList.remove('hidden');
                }

                form.submit();
            }, 800);

            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const kategoriSelect = document.getElementById('kategoriSelect');
                const jenisBarangSelect = document.getElementById('jenisBarangSelect');
                const tanggalMulaiInput = document.getElementById('tanggalMulaiInput');
                const tanggalAkhirInput = document.getElementById('tanggalAkhirInput');

                if (searchInput) {
                    searchInput.addEventListener('input', autoSubmitForm);
                }

                if (kategoriSelect) {
                    kategoriSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (jenisBarangSelect) {
                    jenisBarangSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (tanggalMulaiInput) {
                    tanggalMulaiInput.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (tanggalAkhirInput) {
                    tanggalAkhirInput.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
