<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-2xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ route('barang-masuk.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 mb-8 group">
                <x-bx-arrow-back
                    class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" />
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
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        {{ __('Tambah Barang Masuk') }}
                    </h1>
                    <p class="text-green-100 mt-2">{{ __('Catat transaksi barang masuk ke inventori') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="create_barang_masuk" method="POST" action="{{ route('barang-masuk.store') }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Row 1: Tanggal -->
                        <div class="group">
                            <x-input-label for="tanggal" :value="__('Tanggal')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="relative">
                                <x-text-input id="tanggal"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="datetime-local" name="tanggal" :value="old('tanggal', now()->format('Y-m-d\TH:i'))"
                                    required autofocus />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <!-- Row 2: Kode Barang & Nama Barang -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kode_barang" :value="__('Kode Barang')"
                                    class="text-gray-700 font-semibold mb-2" />
                                <x-text-input id="kode_barang"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="kode_barang" :value="old('kode_barang')"
                                    placeholder="Masukkan kode barang" />
                                <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="nama_barang" :value="__('Nama Barang')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="nama_barang"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="nama_barang" :value="old('nama_barang')"
                                    placeholder="Masukkan nama barang" required />
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 3: Jenis & Merk -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="jenis" :value="__('Jenis')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="jenis"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="jenis" :value="old('jenis')"
                                    placeholder="Masukkan jenis barang" required />
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="merk" :value="__('Merk')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="merk"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="merk" :value="old('merk')"
                                    placeholder="Masukkan merk barang" required />
                                <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 4: Kondisi & Satuan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kondisi" :value="__('Kondisi')"
                                    class="text-gray-700 font-semibold mb-2" />
                                <div class="relative">
                                    <select id="kondisi" name="kondisi"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none">
                                        <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak" {{ old('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="satuan" :value="__('Satuan')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="satuan"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="satuan" :value="old('satuan')"
                                    placeholder="Contoh: Pcs, Unit, Box" required />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 5: Lokasi -->
                        <div class="group">
                            <x-input-label for="lokasi" :value="__('Lokasi')"
                                class="text-gray-700 font-semibold mb-2" />
                            <x-text-input id="lokasi"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                type="text" name="lokasi" :value="old('lokasi')"
                                placeholder="Masukkan lokasi penyimpanan" />
                            <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                        </div>

                        <!-- Row 6: Jumlah & Kategori -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="jumlah" :value="__('Jumlah')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="jumlah"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="number" name="jumlah" placeholder="Masukkan jumlah barang" min="1"
                                    :value="old('jumlah')" required />
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="kategori" :value="__('Kategori')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <select id="kategori" name="kategori"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none"
                                        required>
                                        <option value="pembelian" {{ old('kategori') == 'pembelian' ? 'selected' : '' }}>
                                            Pembelian
                                        </option>
                                        <option value="bantuan" {{ old('kategori') == 'bantuan' ? 'selected' : '' }}>
                                            Bantuan
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 7: Harga Satuan & Supplier -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="harga_satuan" :value="__('Harga Satuan')"
                                    class="text-gray-700 font-semibold mb-2" />
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-medium">Rp</span>
                                    <x-text-input id="harga_satuan"
                                        class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="number" name="harga_satuan" placeholder="0" min="0"
                                        :value="old('harga_satuan')" />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Opsional - Isi jika pembelian</p>
                                <x-input-error :messages="$errors->get('harga_satuan')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="nama_supplier" :value="__('Nama Supplier')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="nama_supplier"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="nama_supplier" placeholder="Masukkan nama supplier"
                                    :value="old('nama_supplier')" required />
                                <x-input-error :messages="$errors->get('nama_supplier')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="group">
                            <x-input-label for="gambar" :value="__('Gambar')"
                                class="text-gray-700 font-semibold mb-2" />
                            <div class="relative">
                                <label
                                    class="flex items-center justify-between w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-gray-400 focus-within:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-gray-100 cursor-pointer"
                                    for="gambar">
                                    <span id="fileName" class="text-gray-500 text-sm font-medium">
                                        Pilih file gambar (jpg, jpeg, png)
                                    </span>
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </label>
                                <input id="gambar" class="hidden" type="file" name="gambar" accept="image/*" />
                            </div>

                            <!-- Image Preview -->
                            <div id="cover_preview_wrapper" class="mt-4 hidden">
                                <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                                    <p class="text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Preview:
                                    </p>
                                    <div class="relative inline-block">
                                        <img id="cover_preview" src="" alt="Preview" 
                                            class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-white" />
                                        <div class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                        </div>

                        <!-- Keterangan -->
                        <div class="group">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <textarea id="keterangan" name="keterangan" rows="4"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white resize-none"
                                placeholder="Masukkan keterangan transaksi barang masuk" required>{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200 space-x-4">
                            <a href="{{ route('barang-masuk.index') }}"
                                class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button x-data @click="$dispatch('open-modal', 'save_confirmation')"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Simpan Barang Masuk') }}
                            </x-primary-button>
                        </div>

                        <x-confirm-modal id="save_confirmation"
                            message="Apakah Anda yakin ingin menyimpan transaksi barang masuk ini?" okLabel="Simpan"
                            cancelLabel="Batal" :url="route('barang-masuk.store')" formId="create_barang_masuk" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview
            const fileInput = document.getElementById('gambar');
            const fileNameDisplay = document.getElementById('fileName');
            const previewWrapper = document.getElementById('cover_preview_wrapper');
            const previewImage = document.getElementById('cover_preview');

            fileInput.addEventListener('change', function(e) {
                const file = this.files[0];
                
                if (file) {
                    // Update file name display
                    fileNameDisplay.textContent = file.name;
                    fileNameDisplay.classList.remove('text-gray-500');
                    fileNameDisplay.classList.add('text-gray-900');

                    // Show image preview
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewWrapper.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    fileNameDisplay.textContent = 'Pilih file gambar (jpg, jpeg, png)';
                    fileNameDisplay.classList.add('text-gray-500');
                    fileNameDisplay.classList.remove('text-gray-900');
                    previewWrapper.classList.add('hidden');
                }
            });

            // Form group focus animations
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
</x-app-layout>