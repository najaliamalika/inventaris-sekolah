<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Pengajuan') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Kelola pengajuan pembelian & perbaikan barang</p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 rounded-xl p-5 border border-indigo-200 dark:border-indigo-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-indigo-600 dark:text-indigo-400">Total Pengajuan</p>
                <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalPengajuan }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-5 border border-yellow-200 dark:border-yellow-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-yellow-600 dark:text-yellow-400">Menunggu</p>
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalMenunggu }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-5 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-green-600 dark:text-green-400">Disetujui</p>
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalDisetujui }}</p>
        </div>

        <div
            class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-5 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs font-medium text-red-600 dark:text-red-400">Ditolak</p>
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalDitolak }}</p>
        </div>
    </div>

    <div class="mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <form action="{{ route('pengajuan.index') }}" method="GET" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            🔍 Cari
                        </label>
                        <div class="relative">
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                placeholder="Nama barang atau alasan..."
                                class="w-full px-4 py-2.5 pl-10 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <div id="searchLoading" class="hidden absolute right-3 top-3">
                                <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
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
                            📋 Tipe
                        </label>
                        <select name="tipe" id="tipeSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            <option value="pembelian" {{ request('tipe') == 'pembelian' ? 'selected' : '' }}>🛒
                                Pembelian</option>
                            <option value="perbaikan" {{ request('tipe') == 'perbaikan' ? 'selected' : '' }}>🔧
                                Perbaikan</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            📊 Status
                        </label>
                        <select name="status" id="statusSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu
                            </option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✅
                                Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            📦 Jenis Barang
                        </label>
                        <select name="jenis_barang_id" id="jenisBarangSelect"
                            class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white appearance-none">
                            <option value="">Semua</option>
                            @foreach ($jenisBarangList as $jenis)
                                <option value="{{ $jenis->jenis_barang_id }}"
                                    {{ request('jenis_barang_id') == $jenis->jenis_barang_id ? 'selected' : '' }}>
                                    {{ $jenis->kategori }} - {{ $jenis->jenis }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    @if (request()->hasAny(['search', 'tipe', 'status', 'jenis_barang_id']))
                        <a href="{{ route('pengajuan.index') }}"
                            class="px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset Filter
                        </a>
                    @endif

                    <a href="{{ route('pengajuan.create') }}"
                        class="ml-auto px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Pengajuan
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        @if ($pengajuan->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-indigo-600 to-indigo-500 text-white">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">No</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">Tanggal</th>
                            <th class="px-4 py-4 w-40 text-left text-xs font-semibold uppercase">Nama Barang</th>
                            <th class="px-4 py-4 w-40 text-left text-xs font-semibold uppercase">Tipe</th>
                            <th class="px-4 py-4 text-left text-xs font-semibold uppercase">Jenis Barang</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold uppercase">Jumlah</th>
                            <th class="px-4 py-4 w-40 text-right text-xs font-semibold uppercase">Est. Biaya</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold uppercase">Status</th>
                            <th class="px-4 py-4 text-center text-xs font-semibold uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($pengajuan as $index => $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $pengajuan->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->tanggal->format('d M Y') }}
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $item->tipe === 'pembelian' ? $item->nama_barang : $item->perbaikanItems->first()->barang->nama_barang . '' . ($item->perbaikanItems->count() > 1 ? ' + ' . ($item->perbaikanItems->count() - 1) . ' lainnya' : '') }}
                                    </p>
                                    @if ($item->alasan)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1">
                                            {{ Str::limit($item->alasan, 50) }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if ($item->tipe == 'pembelian') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                        @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 @endif">
                                        {{ $item->getTipeLabel() }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($item->jenisBarang)
                                        <div class="flex flex-col">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item->jenisBarang->jenis }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $item->jenisBarang->kategori }}
                                            </p>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-400 font-semibold text-sm">
                                        {{ number_format($item->jumlah) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900 dark:text-gray-100">
                                        {{ $item->estimasi_biaya_format }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if ($item->status == 'menunggu') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                        @elseif($item->status == 'disetujui') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 @endif">
                                        {{ $item->getStatusLabel() }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('pengajuan.show', $item->pengajuan_id) }}"
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

                                        @if ($item->status == 'menunggu')
                                            <a href="{{ route('pengajuan.edit', $item->pengajuan_id) }}"
                                                class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                    <path
                                                        d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                </svg>
                                            </a>

                                            <button x-data
                                                @click="$dispatch('open-modal', 'approve_{{ $item->pengajuan_id }}')"
                                                class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-all"
                                                title="Setujui">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>

                                            <button x-data
                                                @click="$dispatch('open-modal', 'reject_{{ $item->pengajuan_id }}')"
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all"
                                                title="Tolak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>

                                            <x-modal name="approve_{{ $item->pengajuan_id }}" maxWidth="md">
                                                <form
                                                    action="{{ route('pengajuan.update-status', $item->pengajuan_id) }}"
                                                    method="POST" class="p-6">
                                                    @csrf
                                                    <input type="hidden" name="status" value="disetujui">

                                                    <h2
                                                        class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                                        Setujui Pengajuan
                                                    </h2>

                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                        Apakah Anda yakin ingin menyetujui pengajuan ini?
                                                        @if ($item->tipe == 'perbaikan')
                                                            <br><strong class="text-orange-600">Barang akan otomatis
                                                                masuk ke daftar barang keluar dengan status "Sedang
                                                                Diperbaiki"</strong>
                                                        @endif
                                                    </p>

                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                            Catatan (Opsional)
                                                        </label>
                                                        <textarea name="catatan" rows="3"
                                                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                                            placeholder="Tambahkan catatan..."></textarea>
                                                    </div>

                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" x-on:click="$dispatch('close')"
                                                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                                                            Setujui
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>

                                            <x-modal name="reject_{{ $item->pengajuan_id }}" maxWidth="md">
                                                <form
                                                    action="{{ route('pengajuan.update-status', $item->pengajuan_id) }}"
                                                    method="POST" class="p-6">
                                                    @csrf
                                                    <input type="hidden" name="status" value="ditolak">

                                                    <h2
                                                        class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                                        Tolak Pengajuan
                                                    </h2>

                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                        Apakah Anda yakin ingin menolak pengajuan ini?
                                                    </p>

                                                    <div class="mb-4">
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                            Alasan Penolakan <span class="text-red-500">*</span>
                                                        </label>
                                                        <textarea name="catatan" rows="3" required
                                                            class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                                            placeholder="Jelaskan alasan penolakan..."></textarea>
                                                    </div>

                                                    <div class="flex items-center justify-end gap-3">
                                                        <button type="button" x-on:click="$dispatch('close')"
                                                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">
                                                            Tolak
                                                        </button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                        @endif

                                        @if ($item->status != 'disetujui')
                                            <button x-data
                                                @click="$dispatch('open-modal', 'delete_item_{{ $item->pengajuan_id }}')"
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
                                                </svg>
                                            </button>

                                            <x-confirm-modal id="delete_item_{{ $item->pengajuan_id }}"
                                                message="Apakah Anda yakin ingin menghapus pengajuan ini?"
                                                okLabel="Hapus" cancelLabel="Batal" :url="route('pengajuan.destroy', $item->pengajuan_id)"
                                                method="DELETE" />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($pengajuan->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $pengajuan->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-lg font-semibold text-gray-500 dark:text-gray-400 mb-2">
                    @if (request()->hasAny(['search', 'tipe', 'status', 'jenis_barang_id']))
                        Tidak Ada Data yang Sesuai
                    @else
                        Belum Ada Pengajuan
                    @endif
                </p>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-6">
                    @if (request()->hasAny(['search', 'tipe', 'status', 'jenis_barang_id']))
                        Coba ubah filter atau kata kunci pencarian Anda
                    @else
                        Mulai buat pengajuan pembelian atau perbaikan barang
                    @endif
                </p>
                @if (request()->hasAny(['search', 'tipe', 'status', 'jenis_barang_id']))
                    <a href="{{ route('pengajuan.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm font-medium">
                        Reset Filter
                    </a>
                @else
                    <a href="{{ route('pengajuan.create') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Pengajuan Pertama
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
                const tipeSelect = document.getElementById('tipeSelect');
                const statusSelect = document.getElementById('statusSelect');
                const jenisBarangSelect = document.getElementById('jenisBarangSelect');

                if (searchInput) {
                    searchInput.addEventListener('input', autoSubmitForm);
                }

                if (tipeSelect) {
                    tipeSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (statusSelect) {
                    statusSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }

                if (jenisBarangSelect) {
                    jenisBarangSelect.addEventListener('change', function() {
                        document.getElementById('filterForm').submit();
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
