<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - POS Admin</title>
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
                <a href="{{ url('/admin/void') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ $current == 'admin/void' ? 'bg-red-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-prohibit text-2xl"></i> Void / Refund
                </a>
                <a href="{{ url('/admin/laporan') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'laporan') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-line-up text-2xl"></i> Laporan Penjualan
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
    -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- HEADER HAMBURGER -->
        <header class="fixed-header bg-white shadow-lg px-6 py-4 flex items-center justify-between md:hidden">
            <button id="menuBtn" class="text-3xl text-gray-800 hover:text-blue-600 transition">
                <i class="ph ph-list"></i>
            </button>
            <h1 class="text-xl font-bold text-blue-700">Laporan</h1>
            <div class="w-10"></div>
        </header>

        >

        <!-- MAIN CONTENT -->
        <main class="main-content flex-1 p-6 md:p-8 lg:p-10">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-chart-line-up text-6xl md:text-6xl"></i>
                    Laporan Penjualan
                </h2>
            </div>

            <!-- FILTER CARD -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 mb-8">
                <h4 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2">
                    <i class="ph ph-funnel text-xl"></i> Filter Laporan
                </h4>
                <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Waktu</label>
                        <select name="filter" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition">
                            <option value="">Semua Waktu</option>
                            <option value="hari" {{ request('filter')=='hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="bulan" {{ request('filter')=='bulan' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun" {{ request('filter')=='tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="from" value="{{ request('from') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="to" value="{{ request('to') }}"
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition">
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-2">
                            <i class="ph ph-magnifying-glass text-xl"></i>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- EXPORT BUTTONS -->
            <div class="flex flex-wrap gap-3 mb-6">
                <a href="{{ route('laporan.export.pdf', request()->query()) }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-3.5 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2 font-medium">
                    <i class="ph ph-file-pdf text-xl"></i>
                    Export PDF
                </a>
                <a href="{{ route('laporan.export.excel', request()->query()) }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center gap-2 font-medium">
                    <i class="ph ph-file-xls text-xl"></i>
                    Export Excel
                </a>
            </div>

           <!-- TABEL LAPORAN – RAPI, COMPACT & SEMPURNA DI TABLET (agak mepet sesuai request) -->
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-blue-700 to-blue-900 text-white">
                <tr>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Kode</th>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Kasir</th>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Total</th>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Metode</th>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                    <th class="py-3 px-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 px-3 text-center text-xs font-bold uppercase tracking-wider">Cetak</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksi as $item)
                <tr class="hover:bg-gray-50 transition text-sm">
                    <!-- KODE -->
                    <td class="py-3 px-3">
                        <span class="font-mono font-bold text-gray-800">
                            TRX-{{ str_pad($item->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>

                    <!-- KASIR -->
                    <td class="py-3 px-3 font-medium text-gray-800 truncate max-w-32">
                        {{ $item->kasir->name ?? 'Tidak diketahui' }}
                    </td>

                    <!-- TOTAL -->
                    <td class="py-3 px-3 font-bold text-green-600">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </td>

                    <!-- METODE -->
                    <td class="py-3 px-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">
                            {{ ucfirst($item->metode_pembayaran ?? '-') }}
                        </span>
                    </td>

                    <!-- STATUS -->
                    <td class="py-3 px-3">
                        @if($item->status == 'lunas')
                            <span class="px-3 py-1 rounded-full bg-green-600 text-white text-xs font-bold">Lunas</span>
                        @elseif($item->status == 'void')
                            <span class="px-3 py-1 rounded-full bg-red-600 text-white text-xs font-bold">Void</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-gray-500 text-white text-xs font-bold">Lainnya</span>
                        @endif
                    </td>

                    <!-- TANGGAL -->
                    <td class="py-3 px-3 text-gray-700 text-xs">
                        <div>{{ $item->created_at->format('d/m/Y') }}</div>
                        <div class="text-gray-500">{{ $item->created_at->format('H:i') }}</div>
                    </td>

                    <!-- CETAK -->
                    <td class="py-3 px-3 text-center">
                        <a href="{{ route('kasir.cetak', $item->id) }}" target="_blank"
                           class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg shadow transition inline-flex items-center gap-1.5">
                            <i class="ph ph-printer text-base"></i>
                            Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-16">
                        <div class="text-gray-400">
                            <i class="ph ph-file-text text-8xl mb-4 opacity-20"></i>
                            <p class="text-lg font-medium">Tidak ada data transaksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
</div>

        </main>
    </div>
</div>

<!-- SCRIPT HAMBURGER -->
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