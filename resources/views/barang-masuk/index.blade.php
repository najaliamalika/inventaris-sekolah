<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Barang Masuk') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Kelola data barang masuk (pembelian & bantuan)</p>
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
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBarangMasuk }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-green-600 dark:text-green-400">Total Item Masuk</p>
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalItemMasuk) }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-5 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-purple-600 dark:text-purple-400">Nilai Pembelian</p>
                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp
                {{ number_format($totalNilaiPembelian, 0, ',', '.') }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-5 border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Nilai Bantuan</p>
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp
                {{ number_format($totalNilaiBantuan, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('barang-masuk.index') }}" method="GET" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🔍 Cari
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Nama supplier atau jenis barang..."
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
                            📊 Kategori
                        </label>
                        <select name="kategori" id="kategoriSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            <option value="pembelian" {{ request('kategori') == 'pembelian' ? 'selected' : '' }}>
                                Pembelian</option>
                            <option value="bantuan" {{ request('kategori') == 'bantuan' ? 'selected' : '' }}>Bantuan
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            📅 Dari Tanggal
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggalMulaiInput"
                            value="{{ request('tanggal_mulai') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            📅 Sampai Tanggal
                        </label>
                        <input type="date" name="tanggal_akhir" id="tanggalAkhirInput"
                            value="{{ request('tanggal_akhir') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    @if (request()->hasAny(['search', 'kategori', 'tanggal_mulai', 'tanggal_akhir']))
                        <a href="{{ route('barang-masuk.index') }}"
                            class="px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif

                    <a href="{{ route('barang-masuk.create') }}"
                        class="ml-auto px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Barang Masuk
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($barangMasuk->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">No</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">Tanggal</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">Kategori</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">Supplier</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold uppercase">Total Item</th>
                            <th class="px-4 py-4 text-right text-xs font-semibold uppercase">Total Nilai</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($barangMasuk as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $barangMasuk->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $item->tanggal->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($item->kategori == 'pembelian')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                            💰 Pembelian
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400">
                                            🎁 Bantuan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->nama_supplier }}</p>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <div class="flex flex-col items-center">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            {{ number_format($item->total_jumlah) }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            ({{ number_format($item->details->sum(fn($d) => $d->barangItems->count())) }}
                                            barang)
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('barang-masuk.show', $item->masuk_id) }}"
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

                                        <a href="{{ route('barang-masuk.edit', $item->masuk_id) }}"
                                            class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                <path
                                                    d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                            </svg>
                                        </a>

                                        <button x-data
                                            @click="$dispatch('open-modal', 'delete_item_{{ $item->masuk_id }}')"
                                            class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                            </svg>
                                        </button>

                                        <x-confirm-modal id="delete_item_{{ $item->masuk_id }}"
                                            message="Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan."
                                            okLabel="Hapus" cancelLabel="Batal" :url="route('barang-masuk.destroy', $item->masuk_id)" method="DELETE" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($barangMasuk->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $barangMasuk->withQueryString()->links() }}
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
                    @if (request()->hasAny(['search', 'kategori', 'tanggal_mulai', 'tanggal_akhir']))
                        Tidak Ada Data yang Sesuai
                    @else
                        Belum Ada Data Barang Masuk
                    @endif
                </p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">
                    @if (request()->hasAny(['search', 'kategori', 'tanggal_mulai', 'tanggal_akhir']))
                        Coba ubah filter atau kata kunci pencarian Anda
                    @else
                        Mulai tambahkan data barang masuk
                    @endif
                </p>
                @if (request()->hasAny(['search', 'kategori', 'tanggal_mulai', 'tanggal_akhir']))
                    <a href="{{ route('barang-masuk.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                        Reset Filter
                    </a>
                @else
                    <a href="{{ route('barang-masuk.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Barang Masuk Pertama
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
