<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Tambah Barang Masuk') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Catat barang masuk baru (pembelian atau bantuan)</p>
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
            <form id="create_barang_masuk" method="POST" action="{{ route('barang-masuk.store') }}" class="space-y-6">
                @csrf

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
                                type="date" name="tanggal" :value="old('tanggal', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="kategori" :value="__('Kategori')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="kategori" name="kategori" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="pembelian" {{ old('kategori') == 'pembelian' ? 'selected' : '' }}>
                                    Pembelian</option>
                                <option value="bantuan" {{ old('kategori') == 'bantuan' ? 'selected' : '' }}>Bantuan
                                </option>
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
                                type="text" name="nama_supplier" :value="old('nama_supplier')"
                                placeholder="Contoh: PT. Maju Jaya, CV. Sukses Bersama" required />
                            <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />
                            <textarea id="keterangan" name="keterangan" rows="3"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Detail Barang</h3>
                        <button type="button" id="addDetailBtn"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium flex items-center gap-2">
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

                    <button type="button" x-data @click="$dispatch('open-modal', 'save_confirmation')"
                        class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ __('Simpan') }}
                    </button>
                </div>

                <x-confirm-modal id="save_confirmation"
                    message="Apakah Anda yakin ingin menyimpan data barang masuk ini?" okLabel="Simpan"
                    cancelLabel="Batal" :url="route('barang-masuk.store')" formId="create_barang_masuk" />
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            let detailIndex = 0;
            const jenisBarangList = @json($jenisBarang);
            const listKodeUtama = [];

            function createDetailItem(index) {
                const jenisOptions = jenisBarangList.map(jenis =>
                    `<option value="${jenis.jenis_barang_id}">${jenis.jenis} - Kode Prefix: ${jenis.kode_utama}</option>`
                ).join('');
                const uniqueId = 'input_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);


                return `
            <div class="detail-item bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 p-6 rounded-xl border-2 border-gray-200 dark:border-gray-600" data-index="${index}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <span class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">${index + 1}</span>
                        Jenis Barang ${index + 1}
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
                            Jenis Barang (Jika tidak ada silahkan tambahkan dulu <a class="text-green-600 font-bold hover:underline" href="{{ route('jenis-barang.create') }}">DISINI</a>)<span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_barang_ids[]" required onchange="updateJenisInfo(${index}); setKodeUtama(${index}, this.value)"
                            class="jenis-select block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white" id="jenis-select-${index}">
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
                            <input type="number" name="jumlah[]" min="1" value="1" required onchange="updateBarangItems(${index})"
                                class="jumlah-input block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- Harga Satuan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Harga Satuan
                            </label>
                            <input 
                                type="text" 
                                name="harga_satuan[]" 
                                value="0"
                                inputmode="numeric"
                                data-format-number="true"
                                data-number-id="${uniqueId}"
                                class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 dark:focus:border-green-600 focus:ring-green-500 dark:focus:ring-green-600 rounded-md shadow-sm block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="0" 
                            />
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
                        <input type="text" name="keterangan_detail[]"
                            class="block w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 bg-white dark:bg-gray-700 dark:text-white"
                            placeholder="Catatan khusus untuk jenis barang ini...">
                    </div>

                    <!-- Barang Items Container -->
                    <div class="barang-items-container bg-green-50 dark:bg-green-900/10 p-4 rounded-lg border border-green-200 dark:border-green-800">
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

            function createBarangItem(detailIndex, barangIndex) {
                return `
            <div class="barang-item bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                <div class="flex items-center gap-2 mb-3">
                    <span class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">Barang ${barangIndex + 1}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nama Barang <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][nama_barang]" required
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="Contoh: Laptop HP ProBook 450 G8">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Kode Barang
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][kode_barang]"
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white input-kode-barang-${detailIndex}"
                            placeholder="">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Merk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][merk]" required
                            class="block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="HP">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Lokasi
                        </label>
                        <input type="text" name="list_barang[${detailIndex}][${barangIndex}][lokasi]"
                            class="lokasi-input block w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500/20 bg-white dark:bg-gray-800 dark:text-white"
                            placeholder="Gudang A">
                    </div>
                </div>
            </div>
            `;
            }

            function updateBarangItems(detailIndex) {
                const detailItem = document.querySelector(`.detail-item[data-index="${detailIndex}"]`);
                const jumlah = parseInt(detailItem.querySelector('.jumlah-input').value) || 0;
                const container = detailItem.querySelector('.barang-items');

                container.innerHTML = '';

                for (let i = 0; i < jumlah; i++) {
                    container.insertAdjacentHTML('beforeend', createBarangItem(detailIndex, i));
                }

                applyLokasiToAll(detailIndex);

                if (jumlah > 1) {
                    setKodeUtama(detailIndex, listKodeUtama[detailIndex][0]);
                }
            }

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

            function setKodeUtama(index, jenis_barang_id) {
                console.log(index, jenis_barang_id);
                const jenis = jenisBarangList.find(
                    j => j.jenis_barang_id === jenis_barang_id
                );

                listKodeUtama[index] = [jenis_barang_id, jenis.kode_utama];

                const inputKodeBarangs = document.querySelectorAll(`.input-kode-barang-${index}`);
                inputKodeBarangs.forEach(input => {
                    input.placeholder = `Sudah berawal ${jenis.kode_utama}`;
                });
            }

            function updateJenisInfo(detailIndex) {
                updateBarangItems(detailIndex);
            }

            function initializeNumberFormat(input) {
                if (!input || input.dataset.numberInitialized) return;
                input.dataset.numberInitialized = 'true';

                // Format number
                function fmt(n) {
                    if (!n) return '';
                    const clean = String(n).replace(/\D/g, '');
                    return clean ? clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
                }

                // Unformat number
                function unfmt(s) {
                    return String(s).replace(/\./g, '');
                }

                // Get digit position
                function getDigitPos(str, cursorPos) {
                    let pos = 0;
                    for (let i = 0; i < cursorPos; i++) {
                        if (str[i] && str[i] !== '.') pos++;
                    }
                    return pos;
                }

                // Get cursor position from digit position
                function getCursorPos(str, digitPos) {
                    let count = 0;
                    for (let i = 0; i <= str.length; i++) {
                        if (count === digitPos) return i;
                        if (i < str.length && str[i] !== '.') count++;
                    }
                    return str.length;
                }

                // Format initial value
                if (input.value) {
                    input.value = fmt(input.value);
                }

                // Input event
                input.addEventListener('input', function() {
                    const pos = getDigitPos(this.value, this.selectionStart);
                    this.value = fmt(this.value);
                    const newPos = getCursorPos(this.value, pos);
                    this.setSelectionRange(newPos, newPos);
                });

                // Paste event
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = (e.clipboardData || window.clipboardData).getData('text');
                    const clean = paste.replace(/\D/g, '');
                    if (!clean) return;

                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    const posStart = getDigitPos(this.value, start);
                    const posEnd = getDigitPos(this.value, end);
                    const raw = unfmt(this.value);
                    const newRaw = raw.substring(0, posStart) + clean + raw.substring(posEnd);

                    this.value = fmt(newRaw);

                    const newDigitPos = posStart + clean.length;
                    const newCursorPos = getCursorPos(this.value, newDigitPos);
                    this.setSelectionRange(newCursorPos, newCursorPos);
                });

                // Keydown event
                input.addEventListener('keydown', function(e) {
                    const allowed = [8, 9, 27, 13, 46, 35, 36, 37, 38, 39, 40];
                    if (allowed.includes(e.keyCode) ||
                        ((e.ctrlKey || e.metaKey) && [65, 67, 86, 88, 90].includes(e.keyCode))) {
                        return;
                    }
                    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
            }

            document.getElementById('addDetailBtn').addEventListener('click', function() {
                const container = document.getElementById('detailContainer');
                container.insertAdjacentHTML('beforeend', createDetailItem(detailIndex));

                // Initialize number format untuk input harga satuan yang baru ditambahkan
                const newDetailItem = container.querySelector(`.detail-item[data-index="${detailIndex}"]`);
                const hargaInput = newDetailItem.querySelector('[data-format-number="true"]');
                if (hargaInput) {
                    initializeNumberFormat(hargaInput);
                }

                detailIndex++;
                updateRemoveButtons();
            });

            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-detail-btn')) {
                    const btn = e.target.closest('.remove-detail-btn');
                    const item = btn.closest('.detail-item');

                    if (document.querySelectorAll('.detail-item').length > 1) {
                        item.remove();
                        updateItemNumbers();
                    } else {
                        alert('Minimal harus ada 1 jenis barang');
                    }
                }
            });

            function updateItemNumbers() {
                document.querySelectorAll('.detail-item').forEach((item, index) => {
                    const numberBadge = item.querySelector('.bg-green-600');
                    const title = item.querySelector('h4');
                    numberBadge.textContent = index + 1;
                    title.innerHTML =
                        `<span class="bg-green-600 text-white w-8 h-8 rounded-full flex items-center justify-center text-sm">${index + 1}</span> Jenis Barang #${index + 1}`;
                });
            }

            function updateRemoveButtons() {
                const items = document.querySelectorAll('.detail-item');
                items.forEach(item => {
                    const removeBtn = item.querySelector('.remove-detail-btn');
                    removeBtn.style.display = items.length > 1 ? 'block' : 'none';
                });
            }

            const form = document.getElementById('create_barang_masuk');
            if (form && !form.dataset.numberFormHandler) {
                form.dataset.numberFormHandler = 'true';
                form.addEventListener('submit', function() {
                    const inputs = this.querySelectorAll('[data-format-number="true"]');
                    inputs.forEach(inp => {
                        if (inp.value) {
                            inp.value = inp.value.replace(/\./g, '');
                        }
                    });
                });
            }

            document.getElementById('addDetailBtn').click();
        </script>
    @endpush
</x-app-layout>
