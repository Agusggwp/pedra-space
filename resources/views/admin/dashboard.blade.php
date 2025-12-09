<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200 w-72 p-6 flex flex-col justify-between">
        <!-- HEADER -->
        <div>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white">POS ADMIN</h2>
                <hr class="border-gray-600 my-3">
                <p class="text-sm text-gray-300">{{ auth()->user()->name }}</p>
                <p class="text-xs text-yellow-400">{{ ucfirst(auth()->user()->role) }}</p>
            </div>

            <!-- NAVIGATION -->
            <nav class="space-y-2">
                @php $current = request()->path(); @endphp

                <!-- Dashboard -->
                <a href="{{ url('/admin/dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/dashboard' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-2 2v7a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-7"/>
                    </svg>
                    Dashboard
                </a>

               

                <!-- Manajemen User -->
                <a href="{{ url('/admin/users') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/users' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/>
                    </svg>
                    Manajemen User
                </a>

                <!-- Manajemen Produk -->
                <a href="{{ url('/admin/produk') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/produk' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"/>
                    </svg>
                    Manajemen Produk
                </a>

                <!-- Manajemen Stok -->
                <a href="{{ url('/admin/stok') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/stok' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/>
                    </svg>
                    Manajemen Stok
                </a>

                <!-- Void / Refund -->
                <a href="{{ url('/admin/void') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/void' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"/>
                    </svg>
                    Void / Refund
                </a>

                <!-- Laporan Penjualan -->
                <a href="{{ url('/admin/laporan') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
                   {{ $current == 'admin/laporan' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/>
                    </svg>
                    Laporan Penjualan
                </a>
            </nav>
        </div>

        <!-- LOGOUT -->
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="flex items-center gap-3 px-4 py-3 rounded-lg w-full text-left text-red-400 
                    hover:bg-red-600 hover:text-white transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/>
                </svg>
                Logout
            </button>
        </form>
    </aside>

    <!-- KONTEN -->
    <main class="flex-1 p-8">
        <h2 class="text-3xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            Dashboard Utama
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- CARD -->
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h4 class="mt-2 text-lg font-semibold">Penjualan Hari Ini</h4>
                <p class="text-2xl font-bold text-green-600">
                    Rp {{ number_format($penjualanHariIni) }}
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h4 class="mt-2 text-lg font-semibold">Transaksi Hari Ini</h4>
                <p class="text-2xl font-bold text-blue-600">{{ $transaksiHariIni }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h4 class="mt-2 text-lg font-semibold">Stok Kritis (≤ 10)</h4>
                <p class="text-2xl font-bold text-yellow-600">{{ $stokKritis }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h4 class="mt-2 text-lg font-semibold">Kasir Aktif</h4>
                <p class="text-2xl font-bold text-purple-600">{{ $kasirAktif }}</p>
            </div>
        </div>

        <div class="mt-10 bg-blue-100 border border-blue-300 text-blue-800 p-4 rounded-lg">
            Gunakan menu di sidebar untuk mengelola sistem POS.
        </div>
    </main>
</div>

</body>
</html>
