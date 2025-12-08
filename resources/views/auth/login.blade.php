<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full">
            <!-- Logo/Header Section -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-600 to-green-400 shadow-lg mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
                <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="w-full mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- username -->
                        <div class="group">
                            <x-input-label for="username" :value="__('Username')"
                                class="text-gray-700 font-semibold mb-3 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <x-text-input id="username"
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="username" :value="old('username')" required autofocus autocomplete="username"
                                    placeholder="nama@example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('username')" class="mt-3" />
                        </div>

                        <!-- Password -->
                        <div class="group">
                            <x-input-label for="password" :value="__('Password')"
                                class="text-gray-700 font-semibold mb-3 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password"
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Masukkan kata sandi Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-3" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="w-4 h-4 rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 cursor-pointer"
                                name="remember">
                            <label for="remember_me" class="ms-2 text-sm text-gray-600 cursor-pointer select-none">
                                {{ __('Ingat saya') }}
                            </label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-8">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Masuk') }}
                        </button>

                        <!-- Forgot Password Link -->
                        @if (Route::has('password.request'))
                            <div class="text-center pt-4 border-t border-gray-200">
                                <a href="{{ route('password.request') }}"
                                    class="text-sm text-green-600 hover:text-green-700 font-medium transition-colors duration-200">
                                    {{ __('Lupa kata sandi?') }}
                                </a>
                            </div>
                        @endif
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                    <p class="text-center text-sm text-gray-600">
                        Belum punya akun?
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700 font-semibold transition-colors duration-200">
                                Daftar di sini
                            </a>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Bottom Text -->
            <p class="text-center text-xs text-gray-500 mt-8">
                © 2024 Sistem Manajemen Inventori. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>

    <style>
        @keyframes gradient-shift {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .bg-gradient-to-br {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }
    </style>
</x-guest-layout>