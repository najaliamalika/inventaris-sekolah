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
                <div class="bg-gradient-to-r from-orange-600 to-orange-400 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        {{ __('Edit Peminjaman') }}
                    </h1>
                    <p class="text-orange-100 mt-2">{{ __('Perbarui data peminjaman dan status pengembalian') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="update_peminjaman" method="POST" 
                        action="{{ route('peminjaman.update', $peminjaman->peminjaman_id) }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Info Card -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-blue-800">Informasi</p>
                                <p class="text-sm text-blue-700 mt-1">
                                    Item yang dipinjam: <span class="font-bold">{{ $peminjaman->item->nama_barang }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Row 1: Tanggal & Nama Peminjam -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="tanggal_peminjaman" :value="__('Tanggal Peminjaman')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="tanggal_peminjaman"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="datetime-local" name="tanggal_peminjaman" 
                                        :value="old('tanggal_peminjaman', date('Y-m-d\TH:i', strtotime($peminjaman->tanggal_peminjaman)))"
                                        required />
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
                                        type="text" name="nama_peminjam" 
                                        :value="old('nama_peminjam', $peminjaman->nama_peminjam)"
                                        placeholder="Masukkan Nama Peminjam" required />
                                </div>
                                <x-input-error :messages="$errors->get('nama_peminjam')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 2: Jumlah & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="jumlah" :value="__('Jumlah Barang')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="jumlah"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="number" name="jumlah" 
                                        :value="old('jumlah', $peminjaman->jumlah)"
                                        placeholder="Masukkan Jumlah" required min="1" />
                                </div>
                                <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="status" :value="__('Status')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <select id="status" name="status" required
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white appearance-none">
                                        <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>
                                            Dipinjam
                                        </option>
                                        <option value="dikembalikan" {{ old('status', $peminjaman->status) == 'dikembalikan' ? 'selected' : '' }}>
                                            Dikembalikan
                                        </option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 3: Tanggal Pengembalian (Conditional) -->
                        <div id="tanggal_pengembalian_group" class="group {{ old('status', $peminjaman->status) == 'dikembalikan' ? '' : 'hidden' }}">
                            <x-input-label for="tanggal_pengembalian" :value="__('Tanggal Pengembalian')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span id="required_mark" class="text-red-500">*</span>
                            </x-input-label>
                            <div class="relative">
                                <x-text-input id="tanggal_pengembalian"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="datetime-local" name="tanggal_pengembalian" 
                                    :value="old('tanggal_pengembalian', $peminjaman->tanggal_pengembalian ? date('Y-m-d\TH:i', strtotime($peminjaman->tanggal_pengembalian)) : '')" />
                            </div>
                            <x-input-error :messages="$errors->get('tanggal_pengembalian')" class="mt-2" />
                        </div>

                        <!-- Row 4: Foto Peminjaman -->
                        <div class="group">
                            <x-input-label for="foto_peminjaman" :value="__('Foto Peminjaman')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-gray-500 text-xs">(Opsional - Kosongkan jika tidak ingin mengubah)</span>
                            </x-input-label>
                            
                            @if(isset($peminjaman->foto_peminjaman_url))
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                    <img src="{{ $peminjaman->foto_peminjaman_url }}" alt="Foto Peminjaman" 
                                        class="max-h-48 rounded-lg shadow-md border border-gray-200" />
                                </div>
                            @endif

                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-all duration-200 bg-gray-50">
                                <input type="file" id="foto_peminjaman" name="foto_peminjaman" accept="image/jpeg,image/png,image/jpg"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-semibold text-blue-600">Klik untuk upload foto baru</span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG (Max. 5MB)</p>
                                </div>
                                <div id="preview_foto_peminjaman" class="mt-4 hidden">
                                    <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-md" />
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('foto_peminjaman')" class="mt-2" />
                        </div>

                        <!-- Row 5: Foto Pengembalian (Conditional) -->
                        <div id="foto_pengembalian_group" class="group {{ old('status', $peminjaman->status) == 'dikembalikan' ? '' : 'hidden' }}">
                            <x-input-label for="foto_pengembalian" :value="__('Foto Pengembalian')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-gray-500 text-xs">(Opsional)</span>
                            </x-input-label>
                            
                            @if(isset($peminjaman->foto_pengembalian_url))
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Foto pengembalian saat ini:</p>
                                    <img src="{{ $peminjaman->foto_pengembalian_url }}" alt="Foto Pengembalian" 
                                        class="max-h-48 rounded-lg shadow-md border border-gray-200" />
                                </div>
                            @endif

                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 transition-all duration-200 bg-gray-50">
                                <input type="file" id="foto_pengembalian" name="foto_pengembalian" accept="image/jpeg,image/png,image/jpg"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">
                                        <span class="font-semibold text-blue-600">Upload foto pengembalian</span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, JPEG, PNG (Max. 5MB)</p>
                                </div>
                                <div id="preview_foto_pengembalian" class="mt-4 hidden">
                                    <img src="" alt="Preview" class="max-h-48 mx-auto rounded-lg shadow-md" />
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('foto_pengembalian')" class="mt-2" />
                        </div>

                        <!-- Row 6: Keterangan -->
                        <div class="group">
                            <x-input-label for="keterangan" :value="__('Keterangan')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <textarea id="keterangan" name="keterangan" rows="4" required
                                placeholder="Masukkan keterangan peminjaman"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white resize-none">{{ old('keterangan', $peminjaman->keterangan) }}</textarea>
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

                        <x-primary-button x-data @click="$dispatch('open-modal', 'update_confirmation')"
                            class="px-8 py-3 bg-gradient-to-r from-orange-600 to-orange-400 hover:from-orange-700 hover:to-orange-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Update Peminjaman') }}
                        </x-primary-button>

                        <x-confirm-modal id="update_confirmation"
                            message="Apakah Anda yakin ingin memperbarui data peminjaman ini? Perubahan status akan mempengaruhi stok barang."
                            okLabel="Update" cancelLabel="Batal" 
                            :url="route('peminjaman.update', $peminjaman->peminjaman_id)" 
                            formId="update_peminjaman" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const tanggalPengembalianGroup = document.getElementById('tanggal_pengembalian_group');
            const tanggalPengembalianInput = document.getElementById('tanggal_pengembalian');
            const fotoPengembalianGroup = document.getElementById('foto_pengembalian_group');

            // Toggle tanggal & foto pengembalian based on status
            statusSelect.addEventListener('change', function() {
                if (this.value === 'dikembalikan') {
                    tanggalPengembalianGroup.classList.remove('hidden');
                    fotoPengembalianGroup.classList.remove('hidden');
                    tanggalPengembalianInput.required = true;
                    
                    // Set default date to now if empty
                    if (!tanggalPengembalianInput.value) {
                        const now = new Date();
                        const year = now.getFullYear();
                        const month = String(now.getMonth() + 1).padStart(2, '0');
                        const day = String(now.getDate()).padStart(2, '0');
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        tanggalPengembalianInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                    }
                } else {
                    tanggalPengembalianGroup.classList.add('hidden');
                    fotoPengembalianGroup.classList.add('hidden');
                    tanggalPengembalianInput.required = false;
                    tanggalPengembalianInput.value = '';
                }
            });

            // Image preview for foto_peminjaman
            const fotoPeminjamanInput = document.getElementById('foto_peminjaman');
            const previewPeminjamanDiv = document.getElementById('preview_foto_peminjaman');
            const previewPeminjamanImg = previewPeminjamanDiv.querySelector('img');

            fotoPeminjamanInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewPeminjamanImg.src = e.target.result;
                        previewPeminjamanDiv.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Image preview for foto_pengembalian
            const fotoPengembalianInput = document.getElementById('foto_pengembalian');
            const previewPengembalianDiv = document.getElementById('preview_foto_pengembalian');
            const previewPengembalianImg = previewPengembalianDiv.querySelector('img');

            fotoPengembalianInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewPengembalianImg.src = e.target.result;
                        previewPengembalianDiv.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Character counter
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