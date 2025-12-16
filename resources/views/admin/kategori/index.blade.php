<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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
                    <i class="ph ph-circles-three text-5xl md:text-6xl"></i>
                    Manajemen Kategori
                </h3>
                <a href="{{ route('admin.category.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl flex items-center gap-3 shadow-lg transition text-lg font-medium">
                    <i class="ph ph-plus text-2xl"></i>
                    Tambah Kategori
                </a>
            </div>

            <!-- Flash Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <i class="ph ph-check-circle text-3xl"></i>
                    <span class="text-lg">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                    <i class="ph ph-warning-circle text-3xl"></i>
                    <span class="text-lg">{{ session('error') }}</span>
                </div>
            @endif

            <!-- TABEL KATEGORI -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-800 to-gray-900 text-white">
                            <tr>
                                <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">No</th>
                                <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Nama Kategori</th>
                                <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Jumlah Produk</th>
                                <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Jumlah Menu</th>
                                <th class="py-4 px-3 text-left text-xs font-bold uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="py-4 px-3 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="py-4 px-3 text-sm font-bold text-gray-700">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</td>
                                <td class="py-4 px-3 max-w-xs">
                                    <div class="font-semibold text-gray-900 text-base">{{ $category->nama }}</div>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md bg-green-600 text-white">
                                        {{ $category->produks()->count() }} produk
                                    </span>
                                </td>
                                <td class="py-4 px-3">
                                    <span class="inline-block px-4 py-2 rounded-full text-sm font-bold shadow-md bg-blue-600 text-white">
                                        {{ $category->menus()->count() }} menu
                                    </span>
                                </td>
                                <td class="py-4 px-3 text-gray-600 text-sm">
                                    {{ $category->created_at ? $category->created_at->format('d M Y') : '-' }}
                                </td>
                                <td class="py-4 px-3 relative">
                                    <div class="flex justify-center">
                                        <!-- Dropdown Button -->
                                        <button type="button" 
                                                class="dropdown-trigger bg-gray-100 hover:bg-gray-200 text-gray-700 p-2 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                data-dropdown-id="dropdown-{{ $category->id }}">
                                            <i class="ph ph-dots-three-vertical text-2xl"></i>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div id="dropdown-{{ $category->id }}" 
                                             class="dropdown-menu hidden fixed w-48 bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden"
                                             style="z-index: 9999;">
                                            <a href="{{ route('admin.category.show', $category) }}"
                                               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition duration-150">
                                                <i class="ph ph-eye text-lg"></i>
                                                <span class="font-medium">Lihat Detail</span>
                                            </a>
                                            <a href="{{ route('admin.category.edit', $category) }}"
                                               class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition duration-150 border-t border-gray-100">
                                                <i class="ph ph-pencil-simple text-lg"></i>
                                                <span class="font-medium">Edit Kategori</span>
                                            </a>
                                            <button type="button"
                                                    class="delete-category-btn w-full flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition duration-150 border-t border-gray-100 text-left"
                                                    data-category-id="{{ $category->id }}"
                                                    data-category-name="{{ $category->nama }}"
                                                    data-form-action="{{ route('admin.category.destroy', $category) }}">
                                                <i class="ph ph-trash text-lg"></i>
                                                <span class="font-medium">Hapus Kategori</span>
                                            </button>
                                        </div>

                                        <!-- Hidden Form for Delete -->
                                        <form id="delete-form-{{ $category->id }}" 
                                              action="{{ route('admin.category.destroy', $category) }}" 
                                              method="POST" 
                                              class="hidden">
                                            @csrf 
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-20">
                                    <div class="text-gray-400">
                                        <i class="ph ph-circles-three text-9xl mb-6 opacity-20"></i>
                                        <p class="text-2xl font-medium">Belum ada kategori</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PAGINATION -->
            @if($categories->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $categories->links() }}
            </div>
            @endif

        </main>
    </div>
</div>

<script>
// Toggle Dropdown Menu
document.addEventListener('DOMContentLoaded', function() {
    // Get all dropdown triggers
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdownId = this.getAttribute('data-dropdown-id');
            const dropdown = document.getElementById(dropdownId);
            
            // Close all other dropdowns
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu.id !== dropdownId) {
                    menu.classList.add('hidden');
                }
            });
            
            // Calculate position
            const rect = this.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + window.scrollY + 5) + 'px';
            dropdown.style.left = (rect.left + window.scrollX - 192 + rect.width) + 'px'; // 192px = w-48 (12rem)
            
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown-trigger') && !e.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.add('hidden');
            });
        }
    });
    
    // Delete Category with SweetAlert
    document.querySelectorAll('.delete-category-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const categoryId = this.getAttribute('data-category-id');
            const categoryName = this.getAttribute('data-category-name');
            const formAction = this.getAttribute('data-form-action');
            
            // Close dropdown
            this.closest('.dropdown-menu').classList.add('hidden');
            
            Swal.fire({
                icon: 'warning',
                title: 'Hapus Kategori',
                html: `<p class="text-gray-700">Apakah Anda yakin ingin menghapus kategori <strong class="text-red-600">"${categoryName}"</strong>?</p><p class="text-sm text-gray-500 mt-2">Aksi ini tidak dapat dibatalkan!</p>`,
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    return new Promise((resolve) => {
                        Swal.fire({
                            title: 'Menghapus...',
                            html: 'Mohon tunggu, sedang menghapus kategori...',
                            icon: 'info',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                                setTimeout(() => {
                                    document.getElementById(`delete-form-${categoryId}`).submit();
                                }, 500);
                            }
                        });
                    });
                }
            });
        });
    });
});
</script>

</body>
</html>