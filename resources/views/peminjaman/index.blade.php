<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Daftar Peminjaman') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Kelola semua data peminjaman barang</p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-5 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-blue-600 dark:text-blue-400">Total Peminjaman</p>
                <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalPeminjaman }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-5 border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Sedang Dipinjam</p>
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $dipinjamCount }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-green-600 dark:text-green-400">Dikembalikan</p>
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $dikembalikanCount }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-5 border border-purple-200 dark:border-purple-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-purple-600 dark:text-purple-400">Total Barang</p>
                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalBarangDipinjam }}</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('peminjaman.index') }}" method="GET" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cari Peminjaman
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Cari nama peminjam atau barang..."
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
                            Status
                        </label>
                        <select name="status" id="statusSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua Status</option>
                            <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>
                                Sudah Dikembalikan
                            </option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                                Sedang Dipinjam
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Peminjaman
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggalMulaiInput"
                            value="{{ request('tanggal_mulai') }}"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    @if (request()->hasAny(['search', 'status', 'tanggal_mulai']))
                        <a href="{{ route('peminjaman.index') }}"
                            class="px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif

                    @hasrole('admin')
                        <a href="{{ route('peminjaman.create') }}"
                            class="ml-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Peminjaman
                        </a>
                    @endhasrole
                </div>
            </form>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($peminjaman->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-600 to-green-500 text-white">
                        <tr>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">No</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Tgl Pinjam</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Nama Barang</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Peminjam</th>
                            <th class="px-2 py-4 text-center text-xs font-semibold uppercase">Jumlah</th>
                            <th class="px-2 py-4 text-center text-xs font-semibold uppercase">Status</th>
                            <th class="px-2 py-4 text-left text-xs font-semibold uppercase">Tgl Kembali</th>
                            <th class="px-2 py-4 text-center text-xs font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($peminjaman as $index => $p)
                            @php
                                $isDikembalikan = !is_null($p->tanggal_pengembalian);
                            @endphp
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-2 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $peminjaman->firstItem() + $index }}
                                </td>
                                <td class="px-2 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $p->tanggal_peminjaman->format('d M Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-2 py-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $p->peminjamanBarang->first()->barang->nama_barang . ' ' . ($p->peminjamanBarang->count() > 1 ? ' + ' . ($p->peminjamanBarang->count() - 1) . ' lainnya' : '') }}
                                    </p>
                                </td>
                                <td class="px-2 py-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $p->nama_peminjam }}
                                    </p>
                                </td>
                                <td class="px-2 py-4">
                                    <p class="text-sm font-normal text-center text-gray-900 dark:text-gray-100">
                                        {{ $p->peminjamanBarang->count() }}
                                    </p>
                                </td>
                                <td class="px-2 py-2 text-center">
                                    @if ($isDikembalikan)
                                        <span
                                            class="px-3 py-1 rounded-lg text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            Sudah Kembali
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-lg text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            Sedang Dipinjam
                                        </span>
                                    @endif
                                </td>

                                <td class="px-2 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $isDikembalikan ? $p->tanggal_pengembalian->format('d M Y') : '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="px-2 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('peminjaman.show', $p->peminjaman_id) }}"
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
                                            @if (!$isDikembalikan)
                                                <a href="{{ route('peminjaman.edit', $p->peminjaman_id) }}"
                                                    class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                        <path
                                                            d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                    </svg>
                                                </a>
                                            @endif

                                            <button type="button" x-data
                                                @click="$dispatch('open-modal', 'delete_peminjaman_{{ $p->peminjaman_id }}')"
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                </svg>
                                            </button>
                                        @endhasrole
                                    </div>
                                </td>
                            </tr>

                            <x-confirm-modal id="delete_peminjaman_{{ $p->peminjaman_id }}"
                                message="Apakah Anda yakin ingin menghapus data peminjaman ini? Data yang dihapus tidak dapat dikembalikan."
                                okLabel="Hapus" cancelLabel="Batal" :url="route('peminjaman.destroy', $p->peminjaman_id)" method="DELETE" />
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($peminjaman->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $peminjaman->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    @if (request()->hasAny(['search', 'status', 'tanggal_mulai']))
                        Tidak Ada Data yang Sesuai
                    @else
                        Belum Ada Data Peminjaman
                    @endif
                </p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">
                    @if (request()->hasAny(['search', 'status', 'tanggal_mulai']))
                        Coba ubah filter atau kata kunci pencarian Anda
                    @else
                        Mulai tambahkan data peminjaman barang
                    @endif
                </p>
                @if (request()->hasAny(['search', 'status', 'tanggal_mulai']))
                    <a href="{{ route('peminjaman.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                        Reset Filter
                    </a>
                @else
                    <a href="{{ route('peminjaman.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Peminjaman Pertama
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
                const statusSelect = document.getElementById('statusSelect');
                const tanggalMulaiInput = document.getElementById('tanggalMulaiInput');

                if (searchInput) {
                    searchInput.addEventListener('input', autoSubmitForm);
                }

                if (statusSelect) {
                    statusSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (tanggalMulaiInput) {
                    tanggalMulaiInput.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
