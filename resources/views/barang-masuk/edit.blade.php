<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Barang Masuk') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Perbarui data barang masuk</p>
        </div>
    </x-slot>

    <!-- Back Button -->
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

    <!-- Main Card -->
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-8">
            <form id="update_barang_masuk" method="POST"
                action="{{ route('barang-masuk.update', $barangMasuk->masuk_id) }}" class="space-y-6">
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
                                type="date" name="tanggal" :value="old('tanggal', $barangMasuk->tanggal->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Kategori -->
                        <div class="group">
                            <x-input-label for="kategori" :value="__('Kategori')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="kategori" name="kategori" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="pembelian"
                                    {{ old('kategori', $barangMasuk->kategori) == 'pembelian' ? 'selected' : '' }}>💰
                                    Pembelian</option>
                                <option value="bantuan"
                                    {{ old('kategori', $barangMasuk->kategori) == 'bantuan' ? 'selected' : '' }}>🎁
                                    Bantuan</option>
                            </select>
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

                <!-- Detail Barang -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Barang</h3>
                        <button type="button" id="addDetailBtn"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Jenis Barang
                        </button>
                    </div>

                    <div id="detailContainer" class="space-y-6">
                    </div>
                </div>

                <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('barang-masuk.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Batal') }}
                    </a>

                    <button type="button" x-data @click="$dispatch('open-modal', 'update_confirmation')"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Perbarui') }}
                    </button>
                </div>

                <x-confirm-modal id="update_confirmation"
                    message="Apakah Anda yakin ingin memperbarui data barang masuk ini?" okLabel="Perbarui"
                    cancelLabel="Batal" :url="route('barang-masuk.update', $barangMasuk->masuk_id)" formId="update_barang_masuk" />
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let detailIndex = {{ $barangMasuk->details->count() }};
            const jenisBarangList = @json($jenisBarang);
            const existingDetails = @json($barangMasuk->details->load('barangItems'));

            // Template untuk detail item
            function createDetailItem(index, detail = null) {
                const jenisOptions = jenisBarangList.map(jenis => {
                    const selected = detail && jenis.jenis_barang_id === detail.jenis_barang_id ? 'selected' : '';
                    return `<option value="${jenis.jenis_barang_id}" ${selected}>${jenis.kategori} - ${jenis.jenis}</option>`;
                }).join('');

                const detailId = detail ? detail.detail_id : '';
                const jumlah = detail ? detail.jumlah : 1;
                const harga = detail ? detail.harga_satuan : 0;
                const keterangan = detail ? (detail.keterangan || '') : '';

                return `
            <div class="detail-item bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 p-6 rounded-xl border-2 border-gray-200 dark:border-gray-600" data-index="${index}">
                ${detailId ? `<input type="hidden" name="detail_ids[]" value="${detailId}">` : ''}
                
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">${index + 1}</span>
                        Jenis Barang #${index + 1}
                    </h4>
                    <button type="button" class="remove-detail-btn text-red-600 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 p-2 rounded-lg transition-all" data-index="${index}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Jenis Barang -->
                    <div class="bg-white dark:bg-gray-700 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Barang <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_barang_ids[]" required onchange="updateJenisInfo(${index})"
                            class="jenis-select block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white">
                            <option value="">-- Pilih Jenis Barang --</option>
                            ${jenisOptions}
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Jumlah -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jumlah Barang <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="jumlah[]" min="1" value="${jumlah}" required onchange="updateBarangItems(${index})"
                                class="jumlah-input block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Harga Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Harga Satuan
                            </label>
                            <input type="number" name="harga_satuan[]" min="0" value="${harga}"
                                class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Lokasi Default -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lokasi Default
                            </label>
                            <input type="text" class="lokasi-default block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Gudang A" onchange="applyLokasiToAll(${index})">
                        </div>
                    </div>

                    <!-- Keterangan Detail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Keterangan Item
                        </label>
                        <input type="text" name="keterangan_detail[]" value="${keterangan}"
                            class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                            placeholder="Catatan khusus untuk jenis barang ini...">
                    </div>

                    <!-- Barang Items Container -->
                    <div class="barang-items-container bg-blue-50 dark:bg-blue-900/10 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center justify-between mb-3">
                            <h5 class="font-semibold text-sm text-gray-700 dark:text-gray-300">Detail Barang Individual</h5>
                            <span class="text-xs text-gray-500 dark:text-gray-400">Sesuai dengan jumlah barang</span>
                        </div>
                        <div class="barang-items space-y-3">
                            <!-- Barang items will be added here -->
                        </div>
                    </div>
                </div>
            </div>
            `;
            }

            // Template untuk barang individual item
            function createBarangItem(detailIndex, barangIndex, barang = null) {
                const barangId = barang ? barang.barang_id : '';
                const namaBarang = barang ? barang.nama_barang : '';
                const kodeBarang = barang ? (barang.kode_barang || '') : '';
                const merk = barang ? barang.merk : '';
                const lokasi = barang ? (barang.lokasi || '') : '';

                return `
            <div class="barang-item bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                ${barangId ? `<input type="hidden" name="barang_ids[${detailIndex}][]" value="${barangId}">` : ''}
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">Barang ${barangIndex + 1}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][nama_barang]" value="${namaBarang}" required
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="Contoh: Laptop HP ProBook 450 G8">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kode Barang
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][kode_barang]" value="${kodeBarang}"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="LT001">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Merk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][merk]" value="${merk}" required
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="HP">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Lokasi
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][lokasi]" value="${lokasi}"
                            class="lokasi-input block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="Gudang A">
                    </div>
                </div>
            </div>
            `;
            }

            // Update barang items based on jumlah
            function updateBarangItems(detailIndex) {
                const detailItem = document.querySelector(`.detail-item[data-index="${detailIndex}"]`);
                const jumlah = parseInt(detailItem.querySelector('.jumlah-input').value) || 0;
                const container = detailItem.querySelector('.barang-items');

                const currentItems = container.querySelectorAll('.barang-item').length;

                if (jumlah > currentItems) {
                    // Add new items
                    for (let i = currentItems; i < jumlah; i++) {
                        container.insertAdjacentHTML('beforeend', createBarangItem(detailIndex, i));
                    }
                } else if (jumlah < currentItems) {
                    // Remove excess items
                    const items = container.querySelectorAll('.barang-item');
                    for (let i = currentItems - 1; i >= jumlah; i--) {
                        items[i].remove();
                    }
                }

                // Apply lokasi default if exists
                applyLokasiToAll(detailIndex);
            }

            // Apply lokasi default to all barang items
            function applyLokasiToAll(detailIndex) {
                const detailItem = document.querySelector(`.detail-item[data-index="${detailIndex}"]`);
                const lokasiDefault = detailItem.querySelector('.lokasi-default').value;

                if (lokasiDefault) {
                    detailItem.querySelectorAll('.lokasi-input').forEach(input => {
                        if (!input.value) {
                            input.value = lokasiDefault;
                        }
                    });
                }
            }

            // Update jenis info
            function updateJenisInfo(detailIndex) {
                // Can add additional logic here if needed
            }

            // Load existing details
            existingDetails.forEach((detail, index) => {
                const container = document.getElementById('detailContainer');
                container.insertAdjacentHTML('beforeend', createDetailItem(index, detail));

                // Load barang items for this detail
                const detailElement = container.querySelector(`.detail-item[data-index="${index}"]`);
                const barangContainer = detailElement.querySelector('.barang-items');

                detail.barang_items.forEach((barang, barangIndex) => {
                    barangContainer.insertAdjacentHTML('beforeend', createBarangItem(index, barangIndex,
                        barang));
                });
            });

            // Add detail item
            document.getElementById('addDetailBtn').addEventListener('click', function() {
                const container = document.getElementById('detailContainer');
                container.insertAdjacentHTML('beforeend', createDetailItem(detailIndex));
                detailIndex++;
                updateRemoveButtons();
            });

            // Remove detail item
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-detail-btn')) {
                    const btn = e.target.closest('.remove-detail-btn');
                    const item = btn.closest('.detail-item');

                    if (document.querySelectorAll('.detail-item').length > 1) {
                        if (confirm('Yakin ingin menghapus jenis barang ini dan semua barang di dalamnya?')) {
                            item.remove();
                            updateItemNumbers();
                        }
                    } else {
                        alert('Minimal harus ada 1 jenis barang');
                    }
                }
            });

            // Update item numbers
            function updateItemNumbers() {
                document.querySelectorAll('.detail-item').forEach((item, index) => {
                    const numberBadge = item.querySelector('.bg-blue-600');
                    const title = item.querySelector('h4');
                    numberBadge.textContent = index + 1;
                    title.innerHTML =
                        `<span class="bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">${index + 1}</span> Jenis Barang #${index + 1}`;
                });
            }

            // Update remove button visibility
            function updateRemoveButtons() {
                const items = document.querySelectorAll('.detail-item');
                items.forEach(item => {
                    const removeBtn = item.querySelector('.remove-detail-btn');
                    removeBtn.style.display = items.length > 1 ? 'block' : 'none';
                });
            }

            // Initialize button states
            updateRemoveButtons();
        </script>
    @endpush
</x-app-layout>
