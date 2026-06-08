<nav x-data="{
    isScrolled: false,
    mobileMenuOpen: false,
    isDarkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
}" x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 20 });
$watch('isDarkMode', value => {
    document.documentElement.classList.toggle('dark', value);
    localStorage.setItem('theme', value ? 'dark' : 'light');
});
document.documentElement.classList.toggle('dark', isDarkMode);"
    :class="{
        'py-6 bg-transparent w-full': !isScrolled,
        'py-3 top-4 mx-auto w-[95%] rounded-[2rem] bg-white/70 dark:bg-slate-900/70 backdrop-blur-2xl border border-white/20 dark:border-slate-700/30 shadow-[0_20px_50px_rgba(0,0,0,0.1)]': isScrolled
    }"
    class="fixed top-0 left-0 right-0 transition-all duration-700 ease-in-out z-[9999] px-6 lg:px-12">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <div class="flex items-center space-x-3 group cursor-pointer relative z-[10000]">
            <div
                class="w-12 h-12 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                <img src="{{ asset('img/logo-bg.png') }}" alt="Logo SD Katolik Weetabula"
                    class="w-full h-full object-contain drop-shadow-md" loading="lazy" />
            </div>
            <span class="text-xl font-bold tracking-tight text-[#1C1C1C] dark:text-white uppercase">
                SD Katolik <span class="text-[#2A246B] dark:text-[#FCEE09]">Weetabula</span>
            </span>
        </div>

        <div class="hidden lg:flex items-center space-x-10 relative z-[10000]">
            <a href="{{ route('frond.home') }}"
                class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('frond.home') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors relative group">
                Beranda
                <span
                    class="absolute -bottom-2 left-0 {{ request()->routeIs('frond.home') ? 'w-full' : 'w-0' }} h-0.5 bg-[#FCEE09] dark:bg-[#FCEE09] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ route('frond.tentang') }}"
                class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('frond.tentang') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors relative group">
                Tentang
                <span
                    class="absolute -bottom-2 left-0 {{ request()->routeIs('frond.tentang') ? 'w-full' : 'w-0' }} h-0.5 bg-[#FCEE09] dark:bg-[#FCEE09] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ route('frond.guru-dan-staf') }}"
                class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('frond.guru-dan-staf') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors relative group">
                Guru & Staf
                <span
                    class="absolute -bottom-2 left-0 {{ request()->routeIs('frond.guru-dan-staf') ? 'w-full' : 'w-0' }} h-0.5 bg-[#FCEE09] dark:bg-[#FCEE09] transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="{{ route('frond.kontak') }}"
                class="text-sm font-bold uppercase tracking-widest {{ request()->routeIs('frond.kontak') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-600 dark:text-slate-300' }} hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors relative group">
                Kontak
                <span
                    class="absolute -bottom-2 left-0 {{ request()->routeIs('frond.kontak') ? 'w-full' : 'w-0' }} h-0.5 bg-[#FCEE09] dark:bg-[#FCEE09] transition-all duration-300 group-hover:w-full"></span>
            </a>
        </div>

        <div class="hidden lg:flex items-center space-x-8 relative z-[10000]">
            <button @click="isDarkMode = !isDarkMode"
                class="p-3 rounded-2xl bg-white/5 hover:bg-white/10 dark:hover:bg-slate-800 border border-white/10 transition-all text-slate-600 dark:text-slate-300 flex items-center justify-center">
                <span x-show="!isDarkMode">
                    <i class="fas fa-sun text-lg text-[#FCEE09]"></i>
                </span>
                <span x-show="isDarkMode" x-cloak>
                    <i class="fas fa-moon text-lg text-slate-300"></i>
                </span>
            </button>

            <div class="flex items-center">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="px-10 py-3.5 text-sm font-black text-white bg-[#2A246B] hover:bg-[#1C1C1C] dark:hover:bg-[#FCEE09] dark:hover:text-[#1C1C1C] rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-md">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-10 py-3.5 text-sm font-black text-white bg-[#2A246B] hover:bg-[#1C1C1C] dark:hover:bg-[#FCEE09] dark:hover:text-[#1C1C1C] rounded-2xl transition-all hover:scale-105 active:scale-95 shadow-md">LOGIN</a>
                @endauth
            </div>
        </div>

        <div class="lg:hidden flex items-center space-x-4 relative z-[10000]">
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="p-3 bg-white/5 backdrop-blur-lg border border-white/10 rounded-2xl text-slate-600 dark:text-slate-300">
                <i x-show="!mobileMenuOpen" class="fas fa-bars text-xl"></i>
                <i x-show="mobileMenuOpen" class="fas fa-times text-xl" x-cloak></i>
            </button>
        </div>
    </div>

    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-[-20px]" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-[-20px]"
        class="lg:hidden absolute top-full left-0 right-0 mt-4 mx-4 p-8 bg-white/95 dark:bg-slate-900/95 backdrop-blur-3xl rounded-[2.5rem] border border-white/20 dark:border-slate-700/30 shadow-2xl overflow-hidden"
        @click.away="mobileMenuOpen = false" x-cloak>
        <div class="flex flex-col space-y-6">
            <a href="{{ route('frond.home') }}"
                class="text-xl font-bold {{ request()->routeIs('frond.home') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-800 dark:text-white' }} flex items-center justify-between">Beranda
                <i class="fas fa-chevron-right text-xs opacity-30"></i></a>
            <a href="{{ route('frond.tentang') }}"
                class="text-xl font-bold {{ request()->routeIs('frond.tentang') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-800 dark:text-white' }} flex items-center justify-between">Tentang
                <i class="fas fa-chevron-right text-xs opacity-30"></i></a>
            <a href="{{ route('frond.guru-dan-staf') }}"
                class="text-xl font-bold {{ request()->routeIs('frond.guru-dan-staf') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-800 dark:text-white' }} flex items-center justify-between">Guru
                & Staf
                <i class="fas fa-chevron-right text-xs opacity-30"></i></a>
            <a href="{{ route('frond.kontak') }}"
                class="text-xl font-bold {{ request()->routeIs('frond.kontak') ? 'text-[#2A246B] dark:text-[#FCEE09]' : 'text-slate-800 dark:text-white' }} flex items-center justify-between">Kontak
                <i class="fas fa-chevron-right text-xs opacity-30"></i></a>

            <hr class="border-slate-200 dark:border-slate-800">

            <div class="flex items-center justify-between">
                <span class="font-bold text-slate-500">Mode Tampilan</span>
                <button @click="isDarkMode = !isDarkMode"
                    class="w-14 h-8 rounded-full bg-slate-200 dark:bg-slate-800 relative transition-colors">
                    <div :class="isDarkMode ? 'translate-x-7 bg-[#FCEE09]' : 'translate-x-1 bg-white'"
                        class="absolute top-1 w-6 h-6 rounded-full transition-transform duration-300 shadow-sm flex items-center justify-center">
                        <i
                            :class="isDarkMode ? 'fas fa-moon text-[10px] text-[#1C1C1C]' :
                                'fas fa-sun text-[10px] text-[#FCEE09]'"></i>
                    </div>
                </button>
            </div>

            @auth
                <a href="{{ route('dashboard') }}"
                    class="w-full py-5 text-center text-white bg-[#2A246B] font-black rounded-2xl hover:bg-[#1C1C1C] transition-colors shadow-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="w-full py-5 text-center text-white bg-[#2A246B] font-black rounded-2xl hover:bg-[#1C1C1C] transition-colors shadow-md">Login</a>
            @endauth
        </div>
    </div>
</nav>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
