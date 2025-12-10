<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - POS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50">

<div class="flex min-h-screen">

    <!-- SIDEBAR COMPONENT -->
    @include('components.sidebar')

    <!-- KONTEN UTAMA -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen overflow-hidden">

        <!-- TOPBAR COMPONENT -->
        @include('components.topbar')

        <!-- MAIN CONTENT -->
        <main class="flex-1 p-6 md:p-8 lg:p-10 overflow-y-auto bg-gray-50">

            <!-- Judul Halaman -->
            <div class="mb-8 mt-20">
                <h3 class="text-3xl md:text-4xl font-bold text-blue-700 flex items-center gap-4">
                    <i class="ph ph-user-gear text-5xl md:text-6xl"></i>
                    Edit User: <span class="text-gray-800">{{ $user->name }}</span>
                </h3>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-10">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Success / Error Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <i class="ph ph-check-circle text-3xl"></i>
                            <span class="text-lg">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-xl mb-8 flex items-center gap-4 shadow">
                            <i class="ph ph-x-circle text-3xl"></i>
                            <div>
                                <p class="font-bold mb-2">Ada kesalahan input:</p>
                                <ul class="list-disc list-inside space-y-1">
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
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-envelope text-xl mr-2"></i> Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Baru (opsional) -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-lock text-xl mr-2"></i> Password Baru
                                <span class="text-gray-500 text-sm">(kosongkan jika tidak diganti)</span>
                            </label>
                            <input type="password" name="password"
                                   class="w-full px-5 py-4 rounded-xl border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-lock-key text-xl mr-2"></i> Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-5 py-4 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                   placeholder="Ulangi password baru">
                        </div>

                        <!-- Role -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">
                                <i class="ph ph-shield-checkered text-xl mr-2"></i> Role
                            </label>
                            <select name="role"
                                    class="w-full px-5 py-4 rounded-xl border {{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
                                    required>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-2"><i class="ph ph-warning"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-105 flex items-center justify-center gap-3 text-lg">
                            <i class="ph ph-check-circle text-2xl"></i>
                            Update User
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-8 rounded-xl shadow-lg transition text-center flex items-center justify-center gap-3">
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