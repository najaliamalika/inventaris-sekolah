<nav x-data="{ open: false, scrolled: false }" x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-lg shadow-green-500/5' :
        'bg-white dark:bg-gray-900'"
    class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 dark:border-gray-700/50 transition-all duration-300">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}"
                        class="relative w-12 h-12 flex items-center justify-center transform transition-transform duration-300 hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-400 rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300">
                        </div>
                        <div style="background-image: url('{{ asset('images/LOGOMAN1.png') }}')"
                            class="h-10 w-10 bg-cover bg-center bg-no-repeat rounded-lg"></div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-2">
                    <a href="{{ route('dashboard') }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group
                              {{ request()->routeIs('dashboard')
                                  ? 'text-green-600 dark:text-green-400'
                                  : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }}">
                        <span class="relative z-10">{{ __('Dashboard') }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-green-400/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    {{ request()->routeIs('dashboard') ? '!opacity-100' : '' }}">
                        </div>
                        @if (request()->routeIs('dashboard'))
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-gradient-to-r from-green-600 to-green-400 rounded-full">
                            </div>
                        @endif
                    </a>

                    <a href="{{ route('item.index') }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group
                              {{ request()->routeIs('item.*')
                                  ? 'text-green-600 dark:text-green-400'
                                  : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }}">
                        <span class="relative z-10">{{ __('Data Barang') }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-green-400/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    {{ request()->routeIs('item.*') ? '!opacity-100' : '' }}">
                        </div>
                        @if (request()->routeIs('item.*'))
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-gradient-to-r from-green-600 to-green-400 rounded-full">
                            </div>
                        @endif
                    </a>

                    <a href="{{ route('peminjaman.index') }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group
                              {{ request()->routeIs('peminjaman.*')
                                  ? 'text-green-600 dark:text-green-400'
                                  : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }}">
                        <span class="relative z-10">{{ __('Peminjaman') }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-green-400/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    {{ request()->routeIs('peminjaman.*') ? '!opacity-100' : '' }}">
                        </div>
                        @if (request()->routeIs('peminjaman.*'))
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-gradient-to-r from-green-600 to-green-400 rounded-full">
                            </div>
                        @endif
                    </a>

                     <a href="{{ route('barang-masuk.index') }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group
                              {{ request()->routeIs('barang-masuk.*')
                                  ? 'text-green-600 dark:text-green-400'
                                  : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }}">
                        <span class="relative z-10">{{ __('Barang Masuk') }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-green-400/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    {{ request()->routeIs('barang-masuk.*') ? '!opacity-100' : '' }}">
                        </div>
                        @if (request()->routeIs('barang-masuk.*'))
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-gradient-to-r from-green-600 to-green-400 rounded-full">
                            </div>
                        @endif
                    </a>

                    <a href="{{ route('barang-keluar.index') }}"
                        class="relative px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 group
                              {{ request()->routeIs('barang-keluar.*')
                                  ? 'text-green-600 dark:text-green-400'
                                  : 'text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400' }}">
                        <span class="relative z-10">{{ __('Barang Keluar') }}</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-600/10 to-green-400/10 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    {{ request()->routeIs('barang-keluar.*') ? '!opacity-100' : '' }}">
                        </div>
                        @if (request()->routeIs('barang-keluar.*'))
                            <div
                                class="absolute bottom-0 left-1/2 -translate-x-1/2 w-1/2 h-0.5 bg-gradient-to-r from-green-600 to-green-400 rounded-full">
                            </div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="group flex items-center space-x-3 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 
                                       bg-white dark:bg-gray-800 hover:border-green-300 dark:hover:border-green-700
                                       transition-all duration-300 hover:shadow-lg hover:shadow-green-500/10">
                            <div
                                class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-r from-green-600 to-green-400 text-white text-sm font-semibold shadow-lg shadow-green-500/30">
                                {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                            </div>
                            <div
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                {{ Auth::user()->username }}
                            </div>
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-300 group-hover:rotate-180"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}"
                                class="group flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors">
                                <svg class="w-5 h-5 mr-3 text-gray-400 group-hover:text-green-500 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </a>

                            <div class="my-1 border-t border-gray-200 dark:border-gray-700"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="group flex items-center w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-red-500 group-hover:text-red-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-500 dark:text-gray-400 
                               hover:text-green-600 dark:hover:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 
                               focus:outline-none transition-all duration-300">
                    <svg class="h-6 w-6 transition-transform duration-300" :class="{ 'rotate-90': open }"
                        stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-4"
        class="sm:hidden border-t border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg">

        <!-- Mobile Nav Links -->
        <div class="px-4 pt-4 pb-3 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('dashboard')
                          ? 'bg-gradient-to-r from-green-600/10 to-green-400/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-lg shadow-green-500/10'
                          : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Dashboard') }}
            </a>

            <a href="{{ route('item.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('item.*')
                          ? 'bg-gradient-to-r from-green-600/10 to-green-400/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-lg shadow-green-500/10'
                          : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Data Barang') }}
            </a>

            <a href="{{ route('item.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('peminjaman*')
                          ? 'bg-gradient-to-r from-green-600/10 to-green-400/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-lg shadow-green-500/10'
                          : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Peminjaman') }}
            </a>

            <a href="{{ route('barang-masuk.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('barang-masuk*')
                          ? 'bg-gradient-to-r from-green-600/10 to-green-400/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-lg shadow-green-500/10'
                          : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Barang Masuk') }}
            </a>

            <a href="{{ route('barang-keluar.index') }}"
                class="flex items-center px-4 py-3 rounded-xl text-sm font-medium transition-all duration-300
                      {{ request()->routeIs('barang-keluar*')
                          ? 'bg-gradient-to-r from-green-600/10 to-green-400/10 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 shadow-lg shadow-green-500/10'
                          : 'text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                {{ __('Barang Keluar') }}
            </a>
        </div>

        <!-- Mobile User Section -->
        <div class="px-4 py-4 border-t border-gray-200 dark:border-gray-700">
            <div
                class="flex items-center mb-4 p-3 rounded-xl bg-gradient-to-r from-green-600/5 to-green-400/5 border border-green-200/50 dark:border-green-800/50">
                <div
                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-green-600 to-green-400 text-white text-sm font-semibold shadow-lg shadow-green-500/30">
                    {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                </div>
                <div class="ml-3">
                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center px-4 py-2.5 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-all">
                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full px-4 py-2.5 rounded-xl text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Add padding to body to account for fixed navbar -->
<div class="h-20"></div>
