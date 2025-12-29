<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Detail Peminjaman') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Informasi lengkap peminjaman barang</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('peminjaman.index') }}"
                    class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium">{{ __('Kembali') }}</span>
                </a>
            </div>

            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

                @php
                    $isDikembalikan = !is_null($peminjaman->tanggal_pengembalian);
                @endphp

                <div
                    class="bg-gradient-to-r {{ $isDikembalikan ? 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-green-100 dark:border-green-800' : 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border-yellow-100 dark:border-yellow-800' }} px-8 py-6 border-b">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-16 h-16 {{ $isDikembalikan ? 'bg-green-500' : 'bg-yellow-500' }} rounded-xl flex items-center justify-center shadow-lg">
                                @if ($isDikembalikan)
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Status Peminjaman</p>
                                <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                    {{ $isDikembalikan ? 'Sudah Dikembalikan' : 'Sedang Dipinjam' }}
                                </p>
                            </div>
                        </div>

                        @hasrole('admin')
                            @if (!$isDikembalikan)
                                <a href="{{ route('peminjaman.edit', $peminjaman->peminjaman_id) }}"
                                    class="px-6 py-3 bg-white/20 hover:bg-white/30 text-gray-800 dark:text-gray-100 font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Peminjaman
                                </a>
                            @endif
                        @endhasrole
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-6">
                            <div>
                                <h3
                                    class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                    Informasi Peminjaman
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Nama Peminjam</p>
                                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $peminjaman->nama_peminjam }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal Peminjaman
                                            </p>
                                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $peminjaman->tanggal_peminjaman->format('d F Y') }}
                                            </p>
                                        </div>
                                    </div>

                                    @if ($isDikembalikan)
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tanggal
                                                    Pengembalian
                                                </p>
                                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                    {{ $peminjaman->tanggal_pengembalian->format('d F Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Jumlah Barang</p>
                                            <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $peminjaman->peminjamanBarang->count() }} item
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($peminjaman->keterangan)
                                <div>
                                    <h3
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                        Keterangan
                                    </h3>
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                            {{ $peminjaman->keterangan }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h3
                                    class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                    Foto Peminjaman
                                </h3>
                                @if ($peminjaman->foto_peminjaman)
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                        <img src="{{ asset('storage/' . $peminjaman->foto_peminjaman) }}"
                                            alt="Foto Peminjaman"
                                            class="w-full h-auto rounded-lg shadow-md border-2 border-white dark:border-gray-600 cursor-pointer hover:opacity-90 transition-opacity"
                                            onclick="window.open(this.src, '_blank')" />
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">Klik untuk
                                            memperbesar</p>
                                    </div>
                                @else
                                    <div
                                        class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-8 border border-gray-200 dark:border-gray-600 text-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-2"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada foto</p>
                                    </div>
                                @endif
                            </div>

                            @if ($isDikembalikan)
                                <div>
                                    <h3
                                        class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                        Foto Pengembalian
                                    </h3>
                                    @if ($peminjaman->foto_pengembalian)
                                        <div
                                            class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                                            <img src="{{ asset('storage/' . $peminjaman->foto_pengembalian) }}"
                                                alt="Foto Pengembalian"
                                                class="w-full h-auto rounded-lg shadow-md border-2 border-white dark:border-gray-600 cursor-pointer hover:opacity-90 transition-opacity"
                                                onclick="window.open(this.src, '_blank')" />
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-center">Klik
                                                untuk
                                                memperbesar</p>
                                        </div>
                                    @else
                                        <div
                                            class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-8 border border-gray-200 dark:border-gray-600 text-center">
                                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-2"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada foto</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3
                            class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">
                            Daftar Barang yang Dipinjam
                        </h3>
                        <div class="space-y-4">
                            @foreach ($peminjaman->peminjamanBarang as $peminjamanBarang)
                                <div
                                    class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border border-gray-200 dark:border-gray-600">
                                    <div class="flex items-start gap-4">
                                        <img src="{{ $peminjamanBarang->barang->gambar_url ?? 'https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg' }}"
                                            alt="{{ $peminjamanBarang->barang->nama_barang }}"
                                            class="w-20 h-20 object-cover rounded-lg border-2 border-white dark:border-gray-600 shadow-sm flex-shrink-0" />

                                        <div class="flex-1">
                                            <div class="flex items-start justify-between mb-2">
                                                <div>
                                                    <p class="text-base font-bold text-gray-900 dark:text-gray-100">
                                                        {{ $peminjamanBarang->barang->nama_barang }}
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        {{ $peminjamanBarang->barang->jenisBarang->jenis ?? '-' }}
                                                    </p>
                                                </div>

                                                @if ($isDikembalikan)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Dikembalikan
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                        <svg class="w-3 h-3 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Dipinjam
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="flex items-center gap-3 mb-3">
                                                <span
                                                    class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                    {{ $peminjamanBarang->barang->merk }}
                                                </span>
                                                @if ($peminjamanBarang->barang->kode_barang)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400">
                                                        {{ $peminjamanBarang->barang->jenisBarang->kode_utama . '' . $peminjamanBarang->barang->kode_barang }}
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded text-xs font-mono font-medium bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                                        -
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @hasrole('admin')
                        @if (!$isDikembalikan)
                            <div
                                class="mt-8 bg-green-50 dark:bg-green-900/20 rounded-xl p-6 border border-green-200 dark:border-green-800">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-green-900 dark:text-green-300 mb-2">
                                            Pengembalian Barang
                                        </h4>
                                        <p class="text-sm text-green-800 dark:text-green-400 mb-4">
                                            Semua barang akan dikembalikan sekaligus. Klik tombol di bawah untuk memproses
                                            pengembalian.
                                        </p>
                                        <button type="button" x-data
                                            @click="$dispatch('open-modal', 'kembalikan-peminjaman')"
                                            class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors duration-200 text-sm gap-2 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                            Kembalikan Semua Barang
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Pengembalian --}}
                            <div x-data="{ open: false }"
                                x-on:open-modal.window="if ($event.detail === 'kembalikan-peminjaman') open = true"
                                x-show="open" x-transition
                                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
                                style="display: none">
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full mx-4 p-6">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                                        Kembalikan Semua Barang
                                    </h3>

                                    <form method="POST"
                                        action="{{ route('peminjaman.kembalikan-barang', $peminjaman->peminjaman_id) }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="space-y-4">
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Tanggal Pengembalian <span class="text-red-500">*</span>
                                                </label>
                                                <input type="date" name="tanggal_pengembalian" required
                                                    value="{{ old('tanggal_pengembalian', date('Y-m-d')) }}"
                                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white" />
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Foto Pengembalian <span class="text-red-500">*</span>
                                                </label>
                                                <input type="file" name="foto_pengembalian" accept="image/*" required
                                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 dark:file:bg-green-900/30 dark:file:text-green-400" />
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    Format: JPG, JPEG, PNG (max. 5MB)
                                                </p>
                                            </div>

                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Keterangan (Opsional)
                                                </label>
                                                <textarea name="keterangan" rows="3"
                                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                                    placeholder="Kondisi barang saat pengembalian, catatan tambahan, dll...">{{ old('keterangan') }}</textarea>
                                            </div>

                                            <div
                                                class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 border border-yellow-200 dark:border-yellow-800">
                                                <p class="text-xs text-yellow-800 dark:text-yellow-400">
                                                    <strong>Perhatian:</strong> Semua
                                                    {{ $peminjaman->peminjamanBarang->count() }} barang akan dikembalikan
                                                    sekaligus.
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex justify-end gap-3 mt-6">
                                            <button type="button" @click="open = false"
                                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                                Kembalikan Semua
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endhasrole

                    <div
                        class="flex items-center justify-between pt-8 border-t border-gray-200 dark:border-gray-700 mt-8">
                        <a href="{{ route('peminjaman.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-semibold transition-colors duration-200 gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                        @hasrole('admin')
                            @if (!$isDikembalikan)
                                <a href="{{ route('peminjaman.edit', $peminjaman->peminjaman_id) }}"
                                    class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-colors duration-200 gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Peminjaman
                                </a>
                            @endif
                        @endhasrole
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
