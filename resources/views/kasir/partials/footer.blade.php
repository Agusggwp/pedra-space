<!-- FOOTER KASIR - SEAMLESS WITH SIDEBAR 
<footer class="fixed bottom-0 left-0 right-0 bg-gray-50 py-5 px-6 shadow-2xl z-40">
    <div class="flex flex-col sm:flex-row items-center justify-center gap-8 max-w-7xl mx-auto">
        
   
        <div class="flex items-center gap-3 group cursor-pointer transition-transform hover:scale-105">
            <div class="relative w-10 h-10 bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300 transform group-hover:-translate-y-1">
                <i class="ph-fill ph-cash-register text-white text-xl"></i>
                <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 bg-gradient-to-br from-blue-300 to-transparent blur transition-opacity duration-300"></div>
            </div>
            <div class="text-left">
                <p class="font-bold text-gray-800 text-sm leading-tight">Pedra Kopi</p>
                <p class="text-xs text-blue-600 font-semibold">POS System</p>
            </div>
        </div>

        <div class="hidden sm:flex items-center gap-1">
            <div class="w-px h-8 bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
            <i class="ph ph-dot text-blue-500 text-xs"></i>
            <div class="w-px h-8 bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
        </div>

      
        <div class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-50 to-orange-50 flex items-center justify-center group-hover:shadow-lg transition-all duration-300">
                <i class="ph ph-code text-blue-600 text-lg group-hover:text-red-500 transition-colors"></i>
            </div>
            <div class="text-left">
                <p class="text-xs text-gray-500 font-medium">Built with</p>
                <p class="text-sm text-gray-800 font-semibold">
                    <span class="text-red-500 animate-pulse">❤</span>
                    <a href="https://artdevata.net" target="_blank" class="text-blue-600 hover:text-blue-800 font-bold underline underline-offset-2 hover:underline-offset-4 transition-all duration-300">ArtDevata</a>
                </p>
            </div>
        </div>

    
        <div class="hidden sm:flex items-center gap-1">
            <div class="w-px h-8 bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
            <i class="ph ph-dot text-blue-500 text-xs"></i>
            <div class="w-px h-8 bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
        </div>

        
        <div class="flex items-center gap-2.5 group">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-50 to-emerald-50 flex items-center justify-center group-hover:shadow-lg transition-all duration-300 transform group-hover:scale-110">
                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                    <i class="ph-fill ph-user text-white text-xs"></i>
                </div>
            </div>
            <div class="text-left">
                <p class="text-xs text-gray-500 font-medium">Kasir</p>
                <p class="text-sm text-gray-800 font-bold group-hover:text-green-600 transition-colors">{{ auth()->user()->name }}</p>
            </div>
        </div>

      
        <div class="hidden sm:block w-px h-8 bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>

       
        <div class="px-3 py-1 rounded-full bg-white border border-gray-300 text-xs font-semibold text-gray-700 group hover:shadow-md transition-all duration-300">
            © {{ date('Y') }}
        </div>
    </div>
</footer>


<style>
    body {
        padding-bottom: 100px;
    }
    
    footer {
        animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    footer i {
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
</style>


-->