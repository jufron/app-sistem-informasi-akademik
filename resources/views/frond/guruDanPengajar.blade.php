<x-frond.layout.app title="SD Katolik Weetabula - Masa Depan Cerah Dimulai Di Sini"
    metaDescription="Website resmi SD Katolik Weetabula. Pendidikan dasar unggulan dengan konsep modern, berkarakter, dan inovatif.">
    <x-frond.navbar />

    <!-- Guru & Staf Carousel Section (Portrait Premium Glass Card - Clickable) -->
    <section
        class="relative py-24 lg:py-32 w-full overflow-hidden bg-slate-50 dark:bg-slate-950 transition-colors duration-700"
        x-data="{
            autoplayInterval: null,
            staffList: [
                { name: 'Antonius Budi, S.Pd', role: 'Wali Kelas 6', subject: 'Matematika & IPA', status: 'Guru Tetap', image: 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?q=80&w=800&h=1000&auto=format&fit=crop' },
                { name: 'Maria Yosefina, S.Pd', role: 'Guru Bahasa Inggris', subject: 'Bahasa Asing', status: 'Guru Tetap', image: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&h=1000&auto=format&fit=crop' },
                { name: 'Yohanes Don Bosco', role: 'Guru Agama', subject: 'Pend. Agama Katolik', status: 'Guru Tetap', image: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=800&h=1000&auto=format&fit=crop' },
                { name: 'Fransiska N., S.Kom', role: 'Guru TIK', subject: 'Komputer', status: 'Tenaga Honorer', image: 'https://images.unsplash.com/photo-1531123897727-8f129e1b4eca?q=80&w=800&h=1000&auto=format&fit=crop' },
                { name: 'Agustinus D.', role: 'Guru Penjaskes', subject: 'Olahraga', status: 'Guru Tetap', image: 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=800&h=1000&auto=format&fit=crop' },
                { name: 'Theresia Lende', role: 'Staf Perpustakaan', subject: 'Administrasi', status: 'Staf', image: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=800&h=1000&auto=format&fit=crop' }
            ],
            startAutoplay() {
                this.autoplayInterval = setInterval(() => { this.next() }, 3000);
            },
            stopAutoplay() {
                clearInterval(this.autoplayInterval);
            },
            next() {
                let slider = this.$refs.slider;
                let cardWidth = slider.firstElementChild.offsetWidth + 24;
                if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 10) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                    slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
                }
            },
            prev() {
                let slider = this.$refs.slider;
                let cardWidth = slider.firstElementChild.offsetWidth + 24;
                slider.scrollBy({ left: -cardWidth, behavior: 'smooth' });
            }
        }" x-init="startAutoplay()">

        <!-- Abstract Vibrant Background Blobs -->
        <div
            class="absolute inset-0 w-full h-full overflow-hidden z-0 pointer-events-none flex justify-center items-center">
            <div
                class="absolute top-[20%] left-[-5%] w-[400px] h-[400px] rounded-full bg-gradient-to-tr from-cyan-400/40 to-blue-500/30 dark:from-cyan-600/20 dark:to-blue-800/20 blur-[100px] animate-pulse">
            </div>
            <div
                class="absolute bottom-[10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-gradient-to-bl from-indigo-400/30 to-purple-500/30 dark:from-indigo-600/10 dark:to-purple-800/10 blur-[120px]">
            </div>
        </div>

        <div class="w-full relative z-10">

            <!-- Header Section -->
            <div
                class="max-w-7xl mx-auto px-6 lg:px-12 mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-xl">
                    <div class="inline-flex items-center space-x-2 mb-4">
                        <span class="w-8 h-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full"></span>
                        <span class="text-sm font-bold uppercase tracking-widest text-cyan-600 dark:text-cyan-400">Tim
                            Pengajar</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-800 dark:text-white tracking-tight">
                        Guru & <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400">Staf
                            Kami</span>
                    </h2>
                </div>

                <!-- Manual Navigation Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <button @click="prev(); stopAutoplay(); startAutoplay();"
                        class="w-14 h-14 rounded-full bg-white/40 dark:bg-slate-800/50 backdrop-blur-md border border-white/60 dark:border-white/10 flex items-center justify-center text-slate-800 dark:text-white hover:bg-white/60 dark:hover:bg-slate-700/50 transition-all shadow-lg hover:scale-105 active:scale-95">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button @click="next(); stopAutoplay(); startAutoplay();"
                        class="w-14 h-14 rounded-full bg-cyan-600/90 dark:bg-cyan-500/90 backdrop-blur-md border border-cyan-400/50 flex items-center justify-center text-white hover:bg-cyan-700 transition-all shadow-lg hover:scale-105 active:scale-95">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Slider Container -->
            <div class="w-full pl-6 lg:pl-12 pr-6 lg:pr-12" @mouseenter="stopAutoplay()" @mouseleave="startAutoplay()"
                @touchstart="stopAutoplay()" @touchend="startAutoplay()">

                <div x-ref="slider"
                    class="flex gap-6 overflow-x-auto snap-x snap-mandatory no-scrollbar scroll-smooth pb-12 pt-4">

                    <template x-for="(person, index) in staffList" :key="index">

                        <!-- REVISI DI SINI: Tag <div> diganti jadi <a>, dan class ditambah 'block' -->
                        <a href="{{ route('frond.guru-dan-staf.show') }}"
                            class="block snap-start snap-always flex-none w-[75vw] sm:w-[280px] md:w-[320px] aspect-[4/5] relative group cursor-pointer rounded-[2.5rem] overflow-hidden shadow-[0_15px_40px_rgba(0,0,0,0.08)]">

                            <!-- Full Background Image -->
                            <img :src="person.image" :alt="person.name"
                                class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000 ease-out">

                            <!-- Dark Gradient Overlay (Agar text di atasnya selalu terbaca) -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500">
                            </div>

                            <!-- Floating Glass Panel (Muncul dari bawah) -->
                            <div
                                class="absolute inset-x-4 bottom-4 p-5 md:p-6 rounded-[1.5rem] md:rounded-[2rem] bg-white/20 dark:bg-slate-900/40 backdrop-blur-xl border border-white/40 dark:border-white/10 transform translate-y-3 group-hover:translate-y-0 transition-all duration-500 shadow-xl">

                                <div class="flex flex-col">
                                    <!-- Subject Badge -->
                                    <span
                                        class="text-[10px] md:text-xs font-black text-cyan-400 uppercase tracking-widest mb-1.5"
                                        x-text="person.subject"></span>

                                    <!-- Name -->
                                    <h3 class="text-xl md:text-2xl font-extrabold text-white leading-tight mb-1"
                                        x-text="person.name"></h3>

                                    <!-- Role -->
                                    <p class="text-sm font-medium text-slate-300" x-text="person.role"></p>
                                </div>

                                <!-- Hidden Hover Content (Akan muncul saat di hover/disentuh) -->
                                <div
                                    class="grid grid-rows-[0fr] group-hover:grid-rows-[1fr] transition-all duration-500 ease-in-out">
                                    <div class="overflow-hidden">
                                        <div
                                            class="mt-4 pt-4 border-t border-white/20 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                            <div class="flex items-center space-x-2">
                                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                                <span class="text-xs text-white font-medium"
                                                    x-text="person.status"></span>
                                            </div>
                                            <!-- Tombol Aksi (Panah) -->
                                            <div
                                                class="w-8 h-8 rounded-full bg-cyan-500/80 backdrop-blur-sm flex items-center justify-center text-white border border-cyan-400/50">
                                                <i
                                                    class="fas fa-arrow-right text-xs transform -rotate-45 group-hover:rotate-0 transition-transform duration-500"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Glossy Top Edge Reflection (Untuk seluruh kartu) -->
                            <div
                                class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/60 to-transparent z-20 pointer-events-none">
                            </div>
                        </a>

                    </template>

                </div>
            </div>

        </div>
    </section>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    <x-frond.footer />
</x-frond.layout.app>
