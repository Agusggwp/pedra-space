<!-- TOPBAR COMPONENT -->
<header class="fixed top-0 right-0 left-0 md:left-64 z-30 bg-white border-b border-gray-200 px-6 py-3 shadow-sm">
    <div class="flex items-center justify-between">
        <!-- Left: Hamburger Menu (Mobile) + Search -->
        <div class="flex items-center gap-4 flex-1">
            <!-- Hamburger Button -->
            <button id="menuBtn" class="md:hidden text-gray-600 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" x2="20" y1="12" y2="12"/>
                    <line x1="4" x2="20" y1="6" y2="6"/>
                    <line x1="4" x2="20" y1="18" y2="18"/>
                </svg>
            </button>

            <!-- Search Bar -->
            <div class="hidden sm:flex items-center bg-gray-100 rounded-lg px-4 py-2 w-full max-w-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" placeholder="Search products..." class="bg-transparent border-0 outline-none ml-3 text-sm text-gray-700 placeholder-gray-400 w-full">
            </div>
        </div>

        <!-- Right: Role Badge + Notification + Profile -->
        <div class="flex items-center gap-4">
            <!-- Role Badge -->
            <div class="hidden md:flex items-center gap-2 bg-green-100 text-green-700 px-3 py-1.5 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 16v-4"/>
                    <path d="M12 8h.01"/>
                </svg>
                <span class="text-sm font-medium">{{ ucfirst(auth()->user()->role) }}</span>
            </div>

            <!-- Notification Bell -->
            <!-- <button class="relative text-gray-600 hover:text-gray-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/>
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>
                </svg>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button> -->

            <!-- Profile -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="hidden lg:block">
                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</header>
