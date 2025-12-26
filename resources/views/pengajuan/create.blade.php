<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Buat Pengajuan') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Buat pengajuan pembelian atau perbaikan barang</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('pengajuan.index') }}"
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
            <form id="create_pengajuan" method="POST" action="{{ route('pengajuan.store') }}" class="space-y-6"
                x-data="pengajuanForm()">
                @csrf

                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pengajuan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="tanggal" :value="__('Tanggal')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal" :value="old('tanggal', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="tipe" :value="__('Tipe Pengajuan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="tipe" name="tipe" required x-model="tipe" @change="onTipeChange()"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="pembelian">🛒 Pembelian Barang Baru</option>
                                <option value="perbaikan">🔧 Perbaikan Barang</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                <span x-show="tipe === 'pembelian'">Untuk mengajukan pembelian barang baru</span>
                                <span x-show="tipe === 'perbaikan'">Untuk mengajukan perbaikan barang yang rusak</span>
                            </p>
                            <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2" x-show="tipe === 'perbaikan'">
                            <x-input-label for="jenis_barang_id" :value="__('Jenis Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="jenis_barang_id" name="jenis_barang_id" x-model="selectedJenis"
                                @change="loadAvailableBarang()" :required="tipe === 'perbaikan'"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="">-- Pilih Jenis Barang --</option>
                                @foreach ($jenisBarang as $jenis)
                                    <option value="{{ $jenis->jenis_barang_id }}"
                                        data-kode-utama="{{ $jenis->kode_utama }}">
                                        {{ $jenis->jenis }} (Tersedia:
                                        {{ $jenis->barang()->tersedia()->get()->count() }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_barang_id')" class="mt-2" />
                        </div>

                        <div x-show="tipe !== 'perbaikan'" class="group md:col-span-2">
                            <x-input-label for="nama_barang" :value="__('Nama Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama_barang"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="nama_barang" x-model="nama_barang"
                                x-bind:required="tipe !== 'perbaikan'" placeholder="Contoh: Laptop HP ProBook 450 G8" />
                            <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="jumlah" :value="__('Jumlah')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="jumlah"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="number" name="jumlah" :value="old('jumlah', 1)" min="1" required
                                x-model="jumlah" @input="checkSelectionLimit()" />
                            <p class="mt-1 text-xs text-gray-500" x-show="tipe === 'perbaikan'">
                                Pilih barang sebanyak jumlah yang diinput
                            </p>
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="estimasi_biaya" :value="__('Estimasi Biaya (Rp)')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="estimasi_biaya"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="number" name="estimasi_biaya" :value="old('estimasi_biaya', 0)" min="0" required
                                placeholder="0" />
                            <x-input-error :messages="$errors->get('estimasi_biaya')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2">
                            <x-input-label for="alasan" :value="__('Alasan Pengajuan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <textarea id="alasan" name="alasan" rows="4" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Jelaskan alasan pengajuan secara detail...">{{ old('alasan') }}</textarea>
                            <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div x-show="tipe === 'perbaikan'">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Pilih Barang yang Akan
                            Diperbaiki</h3>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold"
                            :class="selectedBarang.length == jumlah ?
                                'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' :
                                'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200'"
                            x-text="`${selectedBarang.length} / ${jumlah} dipilih`"></span>
                    </div>

                    <div x-show="!selectedJenis"
                        class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 flex-shrink-0 mt-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-sm text-yellow-800 dark:text-yellow-200 font-medium">
                                Silakan pilih jenis barang terlebih dahulu untuk melihat daftar barang yang tersedia
                            </p>
                        </div>
                    </div>

                    <div x-show="loading" class="flex flex-col items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mb-4"></div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Memuat data barang...</p>
                    </div>

                    <div x-show="!loading && availableBarang.length > 0"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="barang in availableBarang" :key="barang.barang_id">
                            <div @click="toggleBarang(barang)"
                                :class="{
                                    'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20 shadow-md': isSelected(barang
                                        .barang_id),
                                    'border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-700':
                                        !isSelected(barang.barang_id)
                                }"
                                class="relative border-2 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:shadow-md">

                                <div x-show="isSelected(barang.barang_id)"
                                    class="absolute -top-2 -right-2 bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>

                                <input type="checkbox" name="barang_ids[]" :value="barang.barang_id"
                                    :checked="isSelected(barang.barang_id)" class="hidden">

                                <div class="pr-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-2 line-clamp-2"
                                        x-text="barang.nama_barang"></h4>

                                    <div class="space-y-2">
                                        <div x-show="barang.kode_barang"
                                            class="flex items-center gap-2 text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 px-2 py-1 rounded">
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                            <span class="font-mono font-semibold"
                                                x-text="getFullKodeBarang(barang)"></span>
                                        </div>

                                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <span class="font-medium" x-text="barang.merk"></span>
                                        </div>

                                        <div x-show="barang.lokasi"
                                            class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span x-text="barang.lokasi"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div x-show="!loading && selectedJenis && availableBarang.length === 0"
                        class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-gray-600 dark:text-gray-400 font-medium mb-1">Tidak ada barang tersedia</p>
                        <p class="text-gray-500 dark:text-gray-500 text-sm">Semua barang untuk jenis ini sedang tidak
                            tersedia atau dalam kondisi tidak baik</p>
                    </div>

                    <div x-show="selectedBarang.length > 0 && selectedBarang.length != jumlah"
                        class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mt-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-red-800 dark:text-red-200">
                                <p class="font-semibold mb-1">Jumlah barang tidak sesuai</p>
                                <p>Anda telah memilih <strong x-text="selectedBarang.length"></strong> barang, tetapi
                                    jumlah yang diinput adalah <strong x-text="jumlah"></strong>. Silakan sesuaikan
                                    pilihan Anda.</p>
                            </div>
                        </div>
                    </div>

                    <div x-show="selectedBarang.length > 0 && selectedBarang.length == jumlah"
                        class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 mt-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="text-sm text-green-800 dark:text-green-200">
                                <p class="font-semibold">Pilihan lengkap!</p>
                                <p>Anda telah memilih semua barang yang diperlukan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                    <div class="flex gap-3">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <p class="font-semibold mb-2">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pengajuan akan masuk ke status <strong>Menunggu</strong> setelah dibuat</li>
                                <li x-show="tipe === 'perbaikan'">Jika disetujui, barang akan otomatis masuk ke
                                    <strong>Barang Keluar</strong> dengan status "Sedang Diperbaiki"
                                </li>
                                <li x-show="tipe === 'pembelian'">Jika disetujui, Anda dapat melanjutkan dengan proses
                                    pembelian</li>
                                <li x-show="tipe === 'perbaikan'">Pastikan jumlah barang yang dipilih sesuai dengan
                                    jumlah yang diinput</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('pengajuan.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Batal') }}
                    </a>

                    <button type="submit"
                        :disabled="(tipe === 'perbaikan' && selectedBarang.length != jumlah) || !tipe"
                        class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-700 hover:to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        {{ __('Ajukan Sekarang') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function pengajuanForm() {
                return {
                    tipe: '{{ old('tipe') }}',
                    selectedJenis: '{{ old('jenis_barang_id') }}',
                    kodeUtama: '',
                    availableBarang: [],
                    selectedBarang: [],
                    jumlah: {{ old('jumlah', 1) }},
                    loading: false,
                    nama_barang: '{{ old('nama_barang') }}',

                    init() {
                        if (this.tipe === 'perbaikan' && this.selectedJenis) {
                            this.loadAvailableBarang();
                        }
                    },

                    onTipeChange() {
                        this.selectedJenis = '';
                        this.kodeUtama = '';
                        this.availableBarang = [];
                        this.selectedBarang = [];
                        this.nama_barang = '';
                    },

                    async loadAvailableBarang() {
                        if (!this.selectedJenis) {
                            this.availableBarang = [];
                            return;
                        }

                        const selectedOption = document.querySelector(
                            `#jenis_barang_id option[value="${this.selectedJenis}"]`);
                        this.kodeUtama = selectedOption ? selectedOption.dataset.kodeUtama : '';

                        this.loading = true;
                        this.selectedBarang = [];

                        try {
                            const response = await fetch(`/api/pengajuan/available-barang/${this.selectedJenis}`);
                            const data = await response.json();
                            this.availableBarang = data;
                        } catch (error) {
                            console.error('Error loading barang:', error);
                            this.availableBarang = [];
                            alert('Gagal memuat data barang. Silakan coba lagi.');
                        } finally {
                            this.loading = false;
                        }
                    },

                    getFullKodeBarang(barang) {
                        if (!barang.kode_barang) return '-';
                        if (this.kodeUtama) {
                            return `${this.kodeUtama}${barang.kode_barang}`;
                        }
                        return barang.kode_barang;
                    },

                    toggleBarang(barang) {
                        const index = this.selectedBarang.findIndex(b => b.barang_id === barang.barang_id);

                        if (index > -1) {
                            this.selectedBarang.splice(index, 1);
                        } else {
                            if (this.selectedBarang.length < this.jumlah) {
                                this.selectedBarang.push(barang);
                            } else {
                                alert(`Anda hanya bisa memilih ${this.jumlah} barang sesuai dengan jumlah yang diinput.`);
                            }
                        }
                    },

                    checkSelectionLimit() {
                        if (this.selectedBarang.length > this.jumlah) {
                            this.selectedBarang = this.selectedBarang.slice(0, this.jumlah);
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
