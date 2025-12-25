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
            <span class="text-xl font-bold text-gray-800 dark:text-white">INVENTARIS</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto h-[calc(100vh-160px)]">
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
    </nav>

    <!-- User Profile Section -->
    <div x-data="{ profileOpen: false }"
        class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <!-- Profile Trigger Button -->
        <button @click="profileOpen = !profileOpen"
            class="flex items-center w-full px-4 py-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
            <div
                class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-green-600 to-green-400 text-white text-sm font-semibold shadow-lg shadow-green-500/30">
                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
            </div>
            <div class="ml-3 text-left flex-1">
                <div class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
                    {{ Auth::user()->username }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">View Profile</div>
            </div>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-all duration-300"
                :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="profileOpen" @click.away="profileOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute bottom-20 left-4 right-4 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 py-2 z-50">

            <!-- Profile Link -->
            <a href="{{ route('profile.edit') }}"
                class="group flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-green-500 transition-colors" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ __('Profile') }}
            </a>

            <!-- Divider -->
            <div class="my-1 border-t border-gray-200 dark:border-gray-700"></div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="group flex items-center w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
                    <svg class="w-5 h-5 mr-3 text-red-500 group-hover:text-red-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Overlay for mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-30 bg-gray-900/50 backdrop-blur-sm lg:hidden">
</div>
