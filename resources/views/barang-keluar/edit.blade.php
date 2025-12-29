<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Barang Keluar') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Perbarui data barang keluar</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('barang-keluar.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium">{{ __('Kembali') }}</span>
        </a>
    </div>

    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-8">
            <form id="update_barang_keluar" method="POST"
                action="{{ route('barang-keluar.update', $barangKeluar->keluar_id) }}" class="space-y-6"
                x-data="barangKeluarEditForm()">
                @csrf
                @method('PUT')

                <!-- Informasi Umum -->
                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Umum</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tanggal -->
                        <div class="group">
                            <x-input-label for="tanggal" :value="__('Tanggal')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal" :value="old('tanggal', $barangKeluar->tanggal->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Jenis Barang -->
                        <div class="group">
                            <x-input-label for="jenis_barang_id" :value="__('Jenis Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="jenis_barang_id" name="jenis_barang_id" required x-model="selectedJenis"
                                @change="loadAvailableBarang()"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="">-- Pilih Jenis Barang --</option>
                                @foreach ($jenisBarang as $jenis)
                                    <option value="{{ $jenis->jenis_barang_id }}" data-kode="{{ $jenis->kode_utama }}"
                                        {{ old('jenis_barang_id', $barangKeluar->jenis_barang_id) == $jenis->jenis_barang_id ? 'selected' : '' }}>
                                        {{ $jenis->jenis }} (Stok: {{ $jenis->stok_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_barang_id')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="group">
                            <x-input-label for="kategori" :value="__('Kategori')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="kategori" name="kategori" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="">-- Pilih Kategori --</option>
                                <option value="habis_pakai"
                                    {{ old('kategori', $barangKeluar->kategori) == 'habis_pakai' ? 'selected' : '' }}>
                                    Habis Pakai</option>
                                <option value="rusak"
                                    {{ old('kategori', $barangKeluar->kategori) == 'rusak' ? 'selected' : '' }}>
                                    Rusak</option>
                                <option value="tidak_layak"
                                    {{ old('kategori', $barangKeluar->kategori) == 'tidak_layak' ? 'selected' : '' }}>
                                    Tidak Layak</option>
                                <option value="sedang_diperbaiki"
                                    {{ old('kategori', $barangKeluar->kategori) == 'sedang_diperbaiki' ? 'selected' : '' }}>
                                    Sedang Diperbaiki</option>
                                <option value="dihibahkan"
                                    {{ old('kategori', $barangKeluar->kategori) == 'dihibahkan' ? 'selected' : '' }}>
                                    Dihibahkan</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <!-- Penerima -->
                        <div class="group">
                            <x-input-label for="penerima" :value="__('Penerima')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />
                            <x-text-input id="penerima"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="penerima" :value="old('penerima', $barangKeluar->penerima)"
                                placeholder="Nama penerima (opsional)" />
                            <x-input-error :messages="$errors->get('penerima')" class="mt-2" />
                        </div>

                        <!-- Jumlah -->
                        <div class="group md:col-span-2">
                            <x-input-label for="jumlah" :value="__('Jumlah Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="jumlah"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="number" name="jumlah" :value="old('jumlah', $barangKeluar->jumlah)" min="1" required
                                x-model="jumlah" />
                            <p class="mt-1 text-xs text-gray-500">Pilih barang sebanyak jumlah yang diinput</p>
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="group md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />
                            <textarea id="keterangan" name="keterangan" rows="3"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Catatan tambahan...">{{ old('keterangan', $barangKeluar->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div
                    class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Barang yang Dipilih Sebelumnya
                    </h4>
                    <div class="space-y-1 mt-3">
                        @foreach ($barangKeluar->items as $item)
                            <p class="text-sm text-green-800 dark:text-green-200">
                                • {{ $item->barang->nama_barang }}
                                @if ($item->barang->kode_barang)
                                    <span class="font-mono text-xs bg-green-100 dark:bg-green-800 px-2 py-0.5 rounded">
                                        {{ $item->barang->jenisBarang->kode_utama . '' . $item->barang->kode_barang }}
                                    </span>
                                @endif
                            </p>
                        @endforeach
                    </div>
                    <p class="text-xs text-green-700 dark:text-green-300 mt-3 italic">
                        Pilih barang baru di bawah untuk mengganti barang yang sudah dipilih sebelumnya
                    </p>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pilih Barang yang Keluar
                        </h3>
                        <span
                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold"
                            x-text="`${selectedBarang.length} / ${jumlah} dipilih`"></span>
                    </div>

                    <div x-show="!selectedJenis"
                        class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            Silakan pilih jenis barang terlebih dahulu
                        </p>
                    </div>

                    <div x-show="loading" class="flex justify-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    </div>

                    <div x-show="!loading && availableBarang.length > 0"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="barang in availableBarang" :key="barang.barang_id">
                            <div @click="toggleBarang(barang)"
                                :class="{
                                    'border-blue-500 bg-blue-50 dark:bg-blue-900/20': isSelected(barang.barang_id),
                                    'border-gray-200 dark:border-gray-600 hover:border-gray-300': !isSelected(barang
                                        .barang_id)
                                }"
                                class="relative border-2 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:shadow-md">

                                <div class="absolute top-3 right-3">
                                    <input type="checkbox" name="barang_ids[]" :value="barang.barang_id"
                                        :checked="isSelected(barang.barang_id)"
                                        class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                                </div>

                                <div class="pr-8">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-2"
                                        x-text="barang.nama_barang"></h4>

                                    <div class="space-y-1">
                                        <p class="text-xs text-gray-600 dark:text-gray-400"
                                            x-show="barang.kode_barang || kodeUtama">
                                            <span class="font-semibold text-blue-600 dark:text-blue-400">Kode:</span>
                                            <span class="font-mono font-medium"
                                                x-text="getFullKodeBarang(barang)"></span>
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">Merk:</span> <span x-text="barang.merk"></span>
                                        </p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400" x-show="barang.lokasi">
                                            <span class="font-medium">Lokasi:</span> <span
                                                x-text="barang.lokasi"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="!loading && selectedJenis && availableBarang.length === 0"
                        class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400">Tidak ada barang tersedia untuk jenis ini</p>
                    </div>
                </div>

                <div x-show="selectedBarang.length > 0 && selectedBarang.length != jumlah"
                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <p class="text-sm text-red-800 dark:text-red-200">
                        Jumlah barang yang dipilih (<span x-text="selectedBarang.length"></span>) tidak sesuai dengan
                        jumlah yang diinput (<span x-text="jumlah"></span>)
                    </p>
                </div>

                <div
                    class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('barang-keluar.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Batal') }}
                    </a>

                    <button type="submit" x-data @click="$dispatch('open-modal', 'update_confirmation')"
                        :disabled="selectedBarang.length != jumlah || selectedBarang.length === 0"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Perbarui') }}
                    </button>
                </div>

                <x-confirm-modal id="update_confirmation"
                    message="Apakah Anda yakin ingin memperbarui data barang keluar ini?" okLabel="Perbarui"
                    cancelLabel="Batal" :url="route('barang-keluar.update', $barangKeluar->keluar_id)" formId="update_barang_keluar" />
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function barangKeluarEditForm() {
                return {
                    selectedJenis: '{{ old('jenis_barang_id', $barangKeluar->jenis_barang_id) }}',
                    kodeUtama: '',
                    availableBarang: [],
                    selectedBarang: [],
                    jumlah: {{ old('jumlah', $barangKeluar->jumlah) }},
                    loading: false,

                    init() {
                        if (this.selectedJenis) {
                            const selectElement = document.getElementById('jenis_barang_id');
                            const selectedOption = selectElement.options[selectElement.selectedIndex];
                            this.kodeUtama = selectedOption.getAttribute('data-kode') || '';
                            this.loadAvailableBarang();
                        }
                    },

                    async loadAvailableBarang() {
                        if (!this.selectedJenis) {
                            this.availableBarang = [];
                            this.kodeUtama = '';
                            return;
                        }

                        const selectElement = document.getElementById('jenis_barang_id');
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        this.kodeUtama = selectedOption.getAttribute('data-kode') || '';

                        this.loading = true;
                        this.selectedBarang = [];

                        try {
                            const response = await fetch(`/barang-keluar/get-available-barang/${this.selectedJenis}`);
                            const data = await response.json();
                            this.availableBarang = data;
                            this.selectedBarang = data.filter(b => (b.kondisi === 'diperbaiki') || (b.status ===
                                'nonaktif'));

                        } catch (error) {
                            console.error('Error loading barang:', error);
                            this.availableBarang = [];
                        } finally {
                            this.loading = false;
                        }
                    },

                    getFullKodeBarang(barang) {
                        if (barang.kode_barang) {
                            return this.kodeUtama + '' + barang.kode_barang;
                        }

                        return '-';
                    },

                    toggleBarang(barang) {
                        const index = this.selectedBarang.findIndex(b => b.barang_id === barang.barang_id);

                        if (index > -1) {
                            this.selectedBarang.splice(index, 1);
                        } else {
                            if (this.selectedBarang.length < this.jumlah) {
                                this.selectedBarang.push(barang);
                            }
                        }
                    },

                    isSelected(barangId) {
                        return this.selectedBarang.some(b => b.barang_id === barangId);
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
