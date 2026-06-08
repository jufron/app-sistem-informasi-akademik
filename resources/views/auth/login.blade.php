{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}


<x-frond.layout.app title="SD Katolik Weetabula - Masa Depan Cerah Dimulai Di Sini"
    metaDescription="Website resmi SD Katolik Weetabula. Pendidikan dasar unggulan dengan konsep modern, berkarakter, dan inovatif.">

    <!-- Login Section (Laravel Breeze Replacement - Liquid Glass) -->
    <section
        class="relative min-h-screen w-full flex items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-700 py-12 px-6">

        <!-- Abstract Vibrant Background Blobs -->
        <div
            class="absolute inset-0 w-full h-full overflow-hidden z-0 pointer-events-none flex justify-center items-center">
            <div
                class="absolute top-[10%] left-[10%] w-[400px] h-[400px] rounded-full bg-gradient-to-br from-[#2A246B]/40 to-[#FCEE09]/30 dark:from-[#2A246B]/20 dark:to-[#FCEE09]/10 blur-[100px] animate-pulse">
            </div>
            <div
                class="absolute bottom-[10%] right-[10%] w-[500px] h-[500px] rounded-full bg-gradient-to-tl from-[#FCEE09]/40 to-[#2A246B]/30 dark:from-[#FCEE09]/20 dark:to-[#2A246B]/20 blur-[120px]">
            </div>
        </div>

        <!-- Main Glass Container -->
        <div
            class="relative z-10 w-full max-w-5xl group rounded-[2.5rem] lg:rounded-[3.5rem] overflow-hidden shadow-[0_20px_50px_rgba(42,36,107,0.07)]">

            <!-- Pure Liquid Glass Backing -->
            <div
                class="absolute inset-0 bg-white/30 dark:bg-slate-900/40 backdrop-blur-3xl border border-white/50 dark:border-white/10 transition-colors duration-500 z-10">
            </div>
            <!-- Glossy Top Edge -->
            <div
                class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
            </div>

            <div class="relative z-20 flex flex-col md:flex-row w-full h-full">

                <!-- LEFT PANEL: Branding & Visual (Hidden on small mobile) -->
                <div class="hidden md:flex md:w-5/12 lg:w-1/2 relative bg-[#2A246B] overflow-hidden">
                    <!-- Background Image -->
                    <img src="https://images.unsplash.com/photo-1524069290683-0457abfe42c3?q=80&w=2070&auto=format&fit=crop"
                        alt="SD Katolik Weetabula"
                        class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-50">
                    <!-- Inner Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1C1C1C]/90 via-[#2A246B]/50 to-transparent">
                    </div>

                    <!-- Content -->
                    <div class="relative z-10 flex flex-col justify-between h-full p-10 lg:p-14">
                        <!-- Logo Area -->
                        <div class="flex items-center space-x-3">
                            <div
                                class="w-12 h-12 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ asset('img/logo-bg.png') }}" alt="Logo SD Katolik Weetabula"
                                    class="w-full h-full object-contain drop-shadow-md" loading="lazy" />
                            </div>
                            <span class="text-xl font-extrabold tracking-tight text-white uppercase">
                                SD Katolik <br><span class="text-[#FCEE09] text-sm">Weetabula</span>
                            </span>
                        </div>

                        <!-- Welcome Text -->
                        <div class="mt-20">
                            <h2 class="text-3xl lg:text-4xl font-extrabold text-white leading-tight mb-4">
                                Selamat Datang Kembali!
                            </h2>
                            <p class="text-[#FCEE09]/80 text-base leading-relaxed">
                                Silakan masuk menggunakan kredensial yang telah diberikan oleh administrator sekolah
                                untuk mengakses portal akademik.
                            </p>
                        </div>

                        <!-- Small aesthetic circles -->
                        <div class="flex space-x-2 mt-8">
                            <div class="w-2 h-2 rounded-full bg-[#FCEE09]"></div>
                            <div class="w-2 h-2 rounded-full bg-white/50"></div>
                            <div class="w-2 h-2 rounded-full bg-white/30"></div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANEL: Login Form -->
                <div class="w-full md:w-7/12 lg:w-1/2 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">

                    <!-- Mobile Logo (Shows only on mobile) -->
                    <div class="md:hidden flex items-center space-x-3 mb-10">
                        <div
                            class="w-10 h-10 flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('img/logo-bg.png') }}" alt="Logo SD Katolik Weetabula"
                                class="w-full h-full object-contain drop-shadow-md" loading="lazy" />
                        </div>
                        <span class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white uppercase">
                            SD Katolik <span class="text-[#2A246B] dark:text-[#FCEE09]">Weetabula</span>
                        </span>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-white mb-2">Portal Login</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Masukkan email dan password
                            Anda untuk melanjutkan.</p>
                    </div>

                    <!-- Session Status (Misal: pesan sukses setelah reset password) -->
                    @if (session('status'))
                        <div
                            class="mb-6 p-4 rounded-2xl bg-emerald-100/50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 backdrop-blur-sm">
                            <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                            </p>
                        </div>
                    @endif

                    <!-- LARAVEL FORM -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email"
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Alamat
                                Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-[#2A246B]/60 dark:text-slate-500"></i>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="username"
                                    class="w-full pl-11 pr-4 py-4 rounded-2xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border 
                                    @error('email') border-rose-500 dark:border-rose-500 focus:ring-rose-500 @else border-[#2A246B]/20 dark:border-slate-700/50 focus:border-[#2A246B] dark:focus:border-[#FCEE09] focus:ring-[#2A246B] dark:focus:ring-[#FCEE09] @enderror 
                                    focus:outline-none focus:ring-2 text-slate-800 dark:text-white placeholder-slate-400 transition-all shadow-inner"
                                    placeholder="nama@email.com">
                            </div>
                            <!-- Validation Error -->
                            @error('email')
                                <p class="mt-2 text-sm text-rose-500 dark:text-rose-400 font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div x-data="{ showPassword: false }">
                            <label for="password"
                                class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-[#2A246B]/60 dark:text-slate-500"></i>
                                </div>
                                <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                                    required autocomplete="current-password"
                                    class="w-full pl-11 pr-12 py-4 rounded-2xl bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm border 
                                    @error('password') border-rose-500 dark:border-rose-500 focus:ring-rose-500 @else border-[#2A246B]/20 dark:border-slate-700/50 focus:border-[#2A246B] dark:focus:border-[#FCEE09] focus:ring-[#2A246B] dark:focus:ring-[#FCEE09] @enderror 
                                    focus:outline-none focus:ring-2 text-slate-800 dark:text-white placeholder-slate-400 transition-all shadow-inner"
                                    placeholder="••••••••">

                                <!-- Toggle Password Visibility (Alpine.js) -->
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-[#2A246B] dark:hover:text-[#FCEE09] focus:outline-none transition-colors">
                                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <!-- Validation Error -->
                            @error('password')
                                <p class="mt-2 text-sm text-rose-500 dark:text-rose-400 font-medium flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1.5"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between pt-2">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input id="remember_me" type="checkbox" name="remember" class="peer sr-only">
                                    <div
                                        class="w-5 h-5 rounded border-2 border-slate-300 dark:border-slate-600 bg-white/50 dark:bg-slate-800/50 peer-checked:bg-[#2A246B] dark:peer-checked:bg-[#FCEE09] peer-checked:border-[#2A246B] dark:peer-checked:border-[#FCEE09] transition-all shadow-inner flex items-center justify-center">
                                        <i
                                            class="fas fa-check text-[10px] text-white dark:text-[#1C1C1C] opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></i>
                                    </div>
                                </div>
                                <span
                                    class="ml-3 text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-[#2A246B] dark:group-hover:text-[#FCEE09] transition-colors">Ingat
                                    saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-bold text-[#2A246B] dark:text-[#FCEE09] hover:text-[#1C1C1C] dark:hover:text-yellow-400 transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-4 text-sm font-black text-white bg-[#2A246B] hover:bg-[#1C1C1C] dark:bg-[#FCEE09] dark:text-[#1C1C1C] dark:hover:bg-yellow-400 rounded-2xl shadow-[0_10px_20px_rgba(42,36,107,0.3)] dark:shadow-[0_10px_20px_rgba(252,238,9,0.2)] transition-all hover:-translate-y-1 active:translate-y-0 flex items-center justify-center group/btn">
                                Masuk ke Dashboard
                                <i
                                    class="fas fa-sign-in-alt ml-2 transform group-hover/btn:translate-x-1 transition-transform"></i>
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                            Kembali ke <a href="{{ url('/') }}"
                                class="font-bold text-[#2A246B] dark:text-[#FCEE09] hover:underline">Halaman Utama</a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
</x-frond.layout.app>
