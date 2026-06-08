<footer class="relative overflow-hidden bg-slate-100 dark:bg-slate-950 transition-colors duration-700">

    <div
        class="absolute bottom-0 left-0 w-full h-[300px] overflow-hidden z-0 pointer-events-none flex justify-between items-end">
        <div
            class="w-[400px] h-[400px] rounded-full bg-gradient-to-tr from-[#2A246B]/30 to-[#FCEE09]/20 dark:from-[#2A246B]/20 dark:to-[#FCEE09]/10 blur-[100px] transform -translate-x-1/2 translate-y-1/2">
        </div>
        <div
            class="w-[500px] h-[500px] rounded-full bg-gradient-to-bl from-[#FCEE09]/30 to-[#2A246B]/20 dark:from-[#FCEE09]/10 dark:to-[#2A246B]/20 blur-[120px] transform translate-x-1/3 translate-y-1/3 animate-pulse">
        </div>
    </div>

    <div
        class="relative z-10 bg-white/40 dark:bg-slate-900/50 backdrop-blur-3xl border-t border-white/60 dark:border-white/10 shadow-[0_-10px_40px_rgba(42,36,107,0.03)]">

        <div
            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 pt-16 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">

                <div class="lg:col-span-1 flex flex-col space-y-6">
                    <div class="flex items-center space-x-3 group cursor-pointer">
                        <div
                            class="w-12 h-12 flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('img/logo-bg.png') }}" alt="Logo SD Katolik Weetabula"
                                class="w-full h-full object-contain drop-shadow-md" loading="lazy" />
                        </div>
                        <span class="text-2xl font-extrabold tracking-tight text-[#1C1C1C] dark:text-white uppercase">
                            SD Katolik <br><span class="text-[#2A246B] dark:text-[#FCEE09] text-lg">Weetabula</span>
                        </span>
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                        Membentuk generasi cerdas, berkarakter, dan beriman teguh dalam semangat pelayanan kasih di
                        jantung kota Weetabula.
                    </p>
                </div>

                <div class="flex flex-col space-y-6">
                    <h4 class="text-lg font-bold text-[#1C1C1C] dark:text-white relative inline-block">
                        Tautan Cepat
                        <span
                            class="absolute -bottom-2 left-0 w-8 h-1 bg-[#2A246B] dark:bg-[#FCEE09] rounded-full"></span>
                    </h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('frond.home') }}"
                                class="text-slate-600 dark:text-slate-400 hover:text-[#2A246B] dark:hover:text-[#FCEE09] font-medium transition-colors flex items-center group"><i
                                    class="fas fa-chevron-right text-[10px] mr-2 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                Beranda</a></li>
                        <li><a href="{{ route('frond.tentang') }}"
                                class="text-slate-600 dark:text-slate-400 hover:text-[#2A246B] dark:hover:text-[#FCEE09] font-medium transition-colors flex items-center group"><i
                                    class="fas fa-chevron-right text-[10px] mr-2 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                Tentang</a></li>
                        <li><a href="{{ route('frond.guru-dan-staf') }}"
                                class="text-slate-600 dark:text-slate-400 hover:text-[#2A246B] dark:hover:text-[#FCEE09] font-medium transition-colors flex items-center group"><i
                                    class="fas fa-chevron-right text-[10px] mr-2 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                Guru & Staf</a></li>
                        <li><a href="{{ route('frond.kontak') }}"
                                class="text-slate-600 dark:text-slate-400 hover:text-[#2A246B] dark:hover:text-[#FCEE09] font-medium transition-colors flex items-center group"><i
                                    class="fas fa-chevron-right text-[10px] mr-2 opacity-0 group-hover:opacity-100 transform -translate-x-2 group-hover:translate-x-0 transition-all"></i>
                                Kontak</a></li>
                    </ul>
                </div>

                <div class="flex flex-col space-y-6">
                    <h4 class="text-lg font-bold text-[#1C1C1C] dark:text-white relative inline-block">
                        Hubungi Kami
                        <span
                            class="absolute -bottom-2 left-0 w-8 h-1 bg-[#2A246B] dark:bg-[#FCEE09] rounded-full"></span>
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3 text-slate-600 dark:text-slate-400">
                            <i class="fas fa-map-marker-alt mt-1.5 text-[#2A246B] dark:text-[#FCEE09]"></i>
                            <span class="font-medium text-sm leading-relaxed">Jl. Pendidikan No. 123, Weetabula, Sumba
                                Barat Daya, NTT</span>
                        </li>
                        <li class="flex items-center space-x-3 text-slate-600 dark:text-slate-400">
                            <i class="fas fa-phone-alt text-[#2A246B] dark:text-[#FCEE09]"></i>
                            <span class="font-medium text-sm">+62 812 3456 7890</span>
                        </li>
                        <li class="flex items-center space-x-3 text-slate-600 dark:text-slate-400">
                            <i class="fas fa-envelope text-[#2A246B] dark:text-[#FCEE09]"></i>
                            <span class="font-medium text-sm">info@sdkatolikweetabula.sch.id</span>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col space-y-6">
                    <h4 class="text-lg font-bold text-[#1C1C1C] dark:text-white relative inline-block">
                        Ikuti Kami
                        <span
                            class="absolute -bottom-2 left-0 w-8 h-1 bg-[#2A246B] dark:bg-[#FCEE09] rounded-full"></span>
                    </h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Dapatkan informasi terbaru seputar
                        kegiatan dan prestasi sekolah.</p>

                    <div class="flex items-center space-x-3">
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border border-white/50 dark:border-slate-700 flex items-center justify-center text-[#2A246B] dark:text-slate-400 hover:bg-[#2A246B] hover:text-white hover:border-[#2A246B] dark:hover:bg-[#FCEE09] dark:hover:text-[#1C1C1C] transition-all transform hover:-translate-y-1 shadow-sm">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border border-white/50 dark:border-slate-700 flex items-center justify-center text-[#2A246B] dark:text-slate-400 hover:bg-[#2A246B] hover:text-white hover:border-[#2A246B] dark:hover:bg-[#FCEE09] dark:hover:text-[#1C1C1C] transition-all transform hover:-translate-y-1 shadow-sm">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-full bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border border-white/50 dark:border-slate-700 flex items-center justify-center text-[#2A246B] dark:text-slate-400 hover:bg-[#2A246B] hover:text-white hover:border-[#2A246B] dark:hover:bg-[#FCEE09] dark:hover:text-[#1C1C1C] transition-all transform hover:-translate-y-1 shadow-sm">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

            </div>

            <div
                class="border-t border-slate-300 dark:border-slate-700/50 pt-8 flex flex-col md:flex-row items-center justify-between text-center md:text-left">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mb-4 md:mb-0">
                    &copy; 2026 SD Katolik Weetabula. All rights reserved.
                </p>
                <div class="flex space-x-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                    <a href="#" class="hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors">Kebijakan
                        Privasi</a>
                    <a href="#" class="hover:text-[#2A246B] dark:hover:text-[#FCEE09] transition-colors">Syarat
                        & Ketentuan</a>
                </div>
            </div>

        </div>
    </div>
</footer>
