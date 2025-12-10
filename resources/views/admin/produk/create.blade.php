<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - POS Admin</title>
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

        <!-- HEADER MOBILE -->
        <header class="fixed-header bg-white shadow-lg px-6 py-4 flex items-center justify-between md:hidden">
            <button id="menuBtn" class="text-3xl text-gray-800 hover:text-blue-600 transition">
                <i class="ph ph-list"></i>
            </button>
            <h1 class="text-xl font-bold text-blue-700">Tambah Produk</h1>
            <div class="w-10"></div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content flex-1 p-6 md:p-8 lg:p-10">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-plus-circle text-6xl"></i>
                    Tambah Produk Baru
                </h3>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-10">
                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Error Summary -->
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <i class="ph ph-x-circle text-3xl"></i>
                            <div>
                                <p class="font-bold mb-2">Ada kesalahan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Kode Produk -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-barcode text-xl mr-2"></i> Kode Produk
                            </label>
                            <input type="text" name="kode" value="{{ old('kode') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('kode') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Contoh: BRG001" required>
                            @error('kode')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Nama Produk -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-tag text-xl mr-2"></i> Nama Produk
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('nama') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Masukkan nama produk" required>
                            @error('nama')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-list-bullets text-xl mr-2"></i> Kategori
                            </label>
                            <select name="category_id"
                                    class="w-full px-5 py-4 rounded-xl border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Harga Beli -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-currency-dollar text-xl mr-2"></i> Harga Beli
                            </label>
                            <input type="number" name="harga_beli" value="{{ old('harga_beli') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('harga_beli') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="0" required>
                            @error('harga_beli')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Harga Jual -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-shopping-cart text-xl mr-2"></i> Harga Jual
                            </label>
                            <input type="number" name="harga_jual" value="{{ old('harga_jual') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('harga_jual') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="0" required>
                            @error('harga_jual')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Stok Awal -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-cubes text-xl mr-2"></i> Stok Awal
                            </label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('stok') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   min="0" required>
                            @error('stok')<p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>@enderror
                        </div>

                        <!-- Foto Produk + Preview Real-time -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-700 font-medium mb-3">
                                <i class="ph ph-camera text-xl mr-2"></i> Foto Produk <span class="text-gray-500 text-sm">(opsional)</span>
                            </label>

                            <!-- Preview Foto -->
                            <div class="mb-4">
                                <img id="preview" src="https://via.placeholder.com/400x300/E5E7EB/9CA3AF?text=Preview+Foto"
                                     alt="Preview foto produk"
                                     class="w-80 h-60 object-cover rounded-xl shadow-lg border-4 border-gray-200">
                            </div>

                            <input type="file" name="foto" accept="image/*" id="foto"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('foto')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-3 text-lg">
                            <i class="ph ph-check-circle text-2xl"></i>
                            Simpan Produk
                        </button>
                        <a href="{{ route('admin.produk.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-10 rounded-xl shadow-lg transition text-center flex items-center justify-center gap-3">
                            <i class="ph ph-arrow-left text-2xl"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT: Hamburger Menu + Preview Foto -->
<script>
    // Hamburger Menu
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

    // Preview Foto Saat Upload
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = 'https://via.placeholder.com/400x300/E5E7EB/9CA3AF?text=Preview+Foto';
        }
    });
</script>

</body>
</html>