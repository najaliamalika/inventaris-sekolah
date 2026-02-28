<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Tambah Peminjaman Baru') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Catat peminjaman barang baru</p>
        </div>
    </x-slot>

    <div class="mb-6 max-w-5xl mx-auto px-6">
        <a href="{{ route('peminjaman.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200 group">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="text-sm font-medium">{{ __('Kembali') }}</span>
        </a>
    </div>

    <div class="max-w-5xl mx-auto px-6 pb-12">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="p-8">
                <form id="create_peminjaman" method="POST" action="{{ route('peminjaman.store') }}"
                    enctype="multipart/form-data" class="space-y-6" x-data="peminjamanForm()">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="tanggal_peminjaman" :value="__('Tanggal Peminjaman')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal_peminjaman"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal_peminjaman" :value="old('tanggal_peminjaman', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_peminjaman')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="nama_peminjam" :value="__('Nama Peminjam')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama_peminjam"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="nama_peminjam" placeholder="Contoh: John Doe" required
                                :value="old('nama_peminjam')" />
                            <x-input-error :messages="$errors->get('nama_peminjam')" class="mt-2" />
                        </div>
                    </div>

                    <div class="group">
                        <x-input-label for="keterangan" :value="__('Keterangan Peminjaman')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                        </x-input-label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                            placeholder="Contoh: Untuk keperluan proyek X (opsional)">{{ old('keterangan') }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    <div class="group">
                        <x-input-label for="foto_peminjaman" :value="__('Foto Peminjaman')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                            <span class="text-red-500">*</span>
                        </x-input-label>

                        <div class="relative">
                            <label
                                class="flex items-center justify-between w-full px-4 py-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 focus-within:border-green-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                for="foto_peminjaman">
                                <span id="fileName" class="text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    📷 Pilih foto peminjaman (jpg, jpeg, png - Max 5MB)
                                </span>
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </label>

                            <input id="foto_peminjaman" class="hidden" type="file" name="foto_peminjaman"
                                accept="image/*" required />
                        </div>

                        <div id="preview_wrapper" class="mt-4 hidden">
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-600">
                                <p
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Preview Foto:
                                </p>
                                <div class="relative inline-block">
                                    <img id="image_preview" src="" alt="Preview"
                                        class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-white dark:border-gray-600" />
                                    <button type="button" id="removeImage"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('foto_peminjaman')" class="mt-2" />
                    </div>

                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Pilih Barang yang Dipinjam
                        </h3>

                        <div class="group mb-6">
                            <x-input-label for="jenis_barang_id" :value="__('Filter Jenis Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />

                            <div @dropdown-changed="handleJenisBarangChange($event.detail)">
                                <x-dropdown name="jenis_barang_filter" id="jenis_barang_id"
                                    placeholder="-- Pilih Jenis Barang Dulu --" :options="$jenisBarang->map(
                                        fn($jenis) => [
                                            'value' => $jenis->jenis_barang_id,
                                            'label' =>
                                                $jenis->jenis . ' (Stok Tersedia: ' . $jenis->stok_tersedia . ')',
                                            'kode' => $jenis->kode_utama,
                                        ],
                                    )" searchable />
                            </div>

                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Pilih jenis barang untuk melihat
                                daftar barang yang tersedia</p>
                        </div>

                        <div x-show="!selectedJenis"
                            class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                ⚠️ Silakan pilih jenis barang terlebih dahulu untuk melihat daftar barang yang tersedia
                            </p>
                        </div>

                        <div x-show="loading" class="flex justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                        </div>

                        <div x-show="!loading && availableBarang.length > 0">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Klik barang untuk menambahkan ke daftar peminjaman
                                </p>
                                <span
                                    class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-semibold"
                                    x-text="`${selectedBarang.length} dipilih`"></span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                <template x-for="barang in availableBarang" :key="barang.barang_id">
                                    <div @click="toggleBarang(barang)"
                                        :class="{
                                            'border-green-500 bg-green-50 dark:bg-green-900/20': isSelected(barang
                                                .barang_id),
                                            'border-gray-200 dark:border-gray-600 hover:border-gray-300': !isSelected(
                                                barang.barang_id)
                                        }"
                                        class="relative border-2 rounded-xl p-4 cursor-pointer transition-all duration-200 hover:shadow-md">

                                        <div class="absolute top-3 right-3">
                                            <div :class="isSelected(barang.barang_id) ? 'bg-green-500 border-green-500' :
                                                'border-gray-300 dark:border-gray-500'"
                                                class="w-5 h-5 rounded border-2 flex items-center justify-center transition-all">
                                                <svg x-show="isSelected(barang.barang_id)" class="w-3 h-3 text-white"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="pr-8">
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-2"
                                                x-text="barang.nama_barang"></h4>
                                            <div class="space-y-1">
                                                <p class="text-xs text-gray-600 dark:text-gray-400"
                                                    x-show="barang.kode_barang">
                                                    <span
                                                        class="font-semibold text-green-600 dark:text-green-400">Kode:</span>
                                                    <span class="font-mono font-medium"
                                                        x-text="getFullKodeBarang(barang)"></span>
                                                </p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400"
                                                    x-show="barang.merk">
                                                    <span class="font-medium">Merk:</span> <span
                                                        x-text="barang.merk"></span>
                                                </p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400"
                                                    x-show="barang.lokasi">
                                                    <span class="font-medium">Lokasi:</span> <span
                                                        x-text="barang.lokasi"></span>
                                                </p>
                                                <span
                                                    class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400"
                                                    x-text="barang.kondisi"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="!loading && selectedJenis && availableBarang.length === 0"
                            class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-xl mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-gray-600 dark:text-gray-400">Tidak ada barang tersedia untuk jenis ini</p>
                        </div>

                        <div x-show="selectedBarang.length > 0">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-md font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Barang yang Akan Dipinjam
                                </h4>
                                <span
                                    class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full text-sm font-semibold"
                                    x-text="`${selectedBarang.length} Barang`"></span>
                            </div>

                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl border-2 border-gray-200 dark:border-gray-600 overflow-hidden">
                                <template x-for="(barang, index) in selectedBarang" :key="barang.barang_id">
                                    <div
                                        class="flex items-center justify-between px-5 py-3 border-b border-gray-200 dark:border-gray-600 last:border-b-0">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="flex items-center justify-center w-7 h-7 bg-green-600 text-white rounded-full text-xs font-bold"
                                                x-text="index + 1"></span>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200"
                                                    x-text="barang.nama_barang"></p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 font-mono"
                                                    x-text="getFullKodeBarang(barang)"></p>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeSelected(barang.barang_id)"
                                            class="text-red-500 hover:text-red-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <input type="hidden" :name="`barang_ids[${index}]`" :value="barang.barang_id">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div x-show="selectedJenis && availableBarang.length > 0 && selectedBarang.length === 0"
                            class="mt-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-4">
                            <p class="text-sm text-orange-800 dark:text-orange-200">
                                ⚠️ Belum ada barang yang dipilih. Klik barang di atas untuk menambahkannya.
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                        <a href="{{ route('peminjaman.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Batal') }}
                        </a>

                        <button type="button" x-data @click="$dispatch('open-modal', 'save_confirmation')"
                            :disabled="selectedBarang.length === 0"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Simpan Peminjaman') }}
                        </button>
                    </div>

                    <x-confirm-modal id="save_confirmation"
                        message="Apakah Anda yakin ingin menyimpan data peminjaman ini?" okLabel="Simpan"
                        cancelLabel="Batal" :url="route('peminjaman.store')" formId="create_peminjaman" />
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function peminjamanForm() {
                const jenisBarangList = @json($jenisBarang);

                return {
                    selectedJenis: '',
                    kodeUtama: '',
                    availableBarang: [],
                    selectedBarang: [],
                    loading: false,

                    handleJenisBarangChange(jenisBarangId) {
                        this.selectedJenis = jenisBarangId;

                        const jenis = jenisBarangList.find(j => j.jenis_barang_id === jenisBarangId);
                        if (jenis) {
                            this.kodeUtama = jenis.kode_utama;
                        }

                        this.loadAvailableBarang();
                    },

                    async loadAvailableBarang() {
                        if (!this.selectedJenis) {
                            this.availableBarang = [];
                            this.kodeUtama = '';
                            return;
                        }

                        this.loading = true;

                        try {
                            const response = await fetch(`/peminjaman/get-available-barang/${this.selectedJenis}`);
                            const data = await response.json();
                            this.availableBarang = data;
                        } catch (error) {
                            console.error('Error loading barang:', error);
                            this.availableBarang = [];
                        } finally {
                            this.loading = false;
                        }
                    },

                    getFullKodeBarang(barang) {
                        const kodeUtama = barang.jenis_barang?.kode_utama ?? '';
                        if (barang.kode_barang) {
                            return kodeUtama + '' + barang.kode_barang;
                        }
                        return '-';
                    },

                    toggleBarang(barang) {
                        const index = this.selectedBarang.findIndex(b => b.barang_id === barang.barang_id);
                        if (index > -1) {
                            this.selectedBarang.splice(index, 1);
                        } else {
                            this.selectedBarang.push(barang);
                        }
                    },

                    isSelected(barangId) {
                        return this.selectedBarang.some(b => b.barang_id === barangId);
                    },

                    removeSelected(barangId) {
                        this.selectedBarang = this.selectedBarang.filter(b => b.barang_id !== barangId);
                    }
                }
            }

            const fileInput = document.getElementById('foto_peminjaman');
            const fileNameDisplay = document.getElementById('fileName');
            const previewWrapper = document.getElementById('preview_wrapper');
            const previewImage = document.getElementById('image_preview');
            const removeImageBtn = document.getElementById('removeImage');

            fileInput.addEventListener('change', function(e) {
                const file = this.files[0];

                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB');
                        this.value = '';
                        return;
                    }

                    fileNameDisplay.textContent = '✓ ' + file.name;
                    fileNameDisplay.classList.remove('text-gray-500', 'dark:text-gray-400');
                    fileNameDisplay.classList.add('text-green-600', 'dark:text-green-400', 'font-semibold');

                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewWrapper.classList.remove('hidden');
                            previewWrapper.classList.add('animate-fade-in');
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                fileNameDisplay.textContent = '📷 Pilih foto peminjaman (jpg, jpeg, png - Max 5MB)';
                fileNameDisplay.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                fileNameDisplay.classList.add('text-gray-500', 'dark:text-gray-400');
                previewWrapper.classList.add('hidden');
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
    @endpush
</x-app-layout>
