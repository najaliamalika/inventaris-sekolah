<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 via-white to-emerald-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            <!-- Logo/Header Section -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-green-600 to-green-400 shadow-2xl shadow-green-500/30 mb-6 transform hover:scale-105 transition-transform duration-300">
                    <div style="background-image: url('{{ asset('images/LOGOMAN1.png') }}')"
                        class="h-12 w-12 bg-cover bg-center bg-no-repeat rounded-lg"></div>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
                <p class="text-gray-600">Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 animate-fade-in">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Username -->
                        <div>
                            <x-input-label for="username" :value="__('Username')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="username"
                                    class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="text" name="username" :value="old('username')" required autofocus
                                    autocomplete="username" placeholder="Masukkan username Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')"
                                class="text-gray-700 font-semibold mb-2 flex items-center gap-2" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password"
                                    class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all duration-200 hover:border-gray-300 bg-gray-50 focus:bg-white"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="Masukkan kata sandi Anda" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Login Button -->
                        <button type="submit"
                            class="w-full px-6 py-3.5 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 group">
                            <span>{{ __('Masuk') }}</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Text -->
            <p class="text-center text-xs text-gray-500 mt-8">
                © {{ date('Y') }} Sistem Manajemen IT. Semua hak cipta dilindungi.
            </p>
        </div>
    </div>

    <style>
        @keyframes gradient-shift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bg-gradient-to-br {
            background-size: 200% 200%;
            animation: gradient-shift 8s ease infinite;
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }
    </style>
</x-guest-layout>
