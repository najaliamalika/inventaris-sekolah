@php
    $totalBarang = \App\Models\Barang::count();
    $totalKategori = \App\Models\JenisBarang::distinct('kategori')->count('kategori');
    $barangDiperbaiki = \App\Models\Barang::where('kondisi', 'diperbaiki')->count();
    $totalNilai = \App\Models\BarangMasuk::sum('total_harga');

    $barangMasukTerbaru = \App\Models\BarangMasuk::with('details.jenisBarang')
        ->orderBy('tanggal', 'desc')
        ->take(2)
        ->get();

    $barangKeluarTerbaru = \App\Models\BarangKeluar::with('jenisBarang')->orderBy('tanggal', 'desc')->take(2)->get();

    $pengajuanTerbaru = \App\Models\Pengajuan::with('jenisBarang')->orderBy('tanggal', 'desc')->take(2)->get();

    $barangBaik = \App\Models\Barang::where('kondisi', 'baik')->count();
    $barangDipinjam = \App\Models\Barang::where('kondisi', 'dipinjam')->count();

    $kategoriPopuler = \App\Models\JenisBarang::withCount('barang')->orderBy('barang_count', 'desc')->take(8)->get();

    $pengajuanMenunggu = \App\Models\Pengajuan::where('status', 'menunggu')->count();
    $pengajuanDisetujui = \App\Models\Pengajuan::where('status', 'disetujui')->count();

    $peminjamanAktif = \App\Models\PeminjamanBarang::where('status', 'dipinjam')->count();
    $peminjamanMenunggu = \App\Models\PeminjamanBarang::where('status', 'menunggu')->count();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard Inventaris
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="mb-8 bg-gradient-to-r from-green-600 to-green-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8 text-white">
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang!</h1>
                    <p class="text-green-100 text-lg">Kelola inventaris sekolah Anda dengan mudah dan efisien</p>
                    <p class="text-green-200 text-sm mt-2">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Barang</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($totalBarang) }}</h3>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <a href="{{ route('peminjaman.index') }}"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300 block">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Peminjaman</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $peminjamanAktif }}</h3>
                        </div>
                        <div class="relative bg-orange-100 dark:bg-orange-900 p-4 rounded-full">
                            <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            @if ($peminjamanMenunggu > 0)
                                <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-orange-500"></span>
                                </span>
                            @endif
                        </div>
                    </div>
                    @if ($peminjamanMenunggu > 0)
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300">
                                {{ $peminjamanMenunggu }} peminjaman menunggu
                            </span>
                        </div>
                    @endif
                </a>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Diperbaikan</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-3">{{ $barangDiperbaiki }}
                            </h3>
                            @if ($pengajuanMenunggu > 0)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300">{{ $pengajuanMenunggu }}
                                    pengajuan menunggu
                                </span>
                            @endif
                        </div>
                        <div class="relative bg-red-100 dark:bg-red-900 p-4 rounded-full">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            @if ($pengajuanMenunggu > 0)
                                <span class="absolute -top-1 -right-1 flex h-4 w-4">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-4 w-4 bg-orange-500"></span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Jenis dengan Barang Terbanyak</h3>
                        <a href="{{ route('jenis-barang.index') }}"
                            class="text-sm text-green-600 dark:text-green-400 hover:underline">Lihat Semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $icons = ['📚', '💻', '🪑', '⚽', '🔬', '🎨', '🎵', '🏀'];
                        @endphp
                        @forelse($kategoriPopuler as $index => $jenis)
                            <a href="{{ route('jenis-barang.show', ['jenis_barang_id' => $jenis->jenis_barang_id]) }}"
                                class="p-4 rounded-lg border-2 border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-colors cursor-pointer">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $jenis->jenis }}
                                    ({{ $jenis->kode_utama }})
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $jenis->barang_count }} items
                                </p>
                            </a>
                        @empty
                            <div class="col-span-4 text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Belum ada kategori</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                    @hasrole('admin')
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">Aksi Cepat</h3>
                        <div class="space-y-3 mb-6 border-b ">
                            <a href="{{ route('barang-masuk.create') }}"
                                class="w-full flex items-center space-x-3 p-4 rounded-lg bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                <div class="bg-blue-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">Tambah Barang Masuk</span>
                            </a>

                            <a href="{{ route('barang-keluar.create') }}"
                                class="w-full flex items-center space-x-3 p-4 rounded-lg bg-purple-50 dark:bg-purple-900/30 hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-colors">
                                <div class="bg-purple-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">Catat Barang Keluar</span>
                            </a>

                            <a href="{{ route('peminjaman.create') }}"
                                class="w-full flex items-center space-x-3 p-4 rounded-lg bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 transition-colors">
                                <div class="bg-green-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">Peminjaman Barang</span>
                            </a>

                            <a href="{{ route('pengajuan.create') }}"
                                class="w-full flex items-center space-x-3 p-4 rounded-lg bg-orange-50 dark:bg-orange-900/30 hover:bg-orange-100 dark:hover:bg-orange-900/50 transition-colors">
                                <div class="bg-orange-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-gray-900 dark:text-white">Ajukan Pembelian</span>
                            </a>
                        </div>
                    @endhasrole

                    <div class="mt-6 pt-6 border-t ">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Status Barang</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Kondisi Baik</span>
                                <span
                                    class="text-sm font-semibold text-green-600 dark:text-green-400">{{ $barangBaik }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Sedang Dipinjam</span>
                                <span
                                    class="text-sm font-semibold text-blue-600 dark:text-blue-400">{{ $barangDipinjam }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Perlu Perbaikan</span>
                                <span
                                    class="text-sm font-semibold text-red-600 dark:text-red-400">{{ $barangDiperbaiki }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
