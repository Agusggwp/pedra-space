<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Stok - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        .ph { font-family: 'Phosphor'; }
        .fixed-header { position: fixed; top: 0; left: 0; right: 0; z-index: 50; }
        .main-content { margin-top: 70px; }
        @media (min-width: 768px) { .main-content { margin-top: 0; } }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR (sama persis semua halaman) -->
    <aside id="sidebar"
           class="fixed md:static inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-gray-800 to-gray-900 text-gray-200 p-6 flex flex-col justify-between transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <div>
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-white">POS ADMIN</h2>
                <hr class="border-gray-600 my-4">
                <p class="text-gray-300 text-lg">{{ auth()->user()->name }}</p>
                <p class="text-sm text-yellow-400">{{ ucfirst(auth()->user()->role) }}</p>
            </div>

            <nav class="space-y-3">
                @php $current = request()->path(); @endphp
                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ $current == 'admin/dashboard' ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-house text-2xl"></i> Dashboard
                </a>
                <a href="{{ url('/admin/users') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'users') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-users text-2xl"></i> Manajemen User
                </a>
                <a href="{{ url('/admin/produk') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'produk') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-package text-2xl"></i> Produk
                </a>
                <a href="{{ url('/admin/stok') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'stok') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-bar text-2xl"></i> Manajemen Stok
                </a>
                <a href="{{ url('/admin/void') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'void') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-arrow-counter-clockwise text-2xl"></i> Void
                </a>
                <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'laporan') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-line-up text-2xl"></i> Laporan
                </a>
            </nav>
        </div>

        <form action="{{ url('/logout') }}" method="POST" class="mt-8">
            @csrf
            <button class="flex items-center gap-4 px-5 py-4 rounded-xl w-full text-left text-red-400 hover:bg-red-600 hover:text-white text-lg transition">
                <i class="ph ph-sign-out text-2xl"></i> Logout
            </button>
        </form>
    </aside>

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-40 md:hidden hidden"></div>

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- HEADER HAMBURGER (mobile & tablet) -->
        <header class="fixed-header bg-white shadow-lg px-6 py-4 flex items-center justify-between md:hidden">
            <button id="menuBtn" class="text-3xl text-gray-800 hover:text-blue-600 transition">
                <i class="ph ph-list"></i>
            </button>
            <h1 class="text-xl font-bold text-blue-700">Riwayat Stok</h1>
            <div class="w-10"></div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content flex-1 p-6 md:p-8 lg:p-10">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-clock-counter-clockwise text-6xl md:text-6xl"></i>
                    Riwayat Stok
                </h3>
            </div>

            <!-- Tabel Riwayat -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                            <tr>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Tanggal</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Produk</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Tipe</th>
                                <th class="py-5 px-5 text-center text-sm font-bold uppercase tracking-wider">Jumlah</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">Keterangan</th>
                                <th class="py-5 px-5 text-left text-sm font-bold uppercase tracking-wider">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($histories as $h)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="py-5 px-5 text-gray-700">
                                    {{ $h->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-5 px-5">
                                    <div class="font-semibold text-gray-900">{{ $h->produk->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $h->produk->kode }}</div>
                                </td>
                                <td class="py-5 px-5">
                                    @if($h->tipe == 'masuk')
                                        <span class="inline-block px-5 py-2.5 rounded-full bg-green-600 text-white font-bold shadow">
                                            <i class="ph ph-arrow-down mr-2"></i> Masuk
                                        </span>
                                    @else
                                        <span class="inline-block px-5 py-2.5 rounded-full bg-orange-600 text-white font-bold shadow">
                                            <i class="ph ph-arrow-up mr-2"></i> Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="py-5 px-5 text-center">
                                    <span class="text-xl font-bold text-gray-800">{{ $h->jumlah }}</span>
                                </td>
                                <td class="py-5 px-5 text-gray-600">
                                    {{ $h->keterangan ?: '-' }}
                                </td>
                                <td class="py-5 px-5">
                                    <div class="font-medium text-gray-900">{{ $h->user->name }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-20">
                                    <div class="text-gray-400">
                                        <i class="ph ph-clock-counter-clockwise text-9xl mb-6 opacity-20"></i>
                                        <p class="text-2xl font-medium">Belum ada riwayat stok</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-center">
                        {{ $histories->links() }}
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    });
</script>

</body>
</html>