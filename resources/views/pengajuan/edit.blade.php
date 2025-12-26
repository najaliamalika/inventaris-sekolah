<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Edit Pengajuan') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Perbarui data pengajuan {{ $pengajuan->tipe }}</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('pengajuan.index') }}"
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
            <form id="update_pengajuan" method="POST"
                action="{{ route('pengajuan.update', $pengajuan->pengajuan_id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informasi Pengajuan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="tanggal" :value="__('Tanggal')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="tanggal"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="date" name="tanggal" :value="old('tanggal', $pengajuan->tanggal->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="tipe" :value="__('Tipe Pengajuan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="tipe" name="tipe" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="pembelian"
                                    {{ old('tipe', $pengajuan->tipe) == 'pembelian' ? 'selected' : '' }}>
                                    💰 Pembelian Barang Baru
                                </option>
                                <option value="perbaikan"
                                    {{ old('tipe', $pengajuan->tipe) == 'perbaikan' ? 'selected' : '' }}>
                                    🔧 Perbaikan Barang
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('tipe')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2" id="jenisBarangContainer"
                            style="display: {{ old('tipe', $pengajuan->tipe) == 'perbaikan' ? 'block' : 'none' }}">
                            <x-input-label for="jenis_barang_id" :value="__('Jenis Barang')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <select id="jenis_barang_id" name="jenis_barang_id"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white appearance-none">
                                <option value="">-- Pilih Jenis Barang --</option>
                                @foreach ($jenisBarang as $jenis)
                                    <option value="{{ $jenis->jenis_barang_id }}"
                                        {{ old('jenis_barang_id', $pengajuan->jenis_barang_id) == $jenis->jenis_barang_id ? 'selected' : '' }}>
                                        {{ $jenis->jenis }} (Tersedia:
                                        {{ $jenis->barang()->tersedia()->get()->count() }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('jenis_barang_id')" class="mt-2" />
                        </div>

                        @if ($pengajuan->tipe === 'pembelian')
                            <div class="group md:col-span-2">
                                <x-input-label for="nama_barang" :value="__('Nama Barang')"
                                    class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                    <span class="text-red-500">*</span>
                                </x-input-label>
                                <x-text-input id="nama_barang"
                                    class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                    type="text" name="nama_barang" :value="old('nama_barang', $pengajuan->nama_barang)"
                                    placeholder="Contoh: Laptop HP ProBook 450 G8" required />
                                <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                            </div>
                        @endif

                        <div class="group">
                            <x-input-label for="jumlah" :value="__('Jumlah')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="jumlah"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="number" name="jumlah" min="1" :value="old('jumlah', $pengajuan->jumlah)" required />
                            <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                        </div>

                        <div class="group">
                            <x-input-label for="estimasi_biaya" :value="__('Estimasi Biaya (Rp)')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <x-text-input id="estimasi_biaya"
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                type="number" name="estimasi_biaya" min="0" :value="old('estimasi_biaya', $pengajuan->estimasi_biaya)" required />
                            <x-input-error :messages="$errors->get('estimasi_biaya')" class="mt-2" />
                        </div>

                        <div class="group md:col-span-2">
                            <x-input-label for="alasan" :value="__('Alasan Pengajuan')"
                                class="text-gray-700 dark:text-gray-300 font-semibold mb-2 flex items-center gap-2">
                                <span class="text-red-500">*</span>
                            </x-input-label>
                            <textarea id="alasan" name="alasan" rows="4" required
                                class="block w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200 hover:border-gray-300 bg-white dark:bg-gray-700 dark:text-white"
                                placeholder="Jelaskan alasan pengajuan secara detail...">{{ old('alasan', $pengajuan->alasan) }}</textarea>
                            <x-input-error :messages="$errors->get('alasan')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div id="barangSelectionContainer"
                    style="display: {{ old('tipe', $pengajuan->tipe) == 'perbaikan' ? 'block' : 'none' }}">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Pilih Barang yang Akan Diperbaiki
                        </h3>

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-blue-800 dark:text-blue-300">
                                    <p class="font-semibold mb-1">Pilih jenis barang terlebih dahulu</p>
                                    <p>Barang yang ditampilkan adalah barang dengan kondisi <strong>baik</strong>.
                                        Jumlah barang yang dipilih harus sesuai dengan jumlah yang diinput.</p>
                                </div>
                            </div>
                        </div>

                        <div id="availableBarangContainer" class="space-y-3">
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                                Pilih jenis barang untuk melihat daftar barang yang tersedia
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                    <a href="{{ route('pengajuan.index') }}"
                        class="px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        {{ __('Batal') }}
                    </a>

                    <button type="button" x-data @click="$dispatch('open-modal', 'update_confirmation')"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {{ __('Perbarui Pengajuan') }}
                    </button>
                </div>

                <x-confirm-modal id="update_confirmation" message="Apakah Anda yakin ingin memperbarui pengajuan ini?"
                    okLabel="Perbarui" cancelLabel="Batal" :url="route('pengajuan.update', $pengajuan->pengajuan_id)" formId="update_pengajuan" />
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const existingBarangIds = @json($pengajuan->perbaikanItems->pluck('barang_id')->toArray() ?? []);
            let availableBarang = [];

            document.getElementById('tipe').addEventListener('change', function() {
                const tipe = this.value;
                const jenisContainer = document.getElementById('jenisBarangContainer');
                const barangContainer = document.getElementById('barangSelectionContainer');
                const jenisSelect = document.getElementById('jenis_barang_id');

                if (tipe === 'perbaikan') {
                    jenisContainer.style.display = 'block';
                    barangContainer.style.display = 'block';
                    jenisSelect.required = true;
                } else {
                    jenisContainer.style.display = 'none';
                    barangContainer.style.display = 'none';
                    jenisSelect.required = false;
                    jenisSelect.value = '';
                    document.getElementById('availableBarangContainer').innerHTML = `
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Pilih jenis barang untuk melihat daftar barang yang tersedia
                        </p>
                    `;
                }
            });

            document.getElementById('jenis_barang_id').addEventListener('change', async function() {
                const jenisBarangId = this.value;

                if (!jenisBarangId) {
                    document.getElementById('availableBarangContainer').innerHTML = `
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            Pilih jenis barang untuk melihat daftar barang yang tersedia
                        </p>
                    `;
                    return;
                }

                try {
                    const response = await fetch(`/api/pengajuan/available-barang/${jenisBarangId}`);
                    availableBarang = await response.json();

                    renderBarangList();
                } catch (error) {
                    console.error('Error loading barang:', error);
                    document.getElementById('availableBarangContainer').innerHTML = `
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 text-center">
                            <p class="text-red-600 dark:text-red-400">Gagal memuat data barang</p>
                        </div>
                    `;
                }
            });

            function renderBarangList() {
                const container = document.getElementById('availableBarangContainer');

                if (availableBarang.length === 0) {
                    container.innerHTML = `
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 text-center">
                            <svg class="w-12 h-12 text-yellow-600 dark:text-yellow-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-yellow-800 dark:text-yellow-300 font-semibold">Tidak ada barang tersedia</p>
                            <p class="text-yellow-600 dark:text-yellow-400 text-sm mt-1">Semua barang untuk jenis ini sedang tidak aktif atau dalam kondisi tidak baik</p>
                        </div>
                    `;
                    return;
                }

                let html = '<div class="grid grid-cols-1 md:grid-cols-2 gap-3">';

                availableBarang.forEach(barang => {
                    const isChecked = existingBarangIds.includes(barang.barang_id) ? 'checked' : '';
                    html += `
                        <label class="barang-checkbox-item relative flex items-start p-4 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 ${isChecked ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : ''}">
                            <input type="checkbox" name="barang_ids[]" value="${barang.barang_id}" 
                                class="barang-checkbox w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 mt-0.5" 
                                onchange="updateSelectedCount()" ${isChecked}>
                            <div class="ml-3 flex-1">
                                <div class="font-semibold text-gray-900 dark:text-gray-100">
                                    ${barang.nama_barang}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    ${barang.kode_barang ? `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">${barang.jenis_barang.kode_utama}${barang.kode_barang}</span>` : ''}
                                    <span class="ml-2">Merk: ${barang.merk}</span>
                                </div>
                                ${barang.lokasi ? `<div class="text-xs text-gray-500 dark:text-gray-400 mt-1">📍 ${barang.lokasi}</div>` : ''}
                            </div>
                        </label>
                    `;
                });

                html += '</div>';
                html += `
                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700 dark:text-gray-300">
                                <strong>Dipilih:</strong> 
                                <span id="selectedCount" class="text-blue-600 dark:text-blue-400 font-semibold">0</span> dari 
                                <strong>Jumlah diinput:</strong> 
                                <span id="requiredCount" class="text-gray-900 dark:text-gray-100 font-semibold">${document.getElementById('jumlah').value || 0}</span>
                            </span>
                            <button type="button" onclick="clearSelection()" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                Bersihkan Pilihan
                            </button>
                        </div>
                    </div>
                `;

                container.innerHTML = html;
                updateSelectedCount();
            }

            function updateSelectedCount() {
                const selected = document.querySelectorAll('.barang-checkbox:checked').length;
                const required = parseInt(document.getElementById('jumlah').value) || 0;

                const selectedCountEl = document.getElementById('selectedCount');
                const requiredCountEl = document.getElementById('requiredCount');

                if (selectedCountEl) {
                    selectedCountEl.textContent = selected;
                    selectedCountEl.className = selected === required ?
                        'text-green-600 dark:text-green-400 font-semibold' :
                        'text-blue-600 dark:text-blue-400 font-semibold';
                }

                if (requiredCountEl) {
                    requiredCountEl.textContent = required;
                }

                document.querySelectorAll('.barang-checkbox-item').forEach(item => {
                    const checkbox = item.querySelector('.barang-checkbox');
                    if (checkbox.checked) {
                        item.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                        item.classList.remove('border-gray-200', 'dark:border-gray-600');
                    } else {
                        item.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
                        item.classList.add('border-gray-200', 'dark:border-gray-600');
                    }
                });
            }

            function clearSelection() {
                document.querySelectorAll('.barang-checkbox:checked').forEach(checkbox => {
                    checkbox.checked = false;
                });
                updateSelectedCount();
            }

            document.getElementById('jumlah').addEventListener('input', function() {
                const requiredCountEl = document.getElementById('requiredCount');
                if (requiredCountEl) {
                    requiredCountEl.textContent = this.value || 0;
                    updateSelectedCount();
                }
            });

            if (document.getElementById('tipe').value === 'perbaikan' && document.getElementById('jenis_barang_id')
                .value) {
                document.getElementById('jenis_barang_id').dispatchEvent(new Event('change'));
            }

            document.getElementById('update_pengajuan').addEventListener('submit', function(e) {
                const tipe = document.getElementById('tipe').value;

                if (tipe === 'perbaikan') {
                    const selectedCount = document.querySelectorAll('.barang-checkbox:checked').length;
                    const requiredCount = parseInt(document.getElementById('jumlah').value) || 0;

                    if (selectedCount !== requiredCount) {
                        e.preventDefault();
                        alert(
                            `Jumlah barang yang dipilih (${selectedCount}) harus sesuai dengan jumlah yang diinput (${requiredCount})`
                        );
                        return false;
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
