<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Barang') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                @if ($jenisBarang)
                    Perbarui informasi barang dengan kategori: <span
                        class="font-semibold text-green-600">{{ $jenisBarang->kategori }} -
                        {{ $jenisBarang->jenis }}</span>
                @else
                    Perbarui informasi barang dalam inventaris
                @endif
            </p>
        </div>
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('jenis-barang.show', $jenisBarang->jenis_barang_id) }}"
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

        @if ($jenisBarang)
            <div
                class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 px-8 py-4 border-b border-green-100 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-400 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kategori Barang</p>
                        <p class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            {{ $jenisBarang->kategori }} - {{ $jenisBarang->jenis }}
                        </p>
                    </div>
                    @if ($jenisBarang->kode_utama)
                        <div class="ml-auto">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-mono font-medium bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                Kode: {{ $jenisBarang->kode_utama }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <div class="p-8">
            <form id="update_item" method="POST" action="{{ route('barang.update', $barang->barang_id) }}"
                enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                @if ($jenisBarang)
                    <input type="hidden" name="jenis_barang_id" value="{{ $jenisBarang->jenis_barang_id }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <x-input-label for="nama_barang" :value="__('Nama Barang')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                            <span class="text-red-500">*</span>
                        </x-input-label>
                        <div class="relative">
                            <x-text-input id="nama_barang"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="nama_barang" :value="old('nama_barang', $barang->nama_barang)"
                                placeholder="Contoh: {{ $jenisBarang ? $jenisBarang->jenis . ' Dell Latitude 5420' : 'Laptop Dell Latitude 5420' }}"
                                required autocomplete="nama_barang" />
                        </div>
                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                    </div>

                    <div class="group">
                        <x-input-label for="kode_barang" :value="__('Kode Barang')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2" />
                        <x-text-input id="kode_barang"
                            class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                            type="text" name="kode_barang"
                            placeholder="{{ $jenisBarang && $jenisBarang->kode_utama ? $jenisBarang->kode_utama . '-001' : 'BRG-001' }}"
                            :value="old('kode_barang', $barang->kode_barang)" autocomplete="kode_barang" />
                        @if ($jenisBarang && $jenisBarang->kode_utama)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Format:
                                {{ $jenisBarang->kode_utama }}-XXX</p>
                        @endif
                        <x-input-error :messages="$errors->get('kode_barang')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="group">
                        <x-input-label for="merk" :value="__('Merk')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                            <span class="text-red-500">*</span>
                        </x-input-label>
                        <x-text-input id="merk"
                            class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                            type="text" name="merk" placeholder="Contoh: Dell, Lenovo, HP" required
                            :value="old('merk', $barang->merk)" autocomplete="merk" />
                        <x-input-error :messages="$errors->get('merk')" class="mt-2" />
                    </div>

                    <div class="group">
                        <x-input-label for="kondisi" :value="__('Kondisi')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                            <span class="text-red-500">*</span>
                        </x-input-label>
                        <div class="relative">
                            <select id="kondisi" name="kondisi" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="baik"
                                    {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="diperbaiki"
                                    {{ old('kondisi', $barang->kondisi) == 'diperbaiki' ? 'selected' : '' }}>
                                    Diperbaiki</option>
                                <option value="dipinjam"
                                    {{ old('kondisi', $barang->kondisi) == 'dipinjam' ? 'selected' : '' }}>Dipinjam
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
                </div>

                <div class="group">
                    <x-input-label for="lokasi" :value="__('Lokasi')"
                        class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2" />
                    <x-text-input id="lokasi"
                        class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                        type="text" name="lokasi" placeholder="Contoh: Ruang IT, Gudang, Kantor Pusat"
                        :value="old('lokasi', $barang->lokasi)" autocomplete="lokasi" />
                    <x-input-error :messages="$errors->get('lokasi')" class="mt-2" />
                </div>

                <div class="group">
                    <x-input-label for="gambar" :value="__('Gambar Barang')"
                        class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2" />

                    @if ($barang->gambar && isset($barang->gambar_url))
                        <div class="mb-4" id="existing_image_container">
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-600">
                                <p
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Gambar Saat Ini:
                                </p>
                                <div class="relative inline-block">
                                    <img src="{{ $barang->gambar_url }}" alt="{{ $barang->nama_barang }}"
                                        class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-white dark:border-gray-600" />
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="relative">
                        <label
                            class="flex items-center justify-between w-full px-4 py-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 focus-within:border-green-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                            for="gambar">
                            <span id="fileName" class="text-gray-500 dark:text-gray-400 text-sm font-medium">
                                📷 {{ $barang->gambar ? 'Pilih gambar baru untuk mengganti' : 'Pilih file gambar' }}
                                (jpg, jpeg, png - Max 5MB)
                            </span>
                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </label>

                        <input id="gambar" class="hidden" type="file" name="gambar" accept="image/*" />
                    </div>

                    <div id="cover_preview_wrapper" class="mt-4 hidden">
                        <div
                            class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 border-2 border-gray-200 dark:border-gray-600">
                            <p
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Preview Gambar Baru:
                            </p>
                            <div class="relative inline-block">
                                <img id="cover_preview" src="" alt="Image Preview"
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

                    <x-input-error :messages="$errors->get('gambar')" class="mt-2" />

                    @if ($barang->gambar)
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            💡 Kosongkan jika tidak ingin mengubah gambar
                        </p>
                    @endif
                </div>

                <div
                    class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('jenis-barang.show', $jenisBarang->jenis_barang_id) }}"
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
                        {{ __('Perbarui Barang') }}
                    </button>
                </div>

                <x-confirm-modal id="update_confirmation"
                    message="Apakah Anda yakin ingin memperbarui data barang ini?" okLabel="Perbarui"
                    cancelLabel="Batal" :url="route('barang.update', $barang->barang_id)" formId="update_item" />
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const fileInput = document.getElementById('gambar');
            const fileNameDisplay = document.getElementById('fileName');
            const previewWrapper = document.getElementById('cover_preview_wrapper');
            const previewImage = document.getElementById('cover_preview');
            const removeImageBtn = document.getElementById('removeImage');
            const existingImageContainer = document.getElementById('existing_image_container');

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

                            if (existingImageContainer) {
                                existingImageContainer.style.opacity = '0.5';
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                const hasExistingImage = {{ $barang->gambar ? 'true' : 'false' }};
                fileNameDisplay.textContent = hasExistingImage ?
                    '📷 Pilih gambar baru untuk mengganti (jpg, jpeg, png - Max 5MB)' :
                    '📷 Pilih file gambar (jpg, jpeg, png - Max 5MB)';
                fileNameDisplay.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                fileNameDisplay.classList.add('text-gray-500', 'dark:text-gray-400');
                previewWrapper.classList.add('hidden');

                if (existingImageContainer) {
                    existingImageContainer.style.opacity = '1';
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                const formGroups = document.querySelectorAll('.group');
                formGroups.forEach(group => {
                    const input = group.querySelector('input, select');
                    if (input) {
                        input.addEventListener('focus', () => {
                            group.classList.add('ring-2', 'ring-green-100', 'dark:ring-green-900/30',
                                'ring-opacity-50', 'rounded-xl');
                        });
                        input.addEventListener('blur', () => {
                            group.classList.remove('ring-2', 'ring-green-100', 'dark:ring-green-900/30',
                                'ring-opacity-50', 'rounded-xl');
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
    @endpush
</x-app-layout>
