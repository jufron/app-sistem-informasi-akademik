<!-- Floating Action Buttons (Liquid Glass) - Bebas Bug Space -->
<div class="fixed bottom-12 right-6 md:bottom-8 md:right-8 flex flex-col items-end gap-4 z-[9999]"
     x-data="{ scrolled: false }" 
     @scroll.window="scrolled = window.scrollY > 500">
    
    <!-- 1. Scroll to Top Button (Muncul di atas WA) -->
    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
            x-show="scrolled"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-10 scale-50"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-10 scale-50"
            aria-label="Kembali ke Atas"
            x-cloak
            class="relative group flex items-center justify-center w-12 h-12 md:w-14 md:h-14 rounded-full bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-white/50 dark:hover:bg-slate-800/60 transition-all duration-300 hover:-translate-y-1">
        
        <!-- Icon -->
        <i class="fas fa-arrow-up text-lg text-indigo-600 dark:text-indigo-400 relative z-10 group-hover:animate-bounce"></i>

        <!-- Tooltip Glass -->
        <div class="absolute right-full mr-4 px-3 py-1.5 rounded-lg bg-white/40 dark:bg-slate-800/50 backdrop-blur-xl border border-white/50 dark:border-white/10 text-xs font-bold text-slate-700 dark:text-white opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-300 whitespace-nowrap shadow-lg pointer-events-none">
            Ke Atas
        </div>

    </button>

    <!-- 2. WhatsApp Button (Selalu di paling bawah) -->
    <a href="https://wa.me/6281234567890" target="_blank" aria-label="Chat WhatsApp"
       class="relative group flex items-center justify-center w-14 h-14 md:w-16 md:h-16 rounded-[1.2rem] md:rounded-[1.5rem] bg-white/30 dark:bg-slate-800/40 backdrop-blur-2xl border border-white/50 dark:border-white/10 shadow-[0_8px_30px_rgba(0,0,0,0.1)] hover:bg-white/50 dark:hover:bg-slate-800/60 transition-all duration-300 hover:-translate-y-1">
        
        <!-- Emerald Glow Behind Glass -->
        <div class="absolute inset-0 rounded-[1.2rem] md:rounded-[1.5rem] bg-emerald-500/20 blur-md group-hover:bg-emerald-500/40 transition-colors duration-500"></div>
        
        <!-- Ping Animation (Outer Ring) -->
        <div class="absolute inset-0 rounded-[1.2rem] md:rounded-[1.5rem] border border-emerald-400/50 animate-ping opacity-20"></div>

        <!-- WA Icon -->
        <i class="fab fa-whatsapp text-3xl text-emerald-600 dark:text-emerald-400 relative z-10 transform group-hover:scale-110 transition-transform duration-300"></i>

        <!-- Tooltip Glass -->
        <div class="absolute right-full mr-4 px-4 py-2 rounded-xl bg-white/40 dark:bg-slate-800/50 backdrop-blur-xl border border-white/50 dark:border-white/10 text-sm font-bold text-slate-700 dark:text-white opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-300 whitespace-nowrap shadow-lg pointer-events-none flex items-center">
            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
            Tanya Kami
        </div>
        
    </a>

</div>