<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Produk - POS Admin</title>
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

            <a href="{{ url('/admin/dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ $current == 'admin/dashboard' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-2 2v7a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-7"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ url('/admin/users') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ $current == 'admin/users' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"/>
                </svg>
                Manajemen User
            </a>

            <a href="{{ url('/admin/produk') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ $current == 'admin/produk' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"/>
                </svg>
                Manajemen Produk
            </a>

            <a href="{{ url('/admin/stok') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ $current == 'admin/stok' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18"/>
                </svg>
                Manajemen Stok
            </a>

            <a href="{{ url('/admin/void') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors duration-200
               {{ $current == 'admin/void' ? 'bg-blue-700 text-white' : 'hover:bg-gray-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5"/>
                </svg>
                Void / Refund
            </a>

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
                class="flex items-center gap-3 px-4 py-3 rounded-lg w-full text-left text-red-400 hover:bg-red-600 hover:text-white transition-colors duration-200">
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
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold text-blue-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6"/>
                </svg>
                Manajemen Produk
            </h3>
            <a href="{{ route('admin.produk.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2">
                Tambah Produk
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Foto</th>
                        <th class="py-3 px-6 text-left">Kode</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Kategori</th>
                        <th class="py-3 px-6 text-left">Harga Jual</th>
                        <th class="py-3 px-6 text-left">Stok</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produks as $p)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6">
                            @if($p->foto)
                                <img src="{{ asset($p->foto) }}" class="w-12 h-12 rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-400 rounded"></div>
                            @endif
                        </td>
                        <td class="py-3 px-6 font-semibold">{{ $p->kode }}</td>
                        <td class="py-3 px-6">{{ $p->nama }}</td>
                        <td class="py-3 px-6">{{ $p->category->nama }}</td>
                        <td class="py-3 px-6">Rp {{ number_format($p->harga_jual) }}</td>
                        <td class="py-3 px-6">
                            <span class="px-2 py-1 rounded {{ $p->stok <= 10 ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                                {{ $p->stok }}
                            </span>
                        </td>
                        <td class="py-3 px-6 flex gap-2">
                            <a href="{{ route('admin.produk.edit', $p) }}" class="px-3 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $p) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Belum ada produk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
