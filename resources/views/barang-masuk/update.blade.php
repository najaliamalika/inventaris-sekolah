<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-2xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ route('barang-masuk.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 mb-8 group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium">{{ __('Kembali') }}</span>
            </a>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-400 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        {{ __('Edit Barang Masuk') }}
                    </h1>
                    <p class="text-green-100 mt-2">{{ __('Perbarui informasi transaksi barang masuk') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="update_barang_masuk" method="POST"
                        action="{{ route('barang-masuk.update', $barangMasuk->masuk_id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Row 1: Kode Barang & Nama Barang -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kode_barang" :value="__('Kode Barang')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <div class="relative">
                                    <x-text-input id="kode_barang"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="kode_barang" :value="old('kode_barang', $item->kode_barang)"
                                        placeholder="Masukkan Kode Barang" autocomplete="kode_barang" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>

                            <!-- Row 1: Tanggal & Jumlah -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <x-input-label for="tanggal" :value="__('Tanggal')"
                                        class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                        <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <div class="relative">
                                        <x-text-input id="tanggal"
                                            class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                            type="datetime-local" name="tanggal" :value="old(
                                                'tanggal',
                                                \Carbon\Carbon::parse($barangMasuk->tanggal)->format('Y-m-d\TH:i'),
                                            )" required />
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                                </div>

                                <div class="group">
                                    <x-input-label for="jumlah" :value="__('Jumlah')"
                                        class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                        <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <x-text-input id="jumlah"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="number" name="jumlah" placeholder="Masukkan jumlah barang"
                                        min="1" :value="old('jumlah', $barangMasuk->jumlah)" required />
                                    <p class="text-xs text-gray-500 mt-1">Jumlah sebelumnya: {{ $barangMasuk->jumlah }}
                                    </p>
                                    <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Row 2: Kategori & Harga Satuan -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <x-input-label for="kategori" :value="__('Kategori')"
                                        class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                        <span class="text-red-500">*</span>
                                    </x-input-label>
                                    <div class="relative">
                                        <select id="kategori" name="kategori"
                                            class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none"
                                            required>
                                            <option value="pembelian"
                                                {{ old('kategori', $barangMasuk->kategori) == 'pembelian' ? 'selected' : '' }}>
                                                Pembelian
                                            </option>
                                            <option value="bantuan"
                                                {{ old('kategori', $barangMasuk->kategori) == 'bantuan' ? 'selected' : '' }}>
                                                Bantuan
                                            </option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                                </div>

                                <div class="group">
                                    <x-input-label for="harga_satuan" :value="__('Harga Satuan')"
                                        class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                    <div class="relative">
                                        <span
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-medium">Rp</span>
                                        <x-text-input id="harga_satuan"
                                            class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                            type="number" name="harga_satuan" placeholder="0" min="0"
                                            :value="old('harga_satuan', $barangMasuk->harga_satuan)" />
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Opsional - Isi jika pembelian</p>
                                    <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Nama Supplier -->
                            <div class="group">
                                <x-input-label for="nama_supplier" :value="__('Nama Supplier')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="nama_supplier"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="nama_supplier" placeholder="Masukkan nama supplier"
                                    :value="old('nama_supplier', $barangMasuk->nama_supplier)" required />
                                <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                            </div>

                            <!-- Keterangan -->
                            <div class="group">
                                <x-input-label for="keterangan" :value="__('Keterangan')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <textarea id="keterangan" name="keterangan" rows="4"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white resize-none"
                                    placeholder="Masukkan keterangan transaksi barang masuk" required>{{ old('keterangan', $barangMasuk->keterangan) }}</textarea>
                                <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            </div>
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 space-x-4">
                        <a href="{{ route('barang-masuk.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Batal') }}
                        </a>

                        <x-primary-button x-data type="button"
                            @click="$dispatch('open-modal', 'update_confirmation')"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>

                        <x-confirm-modal id="update_confirmation"
                            message="Apakah Anda yakin ingin memperbarui transaksi barang masuk ini?" okLabel="Simpan"
                            cancelLabel="Batal" :url="route('barang-masuk.update', $barangMasuk->masuk_id)" formId="update_barang_masuk" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.group');
            formGroups.forEach(group => {
                const input = group.querySelector('input, select, textarea');
                if (input) {
                    input.addEventListener('focus', () => {
                        group.classList.add('ring-2', 'ring-green-100', 'ring-opacity-50');
                    });
                    input.addEventListener('blur', () => {
                        group.classList.remove('ring-2', 'ring-green-100', 'ring-opacity-50');
                    });
                }
            });
        });
    </script>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-app-layout>
