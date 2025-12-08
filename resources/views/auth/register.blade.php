<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Logo/Header Section -->
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-green-600 to-green-400 shadow-lg mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
                <p class="text-gray-600">Bergabunglah dan mulai kelola inventori Anda</p>
            </div>

            <!-- Main Card -->
            <div class="w=[50%]bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="group">
                            <x-input-label for="name" :value="__('Nama Lengkap')"
                                class="text-gray-700 font-semibold mb-3 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="name"
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="Masukkan nama lengkap Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-3" />
                        </div>

                        <!-- Email Address -->
                        <div class="group">
                            <x-input-label for="email" :value="__('Email Address')"
                                class="text-gray-700 font-semibold mb-3 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <x-text-input id="email"
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="email" name="email" :value="old('email')" required autocomplete="username"
                                    placeholder="nama@example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-3" />
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
                                    type="password" name="password" required autocomplete="new-password"
                                    placeholder="Minimal 8 karakter" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-3" />
                            <p class="text-xs text-gray-500 mt-2">Gunakan kombinasi huruf besar, huruf kecil, angka dan simbol</p>
                        </div>

                        <!-- Confirm Password -->
                        <div class="group">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                                class="text-gray-700 font-semibold mb-3 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <x-text-input id="password_confirmation"
                                    class="block w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-green-500 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Ulangi password Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-3" />
                        </div>

                        <!-- Register Button -->
                        <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-8">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            {{ __('Daftar') }}
                        </button>

                        <!-- Already Registered Link -->
                        <div class="text-center pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                Sudah punya akun?
                                <a href="{{ route('login') }}"
                                    class="text-green-600 hover:text-green-700 font-semibold transition-colors duration-200">
                                    {{ __('Masuk di sini') }}
                                </a>
                            </p>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-100">
                    <p class="text-center text-xs text-gray-600">
                        Dengan mendaftar, Anda menyetujui <a href="#" class="text-green-600 hover:text-green-700">Syarat & Ketentuan</a> kami
                    </p>
                </div>
            </div>

            <!-- Bottom Text -->
            <p class="text-center text-xs text-gray-500 mt-8">
                © 2025 Sistem Inventaris MAN 1 Kota Tangerang. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>
</x-guest-layout>