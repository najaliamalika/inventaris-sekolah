<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="max-w-3xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ route('peminjaman.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 mb-8 group">
                <x-bx-arrow-back
                    class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" />
                <span class="text-sm font-medium">{{ __('Kembali') }}</span>
            </a>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-400 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        {{ __('Tambah Peminjaman Baru') }}
                    </h1>
                    <p class="text-blue-100 mt-2">{{ __('Catat peminjaman barang oleh pengguna') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="create_peminjaman" method="POST" action="{{ route('peminjaman.store') }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Row 1: Kode Barang & Nama Barang -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kode_barang" :value="__('Kode Barang')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <div class="relative">
                                    <x-text-input id="kode_barang"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="kode_barang" :value="old('kode_barang')"
                                        placeholder="Masukkan Kode Barang" autofocus autocomplete="kode_barang" />
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

                        <!-- Row 1: Item Selection -->
                        <div class="group">
                            <x-input-label for="item_id" :value="__('Pilih Barang')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="relative">
                                <select id="item_id" name="item_id" required
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none">
                                    <option value="" selected disabled>Pilih Barang</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->item_id }}" {{ old('item_id') == $item->item_id ? 'selected' : '' }}>
                                            {{ $item->kode_barang ? $item->kode_barang . ' - ' : '' }}{{ $item->nama_barang }} 
                                            (Stok: {{ $item->stok }} {{ $item->satuan }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                        </div>

                        <!-- Row 2: Tanggal & Nama Peminjam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="tanggal_peminjaman" :value="__('Tanggal Peminjaman')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="tanggal_peminjaman"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="datetime-local" name="tanggal_peminjaman" :value="old('tanggal_peminjaman')"
                                        required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('tanggal_peminjaman')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="nama_peminjam" :value="__('Nama Peminjam')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="nama_peminjam"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="nama_peminjam" :value="old('nama_peminjam')"
                                        placeholder="Masukkan Nama Peminjam" required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('nama_peminjam')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 3: Jumlah -->
                        <div class="group">
                            <x-input-label for="jumlah" :value="__('Jumlah Barang')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="relative">
                                <x-text-input id="jumlah"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="number" name="jumlah" :value="old('jumlah')"
                                    placeholder="Masukkan Jumlah" required min="1" />
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <!-- Row 4: Foto Peminjaman -->
                        <div class="group">
                            <x-input-label for="foto_peminjaman" :value="__('Foto Peminjaman')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-all duration-200 bg-gray-50">
                                <input type="file" id="foto_peminjaman" name="foto_peminjaman" accept="image/jpeg,image/png,image/jpg"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required />
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-semibold text-blue-600">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG (Max. 5MB)</p>
                                </div>
                                <div id="preview_foto_peminjaman" class="mt-4 hidden">
                                    <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-md" />
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('foto_peminjaman')" class="mt-2" />
                        </div>

                        <!-- Row 5: Keterangan -->
                        <div class="group">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <textarea id="keterangan" name="keterangan" rows="4" required
                                placeholder="Masukkan keterangan peminjaman (contoh: Untuk acara, Keperluan proyek, dll)"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white resize-none">{{ old('keterangan') }}</textarea>
                            <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                            <p class="text-sm text-gray-500 mt-2">Maksimal 255 karakter</p>
                        </div>
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 space-x-4">
                        <a href="{{ route('peminjaman.index') }}"
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Batal') }}
                        </a>

                        <x-primary-button x-data @click="$dispatch('open-modal', 'save_confirmation')"
                            class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Simpan Peminjaman') }}
                        </x-primary-button>

                        <x-confirm-modal id="save_confirmation"
                            message="Apakah Anda yakin ingin menyimpan data peminjaman ini? Stok barang akan berkurang otomatis."
                            okLabel="Simpan" cancelLabel="Batal" 
                            :url="route('peminjaman.store')" formId="create_peminjaman" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set default datetime to now
            const tanggalInput = document.getElementById('tanggal_peminjaman');
            if (!tanggalInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                tanggalInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }

            // Image preview
            const fotoInput = document.getElementById('foto_peminjaman');
            const previewDiv = document.getElementById('preview_foto_peminjaman');
            const previewImg = previewDiv.querySelector('img');

            fotoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewDiv.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Add focus animations
            const formGroups = document.querySelectorAll('.group');
            formGroups.forEach(group => {
                const input = group.querySelector('input, select, textarea');
                if (input) {
                    input.addEventListener('focus', () => {
                        group.classList.add('ring-2', 'ring-blue-100', 'ring-opacity-50');
                    });
                    input.addEventListener('blur', () => {
                        group.classList.remove('ring-2', 'ring-blue-100', 'ring-opacity-50');
                    });
                }
            });

            // Character counter for keterangan
            const keteranganInput = document.getElementById('keterangan');
            const maxLength = 255;
            
            keteranganInput.addEventListener('input', function() {
                const remaining = maxLength - this.value.length;
                const counterText = this.parentElement.querySelector('.text-gray-500');
                
                if (remaining < 0) {
                    counterText.textContent = `Melebihi ${Math.abs(remaining)} karakter`;
                    counterText.classList.remove('text-gray-500');
                    counterText.classList.add('text-red-500');
                } else {
                    counterText.textContent = `Sisa ${remaining} karakter`;
                    counterText.classList.remove('text-red-500');
                    counterText.classList.add('text-gray-500');
                }
            });
        });
    </script>
</x-app-layout>