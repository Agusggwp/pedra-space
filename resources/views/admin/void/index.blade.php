<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Void / Refund - POS Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">

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
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-red-600 mb-6 flex items-center gap-2">
            Void / Batalkan Transaksi
        </h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Kasir</th>
                        <th class="py-3 px-6 text-left">Total</th>
                        <th class="py-3 px-6 text-left">Metode</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $t)
                    <tr class="{{ $t->status === 'void' ? 'bg-gray-200' : '' }} border-b hover:bg-gray-100">
                        <td class="py-3 px-6 font-semibold">#{{ $t->id }}</td>
                        <td class="py-3 px-6">{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-6">{{ $t->user->name }}</td>
                        <td class="py-3 px-6">Rp {{ number_format($t->total) }}</td>
                        <td class="py-3 px-6">{{ $t->metode_pembayaran }}</td>
                        <td class="py-3 px-6">
                            @if($t->status === 'void')
                                <span class="px-2 py-1 rounded bg-gray-400 text-white">Dibatalkan</span>
                            @else
                                <span class="px-2 py-1 rounded bg-green-500 text-white">Lunas</span>
                            @endif
                        </td>
                        <td class="py-3 px-6">
                            @if($t->status !== 'void')
                                <button onclick="document.getElementById('modal-{{ $t->id }}').classList.remove('hidden')"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Void
                                </button>
                            @else
                                <small class="text-gray-600">Dibatalkan oleh {{ $t->voidBy?->name ?? '-' }}</small>
                            @endif
                        </td>
                    </tr>

                    <!-- Modal Void -->
                    <div id="modal-{{ $t->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                        <div class="bg-white rounded-lg w-96 p-6 relative">
                            <h3 class="text-lg font-bold text-red-600 mb-4">Konfirmasi Pembatalan Transaksi</h3>
                            <p>Yakin ingin <strong>membatalkan</strong> transaksi ini?</p>
                            <p>Total: <strong>Rp {{ number_format($t->total) }}</strong></p>
                            <form action="{{ route('admin.void.proses', $t) }}" method="POST" class="mt-4">
                                @csrf
                                <textarea name="keterangan" required class="w-full border rounded p-2 mb-4" rows="3"
                                          placeholder="Contoh: Customer batal, salah input, barang rusak, dll"></textarea>
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="document.getElementById('modal-{{ $t->id }}').classList.add('hidden')"
                                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Batal</button>
                                    <button type="submit" class="px-4 py-2 rounded bg-red-500 text-white hover:bg-red-600">Ya, Batalkan!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-gray-500">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</main>

</body>
</html>
