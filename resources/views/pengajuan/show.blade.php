<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Detail Pengajuan') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Informasi lengkap pengajuan
                {{ ucfirst($pengajuan->tipe) }}</p>
        </div>
    </x-slot>

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('pengajuan.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium">{{ __('Kembali') }}</span>
        </a>

        <div class="flex gap-2">
            @if ($pengajuan->status === 'menunggu')
                <a href="{{ route('pengajuan.edit', $pengajuan->pengajuan_id) }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            @endif

            @if ($pengajuan->status !== 'disetujui')
                <button x-data @click="$dispatch('open-modal', 'delete_item_{{ $pengajuan->pengajuan_id }}')"
                    class="p-2.5 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 hover:scale-110"
                    title="Hapus">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <x-confirm-modal id="delete_item_{{ $pengajuan->pengajuan_id }}"
                    message="Apakah Anda yakin ingin menghapus pengajuan ini? Tindakan ini tidak dapat dibatalkan."
                    okLabel="Hapus" cancelLabel="Batal" :url="route('pengajuan.destroy', $pengajuan->pengajuan_id)" method="DELETE" />
            @endif
        </div>
    </div>

    <!-- Main Information Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <!-- Status Banner -->
        <div
            class="
            {{ $pengajuan->status === 'disetujui'
                ? 'bg-gradient-to-r from-green-600 to-green-500'
                : ($pengajuan->status === 'ditolak'
                    ? 'bg-gradient-to-r from-red-600 to-red-500'
                    : 'bg-gradient-to-r from-yellow-600 to-yellow-500') }}
            p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if ($pengajuan->status === 'disetujui')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif($pengajuan->status === 'ditolak')
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                    <div>
                        <h3 class="text-white font-semibold text-lg">
                            Status: {{ ucfirst($pengajuan->status) }}
                        </h3>
                        <p class="text-white/90 text-sm">
                            {{ $pengajuan->created_at->format('d M Y, H:i') }} WIB
                        </p>
                    </div>
                </div>

                @if ($pengajuan->status === 'menunggu')
                    <div class="flex gap-2">
                        <button x-data @click="$dispatch('open-modal', 'approve_modal')"
                            class="px-4 py-2 bg-white text-green-600 hover:bg-green-50 rounded-lg transition-colors text-sm font-semibold flex items-center gap-2 shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Setujui
                        </button>

                        <button x-data @click="$dispatch('open-modal', 'reject_modal')"
                            class="px-4 py-2 bg-white text-red-600 hover:bg-red-50 rounded-lg transition-colors text-sm font-semibold flex items-center gap-2 shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Tolak
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Tipe Pengajuan</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        @if ($pengajuan->tipe == 'pembelian')
                            <span class="inline-flex items-center gap-1">
                                💰 Pembelian
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1">
                                🔧 Perbaikan
                            </span>
                        @endif
                    </p>
                </div>

                @if ($pengajuan->tipe === 'perbaikan' && $pengajuan->jenisBarang)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Jenis Barang</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $pengajuan->jenisBarang->jenis }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $pengajuan->jenisBarang->kategori }}
                        </p>
                    </div>
                @endif

                @if ($pengajuan->tipe === 'pembelian')
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Nama Barang</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $pengajuan->nama_barang }}
                        </p>
                    </div>
                @endif

                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Jumlah</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($pengajuan->jumlah) }} Unit
                    </p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Alasan Pengajuan</p>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <p class="text-gray-900 dark:text-gray-100">{{ $pengajuan->alasan }}</p>
                        </div>
                    </div>

                    @if ($pengajuan->catatan)
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Catatan
                                {{ ucfirst($pengajuan->status) }}</p>
                            <div
                                class="bg-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-50 dark:bg-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-900/20 border border-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-200 dark:border-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-800 p-4 rounded-lg">
                                <p
                                    class="text-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-900 dark:text-{{ $pengajuan->status === 'disetujui' ? 'green' : 'red' }}-100">
                                    {{ $pengajuan->catatan }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Estimasi Biaya</p>
                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        Rp {{ number_format($pengajuan->estimasi_biaya, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Items (for perbaikan) -->
    @if ($pengajuan->tipe === 'perbaikan' && $pengajuan->perbaikanItems->count() > 0)
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-semibold text-lg">
                            Barang yang Akan Diperbaiki
                        </h3>
                        <p class="text-purple-100 text-sm">
                            {{ $pengajuan->perbaikanItems->count() }} Unit
                        </p>
                    </div>
                    <div
                        class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg border border-white/30 text-white font-semibold">
                        {{ $pengajuan->jenisBarang->jenis ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($pengajuan->perbaikanItems as $item)
                        <div
                            class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h5 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1">
                                        {{ $item->barang->nama_barang }}
                                    </h5>
                                    @if ($item->barang->kode_barang)
                                        <p class="text-xs text-blue-600 dark:text-blue-400 font-mono">
                                            {{ $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    <span class="font-medium">{{ $item->barang->merk }}</span>
                                </div>

                                @if ($item->barang->lokasi)
                                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $item->barang->lokasi }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Approval Modal -->
    <x-modal name="approve_modal" :show="false" maxWidth="md">
        <form method="POST" action="{{ route('pengajuan.update-status', $pengajuan->pengajuan_id) }}"
            class="p-6">
            @csrf
            <input type="hidden" name="status" value="disetujui">

            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Setujui Pengajuan
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Konfirmasi persetujuan pengajuan ini
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Catatan (Opsional)
                </label>
                <textarea name="catatan" rows="3"
                    class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 bg-white dark:bg-gray-700 dark:text-white"
                    placeholder="Tambahkan catatan persetujuan..."></textarea>
            </div>

            @if ($pengajuan->tipe === 'perbaikan')
                <div
                    class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-blue-300">
                            <p class="font-semibold mb-1">Informasi Penting</p>
                            <p>Dengan menyetujui pengajuan perbaikan ini, barang yang dipilih akan otomatis dipindahkan
                                ke status "Sedang Diperbaiki" dan tercatat dalam Barang Keluar.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Setujui Pengajuan
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Reject Modal -->
    <x-modal name="reject_modal" :show="false" maxWidth="md">
        <form method="POST" action="{{ route('pengajuan.update-status', $pengajuan->pengajuan_id) }}"
            class="p-6">
            @csrf
            <input type="hidden" name="status" value="ditolak">

            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Tolak Pengajuan
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Berikan alasan penolakan
                    </p>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="catatan" rows="4" required
                    class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all duration-200 bg-white dark:bg-gray-700 dark:text-white"
                    placeholder="Jelaskan alasan penolakan pengajuan ini..."></textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tolak Pengajuan
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
