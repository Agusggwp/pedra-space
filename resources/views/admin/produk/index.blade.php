<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS Admin</title>
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

    <!-- SIDEBAR -->
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
                    <i class="ph ph-package text-2xl"></i> Manajemen Produk
                </a>
                <a href="{{ url('/admin/stok') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-lg {{ str_contains($current,'stok') ? 'bg-blue-700 text-white shadow-lg' : 'hover:bg-gray-700' }} transition">
                    <i class="ph ph-chart-bar text-2xl"></i> Stok
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
            <h1 class="text-xl font-bold text-blue-700">Produk</h1>
            <div class="w-10"></div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content flex-1 p-4 md:p-8 lg:p-10">

            <!-- Judul + Tombol Tambah -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-5">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-package text-5xl md:text-6xl"></i>
                    Manajemen Produk
                </h3>
                <a href="{{ route('admin.produk.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl flex items-center gap-3 shadow-lg transition text-lg font-medium">
                    <i class="ph ph-plus text-2xl"></i>
                    Tambah Produk
                </a>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <i class="ph ph-check-circle text-3xl"></i>
                    <span class="text-lg">{{ session('success') }}</span>
                </div>
            @endif

            <!-- TABEL PRODUK – SUPER NYAMAN DI TABLET -->
            <!-- TABEL PRODUK – SEMPURNA DI TABLET (768px – 1024px) -->
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                <tr>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Foto</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Kode</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Nama Produk</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Kategori</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Harga</th>
                    <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Stok</th>
                    <th class="py-4 px-3 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($produks as $p)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <!-- FOTO -->
                    <td class="py-4 px-3">
                        <img src="{{ $p->foto ? asset($p->foto) : 'https://via.placeholder.com/60/E5E7EB/9CA3AF?text=No+Image' }}"
                             alt="{{ $p->nama }}"
                             class="w-14 h-14 object-cover rounded-lg shadow border-2 border-gray-200">
                    </td>

                    <!-- KODE -->
                    <td class="py-4 px-3">
                        <span class="font-mono text-sm font-bold text-gray-700">{{ $p->kode }}</span>
                    </td>

                    <!-- NAMA PRODUK (paling penting, dikasih ruang lebih) -->
                    <td class="py-4 px-3 max-w-xs">
                        <div class="font-semibold text-gray-900 text-base line-clamp-2">{{ $p->nama }}</div>
                    </td>

                    <!-- KATEGORI -->
                    <td class="py-4 px-3 text-gray-600 text-sm">
                        {{ $p->category?->nama ?? '-' }}
                    </td>

                    <!-- HARGA -->
                    <td class="py-4 px-3 font-bold text-green-600 text-base whitespace-nowrap">
                        Rp {{ number_format($p->harga_jual) }}
                    </td>

                    <!-- STOK -->
                    <td class="py-4 px-3">
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md {{ $p->stok <= 10 ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                            {{ $p->stok }}
                        </span>
                    </td>

                    <!-- AKSI – Tombol pas untuk jari di tablet -->
                    <td class="py-4 px-3">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.produk.edit', $p) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium px-5 py-3 rounded-lg shadow transition flex items-center gap-1.5 min-w-28 justify-center">
                                <i class="ph ph-pencil-simple text-lg"></i>
                                Edit
                            </a>
                            <form action="{{ route('admin.produk.destroy', $p) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus {{ addslashes($p->nama) }}?')"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-5 py-3 rounded-lg shadow transition flex items-center gap-1.5 min-w-28 justify-center">
                                    <i class="ph ph-trash text-lg"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-20">
                        <div class="text-gray-400">
                            <i class="ph ph-package text-9xl mb-6 opacity-20"></i>
                            <p class="text-2xl font-medium">Belum ada produk</p>
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