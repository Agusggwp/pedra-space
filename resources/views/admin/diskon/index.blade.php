<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Diskon - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">

            <!-- Judul Halaman -->
            <div class="mb-8 mt-20">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="20.5" cy="6.5" r="1.5"/>
                        <circle cx="3.5" cy="17.5" r="1.5"/>
                        <path d="M3 6.5h15m-13 11h13"/>
                    </svg>
                    Set Diskon
                </h2>
                <p class="text-gray-600 mt-2">Kelola diskon untuk transaksi penjualan</p>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span class="text-lg">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" x2="9" y1="9" y2="15"/>
                        <line x1="9" x2="15" y1="9" y2="15"/>
                    </svg>
                    <span class="text-lg">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Card Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card: Diskon Produk -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Diskon Produk</h3>
                            <p class="text-sm text-gray-500">Atur diskon per produk</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500">
                            <path d="M16 16h3a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3"/>
                            <path d="M8 16H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/>
                            <path d="M12 3v18"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Tentukan diskon untuk setiap produk yang dijual</p>
                    <a href="{{ route('admin.diskon.produk') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition-colors">
                        <span>Kelola</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" x2="19" y1="12" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

                <!-- Card: Diskon Menu -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Diskon Menu</h3>
                            <p class="text-sm text-gray-500">Atur diskon per menu item</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500">
                            <path d="M4 7h16"/>
                            <path d="M4 12h16"/>
                            <path d="M4 17h16"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Terapkan diskon untuk item menu spesifik</p>
                    <a href="{{ route('admin.diskon.menu') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg font-medium transition-colors">
                        <span>Kelola</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" x2="19" y1="12" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

                <!-- Card: Diskon Kategori -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Diskon Kategori</h3>
                            <p class="text-sm text-gray-500">Atur diskon per kategori</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-purple-500">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            <path d="M7 12a5 5 0 1 0 10 0 5 5 0 0 0-10 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Terapkan diskon otomatis untuk seluruh kategori</p>
                    <a href="{{ route('admin.diskon.kategori') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-colors">
                        <span>Kelola</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" x2="19" y1="12" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

                <!-- Card: Diskon Umum -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Diskon Umum</h3>
                            <p class="text-sm text-gray-500">Diskon untuk transaksi tertentu</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                            <path d="M8 12h8m-4-4v8"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Atur diskon umum untuk semua transaksi</p>
                    <a href="{{ route('admin.diskon.umum') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                        <span>Kelola</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" x2="19" y1="12" y2="12"/>
                            <polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </a>
                </div>

            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mt-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" x2="12" y1="16" y2="12"/>
                            <line x1="12" x2="12.01" y1="8" y2="8"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-blue-900 mb-2">Informasi Diskon</h4>
                        <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                            <li>Diskon Produk: Didefinisikan per item produk individual</li>
                            <li>Diskon Menu: Didefinisikan per item menu khusus</li>
                            <li>Diskon Kategori: Berlaku untuk semua produk dalam kategori tersebut</li>
                            <li>Diskon Umum: Diskon tambahan yang dapat diterapkan saat transaksi</li>
                        </ul>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

</body>
</html>
