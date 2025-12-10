<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - POS Admin</title>
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

    <!-- SIDEBAR (sama persis dengan dashboard & users) -->
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

        <!-- HEADER HAMBURGER (hanya mobile & tablet) -->
        <header class="fixed-header bg-white shadow-lg px-6 py-4 flex items-center justify-between md:hidden">
            <button id="menuBtn" class="text-3xl text-gray-800 hover:text-blue-600 transition">
                <i class="ph ph-list"></i>
            </button>
            <h1 class="text-xl font-bold text-blue-700">Tambah User</h1>
            <div class="w-10"></div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="main-content flex-1 p-6 md:p-8 lg:p-10">

            <!-- Judul Halaman -->
            <div class="mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-user-plus text-5xl md:text-6xl"></i>
                    Tambah User Baru
                </h3>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-10">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <!-- Flash Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <i class="ph ph-check-circle text-3xl"></i>
                            <span class="text-lg">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <i class="ph ph-x-circle text-3xl"></i>
                            <div>
                                <p class="font-bold">Terjadi kesalahan:</p>
                                <ul class="list-disc list-inside mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-user text-xl mr-2"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-envelope text-xl mr-2"></i> Email
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="contoh@domain.com" required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-lock text-xl mr-2"></i> Password
                            </label>
                            <input type="password" name="password"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-lock-key text-xl mr-2"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Ulangi password" required>
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-shield-checkered text-xl mr-2"></i> Role
                            </label>
                            <select name="role"
                                    class="w-full px-5 py-4 rounded-xl border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                    required>
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-3 text-lg">
                            <i class="ph ph-check-circle text-2xl"></i>
                            Simpan User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition text-center">
                            <i class="ph ph-arrow-left text-2xl"></i>
                            Kembali
                        </a>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT HAMBURGER MENU -->
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
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