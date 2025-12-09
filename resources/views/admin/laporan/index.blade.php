<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Penjualan - Admin POS</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-100 min-h-screen">

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
<!-- MAIN CONTENT -->
<main class="flex-1 p-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
    </h2>

    <!-- FILTER -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block mb-1 font-medium">Filter Waktu</label>
                <select name="filter" class="w-full border rounded p-2">
                    <option value="">Semua</option>
                    <option value="hari" {{ request('filter')=='hari'?'selected':'' }}>Hari Ini</option>
                    <option value="bulan" {{ request('filter')=='bulan'?'selected':'' }}>Bulan Ini</option>
                    <option value="tahun" {{ request('filter')=='tahun'?'selected':'' }}>Tahun Ini</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-medium">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" class="w-full border rounded p-2">
            </div>
            <div>
                <label class="block mb-1 font-medium">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" class="w-full border rounded p-2">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white rounded p-2 hover:bg-blue-700">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- EXPORT -->
    <div class="flex gap-2 mb-4">
        <a href="{{ route('laporan.export.pdf', request()->query()) }}" 
           class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
           Export PDF
        </a>
        <a href="{{ route('laporan.export.excel', request()->query()) }}" 
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
           Export Excel
        </a>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Kode Transaksi</th>
                    <th class="px-4 py-2 text-left">Nama Kasir</th>
                    <th class="px-4 py-2 text-left">Total (Rp)</th>
                    <th class="px-4 py-2 text-left">Metode Pembayaran</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $item)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2">{{ 'TRX-' . str_pad($item->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-2">{{ $item->kasir->name ?? 'Tidak diketahui' }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($item->total,0,',','.') }}</td>
                    <td class="px-4 py-2">{{ ucfirst($item->metode_pembayaran ?? '-') }}</td>
                    <td class="px-4 py-2">
                        @if($item->status=='lunas')
                            <span class="px-2 py-1 rounded bg-green-500 text-white">Lunas</span>
                        @elseif($item->status=='void')
                            <span class="px-2 py-1 rounded bg-red-500 text-white">Void</span>
                        @else
                            <span class="px-2 py-1 rounded bg-gray-400 text-white">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('kasir.cetak', $item->id) }}" target="_blank"
                           class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">
                           Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</main>

</body>
</html>
