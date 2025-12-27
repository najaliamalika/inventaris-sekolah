<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Laporan') }}
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Download laporan dalam format Excel atau PDF</p>
        </div>
    </x-slot>

    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px space-x-8" role="tablist">
                <button onclick="switchMainTab('tahunan')"
                    class="main-tab border-b-2 border-blue-500 py-4 px-1 text-center font-medium text-sm text-blue-600 dark:text-blue-400"
                    data-tab="tahunan">
                    📊 Laporan Tahunan @hasanyrole('bendahara|kepala_sekolah')
                    @endhasanyrole
                </button>
                @hasanyrole('bendahara|kepala_sekolah')
                    <button onclick="switchMainTab('range')"
                        class="main-tab border-b-2 border-transparent py-4 px-1 text-center font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300"
                        data-tab="range">
                        📅 Range Waktu (Per Jenis)
                    </button>
                @endhasanyrole
            </nav>
        </div>
    </div>

    <div class="space-y-6">
        <div class="main-content" data-content="tahunan">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden max-w-3xl mx-auto">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-white">Laporan Tahunan Lengkap</h2>
                    </div>
                    @hasanyrole('bendahara|kepala_sekolah')
                        <p class="text-indigo-100 text-sm">Download semua laporan (Barang Masuk, Barang Keluar,
                            Pengajuan) dalam 1 file</p>
                    @endhasanyrole
                    @hasrole('admin')
                        <p class="text-indigo-100 text-sm">Download laporan Peminjaman Barang</p>
                    @endhasrole


                </div>
                <div class="p-8">
                    @hasanyrole('bendahara|kepala_sekolah')
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 text-sm mb-1">Yang Termasuk
                                        dalam Laporan:</h4>
                                    <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                        <li>• Laporan Barang Masuk</li>
                                        <li>• Laporan Barang Keluar</li>
                                        <li>• Laporan Pengajuan</li>
                                    </ul>
                                    <p class="text-xs text-blue-700 dark:text-blue-300 mt-2">
                                        <strong>Excel:</strong> 3 sheets dalam 1 file | <strong>PDF:</strong> Semua laporan
                                        dalam 1 dokumen
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endhasanyrole

                    <form action="{{ route('reports.tahunan') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Tahun Laporan
                                </span>
                            </label>
                            <input type="number" name="year" value="{{ date('Y') }}" min="2020"
                                max="{{ date('Y') }}" required
                                class="w-full px-4 py-3 text-lg border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pilih tahun untuk mengunduh laporan
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    Format Download
                                </span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label
                                    class="relative flex items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-indigo-500 transition-all group">
                                    <input type="radio" name="format" value="excel" required
                                        class="absolute opacity-0 peer">
                                    <div
                                        class="text-center peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <div
                                            class="text-3xl mb-2 peer-checked:scale-110 transition-transform group-hover:scale-105">
                                            📊</div>
                                        <div class="font-semibold">Excel</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            @hasanyrole('bendahara|kepala_sekolah')
                                                3 Sheets
                                            @endhasanyrole
                                            @hasrole('admin')
                                                1 Sheet
                                            @endhasrole
                                        </div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-500 rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity">
                                    </div>
                                </label>

                                <label
                                    class="relative flex items-center justify-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-indigo-500 transition-all group">
                                    <input type="radio" name="format" value="pdf" class="absolute opacity-0 peer">
                                    <div
                                        class="text-center peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                        <div
                                            class="text-3xl mb-2 peer-checked:scale-110 transition-transform group-hover:scale-105">
                                            📄</div>
                                        <div class="font-semibold">PDF</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">1 Dokumen</div>
                                    </div>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-500 rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-4 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 text-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Laporan Tahunan @hasanyrole('bendahara|kepala_sekolah')
                                Lengkap
                            @endhasanyrole
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- RANGE WAKTU (Per Jenis Laporan) -->
        <div class="main-content hidden" data-content="range">
            <!-- Sub Tabs: Jenis Laporan -->
            <div class="mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex -mb-px space-x-4 overflow-x-auto" role="tablist">
                        <button onclick="switchSubTab('peminjaman')"
                            class="sub-tab border-b-2 border-blue-500 py-3 px-3 text-center font-medium text-sm text-blue-600 dark:text-blue-400 whitespace-nowrap"
                            data-tab="peminjaman">
                            📋 Peminjaman
                        </button>
                        <button onclick="switchSubTab('barang-masuk')"
                            class="sub-tab border-b-2 border-transparent py-3 px-3 text-center font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap"
                            data-tab="barang-masuk">
                            📥 Barang Masuk
                        </button>
                        <button onclick="switchSubTab('barang-keluar')"
                            class="sub-tab border-b-2 border-transparent py-3 px-3 text-center font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap"
                            data-tab="barang-keluar">
                            📤 Barang Keluar
                        </button>
                        <button onclick="switchSubTab('pengajuan')"
                            class="sub-tab border-b-2 border-transparent py-3 px-3 text-center font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap"
                            data-tab="pengajuan">
                            📝 Pengajuan
                        </button>
                    </nav>
                </div>
            </div>

            <!-- PEMINJAMAN -->
            <div class="report-content" data-report="peminjaman">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6">
                        <h2 class="text-xl font-semibold text-white">Laporan Peminjaman</h2>
                        <p class="text-blue-100 text-sm mt-1">Download laporan peminjaman berdasarkan rentang tanggal
                        </p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('reports.peminjaman') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Format
                                    Download</label>
                                <select name="format" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                                    <option value="excel">📊 Excel (.xlsx)</option>
                                    <option value="pdf">📄 PDF</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BARANG MASUK -->
            <div class="report-content hidden" data-report="barang-masuk">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-green-600 to-green-500 p-6">
                        <h2 class="text-xl font-semibold text-white">Laporan Barang Masuk</h2>
                        <p class="text-green-100 text-sm mt-1">Download laporan barang masuk berdasarkan rentang
                            tanggal</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('reports.barang-masuk') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Format
                                    Download</label>
                                <select name="format" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                                    <option value="excel">📊 Excel (.xlsx)</option>
                                    <option value="pdf">📄 PDF</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- BARANG KELUAR -->
            <div class="report-content hidden" data-report="barang-keluar">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-red-600 to-red-500 p-6">
                        <h2 class="text-xl font-semibold text-white">Laporan Barang Keluar</h2>
                        <p class="text-red-100 text-sm mt-1">Download laporan barang keluar berdasarkan rentang tanggal
                        </p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('reports.barang-keluar') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Format
                                    Download</label>
                                <select name="format" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                                    <option value="excel">📊 Excel (.xlsx)</option>
                                    <option value="pdf">📄 PDF</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PENGAJUAN -->
            <div class="report-content hidden" data-report="pengajuan">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden max-w-2xl mx-auto">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-500 p-6">
                        <h2 class="text-xl font-semibold text-white">Laporan Pengajuan</h2>
                        <p class="text-purple-100 text-sm mt-1">Download laporan pengajuan berdasarkan rentang tanggal
                        </p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('reports.pengajuan') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Mulai</label>
                                <input type="date" name="start_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Format
                                    Download</label>
                                <select name="format" required
                                    class="w-full px-4 py-2.5 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all bg-white dark:bg-gray-700 dark:text-white">
                                    <option value="excel">📊 Excel (.xlsx)</option>
                                    <option value="pdf">📄 PDF</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-purple-600 to-purple-500 hover:from-purple-700 hover:to-purple-600 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Laporan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let currentMainTab = 'tahunan';
            let currentSubTab = 'peminjaman';

            function switchMainTab(tab) {
                currentMainTab = tab;

                // Update main tab styling
                document.querySelectorAll('.main-tab').forEach(btn => {
                    if (btn.dataset.tab === tab) {
                        btn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                        btn.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                    } else {
                        btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                        btn.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                    }
                });

                // Show/hide main content
                document.querySelectorAll('.main-content').forEach(content => {
                    if (content.dataset.content === tab) {
                        content.classList.remove('hidden');
                    } else {
                        content.classList.add('hidden');
                    }
                });
            }

            function switchSubTab(tab) {
                currentSubTab = tab;

                // Update sub tab styling
                document.querySelectorAll('.sub-tab').forEach(btn => {
                    if (btn.dataset.tab === tab) {
                        btn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                        btn.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                    } else {
                        btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
                        btn.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400');
                    }
                });

                // Show/hide report content
                const rangeContent = document.querySelector('.main-content[data-content="range"]');
                if (rangeContent) {
                    rangeContent.querySelectorAll('.report-content').forEach(content => {
                        if (content.dataset.report === tab) {
                            content.classList.remove('hidden');
                        } else {
                            content.classList.add('hidden');
                        }
                    });
                }
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                switchMainTab('tahunan');
            });
        </script>
    @endpush
</x-app-layout>
