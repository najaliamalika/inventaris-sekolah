<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data Peminjaman Barang') }}
        </h2>
        <p class="text-gray-600 text-sm mt-1">Kelola semua data peminjaman dan pengembalian barang</p>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Search and Filter Section -->
            <div class="mb-8">
                <form action="{{ route('peminjaman.index') }}" method="GET" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2 relative">
                            <input type="text" name="search" 
                                placeholder="Cari berdasarkan nama peminjam, nama barang, kode barang, atau keterangan"
                                value="{{ request('search') }}" 
                                class="w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-white">
                            <svg class="absolute left-4 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('peminjaman.create') }}"
                                class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah
                            </a>
                        </div>
                    </div>

                    <!-- Advanced Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded-xl border-2 border-gray-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Peminjaman (Dari)</label>
                            <input type="date" name="tanggal_peminjaman_dari" value="{{ request('tanggal_peminjaman_dari') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Peminjaman (Sampai)</label>
                            <input type="date" name="tanggal_peminjaman_sampai" value="{{ request('tanggal_peminjaman_sampai') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian (Dari)</label>
                            <input type="date" name="tanggal_pengembalian_dari" value="{{ request('tanggal_pengembalian_dari') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengembalian (Sampai)</label>
                            <input type="date" name="tanggal_pengembalian_sampai" value="{{ request('tanggal_pengembalian_sampai') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <a href="{{ route('peminjaman.index') }}"
                                class="w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200 text-center">
                                Reset Filter
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium">Total Peminjaman</p>
                            <p class="text-3xl font-bold mt-2">{{ $peminjaman->total() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium">Bulan Ini</p>
                            <p class="text-3xl font-bold mt-2">{{ $monthlyCount }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium">Hari Ini</p>
                            <p class="text-3xl font-bold mt-2">{{ $todayCount }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium">Dipinjam</p>
                            <p class="text-3xl font-bold mt-2">{{ $dipinjamCount }}</p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
                                <th class="w-16 px-6 py-4 text-left font-semibold text-sm">No</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Peminjam</th>
                                <th class="w-24 px-6 py-4 text-left font-semibold text-sm">Gambar</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Nama Barang</th>
                                <th class="px-6 py-4 text-center font-semibold text-sm">Jumlah</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Status</th>
                                <th class="px-6 py-4 text-left font-semibold text-sm">Tgl Kembali</th>
                                <th class="w-28 px-6 py-4 text-center font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($peminjaman as $index => $p)
                                <tr class="hover:bg-gray-50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $peminjaman->currentPage() * 10 - 10 + $index + 1 }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('d M Y') }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($p->tanggal_peminjaman)->format('H:i') }} WIB
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($p->nama_peminjam, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $p->nama_peminjam }}</p>
                                                <p class="text-xs text-gray-500 line-clamp-1">{{ $p->keterangan }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-start">
                                            <div class="relative inline-block">
                                                <img src="{{ $p->item->gambar ?? 'https://www.shutterstock.com/image-vector/default-ui-image-placeholder-wireframes-600nw-1037719192.jpg' }}"
                                                    alt="{{ $p->item->nama_barang }}"
                                                    class="w-14 h-14 object-cover rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200" />
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-semibold text-gray-900">{{ $p->item->nama_barang }}</p>
                                            <p class="text-xs text-gray-500">{{ $p->item->jenis }} - {{ $p->item->merk }}</p>
                                            @if($p->item->kode_barang)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 mt-1 w-fit">
                                                    {{ $p->item->kode_barang }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-blue-100 text-blue-800">
                                                <span class="text-sm font-bold">{{ $p->jumlah }}</span>
                                                <span class="text-xs ml-1">{{ $p->item->satuan }}</span>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($p->status === 'dipinjam')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Dipinjam
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Dikembalikan
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($p->tanggal_pengembalian)
                                            <div class="flex flex-col">
                                                <span class="text-sm font-semibold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d M Y') }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('H:i') }} WIB
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            @if (Route::has('peminjaman.show'))
                                                <a href="{{ route('peminjaman.show', $p->peminjaman_id) }}"
                                                    class="p-2.5 text-green-600 hover:bg-green-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                    title="Detail">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                                                    </svg>
                                                </a>
                                            @endif

                                            @if (Route::has('peminjaman.edit'))
                                                <a href="{{ route('peminjaman.edit', $p->peminjaman_id) }}"
                                                    class="p-2.5 text-blue-600 hover:bg-blue-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" />
                                                        <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                                                    </svg>
                                                </a>
                                            @endif

                                            @if (Route::has('peminjaman.destroy'))
                                                <button x-data 
                                                    @click="$dispatch('open-modal', 'delete_peminjaman_{{ $p->peminjaman_id }}')"
                                                    class="p-2.5 text-red-600 hover:bg-red-100 rounded-lg transition-all duration-200 hover:scale-110"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-9l-1 1H5v2h14V4z" />
                                                    </svg>
                                                </button>

                                                <x-confirm-modal id="delete_peminjaman_{{ $p->peminjaman_id }}"
                                                    message="Apakah Anda yakin ingin menghapus data peminjaman ini? Stok barang akan dikembalikan jika masih berstatus 'Dipinjam'."
                                                    okLabel="Hapus" cancelLabel="Batal" 
                                                    :url="route('peminjaman.destroy', $p->peminjaman_id)" method="DELETE" />
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                            <p class="text-lg font-semibold text-gray-500 mb-2">Tidak Ada Data Peminjaman</p>
                                            <p class="text-sm text-gray-400 mb-6">Belum ada data peminjaman yang tercatat dalam sistem</p>
                                            <a href="{{ route('peminjaman.create') }}"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm font-medium">
                                                Tambah Peminjaman Pertama
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
                    {{ $peminjaman->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>