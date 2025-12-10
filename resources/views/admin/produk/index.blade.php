<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS Admin</title>
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
        <main class="flex-1 p-6 md:p-8 lg:p-10 bg-gray-50">

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
                        <img src="{{ $p->foto ? asset('storage/' . $p->foto) : 'https://via.placeholder.com/60/E5E7EB/9CA3AF?text=No+Image' }}"
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

</body>
</html>