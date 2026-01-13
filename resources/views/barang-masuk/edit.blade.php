<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Barang Masuk') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Perbarui data barang masuk</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('barang-masuk.index') }}"
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
            <form id="update_barang_masuk" method="POST"
                action="{{ route('barang-masuk.update', $barangMasuk->masuk_id) }}" class="space-y-6"
                x-data="barangMasukEditForm()">
                @csrf
                @method('PUT')

                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Umum</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="tanggal" :value="__('Tanggal')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal" :value="old('tanggal', $barangMasuk->tanggal->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="kategori" :value="__('Kategori')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-dropdown name="kategori" id="kategori" placeholder="Pilih Kategori" :selected="old('kategori', $barangMasuk->kategori)"
                                :options="[
                                    ['value' => 'pembelian', 'label' => 'Pembelian'],
                                    ['value' => 'bantuan', 'label' => 'Bantuan'],
                                ]" required />
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2">
                            <x-input-label for="nama_supplier" :value="__('Nama Supplier')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama_supplier"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="nama_supplier" :value="old('nama_supplier', $barangMasuk->nama_supplier)"
                                placeholder="Contoh: PT. Maju Jaya, CV. Sukses Bersama" required />
                            <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />
                            <textarea id="keterangan" name="keterangan" rows="3"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Catatan tambahan...">{{ old('keterangan', $barangMasuk->keterangan) }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Barang</h3>
                        <button type="button" @click="addDetail"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Jenis Barang
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(detail, detailIndex) in details" :key="detailIndex">
                            <div
                                class="detail-item bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 p-6 rounded-xl border-2 border-gray-200 dark:border-gray-600">
                                <!-- Hidden input untuk detail_id jika ada -->
                                <input x-show="detail.detail_id" type="hidden" name="detail_ids[]"
                                    x-model="detail.detail_id">

                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <span
                                            class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm"
                                            x-text="detailIndex + 1"></span>
                                        <span>Jenis Barang <span x-text="detailIndex + 1"></span></span>
                                    </h4>
                                    <button type="button" @click="removeDetail(detailIndex)"
                                        x-show="details.length > 1"
                                        class="text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="space-y-4">
                                    <!-- Jenis Barang Dropdown -->
                                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Jenis Barang <span class="text-red-500">*</span>
                                            <a class="text-green-600 font-bold hover:underline text-xs"
                                                href="{{ route('jenis-barang.create') }}" target="_blank">
                                                (Tambah Baru)
                                            </a>
                                        </label>

                                        <div x-data="{
                                            open: false,
                                            search: '',
                                            options: {{ json_encode(
                                                $jenisBarang->map(
                                                        fn($jenis) => [
                                                            'value' => $jenis->jenis_barang_id,
                                                            'label' => $jenis->jenis . ' - Kode Prefix: ' . $jenis->kode_utama,
                                                        ],
                                                    )->values(),
                                            ) }},
                                            filteredOptions: {{ json_encode(
                                                $jenisBarang->map(
                                                        fn($jenis) => [
                                                            'value' => $jenis->jenis_barang_id,
                                                            'label' => $jenis->jenis . ' - Kode Prefix: ' . $jenis->kode_utama,
                                                        ],
                                                    )->values(),
                                            ) }},
                                        
                                            getLabel() {
                                                const selected = this.options.find(opt => opt.value == detail.jenis_barang_id);
                                                return selected ? selected.label : '-- Pilih Jenis Barang --';
                                            },
                                        
                                            selectOption(option) {
                                                detail.jenis_barang_id = option.value;
                                                selectJenisBarang(detailIndex, option.value);
                                                this.open = false;
                                                this.search = '';
                                                this.filteredOptions = this.options;
                                            },
                                        
                                            filterOptions() {
                                                if (!this.search) {
                                                    this.filteredOptions = this.options;
                                                    return;
                                                }
                                                this.filteredOptions = this.options.filter(option =>
                                                    option.label.toLowerCase().includes(this.search.toLowerCase())
                                                );
                                            }
                                        }" @click.away="open = false"
                                            class="relative w-full">

                                            <button type="button" @click="open = !open"
                                                class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white text-left flex items-center justify-between"
                                                :class="{ 'border-green-500 ring-2 ring-green-500/20': open }">
                                                <span x-text="getLabel()" class="truncate"
                                                    :class="{ 'text-gray-400 dark:text-gray-500': !detail.jenis_barang_id }"></span>
                                                <svg class="w-5 h-5 transition-transform"
                                                    :class="{ 'rotate-180': open }" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>

                                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute z-50 w-full mt-2 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-hidden"
                                                style="display: none;">

                                                <div class="p-2 border-b border-gray-200 dark:border-gray-600">
                                                    <input type="text" x-model="search" @input="filterOptions"
                                                        @click.stop placeholder="Cari..."
                                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white text-sm">
                                                </div>

                                                <div class="overflow-y-auto max-h-48">
                                                    <template x-for="option in filteredOptions" :key="option.value">
                                                        <button type="button" @click="selectOption(option)"
                                                            class="w-full px-4 py-2.5 text-left hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                                                            :class="{
                                                                'bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400': detail
                                                                    .jenis_barang_id == option.value
                                                            }">
                                                            <span x-text="option.label"></span>
                                                        </button>
                                                    </template>

                                                    <div x-show="filteredOptions.length === 0"
                                                        class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 text-sm">
                                                        Tidak ada hasil ditemukan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" :name="'jenis_barang_ids[' + detailIndex + ']'"
                                            x-model="detail.jenis_barang_id" required>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <!-- Jumlah -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Jumlah Barang <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" :name="'jumlah[' + detailIndex + ']'"
                                                x-model="detail.jumlah" @change="updateBarangItems(detailIndex)"
                                                min="1" required
                                                class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white">
                                        </div>

                                        <!-- Harga Satuan -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Harga Satuan
                                            </label>
                                            <!-- Input untuk display (dengan format) -->
                                            <input type="text" x-model="detail.harga_satuan_display"
                                                @input="updateHargaSatuan(detailIndex, $event.target.value)"
                                                inputmode="numeric"
                                                class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                                placeholder="0">
                                            <!-- Hidden input untuk submit (tanpa format) -->
                                            <input type="hidden" :name="'harga_satuan[' + detailIndex + ']'"
                                                x-model="detail.harga_satuan">
                                        </div>

                                        <!-- Lokasi Default -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                Lokasi Default
                                            </label>
                                            <input type="text" x-model="detail.lokasi_default"
                                                @change="applyLokasiToAll(detailIndex)"
                                                class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                                placeholder="Gudang A">
                                        </div>
                                    </div>

                                    <!-- Keterangan Detail -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Keterangan Item
                                        </label>
                                        <input type="text" :name="'keterangan_detail[' + detailIndex + ']'"
                                            x-model="detail.keterangan_detail"
                                            class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                            placeholder="Catatan khusus untuk jenis barang ini...">
                                    </div>

                                    <!-- Barang Items Container -->
                                    <div
                                        class="barang-items-container bg-green-50 dark:bg-green-900/10 p-4 rounded-lg border border-green-200 dark:border-green-800">
                                        <div class="flex items-center justify-between mb-3">
                                            <h5 class="font-semibold text-sm text-gray-700 dark:text-gray-300">Detail
                                                Barang Individual</h5>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Sesuai dengan jumlah
                                                barang</span>
                                        </div>
                                        <div class="space-y-3">
                                            <template x-for="(barang, barangIndex) in detail.barang_items"
                                                :key="barangIndex">
                                                <div
                                                    class="barang-item bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                                    <!-- Hidden input untuk barang_id jika ada -->
                                                    <input x-show="barang.barang_id" type="hidden"
                                                        :name="'barang_ids[' + detailIndex + '][' + barangIndex + ']'"
                                                        x-model="barang.barang_id">

                                                    <div class="flex items-center gap-2 mb-3">
                                                        <span
                                                            class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                                            Barang <span x-text="barangIndex + 1"></span>
                                                        </span>
                                                    </div>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                Nama Barang <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                :name="'list_barang[' + detailIndex + '][' + barangIndex +
                                                                    '][nama_barang]'"
                                                                x-model="barang.nama_barang" required
                                                                class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                                                                placeholder="Contoh: Laptop HP ProBook 450 G8">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                Kode Barang
                                                            </label>
                                                            <input type="text"
                                                                :name="'list_barang[' + detailIndex + '][' + barangIndex +
                                                                    '][kode_barang]'"
                                                                x-model="barang.kode_barang"
                                                                class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                                                                :placeholder="detail.kode_prefix ? 'Sudah berawal ' + detail
                                                                    .kode_prefix : ''">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                Merk <span class="text-red-500">*</span>
                                                            </label>
                                                            <input type="text"
                                                                :name="'list_barang[' + detailIndex + '][' + barangIndex +
                                                                    '][merk]'"
                                                                x-model="barang.merk" required
                                                                class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                                                                placeholder="HP">
                                                        </div>
                                                        <div>
                                                            <label
                                                                class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                                                                Lokasi
                                                            </label>
                                                            <input type="text"
                                                                :name="'list_barang[' + detailIndex + '][' + barangIndex +
                                                                    '][lokasi]'"
                                                                x-model="barang.lokasi"
                                                                class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                                                                placeholder="Gudang A">
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('barang-masuk.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Batal') }}
                    </a>

                    <button type="button" @click="submitForm"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Perbarui') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function barangMasukEditForm() {
                const jenisBarangList = @json($jenisBarang);
                const existingDetails = @json($barangMasuk->details->load('barangItems'));

                return {
                    details: [],

                    init() {
                        // Load existing details
                        existingDetails.forEach(detail => {
                            this.details.push({
                                detail_id: detail.detail_id,
                                jenis_barang_id: detail.jenis_barang_id,
                                jumlah: detail.jumlah,
                                harga_satuan: detail.harga_satuan.toString(),
                                harga_satuan_display: this.formatCurrency(detail.harga_satuan.toString()),
                                lokasi_default: '',
                                keterangan_detail: detail.keterangan || '',
                                kode_prefix: this.getKodePrefix(detail.jenis_barang_id),
                                barang_items: detail.barang_items.map(barang => ({
                                    barang_id: barang.barang_id,
                                    nama_barang: barang.nama_barang,
                                    kode_barang: barang.kode_barang || '',
                                    merk: barang.merk,
                                    lokasi: barang.lokasi || ''
                                }))
                            });
                        });
                    },

                    getKodePrefix(jenisBarangId) {
                        const jenis = jenisBarangList.find(j => j.jenis_barang_id === jenisBarangId);
                        return jenis ? jenis.kode_utama : '';
                    },

                    addDetail() {
                        this.details.push({
                            detail_id: null,
                            jenis_barang_id: '',
                            jumlah: 1,
                            harga_satuan: '0',
                            harga_satuan_display: '0',
                            lokasi_default: '',
                            keterangan_detail: '',
                            kode_prefix: '',
                            barang_items: [this.createBarangItem()]
                        });
                    },

                    removeDetail(index) {
                        if (this.details.length > 1) {
                            if (confirm('Yakin ingin menghapus jenis barang ini dan semua barang di dalamnya?')) {
                                this.details.splice(index, 1);
                            }
                        } else {
                            alert('Minimal harus ada 1 jenis barang');
                        }
                    },

                    createBarangItem() {
                        return {
                            barang_id: null,
                            nama_barang: '',
                            kode_barang: '',
                            merk: '',
                            lokasi: ''
                        };
                    },

                    selectJenisBarang(detailIndex, jenisBarangId) {
                        const detail = this.details[detailIndex];
                        detail.jenis_barang_id = jenisBarangId;

                        const jenis = jenisBarangList.find(j => j.jenis_barang_id === jenisBarangId);
                        if (jenis) {
                            detail.kode_prefix = jenis.kode_utama;
                        }

                        this.updateBarangItems(detailIndex);
                    },

                    updateBarangItems(detailIndex) {
                        const detail = this.details[detailIndex];
                        const jumlah = parseInt(detail.jumlah) || 1;

                        if (detail.barang_items.length < jumlah) {
                            while (detail.barang_items.length < jumlah) {
                                detail.barang_items.push(this.createBarangItem());
                            }
                        } else if (detail.barang_items.length > jumlah) {
                            detail.barang_items.splice(jumlah);
                        }

                        this.applyLokasiToAll(detailIndex);
                    },

                    applyLokasiToAll(detailIndex) {
                        const detail = this.details[detailIndex];
                        if (detail.lokasi_default) {
                            detail.barang_items.forEach(item => {
                                if (!item.lokasi) {
                                    item.lokasi = detail.lokasi_default;
                                }
                            });
                        }
                    },

                    updateHargaSatuan(detailIndex, value) {
                        const detail = this.details[detailIndex];

                        const cleanValue = value.replace(/\D/g, '');
                        detail.harga_satuan = cleanValue;

                        detail.harga_satuan_display = cleanValue ? cleanValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
                    },

                    formatCurrency(value) {
                        const cleaned = String(value).replace(/\D/g, '');
                        return cleaned ? cleaned.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
                    },

                    submitForm() {
                        this.$el.closest('form').submit();
                    }
                };
            }
        </script>
    @endpush
</x-app-layout>
