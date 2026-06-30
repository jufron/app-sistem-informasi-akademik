<x-frond.layout.app title="SD Katolik Weetabula - Masa Depan Cerah Dimulai Di Sini"
    metaDescription="Website resmi SD Katolik Weetabula. Pendidikan dasar unggulan dengan konsep modern, berkarakter, dan inovatif.">
    <x-frond.layout.navbar />

    <!-- Kontak & Lokasi Section (Liquid Glass Bento Style) -->
    <section
        class="relative py-24 lg:py-32 w-full overflow-hidden bg-slate-100 dark:bg-slate-900 transition-colors duration-700">

        <!-- Abstract Vibrant Background Blobs -->
        <div
            class="absolute inset-0 w-full h-full overflow-hidden z-0 pointer-events-none flex justify-center items-center">
            <!-- Navy Blue Blob -->
            <div
                class="absolute top-[20%] left-[10%] w-[400px] h-[400px] rounded-full bg-gradient-to-br from-[#2A246B]/40 to-[#FCEE09]/20 dark:from-[#2A246B]/30 dark:to-[#FCEE09]/10 blur-[100px] animate-pulse">
            </div>
            <!-- Yellow Blob -->
            <div
                class="absolute bottom-[10%] right-[5%] w-[500px] h-[500px] rounded-full bg-gradient-to-tl from-[#FCEE09]/30 to-[#2A246B]/30 dark:from-[#FCEE09]/10 dark:to-[#2A246B]/20 blur-[120px]">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">

            <!-- Header Section -->
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="inline-flex items-center justify-center space-x-2 mb-4">
                    <span class="w-8 h-1 bg-gradient-to-r from-[#2A246B] to-[#FCEE09] rounded-full"></span>
                    <span
                        class="text-sm font-bold uppercase tracking-widest text-[#2A246B] dark:text-[#FCEE09]">Informasi
                        Kontak</span>
                    <span class="w-8 h-1 bg-gradient-to-r from-[#FCEE09] to-[#2A246B] rounded-full"></span>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-[#1C1C1C] dark:text-white tracking-tight mb-4">
                    Hubungi <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#2A246B] to-blue-800 dark:from-[#FCEE09] dark:to-yellow-200">Kami</span>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-300">
                    Pintu kami selalu terbuka. Jangan ragu untuk menghubungi kami terkait pendaftaran, informasi
                    sekolah, atau kerja sama.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

                <!-- LEFT COLUMN: Contact Info Grid (Takes 5 columns) -->
                <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6">

                    <!-- Card 1: Alamat -->
                    <div class="relative group rounded-[2rem] overflow-hidden w-full h-full">
                        <div
                            class="absolute inset-0 bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(42,36,107,0.04)] transition-colors duration-500 group-hover:bg-white/50 dark:group-hover:bg-slate-800/60 z-10">
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
                        </div>

                        <div class="relative z-20 p-6 sm:p-8 flex items-start space-x-5">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#2A246B] to-[#1C1C1C] flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-map-marker-alt text-[#FCEE09] text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1C1C1C] dark:text-white text-lg mb-1">Alamat Sekolah</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                                    {{ $kontak['alamat'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Telepon -->
                    <div class="relative group rounded-[2rem] overflow-hidden w-full h-full">
                        <div
                            class="absolute inset-0 bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(42,36,107,0.04)] transition-colors duration-500 group-hover:bg-white/50 dark:group-hover:bg-slate-800/60 z-10">
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
                        </div>

                        <div class="relative z-20 p-6 sm:p-8 flex items-start space-x-5">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#FCEE09] to-yellow-500 flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-phone-alt text-[#2A246B] text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1C1C1C] dark:text-white text-lg mb-1">Telepon & WhatsApp</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-medium mb-1">
                                    Telp: {{ $kontak['telepon'] }}
                                </p>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-medium mb-1">
                                    WA: {{ $kontak['whatsapp'] }}
                                </p>
                                <span
                                    class="inline-block px-3 py-1 bg-[#FCEE09]/20 dark:bg-[#FCEE09]/10 text-[#2A246B] dark:text-[#FCEE09] text-xs font-bold rounded-full border border-[#FCEE09]/30">Respon Cepat</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Email -->
                    <div class="relative group rounded-[2rem] overflow-hidden w-full h-full">
                        <div
                            class="absolute inset-0 bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(42,36,107,0.04)] transition-colors duration-500 group-hover:bg-white/50 dark:group-hover:bg-slate-800/60 z-10">
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
                        </div>

                        <div class="relative z-20 p-6 sm:p-8 flex items-start space-x-5">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#2A246B] to-[#1C1C1C] flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-envelope-open-text text-[#FCEE09] text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1C1C1C] dark:text-white text-lg mb-1">Email Resmi</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-medium break-all">
                                    {{ $kontak['email'] }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Jam Operasional -->
                    <div class="relative group rounded-[2rem] overflow-hidden w-full h-full">
                        <div
                            class="absolute inset-0 bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(42,36,107,0.04)] transition-colors duration-500 group-hover:bg-white/50 dark:group-hover:bg-slate-800/60 z-10">
                        </div>
                        <div
                            class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/80 to-transparent z-20 pointer-events-none">
                        </div>

                        <div class="relative z-20 p-6 sm:p-8 flex items-start space-x-5">
                            <div
                                class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#FCEE09] to-yellow-500 flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-clock text-[#2A246B] text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-[#1C1C1C] dark:text-white text-lg mb-1">Jam Operasional</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-medium">Senin - Jumat: 07.00
                                    -
                                    14.00 WITA</p>
                                <p class="text-sm text-slate-600 dark:text-slate-300 font-medium">Sabtu: 07.00 - 12.00
                                    WITA</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: Google Maps Glass Container (Takes 7 columns) -->
                <div
                    class="lg:col-span-7 relative w-full h-[400px] sm:h-[500px] lg:h-full min-h-[400px] group rounded-[2.5rem] lg:rounded-[3rem] overflow-hidden">

                    <!-- Pure Liquid Glass Layer (Background/Border for the map) -->
                    <div
                        class="absolute inset-0 bg-white/30 dark:bg-slate-800/40 backdrop-blur-3xl border border-white/60 dark:border-white/10 shadow-[0_20px_50px_rgba(42,36,107,0.07)] z-10 pointer-events-none">
                    </div>
                    <!-- Glossy Top Edge Reflection -->
                    <div
                        class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/90 to-transparent z-30 pointer-events-none">
                    </div>

                    <!-- Google Maps Iframe Container -->
                    <!-- Note: Padding (p-3) here makes the map look like it's inside a glass tablet/frame -->
                    <div class="relative z-20 p-3 lg:p-4 w-full h-full flex flex-col">

                        <!-- Decorative Frame Header (Mac OS style dots - dipertahankan karena bagian dari UI/UX desain frame tablet) -->
                        <div class="flex items-center space-x-2 mb-3 px-2">
                            <div class="w-3 h-3 rounded-full bg-rose-500 border border-rose-600/50"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500 border border-amber-600/50"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500 border border-emerald-600/50"></div>
                            <span
                                class="ml-2 text-xs font-bold text-slate-500 dark:text-slate-400 tracking-wider">LOKASI
                                KAMI</span>
                        </div>

                        <!-- Map Iframe -->
                        <div
                            class="flex-1 w-full rounded-[1.5rem] lg:rounded-[2rem] overflow-hidden shadow-inner relative border border-slate-200/50 dark:border-slate-700/50">
                            <!-- Menggunakan URL embed pencarian Google Maps untuk SD Katolik Weetabula -->
                            <iframe
                                src="https://maps.google.com/maps?q=SD%20Katolik%20Weetabula,%20Sumba&t=&z=16&ie=UTF8&iwloc=&output=embed"
                                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                class="absolute inset-0 w-full h-full filter dark:invert-[90%] dark:hue-rotate-180 transition-all duration-700">
                            </iframe>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <x-frond.layout.footer />
</x-frond.layout.app>
