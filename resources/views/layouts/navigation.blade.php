<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl">

    <!-- Logo Section -->
    <div class="flex items-center justify-between h-20 px-6 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
            <div
                class="relative w-10 h-10 flex items-center justify-center transform transition-transform duration-300 group-hover:scale-110">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-400 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                </div>
                <div style="background-image: url('{{ asset('images/LOGOMAN1.png') }}')"
                    class="h-8 w-8 bg-cover bg-center bg-no-repeat rounded-lg"></div>
            </div>
            <span class="text-sm font-bold text-gray-800 dark:text-white">INVENTARIS MAN 1 KOTA TANGERANG</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto h-[calc(100vh-80px)]">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Data Barang -->
        <a href="{{ route('jenis-barang.index') }}"
            class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('jenis-barang.*') || request()->routeIs('barang.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('jenis-barang.*') || request()->routeIs('barang.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>Data Barang</span>
        </a>

        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

        @hasrole('admin')
            <!-- Peminjaman -->
            <a href="{{ route('peminjaman.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('peminjaman.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('peminjaman.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                <span>Peminjaman</span>
            </a>
            <!-- Barang Masuk -->
            <a href="{{ route('barang-masuk.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('barang-masuk.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('barang-masuk.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                </svg>
                <span>Barang Masuk</span>
            </a>

            <!-- Barang Keluar -->
            <a href="{{ route('barang-keluar.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('barang-keluar.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('barang-keluar.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                <span>Barang Keluar</span>
            </a>
        @endhasrole

        <!-- Pengajuan -->
        @hasanyrole('admin|bendahara')
            <a href="{{ route('pengajuan.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('pengajuan.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('pengajuan.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Pengajuan</span>
            </a>
        @endhasanyrole

        <a href="{{ route('reports.index') }}"
            class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group
                  {{ request()->routeIs('reports.*') ? 'bg-gradient-to-r from-green-600 to-green-500 text-white shadow-lg shadow-green-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
            <svg class="w-5 h-5 mr-3 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 17l6-6 4 4 7-7M3 21h18" />
            </svg>


            <span>Laporan</span>
        </a>

        <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center w-full px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300 group text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                <svg class="w-5 h-5 mr-3 text-red-500 group-hover:text-red-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </nav>
</aside>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm lg:hidden">
</div>
