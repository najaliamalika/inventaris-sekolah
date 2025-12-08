<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12">
        <div class="max-w-2xl mx-auto px-6">
            <!-- Back Button -->
            <a href="{{ route('kategori-item.index') }}"
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
                        {{ __('Edit Kategori') }}
                    </h1>
                    <p class="text-green-100 mt-2">{{ __('Perbarui informasi kategori template') }}</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form id="update_template" method="POST"
                        action="{{ route('kategori-item.update', $itemTemplate->item_templates_id) }}"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Row 1: Kategori & Jenis -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kategori" :value="__('Kategori')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <div class="relative">
                                    <x-text-input id="kategori"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="kategori" :value="old('kategori', $itemTemplate->kategori)"
                                        placeholder="Contoh: Elektronik" required autocomplete="kategori" />
                                </div>
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="jenis" :value="__('Jenis')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="jenis"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="jenis" placeholder="Contoh: Laptop" required
                                    :value="old('jenis', $itemTemplate->jenis)" autocomplete="jenis" />
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 2: Kode Utama & Satuan -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <x-input-label for="kode_utama" :value="__('Kode Utama')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                                <div class="relative">
                                    <x-text-input id="kode_utama"
                                        class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                        type="text" name="kode_utama" placeholder="Contoh: ELK-001" :value="old('kode_utama', $itemTemplate->kode_utama)"
                                        autocomplete="kode_utama" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('kode_utama')" class="mt-2" />
                            </div>

                            <div class="group">
                                <x-input-label for="satuan" :value="__('Satuan')"
                                    class="text-gray-700 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="satuan"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="satuan" placeholder="Contoh: Unit, Pcs, Box" required
                                    :value="old('satuan', $itemTemplate->satuan)" autocomplete="satuan" />
                                <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Row 3: Stok -->
                        <div class="group">
                            <x-input-label for="stok" :value="__('Stok')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                            <x-text-input id="stok"
                                class="block w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                type="number" name="stok" placeholder="Masukkan stok" :value="old('stok', $itemTemplate->stok)"
                                min="0" autocomplete="stok" />
                            <p class="mt-2 text-sm text-gray-500">
                                <span class="font-semibold text-gray-700">Catatan:</span> Stok akan otomatis berubah
                                saat item ditambah/dihapus
                            </p>
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200 space-x-4">
                            <a href="{{ route('kategori-item.index') }}"
                                class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ __('Batal') }}
                            </a>

                            <x-primary-button x-data type="button"
                                @click="$dispatch('open-modal', 'update_confirmation')"
                                class="px-8 py-3 bg-gradient-to-r from-green-600 to-green-400 hover:from-green-700 hover:to-green-500 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Simpan Perubahan') }}
                            </x-primary-button>

                            <x-confirm-modal id="update_confirmation"
                                message="Apakah kamu yakin ingin memperbarui data kategori ini?" okLabel="Simpan"
                                cancelLabel="Batal" :url="route('kategori-item.update', $itemTemplate->item_templates_id)" formId="update_template" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
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
</x-app-layout>
