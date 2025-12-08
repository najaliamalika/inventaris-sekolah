<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-2xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors duration-200 mb-8 group">
                <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="text-sm font-medium">{{ __('Back') }}</span>
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
                        {{ __('Edit Barang') }}
                    </h1>
                    <p class="text-green-100 mt-2">{{ __('Perbarui informasi barang yang ada') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="update_item" method="POST" action="{{ route('item.update', $item->item_id) }}"
                        enctype="multipart/form-data" class="space-y-6">
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

                            <div class="group">
                                <x-input-label for="nama_barang" :value="__('Nama Barang')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="nama_barang"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="nama_barang" :value="old('nama_barang', $item->nama_barang)"
                                        placeholder="Masukkan Nama Barang" required autocomplete="nama_barang" />
                                </div>
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 2: Jenis & Merk -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="jenis" :value="__('Jenis')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="jenis"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="jenis" placeholder="Masukkan Jenis Barang" required
                                    :value="old('jenis', $item->jenis)" autocomplete="jenis" />
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="merk" :value="__('Merk')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="merk"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="merk" placeholder="Masukkan Merk Barang" required
                                    :value="old('merk', $item->merk)" autocomplete="merk" />
                                <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 3: Kondisi & Stok -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kondisi" :value="__('Kondisi')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <div class="relative">
                                    <select id="kondisi" name="kondisi"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none">
                                        <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>
                                            Baik
                                        </option>
                                        <option value="Rusak" {{ old('kondisi', $item->kondisi) == 'Rusak' ? 'selected' : '' }}>
                                            Rusak
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
                                <x-input-error :messages="$errors->get('kondisi')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="stok" :value="__('Stok')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <x-text-input id="stok"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="number" name="stok" placeholder="Masukkan Stok Barang"
                                    :value="old('stok', $item->stok)" autocomplete="stok" />
                                <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 4: Satuan & Lokasi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="satuan" :value="__('Satuan')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="satuan"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="satuan" placeholder="Masukkan Satuan Barang" required
                                    :value="old('satuan', $item->satuan)" autocomplete="satuan" />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="lokasi" :value="__('Lokasi')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <x-text-input id="lokasi"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="lokasi" placeholder="Masukkan Lokasi Penyimpanan Barang"
                                    :value="old('lokasi', $item->lokasi)" autocomplete="lokasi" />
                                <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="group">
                            <x-input-label for="gambar" :value="__('Gambar')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />

                            <div class="relative">
                                <label
                                    class="flex items-center justify-between w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl hover:border-gray-400 focus-within:border-green-500 focus:ring-green-500 transition-all duration-200 bg-gray-50 hover:bg-gray-100 cursor-pointer"
                                    for="gambar">
                                    <span id="fileName" class="text-gray-500 text-sm font-medium">
                                        Pilih file gambar (jpg, jpeg, png)
                                    </span>
                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </label>

                                <input id="gambar" class="hidden" type="file" name="gambar" accept="image/*" />
                            </div>

                            <script>
                                const fileInput = document.getElementById('gambar');
                                const fileNameDisplay = document.getElementById('fileName');

                                fileInput.addEventListener('change', function(e) {
                                    if (this.files && this.files[0]) {
                                        fileNameDisplay.textContent = this.files[0].name;
                                        fileNameDisplay.classList.remove('text-gray-500');
                                        fileNameDisplay.classList.add('text-gray-900');
                                    } else {
                                        fileNameDisplay.textContent = 'Pilih file gambar (jpg, jpeg, png)';
                                        fileNameDisplay.classList.add('text-gray-500');
                                        fileNameDisplay.classList.remove('text-gray-900');
                                    }
                                });
                            </script>

                            <!-- Image Preview -->
                            <div id="cover_preview_wrapper" class="mt-4">
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
                                        <img id="cover_preview" src="{{ $item->gambar }}" alt="Image Preview"
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
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end mt-8 pt-6 border-t border-gray-200 space-x-4">
                        <a href="{{ url()->previous() }}"
                            class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __('Batal') }}
                        </a>

                        <x-primary-button x-data type="button" @click="$dispatch('open-modal', 'update_confirmation')"
                            class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Simpan Perubahan') }}
                        </x-primary-button>

                        <x-confirm-modal id="update_confirmation"
                            message="Apakah kamu yakin ingin memperbarui data barang ini?" okLabel="Simpan"
                            cancelLabel="Batal" :url="route('item.update', $item->item_id)" formId="update_item" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewWrapper = document.getElementById('cover_preview_wrapper');
            const previewImage = document.getElementById('cover_preview');

            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewWrapper.classList.add('animate-fade-in');
                };
                reader.readAsDataURL(file);
            }
        });

        // Add smooth interactions
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.group');
            formGroups.forEach(group => {
                const input = group.querySelector('input, select');
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