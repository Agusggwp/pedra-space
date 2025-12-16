<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            <!-- Judul + Tombol Tambah -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-5 mt-20">
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
<div class="bg-white rounded-2xl shadow-2xl">
    <div class="relative">
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
                        <div class="relative flex justify-center" style="z-index:60;">
                            <button type="button" class="text-gray-400 hover:text-gray-600 transition p-2 rounded-lg hover:bg-gray-100" onclick="toggleMenu(event, {{ $p->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="5" r="1.5"/>
                                    <circle cx="12" cy="12" r="1.5"/>
                                    <circle cx="12" cy="19" r="1.5"/>
                                </svg>
                            </button>
                            <div id="menu-{{ $p->id }}" class="hidden absolute z-[9999] w-44 bg-white border border-gray-200 rounded-lg shadow-xl py-2 right-0 top-10">
                                <a href="{{ route('admin.produk.show', $p) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('admin.produk.edit', $p) }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.produk.destroy', $p) }}" method="POST" class="delete-produk-form" data-produk-name="{{ $p->nama }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <rect x="3" y="6" width="18" height="14" rx="2"/>
                                            <path d="M8 6V4a4 4 0 0 1 8 0v2"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
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

<script>
// Dropdown menu logic
function toggleMenu(event, produkId) {
    event.stopPropagation();
    const button = event.currentTarget;
    const menu = document.getElementById('menu-' + produkId);
    // Close all other menus
    document.querySelectorAll('[id^="menu-"]').forEach(m => {
        if (m.id !== 'menu-' + produkId) {
            m.classList.add('hidden');
        }
    });
    // Toggle current menu
    menu.classList.toggle('hidden');
}
// Close menus when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button[onclick^="toggleMenu"]') && !event.target.closest('[id^="menu-"]')) {
        document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
    }
});
// Delete Produk with SweetAlert
document.querySelectorAll('.delete-produk-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const produkName = form.getAttribute('data-produk-name');
        Swal.fire({
            icon: 'warning',
            title: 'Hapus Produk',
            html: `<p class="text-gray-700">Apakah Anda yakin ingin menghapus produk <strong class="text-red-600">"${produkName}"</strong>?</p><p class="text-sm text-gray-500 mt-2">Aksi ini tidak dapat dibatalkan!</p>`,
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                return new Promise((resolve) => {
                    Swal.fire({
                        title: 'Menghapus...',
                        html: 'Mohon tunggu, sedang menghapus produk...',
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                            setTimeout(() => {
                                form.submit();
                            }, 500);
                        }
                    });
                });
            }
        });
    });
});
</script>

</body>
</html>