<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Peminjaman') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Perbarui data peminjaman barang</p>
        </div>
    </x-slot>

    <div class="mb-6 max-w-5xl mx-auto px-6">
        <a href="{{ route('peminjaman.show', $peminjaman->peminjaman_id) }}"
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
                <form id="update_peminjaman" method="POST"
                    action="{{ route('peminjaman.update', $peminjaman->peminjaman_id) }}" enctype="multipart/form-data"
                    class="space-y-6" x-data="peminjamanForm()">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="tanggal_peminjaman" :value="__('Tanggal Peminjaman')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal_peminjaman"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal_peminjaman" :value="old('tanggal_peminjaman', $peminjaman->tanggal_peminjaman->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_peminjaman')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="nama_peminjam" :value="__('Nama Peminjam')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="nama_peminjam"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="text" name="nama_peminjam" required :value="old('nama_peminjam', $peminjaman->nama_peminjam)" />
                            <x-input-error :messages="$errors->get('nama_peminjam')" class="mt-2" />
                        </div>
                    </div>

                    <div class="group">
                        <x-input-label for="keterangan" :value="__('Keterangan Peminjaman')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                        </x-input-label>
                        <textarea id="keterangan" name="keterangan" rows="3"
                            class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                            placeholder="Contoh: Untuk keperluan proyek X (opsional)">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
                        <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                    </div>

                    @if ($peminjaman->foto_peminjaman && isset($peminjaman->foto_peminjaman_url))
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
                                    Foto Peminjaman Saat Ini:
                                </p>
                                <img src="{{ $peminjaman->foto_peminjaman_url }}" alt="Foto Peminjaman"
                                    class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-white dark:border-gray-600" />
                            </div>
                        </div>
                    @endif

                    <div class="group">
                        <x-input-label for="foto_peminjaman" :value="__('Foto Peminjaman')"
                            class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />

                        <div class="relative">
                            <label
                                class="flex items-center justify-between w-full px-4 py-4 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl hover:border-green-400 dark:hover:border-green-500 focus-within:border-green-500 transition-all duration-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                for="foto_peminjaman">
                                <span id="fileName" class="text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    📷
                                    {{ $peminjaman->foto_peminjaman ? 'Pilih foto baru untuk mengganti' : 'Pilih file gambar' }}
                                    (jpg, jpeg, png - Max 5MB)
                                </span>
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </label>

                            <input id="foto_peminjaman" class="hidden" type="file" name="foto_peminjaman"
                                accept="image/*" />
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
                                    Preview Foto Baru:
                                </p>
                                <div class="relative inline-block">
                                    <img id="image_preview" src="" alt="Preview"
                                        class="max-w-xs max-h-48 rounded-lg shadow-md border-2 border-white dark:border-gray-600" />
                                    <button type="button" id="removeImage"
                                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <x-input-error :messages="$errors->get('foto_peminjaman')" class="mt-2" />

                        @if ($peminjaman->foto_peminjaman)
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                💡 Kosongkan jika tidak ingin mengubah foto
                            </p>
                        @endif
                    </div>

                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Daftar Barang yang Dipinjam
                            </h3>
                            <span
                                class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-sm font-semibold"
                                x-text="`${items.length} Barang`"></span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(item, index) in items" :key="index">
                            <div
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-5 border-2 border-gray-200 dark:border-gray-600 hover:border-green-300 dark:hover:border-green-700 transition-all duration-200">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full text-sm font-bold"
                                            x-text="index + 1"></span>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Barang
                                            <span x-text="index + 1"></span></span>
                                    </div>
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                        class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="group">
                                    <label
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                        <span class="text-red-500">*</span>
                                        Pilih Barang
                                    </label>
                                    <div class="relative">
                                        <select :name="`barang_ids[${index}]`" x-model="item.barang_id" required
                                            class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->barang_id }}">
                                                    {{ $item->nama_barang }} (
                                                    {{ $item->jenisBarang->kode_utama . $item->kode_barang }} ) -
                                                    {{ $item->jenisBarang->jenis ?? '' }}
                                                </option>
                                            @endforeach
                                            @foreach ($peminjaman->peminjamanBarang as $pb)
                                                <option value="{{ $pb->barang_id }}">
                                                    {{ $pb->barang->nama_barang }}
                                                    ({{ $pb->barang->jenisBarang->kode_utama . $pb->barang->kode_barang }})
                                                    -
                                                    {{ $pb->barang->jenisBarang->jenis ?? '' }} (Sedang Dipinjam)
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="flex justify-center pt-2">
                        <button type="button" @click="addItem"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-500 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-green-50 dark:hover:bg-green-900/20 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Barang
                        </button>
                    </div>

                    <div
                        class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                        <a href="{{ route('peminjaman.show', $peminjaman->peminjaman_id) }}"
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
                            {{ __('Perbarui Peminjaman') }}
                        </button>
                    </div>
                    <x-confirm-modal id="update_confirmation"
                        message="Apakah Anda yakin ingin memperbarui data peminjaman ini?" okLabel="Perbarui"
                        cancelLabel="Batal" :url="route('peminjaman.update', $peminjaman->peminjaman_id)" formId="update_peminjaman" />
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function peminjamanForm() {
                return {
                    items: {!! json_encode(
                        $peminjaman->peminjamanBarang->map(function ($pb) {
                                return [
                                    'barang_id' => $pb->barang_id,
                                ];
                            })->values()->toArray(),
                    ) !!},
                    addItem() {
                        this.items.push({
                            barang_id: ''
                        });
                    },
                    removeItem(index) {
                        if (this.items.length > 1) {
                            this.items.splice(index, 1);
                        }
                    }
                }
            }

            const fileInput = document.getElementById('foto_peminjaman');
            const fileNameDisplay = document.getElementById('fileName');
            const previewWrapper = document.getElementById('preview_wrapper');
            const previewImage = document.getElementById('image_preview');
            const removeImageBtn = document.getElementById('removeImage');
            const existingImageContainer = document.getElementById('existing_image_container');

            if (fileInput) {
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

                                // Hide existing image when new image is selected
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
                    const hasExistingImage = {{ $peminjaman->foto_peminjaman ? 'true' : 'false' }};
                    fileNameDisplay.textContent = hasExistingImage ?
                        '📷 Pilih foto baru untuk mengganti (jpg, jpeg, png - Max 5MB)' :
                        '📷 Pilih file gambar (jpg, jpeg, png - Max 5MB)';
                    fileNameDisplay.classList.remove('text-green-600', 'dark:text-green-400', 'font-semibold');
                    fileNameDisplay.classList.add('text-gray-500', 'dark:text-gray-400');
                    previewWrapper.classList.add('hidden');

                    if (existingImageContainer) {
                        existingImageContainer.style.opacity = '1';
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const formGroups = document.querySelectorAll('.group');
                formGroups.forEach(group => {
                    const input = group.querySelector('input, select, textarea');
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
